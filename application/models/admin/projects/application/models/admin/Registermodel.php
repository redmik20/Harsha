<?php
class Registermodel extends CI_Model
{

    public function get_packages(){

        $this->db->select('*');
        //$this->db->where('status','Active');
        $query = $this->db->get('packages');      
        return $query->result_array();

    }

    public function addPackageToUser($post_data){
      // echo $order_id;
        date_default_timezone_set('Asia/Kolkata');

        $package_id=$post_data['package_id'];
        $coupon_code=$post_data['coupon_code'];
        $order_id=$post_data['order_id'];
        $user_id=$post_data['user_id'];
        $final_paid_amount=$post_data['final_paid_amount'];
        $price_id=$post_data['price_id'];
        $message=$post_data['message'];
       //echo '<pre>';print_r($post_data);exit;

        $pquery="select * from packages where id='".$package_id."' ";
        $package_data=$this->db->query($pquery)->row_array();

         $uquery="select id,name,email_id,mobile from users where id='".$user_id."' ";
         $user_data=$this->db->query($uquery)->row_array();

         if($order_id != ''){
         $ppquery="select * from payment_info where razorpay_order_id='".$order_id."' ";
         $payment_info=$this->db->query($ppquery)->row_array();
         //echo '<pre>';print_r($payment_info);
         $payment_id=$payment_info['id'];
         $coupon_name=$payment_info['coupon_name'];
         $final_paid_amount=$payment_info['final_paid_amount'];

          $update_array=array(
                        'payment_status'=>'success',
                        'payment_msg'=>'success updated from backend',
                     
                       );
        $this->db->where('razorpay_order_id',$order_id);
        $this->db->update('payment_info',$update_array);
       // echo $this->db->last_query();exit;

            }else{
         $payment_info=array();  
         $payment_id=0; 
         
       
        $ppquery="select id,package_id,month,price from package_prices where id='".$price_id."' ";
        $package_price=$this->db->query($ppquery)->row_array();

        $valid_months=$package_price['month'];
        $valid_to= date('Y-m-d', strtotime("+".$valid_months." months", strtotime(date('Y-m-d'))));

        if($coupon_code != ''){
        $coupon_applied='yes';
        $cquery="select id,coupon_code,discount_percentage from coupons where coupon_code='".$coupon_code."' ";
        $coupon=$this->db->query($cquery)->row_array();
        if(empty($coupon)){
            $a_query="select * from agents where coupon_code='".$coupon_code."' ";
            $agent_coupon=$this->db->query($a_query)->row_array();
            if(!empty($agent_coupon)){
                 $coupon_id=$agent_coupon['id'];
                 $coupon_discount_per=$agent_coupon['discount_percentage'];
                 $coupon_type='agent';
            }else{ $coupon_type='';$coupon_id='';$coupon_discount_per='';}
        }else{
            $coupon_type='normal';
            $coupon_id=$coupon['id'];
            $coupon_discount_per=$coupon['discount_percentage'];
        }
    }else{
        $coupon_applied='no';
        $coupon_type='';
        $coupon_id='';
        $coupon_discount_per='';

    }

         $insert_ary=array(
                            'user_id'=>$user_id,
                            'user_name'=>$user_data['name'],
                            'user_email'=>$user_data['email_id'],
                            'user_mobile'=>$user_data['mobile'],
                            'package_id'=>$package_id,
                            'package_name'=>$package_data['package_name'],
                            'price_id'=>$price_id,
                            'valid_months'=>$package_price['month'],
                            'price'=>$package_price['price'],
                            'valid_from'=>date('Y-m-d'),
                            'valid_to'=>$valid_to,
                            'coupon_type'=>$coupon_type,
                            'coupon_applied'=>$coupon_applied,
                            'coupon_id'=>$coupon_id,
                            'coupon_name'=>$coupon_code,
                            'coupon_discount'=>$coupon_discount_per,
                            'final_paid_amount'=>$final_paid_amount,
                            'payment_status'=>'success',
                            'payment_from'=>'offline',
                            'payment_msg'=>$message,
                            'created_on'=>date('Y-m-d H:i:s'),
                            'payment_created_on'=>date('Y-m-d H:i:s'),
                          );
        
             $check_payment=$this->db->query("select id from payment_info where user_id='".$user_id."' and package_id='".$package_id."' and payment_from='offline' ")->row_array();
             if(empty($check_payment)){
                 $this->db->insert('payment_info',$insert_ary);
                }
                //echo '<pre>';print_r($insert_ary);exit;

            }




         if(!empty($package_data)){

        if($package_data['course_ids'] !=''){

            $ex_course_ids=explode(',',$package_data['course_ids']);
            foreach($ex_course_ids as $ckey=>$cvalue){

            $userUserFreeCourse=$this->db->query("select id from users_paid_courses where user_id='".$user_id."' and course_id='".$cvalue."' and payment_status='free' ")->row_array();
            if(empty($userUserFreeCourse)){
            $check_paid_course=$this->db->query("select id from users_paid_courses where user_id='".$user_id."' and course_id='".$cvalue."' and package_id='".$package_id."' ")->row_array();
                if(empty($check_paid_course)){
                $course_data=array(
                                    'user_id'=>$user_id,
                                    'course_id'=>$cvalue,
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'payment_status'=>'paid',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_paid_courses',$course_data);
                    }
                }else{
                $up_course_data=array(
                                    'user_id'=>$user_id,
                                    'course_id'=>$cvalue,
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'payment_status'=>'paid',
                                    'modified_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->update('users_paid_courses',$up_course_data,array('id'=>$userUserFreeCourse['id']));
                }

            }

            foreach($ex_course_ids as $ckey=>$cvalue){

            $userUserFreeExam=$this->db->query("select id from users_exams where user_id='".$user_id."' and exam_id='".$cvalue."' and payment_type='free' ")->row_array();
            if(empty($userUserFreeExam)){

            $check_user_exam=$this->db->query("select id from users_exams where user_id='".$user_id."' and exam_id='".$cvalue."' ")->row_array();
            if(empty($check_user_exam)){
                $course_data1=array(
                                    'user_id'=>$user_id,
                                    'exam_id'=>$cvalue,
                                    'delete_status'=>1,
                                    'payment_type'=>'paid',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_exams',$course_data1);
                }else{
                    $update_array=array('payment_type' => 'paid','delete_status'=>1);
                    $this->db->update('users_exams',$update_array,array('user_id'=>$user_id,'exam_id'=>$cvalue));
                }
              //  echo $this->db->last_query();exit;
                }else{

                    $up_course_data2=array(
                                    'user_id'=>$user_id,
                                    'exam_id'=>$cvalue,
                                    'delete_status'=>1,
                                    'payment_type'=>'paid',
                                    'modified_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->update('users_exams',$up_course_data2,array('id'=>$userUserFreeExam['id']));

                }
            }
        }
        if($package_data['qbank_subject_ids'] !=''){
         $ex_qbankSubject_ids=explode(',',$package_data['qbank_subject_ids']);
         foreach($ex_qbankSubject_ids as $qbankkey=>$qbankvalue){

             $userUserFreeQbank=$this->db->query("select id from users_paid_qbanksubjects where user_id='".$user_id."' and subject_id='".$qbankvalue."' and payment_status='free' ")->row_array();
            if(empty($userUserFreeQbank)){

            $check_qbank_subject=$this->db->query("select id from users_paid_qbanksubjects where user_id='".$user_id."' and subject_id='".$qbankvalue."' and package_id='".$package_id."' ")->row_array();
            if(empty($check_qbank_subject)){
                $qbank_data=array(
                                    'user_id'=>$user_id,
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'subject_id'=>$qbankvalue,
                                    'payment_status'=>'paid',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_paid_qbanksubjects',$qbank_data);
                    }
                }else{
                    $up_qbank_data=array(
                                    'user_id'=>$user_id,
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'subject_id'=>$qbankvalue,
                                    'payment_status'=>'paid',
                                    'modified_on'=>date('Y-m-d H:i:s')
                                  );
                    $this->db->update('users_paid_qbanksubjects',$up_qbank_data,array('id'=>$userUserFreeQbank['id']));
                }
            }
         }

        if($package_data['video_subject_ids'] !=''){
        $ex_videoSubject_ids=explode(',',$package_data['video_subject_ids']);
        foreach($ex_videoSubject_ids as $videokey=>$videovalue){

            $userUserFreeVideo=$this->db->query("select id from users_paid_videosubjects where user_id='".$user_id."' and subject_id='".$videovalue."' and payment_status='free' ")->row_array();
            if(empty($userUserFreeVideo)){

            $check_video_subject=$this->db->query("select id from users_paid_videosubjects where user_id='".$user_id."' and subject_id='".$videovalue."' and package_id='".$package_id."' ")->row_array();
            if(empty($check_video_subject)){
                $video_data=array(
                                    'user_id'=>$user_id,
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'subject_id'=>$videovalue,
                                    'payment_status'=>'paid',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_paid_videosubjects',$video_data);
                    }
                }else{
                    
                    $up_video_data=array(
                                    'user_id'=>$user_id,
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'subject_id'=>$videovalue,
                                    'payment_status'=>'paid',
                                    'modified_on'=>date('Y-m-d H:i:s'),
                                  );
                    $this->db->update('users_paid_videosubjects',$up_video_data,array('id'=>$userUserFreeVideo['id']));
                 }
            }
        }

        if($package_data['test_series_ids'] !=''){
            $ex_testSeries_ids=explode(',',$package_data['test_series_ids']);
            foreach($ex_testSeries_ids as $testkey=>$testvalue){

            $userUserFreeTest=$this->db->query("select id from users_paid_testseries where user_id='".$user_id."' and test_series_id='".$testvalue."' and payment_status='free' ")->row_array();
            if(empty($userUserFreeTest)){

            $check_test_series=$this->db->query("select id from users_paid_testseries where user_id='".$user_id."' and test_series_id='".$testvalue."' and package_id='".$package_id."' ")->row_array();
                if(empty($check_test_series)){
                    $test_data=array(
                                        'user_id'=>$user_id,
                                        'payment_id'=>$payment_id,
                                        'package_id'=>$package_id,
                                        'test_series_id'=>$testvalue,
                                        'payment_status'=>'paid',
                                        'created_on'=>date('Y-m-d H:i:s')
                                      );
                    $this->db->insert('users_paid_testseries',$test_data);
                   // echo $this->db->last_query();exit;
                }
            }else{
                $up_test_data=array(
                                        'user_id'=>$user_id,
                                        'payment_id'=>$payment_id,
                                        'package_id'=>$package_id,
                                        'test_series_id'=>$testvalue,
                                        'payment_status'=>'paid',
                                        'modified_on'=>date('Y-m-d H:i:s')
                                    );
                    $this->db->update('users_paid_testseries',$up_test_data,array('id'=>$userUserFreeTest['id']));
                }
            }
        }

    }


    if($coupon_code !=''){
        $cquery="select id,coupon_code,discount_percentage from coupons where coupon_code='".$coupon_code."' ";
        $coupon=$this->db->query($cquery)->row_array();
        if(empty($coupon)){
            $a_query="select * from agents where coupon_code='".$coupon_code."' ";
            $agent_coupon=$this->db->query($a_query)->row_array();
            if(!empty($agent_coupon)){
                $agent_commissions_array=array(
                        'payment_info_id'=>$payment_id,
                        'package_id'=>$package_id,
                        'agent_name'=>$agent_coupon['agent_name'],
                        'agent_mobile'=>$agent_coupon['mobile'],
                        'agent_specialisation'=>$agent_coupon['specialisation'],
                        'user_name'=>$user_data['name'],
                        'user_mobile'=>$user_data['mobile'],
                        'applied_coupon'=>$coupon_code,
                        'coupon_discount'=>$agent_coupon['discount_percentage'],
                        'user_paid_amt'=>$final_paid_amount,
                        'created_on'=>date('Y-m-d H:i:s')
                    );
                $this->db->insert('agent_commissions',$agent_commissions_array);
            }
        }

       

    }

    }

    public function updatePackageToUsers($package_id,$users){

        //echo '<pre>';print_r($users);exit;

        foreach($users as $user){

            //echo '<pre>';print_r($user);
        
            
        $ppquery="select * from  users_paid_courses where package_id='".$package_id."' and user_id='".$user['user_id']."' ";
        $up_data=$this->db->query($ppquery)->row_array();
        $payment_id=$up_data['payment_id'];
        

        $pquery="select * from packages where id='".$package_id."' ";
        $package_data=$this->db->query($pquery)->row_array();

        $uquery="select id,name,email_id,mobile from users where id='".$user['user_id']."' ";
        $user_data=$this->db->query($uquery)->row_array();

        if(!empty($package_data)){

        if($package_data['package_type'] == 2){
                /*for paid packages */
        //echo '<pre>';print_r($package_data['package_type']);exit;
        if($package_data['course_ids'] !=''){

            $ex_course_ids=explode(',',$package_data['course_ids']);
            //echo '<pre>';print_r($ex_course_ids);exit;
            foreach($ex_course_ids as $ckey=>$cvalue){

                $userUserFreeCourse=$this->db->query("select id from users_paid_courses where user_id='".$user['user_id']."' and course_id='".$cvalue."' and payment_status='free' ")->row_array();
            if(empty($userUserFreeCourse)){

                    $check_paid_course=$this->db->query("select id from users_paid_courses where user_id='".$user['user_id']."' and course_id='".$cvalue."' and package_id='".$package_id."' ")->row_array();
                        if(empty($check_paid_course)){
                        $course_data=array(
                                            'user_id'=>$user['user_id'],
                                            'course_id'=>$cvalue,
                                            'payment_id'=>$payment_id,
                                            'package_id'=>$package_id,
                                            'payment_status'=>'paid',
                                            'created_on'=>date('Y-m-d H:i:s')
                                          );
                        $this->db->insert('users_paid_courses',$course_data);
                        }
                }else{
                    $up_course_data=array(
                                    'user_id'=>$user['user_id'],
                                    'course_id'=>$cvalue,
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'payment_status'=>'paid',
                                    'modified_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->update('users_paid_courses',$up_course_data,array('id'=>$userUserFreeCourse['id']));
                }

            }

            foreach($ex_course_ids as $ckey=>$cvalue){

            $userUserFreeExam=$this->db->query("select id from users_exams where user_id='".$user['user_id']."' and exam_id='".$cvalue."' and payment_type='free' ")->row_array();
            if(empty($userUserFreeExam)){

            $check_user_exam=$this->db->query("select id from users_exams where user_id='".$user['user_id']."' and exam_id='".$cvalue."' ")->row_array();
            if(empty($check_user_exam)){
                $course_data1=array(
                                    'user_id'=>$user['user_id'],
                                    'exam_id'=>$cvalue,
                                    'delete_status'=>1,
                                    'payment_type'=>'paid',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_exams',$course_data1);
                }else{
                    $update_array=array('payment_type' => 'paid','delete_status'=>1);
                    $this->db->update('users_exams',$update_array,array('user_id'=>$user['user_id'],'exam_id'=>$cvalue));
                }
              //  echo $this->db->last_query();exit;
            }else{
                 $up_course_data2=array(
                                    'user_id'=>$user['user_id'],
                                    'exam_id'=>$cvalue,
                                    'delete_status'=>1,
                                    'payment_type'=>'paid',
                                    'modified_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->update('users_exams',$up_course_data2,array('id'=>$userUserFreeExam['id']));
            }
          }
        }

        if($package_data['qbank_subject_ids'] !=''){
         $ex_qbankSubject_ids=explode(',',$package_data['qbank_subject_ids']);
         foreach($ex_qbankSubject_ids as $qbankkey=>$qbankvalue){

             $userUserFreeQbank=$this->db->query("select id from users_paid_qbanksubjects where user_id='".$user['user_id']."' and subject_id='".$qbankvalue."' and payment_status='free' ")->row_array();
            if(empty($userUserFreeQbank)){

                $check_qbank_subject=$this->db->query("select id from users_paid_qbanksubjects where user_id='".$user['user_id']."' and subject_id='".$qbankvalue."' and package_id='".$package_id."' ")->row_array();
                if(empty($check_qbank_subject)){
                    $qbank_data=array(
                                        'user_id'=>$user['user_id'],
                                        'payment_id'=>$payment_id,
                                        'package_id'=>$package_id,
                                        'subject_id'=>$qbankvalue,
                                        'payment_status'=>'paid',
                                        'created_on'=>date('Y-m-d H:i:s')
                                      );
                    $this->db->insert('users_paid_qbanksubjects',$qbank_data);
                    }
                }else{

                    $up_qbank_data=array(
                                    'user_id'=>$user['user_id'],
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'subject_id'=>$qbankvalue,
                                    'payment_status'=>'paid',
                                    'modified_on'=>date('Y-m-d H:i:s')
                                  );
                    $this->db->update('users_paid_qbanksubjects',$up_qbank_data,array('id'=>$userUserFreeQbank['id']));

                }
            }
         }

        if($package_data['video_subject_ids'] !=''){
        $ex_videoSubject_ids=explode(',',$package_data['video_subject_ids']);
        foreach($ex_videoSubject_ids as $videokey=>$videovalue){

            $userUserFreeVideo=$this->db->query("select id from users_paid_videosubjects where user_id='".$user['user_id']."' and subject_id='".$videovalue."' and payment_status='free' ")->row_array();
            if(empty($userUserFreeVideo)){

                $check_video_subject=$this->db->query("select id from users_paid_videosubjects where user_id='".$user['user_id']."' and subject_id='".$videovalue."' and package_id='".$package_id."' ")->row_array();
                if(empty($check_video_subject)){
                    $video_data=array(
                                        'user_id'=>$user['user_id'],
                                        'payment_id'=>$payment_id,
                                        'package_id'=>$package_id,
                                        'subject_id'=>$videovalue,
                                        'payment_status'=>'paid',
                                        'created_on'=>date('Y-m-d H:i:s')
                                      );
                    $this->db->insert('users_paid_videosubjects',$video_data);
                    }
                }else{
                     $up_video_data=array(
                                    'user_id'=>$user['user_id'],
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'subject_id'=>$videovalue,
                                    'payment_status'=>'paid',
                                    'modified_on'=>date('Y-m-d H:i:s'),
                                  );
                    $this->db->update('users_paid_videosubjects',$up_video_data,array('id'=>$userUserFreeVideo['id']));
                }
            }
        }

        if($package_data['test_series_ids'] !=''){
            $ex_testSeries_ids=explode(',',$package_data['test_series_ids']);
            foreach($ex_testSeries_ids as $testkey=>$testvalue){

            $userUserFreeTest=$this->db->query("select id from users_paid_testseries where user_id='".$user['user_id']."' and test_series_id='".$testvalue."' and payment_status='free' ")->row_array();
            if(empty($userUserFreeTest)){

                $check_test_series=$this->db->query("select id from users_paid_testseries where user_id='".$user['user_id']."' and test_series_id='".$testvalue."' and package_id='".$package_id."' ")->row_array();
                    if(empty($check_test_series)){
                        $video_data=array(
                                            'user_id'=>$user['user_id'],
                                            'payment_id'=>$payment_id,
                                            'package_id'=>$package_id,
                                            'test_series_id'=>$testvalue,
                                            'payment_status'=>'paid',
                                            'created_on'=>date('Y-m-d H:i:s')
                                          );
                        $this->db->insert('users_paid_testseries',$video_data);
                       // echo $this->db->last_query();exit;
                    }
                }else{
                    $up_test_data=array(
                                        'user_id'=>$user['user_id'],
                                        'payment_id'=>$payment_id,
                                        'package_id'=>$package_id,
                                        'test_series_id'=>$testvalue,
                                        'payment_status'=>'paid',
                                        'modified_on'=>date('Y-m-d H:i:s')
                                    );
                    $this->db->update('users_paid_testseries',$up_test_data,array('id'=>$userUserFreeTest['id']));
                }
            }
        }

    }else if($package_data['package_type'] == 3){
        /* for free package */

        //echo '<pre>';print_r($package_data['package_type']);exit;

        if($package_data['course_ids'] !=''){

            $ex_course_ids=explode(',',$package_data['course_ids']);
            //echo '<pre>';print_r($ex_course_ids);exit;
            foreach($ex_course_ids as $ckey=>$cvalue){

            $check_paid_course=$this->db->query("select id from users_paid_courses where user_id='".$user['user_id']."' and course_id='".$cvalue."' and package_id='".$package_id."' ")->row_array();
                if(empty($check_paid_course)){
                $course_data=array(
                                    'user_id'=>$user['user_id'],
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
            $check_user_exam=$this->db->query("select id from users_exams where user_id='".$user['user_id']."' and exam_id='".$cvalue."' ")->row_array();
            if(empty($check_user_exam)){
                $course_data1=array(
                                    'user_id'=>$user['user_id'],
                                    'exam_id'=>$cvalue,
                                    'delete_status'=>1,
                                    'payment_type'=>'free',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_exams',$course_data1);
                }else{
                    $update_array=array('payment_type' => 'paid','delete_status'=>1);
                    $this->db->update('users_exams',$update_array,array('user_id'=>$user['user_id'],'exam_id'=>$cvalue));
                }
              //  echo $this->db->last_query();exit;
            }
        }

        if($package_data['qbank_subject_ids'] !=''){
         $ex_qbankSubject_ids=explode(',',$package_data['qbank_subject_ids']);
         foreach($ex_qbankSubject_ids as $qbankkey=>$qbankvalue){

            $check_qbank_subject=$this->db->query("select id from users_paid_qbanksubjects where user_id='".$user['user_id']."' and subject_id='".$qbankvalue."' and package_id='".$package_id."' ")->row_array();
            if(empty($check_qbank_subject)){
                $qbank_data=array(
                                    'user_id'=>$user['user_id'],
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

            $check_video_subject=$this->db->query("select id from users_paid_videosubjects where user_id='".$user['user_id']."' and subject_id='".$videovalue."' and package_id='".$package_id."' ")->row_array();
            if(empty($check_video_subject)){
                $video_data=array(
                                    'user_id'=>$user['user_id'],
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

            $check_test_series=$this->db->query("select id from users_paid_testseries where user_id='".$user['user_id']."' and test_series_id='".$testvalue."' and package_id='".$package_id."' ")->row_array();
                if(empty($check_test_series)){
                    $video_data=array(
                                        'user_id'=>$user['user_id'],
                                        'payment_id'=>$payment_id,
                                        'package_id'=>$package_id,
                                        'test_series_id'=>$testvalue,
                                        'payment_status'=>'free',
                                        'created_on'=>date('Y-m-d H:i:s')
                                      );
                    $this->db->insert('users_paid_testseries',$video_data);
                   // echo $this->db->last_query();exit;
                }
            }
        }
      }

    }


  }

}


 public function package_users($package_id){

    $query="select DISTINCT up.user_id,u.mobile,u.name from users_paid_courses up inner join users u on u.id=up.user_id where up.package_id='".$package_id."' ";
    $result=$this->db->query($query)->result_array();
    return $result;
 }


      public function all_users($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'name'
        );
        $search_1 = array
        (
             1 => 'users.name',
            2 => 'users.mobile',
            3 => 'users.email_id',
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('id')->from('users')->where('delete_status', 1)->order_by('id','desc')->get()->num_rows();
        }
        else
        {
 $this->db->select('*')->from('users')->where('delete_status', 1)->order_by('id','desc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }    

    /*---------- /users ------------*/

    /* ------Unregister Users---*/
    public function all_unregister_users($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'mobile'
        );
        $search_1 = array
        (
             1 => 'mobile',
           
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {

          return $this->db->select('id')->from('unregister_users')->get()->num_rows();
        }
        else
        {
       
        $this->db->select('*');
        $this->db->from('unregister_users');
        $this->db->order_by('id','desc');
        }
      if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }    

     public function all_free_package_users($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'users.mobile'
        );
        $search_1 = array
        (
             1 => 'users.mobile',
           
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {

          /*return $this->db->select('ut.id')->join('users','users.id=ut.user_id')->from('user_freepackage_trials ut')->get()->num_rows();*/
           return $this->db->select('user_freepackage_trials.id')
            ->from('user_freepackage_trials')->join('users', 'users.id = user_freepackage_trials.user_id')->join('packages', 'packages.id = user_freepackage_trials.package_id')->order_by('user_freepackage_trials.id','asc')->get()->num_rows();
        }
        else
        {
       
        $this->db->select('ut.`user_id`, ut.`package_id`, ut.`package_start_date`, ut.`package_expiry_date`,users.`mobile`, users.`name`,packages.`package_name`');
        $this->db->from('user_freepackage_trials ut');
        $this->db->join('users','users.id=ut.user_id');
        $this->db->join('packages', 'packages.id = ut.package_id');
        $this->db->order_by('ut.id','desc');
        }
      if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column']];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    } 
    /* ------Unregister Users---*/

    /*course intrested users*/

    public function all_course_intrested_users($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'user_mobile'
        );
        $search_1 = array
        (
             1 => 'user_mobile',
           
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
           return $this->db->select('*')->from('user_interseted_courses')->order_by('id','desc')->get()->num_rows();
        }
        else
        {       
        $this->db->select('*');
        $this->db->from('user_interseted_courses');
        $this->db->order_by('id','desc');
        //echo $this->db->last_query();exit;
        }
      if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column']];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    } 

     /* ------Online Users---*/
    public function all_online_users($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'mobile'
        );
        $search_1 = array
        (
             1 => 'mobile',
           
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('id')->from('users')->where('login_status','true')->order_by('id','desc')->get()->num_rows();
        }
        else
        {
        $this->db->select('*')->from('users')->where('login_status','true')->order_by('id','desc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }    
    /* ------Online Users---*/

    public function usersList(){
        $this->db->select('users.*');
        $this->db->where('delete_status','1');
        $query = $this->db->get('users');      
        return $query->result_array();
    }
    public function get_examIds($user_id){
        $this->db->select('DISTINCT(exam_id),payment_type');
        $this->db->where('user_id',$user_id);
        $this->db->where('delete_status','1');
        $query = $this->db->get('users_exams');      
        return $query->result_array();
    }

    public function getExams($exam_ids){
        if(!empty($exam_ids)){
            foreach($exam_ids as $exam){
                    $e_ids[]=$exam['exam_id'];
            }
        $this->db->select('GROUP_CONCAT(name) as course_names');
        $this->db->where_in('id',$e_ids);
        $this->db->where('delete_status','1');
        $query = $this->db->get('exams');  
       // echo $this->db->last_query();    
        return $query->row_array();
        }else{ return array('course_names'=> '');}
        
    }

    public function getCourses(){

        $this->db->select('*');
        $this->db->where('delete_status','1');
        $this->db->order_by('order','asc');
        $query = $this->db->get('exams');  
       //echo $this->db->last_query();    
        return $query->result_array();
    }

        public function getQbankCourses(){

        $this->db->select('*');
        $this->db->where('delete_status','1');
        $this->db->order_by('order','asc');
        $query = $this->db->get('exams');  
       //echo $this->db->last_query();    
        return $query->result_array();
    }

    public function moveQuestionsToQbankTopic($post){
        $question_ids=$post['question_ids'];

        foreach($question_ids as $q_id){
            $update=array(
                            'course_id'=>$post['course_id'],
                            'subject_id'=>$post['subject_id'],
                            'topic_id'=>$post['chapter_id'],
                            'qbank_topic_id'=>$post['topic_id'],
                          );
            $this->db->update('quiz_questions', $update,array('id'=>$q_id));
        }
        return true;
    }

    public function copyQuestionsToQbankTopic($post){
        $question_ids=$post['question_ids'];

        foreach($question_ids as $q_id){
                $query="select * from quiz_questions where id='".$q_id."' ";
                 $question=$this->db->query($query)->row_array();
                 $question_unique_id=$this->get_dynamic_id();
            $questions_array=array(

                        'course_id'=>$post['copy_course_id'],
                        'subject_id'=>$post['copy_subject_id'],
                        'topic_id'=>$post['copy_chapter_id'],
                        'qbank_topic_id'=>$post['copy_topic_id'],
                        'math_library'=>$question['math_library'],
                        'question'=>$question['question'],
                        'question_image'=>$question['question_image'],
                        'answer'=>$question['answer'],
                        'explanation'=>$question['explanation'],
                        'explanation_image'=>$question['explanation_image'],
                        'difficult_level'=>$question['difficult_level'],
                        'reference'=>$question['reference'],
                        'tags'=>$question['tags'],
                        'previous_appearance'=>$question['previous_appearance'],
                        'question_unique_id'=> $question_unique_id,
                        'question_order_no'=>$question['question_order_no'],
                        'options_data'=>$question['options_data'],
                        'status'=>$question['status'],
                        'created_on'=>date('Y-m-d H:i:s')

                        );
            //echo '<pre>';print_r($questions_array);exit;
            $this->db->insert('quiz_questions', $questions_array);

        $db_question_id=$this->db->insert_id();
        $query="select * from quiz_options where question_id='".$q_id."'";
        $options=$this->db->query($query)->result_array();

        foreach($options  as $opt){
            $options_array = array(

                        'course_id' => $post['copy_course_id'],
                        'subject_id' =>$post['copy_subject_id'],
                        'quiz_id' => $post['copy_chapter_id'],
                        'question_id' =>$db_question_id,
                        'options' =>$opt['options'],
                        'image'=> $opt['image'],
                        'created_on'=> date('Y-m-d H:i:s')
                    );

            $this->db->insert('quiz_options', $options_array);

            $query="select * from quiz_options where question_id='".$db_question_id."'";
            $options_data=$this->db->query($query)->result_array();

            $options_encode=json_encode($options_data);
            $update_op=array('options_data'=>$options_encode);
            $this->db->update('quiz_questions',$update_op,array('id'=>$db_question_id));
            $question_unique_id='';
        }
    }
        return true;
    }
  
   public function getExamPaymetTypes($exam_ids,$user_id){
        if(!empty($exam_ids)){
            foreach($exam_ids as $exam){
                    $e_ids=$exam['exam_id'];
            }
        $this->db->select('GROUP_CONCAT(payment_type) as payment_type');
        $this->db->where_in('id',$e_ids);
        $this->db->where('user_id',$user_id);
        $this->db->where('delete_status','1');
        $query = $this->db->get('users_exams');      
        return $query->row_array();
        }else{ return array('payment_type'=> '');}
        
    }
    public function getUserExams($user_id){

        $query="select ue.id,ue.payment_type,u.id as user_id,u.name,u.mobile,e.name as course,e.id as exam_id from users_exams ue inner join exams e on e.id=ue.exam_id inner join users u on u.id=ue.user_id where ue.user_id='".$user_id."' and e.delete_status=1 ";
       // echo $query;exit;
       $result= $this->db->query($query)->result_array();
       return $result;
    }

    public function getUserswithCourse($course_id){
        $this->db->select('users.*,(select count(id) from users_exams where users_exams.user_id=users.id and users_exams.exam_id='.$course_id.') as course_status');
        $this->db->where('delete_status','1');
        $query = $this->db->get('users');      
        return $query->result_array();
    }

    public function checkUserswithCourse($course_id,$user){
        $this->db->select('*');
        $this->db->where('exam_id',$course_id);
         $this->db->where('user_id',$user);
          $this->db->where('delete_status','1');
        $query = $this->db->get('users_exams');      
        return $query->row_array();
    }
    
    function getUsers($search){
      //  $this->db->select('name','mobile');
        $this->db->like('name', $search);
        $this->db->or_like('mobile', $search);
        $query = $this->db->get('users');
        return $query->result();
    }
     function getExamCatids($tquiz_id) {
        $this->db->where('id',$tquiz_id);
        $query = $this->db->get('test_series_quiz');
      return $query->result();
    }
     function getUserTests($uid){
        $this->db->select('qa.*,e.*,qt.*');
            $this->db->from('quiz_answers qa');
            $this->db->join('exams e','e.id = qa.course_id');
            $this->db->join('users u','u.id= qa.user_id');
            //$this->db->join('subjects s','s.id= qa.subject_id');
            $this->db->join('quiz_topics qt','qt.id= qa.topic_id');
            $this->db->where('e.delete_status','1');
           // $this->db->where('s.delete_status','1');
            $this->db->where('u.delete_status','1');
            $this->db->where('u.id',$uid);
            //$this->db->group_by('qa.topic_id');
            $this->db->order_by('qa.id asc');
          //  $this->db->limit($limit, $start);
            $res = $this->db->get();
            return $res->result_array();
       }


    public function get_users()
    {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('users');      
        return $query->result();
    }
public function get_user_data($id){
        $this->db->select('*');
        $this->db->where('id',$id);
        //$this->db->where('delete_status','1');
        $query = $this->db->get('users');      
        $result=$query->row_array();
        return $result;
}
public function get_user_exams($id){
        $this->db->select('*');
        $this->db->where('user_id',$id);
        //$this->db->where('delete_status','1');
        $query = $this->db->get('users_exams');      
        $result=$query->result_array();
        return $result;
}
    public function check_useremail($email)
    {
        $this->db->select('id','email_id');
        $this->db->where('email_id',$email);
        $this->db->where('delete_status','1');

        $query = $this->db->get('users');      
        $result=$query->row_array();
        if(empty($result)){
            return 0;
        }else{
            return 1;
        }
    }

     public function check_usermobile($mobile)
    {
        $this->db->select('id','mobile');
        $this->db->where('mobile',$mobile);
        $this->db->where('delete_status','1');
        $query = $this->db->get('users');      
        $result=$query->row_array();
        if(empty($result)){
            return 0;
        }else{
            return 1;
        }
    }

    public function delete_user($user_id)
    {        
        $this->db->where('id', $user_id);
        $this->db->update('users', array('delete_status' => 0));             
        return true;
    }

    public function user_details($user_id)
    {       
  $this->db->select('users.*')->order_by('users.id','asc')->where('users.id', $user_id);
  $users = $this->db->get('users');
  //echo $this->db->last_query();exit;    
        if($users->num_rows() > 0)
        {
            return $users->result();
        }
        return array();

    }

    public function change_user_status($user_id, $status)
    {        
        $this->db->where('id', $user_id);
        $this->db->update('users', array('status' => $status));
        if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //$this->send_notifications($user_id, $message);  
        }            
        return true;
    }

    /*---------- /users ------------*/

     public function all_exams($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'name',
        );
        $search_1 = array
        (
            1 => 'name',
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return $this->db->select('id')->from('exams')->where('delete_status', 1)->order_by('order','asc')->get()->num_rows();  
        }
        else
        {
            $this->db->select('*')->from('exams')->where('delete_status', 1)->order_by('order','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }

   public function insert_exams($data)
    {
        $this->db->insert('exams', $data); 
        //echo $this->db->last_query();exit;  
        $course_id=$this->db->insert_id(); 
        $course_array=array('0'=>$course_id);
        $query="select id,course_ids from packages where package_type='1' ";
        //echo $query;
        $package=$this->db->query($query)->row_array();
        $ex_course_ids=explode(',',$package['course_ids']);
        $new_course_ids=array_merge($ex_course_ids,$course_array);
        $im_new_course_ids=implode(',',$new_course_ids);
        $update_array=array(
                    'course_ids'=>$im_new_course_ids,
                           );
       // echo '<pre>';print_r($update_array);exit;
        $this->db->update('packages',$update_array,array('id'=>$package['id']));           
        return true;
    }

    public function edit_exams()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        $query = $this->db->get('exams'); 
        //var_dump($query);exit; 
        //echo $this->db->last_query();exit;      
        return $query->row();
    }

    public function update_exams($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('exams', $data);  
         //echo $this->db->last_query();exit;          
        return true;
    }

    public function delete_exams()
    {        
        $this->db->where('exam_id', $this->uri->segment(4));
        $result= $this->db->get('chapters')->result_array();
         //print_r($result);
         $id=array();
         foreach($result as $results){
             $id[]=$results['id'];
         }
        // print_r($id);
         //exit;
        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('exams', $data);
        
        $this->db->where('exam_id', $this->uri->segment(4));
        $this->db->update('subjects', $data);
        
        $this->db->where('exam_id', $this->uri->segment(4));
        $this->db->update('chapters', $data);
        
        //$this->db->where_in('chapter_id', $id);
        //$this->db->update('video_topics', $data);
        
        //$this->db->where_in('chapter_id', $id);
        //$this->db->update('chapters_slides', $data);
        $this->db->where('exam_id', $this->uri->segment(4));
        $this->db->update('video_topics', $data);

        $this->db->where('exam_id', $this->uri->segment(4));
        $this->db->update('chapters_slides', $data);

        $this->db->where('exam_id', $this->uri->segment(4));
        $this->db->update('chapters_upload_notes', $data);

        $this->db->where('course_id', $this->uri->segment(4));
        $this->db->update(' quiz_topics', $data);

        $this->db->where('course_id', $this->uri->segment(4));
        $this->db->update(' quiz_questions', $data);

        $this->db->where('course_id', $this->uri->segment(4));
        $this->db->update(' test_series_quiz', $data);

        $this->db->where('course_id', $this->uri->segment(4));
        $this->db->update(' test_series_questions', $data);
        return true;
    }

    public function change_exam_status($user_id, $status)
    {        
        $this->db->where('id', $user_id);
        $this->db->update('exams', array('status' => $status));
                 
        return true;
    }

    /*---------- /exams ------------*/



    
    

     /*---------- subjects ------------*/
    public function subjects()
    {   
        $this->db->order_by('id', 'asc');
        $this->db->where('subjects.delete_status', 1);
        $query = $this->db->get('subjects');      
        return $query->result();
    }
    
    public function all_subjects($pdata, $getcount=null)
    {    

      $columns = array
        (
            0 => 'subjects.subject_name',
                1 => 'exams.name'
        );

        $search_1 = array
        (
            1 => 'subjects.subject_name',
             2 => 'exams.name'


        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return $this->db->select('subjects.id')->from('subjects')->join('exams', 'exams.id = subjects.exam_id')->where('subjects.delete_status', 1)->where('exams.delete_status', 1)->order_by('subjects.id','asc')->get()->num_rows();  
        }
        else
        {
            $this->db->select('subjects.*, exams.name')->from('subjects')->join('exams', 'exams.id = subjects.exam_id')->where('subjects.delete_status', 1)->where('exams.delete_status', 1)->order_by('subjects.id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;
        }
        return $result;
    }

     public function exams()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('exams.delete_status', 1);
       
        $query = $this->db->get('exams');      
        return $query->result();
    }

    public function insert_subjects($data)
    {
        $this->db->insert('subjects', $data);
        $subject_id=$this->db->insert_id();
        $sub_array=array('0'=>$subject_id);
        $query="select id,video_subject_ids,qbank_subject_ids from packages where package_type='1' ";
        //echo $query;
        $package=$this->db->query($query)->row_array();

        $ex_video_subject_ids=explode(',',$package['video_subject_ids']);
        $ex_qbank_subject_ids=explode(',',$package['qbank_subject_ids']);
        
        $new_vs_subjects=array_merge($ex_video_subject_ids,$sub_array);
        $new_qbank_subjects=array_merge($ex_qbank_subject_ids,$sub_array);

        $im_video_subject_ids=implode(',',$new_vs_subjects);
        $im_qbank_subject_ids=implode(',',$new_qbank_subjects);
        $update_array=array(
                    'video_subject_ids'=>$im_video_subject_ids,
                    'qbank_subject_ids'=>$im_qbank_subject_ids,
                           );
       // echo '<pre>';print_r($update_array);exit;
        $this->db->update('packages',$update_array,array('id'=>$package['id']));
        return true;
    }

    public function edit_subjects()
    {
        $data = array('delete_status' => 0);
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        //echo $this->db->last_query();exit;
        $query = $this->db->get('subjects', $data);       
        return $query->row();
    }

    public function update_subjects($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('subjects', $data); 
       //echo $this->db->last_query();exit;            
        return true;
    }

    public function delete_subjects()
    {        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('subjects', $data);             
        return true;
    }

        public function get_exams()
    {
        $this->db->where('delete_status', 1);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('exams'); 
        return $query->result();
    }

    public function get_submain($exam_id)
    {
        //$this->db->order_by('id', 'asc');
        $this->db->where('delete_status', 1);
        $this->db->where('course_id', $exam_id);
        $query = $this->db->get('subjects');      
        return $query->result_array();
    }


    public function gets_subjects()
    {   
        $this->db->order_by('id', 'asc');
        $this->db->where('delete_status', 1);
        $query = $this->db->get('subjects'); 
            //echo $this->db->last_query();exit;     
        return $query->result();
    }
    

    public function get_demo_video()
    {
       $this->db->order_by('id', 'asc');
        $query = $this->db->get('demo_video'); 
            //echo $this->db->last_query();exit;     
        return $query->result(); 
    }

    /*---------- /subjects ------------*/

    /*---------- Video Chapters ------------*/
    public function videochapters()
    {   
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('videochapters');      
        return $query->result();
    }
    
    public function all_videochapters($pdata, $getcount=null)
    {    

      $columns = array
        (
            0 => 'videochapters.name',
            1 => 'videochapters.title'
        );

        $search_1 = array
        (
             1 => 'exams.name',
             2 => 'subjects.subject_name',
             3 => 'videochapters.name',
             4 => 'videochapters.title',
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return $this->db->select('videochapters.id')
               ->join('exams', 'exams.id = videochapters.course_id')
               ->join('subjects', 'subjects.id = videochapters.subject_id')
               ->from('videochapters')
               ->order_by('videochapters.id','asc')
               ->get()->num_rows();  
        }
        else
        {
            $this->db->select('videochapters.*,exams.name  as ename,subjects.subject_name as sname')
            ->join('exams', 'exams.id = videochapters.course_id')
            ->join('subjects', 'subjects.id = videochapters.subject_id')
            ->from('videochapters')
            ->order_by('videochapters.id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;
        }
        return $result;
    }

     

    public function insert_videochapters($data)
    {
        $this->db->insert('videochapters', $data);
       // echo $this->db->last_query();exit;            
        return true;
    }

    public function edit_videochapters()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        $query = $this->db->get('videochapters');
          // var_dump($this->db->last_query());exit;
        return $query->row();
    }
    
    
    
    public function update_videochapters($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('videochapters', $data); 
       //echo $this->db->last_query();exit;            
        return true;
    }
    public function delete_videochapters($id)
    {        
        $res=$this->common_model->get_table_row('videochapters',array('id'=>$id),array());
         //echo '<pre>';print_r($res);exit;
        $file = './'.$res['banner_image'];
        if(is_file($file))
        unlink($file);
        $file = './'.$res['icon_image'];
        if(is_file($file))
        unlink($file);
         
        $this->db->where('id', $id);
        $res=$this->db->delete('videochapters');             
        return $res;
    }
    public function change_videochapters_status($id, $status)
    {        
        $this->db->where('id', $id);
        $this->db->update('videochapters', array('status' => $status));
        /*if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //$this->send_notifications($user_id, $message);  
        } */           
        return true;
    }

/*---------- Video Chapters ------------*/

      /*---------- chapters ------------*/

    public function change_chapter_status($id, $status)
    {        
        $this->db->where('id', $id);
        $this->db->update('chapters', array('status' => $status));
        /*if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //$this->send_notifications($user_id, $message);  
        } */           
        return true;
    }
    
    public function all_chapters($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'chapter_name'
        );
        $search_1 = array
        (
            1 => 'exams.name',
            2 => 'subjects.subject_name',
            3 => 'chapters.chapter_name',
            4 => 'chapters.video_path',
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            /*return $this->db->select('chapters.id')
            ->where('chapters.delete_status',1)
            ->join('subjects', 'subjects.id = chapters.subject_id','left')
            ->join('exams', 'exams.id = chapters.exam_id','left')
            ->join('videochapters', 'videochapters.id = chapters.chapter_id','left')
            ->join('video_topics', 'video_topics.chapter_id = chapters.id','left')
            ->from('chapters')
            ->order_by('chapters.id','asc')->get()->num_rows();*/

       return $this->db->select('chapters.*,videochapters.name as videochapter_name,chapters.chapter_name,subjects.subject_name,chapters.chapter_actorname,chapters.video_path,chapters.notespdf,exams.name as ename')->where('chapters.delete_status',1)->
join('subjects', 'subjects.id = chapters.subject_id','left')->
// join('video_topics', 'video_topics.chapter_id = chapters.id','left')->
// join('chapters_slides', 'chapters_slides.chapter_id = chapters.id','left')->
join('exams', 'exams.id = chapters.exam_id','left')
->join('videochapters', 'videochapters.id = chapters.chapter_id','left')
->from('chapters')->order_by('chapters.order','asc')->get()->num_rows();
        }
        else
        {
$this->db->select('chapters.*,videochapters.name as videochapter_name,chapters.chapter_name,subjects.subject_name,chapters.chapter_actorname,chapters.video_path,chapters.notespdf,exams.name as ename')->where('chapters.delete_status',1)->
join('subjects', 'subjects.id = chapters.subject_id','left')->
// join('video_topics', 'video_topics.chapter_id = chapters.id','left')->
// join('chapters_slides', 'chapters_slides.chapter_id = chapters.id','left')->
join('exams', 'exams.id = chapters.exam_id','left')
->join('videochapters', 'videochapters.id = chapters.chapter_id','left')
->from('chapters')->order_by('chapters.order','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();  
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }
    public function send_push_notification($course_id,$image_path,$title,$message = NULL, $user_id, $type)
    {
        date_default_timezone_set("Asia/Kolkata");
        $reg_ids = array();
        $ios_reg_ids = array();

        if($course_id != 'all'){
            $this->db->select("DISTINCT(user_id)");
            $multipleWhere = ['delete_status' => 1, 'exam_id' => $course_id];
              $this->db->where($multipleWhere);
            $user_exams = $this->db->get("users_exams");
            $ue_data=$user_exams->result_array();
            //echo '<pre>';print_r($ue_data);exit;
            if(!empty($ue_data)){
            foreach( $ue_data as $udata){
                $user_ids[]=$udata['user_id'];
            }
           }else{ $user_ids = array();}

            if($type == "many")
            {
                // $this->db->where_in('id', $user_id);
            }
            else
            {
                $this->db->where('id', $user_id);
            }
         }

        $this->db->select("id, token, ios_token"); 
        if($course_id != 'all'){
         $this->db->where_in('id',$user_ids);
            }
        $users = $this->db->get("users");
      
      // echo '<pre>';print_r($users);
        $r = array();       
        if($users->num_rows() > 0)
        {
            $result =  $users->result();
            // echo '<pre>';print_r($result);exit;
            foreach($result as $r)
            {
                
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
        //$rowsMsg[] = $message;
       
        //$jsonData = json_encode(array('json' => $rowsMsg));            
        $message = array('title' => $title, 'message' => $message,'image'=>$image_path);
        $ios_message = $message;
     $chunkSize = 900;    
        
    $noOfTimesLoop = $reg_ids%$chunkSize + 1;   
    
   
    
   for ($x = 0; $x < $noOfTimesLoop; $x++) {
       
       
       
   $this->sendAndroidNotification(array_slice($reg_ids, $x*$chunkSize, $chunkSize), $message);
   $this->sendIosNotification(array_slice($ios_reg_ids, $x*$chunkSize, $chunkSize), $message);
   
   }
    
        
        
        //print_r($pushStatus);
        //$iosPushStatus = $this->sendIosNotification($ios_reg_ids, $ios_message);
        return true;
    }

    public function sendAndroidNotification($tokens, $message) 
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
             'registration_ids' => $tokens,
             'data' => $message
            );
//echo '<pre>';print_r($fields);exit;
        $headers = array(
           // 'Authorization:key = AIzaSyCl8zppJLCKPRiy4vxu7kx0KOqkoPAktAo',
            'Authorization:key = AAAAXciXlu0:APA91bH-TsgXC5lvpVvfRbklRLCVKzq4cT1v_s4FWqoKi1ZFWXKECEwRxxMQh6Q_Sn5GfXnPR4IZYIhPQOzusqJ0knVPytOJJ0QIVs9eVUoTSw-fcT2rIwr2ITxmwm8xbTYvuE6eJDFj',
            //'Authorization:key = AAAAU0Hv9rg:APA91bH5jb7SzvnUuXwh9M4CRN17kbRZkeovviIGHVGZtW4fbxfhiUvCaEr_uLeR4wOseb-xjh2hafWwKLtLI9FPiGRCnIq_vb9wBlz-7sSwUN4_GdoOmsmvsVA3wTv3KgCG9m7kfk6U',
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
			 /*if(curl_errno($ch))
			 {
			 	echo 'error:' . curl_error($ch);exit;
			 }*/		
			// curl_close($ch);	
        curl_close($ch);
        //var_dump($result);
        //echo '<pre>';print_r($result);exit;
        return $result;
    }
    public function sendIosNotification($tokens, $message)
    {

        // API access key from Google FCM App Console
        
        define('API_ACCESS_KEY','AAAAX7Wrw_s:APA91bEBBy4lmSapjeHqfaAPxoeb9aAd_Idn8hDA3GiJboqOfuYfHjEcOHf8a334QFXlyy123sS2vLNiJJfyxHlV2v26MGJ8jkELsHSXEV2GYCbN6hYWbBYKvxdePYFhQIAvjuZBFnHK');
        

       
        // 'priority' => 'high' ; // options are normal and high, if not set, defaults to high.

        //$new_message= array( 'aps' => array( 'alert' => $message,'mutable-content' => 1, 'badge' => 1 ));
       //$new_message1=json_encode($new_message);
        //echo '<pre>';print_r($new_message);
        

        $fcmFields = array(
             'registration_ids' => $tokens,
             //'priority' => 'high',
             'notification' => $message
            );
        
        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
         
        $ch = curl_init();
        
          curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          // Disabling SSL Certificate support temporarly
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
        $result = curl_exec($ch );
        if ($result === false) {
          die('Curl failed:' . curl_errno($ch));
        }
        //echo '<pre>';print_r($result);exit;
        curl_close( $ch );
       // echo $result . "\n\n";exit;
        return true;
    }

    /*---------- /chapters ------------*/

    public function insert_chapters($data)
    {
        $this->db->insert('chapters', $data); 
       //echo $this->db->last_query();exit;        
       return $this->db->insert_id();
        //return true;
    }

      public function edit_chapters()
    {
        $this->db->order_by('chapters.id', 'asc');
        $this->db->where('chapters.id', $this->uri->segment(4));
        //var_dump($query);exit;
         //echo $this->db->last_query();exit;
        $this->db->join('exams','exams.id=chapters.exam_id');
        $this->db->join('subjects','subjects.id=chapters.subject_id');
        // $this->db->join('video_topics','chapters.id=video_topics.chapter_id');
        $this->db->select('chapters.*,subjects.subject_name,exams.name as exam_name');
        $chapter = $this->db->get('chapters')->row();

        if(!empty($chapter)){
            // $this->db->order_by('id', 'asc');
            $this->db->where('chapter_id', $chapter->id);
            $slides = $this->db->get('chapters_slides');
            $slides = $slides->result_array();
        }
        if(!empty($chapter)){
            // $this->db->order_by('id', 'asc');
            $this->db->where('chapter_id', $chapter->id);
            $upload_notes = $this->db->get('chapters_upload_notes');
            $upload_notes = $upload_notes->result_array();
        }
        if(!empty($chapter)){
            // $this->db->order_by('id', 'asc');
            $this->db->where('chapter_id', $chapter->id);
            $this->db->order_by('id','asc');
            $video_topics = $this->db->get('video_topics');
            $video_topics = $video_topics->result_array();
        }

        // echo "<pre>";print_r($chapter);exit;
        return array('chapter'=>$chapter,'slides'=>$slides,'video_topics'=>$video_topics,'upload_notes'=>$upload_notes);
    }

    public function update_chapters($data, $id)
    {
        //$this->db->where('exam_id', $id);
        $this->db->where('id', $id);
        $this->db->update('chapters', $data);
       // echo $this->db->last_query();exit;       
        return true;
    }
    public function delete_chapters()
    {        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('chapters', $data);             
        return true;
    }
    public function get_subjects()
    {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('subjects');      
        return $query->result();
    }
    public function get_subjectswithCourse($course_id)
    {   
        $this->db->where('exam_id', $course_id);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('subjects');      
        return $query->result_array();
    }
    
     public function get_subjects_videos()
    {
       
     $where = '(delete_status=1 and (category_type =2 or category_type=0))';
       $this->db->where($where);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('subjects');      
        return $query->result();
    }
    



    public function chapter_details($chapter_id)
    {       
  $this->db->select('chapters.*,,subjects.subject_name')->join('subjects', 'subjects.id = chapters.subject_id')->order_by('chapters.id','asc')->where('chapters.id', $chapter_id);
  $users = $this->db->get('chapters');
  //echo $this->db->last_query();exit;    
        if($users->num_rows() > 0)
        {
            return $users->result();
        }
        return array();

    }

    public function chapterdemo_details($chapter_id)
    {       
         $this->db->select('subjects.*,subjects.subject_name,subjects.video_path,chapters.id,chapters.chapter_name,chapters.chapter_actorname,chapters.notespdf,chapters.suggested_videos')->join('chapters', 'chapters.subject_id = subjects.id')->order_by('subjects.id','asc')->where('subjects.delete_status', 1);
  $users = $this->db->get('subjects');
  //echo $this->db->last_query();exit;    
        if($users->num_rows() > 0)
        {
            return $users->result();
        }
        return array();

    }

     

 public  function change_testaccess_status($status)
     {
        $this->db->update('plan_details', array('tests_access' => $status));
        if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //$this->send_notifications($vendor_id, $message);  
        }            
        return true;
     }

     public  function change_videoaccess_status()
     {

        $this->db->update('plan_details', array('status' => $status));
        if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //echo $this->db->last_query();exit;
            //$this->send_notifications($vendor_id, $message);  
        }            
        return true;
     }

      public  function change_qbankaccess_status($status)
     {
        $this->db->update('plan_details', array('status' => $status));
        if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //$this->send_notifications($vendor_id, $message);  
        }            
        return true;
        //echo $this->db->last_query();exit;
     }
     


 public function change_master_status($vendor_id, $status)
    {        
        $this->db->where('id', $vendor_id);
        $this->db->update('vendors', array('status' => $status));
        if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //$this->send_notifications($vendor_id, $message);  
        }            
        return true;
    }

     

     /*--------chapter-------------*/
   



  /*---------- chapters_slides ------------*/
    
    public function all_chapters_slides($pdata, $getcount=null)
    {
        $columns = array
        (
             0 => 'chapters.chapter_name'
        );
        $search_1 = array
        (
             1 => 'chapters.chapter_name'
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('chapters_slides.id')
            ->from('chapters_slides')->join('chapters', 'chapters.id = chapters_slides.chapter_id')->join('exams', 'exams.id = chapters_slides.exam_id','left')->join('subjects', 'subjects.id = chapters_slides.subject_id','left')->where('chapters_slides.delete_status', 1)->order_by('chapters_slides.id','asc')->get()->num_rows();
        }
        else
        {
        $this->db->select('chapters_slides.*,chapters.chapter_name,exams.name as ename,subjects.subject_name as sname')->join('chapters', 'chapters.id = chapters_slides.chapter_id','left')->join('exams', 'exams.id = chapters_slides.exam_id','left')->join('subjects', 'subjects.id = chapters_slides.subject_id','left')->from('chapters_slides')->where('chapters_slides.delete_status', 1)->order_by('chapters_slides.id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get();
        //echo $this->db->last_query();exit;
        $result=$result->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }    

    /*---------- /chapters_slides ------------*/
 public function chapters()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('chapters.delete_status', 1);
       
        $query = $this->db->get('chapters');      
        return $query->result();
    }
     public function chapters_slides()
    {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('chapters_slides');      
        return $query->result_array();
    }

     public function get_chapters()
    {
          $this->db->where('delete_status', 1);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('chapters');  
       //echo $this->db->last_query();exit;     
        return $query->result();
    }


      public function insert_chapters_slides($data)
    {
        $this->db->insert('chapters_slides', $data); 
        //echo $this->db->last_query();exit;            
        return true;
    }

      public function edit_chapters_slides()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        $query = $this->db->get('chapters_slides');
         //echo $this->db->last_query();exit;        
        return $query->row();
    }
    
    public function edit_chapters_slidess($id)
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $id);
        $query = $this->db->get('chapters_slides');
         //echo $this->db->last_query();exit;        
        return $query->row();
    }
    public function gets_chapters_slides()
    {

        $this->db->order_by('id', 'asc');
        $query = $this->db->get('chapters_slides');      
        return $query->result();


    }

    public function update_chapters_slides($data, $id)
    {
        $this->db->where('chapters_slides.id', $id);
        $this->db->update('chapters_slides', $data); 
       // echo $this->db->last_query();exit;             
        return true;
    }
   public function delete_chapters_slides()
    {        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('chapters_slides', $data);
        //echo $this->db->last_query();exit;             
        return true;
    }



     /*---------- notifications ------------*/
    
    public function all_notifications($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'title'
        );
        $search_1 = array
        (
            1 => 'title'
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('notifications.id')->from('notifications')->where('notifications.delete_status', 1)->order_by('notifications.id','asc')->get()->num_rows();
        }
        else
        {
            $this->db->select('notifications.*')->from('notifications')->where('notifications.delete_status', 1)->order_by('notifications.id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }    

    /*---------- /notifications ------------*/ 

    public function insert_notifications($data)
    {
        $this->db->insert('notifications', $data); 
       // echo $this->db->last_query();exit;            
        return true;
    }

    public function edit_notifications()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        $query = $this->db->get('notifications'); 
        //var_dump($query);exit; 
        //echo $this->db->last_query();exit;      
        return $query->row();
    }

    public function update_notifications($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('notifications', $data);  
         //echo $this->db->last_query();exit;          
        return true;
    }

    public function delete_notifications()
    {        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('notifications', $data);             
        return true;
    }
    
     public function all_faculty($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'faculty_details.name',
             1 => 'faculty_details.title',
               2 => 'faculty_details.specialisation'
        );
        $search_1 = array
        (
            1 => 'exams.name',
            2 => 'faculty_details.name',
            3 => 'faculty_details.title',
            4 => 'faculty_details.specialisation'
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('faculty_details.id')->from('faculty_details')->join('exams', 'exams.id = faculty_details.exam_id','left')->where('faculty_details.delete_status','1')->order_by('faculty_details.order','asc')->get()->num_rows();
        }
        else
        {
 $this->db->select('faculty_details.*,exams.name as ename')->from('faculty_details')->join('exams', 'exams.id = faculty_details.exam_id','left')->where('faculty_details.delete_status', 1)->order_by('faculty_details.order','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }    

    /*---------- /faculty ------------*/
    public function get_faculty()
    {
        $this->db->order_by('faculty_id', 'asc');
        $query = $this->db->get('faculty_details');      
        return $query->result_array();
    }

public function insert_faculty($data)
    {
        $this->db->insert('faculty_details', $data);
       // echo $this->db->last_query();exit;            
        return true;
    }

     public function update_faculty($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('faculty_details', $data);      
           return true;

    }
    public function delete_faculty()
    {        
        
         $data = array('delete_status' => 0);
         $this->db->where('id', $this->uri->segment(4));
         $this->db->update('faculty_details', $data);
        // echo $this->db->last_query();exit;

        return true;
    }

    public function change_faculty_status($faculty_id, $status)
    {        
        $this->db->where('faculty_id', $faculty_id);
        $this->db->update('faculty_details', array('status' => $status));
        if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //$this->send_notifications($user_id, $message);  
        }            
        return true;
    }

    /*---------- /faculty ------------*/

 public function all_banners($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'image'
        );
        $search_1 = array
        (
           1 => 'exams.name'
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('banners.id')->from('banners')->join('exams', 'exams.id = banners.exam_id')->where('banners.delete_status', 1)->order_by('banners.order','asc')->get()->num_rows();
        }
        else
        {
 $this->db->select('banners.*,exams.name')->join('exams', 'exams.id = banners.exam_id')->from('banners')->where('banners.delete_status', 1)->order_by('banners.order','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }  
    
    
    public function get_admin_details($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('admin');      
        return $query->result();
    }

    /*---------- /banners ------------*/
    public function get_banners()
    {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('banners');      
        return $query->result();
    }

     public function delete_banners()
    {        
        /*$data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('banners', $data);  
       // echo $this->db->last_query();exit;             
        return true;*/

        $res=$this->common_model->get_table_row('banners',array('id'=>$this->uri->segment(4)),array());
         //echo '<pre>';print_r($res);exit;
        $file = './'.$res['image'];
        if(is_file($file))
        unlink($file);
        
        $this->db->where('id', $this->uri->segment(4));
        $res=$this->db->delete('banners');             
        return $res;
    }

    public function insert_banners($data)
    {
        $this->db->insert('banners', $data);
       //echo $this->db->last_query();exit;            
        return true;
    }

     public function updatepassword($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('admin', $data); 
       // echo $this->db->last_query();exit;     
            return true;

    }

    public function change_banner_status($banner_id, $status)
    {        
        $this->db->where('id', $banner_id);
        $this->db->update('banners', array('status' => $status));
        if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //$this->send_notifications($user_id, $message);  
        }            
        return true;
    }

     public function edit_banners($id)
     {
         //$this->db->order_by('id', 'asc');
         $this->db->where('id', $id);
         $query = $this->db->get('banners'); 
         //var_dump($query);exit; 
         //echo $this->db->last_query();exit;      
         return $query->row_array();
     }

     public function update_banners($data, $id) {
        $this->db->where('id', $id);
        $result=$this->db->update('banners', $data);
        return $result;
    }

    /*---------- /banners ------------*/

   
    /*---------- / Image Gallery ------------*/

     public function all_imageGallery($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'note'
        );
        $search_1 = array
        (
           1 => 'note'
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('images_gallery.id')->from('images_gallery')->order_by('images_gallery.id','asc')->get()->num_rows();
        }
        else
        {
        $this->db->select('images_gallery.*')->from('images_gallery')->order_by('images_gallery.id','desc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }  


    public function get_images_gallery($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);

        $query = $this->db->get('images_gallery');      
        return $query->row_array();
    }

     public function delete_images_gallery()
    {        
        $res=$this->get_images_gallery($this->uri->segment(4));
        $this->db->where('id', $this->uri->segment(4));
       $delete= $this->db->delete('images_gallery');  
       // echo $this->db->last_query();exit;             
       if($delete){
         if($res['image'] !=''){
            $file = './'.$res['image'];
                if(is_file($file))
                unlink($file);
         }
        }
         return true;
    }

    public function insert_images_gallery($data)
    {
        $this->db->insert('images_gallery', $data);
       //echo $this->db->last_query();exit;            
        return true;
    }
    public function edit_images_gallery()
     {
         $this->db->order_by('id', 'asc');
         $this->db->where('id', $this->uri->segment(4));
         $query = $this->db->get('images_gallery'); 
         //var_dump($query);exit; 
         //echo $this->db->last_query();exit;      
         return $query->row();
     }

     public function update_images_gallery($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('images_gallery', $data);
        return true;
    }

    
/*---------- Image Gallery ------------*/

     /*---------- plandetails ------------*/
    
    public function all_plandetails($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'plan_name'
        );
        $search_1 = array
        (
            1 => 'plan_name',
            2 => 'plan_details.plan_type'
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
    return $this->db->select('plan_details.*')->from('plan_details')->where('delete_status',1)->order_by('plan_details.id','asc')->get()->num_rows();
        }
        else
        {
            $this->db->select('plan_details.*')->from('plan_details')->where('delete_status',1)->order_by('plan_details.id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }    

    /*---------- /plandetails ------------*/

        public function insert_plandetails($data)
    {
        $this->db->insert('plan_details', $data);
       //echo $this->db->last_query();exit;            
        return true;
    }

    
     public function get_morecoupons()
    {
        $this->db->where('delete_status', 1);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('coupons');      
        return $query->result();
    }

    public function update_plandetails($data, $plan_id) {
        $this->db->where('id', $plan_id);
        $this->db->update('plan_details', $data);
        return true;
    }
   
    public function edit_plandetails()
    {
       // $data = array('delete_status' => 0);
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        //echo $this->db->last_query();exit;
        $query = $this->db->get('plan_details');       
        return $query->row();
    }



    public function delete_plandetails()
    {        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('plan_details', $data);    
          //echo $this->db->last_query();exit;
        return true;
    }

     public function gets_plandetails()
    {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('plan_details');      
        return $query->result();
    }

    /*---------- coupons ------------*/
    
    public function all_coupons($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'coupon_code',
        );
        $search_1 = array
        (
            1 => 'coupon_code',
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return $this->db->select('id')->from('coupons')->where('delete_status', 1)->order_by('id','asc')->get()->num_rows();  
        }
        else
        {
            $this->db->select('*')->from('coupons')->where('delete_status', 1)->order_by('id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }

    public function insert_coupons($data)
    {
        $this->db->insert('coupons', $data); 
     //echo $this->db->last_query();exit;            
        return true;
    }

    public function edit_coupons()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        $query = $this->db->get('coupons');      
        return $query->row();
    }

    public function get_coupons()
    {
          $this->db->where('delete_status', 1);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('coupons');      
        return $query->result();
    }

    public function update_coupons($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('coupons', $data);
    // echo $this->db->last_query();exit;               
        return true;
    }

    public function delete_coupons()
    {        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('coupons', $data);    
        
        $this->db->where('coupon_id', $this->uri->segment(4));
        $this->db->update('plan_details', $data);
        return true;
    }

    /*---------- /coupons ------------*/

     public function all_payments($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'receipt_id',
            1 => 'user_mobile'
        );
        $search_1 = array
        (
            1 => 'receipt_id',
            2 => 'user_mobile'
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('payment_info.id')->where('payment_info.payment_from','online')->from('payment_info')->order_by('id','desc')->get()->num_rows();
        }
        else
        {
            $this->db->select('payment_info.*')->where('payment_info.payment_from','online')->from('payment_info')->order_by('id','desc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }    

    public function all_offline_payments($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'user_mobile',
            
        );
        $search_1 = array
        (
            1 => 'user_mobile',
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('payment_info.id')->where('payment_info.payment_from','offline')->from('payment_info')->order_by('id','desc')->get()->num_rows();
        }
        else
        {
            $this->db->select('payment_info.*')->where('payment_info.payment_from','offline')->from('payment_info')->order_by('id','desc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }    

    /*---------- /payments ------------*/

    public function getPaymentInfo($id)
    {
        $this->db->select('*');
        $this->db->where('id',$id);
        $this->db->from('payment_info');
        $query = $this->db->get();      
        return $query->row_array();
    }

    public function get_payments()
    {
          $this->db->where('delete_status', 1);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('payments');      
        return $query->result();
    }

     public function delete_payments($payment_id)
    {        
        $this->db->where('id', $payment_id);
        $this->db->update('payments', array('delete_status' => 0));             
        return true;
    }

    public function change_payments_status($payment_id, $status)
    {        
        $this->db->where('id', $payment_id);
        $this->db->update('payments', array('status' => $status));
        //echo $this->db->last_query();exit;
        if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //$this->send_notifications($user_id, $message);  
        }            
        return true;
    }

    /*---------- /payments ------------*/

     /*---------- testseries ------------*/
    
     public function all_testseries($pdata, $getcount=null)
     {
         $columns = array
         (
             0 => 'title',
         );
         $search_1 = array
         (
             1 => 'title',
         );        
         if(isset($pdata['search_text_1'])!="")
         {
             $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
         }
         if($getcount)
         {
             return $this->db->select('id')->from('testseries')->order_by('id','asc')->get()->num_rows();  
         }
         else
         {
             $this->db->select('*')->from('testseries')->order_by('id','asc');
         }
         if(isset($pdata['length']))
         {
             $perpage = $pdata['length'];
             $limit = $pdata['start'];
             $generatesno=$limit+1;
             $orderby_field = $columns[$pdata['order'][0]['column'] ];   
             $orderby = $pdata['order']['0']['dir'];
             $this->db->order_by($orderby_field,$orderby);
             $this->db->limit($perpage,$limit);
         }
         else
         {
             $generatesno = 0;
         }
         $result = $this->db->get()->result_array();       
         foreach($result as $key=>$values)
         {
             $result[$key]['sno'] = $generatesno++;           
            
         }
         return $result;
     }
 
    public function insert_testseries($data)
     {
         $this->db->insert('testseries', $data); 
      //echo $this->db->last_query();exit;            
         return true;
     }
 
     public function edit_testseries()
     {
         $this->db->order_by('id', 'asc');
         $this->db->where('id', $this->uri->segment(4));
         $query = $this->db->get('testseries'); 
         //var_dump($query);exit; 
         //echo $this->db->last_query();exit;      
         return $query->row();
     }
 
     public function update_testseries($data, $id)
     {
         $this->db->where('id', $id);
         $this->db->update('testseries', $data);  
          //echo $this->db->last_query();exit;          
         return true;
     }
 
     public function delete_testseries()
     {        
         $data = array('delete_status' => 0);
         $this->db->where('id', $this->uri->segment(4));
         $this->db->update('testseries', $data);             
         return true;
     }
 
     /*---------- /testseries ------------*/


    public function all_test_series_categories($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'tsc.title',
            1 => 'e.name'
        );
        $search_1 = array
        (
            1 => 'tsc.title',
            2 => 'e.name'
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return $this->db->select('tsc.id')
            ->from('test_series_categories tsc')
            ->join('exams e','e.id=tsc.course_id','left')
            ->order_by('tsc.order','asc')
            ->get()->num_rows();  
        }
        else
        {
            $this->db->select('tsc.*,e.name')
            ->from('test_series_categories tsc')
            ->join('exams e','e.id=tsc.course_id','left')
            ->order_by('tsc.order','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }

   public function insert_test_series_categories($data)
    {
        $this->db->insert('test_series_categories', $data); 
     //   echo $this->db->last_query();exit;            
        return true;
    }

    public function edit_test_series_categories()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        $query = $this->db->get('test_series_categories'); 
        //var_dump($query);exit; 
        //echo $this->db->last_query();exit;      
        return $query->row();
    }

    public function update_test_series_categories($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('test_series_categories', $data);  
        // echo $this->db->last_query();exit;          
        return true;
    }

    public function delete_test_series_categories()
    {        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('test_series_categories', $data); 
     // $this->db->last_query();exit();            
        return true;
    }

    /*---------- /test_series_categories ------------*/

    /*---------- topics ------------*/
    public function topics()
    {   
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('quiz_topicss');      
        return $query->result();
    }
    
    public function all_topics($pdata, $getcount=null)
    {    

      $columns = array
        (
            0 => 'quiz_topics.topic_name',
                1 => 'quiz_topics.title'
        );

        $search_1 = array
        (
            1 => 'exams.name',
             2 => 'subjects.subject_name',
             3 =>'quiz_topics.topic_name',
             4 =>'quiz_topics.title',
             5 =>'quiz_topics.quiz_type',
             


        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return $this->db->select('quiz_topics.id')->join('exams', 'exams.id = quiz_topics.course_id')->join('subjects', 'subjects.id = quiz_topics.subject_id')->from('quiz_topics')->order_by('quiz_topics.id','asc')->get()->num_rows();  
        }
        else
        {
            $this->db->select('quiz_topics.*,exams.name  as ename,subjects.subject_name as sname')->join('exams', 'exams.id = quiz_topics.course_id')->join('subjects', 'subjects.id = quiz_topics.subject_id')->from('quiz_topics')->order_by('quiz_topics.id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;
        }
        return $result;
    }

     public function mainexams()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('exams.delete_status', 1);
       
        $query = $this->db->get('exams');      
        return $query->result();
    }

    public function insert_topics($data)
    {
        $this->db->insert('quiz_topics', $data);
       // echo $this->db->last_query();exit;            
        return true;
    }

    public function edit_topics()
    {
        $this->db->order_by('quiz_topics.id', 'asc');
        $this->db->where('quiz_topics.id', $this->uri->segment(4));
        $this->db->join('exams', 'exams.id = quiz_topics.course_id');
        $this->db->join('subjects', 'subjects.id = quiz_topics.subject_id');
        $this->db->select('quiz_topics.*,exams.name  as course_name,subjects.subject_name as sname');
        $query = $this->db->get('quiz_topics');
          // var_dump($this->db->last_query());exit;
        return $query->row();
    }
    public function update_topics($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('quiz_topics', $data); 
       //echo $this->db->last_query();exit;            
        return true;
    }
    public function getQbnakTopicQuestionsList($topic_id){

        $this->db->select('id,question_unique_id,question_order_no,question,status');
        $this->db->where('qbank_topic_id', $topic_id);
        $this->db->order_by('question_order_no', 'asc');
        $query = $this->db->get('quiz_questions');
          // var_dump($this->db->last_query());exit;
        return $query->result_array();
    }
    public function getTopicwithTopicID($topic_id){
        $this->db->select('*');
        $this->db->where('id', $topic_id);
        $query = $this->db->get('quiz_qbanktopics');
          // var_dump($this->db->last_query());exit;
        return $query->row_array();
    }

  

    public function delete_topics($id)
    {        
                
        $res=$this->common_model->get_table_row('quiz_topics',array('id'=>$id),array());
        $file = './'.$res['banner_image'];
        if(is_file($file))
        unlink($file);
        $file = './'.$res['topic_image'];
        if(is_file($file))
        unlink($file);
        $this->db->where('id', $id);
        $res=$this->db->delete('quiz_topics');

        /*-----Start topics deletion---- */
        $topics=$this->common_model->get_table('quiz_qbanktopics',array('chapter_id'=>$id),array('id','banner_image','icon_image'));
       // echo '<pre>';print_r($topics);exit; 
        if(!empty($topics)){
            foreach($topics as $topic){
            $file = './'.$topic['banner_image'];
            if(is_file($file))
            unlink($file);
            $file = './'.$topic['icon_image'];
            if(is_file($file))
            unlink($file);
            $this->db->where('id', $topic['id']);
            $res=$this->db->delete('quiz_qbanktopics');
            }  
        }
        /*-------End topics deletion---- */


        /*-----start sub topics deletion---- */
        $subtopics=$this->common_model->get_table('quiz_qbanksubtopics',array('chapter_id'=>$id),array('id','banner_image','icon_image')); 
        //echo '<pre>';print_r($subtopics);
        if(!empty($subtopics)){
            foreach($subtopics as $stopic){
            $file = './'.$stopic['banner_image'];
            if(is_file($file))
            unlink($file);
            $file = './'.$stopic['icon_image'];
            if(is_file($file))
            unlink($file);
            $this->db->where('id', $stopic['id']);
            $res=$this->db->delete('quiz_qbanksubtopics');
            }  
        }
        /*-------End sub topics deletion---- */

        /*-----start questions deletion---- */
        $questions=$this->common_model->get_table('quiz_questions',array('topic_id'=>$id),array('id'));
        //echo '<pre>';print_r($questions);exit;
        if(!empty($questions)){ 
        foreach($questions as $que){
            $this->db->where('id', $que['id']);
            $this->db->delete('quiz_questions');
            $this->db->where('question_id', $que['id']);
            $this->db->delete('quiz_options');
            }
        }
        /*-----End questions deletion---- */
            
        return $res;
    
    }

    public function change_topic_status($id, $status)
    {        
        $this->db->where('id', $id);
        $this->db->update('quiz_topics', array('status' => $status));
        /*if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //$this->send_notifications($user_id, $message);  
        } */           
        return true;
    }


        public function get_mainexams1()
    {
        $this->db->where('delete_status', '1');
        $this->db->where('status', 'Active');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('exams');      
        return $query->result();
    }
     public function get_mainexams()
    {
        $this->db->where('delete_status', '1');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('exams');      
        return $query->result();
    }

    public function get_mainsubjects()
    {
        
         $where = '(delete_status=1 and (category_type =2 or category_type=0))';
       $this->db->where($where);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('subjects'); 
        //$this->db->last_query();exit();     
        return $query->result();
    }


    public function gets_topics()
    {   
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('quiz_topics'); 
            //echo $this->db->last_query();exit;     
        return $query->result();
    }

  public function edit_topicss()
  {
    $this->db->order_by('id', 'asc');
    $query = $this->db->get('quiz_topics');      
    return $query->result();
  }

    /*---------- /topics ------------*/

    /*---------- Qbank topics ------------*/
    public function qbanktopics()
    {   
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('quiz_qbanktopics');      
        return $query->result();
    }
    
    public function all_qbanktopics($pdata, $getcount=null)
    {    

      $columns = array
        (
            0 => 'quiz_qbanktopics.name',
            1 => 'quiz_qbanktopics.title'
        );

        $search_1 = array
        (
             1 => 'exams.name',
             2 => 'subjects.subject_name',
             3 =>'quiz_topics.topic_name',
             4 =>'quiz_qbanktopics.name',
             5 =>'quiz_qbanktopics.title',
             


        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return $this->db->select('quiz_qbanktopics.id')
               ->join('exams', 'exams.id = quiz_qbanktopics.course_id')
               ->join('subjects', 'subjects.id = quiz_qbanktopics.subject_id')
               ->join('quiz_topics', 'quiz_topics.id = quiz_qbanktopics.chapter_id')
               ->from('quiz_qbanktopics')
               ->order_by('quiz_qbanktopics.id','asc')
               ->get()->num_rows();  
        }
        else
        {
            $this->db->select('quiz_qbanktopics.*,exams.name  as ename,subjects.subject_name as sname,quiz_topics.topic_name as chapter')
            ->join('exams', 'exams.id = quiz_qbanktopics.course_id')
            ->join('subjects', 'subjects.id = quiz_qbanktopics.subject_id')
            ->join('quiz_topics', 'quiz_topics.id = quiz_qbanktopics.chapter_id')
            ->from('quiz_qbanktopics')
            ->order_by('quiz_qbanktopics.id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;
        }
        return $result;
    }

     public function get_topicsquestionscount($qbank_topic_id){
        $query="select questions_count from quiz_qbanktopics where id='".$qbank_topic_id."' ";
        $dbTopics_questions_count=$this->db->query($query)->row_array();
        $result=$dbTopics_questions_count['questions_count'];
        return $result;
     }


    public function get_testseriesquestions($topic_id){
        $this->db->where('quiz_id', $topic_id);
        $query = $this->db->get('test_series_questions');      
        return $query->result_array();   
     }

     public function get_qbankquestions($topic_id){
        $this->db->where('qbank_topic_id', $topic_id);
        $query = $this->db->get('quiz_questions');      
        return $query->result_array();   
     }


    public function insert_qbanktopics($data)
    {
        $result=$this->db->insert('quiz_qbanktopics', $data);
       //echo $this->db->last_query();exit;
       $course_id=$data['course_id'];
       $subject_id=$data['subject_id'];
       $chapter_id=$data['chapter_id'];

       $this->update_questions_count($course_id,$subject_id,$chapter_id);
       return $result;
    }

    public function update_questions_count($course_id,$subject_id,$chapter_id){
        $equery="select sum(questions_count) as qcount from quiz_qbanktopics where course_id='".$course_id."'";
       $course_qcount=$this->db->query($equery)->row_array();
       $course_qcount_array=array('questions_count'=>$course_qcount['qcount']);

       $squery="select sum(questions_count) as qcount from quiz_qbanktopics where subject_id='".$subject_id."'";
       $subject_qcount=$this->db->query($squery)->row_array();
       $subject_qcount_array=array('questions_count'=>$subject_qcount['qcount']);

       $cquery="select sum(questions_count) as qcount from quiz_qbanktopics where chapter_id='".$chapter_id."'";
       $chapter_qcount=$this->db->query($cquery)->row_array();
       $chapter_qcount_array=array('questions_count'=>$chapter_qcount['qcount']);            
       
        $this->db->update('exams',$course_qcount_array,array('id'=>$course_id));
        $this->db->update('subjects',$subject_qcount_array,array('id'=>$subject_id));
        $this->db->update('quiz_topics',$chapter_qcount_array,array('id'=>$chapter_id));
        
    }

    public function edit_qbanktopics()
    {
        $this->db->order_by('quiz_qbanktopics.id', 'asc');
        $this->db->where('quiz_qbanktopics.id', $this->uri->segment(4));
        $this->db->join('exams', 'exams.id = quiz_qbanktopics.course_id');
        $this->db->join('subjects', 'subjects.id = quiz_qbanktopics.subject_id');
        $this->db->join('quiz_topics', 'quiz_topics.id = quiz_qbanktopics.chapter_id');
        $this->db->select('quiz_qbanktopics.*,exams.name  as course_name,subjects.subject_name as sname,quiz_topics.topic_name as chapter');
        $query = $this->db->get('quiz_qbanktopics');
          // var_dump($this->db->last_query());exit;
        return $query->row();
    }
    public function get_qbankChapters($course_id,$subject_id){
        $this->db->select('quiz_topics.*');
        $this->db->where('quiz_topics.course_id', $course_id);
        $this->db->where('quiz_topics.subject_id', $subject_id);
        $this->db->order_by('quiz_topics.id', 'asc');
        $query = $this->db->get('quiz_topics');
          // var_dump($this->db->last_query());exit;
        return $query->result_array();
    }
    public function get_videoChapters($course_id,$subject_id){
        $this->db->select('videochapters.*');
        $this->db->where('videochapters.course_id', $course_id);
        $this->db->where('videochapters.subject_id', $subject_id);
        $this->db->order_by('videochapters.id', 'asc');
        $query = $this->db->get('videochapters');
          // var_dump($this->db->last_query());exit;
        return $query->result_array();
    }
    public function get_qbankTopics($course_id,$subject_id,$chapter_id){
        $this->db->select('quiz_qbanktopics.*');
        $this->db->where('quiz_qbanktopics.course_id', $course_id);
        $this->db->where('quiz_qbanktopics.subject_id', $subject_id);
        $this->db->where('quiz_qbanktopics.chapter_id', $chapter_id);
        $this->db->order_by('quiz_qbanktopics.id', 'asc');
        $query = $this->db->get('quiz_qbanktopics');
          // var_dump($this->db->last_query());exit;
        return $query->result_array();
    }
    public function get_courseWiseSubjects($course_id){
        $this->db->select('subjects.*');
        $this->db->where('subjects.exam_id', $course_id);
        $this->db->where('subjects.delete_status', '1');
        $this->db->order_by('subjects.id', 'asc');
        $query = $this->db->get('subjects');
          // var_dump($this->db->last_query());exit;
        return $query->result_array();
    }
    public function update_qbanktopics($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('quiz_qbanktopics', $data); 
       //echo $this->db->last_query();exit;
       $course_id=$data['course_id'];
       $subject_id=$data['subject_id'];
       $chapter_id=$data['chapter_id'];

       $this->update_questions_count($course_id,$subject_id,$chapter_id);           
       return true;
    }
    public function updateQbankQuestions($data,$qbank_topic_id){
        $update_qquery=array(
                            'course_id'=>$data['course_id'],
                            'subject_id'=>$data['subject_id'],
                            'topic_id'=>$data['chapter_id'],
                            );
        $this->db->where('qbank_topic_id',$qbank_topic_id);
        $result=$this->db->update('quiz_questions', $update_qquery); 
        return $result;
    }

    public function delete_qbanktopics($id)
    {        
        $res=$this->common_model->get_table_row('quiz_qbanktopics',array('id'=>$id),array());
         //echo '<pre>';print_r($res);exit;
        $file = './'.$res['banner_image'];
        if(is_file($file))
        unlink($file);
        $file = './'.$res['icon_image'];
        if(is_file($file))
        unlink($file);
         
        $this->db->where('id', $id);
        $res=$this->db->delete('quiz_qbanktopics');  
        /*-----start sub topics deletion---- */
        $subtopics=$this->common_model->get_table('quiz_qbanksubtopics',array('topic_id'=>$id),array('id')); 
        if(!empty($subtopics)){
            foreach($subtopics as $stopic){
            $subtopic=$this->common_model->get_table_row('quiz_qbanksubtopics',array('id'=>$stopic['id']),array());
            $file = './'.$subtopic['banner_image'];
            if(is_file($file))
            unlink($file);
            $file = './'.$subtopic['icon_image'];
            if(is_file($file))
            unlink($file);
            $this->db->where('id', $stopic['id']);
            $res=$this->db->delete('quiz_qbanksubtopics');
            }  
        }
        /*-------End sub topics deletion---- */

        /*-----start questions deletion---- */
        $questions=$this->common_model->get_table('quiz_questions',array('qbank_topic_id'=>$id),array('id'));
        if(!empty($questions)){ 
        foreach($questions as $que){
            $this->db->where('id', $que['id']);
            $this->db->delete('quiz_questions');
            $this->db->where('question_id', $que['id']);
            $this->db->delete('quiz_options');
            }
        }
        /*-----End questions deletion---- */
            
        

        return $res;
    }
    public function change_qbanktopics_status($id, $status)
    {        
        $this->db->where('id', $id);
        $this->db->update('quiz_qbanktopics', array('status' => $status));
        /*if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //$this->send_notifications($user_id, $message);  
        } */           
        return true;
    }


       

    /*---------- /Qbank topics ------------*/

    /*---------- Qbank sub topics ------------*/
    public function qbanksubtopics()
    {   
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('quiz_qbanksubtopics');      
        return $query->result();
    }
    
    public function all_qbanksubtopics($pdata, $getcount=null)
    {    

      $columns = array
        (
            0 => 'quiz_qbanksubtopics.name',
            1 => 'quiz_qbanksubtopics.title'
        );

        $search_1 = array
        (
             1 => 'exams.name',
             2 => 'subjects.subject_name',
             3 =>'quiz_topics.topic_name',
             4 =>'quiz_qbanktopics.name',
             5 =>'quiz_qbanksubtopics.name',
             6 =>'quiz_qbanksubtopics.title',
             


        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return  $this->db->select('quiz_qbanksubtopics.id')
               ->join('exams', 'exams.id = quiz_qbanksubtopics.course_id')
               ->join('subjects', 'subjects.id = quiz_qbanksubtopics.subject_id')
               ->join('quiz_topics', 'quiz_topics.id = quiz_qbanksubtopics.chapter_id')
               ->join('quiz_qbanktopics', 'quiz_qbanktopics.id = quiz_qbanksubtopics.topic_id')
               ->from('quiz_qbanksubtopics')
               ->order_by('quiz_qbanksubtopics.id','asc')
               ->get()->num_rows();
               //echo $this->db->last_query();exit;  
        }
        else
        {
            $this->db->select('quiz_qbanksubtopics.*,exams.name  as ename,subjects.subject_name as sname,quiz_topics.topic_name as chapter,quiz_qbanktopics.name as topic')
            ->join('exams', 'exams.id = quiz_qbanksubtopics.course_id')
            ->join('subjects', 'subjects.id = quiz_qbanksubtopics.subject_id')
            ->join('quiz_topics', 'quiz_topics.id = quiz_qbanksubtopics.chapter_id')
            ->join('quiz_qbanktopics', 'quiz_qbanktopics.id = quiz_qbanksubtopics.topic_id')
            ->from('quiz_qbanksubtopics')
            ->order_by('quiz_qbanksubtopics.id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;
        }
        return $result;
    }

     

    public function insert_qbanksubtopics($data)
    {
        $this->db->insert('quiz_qbanksubtopics', $data);
       // echo $this->db->last_query();exit;            
        return true;
    }

    public function edit_qbanksubtopics()
    {
        $this->db->order_by('quiz_qbanksubtopics.id', 'asc');
        $this->db->where('quiz_qbanksubtopics.id', $this->uri->segment(4));
        $this->db->select('quiz_qbanksubtopics.*');
        $query = $this->db->get('quiz_qbanksubtopics');
          // var_dump($this->db->last_query());exit;
        return $query->row();
    }
    
    public function update_qbanksubtopics($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('quiz_qbanksubtopics', $data); 
       //echo $this->db->last_query();exit;            
        return true;
    }
    public function delete_qbanksubtopics($id)
    {        
        $res=$this->common_model->get_table_row('quiz_qbanksubtopics',array('id'=>$id),array());
         //echo '<pre>';print_r($res);exit;
        $file = './'.$res['banner_image'];
        if(is_file($file))
        unlink($file);
        $file = './'.$res['icon_image'];
        if(is_file($file))
        unlink($file);
         
        $this->db->where('id', $id);
        $res=$this->db->delete('quiz_qbanksubtopics');             
        return $res;
    }
    public function change_qbanksubtopics_status($id, $status)
    {        
        $this->db->where('id', $id);
        $this->db->update('quiz_qbanksubtopics', array('status' => $status));
        /*if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //$this->send_notifications($user_id, $message);  
        } */           
        return true;
    }

    /*---------- /Qbank sub topics ------------*/


    
      /*---------- quiz_questions ------------*/
      public function quiz_questions()
      {   
          $this->db->order_by('id', 'asc');
          $query = $this->db->get('quiz_questions');      
          return $query->result();
      }
      
      public function all_quiz_questions($pdata, $getcount=null)
      {    
  
        $columns = array
          (
              0 => 'quiz_questions.question_unique_id'
          );
  
          $search_1 = array
          (
            1 => 'quiz_questions.question_unique_id',
            2 => 'exams.name',
            3 => 'subjects.subject_name',
            4 => 'quiz_topics.topic_name',  
            5 => 'quiz_qbanktopics.name', 
            6 => 'quiz_questions.question',
            7 => 'quiz_questions.answer',
          );        
          if(isset($pdata['search_text_1'])!="")
          {
              $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
          }
          if($getcount)
          {
              return $this->db->select('quiz_questions.id')
              ->join('exams', 'exams.id = quiz_questions.course_id')
              ->join('subjects', 'subjects.id = quiz_questions.subject_id')
              ->join('quiz_topics', 'quiz_topics.id = quiz_questions.topic_id')
              ->join('quiz_qbanktopics', 'quiz_qbanktopics.id = quiz_questions.qbank_topic_id','left')
              ->from('quiz_questions')->order_by('quiz_questions.id','asc')->get()->num_rows();

             // echo $this->db->last_query();exit;
 
          }
          else
          {
              $this->db->select('quiz_questions.*,exams.name  as ename,subjects.subject_name as sname,quiz_topics.topic_name as qtname,quiz_qbanktopics.name as qbanktopicname')
              ->join('exams', 'exams.id = quiz_questions.course_id')
              ->join('subjects', 'subjects.id = quiz_questions.subject_id')
              ->join('quiz_topics', 'quiz_topics.id = quiz_questions.topic_id')
              ->join('quiz_qbanktopics', 'quiz_qbanktopics.id = quiz_questions.qbank_topic_id','left')
              ->from('quiz_questions')->order_by('quiz_questions.id','asc');
          }
          if(isset($pdata['length']))
          {
              $perpage = $pdata['length'];
              $limit = $pdata['start'];
              $generatesno=$limit+1;
              $this->db->limit($perpage,$limit);
          }
          else
          {
              $generatesno = 0;
          }
          $result = $this->db->get()->result_array();       
          foreach($result as $key=>$values)
          {
              $result[$key]['sno'] = $generatesno++;
          }
          return $result;
      }
    

     public function all_search_quiz_questions($pdata, $getcount=null)
      {    
  
        $columns = array
          (
              0 => 'quiz_questions.question_unique_id',
              1 => 'quiz_questions.question',
          );
  
          $search_1 = array
          (
            1 => 'quiz_questions.question_unique_id',
            2 => 'quiz_questions.question',
           
          );        
          if(isset($pdata['search_text_1'])!="")
          {
              $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
          }
          if($getcount)
          {
              $this->db->select('quiz_questions.id');
              $this->db->join('exams', 'exams.id = quiz_questions.course_id');
              $this->db->join('subjects', 'subjects.id = quiz_questions.subject_id');
              $this->db->join('quiz_topics', 'quiz_topics.id = quiz_questions.topic_id');
              $this->db->join('quiz_qbanktopics', 'quiz_qbanktopics.id = quiz_questions.qbank_topic_id','left');
              if($pdata['exam_id'] !=''){
                $this->db->where('quiz_questions.course_id',$pdata['exam_id']);
              }
              if($pdata['subject_id'] !=''){
                $this->db->where('quiz_questions.subject_id',$pdata['subject_id']);
              }
              if($pdata['chapter_id'] !=''){
                $this->db->where('quiz_questions.topic_id',$pdata['chapter_id']);
              }
              if($pdata['topic_id'] !=''){
                $this->db->where('quiz_questions.qbank_topic_id',$pdata['topic_id']);
              }
              $result=$this->db->from('quiz_questions')->order_by('quiz_questions.id','asc')->get()->num_rows();

              //echo $this->db->last_query();exit;
                return $result;
          }
          else
          {
              $this->db->select('quiz_questions.*,exams.name  as ename,subjects.subject_name as sname,quiz_topics.topic_name as qtname,quiz_qbanktopics.name as qbanktopicname');
              $this->db->join('exams', 'exams.id = quiz_questions.course_id');
              $this->db->join('subjects', 'subjects.id = quiz_questions.subject_id');
              $this->db->join('quiz_topics', 'quiz_topics.id = quiz_questions.topic_id');
              $this->db->join('quiz_qbanktopics', 'quiz_qbanktopics.id = quiz_questions.qbank_topic_id','left');
              if($pdata['exam_id'] !=''){
                $this->db->where('quiz_questions.course_id',$pdata['exam_id']);
              }
              if($pdata['subject_id'] !=''){
                $this->db->where('quiz_questions.subject_id',$pdata['subject_id']);
              }
              if($pdata['chapter_id'] !=''){
                $this->db->where('quiz_questions.topic_id',$pdata['chapter_id']);
              }
              if($pdata['topic_id'] !=''){
                $this->db->where('quiz_questions.qbank_topic_id',$pdata['topic_id']);
              }
              $this->db->from('quiz_questions')->order_by('quiz_questions.id','asc');
          }
          if(isset($pdata['length']))
          {
              $perpage = $pdata['length'];
              $limit = $pdata['start'];
              $generatesno=$limit+1;
              $this->db->limit($perpage,$limit);
          }
          else
          {
              $generatesno = 0;
          }
          $result = $this->db->get()->result_array();       
          foreach($result as $key=>$values)
          {
              $result[$key]['sno'] = $generatesno++;
          }
          return $result;
      }
      
  
      public function insert_quiz_questions($data)
      {
          $this->db->insert('quiz_questions', $data);
        //  echo $this->db->last_query();exit;  
          $question_id=$this->db->insert_id();          
          return $question_id;
      }
  
      public function edit_quiz_questions()
      {
          $this->db->order_by('quiz_questions.id', 'asc');
          $this->db->where('quiz_questions.id', $this->uri->segment(4));
          $this->db->join('exams', 'exams.id = quiz_questions.course_id');
           $this->db->join('subjects', 'subjects.id = quiz_questions.subject_id');
          $this->db->join('quiz_topics', 'quiz_topics.id = quiz_questions.topic_id');
           $this->db->join('quiz_qbanktopics', 'quiz_qbanktopics.id = quiz_questions.qbank_topic_id','left');
          $this->db->select('quiz_questions.*,exams.name  as course_name,subjects.subject_name as sname,quiz_topics.topic_name as qtname,quiz_qbanktopics.name as qbanktopicname');
          $query = $this->db->get('quiz_questions');
        //   var_dump($this->db->last_query());exit;
          return $query->row();
      }

      public function edit_quiz_questionsoptions()
      {
          // $this->db->order_by('id', 'asc');
          $this->db->where('question_id', $this->uri->segment(4));
          $query = $this->db->get('quiz_options');
          //echo $this->db->last_query();exit;
          return $query->result_array();
      }
      
      
  
      public function update_quiz_questions($data, $id)
      {
          $this->db->where('id', $id);
          $this->db->update('quiz_questions', $data); 
         //echo $this->db->last_query();exit;            
          return true;
      }
  
      public function delete_quiz_questions()
      {        
          $data = array('delete_status' => 0);
          $this->db->where('id', $this->uri->segment(4));
          $this->db->update('quiz_questions', $data);             
          return true;
      }

    public function change_quiz_question_status($user_id, $status)
    {        
        $this->db->where('id', $user_id);
        $this->db->update('quiz_questions', array('status' => $status));
        return true;
    }

  
      public function gets_quiz_questions()
      {   
          $this->db->order_by('id', 'asc');
          $query = $this->db->get('quiz_questions'); 
              //echo $this->db->last_query();exit;     
          return $query->result();
      }


      public function get_mainquiz_topics()
      {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('quiz_topics'); 
         //   echo $this->db->last_query();exit;     
        return $query->result();
      }
  
      /*---------- /quiz_questions ------------*/

/*----------- /pearl to question --------------*/

 public function all_pearls($pdata, $getcount=null)
      {    
  
        $columns = array
          (
              0 => 'qbank_pearls.title'
          );
  
          $search_1 = array
          (
            1 => 'exams.name',
            2 => 'subjects.subject_name',
            3 => 'quiz_topics.topic_name',  
            4 => 'quiz_qbankopics.name',
            5 => 'qbank_pearls.title',
            6 => 'qbank_pearls.pearl_number',
            7 => 'qbank_pearls.question_unique_id',
          );        
          if(isset($pdata['search_text_1'])!="")
          {
              $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
          }
          if($getcount)
          {
              return $this->db->select('qbank_pearls.id')
                     ->join('exams', 'exams.id = qbank_pearls.course_id')
                     ->join('subjects', 'subjects.id = qbank_pearls.subject_id')
                     ->join('quiz_topics', 'quiz_topics.id = qbank_pearls.chapter_id')
                     ->join('quiz_qbanktopics', 'quiz_qbanktopics.id = qbank_pearls.topic_id')
                     ->from('qbank_pearls')
                     ->order_by('qbank_pearls.id','asc')->get()->num_rows();  
          }
          else
          {
              $this->db->select('qbank_pearls.*,exams.name  as ename,subjects.subject_name as sname,quiz_topics.topic_name as qtname,quiz_qbanktopics.name as qbanktopicname')
              ->join('exams', 'exams.id = qbank_pearls.course_id')
              ->join('subjects', 'subjects.id = qbank_pearls.subject_id')
              ->join('quiz_topics', 'quiz_topics.id = qbank_pearls.chapter_id')
              ->join('quiz_qbanktopics', 'quiz_qbanktopics.id = qbank_pearls.topic_id')
              ->from('qbank_pearls')->order_by('qbank_pearls.id','asc');
          }
          if(isset($pdata['length']))
          {
              $perpage = $pdata['length'];
              $limit = $pdata['start'];
              $generatesno=$limit+1;
              $this->db->limit($perpage,$limit);
          }
          else
          {
              $generatesno = 0;
          }
          $result = $this->db->get()->result_array();       
          foreach($result as $key=>$values)
          {
              $result[$key]['sno'] = $generatesno++;
          }
          return $result;
      }

public function get_quizquestionData($question_id)
      {
          $this->db->order_by('quiz_questions.id', 'asc');
          $this->db->where('quiz_questions.id', $question_id);
          $this->db->join('exams', 'exams.id = quiz_questions.course_id');
           $this->db->join('subjects', 'subjects.id = quiz_questions.subject_id');
          $this->db->join('quiz_topics', 'quiz_topics.id = quiz_questions.topic_id');
           $this->db->join('quiz_qbanktopics', 'quiz_qbanktopics.id = quiz_questions.qbank_topic_id','left');
          $this->db->select('quiz_questions.*,exams.name  as course_name,subjects.subject_name as sname,quiz_topics.topic_name as qtname,quiz_qbanktopics.name as qbanktopicname');
          $query = $this->db->get('quiz_questions');
        //   var_dump($this->db->last_query());exit;
          return $query->row_array();
      }

public function edit_pearls()
      {
          $this->db->order_by('qbank_pearls.id', 'asc');
          $this->db->where('qbank_pearls.id', $this->uri->segment(4));
          $this->db->join('exams', 'exams.id = qbank_pearls.course_id');
           $this->db->join('subjects', 'subjects.id = qbank_pearls.subject_id');
          $this->db->join('quiz_topics', 'quiz_topics.id = qbank_pearls.chapter_id');
           $this->db->join('quiz_qbanktopics', 'quiz_qbanktopics.id = qbank_pearls.topic_id','left');
          $this->db->select('qbank_pearls.*,exams.name  as course_name,subjects.subject_name as sname,quiz_topics.topic_name as qtname,quiz_qbanktopics.name as qbanktopicname');
          $query = $this->db->get('qbank_pearls');
         //   var_dump($this->db->last_query());exit;
          return $query->row_array();
      }
public function get_existingPearls($course_id,$subject_id,$chapter_id,$topic_id){
            $this->db->select('*');
            $this->db->from('qbank_pearls');
            $this->db->where('course_id',$course_id);
            $this->db->where('subject_id',$subject_id);
            $this->db->where('chapter_id',$chapter_id);
            $this->db->where('topic_id',$topic_id);
            //$this->db->group_by('qa.topic_id');
            $this->db->order_by('id','desc');
            //  $this->db->limit($limit, $start);
            $res = $this->db->get();
            return $res->result_array();
       }
    public function insert_pearl($data,$question_unique_id){
     $this->db->insert('qbank_pearls', $data);
       // echo $this->db->last_query();exit;
     $pearl_id=$this->db->insert_id(); 
     if($question_unique_id != ''){
       $this->insert_pearlQuestions($pearl_id,$question_unique_id);
     }       
     return true;
    }
    public function insert_pearlQuestions($pearl_id,$question_unique_id){
        $data=array(
                   'pearl_id'=>$pearl_id,
                   'question_id'=>$question_unique_id,
                   'created_on'=>date('Y-m-d H:i:s')
                   );
        $result=$this->db->insert('qbank_pearls_question_ids', $data);
        return $result;
    }
    public function update_pearl($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('qbank_pearls', $data); 
      // echo $this->db->last_query();exit;        
        return true;
    }
    public function delete_pearls($id)
    {        
        
        $this->db->where('id', $id);
        $res=$this->db->delete('qbank_pearls');             
        return $res;
    }
    public function change_pearl_status($id, $status)
    {        
        $this->db->where('id', $id);
        $this->db->update('qbank_pearls', array('status' => $status));
        return true;
    }
/*----------- /pearl to question --------------*/

        /*---------- test_series_quiz ------------*/
    public function test_series_quiz()
    {   
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('test_series_quiz');      
        return $query->result();
    }
    
    public function get_quiz_topics_info($details){
        $this->db->order_by('id', 'asc');
        $this->db->where('course_id', $details['course_id']);
        $this->db->where('category_id', $details['category_id']);
        $this->db->where('subject_id', $details['subject_id']);
        $this->db->where('status', 'Active');
        $this->db->select('id,title');
        $query = $this->db->get('test_series_quiz');
        return $query->result_array();
    }

    public function get_qbank_quiz($details){
        $this->db->order_by('id', 'asc');
        $this->db->where('course_id', $details['course_id']);
        $this->db->where('category_id', $details['category_id']);
        $this->db->where('status', 'Active');
        $this->db->select('id,title');
        $query = $this->db->get('quiz_topics');
        return $query->result_array();
    }


    public function all_test_series_quiz($pdata, $getcount=null)
    {    

      $columns = array
        (
            0 => 'test_series_quiz.ascription',
               
        );

        $search_1 = array
        (
             1 => 'exams.name',
             2 => 'test_series_categories.title',
             3 =>'test_series_quiz.title',
             4 =>'test_series_quiz.quiz_type'


        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return $this->db->select('test_series_quiz.id')->join('exams', 'exams.id = test_series_quiz.course_id')->join('test_series_categories', 'test_series_categories.id = test_series_quiz.category_id')->from('test_series_quiz')->order_by('test_series_quiz.order','asc')->get()->num_rows();  
        }
        else
        {
            $this->db->select('test_series_quiz.*,exams.name as ename,test_series_categories.title as tcat')->join('exams', 'exams.id = test_series_quiz.course_id')->join('test_series_categories', 'test_series_categories.id = test_series_quiz.category_id')->from('test_series_quiz')->order_by('test_series_quiz.order','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;
        }
        return $result;
    }

     public function mainsexams()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('exams.delete_status', 1);
       
        $query = $this->db->get('exams');      
        return $query->result();
    }

    public function insert_test_series_quiz($data)
    {
        $this->db->insert('test_series_quiz', $data);
       // echo $this->db->last_query();exit;   
        $test_series_id=$this->db->insert_id(); 
        $test_series_array=array('0'=>$test_series_id);
        $query="select id,test_series_ids from packages where package_type='1' ";
        //echo $query;
        $package=$this->db->query($query)->row_array();
        $ex_test_series_ids=explode(',',$package['test_series_ids']);
        $new_test_series_ids=array_merge($ex_test_series_ids,$test_series_array);
        $im_new_test_series_ids=implode(',',$new_test_series_ids);
        $update_array=array(
                    'test_series_ids'=>$im_new_test_series_ids,
                           );
       // echo '<pre>';print_r($update_array);exit;
        $this->db->update('packages',$update_array,array('id'=>$package['id']));          
        return true;
    }

    public function edit_test_series_quiz()
    {
        $data = array('delete_status' => 0);
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        //echo $this->db->last_query();exit;
        $query = $this->db->get('test_series_quiz', $data);       
        return $query->row();
    }

    public function update_test_series_quiz($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('test_series_quiz', $data); 
      // echo $this->db->last_query();exit;   

        $this->db->where('quiz_id',$id);
        $update_questions_data =array('course_id' => $data['course_id']);
        $this->db->update('test_series_questions',$update_questions_data);         
        return true;
    }
    public function update_questionsCousres_data($data, $id){
        $this->db->where('quiz_id',$id);
        $update_questions_data = array('course_id' => $data['course_id'],'category_id'=>$data['category_id']);
        $this->db->update('test_series_questions',$update_questions_data);         
        return true;
    }

    public function delete_test_series_quiz()
    {        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('test_series_quiz', $data);             
        return true;
    }
    public function change_test_series_qiuz_status($id, $status)
    {        
        $this->db->where('id', $id);
        $this->db->update('test_series_quiz', array('status' => $status));
        /*if($status == "Inactive")
        {
            $message = "Your account has been put on hold. Please contact administrator.";
            //$this->send_notifications($user_id, $message);  
        } */           
        return true;
    }

        public function get_mainimpexams()
    {
        $this->db->where('delete_status', 1);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('exams');      
        return $query->result();
    }

    public function get_test_series_categories($course_id)
    {
        $this->db->where('course_id', $course_id);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('test_series_categories');      
        return $query->result();
    }

    public function getTestSeriesTopic($topic_id)
    {
        $this->db->where('id', $topic_id);
        $query = $this->db->get('test_series_quiz');      
        return $query->row_array();
    }

    public function getTestSeriesTopicQuestions($topic_id)
    {   
        $this->db->select('id,question,question_dynamic_id,status,que_number');
        $this->db->where('quiz_id', $topic_id);
        $this->db->order_by('que_number','asc');
        $query = $this->db->get('test_series_questions');      
        return $query->result_array();
    }

    public function updateTestSeriesQuestionOrder($post){

//echo '<pre>';print_r($post);exit();
        foreach($post as $key=>$value){
            
            //$val_ex = explode('^',$key);
            //echo '<pre>';print_r($value);
            // $question_id=$val_ex[1];

            $update_array=array(
                                'que_number'=> $value,
                               );
            $this->db->update('test_series_questions',$update_array,array('id'=>$key));
        }

        return true;
    }



   public function updateQbankQuestionOrder($post){

//echo '<pre>';print_r($post);exit();
        foreach($post as $key=>$value){
            
            $update_array=array(
                                'question_order_no'=> $value,
                               );
            $this->db->update('quiz_questions',$update_array,array('id'=>$key));
        }

        return true;
    }


    public function gets_test_series_quiz()
    {   
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('test_series_quiz'); 
            //echo $this->db->last_query();exit;     
        return $query->result();
    }

    /*---------- /test_series_quiz ------------*/


     /*---------- test_series_questions ------------*/
     public function test_series_questions()
     {   
         $this->db->order_by('que_number', 'asc');
         $query = $this->db->get('test_series_questions');      
         return $query->result();
     }
     
     public function all_test_series_questions($pdata, $getcount=null)
     {    
 
       $columns = array
         (
             0 => 'test_series_questions.question'
         );
 
         $search_1 = array
         (
             1 => 'exams.name',
             2=> 'test_series_categories.title',
             3 => 'test_series_quiz.title',
             4 => 'test_series_questions.question',
             5 => 'test_series_questions.answer',
             6 => 'test_series_questions.question_dynamic_id'
 
         );        
         if(isset($pdata['search_text_1'])!="")
         {
             $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
         }
         if($getcount)
         {
             return $this->db->select('test_series_questions.id')->join('exams', 'exams.id = test_series_questions.course_id')->join('test_series_categories', 'test_series_categories.id = test_series_questions.category_id')->join('test_series_quiz', 'test_series_quiz.id = test_series_questions.quiz_id')->from('test_series_questions')->order_by('test_series_questions.que_number','asc')->get()->num_rows();  
         }
         else
         {
            $this->db->select('test_series_questions.*,exams.name as ename,test_series_quiz.title as qtitle,test_series_categories.title as tscat')->join('exams', 'exams.id = test_series_questions.course_id')->join('test_series_categories', 'test_series_categories.id = test_series_questions.category_id')->join('test_series_quiz', 'test_series_quiz.id = test_series_questions.quiz_id')->from('test_series_questions')->order_by('test_series_questions.que_number','asc');
            // $this->db->last_query();exit(); 
        }
         if(isset($pdata['length']))
         {
             $perpage = $pdata['length'];
             $limit = $pdata['start'];
             $generatesno=$limit+1;
             $this->db->limit($perpage,$limit);
         }
         else
         {
             $generatesno = 0;
         }
         $result = $this->db->get()->result_array();       
         foreach($result as $key=>$values)
         {
             $result[$key]['sno'] = $generatesno++;
         }
         return $result;
     }
 
     
 
     public function insert_test_series_questions($data)
     {
         $this->db->insert('test_series_questions', $data);
    //   echo $this->db->last_query();exit;            
         return $this->db->insert_id();
     }
 
     public function edit_test_series_questions()
     {
        $this->db->order_by('test_series_questions.id', 'asc');
        $this->db->where('test_series_questions.id', $this->uri->segment(4));
        $this->db->join('exams', 'exams.id = test_series_questions.course_id');
        $this->db->join('test_series_categories', 'test_series_categories.id = test_series_questions.category_id');
        $this->db->join('test_series_quiz', 'test_series_quiz.id = test_series_questions.quiz_id');
        $this->db->join('subjects', 'subjects.id = test_series_questions.subject_id');
        $this->db->select('test_series_questions.*,exams.name  as course_name,test_series_categories.title as cat_name,test_series_quiz.title as tname,subjects.subject_name');
        $query = $this->db->get('test_series_questions');  
        // echo $this->db->last_query();exit;
              
         return $query->row();
     }

     public function edit_test_series_question_options(){
        $this->db->where('question_id', $this->uri->segment(4));
        $query = $this->db->get('test_series_options');
        return $query->result_array();
     }
 
     public function update_test_series_questions($data, $id)
     {
         $this->db->where('id', $id);
         $this->db->update('test_series_questions', $data); 
        //echo $this->db->last_query();exit;            
         return true;
     }
 
     public function delete_test_series_questions()
     {        
         $data = array('delete_status' => 0);
         $this->db->where('id', $this->uri->segment(4));
         $this->db->update('test_series_questions', $data);             
         return true;
     }
 
 
     public function gets_test_series_questions()
     {   
         $this->db->order_by('que_number', 'asc');
         $query = $this->db->get('test_series_questions'); 
             //echo $this->db->last_query();exit;     
         return $query->result();
     }


     public function get_mainquiz_test_series_questions()
     {
       $this->db->order_by('que_number', 'asc');
       $query = $this->db->get('test_series_questions'); 
           //echo $this->db->last_query();exit;     
       return $query->result();
     }

   public function change_testseries_que_status($user_id, $status)
    {        
        $this->db->where('id', $user_id);
        $this->db->update('test_series_questions', array('status' => $status));
                 
        return true;
    }


    public function copyTestSeriesQuestions($testquestions,$post)
    {
        
        foreach ($testquestions as $key => $question_id) {

            $questions=$this->db->query("select * from test_series_questions where id='".$question_id."' ")->row_array();
            
            $insert_questions = array(

                'course_id' => $post['course_id'],
                'category_id' => $post['category_id'] ,
                'subject_id' =>  $post['subject_id'],
                'quiz_id' =>  $post['quiz_id'],
                'question_dynamic_id'=> $this->get_test_series_dynamic_id(),
                'math_library' => $questions['math_library'],
                'question' => $questions['question'],
                'question_image' => $questions['question_image'],
                'answer' => $questions['answer'],
                'explanation' => $questions['explanation'],
                'explanation_image' => $questions['explanation_image'],
                'reference' => $questions['reference'],
                'positive_marks' => $questions['positive_marks'],
                'negative_marks' => $questions['negative_marks'],
                'que_number' => $questions['que_number'],
                'question_type' => $questions['question_type'],
                'options' => $questions['options'],
                'status' => $questions['status'],
                'created_on' => date('Y-m-d-H-i-s'),
                    );

            $query=$this->db->insert('test_series_questions',$insert_questions);
            $db_question_id=$this->db->insert_id();
                                //exit();

            $query="select * from test_series_options where question_id='".$questions['id']."'";
            $options=$this->db->query($query)->result_array();

            foreach($options  as $opt){
            $questions_options_array = array(
                'course_id' => $post['course_id'],
                'category_id' => $post['category_id'] ,
                'subject_id' =>  $post['subject_id'],
                'quiz_id' =>  $post['quiz_id'],
                'question_id' =>$db_question_id,
                'options' =>$opt['options'],
                'image'=> $opt['image'],
                'created_on'=> date('Y-m-d H:i:s')
                                );

        $this->db->insert('test_series_options', $questions_options_array);

        $query="select * from test_series_options where question_id='".$db_question_id."' ";
        $opt_questions=$this->db->query($query)->result_array();
        
        $options_encode=json_encode($opt_questions);
        $update_op=array('options'=>$options_encode);
        $this->db->update('test_series_questions',$update_op,array('id'=>$db_question_id)); 

            }
    }

}


public function copyQbankQuestions($testquestions,$post)
    {
        
        foreach ($testquestions as $key => $questions) {
            
            $insert_questions = array(

                'course_id' => $post['course_id'],
                'subject_id' =>  $post['subject_id'],                
                'topic_id' => $post['topic_id'] ,
                'qbank_topic_id' =>  $post['qbank_topic_id'],
                'math_library' => $questions['math_library'],
                'question' => $questions['question'],
                'question_image' => $questions['question_image'],
                'answer' => $questions['answer'],
                'explanation' => $questions['explanation'],
                'explanation_image' => $questions['explanation_image'],
                'difficult_level' => $questions['difficult_level'],
                'reference' => $questions['reference'],
                'tags' => $questions['tags'],
                'previous_appearance' => $questions['previous_appearance'],
                'question_unique_id' => $questions['question_unique_id'],
                'question_order_no' => $questions['question_order_no'],
                'options_data' => $questions['options_data'],
                'status' => $questions['status'],
                'created_on' => date('Y-m-d-H-i-s'),
                    );

            $query=$this->db->insert('quiz_questions',$insert_questions);
            $db_question_id=$this->db->insert_id();
                                //exit();

            $query="select * from quiz_options where question_id='".$questions['id']."'";
            $options=$this->db->query($query)->result_array();

            foreach($options  as $opt){
            $questions_options_array = array(
                'course_id' => $post['course_id'],
                //'category_id' => $post['category_id'] ,
                'subject_id' =>  $post['subject_id'],
                'quiz_id' =>  $post['quiz_id'],
                'question_id' =>$db_question_id,
                'options' =>$opt['options'],
                'image'=> $opt['image'],
                'created_on'=> date('Y-m-d H:i:s')
                                );

        $this->db->insert('quiz_options', $questions_options_array);

        $query="select * from quiz_options where question_id='".$db_question_id."' ";
        $opt_questions=$this->db->query($query)->result_array();
        
        $options_encode=json_encode($opt_questions);
        $update_op=array('options'=>$options_encode);
        $this->db->update('quiz_options',$update_op,array('id'=>$db_question_id)); 

            }
    }

}


    public function moveTestSeriesQuestions($movequestions,$post)
    {
        foreach ($movequestions as $key => $question_id) {
            
            $move_questions = array(

                'course_id' => $post['move_course_id'],
                'category_id' => $post['move_category_id'] ,
                'subject_id' =>  $post['move_subject_id'],
                'quiz_id' =>  $post['move_quiz_id'],
                
                'modified_on' => date('Y-m-d-H-i-s'),
                    );

            $query=$this->db->update('test_series_questions',$move_questions,array('id' =>$question_id ));
           
        }   
    }


        public function moveQbankQuestions($movequestions,$post)
    {
        foreach ($movequestions as $key => $questions) {
            
            $move_questions = array(

                'course_id' => $post['move_course_id'],                
                'subject_id' =>  $post['move_subject_id'],
                'topic_id' => $post['move_topic_id'] ,
                'qbank_topic_id' =>  $post['move_qbank_topic_id'],
                
                'modified_on' => date('Y-m-d-H-i-s'),
                    );

            $query=$this->db->update('quiz_questions',$move_questions,array('id' =>$questions['id'] ));
           
        }   
    }
     /*---------- /test_series_questions ------------*/


     
    
     /*---------- quiz_reports ------------*/
    public function quiz_reports()
    {   
        $this->db->order_by('id', 'asc');
      //  $this->db->where('quiz_reports.delete_status', 1);
        $query = $this->db->get('quiz_reports');      
        return $query->result();
    }
    
    public function all_quiz_reports($pdata, $getcount=null)
    {    

      $columns = array
        (
            0 => 'quiz_reports.reports'
        );

        $search_1 = array
        (
            1 => 'exams.name',
            2 => 'subjects.subject_name'
            


        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return $this->db->select('quiz_reports.id')->join('exams', 'exams.id = quiz_reports.course_id')->join('subjects', 'subjects.id = quiz_reports.subject_id')->from('quiz_reports')->order_by('quiz_reports.id','asc')->get()->num_rows();  
        }
        else
        {
            $this->db->select('quiz_reports.*,exams.name as ename,subjects.subject_name as sname,quiz_topics.topic_name as qtitle,quiz_questions.question as qq,users.name as uname')->join('users', 'users.id = quiz_reports.user_id')->join('quiz_questions', 'quiz_questions.id = quiz_reports.question_id')->join('exams', 'exams.id = quiz_reports.course_id')->join('subjects', 'subjects.id = quiz_reports.subject_id')->join('quiz_topics', 'quiz_topics.id = quiz_reports.topic_id')->from('quiz_reports')->order_by('quiz_reports.id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;
        }
        return $result;
    }

   

    public function insert_quiz_reports($data)
    {
        $this->db->insert('quiz_reports', $data);
       // echo $this->db->last_query();exit;            
        return true;
    }

    public function edit_quiz_reports()
    {
        $data = array('delete_status' => 0);
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        //echo $this->db->last_query();exit;
        $query = $this->db->get('quiz_reports', $data);       
        return $query->row();
    }

    public function update_quiz_reports($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('quiz_reports', $data); 
       //echo $this->db->last_query();exit;            
        return true;
    }

    public function delete_quiz_reports()
    {        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('quiz_reports', $data);             
        return true;
    }

      

    public function gets_quiz_reports()
    {   
        $this->db->order_by('id', 'asc');
       // $this->db->where('delete_status', 1);
        $query = $this->db->get('quiz_reports'); 
            //echo $this->db->last_query();exit;     
        return $query->result();
    }
    

    
    /*---------- /quiz_reports ------------*/


    /*---------- feedback ------------*/
    public function feedback()
    {   
        $this->db->order_by('id', 'asc');
      //  $this->db->where('feedback.delete_status', 1);
        $query = $this->db->get('feedback');      
        return $query->result();
    }
    
    public function all_feedback($pdata, $getcount=null)
    {    

      $columns = array
        (
            0 => 'quiz_topic_reviews.ratings'
        );

        $search_1 = array
        (
            1 => 'exams.name',
            2 => 'subjects.subject_name',
            3 =>'quiz_topics.topic_name',  
            4 => 'quiz_topic_reviews.ratings',
            


        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return $this->db->select('quiz_topic_reviews.id')->join('exams', 'exams.id = quiz_topic_reviews.course_id')->join('subjects', 'subjects.id = quiz_topic_reviews.subject_id')->join('quiz_topics', 'quiz_topics.id = quiz_topic_reviews.topic_id')->from('quiz_topic_reviews')->order_by('quiz_topic_reviews.id','asc')->get()->num_rows();  
        }
        else
        {
            $this->db->select('quiz_topic_reviews.*,exams.name as ename,subjects.subject_name as sname,quiz_topics.topic_name as qtitle,quiz_topic_reviews.ratings as ratre')->join('exams', 'exams.id = quiz_topic_reviews.course_id')->join('subjects', 'subjects.id = quiz_topic_reviews.subject_id')->join('quiz_topics', 'quiz_topics.id = quiz_topic_reviews.topic_id')->from('quiz_topic_reviews')->order_by('quiz_topic_reviews.id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;
        }
        return $result;
    }

   

    public function insert_feedback($data)
    {
        $this->db->insert('feedback', $data);
       // echo $this->db->last_query();exit;            
        return true;
    }

    public function edit_feedback()
    {
        $data = array('delete_status' => 0);
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        //echo $this->db->last_query();exit;
        $query = $this->db->get('feedback', $data);       
        return $query->row();
    }

    public function update_feedback($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('feedback', $data); 
       //echo $this->db->last_query();exit;            
        return true;
    }

    public function delete_feedback()
    {        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('feedback', $data);             
        return true;
    }

      

    public function gets_feedback()
    {   
        $this->db->order_by('id', 'asc');
       // $this->db->where('delete_status', 1);
        $query = $this->db->get('feedback'); 
            //echo $this->db->last_query();exit;     
        return $query->result();
    }
    

    
    /*---------- /feedback ------------*/

    /*---------- quiz_question_bookmarks ------------*/
    public function quiz_question_bookmarks()
    {   
        $this->db->order_by('id', 'asc');
      //  $this->db->where('quiz_question_bookmarks.delete_status', 1);
        $query = $this->db->get('quiz_question_bookmarks');      
        return $query->result();
    }
    
    public function all_quiz_question_bookmarks($pdata, $getcount=null)
    {    

      $columns = array
        (
            0 => 'quiz_question_bookmarks.id'
        );

        $search_1 = array
        (
            1 => 'exams.name',
            2 => 'subjects.subject_name',
            3 =>'quiz_topics.topic_name',  
        


        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return $this->db->select('quiz_question_bookmarks.id')->join('users', 'users.id = quiz_question_bookmarks.user_id')->join('exams', 'exams.id = quiz_question_bookmarks.course_id')->join('subjects', 'subjects.id = quiz_question_bookmarks.subject_id')->join('quiz_topics', 'quiz_topics.id = quiz_question_bookmarks.topic_id')->join('quiz_questions', 'quiz_questions.id = quiz_question_bookmarks.question_id')->from('quiz_question_bookmarks')->order_by('quiz_question_bookmarks.id','asc')->get()->num_rows();  
        }
        else
        {
            $this->db->select('quiz_question_bookmarks.*,exams.name as ename,subjects.subject_name as sname,quiz_topics.topic_name as qtitle,users.name as uname,quiz_questions.question as qq')->join('users', 'users.id = quiz_question_bookmarks.user_id')->join('exams', 'exams.id = quiz_question_bookmarks.course_id')->join('subjects', 'subjects.id = quiz_question_bookmarks.subject_id')->join('quiz_topics', 'quiz_topics.id = quiz_question_bookmarks.topic_id')->join('quiz_questions', 'quiz_questions.id = quiz_question_bookmarks.question_id')->from('quiz_question_bookmarks')->order_by('quiz_question_bookmarks.id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;
        }
        return $result;
    }

   

    public function insert_quiz_question_bookmarks($data)
    {
        $this->db->insert('quiz_question_bookmarks', $data);
       // echo $this->db->last_query();exit;            
        return true;
    }

    public function edit_quiz_question_bookmarks()
    {
        $data = array('delete_status' => 0);
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        //echo $this->db->last_query();exit;
        $query = $this->db->get('quiz_question_bookmarks', $data);       
        return $query->row();
    }

    public function update_quiz_question_bookmarks($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('quiz_question_bookmarks', $data); 
       //echo $this->db->last_query();exit;            
        return true;
    }

    public function delete_quiz_question_bookmarks()
    {        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('quiz_question_bookmarks', $data);             
        return true;
    }

      

    public function gets_quiz_question_bookmarks()
    {   
        $this->db->order_by('id', 'asc');
       // $this->db->where('delete_status', 1);
        $query = $this->db->get('quiz_question_bookmarks'); 
            //echo $this->db->last_query();exit;     
        return $query->result();
    }
   
    /*---------- /quiz_question_bookmarks ------------*/


    public function all_examss($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'name',
        );
        $search_1 = array
        (
            1 => 'name',
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return $this->db->select('id')->from('exams')->where('delete_status', 1)->order_by('id','asc')->get()->num_rows();  
        }
        else
        {
            $this->db->select('*')->from('exams')->where('delete_status', 1)->order_by('id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }

   public function insert_examss($data)
    {
        $this->db->insert('exams', $data); 
        //echo $this->db->last_query();exit;
                  
        return true;
    }

    public function edit_examss()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        $query = $this->db->get('exams'); 
        //var_dump($query);exit; 
        //echo $this->db->last_query();exit;      
        return $query->row();
    }

    public function update_examss($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('exams', $data);  
         //echo $this->db->last_query();exit;          
        return true;
    }

    public function delete_examss()
    {        
        $this->db->where('exam_id', $this->uri->segment(4));
        $result= $this->db->get('chapters')->result_array();
         //print_r($result);
         $id=array();
         foreach($result as $results){
             $id[]=$results['id'];
         }
        // print_r($id);
         //exit;
        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('exams', $data);
        
        $this->db->where('exam_id', $this->uri->segment(4));
        $this->db->update('subjects', $data);
        
        $this->db->where('exam_id', $this->uri->segment(4));
        $this->db->update('chapters', $data);
        
        $this->db->where_in('chapter_id', $id);
        $this->db->update('video_topics', $data);
        
        $this->db->where_in('chapter_id', $id);
        $this->db->update('chapters_slides', $data);

        return true;
    }

    /*---------- /examss ------------*/


    public function all_examsss($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'name',
        );
        $search_1 = array
        (
            1 => 'name',
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return $this->db->select('id')->from('exams')->where('delete_status', 1)->order_by('id','asc')->get()->num_rows();  
        }
        else
        {
            $this->db->select('*')->from('exams')->where('delete_status', 1)->order_by('id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }

   public function insert_examsss($data)
    {
        $this->db->insert('exams', $data); 
        //echo $this->db->last_query();exit;            
        return true;
    }

    public function edit_examsss()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        $query = $this->db->get('exams'); 
        //var_dump($query);exit; 
        //echo $this->db->last_query();exit;      
        return $query->row();
    }

    public function update_examsss($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('exams', $data);  
         //echo $this->db->last_query();exit;          
        return true;
    }

    public function delete_examsss()
    {        
        $this->db->where('exam_id', $this->uri->segment(4));
        $result= $this->db->get('chapters')->result_array();
         //print_r($result);
         $id=array();
         foreach($result as $results){
             $id[]=$results['id'];
         }
        // print_r($id);
         //exit;
        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('exams', $data);
        
        $this->db->where('exam_id', $this->uri->segment(4));
        $this->db->update('subjects', $data);
        
        $this->db->where('exam_id', $this->uri->segment(4));
        $this->db->update('chapters', $data);
        
        $this->db->where_in('chapter_id', $id);
        $this->db->update('video_topics', $data);
        
        $this->db->where_in('chapter_id', $id);
        $this->db->update('chapters_slides', $data);

        return true;
    }

    /*---------- /examsss ------------*/

     /*---------- testseries_bookmarks ------------*/
    public function testseries_bookmarks()
    {   
        $this->db->order_by('id', 'asc');
      //  $this->db->where('testseries_bookmarks.delete_status', 1);
        $query = $this->db->get('test_series_bookmarks');      
        return $query->result();
    }
    
    public function all_testseries_bookmarks($pdata, $getcount=null)
    {    

      $columns = array
        (
            0 => 'test_series_bookmarks.id'
        );

        $search_1 = array
        (
            1 => 'exams.name',
         2 => 'test_series_categories.title'
            


        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
return $this->db->select('test_series_bookmarks.id')->join('exams', 'exams.id = test_series_bookmarks.course_id')
            ->join('users', 'users.id = test_series_bookmarks.user_id')->join('test_series_categories', 'test_series_categories.id = test_series_bookmarks.category_id')->join('test_series_quiz', 'test_series_quiz.id = test_series_bookmarks.quiz_id')->join('test_series_questions', 'test_series_questions.id = test_series_bookmarks.question_id')->from('test_series_bookmarks')->order_by('test_series_bookmarks.id','asc')->get()->num_rows();  
         //   $this->db->last_query();exit();

        }
        else
        {
$this->db->select('test_series_bookmarks.*,users.name as uname,exams.name as ename,test_series_categories.title as tcname,test_series_quiz.title as tsqt,test_series_questions.question as tsqques')->join('users', 'users.id = test_series_bookmarks.user_id')->join('exams', 'exams.id = test_series_bookmarks.course_id')->join('test_series_categories', 'test_series_categories.id = test_series_bookmarks.category_id')->join('test_series_quiz', 'test_series_quiz.id = test_series_bookmarks.quiz_id')->join('test_series_questions', 'test_series_questions.id = test_series_bookmarks.question_id')->from('test_series_bookmarks')->order_by('test_series_bookmarks.id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;
        }
        return $result;
    }

   

    public function insert_testseries_bookmarks($data)
    {
        $this->db->insert('test_series_bookmarks', $data);
       // echo $this->db->last_query();exit;            
        return true;
    }

    public function edit_testseries_bookmarks()
    {
        $data = array('delete_status' => 0);
        $this->db->order_by('id', 'asc');
        $this->db->where('id', $this->uri->segment(4));
        //echo $this->db->last_query();exit;
        $query = $this->db->get('test_series_bookmarks', $data);       
        return $query->row();
    }

    public function update_testseries_bookmarks($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('test_series_bookmarks', $data); 
       //echo $this->db->last_query();exit;            
        return true;
    }

    public function delete_testseries_bookmarks()
    {        
        $data = array('delete_status' => 0);
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('test_series_bookmarks', $data);             
        return true;
    }

      

    public function gets_testseries_bookmarks()
    {   
        $this->db->order_by('id', 'asc');
       // $this->db->where('delete_status', 1);
        $query = $this->db->get('test_series_bookmarks'); 
            //echo $this->db->last_query();exit;     
        return $query->result();
    }
    
    
     public function getUserId($mobile)
    {      
        
        

           $this->db ->where('mobile', $mobile);
   
              $query = $this->db->get('users');
              $result = $query->result_array();

               if(!empty($result))
                  return  $result;
             else   return null;

    }
    
      public function resetTestSeries($quizId,$mobile){
          
          $user =  $this->getUserId($mobile);
          
          if($user == null)
          return false;
        
          $this->db->delete('user_assigned_testseries',array('user_id'=>$user[0]['id'],'quiz_id'=> $quizId));
          $this->db->delete('test_series_marks',array('user_id'=>$user[0]['id'],'quiz_id'=> $quizId));
          $delete = $this->db->delete('test_series_answers_json',array('user_id'=>$user[0]['id'],'quiz_id'=> $quizId));
          if($delete){
            return true;
          }else{
            return false;
          }
    }
       
    /*---------- /testseries_bookmarks ------------*/

/*---------- /insert_export_Qbankquestions ------------*/
public function insert_export_Qbankquestions($question_id,$data,$options_data){

    //echo '<pre>';print_r($question_id);
    //echo '<pre>';print_r($data);
    //echo '<pre>';print_r($options_data);

if($options_data[0]['options'] !=''){
$option1=$options_data[0]['options'];
}else{
$option1= '';
}
if($options_data[0]['image'] !=''){
$option1_image=$options_data[0]['image'];
}else{
$option1_image= '';
}

if($options_data[1]['options'] !=''){
$option2=$options_data[1]['options'];
}else{
$option2= '';
}
if($options_data[1]['image'] !=''){
$option2_image=$options_data[1]['image'];
}else{
$option2_image= '';
}

if($options_data[2]['options'] !=''){
$option3=$options_data[2]['options'];
}else{
$option3= '';
}
if($options_data[2]['image'] !=''){
$option3_image=$options_data[2]['image'];
}else{
$option3_image= '';
}

if($options_data[3]['options'] !=''){
$option4=$options_data[3]['options'];
}else{
$option4= '';
}
if($options_data[3]['image'] !=''){
$option4_image=$options_data[3]['image'];
}else{
$option4_image= '';
}
  
    //$unique_id= mt_rand(10000000, 99999999);
    $unique_id=$this->get_dynamic_id();
    $insert_data=array(
                    'question_id' =>$question_id,
                    'unique_id'   =>$unique_id,
                    'question'    =>$data['question'],
                    'question_image_path'=>$data['question_image'],
                    'option1'=>$option1,
                    'option1_image_path'=>$option1_image,
                    'option2'=>$option2,
                    'option2_image_path'=>$option2_image,
                    'option3'=>$option3,
                    'option3_image_path'=>$option3_image,
                    'option4'=>$option4,
                    'option4_image_path'=>$option4_image,
                    'answer'=>$data['answer'],
                    'explanation' =>$data['explanation'],
                    'explanation_image_path'=>$data['explanation_image'],
                    'reference'=>$data['reference'],
                    'difficult_level '=>$data['difficult_level'],
                    'tags'=>$data['tags'],
                    'previous_appearance'=>$data['previous_appearance'],
                    'created_on'=>$data['created_on'],
                      );
//echo '<pre>';print_r($insert_data);exit;
    $this->db->insert('export_qbank_questions',$insert_data);
    $exam_id=$data['course_id'];
    $subject_id=$data['subject_id'];
    $chapter_id=$data['topic_id'];
    $qbank_topic_id=$data['qbank_topic_id'];
    
    $exam=$this->db->query('select id,name from exams where id="'.$exam_id.'" ')->row_array();
    $subject=$this->db->query('select id,subject_name from subjects where id="'.$subject_id.'" ')->row_array();
    $chapter=$this->db->query('select id,topic_name from quiz_topics where id="'.$chapter_id.'" ')->row_array();
    $qbank_topic=$this->db->query('select id,name from quiz_qbanktopics where id="'.$qbank_topic_id.'" ')->row_array();

    $sub_data=array(
                'course_id'=>$exam_id,
                'subject_id'=>$subject_id,
                'chapter_id'=>$chapter_id,
                'topic_id'=>$qbank_topic_id,
                'course_name'=>$exam['name'],
                'subject_name'=>$subject['subject_name'],
                'chapter_name'=>$chapter['topic_name'],
                'topic_name'=>$qbank_topic['name'],
                'question_unique_id'=>$unique_id,
                'created_on'=>$data['created_on'],
        );
    //echo '<pre>';print_r($sub_data);exit;
    $this->db->insert('export_qbankque_relations',$sub_data);

    $this->db->where('id',$question_id);
    $this->db->update('quiz_questions',array('question_unique_id'=>$unique_id));

}


public function update_export_Qbankquestions($question_id,$data,$options_data){

    if($options_data[0]['options'] !=''){
$option1=$options_data[0]['options'];
}else{
$option1= '';
}
if($options_data[0]['image'] !=''){
$option1_image=$options_data[0]['image'];
}else{
$option1_image= '';
}

if($options_data[1]['options'] !=''){
$option2=$options_data[1]['options'];
}else{
$option2= '';
}
if($options_data[1]['image'] !=''){
$option2_image=$options_data[1]['image'];
}else{
$option2_image= '';
}

if($options_data[2]['options'] !=''){
$option3=$options_data[2]['options'];
}else{
$option3= '';
}
if($options_data[2]['image'] !=''){
$option3_image=$options_data[2]['image'];
}else{
$option3_image= '';
}

if($options_data[3]['options'] !=''){
$option4=$options_data[3]['options'];
}else{
$option4= '';
}
if($options_data[3]['image'] !=''){
$option4_image=$options_data[3]['image'];
}else{
$option4_image= '';
}
  
    
    $update_data=array(
                    'question_id' =>$question_id,
                    'question'    =>$data['question'],
                    'question_image_path'=>$data['question_image'],
                    'option1'=>$option1,
                    'option1_image_path'=>$option1_image,
                    'option2'=>$option2,
                    'option2_image_path'=>$option2_image,
                    'option3'=>$option3,
                    'option3_image_path'=>$option3_image,
                    'option4'=>$option4,
                    'option4_image_path'=>$option4_image,
                    'answer'=>$data['answer'],
                    'explanation' =>$data['explanation'],
                    'explanation_image_path'=>$data['explanation_image'],
                    'reference'=>$data['reference'],
                    'difficult_level '=>$data['difficult_level'],
                    'tags'=>$data['tags'],
                    'previous_appearance'=>$data['previous_appearance'],
                    'modified_on'=>date('Y-m-d H:i:s'),
                    );
//echo '<pre>';print_r($insert_data);exit;
    $this->db->where('question_id',$question_id);
    $this->db->update('export_qbank_questions',$update_data);

    $question_unique_ids=$this->db->query('select id,unique_id from export_qbank_questions where question_id="'.$question_id.'" ')->row_array();
    $question_unique_id=$question_unique_ids['unique_id'];

    $exam_id=$data['course_id'];
    $subject_id=$data['subject_id'];
    $chapter_id=$data['topic_id'];
    $qbank_topic_id=$data['qbank_topic_id'];
    
    $exam=$this->db->query('select id,name from exams where id="'.$exam_id.'" ')->row_array();
    $subject=$this->db->query('select id,subject_name from subjects where id="'.$subject_id.'" ')->row_array();
    $chapter=$this->db->query('select id,topic_name from quiz_topics where id="'.$chapter_id.'" ')->row_array();
    $qbank_topic=$this->db->query('select id,name from quiz_qbanktopics where id="'.$qbank_topic_id.'" ')->row_array();

    $sub_data=array(
                'course_id'=>$exam_id,
                'subject_id'=>$subject_id,
                'chapter_id'=>$chapter_id,
                'topic_id'=>$qbank_topic_id,
                'course_name'=>$exam['name'],
                'subject_name'=>$subject['subject_name'],
                'chapter_name'=>$chapter['topic_name'],
                'topic_name'=>$qbank_topic['name'],
                'question_unique_id'=>$question_unique_id,
                'modified_on'=>$data['modified_on'],
        );
    //echo '<pre>';print_r($sub_data);exit;
    $this->db->where('question_unique_id',$question_unique_id);
    $this->db->update('export_qbankque_relations',$sub_data);

}

public function get_dynamic_id(){

        /* Reference No */
        $reference_id='';
        $this->db->select("*");
        $this->db->from('tbl_dynamic_nos');
        $query = $this->db->get();
        $row_count = $query->num_rows();
        if($row_count > 0){

            $refers_no = $query->row_array();
            $ref_no=$refers_no['question_no']+1;
            $refernce_data = array('question_no' => $ref_no,
                                   'update_date_time'    => date('Y-m-d H:i:s')
                                   );
            $this->db->where('id ',1);
            $update = $this->db->update('tbl_dynamic_nos', $refernce_data);
        }else{

            $ref_no=1;
            $refernce_data = array('question_no' => $ref_no,
                                    'update_date_time'   => date('Y-m-d H:i:s')
                                    );
            $update = $this->db->insert('tbl_dynamic_nos', $refernce_data); 
        }
        
        /*if(strlen($ref_no) == 1){
            $reference_id =  'QUE'.'000'.$ref_no;
        }else if(strlen($ref_no) == 2){
            $reference_id =  'QUE'.'00'.$ref_no;
        }else if(strlen($ref_no) == 3){
            $reference_id =  'QUE'.'0'.$ref_no;
        }else if(strlen($ref_no) == 4){
            $reference_id =  'QUE'.$ref_no;
        }*/
        $reference_id =  'QUE'.$ref_no;
        
        //$reference_id="BBM".$ref_no;
        /* Reference No */
        return $reference_id;
}

/*---------- Packages ------------*/
    public function packages()
    {   
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('packages');      
        return $query->result();
    }
    
    public function all_packages($pdata, $getcount=null)
    {    

      $columns = array
        (
            0 => 'package_name',
        );

        $search_1 = array
        (
             1 => 'package_name',
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return  $this->db->select('id')
                            ->from('packages')
                            ->order_by('order','asc')
                            ->get()->num_rows();
              // echo $this->db->last_query();exit;  
        }
        else
        {
            $this->db->select('*')
            ->from('packages')
            ->order_by('order','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;
        }
        return $result;
    }

     

    public function insert_packages($data,$months,$prices)
    {
        $result=$this->db->insert('packages', $data);
        $package_id=$this->db->insert_id();
        foreach($months as $key=>$value){
            $sub_array=array(
                'package_id'=>$package_id,
                'month'=>$value,
                'price'=>$prices[$key],
                'created_on'=>date('Y-m-d H:i:s')
                            );
            $this->db->insert('package_prices',$sub_array);
        }
       // echo $this->db->last_query();exit;            
        return $package_id;
    }

    public function get_package($id)
    {
        $this->db->where('id', $id);
        $this->db->select('*');
        $query = $this->db->get('packages');
        return $query->row_array();
    }
    public function getentereddbcoupons($package_id){
        $this->db->where('package_id', $package_id);
        $this->db->select('count(id) as coupons_count');
        $query = $this->db->get('coupons');
        return $query->row_array();
    }
    public function getPackagePrices($package_id){
        $this->db->where('package_id', $package_id);
        $this->db->select('*');
        $query = $this->db->get('package_prices');
        return $query->result_array();
    }

    public function view_packages($id){

        $query=$this->db->select('packages.*')
            ->join('exams', 'FIND_IN_SET(exams.id, packages.course_ids)', '', FALSE)
            ->join('subjects', 'FIND_IN_SET(subjects.id, packages.video_subject_ids)', '', FALSE)
            ->join('test_series_quiz', 'FIND_IN_SET(test_series_quiz.id, packages.test_series_ids)', '', FALSE)
            ->select("GROUP_CONCAT(DISTINCT exams.name SEPARATOR ', ') as course_names")
            ->select("GROUP_CONCAT(DISTINCT subjects.subject_name SEPARATOR ', ') as video_subject_names")
            ->select("GROUP_CONCAT(DISTINCT test_series_quiz.title SEPARATOR ', ') as test_series_names")
            ->where('packages.id',$id)
            ->from('packages')
            ->order_by('packages.id','asc');

        $result=$query->get()->row_array();
        //echo $this->db->last_query();exit; 
        return $result;
    }

    public function edit_packages()
    {
        $this->db->where('id', $this->uri->segment(4));
        $this->db->select('*');
        $query = $this->db->get('packages');
        return $query->row();
    }
    
    public function update_packages($data,$months,$prices, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('packages', $data); 
       //echo $this->db->last_query();exit; 
        $this->detelePackagePrices($id);
       foreach($months as $key=>$value){
            $sub_array=array(
                'package_id'=>$id,
                'month'=>$value,
                'price'=>$prices[$key],
                'created_on'=>date('Y-m-d H:i:s')
                            );
            $this->db->insert('package_prices',$sub_array);
        }           
        return true;
    }
    public function detelePackagePrices($package_id){
        $this->db->where('package_id', $package_id);
        $result=$this->db->delete('package_prices');
        return $result;
    }
    public function delete_packages($id)
    {        
        $this->db->where('id', $id);
        $res=$this->db->delete('packages');             
        return $res;
    }
    public function change_packages_status($id, $status)
    {        
        $this->db->where('id', $id);
        $this->db->update('packages', array('status' => $status));          
        return true;
    }
    public function getMultipleSubjectswithSubjectId($qbank_subject_ids){
        $ex_subject_ids=explode(',',$qbank_subject_ids);
        $this->db->select('id,subject_name');
        $this->db->where_in('id',$ex_subject_ids);
        $this->db->from('subjects');
        $query=$this->db->get();
       // echo $this->db->last_query();exit;
        $result= $query->result_array();
        return $result;
    }
    public function getMultipleSubjects($couse_ids){
        $ex_couse_ids=explode(',',$couse_ids);
        $this->db->select('id,subject_name');
        $this->db->where('delete_status','1');
        $this->db->where_in('exam_id',$ex_couse_ids);
        $this->db->from('subjects');
        $query=$this->db->get();
       // echo $this->db->last_query();exit;
        $result= $query->result_array();
        return $result;
    }
    public function getMultipleTestseries($couse_ids){
        $ex_couse_ids=explode(',',$couse_ids);
        $this->db->select('id,title');
        $this->db->where('status','Active');
        $this->db->where_in('course_id',$ex_couse_ids);
        $this->db->from('test_series_quiz');
        $query=$this->db->get();
       // echo $this->db->last_query();exit;
        $result= $query->result_array();
        return $result;
    }
    /*------------ Packages ------------*/

    /*---------- Agents ------------*/
    public function agents()
    {   
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('agents');      
        return $query->result();
    }
    
    public function all_agents($pdata, $getcount=null)
    {    

      $columns = array
        (
            0 => 'agent_name',
        );

        $search_1 = array
        (
             1 => 'agent_name',
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return  $this->db->select('id')
                            ->from('agents')
                            ->order_by('id','desc')
                            ->get()->num_rows();
              // echo $this->db->last_query();exit;  
        }
        else
        {
            $this->db->select('*')
            ->from('agents')
            ->order_by('id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;
        }
        return $result;
    }

    public function insert_agents($data)
    {
        $result=$this->db->insert('agents', $data);
        //echo $this->db->last_query();exit; 
        $agent_id=$this->db->insert_id();           
        return $agent_id;
    }

    public function get_agents($id)
    {
        $this->db->where('id', $id);
        $this->db->select('*');
        $query = $this->db->get('agents');
        return $query->row_array();
    }
    public function getPackages()
    {
        $this->db->select('*');
        $query = $this->db->get('packages');
        return $query->result_array();
    }

    public function view_agents($id){

        $query=$this->db->select('agents.*')
            ->join('packages', 'FIND_IN_SET(packages.id, agents.package_ids)', '', FALSE)
            ->select("GROUP_CONCAT(DISTINCT packages.package_name SEPARATOR ', ') as package_names")
            
            ->where('agents.id',$id)
            ->from('agents')
            ->order_by('agents.id','asc');

        $result=$query->get()->row_array();
        //echo $this->db->last_query();exit; 
        return $result;
    }

    public function edit_agents()
    {
        $this->db->where('id', $this->uri->segment(4));
        $this->db->select('*');
        $query = $this->db->get('agents');
        return $query->row();
    }
    
    public function update_agents($data,$id)
    {
        $this->db->where('id', $id);
        $this->db->update('agents', $data); 
        //echo $this->db->last_query();exit; 
        return true;
    }
    
    public function delete_agents($id)
    {        
        $this->db->where('id', $id);
        $res=$this->db->delete('agents');             
        return $res;
    }
    public function change_agent_status($id, $status)
    {        
        $this->db->where('id', $id);
        $this->db->update('agents', array('status' => $status));          
        return true;
    }
    
    /*------------ Agents ------------*/


    public function insert_access_user($data)
    {
        $result=$this->db->insert('user_access_mobile_nos', $data);
        // echo $this->db->last_query();exit; 
        $agent_id=$this->db->insert_id();           
        return $agent_id;
    }

    public function checkAccessMobile($mobile){
        $query=$this->db->select('*')
             ->where('mobile_no',$mobile)
             ->from('user_access_mobile_nos');
         $result=$query->get()->row_array();
        //echo $this->db->last_query();exit; 
        return $result;
    }

    /*---------- Agent Commmissions ------------*/
    
    
    public function all_agent_commissions($pdata, $getcount=null)
    {    

      $columns = array
        (
            0 => 'agent_name',
            0 => 'agent_mobile',
        );

        $search_1 = array
        (
             1 => 'agent_name',
             0 => 'agent_mobile',
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] ); 
        }
        if($getcount)
        {
            return  $this->db->select('id')
                            ->from('agent_commissions')
                            ->order_by('id','desc')
                            ->get()->num_rows();
              // echo $this->db->last_query();exit;  
        }
        else
        {
            $this->db->select('*')
            ->from('agent_commissions')
            ->order_by('id','asc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;
        }
        return $result;
    }

     public function getCategories($course_id){

        $this->db->select('*');
        $this->db->where('course_id',$course_id);
        $this->db->order_by('title','ASC');
        $query = $this->db->get('test_series_categories');      
        return $query->result_array();

    }
 /*---------- Agent Commmissions ------------*/
     public function get_test_series_dynamic_id(){
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
        return $reference_id;
     }

 /*Qbank Courses*/
    public function get_search_courses(){

        $this->db->select('*');
        $this->db->where('delete_status','1');
        $this->db->order_by('order','asc');
        $query = $this->db->get('exams');  
       //echo $this->db->last_query();    
        return $query->result_array();
    }

    public function QuestionSearch($keyword)
    {
        $this->db->like('item_name',$keyword);
        $query  =   $this->db->get('quiz_questions');
        if ($query->num_rows()>0) {
            return $query->result();
        }       
    }

 /*end Qbank Courses*/     

 
}
?>
