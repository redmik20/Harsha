<div class="page-wrapper p-t-30">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- Row -->
                <div class="row">                
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <!-- Column -->
                      
                    </div>
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                               <!-- <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Activity</a> </li>-->
                                <!-- <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="javascript:void(0)" role="tab">Change Password</a> </li> -->
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                            <?php
                            if($this->session->flashdata('success'))
                            {
                              ?>
                              <div class="alert alert-success select_lat_error wow shake"id="success">
                                <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                                <?=$this->session->flashdata('success');?></a>
                              </div>
                              <?php
                            }
                            ?>

                                <div class="tab-pane active" id="settings" role="tabpanel">
                                    <div class="card-block">
                                        <form class="form-horizontal form-material" method="post" id="registration" action="<?=base_url();?>home/update_password" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="col-md-12">New Password</label>
                                                <div class="col-md-12">
                                                    <input type="password" class="form-control form-control-line" name="password" id="password" required="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12">Confirm Password</label>
                                                <div class="col-md-12">
                                                    <input type="password" class="form-control form-control-line" name="confirm_password" id="confirm_password" required="">
                                                </div>
                                            </div>
                                            
                                           <input type="hidden" name="user_id" id="user_id" value="<?=$this->uri->segment(3);?>">

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button id="btnSubmit" class="btn btn-success">Update Password</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>

<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-validate-additional-methods.js"></script>
<script>
  $(document).ready(function() { //alert();
      $("#registration").validate({
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

<style type="text/css">
  .error
  {
    color: red;
  }
</style>