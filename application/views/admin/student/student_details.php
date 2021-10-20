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
							<li>								 
								<a href="<?php echo site_url();?>admin/student">Student Details</a>
							</li>
							<li class="active">Details</li>
						</ul><!-- /.breadcrumb -->						
					</div>

					<div class="page-content">
						<div class="page-header-2">
							<h1 class="col-lg-4 col-md-3 col-sm-3 col-xs-12 pdg-top-10">
								<i class="menu-icon fa fa-list-ul blue"></i>Student
								<span class="label label-purple arrowed">Student Details<span>
							</h1>
							<div class="pull-right ">							 
								 <input type="hidden" name="hiv" id="hiv" value="0" />
                           </div>
						</div><!-- /.page-header -->
						
						 <?php if( $this->session->flashdata( 'msg_succ' ) ) { ?>
									<div class="alert alert-block alert-success">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>
										<i class="ace-icon fa fa-check green"></i>	
										<strong class="green">
											<?php echo $this->session->flashdata( 'msg_succ' ); ?>
										</strong>
									</div>
								<?php } ?>
								
								<?php if( $this->session->flashdata( 'msg_danger' ) ) { ?>
									<div class="alert alert-block alert-success">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>
										<i class="ace-icon fa fa-check red"></i>
										<strong class="red">
											<?php echo $this->session->flashdata( 'msg_danger' ); ?>
										</strong>		
									</div>
								<?php } ?>
								   
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
										<form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 ">
									<div class="row form-group frm-btm">
										<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
											<h2>Student Details</h2><hr>
										</div>
									</div>
									<div class="container">
									<div class="row form-group frm-btm">
										<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
											<div style="overflow-x:auto;">
											<table>
												<tr>
													<th>S.No</th>
													<th>Center</th>
													<th>Course</th>
													<th>Batch</th>
													<th>Student Name</th>
													<th>Mobile No</th>
													<th>Final Fees</th>
													<th>Discount</th>
													<th>Discount Scheme</th>
													<th>Amount to be Paid</th>
													<th>Remarks</th>
													<th>Actions</th>
												</tr>
												<tr>
													<td>1</td>
													<td>Hyderabad</td>
													<td>Psyclogy</td>
													<td>2020</td>
													<td>Bichunaik</td>
													<td>+91 9494805486</td>
													<td>70,000.00</td>
													<td>5,000.00</td>
													<td>NEW@123</td>
													<td>50,000</td>
													<td>Sample</td>
													<td><input type="submit" name="add"  class="btn btm-sm btn-success btn-sm" value="EDIT" /></td>
												</tr>  
												<tr>
													<td>1</td>
													<td>Hyderabad</td>
													<td>Psyclogy</td>
													<td>2020</td>
													<td>Bichunaik</td>
													<td>+91 9494805486</td>
													<td>70,000.00</td>
													<td>5,000.00</td>
													<td>NEW@123</td>
													<td>50,000</td>
													<td>Sample</td>
													<td><input type="submit" name="add"  class="btn btm-sm btn-primary btn-sm" value="EDIT" /></td>
												</tr> 
											</table>
										</div>
										</div>
									</div>	
									</div>								
								</div> 									
							</div>
								
							<div class="col-lg-12 col-xs-12 col-sm-12">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formfooter text-center mgtp-btm-10">
									<input type="submit" name="add"  class="btn btm-sm btn-success btn-sm" value="Submit" />									
								</div>								
							</div><!-- End Row -->
						</form>
					</div>
				</div>
			</div>		
		</div>
	</div><!-- /.main-content -->
			
	