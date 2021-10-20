<?php
$url = explode('=', $_SERVER['REQUEST_URI']);
$status = "";
if(isset($url[1]))
{
  $status = $url[1];
}
?>
<div class="loading" id="wait" style="display:none;width:120px;position:absolute; padding:2px;top:40%; z-index:99999999;left:50%;"><img src='<?=base_url();?>assets/images/load.gif' width="80" height="80" /></div>
<div class="my-3 my-md-5">
        <div class="container">
        <div class="row row-cards row-deck my-venues">
<div class="col-lg-12 order-lg-1 mb-4">
<?php if($this->session->flashdata('success') != "") : ?>
              <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span class="sr-only">Close</span></button>
                <?=$this->session->flashdata('success');?>
              </div>
            <?php endif; ?>
               <div class="page-header">
              <h1 class="page-title">
               <?php
               if($status == "pending")
               {
                echo "Online Bookings";
               }
               elseif($status == "offline")
               {
                echo "Offline Bookings";
               }
               elseif($status == "user")
               {
                echo "Bookings Cancelled by user";
               }
               ?>
              </h1>
              </div>
                <!-- <?php $this->load->view('vendor/includes/side_menu'); ?> -->
                <div class="card">
                  <div class="table-responsive data">
                    <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                      <thead>
                        <tr>
                        <!-- <th></th> -->
                        <th>User</th>
                          <th class="text-center w-1"><i class="icon-people"></i></th>
                          <th>Venue</th>
                          <th>Booked On</th>
                          <th class="text-center"><i class="icon-settings"></i></th>
                        </tr>
                      </thead>
                      <tbody id="tbody">

                      <?php 
                      //var_dump($bookings);
                      if(!empty($bookings))
                      {
                        foreach($bookings as $row)
                        {
                          ?>
                          <tr class="tr">
                          <!-- <td class="text-center">
                              <div class="avatar user d-block" style="background-image: url(demo/faces/female/26.jpg)">
                                <span class="avatar-status bg-yellow"></span>
                              </div>
                            </td> -->
                          <td>
                              <div><?=$row['name'];?></div>
                              <div class="small text-muted">
                                <i class="fe fe-phone"></i> +91-<?=$row['mobile'];?>
                              </div>
                            </td>
                            <td class="text-center">
                              <div class="avatar d-block" style="background-image: url(<?=base_url().$row['image'];?>)">
                                <span class="avatar-status bg-yellow"></span>
                              </div>
                            </td>
                            <td>
                              <div><?=$row['venue_name'];?></div>
                              <div class="small text-muted">
                               <strong>Booking Id: </strong><?=$row['booking_id'];?>
                              </div>
                              <div class="small text-muted">
                               <?=$row['address'];?>
                              </div>
                              <div class="small text-muted">
                               <strong>Booked For:</strong> <?=$row['booked_for'];?> 
                               <?php
                               if($row['slot_id'] != 0)
                               {
                                ?>
                               |
                               <strong>Slot Timings:</strong> <?=$row['start_time'];?> - <?=$row['end_time'];?>
                               <?php
                             }
                             ?>
                              </div>
                              <div class="small text-muted">
                               <strong>People Capacity:</strong> <?=$row['people_capacity'];?> |
                               <strong>Booking Type:</strong> <?=ucfirst($row['booking_type']);?>
                               <?php
                               if($row['category_id'] != 7 && $row['category_id'] != 8)
                               {
                                   ?>
                                   | <strong>Booking Capacity:</strong> <?=ucfirst($row['capacity']);?>
                                   <?php
                               }
                               ?>
                              </div>
                            </td>
                            <td>
                              <div class="small text-muted">Date</div>
                              <?=$row['booked_on'];?>
                            </td>
                            <?php
                            if($row['status'] == "pending" || $row['status'] == "accepted" || $row['status'] == "rejected")
                            {
                              ?>
                              <td class="text-center">
                                <div class="item-action dropdown">
                                  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                  <div class="dropdown-menu dropdown-menu-right">
                                    <?php
                                    if($row['status'] == "pending")
                                    {
                                      ?>
                                      <a href="<?=base_url();?>vendor/home/change_status/<?=$status;?>/a/<?=$row['order_id'];?>" class="dropdown-item"><i class="dropdown-icon fe fe-check"></i> Accept </a>
                                      <a href="<?=base_url();?>vendor/home/change_status/<?=$status;?>/r/<?=$row['order_id'];?>" class="dropdown-item"><i class="dropdown-icon fe fe-alert-octagon"></i> Reject </a>
                                      <?php
                                    }
                                    elseif($row['status'] == "accepted" || $row['status'] == "rejected")
                                    {
                                    ?>
                                      <a href="<?=base_url();?>vendor/home/change_status/<?=$status;?>/v/<?=$row['order_id'];?>" class="dropdown-item"><i class="dropdown-icon fe fe-x-circle"></i> Cancel</a>
                                      <?php
                                    }
                                    if($row['category_id'] == 7 || $row['category_id'] == 8)
                                    {
                                      ?>
                                      <a href="javascript:void(0)" class="dropdown-item" data-toggle="modal" data-target="#modal_basic" onclick="fnItems('<?=$row['order_id'];?>');"><i class="dropdown-icon fe fe-more-vertical"></i> View Capacity</a>
                                      <?php
                                    }
                                    ?>
                                  </div>
                                </div>
                              </td>
                              <?php
                            }
                            ?>
                          </tr>
                          <?php
                        }
                      }
                      else
                      {
                        ?>
                        <tr>
                          <td class="text-center" colspan="3">
                          No data available!
                          </td>
                        </tr>
                        <?php
                      }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
             
            </div>
            </div>
        </div>
      </div>

      <div class="modal" id="modal_basic" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
            <!--  <button type="button" class="close" data-dismiss="modal"></button> -->
             <h4 class="modal-title" id="defModalHead">Capacity Details</h4>
           </div>
           <div class="modal-body show_items">
            
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
       </div>
     </div>
    </div>
      <script type="text/javascript">

        $(window).scroll(function() {
          if($(window).scrollTop() + $(window).height() == $(document).height()) {
            var numItems = $('.tr').length;
            $.ajax({
              type:'post',
              url : '<?php echo base_url(); ?>vendor/home/bookings_scroll_data?status=<?=$status;?>',
              data : {numItems:numItems},
              beforeSend: function( xhr ) {
                xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                $("#wait").css("display", "block");
              },
              success : function(data) { //alert(data);
                $("#tbody").append(data);
                $("#wait").css("display", "none");
                return false;
              }
            });
          }
          // if ($(window).scrollTop() == 44) { alert();
          //   var user_id = $('#user_id').val();//alert(user_id);
          //   $('.item-load').show();
          //   var numItems = $('.items').length;//alert(numItems);
          //   $.ajax({
          //     type:'post',
          //     url : '<?php echo base_url(); ?>admin/chat_scroll_data',
          //     data : {user_id:user_id, numItems:numItems},
          //     beforeSend: function( xhr ) {
          //       xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
          //       $("#wait").css("display", "block");
          //     },
          //     success : function(data) { //alert(data);
          //       $(".messages").prepend(data);
          //       $("#wait").css("display", "none");
          //       return false;
          //     }
          //   });
          // }
        });

        function fnItems(order_id)
        { //alert(order_id);
         $.ajax({
           type:'post',
           url : '<?php echo base_url(); ?>vendor/home/get_order_capacity',
           data : {order_id:order_id},
           beforeSend: function( xhr ) {
             xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
             $("#wait").css("display", "block");
           },
             success : function(data) {//alert(data);
             $(".show_items").html(data);
             $("#wait").css("display", "none");
             return false;
             }
           });
        }
      </script>