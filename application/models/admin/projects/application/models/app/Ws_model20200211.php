<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ws_model extends CI_Model
{
	function set_users($RecordData = NULL)
	{
		if($RecordData)
		{
			$this->db->insert('users_exams', $RecordData);
			//echo $this->db->last_query();exit;
			$insert_id = $this->db->insert_id();
			return $insert_id;			
		}
		return 0;
	}
		
	function check_user_deleted($mobile)
	{
		$this->db->where('delete_status', 1);
		$this->db->where('mobile', $mobile);
        //$this->db->or_where('email_id',$email_id);
		$user_status = $this->db->get('users');
  		//echo $this->db->last_query();exit;
		if($user_status->num_rows() > 0)
		{
			return $user_status->row();
		}
		return array();
	}

	function check_user_status($mobile)
	{
		$this->db->where('status', 'Active');
		$this->db->where('mobile', $mobile);
		//$this->db->or_where('email_id',$email_id);
		$user_status = $this->db->get('users');	
		//echo $this->db->last_query();exit;
		if($user_status->num_rows() > 0)
		{
			return $user_status->row();
		}
		return array();
	}

	function update_user($RecordData = NULL, $user_id = NULL)
	{		
		if($RecordData)
		{				
			$this->db->update('users', $RecordData, array('id' => $user_id));

			//echo $this->db->last_query();exit;
			return true;	
		}
		return false;
	}

	function list_user()
	{	
		//$this->db->where('type', $id);
		$list_users = $this->db->get('users');	
		//echo $this->db->last_query();exit;
		if($list_users->num_rows() > 0)
		{
			return $list_users->result();
		}
		return array();
	}

	function check_contact_number_exists($contact_number, $venue_id = NULL)
	{	
		if($venue_id)
		{
			$this->db->where('id !=', $venue_id);
		}
		$this->db->where('contact_number', $contact_number);
		$contact_number_exists = $this->db->get('venues');	
		//echo $this->db->last_query();exit;
		if($contact_number_exists->num_rows() > 0)
		{
			return false;
		}
		return true;
	}

	function check_email_id_exists($email_id, $venue_id = NULL)
	{	
		if($venue_id)
		{
			$this->db->where('id !=', $venue_id);
		}
		$this->db->where('email_id', $email_id);
		$contact_number_exists = $this->db->get('venues');	
		//echo $this->db->last_query();exit;
		if($contact_number_exists->num_rows() > 0)
		{
			return false;
		}
		return true;
	}

	function user_exams($user_id)
	{	
		$this->db->where('exams.delete_status', 1);
		$this->db->where('ue.delete_status', 1);
		$this->db->where('ue.user_id', $user_id);
		$this->db->join('exams', 'exams.id = ue.exam_id');
		$this->db->select('ue.*, exams.name as exam_name,exams.image');
		$this->db->select("IF ((SELECT COUNT(*) FROM `users_exams` where user_id = '$user_id' and users_exams.exam_id = ue.exam_id) >0, 'yes', 'no') as users_exams");
		$users = $this->db->get('users_exams ue');	
		//echo $this->db->last_query();exit;
		if($users->num_rows() > 0)
		{
			return $users->result();
		}
		return array();
	}

	function user_login($mobile, $password)
	{	
		$this->db->where('delete_status', 1);
		$this->db->where('mobile', $mobile);
		$this->db->where('password', md5($password));
		$user_login = $this->db->get('users');	
		//echo $this->db->last_query();exit;		
		if($user_login->num_rows() > 0)
		{
			return $user_login->row_array();
		}
		return array();
	}
	
  	function banners()
	{
		$this->db->where('delete_status', 1);
		$banners = $this->db->get('banners');	
		//echo $this->db->last_query();exit;
		if($banners->num_rows() > 0)
		{
			return $banners->result();
		}
		return array();
	} 
	
	function right_answers($user_id, $quizs_id, $type)
    {
        $this->db->order_by('user_qbank.id', 'asc');
        if($type == "right")
        {
            $this->db->where('user_qbank.answer_status', 'correct');
        }
        elseif($type == "wrong")
        {
            $this->db->where('user_qbank.answer_status', 'wrong');
        } 
        elseif($type == "all")
        {
            
        } 
        else
        {
            $this->db->where('user_qbank.answer_status', 'not answered');
        } 
        $this->db->where('user_qbank.user_id', $user_id);
        $this->db->where('user_qbank.topic_id', $quizs_id);
        $this->db->join('qbank', 'qbank.id = user_qbank.qbank_id', 'left');
        $this->db->select('qbank.question,qbank.option_a,qbank.option_b,qbank.option_c,qbank.option_d, qbank.answer as qbank_answer, qbank.answer, user_qbank.*, qbank.id as qbank_id,IF((select count(id) from bookmarks where bookmarks.qbank_id=user_qbank.qbank_id and bookmarks.user_id='.$user_id.')>0, "yes","no") as bookmark_status');
        $users = $this->db->get('user_qbank'); 
        //echo $this->db->last_query();exit;
        if($users->num_rows() > 0)
        {
            $res = $users->result_array();
            return $res;
        }
        return array();
    }
	
	function examdata()
	{
	   $this->db->where('delete_status', 1);
		$examdata = $this->db->get('homepagedata');	
		//echo $this->db->last_query();exit;
		if($examdata->num_rows() > 0)
		{
			return $examdata->result();
		}
		return array();	
	}
	
	function get_topic($topic_id)
	{
	   $this->db->where('delete_status', 1);
	   $this->db->where('id', $topic_id);
		$topics = $this->db->get('video_topics');	
		//echo $this->db->last_query();exit;
		if($topics->num_rows() > 0)
		{
			return $topics->result();
		}
		return array();	
	}
	
	function get_questions($topic_id,$from)
	{
	    $this->db->where('video_topics_id', $topic_id);
		$this->db->limit('5', $from);
		$questions = $this->db->get('qbank');
		//echo $this->db->last_query();exit;
		if($questions->num_rows() > 0)
		{
			return $questions->result();
		}
		return array();	
	}

	 function exam_subjects($exam_id)
	{	
		$this->db->where('sub.exam_id', $exam_id);
		$this->db->join('exams', 'exams.id = sub.exam_id');
		//$this->db->join('', 'exams.id = sub.exam_id');
		$this->db->select('sub.*, exams.name as exam_name,exams.image');
		$users = $this->db->get('subjects sub');	
		//echo $this->db->last_query();exit;
		if($users->num_rows() > 0)
		{
			return $users->result();
		}
		return array();
	}
	function video_mode($status)
	{
		$this->db->where('uv.mode', $status);
		$this->db->join('chapter_videos', 'chapter_videos.chapters_videos_id = uv.chapters_videos_id');
		$users = $this->db->get('user_videos uv');
		if($users->num_rows() > 0)
		{
			return $users->result();
		}
		return array();
	}

	function plandetails()
	{
		$this->db->where('delete_status', 1);
		$plandetails = $this->db->get('plan_details');	
		//echo $this->db->last_query();exit;
		if($plandetails->num_rows() > 0)
		{
			return $plandetails->result();
		}
		return array();
	} 

	 function users_plan($user_id)
	   {	
		$this->db->where('user_plans.user_id', $user_id);
		$this->db->join('plan_details','plan_details.id = user_plans.plan_id');

		$this->db->join('coupons','coupons.id = plan_details.coupon_id'); 
		$this->db->select('user_plans.*,plan_details.*,coupons.coupon_code,coupons.discount');
		$user_plan = $this->db->get('user_plans');
		//var_dump($user_plan);	
		//echo $this->db->last_query();exit;
		if($user_plan->num_rows() > 0)
		{
			return $user_plan->result();
		}
		return array();
	}  



 function demosinglevideo($data)
	{
		$demovideos;	
		//echo $this->db->last_query();exit;
		if($data['status'] == 'All')
		{
 		$demovideos = $this->db
 			->from('chapters')
 			->where('chapters.subject_id', $data['subject_id'])
 			->where('delete_status', 1)
 			->where('chapters.free_or_paid', 'free')
 			->order_by('chapters.id','desc')
 			->limit(1)
 			->get()->row_array();

         }
		foreach ($demovideos as $demovideo) {
		    $rating = $this->db
				->from('ratings')
				->where('chapter_video_id', $chapter->id)
				->select('IFNULL(CAST(AVG(rating)AS DECIMAL (10,1)), 0) as rating')
				->get()->row();
		    $demovideo->rating = $rating->rating;
		}
		//echo $this->db->last_query();exit;
		return $demovideos;
	}
	
	function demosinglevideos($data)
	{
		$demovideos;	
		//echo $this->db->last_query();exit;
		if($data['status'] == 'All')
		{
 		$demovideos = $this->db
 			->from('video_topics')
 			->where('video_topics.subject_id', $data['subject_id'])
 			->where('delete_status', 1)
 			->where('video_topics.free_or_paid', 'free')
 			->order_by('video_topics.id','desc')
 			->limit(1)
 			->get()->row_array();

         }
		foreach ($demovideos as $demovideo) {
		    $rating = $this->db
				->from('ratings')
				->where('video_topics_id', $chapter->id)
				->select('IFNULL(CAST(AVG(rating)AS DECIMAL (10,1)), 0) as rating')
				->get()->row();
		    $demovideo->rating = $rating->rating;
		}
		//echo $this->db->last_query();exit;
		return $demovideos;
	}
 function chapter_status_list($data)
	 {
	 	$chapters = [];
	 	if($data['status'] == 'All'){
	 		// return all chapters related to subject_id
	 		$chapters = $this->db
	 			->from('chapters')
	 			->where('chapters.subject_id', $data['subject_id'])
	 			->where('delete_status', 1)
	 			->get()->result();
	 		//	echo $this->db->last_query();exit;
	 	} else {
	 		if($data['status'] == 'Unseen') {
	 			// get chapters which don't have topics with status Completd/Paused
	 			$query = 'select c.*
	 				from chapters c
	 				where c.subject_id=? and c.delete_status=1 and c.id not in 
	 				(
	 					select c.id 
	 					from chapters c
	 					join video_topics vt on vt.chapter_id=c.id
	 					join user_topics ut on ut.video_topic_id=vt.id
	 					where c.subject_id=? and c.delete_status=1 and ut.user_id=?
	 					group by c.id
	 				)';
	 			$chapters = $this->db->query($query, [
	 				$data['subject_id'],
	 				$data['subject_id'],
	 				$data['user_id']
	 			])->result();
	 		} else if($data['status'] == 'Completed' || $data['status'] == 'Paused') {
	 			// if the all topics that exist in a chapter are Completed
	 			// then only the chapter is consdered as Completed
	 			$chapters = $this->db
	 				->from('chapters')
	 				->where('chapters.subject_id', $data['subject_id'])
	 				->join('video_topics', 'video_topics.chapter_id = chapters.id')
	 				->where('chapters.delete_status', 1)
	 				->group_by('chapters.id')
	 				->select('chapters.*, COUNT(chapters.id) as topics_count')
	 				->get()->result();
	 			$completed = [];
	 			$paused = [];
	 			foreach ($chapters as $chapter) {
	 				$user_topics = $this->db
		 				->from('video_topics')
		 				->where('video_topics.chapter_id', $chapter->id)
		 				->where('video_topics.delete_status', 1)
		 				->join('user_topics', 'user_topics.video_topic_id = video_topics.id')
		 				->where('user_topics.user_id', $data['user_id'])
		 				->where('user_topics.topic_status', 'Completed')
		 				->group_by('video_topics.chapter_id')
		 				->select('COUNT(video_topics.id) as c_topics_count')
		 				->get()->row();
		 			if($user_topics) {
			 			// calculate avg. rating
		 				$rating = $this->db
		 						->from('ratings')
		 						->where('chapter_video_id', $chapter->id)
		 						->select('IFNULL(CAST(AVG(rating)AS DECIMAL (10,1)), 0) as rating')
		 						->get()->row();
		 				$chapter->rating = $rating->rating;
			 			// compare total topics exist with the no. of topics with Completed status
			 			if($chapter->topics_count == $user_topics->c_topics_count) {
			 				array_push($completed, $chapter);
			 			} else if($chapter->topics_count > $user_topics->c_topics_count) {
							array_push($paused, $chapter);
			 			}
		 			}
	 			}
	 			if($data['status'] == 'Completed') {
	 				return $completed;
	 			} else if($data['status'] == 'Paused') {
	 				return $paused;
	 			}
	 		}
	 	}

	 	// calculate avg. rating for all the chapters with All/Unseen/Paused status
	 	foreach ($chapters as $chapter) {
			$rating = $this->db
					->from('ratings')
					->where('chapter_video_id', $chapter->id)
					->select('IFNULL(CAST(AVG(rating)AS DECIMAL (10,1)), 0) as rating')
					->get()->row();
			$chapter->rating = $rating->rating;
		}
		return $chapters;
	 }
	 
	 
	 function chapter_status_lists($data)
	 {
	 	$chapters = [];
	 	if($data['status'] == 'All'){
	 		// return all chapters related to subject_id
	 		$chapters = $this->db
	 			->from('video_topics')
	 			->where('video_topics.subject_id', $data['subject_id'])
	 			->where('video_topics.free_or_paid', 'Free')
	 			->where('video_topics.delete_status', 1)
	 			->get()->result();
	 		//	echo $this->db->last_query();exit;
	 	}
	 	else {
	 		if($data['status'] == 'Finished') {
	 			// get chapters which don't have topics with status Completd/Paused
	 			$query = 'select v.*
	 				from video_topics v
	 				where v.subject_id=? and v.delete_status=1 and v.id in 
	 				(
	 					select v.id 
	 					from video_topics v
	 					join user_topics ut on ut.video_topic_id=v.id
	 					where v.subject_id=? and v.delete_status=1 and ut.user_id=? and ut.topic_status="Completed"
	 					group by v.id
	 				)';
	 			$chapters = $this->db->query($query, [
	 				$data['subject_id'],
	 				$data['subject_id'],
	 				$data['user_id']
	 			])->result();
	 			//echo $this->db->last_query();
	 		} else if($data['status'] == 'Unfinished' || $data['status'] == 'Continuing') {
	 			// if the all topics that exist in a chapter are Completed
	 			// then only the chapter is consdered as Completed
	 			$chapters = $this->db
	 				->from('video_topics')
	 				->where('video_topics.subject_id', $data['subject_id'])
	 				->where('video_topics.delete_status', 1)
	 				->group_by('video_topics.id')
	 				->select('video_topics.*, COUNT(video_topics.id) as topics_count')
	 				->get()->result();
	 				//echo $this->db->last_query();exit;
	 			$unfinished = [];
	 			$continuing = [];
	 			//print_r($chapters);exit;
	 			foreach ($chapters as $chapter) {
	 				$user_topics = $this->db
		 				->from('video_topics')
		 				->where('video_topics.id', $chapter->id)
		 				->where('video_topics.delete_status', 1)
		 				->join('user_topics', 'user_topics.video_topic_id = video_topics.id')
		 				->where('user_topics.user_id', $data['user_id'])
		 				->where('user_topics.topic_status', NULL)
		 				->group_by('video_topics.chapter_id')
		 				->select('COUNT(video_topics.id) as c_topics_count')
		 				->get()->row();
		 				//echo $this->db->last_query();exit;
		 			if($user_topics) {
			 			// calculate avg. rating
		 				$rating = $this->db
		 						->from('ratings')
		 						->where('video_topics_id', $chapter->id)
		 						->select('IFNULL(CAST(AVG(rating)AS DECIMAL (10,1)), 0) as rating')
		 						->get()->row();
		 				$chapter->rating = $rating->rating;
			 			// compare total topics exist with the no. of topics with Completed status
			 			if($chapter->topics_count == $user_topics->c_topics_count) {
			 				array_push($unfinished, $chapter);
			 			} else if($chapter->topics_count > $user_topics->c_topics_count) {
							array_push($continuing, $chapter);
			 			}
		 			}
	 			}
	 			//print_r($chapters);exit;
	 			if($data['status'] == 'unfinished') {
	 				return $unfinished;
	 			} else if($data['status'] == 'continuing') {
	 				return $continuing;
	 			}
	 		}
	 	}

	 	// calculate avg. rating for all the chapters with All/Unseen/Paused status
	 	foreach ($chapters as $chapter) {
			$rating = $this->db
					->from('ratings')
					->where('video_topics_id', $chapter->id)
					->select('IFNULL(CAST(AVG(rating)AS DECIMAL (10,1)), 0) as rating')
					->get()->row();
			$chapter->rating = $rating->rating;
		}
		return $chapters;
	 }

	  function get_user_access($user_id) {
		//check if user subscribe to plan and has video access
		$user_plans = $this->db
			->from('user_plans')
			->join('plan_details', 'plan_details.id = user_plans.plan_id')
			->where('user_id', $user_id)
			->where('expire_at > CURRENT_TIMESTAMP', null, false)
			->select('plan_details.videos_access, plan_details.tests_access
				, plan_details.q_bank_access')
			->get()->row();
			//print_r($user_plans->videos_access);exit;
		$access = [
			'videos_access' => false,
			'tests_access' => false,
			'q_bank_access' => false
		];

		foreach ($user_plans as $user_plan) {
			if($user_plan->videos_access) {
				$access['videos_access'] = true;
			}
			if($user_plans->tests_access) {
				$access['tests_access'] = true;
			}
			if($user_plans->q_bank_access) {
				$access['q_bank_access'] = true;
			}
		}
		return $access;
	}


	function chapter_videodetails($chapter_id, $user_id)
	{
		//check if user subscribe to plan and has video access
		$user_plans = $this->db
			->from('user_plans')
			->join('plan_details', 'plan_details.id = user_plans.plan_id')
			->where('user_id', $user_id)
			->where('expire_at > CURRENT_TIMESTAMP', null, false)
			->select('plan_details.videos_access')
			->get()->result();
		
		$has_video_access = false;
		foreach ($user_plans as $user_plan) {
			if($user_plan->videos_access) {
				$has_video_access = true;
				break;
			}
		}

		// get video details and other videos in the same chapter as that video
		$chapter = $this->db
			->from('chapters')
			->where('id', $chapter_id)
			->where('delete_status', 1)
			->get()->row();
			
		$user_name = $this->db
			->select('name,email_id')->from('users')
			->where('id', $user_id)
			->where('delete_status', 1)
			->get()->row();	
			//echo $user_name->email_id;exit;
			//print_r($chapter->video_id);exit;
    
	if($has_video_access || $chapter->free_or_paid==="free") {
	    $VideoId = $chapter->video_id;
        //$VideoId="e7ada0e1c7f4445faebfae9c9c6ba631";
        //$VideoId=$_POST['video_id'];
        $client_key = 'FgiFxj1TqRSoL6jS5SDUxobWEBZMEqVgIdYgCf9Uhk1mAR3d3fXmbtBGe6F9hpqT';
        $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://dev.vdocipher.com/api/videos/$VideoId/otp",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'annotate' => json_encode([[
      'type'=>'rtext',
      'text'=> $user_name->name,
      'alpha'=>'0.60',
      'color'=>'0xFF0000',
      'size'=>'15',
      'interval'=>'5000'
    ],
    [
      'type'=> 'text', 
        'text' => 'Plato',
        'x' => '10',  
        'y'=> '50',  
        'alpha'=> '0.8', 
        'color'=>'0xFF0000',  
        'size'=>'15' 
    ]
    ]),
  ]),
  CURLOPT_HTTPHEADER => array(
    "Accept: application/json",
    "Authorization: Apisecret " . $client_key,
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
        $otp_response = json_decode($response);
        //echo '<pre>';
       // print_r($otp_response);
       // exit();
        $OTP = $otp_response->otp;
        $playbackInfo = $otp_response->playbackInfo;
        
	        $chapter->otp = $OTP;
	        $chapter->playback = $playbackInfo;
			if($chapter) {
				$topics = $this->db
					->from('video_topics')
					->where('chapter_id', $chapter_id)
					->where('delete_status', 1)
					->order_by('start_time', 'asc')
					->get()->result();
				$chapter->topics = $topics;
				return [
					'has_access' => true,
					'requested_video' => $chapter
				];
			} else {
				return [
					'has_access' => true,
					'message' => 'Requested video does not exist'
				];
			}
		} else {
			return [
				'has_access' => false,
				'message' => 'User does not have video access & it is a paid video',
				'requested_video' => '{}'
			];
		}
	}    	
 //chapter video id as chapter id
	 function user_ratings($chapter_video_id,$user_id)
	{	
		$this->db->where('chapter_video_id', $chapter_video_id);
		$this->db->where('user_id', $user_id);
		$this->db->join('users', 'users.id = ratings.user_id');
		$this->db->select('ratings.*');
		$user_ratings = $this->db->get('ratings');	
		//echo $this->db->last_query();exit;
		if($user_ratings->num_rows() > 0)
		{
			$res = $user_ratings->result_array();
			return $res;
		}
		return array();
	} 
function user_faq($user_id)
	{	

       if($user_id=='')
		{
	$users = $this->db->get('faq');
		}

		else
		{
		 $this->db->select('faq.*');
		 $this->db->where('faq.user_id', $user_id);
		$users = $this->db->get('faq');
         }
		
		if($users->num_rows() > 0)
		{
			return $users->result();
		}
		return array();
	}

	  function student_support($user_id)
	{	$this->db->where('student_support.user_id', $user_id);
		$this->db->join('users', 'users.id = student_support.user_id');
		$this->db->select('student_support.*');
		$student_support = $this->db->get('student_support');	
		//echo $this->db->last_query();exit;
		if($student_support->num_rows() > 0)
		{
			$res = $student_support->result();
			return $res;
		}
		return array();
	}

	function user_notifications()
	{
		$notifications = $this->db->get('notifications');	
		//echo $this->db->last_query();exit;
		if($notifications->num_rows() > 0)
		{
			return $notifications->result();
		}
		return array();
	} 
	function user_slides($chapter_id)
	{	

		//$this->db->where('ue.user_id', $user_id);
		$this->db->where('ue.chapter_id', $chapter_id);
		$this->db->where('ue.chapters_status', 'free');
		$this->db->select('ue.*');
		$users = $this->db->get('chapters_slides ue');	
		//echo $this->db->last_query();exit;
		if($users->num_rows() > 0)
		{
			return $users->result();
		}
		return array();
	} 

	function check_userotherlogin_deleted($email_id)
	{		
		$this->db->where('delete_status', 1);
		$this->db->where('email_id', $email_id);
		$user_status = $this->db->get('users');	
		//echo $this->db->last_query();exit;
		if($user_status->num_rows() > 0)
		{
			return $user_status->row();
		}
		return array();
	} 

	function check_userotherlogin_status($email_id)
	{	
		$this->db->where('status', 'Active');
		$this->db->where('email_id', $email_id);
	
		$user_status = $this->db->get('users');	
		//echo $this->db->last_query();exit;
		if($user_status->num_rows() > 0)
		{
			return $user_status->row();
		}
		return array();
	} 

 function user_otherlogin($email_id, $password)
	{	
		$this->db->where('delete_status', 1);
		$this->db->where('email_id', $email_id);
		$this->db->where('password', md5($password));
		$user_login = $this->db->get('users');	
		//echo $this->db->last_query();exit;		
		if($user_login->num_rows() > 0)
		{
			return $user_login->row_array();
		}
		return array();
	}

	function exams()
	{
		$exams = $this->db->get('exams');	
		//echo $this->db->last_query();exit;
		if($exams->num_rows() > 0)
		{
			return $exams->result();
		}
		return array();
	} 
	 
   function subjects($exam_id)
	{
			$this->db->where('subjects.delete_status', 1);
		$this->db->where('subjects.exam_id', $exam_id);
		$subjects = $this->db->get('subjects');	
		//echo $this->db->last_query();exit;
		if($subjects->num_rows() > 0)
		{
			return $subjects->result();
		}
		return array();
	}

   function check_otheruser_deleted($mobile,$email_id)
	{		
		$this->db->where('delete_status', 1);
		$this->db->where('mobile', $mobile);
		//$this->db->or_where('email_id',$email_id);
		$user_status = $this->db->get('users');	
		//echo $this->db->last_query();exit;
		if($user_status->num_rows() > 0)
		{
			return $user_status->row();
		}
		return array();
	} 


	function check_otheruser_status($mobile)
	{	
		$this->db->where('status', 'Active');
		$this->db->or_where('mobile', $mobile);
		//$this->db->or_where('email_id',$email_id);
		$user_status = $this->db->get('users');	
		//echo $this->db->last_query();exit;
		if($user_status->num_rows() > 0)
		{
			return $user_status->row();
		}
		return array();
	}

	function user_faculty($exam_id)
	{	
		$this->db->where('ue.exam_id', $exam_id);
		$this->db->where('ue.delete_status', 1);
		$this->db->select('ue.*');
		$users = $this->db->get('faculty_details ue');	
		//echo $this->db->last_query();exit;
		if($users->num_rows() > 0)
		{
			return $users->result();
		}
		return array();
	} 
	
	function videotimes($chapter_id)
	{
		$this->db->join('chapters', 'chapters.chapter_id = ue.chapter_id');
		$this->db->where('ue.chapter_id', $chapter_id);
        $this->db->select(' chapters.chapter_name,ue.*');
       	$users = $this->db->get('chapter_videos ue');	
        if($users->num_rows() > 0)
		{
			return $users->result();
		}
		return array();

	}
    
    function subject_chapters($subject_id)
	{	
		$this->db->where('chapters.subject_id', $subject_id);
		$this->db->join('subjects', 'subjects.subject_id = chapters.subject_id');
		$this->db->join('chapter_videos','chapter_videos.chapters_videos_id = chapters.chapter_id');
		$this->db->select('subjects.subject_name,chapters.chapter_name,chapter_videos.video_name,chapter_videos.video_path');
		$users = $this->db->get('chapters');	
		//echo $this->db->last_query();exit;
		if($users->num_rows() > 0)
		{
			return $users->result();
		}
		return array();
	}

	function subject_chapter($subject_id , $data)
	{
		
	if($data['status'] == "All")
		 {
		    

		 }	
		else
          {

     $this->db->where('user_videos.video_status',$data['status']);
 $this->db->where('subject_chapters.subject_id', $subject_id);
		$this->db->join('subjects', 'subjects.subject_id = chapters.subject_id');
	$this->db->join('user_videos', 'user_videos.id =user_videos.video_status chapters.chapter_id');
		$this->db->join('chapter_videos','chapter_videos.chapters_videos_id = subject_chapters.id');
	$this->db->select('subjects.subject_name,chapters.chapter_name,chapter_videos.video_name,chapter_videos.video_path');
			 
	      }
        $user_videos = $this->db->get('subject_chapters');	
		//echo $this->db->last_query();exit;
		if($user_videos->num_rows() > 0)
		{
			return $user_videos->result();
		}
		return array();	
     }

    

	function check_user_exam_exists($exam_id = NULL,$user_id = NULL)
	{	
		if($exam_id)
		{
			$this->db->where('id !=', $exam_id);
		}
		$this->db->where('exam_id', $exam_id);
		$this->db->where('user_id', $user_id);
		$user_name_exists = $this->db->get('users_exams');	
		//echo $this->db->last_query();exit;
		if($user_name_exists->num_rows() > 0)
		{
			return false;
		}
		return true;
	}
	function add_user_exams($RecordData = NULL)
	     {		
		if($RecordData)
		{				
			$this->db->insert('users_exams', $RecordData);
			//echo $this->db->last_query();exit;	
			$insert_id = $this->db->insert_id();
			return $insert_id;			
		}
		return 0;
	}
	function delete_user_exam($user_id,$exam_id)
	{		
        $this->db->where('delete_status', 1);
		$this->db->where('exam_id', $exam_id);
		$this->db->where('user_id', $user_id);
		$this->db->delete('users_exams');
		//echo $this->db->last_query();exit;	
		return true;
	}


	
	

	 function check_anyuser_deleted($mobile, $email_id)
       {
        $this->db->where('delete_status', 1);
       $this->db->where('mobile', $mobile);
       $this->db->or_where('email_id',$email_id);
      $user_status = $this->db->get('users');
  //echo $this->db->last_query();exit;
     if($user_status->num_rows() > 0)
     {
      return $user_status->row();
     }
   return array();
    }  

    function check_anyuser_status($mobile , $email_id)
	{	
		$this->db->where('status', 'Active');
		$this->db->where('mobile', $mobile);
		$this->db->or_where('email_id',$email_id);
		$user_status = $this->db->get('users');	
		//echo $this->db->last_query();exit;
		if($user_status->num_rows() > 0)
		{
			return $user_status->row();
		}
		return array();
	}

	function user_plandetails($plan_details_id)
	   {	
	$this->db->where('plan_details.id', $plan_details_id);
    $this->db->join('coupons','coupons.id = plan_details.coupon_id'); 
	$this->db->select('plan_details.*,coupons.coupon_code,round((plan_details.price * (coupons.discount_percentage / 100))) as discounted_amount');
		$user_plan = $this->db->get('plan_details');
		//var_dump($user_plan);	
		//echo $this->db->last_query();exit;
		if($user_plan->num_rows() > 0)
		{
			return $user_plan->result_array();
		}
		return array();
	}
	function proplansdetails()
	{
		$this->db->where('delete_status', 1);
$this->db->where('plan_type', 'proplans');
$this->db->select('
			plan_details.*, 
			( CASE WHEN tests_access=1 THEN "Yes" 
			WHEN tests_access=0 THEN "No"
			END ) as tests_access,
			( CASE WHEN q_bank_access=1 THEN "Yes" 
			WHEN q_bank_access=0 THEN "No"
			END ) as q_bank_access,
			( CASE WHEN videos_access=1 THEN "Yes" 
			WHEN videos_access=0 THEN "No"
			END ) as videos_access
		');
		$event_types = $this->db->get('plan_details');	
		//echo $this->db->last_query();exit;
		if($event_types->num_rows() > 0)
		{
			return $event_types->result_array();
		}
		return array();
	}

	function induvidualplandetails()
	{
		$this->db->where('delete_status', 1);
		$this->db->where('plan_type', 'IndividualPlans');
		$this->db->select('
			plan_details.*, 
			( CASE WHEN tests_access=1 THEN "Yes" 
			WHEN tests_access=0 THEN "No"
			END ) as tests_access,
			( CASE WHEN q_bank_access=1 THEN "Yes" 
			WHEN q_bank_access=0 THEN "No"
			END ) as q_bank_access,
			( CASE WHEN videos_access=1 THEN "Yes" 
			WHEN videos_access=0 THEN "No"
			END ) as videos_access
		');
		$event_types = $this->db->get('plan_details');	
		//echo $this->db->last_query();exit;
		if($event_types->num_rows() > 0)
		{
			return $event_types->result_array();
		}
		return array();
	}

	 function user_plan($user_id)
	   {	
		$this->db->where('user_plans.user_id', $user_id);
		//$this->db->where('user_plans.plan_id', $plan_id);
		$this->db->join('plan_details','plan_details.id = user_plans.plan_id');

		$this->db->join('coupons','coupons.id = plan_details.coupon_id'); 
		$this->db->select('user_plans.*,coupons.coupon_code,coupons.discount_percentage,plan_details.*,( CASE WHEN tests_access=1 THEN "Yes" 
			WHEN tests_access=0 THEN "No"
			END ) as tests_access,
			( CASE WHEN q_bank_access=1 THEN "Yes" 
			WHEN q_bank_access=0 THEN "No"
			END ) as q_bank_access,
			( CASE WHEN videos_access=1 THEN "Yes" 
			WHEN videos_access=0 THEN "No"
			END ) as videos_access');
		$user_plan = $this->db->get('user_plans');
		//var_dump($user_plan);	
		//echo $this->db->last_query();exit;
		if($user_plan->num_rows() > 0)
		{
			return $user_plan->result_array();
		}
		return array();
	}



	  
	function change_password($oldpassword,$newpassword,$user_id)
	{
		$this->db
		->where('password', md5($oldpassword));
		$user = $this->db->get('users');	
		//echo $this->db->last_query();exit;
		if($user->num_rows() > 0)
		{
			$this->db
			->where('id', $user_id)
			->update('users', [
				'password' => md5($newpassword)
			]);
			return true;
		}
		return false;
	} 
	
	function subscribe($plan_details_id)
	   {	
	$this->db->where('plan_details.id', $plan_details_id);
    $this->db->join('coupons','coupons.id = plan_details.coupon_id'); 
		$this->db->select('plan_details.price,coupons.discount_percentage');
		$user_plan = $this->db->get('plan_details');
		//var_dump($user_plan);	
		//echo $this->db->last_query();exit;
		if($user_plan->num_rows() > 0)
		{
			return $user_plan->result_array();
		}
		return array();
	}

	public function add_to_favourites($data)
{
$this->db->where('user_id', $data['user_id']);
$this->db->where('exam_id', $data['exam_id']);
$q = $this->db->get('users_exams');
$res = $q->num_rows();
//echo $this->db->last_query();
$insert = "";
$delete = "";
//echo $res;exit;
if($res == 0)
{	
$insert = $this->db->insert('users_exams', $data);
}
else
{
$this->db->where('user_id', $data['user_id']);
$this->db->where('exam_id', $data['exam_id']);
$delete = $this->db->delete('users_exams');
}	
//echo $this->db->last_query();
//echo $insert;
if($insert)
{	
return 1;
}
elseif($delete)
{
return 0;
}
else
{
return false;
}
}

function examslist($user_id)
	{
		if($user_id=='')
		{
		$this->db->where('exams.delete_status', 1);
		$user_exams = $this->db->get('exams');
		}
		else
		{
		 $this->db->select('exams.*,(select count(id) from users_exams where users_exams.exam_id=exams.id and users_exams.user_id='.$user_id.' and users_exams.delete_status=1) as selected');
		 $this->db->where('exams.delete_status', 1);
		$user_exams = $this->db->get('exams');
	//	echo $this->db->last_query();exit;
		}	
		if($user_exams->num_rows() > 0)
		{
			return $user_exams->result_array();
		}
		return array();
	}

	function userselected_exams($user_id)
	{
		$this->db->where('delete_status', 1);
		$this->db->where('users_exams.user_id', $user_id);
		$this->db->select('users_exams.*');
		$userselected_exams = $this->db->get('users_exams');	
		//echo $this->db->last_query();exit;
		if($userselected_exams->num_rows() > 0)
		{
			return $userselected_exams->result();
		}
		return array();
	}

  	function add_examsbyuser($user_id, $exam_id) {
    	// delete which are exists already and doesn't exist in the new list
    	$un_selected = $this->db
			->from('users_exams')
			->where('user_id', $user_id)
			->where('exam_id NOT IN ('.implode(',', $exam_id).')')
			->delete();
		foreach ($exam_id as $e_id) {
			// check if already exists
			$user_exam = $this->db
			->from('users_exams')
			->where('user_id', $user_id)
			->where('exam_id', $e_id)
			->get();

			// if doesn't exist then create one
			if($user_exam->num_rows() == 0) {
				$this->db->insert('users_exams', [
					'user_id' => $user_id,
					'exam_id' => $e_id
				]);
			}
		}

		return $this->db
			->from('users_exams')
			->where('user_id', $user_id)
			->get()->result();
	}

	function add_usersuggest()
	{
        $this->db->where('delete_status', 1);
         $this->db->where('chapters.suggested_videos','Yes');
         $this->db->select('chapters.*');

         $this->db->select("(SELECT cast(AVG(rating) as decimal(10,1)) FROM ratings where ratings.chapter_video_id = chapters.id) as rating");
         $users = $this->db->get('chapters');

        //echo $this->db->last_query();exit;

         if($users->num_rows() > 0)
		{
			return $users->result_array();
		}
		return array();

	}

	function  users_video($chapter_id, $user_id)
   {
   	 $this->db->where('video_topics.chapter_id', $chapter_id);
					 $this->db->or_where('video_topics.delete_status', 1);
					 $this->db->or_where('user_topics.user_id', $user_id);
					 $this->db->join('user_topics', 'user_topics.video_topic_id=video_topics.id');
					 $this->db->order_by('start_time', 'asc');
					$topics = $this->db->get('video_topics');
					if($topics->num_rows() > 0)
		          {
			return $topics->num_rows();
	      	}
		return 0;

   }

   function total_videos()
	{	
		$user_plan = $this->db->get('chapters');
		//var_dump($user_plan);	
		//echo $this->db->last_query();exit;
		if($user_plan->num_rows() > 0)
		{
			return $user_plan->num_rows();
		}
		return 0;
	}

	function user_qbank($user_id)
	   {	
	$this->db->where('user_qbank.user_id', $user_id);
   
		$user_plan = $this->db->get('user_qbank');
		//var_dump($user_plan);	
		//echo $this->db->last_query();exit;
		if($user_plan->num_rows() > 0)
		{
			return $user_plan->num_rows();
		}
		return 0;
	}

		function total_qbank()
	{
		$user_plan = $this->db->get('qbank');
		//var_dump($user_plan);	
		//echo $this->db->last_query();exit;
		if($user_plan->num_rows() > 0)
		{
			return$user_plan->num_rows();
		}
		return 0;
	}

	function user_test($user_id)
	   {	
	$this->db->where('user_testplan.user_id', $user_id);
    
		$user_plan = $this->db->get('user_testplan');
		//var_dump($user_plan);	
		//echo $this->db->last_query();exit;
		if($user_plan->num_rows() > 0)
		{
			return $user_plan->num_rows();
		}
		return 0;
	}

	function total_test()
	    {

		$user_plan = $this->db->get('testseries');
		//var_dump($user_plan);	
		//echo $this->db->last_query();exit;
		if($user_plan->num_rows() > 0)
		{
			return $user_plan->num_rows();
		}
		return 0;
	}

	 function user_notes($chapter_id)
	{	
		$this->db->where('chapters.id', $chapter_id);
		$this->db->select('chapters.notespdf');
		$users = $this->db->get('chapters');	
		//echo $this->db->last_query();exit;
		if($users->num_rows() > 0)
		{
			return $users->result();
		}
		return array();
	} 	

       function	add_users_plans()
       {
        $this->db->select('chapters.notespdf'); 
        $users = $this->db->get('chapters');   
       	if($users->num_rows() > 0)
		{
			return $users->result();
		}
		return array();
       }

    public function get_table_row($table_name='', $where='', $columns='', $order_column='', $order_by='asc', $limit='')
	{
		if(!empty($columns)) {
		$tbl_columns = implode(',', $columns);
		$this->db->select($tbl_columns);
		}
		if(!empty($where)) $this->db->where($where);
		if(!empty($order_column)) $this->db->order_by($order_column, $order_by); 
		if(!empty($limit)) $this->db->limit($limit); 
		$query = $this->db->get($table_name);
		if($columns=='test') { echo $this->db->last_query(); exit; }
		  //echo $this->db->last_query();
		return $query->row_array();
	}

	function quiz_topics($user_id, $course_id, $subject_id, $count)
	{
		if($count > 0)
        {
            $this->db->limit(15, $count * 15);
        }
        else
        {
            $this->db->limit(15);
        }
		$this->db->order_by('qt.id', 'desc');
		$this->db->having('questions_count >', 0);
		$this->db->where('qt.course_id', $course_id);
		$this->db->where('qt.subject_id', $subject_id);
        $this->db->select('qt.id as topic_id, qt.topic_name, qt.quiz_type');
        $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = qt.id) as questions_count");
        $this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = '$course_id' and quiz_topic_reviews.subject_id = '$subject_id' and quiz_topic_reviews.topic_id = qt.id), 1), 0) as ratings");
        $this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = qt.id) as answered");
		$topics = $this->db->get('quiz_topics qt');
		//echo $this->db->last_query();exit;
		if($topics->num_rows() > 0)
		{
			return $topics->result_array();
		}
		return array();
	}

	function quiz_topics_finished($user_id, $course_id, $subject_id, $count)
	{
		if($count > 0)
        {
            $this->db->limit(15, $count * 15);
        }
        else
        {
            $this->db->limit(15);
        }
		$this->db->order_by('qt.id', 'desc');
		$this->db->having('questions_count >', 0);
		$this->db->having('answered >', 0);
		$this->db->where('qt.course_id', $course_id);
		$this->db->where('qt.subject_id', $subject_id);
        $this->db->select('qt.id as topic_id, qt.topic_name, qt.quiz_type');
        $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = qt.id) as questions_count");
        $this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = '$course_id' and quiz_topic_reviews.subject_id = '$subject_id' and quiz_topic_reviews.topic_id = qt.id), 1), 0) as ratings");
        $this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = qt.id) as answered");
		$topics = $this->db->get('quiz_topics qt');
		//echo $this->db->last_query();exit;
		if($topics->num_rows() > 0)
		{
			return $topics->result_array();
		}
		return array();
	}

	function quiz_topics_free($user_id, $course_id, $subject_id, $count){
		if($count > 0)
        {
            $this->db->limit(15, $count * 15);
        }
        else
        {
            $this->db->limit(15);
        }
        $this->db->order_by('qt.id', 'desc');
		$this->db->having('questions_count >', 0);
		$this->db->where('qt.course_id', $course_id);
		$this->db->where('qt.subject_id', $subject_id);
		$this->db->where('qt.quiz_type', 'free');
		$this->db->select('qt.id as topic_id, qt.topic_name, qt.quiz_type');
        $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = qt.id) as questions_count");
        $this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = '$course_id' and quiz_topic_reviews.subject_id = '$subject_id' and quiz_topic_reviews.topic_id = qt.id), 1), 0) as ratings");
        $this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = qt.id) as answered");
		$topics = $this->db->get('quiz_topics qt');
		//echo $this->db->last_query();exit;
		if($topics->num_rows() > 0)
		{
			return $topics->result_array();
		}
		return array();
	}

	function quiz_topics_count($course_id, $subject_id)
	{		
		$this->db->order_by('qt.id', 'desc');
		$this->db->having('questions_count >', 0);
		$this->db->where('qt.course_id', $course_id);
		$this->db->where('qt.subject_id', $subject_id);
        $this->db->select('qt.id as topic_id');
        $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = qt.id) as questions_count");
		$topics = $this->db->get('quiz_topics qt');
		//echo $this->db->last_query();exit;
		return $topics->num_rows();
	}

	function quiz_questions_count($course_id, $subject_id)
	{
		$this->db->order_by('qq.id', 'desc');
		$this->db->where('qq.course_id', $course_id);
		$this->db->where('qq.subject_id', $subject_id);
		$this->db->join('quiz_options qp', 'qp.question_id = qq.id');
        $this->db->select('qq.id');
        $this->db->distinct();
		$topics = $this->db->get('quiz_questions qq');
		//echo $this->db->last_query();exit;
		return $topics->num_rows();
	}

	function quiz_topic_details($user_id, $topic_id)
	{
		$this->db->order_by('qt.id', 'desc');
		$this->db->having('questions_count >', 0);
		$this->db->where('qt.id', $topic_id);
        $this->db->select('qt.*');
        $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.topic_id = qt.id) as questions_count");
        $this->db->select("(SELECT count(qa.id) FROM `quiz_answers` `qa` WHERE `qa`.`topic_id` = '$topic_id' and `qa`.`user_id` = '$user_id') as answers_count");
        $this->db->select("(SELECT DATE_FORMAT(qa.created_on, '%d %b %Y') FROM `quiz_answers` `qa` WHERE `qa`.`topic_id` = '$topic_id' and `qa`.`user_id` = '$user_id' order by id desc limit 1) as topic_completed_date");
         $this->db->select("(SELECT count(qb.id) FROM `quiz_question_bookmarks` `qb` WHERE `qb`.`topic_id` = '$topic_id' and `qb`.`user_id` = '$user_id') as bookmarks_count");
        $this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = qt.course_id and quiz_topic_reviews.subject_id = qt.subject_id and quiz_topic_reviews.topic_id = qt.id), 1), 0) as ratings");
		$topics = $this->db->get('quiz_topics qt');
		//echo $this->db->last_query();exit;
		if($topics->num_rows() > 0)
		{
			$result = $topics->row_array();
			$result['questions_yet_to_answer'] =  $result['questions_count'] - $result['answers_count'];
			return $result;
		}
		return new ArrayObject();
	}

	function quiz_questions($user_id, $course_id, $subject_id, $topic_id, $count = 0)
	{
		// if($count > 0)
  //       {
  //           $this->db->limit(15, $count * 15);
  //       }
  //       else
  //       {
  //           $this->db->limit(15);
  //       }
		$this->db->order_by('qq.id', 'desc');
		$this->db->where('qq.course_id', $course_id);
		$this->db->where('qq.subject_id', $subject_id);
		$this->db->where('qq.topic_id', $topic_id);
		$this->db->join('quiz_options qp', 'qp.question_id = qq.id');
		$this->db->join('quiz_topics', 'quiz_topics.id = qq.topic_id');
        $this->db->select('qq.*, qq.id as question_id, quiz_topics.title as topic_title');
        $this->db->select("IF ((SELECT COUNT(id) FROM `quiz_reports` where user_id = '$user_id' and course_id = '$course_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$topic_id' and quiz_reports.question_id = qq.id) >0, 'yes', 'no') as reported");
        $this->db->distinct();
		$topics = $this->db->get('quiz_questions qq');
		//echo $this->db->last_query();exit;
		if($topics->num_rows() > 0)
		{
			$res = $topics->result_array();
			foreach($res as $key => $row)
			{
				$res[$key]['percentage'] = $this->quiz_correct_answer_percentage($row['question_id'], $row['answer']);
				$res[$key]['options'] = $this->quiz_question_options($row['question_id']);
			}
			return $res;
		}
		return array();
	}

	function quiz_question_options($question_id)
	{
		$this->db->order_by('qo.id', 'asc');
		$this->db->where('qo.question_id', $question_id);
        $this->db->select('qo.*');
		$options = $this->db->get('quiz_options qo');
		//echo $this->db->last_query();exit;
		if($options->num_rows() > 0)
		{
			return $options->result_array();
		}
		return array();
	}

	function quiz_correct_answer_percentage($question_id, $answer)
	{
		$this->db->order_by('qa.id', 'asc');
		$this->db->where('qa.question_id', $question_id);
        $this->db->select('qa.*');
		$answer = $this->db->get('quiz_answers qa');
		//echo $this->db->last_query();exit;
		$question_answered_count = $answer->num_rows();
		if($question_answered_count <= 0)
		{
			return "no one answered";
		}

		$this->db->order_by('qa.id', 'asc');
		$this->db->where('qa.answer_status', 'correct');
		$this->db->where('qa.question_id', $question_id);
        $this->db->select('qa.*');
		$answer = $this->db->get('quiz_answers qa');
		//echo $this->db->last_query();exit;
		$correct_answered_count = $answer->num_rows();

		return $correct_answered_count / $question_answered_count * 100;
	}

	function bookmarked_questions($user_id, $course_id, $subject_id, $topic_id)
	{
		$this->db->order_by('qb.id', 'desc');
		$this->db->where('qb.course_id', $course_id);
		$this->db->where('qb.subject_id', $subject_id);
		$this->db->where('qb.topic_id', $topic_id);
		$this->db->join('quiz_options qp', 'qp.question_id = qb.id');
		$this->db->join('quiz_topics', 'quiz_topics.id = qb.topic_id');
		$this->db->join('quiz_questions', 'quiz_questions.id = qb.topic_id');
        $this->db->select('quiz_questions.*, quiz_questions.id as question_id, qb.*, quiz_topics.title as topic_title');
        $this->db->select("IF ((SELECT COUNT(id) FROM `quiz_reports` where user_id = '$user_id' and course_id = '$course_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$topic_id' and quiz_reports.question_id = quiz_questions.id) >0, 'yes', 'no') as reported");
        $this->db->select("(SELECT answer FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$topic_id' and quiz_answers.question_id = quiz_questions.id) as answered");
        $this->db->distinct();
		$topics = $this->db->get('quiz_question_bookmarks qb');
		//echo $this->db->last_query();exit;
		if($topics->num_rows() > 0)
		{
			$res = $topics->result_array();
			foreach($res as $key => $row)
			{
				$res[$key]['percentage'] = $this->quiz_correct_answer_percentage($row['question_id'], $row['answer']);
				$res[$key]['options'] = $this->quiz_question_options($row['question_id']);
			}
			return $res;
		}
		return array();
	}

	function answered_quiz_questions($user_id, $course_id, $subject_id, $topic_id)
	{
		$this->db->order_by('qq.id', 'desc');
		$this->db->where('qq.course_id', $course_id);
		$this->db->where('qq.subject_id', $subject_id);
		$this->db->where('qq.topic_id', $topic_id);
		$this->db->join('quiz_options qp', 'qp.question_id = qq.id');
		$this->db->join('quiz_topics', 'quiz_topics.id = qq.topic_id');
        $this->db->select('qq.*, qq.id as question_id, quiz_topics.title as topic_title');
        $this->db->select("IF ((SELECT COUNT(id) FROM `quiz_reports` where user_id = '$user_id' and course_id = '$course_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$topic_id' and quiz_reports.question_id = qq.id) >0, 'yes', 'no') as reported");
        $this->db->select("(SELECT answer FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$topic_id' and quiz_answers.question_id = qq.id) as answered");
        $this->db->distinct();
		$topics = $this->db->get('quiz_questions qq');
		//echo $this->db->last_query();exit;
		if($topics->num_rows() > 0)
		{
			$res = $topics->result_array();
			foreach($res as $key => $row)
			{
				$res[$key]['percentage'] = $this->quiz_correct_answer_percentage($row['question_id'], $row['answer']);
				$res[$key]['options'] = $this->quiz_question_options($row['question_id']);
			}
			return $res;
		}
		return array();
	}

	function answered_test_series_questions($user_id, $course_id, $category_id, $quiz_id)
	{
		$this->db->order_by('id', 'desc');
		$this->db->where('course_id', $course_id);
		$this->db->where('category_id', $category_id);
		$this->db->where('quiz_id', $quiz_id);
		$this->db->where('user_id', $user_id);
		$this->db->distinct();
		$topics = $this->db->get('test_series_answers');
		if($topics->num_rows() > 0)
		{
			$res = $topics->result_array();
			return $res;
		}
		return array();
	}

	function data_analysis_allUsers($user_id, $course_id, $category_id, $quiz_id){
		$this->db->group_by(array("answer_status", "user_id"));
		$this->db->distinct();
		$this->db->select('user_id,COUNT(*) as count,answer_status');
		$marks = $this->db->get('test_series_answers');
		if($marks->num_rows() > 0)
		{
			$res = $marks->result_array();
			return $res;
		}
		return array();
	}

	function getMarks($quiz_id,$user_id){
		$this->db->order_by('id', 'desc');
		$this->db->where('quiz_id', $quiz_id);
		$this->db->distinct();
		$marks = $this->db->get('test_series_marks');
		if($marks->num_rows() > 0)
		{
			$res = $marks->result_array();
			return $res;
		}
		return array();
		// $this->db->order_by('tsm.id', 'desc');
		// $this->db->where('quiz_id', $quiz_id);
		// $this->db->distinct();
		// $this->db->select('users.image');
		// $this->db->select('tsm.*');
		// $this->db->join('users', 'users.id = tsm.user_id');
		// $marks = $this->db->get('test_series_marks tsm');
		// var_dump($this->db->last_query());die();
		// if($marks->num_rows() > 0)
		// {
		// 	$res = $marks->result_array();
		// 	return $res;
		// }
		// return array();
	}

	function get_all_review_questions($user_id, $course_id, $category_id, $quiz_id){
		$this->db->where('user_id', $user_id);
		$this->db->where('tsa.course_id', $course_id);
		$this->db->where('tsa.category_id', $category_id);
		$this->db->where('tsa.quiz_id', $quiz_id);
		$this->db->join('test_series_questions', 'test_series_questions.id = tsa.question_id');
		$this->db->select('test_series_questions.question');
		$this->db->select('test_series_questions.id');
		$this->db->distinct();
		$questions = $this->db->get('test_series_answers tsa');
		if($questions->num_rows() > 0)
		{
			$res = $questions->result_array();
			return $res;
		}
		return array();
	}

	function get_status_review_questions($user_id, $course_id, $category_id, $quiz_id,$status){
		$this->db->where('user_id', $user_id);
		$this->db->where('tsa.course_id', $course_id);
		$this->db->where('tsa.category_id', $category_id);
		$this->db->where('tsa.quiz_id', $quiz_id);
		$this->db->where('tsa.answer_status', $status);
		$this->db->join('test_series_questions', 'test_series_questions.id = tsa.question_id');
		$this->db->select('test_series_questions.question');
		$this->db->select('test_series_questions.id');
		$this->db->distinct();
		$questions = $this->db->get('test_series_answers tsa');
		if($questions->num_rows() > 0)
		{
			$res = $questions->result_array();
			return $res;
		}
		return array();
	}

	function test_series_quiz_dates($user_id, $course_id, $category_id)
	{
		$this->db->group_by('exam_time');
		$this->db->order_by('tsq.exam_time', 'asc');
		//$this->db->having('questions_count >', 0);
		$this->db->where('tsq.course_id', $course_id);
		if($category_id != "all")
		{
			$this->db->where('tsq.category_id', $category_id);
		}
		$this->db->join('test_series_questions', 'test_series_questions.quiz_id = tsq.id');
		$this->db->join('test_series_options', 'test_series_options.question_id = test_series_questions.id');
		$this->db->distinct();
        $this->db->select("DATE_FORMAT(tsq.exam_time, '%M %Y') as month_year, DATE_FORMAT(tsq.exam_time, '%Y-%m') as digit_year_month");
        //$this->db->select("(select count(DISTINCT(quiz_questions.id)) from test_series_questions quiz_questions join test_series_options quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.quiz_id = tsq.id) as questions_count");
		$quiz = $this->db->get('test_series_quiz tsq');
		//echo $this->db->last_query();exit;
		if($quiz->num_rows() > 0)
		{
			$res = $quiz->result_array();
			foreach($res as $key => $row)
			{
				$res[$key]['quizs'] = $this->test_series_quizs($user_id, $course_id, $category_id, $row['digit_year_month']);
			}
			return $res;
		}
		return array();
	}

	function test_series_quizs($user_id, $course_id, $category_id, $year_month)
	{
		// if($count > 0)
  //       {
  //           $this->db->limit(15, $count * 15);
  //       }
  //       else
  //       {
  //           $this->db->limit(15);
  //       }
		$this->db->order_by('tsq.id', 'desc');
		$this->db->having('questions_count >', 0);
		$this->db->where('DATE_FORMAT(tsq.exam_time, "%Y-%m") =', $year_month);
		$this->db->where('tsq.course_id', $course_id);
		if($category_id != "all")
		{
			$this->db->where('tsq.category_id', $category_id);
		}
        $this->db->select('tsq.*');
        $this->db->select("(select count(DISTINCT(quiz_questions.id)) from test_series_questions quiz_questions join test_series_options quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.quiz_id = tsq.id) as questions_count");
        $this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `test_series_reviews` reviews where reviews.course_id = '$course_id'  and reviews.quiz_id = tsq.id), 1), 0) as ratings");
        $this->db->select("(SELECT count(id) FROM test_series_answers `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and quiz_id = tsq.id) as answered");
		$quiz = $this->db->get('test_series_quiz tsq');
		//echo $this->db->last_query();exit;
		if($quiz->num_rows() > 0)
		{
			return $quiz->result_array();
		}
		return array();
	}

	function test_series_quiz_details($user_id, $quiz_id)
	{
		$this->db->order_by('qt.id', 'desc');
		$this->db->having('questions_count >', 0);
		$this->db->where('qt.id', $quiz_id);
		$this->db->join('test_series_categories tsc', 'tsc.id = qt.category_id');
        $this->db->select('qt.*, tsc.title as category_name');
        $this->db->select("(select count(DISTINCT(tsqt.id)) from test_series_questions tsqt join test_series_options tso on tso.question_id = tsqt.id where tsqt.quiz_id = qt.id) as questions_count");
        $this->db->select("(SELECT count(tsa.id) FROM test_series_answers `tsa` WHERE `tsa`.`quiz_id` = '$quiz_id' and `tsa`.`user_id` = '$user_id') as answers_count");
        $this->db->select("(SELECT DATE_FORMAT(tsa.created_on, '%d %b %Y') FROM test_series_answers `tsa` WHERE `tsa`.`quiz_id` = '$quiz_id' and `tsa`.`user_id` = '$user_id' order by id desc limit 1) as topic_completed_date");
         $this->db->select("(SELECT count(tsb.id) FROM test_series_bookmarks `tsb` WHERE `tsb`.`quiz_id` = '$quiz_id' and `tsb`.`user_id` = '$user_id') as bookmarks_count");
        $this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `test_series_reviews` trv where trv.course_id = qt.course_id and trv.category_id = qt.category_id and trv.quiz_id = qt.id), 1), 0) as ratings");
		$quiz = $this->db->get('test_series_quiz qt');
		//echo $this->db->last_query();exit;
		if($quiz->num_rows() > 0)
		{
			$result = $quiz->row_array();
			$result['questions_yet_to_answer'] =  $result['questions_count'] - $result['answers_count'];
			return $result;
		}
		return new ArrayObject();
	}

	function test_series_questions($user_id, $course_id, $category_id, $quiz_id, $count = 0)
	{
		// if($count > 0)
		// {
		// 	$this->db->limit(15, $count * 15);
		// }
		// else
		// {
		// 	$this->db->limit(15);
		// }
		$this->db->order_by('tsqt.id', 'desc');
		$this->db->where('tsqt.course_id', $course_id);
		$this->db->where('tsqt.category_id', $category_id);
		$this->db->where('tsqt.quiz_id', $quiz_id);
		$this->db->join('test_series_options tso', 'tso.question_id = tsqt.id');
		$this->db->join('test_series_quiz', 'test_series_quiz.id = tsqt.quiz_id');
        $this->db->select('tsqt.*, tsqt.id as question_id, test_series_quiz.title as topic_title');
        $this->db->select("IF ((SELECT COUNT(id) FROM test_series_reports tsr where user_id = '$user_id' and course_id = '$course_id' and category_id = '$category_id' and quiz_id = '$quiz_id' and tsr.question_id = tsqt.id) >0, 'yes', 'no') as reported");
        $this->db->distinct();
		$topics = $this->db->get('test_series_questions tsqt');
		//echo $this->db->last_query();exit;
		if($topics->num_rows() > 0)
		{
			$res = $topics->result_array();
			foreach($res as $key => $row)
			{
				$res[$key]['percentage'] = $this->test_series_correct_answer_percentage($row['question_id'], $row['answer']);
				$res[$key]['options'] = $this->test_series_question_options($row['question_id']);
			}
			return $res;
		}
		return array();
	}

	function test_series_correct_answer_percentage($question_id, $answer)
	{
		$this->db->order_by('tsa.id', 'asc');
		$this->db->where('tsa.question_id', $question_id);
        $this->db->select('tsa.*');
		$answer = $this->db->get('test_series_answers tsa');
		//echo $this->db->last_query();exit;
		$question_answered_count = $answer->num_rows();
		if($question_answered_count <= 0)
		{
			return "no one answered";
		}

		$this->db->order_by('tsa.id', 'asc');
		$this->db->where('tsa.answer_status', 'correct');
		$this->db->where('tsa.question_id', $question_id);
        $this->db->select('tsa.*');
		$answer = $this->db->get('test_series_answers tsa');
		//echo $this->db->last_query();exit;
		$correct_answered_count = $answer->num_rows();

		return $correct_answered_count / $question_answered_count * 100;
	}

	function test_series_question_options($question_id)
	{
		$this->db->order_by('tso.id', 'asc');
		$this->db->where('tso.question_id', $question_id);
        $this->db->select('tso.*');
		$options = $this->db->get('test_series_options tso');
		//echo $this->db->last_query();exit;
		if($options->num_rows() > 0)
		{
			return $options->result_array();
		}
		return array();
	}
}