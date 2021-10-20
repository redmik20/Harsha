<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Eventcreation_model extends CI_Model {

    private $table='events';

	public function update_record($data,$id){
		if($id !=''){
			$result=$this->db->update($this->table,$data,array('id'=>$id));
		}else{
			$result=$this->db->insert($this->table,$data);
           // echo '<pre>';print_r($this->db->last_query());exit; 
		}

		return $result;
	}

    public function getbatchnames($batch_ids){

       // echo '<pre>';print_r($batch_ids);exit;

        $this->db->select('GROUP_CONCAT(batch_name) as batch_names');
        $this->db->where_in('id',$batch_ids); 
        $this->db->from('batchs');
        $query=$this->db->get();
        //echo $this->db->last_query();exit;
        $result=$query->row_array();
        return $result['batch_names'];
    
    }

    public function all_records($pdata, $getcount=null)
    {
    	// $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
    	  //echo '<pre>';print_r($res);exit; 
        $columns = array
        (   
            0 => 'event_name',
            1 => 'course_name',
            2 => 'state',
            3 => 'organisation_name',
            4 => 'center',
        );
        $search_1 = array
        (
             1 => 'events.event_name',
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
           return $this->db->select('events.id')
            ->join('states','states.id=events.state_id')
            ->join('organisations','organisations.id=events.organisation_id')
            ->join('centers','centers.id=events.center_id')
            ->join('courses','courses.id=events.course_id')
            ->from('events')
            ->order_by('events.id','desc')->get()->num_rows();
        }
        else
        {
        $this->db->select('events.*,courses.course_name,states.state,organisations.organisation_name,centers.center')
        ->join('states','states.id=events.state_id')
        ->join('organisations','organisations.id=events.organisation_id')
        ->join('centers','centers.id=events.center_id')
        ->join('courses','courses.id=events.course_id','left')
        ->from('events')
        ->order_by('events.id','desc');
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

    public function getEventdata($event_unique_id){

        //$query="select e.*, from events e inner join states s on s.id=e.state_id inner join tbl_organastions "
        $this->db->select('events.*,courses.course_name,states.state,organisations.organisation_name,centers.center,GROUP_CONCAT(DISTINCT tbl_batchs.batch_name SEPARATOR ", ") as batch_names');
        $this->db->join('states','states.id=events.state_id');
        $this->db->join('organisations','organisations.id=events.organisation_id');;
        $this->db->join('centers','centers.id=events.center_id');
        $this->db->join('courses','courses.id=events.course_id','left');
        $this->db->join('tbl_batchs', 'FIND_IN_SET(tbl_batchs.id, tbl_events.batch_ids)', '', FALSE); 
        $this->db->where('event_unique_id',$event_unique_id); 
        $this->db->from('events');
        $this->db->group_by('events.id');
        $query=$this->db->get();
       // echo $this->db->last_query();
        $result=$query->row_array();

        return $result;
    }

    public function get_instock_data($post_data){

        $this->db->select('*');
        $this->db->where('state_id',$post_data['state_id']); 
        $this->db->where('organisation_id',$post_data['organisation_id']); 
        $this->db->where('center_id',$post_data['center_id']); 
        $this->db->where('course_id',$post_data['course_id']); 
        
        //$this->db->where_in('batch_id',$post_data['batch_id']); 
        //$this->db->group_start();
        foreach($post_data['batch_id'] as $value)
        {
            $this->db->or_where("find_in_set($value, batch_id)");
            //$where .="find_in_set($value, batch_id)"
        }
       // $this->db->group_end();

        $this->db->from('stockdepartment');
        $query=$this->db->get();
      // echo $this->db->last_query();exit;
        $result=$query->result_array();
        return $result;
    }

}?>