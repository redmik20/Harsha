<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model{

	 	public $email_template_table='email_templetes';

	
	function SendEmail_Basic($to, $subject, $message, $attachs = NULL, $replyTo = NULL)
	{
		$username = 'norply@smartvenue.com';
		$password = 'VMmail@104';
		
		if(!$replyTo){
			$replyTo = array('email' => 'norply@smartvenue.com', 'name' => 'Coupon Up');
		}
		
		$signature = ""; 
		
		$message = $message.$signature;
		
		$this->load->library('email');
		
		$config['protocol'] 	= "sendmail";
		$config['charset'] 		= "utf-8";
		$config['mailtype'] 	= "html";
		$config['newline'] 		= "\r\n";
				
		$this->email->initialize($config);

		$this->email->from($username, 'norply@smartvenue.com');
		$this->email->to($to);			
		$this->email->reply_to($replyTo['email'], $replyTo['name']);
		$this->email->subject($subject);
		$this->email->message($message);
		
		if($attachs) foreach($attachs as $attach)
			$this->email->attach($attach);
		
		$res=$this->email->send();
		
		//echo $this->email->print_debugger();
		// exit;
		
		return $res;
	}
	
	
	function SendEmail($to, $subject, $message, $attachs = NULL, $replyTo = NULL, $cc = NULL, $bcc = NULL){
		
		//return false;

		$username = 'noreply@venuemax.in';
		$password = 'VenueMax@104';
		
		if(! $replyTo){
			$replyTo = array('email' => 'noreply@venuemax.in', 'name' => 'VenueMax');
		}
		
		$signature = ""; 
		
		$message = $message.$signature;
		
		$this->load->library('email');
		
		$config['protocol'] 	= "smtp";
		$config['smtp_host'] 	= "ssl://smtp.zoho.com";
		$config['smtp_port'] 	= "465";
		$config['smtp_user'] 	= $username; 
		$config['smtp_pass'] 	= $password;
		$config['charset'] 		= "utf-8";
		$config['mailtype'] 	= "html";
		$config['newline'] 		= "\r\n";
				
		$this->email->initialize($config);

		$this->email->from($username, 'VenueMax');
		$this->email->to($to);			
		if($cc)
			$this->email->cc($cc);	
		if($bcc)
			$this->email->bcc($bcc);
		$this->email->reply_to($replyTo['email'], $replyTo['name']);
		$this->email->subject($subject);
		$this->email->message($message);
		
		if($attachs) foreach($attachs as $attach)
			$this->email->attach($attach);
		
		$this->email->send();
		
		/*echo $this->email->print_debugger();
		exit;*/
		
		return true;
	}

	function SendGridEmail($to, $subject, $message, $attachs = NULL, $replyTo = NULL, $cc = NULL){
		
		//return false;

		$username = 'venuemax';
		$password = 'office@104';
		
		if(! $replyTo){
			$replyTo = array('email' => 'noreply@venuemax.in', 'name' => 'VenueMax');
		}
		
		$signature = ""; 
		
		$message = $message.$signature;
		

		$this->load->library('email');

		$this->email->send();

		$config['protocol'] 	= "smtp";
		$config['smtp_host'] 	= "smtp.sendgrid.net";
		$config['smtp_port'] 	= "587";
		$config['smtp_user'] 	= $username; 
		$config['smtp_pass'] 	= $password;
		$config['charset'] 		= "utf-8";
		$config['mailtype'] 	= "html";
		$config['newline'] 		= "\r\n";
				
		$this->email->initialize($config);

		$this->email->from($username, 'VenueMax');
		$this->email->to($to);			
		if($cc)
			$this->email->cc($cc);
		$this->email->reply_to($replyTo['email'], $replyTo['name']);
		$this->email->subject($subject);
		$this->email->message($message);
		
		if($attachs) foreach($attachs as $attach)
			$this->email->attach($attach);
		
		$this->email->send();
		
		/*echo $this->email->print_debugger();
		exit;*/
		
		return true;
	}

	public  function getWebSettings(){

		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('id',1);
		//$this->db->where('delete_status',1);
		$query=$this->db->get();
		$result=$query->row_array();
		return $result;

	}

	/** Function to get  Mail Template Header **/
	public function getMailHeader(){
		$mailHead	= 	$this->setMailHeaderTemplate();
		$logo		= 	'assets/images/logo.png';
		$contact	= 	$this->getWebSettings();
		//echo '<pre>';print_r($webSetting);exit;
		$website	=	str_replace("{WEBSITE}",base_url(),$mailHead);
		$folder		=	str_replace("{FOLDER}",'assets/images/main_site/',$website);
		$logo		=	str_replace("{LOGO}",$logo,$folder);
		//echo '<pre>';print_r($logo);exit;
		$email		=	str_replace("{EMAIL}",$contact['email'],$logo);
		$phone		=	str_replace("{PHONE}",$contact['mobile'],$email);
		$result = $phone;
		
		return $result;
	}
	public function setMailHeaderTemplate()
	{
		$this->db->select('content');
		$this->db->from($this->email_template_table);
		$this->db->where('event','header');		
		$result=$this->db->get();
		$result=$result->row_array();
		
		return $result['content'];
	}
	
	/** Function to Set Mail Template Footer **/
	public function setMailFooterTemplate(){
		$this->db->select('content');
		$this->db->from($this->email_template_table);
		$this->db->where('event','footer');		
		$result=$this->db->get();
		$result=$result->row_array();
		return $result['content'];
	}
	
    /** Function to get  Mail Template Footer **/
	public function getMailFooter(){
		$mailFoot		= 	$this->setMailFooterTemplate();
		//$social		= 	$this->get_social_links();
		$thanks_regards	=	str_replace("{ADDRESS}",$_SERVER['SERVER_NAME'],$mailFoot);
		$website		=	str_replace("{WEBSITE}",base_url(),$thanks_regards);
		$folder			=	str_replace("{FOLDER}",'images',$website);
		//$facebook_link	=	str_replace("{FACEBOOK}",$social['facebook_link'],$folder);
		//$twitter_link	=	str_replace("{TWITTER}",$social['twitter_link'],$facebook_link);
		//$googleplus_link=	str_replace("{GOOGLEPLUS}",$social['google_plus_link'],$twitter_link);
		//$youtube_link	=	str_replace("{YOUTUBE}",$social['youtube_link'],$googleplus_link);
		$result = $folder;
		//print_r($result);
		return $result;
	}
	function send_mail_sms($email_temp_id,$email_array,$sms_temp_id,$sms_array,$email,$mobile,$name,$user_type,$user_id=''){
		
		if($email_temp_id!=''){
			    $email_temp=$this->get_email_temp($email_temp_id);
				$email_data=$this->get_content($email_temp['content'],$email_array);
				$reason=$email_temp['event'];
				$email_data_ar=array();
				$email_data_ar['content']=$email_data;
				$email_data_ar['event']=$email_temp['event'];
				$email_data_ar['subject']=$email_temp['subject'];
				$this->mail_send($email,$email_data_ar,$name,$user_type,$user_id,$reason);
		}

		if($sms_temp_id!=''){
			$sms_temp=$this->get_sms_temp($sms_temp_id);
			$sms_data=$this->get_content($sms_temp['sms_template'],$sms_array);
			$reason=$sms_temp['sms_event'];
			$this->send_sms($mobile,$sms_data,$name,$user_type,$user_id,$reason,'yes');
		}
	}

	public function get_content($string,$data){
$fields=array(

			'{NAME}'=>isset($data['NAME'])?$data['NAME']:'',
			'{MOBILE}'=>isset($data['MOBILE'])?$data['MOBILE']:'',
			'{EMAIL}'=>isset($data['EMAIL'])?$data['EMAIL']:'',
			'{PASSWORD}'=>isset($data['PASSWORD'])?$data['PASSWORD']:'',

			'{BOOKINGID}'=>isset($data['BOOKINGID'])?$data['BOOKINGID']:'',
			'{PAYMENT_STATUS}'=>isset($data['PAYMENT_STATUS'])?$data['PAYMENT_STATUS']:'',
			'{EVENT_DATE}'=>isset($data['EVENT_DATE'])?$data['EVENT_DATE']:'',
			'{EVENT_TYPE}'=>isset($data['EVENT_TYPE'])?$data['EVENT_TYPE']:'',
			'{VENUE_NAME}'=>isset($data['VENUE_NAME'])?$data['VENUE_NAME']:'',
			'{VENUE_ADDRESS}'=>isset($data['VENUE_ADDRESS'])?$data['VENUE_ADDRESS']:'',
			'{AMOUNT_PAID}'=>isset($data['AMOUNT_PAID'])?$data['AMOUNT_PAID']:'',
			'{ORDER_TYPE}'=>isset($data['ORDER_TYPE'])?$data['ORDER_TYPE']:'',
			'{SLOT_OPEN_TIME}'=>isset($data['SLOT_OPEN_TIME'])?$data['SLOT_OPEN_TIME']:'',
			'{SLOT_END_TIME}'=>isset($data['SLOT_END_TIME'])?$data['SLOT_END_TIME']:'',
			'{BOOKING_CAPACITY}'=>isset($data['BOOKING_CAPACITY'])?$data['BOOKING_CAPACITY']:'',
			'{PACKAGE_NAME}'=>isset($data['PACKAGE_NAME'])?$data['PACKAGE_NAME']:'',


		);
	return @strtr($string,$fields);

}
	public function get_email_temp($id){
		$this->db->select('*');
		$this->db->from('email_templetes');
		$this->db->where('id', $id);
        $query = $this->db->get();
		$result =$query->row_array();
		return $result;
	}
	public function get_sms_temp($id){
		$this->db->select('*');
		 $this->db->from('sms_templates');
		$this->db->where('id', $id);
        $query = $this->db->get();
		$result =$query->row_array();
		return $result;
	}


  public function mail_send($to,$template,$name,$user_type,$user_id,$reason){
        $adminmail = $this->getWebSettings();
		$current_ip_address =  $_SERVER['REMOTE_ADDR'];	
		$header = $this->getMailHeader();
		$footer = $this->getMailFooter();
		$content=$header.$template['content'].$footer;
		//echo "<pre>";print_r($template['content']);exit;
		/*$this->load->library('email');
		$this->email->from($adminmail['email']);
		$this->email->to($to);
		$this->email->set_mailtype("html");
		$this->email->subject($template['subject']);
		$this->email->message($content);*/
		$email_reslut=$this->SendEmail_Basic($to,$template['subject'],$content);
		//$this->email->attach($pdfFilePath);
		if($email_reslut){
			$record_data = array(
			'user_type' => $user_type,
			'user_id' => $user_id,
			'name' => $name,
			'event' => $template['event'],
			'subject' => $template['subject'],
			'email_message' =>$content,
			'sent_date_time'=> date('y-m-d H:i:s'),
			'email'=>$to,
			'ip_address' =>$current_ip_address,
			'browser_name' =>$_SERVER['HTTP_USER_AGENT'],
			'status'=>1,
			);
			$result = $this->db->insert('email_history', $record_data);
		   return 1;
		}else{ 
		$record_data = array(
		   'user_type' => $user_type,
			'user_id' => $user_id,
			'name' => $name,
			'event' => $template['event'].'==>'.'<b style="color:red;">FAILED</b>',
			'subject' => $template['subject'],
			'email_message' =>  $content,
			'email'=>$to,
			'sent_date_time'=> date('y-m-d H:i:s'),
			'ip_address' =>$current_ip_address,
			'browser_name' =>$_SERVER['HTTP_USER_AGENT'],
			'status'=>0,
			);
			$result = $this->db->insert('email_history', $record_data);
			
			return 0;
		}
	}

public function send_sms($mobile_no,$sms_message,$name,$user_type='',$user_id='',$reason,$store){
	$sms_login_details=$this->sms_login_details();
		if(count($sms_login_details)!=''){
			$params = array( 
				'username' => $sms_login_details['username'],
				'password' => $sms_login_details['password'],
				'from' => $sms_login_details['sender_id'], 
				'to' =>$mobile_no, 
				'message' =>$sms_message.' - '.$_SERVER['SERVER_NAME']
			);
		$Ch=curl_init(); 
			curl_setopt($Ch, CURLOPT_URL,$sms_login_details['api_url']); 
			curl_setopt($Ch, CURLOPT_POST, true); 
			curl_setopt($Ch, CURLOPT_POSTFIELDS,http_build_query($params)); 
			curl_setopt($Ch, CURLOPT_RETURNTRANSFER, true); 
			$result=curl_exec($Ch); 
			if(strtolower($store) == 'yes'){
				$this->store_sent_sms($mobile_no,$sms_message,$name,$user_type,$user_id,$reason);
			}
			return $result;
		}
	}
	public function store_sent_sms($mobile_no,$sms_message,$name,$user_type,$user_id,$reason){
			
		$record_data = array(
			'user_id' => $user_id,
			'user_type' => $user_type,
			'user_name' =>$name,
			'mobile_no' => stripslashes($mobile_no),
			'message' => stripslashes($sms_message),
			'event' =>  stripslashes($reason),
			'sent_date_time'=> date('y-m-d H:i:s'),
			'status'=>0,
		);
		$result = $this->db->insert('dpa_sms_history',$record_data); 
	}

public function setMailBodyTemplate($id)
	{
		$this->db->select('subject,content,event');
		$this->db->from($this->email_template_table);
		$this->db->where('id',$id);		
		$result=$this->db->get();
		//$result=$result->row_array();
		return $result->row_array();
	}



}