<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");		
		$this->is_logged_in();
		$this->load->model('admin/main_model','my_model');
		$this->load->model('common_model');
		$this->load->helper('url','form','HTML');
		$this->load->helper('common_helper');
        $this->load->library(array('form_validation', 'session'));
	}

		public function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');		
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect('admin/login', 'refresh');
		}
	}
	/*----------- Download Online Payment  Excel --------------*/
	/*public function export_online_payments(){

		$fileName = 'data-'.time().'.xlsx';  
        // load excel library

        $this->load->library('excel');
        $listInfo = $this->my_model->online_paymemts_info();
        echo '<pre>';print_r($listInfo);exit;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'receipt ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'user Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'user name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'user email');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'user mobile');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'package id');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'package name');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'price id');       
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'valid months');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'valid from');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'valid to');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'price');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'coupon applied');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'final paid amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'coupon type');


        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'coupon id');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'coupon name');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'coupon discount');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'razorpay order_id');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'razorpay payment_id');
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'razorpay signature');

        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'payment status');
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'payment msg');
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'payment from');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'created on');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'payment created on');
        
       

        // set Row
        $rowCount = 2;
        foreach ($listInfo as $list) {
        	
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list['receipt_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list['user_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['user_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['user_email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list['user_mobile']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['package_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['package_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $list['price_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $list['valid_months']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $list['valid_from']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $list['valid_to']);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $list['price']);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $list['coupon_applied']);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $list['final_paid_amount']);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $list['coupon_type']);

            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $list['coupon_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $list['coupon_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $list['coupon_discount']);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $list['razorpay_order_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $list['razorpay_payment_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $list['razorpay_signature']);

            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $list['payment_status']);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $list['payment_msg']);
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $list['payment_from']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $list['created_on']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $list['payment_created_on']);
            $rowCount++;
        }
        $filename = "online-payments-info". date("Y-m-d-H-i-s").".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output');
	}
*/
	public function export_online_payments(){		//*****  Status change *****//
		
		$query = $this->my_model->online_paymemts_info();
		$this->load->helper('csv');
		query_to_csv($query, TRUE, "online-payments-info".'-'.date("m-d-Y H:i:s").'.csv');	
	}

    public function offline_paymemts_info(){       //*****  Status change *****//
        $query = $this->my_model->offline_paymemts_info();
        $this->load->helper('csv');
        query_to_csv($query, TRUE, "offline-payments-info".'-'.date("m-d-Y H:i:s").'.csv');  
    }

     public function download_unregiter_users(){       //*****  Status change *****//
        $query = $this->my_model->download_unregiter_users();
        $this->load->helper('csv');
        query_to_csv($query, TRUE, "un-registers-info".'-'.date("m-d-Y H:i:s").'.csv');  
    }

}

?>