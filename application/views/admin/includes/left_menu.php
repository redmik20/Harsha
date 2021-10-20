	<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				<!-- <div class="sidebar-shortcuts" id="sidebar-shortcuts">
			<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						
						
						<a class="btn btn-info" href="<?php echo site_url();?>admin/change_password" title="Add Voucher">
							<i class="fa fa-file-text fa-lg"></i>
						</a>

						<a class="btn btn-info" href="<?php echo site_url();?>admin/login/logout" title="Capture Payments">
							<i class="menu-icon fa-lg fa fa-power-off"></i>
						</a>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div> -->
				<!-- /.sidebar-shortcuts -->
				 
				<ul class="nav nav-list">
				
					
					<?php  $uri = $this->uri->segment(2); 

					//echo '<pre>';print_r($roleResponsible);exit;

					?>
					
				
					<?php if(!empty($roleResponsible['dashboard'])){ ?>
					<li class="<?php if($uri=='dashboard') echo 'active';?>">
						<a href="<?php echo site_url();?>admin/dashboard">
							<i class="menu-icon blue fa fa-dashboard"></i>
							<span class="menu-text"> Dashboard </span>
						</a>
					</li>
				<?php }?>

				
				
				<?php if(!empty($roleResponsible['employee_dashboard'])){ ?>
				<li class="<?php if($uri=='employee_dashboard') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/agent_dashboard">
									<i class="menu-icon fa fa-dashboard blue"></i>	
									 <span style="padding:3px">Employee Dashboard</span>
								</a>
								<b class="arrow"></b>
							</li>
					<?php }?>
				<?php if(!empty($roleResponsible['total_batches'])){ ?>
				<li class="<?php if($uri=='total_batches') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/total_batches/total_batches_list">
									<i class="menu-icon fa fa-calendar blue"></i>	
									 <span style="padding:3px">Total Batches</span>
								</a>
								<b class="arrow"></b>
							</li>
				<?php }?>

				<?php if(!empty($roleResponsible['daily_sheet'])){ ?>
				<li class="<?php if($uri=='daily_sheet') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/daily_sheet">
									<i class="menu-icon fa fa-calendar blue"></i>	
									 <span style="padding:3px">Daily Sheet</span>
								</a>
								<b class="arrow"></b>
							</li>
					<?php }?>

					<?php if(!empty($roleResponsible['special_attendance'])){ ?>
				<li class="<?php if($uri=='special_attendance') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/specialattendance">
									<i class="menu-icon fa fa-calendar blue"></i>	
									 <span style="padding:3px">Special Attendance</span>
								</a>
								<b class="arrow"></b>
							</li>
					<?php }?>

			<?php if((!empty($roleResponsible['students'])) || (!empty($roleResponsible['bulk_students'])) || (!empty($roleResponsible['general_students'])) || (!empty($roleResponsible['all_registered_students'])) ){ ?>	
			<li class="<?php if($uri=='student') echo 'active open';?>
						<?php if($uri=='student_upload') echo 'active open';?>	
						<?php if($uri=='nonbhatia_payments') echo 'active open';?>
						<?php if($uri=='payment_portal') echo 'active open';?>	
							">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon blue fa fa-shopping-cart"></i>
							<span class="menu-text"> Students </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<?php if(!empty($roleResponsible['general_students'])){ ?>
					
						<li class="<?php if($uri=='nonbhatia_payments') echo 'active';?>">
							<a href="<?php echo site_url();?>admin/nonbhatia_payments">
								<i class="menu-icon fa fa-caret-right"></i>
								<i class="blue fa fa-pencil-square-o bigger-120"></i> 
								<span style="padding:2px">General Students</span>
							</a>
							<b class="arrow"></b>
						</li>
					<?php }?>
					
					<?php if(!empty($roleResponsible['all_registered_students'])){ ?>

					   <li class="<?php if($uri=='payment_portal') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/payment_portal">	
							<i class="menu-icon fa fa-money blue"></i>	
							<i class="blue fa fa-pencil-square-o bigger-120"></i> 
							<span class="menu-text">All Registered Students</span>
						</a>	
						<b class="arrow"></b>	
				        </li>

				    <?php }?>
					
			
			<?php if(!empty($roleResponsible['students'])){
			if( in_array('a',$roleResponsible['students'])){?>
				<li class="<?php if($uri=='student') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/student/add">	
							<i class="menu-icon fa fa-user blue"></i>	
							<span class="menu-text"> New Regsitration</span>
						</a>		
				</li>
			<?php } }?>

			<?php if((!empty($roleResponsible['students'])) && in_array('l',$roleResponsible['students'])) { ?>

				<li class="<?php if($uri=='student') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/student/states">	
							<i class="menu-icon fa fa-users blue"></i>	
							<span class="menu-text"> Students</span>
						</a>		
				</li>
			<?php } ?>

			<?php if(!empty($roleResponsible['bulk_students'])) { ?>
				<li class="<?php if($uri=='student_upload') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/student_upload">	
							<i class="menu-icon fa fa-upload blue"></i>	
							<span class="menu-text"> Bulk Upload Students</span>
						</a>		
				</li>
				<?php } ?>
				</ul>
			</li>
		    <?php } ?>

			

			<?php if(!empty($roleResponsible['overview_details'])){ ?>

			<li class="<?php if($uri=='paymentview') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/paymentview">	
							<i class="menu-icon fa fa-money blue"></i>	
							<span class="menu-text"> OVERVIEW Details</span>
						</a>		
				</li>
			<?php }?>
			<?php if(!empty($roleResponsible['available_funds'])) { ?>
				<li class="<?php if($uri=='available_funds') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/available_funds">	
							<i class="menu-icon fa fa-money blue"></i>	
							<span class="menu-text"> Available funds</span>
						</a>		
				</li>
			<?php }?>

			

			<?php if(!empty($roleResponsible['transfer_funds'])) { ?>
				<li class="<?php if($uri=='transfer_funds') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/transfer_funds/transfer_funds_list">	
							<i class="menu-icon fa fa-money blue"></i>	
							<span class="menu-text"> Transfer funds</span>
						</a>		
				</li>
			<?php }?>

			<?php if(!empty($roleResponsible['payment_approvals'])){ ?>
			<li class="<?php if($uri=='payment_approvals') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/payment_approvals">	
							<i class="menu-icon fa fa-money blue"></i>	
							<span class="menu-text"> Payment Approvals</span>
						</a>		
				</li>
				<?php }?>

				<!-- <?php if((!empty($roleResponsible['expenses'])) && in_array('l',$roleResponsible['expenses'])) { ?>

							<li class="<?php if($uri=='expenses') echo 'active';?>">
							<a href="<?php echo site_url();?>admin/expenses">
								<i class="menu-icon fa fa-caret-right"></i>
								<i class="blue fa fa-pencil-square-o bigger-120"></i> 
								<span style="padding:2px">Expenses Approvals</span>
							</a>
							<b class="arrow"></b>
						</li>

						<?php }?> -->
			<?php /*if((!empty($roleResponsible['general_students'])) || (!empty($roleResponsible['registered_students']))  ){ ?>	

			<li class="
								<?php if($uri=='nonbhatia_payments') echo 'active open';?>
								<?php if($uri=='payment_portal') echo 'active open';?>
								
							">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon blue fa fa-shopping-cart"></i>
							<span class="menu-text"> Student Details </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
						
						<?php if(!empty($roleResponsible['general_students'])){ ?>
					
						<li class="<?php if($uri=='nonbhatia_payments') echo 'active';?>">
							<a href="<?php echo site_url();?>admin/nonbhatia_payments">
								<i class="menu-icon fa fa-caret-right"></i>
								<i class="blue fa fa-pencil-square-o bigger-120"></i> 
								<span style="padding:2px">General Students</span>
							</a>
							<b class="arrow"></b>
						</li>
					<?php }?>
					
					<?php if(!empty($roleResponsible['all_registered_students'])){ ?>

					   <li class="<?php if($uri=='payment_portal') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/payment_portal">	
							<i class="menu-icon fa fa-money blue"></i>	
							<i class="blue fa fa-pencil-square-o bigger-120"></i> 
							<span class="menu-text">All Registered Students</span>
						</a>	
						<b class="arrow"></b>	
				        </li>

				    <?php }?>
				        <!-- <li class="<?php if($uri=='payment_view') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/payment_view">	
							<i class="menu-icon fa fa-money blue"></i>	
							<span class="menu-text"> Payment View</span>
						</a>	
						<b class="arrow"></b>	
				        </li> -->
					</ul>
				</li>

				<?php }*/ ?>

				<?php if((!empty($roleResponsible['expenses'])) || (!empty($roleResponsible['categories'])) || (!empty($roleResponsible['advance_release']))  ){ ?>

				<li class="<?php if($uri=='expenses') echo 'active open';?>
          				   <?php if($uri=='category') echo 'active open';?>
          				   <?php if($uri=='advrelease') echo 'active open';?>">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon blue fa fa-shopping-cart"></i>
						<span class="menu-text">Add Expenses </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">

						 <?php if((!empty($roleResponsible['expense_approval'])) && in_array('l',$roleResponsible['expense_approval'])) { ?>

							<li class="<?php if($uri=='expenses') echo 'active';?>">
							<a href="<?php echo site_url();?>admin/expenses/expenses_list">
								<i class="menu-icon fa fa-caret-right"></i>
								<i class="blue fa fa-pencil-square-o bigger-120"></i> 
								<span style="padding:2px">Expenses Approval</span>
							</a>
							<b class="arrow"></b>
						</li>

						<?php }?>

						<?php if((!empty($roleResponsible['expenses'])) && in_array('a',$roleResponsible['expenses'])) { ?>

						<li class="<?php if($uri=='expenses') echo 'active';?>">
							<a href="<?php echo site_url();?>admin/expenses">
								<i class="menu-icon fa fa-caret-right"></i>
								<i class="blue fa fa-pencil-square-o bigger-120"></i> 
								<span style="padding:2px">Add Expenses</span>
							</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>

						<?php if(!empty($roleResponsible['categories'])){ ?>

						<li class="<?php if($uri=='category') echo 'active';?>">
							<a href="<?php echo site_url();?>admin/category">
								<i class="menu-icon fa fa-caret-right"></i>
								<i class="blue fa fa-pencil-square-o bigger-120"></i> 
								<span style="padding:2px">Add Categories</span>
							</a>
							<b class="arrow"></b>
						</li>

						<?php } ?>
						<?php  /*if(!empty($roleResponsible['advance_release'])){ ?>
						<li class="<?php if($uri=='advrelease') echo 'active';?>">
							<a href="<?php echo site_url();?>admin/advrelease">
								<i class="menu-icon fa fa-caret-right"></i>
								<i class="blue fa fa-pencil-square-o bigger-120"></i> 
								<span style="padding:2px">Advance Release</span>
							</a>
							<b class="arrow"></b>
						</li>
						<?php }*/ ?>	
					</ul>
				</li>
			<?php }?>
				
				<?php if((!empty($roleResponsible['states'])) || (!empty($roleResponsible['organisations'])) || (!empty($roleResponsible['centers'])) || (!empty($roleResponsible['courses'])) || (!empty($roleResponsible['batchs'])) || (!empty($roleResponsible['attachments'])) || (!empty($roleResponsible['payment_modes'])) || (!empty($roleResponsible['colleges'])) || (!empty($roleResponsible['discount_schemes'])) || (!empty($roleResponsible['departments']))   ){ ?>

					<li class="
								<?php if($uri=='courses') echo 'active open';?>
								<?php if($uri=='batchs') echo 'active open';?>
								<?php if($uri=='states') echo 'active open';?>
								<?php if($uri=='centers') echo 'active open';?>
								<?php if($uri=='colleges') echo 'active open';?>
								<?php if($uri=='discountscheme') echo 'active open';?>
								<?php if($uri=='payment_modes') echo 'active open';?>
								<?php if($uri=='attachment_groups') echo 'active open';?>
								<?php if($uri=='attachments') echo 'active open';?>
								<?php if($uri=='organisations') echo 'active open';?>
								<?php if($uri=='department') echo 'active open';?>
							">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon blue fa fa-list"></i>
							<span class="menu-text"> Masters </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<?php if(!empty($roleResponsible['states'])){ ?>
							<li class="<?php if($uri=='states') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/states">
									<i class="fa fa-building blue fa-lg"></i>
									<i class=""></i> <span style="padding:2px">States</span>
								</a>
								<b class="arrow"></b>
							</li>
							<?php }?>
							<?php if(!empty($roleResponsible['organisations'])){ ?>
							<li class="<?php if($uri=='organisations') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/organisations">
									<i class="fa fa-sitemap" aria-hidden="true"></i>
									<i class=""></i> <span style="padding:2px">Organisations</span>
								</a>
								<b class="arrow"></b>
							</li>
							<?php }?>

							<?php if(!empty($roleResponsible['centers'])){ ?>
							<li class="<?php if($uri=='centers') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/centers">
									<i class="fa fa-university blue fa-lg"></i>
									<i class=""></i> <span style="padding:2px">Centers</span>
								</a>
								<b class="arrow"></b>

							</li>
							<?php }?>
							<?php if(!empty($roleResponsible['courses'])){ ?>
							<li class="<?php if($uri=='courses') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/courses">
									<i class="menu-icon fa fa-caret-right"></i>
									<i class="blue fa fa-pencil-square-o bigger-120"></i> <span style="padding:2px">Courses</span>
								</a>
								<b class="arrow"></b>
							</li>
							<?php }?>

							<?php if(!empty($roleResponsible['main_batchs'])){ ?>
							<li class="<?php if($uri=='main_batchs') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/main_batchs">
									<i class="fa fa-cubes blue fa-lg"></i>
									<i class=""></i> <span style="padding:2px">Main Batches</span>
								</a>
								<b class="arrow"></b>
							</li>
							<?php }?>

							<?php if(!empty($roleResponsible['batchs'])){ ?>
							<li class="<?php if($uri=='batchs') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/batchs">
									<i class="fa fa-cubes blue fa-lg"></i>
									<i class=""></i> <span style="padding:2px">Batches</span>
								</a>
								<b class="arrow"></b>
							</li>
							<?php }?>
							<?php if(!empty($roleResponsible['attachment_groups'])){ ?>
							<li class="<?php if($uri=='attachment_groups') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/attachment_groups">
									<i class="fa fa-paperclip" aria-hidden="true"></i>
									<i class=""></i> <span style="padding:2px">Attachment Groups</span>
								</a>
								<b class="arrow"></b>
							</li>
							<?php }?>
							<?php if(!empty($roleResponsible['attachments'])){ ?>
							<li class="<?php if($uri=='attachments') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/attachments">
									<i class="fa fa-paperclip" aria-hidden="true"></i>
									<i class=""></i> <span style="padding:2px">Attachments</span>
								</a>
								<b class="arrow"></b>
							</li>
							<?php }?>
							<?php if(!empty($roleResponsible['payment_modes'])){ ?>
							<li class="<?php if($uri=='payment_modes') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/payment_modes">
									<i class="fa fa-credit-card-alt blue fa-lg"></i>
									<i class=""></i> <span style="padding:2px">Payment Modes</span>
								</a>
								<b class="arrow"></b>
							</li>
							<?php }?>
							<?php if(!empty($roleResponsible['colleges'])){ ?>
							<li class="<?php if($uri=='colleges') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/colleges">
									<i class="fa fa-graduation-cap blue fa-lg"></i>
									<i class=""></i> <span style="padding:2px">Colleges</span>
								</a>
								<b class="arrow"></b>
							</li>
							<?php }?>
							<?php if(!empty($roleResponsible['discount_schemes'])){ ?>
							<li class="<?php if($uri=='discountscheme') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/discountscheme">
									<i class="fa fa-circle blue fa-lg"></i>
									<i class=""></i> <span style="padding:2px">Discount Scheme</span>
								</a>
								<b class="arrow"></b>
							</li>
							<?php }?>

							<?php if(!empty($roleResponsible['departments'])){ ?>
							<li class="<?php if($uri=='department') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/department">
									<i class="fa fa-circle blue fa-lg"></i>
									<i class=""></i> <span style="padding:2px">Departments</span>
								</a>
								<b class="arrow"></b>
							</li>
							<?php }?>
							
							
					</ul>
				</li>

			<?php }?>

			<?php if((!empty($roleResponsible['in_stock']))  ){ ?>

				<li class="<?php if($uri=='stockdepartment') echo 'active open';?>
									
							">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon blue fa fa-shopping-cart"></i>
							<span class="menu-text"> StockManagement </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
					
			
				<?php if((!empty($roleResponsible['in_stock']))  ){ ?>
				<li class="<?php if($uri=='stockdepartment') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/stockdepartment">	
							<i class="menu-icon fa fa-user blue"></i>	
							<span class="menu-text"> In Stock</span>
						</a>		
				</li>
				<?php }?>
				<!-- <li class="<?php if($uri=='out_stockmanagement') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/out_stockmanagement">	
							<i class="menu-icon fa fa-users blue"></i>	
							<span class="menu-text"> Out Stock</span>
						</a>		
				</li> -->
				

				</ul>
			</li>
			<?php }?>
				

				<?php if((!empty($roleResponsible['schedule'])) || (!empty($roleResponsible['events'])) || (!empty($roleResponsible['special_attendance']))  ){ ?>


				<li class="<?php if($uri=='schedule') echo 'active open';?>
							<?php if($uri=='eventcreation') echo 'active open';?>		
							<?php if($uri=='specialattendance') echo 'active open';?>		
							">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon blue fa fa-calendar blue"></i>
							<span class="menu-text"> Schedule </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
					
			   <?php if(!empty($roleResponsible['schedule'])  ){ ?>
			    <li class="<?php if($uri=='schedule') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/schedule">	
							<i class="menu-icon fa fa-calendar blue"></i>	
							<span class="menu-text"> Schedule</span>
						</a>		
				</li> 
				<?php }?>
				<?php if(!empty($roleResponsible['events'])  ){ ?>
				<li class="<?php if($uri=='eventcreation') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/eventcreation">	
							<i class="menu-icon fa fa-money blue"></i>	
							<span class="menu-text"> Events</span>
						</a>		
				</li>
				<?php }?>
				<?php if(!empty($roleResponsible['special_attendance'])){ ?>
				<li class="<?php if($uri=='specialattendance') echo 'active';?>">	
						<a href="<?php echo site_url();?>admin/specialattendance">	
							<i class="menu-icon fa fa-money blue"></i>	
							<span class="menu-text"> Special Attendance</span>
						</a>		
				</li>
				<?php }?>
				

				</ul>
			</li>

				<?php }?>

				 
<?php if((!empty($roleResponsible['roles'])) || (!empty($roleResponsible['employees'])) ){ ?>
				 
	<li class="xn-openable <?php if($uri == "roles" || $uri == "add_roles" || $uri == "edit_roles" || $uri == "employees" || $uri == "add_employees" || $uri == "edit_employees" || $uri == "view_role_employees" ||  $uri == "view_employee" ): echo "active"; endif; ?>">
            
            <a href="#" class="dropdown-toggle">
							<i class="menu-icon blue fa fa-sitemap"></i>
							<span class="menu-text"> Roles </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>
           <b class="arrow"></b>

			<ul class="submenu">

		<?php if(!empty($roleResponsible['roles'])){ ?>
            
            <li <?php if($uri == "roles" || $uri == "add_roles" || $uri == "edit_roles" || $uri == "view_role_employees"): echo "class='active'"; endif; ?>>
            
            <a href="<?php echo base_url();?>admin/roles/roles">	
							<i class="menu-icon fa fa-sitemap blue"></i>	
							<span class="menu-text"> Roles</span>
						</a>  
            </li>
        <?php }?> 

           <?php if(!empty($roleResponsible['employees'])){ ?>
            <li <?php if($uri == "employees" || $uri == "add_employees" || $uri == "edit_employees" ||  $uri == "view_employee"): echo "class='active'"; endif; ?>>
            
            <a href="<?php echo base_url();?>admin/roles/employees">	
							<i class="menu-icon fa fa-user-plus blue"></i>	
							<span class="menu-text"> Employees</span>
						</a>      
            </li>
          <?php }?> 

           </ul>
          </li>
 			
 			
         	<?php }?>

         	<!-- <li class="<?php if($uri=='loans') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/loans">
									<i class="menu-icon fa fa-lock blue"></i>	
									 <span style="padding:3px">Loans</span>
								</a>
								<b class="arrow"></b>
							</li> -->
			
					<li class="<?php if($uri=='change_password') echo 'active';?>">
								<a href="<?php echo site_url();?>admin/change_password">
									<i class="menu-icon fa fa-lock blue"></i>	
									 <span style="padding:3px">Change Password</span>
								</a>
								<b class="arrow"></b>
							</li>


					
					
					<li class="">
						<a href="<?php echo site_url();?>admin/login/logout" >
							<i class="menu-icon blue fa fa-power-off"></i>
							<span class="menu-text"> Logout </span> 
						</a>
					</li> 
					
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>