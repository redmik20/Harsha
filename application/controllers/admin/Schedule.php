<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Schedule extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $list_Page = 'admin/schedule/list_schedule';
	public $add_Page =  'admin/schedule/add_schedule';	
	public $edit_Page = 'admin/schedule/edit_schedule';
	
	public function __construct()
	{
	parent::__construct();
	$this->load->model('admin/Schedule_model','my_model');
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

	public function add(){

		$this->data['courses']=$this->common_model->get_table('courses',array('status'=>'Active'),array(),'order','asc');
		$this->data['centers']=$this->common_model->get_table('centers',array('status'=>'Active'),array(),'center','asc');
		$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');	
		
		$this->setHeaderFooter($this->add_Page,$this->data);
		}

	public function edit($id){
		$this->data['record']=$this->my_model->get_record($id);
		$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');
		
		$this->data['organisations']=$this->common_model->get_table('organisations',array('state_id'=>$this->data['record']['state_id'],'status'=>'Active'),array(),'organisation_name','asc');
		$this->data['centers']=$this->common_model->get_table('centers',array('state_id'=>$this->data['record']['state_id'],'organisation_id'=>$this->data['record']['organisation_id'],'status'=>'Active'),array(),'center','asc');
		$this->data['courses']=$this->common_model->get_table('courses',array('state_id'=>$this->data['record']['state_id'],'organisation_id'=>$this->data['record']['organisation_id'],'center_id'=>$this->data['record']['center_id'],'course_type'=>'admin','status'=>'Active'),array(),'id','desc');
		$this->data['batchs']=$this->common_model->get_table('batchs',array('course_id'=>$this->data['record']['course_id'],'status'=>'Active'),array(),'batch_name','asc');

		$this->setHeaderFooter($this->edit_Page,$this->data);
	}

	public function view(){

		 $this->setHeaderFooter($this->add_Page,$this->data);
	}

	public function all_records(){
//echo '<pre>';print_r($_POST);exit;
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

	public function update_record()
	{

		$id=$this->input->post('schedule_id');
		$batch_ids= implode(',',$this->input->post('batch_ids'));
		$months=$this->getMonthsInRange($this->input->post('start_date'),$this->input->post('end_date'));

		$Years_Months=$this->getImplodedMonths($months);
		//echo '<pre>',print_r($ImplodedMonths);exit;

		$data=array(
						'state_id'=> $this->input->post('state_id'),
						'organisation_id'=> $this->input->post('organisation_id'),
						'center_id'=> $this->input->post('center_id'),
						'course_id'=> $this->input->post('course_id'),
						'batch_ids'=> $batch_ids,
						'months'=>$Years_Months['imploded_months'],
						'years'=>$Years_Months['imploded_years'],
						'schedule_name'=> $this->input->post('schedule_name'),
						'start_date'=> $this->input->post('start_date'),
						'start_time'=> $this->input->post('start_time'),
						'end_date'=> $this->input->post('end_date'),
						'end_time'=> $this->input->post('end_time')					
					);
			//echo '<pre>';print_r($data);exit();
		if($id == "")
		{
			$data['created_on'] = date('Y-m-d H:i:s');
			$data['created_by'] = $this->session->userdata('user_id');
			$result=$this->my_model->update_record($data,$id);
			$this->update_monthly_schedule_list($months,$result);
			if($result){
				//echo '<pre>';print_r($data);exit();
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/schedule/add', 'refresh');		
			  }else{
			$this->session->set_flashdata('error', 'Record added Failed!.');
			redirect('admin/schedule/add', 'refresh');	
			  }	
		}else{
			
			$data['modified_on'] = date('Y-m-d H:i:s');
			$data['modified_by'] = $this->session->userdata('user_id');
			$result1=$this->my_model->update_record($data, $id);
			$this->update_monthly_schedule_list($months,$id);
			if($result1){
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/schedule/edit/'.$id, 'refresh');
			}else{
			$this->session->set_flashdata('success', 'Record Updated Failed!.');
			redirect('admin/schedule/edit/'.$id, 'refresh');
			}
		}	
		

	}

	public function update_monthly_schedule_list($months,$schedule_id){

		//echo '<pre>';print_r($months);exit;
		$this->db->delete('schedule_monthly_list',array('schedule_id'=>$schedule_id));
		foreach($months as $month){
			$in_data=array(
							'schedule_id'=>$schedule_id,
							'year'=>$month['year'],
							'month'=>$month['month'],
							'created_on'=> date('Y-m-d H:i:s')
					   );
			$this->db->insert('schedule_monthly_list',$in_data);
		}

	}

	public function getImplodedMonths($Months){

		foreach ($Months as $key => $value) {
			$SeperatedMonths[]=$value['month'];
		
			$SeperatedYears[]=$value['year'];

		}

		$SeperatedYears=array_unique($SeperatedYears);

		$result=array(
			'imploded_months'=> implode(',', $SeperatedMonths),
			'imploded_years'=> implode(',', $SeperatedYears),
			);
		//echo '<pre>',print_r($ImplodedMonths);exit;
		return $result;

	}

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
		redirect('admin/schedule', 'refresh');
	}

	function getMonthsInRange($startDate, $endDate) {
		$months = array();
		while (strtotime($startDate) <= strtotime($endDate)) {
		    $months[] = array('year' => date('Y', strtotime($startDate)), 'month' => date('m', strtotime($startDate)), );
		    $startDate = date('01 M Y', strtotime($startDate.
		        '+ 1 month')); // Set date to 1 so that new month is returned as the month changes.
		}

		return $months;
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