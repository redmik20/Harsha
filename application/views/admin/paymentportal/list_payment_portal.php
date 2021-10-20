<!-- START BREADCRUMB -->

<!-- END BREADCRUMB -->
<!-- END PAGE TITLE -->
<!-- PAGE CONTENT WRAPPER -->
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
          <li class="active">Payment Portal</li>
        </ul><!-- /.breadcrumb -->            
    </div>

<div class="page-content">
  <div class="page-header-1">
      <h1 class="col-lg-3 col-sm-4 col-md-5 col-xs-7 mbl-mgbtm-5 pdg-top-10">
        <i class="menu-icon blue fa fa-cart-arrow-down"></i>  
       Payment Portal
      </h1>
        <!-- <div class="pull-right "> 
          <a href="<?php echo base_url();?>admin/payment_portal/add" class="btn btn-success btn-sm" type="button"><i class="fa fa-plus fa-lg"></i> Non Bhatia Payments</a>                          
          <input type="hidden" name="hiv" id="hiv" value="0"/>
       </div> -->  
  </div><!-- /.page-header -->

  <div class="row" style="margin: 300px 0px 0px 0px;">
    <div class="col-md-12 col-xs-12">
 
      <!-- START DATATABLE EXPORT -->
      <div class="panel panel-default">
       <?php echo $message;?>
        <div class="panel-body">
          <div class="table-responsive">
          <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px; z-index:99999999"><img src='<?=base_url();?>assets/img/demo_wait.gif' width="64" height="64" /></div>
            <input type="hidden" id="atpagination" value="">
            <input type="hidden" id="paginationlength" value="">
            <table id="users" class="table datatable table-striped">

            <!-------- Search Form ---------->
            <form id="" action="<?php echo base_url();?>admin/payment_portal/student_payment_view" name="" method="post" class="pull-right">
              <div class="col-md-3 col-md-offset-3">
                  <input type="text" name="mobile_number" id="mobile_number" placeholder="Type keyword to search" class="input-sm form-control custom-input" style="margin-left: 0px;">
              </div>
              <div class="col-md-2">
                  <select name="search_on_1" id="search_on_1" class="form-control input-sm custom-input">                      
                      <option value="1">Mobile Number</option>
                      <option value="2">Student Name</option>
                      <option value="3">Student Id</option>
                  </select>                  
              </div>
              <div class="col-md-2">
                  <select name="search_at_1" id="search_at_1" class="input-sm form-control custom-input">
                      <option value="">Contains</option>
                      <option value="after">Starts with</option>
                      <option value="before">Ends with</option>
                  </select>
              </div>
              <div class="col-md-2">
              <input type="submit" id="search_user" class="btn btn-info margin_search">
              <a class="btn btn-danger" style="display:none;" id="searchreset" href="<?php echo base_url('admin/payment_portal'); ?>"><li class="fa fa-minus icon-style"></li></a>
              </div>
            </form> 
            <!-------- /Search Form ---------->
            </table>                                            
          </div>
        </div>
      </div>
      <!-- END DATATABLE EXPORT -->      
    </div>
  </div>
</div>   
</div>       
</div>      
<!-- END PAGE CONTENT WRAPPER -->
<!-- <script src="<?php echo base_url();?>assets/admin/js/jquery-3.0.0.min.js"></script> -->




    