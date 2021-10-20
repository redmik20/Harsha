<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Batchs_model extends CI_Model {

    public function __construct()
    {
     parent::__construct();
    
     $this->db2 = $this->load->database('plato', TRUE);
     
    }

	public function update_batch($data,$batch_id){
		
		$result=$this->db->update('batchs',$data,array('id'=>$batch_id));

         $update_db2=array(
                            'bhatia_state_id'=> $data['state_id'],
                            'bhatia_organisation_id'=> $data['organisation_id'],
                            'bhatia_center_id'=> $data['center_id'],
                            'bhatia_course_id'=> $data['course_id'],
                            'bhatia_batch_id'=> $batch_id,
                            'name'=> $data['batch_name'],
                            'student_code'=> $data['student_code'],
                            'start_date'=> $data['start_date'],
                            'end_date'=> $data['end_date'],
                            'order'=> $data['order'],
                         );
		$this->db2->update('exams',$update_db2,array('bhatia_batch_id'=>$batch_id));
		return $result;
	}

    public function insert_batch($data){
        $this->db->insert('batchs',$data);
        $insert_id=$this->db->insert_id();

        $insert_db2=array(
                            'bhatia_state_id'=> $data['state_id'],
                            'bhatia_organisation_id'=> $data['organisation_id'],
                            'bhatia_center_id'=> $data['center_id'],
                            'bhatia_course_id'=> $data['course_id'],
                            'bhatia_batch_id'=> $insert_id,
                            'name'=> $data['batch_name'],
                            'student_code'=> $data['student_code'],
                            'start_date'=> $data['start_date'],
                            'end_date'=> $data['end_date'],
                            'order'=> $data['order'],
                         );
        $this->db2->insert('exams',$insert_db2);
        return $insert_id;
    }


    public function all_batchs($pdata, $getcount=null)
    {
    	// $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
    	  //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'batch_name',
            1 => 'course_name',
            2 => 'state',
            3 => 'organisation_name',
            4 => 'center',
        );
        $search_1 = array
        (
             1 => 'batchs.batch_name',
             2 => 'courses.course_name',
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
            return $this->db->select('batchs.id')
            ->join('states','states.id=batchs.state_id')
            ->join('organisations','organisations.id=batchs.organisation_id')
            ->join('centers','centers.id=batchs.center_id')
            ->join('courses','courses.id=batchs.course_id')
            ->from('batchs')
            ->order_by('batchs.order','asc')->get()->num_rows();
        }
        else
        {
        $this->db->select('batchs.*,courses.course_name,states.state,organisations.organisation_name,centers.center')
        ->join('states','states.id=batchs.state_id')
        ->join('organisations','organisations.id=batchs.organisation_id')
        ->join('centers','centers.id=batchs.center_id')
        ->join('courses','courses.id=batchs.course_id','left')
        ->from('batchs')
        ->order_by('batchs.order','asc');
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
    	$this->db->from('batchs');
    	$result=$this->db->get()->row_array();
    	return $result;
    }

    public function change_batch_status($user_id, $status)
    {        
        $this->db->where('id', $user_id);
        $result=$this->db->update('batchs', array('status' => $status));
                    
        return $result;
    }

    public function students_excel_info_with_batch($batch_id){
    $query=$this->db->query("SELECT tbl_states.state,tbl_organisations.organisation_name,tbl_centers.center,tbl_courses.course_name,tbl_batchs.batch_name,sum(amount_paid) as total_amt,tbl_students.* FROM tbl_students INNER JOIN tbl_states ON tbl_states.id=tbl_students.state_id INNER JOIN tbl_organisations ON tbl_organisations.id=tbl_students.organisation_id INNER JOIN tbl_centers ON tbl_centers.id=tbl_students.center_id
        INNER JOIN tbl_courses ON tbl_courses.id=tbl_students.course_id INNER JOIN tbl_batchs ON tbl_batchs.id=tbl_students.batch_id LEFT JOIN tbl_student_payment_details ON  tbl_student_payment_details.student_id=tbl_students.id where tbl_students.batch_id=".$batch_id." GROUP BY tbl_students.id");
        

        return $query;
    }

    public function download_batchs(){

       $query="SELECT b.id as batch_id,b.batch_name,b.student_code,cu.id as course_id,cu.course_name,s.id as state_id,s.state,org.organisation_name,org.id as organisation_id,c.id as center_id,c.center,b.status as batch_status,b.start_date,b.end_date,b.created_on,b.created_by from  tbl_batchs b inner join tbl_courses cu on cu.id=b.course_id inner join tbl_states s on s.id=b.state_id inner join tbl_organisations org on org.id=b.organisation_id inner join tbl_centers c on c.id=b.center_id order by b.id asc ";
        //echo $query;exit;
       return $result= $this->db->query($query);
       
    }


}?>