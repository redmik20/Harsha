<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'libraries/RESTful/REST_Controller.php';

class Ws extends REST_Controller
{

    protected $client_request = NULL;

    function __construct()

    {
        //header('Access-Control-Allow-Origin: *');
        //header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        //$method = $_SERVER['REQUEST_METHOD'];
     
        parent::__construct();

        date_default_timezone_set("Asia/Kolkata");

        error_reporting(0);

        set_time_limit(0);

        //ini_set('memory_limit', '-1');

        /*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
        
//$this->load->helper('date');
        $this
            ->load
            ->helper('app/ws_helper');

        $this
            ->load
            ->model('app/ws_model');
        $this->load->model('app/wssub_model');

        $this
            ->load
            ->model('email_model');

        $this
            ->load
            ->helper('app/jwt_helper');

        $this
            ->load
            ->model('Common_model');


        $this->client_request = new stdClass();

        $this->client_request = json_decode(file_get_contents('php://input', true));

        $this->client_request = json_decode(json_encode($this->client_request) , true);

        //$this->check_user();

    }

    /*-------------------- User -----------------------*/

    function register_user_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => ""
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$mobile)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter Mobile Number!',
                'response' => ""
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        /*if (!$email_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter Email ID!',
                'response' => ""
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }*/

        if (!$password)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter Password!',
                'response' => ""
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (empty($exam_id))

        {

            $response = array(
                'status' => false,
                'message' => 'Enter exams id!',
                'response' => ""
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $check_mobile = check_user_mobile_exists($mobile);

        if (!empty($check_mobile))

        {

            $response = array(
                'status' => false,
                'message' => 'Mobile Number Already Exists!',
                'response' => ""
            );

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

        /*$check_email_id = check_user_email_id_exists($email_id);

        if (!empty($check_email_id))

        {

            $response = array(
                'status' => false,
                'message' => 'Email ID Already Exists!',
                'response' => ""
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }*/

        if ($otp_confirmed == "No")

        {

            $otp = mt_rand(100000, 999999);

            //$message = "<#> Dear User, $otp is One time password (OTP) for MOW. Thank You. QbwSot12oP";
            $message='<#> Dear User, '.$otp.' is One time password (OTP) for PLATO. Thank You. 
QbwSot12oP';

            SendSMS($mobile, $message);
            

            $response = array(
                'status' => true,
                'message' => 'Otp sent successfully!',
                'response' => "$otp"
            );

            TrackResponse($user_input, $response);

            $this->response($response);
            exit;

        }

        /*$mobiles_array=$this->ws_model->getMobilesArray();
        if(!in_array($mobile, $mobiles_array)){
                //echo 'Yes';exit;
                $response = array(
                'status' => false,
                'message' => 'Registration failed for This Number!',
                'response' => false
            );

            TrackResponse($user_input, $response);
            $this->response($response);
            exit;
        }*/

        $data = array(

            'name' => $name,

            'mobile' => $mobile,

            'email_id' => $email_id,

            'password' => md5($password) ,
            
            'location' => $location,
            'college'=>$college,

            'created_on' => date('Y-m-d H:i:s')

        );

        $user_id = insert_table('users', $data);

        if ($user_id == 0)

        {

            $response = array(
                'status' => false,
                'message' => 'User Registration Failed!',
                'response' => ""
            );

        }

        else

        {

            if (!empty($exam_id))

            {

                foreach ($exam_id as $e_id)

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

            $user_exams = $this
                ->ws_model
                ->user_exams($user_id);
            $this->ws_model->deleteUnRegisterUser($mobile);

            $response = array(
                'status' => true,
                'message' => 'User Registration Successful!',
                'response' => $users,
                'user_exams' => $user_exams
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*-------------------- /User -----------------------*/

    /*
    
    
    
    *   User Login
    
    
    
    */

    function user_login_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$mobile)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter Mobile Number!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$password)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter Password!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $user_deleted = $this
            ->ws_model
            ->check_user_deleted($mobile);

        if (empty($user_deleted))

        {

            $response = array(
                'status' => false,
                'message' => 'Not a registered Mobile Number!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $user_status = $this
            ->ws_model
            ->check_user_status($mobile);

        if (empty($user_status))

        {

            $response = array(
                'status' => false,
                'message' => 'Your account has been put on hold. Please contact Administrator!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $user_details = $this
            ->ws_model
            ->user_login($mobile, $password);

        //echo $this->db->last_query();exit;
        

        if (empty($user_details))

        {

            $response = array(
                'status' => false,
                'message' => 'Login Failed. Please try again!',
                'response' => array()
            );

        }

        else

        {

            $user_exams = $this
                ->ws_model
                ->user_exams($user_details['id']);

            //print_r($user_exams);
            

            $response = array(
                'status' => true,
                'message' => 'Login Successful!',
                'response' => $user_details,
                'user_exams' => $user_exams
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }
    
    /*
    
    *   otp service 
    
    */

    function userOtpService_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$mobile)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter Mobile Number!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        

        /*$user_deleted = $this
            ->ws_model
            ->check_user_deleted($mobile);

        if (empty($user_deleted))

        {

            $response = array(
                'status' => false,
                'message' => 'Not a registered Mobile Number!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }*/

        $user_status = $this
            ->ws_model
            ->check_user_statusForMobile($mobile);

        if (empty($user_status))

        {
            
            $otp = mt_rand(100000, 999999);

            //$message = "Dear User, $otp is One time password (OTP) for PLATO. Thank You.";
            $message='<#> Dear User, '.$otp.' is One time password (OTP) for PLATO. Thank You. 
QbwSot12oP';

            SendSMS($mobile, $message);

            $this->ws_model->insertUnRegisterUser($mobile,$otp);
            
            $response = array(
                'status' => true,
                'message' => 'New User',
                'response' => new stdClass(),
                'otp'=>$otp,
                'number_status'=>'no',
                'user_exams' => array(),
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $user_details = $this
            ->ws_model
            ->user_loginForMobile($mobile);



        //echo $this->db->last_query();exit;
        

        if (empty($user_details))

        {

            $response = array(
                'status' => false,
                'message' => 'Login Failed. Please try again!',
                'response' => array()
            );

        }

        else

        {

            //$user_exams = $this->ws_model->user_exams($user_details['id']);

            //print_r($user_exams);
            $otp = mt_rand(100000, 999999);

            $message = "Dear User, $otp is One time password (OTP) for PLATO. Thank You.";

            SendSMS($mobile, $message);

             $this->ws_model->updateLoginUserStatus($user_details['id']);
             $user_details = $this->ws_model->user_loginForMobile($mobile);

            $response = array(
                'status' => true,
                'message' => 'Login Successful!',
                'response' => $user_details,
                //'user_exams' => $user_exams,
                'number_status'=>'yes',
                'otp'=>  $otp
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }
     function logout_post(){


        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'User ID is Requried!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }
       $result=$this->ws_model->updateUserLogoutStatus($user_id);

            $response = array(
                'status' => true,
                'message' => 'Logout Successfully..',
                'response' => $result
            );


        TrackResponse($user_input, $response);

        $this->response($response);
     }

    function homepage_course_post()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $tackId=startApi($user_input);

        if (!$user_id)
        {
            $response = array(
                'status' => false,
                'message' => 'Enter user ID!',
                'response' => array()
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
        if (!$course_id)
        {
            $response = array(
                'status' => false,
                'message' => 'Enter course ID!',
                'response' => array()
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
       // echo $device_id;exit;
        if($device_id !=''){
            //echo $device_id;exit;
            $this->ws_model->updateUserDeviceId($user_id,$device_id);
        }

        if($android_device_id !=''){
            //echo $device_id;exit;
            $this->ws_model->updateUserAndroidDeviceId($user_id,$android_device_id);
        }

        $device_id=$this->ws_model->userDeviceId($user_id);
        //$android_device_id=$this->ws_model->userAndroidDeviceId($user_id);

        $banners = $this->ws_model->banners($course_id);
        $user_exams = $this->ws_model->user_exams($user_id,$course_id);
        /*$stats['user_videos'] = $this->ws_model->users_video($chapter_id, $user_id,$course_id);
        $stats['total_videos'] = $this->ws_model->total_videos($course_id);
        $stats['user_qbank'] = $this->ws_model->user_qbank($user_id,$course_id);
        $stats['total_qbank'] = $this->ws_model->total_qbank($course_id);
        $stats['user_test'] = $this->ws_model->user_test($user_id,$course_id);
        $stats['total_test'] = $this->ws_model->total_test($course_id);*/
       // $suggestedqbank = $this->ws_model->add_usersuggestqbank($user_id, $course_id);
       $suggestedqbank=$this->ws_model->getSuggestqbank($user_id, $course_id);
       $suggestedTestSeries=$this->ws_model->getSuggestedTestSeries($course_id,$user_id);
       
        $suggested_videos = $this->ws_model->add_usersuggest($course_id);
        //$pearlsList = $this->ws_model->latestPearlsList($course_id);

        $response = array(
            'status' => true,
            'message' => 'Data fetched Successful!',
            'user_exams' => $user_exams,
            'banners' => $banners,
            //'statusbar' => [$stats],
            'suggestedqbank' => $suggestedqbank,
            'suggested_videos' => $suggested_videos,
            'suggested_testseries' => $suggestedTestSeries,
            'device_id'=>$device_id['device_id'],
            'android_device_id'=>$device_id['android_device_id']
            //'pearlsList'=>$pearlsList,
        );
        TrackResponse($user_input, $response);
        endApi($tackId);
        $this->response($response);

    }

    function user_complete_video_topic_post()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        if (!$user_id)
        {

            $response = array(
                'status' => false,
                'message' => 'Enter user Number!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }
        if (!$video_topic_id)
        {

            $response = array(
                'status' => false,
                'message' => 'Enter topic ID!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);
        }
        else
        {
            $videodetails=get_table_row('user_topics',array('user_id'=>$user_id,'video_topic_id'=>$video_topic_id));
            if (empty($videodetails))
            {
                $array=array('user_id'=>$user_id,'video_topic_id'=>$video_topic_id,'topic_status'=>'completed');
                $insert_id=insert_table('user_topics', $array);
                $videodetails=get_table_row('user_topics',array('user_id'=>$user_id,'video_topic_id'=>$video_topic_id));
            }
            $response = array(
                'status' => true,
                'message' => 'Data fetched Successful!',
                'response'=>$videodetails
            );
        }
        TrackResponse($user_input, $response);

        $this->response($response);
    }

    function homepage_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter user Number!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$center_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter center Id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$batch_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter batch Id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if ($user_id == 0)

        {

            $response = array(
                'status' => false,
                'message' => 'User fetched Failed!',
                'response' => array()
            );

        }

        else

        {

            //$user_exams = $this->ws_model->user_exams($user_id);

            $user_exams = $this
                ->ws_model
                ->exams1($user_id,$center_id,$batch_id);

            $banners = $this
                ->ws_model
                ->banners();

      /*      $stats['user_videos'] = $this
                ->ws_model
                ->users_video($chapter_id, $user_id);

            $stats['total_videos'] = $this
                ->ws_model
                ->total_videos();

            $stats['user_qbank'] = $this
                ->ws_model
                ->user_qbank($user_id);

            $stats['total_qbank'] = $this
                ->ws_model
                ->total_qbank();

            $stats['user_test'] = $this
                ->ws_model
                ->user_test($user_id);

            $stats['total_test'] = $this
                ->ws_model
                ->total_test();*/

            $suggestedqbank = array();

            $suggested_videos = $this
                ->ws_model
                ->add_usersuggest($user_id);

            $response = array(
                'status' => true,
                'message' => 'Data fetched Successful!',
                'user_exams' => $user_exams,
                'banners' => $banners,
                'statusbar' => [$stats],
                'suggestedqbank' => $suggestedqbank,
                'suggested_videos' => $suggested_videos
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function add_usersuggestqbank_post()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;

        extract($user_input);
        if(!$user_id)
        {
            $response = array(
                'status' => false,
                'message' => 'Enter User Id!',
                'response' => array()
            );
            TrackResponse($user_input, $response);

            $this->response($response);
        }
        if(!$course_id)
        {
            $response = array(
                'status' => false,
                'message' => 'Enter Course Id!',
                'response' => array()
            );
            TrackResponse($user_input, $response);

            $this->response($response);
        }
        $response=$this->ws_model->add_usersuggestqbank($user_id, $course_id);
        $response = array(
            'status' => true,
            'message' => 'Data fetched Successful!',
            'response' => $response
        );
        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function update_device_token_post()
    {
        $response = array('status' => false, 'message' => '');
        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array('user_id'=>"User ID");
        foreach($required_params as $key => $value)
        {
            if(!$user_input[$key])
            {
                $response = array('status' => false, 'message' => $value.' is required');
                TrackResponse($user_input, $response);
                $this->response($response);
            }
        }
        $update_token = $this->ws_model->update_user_device_token($user_id, $android_token, $ios_token);
        //echo $this->db->last_query();exit;
        if(empty($update_token))
        {
            $response = array('status' => false, 'message' => 'Device Token updation failed!', 'response' => array());
        }
        else
        {
            $response = array('status' => true, 'message' => 'Device Token Updated Successfully!', 'response' => $update_token);
        }       
        TrackResponse($user_input, $response);      
        $this->response($response);
    }

    function add_user_exams_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (count($exam_id) == 0)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter Exam id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter User Id!',
                'response' => array()
            );

        }

        else

        {

            $user_exams = $this
                ->ws_model
                ->add_examsbyuser($user_id, $exam_id);

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'User exams added Successful!',
                'user_exams' => $user_exams
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Delete User by exams
    
    
    
    */

    function delete_user_exams_post() //check
    

    
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'User Id is required!'
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$exam_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Exam Name is required!'
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $delete_user = $this
            ->ws_model
            ->delete_user_exam($user_id, $exam_id);

        if ($delete_user === false)

        {

            $response = array(
                'status' => false,
                'message' => 'exam deletion Failed!'
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'exam deleted Successfully!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function exam_subjects_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

         if(!$user_id)
        

         {
        

          $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
        

          TrackResponse($user_input, $response);
        

          $this->response($response);
        

         }
        

        if (!$exam_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Exam ID is required!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $user_subjects = $this
            ->ws_model
            ->exam_subjects_new($exam_id,$user_id);

        if (empty((array)$user_subjects))

        {

            $response = array(
                'status' => false,
                'message' => 'No Subjects found!',
                'response' => array()
            );

        }

        else

        {

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'Subjects fetched Successfully!',
                'user_subjects' => $user_subjects
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function chaptervideomode_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$status)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter video status id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter user id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if ($status == 0)

        {

            $response = array(
                'status' => false,
                'message' => 'User fetched Failed!',
                'response' => array()
            );

        }

        elseif ($user_id == 0)

        {

            $response = array(
                'status' => false,
                'message' => 'User fetched Failed!',
                'response' => array()
            );

        }

        else

        {

            $chapter_video = $this
                ->ws_model
                ->video_mode($status);

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'User fetched Successful!',
                'chapter_video' => $chapter_video
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function plandetails_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        $plandetails = $this
            ->ws_model
            ->plandetails();

        if (empty($plandetails))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $plandetails
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function userplan_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter user Number!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if ($user_id == 0)

        {

            $response = array(
                'status' => false,
                'message' => 'User fetched Failed!',
                'response' => array()
            );

        }

        else

        {

            $user_plan = $this
                ->ws_model
                ->user_plan($user_id);

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'User fetched Successful!',
                'response' =>

                $user_plan
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   post User Details
    
    
    
    */

    function user_profile_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter user id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $user_details = user_by_id($user_id);

        //print_r($user_details);exit;
        

        //echo $this->db->last_query();exit;
        

        if (empty($user_details))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $user_details
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    public function submit_ratings_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter user id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        /*if(!$chapter_video_id)
        
        
        
        {
        
        
        
        $response = array('status' => false, 'message' => 'Enter chapter video id!', 'response' => array());
        
        
        
        TrackResponse($user_input, $response);
        
        
        
        $this->response($response);
        
        
        
        }*/

        if (!$rating)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter rating number!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if ($chapter_video_id != '')
        {

            $data = array(

                'user_id' => $user_id,

                'chapter_video_id' => $chapter_video_id,

                'rating' => $rating,

                'created_on' => date('Y-m-d H:i:s')

            );

        }

        else
        {

            $data = array(

                'user_id' => $user_id,

                'video_topics_id' => $video_topics_id,

                'rating' => $rating,

                'opinion' => $opinion,

                'feedback' => $feedback,

                'created_on' => date('Y-m-d H:i:s')

            );

        }

        $this
            ->db
            ->insert('ratings', $data);

        if ($chapter_video_id != '')
        {

            $user_ratings = $this
                ->ws_model
                ->user_ratings($chapter_video_id, $user_id);

        }
        else
        {

            $user_ratings = get_table('ratings', array(
                'video_topics_id' => $video_topics_id,
                'user_id' => $user_id
            ));

        }

        $response = array(
            'status' => true,
            'message' => 'Rating Submitted Successfully!',
            'response' => $user_ratings
        );

        $this->response($response);

    }

    function ucv_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter user Id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$subject_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter subject Id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$status)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter chapter status!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $data = array(

            'user_id' => $user_id,

            'subject_id' => $subject_id,

            'status' => $status

        );

        $demovideo = $this
            ->ws_model
            ->demosinglevideo($data);
        $chapter_status_list = $this
            ->ws_model
            ->chapter_status_list($data);

        $user_access_info = $this
            ->ws_model
            ->get_user_access($user_id);

        if (empty($chapter_status_list))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => [

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

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter user Id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$subject_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter subject Id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$status)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter chapter status!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $data = array(

            'user_id' => $user_id,

            'subject_id' => $subject_id,

            'status' => $status

        );

        $demovideo = $this
            ->ws_model
            ->demosinglevideos($data);

        $chapter_status_list = $this
            ->ws_model
            ->chapter_status_lists($data);

        $user_access_info = $this
            ->ws_model
            ->get_user_access($user_id);

        if (empty($chapter_status_list))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => [

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

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$topic_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter Topic Id!',
                'response' => array() ,
                'OTP' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $chapter_status_list = $this
            ->ws_model
            ->get_topic($topic_id);

        $total_questions = get_table_row('qbank', array(
            'video_topics_id' => $topic_id
        ) , array(
            'count(id) as count'
        ));

        $total_bookmarks = get_table_row('bookmarks', array(
            'topic_id' => $topic_id,
            'user_id' => $user_id
        ) , array(
            'count(id) as count'
        ));

        $exams = get_table_row('user_qbank', array(
            'topic_id' => $topic_id,
            'user_id' => $user_id
        ) , array(
            'count(id) as count'
        ));

        $ratings = get_table_row('ratings', array(
            'video_topics_id' => $topic_id,
            'user_id' => $user_id
        ) , array(
            'count(id) as count'
        ));

        if ($ratings['count'] != '0')
        {

            $ratings = "yes";

        }

        else
        {

            $ratings = "no";

        }

        if ($exams['count'] != '0')
        {

            $exams = "yes";

        }

        else
        {

            $exams = "no";

        }

        if (empty($chapter_status_list))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $chapter_status_list,
                'questions' => $total_questions['count'],
                'bookmarks' => $total_bookmarks['count'],
                'exam_attempted' => $exams,
                'rating_status' => $ratings
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function get_questions_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$topic_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter Topic Id!',
                'response' => array() ,
                'OTP' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $chapter_status_list = $this
            ->ws_model
            ->get_questions($topic_id, $from);

        //print_r($total_questions);exit;
        

        if (empty($chapter_status_list))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $chapter_status_list
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Submit Q bank Answers
    
    
    
    */

    function submit_qbank_answers_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => "User ID",
            'topic_id' => "Quizs ID",
            'answers' => "Answers"
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

        if (!empty($answers))

        {

            $correct_answer_count = 0;

            $wrong_answer_count = 0;

            foreach ($answers as $row)

            {

                if ($row['answer_status'] == "correct")

                {

                    $correct_answer_count++;

                }

                elseif ($row['answer_status'] == "wrong")

                {

                    $wrong_answer_count++;

                }

                elseif ($row['answer_status'] == "not answered")

                {

                    $not_answer_count++;

                }

                $reports = implode(',', $row['reports']);

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

            if ($response > 0)

            {

                $response = array(
                    'status' => true,
                    'message' => 'Q Bank submitted Successfully!',
                    'correct_answer_count' => $correct_answer_count,
                    'wrong_answer_count' => $wrong_answer_count,
                    'not_answer_count' => $not_answer_count
                );

            }

            else

            {

                $response = array(
                    'status' => false,
                    'message' => 'Q Bank submission failed!'
                );

            }

        }

        else

        {

            $response = array(
                'status' => false,
                'message' => 'Q Bank submission failed!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function add_bookmark_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$topic_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Topic Id Required!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'User Id Required!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$qbank_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Question bank Id Required!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $data = array(

            'user_id' => $user_id,

            'topic_id' => $topic_id,

            'qbank_id' => $qbank_id

        );

        $bookmarks = get_table_row('bookmarks', $data);

        //  print_r($bookmarks);exit;
        

        if (!empty($bookmarks))
        {

            $delete = delete_record('bookmarks', $data);

            $response = array(
                'status' => false,
                'message' => 'Bookmark Deleted successfully!',
                'response' => array()
            );

            $this->response($response);

        }

        else
        {

            $data['created_on'] = date('Y-m-d H:i:s');

            $user_id = insert_table('bookmarks', $data);

        }

        //print_r($total_questions);exit;
        

        if (empty($user_id))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Bookmark Added Successfully!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Get Right and Wrong Attempts
    
    
    
    */

    function right_wrong_attempts_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => "User ID",
            'topic_id' => "Topic ID"
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

        $all_answers = $this
            ->ws_model
            ->right_answers($user_id, $topic_id, 'all');

        $right_answers = $this
            ->ws_model
            ->right_answers($user_id, $topic_id, 'right');

        $wrong_answers = $this
            ->ws_model
            ->right_answers($user_id, $topic_id, 'wrong');

        $skipped_answers = $this
            ->ws_model
            ->right_answers($user_id, $topic_id, 'skipped');

        //echo $this->db->last_query();
        

        $response = array(
            'status' => true,
            'message' => 'Data fetched Successfully!',
            'all_answers' => $all_answers,
            'right_answers' => $right_answers,
            'wrong_answers' => $wrong_answers,
            'skipped_answers' => $skipped_answers,
            'total_marks' => count($right_answers) + count($wrong_answers) + count($skipped_answers) ,
            'right_answers_count' => count($right_answers)
        );

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Get analysis
    
    
    
    */

    function get_analysis_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => "User ID",
            'topic_id' => "Topic ID"
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

        $all_answers = $this
            ->ws_model
            ->right_answers($user_id, $topic_id, 'all');

        $right_answers = $this
            ->ws_model
            ->right_answers($user_id, $topic_id, 'right');

        $wrong_answers = $this
            ->ws_model
            ->right_answers($user_id, $topic_id, 'wrong');

        $skipped_answers = $this
            ->ws_model
            ->right_answers($user_id, $topic_id, 'skipped');

        $right_answerss = number_format(count($right_answers) / count($all_answers) * 100, 2) . '%';

        $wrong_answerss = number_format(count($wrong_answers) / count($all_answers) * 100, 2) . '%';

        $skipped_answerss = number_format(count($skipped_answers) / count($all_answers) * 100, 2) . '%';

        //echo $this->db->last_query();
        

        $response = array(
            'status' => true,
            'message' => 'Data fetched Successfully!',
            'right_answers' => $right_answerss,
            'wrong_answers' => $wrong_answerss,
            'skipped_answers' => $skipped_answerss,
            'total_marks' => count($right_answers) + count($wrong_answers) + count($skipped_answers) ,
            'right_answers_count' => count($right_answers)
        );

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function user_complete_chapter_post()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);
        if (!$chapter_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter chapter Id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$user_id)
        {
            $response = array(
                'status' => false,
                'message' => 'Enter user Id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }
        $update=update_table('user_chapters', array('chapter_status'=>'completed'), array('user_id' => $user_id,'chapter_id'=>$chapter_id));
        if($update)
        {
            $response = array(
                'status' => true,
                'message' => 'status updated Successfully'
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
        else
        {
            $response = array(
                'status' => true,
                'message' => 'status updated Already'
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
    }

    function all_chapters_post()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'user_id' => "User ID",
            'course_id'=>"Course ID",
            'subject_id' => "Subject ID"
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
        $chapter_list = $this
            ->ws_model
            ->get_all_chapters($subject_id, $user_id,$course_id);
        if(!empty($chapter_list))
        {
            $response = array(
                'status' => true,
                'message' => 'Data fetched Successfully',
                'response' => $chapter_list
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
        TrackResponse($user_input, $response);
        $this->response($response);
    }
    
    function free_chapters_post()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'user_id' => "User ID",
            'course_id'=>"Course ID",
            'subject_id' => "Subject ID"
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
        $chapter_list = $this
            ->ws_model
            ->free_chapters($subject_id, $user_id,$course_id);
        if(!empty($chapter_list))
        {
            $response = array(
                'status' => true,
                'message' => 'Data fetched Successfully',
                'response' => $chapter_list
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
        TrackResponse($user_input, $response);
        $this->response($response);
    }

    function allWebChapters_post()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'subject_id' => "Subject ID"
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
        $chapter_list = $this
            ->ws_model
            ->all_webchapters($subject_id);
        if(!empty($chapter_list))
        {
            $response = array(
                'status' => true,
                'message' => 'Data fetched Successfully',
                'response' => $chapter_list
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
        TrackResponse($user_input, $response);
        $this->response($response);
    }


    function status_chapters_post()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'user_id' => "User ID",
            'course_id'=>"Course ID",
            'subject_id' => "Subject ID",
            'status'=>"Status"
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
        $chapter_list = $this
            ->ws_model
            ->status_chapters($subject_id, $user_id,$course_id,$status);
        if(!empty($chapter_list))
        {
            $response = array(
                'status' => true,
                'message' => 'Data fetched Successfully',
                'response' => $chapter_list
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
        TrackResponse($user_input, $response);
        $this->response($response);
    }

    function unseen_chapters_post()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'user_id' => "User ID",
            'course_id'=>"Course ID",
            'subject_id' => "Subject ID"
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
        $chapter_list = $this
            ->ws_model
            ->unseen_chapters1($subject_id, $user_id,$course_id);
        if(!empty($chapter_list))
        {
            $response = array(
                'status' => true,
                'message' => 'Data fetched Successfully',
                'response' => $chapter_list
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
        TrackResponse($user_input, $response);
        $this->response($response);
    }


    function singlechaptervideo_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$chapter_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter chapter Id!',
                'response' => array() ,
                'OTP' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter user Id!',
                'response' => array() ,
                'OTP' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $chapter_status_list = $this
            ->ws_model
            ->chapter_videodetails($chapter_id, $user_id);
        $chapterhistory=get_table_row('user_chapters',array('user_id'=>$user_id,'chapter_id'=>$chapter_id));
        if(empty($chapterhistory))
        {
            $array=array('user_id'=>$user_id,'chapter_id'=>$chapter_id,'chapter_status'=>'paused');
            $insert_id=insert_table('user_chapters', $array);
        }
        if (empty($chapter_status_list))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $chapter_status_list
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }



public function sendOtpPlayVideo_get(){
       $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        $chapter_id=$_GET['chapter_id'];
        $user_id=$_GET['user_id'];

        if (!$chapter_id){

            $response = array(
                'status' => false,
                'message' => 'Enter chapter Id!',
                'response' => array() ,
                'OTP' => array()
            );

            TrackResponse($user_input, $response);
            $this->response($response);

        }
    if (!$user_id){

            $response = array(
                'status' => false,
                'message' => 'Enter user Id!',
                'response' => array() ,
                'OTP' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $chapter_status_list = $this
            ->ws_model
            ->sendDetailsToVideoApi($chapter_id, $user_id);


        if (empty($chapter_status_list))
        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $chapter_status_list
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Change Password
    
    
    
    */

    function user_update_password_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$user_id || !$password)

        {

            $response = array(
                'status' => false,
                'message' => 'User Id or Password not found!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $data = array(

            'password' => md5($password) ,

            'modified_on' => date('Y-m-d H:i:s')

        );

        $update_user = $this
            ->ws_model
            ->update_user($data, $user_id);

        //echo $this->db->last_query();exit;
        

        if ($update_user === false)

        {

            $response = array(
                'status' => false,
                'message' => 'Password Updation Failed!',
                'response' => array()
            );

        }

        else

        {

            //SendSMS($mobile, 'Dear Customer '.$rand.' is your One Time Password for Poprebates. Thank You.');
            

            $user_details = user_by_id($user_id);

            $response = array(
                'status' => true,
                'message' => 'Password Updation Successful!',
                'response' => $user_details
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function faq_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        $user_faq = $this
            ->ws_model
            ->user_faq($user_id);

        if (empty($user_faq))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'User fetched Successful!',
                'user_faq' => $user_faq
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    public function studentsupport_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter user id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$issue)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter issue id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$description)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter description id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $data = array(

            'user_id' => $user_id,

            'issue' => $issue,

            'description' => $description,

            'created_on' => date('Y-m-d H:i:s')

        );

        $this
            ->db
            ->insert('student_support', $data);

        $student_support = $this
            ->ws_model
            ->student_support($user_id);

        $response = array(
            'status' => true,
            'message' => 'Message Submitted Successfully!',
            'response' => $student_support
        );

        $this->response($response);

    }

    public function notifications_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        $user_notifications = $this
            ->ws_model
            ->user_notifications();

        //echo $this->db->last_query();exit;
        

        if (empty($user_notifications))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $user_notifications
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function chapterslides_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$chapter_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter chapter Id!',
                'response' => array() ,
                'OTP' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        /*if(!$user_id)
        
        
        
        {
        
        
        
        $response = array('status' => false, 'message' => 'Enter user Id!', 'response' => array(), 'OTP' => array());
        
        
        
        TrackResponse($user_input, $response);
        
        
        
        $this->response($response);
        
        
        
        
        
        
        
        }*/

        $user_slides = $this
            ->ws_model
            ->user_slides($chapter_id);

        if (empty($user_slides))

        {

            $response = array(
                'status' => false,
                'message' => 'No slides are available as free to show you',
                'response' => array()
            );

        }

        else

        {

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'Chapter Slides fetched Successful!',
                'response' => $user_slides
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function chapternotes_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$chapter_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter chapter Id!',
                'response' => array() ,
                'OTP' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $chapter_notes = $this
            ->ws_model
            ->user_notes($chapter_id);

        if (empty($chapter_notes))

        {

            $response = array(
                'status' => false,
                'message' => 'No data found',
                'response' => array()
            );

        }

        else

        {

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'User fetched Successful!',
                'response' => $chapter_notes
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    public function otherloginmethods_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$email_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter Email ID!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$password)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter Password!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $user_deleted = $this
            ->ws_model
            ->check_userotherlogin_deleted($email_id);

        if (empty($user_deleted))

        {

            $response = array(
                'status' => false,
                'message' => 'Not a registered Email ID!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $user_status = $this
            ->ws_model
            ->check_userotherlogin_status($email_id);

        if (empty($user_status))

        {

            $response = array(
                'status' => false,
                'message' => 'Your account has been put on hold. Please contact Administrator!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $user_details = $this
            ->ws_model
            ->user_otherlogin($email_id, $password);

        //echo $this->db->last_query();exit;
        

        if (empty($user_details))

        {

            $response = array(
                'status' => false,
                'message' => 'Login Failed. Please try again!',
                'response' => array()
            );

        }

        else

        {

            $user_exams = $this
                ->ws_model
                ->user_exams($user_details['id']);

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'Login Successful!',
                'response' => $user_details,
                'user_exams' => $user_exams
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    public function exams_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        $user_exams = $this
            ->ws_model
            ->examslist($user_id);

        //echo $this->db->last_query();exit;
        

        if (empty($user_exams))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $user_exams
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    public function subjects_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);
        
        if (!$user_id)
        {

            $response = array(
                'status' => false,
                'message' => 'User ID is Missing',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$exam_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Please Select exam',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $user_subjects = $this
            ->ws_model
            ->subjects($exam_id);
$user_subjects1=array();
        //echo $this->db->last_query();exit;
        if(!empty($user_subjects)){
            
            foreach($user_subjects as $key=>$sub){
                
                 if($sub->video_ids !=''){
                  $chapter_ids=explode(',',$sub->video_ids);
                     foreach($chapter_ids as $chap){
                        $result= $this->ws_model->getVedioSeenCount($user_id,$chap);
                        //echo '<pre>';print_r($result);exit;
                        $seenVedioCount +=count($result);
                        
                     }
                     //echo '<pre>';print_r($seenVedioCount);exit;
                 }
                
            
            $user_subjects1[$key]=$sub;
            $user_subjects1[$key]->seenVedioCount=$seenVedioCount;
            unset($seenVedioCount);
            }
            
        }
        

        if (empty($user_subjects1))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $user_subjects1
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   User Forgot Password
    
    
    
    */

    function user_forgot_password_post()

    {

        $response = array(
            'status' => true,
            'message' => '',
            'response' => array() ,
            'OTP' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        $user_deleted = $this
            ->ws_model
            ->check_anyuser_deleted($mobile, $email_id);

        if (empty($user_deleted))

        {

            $response = array(
                'status' => false,
                'message' => 'Not a registered Mobile Number or email_id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $user_status = $this
            ->ws_model
            ->check_anyuser_status($mobile, $email_id);

        if (empty($user_status))

        {

            $response = array(
                'status' => true,
                'message' => 'Your account has been put on hold. Please contact Administrator!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if ($email_id != '')
        {

            $user_details = check_user_input_exists($mobile, $email_id);

            //echo $this->db->last_query();
            

            $rand = mt_rand(100000, 999999);

            $otp = array(
                'otp' => $rand
            );

            if (empty($user_details))

            {

                $response = array(
                    'status' => true,
                    'message' => 'Email Id not registered!',
                    'response' => array() ,
                    'OTP' => array()
                );

            }

            else
            {

                $config = Array(

                    'protocol' => 'smtp',

                    'smtp_host' => 'ssl://smtp.gmail.com',

                    'smtp_port' => 465,

                    'smtp_user' => 'shravankumar.p@iprismtech.com',

                    'smtp_pass' => '8099717519',

                    'mailtype' => 'html',

                    'charset' => 'iso-8859-1',

                    'wordwrap' => true

                );

                $msg = 'Dear Customer ' . $rand . ' is your One Time Password for Education. Thank You.



            ';

                $this
                    ->load
                    ->library('email', $config);

                $this
                    ->email
                    ->set_newline("\r\n");

                $this
                    ->email
                    ->from('mprabhudeep@gmail.com', 'jj');

                $this
                    ->email
                    ->to($email_id);

                $this
                    ->email
                    ->subject('Reset Password');

                $this
                    ->email
                    ->message($msg);

                if ($this
                    ->email
                    ->send())

                {

                    $response = array(
                        'status' => true,
                        'message' => 'Data Fetched Successfully!',
                        'response' => $user_deleted,
                        'OTP' => $otp
                    );

                }

                else

                {

                    $response = array(
                        'status' => true,
                        'message' => 'Mail Sending Failed!',
                        'response' => array() ,
                        'OTP' => array()
                    );

                    //echo $this->email->print_debugger();
                    

                    
                }

            }

        }

        else
        {

            $user_details = check_user_input_exists($mobile, $email_id);

            //echo $this->db->last_query();
            

            $rand = mt_rand(100000, 999999);

            $otp = array(
                'otp' => $rand
            );

            if (empty($user_details))

            {

                $response = array(
                    'status' => true,
                    'message' => 'Mobile Number not registered!',
                    'response' => array() ,
                    'OTP' => array()
                );

            }

            else

            {

                $Message = 'Dear Customer ' . $rand . ' is your One Time Password for Education. Thank You.';

                SendSMS($mobile, $Message);

                $response = array(
                    'status' => true,
                    'message' => 'Data Fetched Successfully!',
                    'response' => $user_deleted,
                    'OTP' => $otp
                );

            }

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Update User Profile
    
    
    
    */

    function faculty_info_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$exam_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Please Select  Exam !',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if ($exam_id == 0)

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found',
                'response' => array()
            );

        }

        else

        {

            $user_faculty = $this
                ->ws_model
                ->user_faculty($exam_id);

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'User fetched Successful!',
                'response' => $user_faculty
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function videotime_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$chapter_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter chapter video id Number!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if ($chapter_id == 0)

        {

            $response = array(
                'status' => false,
                'message' => 'User fetched Failed!',
                'response' => array()
            );

        }

        else

        {

            $timedetails = $this
                ->ws_model
                ->videotimes($chapter_id);

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'User fetched Successful!',
                'View_Details' => $timedetails
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function videotimes_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$chapter_video_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter exam Number!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if ($exam_id == 0)

        {

            $response = array(
                'status' => false,
                'message' => 'User fetched Failed!',
                'response' => array()
            );

        }

        else

        {

            $user_faq = $this
                ->ws_model
                ->user_faculty($exam_id);

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'User fetched Successful!',
                'user_faq' => $user_faq
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function subject_chapters_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$exam_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter subject Number!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$subject_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter exam id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if ($subject_id == 0)

        {

            $response = array(
                'status' => false,
                'message' => 'User fetched Failed!',
                'response' => array()
            );

        }

        else

        {

            $user_subjects = $this
                ->ws_model
                ->subject_chapters($subject_id);

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'User fetched Successful!',
                'user_subjects' => $user_subjects
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function planinfo_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter user Number!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $user_plan = $this
            ->ws_model
            ->user_plan($user_id);

        $proplans = $this
            ->ws_model
            ->proplansdetails();

        $induvidualplans = $this
            ->ws_model
            ->induvidualplandetails();

        if (empty($proplans) && empty($induvidualplans))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'proplans' => array() ,
                'induvidualplans' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'ProPlans' => $proplans,
                'InduvidualPlans' =>

                $induvidualplans,
                'Myplans' => $user_plan
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function paticularplan_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$plan_details_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter  plan details id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if ($plan_details_id == 0)

        {

            $response = array(
                'status' => false,
                'message' => 'User fetched Failed!',
                'response' => array()
            );

        }

        else

        {

            $user_planinfo = $this
                ->ws_model
                ->user_plandetails($plan_details_id);

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'User fetched Successful!',
                'response' =>

                $user_planinfo
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Update User Profile
    
    
    
    */

    function update_user_profile_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        $new_data = [];

        if ($name)
        {

            $new_data['name'] = $name;

        }

        /*if ($mobile)
        {

            $new_data['mobile'] = $mobile;

        }*/

        if ($email_id)
        {
            $email_exists=$this->ws_model->getUserEmailExists($user_id,$email_id);
            if(!empty($email_exists)){
                $response = array(
                    'status' => false,
                    'message' => 'Email Id already Exists!'
                );

                TrackResponse($user_input, $response);
                $this->response($response);
            }
            $new_data['email_id'] = $email_id;

        }

        $image_data = array(

            'upload_path' => './storage/pdfs/',

            'file_path' => 'storage/pdfs/'

        );

        if ($image)

        {

            $image_data['image'] = $image;

            $image_result = $this
                ->Common_model
                ->upload_image($image_data);

            if (!$image_result['status'])

            {

                $response = array(
                    'status' => false,
                    'message' => 'Image saving is unsuccessful!'
                );

                TrackResponse($user_input, $response);

                $this->response($response);

            }

            else

            {

                $profile = $image_result['result'];

            }

        }

        if ($image)

        {

            $new_data['image'] = $profile;

        }

        if ($gender)

        {

            $new_data['gender'] = $gender;

        }

        $new_data['modified_on'] = date('Y-m-d H:i:s');

        $update_user = $this
            ->ws_model
            ->update_user($new_data, $user_id);

        if ($update_user === false)

        {

            $response = array(
                'status' => false,
                'message' => 'User Updation Failed!',
                'response' => array()
            );

        }

        else

        {

            //SendSMS($mobile, 'Dear Customer '.$rand.' is your One Time Password for Poprebates. Thank You.');
            

            $user_details = user_by_id($user_id);

            //$user_details['otp'] = mt_rand(100000, 999999);

            //print_r($user_details);exit;
            

            $response = array(
                'status' => true,
                'message' => 'User Updation Successful!',
                'response' => $user_details
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function change_password_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'user Id is required!'
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$oldpassword)

        {

            $response = array(
                'status' => false,
                'message' => 'old password is required!'
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$newpassword)

        {

            $response = array(
                'status' => false,
                'message' => 'new password is required!'
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $result = $this
            ->ws_model
            ->change_password($oldpassword, $newpassword, $user_id);

        if ($result)
        {

            $response = array(
                'status' => true,
                'message' => 'Password Changed Successful!',
                'change password' => $result
            );

        }
        else
        {

            $response = array(
                'status' => false,
                'message' => 'Incorrect old password!',
                'change password' => $result
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function subscribe_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$plan_details_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter  plan details id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if ($plan_details_id == 0)

        {

            $response = array(
                'status' => false,
                'message' => 'No data found',
                'response' => array()
            );

        }

        else

        {

            $subscribe = $this
                ->ws_model
                ->subscribe($plan_details_id);

            //echo $this->db->last_query();exit;
            

            $response = array(
                'status' => true,
                'message' => 'Your pay!',
                'response' =>

                $subscribe
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function add_to_userexams_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        $data = array(

            'user_id' => $user_id,

            'exam_id' => $exam_id,

            'created_on' => date('Y-m-d H:i:s')

        );

        $add_to_favourites = $this
            ->ws_model
            ->add_to_favourites($data);

        if ($add_to_favourites == 1)

        {

            $response = array(
                'status' => true,
                'query' => 'insert',
                'message' => 'Exam added!'
            );

        }

        elseif ($add_to_favourites == 0)

        {

            $response = array(
                'status' => true,
                'response' => 'delete',
                'message' => 'Exam removed!'
            );

        }

        else

        {

            $response = array(
                'status' => false,
                'message' => 'Updation Failed!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function user_selectedexams_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter  user id!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $userselected_exams = $this
            ->ws_model
            ->userselected_exams($user_id);

        if (empty($userselected_exams))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $userselected_exams
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function forgot_resend_otp_post()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$mobile)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter Mobile Number!'
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $details = $this
            ->ws_model
            ->get_table_row('users', array(
            'mobile' => $mobile,
            'delete_status' => 1
        ) , array());

        if (empty($details))

        {

            $response = array(
                'status' => false,
                'message' => 'This mobile number is not registered with us!'
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $otp = mt_rand(100000, 999999);

        if (empty($details))

        {

            $response = array(
                'status' => false,
                'message' => 'Otp Sending Failed!'
            );

        }

        else

        {

            $Message = 'Dear Customer ' . $otp . ' is your One Time Password for Master of Wedding. Thank You.';

            SendSMS($mobile, $Message);

            $response = array(
                'status' => true,
                'message' => 'Otp send Successful!',
                'response' => $details,
                'otp' => $otp
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Quiz Topics
    
    
    
    */

    function quiz_topics_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID'
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

        //$response = $this->ws_model->quiz_topics($user_id, $course_id, $subject_id, $count);
        $response1 = $this->ws_model->getQbankTopicsWithStatus($user_id, $course_id, $subject_id,'0');

        //echo $this->db->last_query();
        /*$new_response=array();
        if(!empty($response)){
            foreach($response as $key=>$value){
                $new_response[$key]=$value;
                $new_response[$key]['pdf_path']=$value['pdf_path'];
            }
        }
        $response=$new_response;*/
        if (empty($response))

        {

            $response = array(
                'status' => false,
                'message' => 'No topics found!'
            );

        }

        else

        {

           

            $response = array(
                'status' => true,
                'message' => 'Topics Fetched Successfully!',
                'response' => $response1
                
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Quiz Topics finished
    
    
    
    */

    function quiz_topics_finished_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID'
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

        $response = $this
            ->ws_model
            ->quiz_topics_finished($user_id, $course_id, $subject_id, $count);

        if (empty($response))

        {

            $response = array(
                'status' => false,
                'message' => 'No topics found!'
            );

        }

        else

        {

            $topics_count = 0;
            $questions_count = 0;

            foreach ($response as $ckey=>$value)
            {

                $topics_count++;
             if(!empty($value['topics_array'])){
                foreach($value['topics_array'] as $tkey=>$tvalue){
                        if ($tvalue['questions_count'] > 0)
                        {
                            $questions_count = $tvalue['questions_count'] + $questions_count;
                        }
                    }
               }


            }

            $topics_count = array(

                'chapters_count' => $topics_count,

                'questions_count' => $questions_count

            );

            $response = array(
                'status' => true,
                'message' => 'Topics Fetched Successfully!',
                'response' => $response,
                'count' => $topics_count
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }


    /*
    
    
    
    *   Quiz Topics Unfininshed
    
    
    
    */

    function quiz_topics_pasued_post()
    {
        $response = array(
            'status' => false,
            'message' => ''
        );
        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID'
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
        $response = $this
            ->ws_model
            ->quiz_topics_pasued($user_id, $course_id, $subject_id, $count);
        if (empty($response))

        {

            $response = array(
                'status' => false,
                'message' => 'No topics found!'
            );

        }
        else

        {

            $topics_count = 0;
            $questions_count = 0;

            foreach ($response as $ckey=>$value)
            {

                $topics_count++;
             if(!empty($value['topics_array'])){
                foreach($value['topics_array'] as $tkey=>$tvalue){
                        if ($tvalue['questions_count'] > 0)
                        {
                            $questions_count = $tvalue['questions_count'] + $questions_count;
                        }
                    }
               }


            }

            $topics_count = array(

                'chapters_count' => $topics_count,

                'questions_count' => $questions_count

            );

            $response = array(
                'status' => true,
                'message' => 'Topics Fetched Successfully!',
                'response' => $response,
                'count' => $topics_count
            );

        }
        TrackResponse($user_input, $response);

        $this->response($response);

    }

 function quiz_topics_unattempt_post()
    {
        $response = array(
            'status' => false,
            'message' => ''
        );
        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID'
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
        $response = $this
            ->ws_model
            ->quiz_topics_unattempt($user_id, $course_id, $subject_id, $count);
        if (empty($response))

        {

            $response = array(
                'status' => false,
                'message' => 'No topics found!'
            );

        }
        else

        {

            $topics_count = 0;
            $questions_count = 0;

            foreach ($response as $ckey=>$value)
            {

                $topics_count++;
             if(!empty($value['topics_array'])){
                foreach($value['topics_array'] as $tkey=>$tvalue){
                        if ($tvalue['questions_count'] > 0)
                        {
                            $questions_count = $tvalue['questions_count'] + $questions_count;
                        }
                    }
               }


            }

            $topics_count = array(

                'chapters_count' => $topics_count,

                'questions_count' => $questions_count

            );

            $response = array(
                'status' => true,
                'message' => 'Topics Fetched Successfully!',
                'response' => $response,
                'count' => $topics_count
            );

        }
        TrackResponse($user_input, $response);

        $this->response($response);

    }


    /*
    
    
    
    *   Quiz Topics free
    
    
    
    */

    function quiz_topics_free_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID'
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

        $response = $this
            ->ws_model
            ->quiz_topics_free($user_id, $course_id, $subject_id, $count);

        // var_dump($response);die();
        

        if (empty($response))

        {

            $response = array(
                'status' => false,
                'message' => 'No topics found!'
            );

        }

        else

        {

            $topics_count = 0;
            $questions_count = 0;

            foreach ($response as $ckey=>$value)
            {

                $topics_count++;
             if(!empty($value['topics_array'])){
                foreach($value['topics_array'] as $tkey=>$tvalue){
                        if ($tvalue['questions_count'] > 0)
                        {
                            $questions_count = $tvalue['questions_count'] + $questions_count;
                        }
                    }
               }


            }

            $topics_count = array(

                'chapters_count' => $topics_count,

                'questions_count' => $questions_count

            );

            $response = array(
                'status' => true,
                'message' => 'Topics Fetched Successfully!',
                'response' => $response,
                'count' => $topics_count
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Quiz Topic Details
    
    
    
    */

    function quiz_topic_details_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'qbank_topic_id' => 'Qbank Topic ID'
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

        $response = $this
            ->ws_model
            ->quiz_topic_details($user_id, $qbank_topic_id);

        //echo $this->db->last_query();
        

        if (empty((array)$response))

        {

            $response = array(
                'status' => false,
                'message' => 'No topics found!'
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Topic Fetched Successfully!',
                'response' => $response
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Quiz Questions
    
    
    
    */

    function quiz_questions_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID',
            'topic_id' => 'Topic ID',
            'qbank_topic_id'=>'Qbank Topic ID'
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

        $response = $this
            ->ws_model
            ->quiz_questions_new($user_id, $course_id, $subject_id, $topic_id, $qbank_topic_id,$count);

        //echo $this->db->last_query();
        

        if (empty((array)$response))

        {

            $response = array(
                'status' => false,
                'message' => 'No questions found!'
            );

        }

        else

        {

            $this->ws_model->insertQuizUserStatus($user_id, $course_id, $subject_id, $topic_id, $qbank_topic_id);
            $response = array(
                'status' => true,
                'message' => 'Questions Fetched Successfully!',
                'response' => $response
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }


    function quiz_questions_unfinished_post()
    {
        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID',
            'topic_id' => 'Topic ID',
            'qbank_topic_id'=> 'Qbank Topic ID'
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
        $response = $this
            ->ws_model
            ->quiz_questions_unfinished($user_id, $course_id, $subject_id, $topic_id, $qbank_topic_id,$count);
        if (empty((array)$response))

        {

            $response = array(
                'status' => false,
                'message' => 'No questions found!'
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Questions Fetched Successfully!',
                'response' => $response
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);
    }


    /*
    
    
    
    *   Submit Quiz Test
    
    
    
    */

    function submit_quiz_tests1_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID',
            'topic_id' => 'Topic ID',
            'qbank_topic_id'=>'Qbank Topic ID'
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

        if (!empty($answers))

        {

            $correct_answer_count = 0;

            $wrong_answer_count = 0;

            $skipped_answer_count = 0;

            foreach ($answers as $row)

            {

                if ($row['answer_status'] == "correct")

                {

                    $correct_answer_count++;

                }

                elseif ($row['answer_status'] == "wrong")

                {

                    $wrong_answer_count++;

                }

                elseif ($row['answer_status'] == "skipped")

                {

                    $skipped_answer_count++;

                }
                
             $this->ws_model->deleteQuizAnswers($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id,$row['question_id']);
                
                $data[] = array(

                    'user_id' => $user_id,

                    'course_id' => $course_id,

                    'subject_id' => $subject_id,

                    'topic_id' => $topic_id,

                    'qbank_topic_id'=>$qbank_topic_id,
                    
                    'question_order_id'=>$row['question_order_id'],

                    'question_id' => $row['question_id'],

                    'option_id' => $row['option_id'],

                    'answer' => $row['answer'],

                    'correct_answer' => $row['correct_answer'],

                    'answer_status' => $row['answer_status'],

                    'created_on' => date('Y-m-d H:i:s')

                );
                //$response=$this->ws_model->submitQbankAnswers($data);

            }

            //$response = insert_table('quiz_answers', $data, '', true);
            $response=$this->db->insert_batch('quiz_answers', $data);

            $this->ws_model->updateQuizUserStatus($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id);

            if ($response > 0)

            {

               if($ratings)
               {
                $this->ws_model->deleteTopicRatings($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id);

                    $rating_data = array(
                        
                        'user_id'   => $user_id,

                        'course_id' => $course_id,

                        'subject_id' => $subject_id,

                        'topic_id' => $topic_id,

                        'qbank_topic_id'=>$qbank_topic_id,

                        'ratings' => $ratings,

                        'message' => $review,

                        'feedback' => $feedback,

                        'created_on' => date('Y-m-d H:i:s')

                    );

                    $rating_insert = insert_table('quiz_topic_reviews', $rating_data);
                }

                $total_questions = $correct_answer_count + $wrong_answer_count + $skipped_answer_count;

                $correct_percentage = $correct_answer_count / $total_questions * 100;

                $wrong_percentage = $wrong_answer_count / $total_questions * 100;

                $skipped_percentage = $skipped_answer_count / $total_questions * 100;

                $response = array(

                    'correct_answer_count' => $correct_answer_count,

                    'wrong_answer_count' => $wrong_answer_count,

                    'skipped_answer_count' => $skipped_answer_count,

                    'correct_percentage' => number_format($correct_percentage, 2) ,

                    'wrong_percentage' => number_format($wrong_percentage, 2) ,

                    'skipped_percentage' => number_format($skipped_percentage, 2)

                );

                $response = array(
                    'status' => true,
                    'message' => 'Quiz submitted Successfully!',
                    'response' => $response
                );

            }

            else

            {

                $response = array(
                    'status' => false,
                    'message' => 'Quiz submission failed!'
                );

            }

        }

        else

        {

            $response = array(
                'status' => false,
                'message' => 'Quiz submission failed!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }



    function submit_quiz_tests_post(){

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID',
            'topic_id' => 'Topic ID',
            'qbank_topic_id'=>'Qbank Topic ID'
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

        if (!empty($answers))

        {

            $correct_answer_count = 0;

            $wrong_answer_count = 0;

            $skipped_answer_count = 0;

            $this->ws_model->deleteQuizAnswersnew($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id);


            foreach ($answers as $row)
            {
                if ($row['answer_status'] == "correct")
                {
                    $correct_answer_count++;
                }
                elseif ($row['answer_status'] == "wrong")
                {
                    $wrong_answer_count++;
                }
                elseif ($row['answer_status'] == "skipped")
                {
                    $skipped_answer_count++;
                }  



                /*$data[] = array(

                    'user_id' => $user_id,

                    'course_id' => $course_id,

                    'subject_id' => $subject_id,

                    'topic_id' => $topic_id,

                    'qbank_topic_id'=>$qbank_topic_id,
                   
                    'question_order_id'=>$row['question_order_id'],

                    'question_id' => $row['question_id'],

                    'option_id' => $row['option_id'],

                    'answer' => $row['answer'],

                    'correct_answer' => $row['correct_answer'],

                    'answer_status' => $row['answer_status'],

                    'created_on' => date('Y-m-d H:i:s'),


                );*/
                $submit_data[$row['question_id']]=array(

                    'question_order_id'=>$row['question_order_id'],

                    'question_id' => $row['question_id'],

                    'option_id' => $row['option_id'],

                    'answer' => $row['answer'],

                    'correct_answer' => $row['correct_answer'],

                    'answer_status' => $row['answer_status'],

                            );
                

            }

            $submit_questions_json=json_encode($submit_data);
           

            $data = array(

                          'user_id' => $user_id,
                          'course_id' => $course_id,
                          'subject_id' => $subject_id,
                          'topic_id' => $topic_id,
                          'qbank_topic_id'=>$qbank_topic_id,
                          'submit_json'=> $submit_questions_json,
                          'created_on'=> date('Y-m-d H:i:s')
                         );
             //echo '<pre>';print_r($data);exit;
            $response=$this->db->insert('quiz_answers_json', $data);

            $this->ws_model->updateQuizUserStatus($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id);

            if ($response > 0)

            {

               if($ratings)
               {
                  $checkstatus=$this->ws_model->checkTopicRatings($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id);
                 
                if($checkstatus>0)
                {
                $rating_data_update = array(
                                       
                                       

                                        'ratings' => $ratings,

                                        'message' => $review,

                                        'feedback' => $feedback,

                                        'created_on' => date('Y-m-d H:i:s')

                                    );
                $this->ws_model->updateTopicRatings($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id,$rating_data_update);
                } else {
                    $rating_data = array(
                       
                        'user_id'   => $user_id,

                        'course_id' => $course_id,

                        'subject_id' => $subject_id,

                        'topic_id' => $topic_id,

                        'qbank_topic_id'=>$qbank_topic_id,

                        'ratings' => $ratings,

                        'message' => $review,

                        'feedback' => $feedback,

                        'created_on' => date('Y-m-d H:i:s')

                    );

                    $rating_insert = $this->db->insert('quiz_topic_reviews', $rating_data);
                    }
                }

                 $total_questions = $correct_answer_count + $wrong_answer_count + $skipped_answer_count;

                $correct_percentage = $correct_answer_count / $total_questions * 100;

                $wrong_percentage = $wrong_answer_count / $total_questions * 100;

                $skipped_percentage = $skipped_answer_count / $total_questions * 100;

                $response = array(

                    'correct_answer_count' => $correct_answer_count,

                    'wrong_answer_count' => $wrong_answer_count,

                    'skipped_answer_count' => $skipped_answer_count,

                    'correct_percentage' => number_format($correct_percentage, 2) ,

                    'wrong_percentage' => number_format($wrong_percentage, 2) ,

                    'skipped_percentage' => number_format($skipped_percentage, 2)

                );

                $response = array(
                    'status' => true,
                    'message' => 'Quiz submitted Successfully!',
                    'response' => $response
                );

            }

            else

            {

                $response = array(
                    'status' => false,
                    'message' => 'Quiz submission failed!'
                );

            }

        }else{


            $response = array(
                'status' => false,
                'message' => 'Quiz submission failed!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);
 
    

    }
    /*
    
    
    
    *   Submit Question Report
    
    
    
    */

    function submit_question_report_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID',
            'topic_id' => 'Topic ID',
            'qbank_topic_id'=> 'Qbank Topic ID',
            'question_id' => 'Question ID'
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

        if (!empty($report))

        {

            $reports = implode(",", $report);

            $report_data = array(

                'user_id' => $user_id,

                'course_id' => $course_id,

                'subject_id' => $subject_id,

                'topic_id' => $topic_id,

                'qbank_topic_id' => $qbank_topic_id,

                'question_id' => $question_id,

                'reports' => $reports,

                'created_on' => date('Y-m-d H:i:s')

            );

            $quiz_reports = insert_table('quiz_reports', $report_data);

            if ($quiz_reports > 0)

            {

                $response = array(
                    'status' => true,
                    'message' => 'Report submitted Successfully!'
                );

            }

            else

            {

                $response = array(
                    'status' => false,
                    'message' => 'Report submission failed!'
                );

            }

        }

        else

        {

            $response = array(
                'status' => false,
                'message' => 'Report submission failed!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function submit_test_series_report_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'category_id' => 'Category ID',
            'quiz_id' => 'Quiz ID',
            'question_id' => 'Question ID'
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

        if (!empty($report))

        {

            $reports = implode(",", $report);

            $report_data = array(

                'user_id' => $user_id,

                'course_id' => $course_id,

                'category_id' => $category_id,

                'quiz_id' => $quiz_id,

                'question_id' => $question_id,

                'reports' => $reports,

                'created_on' => date('Y-m-d H:i:s')

            );

            $quiz_reports = insert_table('test_series_reports', $report_data);

            if ($quiz_reports > 0)

            {

                $response = array(
                    'status' => true,
                    'message' => 'Report submitted Successfully!'
                );

            }

            else

            {

                $response = array(
                    'status' => false,
                    'message' => 'Report submission failed!'
                );

            }

        }

        else

        {

            $response = array(
                'status' => false,
                'message' => 'Report submission failed!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Bookmark Question
    
    
    
    */

    function bookmark_question_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID',
            'topic_id' => 'Topic ID',
            'qbank_topic_id' => 'Qbank Topic ID',
            'question_id' => 'Question ID',
            'question_order_id'=> 'Question Order ID'
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

        $data = array(

            'user_id' => $user_id,

            'course_id' => $course_id,

            'subject_id' => $subject_id,

            'topic_id' => $topic_id,

            'qbank_topic_id' => $qbank_topic_id,

            'question_id' => $question_id,
            
            'question_order_id'=>$question_order_id,

            'created_on' => date('Y-m-d H:i:s')

        );
$checkQuestionOrderId=$this->ws_model->checkQuestionOrderId($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id,$question_order_id);
$checkQuizBookMarkQuestionId=$this->ws_model->checkQuizBookMarkQuestionId($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id,$question_id);

if(empty($checkQuizBookMarkQuestionId)){
    
if(empty($checkQuestionOrderId)){

            $bookmark_count = get_table_row('quiz_question_bookmarks', array(
                'user_id' => $user_id,
                'course_id' => $course_id,
                'subject_id' => $subject_id,
                'topic_id' => $topic_id,
                'qbank_topic_id' => $qbank_topic_id,
                'question_order_id'=>$question_order_id,
                'question_id' => $question_id
            ));

            if (!$bookmark_count)

            {

                $quiz_question_bookmarks = insert_table('quiz_question_bookmarks', $data);

            }
        }else{
            $quiz_question_bookmarks = 0 ;
        }
    }else{
        $quiz_question_bookmarks = 0 ;
    }

        //echo $this->db->last_query();
        

        if ($quiz_question_bookmarks > 0)

        {

            $response = array(
                'status' => true,
                'message' => 'Question added to Bookmark!',
                'bookmark_id' => $quiz_question_bookmarks
            );

        }

        else

        {

            $response = array(
                'status' => false,
                'message' => 'Question already Bookmarked!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *  Un Bookmark Question
    
    
    
    */

    function unbookmark_question_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID',
            'topic_id' => 'Topic ID',
            'qbank_topic_id' => 'Qbank Topic ID',
            'question_id' => 'Question ID',
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

        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('topic_id', $topic_id);
        $this->db->where('qbank_topic_id', $qbank_topic_id);
        $this->db->where('question_id', $question_id);
        $delete=$this->db->delete('quiz_question_bookmarks');

        
        if ($delete)
        {
             $response = array(
                'status' => true,
                'message' => 'Question Un Bookmark Successfully!',
                
            );

        }

        else

        {

            $response = array(
                'status' => false,
                'message' => 'Question Un Bookmark failed!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }


    /*
    
    
    
    *   Bookmarked Questions
    
    
    
    */

    function bookmarked_questions_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID',
            'topic_id' => 'Topic ID',
            'qbank_topic_id'=>'Qbank Topic ID'
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

        $response = $this
            ->ws_model
            ->bookmarked_questions($user_id, $course_id, $subject_id, $topic_id,$qbank_topic_id);

        //echo $this->db->last_query();
        

        if (empty((array)$response))

        {

            $response = array(
                'status' => false,
                'message' => 'No questions found!'
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Questions Fetched Successfully!',
                'questions' => $response
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Quiz report list
    
    
    
    */

    function quiz_report_list_get()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $response = get_table('quiz_reports_list');

        //echo $this->db->last_query();
        

        if (empty($response))

        {

            $response = array(
                'status' => false,
                'message' => 'No report list found!'
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Report list Fetched Successfully!',
                'response' => $response
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Answered Quiz Questions
    
    
    
    */

    function answered_quiz_questions_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID',
            'topic_id' => 'Topic ID'
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

        $response = $this
            ->ws_model
            ->answered_quiz_questions($user_id, $course_id, $subject_id, $topic_id);

        //echo $this->db->last_query();
        

        if (empty((array)$response))

        {

            $response = array(
                'status' => false,
                'message' => 'No questions found!'
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Questions Fetched Successfully!',
                'response' => $response
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function bookmark_testseries_question_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'category_id' => 'Category ID',
            'quiz_id' => 'Quiz ID',
            'question_id' => 'Question ID',
            'question_order_id'=> 'Question order ID'
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

        $data = array(

            'user_id' => $user_id,

            'course_id' => $course_id,

            'category_id' => $category_id,

            'quiz_id' => $quiz_id,

            'question_id' => $question_id,
            
            'question_order_id'=>$question_order_id,

            'created_on' => date('Y-m-d H:i:s')

        );

        $bookmark_count = get_table_row('test_series_bookmarks', array(
            'user_id' => $user_id,
            'course_id' => $course_id,
            'category_id' => $category_id,
            'quiz_id' => $quiz_id,
            'question_id' => $question_id,
            'question_order_id'=>$question_order_id
        ));

        if (!$bookmark_count)

        {

            $insert = insert_table('test_series_bookmarks', $data);

        }

        // var_dump($response);die();
        

        if ($insert)

        {

            $response = array(
                'status' => true,
                'message' => 'Question Bookmarked Successfully!',
                'bookmark_id' => $insert
            );

        }

        else

        {

            $response = array(
                'status' => false,
                'message' => 'No question found!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function unbookmark_testseries_question_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'category_id' => 'Category ID',
            'quiz_id' => 'Quiz ID',
            'question_id' => 'Question ID',
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

        
        $this->db->where('user_id',$user_id);
        $this->db->where('course_id',$course_id);
        $this->db->where('category_id',$category_id);
        $this->db->where('quiz_id',$quiz_id);
        $this->db->where('question_id',$question_id);
        $result=$this->db->delete('test_series_bookmarks');
        
        if ($result)
        {

            $response = array(
                'status' => true,
                'message' => 'Question Un Bookmarked Successfully!',
            );

        }

        else

        {

            $response = array(
                'status' => false,
                'message' => 'Question Un Bookmarked Failed!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function answered_test_series_questions_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;
        $data = base64_encode($user_input);

        extract($data);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'category_id' => 'Category ID',
            'quiz_id' => 'Quiz ID'
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

        $response = $this
            ->ws_model
            ->answered_test_series_questions($user_id, $course_id, $category_id, $quiz_id);

        if (empty((array)$response))

        {

            $response = array(
                'status' => false,
                'message' => 'No questions found!'
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Answers Fetched Successfully!',
                'response' => $response
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }


    function data_analysis_piechart_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'category_id' => 'Category ID',
            'quiz_id' => 'Quiz ID'
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

        $response = $this
            ->ws_model
            ->answered_test_series_questions($user_id, $course_id, $category_id, $quiz_id);

        $getMarks = $this
            ->ws_model
            ->getMarks($quiz_id, $user_id);

        if (empty((array)$response))

        {

            $response = array(
                'status' => false,
                'message' => 'No questions found!'
            );

        }

        else

        {

            $question_count = 0;
            $wrong = 0;
            $correct = 0;
            //$guessed = 0;
            $skipped = 0;
            $guessed_correct=0;
            $guessed_wrong=0;

            
            $response=json_decode($response['submit_json'],TRUE);
           // echo '<pre>';print_r($response);exit;

            foreach ($response as $value)
            {

                $question_count++;
                unset($question_id);
                $question_id=$value['question_id'];

                if(($value['answer_status'] == 'correct') && ($value['answer_sub_status'] == 'attempted')){
                    $correct++;
                    //$query="select positive_marks,negative_marks from test_series_questions where id='".$question_id."' ";
                    //$question=$this->db->query($query)->row_array();

                }

                if(($value['answer_status'] == 'wrong') && ($value['answer_sub_status'] == 'attempted')){
                    $wrong++;
                }

                if(($value['answer_status'] == 'correct') && ($value['answer_sub_status'] == 'guessed')){
                    $guessed_correct++;
                }

                if(($value['answer_status'] == 'wrong') && ($value['answer_sub_status'] == 'guessed')){
                    $guessed_wrong++;
                }

                if(($value['answer_status'] == 'skipped') && ($value['answer_sub_status'] == 'skipped')){
                    $skipped++;
                }


                /*switch ($value['answer_status'])
                {

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

                }*/

            }

            usort($getMarks, function ($a, $b)
            {

                // return $a['marks']<=>$b['marks'];
                if($a['marks']==$b['marks'])
                {
                    return 0;
                }
                if($a['marks']<$b['marks'])
                {
                    return -1;
                }
                if($a['marks']>$b['marks'])
                {
                    return 1;
                }

            });

            $getMarks = array_reverse($getMarks);

            // var_dump($getMarks);die();
            

            $rank = 1;
            $user_count = sizeof($getMarks);

            for ($i = 1;$i < $user_count;$i++)
            {

                if ($getMarks[$i]['marks'] != $getMarks[$i - 1]['marks'])
                {

                    $rank++;

                }

                if ($getMarks[$i]['user_id'] == $user_id)
                {

                    $attempted = $getMarks[$i]['created_on'];

                    break;

                }

            }

            $correct_percentage = number_format(($correct / $question_count) * 100, 2);

            $guessed_correct_percentage = number_format(($guessed_correct / $question_count) * 100, 2);

            $skipped_percentage = number_format(($skipped / $question_count) * 100, 2);

            $wrong_percentage = number_format(($wrong / $question_count) * 100, 2);

            $guessed_wrong_percentage = number_format(($guessed_wrong / $question_count) * 100, 2);

            $percentage = array(
                'correct_percentage' => $correct_percentage,
                'wrong_percentage' => $wrong_percentage,
                'guessed_correct_percentage' => $guessed_correct_percentage,
                'guessed_wrong_percentage' => $guessed_wrong_percentage,
                'skipped_percentage' => $skipped_percentage,
            );

            $count = array(
                'correct' => $correct,
                'wrong' => $wrong,
                'guessed_correct' => $guessed_correct,
                'guessed_wrong' => $guessed_wrong,
                'skipped' => $skipped,
                
            );

            $response = array(
                'status' => true,

                'message' => 'Answers Fetched Successfully!',

                // 'response' => $response,
                

                'count' => $count,

                'percentage' => $percentage,

                'rank' => $rank,

                'user_count' => $user_count,

                'attempted' => $attempted,

                'total_question_count' => $question_count

            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function quiz_data_analysis_piechart_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID',
            'topic_id' => 'Topic ID'
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

        $response = $this
            ->ws_model
            ->quiz_data_analysis_piechart($user_id, $course_id, $subject_id, $topic_id);

        // var_dump($response);die();
        

        if (empty((array)$response))

        {

            $response = array(
                'status' => false,
                'message' => 'No questions found!'
            );

        }

        else
        {

            $question_count = 0;
            $wrong = 0;
            $correct = 0;
            $skipped = 0;

            foreach ($response as $value)
            {

                $question_count++;

                switch ($value['answer_status'])
                {

                    case 'correct':

                        $correct++;

                    break;

                    case 'skipped':

                        $skipped++;

                    break;

                    default:

                        $wrong++;

                    break;

                }

            }

            $correct_percentage = number_format(($correct / $question_count) * 100, 2);

            $wrong_percentage = number_format(($wrong / $question_count) * 100, 2);

            $skipped_percentage = number_format(($skipped / $question_count) * 100, 2);

            $count = array(
                'correct' => $correct,
                'wrong' => $wrong,
                'skipped' => $skipped,
                'question_count' => $question_count
            );

            $percentage = array(
                'correct_percentage' => $correct_percentage,
                'wrong_percentage' => $wrong_percentage,
                'skipped_percentage' => $skipped_percentage
            );

            $response = array(

                'status' => true,

                'message' => 'Data Fetched Successfully!',

                'count' => $count,

                'percentage' => $percentage

            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

    }

    function data_analysis_allUsers_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'category_id' => 'Category ID',
            'quiz_id' => 'Quiz ID'
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
        

        $response = $this
            ->ws_model
            ->data_analysis_allUsers($user_id, $course_id, $category_id, $quiz_id);

        // var_dump($response);die();
       // echo '<pre>';print_r($response);exit;

        $getMarks = $this
            ->ws_model
            ->getMarks($quiz_id, $user_id);
        $get_bookMarkCount=$this->ws_model->getBookMarkCount($quiz_id, $user_id);
//echo '<pre>';print_r($getMarks);exit;
        usort($getMarks, function ($a, $b)
        {

            return $a['marks']<=>$b['marks'];

        });

        $getMarks = array_reverse($getMarks);

        $rank = 1;
        $user_count = sizeof($getMarks);

        for ($i = 0;$i < $user_count-1;$i++)
        {

            if ($getMarks[$i]['marks'] != $getMarks[$i + 1]['marks'])
            {

                $getMarks[$i]['rank'] = $rank;
               // $getMarks[$i]['rank'] = '--';

                $rank++;

            }

            else
            {

                $getMarks[$i]['rank'] = $rank;
                //$getMarks[$i]['rank'] = '--';

            }

            $correct=$getMarks[$i]['correct_answer_count']+$getMarks[$i]['guessed_correct_answer_count'];
            $wrong=$getMarks[$i]['wrong_answer_count']+$getMarks[$i]['guessed_wrong_answer_count'];
            $getMarks[$i]['skipped']=$getMarks[$i]['skipped_answer_count'];
            
            $total_questions=$getMarks[$i]['skipped_answer_count']+$getMarks[$i]['correct_answer_count']+$getMarks[$i]['guessed_correct_answer_count']+$getMarks[$i]['wrong_answer_count']+$getMarks[$i]['guessed_wrong_answer_count'];

            $getMarks[$i]['correct']= (string)$correct;
            $getMarks[$i]['wrong']=(string)$wrong;
            //$getMarks[$i]['total_questions']=(string)$total_questions;
            $getMarks[$i]['total_questions']=$this->wssub_model->getQuizTotalMarks($course_id, $category_id, $quiz_id);
            /*foreach ($response as $value)
            {

                if ($value['user_id'] == $getMarks[$i]['user_id'])
                {

                    $getMarks[$i][$value['answer_status']] = $value['count'];

                }

            }*/

        }

        $getMarks[$i]['rank'] = $rank;
       // $getMarks[$i]['rank'] = '--';
//echo '<pre>';print_r($getMarks);exit;
        /*foreach ($response as $value)
        {

            if ($value['user_id'] == $getMarks[$i]['user_id'])
            {

                $getMarks[$i][$value['answer_status']] = $value['count'];

            }

        }*/

        for ($i = 0;$i < $user_count;$i++)
        {
            //unset($getMarks[$i]['total_questions']);
           //$getMarks[$i]['total_questions'] = $getMarks[$i]['correct_answer_count'] + $getMarks[$i]['wrong_answer_count'] + $getMarks[$i]['guessed_correct_answer_count'] + $getMarks[$i]['guessed_wrong_answer_count'] + $getMarks[$i]['skipped'];

            if ($getMarks[$i]['user_id'] == $user_id)
            {

                $userDetails = $getMarks[$i];

            }

        }

        $getMarks = array_slice($getMarks, 0, 10);
        $userDetails['bookmarkcount']=$get_bookMarkCount['bookmarkcount'];

        $response = array(
            'status' => true,

            'message' => 'Answers Fetched Successfully!',

            'userDetails' => $userDetails,

            'user_count' => $user_count,

            'getMarks' => $getMarks

        );

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   get_all_review_questions
    
    
    
    */

    function get_all_review_questions_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'category_id' => 'Category ID',
            'quiz_id' => 'Quiz ID'
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

        $response = $this
            ->ws_model
            ->get_all_review_questions($user_id, $course_id, $category_id, $quiz_id);

        $response = array(
            'status' => true,

            'message' => 'Answers Fetched Successfully!',

            'questions' => $response

        );

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function fetch_all_review_quiz_questions_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID',
            'topic_id' => 'Topic ID',
            'qbank_topic_id'=> 'Qbank Topic ID',
            'bookmark'=> 'Bookmark Status'
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

        if($bookmark == 'yes'){
        $response = $this
            ->ws_model
            ->getAllQbankBookmarkQuestions($user_id, $course_id, $subject_id, $topic_id,$qbank_topic_id);
        }else{
         $response = $this
            ->ws_model
            ->fetch_all_review_quiz_questions($user_id, $course_id, $subject_id, $topic_id,$qbank_topic_id);
        }

        $response = array(
            'status' => true,

            'message' => 'Data Fetched Successfully!',

            'questions' => $response

        );

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function fetchAllReviewCustomExamQuizQuestions_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'exam_id' => 'Exam ID',
            'bookmark'=> 'Bookmark Status'
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

        if($bookmark == 'yes'){
        $response = $this
            ->ws_model
            ->getAllQbankBookmarkQuestions($user_id, $course_id, $subject_id, $topic_id,$qbank_topic_id);
        }else{
         $response = $this
            ->ws_model
            ->fetchAllReviewCustomExamQuizQuestions($user_id,$exam_id);
        }

        $response = array(
            'status' => true,

            'message' => 'Data Fetched Successfully!',

            'questions' => $response

        );

        TrackResponse($user_input, $response);

        $this->response($response);

    }


    function get_status_review_questions_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'category_id' => 'Category ID',
            'quiz_id' => 'Quiz ID',
            'status' => 'Status'
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

        $response = $this
            ->ws_model
            ->get_status_review_questions($user_id, $course_id, $category_id, $quiz_id, $status);

        $response = array(
            'status' => true,

            'message' => 'Answers Fetched Successfully!',

            'questions' => $response

        );

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function fetch_status_review_quiz_questions_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID',
            'topic_id' => 'Topic ID',
            'qbank_topic_id'=>'Qbank Topic ID',
            'status' => 'Status'
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

        $response = $this
            ->ws_model
            ->fetch_status_review_quiz_questions($user_id, $course_id, $subject_id, $topic_id,$qbank_topic_id, $status);

        $response = array(
            'status' => true,

            'message' => 'Data Fetched Successfully!',

            'questions' => $response

        );

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Test Series Categories
    
    
    
    */

    function test_series_categories_get()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);
        
     

        $response = get_table('test_series_categories', '', '', 'id', 'desc');

        //echo $this->db->last_query();
        

        if (empty($response))

        {

            $response = array(
                'status' => false,
                'message' => 'Categories not found!'
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Categories fetched successfully!',
                'response' => $response
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function get_review_question_analysis_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'question_id' => 'Question Id',
            'quiz_id'=> 'Quiz Id'
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

        $response = $this
            ->ws_model
            ->get_review_question_analysis1($user_id, $question_id, $quiz_id);

        //$percentage = $this->ws_model->get_allusers_percentage($question_id);

             
        /*if ($percentage['0']['total_count'] != 0)
        {
            $correct_percentage = ($percentage['0']['correct_count'] / $percentage['0']['total_count']) * 100;

            $option_a = ($percentage['0']['option_a'] / $percentage['0']['total_count']) * 100;

            $option_b = ($percentage['0']['option_b'] / $percentage['0']['total_count']) * 100;

            $option_c = ($percentage['0']['option_c'] / $percentage['0']['total_count']) * 100;

            $option_d = ($percentage['0']['option_d'] / $percentage['0']['total_count']) * 100;

            $correct_percentage = number_format($correct_percentage);

            $option_a = number_format($option_a);

            $option_b = number_format($option_b);

            $option_c = number_format($option_c);

            $option_d = number_format($option_d);


            if (array_key_exists('0', $response['options'])){
                      $response['options'][0]['percentage']= $option_a; 
                    }
            if (array_key_exists('1', $response['options'])){
                      $response['options'][1]['percentage']= $option_b; 
                    }
            if (array_key_exists('2', $response['options'])){
                      $response['options'][2]['percentage']= $option_c; 
                    }
            if (array_key_exists('3', $response['options'])){
                      $response['options'][3]['percentage']= $option_d; 
                    }

            $percentage = array(

                'correct_percentage' => $correct_percentage,

            );
        }
        else
        {

            if (array_key_exists('0', $response['options'])){
                      $response['options'][0]['percentage']= 0; 
                    }
            if (array_key_exists('1', $response['options'])){
                      $response['options'][1]['percentage']= 0; 
                    }
            if (array_key_exists('2', $response['options'])){
                      $response['options'][2]['percentage']= 0; 
                    }
            if (array_key_exists('3', $response['options'])){
                      $response['options'][3]['percentage']= 0; 
                    }

            $percentage = array(

                'correct_percentage' => 0,
            );

        }*/
       
        if (array_key_exists('0', $response['options'])){
                      $response['options'][0]['percentage']= 0; 
                    }
            if (array_key_exists('1', $response['options'])){
                      $response['options'][1]['percentage']= 0; 
                    }
            if (array_key_exists('2', $response['options'])){
                      $response['options'][2]['percentage']= 0; 
                    }
            if (array_key_exists('3', $response['options'])){
                      $response['options'][3]['percentage']= 0; 
                    }
                    
        $percentage = array(

                'correct_percentage' => 0,
            );

        $response = array(
            'status' => true,
            'message' => 'Data Fetched Successfully!',
            'response' => $response,
            'percentage' => $percentage
        );

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function get_review_quiz_question_analysis_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'question_id' => 'Question Id',
            'qbank_topic_id'=> 'Qbank Topic Id'
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

        $response = $this->ws_model->get_review_quiz_question_analysis1($user_id, $question_id, $qbank_topic_id);

        /*$percentage = $this->ws_model->get_allusers_quiz_percentage($question_id);


        if ($percentage['total_count'] != 0)
        {

            $correct_percentage = ($percentage['correct_count'] / $percentage['total_count']) * 100;

            $option_a = ($percentage['option_a'] / $percentage['total_count']) * 100;

            $option_b = ($percentage['option_b'] / $percentage['total_count']) * 100;

            $option_c = ($percentage['option_c'] / $percentage['total_count']) * 100;

            $option_d = ($percentage['option_d'] / $percentage['total_count']) * 100;

            $correct_percentage = number_format($correct_percentage);

            $option_a = number_format($option_a);

            $option_b = number_format($option_b);

            $option_c = number_format($option_c);

            $option_d = number_format($option_d);

            if (array_key_exists('0', $response['options'])){
                      $response['options'][0]['percentage']= $option_a; 
                    }
            if (array_key_exists('1', $response['options'])){
                      $response['options'][1]['percentage']= $option_b; 
                    }
            if (array_key_exists('2', $response['options'])){
                      $response['options'][2]['percentage']= $option_c; 
                    }
            if (array_key_exists('3', $response['options'])){
                      $response['options'][3]['percentage']= $option_d; 
                    }

            $percentage = array(

                'correct_percentage' => $correct_percentage,

            );

        }

        else
        {
            if (array_key_exists('0', $response['options'])){
                      $response['options'][0]['percentage']= 0; 
                    }
            if (array_key_exists('1', $response['options'])){
                      $response['options'][1]['percentage']= 0; 
                    }
            if (array_key_exists('2', $response['options'])){
                      $response['options'][2]['percentage']= 0; 
                    }
            if (array_key_exists('3', $response['options'])){
                      $response['options'][3]['percentage']= 0; 
                    }

            $percentage = array(

                'correct_percentage' => 0,

            );

        }*/

        if (array_key_exists('0', $response['options'])){
                      $response['options'][0]['percentage']= 0; 
                    }
            if (array_key_exists('1', $response['options'])){
                      $response['options'][1]['percentage']= 0; 
                    }
            if (array_key_exists('2', $response['options'])){
                      $response['options'][2]['percentage']= 0; 
                    }
            if (array_key_exists('3', $response['options'])){
                      $response['options'][3]['percentage']= 0; 
                    }
        $percentage = array(

                'correct_percentage' => 0,

            );

        $response = array(
            'status' => true,
            'message' => 'Data Fetched Successfully!',
            'response' => $response,
            'percentage' => $percentage
        );

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Test Series Quizs
    
    
    
    */

    function test_series_quizs_post(){

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
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

        $response = $this->ws_model->test_series_quiz_dates($user_id, $course_id, $category_id);
       // $response = $this->ws_model->get_test_series_categories($user_id, $course_id);
       // echo $this->db->last_query();exit;
        if (empty((array)$response))
        {
            $response = array(
                'status' => false,
                'message' => 'No tests found!'
            );

        }

        else

        {
                $new_response=array();
             foreach($response as $key =>$value){
                   
                   if(($value['exam_time'] !='') && ($value['exam_time'] !='0000-00-00')){
                       $date_ary=explode($value['exam_time']);
                      // echo '<pre>';print_r($date_ary);exit;
                       $new_exam_date= '01-'.$date_ary[1].''.$date_ary[2];
                   }
                   $new_response[$key] =$value;
                }
            $response = array(
                'status' => true,
                'message' => 'Tests Fetched Successfully!',
                'response' => $new_response
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Test series quiz Details
    
    
    
    */

    function test_series_quiz_details_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'quiz_id' => 'Quiz ID'
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

        $response = $this
            ->ws_model
            ->test_series_quiz_details($user_id, $quiz_id);

        //echo $this->db->last_query();
        

        if (empty((array)$response))

        {

            $response = array(
                'status' => false,
                'message' => 'No topics found!'
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Topic Fetched Successfully!',
                'response' => $response
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    /*
    
    
    
    *   Test Series Questions
    
    
    
    */

    function check_time_post()
    {
        $response = array(
            'status' => false,
            'message' => ''
        );
        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'category_id' => 'Category ID',
            'quiz_id' => 'Quiz ID'
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
        $quizrow=get_table_row('test_series_quiz', array('course_id'=>$course_id,'category_id'=>$category_id,'id'=>$quiz_id));
        $rowtime=get_table_row('testseries_time', array('user_id' => $user_id,'course_id'=>$course_id,'category_id'=>$category_id,'quiz_id'=>$quiz_id));
        if($rowtime)
        {
            $datetime1 = strtotime($rowtime['created_on']);
            $datetime2 = strtotime(date('Y-m-d H:i:s'));
            $interval  = abs($datetime2 - $datetime1);
            $minutes   = round($interval / 60);
            $minutes_left = $quizrow['time']-$minutes;
            $minutes_left = $minutes_left <=0?0: $minutes_left;
            $response = array(
                'status' => true,
                'message' => 'minutes fetched successfully',
                'minutes_left' => $minutes_left
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
        else
        {
            $response = array(
                'status' => false,
                'message' => 'No data found'
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }

    }

    function test_series_questions_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'category_id' => 'Category ID',
            'quiz_id' => 'Quiz ID'
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
        
           
          $exam_status ="select exam_status from user_assigned_testseries where user_id='".$user_id."'  and quiz_id ='".$quiz_id."'  ORDER BY id DESC LIMIT 1";
                 
                  $result_status= $this->db->query($exam_status)->row_array();
                  
                  $status = $result_status['exam_status'];
                    
              
              
                if (!empty( $exam_status ) && $status == 'completed'){
                    $response = array(
                'status' => false,
                'message' => 'Test already submitted before!');

        TrackResponse($user_input, $response);

        $this->response($response); 
        
        
                } else{

        $response = $this->ws_model->test_series_questions($user_id, $course_id, $category_id, $quiz_id, $count);
        foreach($response as $key =>$value){
            $reponse[$key]=$value;
            if($value['question_type'] == 'single'){
                $question_type="2";
            }else{
                 $question_type="1";
            }
            $response[$key]['question_type']=$question_type;

        }
        //$tstime_status=get_table_row('testseries_time', array('user_id' => $user_id,'course_id'=>$course_id,'category_id'=>$category_id,'quiz_id'=>$quiz_id));

        $userts_status=get_table_row('user_assigned_testseries', array('user_id' => $user_id,'course_id'=>$course_id,'category_id'=>$category_id,'quiz_id'=>$quiz_id));

        date_default_timezone_set('Asia/Kolkata');

        if(!empty($response)){

        //if(empty($tstime_status)){
            $this->ws_model->deleteUserTestseriesTime($user_id,$course_id,$category_id,$quiz_id);
            $rowarray=array(
                'user_id' => $user_id,
                'course_id' => $course_id,
                'category_id' => $category_id,
                'quiz_id' => $quiz_id,
                'created_on'=> date('Y-m-d H:i:s')
            );
            $this->db->insert('testseries_time', $rowarray);
        //}
        
         
         if(empty($userts_status)){
            $this->ws_model->deleteUserAssignedTestseries($user_id,$course_id,$category_id,$quiz_id);
            $rowarray1=array(
                'user_id' => $user_id,
                'course_id' => $course_id,
                'category_id' => $category_id,
                'quiz_id' => $quiz_id,
                'exam_status'=> 'inprogress',
                'exam_start_date'=> date('Y-m-d'),
                'exam_start_time'=> date('H:i:s'),
                'created_on'=> date('Y-m-d H:i:s')
            );
            $this->db->insert('user_assigned_testseries', $rowarray1);
        }
      }
        
        
        
        //echo $this->db->last_query();
        if (empty((array)$response))

        {

            $response = array(
                'status' => false,
                'message' => 'No questions found!'
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Questions Fetched Successfully!',
                'response' => $response
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);
}

    }

    /*
    
    
    
    *   Submit Quiz Test
    
    
    
    */

    function submit_test_series_answers_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'category_id' => 'Category ID',
            'quiz_id' => 'Quiz ID'
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

        if (!empty($answers))

        {

            $correct_answer_count = 0;

            $wrong_answer_count = 0;

            $skipped_answer_count = 0;

            $guessed_answer_count = 0;
            
          //  echo '<pre>';print_r($answers);exit;

            foreach ($answers as $row)

            {

                if ($row['answer_status'] == "correct")

                {

                    $correct_answer_count++;

                }

                elseif ($row['answer_status'] == "wrong")

                {

                    $wrong_answer_count++;

                }

                elseif ($row['answer_status'] == "skipped")

                {

                    $skipped_answer_count++;

                }

                elseif ($row['answer_status'] == "guessed")
                {

                    $guessed_answer_count++;

                }

                $data[] = array(

                    'user_id' => $user_id,

                    'course_id' => $course_id,

                    'category_id' => $category_id,

                    'quiz_id' => $quiz_id,
                    
                    'question_order_id' => $row['question_order_id'],
                    
                    'question_id' => $row['question_id'],

                    'option_id' => $row['option_id'],

                    'answer' => $row['answer'],

                    'correct_answer' => $row['correct_answer'],

                    'answer_status' => $row['answer_status'],

                    'created_on' => date('Y-m-d H:i:s')

                );

            }

            $response = insert_table('test_series_answers', $data, '', true);
            $time_array=array(
                'course_id' => $course_id,
                'category_id' => $category_id,
                'quiz_id' => $quiz_id,
                'user_id' =>$user_id
            );
            $delete = delete_record('testseries_time', $time_array);
            $sta=array('exam_status'=> 'completed');
            $this->db->update('user_assigned_testseries',$sta,$time_array);
            if ($response > 0)

            {

                if ($ratings)

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

                $quiz_data = array(

                    'user_id' => $user_id,

                    'course_id' => $course_id,

                    'category_id' => $category_id,

                    'quiz_id' => $quiz_id,

                    'marks' => $correct_answer_count,

                    'created_on' => date('Y-m-d H:i:s')

                );

                insert_table('test_series_marks', $quiz_data);

                $total_questions = $correct_answer_count + $wrong_answer_count + $skipped_answer_count + $reviewed_answer_count + $guessed_answer_count;

                $correct_percentage = $correct_answer_count / $total_questions * 100;

                $wrong_percentage = $wrong_answer_count / $total_questions * 100;

                $skipped_percentage = $skipped_answer_count / $total_questions * 100;

                $guessed_percentage = $guessed_answer_count / $total_questions * 100;

                $response = array(

                    'correct_answer_count' => $correct_answer_count,

                    'wrong_answer_count' => $wrong_answer_count,

                    'skipped_answer_count' => $skipped_answer_count,

                    'correct_percentage' => number_format($correct_percentage, 2) ,

                    'wrong_percentage' => number_format($wrong_percentage, 2) ,

                    'skipped_percentage' => number_format($skipped_percentage, 2) ,

                    'guessed_percentage' => number_format($guessed_percentage, 2)

                );

                $response = array(
                    'status' => true,
                    'message' => 'Quiz submitted Successfully!',
                    'response' => $response
                );

            }

            else

            {

                $response = array(
                    'status' => false,
                    'message' => 'Quiz submission failed!'
                );

            }

        }

        else

        {

            $response = array(
                'status' => false,
                'message' => 'Quiz submission failed!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function submitCustomExamMode_post(){

        $response = array(
            'status' => false,
            'message' => ''
        );
        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
            'user_id' => 'User ID',
            'custom_exam_id'=>'Custom Exam ID'
        );
        foreach ($required_params as $key => $value){
        if (!$user_input[$key]){
                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );
            TrackResponse($user_input, $response);
            $this->response($response);
            }
        }

        if (!empty($answers)){

            $correct_answer_count = 0;
            $wrong_answer_count = 0;
            $guessed_correct_answer_count=0;
            $guessed_wrong_answer_count=0;
            $skipped_answer_count = 0;

            $correct_marks =0;
            $wrong_marks =0;
            $guessed_correct_marks=0;
            $guessed_wrong_marks=0;
            $total_marks = 0;
            //$custom_exam_id=$this->ws_model->getCustomExamID();

            
            foreach ($answers as $row)
            {
                $corrent_answer=$this->ws_model->getCustomQbankModeCorrectAnswer($row['question_id']);

                $answer_status=$this->ws_model->getCustomQbankModeAnswerStatus($row['question_id'],$row['answer'],$row['answer_status']);
                
                
            if($answer_status == "skipped"){
                 
                    $skipped_answer_count++;
                    $marks = 0;
                 
            }else{
                
                 $result_marks=array();
                 $que_id = $row['question_id'];
                // $marks_query ="select id,positive_marks,negative_marks from quiz_questions where id='".$que_id."' ";
                // $result_marks= $this->db->query($marks_query)->row_array();
                   $result_marks=array('positive_marks'=>1,'negative_marks'=>0);
         
            if(($answer_status == "correct") && ($row['answer_sub_status'] == "attempted")){
                   $correct_answer_count++;
                   $marks =  $result_marks['positive_marks'];
                    
                   $correct_marks = (float)$correct_marks + (float)$marks;
                   $total_marks = (float)$total_marks + (float)$marks;
                  
                  
             } 
            if(($answer_status == "wrong") && ($row['answer_sub_status'] == "attempted")){
                 
                  $wrong_answer_count++;
                  
                  $marks = $result_marks['negative_marks'];
                  
                  $wrong_marks = (float)$wrong_marks + (float)$marks;
                  $total_marks = (float)$total_marks + (float)$marks;
                  
             }

              if(($answer_status == "correct") && ($row['answer_sub_status'] == "guessed")){
                   $guessed_correct_answer_count++;
                   $marks =  $result_marks['positive_marks'];
                    
                   $guessed_correct_marks = (float)$guessed_correct_marks + (float)$marks;
                   $total_marks = (float)$total_marks + (float)$marks;

                } 

             if(($answer_status == "wrong") && ($row['answer_sub_status'] == "guessed")){
                 
                  $guessed_wrong_answer_count++;
                  $marks = $result_marks['negative_marks'];
                  $guessed_wrong_marks = (float)$guessed_wrong_marks + (float)$marks;
                  $total_marks = (float)$total_marks + (float)$marks;
              }
            }

            

            $data[] = array(

                    'exam_id'=>$custom_exam_id,

                    'user_id' =>  $user_id,

                    'course_id' => $row['course_id'],

                    'subject_id' => $row['subject_id'],

                    'chapter_id' => $row['chapter_id'],
                    
                    'topic_id'   =>  $row['topic_id'],

                    'mode'=>'exam_mode',
                    
                    'question_order_id' => $row['question_order_id'],
                    
                    'question_id' => $row['question_id'],

                    'option_id' => $row['option_id'],

                    'answer' => $row['answer'],

                    'correct_answer' => $corrent_answer,

                    'answer_status' => $answer_status,
                    
                    'answer_sub_status'=> $row['answer_sub_status'],
                    
                    'marks' => $marks,

                    'created_on' => date('Y-m-d H:i:s')

                );

            }

            //echo '<pre>';print_r($data);exit;

            $response = $this->db->insert_batch('custom_module_exam_result', $data);
            //echo $this->db->last_query();exit;

            $total_questions = $correct_answer_count + $wrong_answer_count + $skipped_answer_count+$guessed_correct_answer_count+$guessed_wrong_answer_count/* + $reviewed_answer_count + $guessed_answer_count*/;
            $correct_percentage = $correct_answer_count / $total_questions * 100;
            $wrong_percentage = $wrong_answer_count / $total_questions * 100;
            $skipped_percentage = $skipped_answer_count / $total_questions * 100;
            $guessed_correct_percentage = $guessed_correct_answer_count / $total_questions * 100;
            $guessed_wrong_percentage = $guessed_wrong_answer_count / $total_questions * 100;

                
                $marks_data = array(

                    'exam_id'=>$custom_exam_id,
                    'mode'=>'exam_mode',
                    'user_id' => $user_id,
                    'marks'=> $total_marks,
                    'wrong_marks'=> $wrong_marks,
                    'correct_marks'=> $correct_marks,

                    'guessed_correct_marks'=>$guessed_correct_marks,
                    'guessed_wrong_marks'=>$guessed_wrong_marks,

                    'correct_answer_count' => $correct_answer_count,
                    'wrong_answer_count' => $wrong_answer_count,

                    'guessed_correct_answer_count'=>$guessed_correct_answer_count,
                    'guessed_wrong_answer_count'=>$guessed_wrong_answer_count,

                    'skipped_answer_count' => $skipped_answer_count,
                    'correct_percentage' => number_format($correct_percentage, 2) ,
                    'wrong_percentage' => number_format($wrong_percentage, 2) ,
                    'skipped_percentage' => number_format($skipped_percentage, 2) ,

                    'guessed_correct_percentage' => number_format($guessed_correct_percentage, 2),
                    'guessed_wrong_percentage' => number_format($guessed_wrong_percentage, 2),

                    'created_on' => date('Y-m-d H:i:s'),
                    'start_time' => $start_time

                );

                //echo '<pre>';print_r($marks_data);exit;

               $this->db->update('custom_module_exam_marks', $marks_data,array('exam_id'=>$custom_exam_id));

               $update_exam_status=array(
                                   'exam_status'=>'completed',
                                   );
                $this->db->update('custom_module_user_exam_status',$update_exam_status,array('exam_id'=>$custom_exam_id,'user_id'=>$user_id));

               $response = array(
                    'status' => true,
                    'message' => 'Exam Mode Exam submitted Successfully!',
                    'response' => $marks_data
                );       
             

        }else{

            $response = array(
                'status' => false,
                'message' => 'Quiz submission failed!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);


    }
    
    
    function submit_test_series_answers1_post()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'category_id' => 'Category ID',
            'quiz_id' => 'Quiz ID'
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
        
          $exam_status ="select exam_status from user_assigned_testseries where user_id='".$user_id."'  and quiz_id ='".$quiz_id."'  ORDER BY id DESC LIMIT 1";
                 
                  $result_status= $this->db->query($exam_status)->row_array();
                  
                  $status = $result_status['exam_status'];
                    
              
              
                if (!empty( $exam_status ) && $status == 'completed'){
                    $response = array(
                'status' => false,
                'message' => 'Test already submitted before!');

        TrackResponse($user_input, $response);

        $this->response($response); 
        
        
                } else{

        if (!empty($answers))

        {

            $correct_answer_count = 0;

            $wrong_answer_count = 0;

            $skipped_answer_count = 0;

            //$guessed_answer_count = 0;
            $guessed_correct_answer_count=0;
            $guessed_wrong_answer_count=0;
            
            $total_marks = 0;
            $wrong_marks =0;
            $correct_marks =0;

            $guessed_correct_marks=0;
            $guessed_wrong_marks=0;

            $ratings='';
           
      
            foreach ($answers as $row)

            {
                
                
                 $corrent_answer=$this->ws_model->getCorrectAnswer($row['question_id']);
            
             /*if ($row['answer_status'] == "guessed")
                          {

                    $guessed_answer_count++;

                     }*/
                
               
                $answer_status=$this->ws_model->getAnswerStatus($row['question_id'],$row['answer'],$row['answer_status']);
                
                
                if($answer_status == "skipped"){
                 
                    $skipped_answer_count++;
                     $marks = 0;
                 
             } else {
                
               $result_marks=array();
                $que_id = $row['question_id'];
                 $marks_query ="select id,positive_marks,negative_marks from test_series_questions where id='".$que_id."' ";
                  $result_marks= $this->db->query($marks_query)->row_array();
                  
         
            if(($answer_status == "correct") && ($row['answer_sub_status'] == "attempted")){
                   $correct_answer_count++;
                   $marks =  $result_marks['positive_marks'];
                    
                   $correct_marks = (float)$correct_marks + (float)$marks;
                   $total_marks = (float)$total_marks + (float)$marks;
                  
                  
             } 



             if(($answer_status == "wrong") && ($row['answer_sub_status'] == "attempted")){
                 
                  $wrong_answer_count++;
                  
                  $marks = $result_marks['negative_marks'];
                  
                  $wrong_marks = (float)$wrong_marks + (float)$marks;
                  $total_marks = (float)$total_marks + (float)$marks;
                  
             }

              if(($answer_status == "correct") && ($row['answer_sub_status'] == "guessed")){
                   $guessed_correct_answer_count++;
                   $marks =  $result_marks['positive_marks'];
                    
                   $guessed_correct_marks = (float)$guessed_correct_marks + (float)$marks;
                   $total_marks = (float)$total_marks + (float)$marks;

                } 

             if(($answer_status == "wrong") && ($row['answer_sub_status'] == "guessed")){
                 
                  $guessed_wrong_answer_count++;
                  
                  $marks = $result_marks['negative_marks'];
                  
                  $guessed_wrong_marks = (float)$guessed_wrong_marks + (float)$marks;
                  $total_marks = (float)$total_marks + (float)$marks;
                  
             }


                 
             }
             //echo '<pre>';print_r($guessed_correct_marks);
             
              // echo '<pre>';print_r($correct_marks);exit; 

                /*$data[] = array(

                    'user_id' => $user_id,

                    'course_id' => $course_id,

                    'category_id' => $category_id,

                    'quiz_id' => $quiz_id,
                    
                    //'subject_id' => $row['subject_id'],
                    
                    'question_order_id' => $row['question_order_id'],
                    
                    'question_id' => $row['question_id'],

                    'option_id' => $row['option_id'],

                    'answer' => $row['answer'],

                    'correct_answer' => $corrent_answer,

                    'answer_status' => $answer_status,
                    
                    'answer_sub_status'=> $row['answer_sub_status'],
                    
                    'marks' => $marks,

                    'created_on' => date('Y-m-d H:i:s')

                );*/

                $submit_data[$row['question_id']]=array(

                    'question_order_id' => $row['question_order_id'],
                    
                    'question_id' => $row['question_id'],

                    'option_id' => $row['option_id'],

                    'answer' => $row['answer'],

                    'correct_answer' => $corrent_answer,

                    'answer_status' => $answer_status,
                    
                    'answer_sub_status'=> $row['answer_sub_status'],
                    
                    'marks' => $marks,

                    'created_on' => date('Y-m-d H:i:s')

                );

            }
             //echo '<pre>';print_r($submit_data);exit;
            

            $form_json_object=array(
                                    'user_id' =>$user_id,
                                    'course_id' => $course_id,
                                    'category_id' => $category_id,
                                    'quiz_id' => $quiz_id,
                                    'submit_json'=>json_encode($submit_data),
                                    'created_on'=>date('Y-m-d H:i:s')
                                   );
            $response = $this->db->insert('test_series_answers_json', $form_json_object);

            $time_array=array(
                'course_id' => $course_id,
                'category_id' => $category_id,
                'quiz_id' => $quiz_id,
                'user_id' =>$user_id
            );
            
                $time_query ="select created_on from testseries_time where user_id='".$user_id."' ORDER BY id DESC LIMIT 1 ";
                  $result_time= $this->db->query($time_query)->row_array();
                  
                  $start_time = $result_time['created_on'];
                  
                
                
            
            
            
            $delete = delete_record('testseries_time', $time_array);
            $sta=array('exam_status'=> 'completed');
            $this->db->update('user_assigned_testseries',$sta,$time_array);
            if ($response > 0)

            {

                if ($ratings)

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

                

                $total_questions = $correct_answer_count + $wrong_answer_count + $skipped_answer_count+$guessed_correct_answer_count+$guessed_wrong_answer_count/* + $reviewed_answer_count + $guessed_answer_count*/;

                $correct_percentage = $correct_answer_count / $total_questions * 100;

                $wrong_percentage = $wrong_answer_count / $total_questions * 100;

                $skipped_percentage = $skipped_answer_count / $total_questions * 100;
                
                $guessed_correct_percentage = $guessed_correct_answer_count / $total_questions * 100;
                $guessed_wrong_percentage = $guessed_wrong_answer_count / $total_questions * 100;

                
                $quiz_data = array(

                    'user_id' => $user_id,

                    'course_id' => $course_id,

                    'category_id' => $category_id,

                    'quiz_id' => $quiz_id,

                     'marks'=> $total_marks,

                     'wrong_marks'=> $wrong_marks,

                     'correct_marks'=> $correct_marks,
                     'guessed_correct_marks'=>$guessed_correct_marks,
                     'guessed_wrong_marks'=>$guessed_wrong_marks,
                    
                     'correct_answer_count' => $correct_answer_count,

                    'wrong_answer_count' => $wrong_answer_count,

                    'guessed_correct_answer_count'=>$guessed_correct_answer_count,

                    'guessed_wrong_answer_count'=>$guessed_wrong_answer_count,

                    'skipped_answer_count' => $skipped_answer_count,

                    'correct_percentage' => number_format($correct_percentage, 2) ,

                    'wrong_percentage' => number_format($wrong_percentage, 2) ,

                    'skipped_percentage' => number_format($skipped_percentage, 2) ,

                    'guessed_correct_percentage' => number_format($guessed_correct_percentage, 2),

                    'guessed_wrong_percentage' => number_format($guessed_wrong_percentage, 2),
                    'created_on' => date('Y-m-d H:i:s'),
                    'start_time' => $start_time

                );

                insert_table('test_series_marks', $quiz_data);

                $response = array(

                    'correct_answer_count' => $correct_answer_count,

                    'wrong_answer_count' => $wrong_answer_count,

                    'guessed_correct_answer_count'=>$guessed_correct_answer_count,

                    'guessed_wrong_answer_count'=>$guessed_wrong_answer_count,

                    'skipped_answer_count' => $skipped_answer_count,

                    'correct_percentage' => number_format($correct_percentage, 2) ,

                    'wrong_percentage' => number_format($wrong_percentage, 2) ,

                    'skipped_percentage' => number_format($skipped_percentage, 2) ,

                    'guessed_correct_percentage' => number_format($guessed_correct_percentage, 2),

                    'guessed_wrong_percentage' => number_format($guessed_wrong_percentage, 2),
                    
                    'marks'=> $total_marks,
                    'wrong_marks'=> $wrong_marks,
                    'correct_marks'=> $correct_marks,
                    'guessed_correct_marks'=>$guessed_correct_marks,
                     'guessed_wrong_marks'=>$guessed_wrong_marks,
                    

                );

                $response = array(
                    'status' => true,
                    'message' => 'Quiz submitted Successfully!',
                    'response' => $response
                );

            }

            else

            {

                $response = array(
                    'status' => false,
                    'message' => 'Quiz submission failed!'
                );

            }

        }

        else

        {

            $response = array(
                'status' => false,
                'message' => 'Quiz submission failed!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);
        
                }

    }
    
    public function send_Singlepush_notification_post(){
        
         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'mobile' => 'Mobile',
            'image_path' => 'IMage Path'
        );

        foreach ($required_params as $key => $value){

            if (!$user_input[$key]){

                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);

                $this->response($response);

            }
        }
        
        $this->db->select("id, token, ios_token"); 
        $this->db->where('mobile',$mobile);
        $this->db->where('delete_status','1');           
       
        $users = $this->db->get("users");
      // echo $this->db->last_query();exit;
        $r = array();       
        if($users->num_rows() > 0)
        {
            $result =  $users->result();
            //echo '<pre>';print_r($result);
            $reg_ids=array();
            foreach($result as $r)
            {
                // if($post_type == "friend_requests")
                // {
                //     $message = $r->name.' '.$message;
                // }
                if(!empty($r->ios_token) && $r->ios_token != "-" && $r->ios_token != "")
                {
                    array_push($ios_reg_ids, $r->ios_token);
                }
                if(!empty($r->token) && $r->token != "-" && $r->token != "")
                {
                    array_push($reg_ids, $r->token);
                }
                // $this->db->insert('notifications', array('user_id' => $r->id, 'title' => $title, 'message' => $message, 'post_id' => $section_id, 'type' => $notification, 'created_on' => date('Y-m-d H:i:s')));
                //echo $this->db->last_query();exit;
            }
        }
        
        $message="this is test message";
        //$image_path="http://platoonline.com/old/storage/pdfs/bipc_2105.jpg";
        $message = array('title' => $title, 'message' => $message,'image'=>$image_path);
       // $message = array('title' => 'srikanth', 'message' => $message);
        
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
             'registration_ids' => $reg_ids,
             'data' => $message
            );
            //echo '<pre>';print_r($fields);exit;

        $headers = array(
           // 'Authorization:key = AIzaSyCl8zppJLCKPRiy4vxu7kx0KOqkoPAktAo',
            //'Authorization:key = AAAAVzI0xoI:APA91bHcBbfCrtJLib1EWTNzu_9-kNQZF1woQVvNAlGR_6Jf9EnFxqTWnakP6L8qfdOUCIXKnYI5MGfIUUL-6YzuEc-iXIGZ1G3Jd_qsLkUOo6kWMD3EBwq26f5MzCfRkLlO2l93OB_M',
            'Authorization:key = AAAAU0Hv9rg:APA91bH5jb7SzvnUuXwh9M4CRN17kbRZkeovviIGHVGZtW4fbxfhiUvCaEr_uLeR4wOseb-xjh2hafWwKLtLI9FPiGRCnIq_vb9wBlz-7sSwUN4_GdoOmsmvsVA3wTv3KgCG9m7kfk6U',
            'Content-Type: application/json'
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);           
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        //Print error if any
		//	 if(curl_errno($ch))
		//	 {
		//	 	$result= 'error:' . curl_error($ch);
		//	 }		
        curl_close($ch);
        //var_dump($result);
        //return $result;
        $response=array('result'=>$result);
        $this->response($response);
        
    }
    
    public function getUserCourses_post(){
        
         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'mobile' => 'Mobile',
        );

        foreach ($required_params as $key => $value){

            if (!$user_input[$key]){

                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);

                $this->response($response);

            }
        }
      $userCourses=$this->ws_model->getUserCourses($mobile);
      
      if(!empty($userCourses)){
           $response = array(
                    'status' => true,
                    'message' => 'Data Fetched Successfully!',
                    'response' => $userCourses
                );

            }

            else

            {

                $response = array(
                    'status' => false,
                    'message' => 'Data Not Fetched!',
                    'response' => array(),
                );

            }

        TrackResponse($user_input, $response);

        $this->response($response);
      
        
    }
    
    public function updateCoursePaymentStatus_post(){
        
         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'mobile' => 'Mobile',
            'course_id'=> 'Course ID',
            'status'=> 'Status'
        );

        foreach ($required_params as $key => $value){

            if (!$user_input[$key]){

                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);

                $this->response($response);

            }
        }
      $result=$this->ws_model->updateCoursePaymentStatus($mobile,$course_id,$status);
      $userCourses=$this->ws_model->getUserCourses($mobile);
      if(!empty($result)){
           $response = array(
                    'status' => true,
                    'message' => 'Data Updated Successfully!',
                    'response' => $userCourses
                );

            }

            else

            {

                $response = array(
                    'status' => false,
                    'message' => 'Data Not Updated!',
                    'response' => array(),
                );

            }

        TrackResponse($user_input, $response);

        $this->response($response);
      
        
    }
    
     public function resetTestSeries_post(){
         
         
        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'userId' => 'userId',
            'quizId'=> 'quizId',
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

       $reset = $this->ws_model->resetTestSeries($userId, $quizId);

        if ($reset === false)

        {

            $response = array(
                'status' => false,
                'message' => 'Test series reset got Failed!'
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Test series rested Successfully!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);


     }
     
     public function testing_post(){
         
         
        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'userId' => 'userId',
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

    

            $response = array(
                'status' => true,
                'message' => 'Post test Success!'
            );

     

        TrackResponse($user_input, $response);

        $this->response($response);


     }

   public function pearls_list_post(){
        
         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'offset' => 'Offset',
            'limit'=> 'Limit',
            'course_id'=>'Course ID'
        );

        foreach ($required_params as $key => $value){

            if (!$user_input[$key]){

                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);

                $this->response($response);

            }
        }
      $result=$this->ws_model->getPearlList($offset,$limit,$course_id);
      $pearlsCount=$this->ws_model->totalPearlsCount($course_id);
      if(!empty($result)){
           $response = array(
                    'status' => true,
                    'message' => 'Data Fetched Successfully!',
                    'totalpearlsCount'=>$pearlsCount['pearlscount'],
                    'response' => $result
                    
                );

            }

            else

            {

                $response = array(
                    'status' => false,
                    'message' => 'Data Not Fetched!',
                    'totalpearlsCount'=> '',
                    'response' => array(),
                    
                );

            }

        TrackResponse($user_input, $response);

        $this->response($response);
    }

    public function pearls_subjects_post(){
        
         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
          'course_id'=>'Course ID'
        );

        foreach ($required_params as $key => $value){

            if (!$user_input[$key]){

                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);

                $this->response($response);

            }
        }
      $result=$this->ws_model->getPearlSubjects($course_id);
     
      if(!empty($result)){
           $response = array(
                    'status' => true,
                    'message' => 'Data Fetched Successfully!',
                    'response' => $result
                    
                );

            }

            else

            {

                $response = array(
                    'status' => false,
                    'message' => 'Data Not Fetched!',
                    'response' => array(),
                    
                );

            }

        TrackResponse($user_input, $response);

        $this->response($response);
    }

    public function subject_wise_pearls_post(){
        
         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
          'user_id'=>'User ID',
          'course_id'=>'Course ID',
          'subject_id'=>'Subject ID',
          'offset'=>'Offset',
          'limit'=>'Limit'
        );

        foreach ($required_params as $key => $value){

            if (!$user_input[$key]){

                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);

                $this->response($response);

            }
        }
      $result=$this->ws_model->getSubjectWisePearls($user_id,$course_id,$subject_id,$offset,$limit);
      $pearlsCount=$this->ws_model->totalSubjectWisePearlsCount($course_id,$subject_id);
     
      if(!empty($result)){
           $response = array(
                    'status' => true,
                    'message' => 'Data Fetched Successfully!',
                    'totalpearlsCount'=>$pearlsCount['pearlscount'],
                    'response' => $result
                    
                );

            }else{
                $response = array(
                    'status' => false,
                    'message' => 'Data Not Fetched!',
                    'totalpearlsCount'=>'',
                    'response' => array(),
                    
                );
            }

        TrackResponse($user_input, $response);
        $this->response($response);
    }

 public function pearl_details_post(){
        
         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
          'pearl_id'=>'Pearl ID',
          );

        foreach ($required_params as $key => $value){

            if (!$user_input[$key]){

                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);

                $this->response($response);

            }
        }
      $result=$this->ws_model->getPearlDetails($pearl_id);
      
      if(!empty($result)){
           $response = array(
                    'status' => true,
                    'message' => 'Data Fetched Successfully!',
                    'response' => $result
                    
                );

            }else{
                $response = array(
                    'status' => false,
                    'message' => 'Data Not Fetched!',
                    'response' => array(),
                    
                );
            }

        TrackResponse($user_input, $response);
        $this->response($response);
    }

    

    public function pearl_questions_post(){
        
         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
          'pearl_id'=>'Pearl ID',
          );
        foreach ($required_params as $key => $value){
            if (!$user_input[$key]){
                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);
                $this->response($response);

            }
        }
      $result=$this->ws_model->getPearlQuestions($pearl_id);
      
      if(!empty($result)){
           $response = array(
                    'status' => true,
                    'message' => 'Data Fetched Successfully!',
                    'response' => $result
                    
                );

            }else{
                $response = array(
                    'status' => false,
                    'message' => 'Data Not Fetched!',
                    'response' => array(),
                    
                );
            }

        TrackResponse($user_input, $response);
        $this->response($response);
    }

    public function bookmark_pearl_post(){
        
         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
          'pearl_id'=>'Pearl ID',
          'user_id'=>'User ID'
          );
        foreach ($required_params as $key => $value){
            if (!$user_input[$key]){
                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);
                $this->response($response);

            }
        }
      $result=$this->ws_model->getBookMarkPearl($user_id,$pearl_id);
      
      if(!empty($result)){
           $response = array(
                    'status' => true,
                    'message' => 'BookMark Added Successfully!',
                    'response' => $result
                    
                );
            }else{
                $response = array(
                    'status' => false,
                    'message' => 'Book mark already Added',
                    'response' => 'false',
                    
                );
            }
        TrackResponse($user_input, $response);
        $this->response($response);
    }

    public function unbookmark_pearl_post(){

         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
          'pearl_id'=>'Pearl ID',
          'user_id'=>'User ID'
          );
        foreach ($required_params as $key => $value){
            if (!$user_input[$key]){
                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);
                $this->response($response);

            }
        }
      $result=$this->ws_model->unBookMarkPearl($user_id,$pearl_id);
      
      if(!empty($result)){
           $response = array(
                    'status' => true,
                    'message' => 'Data Unbookmark Successfully!',
                    'response' => $result
                    
                );
            }else{
                $response = array(
                    'status' => false,
                    'message' => 'BookMark Not Deleted',
                    'response' => 'false',
                    
                );
            }
        TrackResponse($user_input, $response);
        $this->response($response);

    }

public function pearl_feedback_post(){

         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;
        extract($user_input);
        $required_params = array(
          'pearl_id'=>'Pearl ID',
          'user_id'=>'User ID',
          'feedback'=>'Feedback'
          );
        foreach ($required_params as $key => $value){
            if (!$user_input[$key]){
                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);
                $this->response($response);

            }
        }
      $result=$this->ws_model->addfeedbacktopearl($user_id,$pearl_id,$feedback);
      
      if(!empty($result)){
           $response = array(
                    'status' => true,
                    'message' => 'Feedback posted Successfully!',
                    'response' => $result
                    
                );
            }else{
                $response = array(
                    'status' => false,
                    'message' => 'Feedback Not Posted',
                    'response' => 'false',
                    
                );
            }
        TrackResponse($user_input, $response);
        $this->response($response);

    }

 public function pearl_detailswith_serialno_post(){
        
         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
          'pearl_no'=>'Pearl No',
          );

        foreach ($required_params as $key => $value){

            if (!$user_input[$key]){

                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);

                $this->response($response);

            }
        }
      $result=$this->ws_model->getPearlDetailswithSerialNo($pearl_no);
      
      if(!empty($result)){
           $response = array(
                    'status' => true,
                    'message' => 'Data Fetched Successfully!',
                    'response' => $result
                    
                );

            }else{
                $response = array(
                    'status' => false,
                    'message' => 'Data Not Fetched!',
                    'response' => array(),
                    
                );
            }

        TrackResponse($user_input, $response);
        $this->response($response);
    }

    public function total_subjects_with_pearls_post(){
        
         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
          'user_id'=>'User ID',
          'course_id'=>'Course ID'
          );

        foreach ($required_params as $key => $value){

            if (!$user_input[$key]){

                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);

                $this->response($response);

            }
        }
      $result=$this->ws_model->getTotalSubjectswithPearls($user_id,$course_id);
      
      if(!empty($result)){
           $response = array(
                    'status' => true,
                    'message' => 'Data Fetched Successfully!',
                    'response' => $result
                    
                );

            }else{
                $response = array(
                    'status' => false,
                    'message' => 'Data Not Fetched!',
                    'response' => array(),
                    
                );
            }

        TrackResponse($user_input, $response);
        $this->response($response);
    }

    public function insert_doubt_post(){
        
         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
          'user_id'=>'User ID',
          'subject_id'=>'Subject ID'
          );

        foreach ($required_params as $key => $value){

            if (!$user_input[$key]){

                $response = array(
                    'status' => false,
                    'message' => $value . ' is required'
                );

                TrackResponse($user_input, $response);

                $this->response($response);

            }
        }


        $image_data= array(
            'upload_path' =>'./storage/doubts/',
            'file_path' => 'storage/doubts/'
        );

        if($doubt_image)
        {
            $image_data['image'] = $doubt_image;
            $image_result = upload_image($image_data);
            if(!$image_result['status'])
            {
                $response = array('image_status' => false, 'message' => 'Image saving is unsuccessful!');
                TrackResponse($user_input, $response);       
                $this->response($response);
            }
            else
            {
                $image = $image_result['result'];
            }
        }else{ $image='';}

        $data = array(
            'subject_id' => $subject_id,
            'user_id'=> $user_id,
            'image'=>$image,
            'doubt' => $doubt, 
            'created_on' => date('Y-m-d H:i:s')
            );

      //echo '<pre>';print_r($data);exit;
      $result=$this->ws_model->insert_doubts($data);
      
      if(!empty($result)){
           $response = array(
                    'status' => true,
                    'message' => 'Data Posted Successfully!',
                    'response' => $result
                    
                );

            }else{
                $response = array(
                    'status' => false,
                    'message' => 'Data Not Posted!',
                    'response' => array(),
                    
                );
            }

        TrackResponse($user_input, $response);
        $this->response($response);
    }


    public function get_subjects_get(){
        
         $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        //echo '<pre>';print_r($_GET);exit;

        $user_id=$_GET['user_id'];
        $exam_id=$_GET['exam_id'];
        $device_id=$_GET['device_id'];
       if(!$user_id)
        {

            $response = array(
                'status' => false,
                'message' => 'User ID is Missing',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$exam_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Please Select exam',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

       //$user_subjects = $this->ws_model->subjects($exam_id);
        $user_subjects1 = $this->ws_model->getSubjects($user_id,$exam_id);
        if($device_id !=''){
            
            $this->ws_model->updateUserDeviceId($user_id,$device_id);
        }
        $device_id=$this->ws_model->userDeviceId($user_id);
        /*$user_subjects1=array();
        //echo $this->db->last_query();exit;
        if(!empty($user_subjects)){
            
            foreach($user_subjects as $key=>$sub){
                
                 if($sub->video_ids !=''){
                  $chapter_ids=explode(',',$sub->video_ids);
                     foreach($chapter_ids as $chap){
                        $result= $this->ws_model->getVedioSeenCount($user_id,$chap);
                        //echo '<pre>';print_r($result);exit;
                        $seenVedioCount +=count($result);
                        
                     }
                     //echo '<pre>';print_r($seenVedioCount);exit;
                 }
                
            
            $user_subjects1[$key]=$sub;
            $user_subjects1[$key]->seenVedioCount=$seenVedioCount;
            unset($seenVedioCount);
            }
            
        }*/
        

        if (empty($user_subjects1))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {
            //$user_subjects1['device_id']=$device_id;
            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $user_subjects1,
                'device_id'=>$device_id
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function get_all_chapters_get()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);

        $user_input=array(
        'user_id'=>$_GET['user_id'],
        'course_id'=>$_GET['course_id'],
        'subject_id'=>$_GET['subject_id']
        );

        $required_params = array(
            'user_id' => "User ID",
            'course_id'=>"Course ID",
            'subject_id' => "Subject ID"
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
        $user_id=$user_input['user_id'];
        $course_id=$user_input['course_id'];
        $subject_id=$user_input['subject_id'];
        $chapter_list = $this
            ->ws_model
            ->get_all_chapters($subject_id, $user_id,$course_id);
        if(!empty($chapter_list))
        {
            $response = array(
                'status' => true,
                'message' => 'Data fetched Successfully',
                'response' => $chapter_list
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
        TrackResponse($user_input, $response);
        $this->response($response);
    }

    function get_homepage_get()

    {

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        $user_id=$_GET['user_id'];

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Enter user Number!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if ($user_id == 0)

        {

            $response = array(
                'status' => false,
                'message' => 'User fetched Failed!',
                'response' => array()
            );

        }

        else

        {

            //$user_exams = $this->ws_model->user_exams($user_id);

            $user_exams = $this
                ->ws_model
                ->exams1($user_id);

            $banners = $this
                ->ws_model
                ->banners();

      

            $suggestedqbank = array();

            $suggested_videos = $this
                ->ws_model
                ->add_usersuggest();

            $response = array(
                'status' => true,
                'message' => 'Data fetched Successful!',
                'user_exams' => $user_exams,
                'banners' => $banners,
                'statusbar' => [$stats],
                'suggestedqbank' => $suggestedqbank,
                'suggested_videos' => $suggested_videos
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function get_homepage_course_get()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);

        //$getHeaders = apache_request_headers();
       /* $headers=array();
foreach (getallheaders() as $name => $value) {
    $headers[$name] = $value;
}

        echo '<pre>';print_r($headers);exit;
       */ 
        $user_id=$_GET['user_id'];
        $course_id=$_GET['course_id'];
        $android_device_id=$_GET['device_id'];
        //echo '<pre>';print_r($android_device_id);exit;

        if (!$user_id)
        {
            $response = array(
                'status' => false,
                'message' => 'Enter user ID!',
                'response' => array()
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
        if (!$course_id)
        {
            $response = array(
                'status' => false,
                'message' => 'Enter course ID!',
                'response' => array()
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
        $banners = $this->ws_model->banners($course_id);
        $user_exams = $this->ws_model->user_exams($user_id,$course_id);
        $this->ws_model->updateUserAndroidDeviceId($user_id,$android_device_id);
        /*$stats['user_videos'] = $this->ws_model->users_video($chapter_id, $user_id,$course_id);
        $stats['total_videos'] = $this->ws_model->total_videos($course_id);
        $stats['user_qbank'] = $this->ws_model->user_qbank($user_id,$course_id);
        $stats['total_qbank'] = $this->ws_model->total_qbank($course_id);
        $stats['user_test'] = $this->ws_model->user_test($user_id,$course_id);
        $stats['total_test'] = $this->ws_model->total_test($course_id);
       */
       // $suggestedqbank = $this->ws_model->add_usersuggestqbank($user_id, $course_id);
       $suggestedqbank=$this->ws_model->getSuggestqbank($user_id, $course_id);
       $suggestedTestSeries=$this->ws_model->getSuggestedTestSeries($course_id,$user_id);
       
        $suggested_videos = $this->ws_model->add_usersuggest($user_id,$course_id);
        //$pearlsList = $this->ws_model->latestPearlsList($course_id);
        $this->wssub_model->insertUserInterstedCourse($user_id,$course_id);

        $response = array(
            'status' => true,
            'message' => 'Data fetched Successful!',
            'user_exams' => $user_exams,
            'banners' => $banners,
            //'statusbar' => [$stats],
            'suggestedqbank' => $suggestedqbank,
            'suggested_videos' => $suggested_videos,
            'suggested_testseries' => $suggestedTestSeries,
            'pearlsList'=>$pearlsList,
        );
        TrackResponse($user_input, $response);

        $this->response($response);
    }

    function get_homepage_course1_get()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);

        
        $user_id=$_GET['user_id'];
        $course_id=$_GET['course_id'];

        if (!$user_id)
        {
            $response = array(
                'status' => false,
                'message' => 'Enter user ID!',
                'response' => array()
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
        if (!$course_id)
        {
            $response = array(
                'status' => false,
                'message' => 'Enter course ID!',
                'response' => array()
            );
            TrackResponse($user_input, $response);
            $this->response($response);
        }
        $banners = $this->ws_model->banners($course_id);
        $user_exams = $this->ws_model->user_exams($user_id,$course_id);
        
        $suggestedqbank=$this->ws_model->getSuggestqbank1($user_id, $course_id);
        $suggestedTestSeries=$this->ws_model->getSuggestedTestSeries1($course_id,$user_id);
        $suggested_videos = $this->ws_model->add_usersuggest1($user_id,$course_id);
        

        $response = array(
            'status' => true,
            'message' => 'Data fetched Successful!',
            'user_exams' => $user_exams,
            'banners' => $banners,
            //'statusbar' => [$stats],
            'suggestedqbank' => $suggestedqbank,
            'suggested_videos' => $suggested_videos,
            'suggested_testseries' => $suggestedTestSeries,
            'pearlsList'=>$pearlsList,
        );
        TrackResponse($user_input, $response);

        $this->response($response);
    }

    public function check_user(){

        foreach (getallheaders() as $name => $value) {
            $headers[$name] = $value;
        }

       $accessToken= $headers['accessToken'];
       $user_id= $headers['userId'];

       $result=$this->db->query("select * from users where token='$accessToken' and id='$user_id' ")->row_array();
       //echo $this->db->last_query();exit;
       if(empty($result)){
         $response = array(
                'status' => false,
                'message' => 'User not exists',
                'response' => 'Request Failed 500 Error'
            );
            TrackResponse($user_input, $response);
            $this->response($response);
       }
       return ture;

    }

    /*
    
    
    
    *   Get Test Series Quizs
    
    
    
    */

    function get_test_series_quizs_get()

    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $user_input=array(
        'user_id'=>$_GET['user_id'],
        'course_id'=>$_GET['course_id']
        );

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
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

        $user_id=$user_input['user_id'];
        $course_id=$user_input['course_id'];
        
        $response = $this
            ->ws_model
            ->get_test_series_categories($user_id, $course_id);
        //$all_quizs=$this->ws_model->test_series_quiz_dates($user_id,$course_id,'all');

       // echo $this->db->last_query();exit;
        if (empty((array)$response))
        {
            $response = array(
                'status' => false,
                'message' => 'No tests found!'
            );

        }

        else

        {
                /*$new_response=array();
             foreach($response as $key =>$value){
                   
                   if(($value['exam_time'] !='') && ($value['exam_time'] !='0000-00-00')){
                       $date_ary=explode($value['exam_time']);
                      // echo '<pre>';print_r($date_ary);exit;
                       $new_exam_date= '01-'.$date_ary[1].''.$date_ary[2];
                   }
                   $new_response[$key] =$value;
                }*/
            $response = array(
                'status' => true,
                'message' => 'Tests Fetched Successfully!',
                //'all_quizs'=>$all_quizs,
                'response' => $response,

            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function getAllReviewQuestionsWithStatus_get()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $user_input=array(
        'user_id'=>$_GET['user_id'],
        'course_id'=>$_GET['course_id'],
        'category_id' => $_GET['category_id'],
        'quiz_id' => $_GET['quiz_id'],
        'bookmark'=> $_GET['bookmark'],
        );

        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'category_id' => 'Category ID',
            'quiz_id' => 'Quiz ID',
            'bookmark' => 'Bookmark',
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

        $user_id=$user_input['user_id'];
        $course_id=$user_input['course_id'];
        $category_id=$user_input['category_id'];
        $quiz_id=$user_input['quiz_id'];
        $bookmark=$user_input['bookmark'];

        
        if($bookmark == 'yes'){
        $response = $this
            ->ws_model
            ->getAllTestSeriesBookmarkQuestions($user_id, $course_id, $category_id, $quiz_id);
        }else{
         $response = $this
            ->ws_model
            ->getAllReviewQuestionsWithStatus($user_id, $course_id, $category_id, $quiz_id);   
        }

if(!empty($response)){
        $response1 = array(
            'status' => true,

            'message' => 'Answers Fetched Successfully!',

            'questions' => $response

        );
    }else{
        $response1 = array(
            'status' => true,

            'message' => 'Answers Fetched Failed!',

            'questions' => $response

        );
    }

        TrackResponse($user_input, $response1);

        $this->response($response1);

    }

    function getExamSubjects_get()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        $user_id= $_GET['user_id'];
        $exam_id= $_GET['exam_id'];
        $device_id= $_GET['device_id'];
         if(!$user_id)
        {
        
         $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        if (!$exam_id)
        {

            $response = array(
                'status' => false,
                'message' => 'Exam ID is required!',
                'response' => array()
            );

            TrackResponse($user_input, $response);
            $this->response($response);
        }

        if($device_id !=''){
            
            $this->ws_model->updateUserDeviceId($user_id,$device_id);
        }

        if($android_device_id !=''){
            
            $this->ws_model->updateUserAndroidDeviceId($user_id,$android_device_id);
        }

        $user_subjects = $this
            ->ws_model
            ->exam_subjects_new($exam_id,$user_id);

        if (empty((array)$user_subjects))

        {

            $response = array(
                'status' => false,
                'message' => 'No Subjects found!',
                'response' => array()
            );

        }

        else

        {
            $response = array(
                'status' => true,
                'message' => 'Subjects fetched Successfully!',
                'user_subjects' => $user_subjects,
                'device_id'=>$device_id
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function getQbankTopicsWithStatus_get()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        $user_id= $_GET['user_id'];
        $course_id= $_GET['course_id'];
        $subject_id= $_GET['subject_id'];
         if(!$user_id)
        {
        
         $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        if (!$course_id)
        {
            $response = array(
                'status' => false,
                'message' => 'course ID is required!',
                'response' => array()
            );

            TrackResponse($user_input, $response);
            $this->response($response);
        }

        if (!$subject_id)
        {
            $response = array(
                'status' => false,
                'message' => 'subject ID is required!',
                'response' => array()
            );

            TrackResponse($user_input, $response);
            $this->response($response);
        }

        $qbanktopics = $this
            ->ws_model
            ->getQbankTopicsWithStatus($user_id, $course_id, $subject_id,'0');

        if (empty((array)$qbanktopics))

        {

            $response = array(
                'status' => false,
                'message' => 'No Topics found!',
                'response' => array()
            );

        }

        else

        {
            $response = array(
                'status' => true,
                'message' => 'Topics fetched Successfully!',
                'response' => $qbanktopics
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function postQbankTopicsWithStatus_post()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);
        $required_params = array(
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'subject_id' => 'Subject ID'
        );
        
        foreach ($required_params as $key => $value){

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

        $user_id=$user_input['user_id'];
        $course_id=$user_input['course_id'];
        $subject_id=$user_input['subject_id'];

        $qbanktopics = $this
            ->ws_model
            ->getQbankTopicsWithStatus($user_id, $course_id, $subject_id,'0');

        if (empty((array)$qbanktopics))

        {

            $response = array(
                'status' => false,
                'message' => 'No Topics found!',
                'response' => array()
            );

        }

        else

        {
            $response = array(
                'status' => true,
                'message' => 'Topics fetched Successfully!',
                'response' => $qbanktopics
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }


    function getPackagesList_get()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $user_id= $_GET['user_id'];
        $course_id= $_GET['course_id'];
        
         if(!$user_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

    

        $packagesList = $this->ws_model->getPackagesList($user_id,$course_id);
        if (empty((array)$packagesList)){
            $response = array(
                'status' => false,
                'message' => 'No Packages found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Packages fetched Successfully!',
                'response' => $packagesList
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);
    }

    function getCouponsList_get()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $couponsList = $this->ws_model->getCouponsList();
        if (empty((array)$couponsList)){
            $response = array(
                'status' => false,
                'message' => 'No Coupons found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Coupons fetched Successfully!',
                'response' => $couponsList
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);
    }

    function getPackageDetails_get()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $package_id= $_GET['package_id'];
        
         if(!$package_id)
        {
        $response = array('status' => false, 'message' => 'Package ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        $packageDetails = $this->ws_model->getPackageDetails($package_id);
        if (empty((array)$packageDetails)){
            $response = array(
                'status' => false,
                'message' => 'Data Not found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Data fetched Successfully!',
                'response' => $packageDetails
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);
    }

    function applyCoupon_get()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $price_id  = $_GET['price_id'];
        $coupon_code = $_GET['coupon_code'];
        
         if(!$price_id)
        {
        $response = array('status' => false, 'message' => 'Package ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        if(!$coupon_code)
        {
        $response = array('status' => false, 'message' => 'Coupon Code is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        $result = $this->ws_model->applyCoupon($price_id,$coupon_code);
        
        if($result['applied_discount'] == ''){

            $response = array(
                'status' => false,
                'message' => 'Data fetched failed!',
                'response' => $result['final_price'],
                'applied_discount'=>$result['applied_discount']
            );

        }else{
        $response = array(
                'status' => true,
                'message' => 'Data fetched Successfully!',
                'response' => $result['final_price'],
                'applied_discount'=>$result['applied_discount']
            );
        }
        
        TrackResponse($user_input, $response);
        $this->response($response);
    }

    function paymentRespone_get(){

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $user_id= $_GET['user_id'];
        
         if(!$user_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        $paymetRespone = $this->ws_model->getpaymetRespone($user_id);
        if (empty((array)$paymetRespone)){
            $response = array(
                'status' => false,
                'message' => 'Data Not found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Data fetched Successfully!',
                'response' => $paymetRespone
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);

    }

    function customQuestions_get(){

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $user_id= $_GET['user_id'];
       // $subject_ids= $_GET['subject_ids'];
        $topic_ids= $_GET['topic_ids'];
        $difficult_levels= $_GET['difficult_level'];
        $limit=$_GET['no_of_ques'];
        $paper_name=$_GET['paper_name'];
        
        //echo '<pre>';print_r($_GET);exit;
        if(!$user_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        /*if(!$subject_ids)
        {
        $response = array('status' => false, 'message' => 'Subject ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }*/

        if(!$topic_ids)
        {
        $response = array('status' => false, 'message' => 'Topic IDs is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        if(!$difficult_levels)
        {
        $response = array('status' => false, 'message' => 'Dificulty Level is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        if(!$paper_name)
        {
        $response = array('status' => false, 'message' => 'Paper Name is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

      $questions_list = $this->ws_model->getCustomQuestions($user_id,$topic_ids,$difficult_levels,$limit,$paper_name);
      $questions_count=count($questions_list);


        if (empty((array)$questions_list)){
            $response = array(
                'status' => false,
                'message' => 'Data Not found!',
                'response' => array()
            );
        }else{
            $unquie_exam_id=$this->ws_model->getCustomExamID();
            $insert_data=array(
                                'user_id'=>$user_id,
                                'exam_id'=>$unquie_exam_id,
                                'paper_name'=>$paper_name,
                              );
            $this->db->insert('custom_module_exam_marks',$insert_data);

            $insert_data1=array(
                                'user_id'=>$user_id,
                                'exam_id'=>$unquie_exam_id,
                                'exam_status'=>'in_progress',
                                'topic_ids'=> $topic_ids,
                                'difficult_levels'=> $difficult_levels,
                                'created_on'=>date('Y-m-d H:i:s')
                              );
            $this->db->insert('custom_module_user_exam_status',$insert_data1);


            $response = array(
                'status' => true,
                'message' => 'Data fetched Successfully!',
                'unquie_exam_id'=> $unquie_exam_id,
                'questions_count'=>$questions_count,
                'response' => $questions_list,
                
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);
    }

    public function getTopicsWithSubjectID_get(){

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $user_id= $_GET['user_id'];
        $subject_id= $_GET['subject_id'];
        
        //echo '<pre>';print_r($_GET);exit;
        if(!$user_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        if(!$subject_id)
        {
        $response = array('status' => false, 'message' => 'Subject ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        $topics_list = $this->ws_model->getTopicsWithSubjectID($user_id,$subject_id);

        if (empty((array)$topics_list)){
            $response = array(
                'status' => false,
                'message' => 'Data Not found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Data fetched Successfully!',
                'response' => $topics_list
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);
    }

    function addCustomBookmark_post(){

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );

        $user_input = $this->client_request;

        extract($user_input);

        if (!$question_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Question Id Required!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$user_id)

        {

            $response = array(
                'status' => false,
                'message' => 'User Id Required!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        if (!$exam_id)

        {

            $response = array(
                'status' => false,
                'message' => 'Exam Id Required!',
                'response' => array()
            );

            TrackResponse($user_input, $response);

            $this->response($response);

        }

        $data = array(

            'user_id' => $user_id,

            'exam_id' => $exam_id,

            'question_id' => $question_id

        );

        $custom_module_qbank_bookmarks = get_table_row('custom_module_qbank_bookmarks', $data);

        //  print_r($bookmarks);exit;
        

        if (!empty($custom_module_qbank_bookmarks))
        {

            $delete = delete_record('custom_module_qbank_bookmarks', $data);

            $response = array(
                'status' => false,
                'message' => 'Bookmark Deleted successfully!',
                'response' => array()
            );

            $this->response($response);

        }

        else
        {

            $data['created_on'] = date('Y-m-d H:i:s');

            $bookmark_id = insert_table('custom_module_qbank_bookmarks', $data);

        }

        //print_r($total_questions);exit;
        

        if (empty($bookmark_id))

        {

            $response = array(
                'status' => false,
                'message' => 'No Data Found!',
                'response' => array()
            );

        }

        else

        {

            $response = array(
                'status' => true,
                'message' => 'Bookmark Added Successfully!'
            );

        }

        TrackResponse($user_input, $response);

        $this->response($response);

    }

    function getCustomModuleReviewQbankQuestionAnalysis_post()
    {

        $response = array(
            'status' => false,
            'message' => ''
        );

        $user_input = $this->client_request;

        extract($user_input);

        $required_params = array(
            'user_id' => 'User ID',
            'question_id' => 'Question Id',
            'exam_id'=>'Exam Id'
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

        $response = $this->wssub_model->get_custom_review_quiz_question_analysis($user_id, $question_id,$exam_id);

        $percentage = $this->wssub_model->get_custom_allusers_quiz_percentage($question_id);


        if ($percentage['total_count'] != 0)
        {

            $correct_percentage = ($percentage['correct_count'] / $percentage['total_count']) * 100;

            $option_a = ($percentage['option_a'] / $percentage['total_count']) * 100;

            $option_b = ($percentage['option_b'] / $percentage['total_count']) * 100;

            $option_c = ($percentage['option_c'] / $percentage['total_count']) * 100;

            $option_d = ($percentage['option_d'] / $percentage['total_count']) * 100;

            $correct_percentage = number_format($correct_percentage);

            $option_a = number_format($option_a);

            $option_b = number_format($option_b);

            $option_c = number_format($option_c);

            $option_d = number_format($option_d);

            if (array_key_exists('0', $response['options'])){
                      $response['options'][0]['percentage']= $option_a; 
                    }
            if (array_key_exists('1', $response['options'])){
                      $response['options'][1]['percentage']= $option_b; 
                    }
            if (array_key_exists('2', $response['options'])){
                      $response['options'][2]['percentage']= $option_c; 
                    }
            if (array_key_exists('3', $response['options'])){
                      $response['options'][3]['percentage']= $option_d; 
                    }

            $percentage = array(

                'correct_percentage' => $correct_percentage,

            );

        }

        else
        {
            if (array_key_exists('0', $response['options'])){
                      $response['options'][0]['percentage']= 0; 
                    }
            if (array_key_exists('1', $response['options'])){
                      $response['options'][1]['percentage']= 0; 
                    }
            if (array_key_exists('2', $response['options'])){
                      $response['options'][2]['percentage']= 0; 
                    }
            if (array_key_exists('3', $response['options'])){
                      $response['options'][3]['percentage']= 0; 
                    }

            $percentage = array(

                'correct_percentage' => 0,

            );

        }

        $response = array(
            'status' => true,
            'message' => 'Data Fetched Successfully!',
            'response' => $response,
            'percentage' => $percentage
        );

        TrackResponse($user_input, $response);

        $this->response($response);

    }


    public function getCustomModuleExamList_get(){

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $user_id= $_GET['user_id'];

        if(!$user_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        $exams_list = $this->wssub_model->getCustomModuleExamList($user_id);

        if (empty((array)$exams_list)){
            $response = array(
                'status' => false,
                'message' => 'Data Not found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Data fetched Successfully!',
                'response' => $exams_list
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);
    }

    
    
     public function getCustomQuestionsWithExamID_get(){

         $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $exam_id= $_GET['exam_id'];

        if(!$exam_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        $questions_list = $this->wssub_model->getCustomQuestionsWithExamID($exam_id);
        $exam_data = $this->wssub_model->getCustomExamStatusWithExamID($exam_id);

        $topics_count= count(explode(',',$exam_data['topic_ids']));

        if (empty((array)$questions_list)){
            $response = array(
                'status' => false,
                'message' => 'Data Not found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Data fetched Successfully!',
                'questions_count'=> count($questions_list),
                'topics_count'=> $topics_count,
                'difficult_levels'=> $exam_data['difficult_levels'],
                'response' => $questions_list,
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);

     }

     public function CustomModuleQbankQuestionReport_post(){

         $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        if(!$exam_id)
        {
        $response = array('status' => false, 'message' => 'Exam ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        if(!$user_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        if(!$question_id)
        {
        $response = array('status' => false, 'message' => 'Question ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        $result = $this->wssub_model->getCustomModuleQbankQuestionReport($exam_id,$user_id,$question_id);
        if (empty((array)$result)){
            $response = array(
                'status' => false,
                'message' => 'Data Not found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Data Report Successfully!',
                'response' => $result,
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);

     }


     public function getTestSeriesCategoriesWithCourseID_get(){

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $course_id=$_GET['course_id'];
        $user_id=$_GET['user_id'];
        $device_id=$_GET['device_id'];
        if(!$course_id)
        {
        $response = array('status' => false, 'message' => 'Course ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        if(!$user_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        if($device_id !=''){
            
            $this->ws_model->updateUserDeviceId($user_id,$device_id);
        }

        if($android_device_id !=''){
            
            $this->ws_model->updateUserAndroidDeviceId($user_id,$android_device_id);
        }

        $result = $this->wssub_model->getTestSeriesCategoriesWithCourseID($course_id,$user_id);
        $device_id=$this->ws_model->userDeviceId($user_id);

        if (empty((array)$result)){
            $response = array(
                'status' => false,
                'message' => 'Data Not found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Data Report Successfully!',
                'response' => $result,
                'device_id'=>$device_id
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);
     }


     public function getTestSeriesWithCourseAndCategoryIDs_get(){

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $course_id=$_GET['course_id'];
        $category_id=$_GET['category_id'];
        $user_id=$_GET['user_id'];

        if(!$course_id)
        {
        $response = array('status' => false, 'message' => 'Course ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        if(!$user_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        if(!$category_id)
        {
        $response = array('status' => false, 'message' => 'Category ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        $result = $this->wssub_model->getTestSeriesWithCourseAndCategoryID($course_id,$user_id,$category_id);

        if (empty((array)$result)){
            $response = array(
                'status' => false,
                'message' => 'Data Not found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Data Report Successfully!',
                'response' => $result,
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);

    }

    public function getAllTestSeriesList_get(){

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $course_id=$_GET['course_id'];
        $user_id=$_GET['user_id'];

        if(!$course_id)
        {
        $response = array('status' => false, 'message' => 'Course ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        if(!$user_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        
         $result = $this->wssub_model->getAllTestSeriesList($course_id,$user_id);

        if (empty((array)$result)){
            $response = array(
                'status' => false,
                'message' => 'Data Not found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Data Report Successfully!',
                'response' => $result,
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);

    }


    public function getQbankBookmarks_get(){

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
       
        $user_id=$_GET['user_id'];
        $start_limit=$_GET['start_limit'];
        $end_limit=$_GET['end_limit'];

        if(!$user_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        
        if(!$start_limit)
        {
        $response = array('status' => false, 'message' => 'Start Limit is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        if(!$end_limit)
        {
        $response = array('status' => false, 'message' => 'End Limit is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

         $result = $this->wssub_model->getQbankBookmarks($user_id,$start_limit,$end_limit);

        if (empty((array)$result)){
            $response = array(
                'status' => false,
                'message' => 'Data Not found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $result,
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);

    }


    public function getTestSeriesBookmarks_get(){

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
       
        $user_id=$_GET['user_id'];
        $start_limit=$_GET['start_limit'];
        $end_limit=$_GET['end_limit'];

        if(!$user_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        if(!$start_limit)
        {
        $response = array('status' => false, 'message' => 'Start Limit is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        if(!$end_limit)
        {
        $response = array('status' => false, 'message' => 'End Limit is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        
         $result = $this->wssub_model->getTestSeriesBookmarks($user_id,$start_limit,$end_limit);

        if (empty((array)$result)){
            $response = array(
                'status' => false,
                'message' => 'Data Not found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $result,
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);

    }


    public function getuserPaymentStatus_post(){

        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
       
        //$user_id=$_GET['user_id'];       

        if(!$user_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
              
        $result = $this->wssub_model->getuserPaymentStatus($user_id);

        if (empty((array)$result)){
            $response = array(
                'status' => false,
                'message' => 'Data Not found!',
                'response' => array()
            );
        }else{
            $response = array(
                'status' => true,
                'message' => 'Data Fetched Successfully!',
                'response' => $result,
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);

    }

   
    function activateFreePackage_get()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);
        $user_id= $_GET['user_id'];
        $package_id= $_GET['package_id'];
        
         if(!$user_id)
        {
        $response = array('status' => false, 'message' => 'User ID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }
        if(!$package_id)
        {
        $response = array('status' => false, 'message' => 'PackageID is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }


        $packagesList = $this->wssub_model->activateFreePackage($user_id,$package_id);
       // $packagesList1=1;

        //if($packagesList1 == 1){
            
            $response = array(
                'status' => true,
                'message' => 'Package activated Successfully!',
                'response' => true
            );
       /* }else{
            $response = array(
                'status' => false,
                'message' => 'Package already Activated!',
                'response' => false
            );
        }*/
        TrackResponse($user_input, $response);
        $this->response($response);
    }

    function getFreePackage_get()
    {
        $response = array(
            'status' => false,
            'message' => '',
            'response' => array()
        );
        $user_input = $this->client_request;
        extract($user_input);

        $free_package = $this->wssub_model->getFreePackage();
        if(!empty($free_package)){
            
            $response = array(
                'status' => true,
                'message' => 'Package Fetched Successfully!',
                'response' => $free_package
            );
        }else{
            $response = array(
                'status' => false,
                'message' => 'Package Not Fetched!',
                'response' => false
            );
        }
        TrackResponse($user_input, $response);
        $this->response($response);
    }



}

?>
