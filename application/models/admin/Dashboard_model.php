<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Dashboard_model extends CI_Model {

	public function get_students_count(){

	    $this->db->select('id');
        $this->db->from('students');
        $query=$this->db->get();
        $result=$query->num_rows();
        return $result;
    }

    public function get_batchs_count(){

	    $this->db->select('id');
        $this->db->from('batchs');
        $query=$this->db->get();
        $result=$query->num_rows();
        return $result;
    }

}?>