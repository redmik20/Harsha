<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">subjects</a></li>
  <li class="active">Edit subjects</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_subjects', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Edit subjects</h3>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
                  
          <div class="panel-body">           

          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Courses</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="exam_id" id="exam_id" >

            <option value="">Select Courses</option>
                  <?php
                  if(!empty($exams))
                  {
                    foreach($exams as $exam)
                    {
                      ?>
                      <option value="<?=$exam->id;?>" <?php echo ($exam->id == $row->exam_id)?"selected":"" ;?>><?=$exam->name;?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            
             <div class="form-group">
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Enter subject name</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="subject_name" id="subject_name" value="<?=$row->subject_name;?>"  />
              </div>
            </div>
             <!-- <div class="form-group">
              <label for="category_type" class="col-md-3 col-xs-12 control-label">Category Type</label>
               <div> <label > 0- All , 1 - Vidoes , 2 - Pdf, 3- Testseries </label></div>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="number" class="form-control" name="category_type" id="category_type" value="<?=$row->category_type;?>" />
              </div>
            </div> -->

            <div class="form-group">
              <label for="category_type" class="col-md-3 col-xs-12 control-label">Category Type</label>
               
              <div class="col-md-6 col-xs-12">                
               
               <?php $category_values=explode(',',$row->category_values);?>
               
                <input type="checkbox" class="form-check-input" name="category_values[]"  value="1" 
                <?php foreach ($category_values as $key => $value) {
                  if($value == 1){ echo 'checked'; }
                }?>  /> &nbsp;Vidoes<br>
                <input type="checkbox" class="form-check-input" name="category_values[]"  value="2" 
                <?php foreach ($category_values as $key => $value) {
                  if($value == 2){ echo 'checked'; }
                }?>/> &nbsp;Bit Bank<br>
                <input type="checkbox" class="form-check-input" name="category_values[]"  value="3"
                <?php foreach ($category_values as $key => $value) {
                  if($value == 3){ echo 'checked'; }
                }?> /> &nbsp;Testseries
              </div>
            </div>
            <div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Enter Image Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="image" value="<?php echo $row->image;?>" id="image"  />
                </div>
              </div>
              <?php  /*if($row->image !='' ){?>
              <img src="<?=base_url().$row->image;?>" height="50" width="50">
              <?php }else{?>
              <img src="<?=base_url().'storage/no_image.jpg';?>" height="50" width="50">
              <?php }*/ ?>
            </div>

             <div class="form-group">
              <label for="icon" class="col-md-3 col-xs-12 control-label">Enter Qbank image Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="icon" value="<?php echo $row->icon;?>" id="icon"  />
                </div>
                 </div>
                 <?php /* if($row->icon !=''){?>
              <img src="<?=base_url().$row->icon;?>" height="50" width="50">
              <?php }else{?>
              <img src="<?=base_url().'storage/no_image.jpg';?>" height="50" width="50">
              <?php } */?>
            </div>

            <div class="form-group">
              <label for="order" class="col-md-3 col-xs-12 control-label">Enter Order No</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="order" id="order" value="<?php echo $row->order;?>" required="" />
              </div>
            </div>

            <div class="form-group">
              <label for="order" class="col-md-3 col-xs-12 control-label">Enter videos Count</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="videos_count" id="videos_count" value="<?php echo $row->videos_count;?>" required="" />
              </div>
            </div>


        

              </div>
            </div>



          <input type="hidden" name="subject_id" value="<?=$row->id;?>">
          <input type="hidden" name="imgurl" value="<?=$row->image;?>">
           <input type="hidden" name="iconurl" value="<?=$row->icon;?>">
          
              
          <div class="panel-footer">
            <!-- <button class="btn btn-default">Clear Form</button> -->
            <a href="<?=base_url();?>admin/register/subjects" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>            
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
            exam_id: {
               required : true,
            },
             subject_name: {
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
