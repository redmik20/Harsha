<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paymentmode_model extends CI_Model {

    private $table='payment_modes';

    public function update_record($data,$id){
        if($id !=''){
            $result=$this->db->update($this->table,$data,array('id'=>$id));
        }else{
            $result=$this->db->insert($this->table,$data);
        }

        return $result;
    }

    public function insert_payment_modes($payment_mode){

         //echo '<pre>';print_r($payment_mode);
        foreach($payment_mode as $key=>$value)
        {
                $insert_array=array(

                                    'payment_mode'=>$value,
                                    'created_on'=>date('Y-m-d H:i:s'),
                                    'created_by'=> $this->session->userdata('user_id'),
                                    );
               // print_r($insert_array);
                $result= $this->db->insert('payment_modes',$insert_array);
                //echo $this->db->last_query();
        }
       // echo $this->db->last_query();exit;
       // exit();
        return true;
    }

    public function all_paymentmodes($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'payment_modes.payment_mode',
            1 => 'attachments.attachment_name',
            2 => 'centers.center',

        );
        $search_1 = array
        (
             1 => 'payment_modes.payment_mode',
             2 => 'attachments.attachment_name',
             3 => 'centers.center',
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
            return $this->db->select('payment_modes.id')
            ->join('states','states.id=payment_modes.state_id')
            ->join('organisations','organisations.id=payment_modes.organisation_id')
            ->join('centers','centers.id=payment_modes.center_id')
            ->join('attachments','attachments.id=payment_modes.attachment_id')
            ->from('payment_modes')
            ->order_by('payment_modes.id','desc')->get()->num_rows();
        }
        else
        {
            $this->db->select('payment_modes.*,states.state,organisations.organisation_name,centers.center,attachments.attachment_name')
            ->join('states','states.id=payment_modes.state_id')
            ->join('organisations','organisations.id=payment_modes.organisation_id')
            ->join('centers','centers.id=payment_modes.center_id')
            ->join('attachments','attachments.id=payment_modes.attachment_id')
            ->from('payment_modes')
            ->order_by('payment_modes.id','desc');
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
        $this->db->from('payment_modes');
        $result=$this->db->get()->row_array();
        return $result;
    }

    public function change_record_status($id, $status)
    {        
        $this->db->where('id', $id);
        $result=$this->db->update('payment_modes', array('status' => $status));
                    
        return $result;
    }

    public function download_payment_modes(){

       $query="SELECT pm.id as payment_mode_id,pm.amount_type,pm.payment_mode,s.state,s.id as state_id,org.organisation_name,org.id as organisation_id,c.center,c.id as center_id,a.id as attachment_id,a.attachment_name,pm.status as payment_mode_status,pm.created_on,pm.created_by 
            from tbl_payment_modes pm 
            inner join tbl_organisations org on org.id=pm.organisation_id 
            inner join tbl_states s on s.id=pm.state_id
            inner join tbl_centers c on c.id=pm.center_id
            inner join tbl_attachments a on a.id=pm.attachment_id
            order by pm.id asc";
        //echo $query;exit;
       return $result= $this->db->query($query);
       
    }
}?>