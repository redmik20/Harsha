<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Change_password extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $change_password_page = 'admin/change_password';
	
	public $pwd_redirect='/admin/change_password';

	public function __construct()
	{
	parent::__construct();
	$this->load->model('admin/Change_password_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	}

	public function index(){

		$this->data=array();
		if($this->input->post('submit')!='')
		{
		
			if($this->my_model->password_check() != 0)
			{ 
				if($this->input->post('conf_pwd') == $this->input->post('new_pwd')){
					$changepass=$this->my_model->change_password_2();
					
					if($changepass)
					{
						$this->session->set_flashdata('success', 'Password has been Changed Sucessfully...');
						redirect($this->pwd_redirect);
					}
					
				}else{
					$this->session->set_flashdata('error', 'You have entered new and cofirm password does not match');
				    redirect($this->pwd_redirect);
				}
			}
			else
			{		
				$this->session->set_flashdata('error', 'You have entered wrong Password,old records does not match..!');
				redirect($this->pwd_redirect);
			}
		
		}
		if($this->session->userdata('user_id') != 'ADM0001'){
		 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
	     }else{
		 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
		 }
		 $this->setHeaderFooter($this->change_password_page,$this->data);
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