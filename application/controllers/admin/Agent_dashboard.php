<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Agent_dashboard extends CI_Controller {

	public $dashboard_Page = 'admin/agent/agent_dashboard';
	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu='admin/includes/left_menu';
	public $income_list_Page='admin/agent/agent_income_list';
	public $my_admissions_Page='admin/agent/my_admissions';
	public $student_view_Page='admin/agent/view_student';

	public function __construct()
	{
	parent::__construct();
	
	$this->load->model('admin/Agent_dashboard_model','my_model');
	checkAdminLogin();
	$this->load->model('Common_model','common_model');
	if($this->session->userdata('user_id') != 'ADM0001'){
		 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
	     }else{
		 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
		 }
		 //echo '<pre>';print_r($this->session->all_userdata());
		// echo '<pre>';print_r($this->data['roleResponsible']);exit;
		 //echo '<pre>';print_r($this->session->userdata('user_id'));exit;
	}

	

	public function index(){
		//echo '<pre>';print_r($this->session->userdata('user_id'));exit;
		 $this->data['emp_record']=$this->common_model->get_table_row('users',array('user_id'=>$this->session->userdata('user_id')),array('id','user_id','user_name','payment_mode_id'));
		 $this->data['payment_mode_id']=$this->data['emp_record']['payment_mode_id'];

		 $this->data['incomes_total']=$this->my_model->get_incomes_total();
		 $this->data['incomes_pending']=$this->my_model->get_incomes_pending();
		 $this->data['incomes_rejected']=$this->my_model->get_incomes_rejected();

		 if($this->data['payment_mode_id'] != 0){
		 $payment_mode_id=$this->data['payment_mode_id'];
		 $this->data['incomes_payment_mode_total']=$this->my_model->get_incomes_payment_mode_total($payment_mode_id);
		 $this->data['incomes_payment_mode_pending']=$this->my_model->get_incomes_payment_mode_pending($payment_mode_id);
		 $this->data['incomes_payment_mode_rejected']=$this->my_model->get_incomes_payment_mode_rejected($payment_mode_id);
		 }
		 $this->data['my_total_admissions']=$this->my_model->get_my_total_admissions();

		 $this->data['expense_approval']=$this->my_model->get_expense_approval();
		 $this->data['expense_pending']=$this->my_model->get_expense_pending();
		 $this->data['expense_rejected']=$this->my_model->get_expense_rejected();


         $this->setHeaderFooter($this->dashboard_Page,$this->data);
	}

	public function agent_incomes_list($value){

		$this->data['param']=$value;
		$this->setHeaderFooter($this->income_list_Page,$this->data);


	}

	public function student_view($stu_id){

		$this->data['record']=$this->my_model->student_view($stu_id);
		
		//echo '<pre>';print_r($this->data['record']);exit;

		$this->setHeaderFooter($this->student_view_Page,$this->data);
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

	public function my_admissions(){

		$this->setHeaderFooter($this->my_admissions_Page,$this->data);
	}

	public function all_my_admisssions(){

		$records = $this->my_model->all_my_admisssions($_POST);

        $result_count=$this->my_model->all_my_admisssions($_POST,1);

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