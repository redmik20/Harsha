<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if( ! function_exists('user_by_id')){
	    function user_by_id($user_id = NULL)
	    {		
			if($user_id)
			{
				$ci=& get_instance();
				$result = $ci->db->get_where('users', array('id' => $user_id, 'delete_status' => 1));
				//echo $ci->db->last_query();exit;
				if($result->num_rows() > 0){
					return $result->row_array();
				}
			}
			return array();
		}
	}


if( ! function_exists('check_user_mobile_exists')){
    function check_user_mobile_exists($mobile = NULL)
    {		
		if($mobile)
		{
			$ci=& get_instance();
			$Result = $ci->db->get_where('users', array('mobile' => $mobile, 'delete_status' => 1));
			//echo $ci->db->last_query();exit;
			if($Result->num_rows() > 0)
			{
				return $Result->row();
			}
			else
			{
				return array();
			}
		}
		return array();
	}
}

if( ! function_exists('check_user_mobile_status')){
    function check_user_mobile_status($mobile = NULL)
    {		
		if($mobile)
		{
			$ci=& get_instance();
			$Result = $ci->db->get_where('users', array('mobile' => $mobile, 'delete_status' => 1, 'status' => 1));
			//echo $ci->db->last_query();exit;
			if($Result->num_rows() > 0)
			{
				return $Result->row();
			}
			else
			{
				return array();
			}
		}
		return array();
	}
}

if( ! function_exists('check_user_email_id_status')){
    function check_user_email_id_status($email_id = NULL)
    {		
		if($email_id)
		{
			$ci=& get_instance();
			$Result = $ci->db->get_where('users', array('email_id' => $email_id, 'delete_status' => 1, 'status' => 1));
			//echo $ci->db->last_query();exit;
			if($Result->num_rows() > 0)
			{
				return $Result->row();
			}
			else
			{
				return array();
			}
		}
		return array();
	}
}

if( ! function_exists('check_user_email_id_exists')){
    function check_user_email_id_exists($email_id = NULL)
    {		
		if($email_id)
		{
			$ci=& get_instance();
			$Result = $ci->db->get_where('users', array('email_id' => $email_id, 'delete_status' => 1));
			//echo $ci->db->last_query();
			if($Result->num_rows() > 0)
			{
				return $Result->row();
			}
			else
			{
				return array();
			}
		}
		return array();
	}

	if( ! function_exists('users_by_id')){
	    function users_by_id($user_id = NULL)
	    {		
			if($user_id)
			{

				$ci=& get_instance();
				$Result = $ci->db->get_where('users_exams', array('id' => $user_id,  'delete_status' => 1));
                  //echo $ci->db->last_query();

				if($Result->num_rows() > 0){
					return $Result->row();
				}
			}
			return array();
		}
	}

	if( ! function_exists('user_by_email_id')){
	    function user_by_email_id($email_id = NULL)
	    {		
			if($email_id)
			{
				$ci=& get_instance();
				$Result = $ci->db->get_where('users', array('email_id' => $email_id, 'delete_status' => 1));
				if($Result->num_rows() > 0)
					return $Result->row();
			}
			return array();
		}
	}  

	if( ! function_exists('check_user_exam_id_exists')){
    function check_user_exam_id_exists($exam_id = NULL)
    {		
		if($exam_id)
		{
			$ci=& get_instance();
			$Result = $ci->db->get_where('users_exams', array('exam_id' => $exam_id, 'delete_status' => 1));
			echo $ci->db->last_query();exit;
			if($Result->num_rows() > 0)
			{
				return $Result->row();
			}
			else
			{
				return array();
			}
		}
		return array();
	}
  }

  if( ! function_exists('check_user_exam_id_status')){
    function check_user_exam_id_status($exam_id = NULL)
    {		
		if($exam_id)
		{
			$ci=& get_instance();
			$Result = $ci->db->get_where('users_exams', array('exam_id' => $exam_id, 'delete_status' => 1, 'status' => 1));
			//echo $ci->db->last_query();exit;
			if($Result->num_rows() > 0)
			{
				return $Result->row();
			}
			else
			{
				return array();
			}
		}
		return array();
	}
}  

if( ! function_exists('users_by_id')){
	    function users_by_id($user_id = NULL)
	    {

	    if($user_id)
	    {
	    	$ci=& get_instance();
	    	$Result = $ci->db->$this->db->select('*');    
         $this->db->from('users_exams');
         $this->db->join('users', 'users_exams.user_id = users.id','JOIN Type');
         $this->db->join('exams', 'users_exams.exam_id = exams.id');
          $Result = $this->db->get('users_exams');

          if($Result->num_rows() > 0)
			{
				return $Result->row();
			}
			else
			{
				return array();
			}
		}
		return array();
	}
}  

if( ! function_exists('SendSMS')){
    function SendSMS($phone = NULL, $message = NULL)
    {		
		if($phone && $message)
		{
			$ci=& get_instance();
	    	// Account details
	    	/*$apiKey = urlencode('erWTP/XXuLo-pA5P7UN0IAjFJlrNxtmfAi8Oq1fa1m');
	    	
	    	// Message details
	    	$numbers = array($phone);
	    	$sender = urlencode('TXTLCL');
	    	$message = rawurlencode($message);
	     
	    	$numbers = implode(',', $numbers);
	     
	    	// Prepare data for POST request
	    	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "message" => $message);
	     
	    	// Send the POST request with cURL
	    	$ch = curl_init('https://api.textlocal.in/send/');
	    	curl_setopt($ch, CURLOPT_POST, true);
	    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    	$response = curl_exec($ch);
	    	curl_close($ch);
	    	
	    	// Process your response here
	    	//echo $response;*/
	    	$api_key="e10df577-740e-4f74-96ac-12193192c152";
	    	$message1=urlencode($message);
	    	//$url1="http://www.bulksmsapps.com/apisms.aspx?user=DRBHATIA&password=ISSMHYD@999&genkey=639510555&sender=BHATIA&number=".$phone."&message=".$message1;
	        $url2="http://www.bulksmsapps.com/api/apismsv2.aspx?apikey=".$api_key."&sender=PLATOS&number=".$phone."&message=".$message1;
            //echo $url2;exit;
	    	$curl = curl_init();	    
		    curl_setopt($curl, CURLOPT_URL, $url2);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($curl, CURLOPT_HEADER, true);
		    $str = curl_exec($curl);
		    //Print error if any
			// if(curl_errno($ch))
			// {
			// 	echo 'error:' . curl_error($ch);
			// }		
			// curl_close($ch);	
	    	
			return true;
		}		
		return false;
	}
}

if( ! function_exists('SendSMS1')){
    function SendSMS1($phone = NULL, $message = NULL)
    {
    	/*$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://auth.routee.net/oauth/token",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "grant_type=client_credentials",
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Basic NWYyYmI0M2Q4YjcxZGU1OTA0MWI2ZDdmOm9VVm92RDlzUjY=",
		    "content-type: application/x-www-form-urlencoded"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo '<pre>';print_r($response);exit;
		}*/

		    $otp = mt_rand(1000, 9999);
			$message=array(
							'body'=>'Dear User, '.$otp.' is One time password (OTP) for PLATO. Thank You.',
							'to'=>'+917093668623',
							'from'=>'PLATOS'
							);

				$curl = curl_init();

				curl_setopt_array($curl, array(
				CURLOPT_URL => "https://connect.routee.net/sms",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "{ \"body\": \"A new game has been posted to the MindPuzzle. Check it out\",\"to\" : \"+917093668623\",\"from\": \"amdTelecom\"}",
				//CURLOPT_POSTFIELDS =>json_encode($message),
				CURLOPT_HTTPHEADER => array(
				"authorization: Bearer e74a3597-6d5d-4098-8aa5-1c271f6265a7",
				"content-type: application/json"
				),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
				echo "cURL Error #:" . $err;
				} else {
				 echo '<pre>';print_r($response);exit;
				}

    }

}


	if( ! function_exists('get_table_row')){
		function get_table_row($table_name='', $where='', $columns='', $order_column='', $order_by='asc', $limit='')
		{
			$ci=& get_instance();
			if(!empty($columns)) {
			$tbl_columns = implode(',', $columns);
			$ci->db->select($tbl_columns);
			}
			if(!empty($where)) $ci->db->where($where);
			if(!empty($order_column)) $ci->db->order_by($order_column, $order_by); 
			if(!empty($limit)) $ci->db->limit($limit); 
			$query = $ci->db->get($table_name);
			if($columns=='test') { echo $ci->db->last_query(); exit; }
			  //echo $ci->db->last_query();
			return $query->row_array();
		}
	}

	if( ! function_exists('get_table')){
	 	function get_table($table_name='', $where='', $columns='', $order_column='', $order_by='asc', $limit='', $offset='')
	 	{
	 		$ci=& get_instance();
			if(!empty($columns)) 
			{
			$tbl_columns = implode(',', $columns);
			$ci->db->select($tbl_columns);
			}
			if(!empty($where)) $ci->db->where($where);
			if(!empty($order_column)) $ci->db->order_by($order_column, $order_by); 
			if(!empty($limit) && !empty($offset)) $ci->db->limit($limit, $offset); 
			else if(!empty($limit)) $ci->db->limit($limit); 
			$query = $ci->db->get($table_name);
			//echo $ci->db->last_query(); exit;
			//if($columns=='test') { echo $ci->db->last_query(); exit; }
			//echo $ci->db->last_query();
			return $query->result_array();
		}	
	}

	if( ! function_exists('insert_table'))
	{
		function insert_table($table_name='', $array='', $insert_id ='', $batch=false)
		{
			$ci=& get_instance();
			if(!empty($array) && !empty($table_name))
			{
				if($batch)
				{
					$ci->db->insert_batch($table_name, $array);
				}
				else 
				{
					$ci->db->insert($table_name, $array);
				}
				//echo $ci->db->last_query(); exit;
				//if(!empty($insert_id)) return $ci->db->insert_id();
				return $ci->db->insert_id();
			}
			return 0;
		}
	}

	if( ! function_exists('update_table'))
	{
		function update_table($table_name='', $array='', $where ='')
		{
			$ci=& get_instance();
			if(!empty($array) && !empty($table_name))
			{
				$ci->db->where($where);
				$ci->db->update($table_name, $array);				
				if($ci->db->affected_rows() > 0)
				{
					return true;
				}
			}
			return false;
		}
	}

	if( ! function_exists('delete_record'))
	{
		function delete_record($table_name='', $array='')
		{
			$ci=& get_instance();
			if(!empty($array) && !empty($table_name))
			{
				$ci->db->delete($table_name, $array);
				return true;		
			}
			return false;
		}
	}  

	if( ! function_exists('check_user_banners_exists')){
    function check_user_banners_exists($exam_id = NULL)
    {		
		if($exam_id)
		{
			$ci=& get_instance();
			$Result = $ci->db->get_where('banners', array('exam_id' => $exam_id, 'delete_status' => 1));
			//echo $ci->db->last_query();exit;
			if($Result->num_rows() > 0)
			{
				return $Result->row();
			}
			else
			{
				return array();
			}
		}
		return array();
	}
  }

  if( ! function_exists('check_user_input_exists')){
    function check_user_input_exists($mobile = NULL, $email_id = NULL)
    {		
		if($mobile!='')
		{
			$ci=& get_instance();
			$Result = $ci->db->get_where('users', array('mobile' => $mobile, 'delete_status' => 1));
		}
		if($email_id!=''){
			$ci=& get_instance();
			$Result = $ci->db->get_where('users', array('email_id'=> $email_id, 'delete_status' => 1));
		}
			//echo $ci->db->last_query();exit;
			if($Result->num_rows() > 0)
			{
				return $Result->row();
			}
			else
			{
				return array();
			}
		}
		return array();
	}
} 

if( ! function_exists('get_unique_id')){

function get_unique_id(){
	return $passcode = mt_rand(10000000, 99999999);
}
}

if( ! function_exists('upload_image')){
    function upload_image($image_data= array())
    {
        $encoded_string = $image_data['image'];
        $imgdata = base64_decode($encoded_string);
        $data = getimagesizefromstring($imgdata);
        $extension = explode('/',$data['mime']);       
        define('UPLOAD_DIR', $image_data['upload_path']);
        $img = str_replace('data:'.$data['mime'].';base64,', '', $image_data['image']);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = $image_data['file_path'] . uniqid() . '.'.$extension[1];
        $success = file_put_contents($file, $data);

        if($success)
        {
            $status = true;
            $result = $file;
        }
        else
        {
            $status = false;
            $result = '';   
        }
        $response = array('status' => $status,'result' => $result);
        return $response;       
    }
}

