<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Student_upload_model extends CI_Model {

    public function __construct()
    {
     parent::__construct();
    
     $this->db2 = $this->load->database('plato', TRUE);
     
    }

    public function insertStudent($data){

    	if($data[0] != ''){
    	$student_name= $data[0];
    	}else{
    	$student_name= '';	
    	}

    	if($data[1] != ''){
    	$student_mobile= $data[1];
    	}else{
    	$student_mobile= '';	
    	}

    	if($data[2] != ''){
    	$student_email= $data[2];
    	}else{
    	$student_email= '';	
    	}

    	if($data[3] != ''){
    	$gender= $data[3];
    	}else{
    	$gender= '';	
    	}    	

    	if($data[4] != ''){
    	$student_alternative_mobile= $data[4];
    	}else{
    	$student_alternative_mobile= '';	
    	}

    	if($data[5] != ''){
    	$father_name= $data[5];
    	}else{
    	$father_name= '';	
    	}

    	if($data[6] != ''){
    	$occupation= $data[6];
    	}else{
    	$occupation= '';	
    	}

    	if($data[7] != ''){
    	$res_contact_no= $data[7];
    	}else{
    	$res_contact_no= '';	
    	}
    	if($data[8] != ''){
    	$guardian_contact_no= $data[8];
    	}else{
    	$guardian_contact_no= '';	
    	}
    	if($data[9] != ''){
    	$permanent_address= $data[9];
    	}else{
    	$permanent_address= '';	
    	}
    	if($data[10] != ''){
    	$address_state_id= $data[10];
    	}else{
    	$address_state_id= '';	
    	}
    	if($data[11] != ''){
    	$pincode= $data[11];
    	}else{
    	$pincode= '';	
    	}

    	if($data[12] != ''){
    	$mbbs_college_id= $data[12];
    	}else{
    	$mbbs_college_id= '';	
    	}

    	if($data[13] != ''){
    	$mbbs_batch= $data[13];
    	}else{
    	$mbbs_batch= '';	
    	}

    	if($data[14] != ''){
    	$mbbs_state_id= $data[14];
    	}else{
    	$mbbs_state_id= '';	
    	}

    	if($data[15] != ''){
    	$internship_college= $data[15];
    	}else{
    	$internship_college= '';	
    	}

    	if($data[16] != ''){
    	$internship_join_date= date("Y-m-d", strtotime($data[16]));
    	}else{
    	$internship_join_date= '';	
    	}

    	if($data[17] != ''){
    	$presently_working= $data[17];
    	}else{
    	$presently_working= '';	
    	}


    	$batch=$this->common_model->get_table_row('batchs',array('id'=> $this->input->post('batch_id')),array('student_code,start_date,end_date'));
			if($batch['student_code'] != ''){
				$stuent_code=$batch['student_code'];
			}else{
				$stuent_code='STDN';
			}

		$user_exists=$this->common_model->get_table_row('students',array('student_mobile'=>$student_mobile),array());
		$password= 'bhatia123';
		$student_dynamic_id=getDynamicId('student_no',$stuent_code);
		$admission_no=getDynamicId('admission_no','ADMS');

		if(empty($user_exists)){
    	 $insert_ary=array(
    	 					'admission_no'=> $admission_no,
    	 					'student_dynamic_id'=> $student_dynamic_id,
    	 					'state_id'=> $this->input->post('state_id'),
                            'organisation_id'=> $this->input->post('organisation_id'),
                            'center_id' => $this->input->post('center_id'),
                            'course_id' => $this->input->post('course_id'),
                            'batch_id' => $this->input->post('batch_id'),
    	 					'student_name' => $student_name,
    	 					'student_mobile'=> $student_mobile,
    	 					'student_email' => $student_email,
    	 					'password'=>md5($password),
    	 					'gender' => $gender,
    	 					'student_alt_mobile' => $student_alternative_mobile,
    	 					'father_name' => $father_name,
    	 					'occupation' => $occupation,
    	 					'res_contact_no' => $res_contact_no,
    	 					'guardian_contact_no' => $guardian_contact_no,
    	 					'permanent_address' => $permanent_address,
    	 					'address_state_id' => $address_state_id,
    	 					'pincode' => $pincode,
    	 					'college_mbbs' => $mbbs_college_id,
    	 					'mbbs_batch' => $mbbs_batch,
    	 					'mbbs_state'=>$mbbs_state_id,
    	 					'internship_college'=> $internship_college,
    	 					'internship_join_date'=> $internship_join_date,
    	 					'presently_working'=> $presently_working,
    	 					'valid_from' => $batch['start_date'],
			                'valid_to' => $batch['end_date'],
    	 					'created_on'=> date('Y-m-d H:i:s'),
    	 					'created_by'=> $this->session->userdata('user_id'),
    	                  );

    	 $result=$this->db->insert('students',$insert_ary);
         $insert_id=$this->db->insert_id();
        
         $insert_db2=array(
                            'student_id'=>$student_dynamic_id,
                            'bhatia_row_id'=>$insert_id,
                            'state_id'=> $this->input->post('state_id'),
                            'organisation_id'=> $this->input->post('organisation_id'),
                            'center_id' => $this->input->post('center_id'),
                            'course_id' => $this->input->post('course_id'),
                            'batch_id' => $this->input->post('batch_id'),
                            'admission_no'=>$admission_no,
                            'name'=> $student_name,
                            'email_id'=> $student_email,
                            'mobile'=> $student_mobile,
                            'password'=> md5($password),
                            'gender'=> $gender,
                            'delete_status'=>1,
                            'status'=>'Active',
                            'adding_through'=> 'admin',
                            'created_on'=>date('Y-m-d H:i:s'),
                         );
         $result=$this->db2->insert('users',$insert_db2);
         $insert_id2=$this->db2->insert_id();
         $batch_id=$this->input->post('batch_id');
         $exam=$this->db2->query("select id from exams where bhatia_batch_id=".$batch_id." ")->row_array();

         $insert_users_exams=array(
                                'user_id'=> $insert_id2,
                                'exam_id'=> $exam['id'],
                                'payment_type'=>'paid',
                                'delete_status'=>1,
                                'status'=>'Active',
                                'created_on'=> date('Y-m-d H:i:s')
                              );

        $this->db2->insert('users_exams',$insert_users_exams);
        $message=getStudentRegisterMessage($student_dynamic_id);
		SendSMS($student_mobile,$message);
    	}


    }




    


}

?>