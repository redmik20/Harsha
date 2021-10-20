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
					<li class="active">Attachments</li>
				</ul><!-- /.breadcrumb -->						
			</div>
			<div class="page-content">						 
				<div class="page-header">
								
					<h1 class="col-lg-6 col-md-3 col-sm-3 col-xs-9  pdg-top-10">
					<i class=" pull-left blue fa fa-dashboard"></i>
						Attachments  
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
				    			<?php foreach($attachments as $value){ 

				    				if($value['total_amount'] != ''){
				    						 $total_amount=$value['total_amount'];
				    						}else{$total_amount=0;}

				    						if($value['expense_amount'] != ''){
				    						 $expense_amount=$value['expense_amount'];
				    						}else{$expense_amount=0;}

				    				?>
			    				<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<a href="<?php echo base_url()?>admin/available_funds/income_expense_details/<?php echo $value['id']?>">
				    					<div class="edu_color_boxes box_left">
				    						<div class="edu_dash_box_data">
				    						    <p><b><?php echo $value['attachment_name']; ?></b></p>
				    							<h3><b><?php 
				    							//if($value['opening_balance'] != 0){
				    								
				    								//opening_balance+income-allexpenses-transferfunds=closing_balnce;
				    								$attch_id=$value['id'];
	$from_transfer_funds="select sum(transfer_amount) as transfer_amount from tbl_transfer_funds where from_attachment_id='$attch_id' ";
	//echo $transfer_funds;exit;
	$fnl_from_transfer_funds=$this->db->query($from_transfer_funds)->row_array();
	//echo '<pre>';print_r($fnl_transfer_funds);
	$fl_from_transfer_amount=$fnl_from_transfer_funds['transfer_amount'];

	$to_transfer_funds="select sum(transfer_amount) as transfer_amount from tbl_transfer_funds where to_attachment_id='$attch_id' ";
	//echo $transfer_funds;exit;
	$fnl_to_transfer_funds=$this->db->query($to_transfer_funds)->row_array();
	//echo '<pre>';print_r($fnl_transfer_funds);
	$fl_to_transfer_amount=$fnl_to_transfer_funds['transfer_amount'];

				   if($value['opening_balance'] !=0){ 
				   	$opening_balance=$value['opening_balance']; 
				    }else{
				    $opening_balance=0; 	
				    }		
				 $final_opening_bal1=$opening_balance+$total_amount-$expense_amount-$fl_from_transfer_amount+$fl_to_transfer_amount;
				    								//$final_opening_bal1=$final_opening_bal+$total_amount;


				    								/*}else{
				    									$final_opening_bal1=0;
				    								}*/
				    							    echo number_format($final_opening_bal1);
				    							    ?></b></h3>    					
				    						</div>
				    						<div class="edu_dash_box_icon">
												<i class="fa fa-cog" aria-hidden="true"></i>
				    						</div>
				    						<div class="edu_dash_info">
				        					    <ul>
				    					            <li><p><b style="color:green">Total Income(+) : </b><span>
				    					            	<b style="color:green">
															<?php echo number_format($total_amount);?>
				    					            		
				    					            	</b></span></p></li>

				    					            	<li><p><b style="color:red">Total Expense(-) : </b><span>
				    					            		
				    					            	<b style="color:red">

				    					            	<?php echo number_format($expense_amount);?>
				    					            		
				    					            	</b></span></p></li>
				    					            
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
		
		
		