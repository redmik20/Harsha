<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <!-- START DATATABLE EXPORT -->
      <div class="panel panel-default" style="padding-bottom: 52px;">
        <div class="panel-heading">
          <div class="col-md-6 col-xs-6">
            <h2><span class="fa fa-list"></span> Search Qbank Questions</h2>
          </div>
        </div><br><br><br><br>
        <div class="panel-body1" style="background-color: #fff;">
          <p style="text-align: center;"><img src='<?=base_url();?>assets/images/platologo.png' width="200" height="200" /></p>
                             
            
            <!-------- Search Form ---------->
            <form id="fees_form" name="search" action="<?php echo site_url().'/admin/register/SearchQbankQuestion';?>" method="post" style="text-align: center;">             
                <div class="col-md-2">
                    <p>Select Course</p>
                      <select class="form-control" name="exam_id" id="exam_id" required="" class="form-control input-sm custom-input" onchange="getQbankSearchSubject(this.value)">
                        <option value="">Select Course</option>
                          <?php
                          if(!empty($exams))
                          {
                            foreach($exams as $exam)
                            {
                              ?>
                              <option value="<?=$exam['id'];?>"><?=$exam['name'];?></option>
                              <?php
                            }
                          }
                          ?>
                      </select>
                </div>
              
                <div class="col-md-2">
                    <p>Select Subjects</p>
                    <select name="subject_id" id="subject_id" class="form-control input-sm custom-input" onchange="getQbankSearchChapter(this.value)">
                      <option value="">Select Subjects</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <p>Select Chapters</p>
                    <select name="chapter_id" id="chapter_id" class="form-control input-sm custom-input" onchange="getQbankSearchtopics(this.value)">
                      <option value="">Select Chapters</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <p>Select Topics</p>
                    <select name="topic_id" id="topic_id" class="form-control input-sm custom-input">
                      <option value="">Select Topics</option>
                    </select>
                </div>

              

                <div class="col-md-1">
                  <p style="visibility: hidden;">.</p>
                  <button type="submit" id="search_user" class="btn btn-info margin_search"><i class="fa fa-search icon-style"></i></button>
                </div>
            </form> 
            <!-------- /Search Form ---------->
                                                   
          
        </div>
      </div>
      <!-- END DATATABLE EXPORT -->      
    </div>
  </div>
</div>    

<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-validate-additional-methods.js"></script>
<script>
  
  function getQbankSearchSubject(exam_id)
  {
    //alert(exam_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/getQbankSearchSubject',
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


   function getQbankSearchChapter(subject_id)
  {
    //alert(exam_id);
    var course_id=$('#exam_id').val();
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

  function getQbankSearchtopics(chapter_id)
  {
    //alert(exam_id);
    var course_id=$('#exam_id').val();
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
 
</script>