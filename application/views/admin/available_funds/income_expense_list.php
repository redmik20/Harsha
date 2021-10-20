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
					<li class="active">Available Funds</li>
				</ul><!-- /.breadcrumb -->						
			</div>
			<div class="page-content">						 
				<div class="page-header">
								
					<h1 class="col-lg-6 col-md-3 col-sm-3 col-xs-9  pdg-top-10">
					<i class=" pull-left blue fa fa-dashboard"></i>
						Available Funds
					</h1>
					<div class="pull-right">								
						<a class="btn btn-success btn-sm" href="<?php echo site_url();?>admin/available_funds" type="button">Back </a>
						<!-- <a class="btn btn-warning btn-sm" href="<?php echo site_url();?>#" type="button"><i class="fa fa-bar-chart fa-lg"></i>  </a> -->
						 <input type="hidden" name="hiv" id="hiv" value="0" />
	               </div>
				</div><!-- /.page-header -->
				
				<section class="edu_admin_content">	 
					<div class="sectionHolder edu_admin_right edu_dashboard_wrap">
						<div class="edu_dashboard_widgets">							
				    		<div class="row">
				    			<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<!-- <a href="<?php echo base_url()?>admin/available_funds/payment_modes/<?php echo $attachment_id;?>/transfer_funds"> -->
				    					<div class="edu_color_boxes box_center">
				    						<div class="edu_dash_box_data">
				    				    <p><b>Opening Balance(+)</b></p>
				    					<h3><b>+<?php 
				    					if($opening_blac['opening_balance'] !=0 ){
										$opening_blac=$opening_blac['opening_balance'];
										}else{
										$opening_blac=0;
										}
				    					echo $opening_blac;?>
												    		
												    	</b></h3>
				    						</div>
				    						<div class="edu_dash_box_icon">
				    							<i class="fa fa-money" aria-hidden="true"></i>
				    						</div>
				    						<div class="edu_dash_info">
												<ul>
					<li><p><b>Opening Balance(+) : </b><span><b>+<?php echo $opening_blac;?></b></span></p></li>
												   <!--  <li><p><b>Due Fees : </b> <span><b><?php echo $due_amount;?></b></span></p></li> -->
												</ul>
						    				</div>
				    					</div>
			    					</a>
			    				</div>
			    				<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<a href="<?php echo base_url()?>admin/available_funds/payment_modes/<?php echo $attachment_id;?>/income">
				    					<div class="edu_color_boxes box_left">
				    						<div class="edu_dash_box_data">
				    						    <p><b>Total Credits(+)</b></p>
				    							<h3><b>+
				    					            		<?php if($income['income_amount'] != ''){
										    					 $income_total_amt=$income['income_amount'];
										    					 echo number_format($income_total_amt);
												    		}else{
												    			echo $income_total_amt=0;
												    		}
												    	?></b></h3>    					
				    						</div>
				    						<div class="edu_dash_box_icon">
												<i class="fa fa-money" aria-hidden="true"></i>
				    						</div>
				    						<div class="edu_dash_info">
				        					    <ul>
				    					            <li><p><b>Total Credits (+): </b><span><b>

				    					            	
				    					            		+<?php echo number_format($income_total_amt); ?>
				    					            	</b></span></p></li>
				    					            <!-- <li><p><b>Due Fees : </b> <span><b><?php echo $due_amount;?></b></span></p></li> -->
				    					        </ul>
				    					    </div>
				    					</div>
			    					</a>
			    				</div>

			    				<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<a href="<?php echo base_url()?>admin/available_funds/payment_modes/<?php echo $attachment_id;?>/transfer_funds">
				    					<div class="edu_color_boxes box_center">
				    						<div class="edu_dash_box_data">
				    						    <p><b>To Transfer Funds(+)</b></p>
				    					<h3><b>+<?php if($to_tansfer_funds['transfer_amount'] != ''){
										    					$to_tansfer_funds_amt=$to_tansfer_funds['transfer_amount'];
										    					echo number_format($to_tansfer_funds_amt);
												    		}else{
												    			echo $to_tansfer_funds_amt=0;
												    		}
												    	?>
												    		
												    	</b></h3>
				    						</div>
				    						<div class="edu_dash_box_icon">
				    							<i class="fa fa-money" aria-hidden="true"></i>
				    						</div>
				    						<div class="edu_dash_info">
												<ul>
												    <li><p><b>To Transfer Funds(+) : </b><span><b>+<?php echo number_format($to_tansfer_funds_amt);?></b></span></p></li>
												   <!--  <li><p><b>Due Fees : </b> <span><b><?php echo $due_amount;?></b></span></p></li> -->
												</ul>
						    				</div>
				    					</div>
			    					</a>
			    				</div>
			    				
			    				<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<a href="<?php echo base_url()?>admin/available_funds/payment_modes/<?php echo $attachment_id;?>/expense">
				    					<div class="edu_color_boxes box_center">
				    						<div class="edu_dash_box_data">
				    						    <p><b>Total Debits(-)</b></p>
				    							<h3><b>-<?php if($expense['expense_amount'] != ''){
										    					$expense_total_amt=$expense['expense_amount'];
										    					echo number_format($expense_total_amt);
												    		}else{
												    			echo $expense_total_amt=0;
												    		}
												    	?>
												    		
												    	</b></h3>
				    						</div>
				    						<div class="edu_dash_box_icon">
				    							<i class="fa fa-money" aria-hidden="true"></i>
				    						</div>
				    						<div class="edu_dash_info">
												<ul>
												    <li><p><b>Total Debits(-) : </b><span><b>-<?php echo number_format($expense_total_amt);?></b></span></p></li>
												   <!--  <li><p><b>Due Fees : </b> <span><b><?php echo $due_amount;?></b></span></p></li> -->
												</ul>
						    				</div>
				    					</div>
			    					</a>
			    				</div>

			    				<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<a href="<?php echo base_url()?>admin/available_funds/payment_modes/<?php echo $attachment_id;?>/transfer_funds">
				    					<div class="edu_color_boxes box_center">
				    						<div class="edu_dash_box_data">
				    						    <p><b>From Transfer Funds(-)</b></p>
				    					<h3><b>-<?php if($from_tansfer_funds['transfer_amount'] != ''){
										    					$from_tansfer_funds_amt=$from_tansfer_funds['transfer_amount'];
										    					echo number_format($from_tansfer_funds_amt);
												    		}else{
												    			echo $from_tansfer_funds_amt=0;
												    		}
												    	?>
												    		
												    	</b></h3>
				    						</div>
				    						<div class="edu_dash_box_icon">
				    							<i class="fa fa-money" aria-hidden="true"></i>
				    						</div>
				    						<div class="edu_dash_info">
												<ul>
												    <li><p><b>From Transfer Funds(-) : </b><span><b>-<?php echo number_format($from_tansfer_funds_amt);?></b></span></p></li>
												   <!--  <li><p><b>Due Fees : </b> <span><b><?php echo $due_amount;?></b></span></p></li> -->
												</ul>
						    				</div>
				    					</div>
			    					</a>
			    				</div>

			    				

			    				


			    				<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<!-- <a href="<?php echo base_url()?>admin/paymentview/payment_mode_payments/<?php echo $state_id;?>/<?php echo $org_id;?>/<?php echo $center_id;?>"> -->
			        					<div class="edu_color_boxes box_right">
			        						<div class="edu_dash_box_data">
			        						    <p><b>Closing balance</b></p>
			        							<h3><b><?php  

			        							//$net_amt=$income_total_amt-$expense_total_amt;
			        							
						 	//echo $opening_blac;
						 	//$ex=($expense_total_amt+$tansfer_funds_amt);
						 	$net_amt=$opening_blac+$income_total_amt-$expense_total_amt;
						 	$net_amt1=$net_amt-$from_tansfer_funds_amt+$to_tansfer_funds_amt;
							        							echo number_format($net_amt1);;
			        										
			        										?></b></h3>
			        						</div>
			        						<div class="edu_dash_box_icon">				        							
												<i class="fa fa-cc" aria-hidden="true"></i>
			        						</div>
			        						<div class="edu_dash_info">
												<ul>
						 <li><p><b>Closing balance : </b><span><b>
						 	<?php 
						 	//$opening_blac=$opening_blac['opening_balance'];
						 	//echo $opening_blac;
						 	//$ex=($expense_total_amt+$tansfer_funds_amt);
						 	$net_amt=$opening_blac+$income_total_amt-$expense_total_amt;
						 	$net_amt1=$net_amt-$from_tansfer_funds_amt+$to_tansfer_funds_amt;
						 	echo number_format($net_amt1);?></b></span></p></li>
												   <!--  <li><p><b>Due Fees : </b> <span><b><?php echo $due_amount;?></b></span></p></li> -->
												</ul>
						    				</div>
			        					</div>
			    					<!-- </a> -->
			    				</div>
				    		</div>				    				
				    	</div>
					        </div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div><!-- /.page-content -->
		<!--[if !IE]> -->
		
		
		