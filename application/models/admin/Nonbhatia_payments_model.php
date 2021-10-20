

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Nonbhatia_payments_model extends CI_Model {

    private $table='student_payment_details';

    public function __construct()
    {
     parent::__construct();
    
     $this->db2 = $this->load->database('plato', TRUE);
     
    }

    public function update_record($data,$id){
        if($id !=''){

            $db_batch=$this->common_model->get_table_row('student_payment_details',array('id'=> $id),array('batch_id','student_id'));
            if($db_batch['batch_id'] == $this->input->post('batch_id')){
            $result=$this->db->update($this->table,$data,array('id'=>$id));
            $update_ary=array(
                    'room_no'=> $this->input->post('room_no'),
                    'cabin_no'=> $this->input->post('cabin_no'),
                   
                    );
            $result1=$this->db->update('students',$update_ary,array('id'=>$db_batch['student_id']));
            }else{
                $batch=$this->common_model->get_table_row('batchs',array('id'=> $this->input->post('batch_id')),array('student_code','start_date','end_date'));
                if($batch['student_code'] != ''){
                    $stuent_code=$batch['student_code'];
                }else{
                    $stuent_code='STDN';
                }
                $student_dynamic_id=getDynamicId('student_no',$stuent_code);
                $update_ary=array(
                    'student_dynamic_id'=>$student_dynamic_id,
                    'valid_from' => $batch['start_date'],
                    'valid_to' => $batch['end_date'],
                    'room_no'=> $this->input->post('room_no'),
                    'cabin_no'=> $this->input->post('cabin_no'),
                
                    );
                 $result1=$this->db->update('students',$update_ary,array('id'=>$db_batch['student_id']));
                 $result=$this->db->update($this->table,$data,array('id'=>$id));
            }
            //echo $this->db->last_query();exit;
        }else{
            $this->db->insert($this->table,$data);
           // echo $this->db->last_query();exit;
            $result= $this->db->insert_id();
        }

        return $result;
    }
    
  public function insert_record($data){

    $batch=$this->common_model->get_table_row('batchs',array('id'=> $this->input->post('batch_id')),array('student_code','start_date','end_date'));
            if($batch['student_code'] != ''){
                $stuent_code=$batch['student_code'];
            }else{
                $stuent_code='STDN';
            }
            
            $user_exists=$this->common_model->get_table_row('students',array('student_mobile'=>$this->input->post('mobile_number'),'organisation_id'=>$this->input->post('organisation_id')),array());
         // echo '<pre>';print_r($user_exists);
            $user_alt_exists=$this->common_model->get_table_row('students',array('student_alt_mobile'=>$student_mobile,'organisation_id'=>$organisation_id),array());
        if(empty($user_exists)){

             if(empty($user_alt_exists)){
           
            $student_dynamic_id=getDynamicId('student_no',$stuent_code);
            $admission_no=getDynamicId('admission_no','ADMS');
            $password= 'bhatia123';
            $student_data=array(
                                'admission_no'=>$admission_no,
                                'student_dynamic_id'=>$student_dynamic_id,
                                'state_id'=>$this->input->post('state_id'),
                                'organisation_id'=>$this->input->post('organisation_id'),
                                'center_id'=>$this->input->post('center_id'),
                                'course_id'=>$this->input->post('course_id'),
                                'batch_id'=>$this->input->post('batch_id'),
                                'password'=>md5($password),
                                'student_name' => $this->input->post('student_name'),
                                'student_mobile' => $this->input->post('mobile_number'),
                                'room_no'=> $this->input->post('room_no'),
                                'cabin_no'=> $this->input->post('cabin_no'),
                                'valid_from' => $batch['start_date'],
                                'valid_to' => $batch['end_date'],
                                'adding_from' => 'admin',
                                'created_by'=>$this->session->userdata('user_id'),
                                'created_on'=>date('Y-m-d H:i:s'),
                                'status'=>'Active'
                                );
        // echo '<pre>';print_r($student_data);exit;
         $this->db->insert('students',$student_data);
        // echo $this->db->last_query();exit;
         $student_id= $this->db->insert_id();
         $data['student_id']=$student_id;
         $data['student_dy_id']=$student_dynamic_id;

         $student_email='nomail@gmail.com';$gender='';
         $insert_db2=array(
                            'student_id'=>$student_dynamic_id,
                            'bhatia_row_id'=>$student_id,
                            'state_id'=>$this->input->post('state_id'),
                            'organisation_id'=>$this->input->post('organisation_id'),
                            'center_id'=>$this->input->post('center_id'),
                            'course_id'=>$this->input->post('course_id'),
                            'batch_id'=>$this->input->post('batch_id'),
                            'admission_no'=>$admission_no,
                            'name'=> $this->input->post('student_name'),
                            'email_id'=> $student_email,
                            'mobile'=> $this->input->post('mobile_number'),
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

            }else{
                $data['student_id']=$user_alt_exists['id'];
                $data['student_dy_id']=$user_alt_exists['student_dynamic_id']; 
            }
        }else{
           $data['student_id']=$user_exists['id'];
           $data['student_dy_id']=$user_exists['student_dynamic_id']; 

           /*$update_ary=array(
                    'room_no'=> $this->input->post('room_no'),
                    'cabin_no'=> $this->input->post('cabin_no'),
                    'grid'=> $this->input->post('grid'),
                    );
          $result1=$this->db->update('students',$update_ary,array('id'=>$data['student_id']));*/
        }
     //echo '<pre>';print_r($data);
     $this->db->insert($this->table,$data);
           //echo $this->db->last_query();exit;
     $student_payment_id= $this->db->insert_id();
     if($data['final_settled'] == 'yes'){

        $update_data=array('final_settled'=>'yes','due_amount'=>0);
        $this->db->update($this->table,$update_data,array('mobile_number'=>$data['mobile_number'],'batch_id'=>$data['batch_id']));

     }
     return $student_payment_id;
  }

    public function all_records($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'student_payment_details.mobile_number',
            1 => 'student_payment_details.transaction_id',
            2 => 'states.state',
            3 => 'organisations.organisation_name',
            4 => 'centers.center',


        );
        $search_1 = array
        (
             1 => 'student_payment_details.mobile_number',
             2 => 'student_payment_details.transaction_id',
             3 => 'states.state',
             4 => 'organisations.organisation_name',
             5 => 'centers.center',

            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('student_payment_details.id')
            ->from('student_payment_details')
            ->join('payment_modes','payment_modes.id=student_payment_details.payment_mode_id')
            ->join('states','states.id=student_payment_details.state_id')
            ->join('organisations','organisations.id=student_payment_details.organisation_id')
            ->join('centers','centers.id=student_payment_details.center_id')
            //->where('student_payment_details.student_id','0')
            ->where('student_payment_details.amount_from','1')
            ->where('student_payment_details.created_by',$this->session->userdata('user_id'))
            ->order_by('student_payment_details.id','desc')->get()->num_rows();
        }
        else
        {
        $this->db->select('states.state,organisations.organisation_name,centers.center,student_payment_details.*,payment_modes.payment_mode')
        ->from('student_payment_details')
        ->join('states','states.id=student_payment_details.state_id')
        ->join('organisations','organisations.id=student_payment_details.organisation_id')
        ->join('centers','centers.id=student_payment_details.center_id')
        ->join('payment_modes','payment_modes.id=student_payment_details.payment_mode_id')
        //->where('student_payment_details.student_id','0')
        ->where('student_payment_details.amount_from','1')
        ->where('student_payment_details.created_by',$this->session->userdata('user_id'))
        ->order_by('student_payment_details.id','desc');
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
        $center1 = $this->db->get()->result_array();       
       // echo $this->db->last_query();exit;
        foreach($center1 as $key=>$values)
        {
            $center1[$key]['sno'] = $generatesno++;           
           
        }
        return $center1;
    }   

    public function get_record($id){
        $this->db->select('*');
        $this->db->where('id',$id);
        $this->db->from($this->table);
        $result=$this->db->get()->row_array();
        return $result;
    }

    public function change_portal_status($id, $status)
    {        
        $this->db->where('id', $id);
        $result=$this->db->update($this->table, array('status' => $status));                    
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

    public function insertIncomes($data){

        if($data[0] != ''){
        $state_id= $data[0];
        }else{
        $state_id= '';  
        }

        if($data[1] != ''){
        $type= $data[1];
        }else{
        $type= '';    
        }

        if($data[2] != ''){
        $organisation_id= $data[2];
        }else{
        $organisation_id= '';    
        }

        if($data[3] != ''){
        $center_id= $data[3];
        }else{
        $center_id= ''; 
        }

        if($data[4] != ''){
        $course_id= $data[4];
        }else{
        $course_id= '';    
        }       

        if($data[5] != ''){
        $batch_id= $data[5];
        }else{
        $batch_id= '';    
        }

        if($data[6] != ''){
        $student_name= $data[6];
        }else{
        $student_name= '';   
        }

        if($data[7] != ''){
        $student_mobile= $data[7];
        }else{
        $student_mobile= '';    
        }

        if($data[8] != ''){
        $college_state_id= $data[8];
        }else{
        $college_state_id= '';    
        }
        if($data[9] != ''){
        $college_id= $data[9];
        }else{
        $college_id= '';   
        }
        if($data[10] != ''){
        $payment_for= $data[10];
        }else{
        $payment_for= ''; 
        }
        if($data[11] != ''){
        $transaction_id= $data[11];
        }else{
        $transaction_id= '';  
        }
        if($data[12] != ''){
        $payment_mode_id= $data[12];
        }else{
        $payment_mode_id= '';   
        }

        if($data[13] != ''){
        $attachment_id= $data[13];
        }else{
        $attachment_id= '';   
        }

        if($data[14] != ''){
        $total_fee= $data[14];
        }else{
        $total_fee= '';    
        }

        if($data[15] != ''){
        $discount_fee= $data[15];
        }else{
        $discount_fee= ''; 
        }

        if($data[16] != ''){
        $discount_scheme= $data[16];
        }else{
        $discount_scheme= '';    
        }

        if($data[17] != ''){
        $amount_paid= $data[17];
        }else{
        $amount_paid= '';  
        }

        if($data[18] != ''){
        $amount_paid_date= date("Y-m-d", strtotime($data[18]));
        }else{
        $amount_paid_date= ''; 
        }

        if($data[19] != ''){
        $due_amount= $data[19];
        }else{
        $due_amount= ''; 
        }

        if($data[20] != ''){
        $due_date= date("Y-m-d", strtotime($data[20]));
        }else{
        $due_date= ''; 
        }

        if($data[21] != ''){
        $final_settled= $data[21];
        }else{
        $final_settled= ''; 
        }

        if($data[22] != ''){
        $remarks= $data[22];
        }else{
        $remarks= ''; 
        }

        if($type == 'regular'){
            $type='nonbhatia';
        }
        if( ($type !='') && ($state_id !='') && ($organisation_id !='') && ($center_id !='') && ($course_id !='') && ($batch_id !='') && ($payment_mode_id !='') && ($attachment_id !='') && ($amount_paid != 0)){
        $payment_data=array(
                                'type'=>$type,
                                'state_id'=>$state_id,
                                'organisation_id'=>$organisation_id,
                                'center_id'=>$center_id,
                                'course_id'=>$course_id,
                                'batch_id'=>$batch_id,
                                'receipt_id'=>getDynamicId('receipt_no','RECPT'),
                                'student_name'=>$student_name,
                                'mobile_number'=>$student_mobile,
                                'college_state_id' => $college_state_id,
                                'college_id'=>$college_id,
                                'payment_for'=>$payment_for,
                                'payment_mode_id'=>$payment_mode_id,
                                'attachment_id'=>$attachment_id,
                                'transaction_id'=>$transaction_id,
                                'total_fee'=>$total_fee,
                                'amount_paid'=>$amount_paid,
                                'amount_paid_date'=>$amount_paid_date,
                                'due_amount'=>$due_amount,
                                'due_date'=>$due_date,
                                'final_settled'=>$final_settled,
                                'remarks'=> $remarks,
                                'created_by'=>$this->session->userdata('user_id'),
                                'created_on'=>date('Y-m-d H:i:s')
                            );

        $batch=$this->common_model->get_table_row('batchs',array('id'=> $batch_id),array('student_code','start_date','end_date'));
            if($batch['student_code'] != ''){
                $stuent_code=$batch['student_code'];
            }else{
                $stuent_code='STDN';
            }

        $user_exists=$this->common_model->get_table_row('students',array('student_mobile'=>$student_mobile,'organisation_id'=>$organisation_id),array());

        $user_alt_exists=$this->common_model->get_table_row('students',array('student_alt_mobile'=>$student_mobile,'organisation_id'=>$organisation_id),array());

       if(empty($user_exists)){

         if(empty($user_alt_exists)){
           
            $student_dynamic_id=getDynamicId('student_no',$stuent_code);
            $password= 'bhatia123';
            $admission_no=getDynamicId('admission_no','ADMS');
            $student_data=array(
                                'admission_no'=>$admission_no,
                                'student_dynamic_id'=>$student_dynamic_id,
                                'state_id'=>$state_id,
                                'organisation_id'=>$organisation_id,
                                'center_id'=>$center_id,
                                'course_id'=>$course_id,
                                'batch_id'=>$batch_id,
                                'password'=>md5($password),
                                'student_name' => $student_name,
                                'student_mobile' => $student_mobile,
                                'valid_from' => $batch['start_date'],
                                'valid_to' => $batch['end_date'],
                                'adding_from' => 'admin',
                                'created_by'=>$this->session->userdata('user_id'),
                                'created_on'=>date('Y-m-d H:i:s'),
                                'status'=>'Active'
                                );
         //echo '<pre>';print_r($student_data);exit;
         $this->db->insert('students',$student_data);
         $student_id= $this->db->insert_id();
         $payment_data['student_id']=$student_id;
         $payment_data['student_dy_id']=$student_dynamic_id;

         $student_email='nomail@gmail.com';$gender='';
         $insert_db2=array(
                            'student_id'=>$student_dynamic_id,
                            'bhatia_row_id'=>$student_id,
                            'state_id'=> $state_id,
                            'organisation_id'=> $organisation_id,
                            'center_id' => $center_id,
                            'course_id' => $course_id,
                            'batch_id' => $batch_id,
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
            }else{
                $payment_data['student_id']=$user_alt_exists['id'];
                $payment_data['student_dy_id']=$user_alt_exists['student_dynamic_id'];
            }

        }else{
           $payment_data['student_id']=$user_exists['id'];
           $payment_data['student_dy_id']=$user_exists['student_dynamic_id']; 
        }
        //echo '<pre>';print_r($payment_data);exit;

        $this->db->insert($this->table,$payment_data);
        $stu_payment_id= $this->db->insert_id();
        return  $stu_payment_id;
       }else{ 
        return false;
        }

    }
    

}?>