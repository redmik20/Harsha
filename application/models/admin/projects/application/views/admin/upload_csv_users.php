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
      echo form_open_multipart('admin/import/importFile1FromUsers', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Add bulk Users</h2>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <div class="panel-body">
              
              


           

             
            <div class="form-group">
              <label class="col-md-4 col-xs-12 control-label">Upload csv</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <input type="file" class="fileinput btn-primary" name="upload" id="icon" />
                </div>
              </div>
            </div>   
            




          </div>
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/users" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
            <button type="submit" class="btn btn-primary pull-right" id="btnSubmit">Submit</button>
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

var password= document.getElementById("password").value; 
var cnf_password= document.getElementById("cnf_password").value;

if(password == ''){
 alert ("\nPassword must be filled..") 
                    return false; 
}

if(cnf_password == ''){
 alert ("Confirm Password must be filled..") 
                    return false; 
}

/*if (password != cnf_password){ 
                    alert ("\nPassword did not match: Please try again...") 
                    return false; 
                } */

var useremail= document.getElementById("user_email").value; 
 
var pattern = /^[a-z0-9]+@[a-z0-9]+\.(com|net|in|info|org)$/i;

  
     if(!pattern.test(useremail))
            {
          alert('enter valid e-mail address');
          return false;
            }
     
      

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





