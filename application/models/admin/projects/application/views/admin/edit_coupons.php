<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">coupons</a></li>
  <li class="active">Edit coupons</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_coupons', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Edit coupons</h3>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
                  
          <div class="panel-body">  

          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Package</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control "  name="package_id" id="package_id" required="" >
                  <option value="">Select Package</option>
                  <?php
                  if(!empty($packages))
                  {
                    foreach($packages as $package)
                    {
                      ?>
                      <option value="<?php echo $package->id;?>" <?php if($package->id == $row->package_id){?> selected <?php }?> ><?php echo $package->package_name;?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>         
            
            <div class="form-group">
              <label for="coupon_code" class="col-md-3 col-xs-12 control-label">Enter coupons code</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="coupon_code" id="coupon_code"  value="<?=$row->coupon_code;?>"  />
              </div>
            </div>
              

                <div class="form-group">
              <label for="discount_percentage" class="col-md-3 col-xs-12 control-label">Enter Discount Percentage</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="discount_percentage" id="discount_percentage" value="<?=$row->discount_percentage;?>"  />
              </div>
            </div>

             <div class="form-group">
              <label for="discount_percentage" class="col-md-3 col-xs-12 control-label">Enter Start Date</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="start_date" id="start_date" value="<?php echo $row->start_date;?>" />
              </div>
            </div>

            <div class="form-group">
              <label for="discount_percentage" class="col-md-3 col-xs-12 control-label">Enter Expiry Date</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="expiry_date" id="expiry_date" value="<?php echo $row->expiry_date;?>"/>
              </div>
            </div>
          

          <input type="hidden" name="coupon_id" value="<?=$row->id;?>">
              
          <div class="panel-footer">
            <!-- <button class="btn btn-default">Clear Form</button> -->
            <a href="<?=base_url();?>admin/register/coupons" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>            
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
            coupon_code: {
                required : true,
            },
            discount_percentage :
            {
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

<script>
 $(function() {
$("#expiry_date").datepicker({
  //maxDate: "-1d"
   format: 'yyyy-mm-dd'
});

$("#start_date").datepicker({
  //maxDate: "-1d"
   format: 'yyyy-mm-dd'
});


})
</script>