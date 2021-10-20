<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Common extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';


	
	public function __construct()
	{
	parent::__construct();
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	}

	
	public function get_organisations()
   	{
       $state_id = $this->input->post('state_id');
       $organisations  = $this->common_model->get_table('organisations', array('state_id' => $state_id,'status'=>'Active'));
      //print_r($subjects);exit;
       echo '<option value="">Select Organisation</option>';
       if(!empty($organisations))
       {
          foreach($organisations as $org)
			      {
			      echo '<option value="'.$org['id'].'">'.$org['organisation_name'].'</option>';
			      }
        }else{
        	echo '<option value="">No Organisations</option>';
        }
	}

	public function get_centers(){
		$state_id = $this->input->post('state_id');
		$org_id = $this->input->post('org_id');

		$centers  = $this->common_model->get_table('centers', array('state_id' => $state_id,'organisation_id' => $org_id,'status'=>'Active'));
      //print_r($subjects);exit;
       echo '<option value="">Select Center</option>';
       if(!empty($centers))
       {
          foreach($centers as $center)
			      {
			      echo '<option value="'.$center['id'].'">'.$center['center'].'</option>';
			      }
        }else{
        	echo '<option value="">No Centers</option>';
        }
	}

	public function get_attachments(){
		$state_id = $this->input->post('state_id');
		$organisation_id = $this->input->post('organisation_id');
		$center_id = $this->input->post('center_id');

		$attachments  = $this->common_model->get_table('attachments', array('state_id' => $state_id,'organisation_id' => $organisation_id,'center_id'=>$center_id,'status'=>'Active'));
      //print_r($subjects);exit;
       echo '<option value="">Select Attachment</option>';
       if(!empty($attachments))
       {
          foreach($attachments as $attachment)
			      {
			      echo '<option value="'.$attachment['id'].'">'.$attachment['attachment_name'].'</option>';
			      }
        }else{
        	echo '<option value="">No Attachment</option>';
        }
	}

	public function get_courses(){
		$state_id = $this->input->post('state_id');
		$organisation_id = $this->input->post('organisation_id');
		$center_id = $this->input->post('center_id');

		$courses  = $this->common_model->get_table('courses', array('state_id' => $state_id,'organisation_id' => $organisation_id,'center_id'=>$center_id,'course_type'=>'admin','status'=>'Active'));
      //print_r($subjects);exit;
       echo '<option value="">Select Course</option>';
       if(!empty($courses))
       {
          foreach($courses as $course)
			      {
			      echo '<option value="'.$course['id'].'">'.$course['course_name'].'</option>';
			      }
        }else{
        	echo '<option value="">No Courses</option>';
        }
	}

	public function get_spl_attendence_centers(){
		$center_id = $this->input->post('center_id');
		

		$events  = $this->common_model->get_table('events', array('center_id' => $center_id,'status'=>'Active'));
      //print_r($subjects);exit;
       echo '<option value="">Select Event</option>';
       if(!empty($events))
       {
          foreach($events as $event)
			      {
			      echo '<option value="'.$event['id'].'">'.$event['event_name'].'</option>';
			      }
        }else{
        	echo '<option value="">No Events</option>';
        }
	}

	public function getPaymentModes(){
		$state_id = $this->input->post('state_id');
		$organisation_id = $this->input->post('organisation_id');
		$center_id = $this->input->post('center_id');

		$payment_modes  = $this->common_model->get_table('payment_modes', array('state_id' => $state_id,'organisation_id' => $organisation_id,'center_id' => $center_id,'status'=>'Active','amount_type' => 'income'));
      //print_r($subjects);exit;
       echo '<option value="">Select Payment Mode</option>';
       if(!empty($payment_modes))
       {
          foreach($payment_modes as $payment)
			      {
			      echo '<option value="'.$payment['id'].'">'.$payment['payment_mode'].'</option>';
			      }
        }else{
        	echo '<option value="">No Payment Mode</option>';
        }
	}

	public function getCategories(){
		$state_id = $this->input->post('state_id');
		$organisation_id = $this->input->post('organisation_id');
		$center_id = $this->input->post('center_id');

		$categories  = $this->common_model->get_table('categories', array('state_id' => $state_id,'organisation_id' => $organisation_id,'center_id' => $center_id,'status'=>'Active'));
      //print_r($subjects);exit;
       echo '<option value="">Select Category</option>';
       if(!empty($categories))
       {
          foreach($categories as $category)
			      {
			      echo '<option value="'.$category['id'].'">'.$category['category_name'].'</option>';
			      }
        }else{
        	echo '<option value="">No Categories</option>';
        }
	}

	public function getExpensePaymentModes(){
		$state_id = $this->input->post('state_id');
		$organisation_id = $this->input->post('organisation_id');
		$center_id = $this->input->post('center_id');

		$payment_modes  = $this->common_model->get_table('payment_modes', array('state_id' => $state_id,'organisation_id' => $organisation_id,'center_id' => $center_id,'status'=>'Active','amount_type' => 'expense'));
      //print_r($subjects);exit;
       echo '<option value="">Select Payment Mode</option>';
       if(!empty($payment_modes))
       {
          foreach($payment_modes as $payment)
			      {
			      echo '<option value="'.$payment['id'].'">'.$payment['payment_mode'].'</option>';
			      }
        }else{
        	echo '<option value="">No Payment Mode</option>';
        }
	}

	public function getroles(){
		$state_id = $this->input->post('state_id');
		$organisation_id = $this->input->post('organisation_id');
		$center_id = $this->input->post('center_id');

		$roles  = $this->common_model->get_table('roles', array('state_id' => $state_id,'organisation_id' => $organisation_id,'center_id' => $center_id,'status'=>1));
      //print_r($subjects);exit;
       echo '<option value="">Select Role</option>';
       if(!empty($roles))
       {
          foreach($roles as $role)
			      {
			      echo '<option value="'.$role['id'].'">'.$role['rolename'].'</option>';
			      }
        }else{
        	echo '<option value="">No Roles...</option>';
        }
	}

	public function getDepartments(){
		$state_id = $this->input->post('state_id');
		$organisation_id = $this->input->post('organisation_id');
		$center_id = $this->input->post('center_id');

		$departments  = $this->common_model->get_table('departments', array('state_id' => $state_id,'organisation_id' => $organisation_id,'center_id' => $center_id,'status'=>'Active'));
      //print_r($subjects);exit;
       echo '<option value="">Select department</option>';
       if(!empty($departments))
       {
          foreach($departments as $dept)
			      {
			      echo '<option value="'.$dept['id'].'">'.$dept['dept_name'].'</option>';
			      }
        }else{
        	echo '<option value="">No departments...</option>';
        }
	}
	

	
}


?>