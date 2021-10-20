<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title>Register - Smart Venue | Vendor Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <!-- <script src="<?=base_url();?>assets/vendor/assets/js/require.min.js"></script>
    <script>
      requirejs.config({
          baseUrl: '.'
      });
    </script> -->
    <!-- Dashboard Core -->
    <link href="<?=base_url();?>assets/vendor/assets/css/dashboard.css" rel="stylesheet" />
    <script src="<?=base_url();?>assets/vendor/assets/js/dashboard.js"></script>
    <!-- c3.js Charts Plugin -->
    <link href="<?=base_url();?>assets/vendor/assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
    <script src="<?=base_url();?>assets/vendor/assets/plugins/charts-c3/plugin.js"></script>
    <!-- Google Maps Plugin -->
    <link href="<?=base_url();?>assets/vendor/assets/plugins/maps-google/plugin.css" rel="stylesheet" />
    <script src="<?=base_url();?>assets/vendor/assets/plugins/maps-google/plugin.js"></script>
    <!-- Input Mask Plugin -->
    <script src="<?=base_url();?>assets/vendor/assets/plugins/input-mask/plugin.js"></script>
    <script src="<?=base_url();?>assets/js/jquery-3.0.0.min.js"></script>
  <script src="<?=base_url();?>assets/js/jquery.validate.min.js"></script>
  </head>
  <body class="">
    <div class="page">
      <div class="page-single">
        <div class="container">
          <div class="row">
            <div class="col col-login mx-auto">
              <div class="text-center mb-6">
               <img src="<?=base_url();?>assets/vendor/assets/images/logo/vendor-logo.png" />
              </div>
              <form class="card" action="javascript:void(0)" method="post" id="registration">
                <div class="card-body p-6">
                  <div class="card-title">Create new account</div>
                  <div class="alert alert-success select_lat_error wow shake" style="display: none" id="r_success">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                    Registration Successfull!</a>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" placeholder="Enter name" name="name" id="name" required="">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Mobile</label>
                    <input type="text" class="form-control" placeholder="Enter Mobile" name="mobile" id="mobile" required="">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Email address</label>
                    <input type="email" class="form-control" placeholder="Enter email" name="email_id" id="email_id" required="">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" id="password" required="">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm_password" required="">
                  </div>
                  <div class="of-hidden form-group" id="otp-div" style="display: none">
                    <div class="form-group">
                      <label class="form-label">Enter Otp</label>
                      <input type="text" class="form-control" placeholder="OTP" name="otp" id="otp" required="">
                      <label id="otp1-error" class="otp1-error" for="otp1" style="display: none">Otp not matched.</label>
                      <a href="javascript:void(0)" id="resend_otp" onclick="resend_otp()" style="float: right;">Resend Otp</a>
                    </div>
                 </div>

                 <input type="hidden" name="otp_confirmed" id="otp_confirmed" value="no">
                  <div class="form-group">
                    <!-- <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" />
                      <span class="custom-control-label">Agree the <a href="terms.html">terms and policy</a></span>
                    </label> -->
                    <span>After submitting this form, you agree the <a href="javascript:void(0)">terms and policy</a></span>
                  </div>
                  <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">Create new account</button>
                  </div>
                </div>
              </form>
              <div class="text-center text-muted">
                Already have account? <a href="<?=base_url();?>vendor">Sign in</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-validate-additional-methods.js"></script>
<script>
  $(document).ready(function() { //alert();
    $("#registration").validate({
          rules: {
            // simple rule, converted to {required:true}
            name: {
                required : true,
            },
            mobile: {
              required : true,
              number:true,
              minlength:10,
              maxlength:10,
              remote: {
                url: '<?=base_url();?>vendor/login/check_mobile_exists',
                type: "post",
                data: {
                  id: function() {
                    return $( "#id" ).val();
                  },
                  mobile: function() {
                    return $( "#mobile" ).val();
                  }
                }
              }            
            },
            email_id: {
              required : true,
              myEmail:true,
              remote: {
                url: '<?=base_url();?>vendor/login/check_email_id_exists',
                type: "post",
                data: {
                  id: function() {
                    return $( "#id" ).val();
                  },
                  email_id: function() {
                    return $( "#email_id" ).val();
                  }
                }
              }
            },
            password: {
                required : true,
                minlength:6
            },
            confirm_password: {
                required : true,
                minlength:6,
                equalTo : "#password"
            }
          },
          messages:{
            email_id: {
              remote : "Email Id already exists",
            },
            mobile: {
              remote : "Mobile Number already exists",
            }
          },
          submitHandler: function(form) {
              //$("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
  });
  jQuery.validator.addMethod("myEmail", function(value, element) {
    return this.optional( element ) || ( /^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/.test( value ) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test( value ) );
  }, 'Please enter valid email address.');



  $("#registration").submit(function()
  { //alert();
      if ($('.form-group').find('.error').length) { 
        if ($('.error').is(":visible"))
        { 
          $("#otp-div").hide();
          exit;
        }
      }
      var otp_confirmed = $("#otp_confirmed").val();
      var mobile = $("#mobile").val();
      var email_id = $("#email_id").val();
      var password = $("#password").val();
      var confirm_password = $("#confirm_password").val();
      var otp = $("#otp").val(); //alert(mobile);
      if(otp_confirmed == "no" && otp == "" && mobile != "" && email_id != "" && password != "" && confirm_password != "")
      { //alert('test');
          $.ajax({
              type:'post',
              url : '<?=base_url();?>vendor/login/send_otp',
              data : {mobile:mobile},
              beforeSend: function( xhr ){
                  xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                  $("#wait").css("display", "block");
              },
              success : function(data) { //alert(data);
                  //$("#show_temp_slots").html(data);
                  generated_otp = data;
                  $("#wait").css("display", "none");
                  return false;
              }
          });
          $("#otp-div").show();
          $("#otp_confirmed").val('yes');
      }
      else if(otp != "" && mobile != "")
      {
          if(email_id != "" && password != "" && confirm_password != "")
          {
              //var generated_otp = '<?=$this->session->userdata('otp');?>';
              //alert(generated_otp);
              if(generated_otp == otp)
              {
                  var form_data = $("#registration").serialize();//alert(form_data);
                  $.ajax({
                      url: "<?=base_url();?>vendor/login/submit_register",
                      data: form_data,
                      type: "POST",
                      success: function(user_id) 
                      { 
                          $('#r_success').show();
                          $("#registration").find("input[type=text], input[type=email],input[type=password], textarea").val("");
                      $("#btnSubmit").prop('disabled', true);
                      $("#otp-div").hide();
                      $("#otp_confirmed").val('no');
                          // setTimeout(function(){
                          //     location.reload();
                          //  }, 1200);                            
                      }
                  });
              }
              else
              {
                //alert();
                $("#registration").find("input[type=text], input[type=email],input[type=password], textarea").attr("readonly", true);
                $("#otp").attr("readonly", false);
                $("#otp-div").show();
                $("#otp_confirmed").val('yes');
                $("#otp1-error").show().html('Otp not matched.');
              }
          }
      }              
  });

  function resend_otp()
  {
    var otp_confirmed = $("#otp_confirmed").val();
    var mobile = $("#mobile").val();
    var otp = $("#otp").val(); 
    var password = $("#password").val();
    var confirm_password = $("#confirm_password").val();
    if(mobile == "")
    {
      alert('Mobile Number is required!');
      return false;exit;
    }
    if(mobile != "")
    { //alert('test');
        $.ajax({
            type:'post',
            url : '<?=base_url();?>vendor/login/send_otp',
            data : {mobile:mobile},
            beforeSend: function( xhr ){
                xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                $("#wait").css("display", "block");
            },
            success : function(data) { //alert(data);
                //$("#show_temp_slots").html(data);
                generated_otp = data;
                $("#wait").css("display", "none");
                return false;
            }
        });
        $("#otp-div").show();
        $("#otp_confirmed").val('yes');
    }
  } 
</script>


<style type="text/css">
  .error
  {
    color:red;
  }
  .otp1-error
  {
    color:red;
  }
</style>