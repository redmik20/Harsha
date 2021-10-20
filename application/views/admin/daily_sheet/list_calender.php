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
                <a href="<?php echo site_url();?>admin/dashboard">Home</a>
              </li>              
              <li class="active"> Daily Sheet</li>
            </ul><!-- /.breadcrumb -->            
          </div>

<div class="page-content">
  <div class="page-header-1">
              <h1 class="col-lg-3 col-sm-4 col-md-5 col-xs-7 mbl-mgbtm-5 pdg-top-10">
                <i class="menu-icon blue fa fa-cart-arrow-down"></i>  
                Daily Sheet
              </h1>
          <?php if($search_value == 'search'){ ?>
              <div class="pull-right ">  
              <a href="<?php echo base_url();?>admin/daily_sheet" class="btn btn-danger btn-sm" type="button"><i class="fa fa-arrow-left fa-lg"></i> Back </a> 
              </div>
            <?php }?>
              
            </div><!-- /.page-header -->
           

  <div class="row" >
    <div class="col-md-12">
 
      <!-- START DATATABLE EXPORT -->
      <div class="panel panel-default">
        
       <?php echo $message;?>
        <div class="panel-body">
          
          <div class="table-responsive">
          <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px; z-index:99999999"><img src='<?=base_url();?>assets/img/demo_wait.gif' width="64" height="64" /></div>
            <input type="hidden" id="atpagination" value="">
            <input type="hidden" id="paginationlength" value="">
            <table id="users" class="table datatable table-striped">
              <?php if($search_value == 'search'){ ?>
              <h1 class="col-lg-12 col-sm-4 col-md-5 col-xs-7 mbl-mgbtm-5 pdg-top-10">
                <i class="menu-icon blue fa fa-cart-arrow-down"></i>  
                Income/Expense Total  --->Selected Date : <b style="color:red"> <?php echo $search_date?></b>
              </h1>
            <?php }else{?>
            <!-------- Search Form ---------->
            <form id="" action="<?php echo base_url();?>admin/daily_sheet/employee_records" name="" method="post" class="pull-right">

              <div class="col-md-3">
                  
                 
              </div>
              <div class="col-md-1">
                  
                  <label>Select Date :</label>
              </div>
              
              <div class="col-md-4 ">
                                      
                <input type="text" class="form-control" name="date_from" value="" placeholder="Start-date(yyyy-mm-dd)" id="date_from">
                                       
            
              
            </div>
              
             
              <div class="col-md-4">
              <button type="submit" id="" class="btn btn-info margin_search" style="">Submit</button>
              <a class="btn btn-danger" style="display:none;" id="searchreset" href="<?php echo base_url('admin/schedule'); ?>"><li class="fa fa-minus icon-style"></li></a>
              </div>
            </form> 
          <?php }?>
            <!-------- /Search Form ---------->

            </table>                                            
          </div>
        </div>
      </div>
      <!-- END DATATABLE EXPORT -->      
    </div>
  </div>

   <section class="edu_admin_content">  
          <div class="sectionHolder edu_admin_right edu_dashboard_wrap">
            <div class="edu_dashboard_widgets">             
                <div class="row">
                  <div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
                    <a href="<?php echo base_url()?>admin/daily_sheet/daily_incomes_list/">
                      <div class="edu_color_boxes box_left">
                        <div class="edu_dash_box_data">
                            <p><b>Total Income</b></p>
                          <h3><b>
                                      <?php if($daily_approved_incomes['approved_income_total'] != ''){
                                  echo $income_total_amt=roundInt($daily_approved_incomes['approved_income_total']);
                                }else{
                                  echo $income_total_amt=0;
                                }
                              ?></b></h3>             
                        </div>
                        <div class="edu_dash_box_icon">
                        <i class="fa fa-money" aria-hidden="true"></i>
                        </div>
                        <div class="edu_dash_info">
                              <ul>
                                  <li><p><b>Total Income : </b><span><b>

                                    
                                      <?php if($daily_approved_incomes['approved_income_total'] != ''){
                                  echo roundInt($daily_approved_incomes['approved_income_total']);
                                }else{
                                  echo 0;
                                }
                              ?>
                                    </b></span></p></li>
                                  <!-- <li><p><b>Due Fees : </b> <span><b><?php echo $due_amount;?></b></span></p></li> -->
                              </ul>
                          </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
                    <a href="<?php echo base_url()?>admin/daily_sheet/daily_expense_list/<?php echo $this->uri->segment(4);?>">
                      <div class="edu_color_boxes box_center">
                        <div class="edu_dash_box_data">
                            <p><b>Total Expenses</b></p>
                          <h3><b><?php if($daily_approved_expenses['approved_expense_total'] != ''){
                                  echo $expense_total_amt=roundInt($daily_approved_expenses['approved_expense_total']);
                                }else{
                                  echo $expense_total_amt=0;
                                }
                              ?>
                                
                              </b></h3>
                        </div>
                        <div class="edu_dash_box_icon">
                          <i class="fa fa-money" aria-hidden="true"></i>
                        </div>
                        <div class="edu_dash_info">
                        <ul>
                            <li><p><b>Total Expenses : </b><span><b><?php echo roundInt($expense_total_amt);?></b></span></p></li>
                           <!--  <li><p><b>Due Fees : </b> <span><b><?php echo $due_amount;?></b></span></p></li> -->
                        </ul>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
                    <!-- <a href="<?php echo base_url()?>admin/paymentview/payment_mode_payments/<?php echo $state_id;?>/<?php echo $org_id;?>/<?php echo $center_id;?>"> -->
                        <div class="edu_color_boxes box_right">
                          <div class="edu_dash_box_data">
                              <p><b>Net Amount</b></p>
                            <h3><b><?php  $net_amt=$income_total_amt-$expense_total_amt;
                                    echo number_format($net_amt);;
                                  
                                  ?></b></h3>
                          </div>
                          <div class="edu_dash_box_icon">                             
                        <i class="fa fa-cc" aria-hidden="true"></i>
                          </div>
                          <div class="edu_dash_info">
                        <ul>
                            <li><p><b>Total Net : </b><span><b><?php echo number_format($net_amt);?></b></span></p></li>
                           <!--  <li><p><b>Due Fees : </b> <span><b><?php echo $due_amount;?></b></span></p></li> -->
                        </ul>
                        </div>
                        </div>
                    <!-- </a> -->
                  </div>
                </div>                    
              </div>
                  </div>
            </div>
          </section>
          
</div>   
</div>       
</div>  
    <!-- JavaScript to control the actions
         of the date picker -->
    <script type="text/javascript">
       
        $(document).ready(function(){
    $('#date_from,#date_to').datepicker({
        autoclose: true,
        todayHighlight: true,
        format:"yyyy-mm-dd",
        //setDate:"today"
    }).datepicker("setDate", new Date());
   
})
    </script>

  
