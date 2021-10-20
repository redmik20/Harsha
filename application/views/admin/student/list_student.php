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

              
              <li class="active">Students</li>
            </ul><!-- /.breadcrumb -->

            
          </div>

<div class="page-content">
  <div class="page-header-1">
              <h1 class="col-lg-12 col-sm-4 col-md-5 col-xs-7 mbl-mgbtm-5 pdg-top-10">
                <i class="menu-icon blue fa fa-cart-arrow-down"></i>  
                Students ---><b style="color:red"><?php echo $state['state'];?></b>(state) ---><b style="color:red"> <?php echo $organisation['organisation_name'];?> </b>(organasation) ---><b style="color:red"> <?php echo $center['center'];?> </b>(center)
              </h1>
              <?php if( in_array('a',$roleResponsible['students'])){?>
                <div class="pull-right ">       
                
                <a href="<?php echo base_url();?>admin/student/add" class="btn btn-success btn-sm" type="button"><i class="fa fa-plus fa-lg"></i> New Registration </a>                          
                <input type="hidden" name="hiv" id="hiv" value="0" />
               </div>
              <?php }?>
          
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
              <div class="col-md-3 col-md-offset-3" style="padding:0">
                  <input type="text" name="search_text_1" id="search_text_1" placeholder="Type keyword to search" class="input-sm form-control custom-input" style="margin-left:5px;">
              </div>
              <div class="col-md-2">
                  <select name="search_on_1" id="search_on_1" class="form-control input-sm custom-input">

                      <option value="1">Student Mobile</option>
                      <option value="2">Student Name</option>
                      <option value="3">Student ID</option>
                      <option value="4">Admission No</option>
                      <option value="5">Batch</option>
                      <option value="6">Course</option>

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
              <a class="btn btn-danger" style="display:none;" id="searchreset" href="<?php echo base_url('admin/student'); ?>"><li class="fa fa-minus icon-style"></li></a>
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
    var state_id= '<?php echo $state_id;?>';
    var org_id= '<?php echo $org_id;?>';
    var center_id= '<?php echo $center_id;?>';
  
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
        "aLengthMenu": [100,250,500],
        "destroy": true,
        "ajax": {
            "url": "<?php echo base_url('admin/student/all_students'); ?>",
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
            { "title": "Admission No", "name":"title","orderable": false, "data":"admission_no", "width":"0%" },
            { "title": "Student ID", "name":"title","orderable": false, "data":"student_dynamic_id", "width":"0%" },
            { "title": "Course Name", "name":"title","orderable": false, "data":"course_name", "width":"0%" },
            { "title": "Batch Name", "name":"title","orderable": false, "data":"batch_name", "width":"0%" },
            { "title": "Student Name", "name":"title","orderable": false, "data":"student_name", "width":"0%" },
            { "title": "Mobile", "name":"title","orderable": false, "data":"student_mobile", "width":"0%" },
            { "title": "Valid From", "name":"created_on","orderable": false, "data":"valid_from", "width":"0%" },
            { "title": "Valid To", "name":"created_on","orderable": false, "data":"valid_to", "width":"0%" },
            //{ "title": "Modified Date", "name":"modified_on","orderable": false, "data":"modified_on", "width":"0%" },
            { "title": "Receipt Details", "name":"title","orderable": false, "data":"id", "width":"0%" },

             <?php if( in_array('s',$roleResponsible['students'])){?>
            { "title": "Status", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_action"},
            <?php }?>

             <?php if( (in_array('e',$roleResponsible['students'])) || (in_array('d',$roleResponsible['students']))) {?>

            {"title": "Actions", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_action"},  
            <?php }?>    
              
            
        ],
        "fnCreatedRow": function(nRow, aData, iDataIndex) 
        {           

          var image = '<img src="'+url+aData['image_path']+'" height="100" width="150">';
         // $(nRow).find('td:eq(2)').html(image);

         var payments = '<a title="Click to Inactive" href="'+url+'admin/student/student_payments/'+aData['id']+'/all" class="btn btn-success btn-condensed">Receipt Details</a>';

         $(nRow).find('td:eq(9)').html(payments);

          if(aData['status'] == 'Active')
          {
            var action = '<a title="Click to Inactive" href="'+url+'admin/student/change_record_status/'+aData['id']+'/Inactive/" class="btn btn-success btn-condensed">Active</a>';
          }
          else
          {
            var action = '<a title="Click to Active" href="'+url+'admin/student/change_record_status/'+aData['id']+'/Active/" class="btn btn-danger btn-condensed">Inactive</a>';
          }

          <?php if( in_array('s',$roleResponsible['students'])){?>

          $(nRow).find('td:eq(10)').html(action);
          
          <?php }?>


           
       
          var action ='<a class="btn btn-warning btn-condensed" title="edit" href="'+url+'admin/student/edit/'+aData['id']+'"><i class="fa fa-edit"></i></a>';

          
             <?php if( (in_array('s',$roleResponsible['students'])) && (in_array('e',$roleResponsible['students'])) ){?>
        
          $(nRow).find('td:eq(11)').html(action);
        
        <?php }else if((!in_array('s',$roleResponsible['students'])) && (in_array('e',$roleResponsible['students'])) ){?>
           $(nRow).find('td:eq(10)').html(action);

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


    