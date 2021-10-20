 <?php
class Welcome_model extends CI_Model
{


 public function get_all_courses(){

        $this->db->select('*');
        $this->db->from('exams');
        $this->db->where('delete_status','1');
        $this->db->order_by('order','asc');
         $query = $this->db->get();  
       //echo $this->db->last_query();    
        return $query->result_array();
    }

}