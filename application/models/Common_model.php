<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Common_model extends CI_Model{

    public function __construct()
    {
     parent::__construct();
    
     $this->db2 = $this->load->database('plato', TRUE);
     
    }

public function get_table_row($table_name='', $where='', $columns='', $order_column='', $order_by='asc', $limit=''){

			if(!empty($columns)) {

			$tbl_columns = implode(',', $columns);

			$this->db->select($tbl_columns);

			}

			if(!empty($where)) $this->db->where($where);

			if(!empty($order_column)) $this->db->order_by($order_column, $order_by); 

			if(!empty($limit)) $this->db->limit($limit); 

			$query = $this->db->get($table_name);

			if($columns=='test') { echo $this->db->last_query(); exit; }

			  //echo $this->db->last_query();exit;

			return $query->row_array();

}



 public function get_table($table_name='', $where='', $columns='', $order_column='', $order_by='asc', $limit='', $offset=''){

		if(!empty($columns)) 

		{

		$tbl_columns = implode(',', $columns);

		$this->db->select($tbl_columns);

		}

		if(!empty($where)) $this->db->where($where);

		if(!empty($order_column)) $this->db->order_by($order_column, $order_by); 

		if(!empty($limit) && !empty($offset)) $this->db->limit($limit, $offset); 

		else if(!empty($limit)) $this->db->limit($limit); 

		$query = $this->db->get($table_name);

		//echo $this->db->last_query(); exit;

		//if($columns=='test') { echo $this->db->last_query(); exit; }

		//echo $this->db->last_query();

		return $query->result_array();

}	

public function insert_table($table_name='', $array='', $insert_id ='', $batch=false){

	if(!empty($array) && !empty($table_name)){

	if($batch){

	$this->db->insert_batch($table_name, $array);

	}

	else {$this->db->insert($table_name, $array);}

	//echo $this->db->last_query(); exit;

	//if(!empty($insert_id)) return $this->db->insert_id();

	return $this->db->insert_id();

	}

}

public function update_table($table_name='', $array='', $where='', $test=0)



	{		



		if(!empty($array) && !empty($table_name) && !empty($where))



		{



			$this->db->where($where);



			$result=$this->db->update($table_name, $array);



			



		}

	//	echo $this->db->last_query(); exit;

		return  $result;

		//if($test) echo $this->db->last_query(); exit;



	}		

	

	public function delete_rows($table_name='', $where=''){

		if(!empty($table_name) && !empty($where))

		{

		$this->db->where($where);

		$result=$this->db->delete($table_name);

		}

		return  $result;

		//echo $this->db->last_query(); exit;

		}

    public function insert_student_record_mainDB($payment_info){

    $admission_no=getDynamicId('admission_no','ADMS');
    $password= 'bhatia123';
    $batch=$this->get_table_row('batchs',array('id'=> $payment_info['batch_id']),array('student_code'));
            if($batch['student_code'] != ''){
                $stuent_code=$batch['student_code'];
            }else{
                $stuent_code='STDN';
            }
            
            $student_dynamic_id=getDynamicId('student_no',$stuent_code);

    $insert_data=array(
                             'state_id'=> $payment_info['state_id'],
                             'organisation_id'=> $payment_info['organisation_id'],
                             'admission_no'=>$admission_no,
                             'student_dynamic_id'=>$student_dynamic_id,
                             'center_id' => $payment_info['center_id'],
                             'course_id' => $payment_info['course_id'],
                             'batch_id' => $payment_info['batch_id'], 
                             'student_name' => $payment_info['student_name'],
                             'student_mobile' => $payment_info['mobile_no'],
                             'image'=>$payment_info['student_image_path'],
                             'password'=>md5($password),
                             'student_alt_mobile' => $payment_info['alt_mobile_no'],
                             'student_email' => $payment_info['email_id'],
                             'gender'=> $payment_info['gender'],
                             'material_status'=>$payment_info['material_status'],
                             'permanent_address' => $payment_info['permanent_address'],
                             'address_state_id' => $payment_info['adderss_state_id'],
                             'college_mbbs' => $payment_info['mbbs_college_id'],
                             'mbbs_state' => $payment_info['mbbs_state_id'],
                             'internship_college' => $payment_info['internship_college'],
                             'valid_from' => $payment_info['valid_from'],
                             'valid_to' => $payment_info['valid_to'],
                             'adding_from' => 'payment_link',
                             'created_by'=>$payment_info['created_by'],
                             'created_on'=>date('Y-m-d H:i:s'),
                             'status'=>'Active'
                          );
        $result=$this->db->insert('students',$insert_data);
       // echo $this->db->last_query();exit;
        $insert_id=$this->db->insert_id();
       // $this->createAndSaveAdmissionLink($insert_id);
         $insert_db2=array(
                            'student_id'=>$student_dynamic_id,
                            'bhatia_row_id'=>$insert_id,
                            'state_id'=> $payment_info['state_id'],
                            'organisation_id'=> $payment_info['organisation_id'],
                            'center_id' => $payment_info['center_id'],
                            'course_id' => $payment_info['course_id'],
                            'batch_id' => $payment_info['batch_id'],
                            'admission_no'=>$admission_no,
                            'name'=> $payment_info['student_name'],
                            'email_id'=> $payment_info['email_id'],
                            'mobile'=> $payment_info['mobile_no'],
                            'password'=> md5($password),
                            'gender'=> $payment_info['gender'],
                            'image'=> $payment_info['student_image_path'],
                            'delete_status'=>1,
                            'status'=>'Active',
                            'adding_through'=> 'payment_link',
                            'created_on'=>date('Y-m-d H:i:s'),
                         );
         $result=$this->db2->insert('users',$insert_db2);
         $insert_id2=$this->db2->insert_id();
         $batch_id=$payment_info['batch_id'];
         $exam=$this->db2->query("select id from exams where bhatia_batch_id=".$batch_id." ")->row_array();

         $insert_users_exams=array(
                                'user_id'=> $insert_id2,
                                'exam_id'=> $exam['id'],
                                'payment_type'=>'paid',
                                'delete_status'=>1,
                                'status'=>'Active',
                                'created_on'=> date('Y-m-d H:i:s')
                              );

        $this->db2->insert('users_exams',$insert_users_exams);

        //$this->db2->update();
        
        $total_fee=$payment_info['final_fee'];
        $amount_paid=$payment_info['student_paid_amt'];
        $due_amount=$total_fee-$amount_paid;
        if($due_amount == 0){
            $final_settled='yes';
        }else{
            $final_settled='no';
        }

        $payment_data= array(
                            'type'=>'bhatia',
                            'amount_type'=>'income',
                            'amount_from'=>'1',
                            'state_id'=> $payment_info['state_id'],
                            'organisation_id'=> $payment_info['organisation_id'],
                            'center_id' => $payment_info['center_id'],
                            'course_id' => $payment_info['course_id'],
                            'batch_id' => $payment_info['batch_id'],
                            'student_id'=>$insert_id,
                            'student_dy_id'=>$student_dynamic_id,
                            'receipt_id'=>$payment_info['receipt_id'],
                            'student_name'=>$payment_info['student_name'],
                            'mobile_number'=>$payment_info['mobile_no'],
                            'college_state_id'=>$payment_info['mbbs_state_id'],
                            'college_id'=>$payment_info['mbbs_college_id'],

                            'transaction_id'=>$payment_info['razorpay_payment_id'],
                            'payment_mode_id'=>'152',
                            'attachment_id'=>'47',
                            'total_fee'=>$payment_info['final_fee'],
                            'amount_paid'=>$payment_info['student_paid_amt'],
                            'amount_paid_date'=>date('Y-m-d'),
                            'due_amount'=>$due_amount,
                            'final_settled'=>$final_settled,
                            'approval_status'=>'Pending',
                            'razorpay_order_id'=>$payment_info['razorpay_order_id'],
                            'razorpay_signature'=>$payment_info['razorpay_signature'],
                            'remarks'=>$payment_info['payment_msg'],
                            'created_on'=>$payment_info['payment_created_on'],
                            'created_by'=>$payment_info['created_by'],
                            );
          $this->db->insert('student_payment_details',$payment_data);
          //$this->save_pdf($payment_info['receipt_id'],'no');
          $this->db->delete('students_before_admissions',array('id'=>$payment_info['id']));
          $this->createAndSaveAdmissionLink($insert_id,$payment_info['receipt_id']);
          return $insert_id;
        }

        
        public function createAndSaveAdmissionLink($id,$receipt_id){

            $data['record'] =  $this->getStudentRecord($id);
            $admission_no=$data['record']['admission_no'];
            //$data['student_payment_detials']=$this->getStudentPaymentDetails($data['record']['id']);
            $data['payment_data'] =  $this->get_table_row('student_payment_details', array('receipt_id' => $receipt_id),array());

            $this->load->library('M_pdf');
            $html=$this->load->view('admin/student/student_admission_pdf',$data, true); 
           
            $pdfFilePath = $admission_no.".pdf"; 
            $this->m_pdf->pdf->WriteHTML($html);
            //download it D save F.
            $this->m_pdf->pdf->Output("./storage/studentadmpdfs/".$pdfFilePath, "F");

         
          
         $path= "storage/studentadmpdfs/".$pdfFilePath;
         $full_path=base_url().$path;
         $admission_link="https://hyderabadbhatia.com/admin/student_adm/admission_link_step2_continue/".$id;

         $update_path=array('admission_pdf_path' => $path,'admission_link' => $admission_link);
         $this->db->update('students',$update_path,array('admission_no' => $admission_no));

         $update_path2=array('receipt_pdf_path' => $path);
         $this->db->update('student_payment_details',$update_path2,array('receipt_id' => $receipt_id));

         
         $student_name= $data['payment_data']['student_name'];
         $student_mobile= $data['payment_data']['mobile_number'];
         $amount_paid=$data['payment_data']['amount_paid'];
         $payment_made_for=$data['payment_data']['payment_for'];
         $student_id=$data['record']['student_dynamic_id'];

         
         //$message="Dear ".$student_name.",your admission process successfully completed and your payment has been received successfully for INR ".$amount_paid.".00 by ISSM EDUCATION SERVICES Pvt Limited click here to for admission details https://hyderabadbhatia.com/storage/studentadmpdfs/".$pdfFilePath." . Kindly install app to be in touch and updated with your batch information ,ios App Link: https://apps.apple.com/in/app/mci-my-coaching-institute/id1557535056 for Android App Link: https://play.google.com/store/apps/details?id=com.hyderabad.bhatia ,Your Credentials ID:".$student_mobile." and Password:bhatia123 .Thank You -Bhatia";


         $message="Dear ".$student_name.",your admission process successfully completed and your payment has been received successfully for INR ".$amount_paid.".00 by ISSM EDUCATION SERVICES Pvt Limited click here to for admission details https://hyderabadbhatia.com/storage/studentadmpdfs/".$pdfFilePath." . Kindly install app to be in touch and updated with your batch information ,ios App Link: https://apps.apple.com/in/app/mci-my-coaching-institute/id1557535056 for Android App Link: https://play.google.com/store/apps/details?id=com.hyderabad.bhatia ,Your Credentials ID:".$student_mobile." and Password:bhatia123 .Thank You -Bhatia";
         
         SendSMS($student_mobile,$message);

        }

        public function getStudentRecord($id){

            $query="select s.*,st.state,org.organisation_name,c.center,b.batch_name as batch,cu.course_name,cg.college_name from tbl_students s left join tbl_states st on st.id=s.state_id left join tbl_organisations org on org.id=s.organisation_id left join tbl_centers c on c.id=s.center_id left join tbl_batchs b on b.id=s.batch_id left join tbl_courses cu on cu.id=s.course_id left join tbl_colleges cg on cg.id=s.college_mbbs where s.id='".$id."' ";
            //$query="select tbl_students.* from tbl_students where id=$id";
            return $this->db->query($query)->row_array();

        }

        public function getStudentPaymentDetails($id){

            $query="select * from tbl_students_payments where student_id='".$id."' ";
            return $this->db->query($query)->row_array();
        }

public function save_pdf($receipt_id,$previous_payment)
         { 
            $path=''; $full_path='';

         //load mPDF library
         $this->load->library('M_pdf'); 
         //now pass the data//
         $data['payment_data'] =  $this->get_table_row('student_payment_details', array('receipt_id' => $receipt_id),array());
        //echo '<pre>';print_r($data['payment_data']);exit;
         $html=$this->load->view('admin/paymentportal/payment_nonbhatia_pdf',$data, true); //load the pdf.php by passing our data and get all data in $html varriable.
         //echo $html;exit();
         $pdfFilePath = $receipt_id.".pdf"; 
         
         $this->m_pdf->pdf->WriteHTML($html);

            //download it D save F.
         $this->m_pdf->pdf->Output("./storage/paymentreceipts/".$pdfFilePath, "F");
         $path= "storage/paymentreceipts/".$pdfFilePath;
         $full_path=base_url().$path;
         unset($html);
         
         $student_name= $data['payment_data']['student_name'];
         $student_mobile= $data['payment_data']['mobile_number'];
         $amount_paid=$data['payment_data']['amount_paid'];
         $payment_made_for=$data['payment_data']['payment_for'];

         $update_path=array('receipt_pdf_path' => $path);
         $this->db->update('student_payment_details',$update_path,array('receipt_id' => $receipt_id));

         if($previous_payment == ''){
         $message="Dear $student_name,your payment has been recived successfully for INR ".$amount_paid.".00 by ISSM EDUCATION SERVICES Pvt Limited for $payment_made_for click here to for invoice details $full_path ,Thank You.";
            }else{
         $message="Dear $student_name, we are here to inform a change in your receipt that the receipt was wrongly generated for INR ".$previous_payment.".00, but the payment done is INR ".$amount_paid.".00 we are sending the new updated receipt link $full_path. Kindly call +919381915159 if there is any dispute in the issue,Thank You.";
            }
          //echo $message;exit;
         SendSMS($student_mobile,$message);
         }
/** In Function Get single records for edit view purpose from select table **/
    public function get_responsibilities_user() {
        $this->db->select("*");
        $this->db->from('users');
        $this->db->where("user_id",$this->session->userdata('user_id'));
        $query = $this->db->get();
        $result = $query->row_array();
       // echo '<pre>';print_r( $result );exit;
        return $result;
    }
/** In Function Get single records for edit view purpose from select table **/
    public function get_responsibilities() {
        $res = $this->get_responsibilities_user();
        $idArr = @explode(',',$res['role_ids']);
        $this->db->select("*");
        $this->db->from('roles');
        $this->db->where_in('id', $idArr);
        $query = $this->db->get();
        $roles = $query->result_array();
        //echo $this->db->last_query();
        
        $CRows = array();
        $modules_name = $this->module_name();
        for ($i = 0; $i < count($roles); $i++) {
            foreach($modules_name as $key => $value){
                if( !array_key_exists( $roles[$i][$key], $CRows ) == true){
                    $CRows[$key][] = explode(',',$roles[$i][$key]);
                }
            }
        }
        $finalArr = array();
        foreach($CRows as $key => $value){
            $newArr =  new RecursiveIteratorIterator(new RecursiveArrayIterator($value));
            $final = array_values(array_unique(array_filter(iterator_to_array($newArr, false))));
            if(!empty($final)){
                $finalArr[$key] = $final;
            }else{
                $finalArr[$key] = '';
            }
            
        }
        //echo '<pre>';print_r($finalArr);
        return $finalArr;
    }
public function module_name(){
        return $modules_name = array(
            'dashboard' => 'Dashboard',
            'employee_dashboard'=> 'Employee Dashboard',
            'total_batches'=> 'Total Batchs',
            'daily_sheet'=> 'Daily Sheet',
            'my_collection'=> 'My Collection',
            'my_admission'=> 'My Admission',
            'students' => 'Students',
            'student_payments'=>'Student Payments',
            'bulk_students' => 'Bulk Students',
            'overview_details' => 'OVERVIEW Details',
            'available_funds' => 'Available Funds',
            'transfer_funds' => 'Transfer Funds',
            'payment_approvals' => 'Payment Approvals',
            'general_students' => 'General Students',
            'all_registered_students' => 'All Registered Students',
            'expenses' => 'Expenses',
            'expense_approval' => 'Expense Approval',
            'categories' => 'Categories',
            'advance_release' => 'Advance Release',
            'states' => 'States',
            'organisations' => 'Organisations',
            'centers' => 'Centers',
            'courses' => 'Courses',
            'batchs' => 'Batchs',
            'attachment_groups' => 'Attachment Groups',
            'attachments' => 'Attachments',
            'payment_modes' => 'Payment Modes',
             'colleges' => 'Colleges',
             'discount_schemes' => 'Discount Schemes',
             'departments' => 'Departments',
             'in_stock' => 'In stock',
             'schedule' => 'Schedule',
             'events' => 'Events',
             'special_attendance' => 'Special Attendance',
             'roles' => 'Roles',
             'employees' => 'Employees',
             );
    }
public function get_default_responsibilities(){
        $modules = array(
            'dashboard' => array(
                '0' => 'l'
            ),
            'employee_dashboard' => array(
                '0' => 'l'
            ),

            'my_collection' => array(
                
                '0' => 'e'
            ),

            'my_admission' => array(

                '0' => 'l',
                '1' => 'e',
            ),
            'daily_sheet' => array(

                 '0' => 'l'
             ),
            'total_batches'=>array(
                '0' => 'l'
             ),
            
            
            'students' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            ),
            'student_payments' => array(
                '0' => 'e',
            ),
            'bulk_students' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 's',
            ),
            'overview_details' => array(
                '0' => 'l',
               
            ),                        
            'available_funds' => array(
                '0' => 'l',
                              
            ),  
            'transfer_funds' => array(
                '0' => 'l',
            ),

            'payment_approvals'  => array(
                '0' => 'l',
                '1' => 's',
                '2' => 'd',
                              
            ),            
            'general_students' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd'

            ),
            'all_registered_students' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd'
            ),
            'expenses' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            ),
            'expense_approval' => array(
                '0' => 'l',
                '1' => 'd',
            ),
            
            'categories' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            
            ),
            'advance_release' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            
            ),
            'states' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            ),
            'organisations' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            ),
            
            'centers' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            ),
            'courses' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            ),

            
            'batchs' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
                
            ),

            'attachment_groups' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            ),

             'attachments' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
                
            ),

             'payment_modes' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
                
            ),
             'colleges' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
                
            ),
             'discount_schemes' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
                
            ),
             'departments' => array(
               '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
                
            ),
             'in_stock' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            ),
             'schedule' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            ),

            'events' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            ),
            'special_attendance' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd'
            ),
            'roles' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            ),
            'employees' => array(
                '0' => 'l',
                '1' => 'a',
                '2' => 'e',
                '3' => 'd',
                '4' => 's'
            ),
            
                
        );
        return $modules;
    }
public function module_names(){
    $modules = array(
            'Dashboard' => array(
                'l' => 'View'
            ),
            'Employee Dashboard' => array(
                'l' => 'View'
            ),
            'My Collection' => array(
               'e' => 'Edit'
            ),

            'My Admission' => array(
               'l' => 'View',
               'e' => 'Edit',
            ),

            'Daily Sheet' => array(
               'l' => 'View',
            ),
            
            'Total Batches' => array(
               'l' => 'View',
            ),

            
            
            'Students' => array(
                
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
            ),

            'student_payments' => array(
                'e' => 'Edit',
            ),
            'Bulk Students' => array(
                'l' => 'View',
                'a' => 'Add',
                's' => 'Status',
            ),
            'OVERVIEW Details' => array(
                'l' => 'View',              
            ),
            'Available Funds' => array(
                'l' => 'View',              
            ),
            'Transfer Funds' => array(
                'l' => 'View',
            ),
            'Payment Approvals'  => array(
                'l' => 'View',
                's' => 'Status',
                'd' => 'Delete',
                              
            ), 
            'General Students' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',              
            ),
            'All Registered Students' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',             
            ),
            'Expenses' => array(
                
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
            ),
            'Expense Approval' => array(
                
                'l' => 'View',
                'd' => 'Delete',
                
                
            ),
            'Categories' => array(
                
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
            ),
            'Advance Release' => array(
                
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
            ),
            'States' => array(
                
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
            ),
            'Organisations' => array(
                
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
            ),
            'Centers' => array(
                
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
            ),
            'Courses' => array(
                
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
            ),

            'Batchs' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
                
            ),

            'Attachment Groups'=>array(

                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',

            ),
           
            'Attachments' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
                
            ),
            'Payment Modes' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
                
            ),
            'Colleges' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
                
            ),
            'Discount Schemes' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
                
            ),
            'Departments' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
                
            ),

            'In Stock' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
                
            ),
            'Schedule' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
                
            ),
            'Events' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
                
            ),
            'Special Attendance' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
            ),
           'Roles' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
                
            ),
           'Employees' => array(
                'l' => 'View',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status',
                
            ),

           

          

            );

        return $modules; 
}

public function module_methods(){
        return $modules_name = array(
                'l' => 'List',
                'a' => 'Add',
                'e' => 'Edit',
                'd' => 'Delete',
                's' => 'Status'
            );
    }


}

?>