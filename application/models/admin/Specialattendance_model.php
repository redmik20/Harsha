<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Specialattendance_model extends CI_Model {

    private $table='event_attendence';
	
    public function all_records($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'students.student_mobile',
            1 => 'students.student_dynamic_id',
            2 => 'event_attendence.event_dy_id',
            
        );
        $search_1 = array
        (
             1 => 'students.student_mobile',
             2 => 'students.student_dynamic_id',
             3 => 'event_attendence.event_dy_id',
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('event_attendence.id')->from('event_attendence')
            ->join('students','students.student_dynamic_id=event_attendence.student_dy_id')
            ->join('centers','centers.id=event_attendence.center_id')
            ->where('event_attendence.capture_status','2')
            ->order_by('event_attendence.id','desc')->get()->num_rows();
        }
        else
        {
        $this->db->select('students.student_mobile,students.student_dynamic_id,students.student_name,event_attendence.*,DATE_FORMAT(tbl_event_attendence.scaned_date,"%d-%m-%Y") as scaned_date,centers.center')->from('event_attendence')
        ->join('students','students.student_dynamic_id=event_attendence.student_dy_id')
        ->join('centers','centers.id=event_attendence.center_id')
        ->where('event_attendence.capture_status','2')
        ->order_by('event_attendence.id','desc');
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

    public function checkBatchValidation($student_id,$event_id){

    $query="select batch_id from tbl_students where student_dynamic_id='".$student_id."' ";
    //echo $query;exit;
    $student_data=$this->db->query($query)->row_array();
    $batch_id=$student_data['batch_id'];

        $where = "FIND_IN_SET('".$batch_id."', batch_ids)"; 
        $this->db->select('id');
        $this->db->from('events');
        $this->db->where($where);
        $this->db->where('event_unique_id',$event_id);
        $result=$this->db->get()->row_array();
        //echo $this->db->last_query();exit;
        return $result;

   }

   public function checkBatchTimeValidation($student_id){

    $query="select batch_id,valid_from,valid_to from tbl_students where student_dynamic_id='".$student_id."' ";
    //echo $query;exit;
    $student_data=$this->db->query($query)->row_array();

    $valid_to=$student_data['valid_to'];
    $today=date('Y-m-d');
    $valid_to1 = strtotime($valid_to);
    $today1 = strtotime($today);
  
    // Compare the timestamp date 
    if ($valid_to1 >= $today1){
        $result="valid";
      }else{
        $result="expired";
      }
      return $result;
  }

  public function checkDueamountAndDate($student_dy_id){

    $query="select id,batch_id,valid_from,valid_to from tbl_students where student_dynamic_id='".$student_dy_id."' ";
   // echo $query;
    $student_data=$this->db->query($query)->row_array();
    $student_id=$student_data['id'];

    $this->db->select('*');
    $this->db->from('student_payment_details');
    $this->db->where('student_id',$student_id);
    $this->db->order_by('id','desc');
    $payment_row=$this->db->get()->row_array();
    //echo $this->db->last_query();exit;
    if(!empty($payment_row)){
        if($payment_row['due_amount'] == 0){
            $result="feedone";
            //echo "feedone";exit;
         }else{
            $due_date=$payment_row['due_date'];
            $today=date('Y-m-d');
            $due_date1 = strtotime($due_date);
            $today1 = strtotime($today);
          
            // Compare the timestamp date 
            if ($due_date1 >= $today1){
                $result="feedone";
                //echo "feedone";exit;
              }else{
                $result="duedateexpired";
                //echo "duedateexpired";exit;
              }

         }
    }else{
        $result="duedateexpired";
    }

     return $result;

    }

    public function check_attendence($student_id,$event_id){
        $scaned_date=date('Y-m-d');
        $this->db->select('*');
        $this->db->from('event_attendence');
        $this->db->where('student_dy_id',$student_id);
        $this->db->where('event_dy_id',$event_id);
        $this->db->where('scaned_date',$scaned_date);
        $result=$this->db->get()->row_array();
        return $result;
    }

    public function add_attendence($student_id,$event_id,$reason){

        $query="select id,student_dynamic_id,batch_id,valid_from,valid_to from tbl_students where student_dynamic_id='".$student_id."' ";
        //echo $query;exit;
        $student_data=$this->db->query($query)->row_array();
        $this->db->select('id,event_unique_id,event_name,state_id,organisation_id,center_id,course_id,batch_ids');
        $this->db->from('events');
        $this->db->where('event_unique_id',$event_id);
        $event_data=$this->db->get()->row_array();

        $event_name=$event_data['event_name'];
        $scaned_date=date('Y-m-d');
        $scaned_time=date('H:i:s');
        $message="Thanks for attending the ".$event_name." held on ".$scaned_date." at ".$scaned_time."";

        $insert_array=array(
                                'state_id'=>$event_data['state_id'],
                                'organisation_id'=>$event_data['organisation_id'],
                                'center_id'=>$event_data['center_id'],
                                'course_id'=>$event_data['course_id'],
                                'student_batch_id'=>$student_data['batch_id'],
                                'event_batch_ids'=>$event_data['batch_ids'],

                                'student_id'=>$student_data['id'],
                                'event_id'=>$event_data['id'],
                                'student_dy_id'=>$student_data['student_dynamic_id'],
                                'event_dy_id'=>$event_data['event_unique_id'],
                                'event_name'=>$event_name,
                                'scaned_status'=>'completed',
                                'scaned_date'=>$scaned_date,
                                'scaned_time'=>$scaned_time,
                                'message'=>$message,
                                'reason'=>$reason,
                                'capture_status'=>'2',
                                'created_on'=>date('Y-m-d H:i:s')
                            );
        $result=$this->db->insert('event_attendence',$insert_array);
        return $result;
    }
    
}?>