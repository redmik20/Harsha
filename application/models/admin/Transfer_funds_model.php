<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfer_funds_model extends CI_Model {

    
    public function update_record($otp){

    	$up_record=array(
									'transfer_otp'=>$otp,
									'to_transfer_id'=> $this->input->post('to_payment_mode_id'),
									'transfer_amount'=> $this->input->post('amount'),
                                    'transfer_date'=> $this->input->post('transfer_date'),
									'modified_on'=> date('Y-m-d H:i:s'),

									
						);
    	$where=array(
									
									'id'=> $this->input->post('from_payment_mode_id'), 
									
								);
    	$result=$this->db->update('payment_modes',$up_record,array('id'=>$this->input->post('from_payment_mode_id')));
    	//echo $this->db->last_query();exit;
    	return $this->input->post('from_payment_mode_id');
    }

    public function transfer_funds($from_payment_mode_id,$to_payment_mode_id,$amount,$transfer_date){

    	 $from_payment_mode_data=$this->common_model->get_table_row('payment_modes',array('id'=>$from_payment_mode_id),array());
    	 $to_payment_mode_data=$this->common_model->get_table_row('payment_modes',array('id'=>$to_payment_mode_id),array());

    	 $from_attachment_data=$this->common_model->get_table_row('attachments',array('id'=>$from_payment_mode_data['attachment_id']),array());
    	 $to_attachment_data=$this->common_model->get_table_row('attachments',array('id'=>$to_payment_mode_data['attachment_id']),array());

    	
    	 $income_insert=array(	
    	 						'type'=>'nonbhatia',
    	 						'amount_type'=> 'income',
    	 						'amount_from'=> '2',
    	 						'state_id'=>$to_payment_mode_data['state_id'],
								'organisation_id'=>$to_payment_mode_data['organisation_id'],
								'center_id'=>$to_payment_mode_data['center_id'],
                                'receipt_id'=>getDynamicId('receipt_no','RECPT'),
    	 						'student_name'=> $from_payment_mode_data['payment_mode'],
    	 						'mobile_number'=> $from_attachment_data['mobile_num'],
    	 						'payment_mode_id'=>$to_payment_mode_id,
                                'attachment_id'=>$to_payment_mode_data['attachment_id'],
                                'amount_paid'=>$amount,
                                'approval_status'=>'Approved',
                                'transfer_type'=>'From',
                                'transaction_id'=>$from_payment_mode_data['transfer_otp'],
                                'amount_paid_date' => $transfer_date,
								'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->session->userdata('user_id'),
    	 					 );
    	 $this->db->insert('student_payment_details',$income_insert);
    	 $insert_id=$this->db->insert_id();
    	 $payment_record=$this->common_model->get_table_row('student_payment_details',array('id'=>$insert_id),array());
		 	//echo '<pre>';print_r($payment_record);
		 $this->common_model->save_pdf($payment_record['receipt_id'],'');
		 //$ex_amt= -$amount;
		 $expense_insert=array(	
    	 						'type'=>'nonbhatia',
    	 						'amount_type'=> 'expense',
    	 						'amount_from'=> '2',
    	 						'state_id'=>$from_payment_mode_data['state_id'],
								'organisation_id'=>$from_payment_mode_data['organisation_id'],
								'center_id'=>$from_payment_mode_data['center_id'],
                                'receipt_id'=>getDynamicId('receipt_no','RECPT'),
    	 						'student_name'=> $to_payment_mode_data['payment_mode'],
    	 						'mobile_number'=> $to_attachment_data['mobile_num'],
    	 						'payment_mode_id'=>$from_payment_mode_id,
                                'attachment_id'=>$from_payment_mode_data['attachment_id'],
                                'amount_paid'=> -$amount,
                                'approval_status'=>'Approved',
                                'transfer_type'=>'To',
                                'transaction_id'=>$from_payment_mode_data['transfer_otp'],
                                'amount_paid_date' => $transfer_date,
								'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->session->userdata('user_id'),
    	 					 );
		 //echo '<pre>';print_r($expense_insert);
    	$result= $this->db->insert('student_payment_details',$expense_insert);
    	//echo $this->db->last_query();exit;


            $transfer_funds=array(  
                                    'state_id'=>$to_payment_mode_data['state_id'],
                                    'organisation_id'=>$to_payment_mode_data['organisation_id'],
                                    'center_id'=>$to_payment_mode_data['center_id'],
                                    'transaction_id'=> $from_payment_mode_data['transfer_otp'],
                                    'from_payment_mode_id'=> $from_payment_mode_id,
                                    'to_payment_mode_id'=>$to_payment_mode_id,
                                    'from_payment_mode'=> $from_payment_mode_data['payment_mode'],
                                    'to_payment_mode'=> $to_payment_mode_data['payment_mode'],

                                    'from_attachment_id'=> $from_payment_mode_data['attachment_id'],
                                    'to_attachment_id'=> $to_payment_mode_data['attachment_id'],
                                    'from_attachment_mobile'=> $from_attachment_data['mobile_num'],
                                    'to_attachment_mobile'=>$to_attachment_data['mobile_num'],
                                    'transfer_amount' => $amount,
                                    'transfer_date' => $transfer_date,
                                    'created_on' => date('Y-m-d H:i:s'),
                                    'created_by' => $this->session->userdata('user_id'),
                                 );
            $result= $this->db->insert('transfer_funds',$transfer_funds);

    	return $result;
    }

    public function all_records($pdata, $getcount=null)
    {
        // $res=$this->db->select('*')->from('batchs')->order_by('id','desc')->get()->result_array();
          //echo '<pre>';print_r($res);exit; 
        $columns = array
        (
            0 => 'transfer_funds.transaction_id',
            


        );
        $search_1 = array
        (
             1 => 'transfer_funds.transaction_id',
            

            
        );        
        if(isset($pdata['search_text_1'])!="")
        {
            $this->db->like($search_1[$pdata['search_on_1']], $pdata['search_text_1'], $pdata['search_at_1'] );
        }
        if($getcount)
        {
           $this->db->select('transfer_funds.id');
           $this->db->from('transfer_funds');
            
            $this->db->join('states','states.id=transfer_funds.state_id');
            $this->db->join('organisations','organisations.id=transfer_funds.organisation_id');
            $this->db->join('centers','centers.id=transfer_funds.center_id');
           
            if($this->session->userdata('user_id') != 'ADM0001'){
            $this->db->where('transfer_funds.created_by',$this->session->userdata('user_id'));
        		}
            return $this->db->order_by('transfer_funds.transfer_date','desc')->get()->num_rows();

           // echo $this->db->last_query();exit;
        }
        else
        {
        $this->db->select('states.state,organisations.organisation_name,centers.center,transfer_funds.*');
        $this->db->from('transfer_funds');
        $this->db->join('states','states.id=transfer_funds.state_id');
        $this->db->join('organisations','organisations.id=transfer_funds.organisation_id');
        $this->db->join('centers','centers.id=transfer_funds.center_id');
        
        
        if($this->session->userdata('user_id') != 'ADM0001'){
        $this->db->where('transfer_funds.created_by',$this->session->userdata('user_id'));
    		}
        $this->db->order_by('transfer_funds.transfer_date','desc');
        //echo $this->db->last_query();exit;
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


}
?>