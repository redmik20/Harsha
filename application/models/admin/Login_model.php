<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login_model extends CI_Model {


	public $users = 'tbl_users';

	public function __construct()

	{

		parent::__construct();

	

	}

	public function checkUserEmailAndUserID($user_email){
		$where="(user_email = '".$user_email."' AND status='Active') OR (user_id = '".$user_email."' AND status='Active')";
		$this->db->select('id,user_type');
		$this->db->from($this->users);
		$this->db->where($where);
		$result=$this->db->get();
		$result=$result->num_rows();
		//echo $this->db->last_query();exit;
		return $result;
	}


	public function checkUserEmailPassword($user_email,$password){
		$encode_password=md5($password);

		$where="(user_email = '".$user_email."' AND status='Active' AND password='".$encode_password."') OR (user_id = '".$user_email."' AND status='Active' AND password='".$encode_password."')";
		$this->db->select('id,user_id,user_type,user_name,user_email,password,status,login_time');
		$this->db->from($this->users);
		$this->db->where($where);
		$query=$this->db->get(); 
		$num_rows=$query->num_rows();
		$result = $query->row_array();
		if($result){
				//set session values here
				$this->session->set_userdata('user_id', $result['user_id']);
				$this->session->set_userdata('user_name', $result['user_name']);
				$this->session->set_userdata('user_type', $result['user_type']);
				
				$this->session->set_userdata('ip_address', $_SERVER['REMOTE_ADDR']);
				$this->session->set_userdata('logged_in', "DBMCI");
				$this->session->set_userdata('last_logged_in', $result['login_time']);
				$this->session->set_userdata('login_date_time',date('Y-m-d H:i:s'));								 
				$this->session->set_userdata('login_state', TRUE);
				//$user_data = $this->session->all_userdata();
				
			}
		return $result;
		
	}

	public function update_admin_logintime($login_time,$user_id){
		
		$login_st_data = array(
			'login_time'      => $login_time,  
		);
		//echo '<pre>';print_r($login_st_data);exit;
		$this->db->where('id',$user_id);
		$admin_result=$this->db->update($this->users, $login_st_data);
		return $admin_result;
	}

	public function logout_time()
	{
		$login_st_data = array(
			'logout_time'      => date('Y-m-d H:i:s'),  
		);
		
		$this->db->where('user_id',$this->session->userdata('user_id'));
		$admin_result=$this->db->update($this->users, $login_st_data);
		//echo $this->db->last_query();exit;
		return $admin_result;
	}
}

?>