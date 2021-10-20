<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
	}	

	function cancel_booking()
	{
		$this->load->model('homemodel');
		$this->homemodel->get_order_to_be_cancelled();
		echo "success";			
	}
}
?>