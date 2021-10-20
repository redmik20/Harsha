<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Total_batches_model extends CI_Model {


	public function batch_wise_students_count(){

		$query="SELECT *,(select count(id)  from tbl_students where tbl_students.batch_id=tbl_batchs.id ) as students_count FROM tbl_batchs where status='active' ";
 			//echo $query;exit;
		$result=$this->db->query($query)->result_array();

		return $result;
	}

}

?>