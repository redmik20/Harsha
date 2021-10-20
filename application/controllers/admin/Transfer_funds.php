<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Transfer_funds extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $transfer_Page='admin/transfer/transfer';
	public $otp_submit_Page='admin/transfer/otp_submit';
	public $list_Page='admin/transfer/transfer_funds_list';


	public function __construct()
	{
	parent::__construct();
	$this->load->model('admin/Transfer_funds_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	}

	public function transfer_funds_list(){

		 
		 $this->setHeaderFooter($this->list_Page,$this->data);
	}

	public function all_records(){

        $records = $this->my_model->all_records($_POST);

        $result_count=$this->my_model->all_records($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($records) ),

            "data"  => $records);  

        echo json_encode($json_data);
	}

	public function index(){

		 $this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');
		 $user_id=$this->session->userdata('user_id');
		 $user_type=$this->session->userdata('user_type');
		 if($user_type !='admin'){
			$this->data['employee']=$this->common_model->get_table_row('users',array('user_id'=>$user_id),array());
			$state_id=$this->data['employee']['state_id'];
			$org_id=$this->data['employee']['organisation_id'];
			$center_id=$this->data['employee']['center_id'];
			$this->data['organisations']=$this->common_model->get_table('organisations',array('state_id'=>$state_id),array());
			$this->data['centers']=$this->common_model->get_table('centers',array('state_id'=>$state_id,'organisation_id'=>$org_id),array());
			$this->data['categories']=$this->common_model->get_table('categories',array('state_id'=>$state_id,'organisation_id'=>$org_id,'center_id'=>$center_id),array());
			$this->data['payment_modes']=$this->common_model->get_table('payment_modes',array('state_id'=>$state_id,'organisation_id'=>$org_id,'center_id'=>$center_id,'amount_type'=>'income'),array());
		 }else{
				$this->data['employee']=array();
				$this->data['employee']['payment_mode_id']=0;
				$this->data['employee']['state_id']=0;
				$this->data['employee']['organisation_id']=0;
				$this->data['employee']['center_id']=0;
				
			}
		 $this->setHeaderFooter($this->transfer_Page,$this->data);
	}

	public function send_otp(){

		if($this->input->post('submit') != ''){

			$otp = mt_rand(100000, 999999);

           // $message='Hello,Please share this OTP '.$otp.' for transfer funds.Once the OTP is shared,you are responsible for the funds. Thank You.';
            $message='Hello,Please share this OTP '.$otp.' for transfer funds.Once the OTP is shared,you are responsible for the funds. Thank You -Bhatia';

            $payment_mode=$this->common_model->get_table_row('payment_modes',array('id'=> $this->input->post('to_payment_mode_id')),array());
            $attachment=$this->common_model->get_table_row('attachments',array('id'=>$payment_mode['attachment_id']),array());

            $mobile=$attachment['mobile_num'];
	    	$sms_result=SendSMS($mobile,$message);
			//echo ture;
			//$sms_result = 1;

			//echo $sms_result;exit;

	    	if($sms_result == 1){
			    $id=$this->my_model->update_record($otp);
			    if($id !=''){

						$this->session->set_flashdata('success', 'OTP Sent Successfully...');
						redirect('admin/transfer_funds/otp_form/'.$id, 'refresh');
						}else{
						$this->session->set_flashdata('error', 'OTP Sent,but record not inserted...');
			    		redirect('admin/transfer_funds', 'refresh');
						}
				}else{
				 $this->session->set_flashdata('error', 'OTP Sending Failed,Please try again!...');
				 redirect('admin/transfer_funds', 'refresh');	
				}
			
		}
	}

	public function otp_form($id){
		
		 $this->data['record']=$this->common_model->get_table_row('payment_modes',array('id'=>$id),array());
		 $db_otp=$this->data['record']['transfer_otp'];
		 if($this->input->post('submit') != ''){

			if($db_otp == $this->input->post('otp')){

				$to_payment_mode_id=$this->data['record']['to_transfer_id'];
				$from_payment_mode_id=$this->data['record']['id'];
				$amount=$this->data['record']['transfer_amount'];
				$transfer_date=$this->data['record']['transfer_date'];
				$result=$this->my_model->transfer_funds($from_payment_mode_id,$to_payment_mode_id,$amount,$transfer_date);
				if($result){
				$this->session->set_flashdata('success', 'Transfer funds Successfully...');
				redirect('admin/transfer_funds', 'refresh');
				 }

			}else{
				$this->session->set_flashdata('error', 'OTP verification Failed !');
				 redirect('admin/transfer_funds/otp_form/'.$id, 'refresh');	
			}

	    	
			
		 }
		 $this->setHeaderFooter($this->otp_submit_Page,$this->data);
		//echo $id;exit;
	}

	/*-----------start setting header and footer --------------*/

	public function setHeaderFooter($view, $data)
	{	

		$this->load->view($this->header_page, $data);
		$this->load->view($this->leftMenu, $data);
		$data['message']=$this->load->view('admin/includes/message',$data,TRUE);
		$this->load->view($view, $data);
		$this->load->view($this->footer_Page);
	}
  /*----------- stop setting header and footer --------------*/


}

?>