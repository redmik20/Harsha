
      <div class="main-content">
        <div class="main-content-inner">
          <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
              try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>
            <ul class="breadcrumb">
              <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <?php if($this->session->userdata('user_type') == 'employee'){ ?>
                <a href="<?php echo site_url();?>admin/agent_dashboard">Home</a>
                <?php } else { ?>
                <a href="<?php echo site_url();?>admin/dashboard">Home</a>
                <?php } ?>
              </li>
              <li>                 
                <a href="<?php echo site_url();?>admin/payment_mode">Transfer Mode to Mode</a>
              </li>
              <li class="active">Transfer</li>
            </ul><!-- /.breadcrumb -->            
          </div>

          <div class="page-content">
            <div class="page-header-2">
              <h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
                <i class="menu-icon fa fa-list-ul blue"></i>Payment Mode to Mode
                <span class="label label-purple arrowed">Transfer<span>
              </h1>
              <div class="pull-right ">              
                 <input type="hidden" name="hiv" id="hiv" value="0" />
                           </div>
            </div><!-- /.page-header -->            
             <?php echo $message; ?>                   
            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/transfer_funds/send_otp" enctype="multipart/form-data">
                
                                             
                                  <!-- <div id="items" class="form-group">
                                    <label class="col-md-4 control-label" for="textinput">Payment Mode Name</label>
                                  <div class="col-md-8 margin-bottom">
                                    <input id="payment_mode" name="payment_mode" type="text" placeholder="Enter Payment Mode" class="form-control input-md" required>
                                    <br>
                                  </div>
                                  </div> --> 
                  <div class="row">
                  <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">

                     <!-- <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                      <label class="input-text">Select Amount Type<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <select class="form-control" name="amount_type" id="amount_type" required="" >
                                <option value="">Select Amount Type</option>
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>   
                      </select>
                    </div>
                  </div> -->

                 

                    <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Select State<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <select class="form-control" name="state_id" id="state_id" required="" onchange="getOrganisations(this.value)" >
                                <option value="">Select State</option>
                                <?php
                                if(!empty($states))
                                {
                                  foreach($states as $state)
                                  {
                                    ?>
                                    <option value="<?=$state['id'];?>"
                                      <?php if(!empty($employee)){ 
                                        if($employee['state_id'] == $state['id']){ ?> 
                                        selected 
                                      <?php } } ?>
                                      >
                                      <?=$state['state'];?>
                                        
                                      </option>
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
                        <select class="form-control" name="organisation_id" id="organisation_id" required="" onchange="getCenters(this.value)" >
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
        <select class="form-control" name="center_id" id="center_id" required="" onchange="getIncomePaymentModes(this.value)" >
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
                        <label class="input-text">Payment Made From <span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <?php $user_type=$this->session->userdata('user_type');
                      if(($employee['payment_mode_id'] != 0)  && ($user_type != 'admin') && ($user_type != 'subadmin')){?>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                         <select class="form-control" name="from_payment_mode_id" id="from_payment_mode_id" required="" >
                                 

                          <?php 
                              $db_from_payment_mode_id=$employee['payment_mode_id'];
                              $query="SELECT * FROM tbl_payment_modes where id='$db_from_payment_mode_id' ";
//echo $query;exit;
                              $from_paym=$this->db->query($query)->row_array();

                                    ?>
                      <option value="<?=$from_paym['id'];?>" selected ><?=$from_paym['payment_mode'];?></option>


                                   
                          
                                  
                                </select>

                      </div>
                      <?php }else if(($user_type == 'admin') || ($user_type == 'subadmin') ){?>
                          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                         <select class="form-control" name="from_payment_mode_id" id="from_payment_mode_id" required="" >
                                  <option value="">Select Payment Mode</option>

                                  <?php
                                if(!empty($payment_modes))
                                {
                                  foreach($payment_modes as $pm)
                                  {
                                    ?>
                                    <option value="<?=$pm['id'];?>"  ><?=$pm['payment_mode'];?></option>
                                    <?php
                                  }
                                }
                          ?>
                                  
                                </select>

                      </div>

                      <?php }else{?>
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                          <b style="color:red">Please give payment mode id to this employee </b>
                        </div>
                      <?php }?> 

                    </div>



                  </div>                  
                </div>

                   <div class="row">
                  <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">

                 <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Select Date <span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                    

                     <input class="form-control date-picker" name="transfer_date" id="id-date-picker-1" value="" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" >
                    </div>
                  </div>
                  </div>
                  </div>

                 <div class="row">
                  <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">
                <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Enter Amount<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <input class="form-control" type="text" name="amount" id="amount" value="" required="">
                     
                    </div>
                  </div>  
                  </div>  
                  </div>   

                  <div class="row">
                  <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">
                    <div class="row form-group frm-btm">
                      <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                        <label class="input-text">Payment Mode To <span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                        <select class="form-control" name="to_payment_mode_id" id="to_payment_mode_id" required="">
                                  <option value="">Select Payment Mode</option>

                            <?php
                              if(($user_type == 'admin') || ($user_type == 'subadmin') ){
                                if(!empty($payment_modes))
                                {
                                  foreach($payment_modes as $pm)
                                  {
                                    ?>
                                    <option value="<?=$pm['id'];?>" ><?=$pm['payment_mode'];?></option>
                                    <?php
                                  }
                                }
                              }else{
                                $user_id=$this->session->userdata('user_id');

                                $user_data=$this->db->query("SELECT to_payment_mode_id FROM tbl_users where user_id='$user_id' ")->row_array();
                                $to_payment_mode_id=$user_data['to_payment_mode_id'];

                                $db_to_payment_mode_ids=explode(',',$to_payment_mode_id);

                                $query="SELECT * FROM tbl_payment_modes where id IN ($to_payment_mode_id)";

                                $to_paym=$this->db->query($query)->result_array();
                                //echo $query;exit;
                                ?>
                                <?php if(!empty($to_paym)){
                                  foreach($to_paym as $py){
                                  ?>

                                  <option value="<?=$py['id'];?>" ><?=$py['payment_mode'];?></option>

                                 
                             
                              <?php } }else{ ?>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <b style="color:red">Please give To payment mode ids to this employee </b>
                                  </div>  


                              <?php }

                              } ?>
                                  
                                </select>

                      </div>  
                    </div>        
                  </div>                  
                </div> 
                                               
                                                
                              
                            <!-- <div class="col-xs-6 col-md-6 col-lg-6">
                              <a id="add" class="btn add-more button-yellow uppercase" type="button">+ Add another Field</a> <a class="delete btn button-white uppercase">- Remove Field</a>
                            </div> -->
                       
                      
                      <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                          <input type="submit" name="submit"  class="btn btm-sm btn-success btn-sm" value="Send OTP" /> 
                          
                          <a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url();?>admin/transfer_funds/transfer_funds_list">Back
                          </a>
                        </div>                
                      </div><!-- End Row -->
                      </form>
                   </div>
               
              
              </div>
              </div>
            </div>
        </div>
      </div><!-- /.main-content -->   
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
<script type="text/javascript">
     $(document).ready(function() {
  $(".delete").hide();
  //when the Add Field button is clicked
  $("#add").click(function(e) {
    $(".delete").fadeIn("1500");
    //Append a new row of code to the "#items" div
    $("#items").append(
      '<div class="next-referral col-4" style="margin-left: 226px;width: 63%;padding-top: 10px;"><input id="payment_mode" name="payment_mode[]" type="text" placeholder="Enter Payment Mode" class="form-control input-md" required></div>'
    );
  });
  $("body").on("click", ".delete", function(e) {
    $(".next-referral").last().remove();
  });
});


function getIncomePaymentModes(center_id){
    //alert(exam_id);
    var state_id=$("#state_id").val();
    var organisation_id=$("#organisation_id").val();
  

    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/common/getPaymentModes',
      data: {state_id: state_id,organisation_id: organisation_id,center_id: center_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#from_payment_mode_id").html(data);
        $("#to_payment_mode_id").html(data);
        $("#wait").css("display", "none");
      }
    });
  }


     </script>
