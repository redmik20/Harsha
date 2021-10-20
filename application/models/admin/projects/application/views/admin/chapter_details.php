
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">Chapter Details</a></li>
  <li class="active">Chapter Details</li>
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
            <h2 class="panel-title">Chapter Details</h2>
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <div class="panel-body">  
            <?php //print_r($chapter_details);?>
            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Chapter Name: </label>
              <?php $videochapter_id=$chapter_details['0']->chapter_id;
                  $videochapter=$this->db->query("select name from videochapters where id='".$videochapter_id."' ")->row_array(); ?>
              <div class="col-md-6 col-xs-12 margintop7"><?=$videochapter['name'];?></div>
            </div>
            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Video Name: </label>
              <
              <div class="col-md-6 col-xs-12 margintop7"><?=$chapter_details[0]->video_name;?></div>
            </div>

             <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Notes PDF Path: </label>
              <
              <div class="col-md-6 col-xs-12 margintop7"><?=$chapter_details[0]->notespdf_path;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Material PDF Path: </label>
              <
              <div class="col-md-6 col-xs-12 margintop7"><?=$chapter_details[0]->materialpdf_path;?></div>
            </div>
          
            <div class="form-group">
             <label for="title" class="col-md-3 col-xs-12 control-label">Chapter Teacher Name: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$chapter_details['0']->chapter_actorname;?></div>
            </div>
      

            <div class="form-group">
             <label for="title" class="col-md-3 col-xs-12 control-label">Chapter Teacher image: </label>
              <div ><?php if(!empty($chapter_details['0']->image)){ ?><img src="<?=base_url().$chapter_details['0']->image; ?>" height="130" width="320" alt="Logo"/><?php } ?>
              </div>
            
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Video Path: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$chapter_details['0']->video_path;?></div>
            </div>          

            <!--<div class="form-group">-->
            <!--  <label for="title" class="col-md-3 col-xs-12 control-label">total time: </label>-->
            <!--  <div class="col-md-6 col-xs-12 margintop7"><?=$chapter_details['total_time'];?></div>-->
            <!--</div>-->

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Free or Paid: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$chapter_details['0']->free_or_paid;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Suggested Videos: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$chapter_details['0']->suggested_videos;?></div>
            </div>

            <!--<div class="form-group">-->
            <!--  <label for="title" class="col-md-3 col-xs-12 control-label">Notes: </label>-->
            <!--  <div class="col-md-6 col-xs-12 margintop7"><?=$chapter_details['notespdf'];?></div>-->
            <!--</div>-->

          </div>

    <!-- <div class="form-group">
        <div class="col-md-6 col-xs-12 margintop7">
          <?php if(!empty($chapter_details['0']->video_path)){ ?>
          <video width="320" height="240" controls autoplay>
            <source src="<?=base_url().$chapter_details['0']->video_path ?>" type="video/mp4">
            Sorry, your browser doesn't support the video element.
          </video>
          <?php } ?>
</div>
</div> -->
        <div class="form-group">
        <div class="col-md-6 col-xs-12 margintop7">
          <?php if(!empty($chapter_details['0']->video_path)){ 
            echo '<iframe src="https://player.vdocipher.com/playerAssets/1.x/vdo/embed/index.html#otp='.$otp_response->otp.'&playbackInfo='.$otp_response->playbackInfo.'"style="border:0;height:240px;width:320px;max-width:100%" '
        . 'allowFullScreen="true" allow="encrypted-media"></iframe>';
          } ?>
</div>
</div>


        </div>
      </div>
    </div>
  </div>

