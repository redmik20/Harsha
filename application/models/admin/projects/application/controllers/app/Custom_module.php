 <?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'libraries/RESTful/REST_Controller.php';

class Custom_module extends REST_Controller
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
        

        $this
            ->load
            ->helper('app/ws_helper');

        $this
            ->load
            ->model('app/Custom_model','my_model');
        $this
            ->load
            ->model('Common_model');

        $this->client_request = new stdClass();

        $this->client_request = json_decode(file_get_contents('php://input', true));

        $this->client_request = json_decode(json_encode($this->client_request) , true);

        //$this->check_user();

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
        $subject_id= $_GET['subject_id'];
        $topic_ids= $_GET['topic_ids'];
        $difficult_level= $_GET['difficult_level'];
        
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

        if(!$topic_ids)
        {
        $response = array('status' => false, 'message' => 'Topic IDs is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

        if(!$difficult_level)
        {
        $response = array('status' => false, 'message' => 'Dificulty Level is required!', 'response' => array());
         TrackResponse($user_input, $response);
         $this->response($response);
        }

      $questions_list = $this->my_model->getCustomQuestions($user_id,$subject_id,$topic_ids,$difficult_level);
      $questions_count=count($questions_list);

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

        $topics_list = $this->my_model->getTopicsWithSubjectID($user_id,$subject_id);

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


}

?>