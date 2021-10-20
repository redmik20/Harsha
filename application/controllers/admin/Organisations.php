<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Organisations extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $list_Page = 'admin/master/list_organisations';
	public $add_Page =  'admin/master/add_organisations';	
	public $edit_Page = 'admin/master/edit_organisations';
	
	public function __construct()
	{
	parent::__construct();
	$this->load->model('admin/Organisations_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	}

	public function index(){

		$this->setHeaderFooter($this->list_Page,$this->data);
	}

	public function add(){
		$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array());
		$this->setHeaderFooter($this->add_Page,$this->data);
	}

	public function edit($id){
		$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array());
		 $this->data['org']=$this->common_model->get_table('organisations',array('status'=>'Active'),array(),'organisation_name','asc');
		 $this->data['record']=$this->my_model->get_record($id);		 
		 $this->setHeaderFooter($this->edit_Page,$this->data);
	}

	public function view(){

    	$this->setHeaderFooter($this->add_Page,$this->data);
	}

	public function all_organisation(){

        $center = $this->my_model->all_organisation($_POST);

        $result_count=$this->my_model->all_organisation($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($center) ),

            "data"  => $center);  

        echo json_encode($json_data);
	}

	public function update_organisation()
	{

		$id=$this->input->post('id');
		
		$data=array(
						'state_id'=> $this->input->post('state_id'),
						'organisation_name'=> $this->input->post('organisation_name')
					);
			//echo '<pre>';print_r($data);exit;
		if($id == "")
		{
			$data['created_on'] = date('Y-m-d H:i:s');
			$data['created_by'] = $this->session->userdata('user_id');
			$result=$this->my_model->update_organisation($data,$id);
			if($result){
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/organisations/add', 'refresh');		
			  }else{
			$this->session->set_flashdata('error', 'Record added Failed!.');
			redirect('admin/organisations/add', 'refresh');	
			  }	
		}else{
			
			$data['modified_on'] = date('Y-m-d H:i:s');
			$data['modified_by'] = $this->session->userdata('user_id');
			$result1=$this->my_model->update_organisation($data, $id);
			if($result1){
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/organisations/edit/'.$id, 'refresh');
			}else{
			$this->session->set_flashdata('success', 'Record Updated Failed!.');
			redirect('admin/organisations/edit/'.$id, 'refresh');
			}
		}		

	}

	public function change_organisation_status($user_id, $status)
	{
		if($this->my_model->change_organisation_status($user_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/organisations', 'refresh');
	}

	public function download_organisations(){
       $query = $this->my_model->download_organisations();
       //echo $query;exit;
       $this->load->helper('csv');
       query_to_csv($query, TRUE, "all_organisations".'-'.date("m-d-Y H:i:s").'.csv');
    }


	/*-----------start setting header and footer --------------*/

	public function setHeaderFooter($view, $data)
	{	

		$this->load->view($this->header_page, $data);
		$this->load->view($this->leftMenu, $data);
		$data['message']=$this->load->view('admin/includes/message',$data,TRUE);
		$this->load->view($view, $data);
		$this->load->view($this->footer_Page);
	}
  /*----------- stop setting header and footer --------------*/

}


?>