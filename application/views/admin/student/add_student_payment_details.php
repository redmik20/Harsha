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
						
						 <?php echo $message;?>
								   
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
										<form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/student/add_payment_details/<?php echo $record['id'];?>" enctype="multipart/form-data">
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
											<span style="color:red"><?php echo $record['student_dynamic_id'];?></span>
											(<span style="color:green"><?php echo $record['student_name'];?></span>)
											<input type="hidden" id="student_id" name="student_id" value="<?php echo $record['id']?>">
											</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
												<label class="input-text">Total Fees<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
												<b>
											<input class="form-control" placeholder="" type="text" name="total_fee"  id="total_fee" onkeyup="" required <?php if($student_payment_total_fee != '') {?> readonly value="<?php echo $student_payment_total_fee;?>" <?php }else{?> value="" <?php } ?> >
												</b>
											</div>
									</div>

									<!--<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
												<label class="input-text">Till Now Paid Fees<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
												<b style="color:green">
											<?php echo $till_now_paid_amt['total_amt'];?>
												</b>
											</div>
									</div>-->
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
												<label class="input-text">Discount Fees<span class="red bigger-120"></span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
												<em>

											
											<input class="form-control" placeholder="" type="text" name="discount_fee"  id="discount_fee" onkeyup=""  <?php if($student_payment_discount_fee != '') {?> readonly value="<?php echo $student_payment_discount_fee;?>" <?php }else{?> value="" <?php } ?> >
											

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
												<label class="input-text">Paying Amount<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
										<p>
											<input class="form-control" placeholder="" type="text" name="amount_paid" value="<?php echo $paying_fee;?>" id="amount_paid" onkeyup="" required>
										</p>
											</div>
									</div>
									<div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
												<label class="input-text">Amount Paid Date<span class="red bigger-120">*</span></label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
											
											<input class="form-control date-picker" placeholder="" type="text" name="amount_paid_date" value="<?php echo date('Y-m-d') ?>" id="datepicker1" onkeyup="" required data-date-format="yyyy-mm-dd" >
										
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
							                  <?php
							                  if(!empty($payment_modes))
							                  {
							                    foreach($payment_modes as $mode)
							                    {
							                      ?>
							                      <option value="<?=$mode['id'];?>"><?=$mode['payment_mode'];?></option>
							                      <?php
							                    }
							                  }
							                  ?>
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
											<input class="form-control" placeholder="" type="text" name="due_amount" value="" id="due_amount" onkeyup="" >
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
									<!-- <div class="row form-group frm-btm">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
												<label class="input-text">Finally Settled</label>
											</div>
											<div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
											<select class="form-control" name="final_settled" id="final_settled" >
							                  <option value="no">No</option>
							                  <option value="yes">Yes</option>
							                </select>
									</div>
									</div> -->
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
									<a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url();?>admin/payment_portal">Back
									</a>
								</div>								
							</div><!-- End Row -->
							</form>
							</div>
							</div>
						</div>
						
				</div>
			</div><!-- /.main-content -->
			
	
<style>
  .inputs {
    float: left;
    margin-right: 1em;
  }
  .inputs p {
    margin-top: 0;
  }
  </style>

  
  
<script>

$(document).ready(function() {
  var date = new Date();
  var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
  var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());

 // alert(today);
 

});

var focus = 0,
  blur = 0;
$( "p" )
  .focusout(function() {
    //focus++;
    //alert();
   // $( "#focus-count" ).text( "focusout fired: " + focus + "x" );
    var student_id=$("#student_id").val();
    var amount_paid=$("#amount_paid").val();
    var total_fee=$("#total_fee").val();
    var discount_fee=$("#discount_fee").val();
    $.ajax({
			      type: 'post',
			      url: '<?=base_url();?>admin/student/getDueamount',
			      data: {student_id: student_id,amount_paid:amount_paid,total_fee:total_fee,discount_fee:discount_fee},
			      beforeSend: function(xhr){
			        xhr.overrideMimeType("text/plain; charset=utf-8");
			        $("#wait").css("display", "block");
			      },
			      success: function(data){ 
			      	//var json = $.parseJSON(data); 
			      	//alert("OTP Send Successfully");
			      	$("#due_amount").val(data);
			      }
			    });
  });
  
  $( "b" )
  .focusout(function() {
    //focus++;
    //alert();
   // $( "#focus-count" ).text( "focusout fired: " + focus + "x" );
    var student_id=$("#student_id").val();
    var amount_paid=$("#amount_paid").val();
    var total_fee=$("#total_fee").val();
    var discount_fee=$("#discount_fee").val();
    $.ajax({
			      type: 'post',
			      url: '<?=base_url();?>admin/student/getDueamount',
			      data: {student_id: student_id,amount_paid:amount_paid,total_fee:total_fee,discount_fee:discount_fee},
			      beforeSend: function(xhr){
			        xhr.overrideMimeType("text/plain; charset=utf-8");
			        $("#wait").css("display", "block");
			      },
			      success: function(data){ 
			      	//var json = $.parseJSON(data); 
			      	//alert("OTP Send Successfully");
			      	$("#due_amount").val(data);
			      }
			    });
  });

  $( "em" )
  .focusout(function() {
    //focus++;
    //alert();
   // $( "#focus-count" ).text( "focusout fired: " + focus + "x" );
    var student_id=$("#student_id").val();
    var amount_paid=$("#amount_paid").val();
    var total_fee=$("#total_fee").val();
    var discount_fee=$("#discount_fee").val();
    $.ajax({
			      type: 'post',
			      url: '<?=base_url();?>admin/student/getDueamount',
			      data: {student_id: student_id,amount_paid:amount_paid,total_fee:total_fee,discount_fee:discount_fee},
			      beforeSend: function(xhr){
			        xhr.overrideMimeType("text/plain; charset=utf-8");
			        $("#wait").css("display", "block");
			      },
			      success: function(data){ 
			      	//var json = $.parseJSON(data); 
			      	//alert("OTP Send Successfully");
			      	$("#due_amount").val(data);
			      }
			    });
  });
</script>