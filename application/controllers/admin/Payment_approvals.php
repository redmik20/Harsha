<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Payment_approvals extends CI_Controller {


	public $list_payments_Page='admin/payment_approvals/list_payments_approvals';
	public $payment_buttons_Page='admin/payment_approvals/payment_buttons';
	

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu='admin/includes/left_menu';



	public function __construct()
	{
	parent::__construct();
	
	$this->load->model('admin/Payment_approvals_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	}

	public function index(){

		$this->setHeaderFooter($this->payment_buttons_Page,$this->data);
	}

	public function payments($type){		
				 
		 $this->data['type']=$type;
         $this->setHeaderFooter($this->list_payments_Page,$this->data);
         
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

	public function change_status($user_id,$status,$type)
	{
		if($this->my_model->change_status($user_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/payment_approvals/payments/'.$type, 'refresh');
	}

	public function delete_payment($id){
		
		if($this->my_model->delete_payment($id) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/payment_approvals', 'refresh');

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