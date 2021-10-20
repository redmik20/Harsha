<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'libraries/RESTful/REST_Controller.php';
class Ws extends REST_Controller {
	
	protected $client_request = NULL;
	
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		error_reporting(0);
		set_time_limit(0);
		ini_set('memory_limit', '-1');
		
		$this->load->helper('app/ws_helper');
		$this->load->model('app/ws_model');
		$this->load->model('email_model');
		$this->load->model('homemodel');
		$this->load->model('vendormodel');
		
		$this->client_request = new stdClass();
		$this->client_request = json_decode(file_get_contents('php://input', true));
		$this->client_request = json_decode(json_encode($this->client_request), true);
	}

	/*-------------------- User -----------------------*/

	/*
	*	Register User Using Mobile Number
	*/
	function register_user_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$mobile)
		{
			$response = array('status' => false, 'message' => 'Enter Mobile Number!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		
		if(!$email_id)
		{
			$response = array('status' => false, 'message' => 'Enter Email ID!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		if(!$password)
		{
			$response = array('status' => false, 'message' => 'Enter Password!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$check_mobile = check_user_mobile_exists($mobile);
		if(!empty($check_mobile))
		{
			$response = array('status' => false, 'message' => 'Mobile Number Already Exists!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		
		$check_email_id = check_user_email_id_exists($email_id);
		if(!empty($check_email_id))
		{
			$response = array('status' => false, 'message' => 'Email ID Already Exists!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		if($otp_confirmed == "No")
        {
            $otp = mt_rand(100000, 999999);
            $message = "Dear User, $otp is One time password (OTP) for Smart Venue. Thak You.";
            //SendSMS($mobile, $message);
            $response = array('status' => true, 'message' => 'Otp sent successfully!', 'response' => "$otp");
           TrackResponse($user_input, $response);		
		   $this->response($response);exit;
        }
		
		$data = array(
			'name' => $name,
			'mobile' => $mobile,
			'email_id' => $email_id, 
			'password' => md5($password), 
			'created_on' => date('Y-m-d H:i:s')
			);

		$user_id = $this->ws_model->set_users($data);
		$users = user_by_id($user_id);
		if(empty($users))
		{
			$response = array('status' => false, 'message' => 'User Registration Failed!', 'response' => array());
		}
		else
		{
			// $Message = 'Dear Customer '.$rand.' is your One Time Password for Food Safari. Thank You.';
			// SendSMS($email_id, 'One Time Password', $Message);
			$response = array('status' => true, 'message' => 'User Registration Successful!', 'response' => $users);
		}
		TrackResponse($user_input, $response);		
		$this->response($response);
	}

	/*
	*	User Login
	*/
	function user_login_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		$user_deleted = $this->ws_model->check_user_deleted($mobile);
		if(empty($user_deleted))
		{
			$response = array('status' => false, 'message' => 'Not a registered Mobile Number!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$user_status = $this->ws_model->check_user_status($mobile);
		if(empty($user_status))
		{
			$response = array('status' => false, 'message' => 'Your account has been put on hold. Please contact Administrator!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$UserLogin = $this->ws_model->user_login($mobile, $password);
		//echo $this->db->last_query();exit;
		if(empty($UserLogin))
		{
			$response = array('status' => false, 'message' => 'Login Failed. Please try again!', 'response' => array());
		}
		else
		{
			$check_mobile = check_user_mobile_exists($mobile);
			$response = array('status' => true, 'message' => 'Login Successful!', 'response' => $check_mobile);
		}
		
		TrackResponse($user_input, $response);		
		$this->response($response);
	}

	/*
	*	Update Device Token
	*/
	function update_user_device_token_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		$update_token = $this->ws_model->update_user_device_token($user_id, $token, $ios_token);
		//echo $this->db->last_query();exit;
		if(empty($update_token))
		{
			$response = array('status' => false, 'message' => 'Device Token updation failed!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Device Token Updated Successfully!', 'response' => $update_token);
		}
		
		TrackResponse($user_input, $response);		
		$this->response($response);
	}

	/*
	*	User Forgot Password
	*/
	function user_forgot_password_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array(), 'OTP' => array());
		$user_input = $this->client_request;
		extract($user_input);

		if(!$mobile)
		{
			$response = array('status' => false, 'message' => 'Enter Mobile Number!', 'response' => array(), 'OTP' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$user_deleted = $this->ws_model->check_user_deleted($mobile);
		if(empty($user_deleted))
		{
			$response = array('status' => false, 'message' => 'Not a registered Mobile Number!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$user_status = $this->ws_model->check_user_status($mobile);
		if(empty($user_status))
		{
			$response = array('status' => false, 'message' => 'Your account has been put on hold. Please contact Administrator!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		$user_details = check_user_mobile_exists($mobile);
		//echo $this->db->last_query();
		$rand = mt_rand(100000, 999999);
		$otp = array('otp' => $rand);
		if(empty($user_details))
		{
			$response = array('status' => false, 'message' => 'Mobile Number not registered!', 'response' => array(), 'OTP' => array());			
		}
		else
		{
			$Message = 'Dear Customer '.$rand.' is your One Time Password for Food Safari. Thank You.';
			//SendSMS($mobile, $Message);
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $user_details, 'OTP' => $otp);
		}		
		TrackResponse($user_input, $response);		
		$this->response($response);
	}

	/*
	*	Change Password
	*/
	function user_update_password_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		if(!$user_id || !$password)
		{
			$response = array('status' => false, 'message' => 'User Id or Password not found!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		$data = array(
			'password' => md5($password),			
			'modified_on' => date('Y-m-d H:i:s')
			);

		$update_user = $this->ws_model->update_user($data, $user_id);
		//echo $this->db->last_query();exit;
		if($update_user === FALSE)
		{
			$response = array('status' => false, 'message' => 'Password Updation Failed!', 'response' => array());
		}
		else
		{
			//SendSMS($mobile, 'Dear Customer '.$rand.' is your One Time Password for Poprebates. Thank You.');
			$user_details = user_by_id($user_id);
			$response = array('status' => true, 'message' => 'Password Updation Successful!', 'response' => $user_details);
		}		
		TrackResponse($user_input, $response);		
		$this->response($response);
	}

	/*
	*	Get User Details
	*/
	function user_profile_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		$user_details = user_by_id($user_id);
		//echo $this->db->last_query();exit;
		if(empty($user_details))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $user_details);
		}

		TrackResponse($user_input, $response);		
		$this->response($response);
	}

	/*
	*	Update User Profile
	*/
	function update_user_profile_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);		
		
		$data = array(
			'name' => $name,
			//'mobile' => $mobile,
			'email_id' => $email_id, 
			'modified_on' => date('Y-m-d H:i:s')
			);

		$update_user = $this->ws_model->update_user($data, $user_id);
		if($update_user === FALSE)
		{
			$response = array('status' => false, 'message' => 'User Updation Failed!', 'response' => array());
		}
		else
		{
			//SendSMS($mobile, 'Dear Customer '.$rand.' is your One Time Password for Poprebates. Thank You.');
			$user_details = user_by_id($user_id);
			$response = array('status' => true, 'message' => 'User Updation Successful!', 'response' => $user_details);
		}
		
		TrackResponse($user_input, $response);		
		$this->response($response);
	}

	/*
	*	Search Function Halls
	*/
	function venues_list_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);

		$data = array(
			'city_id' => $city_id,
			'area_id' => $area_id,
			'category_id' => $category_id,
			'event_type_id' => $event_type_id,
			'date' => $date,
			'capacity' => $capacity,
			'user_id' => $user_id,
			'ac' => $ac,
			'veg' => $veg,
			'sort' => $sort,
			'booking_type' => $booking_type,
			'venue_type' => $venue_type
		);

		$venues_list = $this->ws_model->venues_list($data);
		$advertisements = $this->homemodel->get_advertisements();
		//echo $this->db->last_query();exit;
		if(empty($venues_list))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $venues_list, 'advertisements' => $advertisements);
		}

		TrackResponse($user_input, $response);		
		$this->response($response);
	}

	/*
	*	Venue Details
	*/
	function user_venue_details_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);		

		$user_venue_details = $this->ws_model->user_venue_details($venue_id, $date, $user_id);
		$pricing = $this->ws_model->venue_extra_pricing_data($venue_id);
		//echo $this->db->last_query();exit;
		if(empty($user_venue_details))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $user_venue_details, 'pricing' => $pricing);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	public function submit_ratings_post()
	{		
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);	

		$data = array(
			'user_id' => $user_id,
			'venue_id' => $venue_id,
			'ratings' => $ratings,
			'reviews' => $reviews,
			'created_on' => date('Y-m-d H:i:s')
			);
		$this->db->insert('venue_ratings', $data);
		$venue_ratings = $this->ws_model->venue_ratings($venue_id);
		$response = array('status' => true, 'message' => 'Rating Submitted Successfully!', 'response' => $venue_ratings);
		$this->response($response);
	}

	/*
	*	Search Venues
	*/
	function search_venues_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		
		$venues = $this->ws_model->search_venues($keyword);
		//echo $this->db->last_query();exit;
		if(empty($venues))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $venues);
		}

		TrackResponse($user_input, $response);		
		$this->response($response);
	}

	/*
	*	Place Order
	*/
	function place_order_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);		
		
		$booking_id = mt_rand(100000, 999999);
		$data = array(
			'booking_id' => $booking_id,
			'user_id' => $user_id,
			'category_id' => $category_id,
			'vendor_id' => $vendor_id,
			'venue_id' => $venue_id,
			'slot_id' => $slot_id,
			'total_capacity' => $total_capacity,
			'capacity' => $capacity,
			'amount_paid' => $amount_paid,
			'booking_type' => $booking_type,
			'payment_status' => $payment_status,
			'booked_for' => $booked_for,
			'created_on' => date('Y-m-d H:i:s')
			);

		if($payment_status == "paid")
		{
			$data['status'] = "accepted";
		}
		$place_order = $this->ws_model->place_order($data, $vendor_id);
		if($place_order == 0)
		{
			$response = array('status' => false, 'message' => 'Order placing failed!', 'response' => array());
		}
		else
		{
			$extradata = array();
			if($platform == "ios")
			{
				if(!empty($extra_data))
				{
					foreach($extra_data as $ext)
					{	
						$extradata[] = array(
							'order_id' => $place_order,
							'e_id' => $ext['e_id'],
							'title' => $ext['title'],
							'quantity' => $ext['quantity'],
							'price' => $ext['price'],
							'total' => $ext['total'],
							'created_on' => date('Y-m-d H:i:s')
						);
					}
				}
			}
			else
			{
	            if(!empty($extra_data))
	            {
	            	$extra_data = json_decode($extra_data);
	                foreach($extra_data as $ext)
	                {
	                    $extradata[] = array(
							'order_id' => $place_order,
							'e_id' => $ext->e_id,
							'title' => $ext->title,
							'quantity' => $ext->quantity,
							'price' => $ext->price,
							'total' => $ext->total,
							'created_on' => date('Y-m-d H:i:s')
						);
	                }
	            }
			}
			if(!empty($extradata))
			{
				$this->db->insert_batch('sv_order_extras', $extradata);
			}

			$user = get_user_details_with_order_id($order_id);
			$this->homemodel->send_booking_successful_email($user->email_id, $place_order);
			SendSMS($user->mobile, 'Dear Customer your order with '.$booking_id.' is placed Successfully. Thank You.');

			$response = array('status' => true, 'message' => 'Order Placed Successfully!', 'response' => array());
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	user_bookings
	*/
	function user_bookings_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);		

		$user_bookings = $this->ws_model->user_bookings($user_id);
		//echo $this->db->last_query();exit;
		if(empty($user_bookings))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $user_bookings);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Update Payment Status
	*/
	function update_payment_status_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);
		
		$data = array(			
			'payment_status' => $payment_status,
			'modified_on' => date('Y-m-d H:i:s')
			);

		$update_payment_status = $this->ws_model->update_payment_status($data, $order_id);
		if($update_payment_status === false)
		{
			$response = array('status' => false, 'message' => 'Payment Status Updation Failed!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Payment Status updated Successfully!', 'response' => array());
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	User cancel Booking
	*/
	function user_cancel_booking_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$category_details = $this->ws_model->get_category_details_using_order_id($order_id);
		$order_details = order_details($order_id);

		$from_range = $category_details->from_range;
		$to_range = $category_details->to_range;
		$refund_percentage = $category_details->cancel_percent;
		$amount_paid = $category_details->amount_paid;

		$today = date('Y-m-d');
		$created_on = date_create($created_on);
		$booked_for = date_create($booked_for);
		$diff = date_diff($created_on,$booked_for);
		$days_left = $diff->format("%a");

		$cancellation = "";
		if($days_left >= $to_range)
		{
			$todays_date = date_create($today);
			$difff = date_diff($created_on,$todays_date);
			$days_leftt = $difff->format("%a");
			if($days_leftt > $from_range && $days_leftt <= $to_range)
			{
				$cancellation = "Paid Cancellation";
				$refund_amount = ($amount_paid / 100) * $refund_percentage;
			}
			elseif($days_leftt < $from_range)
			{
				$cancellation = "Free Cancellation";
				$refund_percentage = 0;
				$refund_amount = $amount_paid;
			}
			elseif($days_leftt > $to_range)
			{
				$response = array('status' => false, 'message' => 'Dear User, You passed cancellation date. Now you cannot cancel the order!');
				TrackResponse($vendor_input, $response);
				$this->response($response);
			}
		}
		elseif($days_left < $to_range)
		{
			$response = array('status' => false, 'message' => 'Dear User, Your order is confirmed. Now you cannot cancel the order!');
			TrackResponse($vendor_input, $response);
			$this->response($response);
		}

		$data = array(			
			'status' => 'cancelled by user',
			'cancellation_reason' => $cancellation,
			'refund_percentage' => $refund_percentage,
			'refund_amount' => $refund_amount,
			'cancelled_date' => date('Y-m-d H:i:s'),
			'modified_on' => date('Y-m-d H:i:s')
			);

		$user_cancel_booking = $this->ws_model->user_cancel_booking($data, $order_id);
		if($user_cancel_booking === false)
		{
			$response = array('status' => false, 'message' => 'Cancellation Failed!', 'response' => array());
		}
		else
		{
			if($cancellation == "Free Cancellation")
			{
				$response = array('status' => true, 'message' => 'Order Cancelled Successfully. Total amount will be refunded within 48 hours.', 'response' => array());
			}
			else
			{
				$user = get_user_details_with_order_id($order_id);
				$this->homemodel->send_booking_cancel_email($user->email_id, $order_id);
				SendSMS($user->mobile, 'Dear Customer, your order with Booking Id: '.$order_details->booking_id.' is Cancelled Successfully. Thank You.');

				$response = array('status' => true, 'message' => 'Order Cancelled Successfully. '.$refund_percentage.' % of amount will be refunded within 48 hours!', 'response' => array());
			}			
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Add to Favourites
	*/
	function add_to_favourites_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);
		
		$data = array(			
			'user_id' => $user_id,
			'vendor_id' => $vendor_id,
			'venue_id' => $venue_id,
			'created_on' => date('Y-m-d H:i:s')
			);

		$add_to_favourites = $this->ws_model->add_to_favourites($data);
		if($add_to_favourites == 1)
		{			
			$response = array('status' => true, 'query' => 'insert', 'message' => 'Venue added to Favourites!');
		}
		elseif($add_to_favourites == 0)
		{
			$response = array('status' => true, 'query' => 'delete', 'message' => 'Venue removed from Favourites!');
		}
		else
		{
			$response = array('status' => false, 'message' => 'Updation Failed!');
		}	
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Favourites
	*/
	function favourites_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);		

		$favourites = $this->ws_model->favourites($user_id);
		//echo $this->db->last_query();exit;
		if(empty($favourites))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $favourites);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	User Notifications
	*/
	function user_notifications_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);		

		$user_notifications = $this->ws_model->user_notifications();
		//echo $this->db->last_query();exit;
		if(empty($user_notifications))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $user_notifications);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*-------------------- /User -----------------------*/

	/*-------------------- Vendor -----------------------*/

	/*
	*	Register Vendor Using Mobile Number
	*/
	function register_vendor_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);
		if(!$mobile)
		{
			$response = array('status' => false, 'message' => 'Enter Mobile Number!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		
		if(!$email_id)
		{
			$response = array('status' => false, 'message' => 'Enter Email ID!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		if(!$password)
		{
			$response = array('status' => false, 'message' => 'Enter Password!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		$check_mobile = check_vendor_mobile_exists($mobile);
		if(!empty($check_mobile))
		{
			$response = array('status' => false, 'message' => 'Mobile Number Already Exists!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}
		
		$check_email_id = check_vendor_email_id_exists($email_id);
		if(!empty($check_email_id))
		{
			$response = array('status' => false, 'message' => 'Email ID Already Exists!', 'response' => array());
			TrackResponse($user_input, $response);		
			$this->response($response);
		}

		if($otp_confirmed == "No")
        {
            $otp = mt_rand(100000, 999999);
            $message = "Dear User, $otp is One time password (OTP) for Smart Venue. Thak You.";
            //SendSMS($mobile, $message);
            $response = array('status' => true, 'message' => 'Otp sent successfully!', 'response' => "$otp");
           TrackResponse($user_input, $response);		
		   $this->response($response);exit;
        }
		
		$data = array(
			'name' => $name,
			'mobile' => $mobile,
			'email_id' => $email_id, 
			'password' => md5($password), 
			'created_on' => date('Y-m-d H:i:s')
			);

		$vendor_id = $this->ws_model->set_vendors($data);
		$vendors = vendor_by_id($vendor_id);
		if(empty($vendors))
		{
			$response = array('status' => false, 'message' => 'Vendor Registration Failed!', 'response' => array());
		}
		else
		{
			// $Message = 'Dear Customer '.$rand.' is your One Time Password for Food Safari. Thank You.';
			// SendSMS($email_id, 'One Time Password', $Message);
			$response = array('status' => true, 'message' => 'Vendor Registration Successful!', 'response' => $vendors);
		}				

		TrackResponse($user_input, $response);		
		$this->response($response);
	}

	/*
	*	vendor Login
	*/
	function vendor_login_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$vendor_deleted = $this->ws_model->check_vendor_deleted($mobile);
		if(empty($vendor_deleted))
		{
			$response = array('status' => false, 'message' => 'Not a registered Mobile Number!', 'response' => array());
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$status = $this->ws_model->check_status($mobile);
		if(empty($status))
		{
			$response = array('status' => false, 'message' => 'Your account has been put on hold. Please contact Administrator!', 'response' => array());
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$vendorLogin = $this->ws_model->vendor_login($mobile, $password);
		//echo $this->db->last_query();exit;
		if(empty($vendorLogin))
		{
			$response = array('status' => false, 'message' => 'Login Failed. Please try again!', 'response' => array());
		}
		else
		{
			$check_mobile = check_vendor_mobile_exists($mobile);
			$response = array('status' => true, 'message' => 'Login Successful!', 'response' => $check_mobile);
		}
		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Update Device Token
	*/
	function update_vendor_device_token_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$update_token = $this->ws_model->update_vendor_device_token($vendor_id, $token, $ios_token);
		//echo $this->db->last_query();exit;
		if(empty($update_token))
		{
			$response = array('status' => false, 'message' => 'Device Token updation failed!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Device Token Updated Successfully!', 'response' => $update_token);
		}
		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Vendor Forgot Password
	*/
	function vendor_forgot_password_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array(), 'OTP' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$mobile)
		{
			$response = array('status' => false, 'message' => 'Enter Mobile Number!', 'response' => array(), 'OTP' => array());
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$vendor_deleted = $this->ws_model->check_vendor_deleted($mobile);
		if(empty($vendor_deleted))
		{
			$response = array('status' => false, 'message' => 'Not a registered Mobile Number!', 'response' => array());
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$status = $this->ws_model->check_status($mobile);
		if(empty($status))
		{
			$response = array('status' => false, 'message' => 'Your account has been put on hold. Please contact Administrator!', 'response' => array());
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$vendor_details = check_vendor_mobile_exists($mobile);
		//echo $this->db->last_query();
		$rand = mt_rand(100000, 999999);
		$otp = array('otp' => $rand);
		if(empty($vendor_details))
		{
			$response = array('status' => false, 'message' => 'Mobile Number not registered!', 'response' => array(), 'OTP' => array());			
		}
		else
		{
			$Message = 'Dear Customer '.$rand.' is your One Time Password for Food Safari. Thank You.';
			//SendSMS($mobile, $Message);
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $vendor_details, 'OTP' => $otp);
		}	
		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Change Password
	*/
	function vendor_update_password_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$vendor_id || !$password)
		{
			$response = array('status' => false, 'message' => 'vendor Id or Password not found!', 'response' => array());
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}
		$data = array(
			'password' => md5($password),			
			'modified_on' => date('Y-m-d H:i:s')
			);

		$update_vendor = $this->ws_model->update_vendor($data, $vendor_id);
		//echo $this->db->last_query();exit;
		if($update_vendor === FALSE)
		{
			$response = array('status' => false, 'message' => 'Password Updation Failed!', 'response' => array());
		}
		else
		{
			//SendSMS($mobile, 'Dear Customer '.$rand.' is your One Time Password for Poprebates. Thank You.');
			$vendor_details = vendor_by_id($vendor_id);
			$response = array('status' => true, 'message' => 'Password Updation Successful!', 'response' => $vendor_details);
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Get vendor Details
	*/
	function vendor_profile_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$vendor_details = vendor_by_id($vendor_id);
		//echo $this->db->last_query();exit;
		if(empty($vendor_details))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $vendor_details);
		}

		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Update vendor Profile
	*/
	function update_vendor_profile_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);		
		
		$data = array(
			'name' => $name,
			//'mobile' => $mobile,
			'email_id' => $email_id, 
			'modified_on' => date('Y-m-d H:i:s')
			);

		$update_vendor = $this->ws_model->update_vendor($data, $vendor_id);
		if($update_vendor === FALSE)
		{
			$response = array('status' => false, 'message' => 'Vendor Updation Failed!', 'response' => array());
		}
		else
		{
			//SendSMS($mobile, 'Dear Customer '.$rand.' is your One Time Password for Poprebates. Thank You.');
			$vendor_details = vendor_by_id($vendor_id);
			$response = array('status' => true, 'message' => 'Vendor Updation Successful!', 'response' => $vendor_details);
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}	

	/*-------------------- /Vendor -----------------------*/

	/*------ Add Venues From Vendor -------*/

	/*
	*	Get Categories
	*/
	function categories_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$categories = $this->ws_model->categories();
		//echo $this->db->last_query();exit;
		if(empty($categories))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $categories);
		}

		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Get sub Categories
	*/
	function sub_categories_post()
	{
		$response = array('status' => false, 'message' => '', 'event_types' => array(), 'amenities' => array(), 'services' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$event_types = $this->ws_model->event_types($category_id);
		$amenities = $this->ws_model->amenities($category_id);
		$services = $this->ws_model->services($category_id);
		//echo $this->db->last_query();exit;
		if(empty($event_types) && empty($amenities) && empty($services))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'event_types' => array(), 'amenities' => array(), 'services' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'event_types' => $event_types, 'amenities' => $amenities, 'services' => $services);
		}

		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Get Cities
	*/
	function cities_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$cities = $this->ws_model->cities();
		//echo $this->db->last_query();exit;
		if(empty($cities))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'cities' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'cities' => $cities);
		}

		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Get Areas
	*/
	function areas_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$areas = $this->ws_model->areas($city_id);
		//echo $this->db->last_query();exit;
		if(empty($areas))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $areas);
		}

		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	function venue_validation_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$venue_name)
		{
			$response = array('status' => false, 'message' => 'Venue Name is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$check_venue_name_exists = $this->ws_model->check_venue_name_exists($venue_name);
		if($check_venue_name_exists === false)
		{
			$response = array('status' => false, 'message' => 'Venue Name already exists. Try with a new name!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		if(!$contact_number)
		{
			$response = array('status' => false, 'message' => 'Contact Number is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$check_contact_number_exists = $this->ws_model->check_contact_number_exists($contact_number);
		if($check_contact_number_exists === false)
		{
			$response = array('status' => false, 'message' => 'Contact Number already exists!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		if(!$email_id)
		{
			$response = array('status' => false, 'message' => 'Email Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$check_email_id_exists = $this->ws_model->check_email_id_exists($email_id);
		if($check_email_id_exists === false)
		{
			$response = array('status' => false, 'message' => 'Email Id already exists!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}
		$response = array('status' => true, 'message' => 'Success!');
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Add Venue
	*/
	function add_venue_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$venue_name)
		{
			$response = array('status' => false, 'message' => 'Venue Name is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$check_venue_name_exists = $this->ws_model->check_venue_name_exists($venue_name);
		if($check_venue_name_exists === false)
		{
			$response = array('status' => false, 'message' => 'Venue Name already exists. Try with a new name!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		if(!$contact_number)
		{
			$response = array('status' => false, 'message' => 'Contact Number is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$check_contact_number_exists = $this->ws_model->check_contact_number_exists($contact_number);
		if($check_contact_number_exists === false)
		{
			$response = array('status' => false, 'message' => 'Contact Number already exists!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		if(!$email_id)
		{
			$response = array('status' => false, 'message' => 'Email Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$check_email_id_exists = $this->ws_model->check_email_id_exists($email_id);
		if($check_email_id_exists === false)
		{
			$response = array('status' => false, 'message' => 'Email Id already exists!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$image_data= array(
			'upload_path' =>'./storage/venues/',
			'file_path' => 'storage/venues/'
		);

		if($image)
		{
			$image_data['image'] = $image;
			$image_result = upload_image($image_data);
			if(!$image_result['status'])
			{
	            $response = array('status' => false, 'message' => 'Image saving is unsuccessful!');
	            TrackResponse($user_input, $response);       
	            $this->response($response);
			}
			else
			{
				$venues = $image_result['result'];
			}
		}		
		
		$data = array(
			'vendor_id' => $vendor_id,
			'city_id' => $city_id,
			'area_id' => $area_id,
			'category_id' => $category_id,
			'event_types' => $event_types,
			'venue_name' => $venue_name,
			'address' => $address,
			'lat' => $lat,
			'lng' => $lng,
			'people_capacity' => $people_capacity,
			'price' => $price,
			'discount_percentage' => $discount_percentage,
			'description' => $description,
			'booking_type' => $booking_type,
			'venue_type' => $venue_type,
			'amenities' => $amenities,
			'services' => $services,
			'ac' => $ac,
			'veg' => $veg,
			'contact_number' => $contact_number,
			'email_id' => $email_id,
			'image' => $venues,
			'created_on' => date('Y-m-d H:i:s')
			);
		//var_dump($data);exit;
		$add_venue = $this->ws_model->add_venue($data);
		if($add_venue == 0)
		{
			$response = array('status' => false, 'message' => 'Venue registration failed!');
		}
		else
		{
			if($platform == "ios")
			{
				if(!empty($banners))
				{
					foreach($banners as $banner)
					{	
						$image_data['image'] = $banner['image'];
						$banner_result = upload_image($image_data);
						$banner_data[] = array(
							'venue_id' => $add_venue,
							'image' => $banner_result['result'],
							'created_on' => date('Y-m-d H:i:s')
						);						
					}
				}
			}
			else
			{			
	            if(!empty($banners))
	            {
	            	$banners = json_decode($banners);
	                foreach($banners as $banner)
	                {
	                    $image_data['image'] = $banner->image;
						$banner_result = upload_image($image_data);
						$banner_data[] = array(
							'venue_id' => $add_venue,
							'image' => $banner_result['result'],
							'created_on' => date('Y-m-d H:i:s')
						);
	                }
	            }
			}

			if($banner_data)
			{
				$this->db->insert_batch('venue_banners', $banner_data);
			}

			if($platform == "ios")
			{
				if(!empty($slots))
				{
					foreach($slots as $slot)
					{	
						$slots_data[] = array(
							'venue_id' => $add_venue,
							'start_time' => $slot['start_time'],
							'end_time' => $slot['end_time'],
							'amount' => $slot['amount'],
							'slot_capacity' => $slot['slot_capacity'],
							'created_on' => date('Y-m-d H:i:s')
						);
					}
				}
			}
			else
			{
	            if(!empty($slots))
	            {
	            	$slots = json_decode($slots);
	                foreach($slots as $slot)
	                {
	                    $slots_data[] = array(
							'venue_id' => $add_venue,
							'start_time' => $slot->start_time,
							'end_time' => $slot->end_time,
							'amount' => $slot->amount,
							'slot_capacity' => $slot->slot_capacity,
							'created_on' => date('Y-m-d H:i:s')
						);
	                }
	            }
			}
			//var_dump($slots_data);exit;
			$add_slot = $this->ws_model->add_slot($slots_data);

			$venues = venue_by_id($add_venue);
			$slots_array = $this->ws_model->list_slots($add_venue);
			$response = array('status' => true, 'message' => 'Venue added Successfully!', 'venues' => $venues, 'slots' => $slots_array);
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Add Slot
	*/
	function add_slot_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$venue_id)
		{
			$response = array('status' => false, 'message' => 'Venue Id is required!', 'response' => array());
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		if(!$slot_capacity)
		{
			$slot_capacity = 0;
		}
		
		$data = array(
			'venue_id' => $venue_id,
			'start_time' => date('H:i:s', strtotime($start_time)),
			'end_time' => date('H:i:s', strtotime($end_time)),
			'amount' => $amount,
			'slot_capacity' => $slot_capacity,
			'created_on' => date('Y-m-d H:i:s')
			);
		//var_dump($data);exit;
		$add_slot = $this->ws_model->add_single_slot($data);
		if($add_slot == 0)
		{
			$response = array('status' => false, 'message' => 'Slot adding failed!', 'response' => array());
		}
		else
		{
			$slots = $this->ws_model->list_slots($venue_id);
			$response = array('status' => true, 'message' => 'Slot added Successfully!', 'response' => $slots);
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Add Slot
	*/
	function add_temporary_slot_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$venue_id)
		{
			$response = array('status' => false, 'message' => 'Venue Id is required!', 'response' => array());
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$this->db->where('venue_id', $venue_id);
		$this->db->where('date', $date);
		$this->db->delete('temporary_slots');

		if($platform == "ios")
		{
			if(!empty($slots))
			{
				foreach($slots as $slot)
				{	
					if($slot['slot_capacity'] == NULL || $slot['slot_capacity'] == 0)
                	{
                		$slot_capacity = 0;
                	}
                	else
                	{
                		$slot_capacity = $slot['slot_capacity'];
                	}
					$slots_data[] = array(
						'venue_id' => $venue_id,
						'slot_id' => $slot['slot_id'],
						'start_time' => $slot['start_time'],
						'end_time' => $slot['end_time'],
						'amount' => $slot['amount'],
						'slot_capacity' => $slot_capacity,
						'date' => $date,
						'created_on' => date('Y-m-d H:i:s')
					);
				}
			}
		}
		else
		{
            if(!empty($slots))
            {
            	$slots = json_decode($slots);
                foreach($slots as $slot)
                {
                	if($slot->slot_capacity == NULL)
                	{
                		$slot_capacity = 0;
                	}
                	else
                	{
                		$slot_capacity = $slot->slot_capacity;
                	}
                    $slots_data[] = array(
						'venue_id' => $venue_id,
						'slot_id' => $slot->slot_id,
						'start_time' => $slot->start_time,
						'end_time' => $slot->end_time,
						'amount' => $slot->amount,
						'slot_capacity' => $slot_capacity,
						'date' => $date,
						'created_on' => date('Y-m-d H:i:s')
					);
                }
            }
		}
		//var_dump($slots_data);exit;
		$add_slot = $this->ws_model->add_temporary_slot($slots_data);
		$slots = $this->ws_model->list_temporary_slots($venue_id, $date);

		$response = array('status' => true, 'message' => 'Slot added Successfully!', 'response' => $slots);				
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Get Slots
	*/
	function slots_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$slots = $this->ws_model->list_slots($venue_id);
		//echo $this->db->last_query();exit;
		if(empty($slots))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $slots);
		}

		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Get Temporary Slot
	*/
	function temporary_slots_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);
		
		$deleted_record = $this->db->query("DELETE FROM sv_temporary_slots WHERE slot_id NOT IN(SELECT id FROM sv_venue_slots) and venue_id = $venue_id");
		$slots = $this->ws_model->list_temporary_slots($venue_id, $date);
		//echo $this->db->last_query();exit;
		if(empty($slots))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $slots);
		}

		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Edit Slot
	*/
	function edit_slot_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$venue_id)
		{
			$response = array('status' => false, 'message' => 'Venue Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		if(!$slot_id)
		{
			$response = array('status' => false, 'message' => 'Slot Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}
		
		if(!$slot_capacity)
		{
			$slot_capacity = 0;
		}

		$data = array(
			'start_time' => date('H:i:s', strtotime($start_time)),
			'end_time' => date('H:i:s', strtotime($end_time)),
			'amount' => $amount,
			'slot_capacity' => $slot_capacity,
			'modified_on' => date('Y-m-d H:i:s')
			);

		//var_dump($data);exit;
		$edit_slot = $this->ws_model->edit_slot($data, $slot_id);
		if($edit_slot === false)
		{
			$response = array('status' => false, 'message' => 'Slot upadation failed!');
		}
		else
		{
			$slots = $this->ws_model->list_slots($venue_id);
			$response = array('status' => true, 'message' => 'Slot updated Successfully!', 'response' => $slots);
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Delete Slot
	*/
	function delete_slot_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$venue_id)
		{
			$response = array('status' => false, 'message' => 'Venue Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		if(!$slot_id)
		{
			$response = array('status' => false, 'message' => 'Slot Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$delete_slot = $this->ws_model->delete_slot($slot_id);
		if($delete_slot === false)
		{
			$response = array('status' => false, 'message' => 'Slot deletion failed!');
		}
		else
		{
			$slots = $this->ws_model->list_slots($venue_id);
			$response = array('status' => true, 'message' => 'Slot deleted Successfully!', 'response' => $slots);
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Venue Details
	*/
	function venue_details_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);
		if(!$venue_id)
		{
			$response = array('status' => false, 'message' => 'Venue Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}
		$venue_details = $this->ws_model->vendor_venue_details($venue_id);
		$pricing = $this->ws_model->venue_extra_pricing_data($venue_id);
		if(empty($venue_details))
		{
			$response = array('status' => false, 'message' => 'No data available!');
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data fetched Successfully!', 'response' => $venue_details, 'pricing' => $pricing);
		}
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Edit Venue
	*/
	function edit_venue_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);
		if(!$venue_id)
		{
			$response = array('status' => false, 'message' => 'Venue Name is required!');
			TrackResponse($vendor_input, $response);
			$this->response($response);
		}
		if(!$venue_name)
		{
			$response = array('status' => false, 'message' => 'Venue Name is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}
		$check_venue_name_exists = $this->ws_model->check_venue_name_exists($venue_name, $venue_id);
		if($check_venue_name_exists === false)
		{
			$response = array('status' => false, 'message' => 'Venue Name already exists. Try with a new name!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}
		if(!$contact_number)
		{
			$response = array('status' => false, 'message' => 'Contact Number is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}
		$check_contact_number_exists = $this->ws_model->check_contact_number_exists($contact_number, $venue_id);
		if($check_contact_number_exists === false)
		{
			$response = array('status' => false, 'message' => 'Contact Number already exists!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}
		if(!$email_id)
		{
			$response = array('status' => false, 'message' => 'Email Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}
		$check_email_id_exists = $this->ws_model->check_email_id_exists($email_id, $venue_id);
		if($check_email_id_exists === false)
		{
			$response = array('status' => false, 'message' => 'Email Id already exists!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}
		$image_data= array(
			'upload_path' =>'./storage/venues/',
			'file_path' => 'storage/venues/'
		);
		if($image)
		{
			$image_data['image'] = $image;
			$image_result = upload_image($image_data);
			if(!$image_result['status'])
			{
	            $response = array('status' => false, 'message' => 'Image saving is unsuccessful!');
	            TrackResponse($user_input, $response);       
	            $this->response($response);
			}
			else
			{
				$venues = $image_result['result'];
			}
		}
		$data = array(
			'vendor_id' => $vendor_id,
			'city_id' => $city_id,
			'area_id' => $area_id,
			'category_id' => $category_id,
			'event_types' => $event_types,
			'venue_name' => $venue_name,
			'address' => $address,
			'lat' => $lat,
			'lng' => $lng,
			'people_capacity' => $people_capacity,
			'price' => $price,
			'discount_percentage' => $discount_percentage,
			'description' => $description,
			'booking_type' => $booking_type,
			'venue_type' => $venue_type,
			'amenities' => $amenities,
			'services' => $services,
			'ac' => $ac,
			'veg' => $veg,
			'contact_number' => $contact_number,
			'email_id' => $email_id,
			'created_on' => date('Y-m-d H:i:s')
			);
		if($image)
		{
			$data['image'] = $venues;
		}
		//var_dump($data);exit;
		$edit_venue = $this->ws_model->edit_venue($data, $venue_id);
		if($edit_venue == 0)
		{
			$response = array('status' => false, 'message' => 'Venue registration failed!');
		}
		else
		{
			// $banner_data = array();
			// if($platform == "ios")
			// {
			// 	if(!empty($banners))
			// 	{
			// 		foreach($banners as $banner)
			// 		{	
			// 			$image_data['image'] = $banner['image'];
			// 			$banner_result = upload_image($image_data);
			// 			$banner_data[] = array(
			// 				'venue_id' => $add_venue,
			// 				'image' => $banner_result['result'],
			// 				'created_on' => date('Y-m-d H:i:s')
			// 			);						
			// 		}
			// 	}
			// }
			// else
			// {			
	  //           if(!empty($banners))
	  //           {
	  //           	$banners = json_decode($banners);
	  //               foreach($banners as $banner)
	  //               {
	  //                   $image_data['image'] = $banner->image;
			// 			$banner_result = upload_image($image_data);
			// 			$banner_data[] = array(
			// 				'venue_id' => $add_venue,
			// 				'image' => $banner_result['result'],
			// 				'created_on' => date('Y-m-d H:i:s')
			// 			);
	  //               }
	  //           }
			// }

			// if(!empty($banner_data))
			// {
			// 	$this->db->insert_batch('venue_banners', $banner_data);
			// }

			// $slots_data = array();
			// if($platform == "ios")
			// {
			// 	if(!empty($slots))
			// 	{
			// 		foreach($slots as $slot)
			// 		{	
			// 			$slots_data[] = array(
			// 				'venue_id' => $add_venue,
			// 				'start_time' => $slot['start_time'],
			// 				'end_time' => $slot['end_time'],
			// 				'amount' => $slot['amount'],
			// 				'slot_capacity' => $slot['slot_capacity'],
			// 				'created_on' => date('Y-m-d H:i:s')
			// 			);
			// 		}
			// 	}
			// }
			// else
			// {
	  //           if(!empty($slots))
	  //           {
	  //           	$slots = json_decode($slots);
	  //               foreach($slots as $slot)
	  //               {
	  //                   $slots_data[] = array(
			// 				'venue_id' => $add_venue,
			// 				'start_time' => $slot->start_time,
			// 				'end_time' => $slot->end_time,
			// 				'amount' => $slot->amount,
			// 				'slot_capacity' => $slot->slot_capacity,
			// 				'created_on' => date('Y-m-d H:i:s')
			// 			);
	  //               }
	  //           }
			// }
			// //var_dump($slots_data);exit;
			// if(!empty($slots_data))
			// {
			// 	$add_slot = $this->ws_model->add_slot($slots_data);
			// }

			$venues = venue_by_id($venue_id);
			$slots_array = $this->ws_model->list_slots($venue_id);
			$response = array('status' => true, 'message' => 'Venue added Successfully!', 'venues' => $venues, 'slots' => $slots_array);
		}
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Venue Images
	*/
	function venue_banners_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$venue_id)
		{
			$response = array('status' => false, 'message' => 'Venue Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$venue_banners = $this->ws_model->venue_banners($venue_id);
		if(empty($venue_banners))
		{
			$response = array('status' => false, 'message' => 'No data available!');
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data fetched Successfully!', 'response' => $venue_banners);
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Add Images
	*/
	function add_venue_banner_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$venue_id)
		{
			$response = array('status' => false, 'message' => 'Venue Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$image_data= array(
			'upload_path' =>'./storage/venues/',
			'file_path' => 'storage/venues/'
		);

		if($platform == "ios")
		{
			if(!empty($banners))
			{
				foreach($banners as $banner)
				{
					$image_data['image'] = $banner['image'];
					$banner_result = upload_image($image_data);
					$banner_data[] = array(
						'venue_id' => $venue_id,
						'image' => $banner_result['result'],
						'created_on' => date('Y-m-d H:i:s')
					);						
				}
			}
		}
		else
		{
            if(!empty($banners))
            {
            	$banners = json_decode($banners);
                foreach($banners as $banner)
                {
                    $image_data['image'] = $banner->image;
					$banner_result = upload_image($image_data);
					$banner_data[] = array(
						'venue_id' => $venue_id,
						'image' => $banner_result['result'],
						'created_on' => date('Y-m-d H:i:s')
					);
                }
            }
		}
		//var_dump($banner_data);exit;
		if($banner_data)
		{
			$this->db->insert_batch('venue_banners', $banner_data);
		}
		
		$venue_banners = $this->ws_model->venue_banners($venue_id);
		$response = array('status' => true, 'message' => 'Venue Banner added Successfully!', 'response' => $venue_banners);
				
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Delete Banners
	*/
	function delete_venue_banner_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$venue_id)
		{
			$response = array('status' => false, 'message' => 'Venue Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		if(!$banner_id)
		{
			$response = array('status' => false, 'message' => 'Banner Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$delete_banner = $this->ws_model->delete_venue_banner($banner_id);
		if($delete_banner === false)
		{
			$response = array('status' => false, 'message' => 'Banner deletion Failed!');
		}
		else
		{
			$venue_banners = $this->ws_model->venue_banners($venue_id);
			$response = array('status' => true, 'message' => 'Banner deleted Successfully!', 'response' => $venue_banners);
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	shortlists
	*/
	function shortlists_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$vendor_id)
		{
			$response = array('status' => false, 'message' => 'Vendor Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$shortlists = $this->ws_model->shortlists($vendor_id);
		if(empty($shortlists))
		{
			$response = array('status' => false, 'message' => 'No data available!');
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data fetched Successfully!', 'response' => $shortlists);
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Online bookings
	*/
	function online_bookings_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);		

		$online_bookings = $this->ws_model->online_bookings($vendor_id, $status);
		//echo $this->db->last_query();exit;
		if(empty($online_bookings))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $online_bookings);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Offline bookings
	*/
	function offline_bookings_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);		

		$offline_bookings = $this->ws_model->offline_bookings($vendor_id);
		//echo $this->db->last_query();exit;
		if(empty($offline_bookings))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $offline_bookings);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Vendor cancel Booking
	*/
	function vendor_cancel_booking_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$data = array(			
			'status' => 'cancelled by vendor',
			'cancellation_reason' => $cancellation_reason,
			'cancelled_date' => date('Y-m-d H:i:s'),
			'modified_on' => date('Y-m-d H:i:s')
			);

		$user_cancel_booking = $this->ws_model->user_cancel_booking($data, $order_id);
		if($user_cancel_booking === false)
		{
			$response = array('status' => false, 'message' => 'Cancellation Failed!', 'response' => array());
		}
		else
		{			
			$response = array('status' => true, 'message' => 'Order Cancelled Successfully!', 'response' => array());		
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Vendor accept Booking
	*/
	function vendor_accept_booking_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$data = array(			
			'status' => 'accepted',
			'modified_on' => date('Y-m-d H:i:s')
			);

		$user_cancel_booking = $this->ws_model->user_cancel_booking($data, $order_id);
		if($user_cancel_booking === false)
		{
			$response = array('status' => false, 'message' => 'Status updation Failed!', 'response' => array());
		}
		else
		{			
			$response = array('status' => true, 'message' => 'Order Rejected Successfully!', 'response' => array());		
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Vendor reject Booking
	*/
	function vendor_reject_booking_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$data = array(			
			'status' => 'rejected',
			'modified_on' => date('Y-m-d H:i:s')
			);

		$user_cancel_booking = $this->ws_model->user_cancel_booking($data, $order_id);
		if($user_cancel_booking === false)
		{
			$response = array('status' => false, 'message' => 'Status updation Failed!', 'response' => array());
		}
		else
		{			
			$response = array('status' => true, 'message' => 'Order Rejected Successfully!', 'response' => array());		
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Day Wise Calendar
	*/
	function day_wise_calendar_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);		

		$day_wise_calendar = $this->ws_model->check_slots_available($venue_id, $date, $category_id);
		//echo $this->db->last_query();exit;
		if(empty($day_wise_calendar))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $day_wise_calendar);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Place Offline Order
	*/
	function place_offline_order_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$vendor_input = $this->client_request;
		extract($vendor_input);		
		
		$booking_id = mt_rand(100000, 999999);
		$data = array(
			'booking_id' => $booking_id,
			'category_id' => $category_id,
			'vendor_id' => $vendor_id,
			'venue_id' => $venue_id,
			'slot_id' => $slot_id,
			'total_capacity' => $total_capacity,
			'capacity' => $capacity,
			//'amount_paid' => $amount_paid,
			'booking_type' => 'instant',
			'payment_status' => 'paid',
			'booked_for' => $booked_for,
			'booked_type' => 'offline',
			'status' => 'accepted',
			'created_on' => date('Y-m-d H:i:s')
			);
		$place_order = $this->ws_model->place_order($data, $vendor_id);

		$user_data = array(
			'order_id' => $place_order,
			'name' => $name,
			'mobile' => $mobile,
			'email_id' => $email_id,
			'created_on' => date('Y-m-d H:i:s')
			);
		$this->db->insert('offline_customers', $user_data);
		if($place_order == 0)
		{
			$response = array('status' => false, 'message' => 'Order placing failed!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Order Placed Successfully!', 'response' => array());
		}		
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Dashboard
	*/
	function dashboard_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);		

		$dashboard = $this->ws_model->dashboard($vendor_id);
		//echo $this->db->last_query();exit;
		
		$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $dashboard);		
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Search Order
	*/
	function search_order_post()
	{
		$response = array('status' => false, 'message' => '', 'response' => array());
		$user_input = $this->client_request;
		extract($user_input);		

		$search_order = $this->ws_model->search_order($keyword, $vendor_id);
		//echo $this->db->last_query();exit;
		
		if(empty($search_order))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $search_order);
		}
		TrackResponse($user_input, $response);
		$this->response($response);
	}

	/*
	*	Feedback Form
	*/
	function vendor_feedback_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$vendor_id)
		{
			$response = array('status' => false, 'message' => 'Vendor Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$data = array(
			'vendor_id' => $vendor_id,
			'title' => $title,
			'message' => $message,
			'created_on' => date('Y-m-d H:i:s')
			);

		$this->ws_model->vendor_feedback($data);
		$response = array('status' => true, 'message' => 'Feedback Submitted Successfully!');
			
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	Vendor Delete Request
	*/
	function vendor_delete_requests_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		if(!$vendor_id)
		{
			$response = array('status' => false, 'message' => 'Vendor Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}
		if(!$venue_id)
		{
			$response = array('status' => false, 'message' => 'Venue Id is required!');
			TrackResponse($vendor_input, $response);		
			$this->response($response);
		}

		$data = array(
			'vendor_id' => $vendor_id,
			'venue_id' => $venue_id,
			'created_on' => date('Y-m-d H:i:s')
			);

		$this->ws_model->vendor_delete_requests($data);
		$response = array('status' => true, 'message' => 'Request Submitted Successfully!');
			
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	/*
	*	User/vendor Messages
	*/
	function submit_message_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);
		
		$data = array(
			'unique_id' => $unique_id,
			'subject' => $subject,
			'message' => $message,
			'type' => $type,
			'created_on' => date('Y-m-d H:i:s')
		);
		$this->db->insert('messages', $data);

		$response = array('status' => true, 'message' => 'Message Submitted Successfully!');			
		TrackResponse($vendor_input, $response);
		$this->response($response);
	}

	/*
	*	Vendor Delete Request
	*/
	function submit_pricing_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$this->db->delete('category_extra_details', array('category_id' => $category_id, 'vendor_id' => $vendor_id, 'venue_id' => $venue_id));
		//echo $this->db->last_query();exit;
		$data = array();

		if(isset($platform) && $platform == "android")
		{
			$pricings = json_decode($pricings);
			//var_dump($json);exit;
			if(isset($pricings)) foreach($pricings as $price) if($price){
				$data[] = array(
					'category_id'	=> $category_id,
					'vendor_id'	=> $vendor_id,
					'venue_id'	=> $venue_id,
					'title'	=> $price->title,
					'price'	=> $price->price,
					'quantity'	=> $price->quantity,					
				);
			}
		}
		else
		{
			if(isset($pricings)) foreach($pricings as $price) if($price){
				$data[] = array(
					'category_id'	=> $category_id,
					'vendor_id'	=> $vendor_id,
					'venue_id'	=> $venue_id,
					'title'	=> $price['title'],
					'price'	=> $price['price'],
					'quantity'	=> $price['quantity'],					
				);
			}
		}	
		if(!empty($data))
		{
			$this->db->insert_batch('category_extra_details', $data);
		}
		$response = array('status' => true, 'message' => 'Data Submitted Successfully!');
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	public function get_pricings_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$pricing = $this->vendormodel->get_pricings($category_id, $venue_id);
		if(empty($pricing))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $pricing);
		}
		$this->response($response);
	}

	function submit_cancellation_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$this->db->delete('category_extra_details', array('category_id' => $category_id, 'vendor_id' => $vendor_id, 'venue_id' => $venue_id));
		//echo $this->db->last_query();exit;
		$data = array();

		if(isset($platform) && $platform == "android")
		{
			$calcellation = json_decode($calcellation);
			//var_dump($json);exit;
			if(isset($calcellation)) foreach($calcellation as $row) if($row){
				$data[] = array(
					'category_id'	=> $category_id,
					'vendor_id'	=> $vendor_id,
					'from'	=> $row->from,
					'to'	=> $row->to,
					'cancellation_allowed'	=> $row->cancellation_allowed,
					'refund'	=> $row->refund,					
				);
			}
		}
		else
		{
			if(isset($calcellation)) foreach($calcellation as $row) if($row){
				$data[] = array(
					'category_id'	=> $category_id,
					'vendor_id'	=> $vendor_id,
					'from'	=> $row['from'],
					'to'	=> $row['to'],
					'cancellation_allowed'	=> $row['cancellation_allowed'],
					'refund'	=> $row['refund'],					
				);
			}
		}	
		if(!empty($data))
		{
			$this->db->insert_batch('vendor_cancellation_policy', $data);
			$response = array('status' => true, 'message' => 'Data Submitted Successfully!');
		}
		else
		{
			$response = array('status' => false, 'message' => 'Data Updation Failed!');
		}
		TrackResponse($vendor_input, $response);		
		$this->response($response);
	}

	public function cancellation_policy_post()
	{
		$response = array('status' => false, 'message' => '');
		$vendor_input = $this->client_request;
		extract($vendor_input);

		$policy = $this->homemodel->cancellation_policy($category_id, $vendor_id);
		if(empty($policy))
		{
			$response = array('status' => false, 'message' => 'No Data Found!', 'response' => array());
		}
		else
		{
			$response = array('status' => true, 'message' => 'Data Fetched Successfully!', 'response' => $policy);
		}
		$this->response($response);
	}

	/*----- /Add Venues From Vendor -------*/

}
?>