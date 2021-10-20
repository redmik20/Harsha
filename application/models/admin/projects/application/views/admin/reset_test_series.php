<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Reset Test Series</a></li>
  <li><a href="#">reset_test_series</a></li>
  <li class="active">Add reset_test_series</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  
   
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/reset_test_series', $attributes); 
      ?>
      
      
      <div class="panel panel-default">
          
          
          <div class="panel-heading">
            <h2 class="panel-title">Reset Test Series</h2>
          </div>
       <?php if($this->session->flashdata('success') != "") { ?>   
       <div class="row">
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?php echo $this->session->flashdata('success');?>
            </div>
            </div>
          <?php }else if($this->session->flashdata('fail') != "") {?>
            <div class="row">
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?php echo $this->session->flashdata('fail');?>
            </div>
            </div>
          <?php }?>
         
          <div class="panel-body">
              
              <div class="row">
              <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Exams</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="course_id" id="course_id" required="" onchange="getCategoriesOnQuiz(this.value)" >
                  <option value="">Select exams</option>
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
            
            </div>


            
            </br>
   <div class="row">
          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Category</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="category_id" id="category_id" required="" >
                  <option value="">Select Category</option>
                 
                </select>
              </div>
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

  <div class="row">
          <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Quiz Name</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="quiz_id" id="quiz_id" required="" >
                  <option value="">Select Topic Name</option>
                </select>
              </div>
            </div>
   </div>
  <div class="row">
   <div class="form-group">
              <label for="mobile" class="col-md-3 col-xs-12 control-label">Mobile Number</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="number" class="form-control" name="mobile" id="mobile"  />
                </div>
              </div>
            </div>

</div>

<div class="row">
   <div class="form-group">
              <label for="empty" class="col-md-3 col-xs-12 control-label"> </label>
              
              </div>
              </div>


          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/reset_test_series_view" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
            <button type="submit" class="btn btn-primary pull-right" id="btnSubmit">Reset</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<br>

<br>

<!-- END PAGE CONTENT WRAPPER -->
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-validate-additional-methods.js"></script>
<script type="text/javascript">


  $(document).ready(function() { //alert();
    
    $('.editor_cls').each(function() {
      var editor_id = $(this).attr('id');
      CKEDITOR.replace( editor_id, {
          height: 100
        });
    });
    $(document).on('change','#subject_id', function(){
        if(($('#course_id').val())&&($('#category_id').val()) && ($('#subject_id').val())){
          var course_id = $('#course_id').val();
          var category_id = $('#category_id').val();
          var subject_id= $('#subject_id').val();
        }
        $.ajax({
          type: 'post',
          url: '<?=base_url();?>admin/register/get_quiz_topics_info',
        data: {course_id: course_id,category_id:category_id,subject_id:subject_id},
          beforeSend: function(xhr){
            xhr.overrideMimeType("text/plain; charset=x-user-defined");
            $("#wait").css("display", "block");
          },
          success: function(data){ //alert(data);
            $("#quiz_id").html(data);
          $("#wait").css("display", "none");
          }
        });
      });
    
      $("#validation").validate({
          rules: {
            // simple rule, converted to {required:true}            
            mobile: {
                required : true,
            }
          },
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
      
  });
  $(document).ready(function() {
      var max_fields      = 5; //maximum input boxes allowed
      var wrapper         = $(".input_fields_wrap"); //Fields wrapper
      var add_button      = $(".add_field_button"); //Add button ID
      
      var html = $(".input_fields_wrap").html();//alert(html);
      var x = 1; //initlal text box count
      $(add_button).click(function(e){ //on add input button click
          e.preventDefault();
          if(x < max_fields){ //max input box allowed
              x++; //text box increment
              $(wrapper).append('<div class="form-group"><label for="options" class="col-md-3 col-xs-12 control-label">Enter Options</label><div class="col-md-6 col-xs-12"><textarea class="form-control editor_cls" rows="5" name="options[]" id="options'+x+'"></textarea></div><a href="javascript:void(0)" class="remove_field"><span class="" style=" color: red"><i class="fa fa-minus"></i></span></a></div>'); //add input box
              var editor_id = "options"+x;
              CKEDITOR.replace( editor_id, {
                  height: 100
              });
          }
      });
      $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); $(this).parent('div').remove(); x--;
      });

  });

function getCategoriesOnQuiz(chapter_id)
  {
    //alert(exam_id);
    var course_id=$('#course_id').val();
    
    //alert(exam_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/getCategories',
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
        $("#subject_id").html(data);
        $("#wait").css("display", "none");
      }
    });
  }
 
</script>

  


