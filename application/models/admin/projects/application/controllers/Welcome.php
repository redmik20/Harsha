<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public $header='website/includes/header';
	public $footer='website/includes/footer';

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");	
		$this->load->helper('url');	
		$this->load->model('welcome_model');
	}
	

	public function index()
	{
		$header['exams']= $this->welcome_model->get_all_courses();
		$this->load->view($this->header,$header);
		$this->load->view('website/index');
		$this->load->view($this->footer);
	}

	public function about_us()
	{
		$header['exams']= $this->welcome_model->get_all_courses();
		$this->load->view($this->header,$header);
		$this->load->view('website/about');
		$this->load->view($this->footer);
	}

	public function contact_us()
	{
		$header['exams']= $this->welcome_model->get_all_courses();
		$this->load->view($this->header,$header);
		$this->load->view('website/contact_us');
		$this->load->view($this->footer);
	}

	public function privacy_policy()
	{
		$header['exams']= $this->welcome_model->get_all_courses();
		$this->load->view($this->header,$header);
		$this->load->view('website/privacy_policy');
		$this->load->view($this->footer);
	}

	public function payment_policy()
	{
		$header['exams']= $this->welcome_model->get_all_courses();
		$this->load->view($this->header,$header);
		$this->load->view('website/payment');
		$this->load->view($this->footer);
	}

	public function terms_conditions()
	{
		$header['exams']= $this->welcome_model->get_all_courses();
		$this->load->view($this->header,$header);
		$this->load->view('website/terms_conditions');
		$this->load->view($this->footer);
	}

	public function course_details($id)
	{		
		$header['exams']= $this->welcome_model->get_all_courses();
		$this->load->view($this->header,$header);
		$this->load->view('website/course_details');
		$this->load->view($this->footer);
	}


public function copyApSIVideosToTsSIVideos(){
		$from_subject_id=$_GET['from_subject_id'];
		$to_subject_id=$_GET['to_subject_id'];
		//echo '<pre>';print_r($subject_id);exit;
		$query="select * from videochapters where course_id='27' and subject_id='".$from_subject_id."'";
		$videochapters=$this->db->query($query)->result_array();

		foreach ($videochapters as $key => $videochp) {

			$insert_videos= array(
				'course_id' => '33',
				'subject_id' => $to_subject_id,
				'name' => $videochp['name'],
				'title' => $videochp['title'],
				'banner_image' => $videochp['banner_image'],
				'icon_image' => $videochp['icon_image'],
				'order' => $videochp['order'],
				'status' => $videochp['status'],
				'created_on' => date('Y-m-d H:i:s'),

				 );
			$query=$this->db->insert('videochapters',$insert_videos);
			$db_video_chapter_id=$this->db->insert_id();

			$query="select * from chapters where exam_id='27' and subject_id='".$from_subject_id."'  and chapter_id='".$videochp['id']."' ";
			$chapters=$this->db->query($query)->result_array();

			foreach ($chapters as $key => $chap) {				
				$insert_chapters = array(									
									'exam_id' => '33',
									'subject_id' => $to_subject_id,
									'chapter_id' => $db_video_chapter_id,
									'video_name' => $chap['video_name'],
									'chapter_name' => $chap['chapter_name'],
									'order' => $chap['order'],
									'image' => $chap['image'],
									'chapter_actorname' => $chap['chapter_actorname'],
									'video_path' => $chap['video_path'],
									'youtube_video_url' => $chap['youtube_video_url'],
									'video_id' => $chap['video_id'],
									'specialization' => $chap['specialization'],
									'total_time' => $chap['total_time'],
									'notespdf' => $chap['notespdf'],
									'suggest_video_banner' => $chap['suggest_video_banner'],
									'suggested_videos' => $chap['suggested_videos'],
									'free_or_paid' => $chap['free_or_paid'],
									'video_date' => $chap['video_date'],
									'notespdf_path' => $chap['notespdf_path'],
									'materialpdf_path' => $chap['materialpdf_path'],
									'status' => $chap['status'],
									'delete_status' => $chap['delete_status'],
									'created_on' => date('Y-m-d H:i:s'),

									 );
				$query=$this->db->insert('chapters',$insert_chapters);
				$db_chapter_videos_id=$this->db->insert_id();

				$query="select * from chapters_slides where exam_id='27' and subject_id='".$from_subject_id."' and chapter_id='".$chap['id']."'  ";
			    $chapter_slides=$this->db->query($query)->row_array();

			    if(!empty($chapter_slides)){

			    	$insert_chapter_slide=array(
									'exam_id' => '33',
									'subject_id' => $to_subject_id,
									'chapter_id' => $db_chapter_videos_id,
									'chapters_status' => $chapter_slides['chapters_status'],
									'image' => $chapter_slides['image'],
									'delete_status' => $chapter_slides['delete_status'],
									'created_on' => date('Y-m-d H:i:s'),
			    	                           );
					$query=$this->db->insert('chapters_slides',$insert_chapter_slide);
			    }


				$query="select * from video_topics where exam_id='27' and subject_id='".$from_subject_id."' and chapter_id='".$chap['id']."' ";
				$topic_videos=$this->db->query($query)->result_array();

				foreach ($topic_videos as $key => $topic) {

					$insert_topic_videos = array(
						'exam_id' => '33',
						'subject_id' => $to_subject_id,
						'chapter_id' => $db_chapter_videos_id,
						'topic_name' => $topic['topic_name'],
						'start_time' => $topic['start_time'],
						'free_or_paid' => $topic['free_or_paid'],
						'delete_status' => $topic['delete_status'],
						'created_on' => date('Y-m-d H:i:s'),
								);					
					$query=$this->db->insert('video_topics',$insert_topic_videos);
				}
			}			
		}
		echo "videos copied from '".$from_subject_id."'  to '".$to_subject_id."' ";		
	}




		public function updateTestSeriesToJosnStructure(){

			
			$testUsers=$this->db->query("SELECT DISTINCT(user_id)  FROM test_series_answers")->result_array();

			//echo '<pre>';print_r($testUsers);exit;
			foreach($testUsers as $k=>$v){

				$query="SELECT DISTINCT(quiz_id) FROM test_series_answers WHERE user_id='".$v['user_id']."'";
				$userWithQuizs=$this->db->query($query)->result_array();
				//echo '<pre>';print_r($userWithQuizs);exit;
				foreach($userWithQuizs as $key=>$value){ 
				$users=array('user_id'=>$v['user_id'],'quiz_id'=>$value['quiz_id']);
				//echo '<pre>';print_r($users);exit;

				$que_question="SELECT * FROM test_series_answers where user_id='".$v['user_id']."' and quiz_id='".$value['quiz_id']."' ORDER BY question_order_id ASC";
				$userQuiz_questions=$this->db->query($que_question)->result_array();
				   $newQue_array=array();
				   foreach($userQuiz_questions as $qk=>$qv){
				   			$newQue_array[$qv['question_id']]=array(
				   													'question_order_id'=>$qv['question_order_id'],
				   													'question_id'=>$qv['question_id'],
				   													'option_id'=>$qv['option_id'],
				   													'answer'=>$qv['answer'],
				   													'correct_answer'=>$qv['correct_answer'],
				   													'answer_status'=>$qv['answer_status'],
				   													'answer_sub_status'=>$qv['answer_sub_status'],
				   													'marks'=>$qv['marks'],
				   													'created_on'=>$qv['created_on'],
				   			                     					);
				   }

				   //echo '<pre>';print_r(json_encode($newQue_array));exit;
				    $json_object=json_encode($newQue_array);
				    $insert_array=array(
				    					'user_id'=>$userQuiz_questions[0]['user_id'],
				    					'course_id'=>$userQuiz_questions[0]['course_id'],
				    					'category_id'=>$userQuiz_questions[0]['category_id'],
				    					'quiz_id'=>$userQuiz_questions[0]['quiz_id'],
				    					'submit_json'=>$json_object,
				    					'created_on'=>date('Y-m-d H:i:s')
				    					);
				   // echo '<pre>';print_r($insert_array);exit;
				    $this->db->insert('test_series_answers_json',$insert_array);
				}

			}

			echo 'done mister srinivas..';exit;

		}

		public function updateQbankToJosnStructure(){

			
			$testUsers=$this->db->query("SELECT DISTINCT(user_id)  FROM quiz_answers")->result_array();

			//echo '<pre>';print_r($testUsers);exit;
			foreach($testUsers as $k=>$v){

				$query="SELECT DISTINCT(qbank_topic_id) FROM quiz_answers WHERE user_id='".$v['user_id']."'";
				$userWithQuizs=$this->db->query($query)->result_array();
				//echo '<pre>';print_r($userWithQuizs);exit;
				foreach($userWithQuizs as $key=>$value){ 
				$users=array('user_id'=>$v['user_id'],'qbank_topic_id'=>$value['qbank_topic_id']);
				//echo '<pre>';print_r($users);exit;

				$que_question="SELECT * FROM quiz_answers where user_id='".$v['user_id']."' and qbank_topic_id='".$value['qbank_topic_id']."' ORDER BY question_order_id ASC";
				$userQuiz_questions=$this->db->query($que_question)->result_array();
				   $newQue_array=array();
				   foreach($userQuiz_questions as $qk=>$qv){
				   			$newQue_array[$qv['question_id']]=array(
				   													'question_order_id'=>$qv['question_order_id'],
				   													'question_id'=>$qv['question_id'],
				   													'option_id'=>$qv['option_id'],
				   													'answer'=>$qv['answer'],
				   													'correct_answer'=>$qv['correct_answer'],
				   													'answer_status'=>$qv['answer_status'],
				   			                     					);
				   }

				   //echo '<pre>';print_r(json_encode($newQue_array));exit;
				    $json_object=json_encode($newQue_array);
				    $insert_array=array(
				    					'user_id'=>$userQuiz_questions[0]['user_id'],
				    					'course_id'=>$userQuiz_questions[0]['course_id'],
				    					'subject_id'=>$userQuiz_questions[0]['subject_id'],
				    					'topic_id'=>$userQuiz_questions[0]['topic_id'],
				    					'qbank_topic_id'=>$userQuiz_questions[0]['qbank_topic_id'],
				    					'submit_json'=>$json_object,
				    					'created_on'=>date('Y-m-d H:i:s')
				    					);
				   // echo '<pre>';print_r($insert_array);exit;
				    $this->db->insert('quiz_answers_json',$insert_array);
				}

			}

			echo 'Done Mister srinivas..';exit;

		}


		public function updateTestSeriesQuestionID(){

			$test_series_questions=$this->db->query("select id from test_series_questions")->result_array();

			foreach($test_series_questions as $key=>$value){
				$question_dynamic_id=$this->get_TestSeriesdynamic_id();
				$update_data=array(
									'question_dynamic_id'=>$question_dynamic_id,
				                  );
				$this->db->update('test_series_questions',$update_data,array('id'=>$value['id']));
			}
			echo 'Done Question Ids Updated successfully...';exit;
		}


		public function get_TestSeriesdynamic_id(){

        /* Reference No */
        $reference_id='';
        $this->db->select("*");
        $this->db->from('tbl_dynamic_nos');
        $query = $this->db->get();
        $row_count = $query->num_rows();
        if($row_count > 0){

            $refers_no = $query->row_array();
            $ref_no=$refers_no['test_series_question_no']+1;
            $refernce_data = array('test_series_question_no' => $ref_no,
                                   'update_date_time'    => date('Y-m-d H:i:s')
                                   );
            $this->db->where('id',1);
            $update = $this->db->update('tbl_dynamic_nos', $refernce_data);
        }else{

            $ref_no=1;
            $refernce_data = array('test_series_question_no' => $ref_no,
                                    'update_date_time'   => date('Y-m-d H:i:s')
                                    );
            $update = $this->db->insert('tbl_dynamic_nos', $refernce_data); 
        }
        
        
        $reference_id =  'QUET'.$ref_no;
        
        //$reference_id="BBM".$ref_no;
        /* Reference No */
        return $reference_id;
}

public function copyAPSIConsVideosTSPPCGroupVideos(){
		$from_subject_id=$_GET['from_subject_id'];
		$to_subject_id=$_GET['to_subject_id'];
		//echo '<pre>';print_r($subject_id);exit;
		$query="select * from videochapters where course_id='27' and subject_id='".$from_subject_id."'";
		$videochapters=$this->db->query($query)->result_array();

		foreach ($videochapters as $key => $videochp) {

			$insert_videos= array(
				'course_id' => '34',
				'subject_id' => $to_subject_id,
				'name' => $videochp['name'],
				'title' => $videochp['title'],
				'banner_image' => $videochp['banner_image'],
				'icon_image' => $videochp['icon_image'],
				'order' => $videochp['order'],
				'status' => $videochp['status'],
				'created_on' => date('Y-m-d H:i:s'),

				 );
			$query=$this->db->insert('videochapters',$insert_videos);
			$db_video_chapter_id=$this->db->insert_id();

			$query="select * from chapters where exam_id='27' and subject_id='".$from_subject_id."'  and chapter_id='".$videochp['id']."' ";
			$chapters=$this->db->query($query)->result_array();

			foreach ($chapters as $key => $chap) {				
				$insert_chapters = array(									
									'exam_id' => '34',
									'subject_id' => $to_subject_id,
									'chapter_id' => $db_video_chapter_id,
									'video_name' => $chap['video_name'],
									'chapter_name' => $chap['chapter_name'],
									'order' => $chap['order'],
									'image' => $chap['image'],
									'chapter_actorname' => $chap['chapter_actorname'],
									'video_path' => $chap['video_path'],
									'youtube_video_url' => $chap['youtube_video_url'],
									'video_id' => $chap['video_id'],
									'specialization' => $chap['specialization'],
									'total_time' => $chap['total_time'],
									'notespdf' => $chap['notespdf'],
									'suggest_video_banner' => $chap['suggest_video_banner'],
									'suggested_videos' => $chap['suggested_videos'],
									'free_or_paid' => $chap['free_or_paid'],
									'video_date' => $chap['video_date'],
									'notespdf_path' => $chap['notespdf_path'],
									'materialpdf_path' => $chap['materialpdf_path'],
									'status' => $chap['status'],
									'delete_status' => $chap['delete_status'],
									'created_on' => date('Y-m-d H:i:s'),

									 );
				$query=$this->db->insert('chapters',$insert_chapters);
				$db_chapter_videos_id=$this->db->insert_id();

				$query="select * from chapters_slides where exam_id='27' and subject_id='".$from_subject_id."' and chapter_id='".$chap['id']."'  ";
			    $chapter_slides=$this->db->query($query)->row_array();

			    if(!empty($chapter_slides)){

			    	$insert_chapter_slide=array(
									'exam_id' => '34',
									'subject_id' => $to_subject_id,
									'chapter_id' => $db_chapter_videos_id,
									'chapters_status' => $chapter_slides['chapters_status'],
									'image' => $chapter_slides['image'],
									'delete_status' => $chapter_slides['delete_status'],
									'created_on' => date('Y-m-d H:i:s'),
			    	                           );
					$query=$this->db->insert('chapters_slides',$insert_chapter_slide);
			    }


				$query="select * from video_topics where exam_id='27' and subject_id='".$from_subject_id."' and chapter_id='".$chap['id']."' ";
				$topic_videos=$this->db->query($query)->result_array();

				foreach ($topic_videos as $key => $topic) {

					$insert_topic_videos = array(
						'exam_id' => '34',
						'subject_id' => $to_subject_id,
						'chapter_id' => $db_chapter_videos_id,
						'topic_name' => $topic['topic_name'],
						'start_time' => $topic['start_time'],
						'free_or_paid' => $topic['free_or_paid'],
						'delete_status' => $topic['delete_status'],
						'created_on' => date('Y-m-d H:i:s'),
								);					
					$query=$this->db->insert('video_topics',$insert_topic_videos);
				}
			}			
		}
		echo "videos copied from '".$from_subject_id."'  to '".$to_subject_id."' ";		
	}
    

    /*public function assign_examstousers(){

    	$users=$this->db->query("select id,batch_id from users")->result_array();

    		foreach($users as $user){

    			$exam=$this->db->query("select id from exams where bhatia_batch_id=".$user['batch_id']." ")->row_array();

    			$insert=array(
    							'user_id'=> $user['id'],
    							'exam_id'=> $exam['id'],
    							'payment_type'=>'paid',
    							'delete_status'=>1,
    							'status'=>'Active',
    							'created_on'=> date('Y-m-d H:i:s')
    						  );

    			$this->db->insert('users_exams',$insert);
    		}
        echo 'script excuted successfully...';exit;
    }*/


}