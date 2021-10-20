<?php
class Main_model extends CI_Model
{

	public function online_paymemts_info(){
		$query=$this->db->query("SELECT `id`, `receipt_id`, `user_id`, `user_name`, `user_email`, `user_mobile`, `package_id`, `package_name`, `price_id`, `valid_months`, `valid_from`, `valid_to`, `price`, `coupon_applied`, `final_paid_amount`, `coupon_type`, `coupon_id`, `coupon_name`, `coupon_discount`, `razorpay_order_id`, `razorpay_payment_id`, `razorpay_signature`, `payment_status`, `payment_msg`, `payment_from`, `created_on`, `payment_created_on` FROM `payment_info` WHERE payment_from='online' ");
		

		return $query;

	}



public function offline_paymemts_info(){
		$query=$this->db->query("SELECT `id`, `receipt_id`, `user_id`, `user_name`, `user_email`, `user_mobile`, `package_id`, `package_name`, `price_id`, `valid_months`, `valid_from`, `valid_to`, `price`, `coupon_applied`, `final_paid_amount`, `coupon_type`, `coupon_id`, `coupon_name`, `coupon_discount`, `razorpay_order_id`, `razorpay_payment_id`, `razorpay_signature`, `payment_status`, `payment_msg`, `payment_from`, `created_on`, `payment_created_on` FROM `payment_info` WHERE payment_from='offline' ");
		

		return $query;

	}

	public function download_unregiter_users(){

        $this->db->select('*');
        $this->db->from('unregister_users');
        $this->db->order_by('id','desc');
        $query=$this->db->get();
		    return $query;
	}

}

?>