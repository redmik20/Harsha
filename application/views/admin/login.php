	<!DOCTYPE html>
	<html lang="en">
		<head>	
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />	
		<title>Login - DBMCI</title>	
		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />	
		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/bootstrap.min.css" />	
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/font-awesome/4.2.0/css/font-awesome.min.css" />	
		<!-- text fonts -->		
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/fonts/fonts.googleapis.com.css" />	
		<!-- ace styles -->		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/ace.min.css" />
		<!--[if lte IE 9]>	
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/ace-part2.min.css" />
		<![endif]-->	
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/ace-rtl.min.css" />	

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">	
		<!--[if lte IE 9]>	
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/ace-ie.min.css" />	
		<![endif]-->	
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>		<script src="<?php echo site_url();?>assets/admin/js/html5shiv.min.js"></script>
		<script src="<?php echo site_url();?>assets/admin/js/respond.min.js"></script>
		<![endif]-->
		</head>	
		<body class="login-layout light-login">	
			<div class="main-container">
			<div class="main-content">
			<div class="row">		
			<div class="col-sm-10 col-sm-offset-1">	
			<div class="login-container">	
			<div class="center">		
			<img src="<?php echo site_url();?>assets/admin/images/logo/dbmci.jpg" style="height: 100px; width: 100%padding:18px; margin-left: 0px">	
			</div>						
			<div class="space-6"></div>	
			<div class="position-relative">	
			<div id="login-box" class="login-box visible widget-box no-border">		
			<div class="widget-body">										
			<div class="widget-main">									
											<h4 class="header blue lighter bigger">
			<i class="ace-icon fa fa-user-secret green"></i>		
			Login	</br>									
										<?php if( $this->session->flashdata( 'message' ) ) { ?>
                                            <span style="color:#F00; font-size:12px; font-weight:bold; text-align:center;">
                                                <?php echo $this->session->flashdata( 'message' ); ?>
                                            </span> 
                                        <?php  }else if( $this->session->flashdata( 'messages' ) ) { ?>
                                            <span style="color:green; font-size:12px; font-weight:bold; text-align:center;">
                                                <?php echo $this->session->flashdata( 'messages' ); ?>
                                            </span> 
                                        <?php  }else{ ?>
			                      
                 <?php } //print_r($this->session->all_userdata());?>
										<?php if(isset($error)) echo $error;?>
										
											</h4>
					<form method="post" action="" >			
					<fieldset style="text-align: left;">
					<span>User ID / Email</span>
						<label class="block clearfix">		
							<span class="block input-icon input-icon-right">	
								<input type="text" class="form-control" placeholder="User ID / Email" name="user_email" id="user_email" value="<?php echo set_value('user_email'); ?>" required />	
								<?php echo form_error('user_email'); ?>
								<i class="ace-icon fa fa-user"></i>						
							</span>										
						</label>
					<div><span>Password</span></div>
						<label class="block clearfix">			
							<span class="block input-icon input-icon-right">
								<input type="password" class="form-control" placeholder="Password" name="password" id="password" value="<?php echo set_value('password'); ?>" required />	
								   <?php echo form_error('password'); ?>
								<i class="ace-icon fa fa-lock"></i>								
							</span>													
						</label>
					
					<div class="space"></div>							
					<div class="clearfix">
					<input type="submit" name="submit" id="submit" class="pull-right btn btn-sm btn-primary" value="Login" />
						
					</div>
					<div class="space-4"></div>					
					</fieldset>										
					</form>										
		</div><!-- /.widget-main -->				
		<div class="toolbar clearfix">				
		<!-- <div>											
		<a href="<?php echo site_url()?>admin/forgot_password" class="forgot-password-link">
		<i class="ace-icon fa fa-arrow-left"></i>			
		I forgot my password							
		</a>										
		</div> -->								
		</div>								
		</div><!-- /.widget-body -->			
		</div><!-- /.login-box -->				
		<div id="forgot-box" class="forgot-box widget-box no-border">		
		<div class="widget-body">										
		<div class="widget-main">							
		<h4 class="header red lighter bigger center">	
		<i class="ace-icon fa fa-key"></i>					
		Retrieve Password					
		</h4>								
		<div class="space-6"></div>			
		<p>									
		Enter Admin E-mail ID to Reset Password
		</p>									
		<form>						
		<fieldset>					
		<label class="block clearfix">	
		<span class="block input-icon input-icon-right">
		<input type="email" class="form-control" placeholder="Email ID" />		
		<i class="ace-icon fa fa-envelope"></i>								
		</span>												
		</label>										
		<div class="clearfix">						
		<button type="button" class="width-35 pull-right btn btn-sm btn-danger">	
		<i class="ace-icon fa fa-lightbulb-o"></i>				
		<span class="bigger-110">Send Me!</span>				
		</button>											
		</div>											
		</fieldset>									
		</form>									
		</div><!-- /.widget-main -->			
		<div class="toolbar center">				
		<a href="#" data-target="#login-box" class="back-to-login-link">
		<i class="ace-icon fa fa-arrow-left"></i>					
		Back to login												
		</a>									
		</div>								
		</div><!-- /.widget-body -->			
		</div><!-- /.forgot-box -->				
		</div><!-- /.position-relative -->		
		</div>				
		</div><!-- /.col -->	
		</div><!-- /.row -->		
		</div><!-- /.main-content -->
		</div><!-- /.main-container -->
		<!-- basic scripts -->		
		<!--[if !IE]> -->		
		<script src="<?php echo site_url();?>assets/admin/js/jquery.2.1.1.min.js"></script>	
		<!-- <![endif]-->		
		<!--[if IE]><script src="<?php echo site_url();?>assets/admin/js/jquery.1.11.1.min.js"></script><![endif]-->
		<!--[if !IE]> -->		
		<script type="text/javascript">
		window.jQuery || document.write("<script src='<?php echo site_url();?>assets/admin/js/jquery.min.js'>"+"<"+"/script>");	
		</script>	
		<!-- <![endif]-->
		<!--[if IE]><script type="text/javascript"> window.jQuery || document.write("<script src='<?php echo site_url();?>assets/admin/js/jquery1x.min.js'>"+"<"+"/script>");</script><![endif]-->
		<script type="text/javascript">	
		if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo site_url();?>assets/admin/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>	
		<!-- inline scripts related to this page -->
		<script type="text/javascript">		
		jQuery(function($) {			
		$(document).on('click', '.toolbar a[data-target]', function(e) {
			e.preventDefault();			
			var target = $(this).data('target');
			$('.widget-box.visible').removeClass('visible');//hide others	
			$(target).addClass('visible');
			//show target		
		 });
		 });	
		 //you don't need this, just used for changing background	
		 jQuery(function($)
		 {	
		 $('#btn-login-dark').on('click', function(e) 
		 {				
		 $('body').attr('class', 'login-layout');
		 $('#id-text2').attr('class', 'white');	
		 $('#id-company-text').attr('class', 'blue');	
		 e.preventDefault();			
		 });			
		 $('#btn-login-light').on('click', function(e) {
			 $('body').attr('class', 'login-layout light-login');	
			 $('#id-text2').attr('class', 'grey');			
			 $('#id-company-text').attr('class', 'blue');	
			 e.preventDefault();		
			 });		
			 $('#btn-login-blur').on('click', function(e) {	
			 $('body').attr('class', 'login-layout blur-login');		
			 $('#id-text2').attr('class', 'white');		
			 $('#id-company-text').attr('class', 'light-blue');	
			 e.preventDefault();		
			 });			 			
			 });		
			 </script>	
			 </body>
			 </html>
		