

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Paymentportal_model extends CI_Model {

    private $table='payment_portal';

    public function update_record($data,$id){
        if($id !=''){
            $result=$this->db->update($this->table,$data,array('id'=>$id));
        }else{
            $result=$this->db->insert($this->table,$data);
        }

        return $result;
    }

    public function search_student_name($student_name){
       $this->db->select('id')->from('students')->where("student_name LIKE '%$student_name%'");
       $query=$this->db->get();
       echo $this->db->last_query();exit;
       $result=$query->row_array();
       return $result;
    }

    public function all_search_students_list($pdata, $getcount=null)
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
            if($pdata['search_on'] == 1){
                $student_mobile=$pdata['search_value'];
                //$this->db->where('students.student_mobile',$pdata['search_value']);
                $where = '(tbl_students.student_mobile="'.$student_mobile.'" or tbl_students.student_alt_mobile = "'.$student_mobile.'")';
                $this->db->where($where);
            }
             if($pdata['search_on'] == 2){
                $student_name=$pdata['search_value'];
                $this->db->where("students.student_name LIKE '%$student_name%'");
            }
            if($pdata['search_on'] == 3){
                $student_dy_id=$pdata['search_value'];
                $this->db->where("students.student_dynamic_id LIKE '%$student_dy_id%'");
           }
            
            return $this->db->order_by('students.id','asc')->get()->num_rows();
        }
        else
        {
        $this->db->select('students.*,courses.course_name,batchs.batch_name');
        $this->db->from('students');
        $this->db->join('courses','courses.id=students.course_id','left');
        $this->db->join('batchs','batchs.id=students.batch_id','left');
        if($pdata['search_on'] == 1){
               $student_mobile=$pdata['search_value'];
                //$this->db->where('students.student_mobile',$pdata['search_value']);
                $where = '(tbl_students.student_mobile="'.$student_mobile.'" or tbl_students.student_alt_mobile = "'.$student_mobile.'")';
                $this->db->where($where);
            }
             if($pdata['search_on'] == 2){
                $student_name=$pdata['search_value'];
                $this->db->where("students.student_name LIKE '%$student_name%'");
            }

        if($pdata['search_on'] == 3){
                $student_dy_id=$pdata['search_value'];
                $this->db->where("students.student_dynamic_id LIKE '%$student_dy_id%'");
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

    public function all_portals($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'mobile_number'

        );
        $search_1 = array
        (
             1 => 'mobile_number',
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('payment_portal.id')->from('payment_portal')->join('payment_modes','payment_modes.id=payment_portal.payment_modes_id')->order_by('payment_portal.student_name','asc')->get()->num_rows();
        }
        else
        {
        $this->db->select('payment_portal.*,payment_modes.course_name')->from('payment_portal')->join('payment_modes','payment_modes.id=payment_portal.payment_modes_id')->order_by('payment_portal.student_name','asc');
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

    

}?>