<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">Chapters</a></li>
  <li class="active">Edit Chapters</li>
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
            <h2 class="panel-title">Edit Qbank Topics</h3>            
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
                <select class="form-control" name="course_id" id="course_id" required="" onchange="getss(this.value)" >
                  <?php foreach($courses as $cour){?>
                  
                  <option value="<?php echo $cour->id?>" <?php if($cour->id == $exams->course_id){ ?> selected <?php } ?> ><?php echo $cour->name?></option>
                  <?php 
                  }?>
                </select>
              </div>
            </div>
   
          <div class="form-group">
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Subjects</label>
              <div class="col-md-6 col-xs-12">  
                        
                <select class="form-control" name="subject_id" id="subject_id" required="" onchange="getqbankchapters(this.value)">
                <?php if(!empty($subjects)){
                  foreach($subjects as $sub){?>
                  
                  <option value="<?php echo $sub['id']?>" <?php if($sub['id'] == $exams->subject_id){ ?> selected <?php } ?> ><?php echo $sub['subject_name']?></option>
                  <?php 
                  } 
                }?>
                  
                </select>
              </div>
          </div>

           <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Select Chapter</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="chapter_id" id="chapter_id" required="">
                <?php foreach($qbankChapters as $chap){?>
                  
                  <option value="<?php echo $chap['id']?>" <?php if($chap['id'] == $exams->chapter_id){ ?>selected <?php } ?> ><?php echo $chap['topic_name']?></option>
                  <?php 
                  }?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Enter Topic Name</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="name" id="name"  value="<?=$exams->name; ?>" required=""/>
              </div>
            </div>


              <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Title </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="title" id="title"  value="<?=$exams->title; ?>"  required=""/>
              </div>
          </div>
            

              <div class="form-group">
              <label for="description" class="col-md-3 col-xs-12 control-label">Enter Description</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="description" id="description" value="<?=$exams->description; ?>"  required=""/>
              </div>
          </div>

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Free/Paid</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" 
                name="quiz_type" id="quiz_type" required="">
                <option value="">Select type</option>
                 <option value="free" <?php if($exams->quiz_type == 'free'){ echo "selected";}?>>Free</option>
                 <option value="paid" <?php if($exams->quiz_type == 'paid'){ echo "selected";}?>>Paid</option>
                </select>
              </div>
            </div> 

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Suggested Qbank Status</label>
              <div class="col-md-6 col-xs-12">
                <input class="" type="radio" name="suggested_qbank" <?php if($exams->suggested_qbank == 'yes'){ ?> checked <?php }?> value="yes" >
                <label for="yes">YES</label>
                </br>
                <input class="" type="radio" name="suggested_qbank" <?php if($exams->suggested_qbank == 'no'){ ?> checked <?php }?> value="no">
                <label for="no">NO</label>
              </div>
          </div>



          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Enter PDF Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="pdf_url" value="<?php echo $exams->pdf_path;?>" id="icon" />
                 
                  </br>

             <?php if($exams->pdf_path != ''){?>
              <a href="<?php echo $exams->pdf_path;?>" target="_blank">Downlod pdf</a>
              <?php }?>
              
                </div>
              </div>
            </div> 

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Enter Questions Count</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="questions_count" value="<?php echo $exams->questions_count;?>" id="icon" />
                 
                  </br>
              
                </div>
              </div>
            </div>
          

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Suggested Banner Path</label>
              <div class="col-md-6 col-xs-12">
              <div class="">
              <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
              <input type="text" class="form-control" name="banner_image" value="<?php echo $exams->banner_image;?>" id="icon" />
              </br>
              <?php /*if($exams->banner_image !=''){?>
              <img src="<?php echo base_url().$exams->banner_image;?>" height="100" width="100">
              <?php }else{?>
              <img src="<?php echo base_url('storage/no_image.jpg')?>" height="100" width="100">
              <?php }*/ ?>
            </div>
            </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Topic Icon Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="icon_image" value="<?php echo $exams->icon_image;?>" id="icon" />
                  </br>
              <?php /*if($exams->icon_image !=''){?>
              <img src="<?php echo base_url().$exams->icon_image;?>" height="100" width="100">
              <?php }else{?>
              <img src="<?php echo base_url('storage/no_image.jpg')?>" height="100" width="100">
              <?php }*/ ?>
                </div>
              </div>
            </div>   

          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Enter Order</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="number" class="form-control" name="order" id="order" value="<?php echo $exams->order;?>"/>
                </div>
              </div>
            </div> 



         
           
           
             

          <input type="hidden" name="qbanktopic_id" id="qbanktopic_id" value="<?=$exams->id;?>">
              
          <div class="panel-footer">
            <!-- <button class="btn btn-default">Clear Form</button> -->
            <a href="<?=base_url();?>admin/register/qbanktopics" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>            
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
  
  
  
  var exam_id = $('#exam_id :selected').val();
 var video_topic_id = $('#video_topic_id').val();
  $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_topics',
      data: {exam_id: exam_id,video_topic_id: video_topic_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=x-user-defined");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#subject_id").html(data);
        $("#wait").css("display", "none");
      }
    });

    /*setTimeout(function () {
        var exam_id = $('#exam_id :selected').val();
        var subject_id = $('#subject_id :selected').val();
 var video_topic_id = $('#video_topic_id').val();
  $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_servicess',
      data: {subject_id: subject_id,exam_id: exam_id,video_topic_id: video_topic_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=x-user-defined");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#chapter_id").html(data);
        $("#wait").css("display", "none");
      }
    });
}, 1000);*/
  
</script>
