<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">test_series_quiz</a></li>
  <li class="active">Edit test_series_quiz</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_test_series_quiz/update', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Edit Test Series Quiz </h3>            
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
                <select class="form-control" name="course_id" id="course_id" required="" onchange="getCourseCategories(this.value)">
                  <option value="">Select courses</option>
                  <?php
                  if(!empty($exams))
                  {
                    foreach($exams as $exam)
                    {
                      ?>
                      <option value="<?=$exam->id;?>" <?php if ($exam->id == $row->course_id){ echo "selected"; }?>><?=$exam->name;?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
   
          <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Category</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="category_id" id="category_id" required="" >
                  <option value="">Select Category</option>
                  <?php
                  if(!empty($test_series_categories))
                  {
                    foreach($test_series_categories as $exam)
                    {
                      ?>
                      <option value="<?=$exam->id;?>" <?php if ($exam->id == $row->category_id){ echo "selected"; }?>><?=$exam->title;?></option>
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
                <select class="form-control" name="subject_id" id="subject_id1" required="" >
                  <option value="">Select Subjects</option>
                  <?php //echo '<pre>';print_r($subjects);exit();
                  foreach ($subjects as $key => $value) {?>
                
                     <option value="<?php echo $value['id'] ?>" <?php if ($value['id'] == $row->subject_id){ echo "selected"; }?>><?php echo $value['subject_name'] ?></option>
                  <?php }
                  ?>
                </select>
              </div>
            </div>
         
            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Title </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="title" id="title"  value="<?=$row->title;?>" required=""/>
              </div>
          </div>
            

              <div class="form-group">
              <label for="description" class="col-md-3 col-xs-12 control-label">Enter Description</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="description" id="description"   value="<?=$row->description;?>" required=""/>
              </div>
          </div>
              

              
          <div class="form-group">
              <label for="time" class="col-md-3 col-xs-12 control-label">Enter Time </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="time" id="time"  value="<?=$row->time;?>" required=""/>
              </div>
          </div>
          


          <div class="form-group">
              <label for="exam_time" class="col-md-3 col-xs-12 control-label">Exam Date </label>
              <div class="col-md-3 col-xs-6">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                <?php 
                if(($row->exam_time != '') && ($row->exam_time != '0000-00-00')){
                  $exam_date=$row->exam_time;
                  $timestamp = strtotime($exam_date);
                  $convert_exam_date=date("d-m-Y", $timestamp);
                  }else{
                  $convert_exam_date='';
                  }
                ?>
                <input type="datetime" class="form-control" 
                name="exam_time" id="exam_time"  value="<?php echo $convert_exam_date;?>" required=""/>
              </div>
              <div class="col-md-3 col-xs-6">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                <?php 
                if(($row->exam_time != '') && ($row->exam_time != '0000-00-00')){
                  $exam_date=$row->exam_time;
                  $timepicker=explode(' ',$exam_date);
                  $time=$timepicker[1];
                  //echo '<pre>';print_r($time);exit;
                  if($time == '00:00:00'){ $time='09:30'; }
                  }else{
                  $time='09:30';
                  }
                ?>
                <input type="text" class="form-control timepicker" 
                name="timepicker" id="timepicker"  value="<?php echo $time;?>" required=""/>
              </div>
          </div>

          <div class="form-group">
              <label for="exam_time" class="col-md-3 col-xs-12 control-label">Expiry Date </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                <?php 
                if(($row->expiry_date != '') && ($row->expiry_date != '0000-00-00')){
                  $expiry_date=$row->expiry_date;
                  $timestamp = strtotime($expiry_date);
                  $convert_expiry_date=date("d-m-Y", $timestamp);
                  }else{
                  $convert_expiry_date='';
                  }
                ?>
                <input type="datetime" class="form-control" 
                name="expiry_date" id="expiry_date"  value="<?php echo $convert_expiry_date;?>"/>
              </div>
          </div>
            
          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Free/Paid</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" 
                name="quiz_type" id="quiz_type">
                <option value="">Select type</option>
                 <option value="free" <?php if($row->quiz_type == 'free'){ echo "selected";}?>>Free</option>
                 <option value="paid" <?php if($row->quiz_type == 'paid'){ echo "selected";}?>>Paid</option>
                </select>
              </div>
            </div> 

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Banner Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <input type="file" class="fileinput btn-primary" name="image" id="icon" />
                  </br>
              <?php if($row->test_series_image !=''){?>
              <img src="<?php echo base_url().$row->test_series_image;?>" height="100" width="100">
              <?php }else{?>
              <img src="<?php echo base_url('storage/no_image.jpg')?>" height="100" width="100">
              <?php }?>
                </div>
              </div>
            </div>  
                   
<div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Suggested Testseries</label>
              <div class="col-md-6 col-xs-12">
                <input class="" type="radio" name="suggested_test_series" <?php if($row->suggested_test_series == 'yes'){ ?> checked <?php }?> value="yes">
                <label for="yes">YES</label>
               
                </br>
                <input class="" type="radio" name="suggested_test_series" <?php if($row->suggested_test_series == 'no'){ ?> checked <?php }?>  value="no">
                <label for="no">NO</label>
                  
                   
              </div>
            </div> 

              <div class="form-group">
              <label for="uploaded_pdf_path" class="col-md-3 col-xs-12 control-label">Uploaded PDF Path </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="uploaded_pdf_path" id="uploaded_pdf_path"  value="<?php echo $row->uploaded_pdf_path;?>"/>
              </div>
          </div>



           <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Enter Order</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text"  class="form-control" name="order" id="order"  value="<?php echo $row->order;?>"/>
                </div>
              </div>
          </div> 

           <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Enter Questions Count</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text"  class="form-control" name="questions_count" id="order"  value="<?php echo $row->questions_count;?>"/>
                </div>
              </div>
          </div> 




          <input type="hidden" name="test_series_quiz_id" id="test_series_quiz_id" value="<?=$row->id;?>">
              
          <div class="panel-footer">
            <!-- <button class="btn btn-default">Clear Form</button> -->
            <a href="<?=base_url();?>admin/register/test_series_quiz" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>            
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


<script src="//code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

<script type="text/javascript">
       $(document).ready(function() {
         $('.timepicker').timepicker({
                timeFormat: 'HH:mm',
                interval: 15,
                defaultTime: '<?php echo $time;?>',
              });
       });
</script>
<script>
 $(function() {
$("#exam_time").datepicker({
  //maxDate: "-1d"
   format: 'dd-mm-yyyy'
});
$("#expiry_date").datepicker({
  //maxDate: "-1d"
   format: 'dd-mm-yyyy'
});
})
</script>
<script>
$(function() {
 /*$("#exam_time").datepicker({

    format: 'dd-mm-yyyy'
  });*/


 /*$("#exam_time").on('change', function(){
     
         var date = Date.parse($(this).val());

         if (date < Date.now()){
             alert('Please select another date');
             $(this).val('');
         }
     
    });*/
});
</script>
<script>
  $(document).ready(function() { //alert();
      $("#validation").validate({
          rules: {
            // simple rule, converted to {required:true}            
            course_id: {
                required : true,
            },
            category_id: {
                required : true,
            },
            title:{
                required : true,
            },
            description:{
                required : true,
            },
            time:{
                required : true,
            },
            exam_time:{
                required : true,
            },
            quiz_type:{
                required : true,
            }
           
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
      url: '<?=base_url();?>admin/register/get_subjectss',
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

    setTimeout(function () {
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
}, 1000);


    function getCourseCategories(course_id)
  {
    //alert(exam_id);
    var course_id=$('#course_id').val();
  //  alert(course_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/getCourseCategories',
      data: {course_id: course_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#category_id").html(data);
        $("#wait").css("display", "none");
      }
    });

    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_subject',
      data: {exam_id: course_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#subject_id1").html(data);
        $("#wait").css("display", "none");
      }
    });

  }
  
</script>
