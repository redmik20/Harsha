
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">test_series_questions</a></li>
  <li class="active">Edit test_series_questions</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_test_series_questions', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Edit Test Series Questions </h3>            
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
                <select class="form-control" name="course_id" id="course_id" required="" >
                  <?php
                  if(!empty($question))
                  {
                      ?>
                      <option value="<?=$question->course_id;?>"><?=$question->course_name;?></option>
                      <?php
                  }
                  ?>
                </select>
              </div>
            </div>
   
          <div class="form-group">
              <label for="tscat" class="col-md-3 col-xs-12 control-label">Category</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="category_id" id="category_id" required="" >
                <?php
                  if(!empty($question))
                  {
                      ?>
                      <option value="<?=$question->category_id;?>"><?=$question->cat_name;?></option>
                      <?php
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Subject</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="subject_id" id="subject_id" required="" >
                  <?php
                  if(!empty($question))
                  {
                      ?>
                      <option value="<?=$question->subject_id;?>"><?=$question->subject_name;?></option>
                      <?php
                  }
                  ?>
                </select>
              </div>
            </div>
          

          <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Quiz Name</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="quiz_id" id="quiz_id" required="" >
                <?php
                  if(!empty($question))
                  {
                      ?>
                      <option value="<?=$question->quiz_id;?>"><?=$question->tname;?></option>
                      <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            
             
     <!--     <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Subject</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="subject_id" id="subject_id" required="" >
                  <?php
                  if(!empty($question))
                  {
                      ?>
                      <option value="<?=$question->subject_id;?>"><?=$question->subject_name;?></option>
                      <?php
                  }
                  ?>
                </select>
              </div>
            </div>
    -->

          <!-- <div class="form-group">
              <label for="question" class="col-md-3 col-xs-12 control-label">Upload Xml File</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="question" id="question" />
                </div>
              </div>
            </div> -->

              <div class="form-group">
              <label for="tscat" class="col-md-3 col-xs-12 control-label">Question Type</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="question_type" id="question_type" >
                  <option value="single" <?php if($question->question_type == 'single'){ echo 'selected'; }?> >Single</option>
                  <option value="multiple" <?php if($question->question_type == 'multiple'){ echo 'selected'; }?>>Multiple</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Math Formula Exists</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="math_library" id="math_library" required="" >
                  <option value="no" <?php if($question->math_library == 'no'){ ?>  selected <?php } ?> >No</option>
                  <option value="yes" <?php if($question->math_library == 'yes'){ ?>  selected <?php } ?> >Yes</option>
                </select>
              </div>
            </div>

     <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Question Number</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="number" class="form-control" name="que_number" id="que_number" value="<?=$question->que_number;?>" />
                </div>
              </div>
            </div>

            
            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Question</label>
              <div class="col-md-6 col-xs-12">                      
                <textarea class="form-control " rows="5" name="question" id="question" value=""><?=$question->question; ?></textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Question Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <!-- <input type="file" class="fileinput btn-primary" name="questionimage" id="questionimage"  /> -->
                  <input type="text" class="form-control" name="questionimage" id="questionimage"  value="<?php echo $question->question_image;?>" />
                </div>
              </div>
              <?php if($question->question_image){ ?><img src="<?=base_url().$question->question_image;?>" height="50" width="50"><?php } ?>
            </div>

            <div class="input_fields_wrap gray points-cont">
              <?php
              if(!empty($options))
              {$i=0;
                foreach($options as $option)
                {$i++;
                  ?>
                  <div class="form-group">
                    <label for="options" class="col-md-3 col-xs-12 control-label">Enter Option <?=$i; ?></label>
                    <div class="col-md-6 col-xs-12">                
                      <textarea class="form-control " rows="5" name="options[]" id="options<?=$i; ?>"><?=$option['options'];?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="image" class="col-md-3 col-xs-12 control-label">Upload Image</label>
                    <div class="col-md-6 col-xs-12">
                      <div class="">
                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                        <!-- <input type="file" class="fileinput btn-primary" name="optionimages[]" id="optionimage<?=$i; ?>"  /> -->
                        <input type="text" class="form-control " name="optionimages[]" id="optionimage<?=$i; ?>" value="<?php echo $option['image'];?>" />
                      </div>
                    </div>
                    <?php if($option['image']){ ?><img src="<?=base_url().$option['image'];?>" height="50" width="50"><?php } ?>
                  </div>
                  <?php
                }
              }
              ?>
            </div>

           
          
            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Solution</label>
              <div class="col-md-6 col-xs-12">                      
                <textarea class="form-control " rows="5" name="explanation" id="explanation"><?=$question->explanation;?></textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="explanationimage" class="col-md-3 col-xs-12 control-label">Explanation Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <!-- <input type="file" class="fileinput btn-primary" name="explanationimage" id="explanationimage"  /> -->
                  <input type="text" class="form-control" name="explanationimage" id="explanationimage"  value="<?php echo $question->explanation_image;?>" />
                </div>
              </div>
              <?php if($question->explanation_image){ ?><img src="<?=base_url().$question->explanation_image;?>" height="50" width="50"><?php } ?>
            </div>

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Reference</label>
              <div class="col-md-6 col-xs-12">                      
                <textarea class="form-control " rows="5" name="reference" id="reference"><?=$question->reference;?></textarea>
              </div>
            </div>

             <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Positive Marks</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="number" class="form-control" name="positive_marks" id="positive_marks"  value="<?=$question->positive_marks;?>" />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Negative Marks</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="number" class="form-control" name="negative_marks" id="negative_marks"    value="<?=$question->negative_marks;?>" />
                </div>
              </div>
            </div>

             <div class="form-group">
              <label for="answer" class="col-md-3 col-xs-12 control-label">Enter Answer</label>
              <div class="col-md-6 col-xs-12">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="answer" id="answer" placeholder="EX: A"  value="<?=$question->answer;?>"/>
              </div>
            </div>
            
        

            <!-- <a href="javascript:void(0)" class="add_field_button"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a> -->
            
          <input type="hidden" name="test_series_questions_id" value="<?=$question->id;?>">
     
              
          <div class="panel-footer">
            <!-- <button class="btn btn-default">Clear Form</button> -->
            <a href="<?=base_url();?>admin/register/test_series_questions" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>            
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
            question: {
                 required : true,
             },
             answer: {
                 required : true,
             },
             explanation: {
                 required : true,
             },
             "options[]": {
              required : true,
            }
          },
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
      
  }); 


  $(document).ready(function()
  {
      var max_fields      = 5; //maximum input boxes allowed
      var wrapper         = $(".input_fields_wrap"); //Fields wrapper
      var add_button      = $(".add_field_button"); //Add button ID
      
      var html = $(".input_fields_wrap").html();//alert(html);
      var x = $('.input_fields_wrap .form-group').length;//alert(x);
      if(x == 0)
      {
        var x = 1;
      }
      //var x = 1; //initlal text box count
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
</script>
<script type="text/javascript">
$('.editor_cls').each(function() {
  var editor_id = $(this).attr('id');
  CKEDITOR.replace( editor_id, {
      height: 100
    });
});
</script>


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
    $(document).on('change','#category_id', function(){
        if(($('#course_id').val())&&($('#category_id').val())){
          var course_id = $('#course_id').val();
          var category_id = $('#category_id').val();
        }
        $.ajax({
          type: 'post',
          url: '<?=base_url();?>admin/register/get_quiz_topics_info',
        data: {course_id: course_id,category_id:category_id},
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

</script>
<script>
     initSample7(); 
     initSample8();
     initSample9(); 
     initSample10(); 
     initSample11();
     initSample12();
     initSample13();
</script>

