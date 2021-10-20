<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Wssub_model extends CI_Model{

function get_custom_review_quiz_question_analysis($user_id, $question_id,$exam_id){

        $this->db->where('custom_module_exam_result.user_id', $user_id);
        $this->db->where('custom_module_exam_result.question_id', $question_id);

        $this->db->join('custom_module_exam_result', 'custom_module_exam_result.question_id = qq.id', 'left outer');

        $this->db->select('qq.*,custom_module_exam_result.answer as attempted_answer,custom_module_exam_result.answer_status, custom_module_exam_result.correct_answer');

        $this->db->distinct();

        $questions = $this->db->get('quiz_questions qq');
        //echo $this->db->last_query();exit;
        $questions = $questions->result_array();



        for ($i = 0;$i < sizeof($questions);$i++)

        {
            $this->db->where('user_id', $user_id);
            $this->db->where('exam_id', $exam_id);
            $this->db->where('question_id', $question_id);



            $this->db->select('id');



            $bookmark_id = $this->db->get('custom_module_qbank_bookmarks');

            $bookmark_id = $bookmark_id->row_array();

            $questions[$i]['bookmark_id'] = $bookmark_id['id'];



        }



        $this->db->where('question_id', $question_id);



        $options = $this ->db->get('quiz_options');



        $options = $options->result_array();



        $this->db->where('user_id', $user_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('question_id', $question_id);



        $reports = $this->db->get('custom_module_qbank_reports');



        $reports = $reports->result_array();



        return array(



            'questions' => $questions,



            'options' => $options,



            'reports' => $reports



        );



    }


    function get_custom_allusers_quiz_percentage($question_id){



        $this

            ->db

            ->where('question_id', $question_id);



        $this

            ->db

            ->select('count(*) as total_count');



        $this

            ->db

            ->select('COUNT(IF(answer_status="correct",1,null)) as correct_count');



        $this

            ->db

            ->select('(select COUNT(IF(answer="A",1,null)) from custom_module_exam_result where question_id=' . $question_id . ' ) as option_a');



        $this

            ->db

            ->select('(select COUNT(IF(answer="B",1,null)) from custom_module_exam_result where question_id=' . $question_id . ' ) as option_b');



        $this

            ->db

            ->select('(select COUNT(IF(answer="C",1,null)) from custom_module_exam_result where question_id=' . $question_id . ' ) as option_c');



        $this

            ->db

            ->select('(select COUNT(IF(answer="D",1,null)) from custom_module_exam_result where question_id=' . $question_id . ' ) as option_d');



        $result = $this

            ->db

            ->get('custom_module_exam_result');



        // var_dump($this->db->last_query());die();

        



        if ($result->num_rows() > 0)



        {



            $res = $result->row_array();



            return $res;



        }



        return array();



    }


    public function getCustomModuleExamList($user_id){


        $query="select  cus.`id`, cus.`user_id`, cus.`exam_id`,cus.`exam_status`,cus.`created_on` as start_date_time,cusm.`paper_name` from custom_module_user_exam_status cus inner join custom_module_exam_marks cusm on cus.exam_id=cusm.exam_id where cus.user_id='".$user_id."' ";

        //echo $query;exit;

        $result=$this->db->query($query)->result_array();
        return $result;
    }

    public function getCustomQuestionsWithExamID($exam_id){

        $query="select  `id`, `exam_id`, `user_id`, `course_id`, `subject_id`, `chapter_id`, `topic_id`, `mode`, `question_order_id`, `question_id`, `option_id`, `answer`, `correct_answer`, `answer_status`, `answer_sub_status`, `marks` from custom_module_exam_result where exam_id='".$exam_id."'";
        $result=$this->db->query($query)->result_array();
        return $result; 
    }

    public function getCustomExamStatusWithExamID($exam_id){
        $query="select `exam_id`, `exam_status`, `topic_ids`, `difficult_levels` from custom_module_user_exam_status where exam_id='".$exam_id."' ";
        $result=$this->db->query($query)->row_array();
        return $result; 
    }

    public function getCustomModuleQbankQuestionReport($exam_id,$user_id,$question_id){
        $insert_data=array(
                    'exam_id'=>$exam_id,
                     'user_id'=>$user_id,
                      'question_id'=>$question_id,
                        );
       $result=$this->db->insert('custom_module_qbank_reports',$insert_data);
       return $result;
    }

    public function getTestSeriesCategoriesWithCourseID($course_id,$user_id){

       $query="select tsc.id as category_id,tsc.course_id,tsc.title,tsc.pdf_path,tsc.order, (select count(tsq.id) from test_series_quiz tsq where tsq.course_id='".$course_id."' and tsq.category_id=tsc.id and tsq.status='Active') as test_series_quiz_count, 
            (select count(ust.id) from user_assigned_testseries ust inner join test_series_quiz tsq on tsq.id=ust.quiz_id where ust.user_id='".$user_id."' and ust.course_id='".$course_id."' and ust.category_id=tsc.id and tsq.status='Active' and ust.exam_status='completed') as test_series_completed_count 
            from test_series_categories tsc where tsc.course_id='".$course_id."' ORDER BY tsc.order ASC ";
    // echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;

    }

    public function getTestSeriesWithCourseAndCategoryID($course_id,$user_id,$category_id){

        $query="select tsq.`id`, tsq.`course_id`, tsq.`category_id`, tsq.`title`, tsq.`description`, tsq.`time`, tsq.`exam_time`, tsq.`expiry_date`, tsq.`quiz_type`,tsq.`suggested_test_series`, tsq.`test_series_image`,tsq. `uploaded_pdf_path`, tsq.`order`, tsq.`status`,tsq.`questions_count`,
            (select exam_status from
            user_assigned_testseries where user_assigned_testseries.user_id='".$user_id."' and user_assigned_testseries.course_id='".$course_id."' and user_assigned_testseries.category_id='".$category_id."' and 
            user_assigned_testseries.quiz_id = tsq.id) as exam_status

            from test_series_quiz tsq where tsq.course_id='".$course_id."' and tsq.category_id='".$category_id."' and tsq.status='Active' ORDER BY tsq.order asc";
            //echo $query;exit;
            //(select(CASE WHEN COUNT(1)<>'0' THEN 'yes' ELSE 'no' END) from
            //users_paid_testseries where users_paid_testseries.user_id='".$user_id."' and users_paid_testseries.test_series_id=tsq.id) as
           // subscription_status
        $test_series=$this->db->query($query)->result_array();

        foreach($test_series as $key=>$value){

            $query="select * from users_paid_testseries where user_id='".$user_id."' and test_series_id='".$value['id']."'";
            $paid_testseries=$this->db->query($query)->row_array();
                    if(!empty($paid_testseries)){
                        
                    $checkFreePackage=$this->db->query("select * from user_freepackage_trials where user_id='".$user_id."'")->row_array();
                    if(!empty($checkFreePackage)){
                    $check_package_expiry_date=$checkFreePackage['package_expiry_date'];
                    $today2=date('Y-m-d');
                    $free_package_expiry_date1 = strtotime($check_package_expiry_date); 
                    $free_today1 = strtotime($today2);

                    if (($free_package_expiry_date1 >= $free_today1) && ($paid_testseries['payment_status'] == 'free')){
                               $test_series[$key]['subscription_status']='yes';
                         }else if($paid_testseries['payment_status'] == 'paid'){
                                $test_series[$key]['subscription_status']='yes';
                         }else{
                            $test_series[$key]['subscription_status']='no';
                         }
                     }else{
                        $test_series[$key]['subscription_status']='yes';
                     }
                    }else{
                        $test_series[$key]['subscription_status']='no';
                    }
        }
        return $test_series;
    }

    public function getAllTestSeriesList($course_id,$user_id){

        $query="select tsq.`id`, tsq.`course_id`, tsq.`category_id`, tsq.`title`, tsq.`description`, tsq.`time`, tsq.`exam_time`, tsq.`expiry_date`, tsq.`quiz_type`,tsq.`suggested_test_series`, tsq.`test_series_image`,tsq. `uploaded_pdf_path`, tsq.`order`, tsq.`status`,tsq.`questions_count`,
            (select exam_status from
            user_assigned_testseries where user_assigned_testseries.user_id='".$user_id."' and user_assigned_testseries.course_id='".$course_id."' and
            user_assigned_testseries.quiz_id = tsq.id) as exam_status,

            (select(CASE WHEN COUNT(1)<>'0' THEN 'yes' ELSE 'no' END) from
            users_paid_testseries where users_paid_testseries.user_id='".$user_id."' and users_paid_testseries.test_series_id=tsq.id) as
            subscription_status

            from test_series_quiz tsq where tsq.course_id='".$course_id."' and tsq.status='Active' ORDER BY tsq.order asc";
        //echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;

    }
 

  public function getQbankTopicWiseBookmarks($user_id){


    $query="SELECT DISTINCT(qqb.qbank_topic_id),qqt.name,(select count(qqb1.question_id) from `quiz_question_bookmarks` qqb1 where qqb1.qbank_topic_id=qqb.qbank_topic_id and qqb1.user_id='".$user_id."') as bookmarks_count FROM `quiz_question_bookmarks` qqb inner join quiz_qbanktopics qqt on qqt.id=qqb.qbank_topic_id where qqb.user_id='".$user_id."'";
    $result=$this->db->query($query)->result_array();
    return $result;

  }

  public function getQbankBookmarks($user_id,$start_limit1,$end_limit){
    $start_limit=$start_limit1-1;
    $query="select qq.id as question_id,qq.question_order_no as question_order_id,qq.question,qq.math_library,qqb.question_order_id,qqb.question_id as question_unique_id,qqb.id as bookmark_id,s.subject_name,qqt.name as qbank_topic_name from quiz_question_bookmarks qqb inner join quiz_questions qq on qq.question_unique_id=qqb.question_id inner join subjects s on qqb.subject_id=s.id inner join quiz_qbanktopics qqt on qqt.id=qqb.qbank_topic_id where qqb.user_id='".$user_id."' limit $start_limit,$end_limit";
    //echo $query;exit;
    $result=$this->db->query($query)->result_array();
    return $result;
  }

  public function getTestSeriesBookmarks($user_id,$start_limit1,$end_limit){

    $start_limit=$start_limit1-1;
    $query="SELECT tsb.id as bookmark_id,tsq.que_number,tsb.user_id,tsb.course_id,tsb.category_id,tsb.quiz_id,tsq.question,tsq.math_library,tsc.title as category_name,ts.title as quiz_name FROM `test_series_bookmarks`  tsb 
        inner join test_series_questions tsq on tsb.question_id=tsq.id 
        inner join test_series_categories tsc on tsc.id=tsb.category_id
        inner join test_series_quiz ts on ts.id=tsb.quiz_id
        where tsb.user_id='".$user_id."' limit $start_limit,$end_limit";
    //echo $query;exit;
    $result=$this->db->query($query)->result_array();
    return $result;
  }
 
  public function getuserPaymentStatus($user_id){

    $query="SELECT id,valid_to as package_expiry_date,valid_from as package_start_date from payment_info where user_id='".$user_id."' and payment_status='success' ORDER BY created_on desc";
    // echo $query;exit;
    $result=$this->db->query($query)->row_array();
    $package_expiry_date=$result['package_expiry_date'];
    $today=date('Y-m-d');

    $package_expiry_date1 = strtotime($package_expiry_date); 
    $today1 = strtotime($today); 
  
    // Compare the timestamp date  
    if ($package_expiry_date1 >= $today1){
         $result['package_exipry_status']='no';
         $result['package_is_trial']='no';
         $query="SELECT id,package_expiry_date,package_start_date from user_freepackage_trials where user_id='".$user_id."'";
         $checkFreePackage=$this->db->query($query)->row_array();
         if(!empty($checkFreePackage)){
            $result['user_taken_trial']='yes';
         }else{
            $result['user_taken_trial']='no';
            }
    }else{
        $result['package_exipry_status']='yes';
        $result['package_is_trial']='no';
        $result['user_taken_trial']='no'; 
        $query="SELECT id,package_expiry_date,package_start_date from user_freepackage_trials where user_id='".$user_id."'";
        // echo $query;exit;
        $checkFreePackage=$this->db->query($query)->row_array();
        if(!empty($checkFreePackage)){
            $result=array(
                        'id'=>$checkFreePackage['id'],
                        'package_expiry_date'=>$checkFreePackage['package_expiry_date'],
                        'package_start_date'=>$checkFreePackage['package_start_date'],
                         );
            $check_package_expiry_date=$checkFreePackage['package_expiry_date'];
            $today2=date('Y-m-d');

            $free_package_expiry_date1 = strtotime($check_package_expiry_date); 
            $free_today1 = strtotime($today2);
            if ($free_package_expiry_date1 >= $free_today1){
                    $result['package_exipry_status']='no';
                    $result['package_is_trial']='yes';
             }else{
                    $result['package_exipry_status']='yes';
                    $result['package_is_trial']='no';
             }
             $result['user_taken_trial']='yes'; 
        }
    
    }

    return $result;
  }

  public function activateFreePackage($user_id,$package_id){

    $pquery="select * from packages where id='".$package_id."' ";
    $package_data=$this->db->query($pquery)->row_array();
    $payment_id=0;

    $check_freeuser=$this->db->query("select * from user_freepackage_trials where user_id='".$user_id."' and package_id='".$package_id."' ")->row_array();
    if(empty($check_freeuser)){

    if(!empty($package_data)){
        $valid_days=3;
        $valid_to= date('Y-m-d', strtotime("+".$valid_days." days", strtotime(date('Y-m-d'))));

        $user_free_trial=array(
                                'user_id'=> $user_id,
                                'package_id'=> $package_id,
                                'package_start_date'=> date('Y-m-d'),
                                'package_expiry_date'=> $valid_to,
                                'created_on'=> date('Y-m-d H:i:s')
                              );
        $this->db->insert('user_freepackage_trials',$user_free_trial);
        if($package_data['course_ids'] !=''){
            $ex_course_ids=explode(',',$package_data['course_ids']);
            foreach($ex_course_ids as $ckey=>$cvalue){
                $check_paid_course=$this->db->query("select id from users_paid_courses where user_id='".$user_id."' and course_id='".$cvalue."' and package_id='".$package_id."' and payment_status='free' ")->row_array();
                if(empty($check_paid_course)){
                $course_data=array(
                                    'user_id'=>$user_id,
                                    'course_id'=>$cvalue,
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'payment_status'=>'free',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_paid_courses',$course_data);
                }
            }

            foreach($ex_course_ids as $ckey=>$cvalue){
            $check_user_exam=$this->db->query("select id from users_exams where user_id='".$user_id."' and exam_id='".$cvalue."' and payment_type='free' ")->row_array();
            if(empty($check_user_exam)){
                $course_data1=array(
                                    'user_id'=>$user_id,
                                    'exam_id'=>$cvalue,
                                    'delete_status'=>1,
                                    'payment_type'=>'free',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_exams',$course_data1);
                }
            }
        }
        if($package_data['qbank_subject_ids'] !=''){
         $ex_qbankSubject_ids=explode(',',$package_data['qbank_subject_ids']);
         foreach($ex_qbankSubject_ids as $qbankkey=>$qbankvalue){

            $check_qbank_subject=$this->db->query("select id from users_paid_qbanksubjects where user_id='".$user_id."' and subject_id='".$qbankvalue."' and package_id='".$package_id."' and payment_status='free' ")->row_array();
            if(empty($check_qbank_subject)){
                $qbank_data=array(
                                    'user_id'=>$user_id,
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'subject_id'=>$qbankvalue,
                                    'payment_status'=>'free',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_paid_qbanksubjects',$qbank_data);
                }
            }
         }
        if($package_data['video_subject_ids'] !=''){
        $ex_videoSubject_ids=explode(',',$package_data['video_subject_ids']);
        foreach($ex_videoSubject_ids as $videokey=>$videovalue){
            $check_video_subject=$this->db->query("select id from users_paid_videosubjects where user_id='".$user_id."' and subject_id='".$videovalue."' and package_id='".$package_id."' and payment_status='free' ")->row_array();
            if(empty($check_video_subject)){
                $video_data=array(
                                    'user_id'=>$user_id,
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'subject_id'=>$videovalue,
                                    'payment_status'=>'free',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_paid_videosubjects',$video_data);
                }
            }
        }
        if($package_data['test_series_ids'] !=''){
            $ex_testSeries_ids=explode(',',$package_data['test_series_ids']);
            foreach($ex_testSeries_ids as $testkey=>$testvalue){
                $check_test_series=$this->db->query("select id from users_paid_testseries where user_id='".$user_id."' and test_series_id='".$testvalue."' and package_id='".$package_id."' and payment_status='free' ")->row_array();
                if(empty($check_test_series)){
                $video_data=array(
                                    'user_id'=>$user_id,
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'test_series_id'=>$testvalue,
                                    'payment_status'=>'free',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_paid_testseries',$video_data);
             }
            }
        }
    }
        return 1;
    }else{
        return 0;
    }

  }

  public function insertUserInterstedCourse($user_id,$course_id){

    $course=$this->db->query("SELECT name from exams WHERE id='".$course_id."' ")->row_array();
    $user=$this->db->query("SELECT name,mobile from users WHERE id='".$user_id."' ")->row_array();
    $mobile=  $user['mobile'];
    $check=$this->db->query("SELECT id from user_interseted_courses WHERE user_mobile='".$mobile."' ")->row_array();
    if(empty($check)){
       $insert_data=array(
                        'user_id'=>$user_id,
                        'user_name'=>$user['name'],
                        'user_mobile'=>$user['mobile'],
                        'course_id'=>$course_id,
                        'course_name'=>$course['name'],
                        'created_on'=>date('Y-m-d H:i:s')
                      );
        $this->db->insert('user_interseted_courses',$insert_data);
        }
  }

 public function getFreePackage(){
    $result=$this->db->query("SELECT id,package_name from packages WHERE package_type='3' ")->row_array();
    return $result;
 }

 public function getQuizTotalMarks($course_id, $category_id, $quiz_id){

    $query="select sum(positive_marks) as total_marks from test_series_questions where course_id='".$course_id."' and category_id='".$category_id."' and quiz_id='".$quiz_id."' and status='Active' GROUP BY quiz_id";
    //echo $query;exit;
    $test_questions=$this->db->query($query)->row_array();
    return $test_questions['total_marks'];
     
     
 }


}

?>