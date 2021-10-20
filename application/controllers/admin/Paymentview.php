<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Paymentview extends CI_Controller {

	public $states_Page = 'admin/paymentview/paymentview_states';

	public $org_Page = 'admin/paymentview/paymentview_org';

	public $centers_Page = 'admin/paymentview/paymentview_centers';
	
	public $center_payment_details_Page = 'admin/paymentview/center_payment_details';

	public $payment_mode_payments_Page = 'admin/paymentview/payment_mode_payments';

	public $income_items_list_Page= 'admin/paymentview/income_items_list';	

	public $expense_items_list_Page= 'admin/paymentview/expense_items_list';

	public $expense_category_Page='admin/paymentview/expense_category_list';
	public $years_Page='admin/paymentview/paymentview_years';
	public $months_Page='admin/paymentview/paymentview_months';


	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu='admin/includes/left_menu';

	public function __construct()
	{
	parent::__construct();
	
	$this->load->model('admin/Paymentview_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	}

	public function index(){		
				 
		 $this->data['states']=$this->my_model->get_state_wise_amount();
		 //echo '<pre>';print_r($this->data['states']);exit;

         $this->setHeaderFooter($this->states_Page,$this->data);
         
	}

	public function org_state($state_id){		
		 $this->data['state']=$this->common_model->get_table_row('states',array('id'=>$state_id),array());
		 
		 $this->data['organisations']=$this->my_model->get_organisation_wise_amount($state_id);
		// echo '<pre>';print_r($this->data['organisations']);exit;
         $this->setHeaderFooter($this->org_Page,$this->data);
         
	}

	public function org_center($state_id,$org_id){
		$this->data['state_id']=$state_id;
		$this->data['org_id']=$org_id;

		$this->data['state']=$this->common_model->get_table_row('states',array('id'=>$state_id),array());
		$this->data['organisation']=$this->common_model->get_table_row('organisations',array('id'=>$org_id),array());

		$this->data['centers']=$this->my_model->get_centers_wise_amount($state_id,$org_id);
		//echo '<pre>';print_r($this->data['centers']);exit;
		$this->setHeaderFooter($this->centers_Page,$this->data);
	}

	public function center_years($state_id,$org_id,$center_id){
		$this->data['state_id']=$state_id;
		$this->data['org_id']=$org_id;
		$this->data['center_id']=$center_id;

		$this->data['state']=$this->common_model->get_table_row('states',array('id'=>$state_id),array());
		$this->data['organisation']=$this->common_model->get_table_row('organisations',array('id'=>$org_id),array());
		$this->data['center']=$this->common_model->get_table_row('centers',array('id'=>$center_id),array());
		$this->data['years']=$this->my_model->get_years_wise_amount($state_id,$org_id,$center_id);

		$this->setHeaderFooter($this->years_Page,$this->data);
	}

	public function center_years_months($state_id,$org_id,$center_id,$year){
		$this->data['state_id']=$state_id;
		$this->data['org_id']=$org_id;
		$this->data['center_id']=$center_id;
		$this->data['year']=$year;

		$this->data['state']=$this->common_model->get_table_row('states',array('id'=>$state_id),array());
		$this->data['organisation']=$this->common_model->get_table_row('organisations',array('id'=>$org_id),array());
		$this->data['center']=$this->common_model->get_table_row('centers',array('id'=>$center_id),array());
		$this->data['months']=$this->my_model->get_years_months_wise_amount($state_id,$org_id,$center_id,$year);

		$this->setHeaderFooter($this->months_Page,$this->data);

	}
	public function center_payment_details($state_id,$org_id,$center_id,$year,$month_id){
		$this->data['state_id']=$state_id;
		$this->data['org_id']=$org_id;
		$this->data['center_id']=$center_id;
		$this->data['year']=$year;
		$this->data['month_id']=$month_id;

		$this->data['state']=$this->common_model->get_table_row('states',array('id'=>$state_id),array());
		$this->data['organisation']=$this->common_model->get_table_row('organisations',array('id'=>$org_id),array());
		$this->data['center']=$this->common_model->get_table_row('centers',array('id'=>$center_id),array());
		$this->data['month']=$this->common_model->get_table_row('months',array('id'=>$month_id),array());


		$this->data['income']=$this->my_model->get_center_wise_income($state_id,$org_id,$center_id,$year,$month_id);
		$this->data['expense']=$this->my_model->get_center_wise_expense($state_id,$org_id,$center_id,$year,$month_id);
		//echo '<pre>';print_r($this->data['income']);exit;
		$this->setHeaderFooter($this->center_payment_details_Page,$this->data);
	}

	public function payment_mode_payments($state_id,$org_id,$center_id,$year,$month_id,$type){

		$this->data['state_id']=$state_id;
		$this->data['org_id']=$org_id;
		$this->data['center_id']=$center_id;
		$this->data['year']=$year;
		$this->data['month_id']=$month_id;

		$this->data['state']=$this->common_model->get_table_row('states',array('id'=>$state_id),array());
		$this->data['organisation']=$this->common_model->get_table_row('organisations',array('id'=>$org_id),array());
		$this->data['center']=$this->common_model->get_table_row('centers',array('id'=>$center_id),array());
		$this->data['month']=$this->common_model->get_table_row('months',array('id'=>$month_id),array());

		$this->data['type']=$type;
		if($type == 'income'){
			$this->data['function_type']='income_items_list';
			$this->data['payment_modes']=$this->my_model->get_payment_modes_income_wise_amount($state_id,$org_id,$center_id,$year,$month_id);
		}else{
			$this->data['function_type']='expense_items_list';
			$this->data['payment_modes']=$this->my_model->get_payment_modes_expense_wise_amount($state_id,$org_id,$center_id,$year,$month_id);
		}
		
		//echo '<pre>';print_r($this->data['payment_modes']);exit;
		$this->setHeaderFooter($this->payment_mode_payments_Page,$this->data);
	}

	public function expense_categories($state_id,$org_id,$center_id,$year,$month_id){
		$this->data['state_id']=$state_id;
		$this->data['org_id']=$org_id;
		$this->data['center_id']=$center_id;
		$this->data['year']=$year;
		$this->data['month_id']=$month_id;

		$this->data['state']=$this->common_model->get_table_row('states',array('id'=>$state_id),array());
		$this->data['organisation']=$this->common_model->get_table_row('organisations',array('id'=>$org_id),array());
		$this->data['center']=$this->common_model->get_table_row('centers',array('id'=>$center_id),array());
		$this->data['month']=$this->common_model->get_table_row('months',array('id'=>$month_id),array());
		$this->data['categories']=$this->my_model->get_categories_wise_amount($state_id,$org_id,$center_id,$year,$month_id);
		//echo '<pre>';print_r($this->data['categories']);exit;
		$this->setHeaderFooter($this->expense_category_Page,$this->data);
	}

	public function income_items_list($state_id,$org_id,$center_id,$year,$month_id,$payment_mode_id,$type){

		$this->data['state_id']=$state_id;
		$this->data['org_id']=$org_id;
		$this->data['center_id']=$center_id;
		$this->data['payment_mode_id']=$payment_mode_id;
		$this->data['type']=$type;
		$this->data['year']=$year;
		$this->data['month_id']=$month_id;

		$this->data['state']=$this->common_model->get_table_row('states',array('id'=>$state_id),array());
		$this->data['organisation']=$this->common_model->get_table_row('organisations',array('id'=>$org_id),array());
		$this->data['center']=$this->common_model->get_table_row('centers',array('id'=>$center_id),array());
		$this->data['month']=$this->common_model->get_table_row('months',array('id'=>$month_id),array());
		$this->data['payment_mode']=$this->common_model->get_table_row('payment_modes',array('id'=>$payment_mode_id),array());


		$this->setHeaderFooter($this->income_items_list_Page,$this->data);

	}

	public function all_income_user_records($state_id,$org_id,$center_id,$year,$month_id,$payment_mode_id){

		$_POST['state_id']=$state_id;
		$_POST['org_id']=$org_id;
		$_POST['center_id']=$center_id;
		$_POST['payment_mode_id']=$payment_mode_id;
		$_POST['year']=$year;
		$_POST['month_id']=$month_id;

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

	public function expense_items_list($state_id,$org_id,$center_id,$year,$month_id,$category_id){

		$this->data['state_id']=$state_id;
		$this->data['org_id']=$org_id;
		$this->data['center_id']=$center_id;
		$this->data['year']=$year;
		$this->data['month_id']=$month_id;
		$this->data['category_id']=$category_id;

		$this->data['state']=$this->common_model->get_table_row('states',array('id'=>$state_id),array());
		$this->data['organisation']=$this->common_model->get_table_row('organisations',array('id'=>$org_id),array());
		$this->data['center']=$this->common_model->get_table_row('centers',array('id'=>$center_id),array());
		$this->data['month']=$this->common_model->get_table_row('months',array('id'=>$month_id),array());
		$this->data['category']=$this->common_model->get_table_row('categories',array('id'=>$category_id),array());
		

		$this->setHeaderFooter($this->expense_items_list_Page,$this->data);

	}

	public function all_expense_user_records($state_id,$org_id,$center_id,$year,$month_id,$category_id){

		$_POST['state_id']=$state_id;
		$_POST['org_id']=$org_id;
		$_POST['center_id']=$center_id;
		$_POST['category_id']=$category_id;
		$_POST['year']=$year;
		$_POST['month_id']=$month_id;

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