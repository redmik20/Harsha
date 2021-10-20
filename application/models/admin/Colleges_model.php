<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Colleges_model extends CI_Model {

    private $table='colleges';

	public function update_record($data,$id){
		if($id !=''){
			$result=$this->db->update($this->table,$data,array('id'=>$id));
		}else{
			$result=$this->db->insert($this->table,$data);
		}

		return $result;
	}


    public function all_colleges($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'state',
            1 => 'college_name'
        );
        $search_1 = array
        (
             1 => 'states.state',
             2 => 'colleges.college_name',
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('colleges.id')->from('colleges')->join('states','states.id=colleges.state_id')->order_by('colleges.college_name','asc')->get()->num_rows();
        }
        else
        {
        $this->db->select('states.state,colleges.*')->from('colleges')->join('states','states.id=colleges.state_id')->order_by('colleges.college_name','asc');
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

    public function change_college_status($id, $status)
    {        
        $this->db->where('id', $id);
        $result=$this->db->update($this->table, array('status' => $status));                    
        return $result;
    }

    public function download_colleges(){
        $query="SELECT cg.id as college_id,cg.college_name,s.state,s.id as state_id,cg.status as college_status,cg.created_on,cg.created_by 
            from tbl_colleges cg 
            inner join tbl_states s on s.id=cg.state_id
            order by cg.id asc";
        //echo $query;exit;
       return $result= $this->db->query($query);
    }

}?>