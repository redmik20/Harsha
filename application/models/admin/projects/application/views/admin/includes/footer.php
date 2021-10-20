</div>            
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- MESSAGE BOX-->
<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
  <div class="mb-container">
    <div class="mb-middle">
      <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
      <div class="mb-content">
        <p>Are you sure you want to log out?</p>
        <p>Press No if you want to continue work. Press yes to logout.</p>
      </div>
      <div class="mb-footer">
        <div class="pull-right">
          <a href="<?=base_url();?>admin/home/is_logged_out" class="btn btn-success btn-lg">Yes</a>
          <button class="btn btn-default btn-lg mb-control-close">No</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END MESSAGE BOX-->

<!-- START PRELOADS -->
<audio id="audio-alert" src="<?=base_url();?>assets/audio/alert.mp3" preload="auto"></audio>
<audio id="audio-fail" src="<?=base_url();?>assets/audio/fail.mp3" preload="auto"></audio>
<!-- END PRELOADS -->

<!-- START SCRIPTS -->
<!-- START PLUGINS -->
<!--<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/jquery/jquery.min.js"></script>-->
<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/bootstrap/bootstrap.min.js"></script>        
<!-- END PLUGINS -->

<!-- START THIS PAGE PLUGINS-->        
<script type='text/javascript' src='<?=base_url();?>assets/js/plugins/icheck/icheck.min.js'></script>        
<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>

<?php
$uri = $this->uri->segment(3);
if($uri == "index")
{
  ?>
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/scrolltotop/scrolltopcontrol.js"></script>

  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/morris/raphael-min.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/morris/morris.min.js"></script>       
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/rickshaw/d3.v3.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/rickshaw/rickshaw.min.js"></script>
  <script type='text/javascript' src='<?=base_url();?>assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'></script>
  <script type='text/javascript' src='<?=base_url();?>assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'></script>                  
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/owl/owl.carousel.min.js"></script>
  <?php
}
else
{
  ?>                
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tableexport/tableExport.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tableexport/jquery.base64.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tableexport/html2canvas.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tableexport/jspdf/jspdf.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tableexport/jspdf/libs/base64.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/bootstrap/bootstrap-file-input.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/bootstrap/bootstrap-select.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
  <?php
}
?>
<script type='text/javascript' src='<?=base_url();?>assets/js/plugins/bootstrap/bootstrap-datepicker.js'></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/moment.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/daterangepicker/daterangepicker.js"></script>

<!-- END THIS PAGE PLUGINS-->        

<!-- START TEMPLATE -->
<!-- <script type="text/javascript" src="<?=base_url();?>assets/js/settings.js"></script> -->

<script type="text/javascript" src="<?=base_url();?>assets/js/plugins.js"></script>        
<script type="text/javascript" src="<?=base_url();?>assets/js/actions.js"></script>

<script type="text/javascript" src="<?=base_url();?>assets/js/demo_dashboard.js"></script>

<style type="text/css">
  .td_action
  {
    width: 100px;
  }
  .td_action_extra
  {
    width: 135px;
  }
</style>
<script type="text/javascript">
  $('.breadcrumb').hide();
</script>
<script type="text/javascript">
  
  function getss(exam_id)
  {
    //alert(exam_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_subject',
      data: {exam_id: exam_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#subject_id").html(data);
        $("#wait").css("display", "none");
      }
    });
  }
  
  function getcc(subject_id)
  {
    //alert(exam_id);
    var exam_id=$('#exam_id').val();
    //alert(exam_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_services',
      data: {subject_id: subject_id,exam_id: exam_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#chapter_id").html(data);
        $("#wait").css("display", "none");
      }
    });
  }

  function getqbankchapters(subject_id)
  {
    //alert(exam_id);
    var course_id=$('#course_id').val();
    //alert(exam_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/getQbankChapters',
      data: {course_id: course_id,subject_id: subject_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#chapter_id").html(data);
        $("#wait").css("display", "none");
      }
    });
  }
function getvideochapters(subject_id)
  {
    //alert(exam_id);
    var course_id=$('#course_id').val();
    //alert(course_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/getVideoChapters',
      data: {course_id: course_id,subject_id: subject_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#chapter_id").html(data);
        $("#wait").css("display", "none");
      }
    });
  }
  function getqbanktopics(chapter_id)
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
        $("#topic_id").html(data);
        $("#wait").css("display", "none");
      }
    });
  }
    
function doesFileExist(urlToFile) {
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();
     
    if (xhr.status == "404") {
        return false;
    } else {
        return true;
    }
}


function getCategories(chapter_id)
  {
    //alert(exam_id);
    var course_id=$('#course_id').val();
    
    //alert(exam_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/getCategories',
      data: {course_id: course_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#category_id").html(data);
        $("#wait").css("display", "none");
      }
    });
  }

</script>
<!-- END TEMPLATE -->
<!-- END SCRIPTS -->
</body>
</html>