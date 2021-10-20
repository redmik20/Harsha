<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Payment_portal extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $list_Page = 'admin/paymentportal/list_payment_portal';
	public $add_Page =  'admin/paymentportal/add_payment_portal';	
	public $edit_Page = 'admin/paymentportal/edit_discountscheme';
	public $payment_pdf = 'admin/paymentportal/payment_nonbhatia_pdf';
	public $search_students_list_Page= 'admin/paymentportal/search_students_list';
	
	public function __construct()
	{
	parent::__construct();
	$this->load->model('admin/Paymentportal_model','my_model');
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

	public function student_payment_view($search_on='',$search_value=''){

		$search_value=$this->input->post('mobile_number');
		$search_on=$this->input->post('search_on_1');
		/*if($search_on == 1){
		$student_id=$this->common_model->get_table_row('students',array('student_mobile'=>$search_value),array('id'));
		}else{
			$student_id=$this->my_model->search_student_name($search_value);
		}*/
		$this->data['search_value']=$search_value;
		$this->data['search_on']=$search_on;

		//echo '<pre>';print_r($search_value);exit;

		/*if($student_id !=''){

			redirect('admin/student/student_payments/'.$student_id['id']);		
			 
		}else{
			$this->session->set_flashdata('error', 'Student Record Non exists!.');
			redirect('admin/payment_portal', 'refresh');	
		}*/
		//print_r($mobile_number);exit();

		$this->setHeaderFooter($this->search_students_list_Page,$this->data);
	}

	public function student_payment_view_back($search_on,$search_value){

		$this->data['search_value']=$search_value;
		$this->data['search_on']=$search_on;


		$this->setHeaderFooter($this->search_students_list_Page,$this->data);
	}

	public function search_students_list(){

		

		$center = $this->my_model->all_search_students_list($_POST);

        $result_count=$this->my_model->all_search_students_list($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($center) ),

            "data"  => $center);  

        echo json_encode($json_data);
	}

	public function add(){

		$this->data['payments']=$this->common_model->get_table('payment_modes',array('status'=>'Active'),array(),'payment_mode','asc');
		$this->data['colleges']=$this->common_model->get_table('colleges',array('status'=>'Active'),array(),'college_name','asc');
		$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');
		$this->setHeaderFooter($this->add_Page,$this->data);
	}

	
	public function view(){

    	$this->setHeaderFooter($this->add_Page,$this->data);
	}

	public function all_portals(){

        $center = $this->my_model->all_portals($_POST);

        $result_count=$this->my_model->all_portals($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($center) ),

            "data"  => $center);  

        echo json_encode($json_data);
	}

	public function update_portal()
	{
		$id=$this->input->post('id');
		$payment_mode_id=$this->input->post('payment_mode_id');
		
		$data=array(
						'student_name'=> $this->input->post('student_name'),
						'mobile_number' => $this->input->post('mobile_number'),
						'college_name'=> $this->input->post('college_name'),
						'payment_for' => $this->input->post('payment_for'),
						'payment_amount'=> $this->input->post('payment_amount'),
						'payment_mode_id' => $this->input->post('payment_mode_id'),
						'remarks'=> $this->input->post('remarks')
					);
			//echo '<pre>';print_r($data);exit;
		if($id == "")
		{
			$data['created_on'] = date('Y-m-d H:i:s');
			$data['created_by'] = $this->session->userdata('user_id');
			$result=$this->my_model->update_record($data,$id);
			if($result){
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/payment_portal/add', 'refresh');		
			  }else{
			$this->session->set_flashdata('error', 'Record added Failed!.');
			redirect('admin/payment_portal/add', 'refresh');	
			  }	
		}else{
			
			$data['modified_on'] = date('Y-m-d H:i:s');
			$data['modified_by'] = $this->session->userdata('user_id');
			$result1=$this->my_model->update_record($data, $id);
			if($result1){
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/payment_portal/edit/'.$id, 'refresh');
			}else{
			$this->session->set_flashdata('success', 'Record Updated Failed!.');
			redirect('admin/payment_portal/edit/'.$id, 'refresh');
			}
		}		

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
             $payment_record=$this->common_model->get_table_row('student_payment_details',array('id'=>$insert_id),array());
		 	//echo '<pre>';print_r($payment_record);
		 	$this->save_pdf($payment_record['receipt_id']);
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/payment_portal/add', 'refresh');		
			  }else{
			$this->session->set_flashdata('error', 'Record added Failed!.');
			redirect('admin/payment_portal/add', 'refresh');
			  }	

       
    }

    public function save_pdf($receipt_id)
		 { 
		 	$path=''; $full_path='';

		 //load mPDF library
		 $this->load->library('M_pdf'); 
		 //now pass the data//
		 $data['payment_data'] =  $this->common_model->get_table_row('student_payment_details', array('receipt_id' => $receipt_id),array());
		//echo '<pre>';print_r($data['payment_data']);exit;
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
		
		 $update_path=array('receipt_pdf_path' => $path);
		 $this->db->update('student_payment_details',$update_path,array('receipt_id' => $receipt_id));

		 $message="Dear $student_name,payment recived successfully click here to your invoice details $full_path ,Thank You ISSM";
		  //echo $message;exit;
		 SendSMS($student_mobile,$message);
		 }
}


?>