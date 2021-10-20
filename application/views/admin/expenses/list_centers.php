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
					<li class="active">Centers</li>
				</ul><!-- /.breadcrumb -->						
			</div>
			<div class="page-content">						 
				<div class="page-header">
									
					<h1 class="col-lg-6 col-md-3 col-sm-3 col-xs-9  pdg-top-10">
					<i class=" pull-left blue fa fa-dashboard"></i>
						Centers  
					</h1>
					<div class="pull-right "> 
          <a href="<?php echo base_url();?>admin/expenses/list_org/<?php echo $state_id?>" class="btn btn-danger btn-sm" type="button"><i class="fa  fa-arrow-left fa-lg"></i> Back</a>                          
          <input type="hidden" name="hiv" id="hiv" value="0"/>
       </div>
				</div><!-- /.page-header -->
				
				<section class="edu_admin_content">	 
					<div class="sectionHolder edu_admin_right edu_dashboard_wrap">
						<div class="edu_dashboard_widgets">							
				    		<div class="row">
				    			<?php foreach($centers as $center){ ?>
			    				<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<a href="<?php echo base_url()?>admin/expenses/expenses_list/<?php echo $state_id?>/<?php echo $org_id?>/<?php echo $center['id']?>">
				    					<div class="edu_color_boxes box_left">
				    						<div class="edu_dash_box_data">
				    						    <p><b><?php echo $center['center']; ?></b></p>
				    							   <h3><b><?php if($center['total_amount'] != ''){
										    			echo $center['total_amount'];
										    		}else{
										    			echo 0;
										    		}
										    	?>	</b></h3>	
				    						</div>
				    						<div class="edu_dash_box_icon">
												<i class="fa fa-cog" aria-hidden="true"></i>
				    						</div>
				    						<div class="edu_dash_info">
				        					    <ul>
				    					            <li><p><b>Total Expenses : </b><span><b>

				    					            	
														<?php if($center['total_amount'] != ''){
										    			echo $center['total_amount'];
										    		}else{
										    			echo 0;
										    		}
										    	?>	
				    					            	
				    					            		
				    					            	</b></span></p></li>
				    					            <!-- <li><p><b>Due Fees : </b> <span><b>

				    					            	
						    					           
				    					            		
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
		
		
		