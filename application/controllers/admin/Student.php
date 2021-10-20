<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Student extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $list_Page = 'admin/student/list_student';
	public $add_Page = 'admin/student/add_student';
	public $student_payment_details = 'admin/student/add_student_payment_details';
	public $view_student = 'admin/student/student_details';
	public $edit_Page = 'admin/student/edit_student';
	public $student_payments_list='admin/student/list_student_payments';
	public $edit_student_payment_details='admin/student/edit_student_payment_details';
	public $payment_pdf = 'admin/student/payment_pdf';

	public $states_list_Page = 'admin/student/list_states';
	public $organisations_list_Page ='admin/student/list_organisations';
	public $centers_list_Page ='admin/student/list_centers';
	public $student_paymentlink_Page ='admin/student/student_payment_link';
	public $student_paymentlink_step1_Page= 'admin/student/student_payment_step1';
	public $student_paymentlink_step2_Page= 'admin/student/student_payment_step2';
	public $student_paymentlink_step2_tc_Page='admin/student/student_payment_step2_tc';
	//public $adm_step2_continiue_after_sms_send_Page

	public function __construct()
	{
	parent::__construct();
	
	$this->load->model('admin/Student_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }

	 error_reporting(0);
	 
	}

	public function student_paymentlink(){

		$this->setHeaderFooter($this->student_paymentlink_Page,$this->data);
	}

	public function admission_link_step1(){

		$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array());

		$this->setHeaderFooter($this->student_paymentlink_step1_Page,$this->data);
	}

	public function admission_link_step2(){


		$student_mobile=$this->input->post('student_mobile');

		$check_student=$this->common_model->get_table_row('students',array('student_mobile'=>$student_mobile),array());
		
		if(!empty($check_student)){
			$this->session->set_flashdata('error', 'Student Already Exists !..');
		    redirect('admin/student/admission_link_step1');
		}

		$check_sending_link=$this->my_model->student_adm_sent_or_not($student_mobile);

		if(!empty($check_sending_link)){
			$this->session->set_flashdata('error', 'Admission Link already sent !..');
		    redirect('admin/student/admission_link_step1');
		}

		$insert_id=$this->my_model->insert_setp1_data($this->input->post());

		$message="Dear Doctor,Welcome to DBMCI,Please click the link below to complete the admission from and formalities Thank You. link:https://hyderabadbhatia.com/admin/student_adm/admission_link_step2_continue/".$insert_id.", Thank You -Bhatia";

		SendSMS($student_mobile,$message);

		$this->session->set_flashdata('success', 'Admission Link sent to Student Successfully..');
		redirect('admin/student/admission_link_step1');
		
	}

	public function adm_step2_continiue_after_sms_send($insert_id){

		//$this->load->view($this->adm_step2_continiue_after_sms_send_Page,$this->data);
	}

	public function admission_link_step2_continue($id){
		
		$this->load->view($this->student_paymentlink_step2_Page,$this->data);
	}

	public function admission_link_step2_tc($id){
		
		$this->load->view($this->student_paymentlink_step2_tc_Page,$this->data);
	}



	public function states(){
		 $this->data['states']=$this->my_model->student_states_wise_count();
		 //echo '<pre>';print_r($this->data['states']);exit;
		 $this->setHeaderFooter($this->states_list_Page,$this->data);
	}

	public function list_org($state_id){
		$this->data['state_id']=$state_id;
		$this->data['organisations']=$this->my_model->student_organisations_count($state_id);
		// echo '<pre>';print_r($this->data['organisations']);exit;
		$this->setHeaderFooter($this->organisations_list_Page,$this->data);
	}

	public function list_centers($state_id,$org_id){
		$this->data['state_id']=$state_id;
		$this->data['org_id']=$org_id;
		$this->data['centers']=$this->my_model->student_centers_count($state_id,$org_id);
		//echo '<pre>';print_r($this->data['centers']);exit;
		$this->setHeaderFooter($this->centers_list_Page,$this->data);
	}

	public function students_list($state_id,$org_id,$center_id){
		$this->data['state_id']=$state_id;
		$this->data['org_id']=$org_id;
		$this->data['center_id']=$center_id;
		$this->data['state']=$this->common_model->get_table_row('states',array('id'=>$state_id),array());
		$this->data['organisation']=$this->common_model->get_table_row('organisations',array('id'=>$org_id),array());
		$this->data['center']=$this->common_model->get_table_row('centers',array('id'=>$center_id),array());	
		$this->setHeaderFooter($this->list_Page,$this->data);
	}

	public function all_students(){

        $records = $this->my_model->all_students($_POST);

        $result_count=$this->my_model->all_students($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($records) ),

            "data"  => $records);  

        echo json_encode($json_data);
	}

	public function add(){
		$this->data['courses']=$this->common_model->get_table('courses',array('status'=>'Active'),array(),'order','asc');
		$this->data['centers']=$this->common_model->get_table('centers',array('status'=>'Active'),array(),'center','asc');
		$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');

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
		if($this->input->post('submit') != ''){

			$user_exists=$this->common_model->get_table_row('students',array('student_mobile'=>$this->input->post('mobile_no'),'batch_id'=>$this->input->post('batch_id')),array());
			if(!empty($user_exists)){
				$this->session->set_flashdata('error', 'User Already Exists in this Batch.');
			    redirect('admin/student/add', 'refresh');
			}

			if($_FILES['image']['name'] != ''){
				$config['upload_path'] = './storage/studentpics'; 
				$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
				$config['max_size']  = '0';
				$config['max_width']  = '0';
				$config['max_height']  = '0';
				
				$this->load->library('upload', $config);
				
				if(!$this->upload->do_upload('image'))
				{
					$data['msg'] = $this->upload->display_errors();
					//echo '<pre>';print_r($data['msg']);exit;
					$this->session->set_flashdata('error', $data['msg']);
			        redirect('admin/student/add', 'refresh');	
				}
				else
				{
					$data = $this->upload->data();
					$uploadedImages['image'] = $data['file_name'];
					
					$profile_image = $uploadedImages['image'];
					$profile_image1 = 'storage/studentpics/'.$uploadedImages['image'];
					//$config_image = array();
					$config_image = array(
					  'image_library' => 'gd2',
					  'source_image' => './storage/studentpics'.$profile_image,
					  'new_image' => './storage/studentpics'.$profile_image,
					  'width' => 297,
					  'height' => 302,
					  'maintain_ratio' => FALSE,
					  'rotate_by_exif' => TRUE,
					  'strip_exif' => TRUE,
					);					
					$this->load->library('image_lib', $config_image);
					$this->image_lib->resize();
					$this->image_lib->clear();
				 }
			}else{
			  $profile_image1='';
			}
			$batch=$this->common_model->get_table_row('batchs',array('id'=> $this->input->post('batch_id')),array('student_code'));
			if($batch['student_code'] != ''){
				$stuent_code=$batch['student_code'];
			}else{
				$stuent_code='STDN';
			}
			
			$student_dynamic_id=getDynamicId('student_no',$stuent_code);
			/*$this->load->library('ciqrcode');
	        $params['data'] = $student_dynamic_id;
	        $params['level'] = 'H';
	        $params['size'] = 10;
	        $params['savename'] = FCPATH.'storage/qrcodes/'.$student_dynamic_id.'.png';
	        $this->ciqrcode->generate($params);
			//echo '123';exit;
			$qrcode_path='storage/qrcodes/'.$student_dynamic_id.'.png';*/
			$qrcode_path='';
			$insert_id=$this->my_model->add_student($profile_image1,$student_dynamic_id,$qrcode_path);
			if($insert_id){

			$student=$this->common_model->get_table_row('students',array('id'=> $insert_id),array('student_dynamic_id','student_mobile'));
			$student_mobile=$student['student_mobile'];
			$student_id=$student['student_dynamic_id'];
			$message=$this->my_model->getStudentRegisterMessage($student_mobile);
			SendSMS($student_mobile,$message);

			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/student/add_payment_details/'.$insert_id, 'refresh');

			
			  }else{
			$this->session->set_flashdata('error', 'Record added Failed!.');
			redirect('admin/student/add', 'refresh');	
			  }	

		}
		$this->setHeaderFooter($this->add_Page,$this->data);
	}

	public function edit($id){
		$this->data['record']=$this->my_model->get_record($id);
		 $state_id=$this->data['record']['state_id'];
		 $organisation_id=$this->data['record']['organisation_id'];
		 $center_id=$this->data['record']['center_id'];
		
		$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');
		$this->data['batchs']=$this->common_model->get_table('batchs',array('course_id'=>$this->data['record']['course_id'],'status'=>'Active'),array(),'batch_name','asc');
		$this->data['colleges']=$this->common_model->get_table('colleges',array('state_id'=>$this->data['record']['mbbs_state'],'status'=>'Active'),array(),'college_name','asc');
		$this->data['organisations']=$this->common_model->get_table('organisations',array('state_id'=>$this->data['record']['state_id'],'status'=>'Active'),array(),'organisation_name','asc');
		$this->data['centers']=$this->common_model->get_table('centers',array('state_id'=>$this->data['record']['state_id'],'organisation_id'=>$this->data['record']['organisation_id'],'status'=>'Active'),array(),'center','asc');

		$this->data['courses']=$this->common_model->get_table('courses',array('state_id'=>$state_id,'organisation_id'=>$organisation_id,'center_id'=>$center_id,'course_type'=>'admin','status'=>'Active'),array(),'id','desc');

		if($this->input->post('submit') != ''){

			if($_FILES['image']['name'] != ''){
				$config['upload_path'] = './storage/studentpics'; 
				$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
				$config['max_size']  = '0';
				$config['max_width']  = '0';
				$config['max_height']  = '0';
				
				$this->load->library('upload', $config);
				
				if(!$this->upload->do_upload('image'))
				{
					$data['msg'] = $this->upload->display_errors();
					//echo '<pre>';print_r($data['msg']);exit;
					$this->session->set_flashdata('error', $data['msg']);
			        redirect('admin/student/edit/'.$id, 'refresh');	
				}
				else
				{
					$data = $this->upload->data();
					$uploadedImages['image'] = $data['file_name'];
					
					$profile_image = $uploadedImages['image'];
					$profile_image1 = 'storage/studentpics/'.$uploadedImages['image'];
					//$config_image = array();
					$config_image = array(
					  'image_library' => 'gd2',
					  'source_image' => './storage/studentpics'.$profile_image,
					  'new_image' => './storage/studentpics'.$profile_image,
					  'width' => 297,
					  'height' => 302,
					  'maintain_ratio' => FALSE,
					  'rotate_by_exif' => TRUE,
					  'strip_exif' => TRUE,
					);					
					$this->load->library('image_lib', $config_image);
					$this->image_lib->resize();
					$this->image_lib->clear();
				 }
				$res=$this->common_model->get_table_row('students',array('id'=>$id),array('image'));
				$file = $res['image'];
				if(is_file($file))
				unlink($file);
					
			}else{
			  $profile_image1=$this->data['record']['image'];
			}

		 	$result=$this->my_model->update_student($id,$profile_image1);
		 	if($result){
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/student/edit/'.$id, 'refresh');		
			  }else{
			$this->session->set_flashdata('error', 'Record Updated Failed!.');
			redirect('admin/student/edit/'.$id, 'refresh');	
			  }	

		 }
		 $this->setHeaderFooter($this->edit_Page,$this->data);
	}

	public function add_payment_details($id){
		
		 $this->data['record']=$this->my_model->get_record($id);

		
         $student=$this->common_model->get_table_row('students',array('id'=> $id),array('id,state_id,organisation_id,center_id'));

		 $this->data['payment_modes']=$this->common_model->get_table('payment_modes',array('amount_type'=>'income','state_id'=>$student['state_id'],'organisation_id'=>$student['organisation_id'],'center_id'=>$student['center_id'],'status'=> 'Active'),array(),'payment_mode','asc');

		 $check_student_payment=$this->common_model->get_table_row('student_payment_details',array('student_id'=> $id),array('id,state_id,organisation_id,center_id,total_fee,discount_fee'),'id','asc');

			 

		
			 $this->data['till_now_paid_amt']=$this->my_model->student_till_now_paid_amt($id); 

			 //echo '<pre>';print_r($check_student_payment_dis);exit;
			 if(!empty($check_student_payment)){
			 	  $this->data['student_payment_discount_fee']=$check_student_payment['discount_fee'];
			 	  $this->data['student_payment_total_fee']=$check_student_payment['total_fee'];

			 	  $till_now_paid_amt= $this->data['till_now_paid_amt'];
			 	  $student_payment_total_fee= $this->data['student_payment_total_fee'];
			 	  $paying_fee=$student_payment_total_fee-$till_now_paid_amt['total_amt'];
			 	  $this->data['paying_fee']=$paying_fee;

			 }else{
			 		$this->data['student_payment_discount_fee']='';
			 		$this->data['student_payment_total_fee']='';
			 		$this->data['paying_fee']=0;
			 }			 

			 $this->data['till_now_paid_amt']=$this->db->query("select sum(amount_paid) as total_amt from tbl_student_payment_details where student_id=$id GROUP BY student_id" )->row_array();

		 if($this->input->post('submit') != ''){
		 	$send_sms=$this->input->post('send_sms');

		 	$till_now_paid_amt= $this->data['till_now_paid_amt']['total_amt'];
		 	$student_payment_total_fee= $this->data['student_payment_total_fee'];
		 	$paynig_amount=$this->input->post('amount_paid');
 				//echo $till_now_paid_amt;
		 	$total_paying_amt=$till_now_paid_amt+$paynig_amount;
		 	if(!empty($check_student_payment)){
			 	if($total_paying_amt <= $student_payment_total_fee){

			 		$insert_id=$this->my_model->add_student_payment_details($id);
			 	}else{
			 		$this->session->set_flashdata('error', 'Record added Failed Your Paying is crossed to total fee!.');
					redirect('admin/student/add_payment_details/'.$id, 'refresh');	
			 	}
		 	}else{
		 		$insert_id=$this->my_model->add_student_payment_details($id);
		 	}

		 	
//exit;

		 	if($insert_id !=''){
		 	$payment_record=$this->common_model->get_table_row('student_payment_details',array('id'=>$insert_id),array());
		 	//echo '<pre>';print_r($payment_record);
		 	$this->save_pdf($send_sms,$payment_record['receipt_id'],'');
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/student/student_payments/'.$student['id'].'/1', 'refresh');		
			  }else{
			$this->session->set_flashdata('error', 'Record added Failed!.');
			redirect('admin/student/add_payment_details/'.$id, 'refresh');	
			  }	

		 }
		 $this->setHeaderFooter($this->student_payment_details,$this->data);
	
		 
	}


	public function edit_payment_details($id){
		
		  $this->data['record']=$this->my_model->get_payment_record($id);
		  $previous_amount=$this->data['record']['amount_paid'];


		  $stu_pay_record=$this->common_model->get_table_row('student_payment_details',array('id'=> $id),array('student_id'));
          $stu_id=$stu_pay_record['student_id'];

          $student=$this->common_model->get_table_row('students',array('id'=> $stu_id),array('id,state_id,organisation_id,center_id'));
          
		  $this->data['payment_modes']=$this->common_model->get_table('payment_modes',array('amount_type'=>'income','state_id'=>$student['state_id'],'organisation_id'=>$student['organisation_id'],'center_id'=>$student['center_id'],'status'=> 'Active'),array(),'payment_mode','asc');

		 
		  $this->data['till_now_paid_amt']=$this->my_model->student_till_now_paid_amt($stu_id); 
		  $this->data['student_payment_id']=$id;
		 if($this->input->post('submit') != ''){

		 	$result=$this->my_model->edit_student_payment_details($id);
		 	if($result){
		 	$send_sms=$this->input->post('send_sms');
		 	$payment_record=$this->common_model->get_table_row('student_payment_details',array('id'=>$id),array());
		 	//echo '<pre>';print_r($payment_record);
		 	$this->save_pdf($send_sms,$payment_record['receipt_id'],$previous_amount);
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/student/student_payments/'.$this->data['record']['student_id'].'/1', 'refresh');		
			  }else{
			$this->session->set_flashdata('error', 'Record Updated Failed!.');
			redirect('admin/student/edit_payment_details/'.$id, 'refresh');	
			  }	

		 }
		 $this->setHeaderFooter($this->edit_student_payment_details,$this->data);
	
		 
	}

	public function view_student()
	{
		$this->load->view($this->header_page);
		 $this->load->view($this->leftMenu);
		 $this->load->view($this->view_student);
		 $this->load->view($this->footer_Page);
	}

	public function getbatchs()
   	{
       $course_id = $this->input->post('course_id');
       $batchs  = $this->common_model->get_table('batchs', array('course_id' => $course_id,'status'=>'Active'));
      //print_r($subjects);exit;
       echo '<option value="">Select Batchs</option>';
       if(!empty($batchs))
       {
          foreach($batchs as $batch)
			      {
			      echo '<option value="'.$batch['id'].'">'.$batch['batch_name'].'</option>';
			      }
        }
	}

	public function getmmbscolleges()
   	{
       $state_id = $this->input->post('state_id');
       $colleges  = $this->common_model->get_table('colleges',array('state_id' => $state_id,'status'=>'Active'),array(),'college_name','asc');
      //print_r($subjects);exit;
       echo '<option value="">Select Colleges</option>';
       if(!empty($colleges))
       {
          foreach($colleges as $college)
			      {
			      echo '<option value="'.$college['id'].'">'.$college['college_name'].'</option>';
			      }
        }
	}

	public function getbatchsdates()
   	{
       $batch_id = $this->input->post('batch_id');
       $batchs  = $this->common_model->get_table_row('batchs', array('id' => $batch_id,'status'=>'Active'));
      //print_r($subjects);exit;
       $array=array( 
       				 'valid_from'=>$batchs['start_date'],
       				 'valid_to'=>$batchs['end_date'],
                     );
       echo json_encode($array);
	}
    
    public function getDueamount(){
    	$student_id = $this->input->post('student_id');
    	$amount_paid = $this->input->post('amount_paid');
    	$total_fee = $this->input->post('total_fee');
    	$discount_fee = $this->input->post('discount_fee');
    	if($discount_fee == ''){
    		$discount_fee=0;
    	}
    	/*$query="select sum(amount_paid) as total_paid_amt from tbl_student_payment_details where student_id='$student_id' GROUP BY student_id";   	
    	$up_to_total_paid_ary=$this->db->query($query)->row_array();*/

    	$query="select sum(amount_paid) as total_paid_amt from tbl_student_payment_details where type='bhatia' and student_id='$student_id' GROUP BY student_id";   	
    	$up_to_total_paid_ary=$this->db->query($query)->row_array();

    	$query1="select sum(discount_fee) as discount_fee from tbl_student_payment_details where type='bhatia' and student_id='$student_id' GROUP BY student_id";   	
    	$discount_fee_ary=$this->db->query($query1)->row_array();

    	if(!empty($up_to_total_paid_ary)){
    		$up_to_total_paid=$up_to_total_paid_ary['total_paid_amt'];
    		$total_paid_amt=$up_to_total_paid+$amount_paid;
    		//echo '<pre>';print_r($discount_fee_ary);exit;
    		$total_discount_fee=$discount_fee_ary['discount_fee']+$discount_fee;
    		$due_amt=$total_fee-$total_paid_amt-$total_discount_fee;
    	}else{
    		$due_amt=$total_fee-$amount_paid-$discount_fee;
    	}

    	if($due_amt > 0){
        echo $due_amt;
    	}else{ echo 0;}
    }

    public function edit_student_payment_Dueamount(){
    	$student_id = $this->input->post('student_id');
    	$amount_paid = $this->input->post('amount_paid');
    	$total_fee = $this->input->post('total_fee');
    	$discount_fee = $this->input->post('discount_fee');
    	$student_payment_id = $this->input->post('student_payment_id');
    	if($discount_fee == ''){
    		$discount_fee=0;
    	}
    	$query="select sum(amount_paid) as total_paid_amt from tbl_student_payment_details where student_id='$student_id' GROUP BY student_id";
    	$up_to_total_paid_ary=$this->db->query($query)->row_array();

    	$payment_record=$this->common_model->get_table_row('student_payment_details',array('id'=>$student_payment_id),array());

    	//echo '<pre>';print_r($data['payment_record']);exit;
    	//if($type == 1){
    		//paid amount case
    	$up_to_total_paid=$up_to_total_paid_ary['total_paid_amt'];
    	$exist_record_paid_payment=$payment_record['amount_paid'];
    	$total_paid_amt=$up_to_total_paid+$amount_paid-$exist_record_paid_payment;
    	$due_amt=$total_fee-$total_paid_amt-$discount_fee;
    	echo $due_amt;
    	/*}else if($type == 2){
    		// total fee case
    		$up_to_total_paid=$up_to_total_paid_ary['total_paid_amt'];
    		$exist_record_paid_payment=$payment_record['amount_paid'];

    	}else if($type == 3){
    		// discount case


    	}*/
    }

	public function sendOTP(){
		$mobile = $this->input->post('mobile');
		$otp = mt_rand(100000, 999999);

        $message='Dear Student, '.$otp.' is One time password (OTP) for DR Bhatia. Thank You.';
	    SendSMS($mobile,$message);
		echo ture;
	}

	public function sendOTPThroughLink(){
		$mobile = $this->input->post('mobile');
		$id = $this->input->post('id');
		$otp = mt_rand(1000, 9999);

        $message='Dear Student, '.$otp.' is One time password (OTP) for DR Bhatia. Thank You.';
	    SendSMS($mobile,$message);
	    $result=$this->my_model->update_otp($otp,$id);
		echo $result;
	}

	/*public function load_db2(){
		$this->db2 = $this->load->database('plato', TRUE);
		$result = $this->db2->query('select * from users')->result_array();
		echo '<pre>';print_r($result);exit;
	}
*/

	public function all_students_payments(){

        $records = $this->my_model->all_students_payments($_POST);

        $result_count=$this->my_model->all_students_payments($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($records) ),

            "data"  => $records);  

        echo json_encode($json_data);
	}

	public function student_payments($student_id,$param){

	   $this->data['student_id']=$student_id;
	   $this->data['param']=$param;
	   $this->data['student_data']=$this->common_model->get_table_row('students',array('id'=> $student_id),array('student_mobile'));
       $this->setHeaderFooter($this->student_payments_list,$this->data);
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



  public function change_record_status($user_id, $status)
	{
		if($this->my_model->change_record_status($user_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/agent_dashboard/my_admissions', 'refresh');
	}


	public function save_pdf($send_sms,$receipt_id,$previous_payment)
		 { 
		 	$path=''; $full_path='';

		 //load mPDF library
		 $this->load->library('M_pdf'); 
		 //now pass the data//
		 $data['payment_data'] =  $this->common_model->get_table_row('student_payment_details', array('receipt_id' => $receipt_id),array());
		
		 $data['student_data']=$this->my_model->get_student_data($data['payment_data']['student_id']);
		
		 $data['due_amount']=$this->my_model->get_student_due_amount($data['payment_data']['student_id'],$data['payment_data']['total_fee']);
		
		 //echo '<pre>';print_r($data['payment_data']);exit;
		 $html=$this->load->view($this->payment_pdf,$data, true); //load the pdf.php by passing our data and get all data in $html varriable.
		
		 $pdfFilePath = $receipt_id.".pdf"; 
		 //actually, you can pass mPDF parameter on this load() function
		 //$pdf = $this->M_pdf->load();
		 //generate the PDF from the given html
		
		 //generate the PDF!
		 //$stylesheet = '<style>'.file_get_contents('assets/admin/css/bootstrap.min.css').'</style>';
		 // apply external css
		 //$this->M_pdf->pdf->WriteHTML($stylesheet,1);
		 //$this->M_pdf->pdf->WriteHTML($html,2);
		 //offer it to user via browser download! (The PDF won't be saved on your server HDD)
		// $this->M_pdf->pdf->Output($pdfFilePath, "D");
		 $this->m_pdf->pdf->WriteHTML($html);

			//download it D save F.
		 $this->m_pdf->pdf->Output("./storage/paymentreceipts/".$pdfFilePath, "F");
		 $path= "storage/paymentreceipts/".$pdfFilePath;
		 $full_path=base_url().$path;

		 
		 $student_name= $data['student_data']['student_name'];
		 $student_mobile= $data['student_data']['student_mobile'];
		 $student_id= $data['student_data']['student_dynamic_id'];
		 $amount_paid=$data['payment_data']['amount_paid'];

		 $update_path=array('receipt_pdf_path' => $path);
		 $this->db->update('student_payment_details',$update_path,array('receipt_id' => $receipt_id));

		 //your mobile app UserID:$student_id and Password:bhatia@123 ;
     	if($previous_payment == ''){
		 
		 //$message="Dear ".$student_name.",your payment has been received successfully for INR ".$amount_paid.".00 by ISSM EDUCATIONAL SERVICES Pvt Limited click here to for invoice details {#var#} , Thank You -Bhatia";
		 $message="Dear ".$student_name.",your payment has been received successfully for INR ".$amount_paid.".00 by ISSM EDUCATIONAL SERVICES Pvt Limited click here to for invoice details https://hyderabadbhatia.com/storage/paymentreceipts/".$pdfFilePath." , Thank You -Bhatia";
		}else{
		 
		 //$message="Dear ".$student_name.", we are here to inform a change in your receipt that the receipt was wrongly generated for INR ".$previous_payment.".00, but the payment done is INR ".$amount_paid.".00 we are sending the new updated receipt link {#var#}. Kindly call +919381915159 if there is any dispute in the issue,Thank You -Bhatia";
		 $message="Dear ".$student_name.", we are here to inform a change in your receipt that the receipt was wrongly generated for INR ".$previous_payment.".00, but the payment done is INR ".$amount_paid.".00 we are sending the new updated receipt link https://hyderabadbhatia.com/storage/paymentreceipts/".$pdfFilePath.". Kindly call +919381915159 if there is any dispute in the issue,Thank You -Bhatia";
		// echo $message;exit;

		}
		  //echo $message;exit;
		 if($send_sms == 'yes'){
		 	SendSMS($student_mobile,$message);
		 	}
		 }


		 public function view_pdf()
		 { 
		
		 
		$this->load->view($this->payment_pdf);
		 
		 }


		 /*public function SendStudentLogins(){

		 	$students=$this->common_model->get_table('students',array('status'=>'Active'),array('student_mobile','student_dynamic_id'));
		 	//echo '<pre>';print_r($students);exit;
		 	foreach($students as $student){
		 		//$student['student_mobile']
		 		$message='Dear Doctor,Kindly download My Institute App used for your institution uses.Your ID:'.$student['student_dynamic_id'].', Password: bhatia123 .Change the password as soon as you log-in in to your account.Android: https://play.google.com/store/apps/details?id=com.hyderabad.bhatia for ios:https://apps.apple.com/in/app/m-c-i/id1557535056 For any doubts please Call: +919381915140';
		 		SendSMS($student['student_mobile'],$message);
		 		//echo '1';exit;
		 	}
		 	echo 'All messages sending successfully';exit;

		 }*/

	
     public function updateIosDevice_ids(){
     	$students=$this->common_model->get_table('students',array(),array('student_mobile','student_dynamic_id'));
     	foreach($students as $key=>$value){
   			$up_array=array(
   								'device_id'=>md5($value['student_dynamic_id'])
   							);
   			$this->db->update('students',$up_array,array('student_dynamic_id'=>$value['student_dynamic_id']));
     	}
     	echo 'done device_ids updated successfully';exit;
     }



}

?>