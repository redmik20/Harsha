<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Dashboard extends CI_Controller {

	public $dashboard_Page = 'admin/dashboard';
	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu='admin/includes/left_menu';

	public function __construct()
	{
	parent::__construct();
	
	$this->load->model('admin/Dashboard_model','my_model');
	checkAdminLogin();
	$this->load->model('Common_model','common_model');
	if($this->session->userdata('user_id') != 'ADM0001'){
		 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
	     }else{
		 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
		 }
		 //echo '<pre>';print_r($this->data['roleResponsible']);exit;
		 //echo '<pre>';print_r($this->session->userdata('user_id'));exit;
	}

	

	public function index(){
		 if($this->session->userdata('user_type') == 'employee'){ 

		 	redirect('admin/agent_dashboard', 'refresh');

		 }
		
		 $this->data['students_count']=$this->my_model->get_students_count();
		 //echo '<pre>';print_r($this->data['students_count']);exit;
		 $this->data['batchs_count']=$this->my_model->get_batchs_count();


         $this->setHeaderFooter($this->dashboard_Page,$this->data);
	}


	/*-----------start setting header and footer --------------*/

	public function setHeaderFooter($view, $data)
	{	

		$this->load->view($this->header_page, $data);
		$this->load->view($this->leftMenu, $data);
		$data['message']=$this->load->view('admin/includes/message',$data,TRUE);
		$this->load->view($view, $data);
		$this->load->view($this->footer_Page);
	}
  /*----------- stop setting header and footer --------------*/

	
}

?>