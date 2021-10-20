<?php 


//$api_key='rzp_test_BGLPFtM9zlOVDY';
//$api_secret='P6EVJZ59BYmsx1N0E6sLFGsr'; // issm test keys

//$api_key='rzp_live_aNXO7tqUxvv7rl';
//$api_secret='V0z4mq5OtX2yL8vOd3Kz7fMw';  // issm live keys


//$api_key='rzp_test_EKzZtSCRLMnLtC';
//$api_secret='Ss84oH7P5OhNAG7X1rEPVRwP';  // plato text keys

//$api_key='rzp_live_Cx7apcIOg1pHp6';
//$api_secret='sUw0Dk8vaxETdH2Arlwkje3d';  // plato live keys

$payment_keys=$this->db->query("select * from payment_gateway where id='1'")->row_array();

$api_key=$payment_keys['key'];
$api_secret=$payment_keys['secret'];  

//require('razorpay/config.php');
require('Razorpay/Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$api = new Api($api_key, $api_secret);
$success = false;
$message='';
$error='';

date_default_timezone_set('Asia/Kolkata');
if ( ! empty( $_POST['razorpay_payment_id'] ) ) {

 try
    {
        $attributes = array(
            'razorpay_order_id' => $_POST['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
        $success = true;
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }

    //$api = new Api('YOUR_KEY_ID', 'YOUR_KEY_SECRET');

    //$payment1 = $api->payment->fetch($_POST['razorpay_payment_id']);
    

}

if (($success === true) || ($success == 1))
{
    $html = "Payment success/ Signature Verified";

    $update_array=array(
                        'payment_status'=>'success',
                        'razorpay_payment_id'=>$_POST['razorpay_payment_id'],
                        'razorpay_signature'=>$_POST['razorpay_signature'],
                        'payment_msg'=>'Signature Verified',
                        'payment_created_on'=>date('Y-m-d H:i:s')
                       );
    $this->db->where('id',$payment_id);
    $this->db->update('payment_info',$update_array);

    $ppquery="select * from payment_info where id='".$payment_id."' ";
    $payment_info=$this->db->query($ppquery)->row_array();
    $package_id=$payment_info['package_id'];
    $user_id=$payment_info['user_id'];

    $pquery="select * from packages where id='".$package_id."' ";
    $package_data=$this->db->query($pquery)->row_array();

    $uquery="select id,name,email_id,mobile from users where id='".$user_id."' ";
    $user_data=$this->db->query($uquery)->row_array();

    if(!empty($package_data)){
        if($package_data['course_ids'] !=''){
            $ex_course_ids=explode(',',$package_data['course_ids']);
            foreach($ex_course_ids as $ckey=>$cvalue){
             $check_paid_course=$this->db->query("select id from users_paid_courses where user_id='".$user_id."' and course_id='".$cvalue."' and payment_status='free' ")->row_array();
             if(empty($check_paid_course)){
                $course_data=array(
                                    'user_id'=>$payment_info['user_id'],
                                    'course_id'=>$cvalue,
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'payment_status'=>'paid',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_paid_courses',$course_data);
                }else{
                    $course_data=array(
                                    'user_id'=>$payment_info['user_id'],
                                    'course_id'=>$cvalue,
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'payment_status'=>'paid',
                                    'modified_on'=>date('Y-m-d H:i:s')
                                  );
                    $this->db->update('users_paid_courses',$course_data,array('id'=>$check_paid_course['id'])); 
                }
            }

            foreach($ex_course_ids as $ckey=>$cvalue){
            $check_user_exam=$this->db->query("select id from users_exams where user_id='".$user_id."' and exam_id='".$cvalue."' and payment_type='free' ")->row_array();
                if(empty($check_user_exam)){
                    $course_data1=array(
                                        'user_id'=>$payment_info['user_id'],
                                        'exam_id'=>$cvalue,
                                        'delete_status'=>1,
                                        'payment_type'=>'paid',
                                        'created_on'=>date('Y-m-d H:i:s')
                                      );
                    $this->db->insert('users_exams',$course_data1);
                }else{
                    $course_data1=array(
                                        'user_id'=>$payment_info['user_id'],
                                        'exam_id'=>$cvalue,
                                        'delete_status'=>1,
                                        'payment_type'=>'paid',
                                        'modified_on'=>date('Y-m-d H:i:s')
                                      );
                    $this->db->update('users_exams',$course_data1,array('id'=>$check_user_exam['id']));
                }
            }
        }
        if($package_data['qbank_subject_ids'] !=''){
         $ex_qbankSubject_ids=explode(',',$package_data['qbank_subject_ids']);
         foreach($ex_qbankSubject_ids as $qbankkey=>$qbankvalue){

            $check_qbank_subject=$this->db->query("select id from users_paid_qbanksubjects where user_id='".$user_id."' and subject_id='".$qbankvalue."' and payment_status='free' ")->row_array();
            if(empty($check_qbank_subject)){
                $qbank_data=array(
                                    'user_id'=>$payment_info['user_id'],
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'subject_id'=>$qbankvalue,
                                    'payment_status'=>'paid',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_paid_qbanksubjects',$qbank_data);
                }else{
                $qbank_data=array(
                                    'user_id'=>$payment_info['user_id'],
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'subject_id'=>$qbankvalue,
                                    'payment_status'=>'paid',
                                    'modified_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->update('users_paid_qbanksubjects',$qbank_data,array('id'=>$check_qbank_subject['id']));
                }
            }
         }
        if($package_data['video_subject_ids'] !=''){
        $ex_videoSubject_ids=explode(',',$package_data['video_subject_ids']);
        foreach($ex_videoSubject_ids as $videokey=>$videovalue){
            $check_video_subject=$this->db->query("select id from users_paid_videosubjects where user_id='".$user_id."' and subject_id='".$videovalue."' and payment_status='free' ")->row_array();
            if(empty($check_video_subject)){
                $video_data=array(
                                    'user_id'=>$payment_info['user_id'],
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'subject_id'=>$videovalue,
                                    'payment_status'=>'paid',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_paid_videosubjects',$video_data);
                }else{
                    $video_data=array(
                                    'user_id'=>$payment_info['user_id'],
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'subject_id'=>$videovalue,
                                    'payment_status'=>'paid',
                                    'modified_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->update('users_paid_videosubjects',$video_data,array('id'=>$check_video_subject['id']));
                }
            }
        }
        if($package_data['test_series_ids'] !=''){
            $ex_testSeries_ids=explode(',',$package_data['test_series_ids']);
            foreach($ex_testSeries_ids as $testkey=>$testvalue){
                $check_test_series=$this->db->query("select id from users_paid_testseries where user_id='".$user_id."' and test_series_id='".$testvalue."' and payment_status='free' ")->row_array();
                if(empty($check_test_series)){
                $video_data=array(
                                    'user_id'=>$payment_info['user_id'],
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'test_series_id'=>$testvalue,
                                    'payment_status'=>'paid',
                                    'created_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->insert('users_paid_testseries',$video_data);
                }else{
                $video_data=array(
                                    'user_id'=>$payment_info['user_id'],
                                    'payment_id'=>$payment_id,
                                    'package_id'=>$package_id,
                                    'test_series_id'=>$testvalue,
                                    'payment_status'=>'paid',
                                    'modified_on'=>date('Y-m-d H:i:s')
                                  );
                $this->db->update('users_paid_testseries',$video_data,array('id'=>$check_test_series['id']));
                }
            }
        }
    }

    $coupon_code=$payment_info['coupon_name'];
    $coupon_type=$payment_info['coupon_type'];
    if($coupon_type == 'agent'){
        $a_query="select * from agents where coupon_code='".$coupon_code."' ";
        $agent_coupon=$this->db->query($a_query)->row_array();
        $agent_commissions_array=array(
                        'payment_info_id'=>$payment_info['id'],
                        'package_id'=>$package_id,
                        'agent_name'=>$agent_coupon['agent_name'],
                        'agent_mobile'=>$agent_coupon['mobile'],
                        'agent_specialisation'=>$agent_coupon['specialisation'],
                        'user_name'=>$user_data['name'],
                        'user_mobile'=>$user_data['mobile'],
                        'applied_coupon'=>$payment_info['coupon_name'],
                        'coupon_discount'=>$agent_coupon['discount_percentage'],
                        'user_paid_amt'=>$payment_info['final_paid_amount'],
                        'created_on'=>date('Y-m-d H:i:s')
                    );
       $this->db->insert('agent_commissions',$agent_commissions_array);
      // echo $this->db->last_query();exit;
    }


    
    /*if($coupon_code !=''){
        $cquery="select id,coupon_code,discount_percentage from coupons where coupon_code='".$coupon_code."' ";
        $coupon=$this->db->query($cquery)->row_array();
        if(empty($coupon)){
            $a_query="select * from agents where coupon_code='".$coupon_code."' ";
            $agent_coupon=$this->db->query($a_query)->row_array();
            if(!empty($agent_coupon)){
                $agent_commissions_array=array(
                        'payment_info_id'=>$payment_info['id'],
                        'package_id'=>$package_id,
                        'agent_name'=>$agent_coupon['agent_name'],
                        'agent_mobile'=>$agent_coupon['mobile'],
                        'agent_specialisation'=>$agent_coupon['specialisation'],
                        'user_name'=>$user_data['name'],
                        'user_mobile'=>$user_data['mobile'],
                        'applied_coupon'=>$payment_info['coupon_name'],
                        'coupon_discount'=>$agent_coupon['discount_percentage'],
                        'user_paid_amt'=>$payment_info['final_paid_amount'],
                        'created_on'=>date('Y-m-d H:i:s')
                    );
                $this->db->insert('agent_commissions',$agent_commissions_array);
            }
        }

    }*/

$message='success';

}
else
{
    $ppquery="select id,package_id,user_id,receipt_id from payment_info where id='".$payment_id."' ";
    $payment_info=$this->db->query($ppquery)->row_array();
    $package_id=$payment_info['package_id'];
    $user_id=$payment_info['user_id'];


    $uquery="select id,name,email_id,mobile from users where id='".$user_id."' ";
    $user_data=$this->db->query($uquery)->row_array();

    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
    $update_array=array(
                        'payment_status'=>'failed',
                        'payment_msg'=>$error,
                        'payment_created_on'=>date('Y-m-d H:i:s')
                       );
    $this->db->where('id',$payment_id);
    $this->db->update('payment_info',$update_array);

    $message='failed';
}

//echo $html;
?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>


<div class="container">
    <div class="row text-center">
        <div class="col-sm-6 col-sm-offset-3">
        
        <?php if($message == 'success'){?>
        <br><br> <h2 style="color:#0fad00">Payment Success</h2>
        <!--<img src="http://osmhotels.com//assets/check-true.jpg">-->
        <h3>Dear, <?php echo $user_data['name'];?></h3>
        <p style="font-size:20px;color:#5C5C5C;">Thank you for Payment with Plato.
        </p>
        <br><br>    
        <p>Razor Pay Order ID:<b><?php echo $_POST['razorpay_order_id'];?></b></p>
        <br><br>
        <p>Razor Pay Payment ID:<b><?php echo $_POST['razorpay_payment_id'];?></b></p>
        <br><br>
        <p>Receipt ID:<b><?php echo $payment_info['receipt_id'];?></b></p>
        <br><br>
        <p>Purchased Package:<b><?php echo $payment_info['package_name'];?></b></p>
        <br><br>
        <p>Valid From:<b><?php echo $payment_info['valid_from'];?></b></p>
        <br><br>
        <p>Valid To:<b><?php echo $payment_info['valid_to'];?></b></p>
        <br><br>
        <p>Amount Paid:<b><?php echo $payment_info['final_paid_amount'];?></b></p>

       <!-- <a href="http://platoonline.in/payment/start_preparation" class="btn btn-success"> Start Preparation  </a>-->
       <a href="<?php echo base_url()?>/payment/start_preparation"> <button class="btn btn-success">Start Preparation</button></a>
        <?php }else{?>
        <br><br> <h2 style="color:red">Payment Failed</h2>
        
        <h3>Dear, <?php echo $user_data['name'];?></h3>
        <p style="font-size:20px;color:#5C5C5C;">Sory,Your Payment was failed.
        </p>
        <br><br>
        <p>Razor Pay Reference ID:<b><?php echo $payment_info['receipt_id'];?></b></p>
        <br><br>
        <a href="<?php echo base_url()?>/payment/try_again" class="btn btn-success"> Please try Once.  </a>
           <?php }?>
        <br><br>

        
        </div>
        
    </div>
</div>