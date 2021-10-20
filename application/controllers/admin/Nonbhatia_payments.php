<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Nonbhatia_payments extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $list_Page = 'admin/paymentportal/list_nonbhatia_payment';
	public $add_Page =  'admin/paymentportal/add_nonbhatia_payment';	
	public $edit_Page = 'admin/paymentportal/edit_nonbhatia_payment';
	public $payment_pdf = 'admin/paymentportal/payment_nonbhatia_pdf';
	public $bulk_upload_income_page = 'admin/paymentportal/bulk_upload_income';
	public $print_page='admin/paymentportal/print_pdf';
	public $preview_print_page='admin/paymentportal/preview_print_pdf';
	
	public function __construct()
	{
	parent::__construct();
	$this->load->model('admin/Nonbhatia_payments_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	}
	public function index(){

		$this->setHeaderFooter($this->list_Page,$this->data);
	}


	public function print($id){

		$this->data['payment_data']=$this->common_model->get_table_row('student_payment_details',array('id'=>$id),array());
		$this->data['course']=$this->common_model->get_table_row('courses',array('id'=>$this->data['payment_data']['course_id']),array('course_name'));
		$this->data['batch']=$this->common_model->get_table_row('batchs',array('id'=>$this->data['payment_data']['batch_id']),array('batch_name'));
		$this->data['student_data']=array(
			'course_name'=>$this->data['course']['course_name'],
			'batch_name'=>$this->data['batch']['batch_name'],
									);
		$this->load->view($this->print_page,$this->data);


	}

	public function preview_print($id){
		$this->data['payment_data']=$this->common_model->get_table_row('student_payment_details',array('id'=>$id),array());
		$this->data['course']=$this->common_model->get_table_row('courses',array('id'=>$this->data['payment_data']['course_id']),array('course_name'));
		$this->data['batch']=$this->common_model->get_table_row('batchs',array('id'=>$this->data['payment_data']['batch_id']),array('batch_name'));
		$this->data['student_data']=array(
			'course_name'=>$this->data['course']['course_name'],
			'batch_name'=>$this->data['batch']['batch_name'],
									);

		$this->load->view($this->preview_print_page,$this->data);
	}
	

	public function add($param){

		$this->data['param']=$param;

		$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');

		$this->data['payments']=$this->common_model->get_table('payment_modes',array('status'=>'Active'),array(),'payment_mode','asc');
		$this->data['colleges']=$this->common_model->get_table('colleges',array('status'=>'Active'),array(),'college_name','asc');
		//$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');

		$user_id=$this->session->userdata('user_id');
		 if($user_id !='ADM0001'){
			$this->data['employee']=$this->common_model->get_table_row('users',array('user_id'=>$user_id),array());
			$state_id=$this->data['employee']['state_id'];
			$org_id=$this->data['employee']['organisation_id'];
			$center_id=$this->data['employee']['center_id'];
			$this->data['organisations']=$this->common_model->get_table('organisations',array('state_id'=>$state_id),array());
			$this->data['centers']=$this->common_model->get_table('centers',array('state_id'=>$state_id,'organisation_id'=>$org_id),array());
			$this->data['courses']=$this->common_model->get_table('courses',array('state_id'=>$state_id,'organisation_id'=>$org_id,'center_id'=>$center_id,'status'=>'Active'),array());
			$this->data['payment_modes']=$this->common_model->get_table('payment_modes',array('state_id'=>$state_id,'organisation_id'=>$org_id,'center_id'=>$center_id,'amount_type'=>'income'),array());
		 }else{
				$this->data['employee']=array();
				
			}

		$this->setHeaderFooter($this->add_Page,$this->data);
	}

	
	public function view(){

    	$this->setHeaderFooter($this->add_Page,$this->data);
	}

	public function all_records(){

        $center = $this->my_model->all_records($_POST);

        $result_count=$this->my_model->all_records($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($center) ),

            "data"  => $center);  

        echo json_encode($json_data);
	}

	public function update_record()
	{
		$id=$this->input->post('id');
		$param=$this->input->post('param');

		$attachment=$this->common_model->get_table_row('payment_modes',array('id'=> $this->input->post('payment_mode_id')),array('id,attachment_id'));

		$print_preview=$this->input->post('print_preview');
		$amount_paid_date= date('Y-m-d', strtotime($this->input->post('date')));

		

		$data=array(			
								'type'=>'nonbhatia',
								'state_id'=>$this->input->post('state_id'),
								'organisation_id'=>$this->input->post('organisation_id'),
								'center_id'=>$this->input->post('center_id'),
								'course_id'=>$this->input->post('course_id'),
								'batch_id'=>$this->input->post('batch_id'),
                                'receipt_id'=>getDynamicId('receipt_no','RECPT'),
                                'student_name'=>$this->input->post('student_name'),
                                'mobile_number'=>$this->input->post('mobile_number'),
                                'college_state_id' => $this->input->post('college_state_id'),
                                'college_id'=>$this->input->post('college_id'),
                                'payment_for'=>$this->input->post('payment_for'),
                                'payment_mode_id'=>$this->input->post('payment_mode_id'),
                                'grid'=>$this->input->post('grid'),
                                'attachment_id'=>$attachment['attachment_id'],
                                'transaction_id'=>$this->input->post('transcation_id'),
                                'total_fee'=>$this->input->post('amount_paid'),
                                'amount_paid'=>$this->input->post('amount_paid'),
                                'amount_paid_date'=>$amount_paid_date,
                                'remarks'=> $this->input->post('remarks'),
                               
                             );        
			//echo '<pre>';print_r($data);exit;
		if($id == "")
		{
			$data['created_on'] = date('Y-m-d H:i:s');
			$data['created_by'] = $this->session->userdata('user_id');
			//$data['final_settled'] = 'yes';


			//$check_student_payment=$this->common_model->get_table_row('student_payment_details',array('student_mobile'=> $this->input->post('mobile_number')),array('id,student_id,state_id,organisation_id,center_id,total_fee,discount_fee'),'id','asc');
			$student_mobile=$this->input->post('mobile_number');
			$batch_id=$this->input->post('batch_id');
			$check_student_payment=$this->db->query("select id,student_id,state_id,organisation_id,batch_id,center_id,total_fee,discount_fee from tbl_student_payment_details where mobile_number='".$student_mobile."' and  batch_id='".$batch_id."' order by id asc" )->row_array();
			//echo $this->db->last_query();exit;

			if(!empty($check_student_payment)){

				$student_id=$check_student_payment['student_id'];

				$this->data['till_now_paid_amt']=$this->db->query("select sum(amount_paid) as total_amt from tbl_student_payment_details where student_id=$student_id and batch_id='".$batch_id."' GROUP BY student_id" )->row_array();

				$till_now_paid_amt= $this->data['till_now_paid_amt']['total_amt'];
		 		$student_payment_total_fee= $check_student_payment['total_fee'];
		 		$paynig_amount=$this->input->post('amount_paid');

		 		$total_paying_amt=$till_now_paid_amt+$paynig_amount;

		 		if($total_paying_amt <= $student_payment_total_fee){
		 			if($total_paying_amt == $student_payment_total_fee){
		 				$data['final_settled'] = 'yes';
		 				$data['due_amount'] = 0;

		 			}else{
		 				$data['final_settled'] = 'no';
		 				$data['due_amount']=$student_payment_total_fee-$total_paying_amt;
		 			}
		 			$data['total_fee'] = $check_student_payment['total_fee'];
		 			
		 			$insert_id=$this->my_model->insert_record($data);
		 		}else{
			 $this->session->set_flashdata('error', 'Record added Failed Your Paying is crossed to total fee!.');
			 redirect('admin/nonbhatia_payments/add/agent_dashboard', 'refresh');	
			 	}

			}else{
				$data['final_settled'] = 'yes';
				$insert_id=$this->my_model->insert_record($data);
			}
			

			


			if($insert_id !=''){
			$send_sms=$this->input->post('send_sms');
			$payment_record=$this->common_model->get_table_row('student_payment_details',array('id'=>$insert_id),array());
		 	//echo '<pre>';print_r($payment_record);
		 	$this->save_pdf($payment_record['receipt_id'],$send_sms,'');
			$this->session->set_flashdata('success', 'Record added Successfully.');
					if($print_preview == 'yes'){
					redirect('admin/nonbhatia_payments/preview_print/'.$insert_id, 'refresh');		
					}else{
					redirect('admin/nonbhatia_payments', 'refresh');	
					}
			  }else{
					$this->session->set_flashdata('error', 'Record added Failed!.');
					 if($param == 'general_students'){
					 	redirect('admin/nonbhatia_payments/add/general_students', 'refresh');
					 }else{
					 	redirect('admin/nonbhatia_payments/add/agent_dashboard', 'refresh');
					 }
				
			  }	
		}else{
			
			$data['modified_on'] = date('Y-m-d H:i:s');
			$data['modified_by'] = $this->session->userdata('user_id');
			//echo '<pre>';print_r($data);exit;
			$pre_payment_record=$this->common_model->get_table_row('student_payment_details',array('id'=>$id),array());
			$previous_payment=$pre_payment_record['amount_paid'];
			$result1=$this->my_model->update_record($data, $id);
			if($result1){
			$send_sms='yes';
			$payment_record=$this->common_model->get_table_row('student_payment_details',array('id'=>$id),array());
		 	$this->save_pdf($payment_record['receipt_id'],$send_sms,$previous_payment);

			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			if($print_preview == 'yes'){
					redirect('admin/nonbhatia_payments/preview_print/'.$insert_id, 'refresh');		
					}else{
					redirect('admin/nonbhatia_payments/edit/'.$id, 'refresh');	
					}
			
			}else{
			$this->session->set_flashdata('success', 'Record Updated Failed!.');
			redirect('admin/nonbhatia_payments/edit/'.$id, 'refresh');
			}
		}		

	}

	public function edit($id){

		$this->data['record']=$this->my_model->get_record($id);

		 $state_id=$this->data['record']['state_id'];
		 $organisation_id=$this->data['record']['organisation_id'];
		 $center_id=$this->data['record']['center_id'];
		$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');
		$this->data['colleges']=$this->common_model->get_table('colleges',array('state_id'=>$this->data['record']['college_state_id'],'status'=>'Active'),array(),'college_name','asc');

		$this->data['organisations']=$this->common_model->get_table('organisations',array('state_id'=>$this->data['record']['state_id'],'status'=>'Active'),array(),'organisation_name','asc');

		$this->data['centers']=$this->common_model->get_table('centers',array('state_id'=>$this->data['record']['state_id'],'organisation_id'=>$this->data['record']['organisation_id'],'status'=>'Active'),array(),'center','asc');

		$this->data['payments']=$this->common_model->get_table('payment_modes',array('state_id'=>$this->data['record']['state_id'],'organisation_id'=>$this->data['record']['organisation_id'],'center_id'=>$this->data['record']['center_id'],'status'=>'Active'),array(),'payment_mode','asc');
		$this->data['courses']=$this->common_model->get_table('courses',array('state_id'=>$state_id,'organisation_id'=>$organisation_id,'center_id'=>$center_id,'course_type'=>'admin','status'=>'Active'),array(),'id','desc');
		$this->data['batchs']=$this->common_model->get_table('batchs',array('course_id'=>$this->data['record']['course_id'],'status'=>'Active'),array(),'batch_name','asc');
		$this->data['student_data']=$this->common_model->get_table_row('students',array('id'=>$this->data['record']['student_id']),array('room_no','cabin_no'));

		$this->setHeaderFooter($this->edit_Page,$this->data);
	}

	public function change_portal_status($payment_portal_id, $status)
	{
		if($this->my_model->change_portal_status($payment_portal_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/payment_portal', 'refresh');
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


    public function add_student_payment_details(){

        $insert_payment=array(
                                'receipt_id'=>getDynamicId('receipt_no','RECPT'),
                                'student_name'=>$this->input->post('student_name'),
                                'mobile_number'=>$this->input->post('mobile_number'),
								'state_id' => $this->input->post('state_id'),
                                'college_id'=>$this->input->post('college_id'),
                                'payment_for'=>$this->input->post('payment_for'),
                                'amount_paid'=>$this->input->post('amount_paid'),
                                'payment_mode_id' => $this->input->post('payment_mode_id'),
                                'remarks'=> $this->input->post('remarks'),
                                'created_on'=> date('Y-m-d H:i:s'),
                             );
       // echo '<pre>';print_r($insert_payment);
         $this->db->insert('student_payment_details',$insert_payment); 
         $insert_id=$this->db->insert_id();
        	if($insert_id !=''){      
        	 $send_sms='yes';
             $payment_record=$this->common_model->get_table_row('student_payment_details',array('id'=>$insert_id),array());
		 	//echo '<pre>';print_r($payment_record);
		 	$this->save_pdf($payment_record['receipt_id'],$send_sms,'');
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/payment_portal/add', 'refresh');		
			  }else{
			$this->session->set_flashdata('error', 'Record added Failed!.');
			redirect('admin/payment_portal/add', 'refresh');
			  }	

       
    }

    public function save_pdf($receipt_id,$send_sms,$previous_payment)
		 { 
		 	$path=''; $full_path='';

		 //load mPDF library
		 $this->load->library('M_pdf'); 
		 //now pass the data//
		 $data['payment_data'] =  $this->common_model->get_table_row('student_payment_details', array('receipt_id' => $receipt_id),array());
		 $data['course']=$this->common_model->get_table_row('courses',array('id'=>$data['payment_data']['course_id']),array('course_name'));
		 $data['batch']=$this->common_model->get_table_row('batchs',array('id'=>$data['payment_data']['batch_id']),array('batch_name'));
		 $data['student_data']=array(
			'course_name'=>$data['course']['course_name'],
			'batch_name'=>$data['batch']['batch_name'],
									);

		 $html=$this->load->view($this->payment_pdf,$data, true); //load the pdf.php by passing our data and get all data in $html varriable.
		 //echo $html;exit();
		 $pdfFilePath = $receipt_id.".pdf"; 
		 
		 $this->m_pdf->pdf->WriteHTML($html);

			//download it D save F.
		 $this->m_pdf->pdf->Output("./storage/paymentreceipts/".$pdfFilePath, "F");
		 $path= "storage/paymentreceipts/".$pdfFilePath;
		 $full_path=base_url().$path;

		 
		 $student_name= $data['payment_data']['student_name'];
		 $student_mobile= $data['payment_data']['mobile_number'];
		 $amount_paid=$data['payment_data']['amount_paid'];
		 $payment_made_for=$data['payment_data']['payment_for'];

		 $update_path=array('receipt_pdf_path' => $path);
		 $this->db->update('student_payment_details',$update_path,array('receipt_id' => $receipt_id));

		 if($previous_payment == ''){
		 $message="Dear ".$student_name.",your payment has been received successfully for INR ".$amount_paid.".00 by ISSM EDUCATIONAL SERVICES Pvt Limited click here to for invoice details https://hyderabadbhatia.com/storage/paymentreceipts/".$pdfFilePath." , Thank You -Bhatia";
		}else{
		 
		 $message="Dear ".$student_name.", we are here to inform a change in your receipt that the receipt was wrongly generated for INR ".$previous_payment.".00, but the payment done is INR ".$amount_paid.".00 we are sending the new updated receipt link https://hyderabadbhatia.com/storage/paymentreceipts/".$pdfFilePath.". Kindly call +919381915159 if there is any dispute in the issue,Thank You -Bhatia";
		// echo $message;exit;

		}
		  //echo $message;exit;
			if($send_sms == 'yes'){
		 		SendSMS($student_mobile,$message);
		 	}
		 }

		 public function bulk_upload_incomes(){

		 $this->setHeaderFooter($this->bulk_upload_income_page,$this->data);	
		 }

	public function filedownload(){
		$file = './assets/excel-files/incomeuploadreference.csv'; 
		if (file_exists($file)){
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}
	}

	public function import_bulkexcel(){

		if($_POST['submit'] !=''){
    
			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
			if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
							if(is_uploaded_file($_FILES['file']['tmp_name'])){
												
																
									$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
																
																
										fgetcsv($csvFile);
																
																
									while(($line = fgetcsv($csvFile)) !== FALSE){
																				//echo '<pre>';print_r($line);exit;
											 $stu_payment_id=$this->my_model->insertIncomes($line);	
											  if($stu_payment_id !=''){
									            $payment_record=$this->common_model->get_table_row('student_payment_details',array('id'=>$stu_payment_id),array());
									            //echo '<pre>';print_r($payment_record);
									            //$this->save_pdf($payment_record['receipt_id'],'no','');
									                  
									            }	
											}
																
																
											fclose($csvFile);

									$this->session->set_flashdata('success', 'Excel upload Sucessfully...');
									redirect(base_url('admin/nonbhatia_payments'));
											}else{
									$this->session->set_flashdata('error', 'Some problem occurred, please try again...');
								    redirect(base_url('admin/nonbhatia_payments'));
											}
						}else{
							$this->session->set_flashdata('error', 'Please upload a valid CSV file....');
							redirect(base_url('admin/nonbhatia_payments'));
						}
    
		}

	}

	public function receipt_view($payment_id){

	 $payment_record=$this->common_model->get_table_row('student_payment_details',array('id'=>$payment_id),array('receipt_id,receipt_pdf_path'));
	 //echo '<pre>';print_r($payment_record);exit;
	 if($payment_record['receipt_pdf_path'] == ''){	
	 $this->save_pdf($payment_record['receipt_id'],'no','');
	 //$receipt_pdf_path;
	 $payment_record=$this->common_model->get_table_row('student_payment_details',array('id'=>$payment_id),array('receipt_pdf_path'));
		}
	 $receipt_pdf_path=$payment_record['receipt_pdf_path'];
	 redirect(base_url().$receipt_pdf_path);
	}

	public function check_student_payment(){

		$mobile_number=$this->input->post('mobile_number');
		$batch_id=$this->input->post('batch_id');

		$payment_record=$this->common_model->get_table_row('student_payment_details',array('mobile_number'=>$mobile_number,'batch_id'=> $batch_id),array(),'id','asc');

		if(!empty($payment_record)){

			$stu_id=$payment_record['student_id'];

			$till_now_paid_amt=$this->db->query("select sum(amount_paid) as total_amt from tbl_student_payment_details where student_id=$stu_id GROUP BY student_id" )->row_array();

			$paying_fee=$payment_record['total_fee']-$till_now_paid_amt['total_amt'];

			$new_record=array(
				'total_fee'=>$payment_record['total_fee'],
				'paying_amount'=>$paying_fee,
				'student_name'=> $payment_record['student_name'],
				   );

			echo  json_encode($new_record);

		}else{
			echo 0;
		}



	}
	
	 
}


?>