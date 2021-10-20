<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="<?php echo base_url('admin/home')?>">Home</a></li>
  <li><a href="<?php echo base_url('admin/register/topics')?>">Chapters</a></li>
  <li class="active">Add Chapters</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_qbanktopics', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Add Qbank Topics</h2>            
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
                <select class="form-control" name="course_id" id="course_id" required="" onchange="getss(this.value)">
                  <option value="">Select Course</option>
                  <?php
                  if(!empty($exams))
                  {
                    foreach($exams as $exam)
                    {
                      ?>
                      <option value="<?=$exam->id;?>"><?=$exam->name;?></option>
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
                <select class="form-control" name="subject_id" id="subject_id" required="" onchange="getqbankchapters(this.value)">
                  <option value="">Select Subjects</option>
                </select>
              </div>
            </div>


            <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Select Chapter</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="chapter_id" id="chapter_id" required="">
                  <option value="">Select Chapter</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Topic Name </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="name" id="name" required=""/>
              </div>
              </div>

              <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Title </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="title" id="title" required=""/>
              </div>
              </div>
            

              <div class="form-group">
              <label for="description" class="col-md-3 col-xs-12 control-label">Enter Description</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="description" id="description" required=""/>
              </div>
          </div>


           <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Free/Paid</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="quiz_type" id="quiz_type" required="">
                  <option value="">Select type</option>
                  <option value="free">Free</option> 
                  <option value="paid">paid</option>
                   </select>
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Suggested Qbank Status</label>
              <div class="col-md-6 col-xs-12">
                <input class="" type="radio" name="suggested_qbank" checked value="yes">
                <label for="yes">YES</label>
               
                </br>
                <input class="" type="radio" name="suggested_qbank" value="no">
                <label for="no">NO</label>
                  
                   
              </div>
            </div>  

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Enter PDF Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="pdf_url" id="icon" />
                </div>
              </div>
            </div> 

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Enter Questions Count</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="questions_count" id="icon" />
                </div>
              </div>
            </div> 

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Suggested Banner Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="banner_image" id="icon" />
                </div>
              </div>
            </div>   

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Topic Icon Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="icon_image" id="icon" />
                </div>
              </div>
            </div>   

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Enter Order</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="number" class="form-control" name="order" id="order" />
                </div>
              </div>
            </div> 

            

          </div>
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/qbanktopics" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
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
            topic_name: {
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




