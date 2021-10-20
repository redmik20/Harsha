<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_model extends CI_Model
{	

	public function __construct()
    {
     parent::__construct();
    
     $this->db2 = $this->load->database('plato', TRUE);
     $this->db = $this->load->database('default', TRUE);
    }

    public function student_registration($data){

    	$batch=$this->common_model->get_table_row('batchs',array('id'=> $data['batch_id']),array('student_code'));
			if($batch['student_code'] != ''){
				$stuent_code=$batch['student_code'];
			}else{
				$stuent_code='STDN';
			}

		$password='bhatia123';
    	$data['admission_no']=getDynamicId('admission_no','ADMS');
    	$data['password']=md5($password);
    	$data['student_dynamic_id']= getDynamicId('student_no',$stuent_code);

    	$this->db->insert('students',$data);
    	//echo $this->db->last_query();exit;
    	$student_id=$this->db->insert_id();
    	

    	$insert_db2=array(
                            'student_id'=>$data['student_dynamic_id'],
                            'bhatia_row_id'=>$student_id,
                            'state_id'=> $data['state_id'],
                            'organisation_id'=> $data['organisation_id'],
                            'center_id' => $data['center_id'],
                            'course_id' => $data['course_id'],
                            'batch_id' => $data['batch_id'],
                            'admission_no'=>$data['admission_no'],
                            'name'=> $data['student_name'],
                            'email_id'=> $data['student_email'],
                            'mobile'=> $data['student_mobile'],
                            'password'=> md5($password),
                            'gender'=> $data['gender'],
                            'image'=> $data['image'],
                            'delete_status'=>1,
                            'status'=>'Active',
                            'adding_through'=> 'admin',
                            'created_on'=>date('Y-m-d H:i:s'),
                         );
         $result=$this->db2->insert('users',$insert_db2);
         //echo $this->db2->last_query();exit;
         $insert_id2=$this->db2->insert_id();
         $batch_id=$data['batch_id'];
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
        return $student_id;
    }


    function student_add_payments($post_data){

    	$this->db->insert('student_payment_details',$post_data);
    	$insert_id=$this->db->insert_id();

    	$final_settled_ary=array('final_settled'=>$post_data['final_settled'],'due_amount'=> $post_data['due_amount']);
        $this->db->update('student_payment_details',$final_settled_ary,array('student_id'=> $post_data['student_id'],'batch_id'=>$post_data['batch_id']));
        
    	return $insert_id;
    }

}
?>