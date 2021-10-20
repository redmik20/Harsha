<!-- START BREADCRUMB -->
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
      echo form_open_multipart('admin/register/submit_bulk_upload_quiz_questions', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Add Chapter Quiz questions</h2>            
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
                <select class="form-control" name="course_id" id="course_id" required="" onchange="getss(this.value)">
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
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Subjects</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="subject_id" id="subject_id" required="" onchange="get_topics()">
                  <option value="">Select Subjects</option>
                </select>
              </div>
            </div>
          

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Topic</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="topic_id" id="topic_id" required=""  >
                  <option value="">Select Topic</option>
                  
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="slideimage" class="col-md-3 col-xs-12 control-label">Upload File</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="excel_file" id="excel_file" />

                </div>
                <!-- <a href="javascript:void(0)" class="add_field_button" onclick="adds()"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a> -->
              </div>
            </div>

          <div class="form-group">
              <label for="slideimage" class="col-md-3 col-xs-12 control-label">Upload Option Images</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="images[]" id="images"  multiple />

                </div>
                <!-- <a href="javascript:void(0)" class="add_field_button" onclick="adds()"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a> -->
              </div>
            </div>

            <div class="form-group">
              <label for="slideimage" class="col-md-3 col-xs-12 control-label">Upload Question Images</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="questionimages[]" id="questionimages"  multiple />

                </div>
                <!-- <a href="javascript:void(0)" class="add_field_button" onclick="adds()"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a> -->
              </div>
            </div>

            <div class="form-group">
              <label for="slideimage" class="col-md-3 col-xs-12 control-label">Upload Explanation Images</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="explanationimages[]" id="explanationimages"  multiple />

                </div>
                <!-- <a href="javascript:void(0)" class="add_field_button" onclick="adds()"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a> -->
              </div>
            </div>


            <!-- <a href="javascript:void(0)" class="add_field_button"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a> -->
            
          

          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/quiz_questions" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
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
  </script>


