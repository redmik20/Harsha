<!-- START BREADCRUMB -->
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url();?>assets/css/questionbank.css"/>

<script src="<?php echo base_url(); ?>assets/js/questionbank.js"></script>
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">quiz_questions</a></li>
  <li class="active">Add quiz_questions</li>
</ul>
<!-- END BREADCRUMB -->
<?php if($this->session->flashdata('error') != "") : ?>                
  <div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <?=$this->session->flashdata('error');?>
  </div>
<?php endif; ?> 

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
            <h2 class="panel-title">Add Question Bank Questions</h2>            
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
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Select Subject</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="subject_id" id="subject_id" required="" onchange="get_topics()">
                  <option value="">Select Subject</option>
                </select>
              </div>
            </div>
          

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Select Chapter</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="topic_id" id="topic_id" required=""  onchange="getqbanktopics1(this.value)">
                  <option value="">Select Chapter</option>
                  
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Select Topic</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="qbanktopic_id" id="qbanktopic_id" required="" >
                  <option value="">Select Topic</option>
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
              <label class="col-md-3 col-xs-12 control-label">Question</label>
              <div class="col-md-6 col-xs-12" >                      
                <textarea class="form-control editor_cls" rows="5" name="question" id="content" required=""></textarea>
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
                  <textarea class="form-control editor_cls dataa" rows="5" name="options[]" id="options1"></textarea>                  
                </div>
              </div>
            </div>

           <!-- <div class="form-group">
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
                  <textarea class="form-control editor_cls dataa" rows="5" name="options[]" id="options2"></textarea>                  
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
                  <textarea class="form-control editor_cls dataa" rows="5" name="options[]" id="options3"></textarea>                  
                </div>
              </div>
            </div>

            <!--<div class="form-group">
              <label for="optionimage3" class="col-md-3 col-xs-12 control-label">Upload Image</label>
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
                  <textarea class="form-control editor_cls dataa" rows="5" name="options[]" id="options4"></textarea>                  
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="questionimage" class="col-md-3 col-xs-12 control-label">Image Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="optionimages[]" id="optionimage4"  />
                </div>
              </div>
            </div>

           <!-- <div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Upload Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="optionimages[]" id="optionimage4"  />
                </div>
              </div>
            </div>-->

            <div class="form-group">
              <label for="answer" class="col-md-3 col-xs-12 control-label">Enter Answer</label>
              <div class="col-md-6 col-xs-12">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="answer" id="answer" placeholder="EX: A" required="" />
              </div>
            </div>
          
            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Solution</label>
              <div class="col-md-6 col-xs-12">                      
                <textarea class="form-control editor_cls" rows="5" name="explanation" id="explanation" required=""></textarea>
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
                <textarea class="form-control editor_cls" rows="5" name="reference" id="reference" ></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Difficult Level</label>
              <div class="col-md-6 col-xs-12">
               
               
                <input class="" type="radio" name="difficult_level" value="easy" checked >
                <label for="yes">Easy</label>
                
                 </br>
               
                <input class="" type="radio" name="difficult_level" value="medium">
                <label for="yes">Medium</label>
                
                 </br>
                 
                 <input class="" type="radio"  name="difficult_level" value="hard">
                <label for="no">Hard</label>
                  
                   
              </div>
            </div> 

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Tags </label>
                <div class="col-md-6 col-xs-12">                
                 
                 <input type="text" name="tags" class="form-control" value="" data-role="tagsinput" />


                </div>
              </div>

              <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Previous Appearance </label>
                <div class="col-md-6 col-xs-12">                
                 <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                 <input type="text" name="previous_appearance" class="form-control" value="" />


                </div>
              </div>

              <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Question Order No </label>
                <div class="col-md-6 col-xs-12">                
                 <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                 <input type="text" name="question_order_no" class="form-control" value="" required="" />


                </div>
              </div>

            <!-- <a href="javascript:void(0)" class="add_field_button"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a> -->
            
          

          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/quiz_questions" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
          <button type="submit" class="btn btn-primary pull-right" id="btnSubmit" style="margin-left:10px;" >Submit with out FlashCard</button>
          <button type="submit" class="btn btn-primary pull-right" name="pearl" value="pearl" id="btnSubmit">Submit with FlashCard</button>
          
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
 
</script>

<script type="text/javascript">
// $('.editor_cls').each(function() {
//   var editor_id = $(this).attr('id');
//   CKEDITOR.replace( editor_id, {
//       height: 100
//     });
// });
</script>

<script>
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


