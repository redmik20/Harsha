<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$vendor_logged_in = $this->session->userdata('vendor_logged_in');
		if(isset($vendor_logged_in) || $vendor_logged_in == true)
		{
			redirect('vendor/dashboard', 'refresh');
		}
	}

	public function index()
	{
		$data['title'] = "Smart Venue";
		$this->load->model('vendormodel');
		//$this->load->view('vendor/includes/headerlogin', $data);
		$this->load->view('vendor/login', $data);
		//$this->load->view('vendor/includes/footerlogin', $data);
	}

	public function register()
	{
		$data['title'] = "Smart Venue";
		$this->load->model('vendormodel');
		//$this->load->view('vendor/includes/headerlogin', $data);
		$this->load->view('vendor/register', $data);
		//$this->load->view('vendor/includes/footerlogin', $data);
	}

	public function forgot_password()
	{
		$data['title'] = "Smart Venue";
		$this->load->model('vendormodel');
		//$this->load->view('vendor/includes/headerlogin', $data);
		$this->load->view('vendor/forgot_password', $data);
		//$this->load->view('vendor/includes/footerlogin', $data);
	}

	public function check_email_id_exists()
	{
		$this->load->model('vendormodel');
		$vendor_id = $this->input->post('vendor_id');
		$email_id = $this->input->post('email_id');
		$details = $this->vendormodel->check_email_id_exists($vendor_id, $email_id);
		//echo $this->db->last_query();exit;
		if($details == 0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}
	}

	public function check_mobile_exists()
	{
		$this->load->model('vendormodel');
		$vendor_id = $this->input->post('id');
		$mobile = $this->input->post('mobile');
		$details = $this->vendormodel->check_mobile_exists($vendor_id, $mobile);
		//echo $this->db->last_query();exit;
		if($details == 0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}
	}

	public function check_email_id_registered()
	{
		$this->load->model('vendormodel');
		$vendor_id = $this->input->post('id');
		$email_id = $this->input->post('email_id');
		$details = $this->vendormodel->check_email_id_exists($vendor_id, $email_id);
		//echo $this->db->last_query();exit;
		if($details > 0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}
	}

	public function check_mobile_valid()
	{
		$this->load->model('vendormodel');
		$vendor_id = $this->input->post('id');
		$mobile = $this->input->post('mobile');
		$details = $this->vendormodel->check_mobile_exists($vendor_id, $mobile);
		//echo $this->db->last_query();exit;
		if($details == 0)
		{
			echo "false";
		}
		else
		{
			echo "true";
		}
	}

	public function send_otp()
	{
		$this->session->unset_userdata('otp');
		$data['title'] = "Smart Venue";
		$mobile = $this->input->post('mobile');
		$otp = mt_rand(100000, 999999);
		//$message = "Dear User, $otp is your One time password (OTP) for Smart Venue. Thak You.";		
		$message = "Dear Venue Owner, $otp is One Time Password(OTP). Thank you for registration with Smart Venue.this OTP will be valid only for 45 min.";
 		SendSMS($mobile, $message);
		$this->session->set_userdata('otp', $otp);
		echo $this->session->userdata('otp');
	}

	public function send_otp_to_email()
	{
		$this->load->model('vendormodel');
		$this->session->unset_userdata('otp');
		$data['title'] = "Smart Venue";
		$email_id = $this->input->post('email_id');
		//$user_details = $this->vendormodel->get_userid_emailid($email_id);
		$otp = mt_rand(100000, 999999);
		$this->session->set_userdata('otp', $otp);
		$to = $email_id;
		$from = "info@fcarnival.com";
		$sitename="Smart Venue";
		$subject = 'Smart Venue';
		$message='<table width="100%" cellspacing="0" cellpadding="5" border="0" style="border:1px solid #d9d9d9">
		<tr>
			<td style="font-family:Arial, Helvetica, sans-serif;color:#fff;font-size:12px; padding:5px;background:#393939">Smart Venue</td>
		</tr>

		<tr>
			<td colspan="2" align="center">
				<img src="http://maharajacab.in/fcarnival/assets/images/logo.png" height="100" width="185" alt="">

			</td>
		</tr>
		<tr>
			<td style="border-top:1px solid #d9d9d9;border-bottom:1px solid #d9d9d9">
				<table width="100%" cellspacing="0" cellpadding="5" border="0">
					<tr>							 
						<td colspan="2" style="font-family:Arial, Helvetica, sans-serif;color:#000;font-size:12px">
							Please Click on the below Url to Reset your Password.
						</td>                
					</tr>
					<tr>							 
						<td colspan="2" style="font-family:Arial, Helvetica, sans-serif;color:#000;font-size:12px">
							Dear Designer, '.$this->session->userdata('otp').' is your OTP.
						</td>                
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="font-family:Arial, Helvetica, sans-serif;color:#000;font-size:12px;background:#eeeeee; padding-right:10px; line-height:30px;">Regards,<br />'.$sitename.' Team</td>
		</tr>
		</table>';

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: ".$to." <".$to.">\n";  
		$headers .= "From: ".$from." <".$from.">\n";  
		$headers .= "Reply-To: ".$from." <".$from.">\n";  
		$headers .= "Return-Path: ".$from." <".$from.">\n";  

		if(mail($to, $subject, $message, $headers))
		{	
			// $this->session->set_flashdata('fsuccess', 'Please Check your Email Id for OTP!');
			// redirect('home/login', 'refresh');
		}
		else
		{
			// $this->session->set_flashdata('ffailure', 'Email Sending Failed!');
			// redirect('home/login', 'refresh');
		}		
		echo $this->session->userdata('otp');
	}

	public function submit_register()
	{
		$this->load->model('vendormodel');
		$data = array(
			'name' => $this->input->post('name'),
			'email_id' => $this->input->post('email_id'),
			'mobile' => $this->input->post('mobile'),
			'password' => md5($this->input->post('password')),
			'status' => 'Inactive',
			'created_on' => date('Y-m-d H:i:s')
		);
		//var_dump($data);exit;		
		$vendor_id = $this->vendormodel->submit_register($data);
		echo $vendor_id;
	}

	public function reset_password()
	{
		$data['title'] = "Smart Venue";
		$password = $this->input->post('password');

		$this->db->where(array('email_id' => $this->input->post('email_id')));
		$this->db->set('password', md5($password));
		$this->db->update('vendors');
		//echo $this->db->last_query();exit;
		echo "success";
	}
	
	public function checklogin()
	{
		$this->form_validation->set_rules('mobile', 'Email Id', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|callback_verifyuser');
		if($this->form_validation->run() == false){
			$data['title'] = "Smart Venue";
			//$this->load->view('vendor/includes/headerlogin', $data);
			$this->load->view('vendor/login', $data);
			//$this->load->view('vendor/includes/footerlogin', $data);
		}else{
			redirect('vendor/dashboard');
		}
	}
	
	public function verifyuser()
	{
		$mobile = $this->security->xss_clean($this->input->post('mobile'));
		$password = $this->security->xss_clean($this->input->post('password'));
		
		$this->load->model('vendormodel');
		$vendor_block_status = $this->vendormodel->vendor_block_status($mobile);
		if($vendor_block_status > 0)
		{
			$this->form_validation->set_message('verifyuser', 'Your account is currently on hold. Please contact administrator!');
			return false;exit;
		}
		$row = $this->vendormodel->login($mobile, $password);
		//var_dump($row);exit;
		if(!empty($row)){
			$this->session->set_userdata(array(
							'vendor_id'  => $row->id,
							'name'	=> $row->name,
                            'mobile'	=> $mobile,
                            'email_id'	=> $row->email_id,
                            'vendor_logged_in' => TRUE
                    ));
			return true;
		}else{
			$this->form_validation->set_message('verifyuser', 'Mobile Number or Password is Incorrect. Please try again');
			return false;
		}
	}

	public function update_password()
	{
		$this->load->model('vendormodel');
		$data = array(
			'password' => md5($this->input->post('password')),
			'modified_on' => date('Y-m-d H:i:s')
		);
		//var_dump($data);exit;
		//echo $this->session->userdata('vendor_id');exit;
		$this->db->where('mobile', $this->input->post('mobile'));
		$this->db->update('vendors', $data);
		echo $this->session->userdata('vendor_id');
	}
}
?>