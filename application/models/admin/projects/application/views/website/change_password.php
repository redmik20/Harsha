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
                    <h4><a href="#" style="text-decoration:none;"><strong>Change Password</strong></a></h4>
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
                            <form class="reply-form" action="<?=base_url();?>home/update_password" method="post" id="change_validation">
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <input placeholder="New Password" required="" title="" data-placement="bottom" data-toggle="tooltip" value="" name="password" id="password" class="form-control name input-your-name" type="password">         
                                    </div>

                                    <div class="form-group col-md-12">
                                        <input placeholder="Repeat New Password" required="" title="" data-placement="bottom" data-toggle="tooltip" value="" name="confirm_password" id="confirm_password" class="form-control name input-your-name" type="password">    
                                    </div>
                                    
                                    <div class="form-group col-md-12">                                               
                                        <button class="theme-btn" type="submit"><i class="fa fa-key"></i> Change Password </button>                                               
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
            password: {
              required : true,
              minlength:6
            },
            confirm_password: {
              required : true,
              equalTo : "#password",
              minlength:6
            }
          },          
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
  });
</script>

