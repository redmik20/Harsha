<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Available_funds_model extends CI_Model {


    public function get_attachment_groups_wise_amount(){

        $query="SELECT tbl_attachment_groups.id,tbl_attachment_groups.attachment_group_name FROM tbl_attachment_groups WHERE tbl_attachment_groups.status='Active' ";
        //echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;
    }


	public function get_attachment_wise_amount($id){

        $att_groups=$this->db->query("select attachment_ids from tbl_attachment_groups where id='".$id."' ")->row_array();
        $attachment_ids=explode(',',$att_groups['attachment_ids']);

        $attachment_idsClause = "'" . implode("','",$attachment_ids) . "'";

		$query="SELECT tbl_attachments.id,tbl_attachments.attachment_name,tbl_attachments.opening_balance,(select sum(amount_paid) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.attachment_id=tbl_attachments.id and tbl_student_payment_details.approval_status='Approved' and tbl_student_payment_details.amount_from='1') as total_amount,(select sum(amount) FROM `tbl_expenses` WHERE tbl_expenses.attachment_id=tbl_attachments.id and tbl_expenses.approval_status='Approved') as expense_amount FROM tbl_attachments WHERE tbl_attachments.id IN ($attachment_idsClause) AND tbl_attachments.status='Active' ";
		//echo $query;exit;
		$result=$this->db->query($query)->result_array();
        return $result;
	}

	public function get_attachment_income_amount($attachment_id){

		$query="select sum(amount_paid) as income_amount FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.attachment_id=".$attachment_id." and tbl_student_payment_details.approval_status='Approved' and tbl_student_payment_details.amount_from='1' ";
		$result=$this->db->query($query)->row_array();
		return $result;
	}

	public function get_attachment_expense_amount($attachment_id){

		$query="select sum(amount) as expense_amount FROM `tbl_expenses` WHERE tbl_expenses.attachment_id=".$attachment_id." and tbl_expenses.approval_status='Approved' ";
		$result=$this->db->query($query)->row_array();
		return $result;
	}
    public function get_attachment_from_tansfer_funds_amount($attachment_id){

        $query="select sum(transfer_amount) as transfer_amount from tbl_transfer_funds where from_attachment_id='$attachment_id'";
        $result=$this->db->query($query)->row_array();
        return $result;
    }
    public function get_attachment_to_tansfer_funds_amount($attachment_id){

        $query="select sum(transfer_amount) as transfer_amount from tbl_transfer_funds where to_attachment_id='$attachment_id'";
        $result=$this->db->query($query)->row_array();
        return $result;
    }
    public function get_attachment_opening_blac($attachment_id){
        $query="select * from tbl_attachments where id='$attachment_id'";
        $result=$this->db->query($query)->row_array();
        return $result;
    }

	public function get_income_payment_modes_amount($attachment_id){

		$query="select tbl_payment_modes.id,tbl_payment_modes.payment_mode,(select sum(amount_paid)  FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.attachment_id=".$attachment_id." and tbl_student_payment_details.payment_mode_id=tbl_payment_modes.id and tbl_student_payment_details.approval_status='Approved' and tbl_student_payment_details.amount_from='1') as total_amount from tbl_payment_modes WHERE tbl_payment_modes.attachment_id=".$attachment_id." and tbl_payment_modes.amount_type='income' and tbl_payment_modes.status='Active' ";
		$result=$this->db->query($query)->result_array();
		return $result;
	}

	public function get_expense_payment_modes_amount($attachment_id){

		$query="select tbl_payment_modes.id,tbl_payment_modes.payment_mode,(select sum(amount)  FROM `tbl_expenses` WHERE tbl_expenses.attachment_id=".$attachment_id." and tbl_expenses.payment_mode_id=tbl_payment_modes.id and tbl_expenses.approval_status='Approved' ) as total_amount from tbl_payment_modes WHERE tbl_payment_modes.attachment_id=".$attachment_id." and tbl_payment_modes.amount_type='expense' and tbl_payment_modes.status='Active'  ";
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
            ->where('student_payment_details.attachment_id',$pdata['attachment_id'])
            ->where('student_payment_details.payment_mode_id',$pdata['payment_mode_id'])
            ->where('student_payment_details.approval_status','Approved')
            ->where('student_payment_details.amount_from','1')
            ->from('student_payment_details')
            ->order_by('student_payment_details.id','asc')->get()->num_rows();

          //  return $this->db->select('id')->from($this->table)->order_by('category_name','asc')->get()->num_rows();
        }
        else
        {
           $this->db->select('student_payment_details.*')
            ->where('student_payment_details.attachment_id',$pdata['attachment_id'])
            ->where('student_payment_details.payment_mode_id',$pdata['payment_mode_id'])
            ->where('student_payment_details.approval_status','Approved') 
            ->where('student_payment_details.amount_from','1')         
            ->from('student_payment_details')
            ->order_by('student_payment_details.id','asc');
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


     public function all_expense_user_records($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'categories.category_name',
            1 => 'expenses.transcation_id',
           
           
        );
        $search_1 = array
        (   
             1 => 'categories.category_name',
             2 => 'expenses.transcation_id',
            
             
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('expenses.id')
            ->where('expenses.attachment_id',$pdata['attachment_id'])
            ->where('expenses.payment_mode_id',$pdata['payment_mode_id'])
            ->where('expenses.approval_status','Approved')
            ->join('categories','categories.id=expenses.category_id')
            ->from('expenses')
            ->order_by('expenses.id','asc')->get()->num_rows();

          //  return $this->db->select('id')->from($this->table)->order_by('category_name','asc')->get()->num_rows();
        }
        else
        {
           $this->db->select('expenses.*,categories.category_name')
            ->where('expenses.attachment_id',$pdata['attachment_id'])
            ->where('expenses.payment_mode_id',$pdata['payment_mode_id'])
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

}

?>