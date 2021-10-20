<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">users</a></li>
  <li class="active">Update Package to Users</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      
      
        <div class="panel panel-default">
      

          <div class="panel-heading">
          

                       
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
         
            <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_package_to_users/'.$package_id, $attributes); 
      ?>
   <input type="hidden"  name="package_id" value="<?php echo $package_id; ?>"/>
      <div class="form-group">    
<label for="user_name" class="col-md-3 col-xs-16 control-label">Package Users (<?php echo $package['package_name'];?>)</label></div>

<div id="users_details" class="col-sm-12"></div>

  <div class="col-sm-12">
  <?php 
    if(!empty($users)){ 
    foreach($users as $user){ 
      ?>
    
            <div class="form-group">
              
              <div class="col-md-3 col-xs-12">                
             
                <!--<input type="checkbox" <?php if($user['course_status'] == 1){?> checked <?php }?> class="form-control" name="user_name[]" value="<?php  echo $user['id'];  ?>"  />-->
              <input type="hidden"  name="user_ids[]" value="<?php  echo $user['user_id'];  ?>"/>
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
            <button type="submit" class="btn btn-primary pull-right" id="btnSubmit" >Update Package</button>
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
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" />-->
<link href="http://harvesthq.github.io/chosen/chosen.css" rel="stylesheet" />

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





