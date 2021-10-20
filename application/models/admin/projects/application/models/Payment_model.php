<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model{

 public function createPaymentOrder($user_input,$receipt_id){

    date_default_timezone_set('Asia/Kolkata');

 	$user_id=$user_input['user_id'];
 	$package_id=$user_input['package_id'];
 	$price_id=$user_input['price_id'];
 	$total_price=$user_input['total_price'];
 	$coupon_code=$user_input['coupon_code'];

 	$query="select id,name,email_id,mobile from users where id='".$user_id."' ";
 	$user_data=$this->db->query($query)->row_array();

 	$pquery="select id,package_name from packages where id='".$package_id."' ";
 	$package_data=$this->db->query($pquery)->row_array();

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

 	$insert_data=array(
 						'user_id'=> $user_id,
 						'receipt_id'=>$receipt_id,
 						'user_name'=> $user_data['name'],
 						'user_email'=> $user_data['email_id'],
 						'user_mobile'=> $user_data['mobile'],
 						'package_id'=> $package_id,
 						'package_name'=> $package_data['package_name'],
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
 						'final_paid_amount'=>$total_price,
 						'payment_status'=>'started',
 						'created_on'=>date('Y-m-d H:i:s'),
					);
 	$this->db->insert('payment_info',$insert_data);
 	$last_insert_id=$this->db->insert_id();
 	//echo '<pre>';print_r($insert_data);exit;
 	return $last_insert_id;

 }

 public function updateRazorPayOrderId($razorpay_order_id,$payment_insert_id){
 		$update_data=array(
 							'razorpay_order_id'=>$razorpay_order_id,
 							'payment_status'=>'order_created',
 		                  );
 		$this->db->where('id',$payment_insert_id);
 		$result=$this->db->update('payment_info',$update_data);
 		return $result;	
 }
 public function getUserData($user_id){
 	$query="select id,name,email_id,mobile from users where id='".$user_id."' ";
 	$user_data=$this->db->query($query)->row_array();
 	return $user_data;
 }

 public function makeCurlRequest($receipt_id,$total_price){

    $payment_keys=$this->db->query("select * from payment_gateway where id='1'")->row_array();
    $api_key=$payment_keys['key'];
    $api_secret=$payment_keys['secret']; 


 	    $url='https://api.razorpay.com/v1/orders';
 	    $final_price=$total_price*100;
        $razorPayRequest=array(
                            'amount'=> $final_price,
                            'currency'=> 'INR',
                            'receipt'=> $receipt_id
                           );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($razorPayRequest));
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_USERPWD, "rzp_test_BGLPFtM9zlOVDY:P6EVJZ59BYmsx1N0E6sLFGsr"); //issm test keys
        //curl_setopt($ch, CURLOPT_USERPWD, "rzp_live_aNXO7tqUxvv7rl:V0z4mq5OtX2yL8vOd3Kz7fMw"); //issm live keys

        //curl_setopt($ch, CURLOPT_USERPWD, "rzp_test_EKzZtSCRLMnLtC:Ss84oH7P5OhNAG7X1rEPVRwP"); //plato test keys

        curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$api_secret"); //plato live keys
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        curl_close($ch);
        $step1_response=json_decode($data);
        $order_info = (array) $step1_response;

        //echo '<pre>';print_r($tmp);exit;
        if(!empty($order_info)){
            $order_id=$order_info['id'];
    		}else{
    			$order_id='';
    		}

        return $order_id;
 }

 public function get_receipt_id(){

        /* Reference No */

        $this->db->select("*");
        $this->db->from('tbl_dynamic_nos');
        $query = $this->db->get();
        $row_count = $query->num_rows();
        if($row_count > 0){

            $refers_no = $query->row_array();
            $ref_no=$refers_no['receipt_no']+1;
            $refernce_data = array('receipt_no' => $ref_no,
                                   'update_date_time'    => date('Y-m-d H:i:s')
                                   );
            $this->db->where('id ',1);
            $update = $this->db->update('tbl_dynamic_nos', $refernce_data);
        }else{

            $ref_no=1;
            $refernce_data = array('receipt_no' => $ref_no,
                                    'update_date_time'   => date('Y-m-d H:i:s')
                                    );
            $update = $this->db->insert('tbl_dynamic_nos', $refernce_data); 
        }
        
        if(strlen($ref_no) == 1){
            $reference_id =  'rcptid_'.'000'.$ref_no;
        }else if(strlen($ref_no) == 2){
            $reference_id =  'rcptid_'.'00'.$ref_no;
        }else if(strlen($ref_no) == 3){
            $reference_id =  'rcptid_'.'0'.$ref_no;
        }else if(strlen($ref_no) == 4){
            $reference_id =  'rcptid_'.$ref_no;
        }
        
        //$reference_id="BBM".$ref_no;
        /* Reference No */
        return $reference_id;
}



}

