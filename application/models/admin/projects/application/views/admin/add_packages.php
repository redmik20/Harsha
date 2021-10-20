<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="<?php echo base_url('admin/home')?>">Home</a></li>
  <li><a href="<?php echo base_url('admin/register/packages')?>">Packages</a></li>
  <li class="active">Add Packages</li>
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
            <h2 class="panel-title">Add Packages</h2>            
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
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="package_name" id="package_name" required=""/>
              </div>
              </div>

              <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Package Order </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="order" id="order" required=""/>
              </div>
              </div>
              
              <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Courses</label>
              <div class="col-md-6 col-xs-12">
              <input type="checkbox" id="select_all" > <label for="vehicle1">Select All</label><br>
                <!--<select class="form-control chosen-select1" multiple name="course_ids[]" id="course_id" required="" onchange="getMultipleSubjects()">

                  <option value="">Select Course</option>
                  <?php
                  if(!empty($courses))
                  {
                    foreach($courses as $course)
                    {
                      ?>
                      <option value="<?php echo $course->id;?>"><?php echo $course->name;?></option>
                      <?php
                    }
                  }
                  ?>
                </select>-->

                <?php
                  if(!empty($courses))
                  {
                    foreach($courses as $course)
                    {
                      ?>
              <input type="checkbox" class="checkbox1" name="course_ids[]" value="<?php echo $course->id;?>" id="courseid_<?php echo $course->id;?>" required="" >
              <label for="vehicle1"> <?php echo $course->name;?></label><br>
              <?php }
              }
              ?>

              </div>
            </div>
   
          <div class="form-group">
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Video Subjects</label>
              <div class="col-md-6 col-xs-12">   
              <input type="checkbox" id="select_all2"> <label for="vehicle1">Select All</label><br>             
               <!-- <select class="form-control chosen-select2" multiple name="video_subject_ids[]" id="video_subject_ids" required="" >
                  <option value="">Select Subjects</option>
                </select>-->
                <div id="video_subject_ids">
                </div>

              </div>
            </div>


            <div class="form-group">
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Qbank Subjects</label>
              <div class="col-md-6 col-xs-12">   
              <input type="checkbox" id="select_all3"> <label for="vehicle1">Select All</label><br>     
               <div id="qbank_subject_ids">
               </div>             
                <!--<select class="form-control chosen-select3" multiple name="qbank_subject_ids[]" id="qbank_subject_ids" required="" >
                  <option value="">Select Subjects</option>
                </select>-->
              </div>
            </div>

            <div class="form-group">
              <label for="subject_name" class="col-md-3 col-xs-12 control-label">Test Series</label>
              <div class="col-md-6 col-xs-12">  
              <input type="checkbox" id="select_all4"> <label for="vehicle1">Select All</label><br> 

              <div id="test_series_ids">              
                <!-- <select class="form-control chosen-select4" multiple name="test_series_ids[]" id="test_series_ids" required="" >
                  <option value="">Select Subjects</option>
                </select> -->
                </div>
              </div>
            </div>

             <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Select Payment type</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="package_type" id="package_type" required="" >
                  <option value="2">Paid</option>
                  <option value="3">Free</option>
                </select>
              </div>
              </div>

        <div class="input_fields_wrap">
            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Select Months 1</label>
              <div class="col-md-6 col-xs-12">                
                <select class="form-control" name="months[]" id="month_ids" required="" >
                  <option value="3">3 days</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="18">1.6 years</option>
                  <option value="24">2 years</option>
                  <option value="30">2.6 years</option>
                  <option value="36">3 years</option>
                  <option value="42">3.6 years</option>
                  <option value="48">4 years</option>
                  <option value="54">4.6 years</option>
                  <option value="60">5 years</option>
                  </select>
              </div>
              </div>

              <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Price 1</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="prices[]" id="price" required=""/>
              </div>
              </div>
              </div>

              <a href="javascript:void(0)" class="add_field_button"><span class="" style="float: right; margin-right: 20px; color: green"><i class="fa fa-plus"></i></span></a>
            </br>
            

              <div class="form-group">
              <label for="description" class="col-md-3 col-xs-12 control-label">Enter Description</label>
              <div class="col-md-6 col-xs-12">                
                
                <textarea cols="50" rows="10" type="text" class="form-control" 
                name="description" id="description" required=""></textarea> 
              </div>
          </div>
          
          <div class="form-group">
            <label for="description" class="col-md-3 col-xs-12 control-label">No of Coupons</label>
              <div class="col-md-6 col-xs-12">
              <span class="input-group-addon"><i class="fa fa-pencil"></i></span>                
                <input  type="text" class="form-control" 
                name="no_of_coupons" id="no_of_coupons" ></input> 
              </div>
          </div>
  

            

          </div>
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/packages" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
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
  //alert(values);
  $.ajax({ 
           type: "POST", 
           url: '<?php echo base_url();?>admin/register/getMultipleSubjects', 
           data: "course_ids="+course_ids,
           complete: function(data){  
            var op = data.responseText.trim();
            $("#video_subject_ids").html(op);
            $("#qbank_subject_ids").html(op);
            $(".chosen-select2").trigger("chosen:updated");
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

$(document).ready(function() {
      var max_fields      = 10; //maximum input boxes allowed

      var wrapper         = $(".input_fields_wrap"); //Fields wrapper
      var add_button      = $(".add_field_button"); //Add button ID
      
      var html = $(".input_fields_wrap").html();//alert(html);
      var x = 1; //initlal text box count
      $(add_button).click(function(e){ //on add input button click
          e.preventDefault();
          if(x < max_fields){ //max input box allowed
              x++; //text box increment
              $(wrapper).append('<div class="input_fields_wrap"><div class="form-group"><label for="title" class="col-md-3 col-xs-12 control-label">Select Months '+x+' </label><div class="col-md-6 col-xs-12"><select class="form-control" name="months[]" id="month_ids" required="" ><option value="3_d">3 days</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="18">1.6 years</option><option value="24">2 years</option><option value="30">2.6 years</option><option value="36">3 years</option><option value="42">3.6 years</option><option value="48">4 years</option><option value="54">4.6 years</option><option value="60">5 years</option></select></div></div><div class="form-group"><label for="title" class="col-md-3 col-xs-12 control-label">Enter Price '+x+' </label><div class="col-md-6 col-xs-12"><span class="input-group-addon"><i class="fa fa-pencil"></i></span><input type="text" class="form-control" name="prices[]" id="price" required=""/></div></div><a href="javascript:void(0)" class="remove_field"><span class="" style="  color: red; float: right; margin-right: 100px;"><i class="fa fa-minus"></i></span></a></div></div>'); //add input box
          }
      });      
      $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); $(this).parent('div').remove(); x--;
      });
  }); 


$("#select_all2").change(function(){  
  var status = this.checked; 
  $('.checkbox2').each(function(){ 
    this.checked = status; 
  });
});

$("#select_all3").change(function(){  
  var status = this.checked; 
  $('.checkbox3').each(function(){ 
    this.checked = status; 
  });
});

$("#select_all4").change(function(){  
  var status = this.checked; 
  $('.checkbox4').each(function(){ 
    this.checked = status; 
  });
});

$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox1').each(function(){
                this.checked = true;

                var course_ids = []
                $("input[name='course_ids[]']:checked").each(function ()
                {
                    course_ids.push(parseInt($(this).val()));
                });
                  //alert(course_ids);

                    var package_id = '';
                    $.ajax({ 
                         type: "POST", 
                        url: '<?php echo base_url();?>admin/register/getupdateMultipleSubjects', 
                         data: "course_ids="+course_ids+"&package_id="+package_id,
                         complete: function(data){  
                          var op = data.responseText.trim();
                          $("#video_subject_ids").html(op);
                          
                         
                             }
                   });

                    $.ajax({ 
                         type: "POST", 
                        url: '<?php echo base_url();?>admin/register/getQbankMultipleSubjects', 
                         data: "course_ids="+course_ids+"&package_id="+package_id,
                         complete: function(data){  
                          var op = data.responseText.trim();
                         
                          $("#qbank_subject_ids").html(op);
                         
                             }
                   });

                    $.ajax({ 
                       type: "POST", 
                       url: '<?php echo base_url();?>admin/register/getMultipleTestseries', 
                       data: "course_ids="+course_ids+"&package_id="+package_id,
                       complete: function(data){  
                        var op = data.responseText.trim();
                        $("#test_series_ids").html(op);
                       // $(".chosen-select4").val('').trigger("chosen:updated");
                           }
                 });

            });
        }else{
             $('.checkbox1').each(function(){
                this.checked = false;
                 var course_ids = []
                $("input[name='course_ids[]']:checked").each(function ()
                {
                    course_ids.push(parseInt($(this).val()));
                });

                var package_id = $('#package_id').val();
                    $.ajax({ 
                         type: "POST", 
                        url: '<?php echo base_url();?>admin/register/getupdateMultipleSubjects', 
                         data: "course_ids="+course_ids+"&package_id="+package_id,
                         complete: function(data){  
                          var op = data.responseText.trim();
                          $("#video_subject_ids").html(op);
                          
                          }
                   });

                    $.ajax({ 
                         type: "POST", 
                        url: '<?php echo base_url();?>admin/register/getQbankMultipleSubjects', 
                         data: "course_ids="+course_ids+"&package_id="+package_id,
                         complete: function(data){  
                          var op = data.responseText.trim();
                         
                          $("#qbank_subject_ids").html(op);
                         
                             }
                   });

                    $.ajax({ 
                       type: "POST", 
                       url: '<?php echo base_url();?>admin/register/getMultipleTestseries', 
                       data: "course_ids="+course_ids+"&package_id="+package_id,
                       complete: function(data){  
                        var op = data.responseText.trim();
                        $("#test_series_ids").html(op);
                       // $(".chosen-select4").val('').trigger("chosen:updated");
                           }
                 });
                  

            });
        }
    });
    
    $('.checkbox1').on('click',function(){
      

              var course_ids = [];
                $("input[name='course_ids[]']:checked").each(function ()
                {
                    course_ids.push(parseInt($(this).val()));
                });
               // alert(course_ids);

               var package_id = $('#package_id').val();
                $.ajax({ 
                         type: "POST", 
                        url: '<?php echo base_url();?>admin/register/getupdateMultipleSubjects', 
                         data: "course_ids="+course_ids+"&package_id="+package_id,
                         complete: function(data){  
                          var op = data.responseText.trim();
                          //alert(op);
                         $("#video_subject_ids").html(op);
                        
                             }
                   });

                $.ajax({ 
                         type: "POST", 
                        url: '<?php echo base_url();?>admin/register/getQbankMultipleSubjects', 
                         data: "course_ids="+course_ids+"&package_id="+package_id,
                         complete: function(data){  
                          var op = data.responseText.trim();
                         
                          $("#qbank_subject_ids").html(op);
                         
                             }
                   });

                $.ajax({ 
                       type: "POST", 
                       url: '<?php echo base_url();?>admin/register/getMultipleTestseries', 
                       data: "course_ids="+course_ids+"&package_id="+package_id,
                       complete: function(data){  
                        var op = data.responseText.trim();
                        $("#test_series_ids").html(op);
                       // $(".chosen-select4").val('').trigger("chosen:updated");
                           }
                 });

        /*if($('.checkbox1:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
             
        }else{
            $('#select_all').prop('checked',false);
        }*/
    });
});
</script>




