<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if(! function_exists('DateFormat')){
	function checkAdminLogin(){
		$ci = &get_instance();
		if($ci->session->userdata('user_id')=='') 
		{
			redirect(base_url('admin/'));
		}
	}
}

if( ! function_exists('DateFormat')){
    function DateFormat($Date){
		return date('M d, Y', strtotime($Date));
	}
}

if( ! function_exists('DateTimeFormat')){
    function DateTimeFormat($Date = '', $Style = ''){
	
		if($Style == 'break')
			return date('d M Y', strtotime($Date)) . '<br />' . date('h:i A', strtotime($Date));
			
		return date('d M Y | h:i A', strtotime($Date));
	}
}

if( ! function_exists('TimeFormat')){
    function TimeFormat($Date = '', $Style = ''){
	
		if($Style == 'break')
			return date('d M Y', strtotime($Date)) . '<br />' . date('h:i A', strtotime($Date));
			
		return date('h:i A', strtotime($Date));
	}
}

if( ! function_exists('Ymd_to_dmY')){
    function Ymd_to_dmY($date = NULL){
		if($date) return date('d/m/Y', strtotime($date));
		return false;
	}
}

if( ! function_exists('Ymd_to_mdY')){
    function Ymd_to_mdY($date = NULL){
		if($date) return date('m/d/Y', strtotime($date));
		return false;
	}
}

if( ! function_exists('dmY_to_Ymd')){
    function dmY_to_Ymd($date = NULL){
		if($date){
			$dateInput = explode('/', $date);
			$date = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
			return $date;
		}
		return false;
	}
}

if( ! function_exists('mdY_to_Ymd')){
    function mdY_to_Ymd($date = NULL){
		if($date){
			$dateInput = explode('/', $date);
			$date = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
			return $date;
		}
		return false;
	}
}

if( ! function_exists('DeliveryTimeFormat')){
    function DeliveryTimeFormat($Time){
		$Minutes = round((strtotime($Time) - strtotime('TODAY')) / 60);
		return $Minutes < 60 ? $Minutes : date('h:i', strtotime($Time));
	}
}

if( ! function_exists('BootstrapCreatePagination')){
    function BootstrapCreatePagination($URL = '', $TotalRows = 0, $PerPage = 0, $Class = NULL){
		$ci=& get_instance();
		
		$ci->load->library('pagination');
		$config['base_url'] 		= $URL;
		$config['total_rows'] 		= $TotalRows;
		$config['per_page'] 		= $PerPage;
		$config['num_links'] 		= 5;
		$config['page_query_string']= TRUE;
		$config['full_tag_open'] 	= '<ul class="pagination">';
		$config['full_tag_close'] 	= '</ul>';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';
		
		$config['next_tag_open'] 	= '<li>';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		
		$config['prev_link'] 		= '&laquo; prev';
		$config['next_link'] 		= 'next &raquo;';
		
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '</li>';
		$config['cur_tag_open'] 	= '<li class="active"><a href="#">';
		$config['cur_tag_close'] 	= '</a></li>';
		$ci->pagination->initialize($config);
		return $ci->pagination->create_links();
	}
}


if( ! function_exists('SendEmail')){
    function SendEmail($to = '', $subject = '', $message = '', $attachs = NULL, $replyTo = NULL){
		if($to && $subject && $message){
			$ci =& get_instance();
			$ci->load->model('email_model');
			$ci->email_model->SendEmail_Basic($to, $subject, $message, $attachs, $replyTo);
		}
		return false;
	}
}


if( ! function_exists('SendSMS')){
    function SendSMS($phone = NULL, $message = NULL)
    {		
    	//echo $phone;exit;
		if($phone && $message)
		{
			$ci=& get_instance();
			$api_key = "e10df577-740e-4f74-96ac-12193192c152";
			$sms_text = urlencode($message);
			$from = 'BHATIA';
			


			//$url="http://www.bulksmsapps.com/api/apismsv2.aspx?apikey=".$api_key."&sender=".$from."&number=".$phone."&message=".$sms_text;

			$url="https://alerts.prioritysms.com/api/web2sms.php?workingkey=A5823ed82045ffceb6f48ed62f26f8ea8&sender=VDBMCI&to=".$phone."&message=".$sms_text;
//echo $url;exit;
			//$url="http://www.bulksmsapps.com/api/apismsv2.aspx?apikey=9674b0ab-afe8-412a-9692-b13bf69e64d9&sender=BHATIA&number=".$phone."&message=".$sms_text;

           // $api = "http://smsduniya.online/app/smsapi/index.php?key=".$api_key."&routeid=100183&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text;
			//$api = str_replace(" ", "+", $api);	
			//echo $api;exit;
			$curl = curl_init();	    
		    curl_setopt($curl, CURLOPT_URL, $url);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($curl, CURLOPT_HEADER, true);
		    $str = curl_exec($curl);
		
			//Print error if any
			 if(curl_errno($curl))
			 {
			 	echo 'error:' . curl_error($ch);exit;
			 	return false;
			 }		
			 curl_close($curl);			
			return true;
		}		
		return false;
	}
}


	if( ! function_exists('MessageTemplate')){
	    function MessageTemplate($Key = NULL){
			$ci=& get_instance();
			if($Key){
				$ci->db->where('Key', $Key);
				$ci->db->where('Status', 'ACTIVE');
				$Records = $ci->db->get('message_templates');
				if($Records->num_rows() > 0)
					return $Records->row()->Text;
			}
			return false;
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



function DateTimeconversion($getdate){
if(trim($getdate)!='0000-00-00 00:00:00' && trim($getdate)!=''){
return date('d-M-Y (h:i A)', strtotime($getdate));
}else{
return '';
}
}


function Dateconversion($getdate){
if(trim($getdate)!='0000-00-00'){
return date('d-M-Y', strtotime($getdate));
}else{
return '';
}
}

function Timeconversion($getdate){
if(trim($getdate)!='00:00:00' && trim($getdate)!=''){
return date('h:i A', strtotime($getdate));
}else{
return '';
}
}

 function getDynamicId($column_name,$dynamic_test){

 		$ci = &get_instance();
        /* Reference No */
        $reference_id='';
        $ci->db->select("*");
        $ci->db->from('tbl_dynamic_nos');
        $query = $ci->db->get();
        $row_count = $query->num_rows();
        if($row_count > 0){

            $refers_no = $query->row_array();
            $ref_no=$refers_no[$column_name]+1;
            $refernce_data = array($column_name => $ref_no,
                                   'update_date_time'    => date('Y-m-d H:i:s')
                                   );
            $ci->db->where('id',1);
            $update = $ci->db->update('tbl_dynamic_nos', $refernce_data);
        }else{

            $ref_no=1;
            $refernce_data =   array($column_name => $ref_no,
                                    'update_date_time'   => date('Y-m-d H:i:s')
                                    );
            $update = $ci->db->insert('tbl_dynamic_nos', $refernce_data); 
        }
        
        
        $reference_id =  $dynamic_test.$ref_no;
        
        //$reference_id="BBM".$ref_no;
        /* Reference No */
        return $reference_id;
}

function getStudentRegisterMessage($student_id){
	
    $message='Dear Doctor,Kindly download My Coaching Institute App used for your institution uses.Your ID: '.$student_id.', Password: bhatia123, Change the password as soon as you log-in in to your account. Android: https://play.google.com/store/apps/details?id=com.hyderabad.bhatia .For ios  https://apps.apple.com/in/app/mci-my-coaching-institute/id1557535056 .any doubts please Call: +919381915140 - Bhatia';
                //echo $message;exit;
        return $message;
    }
function roundInt($amount){

 return round($amount,0);

}

