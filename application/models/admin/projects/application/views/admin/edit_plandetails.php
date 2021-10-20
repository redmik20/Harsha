<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">plandetails</a></li>
  <li class="active">Edit plandetails</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_plandetails', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Edit plandetails</h3>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
                  
          <div class="panel-body">           

          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Coupons</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="coupon_id" id="coupon_id">

            <option value="">Select Coupons</option>
                  <?php
                  if(!empty($coupons))
                  {
                    foreach($coupons as $coupon)
                    {
                      ?>
                      <option value="<?=$coupon->id;?>" <?php echo ($coupon->id == $row->coupon_id)?"selected":"" ;?>><?=$coupon->coupon_code;?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            
              <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">plan_type</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="plan_type" id="plan_type" required="">
                  <option value="">Select plan_type</option>
                  <?php

                  $plan_types = ['proplans', 'IndividualPlans'];

                  foreach($plan_types as $plan_type) {
                  ?>
                    <option value="<?=$plan_type;?>" <?php echo ($plan_type == $row->plan_type)?"selected":"" ;?>><?=$plan_type;?></option> 
                  <?php
                  }
                  ?>
                   </select>
              </div>
            </div>         
            


            <div class="form-group">
              <label for="plan_name" class="col-md-3 col-xs-12 control-label">Enter plan  Name </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="plan_name" id="plan_name" value="<?=$row->plan_name;?>"/>
              </div>
            </div>
          

            <div class="form-group">
              <label for="price" class="col-md-3 col-xs-12 control-label">Enter price  </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="price" id="price" value="<?=$row->price;?>"/>
              </div>
            </div>
            

               <div class="form-group">
              <label for="expire_duration_months" class="col-md-3 col-xs-12 control-label">Enter expire Duration Months  </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="expire_duration_months" id="expire_duration_months" value="<?=$row->expire_duration_months;?>"/>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Q bank Access</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="q_bank_access" id="q_bank_access" required="">
                  <option value="">Select </option>
                  <option value="Yes" <?php echo ($row->q_bank_access == "Yes")?"selected":"" ;?>>Yes</option> 
                  <option value="No" <?php echo ($row->q_bank_access == "No")?"selected":"" ;?>>No</option>
                   </select>
              </div>
            </div>
            
          
            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">plan tests_access</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="tests_access" id="tests_access" required="">
                  <option value="">Select tests access</option>
                  <option value="Yes" <?php echo ($row->tests_access == "Yes")?"selected":"" ;?>>Yes</option> 
                  <option value="No" <?php echo ($row->tests_access == "No")?"selected":"" ;?>>No</option>
                   </select>
              </div>
            </div> 
            
            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">plan videos access</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="videos_access" id="videos_access" required="">
                  <option value="">Select </option>
                  <option value="Yes" <?php echo ($row->videos_access == "Yes")?"selected":"" ;?>>Yes</option> 
                  <option value="No" <?php echo ($row->videos_access == "No")?"selected":"" ;?>>No</option>
                   </select>
              </div>
            </div>
         

</div>
          <input type="hidden" name="plandetail_id" value="<?=$row->id;?>">
              
          <div class="panel-footer">
            <!-- <button class="btn btn-default">Clear Form</button> -->
            <a href="<?=base_url();?>admin/register/plandetails" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>            
            <button type="submit" class="btn btn-primary pull-right">Submit</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- END PAGE CONTENT WRAPPER -->
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-validate-additional-methods.js"></script>
<script>
  $(document).ready(function() { //alert();
      $("#validation").validate({
          rules: {
            // simple rule, converted to {required:true}            
            coupon_id: {
                required : true,
            },
            plan_type: {
                required : true,
            },
            plan_name: {
                required : true,
            },
            price :{
                required : true,
            },
            expire_duration_months:{
                required : true,
            },
            q_bank_access:{
                required : true,
            },
            tests_access:{
                required : true,
            },
            videos_access:{
                required : true,
            }
           
          },
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
      
  }); 
</script>
