<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department_model extends CI_Model {

    private $table='departments';
    public function __construct()
    {
     parent::__construct();
    
     $this->db = $this->load->database('default', TRUE);
     
    }

	public function update_record($data,$id){

		if($id !=''){
			$result=$this->db->update($this->table,$data,array('id'=>$id));

		}else{
			$result=$this->db->insert($this->table,$data);
            //echo $this->db->last_query();exit();
		}

		return $result;
	}


   public function all_records($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'state',
            1 => 'organisation_name',
            2 => 'center',
            3 => 'dept_name',
            
        );
        $search_1 = array
        (       
            1 => 'states.state',
            2 => 'organisations.organisation_name',
            3 => 'centers.center',
            4 => 'departments.dept_name',
             
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('departments.id')
            ->join('states','states.id=departments.state_id')
            ->join('organisations','organisations.id=departments.organisation_id')
            ->join('centers','centers.id=departments.center_id')
            ->from('departments')
            ->order_by('departments.id','asc')->get()->num_rows();
        }
        else
        {
        $this->db->select('departments.*,states.state,organisations.organisation_name,centers.center,departments.dept_name')
        ->join('states','states.id=departments.state_id','left')
        ->join('organisations','organisations.id=departments.organisation_id','left')
        ->join('centers','centers.id=departments.center_id','left')
        ->from('departments')
        ->order_by('departments.id','asc');

        //echo $this->db->last_query();exit();
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

}
?>