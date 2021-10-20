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
    <title>Forgot password - Smart Venue | Vendor Panel</title>
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
              <form class="card" action="javascript:void(0)" method="post" id="validation">
                <div class="card-body p-6">
                  <div class="card-title">Forgot password</div>
                  <p class="text-muted">Enter your Mobile Number reset your password.</p>
                  <div class="alert alert-success select_lat_error wow shake" style="display: none" id="f_success">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                    Password has been updated Successfull!</a>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="exampleInputEmail1">Mobile Number</label>
                    <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter Mobile Number" name="mobile" id="mobile">
                  </div>

                  <div class="form-group" id="otp-div" style="display: none">
                    <label class="form-label" for="exampleInputEmail1">Enter otp</label>
                    <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter OTP" name="otp" id="otp" >
                    <label id="otp1-error" class="otp1-error" for="otp1" style="display: none">Otp not matched.</label>
                    <a href="javascript:void(0)" id="resend_otp" onclick="resend_otp()" style="float: right;">Resend Otp</a>
                  </div>

                  <input type="hidden" name="otp_confirmed" id="otp_confirmed" value="no">

                  <div id="open_password" style="display: none">
                    <div class="form-group">
                      <label class="form-label">Password</label>
                      <input type="password" class="form-control" placeholder="Password" name="password" id="password" required="">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Confirm Password</label>
                      <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm_password" required="">
                    </div>
                  </div>
                  <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                  </div>
                </div>
              </form>
              <div class="text-center text-muted">
                Forget it, <a href="<?=base_url();?>vendor">send me back</a> to the sign in screen.
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
<script type="text/javascript">
$(document).ready(function() {
  $("#validation").validate({
    rules: {
      // simple rule, converted to {required:true}
      mobile: {
        required : true,
        number:true,
        minlength:10,
        maxlength:10,
        remote: {
          url: '<?=base_url();?>vendor/login/check_mobile_valid',
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
      password: {
          required : true,
          minlength:6
      },
      confirm_password: {
          required : true,
          equalTo : "#password",
          minlength:6
      },
      // otp: {
      //     required : true,
      // },
    },
    messages:{
      // otp: {
      //    required : "Enter OTP to continue",
      // },      
      mobile: {
        remote : "This Mobile Number is not Registered with us",
      }
    },
    submitHandler: function(form) {
        //$("#btnSubmit").prop('disabled', true);
        form.submit();
    }
  });


  $("#validation").submit(function()
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
      var otp = $("#otp").val(); 
      var password = $("#password").val();
      var confirm_password = $("#confirm_password").val();//alert(password);alert(confirm_password);
      if(otp_confirmed == "no" && otp == "" && mobile != "")
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
        //var generated_otp = '<?=$this->session->userdata('otp');?>';
        //alert(generated_otp);        
        if(password != "" && confirm_password != "" && (password == confirm_password))
        {
            var form_data = $("#validation").serialize();//alert(form_data);
            $.ajax({
                url: "<?=base_url();?>vendor/login/update_password",
                data: form_data,
                type: "POST",
                success: function(user_id) 
                { 
                    $('#f_success').show();
                    $("#validation").find("input[type=text], input[type=email],input[type=password], textarea").val("");
                $("#btnSubmit").prop('disabled', true);
                $("#otp-div").hide();
                $("#otp_confirmed").val('no');
                $('#open_password').hide();
                    // setTimeout(function(){
                    //     location.reload();
                    //  }, 1200);                            
                }
            });
        }
        else if(generated_otp == otp)
        {
          $('#open_password').show();
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
  });
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