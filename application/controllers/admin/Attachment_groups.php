<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Attachment_groups extends CI_Controller {


	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $list_Page = 'admin/master/list_attachment_groups';
	public $add_Page =  'admin/master/add_attachment_groups';
	public $edit_Page = 'admin/master/edit_attachment_groups';


	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Attachment_groups_model','my_model');
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

		 $this->data['attachments']=$this->common_model->get_table('attachments',array('status' => 'Active'),array());
		 $this->setHeaderFooter($this->add_Page,$this->data);
	}

	public function edit($id){

		 
		 $this->data['row']=$this->my_model->get_record($id);
		 $this->data['attachments']=$this->common_model->get_table('attachments',array('status' => 'Active'),array());

		 $this->setHeaderFooter($this->edit_Page,$this->data);
	}

	public function all_records(){

        $records = $this->my_model->all_records($_POST);

        $result_count=$this->my_model->all_records($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($records) ),

            "data"  => $records);  

        echo json_encode($json_data);
	}


	public function update_records()
	{


		$id=$this->input->post('id');
		$attachment_ids= implode(',',$this->input->post('attachment_ids'));
		
		$data=array(
						
						'attachment_group_name'=> $this->input->post('attachment_group_name'),
						'attachment_ids'=> $attachment_ids
				   );
			//echo '<pre>';print_r($data);exit;
		if($id == "")
		{
			$data['created_on'] = date('Y-m-d H:i:s');
			$data['created_by'] = $this->session->userdata('user_id');
			$result=$this->my_model->update_record($data,$id);
			if($result){
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/attachment_groups/add', 'refresh');		
			  }else{
			$this->session->set_flashdata('error', 'Record added Failed!.');
			redirect('admin/attachment_groups/add', 'refresh');	
			  }	
		}else{
			
			$data['modified_on'] = date('Y-m-d H:i:s');
			$data['modified_by'] = $this->session->userdata('user_id');
			$result1=$this->my_model->update_record($data, $id);
			if($result1){
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/attachment_groups/edit/'.$id, 'refresh');
			}else{
			$this->session->set_flashdata('error', 'Record Updated Failed!.');
			redirect('admin/attachment_groups/edit/'.$id, 'refresh');
			}
		}	
		

	}


	public function change_record_status($user_id, $status)
	{
		if($this->my_model->change_record_status($user_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/attachment_groups', 'refresh');
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