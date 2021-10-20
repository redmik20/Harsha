<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('payment_model');

        date_default_timezone_set('Asia/Kolkata');
	}
	public function index()
	{
		$user_input=array(
        'user_id'=>$_GET['user_id'],
        'package_id'=>$_GET['package_id'],
        'price_id'=>$_GET['price_id'],
        'total_price'=>$_GET['total_price'],
        'coupon_code'=>$_GET['coupon_code'],
        );

        
        

        if (!$user_input['user_id'])
        {
            $error_response = array(
                'status' => false,
                'message' => 'User ID is requried!',
                'response' => array()
            );
            echo json_encode($error_response);exit;
        }

        if (!$user_input['package_id'])
        {
            $error_response = array(
                'status' => false,
                'message' => 'Package ID is requried!',
                'response' => array()
            );
            echo json_encode($error_response);exit;
        }

        if (!$user_input['price_id'])
        {
            $error_response = array(
                'status' => false,
                'message' => 'Price ID is requried!',
                'response' => array()
            );
            echo json_encode($error_response);exit;
        }

        if (!$user_input['total_price'])
        {
            $error_response = array(
                'status' => false,
                'message' => 'Total Price is requried!',
                'response' => array()
            );
            echo json_encode($error_response);exit;
        }

        $receipt_id=$this->payment_model->get_receipt_id();
        $payment_insert_id=$this->payment_model->createPaymentOrder($user_input,$receipt_id);
        if($payment_insert_id !=''){
            $razorpay_order_id=$this->payment_model->makeCurlRequest($receipt_id,$user_input['total_price']);
            $this->payment_model->updateRazorPayOrderId($razorpay_order_id,$payment_insert_id);

           // echo '<pre>';print_r($razorpay_order_id);exit;
            if($razorpay_order_id !=''){
            $data['razorpay_order_id']=$razorpay_order_id;
            $data['total_price']=$user_input['total_price'];
            $data['payment_id']=$payment_insert_id;
            $data['user_data']=$this->payment_model->getUserData($user_input['user_id']);
    		$this->load->view('website/razorpay_manual_payment',$data);
            }
        }else{
            $user_id=$user_input['user_id'];
            $uquery="select id,name,email_id,mobile from users where id='".$user_id."' ";
            $data['user_data']=$this->db->query($uquery)->row_array();
            $data['payment_info']['receipt_id']=$receipt_id;
            $this->load->view('website/razorpay_failed',$data);
        }
	}

	public function automatic()
	{
		$this->load->view('website/razorpay');
	}

	public function success($payment_id){
		$data['payment_id']=$payment_id;
		$this->load->view('website/razorpay_success',$data);
	}

    public function start_preparation(){

    }

    public function try_again(){
        
    }

}
