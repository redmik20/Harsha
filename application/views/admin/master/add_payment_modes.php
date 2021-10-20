
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
                <a href="<?php echo site_url();?>admin/payment_mode">Payment Modes</a>
              </li>
              <li class="active">Add</li>
            </ul><!-- /.breadcrumb -->            
          </div>

          <div class="page-content">
            <div class="page-header-2">
              <h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
                <i class="menu-icon fa fa-list-ul blue"></i>Payment Modes
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
                <form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/payment_modes/update_record" enctype="multipart/form-data">
                
                                             
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
                  </div>

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
                                    <option value="<?=$state['id'];?>"><?=$state['state'];?></option>
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
                                </select>
                      </div>  
                    </div>        
                

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                      <label class="input-text">Center<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <select class="form-control" name="center_id" id="center_id" required="" >
                                <option value="">Select Center</option>
                                
                              </select>
                    </div>
                  </div>

                    <div class="row form-group frm-btm">
                      <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                        <label class="input-text">Payment Mode Name <span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                        <input id="payment_mode" name="payment_mode" type="text" placeholder="Enter Payment Mode" class="form-control " required>

                      </div>  
                    </div>



                  </div>                  
                </div>

                                  <div class="row">
                  <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">
                    <div class="row form-group frm-btm">
                      <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                        <label class="input-text">Attachment To <span class="red bigger-120">*</span></label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                        <select class="form-control" name="attachment_id" id="attachment_id" required="">
                                  <option value="">Select Attachment</option>
                                  <?php
                                  if(!empty($attachments))
                                  {
                                    foreach($attachments as $attch)
                                    {
                                      ?>
                                      <option value="<?=$attch['id'];?>"><?=$attch['attachment_name'];?></option>
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
                        <label class="input-text">Description/Bank Details</label>
                      </div>
                      <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                        <textarea name="description" type="text" class="" id="description" value="" style="margin: 0px; width: 611px; height: 133px;"></textarea>

                      </div>  
                    </div>        
                  </div>                  
                </div>                               
                                                
                              
                            <!-- <div class="col-xs-6 col-md-6 col-lg-6">
                              <a id="add" class="btn add-more button-yellow uppercase" type="button">+ Add another Field</a> <a class="delete btn button-white uppercase">- Remove Field</a>
                            </div> -->
                       
                      
                      <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                          <input type="submit" name="add"  class="btn btm-sm btn-success btn-sm" value="Add" /> 
                          
                          <a class="btn btn-danger btn-sm" type="edit" href="<?php echo base_url();?>admin/payment_modes">Back
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
     </script>
