<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
			
	public $header = 'vendor/includes/header';
	public $footer = 'vendor/includes/footer';
	function __construct()
	{
		parent::__construct();
		$this->load->model('vendormodel');
		$this->load->model('homemodel');
		$this->load->model('app/ws_model');
		date_default_timezone_set("Asia/Kolkata");
		$this->vendor_logged_in();
		$this->load->library('Ajax_pagination');
		$this->perPage = 4;
	}

	public function dashboard()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$data['dashboard'] = $this->ws_model->dashboard($vendor_id);
		$this->setHeaderFooter('vendor/dashboard', $data);
	}

	public function bookings()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$url = explode('=', $_SERVER['REQUEST_URI']);
        if(isset($url[1]))
        {
        	$status = $url[1];
        	if($status == "user")
        	{
        		$status = "cancelled by user";
        	}
        	elseif($status == "vendor")
        	{
        		$status = "cancelled by vendor";
        	}
		}
		else
		{
			redirect('home/dashboard', 'refresh');exit;
		}
		if($status == "offline")
		{
			$data['bookings'] = $this->vendormodel->offline_bookings($vendor_id);
		}
		else
		{
			$data['bookings'] = $this->vendormodel->online_bookings($vendor_id, $status);
		}		
		$this->setHeaderFooter('vendor/bookings', $data);
	}

	public function bookings_scroll_data()
	{
		$data['title'] = "Smart Venue";
		$numItems = $this->input->post('numItems');
		$vendor_id = $this->session->userdata('vendor_id');
		$url = explode('=', $_SERVER['REQUEST_URI']);
        if(isset($url[1]))
        {
        	$status = $url[1];
        	if($status == "user")
        	{
        		$status = "cancelled by user";
        	}
        	elseif($status == "vendor")
        	{
        		$status = "cancelled by vendor";
        	}
		}
		else
		{
			redirect('home/dashboard', 'refresh');exit;
		}
		if($status == "offline")
		{
			$data['bookings'] = $this->vendormodel->offline_bookings($vendor_id, $numItems);
		}
		else
		{
			$data['bookings'] = $this->vendormodel->online_bookings($vendor_id, $status, $numItems);
		}		
		$this->load->view('vendor/bookings_data', $data);
	}

	public function change_status($status, $value, $order_id)
	{

		$details = $this->vendormodel->get_order_details($order_id);
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
		if($value == "a")
		{

$this->homemodel->send_booking_successful_email($details->user_email_id, $order_id, 'approve_user');

$user_message = "Dear $details->user_name, your booking request is approved by venue owner. 
Booking Details:
ID: $details->booking_id 
Token amount: $details->amount_paid  
Please pay the token amount from your login account or Pay at Venue.";
SendSMS($details->user_mobile, $user_message);

$this->homemodel->send_booking_successful_email($details->vendor_email_id, $order_id, 'approve_vendor');
$vendor_message = "Dear $details->vendor_name, Congratulations!!! You have Confirmed the Booking. 
Booking Details:
Booking ID: $details->booking_id
Slot Booking Date: $booked_for
Capacity: $details->capacity
Customer Contact: $details->user_mobile
";
SendSMS($details->vendor_mobile, $vendor_message);
			$data['status'] = "accepted";
		}
		elseif($value == "r")
		{

$this->homemodel->send_booking_successful_email($details->user_email_id, $order_id, 'reject_user');

$user_message = "Dear $details->user_name, Sorry!!! your booking request is rejected by venue owner. Kindly look for other venues. 
Booking Details:
ID: $details->booking_id 
Booking Slot Date: $booked_for";
SendSMS($details->user_mobile, $user_message);

$this->homemodel->send_booking_successful_email($details->vendor_email_id, $order_id, 'reject_vendor');

$vendor_message = "Dear $details->vendor_name, booking request is rejected by you. 
Booking Details:
ID: $details->booking_id 
Booking Slot Date: $booked_for";
SendSMS($details->vendor_mobile, $vendor_message);
			$data['status'] = "rejected";
		}
		elseif($value == "v")
		{			

$this->homemodel->send_booking_cancel_email($details->user_email_id, $order_id, 'cancel_vendor_user');

$user_message = "Dear $details->user_name, Your booking is cancelled by Venue Owner. 
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
SendSMS($details->user_mobile, $user_message);

$this->homemodel->send_booking_cancel_email($details->vendor_email_id, $order_id, 'cancel_vendor_vendor');
$vendor_message = "Dear $details->vendor_name, You have Cancelled the booking. 
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

			$data['status'] = "cancelled by vendor";
			$data['cancelled_date'] = date('Y-m-d H:i:s');
		}
		$data['modified_on'] = date('Y-m-d H:i:s');

		$this->db->where('id', $order_id);
		$this->db->update('orders', $data);
		$this->session->set_flashdata('success', 'Status changed successfully!');
		redirect('vendor/bookings?status='.$status, 'refresh');		
	}

	public function wishlist()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');	
		$data['wishlist'] = $this->vendormodel->shortlists($vendor_id);	
		$this->setHeaderFooter('vendor/wishlist', $data);
	}

	public function wishlist_scroll_data()
	{
		$data['title'] = "Smart Venue";
		$numItems = $this->input->post('numItems');
		$vendor_id = $this->session->userdata('vendor_id');
		$data['wishlist'] = $this->vendormodel->shortlists($vendor_id, $numItems);
		$this->load->view('vendor/wishlist_data', $data);
	}

	public function venues()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');	
		$data['venues'] = $this->vendormodel->venues($vendor_id);	
		$this->setHeaderFooter('vendor/venues', $data);
	}

	public function venues_scroll_data()
	{
		$data['title'] = "Smart Venue";
		$numItems = $this->input->post('numItems');
		$vendor_id = $this->session->userdata('vendor_id');
		$data['venues'] = $this->vendormodel->venues($vendor_id, $numItems);
		$this->load->view('vendor/venues_data', $data);
	}

	public function search_orders()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$keyword = $this->input->post('keyword');
		$data['orders'] = $this->ws_model->search_order($keyword, $vendor_id);	
		$this->load->view('vendor/search_orders', $data);
	}

	public function search_venues()
	{
		$data['title'] = "Smart Venue";
		$keyword = $this->input->post('keyword');
		$data['venues'] = $this->homemodel->search_venues($keyword);
		$this->load->view('website/search_venues', $data);
	}
	
	public function profile()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$data['profile'] = $this->vendormodel->profile($vendor_id);
		$this->setHeaderFooter('vendor/profile', $data);
	}

	public function edit_profile()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$data['profile'] = $this->vendormodel->profile($vendor_id);
		$this->setHeaderFooter('vendor/edit_profile', $data);
	}

	public function check_email_id_exists()
	{
		$vendor_id = $this->session->userdata('vendor_id');
		$email_id = $this->input->post('email_id');
		$details = $this->vendormodel->check_email_id_exists($vendor_id, $email_id);
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

	public function update_profile()
	{
		$data = array(
			'name' => $this->input->post('name'),
			//'mobile' => $this->input->post('mobile'),
			'email_id' => $this->input->post('email_id'),			
			'modified_on' => date('Y-m-d H:i:s')
		);
		//var_dump($data);exit;
		$this->vendormodel->update_profile($data, $this->session->userdata('vendor_id'));
		$this->session->set_flashdata('success', 'Profile updated successfully!');
		redirect('vendor/edit_profile', 'refresh');
	}

	public function change_password()
	{		
		$data['title'] = "Smart Venue";
		//$data['row'] = $this->vendormodel->change_password($this->session->userdata('vendor_id'));
		$this->setHeaderFooter('vendor/change_password', $data);
	}

	public function update_password()
	{
		$data = array(
			'password' => md5($this->input->post('password')),
			'modified_on' => date('Y-m-d H:i:s')
		);
		//var_dump($data);exit;
		//echo $this->session->userdata('vendor_id');exit;
		$this->vendormodel->update_password($data, $this->session->userdata('vendor_id'));
		$this->session->set_flashdata('success', 'Password updated successfully!');
		redirect('vendor/change_password', 'refresh');
	}

	public function add_venue()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		//$data['dashboard'] = $this->ws_model->dashboard($vendor_id);
		$data['categories'] = $this->ws_model->categories();
		$data['cities'] = $this->ws_model->cities();
		//$data['categories'] = $this->ws_model->categories();
		$this->setHeaderFooter('vendor/add_venue', $data);
	}

	public function pricing()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		//$data['dashboard'] = $this->ws_model->dashboard($vendor_id);
		$data['categories'] = $this->ws_model->categories();
		$data['cities'] = $this->ws_model->cities();
		$this->setHeaderFooter('vendor/add_pricing', $data);
	}

	public function submit_form()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		//$data['dashboard'] = $this->ws_model->dashboard($vendor_id);
		$this->setHeaderFooter('vendor/submit_form', $data);
	}

	public function submit_message()
	{
		$data = array(
			'unique_id' => $this->session->userdata('vendor_id'),
			'subject' => $this->input->post('subject'),
			'message' => $this->input->post('message'),
			'type' => 'vendor',
			'created_on' => date('Y-m-d H:i:s')
		);
		$this->db->insert('messages', $data);
		$this->session->set_flashdata('success', 'Data submitted successfully!');
		redirect('vendor/submit_form', 'refresh');
	}

	public function get_event_types()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$category_id = $this->input->post('category_id');
		$type = $this->input->post('type');
		
		//$this->load->view('vendor/get_event_types', $data);
		if($type == "events")
		{
			echo '<option value="">Select Event Types</option>';
			$records = $this->ws_model->event_types($category_id);
		}
		elseif($type == "amenities")
		{
			echo '<option value="">Select Amenities</option>';
			$records = $this->ws_model->amenities($category_id);
		}
		elseif($type == "services")
		{
			echo '<option value="">Select Services</option>';
			$records = $this->ws_model->services($category_id);
		}
		if(!empty($records))
		{
			foreach($records as $row)
			{
				echo '<option value="'.$row->id.'">'.$row->title.'</option>';
			}
		}
		
	}

	public function get_venues()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$category_id = $this->input->post('category_id');
		$venues = $this->vendormodel->get_venues($category_id);

		echo "<option value=''>Select Venue</option>";
		if(!empty($venues))
		{
			foreach($venues as $venue)
			{
				echo "<option value=".$venue->id.">".$venue->venue_name."</option>";
			}
		}
	}

	public function get_pricings()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$venue_id = $this->input->post('venue_id');
		$category_id = $this->input->post('category_id');
		$data['pricing'] = $this->vendormodel->get_pricings($category_id, $venue_id);
		$this->load->view('vendor/pricings', $data);
	}

	public function get_order_capacity()
	{
		$data['title'] = "Smart Venue";
		$order_id = $this->session->userdata('order_id');
		$data['capacity'] = $this->vendormodel->get_order_capacity($order_id);
		$this->load->view('vendor/get_order_capacity', $data);
	}

	public function submit_pricing()
	{
		$this->form_validation->set_rules('category_id', 'Category', 'required');

        if ($this->form_validation->run() == FALSE)
        {
        	redirect('vendor/pricing', 'refresh');
        }
        else
        {
			$title = $this->input->post('title');
			$price = $this->input->post('price');
			$quantity = $this->input->post('quantity');

			$this->db->delete('category_extra_details', array('category_id' => $this->input->post('category_id'), 'vendor_id' => $this->session->userdata('vendor_id'), 'venue_id' => $this->input->post('venue_id')));
			//echo $this->db->last_query();exit;
			$data = array();
			if(!empty($title))
			{
				foreach($title as $key=> $val)
				{
					if($price[$key] != 0)
					{
						$data[] = array(
							'category_id' => $this->input->post('category_id'),
							'vendor_id' => $this->session->userdata('vendor_id'),
							'venue_id' => $this->input->post('venue_id'),
							'title' => $val,
							'price' => $price[$key],
							'quantity' => $quantity[$key],
							'created_on' => date('Y-m-d H:i:s')
						);
					}
				}
				$this->db->insert_batch('category_extra_details', $data);
			}
			$this->session->set_flashdata('success', 'Pricings added successfully!');
			redirect('vendor/pricing', 'refresh');
		}
	}

	public function submit_cancellation_policy()
	{
		$this->form_validation->set_rules('category_id', 'Category', 'required');

        if ($this->form_validation->run() == FALSE)
        {
        	redirect('vendor/cancellation_policy', 'refresh');
        }
        else
        {
			$from = $this->input->post('from');
			$to = $this->input->post('to');
			$cancellation_allowed = $this->input->post('cancellation_allowed');
			$refund = $this->input->post('refund');

			$this->db->delete('vendor_cancellation_policy', array('category_id' => $this->input->post('category_id'), 'vendor_id' => $this->session->userdata('vendor_id')));
			//echo $this->db->last_query();exit;
			$data = array();
			if(!empty($from))
			{
				foreach($from as $key=> $val)
				{
					if($to[$key] != 0)
					{
						$data[] = array(
							'category_id' => $this->input->post('category_id'),
							'vendor_id' => $this->session->userdata('vendor_id'),
							'from' => $val,
							'to' => $to[$key],
							'cancellation_allowed' => $cancellation_allowed[$key],
							'refund' => $refund[$key],
							'created_on' => date('Y-m-d H:i:s')
						);
					}
				}
				$this->db->insert_batch('vendor_cancellation_policy', $data);
			}
			$this->session->set_flashdata('success', 'Cancellation Policy added successfully!');
			redirect('vendor/cancellation_policy', 'refresh');
		}
	}

	public function get_policy()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$category_id = $this->input->post('category_id');
		$data['policy'] = $this->vendormodel->get_policy($category_id, $vendor_id);
		$this->load->view('vendor/cancellation_policy_ajax', $data);
	}

	public function cancellation_policy()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		//$data['dashboard'] = $this->ws_model->dashboard($vendor_id);
		$data['categories'] = $this->ws_model->categories();
		//$data['cities'] = $this->ws_model->cities();
		$this->setHeaderFooter('vendor/cancellation_policy', $data);
	}

	public function delete_banner($banner_id, $venue_id)
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$delete_banner = $this->ws_model->delete_venue_banner($banner_id);
		redirect('vendor/edit_venue/'.$venue_id, 'refresh');
	}

	public function get_areas()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$city_id = $this->input->post('city_id');
		$areas = $this->ws_model->areas($city_id);
		echo '<option value="">Select Area</option>';
		if(!empty($areas))
		{
			foreach($areas as $area)
			{
				echo '<option value="'.$area->id.'">'.$area->title.'</option>';
			}
		}
	}

	function submit_venue_details()
	{
		//$this->form_validation->set_rules('image', 'Image', 'required');
        $this->form_validation->set_rules('venue_name', 'Venue Name', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        //$this->form_validation->set_rules('event_types', 'Event Type', 'required');
        //$this->form_validation->set_rules('amenities', 'Amenities', 'required');
        //$this->form_validation->set_rules('services', 'Services', 'required');
        $this->form_validation->set_rules('city_id', 'City', 'required');
        $this->form_validation->set_rules('area_id', 'Area', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('discount_percentage', 'Discount Percentage', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('booking_type', 'Booking Type', 'required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required');
        $this->form_validation->set_rules('email_id', 'Email ID', 'required');
        if (empty($_FILES['image']['name']))
		{
		    $this->form_validation->set_rules('image', 'Image', 'required');
		}

        if ($this->form_validation->run() == FALSE)
        {
               $data['title'] = "Smart Venue";
				$vendor_id = $this->session->userdata('vendor_id');
				//$data['dashboard'] = $this->ws_model->dashboard($vendor_id);
				$data['categories'] = $this->ws_model->categories();
				$data['cities'] = $this->ws_model->cities();
				//$data['categories'] = $this->ws_model->categories();
				$this->setHeaderFooter('vendor/add_venue', $data);
        }
        else
        {
			//var_dump($this->input->post());
			$config['upload_path']          = './storage/venues';
			$config['allowed_types']        = 'pdf|jpg|png|gif|jpeg';
			$config['max_size']             = 2000;

			$this->load->library('upload', $config);
			// if ( ! $this->upload->do_upload('image')){
			// 	$error = array('error' => $this->upload->display_errors());

	  //           print_r($error); exit;
			// }
			if($this->upload->do_upload('image'))
			{
				$imgdata = $this->upload->data();
				$profile_imgurl = 'storage/venues/'.$imgdata['file_name'];
			}		
			else
			{
				$profile_imgurl = $this->input->post('profile_imgurl');
			}

			$this->load->library('upload');
		    $dataInfo = array();
		    $files = $_FILES;
		    $cpt = count($_FILES['banners']['name']);
		    for($i=0; $i<$cpt; $i++)
		    {
		        $_FILES['userfile']['name']= $files['banners']['name'][$i];
		        $_FILES['userfile']['type']= $files['banners']['type'][$i];
		        $_FILES['userfile']['tmp_name']= $files['banners']['tmp_name'][$i];
		        $_FILES['userfile']['error']= $files['banners']['error'][$i];
		        $_FILES['userfile']['size']= $files['banners']['size'][$i];    

		        $this->upload->initialize($this->set_upload_options());
		        $this->upload->do_upload();
		        $dataInfo[] = $this->upload->data();
		    }
		    //var_dump($dataInfo);exit;
			extract($this->input->post());
			$people_capacity = 0;
			$vendor_id = $this->session->userdata('vendor_id');
			if(isset($to) && $to != "")
			{
				$people_capacity = $from.'-'.$to;
			}		
			else
			{
				$people_capacity = $from;
			}
			if(!empty($amenities))
			{
				$amenities = implode(',', $amenities);
			}
			else
			{
				$amenities = "";
			}
			if(!empty($services))
			{
				$services = implode(',', $services);
			}
			else
			{
				$services = "";
			}
			if(!empty($event_types))
			{
				$event_types = implode(',', $event_types);
			}
			else
			{
				$event_types = "";
			}
			if(!isset($venue_type))
			{
				$venue_type = ""; 
			}
			else
			{
				$venue_type = implode(',', $venue_type);
			}
			if(!isset($amenities)){ $amenities =""; }
			if(!isset($services)){ $services =""; }
			if(!isset($ac)){ $ac =""; }
			if(!isset($veg)){ $veg =""; }
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
				'venue_type' => $venue_type ? $venue_type : "",
				'amenities' => $amenities ? $amenities : "",
				'services' => $services ? $services : "",
				'ac' => $ac ? $ac : "",
				'veg' => $veg ? $veg : "",
				'contact_number' => $contact_number,
				'email_id' => $email_id,
				'image' => $profile_imgurl,
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
				$banner_data = array();		
				$banners = array_filter($dataInfo);
		        if(!empty($banners))
		        {
		            foreach($banners as $banner)
		            {
		            	if($banner['file_name'])
		            	{
							$banner_data[] = array(
								'venue_id' => $add_venue,
								'image' => 'storage/venues/'.$banner['file_name'],
								'created_on' => date('Y-m-d H:i:s')
							);	
						}				
		            }
		        }
				if($banner_data)
				{
					$this->db->insert_batch('venue_banners', $banner_data);
				}		
					
	            if(!empty($start_hour))
	            {
	            	$slots_data = array();
	                foreach($start_hour as $key=>$hour)
	                {
	                	$slot_capacity_val = $slot_capacity[$key];
	                	$start_time = date('H:i:s', strtotime($hour.':'.$start_minute[$key].' '.$start_type[$key]));
	                	$end_time = date('H:i:s', strtotime($end_hour[$key].':'.$end_minute[$key].' '.$end_type[$key]));
	                	$amount1 = $amount[$key];
	                	$slot_capacity = 0;
	                	if(isset($slot_capacity_val))
	                	{
	                		$slot_capacity = $slot_capacity_val;
	                	}
	                    $slots_data[] = array(
							'venue_id' => $add_venue,
							'start_time' => $start_time,
							'end_time' => $end_time,
							'amount' => $amount1,
							'slot_capacity' => $slot_capacity,
							'created_on' => date('Y-m-d H:i:s')
						);
	                }
	                //var_dump($slots_data);exit;
	                if(!empty($slots_data))
	                {
	                	$add_slot = $this->ws_model->add_slot($slots_data);
	                }				
	            }
	            $this->session->set_flashdata('success', 'Venue registered successfully!');
				redirect('vendor/add_venue', 'refresh');
			}
		}
	}

	public function edit_venue($venue_id)
	{
		// $this->output->set_status_header('404'); 
  //   	$this->load->view('vendor/404');

		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		//$data['dashboard'] = $this->ws_model->dashboard($vendor_id);
		$data['categories'] = $this->ws_model->categories();
		$data['cities'] = $this->ws_model->cities();
		$data['details'] = $this->ws_model->vendor_venue_details($venue_id);
		$data['event_types'] = $this->ws_model->event_types($data['details']['category_id']);
		$data['amenities'] = $this->ws_model->amenities($data['details']['category_id']);
		$data['services'] = $this->ws_model->services($data['details']['category_id']);
		$data['areas'] = $this->ws_model->areas($data['details']['city_id']);
		$data['slots'] = $this->ws_model->list_slots($venue_id);		
		$this->setHeaderFooter('vendor/edit_venue', $data);
	}

	function edit_venue_details()
	{
		//$this->form_validation->set_rules('image', 'Image', 'required');
        $this->form_validation->set_rules('venue_name', 'Venue Name', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        //$this->form_validation->set_rules('event_types', 'Event Type', 'required');
        //$this->form_validation->set_rules('amenities', 'Amenities', 'required');
        //$this->form_validation->set_rules('services', 'Services', 'required');
        $this->form_validation->set_rules('city_id', 'City', 'required');
        $this->form_validation->set_rules('area_id', 'Area', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('discount_percentage', 'Discount Percentage', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('booking_type', 'Booking Type', 'required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required');
        $this->form_validation->set_rules('email_id', 'Email ID', 'required');
        //$this->form_validation->set_rules('banners', 'Banner', 'required');

        if ($this->form_validation->run() == FALSE)
        {
               $data['title'] = "Smart Venue";
				$vendor_id = $this->session->userdata('vendor_id');
				//$data['dashboard'] = $this->ws_model->dashboard($vendor_id);
				$data['categories'] = $this->ws_model->categories();
				$data['cities'] = $this->ws_model->cities();
				$data['details'] = $this->ws_model->vendor_venue_details($venue_id);
				$data['event_types'] = $this->ws_model->event_types($data['details']['category_id']);
				$data['amenities'] = $this->ws_model->amenities($data['details']['category_id']);
				$data['services'] = $this->ws_model->services($data['details']['category_id']);
				$data['areas'] = $this->ws_model->areas($data['details']['city_id']);
				$data['slots'] = $this->ws_model->list_slots($venue_id);
				$this->setHeaderFooter('vendor/edit_venue', $data);
        }
        else
        {
			//var_dump($this->input->post());
			$config['upload_path']          = './storage/venues';
			$config['allowed_types']        = 'pdf|jpg|png|gif|jpeg';
			$config['max_size']             = 2000;

			$this->load->library('upload', $config);
			// if ( ! $this->upload->do_upload('image')){
			// 	$error = array('error' => $this->upload->display_errors());

	  //           print_r($error); exit;
			// }
			if($this->upload->do_upload('image'))
			{
				$imgdata = $this->upload->data();
				$profile_imgurll = 'storage/venues/'.$imgdata['file_name'];
			}		
			else
			{
				$profile_imgurll = $this->input->post('profile_imgurl');
			}

			$this->load->library('upload');
		    $dataInfo = array();
		    $files = $_FILES;
		    if(isset($_FILES['banners']['name']))
		    {
			    $cpt = count($_FILES['banners']['name']);
			    for($i=0; $i<$cpt; $i++)
			    {
			        $_FILES['userfile']['name']= $files['banners']['name'][$i];
			        $_FILES['userfile']['type']= $files['banners']['type'][$i];
			        $_FILES['userfile']['tmp_name']= $files['banners']['tmp_name'][$i];
			        $_FILES['userfile']['error']= $files['banners']['error'][$i];
			        $_FILES['userfile']['size']= $files['banners']['size'][$i];    

			        $this->upload->initialize($this->set_upload_options());
			        $this->upload->do_upload();
			        $dataInfo[] = $this->upload->data();
			    }
			}
		    //var_dump($dataInfo);exit;
			extract($this->input->post());
			$vendor_id = $this->session->userdata('vendor_id');
			$people_capacity = "";
			if(isset($to) && $to != "")
			{
				$people_capacity = $from.'-'.$to;
			}
			else
			{
				$people_capacity = $from;
			}
			if(!empty($amenities))
			{
				$amenities = implode(',', $amenities);
			}
			else
			{
				$amenities = "";
			}
			if(!empty($services))
			{
				$services = implode(',', $services);
			}
			else
			{
				$services = "";
			}
			if(!empty($event_types))
			{
				$event_types = implode(',', $event_types);
			}
			else
			{
				$event_types = "";
			}

			if(!isset($venue_type))
			{
			 $venue_type =""; 
			}
			else
			{
				$venue_type = implode(',', $venue_type);
			}
			//var_dump($venue_type);exit;
			if(!isset($amenities)){ $amenities =""; }
			if(!isset($services)){ $services =""; }
			if(!isset($ac)){ $ac =""; }
			if(!isset($veg)){ $veg =""; }
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
				'venue_type' => $venue_type ? $venue_type : "",
				'amenities' => $amenities ? $amenities : "",
				'services' => $services ? $services : "",
				'ac' => $ac ? $ac : "",
				'veg' => $veg ? $veg : "",
				'contact_number' => $contact_number,
				'email_id' => $email_id,
				'image' => $profile_imgurll,
				'created_on' => date('Y-m-d H:i:s')
				);
			//var_dump($data);exit;
			$edit_venue = $this->ws_model->edit_venue($data, $venue_id);
			if($edit_venue == 0)
			{
				$response = array('status' => false, 'message' => 'Venue updation failed!');
			}
			else
			{	
				$banner_data = array();		
				$banners = array_filter($dataInfo);
		        if(!empty($banners))
		        {
		            foreach($banners as $banner)
		            {
		            	if($banner['file_name'])
		            	{
		            		//$this->db->delete('venue_banners', array('venue_id' => $venue_id));
							$banner_data[] = array(
								'venue_id' => $venue_id,
								'image' => 'storage/venues/'.$banner['file_name'],
								'created_on' => date('Y-m-d H:i:s')
							);	
						}				
		            }
		        }
				if(!empty($banner_data))
				{
					$this->db->insert_batch('venue_banners', $banner_data);
				}		
				
				//var_dump($slot_capacity[1]);
				$slot_capacityy = $slot_capacity;
				$this->db->delete('venue_slots', array('venue_id' => $venue_id));
	            if(!empty($start_hour))
	            {
	                foreach($start_hour as $key => $hour)
	                {
	                    //echo $key;
	                	//echo $slot_capacityy[$key];
	                	//echo $start_minute[$key];
	                	//echo $start_type[$key];
	                	if(isset($slot_capacityy[$key]))
	                	{
	                	    //echo "test";
	                		$slot_capacity = $slot_capacityy[$key];
	                	}
	                	else
	                	{
	                		$slot_capacity = 0;
	                	}
	                	//echo $slot_capacity;
	                	$start_time = date('H:i:s', strtotime($hour.':'.$start_minute[$key].' '.$start_type[$key]));
	                	$end_time = date('H:i:s', strtotime($end_hour[$key].':'.$end_minute[$key].' '.$end_type[$key]));
	                	$amount1 = $amount[$key];
	                	//$slot_capacity = 0;                	
	                	// if(isset($slot_capacity_val))
	                	// {
	                	// 	$slot_capacity = $slot_capacity_val;
	                	// }
	                    $slots_data[] = array(
							'venue_id' => $venue_id,
							'start_time' => $start_time,
							'end_time' => $end_time,
							'amount' => $amount1,
							'slot_capacity' => $slot_capacity,
							'created_on' => date('Y-m-d H:i:s')
						);
	                }
	                //var_dump($slots_data);exit;               
	                if(!empty($slots_data))
					{
						$add_slot = $this->ws_model->add_slot($slots_data);
					}
	            }
	            $this->session->set_flashdata('success', 'Venue updated successfully!');
				redirect('vendor/edit_venue/'.$venue_id, 'refresh');
			}
		}
	}

	public function delete_venue($venue_id)
	{
		$vendor_id = $this->session->userdata('vendor_id');
		$data = array(
			'vendor_id' => $vendor_id,
			'venue_id' => $venue_id,
			'created_on' => date('Y-m-d H:i:s')
			);
		$this->ws_model->vendor_delete_requests($data);
		$this->session->set_flashdata('success', 'Delete request submitted successfully!');
		redirect('vendor/venues', 'refresh');
	}

	public function temporary_slots()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');		
		$this->setHeaderFooter('vendor/temporary_slots', $data);
	}

	public function temporary_slots_ajax()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$venue_id = $this->input->post('venue_id');
		$date = date('Y-m-d', strtotime($this->input->post('date')));
		$deleted_record = $this->db->query("DELETE FROM sv_temporary_slots WHERE slot_id NOT IN(SELECT id FROM sv_venue_slots) and venue_id = $venue_id");
		$data['slots'] = $this->ws_model->list_temporary_slots($venue_id, $date);
		//echo $this->db->last_query();exit;
		//var_dump($data['slots']);
		$this->load->view('vendor/temporary_slots_ajax', $data);
	}

	public function add_temporary_slot()
	{
		extract($this->input->post());		
		$date = date('Y-m-d', strtotime($date));
		$this->db->where('venue_id', $venue_id);
		$this->db->where('date', $date);
		$this->db->delete('temporary_slots');
		
		//var_dump($start_time);exit;
		$slots_data = array();
        if(!empty($amount))
        {
            foreach($amount as $key => $price)
            {
                $slots_data[] = array(
					'venue_id' => $venue_id,
					'slot_id' => $slot_id[$key],
					'start_time' => $start_time[$key],
					'end_time' => $end_time[$key],
					'amount' => $price,
					'slot_capacity' => $slot_capacity[$key],
					'date' => $date,
					'created_on' => date('Y-m-d H:i:s')
				);
            }
        }		
		//var_dump($slots_data);exit;
		if(!empty($slots_data))
		{
			$add_slot = $this->ws_model->add_temporary_slot($slots_data);
			$this->session->set_flashdata('success', 'Request submitted successfully!');
		}
		else
		{
			$this->session->set_flashdata('failure', 'Request Failed!');
		}
		redirect('vendor/temporary_slots/'.$venue_id, 'refresh');
	}

	public function book_offline($venue_id)
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$data['details'] = $this->ws_model->vendor_venue_details($venue_id);
		$this->setHeaderFooter('vendor/book_offline', $data);
	}

	public function book_offline_ajax()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$venue_id = $this->input->post('venue_id');
		$category_id = $this->input->post('category_id');
		$date = date('Y-m-d', strtotime($this->input->post('date')));

		$deleted_record = $this->db->query("DELETE FROM sv_temporary_slots WHERE slot_id NOT IN(SELECT id FROM sv_venue_slots) and venue_id = $venue_id");
		//echo $this->db->last_query();exit;
		//$data['slots'] = $this->ws_model->list_temporary_slots($venue_id, $date);
		$data['slots'] = $this->ws_model->check_slots_available($venue_id, $date, $category_id);
		//echo $this->db->last_query();exit;
		//var_dump($data['slots']);
		$data['category_id'] = $category_id;
		$this->load->view('vendor/book_offline_ajax', $data);
	}

	/*
	*	Place Offline Order
	*/
	function place_offline_order()
	{
		$this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('vendor_id', 'Vendor Id', 'required');
        $this->form_validation->set_rules('venue_id', 'Venue ID', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        	redirect('vendor/dashboard', 'refresh');
        }
        else
        {
			$vendor_input = $this->input->post();
			extract($vendor_input);	
			
			$where = array(
    			'category_id' => $category_id,
    			'vendor_id' => $vendor_id,
    			'venue_id' => $venue_id,
    			'slot_id' => $slot_id,
    			'booking_type' => 'instant',
    			'booked_for' => date('Y-m-d', strtotime($date)),
    			);
    			
    	    $get_table_row = $this->homemodel->get_table_row('orders', $where, array());
    	    if(!empty($get_table_row) && $category_id != 7 && $category_id != 8)
    	    {
    	        echo "placed";exit;
    	    }
			
			$booking_id = mt_rand(100000, 999999);
			$data = array(
				'booking_id' => $booking_id,
				'category_id' => $category_id,
				'vendor_id' => $vendor_id,
				'venue_id' => $venue_id,
				'slot_id' => $slot_id,
				// 'total_capacity' => $total_capacity,
				// 'capacity' => $capacity,
				//'amount_paid' => $amount_paid,
				'booking_type' => 'instant',
				'payment_status' => 'paid',
				'booked_for' => date('Y-m-d', strtotime($date)),
				'booked_type' => 'offline',
				'status' => 'accepted',
				'created_on' => date('Y-m-d H:i:s')
				);
			if($capacity_applicable == "Yes")
			{
				$data['total_capacity'] = $total_capacity;
				$data['capacity'] = $capacity;
			}
			//var_dump($data);exit;
			$place_order = $this->ws_model->place_order($data, $vendor_id);

			$user_data = array(
				'order_id' => $place_order,
				'name' => $name,
				'mobile' => $mobile,
				'email_id' => $email_id,
				'created_on' => date('Y-m-d H:i:s')
				);
			$this->db->insert('offline_customers', $user_data);
			echo "success";
		}
	}

	public function calendar($venue_id)
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$data['details'] = $this->ws_model->vendor_venue_details($venue_id);
		$this->setHeaderFooter('vendor/calendar', $data);
	}

	public function calendar_ajax()
	{
		$data['title'] = "Smart Venue";
		$vendor_id = $this->session->userdata('vendor_id');
		$venue_id = $this->input->post('venue_id');
		$category_id = $this->input->post('category_id');
		$date = date('Y-m-d', strtotime($this->input->post('date')));
		$data['slots'] = $this->ws_model->check_slots_available($venue_id, $date, $category_id);
		$data['details'] = $this->ws_model->vendor_venue_details($venue_id);
		//$data['users'] = $this->ws_model->slot_booked_users($slot_id, $date);
		//echo $this->db->last_query();exit;
		//var_dump($data['slots']);
		$this->load->view('vendor/calendar_ajax', $data);
	}

	public function slot_booked_users()
	{
		$slot_id = $this->input->post('slot_id');
		$date = date('Y-m-d', strtotime($this->input->post('date')));
		$data['users'] = $this->ws_model->slot_booked_users($slot_id, $date);
		//var_dump($data['users']);
		$this->load->view('vendor/booked_users_list', $data);
	}

	private function set_upload_options()
	{
	    //upload an image options
	    $config = array();
	    $config['upload_path'] = './storage/venues';
	    $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|JPEG';
	    $config['max_size']      = '0';
	    $config['overwrite']     = FALSE;
	    return $config;
	}

	function vendor_logged_out()
    {
    	$this->session->unset_userdata('vendor_id');
    	$this->session->unset_userdata('vendor_id');
    	$this->session->unset_userdata('email_id');
        $this->session->unset_userdata('vendor_logged_in');
        redirect('vendor', 'refresh');
    }

	public function setHeaderFooter($view, $data)
	{	
		$vendor_id = $this->session->userdata('vendor_id');
		$data['profile'] = $this->vendormodel->profile($vendor_id);
		
		$this->load->view($this->header, $data);
		$this->load->view($view, $data);
		$this->load->view($this->footer);
	}

	public function vendor_logged_in()
	{
		$vendor_logged_in = $this->session->userdata('vendor_logged_in');		
		if(!isset($vendor_logged_in) || $vendor_logged_in != true)
		{
			redirect('vendor/login', 'refresh');
		}
	}
	
}
?>