<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Custom_model extends CI_Model
{


public function getCustomQuestions($user_id,$subject_id,$topic_ids,$difficult_level){
    $ex_topic_ids=explode(',',$topic_ids);
    //echo '<pre>';print_r($ex_topic_ids);exit;
    $this->db->select('*');
    $this->db->where('subject_id',$subject_id);
    $this->db->where_in('qbank_topic_id',$ex_topic_ids);
    $this->db->where('difficult_level',$difficult_level);
    $this->db->order_by('id','RANDOM');
   // $this->db->order_by('rand()');
    $query=$this->db->get('quiz_questions');
    $result=$query->result_array();

    foreach ($result as $key => $value) {
        $this->db->select('id as option_id,options,image');
        $this->db->where('question_id',$value['id']);
        $query=$this->db->get('quiz_options');
        $options=$query->result_array();
        $result[$key]['options']=$options;
    }
    return $result;

}


public function getTopicsWithSubjectID($user_id,$subject_id){
    $this->db->select('id as topic_id,course_id,subject_id,chapter_id,name,title,description,quiz_type,questions_count,order,status');
    $this->db->where('subject_id',$subject_id);
    $this->db->order_by('id','asc');
    $query=$this->db->get('quiz_qbanktopics');
    $result=$query->result_array();
    return $result;
}


public function getCustomExamID(){

     /* Reference No */

        $this->db->select("*");
        $this->db->from('tbl_dynamic_nos');
        $query = $this->db->get();
        $row_count = $query->num_rows();
        if($row_count > 0){

            $refers_no = $query->row_array();
            $ref_no=$refers_no['custom_exam_no']+1;
            $refernce_data = array('custom_exam_no' => $ref_no,
                                   'update_date_time'    => date('Y-m-d H:i:s')
                                   );
            $this->db->where('id ',1);
            $update = $this->db->update('tbl_dynamic_nos', $refernce_data);
        }else{

            $ref_no=1;
            $refernce_data = array('custom_exam_no' => $ref_no,
                                    'update_date_time'   => date('Y-m-d H:i:s')
                                    );
            $update = $this->db->insert('tbl_dynamic_nos', $refernce_data); 
        }
        
        if(strlen($ref_no) == 1){
            $reference_id =  'EXAM'.'000'.$ref_no;
        }else if(strlen($ref_no) == 2){
            $reference_id =  'EXAM'.'00'.$ref_no;
        }else if(strlen($ref_no) == 3){
            $reference_id =  'EXAM'.'0'.$ref_no;
        }else if(strlen($ref_no) == 4){
            $reference_id =  'EXAM'.$ref_no;
        }
        
        //$reference_id="BBM".$ref_no;
        /* Reference No */
        return $reference_id;
}


}

?>