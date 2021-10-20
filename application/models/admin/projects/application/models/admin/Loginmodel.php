<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Loginmodel extends CI_Model
{
	public function login($username, $password)
	{
		//echo $password;exit;
		$this->db->select('username, password, id');
		$this->db->from('admin');
		$this->db->where('username', $username);
		$this->db->where('password', md5($password));		
		$query = $this->db->get();	
		//echo $this->db->last_query();exit;
		if ($query !== FALSE)
		{	
			if($query->num_rows() > 0){
				return $query->row();
			}else{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	public function users_count()
	{
		$this->db->where('delete_status', 1);
		$query = $this->db->get('users');
		if ($query !== FALSE)
		{				
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}

	public function usersLoginCount()
	{
		$this->db->where('delete_status', 1);
		$this->db->where('login_status', 'true');
		$query = $this->db->get('users');
		if ($query !== FALSE)
		{				
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}

	public function unregister_users_count()
	{
		
		$this->db->select('id');
		$query = $this->db->get('unregister_users');
		if ($query !== FALSE)
		{				
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}

	public function exams_count()
	{
		$this->db->where('delete_status', 1);
		$query = $this->db->get('exams');
		if ($query !== FALSE)
		{				
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}
	
	public function subjects_count()
	{
		return $this->db->select('subjects.id')->from('subjects')->join('exams', 'exams.id = subjects.exam_id')->where('subjects.delete_status', 1)->where('exams.delete_status', 1)->order_by('subjects.id','desc')->get()->num_rows();
	}	

	public function chapters_count()
	{
		// $this->db->where('delete_status', 1);
		// $query = $this->db->get('chapters');
		// //echo $this->db->last_query();exit;
		// if ($query !== FALSE)
		// {				
		// 	return $query->num_rows();
		// }
		// else
		// {
		// 	return 0;
		// }
		return $this->db->select('chapters.*')->where('chapters.delete_status',1)->join('subjects', 'subjects.id = chapters.subject_id','left')->join('video_topics', 'video_topics.chapter_id = chapters.id','left')->join('chapters_slides', 'chapters_slides.chapter_id = chapters.id','left')->join('exams', 'exams.id = chapters.exam_id','left')->from('chapters')->order_by('chapters.id','desc')->get()->num_rows();
	}	

	public function chapters_slides_count()
	{
		$this->db->where('delete_status', 1);
		$query = $this->db->get('chapters_slides');
		if ($query !== FALSE)
		{				
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}	
	
	public function chapter_topics()
	{
		$this->db->where('delete_status', 1);
		$query = $this->db->get('video_topics');
		if ($query !== FALSE)
		{				
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}	

	public function plandetails_count()
	{
		$this->db->where('delete_status', 1);
		$query = $this->db->get('plan_details');
		if ($query !== FALSE)
		{				
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}	


	public function faculty_count()
	{
		$this->db->where('delete_status', 1);
		$query = $this->db->get('faculty_details');
		if ($query !== FALSE)
		{				
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}	

	public function coupons_count()
	{
		$this->db->where('delete_status', 1);
		$query = $this->db->get('coupons');
		if ($query !== FALSE)
		{				
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}	


		public function payments_count()
	{
		//$this->db->where('delete_status', 1);
		$query = $this->db->get('payment_info');
		if ($query !== FALSE)
		{				
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}

	public function total_payment_amount(){
		$query="select sum(final_paid_amount) as total_amt from payment_info where payment_status='success'";
		//echo $query;exit;
		$result=$this->db->query($query)->row_array();
		return $result;
	}
	
	public function feedback_count()
	{
		
		$query = $this->db->get('quiz_topic_reviews');
		//echo $this->db->last_query();exit;
		if ($query !== FALSE)
		{				
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}
	
	public function reports_count()
	{
		
		$query = $this->db->get('quiz_reports');
		//echo $this->db->last_query();exit;
		if ($query !== FALSE)
		{				
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}	

	
}
?>