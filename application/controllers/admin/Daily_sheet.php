<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Daily_sheet extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $calender_Page = 'admin/daily_sheet/list_calender';
	public $search_employees_list_Page= 'admin/daily_sheet/search_employees_list';
	public $daily_incomes_list_Page='admin/daily_sheet/daily_incomes_list';
	public $daily_expense_list_Page='admin/daily_sheet/daily_expense_list';
	
	
	public function __construct()
	{
	parent::__construct();
	$this->load->model('admin/daily_sheet_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	}

	public function index(){
		redirect(base_url().'admin/daily_sheet/calender');
	}

	public function calender(){
		if($this->uri->segment(4) == ''){
			 $this->data['search_date']=$search_date=date('Y-m-d');
			 $this->data['search_value']='today';
		}else{
			 $this->data['search_date']=$search_date=$this->uri->segment(4);
			 $this->data['search_value']='search';
		}
		 //echo '<pre>';print_r($search_date);exit;
		 $this->data['daily_approved_incomes']=$this->my_model->get_daily_approved_incomes($search_date);
		 $this->data['daily_approved_expenses']=$this->my_model->get_daily_approved_expenses($search_date);
		 //echo '<pre>';print_r($this->data['daily_approved_expenses']);exit;
		 $this->setHeaderFooter($this->calender_Page,$this->data);
	}

	public function employee_records(){
    	
    	$search_date=$this->input->post('date_from');
    	//$this->data['search_date']=$search_date;
    	//$this->setHeaderFooter($this->search_employees_list_Page,$this->data);
    	redirect(base_url().'admin/daily_sheet/calender/'.$search_date);
	}

	public function search_employee_list(){

		

		$center = $this->my_model->all_search_employee_list($_POST);

        $result_count=$this->my_model->all_search_employee_list($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($center) ),

            "data"  => $center);  

        echo json_encode($json_data);
	}

	public function daily_incomes_list(){
		if($this->uri->segment(4) == ''){
			 $this->data['search_date']=$search_date=date('Y-m-d');
			 $this->data['search_value']='today';
		}else{
			 $this->data['search_date']=$search_date=$this->uri->segment(4);
			 $this->data['search_value']='search';
		}

		$this->setHeaderFooter($this->daily_incomes_list_Page,$this->data);
	}



	public function all_daily_incomes_list_records(){

		

		$records = $this->my_model->all_daily_incomes_list_records($_POST);

        $result_count=$this->my_model->all_daily_incomes_list_records($_POST,1);

        $json_data = array(

            "draw"  => intval($_POST['draw'] ),

            "iTotalRecords"  => intval($result_count ),

            "iTotalDisplayRecords"  => intval($result_count ),

            "recordsFiltered"  => intval(count($records) ),

            "data"  => $records);  

        echo json_encode($json_data);

	}

	public function daily_expense_list(){

		if($this->uri->segment(4) == ''){
			 $this->data['search_date']=$search_date=date('Y-m-d');
			 $this->data['search_value']='today';
		}else{
			 $this->data['search_date']=$search_date=$this->uri->segment(4);
			 $this->data['search_value']='search';
		}

		$this->setHeaderFooter($this->daily_expense_list_Page,$this->data);
	}

	public function all_daily_expense_list_records(){

		

		$records = $this->my_model->all_daily_expense_list_records($_POST);

        $result_count=$this->my_model->all_daily_expense_list_records($_POST,1);

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