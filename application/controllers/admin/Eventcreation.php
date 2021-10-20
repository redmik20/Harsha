<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Eventcreation extends CI_Controller {

	public $header_page= 'admin/includes/header';
	public $footer_Page= 'admin/includes/footer';
	public $leftMenu  = 'admin/includes/left_menu';
	public $list_Page = 'admin/event/list_events';
	public $add_Page =  'admin/event/add_eventcreate';	
	public $edit_Page = 'admin/event/edit_event';
	public $pdf_file_Page =  'admin/event/pdf_event_file';
	public $ajax_StockPage = 'admin/event/ajax_StockPage';
	
	public function __construct()
	{
	parent::__construct();
	$this->load->model('admin/Eventcreation_model','my_model');
	$this->load->model('Common_model','common_model');
	checkAdminLogin();
	 if($this->session->userdata('user_id') != 'ADM0001'){
	 $this->data['roleResponsible'] = $this->common_model->get_responsibilities();
     }else{
	 $this->data['roleResponsible'] = $this->common_model->get_default_responsibilities();
	 }
	 error_reporting(0);
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
		$batch_ids=explode(',',$this->data['record']['batch_ids']);
		$db_data=array(
			'state_id' => $this->data['record']['state_id'],
			'organisation_id'=>$this->data['record']['organisation_id'],
			'center_id'=>$this->data['record']['center_id'],
			'course_id'=>$this->data['record']['course_id'],
			'batch_id'=>$batch_ids,
		);

		$this->data['in_stock']=$this->my_model->get_instock_data($db_data);

		 $this->setHeaderFooter($this->edit_Page,$this->data);
	}

	public function update_records(){

		
		//echo '<pre>';print_r($_POST);exit;

		$id=$this->input->post('id');
		
		$mobile_numbers= implode(',',$this->input->post('mobile_numbers'));
		$batch_ids= implode(',',$this->input->post('batch_ids'));
		if($this->input->post('stock_included') == 'yes'){
			$in_stock_id=$this->input->post('in_stock_id');
			$db_record=$this->common_model->get_table_row('stockdepartment',array('id'=> $in_stock_id),array('id,count'));
			$in_stock_count=$db_record['count'];
		}else{
			$in_stock_id=0;
			$in_stock_count=0;
		}
		$data=array(
						
						'state_id'=> $this->input->post('state_id'),
						'organisation_id'=> $this->input->post('organisation_id'),
						'center_id'=> $this->input->post('center_id'),
						'course_id'=> $this->input->post('course_id'),
						'batch_ids'=>$batch_ids,
						'event_name'=> $this->input->post('event_name'),
						'stock_included'=> $this->input->post('stock_included'),
						'in_stock_id'=> $in_stock_id,
						'in_stock_count'=> $in_stock_count,
						'start_date'=> $this->input->post('start_date'),
						'start_time'=> $this->input->post('start_time'),
						'end_date'=> $this->input->post('end_date'),
						'end_time'=> $this->input->post('end_time'),
						'location'=> $this->input->post('location'),
						'mobile_numbers'=> $mobile_numbers,

				    );
			
		if($id == "")
		{
			$data['event_unique_id'] = getDynamicId('event_no','EVT');
			$data['created_on'] = date('Y-m-d H:i:s');
			$data['created_by'] = $this->session->userdata('user_id');
			$event_name=$this->input->post('event_name');
			$start_date= date("d-m-Y", strtotime($this->input->post('start_date')));
			$start_time=date("g:i a", strtotime($this->input->post('start_time')));
			$batch_names= $this->my_model->getbatchnames($this->input->post('batch_ids'));
			//echo '<pre>';print_r($data);exit;
			/*--Start QR code-Generation--*/
			$this->load->library('ciqrcode');
	        $params['data'] = $data['event_unique_id'].'##'.$event_name.'##'.$start_date.'##'.$batch_names;
	        $params['level'] = 'H';
	        $params['size'] = 10;
	        $params['savename'] = FCPATH.'storage/eventqrcodes/'.$data['event_unique_id'].'.png';
	        $this->ciqrcode->generate($params);
			$qrcode_path='storage/eventqrcodes/'.$data['event_unique_id'].'.png';
			/*--End QR code-Generation--*/

			$data['qrcode_path']=$qrcode_path;
			$result=$this->my_model->update_record($data,$id);
			if($result){
				/* --start Generate PDF--*/
			$this->save_pdf($data['event_unique_id'],$this->input->post('mobile_numbers'),$batch_names,$start_date,$start_time,$event_name,'add');
				/* --stop Generate PDF--*/
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/eventcreation/add', 'refresh');		
			  }else{
			$this->session->set_flashdata('error', 'Record added Failed!.');
			redirect('admin/eventcreation/add', 'refresh');	
			  }	
		}else{
			
			$data['modified_on'] = date('Y-m-d H:i:s');
			$data['modified_by'] = $this->session->userdata('user_id');
			$event_name=$this->input->post('event_name');
			$start_date= date("d-m-Y", strtotime($this->input->post('start_date')));
			$start_time=date("g:i a", strtotime($this->input->post('start_time')));
			$batch_names= $this->my_model->getbatchnames($this->input->post('batch_ids'));

			$db_record=$this->common_model->get_table_row('events',array('id'=> $id),array('event_unique_id'));
			$result1=$this->my_model->update_record($data, $id);
			if($result1){

			/*--Start QR code-Generation--*/
			$this->load->library('ciqrcode');
	        $params['data'] = $db_record['event_unique_id'].'$#'.$event_name.'$#'.$start_date.'$#'.$batch_names;
	        $params['level'] = 'H';
	        $params['size'] = 10;
	        $params['savename'] = './storage/eventqrcodes/'.$db_record['event_unique_id'].'.png';
	        $this->ciqrcode->generate($params);
			$qrcode_path='storage/eventqrcodes/'.$db_record['event_unique_id'].'.png';
			/*--End QR code-Generation--*/

				/* --start Generate PDF--*/
			$this->save_pdf($db_record['event_unique_id'],$this->input->post('mobile_numbers'),$batch_names,$start_date,$start_time,$event_name,'update');
				/* --stop Generate PDF--*/
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/eventcreation/edit/'.$id, 'refresh');
			}else{
			$this->session->set_flashdata('error', 'Record Updated Failed!.');
			redirect('admin/eventcreation/edit/'.$id, 'refresh');
			}
		}	
	}

	public function save_pdf($event_unique_id,$mobile_numbers,$batch,$start_date,$start_time,$schedule,$type)
		 { 

		 	$data['event']=$this->my_model->getEventdata($event_unique_id);
		 	//echo '<pre>';print_r($data['event']);exit;
		 	$path=''; $full_path='';
			//load mPDF library
		 	$this->load->library('M_pdf'); 
		 	$html=$this->load->view($this->pdf_file_Page,$data,true);
		 	$pdfFilePath = $event_unique_id.".pdf"; 
			$this->m_pdf->pdf->WriteHTML($html);
		 	//download it D save F.
			$this->m_pdf->pdf->Output("./storage/eventpdfs/".$pdfFilePath, "F");
			$path= "storage/eventpdfs/".$pdfFilePath;
			$full_path=base_url().$path;
		 	$update_path=array('event_pdf_path' => $path);
			$this->db->update('events',$update_path,array('event_unique_id' => $event_unique_id));

			if($type == 'add'){
			$message='Dear User,The Schedule is confirmed for '.$batch.' , '.$start_date.' '.$start_time.' , '.$schedule.' ,For QR Code click on this link '.$full_path.' ';
			}else{
			$message='Dear User,The Schedule is updated and confirmed for '.$batch.' , '.$start_date.' '.$start_time.' , '.$schedule.' ,For QR Code click on this link '.$full_path.' ';
			}
			
				foreach($mobile_numbers as $mobile){
					SendSMS($mobile,$message);
				}
			
		 }

	function download_event_pdf($id)
    {

    	$event=$this->common_model->get_table_row('events',array('id'=>$id),array());
        $file_name= $event['event_pdf_path'];

        $this->load->helper('download');
        $data = file_get_contents($file_name);
        $name = $event['event_unique_id'].".pdf"; // custom file name for your download

        force_download($name, $data);
        //force_download($file_name, NULL); will get the file name for you
	}

	public function view(){

    	$this->setHeaderFooter($this->add_Page,$this->data);
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
		redirect('admin/eventcreation', 'refresh');
	}

	public function getstockdata(){
		//echo '<pre>';print_r($_POST);exit;

		$post_data=array(
			'state_id' => $this->input->post('state_id'),
			'organisation_id'=>$this->input->post('organisation_id'),
			'center_id'=>$this->input->post('center_id'),
			'course_id'=>$this->input->post('course_id'),
			'batch_id'=>$this->input->post('batch_id'),
		);
		$this->data['in_stock']=$this->my_model->get_instock_data($post_data);

		echo $this->load->view($this->ajax_StockPage,$this->data,TRUE);
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