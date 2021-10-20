
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
                <a href="<?php echo site_url();?>admin/stockdepartment">Stock Name</a>
              </li>
              <li class="active"> Edit</li>
            </ul><!-- /.breadcrumb -->            
          </div>

          <div class="page-content">
            <div class="page-header-2">
              <h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
                <i class="menu-icon fa fa-list-ul blue"></i>Stock Name
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
                    <form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/stockdepartment/update_record" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">
                  
                   <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                      <label class="input-text">Select State<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <select class="form-control" name="state_id" id="state_id" required="" onchange="getOrganisations(this.value)">
                                <option value="">Select State</option>
                                <?php
                                if(!empty($states))
                                {
                                  foreach($states as $state)
                                  {
                                    ?>
                                    <option value="<?=$state['id'];?>" <?php if($state['id'] == $record['state_id']){?> selected <?php }?>><?=$state['state'];?></option>
                                    <?php
                                  }
                                }
                                ?>
                              </select>
                    </div>
                  </div>

                  <div class="row form-group frm-btm">
                      <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label class="input-text">Select Organisation <span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                        <select class="form-control" name="organisation_id" id="organisation_id" required="" onchange="getCenters(this.value)">
                                 <option value="">Select Organisation</option> 
                                 <?php
                                if(!empty($organisations))
                                {
                                  foreach($organisations as $organisation)
                                  {
                                    ?>
                                    <option value="<?=$organisation['id'];?>" <?php if($organisation['id'] == $record['organisation_id']){?> selected <?php }?> ><?=$organisation['organisation_name'];?></option>
                                    <?php
                                  }
                                }
                                ?>

                        </select>
                      </div>  
                    </div>        
                

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                      <label class="input-text">Center<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <select class="form-control" name="center_id" id="center_id" required="" onchange="getCourses(this.value)">
                                <option value="">Select Center</option>
                                <?php
                                if(!empty($centers))
                                {
                                  foreach($centers as $center)
                                  {
                                    ?>
                                    <option value="<?=$center['id'];?>" <?php if($center['id'] == $record['center_id']){?> selected <?php }?>><?=$center['center'];?></option>
                                    <?php
                                  }
                                }
                                ?>
                              </select>
                    </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Select Course <span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <select class="form-control" name="course_id" id="course_id" required="" onchange="getbatchs(this.value)">
                                <option value="">Select Course</option>
                                <?php
                                if(!empty($courses))
                                {
                                  foreach($courses as $course)
                                  {
                                    ?>
                                    <option value="<?=$course['id'];?>" <?php if($course['id'] == $record['course_id']){?> selected <?php }?> ><?=$course['course_name'];?></option>
                                    <?php
                                  }
                                }
                                ?>
                              </select>
                    </div>
                  </div>

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Select Batch <span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <select class="form-control standardSelect" name="batch_ids[]" id="batch_id" required multiple>
                                <option value="">Select Batch</option>
                                <?php
                                if(!empty($batchs))
                                {
                                  foreach($batchs as $batch)
                                  {

                                    $db_batch_ids=explode(',',$record['batch_id']);
                                    ?>
                                    <option value="<?=$batch['id'];?>" 
                                       
                                      <?php foreach($db_batch_ids as $r_id){
                            if($r_id == $batch['id']){?> selected <?php } }?>
                              ><?=$batch['batch_name'];?></option>
                                    <?php
                                  }
                                }
                                ?>
                              </select>
                    </div>
                  </div>
                  
                  
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Stock Name <span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="" type="text" name="stock_name" value="<?php echo $record['stock_name'] ?>" id="stock_name" onkeyup="" required>
                    </div>
                  </div>

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                      <label class="input-text">Count<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <b>
                      <input class="form-control" placeholder="" type="text" name="count" value="<?php echo $record['count'] ?>" id="count" onkeyup="" required>
                    </b>
                    </div>
                  </div>
                                    

                    <input class="form-control" type="hidden" name="instock_id" value="<?php echo $record['id']; ?>" >
                    
                      
                  
                                    
                  </div>                  
                </div>
                
                <div class="col-lg-12 col-xs-12 col-sm-12">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                  <input type="submit" name="edit"  class="btn btm-sm btn-success btn-sm" value="Update" /> 
                  
                  <a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url();?>admin/stockdepartment">Back
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

    </script>
      <script type="text/javascript">
  function getbatchs1(course_id){
    //alert(exam_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/student/getbatchs',
      data: {course_id: course_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#batch_id").html(data);
        //$("#wait").css("display", "none");
        $("#batch_id").trigger("chosen:updated");
      }
    });
  }
      </script>
  