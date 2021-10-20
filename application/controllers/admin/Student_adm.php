<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Student_adm extends CI_Controller {

	
	public $student_paymentlink_step2_Page= 'admin/student/student_payment_step2';
	public $student_paymentlink_step2_tc_Page='admin/student/student_payment_step2_tc';
	public $student_paymentlink_step3_Page='admin/student/student_payment_step3_payment';
	public $student_paymentlink_step2_error_Page='admin/student/student_paymentlink_step2_error';

	public function __construct()
	{
	parent::__construct();
	
	$this->load->model('admin/Student_model','my_model');
	$this->load->model('Common_model','common_model');
	$this->data=array();
	$this->load->library('session');
	}

	public function admission_link_step2_continue($id){

		$post=$this->input->post();
		if($this->input->post('submit') != ''){
		$session_data=array(
                            
                            'student_name'=> $post['student_name'],
                            'mobile_no'=> $post['mobile_no'],
                            'gender'=> $post['gender'],
                            'alt_mobile_no'=> $post['alt_mobile_no'],
                            'email_id'=> $post['email_id'],
                            'adderss_state_id'=> $post['state_id'],
                            'permanent_address'=> $post['permanent_address'],
                            'mbbs_state_id'=> $post['mbbs_state_id'],
                            'mbbs_college_id'=> $post['college_mbbs_id'],
                            'mbbs_batch'=> $post['mbbs_batch'],
                            'internship_college'=> $post['internship_college'],
                            'valid_from'=> $post['valid_from'],
                            'valid_to'=> $post['valid_to'],
                            
                          );
		$this->session->set_userdata($session_data);
		}
		

		$this->data['id']=$id;
		$this->data['record']=$this->common_model->get_table_row('students_before_admissions',array('id'=>$id),array());
		$student_mobile=$this->data['record']['mobile_no'];
		$check_student_link=$this->common_model->get_table_row('students',array('id'=>$student_mobile),array('admission_link'));
		
		if(!empty($check_student)){
			$this->session->set_flashdata('error', 'Student Already Used this link !..');
		    redirect('admin/student_adm/admission_link_step2_error_page');
		}

		$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array());

		$this->data['colleges']=$this->common_model->get_table('colleges',array('status'=>'Active'),array());

		
		//echo '<pre>';print_r($this->data['record']);exit;
		$this->data['batch_data']=$this->common_model->get_table_row('batchs',array('id'=>$this->data['record']['batch_id']),array('batch_name','start_date','end_date'));
		$this->data['center']=$this->common_model->get_table_row('centers',array('id'=>$this->data['record']['center_id']),array('center'));
		if($this->input->post('submit') != ''){

			//echo '<pre>';print_r($this->data['record']);exit;
			$this->data['up_record']=$this->common_model->get_table_row('students_before_admissions',array('id'=>$id),array('verify_otp'));
			$db_otp=$this->data['up_record']['verify_otp'];
			$post_otp=$this->input->post('otp');
			if($db_otp != $post_otp ){

				$this->session->set_flashdata('error', 'OTP Verification Failed!.');
				redirect(base_url('admin/student_adm/admission_link_step2_continue/'.$id));
			}

			$image=$_FILES['image'];
		    $imgurl='';

		    if($image['name']!=''){
					$config['upload_path']          = './storage/studentpics';
					$config['allowed_types']        = 'jpg|png|gif|jpeg';
					$config['max_size']             = 2000;

			   		$this->load->library('upload', $config);
		
		
				   if($this->upload->do_upload('image')){
						$imgdata = $this->upload->data();
						$imgurl = 'storage/studentpics/'.$imgdata['file_name'];
					}else{
						$imgurl = '';
						//$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
						}
		
	    	}

			$this->my_model->update_student_step2_data($this->input->post(),$id,$imgurl);
			redirect(base_url('admin/student_adm/admission_payment_link_step3/'.$id));

		}
		$this->load->view($this->student_paymentlink_step2_Page,$this->data);
	}

	public function admission_link_step2_tc(){
		
		$this->load->view($this->student_paymentlink_step2_tc_Page,$this->data);
	}

	public function admission_payment_link_step3($id){
		$this->data['id']=$id;
		$this->data['record']=$this->common_model->get_table_row('students_before_admissions',array('id'=>$id),array());
		$this->data['batch']=$this->common_model->get_table_row('batchs',array('id'=>$this->data['record']['batch_id']),array());
		$this->data['course']=$this->common_model->get_table_row('courses',array('id'=>$this->data['record']['course_id']),array());
		$this->load->view($this->student_paymentlink_step3_Page,$this->data);
	}

	public function getmmbscolleges()
   	{
       $state_id = $this->input->post('state_id');
       $colleges  = $this->common_model->get_table('colleges',array('state_id' => $state_id,'status'=>'Active'),array(),'college_name','asc');
      //print_r($subjects);exit;
       echo '<option value="">Select Colleges</option>';
       if(!empty($colleges))
       {
          foreach($colleges as $college)
			      {
			      echo '<option value="'.$college['id'].'">'.$college['college_name'].'</option>';
			      }
        }
	}

	public function sendOTPThroughLink(){
		$mobile = $this->input->post('mobile');
		$id = $this->input->post('id');
		$otp = mt_rand(100000, 999999);

        $message='Dear Student, '.$otp.' is One time password (OTP) for DR Bhatia. Thank You -Bhatia';
	    SendSMS($mobile,$message);
	    $result=$this->my_model->update_otp($otp,$id);
		echo $result;
	}

	public function admission_link_step2_error_page(){

		$this->load->view($this->student_paymentlink_step2_error_Page,$this->data);
	}

	public function checkadmform($id){

		//$this->common_model->save_pdf($receipt_id,'no');

		$this->common_model->createAndSaveAdmissionLink($id,'RECPT7740');

	}


}


?>