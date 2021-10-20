<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paymentview_model extends CI_Model {


    public function get_state_wise_amount(){
        $query="SELECT tbl_states.id,tbl_states.state,(select sum(amount_paid) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.state_id=tbl_states.id and tbl_student_payment_details.approval_status='Approved') as total_amount,(select sum(due_amount) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.state_id=tbl_states.id and tbl_student_payment_details.approval_status='Approved') as total_due_amount FROM `tbl_states` WHERE tbl_states.status='Active'";
        $result=$this->db->query($query)->result_array();
        return $result;

    }

    public function get_organisation_wise_amount($state_id){

        $query="SELECT tbl_organisations.id,tbl_organisations.state_id,tbl_organisations.organisation_name,(select sum(amount_paid) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.state_id=".$state_id." and tbl_student_payment_details.organisation_id=tbl_organisations.id and tbl_student_payment_details.approval_status='Approved') as total_amount, (select sum(due_amount) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.state_id=".$state_id." and tbl_student_payment_details.organisation_id=tbl_organisations.id and tbl_student_payment_details.approval_status='Approved') as total_due_amount FROM tbl_organisations WHERE tbl_organisations.state_id=".$state_id." and tbl_organisations.status='Active' ";

        $result=$this->db->query($query)->result_array();
        return $result;

    }

    public function get_centers_wise_amount($state_id,$org_id){

        $query="SELECT tbl_centers.id,tbl_centers.state_id,tbl_centers.organisation_id,tbl_centers.center, (select sum(amount_paid) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.state_id=".$state_id." and tbl_student_payment_details.organisation_id=".$org_id." and tbl_student_payment_details.center_id=tbl_centers.id and tbl_student_payment_details.approval_status='Approved') as total_amount, (select sum(due_amount) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.state_id=".$state_id." and tbl_student_payment_details.organisation_id=".$org_id." and tbl_student_payment_details.center_id=tbl_centers.id and tbl_student_payment_details.approval_status='Approved') as total_due_amount FROM tbl_centers WHERE tbl_centers.state_id=".$state_id." and tbl_centers.organisation_id=".$org_id."  and tbl_centers.status='Active'";
        $result=$this->db->query($query)->result_array();
        return $result;

    }

    public function get_years_wise_amount($state_id,$org_id,$center_id){

        $query="SELECT tbl_years.id,tbl_years.year, (select sum(amount_paid) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.state_id=".$state_id." and tbl_student_payment_details.organisation_id=".$org_id." and tbl_student_payment_details.center_id=".$center_id." and YEAR(tbl_student_payment_details.amount_paid_date)= tbl_years.year and tbl_student_payment_details.approval_status='Approved') as total_amount,  (select sum(due_amount) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.state_id=".$state_id." and tbl_student_payment_details.organisation_id=".$org_id." and tbl_student_payment_details.center_id=".$center_id." and YEAR(tbl_student_payment_details.amount_paid_date)= tbl_years.year and tbl_student_payment_details.approval_status='Approved') as total_due_amount  FROM tbl_years WHERE tbl_years.status='Active'";
       // echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;

    }

    public function get_years_months_wise_amount($state_id,$org_id,$center_id,$year){
         $query="SELECT tbl_months.id,tbl_months.month, (select sum(amount_paid) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.state_id=".$state_id." and tbl_student_payment_details.organisation_id=".$org_id." and tbl_student_payment_details.center_id=".$center_id." and YEAR(tbl_student_payment_details.amount_paid_date)=".$year." and MONTH(tbl_student_payment_details.amount_paid_date)=tbl_months.id and tbl_student_payment_details.approval_status='Approved') as total_amount,  (select sum(due_amount) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.state_id=".$state_id." and tbl_student_payment_details.organisation_id=".$org_id." and tbl_student_payment_details.center_id=".$center_id." and YEAR(tbl_student_payment_details.amount_paid_date)=".$year." and MONTH(tbl_student_payment_details.amount_paid_date)=tbl_months.id and tbl_student_payment_details.approval_status='Approved') as total_due_amount  FROM tbl_months WHERE tbl_months.status='Active'";
        //echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;
    }

   public function get_center_wise_income($state_id,$org_id,$center_id,$year,$month_id){

        $query="SELECT tbl_centers.id,tbl_centers.state_id,tbl_centers.organisation_id,tbl_centers.center, (select sum(amount_paid) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.state_id=".$state_id." and tbl_student_payment_details.organisation_id=".$org_id." and tbl_student_payment_details.center_id=".$center_id." and YEAR(tbl_student_payment_details.amount_paid_date)=".$year." and MONTH(tbl_student_payment_details.amount_paid_date)=".$month_id." and tbl_student_payment_details.approval_status='Approved') as total_amount, (select sum(due_amount) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.state_id=".$state_id." and tbl_student_payment_details.organisation_id=".$org_id." and tbl_student_payment_details.center_id=".$center_id."  and YEAR(tbl_student_payment_details.amount_paid_date)=".$year." and MONTH(tbl_student_payment_details.amount_paid_date)=".$month_id." and tbl_student_payment_details.approval_status='Approved') as total_due_amount FROM tbl_centers WHERE tbl_centers.state_id=".$state_id." and tbl_centers.organisation_id=".$org_id." and tbl_centers.id=".$center_id."";
       // echo $query;exit;
        $result=$this->db->query($query)->row_array();
        return $result;
    }

    public function get_center_wise_expense($state_id,$org_id,$center_id,$year,$month_id){

         $query="SELECT tbl_expenses.state_id,tbl_expenses.organisation_id,tbl_expenses.center_id, (select sum(amount) FROM `tbl_expenses` WHERE tbl_expenses.state_id=".$state_id." and tbl_expenses.organisation_id=".$org_id." and tbl_expenses.center_id=".$center_id." and YEAR(tbl_expenses.amount_paid_date)=".$year." and MONTH(tbl_expenses.amount_paid_date)=".$month_id." and tbl_expenses.approval_status='Approved') as total_amount FROM tbl_expenses WHERE tbl_expenses.state_id=".$state_id." and tbl_expenses.organisation_id=".$org_id." and tbl_expenses.center_id=".$center_id." GROUP BY tbl_expenses.center_id";
       // echo $query;exit;
        $result=$this->db->query($query)->row_array();
        return $result;

    }

    public function get_payment_modes_income_wise_amount($state_id,$org_id,$center_id,$year,$month_id){

        $query="select tbl_payment_modes.id,tbl_payment_modes.payment_mode,(select sum(amount_paid) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.state_id=".$state_id." and tbl_student_payment_details.organisation_id=".$org_id." and tbl_student_payment_details.center_id=".$center_id." and tbl_student_payment_details.payment_mode_id=tbl_payment_modes.id and YEAR(tbl_student_payment_details.amount_paid_date)=".$year." and MONTH(tbl_student_payment_details.amount_paid_date)=".$month_id." and tbl_student_payment_details.approval_status='Approved') as total_amount from tbl_payment_modes where tbl_payment_modes.amount_type='income' and tbl_payment_modes.state_id=".$state_id." and tbl_payment_modes.organisation_id=".$org_id." and tbl_payment_modes.center_id=".$center_id." and tbl_payment_modes.status='Active' ";
            //echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;
    }

     public function get_payment_modes_expense_wise_amount($state_id,$org_id,$center_id,$year,$month_id){

        $query="select tbl_payment_modes.id,tbl_payment_modes.payment_mode,(select sum(amount) FROM `tbl_expenses` WHERE tbl_expenses.state_id=".$state_id." and tbl_expenses.organisation_id=".$org_id." and tbl_expenses.center_id=".$center_id." and tbl_expenses.payment_mode_id=tbl_payment_modes.id and YEAR(tbl_expenses.amount_paid_date)=".$year." and MONTH(tbl_expenses.amount_paid_date)=".$month_id." and tbl_expenses.approval_status='Approved') as total_amount from tbl_payment_modes where tbl_payment_modes.amount_type='expense' and tbl_payment_modes.state_id=".$state_id." and tbl_payment_modes.organisation_id=".$org_id." and tbl_payment_modes.center_id=".$center_id." and tbl_payment_modes.status='Active'  ";
           // echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;
    }

    public function get_categories_wise_amount($state_id,$org_id,$center_id,$year,$month_id){
        $query="select tbl_categories.id,tbl_categories.category_name,(select sum(amount) FROM `tbl_expenses` WHERE tbl_expenses.state_id=".$state_id." and tbl_expenses.organisation_id=".$org_id." and tbl_expenses.center_id=".$center_id." and tbl_expenses.category_id=tbl_categories.id and YEAR(tbl_expenses.amount_paid_date)=".$year." and MONTH(tbl_expenses.amount_paid_date)=".$month_id." and tbl_expenses.approval_status='Approved') as total_amount from tbl_categories where tbl_categories.state_id=".$state_id." and tbl_categories.organisation_id=".$org_id." and tbl_categories.center_id=".$center_id." and tbl_categories.status='Active' ";
       // echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;
    }


    public function all_income_user_records($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'student_payment_details.student_name',
            1 => 'student_payment_details.mobile_number'
           
        );
        $search_1 = array
        (
             1 => 'student_payment_details.student_name',
             2 => 'student_payment_details.mobile_number'
             
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('student_payment_details.id')
            ->where('student_payment_details.state_id',$pdata['state_id'])
            ->where('student_payment_details.organisation_id',$pdata['org_id'])
            ->where('student_payment_details.center_id',$pdata['center_id'])
            ->where('student_payment_details.payment_mode_id',$pdata['payment_mode_id'])
            ->where('year(tbl_student_payment_details.amount_paid_date)',$pdata['year'])
            ->where('month(tbl_student_payment_details.amount_paid_date)',$pdata['month_id'])
            ->where('student_payment_details.approval_status','Approved')
            ->from('student_payment_details')
            ->order_by('student_payment_details.id','asc')->get()->num_rows();
//echo $this->db->last_query();exit;
          //  return $this->db->select('id')->from($this->table)->order_by('category_name','asc')->get()->num_rows();
        }
        else
        {
           $this->db->select('student_payment_details.*')
            ->where('student_payment_details.state_id',$pdata['state_id'])
            ->where('student_payment_details.organisation_id',$pdata['org_id'])
            ->where('student_payment_details.center_id',$pdata['center_id'])
            ->where('student_payment_details.payment_mode_id',$pdata['payment_mode_id'])
            ->where('year(tbl_student_payment_details.amount_paid_date)',$pdata['year'])
            ->where('month(tbl_student_payment_details.amount_paid_date)',$pdata['month_id'])
            ->where('student_payment_details.approval_status','Approved')
            ->from('student_payment_details')
            ->order_by('student_payment_details.id','asc');
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


    public function all_expense_user_records($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'expenses.transcation_id',
           
           
        );
        $search_1 = array
        (
             1 => 'expenses.transcation_id',
            
             
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('expenses.id')
            ->where('expenses.state_id',$pdata['state_id'])
            ->where('expenses.organisation_id',$pdata['org_id'])
            ->where('expenses.center_id',$pdata['center_id'])
            ->where('expenses.category_id',$pdata['category_id'])
            ->where('year(tbl_expenses.amount_paid_date)',$pdata['year'])
            ->where('month(tbl_expenses.amount_paid_date)',$pdata['month_id'])
            ->where('expenses.approval_status','Approved')
            ->join('categories','categories.id=expenses.category_id')
            ->from('expenses')
            ->order_by('expenses.id','asc')->get()->num_rows();

          //  return $this->db->select('id')->from($this->table)->order_by('category_name','asc')->get()->num_rows();
        }
        else
        {
           $this->db->select('expenses.*,categories.category_name')
            ->where('expenses.state_id',$pdata['state_id'])
            ->where('expenses.organisation_id',$pdata['org_id'])
            ->where('expenses.center_id',$pdata['center_id'])
            ->where('expenses.category_id',$pdata['category_id'])
            ->where('year(tbl_expenses.amount_paid_date)',$pdata['year'])
            ->where('month(tbl_expenses.amount_paid_date)',$pdata['month_id'])
            ->where('expenses.approval_status','Approved')
            ->join('categories','categories.id=expenses.category_id')
            ->from('expenses')
            ->order_by('expenses.id','asc');
         // echo $this->db->last_query();exit;
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



}?>