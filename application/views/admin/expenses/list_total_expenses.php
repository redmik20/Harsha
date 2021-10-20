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
          <li class="active">List Expenses</li>
        </ul><!-- /.breadcrumb -->            
    </div>

<div class="page-content">
  <div class="page-header-1">
      <h1 class="col-lg-3 col-sm-4 col-md-5 col-xs-7 mbl-mgbtm-5 pdg-top-10">
        <i class="menu-icon blue fa fa-cart-arrow-down"></i>  
       Expenses
      </h1>
      <div class="pull-right "> 
        
      <a href="<?php echo base_url();?>admin/dashboard" class="btn btn-danger btn-sm" type="button"><i class="fa fa-arrow-left fa-lg"></i> Back</a> 

      <?php if( in_array('a',$roleResponsible['expenses'])){?>

        <a href="<?php echo base_url();?>admin/expenses/bulk_upload_expenses" class="btn btn-success btn-sm" type="button"><i class="menu-icon fa fa-upload"></i>Bulk Upload</a>
        
          <a href="<?php echo base_url();?>admin/expenses/add/add_expense" class="btn btn-success btn-sm" type="button"><i class="fa fa-plus fa-lg"></i> Add Expenses</a> 
                                  
          <input type="hidden" name="hiv" id="hiv" value="0"/>
     
       <?php }?>

         </div>  
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
              <div class="col-md-3 col-md-offset-3" >
                  <input type="text" name="search_text_1" id="search_text_1" placeholder="Type keyword to search" class="input-sm form-control custom-input" style="margin-left:0px;">
              </div>
              <div class="col-md-2">
                  <select name="search_on_1" id="search_on_1" class="form-control input-sm custom-input">                      
                      <option value="1">State</option>
                      <option value="2">Organisation</option>
                      <option value="3">Center</option>
                      <option value="4">Category</option>

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
              <a class="btn btn-danger" href="<?php echo base_url('admin/agent_dashboard'); ?>">Back</a>
              <a class="btn btn-danger" style="display:none;" id="searchreset" href="<?php echo base_url('admin/expenses'); ?>"><li class="fa fa-minus icon-style"></li></a>
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
    var state_id= '';
    var org_id= '';
    var center_id= '';
  
  
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
            "url": "<?php echo base_url('admin/expenses/all_records'); ?>",
            "type":"POST",
            beforeSend: function() {
              $("#wait").css("display", "block");
            },
            "data":function (d){
                d.search_text_1 = search_text_1;
                d.search_on_1 = search_on_1;
                d.search_at_1 = search_at_1;
                d.state_id=state_id;
                d.org_id=org_id;
                d.center_id=center_id;
            },
            "dataSrc": function ( jsondata ) {
                $("#wait").css("display", "none");
                return jsondata['data'];
            }
        },
        "columns": [
            { "title": "S.No", "name":"sno", "orderable": false, "data":"sno", "width":"0%" },
            { "title": "State", "name":"state","orderable": false, "data":"state", "width":"0%" },
            { "title": "Organisation", "name":"organisation_name","orderable": false, "data":"organisation_name", "width":"0%" },
            { "title": "Center", "name":"center","orderable": false, "data":"center", "width":"0%" },

            { "title": "Category name", "name":"category_name","orderable": false, "data":"category_name", "width":"0%" },

            { "title": "Entered Date", "name":"date","orderable": false, "data":"amount_paid_date", "width":"0%" },

            { "title": "Payment Mode", "name":"payment_mode","orderable": false, "data":"payment_mode", "width":"0%" },

            { "title": "Transaction ID", "name":"transcation_id","orderable": false, "data":"transcation_id", "width":"0%" },

            { "title": "Amount", "name":"amount","orderable": false, "data":"amount", "width":"0%" },

            { "title": "View Attachment", "name":"id","orderable": false, "data":"id", "width":"0%" },

          
            
            { "title": "Approval Status", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_action"},
         

          

          <?php if( (in_array('e',$roleResponsible['expenses'])) || (in_array('d',$roleResponsible['expenses']))) {?>

            {"title": "Actions", "name":"action", "orderable": false, "deafultContent":"", "data": "approval_status", "width":"0%", "class":"td_action"},
          <?php }?>
        ],

        "fnCreatedRow": function(nRow, aData, iDataIndex) 
        {           

          var image = '<img src="'+url+aData['image_path']+'" height="100" width="150">';

          var view_attch ='<a target="_blank" class="btn btn-primary btn-condensed" title="view" href="'+aData['attachment']+'">View</a>';

          $(nRow).find('td:eq(9)').html(view_attch);
         // $(nRow).find('td:eq(2)').html(image);

          if(aData['approval_status'] == 'Approved')
          {
            var action = '<b style="color:green">Approved</b>';
          }
          else if(aData['approval_status'] == 'Pending')
          {
            var action = '<b style="color:red">Pending</b>';
          }else
          {
            var action = '<b style="color:red">Rejected</b>';
          }


        
          $(nRow).find('td:eq(10)').html(action);
        


 



      <?php if( (in_array('s',$roleResponsible['expenses'])) && (in_array('e',$roleResponsible['expenses'])) ){?>
       

          if(aData['approval_status'] != 'Approved'){
          var action ='<a class="btn btn-warning btn-condensed" title="edit" href="'+url+'admin/expenses/edit/'+aData['id']+'">Edit</a>';

          $(nRow).find('td:eq(11)').html(action);
            }

       <?php }else if((!in_array('s',$roleResponsible['expenses'])) && (in_array('e',$roleResponsible['expenses'])) ){?>
           if(aData['approval_status'] != 'Approved'){
          var action ='<a class="btn btn-warning btn-condensed" title="edit" href="'+url+'admin/expenses/edit/'+aData['id']+'">Edit</a>';

          $(nRow).find('td:eq(11)').html(action);
            }


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


    