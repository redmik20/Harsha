<!-- FAQ Starts-->
<section class="sec-space text-center faq light-gray-bg user-panel">
    <div class="container"> 
       <div class="row">        
        <?php
        $this->load->view('website/includes/side_menu');
        ?>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <!-- Simple post content example. -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4><a href="#" style="text-decoration:none;"><strong>Edit Profile</strong></a></h4>
                   <?php if($this->session->flashdata('success') != "") : ?>
                      <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <?=$this->session->flashdata('success');?>
                      </div>
                    <?php endif; ?>
                    <hr>
                    <div class="post-content">
                        <div class="col-sm-12">
            <div class="all-courses">
              <div class="profile__courses__inner">
                            
                            <div class="login pb-50 col-lg-6">
                            <form class="reply-form" action="<?=base_url();?>home/update_profile" method="post" id="change_validation">
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <input placeholder="Enter Name" required="" title="" data-placement="bottom" data-toggle="tooltip" value="<?=$row->name;?>" name="name" id="name" class="form-control name input-your-name" type="text">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <input placeholder="Enter Email Id" required="" title="" data-placement="bottom" data-toggle="tooltip" value="<?=$row->email_id;?>" name="email_id" id="email_id" class="form-control name input-your-name" type="text">         
                                    </div>
                                    <input type="hidden" name="user_id" id="user_id" value="<?=$row->id;?>">
                                    <div class="form-group col-md-12">                                               
                                        <button class="theme-btn" type="submit"><i class="fa fa-envelope"></i> Submit </button>                                               
                                    </div>
                                </div>
                            </form>
                        </div>  
                        
                            </div>

                            </div>
            </div>
          </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>
</section>
<!-- / FAQ Ends -->
</article>
<!-- / CONTENT AREA -->

<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-validate-additional-methods.js"></script>
<script>
  $(document).ready(function() { //alert();
      $("#change_validation").validate({
          rules: {
            // simple rule, converted to {required:true}            
            name: {
              required : true,
              minlength:6
            },
            email_id: {
              required : true,
              myEmail:true,
              remote: {
                url: '<?=base_url();?>home/check_email_id_exists',
                type: "post",
                data: {
                  user_id: function() {
                    return $( "#user_id" ).val();
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
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
  });
  jQuery.validator.addMethod("myEmail", function(value, element) {
    return this.optional( element ) || ( /^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/.test( value ) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test( value ) );
  }, 'Please enter valid email address.'); 
</script>

