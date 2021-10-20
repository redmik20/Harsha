<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li class="active">Push Notifications</li>
</ul>
<!-- END BREADCRUMB -->
<!-- END PAGE TITLE -->
<?php if($this->session->flashdata('success') != "") : ?>                
  <div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <?=$this->session->flashdata('success');?>
  </div>
<?php endif; ?> 
<?php if($this->session->flashdata('failed') != "") : ?>                
  <div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <?=$this->session->flashdata('failed');?>
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
          <h2><span class="fa fa-arrow-circle-o-left"></span> Push Notifications</h2>
        </div>
        <!-- <div class="col-md-6 col-xs-6">
          <h3 class="panel-title" style="float: right;"><a href="<?=base_url();?>admin/register/PushNotificationsView" class="btn btn-success">Send Push Notifications</a></h3>
        </div> -->
        </div>
        <div class="panel-body">
        <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/send_push_notification', $attributes); 
      ?>
        <div class="panel panel-default">
                 
          <div class="panel-body"> 

               <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Send to</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="student_id" id="teacher_id" required="">
                  <option value="">Select student</option>
                  <?php
                  if(!empty($students))
                  {
                    foreach($students as $student)
                    {
                      ?>
                       <option value="<?=$student->id;?>" ><?=$student->name;?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>          
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label">
                title</label>
                <div class="col-md-6 col-xs-12">
                   <input style="margin-left: auto;width: 100%;" type="text" class="form-control" name="title" id="title" required=""/>
                </div>
              </div>
              <div class="form-group">
                <label for="title" class="col-md-3 col-xs-12 control-label">Message</label>
                <div class="col-md-6 col-xs-12">
                  <div class="">
                    <textarea class="form-control" name="message" id="message" required=""></textarea>
                  </div>               
                </div>
              </div>
          </div>

          <div class="panel-footer">
            <!-- <button class="btn btn-default">Clear Form</button> -->
            <!-- <button class="add_field_button btn btn-primary">Add More Stops</button> -->
            <button type="submit" class="btn btn-primary pull-right">Submit</button>
          </div>
        </div>
      </form>
          <div class="table-responsive">
          <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px; z-index:99999999"><img src='<?=base_url();?>assets/img/demo_wait.gif' width="64" height="64" /></div>
            <input type="hidden" id="atpagination" value="">
            <input type="hidden" id="paginationlength" value="">
            <table id="users" class="table datatable table-striped">

            <!-------- Search Form ---------->
            <!-- <form id="fees_form" name="search_fees" method="post" class="pull-right">
              <div class="col-md-3 col-md-offset-3" style="padding:0">
                  <input type="text" name="search_text_1" id="search_text_1" placeholder="Type keyword to search" class="input-sm form-control custom-input" style="margin-left:5px;">
              </div>
              <div class="col-md-2">
                  <select name="search_on_1" id="search_on_1" class="form-control input-sm custom-input">
                      <option value="1">Name</option>
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
              <a class="btn btn-danger" style="display:none;" id="searchreset" href="<?php echo base_url('admin/register/users'); ?>"><li class="fa fa-minus icon-style"></li></a>
              </div>
            </form> -->
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
            "url": "<?php echo base_url('admin/register/all_push_notifications'); ?>",
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
            //{ "title": "Action", "name":"Status", "orderable": false, "deafultContent":"", "data": "Status", "width":"0%"},
            { "title": "title", "name":"title","orderable": false, "data":"title", "width":"0%" },
            //{ "title": "Phone", "name":"Phone","orderable": false, "data":"Phone", "width":"0%" },
            { "title": "student", "name":"studentname","orderable": false, "data":"studentname", "width":"0%" },
            { "title": "User name", "name":"username","orderable": false, "data":"username", "width":"0%" },
            { "title": "Message", "name":"message","orderable": false, "data":"message", "width":"0%" },
            { "title": "Created Date", "name":"created_on","orderable": false, "data":"created_on", "width":"0%" },
            //{ "title": "Modified Date", "name":"ModifiedOn","orderable": false, "data":"ModifiedOn", "width":"0%" },           
        ],
        "fnCreatedRow": function( nRow, aData, iDataIndex) 
        {
          // var Image = aData['Image'];
          // var imgTag = '<img src="' +url+ Image + '"style="height:50px;width:50px;"/>';          
          // $(nRow).find('td:eq(5)').html(imgTag);
          // if(aData['Status'] == "ACTIVE")
          // {
          //   var Status ='<a href="'+url+'admin/register/Userstatus/INACTIVE/'+aData['UserID']+'" class="btn btn-default">Active</button>';
          // }
          // else
          // {
          //   var Status ='<a href="'+url+'admin/register/Userstatus/ACTIVE/'+aData['UserID']+'" class="btn btn-default">In Active</button>';
          // }
          // $(nRow).find('td:eq(1)').html(Status);

         //   var Restaurant ='<a href="'+url+'admin/register/RestaurantsList/'+aData['UserID']+'" class="btn btn-default">View</button>';
         // $(nRow).find('td:eq(2)').html(Restaurant);
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
