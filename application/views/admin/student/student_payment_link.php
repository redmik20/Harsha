
<div class="main-content">
        <div class="main-content-inner">
          <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
              try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>
            <ul class="breadcrumb">
              <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="<?php echo site_url();?>admin/dashboard">Home</a>
              </li>
              <li>                 
                <a href="<?php echo site_url();?>#">Students</a>
              </li>
              <li class="active"> Add</li>
            </ul>            
          </div>

          <div class="page-content">
            <div class="page-header-2">
              <h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
                <i class="menu-icon fa fa-list-ul blue"></i>Students
                <span class="label label-purple arrowed">Add<span>
              </h1>
              <div class="pull-right ">              
                 <input type="hidden" name="hiv" id="hiv" value="0" />
                           </div>
            </div><!-- /.page-header -->
            
             <?php echo $message; ?>


          <button style="padding: 11px;font-size: 20px;" class="tablink" onclick="openPage('Home', this, '')">Organisation Details</button>
          <button style="padding: 11px;font-size: 20px;" class="tablink" onclick="openPage('News', this, '')">Student Information
          </button>
          <button style="padding: 11px;font-size: 20px;" class="tablink" onclick="openPage('Contact', this, '#000')" id="defaultOpen">Fee Details</button>
          <br><br>
          <div id="Home" class="tabcontent">
            <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Select State<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <select class="form-control" name="state_id" id="state_id" required="" onchange="getOrganisations(this.value)" data-parsley-id="6715">
                      <option value="">Select State</option>
                      <option value="3">Andhra Pradesh</option>
                          <option value="4">Karnataka</option>
                          <option value="5">Others</option>
                          <option value="7">Puducherry</option>
                          <option value="2">Tamilnadu</option>
                          <option value="1">Telangana</option>
                    </select><ul class="parsley-errors-list" id="parsley-id-6715"></ul>
                    </div>
                  </div>
                  <div class="row form-group frm-btm">
                      <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                        <label class="input-text">Select Organisation <span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                        <select class="form-control" name="organisation_id" id="organisation_id" required="" onchange="getCenters(this.value)" data-parsley-id="2279">
                                 <option value="">Select Organisation</option> 
                                </select><ul class="parsley-errors-list" id="parsley-id-2279"></ul>
                      </div>  
                    </div>
                    <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Center<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <select class="form-control" name="center_id" id="center_id" required="" onchange="getCourses(this.value)" data-parsley-id="7577">
                                <option value="">Select Center</option>
                               
                              </select><ul class="parsley-errors-list" id="parsley-id-7577"></ul>
                    </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Courses<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                    <select class="form-control" name="course_id" id="course_id" required="" onchange="getbatchs(this.value)" data-parsley-id="1344">
                                <option value="">Select Course</option>
                                
                              </select><ul class="parsley-errors-list" id="parsley-id-1344"></ul>
                    </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Batch<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                    <select class="form-control" id="batch_id" name="batch_id" required="" onchange="getbatchdates(this.value)" data-parsley-id="5416">
                    <option value="">Please select</option>
                                        
                    </select><ul class="parsley-errors-list" id="parsley-id-5416"></ul>
                    </div>
                  </div>
                 <!--  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Student Image <span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="file-input" placeholder="" type="file" name="image" value="" id="image" onkeyup="" required="" data-parsley-id="0120"><ul class="parsley-errors-list" id="parsley-id-0120"></ul>
                    </div>
                  </div> -->

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Final Fees <span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="" type="text" name="student_paid_amt" value="" id="student_paid_amt" onkeyup="" required><ul class="parsley-errors-list" id="parsley-id-0120"></ul>
                    </div>
                  </div>

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Amount Payable <span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="" type="text" name="student_paid_amt" value="" id="student_paid_amt" onkeyup="" required><ul class="parsley-errors-list" id="parsley-id-0120"></ul>
                    </div>
                  </div>

                  

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label class="input-text">Materials </label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <select class="form-control" name="materials" id="materials" >
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                              </select>
                  </div>
                  </div>


                  <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                      <input type="submit" name="submit"  class="btn btm-sm btn-success btn-sm" value="Send Link" />
                      <a class="btn btn-danger btn-sm" type="edit" href="#">Back
                      </a>
                    </div>                
                  </div>
          </div>

          <div id="News" class="tabcontent">
            <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Student Name <span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="" type="text" name="student_name" value="" id="frist_name" onkeyup="" required>
                    </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Mobile Number <span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="Phone number" type="text" name="mobile_no" value="" id="mobile_number" required>
                    </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Gender<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      
                      <input type="radio" id="male" name="gender" checked value="Male">
                      <label for="male">Male</label><br>
                      <input type="radio" id="female" name="gender" value="Female">
                      <label for="female">Female</label><br>
                    </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Alternate Mobile Number </label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="Phone number" type="text" name="alt_mobile_no" value="" id="alt_mobile_no" onkeyup="">
                    </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Student Email Id  <span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="" type="text" name="email_id" value="" id="email_id" onkeyup="" required="">
                    </div>
                  </div>  
                 
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Address State</label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                    <select class="form-control" name="address_state" id="address_state" >
                                <option value="">Select State</option>
                                                                    <option value="3">Andhra Pradesh</option>
                                                                        <option value="4">Karnataka</option>
                                                                        <option value="5">Others</option>
                                                                        <option value="7">Puducherry</option>
                                                                        <option value="2">Tamilnadu</option>
                                                                        <option value="1">Telangana</option>
                                                                  </select>
                    </div>
                  </div>  

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Permanent Address</label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7  col-md-7 col-sm-7 col-xs-6">
                    <textarea class="form-control" type="text" rows="6" placeholder="Should not exceed 250 Characters..." name="permanent_address" id="permanent_address" value="" ></textarea>
                    </div>
                  </div>    
                  
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">College of MBBS State</label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                    <select class="form-control" name="mbbs_state" id="mbbs_state" onchange="getmmbscolleges(this.value)">
                                <option value="">Select State</option>
                                                                    <option value="3">Andhra Pradesh</option>
                                                                        <option value="4">Karnataka</option>
                                                                        <option value="5">Others</option>
                                                                        <option value="7">Puducherry</option>
                                                                        <option value="2">Tamilnadu</option>
                                                                        <option value="1">Telangana</option>
                                                                  </select>
                    </div>
                  </div>

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">College of MBBS</label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                    <select class="form-control" name="college_mbbs" id="college_mbbs" >
                                <option value="">Select College</option>
                               
                              </select>
                    </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">MBBS Batch</label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="" type="text" name="mbbs_batch" value="" id="mbbs_batch" onkeyup="" >
                    </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Internship College/Hospital</label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="" type="text" name="internship_college" value="" id="internship_college" onkeyup="" >
                    </div>
                  </div>
                  

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Join/Valid From<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                  <input class="form-control" name="valid_from" id="batch_start_date" value="" data-date-format="yyyy-mm-dd" required readonly="">
                    </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Valid To<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                  <input class="form-control" name="valid_to" id="batch_end_date" value="" data-date-format="yyyy-mm-dd" required  readonly="">
                    </div>
                  </div>    

                  

                  <div class="panel panel-default" style="margin-top:20px;">
          <div class="panel-body" style="max-height:600px; overflow-y:scroll; background-color:white;">
            <div style="text-align:center;">
              <h1>Terms and Conditions</h1>
              <p>
                This is where your terms and conditions content will go.
                Here is the factory code for the Terms and Conditions page for the Customer Hub. If you would like to use this code on your page, you can hit the red “Revert” button on your page. If you do not see the “Revert” button, that means your code is up to date.If you have customized your code and would like to compare it with the factory code below, we recommend using a text compare tool such as.....please go to this link 
                <a style="color:red" target="_blank" href="https://hyderabadbhatia.com/admin/agent_dashboard">link text</a>
              </p>
            </div>
          </div>
        </div>
        <div style="text-align:center;" ng-if="settings.Authentication.RequireTermsAndConditions && !UserInfo.approvedTermsAndConditions && UserInfo.isAuthenticated">
          <button style="margin:10px;" class="btn btn-primary" type="submit">Agree to Terms and Conditions</button>
        </div>

                   <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">By Entering OTP I Agree to T&C<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" name="valid_to" id="batch_end_date" value="" data-date-format="yyyy-mm-dd" required >
                    </div>
                  </div> 
                  
                  <div class="col-lg-12 col-xs-12 col-sm-12">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                  <input type="submit" name="submit"  class="btn btm-sm btn-success btn-sm" value="Next" />
                  <a class="btn btn-danger btn-sm" type="edit" href="#">Back
                  </a>
                </div>                
              </div>

                  </div>                  
                </div> 
          </div>

          <div id="Contact" class="tabcontent">
            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                    <form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="https://hyderabadbhatia.com/admin/student/add_payment_details/2634" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">
                  <div class="row form-group frm-btm">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                      <h2>Fees Details</h2><hr>
                    </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label class="input-text">Student Id<span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <span style="color:red">PCHS5620</span>
                      (<span style="color:green">Bichu</span>)
                      <input type="hidden" id="student_id" name="student_id" value="2634">
                      </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label class="input-text">Total Fees<span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                        <b>
                      <input class="form-control" placeholder="" type="text" name="total_fee" value="" id="total_fee" onkeyup="" required>
                        </b>
                      </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label class="input-text">Discount Fees<span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                        <em>
                      <input class="form-control" placeholder="" type="text" name="discount_fee" value="" id="discount_fee" onkeyup="" required>
                      </em>
                      </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label class="input-text">Discount Scheme</label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <input class="form-control" placeholder="" type="text" name="discount_scheme" value="" id="discount_scheme" onkeyup="" >
                      </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label class="input-text">Paid Amount<span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                          <p>
                      <input class="form-control" placeholder="" type="text" name="amount_paid" value="" id="amount_paid" onkeyup="" required>
                    </p>
                      </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label class="input-text">Amount Paid Date<span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      
                      <input class="form-control date-picker" placeholder="" type="text" name="amount_paid_date" value="" id="id-date-picker-1" onkeyup="" required data-date-format="yyyy-mm-dd">
                    
                      </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label class="input-text">Payment mode<span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                          
                      <select class="form-control" name="payment_mode" id="payment_mode" required="">
                                <option value="">Select</option>
                                                                    <option value="124">Anudeep Testing</option>
                                                                        <option value="123">Anudeep Testing</option>
                                                                        <option value="112">Axis Sai sir </option>
                                                                        <option value="114">Bandi Raja Sir </option>
                                                                        <option value="89">cash collected</option>
                                                                        <option value="116">Chitturu Neelakantam Account</option>
                                                                        <option value="122">Chitturu Rajeshwari Account</option>
                                                                        <option value="115">Chitturu Sireesha Maam Account</option>
                                                                        <option value="87">G pay 9956 suri sir</option>
                                                                        <option value="83">Gpay 9958 yesbank</option>
                                                                        <option value="81">icici 303 account</option>
                                                                        <option value="82">issm yes bank </option>
                                                                        <option value="88">P pay 9956 suri sir</option>
                                                                        <option value="84">P pay 9958 yesbank</option>
                                                                        <option value="48">Sikanth-Test-Phone-Pay</option>
                                                                        <option value="113">Suri Sir IDFC</option>
                                                                        <option value="47">TEST-Srinivas-Gpay</option>
                                                                        <option value="107">testing naveen</option>
                                                                  </select>
                    
                      </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label class="input-text">Transaction Id<span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                          
                      <input class="form-control" placeholder="" type="text" name="transaction_id" value="" id="transaction_id" onkeyup="" required>
                    
                      </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label class="input-text">Due amount</label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <input class="form-control" placeholder="" type="text" name="due_amount" value="" id="due_amount" onkeyup="" readonly="">
                      </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label class="input-text">Due date</label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <input class="form-control date-picker" placeholder="" type="text" name="due_date" value="" id="id-date-picker-1" onkeyup="" data-date-format="dd-mm-yyyy">
                      </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                      <label class="input-text">Remarks</label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7  col-md-7 col-sm-7 col-xs-12">
                    <textarea class="form-control" type="text" rows="6" placeholder="Should not exceed 250 Characters..." name="remarks" id="remarks" value=""></textarea>
                    </div>
                  </div>  

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label class="input-text">Send SMS</label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      
                              <input  type="radio" name="send_sms" value="no" checked="checked" />NO
                      <input  type="radio" name="send_sms" value="yes" />YES
                  </div>
                  </div>                
                  </div>                  
                </div>
                
                <div class="col-lg-12 col-xs-12 col-sm-12">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                  <input type="submit" name="submit"  class="btn btm-sm btn-success btn-sm" value="Send for Approval" />
                  <a class="btn btn-danger btn-sm" type="edit" href="https://hyderabadbhatia.com/admin/student">Back
                  </a>
                </div>                
              </div><!-- End Row -->
              </form>
          </div>

            </div>
            
        </div>
      </div><!-- /.main-content -->
      
  <script>
function openPage(pageName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "green";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>