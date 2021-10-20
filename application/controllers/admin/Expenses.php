<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Expenses extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $list_Page = 'admin/expenses/list_expenses';
	public $list_total_Page='admin/expenses/list_total_expenses';
	public $add_Page =  'admin/expenses/add_expenses';
	public $edit_Page = 'admin/expenses/edit_expenses';

	public $states_list_Page = 'admin/expenses/list_states';
	public $organisations_list_Page ='admin/expenses/list_organisations';
	public $centers_list_Page ='admin/expenses/list_centers';
	public $bulk_upload_expense_page='admin/expenses/bulk_upload_expense';


	public function __construct()
	{
	parent::__construct();
	$this->load->model('admin/Expenses_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	}

	public function index(){
		
		 $this->setHeaderFooter($this->list_total_Page,$this->data);
	}

	public function states(){
		 $this->data['states']=$this->my_model->expense_states_wise_count();
		 //secho '<pre>';print_r($this->data['states']);exit;
		 $this->setHeaderFooter($this->states_list_Page,$this->data);
	}

	public function list_org($state_id){
		$this->data['state_id']=$state_id;
		$this->data['organisations']=$this->my_model->expense_organisations_count($state_id);
		// echo '<pre>';print_r($this->data['organisations']);exit;
		$this->setHeaderFooter($this->organisations_list_Page,$this->data);
	}

	public function list_centers($state_id,$org_id){
		$this->data['state_id']=$state_id;
		$this->data['org_id']=$org_id;
		$this->data['centers']=$this->my_model->expense_centers_count($state_id,$org_id);
		//echo '<pre>';print_r($this->data['centers']);exit;
		$this->setHeaderFooter($this->centers_list_Page,$this->data);
	}

	public function expenses_list(){
		//$this->data['state_id']=$state_id;
		//$this->data['org_id']=$org_id;
		//$this->data['center_id']=$center_id;

		 $this->setHeaderFooter($this->list_Page,$this->data);
	}

	public function add($param){
		 $this->data['param']=$param;

		 $this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');

		$this->data['payments']=$this->common_model->get_table('payment_modes',array('status'=>'Active'),array(),'payment_mode','asc');
		$user_id=$this->session->userdata('user_id');
		if($user_id !='ADM0001'){
			$this->data['employee']=$this->common_model->get_table_row('users',array('user_id'=>$user_id),array());
			$state_id=$this->data['employee']['state_id'];
			$org_id=$this->data['employee']['organisation_id'];
			$center_id=$this->data['employee']['center_id'];
			$this->data['organisations']=$this->common_model->get_table('organisations',array('state_id'=>$state_id),array());
			$this->data['centers']=$this->common_model->get_table('centers',array('state_id'=>$state_id,'organisation_id'=>$org_id),array());
			$this->data['categories']=$this->common_model->get_table('categories',array('state_id'=>$state_id,'organisation_id'=>$org_id,'center_id'=>$center_id),array());
			$this->data['payment_modes']=$this->common_model->get_table('payment_modes',array('state_id'=>$state_id,'organisation_id'=>$org_id,'center_id'=>$center_id,'amount_type'=>'expense'),array());
		}else{
			$this->data['employee']=array();
			
		}
		//echo '<pre>';print_r($this->data['employee']);exit;
		
		 $this->setHeaderFooter($this->add_Page,$this->data);
	}

	public function edit($id){
		 $this->data['record']=$this->my_model->get_record($id);
		 $this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');
		 $this->data['organisations']=$this->common_model->get_table('organisations',array('state_id'=>$this->data['record']['state_id'],'status'=>'Active'),array(),'organisation_name','asc');

		$this->data['centers']=$this->common_model->get_table('centers',array('state_id'=>$this->data['record']['state_id'],'organisation_id'=>$this->data['record']['organisation_id'],'status'=>'Active'),array(),'center','asc');
		$this->data['payments']=$this->common_model->get_table('payment_modes',array('state_id'=>$this->data['record']['state_id'],'organisation_id'=>$this->data['record']['organisation_id'],'center_id'=>$this->data['record']['center_id'],'status'=>'Active','amount_type'=>'expense'),array(),'payment_mode','asc');
		$this->data['categories']=$this->common_model->get_table('categories',array('state_id'=>$this->data['record']['state_id'],'organisation_id'=>$this->data['record']['organisation_id'],'center_id'=>$this->data['record']['center_id'],'status'=>'Active'),array(),'category_name','asc');


		 $this->setHeaderFooter($this->edit_Page,$this->data);
	}

	public function view(){

		 $this->setHeaderFooter($this->add_Page,$this->data);
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

	public function update_records()
	{


		$id=$this->input->post('id');
		$param=$this->input->post('param');

		if($this->input->post('image_type') == 2){
		if($_FILES['image']['name'] != ''){
				$config['upload_path'] = './storage/expenses_images'; 
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
			        redirect('admin/expenses/add', 'refresh');	
				}
				else
				{
					$data = $this->upload->data();
					$uploadedImages['image'] = $data['file_name'];
					
					$attachment = $uploadedImages['image'];
					$attachment1 = 'storage/expenses_images/'.$uploadedImages['image'];
					//$config_image = array();
					$config_image = array(
					  'image_library' => 'gd2',
					  'source_image' => './storage/expenses_images'.$attachment,
					  'new_image' => './storage/expenses_images'.$attachment,
					 // 'width' => 297,
					  //'height' => 302,
					  'maintain_ratio' => FALSE,
					  'rotate_by_exif' => TRUE,
					  'strip_exif' => TRUE,
					);					
					$this->load->library('image_lib', $config_image);
					$this->image_lib->resize();
					$this->image_lib->clear();
				 }
			}else{
			  $attachment1='';
			}
		}else{
			  $attachment1='';
			}

		$payment_mode=$this->common_model->get_table_row('payment_modes',array('id'=> $this->input->post('payment_mode_id')),array('id,attachment_id'));
		
		$data=array(
						
						'state_id'=> $this->input->post('state_id'),
						'organisation_id'=> $this->input->post('organisation_id'),
						'center_id'=> $this->input->post('center_id'),
						'amount_paid_date'=> $this->input->post('date'),
						'category_id'=> $this->input->post('category_id'),
						'paid_for'=> $this->input->post('paid_for'),
						'paid_to'=> $this->input->post('paid_to'),
						'image_type'=>$this->input->post('image_type'),
						'amount'=> $this->input->post('amount'),
						'payment_mode_id'=> $this->input->post('payment_mode_id'),
						'attachment_id'=>$payment_mode['attachment_id'],
						'transcation_id'=> $this->input->post('transaction_id'),
						'remarks'=> $this->input->post('remarks'),
						
				    );
			//echo '<pre>';print_r($data);exit;
		if($id == "")
		{	
			$data['date'] = date('Y-m-d');
			$data['created_on'] = date('Y-m-d H:i:s');
			//$data['amount_paid_date'] = $this->input->post('date');
			if($this->input->post('image_type') == 2){
			$data['attachment'] = base_url().$attachment1;
			}else{
			$data['attachment'] = $this->input->post('image_path');
			}
			$data['image_type'] = $this->input->post('image_type');
			$data['created_by'] = $this->session->userdata('user_id');
			$result=$this->my_model->update_record($data,$id);
			if($result){
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/expenses/add/'.$param, 'refresh');		
			  }else{
			$this->session->set_flashdata('error', 'Record added Failed!.');
			redirect('admin/expenses/add/'.$param, 'refresh');	
			  }	
		}else{

			if($attachment1 != ''){
				$res=$this->common_model->get_table_row('expenses',array('id'=>$id),array('attachment'));
				$file = $res['attachment'];
				if(is_file($file))
				unlink($file);
			    $data['attachment'] = base_url().$attachment1;
			}
			if($this->input->post('image_type') == 1){
			$data['attachment'] = $this->input->post('image_path');
			}
			
			$data['modified_on'] = date('Y-m-d H:i:s');
			$data['modified_by'] = $this->session->userdata('user_id');
			$result1=$this->my_model->update_record($data, $id);
			if($result1){
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/expenses/edit/'.$id, 'refresh');
			}else{
			$this->session->set_flashdata('error', 'Record Updated Failed!.');
			redirect('admin/expenses/edit/'.$id, 'refresh');
			}
		}	
		

	}

	public function change_status($user_id,$state_id,$org_id,$center_id,$status)
	{
		if($this->my_model->change_status($user_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/expenses/expenses_list/'.$state_id.'/'.$org_id.'/'.$center_id, 'refresh');
	}

	public function bulk_upload_expenses(){

		$this->setHeaderFooter($this->bulk_upload_expense_page,$this->data);	

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
											 $this->my_model->insertExpenses($line);	
											  	
											}
																
																
									fclose($csvFile);

									$this->session->set_flashdata('success', 'Excel upload Sucessfully...');
									redirect(base_url('admin/expenses'));
											}else{
									$this->session->set_flashdata('error', 'Some problem occurred, please try again...');
								    redirect(base_url('admin/expenses'));
											}
						}else{
							$this->session->set_flashdata('error', 'Please upload a valid CSV file....');
							redirect(base_url('admin/expenses'));
						}
    
		}	
	}

	public function filedownload(){
		$file = './assets/excel-files/expenseuploadreference.csv'; 
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
	public function delete_expense($id){
		
		if($this->my_model->delete_expense($id) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/expenses/expenses_list', 'refresh');

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