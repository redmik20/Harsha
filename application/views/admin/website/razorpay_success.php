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
    //$this->db->where('id',$payment_id);
    $this->db->update('students_before_admissions',$update_array,array('id'=>$payment_id));

    $ppquery="select * from students_before_admissions where id='".$payment_id."' ";
    
    $update_payment_info=array(
                        'payment_status'=>'success',
                        'payment_msg'=>'Signature Verified',
                        'payment_created_on'=>date('Y-m-d H:i:s')
                       );
    //$this->db->where('id',$payment_id);
    $this->db->update('students_before_admissions',$update_payment_info,array('id'=>$payment_id));

    $message='success';
    $ppquery="select b.batch_name,sb.* from tbl_students_before_admissions sb inner join tbl_batchs b on b.id=sb.batch_id where sb.id='".$payment_id."' ";
    //echo $ppquery;exit;
    $payment_info=$this->db->query($ppquery)->row_array();

    /*--start insert student record in dbmci database---*/

    
    $insert_id=$this->common_model->insert_student_record_mainDB($payment_info);


    /*--stop insert student record in dbmci database---*/
}
else
{
    $ppquery="select id,student_name,batch_id,receipt_id,student_paid_amt from tbl_students_before_admissions where id='".$payment_id."' ";
    $payment_info=$this->db->query($ppquery)->row_array();
    


    

    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
    $update_array=array(
                        'payment_status'=>'failed',
                        'payment_msg'=>$error,
                        'payment_created_on'=>date('Y-m-d H:i:s')
                       );
    $this->db->where('id',$payment_id);
    $this->db->update('students_before_admissions',$update_array);

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
        <h3>Dear, <?php echo $payment_info['student_name'];?></h3>
        <p style="font-size:20px;color:#5C5C5C;">Thank you for Payment with DBMCI.
        </p>
        <br><br>    
        <p>Razor Pay Order ID:<b><?php echo $_POST['razorpay_order_id'];?></b></p>
        <br><br>
        <p>Razor Pay Payment ID:<b><?php echo $_POST['razorpay_payment_id'];?></b></p>
        <br><br>
        <p>Receipt ID:<b><?php echo $payment_info['receipt_id'];?></b></p>
        <br><br>
        <p>Batch Name:<b><?php echo $payment_info['batch_name'];?></b></p>
        <br><br>
        <p>Valid From:<b><?php echo $payment_info['valid_from'];?></b></p>
        <br><br>
        <p>Valid To:<b><?php echo $payment_info['valid_to'];?></b></p>
        <br><br>
        <p>Amount Paid:<b><?php echo $payment_info['student_paid_amt'];?> Rs/-</b></p>

       <!-- <a href="http://platoonline.in/payment/start_preparation" class="btn btn-success"> Start Preparation  </a>-->
       <!-- <a href="<?php echo base_url()?>/payment/start_preparation"> <button class="btn btn-success">Start Preparation</button></a> -->
        <?php }else{?>
        <br><br> <h2 style="color:red">Payment Failed</h2>
        
        <h3>Dear, <?php echo $payment_info['student_name'];?></h3>
        <p style="font-size:20px;color:#5C5C5C;">Sory,Your Payment was failed.
        </p>
        <br><br>
        <p>Razor Pay Reference ID:<b><?php echo $payment_info['receipt_id'];?></b></p>
        <br><br>
        <!-- <a href="<?php echo base_url()?>/payment/try_again" class="btn btn-success"> Please try Once.  </a> -->
           <?php }?>
        <br><br>

        
        </div>
        
    </div>
</div>