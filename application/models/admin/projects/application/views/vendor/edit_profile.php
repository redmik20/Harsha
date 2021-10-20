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
              <h3 class="card-title">Edit Profile</h3>
            </div>
            <?php if($this->session->flashdata('success') != "") : ?>
              <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span class="sr-only">Close</span></button>
                <?=$this->session->flashdata('success');?>
              </div>
            <?php endif; ?>
            <div class="card-body">
            <form method="post" action="<?=base_url();?>vendor/home/update_profile" id="validation">
              <fieldset class="form-fieldset col-md-6">
                  <div class="form-group">
                    <label class="form-label">Enter Name<span class="form-required">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" value="<?=$profile->name;?>" />
                  </div>
                  <div class="form-group">
                    <label class="form-label">Enter Mobile<span class="form-required">*</span></label>
                    <input type="text" class="form-control" name="mobile" id="mobile" value="<?=$profile->mobile;?>" readonly="" />
                  </div>
                  <div class="form-group">
                    <label class="form-label">Enter Email Id<span class="form-required">*</span></label>
                    <input type="email" class="form-control" name="email_id" id="email_id" value="<?=$profile->email_id;?>" />
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
$(document).ready(function() { //alert();
  $("#validation").validate({
    rules: {
      // simple rule, converted to {required:true}            
      name: {
          required : true,
      },
      email_id: {
        required : true,
        myEmail:true,
        remote: {
          url: '<?=base_url();?>vendor/home/check_email_id_exists',
          type: "post",
          data: {
            id: function() {
              return $( "#id" ).val();
            },
            email_id: function() {
              return $( "#email_id" ).val();
            }
          }
        }
      }
    },
    messages:{
      email_id: {
        remote : "Email Id already exists",
      }
    },
    submitHandler: function(form) {
        //$("#btnSubmit").prop('disabled', true);
        form.submit();
    }
  });
   });
  // create your custom rule
  jQuery.validator.addMethod("myEmail", function(value, element) {
    return this.optional( element ) || ( /^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/.test( value ) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test( value ) );
  }, 'Please enter valid email address.');
  </script>
  <style type="text/css">
    .error
    {
      color:red;
    }
  </style>