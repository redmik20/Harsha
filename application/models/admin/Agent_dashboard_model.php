<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent_dashboard_model extends CI_Model {

	public function get_incomes_total(){
		$user_id=$this->session->userdata('user_id');
		$query="SELECT sum(amount_paid)  as total_amount FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.created_by='".$user_id."' and tbl_student_payment_details.approval_status='Approved' ";
		//echo $query;exit;
		$result=$this->db->query($query)->row_array();
		return $result;
	}

    public function get_incomes_pending(){
        $user_id=$this->session->userdata('user_id');
        $query="SELECT sum(amount_paid)  as total_amount FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.created_by='".$user_id."' and tbl_student_payment_details.approval_status='Pending'";
        //echo $query;exit;
        $result=$this->db->query($query)->row_array();
        return $result;
    }

    public function get_incomes_rejected(){
        $user_id=$this->session->userdata('user_id');
        $query="SELECT sum(amount_paid)  as total_amount FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.created_by='".$user_id."' and tbl_student_payment_details.approval_status='Rejected' ";
        //echo $query;exit;
        $result=$this->db->query($query)->row_array();
        return $result;
    }

    

    public function get_incomes_payment_mode_total($payment_mode_id){
        $user_id=$this->session->userdata('user_id');
        $query="SELECT sum(amount_paid)  as total_amount FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.approval_status='Approved' and tbl_student_payment_details.payment_mode_id='".$payment_mode_id."'";
       // echo $query;exit;
        $result=$this->db->query($query)->row_array();
        return $result;
    }

    public function get_incomes_payment_mode_pending($payment_mode_id){
        $user_id=$this->session->userdata('user_id');
        $query="SELECT sum(amount_paid)  as total_amount FROM `tbl_student_payment_details` WHERE  tbl_student_payment_details.approval_status='Pending' and tbl_student_payment_details.payment_mode_id='".$payment_mode_id."' ";
        //echo $query;exit;
        $result=$this->db->query($query)->row_array();
        return $result;
    }

    public function get_incomes_payment_mode_rejected($payment_mode_id){
        $user_id=$this->session->userdata('user_id');
        $query="SELECT sum(amount_paid)  as total_amount FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.approval_status='Rejected' and tbl_student_payment_details.payment_mode_id='".$payment_mode_id."' ";
        //echo $query;exit;
        $result=$this->db->query($query)->row_array();
        return $result;
    }

    public function get_expense_approval(){
        $user_id=$this->session->userdata('user_id');
        $query="SELECT sum(amount)  as total_amount FROM `tbl_expenses` WHERE tbl_expenses.created_by='".$user_id."' and tbl_expenses.approval_status='Approved'";
        //echo $query;exit;
        $result=$this->db->query($query)->row_array();
        return $result;
    }

    public function get_expense_pending(){
        $user_id=$this->session->userdata('user_id');
        $query="SELECT sum(amount)  as total_amount FROM `tbl_expenses` WHERE tbl_expenses.created_by='".$user_id."' and tbl_expenses.approval_status='Pending'";
        //echo $query;exit;
        $result=$this->db->query($query)->row_array();
        return $result;
    }

    public function get_expense_rejected(){
        $user_id=$this->session->userdata('user_id');
        $query="SELECT sum(amount)  as total_amount FROM `tbl_expenses` WHERE tbl_expenses.created_by='".$user_id."' and tbl_expenses.approval_status='Rejected'";
        //echo $query;exit;
        $result=$this->db->query($query)->row_array();
        return $result;
    }

    public function student_view($stu_id){



        $this->db->select('states.state,organisations.organisation_name,centers.center,courses.course_name,batchs.batch_name,students.*');
        $this->db->from('students');
        $this->db->join('states','states.id=students.state_id');
        $this->db->join('organisations','organisations.id=students.organisation_id');
        $this->db->join('centers','centers.id=students.center_id');
        $this->db->join('courses','courses.id=students.course_id');
        $this->db->join('batchs','batchs.id=students.batch_id');
        $this->db->where('students.id',$stu_id);
        $this->db->order_by('students.id','desc');
        $query=$this->db->get();
        $result=$query->row_array();

        return $result;

    }

    

    public function get_my_total_admissions(){
        $user_id=$this->session->userdata('user_id');

        $query="SELECT count(id)  as admission_count FROM `tbl_students` WHERE tbl_students.created_by='".$user_id."' ";
        //echo $query;exit;
        $result=$this->db->query($query)->row_array();
        return $result;
    }

	public function all_records($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 

        $emp_record=$this->common_model->get_table_row('users',array('user_id'=>$this->session->userdata('user_id')),array('id','user_id','user_name','payment_mode_id'));
        $payment_mode_id=$emp_record['payment_mode_id'];

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
           $this->db->select('student_payment_details.id');
            $this->db->from('student_payment_details');
            $this->db->join('payment_modes','payment_modes.id=student_payment_details.payment_mode_id');
            $this->db->join('states','states.id=student_payment_details.state_id');
            $this->db->join('organisations','organisations.id=student_payment_details.organisation_id');
            $this->db->join('centers','centers.id=student_payment_details.center_id');
            //->where('student_payment_details.student_id','0')
             /*if($this->session->userdata('user_id') != 'ADM0001'){
            $this->db->where('student_payment_details.created_by',$this->session->userdata('user_id'));
                }*/
            if($payment_mode_id !=0){
            $this->db->where('student_payment_details.payment_mode_id',$payment_mode_id);
            }
                //$this->db->where('student_payment_details.amount_from','1');
             return $this->db->order_by('student_payment_details.id','desc')->get()->num_rows();
        }
        else
        {
        $this->db->select('states.state,organisations.organisation_name,centers.center,student_payment_details.*,payment_modes.payment_mode');
        $this->db->from('student_payment_details');
        $this->db->join('states','states.id=student_payment_details.state_id');
        $this->db->join('organisations','organisations.id=student_payment_details.organisation_id');
        $this->db->join('centers','centers.id=student_payment_details.center_id');
        $this->db->join('payment_modes','payment_modes.id=student_payment_details.payment_mode_id');
        //->where('student_payment_details.student_id','0')
        /*if($this->session->userdata('user_id') != 'ADM0001'){
        $this->db->where('student_payment_details.created_by',$this->session->userdata('user_id'));
            }*/
        //$this->db->where('student_payment_details.amount_from','1');
        if($pdata['param'] == 2){
            if($payment_mode_id !=0){
            $this->db->where('student_payment_details.payment_mode_id',$payment_mode_id);
            }
         }
        $this->db->order_by('student_payment_details.id','desc');
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

    public function all_my_admisssions($pdata, $getcount=null)
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
            $this->db->select('students.id');
            $this->db->from('students');
            $this->db->join('courses','courses.id=students.course_id','left');
            $this->db->join('batchs','batchs.id=students.batch_id','left');
           if($this->session->userdata('user_id') != 'ADM0001'){
                $this->db->where('students.created_by',$this->session->userdata('user_id'));
                }
           return $this->db->order_by('students.id','asc')->get()->num_rows();

            //echo $this->db->last_query();exit;
        }
        else
        {
        $this->db->select('students.*,courses.course_name,batchs.batch_name');
        $this->db->from('students');
        $this->db->join('courses','courses.id=students.course_id','left');
        $this->db->join('batchs','batchs.id=students.batch_id','left');
        
        if($this->session->userdata('user_id') != 'ADM0001'){
        $this->db->where('students.created_by',$this->session->userdata('user_id'));
                }
        $this->db->order_by('students.id','asc');
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


}

?>