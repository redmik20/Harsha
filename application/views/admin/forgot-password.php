	<!DOCTYPE html>
	<html lang="en">
		<head>	
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />	
		<title>Admin Login - My jobs bank</title>	
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
	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="icon-leaf green"></i>
									<span class="red">Admin</span>
									<span class="white">Panel</span>
								</h1>
								<h4 class="blue">&copy; <?php echo $_SERVER['SERVER_NAME'];?></h4>
							</div>
							<div class="space-6"></div>
                            
							<div class="position-relative">
                                
								<div id="forgot-box" class="forgot-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="icon-key"></i>
												Retrieve Password
											</h4>
											<div class="space-6"></div>
                                            
											<p>
										<?php if( $this->session->flashdata( 'message' ) ) : ?>
                                            <span style="color:#F00; font-size:12px; font-weight:bold; text-align:center;">
                                                <?php echo $this->session->flashdata( 'message' ); ?>
                                            </span> 
                                        <?php  else: ?>
											Enter your email and to receive instructions
                                        <?php endif; //print_r($this->session->all_userdata());?>
										<?php if(isset($error)) echo $error;?>
											</p>
											<form name="forgot-form" id="forgot-form" action="<?php echo site_url()?>admin/forgot_password" method="post">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" name="email" id="email" value="<?php echo set_value('email'); ?>" required/>
														  <?php echo form_error('email'); ?>
															<i class="icon-envelope"></i>
														</span>
													</label>
													<div class="clearfix">
														<!--<button type="button" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="icon-lightbulb"></i>-->
                                                            <input type="submit" name="submit" class="pull-right btn btn-sm btn-danger" value="Send Me!" />
														<!--</button>-->
													</div>
												</fieldset>
											</form>
										</div><!-- /widget-main -->
										<div class="toolbar center">
											<a href="<?php echo site_url()?>admin/" onclick="show_box11('login-box'); return false;" class="back-to-login-link">
												Back to login
												<i class="icon-arrow-right"></i>
											</a>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /forgot-box -->
                                
							</div><!-- /position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>
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
		