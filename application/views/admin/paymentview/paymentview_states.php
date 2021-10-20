	<div class="main-content">
		<div class="main-content-inner">
			<div class="breadcrumbs" id="breadcrumbs">
				<script type="text/javascript">
					try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
				</script>
				<ul class="breadcrumb">
					<li>
						<i class="ace-icon fa fa-home home-icon"></i>
						<a href="dashboard.html">Home</a>
					</li>
					<li class="active">States</li>
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
					<h1 class="col-lg-6 col-md-3 col-sm-3 col-xs-9  pdg-top-10">
					<i class=" pull-left blue fa fa-dashboard"></i>
						States  
					</h1>
					<div class="pull-right">								
						<a class="btn btn-success btn-sm" href="<?php echo site_url();?>admin/paymentview" type="button">Back </a>
						<!-- <a class="btn btn-warning btn-sm" href="<?php echo site_url();?>#" type="button"><i class="fa fa-bar-chart fa-lg"></i>  </a> -->
						 <input type="hidden" name="hiv" id="hiv" value="0" />
	               </div>
				</div><!-- /.page-header -->
				
				<section class="edu_admin_content">	 
					<div class="sectionHolder edu_admin_right edu_dashboard_wrap">
						<div class="edu_dashboard_widgets">							
				    		<div class="row">
				    			<?php foreach($states as $state){ ?>
			    				<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<a href="<?php echo base_url()?>admin/paymentview/org_state/<?php echo $state['id']?>">
				    					<div class="edu_color_boxes box_left">
				    						<div class="edu_dash_box_data">
				    						    <p><b><?php echo $state['state']; ?></b></p>
				    							<h3><b><?php if($state['total_amount'] != ''){
										    			echo roundInt($state['total_amount']);
												    		}else{
												    			echo 0;
												    		}
												    	?></b></h3>    					
				    						</div>
				    						<div class="edu_dash_box_icon">
												<i class="fa fa-cog" aria-hidden="true"></i>
				    						</div>
				    						<div class="edu_dash_info">
				        					    <ul>
				    					            <li><p><b>Total collected : </b><span><b>

				    					            	

				    					            	<?php if($state['total_amount'] != ''){
										    			echo roundInt($state['total_amount']);
												    		}else{
												    			echo 0;
												    		}
												    	?>
				    					            		
				    					            	</b></span></p></li>
				    					            <li><p><b>Due Fees : </b> <span><b>

				    					            	
						    					            <?php if($state['total_due_amount'] != ''){
												    			echo roundInt($state['total_due_amount']);
												    		}else{
												    			echo 0;
												    		}
												    		?>
				    					            		
				    					            	</b></span></p></li>
				    					        </ul>
				    					    </div>
				    					</div>
			    					</a>
			    				</div>
			    			<?php }?>
			    				<!-- <div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<a href="<?php echo base_url('admin/paymentview/org_state')?>">
				    					<div class="edu_color_boxes box_center">
				    						<div class="edu_dash_box_data">
				    						    <p><b>Tamilnadu</b></p>
				    							<h3><b><?php echo $cash_at_office_count;?></b></h3>
				    						</div>
				    						<div class="edu_dash_box_icon">
				    							<i class="fa fa-cog" aria-hidden="true"></i>
				    						</div>
				    						<div class="edu_dash_info">
												<ul>
												    <li><p><b>Total collected : </b><span><b><?php echo $collected_cash;?></b></span></p></li>
												    <li><p><b>Due Fees : </b> <span><b><?php echo $due_amount;?></b></span></p></li>
												</ul>
						    				</div>
				    					</div>
			    					</a>
			    				</div>
			    				<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<a href="<?php echo base_url('admin/paymentview/org_state')?>">
			        					<div class="edu_color_boxes box_right">
			        						<div class="edu_dash_box_data">
			        						    <p><b>Kerala</b></p>
			        							<h3><b>1,04,62,000</b></h3>
			        						</div>
			        						<div class="edu_dash_box_icon">				        							
												<i class="fa fa-cog" aria-hidden="true"></i>
			        						</div>
			        						<div class="edu_dash_info">
												<ul>
												    <li><p><b>Total collected : </b><span><b><?php echo $collected_cash;?></b></span></p></li>
												    <li><p><b>Due Fees : </b> <span><b><?php echo $due_amount;?></b></span></p></li>
												</ul>
						    				</div>
			        					</div>
			    					</a>
			    				</div> -->
				    		</div>				    				
				    	</div>
					        </div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
		
		
		