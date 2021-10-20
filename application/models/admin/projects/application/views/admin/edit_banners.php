<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">banners</a></li>
  <li class="active">Edit banners</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation1');
      echo form_open_multipart('admin/register/update_banners', $attributes); 
      ?>
         <div class="panel panel-default"> 
          <div class="panel-heading">
            <h2 class="panel-title">Edit banners</h2>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <!-- <div class="panel-body"> -->

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Exams</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="exam_id" id="exam_id" required="" onchange="getpackages(this.value)">
                  <option value="">Select exams</option>
                  <?php
                  if(!empty($exams))
                  {
                    foreach($exams as $exam)
                    {
                      ?>
                      <option value="<?=$exam['id'];?>" <?php if($exam['id'] == $row['exam_id']){?> selected <?php }?>><?=$exam['name'];?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group" id="youtube_div">
              <label for="image" class="col-md-3 col-xs-12 control-label">Youtube Video Url</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="youtube_video_url" value="<?php echo $row['youtube_video_url'] ?>" id="youtube_video_url"  />
                </div>
              </div>
            </div>

            <div class="form-group" id="youtube_div">
              <label for="image" class="col-md-3 col-xs-12 control-label">Pdf path</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="pdf_path" value="<?php echo $row['pdf_path'] ?>" id="pdf_path"  />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Enter Order</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="order" id="order" value="<?php echo $row['order'];?>" required="" />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="" class="col-md-3 col-xs-12 control-label">Upload Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  
                  <input type="file" class="fileinput btn-primary" name="image"   />
                </div>
              </div>
              <?php
             if($row['image'] !='' ){ ?>
              
              <img src="<?php echo base_url().$row['image'];?>" height="50" width="50">
              <?php }else{?>
              <img src="<?php echo base_url().'storage/no_image.jpg';?>" height="50" width="50">
              <?php } ?>
            </div>

             

            
          
          

             

            
          
            <input type="hidden" class="form-control" name="banners_id" value="<?php echo $row['id']?>"  />

          <!-- </div> -->
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/banners" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
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

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/chosen/chosen.min.css">

<script src="<?php echo base_url(); ?>assets/js/chosen/chosen.jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(".standardSelect").chosen({
            disable_search_threshold: 10,
            no_results_text: "Oops, nothing found!",
            width: "100%"
        });
    });

   </script>
<script>
  $(document).ready(function() { //alert();
      $("#validation").validate({
          rules: {
            // simple rule, converted to {required:true}            
            image: {
                required : true,
            }
          },
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
  });
 
 function getpackages(exam_id){
    //alert(exam_id);
    

    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/common/getpackages',
      data: {exam_id: exam_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        //$("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#package_ids").html(data);
        //$("#wait").css("display", "none");
        $("#package_ids").trigger("chosen:updated");
      }
    });
  }

  function getdiv(type){

    if(type == 'youtube'){
      $("#youtube_div").show();
      $("#package_div").hide();
    }else{
      $("#youtube_div").hide();
      $("#package_div").show();
    }

  }
</script>
