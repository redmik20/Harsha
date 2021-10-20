<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Available_funds extends CI_Controller {

	public $attachment_groups_Page='admin/available_funds/attachment_groups_list';
	public $attachments_Page='admin/available_funds/attachments_list';
	public $income_expense_Page='admin/available_funds/income_expense_list';
	public $payment_modes_Page='admin/available_funds/payment_modes_list';
	public $income_items_list_Page='admin/available_funds/income_items_list';
	public $expense_items_list_Page='admin/available_funds/expense_items_list';

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu='admin/includes/left_menu';



	public function __construct()
	{
	parent::__construct();
	
	$this->load->model('admin/Available_funds_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	}


	public function index(){

		$this->data['attachment_groups']=$this->my_model->get_attachment_groups_wise_amount();
		//echo '<pre>';print_r($this->data['states']);exit;

        $this->setHeaderFooter($this->attachment_groups_Page,$this->data);
	}
	public function attachments($id){		
				 
		 $this->data['attachments']=$this->my_model->get_attachment_wise_amount($id);
		 //echo '<pre>';print_r($this->data['states']);exit;

         $this->setHeaderFooter($this->attachments_Page,$this->data);
         
	}

	public function income_expense_details($attachment_id){

		$this->data['attachment_id']=$attachment_id;

		$this->data['income']=$this->my_model->get_attachment_income_amount($attachment_id);
		$this->data['expense']=$this->my_model->get_attachment_expense_amount($attachment_id);
		$this->data['from_tansfer_funds']=$this->my_model->get_attachment_from_tansfer_funds_amount($attachment_id);
		$this->data['to_tansfer_funds']=$this->my_model->get_attachment_to_tansfer_funds_amount($attachment_id);
		$this->data['opening_blac']=$this->my_model->get_attachment_opening_blac($attachment_id);

		$this->setHeaderFooter($this->income_expense_Page,$this->data);
	}

	public function payment_modes($attachment_id,$type){

		$this->data['attachment_id']=$attachment_id;
		$this->data['type']=$type;
		if($type == 'income'){
		$this->data['function_type']='income_items_list';
		$this->data['payment_modes']=$this->my_model->get_income_payment_modes_amount($attachment_id);
			}else{
		$this->data['function_type']='expense_items_list';
		$this->data['payment_modes']=$this->my_model->get_expense_payment_modes_amount($attachment_id);
			     }
		$this->setHeaderFooter($this->payment_modes_Page,$this->data);
	}

	public function income_items_list($attachment_id,$payment_mode_id){

		$this->data['attachment_id']=$attachment_id;
		$this->data['payment_mode_id']=$payment_mode_id;

		$this->setHeaderFooter($this->income_items_list_Page,$this->data);

	}

	public function all_income_user_records($attachment_id,$payment_mode_id){

		$_POST['attachment_id']=$attachment_id;
		$_POST['payment_mode_id']=$payment_mode_id;		

		$records = $this->my_model->all_income_user_records($_POST);

        $result_count=$this->my_model->all_income_user_records($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($records) ),

            "data"  => $records);  

        echo json_encode($json_data);

	}

	public function expense_items_list($attachment_id,$payment_mode_id){

		$this->data['attachment_id']=$attachment_id;
		$this->data['payment_mode_id']=$payment_mode_id;	
		

		$this->setHeaderFooter($this->expense_items_list_Page,$this->data);

	}

	public function all_expense_user_records($attachment_id,$payment_mode_id){

		$_POST['attachment_id']=$attachment_id;
		$_POST['payment_mode_id']=$payment_mode_id;

		$records = $this->my_model->all_expense_user_records($_POST);

        $result_count=$this->my_model->all_expense_user_records($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($records) ),

            "data"  => $records);  

        echo json_encode($json_data);

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