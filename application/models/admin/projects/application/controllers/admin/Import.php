<?php

 

defined('BASEPATH') OR exit('No direct script access allowed');

 

class Import extends CI_Controller {

    // construct

      public function __construct() {

         parent::__construct();

         // load model

         $this->load->model('admin/Import_model','import');

         $this->load->helper(array('url','html','form'));

      }    

 

      public function index() {

         $this->load->view('import');

      }

 

    public function importFile(){

   

         $data = array();

         $config['upload_path'] = 'uploads'; 

         $config['allowed_types'] = 'csv'; 

         $config['max_size'] = '1000'; // max_size in kb 

         $config['file_name'] = $_FILES['upload']['name'];

         $config['remove_spaces'] = TRUE;

         $this->load->library('upload', $config);

         $this->upload->initialize($config);            

         if (!$this->upload->do_upload('upload')) {

             $error = array('error' => $this->upload->display_errors());

         } else {

             $data = array('upload_data' => $this->upload->data());

         }

         if($this->upload->do_upload('upload')){ 

            // Get data about the file

            $uploadData = $this->upload->data(); 

            $filename = $uploadData['file_name'];



            // Reading file

            $file = fopen("uploads/".$filename,"r");

            $i = 0;



            $importData_arr = array();

 

            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {

               $num = count($filedata );



               for ($c=0; $c < $num; $c++) {

                  $importData_arr[$i][] = $filedata [$c];

               }

               $i++;

            }

            fclose($file);

         $course_id=$this->input->post('course_id');

            $skip = 0;         

            foreach($importData_arr as $userdata){              

                  $this->import->insert($userdata,$course_id);

               $skip ++;

            }

            $data['response'] = 'successfully uploaded '.$filename; 

         }else{ 

            $data['response'] = 'failed'; 

         } 

     

     

      redirect('admin/register/users', 'refresh');

    



  }

function importFile1FromUsers(){

    

         $data = array();

         $config['upload_path'] = 'uploads'; 

         $config['allowed_types'] = 'csv'; 

         $config['max_size'] = '1000'; // max_size in kb 

         $config['file_name'] = $_FILES['upload']['name'];

         $config['remove_spaces'] = TRUE;

         $this->load->library('upload', $config);

         $this->upload->initialize($config);            

         if (!$this->upload->do_upload('upload')) {

             $error = array('error' => $this->upload->display_errors());

         } else {

             $data = array('upload_data' => $this->upload->data());

         }

         if($this->upload->do_upload('upload')){ 

            // Get data about the file

            $uploadData = $this->upload->data(); 

            $filename = $uploadData['file_name'];



            // Reading file

            $file = fopen("uploads/".$filename,"r");

            $i = 0;



            $importData_arr = array();

 

            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {

               $num = count($filedata );



               for ($c=0; $c < $num; $c++) {

                  $importData_arr[$i][] = $filedata [$c];

               }

               $i++;

            }

            fclose($file);

            //$course_id=$this->input->post('course_id');
           // echo '<pre>';print_r($course_id);

            $skip = 0;         

            foreach($importData_arr as $userdata){              

                  $this->import->insert($userdata);

                  

               $skip ++;

            }

            $data['response'] = 'successfully uploaded '.$filename; 

         }else{ 

            $data['response'] = 'failed'; 

         } 

     

     

      redirect('admin/register/users', 'refresh');

    



  }   

    

}    





?>