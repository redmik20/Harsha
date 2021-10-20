
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
							<li class="active"> Add</li>
						</ul><!-- /.breadcrumb -->						
					</div>

					<div class="page-content">
						<div class="page-header-2">
							<h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
								<i class="menu-icon fa fa-list-ul blue"></i>General payments
								<span class="label label-purple arrowed">Add<span>
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
                      <select class="form-control" name="center_id" id="center_id" required="" onchange="getCourses1(this.value)">
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
										<select class="form-control" id="batch_id" name="batch_id"  required onchange="getbatchdates1(this.value)">
										<option value="" >Please select</option>


                                        
										</select>
										</div>
				    </div>

				    	

				    <div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Mobile Number<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
												<input class="form-control" placeholder="" type="text" name="mobile_number" value="" maxlength="10" pattern="([0-9]|[0-9]|[0-9])" id="mobile_number" onkeyup="" required>
											</div>
										</div>
					<div class="row form-group frm-btm" id="total_fee_div" style="display:none">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Total Fee<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<b><input class="form-control" placeholder="" type="text" name="total_fee" value="" id="total_fee" disabled="" onkeyup="" required></b>
											</div>
					</div>

										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Payable Amount<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<b><input class="form-control" placeholder="" type="text" name="amount_paid" value="" id="paying_amount" onkeyup="" required></b>
											</div>
					</div>

                  <div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Entered date<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
					<!-- <b><input class="form-control" placeholder="" type="text" name="date" readonly value="<?php echo date('d-m-Y');?>" ></b> -->
					<input class="form-control date-picker" name="date" id="id-date-picker-1" value="<?php echo  date('d-m-Y');?>" data-date-format="yyyy-mm-dd" >

				 </div>
				</div>

										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Name <span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
												<input class="form-control" placeholder="" type="text" name="student_name" value="" id="student_name" onkeyup="" required>
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
												<label class="input-text">Name of the College</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
												<select class="form-control" name="college_id" id="college_mbbs">
							                  <option value="">Select College</option>
							                  <?php
							                  /*if(!empty($colleges))
							                  {
							                    foreach($colleges as $college)
							                    {
							                      ?>
							                      <option value="<?=$college['id'];?>"><?=$college['college_name'];?></option>
							                      <?php
							                    }
							                  }*/
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
												<input class="form-control" placeholder="" type="text" name="payment_for" value="" id="payment_for" onkeyup="" required>
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
							                  /*if(!empty($payments))
							                  {
							                    foreach($payments as $payment)
							                    {
							                      ?>
							                      <option value="<?=$payment['id'];?>"><?=$payment['payment_mode'];?></option>
							                      <?php
							                    }
							                  }*/
							                  ?>

							                  <?php
                                if(!empty($payment_modes))
                                {
                                  foreach($payment_modes as $pm)
                                  {
                                    ?>
                                    <option value="<?=$pm['id'];?>" ><?=$pm['payment_mode'];?></option>
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
											<input class="form-control" placeholder="" type="text" name="grid" value="" id="grid" onkeyup="" >
											</div>
										</div>

										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Transcation Id<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<input class="form-control" placeholder="" type="text" name="transcation_id" value="" id="transcation_id" onkeyup="" required>
											</div>
										</div>
										<div class="row form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Remarks</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											<textarea id="w3review" name="remarks" id="remarks" style="height: 100px;width: 100%;"></textarea>
											</div>
										</div>
										<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
												<label class="input-text">Send SMS</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
											
							                <input  type="radio" name="send_sms" value="no" checked="checked" />NO
											<input  type="radio" name="send_sms" value="yes" />YES
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

								<input  type="hidden" name="param" value="<?php echo $param; ?>" >

								<div class="col-lg-12 col-xs-12 col-sm-12">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
									<input type="submit" name="add"  class="btn btm-sm btn-success btn-sm" value="Submit" />
									<?php $user_id=$this->session->userdata('user_id');
									if($param == 'general_students'){?>
									<a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url()?>admin/nonbhatia_payments">Cancel
									</a>
								<?php }else{ ?>
									<a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url()?>admin/agent_dashboard">Cancel
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

    		var mobile_number=$('#mobile_number').val();
    		
    		var batch_id=$('#batch_id').val();

	    		if(mobile_number.length == 10){

	    			if(batch_id != ''){
	    				checkpayment(mobile_number,batch_id);
		    			
	    			}else{
	    				alert('please select batch');
	    			}
	    		}
      
			});


		function checkpayment(mobile_number,batch_id){

			$.ajax({
					      type: 'post',
					      url: '<?=base_url();?>admin/nonbhatia_payments/check_student_payment',
					      data: {mobile_number: mobile_number,batch_id:batch_id},
					      beforeSend: function(xhr){
					        xhr.overrideMimeType("text/plain; charset=utf-8");
					        //$("#wait").css("display", "block");
					      },
					      success: function(data){ 
					      	if(data != 0){
					      	var response=JSON.parse(data);
					      	//alert(response.paying_amount);
					      	$("#paying_amount").val(response.paying_amount);
					      	$("#student_name").val(response.student_name);
					      	$("#total_fee").val(response.total_fee);
					      	$("#total_fee_div").show();
					        //$("#wait").css("display", "none");
					    	}else{
					    		$("#paying_amount").val(0);
					      		$("#student_name").val('');
					      		$("#total_fee").val(0);
					      		$("#total_fee_div").hide();
					    	}
					      }
					    });
		}

function getbatchdates1(batch_id){

 	 $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/student/getbatchsdates',
      data: {batch_id: batch_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ 
      	var json = JSON.parse(data); 
      	//alert(json.valid_from);
      	 //$('#namaBarang').val(response);
        $("#batch_start_date").val(json.valid_from);
        $("#batch_end_date").val(json.valid_to);
        //$("#wait").css("display", "none");
      }
    });

 	 var mobile_number=$('#mobile_number').val();
 	 if(mobile_number != ''){
 	 checkpayment(mobile_number,batch_id);
 		}

 }

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