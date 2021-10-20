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
          <li class="active">List of Income Payments</li>
        </ul><!-- /.breadcrumb -->            
    </div>

<div class="page-content">
  <div class="page-header-1">
      <h1 class="col-lg-3 col-sm-4 col-md-5 col-xs-7 mbl-mgbtm-5 pdg-top-10">
        <i class="menu-icon blue fa fa-cart-arrow-down"></i>  
       List of Income Payments
      </h1>
       
  </div><!-- /.page-header -->

  <div class="row" style="margin: 0px 0px 0px 0px;">
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
                      <option value="1">Student Name</option>
                      <option value="2">Student Mobile</option>
                      <option value="3">Transaction Id / UTR Id</option>
                      <option value="4">State</option>
                      <option value="5">Organisation name</option>
                      <option value="6">Center</option>
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
              <a class="btn btn-danger" style="display:none;" id="searchreset" href="<?php echo base_url('admin/payment_approvals'); ?>"><li class="fa fa-minus icon-style"></li></a>
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
    var type = '<?php echo $type;?>';
  
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
        "aLengthMenu": [100, 250, 500],
        "destroy": true,
        "ajax": {
            "url": "<?php echo base_url('admin/payment_approvals/all_records'); ?>",
            "type":"POST",
            beforeSend: function() {
              $("#wait").css("display", "block");
            },
            "data":function (d){
                d.search_text_1 = search_text_1;
                d.search_on_1 = search_on_1;
                d.search_at_1 = search_at_1;
                d.type=type;
            },
            "dataSrc": function ( jsondata ) {
                $("#wait").css("display", "none");
                return jsondata['data'];
            }
        },
        "columns": [
            { "title": "S.No", "name":"sno", "orderable": false, "data":"sno", "width":"0%" },
            
             { "title": "State&ORG&Center", "name":"state","orderable": false, "data":"state", "width":"0%" },
            //{ "title": "Organisation", "name":"organisation_name","orderable": false, "data":"organisation_name", "width":"0%" },
           // { "title": "Center", "center":"receipt_id","orderable": false, "data":"center", "width":"0%" },

            { "title": "Student Id&Name(Mobile)", "name":"student_name","orderable": false, "data":"student_name", "width":"0%" },

            //{ "title": "Mobile", "name":"mobile_number","orderable": false, "data":"mobile_number", "width":"0%" },

            { "title": "Receipt Id", "name":"receipt_id","orderable": false, "data":"receipt_id", "width":"0%" },

            { "title": "Amount", "name":"amount","orderable": false, "data":"amount_paid", "width":"0%" },

            { "title": "Payment Mode", "name":"payment_mode","orderable": false, "data":"payment_mode", "width":"0%" },

            { "title": "Transaction Id / UTR Id", "name":"transaction_id","orderable": false, "data":"transaction_id", "width":"0%" },

            { "title": "Entered By(Date)", "name":"date","orderable": false, "data":"amount_paid_date", "width":"0%" },

           

            

          
            
            { "title": "Approval Status", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_action"},
          
<?php if( in_array('s',$roleResponsible['payment_approvals'])){?>
          { "title": "Change Status", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_action"},
<?php }?>

<?php if( in_array('d',$roleResponsible['payment_approvals'])){?>
          { "title": "Delete", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_action"},
<?php }?>
         
        ],

        "fnCreatedRow": function(nRow, aData, iDataIndex) 
        {           
          if(aData['type'] == 'bhatia')
          {
           var type1 = '<b><p style="color:green"> Registered</p</b>';
         }else{
           var type1 = '<b><p style="color:red">Un Registered</p</b>';
         }
          // $(nRow).find('td:eq(1)').html(type) (<b style="color:green">'+aData['mobile_number'] +'</b>);

          var state = '<b style="color:green">State:</b><b>'+aData['state'] +'</b><br><b style="color:green"> ORG:</b><b>'+aData['organisation_name'] +'</b><br><b style="color:green"> Center:</b><b>'+aData['center'] +'</b>';

          $(nRow).find('td:eq(1)').html(state);

          var name = '<b style="color:red">ID:'+aData['student_dy_id'] +'</b><br><b style="color:green">Name:'+aData['student_name'] +'</b><br><b style="color:green">Mobile:'+aData['mobile_number'] +'</b>';

          $(nRow).find('td:eq(2)').html(name);

          var entered_by = '<b style="color:red">EnteredBy:'+aData['created_by'] +'</b><br><b style="color:blue">Emp Name:'+aData['user_name'] +'</b><br><b style="color:green">Date:'+aData['amount_paid_date'] +'</b>';

          $(nRow).find('td:eq(7)').html(entered_by);

          if(aData['approval_status'] == 'Approved')
          {
            var action = '<b style="color:green">Approved</b>';
          }
          else if(aData['approval_status'] == 'Pending')
          {
            var action = '<b style="color:orange">Pending</b>';
          }else
          {
            var action = '<b style="color:red">Rejected</b>';
          }


       
          $(nRow).find('td:eq(8)').html(action);
      
  if(aData['approval_status'] != 'Approved'){
           
        var change_status ='<a class="btn btn-success btn-condensed" title="approve" href="'+url+'admin/payment_approvals/change_status/'+aData['id']+'/Approved/'+type+'">Approve</a><br>';
        }
if(aData['approval_status'] != 'Rejected'){
       var change_status ='<a class="btn btn-danger btn-condensed" title="reject" href="'+url+'admin/payment_approvals/change_status/'+aData['id']+'/Rejected/'+type+'">Reject</a>';
     }

     if(aData['approval_status'] == 'Pending'){
var change_status ='<a class="btn btn-success btn-condensed" title="approve" href="'+url+'admin/payment_approvals/change_status/'+aData['id']+'/Approved/'+type+'">Approve</a><br><a class="btn btn-danger btn-condensed" title="reject" href="'+url+'admin/payment_approvals/change_status/'+aData['id']+'/Rejected/'+type+'">Reject</a>';
         
        }

        <?php if( in_array('s',$roleResponsible['payment_approvals'])){?>
            $(nRow).find('td:eq(9)').html(change_status);
       <?php }?>

       <?php if( in_array('d',$roleResponsible['payment_approvals'])){?>
        var delete_s ='<a onclick="return confirm('+"'Are you sure want to delete?'"+');" class="btn btn-danger btn-condensed" title="delete" href="'+url+'admin/payment_approvals/delete_payment/'+aData['id']+'"><i class="fa fa-trash"></i></a>';
            $(nRow).find('td:eq(10)').html(delete_s);
       <?php }?>


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


    