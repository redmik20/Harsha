<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
			
	function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('admin/loginmodel');
		date_default_timezone_set("Asia/Kolkata");
	}
	
	public function index()
	{
		$data['title'] = "Education";
		//$data['users_count'] = $this->loginmodel->users_count();
		//$data['users_login_count'] = $this->loginmodel->usersLoginCount();
		//$data['unregister_users_count'] = $this->loginmodel->unregister_users_count();
		$data['exams_count'] = $this->loginmodel->exams_count();
		$data['subjects_count'] = $this->loginmodel->subjects_count();
		$data['chapters_count'] = $this->loginmodel->chapters_count();
		$data['chapters_slides'] = $this->loginmodel->chapters_slides_count();
		$data['faculty_count'] = $this->loginmodel->faculty_count();
		$data['plandetails_count'] = $this->loginmodel->plandetails_count();
		$data['coupons_count'] = $this->loginmodel->coupons_count();
		$data['chaptertopics'] = $this->loginmodel->chapter_topics();
		$data['reports_count'] = $this->loginmodel->reports_count();
		$data['feedback_count'] = $this->loginmodel->feedback_count();
		$data['payments_count'] = $this->loginmodel->payments_count();
		$data['users_paid_amount'] = $this->loginmodel->total_payment_amount();
		$this->load->view('admin/includes/header', $data);
		$this->load->view('admin/homeview', $data);
		$this->load->view('admin/includes/footer', $data);
	}	
	
	public function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');		
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect('admin/login', 'refresh');
		}
	}
	
	function is_logged_out()
    {
        $this->session->unset_userdata('is_logged_in');
        redirect('admin/login', 'refresh');
    }

    function update_options_in_questions(){

    $questions = $this->db->query("SELECT `id` as question_id
					FROM `quiz_questions`");//->result_array();


    if ($questions->num_rows() > 0)
    {
    $res = $questions->result_array();
    foreach ($res as $key => $row){
        
            $option_data=$this->db->query("SELECT * from quiz_options where question_id=".$row['question_id']." order by id")->result_array();

            $option_data = json_encode($option_data);           
            $this->db->where(array('id'=>$row['question_id']))->update('quiz_questions', array('options_data'=>$option_data));
        }
        
        //echo json_encode($res);
        
    }

    echo count($res) .'options updated successfully...';

    }

    function update_options_in_testseries(){

    $questions = $this->db->query("SELECT `id` as question_id
					FROM `test_series_questions`");//->result_array();


    if ($questions->num_rows() > 0)
    {
    $res = $questions->result_array();
    foreach ($res as $key => $row){
        
            $option_data=$this->db->query("SELECT * from test_series_options where question_id=".$row['question_id']." order by id")->result_array();

            $option_data = json_encode($option_data);           
            $this->db->where(array('id'=>$row['question_id']))->update('test_series_questions', array('options'=>$option_data));
        }
        
        //echo json_encode($res);
        
    }

    echo count($res) .'options updated successfully...';

    }





	
}
?>