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
					<li class="active">Available Funds Details</li>
				</ul><!-- /.breadcrumb -->						
			</div>
			<div class="page-content">						 
				<div class="page-header">
								
					<h1 class="col-lg-6 col-md-3 col-sm-3 col-xs-9  pdg-top-10">
					<i class=" pull-left blue fa fa-dashboard"></i>
						Available Funds Details  
					</h1>
					<div class="pull-right">								
						<a class="btn btn-success btn-sm" href="<?php echo site_url();?>admin/available_funds/income_expense_details/<?php echo $attachment_id?>" type="button">Back </a>
						<!-- <a class="btn btn-warning btn-sm" href="<?php echo site_url();?>#" type="button"><i class="fa fa-bar-chart fa-lg"></i>  </a> -->
						 <input type="hidden" name="hiv" id="hiv" value="0" />
	               </div>
				</div><!-- /.page-header -->
				
				<section class="edu_admin_content">	 
					<div class="sectionHolder edu_admin_right edu_dashboard_wrap">
						<div class="edu_dashboard_widgets">							
				    		
						<div class="row">
				    			<?php if(!empty($payment_modes)){
				    				foreach($payment_modes as $value){

				    					if($value['total_amount'] != ''){
				    						 $total_amount=$value['total_amount'];
				    						}else{$total_amount=0;}
				    					?>
				    						
			    				<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					 <a href="<?php echo base_url()?>admin/available_funds/<?php echo $function_type?>/<?php echo $attachment_id;?>/<?php echo $value['id']?>"> 
				    					<div class="edu_color_boxes box_left">
				    						<div class="edu_dash_box_data">
				    						    <p><b><?php echo $value['payment_mode']?></b></p>
				    							<h3><b><?php echo number_format($total_amount);?></b></h3>    					
				    						</div>
				    						<div class="edu_dash_box_icon">
												<i class="fa fa-money" aria-hidden="true"></i>
				    						</div>
				    						<div class="edu_dash_info">
				        					    <ul>
				    					            <li><p><b>Total Income : </b><span><b><?php echo number_format($total_amount);?></b></span></p></li>
				    					            <!-- <li><p><b>Due Fees : </b> <span><b><?php echo $due_amount;?></b></span></p></li> -->
				    					        </ul>
				    					    </div>
				    					</div>
			    					 </a> 
			    				</div>
			    				
			    			<?php }
			    		}else{?>

			    			<center><b> No records found...!</b></center>

			    			<?php } ?>	
				    		
				    	</div>
					        </div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
		
		
		