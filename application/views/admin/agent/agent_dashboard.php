	<div class="main-content">
		<div class="main-content-inner">
			<div class="breadcrumbs" id="breadcrumbs">
				<script type="text/javascript">
					try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
				</script>
				<ul class="breadcrumb">
					<li>
						<i class="ace-icon fa fa-home home-icon"></i>
						<?php if($this->session->userdata('user_type') == 'employee'){?>
						<a href="agent_dashboard">Home</a>
						<?php } else { ?>
						<a href="dashboard">Home</a>
						<?php } ?>
					</li>
					<li class="active">Employee Dashboard</li>
				</ul><!-- /.breadcrumb -->						
			</div>
			<div class="page-content">						 
				<div class="page-header">
					<?php 
						if($this->session->flashdata('message')!=''){
						?>						
						<div class="alert alert-success alert-dismissable">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
						<?php echo $this->session->flashdata('message');?>
						</div>	
						<?php 
						}
					?>				
					<h1 class="col-lg-6 col-md-3 col-sm-3 col-xs-6  pdg-top-10">
					<i class=" pull-left blue fa fa-dashboard"></i>
						Employee Dashboard  
					</h1>
					<div class="pull-right">								
						<!-- <a class="btn btn-success btn-sm" href="<?php echo site_url();?>master/hyderabad_city_tour_booking_data" type="button"><i class="fa fa-bar-chart fa-lg"></i> </a> -->
						<p><b>Name:</b> <?php echo $emp_record['user_name']?></p>
						<p><b>Id:</b> <?php echo $emp_record['user_id']?></p>
						<!-- <a class="btn btn-warning btn-sm" href="<?php echo site_url();?>master/ramoji_film_city_booking_data" type="button"><i class="fa fa-bar-chart fa-lg"></i>  </a>
						 <input type="hidden" name="hiv" id="hiv" value="0" /> -->
	               </div>
				</div><!-- /.page-header -->
				<div class="row">
					<!-- <div class="col-md-3 col-xs-12 col-lg-3 col-sm-3">
						<div class="widget-item-icon" onclick="location.href='<?php echo base_url('#')?>';" style="color:blue">
							<div class="edu_color_boxes box_left">
	    						<div class="edu_dash_box_data">
	    							   <h4><b>My Activity</b></h4>
	    							   <p><span><b><?php echo $students_count;?></b></span></p>	
	    						</div>
	    						<div class="edu_dash_box_icon">
									<i class="fa fa-cog" aria-hidden="true"></i>
	    						</div>
	    					</div>                                  
				        </div>
					</div> -->
					<!-- <a href="<?php echo base_url()?>admin/nonbhatia_payments/add/agent_dashboard"> -->
				<a href="<?php echo base_url()?>admin/payment_portal">
					<div class="col-md-3 col-xs-12 col-lg-3 col-sm-3">

							<div class="widget-item-icon" onclick="location.href='<?php echo base_url('admin/payment_portal')?>'">
							<div class="edu_color_boxes box_left">
	    						<div class="edu_dash_box_data">
	    							   <h4><b>Collect New Payment</b></h4>
	    							   <p><!-- <span><b>30,05,62</b></span> --></p>	
	    						</div>
	    						<div class="edu_dash_box_icon">
									<img src="<?php echo base_url();?>assets/admin/images/logo/new-payment.png" style="width: 101%;height: 100%;border-radius: 12px;">
	    						</div>
	    					</div>                                     
				        </div>
					</div><!-- /.col -->
					</a>
					<a href="<?php echo base_url()?>admin/agent_dashboard/agent_incomes_list/1">
					<div class="col-md-3 col-xs-12 col-lg-3 col-sm-3">
						<div class="widget-item-icon" onclick="location.href='<?php echo base_url('admin/agent_dashboard/agent_incomes_list/1')?>';">
							<div class="edu_color_boxes box_left">
	    						<div class="edu_dash_box_data">
	    							   <h4><b>My Total Collection</b></h4>
	    							   <!-- <p><b><?php echo roundInt($incomes_total['total_amount']);?></b></span></p> -->	
	    						</div>
	    						<div class="edu_dash_box_icon">
									<img src="<?php echo base_url();?>assets/admin/images/logo/rupee.jpg" style="width: 101%;">
	    						</div>
	    						<div class="edu_dash_info">
	        					    <ul>

	        					    	<li><p ><b style="color:green">Approved: </b> <span><b><?php echo roundInt($incomes_total['total_amount']);?></b></span></p></li>

	    					            <li><p><b style="color:orange;">Pending : </b><span><b><?php echo roundInt($incomes_pending['total_amount']); ?>&nbsp;&nbsp;&nbsp;</b></span></p></li>

	    					            <li><p ><b style="color:red">Rejected: </b> <span><b><?php echo roundInt($incomes_rejected['total_amount']);?></b></span></p></li>
	    					        </ul>
				    			</div>
	    					</div>                                    
				        </div>
					</div><!-- /.col -->
				  </a>

				  <?php if($payment_mode_id != 0){?>

				  	<a href="<?php echo base_url()?>admin/agent_dashboard/agent_incomes_list/2">
					<div class="col-md-3 col-xs-12 col-lg-3 col-sm-3">
						<div class="widget-item-icon" onclick="location.href='<?php echo base_url('admin/agent_dashboard/agent_incomes_list/2')?>';">
							<div class="edu_color_boxes box_left">
	    						<div class="edu_dash_box_data">
	    							<?php $res=$this->db->query('select id,payment_mode from tbl_payment_modes where id="'.$payment_mode_id.'" ' )->row_array();

	    							?>
	    							   <h4><b><?php 
	    							   if(!empty($res)){
	    							   echo $res['payment_mode'];
	    									}else{ echo 'No Payment Mode'; }
	    							   ?></b></h4>
	    							   <!-- <p><b><?php echo roundInt($incomes_total['total_amount']);?></b></span></p> -->	
	    						</div>
	    						<div class="edu_dash_box_icon">
									<img src="<?php echo base_url();?>assets/admin/images/logo/kavya.png" style="width: 100%;border-radius: 12px;">
	    						</div>
	    						<div class="edu_dash_info">
	        					    <ul>
	        					    	<li><p ><b style="color:green">Approved: </b> <span><b><?php echo roundInt($incomes_payment_mode_total['total_amount']);?></b></span></p></li><br>

	    					            <li><p><b style="color:orange;">Pending : </b><span><b><?php echo roundInt($incomes_payment_mode_pending['total_amount']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span></p></li>

	    					            <li><p ><b style="color:red">Rejected: </b> <span><b><?php echo roundInt($incomes_payment_mode_rejected['total_amount']);?></b></span></p></li>
	    					        </ul>
				    			</div>
	    					</div>                                    
				        </div>
					</div><!-- /.col -->
				  </a>

				  <?php } ?>

				  <a href="<?php echo base_url()?>admin/expenses">
					<div class="col-md-3 col-xs-12 col-lg-3 col-sm-3">
						<div class="widget-item-icon" onclick="location.href='<?php echo base_url('admin/expenses')?>';">
							<div class="edu_color_boxes box_left">
	    						<div class="edu_dash_box_data">
	    							   <h4><b>My Total Expenses</b></h4>
	    							   <!-- <p><b><?php echo roundInt($incomes_total['total_amount']);?></b></span></p> -->	
	    						</div>
	    						<div class="edu_dash_box_icon">
									<img src="<?php echo base_url();?>assets/admin/images/logo/total-expen.png" style="width: 101%;">
	    						</div>
	    						<div class="edu_dash_info">

	    							<ul>

	        					    	<li><p ><b style="color:green">Approved: </b> <span><b><?php echo roundInt($expense_approval['total_amount']);?></b></span></p></li>

	    					            <li><p><b style="color:orange;">Pending : </b><span><b><?php echo roundInt($expense_pending['total_amount']);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span></p></li>

	    					            <li><p ><b style="color:red">Rejected: </b> <span><b><?php echo roundInt($expense_rejected['total_amount']);?></b></span></p></li>
	    					        </ul>
				    			</div>
	    					</div> 

	    					                                  
				        </div>
					</div><!-- /.col -->
				  </a>

				  <?php if($payment_mode_id == 0){?>

				  <a href="<?php echo base_url()?>admin/agent_dashboard/my_admissions">
					<div class="col-md-3 col-xs-12 col-lg-3 col-sm-3">
						<div class="widget-item-icon" onclick="location.href='<?php echo base_url('admin/agent_dashboard/my_admissions')?>';">
							<div class="edu_color_boxes box_left">
	    						<div class="edu_dash_box_data">
	    							   <h4><b>My Admissions</b></h4>
	    							   <p><span><b><?php echo $my_total_admissions['admission_count'];?></b></span></p>	
	    						</div>
	    						<div class="edu_dash_box_icon">
									<img src="<?php echo base_url();?>assets/admin/images/logo/total-admin.jpg" style="width: 101%;">
	    						</div>
	    					</div>                                    
				        </div>
					</div>
					</a>
					<?php }?>

					
				</div>
				
				<div class="row">
					<?php if($payment_mode_id != 0){?>

				  <a href="<?php echo base_url()?>admin/agent_dashboard/my_admissions">
					<div class="col-md-3 col-xs-12 col-lg-3 col-sm-3">
						<div class="widget-item-icon" onclick="location.href='<?php echo base_url('admin/agent_dashboard/my_admissions')?>';">
							<div class="edu_color_boxes box_left">
	    						<div class="edu_dash_box_data">
	    							   <h4><b>My Admissions</b></h4>
	    							   <p><span><b><?php echo $my_total_admissions['admission_count'];?></b></span></p>	
	    						</div>
	    						<div class="edu_dash_box_icon">
									<img src="<?php echo base_url();?>assets/admin/images/logo/total-admin.jpg" style="width: 101%;">
	    						</div>
	    					</div>                                    
				        </div>
					</div>
					</a>
					<?php }?>

					<a href="<?php echo base_url()?>admin/student/add">
					<div class="col-md-3 col-xs-12 col-lg-3 col-sm-3">
						<div class="widget-item-icon" onclick="location.href='<?php echo base_url('admin/student/add')?>';">
							<div class="edu_color_boxes box_left">
	    						<div class="edu_dash_box_data">
	    							   <h4><b>Take New Admission</b></h4>
	    							   <p><!-- <span><b>20,03,12,000</b></span> --></p>	
	    						</div>
	    						<div class="edu_dash_box_icon">
									<img src="<?php echo base_url();?>assets/admin/images/logo/add-student.png" style="width: 101%;">
	    						</div>
	    					</div>                                      
				        </div>
					</div><!-- /.col -->
					</a>

					<a href="<?php echo base_url()?>admin/student/admission_link_step1">
					<div class="col-md-3 col-xs-12 col-lg-3 col-sm-3">
						<div class="widget-item-icon" onclick="location.href='<?php echo base_url('admin/student/admission_link_step1')?>';">
							<div class="edu_color_boxes box_left">
	    						<div class="edu_dash_box_data">
	    							   <h4><b>Send Admission Link</b></h4>
	    							   
	    						</div>
	    						<div class="edu_dash_box_icon">
									<img src="<?php echo base_url();?>assets/admin/images/logo/new-expen.png" style="width: 101%;">
	    						</div>
	    					</div>                                      
				        </div>
					</div><!-- /.col -->
					</a>
				</div>

				</div><!-- /.row -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
		<!--[if !IE]> -->
		
		
		