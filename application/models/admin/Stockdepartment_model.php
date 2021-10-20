<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Stockdepartment_model extends CI_Model {

    private $table='stockdepartment';
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
            0 => 'batch_name',
            1 => 'course_name',
            2 => 'state',
            3 => 'organisation_name',
            4 => 'center',
            5 => 'stock_name',
            6 => 'count',
            
        );
        $search_1 = array
        (       
            1 => 'batchs.batch_name',
            2 => 'courses.course_name',
            3 => 'states.state',
            4 => 'organisations.organisation_name',
            5 => 'centers.center',
            6 => 'stockdepartment.stock_name',
            7 => 'stockdepartment.count',
             
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('stockdepartment.id')
            ->join('states','states.id=stockdepartment.state_id')
            ->join('organisations','organisations.id=stockdepartment.organisation_id')
            ->join('centers','centers.id=stockdepartment.center_id')
            ->join('courses','courses.id=stockdepartment.course_id')
            ->join('batchs','batchs.id=stockdepartment.batch_id')
            ->from('stockdepartment')
            ->order_by('stockdepartment.id','asc')->get()->num_rows();
        }
        else
        {
        $this->db->select('stockdepartment.*,courses.course_name,states.state,organisations.organisation_name,centers.center,batchs.batch_name')
        ->join('states','states.id=stockdepartment.state_id','left')
        ->join('organisations','organisations.id=stockdepartment.organisation_id','left')
        ->join('centers','centers.id=stockdepartment.center_id','left')
        ->join('courses','courses.id=stockdepartment.course_id','left')
        ->join('batchs','batchs.id=stockdepartment.batch_id','left')
        ->from('stockdepartment')
        ->order_by('stockdepartment.id','asc');

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

}?>