<!-- START BREADCRUMB -->
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url();?>assets/css/questionbank.css"/>

<script src="<?php echo base_url(); ?>assets/js/questionbank.js"></script>
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">quiz_questions</a></li>
  <li class="active">Edit quiz_questions</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_quiz_questions', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Edit Question Bank Questions</h3>            
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
                <select class="form-control" name="course_id" id="course_id" required="" onchange="getss(this.value)">
                  <!--<option value="<?=$questions->course_id; ?>"><?=$questions->course_name; ?></option>-->
                  <?php foreach($courses as $cour){?>
                  
                  <option value="<?php echo $cour->id?>" <?php if($cour->id == $questions->course_id){ ?> selected <?php } ?> ><?php echo $cour->name?></option>
                  <?php 
                  }?>
                </select>
              </div>
            </div>
   
          <div class="form-group">
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Select Subject</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="subject_id" id="subject_id" required="" onchange="getqbankchapters(this.value)">
                 <!-- <option value="<?=$questions->subject_id; ?>"><?=$questions->sname; ?></option>-->
                 <?php foreach($subjects as $sub){?>
                  
                  <option value="<?php echo $sub['id']?>" <?php if($sub['id'] == $questions->subject_id){ ?> selected <?php } ?> ><?php echo $sub['subject_name']?></option>
                  <?php 
                  }?>
                </select>
              </div>
            </div>
          

          <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Select Chapter</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="topic_id" id="topic_id" required="" onchange="getqbanktopics1(this.value)">
                <!--<option value="<?=$questions->topic_id; ?>"><?=$questions->qtname; ?></option>-->
                <?php foreach($qbankChapters as $chap){?>
                  
                  <option value="<?php echo $chap['id']?>" <?php if($chap['id'] == $questions->topic_id){ ?>selected <?php } ?> ><?php echo $chap['topic_name']?></option>
                  <?php 
                  }?>

                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Select Topic</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="qbanktopic_id" id="qbanktopic_id" required="" >
                <!--<option value="<?=$questions->qbank_topic_id; ?>"><?=$questions->qbanktopicname; ?></option>-->
                <?php foreach($qbankTopics as $topic){?>
                  
                  <option value="<?php echo $topic['id']?>" <?php if($topic['id'] == $questions->qbank_topic_id){ ?>selected <?php } ?> ><?php echo $topic['name']?></option>
                  <?php 
                  }?>
                </select>
              </div>
            </div>

             <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Math Formula Exists</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="math_library" id="math_library" required="" >
                  <option value="no" <?php if($questions->math_library == 'no'){ ?>  selected <?php } ?> >No</option>
                  <option value="yes" <?php if($questions->math_library == 'yes'){ ?>  selected <?php } ?> >Yes</option>
                </select>
              </div>
            </div>

    

         
            <div class="form-group">
              <label for="question" class="col-md-3 col-xs-12 control-label">Question</label>
              <div class="col-md-6 col-xs-12">                      
                <textarea class="form-control" rows="5" required="" name="question" id="content" value=""><?=$questions->question; ?></textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Question Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <!--<input type="file" class="fileinput btn-primary" name="questionimage" id="questionimage"  />-->
                  <input type="text" class="form-control" name="questionimage" id="questionimage"  value="<?php echo $questions->question_image;?>" />
                </div>
              </div>
              <?php if($questions->question_image){ ?><img src="<?=base_url().$questions->question_image;?>" height="50" width="50"><?php } ?>
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
                      <textarea class="form-control" rows="5" name="options[]" id="options<?=$i; ?>"><?=$option['options'];?></textarea>
                    </div>
                    <?php
                      ?>
                      
                      <?php
                    ?>
                  </div>
                  <div class="form-group">
                    <label for="image" class="col-md-3 col-xs-12 control-label">Upload Image</label>
                    <div class="col-md-6 col-xs-12">
                      <div class="">
                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                        <!--<input type="file" class="fileinput btn-primary" name="optionimages[]" id="optionimage<?=$i; ?>"  />-->
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
              <label for="answer" class="col-md-3 col-xs-12 control-label">Enter Answer</label>
              <div class="col-md-6 col-xs-12">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="answer" id="answer" required="" placeholder="EX: A" value="<?=$questions->answer;?>" />
              </div>
            </div>
          
            <div class="form-group">
              <label for="explanation" class="col-md-3 col-xs-12 control-label">Explanation</label>
              <div class="col-md-6 col-xs-12">                      
                <textarea class="form-control" rows="5" required="" name="explanation" id="explanation" ><?=$questions->explanation;?></textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="explanationimage" class="col-md-3 col-xs-12 control-label">Explanation Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <!--<input type="file" class="fileinput btn-primary" name="explanationimage" id="explanationimage"  />-->
                  <input type="text" class="form-control" name="explanationimage" id="explanationimage"  value="<?php echo $questions->explanation_image;?>" />
                </div>
              </div>
              <?php if($questions->explanation_image){ ?><img src="<?=base_url().$questions->explanation_image;?>" height="50" width="50"><?php } ?>
            </div>

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Reference</label>
              <div class="col-md-6 col-xs-12">                      
                <textarea class="form-control" rows="5"  name="reference" id="reference" ><?=$questions->reference;?></textarea>
              </div>
            </div>


             <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Difficult level</label>
              <div class="col-md-6 col-xs-12">
               
               
                <input class="" type="radio" name="difficult_level" value="easy" <?php if($questions->difficult_level == 'easy'){?> checked <?php } ?> >
                <label for="yes">Easy</label>
                
                 </br>
               
                <input class="" type="radio" name="difficult_level" value="medium" <?php if($questions->difficult_level == 'medium'){?> checked <?php } ?> >
                <label for="yes">Medium</label>
                
                 </br>
                 
                 <input class="" type="radio"  name="difficult_level" value="hard" <?php if($questions->difficult_level == 'hard'){?> checked <?php } ?> >
                <label for="no">Hard</label>
                  
                   
              </div>
            </div> 

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Tags </label>
                <div class="col-md-6 col-xs-12">                
                 
                 <input type="text" name="tags" class="form-control" value="<?php echo $questions->tags?>" data-role="tagsinput" />


                </div>
              </div>

              <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Previous Appearance </label>
                <div class="col-md-6 col-xs-12">                
                 <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                 <input type="text" name="previous_appearance" class="form-control" value="<?php echo $questions->previous_appearance;?>" />


                </div>
              </div>

              <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Question Order No</label>
                <div class="col-md-6 col-xs-12">                
                 <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                 <input type="text" name="question_order_no" class="form-control" value="<?php echo $questions->question_order_no;?>" required="" />


                </div>
              </div>
            <!-- <a href="javascript:void(0)" class="add_field_button"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a> -->
            
          <input type="hidden" name="quiz_questions_id" id="quiz_questions_id" value="<?=$questions->id;?>">
              
          <div class="panel-footer">
            <!-- <button class="btn btn-default">Clear Form</button> -->
            <a href="<?=base_url();?>admin/register/quiz_questions" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>            
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
</script>


<script>
  $(document).ready(function() { //alert();
      
    $(document).on('change', '#subject_id', function() {
      
        var course_id=$("#course_id").val();
        var subject_id=$("#subject_id").val();
        $.ajax({
        type: 'post',
        url: '<?=base_url();?>admin/register/get_topicinfo',
       data: {course_id: course_id,subject_id:subject_id},
        beforeSend: function(xhr){
          xhr.overrideMimeType("text/plain; charset=utf-8");
          $("#wait").css("display", "block");
        },
        success: function(data){ //alert(data);
          $("#topic_id").html(data);
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
 
</script>

<script type="text/javascript">
$('.editor_cls').each(function() {
  var editor_id = $(this).attr('id');
  CKEDITOR.replace( editor_id, {
      height: 100
    });
});
</script>

<script>
  $(document).ready(function() {
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

  function getqbanktopics1(chapter_id)
  {
    //alert(exam_id);
    var course_id=$('#course_id').val();
    var subject_id=$('#subject_id').val();
    //alert(exam_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/getQbankTopics',
      data: {course_id: course_id,subject_id: subject_id,chapter_id: chapter_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#qbanktopic_id").html(data);
        $("#wait").css("display", "none");
      }
    });
  }

</script>
 <script>
    initSample(); 
     initSample1();
     initSample2();
     initSample3();
     initSample4();
     initSample5();
     initSample6();
  </script>


