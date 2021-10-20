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
		//$ci->db->insert('mobile_tracking', $TrackData);
		return true;
	}
}

if( ! function_exists('startApi')){
	function startApi($Req = '') {
		$date = new DateTime(); 
		$ci=& get_instance();
		//echo '<pre>';print_r($ci->router->fetch_method());exit;
		$TrackData = array(
			'method' => $ci->router->fetch_method(),
			'start_time' => $date->format("Y-m-d H:i:s.u")
		);
		$ci->db->insert('api_response_logs', $TrackData);
		$insert_id=$ci->db->insert_id();
		return $insert_id;
	}
}

if( ! function_exists('endApi')){
	function endApi($trackId) { 
		$date = new DateTime();
		$ci=& get_instance();
		//echo '<pre>';print_r($ci->router->fetch_method());exit;
		$TrackData = array(
			'end_time' => $date->format("Y-m-d H:i:s.u")
		);
		$ci->db->update('api_response_logs', $TrackData,array('id'=>$trackId));
		$ResponseData=$ci->db->query('select * from api_response_logs where id="'.$trackId.'"')->row_array();
		$ci->db->query("DELETE FROM api_response_logs where id=$trackId");
		//echo $ci->db->last_query();exit;

		/*$inp = file_get_contents('./api_logs.txt');
		$tempArray = json_decode($inp);
		array_push($tempArray, $ResponseData);
		$jsonData = json_encode($tempArray);

		$fp = fopen('./api_logs.txt', 'w+');
        //fwrite($fp, json_encode($ResponseData));
        file_put_contents($fp, json_encode($jsonData));
		//$txt = file_get_contents('api_logs.txt');*/

		$txt=json_encode($ResponseData);
        //$myfile = file_put_contents('api_logs.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
		$myfile = fopen("api_logs.txt", "a") or die("Unable to open file!");
		//$txt = json_encode($ResponseData);
		fwrite($myfile, "\n". $txt);
		fclose($myfile);
		return true;
	}
}


if( ! function_exists('IsVenueExists_By_Email_Phone')){
    function IsVenueExists_By_Email_Phone($Email = NULL, $Phone = NULL){
		
		if($Email){
			$ci=& get_instance();
			$ci->db->where(" (Email = '$Email' OR Phone = '$Phone' ) ");
			$Result = $ci->db->get('venue_admins');
			if($Result->num_rows() > 0)
				return true;
		}
		return false;
	}
}

if( ! function_exists('IsVendorExists_By_Email_Phone')){
    function IsVendorExists_By_Email_Phone($Email = NULL, $Phone = NULL){
		
		if($Email){
			$ci=& get_instance();
			$ci->db->where(" (Email = '$Email' OR Phone = '$Phone' ) ");
			$Result = $ci->db->get('vendor_admins');
			if($Result->num_rows() > 0)
				return true;
		}
		return false;
	}
}


if( ! function_exists('VenueTypeName_By_ID')){
    function VenueTypeName_By_ID($VenueTypeID = NULL){
		
		if($VenueTypeID){
			$ci=& get_instance();
			$Result = $ci->db->get_where('venue_types', array('VenueTypeID' => $VenueTypeID));
			if($Result->num_rows() > 0)
				return $Result->row()->Name;
		}
		return false;
	}
}

