<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_password_model extends CI_Model {

    public $users_table = 'tbl_users';

// Function to Change Admin Password
    public function change_password_2()
    {
        
        $normal_password =  $this->input->post('conf_pwd');
        $encode_password = md5($normal_password);
        
        $data = array(
                    //  'password'=>$this->input->post('conf_pwd')
                        'password'=>$encode_password,
                        'modified_by'=>$this->session->userdata('user_id'),
                        'modified_on'=>date('Y-m-d H:i:s')
                    );
        $this->db->where('user_id',$this->session->userdata('user_id'));
        $result = $this->db->update($this->users_table, $data);
        return $result;
    }

// Function to Check Current Password Current or Not
    public function password_check()
    {
        
        $normal_password =  $this->input->post('cur_pwd');
        $encode_password = md5($normal_password);
        
        
        $this->db->select('*');
        $this->db->from($this->users_table);
        $this->db->where('password',$encode_password);
        $this->db->where('user_id',$this->session->userdata('user_id'));     
        $result=$this->db->get();
        return $result->num_rows(); 
    }



}?>