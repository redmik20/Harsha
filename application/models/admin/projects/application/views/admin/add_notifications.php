<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">notifications</a></li>
  <li class="active">Add notifications</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_notifications', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Add notifications</h2>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <div class="panel-body">

          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Courses<span style="color:red">*</span></label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="course_id" id="course_id" required="" onchange="getss(this.value)">
                  <option value="">Select Course</option>
                  <option value="all">ALL</option>
                  <?php
                  if(!empty($courses))
                  {
                    foreach($courses as $course)
                    {
                      ?>
                      <option value="<?=$course->id;?>"><?=$course->name;?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Title<span style="color:red">*</span></label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="title" id="title" />
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Image<span style="color:red">*</span></label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <input type="file" class="fileinput btn-primary" name="image" id="icon" />
                </div>
              </div>
           </div>
      

          <div class="form-group">
              <label for="description" class="col-md-3 col-xs-12 control-label">Enter description</label>
              <div class="col-md-6 col-xs-12">                
                <textarea class="form-control" name="description" id="description"></textarea>
              </div>
          </div>

           

             

          </div>
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/notifications" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
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
            title:
            {
              required : true,
            },          
             description: {
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
