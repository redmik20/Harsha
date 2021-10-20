
<div class="main-content">
        <div class="main-content-inner">
          <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
              try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>
            <ul class="breadcrumb">
              <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="<?php echo site_url();?>admin/dashboard">Home</a>
              </li>
              <li>                 
                <a href="<?php echo site_url();?>admin/eventcreation"> Event</a>
              </li>
              <li class="active"> Edit</li>
            </ul><!-- /.breadcrumb -->            
          </div>

          <div class="page-content">
            <div class="page-header-2">
              <h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
                <i class="menu-icon fa fa-list-ul blue"></i> Event
                <span class="label label-purple arrowed">Edit<span>
              </h1>
              <div class="pull-right ">              
                 <input type="hidden" name="hiv" id="hiv" value="0" />
              </div>
            </div><!-- /.page-header -->
            
             <?php echo $message; ?>
                   
            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                    <form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/eventcreation/update_records" enctype="multipart/form-data">
                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                          
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Select State<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <select class="form-control" name="state_id" id="state_id" required="" onchange="getOrganisations(this.value)" data-parsley-id="8530">
                                <option value="">Select State</option>
                                  <?php
                                if(!empty($states))
                                {
                                  foreach($states as $state)
                                  {
                                    ?>
                                    <option value="<?=$state['id'];?>" <?php if($state['id'] == $record['state_id']){?> selected  <?php }?> ><?=$state['state'];?></option>
                                    <?php
                                  }
                                }
                                ?>
                              </select>
                            </div>
                          </div>            
                        </div>                  
                      </div>

                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Select Organisation<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <select class="form-control" name="organisation_id" id="organisation_id" required="" onchange="getCenters(this.value)" data-parsley-id="0399">
                                       <option value="">Select Organisation</option> 
                                       <?php
                                if(!empty($organisations))
                                {
                                  foreach($organisations as $org)
                                  {
                                    ?>
                                    <option value="<?=$org['id'];?>"  <?php if($org['id'] == $record['organisation_id']){?> selected  <?php }?> ><?=$org['organisation_name'];?></option>
                                    <?php
                                  }
                                }
                                ?>
                              </select>
                            </div>
                          </div>            
                          </div>                  
                      </div>

                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Center<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <select class="form-control" name="center_id" id="center_id" required="" onchange="getCourses(this.value)" data-parsley-id="3661">
                                <option value="">Select Center</option>
                               <?php
                                if(!empty($centers))
                                {
                                  foreach($centers as $center)
                                  {
                                    ?>
                                    <option value="<?=$center['id'];?>"  <?php if($center['id'] == $record['center_id']){?> selected  <?php }?> ><?=$center['center'];?></option>
                                    <?php
                                  }
                                }
                                ?>
                              </select>
                            </div>
                          </div>            
                          </div>                  
                      </div>
                    <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1"> 
                    <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Courses<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                    <select class="form-control" name="course_id" id="course_id" required="" onchange="getbatchs1(this.value)">
                                <option value="">Select Course</option>
                                <?php
                                if(!empty($courses))
                                {
                                  foreach($courses as $course)
                                  {
                                    ?>
                                    <option value="<?=$course['id'];?>" <?php if($course['id'] == $record['course_id']){?> selected  <?php }?>><?=$course['course_name'];?></option>
                                    <?php
                                  }
                                }
                                ?>
                              </select>
                    </div>
                  </div>
                  </div>
                  </div>


                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Batch<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <select class="form-control standardSelect" id="batch_id" name="batch_ids[]" required=""  multiple>
                              <option value="">Please select</option>  
                              <?php
                                if(!empty($batchs))
                                {
                                  foreach($batchs as $batch)
                                  {

                                    $db_batch_ids= explode(',',$record['batch_ids']);
                                    ?>
                                    <option value="<?=$batch['id'];?>"
                                     <?php 
                                     foreach($db_batch_ids as $db_id){
                                     if($batch['id'] == $db_id){?> 
                                      selected  
                                     <?php } } ?>

                                     ><?=$batch['batch_name'];?></option>
                                    <?php
                                  }
                                }
                                ?>                                                
                              </select>
                            </div>
                          </div>            
                        </div>                  
                      </div>

                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Event Name<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <input class="form-control" placeholder="" type="text" name="event_name" value="<?php echo $record['event_name']; ?>" id="frist_name" onkeyup="" required="" data-parsley-id="6180">
                            </div>
                          </div>            
                        </div>                  
                      </div>

                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Stock Included</label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <select class="form-control" id="stock_included" name="stock_included" required=""  onchange="getinstock(this.value)" >
                              <option value="">Please select</option>    
                              <option value="yes" <?php if($record['stock_included'] == 'yes'){ ?> selected <?php }?> >Yes</option>    
                              <option value="no" <?php if($record['stock_included'] == 'no'){ ?> selected <?php }?>>No</option>                                                  
                              </select>
                            </div>
                          </div>            
                        </div>                  
                      </div>
<div id="stock_fields">
                      <?php if($record['stock_included'] == 'yes'){ ?>
                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Select In Stock</label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <select class="form-control" id="in_stock_id" name="in_stock_id" required="" >
                              <option value="">Please select</option>  

                               <?php
                                if(!empty($in_stock))
                                {
                                  foreach($in_stock as $in)
                                  {
                                    ?>
                                    <option value="<?=$in['id'];?>" <?php if($in['id'] == $record['in_stock_id']){?> selected  <?php }?> ><?=$in['stock_name'];?> -- (<?php echo $in['count']?>)</option>
                                    <?php
                                  }
                                }
                                ?>  
                                                                               
                              </select>
                            </div>
                          </div>            
                        </div>
                      </div>
                      <?php }?>
 </div>
                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Start Date<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <input class="form-control date-picker" name="start_date" id="id-date-picker-1" value="<?php echo $record['start_date']; ?>" data-date-format="yyyy-mm-dd" data-parsley-id="9055">
                            </div>
                          </div>            
                        </div>                  
                      </div>

                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Start Time<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <input class="form-control" name="start_time" id="id-date-picker-1" value="<?php echo $record['start_time']; ?>" type="time">
                            </div>
                          </div>            
                        </div>                  
                      </div>

                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">End Date<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <input class="form-control date-picker" name="end_date" id="id-date-picker-1" value="<?php echo $record['end_date']; ?>" data-date-format="yyyy-mm-dd" data-parsley-id="9055">
                            </div>
                          </div>            
                        </div>                  
                      </div>

                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">End Time<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <input class="form-control" name="end_time" id="id-date-picker-1" value="<?php echo $record['end_time']; ?>" type="time">
                            </div>
                          </div>            
                        </div>                  
                      </div>

                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Location<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <input class="form-control" placeholder="" type="text" name="location" value="<?php echo $record['location']; ?>" id="location" onkeyup="" required="" data-parsley-id="6180">
                            </div>
                          </div>            
                        </div>                  
                      </div>

<?php 
 $mobile_numbers=explode(',',$record['mobile_numbers']);
 foreach($mobile_numbers as $mobile){ ?>
                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Mobile Number<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <input class="form-control" name="mobile_numbers[]"  value="<?php  echo $mobile ;?>" required="" data-parsley-required-message="Please enter Mobile" parsley-type="text" data-parsley-check_emp_mobile="" data-parsley-trigger="keyup" data-parsley-trigger="change" data-parsley-pattern="/^[0-9]+$/"   data-parsley-pattern-message="Enter valid Mobile no" data-parsley-minlength="10" data-parsley-minlength-message="Mobile number should not be less than 10 digits" data-parsley-maxlength="10" data-parsley-maxlength-message="Mobile number should not be greater than 10 digits">
                             <!--  <a href="javascript:void(0)" class="remove_field"><span class="" style="float: right; margin-right: 200px; color: red"><i class="fa fa-minus"></i></span></a> -->
                             
                            </div>
                          </div>            
                        </div>                  
                      </div>
<?php }?> 

 <a href="javascript:void(0)" class="add_field_button"><span class="" style="float: right; margin-right: 200px; color: green"><i class="fa fa-plus"></i></span></a>


                       <div class="input_fields_wrap gray points-cont">

                       </div>

                      <!-- <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                          <a class="btn btn-primary btn-sm" type="edit" href="#">Create QR Code</a>
                          <a class="btn btn-primary btn-sm" type="edit" href="#">Send SMS Link</a>
                        </div>                
                      </div> -->

                      <input type="hidden" name="id"  class="btn btm-sm btn-success btn-sm" value="<?php echo $record['id']; ?>" />

                  <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                      <input type="submit" name="edit"  class="btn btm-sm btn-success btn-sm" value="Edit" />
                      <a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url();?>admin/eventcreation">Back
                      </a>
                    </div>                
                  </div><!-- End Row -->
              </form>
              </div>
              </div>
            </div>
            
        </div>
      </div><!-- /.main-content -->
      
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/chosen/chosen.min.css">

<script src="<?php echo base_url(); ?>assets/admin/js/chosen/chosen.jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(".standardSelect").chosen({
            disable_search_threshold: 10,
            no_results_text: "Oops, nothing found!",
            width: "100%"
        });
    });

function getbatchs1(course_id){
    //alert(exam_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/student/getbatchs',
      data: {course_id: course_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        //$("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#batch_id").html(data);
        //$("#wait").css("display", "none");
        $("#batch_id").trigger("chosen:updated");
      }
    });
  }
</script>
<script type="text/javascript">
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
              $(wrapper).append('<div class="row"><div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1"><div class="row form-group frm-btm"><div class="col-lg-3 col-sm-3 col-md-3 col-xs-5"><label class="input-text">Mobile Number <span class="red bigger-120">*</span></label></div><div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div><div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk"><input class="form-control" name="mobile_numbers[]" required="" data-parsley-required-message="Please enter Mobile" parsley-type="text" data-parsley-check_emp_mobile="" data-parsley-trigger="keyup" data-parsley-trigger="change" data-parsley-pattern="/^[0-9]+$/"   data-parsley-pattern-message="Enter valid Mobile no" data-parsley-minlength="10" data-parsley-minlength-message="Mobile number should not be less than 10 digits" data-parsley-maxlength="10" data-parsley-maxlength-message="Mobile number should not be greater than 10 digits"></div></div></div><a href="javascript:void(0)" class="remove_field"><span class="" style=" color: red"><i class="fa fa-minus"></i></span></a></div>'); //add input box
          }
      });      
      $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); $(this).parent('div').remove(); x--;
      });
  });


function getinstock(value){
  if(value == 'yes'){
    //$("#stock_fields").show();
      var state_id=$("#state_id").val();
      var organisation_id=$("#organisation_id").val();
      var center_id= $("#center_id").val();
      var course_id= $("#course_id").val();
      var batch_id= $("#batch_id").val();
        
      $.ajax({
        type: 'post',
        url: '<?=base_url();?>admin/eventcreation/getstockdata',
        data: {state_id:state_id,organisation_id:organisation_id,center_id: center_id,course_id: course_id,batch_id: batch_id},
        beforeSend: function(xhr){
          xhr.overrideMimeType("text/plain; charset=utf-8");
          //$("#wait").css("display", "block");
        },
        success: function(data){ //alert(data);
          $("#stock_fields").html(data);
          $("#stock_fields").show();
          //$("#wait").css("display", "none");
          //$("#batch_id").trigger("chosen:updated");
        }
      });
  }else{
    $("#stock_fields").hide();
  }
}
</script>