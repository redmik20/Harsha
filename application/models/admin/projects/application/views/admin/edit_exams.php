<!-- START BREADCRUMB -->
<ul class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">exams</a></li>
  <li class="active">Edit exams</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php 
      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');
      echo form_open_multipart('admin/register/update_exams', $attributes); 
      ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Edit Courses</h3>            
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
                  
          <div class="panel-body">           

            <div class="form-group">
              <label for="name" class="col-md-3 col-xs-12 control-label">Enter name</label>
              <div class="col-md-6 col-xs-12">                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="text" class="form-control" name="name" id="name" value="<?=$row->name;?>" />
              </div>
            </div>

            <!--<div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Free/Paid</label>
              <div class="col-md-6 col-xs-12">
                <select class="form-control" name="payment_type" id="payment_type" required="">
                  <option value="">Select type</option>
                  <option value="free" <?php if($row->payment_type == 'free'){ echo "selected";}?>>Free</option> 
                  <option value="paid" <?php if($row->payment_type == 'paid'){ echo "selected";}?>>paid</option>
                   </select>
              </div>
            </div>-->

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Price</label>
              <div class="col-md-6 col-xs-12">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="number" class="form-control" name="price" id="price" required="" value="<?=$row->price;?>"/>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Discount Price</label>
              <div class="col-md-6 col-xs-12">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="number" class="form-control" name="discount_price" id="discount_price" required="" value="<?=$row->discount_price;?>" />
              </div>
            </div>

            <div class="form-group">
              <label for="image" class="col-md-3 col-xs-12 control-label">Upload Image</label>
              <div class="col-md-6 col-xs-12">
                <div class="">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" name="image" id="image" value="<?=$row->image;?>"/>
                </div>
              </div>
             <?php
            /* if($row->image !='' ){ ?>
              
              <img src="<?=base_url().$row->image;?>" height="50" width="50">
              <?php }else{?>
              <img src="<?=base_url().'storage/no_image.jpg';?>" height="50" width="50">
              <?php }*/ ?>
            </div>

            <div class="form-group">
              <label class="col-md-3 col-xs-12 control-label">Order</label>
              <div class="col-md-6 col-xs-12">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="number" class="form-control" name="order" id="order" required="" value="<?=$row->order;?>"/>
              </div>
            </div>

          <input type="hidden" name="exam_id" value="<?=$row->id;?>">
          <!-- <input type="hidden" name="imgurl" value="<?=$row->image;?>"> -->
              
          <div class="panel-footer">
            <!-- <button class="btn btn-default">Clear Form</button> -->
            <a href="<?=base_url();?>admin/register/exams" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>            
            <button type="submit" class="btn btn-primary pull-right">Submit</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- END PAGE CONTENT WRAPPER -->
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-validate-additional-methods.js"></script>
<script>
  $(document).ready(function() { //alert();
      $("#validation").validate({
           rules: {
            // simple rule, converted to {required:true}            
            name: {
                required : true,
            }
          },
          submitHandler: function(form) {
              $("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
      
  }); 
</script>
