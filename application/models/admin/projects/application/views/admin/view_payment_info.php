<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li class="active">Order Details</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_services', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Payment Details</h2>
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <div class="panel-body">  

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Receipt ID:: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['receipt_id'];?></div>
            </div>

            
            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">User Name:  </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['user_name'];?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">User Mobile: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['user_mobile'];?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Package Name: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['package_name'];?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Valid Months: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['valid_months'];?> months</div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Valid From: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['valid_from'];?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Valid To: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['valid_to'];?></div>
            </div>
            
            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Coupon applied: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['coupon_applied'];?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Final paid amount: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['final_paid_amount'];?>.00 /-</div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Coupon name: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['coupon_name'];?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Coupon discount: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['coupon_discount'];?> %</div>
            </div>


            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Razorpay order Id: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['razorpay_order_id'];?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Razorpay payment Id: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['razorpay_payment_id'];?></div>
            </div>
            
            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Payment Status: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['payment_status'];?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Payment messsage: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['payment_msg'];?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Order created on: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['created_on'];?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Payment created on: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php echo $payment_info['payment_created_on'];?></div>
            </div>





          </div>
          <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/payments" class="btn btn-primary pull-right" style="margin-left:10px;">Back</a>    
            
          </div> 
        </div>
      </form>

    </div>
  </div>
</div>
<style type="text/css">
  .margintop7
  {
    margin-top: 7px;
  }
</style>

<script type="text/javascript">
  function get_temporary_slots(temp_date, venue_id)
  {//alert(temp_date);exit;
    $.ajax({
      type:'post',
      url : '<?php echo base_url(); ?>admin/register/get_temporary_slots',
      data : {venue_id:venue_id, temp_date:temp_date},
      beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
        $("#wait").css("display", "block");
      },
        success : function(data) {//alert(data);
        $("#show_temp_slots").html(data);
        $("#wait").css("display", "none");
        return false;
        }
      });         
  }
</script>