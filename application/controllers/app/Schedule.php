<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'libraries/RESTful/REST_Controller.php';
class Schedule extends REST_Controller {
	
	protected $client_request = NULL;

	function __construct()
	{
		parent::__construct();
		error_reporting(0);
		set_time_limit(0);
		ini_set('memory_limit', '-1');

		$this->load->helper('app/ws_helper');
		$this->load->model('app/Schedule_model','my_model');
		$this->load->model('common_model','common_model');
		
		$this->client_request = new stdClass();
		$this->client_request = json_decode(file_get_contents('php://input', true));
		$this->client_request = json_decode(json_encode($this->client_request), true);
		//_prepare_basic_auth($this->client_request);
		$this->checkToken();
	}


	public function start_attendence_post(){

		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		//echo '<pre>';print_r($student_id);exit;

		if(!$student_id)
		{
			$response = array('status' => false, 'message' => 'Student ID is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		if(!$event_id)
		{
			$response = array('status' => false, 'message' => 'Event Id is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$check_event_date=$this->my_model->checkEventDateValidation($event_id);

		if($check_event_date == 'expired'){
		$response = array('status' => false, 'message' => 'Attendence Not Captured! Event Date is Expired.!', 'response' => new stdClass());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}

		$batch_exists=$this->my_model->checkBatchValidation($student_id,$event_id);

		if(empty($batch_exists)){
		$response = array('status' => false, 'message' => 'Attendence Not Captured! Student Batch Not exits in this Event.!', 'response' => new stdClass());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}



		$batch_time_validation=$this->my_model->checkBatchTimeValidation($student_id);

		if($batch_time_validation == 'expired'){
		$response = array('status' => false, 'message' => 'Attendence Not Captured! Student Expired on this Batch.', 'response' => new stdClass());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}

		$check_due_amount=$this->my_model->checkDueamountAndDate($student_id);

		if($check_due_amount == 'duedateexpired'){
		$response = array('status' => false, 'message' => 'Attendence Not Captured! Student Due Date Expired on this Batch.', 'response' => new stdClass());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}

		$check_attendence=$this->my_model->check_attendence($student_id,$event_id);

		if(!empty($check_attendence)){
		$response = array('status' => false, 'message' => 'Attendence Not Captured! Your already Attended Today.', 'response' => new stdClass());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}

		$add_attendence=$this->my_model->add_attendence($student_id,$event_id);
		if($add_attendence){
		$response = array('status' => true, 'message' => 'Attendence Captured Successfully', 'response' => array('status'=>'success'));
		TrackResponse($user_input, $response);		
		$this->response($response);
		}


	}

	public function monthly_attendence_list_post(){

		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		//echo '<pre>';print_r($student_id);exit;

		if(!$student_id)
		{
			$response = array('status' => false, 'message' => 'Student ID is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$attendence=$this->my_model->get_monthly_attendence($student_id);

		if(!empty($attendence)){
		$response = array('status' => true, 'message' => 'Attendence List Fetched Successfully', 'response' => $attendence);
		TrackResponse($user_input, $response);		
		$this->response($response);
		}else{
		$response = array('status' => false, 'message' => 'Attendence List Not Fetched..!', 'response' => array());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}



	}

	public function event_list_post(){

		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		//echo '<pre>';print_r($student_id);exit;

		if(!$student_id)
		{
			$response = array('status' => false, 'message' => 'Student ID is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$stu_event_list=$this->my_model->get_student_event_list($student_id);

		if(!empty($stu_event_list)){
		$response = array('status' => true, 'message' => 'Event List Fetched Successfully', 'response' => $stu_event_list);
		TrackResponse($user_input, $response);		
		$this->response($response);
		}else{
		$response = array('status' => false, 'message' => 'Event List Not Fetched..!', 'response' => array());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}


	public function schedule_list_post(){

		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		//echo '<pre>';print_r($student_id);exit;

		if(!$student_id)
		{
			$response = array('status' => false, 'message' => 'Student ID is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$stu_schedule_list=$this->my_model->get_student_schedule_list($student_id);

		if(!empty($stu_schedule_list)){
		$response = array('status' => true, 'message' => 'Schedule List Fetched Successfully', 'response' => $stu_schedule_list);
		TrackResponse($user_input, $response);		
		$this->response($response);
		}else{
		$response = array('status' => false, 'message' => 'Schedule List Not Fetched..!', 'response' => array());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}

	public function current_month_schedule_post(){

		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		//echo '<pre>';print_r($student_id);exit;

		if(!$student_id)
		{
			$response = array('status' => false, 'message' => 'Student ID is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$current_month_schedule=$this->my_model->current_month_schedule($student_id);

		if(!empty($current_month_schedule)){
		$response = array('status' => true, 'message' => 'Current Month Schedule Fetched Successfully', 'response' => $current_month_schedule,'current_month'=>date("F", strtotime('m')));
		
		}else{
		$response = array('status' => false, 'message' => 'Current Month Schedule Not Fetched..!', 'response' => array(),'current_month'=>'');
		
		}
		TrackResponse($user_input, $response);		
		$this->response($response);
	}



	/*--------------------Check Token -----------------------*/
	public function checkToken(){

        foreach (getallheaders() as $name => $value) {
            $headers[$name] = $value;
        }

       $accessToken= $headers['access_token'];
       //$user_id= $headers['userId'];
	   //echo '<pre>';print_r($headers);exit;
       $result=$this->db->query("select * from tbl_access_tokens where access_token='$accessToken' and status='Active' ")->row_array();
      // echo $this->db->last_query();exit;
       if(empty($result)){
         $response = array(
                'status' => false,
                'message' => 'Token Failed',
                'error_code'=> '500',
                'response' => 'Request Failed 500 Error'
            );
            TrackResponse($user_input, $response);
            $this->response($response);
       }
       return ture;

    }

	
   
   


	
	

	
	
	
	
	
    	
}
?>