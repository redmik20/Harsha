<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Specialattendance extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $list_Page = 'admin/schedule/list_splattendance';
	public $ajax_attendenceInfo_Page =  'admin/schedule/ajax_attendence_info';
	public $attendence_list_Page= 'admin/schedule/list_attendence';	
	//public $edit_Page = 'admin/master/edit_centers';
	
	public function __construct()
	{
	parent::__construct();
	$this->load->model('admin/Specialattendance_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	}

	public function index(){

		$this->setHeaderFooter($this->attendence_list_Page,$this->data);
	}


	public function all_attendence_records(){

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

	public function take_attendence(){

		$this->data['centers']=$this->common_model->get_table('centers',array('status'=>'Active'),array());
		$this->setHeaderFooter($this->list_Page,$this->data);
	}

	public function view(){

    	$this->setHeaderFooter($this->add_Page,$this->data);
	}

	public function get_spl_attendence_info(){
		$center_id = $this->input->post('center_id');
		$event_id = $this->input->post('event_id');
		$mobile_number = $this->input->post('mobile_number');
		$this->data['student']=$this->common_model->get_table_row('students',array('student_mobile'=>$mobile_number),array());
		$this->data['event_data']=$this->common_model->get_table_row('events',array('id'=>$event_id),array());
		//echo '<pre>';print_r($this->data['student']);exit;
		$student_dy_id=$this->data['student']['student_dynamic_id'];
		$event_unique_id=$this->data['event_data']['event_unique_id'];
		$batch_exists=$this->my_model->checkBatchValidation($student_dy_id,$event_unique_id);
		if(empty($batch_exists)){
			 $this->data['student_batch_validation']='batch_not_exists';
		}else{
			$this->data['student_batch_validation']='batch_exists';
		}

		$this->data['batch_time_validation']=$this->my_model->checkBatchTimeValidation($student_dy_id);

		$this->data['check_due_amount']=$this->my_model->checkDueamountAndDate($student_dy_id);

		$this->data['check_attendence']=$this->my_model->check_attendence($student_dy_id,$event_unique_id);
		if(!empty($this->data['check_attendence'])){
			 $this->data['student_attendence_validation']='already_attentened';
			 $this->data['scaned_date']=$this->data['check_attendence']['scaned_date'];
			 $this->data['scaned_time']=$this->data['check_attendence']['scaned_time'];
		}else{
			$this->data['student_attendence_validation']='not_attentened';
			 $this->data['scaned_date']='00-00-0000';
			 $this->data['scaned_time']='00';
		}

		echo $this->load->view($this->ajax_attendenceInfo_Page,  $this->data, TRUE);
	}

	public function submitspl_attendence(){
		$student_id=$this->input->post('student_id');
		$event_id=$this->input->post('event_id');
		$reason=$this->input->post('reason');
		$insert_attendance=$this->my_model->add_attendence($student_id,$event_id,$reason);
		if($insert_attendance){
			$this->session->set_flashdata('success', 'Attendance Posted Successfully.');
			redirect('admin/specialattendance', 'refresh');	
		}else{
			$this->session->set_flashdata('error', 'Attendance Posted Failed!.');
			redirect('admin/specialattendance', 'refresh');	
		}
	}
	public function all_records(){

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