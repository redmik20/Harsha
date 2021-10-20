<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">Areas</a></li>
  <li class="active">Edit Areas</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/delete_topics_permently/'.$topic_id, $attributes); 
      ?>
        <div class="panel panel-default">
           </br>
              <h3 style="color:red">Once delete this Qbank Chapter below dependent lists are deleted</h3>
          </br>
          </hr>
              </br>
              <h3 style="color:red">Dependent Questions List</h3>
              <hr>
       <?php if(!empty($questions)){
        foreach($questions as $qk=>$qv){?>
            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Question <?php echo $qk+1;?> :</label> 
              <div class="col-md-6 col-xs-12">                
                <?php echo $qv['question_unique_id']?>
              </div>
            </div>
       <?php }}else{
        echo '<h5 style="color:green">No Questions Found</h5>';
        }?>

        </br>
              <h3 style="color:red">Dependent Topics List</h3>
              <hr>

        <?php if(!empty($topics)){
        foreach($topics as $tk=>$tv){?>
            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Topic <?php echo $tk+1;?> :</label> 
              <div class="col-md-6 col-xs-12">                
                <?php echo $tv['name']?>
              </div>
            </div>
       <?php }}else{
        echo '<h5 style="color:green">No Topics Found</h5>';
        }?>

              </br>
              <h3 style="color:red">Dependent Subtopics List</h3>
              <hr>

        <?php if(!empty($subtopics)){
        foreach($subtopics as $sbk=>$sbv){?>
            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">SubTopic <?php echo $sbk+1;?> :</label> 
              <div class="col-md-6 col-xs-12">                
                <?php echo $sbv['name']?>
              </div>
            </div>
       <?php }}else{
        echo '<h5 style="color:green">No SubTopics Found</h5>';
        }?>

           

          </div>


          <input type="hidden" name="topic_id" value="<?php echo $topic_id;?>">
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/topics" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
            <button type="submit" name="submit" value="submit" class="btn btn-primary pull-right" id="btnSubmit">Delete</button>
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
           
            title: {
                required : true,
            },
           
          },
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
      
  });
</script>
