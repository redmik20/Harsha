<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expenses_model extends CI_Model {

    private $table='expenses';

    public function update_record($data,$id){
        if($id !=''){
            $result=$this->db->update($this->table,$data,array('id'=>$id));
        }else{
            $this->db->insert($this->table,$data);
           // echo $this->db->last_query();exit;
            $result=$this->db->insert_id();
        }

        return $result;
    }

    public function expense_states_wise_count(){

        $query='select s.id,s.state,(select sum(amount) from tbl_expenses te where te.state_id=s.id) as total_amount from tbl_states s where s.status="Active" ';
        //echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;
    }

     public function expense_organisations_count($state_id){
        $query="select tbl_organisations.id,tbl_organisations.organisation_name,(select sum(amount) from tbl_expenses where tbl_expenses.state_id=".$state_id." and tbl_expenses.organisation_id=tbl_organisations.id) as total_amount from tbl_organisations where tbl_organisations.status='Active' and tbl_organisations.state_id=".$state_id." ";
        //echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;
    }

    public function expense_centers_count($state_id,$org_id){
        $query="select tbl_centers.id,tbl_centers.center,(select sum(amount) from tbl_expenses where tbl_expenses.state_id=".$state_id." and tbl_expenses.organisation_id=".$org_id." and tbl_expenses.center_id=tbl_centers.id) as total_amount from tbl_centers where  tbl_centers.state_id=".$state_id." and tbl_centers.organisation_id=".$org_id." and tbl_centers.status='Active'";
        //echo $query;exit;
        $result=$this->db->query($query)->result_array();
        return $result;
    }


    public function all_records($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'states.state',
            1 => 'organisations.organisation_name',
            2 => 'centers.center',
            3 => 'categories.category_name'
        );
        $search_1 = array
        (
            1 => 'states.state',
            2 => 'organisations.organisation_name',
            3 => 'centers.center',
            4 => 'categories.category_name'
            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
           
            $this->db->select('expenses.id');
            $this->db->join('states','states.id=expenses.state_id','inner');
            $this->db->join('organisations','organisations.id=expenses.organisation_id','inner');
            $this->db->join('centers','centers.id=expenses.center_id','inner');
            $this->db->join('categories','categories.id=expenses.category_id','inner');
            $this->db->join('payment_modes','payment_modes.id=expenses.payment_mode_id','left');
            $this->db->join('users','users.user_id=expenses.created_by');
            /*if($pdata['state_id'] !=''){
            $this->db->where('expenses.state_id',$pdata['state_id']);
                }
            if($pdata['org_id'] !=''){
            $this->db->where('expenses.organisation_id',$pdata['org_id']);
                }
            if($pdata['center_id'] !=''){
            $this->db->where('expenses.center_id',$pdata['center_id']);
                }*/
            if($this->session->userdata('user_type') != 'admin'){
                $this->db->where('expenses.created_by',$this->session->userdata('user_id'));
            }
            $this->db->from('expenses');
            return $this->db->order_by('expenses.id','desc')->get()->num_rows();
        }
        else
        {
        
        $this->db->select('expenses.*,states.state,organisations.organisation_name,centers.center,categories.category_name,payment_modes.payment_mode,DATE_FORMAT(tbl_expenses.amount_paid_date, "%d-%m-%Y") as amount_paid_date,users.user_name');
            $this->db->join('states','states.id=expenses.state_id','inner');
            $this->db->join('organisations','organisations.id=expenses.organisation_id','inner');
            $this->db->join('centers','centers.id=expenses.center_id','inner');
            $this->db->join('categories','categories.id=expenses.category_id','inner');
            $this->db->join('payment_modes','payment_modes.id=expenses.payment_mode_id','left');
            $this->db->join('users','users.user_id=expenses.created_by');
            /*if($pdata['state_id'] !=''){
            $this->db->where('expenses.state_id',$pdata['state_id']);
                }
            if($pdata['org_id'] !=''){
            $this->db->where('expenses.organisation_id',$pdata['org_id']);
                }
            if($pdata['center_id'] !=''){
            $this->db->where('expenses.center_id',$pdata['center_id']);
                }*/
            if($this->session->userdata('user_type') != 'admin'){
                $this->db->where('expenses.created_by',$this->session->userdata('user_id'));
            }
            $this->db->from('expenses');
            $this->db->order_by('expenses.id','desc');
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

    public function change_status($id, $status)
    {        
        $this->db->where('id', $id);
        $result=$this->db->update($this->table, array('approval_status' => $status));
                  //echo  $this->db->last_query();exit;
        return $result;
    }
  
   public function insertExpenses($data){


        if($data[0] != ''){
        $state_id= $data[0];
        }else{
        $state_id= '';  
        }

        if($data[1] != ''){
        $organisation_id= $data[2];
        }else{
        $organisation_id= '';    
        }

        if($data[2] != ''){
        $center_id= $data[2];
        }else{
        $center_id= ''; 
        }

        if($data[3] != ''){
        $category_id= $data[3];
        }else{
        $category_id= ''; 
        }

        if($data[4] != ''){
        $date= date("Y-m-d", strtotime($data[4]));
        }else{
        $date= ''; 
        }

        if($data[5] != ''){
        $paid_for= $data[5];
        }else{
        $paid_for= ''; 
        }

        if($data[6] != ''){
        $paid_to= $data[6];
        }else{
        $paid_to= ''; 
        }

        if($data[7] != ''){
        $amount= $data[7];
        }else{
        $amount= ''; 
        }

        if($data[8] != ''){
        $payment_mode_id= $data[8];
        }else{
        $payment_mode_id= ''; 
        }

        if($data[9] != ''){
        $transaction_id= $data[9];
        }else{
        $transaction_id= ''; 
        }

        if($data[10] != ''){
        $image_path= $data[10];
        }else{
        $image_path= ''; 
        }

        if($data[11] != ''){
        $remarks= $data[11];
        }else{
        $remarks= ''; 
        }

        if( ($state_id !='') && ($organisation_id !='') && ($center_id !='') && ($payment_mode_id !='') && ($transaction_id !='')){
        $payment_mode=$this->common_model->get_table_row('payment_modes',array('id'=> $payment_mode_id),array('id','attachment_id'));
        $attachment_id=$payment_mode['attachment_id'];
        $payment_data=array(
                                
                                'state_id'=>$state_id,
                                'organisation_id'=>$organisation_id,
                                'center_id'=>$center_id,
                                'category_id'=>$category_id,
                                'date'=>$date,
                                'paid_for'=>$paid_for,
                                'paid_to'=>$paid_to,
                                'payment_mode_id'=>$payment_mode_id,
                                'attachment_id'=>$attachment_id,
                                'transcation_id'=>$transaction_id,
                                'image_type'=> '1',
                                'attachment'=>$image_path,
                                'amount'=> $amount,
                                'amount_paid_date'=>$date,
                                'approval_status'=>'Pending',
                                'remarks'=> $remarks,
                                'created_by'=>$this->session->userdata('user_id'),
                                'created_on'=>date('Y-m-d H:i:s')
                            );
        //echo '<pre>';print_r($payment_data);exit;
         $result=$this->common_model->insert_table('expenses',$payment_data);
        }
        
        return $result;
     

   }

   public function delete_payment($id)
    {        
        
        $this->db->where('id', $id);
        $result=$this->db->delete('expenses');    
        return $result;
    }


}?>