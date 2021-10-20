<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ws_model extends CI_Model
{	

	public function __construct()
    {
     parent::__construct();
    
     $this->db2 = $this->load->database('plato', TRUE);
     $this->db = $this->load->database('default', TRUE);
    }


	public function check_login($student_id,$password){

		$this->db->select('`admission_no`, `student_dynamic_id`, `valid_from`, `valid_to`, `student_name`, `student_mobile`, `student_email`, `qrcode_path`,`image`,`status`,`center_id`,`batch_id`,`device_id`');
		$this->db->from('students');
		$this->db->where('student_mobile',$student_id);
		$this->db->where('password',md5($password));
		$this->db->where('status','Active');
		$result=$this->db->get()->row_array();
		return $result;
	}

	public function get_userID($student_id){
		$this->db2->select('id');
		$this->db2->from('users');
		$this->db2->where('student_id',$student_id);
		$result=$this->db2->get()->row_array();
		return $result;
	}

	public function student_card_details($student_id){

		/*$this->db->select('students.`id`, students.`admission_no`, students.`student_dynamic_id`, students.`valid_from`, students.`valid_to`, students.`student_name`, students.`student_mobile`, students.`student_email`, students.`qrcode_path`, students.`status`, students.`image`, batchs.`batch_name`');
		$this->db->join('batchs','tbl_batchs.id=tbl_students.batch_id');
		$this->db->from('students');
		$this->db->where('tbl_students.id',$student_id);
		$this->db->where('tbl_students.status','Active');
		$query=$this->db->get();
		//echo $this->db->last_query();exit;
		$result=$query->row_array();*/
		//echo $student_id;
		$query = $this->db->query("CALL student_card_details('$student_id')");
		//echo $this->db->last_query();exit;
        return $query->row_array();
		//return $result;
	}

	public function student_check_password($student_id,$old_password){

		$old_password1=md5($old_password);
		$query="select student_dynamic_id from tbl_students where student_dynamic_id='".$student_id."' and password='".$old_password1."' ";
		//echo $query;exit;
		$result=$this->db->query($query)->row_array();
		return $result;
	}

	public function student_change_password($student_id,$new_password){

		$update_array=array(
							'password'=>md5($new_password),
							'modified_on'=> date('Y-m-d H:i:s')
						   );

		$this->db->update('students',$update_array,array('student_dynamic_id'=>$student_id));
		$result=$this->db2->update('users',$update_array,array('student_id'=>$student_id));
		return $result;
	}

	public function student_profile_details($student_id){
		$query = $this->db->query("CALL student_profile_details('$student_id')");
        return $query->row_array();
	}

	public function updateUserDeviceId($student_id,$device_id){

        $update_data=array(
                            'device_id'=> $device_id,
                          );
        $this->db->update('students',$update_data,array('student_dynamic_id'=>$student_id));
        //echo $this->db->last_query();exit;
        
        $result=$this->db2->update('users',$update_data,array('student_id'=>$student_id));
        //echo $this->db2->last_query();exit;
        return $result;
    }

    public function checkStudentAttendance($student_id){
    	$scaned_date=date('Y-m-d');
		$this->db->select('*');
		$this->db->from('event_attendence');
		$this->db->where('student_dy_id',$student_id);
		//$this->db->where('scaned_date',$scaned_date);
		$query=$this->db->get();
		//echo $this->db->last_query();exit;
		//$result=$query->row_array();
		
		
		//echo $this->db->last_query();exit;
		$result=$query->result_array();
		//echo '<pre>';print_r($result);exit;
		/*if(!empty($result)){
			$t_res= true;
		}else{
			$t_res= false;
		}*/
		return $result;
    }

    public function get_states(){

    	$this->db->select('*');
		$this->db->from('states');
		$this->db->where('status','Active');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;

    }

    public function get_organisations($state_id){

    	$this->db->select('*');
		$this->db->from('organisations');
		$this->db->where('state_id',$state_id);
		$this->db->where('status','Active');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}

	public function get_centers($state_id,$organisation_id){

		$this->db->select('*');
		$this->db->from('centers');
		$this->db->where('state_id',$state_id);
		$this->db->where('organisation_id',$organisation_id);
		$this->db->where('status','Active');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}

	public function get_courses($state_id,$organisation_id,$center_id){

		$this->db->select('*');
		$this->db->from('courses');
		$this->db->where('state_id',$state_id);
		$this->db->where('organisation_id',$organisation_id);
		$this->db->where('center_id',$center_id);
		$this->db->where('status','Active');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}

	public function get_batchs($state_id,$organisation_id,$center_id,$course_id){

		$this->db->select('*');
		$this->db->from('batchs');
		$this->db->where('state_id',$state_id);
		$this->db->where('organisation_id',$organisation_id);
		$this->db->where('center_id',$center_id);
		$this->db->where('course_id',$course_id);
		$this->db->where('status','Active');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}

	public function get_colleges($state_id){

		$this->db->select('*');
		$this->db->from('colleges');
		$this->db->where('state_id',$state_id);
		$this->db->where('status','Active');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}

	public function insert_otp($mobile_no,$otp){

		$this->db->delete('mobile_otp_verification',array('student_mobile'=>$mobile_no));

		$insert_data=array('student_mobile'=>$mobile_no,'otp'=>$otp,'created_on'=>date('Y-m-d H:i:s'));
		$result=$this->db->insert('mobile_otp_verification',$insert_data);
		return $result;
	}

	public function OTP_verification($mobile_no,$otp){
		$this->db->select('*');
		$this->db->from('mobile_otp_verification');
		$this->db->where('student_mobile',$mobile_no);
		$this->db->where('otp',$otp);
		$query=$this->db->get();
		$result=$query->row_array();
		return $result;
	}

	public function get_payment_modes($state_id,$organisation_id,$center_id,$type){

		$this->db->select('*');
		$this->db->from('payment_modes');
		$this->db->where('state_id',$state_id);
		$this->db->where('organisation_id',$organisation_id);
		$this->db->where('center_id',$center_id);
		$this->db->where('amount_type',$type);
		$this->db->where('status','Active');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;

	}
   

}
?>