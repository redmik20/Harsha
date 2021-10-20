<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Schedule_model extends CI_Model {

    private $table='schedule';
    public function __construct()
    {
     parent::__construct();
    
     $this->db = $this->load->database('default', TRUE);
     
    }

	public function update_record($data,$id){

		if($id !=''){
			$result=$this->db->update($this->table,$data,array('id'=>$id));

		}else{
			$this->db->insert($this->table,$data);
            $result=$this->db->insert_id();
            //echo $this->db->last_query();exit();
		}

		return $result;
	}


   public function all_records($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($pdata);exit; 
        $columns = array
        (
           // 0 => 'batch_name',
            0 => 'course_name',
            1 => 'state',
            2 => 'organisation_name',
            3 => 'center',
            4 => 'schedule_name',
            5 => 'start_date',
            
        );
        $search_1 = array
        (       
           // 1 => 'batchs.batch_name',
            1 => 'courses.course_name',
            2 => 'states.state',
            3 => 'organisations.organisation_name',
            4 => 'centers.center',
            5 => 'schedule.schedule_name',
            6 => 'schedule.start_date',
             
            
        ); 

        if( isset($pdata['search_text_1'])!=""  && ($pdata['search_text_1'] != '')  )
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }

        if(isset($pdata['date_from']) && ($pdata['date_from'] != '') )
        {
            $this->db->where('schedule.start_date >=', $pdata['date_from']);

        }
        if(isset($pdata['date_to']) && ($pdata['date_to'] != ''))
        {
            $this->db->where('schedule.end_date <=', $pdata['date_to']);
        }

       // $this->db->where('date BETWEEN "'. date('Y-m-d', strtotime($pdata['date_from'])). '" and "'. date('Y-m-d', strtotime($pdata['date_to'])).'"');

        if($getcount)
        {
            return $this->db->select('schedule.id')
            ->join('states','states.id=schedule.state_id')
            ->join('organisations','organisations.id=schedule.organisation_id')
            ->join('centers','centers.id=schedule.center_id')
            ->join('courses','courses.id=schedule.course_id')
            ->from('schedule')
            ->order_by('schedule.id','asc')->get()->num_rows();

            //echo $this->db->last_query();exit;
        }
        else
        {
        $this->db->select('schedule.*,courses.course_name,states.state,organisations.organisation_name,centers.center,schedule.schedule_name,schedule.start_date,schedule.start_time,schedule.end_date,schedule.end_time')
        ->join('states','states.id=schedule.state_id','left')
        ->join('organisations','organisations.id=schedule.organisation_id','left')
        ->join('centers','centers.id=schedule.center_id','left')
        ->join('courses','courses.id=schedule.course_id','left')
        ->from('schedule')
        ->order_by('schedule.id','asc');

       // echo $this->db->last_query();exit();
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
        //echo $this->db->last_query();exit;
        foreach($result as $key=>$values)
        {
            $result[$key]['sno'] = $generatesno++;           
           
        }
        return $result;
    }  

    public function get_record($id){
    	$this->db->select('*');
    	$this->db->where('id',$id);
    	$this->db->from($this->table);
    	$result=$this->db->get()->row_array();
    	return $result;
    }

    public function change_record_status($id, $status)
    {        
        $this->db->where('id', $id);
        $result=$this->db->update($this->table, array('status' => $status));
                    
        return $result;
    }

}?>