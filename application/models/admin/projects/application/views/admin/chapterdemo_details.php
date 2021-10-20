
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">chapterdemo Details</a></li>
  <li class="active">chapterdemo Details</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_subjects', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">chapterdemo Details</h2>
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <div class="panel-body">  

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">chapterdemo Name: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$chapterdemo_details[0]->chapter_name;?></div>
            </div>
          
            <div class="form-group">
             <label for="title" class="col-md-3 col-xs-12 control-label">chapterdemo Actor Name: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$chapterdemo_details[0]->chapter_actorname;?></div>
            </div>
      

            <div class="form-group">
             <label for="title" class="col-md-3 col-xs-12 control-label">chapter image: </label>
              <div ><img src="<?=base_url().$chapterdemo_details[0]->image ?>" height="130" width="320" alt="Logo"/>
              </div>
            
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Video Path: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$chapterdemo_details[0]->video_path;?></div>
            </div>          

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">total time: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$chapterdemo_details[0]->total_time;?></div>
            </div>
            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Suggested Videos: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$chapterdemo_details[0]->suggested_videos;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Notes: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$chapterdemo_details[0]->notespdf;?></div>
            </div>

          </div>

          <video width="320" height="240" controls autoplay>
  <source src="<?=base_url().$chapterdemo_details[0]->video_path ?>" type="video/mp4">
  Sorry, your browser doesn't support the video element.
</video> 


        </div>
      </div>
    </div>
  </div>

