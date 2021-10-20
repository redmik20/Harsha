
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">quiz_questions</a></li>
  <li class="active">Add quiz_questions</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_pearl_to_question', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Edit Flash Card</h2>            
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
                  
                  <?php 
                  /*foreach($courses as $cour){?>
                  
                  <option value="<?php echo $cour->id?>" <?php if($cour->id == $pearl['course_id']){ ?> selected <?php } ?> ><?php echo $cour->name?></option>
                  <?php 
                  }*/?>
                  <option value="<?php echo $pearl['course_id']?>"><?php echo $pearl['course_name']?></option>

                </select>
              </div>
            </div>
   
          <div class="form-group">
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Select Subject</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="subject_id" id="subject_id" required="" onchange="getqbankchapters(this.value)">
                
                 <?php 
                 
                 /*foreach($subjects as $sub){?>
                  <option value="<?php echo $sub['id']?>" <?php if($sub['id'] == $pearl['subject_id']){ ?> selected <?php } ?> ><?php echo $sub['subject_name']?></option>
                  <?php 
                  }*/?>

                   <option value="<?php echo $pearl['subject_id']?>"><?php echo $pearl['sname']?>
                </select>
              </div>
            </div>
          

          <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Select Chapter</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="topic_id" id="topic_id" required="" onchange="getqbanktopics1(this.value)">
               
                <?php 
      
                  /*foreach($qbankChapters as $chap){?>
                  <option value="<?php echo $chap['id']?>" <?php if($chap['id'] == $pearl['chapter_id']){ ?>selected <?php } ?> ><?php echo $chap['topic_name']?></option>
                  <?php 
                  }*/
                 ?>

                  <option value="<?php echo $pearl['chapter_id']?>"><?php echo $pearl['qtname']?>

                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Select Topic</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="qbanktopic_id" id="qbanktopic_id" required="" >
               
                <?php 
               
                /*foreach($qbankTopics as $topic){?>
                  
                  <option value="<?php echo $topic['id']?>" <?php if($topic['id'] == $pearl['topic_id']){ ?>selected <?php } ?> ><?php echo $topic['name']?></option>
                  <?php 
                  }*/?>

                  <option value="<?php echo $pearl['topic_id']?>"><?php echo $pearl['qbanktopicname']?>

                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Title</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="title" id="title" value="<?php echo $pearl['title']?>" />
                </div>
              </div>
            </div>

          <div class="form-group">
              <label for="icon_image" class="col-md-3 col-xs-12 control-label">Icon Image Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="icon_image" value="<?php echo $pearl['icon_image_path']?>" id="icon_image"  />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Explanation</label>
              <div class="col-md-6 col-xs-12" >                      
                <textarea class="form-control editor_cls" rows="5" name="explanation" id="content" required=""><?php echo $pearl['explanation']?></textarea>
              </div>
            </div>

          
            <input type="hidden" class="form-control" name="pearl_id" value="<?php echo $pearl['id']?>" id="pearl_id"  />

           

            <!-- <a href="javascript:void(0)" class="add_field_button"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a> -->
            
          

          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/pearls" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
          <button type="submit" class="btn btn-primary pull-right" id="btnSubmit" style="margin-left:10px;" >Submit </button>
          
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
          xhr.overrideMimeType("text/plain; charset=x-user-defined");
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
        xhr.overrideMimeType("text/plain; charset=x-user-defined");
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


