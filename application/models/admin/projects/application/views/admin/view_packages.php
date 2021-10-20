<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="<?php echo base_url('admin/home')?>">Home</a></li>
  <li><a href="<?php echo base_url('admin/register/packages')?>">Packages</a></li>
  <li class="active">View Packages</li>
</ul>
<!-- END BREADCRUMB -->

  <!--<link rel="stylesheet" type="text/css" id="theme" href="<?=base_url();?>assets/css/bootstrap/bootstrap.min.css"/>-->
  <!--<link rel="stylesheet" type="text/css" id="theme" href="<?=base_url();?>assets/css/chosen.css"/>
  <script src="<?=base_url(); ?>assets/js/chosen.jquery.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_packages', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">View Packages</h2>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <div class="panel-body">

          <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Package Name </label>
              <div class="col-md-6 col-xs-12">                
                
                <?php echo $row['package_name']; ?>
              </div>
              </div>
              
              <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Courses</label>
              <div class="col-md-6 col-xs-12">
                <?php echo $row['course_names']; ?>
              </div>
            </div>
   
          <div class="form-group">
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Video Subjects</label>
              <div class="col-md-6 col-xs-12">                
                <?php echo $row['video_subject_names']; ?>
              </div>
            </div>


            <div class="form-group">
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Qbank Subjects</label>
              <div class="col-md-6 col-xs-12">    
              <?php foreach($qbank_subjects as $subject){

                echo $subject['subject_name'].',';

                 }?>            
                
              </div>
            </div>

            <div class="form-group">
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Test Series</label>
              <div class="col-md-6 col-xs-12">                
                <?php echo $row['test_series_names']; ?>
              </div>
            </div>

            

      
            

              <div class="form-group">
              <label for="description" class="col-md-3 col-xs-12 control-label"> Description</label>
              <div class="col-md-6 col-xs-12">                
                
                <?php echo $row['description']?>
              </div>
          </div>

          <div class="form-group">
              <label for="description" class="col-md-3 col-xs-12 control-label">No of Coupons</label>
              <div class="col-md-6 col-xs-12">                
                
                <?php echo $row['no_of_coupons']?>
              </div>
          </div>
        
        <?php 
        foreach ($package_prices as $key => $value) {?>
          <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label"> Month <?php echo $key+1; ?> </label>
              <div class="col-md-6 col-xs-12">                
                <?php echo $value['month'];?> Months
              </div>
              </div>
            

              <div class="form-group">
              <label for="description" class="col-md-3 col-xs-12 control-label">Enter Price <?php echo $key+1; ?></label>
              <div class="col-md-6 col-xs-12">                
                
                <?php echo $value['price'];?> /-
              </div>
          </div>
       <?php  }

        ?>

           

          </div>
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/packages" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
            
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
            topic_name: {
                required : true,
            }
          },
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
  });
 
 $(".chosen-select1").chosen();
 $(".chosen-select2").chosen();
 $(".chosen-select3").chosen();
 $(".chosen-select4").chosen();
/*$('button').click(function(){
        $(".chosen-select1").val('').trigger("chosen:updated");
});*/

function getMultipleSubjects(){
var course_ids = $('#course_id').val();
var package_id = $('#package_id').val();
  //alert(values);
  $.ajax({ 
           type: "POST", 
           url: '<?php echo base_url();?>admin/register/getupdateMultipleSubjects', 
           data: "course_ids="+course_ids+"&package_id="+package_id,
           complete: function(data){  
            var op = data.responseText.trim();
            $("#video_subject_ids").html(op);
            $("#qbank_subject_ids").html(op);
            $(".chosen-select2").chosen();
            $(".chosen-select2").val('').trigger("chosen:updated");
           //$(".chosen-select2").find('option').map(function() { return this.value }).get().join();
            $(".chosen-select3").val('').trigger("chosen:updated");
               }
     });

  $.ajax({ 
           type: "POST", 
           url: '<?php echo base_url();?>admin/register/getMultipleTestseries', 
           data: "course_ids="+course_ids,
           complete: function(data){  
            var op = data.responseText.trim();
            $("#test_series_ids").html(op);
            $(".chosen-select4").val('').trigger("chosen:updated");
               }
     });

}
</script>




