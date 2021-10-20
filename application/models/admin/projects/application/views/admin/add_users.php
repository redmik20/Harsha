<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">users</a></li>
  <li class="active">Add Users</li>
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
            <h2 class="panel-title">Add User</h2>            
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
                <select class="form-control chosen-select" name="course_ids[]" id="course_ids" >
                  <option value="">Select Course</option>
                  <?php
                  if(!empty($exams))
                  {
                    foreach($exams as $exam)
                    {
                      ?>
                      <option value="<?=$exam->id;?>"><?=$exam->name;?>(<?=$exam->payment_type;?>)(<?=$exam->discount_price;?>)</option>
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
                <input type="text" class="form-control" name="user_name" id="user_name" required=""/>
              </div>
            </div>

             <div class="form-group">
              <label for="user_name" class="col-md-3 col-xs-12 control-label">Enter Password  <span style="color:red"></span></label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="password" class="form-control" name="password" id="password" />
              </div>
            </div>

            <div class="form-group">
              <label for="user_name" class="col-md-3 col-xs-12 control-label">Confirm Password  <span style="color:red"></span></label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="password" class="form-control" name="cnf_password" id="cnf_password"/>
              </div>
            </div>


              <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter User Email <span style="color:red"></span></label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" 
                name="user_email" id="user_email"/>
              </div>
              </div>

              <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Enter Mobile Number <span style="color:red">*</span></label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="number" maxlength="10" class="form-control" 
                name="user_mobile" value="" id="user_mobile" required=""/>
              </div>
              </div>
            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Gender</label>
              <div class="col-md-6 col-xs-12">
                <input class="" type="radio" name="gender" checked value="Male">
                <label for="yes">Male</label>
                </br>
                <input class="" type="radio" name="gender" value="Female">
                <label for="no">Female</label>
              </div>
          </div> 

              
            <div class="form-group">
              <label for="user_name" class="col-md-3 col-xs-12 control-label">College </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="college" id="college"/>
              </div>
            </div>

            <div class="form-group">
              <label for="user_name" class="col-md-3 col-xs-12 control-label">Location </label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="location" id="location"/>
              </div>
            </div>

          <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Status</label>
              <div class="col-md-6 col-xs-12">
                <input class="" type="radio" name="status" checked value="Active"/>
                <label for="1">Active</label>
                </br>
                <input class="" type="radio" name="status" value="Inactive"/>
                <label for="0">De active</label>
              </div>
            </div>   

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">User Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <input type="file" class="fileinput btn-primary" name="image" id="icon" />
                </div>
              </div>
            </div>   

             
            <!--<div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Select Courses</label>

              <div class="col-md-6 col-xs-12">
               
                  <?php
                  if(!empty($exams))
                  {
                    foreach($exams as $exam)
                    {
                      ?>
                      <input type="checkbox" name="course_ids[]" id="course_ids1" value="<?=$exam->id;?>"/><?=$exam->name;?>
                        <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Free/Paid</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="payment_type[]" id="payment_type" >
                 <option value="free">Free</option> 
                  <option value="paid">paid</option>
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
/*
var password= document.getElementById("password").value; 
var cnf_password= document.getElementById("cnf_password").value;

if(password == ''){
 alert ("\nPassword must be filled..") 
                    return false; 
}

if(cnf_password == ''){
 alert ("Confirm Password must be filled..") 
                    return false; 
}*/

/*if (password != cnf_password){ 
                    alert ("\nPassword did not match: Please try again...") 
                    return false; 
                } */
/*
var useremail= document.getElementById("user_email").value; 
 
var pattern = /^[a-z0-9]+@[a-z0-9]+\.(com|net|in|info|org)$/i;

  
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

</script>





