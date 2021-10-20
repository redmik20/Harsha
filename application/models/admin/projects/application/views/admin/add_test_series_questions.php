<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">test_series_questions</a></li>
  <li class="active">Add test_series_questions</li>
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
            <h2 class="panel-title">Add  Test Series questions</h2>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <?php if(count($ids)>0){?>
           <div class="form-group">
           <input type="hidden" class="form-control" value="<?php echo $ids[0]->id;?>" name="quiz_id" id="quiz_id" />
           <input type="hidden" class="form-control" value="<?php echo $ids[0]->course_id;?>" name="course_id" id="course_id" />
           <input type="hidden" class="form-control" value="<?php echo $ids[0]->category_id;?>" name="category_id" id="category_id" />
           <input type="hidden" class="form-control" value="<?php echo $ids[0]->subject_id;?>" name="subject_id" id="subject_id" />
           <input type="hidden" class="form-control" value="<?php echo $ids[0]->title;?>" name="title" id="title" />
          </div>
        <?php  } else { ?>
          <div class="panel-body">
              
              <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Exams</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="course_id" id="course_id" required="" onchange="getCategoriesOnQuiz(this.value)">
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
   
          <div class="form-group">
              <label for="tscat" class="col-md-3 col-xs-12 control-label">Category</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="category_id" id="category_id" required="" >
                  <option value="">Select Category</option>
                  
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="tscat" class="col-md-3 col-xs-12 control-label">Subject</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="subject_id" id="subject_id" required="" >
                  <option value="">Select Subject</option>
                  <?php
                  /*if(!empty($subjects))
                  {
                    foreach($subjects as $subject)
                    {
                      ?>
                      <option value="<?=$subject->id;?>"><?=$subject->subject_name;?></option>
                      <?php
                    }
                  }*/
                  ?>
                </select>
              </div>
            </div>
          

          <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Quiz Name</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="quiz_id" id="quiz_id" required="" >
                  <option value="">Select Topic Name</option>
                </select>
              </div>
            </div>


    <?php } ?>
<!-- 
          <div class="form-group">
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
                  <option value="single">Single</option>
                  <option value="multiple">Multiple</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Math Formula Exists</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="math_library" id="math_library" required="" >
                  <option value="no">No</option>
                  <option value="yes">Yes</option>
                </select>
              </div>
            </div>
   <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Question Number</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="number" class="form-control" name="que_number" id="que_number"  />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Question</label>
              <div class="col-md-6 col-xs-12">                      
                <textarea class="form-control" rows="5" name="question" id="question"></textarea>
              </div>
            </div>

            <!--<div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Question Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="questionimage" id="questionimage"  />
                </div>
              </div>
            </div>-->

            <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Question Image Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="questionimage" id="questionimage"  />
                </div>
              </div>
            </div>

            <div class="input_fields_wrap gray points-cont">
              <div class="form-group">
                <label for="options" class="col-md-3 col-xs-12 control-label">Enter Option 1</label>
                <div class="col-md-6 col-xs-12">
                  <textarea class="form-control  dataa" rows="5" name="options[]" id="options1"></textarea>                  
                </div>
              </div>
            </div>

            <!--<div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Upload Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="optionimages[]" id="optionimage1"  />
                </div>
              </div>
            </div>-->

            <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Image Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="optionimages[]" id="optionimage1"  />
                </div>
              </div>
            </div>

            <div class="input_fields_wrap gray points-cont">
              <div class="form-group">
                <label for="options" class="col-md-3 col-xs-12 control-label">Enter Option 2</label>
                <div class="col-md-6 col-xs-12">
                  <textarea class="form-control  dataa" rows="5" name="options[]" id="options2"></textarea>                  
                </div>
              </div>
            </div>

            <!--<div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Upload Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="optionimages[]" id="optionimage2"  />
                </div>
              </div>
            </div>-->

             <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Image Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="optionimages[]" id="optionimage2"  />
                </div>
              </div>
            </div>

            <div class="input_fields_wrap gray points-cont">
              <div class="form-group">
                <label for="options" class="col-md-3 col-xs-12 control-label">Enter Option 3</label>
                <div class="col-md-6 col-xs-12">
                  <textarea class="form-control  dataa" rows="5" name="options[]" id="options3"></textarea>                  
                </div>
              </div>
            </div>

            <!--<div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Upload Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="optionimages[]" id="optionimage3"  />
                </div>
              </div>
            </div>-->

            <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Image Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="optionimages[]" id="optionimage3"  />
                </div>
              </div>
            </div>

            <div class="input_fields_wrap gray points-cont">
              <div class="form-group">
                <label for="options" class="col-md-3 col-xs-12 control-label">Enter Option 4</label>
                <div class="col-md-6 col-xs-12">
                  <textarea class="form-control  dataa" rows="5" name="options[]" id="options4"></textarea>                  
                </div>
              </div>
            </div>

            <<!--div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Upload Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="optionimages[]" id="optionimage4"  />
                </div>
              </div>
            </div>-->

            <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Image Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="optionimages[]" id="optionimage4"  />
                </div>
              </div>
            </div>

            
          
            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Solution</label>
              <div class="col-md-6 col-xs-12">                      
                <textarea class="form-control " rows="5" name="explanation" id="explanation"></textarea>
              </div>
            </div>

            <!--<div class="form-group">
              <label for="explanationimage" class="col-md-3 col-xs-12 control-label">Explanation Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="explanationimage" id="explanationimage"  />
                </div>
              </div>
            </div>-->
            <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Explanation Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="explanationimage" id="explanationimage"  />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Reference</label>
              <div class="col-md-6 col-xs-12">                      
                <textarea class="form-control " rows="5" name="reference" id="reference"></textarea>
              </div>
            </div>
            
            
           <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Marks pattern for Positive and Negative</label>
              <div class="col-md-6 col-xs-12">
               
               
                <input class="" type="radio"  value="simple" checked 
                onchange="changeanstype(this.value)">
                <label for="yes">Marks :  1 and 0</label>
                
                 </br>
               
                <input class="" type="radio" value="multiple"
                onchange="changeanstype(this.value)">
                <label for="yes">Marks :  4 and 0</label>
                
                 </br>
                 
                 <input class="" type="radio"   value="single" 
                onchange="changeanstype(this.value)">
                <label for="no">Marks : 4 and -1</label>
                  
                   
              </div>
            </div> 

             <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Positive Marks</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="number" class="form-control" name="positive_marks" id="positive_marks" value=1 />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Negative Marks</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="number" class="form-control" name="negative_marks" id="negative_marks" value= 0 />
                </div>
              </div>
            </div>
            
            <div class="form-group" id="single">
              <label for="answer" class="col-md-3 col-xs-12 control-label">Enter Answer</label>
              <div class="col-md-6 col-xs-12">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="answer" id="answer" placeholder="EX: A" />
              </div>
            </div>

            
       <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/test_series_questions" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
            <button type="submit" class="btn btn-primary pull-right" id="btnSubmit">Submit And Continue</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- END PAGE CONTENT WRAPPER -->
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-validate-additional-methods.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML">

function changeanstype(val){
 //alert(val);
 
 if(val == 'simple'){


   document.getElementById('negative_marks').value=0
    document.getElementById('positive_marks').value=1


 }else if(val == 'single'){


   document.getElementById('negative_marks').value=-1
    document.getElementById('positive_marks').value=4


 }else if(val == 'multiple'){

      document.getElementById('negative_marks').value=0
    document.getElementById('positive_marks').value=4

 }
}
  $(document).ready(function() { //alert();
    
    $('.editor_cls').each(function() {
      var editor_id = $(this).attr('id');
     
      CKEDITOR.replace( editor_id, {
            extraPlugins: 'mathjax',
             mathJaxLib: 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML',
             height: 100
        });
    });
    $(document).on('change','#subject_id', function(){
        if(($('#course_id').val())&&($('#category_id').val())){
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
            question: {
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
                    extraPlugins: 'mathjax',
      mathJaxLib: 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML',
    
                  height: 100
              });
          }
      });
      $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); $(this).parent('div').remove(); x--;
      });

  });


  function getCategoriesOnQuiz()
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
<script>
     initSample7(); 
     initSample8();
     initSample9(); 
     initSample10(); 
     initSample11();
     initSample12();
     initSample13();
</script>
  


