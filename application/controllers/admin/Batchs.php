<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Batchs extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $list_Page = 'admin/master/list_batch';
	public $add_Page =  'admin/master/add_batch';
	public $view_Page = 'admin/master/batch_details';
	public $edit_Page = 'admin/master/edit_batch';




	public function __construct()
	{
	parent::__construct();
	$this->load->model('admin/Batchs_model','my_model');
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
		// $this->data['courses']=$this->common_model->get_table('courses',array('status'=>'Active'),array(),'order','asc');
		 //echo '<pre>';print_r($this->data['courses']);exit;
		 $this->setHeaderFooter($this->add_Page,$this->data);
	}

	public function edit($id){
		 //$this->data['courses']=$this->common_model->get_table('courses',array('status'=>'Active'),array(),'order','asc');
		 $this->data['record']=$this->my_model->get_record($id);

		 $state_id=$this->data['record']['state_id'];
		 $organisation_id=$this->data['record']['organisation_id'];
		 $center_id=$this->data['record']['center_id'];
		 $this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');
		 $this->data['organisations']=$this->common_model->get_table('organisations',array('state_id'=>$state_id,'status'=>'Active'),array(),'id','desc');
		 $this->data['centers']=$this->common_model->get_table('centers',array('state_id'=>$state_id,'organisation_id'=>$organisation_id,'status'=>'Active'),array(),'id','desc');
		 $this->data['courses']=$this->common_model->get_table('courses',array('state_id'=>$state_id,'organisation_id'=>$organisation_id,'center_id'=>$center_id,'course_type'=>'admin','status'=>'Active'),array(),'id','desc');

		 $this->setHeaderFooter($this->edit_Page,$this->data);
	}

	public function view(){

		 $this->setHeaderFooter($this->add_Page,$this->data);
	}

	public function all_batchs(){

        $records = $this->my_model->all_batchs($_POST);

        $result_count=$this->my_model->all_batchs($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($records) ),

            "data"  => $records);  

        echo json_encode($json_data);
	}

	public function update_batchs()
	{

		//$role_user_id=$this->session->userdata('user_id');
		
		
		$batch_id=$this->input->post('batch_id');
		
		$data=array(
						'state_id'=> $this->input->post('state_id'),
						'organisation_id'=> $this->input->post('organisation_id'),
						'center_id'=> $this->input->post('center_id'),
						'course_id'=> $this->input->post('course_id'),
						'batch_name'=> $this->input->post('batch_name'),
						'student_code'=> $this->input->post('student_code'),
						'order'=> $this->input->post('order'),
						'start_date'=> $this->input->post('start_date'),
						'end_date'=> $this->input->post('end_date'),
					);
			//echo '<pre>';print_r($data);exit;
		if($batch_id == "")
		{
			$data['created_on'] = date('Y-m-d H:i:s');
			$data['created_by'] = $this->session->userdata('user_id');
			$result=$this->my_model->insert_batch($data);
			if($result){
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/batchs/add', 'refresh');		
			  }else{
			$this->session->set_flashdata('error', 'Record added Failed!.');
			redirect('admin/batchs/add', 'refresh');	
			  }	
		}else{
			
			$data['modified_on'] = date('Y-m-d H:i:s');
			$data['modified_by'] = $this->session->userdata('user_id');
			$result1=$this->my_model->update_batch($data, $batch_id);
			if($result1){
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/batchs/edit/'.$batch_id, 'refresh');
			}else{
			$this->session->set_flashdata('success', 'Record Updated Failed!.');
			redirect('admin/batchs/edit/'.$batch_id, 'refresh');
			}
		}	
		

	}

	public function change_batch_status($user_id, $status)
	{
		if($this->my_model->change_batch_status($user_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/batchs', 'refresh');
	}

	public function download_students($batch_id){
		$query = $this->my_model->students_excel_info_with_batch($batch_id);
		$this->load->helper('csv');
		query_to_csv($query, TRUE, "students-data".'-'.date("m-d-Y H:i:s").'.csv');

	}

	public function download_batchs(){
       $query = $this->my_model->download_batchs();
       //echo $query;exit;
       $this->load->helper('csv');
       query_to_csv($query, TRUE, "all_batchs".'-'.date("m-d-Y H:i:s").'.csv');
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