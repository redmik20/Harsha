<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="<?php echo site_url();?>admin/dashboard">Home</a>
							</li>

							<li class="active">Change Password</li>
						</ul><!-- /.breadcrumb -->

						
					</div>

					<div class="page-content">
						

						<div class="page-header">
							<h1 class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<i class="fa fa-key blue"></i>  Change <span class="blue"> Password </span>							
							</h1>
							
						</div><!-- /.page-header -->
						 <?php echo $message; ?>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								 
								<form class="form-horizontal" role="form" method="post" action="">
								<div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">
									<!---old-password-->
									<div class="row">
										<div class="form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
												<label class="input-text"> Old Password <span class="star">*</span></label>
											</div>
											<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
												<input class="form-control" type="password" name="cur_pwd" value="<?php echo set_value('cur_pwd'); ?>" placeholder="Old Password"  required>
												<?php echo form_error('cur_pwd'); ?>
											</div>
										</div>
									</div>
									<!---old-password-end--->
									<!---new--password---->
									<div class="row">
										<div class="form-group frm-btm">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
												<label class="input-text"> New Password <span class="star">*</span></label>
											</div>
											<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
												<input class="form-control" type="password" name="new_pwd" value="<?php echo set_value('new_pwd'); ?>" placeholder="New Password"  required>
											<?php echo form_error('new_pwd'); ?>
											</div>
										</div>
									</div>
									<!---new--password-end--->
									<!---confirm--password---->
									<div class="row">
										<div class="form-group ">
											<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
												<label class="input-text"> Confirm Password <span class="star">*</span></label>
											</div>
											<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 input-text"> : </div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 word-brk">
												<input class="form-control" type="password" name="conf_pwd" value="<?php echo set_value('conf_pwd'); ?>" placeholder="Confirm New Password" required>
												<?php echo form_error('conf_pwd'); ?>
											</div>
										</div>
									</div>
									<!---confirm--password-end--->
				
									
									
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center">
												<input type="submit" name="submit" id="add" class="btn btn-success btn-sm" value="Save" />	
											</div>
						</form>

								 
								
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
			

