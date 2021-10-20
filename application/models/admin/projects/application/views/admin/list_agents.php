<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li class="active">Packages</li>
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
          <h2><span class="fa fa-edit"></span>Agents</h2>
        </div>
        <div class="col-md-6 col-xs-6">
          <h3 class="panel-title" style="float: right;"><a href="<?=base_url();?>admin/register/add_agents" class="btn btn-success">Add</a></h3>
        </div>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
          <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px; z-index:99999999"><img src='<?=base_url();?>assets/img/demo_wait.gif' width="64" height="64" /></div>
            <input type="hidden" id="atpagination" value="">
            <input type="hidden" id="paginationlength" value="">
            <table id="users" class="table datatable table-striped">

            <!-------- Search Form ---------->
            <form id="fees_form" name="search_fees" method="post" class="pull-right">
              <div class="col-md-3 col-md-offset-3" style="padding:0">
                  <input type="text" name="search_text_1" id="search_text_1" placeholder="Type keyword to search" class="input-sm form-control custom-input" style="margin-left:5px;">
              </div>

                <div class="col-md-2">
                  <select name="search_on_1" id="search_on_1" class="form-control input-sm custom-input">
                      <option value="1">Agent name</option>
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
              <button type="button" id="search_user" class="btn btn-info margin_search" style=""><i class="fa fa-search icon-style"></i></button>
              <a class="btn btn-danger" style="display:none;" id="searchreset" href="<?php echo base_url('admin/register/agents'); ?>"><li class="fa fa-minus icon-style"></li></a>
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
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/datatables/dataTables_custom.js" type="text/javascript"></script>
<!--Load JQuery-->
<!--<script src="<?php echo base_url();?>assets/datatables/jquery.dataTables.min.js"></script>-->
<!--<script src="<?php echo base_url();?>assets/datatables/dataTables.bootstrap.min.js"></script>-->
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
            // "bStateSave": true,
            "language": {
            "emptyTable": "No Records Found!",
        },
        dom: '<"html5buttons" B>lTgtp',
        buttons: [],
        "aLengthMenu": [10, 20, 50, 100],
        "destroy": true,
        "ajax": {
            "url": "<?php echo base_url('admin/register/all_agents'); ?>",
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
            
            { "title": "Agent Name", "name":"agent_name","orderable": false, "data":"agent_name", "width":"0%" },
            { "title": "Mobile", "name":"mobile","orderable": false, "data":"mobile", "width":"0%" },

            { "title": "Specialisation", "name":"specialisation","orderable": false, "data":"specialisation", "width":"0%" },

            { "title": "Coupon code", "name":"coupon_code","orderable": false, "data":"coupon_code", "width":"0%" },

            { "title": "Discount(%)", "name":"discount_percentage","orderable": false, "data":"discount_percentage", "width":"0%" },

            { "title": "Start date", "name":"start_date","orderable": false, "data":"start_date", "width":"0%" },

            { "title": "Expiry date", "name":"expiry_date","orderable": false, "data":"expiry_date", "width":"0%" },

            { "title": "View", "name":"id","orderable": false, "data":"id", "width":"0%" },

            { "title": "On/Off", "name":"id","orderable": false, "data":"id", "width":"0%" },

            { "title": "Actions", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_actionn"},

            //{ "title": "modified Date", "name":"modified_on","orderable": false, "data":"modified_on", "width":"0%" },         
        ],
        "fnCreatedRow": function(nRow, aData, iDataIndex) 
        {

        var view ='<a title="Click to View" href="'+url+'admin/register/view_agents/'+aData['id']+'" class="btn btn-success btn-condensed">View</a>';
        $(nRow).find('td:eq(8)').html(view);   

          var action ='<a class="btn btn-warning btn-condensed" title="edit" href="'+url+'admin/register/edit_agents/'+aData['id']+'"><i class="fa fa-edit"></i></a>';
          $(nRow).find('td:eq(10)').html(action);

          if(aData['status'] == "Active")
          {
            var status ='<a title="Click to Inactive" href="'+url+'admin/register/change_agent_status/'+aData['id']+'/Inactive" class="btn btn-success btn-condensed">ON</a>';
          }
          else
          {
            var status ='<a title="Click to Active" href="'+url+'admin/register/change_agent_status/'+aData['id']+'/Active" class="btn btn-danger btn-condensed">OFF</a>';
          }
          $(nRow).find('td:eq(9)').html(status);
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

