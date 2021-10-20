<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Courses_model extends CI_Model {

    private $table='courses';

    public function __construct()
    {
     parent::__construct();
    
     $this->db2 = $this->load->database('plato', TRUE);
     
    }

	public function update_record($data,$id){
		
			$result=$this->db->update($this->table,$data,array('id'=>$id));
            /*if($data['course_type'] == 'app'){
		    $up_data=array(
                            'name'=>$data['course_name'],
                            'bhatia_center_id'=> $data['center_id'],
                            'order'=> $data['order'],
                         );
             $this->db2->update('exams',$up_data,array('bhatia_row_id'=>$id));
            }*/

		return $result;
	}

    public function insert_record($data){

      $result=$this->db->insert($this->table,$data);

      $insert_id=$this->db->insert_id();
      /*if($data['course_type'] == 'app'){
      $insert_data=array(
                            'name'=>$data['course_name'],
                            'bhatia_center_id'=> $data['center_id'],
                            'bhatia_row_id'=>$insert_id,
                            'order'=> $data['order'],
                         );
      $this->db2->insert('exams',$insert_data);
        }*/

      return $insert_id;
    }


    public function all_records($pdata, $getcount=null)
    {
    	// $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
    	  //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'courses.course_name',
            1 => 'courses.course_type'
        );
        $search_1 = array
        (
             1 => 'courses.course_name',
             2 => 'courses.course_type',
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('courses.id')
            ->join('states','states.id=courses.state_id')
            ->join('organisations','organisations.id=courses.organisation_id')
            ->join('centers','centers.id=courses.center_id')
            ->from('courses')
            ->where('courses.course_type','admin')
            ->order_by('order','asc')->get()->num_rows();
        }
        else
        {
        $this->db->select('courses.*,states.state,organisations.organisation_name,centers.center')
        ->join('states','states.id=courses.state_id')
        ->join('organisations','organisations.id=courses.organisation_id')
        ->join('centers','centers.id=courses.center_id')
        ->from('courses')
        ->where('courses.course_type','admin')
        ->order_by('order','asc');
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

    public function download_courses(){

       $query="select cu.id as course_id,cu.course_name,s.id as state_id,s.state,org.organisation_name,org.id as organisation_id,c.id as center_id,c.center,cu.status as course_status,cu.created_on,cu.created_by from  tbl_courses cu inner join tbl_states s on s.id=cu.state_id inner join tbl_organisations org on org.id=cu.organisation_id inner join tbl_centers c on c.id=cu.center_id where cu.course_type='admin' order by cu.id asc ";
        //echo $query;exit;
       return $result= $this->db->query($query);
       
    }



}?>