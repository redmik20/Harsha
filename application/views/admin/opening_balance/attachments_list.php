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
					<li class="active">Opening Balance</li>
				</ul><!-- /.breadcrumb -->						
			</div>
			<div class="page-content">						 
				<div class="page-header">
								
					<h1 class="col-lg-6 col-md-3 col-sm-3 col-xs-9  pdg-top-10">
					<i class=" pull-left blue fa fa-dashboard"></i>
						Opening Balance  
					</h1>
					<div class="pull-right">								
						<a class="btn btn-success btn-sm" href="<?php echo site_url();?>admin/opening_balance" type="button">Back </a>
						<!-- <a class="btn btn-warning btn-sm" href="<?php echo site_url();?>#" type="button"><i class="fa fa-bar-chart fa-lg"></i>  </a> -->
						 <input type="hidden" name="hiv" id="hiv" value="0" />
	               </div>
				</div><!-- /.page-header -->
				
				<section class="edu_admin_content">	 
					<div class="sectionHolder edu_admin_right edu_dashboard_wrap">
						<div class="edu_dashboard_widgets">							
				    		<div class="row">
				    			<?php foreach($attachments as $value){ 

				    				if($value['income_amount'] != ''){
				    						 $income_amount=$value['income_amount'];
				    						}else{$income_amount=0;}

				    						if($value['expense_amount'] != ''){
				    						 $expense_amount=$value['expense_amount'];
				    						}else{$expense_amount=0;}

				    				?>
			    				<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<a href="<?php echo base_url()?>admin/opening_balance?>">
				    					<div class="edu_color_boxes box_left">
				    						<div class="edu_dash_box_data">
				    						    <p><b><?php echo $value['attachment_name']; ?></b></p>
				    							<h3><b>
				    								<?php 
				    								//$net_amount=$income_amount-$expense_amount;
				    								
				    								if($value['opening_balance'] != 0){
				    								$final_opening_bal=$value['opening_balance']-$expense_amount;
				    								$final_opening_bal1=$final_opening_bal+$income_amount;
				    								}else{
				    									$final_opening_bal1=0;
				    								}
				    							    echo number_format($final_opening_bal1);
				    							?>
				    								
				    							</b></h3>    					
				    						</div>
				    						<div class="edu_dash_box_icon">
												<i class="fa fa-cog" aria-hidden="true"></i>
				    						</div>
				    						<div class="edu_dash_info">
				        					    <ul>
				    					            <!-- <li><p><b style="color:green">Total Income(+) : </b><span>
				    					            	<b style="color:green">
															<?php //echo number_format($total_amount);?>
				    					            		
				    					            	</b></span></p></li>

				    					            	<li><p><b style="color:red">Total Expense(-) : </b><span>
				    					            		
				    					            	<b style="color:red">

				    					            	<?php //echo number_format($expense_amount);?>
				    					            		
				    					            	</b></span></p></li> -->
				    					            
				    					        </ul>
				    					    </div>
				    					</div>
			    					</a>
			    				</div>
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
		
		
		