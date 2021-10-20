<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if( ! function_exists('TrackResponse')){

	function TrackResponse($Req = '', $Res = '') { 

		$ci=& get_instance();

		

		$TrackData = array(

			'Method' => $ci->router->fetch_method(),

			'Request' => serialize($Req),

			'Response' => serialize($Res),

			'Date' => date('Y-m-d H:i:s')

		);

		$ci->db->insert('mobile_tracking', $TrackData);

		return true;

	}

}


if( ! function_exists('user_by_mobile')){

    function user_by_mobile($mobile = NULL){

		

		if($mobile){

			$ci=& get_instance();

			$Result = $ci->db->get_where('users', array('mobile' => $mobile));

			if($Result->num_rows() > 0)

				return $Result->row()->id;

		}

		return false;

	}

}

if( ! function_exists('Dateconversion')){



function Dateconversion($getdate){

if(trim($getdate)!='0000-00-00'){

return date('d-M-Y', strtotime($getdate));

}else{

return '';

}

}

}

if( ! function_exists('Timeconversion')){



function Timeconversion($getdate){

if(trim($getdate)!='00:00:00' && trim($getdate)!=''){

return date('h:i A', strtotime($getdate));

}else{

return '';

}

}

}



if( ! function_exists('GetOTP')){

function GetOTP(){

	return $otp = mt_rand(100000, 999999);

}

}

if( ! function_exists('is_decimal')){

function is_decimal($val){

	return is_numeric( $val ) && floor( $val ) != $val;

}

}










