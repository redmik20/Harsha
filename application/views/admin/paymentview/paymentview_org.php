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
					<li class="active">List Organisations</li>
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
					<h1  class="col-lg-6 col-md-3 col-sm-3 col-xs-9  pdg-top-10">
					<i class=" pull-left blue fa fa-dashboard"></i>
						List Organisations ---> <b style="text-align:center;color:red"><?php echo $state['state'];?></b>
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
		                      <?php if(!empty($organisations)){
		                      foreach($organisations as $org){ ?>
		                      <div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
		                        <a href="<?php echo base_url();?>admin/paymentview/org_center/<?php echo $org['state_id']?>/<?php echo $org['id']?>">
		                          <div class="edu_color_boxes box_other">
		                            <div class="edu_dash_box_data">
		                                <p><b><?php echo $org['organisation_name']; ?></b></p>
		                              <h3><b><?php if($org['total_amount'] != ''){
										    			echo roundInt($org['total_amount']);
										    		}else{
										    			echo 0;
										    		}
										    	?></b></h3>
		                            </div>
		                            <div class="edu_dash_box_icon">
		                              <i class="fa fa-university" aria-hidden="true"></i>
		                            </div>
		                            <div class="edu_dash_info">
										<ul>
										    <li><p><b>Total collected : </b><span><b>

										    	<?php if($org['total_amount'] != ''){
										    			echo roundInt($org['total_amount']);
										    		}else{
										    			echo 0;
										    		}
										    	?>
										    		
										    	</b></span></p></li>
										    <li><p><b>Due Fees : </b> <span><b>
										    	<?php if($org['total_due_amount'] != ''){
										    			echo roundInt($org['total_due_amount']);
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
		                      <?php } 
		                  }else{?>
			    				<center><b>No Organisations found..!</b></center>

			    		<?php }?>

		                       <!-- <div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
		                        <a href="<?php echo base_url('admin/paymentview/org_center');?>">
		                          <div class="edu_color_boxes box_other">
		                            <div class="edu_dash_box_data">
		                                <p><b>DBMCI</b></p>
		                              <h3><b>13</b></h3>
		                            </div>
		                            <div class="edu_dash_box_icon">
		                              <i class="fa fa-university" aria-hidden="true"></i>
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
		                    </div><br><br>
				    						    				
				    	</div>
					        </div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div><!-- /.page-content -->
		<!--[if !IE]> -->
		
		
		