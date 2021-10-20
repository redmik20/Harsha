<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vendormodel extends CI_Model
{
	public function login($mobile, $password)
	{
		//echo $password;exit;
		$this->db->select('email_id, password, id, name');
		$this->db->from('vendors');
		$this->db->where('mobile', $mobile);
        $this->db->where('status', 'Active');
		$this->db->where('password', md5($password));		
		$query = $this->db->get();	
		//echo $this->db->last_query();exit;
		if ($query !== FALSE)
		{	
			if($query->num_rows() > 0){
				return $query->row();
			}else{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

    public function vendor_block_status($mobile)
    {
        //echo $password;exit;
        $this->db->select('id');
        $this->db->from('vendors');
        $this->db->where('mobile', $mobile);
        $this->db->where('status', 'Inactive');
        $query = $this->db->get();  
        //echo $this->db->last_query();exit;
        if ($query !== FALSE)
        {   
            return $query->num_rows();
        }
        else
        {
            return 0;
        }       
    }


    public function check_product_code($product_id, $product_code)
    {
        if($product_id)
        {
             $this->db->where('id !=', $product_id);
        }
        if($product_code)
        {
             $this->db->where('product_code', $product_code);              
            $this->db->where('delete_status',  1);
            $query = $this->db->get('products'); 
            //echo $this->db->last_query();exit;
            return $query->num_rows(); 
        }
    }

	public function check_email_id_exists($vendor_id, $email_id)
    {
        if($vendor_id)
        {
             $this->db->where('id !=', $vendor_id);
        }
        if($email_id)
        {
             $this->db->where('email_id', $email_id);              
	        $this->db->where('delete_status',  1);
	        $query = $this->db->get('vendors'); 
	        //echo $this->db->last_query();exit;
	        return $query->num_rows(); 
    	}
    }

    public function check_mobile_exists($vendor_id, $mobile)
    {
        if(!empty($vendor_id))
        {
             $this->db->where('id !=', $vendor_id);
        }
        if(!empty($mobile) )
        {
            $this->db->where('mobile', $mobile);               
	        $this->db->where('delete_status',  1);
	        $query = $this->db->get('vendors'); 
	        //echo $this->db->last_query();exit;
	        return $query->num_rows(); 
	    }
    }

	public function submit_register($data)
    {
        $this->db->insert('vendors', $data); 
        //echo $this->db->last_query();exit;            
        return true;
    }

    public function profile($vendor_id)
    {        
        $this->db->where('id', $vendor_id);
        $this->db->select('vendors.*');
        //$this->db->select("IF ((SELECT COUNT(*) FROM `followers` where vendor_id = '$vendor_id' and followers.vendor_id = designers.id) >0, 'Unfollow', 'Follow') as following");
        $query = $this->db->get('vendors');
        //echo $this->db->last_query();exit;     
        return $query->row();
    }

    public function update_password($data, $vendor_id)
    {
        $this->db->where('id', $vendor_id);
        $this->db->update('vendors', $data); 
        //echo $this->db->last_query();exit;            
        return true;
    }

    public function update_profile($data, $vendor_id)
    {
    	$this->db->where('id', $vendor_id);
        $this->db->update('vendors', $data); 
        //echo $this->db->last_query();exit;            
        return true;
    }

    public function get_categories()
    {
        $query = $this->db->get('categories');      
        return $query->result();
    }

    public function get_sub_categories($category_id)
    {
        $this->db->where('category_id', $category_id);
        $query = $this->db->get('sub_categories');      
        return $query->result();
    }

    public function get_types()
    {
        $query = $this->db->get('types');      
        return $query->result();
    }

    public function get_colors()
    {
        $query = $this->db->get('color_codes');      
        return $query->result();
    }

    public function upload_product($data)
    {
        $this->db->insert('products', $data); 
        //echo $this->db->last_query();exit;            
        return $this->db->insert_id();
    }

    public function manage_products($params = array())
    {
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
        {
            $this->db->limit($params['limit'],$params['start']);
        }
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
        {
            $this->db->limit($params['limit']);
        }
        
        $this->db->order_by('id', 'desc');
        $url = explode('=', $_SERVER['REQUEST_URI']);
        if(isset($url[1]))
        {
            $filters = explode(',', $url[1]);
            if(isset($filters[0]) && $filters[0] != "")
            {
                $this->db->where('gender', $filters[0]);
            }
            if(isset($filters[1]) && $filters[1] != "")
            {
                $this->db->where('category_id', $filters[1]);
            }
        }
        $this->db->where('vendor_id', $this->session->userdata('vendor_id'));       
        $this->db->where('products.delete_status', 1);
        $this->db->select('products.*, DATE_FORMAT(products.created_on,"%d %M %Y") as uploaded_on, categories.title as category');
        $this->db->join('categories', 'categories.id=products.category_id');
        $query = $this->db->get('products');
        //echo $this->db->last_query();     
        $res = $query->result();
        if(!empty($res))
        {
            foreach($res as $row)
            {
                $image = $this->get_single_product_image($row->id);
                $data[] = array(
                    'product_id' => $row->id,
                    'name' => $row->name,
                    'new_price' => $row->new_price,
                    'old_price' => $row->old_price,
                    'gender' => $row->gender,
                    'category' => $row->category,
                    'product_code' => $row->product_code,
                    'image' => $image->image,
                    'uploaded_on' => $row->uploaded_on
                    );
            }
            return $data;
        }
    }

    public function orders($params = array(), $status)
    {
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
        {
            $this->db->limit($params['limit'],$params['start']);
        }
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
        {
            $this->db->limit($params['limit']);
        }
        
        $this->db->order_by('id', 'desc');
        // $url = explode('=', $_SERVER['REQUEST_URI']);
        // if(isset($url[1]))
        // {
        //     $filters = explode(',', $url[1]);
        //     if(isset($filters[0]) && $filters[0] != "")
        //     {
        //         $this->db->where('gender', $filters[0]);
        //     }
        //     if(isset($filters[1]) && $filters[1] != "")
        //     {
        //         $this->db->where('category_id', $filters[1]);
        //     }
        // }
        $this->db->where('products.vendor_id', $this->session->userdata('vendor_id'));       
        $this->db->where('products.delete_status', 1);
        $this->db->where('order_products.status', $status);
        $this->db->join('products', 'products.id=order_products.product_id');
        $this->db->select('products.*, DATE_FORMAT(products.created_on,"%d %M %Y") as uploaded_on, categories.title as category');
        $this->db->select('orders.booking_id, DATE_FORMAT(orders.created_on,"%d %M %Y") as ordered_on');
        $this->db->join('categories', 'categories.id=products.category_id');
        $this->db->join('orders', 'orders.id=order_products.order_id');
        $query = $this->db->get('order_products');
        //echo $this->db->last_query();     
        $res = $query->result();
        if(!empty($res))
        {
            foreach($res as $row)
            {
                $image = $this->get_single_product_image($row->id);
                $data[] = array(
                    'product_id' => $row->id,
                    'name' => $row->name,
                    'new_price' => $row->new_price,
                    'old_price' => $row->old_price,
                    'gender' => $row->gender,
                    'category' => $row->category,
                    'product_code' => $row->product_code,
                    'image' => $image->image,
                    'uploaded_on' => $row->uploaded_on,
                    'booking_id' => $row->booking_id,
                    'ordered_on' => $row->ordered_on,
                    );
            }
            return $data;
        }
    }

    public function out_of_stock_products($params = array())
    {
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
        {
            $this->db->limit($params['limit'],$params['start']);
        }
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
        {
            $this->db->limit($params['limit']);
        }
        
        $this->db->order_by('products.id', 'desc');
        $url = explode('=', $_SERVER['REQUEST_URI']);
        if(isset($url[1]))
        {
            $filters = explode(',', $url[1]);
            if(isset($filters[0]) && $filters[0] != "")
            {
                $this->db->where('gender', $filters[0]);
            }
            if(isset($filters[1]) && $filters[1] != "")
            {
                $this->db->where('category_id', $filters[1]);
            }
        }
        $where_au = "(ones_quantity <= 0 OR xs_quantity <= 0 OR s_quantity <= 0 OR m_quantity <= 0 OR l_quantity <= 0 OR xl_quantity <= 0)";
        $this->db->where('products.delete_status', 1);
        $this->db->where('products.vendor_id', $this->session->userdata('vendor_id'));
        $this->db->where($where_au, NULL, FALSE);
        $this->db->select('products.*, DATE_FORMAT(products.created_on,"%d %M %Y") as uploaded_on, categories.title as category');
        $this->db->join('categories', 'categories.id=products.category_id');
        $query = $this->db->get('products'); 
        //echo $this->db->last_query();exit;     
        $res = $query->result();
        if(!empty($res))
        {
            foreach($res as $row)
            {
                $image = $this->get_single_product_image($row->id);
                $data[] = array(
                    'product_id' => $row->id,
                    'name' => $row->name,
                    'new_price' => $row->new_price,
                    'old_price' => $row->old_price,
                    'gender' => $row->gender,
                    'category' => $row->category,
                    'product_code' => $row->product_code,
                    'image' => $image->image,
                    'uploaded_on' => $row->uploaded_on,
                    'ones_quantity' => $row->ones_quantity,
                    'xs_quantity' => $row->xs_quantity,
                    's_quantity' => $row->s_quantity,
                    'm_quantity' => $row->m_quantity,
                    'l_quantity' => $row->l_quantity,
                    'xl_quantity' => $row->xl_quantity
                    );
            }
            return $data;
        }
    }

    public function get_single_product_image($product_id)
    {
        $this->db->limit(1);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('product_images');      
        return $query->row();
    }

    public function view_product_details($product_id)
    {
        $this->db->where('products.delete_status', 1);
        $this->db->where('products.id', $product_id);
        $this->db->select('products.*, DATE_FORMAT(products.created_on,"%d %M %Y") as uploaded_on, categories.title as category, color_codes.name as color_name, color_codes.code as color_code, sub_categories.title as sub_category, types.title as type_title');
        $this->db->join('categories', 'categories.id=products.category_id');
        $this->db->join('sub_categories', 'sub_categories.id=products.sub_category_id');
        $this->db->join('types', 'types.id=products.type');
        $this->db->join('color_codes', 'color_codes.id=products.color_id');
        $query = $this->db->get('products'); 
        //echo $this->db->last_query();exit;     
        $row = $query->row();
        if(!empty($row))
        {            
            $images = $this->get_multiple_product_images($row->id);
            $data = array(
                'product_id' => $row->id,
                'name' => $row->name,
                'new_price' => $row->new_price,
                'old_price' => $row->old_price,
                'gender' => $row->gender,
                'category' => $row->category,
                'sub_category' => $row->sub_category,
                'type_title' => $row->type_title,
                'category_id' => $row->category_id,
                'sub_category_id' => $row->sub_category_id,
                'type' => $row->type,
                'color_id' => $row->color_id,
                'available_sizes' => $row->available_sizes,
                'product_code' => $row->product_code,
                'item_code' => $row->item_code,
                'short_description' => $row->short_description,
                'long_description' => $row->long_description,
                'color_name' => $row->color_name,
                'color_code' => $row->color_code,
                'images' => $images,
                'uploaded_on' => $row->uploaded_on,
                'ones_quantity' => $row->ones_quantity,
                'xs_quantity' => $row->xs_quantity,
                's_quantity' => $row->s_quantity,
                'm_quantity' => $row->m_quantity,
                'l_quantity' => $row->l_quantity,
                'xl_quantity' => $row->xl_quantity
                );
            
            return $data;
        }
    }

    public function get_multiple_product_images($product_id)
    {
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('product_images');      
        return $query->result();
    }

    public function edit_uploaded_product($data, $product_id)
    {
        $this->db->where('id', $product_id);
        $this->db->update('products', $data); 
        //echo $this->db->last_query();exit;            
        return true;
    }

    function online_bookings($vendor_id, $status = "pending", $numItems = 0)
    {
        $this->db->limit(6, $numItems);

        $this->db->order_by('orders.id', 'desc');
        if($status != "cancelled by vendor")
        {
            $this->db->where('orders.booked_type', 'online');
        }       
        $this->db->where('orders.status', $status);
        $this->db->where('orders.vendor_id', $vendor_id);
        $this->db->join('categories', 'categories.id = orders.category_id');
        $this->db->join('venues', 'venues.id = orders.venue_id');
        $this->db->join('users', 'users.id = orders.user_id', 'left');
        $this->db->join('venue_slots', 'venue_slots.id = orders.slot_id', 'left');
        $this->db->join('offline_customers', 'offline_customers.order_id = orders.id', 'left');
        $this->db->select('orders.*, venues.*, categories.capacity as capacity_applicable, categories.token_amount, venue_slots.start_time, venue_slots.end_time, orders.id as order_id, categories.from_range, users.name, users.mobile, users.email_id as user_email_id, orders.created_on');
        $this->db->select('offline_customers.name as offline_name, offline_customers.mobile as offline_mobile, offline_customers.email_id as offline_email_id');
        $orders = $this->db->get('orders'); 
        //echo $this->db->last_query();
        if($orders->num_rows() > 0)
        {
            $res = $orders->result();
            foreach($res as $row)
            {
                $final_data[] = array(
                    "id" => $row->id,
                    "vendor_id" => $row->vendor_id,
                    "city_id" => $row->city_id,
                    "area_id" => $row->area_id,
                    "category_id" => $row->category_id,
                    "event_types" => $row->event_types,
                    "venue_name" => $row->venue_name,
                    "address" => $row->address,
                    "lat" => $row->lat,
                    "lng" => $row->lng,
                    "people_capacity" => $row->people_capacity,
                    "price" => $row->price,
                    "discount_percentage" => $row->discount_percentage,
                    "token_amount" => $row->token_amount,
                    "description" => $row->description,
                    "venue_type" => $row->venue_type,
                    "amenities" => $row->amenities,
                    "services" => $row->services,
                    "ac" => $row->ac,
                    "veg" => $row->veg,
                    "contact_number" => $row->contact_number,
                    "email_id" => $row->email_id,
                    "image" => $row->image,                 
                    //"amenities_images" => $row->amenities_images,
                    "capacity_applicable" => $row->capacity_applicable,
                    "delete_status" => $row->delete_status,                 
                    "order_id" => $row->order_id,
                    "booking_id" => $row->booking_id,
                    "user_id" => $row->user_id,
                    "category_id" => $row->category_id,
                    "venue_id" => $row->venue_id,
                    "slot_id" => $row->slot_id,
                    "total_capacity" => $row->total_capacity,
                    "capacity" => $row->capacity,
                    "amount_paid" => $row->amount_paid,
                    "booking_type" => $row->booking_type,
                    "booked_for" => date('d, F, Y', strtotime($row->booked_for)),
                    "start_time" => date('h:i A', strtotime($row->start_time)),
                    "end_time" => date('h:i A', strtotime($row->end_time)),
                    "payment_status" => $row->payment_status,
                    "status" => $row->status,
                    "cancellation_reason" => $row->cancellation_reason,
                    "booked_on" => date('d F Y H:i A', strtotime($row->created_on)),
                    "created_on" => date('Y-m-d', strtotime($row->created_on)),
                    "name" => $row->name,
                    "mobile" => $row->mobile,
                    "user_email_id" => $row->user_email_id,
                    "offline_name" => $row->offline_name,
                    "offline_mobile" => $row->offline_mobile,
                    "offline_email_id" => $row->offline_email_id,
                );
            }
            return $final_data;
        }
        return array();
    }

    function offline_bookings($vendor_id, $numItems = 0)
    {
        $this->db->limit(6, $numItems);
        $this->db->order_by('orders.id', 'desc');
        $this->db->where('orders.status', "accepted");
        $this->db->where('orders.booked_type', 'offline');
        $this->db->where('orders.vendor_id', $vendor_id);
        $this->db->join('categories', 'categories.id = orders.category_id');
        $this->db->join('venues', 'venues.id = orders.venue_id');
        $this->db->join('offline_customers', 'offline_customers.order_id = orders.id');
        $this->db->join('venue_slots', 'venue_slots.id = orders.slot_id');
        $this->db->select('orders.*, venues.*, categories.capacity as capacity_applicable, categories.token_amount, venue_slots.start_time, venue_slots.end_time, orders.id as order_id, categories.from_range, offline_customers.name, offline_customers.mobile, offline_customers.email_id as user_email_id');
        $orders = $this->db->get('orders'); 
        //echo $this->db->last_query();exit;
        if($orders->num_rows() > 0)
        {
            $res = $orders->result();
            foreach($res as $row)
            {
                $final_data[] = array(
                    "id" => $row->id,
                    "vendor_id" => $row->vendor_id,
                    "city_id" => $row->city_id,
                    "area_id" => $row->area_id,
                    "category_id" => $row->category_id,
                    "event_types" => $row->event_types,
                    "venue_name" => $row->venue_name,
                    "address" => $row->address,
                    "lat" => $row->lat,
                    "lng" => $row->lng,
                    "people_capacity" => $row->people_capacity,
                    "price" => $row->price,
                    "discount_percentage" => $row->discount_percentage,
                    "token_amount" => $row->token_amount,
                    "description" => $row->description,
                    "venue_type" => $row->venue_type,
                    "amenities" => $row->amenities,
                    "services" => $row->services,
                    "ac" => $row->ac,
                    "veg" => $row->veg,
                    "contact_number" => $row->contact_number,
                    "email_id" => $row->email_id,
                    "image" => $row->image,                 
                    //"amenities_images" => $row->amenities_images,
                    "capacity_applicable" => $row->capacity_applicable,
                    "delete_status" => $row->delete_status,                 
                    "order_id" => $row->order_id,
                    "booking_id" => $row->booking_id,
                    "user_id" => $row->user_id,
                    "category_id" => $row->category_id,
                    "venue_id" => $row->venue_id,
                    "slot_id" => $row->slot_id,
                    "total_capacity" => $row->total_capacity,
                    "capacity" => $row->capacity,
                    "amount_paid" => $row->amount_paid,
                    "booking_type" => $row->booking_type,
                    "booked_for" => date('d F Y', strtotime($row->booked_for)),
                    "start_time" => date('h:i A', strtotime($row->start_time)),
                    "end_time" => date('h:i A', strtotime($row->end_time)),
                    "payment_status" => $row->payment_status,
                    "status" => $row->status,
                    "cancellation_reason" => $row->cancellation_reason,
                    "booked_on" => date('d F Y', strtotime($row->created_on)),
                    "created_on" => date('Y-m-d', strtotime($row->created_on)),
                    "name" => $row->name,
                    "mobile" => $row->mobile,
                    "user_email_id" => $row->user_email_id,
                );
            }
            return $final_data;
        }
        return array();
    }

    function shortlists($vendor_id, $numItems = 0)
    {
        $this->db->limit(6, $numItems);
        $this->db->where('favourites.vendor_id', $vendor_id);
        $this->db->join('venues', 'venues.id = favourites.venue_id');
        $this->db->join('users', 'users.id = favourites.user_id');
        $this->db->select('venues.venue_name, users.name, users.mobile, users.email_id, venues.address, venues.image, favourites.created_on');
        $notifications = $this->db->get('favourites');  
        //echo $this->db->last_query();exit;
        if($notifications->num_rows() > 0)
        {
            return $notifications->result_array();
        }
        return array();
    }

    function venues($vendor_id, $numItems = 0)
    {
        $this->db->order_by('venues.id', 'desc');
        $this->db->where('venues.delete_status', 1);
        $this->db->limit(6, $numItems);
        $this->db->where('vendor_id', $vendor_id);
        $this->db->join('categories', 'categories.id = venues.category_id');
        $this->db->select('venues.*');
        $this->db->select("(SELECT cast(AVG(ratings) as decimal(6,1)) FROM sv_venue_ratings where sv_venue_ratings.venue_id = sv_venues.id) as ratings");
        $venues = $this->db->get('venues'); 
        //echo $this->db->last_query();exit;
        if($venues->num_rows() > 0)
        {
            return $venues->result();
        }
        return array();
    }

    public function get_venues($category_id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('venues.delete_status', 1);
        $this->db->where('category_id', $category_id);
        $this->db->select('id, venue_name');
        $query = $this->db->get('venues');      
        return $query->result();
    }    

    public function get_pricings($category_id, $venue_id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('category_id', $category_id);
        $this->db->where('venue_id', $venue_id);
        $this->db->select('*');
        $query = $this->db->get('category_extra_details');      
        return $query->result();
    }

    public function get_order_capacity($order_id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('order_id', $order_id);
        $this->db->select('*');
        $query = $this->db->get('order_extras');
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        return array();
    }

    public function get_policy($category_id, $vendor_id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('category_id', $category_id);
        $this->db->where('vendor_id', $vendor_id);
        $this->db->select('*');
        $query = $this->db->get('vendor_cancellation_policy');      
        return $query->result();
    }	

    public function get_order_details($order_id)
    {
        $this->db->where('orders.id', $order_id);
        $this->db->where('venues.delete_status', 1);
        $this->db->join('venue_slots', 'venue_slots.id = orders.slot_id', 'left');
        $this->db->join('venues', 'venues.id = orders.venue_id');
        $this->db->join('vendors', 'vendors.id = venues.vendor_id');
        $this->db->join('users', 'users.id = orders.user_id');
        $this->db->select('orders.*, venues.*, venue_slots.*, orders.created_on, vendors.email_id as vendor_email_id, vendors.name as vendor_name, users.name as user_name, venues.price as venue_price, venues.contact_number as venue_mobile, venues.address as venue_address, users.mobile as user_mobile, vendors.mobile as vendor_mobile, users.email_id as user_email_id');
        $query = $this->db->get('orders');
        return $query->row();
    }
}
?>