<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public $data=array();

	function __construct()
	{
		parent::__construct();	
		
		
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('index');
		$this->load->view('footer');
	}

	public function about()
	{
		$this->load->view('header');
		$this->load->view('about');
		$this->load->view('footer');
	}
    
    public function contact()
	{
		$this->load->view('header');
		$this->load->view('contact');
		$this->load->view('footer');
	}

	public function courses()
	{
		$this->load->view('header');
		$this->load->view('courses');
		$this->load->view('footer');
	}

	public function privacy_policy()
	{
		$this->load->view('header');
		$this->load->view('privacy_policy');
		$this->load->view('footer');
	}

	public function cancellation_policy()
	{
		$this->load->view('header');
		$this->load->view('cancellation_policy');
		$this->load->view('footer');
	}

	public function course_details()
	{
		$this->load->view('header');
		$this->load->view('course_details');
		$this->load->view('footer');
	}

 public function overview()
	{
	
		$this->load->view('overview');
		
	}

	public function term_and_conditions()
	{
		$this->load->view('header');
		$this->load->view('terms_and_conditions');
		$this->load->view('footer');
		
	}

	public function login()
	{
		$this->load->view('header');
		$this->load->view('login');
		$this->load->view('footer');
		
	}





}