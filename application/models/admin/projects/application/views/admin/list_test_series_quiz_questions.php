<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="<?php echo base_url('admin/home')?>">Home</a></li>
  <li><a href="<?php echo base_url('admin/register/qbanktopics')?>">Qbank Topics</a></li>
  <li class="active">Qbank Topic Questions List</li>
</ul>
<!-- END BREADCRUMB -->

  <!--<link rel="stylesheet" type="text/css" id="theme" href="<?=base_url();?>assets/css/bootstrap/bootstrap.min.css"/>-->
  <!--<link rel="stylesheet" type="text/css" id="theme" href="<?=base_url();?>assets/css/chosen.css"/>
  <script src="<?=base_url(); ?>assets/js/chosen.jquery.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_testseries_question_order', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Test Series Topic Questions List</h2>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <div class="panel-body">

          <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Topic Name </label>
              <div class="col-md-6 col-xs-12">                
                
                <b><?php echo $topic['title']; ?></b> <b>(<?php echo count($questions_list); ?>)</b>

                <input type="hidden" name="testseries_topic_id" value="<?php echo $testseries_topic_id;?>"></input>
            </div>
          </div>

          <table class="table table-striped">
          <div class="table responsive">
           <thead>
            <tr>
              <th><input type="checkbox" id="checkAll"> Select</th>
              <th>Question Order</th>
              <th>Question ID</th>
              <th>Question </th>
              
              <th>Status </th>
            </tr>
           </thead>
              <tbody>
              <?php if(!empty($questions_list)){
                foreach($questions_list as $row){?>
                  <tr>
                      <td><input type="checkbox" name="question_ids[]" id="checkboxes" value="<?php echo $row['id']?>"></input></td>
                      <td><input type="text" name="que[<?php echo $row['id']?>]" value="<?php echo $row['que_number']?>" ></input></td>
                     <td><?php //echo $small = substr($row['question'], 0, 300);  
                            echo $row['question_dynamic_id'];
                       ?></td>

                       <td><?php //echo $small = substr($row['question'], 0, 300);  
                            echo $row['question'];
                       ?></td>

                    <td>
                <?php if($row['status'] == "Active") { ?>
                    <a title="Click to Inactive" 
                    href="<?php echo base_url().'admin/register/change_test_series_question_status/'.$row['id'].'/Inactive/'.$testseries_topic_id ?>" class="btn btn-success btn-condensed">ON</a>
               <?php }else {?>
                    <a title="Click to Active" href="<?php echo base_url().'admin/register/change_test_series_question_status/'.$row['id'].'/Active/'.$testseries_topic_id ?>" class="btn btn-danger btn-condensed">OFF</a>
                 <?php } ?>

                    </td>

                  </tr>
                  <?php }
                   }?>

              </tbody>
              </div> 
           </table>             
              
                      <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Copy Questions</h4>
        </div>

        <div class="modal-body">
        
          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Courses</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="course_id" id="course_id" required="" onchange="getSubjects(this.value)">
                  <option value="">Select Course</option>
                  <?php
                  if(!empty($exams))
                  {
                    foreach($exams as $exam)
                    {
                      ?>
                      <option value="<?=$exam['id'];?>"><?=$exam['name'];?></option>
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
                <select class="form-control" name="subject_id" id="subject_id" required="" >
                  <option value="">Select Subjects</option>
                </select>
              </div>
            </div>


            <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Copy Category</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="category_id" id="category_id" required="" onchange="getQuizTopics(this.value)">
                  <option value="">Select Category</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Copy Quiz</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="quiz_id" id="quiz_id" required="">
                  <option value="">Select Quiz</option>
                </select>
              </div>
              </div>
        </div>

        <input type="hidden" name="copy" value="copy">
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" value="copy" onclick="return copycheck()" id="btnSubmit">Copy</button>
          <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
        </div>
       
      </div>
      
    </div>
  </div>
  <!-- end modal -->

  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Move Questions</h4>
        </div>

        <div class="modal-body">
        
          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Courses</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="move_course_id" id="move_course_id" required="" onchange="getSubjects_move(this.value)">
                  <option value="">Select Course</option>
                  <?php
                  if(!empty($exams))
                  {
                    foreach($exams as $exam)
                    {
                      ?>
                      <option value="<?=$exam['id'];?>"><?=$exam['name'];?></option>
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
                <select class="form-control" name="move_subject_id" id="move_subject_id" required="" >
                  <option value="">Select Subjects</option>
                </select>
              </div>
            </div>


            <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Move Category</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="move_category_id" id="move_category_id" required="" onchange="getQuizTopics_move(this.value)">
                  <option value="">Select Category</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Move Quiz</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="move_quiz_id" id="move_quiz_id" required="">
                  <option value="">Select Quiz</option>
                </select>
              </div>
              </div>
        </div>

        <input type="hidden" name="move" value="move">
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" value="copy" onclick="return movecheck()"  id="btnSubmit">Move</button>
          <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
        </div>
       
      </div>
      
    </div>
  </div>
  <!-- end modal -->

          </div>
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/qbanktopics" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a> 
            <button type="submit" class="btn btn-primary pull-right" id="btnSubmit">Update Order</button>   
            <button type="button"  class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal" style="margin-right:10px;" >Copy Questions</button>  

            <button type="button"  class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal1" style="margin-right:10px;" >Move Questions</button>            
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
 
 $(".chosen-select1").chosen();
 $(".chosen-select2").chosen();
 $(".chosen-select3").chosen();
 $(".chosen-select4").chosen();
/*$('button').click(function(){
        $(".chosen-select1").val('').trigger("chosen:updated");
});*/

$("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});

function getMultipleSubjects(){
var course_ids = $('#course_id').val();
var package_id = $('#package_id').val();
  //alert(values);
  $.ajax({ 
           type: "POST", 
           url: '<?php echo base_url();?>admin/register/getupdateMultipleSubjects', 
           data: "course_ids="+course_ids+"&package_id="+package_id,
           complete: function(data){  
            var op = data.responseText.trim();
            $("#video_subject_ids").html(op);
            $("#qbank_subject_ids").html(op);
            $(".chosen-select2").chosen();
            $(".chosen-select2").val('').trigger("chosen:updated");
           //$(".chosen-select2").find('option').map(function() { return this.value }).get().join();
            $(".chosen-select3").val('').trigger("chosen:updated");
               }
     });

  $.ajax({ 
           type: "POST", 
           url: '<?php echo base_url();?>admin/register/getMultipleTestseries', 
           data: "course_ids="+course_ids,
           complete: function(data){  
            var op = data.responseText.trim();
            $("#test_series_ids").html(op);
            $(".chosen-select4").val('').trigger("chosen:updated");
               }
     });

}
function getSubjects(exam_id)
  {
    //alert(exam_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_subject',
      data: {exam_id: exam_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#subject_id").html(data);
        $("#wait").css("display", "none");
      }
    });

$.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_test_series_categories',
      data: {exam_id: exam_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#category_id").html(data);
        $("#wait").css("display", "none");
      }
    });

  }

  function getQuizTopics(category_id){
     var exam_id=$("#course_id").val();
     var subject_id=$("#subject_id").val();
       $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_quiz_topics_info',
      data: {course_id: exam_id,category_id: category_id,subject_id: subject_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#quiz_id").html(data);
        $("#wait").css("display", "none");
      }
    });
  }



  function getSubjects_move(exam_id)
  {
    //alert(exam_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_subject',
      data: {exam_id: exam_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#move_subject_id").html(data);
        $("#wait").css("display", "none");
      }
    });

$.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_test_series_categories',
      data: {exam_id: exam_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#move_category_id").html(data);
        $("#wait").css("display", "none");
      }
    });



  }

  function getQuizTopics_move(category_id){
     var exam_id=$("#move_course_id").val();
     var subject_id=$("#move_subject_id").val();
       $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_quiz_topics_info',
      data: {course_id: exam_id,category_id: category_id,subject_id:subject_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#move_quiz_id").html(data);
        $("#wait").css("display", "none");
      }
    });
  }

  function copycheck(){

  var checked_ids=$('[name="question_ids[]"]:checked').length;
  if(checked_ids == 0){
            alert("Please select Any checkbox");
            return false;
      }
      return true;

 }

 function movecheck(){


  var checked_ids=$('[name="question_ids[]"]:checked').length;
  if(checked_ids == 0){
            alert("Please select Any checkbox");
            return false;
      }
      return true;

 }
</script>




