<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">Agents</a></li>
  <li class="active">Add Agents</li>
</ul>
<!-- END BREADCRUMB -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_agents', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Agent Registration </h2>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <div class="panel-body">

             <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Packages</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control chosen-select1" multiple="" name="package_ids[]" id="package_ids" required>
                  <option value="">Select Packages</option>
                  <?php
                  if(!empty($packages))
                  {
                    foreach($packages as $package)
                    {
                      ?>
                      <option value="<?php echo $package['id'];?>"><?php echo $package['package_name'];?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="name" class="col-md-3 col-xs-12 control-label">Enter Agent Name</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="agent_name" id="agent_name" required />
              </div>
            </div>

             <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Email</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="email" id="email" required/>
              </div>
            </div>

              <div class="form-group">
              <label for="specialisation" class="col-md-3 col-xs-12 control-label">Enter Mobile</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="mobile" id="mobile" required/>
              </div>
            </div>

            <div class="form-group">
              <label for="specialisation" class="col-md-3 col-xs-12 control-label">Enter Specialisation Type</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="specialisation" id="specialisation" required />
              </div>
            </div>

             <div class="form-group">
              <label for="specialisation" class="col-md-3 col-xs-12 control-label">Discount Percentage(%)</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="number" class="form-control" name="discount_percentage" id="discount_percentage" required/>
              </div>
            </div>

             <div class="form-group">
              <label for="specialisation" class="col-md-3 col-xs-12 control-label">Coupon code</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="coupon_code" id="coupon_code" required />
              </div>
            </div>

            <div class="form-group">
              <label for="discount_percentage" class="col-md-3 col-xs-12 control-label">Enter Start Date</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="start_date" id="start_date" required/>
              </div>
            </div>

          <div class="form-group">
              <label for="discount_percentage" class="col-md-3 col-xs-12 control-label">Enter Expiry Date</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="expiry_date" id="expiry_date" required/>
              </div>
            </div>

            <div class="form-group">
              <label for="discount_percentage" class="col-md-3 col-xs-12 control-label">No Of Users to Apply</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="no_of_users_to_apply" id="no_of_users_to_apply" required/>
              </div>
            </div>

            <hr>
            <center><b>Bank Information</b></center>

            <div class="form-group">
              <label for="specialisation" class="col-md-3 col-xs-12 control-label">Bank Name</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="bank_name" id="bank_name" />
              </div>
            </div>

            <div class="form-group">
              <label for="specialisation" class="col-md-3 col-xs-12 control-label">Account Number</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="account_number" id="account_number" />
              </div>
            </div>

             <div class="form-group">
              <label for="specialisation" class="col-md-3 col-xs-12 control-label">Account Holder Name </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="account_holder_name" id="account_holder_name" />
              </div>
            </div>

             <div class="form-group">
              <label for="specialisation" class="col-md-3 col-xs-12 control-label">IFSC Code </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" />
              </div>
            </div>

            <div class="form-group">
              <label for="specialisation" class="col-md-3 col-xs-12 control-label">Bank Address </label>
              <div class="col-md-6 col-xs-12">                
                
                <textarea type="text" class="form-control" name="bank_address"></textarea>
              </div>
            </div>
             

          </div>
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/agents" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
            <button type="submit" class="btn btn-primary pull-right" id="btnSubmit">Submit</button>
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
            name:
            {
              required : true,
            },          
             title: {
                 required : true,
             },
             specialisation:
             {
               required : true,
             },
             image:
             {
                required : true,
             }
          },
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });

       $(".chosen-select1").chosen();
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