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
            <h2 class="panel-title">Order Details</h2>
          </div>
          <?php if($this->session->flashdata('success') != "") : ?>                
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <?=$this->session->flashdata('success');?>
            </div>
          <?php endif; ?>
          <div class="panel-body">  

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Booking Id: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->booking_id;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">User Name: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->user_name;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">User Mobile: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->user_mobile;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">User Email Id: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->user_email_id;?></div>
            </div>


            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Slot Start and End Time: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=date('h:i A', strtotime($order_details->start_time));?> & <?=date('h:i A', strtotime($order_details->end_time));?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Total Capacity: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->total_capacity;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Capacity Booked: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->capacity;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Amount Paid: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->amount_paid;?></div>
            </div>


            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Booked for Date: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=date('d F Y', strtotime($order_details->booked_for));?></div>
            </div>
            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Menu: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->menu;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Payment Status: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->payment_status;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Overall Status (User/Vendor): </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->status;?></div>
            </div>            


            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">order Placed On: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?php if($order_details->created_on){ echo date('d F Y h:i A', strtotime($order_details->created_on)); } ?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Vendor Name: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->name;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Vendor Mobile: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->mobile;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Vendor Email Id: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->email_id;?></div>
            </div>          

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">City Name: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->city_name;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Area Name: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->area_name;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Category Name: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->category_name;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Venue Name: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->venue_name;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Event Types: </label>
              <div class="col-md-6 col-xs-12 margintop7"><?=$order_details->event_types;?></div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Address: </label>
              <div class="col-md-6 col-xs-12 margintop7">  
              <?=$order_details->address;?>              
              </div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">People Capacity: </label>
              <div class="col-md-6 col-xs-12 margintop7">  
              <?=$order_details->people_capacity;?>              
              </div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Price: </label>
              <div class="col-md-6 col-xs-12 margintop7">  
              <?=$order_details->price;?>              
              </div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Description: </label>
              <div class="col-md-6 col-xs-12 margintop7">  
              <?=$order_details->description;?>              
              </div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Amenities: </label>
              <div class="col-md-6 col-xs-12 margintop7">  
              <?=$order_details->amenities;?>              
              </div>
            </div>

          


            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Venue Type: </label>
              <div class="col-md-6 col-xs-12 margintop7">  
              <?=$order_details->venue_type;?>              
              </div>
            </div>

        

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Contact Number: </label>
              <div class="col-md-6 col-xs-12 margintop7">  
              <?=$order_details->contact_number;?>              
              </div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Email Id: </label>
              <div class="col-md-6 col-xs-12 margintop7">  
              <?=$order_details->email_id;?>              
              </div>
            </div>

            <div class="form-group">
              <label for="title" class="col-md-3 col-xs-12 control-label">Image: </label>
              <div class="col-md-6 col-xs-12 margintop7">
              <img src="<?=base_url().$order_details->image;?>" height="80" width="80" />            
              </div>
            </div>
            

          </div>
          <!-- <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/venues" class="btn btn-primary pull-right" style="margin-left:10px;">Cancel</a>    
            <button type="submit" class="btn btn-primary pull-right" id="btnSubmit">Submit</button>
          </div> -->
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