<?php 

 //echo '<pre>';print_r($_GET);
 //echo '<pre>';print_r($_POST);
$api_key='rzp_test_BGLPFtM9zlOVDY';
$api_secret='P6EVJZ59BYmsx1N0E6sLFGsr';

/*$generated_signature = hmac_sha256($_POST['razorpay_order_id']."|".$_POST['razorpay_payment_id'], $key_secret);

  if ($generated_signature == $_POST['razorpay_signature']) {
    echo 'payment is successful';
  }*/

/*use Razorpay\Api\Api;
$api = new Api($key_id, $key_secret);
$attributes  = array('razorpay_signature'  => $_POST['razorpay_signature'],  'razorpay_payment_id'  => $_POST['razorpay_payment_id'] ,  'order_id' =>  $_POST['razorpay_order_id'] );
$order  = $api->utility->verifyPaymentSignature($attributes);
echo '<pre>';print_r($order);exit;*/


//require('razorpay/config.php');
require('Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$api = new Api($api_key, $api_secret);
$success = false;
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

}

if ($success === true)
{
    $html = "Payment success/ Signature Verified";
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
}
echo $html;
?>