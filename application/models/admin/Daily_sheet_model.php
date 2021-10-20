<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daily_sheet_model extends CI_Model {


	
 public function all_search_employee_list($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $search_date=$pdata['search_date'];
        $columns = array
        (
            0 => 'users.user_mobile'

        );
        $search_1 = array
        (
             1 => 'users.user_mobile',
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('users.id')->from('users')->join('centers','centers.id=users.center_id')->order_by('centers.id','asc')->get()->num_rows();
        }
        else
        {

        $this->db->select("users.*,(select COALESCE(sum(amount_paid),0)  from tbl_student_payment_details where created_by=tbl_users.user_id and amount_paid_date='".$search_date."' and approval_status='Approved') as approved_income_total,(select COALESCE(sum(amount_paid),0)  from tbl_student_payment_details where created_by=tbl_users.user_id and amount_paid_date='".$search_date."' and approval_status='Pending') as pending_income_total,(select COALESCE(sum(amount_paid),0)  from tbl_student_payment_details where created_by=tbl_users.user_id and amount_paid_date='".$search_date."' and approval_status='Rejected') as rejected_income_total,(select COALESCE(sum(amount),0)  from tbl_expenses where created_by=tbl_users.user_id and amount_paid_date='".$search_date."' and approval_status='Approved') as approved_expense,(select COALESCE(sum(amount),0)  from tbl_expenses where created_by=tbl_users.user_id and amount_paid_date='".$search_date."' and approval_status='Pending') as pending_expense,(select COALESCE(sum(amount),0)  from tbl_expenses where created_by=tbl_users.user_id and amount_paid_date='".$search_date."' and approval_status='Rejected') as rejected_expense")->from('users')->join('centers','centers.id=tbl_users.center_id')->order_by('centers.id','asc');

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
 
    public function get_daily_approved_incomes($date){
        $today_date=$date;
        $query="select sum(amount_paid) as approved_income_total  from tbl_student_payment_details where amount_paid_date='".$today_date."' and approval_status='Approved' ";
        $result=$this->db->query($query)->row_array();
        return $result;
    }

    public function get_daily_approved_expenses($date){
        $today_date=$date;
        $query="select sum(amount) as approved_expense_total from tbl_expenses where amount_paid_date='".$today_date."' and approval_status='Approved' ";
       // echo $query;exit;
        $result=$this->db->query($query)->row_array();
        return $result;
    }

    public function all_daily_incomes_list_records($pdata, $getcount=null)
    {
       
        $today_date=$pdata['search_date'];
        $columns = array
        (
            0 => 'users.user_id',
            1 => 'users.user_name',
            2 => 'users.user_mobile',

        );
        $search_1 = array
        (
             1 => 'users.user_id',
             2 => 'users.user_name',
             3 => 'users.user_mobile',
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            $this->db->select('student_payment_details.id');
            $this->db->from('student_payment_details');
            $this->db->join('centers','centers.id=tbl_student_payment_details.center_id');
            $this->db->join('users','users.user_id=tbl_student_payment_details.created_by');
            if($this->session->userdata('user_type') != 'admin'){
                $this->db->where('expenses.created_by',$this->session->userdata('user_id'));
            }
            $this->db->where('student_payment_details.amount_paid_date',$today_date);
            $this->db->where('student_payment_details.approval_status','Approved');
            return $this->db->order_by('student_payment_details.id','desc')->get()->num_rows();
        }
        else
        {

        $this->db->select("student_payment_details.*,centers.center,users.user_name,users.user_mobile,users.user_id");
        $this->db->from('student_payment_details');
        $this->db->join('centers','centers.id=tbl_student_payment_details.center_id');
        $this->db->join('users','users.user_id=tbl_student_payment_details.created_by');
        if($this->session->userdata('user_type') != 'admin'){
                $this->db->where('expenses.created_by',$this->session->userdata('user_id'));
            }
        $this->db->where('student_payment_details.amount_paid_date',$today_date);
        $this->db->where('student_payment_details.approval_status','Approved');
        $this->db->order_by('student_payment_details.id','asc');

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

    public function all_daily_expense_list_records($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $today_date=$pdata['search_date'];
        $columns = array
        (
            0 => 'users.user_id',
            1 => 'users.user_name',
            2 => 'users.user_mobile',
        );
        $search_1 = array
        (
             1 => 'users.user_id',
             2 => 'users.user_name',
             3 => 'users.user_mobile',
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
           
            $this->db->select('expenses.id');
            $this->db->join('states','states.id=expenses.state_id','inner');
            $this->db->join('organisations','organisations.id=expenses.organisation_id','inner');
            $this->db->join('centers','centers.id=expenses.center_id','inner');
            $this->db->join('categories','categories.id=expenses.category_id','inner');
            $this->db->join('payment_modes','payment_modes.id=expenses.payment_mode_id','left');
            $this->db->join('users','users.user_id=expenses.created_by');
            if($this->session->userdata('user_type') != 'admin'){
                $this->db->where('expenses.created_by',$this->session->userdata('user_id'));
            }
            $this->db->where('expenses.amount_paid_date',$today_date);
            $this->db->where('expenses.approval_status','Approved');
            $this->db->from('expenses');
           return $this->db->order_by('expenses.id','desc')->get()->num_rows();
            //echo $this->db->last_query();exit;
        }
        else
        {
        
        $this->db->select('expenses.*,states.state,organisations.organisation_name,centers.center,categories.category_name,payment_modes.payment_mode,DATE_FORMAT(tbl_expenses.amount_paid_date, "%d-%m-%Y") as amount_paid_date,users.user_name,users.user_mobile,users.user_id');
            $this->db->join('states','states.id=expenses.state_id','inner');
            $this->db->join('organisations','organisations.id=expenses.organisation_id','inner');
            $this->db->join('centers','centers.id=expenses.center_id','inner');
            $this->db->join('categories','categories.id=expenses.category_id','inner');
            $this->db->join('payment_modes','payment_modes.id=expenses.payment_mode_id','left');
            $this->db->join('users','users.user_id=expenses.created_by');
            if($this->session->userdata('user_type') != 'admin'){
                $this->db->where('expenses.created_by',$this->session->userdata('user_id'));
            }
            $this->db->where('expenses.amount_paid_date',$today_date);
            $this->db->where('expenses.approval_status','Approved');
            $this->db->from('expenses');
            $this->db->order_by('expenses.id','desc');
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