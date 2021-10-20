<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">subjects</a></li>
  <li class="active">Edit subjects</li>
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
            <h2 class="panel-title">Edit Chapters</h3>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
                  
          <div class="panel-body">

            <?php //print_r($row); ?>
             <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Courses</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="exam_id" id="course_id" required="" onchange="getss(this.value)" >
                  
                  <?php foreach($courses as $cour){?>
                  
                  <option value="<?php echo $cour->id?>" <?php if($cour->id == $chapter_data->exam_id){ ?> selected <?php } ?> ><?php echo $cour->name?></option>
                  <?php 
                  }?>
                </select>
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Subjects</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="subject_id" id="subject_id" required="" onchange="getvideochapters(this.value)">
                
                  <?php foreach($subjects as $sub){?>
                  
                  <option value="<?php echo $sub['id']?>" <?php if($sub['id'] == $chapter_data->subject_id){ ?> selected <?php } ?> ><?php echo $sub['subject_name']?></option>
                  <?php 
                  }?>

                </select>
              </div>
            </div>

              <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Select Chapter</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="video_chapter_id" id="chapter_id" required="">
                <?php foreach($videoChapters as $chap){?>
                  
                  <option value="<?php echo $chap['id']?>" <?php if($chap['id'] == $chapter_data->chapter_id){ ?>selected <?php } ?> ><?php echo $chap['name']?></option>
                  <?php 
                  }?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="video_name" class="col-md-3 col-xs-12 control-label">Enter Video Name</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="video_name" id="video_name" value="<?=$chapter_data->video_name;?>" />
              </div>
            </div> 


            <div class="form-group">
              <label for="total_time" class="col-md-3 col-xs-12 control-label">Enter Chapter Total Time (hh:mm:ss)</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="total_time" id="total_time" value="<?=$chapter_data->total_time;?>" />
              </div>
            </div>
            <div class="input_fields_wrap">
            <?php $x=0;foreach ($video_topics as $topic) { $x++;?>
              <div class="form-group">
              <label for="topic_name" class="col-md-3 col-xs-12 control-label">Enter Chapter Topic Name <?php echo $x;?></label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="topic_name[]" id="topic_name<?=$x;?>" 
                value="<?=$topic["topic_name"];?>" />
              </div>
            </div>
            <input type="hidden" name="video_topic_id[]" value="<?php echo $topic['id']?>"/>
              <div class="form-group">
              <label for="start_time" class="col-md-3 col-xs-12 control-label">Enter Chapter Topic Time (hh:mm:ss) <?php echo $x;?></label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="start_time[]" id="start_time<?=$x;?>"
                 value="<?=$topic["start_time"];?>" />
              </div>

              <a href="<?php echo base_url()?>admin/register/delete_video_topic/<?php echo $topic["id"]?>/<?=$chapter_data->id;?>" class="remove_video" id="remove_video"><span class="" style="float: right; margin-right: 200px; color: red"><i class="fa fa-remove"></i></span></a>
            </div>
           <?php  } ?>
           <a href="javascript:void(0)" class="add_field_button" id="add_video_topic"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a>
           </div>

            <!-- <div class="form-group">
              <label for="video_path" class="col-md-3 col-xs-12 control-label">Upload video</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="file" class="fileinput btn-primary" name="video" id="video" value="" />
                </div>
              </div>
              <?php if(!empty($chapter_data->video_path)){ ?>
              <video src="<?=base_url().$chapter_data->video_path;?>" height="50" width="50">
              <?php } ?>
            </div> -->
<hr/>
            <div class="form-group">
              <label for="video" class="col-md-3 col-xs-12 control-label">Enter Uploaded video ID</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="video" id="video" 
                value="<?=$chapter_data->video_path;?>" />
              </div>
            </div>

             <div class="form-group">
              <label for="video" class="col-md-3 col-xs-12 control-label">Youtube Video Url</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="youtube_video_url" id="youtube_video_url" 
                value="<?=$chapter_data->youtube_video_url;?>" />
              </div>
            </div>


            <div class="form-group">
              <label for="slideimage" class="col-md-3 col-xs-12 control-label">Upload Slides Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  
                  <input type="file" class="fileinput btn-primary" name="slideimage[]" id="slideimage" value="" multiple />

                </div>
              </div>
              <?php if(!empty($slides)){ 
                foreach ($slides as $slide) { if($slide['image']!=''){?>
                  <img src="<?=base_url().$slide['image'];?>" height="50" width="50">
                <?php }}} ?>
            </div>

            <div class="form-group">
              <label for="chapter_actorname" class="col-md-3 col-xs-12 control-label">Enter chapter actor name </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="chapter_actorname" id="chapter_actorname" value="<?=$chapter_data->chapter_actorname;?>" />
              </div>
            </div>

             <div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Upload Author Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  
                  <input type="file" class="fileinput btn-primary" name="image" id="image" value="<?=$chapter_data->image;?>" />
                </div>
              </div>
              <?php if(!empty($chapter_data->image)){ ?>
              <img src="<?=base_url().$chapter_data->image;?>" height="50" width="50">
            <?php } ?>
            </div>

            <!-- <div class="form-group">
              <label for="notespdf" class="col-md-3 col-xs-12 control-label">Upload Notes <span style="color:red">*</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  
                  <input type="file" class="fileinput btn-primary" name="notespdf[]" id="notespdf" value="" multiple/>
                </div>
              </div>
              <?php if(!empty($upload_notes)){ 
                foreach ($upload_notes as $upload_note) { if($upload_note['image']!=''){?>
                  <img src="<?=base_url().$upload_note['image'];?>" height="50" width="50">
                <?php }}} ?>
            </div> -->

    <div class="form-group">
              <label for="notespdf" class="col-md-3 col-xs-12 control-label">Upload Notes PDF Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="notespdf_path" id="notespdf"  value="<?php echo $chapter_data->notespdf_path; ?>" />
                </div>
              </div>
        </div>

        <div class="form-group">
              <label for="notespdf" class="col-md-3 col-xs-12 control-label">Upload Material PDF Path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="materialpdf_path" id="notespdf"  value="<?php echo $chapter_data->materialpdf_path; ?>" />
                </div>
              </div>
        </div>
               <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Free/Paid<span style="color:red">*</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" 
                name="free_or_paid" id="free_or_paid">
                <option value="">Select type</option>
                 <option value="free" <?php if($chapter_data->free_or_paid == 'free'){ echo "selected";}?>>Free</option>
                 <option value="paid" <?php if($chapter_data->free_or_paid == 'paid'){ echo "selected";}?>>Paid</option>
                </select>
              </div>
            </div>

           <div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Suggested Video Banner</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  
                  <input type="file" class="fileinput btn-primary" name="suggest_video_banner" id="suggest_video_banner" value="<?=$chapter_data->suggest_video_banner;?>" />
                </div>
              </div>
              <?php if(!empty($chapter_data->suggest_video_banner)){ ?>
              <img src="<?=base_url().$chapter_data->suggest_video_banner;?>" height="50" width="50">
            <?php } ?>
            </div>


             <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Suggested Video Status<span style="color:red">*</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" 
                name="suggested_videos" id="suggested_videos">
                    <option value="">Select type</option>
                 <option value="Yes" <?php if($chapter_data->suggested_videos == 'Yes'){ echo "selected";}?>>Yes</option>
                 <option value="No" <?php if($chapter_data->suggested_videos == 'No'){ echo "selected";}?>>No</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="video_date" class="col-md-3 col-xs-12 control-label">Video Date </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="video_date" id="video_date" value="<?php echo $chapter_data->video_date;?>" />
              </div>
            </div>

            <div class="form-group">
              <label for="video_date" class="col-md-3 col-xs-12 control-label">Enter Order </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="number" class="form-control" 
                name="order" id="order" value="<?php echo $chapter_data->order;?>"  />
              </div>
            </div>



          </div>
        
          <!--  <input type="hidden" name="video_id" id="video_id" value="<?=$chapter_data->video_topic_id;?>"> -->
          <!--  <input type="hidden" name="chapter_slides_id" value="<?=$slides[0]['id'];?>" > -->
           <input type="hidden" name="chapter_id" value="<?=$chapter_data->id;?>" >
              
          <div class="panel-footer">
            <!-- <button class="btn btn-default">Clear Form</button> -->
            <a href="<?=base_url();?>admin/register/chapters" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>            
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
            exam_id: {
               required : true,
            },
            subject_id:{
               required : true,
            },
            chapter_name:{
               required : true,
            },
            total_time:{
               required : true,
            },
            topic_name:{
               required : true,
            },
            start_time:{
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
      var x = '<?php echo count($video_topics)?>'; //initlal text box count
     // alert(x);
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