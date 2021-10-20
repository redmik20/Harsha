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
					<li class="active">Attachment Groups</li>
				</ul><!-- /.breadcrumb -->						
			</div>
			<div class="page-content">						 
				<div class="page-header">
								
					<h1 class="col-lg-6 col-md-3 col-sm-3 col-xs-9  pdg-top-10">
					<i class=" pull-left blue fa fa-dashboard"></i>
						Attachment Groups  
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
				    			<?php foreach($attachment_groups as $value){ 
				    				$id=$value['id'];
		$att_groups=$this->db->query("select attachment_ids from tbl_attachment_groups where id='".$id."' ")->row_array();
        $attachment_ids=explode(',',$att_groups['attachment_ids']);

        $attachment_idsClause = "'" . implode("','",$attachment_ids) . "'";

	   $query="SELECT tbl_attachments.id,tbl_attachments.attachment_name,(select COALESCE(SUM(amount_paid),0) FROM `tbl_student_payment_details` WHERE tbl_student_payment_details.attachment_id=tbl_attachments.id and tbl_student_payment_details.approval_status='Approved') as total_amount FROM tbl_attachments WHERE tbl_attachments.id IN ($attachment_idsClause) AND tbl_attachments.status='Active' ";

				$incomes=$this->db->query($query)->result_array();
				//echo '<pre>';print_r($incomes);exit;
				$income_total=0;
				foreach($incomes as $income){
					$income_total += $income['total_amount'];
				}


				$query2="SELECT tbl_attachments.id,tbl_attachments.attachment_name,(select  COALESCE(SUM(amount),0) FROM `tbl_expenses` WHERE tbl_expenses.attachment_id=tbl_attachments.id and tbl_expenses.approval_status='Approved') as expense_amount FROM tbl_attachments WHERE tbl_attachments.id IN ($attachment_idsClause) AND tbl_attachments.status='Active' ";

				$expenes=$this->db->query($query2)->result_array();
//echo '<pre>';print_r($expenes);exit;

				$expense_total=0;
				foreach($expenes as $expene){
					$expense_total += $expene['expense_amount'];
				}
				    				?>
			    				<div class="col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
			    					<a href="<?php echo base_url()?>admin/available_funds/attachments/<?php echo $value['id']?>">
				    					<div class="edu_color_boxes box_left">
				    						<div class="edu_dash_box_data">
				    						    <p><b><?php echo $value['attachment_group_name']; ?></b></p>
				    							<h3><b><?php //echo $income_total;?> </b></h3>    					
				    						</div>
				    						<div class="edu_dash_box_icon">
												<i class="fa fa-cog" aria-hidden="true"></i>
				    						</div>
				    						<div class="edu_dash_info">
				        					    <!-- <ul>
				    					            <li><p><b style="color:green">Total Income(+) : </b><span>
				    					            	<b style="color:green">
															<?php echo $income_total;?>;
				    					            		
				    					            	</b></span></p></li>

				    					            	<li><p><b style="color:red">Total Expense(-) : </b><span>
				    					            		
				    					            	<b style="color:red">

				    					            	<?php echo $expense_total;?>
				    					            		
				    					            	</b></span></p></li>
				    					            
				    					        </ul> -->
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
		
		
		