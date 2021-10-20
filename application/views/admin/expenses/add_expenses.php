
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
                <a href="<?php echo site_url();?>admin/expenses">Expenses</a>
              </li>
              <li class="active"> Add</li>
            </ul><!-- /.breadcrumb -->            
          </div>

          <div class="page-content">
            <div class="page-header-2">
              <h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
                <i class="menu-icon fa fa-list-ul blue"></i>Expenses
                <span class="label label-purple arrowed">Add</span>
              </h1>
              <div class="pull-right ">              
                 <input type="hidden" name="hiv" id="hiv" value="0" />
              </div>
            </div><!-- /.page-header -->
            
             <?php echo $message; ?>
                   
            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                    <form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/expenses/update_records" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Select State<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <select class="form-control" name="state_id" id="state_id" required="" onchange="getOrganisations(this.value)">
                                <option value="">Select State</option>
                                <?php
                                if(!empty($states))
                                {
                                  foreach($states as $state)
                                  {
                                    ?>
                                    <option value="<?=$state['id'];?>" 
                                      <?php if(!empty($employee)){ 
                                        if($employee['state_id'] == $state['id']){?> 
                                        selected 
                                      <?php } } ?> ><?=$state['state'];?></option>
                                    <?php
                                  }
                                }
                                ?>
                              </select>
                    </div>
                  </div>

                   <div class="row form-group frm-btm">
                      <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                        <label class="input-text">Select Organisation <span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                        <select class="form-control" name="organisation_id" id="organisation_id" required="" onchange="getCenters(this.value)">
                                 <option value="">Select Organisation</option> 

                                  <?php
                                if(!empty($organisations))
                                {
                                  foreach($organisations as $org)
                                  {
                                    ?>
                                    <option value="<?=$org['id'];?>" 
                                      <?php if(!empty($employee)){ 
                                        if($employee['organisation_id'] == $org['id']){?> 
                                        selected 
                                      <?php } } ?> ><?=$org['organisation_name'];?></option>
                                    <?php
                                  }
                                }
                                ?>
                                </select>
                      </div>  
                    </div>        
                

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Center<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <select class="form-control" name="center_id" id="center_id" required="" onchange="getPaymentModes(this.value)">
                                <option value="">Select Center</option>

                                <?php
                                if(!empty($centers))
                                {
                                  foreach($centers as $center)
                                  {
                                    ?>
                                    <option value="<?=$center['id'];?>" 
                                      <?php if(!empty($employee)){ 
                                        if($employee['center_id'] == $center['id']){?> 
                                        selected 
                                      <?php } } ?> ><?=$center['center'];?></option>
                                    <?php
                                  }
                                }
                                ?>
                                
                              </select>
                    </div>
                  </div>
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Date <span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                    <!-- <input class="form-control" name="date" id="" value="<?php echo date('d-m-Y')?>" readonly> -->
                    <input class="form-control date-picker" name="date" id="id-date-picker-1" value="" data-date-format="yyyy-mm-dd" >
                    </div>
                  </div>

                 

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Category<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <select class="form-control" name="category_id" id="category_id" required="">
                        <option value="">Select Category</option>

                        <?php
                                if(!empty($categories))
                                {
                                  foreach($categories as $cat)
                                  {
                                    ?>
                                    <option value="<?=$cat['id'];?>" ><?=$cat['category_name'];?></option>
                                    <?php
                                  }
                                }
                                ?>
                        
                      </select>
                    </div>
                  </div> 

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Paid For</label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="" type="text" name="paid_for" value="" id="paid_for" onkeyup="">
                    </div>
                  </div>
                  
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Paid At</label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="" type="text" name="paid_to" value="" id="paid_to" onkeyup="">
                    </div>
                  </div>

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Amount<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="" type="text" name="amount" value="" id="amount" onkeyup="" required>
                    </div>
                  </div>  

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Payment Mode<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <select class="form-control" name="payment_mode_id" id="payment_mode_id" required="">
                        <option value="">Select Payment Mode</option>
                        <?php
                                if(!empty($payment_modes))
                                {
                                  foreach($payment_modes as $pm)
                                  {
                                    ?>
                                    <option value="<?=$pm['id'];?>" ><?=$pm['payment_mode'];?></option>
                                    <?php
                                  }
                                }
                          ?>
                      </select>
                    </div>
                  </div> 

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Transaction Id<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="" type="text" name="transaction_id" value="" id="transaction_id" onkeyup="" required>
                    </div>
                  </div>

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Remarks</label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7  col-md-7 col-sm-7 col-xs-6">
                    <textarea class="form-control" type="text" rows="6" placeholder="Should not exceed 250 Characters..." name="remarks" id="remarks" value="" data-parsley-id="8322"></textarea><ul class="parsley-errors-list" id="parsley-id-8322"></ul>
                    </div>
                  </div> 

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Select Image type<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <select class="form-control" name="image_type" id="image_type" required="" onchange="getImageType(this.value)">
                                <option value="1">Image Path</option>
                                <option value="2">Upload Image</option>
                      </select>
                    </div>
                  </div>

                  <div class="row form-group frm-btm" id="image_path_div">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Image Path </label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" placeholder="" type="text" name="image_path" value="" id="image_path" onkeyup=""  data-parsley-id="0583"><ul class="parsley-errors-list" id="parsley-id-0583"></ul>
                    </div>
                  </div> 

                  <div class="row form-group frm-btm" id="image_div" style="display: none">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Attach Receipt</label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="file-input" placeholder="" type="file" name="image" value="" id="image" onkeyup=""  data-parsley-id="0583"><ul class="parsley-errors-list" id="parsley-id-0583"></ul>
                    </div>
                  </div>    
                                    
                  </div>                  
                </div>

                <input  type="hidden" name="param" value="<?php echo $param;?>"  >

                <div class="col-lg-12 col-xs-12 col-sm-12">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                    <input type="submit" name="add"  class="btn btm-sm btn-success btn-sm" value="Send for Approval" />
                  <?php if($param == 'add_expense'){?>
                  <a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url();?>admin/expenses">Back </a>
                 <?php  }else{ ?>
                  <a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url();?>admin/agent_dashboard">Back </a>
                 <?php }?>
                  </div>                
                </div><!-- End Row -->
              </form>
              </div>
              </div>
            </div>
            
        </div>
      </div><!-- /.main-content -->
      
  <script type="text/javascript">

function getPaymentModes(center_id){

  var state_id=$("#state_id").val();
    var organisation_id=$("#organisation_id").val();
    var center_id=$("#center_id").val();

    $.ajax({
            type: 'post',
            url: '<?=base_url();?>admin/common/getExpensePaymentModes',
            data: {state_id: state_id,organisation_id:organisation_id,center_id:center_id},
            beforeSend: function(xhr){
              xhr.overrideMimeType("text/plain; charset=utf-8");
              $("#wait").css("display", "block");
            },
            success: function(data){ 
              //var json = $.parseJSON(data); 
              //alert("OTP Send Successfully");
              $("#payment_mode_id").html(data);
            }
          });

    $.ajax({
            type: 'post',
            url: '<?=base_url();?>admin/common/getCategories',
            data: {state_id: state_id,organisation_id:organisation_id,center_id:center_id},
            beforeSend: function(xhr){
              xhr.overrideMimeType("text/plain; charset=utf-8");
              $("#wait").css("display", "block");
            },
            success: function(data){ 
              //var json = $.parseJSON(data); 
              //alert("OTP Send Successfully");
              $("#category_id").html(data);
            }
          });
  }

  function getImageType(value){

    if(value == 1){
         $("#image_path_div").show();
         $("#image_div").hide();
    }else if(value == 2){
         $("#image_path_div").hide();
         $("#image_div").show();
    }

  }

  </script>