<?PHP header("cache-Control: no-store, no-cache, must-revalidate");
header("cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
  //echo '<pre>'; print_r($this->session->all_userdata()); if(($this->session->userdata('logged_in')!='ECOM')||($this->session->userdata('username')=="")||($this->session->userdata('logged_in')=='')){	redirect('/master/');}
  ?>
  <!DOCTYPE html>
<html lang="en">
	<head>
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Admin - Dashboard</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/bootstrap.min.css" />
		
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/font-awesome/4.2.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/chosen.min.css" />
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/fonts/fonts.googleapis.com.css" />
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/style.css" />
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/custom.css" />
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/colorpicker.min.css" />
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/datepicker.min.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
		
		<!-- fa fa-icons -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo site_url();?>assets/admin/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="<?php echo site_url();?>assets/admin/js/ace-extra.min.js"></script>

		<script src="<?php echo base_url();?>assets/admin/js/jquery-3.0.0.min.js"></script>

		<style>.parsley-errors-list{list-style: none;color:red;}.canvasjs-chart-credit{display:none;}</style>
 <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/parsley.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/jquery.toast.css" />

  <!-- EOF CSS INCLUDE --> 
   <style type="text/css">
    .alert-error, .error {
      color: #ff0000;
    }
    .alert-success {
      color: #3c763d;
      background-color: #dff0d8;
      border-color: #d6e9c6;
    }
 .x-navigation.x-navigation-horizontal li.user{
      padding: 10px;
      line-height: 30px;
      color: #fff;
      font-weight: bold;
    }

  </style>   
	</head>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<!-- <a href="index.html" class="navbar-brand">
						<small>
							
							ISSM 
						</small>
					</a> -->
					<small class="navbar-brand">
							
							Admin Dashboard
						</small>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						
					
						
						
						<li class="green">
							<!-- <a href="<?php echo site_url();?>index" target="_blank" class=""> -->
								<i class="ace-icon fa fa-globe icon-animated-bell" style="color:white;"></i>
								<?php //echo '<pre>';print_r($this->session->userdata('user_id'));exit;

								$user_id=$this->session->userdata('user_id');
								$user=$this->db->query("select login_time,user_name from tbl_users where user_id='".$user_id."' ")->row_array();?>
								<span class="bold" style="color:white;">Last Login TIme (<?php echo $user['login_time']; ?>)</span>
						<!-- 	</a> -->
						</li>

						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<i class="fa fa-user-secret fa-2x"></i>
								<span class="user-info">
									<small>Welcome,</small>
									<?php echo  $user['user_name'];?>
								</span>

								<!-- <i class="ace-icon fa fa-caret-down"></i> -->
							</a>
							<!-- <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								
								<li class="divider"></li>
								<li>
									<a href="<?php echo site_url();?>admin/change_password">
										<i class="ace-icon fa fa-key"></i>
										Change Password
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="<?php echo site_url();?>admin/login/logout">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul> -->
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>