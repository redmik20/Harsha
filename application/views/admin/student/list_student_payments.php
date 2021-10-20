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

              
              <li class="active">Students Payments</li>
            </ul><!-- /.breadcrumb -->

            
          </div>

<div class="page-content">
  <div class="page-header-1">
              <h1 class="col-lg-3 col-sm-4 col-md-5 col-xs-7 mbl-mgbtm-5 pdg-top-10">
                <i class="menu-icon blue fa fa-cart-arrow-down"></i>  
                Students Payments
              </h1>
                <div class="pull-right ">    
                <?php if($param == 'my_admission'){?>   
                <a href="<?php echo base_url();?>admin/agent_dashboard/my_admissions" class="btn btn-danger btn-sm" type="button"><i class="fa fa-arrow-left fa-lg"></i> Back</a>
              <?php }else if($param == 'search_student'){?>
                <a href="<?php echo base_url();?>admin/payment_portal" class="btn btn-danger btn-sm" type="button"><i class="fa fa-arrow-left fa-lg"></i> Back</a>
                <?php } ?>

                <a href="<?php echo base_url();?>admin/student/add_payment_details/<?php echo $student_id?>" class="btn btn-success btn-sm" type="button"><i class="fa fa-plus fa-lg"></i> Add Payment</a>     

                <input type="hidden" name="hiv" id="hiv" value="0" />
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
              <div class="col-md-3 col-md-offset-3" style="padding:0">
                  <input type="text" name="search_text_1" id="search_text_1" placeholder="Type keyword to search" class="input-sm form-control custom-input" style="margin-left:5px;">
              </div>
              <div class="col-md-2">
                  <select name="search_on_1" id="search_on_1" class="form-control input-sm custom-input">

                      <option value="1">Reciept ID</option>
                    

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
    var student_id='<?php echo $student_id;?>';
  
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
            "url": "<?php echo base_url('admin/student/all_students_payments'); ?>",
            "type":"POST",
            beforeSend: function() {
              $("#wait").css("display", "block");
            },
            "data":function (d){
                d.search_text_1 = search_text_1;
                d.search_on_1 = search_on_1;
                d.search_at_1 = search_at_1;
                d.student_id=student_id;
            },
            "dataSrc": function ( jsondata ) {
                $("#wait").css("display", "none");
                return jsondata['data'];
            }
        },
        "columns": [
            { "title": "S.No", "name":"sno", "orderable": false, "data":"sno", "width":"0%" },
           
            { "title": "Student ID", "name":"title","orderable": false, "data":"student_dynamic_id", "width":"0%" },
            { "title": "Student Mobile", "name":"title","orderable": false, "data":"student_mobile", "width":"0%" },
            { "title": "Reciept ID", "name":"title","orderable": false, "data":"receipt_id", "width":"0%" },
            { "title": "Final Fees", "name":"title","orderable": false, "data":"total_fee", "width":"0%" },
            { "title": "Amount paid", "name":"title","orderable": false, "data":"amount_paid", "width":"0%" },
            { "title": "Amount paid Date", "name":"title","orderable": false, "data":"amount_paid_date", "width":"0%" },
            { "title": "Due Fees", "name":"created_on","orderable": false, "data":"due_amount", "width":"0%" },
            { "title": "Due date", "name":"created_on","orderable": false, "data":"due_date", "width":"0%" },
            { "title": "Final Setteled", "name":"created_on","orderable": false, "data":"final_settled", "width":"0%" },
            { "title": "Created On", "name":"title","orderable": false, "data":"created_on", "width":"0%" },
            { "title": "Reciept View", "name":"college_name","orderable": false, "data":"id", "width":"0%" },
            
            { "title": "Approval Status", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_action"},

            <?php if( !empty($roleResponsible['student_payments'])){
             if( in_array('e',$roleResponsible['student_payments'])){?>

            {"title": "Actions", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_action"},      
             <?php } }?> 

              
            
        ],
        "fnCreatedRow": function(nRow, aData, iDataIndex) 
        {           

          var image = '<img src="'+url+aData['image_path']+'" height="100" width="150">';

          //var mobile = '<b style="color:green">Mobile:</b><b>'+aData['student_mobile'] +'</b><br><b style="color:green"> Alt:</b><b>'+aData['student_alt_mobile'] +'</b>';

          ///$(nRow).find('td:eq(3)').html(state);

         // $(nRow).find('td:eq(2)').html(image);
        // if(aData['receipt_pdf_path'] != ''){
          var view = '<a target="_blank" title="Click to view" href="'+url+'admin/nonbhatia_payments/receipt_view/'+aData['id']+'" class="btn btn-primary btn-condensed">view</a>';

            //}else{
         // var view = '<b>No PDF</b>'; 
           // }
            $(nRow).find('td:eq(11)').html(view);

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


       
          $(nRow).find('td:eq(12)').html(action);
      
           <?php if( !empty($roleResponsible['student_payments'])){
             if( in_array('e',$roleResponsible['student_payments'])){?>
          var action ='<a class="btn btn-warning btn-condensed" title="edit" href="'+url+'admin/student/edit_payment_details/'+aData['id']+'"><i class="fa fa-edit"></i></a>';
          $(nRow).find('td:eq(13)').html(action);
            <?php } }?> 



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


    