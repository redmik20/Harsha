<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Main_batchs extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $list_Page = 'admin/master/list_main_batchs';
	public $add_Page =  'admin/master/add_main_batchs';
	public $view_Page = 'admin/master/batch_details';
	public $edit_Page = 'admin/master/edit_main_batchs';


	public function __construct()
	{
	 parent::__construct();
	 $this->load->model('admin/Batchs_model','my_model');
	 $this->load->model('Common_model','common_model');
	 checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	}

	public function index(){

		 $this->setHeaderFooter($this->list_Page,$this->data);
	}


}
?>