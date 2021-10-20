<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Student_model extends CI_Model {

    public function __construct()
    {
     parent::__construct();
    
     $this->db2 = $this->load->database('plato', TRUE);
     
    }

    public function student_states_wise_count(){
        $query='select s.id,s.state,(select count(id) from tbl_students ts where ts.state_id=s.id) as students_count from tbl_states s where s.status="Active" ';
        //echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;
    }
    public function student_organisations_count($state_id){
        $query="select tbl_organisations.id,tbl_organisations.organisation_name,(select count(id) from tbl_students where tbl_students.state_id=".$state_id." and tbl_students.organisation_id=tbl_organisations.id) as students_count from tbl_organisations where tbl_organisations.status='Active' and tbl_organisations.state_id=".$state_id." ";
        //echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;
    }

    public function student_centers_count($state_id,$org_id){
        $query="select tbl_centers.id,tbl_centers.center,(select count(id) from tbl_students where tbl_students.state_id=".$state_id." and tbl_students.organisation_id=".$org_id." and tbl_students.center_id=tbl_centers.id) as students_count from tbl_centers where  tbl_centers.state_id=".$state_id." and tbl_centers.organisation_id=".$org_id." and tbl_centers.status='Active'";
        //echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;
    }

    public function getStudentRegisterMessage($student_id){
   

    //$message='Dear Doctor,Kindly download My Coaching Institute App used for your institution uses.Your ID: '.$student_id.', Password: bhatia123, Change the password as soon as you log-in in to your account. Android: shorturl.at/rzFXY. For ios shorturl.at/uvNTY. any doubts please Call: +919381915140 - Bhatia';
                //echo $message;exit;
        $message=getStudentRegisterMessage($student_id);
        return $message;
    }

	public function add_student($profile_image1,$student_dynamic_id,$qrcode_path){

		//echo '<pre>';print_r($this->input->post());exit;
		$admission_no=getDynamicId('admission_no','ADMS');
		$password= 'bhatia123';
		$insert_data=array(
			 				 'state_id'=> $this->input->post('state_id'),
                             'organisation_id'=> $this->input->post('organisation_id'),
			 				 'admission_no'=>$admission_no,
			 				 'student_dynamic_id'=>$student_dynamic_id,
			                 'center_id' => $this->input->post('center_id'),
			                 'course_id' => $this->input->post('course_id'),
			                 'batch_id' => $this->input->post('batch_id'), 
			                 'student_name' => $this->input->post('student_name'),
			                 'student_mobile' => $this->input->post('mobile_no'),
			                 'image'=>$profile_image1,
                             'qrcode_path'=>$qrcode_path,
                             'password'=>md5($password),
                            // 'device_id'=>md5($student_dynamic_id),
			                 'student_alt_mobile' => $this->input->post('alt_mobile_no'),
			                 'student_email' => $this->input->post('email_id'),
			                 'father_name' => $this->input->post('father_name'),
			                 'occupation' => $this->input->post('occupation'),
                             'gender'=> $this->input->post('gender'),
                             'room_no'=> $this->input->post('room_no'),
                             'cabin_no'=> $this->input->post('cabin_no'),
			                 'res_contact_no' => $this->input->post('res_contact_no'),
			                 'guardian_contact_no' => $this->input->post('guardian_contact_no'),
			                 'permanent_address' => $this->input->post('permanent_address'),
			                 'address_state_id' => $this->input->post('address_state'),
			                 //'pincode' => $this->input->post('pincode'),
			                 'college_mbbs' => $this->input->post('college_mbbs'),
			                 'mbbs_state' => $this->input->post('mbbs_state'),
			                 'internship_college' => $this->input->post('internship_college'),
			                 'internship_join_date' => $this->input->post('internship_join_date'),
			                 'presently_working' => $this->input->post('presently_working'),
			                 'valid_from' => $this->input->post('valid_from'),
			                 'valid_to' => $this->input->post('valid_to'),
                             'adding_from' => 'admin',
                             'created_by'=>$this->session->userdata('user_id'),
			                 'created_on'=>date('Y-m-d H:i:s'),
			                 'status'=>'Active'
			              );
		$result=$this->db->insert('students',$insert_data);
        //echo $this->db->last_query();exit;
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
                            'name'=> $this->input->post('student_name'),
                            'email_id'=> $this->input->post('email_id'),
                            'mobile'=> $this->input->post('mobile_no'),
                            'password'=> md5($password),
                            'gender'=> $this->input->post('gender'),
                            'image'=> $profile_image1,
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

        //$this->db2->update();
		return $insert_id;
	}

    public function update_student($id,$profile_image1){

        $update_data=array(
                             'state_id'=> $this->input->post('state_id'),
                             'organisation_id'=> $this->input->post('organisation_id'),
                             'center_id' => $this->input->post('center_id'),
                             'course_id' => $this->input->post('course_id'),
                             'batch_id' => $this->input->post('batch_id'), 
                             'student_name' => $this->input->post('student_name'),
                             'student_mobile' => $this->input->post('mobile_no'),
                             'gender'=> $this->input->post('gender'),
                             'image'=>$profile_image1,
                             'student_alt_mobile' => $this->input->post('alt_mobile_no'),
                             'student_email' => $this->input->post('email_id'),
                             'father_name' => $this->input->post('father_name'),
                             'occupation' => $this->input->post('occupation'),
                             'room_no'=> $this->input->post('room_no'),
                             'cabin_no'=> $this->input->post('cabin_no'),
                             'res_contact_no' => $this->input->post('res_contact_no'),
                             'guardian_contact_no' => $this->input->post('guardian_contact_no'),
                             'permanent_address' => $this->input->post('permanent_address'),
                             'address_state_id' => $this->input->post('address_state'),
                            // 'pincode' => $this->input->post('pincode'),
                             'college_mbbs' => $this->input->post('college_mbbs'),
                             'mbbs_state' => $this->input->post('mbbs_state'),
                             'internship_college' => $this->input->post('internship_college'),
                             'internship_join_date' => $this->input->post('internship_join_date'),
                             'presently_working' => $this->input->post('presently_working'),
                             'valid_from' => $this->input->post('valid_from'),
                             'valid_to' => $this->input->post('valid_to'),
                             'modified_by'=>$this->session->userdata('user_id'),
                             'modified_on'=>date('Y-m-d H:i:s'),
                           
                          );
        $result=$this->db->update('students',$update_data,array('id'=>$id));

        $update_db2=array(
                            'state_id'=> $this->input->post('state_id'),
                            'organisation_id'=> $this->input->post('organisation_id'),
                            'center_id' => $this->input->post('center_id'),
                            'course_id' => $this->input->post('course_id'),
                            'batch_id' => $this->input->post('batch_id'),
                            'name'=> $this->input->post('student_name'),
                            'email_id'=> $this->input->post('email_id'),
                            'mobile'=> $this->input->post('mobile_no'),
                            'gender'=> $this->input->post('gender'),
                            'image'=> $profile_image1,
                            'modified_on'=>date('Y-m-d H:i:s'),
                         );
        $result=$this->db2->update('users',$update_db2,array('bhatia_row_id'=>$id));
        
         $batch_id=$this->input->post('batch_id');
         $exam=$this->db2->query("select id from exams where bhatia_batch_id=".$batch_id." ")->row_array();
         $bhatia_user=$this->db2->query("select id from users where bhatia_row_id=".$id." ")->row_array();
         $up_users_exams=array(
                                'user_id'=> $bhatia_user['id'],
                                'exam_id'=> $exam['id'],
                                'payment_type'=>'paid',
                                'delete_status'=>1,
                                'status'=>'Active',
                                'modified_on'=> date('Y-m-d H:i:s')
                              );
        $this->db2->update('users_exams',$up_users_exams,array('user_id'=>$bhatia_user['id']));

        return $result; 
    }
  
    /*public function insert_studentsIn_DB2($students){

        foreach($students as $student){

        $insert_db2=array(
                            'student_id'=>$student['student_dynamic_id'],
                            'bhatia_row_id'=>$student['id'],
                            'admission_no'=>$student['admission_no'],
                            'name'=> $student['student_name'],
                            'email_id'=> $student['student_email'],
                            'mobile'=> $student['student_mobile'],
                            'password'=> $student['password'],
                            'gender'=> $student['gender'],
                            'image'=> $student['image'],
                            'delete_status'=>1,
                            'status'=>$student['status'],
                            'adding_through'=> $student['adding_from'],
                            'created_on'=>date('Y-m-d H:i:s'),
                         );
         $result=$this->db2->insert('users',$insert_db2);
        }
        return true;
    }*/

	public function all_students($pdata, $getcount=null)
    {
    	// $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
    	  //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'student_mobile',
            1 => 'student_name',
            2 => 'student_dynamic_id',
            3 => 'admission_no',
            4 => 'batch_name',
            5 => 'course_name',
        );
        $search_1 = array
        (
             1 => 'students.student_mobile',
             2 => 'students.student_name',
             3 => 'students.student_dynamic_id',
             4 => 'students.admission_no',
             5 => 'batchs.batch_name',
             6 => 'courses.course_name',
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('students.id')
            ->from('students')
            ->join('courses','courses.id=students.course_id','left')
            ->join('batchs','batchs.id=students.batch_id','left')
            ->where('students.state_id',$pdata['state_id'])
            ->where('students.organisation_id',$pdata['org_id'])
            ->where('students.center_id',$pdata['center_id'])
            ->order_by('students.created_on','desc')->get()->num_rows();
        }
        else
        {
        $this->db->select('students.*,courses.course_name,batchs.batch_name')
        ->from('students')
        ->join('courses','courses.id=students.course_id','left')
        ->join('batchs','batchs.id=students.batch_id','left')
        ->where('students.state_id',$pdata['state_id'])
        ->where('students.organisation_id',$pdata['org_id'])
        ->where('students.center_id',$pdata['center_id'])
        ->order_by('students.created_on','desc');
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
       // echo $this->db->last_query();exit;
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }    

    public function get_record($id){

        $this->db->select('*');
        $this->db->where('id',$id);
        $this->db->from('students');
        $result=$this->db->get()->row_array();
        return $result;
    }
 public function student_till_now_paid_amt($stu_id){
    $till_now_paid_amt=$this->db->query("select sum(amount_paid) as total_amt from tbl_student_payment_details where student_id=$stu_id GROUP BY student_id" )->row_array();
    return $till_now_paid_amt;

 }
    public function add_student_payment_details($stu_id){

       if($this->input->post('due_date') != ''){
        $new_due_date=date("Y-m-d", strtotime($this->input->post('due_date')));
        }else{$new_due_date = '0000-00-00'; }
      //echo $new_due_date;exit;
       if($this->input->post('due_amount') == 0){
            $final_settled='yes';
        }else{
            $final_settled='no';
        }
        //$final_settled=$this->input->post('final_settled');

        $student=$this->common_model->get_table_row('students',array('id'=> $stu_id),array('id,student_dynamic_id,state_id,organisation_id,center_id,course_id,batch_id,student_name,student_mobile'));

        $attachment=$this->common_model->get_table_row('payment_modes',array('id'=> $this->input->post('payment_mode')),array('id,attachment_id'));
        //echo '<pre>';print_r($this->input->post());

        $insert_payment=array(
                                'receipt_id'=>getDynamicId('receipt_no','RECPT'),
                                'student_id'=> $stu_id,
                                'state_id'=>$student['state_id'],
                                'organisation_id'=>$student['organisation_id'],
                                'center_id'=>$student['center_id'],
                                'course_id'=>$student['course_id'],
                                'batch_id'=>$student['batch_id'],
                                'student_name'=>$student['student_name'],
                                'mobile_number'=>$student['student_mobile'],
                                'student_dy_id'=>$student['student_dynamic_id'],
                                'total_fee'=> $this->input->post('total_fee'),
                                'discount_fee'=> $this->input->post('discount_fee'),
                                'discount_scheme'=> $this->input->post('discount_scheme'),
                                'amount_paid'=> $this->input->post('amount_paid'),
                                'amount_paid_date'=> $this->input->post('amount_paid_date'),
                                'transaction_id'=> $this->input->post('transaction_id'),
                                'payment_mode_id'=> $this->input->post('payment_mode'),
                                'attachment_id'=>$attachment['attachment_id'],
                                'due_amount'=> $this->input->post('due_amount'),
                                'due_date'=> $new_due_date,
                                'remarks'=> $this->input->post('remarks'),
                                'final_settled'=>$final_settled,
                                'created_on'=> date('Y-m-d H:i:s'),
                                'created_by' => $this->session->userdata('user_id'),
                             );
      // echo '<pre>';print_r($insert_payment);exit;
        $this->db->insert('student_payment_details',$insert_payment);
        $insert_id=$this->db->insert_id();
        $update_final_status=array('final_settled'=>$final_settled);
        $result=$this->db->update('students',$update_final_status,array('id'=> $stu_id));

        
        
        $final_settled_ary=array('final_settled'=>$final_settled,'due_amount'=> $this->input->post('due_amount'));
        
        $this->db->update('student_payment_details',$final_settled_ary,array('student_id'=> $stu_id,'batch_id'=>$student['batch_id']));
        

        return $insert_id;
    }

    public function edit_student_payment_details($id){

       if($this->input->post('due_amount') == 0){
            $final_settled='yes';
        }else{
            $final_settled='no';
        }
        // $final_settled=$this->input->post('final_settled');
         $stu_pay_record=$this->common_model->get_table_row('student_payment_details',array('id'=> $id),array('student_id'));
         $stu_id=$stu_pay_record['student_id'];
         $student=$this->common_model->get_table_row('students',array('id'=> $stu_id),array('id,student_dynamic_id,state_id,organisation_id,center_id,course_id,batch_id,student_name,student_mobile'));

         $attachment=$this->common_model->get_table_row('payment_modes',array('id'=> $this->input->post('payment_mode')),array('id,attachment_id'));

        $update_payment=array(
                                'state_id'=>$student['state_id'],
                                'organisation_id'=>$student['organisation_id'],
                                'center_id'=>$student['center_id'],
                                'course_id'=>$student['course_id'],
                                'batch_id'=>$student['batch_id'],
                                'student_dy_id'=>$student['student_dynamic_id'],
                                'student_name'=>$student['student_name'],
                                'mobile_number'=>$student['student_mobile'],
                                'total_fee'=> $this->input->post('total_fee'),
                                'discount_fee'=> $this->input->post('discount_fee'),
                                'discount_scheme'=> $this->input->post('discount_scheme'),
                                'amount_paid'=> $this->input->post('amount_paid'),
                                'amount_paid_date'=> $this->input->post('amount_paid_date'),
                                'transaction_id'=> $this->input->post('transaction_id'),
                                'payment_mode_id'=> $this->input->post('payment_mode'),
                                'attachment_id'=>$attachment['attachment_id'],
                                'due_amount'=> $this->input->post('due_amount'),
                                'due_date'=> $this->input->post('due_date'),
                                'remarks'=> $this->input->post('remarks'),
                                'final_settled'=>$final_settled,
                                'modified_on'=> date('Y-m-d H:i:s'),
                                'modified_by' => $this->session->userdata('user_id'),
                             );
       // echo '<pre>';print_r($update_payment);
        $this->db->update('student_payment_details',$update_payment,array('id'=>$id));
        //echo $this->db->last_query();exit;
        $update_final_status=array('final_settled'=>$final_settled);
        $result=$this->db->update('students',$update_final_status,array('id'=> $this->input->post('student_id')));

        $final_settled_ary=array('final_settled'=>$final_settled,'due_amount'=> $this->input->post('due_amount'));

        $this->db->update('student_payment_details',$final_settled_ary,array('student_id'=> $stu_id,'batch_id'=>$student['batch_id']));
        
        return $result;
    }

    public function change_record_status($user_id, $status)
    {        
        $this->db->where('id', $user_id);
        $result=$this->db->update('students', array('status' => $status));
                    
        return $result;
    }

    public function all_students_payments($pdata, $getcount=null)
    {
        $columns = array
        (
            0 => 'receipt_id',
        );
        $search_1 = array
        (
             1 => 'student_payment_details.receipt_id',
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('student_payment_details.id')->from('student_payment_details')->join('students','students.id=student_payment_details.student_id','left')->where('student_payment_details.student_id',$pdata['student_id'])->order_by('student_payment_details.id','asc')->get()->num_rows();
        }
        else
        {
        $this->db->select('student_payment_details.*,students.student_dynamic_id,students.student_mobile')->from('student_payment_details')->join('students','students.id=student_payment_details.student_id','left')->where('student_payment_details.student_id',$pdata['student_id'])->order_by('student_payment_details.id','asc');
        //echo $this->db->last_query();exit;
        }
        if(isset($pdata['length']))
        {
            $perpage = $pdata['length'];
            $limit = $pdata['start'];
            $generatesno=$limit+1;
            $orderby_field = $columns[$pdata['order'][0]['column'] ];   
            $orderby = $pdata['order']['0']['dir'];
            $this->db->order_by($orderby_field,$orderby);
            $this->db->limit($perpage,$limit);
        }
        else
        {
            $generatesno = 0;
        }
        $result = $this->db->get()->result_array();       
       // echo $this->db->last_query();exit;
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }   


    public function get_payment_record($id){

        $this->db->select('student_payment_details.*,students.student_dynamic_id,students.final_settled,students.student_name');
        $this->db->where('student_payment_details.id',$id);
        $this->db->from('student_payment_details');
        $this->db->join('students','students.id=student_payment_details.student_id');
        $result=$this->db->get()->row_array();
        return $result;
    } 

    public function get_student_data($student_id){
        $this->db->select('s.*,c.course_name,b.batch_name');
        $this->db->where('s.id',$student_id);
        $this->db->from('students s');
        $this->db->join('courses c','c.id=s.course_id');
        $this->db->join('batchs b','b.id=s.batch_id');
        $result=$this->db->get()->row_array();
        return $result;
    }

    public function get_student_due_amount($student_id,$total_fee){
      $query="select sum(amount_paid) as total_paid_amt from tbl_student_payment_details where student_id='$student_id' GROUP BY student_id";     
      $up_to_total_paid_ary=$this->db->query($query)->row_array();
      $due_amt=$total_fee-$up_to_total_paid_ary['total_paid_amt'];
      return $due_amt;
    }

    public function student_adm_sent_or_not($student_mobile){
      
      $query="select id from tbl_students_before_admissions where mobile_no='$student_mobile' and link_sent=1 ";
      $result=$this->db->query($query)->row_array();
      return $result;
    }

    public function insert_setp1_data($post){

        //echo '<pre>';print_r($post);exit;

        $tep_insert=array(
                            'complition_steps'=>'1',
                            'link_sent'=>'1',
                            'state_id'=>$post['state_id'],
                            'organisation_id'=>$post['organisation_id'],
                            'center_id'=>$post['center_id'],
                            'course_id'=>$post['course_id'],
                            'batch_id'=>$post['batch_id'],
                            'final_fee'=>$post['final_fee'],
                            'student_paid_amt'=>$post['student_paid_amt'],
                            'material_status'=>$post['material_status'],
                            'mobile_no'=>$post['student_mobile'],
                            'created_on'=> date('Y-m-d H:i:s'),
                            'created_by'=> $this->session->userdata('user_id'),

                         );
        
        $this->db->insert('students_before_admissions',$tep_insert);
        //echo $this->db->last_query();exit;
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }

    public function update_otp($otp,$id){
        $update_data=array(
                            'verify_otp'=> $otp,
                          );

        $result=$this->db->update('students_before_admissions',$update_data,array('id'=>$id));
        return $result;
       // echo $this->db->last_query();exit;
    }

    public function update_student_step2_data($post,$id,$imgurl){

       // echo '<pre>';print_r($post);exit;

        $update_data=array(
                            'complition_steps'=>'2',
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
                            'student_image_path'=>$imgurl,
                          );

        $result=$this->db->update('students_before_admissions',$update_data,array('id'=>$id));
        return $result;
    }


}?>