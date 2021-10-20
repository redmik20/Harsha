<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_approvals_model extends CI_Model {

  private $table='student_payment_details';





	public function all_records($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'student_payment_details.student_name',
            1 => 'student_payment_details.mobile_number',
            2 => 'student_payment_details.transaction_id',
            3 => 'states.state',
            4 => 'organisations.organisation_name',
            5 => 'centers.center',
           
        );
        $search_1 = array
        (
             1 => 'student_payment_details.student_name',
             2 => 'student_payment_details.mobile_number',
             3 => 'student_payment_details.transaction_id',
             4 => 'states.state',
             5 => 'organisations.organisation_name',
             6 => 'centers.center',
             
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('student_payment_details.id')
            ->join('payment_modes','payment_modes.id=student_payment_details.payment_mode_id','left')
            ->join('states','states.id=student_payment_details.state_id')
            ->join('organisations','organisations.id=student_payment_details.organisation_id')
            ->join('centers','centers.id=student_payment_details.center_id')
            ->join('users','users.user_id=student_payment_details.created_by')
            ->from('student_payment_details')
            ->where('student_payment_details.amount_from','1')
            ->where('student_payment_details.approval_status',$pdata['type'])
            ->order_by('student_payment_details.id','desc')->get()->num_rows();

          //  return $this->db->select('id')->from($this->table)->order_by('category_name','asc')->get()->num_rows();
        }
        else
        {
           $this->db->select('states.state,organisations.organisation_name,centers.center,student_payment_details.*,DATE_FORMAT(tbl_student_payment_details.amount_paid_date, "%d-%m-%Y") as amount_paid_date,payment_modes.payment_mode,users.user_name')
           ->join('states','states.id=student_payment_details.state_id')
            ->join('organisations','organisations.id=student_payment_details.organisation_id')
            ->join('centers','centers.id=student_payment_details.center_id')
             ->join('payment_modes','payment_modes.id=student_payment_details.payment_mode_id','left')
             ->join('users','users.user_id=student_payment_details.created_by')
             ->from('student_payment_details')
             ->where('student_payment_details.amount_from','1')
             ->where('student_payment_details.approval_status',$pdata['type'])
            ->order_by('student_payment_details.id','desc');
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

 public function change_status($id, $status)
    {        
        $this->db->where('id', $id);
        $result=$this->db->update($this->table, array('approval_status' => $status));
                  //echo  $this->db->last_query();exit;
        return $result;
    }

    public function delete_payment($id)
    {        
        
        $this->db->where('id', $id);
        $result=$this->db->delete($this->table);    
        return $result;
    }








}

	?>