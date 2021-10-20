<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">Images Gallery</a></li>
  <li class="active">Add Images Gallery</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_images_gallery', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Add Images Gallery</h2>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <div class="panel-body">

            

             <div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Upload Image<span style="color:red">*</span></label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                 
                  <input type="file" class="fileinput btn-primary" name="image" id="image" required="" />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Restriction</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                 
                  <span style="color:red">Image dimenstions must be below (500 * 500) </span>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Notes</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                 
                  <input type="text" class="form-control" name="note" id="image" />
                </div>
              </div>
            </div>

          </div>
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/images_gallery" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
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
            image: {
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
