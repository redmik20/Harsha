<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li class="active">Search Quiz questions</li>
</ul>
<!-- END BREADCRUMB -->
<!-- END PAGE TITLE -->
<?php if($this->session->flashdata('success') != "") : ?>                
  <div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <?=$this->session->flashdata('success');?>
  </div>
<?php endif; ?> 

<?php 
//echo '<pre>';print_r($post);exit;
if ((array_key_exists("exam_id",$post)) && ($post['exam_id'] !='')){
  $exam_id=$post['exam_id'];
  $exam=$this->db->query("select name from exams where id='".$exam_id."' ")->row_array();
  $exam_name=$exam['name'];

}else{
   $exam_id ='';
   $exam_name='';
}

if((array_key_exists("subject_id",$post)) && ($post['subject_id'] !='')){
  $subject_id=$post['subject_id'];
//  echo '<pre>';print_r($post);exit;
  $subject=$this->db->query("select subject_name from subjects where id='".$subject_id."' ")->row_array();
  $subject_name=$subject['subject_name'];
}else{
  $subject_id='';
  $subject_name='';
}

if((array_key_exists("chapter_id",$post)) && ($post['chapter_id'] !='')){
  $chapter_id=$post['chapter_id'];
  $topic=$this->db->query("select topic_name from quiz_topics where id='".$chapter_id."' ")->row_array();
  $topic_name=$topic['topic_name'];
}else{
  $chapter_id='';
  $topic_name='';
}

if((array_key_exists("topic_id",$post)) && ($post['topic_id'] !='')){
  $topic_id=$post['topic_id'];
  $qbank_topic=$this->db->query("select name from quiz_qbanktopics where id='".$topic_id."' ")->row_array();
  $qbank_topic=$qbank_topic['name'];
}else{
  $topic_id='';
  $qbank_topic='';
}



?> 
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

  <div class="row">
    <div class="col-md-12">

      <!-- START DATATABLE EXPORT -->
      <div class="panel panel-default">
        <div class="panel-heading">
        <div class="col-md-6 col-xs-6">
          <h2><span class="fa fa-list"></span>Search Qbank Questions</h2>
        </div>
        <div class="col-md-6 col-xs-6">
          <h3 class="panel-title" style="float: right;"><a href="<?=base_url();?>admin/register/search_quiz_questions" class="btn btn-success">Back</a></h3>          
        </div>
        </div>
        <div class="panel-body" style="padding: 29px 0px;">
          <div class="table-responsive">
              <p style="text-align: center;"><?php if($exam_name !=''){?>
              <b>Course: <?php echo $exam_name;?>
              <?php }?></b>
              <b><?php if($subject_name!=''){?>
              Subject: <?php echo  $subject_name;?>
              <?php }?></b>
              <b><?php if($topic_name !=''){?>
              Chapter: <?php echo  $topic_name;?>
              <?php }?></b>
              <b><?php if($qbank_topic !=''){?>
              Toipc : <?php echo $qbank_topic;?>
              <?php }?></b></p><br><br>

            <table id="users" class="table datatable table-striped">


            <!-------- Search Form ---------->
            <form id="fees_form1" name="search" method="post" class="pull-right">
                <div class="col-md-3 col-md-offset-1" style="padding:0">
                    <input type="text" name="search_text_1" id="search_text_1" placeholder="Type keyword to search" class="input-sm form-control custom-input" style="margin-left:5px;">
                </div>
                <div class="col-md-3">
                  <select name="search_on_1" id="search_on_1" class="form-control input-sm custom-input">
                    <option value="1">Question ID</option>
                    <option value="2">QUESTION</option>
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
                <div class="col-md-1" style="width: 5.333333%!important">
                  <button type="button" id="search_user" class="btn btn-info margin_search" style=""><i class="fa fa-search icon-style"></i></button>
                </div>

                
            </form> 
            <div class="col-md-1">
                  <form method="POST" action="">
                    <input type="hidden" name="exam_id" value="<?php echo $exam_id?>"/>
                    <input type="hidden" name="subject_id" value="<?php echo $subject_id?>"/>
                    <input type="hidden" name="chapter_id" value="<?php echo $chapter_id?>"/>
                    <input type="hidden" name="topic_id" value="<?php echo $topic_id?>"/>
                    <button type="submit" name="submit" class="btn btn-danger"><i class="fa fa-minus icon-style"></i></button> 
                  </form>
                </div>
            </table>                                  
          </div>

          <!-- <div class="table-responsive">
          <table  class="table datatable table-striped">
            <form method="POST" action="">
                  <input type="hidden" name="exam_id" value="<?php echo $exam_id?>"/>
                  <input type="hidden" name="subject_id" value="<?php echo $subject_id?>"/>
                  <input type="hidden" name="chapter_id" value="<?php echo $chapter_id?>"/>
                  <input type="hidden" name="topic_id" value="<?php echo $topic_id?>"/>
                  <button type="submit" name="submit" class="btn btn-danger"><i class="fa fa-minus icon-style"></i></button> 
                </form>
                </table>
          </div> -->
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
    var exam_id=  '<?php echo $exam_id;?>';
    var subject_id=  '<?php echo $subject_id;?>';
    var chapter_id=  '<?php echo $chapter_id;?>';
    var topic_id=  '<?php echo $topic_id;?>';
    $(document).ready(function () {
        dtabel = $('#users').DataTable({
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
            "url": "<?php echo base_url('admin/register/all_search_quiz_questions'); ?>",
            "type":"POST",
            beforeSend: function() {
              $("#wait").css("display", "block");
            },
            "data":function (d){
                d.search_text_1 = search_text_1;
                d.search_on_1 = search_on_1;
                d.search_at_1 = search_at_1;
                d.exam_id = exam_id;
                d.subject_id = subject_id;
                d.chapter_id = chapter_id;
                d.topic_id = topic_id;
            },
            "dataSrc": function ( jsondata ) {
                $("#wait").css("display", "none");
                return jsondata['data'];
            }
        },
        "columns": [
            { "title": "S.No", "name":"sno", "orderable": false, "data":"sno", "width":"0%" },
    { "title": "Actions", "name":"action", "orderable": false, "deafultContent":"", "data": "id", "width":"0%", "class":"td_actionn"},
    { "title": "On/Off", "name":"id","orderable": false, "data":"id", "width":"0%" },
    { "title": "Question ID", "name":"question_unique_id","orderable": false, "data":"question_unique_id", "width":"0%" },
            { "title": "Course Name", "name":"ename","orderable": false, "data":"ename", "width":"0%" }, 
             { "title": "Subject Name", "name":"sname","orderable": false, "data":"sname", "width":"0%" },
             { "title": "Chapter name", "name":"qtname","orderable": false, "data":"qtname", "width":"0%" },
             { "title": "Topic name", "name":"qtname","orderable": false, "data":"qbanktopicname", "width":"0%" },
             { "title": "question", "name":"question","orderable": false, "data":"question", "width":"0%" },
         { "title": "answer", "name":"answer","orderable": false, "data":"answer", "width":"0%" }, 
        { "title": " explanation", "name":"explanation","orderable": false, "data":"explanation", "width":"0%" },
        { "title": " Reference", "name":"reference","orderable": false, "data":"reference", "width":"0%" },
        
            { "title": "Created Date", "name":"created_on","orderable": false, "data":"created_on", "width":"0%" }, 
                    
        ],
        "fnCreatedRow": function(nRow, aData, iDataIndex) 
        {            
          var action ='<a class="btn btn-warning btn-condensed" title="edit" href="'+url+'admin/register/edit_quiz_questions/'+aData['id']+'"><i class="fa fa-edit"></i></a> <a onclick="return confirm('+"'Are you sure want to delete?'"+');" class="btn btn-danger btn-condensed" title="delete" href="'+url+'admin/register/delete_quiz_questions/'+aData['id']+'"><i class="fa fa-trash"></i></a>';
          $(nRow).find('td:eq(1)').html(action);

          if(aData['status'] == "Active")
          {
            var status ='<a title="Click to Inactive" href="'+url+'admin/register/change_quiz_question_status/'+aData['id']+'/Inactive" class="btn btn-success btn-condensed">ON</a>';
          }
          else
          {
            var status ='<a title="Click to Active" href="'+url+'admin/register/change_quiz_question_status/'+aData['id']+'/Active" class="btn btn-danger btn-condensed">OFF</a>';
          }
          $(nRow).find('td:eq(2)').html(status);

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

