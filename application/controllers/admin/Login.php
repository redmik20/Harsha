<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login extends CI_Controller {

	public $login_redirect= '/admin';
	public $dashboard_redirect= '/admin/dashboard';
	public $change_password_redirect='admin/change_password';
	public $employee_dashboard_redirect='admin/agent_dashboard';
 	
	public function __construct()
	{
	parent::__construct();
	
	$this->load->helper('url','form','HTML');
	$this->load->library(array('form_validation', 'session'));
	$this->recordsperpage = 10;
	$this->load->model('admin/Login_model','my_model');
	
	}

   public function index()
   {

   	  if($this->input->post('submit')!='')
		{
				$checkEmail = $this->my_model->checkUserEmailAndUserID($this->input->post('user_email'));
				if($checkEmail == 0)
				{
					$this->session->set_flashdata( 'message', 'Invalid User Email OR User ID...' );
					redirect($this->login_redirect);
					
				}

				//Username And Password Check here
				$user_details = $this->my_model->checkUserEmailPassword($this->input->post('user_email'),$this->input->post('password'));
				if(!empty($user_details)){
				$user_details = $this->my_model->update_admin_logintime($this->session->userdata('login_date_time'),$user_details['id']);
				$this->session->set_flashdata( 'message', 'User Successfully Login...' );
						if($this->session->userdata('user_id') == 'ADM0001'){
						    redirect($this->dashboard_redirect);
							}else{
							redirect($this->employee_dashboard_redirect);	
							}
				}else{
					$this->session->set_flashdata( 'message', 'Invaild password...' );
					redirect($this->login_redirect);
				}
				//echo '<pre>';print_r($this->session->all_userdata());exit;
					
				
			
		}
		
       $this->load->view('admin/login');
   }

   public function logout(){
		$this->my_model->logout_time();
	    $user_data = $this->session->all_userdata();
			foreach ($user_data as $key => $value) {
				
					$this->session->unset_userdata($key);
			
			}
			
			$this->session->sess_destroy();
			$this->session->set_flashdata( 'message', 'Successfully Logout..' );
			//$this->data['logout_message']="Successfully Logout..";
            redirect(base_url('admin'));
    }

}
 
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */
