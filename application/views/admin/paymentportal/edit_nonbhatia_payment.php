
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
								<a href="<?php echo site_url();?>admin/nonbhatia_payments">General payments</a>
							</li>
							<li class="active"> Edit</li>
						</ul><!-- /.breadcrumb -->						
					</div>

					<div class="page-content">
						<div class="page-header-2">
							<h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
								<i class="menu-icon fa fa-list-ul blue"></i>General payments
								<span class="label label-purple arrowed">Edit<span>
							</h1>
							<div class="pull-right ">							 
								 <input type="hidden" name="hiv" id="hiv" value="0" />
                           </div>
						</div><!-- /.page-header -->
						
						 <?php echo $message; ?>
								   
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
										<form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/nonbhatia_payments/update_record" enctype="multipart/form-data">
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
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<select class="form-control" name="center_id" id="center_id" required="" onchange="getCourses1(this.value)">
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
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
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
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
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
										</div>
									 <div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Entered date<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
					<!-- <b><input class="form-control" placeholder="" type="text" name="date" readonly 
						value="<?php echo date("d-m-Y", strtotime($record['amount_paid_date']));?>" ></b> -->
						<input class="form-control date-picker" name="date" id="id-date-picker-1" value="<?php echo $record['amount_paid_date'];?>" data-date-format="yyyy-mm-dd" >
				 </div>
				</div>
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Name <span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
												<input class="form-control" placeholder="" type="text" name="student_name" value="<?php echo $record['student_name']?>" id="student_name" onkeyup="" required>
											</div>
										</div>	
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Mobile Number<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
												<input class="form-control" placeholder="" type="text" name="mobile_number" value="<?php echo $record['mobile_number']?>" id="mobile_number" onkeyup="" required>
											</div>
										</div>

										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Room No</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
												<input class="form-control" placeholder="" type="text" name="room_no" value="<?php echo $student_data['room_no']?>" id="room_no" onkeyup="" required>
											</div>
										</div>
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Cabin No</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
												<input class="form-control" placeholder="" type="text" name="cabin_no" value="<?php echo $student_data['cabin_no']?>" id="cabin_no" onkeyup="" required>
											</div>
										</div>
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">State Name</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<select class="form-control" name="college_state_id" id="college_state_id" onchange="getmmbscolleges(this.value)"> 
							                  <option value="">Select State</option>
							                  <?php
							                  if(!empty($states))
							                  {
							                    foreach($states as $state)
							                    {
							                      ?>
							                      <option value="<?=$state['id'];?>" <?php if($state['id'] == $record['college_state_id']){ echo 'selected'; } ?> ><?=$state['state'];?></option>
							                      <?php
							                    }
							                  }
							                  ?>
							                </select>
											</div>
										</div>
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Name of the College</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
												<select class="form-control" name="college_id" id="college_mbbs" >
							                  <option value="">Select College</option>
							                  <?php
							                  if(!empty($colleges))
							                  {
							                    foreach($colleges as $college)
							                    {
							                      ?>
							                      <option value="<?=$college['id'];?>"  <?php if($college['id'] == $record['college_id']){ echo 'selected'; } ?> ><?=$college['college_name'];?></option>
							                      <?php
							                    }
							                  }
							                  ?>
							                </select>

											</div>
										</div>									
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Payment Made for<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
												<input class="form-control" placeholder="" type="text" name="payment_for" value="<?php echo $record['payment_for']?>" id="payment_for" onkeyup="" required>
											</div>
										</div>										
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Payment Amount<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="" type="text" name="amount_paid" value="<?php echo $record['amount_paid']?>" id="amount_paid" onkeyup="" required>
											</div>
										</div>
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Payment Mode<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<!-- <input class="form-control" placeholder="" type="text" name="payment_mode" value="" id="payment_mode" onkeyup="" required> -->

											<select class="form-control" name="payment_mode_id" id="payment_mode_id" required="">
							                  <option value="">Select Payment Mode</option>
							                  <?php
							                  if(!empty($payments))
							                  {
							                    foreach($payments as $payment)
							                    {
							                      ?>
							                      <option value="<?=$payment['id'];?>" <?php if($payment['id'] == $record['payment_mode_id']){ echo 'selected'; } ?>><?=$payment['payment_mode'];?></option>
							                      <?php
							                    }
							                  }
							                  ?>
							                </select>

											</div>
										</div>

										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">GRID</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="" type="text" name="grid" value="<?php echo $record['grid']?>" id="grid" onkeyup="" >
											</div>
										</div>

										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Transcation Id<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="" type="text" name="transcation_id" value="<?php echo $record['transaction_id']?>" id="transcation_id" onkeyup="" required>
											</div>
										</div>
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Remarks</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<textarea id="w3review" name="remarks" id="remarks" style="height: 100px;width: 100%;"><?php echo $record['remarks']?></textarea>
											</div>
										</div>	

										<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Print Preview</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											
							        <input  type="radio" name="print_preview" value="no" checked="checked" />NO
											<input  type="radio" name="print_preview" value="yes" />YES
									</div>
									</div>

									</div> 									
								</div>
								<input class="form-control" placeholder="" type="hidden" name="id" value="<?php echo $record['id']?>" id="rid" onkeyup="" required>

								<div class="col-lg-12 col-xs-12 col-sm-12">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
									<input type="submit" name="edit"  class="btn btm-sm btn-success btn-sm" value="Update" /> 
									<a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url()?>admin/nonbhatia_payments">Cancel
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

		function getCourses1(center_id){

	getPaymentModes(center_id);

 	var state_id=$("#state_id").val();
	var organisation_id=$("#organisation_id").val();
	var center_id=$("#center_id").val();

 	 $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/common/get_courses',
      data: {state_id: state_id,organisation_id:organisation_id,center_id:center_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ 
      	$("#course_id").html(data);
        $("#wait").css("display", "none");
      }
    });

 }

function getPaymentModes(center_id){

	var state_id=$("#state_id").val();
    var organisation_id=$("#organisation_id").val();
   	var center_id=$("#center_id").val();

    $.ajax({
			      type: 'post',
			      url: '<?=base_url();?>admin/common/getPaymentModes',
			      data: {state_id: state_id,organisation_id:organisation_id,center_id:center_id},
			      beforeSend: function(xhr){
			        xhr.overrideMimeType("text/plain; charset=utf-8");
			        $("#wait").css("display", "block");
			      },
			      success: function(data){ 
			      	//var json = $.parseJSON(data); 
			      	//alert("OTP Send Successfully");
			      	$("#payment_mode_id").html(data);
			      }
			    });
  }

	</script>