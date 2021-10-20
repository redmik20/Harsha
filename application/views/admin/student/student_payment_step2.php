<!DOCTYPE html>
<html>

<head>
    <title>Link</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>

    </style>
</head>

<body>

              <center><h3 style="color:green">Student Admission from</h3></center></br>
              <?php if($this->session->flashdata('error') != ''){?>
                                    <div class="alert alert-block alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">
                                        <i class="fa fa-close"></i>
                                        </button>
                                        <p>
                                            <i class="icon-ok"></i>
                                            <?php echo $this->session->flashdata('error')?$this->session->flashdata('error'):'';?>
                                        </p>
                                    </div>
                             <?php } ?>
              <form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/student_adm/admission_link_step2_continue/<?php echo $id;?>" enctype="multipart/form-data">
    <div id="News" class="container">

        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">Center <span class="red bigger-120">*</span></label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <?php echo $center['center'];?>
            </div>
        </div>

        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">Batch <span class="red bigger-120">*</span></label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <?php echo $batch_data['batch_name'];?>
            </div>
        </div>

        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">Student Name <span class="red bigger-120">*</span></label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <input class="form-control" placeholder="" type="text" name="student_name" value="<?php echo $this->session->userdata('student_name'); ?>" id="frist_name"
                    onkeyup="" required>
            </div>
        </div>
        <input type="hidden" name="row_id" id="row_id" value="<?php echo $id;?>">
        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">Mobile Number <span class="red bigger-120">*</span></label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <input class="form-control" placeholder="Phone number" type="text" name="mobile_no" value="<?php echo $record['mobile_no'];?>"
                    id="mobile_number" required readonly>
            </div>
        </div>
        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">Gender<span class="red bigger-120">*</span></label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">

                <input type="radio" id="male" name="gender" <?php if($this->session->userdata('gender') == 'Male') { echo 'checked'; }?>  value="Male">
                <label for="male">Male</label><br>
                <input type="radio" id="female" name="gender" <?php if($this->session->userdata('gender') == 'Female') { echo 'checked'; }?> value="Female">
                <label for="female">Female</label><br>
            </div>
        </div>
        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">Alternate Mobile Number </label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <input class="form-control" placeholder="Phone number" type="text" name="alt_mobile_no" value="<?php echo $this->session->userdata('alt_mobile_no'); ?>"
                    id="alt_mobile_no" onkeyup="">
            </div>
        </div>
        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">Student Email Id <span class="red bigger-120">*</span></label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <input class="form-control" placeholder="" type="text" name="email_id" value="<?php echo $this->session->userdata('email_id'); ?>" id="email_id" onkeyup=""
                    required="">
            </div>
        </div>

        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">Address State</label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <select class="form-control" name="state_id" id="state_id"  >
                  <option value="">Select State</option>
                  <?php
                  if(!empty($states))
                  {
                    foreach($states as $state)
                    {
                      ?>
                      <option value="<?=$state['id'];?>" 
                        <?php if($this->session->userdata('adderss_state_id') == $state['id']){ ?> 
                            selected <?php }?> 
                        ><?=$state['state'];?></option>
                      <?php
                    }
                  }?>
               </select>
            </div>
        </div>
        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">Permanent Address</label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7  col-md-7 col-sm-7 col-xs-6">
                <textarea class="form-control" type="text" rows="6" placeholder="Should not exceed 250 Characters..."
                    name="permanent_address" id="permanent_address" value=""><?php echo $this->session->userdata('permanent_address'); ?></textarea>
            </div>
        </div>

        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">College of MBBS State <span class="red bigger-120">*</span></label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <select class="form-control" name="mbbs_state_id" id="mbbs_state_id" required="">
                    
                                              <option value="">Select State</option>
                                              <?php
                                              if(!empty($states))
                                              {
                                                foreach($states as $state)
                                                {
                                                  ?>
                                                  <option value="<?=$state['id'];?>" 
                            <?php if($this->session->userdata('mbbs_state_id') == $state['id']){ ?> 
                            selected <?php }?> 
                            ><?=$state['state'];?></option>
                                                  <?php
                                                }
                                              }?>
             
                </select>
            </div>
        </div>
        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">College of MBBS <span class="red bigger-120">*</span></label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <select class="form-control" name="college_mbbs_id" id="college_mbbs_id" required="">
                    <option value="">Select College</option>

                                              <?php
                                              if(!empty($colleges))
                                              {
                                                foreach($colleges as $college)
                                                {
                                                  ?>
                                                  <option value="<?=$college['id'];?>"

                            <?php if($this->session->userdata('mbbs_college_id') == $college['id']){ ?> 
                            selected <?php }?> 
                            ><?=$college['college_name'];?></option>
                                                  <?php
                                                }
                                              }?>
                </select>
            </div>
        </div>
        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">MBBS Batch <span class="red bigger-120">*</span></label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <input class="form-control" placeholder="" type="text" name="mbbs_batch" value="<?php echo $this->session->userdata('mbbs_batch'); ?>" id="mbbs_batch"
                    onkeyup="" required="">
            </div>
        </div>
        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">Internship College/Hospital</label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <input class="form-control" placeholder="" type="text" name="internship_college" value="<?php echo $this->session->userdata('internship_college'); ?>"
                    id="internship_college" onkeyup="">
            </div>
        </div>

        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">Join/Valid From<span class="red bigger-120">*</span></label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <input class="form-control" name="valid_from" id="batch_start_date" value="<?php echo $batch_data['start_date']?>"
                    data-date-format="yyyy-mm-dd" required readonly="">
            </div>
        </div>
        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">Valid To<span class="red bigger-120">*</span></label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <input class="form-control" name="valid_to" id="batch_end_date" value="<?php echo $batch_data['end_date']?>" data-date-format="yyyy-mm-dd"
                    required readonly="">
            </div>
        </div>

        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">Student Image</label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
               <input class="file-input" placeholder="" type="file" name="image" value="" id="image" >
            </div>
        </div>

        <div class="panel panel-default" style="margin-top:20px;">
            <div class="panel-body" style="max-height:600px; overflow-y:scroll; background-color:white;">
                <div style="text-align:center;">
                    <h1>Terms and Conditions</h1>
                    <p>
                        INSTRUCTIONS FOR STUDENTS :</br>
                        1. I/ We hereby declare that the information declared in the enrollment form is true and correct.
                        2. I/we have read the prospectus / brochure and being satisfied with the study system, faculty, previous examination results,infrastructure, syllabus and all other information of (DBMCIPL) in all respects and decided to take admission after giving due consideration to gigours of time, distance and studies ahead.....
                        <a style="color:red" target="_blank"
                            href="https://hyderabadbhatia.com/admin/student_adm/admission_link_step2_tc">Read more </a>
                    </p>
                </div>
            </div>
        </div>
        <div style="text-align:center;"
            ng-if="settings.Authentication.RequireTermsAndConditions && !UserInfo.approvedTermsAndConditions && UserInfo.isAuthenticated">
            <button style="margin:10px;" class="btn btn-primary" onClick="sendOtp()" type="submit">Agree to Terms and Conditions</button>
        </div>
        <div class="row form-group frm-btm">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                <label class="input-text">By Entering OTP I Agree to T&C<span class="red bigger-120">*</span></label>
            </div>
            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                <input class="form-control" name="otp" id="otp" value="" data-date-format="yyyy-mm-dd"
                    required>
            </div>
        </div>

        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                <input type="submit" name="submit" class="btn btm-sm btn-success btn-sm" value="Proceed to Pay" />
                <a class="btn btn-danger btn-sm" type="edit" href="#">Back
                </a>
            </div>
        </div>
    </div>

</form>
    </div>
    </div>
</body>

</html>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script>
         
            function getmmbscolleges(state_id){
                //alert(state_id);

                     $.ajax({
                      type: 'post',
                      url: 'https://hyderabadbhatia.com/admin/student_adm/getmmbscolleges',
                      data: {state_id: state_id},
                      
                      success: function(data){ 
                        $("#college_mbbs_id").html(data);
                        
                      }
                    });

                 }

                 function sendOtp(){
                    //alert();

                var mobile=document.getElementById("mobile_number").value; 
                    //alert(mobile);
                    var id= document.getElementById("row_id").value;

                    $.ajax({
                      type: 'post',
                      url: 'https://hyderabadbhatia.com/admin/student_adm/sendOTPThroughLink',
                      data: {mobile: mobile,id: id},
                      beforeSend: function(xhr){
                        xhr.overrideMimeType("text/plain; charset=utf-8");
                        $("#wait").css("display", "block");
                      },
                      success: function(data){ 
                        //$("#college_mbbs").html(data);
                        alert('OTP sent Successfully');
                        $("#wait").css("display", "none");
                      }
                    });

                 }
       
     </script>

