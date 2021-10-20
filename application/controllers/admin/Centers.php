<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Centers extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $list_Page = 'admin/master/list_centers';
	public $add_Page =  'admin/master/add_centers';	
	public $edit_Page = 'admin/master/edit_centers';
	
	public function __construct()
	{
	parent::__construct();
	$this->load->model('admin/Centers_model','my_model');
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

		$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');
		$this->data['organisations']=$this->common_model->get_table('organisations',array('status' => 'Active'),array());
		$this->setHeaderFooter($this->add_Page,$this->data);
	}

	public function edit($id){
		
		 $this->data['record']=$this->my_model->get_record($id);
		 $this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');
		 $this->data['organisations']=$this->common_model->get_table('organisations',array('status' => 'Active'),array());
		 $this->setHeaderFooter($this->edit_Page,$this->data);
	}

	public function view(){

    	$this->setHeaderFooter($this->add_Page,$this->data);
	}

	public function all_centers(){

        $center = $this->my_model->all_centers($_POST);

        $result_count=$this->my_model->all_centers($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($center) ),

            "data"  => $center);  

        echo json_encode($json_data);
	}

	public function update_centers()
	{
		$role_user_id=1;
		$user_type=1;
		$id=$this->input->post('id');
		
		$data=array(
						
						'organisation_id'=> $this->input->post('organisation_id'),
						'state_id'=> $this->input->post('state_id'),
						'center' => $this->input->post('center')
					);
			//echo '<pre>';print_r($data);exit;
		if($id == "")
		{
			$data['created_on'] = date('Y-m-d H:i:s');
			$data['created_by'] = $this->session->userdata('user_id');
			$result=$this->my_model->update_record($data,$id);
			if($result){
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/centers/add', 'refresh');		
			  }else{
			$this->session->set_flashdata('error', 'Record added Failed!.');
			redirect('admin/centers/add', 'refresh');	
			  }	
		}else{
			
			$data['modified_on'] = date('Y-m-d H:i:s');
			$data['modified_by'] = $this->session->userdata('user_id');
			$result1=$this->my_model->update_record($data, $id);
			if($result1){
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/centers/edit/'.$id, 'refresh');
			}else{
			$this->session->set_flashdata('success', 'Record Updated Failed!.');
			redirect('admin/centers/edit/'.$id, 'refresh');
			}
		}		

	}

	public function change_center_status($user_id, $status)
	{
		if($this->my_model->change_center_status($user_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/centers', 'refresh');
	}

	public function download_centers(){
       $query = $this->my_model->download_centers();
       //echo $query;exit;
       $this->load->helper('csv');
       query_to_csv($query, TRUE, "all_centers".'-'.date("m-d-Y H:i:s").'.csv');
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