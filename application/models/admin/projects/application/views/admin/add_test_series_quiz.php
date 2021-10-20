<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">test_series_quiz</a></li>
  <li class="active">Add test_series_quiz</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_test_series_quiz/insert', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Add Test Series quiz </h2>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <div class="panel-body">
              
               <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Course</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="course_id" id="course_id" required="" onchange="getCategoriesOnQuiz(this.value)">
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
              <label  class="col-md-3 col-xs-12 control-label">Test Series Categories</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="category_id" id="category_id" >
                  <option value="">Select Category</option>
                  

                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Subjects</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="subject_id" id="subject_id" required="" >
                  <option value="">Select Subjects</option>
                </select>
              </div>
            </div>
               
              <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Title </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="title" id="title" required=""/>
              </div>
          </div>
            

              <div class="form-group">
              <label for="description" class="col-md-3 col-xs-12 control-label">Enter Description</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="description" id="description" required=""/>
              </div>
          </div>
              

              
          <div class="form-group">
              <label for="time" class="col-md-3 col-xs-12 control-label">Enter Time </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="time" id="time"  required=""/>
              </div>
          </div>
          


          <div class="form-group">
              <label for="exam_time" class="col-md-3 col-xs-12 control-label">Enter Exam  Date </label>
              <div class="col-md-3 col-xs-6">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="exam_time" id="exam_time" required="" />
      
              </div>
              <div class="col-md-3 col-xs-6">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
               
                <input type="text" class="form-control timepicker" name="timepicker" value=""/>
              </div>
          </div>
            
          <div class="form-group">
              <label for="expiry_date" class="col-md-3 col-xs-12 control-label">Enter Expiry  Date </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="expiry_date" id="expiry_date"  />
              </div>
          </div>

          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Free/Paid</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="quiz_type" id="quiz_type" required="">
                  <option value="">Select type</option>
                  <option value="free">Free</option> 
                  <option value="paid">paid</option>
                   </select>
              </div>
          </div>

          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Suggested Testseries</label>
              <div class="col-md-6 col-xs-12">
                <input class="" type="radio" name="suggested_test_series" checked value="yes">
                <label for="yes">YES</label>
               
                </br>
                <input class="" type="radio" name="suggested_test_series" value="no">
                <label for="no">NO</label>
                  
                   
              </div>
            </div> 


            

          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Banner Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <input type="file" class="fileinput btn-primary" name="image" id="icon" />
                </div>
              </div>
          </div> 
          
          <div class="form-group">
              <label for="uploaded_pdf_path" class="col-md-3 col-xs-12 control-label">Uploaded PDF Path </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="uploaded_pdf_path" id="uploaded_pdf_path"  />
              </div>
          </div>

           <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Enter Order</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text"  class="form-control" name="order" id="order" />
                </div>
              </div>
          </div> 
          
           <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Enter Questions Count</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text"  class="form-control" name="questions_count" id="questions_count" />
                </div>
              </div>
          </div> 
          



          </div>
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/test_series_quiz" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
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


<script src="//code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

<script type="text/javascript">
       $(document).ready(function() {
         $('.timepicker').timepicker({
                timeFormat: 'HH:mm',
                interval: 15,
                defaultTime: '09:30',
              });
       });
</script>

<script>
  $(document).ready(function() { //alert();
      $("#validation").validate({
          rules: {
            // simple rule, converted to {required:true}            
            // topic_name: {
            //     required : true,
            // }
          },
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
  });
 
</script>

<script>
function get_categories()
  {
    //alert(education_id);exit;
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_test_seriescategories',
     // data: {exam_id: exam_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=x-user-defined");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#category_id").html(data);
       $("#wait").css("display", "none");
      }
    });
  }
</script>

 <script>
 $(function() {
$("#exam_time").datepicker({
  //maxDate: "-1d"
   format: 'dd-mm-yyyy'
});
$("#expiry_date").datepicker({
  //maxDate: "-1d"
   format: 'dd-mm-yyyy'
});
})
 

</script>
<script>
$(function() {
 //$("#exam_time").datepicker();
 /*$("#exam_time").on('change', function(){
     
         var date = Date.parse($(this).val());

         if (date > Date.now()){
             alert('Please select another date');
             $(this).val('');
         }
     
    });*/
});


function getCategoriesOnQuiz(chapter_id)
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


    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/get_subject',
      data: {exam_id: course_id},
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
</script>
