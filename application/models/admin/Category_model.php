<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model {

    private $table='categories';

    public function update_record($data,$id){
        if($id !=''){
            $result=$this->db->update($this->table,$data,array('id'=>$id));
        }else{
            $result=$this->db->insert($this->table,$data);
        }

        return $result;
    }


    public function all_records($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'categories.category_name',
            1 => 'centers.center'
           
        );
        $search_1 = array
        (
             1 => 'categories.category_name',
             2 => 'centers.center'
             
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('categories.id')
            ->join('states','states.id=categories.state_id','inner')
            ->join('organisations','organisations.id=categories.organisation_id','inner')
            ->join('centers','centers.id=categories.center_id','inner')
            ->from('categories')
            ->order_by('categories.id','asc')->get()->num_rows();

          //  return $this->db->select('id')->from($this->table)->order_by('category_name','asc')->get()->num_rows();
        }
        else
        {
           $this->db->select('categories.*,states.state,organisations.organisation_name,centers.center')
            ->join('states','states.id=categories.state_id','inner')
            ->join('organisations','organisations.id=categories.organisation_id','inner')
            ->join('centers','centers.id=categories.center_id','inner')
            ->from('categories')
            ->order_by('categories.id','asc');
       // $this->db->select('*')->from($this->table)->order_by('category_name','asc');
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
   
   public function download_categories(){

    $query="SELECT s.state,s.id as state_id,org.organisation_name,org.id as organisation_id, c.id as center_id,c.center,ct.id as category_id,ct.category_name,ct.status,ct.created_on,ct.created_by 
        from tbl_categories ct 
        inner join tbl_organisations org on org.id=ct.organisation_id 
        inner join tbl_states s on s.id=ct.state_id 
        inner join tbl_centers c on c.id=ct.center_id 
        order by ct.id asc";
        //echo $query;exit;
       return $result= $this->db->query($query);

   }


}?>