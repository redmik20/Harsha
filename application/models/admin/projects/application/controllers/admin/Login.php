<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller
{
	public function index()
	{
		$data['title'] = "Master of Wedding";
		$this->load->model('admin/loginmodel');
		$this->load->view('admin/includes/headerlogin', $data);
		$this->load->view('admin/loginview', $data);
		$this->load->view('admin/includes/footerlogin', $data);
	}
	
	public function checklogin()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|callback_verifyuser');
		
		if($this->form_validation->run() == false){
			$data['title'] = "Smart Venue";
			$this->load->view('admin/includes/headerlogin', $data);
			$this->load->view('admin/loginview', $data);
			$this->load->view('admin/includes/footerlogin', $data);
		}else{
			redirect('admin/home/index');
		}
	}
	
	public function verifyuser()
	{
		$username = $this->security->xss_clean($this->input->post('username'));
		$password = $this->security->xss_clean($this->input->post('password'));
		
		$this->load->model('admin/loginmodel');
		$row = $this->loginmodel->login($username, $password);
		//var_dump($row);exit;
		if(!empty($row)){
			$this->session->set_userdata(array(
							'admin_id'       => $row->id,
							// 'name'       => $row->name,
							// 'type'       => $row->type,
                            'username'       => $username,
                            'is_logged_in' => TRUE
                    ));
			return true;
		}else{
			$this->form_validation->set_message('verifyuser', 'Username or Password is Incorrect. Please try again');
			return false;
		}
	}
}
?>