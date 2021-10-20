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
								<a href="<?php echo site_url();?>admin/student">Students</a>
							</li>
							<li class="active"> Update</li>
						</ul><!-- /.breadcrumb -->						
					</div>

					<div class="page-content">
						<div class="page-header-2">
							<h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
								<i class="menu-icon fa fa-list-ul blue"></i>Student
								<span class="label label-purple arrowed">Update<span>
							</h1>
							<div class="pull-right ">							 
								 <input type="hidden" name="hiv" id="hiv" value="0" />
                           </div>
						</div><!-- /.page-header -->
						
						 <?php echo $message; ?>
								   
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
										<form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/student/edit/<?php echo $record['id']?>" enctype="multipart/form-data">
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
							                      <option value="<?=$state['id'];?>" <?php if($state['id'] == $record['state_id']){?> selected  <?php }?>><?=$state['state'];?></option>
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
							                      <option value="<?=$org['id'];?>"  <?php if($org['id'] == $record['organisation_id']){?> selected  <?php }?> ><?=$org['organisation_name'];?></option>
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
										<div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 word-brk">
											<select class="form-control" name="center_id" id="center_id" required="" onchange="getCourses(this.value)">
							                  <option value="">Select Center</option>
							                  <?php
							                  if(!empty($centers))
							                  {
							                    foreach($centers as $center)
							                    {
							                      ?>
							                      <option value="<?=$center['id'];?>"  <?php if($center['id'] == $record['center_id']){?> selected  <?php }?> ><?=$center['center'];?></option>
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
										<div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 word-brk">
										<select class="form-control" name="course_id" id="course_id" required="" onchange="getbatchs(this.value)">
							                  <option value="">Select Course</option>
							                  <?php
							                  if(!empty($courses))
							                  {
							                    foreach($courses as $course)
							                    {
							                      ?>
							                      <option value="<?=$course['id'];?>" <?php if($course['id'] == $record['course_id']){?> selected  <?php }?>><?=$course['course_name'];?></option>
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
										<div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 word-brk">
										<select class="form-control" id="batch_id" name="batch_id"  required>
										<option value="" >Please select</option>
                                        <?php
							                  if(!empty($batchs))
							                  {
							                    foreach($batchs as $batch)
							                    {
							                      ?>
							                      <option value="<?=$batch['id'];?>" <?php if($batch['id'] == $record['batch_id']){?> selected  <?php }?>><?=$batch['batch_name'];?></option>
							                      <?php
							                    }
							                  }
							                  ?>
										</select>
										</div>

										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 word-brk">
										<h5 style="margin-top: 23px;">Student Image</h5>
											<?php if($record['image'] != ''){?>
						                  <img src="<?=base_url().$record['image'];?>" height="50" width="50"/>
						                <?php }else{?>
						                  <img src="<?=base_url('storage/no_image.jpg');?>" height="30" width="30" />
						                <?php }?>
						                <br>
						                <div style="margin-top: 11px;">
						                <input class="file-input" placeholder="" type="file" name="image" value="" id="image" onkeyup="">
										</div>
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
											<label class="input-text">Admission No <span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<span style="color:green"><?php echo $record['admission_no']?></span>
										</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Student ID <span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<span style="color:green"><?php echo $record['student_dynamic_id']?></span>
										</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Student Name <span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="" type="text" name="student_name" value="<?php echo $record['student_name']?>" id="frist_name" onkeyup="" required>
										</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Mobile Number <span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="Phone number" type="text" name="mobile_no" value="<?php echo $record['student_mobile']?>" id="mobile_no" onkeyup="" required>
										</div>
									</div>
									<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Room No</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
												<input class="form-control" placeholder="" type="text" name="room_no" value="<?php echo $record['room_no']?>" id="room_no" onkeyup="" >
											</div>
										</div>
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Cabin No</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
												<input class="form-control" placeholder="" type="text" name="cabin_no" value="<?php echo $record['cabin_no']?>" id="cabin_no" onkeyup="" >
											</div>
										</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Gender<span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											
											<input type="radio" id="male" name="gender" <?php if($record['gender'] == 'Male' ){ ?> checked <?php } ?> value="Male">
											<label for="male">Male</label><br>
											<input type="radio" id="female" name="gender" <?php if($record['gender'] == 'Female' ){ ?> checked <?php } ?> value="Female">
											<label for="female">Female</label><br>
										</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Alternate Mobile Number </label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="Phone number" type="text" name="alt_mobile_no" value="<?php echo $record['student_alt_mobile']?>" id="alt_mobile_no" onkeyup="">
										</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Student Email Id  </label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="" type="text" name="email_id" value="<?php echo $record['student_email']?>" id="email_id" onkeyup="" >
										</div>
									</div>	
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Father's/Husband Name </label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="" type="text" name="father_name" value="<?php echo $record['father_name']?>" id="father_name" onkeyup="">
										</div>
									</div>	
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Occupation(Guardian)</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="" type="text" name="occupation" value="<?php echo $record['occupation']?>" id="occupation" onkeyup="" >
										</div>
									</div>	
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Contact No.(Residence)</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="Phone number" type="text" name="res_contact_no" value="<?php echo $record['res_contact_no']?>" id="res_contact_no" onkeyup="" >
										</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Contact Number(Guardian)</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="Phone number" type="text" name="guardian_contact_no" value="<?php echo $record['guardian_contact_no']?>" id="guardian_contact_no" onkeyup="">
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
							                      <option value="<?=$state['id'];?>"  <?php if($state['id'] == $record['state']){?> selected  <?php }?> ><?=$state['state'];?></option>
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
										<textarea class="form-control" type="text" rows="6" placeholder="Should not exceed 250 Characters..." name="permanent_address" id="permanent_address" value="" ><?php echo $record['permanent_address']?></textarea>
										</div>
									</div>	
										
									<!-- <div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
											<label class="input-text">Pin Code</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
										<input class="form-control" placeholder="" type="text" name="pincode" value="<?php echo $record['pincode']?>" id="pincode" onkeyup="">
										</div>
									</div>	 -->		
									
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">College of MBBS State <span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
										<select class="form-control" name="mbbs_state" id="mbbs_state"  onchange="getmmbscolleges(this.value)" required="">
							                  <option value="">Select State</option>
							                  <?php
							                  if(!empty($states))
							                  {
							                    foreach($states as $state)
							                    {
							                      ?>
							                      <option value="<?=$state['id'];?>"  <?php if($state['id'] == $record['mbbs_state']){?> selected  <?php }?> ><?=$state['state'];?></option>
							                      <?php
							                    }
							                  }
							                  ?>
							                </select>
										</div>
									</div>

									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">College of MBBS <span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											
											<select class="form-control" name="college_mbbs" id="college_mbbs" required="">
							                  <option value="">Select College</option>
							                  <?php
							                  if(!empty($colleges))
							                  {
							                    foreach($colleges as $college)
							                    {
							                      ?>
							                      <option value="<?=$college['id'];?>"  <?php if($college['id'] == $record['college_mbbs']){?> selected  <?php }?> ><?=$college['college_name'];?></option>
							                      <?php
							                    }
							                  }
							                  ?>
							                </select>
										</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">MBBS Batch</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="" type="text" name="mbbs_batch" value="<?php echo $record['mbbs_batch']?>" id="mbbs_batch" onkeyup="" >
										</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Internship College/Hospital</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="" type="text" name="internship_college" value="<?php echo $record['internship_college']?>" id="internship_college" onkeyup="" >
										</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Internship Start Date</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
									<input class="form-control date-picker" name="internship_join_date" id="id-date-picker-1" value="<?php echo $record['internship_join_date']?>" data-date-format="yyyy-mm-dd" >
										</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Presently Working</label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
									<input class="form-control" placeholder="" type="text" name="presently_working" value="<?php echo $record['presently_working']?>" id="presently_working" onkeyup="" >
										</div>
									</div>

									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Join/Valid From<span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
									<input class="form-control date-picker" name="valid_from" id="id-date-picker-1" value="<?php echo $record['valid_from']?>" data-date-format="yyyy-mm-dd" required>
										</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Valid To<span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
									<input class="form-control date-picker" name="valid_to" id="id-date-picker-1" value="<?php echo $record['valid_to']?>" data-date-format="yyyy-mm-dd" required>
										</div>
									</div>									
									</div> 									
								</div>

								<input type="hidden" name="student_id"  class="btn btm-sm btn-success btn-sm" value="<?php echo $record['id']?>" />
								
									<div class="col-lg-12 col-xs-12 col-sm-12">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
									
									<input type="submit" name="submit"  class="btn btm-sm btn-success btn-sm" value="Update" /> 
									 <a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url();?>admin/student/states">Back
									</a>
								</div>								
							</div><!-- End Row -->
							</form>
							</div>
							</div>
						</div>
						
				</div>
			</div><!-- /.main-content -->
			
