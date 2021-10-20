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
					<li class="active">List Months</li>
				</ul><!-- /.breadcrumb -->						
			</div>
			<div class="page-content">						 
				<div class="page-header">
								
					<h1 class="col-lg-12 col-md-3 col-sm-3 col-xs-9  pdg-top-10">
					<i class=" pull-left blue fa fa-dashboard"></i>
						List Months ---> <b style="color:red"><?php echo $state['state'];?></b>(state) ---><b style="color:red"> <?php echo $organisation['organisation_name'];?> </b>(organasation) ---><b style="color:red"> <?php echo $center['center'];?> </b>(center) ---><b style="color:red"> <?php echo $year;?> </b>(Year) 
					</h1>
					<div class="pull-right">								
						<a class="btn btn-success btn-sm" href="<?php echo site_url();?>admin/paymentview/center_years/<?php echo $state_id?>/<?php echo $org_id?>/<?php echo $center_id?>" type="button">Back </a>
						<!-- <a class="btn btn-warning btn-sm" href="<?php echo site_url();?>#" type="button"><i class="fa fa-bar-chart fa-lg"></i>  </a> -->
						 <input type="hidden" name="hiv" id="hiv" value="0" />
	               </div>
				</div><!-- /.page-header -->
				
				<section class="edu_admin_content">	 
					<div class="sectionHolder edu_admin_right edu_dashboard_wrap">
						<div class="edu_dashboard_widgets">							
				    		<div class="row">
				    			<?php if(!empty($months)){
				    				foreach($months as $value){

				    						if($value['total_amount'] != ''){
				    						 $total_amount=roundInt($value['total_amount']);
				    						}else{$total_amount=0;}

				    						if($value['total_due_amount'] != ''){
				    						 $total_due_amount=roundInt($value['total_due_amount']);
				    						}else{$total_due_amount=0;}

				    					?>
				    					
			    				<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<a href="<?php echo base_url()?>admin/paymentview/center_payment_details/<?php echo $state_id?>/<?php echo $org_id?>/<?php echo $center_id?>/<?php echo $year?>/<?php echo $value['id']?>">
				    					<div class="edu_color_boxes box_left">
				    						<div class="edu_dash_box_data">
				    						    <p><b><?php echo $year?>-<?php echo $value['month'] ?></b></p>
				    							<h3><b><?php echo $total_amount;?></b></h3>    					
				    						</div>
				    						<div class="edu_dash_box_icon">
												<i class="fa fa-cog" aria-hidden="true"></i>
				    						</div>
				    						<div class="edu_dash_info">
				        					    <ul>
				    					            <li><p><b>Total collected : </b><span><b><?php echo $total_amount;?></b></span></p></li>
				    					            <li><p><b>Due Fees : </b> <span><b><?php echo $total_due_amount;?></b></span></p></li>
				    					        </ul>
				    					    </div>
				    					</div>
			    					</a>
			    				</div>
			    				
			    			<?php }
			    		}else{?>
			    				<center><b>No Months found..!</b></center>

			    		<?php }?>

			    			
				    		</div>				    				
				    	</div>
					        </div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
		
		
		