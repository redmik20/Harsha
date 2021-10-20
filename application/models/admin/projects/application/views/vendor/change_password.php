<div class="my-3 my-md-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="card card-profile">            
            <?php $this->load->view('vendor/includes/profile_side_menu'); ?>
          </div>
          </div>
          

        <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Change Password</h3>
            </div>
            <?php if($this->session->flashdata('success') != "") : ?>
              <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span class="sr-only">Close</span></button>
                <?=$this->session->flashdata('success');?>
              </div>
            <?php endif; ?>
            <div class="card-body">
            <form action="<?=base_url();?>vendor/home/update_password" method="post" id="c_validation">
              <fieldset class="form-fieldset col-md-6">
                  <div class="form-group">
                    <label class="form-label">New Passowrd<span class="form-required">*</span></label>
                    <input type="password" class="form-control" name="password" id="password" required="" />
                  </div>
                  <div class="form-group">
                    <label class="form-label">Confirm New Password<span class="form-required">*</span></label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" required="" />
                  </div>
                 <div class="form-footer">
                   <button type="submit" class="btn btn-primary btn-block col-lg-6 pull-right">Change</button>
                 </div>
                </fieldset>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-validate-additional-methods.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $("#c_validation").validate({
    rules: {
      // simple rule, converted to {required:true}      
      password: {
          required : true,
          minlength:6
      },
      confirm_password: {
          required : true,
          equalTo : "#password",
          minlength:6
      },
    },    
    submitHandler: function(form) {
        //$("#btnSubmit").prop('disabled', true);
        form.submit();
    }
  });
  });
  </script>