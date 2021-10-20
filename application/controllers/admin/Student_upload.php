<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Student_upload extends CI_Controller {


	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $bulk_upload_Page = 'admin/student/student_bulk_upload';

	public function __construct()
	{
	parent::__construct();
	
	$this->load->model('admin/Student_upload_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	 
	}

	public function index(){

		$this->data['states']=$this->common_model->get_table('states',array('status'=>'Active'),array(),'state','asc');
		$this->setHeaderFooter($this->bulk_upload_Page,$this->data);
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
											 $result=$this->my_model->insertStudent($line);		
											}
																
																
											fclose($csvFile);

									$this->session->set_flashdata('success', 'Excel upload Sucessfully...');
									redirect(base_url('admin/student_upload'));
											}else{
									$this->session->set_flashdata('error', 'Some problem occurred, please try again...');
								    redirect(base_url('admin/student_upload'));
											}
						}else{
							$this->session->set_flashdata('error', 'Please upload a valid CSV file....');
							redirect(base_url('admin/student_upload'));
						}
    
		}
        
	}

	public function filedownload(){
		$file = './assets/excel-files/studentuploadreference.csv'; 
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