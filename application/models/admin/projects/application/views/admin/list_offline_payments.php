<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li class="active">payments</li>
</ul>
<!-- END BREADCRUMB -->
<!-- END PAGE TITLE -->
<?php if($this->session->flashdata('success') != "") : ?>                
  <div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <?=$this->session->flashdata('success');?>
  </div>
<?php endif; ?>  
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

  <div class="row">
    <div class="col-md-12">

      <!-- START DATATABLE EXPORT -->
      <div class="panel panel-default">
        <div class="panel-heading">
        <div class="col-md-6 col-xs-6">
          <h2><span class="fa fa-list"></span>Offline Payments</h2>
        </div>
         <div class="col-md-6 col-xs-6">
          <h3 class="panel-title" style="float: right;"><a href="<?=base_url();?>admin/main/offline_paymemts_info" class="btn btn-success">Export Excel</a></h3>
        </div>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
          <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px; z-index:99999999"><img src='<?=base_url();?>assets/img/demo_wait.gif' width="64" height="64" /></div>
            <input type="hidden" id="atpagination" value="">
            <input type="hidden" id="paginationlength" value="">
            <table id="payments" class="table datatable table-striped">

            <!-------- Search Form ---------->
            <form id="fees_form" name="search_fees" method="post" class="pull-right">
              <div class="col-md-3 col-md-offset-3" style="padding:0">
                  <input type="text" name="search_text_1" id="search_text_1" placeholder="Type keyword to search" class="input-sm form-control custom-input" style="margin-left:5px;">
              </div>
              <div class="col-md-2" style="display:block;">
                  <select name="search_on_1" id="search_on_1" class="form-control input-sm custom-input">
                      
                      <option value="1">Mobile No</option>

                  </select>
                  <i class="fa fa-angle-down arrow-icon" id="arrow-icon"></i>
              </div>
              <div class="col-md-2">
                  <select name="search_at_1" id="search_at_1" class="input-sm form-control custom-input">
                      <option value="">Contains</option>
                      <option value="after">Starts with</option>
                      <option value="before">Ends with</option>
                  </select>
                  <i class="fa fa-angle-down arrow-icon" id="arrow-icon"></i>
              </div>

              <div class="col-md-2">
              <button type="button" id="search_payments" class="btn btn-info margin_search" style=""><i class="fa fa-search icon-style"></i></button>
              <a class="btn btn-danger" style="display:none;" id="searchreset" href="<?php echo base_url('admin/register/offline_payments'); ?>"><li class="fa fa-minus icon-style"></li></a>
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
<!-- END PAGE CONTENT WRAPPER -->
<script src="<?php echo base_url();?>assets/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/datatables/dataTables_custom.js" type="text/javascript"></script>
<!--Load JQuery-->
<script src="<?php echo base_url();?>assets/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/datatables/dataTables.bootstrap.min.js"></script>
<script>
    var dtabel;
    var search_text_1;
    var search_on_1;
    var search_at_1;
    var ispage;
    var url = '<?php echo base_url();?>';
    $(document).ready(function () {
        dtabel = $('#payments').DataTable({
            "processing": true,
            "serverSide": true,
            //"bStateSave": true,
            "language": {
            "emptyTable": "No Records Found!",
        },
        dom: '<"html5buttons" B>lTgtp',
        buttons: [],
        "aLengthMenu": [10, 20, 50, 100],
        "destroy": true,
        "ajax": {
            "url": "<?php echo base_url('admin/register/all_offline_payments'); ?>",
            "type":"POST",
            beforeSend: function() {
              $("#wait").css("display", "block");
            },
            "data":function (d){
                d.search_text_1 = search_text_1;
                d.search_on_1 = search_on_1;
                d.search_at_1 = search_at_1;
            },
            "dataSrc": function ( jsondata ) {
                $("#wait").css("display", "none");
                return jsondata['data'];
            }
        },
        "columns": [
            { "title": "S.No", "name":"sno", "orderable": false, "data":"sno", "width":"0%" },
            
            
            { "title": "User Name", "name":"user_name","orderable": false, "data":"user_name", "width":"0%" },
            { "title": "User Mobile", "name":"user_mobile","orderable": false, "data":"user_mobile", "width":"0%" },

            { "title": "Package", "name":"package_name","orderable": false, "data":"package_name", "width":"0%" },

            { "title": "Paid Amount", "name":"final_paid_amount","orderable": false, "data":"final_paid_amount", "width":"0%" },

            { "title": "Valid Months", "name":"valid_months","orderable": false, "data":"valid_months", "width":"0%" },


            { "title": "Coupon Applied", "name":"coupon_applied","orderable": false, "data":"coupon_applied", "width":"0%" },

            { "title": "Payment Status", "name":"payment_status","orderable": false, "data":"payment_status", "width":"0%" },

            { "title": "Payment From", "name":"payment_from","orderable": false, "data":"payment_from", "width":"0%" },
            
            { "title": "Created Date", "name":"created_on","orderable": false, "data":"created_on", "width":"0%" },

            { "title": "View", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_action"},

            
        ],
        "fnCreatedRow": function(nRow, aData, iDataIndex) 
        {

          var view ='<a href="'+url+'admin/register/view_payment_info/'+aData['id']+'" class="btn btn-success btn-condensed" title="view Info">view</a>';
          $(nRow).find('td:eq(10)').html(view);

          var receipt='<b style="color:black">'+aData['receipt_id']+'</b>';
         // $(nRow).find('td:eq(1)').html(receipt);

          var amt='<p style="color:green">'+aData['final_paid_amount']+'.00 /-</p>';
          $(nRow).find('td:eq(5)').html(amt);

          var valid_months='<p style="color:red">'+aData['valid_months']+' months.</p>';
          $(nRow).find('td:eq(6)').html(valid_months);
          
        },
        "fnDrawCallback": function( oSettings ) {            
            var info = this.fnPagingInfo().iPage;
            $("#atpagination").val(info+1);
            $("td:empty").html("&nbsp;");
        },
    });
    $("#search_payments").click(function(){
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
    var table = $('#payments').DataTable();
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

