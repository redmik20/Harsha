<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'libraries/RESTful/REST_Controller.php';
class Ws extends REST_Controller {
	
	protected $client_request = NULL;

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		error_reporting(0);
		set_time_limit(0);
		ini_set('memory_limit', '-1');

		$this->load->helper('app/ws_helper');
		$this->load->model('app/ws_model','ws_model');
		$this->load->model('common_model','common_model');
		
		$this->client_request = new stdClass();
		$this->client_request = json_decode(file_get_contents('php://input', true));
		$this->client_request = json_decode(json_encode($this->client_request), true);
		//_prepare_basic_auth($this->client_request);
	}

	/*-------------------- User -----------------------*/

	
   
   


	/*
       Student Login 
	*/
   
   function student_login_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		if(!$student_id)
		{
			$response = array('status' => false, 'message' => 'Student ID is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		if(!$password)
		{
			$response = array('status' => false, 'message' => 'Password is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

	if($student_id != 'STDN258'){

		if($device_id !=''){
			$device_token=$this->common_model->get_table_row('students',array('student_mobile'=>$student_id),array('device_id'));
			$db_device_id=$device_token['device_id'];
			if($db_device_id != ''){
				//echo '123';exit;
              // $this->ws_model->check_device_token($student_id,$device_id);=
				if($device_id != $db_device_id){
					$response = array('status' => false, 'message' => 'Dear user, You already logged in another device. Please contact our staff +919381915140','student_id'=>$student_id);
					TrackResponse($user_input, $response);		
					$this->response($response);
				}
        	  }
           // $this->ws_model->updateUserDeviceId($student_id,$device_id);
        }
    }

        if($android_device_id !=''){
			$device_token=$this->common_model->get_table_row('students',array('student_mobile'=>$student_id),array('android_device_id'));
			$db_device_id=$device_token['android_device_id'];
			if($db_device_id != ''){
              // $this->ws_model->check_device_token($student_id,$device_id);=
				if($android_device_id != $db_device_id){
					$response = array('status' => false, 'message' => 'Dear user, You already logged in another device. Please contact our staff +919381915140','student_id'=>$student_id);
					TrackResponse($user_input, $response);		
					$this->response($response);
				}
        	  }
           // $this->ws_model->updateUserDeviceId($student_id,$device_id);
        }
		$user=$this->ws_model->check_login($student_id,$password);
	
		if(!empty($user)){

		$plato_user=$this->ws_model->get_userID($user['student_dynamic_id']);
		$user['id']=$plato_user['id'];
		$response = array('status' => true, 'message' => 'User login successfully!', 'response' => $user);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'User login Failed!', 'response' => new stdClass(),'student_id'=>$student_id);
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}

	/*
       Student ID Card Details 
	*/
   
   function student_card_details_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		if(!$student_id)
		{
			$response = array('status' => false, 'message' => 'Student ID is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$user=$this->ws_model->student_card_details($student_id);

		$due_amount=$this->common_model->get_table_row('student_payment_details',array('student_dy_id'=>$student_id),array('due_amount','due_date'));
		if($due_amount['due_amount'] != 0){
			$user['due_amount']=$due_amount['due_amount'];
			//$user['due_amount_status']= 'yes'; due is over
		}else{
			$user['due_amount']=0;
			//$user['due_amount_status']= 'no'; due is not over
		}
		$due_date=$due_amount['due_date'];
		$today=date('Y-m-d');
	  	$due_date1 = strtotime($due_date);
	  	$today1 = strtotime($today);
	  
		// Compare the timestamp date 
	  	if($user['due_amount'] != 0){
		if($due_date1 >= $today1){
		    $result="feedone";
		    //echo "feedone";exit;
		    $user['due_amount_status']= 'no';
		    $user['due_amount']= '0';
		  }else{
		  	$result="duedateexpired";
		  	//echo "duedateexpired";exit;
		  	$user['due_amount_status']= 'yes';
		  }
		}else{
			$user['due_amount_status']= 'no';
			$user['due_amount']= '0';
		}


		$user['due_date']=$due_amount['due_date'];


		$scaned_date=date('Y-m-d');
		$attendance_status=$this->common_model->get_table_row('event_attendence',array('student_dy_id'=>$student_id,'scaned_date'=>$scaned_date),array('id,event_dy_id'));
		//echo '<pre>';print_r($attendance_status);exit;
		
		if(!empty($attendance_status)){
			$user['attendance_status']= true;
			$a_info=$this->common_model->get_table_row('events',array('event_unique_id'=>$attendance_status['event_dy_id']),array());
			$user['attendance_info']=$a_info['event_unique_id'].'##'.$a_info['event_name'].'##'.$a_info['start_date'].'##'.$a_info['end_date'];
		}else{
			$user['attendance_status']= false;
			$user['attendance_info']='';
		}
		if(!empty($user)){
			
		$response = array('status' => true, 'message' => 'Student details Fetched successfully!', 'response' => $user);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'Student details not Fetched!', 'response' => array());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}

	/*
       Student Change Password 
	*/
   
   function student_change_password_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		if(!$student_id)
		{
			$response = array('status' => false, 'message' => 'Student ID is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		if(!$old_password)
		{
			$response = array('status' => false, 'message' => 'Old Password is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		if(!$new_password)
		{
			$response = array('status' => false, 'message' => 'New Password is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$check_password=$this->ws_model->student_check_password($student_id,$old_password);

		if(empty($check_password)){
			$response = array('status' => true, 'message' => 'Password does not match with Old records!', 'response' => false);
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$user=$this->ws_model->student_change_password($student_id,$new_password);
	
		if(!empty($user)){
			
		$response = array('status' => true, 'message' => 'Student password Changed successfully!', 'response' => $user);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'Student details not Fetched!', 'response' => array());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}

	/*
       Student Forgot Password 
	*/
   
   function student_forgot_password_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		if(!$student_id)
		{
			$response = array('status' => false, 'message' => 'Student ID is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		
		if(!$new_password)
		{
			$response = array('status' => false, 'message' => 'New Password is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$user=$this->ws_model->student_change_password($student_id,$new_password);
	
		if(!empty($user)){
			
		$response = array('status' => true, 'message' => 'Student password Changed successfully!', 'response' => $user);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'Student password Changed failed!!', 'response' => array());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}

	/*
       Student Profile Details 
	*/
   
   function student_profile_details_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		if(!$student_id)
		{
			$response = array('status' => false, 'message' => 'Student ID is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		

		$user=$this->ws_model->student_profile_details($student_id);
	
		if(!empty($user)){
			
		$response = array('status' => true, 'message' => 'Student Details successfully!', 'response' => $user);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'Student Details not Fetched!', 'response' => array());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}

	/*
       States API 
	*/
   
   function states_get()
	{

		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		$states=$this->ws_model->get_states();
	
		if(!empty($states)){
			
		$response = array('status' => true, 'message' => 'States Fetching successfully!', 'response' => $states);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'States Details not Fetched!', 'response' => array());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}


	/*
       Organisations API 
	*/
   
   function organisations_post()
	{
		
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		if(!$state_id)
		{
			$response = array('status' => false, 'message' => 'state ID is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$organisations=$this->ws_model->get_organisations($state_id);
	
		if(!empty($organisations)){
			
		$response = array('status' => true, 'message' => 'Organisations Fetching successfully!', 'response' => $organisations);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'Organisations Details not Fetched!', 'response' => array());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}


	/*
       Centers API 
	*/

	function centers_post()
	{
		
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		if(!$state_id)
		{
			$response = array('status' => false, 'message' => 'state ID is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		if(!$organisation_id)
		{
			$response = array('status' => false, 'message' => 'Organisation ID is required', 'response' => '');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$centers=$this->ws_model->get_centers($state_id,$organisation_id);
	
		if(!empty($centers)){
			
		$response = array('status' => true, 'message' => 'Centers Fetching successfully!', 'response' => $centers);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'Centers Details not Fetched!', 'response' => array());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}


	/*
       Courses API 
	*/

	function courses_post()
	{
		
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'state_id' => 'State ID',
            'organisation_id' => 'Organisation ID',
            'center_id' => 'Center ID'
        );
        foreach ($required_params as $key => $value)
        {
            if (!$user_input[$key])
            {
                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );
                TrackResponse($user_input, $response);
                $this->response($response);
            }
        }

		$courses=$this->ws_model->get_courses($state_id,$organisation_id,$center_id);
	
		if(!empty($courses)){
			
		$response = array('status' => true, 'message' => 'Courses Fetching successfully!', 'response' => $courses);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'Courses Details not Fetched!', 'response' => array());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}

	/*
       Batchs API 
	*/

	function batchs_post()
	{
		
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'state_id' => 'State ID',
            'organisation_id' => 'Organisation ID',
            'center_id' => 'Center ID',
            'course_id' => 'Course ID'
        );
        foreach ($required_params as $key => $value)
        {
            if (!$user_input[$key])
            {
                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );
                TrackResponse($user_input, $response);
                $this->response($response);
            }
        }

		$batchs=$this->ws_model->get_batchs($state_id,$organisation_id,$center_id,$course_id);
	
		if(!empty($batchs)){
			
		$response = array('status' => true, 'message' => 'Courses Fetching successfully!', 'response' => $batchs);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'Courses Details not Fetched!', 'response' => array());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}

	/*
       Colleges API 
	*/

	function colleges_post()
	{
		
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'state_id' => 'State ID'
        );
        foreach ($required_params as $key => $value)
        {
            if (!$user_input[$key])
            {
                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );
                TrackResponse($user_input, $response);
                $this->response($response);
            }
        }

		$colleges=$this->ws_model->get_colleges($state_id);
	
		if(!empty($colleges)){
			
		$response = array('status' => true, 'message' => 'Colleges Fetching successfully!', 'response' => $colleges);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'Courses Details not Fetched!', 'response' => array());
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}

	/*
       Sent OTP to User API 
	*/

	function sentOTP_to_mobile_post()
	{
		
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'mobile_no' => 'Mobile No is Required'
        );

        foreach ($required_params as $key => $value)
        {
            if (!$user_input[$key])
            {
                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );
                TrackResponse($user_input, $response);
                $this->response($response);
            }
        }

       
		$otp = mt_rand(1000, 9999);

        $message='Dear Student, '.$otp.' is One time password (OTP) for DR Bhatia. Thank You -Bhatia';
	    SendSMS($mobile_no,$message);

		if(!empty($otp)){
		$this->ws_model->insert_otp($mobile_no,$otp);
		$response = array('status' => true, 'message' => 'OTP Fetching successfully!', 'response' => $otp);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'OTP not Fetched!', 'response' => '');
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}

	/*
       OTP Verification to User API 
	*/

	function OTP_verification_post()
	{
		
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'mobile_no' => 'Mobile No is Required',
            'otp' => 'OTP is Required',
        );

        foreach ($required_params as $key => $value)
        {
            if (!$user_input[$key])
            {
                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );
                TrackResponse($user_input, $response);
                $this->response($response);
            }
        }

       
		$result=$this->ws_model->OTP_verification($mobile_no,$otp);

		if(!empty($result)){
		$this->db->delete('mobile_otp_verification',array('student_mobile'=>$mobile_no));
		$response = array('status' => true, 'message' => 'OTP Verified successfully!', 'response' => true);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'OTP not Verified!', 'response' => false);
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}

	/*
       Payment Modes API 
	*/

	function paymentmodes_post()
	{
		
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'state_id' => 'State ID',
            'organisation_id' => 'Organisation ID',
            'center_id' => 'Center ID',
            'type'=>'Type'
        );

        foreach ($required_params as $key => $value)
        {
            if (!$user_input[$key])
            {
                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );
                TrackResponse($user_input, $response);
                $this->response($response);
            }
        }

       
		$result=$this->ws_model->get_payment_modes($state_id,$organisation_id,$center_id,$type);
		
		if(!empty($result)){
		
		$response = array('status' => true, 'message' => 'Data Fetched successfully!', 'response' => $result);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'Data not Fetched!', 'response' => '');
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
	}
	
	
	
    	
}
?>