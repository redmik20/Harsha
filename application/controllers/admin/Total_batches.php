<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Total_batches extends CI_Controller {

	
	public $batches_list_Page='admin/total_batches/total_batches_list';

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu='admin/includes/left_menu';



	public function __construct()
	{
	parent::__construct();
	
	$this->load->model('admin/Total_batches_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	}

	public function total_batches_list(){

		$this->data['batch_wise_students']=$this->my_model->batch_wise_students_count();
		$this->setHeaderFooter($this->batches_list_Page,$this->data);

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