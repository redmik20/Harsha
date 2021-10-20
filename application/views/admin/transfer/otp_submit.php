
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
              <li class="active">OTP Submit</li>
            </ul><!-- /.breadcrumb -->            
          </div>

          <div class="page-content">
            <div class="page-header-2">
              <h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
                <i class="menu-icon fa fa-list-ul blue"></i>Payment Mode to Mode
                <span class="label label-purple arrowed">OTP Submit<span>
              </h1>
              <div class="pull-right ">              
                 <input type="hidden" name="hiv" id="hiv" value="0" />
                           </div>
            </div><!-- /.page-header -->            
             <?php echo $message; ?>                   
            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/transfer_funds/otp_form/<?php echo $record['id']?>" enctype="multipart/form-data">
                
                                             
                                  <!-- <div id="items" class="form-group">
                                    <label class="col-md-4 control-label" for="textinput">Payment Mode Name</label>
                                  <div class="col-md-8 margin-bottom">
                                    <input id="payment_mode" name="payment_mode" type="text" placeholder="Enter Payment Mode" class="form-control input-md" required>
                                    <br>
                                  </div>
                                  </div> --> 
                  

                    

                 <div class="row">
                  <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">
                <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                      <label class="input-text">Enter OTP<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <input class="form-control" type="text" name="otp" id="otp" value="" required="">
                     
                    </div>
                  </div>  
                  </div>  
                  </div>   

                                               
                                                
                              
                            <!-- <div class="col-xs-6 col-md-6 col-lg-6">
                              <a id="add" class="btn add-more button-yellow uppercase" type="button">+ Add another Field</a> <a class="delete btn button-white uppercase">- Remove Field</a>
                            </div> -->
                       
                      
                      <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                          <input type="submit" name="submit"  class="btn btm-sm btn-success btn-sm" value="Submit" /> 
                          
                          <a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url();?>admin/transfer_funds">Back
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
