<!-- <?php
$url = explode('=', $_SERVER['REQUEST_URI']);
$status = "";
if(isset($url[1]))
{
  $status = $url[1];
}
?> -->
<div class="loading" id="wait" style="display:none;width:120px;position:absolute; padding:2px;top:40%; z-index:99999999;left:50%;"><img src='<?=base_url();?>assets/images/load.gif' width="80" height="80" /></div>
<div class="my-3 my-md-5">
        <div class="container">
        <div class="row row-cards row-deck my-venues">
<div class="col-lg-12 order-lg-1 mb-4">
               <div class="page-header">
              <h1 class="page-title">
               Wishlist
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
                          <th>Shortlisted Date</th>
                          <!-- <th class="text-center"><i class="icon-settings"></i></th> -->
                        </tr>
                      </thead>
                      <tbody id="tbody">

                      <?php 
                      //var_dump($wishlist);
                      if(!empty($wishlist))
                      {
                        foreach($wishlist as $row)
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
                               <?=$row['address'];?>
                              </div>
                              <!-- <div class="small text-muted">
                               <strong>Booked For:</strong> <?=$row['booked_for'];?> |
                               <strong>Slot Timings:</strong> <?=$row['start_time'];?> - <?=$row['end_time'];?>
                              </div>
                              <div class="small text-muted">
                               <strong>People Capacity:</strong> <?=$row['people_capacity'];?> |
                               <strong>Booking Type:</strong> <?=ucfirst($row['booking_type']);?>
                              </div> -->
                            </td>
                            <td>
                              <div class="small text-muted">Date</div>
                              <?=date('d F Y h:i: A', strtotime($row['created_on']));?>
                            </td>
                            <!-- <td class="text-center">
                              <div class="item-action dropdown">
                                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-check"></i> Accept </a>
                                  <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-alert-octagon"></i> Reject </a>
                                  <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-x-circle"></i> Cancel</a>
                                 </div>
                              </div>
                            </td> -->
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
      <script type="text/javascript">

        $(window).scroll(function() {
          if($(window).scrollTop() + $(window).height() == $(document).height()) {
            var numItems = $('.tr').length;
            $.ajax({
              type:'post',
              url : '<?php echo base_url(); ?>vendor/home/wishlist_scroll_data',
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
        });
      </script>