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
								<a href="<?php echo site_url();?>admin/student">Bulk Upload Student</a>
							</li>
							<li class="active"> Bulk Upload</li>
						</ul><!-- /.breadcrumb -->						
					</div>

					<div class="page-content">
						<div class="page-header-2">
							<h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
								<i class="menu-icon fa fa-list-ul blue"></i>Student
								<span class="label label-purple arrowed">Bulk Upload<span>
							</h1>
							<div class="pull-right ">							 
								 <input type="hidden" name="hiv" id="hiv" value="0" />
                           </div>
                           <div class="pull-right ">
							
							<a class="btn btn-success btn-sm" href="<?php echo site_url();?>admin/student_upload/filedownload" type="button"><i class="fa fa-arrow fa-lg"></i> Download excel format </a>
							
							</div>
						</div><!-- /.page-header -->
						
						 <?php echo $message; ?>
								   
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
										<form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/student_upload/import_bulkexcel" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">

									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
											<label class="input-text">Select State<span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
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
							                </select>
										</div>
									</div>

									
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
												<label class="input-text">Select Organisation <span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
												<select class="form-control" name="organisation_id" id="organisation_id" required="" onchange="getCenters(this.value)">
								                 <option value="">Select Organisation</option> 
								                </select>
											</div>	
										</div>				
								

									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
											<label class="input-text">Center<span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
											<select class="form-control" name="center_id" id="center_id" required="" onchange="getCourses(this.value)">
							                  <option value="">Select Center</option>
							                 
							                </select>
										</div>
									</div>

									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
											<label class="input-text">Courses<span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
										<select class="form-control" name="course_id" id="course_id" required="" onchange="getbatchs(this.value)">
							                  <option value="">Select Course</option>
							                 
							                </select>
										</div>
									</div>

									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
											<label class="input-text">Batch<span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
										<select class="form-control" id="batch_id" name="batch_id"  required onchange="getbatchdates(this.value)">
										<option value="" >Please select</option>
                                        
										</select>
										</div>
									</div>

									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
											<label class="input-text">Choose File <span class="red bigger-120">*</span></label>
										</div>
										<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="file-input" placeholder="" type="file" name="file" value="" id="file" onkeyup="" required="">
										</div>
									</div>
									
									
									

									</div> 									
								</div>
								
									<div class="col-lg-12 col-xs-12 col-sm-12">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
									
									<input type="submit" name="submit"  class="btn btm-sm btn-success btn-sm" value="submit" /> 
									 <a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url();?>admin/student">Back
									</a>
								</div>								
							</div><!-- End Row -->
							</form>
							</div>
							</div>
						</div>
						
				</div>
			</div><!-- /.main-content -->
			
<script type="text/javascript">
	
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