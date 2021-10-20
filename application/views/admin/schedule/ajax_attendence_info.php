 <section class="edu_admin_content" style="padding-bottom: 0px;">  
          <div class="sectionHolder edu_admin_right edu_dashboard_wrap">
            <div class="edu_dashboard_widgets">             
                <div class="row">
                  <div class="col-xl-12 col-lg-3 col-md-3 col-sm-12 col-12">
                    <a href="#">
                      <div class="edu_color_boxes box_left">
                        <div class="edu_dash_box_data">
                            <p><b>Batch Checking</b></p> 
                        </div>
                        <?php if($student_batch_validation == 'batch_not_exists'){?>
                        <div class="edu_dash_box_icon" style="background-color: #f3f7f9;color: red;">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                       <?php }else{?>
                        <div class="edu_dash_box_icon" style="background-color: #f3f7f9;color: green;">                             
                          <i class="fa fa-check" aria-hidden="true"></i>
                        </div>
                       <?php }?>

                        <div class="edu_dash_info">
                          <ul>
                            <?php  
                            $batch_id=$student['batch_id'];
                            $batch=$this->db->query("select batch_name from tbl_batchs where id='".$batch_id."' ")->row_array();?>
                            <li><p><b>Batch Name : </b><span><b><?php echo $batch['batch_name'];?></b></span></p></li>
                          </ul>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-xl-12 col-lg-3 col-md-3 col-sm-12 col-12">
                    <a href="#">
                      <div class="edu_color_boxes box_center">
                        <div class="edu_dash_box_data">
                          <p><b>Batch Expire</b></p>
                        </div>
                        <?php if($batch_time_validation == 'expired'){?>
                        <div class="edu_dash_box_icon" style="background-color: #f3f7f9;color: red;">
                          <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                      <?php }else{?>
                        <div class="edu_dash_box_icon" style="background-color: #f3f7f9;color: green;">  
                          <i class="fa fa-check" aria-hidden="true"></i>
                        </div>
                      <?php }?>
                        <div class="edu_dash_info">
                          <ul>
                            <li><p><b>Batch End Date : </b><span><b><?php echo $student['valid_to']; ?></b></span></p></li>
                          </ul>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-xl-12 col-lg-3 col-md-3 col-sm-12 col-12">
                    <a href="#">
                      <div class="edu_color_boxes box_right">
                        <div class="edu_dash_box_data">
                            <p><b>Fee Check</b></p>
                        </div>
                        <?php if($check_due_amount == 'duedateexpired'){?>
                        <div class="edu_dash_box_icon" style="background-color: #f3f7f9;color: red;">
                          <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                      <?php }else{?>
                        <div class="edu_dash_box_icon" style="background-color: #f3f7f9;color: green;">  
                          <i class="fa fa-check" aria-hidden="true"></i>
                        </div>
                      <?php }?>
                        <div class="edu_dash_info">
                          <?php  
                            $student_id=$student['id'];
                            $query="select * from tbl_student_payment_details where student_id='".$student_id."' order by id desc ";
                            //echo $query;exit;
                            $payment_row=$this->db->query($query)->row_array();
                           

                            ?>
                          <ul>
                            <li><p><b>Due Fee  : </b><span><b>
                              <?php 
                              if(!empty($payment_row)){
                                echo $payment_row['due_amount'];
                              }else{
                                echo 'no-payments';
                              }
                              
                            ?></b></span></p></li>
                            <li><p><b>Due Date  : </b><span><b>
                              <?php 
                              if(!empty($payment_row)){
                                echo $payment_row['due_date'];
                              }else{
                                echo '00-00-0000';
                              }
                              
                            ?></b></span></p></li>
                          </ul>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-xl-12 col-lg-3 col-md-3 col-sm-12 col-12">
                    <a href="#">
                      <div class="edu_color_boxes box_right">
                        <div class="edu_dash_box_data">
                            <p><b>Today Not Attended </b></p>
                        </div>
                       <?php if($student_attendence_validation == 'already_attentened'){?>
                        <div class="edu_dash_box_icon" style="background-color: #f3f7f9;color: red;">
                          <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                      <?php }else{?>
                        <div class="edu_dash_box_icon" style="background-color: #f3f7f9;color: green;">  
                          <i class="fa fa-check" aria-hidden="true"></i>
                        </div>
                      <?php }?>
                        <div class="edu_dash_info">


                          <ul>
                            <li><p><b>Last Attended Date : </b><span><b><?php echo $scaned_date?></b></span></p></li>
                            <li><p><b>Time: </b><span><b><?php echo $scaned_time?></b></span></p></li>
                          </ul>
                        </div>
                      </div>
                    </a>
                  </div>

                </div>                    
              </div>
                  </div>
            </section>
             
            <form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url('admin/specialattendance/submitspl_attendence')?>" enctype="multipart/form-data" novalidate="">
              <div class="row">
                <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Event Id<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <div class="form-group">
                        <b>
                        <input class="form-control" placeholder="" type="text" name="event_id" value="<?php echo $event_data['event_unique_id'] ?>" id="event_id" onkeyup="" required="" data-parsley-id="1436" readonly><ul class="parsley-errors-list" id="parsley-id-1436"></b>
                      </div>
                    </div>
                  </div>

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Student Id<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <div class="form-group">
                        <b>
                        <input class="form-control" placeholder="" type="text" name="student_id" value="<?php echo $student['student_dynamic_id'] ?>" id="student_id" onkeyup="" required="" data-parsley-id="1436" readonly><ul class="parsley-errors-list" id="parsley-id-1436"></b>
                      </div>
                    </div>
                  </div>

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                      <label class="input-text">Student Name<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <div class="form-group">
                         <b>
                        <input class="form-control" placeholder="" type="text" name="student_name" value="<?php echo $student['student_name'] ?>" id="student_name" onkeyup="" required="" data-parsley-id="5789" readonly><ul class="parsley-errors-list" id="parsley-id-5789"></b>
                      </div>
                    </div>
                  </div> 

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                      <label class="input-text">Reason<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <div class="form-group">
                        <textarea class="form-control" rows="5" name="reason" value="" id="reason"></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                      <input type="submit" name="add" class="btn btm-sm btn-success btn-sm" value="Submit Attendance">
                    </div>                
                  </div> 
                </div>
              </div>
            </form> 