
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
                <a href="<?php echo site_url();?>admin/eventcreation"> Event Creation</a>
              </li>
              <li class="active"> Add</li>
            </ul><!-- /.breadcrumb -->            
          </div>

          <div class="page-content">
            <div class="page-header-2">
              <h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
                <i class="menu-icon fa fa-list-ul blue"></i> Event Creation
                <span class="label label-purple arrowed">Add<span>
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
                                    <option value="<?=$state['id'];?>"><?=$state['state'];?></option>
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
                              <input class="form-control" placeholder="" type="text" name="event_name" value="" id="frist_name" onkeyup="" required="" data-parsley-id="6180">
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
                              <select class="form-control" id="stock_included" name="stock_included" required="" onchange="getinstock(this.value)">
                              <option value="">Please select</option>    
                              <option value="yes">Yes</option>    
                              <option value="no">No</option>                                                  
                              </select>
                            </div>
                          </div>            
                        </div>                  
                      </div>
                      <div id="stock_fields">
                       
                      </div>
                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Start Date<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <input class="form-control date-picker" name="start_date" id="id-date-picker-1" value="" data-date-format="yyyy-mm-dd" data-parsley-id="9055">
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
                              <input class="form-control" name="start_time" id="id-date-picker-1" value="" type="time">
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
                              <input class="form-control date-picker" name="end_date" id="id-date-picker-1" value="" data-date-format="yyyy-mm-dd" data-parsley-id="9055">
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
                              <input class="form-control" name="end_time" id="id-date-picker-1" value="" type="time">
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
                              <input class="form-control" placeholder="" type="text" name="location" value="" id="location" onkeyup="" required="" data-parsley-id="6180">
                            </div>
                          </div>            
                        </div>                  
                      </div>

                      <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Mobile Number<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <input class="form-control" name="mobile_numbers[]" required="" data-parsley-required-message="Please enter Mobile" parsley-type="text" data-parsley-check_emp_mobile="" data-parsley-trigger="keyup" data-parsley-trigger="change" data-parsley-pattern="/^[0-9]+$/"   data-parsley-pattern-message="Enter valid Mobile no" data-parsley-minlength="10" data-parsley-minlength-message="Mobile number should not be less than 10 digits" data-parsley-maxlength="10" data-parsley-maxlength-message="Mobile number should not be greater than 10 digits">

                              <a href="javascript:void(0)" class="add_field_button"><span class="" style="float: right; margin-right: 200px; margin-right: -34px;margin-top: -25px;color: green"><i class="fa fa-plus"></i></span></a>
                            </div>
                          </div>            
                        </div>                  
                      </div>

                       <div class="input_fields_wrap gray points-cont">

                       </div>

                      <!-- <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                          <a class="btn btn-primary btn-sm" type="edit" href="#">Create QR Code</a>
                          <a class="btn btn-primary btn-sm" type="edit" href="#">Send SMS Link</a>
                        </div>                
                      </div> -->

                  <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                      <input type="submit" name="add"  class="btn btm-sm btn-success btn-sm" value="Add" />
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
              $(wrapper).append('<div class="row"><div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1"><div class="row form-group frm-btm"><div class="col-lg-3 col-sm-3 col-md-3 col-xs-5"><label class="input-text">Mobile Number '+x+'<span class="red bigger-120">*</span></label></div><div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div><div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk"><input class="form-control" name="mobile_numbers[]" required="" data-parsley-required-message="Please enter Mobile" parsley-type="text" data-parsley-check_emp_mobile="" data-parsley-trigger="keyup" data-parsley-trigger="change" data-parsley-pattern="/^[0-9]+$/"   data-parsley-pattern-message="Enter valid Mobile no" data-parsley-minlength="10" data-parsley-minlength-message="Mobile number should not be less than 10 digits" data-parsley-maxlength="10" data-parsley-maxlength-message="Mobile number should not be greater than 10 digits"></div></div></div><a href="javascript:void(0)" class="remove_field"><span class="" style=" color: red"><i class="fa fa-minus"></i></span></a></div>'); //add input box
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