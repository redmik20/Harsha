<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">users</a></li>
  <li class="active">Assign course to Users</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      
      
        <div class="panel panel-default">
      

          <div class="panel-heading">
          <div class="row">
          
  <div class="col-sm-4"><h2 class="panel-title">Assign course to Users</h2> </div>
  
  <div class="col-sm-1">Search:</div>
  <div class="col-sm-2"><input type="text" name="user_name" id="user_name" placeholder="" class="input-sm form-control custom-input" style="margin-left:5px;"/></div>
  <div class="col-sm-1"><button type="button" id="search_user" class="btn btn-info margin_search" style=""><i class="fa fa-search icon-style" aria-hidden="true"></i></button></div>
 
  <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/import/importFile', $attributes); 
     
     
      ?>
 <input type="hidden" name="course_id" value="<?php echo $course_id;?>" />
  <div class="col-sm-2"> <input type="file" class="fileinput btn-primary" name="upload" id="icon" /></div>  
  <div class="col-sm-2"> <button type="submit" class="btn btn-primary pull-right" id="btnSubmit">Submit</button>
  </div>
</div>
</form>
                       
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <div class="panel-body">
              
              <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Course Name</label>

              <div class="col-md-6 col-xs-12">
                <?php $course=$this->db->query('select * from exams where id="'.$course_id.'" ')->row_array();
                    echo $course['name'];
                ?>
              </div>
            </div>
            <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/assignCourseToUser/'.$course_id, $attributes); 
      ?>
   <input type="hidden"  name="course_id" value="<?php echo $course_id; ?>"/>
      <div class="form-group">    
<label for="user_name" class="col-md-3 col-xs-16 control-label">Select User </label></div>

<div id="users_details" class="col-sm-12"></div>

  <div class="col-sm-12"><?php foreach($users as $user){?>
    <?php if($user['course_status'] == 1){ ?>
            <div class="form-group">
              
              <div class="col-md-3 col-xs-12">                
             
                <input type="checkbox" <?php if($user['course_status'] == 1){?> checked <?php }?> class="form-control" name="user_name[]" value="<?php  echo $user['id'];  ?>"  />
            
              </div>
              <div class="col-md-3 col-xs-12">                
                <?php  echo $user['name'];  ?>---(<?php  echo $user['mobile'];  ?>)
              </div>
            </div>
            <?php } ?>
<?php }?>
             

          </div>
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/users" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
            <button type="submit" class="btn btn-primary pull-right" id="btnSubmit" >Submit</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- END PAGE CONTENT WRAPPER -->
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-validate-additional-methods.js"></script>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
<script src="https://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" />-->
<link href="https://harvesthq.github.io/chosen/chosen.css" rel="stylesheet" />

<script>
//$('select[multiple]').multiselect();

$('#course_ids').chosen();

function checkvalidation(){
  //alert();

}


$( "#search_user" ).click(function() {
 // alert( "Handler for .click() called." );
var username = $("#user_name").val();
$.ajax({
   url:"<?php echo base_url('admin/register/serach_users'); ?>",
   method:"POST",
   data:{username:username},
   success:function(data){
  //   console.log(data);
     $('#users_details').html("");
            var obj = JSON.parse(data);
            if(obj.length>0){
             try{
              var items=[];  
              $.each(obj, function(i,val){   
                  items.push($('<div class="col-sm-12"><div class="form-group"><div class="col-md-3 col-xs-12"><input type="checkbox" class="form-control" name="user_name[]" value="'+val.id+'"  /></div><div class="col-md-3 col-xs-12">'+val.name+"--("+val.mobile+')</div></div></div>').html());
              }); 
              $('#users_details').append.apply($('#users_details'), items);
             }catch(e) {  
              alert('Exception while request..');
             }  
            }else{
             $('#users_details').html("No Data Found");  
            }  
            
           },
           error: function(){      
            alert('Error while request..');
           }
          });
        

});
</script>





