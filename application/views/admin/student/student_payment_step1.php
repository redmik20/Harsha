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
								<a href="<?php echo site_url();?>admin/student">Admission Link</a>
							</li>
							<li class="active"> Student Admission Link Step 1</li>
						</ul><!-- /.breadcrumb -->						
					</div>

					<div class="page-content">
						<div class="page-header-2">
							<h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
								<i class="menu-icon fa fa-list-ul blue"></i>Student
								<span class="label label-purple arrowed">Student Admission Link Step 1<span>
							</h1>
							<div class="pull-right ">							 
								 <input type="hidden" name="hiv" id="hiv" value="0" />
                           </div>
                           						</div><!-- /.page-header -->
						
						 <?php echo $message; ?>
								   
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
										<form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/student/admission_link_step2" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">

									 <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Select State<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <select class="form-control" name="state_id" id="state_id" required="" onchange="getOrganisations(this.value)">
							                  <option value="">Select State</option>
							                  <?php
							                  if(!empty($states))
							                  {
							                    foreach($states as $state)
							                    {
							                      ?>
							                      <option value="<?=$state['id'];?>"><?=$state['state'];?></option>
							                      <?php
							                    }
							                  }
							                  ?>
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
                      <input class="form-control" placeholder="" type="text" name="final_fee" value="" id="final_fee" onkeyup="" required><ul class="parsley-errors-list" id="parsley-id-0120"></ul>
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
                      <select class="form-control" name="material_status" id="material_status" >
                                <option value="yes" selected>Yes</option>
                              </select>
                  </div>
                  </div>

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Student Mobile <span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="" type="text" maxlength="10" pattern="([0-9]|[0-9]|[0-9])" name="student_mobile" value="" id="student_mobile"  required><ul class="parsley-errors-list" id="myField"></ul>
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
								</div>
								
																	
							</div><!-- End Row -->
							</form>
							</div>
							</div>
						</div>
						
				</div>
			</div><!-- /.main-content -->
			
<script type="text/javascript">

  $("#student_mobile").keyup(function() {
    $("#student_mobile").val(this.value.match(/[0-9]*/));
      
});
	
	function getotp(value){
		//alert(value);
		if(value == 'app'){
			$('#otp').val('');
			$("#otp_div").show();
			var mobile= $('#mobile_number').val();
			//alert(mobile);
			if(mobile == ''){
				alert("Please Enter Mobile number");
				return false;
			}
			 $.ajax({
			      type: 'post',
			      url: '<?=base_url();?>admin/student/sendOTP',
			      data: {mobile: mobile},
			      beforeSend: function(xhr){
			        xhr.overrideMimeType("text/plain; charset=utf-8");
			        $("#wait").css("display", "block");
			      },
			      success: function(data){ 
			      	//var json = $.parseJSON(data); 
			      	alert("OTP Send Successfully");
			      }
			    });

		}else if(value == 'admin'){
			$("#otp_div").hide();
			$('#otp').val('111111');
		}
	}
</script>