<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
			
	public $header = 'website/includes/header';
	public $footer = 'website/includes/footer';
	function __construct()
	{
		parent::__construct();
		$this->load->model('homemodel');
		$this->load->model('app/ws_model');
		date_default_timezone_set("Asia/Kolkata");
		$this->load->library('Ajax_pagination');
		$this->perPage = 5;
	}
	
	public function index()
	{
		$data['title'] = "Plato";
		echo "Site is under maintenance!";
	}

	// public function venues()
	// {
	// 	$data['title'] = "Smart Venue";
	// 	$totalRec = count($this->homemodel->venues());
	// 	$config['target']      = '#postList';
 //        $config['base_url']    = base_url().'home/venues_ajax';
 //        $config['total_rows']  = $totalRec;
 //        $config['per_page']    = $this->perPage;
 //        $this->ajax_pagination->initialize($config);
	// 	$data['venues'] = $this->homemodel->venues(array('limit'=>$this->perPage));
	// 	$data['categories'] = $this->homemodel->categories();
	// 	$data['areas'] = $this->homemodel->areas($this->session->userdata('city'));
	// 	$data['event_types'] = $this->homemodel->event_types();
	// 	$data['category_name'] = $this->homemodel->get_category_name();
	// 	//var_dump($data['venues']);				
	// 	$this->setHeaderFooter('website/venues', $data);
	// }

	// function venues_ajax()
 //    {
 //        $page = $this->input->post('page');
 //        if(!$page)
 //        {
 //            $offset = 0;
 //        }
 //        else
 //        {
 //            $offset = $page;
 //        }
 //        //total rows count
 //        $totalRec = count($this->homemodel->venues());
 //        //pagination configuration
 //        $config['target']      = '#postList';
 //        $config['base_url']    = base_url().'home/venues_ajax';
 //        $config['total_rows']  = $totalRec;
 //        $config['per_page']    = $this->perPage;
        
 //        $this->ajax_pagination->initialize($config);
 //        //get the posts data
 //        $data['venues'] = $this->homemodel->venues(array('start'=>$offset, 'limit'=>$this->perPage));
 //        //load the view
 //        $this->load->view('website/venues_ajax', $data, false);
 //    }

	public function venues()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');	
		$data['venues'] = $this->homemodel->venues();
		$data['categories'] = $this->homemodel->categories();
		$data['areas'] = $this->homemodel->areas($this->session->userdata('city'));
		$data['event_types'] = $this->homemodel->event_types();
		$data['category_name'] = $this->homemodel->get_category_name();
		$data['advertisements'] = $this->homemodel->get_advertisements();
		$data['venues_count'] = $this->homemodel->total_venues_count();

		$venues_count = $this->homemodel->total_venues_count();
		$round = $venues_count/5;
        $str_arr = explode('.',$round);
        $this->session->set_userdata('v_count', $str_arr[0]);

		$this->setHeaderFooter('website/venues', $data);
	}

	public function venues_scroll_data()
	{
		$data['title'] = "Smart Venue";
		$numItems = $this->input->post('numItems');
		$vendor_id = $this->session->userdata('vendor_id');
		$data['venues'] = $this->homemodel->venues($numItems);
		//echo $this->db->last_query();
		$data['categories'] = $this->homemodel->categories();
		$data['areas'] = $this->homemodel->areas($this->session->userdata('city'));
		$data['event_types'] = $this->homemodel->event_types();
		$data['category_name'] = $this->homemodel->get_category_name();
		$data['advertisements'] = $this->homemodel->get_advertisements();
		$data['venues_count'] = $this->homemodel->total_venues_count();

		$v_count = $this->session->userdata('v_count') - 1;
		$this->session->set_userdata('v_count', $v_count);
		$this->load->view('website/venues_ajax', $data);
	}

    public function venue_details($venue_id)
	{
		$data['title'] = "Smart Venue";
		$date = "";
		$data['capacity'] = "";
		$url = explode('=', $_SERVER['REQUEST_URI']);
        if(isset($url[1]))
        {
        	$filters = explode(',', $url[1]);
	    	if(isset($filters[0]))
	    	{
	    		$date = date('Y-m-d', strtotime($filters[0]));
	    	}
	    	if(isset($filters[1]))
	    	{
	    		$data['capacity'] = $filters[1];
	    	}
        }

		$data['pricings'] = $this->homemodel->venue_extra_pricing_data($venue_id);
		$data['venue_details'] = $this->homemodel->venue_details($venue_id,$date);
		$data['pricing'] = $this->homemodel->venue_extra_pricing_data($venue_id);
		//var_dump($data['venue_details']);
		$this->setHeaderFooter('website/venue_details', $data);
	}

	// public function get_slots()
	// {
	// 	$Capacity = $this->input->post('capacity');
	// 	$venue_id = $this->input->post('venue_id');
	// 	$category_id = $this->input->post('category_id');
	// 	$date = date('Y-m-d', strtotime($this->input->post('date')));
	// 	$slots = $this->homemodel->check_slots_available($venue_id, $date, $category_id);
	// 	//var_dump($slots);
	// 	if(!empty($slots))
	// 	{
	// 		foreach($slots as $slot)
	// 		{
	// 	echo '<li><a href="javascript:void(0)" class="wow pulse" data-wow-delay=".5s"><span><i class="fa fa-clock-o" aria-hidden="true"></i> Time</span>
 //                    <span class="capacity"> 
 //                        <span class="total-capacity"><i class="fa fa-users" aria-hidden="true"></i> Capacity 1000</span> 
 //                        <span class="remaining-capacity"><i class="fa fa-users" aria-hidden="true"></i> Remaining 1000</span>
 //                    </span>

 //                    <span class="price"><i class="fa fa-inr" aria-hidden="true"></i> 3000</span><span class="select">Select this Slot</span><span class="selected">Selected <i class="fa fa-check" aria-hidden="true"></i> </span></a>
 //                    </li>';
 //                }
 //            }
	// }

	public function search_venues()
	{
		$data['title'] = "Smart Venue";
		$keyword = $this->input->post('keyword');
		$data['venues'] = $this->homemodel->search_venues($keyword);
		$this->load->view('website/search_venues', $data);
	}

	public function send_otp()
	{
		$this->session->unset_userdata('otp');
		$data['title'] = "Smart Venue";
		$mobile = $this->input->post('mobile');
		$otp = mt_rand(100000, 999999);
		$message = "Dear User, $otp is One time password (OTP) for Smart Venue. Thank You.";
        SendSMS($mobile, $message);
		$this->session->set_userdata('otp', $otp);
		echo $this->session->userdata('otp');
	}

	public function check_mobile_exists()
	{
		$user_id = $this->input->post('user_id');
		$mobile = $this->input->post('mobile');
		$details = $this->homemodel->check_mobile_exists($user_id, $mobile);
		//echo $this->db->last_query();exit;
		if($details == 0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}
	}

	public function check_email_id_exists()
	{
		$user_id = $this->input->post('user_id');
		$email_id = $this->input->post('email_id');
		$details = $this->homemodel->check_email_id_exists($user_id, $email_id);
		//echo $this->db->last_query();exit;
		if($details == 0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}
	}

	public function check_mobile_valid()
	{
		$user_id = $this->input->post('isdd');
		$mobile = $this->input->post('mobile');
		$details = $this->homemodel->check_mobile_exists($user_id, $mobile);
		//echo $this->db->last_query();exit;
		if($details == 0)
		{
			echo "false";
		}
		else
		{
			echo "true";
		}
	}

	public function check_email_id_registered()
	{
		$user_id = $this->input->post('user_id');
		$email_id = $this->input->post('email_id');
		$details = $this->homemodel->check_email_id_exists($user_id, $email_id);
		//echo $this->db->last_query();exit;
		if($details > 0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}
	}

	public function user_register()
	{
		//var_dump($this->input->post());
		$data = array(
			'name' => $this->input->post('name'),
			'mobile' => $this->input->post('mobile_reg'),
			'email_id' => $this->input->post('email_id'), 
			'password' => md5($this->input->post('r_password')), 
			'created_on' => date('Y-m-d H:i:s')
			);
		$user_id = $this->homemodel->set_users($data);
		if($user_id > 0)
		{			
			$this->homemodel->send_register_email($this->input->post('email_id'));
		}
		echo $user_id;
	}

	public function user_login()
	{
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|callback_verifyuser');
		
		if($this->form_validation->run() == false)
		{
			$this->session->set_flashdata('login_failed', 'Mobile Number or Password is Incorrect. Please try again!');
			if($this->session->userdata('favourites_data'))
			{
				redirect('home/my_favourites', 'refresh');
			}
			elseif($this->input->post('method') == "venue_details")
			{
				redirect('home/'.$this->input->post('method').'/'.$this->input->post('uid').'/?filter='.$this->input->post('filter'), 'refresh');
			}
			else
			{
			    redirect('home/index', 'refresh');
			}
		}
		else
		{
			if($this->session->userdata('favourites_data'))
			{
				$favourites_data = $this->session->userdata('favourites_data');
				$favourites_data['user_id'] = $this->session->userdata('user_id');
				//var_dump($favourites_data);exit;

				$add_to_favourites = $this->homemodel->add_to_favourites($favourites_data);				
				
				if($add_to_favourites == 1)
				{			
					$this->session->set_flashdata('success', 'Venue added to Favourites!');
					//echo "Venue added to Favourites";
				}
				elseif($add_to_favourites == 0)
				{
					$this->session->set_flashdata('success', 'Venue removed from Favourites!');
					//echo "Venue removed from Favourites!";
				}
				else
				{
					$this->session->set_flashdata('failure', 'Updation Failed successfully!');
					//echo "Updation Failed!";
				}
				$this->session->unset_userdata('favourites_data');
				redirect('home/my_favourites', 'refresh');
			}
			elseif($this->input->post('method') == "venue_details")
			{
				redirect('home/'.$this->input->post('method').'/'.$this->input->post('uid').'/?filter='.$this->input->post('filter'), 'refresh');
			}
			redirect('home/index', 'refresh');
		}
	}

	public function verifyuser()
	{
		$mobile = $this->security->xss_clean($this->input->post('mobile'));
		$password = $this->security->xss_clean($this->input->post('password'));		
		$row = $this->homemodel->user_login($mobile, $password);
		//var_dump($result);exit;
		if(!empty($row))
		{
			$this->session->set_userdata(array(
                            'mobile'   => $mobile,
                            'user_id'   => $row->id,
                            'email_id'   => $row->email_id,
                            'name'   => $row->name,
                            'user_logged_in' => TRUE
                    ));
			return true;
		}
		else
		{
			$this->form_validation->set_message('verifyuser', 'Mobile Number or Password is Incorrect. Please try again.');
			return false;
		}
	}

	public function submit_ratings()
	{
		$user_logged_in = $this->session->userdata('user_logged_in');
		if(!isset($user_logged_in) || $user_logged_in != true)
		{
			redirect('home/venue_details/'.$this->input->post('venue_id'), 'refresh');
		}
		$ratings = $this->input->post('star');
		$reviews = $this->input->post('reviews');
		$venue_id = $this->input->post('venue_id');
		$filter = $this->input->post('filter');
		$user_id = $this->session->userdata('user_id');
		$data = array(
			'user_id' => $user_id,
			'venue_id' => $venue_id,
			'ratings' => $ratings,
			'reviews' => $reviews,
			'created_on' => date('Y-m-d H:i:s')
			);
			//echo "<pre>";print_r($data);exit;
		$this->db->insert('venue_ratings', $data);
		$this->session->set_flashdata('success', 'Thanks for your valuable review!');
		redirect('home/venue_details/'.$venue_id.'/?'.$filter, 'refresh');
	}

	/*
	*	Place Order
	*/
	function place_order()
	{
	    $where = array(
			'user_id' => $this->session->userdata('user_id'),
			'category_id' => $this->input->post('category_id'),
			'vendor_id' => $this->input->post('vendor_id'),
			'venue_id' => $this->input->post('venue_id'),
			'slot_id' => $this->input->post('slot_id'),
			'booking_type' => $this->input->post('booking_type'),
			'booked_for' => date('Y-m-d', strtotime($this->input->post('booked_for'))),
			);
			
	    $get_table_row = $this->homemodel->get_table_row('orders', $where, array());
	    if(!empty($get_table_row) && $this->input->post('category_id') != 7 && $this->input->post('category_id') != 8)
	    {
	        echo "placed";exit;
	    }
	    
		$booking_id = mt_rand(100000, 999999);
		$quantity = $this->input->post('quantity');
		$capacity = 0;
		if($this->input->post('capacity') != "" || $this->input->post('capacity') != 0)
		{
			$capacity = $this->input->post('capacity');
		}
		elseif(!empty($quantity))
		{
			$capacity = array_sum($quantity);
		}
		$data = array(
			'booking_id' => $booking_id,
			'user_id' => $this->session->userdata('user_id'),
			'category_id' => $this->input->post('category_id'),
			'vendor_id' => $this->input->post('vendor_id'),
			'venue_id' => $this->input->post('venue_id'),
			'slot_id' => $this->input->post('slot_id'),
			'total_capacity' => $this->input->post('total_capacity'),
			'capacity' => $capacity,
			'amount_paid' => $this->input->post('amount_paid'),
			'booking_type' => $this->input->post('booking_type'),
			'payment_status' => $this->input->post('payment_status')? $this->input->post('payment_status') : 'pending',
			'booked_for' => date('Y-m-d', strtotime($this->input->post('booked_for'))),
			'payment_mode' => $this->input->post('payment_mode'),
			'created_on' => date('Y-m-d H:i:s')
			);
		//echo $this->input->post('booking_type');exit;
		
		if($this->input->post('payment_status') == "paid")
		{
			$data['status'] = "accepted";
		}
		if($this->input->post('payment_mode') == "cash" || $this->input->post('payment_mode') == "na")
		{
			$data['status'] = "pending";			
		}
		if($this->input->post('booking_type') == "instant")
		{
			$data['status'] = "accepted";
		}
		$place_order = $this->homemodel->place_order($data, $this->input->post('vendor_id'));
		$this->session->set_userdata('order_id', $place_order);
		//echo $this->db->last_query();
		if($place_order == 0)
		{
			echo "failed";
		}
		else
		{
			$title = $this->input->post('title');
			$quantity = $this->input->post('quantity');
			$e_id = $this->input->post('e_id');
			$price = $this->input->post('price');
			$total = $this->input->post('total');
 
			$resort_capacity = 0;
			if(isset($quantity) && !empty($quantity))
			{
				$extradata = array();
				foreach($quantity as $key => $row)
				{
					if($row)
					{
						$resort_capacity += $row;
						$extradata[] = array(
							'order_id' => $place_order,
							'e_id' => $e_id[$key],
							'title' => $title[$key],
							'quantity' => $row,
							'price' => $price[$key],
							'total' => $total[$key],
							'created_on' => date('Y-m-d H:i:s')
							);
					}
				}
				$this->db->insert_batch('sv_order_extras', $extradata);
			}

			if($this->input->post('payment_mode') == "cash" || $this->input->post('payment_mode') == "na")
			{				
				$user = user_by_id($this->session->userdata('user_id'));
				$vendor = vendor_by_id($this->input->post('vendor_id'));
				$venue = venue_by_id($this->input->post('venue_id'));

				if($this->input->post('category_id') != 5 && $this->input->post('category_id') != 6)
				{
					$amount_paid = $this->input->post('amount_paid');
				}
				else
				{
					$amount_paid = "NA";
				}

				if($this->input->post('slot_id') != 0)
				{
					$details = $this->homemodel->get_order_details($place_order);
					$booked_for = date('d M Y', strtotime($this->input->post('booked_for'))).' '.'('.date('h:i A', strtotime($details->start_time)).'-'.date('h:i A', strtotime($details->end_time)).')';
				}
				else
				{
					$booked_for = date('d M Y', strtotime($this->input->post('booked_for')));
				}			

				if($resort_capacity > 0)
				{
					$capacity = $resort_capacity;
				}
				else
				{
					$capacity = $this->input->post('capacity');
				}

				$final_amount = $venue->price * ((100 - $venue->discount_percentage) / 100);
			
if($this->input->post('booking_type') == "delayed")
{

$this->homemodel->send_booking_successful_email($this->session->userdata('email_id'), $place_order, 'delayed_user');

$user_message = "Dear $user->name, Your booking request is sent for venue owner's approval. 
Booking Details:
ID: $booking_id 
Booking Slot Date: $booked_for 
Capacity: $capacity
Name: $venue->venue_name
Address: $venue->address
Contact: $venue->contact_number";
				
$this->homemodel->send_booking_successful_email($vendor->email_id, $place_order, 'delayed_vendor');

$vendor_message = "Dear $vendor->name, you have received the booking request. 
Booking Details:
ID: $booking_id 
Booking Slot Date: $booked_for 
Capacity: $capacity
Please approve or reject it. Otherwise,it will be auto-rejected by system.";
}
else
{
				


$this->homemodel->send_booking_successful_email($this->session->userdata('email_id'), $place_order, 'instant_user');

$user_message = "Dear $user->name, Congratulations!!!! your Booking request is Confirmed. 
Booking Details: 
ID: $booking_id
Booking Slot Date: $booked_for
Capacity: $capacity
Total Amount: $final_amount
Token Amount: $amount_paid
Venue Details:
Name: $venue->venue_name
Address: $venue->address
Contact: $venue->contact_number";

$this->homemodel->send_booking_successful_email($vendor->email_id, $place_order, 'instant_vendor');

$vendor_message = "Dear $vendor->name, Congratulations!!! You have Confirmed the Booking. 
Booking Details:
ID: $booking_id
Booking Slot Date: $booked_for
Capacity: $capacity 
Total Amount:$final_amount 
Token Amount:$amount_paid 
Customer Details:
Customer Name: $user->name 
Customer Contact: $user->mobile";
}

SendSMS($user->mobile, $user_message);
SendSMS($vendor->mobile, $vendor_message);
				echo "success";
			}
			else
			{
				echo "payment_gateway-".$place_order;
			}
		}
	}

	/*
	*	Pay Now
	*/
	function payu($venue_id, $order_id, $payment_mode)
	{
		$user_logged_in = $this->session->userdata('user_logged_in');
		if(!isset($user_logged_in) || $user_logged_in != true)
		{
			redirect('home/index', 'refresh');
		}
		if($payment_mode == "cash")
		{
			$data = array(
				'payment_status' => 'pending',
				//'status' => 'accepted',
				'payment_mode' => 'cash',
				'modified_on' => date('Y-m-d H:i:s')
				);
			$this->homemodel->update_payment_status($data, $order_id);
			$this->session->set_flashdata('success', 'Status Updated Successfully!');
			redirect('home/user_bookings', 'refresh');
		}
		$data['venue_details'] = $this->homemodel->venue_details($venue_id, '', $this->session->userdata('user_id'));
		$data['order_id'] = $order_id;
		$order_details = $this->homemodel->get_order_details($order_id);
		//var_dump($order_details);exit;
		$data['amount_paid'] = $order_details->amount_paid;//exit;
		//echo $this->db->last_query();exit;
		$this->setHeaderFooter('website/payu', $data);
	}

	function payment_status($status, $order_id)
	{
		if($status == "success")
		{
			$data = array(
				'payment_status' => 'paid',
				'status' => 'accepted',
				'modified_on' => date('Y-m-d H:i:s')
				);
			$update_payment_status = $this->homemodel->update_payment_status($data, $order_id);
			$data['p_status'] = "success";
			//$this->homemodel->send_booking_successful_email($this->session->userdata('email_id'), $order_id);
			$user = get_user_details_with_order_id($order_id);
			//SendSMS($user->mobile, 'Dear Customer your order with '.$booking_id.' is placed Successfully. Thank You.');
			
			$details = $this->homemodel->get_order_details($order_id);
    		//echo "test";
    		if($details->category_id != 5 && $details->category_id != 6)
    		{
    			$amount_paid = $category_details->amount_paid;
    		}
    		else
    		{
    			$amount_paid = "NA";
    		}
    		if($details->slot_id != 0)
    		{					
    			$booked_for = date('d M Y', strtotime($details->booked_for)).' '.'('.date('h:i A', strtotime($details->start_time)).'-'.date('h:i A', strtotime($details->end_time)).')';
    		}
    		else
    		{
    			$booked_for = date('d M Y', strtotime($details->booked_for));
    		}
    
    		$final_amount = $details->venue_price * ((100 - $details->discount_percentage) / 100);
			
			$this->homemodel->send_booking_successful_email($this->session->userdata('email_id'), $order_id, 'instant_user');

            $user_message = "Dear $details->user_name, Congratulations!!!! your Booking request is Confirmed. 
            Booking Details: 
            ID: $details->booking_id
            Booking Slot Date: $booked_for
            Capacity: $details->capacity
            Total Amount: $final_amount
            Token Amount: $amount_paid
            Venue Details:
            Name: $details->venue_name 
            Address: $details->venue_address 
            Contact: $details->venue_mobile";
            
            $this->homemodel->send_booking_successful_email($details->vendor_email_id, $order_id, 'instant_vendor');
            
            $vendor_message = "Dear $details->vendor_name, Congratulations!!! You have Confirmed the Booking. 
            Booking Details:
            ID: $details->booking_id
            Booking Slot Date: $booked_for
            Capacity: $details->capacity 
            Total Amount:$final_amount 
            Token Amount:$amount_paid 
            Customer Details:
            Customer Name: $details->user_name 
            Customer Contact: $details->user_mobile";
            
            
            $sendsms = SendSMS($details->user_mobile, $user_message);
            //var_dump($sendsms);
            SendSMS($details->vendor_mobile, $vendor_message);
			
			$this->setHeaderFooter('website/payment_success', $data);
		}
		elseif($status == "failure")
		{
			$data['p_status'] = "failure";
			// $this->db->where('id', $order_id);
			// $this->db->set('status', 'pending');
			// $this->db->set('payment_status', 'pending');
			// $this->db->update('orders');

			$this->db->where('id', $order_id);
			$this->db->delete('orders');
			//echo $this->db->last_query();
			$this->setHeaderFooter('website/payment_success', $data);
		}
	}

	/*
	*	Add to Favourites
	*/
	function add_to_favourites()
	{
		$data = array(			
			'user_id' => $this->session->userdata('user_id'),
			'vendor_id' => $this->input->post('vendor_id'),
			'venue_id' => $this->input->post('venue_id'),
			'created_on' => date('Y-m-d H:i:s')
			);
		$user_logged_in = $this->session->userdata('user_logged_in');
		if(!isset($user_logged_in) || $user_logged_in != true)
		{
			$this->session->set_userdata('favourites_data', $data);
			echo "login";exit;
		}
		$add_to_favourites = $this->homemodel->add_to_favourites($data);
		if($add_to_favourites == 1)
		{			
			echo "Venue added to Favourites";
		}
		elseif($add_to_favourites == 0)
		{
			echo "Venue removed from Favourites!";
		}
		else
		{
			echo "Updation Failed!";
		}
	}

	/*
	*	Favourites
	*/
	function my_favourites()
	{
		$user_logged_in = $this->session->userdata('user_logged_in');
		if(!isset($user_logged_in) || $user_logged_in != true)
		{
			redirect('home/index', 'refresh');
		}
		$data['favourites'] = $this->homemodel->favourites($this->session->userdata('user_id'));
		//echo $this->db->last_query();exit;
		$this->setHeaderFooter('website/my_favourites', $data);
	}

	public function user_profile()
	{
		$user_logged_in = $this->session->userdata('user_logged_in');
		if(!isset($user_logged_in) || $user_logged_in != true)
		{
			redirect('home/index', 'refresh');
		}
		$data['title'] = "Smart Venue";
		$data['row'] = $this->homemodel->user_profile($this->session->userdata('user_id'));
		$this->setHeaderFooter('website/user_profile', $data);
	}

	public function user_bookings()
	{
		$user_logged_in = $this->session->userdata('user_logged_in');
		if(!isset($user_logged_in) || $user_logged_in != true)
		{
			redirect('home/index', 'refresh');
		}
		$data['title'] = "Smart Venue";
		$data['orders'] = $this->homemodel->user_bookings($this->session->userdata('user_id'));
		$this->setHeaderFooter('website/user_bookings', $data);
	}	

	public function change_password()
	{
		$user_logged_in = $this->session->userdata('user_logged_in');
		if(!isset($user_logged_in) || $user_logged_in != true)
		{
			redirect('home/index', 'refresh');
		}
		$data['title'] = "Smart Venue";
		//$data['row'] = $this->homemodel->change_password($this->session->userdata('user_id'));
		$this->setHeaderFooter('website/change_password', $data);
	}

	public function update_password()
	{
		$data = array(
			'password' => md5($this->input->post('f_password')),
			'modified_on' => date('Y-m-d H:i:s')
		);
		//var_dump($data);exit;
		//echo $this->session->userdata('user_id');exit;
		$this->db->where('mobile', $this->input->post('f_mobile_reg'));
		$this->db->update('users', $data);
		//echo $this->db->last_query();
		//$this->homemodel->update_password($data, $this->session->userdata('user_id'));
		$this->session->set_flashdata('success', 'Password updated successfully!');
		redirect('home/change_password', 'refresh');
	}

	public function edit_profile()
	{
		$user_logged_in = $this->session->userdata('user_logged_in');
		if(!isset($user_logged_in) || $user_logged_in != true)
		{
			redirect('home/index', 'refresh');
		}
		$data['title'] = "Smart Venue";
		$data['row'] = $this->homemodel->edit_profile($this->session->userdata('user_id'));
		$this->setHeaderFooter('website/edit_profile', $data);
	}

	public function update_profile()
	{
		// $config['upload_path']          = './storage/pdfs';
		// $config['allowed_types']        = 'pdf|jpg|png|gif';
		// $config['max_size']             = 2000;
		
		// $this->load->library('upload', $config);
		// // if ( ! $this->upload->do_upload('course_curriculum')){
		// // 	$error = array('error' => $this->upload->display_errors());

  // //           print_r($error); exit;
		// // }		

		// if($this->upload->do_upload('image'))
		// {
		// 	$imgdata = $this->upload->data();
		// 	$imgurl = 'storage/pdfs/'.$imgdata['file_name'];			
		// }		
		// else
		// {
		// 	$imgurl = $this->input->post('imgurl');
		// }

		$data = array(
			'name' => $this->input->post('name'),
			'email_id' => $this->input->post('email_id'),
			//'image' => $imgurl,
			'modified_on' => date('Y-m-d H:i:s')
		);
		//var_dump($data);exit;
		$this->homemodel->update_password($data, $this->session->userdata('user_id'));
		$this->session->set_flashdata('success', 'Profile updated successfully!');
		redirect('home/edit_profile', 'refresh');
	}

	/*
	*	User cancel Booking
	*/
	function user_cancel_booking()
	{
		$category_details = $this->homemodel->get_category_details_using_order_id($this->input->post('order_id'));
		$order_details = order_details($this->input->post('order_id'));

		$from_range = $category_details->from_range;
		$to_range = $category_details->to_range;
		$refund_percentage = $category_details->cancel_percent;
		$amount_paid = $category_details->amount_paid;

		// Previous Logic...
		// $today = date('Y-m-d');
		// $created_on = date_create($this->input->post('created_on'));
		// $booked_for = date_create($this->input->post('booked_for'));
		// $diff = date_diff($created_on, $booked_for);
		// $days_left = $diff->format("%a");

		// $cancellation = "";
		// $refund_amount = 0;
		// if($days_left >= $to_range)
		// {
		// 	$todays_date = date_create($today);
		// 	$difff = date_diff($created_on,$todays_date);
		// 	$days_leftt = $difff->format("%a");
		// 	if($days_leftt > $from_range && $days_leftt <= $to_range)
		// 	{
		// 		$cancellation = "Paid Cancellation";
		// 		$refund_amount = ($amount_paid / 100) * $refund_percentage;
		// 	}
		// 	elseif($days_leftt < $from_range)
		// 	{
		// 		$cancellation = "Free Cancellation";
		// 		$refund_percentage = 0;
		// 		$refund_amount = $amount_paid;
		// 	}
		// 	elseif($days_leftt > $to_range)
		// 	{
		// 		echo 'Dear User, You passed cancellation date. Now you cannot cancel the order!';exit;			
		// 	}
		// }
		// elseif($days_left < $from_range)
		// {
		// 	echo 'Dear User, Your order is confirmed. Now you cannot cancel the order!';exit;			
		// }

		$today = date('Y-m-d');
		$created_on = date_create($today);
		$booked_for = date_create($this->input->post('booked_for'));
		$diff = date_diff($created_on, $booked_for);
		$days_left = $diff->format("%a") + 1;

		$cancellation = "";
		$refund_amount = 0;	
		
		if($days_left >= $from_range && $days_left <= $to_range)
		{
			$cancellation = "Paid Cancellation";
			$refund_amount = ($amount_paid / 100) * $refund_percentage;
		}
		elseif($days_left > $to_range)
		{
			$cancellation = "Free Cancellation";
			$refund_percentage = 0;
			$refund_amount = $amount_paid;
		}
		elseif($days_left < $from_range)
		{
			echo 'Dear User, You passed cancellation date. Now you cannot cancel the order!';exit;			
		}
		
		//exit;
		$data = array(			
			'status' => 'cancelled by user',
			'cancellation_reason' => $cancellation,
			'refund_percentage' => $refund_percentage,
			'refund_amount' => $refund_amount,
			'cancelled_date' => date('Y-m-d H:i:s'),
			'modified_on' => date('Y-m-d H:i:s')
			);

		$user_cancel_booking = $this->homemodel->user_cancel_booking($data, $this->input->post('order_id'));
		if($user_cancel_booking === false)
		{
			echo 'Cancellation Failed!';exit;
		}
		else
		{
				$details = $this->homemodel->get_order_details($this->input->post('order_id'));

				//echo "test";

				if($details->category_id != 5 && $details->category_id != 6)
				{
					$amount_paid = $category_details->amount_paid;
				}
				else
				{
					$amount_paid = "NA";
				}
				if($details->slot_id != 0)
				{					
					$booked_for = date('d M Y', strtotime($details->booked_for)).' '.'('.date('h:i A', strtotime($details->start_time)).'-'.date('h:i A', strtotime($details->end_time)).')';
				}
				else
				{
					$booked_for = date('d M Y', strtotime($details->booked_for));
				}

				$final_amount = $details->venue_price * ((100 - $details->discount_percentage) / 100);

$this->homemodel->send_booking_cancel_email($details->user_email_id, $this->input->post('order_id'), 'cancelled_by_user');

			$user_message = "Dear $details->user_name, you have cancelled the Booking. 
Booking Details: 
ID: $details->booking_id
Booking Slot Date: $booked_for
Capacity: $details->capacity
Total Amount: $final_amount
Token Amount: $details->amount_paid
Venue Details:
Name: $details->venue_name
Address: $details->venue_address
Contact: $details->venue_mobile";
			SendSMS($this->session->userdata('mobile'), $user_message);	

$this->homemodel->send_booking_cancel_email($details->vendor_email_id, $this->input->post('order_id'), 'cancelled_by_user_vendor');			

$vendor_message = "Dear $details->vendor_name, The booking is cancelled by Customer. 
Booking Details: 
ID: $details->booking_id 
Booking Slot Date: $booked_for 
Capacity: $details->capacity 
Total Amount: $final_amount 
Token Amount: $details->amount_paid 
Customer Details: 
Customer Name: $details->user_name 
Customer Contact: $details->user_mobile";

			SendSMS($details->vendor_mobile, $vendor_message);	
			//echo $details->vendor_mobile;

			if($cancellation == "Free Cancellation")
			{
				echo 'Order Cancelled Successfully. Total amount will be refunded within 48 hours.';exit;
			}
			else
			{				
				echo 'Order Cancelled Successfully. '.$refund_percentage.' % of amount will be refunded within 48 hours!';exit;
			}

		}
	}

	public function reset_password_link()
	{
		$data['title'] = "Smart Venue";
		$email_idd = $this->input->post('email_idd');
		$user_details = $this->homemodel->get_userid_emailid($email_idd);
		$to = $email_idd;
		$from = "info@smartvenue.com";
		$sitename="Smart Venue";
		$subject = 'Smart Venue';
		$message='<table width="100%" cellspacing="0" cellpadding="5" border="0" style="border:1px solid #d9d9d9">
		<tr>
			<td style="font-family:Arial, Helvetica, sans-serif;color:#fff;font-size:12px; padding:5px;background:#393939">Smart Venue</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<img src="http://iprismconstructions.com/smartvenue/assets/website/images/logo/logo-1.png" height="100" width="185" alt="">
			</td>
		</tr>
		<tr>
			<td style="border-top:1px solid #d9d9d9;border-bottom:1px solid #d9d9d9">
				<table width="100%" cellspacing="0" cellpadding="5" border="0">
					<tr>							 
						<td colspan="2" style="font-family:Arial, Helvetica, sans-serif;color:#000;font-size:12px">
							Please Click on the below Url to Reset your Password.
						</td>                
					</tr>
					<tr>							 
						<td colspan="2" style="font-family:Arial, Helvetica, sans-serif;color:#000;font-size:12px">
							<a href="http://iprismconstructions.com/smartvenue/home/reset_password/'.$user_details->id.'">Please Click here to Reset your Password!</a>
						</td>                
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="font-family:Arial, Helvetica, sans-serif;color:#000;font-size:12px;background:#eeeeee; padding-right:10px; line-height:30px;">Regards,<br />'.$sitename.' Team</td>
		</tr>
		</table>';

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: ".$to." <".$to.">\n";  
		$headers .= "From: ".$from." <".$from.">\n";  
		$headers .= "Reply-To: ".$from." <".$from.">\n";  
		$headers .= "Return-Path: ".$from." <".$from.">\n";  

		if(mail($to, $subject, $message, $headers))
		{
			$this->session->set_flashdata('fsuccess', 'Please Check your Email Id for Reset Link!');
			redirect('home/index', 'refresh');
		}
		else
		{
			$this->session->set_flashdata('ffailure', 'Email Sending Failed!');
			redirect('home/index', 'refresh');
		}
	}

	public function submit_form()
	{
		$data['title'] = "Smart Venue";
		$user_id = $this->session->userdata('user_id');
		//$data['dashboard'] = $this->ws_model->dashboard($user_id);
		$this->setHeaderFooter('website/submit_form', $data);
	}

	public function terms_conditions()
	{
		$data['title'] = "Terms and Conditions";
		$this->setHeaderFooter('website/terms', $data);
	}
  
  	public function privacy_policy()
	{
		$data['title'] = "Privacy Policy";
		$this->setHeaderFooter('website/privacy', $data);
	}
  
  	public function about_us()
	{
		$data['title'] = "About Smart Venue";
		$this->setHeaderFooter('website/aboutus', $data);
	}
  
   	public function contact_us()
	{
		$data['title'] = "Contact Us";
		$this->setHeaderFooter('website/contact', $data);
	}

	public function cancellation_policy()
	{
		$data['title'] = "Smart Venue";
		$category_id = $this->input->post('category_id');
		$vendor_id = $this->input->post('vendor_id');
		$data['policy'] = $this->homemodel->cancellation_policy($category_id, $vendor_id);
		$this->load->view('website/cancellation_policy', $data);
	}

	public function submit_message()
	{
		$data = array(
			'unique_id' => $this->session->userdata('user_id'),
			'subject' => $this->input->post('subject'),
			'message' => $this->input->post('message'),
			'type' => 'user',
			'created_on' => date('Y-m-d H:i:s')
		);
		$this->db->insert('messages', $data);
		$this->session->set_flashdata('success', 'Data submitted successfully!');
		redirect('home/submit_form', 'refresh');
	}

	public function reset_password()
	{
		$data['title'] = "Smart Venue";
		$this->load->view('website/reset_password', $data);
	}

	public function change_city($city_id)
	{
		$this->session->set_userdata('city', $city_id);
		redirect('home/index', 'refresh');
	}

	public function update_passwordd()
	{
		$data['title'] = "Smart Venue";
		$password = $this->input->post('passwordd');

		$this->db->where(array('id' => $this->input->post('user_id')));
		$this->db->set('password', md5($password));
		$this->db->update('users');
		//echo $this->db->last_query();exit;

		$this->session->set_flashdata('success', 'Password Changed Successfully!');
		redirect('home/reset_password/'.$this->input->post('user_id'), 'refresh');
	}

	function user_logged_out()
    {
    	$this->session->unset_userdata('user_id');
    	$this->session->unset_userdata('email_id');
    	$this->session->unset_userdata('name');
        $this->session->unset_userdata('user_logged_in');
        redirect('home/index', 'refresh');
    }

	public function setHeaderFooter($view, $data)
	{
		$city_id = $this->session->userdata('city');
		if(isset($city_id))
		{
			$data['city_name'] = $this->homemodel->get_city_name_using_city_id($city_id);
		}
		if(!isset($data['city_name']))
		{
			$data['city_name'] = "";
		}
		$data['cities'] = $this->homemodel->cities();
		$data['categories'] = $this->homemodel->categories();
		$data['recommended_events'] = $this->homemodel->recommended_events();
		$this->load->view($this->header, $data);
		$this->load->view($view, $data);
		$this->load->view($this->footer);
	}
	
	
}
?>