<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<?php if($this->session->userdata('user_type') == 'employee'){ ?>
		            <a href="<?php echo site_url();?>admin/agent_dashboard">Home</a>
		            <?php } else { ?>
		            <a href="<?php echo site_url();?>admin/dashboard">Home</a>
		            <?php } ?>
							</li>
							<li>								 
								<a href="<?php echo site_url();?>admin/student">Enroll Student</a>
							</li>
							<li class="active"> Enroll</li>
						</ul><!-- /.breadcrumb -->						
					</div>

					<div class="page-content">
						<div class="page-header-2">
							<h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
								<i class="menu-icon fa fa-list-ul blue"></i>Student
								<span class="label label-purple arrowed">Enroll<span>
							</h1>
							<div class="pull-right ">							 
								 <input type="hidden" name="hiv" id="hiv" value="0" />
                           </div>
						</div><!-- /.page-header -->
						
						 <?php echo $message; ?>
								   
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
						<form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/student/add" enctype="multipart/form-data">
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
                                    <option value="<?=$state['id'];?>"

                                    	<?php if(!empty($employee)){ 
                                        if($employee['state_id'] == $state['id']){ ?> 
                                        selected 
                                      <?php } } ?>

                                    	><?=$state['state'];?></option>
                                    <?php
                                  }
                                }
                                ?>
							                </select>
										</div>
									</div>

									
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Select Organisation <span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
												<select class="form-control" name="organisation_id" id="organisation_id" required="" onchange="getCenters(this.value)">
								                 <option value="">Select Organisation</option> 
								                  <?php
                                if(!empty($organisations))
                                {
                                  foreach($organisations as $org)
                                  {
                                    ?>
                                    <option value="<?=$org['id'];?>" 
                                      <?php if(!empty($employee)){ 
                                        if($employee['organisation_id'] == $org['id']){?> 
                                        selected 
                                      <?php } } ?> ><?=$org['organisation_name'];?></option>
                                    <?php
                                  }
                                }
                                ?>
								                </select>
											</div>	
										</div>				
								

									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Center<span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<select class="form-control" name="center_id" id="center_id" required="" onchange="getCourses(this.value)">
							                  <option value="">Select Center</option>
							                   <?php
                                if(!empty($centers))
                                {
                                  foreach($centers as $center)
                                  {
                                    ?>
                                    <option value="<?=$center['id'];?>" 
                                      <?php if(!empty($employee)){ 
                                        if($employee['center_id'] == $center['id']){?> 
                                        selected 
                                      <?php } } ?> ><?=$center['center'];?></option>
                                    <?php
                                  }
                                }
                                ?>
							                </select>
										</div>
									</div>

									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Courses<span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
										<select class="form-control" name="course_id" id="course_id" required="" onchange="getbatchs(this.value)">
							                  <option value="">Select Course</option>
							                  <?php
                                if(!empty($courses))
                                {
                                  foreach($courses as $course)
                                  {
                                    ?>
                                    <option value="<?=$course['id'];?>" ><?=$course['course_name'];?></option>
                                    <?php
                                  }
                                }
                                ?>
							                </select>
										</div>
									</div>

									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Batch<span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
										<select class="form-control" id="batch_id" name="batch_id"  required onchange="getbatchdates(this.value)">
										<option value="" >Please select</option>
                                        
										</select>
										</div>
									</div>

									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Student Image <span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="file-input" placeholder="" type="file" name="image" value="" id="image" onkeyup="" required="">
										</div>
									</div>
									
									<br>
									<div class="row form-group frm-btm">
										<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
											<h2>Student Information</h2><hr>
										</div>
									</div>
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
											<input class="form-control" placeholder="Phone number" type="text" name="mobile_no" maxlength="10" pattern="([0-9]|[0-9]|[0-9])" value="" id="mobile_number" required>
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
												<label class="input-text">Room No</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
												<input class="form-control" placeholder="" type="text" name="room_no" value="" id="room_no" onkeyup="" >
											</div>
										</div>
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Cabin No</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="" type="text" name="cabin_no" value="" id="cabin_no" onkeyup="" >
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
											<label class="input-text">Father's/Husband Name </label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="" type="text" name="father_name" value="" id="father_name" onkeyup="">
										</div>
									</div>	
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Occupation(Guardian)</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="" type="text" name="occupation" value="" id="occupation" onkeyup="" >
										</div>
									</div>	
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Contact No.(Residence)</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="Phone number" type="text" name="res_contact_no" value="" id="res_contact_no" onkeyup="" >
										</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Contact Number(Guardian)</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="Phone number" type="text" name="guardian_contact_no" value="" id="guardian_contact_no" onkeyup="">
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
									
									<!-- <div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
											<label class="input-text">Pin Code</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
										<input class="form-control" placeholder="" type="text" name="pincode" value="" id="pincode" onkeyup="">
										</div>
									</div>	 -->		
									
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">College of MBBS State <span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
										<select class="form-control" name="mbbs_state" id="mbbs_state" onchange="getmmbscolleges(this.value)" required="">
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
							                </select>
										</div>
									</div>

									<!-- <div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
											<label class="input-text">College of MBBS</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
											<input class="form-control" placeholder="" type="text" name="college_mbbs" value="" id="college_mbbs" onkeyup="" >
										</div>
									</div> -->
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">College of MBBS <span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
										<select class="form-control" name="college_mbbs" id="college_mbbs" required="">
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
											<label class="input-text">Internship Start Date</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
									<input class="form-control date-picker" name="internship_join_date" id="id-date-picker-1" value="" data-date-format="yyyy-mm-dd" >
										</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Presently Working</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
									<input class="form-control" placeholder="" type="text" name="presently_working" value="" id="presently_working" onkeyup="" >
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

									 <div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Adding From <span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<select class="form-control" name="adding_from" id="adding_from" required="" onchange="getotp(this.value)">
							                  <option value="">Select</option>

							                  <option value="admin" selected >Admin</option>
							                  
							                  <!-- <option value="app">App</option> -->
							              	 
							                  <!-- <?php if($this->session->userdata('user_id') == 'ADM0001'){?>
							                  <option value="admin">Admin</option>
							                  <?php }?>
							                  <?php if($this->session->userdata('user_id') != 'ADM0001'){?>
							                  <option value="app">App</option>
							              	  <?php }?> -->
							                  
							                </select>
										</div>
									</div> 

									<!-- <div class="row form-group frm-btm" id="otp_div" style="display: none">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Enter OTP<span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
									   <input class="form-control" name="otp" id="otp" value="" required >
										</div>
									</div>	 -->
									


									</div> 									
								</div>
								
									<div class="col-lg-12 col-xs-12 col-sm-12">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
									
									<input type="submit" name="submit"  class="btn btm-sm btn-success btn-sm" value="Continue" /> 
									<?php $user_id=$this->session->userdata('user_id');
									if($user_id == 'ADM0001'){?>
									 <a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url();?>admin/dashboard">Back
									</a>
									<?php }else{ ?>
									 <a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url();?>admin/agent_dashboard">Back
									</a>
								<?php }?>
								</div>								
							</div><!-- End Row -->
							</form>
							</div>
							</div>
						</div>
						
				</div>
			</div><!-- /.main-content -->
			
<script type="text/javascript">
	$("#mobile_number").keyup(function() {
    $("#mobile_number").val(this.value.match(/[0-9]*/));
      
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