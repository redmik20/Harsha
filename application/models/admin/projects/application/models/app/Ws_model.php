<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Ws_model extends CI_Model{

public function __construct()
    {
     parent::__construct();
    
     $this->db2 = $this->load->database('dbmci', TRUE);
     
    }

    public function updateUserDeviceId($user_id,$device_id){

        $update_data=array(
                            'device_id'=> $device_id,
                          );
        $this->db->update('users',$update_data,array('id'=>$user_id));
        //echo $this->db->last_query();exit;
        $student=$this->db->query("select student_id from users where id='".$user_id."' ")->row_array();
        $student_id=$student['student_id'];
        $result=$this->db2->update('tbl_students',$update_data,array('student_dynamic_id'=>$student_id));
        //echo $this->db2->last_query();exit;
        return $result;
    }

    public function updateUserAndroidDeviceId($user_id,$android_device_id){

        $update_data=array(
                            'android_device_id'=> $android_device_id,
                          );
        $this->db->update('users',$update_data,array('id'=>$user_id));
        //echo $this->db->last_query();exit;
        $student=$this->db->query("select student_id from users where id='".$user_id."' ")->row_array();
        $student_id=$student['student_id'];
        $result=$this->db2->update('tbl_students',$update_data,array('student_dynamic_id'=>$student_id));
        //echo $this->db2->last_query();exit;
        return $result;
    }

    public function userDeviceId($user_id){
        $student=$this->db->query("select device_id,android_device_id from users where id='".$user_id."' ")->row_array();
        //$device_id=$student['device_id'];
        return $student;
    }

    function set_users($RecordData = NULL)



    {



        if ($RecordData)



        {



            $this

                ->db

                ->insert('users_exams', $RecordData);



            //echo $this->db->last_query();exit;

            



            $insert_id = $this

                ->db

                ->insert_id();



            return $insert_id;



        }



        return 0;



    }

    function insertUnRegisterUser($mobile,$otp){

        $insert_ary=array(
                            'mobile'=>$mobile,
                            'otp'=>$otp,
                            'created_on'=>date('Y-m-d H:i:s')
                         );
       $result=$this->db->insert('unregister_users',$insert_ary);
       return $result;
    }
    function deleteUnRegisterUser($mobile){
         $this->db->where('mobile',$mobile);
         $result=$this->db->delete('unregister_users');
         return $result;
    }

    function check_user_deleted($mobile)



    {



        $this

            ->db

            ->where('delete_status', 1);



        $this

            ->db

            ->where('mobile', $mobile);



        //$this->db->or_where('email_id',$email_id);

        



        $user_status = $this

            ->db

            ->get('users');



        //echo $this->db->last_query();exit;

        



        if ($user_status->num_rows() > 0)



        {



            return $user_status->row();



        }



        return array();



    }



    function check_user_status($mobile)



    {



        $this

            ->db

            ->where('status', 'Active');



        $this

            ->db

            ->where('mobile', $mobile);



        //$this->db->or_where('email_id',$email_id);

        
        //$this->db->where('delete_status','1');


        $user_status = $this->db->get('users');



        //echo $this->db->last_query();exit;

        



        if ($user_status->num_rows() > 0)



        {



            return $user_status->row();



        }



        return array();



    }
    
    function check_user_statusForMobile($mobile)



    {



        //$this

         //   ->db

           // ->where('status', 'Active');



        $this

            ->db

            ->where('mobile', $mobile);



        //$this->db->or_where('email_id',$email_id);

        
        $this->db->where('delete_status','1');


        $user_status = $this->db->get('users');



        //echo $this->db->last_query();exit;

        



        if ($user_status->num_rows() > 0)



        {



            return $user_status->row();



        }



        return array();

    }



    function update_user($RecordData = NULL, $user_id = NULL)



    {



        if ($RecordData)



        {



            $this

                ->db

                ->update('users', $RecordData, array(

                'id' => $user_id

            ));



            //echo $this->db->last_query();exit;

            



            return true;



        }



        return false;



    }

    public function getUserEmailExists($user_id,$email_id){
        $query="select * from users where email_id='".$email_id."' and id !='".$user_id."' and delete_status='1' ";
        //echo $query;exit;
        $result=$this->db->query($query)->row_array();
        return $result;
    }



    function list_user()



    {



        //$this->db->where('type', $id);

        



        $list_users = $this

            ->db

            ->get('users');



        //echo $this->db->last_query();exit;

        



        if ($list_users->num_rows() > 0)



        {



            return $list_users->result();



        }



        return array();



    }



    function check_contact_number_exists($contact_number, $venue_id = NULL)



    {



        if ($venue_id)



        {



            $this

                ->db

                ->where('id !=', $venue_id);



        }



        $this

            ->db

            ->where('contact_number', $contact_number);



        $contact_number_exists = $this

            ->db

            ->get('venues');



        //echo $this->db->last_query();exit;

        



        if ($contact_number_exists->num_rows() > 0)



        {



            return false;



        }



        return true;



    }



    function check_email_id_exists($email_id, $venue_id = NULL)



    {



        if ($venue_id)



        {



            $this

                ->db

                ->where('id !=', $venue_id);



        }



        $this

            ->db

            ->where('email_id', $email_id);



        $contact_number_exists = $this

            ->db

            ->get('venues');



        //echo $this->db->last_query();exit;

        



        if ($contact_number_exists->num_rows() > 0)



        {



            return false;



        }



        return true;



    }

function exams1($user_id,$center_id,$batch_id){

        /*$user=$this->db->query("select bhatia_row_id from users where id='$user_id' ")->row_array();
        $bhatia_row_id=$user['bhatia_row_id'];
        */

        $this->db->select('id as exam_id,name as exam_name,image,status');
        $this->db->where('delete_status','1');
        //$this->db->where('status','Active');
        $this->db->where('bhatia_center_id',$center_id);
        $this->db->where('bhatia_batch_id',$batch_id);
        $this->db->from('exams');

        $query=$this->db->get();
        $result=$query->result_array();
        foreach($result as $key=>$value){
            $sub_result=array();
            $exam_id=$value['exam_id'];
            $this->db->select('*');
            $this->db->select("IF ((SELECT COUNT(*) FROM `users_exams` where user_id = '$user_id' and users_exams.exam_id = '$exam_id') >0, 'yes', 'no') as users_exams");
      
            $this->db->where('user_id',$user_id);
            $this->db->where('exam_id',$exam_id);
            //$this->db->where('users_exams','yes');
            $this->db->from('users_exams');
            $query=$this->db->get();
            $sub_result=$query->row_array();
            if(!empty($sub_result)){
            
                
                    $result[$key]['id']=$sub_result['id'];
                    $result[$key]['user_id']=$sub_result['user_id'];
                    //$result[$key]['exam_id']=$sub_result['exam_id'];
                    $result[$key]['users_exams']=$sub_result['users_exams'];
                    $result[$key]['payment_type']=$sub_result['payment_type'];
                    $result[$key]['delete_status']=$sub_result['delete_status'];
                    $result[$key]['status']=$value['status'];
                    $result[$key]['created_on']=$sub_result['created_on'];
                }else{
                   
                    $result[$key]['id']='';
                    $result[$key]['user_id']='';
                    //$result[$key]['exam_id']='';
                    $result[$key]['users_exams']='no';
                    $result[$key]['payment_type']='free';
                    $result[$key]['delete_status']='';
                    $result[$key]['status']=$value['status'];
                    $result[$key]['created_on']='';
                }
           

            if(($result[$key]['users_exams'] == 'no') && ($result[$key]['status'] == 'Inactive')){
                    unset($result[$key]);
            }

        }

        foreach ($result as $key => $value) {
            $new_result[]=$value;
        }


        
        return $new_result;
    }

    function user_exams($user_id,$course_id=NULL)



    {



        if($course_id){

            $this

            ->db

            ->where('ue.exam_id', $course_id);

        }

        $this

            ->db

            ->where('exams.delete_status', 1);



        $this

            ->db

            ->where('ue.delete_status', 1);



        $this

            ->db

            ->where('ue.user_id', $user_id);



        $this

            ->db

            ->join('exams', 'exams.id = ue.exam_id');



        $this

            ->db

            ->select('ue.*, exams.name as exam_name,exams.image');



        $this

            ->db

            ->select("IF ((SELECT COUNT(*) FROM `users_exams` where user_id = '$user_id' and users_exams.exam_id = ue.exam_id) >0, 'yes', 'no') as users_exams");



        $users = $this->db->get('users_exams ue');



        //echo $this->db->last_query();exit;

        



        if ($users->num_rows() > 0)



        {



            return $users->result();



        }



        return array();



    }



    function user_loginForMobile($mobile)



    {



        $this

            ->db

            ->where('delete_status', 1);



        $this

            ->db

            ->where('mobile', $mobile);



        



        $user_login = $this

            ->db

            ->get('users');



        //echo $this->db->last_query();exit;

        



        if ($user_login->num_rows() > 0)



        {



            return $user_login->row_array();



        }



        return array();



    }

    function updateLoginUserStatus($user_id){

        $update_status=array(
                                'login_status'=>'true',
                            );
        $this->db->update('users',$update_status,array('id'=>$user_id));
       // echo $this->db->last_query();exit;
        return true;

    }

    function updateUserLogoutStatus($user_id){
        $update_status=array(
                                'login_status'=>'false',
                            );
        $result=$this->db->update('users',$update_status,array('id'=>$user_id));
       // echo $this->db->last_query();exit;
        return $result;
    }
    
    
    function user_login($mobile, $password)



    {



        $this

            ->db

            ->where('delete_status', 1);



        $this

            ->db

            ->where('mobile', $mobile);



        $this

            ->db

            ->where('password', md5($password));



        $user_login = $this

            ->db

            ->get('users');



        //echo $this->db->last_query();exit;

        



        if ($user_login->num_rows() > 0)



        {



            return $user_login->row_array();



        }



        return array();



    }



    function banners($course_id=NULL)



    {

  
        $this

            ->db

            ->where('delete_status', 1);

        if($course_id){

            $this

            ->db

            ->where('exam_id', $course_id);

        }

        $this->db->order_by('order','asc');
        $banners = $this

            ->db

            ->get('banners');



        //echo $this->db->last_query();exit;

        



        if ($banners->num_rows() > 0)



        {



            return $banners->result();



        }



        return array();



    }



    function update_user_device_token($user_id = NULL, $token = NULL, $ios_token = NULL)

    {

        if($token !=''){
            $RecordData = array(

            'token' => $token

        );
        }
        
        if($ios_token !=''){
            $RecordData = array(

            'ios_token' => $ios_token

        );
        }

       // $this->db->update('users', $RecordData, array('id' => $user_id));
        $this->db->where('id', $user_id);
        $users = $this->db->get('users')->row_array();   
        //echo $this->db->last_query();exit; 
       // echo '<pre>';print_r($users);exit;
        if($users['token'] == $token){
         $result= $this->db->update('users', $RecordData, array('id' => $user_id));
        }else{
            $check_token=$this->db->query("select id from users_unknown_tokens where token='".$token."' ")->row_array();
            if(empty($check_token)){
                    $insert_token=array(
                        
                        'user_id'=>$user_id,
                        'name'=>$users['name'],
                        'mobile'=>$users['mobile'],
                        'token' => $token,
                        'created_on'=> date('Y-m-d H:i:s')
                        );
                  $this->db->insert('users_unknown_tokens', $insert_token, array('id' => $user_id));
                  $unknown_tokens_count=$users['unknown_tokens_count']+1;
                  $update_token_count= array(
                            'unknown_tokens_count' => $unknown_tokens_count,
                            'token' => $token
                                            );
                  $result= $this->db->update('users',$update_token_count,array('id' => $user_id));
            }
        }
        return $result;       
    }



    function right_answers($user_id, $quizs_id, $type)



    {



        $this

            ->db

            ->order_by('user_qbank.id', 'asc');



        if ($type == "right")



        {



            $this

                ->db

                ->where('user_qbank.answer_status', 'correct');



        }



        elseif ($type == "wrong")



        {



            $this

                ->db

                ->where('user_qbank.answer_status', 'wrong');



        }



        elseif ($type == "all")



        {



        }



        else



        {



            $this

                ->db

                ->where('user_qbank.answer_status', 'not answered');



        }



        $this

            ->db

            ->where('user_qbank.user_id', $user_id);



        $this

            ->db

            ->where('user_qbank.topic_id', $quizs_id);



        $this

            ->db

            ->join('qbank', 'qbank.id = user_qbank.qbank_id', 'left');



        $this

            ->db

            ->select('qbank.question,qbank.option_a,qbank.option_b,qbank.option_c,qbank.option_d, qbank.answer as qbank_answer, qbank.answer, user_qbank.*, qbank.id as qbank_id,IF((select count(id) from bookmarks where bookmarks.qbank_id=user_qbank.qbank_id and bookmarks.user_id=' . $user_id . ')>0, "yes","no") as bookmark_status');



        $users = $this

            ->db

            ->get('user_qbank');



        //echo $this->db->last_query();exit;

        



        if ($users->num_rows() > 0)



        {



            $res = $users->result_array();



            return $res;



        }



        return array();



    }



    function examdata()



    {



        $this

            ->db

            ->where('delete_status', 1);



        $examdata = $this

            ->db

            ->get('homepagedata');



        //echo $this->db->last_query();exit;

        



        if ($examdata->num_rows() > 0)



        {



            return $examdata->result();



        }



        return array();



    }



    function get_topic($topic_id)



    {



        $this

            ->db

            ->where('delete_status', 1);



        $this

            ->db

            ->where('id', $topic_id);



        $topics = $this

            ->db

            ->get('video_topics');



        //echo $this->db->last_query();exit;

        



        if ($topics->num_rows() > 0)



        {



            return $topics->result();



        }



        return array();



    }



    function get_questions($topic_id, $from)



    {



        $this

            ->db

            ->where('video_topics_id', $topic_id);



        $this

            ->db

            ->limit('5', $from);



        $questions = $this

            ->db

            ->get('qbank');



        //echo $this->db->last_query();exit;

        



        if ($questions->num_rows() > 0)



        {



            return $questions->result();



        }



        return array();



    }



    function exam_subjects($exam_id,$user_id)



    {



        $this

            ->db

            ->where('sub.exam_id', $exam_id);



        $this

            ->db

            ->join('exams', 'exams.id = sub.exam_id');



        //$this->db->join('', 'exams.id = sub.exam_id');

        



        $this

            ->db

            ->select('sub.*, exams.name as exam_name');
        //$this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions  where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = sub.id  and quiz_questions.topic_id = qt.id) as questions_count");

       // $this->db->select("(select count(id) from quiz_topics where quiz_topics.subject_id=sub.id) as total_topics_count");

            
        $this->db->select("(select count(id) from quiz_topic_reviews where quiz_topic_reviews.subject_id=sub.id and quiz_topic_reviews.user_id='$user_id' and quiz_topic_reviews.course_id='$exam_id') as quiz_topic_completed_count");

        $this->db->where('sub.delete_status','1');
        
         $where = '(sub.category_type =2 or sub.category_type=0)';
       $this->db->where($where);
        $users = $this->db->get('subjects sub');



        //echo $this->db->last_query();exit;

        



        if ($users->num_rows() > 0)



        {

            $users=$users->result_array();
             
            for ($i = 0;$i < sizeof($users);$i++)

            {

                $subject_id=$users[$i]['id'];
                $this->db->where('course_id', $exam_id);
                $this->db->where('subject_id', $users[$i]['id']);
                $this->db->select('id');
                $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions  where quiz_questions.course_id = '$exam_id' and quiz_questions.subject_id = '$subject_id'  and quiz_questions.`topic_id` = quiz_topics.`id`) as questions_count");
                $this->db->having('questions_count >', 0);
                $topics_count = $this->db->get('quiz_topics');
                $topics_count = $topics_count->result_array();

                //echo $this->db->last_query();exit;
                // var_dump($bookmark_id['id']);die;

                //$users[$i]['total_chapters_count'] = count($topics_count);

                    $j=1;
                    $qbank_topics_finalCount=0;
                    foreach($topics_count as $key =>$chapter){

                    $chapter_id=$chapter['id'];
                    $this->db->select('id as qbank_topic_id,name as qbank_topic_name,banner_image as image,title');

                    
                    $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$exam_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = '$chapter_id' and quiz_questions.qbank_topic_id=quiz_qbanktopics.id) as questions_count");

                    //$this->db->select("(select count(id) from quiz_topic_reviews where quiz_topic_reviews.user_id='$user_id' and quiz_topic_reviews.course_id='$exam_id' and quiz_topic_reviews.subject_id='$subject_id' and quiz_topic_reviews.topic_id='$chapter_id' and quiz_topic_reviews.qbank_topic_id=quiz_qbanktopics.id) as quiz_topic_completed_count");

                    $this->db->where('course_id',$exam_id);
                    $this->db->where('subject_id',$subject_id);
                    $this->db->where('chapter_id',$chapter_id);
                    $this->db->having('questions_count >', 0);
                    $this->db->from('quiz_qbanktopics');

                    $sub_result=$this->db->get();
                    //echo $this->db->last_query();exit;
                    $qbank_topics=$sub_result->result_array();
                    
//echo '<pre>';print_r($qbank_topics);exit;
                        if(!empty($qbank_topics)){
                            $chapters_count= $j++;
                            $qbank_topics_count=count($qbank_topics);
                            $qbank_topics_finalCount += $qbank_topics_count;
                        }else{
                            unset($result[$key]);
                        }
                    }

                    $users[$i]['total_chapters_count'] = $chapters_count;
                    $users[$i]['total_qbankTopics_count'] = $qbank_topics_finalCount;

                   // $users[$i]['quiz_topic_completed_count'] = $quiz_topic_completed_count;
                    
            }
            
            return $users;

           // return $users->result();



        }



        return array();



    }

    function exam_subjects_new($exam_id,$user_id)
    {



        $this

            ->db

            ->where('sub.exam_id', $exam_id);



        $this

            ->db

            ->join('exams', 'exams.id = sub.exam_id');

        $this

            ->db

            ->select('`sub`.`id`, `sub`.`subject_name`, `sub`.`category_type`,`sub`.`category_values`,`sub`.`icon` as image, `sub`.`exam_id`, `sub`.`video_path`, `sub`.`total_time`, `sub`.`questions_count`, `sub`.`order`, `sub`.`delete_status`, `sub`.`videos_count`, `sub`.`created_on`, `sub`.`modified_on`,exams.name as exam_name');
        

            
        $this->db->select("(select count(id) from quiz_topic_reviews where quiz_topic_reviews.subject_id=sub.id and quiz_topic_reviews.user_id='$user_id' and quiz_topic_reviews.course_id='$exam_id') as quiz_topic_completed_count");

        $this->db->select("(select count(id) from quiz_topics where quiz_topics.subject_id=sub.id and quiz_topics.course_id='$exam_id') as total_chapters_count");


        $this->db->select("(select count(id) from quiz_qbanktopics where quiz_qbanktopics.subject_id=sub.id and quiz_qbanktopics.course_id='$exam_id' and delete_status=1) as total_qbankTopics_count");

        //$this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions  where quiz_questions.course_id = '$exam_id' and quiz_questions.subject_id = sub.id) as questions_count");

         $this->db->where('sub.delete_status','1');
         //$this->db->where('sub.questions_count !=', 0);
         //$where = '(sub.category_type =2 or sub.category_type=0)';
         $this->db->where('find_in_set("2", category_values) <> 0');
         
         //$this->db->where($where);
         $this->db->order_by('sub.order','asc');
         $query = $this->db->get('subjects sub');
        //echo $this->db->last_query();exit;
         $result=$query->result_array();

         return $result;
    }

    



    function video_mode($status)



    {



        $this

            ->db

            ->where('uv.mode', $status);



        $this

            ->db

            ->join('chapter_videos', 'chapter_videos.chapters_videos_id = uv.chapters_videos_id');



        $users = $this

            ->db

            ->get('user_videos uv');



        if ($users->num_rows() > 0)



        {



            return $users->result();



        }



        return array();



    }



    function plandetails(){



        $this

            ->db

            ->where('delete_status', 1);



        $plandetails = $this

            ->db

            ->get('plan_details');



        //echo $this->db->last_query();exit;

        



        if ($plandetails->num_rows() > 0)



        {



            return $plandetails->result();



        }



        return array();



    }



    function users_plan($user_id)



    {



        $this

            ->db

            ->where('user_plans.user_id', $user_id);



        $this

            ->db

            ->join('plan_details', 'plan_details.id = user_plans.plan_id');



        $this

            ->db

            ->join('coupons', 'coupons.id = plan_details.coupon_id');



        $this

            ->db

            ->select('user_plans.*,plan_details.*,coupons.coupon_code,coupons.discount');



        $user_plan = $this

            ->db

            ->get('user_plans');



        //var_dump($user_plan);

        



        //echo $this->db->last_query();exit;

        



        if ($user_plan->num_rows() > 0)



        {



            return $user_plan->result();



        }



        return array();



    }



    function demosinglevideo($data)



    {



        $demovideos;



        //echo $this->db->last_query();exit;

        



        if ($data['status'] == 'All')



        {



            $demovideos = $this

                ->db



                ->from('chapters')



                ->where('chapters.subject_id', $data['subject_id'])

->where('delete_status', 1)



                ->where('chapters.free_or_paid', 'free')



                ->order_by('chapters.id', 'desc')



                ->limit(1)



                ->get()

                ->row_array();



        }



        foreach ($demovideos as $demovideo)

        {



            $rating = $this

                ->db



                ->from('ratings')



                ->where('chapter_video_id', $chapter->id)



                ->select('IFNULL(CAST(AVG(rating)AS DECIMAL (10,1)), 0) as rating')



                ->get()

                ->row();



            $demovideo->rating = $rating->rating;



        }



        //echo $this->db->last_query();exit;

        



        return $demovideos;



    }



    function demosinglevideos($data)



    {



        $demovideos;



        //echo $this->db->last_query();exit;

        



        if ($data['status'] == 'All')



        {



            $demovideos = $this

                ->db



                ->from('video_topics')



                ->where('video_topics.subject_id', $data['subject_id'])

->where('delete_status', 1)



                ->where('video_topics.free_or_paid', 'free')



                ->order_by('video_topics.id', 'desc')



                ->limit(1)



                ->get()

                ->row_array();



        }



        foreach ($demovideos as $demovideo)

        {



            $rating = $this

                ->db



                ->from('ratings')



                ->where('video_topics_id', $chapter->id)



                ->select('IFNULL(CAST(AVG(rating)AS DECIMAL (10,1)), 0) as rating')



                ->get()

                ->row();



            $demovideo->rating = $rating->rating;



        }



        //echo $this->db->last_query();exit;

        



        return $demovideos;



    }



    function chapter_status_list($data)



    {



        $chapters = [];



        if ($data['status'] == 'All')

        {



            // return all chapters related to subject_id

            



            $chapters = $this

                ->db



                ->from('chapters')



                ->where('chapters.subject_id', $data['subject_id'])

->where('delete_status', 1)



                ->get()

                ->result();



            //	echo $this->db->last_query();exit;

            



            

        }

        else

        {



            if ($data['status'] == 'Unseen')

            {



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



                $chapters = $this

                    ->db

                    ->query($query, [



                $data['subject_id'],



                $data['subject_id'],



                $data['user_id']



                ])->result();



            }

            else if ($data['status'] == 'Completed' || $data['status'] == 'Paused')

            {



                // if the all topics that exist in a chapter are Completed

                



                // then only the chapter is consdered as Completed

                



                $chapters = $this

                    ->db



                    ->from('chapters')



                    ->where('chapters.subject_id', $data['subject_id'])

->join('video_topics', 'video_topics.chapter_id = chapters.id')



                    ->where('chapters.delete_status', 1)



                    ->group_by('chapters.id')



                    ->select('chapters.*, COUNT(chapters.id) as topics_count')



                    ->get()

                    ->result();



                $completed = [];



                $paused = [];



                foreach ($chapters as $chapter)

                {



                    $user_topics = $this

                        ->db



                        ->from('video_topics')



                        ->where('video_topics.chapter_id', $chapter->id)



                        ->where('video_topics.delete_status', 1)



                        ->join('user_topics', 'user_topics.video_topic_id = video_topics.id')



                        ->where('user_topics.user_id', $data['user_id'])

->where('user_topics.topic_status', 'Completed')



                        ->group_by('video_topics.chapter_id')



                        ->select('COUNT(video_topics.id) as c_topics_count')



                        ->get()

                        ->row();



                    if ($user_topics)

                    {



                        // calculate avg. rating

                        



                        $rating = $this

                            ->db



                            ->from('ratings')



                            ->where('chapter_video_id', $chapter->id)



                            ->select('IFNULL(CAST(AVG(rating)AS DECIMAL (10,1)), 0) as rating')



                            ->get()

                            ->row();



                        $chapter->rating = $rating->rating;



                        // compare total topics exist with the no. of topics with Completed status

                        



                        if ($chapter->topics_count == $user_topics->c_topics_count)

                        {



                            array_push($completed, $chapter);



                        }

                        else if ($chapter->topics_count > $user_topics->c_topics_count)

                        {



                            array_push($paused, $chapter);



                        }



                    }



                }



                if ($data['status'] == 'Completed')

                {



                    return $completed;



                }

                else if ($data['status'] == 'Paused')

                {



                    return $paused;



                }



            }



        }



        // calculate avg. rating for all the chapters with All/Unseen/Paused status

        



        foreach ($chapters as $chapter)

        {



            $rating = $this

                ->db



                ->from('ratings')



                ->where('chapter_video_id', $chapter->id)



                ->select('IFNULL(CAST(AVG(rating)AS DECIMAL (10,1)), 0) as rating')



                ->get()

                ->row();



            $chapter->rating = $rating->rating;



        }



        return $chapters;



    }



    function chapter_status_lists($data)



    {



        $chapters = [];



        if ($data['status'] == 'All')

        {



            // return all chapters related to subject_id

            



            $chapters = $this

                ->db



                ->from('video_topics')



                ->where('video_topics.subject_id', $data['subject_id'])

->where('video_topics.free_or_paid', 'Free')



                ->where('video_topics.delete_status', 1)



                ->get()

                ->result();



            //	echo $this->db->last_query();exit;

            



            

        }



        else

        {



            if ($data['status'] == 'Finished')

            {



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



                $chapters = $this

                    ->db

                    ->query($query, [



                $data['subject_id'],



                $data['subject_id'],



                $data['user_id']



                ])->result();



                //echo $this->db->last_query();

                



                

            }

            else if ($data['status'] == 'Unfinished' || $data['status'] == 'Continuing')

            {



                // if the all topics that exist in a chapter are Completed

                



                // then only the chapter is consdered as Completed

                



                $chapters = $this

                    ->db



                    ->from('video_topics')



                    ->where('video_topics.subject_id', $data['subject_id'])

->where('video_topics.delete_status', 1)



                    ->group_by('video_topics.id')



                    ->select('video_topics.*, COUNT(video_topics.id) as topics_count')



                    ->get()

                    ->result();



                //echo $this->db->last_query();exit;

                



                $unfinished = [];



                $continuing = [];



                //print_r($chapters);exit;

                



                foreach ($chapters as $chapter)

                {



                    $user_topics = $this

                        ->db



                        ->from('video_topics')



                        ->where('video_topics.id', $chapter->id)



                        ->where('video_topics.delete_status', 1)



                        ->join('user_topics', 'user_topics.video_topic_id = video_topics.id')



                        ->where('user_topics.user_id', $data['user_id'])

->where('user_topics.topic_status', NULL)



                        ->group_by('video_topics.chapter_id')



                        ->select('COUNT(video_topics.id) as c_topics_count')



                        ->get()

                        ->row();



                    //echo $this->db->last_query();exit;

                    



                    if ($user_topics)

                    {



                        // calculate avg. rating

                        



                        $rating = $this

                            ->db



                            ->from('ratings')



                            ->where('video_topics_id', $chapter->id)



                            ->select('IFNULL(CAST(AVG(rating)AS DECIMAL (10,1)), 0) as rating')



                            ->get()

                            ->row();



                        $chapter->rating = $rating->rating;



                        // compare total topics exist with the no. of topics with Completed status

                        



                        if ($chapter->topics_count == $user_topics->c_topics_count)

                        {



                            array_push($unfinished, $chapter);



                        }

                        else if ($chapter->topics_count > $user_topics->c_topics_count)

                        {



                            array_push($continuing, $chapter);



                        }



                    }



                }



                //print_r($chapters);exit;

                



                if ($data['status'] == 'unfinished')

                {



                    return $unfinished;



                }

                else if ($data['status'] == 'continuing')

                {



                    return $continuing;



                }



            }



        }



        // calculate avg. rating for all the chapters with All/Unseen/Paused status

        



        foreach ($chapters as $chapter)

        {



            $rating = $this

                ->db



                ->from('ratings')



                ->where('video_topics_id', $chapter->id)



                ->select('IFNULL(CAST(AVG(rating)AS DECIMAL (10,1)), 0) as rating')



                ->get()

                ->row();



            $chapter->rating = $rating->rating;



        }



        return $chapters;



    }



    function get_user_access($user_id)

    {



        //check if user subscribe to plan and has video access

        



        $user_plans = $this

            ->db



            ->from('user_plans')



            ->join('plan_details', 'plan_details.id = user_plans.plan_id')



            ->where('user_id', $user_id)

->where('expire_at > CURRENT_TIMESTAMP', null, false)



            ->select('plan_details.videos_access, plan_details.tests_access







				, plan_details.q_bank_access')



            ->get()

            ->row();



        //print_r($user_plans->videos_access);exit;

        



        $access = [



        'videos_access' => false,



        'tests_access' => false,



        'q_bank_access' => false



        ];



        foreach ($user_plans as $user_plan)

        {



            if ($user_plan->videos_access)

            {



                $access['videos_access'] = true;



            }



            if ($user_plans->tests_access)

            {



                $access['tests_access'] = true;



            }



            if ($user_plans->q_bank_access)

            {



                $access['q_bank_access'] = true;



            }



        }



        return $access;



    }

    function get_all_chapters($subject_id, $user_id,$course_id)
    {

        $this->db->where('course_id', $course_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->order_by('order', 'asc');
        $videochapters = $this->db->get('videochapters');
        
        

        if($videochapters->num_rows()>0){   

            $videochapters=$videochapters->result_array();
            foreach($videochapters as $key=>$value){

            $videochapters[$key]=$value;
            $this->db->where('exam_id', $value['course_id']);
            $this->db->where('subject_id', $value['subject_id']);
            $this->db->where('chapter_id', $value['id']);
            $this->db->where('delete_status', '1');
            $this->db->order_by('order', 'asc');
            $chapters = $this->db->get('chapters');
            $chapters=$chapters->result_array();
            //echo '<pre>';print_r($chapters);exit;
           if(!empty($chapters)){
            for ($i=0; $i < sizeof($chapters); $i++) {

               $videochapters[$key]['videos'][$i]=$chapters[$i]; 
                $chapter_id=$chapters[$i]['id'];

        $query="select * from user_chapters where user_id='$user_id' and chapter_id='$chapter_id' ";
        $user_seen_chapters=$this->db->query($query)->row_array();

        if(!empty($user_seen_chapters)){
             $videochapters[$key]['videos'][$i]['user_seen_status']=$user_seen_chapters['chapter_status'];
        }else{
            $videochapters[$key]['videos'][$i]['user_seen_status']='unseen';
        }


                $this->db->where('chapter_video_id', $chapters[$i]['id']);

                $this->db->select('FORMAT(AVG(rating),0) as ratings');

                $ratings = $this->db->get('ratings');

                $ratings = $ratings->row_array();

               $videochapters[$key]['videos'][$i]['rating']=$ratings['ratings'];

               if($chapters[$i]['video_date'] != '0000-00-00'){
                $video_date=date('d M',strtotime($chapters[$i]['video_date']));
                $date_ary=explode('-',$chapters[$i]['video_date']);
                       $new_exam_date= $date_ary[2].'-'.$date_ary[1].'-'.$date_ary[0];
                      // echo '<pre>';print_r($new_exam_date);
                       $today_date=date('d-m-Y');
                      // echo '<pre>';print_r($today_date);exit;
                       if(strtotime($new_exam_date) <= strtotime($today_date)){
                          $allow_status=1;
                        }else{
                          $allow_status=0;
                        }
                   }else{
                    $allow_status=1;
                    $video_date= '';
                    }

               $videochapters[$key]['videos'][$i]['video_date']=$video_date;
               $videochapters[$key]['videos'][$i]['allow_status']=$allow_status;

                $this->db->select('id,exam_id,subject_id,chapter_id,topic_name,start_time,free_or_paid');
                $this->db->where('chapter_id', $chapters[$i]['id']);
                $this->db->where('exam_id', $value['course_id']);
                $this->db->where('subject_id', $value['subject_id']);
                $this->db->where('delete_status', '1');
                $video_topics = $this->db->get('video_topics');
               // echo $this->db->last_query();exit;
                $video_topics1 = $video_topics->result_array();
               // $videochapters[$key]['videos'][$i]['video_topics']=$video_topics1;
                $subject_id=$value['subject_id'];
                $query="select * from users_paid_videosubjects where user_id='".$user_id."' and subject_id='".$subject_id."'";
                $paid_video_subject=$this->db->query($query)->row_array();
                if(!empty($paid_video_subject)){
                    //$videochapters[$key]['videos'][$i]['subscription_status']='yes';
                    
                    $checkFreePackage=$this->db->query("select * from user_freepackage_trials where user_id='".$user_id."'")->row_array();
                    if(!empty($checkFreePackage)){
                    $check_package_expiry_date=$checkFreePackage['package_expiry_date'];
                    $today2=date('Y-m-d');
                    $free_package_expiry_date1 = strtotime($check_package_expiry_date); 
                    $free_today1 = strtotime($today2);

                    if (($free_package_expiry_date1 >= $free_today1) && ($paid_video_subject['payment_status'] == 'free')){
                               $videochapters[$key]['videos'][$i]['subscription_status']='yes';
                         }else if($paid_video_subject['payment_status'] == 'paid'){
                                $videochapters[$key]['videos'][$i]['subscription_status']='yes';
                         }else{
                            $videochapters[$key]['videos'][$i]['subscription_status']='no';
                         }
                     }else{
                        $videochapters[$key]['videos'][$i]['subscription_status']='yes';
                     }

                }else{
                    $videochapters[$key]['videos'][$i]['subscription_status']='no';
                }


             }
         }else{
            $videochapters[$key]['videos']=array();
            unset($videochapters[$key]);
         }

    }

            $new_videochapters1=array();
            foreach ($videochapters as $key => $value) {
                $new_videochapters1[]=$value;
            }
            return $new_videochapters1;

        }

        return array();

    }

    function all_chapters($subject_id, $user_id,$course_id)
    {

        $this->db->where('course_id', $course_id);
        $this->db->where('subject_id', $subject_id);
        $videochapters = $this->db->get('videochapters');
        
        

        if($videochapters->num_rows()>0){   

            $videochapters=$videochapters->result_array();
            foreach($videochapters as $key=>$value){

            $videochapters[$key]=$value;
            $this->db->where('exam_id', $value['course_id']);
            $this->db->where('subject_id', $value['subject_id']);
            $this->db->where('chapter_id', $value['id']);
            $this->db->where('delete_status', '1');
            $chapters = $this->db->get('chapters');
            $chapters=$chapters->result_array();
            //echo '<pre>';print_r($chapters);exit;
           if(!empty($chapters)){
            for ($i=0; $i < sizeof($chapters); $i++) {

               $videochapters[$key]['videos'][$i]=$chapters[$i]; 

                $this->db->where('chapter_video_id', $chapters[$i]['id']);

                $this->db->select('FORMAT(AVG(rating),0) as ratings');

                $ratings = $this->db->get('ratings');

                $ratings = $ratings->row_array();

               $videochapters[$key]['videos'][$i]['rating']=$ratings['ratings'];

               if($chapters[$i]['video_date'] != '0000-00-00'){
                $video_date=date('d M',strtotime($chapters[$i]['video_date']));
                   }else{$video_date= '';}

               $videochapters[$key]['videos'][$i]['video_date']=$video_date;
                

                $this->db->select('id,exam_id,subject_id,chapter_id,topic_name,start_time,free_or_paid');
                $this->db->where('chapter_id', $chapters[$i]['id']);
                $this->db->where('exam_id', $value['course_id']);
                $this->db->where('subject_id', $value['subject_id']);
                $this->db->where('delete_status', '1');
                $video_topics = $this->db->get('video_topics');
               // echo $this->db->last_query();exit;
                $video_topics1 = $video_topics->result_array();
               // $videochapters[$key]['videos'][$i]['video_topics']=$video_topics1;
             }
         }else{
            $videochapters[$key]['videos']=array();
            unset($videochapters[$key]);
         }

    }

            return $videochapters;

        }

        return array();

    }
    function free_chapters($subject_id, $user_id,$course_id)
    {

        $this->db->where('course_id', $course_id);
        $this->db->where('subject_id', $subject_id);
        $videochapters = $this->db->get('videochapters');
        
        if($videochapters->num_rows()>0){   

            $videochapters=$videochapters->result_array();
            foreach($videochapters as $key=>$value){

            $videochapters[$key]=$value;
            $this->db->where('exam_id', $value['course_id']);
            $this->db->where('subject_id', $value['subject_id']);
            $this->db->where('chapter_id', $value['id']);
            $this->db->where('free_or_paid', 'free');
            $this->db->where('delete_status', '1');
            $chapters = $this->db->get('chapters');
            $chapters=$chapters->result_array();
            //echo '<pre>';print_r($chapters);exit;
           if(!empty($chapters)){
            for ($i=0; $i < sizeof($chapters); $i++) {

               $videochapters[$key]['videos'][$i]=$chapters[$i]; 

                $this->db->where('chapter_video_id', $chapters[$i]['id']);

                $this->db->select('FORMAT(AVG(rating),0) as ratings');

                $ratings = $this->db->get('ratings');

                $ratings = $ratings->row_array();

               $videochapters[$key]['videos'][$i]['rating']=$ratings['ratings'];

            
             }
         }else{
            $videochapters[$key]['videos']=array();
            unset($videochapters[$key]);
         }

    }

            return $videochapters;

        }

        return array();

    }
    
    function all_webchapters($subject_id)

    {

        

        $this->db->where('subject_id', $subject_id);
         $this->db->where('delete_status', '1');

        $chapters = $this->db->get('chapters');
        

        if($chapters->num_rows()>0)

        {   

            $chapters=$chapters->result_array();

            return $chapters;

        }

        return array();

    }



    function status_chapters($subject_id, $user_id,$course_id,$status)

    {

        $this->db->where('course_id', $course_id);
        $this->db->where('subject_id', $subject_id);
        $videochapters = $this->db->get('videochapters');

    if($videochapters->num_rows()>0){

            $videochapters=$videochapters->result_array();
        foreach($videochapters as $key=>$value){
            $videochapters[$key]=$value;
        $this->db->where('chapters.exam_id', $course_id);

        $this->db->where('user_chapters.user_id', $user_id);

        $this->db->where('chapters.subject_id', $subject_id);

        $this->db->where('chapters.chapter_id', $value['id']);
        $this->db->where('chapters.delete_status', '1');

        $this->db->where('user_chapters.chapter_status', $status);

        $this->db->join('user_chapters', 'chapters.id=user_chapters.chapter_id');

        $this->db->select('chapters.*');

        $chapters = $this->db->get('chapters');

        //echo $this->db->last_query();exit;

        if($chapters->num_rows()>0)
        {   

            $chapters=$chapters->result_array();

            for ($i=0; $i < sizeof($chapters); $i++) { 

                $videochapters[$key]['videos'][$i]=$chapters[$i];

                $this->db->where('chapter_video_id', $chapters[$i]['id']);

                $this->db->select('FORMAT(AVG(rating),0) as ratings');

                $ratings = $this->db->get('ratings');

                $ratings = $ratings->row_array();

               // $chapters[$i]['rating']=$ratings['ratings'];
                $videochapters[$key]['videos'][$i]['rating']=$ratings['ratings'];



                $chapter_id=$chapters[$i]['id'];
                $query="select * from user_chapters where user_id='$user_id' and chapter_id='$chapter_id' ";
                        $user_seen_chapters=$this->db->query($query)->row_array();

                        if(!empty($user_seen_chapters)){
                             $videochapters[$key]['videos'][$i]['user_seen_status']=$user_seen_chapters['chapter_status'];
                        }else{
                            $videochapters[$key]['videos'][$i]['user_seen_status']='unseen';
                        }

                if($chapters[$i]['video_date'] != '0000-00-00'){
                $video_date=date('d M',strtotime($chapters[$i]['video_date']));
                $date_ary=explode('-',$chapters[$i]['video_date']);
                       $new_exam_date= $date_ary[2].'-'.$date_ary[1].'-'.$date_ary[0];
                      // echo '<pre>';print_r($new_exam_date);
                       $today_date=date('d-m-Y');
                      // echo '<pre>';print_r($today_date);exit;
                       if(strtotime($new_exam_date) <= strtotime($today_date)){
                          $allow_status=1;
                        }else{
                          $allow_status=0;
                        }
                   }else{
                    $allow_status=1;
                    $video_date= '';
                    }

               $videochapters[$key]['videos'][$i]['video_date']=$video_date;
               $videochapters[$key]['videos'][$i]['allow_status']=$allow_status;



                $this->db->select('id,exam_id,subject_id,chapter_id,topic_name,start_time,free_or_paid');
                $this->db->where('chapter_id', $chapters[$i]['id']);
                $this->db->where('exam_id', $value['course_id']);
                $this->db->where('subject_id', $value['subject_id']);
                $this->db->where('delete_status', '1');
                $video_topics = $this->db->get('video_topics');
               // echo $this->db->last_query();exit;
                $video_topics1 = $video_topics->result_array();
               // $videochapters[$key]['videos'][$i]['video_topics']=$video_topics1;
                $subject_id=$value['subject_id'];
                $query="select * from users_paid_videosubjects where user_id='".$user_id."' and subject_id='".$subject_id."' ";
                $paid_video_subject=$this->db->query($query)->row_array();
                if(!empty($paid_video_subject)){
                    $videochapters[$key]['videos'][$i]['subscription_status']='yes';
                }else{
                    $videochapters[$key]['videos'][$i]['subscription_status']='no';
                }

            }

            //return $chapters;

        }else{
            $videochapters[$key]['videos']=array();
            unset($videochapters[$key]);
        }
    }
    return $videochapters;
}

        return array();

    }

    function unseen_chapters1($subject_id, $user_id,$course_id){
        $this->db->where('course_id', $course_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->order_by('order', 'asc');
        $videochapters = $this->db->get('videochapters');
        
        

        if($videochapters->num_rows()>0){   

            $videochapters=$videochapters->result_array();
            foreach($videochapters as $key=>$value){

            $videochapters[$key]=$value;
            $this->db->where('exam_id', $value['course_id']);
            $this->db->where('subject_id', $value['subject_id']);
            $this->db->where('chapter_id', $value['id']);
            $this->db->where('delete_status', '1');
            $this->db->order_by('order', 'asc');
            $chapters = $this->db->get('chapters');
            $chapters=$chapters->result_array();
           // echo '<pre>';print_r($chapters);
           if(!empty($chapters)){
            for ($i=0; $i < sizeof($chapters); $i++) {

               $videochapters[$key]['videos'][$i]=$chapters[$i]; 
                $chapter_id=$chapters[$i]['id'];

        $query="select * from user_chapters where user_id='$user_id' and chapter_id='$chapter_id' ";
        $user_seen_chapters=$this->db->query($query)->row_array();

        if(!empty($user_seen_chapters)){
             $videochapters[$key]['videos'][$i]['user_seen_status']=$user_seen_chapters['chapter_status'];
        }else{
            $videochapters[$key]['videos'][$i]['user_seen_status']='unseen';
        }


                $this->db->where('chapter_video_id', $chapters[$i]['id']);

                $this->db->select('FORMAT(AVG(rating),0) as ratings');

                $ratings = $this->db->get('ratings');

                $ratings = $ratings->row_array();

               $videochapters[$key]['videos'][$i]['rating']=$ratings['ratings'];

               if($chapters[$i]['video_date'] != '0000-00-00'){
                $video_date=date('d M',strtotime($chapters[$i]['video_date']));
                $date_ary=explode('-',$chapters[$i]['video_date']);
                       $new_exam_date= $date_ary[2].'-'.$date_ary[1].'-'.$date_ary[0];
                      // echo '<pre>';print_r($new_exam_date);
                       $today_date=date('d-m-Y');
                      // echo '<pre>';print_r($today_date);exit;
                       if(strtotime($new_exam_date) <= strtotime($today_date)){
                          $allow_status=1;
                        }else{
                          $allow_status=0;
                        }
                   }else{
                    $allow_status=1;
                    $video_date= '';
                    }

               $videochapters[$key]['videos'][$i]['video_date']=$video_date;
               $videochapters[$key]['videos'][$i]['allow_status']=$allow_status;

                $this->db->select('id,exam_id,subject_id,chapter_id,topic_name,start_time,free_or_paid');
                $this->db->where('chapter_id', $chapters[$i]['id']);
                $this->db->where('exam_id', $value['course_id']);
                $this->db->where('subject_id', $value['subject_id']);
                $this->db->where('delete_status', '1');
                $video_topics = $this->db->get('video_topics');
               // echo $this->db->last_query();exit;
                $video_topics1 = $video_topics->result_array();
               // $videochapters[$key]['videos'][$i]['video_topics']=$video_topics1;
                $subject_id=$value['subject_id'];
                $query="select * from users_paid_videosubjects where user_id='".$user_id."' and subject_id='".$subject_id."' ";
                $paid_video_subject=$this->db->query($query)->row_array();
                if(!empty($paid_video_subject)){
                    $videochapters[$key]['videos'][$i]['subscription_status']='yes';
                }else{
                    $videochapters[$key]['videos'][$i]['subscription_status']='no';
                }

                if($videochapters[$key]['videos'][$i]['user_seen_status'] !='unseen'){
                     unset($videochapters[$key]['videos'][$i]);
                }



             }


             foreach($videochapters[$key]['videos'] as $vkvalue){
                $videochapters_video[]=$vkvalue;
             }
             $videochapters[$key]['videos'] =$videochapters_video;

         }else{
            $videochapters[$key]['videos']=array();
            unset($videochapters[$key]);
         }

     }

            $new_videochapters1=array();
            foreach ($videochapters as $key => $value) {
                $new_videochapters1[]=$value;
            }
            return $new_videochapters1;

        }

        return array();
    }

    function unseen_chapters($subject_id, $user_id,$course_id)

    {
        $new_videochapters=array();
        $this->db->where('course_id', $course_id);
        $this->db->where('subject_id', $subject_id);
        $videochapters = $this->db->get('videochapters');
        
        

        if($videochapters->num_rows()>0){   

            $videochapters=$videochapters->result_array();

        foreach($videochapters as $key=>$value){

            $videochapters[$key]=$value;

        $this->db->where('chapters.exam_id', $course_id);

        $this->db->where('user_chapters.user_id', $user_id);

        $this->db->where('chapters.subject_id', $subject_id);

        $this->db->where('chapters.chapter_id', $value['id']);

        $this->db->where('chapters.delete_status', '1');

        $this->db->join('user_chapters', 'chapters.id=user_chapters.chapter_id');

        $this->db->select('chapters.*');

        $user_chapters = $this->db->get('chapters');
//echo $this->db->last_query();exit;
        $user_chapters=$user_chapters->result_array();

        $chapter_ids=array_column($user_chapters, 'id');


//echo '<pre>';print_r($chapter_ids);exit;
        if(!empty($chapter_ids)){

            $this->db->where('exam_id', $course_id);

            $this->db->where('subject_id', $subject_id);
            $this->db->where('chapter_id', $value['id']);

            $this->db->where_not_in('id', $chapter_ids);
            $this->db->where('chapters.delete_status', '1');
            $chapters = $this->db->get('chapters');
//echo $this->db->last_query();exit;
            if($chapters->num_rows()>0)

            {   

                $chapters=$chapters->result_array();

                for ($i=0; $i < sizeof($chapters); $i++) {

                
                $videochapters[$key]['videos'][$i]=$chapters[$i]; 

                    $this->db->where('chapter_video_id', $chapters[$i]['id']);

                    $this->db->select('FORMAT(AVG(rating),0) as ratings');

                    $ratings = $this->db->get('ratings');

                    $ratings = $ratings->row_array();

                    //$chapters[$i]['rating']=$ratings['ratings'];
                    $videochapters[$key]['videos'][$i]['rating']=$ratings['ratings'];

                    if($chapters[$i]['video_date'] != '0000-00-00'){
                $video_date=date('d M',strtotime($chapters[$i]['video_date']));
                $date_ary=explode('-',$chapters[$i]['video_date']);
                       $new_exam_date= $date_ary[2].'-'.$date_ary[1].'-'.$date_ary[0];
                      // echo '<pre>';print_r($new_exam_date);
                       $today_date=date('d-m-Y');
                      // echo '<pre>';print_r($today_date);exit;
                       if(strtotime($new_exam_date) <= strtotime($today_date)){
                          $allow_status=1;
                        }else{
                          $allow_status=0;
                        }
                   }else{
                    $allow_status=1;
                    $video_date= '';
                    }

               $videochapters[$key]['videos'][$i]['video_date']=$video_date;
               $videochapters[$key]['videos'][$i]['allow_status']=$allow_status;
        
                }

                //return $chapters;
            }else{ 
                $videochapters[$key][$i]['videos'] =array();
                unset($videochapters[$key]);
            }

        }else{
             $videochapters[$key][$i]['videos'] =array();
             unset($videochapters[$key]);
        }
        
    }
        
    foreach($videochapters as $k=>$vc){
        $new_videochapters[]=$vc;
    }

    return $new_videochapters;
}

        return array();
}


function sendDetailsToVideoApi($chapter_id, $user_id){

    $chapter = $this->db->from('chapters')->where('id', $chapter_id)->where('delete_status', 1)->get()->row();

    $user_name = $this->db->select('name,email_id,mobile')->from('users')->where('id', $user_id)->where('delete_status', 1)->get()->row();

     $VideoId = $chapter->video_path;

            //$VideoId="e7ada0e1c7f4445faebfae9c9c6ba631";
            //$VideoId=$_POST['video_id'];
            $client_key = CLIENT_KEY;
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

                      'licenseRules'=> json_encode([
                      'canPersist' => true,
                      'rentalDuration' => 15 * 24 * 3600
                    ]),



                'annotate' => json_encode([[



                'type' => 'rtext',



                'text' => $user_name->name."\n".$user_name->mobile,



                'alpha' => '0.60',



                'color' => '0x696969',



                'size' => '15',



                'interval' => '5000',

                'canPersist'=> true,

                'rentalDuration'=> '1296000'



                ],



                [



                'type' => 'text',



                'text' => 'Plato',



                'x' => '10',



                'y' => '50',



                'alpha' => '0.8',



                'color' => '0xFF0000',



                'size' => '15'



                ]



                ]) ,



                ]) ,



                CURLOPT_HTTPHEADER => array(



                    "Accept: application/json",



                    "Authorization: Apisecret " . $client_key,

                    "Content-Type: application/json",




                ) ,



            ));



            $response = curl_exec($curl);



            $err = curl_error($curl);



            curl_close($curl);



            $otp_response = json_decode($response);



            //echo '<pre>';print_r($otp_response);exit;

            // exit();
            $OTP = $otp_response->otp;
            $playbackInfo = $otp_response->playbackInfo;
            $chapter->otp = $OTP;
            $chapter->playback = $playbackInfo;



            if ($chapter)
            {

                $topics = $this->db->from('video_topics')->where('chapter_id', $chapter_id)->where('delete_status', 1)->order_by('start_time', 'asc')->get()->result();
                $chapter->topics = $topics;
                return [
                        'has_access' => true,
                        'requested_video' => $chapter

                        ];

                }else{
                 return [
                         'has_access' => true,
                         'message' => 'Requested video does not exist'
                        ];

                }

}


    function chapter_videodetails($chapter_id, $user_id)



    {



        //check if user subscribe to plan and has video access

        



$user_plans = $this

            ->db



            ->from('user_plans')



            ->join('plan_details', 'plan_details.id = user_plans.plan_id')



            ->where('user_id', $user_id)

->where('expire_at > CURRENT_TIMESTAMP', null, false)



            ->select('plan_details.videos_access')



            ->get()

            ->result();




/*$user_plans = $this

            ->db
            ->from('user_exams')

            ->where('user_id', $user_id)

            ->select('*')
            ->get()

            ->result();*/
        $has_video_access = false;



        foreach ($user_plans as $user_plan)

        {



            if ($user_plan->videos_access)

            {



                $has_video_access = true;



                break;



            }



        }



        // get video details and other videos in the same chapter as that video

        



        $chapter = $this

            ->db



            ->from('chapters')



            ->where('id', $chapter_id)

->where('delete_status', 1)



            ->get()

            ->row();



        $user_name = $this

            ->db
            ->select('name,email_id,mobile')

            ->from('users')

            ->where('id', $user_id)

            ->where('delete_status', 1)
            ->get()
            ->row();



        //echo $user_name->email_id;exit;

        



        // print_r($chapter);exit;

        



        if ($has_video_access || $chapter->free_or_paid === "free" || $chapter->free_or_paid === "paid")

        {



            $VideoId = $chapter->video_path;



            //$VideoId="e7ada0e1c7f4445faebfae9c9c6ba631";

            



            //$VideoId=$_POST['video_id'];

            



            $client_key = CLIENT_KEY;



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



                'type' => 'rtext',



                //'text' => $user_name->name."\n".$user_name->mobile,

                'text'=> '',


                'alpha' => '0.60',



                'color' => '0x696969',



                'size' => '15',



                'interval' => '5000'



                ],



                [



                'type' => 'text',



                'text' => 'Plato',



                'x' => '10',



                'y' => '50',



                'alpha' => '0.8',



                'color' => '0xFF0000',



                'size' => '15'



                ]



                ]) ,



                ]) ,



                CURLOPT_HTTPHEADER => array(



                    "Accept: application/json",



                    "Authorization: Apisecret " . $client_key,



                    "Content-Type: application/json"



                ) ,



            ));



            $response = curl_exec($curl);



            $err = curl_error($curl);



            curl_close($curl);



            $otp_response = json_decode($response);



            //echo '<pre>';

            



            // print_r($otp_response);die;

            



            // exit();

            



            $OTP = $otp_response->otp;



            $playbackInfo = $otp_response->playbackInfo;



            $chapter->otp = $OTP;



            $chapter->playback = $playbackInfo;



            if ($chapter)

            {



                $topics = $this

                    ->db



                    ->from('video_topics')



                    ->where('chapter_id', $chapter_id)

->where('delete_status', 1)



                    ->order_by('start_time', 'asc')



                    ->get()

                    ->result();



                $chapter->topics = $topics;



                return [



                'has_access' => true,



                'requested_video' => $chapter



                ];



            }

            else

            {



                return [



                'has_access' => true,



                'message' => 'Requested video does not exist'



                ];



            }



        }

        else

        {



            return [



            'has_access' => false,



            'message' => 'User does not have video access & it is a paid video',



            'requested_video' => '{}'



            ];



        }



    }



    //chapter video id as chapter id

    



    function user_ratings($chapter_video_id, $user_id)



    {



        $this

            ->db

            ->where('chapter_video_id', $chapter_video_id);



        $this

            ->db

            ->where('user_id', $user_id);



        $this

            ->db

            ->join('users', 'users.id = ratings.user_id');



        $this

            ->db

            ->select('ratings.*');



        $user_ratings = $this

            ->db

            ->get('ratings');



        //echo $this->db->last_query();exit;

        



        if ($user_ratings->num_rows() > 0)



        {



            $res = $user_ratings->result_array();



            return $res;



        }



        return array();



    }



    function user_faq($user_id)



    {



        if ($user_id == '')



        {



            $users = $this

                ->db

                ->get('faq');



        }



        else



        {



            $this

                ->db

                ->select('faq.*');



            $this

                ->db

                ->where('faq.user_id', $user_id);



            $users = $this

                ->db

                ->get('faq');



        }



        if ($users->num_rows() > 0)



        {



            return $users->result();



        }



        return array();



    }



    function student_support($user_id)



    {

        $this

            ->db

            ->where('student_support.user_id', $user_id);



        $this

            ->db

            ->join('users', 'users.id = student_support.user_id');



        $this

            ->db

            ->select('student_support.*');



        $student_support = $this

            ->db

            ->get('student_support');



        //echo $this->db->last_query();exit;

        



        if ($student_support->num_rows() > 0)



        {



            $res = $student_support->result();



            return $res;



        }



        return array();



    }



    function user_notifications()



    {

        $this->db->order_by('id', 'desc');
        $this->db->where('delete_status', '1');
        $notifications = $this

            ->db

            ->get('notifications');



        //echo $this->db->last_query();exit;

        



        if ($notifications->num_rows() > 0)



        {



            return $notifications->result();



        }



        return array();



    }



    function user_slides($chapter_id)



    {



        //$this->db->where('ue.user_id', $user_id);

        



        $this

            ->db

            ->where('ue.chapter_id', $chapter_id);



        $this

            ->db

            ->where('ue.chapters_status', 'free');



        $this

            ->db

            ->select('ue.*');



        $users = $this

            ->db

            ->get('chapters_slides ue');



        //echo $this->db->last_query();exit;

        



        if ($users->num_rows() > 0)



        {



            return $users->result();



        }



        return array();



    }



    function check_userotherlogin_deleted($email_id)



    {



        $this

            ->db

            ->where('delete_status', 1);



        $this

            ->db

            ->where('email_id', $email_id);



        $user_status = $this

            ->db

            ->get('users');



        //echo $this->db->last_query();exit;

        



        if ($user_status->num_rows() > 0)



        {



            return $user_status->row();



        }



        return array();



    }



    function check_userotherlogin_status($email_id)



    {



        $this

            ->db

            ->where('status', 'Active');



        $this

            ->db

            ->where('email_id', $email_id);



        $user_status = $this

            ->db

            ->get('users');



        //echo $this->db->last_query();exit;

        



        if ($user_status->num_rows() > 0)



        {



            return $user_status->row();



        }



        return array();



    }



    function user_otherlogin($email_id, $password)



    {



        $this

            ->db

            ->where('delete_status', 1);



        $this

            ->db

            ->where('email_id', $email_id);



        $this

            ->db

            ->where('password', md5($password));



        $user_login = $this

            ->db

            ->get('users');



        //echo $this->db->last_query();exit;

        



        if ($user_login->num_rows() > 0)



        {



            return $user_login->row_array();



        }



        return array();



    }



    function exams()



    {



        $exams = $this

            ->db

            ->get('exams');



        //echo $this->db->last_query();exit;

        



        if ($exams->num_rows() > 0)



        {



            return $exams->result();



        }



        return array();



    }



    function subjects($exam_id)



    {



        $this

            ->db

            ->where('subjects.delete_status', 1);



        $this

            ->db

            ->where('subjects.exam_id', $exam_id);
            
            
        $this->db->select('subjects.*');
        $this->db->select("(select count(id) from chapters where chapters.subject_id=subjects.id and chapters.exam_id='$exam_id' and chapters.delete_status=1) as total_videos_count");
        $this->db->select("(select GROUP_CONCAT(id) from chapters where chapters.subject_id=subjects.id and chapters.exam_id='$exam_id') as video_ids");
       
        $where = '(subjects.category_type =1 or subjects.category_type=0)';
       $this->db->where($where);
        $subjects = $this

            ->db

            ->get('subjects');



        //echo $this->db->last_query();exit;

        



        if ($subjects->num_rows() > 0)



        {



            return $subjects->result();



        }



        return array();



    }
  
     function getVedioSeenCount($user_id,$capter_id){
        
        $this->db->select('id');
        $this->db->where('user_id', $user_id);
        $this->db->where('chapter_id', $capter_id);
        $this->db->where('chapter_status', 'completed');
        $this->db->where('delete_status', '1');
        $user_chapters = $this->db->get('user_chapters');
        //echo $this->db->last_query();exit;
        if ($user_chapters->num_rows() > 0){
        return $user_chapters->result_array();
        }
         return array();
         
     }

     function getSubjects($user_id,$exam_id){

        $query="select `id`,`subject_name`,`category_values`,`icon`,`image`,`order`,`videos_count` as total_videos_count,

(select count(uc.id) from user_chapters uc  inner join chapters chap on chap.id=uc.chapter_id where chap.subject_id=subjects.id and uc.user_id='".$user_id."' and subjects.exam_id='".$exam_id."' and chap.status='Active' and chap.delete_status='1' and uc.chapter_status='completed') as seenVedioCount

from subjects where exam_id='".$exam_id."'  and delete_status='1' and find_in_set('1', category_values) <>0 ORDER BY subjects.order asc";
        //echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;
     }



    function check_otheruser_deleted($mobile, $email_id)



    {



        $this

            ->db

            ->where('delete_status', 1);



        $this

            ->db

            ->where('mobile', $mobile);



        //$this->db->or_where('email_id',$email_id);

        



        $user_status = $this

            ->db

            ->get('users');



        //echo $this->db->last_query();exit;

        



        if ($user_status->num_rows() > 0)



        {



            return $user_status->row();



        }



        return array();



    }



    function check_otheruser_status($mobile)



    {



        $this

            ->db

            ->where('status', 'Active');



        $this

            ->db

            ->or_where('mobile', $mobile);



        //$this->db->or_where('email_id',$email_id);

        



        $user_status = $this

            ->db

            ->get('users');



        //echo $this->db->last_query();exit;

        



        if ($user_status->num_rows() > 0)



        {



            return $user_status->row();



        }



        return array();



    }



    function user_faculty($exam_id)



    {



        $this

            ->db

            ->where('ue.exam_id', $exam_id);



        $this

            ->db

            ->where('ue.delete_status', 1);



        $this

            ->db

            ->select('ue.*');



        $users = $this

            ->db

            ->get('faculty_details ue');



        //echo $this->db->last_query();exit;

        



        if ($users->num_rows() > 0)



        {



            return $users->result();



        }



        return array();



    }



    function videotimes($chapter_id)



    {



        $this

            ->db

            ->join('chapters', 'chapters.chapter_id = ue.chapter_id');



        $this

            ->db

            ->where('ue.chapter_id', $chapter_id);



        $this

            ->db

            ->select(' chapters.chapter_name,ue.*');



        $users = $this

            ->db

            ->get('chapter_videos ue');



        if ($users->num_rows() > 0)



        {



            return $users->result();



        }



        return array();



    }



    function subject_chapters($subject_id)



    {



        $this

            ->db

            ->where('chapters.subject_id', $subject_id);
        $this

            ->db

            ->where('chapters.status', 'Active');


        $this

            ->db

            ->join('subjects', 'subjects.subject_id = chapters.subject_id');



        $this

            ->db

            ->join('chapter_videos', 'chapter_videos.chapters_videos_id = chapters.chapter_id');



        $this

            ->db

            ->select('subjects.subject_name,chapters.chapter_name,chapter_videos.video_name,chapter_videos.video_path');



        $users = $this

            ->db

            ->get('chapters');



        //echo $this->db->last_query();exit;

        



        if ($users->num_rows() > 0)



        {



            return $users->result();



        }



        return array();



    }



    function subject_chapter($subject_id, $data)



    {



        if ($data['status'] == "All")



        {



        }



        else



        {



            $this

                ->db

                ->where('user_videos.video_status', $data['status']);



            $this

                ->db

                ->where('subject_chapters.subject_id', $subject_id);



            $this

                ->db

                ->join('subjects', 'subjects.subject_id = chapters.subject_id');



            $this

                ->db

                ->join('user_videos', 'user_videos.id =user_videos.video_status chapters.chapter_id');



            $this

                ->db

                ->join('chapter_videos', 'chapter_videos.chapters_videos_id = subject_chapters.id');



            $this

                ->db

                ->select('subjects.subject_name,chapters.chapter_name,chapter_videos.video_name,chapter_videos.video_path');



        }



        $user_videos = $this

            ->db

            ->get('subject_chapters');



        //echo $this->db->last_query();exit;

        



        if ($user_videos->num_rows() > 0)



        {



            return $user_videos->result();



        }



        return array();



    }



    function check_user_exam_exists($exam_id = NULL, $user_id = NULL)



    {



        if ($exam_id)



        {



            $this

                ->db

                ->where('id !=', $exam_id);



        }



        $this

            ->db

            ->where('exam_id', $exam_id);



        $this

            ->db

            ->where('user_id', $user_id);



        $user_name_exists = $this

            ->db

            ->get('users_exams');



        //echo $this->db->last_query();exit;

        



        if ($user_name_exists->num_rows() > 0)



        {



            return false;



        }



        return true;



    }



    function add_user_exams($RecordData = NULL)



    {



        if ($RecordData)



        {



            $this

                ->db

                ->insert('users_exams', $RecordData);



            //echo $this->db->last_query();exit;

            



            $insert_id = $this

                ->db

                ->insert_id();



            return $insert_id;



        }



        return 0;



    }



    function delete_user_exam($user_id, $exam_id)
    {



        $this

            ->db

            ->where('delete_status', 1);



        $this

            ->db

            ->where('exam_id', $exam_id);



        $this

            ->db

            ->where('user_id', $user_id);



        $this

            ->db

            ->delete('users_exams');



        //echo $this->db->last_query();exit;

        



        return true;



    }



    function check_anyuser_deleted($mobile, $email_id)



    {



        $this

            ->db

            ->where('delete_status', 1);



        $this

            ->db

            ->where('mobile', $mobile);



        $this

            ->db

            ->or_where('email_id', $email_id);



        $user_status = $this

            ->db

            ->get('users');



        //echo $this->db->last_query();exit;

        



        if ($user_status->num_rows() > 0)



        {



            return $user_status->row();



        }



        return array();



    }



    function check_anyuser_status($mobile, $email_id)



    {



        $this

            ->db

            ->where('status', 'Active');



        $this

            ->db

            ->where('mobile', $mobile);



        $this

            ->db

            ->or_where('email_id', $email_id);



        $user_status = $this

            ->db

            ->get('users');



        //echo $this->db->last_query();exit;

        



        if ($user_status->num_rows() > 0)



        {



            return $user_status->row();



        }



        return array();



    }



    function user_plandetails($plan_details_id)



    {



        $this

            ->db

            ->where('plan_details.id', $plan_details_id);



        $this

            ->db

            ->join('coupons', 'coupons.id = plan_details.coupon_id');



        $this

            ->db

            ->select('plan_details.*,coupons.coupon_code,round((plan_details.price * (coupons.discount_percentage / 100))) as discounted_amount');



        $user_plan = $this

            ->db

            ->get('plan_details');



        //var_dump($user_plan);

        



        // echo $this->db->last_query();exit;

        



        if ($user_plan->num_rows() > 0)



        {



            return $user_plan->result_array();



        }



        return array();



    }



    function proplansdetails()



    {



        $this

            ->db

            ->where('delete_status', 1);



        $this

            ->db

            ->where('plan_type', 'proplans');



        $this

            ->db

            ->select('







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



        $event_types = $this

            ->db

            ->get('plan_details');



        //echo $this->db->last_query();exit;

        



        if ($event_types->num_rows() > 0)



        {



            return $event_types->result_array();



        }



        return array();



    }



    function induvidualplandetails()



    {



        $this

            ->db

            ->where('delete_status', 1);



        $this

            ->db

            ->where('plan_type', 'IndividualPlans');



        $this

            ->db

            ->select('







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



        $event_types = $this

            ->db

            ->get('plan_details');



        //echo $this->db->last_query();exit;

        



        if ($event_types->num_rows() > 0)



        {



            return $event_types->result_array();



        }



        return array();



    }



    function user_plan($user_id)



    {



        $this

            ->db

            ->where('user_plans.user_id', $user_id);



        //$this->db->where('user_plans.plan_id', $plan_id);

        



        $this

            ->db

            ->join('plan_details', 'plan_details.id = user_plans.plan_id');



        $this

            ->db

            ->join('coupons', 'coupons.id = plan_details.coupon_id');



        $this

            ->db

            ->select('user_plans.*,coupons.coupon_code,coupons.discount_percentage,plan_details.*,( CASE WHEN tests_access=1 THEN "Yes" 







			WHEN tests_access=0 THEN "No"







			END ) as tests_access,







			( CASE WHEN q_bank_access=1 THEN "Yes" 







			WHEN q_bank_access=0 THEN "No"







			END ) as q_bank_access,







			( CASE WHEN videos_access=1 THEN "Yes" 







			WHEN videos_access=0 THEN "No"







			END ) as videos_access');



        $user_plan = $this

            ->db

            ->get('user_plans');



        //var_dump($user_plan);

        



        //echo $this->db->last_query();exit;

        



        if ($user_plan->num_rows() > 0)



        {



            return $user_plan->result_array();



        }



        return array();



    }



    function change_password($oldpassword, $newpassword, $user_id)



    {



        $this

            ->db



            ->where('password', md5($oldpassword));



        $user = $this

            ->db

            ->get('users');



        //echo $this->db->last_query();exit;

        



        if ($user->num_rows() > 0)



        {



            $this

                ->db



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



        $this

            ->db

            ->where('plan_details.id', $plan_details_id);



        $this

            ->db

            ->join('coupons', 'coupons.id = plan_details.coupon_id');



        $this

            ->db

            ->select('plan_details.price,coupons.discount_percentage');



        $user_plan = $this

            ->db

            ->get('plan_details');



        //var_dump($user_plan);

        



        //echo $this->db->last_query();exit;

        



        if ($user_plan->num_rows() > 0)



        {



            return $user_plan->result_array();



        }



        return array();



    }



    public function add_to_favourites($data)



    {



        $this

            ->db

            ->where('user_id', $data['user_id']);



        $this

            ->db

            ->where('exam_id', $data['exam_id']);



        $q = $this

            ->db

            ->get('users_exams');



        $res = $q->num_rows();



        //echo $this->db->last_query();

        



        $insert = "";



        $delete = "";



        //echo $res;exit;

        



        if ($res == 0)



        {



            $insert = $this

                ->db

                ->insert('users_exams', $data);



        }



        else



        {



            $this

                ->db

                ->where('user_id', $data['user_id']);



            $this

                ->db

                ->where('exam_id', $data['exam_id']);



            $delete = $this

                ->db

                ->delete('users_exams');



        }



        //echo $this->db->last_query();

        



        //echo $insert;

        



        if ($insert)



        {



            return 1;



        }



        elseif ($delete)



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



        if ($user_id == '')



        {



            $this

                ->db

                ->where('exams.delete_status', 1);



            $user_exams = $this

                ->db

                ->get('exams');



        }



        else



        {



            $this

                ->db

                ->select('exams.*,(select count(id) from users_exams where users_exams.exam_id=exams.id and users_exams.user_id=' . $user_id . ' and users_exams.delete_status=1) as selected');


            $this

                ->db

                ->select('(select payment_type from users_exams where users_exams.exam_id=exams.id and users_exams.user_id=' . $user_id . ' and users_exams.delete_status=1) as payment_status');


            $this

                ->db

                ->where('exams.delete_status', 1);

            $this->db->order_by('exams.order','asc');

            $user_exams = $this

                ->db

                ->get('exams');



            //	echo $this->db->last_query();exit;

            



            

        }



        if ($user_exams->num_rows() > 0)



        {



            return $user_exams->result_array();



        }



        return array();



    }



    function userselected_exams($user_id)



    {



        $this

            ->db

            ->where('delete_status', 1);



        $this

            ->db

            ->where('users_exams.user_id', $user_id);



        $this

            ->db

            ->select('users_exams.*');



        $userselected_exams = $this

            ->db

            ->get('users_exams');



        //echo $this->db->last_query();exit;

        



        if ($userselected_exams->num_rows() > 0)



        {



            return $userselected_exams->result();



        }



        return array();



    }



    function add_examsbyuser($user_id, $exam_id)

    {



        // delete which are exists already and doesn't exist in the new list

        



        $un_selected = $this

            ->db



            ->from('users_exams')



            ->where('user_id', $user_id)

->where('exam_id NOT IN (' . implode(',', $exam_id) . ')')

->delete();



        foreach ($exam_id as $e_id)

        {



            // check if already exists

            



            $user_exam = $this

                ->db



                ->from('users_exams')



                ->where('user_id', $user_id)

->where('exam_id', $e_id)

->get();



            // if doesn't exist then create one

            



            if ($user_exam->num_rows() == 0)

            {



                $this

                    ->db

                    ->insert('users_exams', [



                'user_id' => $user_id,



                'exam_id' => $e_id



                ]);



            }



        }



        return $this

            ->db



            ->from('users_exams')



            ->where('user_id', $user_id)

->get()

            ->result();



    }



    function add_usersuggest($user_id,$course_id=NULL)



    {
          


        if($course_id){

            $this

            ->db

            ->where('chapters.exam_id', $course_id);

        }

        $this

            ->db

            ->where('delete_status', 1);



        $this

            ->db

            ->where('chapters.suggested_videos', 'Yes');



        $this

            ->db

            ->select('chapters.*');



        $this

            ->db

            ->select("(SELECT cast(AVG(rating) as decimal(10,1)) FROM ratings where ratings.chapter_video_id = chapters.id) as rating");

        $this->db->limit(3);

        $chapters = $this

            ->db

            ->get('chapters');



        //echo $this->db->last_query();exit;

        



        if ($chapters->num_rows() > 0)



        {



            $result=$chapters->result_array();

                foreach($result as $key=>$value){
                $subject_id=$value['subject_id'];
                $query="select * from users_paid_videosubjects where user_id='".$user_id."' and subject_id='".$subject_id."' " ;

                $video_subject=$this->db->query($query)->row_array();
                if(!empty($video_subject)){
                    $result[$key]['subscription_status']='yes';
                }else{
                    $result[$key]['subscription_status']='no';
                }
                }

                return $result;
        }



        return array();



    }



    function add_usersuggestqbank($user_id, $course_id){

    	$this->db->distinct();

    	$this->db->where('quiz_topic_reviews.course_id', $course_id);

		$this->db->join('quiz_topics', 'quiz_topics.id=quiz_topic_reviews.topic_id');

		$this->db->join('subjects', 'subjects.id=quiz_topic_reviews.subject_id');

		$this->db->select('quiz_topics.id as topic_id,quiz_topics.topic_name as topic_name,subjects.id as subject_id,subjects.subject_name as subject_name,quiz_topics.banner_image,quiz_topics.topic_image,quiz_topics.suggested_qbank as suggested_qbank_status,quiz_topic_reviews.*');

		$this->db->select('FORMAT(AVG(quiz_topic_reviews.ratings),0) as ratings');

		$this->db->group_by('quiz_topic_reviews.topic_id');

		$this->db->order_by('AVG(quiz_topic_reviews.ratings)', 'desc');

		$topics = $this->db->get('quiz_topic_reviews');

 		//echo $this->db->last_query();exit;

		if ($topics->num_rows() > 0)

        {

            $topics=$topics->result_array();

            for ($i=0; $i < sizeof($topics); $i++) { 

                $this->db->distinct();

                $this->db->where('topic_id', $topics[$i]['topic_id']);

                $count=$this->db->get('quiz_questions');

                $count=$count->num_rows();

                $topics[$i]['question_count']=$count;

            }

            return $topics;

        }



        return array();

    }
    
    
     function getSuggestqbank($user_id,$course_id){

        $new_topics=array();

    	$this->db->distinct();

    	$this->db->where('quiz_qbanktopics.course_id', $course_id);
    	$this->db->where('quiz_qbanktopics.suggested_qbank', 'yes');
        $this->db->where('quiz_qbanktopics.status', 'Active');
        $this->db->join('subjects', 'subjects.id=quiz_qbanktopics.subject_id');
        $this->db->join('quiz_topics', 'quiz_topics.id=quiz_qbanktopics.chapter_id');

		$this->db->select('quiz_qbanktopics.id as topic_id,quiz_qbanktopics.name as topic_name,quiz_qbanktopics.quiz_type,subjects.id as subject_id,subjects.subject_name as subject_name,quiz_topics.id as chapter_id,quiz_topics.topic_name as chapter_name,quiz_qbanktopics.banner_image,quiz_qbanktopics.icon_image as topic_image,quiz_qbanktopics.suggested_qbank as suggested_qbank_status,quiz_qbanktopics.created_on,quiz_qbanktopics.status');
        $this->db->limit(10);
		$topics = $this->db->get('quiz_qbanktopics');

 	//	echo $this->db->last_query();exit;

		if ($topics->num_rows() > 0)

        {

            $topics=$topics->result_array();
            for ($i=0; $i < sizeof($topics); $i++) { 

                $qbank_topic_id=$topics[$i]['topic_id'];
                $subject_id=$topics[$i]['subject_id'];
                $chapter_id=$topics[$i]['chapter_id'];

                $this->db->distinct();

                $this->db->where('qbank_topic_id', $topics[$i]['topic_id']);

                $count=$this->db->get('quiz_questions');

                $count=$count->num_rows();
                
                $topics[$i]['question_count']=$count;
                
                $this->db->select('FORMAT(AVG(quiz_topic_reviews.ratings),0) as ratings');
                $this->db->where('quiz_topic_reviews.qbank_topic_id', $topics[$i]['topic_id']);
                $this->db->group_by('quiz_topic_reviews.topic_id');
                $review_avg=$this->db->get('quiz_topic_reviews');
                $review_avg=$review_avg->row_array();
                $topics[$i]['ratings']=$review_avg['ratings'];


                /*$counts=$this->getQbankStatusCounts($user_id,$course_id,$subject_id,$chapter_id,$qbank_topic_id);
                //echo '<pre>';print_r($counts);exit;
                if($counts['questions_count'] == $counts['answered']){
                    $topics[$i]['quiz_status']='finished';
                }else if($counts['answered'] == 0){
                    $topics[$i]['quiz_status']='unattempt';
                }else if(($counts['answered'] > 0) && ($counts['answered'] < $counts['questions_count'])){
                    $topics[$i]['quiz_status']='unfinished';
                }else if(($counts['answered'] > 0) && ($counts['answered'] > $counts['questions_count'])){
                    $topics[$i]['quiz_status']='finished';
                }*/


                $quiz_user_status=$this->getQuizUserStatus($user_id,$course_id,$subject_id,$chapter_id,$qbank_topic_id);
                if(empty($quiz_user_status)){
                    $topics[$i]['quiz_status']='unattempt';
                }else{
                    $topics[$i]['quiz_status']=$quiz_user_status['quiz_status'];
                }

                $bookmark_count=$this->getQbankBookmarkCount($user_id,$course_id,$subject_id,$chapter_id,$qbank_topic_id);
                $topics[$i]['bookmark_count']=$bookmark_count;

                $query="select * from users_paid_qbanksubjects where user_id='".$user_id."' and subject_id='".$subject_id."' ";
                $qbank_subject=$this->db->query($query)->row_array();

                if(!empty($qbank_subject)){
                    $topics[$i]['subscription_status']='yes';
                }else{
                    $topics[$i]['subscription_status']='no';
                }

                
            }
            
            foreach($topics as $key=>$topic){ 
                if($topic['quiz_status'] == 'finished'){
                    unset($topics[$key]);
                }
                if(!empty($topics[$key])){
                $new_topics[]=$topics[$key];
                }
            }

            return $new_topics;
            
        }
        return array();
    }
    
    function getSuggestedTestSeries($course_id,$user_id){
        $new_topics=array();

    	$this->db->distinct();
//$this->load->helper('date');
    	$this->db->where('test_series_quiz.course_id', $course_id);
    	$this->db->where('test_series_quiz.suggested_test_series', 'yes');
        //$this->db->join('subjects', 'subjects.id=quiz_topics.subject_id');
        $this->db->where('test_series_quiz.status','Active');

        $this->db->where('test_series_quiz.exam_time <= NOW()');

		$this->db->select("test_series_quiz.`id`, test_series_quiz.`course_id`,test_series_quiz. `category_id`, test_series_quiz.`title`,test_series_categories.title as category_title,test_series_quiz.`description`, test_series_quiz.`time`, test_series_quiz.`exam_time`, test_series_quiz.`expiry_date`, test_series_quiz.`quiz_type`, test_series_quiz.`suggested_test_series`, test_series_quiz.`test_series_image`, test_series_quiz.`status`, test_series_quiz.`created_on`, test_series_quiz.`modified_on`,test_series_quiz.`questions_count`");
        $this

            ->db

            ->select("(select exam_status from user_assigned_testseries where user_assigned_testseries.user_id='$user_id' and user_assigned_testseries.course_id='$course_id' and user_assigned_testseries.quiz_id = test_series_quiz.id) as exam_status");
        $this->db->join('test_series_categories','test_series_quiz.category_id=test_series_categories.id','inner'); 
          
        $this->db->limit(10);
		$topics = $this->db->get('test_series_quiz');

 		//echo $this->db->last_query();exit;

		if ($topics->num_rows() > 0)

        {

            $topics=$topics->result_array();
            foreach($topics as $key=>$topic){ 

                $test_series_id=$topic['id'];
                $tquery="select * from users_paid_testseries where user_id='".$user_id."' and test_series_id='".$test_series_id."' ";
                $tresult=$this->db->query($tquery)->row_array();
                if(!empty($tresult)){
                    $topics[$key]['subscription_status'] = 'yes';
                }else{
                    $topics[$key]['subscription_status'] = 'no';
                }


                if($topic['exam_status'] == 'completed'){
                    unset($topics[$key]);
                }else if($topic['exam_status'] == ''){
                    $topics[$key]['exam_status'] = 'yet-to-start';
                }
            }

            
            foreach($topics as $k=>$tp){
                $new_topics[]=$tp;
            }

            return $new_topics;

        }
        return array();

        
   


        /*$result=$this->db->query("select  `A`.`id`, `A`.`course_id`, `A`. `category_id`,`A`.`title`, `A`.`title` as `category_title`, `A`.`description`,
`A`.`time`, `A`.`exam_time`, `A`.`expiry_date`,`A`.`quiz_type`, `A`.`suggested_test_series`, `A`.`test_series_image`,
`A`.`status`, `A`.`created_on`, `A`.`modified_on`,questions_count,subscription_status,
CASE WHEN (A.exam_status_cnt='0' or in_exam_status='' )then 'yet-to-start' else in_exam_status end exam_status
from
(SELECT DISTINCT `test_series_quiz`.`id`, `test_series_quiz`.`course_id`, `test_series_quiz`. `category_id`]
`test_series_quiz`.`title`, `test_series_categories`.`title` as `category_title`, `test_series_quiz`.`description`,
`test_series_quiz`.`time`, `test_series_quiz`.`exam_time`, `test_series_quiz`.`expiry_date`,
`test_series_quiz`.`quiz_type`, `test_series_quiz`.`suggested_test_series`, `test_series_quiz`.`test_series_image`,
`test_series_quiz`.`status`, `test_series_quiz`.`created_on`, `test_series_quiz`.`modified_on`,
(SELECT count(id) from test_series_questions where course_id='".$course_id."' and test_series_questions.quiz_id=test_series_quiz.id) as questions_count,
 (select count(1) from user_assigned_testseries where user_assigned_testseries.user_id='".$user_id."' and user_assigned_testseries.course_id='".$course_id."' and user_assigned_testseries.quiz_id =  test_series_quiz.id
 and exam_status='completed') as exam_status_cnt,
 (select exam_status from user_assigned_testseries where user_assigned_testseries.user_id='".$user_id."' and user_assigned_testseries.course_id='".$course_id."' and user_assigned_testseries.quiz_id =  test_series_quiz.id ) as in_exam_status,
(select CASE WHEN COUNT(1)<>'0' THEN 'yes'ELSE 'no' END subscription_status from users_paid_testseries where user_id='".$user_id."' and test_series_id=`test_series_quiz`.`id`)subscription_status
FROM `test_series_quiz` 
INNER JOIN `test_series_categories` ON `test_series_quiz`.`category_id`=`test_series_categories`.`id`
WHERE `test_series_quiz`.`course_id` = '".$course_id."'
AND `test_series_quiz`.`suggested_test_series` = 'yes'
AND `test_series_quiz`.`status` = 'Active'
LIMIT 10)A 
  where exam_status_cnt='0'")->result_array();

        return $result;
   */


    }
    function add_usersuggest1($user_id,$course_id){
        $result=$this->db->query("SELECT `chp`.*, (SELECT cast(AVG(rating) as decimal(10, 1)) FROM ratings where ratings.chapter_video_id =chp.id) as rating,
(select CASE WHEN COUNT(1)<>'0' then 'yes' else 'no' end from users_paid_videosubjects where user_id='".$user_id."' and subject_id=chp.subject_id)subscription_status
FROM `chapters` chp
WHERE `chp`.`exam_id` = '".$course_id."'
AND `delete_status` = 1
AND `chp`.`suggested_videos` = 'Yes'
LIMIT 3")->result_array();
        return $result;
    }

    function getSuggestqbank1($user_id, $course_id){
        $reslut=$this->db->query("select A.topic_id,A.topic_name,A.quiz_type,A.subject_id,A.subject_name,A.chapter_id,A.chapter_name,
A.banner_image,A.topic_image,A.suggested_qbank_status,A.created_on,A.question_count,IFNULL(ratings,'0')ratings
,quiz_status,bookmark_count,subscription_status
from
(
SELECT  DISTINCT `quiz_qbanktopics`.`id` as `topic_id`, `quiz_qbanktopics`.`name` as `topic_name`,
`quiz_qbanktopics`.`quiz_type`, `subjects`.`id` as `subject_id`, `subjects`.`subject_name` as `subject_name`,
`quiz_topics`.`id` as `chapter_id`, `quiz_topics`.`topic_name` as `chapter_name`, `quiz_qbanktopics`.`banner_image`,
`quiz_qbanktopics`.`icon_image` as `topic_image`, `quiz_qbanktopics`.`suggested_qbank` as `suggested_qbank_status`,
`quiz_qbanktopics`.`created_on`,
(SELECT DISTINCT COUNT(1) FROM `quiz_questions` WHERE `qbank_topic_id` = quiz_qbanktopics.id)question_count,
(SELECT FORMAT(AVG(quiz_topic_reviews.ratings),0) as ratings FROM `quiz_topic_reviews`
WHERE  user_id='".$user_id."' and course_id='".$course_id."' and quiz_topic_reviews.`qbank_topic_id` = quiz_qbanktopics.id GROUP BY user_id,course_id,`quiz_topic_reviews`.`topic_id`)ratings,
(SELECT IFNULL(min(quiz_status),'unattempt')quiz_status  FROM `quiz_user_status` WHERE `user_id` = '".$user_id."' AND `course_id` = '".$course_id."' AND `subject_id` =`subjects`.`id`  AND `chapter_id` =`quiz_topics`.`id` AND `topic_id` = `quiz_qbanktopics`.`id`  
)quiz_status,
 (SELECT DISTINCT count(question_id) as count FROM `quiz_question_bookmarks`
WHERE `user_id` = '".$user_id."' AND `course_id` = '".$course_id."'  AND `subject_id` = `subjects`.`id` AND `topic_id` = `quiz_topics`.`id` AND `qbank_topic_id` = `quiz_qbanktopics`.`id`)bookmark_count,
(select CASE WHEN COUNT(1)<>'0' THEN 'yes' ELSE 'no' END  from users_paid_qbanksubjects where user_id='".$user_id."' and subject_id=`subjects`.`id`)subscription_status
FROM `quiz_qbanktopics`
JOIN `subjects` ON `subjects`.`id`=`quiz_qbanktopics`.`subject_id`
JOIN `quiz_topics` ON `quiz_topics`.`id`=`quiz_qbanktopics`.`chapter_id`
WHERE `quiz_qbanktopics`.`course_id` = '".$course_id."'
AND `quiz_qbanktopics`.`suggested_qbank` = 'yes'
LIMIT 10)A
where quiz_status<>'finished'")->result_array();
        return $result;

    }

    function getSuggestedTestSeries1($course_id,$user_id){

        $result=$this->db->query("select  `A`.`id`, `A`.`course_id`, `A`. `category_id`,`A`.`title`, `A`.`title` as `category_title`, `A`.`description`,
`A`.`time`, `A`.`exam_time`, `A`.`expiry_date`,`A`.`quiz_type`, `A`.`suggested_test_series`, `A`.`test_series_image`,
`A`.`status`, `A`.`created_on`, `A`.`modified_on`,questions_count,subscription_status,
CASE WHEN ((A.exam_status_cnt='0' and length(in_exam_status)='0') or in_exam_status IS NULL ) then 'yet-to-start' else in_exam_status end exam_status
from
(SELECT DISTINCT `test_series_quiz`.`id`, `test_series_quiz`.`course_id`, `test_series_quiz`. `category_id`,
`test_series_quiz`.`title`, `test_series_categories`.`title` as `category_title`, `test_series_quiz`.`description`,
`test_series_quiz`.`time`, `test_series_quiz`.`exam_time`, `test_series_quiz`.`expiry_date`,
`test_series_quiz`.`quiz_type`, `test_series_quiz`.`suggested_test_series`, `test_series_quiz`.`test_series_image`,
`test_series_quiz`.`status`, `test_series_quiz`.`created_on`, `test_series_quiz`.`modified_on`,
(SELECT count(id) from test_series_questions where course_id='".$course_id."' and test_series_questions.quiz_id=test_series_quiz.id) as questions_count,
 (select count(1) from user_assigned_testseries where user_assigned_testseries.user_id='".$user_id."' and user_assigned_testseries.course_id='".$course_id."' and user_assigned_testseries.quiz_id =  test_series_quiz.id
 and exam_status='completed') as exam_status_cnt,
 (select exam_status from user_assigned_testseries where user_assigned_testseries.user_id='".$user_id."' and user_assigned_testseries.course_id='".$course_id."' and user_assigned_testseries.quiz_id =  test_series_quiz.id ) as in_exam_status,
(select CASE WHEN COUNT(1)<>'0' THEN 'yes'ELSE 'no' END subscription_status from users_paid_testseries where user_id='".$user_id."' and test_series_id=`test_series_quiz`.`id`)subscription_status
FROM `test_series_quiz`
INNER JOIN `test_series_categories` ON `test_series_quiz`.`category_id`=`test_series_categories`.`id`
WHERE `test_series_quiz`.`course_id` = '".$course_id."'
AND `test_series_quiz`.`suggested_test_series` = 'yes'
AND `test_series_quiz`.`status` = 'Active'
LIMIT 10)A
   where exam_status_cnt='0'")->result_array();

        return $result;
    }

   function getQbankBookmarkCount($user_id,$course_id,$subject_id,$chapter_id,$qbank_topic_id){
    
    $this->db->select("count(question_id) as count");
    $this->db->distinct();
    $this->db->where('user_id',$user_id);
    $this->db->where('course_id',$course_id);
    $this->db->where('subject_id',$subject_id);
    $this->db->where('topic_id',$chapter_id);
    $this->db->where('qbank_topic_id',$qbank_topic_id);
    $this->db->from('quiz_question_bookmarks');
    $query=$this->db->get();
    $result=$query->row_array();
    return $result['count'];
   }





    function users_video($chapter_id, $user_id,$course_id=NULL)



    {
        
          

        if($course_id){

            $this

            ->db

            ->where('video_topics.exam_id', $course_id);

        }

        $this

            ->db

            ->where('video_topics.chapter_id', $chapter_id);



        $this

            ->db

            ->or_where('video_topics.delete_status', 1);



        $this

            ->db

            ->or_where('user_topics.user_id', $user_id);



        $this

            ->db

            ->join('user_topics', 'user_topics.video_topic_id=video_topics.id');



        $this

            ->db

            ->order_by('start_time', 'asc');



        $topics = $this

            ->db

            ->get('video_topics');



        if ($topics->num_rows() > 0)



        {



            return $topics->num_rows();



        }



        return 0;



    }



    function total_videos($course_id=NULL)



    {

        if($course_id){

            $this

            ->db

            ->where('exam_id', $course_id);

        }
        $this

            ->db

            ->where('status', 'Active');
        $user_plan = $this

            ->db

            ->get('chapters');



        //var_dump($user_plan);

        



        //echo $this->db->last_query();exit;

        



        if ($user_plan->num_rows() > 0)



        {



            return $user_plan->num_rows();



        }



        return 0;



    }



    function user_qbank($user_id,$course_id=NULL)



    {



        if($course_id){

            $this

            ->db

            ->where('course_id', $course_id);

        }

        $this

            ->db

            ->where('user_id', $user_id);



        $this

            ->db

            ->select('count(DISTINCT(topic_id)) as user_qbank');



        $user_qbank = $this

            ->db

            ->get('quiz_answers');



        //var_dump($user_plan);

        



        //echo $this->db->last_query();exit;

        



        $user_qbank = $user_qbank->row_array();



        return $user_qbank['user_qbank'];



    }



    function total_qbank($course_id=NULL)



    {

        if($course_id){

            $this

            ->db

            ->where('course_id', $course_id);

        }

        $user_plan = $this

            ->db

            ->get('quiz_topics');



        if ($user_plan->num_rows() > 0)



        {



            return $user_plan->num_rows();



        }



        return 0;



    }



    function user_test($user_id,$course_id=NULL)



    {

        if($course_id){

            $this

            ->db

            ->where('course_id', $course_id);

        }

        $this

            ->db

            ->where('user_id', $user_id);



        $this

            ->db

            ->select('count(DISTINCT(quiz_id)) as user_qbank');



        $user_qbank = $this

            ->db

            ->get('test_series_answers');



        //var_dump($user_plan);

        



        //echo $this->db->last_query();exit;

        



        $user_qbank = $user_qbank->row_array();



        return $user_qbank['user_qbank'];



    }



    function total_test($course_id=NULL)



    {

        if($course_id){

            $this

            ->db

            ->where('course_id', $course_id);

        }

        $user_plan = $this

            ->db

            ->get('test_series_quiz');



        //var_dump($user_plan);

        



        //echo $this->db->last_query();exit;

        



        if ($user_plan->num_rows() > 0)



        {



            return $user_plan->num_rows();



        }



        return 0;



    }



    function user_notes($chapter_id)



    {



        $this->db->where('chapters_upload_notes.chapter_id', $chapter_id);
        $this->db->select('chapters_upload_notes.image');



        $users = $this

            ->db

            ->get('chapters_upload_notes');



        //echo $this->db->last_query();exit;

        



        if ($users->num_rows() > 0)



        {



            return $users->result();



        }



        return array();



    }



    function add_users_plans()



    {



        $this

            ->db

            ->select('chapters.notespdf');



        $users = $this

            ->db

            ->get('chapters');



        if ($users->num_rows() > 0)



        {



            return $users->result();



        }



        return array();



    }



    public function get_table_row($table_name = '', $where = '', $columns = '', $order_column = '', $order_by = 'asc', $limit = '')



    {



        if (!empty($columns))

        {



            $tbl_columns = implode(',', $columns);



            $this

                ->db

                ->select($tbl_columns);



        }



        if (!empty($where)) $this

            ->db

            ->where($where);



        if (!empty($order_column)) $this

            ->db

            ->order_by($order_column, $order_by);



        if (!empty($limit)) $this

            ->db

            ->limit($limit);



        $query = $this

            ->db

            ->get($table_name);



        if ($columns == 'test')

        {

            echo $this

                ->db

                ->last_query();

            exit;

        }



        //echo $this->db->last_query();

        



        return $query->row_array();



    }



    function quiz_topics($user_id, $course_id, $subject_id, $count)



    {



        if ($count > 0)



        {



            $this

                ->db

                ->limit(15, $count * 15);



        }



        else



        {



            $this

                ->db

                ->limit(15);



        }



        $this

            ->db

            ->order_by('qt.order', 'asc');



       // $this->db->having('questions_count >', 0);
        $this->db->where('qt.status','Active');


        $this

            ->db

            ->where('qt.course_id', $course_id);



        $this

            ->db

            ->where('qt.subject_id', $subject_id);



        $this

            ->db

            ->select('qt.id as qbank_chapter_id, qt.topic_name as qbank_chapter_name, qt.quiz_type,qt.title,qt.topic_image,qt.pdf_path,qt.status,qt.order');



        //$this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = qt.id) as questions_count");



       // $this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = '$course_id' and quiz_topic_reviews.subject_id = '$subject_id' and quiz_topic_reviews.topic_id = qt.id), 1), 0) as ratings");



        //$this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = qt.id) as answered");



        $topics = $this

            ->db

            ->get('quiz_topics qt');



       // echo $this->db->last_query();exit;

        



        if ($topics->num_rows() > 0)
        {



            $result=$topics->result_array();
            
            foreach($result as $key =>$chapter){
                $final_qbank_topics_count=0;
            $chapter_id=$chapter['qbank_chapter_id'];
            $this->db->select('id as qbank_topic_id,name as qbank_topic_name,banner_image as image,title,quiz_type,pdf_path,order');

            $this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = '$course_id' and quiz_topic_reviews.subject_id = '$subject_id' and quiz_topic_reviews.topic_id = '$chapter_id' and quiz_topic_reviews.qbank_topic_id=quiz_qbanktopics.id), 1), 0) as ratings");

            $this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$chapter_id' and qbank_topic_id=quiz_qbanktopics.id) as answered");

            $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = '$chapter_id' and quiz_questions.qbank_topic_id=quiz_qbanktopics.id) as questions_count");

            $this->db->where('course_id',$course_id);
            $this->db->where('subject_id',$subject_id);
            $this->db->where('chapter_id',$chapter_id);
            $this->db->order_by('order','asc');
            $this->db->having('questions_count >', 0);
            $this->db->from('quiz_qbanktopics');

            $sub_result=$this->db->get();
            //echo $this->db->last_query();exit;
            $qbank_topics=$sub_result->result_array();
            if(!empty($qbank_topics)){
            $result[$key]['topics_array']=$qbank_topics;
            $final_qbank_topics_count += count($qbank_topics);
            $result[$key]['qbank_topics_count'] = $final_qbank_topics_count;
                }else{
            $result[$key]['topics_array'] =array(); 
            unset($result[$key]);
                }
             
            }

            return $result;
        }



        return array();

}



    function quiz_topics_finished($user_id, $course_id, $subject_id, $count)



    {



        
        
        if ($count > 0)



        {



            $this

                ->db

                ->limit(15, $count * 15);



        }



        else



        {



            $this

                ->db

                ->limit(15);



        }



        $this

            ->db

            ->order_by('qt.id', 'desc');



     //$this->db->having('questions_count >', 0);
     //$this->db->having('answered >', 0);
     //$this->db->having('answered = questions_count');



        $this

            ->db

            ->where('qt.course_id', $course_id);



        $this

            ->db

            ->where('qt.subject_id', $subject_id);



        $this

            ->db

            ->select('qt.id as qbank_chapter_id, qt.topic_name as qbank_chapter_name, qt.quiz_type,qt.title');



       // $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = qt.id) as questions_count");



        //$this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = '$course_id' and quiz_topic_reviews.subject_id = '$subject_id' and quiz_topic_reviews.topic_id = qt.id), 1), 0) as ratings");



        //$this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = qt.id) as answered");



        $topics = $this

            ->db

            ->get('quiz_topics qt');



     //   echo $this->db->last_query();exit;

        



        if ($topics->num_rows() > 0)



        {



             //$topics=$topics->result_array();
             //$new_result=array();
              /*for ($i = 0;$i <= sizeof($topics);$i++)

            {

                $this->db->where('user_id', $user_id);
                $this->db->where('course_id', $course_id);
                 $this->db->where('subject_id', $subject_id);
                $this->db->where('topic_id', $topics[$i]['topic_id']);
                $this->db->select('count(id) as answered');
                $answed = $this->db->get('quiz_answers');
                $answed = $answed->row_array();

                //echo $this->db->last_query();

                // var_dump($bookmark_id['id']);die;

                $topics[$i]['answered'] = $answed['answered'];
                
                if($answed['answered'] != $topics[$i]['questions_count']){
                    unset($topics[$i]);
                }
                
                if($answed['answered'] == 0){
                    unset($topics[$i]);
                }
                
            }*/

            $result=$topics->result_array();
            foreach($result as $key =>$chapter){
                $final_qbank_topics_count=0;
            $chapter_id=$chapter['qbank_chapter_id'];
            $this->db->select('id as qbank_topic_id,name as qbank_topic_name,banner_image as image,title,pdf_path,quiz_type');

            $this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = '$course_id' and quiz_topic_reviews.subject_id = '$subject_id' and quiz_topic_reviews.topic_id = '$chapter_id' and quiz_topic_reviews.qbank_topic_id=quiz_qbanktopics.id), 1), 0) as ratings");

            $this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$chapter_id' and qbank_topic_id=quiz_qbanktopics.id) as answered");

            $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = '$chapter_id' and quiz_questions.qbank_topic_id=quiz_qbanktopics.id) as questions_count");

            $this->db->where('course_id',$course_id);
            $this->db->where('subject_id',$subject_id);
            $this->db->where('chapter_id',$chapter_id);
            $this->db->having('questions_count >', 0);
            $this->db->having('answered >', 0);
            $this->db->having('answered = questions_count');
            $this->db->from('quiz_qbanktopics');

            $sub_result=$this->db->get();
            //echo $this->db->last_query();exit;
            $qbank_topics=$sub_result->result_array();
                if(!empty($qbank_topics)){
                $result[$key]['topics_array']=$qbank_topics;
                $final_qbank_topics_count += count($qbank_topics);
                $result[$key]['qbank_topics_count'] = $final_qbank_topics_count;
                    }else{
                $result[$key]['topics_array'] =array(); 
                unset($result[$key]);
                    }
            }

            $new_result=array();
            foreach ($result as $k => $v) {
                $new_result[]=$v;
            }
            
            return $new_result;
        }
        
     return array();   



    }



    function quiz_topics_pasued($user_id, $course_id, $subject_id, $count)

    {

        if ($count > 0)



        {



            $this

                ->db

                ->limit(15, $count * 15);



        }



        else



        {



            $this

                ->db

                ->limit(15);



        }



        $this

            ->db

            ->order_by('qt.id', 'desc');



         //$this->db->having('questions_count >', 0);
        //$this->db->having('answered >', 0);
        //$this->db->having('answered < questions_count');



        $this

            ->db

            ->where('qt.course_id', $course_id);



        $this

            ->db

            ->where('qt.subject_id', $subject_id);



        $this

            ->db

            ->select('qt.id as qbank_chapter_id, qt.topic_name as qbank_chapter_name, qt.quiz_type,qt.title');



        //$this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = qt.id) as questions_count");



        //$this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = '$course_id' and quiz_topic_reviews.subject_id = '$subject_id' and quiz_topic_reviews.topic_id = qt.id), 1), 0) as ratings");



       // $this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = qt.id) as answered");



        $topics = $this

            ->db

            ->get('quiz_topics qt');



        //echo $this->db->last_query();exit;

        



        if ($topics->num_rows() > 0)



        {



            // $topics=$topics->result_array();
             
             
             
             /* for ($i = 0;$i <= sizeof($topics);$i++)

            {

                $this->db->where('user_id', $user_id);
                $this->db->where('course_id', $course_id);
                $this->db->where('subject_id', $subject_id);
                $this->db->where('topic_id', $topics[$i]['topic_id']);
                $this->db->select('count(id) as answered');
                $answed = $this->db->get('quiz_answers');
                $answed = $answed->row_array();

               // echo $this->db->last_query();
                // var_dump($bookmark_id['id']);die;

                $topics[$i]['answered'] = $answed['answered'];
                
                if($answed['answered'] == 0){
                    unset($topics[$i]);
                }
                
                if($answed['answered'] >= $topics[$i]['questions_count']){
                    unset($topics[$i]);
                }
                
            }*/

            $result=$topics->result_array();
            foreach($result as $key =>$chapter){
                $final_qbank_topics_count=0;
                $chapter_id=$chapter['qbank_chapter_id'];
                $this->db->select('id as qbank_topic_id,name as qbank_topic_name,banner_image as image,title,quiz_type,pdf_path');

                $this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = '$course_id' and quiz_topic_reviews.subject_id = '$subject_id' and quiz_topic_reviews.topic_id = '$chapter_id' and quiz_topic_reviews.qbank_topic_id=quiz_qbanktopics.id), 1), 0) as ratings");

                $this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$chapter_id' and qbank_topic_id=quiz_qbanktopics.id) as answered");

                $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = '$chapter_id' and quiz_questions.qbank_topic_id=quiz_qbanktopics.id) as questions_count");

                $this->db->where('course_id',$course_id);
                $this->db->where('subject_id',$subject_id);
                $this->db->where('chapter_id',$chapter_id);
                $this->db->having('questions_count >', 0);
                $this->db->having('answered >', 0);
                $this->db->having('answered < questions_count');
                $this->db->from('quiz_qbanktopics');

                $sub_result=$this->db->get();
                //echo $this->db->last_query();exit;
                $qbank_topics=$sub_result->result_array();
                        if(!empty($qbank_topics)){
                    $result[$key]['topics_array']=$qbank_topics;
                    $final_qbank_topics_count += count($qbank_topics);
                    $result[$key]['qbank_topics_count'] = $final_qbank_topics_count;
                        }else{
                    $result[$key]['topics_array'] =array(); 
                    unset($result[$key]);
                        }

                }

            $new_result=array();
            foreach ($result as $k => $v) {
                $new_result[]=$v;
            }
            
            return $new_result;
    
            
        }



        return array();

    }
    

    function quiz_topics_unattempt($user_id, $course_id, $subject_id, $count)
    {

        $new_result=array();
        if ($count > 0){

            $this->db->limit(15, $count * 15);
        } else{

            $this->db->limit(15);
        }



        $this->db->order_by('qt.id', 'desc');


/* --old start--*/
     //$this->db->having('questions_count >', 0);
     //$this->db->having('answered =', 0);

/* --old end--*/

       // $this->db->having('answered < questions_count');



        $this

            ->db

            ->where('qt.course_id', $course_id);



        $this

            ->db

            ->where('qt.subject_id', $subject_id);



        $this

            ->db

            ->select('qt.id as qbank_chapter_id, qt.topic_name as qbank_chapter_name, qt.quiz_type,qt.title');



       // $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = qt.id) as questions_count");



        //$this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = '$course_id' and quiz_topic_reviews.subject_id = '$subject_id' and quiz_topic_reviews.topic_id = qt.id), 1), 0) as ratings");



       // $this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = qt.id) as answered");



        $topics = $this

            ->db

            ->get('quiz_topics qt');



       // echo $this->db->last_query();exit;

        



        if ($topics->num_rows() > 0)



        {



             //$topics=$topics->result_array();
             
             /* for ($i = 0;$i <= sizeof($topics);$i++)

            {

                $this->db->where('user_id', $user_id);
                $this->db->where('course_id', $course_id);
                 $this->db->where('subject_id', $subject_id);
                $this->db->where('topic_id', $topics[$i]['topic_id']);
                $this->db->select('count(id) as answered');
                $answed = $this->db->get('quiz_answers');
                $answed = $answed->row_array();

                //echo $this->db->last_query();exit;
                // var_dump($bookmark_id['id']);die;

                $topics[$i]['answered'] = $answed['answered'];
                
                if($answed['answered'] != 0){
                    unset($topics[$i]);
                }
                
                
                
            }*/
            
             $result=$topics->result_array();
            foreach($result as $key =>$chapter){
                $final_qbank_topics_count=0;
            $chapter_id=$chapter['qbank_chapter_id'];
            $this->db->select('id as qbank_topic_id,name as qbank_topic_name,banner_image as image,title,pdf_path,quiz_type');

            $this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = '$course_id' and quiz_topic_reviews.subject_id = '$subject_id' and quiz_topic_reviews.topic_id = '$chapter_id' and quiz_topic_reviews.qbank_topic_id=quiz_qbanktopics.id), 1), 0) as ratings");

            $this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$chapter_id' and qbank_topic_id=quiz_qbanktopics.id) as answered");

            $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = '$chapter_id' and quiz_questions.qbank_topic_id=quiz_qbanktopics.id) as questions_count");

            $this->db->where('course_id',$course_id);
            $this->db->where('subject_id',$subject_id);
            $this->db->where('chapter_id',$chapter_id);
            $this->db->having('questions_count >', 0);
            $this->db->having('answered =', 0);

            $this->db->from('quiz_qbanktopics');

            $sub_result=$this->db->get();
            //echo $this->db->last_query();exit;
            $qbank_topics=$sub_result->result_array();
                if(!empty($qbank_topics)){
                $result[$key]['topics_array']=$qbank_topics;
                $final_qbank_topics_count += count($qbank_topics);
                $result[$key]['qbank_topics_count'] = $final_qbank_topics_count;
                    }else{
                $result[$key]['topics_array'] =array(); 
                unset($result[$key]);
                    }
            }
                
                foreach($result as $k=>$v){
                    $new_result[]=$v;
                }
                return $new_result;

        }
        
     return array();   
    }


    function quiz_topics_free($user_id, $course_id, $subject_id, $count)

    {



        if ($count > 0)



        {



            $this

                ->db

                ->limit(15, $count * 15);



        }



        else



        {



            $this

                ->db

                ->limit(15);



        }



        $this

            ->db

            ->order_by('qt.id', 'desc');



       // $this->db->having('questions_count >', 0);



        $this

            ->db

            ->where('qt.course_id', $course_id);



        $this->db->where('qt.subject_id', $subject_id);



        $this

            ->db

            ->where('qt.quiz_type', 'free');



        $this

            ->db

            ->select('qt.id as qbank_chapter_id, qt.topic_name as qbank_chapter_name, qt.quiz_type,qt.title');



        //$this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = qt.id) as questions_count");



       // $this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = '$course_id' and quiz_topic_reviews.subject_id = '$subject_id' and quiz_topic_reviews.topic_id = qt.id), 1), 0) as ratings");



       // $this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = qt.id) as answered");



        $topics = $this

            ->db

            ->get('quiz_topics qt');



        //echo $this->db->last_query();exit;

        



        if ($topics->num_rows() > 0)



        {



            //return $topics->result_array();
            $result=$topics->result_array();
            foreach($result as $key =>$chapter){
                $final_qbank_topics_count=0;
            $chapter_id=$chapter['qbank_chapter_id'];
            $this->db->select('id as qbank_topic_id,name as qbank_topic_name,banner_image as image,title,quiz_type,pdf_path');

            $this->db->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = '$course_id' and quiz_topic_reviews.subject_id = '$subject_id' and quiz_topic_reviews.topic_id = '$chapter_id' and quiz_topic_reviews.qbank_topic_id=quiz_qbanktopics.id), 1), 0) as ratings");

            $this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$chapter_id' and qbank_topic_id=quiz_qbanktopics.id) as answered");

            $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = '$chapter_id' and quiz_questions.qbank_topic_id=quiz_qbanktopics.id) as questions_count");

            $this->db->where('course_id',$course_id);
            $this->db->where('subject_id',$subject_id);
            $this->db->where('chapter_id',$chapter_id);
            $this->db->having('questions_count >', 0);
            $this->db->from('quiz_qbanktopics');

            $sub_result=$this->db->get();
            //echo $this->db->last_query();exit;
            $qbank_topics=$sub_result->result_array();
            if(!empty($qbank_topics)){
            $result[$key]['topics_array']=$qbank_topics;
            $final_qbank_topics_count += count($qbank_topics);
            $result[$key]['qbank_topics_count'] = $final_qbank_topics_count;
                }else{
            $result[$key]['topics_array'] =array(); 
            unset($result[$key]);
                }
            }

                return $result;

        }



        return array();



    }



    function quiz_topics_count($course_id, $subject_id)



    {



        $this

            ->db

            ->order_by('qt.id', 'desc');



        //$this->db->having('questions_count >', 0);



        $this

            ->db

            ->where('qt.course_id', $course_id);



        $this

            ->db

            ->where('qt.subject_id', $subject_id);



        $this

            ->db

            ->select('qt.id as qbank_chapter_id');



        //$this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = qt.id) as questions_count");



        $topics = $this

            ->db

            ->get('quiz_topics qt');



        //echo $this->db->last_query();exit;
            $qbank_topics_finalCount=0;
            $result=$topics->result_array();
                $i=1;
            foreach($result as $key =>$chapter){

            $chapter_id=$chapter['qbank_chapter_id'];
            $this->db->select('id as qbank_topic_id,name as qbank_topic_name,banner_image as image,title');

            
            $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = '$chapter_id' and quiz_questions.qbank_topic_id=quiz_qbanktopics.id) as questions_count");

            $this->db->where('course_id',$course_id);
            $this->db->where('subject_id',$subject_id);
            $this->db->where('chapter_id',$chapter_id);
            $this->db->having('questions_count >', 0);
            $this->db->from('quiz_qbanktopics');

            $sub_result=$this->db->get();
            //echo $this->db->last_query();exit;
            $qbank_topics=$sub_result->result_array();
            $qbank_topics_count=count($qbank_topics);
            $qbank_topics_finalCount += $qbank_topics_count;
                if(!empty($qbank_topics)){
                    $chapters_count= $i++;
                }else{
                    unset($result[$key]);
                }
            }
//echo $qbank_topics_finalCount;exit;

            $f_result=array(
                             'chapters_count'=> $chapters_count,
                             //'topics_count' => $qbank_topics_finalCount
                           );

        return $f_result;
    }



    function quiz_questions_count($course_id, $subject_id)



    {



        $this

            ->db

            ->order_by('qq.id', 'desc');



        $this

            ->db

            ->where('qq.course_id', $course_id);



        $this

            ->db

            ->where('qq.subject_id', $subject_id);

        $this->db->where('qq.topic_id !=', '0');
        $this->db->where('qq.qbank_topic_id !=', '0');

        $this

            ->db

            ->join('quiz_options qp', 'qp.question_id = qq.id');



        $this

            ->db

            ->select('qq.id');



        $this

            ->db

            ->distinct();



        $topics = $this

            ->db

            ->get('quiz_questions qq');



        //echo $this->db->last_query();exit;

        



        return $topics->num_rows();



    }



    function quiz_topic_details($user_id, $qbank_topic_id)



    {



        $this

            ->db

            ->order_by('qt.id', 'desc');



        //$this->db->having('questions_count >', 0);



        $this

            ->db

            ->where('qt.id', $qbank_topic_id);



        $this

            ->db

            ->select('qt.*');



        //$this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.qbank_topic_id = qt.id) as questions_count");



        $this

            ->db

            ->select("(SELECT count(qa.id) FROM `quiz_answers` `qa` WHERE `qa`.`qbank_topic_id` = '$qbank_topic_id' and `qa`.`user_id` = '$user_id') as answers_count");



        $this

            ->db

            ->select("(SELECT DATE_FORMAT(qa.created_on, '%d %b %Y') FROM `quiz_answers` `qa` WHERE `qa`.`qbank_topic_id` = '$qbank_topic_id' and `qa`.`user_id` = '$user_id' order by id desc limit 1) as topic_completed_date");



        $this

            ->db

            ->select("(SELECT count(qb.id) FROM `quiz_question_bookmarks` `qb` WHERE `qb`.`qbank_topic_id` = '$qbank_topic_id' and `qb`.`user_id` = '$user_id') as bookmarks_count");



        $this

            ->db

            ->select("IFNULL(round((SELECT AVG(ratings) FROM `quiz_topic_reviews` where quiz_topic_reviews.course_id = qt.course_id and quiz_topic_reviews.subject_id = qt.subject_id and quiz_topic_reviews.qbank_topic_id = qt.id), 1), 0) as ratings");



        $topics = $this

            ->db

            ->get('quiz_qbanktopics qt');



        //echo $this->db->last_query();exit;

        



        if ($topics->num_rows() > 0)



        {



            $result = $topics->row_array();



            $result['questions_yet_to_answer'] = $result['questions_count'] - $result['answers_count'];
            $course_id=$result['course_id'];
            $subject_id=$result['subject_id'];
            $chapter_id=$result['chapter_id'];$qbank_topic_id=$result['id'];
            $quiz_user_status=$this->getQuizUserStatus($user_id,$course_id,$subject_id,$chapter_id,$qbank_topic_id);
            if(empty($quiz_user_status)){
                $result['quiz_status']='unattempt';
            }else{
                $result['quiz_status']=$quiz_user_status['quiz_status'];
            }


            return $result;



        }



        return new ArrayObject();



    }



    function quiz_questions($user_id, $course_id, $subject_id, $topic_id, $qbank_topic_id, $count = 0)



    {



        // if($count > 0)

        



        //       {

        



        //           $this->db->limit(15, $count * 15);

        



        //       }

        



        //       else

        



        //       {

        



        //           $this->db->limit(15);

        



        //       }

        



        // $this

        //     ->db

        //     ->order_by('qq.id', 'desc');



        $this

            ->db

            ->where('qq.course_id', $course_id);



        $this

            ->db

            ->where('qq.subject_id', $subject_id);



        $this

            ->db

            ->where('qq.topic_id', $topic_id);

        $this->db->where('qq.qbank_topic_id', $qbank_topic_id);


        $this

            ->db

            ->join('quiz_options qp', 'qp.question_id = qq.id');



        $this

            ->db

            ->join('quiz_topics', 'quiz_topics.id = qq.topic_id');



        $this

            ->db

            ->select('qq.*, qq.id as question_id, quiz_topics.title as topic_title');



        $this

            ->db

            ->select("IF ((SELECT COUNT(id) FROM `quiz_reports` where user_id = '$user_id' and course_id = '$course_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$topic_id' and qbank_topic_id = '$qbank_topic_id' and quiz_reports.question_id = qq.id) >0, 'yes', 'no') as reported");

        $this->db->order_by('qq.question_order_no','asc');

        $this

            ->db

            ->distinct();



        $topics = $this

            ->db

            ->get('quiz_questions qq');



        // echo $this->db->last_query();exit;

        



        if ($topics->num_rows() > 0)



        {



            $res = $topics->result_array();



            foreach ($res as $key => $row)



            {



                // $res[$key]['percentage'] = $this->quiz_correct_answer_percentage($row['question_id'], $row['answer']);

                



                $percentage = $this->get_allusers_quiz_percentage($row['question_id']);



                // var_dump($percentage);die();

                



                $correct_percentage = ($percentage['correct_count'] / $percentage['total_count']) * 100;



                $option_a = ($percentage['option_a'] / $percentage['total_count']) * 100;



                $option_b = ($percentage['option_b'] / $percentage['total_count']) * 100;



                $option_c = ($percentage['option_c'] / $percentage['total_count']) * 100;



                $option_d = ($percentage['option_d'] / $percentage['total_count']) * 100;



                $correct_percentage = number_format($correct_percentage);

                if(is_numeric($correct_percentage)){
                    $correct_percentage = $correct_percentage;
                }else{
                    $correct_percentage = '0';
                }

                $option_a = number_format($option_a);
                $option_b = number_format($option_b);
                $option_c = number_format($option_c);
                $option_d = number_format($option_d);

                if(is_numeric($option_a)){
                    $option_a = $option_a;
                }else{
                    $option_a = '0';
                }

                if(is_numeric($option_b)){
                    $option_b = $option_a;
                }else{
                    $option_b = '0';
                }

                if(is_numeric($option_c)){
                    $option_c = $option_c;
                }else{
                    $option_c = '0';
                }

                if(is_numeric($option_d)){
                    $option_d = $option_d;
                }else{
                    $option_d = '0';
                }


                //$res[$key]['question_order_id'] = $key+1;
                $res[$key]['question_order_id'] = $row['question_order_no'];

                $bookMarkUserStatus=$this->findBookMarkStatus($user_id,$row['question_id']);

                $res[$key]['bookmark_status']=$bookMarkUserStatus;

                $res[$key]['percentage'] = array(


                    'correct_percentage' => $correct_percentage,

                );
                $res[$key]['correct_percentage'] =  $correct_percentage;

                



                $res[$key]['options'] = $this->quiz_question_options($row['question_id']);
                if (array_key_exists('0', $res[$key]['options'])){
                      $res[$key]['options'][0]['percentage']= $option_a; 
                    }
                if (array_key_exists('1', $res[$key]['options'])){
                      $res[$key]['options'][1]['percentage']= $option_b; 
                    }
                if (array_key_exists('2', $res[$key]['options'])){
                      $res[$key]['options'][2]['percentage']= $option_c; 
                    }
                if (array_key_exists('3', $res[$key]['options'])){
                      $res[$key]['options'][3]['percentage']= $option_d; 
                    }
                

            }



            return $res;



        }



        return array();
    }

    function quiz_questions_new($user_id, $course_id, $subject_id, $topic_id, $qbank_topic_id, $count = 0)
    {


        /*$this->db->where('course_id', $course_id);

        $this->db->where('subject_id', $subject_id);

        $this->db->where('topic_id', $topic_id);

        $this->db->where('qbank_topic_id', $qbank_topic_id);

        $this->db->where('status', 'Active');

        $this->db->select('`id` as question_id, `course_id`, `subject_id`, `topic_id`, `qbank_topic_id`, `math_library`, `question`, `question_image`, `answer`, `explanation`, `explanation_image`, `difficult_level`, `reference`, `tags`, `previous_appearance`, `question_unique_id`, `question_order_no`');

        $this->db->order_by('question_order_no','asc');

        

        $topics = $this->db->get('quiz_questions');



       

        $topics = $this->db->query("SELECT `id`,`id` as question_id, `course_id`, `subject_id`, `topic_id`, `qbank_topic_id`, `math_library`, `question`, `question_image`, `answer`, `explanation`, `explanation_image`, `difficult_level`, `reference`, `tags`, `previous_appearance`, `question_unique_id`, `question_order_no`,question_order_no as question_order_id,
        (select CASE WHEN count(1)<>'0' THEN 'true' ELSE 'false' END from quiz_question_bookmarks bm where qq.id=bm.question_id and user_id='".$user_id."') bookmark_status
        FROM `quiz_questions` qq 
        where status='Active'
        and course_id='".$course_id."'
        and subject_id='".$subject_id."'
        and topic_id='".$topic_id."'
        and qbank_topic_id='".$qbank_topic_id."'  
        ORDER BY `question_order_no` ASC");

        if ($topics->num_rows() > 0)



        {



            $res = $topics->result_array();



            foreach ($res as $key => $row){


                //$res[$key]['question_order_id'] = $key+1;
                //$res[$key]['question_order_id'] = $row['question_order_no'];

                $res[$key]['options'] = $this->quiz_question_options($row['question_id']);

                //$bookMarkUserStatus=$this->findBookMarkStatus($user_id,$row['question_id']);

                //$res[$key]['bookmark_status']=$bookMarkUserStatus;

        }



            return $res;



        }*/



$topics = $this->db->query("SELECT `id`,`id` as question_id, `course_id`, `subject_id`, `topic_id`, `qbank_topic_id`, `math_library`, `question`, `question_image`, `answer`, `explanation`, `explanation_image`, `difficult_level`, `reference`, `tags`, `previous_appearance`, `question_unique_id`, `question_order_no`,question_order_no as question_order_id,
(select CASE WHEN count(1)<>'0' THEN 'true' ELSE 'false' END from quiz_question_bookmarks bm where qq.id=bm.question_id and user_id='".$user_id."') bookmark_status,options_data as options
FROM `quiz_questions` qq 
where status='Active'
and course_id='".$course_id."' and subject_id='".$subject_id."' and topic_id='".$topic_id."' and qbank_topic_id='".$qbank_topic_id."' ORDER BY `question_order_no` asc");//->result_array();

    if ($topics->num_rows() > 0)
   {
    $res = $topics->result_array();
    foreach ($res as $key => $row){
        $res[$key]['options'] = json_decode($row['options'],TRUE);
        
        
        }
    }

    return $res;

}

    function insertQuizUserStatus($user_id, $course_id, $subject_id, $topic_id, $qbank_topic_id){
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('chapter_id', $topic_id);
        $this->db->where('topic_id', $qbank_topic_id);
        $this->db->delete('quiz_user_status');
        $insert=array(
                    'user_id'=>$user_id,
                    'course_id'=>$course_id,
                    'subject_id'=>$subject_id,
                    'chapter_id'=>$topic_id,
                    'topic_id'=>$qbank_topic_id,
                    'quiz_status'=>'pasued',
                    'created_on'=>date('Y-m-d H:i:s')
                    );
        $result=$this->db->insert('quiz_user_status',$insert);
        return $result;
    }
    function updateQuizUserStatus($user_id, $course_id, $subject_id, $topic_id, $qbank_topic_id){
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('chapter_id', $topic_id);
        $this->db->where('topic_id', $qbank_topic_id);
        $update=array(
                    'quiz_status'=>'finished',
                    );
        $result=$this->db->update('quiz_user_status',$update);
        return $result;
    }

    function submitQbankAnswers($post){
        $user_id=$post['user_id'];
        $course_id=$post['course_id'];
        $subject_id=$post['subject_id'];
        $topic_id=$post['topic_id'];
        $qbank_topic_id=$post['qbank_topic_id'];
        $question_order_id=$post['question_order_id'];
        $question_id=$post['question_id'];
        $option_id=$post['option_id'];
        $answer=$post['answer'];
        $correct_answer=$post['correct_answer'];
        $answer_status=$post['answer_status'];
        $created_on= date('Y-m-d H:i:s');
        $query="CALL submitQbankAnswers('$user_id','$course_id','$subject_id','$topic_id','$qbank_topic_id','$question_order_id','$question_id','$option_id','$answer','$correct_answer','$answer_status','$created_on')";
       // echo $query;exit;
        $result=$this->db->query($query);
        return $result;
    }


    function findBookMarkStatus($user_id,$question_id){
        $query="SELECT * FROM quiz_question_bookmarks WHERE user_id='".$user_id."' AND question_id='".$question_id."'";
        $result=$this->db->query($query)->row_array();
        if(!empty($result)){
            $status= "true";
        }else{
            $status= "false";
        }
        return $status;
    }


    function quiz_questions_unfinished($user_id, $course_id, $subject_id, $topic_id, $qbank_topic_id,$count)

    {

        $this

            ->db

            ->where('qq.course_id', $course_id);



        $this

            ->db

            ->where('qq.subject_id', $subject_id);



        $this

            ->db

            ->where('qq.topic_id', $topic_id);

        $this->db->where('qq.qbank_topic_id', $qbank_topic_id);

        $this

            ->db

            ->join('quiz_options qp', 'qp.question_id = qq.id');



        $this

            ->db

            ->join('quiz_topics', 'quiz_topics.id = qq.topic_id');



        $this

            ->db

            ->select('qq.*, qq.id as question_id, quiz_topics.title as topic_title');



        $this

            ->db

            ->select("IF ((SELECT COUNT(id) FROM `quiz_reports` where user_id = '$user_id' and course_id = '$course_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$topic_id' and qbank_topic_id='$qbank_topic_id' and quiz_reports.question_id = qq.id) >0, 'yes', 'no') as reported");



        $this

            ->db

            ->select("(SELECT answer FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$topic_id' and qbank_topic_id='$qbank_topic_id' and quiz_answers.question_id = qq.id) as user_answer");

        $this->db->select("(SELECT question_order_id FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$topic_id' and qbank_topic_id='$qbank_topic_id' and quiz_answers.question_id = qq.id) as question_order_id");

        



        $this

            ->db

            ->distinct();



        $topics = $this

            ->db

            ->get('quiz_questions qq');



        // echo $this->db->last_query();exit;

        



        if ($topics->num_rows() > 0)



        {



            $res = $topics->result_array();



            foreach ($res as $key => $row)



            {



                // $res[$key]['percentage'] = $this->quiz_correct_answer_percentage($row['question_id'], $row['answer']);

                

                $bookmark_status=$this->check_bookmarkStatus($row['course_id'],$row['subject_id'],$row['topic_id'],$row['qbank_topic_id'],$row['id']);

                $res[$key]['bookmark_status']=$bookmark_status;

                $percentage = $this->get_allusers_quiz_percentage($row['question_id']);



                // var_dump($percentage);die();

                



                $correct_percentage = ($percentage['correct_count'] / $percentage['total_count']) * 100;



                $option_a = ($percentage['option_a'] / $percentage['total_count']) * 100;



                $option_b = ($percentage['option_b'] / $percentage['total_count']) * 100;



                $option_c = ($percentage['option_c'] / $percentage['total_count']) * 100;



                $option_d = ($percentage['option_d'] / $percentage['total_count']) * 100;



                $correct_percentage = number_format($correct_percentage);



                $correct_percentage = is_numeric($correct_percentage) ? $correct_percentage : 0;



                $option_a = number_format($option_a);



                $option_a = is_numeric($option_a) ? $option_a : 0;



                $option_b = number_format($option_b);



                $option_b = is_numeric($option_b) ? $option_b : 0;



                $option_c = number_format($option_c);



                $option_c = is_numeric($option_c) ? $option_c : 0;



                $option_d = number_format($option_d);



                $option_d = is_numeric($option_d) ? $option_d : 0;



                $res[$key]['percentage'] = array(



                    'correct_percentage' => $correct_percentage,



                    'option_a' => $option_a,



                    'option_b' => $option_b,



                    'option_c' => $option_c,



                    'option_d' => $option_d



                );



                $res[$key]['options'] = $this->quiz_question_options($row['question_id']);



            }



            return $res;



        }



        return array();

    }


public function check_bookmarkStatus($course_id,$subject_id,$topic_id,$qbank_topic_id,$question_id){

        $this->db->select('id');
        $this->db->where('course_id',$course_id);
        $this->db->where('subject_id',$subject_id);
        $this->db->where('topic_id',$topic_id);
        $this->db->where('qbank_topic_id',$qbank_topic_id);
        $this->db->where('question_id',$question_id);
        $this->db->from('quiz_question_bookmarks');
        $query=$this->db->get();
        $result=$query->row_array();
        if(!empty($result)){
            return 1;
        }else{
            return 0;
        }
    }


    function quiz_question_options($question_id)



    {



        $this->db->order_by('qo.id', 'asc');



        $this

            ->db

            ->where('qo.question_id', $question_id);



        $this

            ->db

            ->select('qo.*');



        $options = $this

            ->db

            ->get('quiz_options qo');



        //echo $this->db->last_query();exit;

        



        if ($options->num_rows() > 0)



        {



            return $options->result_array();



        }



        return array();



    }



    function quiz_correct_answer_percentage($question_id, $answer)



    {



        $this

            ->db

            ->order_by('qa.id', 'asc');



        $this

            ->db

            ->where('qa.question_id', $question_id);



        $this

            ->db

            ->select('qa.*');



        $answer = $this

            ->db

            ->get('quiz_answers qa');



        //echo $this->db->last_query();exit;

        



        $question_answered_count = $answer->num_rows();



        if ($question_answered_count <= 0)



        {



            return "no one answered";



        }



        $this

            ->db

            ->order_by('qa.id', 'asc');



        $this

            ->db

            ->where('qa.answer_status', 'correct');



        $this

            ->db

            ->where('qa.question_id', $question_id);



        $this

            ->db

            ->select('qa.*');



        $answer = $this

            ->db

            ->get('quiz_answers qa');



        //echo $this->db->last_query();exit;

        



        $correct_answered_count = $answer->num_rows();



        return $correct_answered_count / $question_answered_count * 100;



    }



    function bookmarked_questions($user_id, $course_id, $subject_id, $topic_id,$qbank_topic_id)



    {



        $this

            ->db

            ->where('quiz_question_bookmarks.user_id', $user_id);



        $this

            ->db

            ->where('quiz_question_bookmarks.course_id', $course_id);



        $this

            ->db

            ->where('quiz_question_bookmarks.subject_id', $subject_id);



        $this

            ->db

            ->where('quiz_question_bookmarks.topic_id', $topic_id);

        $this->db->where('quiz_question_bookmarks.qbank_topic_id', $qbank_topic_id);


        $this

            ->db

            ->join('quiz_questions', 'quiz_questions.id = qa.question_id');



        $this

            ->db

            ->join('quiz_question_bookmarks', 'quiz_question_bookmarks.question_id = qa.question_id');



        $this

            ->db

            ->select('quiz_questions.question');



        $this

            ->db

            ->select('quiz_question_bookmarks.id as bookmark_id,quiz_question_bookmarks.question_order_id');



        $this

            ->db

            ->select('quiz_questions.id');



        $this

            ->db

            ->distinct();

        $this->db->order_by('quiz_question_bookmarks.question_order_id','asc');
        $questions = $this

            ->db

            ->get('quiz_answers qa');
//echo '<pre>';print_r($this->db->last_query());exit;
        if ($questions->num_rows() > 0)



        {



            $questions = $questions->result_array();



            return $questions;



        }



        return array();



    }



    function answered_quiz_questions($user_id, $course_id, $subject_id, $topic_id)



    {



        $this

            ->db

            ->order_by('qq.id', 'desc');



        $this

            ->db

            ->where('qq.course_id', $course_id);



        $this

            ->db

            ->where('qq.subject_id', $subject_id);



        $this

            ->db

            ->where('qq.topic_id', $topic_id);



        $this

            ->db

            ->join('quiz_options qp', 'qp.question_id = qq.id');



        $this

            ->db

            ->join('quiz_topics', 'quiz_topics.id = qq.topic_id');



        $this

            ->db

            ->select('qq.*, qq.id as question_id, quiz_topics.title as topic_title');



        $this

            ->db

            ->select("IF ((SELECT COUNT(id) FROM `quiz_reports` where user_id = '$user_id' and course_id = '$course_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$topic_id' and quiz_reports.question_id = qq.id) >0, 'yes', 'no') as reported");



        $this

            ->db

            ->select("(SELECT answer FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$topic_id' and quiz_answers.question_id = qq.id) as answered");



        $this

            ->db

            ->distinct();



        $topics = $this

            ->db

            ->get('quiz_questions qq');



        //echo $this->db->last_query();exit;

        



        if ($topics->num_rows() > 0)



        {



            $res = $topics->result_array();



            foreach ($res as $key => $row)



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



        $this

            ->db

            ->order_by('id', 'desc');



        $this

            ->db

            ->where('course_id', $course_id);



        $this

            ->db

            ->where('category_id', $category_id);



        $this

            ->db

            ->where('quiz_id', $quiz_id);



        $this

            ->db

            ->where('user_id', $user_id);



        $topics = $this

            ->db

            ->get('test_series_answers_json');



        $res = $topics->row_array();

        //echo $this->db->last_query();exit;

            return $res;


    }



    function quiz_data_analysis_piechart($user_id, $course_id, $subject_id, $topic_id)

    {



        $this

            ->db

            ->order_by('id', 'desc');



        $this

            ->db

            ->where('course_id', $course_id);



        $this

            ->db

            ->where('subject_id', $subject_id);



        $this

            ->db

            ->where('topic_id', $topic_id);



        $this

            ->db

            ->where('user_id', $user_id);



        $this

            ->db

            ->distinct();



        $answers = $this

            ->db

            ->get('quiz_answers');



        if ($answers->num_rows() > 0)



        {



            $res = $answers->result_array();



            return $res;



        }



        return array();



    }



    function data_analysis_allUsers($user_id, $course_id, $category_id, $quiz_id)

    {



        $this

            ->db

            ->group_by(array(

            "answer_status",

            "user_id"

        ));



        $this

            ->db

            ->distinct();



        $this

            ->db

            ->select('user_id,COUNT(*) as count,answer_status');



        $marks = $this

            ->db

            ->get('test_series_answers');



        if ($marks->num_rows() > 0)



        {



            $res = $marks->result_array();



            return $res;



        }



        return array();



    }

function getBookMarkCount($quiz_id, $user_id){
    $query="select count(id) as bookmarkcount from test_series_bookmarks where user_id='".$user_id."' and quiz_id='".$quiz_id."' ";
    //echo $query;exit;
    $result=$this->db->query($query)->row_array();
    return $result;
}

    function getMarks($quiz_id, $user_id)

    {



        $this

            ->db

            ->order_by('tsm.id', 'desc');



        $this

            ->db

            ->where('tsm.quiz_id', $quiz_id);


        $this->db->join('users u','u.id=tsm.user_id');
        $this->db->distinct();
        $this->db->select('tsm.*,u.name,u.image');
        $this->db->from('test_series_marks tsm');

        $marks = $this->db->get();

//echo $this->db->last_query();exit;

        if ($marks->num_rows() > 0)



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



    function get_all_review_questions($user_id, $course_id, $category_id, $quiz_id)

    {



        $this

            ->db

            ->where('tsa.user_id', $user_id);



        $this

            ->db

            ->where('tsa.course_id', $course_id);



        $this

            ->db

            ->where('tsa.category_id', $category_id);



        $this

            ->db

            ->where('tsa.quiz_id', $quiz_id);



        $this

            ->db

            ->join('test_series_questions', 'test_series_questions.id = tsa.question_id');



        // $this->db->join('test_series_bookmarks', 'test_series_bookmarks.question_id = tsa.question_id','left outer');

        



        $this

            ->db

            ->select('test_series_questions.question,test_series_questions.math_library');



        // $this->db->select('test_series_bookmarks.id as bookmark_id');

        



        $this

            ->db

            ->select('test_series_questions.id,tsa.question_order_id');

        $this->db->order_by('tsa.question_order_id','asc');

        $this

            ->db

            ->distinct();



        $questions = $this

            ->db

            ->get('test_series_answers tsa');



        if ($questions->num_rows() > 0)



        {



            $questions = $questions->result_array();



            for ($i = 0;$i < sizeof($questions);$i++)

            {



                $this

                    ->db

                    ->distinct();



                $this

                    ->db

                    ->where('user_id', $user_id);



                $this

                    ->db

                    ->where('question_id', $questions[$i]['id']);



                $this

                    ->db

                    ->select('id');



                $bookmark_id = $this

                    ->db

                    ->get('test_series_bookmarks');



                $bookmark_id = $bookmark_id->row_array();



                // var_dump($bookmark_id['id']);die;

                $questions[$i]['bookmark_id'] = $bookmark_id['id'];



            }



            $res = $questions;



            return $res;



        }



        return array();



    }

    function fetchAllReviewCustomExamQuizQuestions($user_id,$exam_id){

        $query="select q.question,q.math_library,q.question_unique_id,cmer.answer_status,cmer.question_order_id,cmer.question_id as id,(select id from custom_module_qbank_bookmarks where user_id='".$user_id."' and exam_id='".$exam_id."' and question_id=q.question_unique_id) bookmark_id from custom_module_exam_result cmer inner join quiz_questions q on q.id=cmer.question_id where cmer.exam_id='".$exam_id."' and cmer.user_id='".$user_id."' ";
        //echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;
    }

    function fetch_all_review_quiz_questions($user_id, $course_id, $subject_id, $topic_id,$qbank_topic_id){

        /*$this->db->where('qa.user_id', $user_id);
        $this->db->where('qa.course_id', $course_id);
        $this->db->where('qa.subject_id', $subject_id);
        $this->db->where('qa.topic_id', $topic_id);
        $this->db->where('qa.qbank_topic_id', $qbank_topic_id);
        $this->db->join('quiz_questions', 'quiz_questions.id = qa.question_id');
        $this->db->select('quiz_questions.question,quiz_questions.math_library,quiz_questions.question_order_no as question_order_id,qa.answer_status,quiz_questions.question_unique_id');
        $this->db->select('quiz_questions.id');
        $questions = $this->db->get('quiz_answers qa');*/

        // var_dump($this->db->last_query());die;
        // var_dump($questions->result_array());die;

        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('topic_id', $topic_id);
        $this->db->where('qbank_topic_id', $qbank_topic_id);
        $this->db->select('*');
        $query=$this->db->get('quiz_answers_json');
        $questions1 = $query->row_array();
        $questions=json_decode($questions1['submit_json'],TRUE);

        //echo '<pre>';print_r($questions);exit;
        $new_questions=array();
        if (!empty($questions)){
            foreach($questions as $key=>$value)
            {

            $question_data=$this->db->query("SELECT question,math_library,question_unique_id FROM quiz_questions WHERE id='".$value['question_id']."'")->row_array();
            //echo $this->db->last_query();exit;
            $this->db->where('user_id', $user_id);
            $this->db->where('question_id', $question_data['question_unique_id']);
            $this->db->select('id');
            $bookmark_id = $this->db->get('quiz_question_bookmarks');
            $bookmark_id = $bookmark_id->row_array();
            // var_dump($bookmark_id['id']);die;
            //echo $this->db->last_query();exit;

            $new_questions[]=array(
                                'id'=>$value['question_id'],
                                'question'=>$question_data['question'],
                                'math_library'=>$question_data['math_library'],
                                'question_unique_id'=>$question_data['question_unique_id'],
                                'question_order_id'=>$value['question_order_id'],
                                'answer_status'=>$value['answer_status'],
                                'bookmark_id'=>$bookmark_id['id']
                                  );
           // $questions[$i]['bookmark_id'] = $bookmark_id['id'];

            }



            return $new_questions;



        }



        return array();



    }



    function get_status_review_questions($user_id, $course_id, $category_id, $quiz_id, $status)

    {



        $this

            ->db

            ->where('tsa.user_id', $user_id);



        $this

            ->db

            ->where('tsa.course_id', $course_id);



        $this

            ->db

            ->where('tsa.category_id', $category_id);



        $this

            ->db

            ->where('tsa.quiz_id', $quiz_id);



        $this

            ->db

            ->where('tsa.answer_status', $status);



        $this

            ->db

            ->join('test_series_questions', 'test_series_questions.id = tsa.question_id');



        // $this->db->join('test_series_bookmarks', 'test_series_bookmarks.question_id = tsa.question_id','left outer');

        



        $this

            ->db

            ->select('test_series_questions.question,tsa.question_order_id');



        // $this->db->select('test_series_bookmarks.id as bookmark_id');

        



        $this

            ->db

            ->select('test_series_questions.id');


     
        $this

            ->db

            ->distinct();



   $this->db->order_by('tsa.question_order_id','asc');
        $questions = $this

            ->db

            ->get('test_series_answers tsa');



        if ($questions->num_rows() > 0)



        {



            $questions = $questions->result_array();



            for ($i = 0;$i < sizeof($questions);$i++)

            {



                $this

                    ->db

                    ->distinct();



                $this

                    ->db

                    ->where('user_id', $user_id);



                $this

                    ->db

                    ->where('question_id', $questions[$i]['id']);



                $this

                    ->db

                    ->select('id');



                $bookmark_id = $this

                    ->db

                    ->get('test_series_bookmarks');



                $bookmark_id = $bookmark_id->row_array();



                // var_dump($bookmark_id['id']);die;

                $questions[$i]['bookmark_id'] = $bookmark_id['id'];



            }



            $res = $questions;



            return $res;



        }



        return array();



    }



    function fetch_status_review_quiz_questions($user_id, $course_id, $subject_id, $topic_id,$qbank_topic_id, $status)

    {



        $this

            ->db

            ->where('qa.user_id', $user_id);



        $this

            ->db

            ->where('qa.course_id', $course_id);



        $this

            ->db

            ->where('qa.subject_id', $subject_id);



        $this

            ->db

            ->where('qa.topic_id', $topic_id);
        $this->db->where('qa.qbank_topic_id', $qbank_topic_id);


        $this

            ->db

            ->where('qa.answer_status', $status);



        $this

            ->db

            ->join('quiz_questions', 'quiz_questions.id = qa.question_id');



        // $this->db->join('quiz_question_bookmarks', 'quiz_question_bookmarks.question_id = qa.question_id','left outer');

        



        $this

            ->db

            ->select('quiz_questions.question,qa.question_order_id');



        $this

            ->db

            ->select('quiz_questions.id');



        // $this->db->select('quiz_question_bookmarks.id as bookmark_id');

        $this->db->order_by('qa.question_order_id','asc');



        $this

            ->db

            ->distinct();



        $questions = $this

            ->db

            ->get('quiz_answers qa');



        if ($questions->num_rows() > 0)



        {



            $questions = $questions->result_array();



            for ($i = 0;$i < sizeof($questions);$i++)

            {



                $this

                    ->db

                    ->distinct();



                $this

                    ->db

                    ->where('user_id', $user_id);



                $this

                    ->db

                    ->where('question_id', $questions[$i]['id']);



                $this

                    ->db

                    ->select('id');



                $bookmark_id = $this

                    ->db

                    ->get('quiz_question_bookmarks');



                $bookmark_id = $bookmark_id->row_array();



                // var_dump($bookmark_id['id']);die;

                $questions[$i]['bookmark_id'] = $bookmark_id['id'];



            }



            $res = $questions;



            return $res;



        }



        return array();



    }

    function get_review_question_analysis1($user_id, $question_id, $quiz_id){

        $this->db->select('`id`, `question_dynamic_id`, `course_id`, `category_id`, `quiz_id`, `math_library`, `question`, `question_image`, `answer`, `explanation`, `explanation_image`, `reference`, `positive_marks`, `negative_marks`, `que_number`, `question_type`,`subject_id`,`options`');
        $this->db->where('id',$question_id);
        $this->db->from('test_series_questions');
        $question=$this->db->get()->result_array();
        

        $query="SELECT submit_json from test_series_answers_json WHERE user_id='".$user_id."' and quiz_id='".$quiz_id."' ";
        $submit_data=$this->db->query($query)->row_array();

        $decode_submit_data=json_decode($submit_data['submit_json'],TRUE);
       //echo '<pre>';print_r($decode_submit_data);exit;
        $question[0]['attempted_answer']=$decode_submit_data[$question_id]['answer'];
        $question[0]['answer_status']=$decode_submit_data[$question_id]['answer_status'];
        $question[0]['correct_answer']=$decode_submit_data[$question_id]['correct_answer'];
       
        $this->db->where('user_id', $user_id);
        $this->db->where('question_id', $question_id);
        $this->db->select('id');
        $bookmark_id = $this->db->get('test_series_bookmarks');
        $bookmark_id = $bookmark_id->row_array();
        $question[0]['bookmark_id'] = $bookmark_id['id'];
         //echo '<pre>';print_r($question);exit;
        
        $this->db->where('question_id', $question_id);
        $options = $this->db->get('test_series_options');
        $options = $options->result_array();
        //$question['options']=$options;
        //return $question;
        return array(



            'questions' => $question,



            'options' => $options,



            'reports' => array()



        );
    }


    function get_review_question_analysis($user_id, $question_id)

    {



        $this

            ->db

            ->where('test_series_answers.user_id', $user_id);



        $this

            ->db

            ->where('test_series_answers.question_id', $question_id);



        $this

            ->db

            ->join('test_series_answers', 'test_series_answers.question_id = tsq.id');



        // $this->db->join('test_series_bookmarks', 'test_series_bookmarks.question_id = tsq.id','left outer');

        



        $this

            ->db

            ->select('tsq.*,test_series_answers.answer as attempted_answer, test_series_answers.answer_status,test_series_answers.correct_answer');



        // $this->db->select('test_series_bookmarks.id as bookmark_id');

        



        $this

            ->db

            ->distinct();


  $this->db->order_by('que_number', 'asc');

        $questions = $this

            ->db

            ->get('test_series_questions tsq');



        // var_dump($this->db->last_query());die();

        $questions = $questions->result_array();



        // var_dump($questions);die;

        



        for ($i = 0;$i < sizeof($questions);$i++)

        {



            $this

                ->db

                ->distinct();



            $this

                ->db

                ->where('user_id', $user_id);



            $this

                ->db

                ->where('question_id', $questions[$i]['id']);



            $this

                ->db

                ->select('id');



            $bookmark_id = $this

                ->db

                ->get('test_series_bookmarks');



            $bookmark_id = $bookmark_id->row_array();



            // var_dump($bookmark_id['id']);die;

            $questions[$i]['bookmark_id'] = $bookmark_id['id'];



        }



        // $res = $questions;

        



        $this

            ->db

            ->where('question_id', $question_id);



        $this

            ->db

            ->distinct();



        $options = $this

            ->db

            ->get('test_series_options');



        $options = $options->result_array();



        $this

            ->db

            ->where('user_id', $user_id);



        $this

            ->db

            ->where('question_id', $question_id);



        $this

            ->db

            ->distinct();



        $reports = $this

            ->db

            ->get('test_series_reports');



        $reports = $reports->result_array();



        return array(



            'questions' => $questions,



            'options' => $options,



            'reports' => $reports



        );



    }

   function get_review_quiz_question_analysis1($user_id, $question_id,$qbank_topic_id)
    {

        $this->db->select('*');
        $this->db->where('id',$question_id);
        $this->db->from('quiz_questions');
        $question=$this->db->get()->result_array();
        

        $query="SELECT submit_json from quiz_answers_json WHERE user_id='".$user_id."' and qbank_topic_id='".$qbank_topic_id."' ";
        $submit_data=$this->db->query($query)->row_array();

        $decode_submit_data=json_decode($submit_data['submit_json'],TRUE);
      // echo '<pre>';print_r($decode_submit_data);exit;
        $question[0]['attempted_answer']=$decode_submit_data[$question_id]['answer'];
        $question[0]['answer_status']=$decode_submit_data[$question_id]['answer_status'];
        $question[0]['correct_answer']=$decode_submit_data[$question_id]['correct_answer'];
       
        $this->db->where('user_id', $user_id);
        $this->db->where('question_id', $question[0]['question_unique_id']);
        $this->db->select('id');
        $bookmark_id = $this->db->get('quiz_question_bookmarks');
        $bookmark_id = $bookmark_id->row_array();
        $question[0]['bookmark_id'] = $bookmark_id['id'];
        //echo '<pre>';print_r($question);exit;
        
        $this->db->where('question_id', $question_id);
        $options = $this->db->get('quiz_options');
        $options = $options->result_array();
        //$question['options']=$options;
        //return $question;
        return array(



            'questions' => $question,



            'options' => $options,



            'reports' => array()



        );


    }

    function get_review_quiz_question_analysis($user_id, $question_id)

    {



        $this->db->where('quiz_answers.user_id', $user_id);
        $this->db->where('quiz_answers.question_id', $question_id);
        $this->db->join('quiz_answers', 'quiz_answers.question_id = qq.id', 'left outer');
        // $this->db->join('quiz_question_bookmarks', 'quiz_question_bookmarks.question_id = qq.id','left outer');
        $this->db->select('qq.*,quiz_answers.answer as attempted_answer,quiz_answers.answer_status, quiz_answers.correct_answer');
        // $this->db->select('quiz_question_bookmarks.id as bookmark_id');
        $this->db->distinct();
        $questions = $this->db->get('quiz_questions qq');
        $questions = $questions->result_array();



        for ($i = 0;$i < sizeof($questions);$i++)

        {



            $this->db

                ->distinct();



            $this

                ->db

                ->where('user_id', $user_id);



            $this

                ->db

                ->where('question_id', $questions[$i]['question_unique_id']);



            $this

                ->db

                ->select('id');



            $bookmark_id = $this

                ->db

                ->get('quiz_question_bookmarks');



            $bookmark_id = $bookmark_id->row_array();



            // var_dump($bookmark_id['id']);die;

            $questions[$i]['bookmark_id'] = $bookmark_id['id'];



        }



        $this

            ->db

            ->where('question_id', $question_id);



        $options = $this

            ->db

            ->get('quiz_options');



        $options = $options->result_array();



        $this

            ->db

            ->where('user_id', $user_id);



        $this

            ->db

            ->where('question_id', $question_id);



        $reports = $this

            ->db

            ->get('quiz_reports');



        $reports = $reports->result_array();



        return array(



            'questions' => $questions,



            'options' => $options,



            'reports' => $reports



        );



    }



    function get_allusers_percentage($question_id)

    {



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

            ->select('(select COUNT(IF(answer="A",1,null)) from test_series_answers where question_id=' . $question_id . ' ) as option_a');



        $this

            ->db

            ->select('(select COUNT(IF(answer="B",1,null)) from test_series_answers where question_id=' . $question_id . ' ) as option_b');



        $this

            ->db

            ->select('(select COUNT(IF(answer="C",1,null)) from test_series_answers where question_id=' . $question_id . ' ) as option_c');



        $this

            ->db

            ->select('(select COUNT(IF(answer="D",1,null)) from test_series_answers where question_id=' . $question_id . ' ) as option_d');



        $result = $this

            ->db

            ->get('test_series_answers');



        if ($result->num_rows() > 0)



        {



            $res = $result->result_array();



            return $res;



        }



        return array();



    }



    function get_allusers_quiz_percentage($question_id)

    {



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

            ->select('(select COUNT(IF(answer="A",1,null)) from quiz_answers where question_id=' . $question_id . ' ) as option_a');



        $this

            ->db

            ->select('(select COUNT(IF(answer="B",1,null)) from quiz_answers where question_id=' . $question_id . ' ) as option_b');



        $this

            ->db

            ->select('(select COUNT(IF(answer="C",1,null)) from quiz_answers where question_id=' . $question_id . ' ) as option_c');



        $this

            ->db

            ->select('(select COUNT(IF(answer="D",1,null)) from quiz_answers where question_id=' . $question_id . ' ) as option_d');



        $result = $this

            ->db

            ->get('quiz_answers');



        // var_dump($this->db->last_query());die();

        



        if ($result->num_rows() > 0)



        {



            $res = $result->row_array();



            return $res;



        }



        return array();



    }

   function get_test_series_categories($user_id, $course_id){

        $query="select * from test_series_categories where course_id='".$course_id."' order by id desc";
        $test_series_categories=$this->db->query($query)->result_array();

        $new_response=array();
       //$new_response['all_tests']=$this->test_series_quiz_dates($user_id,$course_id,'all');
        foreach($test_series_categories as $key=>$value){
            $category_id=$value['id'];
            $result=$this->test_series_quiz_dates($user_id,$course_id, $category_id);
            $new_response[$key]=$value;
            $new_response[$key]['test_series_quizs']=$result;
         }
         
        /*$all_tests=$this->test_series_quiz_dates($user_id,$course_id,'all');
        $all_test_response=array(
                             'id'=>'31',
                            'title'=> 'All',
                            'created_on'=> '2020-06-17 11:40:39',
                            'modified_on'=> '2020-06-26 12:43:22',
                            'test_series_quizs'=>$all_tests,
                                );

        $final_response=array($new_response,$all_test_response);
        return (object)$final_response;*/
        return $new_response;


    }

function test_series_quiz_dates($user_id, $course_id, $category_id)



    {



        $this

            ->db

            ->group_by('exam_time');



        //$this->db->order_by('tsq.exam_time', 'asc');



        //$this->db->having('questions_count >', 0);

        



        $this

            ->db

            ->where('tsq.course_id', $course_id);



        if ($category_id != "all")



        {



            $this

                ->db

                ->where('tsq.category_id', $category_id);



        }



        $this

            ->db

            ->join('test_series_questions', 'test_series_questions.quiz_id = tsq.id');


/*
        $this

            ->db

            ->join('test_series_options', 'test_series_options.question_id = test_series_questions.id');
*/


        $this

            ->db

            ->distinct();



        $this

            ->db

            ->select("DATE_FORMAT(tsq.exam_time, '%M %Y') as month_year, DATE_FORMAT(tsq.exam_time, '%Y-%m') as digit_year_month");



        //$this->db->select("(select count(DISTINCT(quiz_questions.id)) from test_series_questions quiz_questions join test_series_options quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.quiz_id = tsq.id) as questions_count");

        



        $quiz = $this

            ->db

            ->get('test_series_quiz tsq');



        //echo $this->db->last_query();exit;

        



        if ($quiz->num_rows() > 0)



        {



            $res = $quiz->result_array();



            foreach ($res as $key => $row)



            {



                $res[$key]['quizs'] = $this->test_series_quizs($user_id, $course_id, $category_id, $row['digit_year_month']);
                //$res[$key]['all_quizs'] = $this->test_series_quizs($user_id, $course_id,'all', $row['digit_year_month']);


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

        

      


        $this

            ->db

            ->order_by('tsq.order', 'asc');



        $this

            ->db

            ->having('questions_count >', 0);



        $this

            ->db

            ->where('DATE_FORMAT(tsq.exam_time, "%Y-%m") =', $year_month);



        $this

            ->db

            ->where('tsq.course_id', $course_id);
        $this->db->where('tsq.status','Active');
       // $this->db->where('tsq.suggested_test_series','yes');
        

        if ($category_id != "all")



        {



            $this

                ->db

                ->where('tsq.category_id', $category_id);



        }



        $this

            ->db

            ->select('tsq.*');

        $this

            ->db

            ->select("(select exam_status from user_assigned_testseries where user_assigned_testseries.user_id='$user_id' and user_assigned_testseries.course_id='$course_id' and user_assigned_testseries.quiz_id = tsq.id) as exam_status");

        $this

            ->db

            ->select("(select count(DISTINCT(quiz_questions.id)) from test_series_questions quiz_questions join test_series_options quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.quiz_id = tsq.id) as questions_count");



        $this

            ->db

            ->select("IFNULL(round((SELECT AVG(ratings) FROM `test_series_reviews` reviews where reviews.course_id = '$course_id'  and reviews.quiz_id = tsq.id), 1), 0) as ratings");



        $this

            ->db

            ->select("(SELECT count(id) FROM test_series_answers `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and quiz_id = tsq.id) as answered");



        $quiz = $this

            ->db

            ->get('test_series_quiz tsq');



        //echo $this->db->last_query();exit;

        



        if ($quiz->num_rows() > 0)



        {

             $response=$quiz->result_array();
             $new_response=array();
             foreach($response as $key =>$value){
                   //echo '<pre>';print_r($value);
                   if(($value['exam_time'] !='') && ($value['exam_time'] !='0000-00-00')){
                       $date_ary=explode('-',$value['exam_time']);
                       $new_exam_date= $date_ary[2].'-'.$date_ary[1].'-'.$date_ary[0];
                       //echo '<pre>';print_r($new_exam_date);
                       $today_date=date('d-m-Y');
                       //echo '<pre>';print_r($today_date);exit;
                       if(strtotime($new_exam_date) <= strtotime($today_date)){
                          $allow_status=1;
                        }else{
                          $allow_status=0;
                        }
                    $exam_date=date('d M',strtotime($value['exam_time']));
                    }else{
                        $allow_status=1;
                        $exam_date='';
                    }
                   $new_response[$key] =$value;
                   $new_response[$key]['allow_status'] =$allow_status;
                   $new_response[$key]['exam_date'] =$exam_date;
                   
                   /*if(($value['expiry_date'] !='')  && ($value['expiry_date'] != '0000-00-00')){
                        $new_response[$key]['expiry_date'] = $value['expiry_date'];
                   }else{
                        $new_response[$key]['expiry_date'] ='';
                   }*/
                   $test_series_id=$value['id'];
                   $query="select * from users_paid_testseries where user_id='".$user_id."' and test_series_id='".$test_series_id."' ";
                   $paid_test=$this->db->query($query)->row_array();
                   if(!empty($paid_test)){
                    $new_response[$key]['subscription_status']='yes';
                   }else{
                    $new_response[$key]['subscription_status']='no';
                   }


                }

            return $new_response;



        }



        return array();



    }



    function test_series_quiz_details($user_id, $quiz_id)



    {


        $this

            ->db

            ->order_by('qt.id', 'desc');



        $this

            ->db

            ->having('questions_count >', 0);



        $this

            ->db

            ->where('qt.id', $quiz_id);



        $this

            ->db

            ->join('test_series_categories tsc', 'tsc.id = qt.category_id');



        $this

            ->db

            ->select('qt.*, tsc.title as category_name');



        $this

            ->db

            ->select("(select count(DISTINCT(tsqt.id)) from test_series_questions tsqt join test_series_options tso on tso.question_id = tsqt.id where tsqt.quiz_id = qt.id) as questions_count");



        $this

            ->db

            ->select("(SELECT count(tsa.id) FROM test_series_answers `tsa` WHERE `tsa`.`quiz_id` = '$quiz_id' and `tsa`.`user_id` = '$user_id') as answers_count");



        $this

            ->db

            ->select("(SELECT DATE_FORMAT(tsa.created_on, '%d %b %Y') FROM test_series_answers `tsa` WHERE `tsa`.`quiz_id` = '$quiz_id' and `tsa`.`user_id` = '$user_id' order by id desc limit 1) as topic_completed_date");



        $this

            ->db

            ->select("(SELECT count(tsb.id) FROM test_series_bookmarks `tsb` WHERE `tsb`.`quiz_id` = '$quiz_id' and `tsb`.`user_id` = '$user_id') as bookmarks_count");



        $this

            ->db

            ->select("IFNULL(round((SELECT AVG(ratings) FROM `test_series_reviews` trv where trv.course_id = qt.course_id and trv.category_id = qt.category_id and trv.quiz_id = qt.id), 1), 0) as ratings");



        $quiz = $this

            ->db

            ->get('test_series_quiz qt');



        //echo $this->db->last_query();exit;

        



        if ($quiz->num_rows() > 0)



        {



            $result = $quiz->row_array();



            $result['questions_yet_to_answer'] = $result['questions_count'] - $result['answers_count'];



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

        



        // $this

        //     ->db

        //     ->order_by('tsqt.id', 'desc');



    

        $this

            ->db

            ->where('tsqt.course_id', $course_id);



        $this

            ->db

            ->where('tsqt.category_id', $category_id);



        $this

            ->db

            ->where('tsqt.quiz_id', $quiz_id);

    $this->db->where('tsqt.status', 'Active');



        $this

            ->db

            ->join('test_series_options tso', 'tso.question_id = tsqt.id');



        $this

            ->db

            ->join('test_series_quiz', 'test_series_quiz.id = tsqt.quiz_id');
            
    



        $this

            ->db

            ->select('tsqt.*, tsqt.id as question_id, test_series_quiz.title as topic_title');



      /*  $this

            ->db

            ->select("IF ((SELECT COUNT(id) FROM test_series_reports tsr where user_id = '$user_id' and course_id = '$course_id' and category_id = '$category_id' and quiz_id = '$quiz_id' and tsr.question_id = tsqt.id) >0, 'yes', 'no') as reported");

*/

        $this

            ->db

            ->distinct();


        $this->db->order_by('que_number', 'asc');

        $topics = $this

            ->db

            ->get('test_series_questions tsqt');



       // echo $this->db->last_query();exit;

        



        if ($topics->num_rows() > 0)



        {



            $res = $topics->result_array();



            foreach ($res as $key => $row)



            {


                $res[$key]['question_order_id']= $key+1;
                
                
                $res[$key]['question_image'] = $row['question_image'] === '' ? NULL : $row['question_image'];
                
             /*   $res[$key]['percentage'] = $this->test_series_correct_answer_percentage($row['question_id'], $row['answer']);*/

               // $res[$key]['options'] = $this->test_series_question_options($row['question_id']);

             $res[$key]['options'] = json_decode($row['options'],TRUE);

            }



            return $res;



        }



        return array();



    }



    function test_series_correct_answer_percentage($question_id, $answer)



    {



        $this

            ->db

            ->order_by('tsa.id', 'asc');



        $this

            ->db

            ->where('tsa.question_id', $question_id);



        $this

            ->db

            ->select('tsa.*');



        $answer = $this

            ->db

            ->get('test_series_answers tsa');



        //echo $this->db->last_query();exit;

        



        $question_answered_count = $answer->num_rows();



        if ($question_answered_count <= 0)



        {



            return "no one answered";



        }



        $this

            ->db

            ->order_by('tsa.id', 'asc');



        $this

            ->db

            ->where('tsa.answer_status', 'correct');



        $this

            ->db

            ->where('tsa.question_id', $question_id);



        $this

            ->db

            ->select('tsa.*');



        $answer = $this

            ->db

            ->get('test_series_answers tsa');



        //echo $this->db->last_query();exit;

        



        $correct_answered_count = $answer->num_rows();



        return $correct_answered_count / $question_answered_count * 100;



    }



    function test_series_question_options($question_id)



    {



        $this

            ->db

            ->order_by('tso.id', 'asc');



        $this

            ->db

            ->where('tso.question_id', $question_id);



        $this

            ->db

            ->select('tso.*');



        $options = $this

            ->db

            ->get('test_series_options tso');



        //echo $this->db->last_query();exit;

        


        $res = $options->result_array();


        if ($options->num_rows() > 0)

        {


          foreach ($res as $key => $row)

            {

       $res[$key]['image'] = $row['image'] === '' ? NULL : $row['image'];
                
          

            }


                 return $res;



        }



        return array();



    }
    
    public function getAnswerValue($answer){
        
        if($answer == 'a'){
            return 'A';
        }else if($answer == 'b'){
            return 'B';
        }else if($answer == 'c'){
            return 'C';
        }else if($answer == 'd'){
            return 'D';
        }else{
            //return round($answer, 2);
            return $answer;
        }
    }
    
    public function correct_answers_count($answers){
         $correct_answer_count = 0;
         $correctMarks=0;
        foreach($answers as $key=>$row){
             $correct_ans=array();
             $slected_answer=$this->getAnswerValue($row['answer']);
             $question_id=$row['question_id'];
                
             $query ="select id,positive_marks from test_series_questions where id='".$question_id."' ";
             
             $correct_ans= $this->db->query($query)->row_array();
             
             $status =  $this->checkAnswerStatus($question_id,$slected_answer);
             
             if($status == "correct"){
                 $correct_answer_count++;
                  $correctMarks += $correct_ans['positive_marks'];
             }
            
        }
        
        $result=array(
                        'correct_answer_count'=> $correct_answer_count,
                        'correctMarks'=> $correctMarks,
                     );
        return $result;
        
    }
    
    public function worng_answers_count($answers){
         $worng_answer_count = 0;
         $worngtMarks=0;
        foreach($answers as $key=>$row){
             $worng_ans=array();
             $slected_answer=$this->getAnswerValue($row['answer']);
             $question_id=$row['question_id'];
                if($row['answer'] != ''){
             $query ="select id,negative_marks from test_series_questions where id='".$question_id."' ";
             $worng_ans= $this->db->query($query)->row_array();
                }
          
              $status =  $this->checkAnswerStatus($question_id,$slected_answer);
             
             if($status == "wrong"){
                 $worng_answer_count++;
                  $worngtMarks += $worng_ans['negative_marks'];
             }
            
             
        }
        
         $result=array(
                        'worng_answer_count'=> $worng_answer_count,
                        'worngtMarks'=> $worngtMarks,
                     );
        return $result;
        
    }
    
    public function getCorrectAnswer($question_id){
        
             $query ="select id,answer from test_series_questions where id='".$question_id."' ";
             $result= $this->db->query($query)->row_array();
             
             return $result['answer'];
    }

    public function getCustomQbankModeCorrectAnswer($question_id){
        
             $query ="select id,answer from quiz_questions where id='".$question_id."' ";
             $result= $this->db->query($query)->row_array();
             
             return $result['answer'];
    }

    public function getCustomQbankModeAnswerStatus($question_id,$answer,$answer_status){
        
        
        
         if(($answer == 'A') || ($answer == 'B') || ($answer == 'C') ||  ($answer == 'D') || ($answer == 'a') || ($answer == 'b') || ($answer == 'c') || ($answer == 'd')){
             
              $query ="select id from quiz_questions where id='".$question_id."' and answer ='".$answer."' ";
          
                $res= $this->db->query($query)->row_array();
                if(!empty($res)){
                    return 'correct';
                }else{
                    return 'wrong';
                }
             
         }
        
        else if($answer != ''){
                
               
                $query ="select answer from quiz_questions where id='".$question_id."' ";
                $res= $this->db->query($query)->row_array();
                
                if(!empty($res)){
                    
                    $realAnswer = floatval($res['answer']);
                    $userAnswer = floatval($answer);
                   
                   if($userAnswer!=0)
                   $diff = abs(($realAnswer-$userAnswer)/$userAnswer) ;
                   else
                   $diff = abs($realAnswer-$userAnswer);
                   
                  if($diff < 0.01)
                    return 'correct';
                    
                    return 'wrong';
                    
                    
                }else{
                    return 'wrong';
                }
                
            }else{
                $answer_status = 'skipped';
                return  $answer_status;
            }
        
        
        
    }
    
    public function getAnswerStatus($question_id,$answer,$answer_status){
        
        
        
         if(($answer == 'A') || ($answer == 'B') || ($answer == 'C') ||  ($answer == 'D') || ($answer == 'a') || ($answer == 'b') || ($answer == 'c') || ($answer == 'd')){
             
              $query ="select id from test_series_questions where id='".$question_id."' and answer ='".$answer."' ";
          
                $res= $this->db->query($query)->row_array();
                if(!empty($res)){
                    return 'correct';
                }else{
                    return 'wrong';
                }
             
         }
        
        else if($answer != ''){
                
               
                $query ="select answer from test_series_questions where id='".$question_id."' ";
                $res= $this->db->query($query)->row_array();
                
                if(!empty($res)){
                    
                    $realAnswer = floatval($res['answer']);
                    $userAnswer = floatval($answer);
                   
                   if($userAnswer!=0)
                   $diff = abs(($realAnswer-$userAnswer)/$userAnswer) ;
                   else
                   $diff = abs($realAnswer-$userAnswer);
                   
                  if($diff < 0.01)
                    return 'correct';
                    
                    return 'wrong';
                    
                    
                }else{
                    return 'wrong';
                }
                
            }else{
                $answer_status = 'skipped';
                return  $answer_status;
            }
        
        
        
    }
    
    
    public function checkAnswerStatus($question_id,$answer){
        
        
         if(($answer == 'A') || ($answer == 'B') || ($answer == 'C') ||  ($answer == 'D') || ($answer == 'a') || ($answer == 'b') || ($answer == 'c') ||  ($answer == 'd')){
             
              $query ="select id from test_series_questions where id='".$question_id."' and answer ='".$answer."' ";
          
                $res= $this->db->query($query)->row_array();
                if(!empty($res)){
                    return 'correct';
                }else{
                    return 'wrong';
                }
             
         }
        
        else if($answer != '' && $answer!=null){
                
               
                $query ="select answer from test_series_questions where id='".$question_id."' ";
                $res= $this->db->query($query)->row_array();
                
                if(!empty($res)){
                    
                    $realAnswer = floatval($res['answer']);
                    $userAnswer = floatval($answer);
                   
                   
                   $diff = abs(($realAnswer-$userAnswer)/$userAnswer) ;
                   
                  if($diff < 0.01)
                    return 'correct';
                    
                    return 'wrong';
                    
                    
                }else{
                    return 'wrong';
                }
                
            }else{
                return 'skipped';
               
            }
        
        
        
    }


    public function getUserCourses($mobile){
        $query="select id from users where mobile='".$mobile."' and delete_status='1'";
        $result=$this->db->query($query)->row_array();
        
        if(!empty($result)){
            $user_id=$result['id'];
            $query="select ue.user_id,ue.exam_id as course_id,e.name as course,ue.payment_type from users_exams ue inner join exams e on e.id=ue.exam_id where ue.user_id='".$user_id."' ";
            $result1=$this->db->query($query)->result_array();
            return  $result1;
        }else{
          return array();   
        }
        
    }
    
    public function updateCoursePaymentStatus($mobile,$course_id,$status){
        
        $query="select id from users where mobile='".$mobile."' and delete_status='1'";
        $result=$this->db->query($query)->row_array();
        if(!empty($result)){
            $user_id=$result['id'];
            if($status == 'true'){
                $sta= 'paid';
            }else{
                $sta= 'free';
            }
            $up_arry=array('payment_type'=> $sta);
            $this->db->where('user_id',$user_id);
            $this->db->where('exam_id',$course_id);
            $this->db->update('users_exams',$up_arry);
            return 1;
        }else{
            return 0;
        }
    }
    
    
    public function resetTestSeries($userId,$quizId){
        
      $this->db ->where('user_id', $userId);

        $this ->db ->where('quiz_id', $quizId);
         
        $delete = $this->db ->delete(array('user_assigned_testseries','test_series_marks','test_series_answers','user_assigned_testseries'));
        
    }

    public function getPearlList($offset,$limit,$course_id){
        $new_offset=$offset-1;
        $query="select * from qbank_pearls where status='Active' and course_id='$course_id' LIMIT $new_offset,$limit";
        
        //echo $query;exit;
        $result= $this->db->query($query)->result_array();
        return $result; 
    }

    public function totalPearlsCount($course_id){
         $query="select count(id) as pearlscount from qbank_pearls where status='Active' and course_id='$course_id' ";
        //echo $query;exit;
        $result= $this->db->query($query)->row_array();
        return $result;
    }
    public function latestPearlsList($course_id){
        $query="select * from qbank_pearls where status='Active' and course_id='$course_id' order by id desc LIMIT 4";
       // echo $query;exit;
        $result= $this->db->query($query)->result_array();
        return $result;
    }

    public function getPearlSubjects($course_id){
        $query="select DISTINCT(subject_id) from qbank_pearls where status='Active' and course_id='$course_id'";
        $subject_ids= $this->db->query($query)->result_array();
        if(!empty($subject_ids)){
        foreach($subject_ids as $id){
            $string_ary[] = $id['subject_id'];
        }
        $sub_ids=implode(',',$string_ary);
        $query="select exam_id as course_id,id as subject_id,subject_name from subjects where id IN ($sub_ids) and delete_status='1'";
        $subject_data= $this->db->query($query)->result_array();
        
            if(!empty($subject_data)){
                    foreach($subject_data as $key=>$data){
                        $subject_id=$data['subject_id'];
                        $query="select count(id) as pearlscount from qbank_pearls where status='Active' and subject_id='$subject_id'";
                        // echo $query;exit;
                        $result= $this->db->query($query)->row_array();
                        $subject_data[$key]['pearlscount']=$result['pearlscount'];
                    }
            }
        }else{
            $subject_data=array();
        }

        //echo '<pre>';print_r($subject_data);exit;
        return $subject_data;
    }

  public function getSubjectWisePearls($user_id,$course_id,$subject_id,$offset,$limit){

        $new_offset=$offset-1;
        $query="select * from qbank_pearls where status='Active' and course_id='$course_id' and subject_id='$subject_id' LIMIT $new_offset,$limit";
        
        //echo $query;exit;
        $pearls= $this->db->query($query)->result_array();

        foreach($pearls as $key=>$pearl){
            $pearl_id=$pearl['id'];
            $query="select * from pearl_bookmarks where user_id='$user_id' and pearl_id='$pearl_id'";
            $bookMark=$this->db->query($query)->row_array();
            if(!empty($bookMark)){
                $pearls[$key]['bookmark_status']='true';
            }else{
                $pearls[$key]['bookmark_status']='false';
            }

            $query="select count(id)  as mcqs_count from qbank_pearls_question_ids where pearl_id='$pearl_id'";
            $mcqs_count=$this->db->query($query)->row_array();
            $pearls[$key]['mcqs_count']=$mcqs_count['mcqs_count'];
            
        }
        return $pearls;
  }

   public function totalSubjectWisePearlsCount($course_id,$subject_id){
         $query="select count(id) as pearlscount from qbank_pearls where status='Active' and course_id='$course_id' and subject_id='$subject_id'";
        //echo $query;exit;
        $result= $this->db->query($query)->row_array();
        return $result;
    }
  public function getPearlDetails($pearl_id){
        $query="select *,(select count(id) from qbank_pearls_question_ids where qbank_pearls_question_ids.pearl_id='$pearl_id') as mcqs_count from qbank_pearls where id='$pearl_id'";
        //echo $query;exit;
        $result= $this->db->query($query)->row_array();
        return $result;  
  }

  public function getPearlQuestions($pearl_id){
     $query="select qpq.pearl_id,qq.question,qq.question_unique_id,qq.id as question_id from qbank_pearls_question_ids qpq  inner join quiz_questions qq on qq.question_unique_id=qpq.question_id where qpq.pearl_id='$pearl_id' ";
        //echo $query;exit;
        $result= $this->db->query($query)->result_array();
        return $result; 
  }

  public function getBookMarkPearl($user_id,$pearl_id){

    $query="select * from pearl_bookmarks where pearl_id='$pearl_id' and user_id='$user_id'";
        //echo $query;exit;
    $result= $this->db->query($query)->row_array();
    if(empty($result)){
    $insert_ary=array(

                        'user_id'=>$user_id,
                        'pearl_id'=>$pearl_id,
                        'created_on'=>date('Y-m-d H:i:s')
                     );
    $res=$this->db->insert('pearl_bookmarks',$insert_ary);
    return ture;
    }else{
    return 0;
    }
  }

  public function unBookMarkPearl($user_id,$pearl_id){

    $this->db->where('user_id',$user_id);
    $this->db->where('pearl_id',$pearl_id);
    $res=$this->db->delete('pearl_bookmarks');
    return $res;
    
  }
public function addfeedbacktopearl($user_id,$pearl_id,$feedback){
    $insert_ary=array(
                        'user_id'=>$user_id,
                        'pearl_id'=>$pearl_id,
                        'feedback'=>$feedback,
                        'created_on'=>date('Y-m-d H:i:s')
                     );
    $res=$this->db->insert('pearl_feedbacks',$insert_ary);
    return $res;
}


public function getPearlDetailswithSerialNo($pearl_no){

        $pearl=$this->db->query("select id from qbank_pearls where pearl_number='$pearl_no'")->row_array();
        $pearl_id=$pearl['id'];

        $query="select *,(select count(id) from qbank_pearls_question_ids where qbank_pearls_question_ids.pearl_id='$pearl_id') as mcqs_count from qbank_pearls where pearl_number='$pearl_no'";
        //echo $query;exit;
        $result= $this->db->query($query)->row_array();
        return $result;  
  }

  public function getTotalSubjectswithPearls($user_id,$course_id){

    $query="select exam_id as course_id,id as subject_id,subject_name from subjects where delete_status='1'";
        $subject_data= $this->db->query($query)->result_array();
        
            if(!empty($subject_data)){
                    foreach($subject_data as $key=>$data){
                        $subject_id=$data['subject_id'];
                        $query="select count(id) as pearlscount from qbank_pearls where status='Active' and subject_id='$subject_id'";
                        // echo $query;exit;
                        $result= $this->db->query($query)->row_array();
                        $subject_data[$key]['pearlscount']=$result['pearlscount'];
                        $query="select * from qbank_pearls where status='Active' and subject_id='$subject_id'";
                        $pearls= $this->db->query($query)->result_array();
                        
                        if(!empty($pearls)){
                        foreach($pearls as $key2=>$pearl){
                            $pearl_id=$pearl['id'];
                            $query="select * from pearl_bookmarks where user_id='$user_id' and pearl_id='$pearl_id'";
                            $bookMark=$this->db->query($query)->row_array();
                            if(!empty($bookMark)){
                                $pearls[$key2]['bookmark_status']='true';
                            }else{
                                $pearls[$key2]['bookmark_status']='false';
                            }

                            $query="select count(id)  as mcqs_count from qbank_pearls_question_ids where pearl_id='$pearl_id'";
                            $mcqs_count=$this->db->query($query)->row_array();
                            $pearls[$key2]['mcqs_count']=$mcqs_count['mcqs_count'];
                            
                        }
                        $subject_data[$key]['pearls']=$pearls;
                    }else{
                        $subject_data[$key]['pearls']=array();
                    }
                }
              
            }else{
            $subject_data=array();
            }

        //echo '<pre>';print_r($subject_data);exit;
        return $subject_data;

  }


function getAllReviewQuestionsWithStatus($user_id, $course_id, $category_id, $quiz_id)
{
    /*$this->db->where('tsa.user_id', $user_id);
    $this->db->where('tsa.course_id', $course_id);
    $this->db->where('tsa.category_id', $category_id);
    $this->db->where('tsa.quiz_id', $quiz_id);
    $this->db->join('test_series_questions', 'test_series_questions.id = tsa.question_id');
    $this->db->select('test_series_questions.question,test_series_questions.math_library,tsa.question_order_id,tsa.answer_status,tsa.answer_sub_status');
    $this->db->select('test_series_questions.id');
    $this->db->distinct();
    $this->db->order_by('tsa.question_order_id','asc');
    $questions = $this->db->get('test_series_answers tsa');*/
    $this->db->select('*');
    $this->db->where('user_id', $user_id);
    $this->db->where('course_id', $course_id);
    $this->db->where('category_id', $category_id);
    $this->db->where('quiz_id', $quiz_id);
   
    $submit_data = $this->db->get('test_series_answers_json')->row_array();
   
    $decode_questions=json_decode($submit_data['submit_json'],TRUE);
    // echo '<pre>';print_r($decode_questions);exit;
        if (!empty($decode_questions))
        {
            //$questions = $questions->result_array();
            $questions=$decode_questions;
            foreach($questions as $key => $value)
            {
                $this->db->distinct();
                $this->db->where('user_id', $user_id);
                $this->db->where('question_id', $value['question_id']);
                $this->db->select('id');
                $bookmark_id = $this->db->get('test_series_bookmarks');
                $bookmark_id = $bookmark_id->row_array();
                $value['bookmark_id'] = $bookmark_id['id'];

                $question=$this->db->query("select question,math_library from test_series_questions where id='".$value['question_id']."' ")->row_array();
                $value['question']=$question['question'];
                $value['math_library']=$question['math_library'];

                if(($value['answer_status'] == 'correct') && ($value['answer_sub_status'] == 'guessed')) {
                    $value['answer_status']= 'guessed_correct';
                }

                if(($value['answer_status'] == 'wrong') && ($value['answer_sub_status'] == 'guessed')) {
                    $value['answer_status']= 'guessed_wrong';
                }

                $result[]=array(
                    'question' => $question['question'],
                    'math_library'=> $question['math_library'],
                    'question_order_id'=>$value['question_order_id'],
                    'answer_status'=>$value['answer_status'],
                    'answer_sub_status'=>$value['answer_sub_status'],
                    'id'=>$value['question_id'],
                    'bookmark_id'=>$bookmark_id['id'] 
                             );
           }
                      
             return $result;       
        
          //echo '<pre>';print_r($res);exit;
          
       }
       return array();
}
function getAllTestSeriesBookmarkQuestions($user_id, $course_id, $category_id, $quiz_id){
                /*$this->db->distinct();
                $this->db->where('tsb.user_id', $user_id);
                $this->db->where('tsb.course_id', $course_id);
                $this->db->where('tsb.category_id', $category_id);
                $this->db->where('tsb.quiz_id', $quiz_id);
                $this->db->select('tsb.id as bookmark_id,tsq.id,tsq.question,tsq.math_library,tsb.question_order_id,');
                $this->db->select("(select answer_status from test_series_answers where test_series_answers.user_id='$user_id' and 
                    test_series_answers.course_id='$course_id' and 
                    test_series_answers.category_id = '$category_id' and
                    test_series_answers.quiz_id = '$quiz_id' and 
                    test_series_answers.question_id = tsq.id) as answer_status");

                $this->db->select("(select answer_sub_status from test_series_answers where test_series_answers.user_id='$user_id' and 
                    test_series_answers.course_id='$course_id' and 
                    test_series_answers.category_id = '$category_id' and
                    test_series_answers.quiz_id = '$quiz_id' and 
                    test_series_answers.question_id = tsq.id) as answer_sub_status");

                $this->db->join('test_series_questions tsq','tsq.id=tsb.question_id');
                $this->db->from('test_series_bookmarks tsb');
                $this->db->order_by('tsb.question_order_id','ASC');
                $query=$this->db->get();
                $result=$query->result_array();*/

                $this->db->where('tsb.user_id', $user_id);
                $this->db->where('tsb.course_id', $course_id);
                $this->db->where('tsb.category_id', $category_id);
                $this->db->where('tsb.quiz_id', $quiz_id);
                $this->db->select('tsb.id as bookmark_id,tsq.id,tsq.question,tsq.math_library,tsb.question_order_id');
                
                $this->db->join('test_series_questions tsq','tsq.id=tsb.question_id');
                $this->db->from('test_series_bookmarks tsb');
                $this->db->order_by('tsb.question_order_id','ASC');
                $query=$this->db->get();
                $bookmarkedQuestions=$query->result_array();

                foreach($bookmarkedQuestions as $key=>$value){

                    $this->db->select('*');
                    $this->db->where('user_id', $user_id);
                    $this->db->where('course_id', $course_id);
                    $this->db->where('category_id', $category_id);
                    $this->db->where('quiz_id', $quiz_id);
                    $this->db->from('test_series_answers_json');
                    $result=$this->db->get()->row_array();
                    $submit_json=json_decode($result['submit_json'],TRUE);
                   // echo '<pre>';print_r($submit_json);exit;
                    //$res=$this->getTestSeriesSubmitAnswer($submit_json,$value['id']);
                    $bookmarkedQuestions[$key]['answer_status']=$submit_json[$value['id']]['answer_status'];
                    $bookmarkedQuestions[$key]['answer_sub_status']=$submit_json[$value['id']]['answer_sub_status'];
                }

                return $bookmarkedQuestions;
}
function getTestSeriesSubmitAnswer($array,$question_id){
    foreach($array as $k=>$v){
        if($v['question_id'] == $question_id){
                $res=array('answer_status'=>$v['answer_status'],'answer_sub_status'=>$v['answer_sub_status']);
        }
    }
    return $res;
}

function getAllQbankBookmarkQuestions($user_id, $course_id, $subject_id, $topic_id,$qbank_topic_id){
               
                $this->db->where('qb.user_id', $user_id);
                $this->db->where('qb.course_id', $course_id);
                $this->db->where('qb.subject_id', $subject_id);
                $this->db->where('qb.topic_id', $topic_id);
                $this->db->where('qb.qbank_topic_id', $qbank_topic_id);

               $this->db->select('qb.id as bookmark_id,qq.id,qq.question,qq.math_library,qq.question_order_no as question_order_id,qq.question_unique_id');
                /*$this->db->select("(select answer_status from quiz_answers where quiz_answers.user_id='$user_id' and 
                    quiz_answers.course_id='$course_id' and 
                    quiz_answers.subject_id = '$subject_id' and
                    quiz_answers.topic_id = '$topic_id' and 
                    quiz_answers.qbank_topic_id = '$qbank_topic_id' and
                    quiz_answers.question_id = qq.id) as answer_status");*/
                $this->db->join('quiz_questions qq','qq.question_unique_id=qb.question_id');
                $this->db->from('quiz_question_bookmarks qb');
                $this->db->order_by('qb.question_order_id','ASC');
                $query=$this->db->get();
                $bookmarkedQuestions=$query->result_array();
                foreach($bookmarkedQuestions as $key=>$value){

                    $this->db->select('*');
                    $this->db->where('user_id', $user_id);
                    $this->db->where('course_id', $course_id);
                    $this->db->where('subject_id', $subject_id);
                    $this->db->where('topic_id', $topic_id);
                    $this->db->where('qbank_topic_id', $qbank_topic_id);
                    $this->db->from('quiz_answers_json');
                    $result=$this->db->get()->row_array();
                    $submit_json=json_decode($result['submit_json'],TRUE);
                   // echo '<pre>';print_r($submit_json);exit;
                    //$res=$this->getTestSeriesSubmitAnswer($submit_json,$value['id']);
                    $bookmarkedQuestions[$key]['answer_status']=$submit_json[$value['id']]['answer_status'];
                    //$bookmarkedQuestions[$key]['answer_sub_status']=$submit_json[$value['id']]['answer_sub_status'];
                }

                return $bookmarkedQuestions;

}


function getQbankTopicsWithStatus($user_id, $course_id, $subject_id, $count)

    {
        $new_result=array();
        /*if ($count > 0){
            $this->db->limit(15, $count * 15);
        }else{
            $this->db->limit(15);
        }*/

        //$where="(qt.course_id='".$course_id."' AND qt.subject_id='".$subject_id."' AND qt.questions_count !=0 AND qt.status='Active') || (qt.course_id='".$course_id."' AND qt.subject_id='".$subject_id."' AND qt.questions_count !=0 AND qt.status='Active')";
        $this->db->where('qt.course_id', $course_id);
        $this->db->where('qt.subject_id', $subject_id);
        //$this->db->where('qt.questions_count !=', 0);
        $this->db->where('qt.status','Active');
        $this->db->order_by('qt.order','asc');
        $this->db->select('qt.id as qbank_chapter_id, qt.subject_id,qt.topic_name as qbank_chapter_name, qt.quiz_type,qt.title,qt.order');
        
        $topics = $this->db->get('quiz_topics qt');
        //echo $this->db->last_query();exit;
        $result=$topics->result_array();
        //echo '<pre>';print_r($result);
        if ($topics->num_rows() > 0)
       {

            $result=$topics->result_array();
            
            foreach($result as $key => $chapter){
                $final_qbank_topics_count=0;
            unset($chapter_id);
            $chapter_id=$chapter['qbank_chapter_id'];
           //echo '<pre>';print_r($chapter);
            $this->db->select('id as qbank_topic_id,name as qbank_topic_name,banner_image as image,title,pdf_path,quiz_type,questions_count,order');

            $this->db->where('course_id',$course_id);
            $this->db->where('subject_id',$subject_id);
            $this->db->where('chapter_id',$chapter['qbank_chapter_id']);
            //$this->db->having('questions_count >', 0);
            $this->db->where('status','Active');
            $this->db->order_by('order','asc');
            $this->db->from('quiz_qbanktopics');
            $sub_result=$this->db->get();

           // echo $this->db->last_query();exit;

            $qbank_topics=$sub_result->result_array();
            //echo '<pre>';print_r($qbank_topics);exit;
            foreach($qbank_topics as $key1=>$value1){
                unset($qbank_topic_id);
                $qbank_topic_id=$value1['qbank_topic_id'];
                
                $quiz_user_status=$this->getQuizUserStatus($user_id,$course_id,$subject_id,$chapter_id,$qbank_topic_id);
                if(empty($quiz_user_status)){
                    $qbank_topics[$key1]['quiz_status']='unattempt';
                }else{
                    $qbank_topics[$key1]['quiz_status']=$quiz_user_status['quiz_status'];
                }

            $query="select * from users_paid_qbanksubjects where user_id='".$user_id."' and subject_id='".$subject_id."' and payment_status='paid' ";
            $qbank_subject=$this->db->query($query)->row_array();
                    if(!empty($qbank_subject)){
                        $qbank_topics[$key1]['subscription_status']='yes';
                    /*$checkFreePackage=$this->db->query("select * from user_freepackage_trials where user_id='".$user_id."'")->row_array();
                    if(!empty($checkFreePackage)){
                    $check_package_expiry_date=$checkFreePackage['package_expiry_date'];
                    $today2=date('Y-m-d');
                    $free_package_expiry_date1 = strtotime($check_package_expiry_date); 
                    $free_today1 = strtotime($today2);

                    if (($free_package_expiry_date1 >= $free_today1) && ($qbank_subject['payment_status'] == 'free')){
                               $qbank_topics[$key1]['subscription_status']='yes';
                         }else if($qbank_subject['payment_status'] == 'paid'){
                                $qbank_topics[$key1]['subscription_status']='yes';
                         }else{
                            $qbank_topics[$key1]['subscription_status']='no';
                         }
                     }else{
                        $qbank_topics[$key1]['subscription_status']='yes';
                     }*/
                    }else{
                        $qbank_topics[$key1]['subscription_status']='no';
                    }

            }


            if(!empty($qbank_topics)){
                $result[$key]['topics_array']=$qbank_topics;
                $final_qbank_topics_count += count($qbank_topics);
                $result[$key]['qbank_topics_count'] = $final_qbank_topics_count;
                    }else{
                $result[$key]['topics_array'] =array(); 
               // unset($result[$key]);
                    }
            }
//exit;


            
            return $result;

        }
        
     return array();   
    }
    function getQuizUserStatus($user_id,$course_id,$subject_id,$chapter_id,$qbank_topic_id){
        $this->db->where('user_id',$user_id);
        $this->db->where('course_id',$course_id);
        $this->db->where('subject_id',$subject_id);
        $this->db->where('chapter_id',$chapter_id);
        $this->db->where('topic_id',$qbank_topic_id);
        $this->db->from('quiz_user_status');
        $query=$this->db->get(); 
        $result=$query->row_array();
        return $result; 
    }


function getQbankStatusCounts($user_id,$course_id,$subject_id,$chapter_id,$qbank_topic_id){

        $this->db->select('count(id) as topics_count');

        $this->db->select("(SELECT count(id) FROM `quiz_answers` where user_id = '$user_id' and course_id = '$course_id' and subject_id = '$subject_id' and topic_id = '$chapter_id' and qbank_topic_id='$qbank_topic_id') as answered");

        $this->db->select("(select count(DISTINCT(quiz_questions.id)) from quiz_questions join quiz_options on quiz_options.question_id = quiz_questions.id where quiz_questions.course_id = '$course_id' and quiz_questions.subject_id = '$subject_id' and quiz_questions.topic_id = '$chapter_id' and quiz_questions.qbank_topic_id='$qbank_topic_id') as questions_count");

        $this->db->where('course_id',$course_id);
        $this->db->where('subject_id',$subject_id);
        $this->db->where('chapter_id',$chapter_id);
        $this->db->where('id',$qbank_topic_id);
        $this->db->from('quiz_qbanktopics');

        $query=$this->db->get();
        //echo $this->db->last_query();exit;
        $result=$query->row_array();
        return $result;

}

public function deleteQuizAnswers($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id,$question_id){

        $this->db->where('user_id',$user_id);
        $this->db->where('course_id',$course_id);
        $this->db->where('subject_id',$subject_id);
        $this->db->where('topic_id',$topic_id);
        $this->db->where('qbank_topic_id',$qbank_topic_id);
        $this->db->where('question_id',$question_id);
        $result=$this->db->delete('quiz_answers');
        return $result;
        /*$query="CALL deleteQuizAnswers('$user_id','$course_id','$subject_id','$topic_id','$qbank_topic_id','$question_id')"
        $result=$this->db->query($query);
        return $result;*/
}

public function deleteUserAssignedTestseries($user_id,$course_id,$category_id,$quiz_id){
        $this->db->where('user_id',$user_id);
        $this->db->where('course_id',$course_id);
        $this->db->where('category_id',$category_id);
        $this->db->where('quiz_id',$quiz_id);
        $result=$this->db->delete('user_assigned_testseries');
        return $result;
}

public function deleteUserTestseriesTime($user_id,$course_id,$category_id,$quiz_id){
        $this->db->where('user_id',$user_id);
        $this->db->where('course_id',$course_id);
        $this->db->where('category_id',$category_id);
        $this->db->where('quiz_id',$quiz_id);
        $result=$this->db->delete('testseries_time');
        return $result;
}

public function deleteTopicRatings($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id){
        $this->db->where('user_id',$user_id);
        $this->db->where('course_id',$course_id);
        $this->db->where('subject_id',$subject_id);
        $this->db->where('topic_id',$topic_id);
        $this->db->where('qbank_topic_id',$qbank_topic_id);
        $result=$this->db->delete('quiz_topic_reviews');
        return $result;
}

public function checkQuestionOrderId($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id,$question_order_id){
        $this->db->where('user_id',$user_id);
        $this->db->where('course_id',$course_id);
        $this->db->where('subject_id',$subject_id);
        $this->db->where('topic_id',$topic_id);
        $this->db->where('qbank_topic_id',$qbank_topic_id);
        $this->db->where('question_order_id',$question_order_id);
        $this->db->from('quiz_question_bookmarks');
        $query=$this->db->get(); 
        $result=$query->row_array();
        return $result; 
    }
public function checkQuizBookMarkQuestionId($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id,$question_id) {
        $this->db->where('user_id',$user_id);
        $this->db->where('course_id',$course_id);
        $this->db->where('subject_id',$subject_id);
        $this->db->where('topic_id',$topic_id);
        $this->db->where('qbank_topic_id',$qbank_topic_id);
        $this->db->where('question_id',$question_id);
        $this->db->from('quiz_question_bookmarks');
        $query=$this->db->get(); 
        $result=$query->row_array();
        return $result; 
    }

public function getMobilesArray(){
    /*$array=array(
                 0 =>'7093668623',
                 1 =>'8886032595',
                 2 =>'7799820099',
                 3 =>'8099999956',
                 4 =>'7259279021',
                 5 =>'8919680181',
                 6 =>'8143496691',
                 7 =>'9381915174',
                 8 =>'9108391276',
				 9 =>'9381915168',
                10 =>'9381915169',
                11 =>'9381915156',
                12 =>'9381915159',
                13 =>'9381915140',
                14 =>'9381915160',
                15 =>'9381915174',
                16 =>'9381915178',
                17 =>'8099999958',
                );*/

        $this->db->select('mobile_no');
        $this->db->from('user_access_mobile_nos');
        $query=$this->db->get(); 
        $array=$query->result_array();
        $new_array=array();
        foreach($array as $key=>$value){
            $new_array[]=$value['mobile_no'];
        }
         
      //echo '<pre>';print_r($new_array);exit;
      return $new_array;
        
}


function getPackagesList($user_id,$course_id){
            
          
           $this->db->select('packages.*');
           if($course_id !=''){
          // $this->db->where('find_in_set("'.$course_id.'", packages.course_ids) <> 0');
          // $where="(find_in_set('".$course_id."', packages.course_ids) <> 0 and packages.status='Active' and packages.package_type='3') || (find_in_set('".$course_id."', packages.course_ids) <> 0 and packages.status='Active' and packages.package_type='2')";
           $where="(find_in_set('".$course_id."', packages.course_ids) <> 0 and packages.status='Active' and packages.package_type='2')";
            }else{
            // $where="(packages.status='Active' and packages.package_type='3') || (packages.status='Active' and packages.package_type='2')";
             $where="(packages.status='Active' and packages.package_type='2')";
            }
           // $this->db->join('exams', 'FIND_IN_SET(exams.id, packages.course_ids)', '', FALSE);
           // $this->db->join('subjects', 'FIND_IN_SET(subjects.id, packages.video_subject_ids)', '', FALSE);
           // $this->db->join('test_series_quiz', 'FIND_IN_SET(test_series_quiz.id, packages.test_series_ids)', '', FALSE);
           // $this->db->select("GROUP_CONCAT(DISTINCT exams.name SEPARATOR ', ') as course_names");
           // $this->db->select("GROUP_CONCAT(DISTINCT subjects.subject_name SEPARATOR ', ') as video_subject_names");
           // $this->db->select("GROUP_CONCAT(DISTINCT test_series_quiz.title SEPARATOR ', ') as test_series_names");
            $this->db->from('packages');
            //$this->db->where('packages.status','Active');
            $this->db->where($where);
            $this->db->order_by('packages.order','asc');

         $query=$this->db->get();
         $result=$query->result_array();
         //echo $this->db->last_query();exit; 
         //echo '<pre>';print_r($result);exit;
         $new_result=array();
         foreach ($result as $key => $value){
             if($value['id'] != ''){
                    $new_result[$key]=$value;

                    $package_id=$value['id'];
                    $payment_res=$this->db->query("select id from payment_info where package_id='".$package_id."' and payment_status='success' and user_id='".$user_id."'  ")->row_array();

                    if(!empty($payment_res)){
                    $new_result[$key]['subscription_status']='yes';
                    }else{
                    $new_result[$key]['subscription_status']='no';

                    /*$=$this->db->query("select id from payment_info where package_id='".$package_id."' and payment_status='success' and user_id='".$user_id."'  ")->row_array();*/

                    }

                    $ex_qbank_subject_ids=explode(',',$value['qbank_subject_ids']);
                    if(!empty($ex_qbank_subject_ids)){
                        $this->db->select('id,subject_name');
                        $this->db->from('subjects');
                        $this->db->where_in('id',$ex_qbank_subject_ids);
                        $result=$this->db->get()->result_array();
                        $new_result[$key]['qbank_subject_names']=$result;
                    }else{
                        $new_result[$key]['qbank_subject_names']=array();
                    }
                    $ex_video_subject_ids=explode(',',$value['video_subject_ids']);
                    if(!empty($ex_video_subject_ids)){
                        $this->db->select('id,subject_name');
                        $this->db->from('subjects');
                        $this->db->where_in('id',$ex_video_subject_ids);
                        $result=$this->db->get()->result_array();
                        $new_result[$key]['video_subject_names']=$result;
                    }else{
                        $new_result[$key]['video_subject_names']=array();
                    }
                    $ex_test_series_ids=explode(',',$value['test_series_ids']);
                    if(!empty($ex_test_series_ids)){
                        $this->db->select('id,title as test_series_name');
                        $this->db->from('test_series_quiz');
                        $this->db->where_in('id',$ex_test_series_ids);
                        $result=$this->db->get()->result_array();
                        $new_result[$key]['test_series_names']=$result;
                    }else{
                        $new_result[$key]['test_series_names']=array();
                    }
                    $ex_course_ids=explode(',',$value['course_ids']);
                    if(!empty($ex_course_ids)){
                        $this->db->select('id,name as course_name');
                        $this->db->from('exams');
                        $this->db->where_in('id',$ex_course_ids);
                        $result=$this->db->get()->result_array();
                        $new_result[$key]['course_names']=$result;
                    }else{
                        $new_result[$key]['course_names']=array();
                    }

                    $this->db->select('id as price_id,month,price,package_id');
                    $this->db->from('package_prices');
                    $this->db->where('package_id',$value['id']);
                    $package_prices=$this->db->get()->result_array();
                    $new_result[$key]['prices']=$package_prices;

                


             }
        }
        //echo '<pre>';print_r($new_result);exit;
        return $new_result;
}

public function getCouponsList(){
    $this->db->select('*');
    $this->db->from('coupons');
    $this->db->where('status','Active');
    $this->db->where('delete_status','1');
    $result=$this->db->get()->result_array();
    foreach ($result as $key => $value) {
              $today_date = date('Y-m-d');
             // $today_date1 = date('Y-m-d', strtotime($today_date . ' +1 day'));
              $today_date1 = strtotime($today_date);
              $coupon_start_date = strtotime($value['start_date']);
              if($today_date1 >= $coupon_start_date){
                $new_result[]=$value;
              }
        
    }
    return $new_result;
    
}

public function getPackageDetails($package_id){
    $this->db->select('*');
    $this->db->from('packages');
    $this->db->where('id',$package_id);
    $package=$this->db->get()->row_array();
    
    $ex_course_ids=explode(',',$package['course_ids']);
    $this->db->select('id,name as course_name');
    $this->db->from('exams');
    $this->db->where_in('id',$ex_course_ids);
    $courses=$this->db->get()->result_array();

    $ex_video_subject_ids1=explode(',',$package['video_subject_ids']);
    $ex_video_subject_ids= join("','",$ex_video_subject_ids1);

    $ex_qbank_subject_ids1=explode(',',$package['qbank_subject_ids']);
    $ex_qbank_subject_ids= join("','",$ex_qbank_subject_ids1);

    $test_series_ids1=explode(',',$package['test_series_ids']);
    $test_series_ids= join("','",$test_series_ids1);

    foreach($courses as $ckey => $cvalue){     
        
        $vsquery="select id,subject_name from subjects where id IN ('".$ex_video_subject_ids."') and exam_id='".$cvalue['id']."' ";
        $video_subjects=$this->db->query($vsquery)->result_array();
        $courses[$ckey]['video_subject_names']=$video_subjects;

        foreach($video_subjects as $vskey=>$vs_value){
        $vquery="select count(id) as videos_count from chapters where subject_id='".$vs_value['id']."' and exam_id='".$cvalue['id']."' and delete_status='1' and status='Active' ";
        $videos_count=$this->db->query($vquery)->row_array();
        $courses[$ckey]['video_subject_names'][$vskey]['videos_count']=$videos_count['videos_count'];
        }
       

        $qsquery="select id,subject_name from subjects where id IN ('".$ex_qbank_subject_ids."') and exam_id='".$cvalue['id']."'";
        $qbank_subjects=$this->db->query($qsquery)->result_array();
        $courses[$ckey]['qbank_subject_names']=$qbank_subjects;

        foreach($qbank_subjects as $qb_key=>$qb_value){
        $qtquery="select count(id) as qbank_topics_count from quiz_qbanktopics where subject_id='".$qb_value['id']."' and course_id='".$cvalue['id']."' and delete_status='1' and status='Active' ";
        $qbank_topics_count=$this->db->query($qtquery)->row_array();
        $courses[$ckey]['qbank_subject_names'][$qb_key]['qbank_topics_count']=$qbank_topics_count['qbank_topics_count'];
        }


        $tsquery="select id,title from test_series_quiz where id IN ('".$test_series_ids."') and course_id='".$cvalue['id']."'";
        $test_series=$this->db->query($tsquery)->result_array();
        $courses[$ckey]['test_series']=$test_series;
        
        }

        $response=array();
        $response['courses']=$courses;
        $pquery="select id as price_id,month,price from package_prices where package_id='".$package_id."' order by month asc ";
        $package_prices=$this->db->query($pquery)->result_array();
        $response['prices']=$package_prices;

        return $response;

}

  public function applyCoupon($price_id,$coupon_code){
   
   $cquery="select * from coupons where coupon_code='".$coupon_code."' and delete_status='1' and status='Active' ";

   $coupon=$this->db->query($cquery)->row_array();

   if(empty($coupon)){
    
    $aquery="select * from agents where coupon_code='".$coupon_code."' and status='Active' ";

    $coupon=$this->db->query($aquery)->row_array();

        if($coupon){
              date_default_timezone_set("Asia/Kolkata");
              $today_date = date('Y-m-d');
              $today_date1 = date('Y-m-d', strtotime($today_date . ' +1 day'));
              $today_date2 = strtotime($today_date1);
              $coupon_start_date = strtotime($coupon['start_date']);
              if($today_date2 <= $coupon_start_date){
                $final_price='coupon date Started at--'.$coupon['start_date'];
                $result=array('final_price'=> $final_price,'applied_discount'=>'');
                return $result;
              }
        }
    }
   
   $pquery="select * from package_prices where id='".$price_id."' ";
   $prices=$this->db->query($pquery)->row_array();

   $current_date = strtotime(date('Y-m-d')); 
   $coupon_date = strtotime($coupon['expiry_date']);

   if($coupon_date >= $current_date){
        $msg='coupon_exits';
        $coupon_discount=$coupon['discount_percentage'];
        $price=$prices['price']; 

        $applied_price=$price*($coupon_discount/100);
        $final_price=$price-$applied_price;
        $applied_discount=$applied_price;
        $result=array('final_price'=> $final_price,'applied_discount'=>$applied_discount);

   }else{
        $final_price='coupon expired';
        $result=array('final_price'=> $final_price,'applied_discount'=>'');
   }
    
    return $result;
   
  }


  public function getpaymetRespone($user_id){
    $this->db->select('id,user_name,user_mobile,receipt_id,package_name,valid_from,valid_to,final_paid_amount,razorpay_order_id,razorpay_payment_id,payment_status,payment_msg, payment_created_on,created_on as order_created_on');
    $this->db->where('user_id',$user_id);
    $this->db->order_by('id','desc');
    $query=$this->db->get('payment_info');
    $result=$query->row_array();
    return $result;
  }

public function getCustomQuestions($user_id,$topic_ids,$difficult_level,$limit,$paper_name){
    $ex_topic_ids=explode(',',$topic_ids);
    $ex_difficult_levels=explode(',',$difficult_level);
    $st_difficult_levels = join("','",$ex_difficult_levels);
    $st_topic_ids = join("','",$ex_topic_ids);  

   // $ex_subject_ids=explode(',',$subject_ids);
    //$st_subject_ids = join("','",$ex_subject_ids); 
    /*$this->db->select('*');
    $this->db->where('subject_id',$subject_id);
    $this->db->where_in('qbank_topic_id',$ex_topic_ids);
    $this->db->where_in('difficult_level',$ex_difficult_levels);
    $this->db->order_by('id','RANDOM');*/

    $query = $this->db->query("SELECT `id`,`id` as question_id, `course_id`, `subject_id`, `topic_id`, `qbank_topic_id`, `math_library`, `question`, `question_image`, `answer`, `explanation`, `explanation_image`, `difficult_level`, `reference`, `tags`, `previous_appearance`, `question_unique_id`,
(select CASE WHEN count(1)<>'0' THEN 'true' ELSE 'false' END from quiz_question_bookmarks bm where qq.id=bm.question_id and user_id='".$user_id."') bookmark_status,options_data as options
FROM `quiz_questions` qq 
where status='Active'
  and qbank_topic_id IN ('".$st_topic_ids."') and difficult_level IN ('".$st_difficult_levels."') ORDER BY rand() LIMIT $limit ");
   // $this->db->order_by('rand()');
    //$query=$this->db->get('quiz_questions');
   // echo $this->db->last_query();exit;
    $result=$query->result_array();

    foreach ($result as $key => $value) {
        
        $result[$key]['options']=json_decode($value['options'],TRUE);
        $result[$key]['question_order_id']= $key+1;
     }
    return $result;

}

public function getTopicsWithSubjectID($user_id,$subject_id){
    $ex_subject_ids=explode(',',$subject_id);
    $this->db->select('id as topic_id,course_id,subject_id,chapter_id,name,title,description,quiz_type,questions_count,order,status');
    $this->db->where_in('subject_id',$ex_subject_ids);
    $this->db->order_by('order','asc');
    $query=$this->db->get('quiz_qbanktopics');
    $result=$query->result_array();
    return $result;
}

public function getCustomExamID(){

     /* Reference No */

        $this->db->select("*");
        $this->db->from('tbl_dynamic_nos');
        $query = $this->db->get();
        $row_count = $query->num_rows();
        if($row_count > 0){

            $refers_no = $query->row_array();
            $ref_no=$refers_no['custom_exam_no']+1;
            $refernce_data = array('custom_exam_no' => $ref_no,
                                   'update_date_time'    => date('Y-m-d H:i:s')
                                   );
            $this->db->where('id ',1);
            $update = $this->db->update('tbl_dynamic_nos', $refernce_data);
        }else{

            $ref_no=1;
            $refernce_data = array('custom_exam_no' => $ref_no,
                                    'update_date_time'   => date('Y-m-d H:i:s')
                                    );
            $update = $this->db->insert('tbl_dynamic_nos', $refernce_data); 
        }
        
        /*if(strlen($ref_no) == 1){
            $reference_id =  'EXAM'.'000'.$ref_no;
        }else if(strlen($ref_no) == 2){
            $reference_id =  'EXAM'.'00'.$ref_no;
        }else if(strlen($ref_no) == 3){
            $reference_id =  'EXAM'.'0'.$ref_no;
        }else if(strlen($ref_no) == 4){
            $reference_id =  'EXAM'.$ref_no;
        }*/
        $reference_id =  'EXAMQ'.$ref_no;
        //$reference_id="BBM".$ref_no;
        /* Reference No */
        return $reference_id;
}


public function deleteQuizAnswersnew($user_id,$course_id,$subject_id,$topic_id,$qbank_topic_id){

        $this->db->where('user_id',$user_id);
        $this->db->where('course_id',$course_id);
        $this->db->where('subject_id',$subject_id);
        $this->db->where('topic_id',$topic_id);
        $this->db->where('qbank_topic_id',$qbank_topic_id);
       
        $result=$this->db->delete('quiz_answers_json');
        return $result;
       
}

function checkTopicRatings($user_id, $course_id, $subject_id, $topic_id, $qbank_topic_id){
$this->db->select('id')->from('quiz_topic_reviews');
        $this->db->where('user_id',$user_id);
        $this->db->where('course_id',$course_id);
        $this->db->where('subject_id',$subject_id);
        $this->db->where('topic_id',$topic_id);
        $this->db->where('qbank_topic_id',$qbank_topic_id);
       // $this->db->where('question_id',$question_id);
$result=$this->db->get()->result_array();

if(count($result)>0)
return $result[0]['id'];
else
return 0;
       
    }


    function updateTopicRatings($user_id, $course_id, $subject_id, $topic_id, $qbank_topic_id,$updatearr){
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('topic_id', $topic_id);
        $this->db->where('qbank_topic_id', $qbank_topic_id);
       
        $result=$this->db->update('quiz_topic_reviews',$updatearr);
        return $result;
    }


}



