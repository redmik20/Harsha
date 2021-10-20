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
		//ini_set('memory_limit', '-1');
		
		$this->load->helper('app/ws_helper');
		$this->load->model('app/ws_model');
		$this->load->model('email_model');
		$this->load->helper('app/jwt_helper');
		$this->load->model('Common_model');
		
		$this->client_request = new stdClass();
		$this->client_request = json_decode(file_get_contents('php://input', true));
		$this->client_request = json_decode(json_encode($this->client_request), true);
	}

	/*-------------------- User -----------------------*/

    function register_user_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => "");
		$user_input = $this->client_request;
		extract($user_input);
		if(!$mobile)
		{
			$response = array('status' => false, 'message' => 'Enter Mobile Number!', 'response' => "");
			TrackResponse($user_input, $response);		
			$this->response($response);
		}		
		if(!$email_id)
		{
			$response = array('status' => false, 'message' => 'Enter Email ID!', 'response' => "");
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		if(!$password)
		{
			$response = array('status' => false, 'message' => 'Enter Password!', 'response' => "");
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		if(empty($exam_id))
		{
			$response = array('status' => false, 'message' => 'Enter exams id!', 'response' =>"");
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		$check_mobile = check_user_mobile_exists($mobile);
		if(!empty($check_mobile))
		{
			$response = array('status' => false, 'message' => 'Mobile Number Already Exists!', 'response' => "");
			TrackResponse($user_input, $response);
			$this->response($response);
		}
		/*$check_exams = check_user_exam_id_exists($exam_id);
		if(!empty($check_exam_id))
		{
			$response = array('status' => false, 'message' => 'Exams Already Exists!', 'response' => array());
			TrackResponse($user_input, $response);
			$this->response($response);
		}*/	
		$check_email_id = check_user_email_id_exists($email_id);
		if(!empty($check_email_id))
		{
			$response = array('status' => false, 'message' => 'Email ID Already Exists!', 'response' => "");
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		if($otp_confirmed == "No")
        {
            $otp = mt_rand(100000, 999999);
            $message = "Dear User, $otp is One time password (OTP) for MOW. Thank You.";
            //SendSMS($mobile, $message);
            $response = array('status' => true, 'message' => 'Otp sent successfully!', 'response' => "$otp");
           TrackResponse($user_input, $response);		
		   $this->response($response);exit;
        }
		$data = array(
			'name' => $name,
			'mobile' => $mobile,
			'email_id' => $email_id, 
			'password' => md5($password),
			'created_on' => date('Y-m-d H:i:s')
			);

		$user_id = insert_table('users', $data);		
		if($user_id == 0)
		{
			$response = array('status' => false, 'message' => 'User Registration Failed!', 'response' => "");
		}
		else
		{
			if(!empty($exam_id))
			{
				foreach($exam_id as $e_id)
				{
					$exams[] = array(
						'exam_id' => $e_id,
						'user_id' => $user_id,
						'created_on' => date('Y-m-d H:i:s')
					);
				}
				insert_table('users_exams', $exams, '', true);
			}
			$users = user_by_id($user_id);
			$user_exams = $this->ws_model->user_exams($user_id);
			$response = array('status' => true, 'message' => 'User Registration Successful!', 'response' => $users, 'user_exams' => $user_exams);
		}
		TrackResponse($user_input, $response);		
		$this->response($response);  

	}   

	/*-------------------- /User -----------------------*/ 


	/*
	*	User Login
	*/
	function user_login_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$mobile)
		{
			$response = array('status' => false, 'message' => 'Enter Mobile Number!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}	
		if(!$password)
		{
			$response = array('status' => false, 'message' => 'Enter Password!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}	

		$user_deleted = $this->ws_model->check_user_deleted($mobile);
		if(empty($user_deleted))
		{
			$response = array('status' => false, 'message' => 'Not a registered Mobile Number!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$user_status = $this->ws_model->check_user_status($mobile);
		if(empty($user_status))
		{
			$response = array('status' => false, 'message' => 'Your account has been put on hold. Please contact Administrator!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$user_details = $this->ws_model->user_login($mobile, $password);
		//echo $this->db->last_query();exit;
		if(empty($user_details))
		{
			$response = array('status' => false, 'message' => 'Login Failed. Please try again!', 'response' => array());
		}
		else
		{
			
			$user_exams = $this->ws_model->user_exams($user_details['id']);
			//print_r($user_exams);

			$response = array('status' => true, 'message' => 'Login Successful!', 'response' => $user_details, 'user_exams' => $user_exams);
		}
		
		TrackResponse($user_input, $response);		
		$this->response($response);
	}
function  homepage_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'Enter user Number!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		
		if($user_id == 0)
		{
		$response = array('status' => false, 'message' => 'User fetched Failed!', 'response' => array());
		}
		else
		{
		$user_exams = $this->ws_model->user_exams($user_id);
			$banners = $this->ws_model->banners();
	$stats['user_videos'] = $this->ws_model->users_video($chapter_id, $user_id);
		$stats['total_videos'] = $this->ws_model->total_videos();
		$stats['user_qbank'] = $this->ws_model->user_qbank($user_id);
		$stats['total_qbank'] = $this->ws_model->total_qbank();
		$stats['user_test'] = $this->ws_model->user_test($user_id);
		$stats['total_test'] = $this->ws_model->total_test();
	 $suggestedqbank = array();
	$suggested_videos = $this->ws_model->add_usersuggest();
			$response = array('status' => true, 'message' => 'Data fetched Successful!','user_exams' => $user_exams,'banners' => $banners,'statusbar'=>[$stats],'suggestedqbank'=>$suggestedqbank,'suggested_videos'=>$suggested_videos);
		}
		
		TrackResponse($user_input, $response);		
		$this->response($response);
   }

  	function add_user_exams_post()
    {
        $response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(count($exam_id) == 0)
		{
			$response = array('status' => false, 'message' => 'Enter Exam id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'Enter User Id!', 'response' => array());
		}
		else
		{
    			$user_exams = $this->ws_model->add_examsbyuser($user_id, $exam_id);
			//echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'User exams added Successful!','user_exams' => $user_exams);
		}		
		TrackResponse($user_input, $response);		
		$this->response($response);  
     } 

     	/*
	*	Delete User by exams
	*/
	function delete_user_exams_post() //check
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);

		
		if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'User Id is required!');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		if(!$exam_id)
		{
			$response = array('status' => false, 'message' => 'Exam Name is required!');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

	 $delete_user = $this->ws_model->delete_user_exam($user_id,$exam_id);
		if($delete_user === false)
		{
			$response = array('status' => false, 'message' => 'exam deletion Failed!');
		}
		else
		{
			
			$response = array('status' => true, 'message' => 'exam deleted Successfully!');
		}		
		TrackResponse($user_input, $response);		
		$this->response($response);
	}

   function exam_subjects_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		// if(!$user_id)
		// {
		// 	$response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
		// 	TrackResponse($user_input, $response);		
		// 	$this->response($response);
		// }
		if(!$exam_id)
		{
			$response = array('status' => false, 'message' => 'Exam ID is required!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		$user_subjects = $this->ws_model->exam_subjects($exam_id);
		if(empty((array)$user_subjects))
		{
			$response = array('status' => false, 'message' => 'No Subjects found!', 'response' => array());
		}
		else
		{			
			//echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'Subjects fetched Successfully!', 'user_subjects' => $user_subjects);
		}
		
		TrackResponse($user_input, $response);		
		$this->response($response);
   } 

   function  chaptervideomode_post()
   {
   	$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$status)
		{
			$response = array('status' => false, 'message' => 'Enter video status id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'Enter user id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		if($status == 0)
		{
			$response = array('status' => false, 'message' => 'User fetched Failed!', 'response' => array());
		}
		elseif($user_id==0)
			{
			$response = array('status' => false, 'message' => 'User fetched Failed!', 'response' => array());
		}
		else
		{
			$chapter_video = $this->ws_model->video_mode($status);
		//echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'User fetched Successful!','chapter_video' => $chapter_video);
		}
		
		TrackResponse($user_input, $response);		
		$this->response($response);
   }

   function plandetails_post()
    {
 	$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		$plandetails = $this->ws_model->plandetails();
		if(empty($plandetails))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $plandetails);
		}

		TrackResponse($user_input, $response);		
		$this->response($response);
	}


	function  userplan_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'Enter user Number!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}		
		if($user_id == 0)
		{
			$response = array('status' => false, 'message' => 'User fetched Failed!', 'response' => array());
		}
		else
		{
			$user_plan = $this->ws_model->user_plan($user_id);
			//echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'User fetched Successful!','response' => 
				$user_plan);
		}		
		TrackResponse($user_input, $response);		
		$this->response($response);
   }

   /*
	*	post User Details
	*/
	function user_profile_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
        
        if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'Enter user id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$user_details = user_by_id($user_id);
		//print_r($user_details);exit;
	//echo $this->db->last_query();exit;
		if(empty($user_details))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $user_details);
		}

		TrackResponse($user_input, $response);		
		$this->response($response);
	}
   public function submit_ratings_post()
	{		
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		  if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'Enter user id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		  /*if(!$chapter_video_id)
		{
			$response = array('status' => false, 'message' => 'Enter chapter video id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}*/
		  if(!$rating)
		{
			$response = array('status' => false, 'message' => 'Enter rating number!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}	
    if($chapter_video_id!=''){
        $data = array(
			'user_id' => $user_id,
			'chapter_video_id' => $chapter_video_id,
			'rating' => $rating,
			'created_on' => date('Y-m-d H:i:s')
			);
    }
    else{
		$data = array(
			'user_id' => $user_id,
			'video_topics_id' => $video_topics_id,
			'rating' => $rating,
			'opinion' => $opinion,
			'feedback' => $feedback,
			'created_on' => date('Y-m-d H:i:s')
			);
    }
		$this->db->insert('ratings', $data);
	if($chapter_video_id!=''){
		$user_ratings = $this->ws_model->user_ratings($chapter_video_id,$user_id);
	}else{
	    $user_ratings = get_table('ratings',array('video_topics_id'=>$video_topics_id,'user_id'=>$user_id));
	}
		$response = array('status' => true, 'message' => 'Rating Submitted Successfully!', 'response' => $user_ratings);
		$this->response($response);
	}

function ucv_post()
	{
		 $response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
        if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'Enter user Id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);

		}

		if(!$subject_id)
		{
			$response = array('status' => false, 'message' => 'Enter subject Id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		if(!$status)
		{
			$response = array('status' => false, 'message' => 'Enter chapter status!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		$data = array(
              'user_id' => $user_id,
              'subject_id' => $subject_id,
             'status' => $status
             	);
		$demovideo = $this->ws_model->demosinglevideo($data);
         $chapter_status_list = $this->ws_model->chapter_status_list($data);
         $user_access_info = $this->ws_model->get_user_access($user_id);
         if(empty($chapter_status_list))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => [
				'demovideo' => $demovideo,
				'chapters_list' => $chapter_status_list,
				'user_access_info' => $user_access_info
				]
			);
		}

		TrackResponse($user_input, $response);		
		$this->response($response);
	}
	
	
	function ucvs_post()
	{
		 $response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
        if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'Enter user Id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);

		}

		if(!$subject_id)
		{
			$response = array('status' => false, 'message' => 'Enter subject Id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		if(!$status)
		{
			$response = array('status' => false, 'message' => 'Enter chapter status!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		$data = array(
              'user_id' => $user_id,
              'subject_id' => $subject_id,
             'status' => $status
             	);
		$demovideo = $this->ws_model->demosinglevideos($data);
         $chapter_status_list = $this->ws_model->chapter_status_lists($data);
         $user_access_info = $this->ws_model->get_user_access($user_id);
         if(empty($chapter_status_list))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => [
				'demovideo' => $demovideo,
				'chapters_list' => $chapter_status_list,
				'user_access_info' => $user_access_info
				]
			);
		}

		TrackResponse($user_input, $response);		
		$this->response($response);
	}
    
    function get_topic_post()
     {
     	$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
        if(!$topic_id)
		{
			$response = array('status' => false, 'message' => 'Enter Topic Id!', 'response' => array(), 'OTP' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);

		}

         $chapter_status_list = $this->ws_model->get_topic($topic_id);
         $total_questions = get_table_row('qbank',array('video_topics_id'=>$topic_id),array('count(id) as count'));
         $total_bookmarks = get_table_row('bookmarks',array('topic_id'=>$topic_id,'user_id'=>$user_id),array('count(id) as count'));
         $exams = get_table_row('user_qbank',array('topic_id'=>$topic_id,'user_id'=>$user_id),array('count(id) as count'));
         $ratings = get_table_row('ratings',array('video_topics_id'=>$topic_id,'user_id'=>$user_id),array('count(id) as count'));
          if($ratings['count']!='0'){
             $ratings="yes";
         }
         else{
             $ratings="no";
         }
         if($exams['count']!='0'){
             $exams="yes";
         }
         else{
             $exams="no";
         }
         if(empty($chapter_status_list))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $chapter_status_list, 'questions'=>$total_questions['count'], 'bookmarks'=>$total_bookmarks['count'], 'exam_attempted'=>$exams, 'rating_status'=>$ratings);
		}

		TrackResponse($user_input, $response);		
		$this->response($response);
	} 
	
	function get_questions_post()
     {
     	$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
        if(!$topic_id)
		{
			$response = array('status' => false, 'message' => 'Enter Topic Id!', 'response' => array(), 'OTP' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);

		}

         $chapter_status_list = $this->ws_model->get_questions($topic_id,$from);
         //print_r($total_questions);exit;
         if(empty($chapter_status_list))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $chapter_status_list);
		}

		TrackResponse($user_input, $response);		
		$this->response($response);
	} 
	
	
	/*
	*	Submit Q bank Answers
	*/
	function submit_qbank_answers_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);

		$required_params = array('user_id'=>"User ID", 'topic_id'=>"Quizs ID", 'answers'=>"Answers");
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
        if(!empty($answers))
        {
        	$correct_answer_count = 0;
        	$wrong_answer_count = 0;
        	foreach($answers as $row)
        	{
        		if($row['answer_status'] == "correct")
        		{
        			$correct_answer_count++;
        		}
        		elseif($row['answer_status'] == "wrong")
        		{
        			$wrong_answer_count++;
        		}
        		elseif($row['answer_status'] == "not answered")
        		{
        			$not_answer_count++;
        		}
        		$reports=implode(',',$row['reports']);
        		$data[] = array(
		        	'user_id' => $user_id,
		        	'topic_id' => $topic_id,
		        	'qbank_id' => $row['qbank_id'],
		        	'answer' => $row['answer'],
		        	'reports' => $reports,
		        	'correct_answer' => $row['correct_answer'],
		        	'answer_status' => $row['answer_status'],
		        	'created_on' => date('Y-m-d H:i:s')
		        	);
        	}
        	//print_r($data);exit;
        	$response = insert_table('user_qbank', $data, '', true);
        	if($response > 0)
			{
				$response = array('status' => true, 'message' => 'Q Bank submitted Successfully!', 'correct_answer_count' => $correct_answer_count, 'wrong_answer_count' => $wrong_answer_count, 'not_answer_count' => $not_answer_count);
			}
			else
			{
				$response = array('status' => false, 'message' => 'Q Bank submission failed!');
			}
        }
        else
        {
        	$response = array('status' => false, 'message' => 'Q Bank submission failed!');
        }				
		TrackResponse($user_input, $response);		
		$this->response($response);
	}
	
	function add_bookmark_post()
     {
     	$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
        if(!$topic_id)
		{
			$response = array('status' => false, 'message' => 'Topic Id Required!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);

		}
		if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'User Id Required!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);

		}
		if(!$qbank_id)
		{
			$response = array('status' => false, 'message' => 'Question bank Id Required!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);

		}

         $data = array(
			'user_id' => $user_id,
			'topic_id' => $topic_id,
			'qbank_id' => $qbank_id
			);
		$bookmarks=	get_table_row('bookmarks', $data);
	//	print_r($bookmarks);exit;
        if(!empty($bookmarks)){
           $delete = delete_record('bookmarks', $data);
            $response = array('status' => false, 'message' => 'Bookmark Deleted successfully!', 'response' => array());
        	$this->response($response);
        }
        else{
            $data['created_on']=date('Y-m-d H:i:s');
            $user_id = insert_table('bookmarks', $data);
        }
	
         //print_r($total_questions);exit;
         if(empty($user_id))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Bookmark Added Successfully!');
		}

		TrackResponse($user_input, $response);		
		$this->response($response);
	} 
	
	/*
	*	Get Right and Wrong Attempts
	*/
	function right_wrong_attempts_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);		
		$required_params = array('user_id'=>"User ID", 'topic_id'=>"Topic ID");
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
        $all_answers = $this->ws_model->right_answers($user_id, $topic_id, 'all');
		$right_answers = $this->ws_model->right_answers($user_id, $topic_id, 'right');
		$wrong_answers = $this->ws_model->right_answers($user_id, $topic_id, 'wrong');
		$skipped_answers = $this->ws_model->right_answers($user_id, $topic_id, 'skipped');
		//echo $this->db->last_query();

		$response = array('status' => true, 'message' => 'Data fetched Successfully!', 'all_answers' => $all_answers,  'right_answers' => $right_answers, 'wrong_answers' => $wrong_answers, 'skipped_answers' => $skipped_answers, 'total_marks' => count($right_answers) + count($wrong_answers) + count($skipped_answers), 'right_answers_count' => count($right_answers));
		TrackResponse($user_input, $response);		
		$this->response($response);
	} 
	
	/*
	*	Get analysis
	*/
	function get_analysis_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);		
		$required_params = array('user_id'=>"User ID", 'topic_id'=>"Topic ID");
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
        $all_answers = $this->ws_model->right_answers($user_id, $topic_id, 'all');
		$right_answers = $this->ws_model->right_answers($user_id, $topic_id, 'right');
		$wrong_answers = $this->ws_model->right_answers($user_id, $topic_id, 'wrong');
		$skipped_answers = $this->ws_model->right_answers($user_id, $topic_id, 'skipped');

            $right_answerss = number_format( count($right_answers)/count($all_answers) * 100, 2 ) . '%';
            $wrong_answerss = number_format( count($wrong_answers)/count($all_answers) * 100, 2 ) . '%';
	        $skipped_answerss = number_format( count($skipped_answers)/count($all_answers) * 100, 2 ) . '%';
		//echo $this->db->last_query();

		$response = array('status' => true, 'message' => 'Data fetched Successfully!',  'right_answers' => $right_answerss, 'wrong_answers' => $wrong_answerss, 'skipped_answers' => $skipped_answerss, 'total_marks' => count($right_answers) + count($wrong_answers) + count($skipped_answers), 'right_answers_count' => count($right_answers));
		TrackResponse($user_input, $response);		
		$this->response($response);
	} 

    function singlechaptervideo_post()
     {
     	$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
        if(!$chapter_id)
		{
			$response = array('status' => false, 'message' => 'Enter chapter Id!', 'response' => array(), 'OTP' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);

		}
		if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'Enter user Id!', 'response' => array(), 'OTP' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);

		}

         $chapter_status_list = $this->ws_model->chapter_videodetails($chapter_id, $user_id);
         if(empty($chapter_status_list))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $chapter_status_list);
		}

		TrackResponse($user_input, $response);		
		$this->response($response);
	}               
	/*
	*	Change Password
	*/
	function user_update_password_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		if(!$user_id || !$password)
		{
			$response = array('status' => false, 'message' => 'User Id or Password not found!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		$data = array(
			'password' => md5($password),			
			'modified_on' => date('Y-m-d H:i:s')
			);

		$update_user = $this->ws_model->update_user($data, $user_id);
		//echo $this->db->last_query();exit;
		if($update_user === FALSE)
		{
			$response = array('status' => false, 'message' => 'Password Updation Failed!', 'response' => array());
		}
		else
		{
			//SendSMS($mobile, 'Dear Customer '.$rand.' is your One Time Password for Poprebates. Thank You.');
			$user_details = user_by_id($user_id);
			$response = array('status' => true, 'message' => 'Password Updation Successful!', 'response' => $user_details);
		}		
		TrackResponse($user_input, $response);		
		$this->response($response);
	}
	function  faq_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		
		
		
			$user_faq = $this->ws_model->user_faq($user_id);
			if(empty($user_faq))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			//echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'User fetched Successful!','user_faq' => $user_faq);
		
		}
		TrackResponse($user_input, $response);		
		$this->response($response);
   }

   public function studentsupport_post()
	{		
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'Enter user id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}	
      
      if(!$issue)
		{
			$response = array('status' => false, 'message' => 'Enter issue id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}	
        if(!$description)
		{
			$response = array('status' => false, 'message' => 'Enter description id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}	

		$data = array(
			'user_id' => $user_id,
			'issue' => $issue,
			'description' => $description,
			'created_on' => date('Y-m-d H:i:s')
			);
		$this->db->insert('student_support', $data);
	$student_support = $this->ws_model->student_support($user_id);
		$response = array('status' => true, 'message' => 'Message Submitted Successfully!', 'response' => $student_support);
		$this->response($response);
	}

    public function notifications_post()
    {
    	$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);		

		$user_notifications = $this->ws_model->user_notifications();
		//echo $this->db->last_query();exit;
		if(empty($user_notifications))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $user_notifications);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	
    }

   function chapterslides_post()
 	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		 if(!$chapter_id)
		{
			$response = array('status' => false, 'message' => 'Enter chapter Id!', 'response' => array(), 'OTP' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);

		}
		/*if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'Enter user Id!', 'response' => array(), 'OTP' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);

		}*/
		$user_slides = $this->ws_model->user_slides($chapter_id);
		
		 if(empty($user_slides))
		{
			$response = array('status' => false, 'message' => 'No slides are available as free to show you', 'response' => array());
		}
		else
		{
			
			//echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'Chapter Slides fetched Successful!','response' => $user_slides);
		}
		
		TrackResponse($user_input, $response);		
		$this->response($response);

 	} 

     function chapternotes_post()
 	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		 if(!$chapter_id)
		{
			$response = array('status' => false, 'message' => 'Enter chapter Id!', 'response' => array(), 'OTP' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);

		}
			$chapter_notes = $this->ws_model->user_notes($chapter_id);
		
		 if(empty($chapter_notes))
		{
			$response = array('status' => false, 'message' => 'No data found', 'response' => array());
		}
		else
		{
			
			//echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'User fetched Successful!','response' => $chapter_notes);
		}
		
		TrackResponse($user_input, $response);		
		$this->response($response);

 	} 

  	public function otherloginmethods_post()
    {
    	$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$email_id)
		{
			$response = array('status' => false, 'message' => 'Enter Email ID!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		if(!$password)
		{
			$response = array('status' => false, 'message' => 'Enter Password!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}	
		

	$user_deleted = $this->ws_model->check_userotherlogin_deleted($email_id);
		if(empty($user_deleted))
		{
			$response = array('status' => false, 'message' => 'Not a registered Email ID!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

	 $user_status = $this->ws_model->check_userotherlogin_status($email_id);
		if(empty($user_status))
		{
			$response = array('status' => false, 'message' => 'Your account has been put on hold. Please contact Administrator!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

  $user_details = $this->ws_model->user_otherlogin($email_id, $password);
		//echo $this->db->last_query();exit;
		if(empty($user_details))
		{
			$response = array('status' => false, 'message' => 'Login Failed. Please try again!', 'response' => array());
		}
		else
		{
			$user_exams = $this->ws_model->user_exams($user_details['id']);
           //echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'Login Successful!', 'response' => $user_details, 'user_exams' => $user_exams);
		}
		
		TrackResponse($user_input, $response);		
		$this->response($response);

    }


    public function exams_post()
     {
    	$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		$user_exams = $this->ws_model->examslist($user_id);
		//echo $this->db->last_query();exit;
		if(empty($user_exams))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $user_exams);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
    }

     public function subjects_post()
     {
    	$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		if(!$exam_id)
		{
			$response = array('status' => false, 'message' => 'Please Select exam', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}		

		$user_subjects = $this->ws_model->subjects($exam_id);
		//echo $this->db->last_query();exit;
		if(empty($user_subjects))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $user_subjects);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
    }
   

    /*
	*	User Forgot Password
	*/
	function user_forgot_password_post()
	{
		$response = array('status' => true, 'message' => '', 'response' => array(), 'OTP' => array());
		$user_input = $this->client_request;
		extract($user_input);

 $user_deleted = $this->ws_model->check_anyuser_deleted($mobile,$email_id);

		if(empty($user_deleted))
		{
			$response = array('status' => false, 'message' => 'Not a registered Mobile Number or email_id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$user_status = $this->ws_model->check_anyuser_status($mobile , $email_id);

		if(empty($user_status))
		{
			$response = array('status' => true, 'message' => 'Your account has been put on hold. Please contact Administrator!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

	if($email_id!=''){ 
		$user_details = check_user_input_exists($mobile,$email_id);
		//echo $this->db->last_query();
		$rand = mt_rand(100000, 999999);
		$otp = array('otp' => $rand);
		if(empty($user_details))
		{
			$response = array('status' => true, 'message' => 'Email Id not registered!', 'response' => array(), 'OTP' => array());			
		}
		else{
		$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.gmail.com',
				'smtp_port' => 465,
				'smtp_user' => 'mprabhudeepyy@gmail.com', 
				'smtp_pass' => '9849763795ff', 
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
				);


			$msg='Dear Customer '.$rand.' is your One Time Password for Education. Thank You.
			';
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('mprabhudeep@gmail.com','jj');
			$this->email->to($email_id);
			$this->email->subject('Reset Password');
			$this->email->message($msg);
			if($this->email->send())
			{
				$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $user_deleted, 'OTP' => $otp);
			}
			else
			{
				$response = array('status' => true, 'message' => 'Mail Sending Failed!', 'response' => array(), 'OTP' => array());
     //echo $this->email->print_debugger();
			}
		}

	} 
	else{
	$user_details = check_user_input_exists($mobile,$email_id);

		//echo $this->db->last_query();
		$rand = mt_rand(100000, 999999);
		$otp = array('otp' => $rand);
		if(empty($user_details))
		{
			$response = array('status' => true, 'message' => 'Mobile Number not registered!', 'response' => array(), 'OTP' => array());			
		}
		else
		{
			$Message = 'Dear Customer '.$rand.' is your One Time Password for Education. Thank You.';
			SendSMS($mobile, $Message);
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $user_deleted, 'OTP' => $otp);
		}		
		
	}

	TrackResponse($user_input, $response);		
		$this->response($response);

	}


	/*
	*	Update User Profile
	*/
	
	 function faculty_info_post()
 	  {
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$exam_id)
		{
			$response = array('status' => false, 'message' => 'Please Select  Exam !', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		
		if($exam_id == 0)
		{
			$response = array('status' => false, 'message' => 'No Data Found', 'response' => array());
		}
		else
		{
			$user_faculty = $this->ws_model->user_faculty($exam_id);
			//echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'User fetched Successful!','response' => $user_faculty);
		}
		
		TrackResponse($user_input, $response);		
		$this->response($response);
 	}


 	function  videotime_post()
 	{
       	$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$chapter_id)
		{
			$response = array('status' => false, 'message' => 'Enter chapter video id Number!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
 	  	if($chapter_id == 0)
		{
			$response = array('status' => false, 'message' => 'User fetched Failed!', 'response' => array());
		}
		else
		{
			$timedetails = $this->ws_model->videotimes($chapter_id);
			//echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'User fetched Successful!','View_Details' => $timedetails);
		}		
		TrackResponse($user_input, $response);		
		$this->response($response);
 	}

	function videotimes_post()
 	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$chapter_video_id)
		{
			$response = array('status' => false, 'message' => 'Enter exam Number!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}		
		if($exam_id == 0)
		{
			$response = array('status' => false, 'message' => 'User fetched Failed!', 'response' => array());
		}
		else
		{
			$user_faq = $this->ws_model->user_faculty($exam_id);
			//echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'User fetched Successful!','user_faq' => $user_faq);
		}		
		TrackResponse($user_input, $response);		
		$this->response($response);
 	}

 	function  subject_chapters_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$exam_id)
		{
			$response = array('status' => false, 'message' => 'Enter subject Number!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		if(!$subject_id)
		{
			$response = array('status' => false, 'message' => 'Enter exam id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}		
		if($subject_id == 0)
		{
			$response = array('status' => false, 'message' => 'User fetched Failed!', 'response' => array());
		}
		else
		{
			$user_subjects = $this->ws_model->subject_chapters($subject_id);
			//echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'User fetched Successful!','user_subjects' => $user_subjects);
		}		
		TrackResponse($user_input, $response);		
		$this->response($response);
    }

	function  planinfo_post()
	{
 		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'Enter user Number!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}	
		$user_plan = $this->ws_model->user_plan($user_id);
		$proplans = $this->ws_model->proplansdetails();
		$induvidualplans = $this->ws_model->induvidualplandetails();
		if(empty($proplans) && empty($induvidualplans))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'proplans' => array(), 'induvidualplans' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'ProPlans' => $proplans, 'InduvidualPlans' => 
			$induvidualplans,'Myplans' =>$user_plan );
		}
		TrackResponse($user_input, $response);		
		$this->response($response);
	}


	function  paticularplan_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$plan_details_id)
		{
			$response = array('status' => false, 'message' => 'Enter  plan details id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}		
		if($plan_details_id == 0)
		{
			$response = array('status' => false, 'message' => 'User fetched Failed!', 'response' => array());
		}
		else
		{
			$user_planinfo = $this->ws_model->user_plandetails($plan_details_id);
			//echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'User fetched Successful!','response' => 
				$user_planinfo);
		}		
		TrackResponse($user_input, $response);		
		$this->response($response);
   	}

 	/*
	*	Update User Profile
	*/
	function update_user_profile_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		$new_data = [];	
		if($name) {
			$new_data['name'] = $name;
		}
		if($mobile) {
			$new_data['mobile'] = $mobile;
		}
		if($email_id) {
			$new_data['email_id'] = $email_id;
		}
		$image_data= array(
			'upload_path' =>'./storage/images/',
			'file_path' => 'storage/images/'
		);
		if($image)
		{
			$image_data['image'] = $image;
			$image_result = $this->Common_model->upload_image($image_data);
			if(!$image_result['status'])
			{
	            $response = array('status' => false, 'message' => 'Image saving is unsuccessful!');
	            TrackResponse($user_input, $response);       
	            $this->response($response);
			}
			else
			{
				$profile = $image_result['result'];
			}
		}
		if($image)
		{
			$new_data['image'] = $profile;
		}
		if($gender)
		{
			$new_data['gender'] = $gender;
		}
		$new_data['modified_on'] = date('Y-m-d H:i:s');

		$update_user = $this->ws_model->update_user($new_data, $user_id);
		if($update_user === FALSE)
		{
			$response = array('status' => false, 'message' => 'User Updation Failed!', 'response' => array());
		}
		else
		{
			//SendSMS($mobile, 'Dear Customer '.$rand.' is your One Time Password for Poprebates. Thank You.');
			$user_details = user_by_id($user_id);
			$user_details['otp'] = mt_rand(100000, 999999);
			//print_r($user_details);exit;
			$response = array('status' => true, 'message' => 'User Updation Successful!', 'response' => $user_details);
		}		
		TrackResponse($user_input, $response);		
		$this->response($response);
	}

	function change_password_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'user Id is required!');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		if(!$oldpassword)
		{
			$response = array('status' => false, 'message' => 'old password is required!');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		if(!$newpassword)
		{
			$response = array('status' => false, 'message' => 'new password is required!');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

       $result = $this->ws_model->change_password($oldpassword,$newpassword,$user_id);

       if($result) {
	       $response = array('status' => true, 'message' => 'Password Changed Successful!','change password' => $result);
       } else {
	       $response = array('status' => true, 'message' => 'Incorrect old password!','change password' => $result);
       }
       
		
		TrackResponse($user_input, $response);		
		$this->response($response);
 	} 	 

	 function  subscribe_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$plan_details_id)
		{
			$response = array('status' => false, 'message' => 'Enter  plan details id!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		
		if($plan_details_id == 0)
		{
			$response = array('status' => false, 'message' => 'No data found', 'response' => array());
		}
		else
		{
			$subscribe = $this->ws_model->subscribe($plan_details_id);
			//echo $this->db->last_query();exit;
			$response = array('status' => true, 'message' => 'Your pay!','response' => 
				$subscribe);
		}
		
		TrackResponse($user_input, $response);		
		$this->response($response);
    }

	function add_to_userexams_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		$data = array(	
			'user_id' => $user_id,
			'exam_id' => $exam_id,
			'created_on' => date('Y-m-d H:i:s')
			);
		$add_to_favourites = $this->ws_model->add_to_favourites($data);
		if($add_to_favourites == 1)
		{	
			$response = array('status' => true, 'query' => 'insert', 'message' => 'Exam added!');
		}
		elseif($add_to_favourites == 0)
		{
			$response = array('status' => true, 'response' => 'delete', 'message' => 'Exam removed!');
		}
		else
		{
			$response = array('status' => false, 'message' => 'Updation Failed!');
		}	
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	function  user_selectedexams_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$user_id)
		{
			$response = array('status' => false, 'message' => 'Enter  user id!', 'response' => array());
			TrackResponse($user_input, $response);
			$this->response($response);
		}
		$userselected_exams = $this->ws_model->userselected_exams($user_id);
		if(empty($userselected_exams))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $userselected_exams);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	function forgot_resend_otp_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);		
		if(!$mobile)
		{
			$response = array('status' => false, 'message' => 'Enter Mobile Number!');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		$details = $this->ws_model->get_table_row('users',array('mobile'=>$mobile, 'delete_status' => 1),array());
		if(empty($details))
		{
		    $response = array('status' => false, 'message' => 'This mobile number is not registered with us!');
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		$otp = mt_rand(100000, 999999);
		if(empty($details))
		{
			$response = array('status' => false, 'message' => 'Otp Sending Failed!');
		}
		else
		{
		    $Message = 'Dear Customer '.$otp.' is your One Time Password for Master of Wedding. Thank You.';
    		SendSMS($mobile, $Message);
		    $response = array('status' => true, 'message' => 'Otp send Successful!', 'response' => $details, 'otp' => $otp);
		}
		TrackResponse($user_input, $response);		
		$this->response($response);
	}

	/*
	*	Quiz Topics
	*/
	function quiz_topics_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'subject_id' => 'Subject ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
		$response = $this->ws_model->quiz_topics($user_id, $course_id, $subject_id, $count);		
		//echo $this->db->last_query();
		if(empty($response))
		{
			$response = array('status' => false, 'message' => 'No topics found!');	
		}
		else
		{
			$topics_count = $this->ws_model->quiz_topics_count($course_id, $subject_id);
			$questions_count = $this->ws_model->quiz_questions_count($course_id, $subject_id);
			$topics_count = array(
				'topics_count' => $topics_count,
				'questions_count' => $questions_count
				);
			$response = array('status' => true, 'message' => 'Topics Fetched Successfully!', 'response' => $response, 'count' => $topics_count);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Quiz Topics finished
	*/

	function quiz_topics_finished_post(){
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'subject_id' => 'Subject ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
        $response = $this->ws_model->quiz_topics_finished($user_id, $course_id, $subject_id, $count);
        if(empty($response))
		{
			$response = array('status' => false, 'message' => 'No topics found!');	
		}
		else
		{
			$topics_count=0;$questions_count=0;
			foreach ($response as $value) {
				if($value['answered']>0){
					$topics_count++;
					$questions_count=$value['questions_count']+$questions_count;
				}
			}
			$topics_count = array(
				'topics_count' => $topics_count,
				'questions_count' => $questions_count
				);
			$response = array('status' => true, 'message' => 'Topics Fetched Successfully!', 'response' => $response, 'count' => $topics_count);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Quiz Topics free
	*/

	function quiz_topics_free_post(){
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'subject_id' => 'Subject ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
        $response = $this->ws_model->quiz_topics_free($user_id, $course_id, $subject_id, $count);
        // var_dump($response);die();
        if(empty($response))
		{
			$response = array('status' => false, 'message' => 'No topics found!');	
		}
		else
		{
			$topics_count=0;$questions_count=0;
			foreach ($response as $value) {
				$topics_count++;
				if($value['questions_count']>0){
					$questions_count=$value['questions_count']+$questions_count;
				}
			}
			$topics_count = array(
				'topics_count' => $topics_count,
				'questions_count' => $questions_count
				);
			$response = array('status' => true, 'message' => 'Topics Fetched Successfully!', 'response' => $response, 'count' => $topics_count);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}


	/*
	*	Quiz Topic Details
	*/
	function quiz_topic_details_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'topic_id'=>'Topic ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
		$response = $this->ws_model->quiz_topic_details($user_id, $topic_id);		
		//echo $this->db->last_query();
		if(empty((array)$response))
		{
			$response = array('status' => false, 'message' => 'No topics found!');	
		}
		else
		{
			$response = array('status' => true, 'message' => 'Topic Fetched Successfully!', 'response' => $response);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}


	/*
	*	Quiz Questions
	*/
	function quiz_questions_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'subject_id' => 'Subject ID', 'topic_id' => 'Topic ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
		$response = $this->ws_model->quiz_questions($user_id, $course_id, $subject_id, $topic_id, $count);
		//echo $this->db->last_query();
		if(empty((array)$response))
		{
			$response = array('status' => false, 'message' => 'No questions found!');	
		}
		else
		{
			$response = array('status' => true, 'message' => 'Questions Fetched Successfully!', 'response' => $response);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Submit Quiz Test
	*/
	function submit_quiz_tests_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'subject_id' => 'Subject ID', 'topic_id' => 'Topic ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
        if(!empty($answers))
        {
        	$correct_answer_count = 0;
        	$wrong_answer_count = 0;
        	$skipped_answer_count = 0;
        	foreach($answers as $row)
        	{
        		if($row['answer_status'] == "correct")
        		{
        			$correct_answer_count++;
        		}
        		elseif($row['answer_status'] == "wrong")
        		{
        			$wrong_answer_count++;
        		}
        		elseif($row['answer_status'] == "skipped")
        		{
        			$skipped_answer_count++;
        		}
        		$data[] = array(
		        	'user_id' => $user_id,
		        	'course_id' => $course_id,
		        	'subject_id' => $subject_id,
		        	'topic_id' => $topic_id,
		        	'question_id' => $row['question_id'],
		        	'option_id' => $row['option_id'],
		        	'answer' => $row['answer'],
		        	'correct_answer' => $row['correct_answer'],
		        	'answer_status' => $row['answer_status'],
		        	'created_on' => date('Y-m-d H:i:s')
		        	);
        	}
        	$response = insert_table('quiz_answers', $data, '', true);        	
        	if($response > 0)
			{
				if($ratings)
				{
					$rating_data = array(
						'course_id' => $course_id,
			        	'subject_id' => $subject_id,
			        	'topic_id' => $topic_id,
			        	'ratings' => $ratings,
			        	'message' => $review,
			        	'created_on' => date('Y-m-d H:i:s')
						);
					insert_table('quiz_topic_reviews', $rating_data);
				}
				$total_questions = $correct_answer_count + $wrong_answer_count + $skipped_answer_count;

				$correct_percentage = $correct_answer_count / $total_questions * 100;
				$wrong_percentage = $wrong_answer_count / $total_questions * 100;
				$skipped_percentage = $skipped_answer_count / $total_questions * 100;

				$response = array(
					'correct_answer_count' => $correct_answer_count,
					'wrong_answer_count' => $wrong_answer_count,
					'skipped_answer_count' => $skipped_answer_count,
					'correct_percentage' => number_format($correct_percentage, 2),
					'wrong_percentage' => number_format($wrong_percentage, 2),
					'skipped_percentage' => number_format($skipped_percentage, 2)
					);

				$response = array('status' => true, 'message' => 'Quiz submitted Successfully!', 'response' => $response);
			}
			else
			{
				$response = array('status' => false, 'message' => 'Quiz submission failed!');
			}
        }
        else
        {
        	$response = array('status' => false, 'message' => 'Quiz submission failed!');
        }		
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Submit Question Report
	*/
	function submit_question_report_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'subject_id' => 'Subject ID', 'topic_id' => 'Topic ID', 'question_id' => 'Question ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
        if(!empty($report))
        {
        	$reports = implode(",", $report);
        	$report_data = array(
        		'user_id' => $user_id,
				'course_id' => $course_id,
	        	'subject_id' => $subject_id,
	        	'topic_id' => $topic_id,
	        	'question_id' => $question_id,
	        	'reports' => $reports,
	        	'created_on' => date('Y-m-d H:i:s')
				);
			$quiz_reports = insert_table('quiz_reports', $report_data);
			if($quiz_reports > 0)
			{
				$response = array('status' => true, 'message' => 'Report submitted Successfully!');
			}
			else
			{
				$response = array('status' => false, 'message' => 'Report submission failed!');
			}
        }
        else
        {
        	$response = array('status' => false, 'message' => 'Report submission failed!');
        }		
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Bookmark Question
	*/
	function bookmark_question_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'subject_id' => 'Subject ID', 'topic_id' => 'Topic ID', 'question_id' => 'Question ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
    	$data = array(
    		'user_id' => $user_id,
			'course_id' => $course_id,
        	'subject_id' => $subject_id,
        	'topic_id' => $topic_id,
        	'question_id' => $question_id,
        	'created_on' => date('Y-m-d H:i:s')
			);
		$quiz_question_bookmarks = insert_table('quiz_question_bookmarks', $data);
		//echo $this->db->last_query();
		if($quiz_question_bookmarks > 0)
		{
			$response = array('status' => true, 'message' => 'Question added to Bookmark!');
		}
		else
		{
			$response = array('status' => false, 'message' => 'Question adding to Bookmark failed!');
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Bookmarked Questions
	*/
	function bookmarked_questions_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'subject_id' => 'Subject ID', 'topic_id' => 'Topic ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
		$response = $this->ws_model->bookmarked_questions($user_id, $course_id, $subject_id, $topic_id);
		//echo $this->db->last_query();
		if(empty((array)$response))
		{
			$response = array('status' => false, 'message' => 'No questions found!');	
		}
		else
		{
			$response = array('status' => true, 'message' => 'Questions Fetched Successfully!', 'response' => $response);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Quiz report list
	*/
	function quiz_report_list_get()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);		
		$response = get_table('quiz_reports_list');
		//echo $this->db->last_query();
		if(empty($response))
		{
			$response = array('status' => false, 'message' => 'No report list found!');	
		}
		else
		{
			$response = array('status' => true, 'message' => 'Report list Fetched Successfully!', 'response' => $response);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Answered Quiz Questions
	*/
	function answered_quiz_questions_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'subject_id' => 'Subject ID', 'topic_id' => 'Topic ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
		$response = $this->ws_model->answered_quiz_questions($user_id, $course_id, $subject_id, $topic_id);
		//echo $this->db->last_query();
		if(empty((array)$response))
		{
			$response = array('status' => false, 'message' => 'No questions found!');	
		}
		else
		{
			$response = array('status' => true, 'message' => 'Questions Fetched Successfully!', 'response' => $response);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	function answered_test_series_questions_post(){
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'category_id' => 'Category ID', 'quiz_id' => 'Quiz ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
        $response = $this->ws_model->answered_test_series_questions($user_id, $course_id, $category_id, $quiz_id);
        if(empty((array)$response))
		{
			$response = array('status' => false, 'message' => 'No questions found!');	
		}
		else
		{
			$response = array('status' => true, 'message' => 'Answers Fetched Successfully!', 'response' => $response);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	function data_analysis_piechart_post(){
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'category_id' => 'Category ID', 'quiz_id' => 'Quiz ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
        $response = $this->ws_model->answered_test_series_questions($user_id, $course_id, $category_id, $quiz_id);
        $getMarks=$this->ws_model->getMarks($quiz_id,$user_id);
        if(empty((array)$response))
		{
			$response = array('status' => false, 'message' => 'No questions found!');	
		}
		else
		{
			$question_count=0;$wrong=0;$correct=0;$guessed=0;$skipped=0;
			foreach ($response as $value) {
				$question_count++;
				switch ($value['answer_status']) {
					case 'correct':
						$correct++;
						break;
					case 'guessed':
						$guessed++;
						break;
					case 'skipped':
						$skipped++;
						break;
					default:
						$wrong++;
						break;
				}
			}
			usort($getMarks, function($a, $b) {
			    return $a['marks'] <=> $b['marks'];
			});
			$getMarks=array_reverse($getMarks);
			// var_dump($getMarks);die();
			$rank=1;$user_count=sizeof($getMarks);
			for($i=1; $i < $user_count ; $i++) {
				if ($getMarks[$i]['marks']!=$getMarks[$i-1]['marks']) {
					$rank++;
				}
				if($getMarks[$i]['user_id']==$user_id){
					$attempted=$getMarks[$i]['created_on'];
					break;
				}
			}
			$correct_percentage=number_format(($correct/$question_count)*100, 2);
			$guessed_percentage=number_format(($guessed/$question_count)*100, 2);
			$skipped_percentage=number_format(($skipped/$question_count)*100, 2);
			$wrong_percentage=number_format(($wrong/$question_count)*100, 2);
			$percentage=array('correct_percentage'=>$correct_percentage,'guessed_percentage'=>$guessed_percentage,'skipped_percentage'=>$skipped_percentage,'wrong_percentage'=>$wrong_percentage);
			$count=array('correct'=>$correct,'guessed'=>$guessed,'skipped'=>$skipped,'wrong'=>$wrong);
			$response = array('status' => true, 
							  'message' => 'Answers Fetched Successfully!', 
							  // 'response' => $response,
							  'count'=>$count,
							  'percentage'=>$percentage,
							  'rank'=>$rank,
							  'user_count'=>$user_count,
							  'attempted'=>$attempted
							);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	function data_analysis_allUsers_post(){
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'category_id' => 'Category ID', 'quiz_id' => 'Quiz ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
        $response = $this->ws_model->data_analysis_allUsers($user_id, $course_id, $category_id, $quiz_id);
        // var_dump($response);die();
        $getMarks=$this->ws_model->getMarks($quiz_id,$user_id);
        usort($getMarks, function($a, $b) {
		    return $a['marks'] <=> $b['marks'];
		});
		$getMarks=array_reverse($getMarks);
		$rank=1;$user_count=sizeof($getMarks);
		for($i=0; $i < $user_count-1 ; $i++) {
			if($getMarks[$i]['marks']!=$getMarks[$i+1]['marks']){
				$getMarks[$i]['rank']=$rank;
				$rank++;
			}
			else{
				$getMarks[$i]['rank']=$rank;	
			}
			foreach ($response as $value) {
				if($value['user_id']==$getMarks[$i]['user_id']){
					$getMarks[$i][$value['answer_status']]=$value['count'];
				}
			}
		}
		$getMarks[$i]['rank']=$rank;
		foreach ($response as $value) {
			if($value['user_id']==$getMarks[$i]['user_id']){
				$getMarks[$i][$value['answer_status']]=$value['count'];
			}
		}
		for($i=0; $i < $user_count ; $i++) {
			$getMarks[$i]['total_questions']=$getMarks[$i]['correct']+$getMarks[$i]['wrong']+$getMarks[$i]['guessed']+$getMarks[$i]['skipped'];
			if($getMarks[$i]['user_id']==$user_id){
				$userDetails=$getMarks[$i];
			}
		}
		$getMarks=array_slice($getMarks,0,3);
		$response = array('status' => true, 
							  'message' => 'Answers Fetched Successfully!', 
							  'userDetails' => $userDetails,
							  'user_count'=>$user_count,
							  'getMarks'=>$getMarks
							);
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	get_all_review_questions
	*/

	function get_all_review_questions_post(){
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'category_id' => 'Category ID', 'quiz_id' => 'Quiz ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
        $response = $this->ws_model->get_all_review_questions($user_id, $course_id, $category_id, $quiz_id);
        $response = array('status' => true, 
							  'message' => 'Answers Fetched Successfully!', 
							  'questions' => $response
							);
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	function get_status_review_questions_post(){
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'category_id' => 'Category ID', 'quiz_id' => 'Quiz ID','status'=>'Status');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
        $response = $this->ws_model->get_status_review_questions($user_id, $course_id, $category_id, $quiz_id,$status);
        $response = array('status' => true, 
							  'message' => 'Answers Fetched Successfully!', 
							  'questions' => $response
							);
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Test Series Categories
	*/
	function test_series_categories_get()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);		
		$response = get_table('test_series_categories', '', '', 'id', 'desc');
		//echo $this->db->last_query();
		if(empty($response))
		{
			$response = array('status' => false, 'message' => 'Categories not found!');	
		}
		else
		{
			$response = array('status' => true, 'message' => 'Categories fetched successfully!', 'response' => $response);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Test Series Quizs
	*/
	function test_series_quizs_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'category_id' => 'Category ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
		$response = $this->ws_model->test_series_quiz_dates($user_id, $course_id, $category_id);
		//echo $this->db->last_query();
		if(empty((array)$response))
		{
			$response = array('status' => false, 'message' => 'No tests found!');	
		}
		else
		{
			$response = array('status' => true, 'message' => 'Tests Fetched Successfully!', 'response' => $response);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Test series quiz Details
	*/
	function test_series_quiz_details_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'quiz_id'=>'Quiz ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
		$response = $this->ws_model->test_series_quiz_details($user_id, $quiz_id);		
		//echo $this->db->last_query();
		if(empty((array)$response))
		{
			$response = array('status' => false, 'message' => 'No topics found!');	
		}
		else
		{
			$response = array('status' => true, 'message' => 'Topic Fetched Successfully!', 'response' => $response);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Test Series Questions
	*/
	function test_series_questions_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'category_id' => 'Category ID', 'quiz_id' => 'Quiz ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
		$response = $this->ws_model->test_series_questions($user_id, $course_id, $category_id, $quiz_id, $count);
		//echo $this->db->last_query();
		if(empty((array)$response))
		{
			$response = array('status' => false, 'message' => 'No questions found!');	
		}
		else
		{
			$response = array('status' => true, 'message' => 'Questions Fetched Successfully!', 'response' => $response);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Submit Quiz Test
	*/
	function submit_test_series_answers_post()
	{
		$response = array('status' => false, 'message' => '');
		$user_input = $this->client_request;
		extract($user_input);
		$required_params = array('user_id'=>'User ID', 'course_id'=>'Course ID', 'category_id' => 'Category ID', 'quiz_id' => 'Quiz ID');
		foreach($required_params as $key => $value)
        {
        	if(!$user_input[$key])
			{
				$response = array('status' => false, 'message' => $value.' is required');
				TrackResponse($user_input, $response);
				$this->response($response);
			}
        }
        if(!empty($answers))
        {
        	$correct_answer_count = 0;
        	$wrong_answer_count = 0;
        	$skipped_answer_count = 0;
        	$guessed_answer_count = 0;
        	foreach($answers as $row)
        	{
        		if($row['answer_status'] == "correct")
        		{
        			$correct_answer_count++;
        		}
        		elseif($row['answer_status'] == "wrong")
        		{
        			$wrong_answer_count++;
        		}
        		elseif($row['answer_status'] == "skipped")
        		{
        			$skipped_answer_count++;
        		}
        		elseif($row['answer_status'] == "guessed"){
        			$guessed_answer_count++;
        		}
        		$data[] = array(
		        	'user_id' => $user_id,
		        	'course_id' => $course_id,
		        	'category_id' => $category_id,
		        	'quiz_id' => $quiz_id,
		        	'question_id' => $row['question_id'],
		        	'option_id' => $row['option_id'],
		        	'answer' => $row['answer'],
		        	'correct_answer' => $row['correct_answer'],
		        	'answer_status' => $row['answer_status'],
		        	'created_on' => date('Y-m-d H:i:s')
		        	);
        	}
        	$response = insert_table('test_series_answers', $data, '', true);        	
        	if($response > 0)
			{
				if($ratings)
				{
					$rating_data = array(
						'course_id' => $course_id,
			        	'category_id' => $category_id,
			        	'quiz_id' => $quiz_id,
			        	'ratings' => $ratings,
			        	'message' => $review,
			        	'created_on' => date('Y-m-d H:i:s')
						);
					insert_table('test_series_reviews', $rating_data);
				}
				$quiz_data=array(
					'user_id' => $user_id,
					'course_id' => $course_id,
					'category_id' => $category_id,
					'quiz_id' => $quiz_id,
					'marks'=>$correct_answer_count,
					'created_on' => date('Y-m-d H:i:s')
				);
				insert_table('test_series_marks', $quiz_data);
				$total_questions = $correct_answer_count + $wrong_answer_count + $skipped_answer_count+$reviewed_answer_count+$guessed_answer_count;

				$correct_percentage = $correct_answer_count / $total_questions * 100;
				$wrong_percentage = $wrong_answer_count / $total_questions * 100;
				$skipped_percentage = $skipped_answer_count / $total_questions * 100;
				$guessed_percentage = $guessed_answer_count / $total_questions * 100;

				$response = array(
					'correct_answer_count' => $correct_answer_count,
					'wrong_answer_count' => $wrong_answer_count,
					'skipped_answer_count' => $skipped_answer_count,
					'correct_percentage' => number_format($correct_percentage, 2),
					'wrong_percentage' => number_format($wrong_percentage, 2),
					'skipped_percentage' => number_format($skipped_percentage, 2),
					'guessed_percentage' => number_format($guessed_percentage, 2)
					);

				$response = array('status' => true, 'message' => 'Quiz submitted Successfully!', 'response' => $response);
			}
			else
			{
				$response = array('status' => false, 'message' => 'Quiz submission failed!');
			}
        }
        else
        {
        	$response = array('status' => false, 'message' => 'Quiz submission failed!');
        }
		TrackResponse($user_input, $response);
		$this->response($response);
	}
}
?>