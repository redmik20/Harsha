<?php

defined('BASEPATH') OR exit('No direct script access allowed');

 

    class Import_model extends CI_Model {

 

        public function __construct()

        {

            $this->load->database();

        }

        

        public function insert($data) {

               
            $check_user=$this->get_checkUser($data[1]);
           // echo '<pre>';print_r( $check_user);
                if(empty($check_user)){

                  $newuser = array(

                    "name" => trim($data[0]),
                    "mobile" => trim($data[1]),
                    "email_id"=> trim($data[2]),
                    "status"=> trim($data[3]),
                    "created_on"=>  trim($data[4]),
                    );



           $res = $this->db->insert('users',$newuser);

           $user_id = $this->db->insert_id();

           /*$insert_data=array(

                            'user_id'=> $user_id,

                            'exam_id'=>$course_id,
                     
                            'payment_type'=>  trim($data[2]),

                            'delete_status'=>1,

                            'status'=>'Active',

                            'created_on'=>date('Y-m-d H:i:s')

                        );

                $this->db->insert('users_exams',$insert_data);*/ 

            return TRUE;

         }else{

            /*$exist_user_id=$check_user['id'];
            $query="select id from users_exams where exam_id='".$course_id."' and user_id='".$exist_user_id."' ";
             // echo $query;exit;
            $user_exam=$this->db->query($query)->row_array();

            $update_array=array(
                                    'payment_type'=> trim($data[2])
                               );

            $this->db->where('id', $user_exam['id']);
            $this->db->update('users_exams', $update_array);*/

            return TRUE;

         }

           /* if($res){

                return TRUE;

            }else{

                return FALSE;

            }*/

      

        }


        public function get_checkUser($mobile){


            $query="select id from users where mobile='".$mobile."' and delete_status='1'";
            echo $query;
            $result=$this->db->query($query)->row_array();
            return $result;
        }  

    }

?>