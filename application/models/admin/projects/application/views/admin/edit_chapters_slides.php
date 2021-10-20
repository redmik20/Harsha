<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">Chapters Slides</a></li>
  <li class="active">Edit Chapters Slides</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_chapters_slides', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Edit Chapters Slides</h3>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
                  
          <div class="panel-body">
                
                
                <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Exams</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="exam_id" id="exam_id" required="" onchange="getss(this.value)" >
                  <option value="">Select exams</option>
                  <?php
                  if(!empty($exams))
                  {
                    foreach($exams as $exam)
                    {
                      ?>
                      <option value="<?=$exam->id;?>" <?php if ($exam->id == $row->exam_id){ echo "selected"; }?>><?=$exam->name;?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
   
          <div class="form-group">
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Subjects</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="subject_id" id="subject_id" required="" onchange="getcc(this.value)">
                  <option value="">Select Subjects</option>
                </select>
              </div>
            </div>

             <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Chapters</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="chapter_id" id="chapter_id" required>
                  <option value="">Select chapters</option>
                </select>
              </div>
            </div> 

             <div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Upload Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="image" id="image" />
                </div>
              </div><img src="<?=base_url().$row->image;?>" height="50" width="50">
            </div>
            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Chapter slides Status</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="status" id="status" required="">
                  <option value="">Select slides status</option>
                  <option value="free" <?php if($row->chapters_status=='free'){ echo "selected";} ?>>Free</option>
                  <option value="paid" <?php if($row->chapters_status=='paid'){ echo "selected";} ?>>Paid</option>
                </select>
              </div>
            </div>


          </div>
          <input type="hidden" name="chapters_slides_id" id="chapters_slides_id" value="<?=$row->id;?>">

           <input type="hidden" name="imgurl" value="<?=$row->image;?>">
              
          <div class="panel-footer">
            <!-- <button class="btn btn-default">Clear Form</button> -->
            <a href="<?=base_url();?>admin/register/chapters_slides" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>            
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

          },
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
      
  });    
  
  
  var exam_id = $('#exam_id :selected').val();
 var chapters_slides_id = $('#chapters_slides_id').val();
  $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_subjectsss',
      data: {exam_id: exam_id,chapters_slides_id: chapters_slides_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=x-user-defined");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#subject_id").html(data);
        $("#wait").css("display", "none");
      }
    });

    setTimeout(function () {
        var exam_id = $('#exam_id :selected').val();
        var subject_id = $('#subject_id :selected').val();
 var chapters_slides_id = $('#chapters_slides_id').val();
  $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_servicesss',
      data: {subject_id: subject_id,exam_id: exam_id,chapters_slides_id: chapters_slides_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=x-user-defined");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#chapter_id").html(data);
        $("#wait").css("display", "none");
      }
    });
}, 1000);
</script>
