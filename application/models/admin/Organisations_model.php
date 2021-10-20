<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Organisations_model extends CI_Model {

    private $table='organisations';

	public function update_organisation($data,$id){
		if($id !=''){
			$result=$this->db->update($this->table,$data,array('id'=>$id));
		}else{
			$result=$this->db->insert($this->table,$data);
		}

		return $result;
	}


    public function all_organisation($pdata, $getcount=null)
    {
    	// $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
    	  //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'organisations.organisation_name'
        );
        $search_1 = array
        (
             1 => 'organisations.organisation_name',
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('organisations.id')->join('states','states.id=organisations.state_id')->from($this->table)->order_by('organisations.organisation_name','asc')->get()->num_rows();
        }
        else
        {
        $this->db->select('organisations.*,states.state')->join('states','states.id=organisations.state_id')->from($this->table)->order_by('organisations.organisation_name','asc');
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

    public function change_organisation_status($id, $status)
    {        
        $this->db->where('id', $id);
        $result=$this->db->update($this->table, array('status' => $status));
                    
        return $result;
    }

    public function download_organisations(){

       $query="select org.id as organisation_id,s.state,s.id as state_id,org.organisation_name,org.status,org.created_on,org.created_by from tbl_organisations org inner join tbl_states s on s.id=org.state_id order by org.id asc";
        //echo $query;exit;
       return $result= $this->db->query($query);
       
    }


}?>