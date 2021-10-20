<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");		
		$this->is_logged_in();
		$this->load->model('admin/registermodel');
		$this->load->model('common_model');
		$this->load->helper('url','form','HTML');
		$this->load->helper('common_helper');
        $this->load->library(array('form_validation', 'session'));
	}

	
	/*----------- users --------------*/
	public function download_allUsers(){		//*****  Status change *****//
		//$this->load->database();
		
		/*$query="select u.name,u.mobile,u.email_id,u.gender,u.location,u.college,u.status,u.created_on,GROUP_CONCAT(ue.exam_id) left join users_exams ue on ue.user_id=u.id where u.delete_status=1";
		echo $query;exit;
		$query = $this->db->query($query)->get();
		$this->load->helper('csv');
		$users='users_list';
		query_to_csv($query, TRUE, $users.'-'.date("m-d-Y").'.csv');	*/

		$fileName = 'data-'.time().'.xlsx';  
        // load excel library

        $this->load->library('excel');
        $listInfo = $this->registermodel->usersList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'UserName');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Mobile');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Email ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Location');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'College');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Created On');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Course Names');       
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Payment Type');
       // $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'End time');

        // set Row
        $rowCount = 2;
        foreach ($listInfo as $list) {
        	
        	
        	$exam_ids=$this->registermodel->get_examIds($list['id']);
        	$exams=$this->registermodel->getExams($exam_ids);
        	//$examsp=$this->registermodel->getExamPaymetTypes($exam_ids,$list['id']);
//echo '<pre>';print_r($exam_ids);
        	$ste1=array();
			if(!empty($exam_ids)){
				foreach($exam_ids as $ste){
						$ste1[]= $ste['payment_type'];
				}
			$ste2=implode(',',$ste1);
			}else{ $ste2='';
				//echo '<pre>';print_r();exit;
			}
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list['mobile']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['email_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['location']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list['college']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['status']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['created_on']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $exams['course_names']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $ste2);
           // $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $list['out_time']);
            $rowCount++;
        }
        $filename = "UsersList". date("Y-m-d-H-i-s").".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output');
	}

	public function all_users()
	{
        $users = $this->registermodel->all_users($_POST);
        $result_count=$this->registermodel->all_users($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($users) ),
            "data"  => $users);  
        echo json_encode($json_data);
    }
    
    public function serach_users(){
		$search=  $this->input->post('username');
		$query = $this->registermodel->getUsers($search);
		echo json_encode ($query);
	   }

    public function checkUserEmail(){

    	$useremail=$_POST['useremail'];
    	$result=$this->registermodel->check_useremail($useremail);
    	echo $result;
    }

   public function checkUserMobile(){

    	$mobilenumber=$_POST['mobilenumber'];
    	$result=$this->registermodel->check_usermobile($mobilenumber);
    	echo $result;

    }
    public function upload_csv_users()
	{
		$data['title'] = "Abhaya";
		$data['exams'] = $this->registermodel->get_mainexams();
		$data['subjects'] = $this->registermodel->get_mainsubjects();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/upload_csv_users', $data);
		$this->load->view('admin/includes/footer', $data);
	} 

	public function add_users()
	{
		$data['title'] = "Abhaya";
		$data['exams'] = $this->registermodel->get_mainexams();
		$data['subjects'] = $this->registermodel->get_mainsubjects();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_users', $data);
		$this->load->view('admin/includes/footer', $data);
	} 

	public function edit_users($id)
	{
		$data['title'] = "Abhaya";
		$data['exams'] = $this->registermodel->get_mainexams();
		$data['subjects'] = $this->registermodel->get_mainsubjects();
		$data['user'] = $this->registermodel->get_user_data($id);
		$data['user_exams'] = $this->registermodel->get_user_exams($id);
		$data['pacakages']=$this->registermodel->get_packages();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/edit_user', $data);
		$this->load->view('admin/includes/footer', $data);
	}    

    public function view_user($user_id)
	{		
		$data['title'] = "Education";
		$data['user_details'] = $this->registermodel->user_details($user_id);
		//echo '<pre>';print_r($data['user_details']);exit;
		$data['user_exams'] = $this->registermodel->get_user_exams($user_id);
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/view_user', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function users()
	{		
		$data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_users', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function viewUserExams($user_id){
		$data['title'] = "Education";
		$data['user_exmas']=$this->registermodel->getUserExams($user_id);
		//echo '<pre>';print_r($data['user_exmas']);exit;
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_usersexams', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_users()
	{
           
       $config['upload_path']          = './storage/pdfs';
		$config['allowed_types']        = 'pdf|jpg|png|gif';
		$config['max_size']             = 2000;
        
        $this->load->library('upload', $config);

        if($this->upload->do_upload('image')){
			$imgdata = $this->upload->data();
			$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
		}else{
			$imgurl = $this->input->post('imgurl');
		}
		$course_ids=$this->input->post('course_ids');
		$payment_type=$this->input->post('payment_type');
		//echo '<pre>';print_r($course_ids);
		//echo '<pre>';print_r($payment_type);exit;
		$data = array(		
			'name' => $this->input->post('user_name'),
			'email_id' => $this->input->post('user_email'),
			'mobile' => $this->input->post('user_mobile'),
			'password'=>  md5($this->input->post('cnf_password')),
			'gender'=> $this->input->post('gender'),
			'status'=> $this->input->post('status'),
			'college'=>$this->input->post('college'),
			'location'=>$this->input->post('location'),
			'image' => $imgurl,
			'adding_through'=> 2
			);
		//var_dump($data);exit;c
		//echo '<pre>';print_r($data );

		if($this->input->post('user_id') == "")
		{
             $mobile=$this->registermodel->check_usermobile($this->input->post('user_mobile'));
            if($mobile == 0){  
			//$email=$this->registermodel->check_useremail($this->input->post('user_email'));
		//if($email == 0){
					$data['created_on'] = date('Y-m-d H:i:s');	
			    	$this->db->insert('users',$data);
			    	$user_id=$this->db->insert_id();
			    	/*if(!empty($course_ids)){
			    		//echo '<pre>';print_r($course_ids);exit;
			    		foreach($course_ids as $key=>$cousre){
			    				$inerst_data = array('exam_id' => $cousre,
			    									 'user_id'=>$user_id,
			    									 'payment_type'=>$payment_type[$key],
			    									 'delete_status'=> 1,
			    									 'status'=>'Active',
			    									 'created_on'=>date('Y-m-d H:i:s')
			    									 );
			    				$this->db->insert('users_exams',$inerst_data);
			    		}
			    	}*/
			    	/*if($this->input->post('package_id') != ''){
			    		$coupon_code=$this->input->post('coupon_code');
			    		$receipt_id=$this->input->post('receipt_id');
			    	    $this->registermodel->addPackageToUser($this->input->post('package_id'));
			    		}*/
					$this->session->set_flashdata('success', 'Record added Successfully.');
					redirect('admin/register/users', 'refresh');
				/*}else{
					$this->session->set_flashdata('success', 'Email already exists.');
					redirect('admin/register/add_users', 'refresh');
				}*/
	        }else{
             	$this->session->set_flashdata('success', 'Mobile number already exists.');
				redirect('admin/register/add_users', 'refresh');
             }
		
		}
		else
		{
		 $res=$this->common_model->get_table_row('users',array('id'=>$this->input->post('user_id')),array());
		 //echo '<pre>';print_r($res);exit;
		 if($imgurl == ''){
			$data['image']= $res['image'];
		 }else{
				$file = './'.$res['image'];
				if(is_file($file))
				unlink($file);
		 }

		

		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['package_id']=$this->input->post('package_id');
		$this->db->where('id',$this->input->post('user_id'));
		$this->db->update('users',$data) ;
		/*if(!empty($course_ids)){
	    		
			$this->db->where('user_id',$this->input->post('user_id'));
			$this->db->delete('users_exams');
	    		foreach($course_ids as $key=>$cousre){
	    			foreach($payment_type as $ptype){
	    				$ptype_course=explode('_',$ptype);
	    			if($cousre == $ptype_course[0]){
	    				$payment_type1=$ptype_course[1];
	    			}
	    		}
	    		//echo '<pre>';print_r($payment_type1);exit;
	    				$inerst_data = array('exam_id' => $cousre,
	    									 'user_id'=>$this->input->post('user_id'),
	    									 'payment_type'=>$payment_type1,
	    									 'delete_status'=> 1,
	    									 'status'=>'Active',
	    									 'created_on'=>date('Y-m-d H:i:s')
	    									 );
	    				$this->db->insert('users_exams',$inerst_data);
	    		}
	    	}*/
		
		if($this->input->post('package_id') != ''){
			    		$post_data=array(
			    			'coupon_code'=>$this->input->post('coupon_code'),
				    		'order_id' =>$this->input->post('order_id'),
				    		'user_id' =>$this->input->post('user_id'),
				    		'price_id' =>$this->input->post('price_id'),
				    		'final_paid_amount'=>$this->input->post('final_paid_amt'),
				    		'package_id'=>$this->input->post('package_id'),
				    		'message'=>$this->input->post('message'),
			    		);

			    	    $this->registermodel->addPackageToUser($post_data);
			    		}
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_users/'.$this->input->post('user_id'), 'refresh');
		}			
	}


	public function delete_user($user_id)
	{
		if($this->registermodel->delete_user($user_id) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/users', 'refresh');
	}

		/* --start un register users--- */
	public function all_unregister_users()
	{
        $users = $this->registermodel->all_unregister_users($_POST);
        $result_count=$this->registermodel->all_unregister_users($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($users) ),
            "data"  => $users);  
        echo json_encode($json_data);
    }



   public function unregister_users()
	{		
		$data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_unregister_users', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function all_free_package_users()
	{
        $users = $this->registermodel->all_free_package_users($_POST);
        $result_count=$this->registermodel->all_free_package_users($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($users) ),
            "data"  => $users);  
        echo json_encode($json_data);
    }

	public function free_package_users()
	{		
		$data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_free_package_users', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function all_course_intrested_users()
	{
        $users = $this->registermodel->all_course_intrested_users($_POST);
        $result_count=$this->registermodel->all_course_intrested_users($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($users) ),
            "data"  => $users);  
        echo json_encode($json_data);
    }

	public function course_intrested_users()
	{		
		$data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/course_intrested_users_lists', $data);
		$this->load->view('admin/includes/footer', $data);
	}
    
        /* --stop un register users--- */

        /* --start online users--- */
	public function all_online_users()
	{
        $users = $this->registermodel->all_online_users($_POST);
        $result_count=$this->registermodel->all_online_users($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($users) ),
            "data"  => $users);  
        echo json_encode($json_data);
    }

   public function online_users()
	{		
		$data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_online_users', $data);
		$this->load->view('admin/includes/footer', $data);
	}
    
        /* --stop online users--- */
	
	
	public function ChangePassword()
	{
			$id=$this->session->userdata('admin_id');
			
			$data['row']=$this->registermodel->get_admin_details($id);
            $data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/change_password', $data);
		$this->load->view('admin/includes/footer', $data);
	}
	
	public function UpdatePassword()
	{
	    $password=md5($this->input->post('password'));
	    
	    $id=$this->session->userdata('admin_id');
	    $data=array('password'=>$password);
		if($this->registermodel->updatepassword($data,$id) == true)
		{
			$this->session->set_flashdata('success', 'Password Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('success', 'Error in Updating.');
		}
		redirect('admin/register/ChangePassword', 'refresh');
	}


	public function change_user_status($user_id, $status)
	{
		if($this->registermodel->change_user_status($user_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/users', 'refresh');
	}

	/*----------- /users --------------*/

	/*----------- exams --------------*/

	public function all_exams()
	{
        $exams = $this->registermodel->all_exams($_POST);
        $result_count=$this->registermodel->all_exams($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($exams) ),
            "data"  => $exams);  
        echo json_encode($json_data);
    }

	public function exams()
	{		
		$data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_exams', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_exams()
	{
		$data['title'] = "Education";						
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_exams', $data);
		$this->load->view('admin/includes/footer', $data);
	}
	public function assignCourseToUser($course_id){

		$data['title'] = "Education";	
		$data['course_id']=$course_id;	
		$data['users']=$this->registermodel->getUserswithCourse($course_id);	
		//echo '<pre>';print_r($data['users']);exit;	
		if($this->input->post('user_name') !=''){
			//echo '<pre>';print_r($_POST);exit;

			$users=$this->input->post('user_name');
			foreach($users as $user){

				$check_user=$this->registermodel->checkUserswithCourse($course_id,$user);

				if(empty($check_user)){
						$insert_data=array(
							'user_id'=> $user,
							'exam_id'=>$course_id,
							'delete_status'=>1,
							'status'=>'Active',
							'created_on'=>date('Y-m-d H:i:s')
						);
				$this->db->insert('users_exams',$insert_data);		
				}
			}

			$this->session->set_flashdata('success', 'Course assign to user Successsfully');
			redirect('admin/register/assignCourseToUser/'.$course_id, 'refresh');

		}		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/assign_coursetouser', $data);
		$this->load->view('admin/includes/footer', $data);
	}
	public function update_exams()
	{
	    /*$image=$_FILES['image'];
	    $imgurl='';
	    if($image['name']!=''){
		$config['upload_path']          = './storage/pdfs';
		$config['allowed_types']        = 'jpg|png|gif|jpeg';
		$config['max_size']             = 2000;

	   $this->load->library('upload', $config);
		
		
	   if($this->upload->do_upload('image')){
			$imgdata = $this->upload->data();
			$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
		}else{
			//$imgurl = $this->input->post('imgurl');
			
			$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
			if($this->input->post('exam_id') == "")
		{
			redirect('admin/register/add_exams', 'refresh');
		}else{
		    redirect('admin/register/edit_exams/'.$this->input->post('exam_id'));
		}
		}
		
	    }*/
		$data = array(
			'name' => $this->input->post('name'),
			'image' => $this->input->post('image'),
			'order' => $this->input->post('order'),
			'price' => $this->input->post('price'),
			'discount_price' => $this->input->post('discount_price'),
		);
		/*if($imgurl!=''){
		    $data['image']=$imgurl;
		}*/
		
		//var_dump($data);exit;
		if($this->input->post('exam_id') == "")
		{
			$data['created_on'] = date('Y-m-d H:i:s');		
			$this->registermodel->insert_exams($data);
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/register/add_exams', 'refresh');
			//echo $this->db->last_query();exit;				
		}
		else
		{
			$data['modified_on'] = date('Y-m-d H:i:s');
			$this->registermodel->update_exams($data, $this->input->post('exam_id'));
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/register/edit_exams/'.$this->input->post('exam_id'), 'refresh');
		}	
	}

	public function edit_exams()
	{
		$data['title'] = "Education";
		if($query = $this->registermodel->edit_exams())
		{
			$data['row'] = $query;
		}		
		//var_dump($data['row']);		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/edit_exams', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function delete_exams()
	{
		if($this->registermodel->delete_exams() == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/exams', 'refresh');
	}

	public function change_exam_status($user_id, $status)
	{
		if($this->registermodel->change_exam_status($user_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/exams', 'refresh');
	}
		
	/*----------- /exams --------------*/



/*----------- subjects --------------*/

	public function all_subjects()
	{
        
      $subjects = $this->registermodel->all_subjects($_POST);
  	  $result_count=$this->registermodel->all_subjects($_POST,1);
      $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($subjects) ),
            "data"  => $subjects);  
        echo json_encode($json_data);
    }

	public function subjects()
	{
		$data['title'] = "Education";		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_subjects', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_subjects()
	{
		$data['title'] = "Education";
		$data['exams'] = $this->registermodel->get_exams();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_subjects', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_subjects()
	{
        
		/*$config['upload_path']          = './storage/pdfs';
		$config['allowed_types']        = 'jpg|png|gif|jpeg';
		$config['max_size']             = 20000;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$image=$_FILES['image'];
        $icon=$_FILES['icon'];
 
            $imgurl='';
            $iconurl='';

         if($image['name']!=''){
	   if($this->upload->do_upload('image')){
			$imgdata = $this->upload->data();
			$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
		}else{
			//$imgurl = $this->input->post('imgurl');
			$this->session->set_flashdata('success', $this->upload->display_errors());
			if($this->input->post('subject_id') == ""){
			redirect('admin/register/subjects', 'refresh');
			}else{
			    redirect('admin/register/edit_subjects/'.$this->input->post('subject_id'), 'refresh');
			}
			
		}
		
         }
         
         
if($icon['name']!=''){
		if($this->upload->do_upload('icon')){
			$imgdata = $this->upload->data();
			$iconurl = 'storage/pdfs/'.$imgdata['file_name'];
		}else{
			//$iconurl = $this->input->post('iconurl');
			$this->session->set_flashdata('success', $this->upload->display_errors());
			if($this->input->post('subject_id') == ""){
			redirect('admin/register/subjects', 'refresh');
			}else{
			    redirect('admin/register/edit_subjects/'.$this->input->post('subject_id'), 'refresh');
			}
		}
		
}*/
     	$category_values=implode(',',$this->input->post('category_values'));
		$data = array(
			'exam_id' => $this->input->post('exam_id'),
       		'subject_name' => $this->input->post('subject_name'),
         	'category_values' => $category_values,
         	'image' => $this->input->post('image'),
         	'icon' => $this->input->post('icon'),
         	'order' => $this->input->post('order'),
         	'videos_count' => $this->input->post('videos_count'),
			);
			/*if($imgurl!=''){
			    $data['image']=$imgurl;
			}
			if($iconurl!=''){
			    $data['icon']=$iconurl;
			}*/


		if($this->input->post('subject_id') == "")
		{			
	
			$data['created_on'] = date('Y-m-d H:i:s');	
			if($this->registermodel->insert_subjects($data)) { // kvkb added if condition
				$this->session->set_flashdata('success', 'Record added Successfully.');
				redirect('admin/register/subjects', 'refresh');
			}
		}
		else
		{

		
			/*if($imgurl!=''){
			    $data['image']=$imgurl;
			}
			if($iconurl!=''){
			    $data['icon']=$iconurl;
			}*/

			$data['modified_on'] = date('Y-m-d H:i:s');
			$this->registermodel->update_subjects($data, $this->input->post('subject_id'));
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/register/edit_subjects/'.$this->input->post('subject_id'), 'refresh');
		}		
	}

	public function edit_subjects()
	{
		$data['title'] = "Education";
		if($query = $this->registermodel->edit_subjects())
		{
			$data['row'] = $query;
		}
		$data['exams'] = $this->registermodel->get_exams();
		$data['subjects'] = $this->registermodel->gets_subjects();		
		//var_dump($data['row']);	exit();	
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/edit_subjects', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function delete_subjects()
	{
		if($this->registermodel->delete_subjects() == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/subjects', 'refresh');
	}

public function change_event_type_to_recommended($subject_id, $recommended)
	{
		if($this->registermodel->change_event_type_to_recommended($subject_id, $recommended) == true)
		{
			$this->session->set_flashdata('success', 'Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/subjects', 'refresh');
	} 


		public function chapterdemo_details($chapter_id)
	{		
		$data['title'] = "Education";
		$data['chapterdemo_details'] = $this->registermodel->chapterdemo_details($chapter_id);
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/chapterdemo_details', $data);
		$this->load->view('admin/includes/footer', $data);
	}
		


	public function subjectinfo()
	{
		$course_id = $this->input->post('course_id');
		$subject_id = $this->input->post('subject_id');
		$subjects = $this->input->post('subjects');
		if($course_id != ''){
			$html = '';
			$data['subjects'] = $this->registermodel->get_submain($exam_id);
			$html = '<option value="">Select Hostel</option>';
      
		  if(!empty($data['
		  ']))
	      {
	        foreach($data['subjects'] as $subject)
	        {
	         $html.='<option value='.$subject['id'].'>'.$subject['subject_name'].'</option>';
	        }
	      }
            echo $html;
		}

	}

	/*----------- /subjects --------------*/

	/*----------- Video chapters--------------*/

	public function all_videochapters()
	{
        
      $videochapters = $this->registermodel->all_videochapters($_POST);
  	  $result_count=$this->registermodel->all_videochapters($_POST,1);
      $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($videochapters) ),
            "data"  => $videochapters);  
        echo json_encode($json_data);
    }

	public function videochapters()
	{
		$data['title'] = "Abhaya";		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_videochapters', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_videochapters()
	{
		$data['title'] = "Abhaya";
		$data['exams'] = $this->registermodel->get_mainexams();
		$data['subjects'] = $this->registermodel->get_mainsubjects();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_videochapters', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_videochapters()
	{
		/*$banner_image=$_FILES['banner_image'];

		if($banner_image['name']!=''){
			$config['upload_path']          = './storage/videochapters';
		    $config['allowed_types']        = 'pdf|jpg|png|gif|jpeg';
			$config['max_size']             = 2000;
	        $this->load->library('upload',$config);
	        $this->upload->initialize($config);
	        if($this->upload->do_upload('banner_image')){
				$imgdata = $this->upload->data();
				$image = 'storage/videochapters/'.$imgdata['file_name'];
				
			}else{
				$this->session->set_flashdata('success', $this->upload->display_errors());
				if($this->input->post('videochapter_id') == ""){
				redirect('admin/register/add_videochapters', 'refresh');
				}else{
				    redirect('admin/register/edit_videochapters/'.$this->input->post('videochapter_id'), 'refresh');
				}
			}
		}else{
			$image='';
		}

		$Iconimage=$_FILES['icon_image'];

		if($Iconimage['name']!=''){
			$config['upload_path']          = './storage/videochapters';
		    $config['allowed_types']        = 'pdf|jpg|png|gif|jpeg';
			$config['max_size']             = 2000;
	        $this->load->library('upload',$config);
	        $this->upload->initialize($config);
	        if($this->upload->do_upload('icon_image')){
				$imgdata = $this->upload->data();
				$icon_image = 'storage/videochapters/'.$imgdata['file_name'];
				
			}else{
				$this->session->set_flashdata('success', $this->upload->display_errors());
				if($this->input->post('videochapter_id') == ""){
				redirect('admin/register/add_videochapters', 'refresh');
				}else{
				    redirect('admin/register/edit_videochapters/'.$this->input->post('videochapter_id'), 'refresh');
				}
			}
		}else{
			$icon_image='';
		}*/
		
		
		$data = array(
	   'course_id' => $this->input->post('course_id'),
	   'subject_id' => $this->input->post('subject_id'),
	   'name' => $this->input->post('name'),
	   'title' => $this->input->post('title'),
	   'banner_image'=> $this->input->post('banner_image'),
	   'icon_image'=> $this->input->post('icon_image'),
	   'order'=> $this->input->post('order'),
	   	);

		if($this->input->post('videochapter_id') == "")
		{

		$data['created_on'] = date('Y-m-d H:i:s');	
    	$this->registermodel->insert_videochapters($data);
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/videochapters', 'refresh');
		}
		else
		{
		 /*$res=$this->common_model->get_table_row('videochapters',array('id'=>$this->input->post('videochapter_id')),array());
		 //echo '<pre>';print_r($res);exit;
		 if($image == ''){
			$data['banner_image']= $res['banner_image'];
		 }else{
				$file = './'.$res['banner_image'];
				if(is_file($file))
				unlink($file);
		 }

		 if($icon_image == ''){
			$data['icon_image']= $res['icon_image'];
		 }else{
				$file = './'.$res['icon_image'];
				if(is_file($file))
				unlink($file);
		 }*/

		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_videochapters($data, $this->input->post('videochapter_id'));
		//print_r($this->input->post('topics_id'));exit();
		//	print_r($data);exit();
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_videochapters/'.$this->input->post('videochapter_id'), 'refresh');
		}		
	}


	public function edit_videochapters()
	{
		$data['title'] = "Education";
		$query = $this->registermodel->edit_videochapters();
		$data['exams']=$query;
		$data['courses'] = $this->registermodel->get_mainexams();
		$data['subjects'] = $this->registermodel->get_courseWiseSubjects($query->course_id);
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/edit_videochapters', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function delete_videochapters($id)
	{
		if($this->registermodel->delete_videochapters($id) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		
		redirect('admin/register/videochapters', 'refresh');
	} 

	public function change_videochapters_status($id, $status)
	{
		if($this->registermodel->change_videochapters_status($id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/videochapters', 'refresh');
	}


	public function getVideoChapters()
	{
	
        $course_id = $this->input->post('course_id');
        $subject_id = $this->input->post('subject_id');
        $videoChapters = get_table('videochapters', array('subject_id' => $subject_id,'course_id' => $course_id,'status'=>'Active'));
      //print_r($subjects);exit;
         echo '<option value="">Select Chapter</option>';
        if(!empty($videoChapters))
        {
          foreach($videoChapters as $chapter)
	      { ?>
	     <option value="<?=$chapter['id']?>"><?=$chapter['name']?></option>';
	    <?php  }
	      }
    
	}	
	/*----------- / Video chapters --------------*/

/*----------- chapters --------------*/

	public function all_chapters()
	{
        $chapters = $this->registermodel->all_chapters($_POST);
        $result_count=$this->registermodel->all_chapters($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($chapters) ),
            "data"  => $chapters);  
        echo json_encode($json_data);
    }

	public function chapters()
	{		
		$data['title'] = "Education";		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_chapters', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_chapters()
	{
		$data['title'] = "Education";
		$data['exams'] = $this->registermodel->get_exams();
	    $data['subjects'] = $this->registermodel->get_subjects_videos();				
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_chapters', $data);
		$this->load->view('admin/includes/footer', $data);
	}
	public function change_chapter_status($id, $status)
	{
		if($this->registermodel->change_chapter_status($id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/chapters', 'refresh');
	}
	
	public function get_subject()
           {
        $exam_id = $this->input->post('exam_id');
           //print_r($exam_id);
        //$exams = explode(',', $exam_id);
	    //print_r($query);exit;
		
        //print_r($exams);exit;
         // $where = '(subjects.category_type =1 or subjects.category_type=0)';
      $subjects = get_table('subjects', array('exam_id' => $exam_id,'delete_status'=>1));
      //print_r($subjects);exit;
            echo '<option value="">Select Subjects</option>';
       if(!empty($subjects))
       {
          foreach($subjects as $subject)
      {
     echo '<option value="'.$subject['id'].'">'.$subject['subject_name'].'</option>';
      }
    }
	}

		public function get_Qbank_subject()
           {
        $exam_id = $this->input->post('exam_id');
           //print_r($exam_id);
        //$exams = explode(',', $exam_id);
	    //print_r($query);exit;
		
        //print_r($exams);exit;
         // $where = '(subjects.category_type =1 or subjects.category_type=0)';
      $subjects = get_table('subjects', array('exam_id' => $exam_id,'delete_status'=>1));
      //print_r($subjects);exit;
            echo '<option value="">Select Subjects</option>';
       if(!empty($subjects))
       {
          foreach($subjects as $subject)
      {
     echo '<option value="'.$subject['id'].'">'.$subject['subject_name'].'</option>';
      }
    }
	}

	

	public function get_test_series_categories()
           {
        $exam_id = $this->input->post('exam_id');
           
      $categories = get_table('test_series_categories', array('course_id' => $exam_id));
      //print_r($subjects);exit;
            echo '<option value="">Select Category</option>';
       if(!empty($categories))
       {
          foreach($categories as $cat)
      {
     echo '<option value="'.$cat['id'].'">'.$cat['title'].'</option>';
      }
    }
	}



		public function get_qbank_topics()
           {
        $exam_id = $this->input->post('exam_id');
           
      $categories = get_table('quiz_topics', array('course_id' => $exam_id));
      //print_r($subjects);exit;
            echo '<option value="">Select Category</option>';
       if(!empty($categories))
       {
          foreach($categories as $cat)
      {
     echo '<option value="'.$cat['id'].'">'.$cat['title'].'</option>';
      }
    }
	}

	
    
    public function get_subjectss()
           {
        $exam_id = $this->input->post('exam_id');
        $video_topic_id = $this->input->post('video_topic_id');
           //print_r($exam_id);
        //$exams = explode(',', $exam_id);
	    //print_r($query);exit;
		$idss=$this->registermodel->edit_topicss($video_topic_id);
		//print_r($idss);exit;
        //print_r($exams);exit;
      $subjects = get_table('subjects', array('exam_id' => $exam_id));
      //print_r($subjects);exit;?>
            <option value="">Select Subjects</option>
      <?php if(!empty($subjects))
       {
          foreach($subjects as $subject)
      { ?>
     <option value="<?=$subject['id']?>" <?php if($subject['id']==$idss->subject_id){ echo "selected"; } ?>><?=$subject['subject_name'];?></option>
     <?php }
    }
    }
    
    
        public function get_subjectsss()
           {
        $exam_id = $this->input->post('exam_id');
        $chapters_slides_id = $this->input->post('chapters_slides_id');
           //print_r($exam_id);
        //$exams = explode(',', $exam_id);
	    //print_r($query);exit;
		$idss=$this->registermodel->edit_chapters_slidess($chapters_slides_id);
		//print_r($idss);exit;
        //print_r($exams);exit;
      $subjects = get_table('subjects', array('exam_id' => $exam_id));
      //print_r($subjects);exit;?>
            <option value="">Select Subjects</option>
      <?php if(!empty($subjects))
       {
          foreach($subjects as $subject)
      { ?>
     <option value="<?=$subject['id']?>" <?php if($subject['id']==$idss->subject_id){ echo "selected"; } ?>><?=$subject['subject_name'];?></option>
     <?php }
    }
    }
    public function get_servicess()
           {
               $exam_id = $this->input->post('exam_id');
        $subject_id = $this->input->post('subject_id');
         $video_topic_id = $this->input->post('video_topic_id');
         $idss=$this->registermodel->edit_topicss($video_topic_id);
         //print_r($idss);exit;
           //print_r($exam_id);
        //$exams = explode(',', $exam_id);
        //print_r($exams);exit;
      $services = get_table('chapters', array('subject_id' => $subject_id,'exam_id' => $exam_id));
      //print_r($subjects);exit;
            echo '<option value="">Select Topics</option>';
       if(!empty($services))
       {
          foreach($services as $service)
      { ?>
     <option value="<?=$service['id']?>" <?php if($service['id']==$idss->chapter_id){ echo "selected"; } ?>><?=$service['chapter_name']?></option>';
    <?php  }
    }
    }

 
    
     public function get_servicesss()
           {
               $exam_id = $this->input->post('exam_id');
        $subject_id = $this->input->post('subject_id');
         $chapters_slides_id = $this->input->post('chapters_slides_id');
         $idss=$this->registermodel->edit_chapters_slidess($chapters_slides_id);
         //print_r($idss);exit;
           //print_r($exam_id);
        //$exams = explode(',', $exam_id);
        //print_r($exams);exit;
      $services = get_table('chapters', array('subject_id' => $subject_id,'exam_id' => $exam_id));
      //print_r($subjects);exit;
            echo '<option value="">Select Chapters</option>';
       if(!empty($services))
       {
          foreach($services as $service)
      { ?>
     <option value="<?=$service['id']?>" <?php if($service['id']==$idss->chapter_id){ echo "selected"; } ?>><?=$service['chapter_name']?></option>';
    <?php  }
    }
    }
    
    public function get_services()
           {
               $exam_id = $this->input->post('exam_id');
        $subject_id = $this->input->post('subject_id');
           //print_r($exam_id);
        //$exams = explode(',', $exam_id);
        //print_r($exams);exit;
      $services = get_table('chapters', array('subject_id' => $subject_id,'exam_id' => $exam_id));
      //print_r($subjects);exit;
            echo '<option value="">Select </option>';
       if(!empty($services))
       {
          foreach($services as $service)
      {
     echo '<option value="'.$service['id'].'">'.$service['chapter_name'].'</option>';
      }
    }
    }

	public function update_chapters()
	{
		// echo "<pre>";var_dump($this->input->post());die;
        $image=$_FILES['image'];
        $slideimage=$_FILES['slideimage'];
        //$notespdf=$_FILES['notespdf'];
		$suggest_video_banner=$_FILES['suggest_video_banner'];
		//echo '<pre>';print_r($suggest_video_banner);
        // $video=$_FILES['video'];
         //print_r($image);
         //echo $image['name'];
         //exit;
        $imgurl='';
        $slideimgurl='';
		$fileurl='';
		$videourl='';
		$suggest_video_bannerUrl='';

		$data = array(
			'exam_id' => $this->input->post('exam_id'),
			'subject_id' => $this->input->post('subject_id'),
			'chapter_id' => $this->input->post('video_chapter_id'),
			'video_name' => $this->input->post('video_name'),
			'free_or_paid'=>$this->input->post('free_or_paid'),
			'total_time' => $this->input->post('total_time'),
			'suggested_videos'=>$this->input->post('suggested_videos'),
			'chapter_actorname' => $this->input->post('chapter_actorname'),
			'video_path'=>$this->input->post('video'),
			'youtube_video_url'=>$this->input->post('youtube_video_url'),
			'video_date'=>$this->input->post('video_date'),
			'notespdf_path'=>$this->input->post('notespdf_path'),
			'materialpdf_path'=>$this->input->post('materialpdf_path'),
			'order' => $this->input->post('order'),
		);

        if($image['name']!=''){
			$config['upload_path']          = './storage/pdfs';
			$config['allowed_types']        = 'jpg|png|gif|jpeg';
			$config['max_size']             = 2000;
	        $this->load->library('upload',$config);
	        if($this->upload->do_upload('image')){
				$imgdata = $this->upload->data();
				$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
				$data['image'] = $imgurl;
			}else{
				$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
				if($this->input->post('chapter_id') == ""){
				redirect('admin/register/add_chapters', 'refresh');
				}else{
				    redirect('admin/register/edit_chapters/'.$this->input->post('chapter_id'), 'refresh');
				}
			}
		
        }

        if($suggest_video_banner['name']!=''){
			$config['upload_path']          = './storage/pdfs';
			$config['allowed_types']        = 'jpg|png|gif|jpeg';
			$config['max_size']             = 2000;
	        $this->load->library('upload',$config);
	        if($this->upload->do_upload('suggest_video_banner')){
				$imgdata = $this->upload->data();
				$suggest_video_bannerUrl = 'storage/pdfs/'.$imgdata['file_name'];
				$data['suggest_video_banner'] = $suggest_video_bannerUrl;
			}else{
				$this->session->set_flashdata('success', 'Image is must jpg or png or gif or jpeg format.');
				if($this->input->post('chapter_id') == ""){
				redirect('admin/register/add_chapters', 'refresh');
				}else{
				    redirect('admin/register/edit_chapters/'.$this->input->post('chapter_id'), 'refresh');
				}
			}
		}
        


		/*if($notespdf['name']!=''){
			$config['upload_path']          = './storage/notes';
			$config['allowed_types']        = 'pdf|docx|doc';
			$config['max_size']             = 20000;
	        $this->load->library('upload');
			$this->upload->initialize($config, true);
			
		   if($this->upload->do_upload('notespdf')){
				$imgdata = $this->upload->data();
				$fileurl = 'storage/notes/'.$imgdata['file_name'];
				$data['notespdf'] = $fileurl;
			}else{
				//$imgurl = $this->input->post('imgurl');
				$this->session->set_flashdata('success', 'Notes is must pdf or docx or doc format.');
				if($this->input->post('chapter_id') == ""){
					redirect('admin/register/add_chapters', 'refresh');
				}else{
				    redirect('admin/register/edit_chapters/'.$this->input->post('chapter_id'), 'refresh');
				}
			}
		}*/
   //  	if($video['name']!=''){
	  //       $config['upload_path']          = './storage/videos';
			// $config['allowed_types']        = 'mp4';
			// $config['max_size']             = 100000000;
	  //       $this->load->library('upload');
	  //       $this->upload->initialize($config, true);
	  //       if($this->upload->do_upload('video')){
			// 	$imgdata = $this->upload->data();
			// 	$videourl = 'storage/videos/'.$imgdata['file_name'];
			// 	$data['video_path'] = $videourl;
			// }else{
			// 	//$imgurl = $this->input->post('imgurl');
			// 	$this->session->set_flashdata('success', 'Video is must mp4 format.');
			// 	if($this->input->post('chapter_id') == ""){
			// 		redirect('admin/register/add_chapters', 'refresh');
			// 	}else{
			// 	    redirect('admin/register/edit_chapters/'.$this->input->post('chapter_id'), 'refresh');
			// 	}
			// }
   //  	}
    	$slideimageurls=array();
    	if(!empty($slideimage)){
    		$countfiles=count($slideimage['name']);
    		for ($i=0; $i < $countfiles; $i++) {
    			$imgurl=NULL;
    			if($_FILES['slideimage']['name'][$i]!=""){
    				$_FILES['image']['name'] = $_FILES['slideimage']['name'][$i];
			    	$_FILES['image']['type'] = $_FILES['slideimage']['type'][$i];
			    	$_FILES['image']['tmp_name'] = $_FILES['slideimage']['tmp_name'][$i];
			    	$_FILES['image']['error'] = $_FILES['slideimage']['error'][$i];
			    	$_FILES['image']['size'] = $_FILES['slideimage']['size'][$i];
			    	$config['upload_path']          = './storage/pdfs';
			    	$config['allowed_types']        = 'jpg|png|gif|jpeg';
					$config['max_size']             = 2000;
					$this->load->library('upload',$config);
					if($this->upload->do_upload('image')){
						$imgdata = $this->upload->data();
						$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
						$slideimageurls[]=$imgurl;
					}else{
						$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
						if($this->input->post('chapter_id') == ""){
						redirect('admin/register/add_chapters', 'refresh');
						}else{
						    redirect('admin/register/edit_chapters/'.$this->input->post('chapter_id'), 'refresh');
						}
					}
    			}
    		}
    	}

    	/*$notespdfurls=array();
    	if(!empty($notespdf)){
    		$countfiles1=count($notespdf['name']);
    		for ($i=0; $i < $countfiles1; $i++) {
    			$imgurl=NULL;
    			if($_FILES['notespdf']['name'][$i]!=""){
    				$_FILES['image']['name'] = $_FILES['notespdf']['name'][$i];
			    	$_FILES['image']['type'] = $_FILES['notespdf']['type'][$i];
			    	$_FILES['image']['tmp_name'] = $_FILES['notespdf']['tmp_name'][$i];
			    	$_FILES['image']['error'] = $_FILES['notespdf']['error'][$i];
			    	$_FILES['image']['size'] = $_FILES['notespdf']['size'][$i];
			    	$config['upload_path']          = './storage/pdfs';
			    	$config['allowed_types']        = 'jpg|png|gif|jpeg';
					$config['max_size']             = 2000;
					$this->load->library('upload',$config);
					if($this->upload->do_upload('image')){
						$imgdata = $this->upload->data();
						$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
						$notespdfurls[]=$imgurl;
					}else{
						$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
						if($this->input->post('chapter_id') == ""){
						redirect('admin/register/add_chapters', 'refresh');
						}else{
						    redirect('admin/register/edit_chapters/'.$this->input->post('chapter_id'), 'refresh');
						}
					}
    			}
    		}
    	}*/





    	//echo '<pre>';print_r($notespdfurls);exit;

  //   	if($slideimage['name']!=''){
		// 	$config['upload_path']          = './storage/pdfs';
		// 	$config['allowed_types']        = 'jpg|png|gif|jpeg';
		// 	$config['max_size']             = 2000;
	 //        $this->load->library('upload');
	 //        $this->upload->initialize($config, true);
	 //        if($this->upload->do_upload('slideimage')){
		// 		$imgdata = $this->upload->data();
		// 		$slideimgurl = 'storage/pdfs/'.$imgdata['file_name'];
		// 	}else{
		// 		$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
		// 		if($this->input->post('chapter_id') == ""){
		// 		redirect('admin/register/add_chapters', 'refresh');
		// 		}else{
		// 		    redirect('admin/register/edit_chapters/'.$this->input->post('chapter_id'), 'refresh');
		// 		}
		// 	}
		// }
	if($this->input->post('chapter_id') == "")
	{
     	$data['created_on'] = date('Y-m-d H:i:s');
     	// $chapter_id=1;
     	$chapter_id=insert_table('chapters', $data);
     	if(!empty($slideimageurls)){
	     	foreach ($slideimageurls as $image) {
	     		$data=array(
					'exam_id' => $this->input->post('exam_id'),
					'subject_id' => $this->input->post('subject_id'),
					'chapter_id' => $chapter_id,
					'image'=>$image,
					'chapters_status' => $this->input->post('free_or_paid')
		     	);
		     	$datas[]=$data;
	     	}
	     	insert_table('chapters_slides', $datas, '', true);
     	}

     	/*if(!empty($notespdfurls)){
	     	foreach ($notespdfurls as $image) {
	     		$data=array(
					'exam_id' => $this->input->post('exam_id'),
					'subject_id' => $this->input->post('subject_id'),
					'chapter_id' => $chapter_id,
					'image'=>$image,
					'chapters_status' => $this->input->post('free_or_paid'),
					'created_on' => date('Y-m-d H:i:s')
		     	);
		     	$dataup[]=$data;
	     	}
	     	insert_table('chapters_upload_notes', $dataup, '', true);
     	}*/
     	// $datatopics=array(
     	//     'exam_id' => $this->input->post('exam_id'),
		    // 'subject_id' => $this->input->post('subject_id'),
		    // 'chapter_id' => $chapter_id,
		    // 'topic_name' => $this->input->post('topic_name'),
		    // 'start_time' => $this->input->post('start_time'),
		    // 'free_or_paid' => $this->input->post('free_or_paid')
     	// );
     	$topic_names=$this->input->post('topic_name');
     	//$topic_free_or_paid=$this->input->post('topic_free_or_paid');
     	$start_time=$this->input->post('start_time');
     	for ($i=0; $i <sizeof($this->input->post('topic_name')) ; $i++) { 
     		$datatopic=array(
	     	    'exam_id' => $this->input->post('exam_id'),
			    'subject_id' => $this->input->post('subject_id'),
			    'chapter_id' => $chapter_id,
			    'topic_name' => $topic_names[$i],
			    'start_time' => $start_time[$i],
			    'free_or_paid' => $this->input->post('free_or_paid')
	     	);
	     	$datatopics[]=$datatopic;
     	}
     	// echo "<pre>";var_dump($datatopics);die;
     	$chapter_topic_id=insert_table('video_topics', $datatopics, '', true);
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/chapters', 'refresh');
	}
	else
	{

		$data['modified_on'] = date('Y-m-d H:i:s');
//echo '<pre>';print_r($data);exit;
		update_table('chapters', $data, array('id' => $this->input->post('chapter_id')));
	    if(!empty($slideimageurls)){
	    	delete_record('chapters_slides',array('chapter_id' => $this->input->post('chapter_id')));
	    	foreach ($slideimageurls as $image) {
	    		$slide=array(
			        'exam_id' => $this->input->post('exam_id'),
				    'subject_id' => $this->input->post('subject_id'),
				    'chapter_id' =>$this->input->post('chapter_id'),
				    'image'=>$image,
				    'chapters_status' => $this->input->post('free_or_paid'),
				    'modified_on' => date('Y-m-d H:i:s')
			    );
	    		$slides[]=$slide;
	    	}
	    	insert_table('chapters_slides', $slides, '', true);
	    }

		/*if(!empty($notespdfurls)){
	    	delete_record('chapters_upload_notes',array('chapter_id' => $this->input->post('chapter_id')));
	    	foreach ($notespdfurls as $image) {
	    		$note=array(
			        'exam_id' => $this->input->post('exam_id'),
				    'subject_id' => $this->input->post('subject_id'),
				    'chapter_id' =>$this->input->post('chapter_id'),
				    'image'=>$image,
				    'chapters_status' => $this->input->post('free_or_paid'),
				    'modified_on' => date('Y-m-d H:i:s')
			    );
	    		$uploadN[]=$note;
	    	}
	    	insert_table('chapters_upload_notes', $uploadN, '', true);
	    }*/
	    // update_table('chapters_slides', $datas, array('chapter_id' => $this->input->post('chapter_id')));

	    
	    $topic_names=$this->input->post('topic_name');
     	//$topic_free_or_paid=$this->input->post('topic_free_or_paid');
     	$start_time=$this->input->post('start_time');
     	$video_topic_ids= $this->input->post('video_topic_id');
     	//delete_record('video_topics',array('chapter_id' => $this->input->post('chapter_id')));
     	 //echo '<pre>';print_r($topic_names);
     	 //echo '<pre>';print_r($video_topic_ids);exit();
     	for ($i=0; $i < sizeof($topic_names); $i++) {
     		$data1=array(
		        'exam_id' => $this->input->post('exam_id'),
			    'subject_id' => $this->input->post('subject_id'),
			    'topic_name' => $topic_names[$i],
			    'chapter_id' =>$this->input->post('chapter_id'),
			    'start_time' => $start_time[$i],
			    //'free_or_paid' => $this->input->post('free_or_paid'),
				'created_on' => date('Y-m-d H:i:s')
		    );
		    //$datas[]=$data;
		   if(sizeof($video_topic_ids) > $i){
		   $this->db->update('video_topics',$data1,array('id'=>$video_topic_ids[$i]));
			}else{
		   $this->db->insert('video_topics',$data1);	
			}
     		
     	}
     	//insert_table('video_topics', $datas, '', true);
	    // echo $this->db->last_query();die();
	    // $this->registermodel->update_chapters_slides($datas,$this->input->post('chapter_id'));
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_chapters/'.$this->input->post('chapter_id'), 'refresh');
		}		
	}

	public function delete_video_topic($video_topic_id,$video_id){
		$this->db->where('id',$video_topic_id);
		$this->db->delete('video_topics');
		$this->session->set_flashdata('success', 'Record Deleted Successfully.');
		redirect('admin/register/edit_chapters/'.$video_id, 'refresh');
	}
	public function edit_chapters()
	{
		$data['title'] = "Education";
		$chapter_data = $this->registermodel->edit_chapters();
		$data['chapter_data']=$chapter_data['chapter'];
		$data['slides']=$chapter_data['slides'];
		$data['video_topics']=$chapter_data['video_topics'];
		$data['upload_notes']=$chapter_data['upload_notes'];
		$data['courses'] = $this->registermodel->get_mainexams();
		$data['subjects'] = $this->registermodel->get_courseWiseSubjects($data['chapter_data']->exam_id);
		$data['videoChapters'] = $this->registermodel->get_videoChapters($data['chapter_data']->exam_id,$data['chapter_data']->subject_id);
		//echo '<pre>';print_r($data['videoChapters']);exit;
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/edit_chapters', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function delete_chapters($class_id)
	{
		if(update_table('chapters', array('delete_status' => 0), array('id' => $class_id)) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/chapters', 'refresh');
	}

	public function get_user_chapters()
	{
		$data['title'] = "Education";
		$user_id = $this->input->post('user_id');
		$data['details'] = $this->registermodel->get_user_chapters($user_id);
		//var_dump($data['row']);		
		$this->load->view('admin/get_user_chapters', $data);
	}

	public function chapter_details($chapter_id)
	{		
		$data['title'] = "Education";
		$data['chapter_details'] = $this->registermodel->chapter_details($chapter_id);
		// echo "<pre>";var_dump($data['chapter_details']);die;
		$VideoId = $data['chapter_details'][0]->video_path;
        //$VideoId=$_POST['video_id'];
        $client_key = CLIENT_KEY;
        $ttl = 300; // Time to live validity of OTP is set to 300 seconds
        $annotate_code = <<< WATERMARK
      [{'type':'rtext', 'text':'dummy text as watermark', 'alpha':'0.60', 'color':'#000000', 'size':'15', 'interval':'5000','x' : '10','y': '50'}]
WATERMARK;
        $otp_post_array = array(
            "ttl" => $ttl,
                "annotate" => $annotate_code
        );
        $header = array(
            'Authorization: Apisecret ' . $client_key,
            'Content-Type: application/json',
            'Accept: application/json'
        );
        $otp_post_json = json_encode($otp_post_array);
        $url = "https://dev.vdocipher.com/api/videos/$VideoId/otp";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $otp_post_json);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $url);
        $otp_response = curl_exec($curl);
        curl_close($curl);
        $otp_response = json_decode($otp_response);
        $data['otp_response']=$otp_response;
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/chapter_details', $data);
		$this->load->view('admin/includes/footer', $data);
	}
		
		
	/*----------- /chapters --------------*/
	/*----------- topics --------------*/

	public function all_topics()
	{
        
      $topics = $this->registermodel->all_topics($_POST);
  $result_count=$this->registermodel->all_topics($_POST,1);
      $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($topics) ),
            "data"  => $topics);  
        echo json_encode($json_data);
    }

	public function topics()
	{
		$data['title'] = "Abhaya";		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_topics', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_topics()
	{
		$data['title'] = "Abhaya";
		$data['exams'] = $this->registermodel->get_mainexams();
		$data['subjects'] = $this->registermodel->get_mainsubjects();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_topics', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_topics()
	{
		//echo '<pre>';print_r($_FILES);exit;
		//echo '<pre>';print_r($pdf);exit;
		/*$config['upload_path']          = './storage/qbankBanners';
		$config['allowed_types']        = 'pdf|jpg|png|gif|jpeg';
		$config['max_size']             = 2000;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if($this->upload->do_upload('banner_image')){
		$imgdata = $this->upload->data();
		$image = 'storage/qbankBanners/'.$imgdata['file_name'];
		}else{
		$image = '';
		}

		if($this->upload->do_upload('topic_image')){
		$imgdata = $this->upload->data();
		$topic_image = 'storage/qbankBanners/'.$imgdata['file_name'];
		}else{
		$topic_image = '';
		}*/

		/*$pdf=$_FILES['pdf'];


		if($pdf['name']!=''){
			$config['upload_path']          = './storage/onlypdfs';
			$config['allowed_types']        = 'pdf|jpg';
			$config['max_size']             = 2000;
	        $this->load->library('upload',$config);
	        $this->upload->initialize($config);
	        
	        if($this->upload->do_upload('pdf')){
				$imgdata = $this->upload->data();
				$pdfUrl = 'storage/onlypdfs/'.$imgdata['file_name'];
				
			}else{
				$this->session->set_flashdata('success',  $this->upload->display_errors());
				if($this->input->post('topics_id') == ""){
				redirect('admin/register/add_topics', 'refresh');
				}else{
				    redirect('admin/register/edit_topics/'.$this->input->post('topics_id'), 'refresh');
				}
			}
		}else{
			$pdfUrl='';
		}*/


		$data = array(
	   'course_id' => $this->input->post('course_id'),
	   'subject_id' => $this->input->post('subject_id'),
	   'topic_name' => $this->input->post('topic_name'),
	   'title' => $this->input->post('title'),
	   'description' => $this->input->post('description'),
	   'quiz_type'=> $this->input->post('quiz_type'),
	   'pdf_path'=>$this->input->post('pdf_url'),
	   'suggested_qbank'=> $this->input->post('suggested_qbank'),
	   'banner_image'=> $this->input->post('banner_image'),
	   'topic_image'=> $this->input->post('topic_image'),
	   'order'=> $this->input->post('order')
			);
		if($this->input->post('topics_id') == "")
		{

		$data['created_on'] = date('Y-m-d H:i:s');	
    	$this->registermodel->insert_topics($data);
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/topics', 'refresh');
		}
		else
		{
		 //$res=$this->common_model->get_table_row('quiz_topics',array('id'=>$this->input->post('topics_id')),array());
		 //echo '<pre>';print_r($res);exit;
		 /*if($image == ''){
			$data['banner_image']= $res['banner_image'];
		 }else{
				$file = './'.$res['banner_image'];
				if(is_file($file))
				unlink($file);
		 }

		 if($topic_image == ''){
			$data['topic_image']= $res['topic_image'];
		 }else{
				$file = './'.$res['topic_image'];
				if(is_file($file))
				unlink($file);
		 }*/

		 /*if($pdfUrl == ''){
			$data['pdf_path']= $res['pdf_path'];
		 }else{
				$file = './'.$res['pdf_path'];
				if(is_file($file))
				unlink($file);
		 }*/

		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_topics($data, $this->input->post('topics_id'));
		//print_r($this->input->post('topics_id'));exit();
		//	print_r($data);exit();
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_topics/'.$this->input->post('topics_id'), 'refresh');
		}		
	}


	public function edit_topics()
	{
		$data['title'] = "Education";
		$query = $this->registermodel->edit_topics();
		$data['exams']=$query;
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/edit_topics', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function delete_topics($topics_id)
	{
		$data['topics']=$this->common_model->get_table('quiz_qbanktopics',array('chapter_id'=>$topics_id),array('id','name'));
		$data['subtopics']=$this->common_model->get_table('quiz_qbanksubtopics',array('chapter_id'=>$topics_id),array('id','name'));
		$data['questions']=$this->common_model->get_table('quiz_questions',array('topic_id'=>$topics_id),array('id','question_unique_id'));
		$data['topic_id']=$topics_id;
		//echo '<pre>';print_r($data['subtopics']);exit;
		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/delete_topics', $data);
		$this->load->view('admin/includes/footer', $data);
	}
	public function delete_topics_permently($id){

		
		$result=$this->registermodel->delete_topics($id);
		if($result == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/topics', 'refresh');
		
	}

public function change_events_type_to_recommended($subject_id, $recommended)
	{
		if($this->registermodel->change_event_type_to_recommended($subject_id, $recommended) == true)
		{
			$this->session->set_flashdata('success', 'Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/topics', 'refresh');
	} 

	public function change_topic_status($id, $status)
	{
		if($this->registermodel->change_topic_status($id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/topics', 'refresh');
	}


	public function get_topics()
	{
 $exam_id = $this->input->post('exam_id');

 $subjects=$this->registermodel->get_topics($exam_id);
?>
	 <option value="">Select Subjects</option>
<?php if(!empty($subjects))
{
   foreach($subjects as $subject)
{ ?>
<option value="<?=$subject['id']?>" ><?=$subject['subject_name'];?></option>
<?php }
}
}		
	/*----------- /topics --------------*/

	/*-----------Qbank topics --------------*/

	public function all_qbanktopics()
	{
        
      $qbanktopics = $this->registermodel->all_qbanktopics($_POST);
  	  $result_count=$this->registermodel->all_qbanktopics($_POST,1);
      $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($qbanktopics) ),
            "data"  => $qbanktopics);  
        echo json_encode($json_data);
    }

	public function qbanktopics()
	{
		$data['title'] = "Abhaya";		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_qbanktopics', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_qbanktopics()
	{
		$data['title'] = "Plato";
		$data['exams'] = $this->registermodel->get_mainexams();
		$data['subjects'] = $this->registermodel->get_mainsubjects();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_qbanktopics', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_quiztopic_question_order(){
		//echo '<pre>';print_r($post);exit;
		if($this->input->post() !=''){
			$post=$this->input->post();
			$topic_id=$this->input->post('qbank_topic_id');
			$course_id=$this->input->post('course_id');
			$copy_course_id=$this->input->post('copy_course_id');
			//echo '<pre>';print_r($post);exit;
			if($course_id !=''){
				
				$this->registermodel->moveQuestionsToQbankTopic($post);
				$this->session->set_flashdata('success', 'Records moved Successfully.');
			}else if($copy_course_id !=''){
				
				$this->registermodel->copyQuestionsToQbankTopic($post);
				$this->session->set_flashdata('success', 'Records copied Successfully.');
			}else{
				
			    $this->registermodel->updateQbankQuestionOrder($post['que']);
			    $this->session->set_flashdata('success', 'Records updated Successfully.');
			}
			
		    redirect('admin/register/qbanktopic_questions_list/'.$topic_id, 'refresh');
		}else{
		   $this->session->set_flashdata('success', 'Record added Successfully.');
		   redirect('admin/register/qbanktopic_questions_list/'.$topic_id, 'refresh');
		}
	}




public function qbanktopic_questions_list($topic_id){

		$data['title'] = "Plato";
		$data['topic']=$this->registermodel->getTopicwithTopicID($topic_id);
		$data['questions_list'] = $this->registermodel->getQbnakTopicQuestionsList($topic_id);
		$data['qbank_topic_id'] = $topic_id;		
		$data['exams']=$this->registermodel->getQbankCourses();
		//echo '<pre>';print_r($data['questions_list']);exit;
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_qbanktopic_questions', $data);
		$this->load->view('admin/includes/footer', $data);

	}

	public function change_topic_quiz_question_status($user_id, $status,$topic_id)
	{
		if($this->registermodel->change_quiz_question_status($user_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/qbanktopic_questions_list/'.$topic_id, 'refresh');
	}

	public function update_qbanktopics()
	{
		/*$config['upload_path']          = './storage/qbanktopics';
		$config['allowed_types']        = 'pdf|jpg|png|gif|jpeg';
		$config['max_size']             = 2000;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		 
		if($this->upload->do_upload('banner_image')){
		$imgdata = $this->upload->data();
		$image = 'storage/qbanktopics/'.$imgdata['file_name'];
		}else{
		$image = '';
		}

		if($this->upload->do_upload('icon_image')){
		$imgdata = $this->upload->data();
		$icon_image = 'storage/qbanktopics/'.$imgdata['file_name'];
		}else{
		$icon_image = '';
		}*/

		
		$data = array(
	   'course_id' => $this->input->post('course_id'),
	   'subject_id' => $this->input->post('subject_id'),
	   'chapter_id' => $this->input->post('chapter_id'),
	   'name' => $this->input->post('name'),
	   'title' => $this->input->post('title'),
	   'description' => $this->input->post('description'),
	   'banner_image'=> $this->input->post('banner_image'),
	   'icon_image'=> $this->input->post('icon_image'),
	   'pdf_path'=>$this->input->post('pdf_url'),
	   'suggested_qbank'=> $this->input->post('suggested_qbank'),
	   'questions_count'=> $this->input->post('questions_count'),
	   'quiz_type'=> $this->input->post('quiz_type'),
	   'order'=> $this->input->post('order')
	   	);
	   //	echo '<pre>';print_r($data);exit;
		if($this->input->post('qbanktopic_id') == "")
		{

		$data['created_on'] = date('Y-m-d H:i:s');	
    	$this->registermodel->insert_qbanktopics($data);
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/qbanktopics', 'refresh');
		}
		else
		{
		 //$res=$this->common_model->get_table_row('quiz_qbanktopics',array('id'=>$this->input->post('qbanktopic_id')),array());
		 //echo '<pre>';print_r($res);exit;
		 /*if($image == ''){
			$data['banner_image']= $res['banner_image'];
		 }else{
				$file = './'.$res['banner_image'];
				if(is_file($file))
				unlink($file);
		 }

		 if($icon_image == ''){
			$data['icon_image']= $res['icon_image'];
		 }else{
				$file = './'.$res['icon_image'];
				if(is_file($file))
				unlink($file);
		 }*/

		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_qbanktopics($data, $this->input->post('qbanktopic_id'));
		//print_r($this->input->post('topics_id'));exit();
		//	print_r($data);exit();
		$this->registermodel->updateQbankQuestions($data,$this->input->post('qbanktopic_id'));
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_qbanktopics/'.$this->input->post('qbanktopic_id'), 'refresh');
		}		
	}


	public function edit_qbanktopics()
	{
		$data['title'] = "Education";
		$query = $this->registermodel->edit_qbanktopics();
		$data['exams']=$query;
		$data['courses'] = $this->registermodel->get_mainexams();
		$data['subjects'] = $this->registermodel->get_courseWiseSubjects($query->course_id);
		$data['qbankChapters'] = $this->registermodel->get_qbankChapters($query->course_id,$query->subject_id);
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/edit_qbanktopics', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function delete_qbanktopics($topics_id)
	{
		
		$data['subtopics']=$this->common_model->get_table('quiz_qbanksubtopics',array('topic_id'=>$topics_id),array('id','name'));
		$data['questions']=$this->common_model->get_table('quiz_questions',array('qbank_topic_id'=>$topics_id),array('id','question_unique_id'));
		$data['qbank_topic_id']=$topics_id;
		//echo '<pre>';print_r($data['subtopics']);exit;
		if($this->input->post('submit')!=''){
			//echo '<pre>';print_r($_POST);exit;
		$result=$this->registermodel->delete_qbanktopics($_POST['qbank_topic_id']);
		if($result == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/qbanktopics', 'refresh');
		}
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/delete_qbanktopics', $data);
		$this->load->view('admin/includes/footer', $data);
	} 

	public function change_qbanktopics_status($id, $status)
	{
		if($this->registermodel->change_qbanktopics_status($id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/qbanktopics', 'refresh');
	}




	public function get_qbanktopics()
	{
		 $exam_id = $this->input->post('exam_id');

		 $subjects=$this->registermodel->get_topics($exam_id);
		?>
			 <option value="">Select Subjects</option>
		<?php if(!empty($subjects))
		{
		   foreach($subjects as $subject)
		{ ?>
		<option value="<?=$subject['id']?>" ><?=$subject['subject_name'];?></option>
		<?php }
		}
	}		
	/*----------- /Qbank topics --------------*/

	/*-----------Qbank sub topics --------------*/

	public function all_qbanksubtopics()
	{
        
      $qbanktopics = $this->registermodel->all_qbanksubtopics($_POST);
  	  $result_count=$this->registermodel->all_qbanksubtopics($_POST,1);
      $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($qbanktopics) ),
            "data"  => $qbanktopics);  
        echo json_encode($json_data);
    }

	public function qbanksubtopics()
	{
		$data['title'] = "Abhaya";		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_qbanksubtopics', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_qbanksubtopics()
	{
		$data['title'] = "Abhaya";
		$data['exams'] = $this->registermodel->get_mainexams();
		$data['subjects'] = $this->registermodel->get_mainsubjects();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_qbanksubtopics', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_qbanksubtopics()
	{
		
		$banner_image=$_FILES['banner_image'];

		if($banner_image['name']!=''){
			$config['upload_path']          = './storage/qbanktopics';
		    $config['allowed_types']        = 'pdf|jpg|png|gif|jpeg';
			$config['max_size']             = 2000;
	        $this->load->library('upload',$config);
	        $this->upload->initialize($config);
	        if($this->upload->do_upload('banner_image')){
				$imgdata = $this->upload->data();
				$image = 'storage/qbanktopics/'.$imgdata['file_name'];
				
			}else{
				$this->session->set_flashdata('success', $this->upload->display_errors());
				if($this->input->post('qbanksubtopic_id') == ""){
				redirect('admin/register/add_qbanksubtopics', 'refresh');
				}else{
				    redirect('admin/register/edit_qbanksubtopics/'.$this->input->post('qbanksubtopic_id'), 'refresh');
				}
			}
		}else{
			$image='';
		}

		$Iconimage=$_FILES['icon_image'];

		if($Iconimage['name']!=''){
			$config['upload_path']          = './storage/qbanktopics';
		    $config['allowed_types']        = 'pdf|jpg|png|gif|jpeg';
			$config['max_size']             = 2000;
	        $this->load->library('upload',$config);
	        $this->upload->initialize($config);
	        if($this->upload->do_upload('icon_image')){
				$imgdata = $this->upload->data();
				$icon_image = 'storage/qbanktopics/'.$imgdata['file_name'];
				
			}else{
				$this->session->set_flashdata('success', $this->upload->display_errors());
				if($this->input->post('qbanksubtopic_id') == ""){
				redirect('admin/register/add_qbanksubtopics', 'refresh');
				}else{
				    redirect('admin/register/edit_qbanksubtopics/'.$this->input->post('qbanksubtopic_id'), 'refresh');
				}
			}
		}else{
			$icon_image='';
		}
		
		
		$data = array(
	   'course_id' => $this->input->post('course_id'),
	   'subject_id' => $this->input->post('subject_id'),
	   'chapter_id' => $this->input->post('chapter_id'),
	   'topic_id' => $this->input->post('topic_id'),
	   'name' => $this->input->post('name'),
	   'title' => $this->input->post('title'),
	   'description' => $this->input->post('description'),
	   'banner_image'=> $image,
	   'icon_image'=> $icon_image,
	   	);

		if($this->input->post('qbanksubtopic_id') == "")
		{

		$data['created_on'] = date('Y-m-d H:i:s');	
    	$this->registermodel->insert_qbanksubtopics($data);
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/qbanksubtopics', 'refresh');
		}
		else
		{
		 $res=$this->common_model->get_table_row('quiz_qbanksubtopics',array('id'=>$this->input->post('qbanksubtopic_id')),array());
		 //echo '<pre>';print_r($res);exit;
		 if($image == ''){
			$data['banner_image']= $res['banner_image'];
		 }else{
				$file = './'.$res['banner_image'];
				if(is_file($file))
				unlink($file);
		 }

		 if($icon_image == ''){
			$data['icon_image']= $res['icon_image'];
		 }else{
				$file = './'.$res['icon_image'];
				if(is_file($file))
				unlink($file);
		 }

		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_qbanksubtopics($data, $this->input->post('qbanksubtopic_id'));
		//print_r($this->input->post('topics_id'));exit();
		//	print_r($data);exit();
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_qbanksubtopics/'.$this->input->post('qbanksubtopic_id'), 'refresh');
		}		
	}


	public function edit_qbanksubtopics()
	{
		$data['title'] = "Education";
		$query = $this->registermodel->edit_qbanksubtopics();
		$data['exams']=$query;
		$data['courses'] = $this->registermodel->get_mainexams();
		$data['subjects'] = $this->registermodel->get_courseWiseSubjects($query->course_id);
		$data['qbankChapters'] = $this->registermodel->get_qbankChapters($query->course_id,$query->subject_id);
		$data['qbankTopics'] = $this->registermodel->get_qbankTopics($query->course_id,$query->subject_id,$query->chapter_id);
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/edit_qbanksubtopics', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function delete_qbanksubtopics($topics_id)
	{
		if($this->registermodel->delete_qbanksubtopics($topics_id) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		
		redirect('admin/register/qbanksubtopics', 'refresh');
	} 

	public function change_qbanksubtopics_status($id, $status)
	{
		if($this->registermodel->change_qbanksubtopics_status($id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/qbanksubtopics', 'refresh');
	}


	public function get_qbanksubtopics()
	{
		 $exam_id = $this->input->post('exam_id');

		 $subjects=$this->registermodel->get_topics($exam_id);
		?>
			 <option value="">Select Subjects</option>
		<?php if(!empty($subjects))
		{
		   foreach($subjects as $subject)
		{ ?>
		<option value="<?=$subject['id']?>" ><?=$subject['subject_name'];?></option>
		<?php }
		}
	}		
	/*----------- /Qbank sub topics --------------*/
	
	
/*----------- notifications --------------*/

	public function all_notifications()
	{
        $notifications = $this->registermodel->all_notifications($_POST);
        $result_count=$this->registermodel->all_notifications($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($notifications) ),
            "data"  => $notifications);  
        echo json_encode($json_data);
    }

	public function notifications()
	{		
		$data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_notifications', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_notifications()
	{
		$data['title'] = "Education";						
		$this->load->view('admin/includes/header', $data);
		$data['courses'] = $this->registermodel->get_exams();
		$this->load->view('admin/add_notifications', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_notifications()
	{

		$image=$_FILES['image'];

		if($image['name']!=''){
			$config['upload_path']          = './storage/notifications';
			$config['allowed_types']        = 'jpg|png|gif|jpeg';
			$config['max_size']             = 2000;
	        $this->load->library('upload', $config);
			$this->upload->initialize($config);
	        if($this->upload->do_upload('image')){
				$imgdata = $this->upload->data();
				$imgurl = 'storage/notifications/'.$imgdata['file_name'];
				$data['image'] = $imgurl;
			}else{
				$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
				redirect('admin/register/add_notifications', 'refresh');
			}
		}else{
				$this->session->set_flashdata('success', 'Please select Image.');
				redirect('admin/register/add_notifications', 'refresh');
			}

     $data = array(		
     		'title' => $this->input->post('title'),
     		'course_id'=> $this->input->post('course_id'), 
     		'image' => $imgurl,
		    'description' => $this->input->post('description'),
            'created_on' => date('Y-m-d H:i:s')
			);
		
		//var_dump($data);exit;
		if($this->input->post('notification_id') == "")
		{
			$data['created_on'] = date('Y-m-d H:i:s');		
			$this->registermodel->insert_notifications($data);
			$image_path=base_url().$imgurl;
		   $pushStatus = 	$this->registermodel->send_push_notification($this->input->post('course_id'),$image_path,$this->input->post('title'),$this->input->post('description'),'', 'many');
		
		if(   $pushStatus )
			$this->session->set_flashdata('success', 'Record added Successfully.');
			else
				$this->session->set_flashdata('fail', 'Failed.');
			redirect('admin/register/add_notifications', 'refresh');				
		}
		else
		{
			$data['modified_on'] = date('Y-m-d H:i:s');
			//$this->registermodel->update_notifications($data, $this->input->post('notification_id'));
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
		// redirect('admin/register/edit_notifications/'.$this->input->post('notification_id'), 'refresh');
		}		
	}


	public function delete_notifications()
	{
		if($this->registermodel->delete_notifications() == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/notifications', 'refresh');
	}
		
	/*----------- /notifications --------------*/	
		
		/*----------- chapters_slides --------------*/

	public function all_chapters_slides()
	{
        
      $chapters_slides = $this->registermodel->all_chapters_slides($_POST);
  $result_count=$this->registermodel->all_chapters_slides($_POST,1);
      $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($chapters_slides) ),
            "data"  => $chapters_slides);  
        echo json_encode($json_data);
    }

	public function chapters_slides()
	{
		$data['title'] = "Education";		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_chapters_slides', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_chapters_slides()
	{
		$data['title'] = "Education";
		$data['chapters'] = $this->registermodel->get_chapters();
		$data['exams'] = $this->registermodel->get_exams();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_chapters_slides', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_chapters_slides()
	{
		$config['upload_path']          = './storage/pdfs';
		$config['allowed_types']        = 'jpg|png|gif|jpeg';
		$config['max_size']             = 20000;

		$this->load->library('upload', $config);
		$image=$_FILES['image'];
         //print_r($image);
         //echo $image['name'];
         //exit;
         $imgurl='';

         if($image['name']!=''){
	   if($this->upload->do_upload('image')){
			$imgdata = $this->upload->data();
			$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
		}else{
			//$imgurl = $this->input->post('imgurl');
				$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
			if($this->input->post('chapters_slides_id') == "")
		{
		
	    	redirect('admin/register/add_chapters_slides', 'refresh');
		}
		else{
		    
		}
			redirect('admin/register/edit_chapters_slides/'.$this->input->post('chapters_slides_id'), 'refresh');
		}
         }

		$data = array(
    'exam_id' => $this->input->post('exam_id'),
    'subject_id' => $this->input->post('subject_id'),
	'chapter_id' => $this->input->post('chapter_id'),
	'chapters_status' => $this->input->post('status')
			);
        if($imgurl!=''){
            $data['image']=$imgurl;
        }

		if($this->input->post('chapters_slides_id') == "")
		{			
	
		$data['created_on'] = date('Y-m-d H:i:s');	
    $this->registermodel->insert_chapters_slides($data);
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/register/chapters_slides', 'refresh');
		}
		else
		{

		$data = array(
	'exam_id' => $this->input->post('exam_id'),
    'subject_id' => $this->input->post('subject_id'),
	'chapter_id' => $this->input->post('chapter_id'),
	'chapters_status' => $this->input->post('status')
			);
			
			if($imgurl!=''){
            $data['image']=$imgurl;
        }
			$data['modified_on'] = date('Y-m-d H:i:s');
			$this->registermodel->update_chapters_slides($data, $this->input->post('chapters_slides_id'));
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/register/edit_chapters_slides/'.$this->input->post('chapters_slides_id'), 'refresh');
		}		
	}

public function edit_chapters_slides()
	{
		$data['title'] = "Education";
		if($query = $this->registermodel->edit_chapters_slides())
		{
			$data['row'] = $query;
		}
		$data['chapters'] = $this->registermodel->get_chapters();
		$data['exams'] = $this->registermodel->get_exams();
		$data['chapters_slides'] = $this->registermodel->gets_chapters_slides();		
		//var_dump($data['row']);	exit();	
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/edit_chapters_slides', $data);
		$this->load->view('admin/includes/footer', $data);
	}
	public function delete_chapters_slides()
	{
if($this->registermodel->delete_chapters_slides() == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/chapters_slides', 'refresh');
	}
public function changes_events_type_to_recommended($chapters_slides_id, $recommended)
	{
		if($this->registermodel->change_events_type_to_recommended($chapters_slides_id, $recommended) == true)
		{
			$this->session->set_flashdata('success', 'Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/chapters_slides', 'refresh');
	} 
/*--------- chapterslides ----------------*/

	/*----------- plandetails --------------*/

	public function all_plandetails()
	{
        
      $plandetails = $this->registermodel->all_plandetails($_POST);
  $result_count=$this->registermodel->all_plandetails($_POST,1);
      $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($plandetails) ),
            "data"  => $plandetails);  
        echo json_encode($json_data);
    }

	public function plandetails()
	{
		$data['title'] = "Education";		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_plandetails', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_plandetails()
	{
		$data['title'] = "Education";
		$data['coupons'] = $this->registermodel->get_morecoupons();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_plandetails', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_plandetails()
	{
       
		$data = array(
		'coupon_id' => $this->input->post('coupon_id'),
         	'plan_name' =>$this->input->post('plan_name'),
         	'plan_type' =>$this->input->post('plan_type'),
  'expire_duration_months' =>  $this->input->post('expire_duration_months'),
'price' => $this->input->post('price'),
'q_bank_access' => $this->input->post('q_bank_access'),
'videos_access' => $this->input->post('videos_access'),
'tests_access' => $this->input->post('tests_access')
          	);


		if($this->input->post('plandetail_id') == "")
		{			
	
		$data['created_on'] = date('Y-m-d H:i:s');	
    $this->registermodel->insert_plandetails($data);
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/register/plandetails', 'refresh');
		}
		else
		{
			//echo $this->db->last_query();exit;
		//echo $this->db->last_query();exit;
			$data['modified_on'] = date('Y-m-d H:i:s');
			$this->registermodel->update_plandetails($data, $this->input->post('plandetail_id'));
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/register/edit_plandetails/'.$this->input->post('plandetail_id'), 'refresh');
		}		
	}

	public function edit_plandetails()
	{
		$data['title'] = "plato";
		if($query = $this->registermodel->edit_plandetails())
		{
			$data['row'] = $query;
		}
		$data['coupons'] = $this->registermodel->get_morecoupons();
		//var_dump($data['row']);	exit();	
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/edit_plandetails', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function delete_plandetails()
	{
		if($this->registermodel->delete_plandetails() == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/plandetails', 'refresh');
	}

public function change_evented_type_to_recommended($subject_id, $recommended)
	{
		if($this->registermodel->change_event_type_to_recommended($subject_id, $recommended) == true)
		{
			$this->session->set_flashdata('success', 'Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/plandetails', 'refresh');
	} 
		
	/*----------- /plandetails --------------*/




	/*----------- faculty --------------*/

	public function all_faculty()
	{
        $faculty = $this->registermodel->all_faculty($_POST);
        $result_count=$this->registermodel->all_faculty($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($faculty) ),
            "data"  => $faculty);  
        echo json_encode($json_data);
    }

	public function faculty()
	{		
		$data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_faculty', $data);
		$this->load->view('admin/includes/footer', $data);
	}
	public function add_faculty()
	{
		$data['title'] = "Education";
		$data['exams'] = $this->registermodel->get_exams();				
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_faculty', $data);
		$this->load->view('admin/includes/footer', $data);
	}
		public function update_faculty()
     	{
			/*$image=$_FILES['image'];
			$imgurl='';
			if($image['name']!='')
			{
			$config['upload_path']          = './storage/pdfs';
			$config['allowed_types']        = 'jpg|png|gif|jpeg';
			$config['max_size']             = 2000;
	
		   $this->load->library('upload', $config);
		
		
	   if($this->upload->do_upload('image')){
			$imgdata = $this->upload->data();
			$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
		}else{
			//$imgurl = $this->input->post('imgurl');
		
			$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');

			if($this->input->post('faculty_id') == "")
			{
				redirect('admin/register/add_faculty', 'refresh');
			}else{
				redirect('admin/register/edit_faculty/'.$this->input->post('faculty_id'));
			}
			}
		}*/


		     $data = array(	
			     	'exam_id' => $this->input->post('exam_id'),	
			     	'name' => $this->input->post('name'),
					'title' => $this->input->post('title'),
					'specialisation' => $this->input->post('specialisation'),
					'profile_img' => $this->input->post('profile_img'),
					'order' => $this->input->post('order'),
		            'created_on' => date('Y-m-d H:i:s')
					);

			/*if($imgurl!=''){
				$data['profile_img']=$imgurl;
			}*/
			
		
		//var_dump($data);exit;
		if($this->input->post('faculty_id') == "")
		{
			$data['created_on'] = date('Y-m-d H:i:s');		
			$this->registermodel->insert_faculty($data);
			//echo $this->db->last_query();exit;
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/register/add_faculty', 'refresh');				
		}
		else
		{
			$data['modified_on'] = date('Y-m-d H:i:s');
			$this->registermodel->update_faculty($data, $this->input->post('faculty_id'));
			//echo $this->db->last_query();exit;
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
		// redirect('admin/register/edit_faculty/'.$this->input->post('notification_id'), 'refresh');
		}		
	}


	public function delete_faculty()
	{
		if($this->registermodel->delete_faculty() == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/faculty', 'refresh');
	}

	public function change_faculty_status($faculty_id, $status)
	{
		if($this->registermodel->change_faculty_status($faculty_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/faculty', 'refresh');
	}

	/*----------- /faculty --------------*/

	public function all_coupons()
	{
        $coupons = $this->registermodel->all_coupons($_POST);
        $result_count=$this->registermodel->all_coupons($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($coupons) ),
            "data"  => $coupons);  
        echo json_encode($json_data);
    }

	public function coupons()
	{		
		$data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_coupons', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_coupons()
	{
		$data['title'] = "Education";		
		$data['packages']=$this->registermodel->packages();				
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_coupons', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_coupons()
	{
		
		$data = array(
			'package_id'         => $this->input->post('package_id'),
			'coupon_code'         => $this->input->post('coupon_code'),
		    'discount_percentage' => $this->input->post('discount_percentage'),
		    'expiry_date'         => $this->input->post('expiry_date'),
			'start_date'         => $this->input->post('start_date')
		);
		//var_dump($data);exit;
		if($this->input->post('coupon_id') == "")
		{
			$data['created_on'] = date('Y-m-d H:i:s');		
			$package_limit=$this->registermodel->get_package($this->input->post('package_id'));
			$entereddbcoupons=$this->registermodel->getentereddbcoupons($this->input->post('package_id'));
			$entered_db=$entereddbcoupons['coupons_count'];
			$db_package_limit =$package_limit['no_of_coupons'];
			//echo $entered_db;
			//echo $db_package_limit;exit;
			if($db_package_limit > $entered_db){
			$this->registermodel->insert_coupons($data);
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/register/add_coupons', 'refresh');
			}else{
			$this->session->set_flashdata('success', 'Entered Coupons Limit crossed on this package.');
			redirect('admin/register/add_coupons', 'refresh');
			}
			//echo $this->db->last_query();exit;				
		}
		else
		{
			$data['modified_on'] = date('Y-m-d H:i:s');
			$this->registermodel->update_coupons($data, $this->input->post('coupon_id'));
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
			redirect('admin/register/edit_coupons/'.$this->input->post('coupon_id'), 'refresh');
		}		
	}

	public function edit_coupons()
	{
		$data['title'] = "Education";
		$data['packages']=$this->registermodel->packages();	
		if($query = $this->registermodel->edit_coupons())
		{
			$data['row'] = $query;
		}		
		//var_dump($data['row']);		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/edit_coupons', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function delete_coupons()
	{
		if($this->registermodel->delete_coupons() == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/coupons', 'refresh');
	}
		
	/*----------- /coupons --------------*/



 
	/*----------- banners --------------*/

	public function all_banners()
	{
        $banners = $this->registermodel->all_banners($_POST);
        $result_count=$this->registermodel->all_banners($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($banners) ),
            "data"  => $banners);  
        echo json_encode($json_data);
    }

	public function banners()
	{		
		$data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_banners', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_banners()
	{
		$data['title'] = "Education";
		$data['exams'] = $this->registermodel->get_exams();						
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_banners', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function edit_banners($id)
	 {
		 $data['title'] = "Education";
		 $data['exams']=$this->common_model->get_table('exams',array('delete_status'=>'1','status'=>'Active'),array());
		 if($query = $this->registermodel->edit_banners($id))
		 {
			 $data['row'] = $query;
			
		 }		
		 //var_dump($data['row']);		
		 $this->load->view('admin/includes/header', $data);
		 $this->load->view('admin/edit_banners', $data);
		 $this->load->view('admin/includes/footer', $data);
	 }


	public function update_banners()
     	{


	   $image=$_FILES['image'];
	   $imgurl='';
	   if($image['name']!='')
	   {
	   $config['upload_path']          = './storage/pdfs';
	   $config['allowed_types']        = 'jpg|png|gif|jpeg';
	   $config['max_size']             = 2000;

	  $this->load->library('upload', $config);
		
		
	   if($this->upload->do_upload('image')){
			$imgdata = $this->upload->data();
			$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
		}else{
		//	$imgurl = $this->input->post('imgurl');
		$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');

		if($this->input->post('banners_id') == "")
		{
			redirect('admin/register/add_banners', 'refresh');
		}else{
		    redirect('admin/register/edit_banners/'.$this->input->post('banners_id'));
		}

		}
	}


     $data = array(	
     'exam_id' => $this->input->post('exam_id'),
      'youtube_video_url' => $this->input->post('youtube_video_url'),
      'pdf_path' => $this->input->post('pdf_path'),
      'order' => $this->input->post('order'),
			);

			if($imgurl!=''){
				$data['image']=$imgurl;
			}
		
		//var_dump($data);exit;
		if($this->input->post('banners_id') == "")
		{
			$data['created_on'] = date('Y-m-d H:i:s');		
			$this->registermodel->insert_banners($data);
			//echo $this->db->last_query();exit;
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/register/add_banners', 'refresh');				
		}
		else
		{
			$data['modified_on'] = date('Y-m-d H:i:s');
			$this->registermodel->update_banners($data, $this->input->post('banners_id'));
			//echo $this->db->last_query();exit;
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
		    redirect('admin/register/edit_banners/'.$this->input->post('banners_id'), 'refresh');
		}		
	}


  public function delete_banners()
	{
		if($this->registermodel->delete_banners() == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/banners', 'refresh');
	}

	public function change_banners_status($banners_id, $status)
	{
		if($this->registermodel->change_banners_status($banners_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/banners', 'refresh');
	}

	/*----------- /banners --------------*/


	/*-----------Image Gallery --------------*/

	public function all_imageGallery()
	{
        $banners = $this->registermodel->all_imageGallery($_POST);
        $result_count=$this->registermodel->all_imageGallery($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($banners) ),
            "data"  => $banners);  
        echo json_encode($json_data);
    }

	public function images_gallery()
	{		
		$data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_images_gallery', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_images_gallery()
	{
		$data['title'] = "Education";
		$data['exams'] = $this->registermodel->get_exams();						
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_images_gallery', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function edit_images_gallery()
	 {
		 $data['title'] = "Education";
		 if($query = $this->registermodel->edit_images_gallery())
		 {
			 $data['row'] = $query;
		 }		
		 //var_dump($data['row']);		
		 $this->load->view('admin/includes/header', $data);
		 $this->load->view('admin/edit_images_gallery', $data);
		 $this->load->view('admin/includes/footer', $data);
	 }

	public function update_images_gallery()
     	{


	   $image=$_FILES['image'];
	   $imgurl='';
	   if($image['name']!='')
	   {
	   $config['upload_path']          = './storage/images_gallery';
	   $config['allowed_types']        = 'jpg|png|gif|jpeg';
	   $config['max_size']             = 2000;
	   $config['max_width']  = '500';
	   $config['max_height']  = '500';
	  	$this->load->library('upload', $config);
		$this->upload->initialize($config);

	   if($this->upload->do_upload('image')){
			$imgdata = $this->upload->data();
			$imgurl = 'storage/images_gallery/'.$imgdata['file_name'];
		}else{
		//	$imgurl = $this->input->post('imgurl');
			//$error = array('error' => $this->upload->display_errors());
			$error = $this->upload->display_errors();
		$this->session->set_flashdata('success', $error);

				if($this->input->post('image_id') == "")
				{
					redirect('admin/register/add_images_gallery', 'refresh');
				}else{
				    redirect('admin/register/edit_images_gallery/'.$this->input->post('image_id'));
				}

			}
		}


		     $data = array(	
		     'note' => $this->input->post('note'),
		     'image'=>	$imgurl
					);

			
		
		//var_dump($data);exit;
		if($this->input->post('image_id') == "")
		{
			$data['created_on'] = date('Y-m-d H:i:s');		
			$this->registermodel->insert_images_gallery($data);
			//echo $this->db->last_query();exit;
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/register/add_images_gallery', 'refresh');				
		}
		else
		{

			$res=$this->common_model->get_table_row('images_gallery',array('id'=>$this->input->post('image_id')),array());
		 //echo '<pre>';print_r($res);exit;
		 if($imgurl == ''){
			$data['image']= $res['image'];
		 }else{
				$file = './'.$res['image'];
				if(is_file($file))
				unlink($file);
		 }
		
		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_images_gallery($data, $this->input->post('image_id'));
		//echo $this->db->last_query();exit;
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		 redirect('admin/register/edit_images_gallery/'.$this->input->post('image_id'), 'refresh');
		}		
	}


  public function delete_images_gallery()
	{
		if($this->registermodel->delete_images_gallery() == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/images_gallery', 'refresh');
	}

	/*----------- Image Gallery --------------*/

	/*----------- payments --------------*/

	public function all_payments()
	{
        $payments = $this->registermodel->all_payments($_POST);
        $result_count=$this->registermodel->all_payments($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($payments) ),
            "data"  => $payments);  
        echo json_encode($json_data);
    }

	public function payments()
	{		
		$data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_payments', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function all_offline_payments()
	{
        $payments = $this->registermodel->all_offline_payments($_POST);
        $result_count=$this->registermodel->all_offline_payments($_POST,1);
        $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($payments) ),
            "data"  => $payments);  
        echo json_encode($json_data);
    }

	public function offline_payments()
	{		
		$data['title'] = "Education";
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_offline_payments', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function view_payment_info()
	{		
		$data['title'] = "Education";
		$data['payment_info']=$this->registermodel->getPaymentInfo($this->uri->segment(4));
		//echo '<pre>';print_r($this->uri->segment(4));exit;
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/view_payment_info', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_payments()
	{        
		$data = array(		
			'total_amount' => $this->input->post('total_amount'),
			'discounted_amount' => $this->input->post('discounted_amount'),
			'paid_amount' => $this->input->post('paid_amount'),
	        'payment_ref_no' => $this->input->post('payment_ref_no'),
			'payment_mode'=> $this->input->post('payment_mode')

			);
		//var_dump($data);exit;
		
	
			$data['created_on'] = date('Y-m-d H:i:s');
			$event_id = update_table('payments', $data, array('id' => $this->input->post('payment_id')));
			//echo $this->db->last_query();exit;
			$this->session->set_flashdata('success', 'Record Updated Successfully.');
	}


	public function delete_payments($payment_id)
	{
		if($this->registermodel->delete_payments($payment_id) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/payments', 'refresh');
	}


	public function change_payments_status($payment_id, $status)
	{
		if($this->registermodel->change_payments_status($payment_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/payments', 'refresh');
	}

	/*----------- /payments --------------*/
	     	/*----------- testseries --------------*/

			 public function all_testseries()
			 {
				 $testseries = $this->registermodel->all_testseries($_POST);
				 $result_count=$this->registermodel->all_testseries($_POST,1);
				 $json_data = array(
					 "draw"  => intval($_POST['draw'] ),
					 "iTotalRecords"  => intval($result_count ),
					 "iTotalDisplayRecords"  => intval($result_count ),
					 "recordsFiltered"  => intval(count($testseries) ),
					 "data"  => $testseries);  
				 echo json_encode($json_data);
			 }
		 
			 public function testseries()
			 {		
				 $data['title'] = "Education";
				 $this->load->view('admin/includes/header', $data);
				 $this->load->view('admin/list_testseries', $data);
				 $this->load->view('admin/includes/footer', $data);
			 }
		 
			 public function add_testseries()
			 {
				 $data['title'] = "Education";						
				 $this->load->view('admin/includes/header', $data);
				 $this->load->view('admin/add_testseries', $data);
				 $this->load->view('admin/includes/footer', $data);
			 }
		 
			 public function update_testseries()
			 {
				$image=$_FILES['image'];
				$imgurl='';
				if($image['name']!='')
				{
				$config['upload_path']          = './storage/pdfs';
				$config['allowed_types']        = 'jpg|png|gif|jpeg';
				$config['max_size']             = 2000;
		
			   $this->load->library('upload', $config);
				 
				 
				if($this->upload->do_upload('image')){
					 $imgdata = $this->upload->data();
					 $imgurl = 'storage/pdfs/'.$imgdata['file_name'];
				 }else{
					// $imgurl = $this->input->post('imgurl');
				 
						
			$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
			if($this->input->post('testseries_id') == "")
		{
			redirect('admin/register/add_testseries', 'refresh');
		}else{
		    redirect('admin/register/edit_testseries/'.$this->input->post('testseries_id'));
		}
				}
			}
		 
				 $data = array(
					 'title' => $this->input->post('title'),
					 
				 );


				 if($imgurl!=''){
					$data['image']=$imgurl;
				}
				 //var_dump($data);exit;
				 if($this->input->post('testseries_id') == "")
				 {
					 $data['created_on'] = date('Y-m-d H:i:s');		
					 $this->registermodel->insert_testseries($data);
					 $this->session->set_flashdata('success', 'Record added Successfully.');
					 redirect('admin/register/add_testseries', 'refresh');
					 //echo $this->db->last_query();exit;				
				 }
				 else
				 {
					 //$data['modified_on'] = date('Y-m-d H:i:s');
					 $this->registermodel->update_testseries($data, $this->input->post('testseries_id'));
					 $this->session->set_flashdata('success', 'Record Updated Successfully.');
					 redirect('admin/register/edit_testseries/'.$this->input->post('testseries_id'), 'refresh');
				 }		
			 }
		 
			 public function edit_testseries()
			 {
				 $data['title'] = "Education";
				 if($query = $this->registermodel->edit_testseries())
				 {
					 $data['row'] = $query;
				 }		
				 //var_dump($data['row']);		
				 $this->load->view('admin/includes/header', $data);
				 $this->load->view('admin/edit_testseries', $data);
				 $this->load->view('admin/includes/footer', $data);
			 }
		 
			 public function delete_testseries($testsinfo_id)
			 {
				if(delete_record('testseries', array('id' => $testsinfo_id)) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
				
			 }
			 redirect('admin/register/testseries', 'refresh');
			}
				 
			 /*----------- /testseries --------------*/

/*----------- test_series_categories --------------*/

public function all_test_series_categories()
{
	$test_series_categories = $this->registermodel->all_test_series_categories($_POST);
	$result_count=$this->registermodel->all_test_series_categories($_POST,1);
	$json_data = array(
		"draw"  => intval($_POST['draw'] ),
		"iTotalRecords"  => intval($result_count ),
		"iTotalDisplayRecords"  => intval($result_count ),
		"recordsFiltered"  => intval(count($test_series_categories) ),
		"data"  => $test_series_categories);  
	echo json_encode($json_data);
}

public function test_series_categories()
{		
	$data['title'] = "Education";
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/list_test_series_categories', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function add_test_series_categories()
{
	$data['title'] = "Education";			
	$data['courses']=$this->registermodel->getCourses();		
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/add_test_series_categories', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function update_test_series_categories()
{
	
	$data = array(
		'title' => $this->input->post('title'),
		'course_id'=> $this->input->post('course_id'),
		'pdf_path'=> $this->input->post('pdf_path'),
		'order'=> $this->input->post('order'),
	);
	
	
	//var_dump($data);exit;
	if($this->input->post('test_series_categories_id') == "")
	{
		$data['created_on'] = date('Y-m-d H:i:s');		
		$this->registermodel->insert_test_series_categories($data);
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/add_test_series_categories', 'refresh');
		//echo $this->db->last_query();exit;				
	}
	else
	{
		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_test_series_categories($data, $this->input->post('test_series_categories_id'));
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_test_series_categories/'.$this->input->post('test_series_categories_id'), 'refresh');
	}		
}

public function edit_test_series_categories()
{
	$data['title'] = "Education";
	if($query = $this->registermodel->edit_test_series_categories())
	{
		$data['row'] = $query;
	}		
	//var_dump($data['row']);	
	$data['courses']=$this->registermodel->getCourses();	
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/edit_test_series_categories', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function delete_test_series_categories( $test_quest_id)
{
	if(delete_record('test_series_categories', array('id' => $test_quest_id)) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
	redirect('admin/register/test_series_categories', 'refresh');
}
	
/*----------- /test_series_categories --------------*/


/*----------- quiz_questions --------------*/

public function all_quiz_questions()
{
  $quiz_questions = $this->registermodel->all_quiz_questions($_POST);
$result_count=$this->registermodel->all_quiz_questions($_POST,1);
  $json_data = array(
		"draw"  => intval($_POST['draw'] ),
		"iTotalRecords"  => intval($result_count ),
		"iTotalDisplayRecords"  => intval($result_count ),
		"recordsFiltered"  => intval(count($quiz_questions) ),
		"data"  => $quiz_questions);  
	echo json_encode($json_data);
}

public function bulk_upload_quiz_questions()
{
	$data['title'] = "Education";
	$data['exams'] = $this->registermodel->get_mainexams();
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/bulk_upload_quiz_questions', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function submit_bulk_upload_quiz_questions()
{
	$data_input = array(
		'course_id' => $this->input->post('course_id'),
		'subject_id' => $this->input->post('subject_id'),
		'topic_id' => $this->input->post('topic_id'),
		'created_on' => date('Y-m-d H:i:s')
	);
	$countfiles=count($_FILES['images']['name']);
	if($countfiles>0)
	{
		for ($i=0; $i < $countfiles; $i++) 
		{ 
			if($_FILES['images']['name'][$i]!="")
			{
			  $_FILES['optionimage']['name'] = $_FILES['images']['name'][$i];
	          $_FILES['optionimage']['type'] = $_FILES['images']['type'][$i];
	          $_FILES['optionimage']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
	          $_FILES['optionimage']['error'] = $_FILES['images']['error'][$i];
	          $_FILES['optionimage']['size'] = $_FILES['images']['size'][$i];
	          $config['upload_path']          = './storage/pdfs';
	          $config['allowed_types']        = 'jpg|png|gif|jpeg';
			  $config['max_size']             = 2000;
			  $this->load->library('upload',$config);
			  if($this->upload->do_upload('optionimage'))
			  {
					$imgdata = $this->upload->data();
					$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
			  }
				else
				{
					$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
					redirect('admin/register/bulk_upload_quiz_questions', 'refresh');
				}
			}
		}
	}

	$countfiles=count($_FILES['questionimages']['name']);
	if($countfiles>0)
	{
		for ($i=0; $i < $countfiles; $i++) 
		{ 
			if($_FILES['questionimages']['name'][$i]!="")
			{
			  $_FILES['optionimage']['name'] = $_FILES['questionimages']['name'][$i];
	          $_FILES['optionimage']['type'] = $_FILES['questionimages']['type'][$i];
	          $_FILES['optionimage']['tmp_name'] = $_FILES['questionimages']['tmp_name'][$i];
	          $_FILES['optionimage']['error'] = $_FILES['questionimages']['error'][$i];
	          $_FILES['optionimage']['size'] = $_FILES['questionimages']['size'][$i];
	          $config['upload_path']          = './storage/pdfs';
	          $config['allowed_types']        = 'jpg|png|gif|jpeg';
			  $config['max_size']             = 2000;
			  $this->load->library('upload',$config);
			  if($this->upload->do_upload('optionimage'))
			  {
					$imgdata = $this->upload->data();
					$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
			  }
				else
				{
					$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
					redirect('admin/register/bulk_upload_quiz_questions', 'refresh');
				}
			}
		}
	}

	$countfiles=count($_FILES['explanationimages']['name']);
	if($countfiles>0)
	{
		for ($i=0; $i < $countfiles; $i++) 
		{ 
			if($_FILES['explanationimages']['name'][$i]!="")
			{
			  $_FILES['optionimage']['name'] = $_FILES['explanationimages']['name'][$i];
	          $_FILES['optionimage']['type'] = $_FILES['explanationimages']['type'][$i];
	          $_FILES['optionimage']['tmp_name'] = $_FILES['explanationimages']['tmp_name'][$i];
	          $_FILES['optionimage']['error'] = $_FILES['explanationimages']['error'][$i];
	          $_FILES['optionimage']['size'] = $_FILES['explanationimages']['size'][$i];
	          $config['upload_path']          = './storage/pdfs';
	          $config['allowed_types']        = 'jpg|png|gif|jpeg';
			  $config['max_size']             = 2000;
			  $this->load->library('upload',$config);
			  if($this->upload->do_upload('optionimage'))
			  {
					$imgdata = $this->upload->data();
					$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
			  }
				else
				{
					$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
					redirect('admin/register/bulk_upload_quiz_questions', 'refresh');
				}
			}
		}
	}


	require_once APPPATH . "/third_party/PHPExcel.php";
	$path='./storage/pdfs/';
	if($_FILES['excel_file']['name']!=""){
		$config['upload_path']          = $path;
		$config['allowed_types']        = 'xlsx|csv|xls|ods';
		$config['max_size']             = 20000;
		$this->load->library('upload',$config);
		if($this->upload->do_upload('excel_file')){
			$data = array('upload_data' => $this->upload->data());
			if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            try {
					$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($inputFileName);
					$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    foreach ($allDataInSheet as $value) {
                      if($flag)
                      {
                      	$flag=false;
                      	continue;
                      }
                      $question_data['course_id'] = $data_input['course_id'];
                      $question_data['subject_id'] = $data_input['subject_id'];
                      $question_data['topic_id'] = $data_input['topic_id'];
                      $question_data['created_on'] = $data_input['created_on'];
                      $question_data['question'] = $value['A'];
                      $question_data['question_image'] = $value['B']?'storage/pdfs/'.$value['B']:$value['B'];
                      $question_data['answer'] = $value['C'];
                      $question_data['explanation'] = $value['D'];
                      $question_data['explanation_image'] = $value['E']?'storage/pdfs/'.$value['E']:$value['E'];
                      $question_data['reference'] = $value['F'];
                      $question_id=insert_table('quiz_questions', $question_data);

                      $option_data['course_id'] = $data_input['course_id'];
                      $option_data['subject_id'] = $data_input['subject_id'];
                      $option_data['quiz_id'] = $data_input['topic_id'];
                      $option_data['options'] = $value['G'];
                      $option_data['image'] = $value['H']?'storage/pdfs/'.$value['H']:$value['H'];
                      $option_data['created_on'] = $data_input['created_on'];
                      $option_data['question_id'] = $question_id;
                      insert_table('quiz_options', $option_data);

                      $option_data['course_id'] = $data_input['course_id'];
                      $option_data['subject_id'] = $data_input['subject_id'];
                      $option_data['quiz_id'] = $data_input['topic_id'];
                      $option_data['options'] = $value['I'];
                      $option_data['image'] = $value['J']?'storage/pdfs/'.$value['J']:$value['J'];
                      $option_data['created_on'] = $data_input['created_on'];
                      $option_data['question_id'] = $question_id;
                      insert_table('quiz_options', $option_data);

                      $option_data['course_id'] = $data_input['course_id'];
                      $option_data['subject_id'] = $data_input['subject_id'];
                      $option_data['quiz_id'] = $data_input['topic_id'];
                      $option_data['options'] = $value['K'];
                      $option_data['image'] = $value['L']?'storage/pdfs/'.$value['L']:$value['L'];
                      $option_data['created_on'] = $data_input['created_on'];
                      $option_data['question_id'] = $question_id;
                      insert_table('quiz_options', $option_data);

                      $option_data['course_id'] = $data_input['course_id'];
                      $option_data['subject_id'] = $data_input['subject_id'];
                      $option_data['quiz_id'] = $data_input['topic_id'];
                      $option_data['options'] = $value['M'];
                      $option_data['image'] = $value['N']?'storage/pdfs/'.$value['N']:$value['N'];
                      $option_data['created_on'] = $data_input['created_on'];
                      $option_data['question_id'] = $question_id;
                      insert_table('quiz_options', $option_data);

                    }
                    $this->session->set_flashdata('success', 'Record Updated Successfully.');
					redirect('admin/register/quiz_questions', 'refresh');
                      
              } catch (Exception $e) {
                   die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' .$e->getMessage());
                }
		}
		else{
			$error = array('error' => $this->upload->display_errors());
			// var_dump($this->upload->data());
			// echo $error['error'];die;
			$this->session->set_flashdata('success', 'File is must xlsx or csv or xls format.');
			redirect('admin/register/bulk_upload_quiz_questions', 'refresh');
		}
	}

}

public function quiz_questions()
{
	$data['title'] = "Education";		
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/list_quiz_questions', $data);
	$this->load->view('admin/includes/footer', $data);
}
public function add_quiz_questions()
{
	$data['title'] = "Education";
	$data['exams'] = $this->registermodel->get_mainexams();
	$data['subjects'] = $this->registermodel->get_mainsubjects();
	$data['quiz_topics'] = $this->registermodel->get_mainquiz_topics();
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/add_quiz_questions', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function update_quiz_questions()
{
	// echo "<pre>";var_dump($_FILES['questionimage']['name']);var_dump($_FILES['explanationimage']['name']);die;
	$data = array(
		'course_id' => $this->input->post('course_id'),
		'subject_id' => $this->input->post('subject_id'),
		'topic_id' => $this->input->post('topic_id'),
		'qbank_topic_id'=> $this->input->post('qbanktopic_id'),
		'question' => $this->input->post('question'),
		'answer' => $this->input->post('answer'),
		'explanation'=> $this->input->post('explanation'),
		'reference'=> $this->input->post('reference'),
		'question_image'=> $this->input->post('questionimage'),
		'explanation_image'=> $this->input->post('explanationimage'),
		'difficult_level'=> $this->input->post('difficult_level'),
		'tags'=>$this->input->post('tags'),
		'previous_appearance'=>$this->input->post('previous_appearance'),
		'question_order_no'=>$this->input->post('question_order_no'),
		'math_library'=>$this->input->post('math_library'),
		'created_on' => date('Y-m-d H:i:s')

	);
	//echo '<pre>';print_r($_POST);exit;
	$pearl=$this->input->post('pearl');
	/*if($_FILES['questionimage']['name']!=""){
		$config['upload_path']          = './storage/pdfs';
		$config['allowed_types']        = 'jpg|png|gif|jpeg';
		$config['max_size']             = 2000;
		$this->load->library('upload',$config);
		if($this->upload->do_upload('questionimage')){
			$imgdata = $this->upload->data();
			$questionimgurl = 'storage/pdfs/'.$imgdata['file_name'];
			$data['question_image']=$questionimgurl;
		}
		else{
			$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
			if($this->input->post('quiz_questions_id') == ""){
				redirect('admin/register/add_quiz_questions', 'refresh');
			}else{
				redirect('admin/register/edit_quiz_questions/'.$this->input->post('quiz_questions_id'), 'refresh');
			}
		}
	}
	if($_FILES['explanationimage']['name']!=""){
		$config['upload_path']          = './storage/pdfs';
		$config['allowed_types']        = 'jpg|png|gif|jpeg';
		$config['max_size']             = 2000;
		$this->load->library('upload',$config);
		if($this->upload->do_upload('explanationimage')){
			$imgdata = $this->upload->data();
			$explanationimgurl = 'storage/pdfs/'.$imgdata['file_name'];
			$data['explanation_image']=$explanationimgurl;
		}
		else{
			$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
			if($this->input->post('quiz_questions_id') == ""){
				redirect('admin/register/add_quiz_questions', 'refresh');
			}else{
				redirect('admin/register/edit_quiz_questions/'.$this->input->post('quiz_questions_id'), 'refresh');
			}
		}
	}*/
	if($this->input->post('quiz_questions_id') == "")
	{	
		$topicquestionsCount=$this->registermodel->get_topicsquestionscount($data['qbank_topic_id']);
		$qbank_topic_id=$data['qbank_topic_id'];
		$query="select count(id) as questions_count from quiz_questions where qbank_topic_id='".$qbank_topic_id."' ";

		$dbTopics_questions_count=$this->db->query($query)->row_array();
		$db_questions_count=$dbTopics_questions_count['questions_count'];

		//echo $topicquestionsCount;echo '<br>';echo $db_questions_count;exit;

		if($topicquestionsCount > $db_questions_count){

				$data['question_unique_id']=$this->registermodel->get_dynamic_id();

				$question_id=$this->registermodel->insert_quiz_questions($data);
        //$unique_id = insert_table('quiz_questions', $data);
				$unique_id = $data['question_unique_id'];
				//echo $this->db->last_query();exit;
				$options = $this->input->post('options');
				//$countfiles=count($_FILES['optionimages']['name']);
				if(!empty($options))
				{	
					$i=0;
					foreach($options as $option)
					{
						$imgurl=NULL;
						$optionimages=$this->input->post('optionimages');
						
						$options_data[] = array(
							'course_id' => $this->input->post('course_id'),
							'subject_id' => $this->input->post('subject_id'),
							'quiz_id'=>$this->input->post('topic_id'),
							'question_id' => $question_id,
							'options' => $option,
							'image'=> $optionimages[$i]
							//'image'=> $imgurl
						);
						$i++;
					}
					
					//echo '<pre>';print_r($options_data);exit;
					$unique_ids = insert_table('quiz_options', $options_data, '', true);
					$get_DBoptions=$this->db->query("select * from quiz_options where question_id='".$question_id."' ")->result_array();
					$json_option_data = json_encode($get_DBoptions); 
					$this->db->where(array('id'=>$question_id))->update('quiz_questions', array('options_data'=>$json_option_data));
					

					$this->registermodel->insert_export_Qbankquestions($unique_id,$data,$options_data);
				}
			

				$this->session->set_flashdata('success', 'Record added Successfully.');
				if($pearl !=''){
		          redirect('admin/register/add_pearl_to_question/'.$unique_id, 'refresh');
				}else{
		          redirect('admin/register/quiz_questions', 'refresh');
				}
		}else{
			$this->session->set_flashdata('error', 'Question Not Inserted Because Exceed Maxmium Limt of Qbank Tpoic..');
				
		    redirect('admin/register/add_quiz_questions', 'refresh');
				
		}
		
	}
	else
	{
		$data['modified_on'] = date('Y-m-d H:i:s');
		$quiz_questions_id=$this->input->post('quiz_questions_id');
		$query="select question_unique_id from quiz_questions where id='".$quiz_questions_id."' ";

		$db_question_uniquieID=$this->db->query($query)->row_array();
		
		if($db_question_uniquieID['question_unique_id'] == ''){
		$data['question_unique_id']=$this->registermodel->get_dynamic_id();
		}

		$event_id = update_table('quiz_questions', $data, array('id' => $this->input->post('quiz_questions_id')));
		// var_dump($this->input->post('options'));die;
		$optionarray=get_table('quiz_options',array('subject_id' => $this->input->post('subject_id'),'course_id' => $this->input->post('course_id'),'quiz_id'=>$this->input->post('topic_id'),'question_id'=>$this->input->post('quiz_questions_id')));
		$options = $this->input->post('options');
		if(!empty($options))
		{
			
			for ($i=0; $i <sizeof($options) ; $i++) {
				//$imgurl=$optionarray[$i]['image'];
				$optionimages=$this->input->post('optionimages');
				/*if($_FILES['optionimages']['name'][$i]!=""){
				  $_FILES['optionimage']['name'] = $_FILES['optionimages']['name'][$i];
		          $_FILES['optionimage']['type'] = $_FILES['optionimages']['type'][$i];
		          $_FILES['optionimage']['tmp_name'] = $_FILES['optionimages']['tmp_name'][$i];
		          $_FILES['optionimage']['error'] = $_FILES['optionimages']['error'][$i];
		          $_FILES['optionimage']['size'] = $_FILES['optionimages']['size'][$i];
		          $config['upload_path']          = './storage/pdfs';
		          $config['allowed_types']        = 'jpg|png|gif|jpeg';
				  $config['max_size']             = 2000;
				  $this->load->library('upload',$config);
				  if($this->upload->do_upload('optionimage')){
						$imgdata = $this->upload->data();
						$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
				  }
				  else{
					$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
					if($this->input->post('quiz_questions_id') == ""){
					redirect('admin/register/add_quiz_questions', 'refresh');
					}else{
					    redirect('admin/register/edit_quiz_questions/'.$this->input->post('quiz_questions_id'), 'refresh');
					}
				  }
				}*/
				// delete_record('quiz_options', array('question_id' => $this->input->post('quiz_questions_id')));

				$options_data[] = array(
					'course_id' => $this->input->post('course_id'),
					'subject_id' => $this->input->post('subject_id'),
					'quiz_id' => $this->input->post('topic_id'),
					'question_id' => $this->input->post('quiz_questions_id'),
					'options' => $options[$i],
					'image'=>$optionimages[$i]
					//'image'=>$imgurl
				);
			}
			//$quiz_questions_id=$this->input->post('quiz_questions_id');
			delete_record('quiz_options', array('question_id' => $this->input->post('quiz_questions_id')));
			$unique_id = insert_table('quiz_options', $options_data, '', true);

			$get_DBoptions=$this->db->query("select * from quiz_options where question_id='".$this->input->post('quiz_questions_id')."' ")->result_array();
			$json_option_data = json_encode($get_DBoptions); 
			$this->db->where(array('id'=>$this->input->post('quiz_questions_id')))->update('quiz_questions', array('options_data'=>$json_option_data));

			$this->registermodel->update_export_Qbankquestions($this->input->post('quiz_questions_id'),$data,$options_data);
		}
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_quiz_questions/'.$this->input->post('quiz_questions_id'), 'refresh');
	}
	
}
// 	$data = array(
// 	'course_id' => $this->input->post('course_id'),
//    'subject_id' => $this->input->post('subject_id'),
//    'topic_id' => $this->input->post('topic_id'),
//    'question' => $this->input->post('question'),
//    'answer' => $this->input->post('answer'),
//    'explanation'=> $this->input->post('explanation'),
//    'reference'=> $this->input->post('reference'),

// 		);
		
// 		$data['modified_on'] = date('Y-m-d H:i:s');
// 		$this->registermodel->update_quiz_questions($data, $this->input->post('quiz_questions_id'));
// 		$this->session->set_flashdata('success', 'Record Updated Successfully.');
// 		redirect('admin/register/edit_quiz_questions/'.$this->input->post('quiz_questions_id'), 'refresh');
// 	}		
// }
// }
public function edit_quiz_questions()
{
	$data['title'] = "Education";
	$questions = $this->registermodel->edit_quiz_questions();
	$options = $this->registermodel->edit_quiz_questionsoptions();
	$data['questions']=$questions;
	$data['options']=$options;
	// var_dump($data['questions']);
	//echo '<pre>'; print_r($data['questions']);	exit();	
	$data['courses'] = $this->registermodel->get_mainexams();
	$data['subjects'] = $this->registermodel->get_courseWiseSubjects($questions->course_id);
	$data['qbankChapters'] = $this->registermodel->get_qbankChapters($questions->course_id,$questions->subject_id);
	$data['qbankTopics'] = $this->registermodel->get_qbankTopics($questions->course_id,$questions->subject_id,$questions->topic_id);
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/edit_quiz_questions', $data);
	$this->load->view('admin/includes/footer', $data);
}
public function delete_quiz_questions($quiz_questions_id)
	{
		if(delete_record('quiz_questions', array('id' => $quiz_questions_id)) == true)
		{
			// delete_record('activity', array('section_id' => $quiz_questions_id, 'type' => 'quiz_questions'));
			delete_record('quiz_options', array('question_id' => $quiz_questions_id));
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		redirect('admin/register/quiz_questions', 'refresh');
	}


public function change_events_type_to_recommendeds($quiz_questions_id, $recommended)
{
	if($this->registermodel->change_event_type_to_recommended($quiz_questions_id, $recommended) == true)
	{
		$this->session->set_flashdata('success', 'Updated Successfully.');
	}
	else
	{
		$this->session->set_flashdata('fail', 'Error in Updating.');
	}
	redirect('admin/register/quiz_questions', 'refresh');
} 



public function get_topicinfo()
           {
		$course_id = $this->input->post('course_id');
		$subject_id = $this->input->post('subject_id');
		
	  $topics = get_table('quiz_topics',array('subject_id' => $subject_id,'course_id' => $course_id));
	//   var_dump($this->db->last_query());exit();
            echo '<option value="">Select Topics</option>';
       if(!empty($topics))
       {
          foreach($topics as $topic)
      {
     echo '<option value="'.$topic['id'].'">'.$topic['topic_name'].'</option>';
      }
        }
	}

	public function change_quiz_question_status($user_id, $status)
	{
		if($this->registermodel->change_quiz_question_status($user_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/quiz_questions', 'refresh');
	}

/*----------- /quiz_questions --------------*/

/*----------- /pearl to question --------------*/

public function all_pearls()
{
	
  $result = $this->registermodel->all_pearls($_POST);
  $result_count=$this->registermodel->all_pearls($_POST,1);
  $json_data = array(
		"draw"  => intval($_POST['draw'] ),
		"iTotalRecords"  => intval($result_count ),
		"iTotalDisplayRecords"  => intval($result_count ),
		"recordsFiltered"  => intval(count($result) ),
		"data"  => $result);  
	echo json_encode($json_data);
}

public function pearls()
{
	$data['title'] = "Education";		
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/list_pearls', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function add_pearl_to_question($question_id=''){

	$data['question_id']=$question_id;
	if($question_id !=''){
	$data['question']=$this->registermodel->get_quizquestionData($question_id);
	
	$data['subjects'] = $this->registermodel->get_courseWiseSubjects($data['question']['course_id']);
	$data['qbankChapters'] = $this->registermodel->get_qbankChapters($data['question']['course_id'],$data['question']['subject_id']);
	$data['qbankTopics'] = $this->registermodel->get_qbankTopics($data['question']['course_id'],$data['question']['subject_id'],$data['question']['topic_id']);
	$course_id=$data['question']['course_id'];
	$subject_id=$data['question']['subject_id'];
	$chapter_id=$data['question']['topic_id'];
	$topic_id=$data['question']['qbank_topic_id'];
	$data['existing_pearls']=$this->registermodel->get_existingPearls($course_id,$subject_id,$chapter_id,$topic_id);
	}

    $data['courses'] = $this->registermodel->get_mainexams();
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/add_pearl_to_question', $data);
	$this->load->view('admin/includes/footer', $data);
} 

 

public function update_pearl_to_question()
{
		
	$question_id=$this->input->post('question_id');
	if($question_id !=''){
	$res=$this->db->query("select id,question_unique_id from quiz_questions where id='".$question_id."' ")->row_array();
	$question_unique_id=$res['question_unique_id'];
	}else{
	$question_unique_id='';
	}

    $pearl_type = $this->input->post('peral_type');
	$data = array(
			   'course_id' => $this->input->post('course_id'),
			   'subject_id' => $this->input->post('subject_id'),
			   'chapter_id' => $this->input->post('topic_id'),
			   'topic_id' => $this->input->post('qbanktopic_id'),
			   'title' => $this->input->post('title'),
			   'icon_image_path' => $this->input->post('icon_image'),
			   'explanation' => $this->input->post('explanation'),
				);
//echo '<pre>';print_r($data);exit;
		if($this->input->post('pearl_id') == "")
		{			
		$data['created_on'] = date('Y-m-d H:i:s');	
		$pcount=$this->db->query("select count(id) as pearl_count from qbank_pearls")->row_array();
		$pearl_count=$pcount['pearl_count']+1;
		$data['pearl_number']=$pearl_count;
		//echo '<pre>';print_r($data);exit;
		if($pearl_type == 'new'){
		$this->registermodel->insert_pearl($data,$question_unique_id);
			}else{
		$exist_pearl_id = $this->input->post('exist_pearl_id');
		$this->registermodel->insert_pearlQuestions($exist_pearl_id,$question_unique_id);
			}
		$this->session->set_flashdata('success', 'Record added Successfully.');
		if($question_unique_id !=''){
		redirect('admin/register/quiz_questions', 'refresh');
			}else{
		redirect('admin/register/pearls', 'refresh');
			}
		}else{
		
		$data['modified_on'] = date('Y-m-d H:i:s');
		//$data['question_unique_id'] = $this->input->post('question_unique_id');
		//echo '<pre>';print_r($data);exit;
		$this->registermodel->update_pearl($data, $this->input->post('pearl_id'));
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_pearls/'.$this->input->post('pearl_id'), 'refresh');
	}		
}

public function edit_pearls()
{
	$data['title'] = "Education";
	$data['pearl'] = $this->registermodel->edit_pearls();
	$data['subjects'] = $this->registermodel->get_courseWiseSubjects($data['pearl']['course_id']);
	$data['qbankChapters'] = $this->registermodel->get_qbankChapters($data['pearl']['course_id'],$data['pearl']['subject_id']);
	$data['qbankTopics'] = $this->registermodel->get_qbankTopics($data['pearl']['course_id'],$data['pearl']['subject_id'],$data['pearl']['topic_id']);
	$data['courses'] = $this->registermodel->get_mainexams();
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/edit_pearls', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function delete_pearls($id)
	{
		if($this->registermodel->delete_pearls($id) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		
		redirect('admin/register/pearls', 'refresh');
	} 

	public function change_pearl_status($id, $status)
	{
		if($this->registermodel->change_pearl_status($id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/pearls', 'refresh');
	}


/*----------- /pearl to question --------------*/

/*----------- test_series_quiz --------------*/

public function all_test_series_quiz()
{
	
  $test_series_quiz = $this->registermodel->all_test_series_quiz($_POST);
$result_count=$this->registermodel->all_test_series_quiz($_POST,1);
  $json_data = array(
		"draw"  => intval($_POST['draw'] ),
		"iTotalRecords"  => intval($result_count ),
		"iTotalDisplayRecords"  => intval($result_count ),
		"recordsFiltered"  => intval(count($test_series_quiz) ),
		"data"  => $test_series_quiz);  
	echo json_encode($json_data);
}

public function test_series_quiz()
{
	$data['title'] = "Education";		
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/list_test_series_quiz', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function testseries_questions_list($topic_id){

	$data['title'] = "Education";		
	$data['topic']=$this->registermodel->getTestSeriesTopic($topic_id);
	$data['questions_list']=$this->registermodel->getTestSeriesTopicQuestions($topic_id);
	$data['testseries_topic_id']=$topic_id;
	$data['exams']=$this->registermodel->getCourses();
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/list_test_series_quiz_questions', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function change_test_series_question_status($id, $status,$topic_id)
	{
		if($this->registermodel->change_testseries_que_status($id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/testseries_questions_list/'.$topic_id, 'refresh');
	}

	public function update_testseries_question_order(){

		//echo '<pre>';print_r($_POST);exit;

		if($this->input->post() !=''){
			$post=$this->input->post();
			$topic_id=$this->input->post('testseries_topic_id');
			
//echo '<pre>';print_r($post);exit;
			if($this->input->post('course_id') !=''){
				
				$data['questions']=$this->registermodel->get_testseriesquestions($topic_id);
				//echo 'copy';
				
				$this->registermodel->copyTestSeriesQuestions($post['question_ids'],$post);

					//$db_quiz_id=$this->db->insert_id();
				$this->session->set_flashdata('success', 'Records Copied Successfully.');
				}
				
			else if ($this->input->post('move_course_id') !='') {
					//echo 'move';
					//echo '<pre>';print_r($post);exit;
				$data['questions']=$this->registermodel->get_testseriesquestions($topic_id);
				$this->registermodel->moveTestSeriesQuestions($post['question_ids'],$post);

				$this->session->set_flashdata('success', 'Records Moved Successfully.');
			}else{
				$this->registermodel->updateTestSeriesQuestionOrder($post['que']);
				$this->session->set_flashdata('success', 'Records updated Successfully.');
			}

			
		    redirect('admin/register/testseries_questions_list/'.$topic_id, 'refresh');
		}else{
		   $this->session->set_flashdata('success', 'Record added Successfully.');
		   redirect('admin/register/testseries_questions_list/'.$topic_id, 'refresh');
		}

	}

public function bulk_upload_testseries()
{
	$data['title'] = "Education";
	$data['exams'] = $this->registermodel->get_mainexams();
	$data['categories'] = $this->registermodel->get_test_series_categories();
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/bulk_upload_testseries', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function change_test_series_qiuz_status($id, $status)
	{
		if($this->registermodel->change_test_series_qiuz_status($id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/test_series_quiz', 'refresh');
	}

public function submit_bulk_upload_testseries()
{

	$data_input = array(
		'course_id' => $this->input->post('course_id'),
		'category_id' => $this->input->post('category_id'),
		'quiz_id' => $this->input->post('quiz_id'),
		'created_on' => date('Y-m-d H:i:s')
	);
	$countfiles=count($_FILES['images']['name']);
	if($countfiles>0)
	{
		for ($i=0; $i < $countfiles; $i++) 
		{ 
			if($_FILES['images']['name'][$i]!="")
			{
			  $_FILES['optionimage']['name'] = $_FILES['images']['name'][$i];
	          $_FILES['optionimage']['type'] = $_FILES['images']['type'][$i];
	          $_FILES['optionimage']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
	          $_FILES['optionimage']['error'] = $_FILES['images']['error'][$i];
	          $_FILES['optionimage']['size'] = $_FILES['images']['size'][$i];
	          $config['upload_path']          = './storage/pdfs';
	          $config['allowed_types']        = 'jpg|png|gif|jpeg';
			  $config['max_size']             = 2000;
			  $this->load->library('upload',$config);
			  if($this->upload->do_upload('optionimage'))
			  {
					$imgdata = $this->upload->data();
					$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
			  }
				else
				{
					$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
					redirect('admin/register/bulk_upload_quiz_questions', 'refresh');
				}
			}
		}
	}

	$countfiles=count($_FILES['questionimages']['name']);
	if($countfiles>0)
	{
		for ($i=0; $i < $countfiles; $i++) 
		{ 
			if($_FILES['questionimages']['name'][$i]!="")
			{
			  $_FILES['optionimage']['name'] = $_FILES['questionimages']['name'][$i];
	          $_FILES['optionimage']['type'] = $_FILES['questionimages']['type'][$i];
	          $_FILES['optionimage']['tmp_name'] = $_FILES['questionimages']['tmp_name'][$i];
	          $_FILES['optionimage']['error'] = $_FILES['questionimages']['error'][$i];
	          $_FILES['optionimage']['size'] = $_FILES['questionimages']['size'][$i];
	          $config['upload_path']          = './storage/pdfs';
	          $config['allowed_types']        = 'jpg|png|gif|jpeg';
			  $config['max_size']             = 2000;
			  $this->load->library('upload',$config);
			  if($this->upload->do_upload('optionimage'))
			  {
					$imgdata = $this->upload->data();
					$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
			  }
				else
				{
					$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
					redirect('admin/register/bulk_upload_quiz_questions', 'refresh');
				}
			}
		}
	}

	$countfiles=count($_FILES['explanationimages']['name']);
	if($countfiles>0)
	{
		for ($i=0; $i < $countfiles; $i++) 
		{ 
			if($_FILES['explanationimages']['name'][$i]!="")
			{
			  $_FILES['optionimage']['name'] = $_FILES['explanationimages']['name'][$i];
	          $_FILES['optionimage']['type'] = $_FILES['explanationimages']['type'][$i];
	          $_FILES['optionimage']['tmp_name'] = $_FILES['explanationimages']['tmp_name'][$i];
	          $_FILES['optionimage']['error'] = $_FILES['explanationimages']['error'][$i];
	          $_FILES['optionimage']['size'] = $_FILES['explanationimages']['size'][$i];
	          $config['upload_path']          = './storage/pdfs';
	          $config['allowed_types']        = 'jpg|png|gif|jpeg';
			  $config['max_size']             = 2000;
			  $this->load->library('upload',$config);
			  if($this->upload->do_upload('optionimage'))
			  {
					$imgdata = $this->upload->data();
					$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
			  }
				else
				{
					$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
					redirect('admin/register/bulk_upload_quiz_questions', 'refresh');
				}
			}
		}
	}


	require_once APPPATH . "/third_party/PHPExcel.php";
	$path='./storage/pdfs/';
	if($_FILES['excel_file']['name']!=""){
		$config['upload_path']          = $path;
		$config['allowed_types']        = 'xlsx|csv|xls|ods';
		$config['max_size']             = 20000;
		$this->load->library('upload',$config);
		if($this->upload->do_upload('excel_file')){
			$data = array('upload_data' => $this->upload->data());
			if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            try {
					$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($inputFileName);
					$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    foreach ($allDataInSheet as $value) {
                      if($flag)
                      {
                      	$flag=false;
                      	continue;
                      }	
                      $question_data['course_id'] = $data_input['course_id'];
                      $question_data['category_id'] = $data_input['category_id'];
                      $question_data['quiz_id'] = $data_input['quiz_id'];
                      $question_data['created_on'] = $data_input['created_on'];
                      $question_data['question'] = $value['A'];
                      $question_data['question_image'] = $value['B']?'storage/pdfs/'.$value['B']:$value['B'];
                      $question_data['answer'] = $value['C'];
                      $question_data['explanation'] = $value['D'];
                      $question_data['explanation_image'] = $value['E']?'storage/pdfs/'.$value['E']:$value['E'];
                      $question_data['reference'] = $value['F'];
                      $question_id=insert_table('test_series_questions', $question_data);

                      $option_data['course_id'] = $data_input['course_id'];
                      $option_data['category_id'] = $data_input['category_id'];
                      $option_data['quiz_id'] = $data_input['quiz_id'];
                      $option_data['options'] = $value['G'];
                      $option_data['image'] = $value['H']?'storage/pdfs/'.$value['H']:$value['H'];
                      $option_data['created_on'] = $data_input['created_on'];
                      $option_data['question_id'] = $question_id;
                      insert_table('test_series_options', $option_data);

                      $option_data['course_id'] = $data_input['course_id'];
                      $option_data['category_id'] = $data_input['category_id'];
                      $option_data['quiz_id'] = $data_input['quiz_id'];
                      $option_data['options'] = $value['I'];
                      $option_data['image'] = $value['J']?'storage/pdfs/'.$value['J']:$value['J'];
                      $option_data['created_on'] = $data_input['created_on'];
                      $option_data['question_id'] = $question_id;
                      insert_table('test_series_options', $option_data);

                      $option_data['course_id'] = $data_input['course_id'];
                      $option_data['category_id'] = $data_input['category_id'];
                      $option_data['quiz_id'] = $data_input['quiz_id'];
                      $option_data['options'] = $value['K'];
                      $option_data['image'] = $value['L']?'storage/pdfs/'.$value['L']:$value['L'];
                      $option_data['created_on'] = $data_input['created_on'];
                      $option_data['question_id'] = $question_id;
                      insert_table('test_series_options', $option_data);

                      $option_data['course_id'] = $data_input['course_id'];
                      $option_data['category_id'] = $data_input['category_id'];
                      $option_data['quiz_id'] = $data_input['quiz_id'];
                      $option_data['options'] = $value['M'];
                      $option_data['image'] = $value['N']?'storage/pdfs/'.$value['N']:$value['N'];
                      $option_data['created_on'] = $data_input['created_on'];
                      $option_data['question_id'] = $question_id;
                      insert_table('test_series_options', $option_data);

                    }
                    $this->session->set_flashdata('success', 'Record Updated Successfully.');
					redirect('admin/register/test_series_questions', 'refresh');
                      
              } catch (Exception $e) {
                   die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' .$e->getMessage());
                }
		}
		else{
			$error = array('error' => $this->upload->display_errors());
			// var_dump($this->upload->data());
			// echo $error['error'];die;
			$this->session->set_flashdata('success', 'File is must xlsx or csv or xls format.');
			redirect('admin/register/bulk_upload_testseries', 'refresh');
		}
	}
}

public function add_test_series_quiz()
{
	$data['title'] = "Education";
	$data['exams'] = $this->registermodel->get_mainexams();
	//$data['test_series_categories'] = $this->registermodel->get_test_series_categories();
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/add_test_series_quiz', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function update_test_series_quiz($type='')
{
		$config['upload_path']          = './storage/test_series_quiz';
		$config['allowed_types']        = 'pdf|jpg|png|gif|jpeg';
		$config['max_size']             = 2000;

		$this->load->library('upload', $config);
		 /*$if ( ! $this->upload->do_upload('image')){
		 $error = array('error' => $this->upload->display_errors());
		 print_r($error);
		 }*/
		if($this->upload->do_upload('image')){
		$imgdata = $this->upload->data();
		//echo '<pre>';print_r($imgdata);
		$image = 'storage/test_series_quiz/'.$imgdata['file_name'];
		}else{
		$image = '';
		}

		/*$banner_image=$_FILES['banner_image'];

		if($banner_image['name']!=''){
			$config['upload_path']          = './storage/pdfs';
			$config['allowed_types']        = 'pdf';
			$config['max_size']             = 2000;
	        $this->load->library('upload',$config);
	        if($this->upload->do_upload('pdf')){
				$imgdata = $this->upload->data();
				$banner_imageUrl = 'storage/pdfs/'.$imgdata['file_name'];
				
			}else{
				$this->session->set_flashdata('success', 'File is must PDF format.');
				if($this->input->post('test_series_quiz_id') == ""){
				redirect('admin/register/add_test_series_quiz', 'refresh');
				}else{
				    redirect('admin/register/edit_test_series_quiz/'.$this->input->post('test_series_quiz_id'), 'refresh');
				}
			}
		}else{
			$banner_imageUrl='';
		}*/
$exam_date=$this->input->post('exam_time');
if($exam_date != ''){
$timestamp = strtotime($exam_date);
$convert_exam_date=date("Y-m-d", $timestamp);
$datetimepicker= $convert_exam_date.' '.$this->input->post('timepicker').':00';
}else{
$convert_exam_date='';	
}

$expiry_date=$this->input->post('expiry_date');
if($expiry_date !=''){
$timestamp2 = strtotime($expiry_date);
$convert_expiry_date=date("Y-m-d", $timestamp2);
}else{
$convert_expiry_date='';
}


//echo '<pre>';print_r($timepicker);exit;
	$data = array(
			   'course_id' => $this->input->post('course_id'),
			   'category_id' => $this->input->post('category_id'),
			   'subject_id' => $this->input->post('subject_id'),
			   'title' => $this->input->post('title'),
			   'order' => $this->input->post('order'),
			   'questions_count' => $this->input->post('questions_count'),
			   'description' => $this->input->post('description'),
			   'time' => $this->input->post('time'),
			   'exam_time' => $datetimepicker,
			   'expiry_date' => $convert_expiry_date,
			   'quiz_type'=> $this->input->post('quiz_type'),
			   'suggested_test_series'=> $this->input->post('suggested_test_series'),
			   'uploaded_pdf_path'=> $this->input->post('uploaded_pdf_path'),
			   'test_series_image'=>$image,
				);
//echo '<pre>';print_r($data);exit;

	if($type=='insert')
	{
		if($this->input->post('test_series_quiz_id') == "")
		{			
		$data['created_on'] = date('Y-m-d H:i:s');	
		$this->registermodel->insert_test_series_quiz($data);
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/test_series_quiz', 'refresh');
		}
	}else{

	
	//	var_dump($data);exit();
	//	print_r($data);exit();
		$res=$this->common_model->get_table_row('test_series_quiz',array('id'=>$this->input->post('test_series_quiz_id')),array());
		 //echo '<pre>';print_r($res);exit;
		 if($image == ''){
			$data['test_series_image']= $res['test_series_image'];
		 }else{
				$file = './'.$res['test_series_image'];
				if(is_file($file))
				unlink($file);
		 }
		
		$data['modified_on'] = date('Y-m-d H:i:s');
		//echo '<pre>';print_r($data);exit;
		$this->registermodel->update_test_series_quiz($data, $this->input->post('test_series_quiz_id'));
		$this->registermodel->update_questionsCousres_data($data, $this->input->post('test_series_quiz_id'));
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_test_series_quiz/'.$this->input->post('test_series_quiz_id'), 'refresh');
	}		
}

public function edit_test_series_quiz()
{
	$data['title'] = "Education";
	if($query = $this->registermodel->edit_test_series_quiz())
	{
		$data['row'] = $query;
	}
	$data['exams'] = $this->registermodel->get_mainexams();
	$data['subjects'] = $this->registermodel->get_subjectswithCourse($query->course_id);
	$data['test_series_categories'] = $this->registermodel->get_test_series_categories($query->course_id);		
	//echo '<pre>';print_r($data['subjects']);exit();	
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/edit_test_series_quiz', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function delete_test_series_quiz($tquiz_id)
{
	if(delete_record('test_series_quiz', array('id' => $tquiz_id)) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
	redirect('admin/register/test_series_quiz', 'refresh');
}

public function change_eventstest_series_quiz_type_to_recommended($test_series_quiz_id, $recommended)
{
	if($this->registermodel->change_event_type_to_recommended($test_series_quiz_id, $recommended) == true)
	{
		$this->session->set_flashdata('success', 'Updated Successfully.');
	}
	else
	{
		$this->session->set_flashdata('fail', 'Error in Updating.');
	}
	redirect('admin/register/test_series_quiz', 'refresh');
} 

public function get_test_seriescategories()
{
	
  $subjects = get_table('test_series_categories');
 //print_r($subjects);exit;
		echo '<option value="">Select categories</option>';
   if(!empty($subjects))
   {
	  foreach($subjects as $subject)
  {
 echo '<option value="'.$subject['id'].'">'.$subject['title'].'</option>';
  }
}
}	
/*----------- /test_series_quiz --------------*/


/*----------- test_series_questions --------------*/

public function all_test_series_questions()
{
	
  $test_series_questions = $this->registermodel->all_test_series_questions($_POST);
$result_count=$this->registermodel->all_test_series_questions($_POST,1);
  $json_data = array(
		"draw"  => intval($_POST['draw'] ),
		"iTotalRecords"  => intval($result_count ),
		"iTotalDisplayRecords"  => intval($result_count ),
		"recordsFiltered"  => intval(count($test_series_questions) ),
		"data"  => $test_series_questions);  
	echo json_encode($json_data);
}

public function test_series_questions()
{
	$data['title'] = "Education";		
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/list_test_series_questions', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function add_test_series_questions_back()
{
	$data['title'] = "Education";
	$data['exams'] = $this->registermodel->get_mainexams();
	$data['categories'] = $this->registermodel->get_test_series_categories();
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/add_test_series_questions', $data);
	$this->load->view('admin/includes/footer', $data);
}
public function add_test_series_questions($tquiz_id='')
{
	$data['title'] = "Education";
	if($tquiz_id !=''){
	$data['ids'] = $this->registermodel->getExamCatids($tquiz_id);	
	}else{$data['ids']=array();}
	$data['exams'] = $this->registermodel->get_mainexams();
	//$data['categories'] = $this->registermodel->get_test_series_categories();
	$data['subjects'] = $this->registermodel->subjects();

	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/add_test_series_questions', $data);
	$this->load->view('admin/includes/footer', $data);
}


public function get_quiz_topics_info(){
	$quiz_topics=$this->registermodel->get_quiz_topics_info($_POST);
	// var_dump($this->db->last_query());die;
	$html = '<option value="">Select Quiz</option>';
	if(!empty($quiz_topics)){
		foreach ($quiz_topics as $quiz) {
			$html.='<option value='.$quiz['id'].'>'.$quiz['title'].'</option>';
		}
	}
	echo $html;
}

public function get_qbank_quiz(){
	$quiz_topics=$this->registermodel->get_qbank_quiz($_POST);
	// var_dump($this->db->last_query());die;
	$html = '<option value="">Select Quiz</option>';
	if(!empty($quiz_topics)){
		foreach ($quiz_topics as $quiz) {
			$html.='<option value='.$quiz['id'].'>'.$quiz['title'].'</option>';
		}
	}
	echo $html;
}

public function update_test_series_questions()
{

	$data = array(
		'course_id' => $this->input->post('course_id'),
		'category_id' => $this->input->post('category_id'),
		'quiz_id' => $this->input->post('quiz_id'),
		'subject_id' => $this->input->post('subject_id'),
		'question' => $this->input->post('question'),
		'answer' => $this->input->post('answer'),
		'explanation'=> $this->input->post('explanation'),
		'question_image'=> $this->input->post('questionimage'),
		'explanation_image'=> $this->input->post('explanationimage'),
		'reference'=> $this->input->post('reference'),
		'positive_marks'=>  $this->input->post('positive_marks'),
		'negative_marks'=> $this->input->post('negative_marks'),
		'que_number'=> $this->input->post('que_number'),
		'question_type'=> $this->input->post('question_type'),
		'math_library'=>$this->input->post('math_library'),

	);

	/*if($_FILES['questionimage']['name']!=""){
		$config['upload_path']          = './storage/pdfs';
		$config['allowed_types']        = 'jpg|png|gif|jpeg';
		$config['max_size']             = 2000;
		$this->load->library('upload',$config);
		if($this->upload->do_upload('questionimage')){
			$imgdata = $this->upload->data();
			$questionimgurl = 'storage/pdfs/'.$imgdata['file_name'];
			$data['question_image']=$questionimgurl;
		}
		else{
			$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
			if($this->input->post('quiz_questions_id') == ""){
				redirect('admin/register/add_quiz_questions', 'refresh');
			}else{
				redirect('admin/register/edit_quiz_questions/'.$this->input->post('quiz_questions_id'), 'refresh');
			}
		}
	}*/
	/*if($_FILES['explanationimage']['name']!=""){
		$config['upload_path']          = './storage/pdfs';
		$config['allowed_types']        = 'jpg|png|gif|jpeg';
		$config['max_size']             = 2000;
		$this->load->library('upload',$config);
		if($this->upload->do_upload('explanationimage')){
			$imgdata = $this->upload->data();
			$explanationimgurl = 'storage/pdfs/'.$imgdata['file_name'];
			$data['explanation_image']=$explanationimgurl;
		}
		else{
			$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
			if($this->input->post('quiz_questions_id') == ""){
				redirect('admin/register/add_quiz_questions', 'refresh');
			}else{
				redirect('admin/register/edit_quiz_questions/'.$this->input->post('quiz_questions_id'), 'refresh');
			}
		}
	}*/

	if($this->input->post('test_series_questions_id') == "")
	{
	    $data['created_on'] = date('Y-m-d H:i:s');
	    $data['question_dynamic_id'] = $this->registermodel->get_test_series_dynamic_id();	
        $question_id = $this->registermodel->insert_test_series_questions($data);
        if($question_id>0)
        {
        $options = $this->input->post('options');
			if(!empty($options)){
			$i=0;
			for ($i=0; $i < sizeof($options) ; $i++) {
				$imgurl=NULL;
				$optionimages=$this->input->post('optionimages');
				/*if($_FILES['optionimages']['name'][$i]!="")
				{
					  $_FILES['optionimage']['name'] = $_FILES['optionimages']['name'][$i];
			          $_FILES['optionimage']['type'] = $_FILES['optionimages']['type'][$i];
			          $_FILES['optionimage']['tmp_name'] = $_FILES['optionimages']['tmp_name'][$i];
			          $_FILES['optionimage']['error'] = $_FILES['optionimages']['error'][$i];
			          $_FILES['optionimage']['size'] = $_FILES['optionimages']['size'][$i];
			          $config['upload_path']          = './storage/pdfs';
			          $config['allowed_types']        = 'jpg|png|gif|jpeg';
					  $config['max_size']             = 2000;
					  $this->load->library('upload',$config);
					  if($this->upload->do_upload('optionimage')){
							$imgdata = $this->upload->data();
							$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
					  }
					  else{
						$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
						if($this->input->post('test_series_questions_id') == ""){
						redirect('admin/register/add_test_series_questions/'.$this->input->post('quiz_id'), 'refresh');
						}else{
						    redirect('admin/register/edit_test_series_questions/'.$this->input->post('test_series_questions_id'), 'refresh');
						}
					  }
				}*/
				$options_data[]=array(
					'course_id' => $this->input->post('course_id'),
					'category_id' => $this->input->post('category_id'),
					'subject_id' => $this->input->post('subject_id'),
					'quiz_id' => $this->input->post('quiz_id'),
					'question_id' => $question_id,
					'options' => $options[$i],
					//'image'=>$imgurl,
					'image'=>$optionimages[$i],
					'created_on' => date('Y-m-d H:i:s')
				);
			}
			// var_dump($options_data);exit;
			$unique_id = insert_table('test_series_options', $options_data, '', true);

			$get_DBoptions=$this->db->query("select * from test_series_options where question_id='".$question_id."' ")->result_array();
			$json_option_data = json_encode($get_DBoptions); 
			$this->db->where(array('id'=>$question_id))->update('test_series_questions', array('options'=>$json_option_data));
	
			// var_dump($this->input->post('test_series_questions_id'));die;
		}
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/add_test_series_questions/'.$this->input->post('quiz_id'), 'refresh');
        }else{
            
            $this->session->set_flashdata('Fail', '.Fail');
        }
	}
	else
	{	
		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_test_series_questions($data, $this->input->post('test_series_questions_id'));
		$optionarray=get_table('test_series_options',array('category_id' => $this->input->post('category_id'),'course_id' => $this->input->post('course_id'),'quiz_id'=>$this->input->post('quiz_id'),'question_id'=>$this->input->post('test_series_questions_id')));
		$options = $this->input->post('options');
		// var_dump($options);die;
		if(!empty($options)){
			for ($i=0; $i < sizeof($options) ; $i++) {
				//$imgurl=$optionarray[$i]['image'];
				$optionimages=$this->input->post('optionimages');
				/*if($_FILES['optionimages']['name'][$i]!=""){
				  $_FILES['optionimage']['name'] = $_FILES['optionimages']['name'][$i];
		          $_FILES['optionimage']['type'] = $_FILES['optionimages']['type'][$i];
		          $_FILES['optionimage']['tmp_name'] = $_FILES['optionimages']['tmp_name'][$i];
		          $_FILES['optionimage']['error'] = $_FILES['optionimages']['error'][$i];
		          $_FILES['optionimage']['size'] = $_FILES['optionimages']['size'][$i];
		          $config['upload_path']          = './storage/pdfs';
		          $config['allowed_types']        = 'jpg|png|gif|jpeg';
				  $config['max_size']             = 2000;
				  $this->load->library('upload',$config);
				  if($this->upload->do_upload('optionimage')){
						$imgdata = $this->upload->data();
						$imgurl = 'storage/pdfs/'.$imgdata['file_name'];
				  }
				  else{
					$this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
					if($this->input->post('quiz_questions_id') == ""){
					redirect('admin/register/add_test_series_questions/'.$this->input->post('quiz_id'), 'refresh');
					}else{
					    redirect('admin/register/edit_test_series_questions/'.$this->input->post('test_series_questions_id'), 'refresh');
					}
				  }
				}*/
				delete_record('test_series_options', array('question_id' => $this->input->post('test_series_questions_id')));
				// var_dump($this->db->last_query());die;
				$options_data[]=array(
					'course_id' => $this->input->post('course_id'),
					'category_id' => $this->input->post('category_id'),
					'quiz_id' => $this->input->post('quiz_id'),
					'subject_id' => $this->input->post('subject_id'),
					'question_id' => $this->input->post('test_series_questions_id'),
					'options' => $options[$i],
					//'image'=>$imgurl,
					'image'=>$optionimages[$i],
					'created_on' => date('Y-m-d H:i:s')
				);
			}
			// var_dump($options_data);exit;
			$unique_id = insert_table('test_series_options', $options_data, '', true);
			
			$get_DBoptions=$this->db->query("select * from test_series_options where question_id='".$this->input->post('test_series_questions_id')."' ")->result_array();
			$json_option_data = json_encode($get_DBoptions); 
			$this->db->where(array('id'=>$this->input->post('test_series_questions_id')))->update('test_series_questions', array('options'=>$json_option_data));
	

			// var_dump($this->input->post('test_series_questions_id'));die;
		}
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_test_series_questions/'.$this->input->post('test_series_questions_id'), 'refresh');
	}		
}

public function edit_test_series_questions()
{
	$data['title'] = "Education";
	$data['question'] =$this->registermodel->edit_test_series_questions();
	$data['options'] = $this->registermodel->edit_test_series_question_options();
	//var_dump($data['row']);	exit();	
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/edit_test_series_questions', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function delete_test_series_questions($test_quest_id)
{
	if(delete_record('test_series_questions', array('id' => $test_quest_id)) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
	redirect('admin/register/test_series_questions', 'refresh');
}

public function change_events_type_to_recommendeds_data($test_series_questions_id, $recommended)
{
	if($this->registermodel->change_event_type_to_recommended($test_series_questions, $recommended) == true)
	{
		$this->session->set_flashdata('success', 'Updated Successfully.');
	}
	else
	{
		$this->session->set_flashdata('fail', 'Error in Updating.');
	}
	redirect('admin/register/test_series_questions', 'refresh');
} 

public function change_testseries_que_status($user_id, $status)
	{
		if($this->registermodel->change_testseries_que_status($user_id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/test_series_questions', 'refresh');
	}

	
/*----------- /test_series_questions --------------*/



/*----------- quiz_reports --------------*/

public function all_quiz_reports()
{
	
  $quiz_reports = $this->registermodel->all_quiz_reports($_POST);
  // var_dump($this->db->last_query());die;
$result_count=$this->registermodel->all_quiz_reports($_POST,1);
// var_dump($this->db->last_query());die;
  $json_data = array(
		"draw"  => intval($_POST['draw'] ),
		"iTotalRecords"  => intval($result_count ),
		"iTotalDisplayRecords"  => intval($result_count ),
		"recordsFiltered"  => intval(count($quiz_reports) ),
		"data"  => $quiz_reports);  
	echo json_encode($json_data);
}

public function quiz_reports()
{
	$data['title'] = "Education";		
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/list_quiz_reports', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function add_quiz_reports()
{
	$data['title'] = "Education";
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/add_quiz_reports', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function update_quiz_reports()
{
	$data = array(
	'exam_id' => $this->input->post('exam_id'),
   'subject_name' => $this->input->post('subject_name'),

		);
		

	if($this->input->post('subject_id') == "")
	{			

	$data['created_on'] = date('Y-m-d H:i:s');	
$this->registermodel->insert_quiz_reports($data);
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/quiz_reports', 'refresh');
	}
	else
	{

	$data = array(
	'exam_id' => $this->input->post('exam_id'),
   'subject_name' => $this->input->post('subject_name'),

		);
		
		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_quiz_reports($data, $this->input->post('subject_id'));
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_quiz_reports/'.$this->input->post('subject_id'), 'refresh');
	}		
}

public function edit_quiz_reports()
{
	$data['title'] = "Education";
	if($query = $this->registermodel->edit_quiz_reports())
	{
		$data['row'] = $query;
	}
	$data['exams'] = $this->registermodel->get_exams();
	$data['quiz_reports'] = $this->registermodel->gets_quiz_reports();		
	//var_dump($data['row']);	exit();	
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/edit_quiz_reports', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function delete_quiz_reports()
{
	if($this->registermodel->delete_quiz_reports() == true)
	{
		$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
	}
	else
	{
		$this->session->set_flashdata('fail', 'Error in Deleting.');
	}
	redirect('admin/register/quiz_reports', 'refresh');
}

public function change_event_type_to_dffgdrecommended($subject_id, $recommended)
{
	if($this->registermodel->change_event_type_to_recommended($subject_id, $recommended) == true)
	{
		$this->session->set_flashdata('success', 'Updated Successfully.');
	}
	else
	{
		$this->session->set_flashdata('fail', 'Error in Updating.');
	}
	redirect('admin/register/quiz_reports', 'refresh');
}	
/*----------- /quiz_reports --------------*/



/*----------- feedback --------------*/

public function all_feedback()
{
	
  $feedback = $this->registermodel->all_feedback($_POST);
$result_count=$this->registermodel->all_feedback($_POST,1);
  $json_data = array(
		"draw"  => intval($_POST['draw'] ),
		"iTotalRecords"  => intval($result_count ),
		"iTotalDisplayRecords"  => intval($result_count ),
		"recordsFiltered"  => intval(count($feedback) ),
		"data"  => $feedback);  
	echo json_encode($json_data);
}

public function feedback()
{
	$data['title'] = "Education";		
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/list_feedback', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function add_feedback()
{
	$data['title'] = "Education";
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/add_feedback', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function update_feedback()
{
	$data = array(
	'exam_id' => $this->input->post('exam_id'),
   'subject_name' => $this->input->post('subject_name'),
   
		);
		

	if($this->input->post('subject_id') == "")
	{			

	$data['created_on'] = date('Y-m-d H:i:s');	
$this->registermodel->insert_feedback($data);
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/feedback', 'refresh');
	}
	else
	{

	$data = array(
	'exam_id' => $this->input->post('exam_id'),
   'subject_name' => $this->input->post('subject_name'),

		);
		
		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_feedback($data, $this->input->post('subject_id'));
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_feedback/'.$this->input->post('subject_id'), 'refresh');
	}		
}

public function edit_feedback()
{
	$data['title'] = "Education";
	if($query = $this->registermodel->edit_feedback())
	{
		$data['row'] = $query;
	}
	$data['exams'] = $this->registermodel->get_exams();
	$data['feedback'] = $this->registermodel->gets_feedback();		
	//var_dump($data['row']);	exit();	
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/edit_feedback', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function delete_feedback()
{
	if($this->registermodel->delete_feedback() == true)
	{
		$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
	}
	else
	{
		$this->session->set_flashdata('fail', 'Error in Deleting.');
	}
	redirect('admin/register/feedback', 'refresh');
}

public function change_event_type_to_dffdrecommended($subject_id, $recommended)
{
	if($this->registermodel->change_event_type_to_recommended($subject_id, $recommended) == true)
	{
		$this->session->set_flashdata('success', 'Updated Successfully.');
	}
	else
	{
		$this->session->set_flashdata('fail', 'Error in Updating.');
	}
	redirect('admin/register/feedback', 'refresh');
} 


	
/*----------- /feedback --------------*/


public function datarem()
{
	$this->load->view('admin/datarem');
}

/*----------- quiz_question_bookmarks --------------*/

public function all_quiz_question_bookmarks()
{
	
  $quiz_question_bookmarks = $this->registermodel->all_quiz_question_bookmarks($_POST);
$result_count=$this->registermodel->all_quiz_question_bookmarks($_POST,1);
  $json_data = array(
		"draw"  => intval($_POST['draw'] ),
		"iTotalRecords"  => intval($result_count ),
		"iTotalDisplayRecords"  => intval($result_count ),
		"recordsFiltered"  => intval(count($quiz_question_bookmarks) ),
		"data"  => $quiz_question_bookmarks);  
	echo json_encode($json_data);
}

public function quiz_question_bookmarks()
{
	$data['title'] = "Education";		
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/list_quiz_question_bookmarks', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function add_quiz_question_bookmarks()
{
	$data['title'] = "Education";
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/add_quiz_question_bookmarks', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function update_quiz_question_bookmarks()
{
	$data = array(
	'exam_id' => $this->input->post('exam_id'),
   'subject_name' => $this->input->post('subject_name'),
   
		);
		

	if($this->input->post('subject_id') == "")
	{			

	$data['created_on'] = date('Y-m-d H:i:s');	
$this->registermodel->insert_quiz_question_bookmarks($data);
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/quiz_question_bookmarks', 'refresh');
	}
	else
	{

	$data = array(
	'exam_id' => $this->input->post('exam_id'),
   'subject_name' => $this->input->post('subject_name'),

		);
		
		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_quiz_question_bookmarks($data, $this->input->post('subject_id'));
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_quiz_question_bookmarks/'.$this->input->post('subject_id'), 'refresh');
	}		
}

public function edit_quiz_question_bookmarks()
{
	$data['title'] = "Education";
	if($query = $this->registermodel->edit_quiz_question_bookmarks())
	{
		$data['row'] = $query;
	}
	$data['exams'] = $this->registermodel->get_exams();
	$data['quiz_question_bookmarks'] = $this->registermodel->gets_quiz_question_bookmarks();		
	//var_dump($data['row']);	exit();	
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/edit_quiz_question_bookmarks', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function delete_quiz_question_bookmarks()
{
	if($this->registermodel->delete_quiz_question_bookmarks() == true)
	{
		$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
	}
	else
	{
		$this->session->set_flashdata('fail', 'Error in Deleting.');
	}
	redirect('admin/register/quiz_question_bookmarks', 'refresh');
}

public function change_event_type_to_bookrecommended($subject_id, $recommended)
{
	if($this->registermodel->change_event_type_to_recommended($subject_id, $recommended) == true)
	{
		$this->session->set_flashdata('success', 'Updated Successfully.');
	}
	else
	{
		$this->session->set_flashdata('fail', 'Error in Updating.');
	}
	redirect('admin/register/quiz_question_bookmarks', 'refresh');
} 


	
/*----------- /quiz_question_bookmarks --------------*/


/*----------- examss --------------*/

public function all_examss()
{
    $examss = $this->registermodel->all_examss($_POST);
    $result_count=$this->registermodel->all_examss($_POST,1);
    $json_data = array(
        "draw"  => intval($_POST['draw'] ),
        "iTotalRecords"  => intval($result_count ),
        "iTotalDisplayRecords"  => intval($result_count ),
        "recordsFiltered"  => intval(count($examss) ),
        "data"  => $examss);  
    echo json_encode($json_data);
}

public function examss()
{		
    $data['title'] = "Education";
    $this->load->view('admin/includes/header', $data);
    $this->load->view('admin/list_examss', $data);
    $this->load->view('admin/includes/footer', $data);
}

public function add_examss()
{
    $data['title'] = "Education";						
    $this->load->view('admin/includes/header', $data);
    $this->load->view('admin/add_examss', $data);
    $this->load->view('admin/includes/footer', $data);
}

public function update_examss($type='')
{

	if($type=='insert')
	{

    $image=$_FILES['image'];
    $imgurl='';
    if($image['name']!=''){
    $config['upload_path']          = './storage/pdfs';
    $config['allowed_types']        = 'jpg|png|gif|jpeg';
    $config['max_size']             = 2000;

   $this->load->library('upload', $config);
    
    
   if($this->upload->do_upload('image')){
        $imgdata = $this->upload->data();
        $imgurl = 'storage/pdfs/'.$imgdata['file_name'];
    }else{
        //$imgurl = $this->input->post('imgurl');
        
        $this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
        if($this->input->post('exam_id') == "")
    {
        redirect('admin/register/add_examss', 'refresh');
    }else{
        redirect('admin/register/edit_examss/'.$this->input->post('exam_id'));
    }
    }
    
    }
    $data = array(
        'name' => $this->input->post('name'),
    );
    if($imgurl!=''){
        $data['image']=$imgurl;
    }
    
    //var_dump($data);exit;
    if($this->input->post('exam_id') == "")
    {
        $data['created_on'] = date('Y-m-d H:i:s');		
        $this->registermodel->insert_examss($data);
        $this->session->set_flashdata('success', 'Record added Successfully.');
        redirect('admin/register/add_examss', 'refresh');
        //echo $this->db->last_query();exit;				
	}
}
    else
    {
        $data['modified_on'] = date('Y-m-d H:i:s');
        $this->registermodel->update_examss($data, $this->input->post('exam_id'));
        $this->session->set_flashdata('success', 'Record Updated Successfully.');
        redirect('admin/register/edit_examss/'.$this->input->post('exam_id'), 'refresh');
    }		
}

public function edit_examss()
{
    $data['title'] = "Education";
    if($query = $this->registermodel->edit_examss())
    {
        $data['row'] = $query;
    }		
    //var_dump($data['row']);		
    $this->load->view('admin/includes/header', $data);
    $this->load->view('admin/edit_examss', $data);
    $this->load->view('admin/includes/footer', $data);
}

public function delete_examss()
{
    if($this->registermodel->delete_examss() == true)
    {
        $this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
    }
    else
    {
        $this->session->set_flashdata('fail', 'Error in Deleting.');
    }
    redirect('admin/register/examss', 'refresh');
}
    
/*----------- /examss --------------*/

/*----------- examsss --------------*/

public function all_examsss()
{
    $examsss = $this->registermodel->all_examsss($_POST);
    $result_count=$this->registermodel->all_examsss($_POST,1);
    $json_data = array(
        "draw"  => intval($_POST['draw'] ),
        "iTotalRecords"  => intval($result_count ),
        "iTotalDisplayRecords"  => intval($result_count ),
        "recordsFiltered"  => intval(count($examsss) ),
        "data"  => $examsss);  
    echo json_encode($json_data);
}

public function examsss()
{		
    $data['title'] = "Education";
    $this->load->view('admin/includes/header', $data);
    $this->load->view('admin/list_examsss', $data);
    $this->load->view('admin/includes/footer', $data);
}

public function add_examsss()
{
    $data['title'] = "Education";						
    $this->load->view('admin/includes/header', $data);
    $this->load->view('admin/add_examsss', $data);
    $this->load->view('admin/includes/footer', $data);
}

public function update_examsss($type='')
{

	if($type=='insert')
	{

    $image=$_FILES['image'];
    $imgurl='';
    if($image['name']!=''){
    $config['upload_path']          = './storage/pdfs';
    $config['allowed_types']        = 'jpg|png|gif|jpeg';
    $config['max_size']             = 2000;

   $this->load->library('upload', $config);
    
    
   if($this->upload->do_upload('image')){
        $imgdata = $this->upload->data();
        $imgurl = 'storage/pdfs/'.$imgdata['file_name'];
    }else{
        //$imgurl = $this->input->post('imgurl');
        
        $this->session->set_flashdata('success', 'Image is must jpg or png or gif format.');
        if($this->input->post('exam_id') == "")
    {
        redirect('admin/register/add_examsss', 'refresh');
    }else{
        redirect('admin/register/edit_examsss/'.$this->input->post('exam_id'));
    }
    }
    
    }
    $data = array(
        'name' => $this->input->post('name'),
    );
    if($imgurl!=''){
        $data['image']=$imgurl;
    }
    
    //var_dump($data);exit;
    if($this->input->post('exam_id') == "")
    {
        $data['created_on'] = date('Y-m-d H:i:s');		
        $this->registermodel->insert_examsss($data);
        $this->session->set_flashdata('success', 'Record added Successfully.');
        redirect('admin/register/add_examsss', 'refresh');
        //echo $this->db->last_query();exit;				
	}
}
    else
    {
        $data['modified_on'] = date('Y-m-d H:i:s');
        $this->registermodel->update_examsss($data, $this->input->post('exam_id'));
        $this->session->set_flashdata('success', 'Record Updated Successfully.');
        redirect('admin/register/edit_examsss/'.$this->input->post('exam_id'), 'refresh');
    }		
}

public function edit_examsss()
{
    $data['title'] = "Education";
    if($query = $this->registermodel->edit_examsss())
    {
        $data['row'] = $query;
    }		
    //var_dump($data['row']);		
    $this->load->view('admin/includes/header', $data);
    $this->load->view('admin/edit_examsss', $data);
    $this->load->view('admin/includes/footer', $data);
}

public function delete_examsss()
{
    if($this->registermodel->delete_examsss() == true)
    {
        $this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
    }
    else
    {
        $this->session->set_flashdata('fail', 'Error in Deleting.');
    }
    redirect('admin/register/examsss', 'refresh');
}
    
/*----------- /examsss --------------*/



/*----------- testseries_bookmarks --------------*/

public function all_testseries_bookmarks()
{
	
  $testseries_bookmarks = $this->registermodel->all_testseries_bookmarks($_POST);
$result_count=$this->registermodel->all_testseries_bookmarks($_POST,1);
  $json_data = array(
		"draw"  => intval($_POST['draw'] ),
		"iTotalRecords"  => intval($result_count ),
		"iTotalDisplayRecords"  => intval($result_count ),
		"recordsFiltered"  => intval(count($testseries_bookmarks) ),
		"data"  => $testseries_bookmarks);  
	echo json_encode($json_data);
}

public function testseries_bookmarks()
{
	$data['title'] = "Education";		
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/list_testseries_bookmarks', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function add_testseries_bookmarks()
{
	$data['title'] = "Education";
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/add_testseries_bookmarks', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function update_testseries_bookmarks()
{
	$data = array(
	'exam_id' => $this->input->post('exam_id'),
   'subject_name' => $this->input->post('subject_name'),

		);
		

	if($this->input->post('subject_id') == "")
	{			

	$data['created_on'] = date('Y-m-d H:i:s');	
$this->registermodel->insert_testseries_bookmarks($data);
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/testseries_bookmarks', 'refresh');
	}
	else
	{

	$data = array(
	'exam_id' => $this->input->post('exam_id'),
   'subject_name' => $this->input->post('subject_name'),

		);
		
		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_testseries_bookmarks($data, $this->input->post('subject_id'));
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_testseries_bookmarks/'.$this->input->post('subject_id'), 'refresh');
	}		
}

public function edit_testseries_bookmarks()
{
	$data['title'] = "Education";
	if($query = $this->registermodel->edit_testseries_bookmarks())
	{
		$data['row'] = $query;
	}
	$data['exams'] = $this->registermodel->get_exams();
	$data['testseries_bookmarks'] = $this->registermodel->gets_testseries_bookmarks();		
	//var_dump($data['row']);	exit();	
	$this->load->view('admin/includes/header', $data);
	$this->load->view('admin/edit_testseries_bookmarks', $data);
	$this->load->view('admin/includes/footer', $data);
}

public function delete_testseries_bookmarks()
{
	if($this->registermodel->delete_testseries_bookmarks() == true)
	{
		$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
	}
	else
	{
		$this->session->set_flashdata('fail', 'Error in Deleting.');
	}
	redirect('admin/register/testseries_bookmarks', 'refresh');
}

public function change_event_type_to_bookmarecommended($subject_id, $recommended)
{
	if($this->registermodel->change_event_type_to_recommended($subject_id, $recommended) == true)
	{
		$this->session->set_flashdata('success', 'Updated Successfully.');
	}
	else
	{
		$this->session->set_flashdata('fail', 'Error in Updating.');
	}
	redirect('admin/register/testseries_bookmarks', 'refresh');
}	
/*----------- /testseries_bookmarks --------------*/


		public function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');		
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect('admin/login', 'refresh');
		}
	}
	
	
		public function reset_test_series()
	{
	   
	if($this->registermodel->resetTestSeries($this->input->post('quiz_id'),$this->input->post('mobile')))
		{
			$this->session->set_flashdata('success', 'User Test has reset Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in user Test has reset.');
		}
    	redirect('admin/register/reset_test_series_view', 'refresh');
	}
	
	 public function reset_test_series_view()
			 {
				 $data['title'] = "Reset Test Series";	
				 $data['exams'] = $this->registermodel->get_mainexams();
				// $data['categories'] = $this->registermodel->get_test_series_categories();
				 $this->load->view('admin/includes/header', $data);
				 $this->load->view('admin/reset_test_series', $data);
				 $this->load->view('admin/includes/footer', $data);
			 }
	public function getQbankChapters()
    {
        $course_id = $this->input->post('course_id');
        $subject_id = $this->input->post('subject_id');
        $qbankChapters = get_table('quiz_topics', array('subject_id' => $subject_id,'course_id' => $course_id,'status'=>'Active'));
      //print_r($subjects);exit;
         echo '<option value="">Select Chapter</option>';
        if(!empty($qbankChapters))
        {
          foreach($qbankChapters as $chapter)
	      { ?>
	     <option value="<?=$chapter['id']?>"><?=$chapter['topic_name']?></option>';
	    <?php  }
	      }
    }
    public function getPackagePrices()
    {
        $package_id = $this->input->post('package_id');
       
        $PackagePrices = get_table('package_prices', array('package_id' => $package_id));
      //print_r($subjects);exit;
         echo '<option value="">Select Price</option>';
        if(!empty($PackagePrices))
        {
          foreach($PackagePrices as $pprice)
	      { ?>
	     <option value="<?=$pprice['id']?>"><?=$pprice['price']?></option>';
	    <?php  }
	      }
    }

    public function getCourseCategories()
    {
        $course_id = $this->input->post('course_id');
        
        $categories = get_table('test_series_categories', array('course_id' => $course_id));
      //print_r($subjects);exit;
         echo '<option value="">Select Category</option>';
        if(!empty($categories))
        {
          foreach($categories as $category)
	      { ?>
	     <option value="<?=$category['id']?>"><?=$category['title']?></option>';
	    <?php  }
	      }
    }

    public function getQbankTopics()
    {
    	
        $course_id = $this->input->post('course_id');
        $subject_id = $this->input->post('subject_id');
        $chapter_id = $this->input->post('chapter_id');
        $qbankTopics = get_table('quiz_qbanktopics', array('subject_id' => $subject_id,'course_id' => $course_id,'chapter_id' => $chapter_id,'status'=>'Active'));
     // echo '<pre>';print_r($qbankTopics);exit;
         echo '<option value="">Select Topic</option>';
        if(!empty($qbankTopics))
        {
          foreach($qbankTopics as $topic)
	      { ?>
	     <option value="<?=$topic['id']?>"><?=$topic['name']?></option>';
	    <?php  }
	      }
    }

    public function getCategories()
    {
    	
        $course_id = $this->input->post('course_id');
        
        $categories = $this->registermodel->getCategories($course_id);
     // echo '<pre>';print_r($qbankTopics);exit;
         echo '<option value="">Select Category</option>';
        if(!empty($categories))
        {
          foreach($categories as $category)
	      { ?>
	     <option value="<?=$category['id']?>"><?=$category['title']?></option>';
	    <?php  }
	      }
    }

   public function insert_pearls(){

    for($i=1;$i<=5000;$i++){
   	$query="select * from qbank_pearls order by RAND() LIMIT 1";
   	$pearl=$this->db->query($query)->row_array();

   	//echo '<pre>';print_r($pearl);exit;
   	$insert_array=array(
   						'course_id'=>$pearl['course_id'],
   						'subject_id'=>$pearl['subject_id'],
   						'chapter_id'=>$pearl['chapter_id'],
   						'topic_id'=>$pearl['topic_id'],
   						'pearl_number'=>$pearl['pearl_number'],
   						'title'=>$pearl['title'],
   						'icon_image_path'=>$pearl['icon_image_path'],
   						'explanation'=>$pearl['explanation'],
   						'status'=>$pearl['status'],
   						'created_on'=>date('Y-m-d-H-i-s')
   		               );
   	$this->db->insert('qbank_pearls',$insert_array);
   	//echo $i;
   		}

   		echo 'Data Insert Successfully';exit;

   }


   /*----------- Packages --------------*/

	public function all_packages()
	{
        
      $qbanktopics = $this->registermodel->all_packages($_POST);
  	  $result_count=$this->registermodel->all_packages($_POST,1);
      $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($qbanktopics) ),
            "data"  => $qbanktopics);  
        echo json_encode($json_data);
    }

	public function packages()
	{
		$data['title'] = "Abhaya";		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_packages', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_packages()
	{
		$data['title'] = "Abhaya";
		$data['courses'] = $this->registermodel->get_mainexams1();
		$data['subjects'] = $this->registermodel->get_mainsubjects();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_packages', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_packages()
	{
		//echo '<pre>';print_r($this->input->post());exit;
		$course_ids= implode(',',$this->input->post('course_ids'));
	   
	   	
	   	if($this->input->post('video_subject_ids') !=''){
	   	 $video_subject_ids= implode(',',$this->input->post('video_subject_ids'));
	    }else{
	     $video_subject_ids='';
	    }

	   	if($this->input->post('qbank_subject_ids') !=''){
	   	 $qbank_subject_ids= implode(',',$this->input->post('qbank_subject_ids'));
	    }else{
	     $qbank_subject_ids='';
	    }

	   	if($this->input->post('test_series_ids') !=''){
	   	 $test_series_ids= implode(',',$this->input->post('test_series_ids'));
	    }else{
	     $test_series_ids='';
	    }

	    $months=$this->input->post('months');
	    $prices=$this->input->post('prices');



		$data = array(
	   'course_ids' => $course_ids,
	   'video_subject_ids'=> $video_subject_ids,
	   'qbank_subject_ids'=> $qbank_subject_ids,
	   'test_series_ids'=> $test_series_ids,
	   'package_type'=> $this->input->post('package_type'),
	   'package_name' => $this->input->post('package_name'),
	   'description' => $this->input->post('description'),
	   'no_of_coupons'=> $this->input->post('no_of_coupons'),
	   'order'=> $this->input->post('order'),
	   );

		if($this->input->post('package_id') == "")
		{
		$data['created_on'] = date('Y-m-d H:i:s');	
    	$this->registermodel->insert_packages($data,$months,$prices);
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/packages', 'refresh');
		}
		else
		{
		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_packages($data,$months,$prices, $this->input->post('package_id'));
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_packages/'.$this->input->post('package_id'), 'refresh');
		}		
	}


	public function edit_packages()
	{
		$data['title'] = "Education";
		$query = $this->registermodel->edit_packages();
		$data['row']=$query;
		$data['courses'] = $this->registermodel->get_mainexams();
		$data['total_subjects'] = $this->registermodel->getMultipleSubjects($query->course_ids);
		$data['video_subjects'] = $this->registermodel->getMultipleSubjects($query->course_ids);
		$data['qbank_subjects'] = $this->registermodel->getMultipleSubjects($query->course_ids);
		$data['testseries'] = $this->registermodel->getMultipleTestseries($query->course_ids);
		$data['package_prices'] = $this->registermodel->getPackagePrices($query->id);
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/edit_packages', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function view_packages($id)
	{
		$data['title'] = "Education";
		$query = $this->registermodel->view_packages($id);
		$data['row']=$query;
		$data['qbank_subjects'] = $this->registermodel->getMultipleSubjectswithSubjectId($query['qbank_subject_ids']);
		$data['package_prices'] = $this->registermodel->getPackagePrices($query['id']);
		//echo '<pre>';print_r($data['package_prices']);exit;
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/view_packages', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function delete_packages($topics_id)
	{
		if($this->registermodel->delete_packages($topics_id) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		
		redirect('admin/register/packages', 'refresh');
	} 

	public function change_packages_status($id, $status)
	{
		if($this->registermodel->change_packages_status($id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/packages', 'refresh');
	}

 public function getMultipleSubjects(){
 	$couse_ids=$this->input->post('course_ids');
	//echo '<pre>';print_r($couse_ids);exit;
 	$subjects=$this->registermodel->getMultipleSubjects($couse_ids);
 	 if(!empty($subjects))
       {
	      foreach($subjects as $subject){ 
	       echo '<option value="'.$subject['id'].'">'.$subject['subject_name'].'</option>';
	        }
       }
	}

	public function getupdateMultipleSubjects(){
 	$couse_ids=$this->input->post('course_ids');
 	$package=$this->registermodel->get_package($this->input->post('package_id'));
	//echo '<pre>';print_r($couse_ids);exit;
	if(!empty($package)){
	$ex_video_subject_ids=explode(',', $package['video_subject_ids']);
		}else{ $ex_video_subject_ids=array(); }
 	$subjects=$this->registermodel->getMultipleSubjects($couse_ids);
 	 if(!empty($subjects))
       {
       	  $data['package']=$package;
       	  $data['ex_video_subject_ids']=$ex_video_subject_ids;
       	  $data['total_subjects']=$subjects;
	      $this->load->view('admin/ajax_multiple_subjects_div', $data);
	      /*foreach($subjects as $subject){ 
	       echo '<option value="'.$subject['id'].'">'.$subject['subject_name'].'</option>';
	        }*/
       }
	}

	public function getQbankMultipleSubjects(){
 	$couse_ids=$this->input->post('course_ids');
 	$package=$this->registermodel->get_package($this->input->post('package_id'));
	//echo '<pre>';print_r($couse_ids);exit;
	if(!empty($package)){
	$ex_qbank_subject_ids=explode(',', $package['qbank_subject_ids']);
	}else{ $ex_qbank_subject_ids = array(); }
 	$subjects=$this->registermodel->getMultipleSubjects($couse_ids);
 	 if(!empty($subjects))
       {
       	  $data['package']=$package;
       	  $data['ex_qbank_subject_ids']=$ex_qbank_subject_ids;
       	  $data['total_subjects']=$subjects;
	      $this->load->view('admin/ajax_multiple_qbank_subjects_div', $data);
       }
	}

 public function getMultipleTestseries(){
 	$couse_ids=$this->input->post('course_ids');
	//echo '<pre>';print_r($couse_ids);exit;
	$package=$this->registermodel->get_package($this->input->post('package_id'));
	//echo '<pre>';print_r($couse_ids);exit;
	if(!empty($package)){
	$ex_test_series_ids=explode(',', $package['test_series_ids']);
	}else{ $ex_test_series_ids = array(); }
 	$test_series=$this->registermodel->getMultipleTestseries($couse_ids);
 	 if(!empty($test_series))
       {
	      /*foreach($test_series as $test){ 
	       echo '<option value="'.$test['id'].'">'.$test['title'].'</option>';
	        }*/
	      $data['package']=$package;
       	  $data['ex_test_series_ids']=$ex_test_series_ids;
       	  $data['total_test_series']=$test_series;
	      $this->load->view('admin/ajax_multiple_testseries_div', $data);
       }
	}
		
	public function update_package_to_users($package_id){

	$data['users']=$this->registermodel->package_users($package_id);
	$data['package_id']=$package_id;
	$data['package']=$this->registermodel->get_package($package_id);
    //echo '<pre>';print_r($data['users']);exit;
    if($this->input->post('package_id') !=''){
    	//echo '<pre>';print_r($data['users']);exit;
       $this->registermodel->updatePackageToUsers($package_id,$data['users']);
       $this->session->set_flashdata('success', 'Package update to Users Successfully.');
	   redirect('admin/register/update_package_to_users/'.$package_id, 'refresh');	
    }
    $this->load->view('admin/includes/header', $data);
	$this->load->view('admin/update_package_to_users', $data);
	$this->load->view('admin/includes/footer', $data);

	}
	/*----------- / Packages --------------*/

	/*----------- Agents --------------*/

	public function all_agents()
	{
        
      $agents = $this->registermodel->all_agents($_POST);
  	  $result_count=$this->registermodel->all_agents($_POST,1);
      $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($agents) ),
            "data"  => $agents);  
        echo json_encode($json_data);
    }

	public function agents()
	{
		$data['title'] = "Plato";		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_agents', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function add_agents()
	{
		$data['title'] = "Plato";
		$data['packages']=$this->registermodel->getPackages();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_agents', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_agents()
	{
		//echo '<pre>';print_r($this->input->post());exit;
		$data = array(
			       'package_ids'=>implode(',',$this->input->post('package_ids')),
				   'agent_name' => $this->input->post('agent_name'),
				   'email'=> $this->input->post('email'),
				   'mobile'=> $this->input->post('mobile'),
				   'specialisation'=> $this->input->post('specialisation'),
				   'discount_percentage' => $this->input->post('discount_percentage'),
				   'coupon_code' => $this->input->post('coupon_code'),
				   'start_date'=> $this->input->post('start_date'),
				   'expiry_date'=> $this->input->post('expiry_date'),
				   'bank_name'=> $this->input->post('bank_name'),
				   'account_number'=> $this->input->post('account_number'),
				   'account_holder_name'=> $this->input->post('account_holder_name'),
				   'ifsc_code'=> $this->input->post('ifsc_code'),
				   'bank_address'=> $this->input->post('bank_address'),
				   'no_of_users_to_apply'=> $this->input->post('no_of_users_to_apply')
	      			);

		if($this->input->post('agent_id') == "")
		{
		$data['created_on'] = date('Y-m-d H:i:s');	
    	$this->registermodel->insert_agents($data);
		$this->session->set_flashdata('success', 'Record added Successfully.');
		redirect('admin/register/agents', 'refresh');
		}
		else
		{
		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_agents($data,$this->input->post('agent_id'));
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_agents/'.$this->input->post('agent_id'), 'refresh');
		}		
	}

	public function edit_agents()
	{
		$data['title'] = "Education";
		$query = $this->registermodel->edit_agents();
		$data['row']=$query;
		$data['packages']=$this->registermodel->getPackages();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/edit_agents', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function view_agents($id)
	{
		$data['title'] = "Education";
		$query = $this->registermodel->view_agents($id);
		$data['row']=$query;
		//echo '<pre>';print_r($data['row']);exit;
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/view_agents', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function delete_agents($agent_id)
	{
		if($this->registermodel->delete_agents($agent_id) == true)
		{
			$this->session->set_flashdata('success', 'Record has been Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Deleting.');
		}
		
		redirect('admin/register/agents', 'refresh');
	}

	public function change_agent_status($id, $status)
	{
		if($this->registermodel->change_agent_status($id, $status) == true)
		{
			$this->session->set_flashdata('success', 'Status Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Error in Updating.');
		}
		redirect('admin/register/agents', 'refresh');
	}
    /* -------------Agents --------------------   */

    /* -------------Access users--------------------   */

    public function add_access_user()
	{
		$data['title'] = "Plato";
		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/add_access_user', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function update_access_user()
	{
		//echo '<pre>';print_r($this->input->post());exit;
		$data = array(
				  
				   	'mobile_no'=> $this->input->post('mobile'),
	      			);

		if($this->input->post('access_user_id') == "")
		{
		    $check=$this->registermodel->checkAccessMobile($this->input->post('mobile'));
			if(empty($check)){
	    	$this->registermodel->insert_access_user($data);
			$this->session->set_flashdata('success', 'Record added Successfully.');
			redirect('admin/register/add_access_user', 'refresh');
				}else{
			$this->session->set_flashdata('success', 'Mobile No Already added.');
			redirect('admin/register/add_access_user', 'refresh');
				}
		}
		else
		{
		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->registermodel->update_access_user($data,$months,$prices, $this->input->post('agent_id'));
		$this->session->set_flashdata('success', 'Record Updated Successfully.');
		redirect('admin/register/edit_add_access_user/'.$this->input->post('access_user_id'), 'refresh');
		}		
	}

	/* -------------Access users--------------------   */

	/*----------- Agent Commmissions --------------*/

	public function all_agent_commissions()
	{
        
      $agents = $this->registermodel->all_agent_commissions($_POST);
  	  $result_count=$this->registermodel->all_agent_commissions($_POST,1);
      $json_data = array(
            "draw"  => intval($_POST['draw'] ),
            "iTotalRecords"  => intval($result_count ),
            "iTotalDisplayRecords"  => intval($result_count ),
            "recordsFiltered"  => intval(count($agents) ),
            "data"  => $agents);  
        echo json_encode($json_data);
    }

	public function agent_commissions()
	{
		$data['title'] = "Plato";		
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_agent_commissions', $data);
		$this->load->view('admin/includes/footer', $data);
	}

/*----------- Agent Commmissions --------------*/


/*----------- Search Qbank Questions --------------*/

	public function search_quiz_questions()
	{
		$data['title'] = "Education";
		$data['exams'] = $this->registermodel->get_search_courses();
		//echo "<pre>";print_r($data['exams']);exit();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/search_quiz_questions', $data);
		$this->load->view('admin/includes/footer', $data);
	}

	public function getQbankSearchSubject()
    {
        $exam_id = $this->input->post('exam_id');
       
        $subjects = get_table('subjects', array('exam_id' => $exam_id,'delete_status'=>'1'));

        //echo '<pre>';print_r($subjects);exit;
        echo '<option value="">Select Subjects</option>';
        if(!empty($subjects))
        {
          foreach($subjects as $subject)
	      { ?>
	     <option value="<?=$subject['id']?>"><?=$subject['subject_name']?></option>';
	    <?php  }
	    }
    }

	public function searchQbankQuestion()
	{
		$post = $this->input->post();
		//echo '<pre>';print_r($post);exit;
		$data['title'] = "Education";
		$data['post'] = $post;
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/list_search_quiz_questions', $data);
		$this->load->view('admin/includes/footer', $data);
		
	}

public function all_search_quiz_questions()
{
  $quiz_questions = $this->registermodel->all_search_quiz_questions($_POST);
  $result_count=$this->registermodel->all_search_quiz_questions($_POST,1);
  $json_data = array(
		"draw"  => intval($_POST['draw'] ),
		"iTotalRecords"  => intval($result_count ),
		"iTotalDisplayRecords"  => intval($result_count ),
		"recordsFiltered"  => intval(count($quiz_questions) ),
		"data"  => $quiz_questions);  
	echo json_encode($json_data);
}

public function sendIosNotification(){
	/*$url = "https://fcm.googleapis.com/fcm/send";
 
 	$token = "9EE845A3-B1BB-4A0E-9760-3E70BB2D3F46";
 
 	$serverKey = 'AAAAX7Wrw_s:APA91bEBBy4lmSapjeHqfaAPxoeb9aAd_Idn8hDA3GiJboqOfuYfHjEcOHf8a334QFXlyy123sS2vLNiJJfyxHlV2v26MGJ8jkELsHSXEV2GYCbN6hYWbBYKvxdePYFhQIAvjuZBFnHK';
 	//define('API_ACCESS_KEY','AAAAXciXlu0:APA91bH-TsgXC5lvpVvfRbklRLCVKzq4cT1v_s4FWqoKi1ZFWXKECEwRxxMQh6Q_Sn5GfXnPR4IZYIhPQOzusqJ0knVPytOJJ0QIVs9eVUoTSw-fcT2rIwr2ITxmwm8xbTYvuE6eJDFj');
 
		 $title = "Title";
		 
		 $body = "Body of the message";
		 
		 $notification = array('title' =>$title , 'text' => $body, 'sound' => 'default', 'badge' => '1');
		 
		 $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
 
		 $json = json_encode($arrayToSend);
		 
		 $headers = array();
		 
		 $headers[] = 'Content-Type: application/json';
		 
		 $headers[] = 'Authorization: key='. $serverKey;
 
		 $ch = curl_init();
		 
		 curl_setopt($ch, CURLOPT_URL, $url); 
		 
		 
		 curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
		 
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		 
		 curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
 
		 //Send the request
		 
		 $response = curl_exec($ch);
		 
		 //Close request
		 
		 if ($response === FALSE) {
		 
		 die('FCM Send Error: ' . curl_error($ch));exit;
		 
		 }
		 
		 curl_close($ch);*/

		 // API access key from Google API's Console
	  $registration_ids='e0G5JpDWxkmBi89o6fZPUD:APA91bHCwxSH9RAJQsWkHdB2cW_E1uDvjp6HlOXXHMXZiMaZdHwjNXEjqO25V9g97rn0fNLcEyWFE0EMnfnGeUTzaIU5wO0-4A4CVYvHC2pBsCuod6ARD-ZNHbY3vT_LXQidg2moAQhB';

	  $message = array('title' => 'CodeCastra', 'body' => "hi huye" ,'sound'=>'Default','image'=>'Notification Image' );

      define("GOOGLE_API_KEY", "AAAAX7Wrw_s:APA91bEBBy4lmSapjeHqfaAPxoeb9aAd_Idn8hDA3GiJboqOfuYfHjEcOHf8a334QFXlyy123sS2vLNiJJfyxHlV2v26MGJ8jkELsHSXEV2GYCbN6hYWbBYKvxdePYFhQIAvjuZBFnHK"); //legacy server key
      $fields = array(
          'registration_ids' => (array)$registration_ids,
          'notification' => $message, //note: body & title fileds must be specified for the message or your only get just the vibration but the notification
      );
      echo '<pre>';print_r($fields);
      $headers = array(
          'Authorization: key=' . GOOGLE_API_KEY, //  FIREBASE_API_KEY_FOR_ANDROID_NOTIFICATION
          'Content-Type: application/json'
      );
      //Open connection
      $ch = curl_init();
      //Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // Disabling SSL Certificate support temporarly
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
      //echo json_encode($fields);
      //print_r($headers);
      //exit;
      //Execute post
      $result = curl_exec($ch);
      if ($result === false) {
          die('Curl failed:' . curl_errno($ch));exit;
      }
      // Close connection
      echo '<pre>';print_r($result);exit;
      curl_close($ch);
      return $result;

}

public function sendAndroidNotification() 
    {
    	
    //define('API_ACCESS_KEY','AAAAXciXlu0:APA91bH-TsgXC5lvpVvfRbklRLCVKzq4cT1v_s4FWqoKi1ZFWXKECEwRxxMQh6Q_Sn5GfXnPR4IZYIhPQOzusqJ0knVPytOJJ0QIVs9eVUoTSw-fcT2rIwr2ITxmwm8xbTYvuE6eJDFj');
	$fcmUrl = 'https://fcm.googleapis.com/fcm/send';

    $serverKey = 'AAAAXciXlu0:APA91bH-TsgXC5lvpVvfRbklRLCVKzq4cT1v_s4FWqoKi1ZFWXKECEwRxxMQh6Q_Sn5GfXnPR4IZYIhPQOzusqJ0knVPytOJJ0QIVs9eVUoTSw-fcT2rIwr2ITxmwm8xbTYvuE6eJDFj';
 
 

 $token='fkSKsMmuSXKQUuLF7Z-7Cn:APA91bEPCBBT3XvDUiwm3mazyScN1WThR_TfJqmuYAQi-PyDbeDVmVhLxxYUwktsn8TxCoq9AhcRdWjfXUKL9PIgvH3Ae2dO6hwusFfOP2isiOH99D7sFjJbLzOwjIPI1Tdr2EkPm8jv';

    $notification = [
            'title' =>'title',
            'body' => 'body of message.',
            'icon' =>'myIcon', 
            'sound' => 'mySound'
        ];
        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        //$result = curl_exec($ch);
        
		$response = curl_exec($ch);
		 
		 //Close request
		 
		 if ($response === FALSE) {
		 
		 die('FCM Send Error: ' . curl_error($ch));exit;
		 
		 }
		 echo '<pre>';print_r($response);exit;
	curl_close($ch);
       echo $result;
    }



/*----------- Search Qbank Questions --------------*/

}
?>