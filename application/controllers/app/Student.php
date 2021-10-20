<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'libraries/RESTful/REST_Controller.php';
class Student extends REST_Controller {
	
	protected $client_request = NULL;

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		error_reporting(0);
		set_time_limit(0);
		ini_set('memory_limit', '-1');

		$this->load->helper('app/ws_helper');
		$this->load->model('app/student_model','my_model');
		$this->load->model('common_model','common_model');
		
		$this->client_request = new stdClass();
		$this->client_request = json_decode(file_get_contents('php://input', true));
		$this->client_request = json_decode(json_encode($this->client_request), true);
		//_prepare_basic_auth($this->client_request);
		$this->checkToken();
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

	function registration_post(){
	$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'state_id' => 'State ID',
            'organisation_id' => 'Organisation ID',
            'center_id' => 'Center ID',
            'course_id'=>'Course Id',
            'batch_id'=>'batch_id',
            'student_image'=>'Student Image',
            'student_mobile'=>'Student Mobile',
            'student_name'=>'Student Name',
            'mbbbs_state_id'=>'MBBS State id',
            'mbbs_college_id'=>'MBBS college Id',
            'email_id'=>'Email ID'


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

        $user_exists=$this->common_model->get_table_row('students',array('student_mobile'=>$student_mobile,'organisation_id'=>$organisation_id),array());
			if(!empty($user_exists)){
				$response = array('status' => false, 'message' => 'User Already Exists in this Orgnanisation', 'response' => '');
				TrackResponse($user_input, $response);		
				$this->response($response);
			}


        $post_params=array(
				        	'state_id' => $state_id,
				            'organisation_id' => $organisation_id,
				            'center_id' => $center_id,
				            'course_id'=> $course_id,
				            'batch_id'=> $batch_id,
							'student_name'=>$student_name,
				            'student_mobile'=>$student_mobile,
				            
				            'mbbs_state'=>$mbbbs_state_id,
				            'college_mbbs'=> $mbbs_college_id,
				            'mbbs_batch'=> $mbbs_batch,
				            'student_email'=>$email_id,
				            'gender'=>$gender,
				            'room_no'=>$room_no,
				            'cabin_no'=>$cabin_no,
				            'student_alt_mobile'=>$alt_mobile_no,
				            'father_name'=>$father_or_husband_name,
				            'occupation'=>$guardian_occupation,
				            'res_contact_no'=>$residence_contact,
				            'guardian_contact_no'=>$guardian_contact_no,
				            'address_state_id'=>$address_state_id,
				            'permanent_address'=>$perement_address,
				            'internship_college'=>$intership_college,
				            'internship_join_date'=>$intership_start_date,
				            'presently_working'=>$presently_working,
				            'valid_from'=>$valid_from,
				            'valid_to'=>$valid_to,
				            'adding_from'=>'app',
				            'created_by'=>'ADM0001',
				            'created_on'=>date('Y-m-d H:i:s')

                           );
        $student_image1=upload_image(array('image'=>$student_image,'file_path'=>'storage/studentpics/','upload_path'=>'storage/studentpics/'));

        //echo '<pre>';print_r($student_image1);exit;
        $post_params['image']=$student_image1['result'];

        $result=$this->my_model->student_registration($post_params);
		
		if(!empty($result)){

		$stu_dy_id=$this->common_model->get_table_row('students',array('id'=>$result),array('student_dynamic_id'));
		
		$response = array('status' => true, 'message' => 'Student Register successfully!', 'response' => $result,'student_dynamic_id'=>$stu_dy_id['student_dynamic_id']);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'Student not Registered!', 'response' => '','student_dynamic_id'=>'');
		TrackResponse($user_input, $response);		
		$this->response($response);
		}


    }


    function addStudentPaymentDetails_post(){

	$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'student_id' => 'Student id',
            'payment_mode_id'=>'Payment mode id',
            'total_fee'=>'Total fee',
            'payable_amount'=>'Payable amount',
            'final_settled'=>'Final settled'
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

        $student=$this->common_model->get_table_row('students',array('id'=>$student_id),array());

        $check_student_payment=$this->common_model->get_table_row('student_payment_details',array('student_id'=> $student_id),array('id,state_id,organisation_id,center_id,total_fee,discount_fee'),'id','asc');
        if(!empty($check_student_payment)){

        	$this->data['till_now_paid_amt']=$this->db->query("select sum(amount_paid) as total_amt from tbl_student_payment_details where student_id=$student_id GROUP BY student_id" )->row_array();
        	$till_now_paid_amt= $this->data['till_now_paid_amt']['total_amt'];
        	$paynig_amount=$payable_amount;
			$total_paying_amt=$till_now_paid_amt+$paynig_amount;
			$student_payment_total_fee=$check_student_payment['total_fee'];

			if($total_paying_amt > $student_payment_total_fee){

				$response = array('status' => false, 'message' => 'Record added Failed Your Paying is crossed to total fee!.', 'response' => false);
				TrackResponse($user_input, $response);		
				$this->response($response);

			}

        }


        $attachment=$this->common_model->get_table_row('payment_modes',array('id'=> $payment_mode_id),array('id,attachment_id'));
        $receipt_no=getDynamicId('receipt_no','RECPT');

        $post_params=array(

        					'type'=>'bhatia',
        					'amount_type'=>'income',
        					'amount_from'=>'1',
				        	'state_id' => $student['state_id'],
				            'organisation_id' => $student['organisation_id'],
				            'center_id' => $student['center_id'],
				            'course_id'=> $student['course_id'],
				            'batch_id'=> $student['batch_id'],
				            'receipt_id'=>$receipt_no,
				            'student_id'=> $student['id'],
				            'student_dy_id'=>$student['student_dynamic_id'],
							'student_name'=>$student['student_name'],
				            'mobile_number'=>$student['student_mobile'],
				            'college_state_id'=>$student['mbbs_state'],
				            'college_id'=>$student['college_mbbs'],
				            'payment_for'=>'bhatia',
				            'payment_mode_id'=>$payment_mode_id,
				            'attachment_id'=>$attachment['attachment_id'],
				            'total_fee'=>$total_fee,
				            'discount_fee'=>$discount_fee,
				            'discount_scheme'=>$discount_scheme,
				            'amount_paid'=>$payable_amount,
				            'amount_paid_date'=>date('Y-m-d'),
				            'due_amount'=>$due_amount,
				            'due_date'=>$due_date,
				            'final_settled'=>$final_settled
				        );


        $result=$this->my_model->student_add_payments($post_params);
		
		if(!empty($result)){

		$this->common_model->createAndSaveAdmissionLink($student_id,$receipt_no);
		
		$response = array('status' => true, 'message' => 'Student Payment added successfully!', 'response' => $result);
		TrackResponse($user_input, $response);		
		$this->response($response);

		}else{

		$response = array('status' => false, 'message' => 'Student Payment not added !', 'response' => '');
		TrackResponse($user_input, $response);		
		$this->response($response);
		}
    }


}
?>