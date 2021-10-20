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
          <li class="active">Special Attendance</li>
        </ul><!-- /.breadcrumb -->            
    </div>

<div class="page-content">
  <div class="page-header-1">
      <h1 class="col-lg-3 col-sm-4 col-md-5 col-xs-7 mbl-mgbtm-5 pdg-top-10">
        <i class="menu-icon blue fa fa-cart-arrow-down"></i>  
        Special Attendance 
      </h1>  
  </div><!-- /.page-header -->

  <div class="row" style="margin: 36px 0 0 0;">
    <div class="col-md-12">
 
      <!-- START DATATABLE EXPORT -->
      <div class="panel panel-default">
        
       <?php echo $message;?>
        <div class="panel-body">
          <div class="table-responsive" style="overflow-x: hidden;">
          <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px; z-index:99999999"><img src='<?=base_url();?>assets/img/demo_wait.gif' width="64" height="64" /></div>
            <input type="hidden" id="atpagination" value="">
            <input type="hidden" id="paginationlength" value="">
            <table id="users" class="table datatable table-striped">

            <!-------- Search Form ---------->
           <!--  <form id="fees_form" name="search_fees" method="post" class="pull-right"> -->
              <div class="col-md-3">
                  <select name="center_id" id="center_id" class="form-control input-sm custom-input" onclick="getevents(this.value)">
                      <option value="">Select Center</option>
                       <?php
                                if(!empty($centers))
                                {
                                  foreach($centers as $center)
                                  {
                                    ?>
                                    <option value="<?=$center['id'];?>"><?=$center['center'];?></option>
                                    <?php
                                  }
                                }
                                ?>
                  </select>                  
              </div>
              <div class="col-md-3">
                <select name="event_id" id="event_id" class="input-sm form-control custom-input">
                    <option value="">Select Event</option>
                    
                </select>
              </div>
              <div class="col-md-3" style="padding:0">
                  <input type="text" name="mobile_number" id="mobile_number" placeholder="Type keyword to search" class="input-sm form-control custom-input" style="margin-left:5px;">
              </div>
              
              
              
              <div class="col-md-2">
              <button type="button" id="search_user" class="btn btn-info margin_search" style="padding: 0px;" onclick="getStudentAttInfo()">Submit</button>
              <a class="btn btn-danger" style="display:none;" id="searchreset" href="<?php echo base_url('admin/specialattendance'); ?>"><li class="fa fa-minus icon-style"></li></a>
              </div>
            <!-- </form> --> 
            <!-------- /Search Form ---------->

            <div id="attendence_info" ></div>

           <!--  <section class="edu_admin_content" style="padding-bottom: 0px;">  
          <div class="sectionHolder edu_admin_right edu_dashboard_wrap">
            <div class="edu_dashboard_widgets">             
                <div class="row">
                  <div class="col-xl-12 col-lg-3 col-md-3 col-sm-12 col-12">
                    <a href="#">
                      <div class="edu_color_boxes box_left">
                        <div class="edu_dash_box_data">
                            <p><b>Batch Checking</b></p> 
                        </div>
                        <div class="edu_dash_box_icon" style="background-color: #f3f7f9;color: red;">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                        <div class="edu_dash_info">
                          <ul>
                            <li><p><b>Batch Name : </b><span><b>P4</b></span></p></li>
                          </ul>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-xl-12 col-lg-3 col-md-3 col-sm-12 col-12">
                    <a href="#">
                      <div class="edu_color_boxes box_center">
                        <div class="edu_dash_box_data">
                          <p><b>Batch Expire</b></p>
                        </div>
                        <div class="edu_dash_box_icon" style="background-color: #f3f7f9;color: red;">
                          <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                        <div class="edu_dash_info">
                          <ul>
                            <li><p><b>Batch Date : </b><span><b>26-03-2021</b></span></p></li>
                          </ul>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-xl-12 col-lg-3 col-md-3 col-sm-12 col-12">
                    <a href="#">
                      <div class="edu_color_boxes box_right">
                        <div class="edu_dash_box_data">
                            <p><b>Fee Check</b></p>
                        </div>
                        <div class="edu_dash_box_icon" style="background-color: #f3f7f9;color: green;">                             
                          <i class="fa fa-check" aria-hidden="true"></i>
                        </div>
                        <div class="edu_dash_info">
                          <ul>
                            <li><p><b>Due Fee  : </b><span><b>45000</b></span></p></li>
                            <li><p><b>Due Date  : </b><span><b>25-03-2021</b></span></p></li>
                          </ul>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-xl-12 col-lg-3 col-md-3 col-sm-12 col-12">
                    <a href="#">
                      <div class="edu_color_boxes box_right">
                        <div class="edu_dash_box_data">
                            <p><b>Today Attended</b></p>
                        </div>
                        <div class="edu_dash_box_icon" style="background-color: #f3f7f9;color: green;">                             
                          <i class="fa fa-check" aria-hidden="true"></i>
                        </div>
                        <div class="edu_dash_info">
                          <ul>
                            <li><p><b>Last Attended Date : </b><span><b>26-03-2021</b></span></p></li>
                            <li><p><b>Time: </b><span><b>12:13:17</b></span></p></li>
                          </ul>
                        </div>
                      </div>
                    </a>
                  </div>

                </div>                    
              </div>
                  </div>
            </section>
             
            <form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="#" enctype="multipart/form-data" novalidate="">
              <div class="row">
                <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">
                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                      <label class="input-text">Student Id<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                      <div class="form-group">
                        <input class="form-control" placeholder="" type="text" name="stock_name" value="" id="stock_name" onkeyup="" required="" data-parsley-id="1436"><ul class="parsley-errors-list" id="parsley-id-1436"></ul>
                      </div>
                    </div>
                  </div>

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                      <label class="input-text">Student Name<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <div class="form-group">
                        <input class="form-control" placeholder="" type="text" name="count" value="" id="count" onkeyup="" required="" data-parsley-id="5789"><ul class="parsley-errors-list" id="parsley-id-5789"></ul>
                      </div>
                    </div>
                  </div> 

                  <div class="row form-group frm-btm">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
                      <label class="input-text">Reason<span class="red bigger-120">*</span></label>
                    </div>
                    <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
                      <div class="form-group">
                        <textarea class="form-control" rows="5" id="comment"></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
                      <input type="submit" name="add" class="btn btm-sm btn-success btn-sm" value="Submit">
                    </div>                
                  </div> 
                </div>
              </div>
            </form>  -->


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
            "url": "<?php echo base_url('#'); ?>",
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
       /* "columns": [
            { "title": "S.No", "name":"sno", "orderable": false, "data":"sno", "width":"0%" },
            { "title": "State Name", "name":"state","orderable": false, "data":"state", "width":"0%" },
            { "title": "Organisation Name", "name":"organisation_name","orderable": false, "data":"organisation_name", "width":"0%" },
            { "title": "Center Name", "name":"center","orderable": false, "data":"center", "width":"0%" },
            { "title": "Created Date", "name":"created_on","orderable": false, "data":"created_on", "width":"0%" },
            //{ "title": "Modified Date", "name":"modified_on","orderable": false, "data":"modified_on", "width":"0%" },
            { "title": "Status", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_action"},
            {"title": "Actions", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_action"},
            
        ],*/
        "fnCreatedRow": function(nRow, aData, iDataIndex) 
        {           

          var image = '<img src="'+url+aData['image_path']+'" height="100" width="150">';
         // $(nRow).find('td:eq(2)').html(image);

          if(aData['status'] == 'Active')
          {
            var action = '<a title="Click to Inactive" href="'+url+'admin/centers/change_center_status/'+aData['id']+'/Inactive/" class="btn btn-success btn-condensed">Active</a>';
          }
          else
          {
            var action = '<a title="Click to Active" href="'+url+'admin/centers/change_center_status/'+aData['id']+'/Active/" class="btn btn-danger btn-condensed">Inactive</a>';
          }
          $(nRow).find('td:eq(5)').html(action);

       
          var action ='<a class="btn btn-warning btn-condensed" title="edit" href="'+url+'admin/centers/edit/'+aData['id']+'"><i class="fa fa-edit"></i></a>';
          $(nRow).find('td:eq(6)').html(action);



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

function getevents(center_id){

  var center_id=$("#center_id").val();
  

   $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/common/get_spl_attendence_centers',
      data: {center_id: center_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ 
        $("#event_id").html(data);
        $("#wait").css("display", "none");
      }
    });
}

function getStudentAttInfo(){
   var center_id=$("#center_id").val();
   var event_id=$("#event_id").val();
   var mobile_number=$("#mobile_number").val();
   //alert(center_id);

   $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/specialattendance/get_spl_attendence_info',
      data: {center_id: center_id, event_id:event_id,mobile_number:mobile_number},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ 
        $("#attendence_info").html(data);
        $("#wait").css("display", "none");
      }
    });

   
}

</script>


    