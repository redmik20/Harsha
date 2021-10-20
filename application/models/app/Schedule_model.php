<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Schedule_model extends CI_Model{

  
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
  	//echo $query;exit;
  	$student_data=$this->db->query($query)->row_array();
  	$student_id=$student_data['id'];

  	$this->db->select('*');
	$this->db->from('student_payment_details');
	$this->db->where('student_id',$student_id);
	$this->db->order_by('id','desc');
	$payment_row=$this->db->get()->row_array();
	//echo $this->db->last_query();exit;
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

	 return $result;

	}

	public function checkEventDateValidation($event_id){
	$this->db->select('*');
	$this->db->from('events');
	$this->db->where('event_unique_id',$event_id);
	$event=$this->db->get()->row_array();

		$end_date=$event['end_date'];
	  	$today=date('Y-m-d');
	  	$end_date1 = strtotime($end_date);
	  	$today1 = strtotime($today);
	  
		// Compare the timestamp date 
		if ($end_date1 >= $today1){
		    $result="valid";
		    //echo "valid";exit;
		  }else{
		  	$result="expired";
		  	//echo "expired";exit;
		  }
		return $result;
	}

	public function add_attendence($student_id,$event_id){

		$query="select id,student_dynamic_id,batch_id,valid_from,valid_to from tbl_students where student_dynamic_id='".$student_id."' ";
	  	//echo $query;exit;
	  	$student_data=$this->db->query($query)->row_array();
		$this->db->select('id,event_unique_id,event_name,state_id,organisation_id,center_id,course_id,batch_ids,stock_included,in_stock_count');
		$this->db->from('events');
		$this->db->where('event_unique_id',$event_id);
		$event_data=$this->db->get()->row_array();

		$event_name=$event_data['event_name'];
		$scaned_date=date('Y-m-d');
		$scaned_time=date('H:i:s');
		if($event_data['stock_included'] == 'no'){
		$message="Thanks for attending the ".$event_name." held on ".$scaned_date." at ".$scaned_time."";
			}else{
		$message="Thanks for collecting materials on ".$scaned_date." at ".$scaned_time."";
		$stock_included=(int)$event_data['in_stock_count'];
		$cal_stock=$stock_included-1;
		$update_event_data=array(
									'in_stock_count'=> $cal_stock
								);
		$this->db->update('events',$update_event_data,array('id'=>$event_data['id']));
			}

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
								'created_on'=>date('Y-m-d H:i:s')
							);
		$result=$this->db->insert('event_attendence',$insert_array);
		return $result;
	}

	public function check_attendence($student_id,$event_id){
		$scaned_date=date('Y-m-d');
		$this->db->select('id');
		$this->db->from('event_attendence');
		$this->db->where('student_dy_id',$student_id);
		$this->db->where('event_dy_id',$event_id);
		$this->db->where('scaned_date',$scaned_date);
		$result=$this->db->get()->row_array();
		return $result;
	}

	public function get_monthly_attendence($student_id){

		$query="select ea.id,ea.message,ea.scaned_date,MONTHNAME(ea.scaned_date) as month,e.event_name from tbl_event_attendence ea INNER JOIN tbl_events e on e.id=ea.event_id where ea.student_dy_id='".$student_id."' order by ea.scaned_date ASC";
		//echo $query;exit;
		$result=$this->db->query($query)->result_array();
		//echo '<pre>';print_r($result);exit;
		return $result;
	}

	public function get_student_event_list($student_id){

		$this->db->select('id,batch_id');
		$this->db->where('student_dynamic_id',$student_id);
		$this->db->from('students');
		$query=$this->db->get();
		$result=$query->row_array();
		$student_batch_id=$result['batch_id'];

		$this->db->select('events.id,events.event_unique_id,events.batch_ids,events.event_name,events.start_date,events.end_date,events.qrcode_path');
		$this->db->from('events');
		//$this->db->where_in('batch_ids',$student_batch_id);
		//$this->db->join('batchs', 'batchs.id = events.batch_ids', 'LEFT OUTER');
		$this->db->where('find_in_set("'.$student_batch_id.'", tbl_events.batch_ids) <> 0');
		$this->db->where('events.start_date <=',date('Y-m-d'));
		$this->db->where('events.end_date >=',date('Y-m-d'));
		$this->db->where('events.status','Active');
		$query=$this->db->get();
		//echo $this->db->last_query();exit;
		$result=$query->result_array();
		$scaned_date=date('Y-m-d');//$new_result=array();
		foreach ($result as $key => $value) {
			$batchs=array();
			$batchs_ids=explode(',',$value['batch_ids']);

			foreach($batchs_ids as $b_id){
				$batch_data=$this->common_model->get_table_row('batchs',array('id'=>$b_id),array('id,batch_name'));
				$batchs[]=$batch_data['batch_name'];
			}
			

			$attendance_status=array();
			$new_result[$key]=$value;
			$new_result[$key]['batchs']=$batchs;
			$attendance_status=$this->common_model->get_table_row('event_attendence',array('student_dy_id'=>$student_id,'scaned_date'=>$scaned_date,'event_dy_id'=>$value['event_unique_id']),array('id,event_dy_id'));
			if(!empty($attendance_status)){
			$new_result[$key]['attendance_status']= true;
			$new_result[$key]['attendance_info']=$value['event_unique_id'].'##'.$value['event_name'].'##'.$value['start_date'].'##'.$value['end_date'];
				}else{
					$new_result[$key]['attendance_status']= false;
					$new_result[$key]['attendance_info']='';
				}
			}
 		
 		return $new_result;
		 //echo '<pre>';print_r($result);exit;
	}

	public function get_student_schedule_list($student_id){

		$this->db->select('id,batch_id');
		$this->db->where('student_dynamic_id',$student_id);
		$this->db->from('students');
		$query=$this->db->get();
		$result=$query->row_array();
		$student_batch_id=$result['batch_id'];

		$this->db->select('id,batch_ids,schedule_name,start_date,end_date');
		$this->db->from('schedule');
		//$this->db->where_in('batch_ids',$student_batch_id);
		//$this->db->join('batchs', 'batchs.id = events.batch_ids', 'LEFT OUTER');
		$this->db->where('find_in_set("'.$student_batch_id.'",batch_ids) <> 0');
		$this->db->where('start_date <=',date('Y-m-d'));
		$this->db->where('end_date >=',date('Y-m-d'));
		$this->db->where('status','Active');
		$query=$this->db->get();
		//echo $this->db->last_query();exit;
		$result=$query->result_array();
		//$new_result=array();
		foreach ($result as $key => $value) {
			$batchs=array();
			$batchs_ids=explode(',',$value['batch_ids']);
			//$months=$this->getMonthsInRange($value['start_date'],'2022-05-05');
			//echo '<pre>';print_r($value['start_date']);
			//echo '<pre>';print_r($value['end_date']);
			//echo '<pre>';print_r($months);exit;
			foreach($batchs_ids as $b_id){
				$batch_data=$this->common_model->get_table_row('batchs',array('id'=>$b_id),array('id,batch_name'));
				$batchs[]=$batch_data['batch_name'];
			}
			

			
			$new_result[$key]=$value;
			$new_result[$key]['batchs']=$batchs;
			
			}
 		
 		return $new_result;
		 //echo '<pre>';print_r($result);exit;
	}

	public function current_month_schedule($student_id){

		$this->db->select('id,batch_id');
		$this->db->where('student_dynamic_id',$student_id);
		$this->db->from('students');
		$query=$this->db->get();
		$result=$query->row_array();
		$student_batch_id=$result['batch_id'];

		$this->db->select('id,batch_ids,schedule_name,start_date,end_date');
		$this->db->from('schedule');
		//$this->db->where_in('batch_ids',$student_batch_id);
		//$this->db->join('batchs', 'batchs.id = events.batch_ids', 'LEFT OUTER');
		$this->db->where('find_in_set("'.$student_batch_id.'",batch_ids) <> 0');
		//$this->db->where('start_date >=',date('Y-m-d'));
		$this->db->where('end_date >=',date('Y-m-d'));
		$this->db->where('status','Active');
		$query=$this->db->get();
		//echo $this->db->last_query();exit;
		$result=$query->result_array();
		//$new_result=array();
		foreach ($result as $key => $value) {
			$batchs=array();
			$batchs_ids=explode(',',$value['batch_ids']);

			foreach($batchs_ids as $b_id){
				$batch_data=$this->common_model->get_table_row('batchs',array('id'=>$b_id),array('id,batch_name'));
				$batchs[]=$batch_data['batch_name'];
			}
			
			$new_result[$key]=$value;
			$new_result[$key]['batchs']=$batchs;

			$a_date = date('Y-m-d');
			$month_last_date=date("Y-m-t", strtotime($a_date));
				if(strtotime($value['end_date']) > strtotime($month_last_date)){
					$new_result[$key]['end_date']= date("d-m-Y",strtotime($month_last_date));
				}else{
					$new_result[$key]['end_date']= date("d-m-Y",strtotime($new_result[$key]['end_date']));
				}
				$new_result[$key]['start_date']= date("d-m-Y",strtotime($new_result[$key]['start_date']));
				
			}

 		//$new_result[$key]['current_month']=date('');
 		return $new_result;
		 //echo '<pre>';print_r($result);exit;
	}


	function echoDate( $start, $end ){

            $current = $start;
            $ret = array();

            while( $current<$end ){
                
                $next = date('Y-M-01', $current) . "+1 month";
                $current = strtotime($next);
                $ret[] = $current;
            }

            return array_reverse($ret);
        }

        function getMonthsInRange($startDate, $endDate) {
$months = array();
while (strtotime($startDate) <= strtotime($endDate)) {
    $months[] = array('year' => date('Y', strtotime($startDate)), 'month' => date('m', strtotime($startDate)), );
    $startDate = date('01 M Y', strtotime($startDate.
        '+ 1 month')); // Set date to 1 so that new month is returned as the month changes.
}

return $months;
}


}

?>