<!-- <style type="text/css">
  input[type=time]::-webkit-datetime-edit-ampm-field {
  display: none;
}
</style> -->
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">chapters</a></li>
  <li class="active">Add chapters</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_chapters', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Add chapters</h2>            
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
                <select class="form-control" name="exam_id" id="course_id" onchange="getss(this.value)" required>
                  <option value="">Select Courses</option>
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
              <label class="col-md-3 col-xs-12 control-label">Subjects</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="subject_id" id="subject_id" onchange="getvideochapters(this.value)" required>
                  <option value="">Select subjects</option>
                </select>
              </div>
            </div>   

            <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Select Chapter</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="video_chapter_id" id="chapter_id" required="">
                  <option value="">Select Chapter</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="video_name" class="col-md-3 col-xs-12 control-label">Enter Video Name</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="video_name" id="video_name" required=""/>
              </div>
            </div>


              <div class="form-group">
              <label for="total_time" class="col-md-3 col-xs-12 control-label">Enter Video Total Time (hh:mm:ss)</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control timepicker" 
                name="total_time" id="total_time" placeholder="hh:mm:ss" required="" />
              </div>
          </div>
            
            <div class="input_fields_wrap">
              <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Enter Chapter Topic Name 1</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="topic_name[]" id="topic_name1" required=""/>
              </div>
          </div>
          
        <div class="form-group">
              <label for="start_time" class="col-md-3 col-xs-12 control-label">Enter Topic Time (hh:mm:ss) 1</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="start_time[]" id="start_time1" required="" />
              </div>
            <a href="javascript:void(0)" class="add_field_button" id="add_video_topic"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a>
          </div>
          </div>
            <div id="datass">
                
            </div>

              <!-- <div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Upload video</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="fileinput btn-primary" name="video" id="video" required="" />
                </div>
              </div>
            </div> -->
        <hr/>
            <div class="form-group">
                <label for="video" class="col-md-3 col-xs-12 control-label">Enter Uploaded video ID</label>
                <div class="col-md-6 col-xs-12">                
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" 
                  name="video" id="video" />
                </div>
            </div>

            <div class="form-group">
                <label for="video" class="col-md-3 col-xs-12 control-label">Youtube Video Url</label>
                <div class="col-md-6 col-xs-12">                
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" 
                  name="youtube_video_url" id="youtube_video_url" />
                </div>
            </div>

             <div class="form-group">
              <label for="slideimage" class="col-md-3 col-xs-12 control-label">Upload Slides Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  
                  <input type="file" class="fileinput btn-primary" name="slideimage[]" id="slideimage"  multiple />

                </div>
                <!-- <a href="javascript:void(0)" class="add_field_button" onclick="adds()"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a> -->
              </div>
            </div>

              <div class="form-group">
              <label for="chapter_actorname" class="col-md-3 col-xs-12 control-label">Enter chapter faculty name </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="chapter_actorname" id="chapter_actorname"  />
              </div>
            </div>

             <div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Upload faculty Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  
                  <input type="file" class="fileinput btn-primary" name="image" id="image"  />
                </div>
              </div>
            </div>

           

           

            <!-- <div class="form-group">
              <label for="notespdf" class="col-md-3 col-xs-12 control-label">Upload Notes <span style="color:red">*</span></label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  
                  <input type="file" class="fileinput btn-primary" name="notespdf[]" id="notespdf" multiple  />
                </div>
              </div>
            </div>
 -->

            <div class="form-group">
              <label for="notespdf" class="col-md-3 col-xs-12 control-label">Upload Notes PDF Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="notespdf_path" id="notespdf"   />
                </div>
              </div>
            </div>

             <div class="form-group">
              <label for="notespdf" class="col-md-3 col-xs-12 control-label">Upload Material PDF Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="materialpdf_path" id="materialpdf_path"   />
                </div>
              </div>
            </div>

              <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Free/Paid<span style="color:red">*</span></label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="free_or_paid" id="free_or_paid" required="">
                  <option value="">Select type</option>
                  <option value="free">Free</option> 
                  <option value="paid">paid</option>
                   </select>
              </div>
            </div>

            <div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Suggested Video Banner</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  
                  <input type="file" class="fileinput btn-primary" name="suggest_video_banner" id="suggest_video_banner"  />
                </div>
              </div>
            </div>

             <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Suggested Videos Status <span style="color:red">*</span></label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="suggested_videos" id="suggested_videos" required="">
                  <option value="">Select type</option>
                  <option value="Yes">Yes</option> 
                  <option value="No">No</option>
                   </select>
              </div>
            </div>

            <div class="form-group">
              <label for="video_date" class="col-md-3 col-xs-12 control-label">Video Date </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="video_date" id="video_date" />
              </div>
            </div>

             <div class="form-group">
              <label for="video_date" class="col-md-3 col-xs-12 control-label">Enter Order </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="number" class="form-control" 
                name="order" id="order" />
              </div>
            </div>

          </div>
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/chapters" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
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
      $("#validation").validate({
          rules: {
            exam_id: {
                required : true,
            },
            subject_id: {
                required : true,
            },
            chapter_name: {
                required : true,
            },
            topic_name: {
                required : true,
            },
            total_time: {
                required : true,
            },
            start_time: {
                required : true,
            },
            free_or_paid:{
                required : true,
            },
            suggested_videos:{
                required : true,
            }
          },
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
      
  });

      var max_fields      = 1000; //maximum input boxes allowed

      var wrapper         = $(".input_fields_wrap"); //Fields wrapper
      var add_button      = $("#add_video_topic"); //Add button ID
      
      var html = $(".input_fields_wrap").html();//alert(html);
      var x = 1; //initlal text box count
      $("#add_video_topic").on("click",function(e){ //on add input button click
          e.preventDefault();
          if(x < max_fields){ //max input box allowed
              x++; //text box increment
              // $(wrapper).append('<div class="form-group"><label for="topic_name" class="col-md-3 col-xs-12 control-label">Enter Chapter Topic Name </label><div class="col-md-6 col-xs-12"><span class="input-group-addon"><i class="fa fa-pencil"></i></span><input type="text" class="form-control" name="topic_name[]" id="topic_name" /></div><a href="javascript:void(0)" class="remove_field"><span class="" style=" color: red"><i class="fa fa-minus"></i></span></a></div>'); //add input box
              $(wrapper).append('<div class="input_fields_wrap"> <div class="form-group"> <label for="topic_name" class="col-md-3 col-xs-12 control-label">Enter Chapter Topic Name '+x+'</label> <div class="col-md-6 col-xs-12"> <span class="input-group-addon"><i class="fa fa-pencil"></i></span> <input type="text" class="form-control" name="topic_name[]" id="topic_name'+x+'" required=""/> </div></div><!--<div class="form-group"> <label class="col-md-3 col-xs-12 control-label">Topic Free/Paid</label> <div class="col-md-6 col-xs-12"> <select class="form-control" name="topic_free_or_paid[]" id="topic_free_or_paid'+x+'" required=""> <option value="">Select type</option> <option value="free">Free</option> <option value="paid">paid</option> </select> </div></div>--><div class="form-group"> <label for="start_time" class="col-md-3 col-xs-12 control-label">Enter Topic Time (hh:mm:ss) '+x+'</label> <div class="col-md-6 col-xs-12"> <span class="input-group-addon"><i class="fa fa-pencil"></i></span> <input type="text" class="form-control" placeholder="hh:mm:ss" name="start_time[]" id="start_time'+x+'" required=""/> </div> </div><a href="javascript:void(0)" class="remove_field"><span class="" style="float: right; margin-right: 200px;color: red"><i class="fa fa-minus"></i></span></a></div>')
          }
      });      
      $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); $(this).parent('div').remove(); x--;
      });
  
  
  function datas(){
      
      $('#datas').html('<div class="form-group"><label for="topic_name" class="col-md-3 col-xs-12 control-label">Enter Chapter Topic Name</label><div class="col-md-6 col-xs-12"><span class="input-group-addon"><i class="fa fa-pencil"></i></span><input type="text" class="form-control" name="topic_name" id="topic_name" required=""/></div></div><div class="form-group"><label for="topic_name" class="col-md-3 col-xs-12 control-label">Topic Time</label><div class="col-md-6 col-xs-12"><span class="input-group-addon"><i class="fa fa-pencil"></i></span><input type="text" class="form-control" name="topic_time" id="topic_time" required=""/></div><a href="javascript:void(0)" class="add_field_button" onclick="adds()"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a></div>'
          );
  }
 })
$(document).ready(function(){
    $('input.timepicker').timepicker({ timeFormat: 'h:mm:ss p' });
});
</script>
<script>
 $(function() {
$("#video_date").datepicker({
  //maxDate: "-1d"
   format: 'yyyy-mm-dd'
});

})
 

</script>