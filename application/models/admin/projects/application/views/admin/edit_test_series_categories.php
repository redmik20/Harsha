<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">test_series_categories</a></li>
  <li class="active">Edit test_series_categories</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_test_series_categories', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Edit Test series categories</h3>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
                  


          <div class="panel-body">  


          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Select Course</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="course_id" id="course_id" required="" >
                  <!--<option value="<?=$questions->course_id; ?>"><?=$questions->course_name; ?></option>-->

                   <option value="">Select course</option>

                  <?php foreach($courses as $cour){?>
                  
                  <option value="<?php echo $cour['id']?>" <?php if($cour['id'] == $row->course_id){ ?> selected <?php } ?> ><?php echo $cour['name']?></option>
                  <?php 
                  }?>
                </select>
              </div>
            </div>          


            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter name</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="title" id="title" value="<?=$row->title;?>" />
              </div>
            </div>

             <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter PDF Path</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="pdf_path" id="pdf_path" value="<?=$row->pdf_path;?>"/>
              </div>
            </div>

             <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Order</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="order" id="order" value="<?=$row->order;?>"/>
              </div>
            </div>
            

          <input type="hidden" name="test_series_categories_id" value="<?=$row->id;?>">
       
              
          <div class="panel-footer">
            <!-- <button class="btn btn-default">Clear Form</button> -->
            <a href="<?=base_url();?>admin/register/test_series_categories" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>            
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
            title: {
                required : true,
            },
          },
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
      
  }); 
</script>
