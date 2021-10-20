<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Opening_balance_model extends CI_Model {






	public function get_attachments(){

		$query="SELECT tbl_attachments.id,tbl_attachments.attachment_name,tbl_attachments.opening_balance,(select sum(amount_paid) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.attachment_id=tbl_attachments.id and tbl_student_payment_details.approval_status='Approved') as income_amount,(select sum(amount) FROM `tbl_expenses` WHERE tbl_expenses.attachment_id=tbl_attachments.id and tbl_expenses.approval_status='Approved') as expense_amount FROM tbl_attachments WHERE tbl_attachments.status='Active' ";
		//echo $query;exit;
		$result=$this->db->query($query)->result_array();
        return $result;
	}

}

?>