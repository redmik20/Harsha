<!-- FAQ Starts-->
<section class="sec-space text-center faq light-gray-bg user-panel">
    <div class="container"> 
        <div class="row">
            <?php
            $this->load->view('website/includes/side_menu');
            ?>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <!-- Simple post content example. -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4><a href="#" style="text-decoration:none;"><strong>My Bookings</strong></a></h4> 
                        <hr>
                        <?php if($this->session->flashdata('success') != "") : ?>
                    <div class="alert alert-success" role="alert">
                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                      <?=$this->session->flashdata('success');?>
                    </div>
                  <?php endif; ?>
                        <div class="post-content">
                            <div class="col-sm-12">
                                <div class="all-courses">
                                    <div class="profile__courses__inner">
                                        <table class="profile-table" style="width:100%">
                                            
                                                
            <?php
            if(!empty($orders))
            {
                foreach($orders as $row)
                {
                    ?>
                    <!-- <?=$row['order_id'];?> -->
                    <tr>
                    <td class="bookings-list-img" style="width:150px;"> 
                        <a href="#">
                            <img class="media-object" src="<?=base_url().$row['image'];?>"  style="margin-right:8px; margin-top:-5px;">
                        </a>
                        <i class="fa fa-shopping-cart"></i>
                    </td>
                        <td>
                            <h4 class="pull-left"><a href="#" style="text-decoration:none;"><?=$row['venue_name'];?></a></h4> <h4 class="pull-right"><a href="#" style="text-decoration:none;"><i class="fa fa-inr"></i> <!-- <?php echo $final_amount = $row['price'] * ((100 - $row['discount_percentage']) / 100); ?> --><?=$row['amount_paid'];?>/-</a></h4>
                            <div class="clearfix"></div>
                                <p>
                                    <strong>Booking Id:</strong> <?=$row['booking_id'];?><br>
                                    <strong>Booking Date:</strong> <?=$row['booked_on'];?><br>
                                    <strong>Slot Booking Date:</strong> <?=$row['booked_for'];?> 
                                    <?php
                                   if($row['slot_id'] != 0)
                                   {
                                    ?>
                                    (<?=$row['start_time'];?> - <?=$row['end_time'];?>)
                                    <?php
                                    }
                                    ?>
                                    <br>
                                    <strong>Total Capacity:</strong> <?=$row['people_capacity'];?><br>
                                    <strong>Category:</strong> <?=$row['category'];?><br>
                                    <strong>Status:</strong> <?=ucfirst($row['status']);?><br>
                                    <?php
                                    if($row['payment_mode'] != "cash" && $row['payment_status'] == "pending" && ($row['category_id'] != 6 && $row['category_id'] != 5))
                                    {
                                        ?>
                                        <strong>Payment Status:</strong> <?=ucfirst($row['payment_status']);?><br>
                                        <?php
                                    }
                                    elseif($row['category_id'] == 6 || $row['category_id'] == 5)
                                    {
                                        ?>
                                        <strong>Booked Capacity:</strong> <?=$row['capacity'];?><br>
                                        <strong>Payment Status:</strong> Payment not required<br>
                                        <?php
                                    }
                                    elseif($row['payment_mode'] == "card")
                                    {
                                      ?>
                                        <strong>Payment Status:</strong> Paid Online<br>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <strong>Payment Status:</strong> Pay at Venue<br>
                                        <?php
                                    }
                                    ?>

                                    <strong>Booking Type:</strong> <?=ucfirst($row['booking_type']);?>
                                </p>
                                <div class="services pull-left">
                                    <ul>
                                        <li>
                                            <span> <?=ucfirst($row['status']);?> </span>
                                        </li>
                                        <?php
                                        //echo $row['payment_mode'];
                                        if(($row['payment_mode'] != "cash" && $row['payment_status'] == "pending" && ($row['category_id'] != 6 && $row['category_id'] != 5)) && ($row['booking_type'] == "delayed") && $row['status'] == "accepted")
                                        {
                                            ?>
                                        <li>
                                            <!-- <a href="<?=base_url();?>home/payu/<?=$row['venue_id'];?>/<?=$row['order_id'];?>" class="pay_now"><span>Pay Now</span></a> -->

                                            <a href="javascript:void(0)" class="pay_now" id="btAnimate" onclick="payment_mode('<?=$row['order_id'];?>', '<?=$row['venue_id'];?>')"><span>Pay Now</span></a>

                                        </li>
                                        
                                        <?php
                                        }
                                        elseif($row['payment_mode'] != "cash" && $row['payment_status'] == "pending" && $row['status'] == "pending" && $row['booking_type'] == "instant")
                                        {
                                            ?>
                                        <li>
                                            <!-- <a href="<?=base_url();?>home/payu/<?=$row['venue_id'];?>/<?=$row['order_id'];?>" class="pay_now"><span>Pay Now</span></a> -->

                                            <a href="javascript:void(0)" class="pay_now" id="btAnimate" onclick="payment_mode('<?=$row['order_id'];?>', '<?=$row['venue_id'];?>')"><span>Pay Now</span></a>

                                        </li>
                                        
                                        <?php
                                        }
                                        ?>
                                        
                                        <?php
                                        $order_id = $row['order_id'];
                                        $booked_for_date = $row['booked_for_date'];
                                        $created_on = $row['created_on'];

                                        if($row['status'] != "cancelled by vendor" && $row['status'] != "cancelled by user")
                                        {
                                        ?>
                                        <li>
                                            <a href="javascript:void(0)" onclick="user_cancel_booking('<?=$order_id;?>', '<?=$booked_for_date;?>', '<?=$created_on;?>')"><span> Cancel</span></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="get_cancellation_policy('<?=$row['category_id'];?>', '<?=$row['vendor_id'];?>')"><span> Cancellation Policy </span></a>
                                        </li>
                                            <?php
                                        }
                                        ?>                                        
                                        <div class="clearfix"></div>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <tr>
                        <td>No data available!</td>
                    </tr>    
                    <?php
                }
                ?>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</article>
<!-- Cancellation Policy popup -->
  <div class="modal fade" id="cancellation_policy_popup" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cancellation Policy</h4>
        </div>
        <div class="modal-body" id="cancel_data">
          <table class="table">
              <tr>
              <th>From</th>
              <th>To</th>
              <th>Cancellation Allowed</th>
              <th>Refund</th>
              </tr>
              <tr>
              <td colspan="4">No data found</td>              
              </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Payment Confirmation popup -->
  <div class="modal fade ajsrConfirm pill" id="payment_confirm" role="dialog" style="position: fixed; z-index: 10001; pill  ">
    <div class="title">Payment Mode!</div>
    <div class="content"><p>Please select a payment mode!</p></div>
    <div class="col-lg-12">
                <div class="text-center cash-radio row">
              <label class="">Pay at Venue
                <input type="radio" name="payment_type" value="cash" class="payment_type" id="pay_at_venue">
                <span class="checkmark"></span>
              </label>
              <label class="">Pay Online
                <input type="radio" name="payment_type" value="card" class="payment_type" id="pay_online"/>
                <span class="checkmark"/></span>
                <input type="hidden" name="order_id" id="order_id" value="">
                <input type="hidden" name="venue_id" id="venue_id" value="">
              </label>
            </div>
            </div>
            <br>  <br>
    <div class="footer">
    <button id="btn-cancel" class="btn cancel" type="button" data-dismiss="modal">Cancel</button>
    <!-- <button id="btn-ok" class="btn confirm default" type="button">OK</button> -->
    </div>
  </div>

  <!-- <div id="ajsrConfirm-1546072760429" class="ajsrConfirm pill " style="position: fixed; z-index: 10001; pill  "><div class="title">Attention!</div><div class="content"><p>Do you really want to do that?</p></div><div class="footer"><button id="btn-cancel" class="btn cancel" type="button">Cancel</button><button id="btn-ok" class="btn confirm default" type="button">OK</button></div></div> -->
<script type="text/javascript">
    function user_cancel_booking(order_id, booked_for, created_on)
    {
      //alert(created_on);
      $.ajax( {
          type: 'POST',
          url: "<?=base_url();?>home/user_cancel_booking",
          data: {order_id:order_id, booked_for:booked_for, created_on:created_on},
          beforeSend: function( xhr ) {
              xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
              $("#wait").css("display", "block");
          },
          success: function(data) { //alert(data);exit;
              alert(data);      
              $("#wait").css("display", "none");
              location.reload();
              return false;
          }
      }); 
    }

    function payment_mode(order_id, venue_id)
    {
        //alert(order_id);
        $('#order_id').val(order_id);
        $('#venue_id').val(venue_id);
        $('#payment_confirm').modal('show');        
    }

    $('.payment_type').click(function()
    {
        $("#wait").css("display", "block");
        var order_id = $('#order_id').val();
        var venue_id = $('#venue_id').val();
        var payment_mode = $(this).attr("value");
        if(payment_mode == "card")
        {      
            //alert(payment_mode);      
            location.href='<?=base_url();?>home/payu/'+venue_id+'/'+order_id+'/card';
        }
        else if(payment_mode == "cash")
        {
            location.href='<?=base_url();?>home/payu/'+venue_id+'/'+order_id+'/cash';
        }      
    });

    function get_cancellation_policy(category_id, vendor_id)
    {
        //alert(category_id);
        $('#cancellation_policy_popup').modal('show');
        $.ajax( {
            type: 'POST',
            url: "<?=base_url();?>home/cancellation_policy",
            data: {category_id:category_id, vendor_id:vendor_id},
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                $("#wait").css("display", "block");
            },
            success: function(data) { //alert(data);exit;
                $('#cancel_data').html(data);
                $("#wait").css("display", "none");
                return false;
            }
        });
    }
</script>

<style>
        /* css */
/* line 5, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm-back-bg.pill {
  background-color: #353535 !important;
  opacity: 0.5 !important;
}

/* line 15, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}
/* line 17, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill {
  background-color: #7a329d;
  border-radius: 0;
  padding: 6px;
  width: 380px;
  height: 210px;
  left: calc(50% - 200px);
  top: calc(50% - 200px);
  border: 2px solid white;
  border-radius: 1000px;
  background-image: linear-gradient(to bottom, #7a329d 0%, #fcb100 100%);
}
/* line 35, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .layer-1 {
  position: absolute;
  width: 16px;
  height: 16px;
  top: 0px;
  left: 0px;
}
/* line 40, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .layer-2 {
  position: absolute;
  width: 16px;
  height: 16px;
  top: 0px;
  right: 0px;
}
/* line 45, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .layer-3 {
  position: absolute;
  width: 16px;
  height: 16px;
  bottom: 0px;
  right: 0px;
}
/* line 50, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .layer-4 {
  position: absolute;
  width: 16px;
  height: 16px;
  bottom: 0px;
  left: 0px;
}
/* line 55, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .title {
  padding: 8px 14px;
  margin: 0;
  font-size: 18px;
  font-weight: 400;
  line-height: 18px;
  background-color: #f7d56f;
  border-bottom: 1px solid #ebebeb;
  border-radius: 0;
  padding: 15px;
  border-bottom: 1px solid #176ee4;
  border-top: 1px solid #5f0000;
  border-right: 1px solid #680075;
  border-left: 1px solid #11001f;
  line-height: 14px;
  font-weight: 500;
  text-shadow: 0 1px white;
  color: #900505;
  border: 0;
  border-radius: 26px 26px 0 0;
  color: #ffc519;
  text-align: center;
  font-weight: 200;
  text-shadow: 0 1px 1px #000000;
  background-color: transparent;
  background-size: 100%;
  background-image: unset;
  border: 0;
}
/* line 84, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .content {
  padding: 0px;
  height: 55px;
  color: #ffffff;
  text-shadow: 0 0px 5px #120054;
  font-weight: 300;
  font-size: 24px;
  text-align: center;
  line-height: 52px;
  background-color: transparent;
  background-image: unset;
  font-size: 26px;
}
/* line 97, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .footer {
  padding: 3px;
  text-align: right;
  border-top: 1px solid #e5e5e5;
  background-color: #f6f6f6;
  border-radius: 0;
  bottom: 10px;
  position: relative;
  background-color: #f0f0f0;
  padding: 13px;
  border-radius: 0;
  bottom: 0px;
  position: relative;
  background-color: #f0f0f0;
  padding: 0 10px 0 0;
  height: 48px;
  border: 1px solid #3e0080;
  border-bottom: 1px solid #e7ae00;
  border-radius: 0 0 26px 26px;
  background-color: transparent;
  border-bottom: 1px solid #000000;
  text-align: center;
  background-image: linear-gradient(to bottom, #5533bd 0%, #170844 100%);
  background-color: transparent;
  background-image: unset;
  border: 0;
}
/* line 124, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .btn {
  font-size: 14px;
  font-weight: 400;
  line-height: 1.42857143;
  text-align: center;
  padding: 4px 10px;
  border-radius: 100px;
  margin-top: 7px;
  padding: 4px 30px;
  background-color: #0a74a1;
  border: 2px solid white;
  margin-left: 15px;
  text-shadow: 0 1px 0 black;
  color: white;
}
/* line 143, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .btn.cancel {
  background-color: #0a74a1;
  border: 2px solid white;
  margin-left: 15px;
  text-shadow: 0 1px 0 black;
  color: white;
  /*
  background-color: #b8e1fc; // Old browsers
  @include filter-gradient(#b8e1fc,
  #bdf3fd,
  vertical); // IE6-9
  @include background-image(linear-gradient(top,
  #FFC107 0%,
  #FF9800 10%,
  #FF5722 25%,
  #F44336 37%,
  #E91E63 50%,
  #FF9800 51%,
  #FF5722 83%,
  #F44336 100%));
  */
  background-image: linear-gradient(to bottom, #ff5722 0%, #9c27b0 100%);
}
/* line 172, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .btn.cancel:hover {
  background-color: black;
  box-shadow: 0 0 13px red;
}
/* line 178, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .btn.cancel.default {
  box-shadow: 0 3px 9px black;
}
/* line 184, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .btn.confirm {
  background-color: #00a800;
  border: 2px solid white;
  margin-left: 15px;
  text-shadow: 0 1px 0 black;
  color: white;
  background-color: #bfd255;
  *zoom: 1;
  filter: progid:DXImageTransform.Microsoft.gradient(gradientType=0, startColorstr='#FFBFD255', endColorstr='#FF9ECB2D');
  background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2JmZDI1NSIvPjxzdG9wIG9mZnNldD0iNTAlIiBzdG9wLWNvbG9yPSIjOGViOTJhIi8+PHN0b3Agb2Zmc2V0PSI1MSUiIHN0b3AtY29sb3I9IiM3MmFhMDAiLz48c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiM5ZWNiMmQiLz48L2xpbmVhckdyYWRpZW50PjwvZGVmcz48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyYWQpIiAvPjwvc3ZnPiA=');
  background-size: 100%;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #bfd255), color-stop(50%, #8eb92a), color-stop(51%, #72aa00), color-stop(100%, #9ecb2d));
  background-image: -moz-linear-gradient(top, #bfd255 0%, #8eb92a 50%, #72aa00 51%, #9ecb2d 100%);
  background-image: -webkit-linear-gradient(top, #bfd255 0%, #8eb92a 50%, #72aa00 51%, #9ecb2d 100%);
  background-image: linear-gradient(to bottom, #bfd255 0%, #8eb92a 50%, #72aa00 51%, #9ecb2d 100%);
}
/* line 203, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .btn.confirm:hover {
  background-color: black;
  box-shadow: 0 0 13px #1bff00;
}
/* line 209, ../compass/sass/tmplt-pill.scss */
.ajsrConfirm.pill .btn.confirm.default {
  box-shadow: 0 3px 9px black;
}
    </style>
