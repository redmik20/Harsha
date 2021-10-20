<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Centers_model extends CI_Model {

    private $table='centers';

	public function update_record($data,$id){
		if($id !=''){
			$result=$this->db->update($this->table,$data,array('id'=>$id));
		}else{
			$result=$this->db->insert($this->table,$data);
		}

		return $result;
	}


    public function all_centers($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'state',
            1 => 'center',
            2 => 'organisation_name'
        );
        $search_1 = array
        (
             1 => 'states.state',
             2 => 'centers.center',
             3 => 'organisations.organisation_name',
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('centers.id')->from('centers')->join('states','states.id=centers.state_id')->join('organisations','organisations.id=centers.organisation_id')->order_by('centers.center','asc')->get()->num_rows();
        }
        else
        {
        $this->db->select('states.state,centers.*,organisations.organisation_name')->from('centers')->join('states','states.id=centers.state_id')->join('organisations','organisations.id=centers.organisation_id')->order_by('centers.center','asc');
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

    public function change_center_status($id, $status)
    {        
        $this->db->where('id', $id);
        $result=$this->db->update($this->table, array('status' => $status));                    
        return $result;
    }

    public function download_centers(){

       $query="select c.id as center_id,s.state,s.id as state_id,org.organisation_name,org.id as organisation_id,c.center,c.status,c.created_on,c.created_by from tbl_centers c inner join tbl_organisations org on org.id=c.organisation_id inner join tbl_states s on s.id=c.state_id order by c.id asc";
        //echo $query;exit;
       return $result= $this->db->query($query);
       
    }

}?>