<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">users</a></li>
  <li class="active">Update Users</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_users', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Update User</h2>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <div class="panel-body">
              
              <!--<div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Select Courses</label>

              <div class="col-md-6 col-xs-12">
                <select class="form-control chosen-select" name="course_ids[]" id="course_ids" multiple>
                  <option value="">Select Course</option>
                  <?php
                  if(!empty($exams))
                  {
                    foreach($exams as $exam)
                    {
                      ?>
                      <option value="<?=$exam->id;?>" 
                      <?php if(!empty($user_exams)){foreach($user_exams as $ue){
                        if($ue['exam_id'] == $exam->id){?> 
selected

<?php } } }?>
                        ><?=$exam->name;?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>-->
   
          


            <div class="form-group">
              <label for="user_name" class="col-md-3 col-xs-12 control-label">Enter User Name          <span style="color:red">*</span></label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="user_name" id="user_name" value="<?php echo $user['name']?>" required=""/>
              </div>
            </div>

            


              <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter User Email </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="user_email" id="user_email"  value="<?php echo $user['email_id']?>"/>
              </div>
              </div>

              <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Mobile Number <span style="color:red">*</span></label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="number" maxlength="10" class="form-control" 
                name="user_mobile" id="user_mobile" required="" value="<?php echo $user['mobile']?>"/>
              </div>
              </div>
            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Gender</label>
              <div class="col-md-6 col-xs-12">
                <input class="" type="radio" name="gender" <?php if($user['gender'] == 'Male'){ ?> checked <?php } ?> value="Male">
                <label for="yes">Male</label>
                </br>
                <input class="" type="radio" name="gender" <?php if($user['gender'] == 'Female'){ ?> checked <?php } ?> value="Female">
                <label for="no">Female</label>
              </div>
          </div> 

             <div class="form-group">
              <label for="user_name" class="col-md-3 col-xs-12 control-label">College </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="college" id="college" value="<?php echo $user['college']?>" />
              </div>
            </div>

            <div class="form-group">
              <label for="user_name" class="col-md-3 col-xs-12 control-label">Location </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="location" id="location" value="<?php echo $user['location']?>"/>
              </div>
            </div>
              


          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Status</label>
              <div class="col-md-6 col-xs-12">
                <input class="" type="radio" name="status" <?php if($user['status'] == 'Active'){ ?> checked <?php } ?> value="Active"/>
                <label for="1">Active</label>
                </br>
                <input class="" type="radio" name="status" value="Inactive" <?php if($user['status'] == 'Inactive'){ ?> checked <?php } ?>/>
                <label for="0">De active</label>
              </div>
            </div>   

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">User Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <input type="file" class="fileinput btn-primary" name="image" id="icon" />
                </div>
                <?php if($user['image'] !=''){?>
              <img src="<?php echo base_url().$user['image'];?>" height="100" width="100">
              <?php }else{?>
              <img src="<?php echo base_url('storage/no_image.jpg')?>" height="100" width="100">
              <?php }?>
              </div>
            </div>   


           <!-- <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Select Courses</label>

              <div class="col-md-6 col-xs-12">
               
                  <?php
                  if(!empty($exams))
                  {
                    foreach($exams as $exam)
                    {
                      ?>
                      <input type="checkbox" name="course_ids[]" id="course_ids1" value="<?=$exam->id;?>"  <?php if(!empty($user_exams)){foreach($user_exams as $ue){
                        if($ue['exam_id'] == $exam->id){?> 
checked

<?php } } }?> /><?=$exam->name;?>
                        <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Free/Paid</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="payment_type[]" id="payment_type" >
                 <option value="<?php echo $exam->id ?>_free" <?php if(!empty($user_exams)){foreach($user_exams as $ue){
                        if(($ue['exam_id'] == $exam->id) && ($ue['payment_type'] == 'free')){?> 
selected

<?php } } }?>>Free</option> 
                  <option value="<?php echo $exam->id ?>_paid"  <?php if(!empty($user_exams)){foreach($user_exams as $ue){
                        if(($ue['exam_id'] == $exam->id) && ($ue['payment_type'] == 'paid')){?> 
selected

<?php } } }?>>paid</option>
                   </select>
              </div>
            </div>
                      </br>
                      <?php
                    }
                  }
                  ?>
            
              </div>
            </div>-->

            <h3 style="text-align: center;"><b>Assign Package</b></h3>
             <hr>

              <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Select Package</label>

              <div class="col-md-6 col-xs-12">
<div class="form-group">
               <select class="form-control" name="package_id" id="package_id" onchange="return getPrices(this.value)" >
                <option value="" > Select Package</option>
             <?php 
              if(!empty($pacakages))
                  {
                    foreach($pacakages as $package)
                    {?>

<option value="<?php echo $package['id']?>"  <?php if($user['package_id'] == $package['id'] ){ ?>  selected <?php }  ?> > <?php echo $package['package_name']?></option>

                     <?php  }

                  }
               ?>
               </select>
               
               
</div>


<div class="form-group">
<label class="col-md-3 col-xs-12 control-label">Select Price</label>
<div class="col-md-6 col-xs-12">
<div class="form-group">
               <select class="form-control" name="price_id" id="price_id" >
                <option value="" > Select Prices</option>
             
               </select>
               
 </div> </div> </div>

               <div class="form-group">
              <label for="user_name" class="col-md-3 col-xs-12 control-label">Applied Coupon Code </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="coupon_code" id="coupon_code" value=""/>
              </div>
            </div>


            <div class="form-group">
              <label for="user_name" class="col-md-3 col-xs-12 control-label"><span style="color:red">Recipt ID (Online-payment-failed-cases-in-app-only) </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="order_id" id="order_id" value=""/>
              </div>
            </div>


            <div class="form-group">
              <label for="user_name" class="col-md-3 col-xs-12 control-label">Offline Paid Amount </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="final_paid_amt" id="final_paid_amt" value=""  />
              </div>
            </div>

             <div class="form-group">
              <label for="user_name" class="col-md-3 col-xs-12 control-label">Message </label>
              <div class="col-md-6 col-xs-12">                
               
                <textarea type="text" class="form-control" name="message" id="message" value="" ></textarea>
              </div>
            </div>


</div>
               </div>
            
          <input class="" type="hidden" name="user_id"  value="<?php echo $user['id']?>"/>



          </div>
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/users" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
            <button type="submit" class="btn btn-primary pull-right" id="btnSubmit" onclick="checkvalidation();">Submit</button>
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
var user_name= document.getElementById("user_name").value;

if(user_name == ''){
 alert ("User Name must be filled..") 
                    return false; 
}



var useremail= document.getElementById("user_email").value; 
 
/*var pattern = /^[a-z0-9]+@[a-z0-9]+\.(com|net|in|info|org)$/i;

  
     if(!pattern.test(useremail))
            {
          alert('enter valid e-mail address');
          return false;
            }
     */
      

      /*$.ajax({

      type : "POST",   

      url : '<?php echo base_url();?>admin/register/checkUserEmail',    

      data  : "useremail="+useremail,

      complete: function(data){  

        var op = data.responseText.trim();

        //$("#societies").html(op);
        if(op == 1){
            alert('Email already exists');
            return false;
          }
       }

    });*/
         
         var mobilenumber= document.getElementById("user_mobile").value;
//alert(mobilenumber);
if(mobilenumber == ''){
 alert ("Mobile number must be filled..") 
                    return false; 
}else{
  //alert(mobilenumber);
             /*$.ajax({

                  type : "POST",   

                  url : '<?php echo base_url();?>admin/register/checkUserMobile',    

                  data  : "mobilenumber="+mobilenumber,

                  complete: function(data){  

                    var op = data.responseText.trim();

                    //$("#societies").html(op);
                    //alert(op);
                    if(op == 1){
                        alert('Mobile No already exists');
                        return false;
                      }
                   }

                }); */
           }

           return false;
    
   

    //return true;  

    //form.submit();  
           
}

  /*$(document).ready(function() { //alert();
      $("#validation").validate({
          rules: {
            // simple rule, converted to {required:true}            
            topic_name: {
                required : true,
            }
          },
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
  });
 
*/ 

function getPrices(package_id){
  
    //alert(exam_id);
    var package_id=$('#package_id').val();
    //alert(exam_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/register/getPackagePrices',
      data: {package_id: package_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#price_id").html(data);
        $("#wait").css("display", "none");
      }
    });
  
}

</script>





