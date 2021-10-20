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
          <li class="active">Transfer Funds List</li>
        </ul><!-- /.breadcrumb -->            
    </div>

<div class="page-content">
  <div class="page-header-1">
      <h1 class="col-lg-3 col-sm-4 col-md-5 col-xs-7 mbl-mgbtm-5 pdg-top-10">
        <i class="menu-icon blue fa fa-cart-arrow-down"></i>  
        Transfer Funds List
      </h1>
    <div class="pull-right "> 
         <!--  <a href="<?php echo base_url();?>admin/nonbhatia_payments/bulk_upload_incomes" class="btn btn-success btn-sm" type="button"><i class="menu-icon fa fa-upload"></i>Bulk Upload</a>-->
      
        
          <a href="<?php echo base_url('admin/transfer_funds');?>" class="btn btn-success btn-sm" type="button"><i class="fa fa-plus fa-lg"></i> Transfer Funds</a>                          
          <input type="hidden" name="hiv" id="hiv" value="0"/>
      
   
        </div> 
  </div><!-- /.page-header -->

  <div class="row" style="margin: 36px 0 0 0;">
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

            <!-------- Search Form ---------->
            <form id="fees_form" name="search_fees" method="post" class="pull-right">
              <div class="col-md-3 col-md-offset-3">
                  <input type="text" name="search_text_1" id="search_text_1" placeholder="Type keyword to search" class="input-sm form-control custom-input" style="margin-left: 0px;">
              </div>
              <div class="col-md-2">
                  <select name="search_on_1" id="search_on_1" class="form-control input-sm custom-input">
                      <option value="1">Mobile Number</option>
                      <option value="2">Transaction Id</option>
                      <!-- <option value="3">State</option>
                      <option value="4">Organisation name</option>
                      <option value="5">Center</option> -->
        

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
              <button type="button" id="search_user" class="btn btn-info margin_search" style=""><i class="fa fa-search icon-style"></i></button>
              <a class="btn btn-danger" style="display:none;" id="searchreset" href="<?php echo base_url('admin/transfer_funds/transfer_funds_list'); ?>"><li class="fa fa-minus icon-style"></li></a>
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

<script>
    var dtabel;
    var search_text_1;
    var search_on_1;
    var search_at_1;
    var ispage;
    var url = '<?php echo base_url();?>';
  
    $(document).ready(function () {
        dtabel = $('#users').DataTable({
            "processing": true,
            "serverSide": true,
            "bStateSave": true,
            "language": {
            "emptyTable": "No Records Found!",
        },
        dom: '<"html5buttons" B>lTgtp',
        buttons: [],
        "aLengthMenu": [10, 20, 50, 100],
        "destroy": true,
        "ajax": {
            "url": "<?php echo base_url('admin/transfer_funds/all_records'); ?>",
            "type":"POST",
            beforeSend: function() {
              $("#wait").css("display", "block");
            },
            "data":function (d){
                d.search_text_1 = search_text_1;
                d.search_on_1 = search_on_1;
                d.search_at_1 = search_at_1;
                //d.language_id=language_id;
            },
            "dataSrc": function ( jsondata ) {
                $("#wait").css("display", "none");
                return jsondata['data'];
            }
        },
        "columns": [
            { "title": "S.No", "name":"sno", "orderable": false, "data":"sno", "width":"0%" },
            //{ "title": "State", "name":"state","orderable": false, "data":"state", "width":"0%" },
            //{ "title": "Organisation", "name":"organisation_name","orderable": false, "data":"organisation_name", "width":"0%" },
            //{ "title": "Center", "center":"receipt_id","orderable": false, "data":"center", "width":"0%" },
           // { "title": "Student Id", "center":"receipt_id","orderable": false, "data":"student_dy_id", "width":"0%" },
           // { "title": "Recepit Id", "name":"receipt_id","orderable": false, "data":"receipt_id", "width":"0%" },
            //{ "title": "Name/Payment Mode", "name":"state","orderable": false, "data":"student_name", "width":"0%" },
           

            { "title": "Trasaction Id", "name":"college_name","orderable": false, "data":"transaction_id", "width":"0%" },
            { "title": "From Payment Mode", "name":"college_name","orderable": false, "data":"from_payment_mode", "width":"0%" },
            { "title": "To Payment Mode", "name":"college_name","orderable": false, "data":"to_payment_mode", "width":"0%" },
            { "title": "From Attach mobile", "name":"transfer_type","orderable": false, "data":"from_attachment_mobile", "width":"0%" },
            { "title": "To Attach mobile", "name":"transfer_type","orderable": false, "data":"to_attachment_mobile", "width":"0%" },
            { "title": "Amount", "name":"amount_paid_date","orderable": false, "data":"transfer_amount", "width":"0%" },

            { "title": "Entered Date", "name":"amount_paid_date","orderable": false, "data":"transfer_date", "width":"0%" },
            //{ "title": "Status", "name":"approval_status","orderable": false, "data":"approval_status", "width":"0%" },
           // { "title": "Pdf path", "name":"college_name","orderable": false, "data":"payment_mode", "width":"0%" },
          //  { "title": "Print", "name":"id","orderable": false, "data":"id", "width":"0%" },
            
           <?php /* 
           if(!empty($roleResponsible['my_collection'])){
            if( (in_array('e',$roleResponsible['my_collection']))) {?>

            {"title": "Actions", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_action"},
          <?php } }*/ ?>
          
            
        ],
        "fnCreatedRow": function(nRow, aData, iDataIndex) 
        {           

          /*if(aData['transfer_type'] == 'From'){
          var type = '<b style="color:green">'+aData['transfer_type'] +'</b>';
          }else{
          var type = '<b style="color:red">'+aData['transfer_type'] +'</b>';
          }*/
          //$(nRow).find('td:eq(5)').html(type);

          if(aData['receipt_pdf_path'] != ''){
          var view = '<a target="_blank" title="Click to Active" href="'+url+aData['receipt_pdf_path']+'" class="btn btn-primary btn-condensed">view</a>';

            }else{
          var view = '<b>No PDF</b>'; 
            }
            //$(nRow).find('td:eq(9)').html(view);

            var print = '<a target="_blank" title="Click to Active" href="'+url+'admin/nonbhatia_payments/print/'+aData['id']+'" class="btn btn-primary btn-condensed">Print</a>';
            //$(nRow).find('td:eq(10)').html(print);


          if(aData['status'] == 'Active')
          {
            var action = '<a title="Click to Inactive" href="'+url+'admin/colleges/change_college_status/'+aData['id']+'/Inactive/" class="btn btn-success btn-condensed">Active</a>';
          }
          else
          {
            var action = '<a title="Click to Active" href="'+url+'admin/colleges/change_college_status/'+aData['id']+'/Active/" class="btn btn-danger btn-condensed">Inactive</a>';
          }
        //  $(nRow).find('td:eq(4)').html(action);

      
        if(aData['approval_status'] != 'Approved'){

          var action ='<a class="btn btn-warning btn-condensed" title="edit" href="'+url+'admin/nonbhatia_payments/edit/'+aData['id']+'"><i class="fa fa-edit"></i></a>';
          $(nRow).find('td:eq(8)').html(action);
          }else{
          var action ='<b><p style="color:green"> Approved </p></b>';
          $(nRow).find('td:eq(8)').html(action);
          }
          
      



        },
        "fnDrawCallback": function( oSettings ) {            
            var info = this.fnPagingInfo().iPage;
            $("#atpagination").val(info+1);
            $("td:empty").html("&nbsp;");
        },
    });
    $("#search_user").click(function(){
        if($("#search_text_1").val()!=""){
            $("#search_text_1").css('background', '#ffffff');
            setallvalues();
            dtabel.draw();
        }else{
         $("#search_text_1").css('background', '#ffb3b3');
         $("#search_text_1").focus();
                     return false;
        }
    });
});

function setallvalues(){
    search_text_1 = $("#search_text_1").val();
    search_on_1 = $("#search_on_1").val();
    search_at_1 = $("#search_at_1").val();
    var table = $('#users').DataTable();
    var info = table.page.info();
    $("#atpagination").val((info.page+1));
    if(search_text_1!=""){
        $("#searchreset").show();            
    }
    searchAstr = '';
}

function getpagenumber()
{
    return $("#atpagination").val() / $("#paginationlength").val();
} 

    

</script>


    