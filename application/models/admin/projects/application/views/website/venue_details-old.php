<?php
$user_logged_in = $this->session->userdata('user_logged_in');
if(!isset($user_logged_in) || $user_logged_in != true)
{
    ?>
    <!-- <script type="text/javascript">
      $(document).ready(function() 
      { 
         //$('#login-modal').modal('show'); 
         $('#login-modal').show();
         $('#login-modal').addClass('in');
         $('#login-modal .close').hide();
         $('#login-modal').modal({backdrop:'static', keyboard:false});
      });
    </script> -->
    <?php
}
$tdate = date('Y-m-d');
?>
<!-- <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px; z-index:99999999"><img src='<?=base_url();?>assets/img/demo_wait.gif' width="64" height="64" /></div> -->
<!-- <?=var_dump($venue_details);?> -->
<div class="overlay-select"></div>

<!-- / Promotion Ends -->


<!-- Listing Slider Starts-->
<section class="pt-50 pb-50 light-bg listing-slider">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="promotion-slider sync1 owl-carousel">
          <?php
                //var_dump($venue_details['venue_banners']);
                if(!empty($venue_details['venue_banners']))
                {
                    foreach($venue_details['venue_banners'] as $vb)
                    {
                      //echo $vb->image;
                        ?>

          <div class="item">
            <img src="<?=base_url().$vb->image;?>" alt="" />
          </div>
          <?php
                    }
                }
                else
                {
                    ?>
                <div class="no-preview">
                  <img src="<?=base_url();?>assets/website/images/no-preview.png" />
                  <h5>No Images to Preview</h5>
                </div>
          <?php
                }
                ?>
          
        </div>
        <div class="navigation">
          <div class="owl-carousel home-slide-thumb sync2">
            <?php
                    //var_dump($venue_details['venue_banners']);
                    if(!empty($venue_details['venue_banners']))
                    {
                        foreach($venue_details['venue_banners'] as $vb)
                        {
                            ?>
            <div class="item">
              <img src="<?=base_url().$vb->image;?>" alt="product">
            </div>
            <?php
                        }
                    }
                    ?>
            <!-- <div class="item"> 
                        <img src="<?=base_url();?>assets/website/images/slider/270x150-2.jpg" alt="product"> 
                    </div>
                    <div class="item"> 
                        <img src="<?=base_url();?>assets/website/images/slider/270x150-3.jpg" alt="product"> 
                    </div>                           
                    <div class="item"> 
                        <img src="<?=base_url();?>assets/website/images/slider/270x150-4.jpg" alt="product"> 
                    </div> 
                    <div class="item"> 
                        <img src="<?=base_url();?>assets/website/images/slider/270x150-5.jpg" alt="product"> 
                    </div> 
                    <div class="item"> 
                        <img src="<?=base_url();?>assets/website/images/slider/270x150-3.jpg" alt="product"> 
                    </div>                           
                    <div class="item"> 
                        <img src="<?=base_url();?>assets/website/images/slider/270x150-4.jpg" alt="product"> 
                    </div> -->
          </div>
        </div>

      </div>
      <div class="col-md-4 sx-mt-50">
        <div class="info mb-30">
          <div class="title-wrap">
            <h2 class="section-title fw-600 no-margin">
              <?=$venue_details['venue_name'];?>
            </h2>
            <ul class="list-inline">
              <li>
                <span class="rating fsz-11">
                  <?php
                  $i = 1;
                  while($i <= $venue_details['ratings'])
                  {
                    ?>
                    <span class="star active"></span>
                    <?php
                    $i++;
                  }
                  ?>
                </span>
                <!-- <span class="fsz-12 fw-600"> 3250 REVEW </span> -->
              </li>
              <!--<li class="fsz-12 fw-600">
                            <i class="fa fa-trophy theme-color"></i> 20 of 380 HOTELS IN AMSTERDAM
                        </li>-->
            </ul>
          </div>
          <!--  <div class="label-one theme-color-bg mb-30">
                    <strong>$750.00</strong> <span>PER NIGHT</span>
                </div>-->
          <p class="product-description">
            <?=$venue_details['description'];?>
          </p>
          
          </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <section class="promotion new-promo">
    <!-- <div class="container">
    
            <img alt="" src="<?=base_url();?>assets/website/images/icons/lable-1.png" />
            <h2 class="section-title white-color"> <?=$venue_details['venue_name'];?> </h2>
            <h4 class="title-3 fsz-12 white-color"> <?=$venue_details['address'];?> </h4>
        
        <ul class="main-title-stars list-inline">
            <li>
                <span class="rating fsz-11">
                    <?php
                    $i = 1;
                    while($i <= $venue_details['ratings'])
                    {
                        ?>
                        <span class="star active"></span>
                        <?php
                        $i++;
                    }
                    ?>                       
                </span>
            </li>
        </ul> 
  
   
</div> -->
    <!-- <div class="promotion-slider sync1 owl-carousel">
    <div class="item">
        <img src="<?=base_url();?>assets/website/images/slider/1920x970-1.jpg" alt="" />
    </div>
</div> -->

    <div class="info-bottom container">
      <!-- <p class="fw-600 upper-case">THIS PROMOTION ONLY VALID UNTIL 25 AUGUST 2017.</p> -->

      <ul class="hotel-feature">
        <?php
        if($venue_details['amenities_images'])
        {
            $amenities_images = explode(', ', $venue_details['amenities_images']);
            $amenities_titles = explode(', ', $venue_details['amenities_titles']);
            //var_dump($amenities_images);
            foreach($amenities_images as $key=>$am)
            {
                ?>
            <li>
              <img alt="" src="<?=base_url().$am;?>" width="35" height="27"> <span>
                <?=$amenities_titles[$key];?>
              </span>
            </li>
            <?php
            }
        }
        ?>

        <!-- <li> <img alt="" src="<?=base_url();?>assets/website/images/icons/icon-11.png"> <span>SWIMMING POOL</span> </li>
        <li> <img alt="" src="<?=base_url();?>assets/website/images/icons/icon-12.png"> <span>RESTAURANT</span> </li>
        <li> <img alt="" src="<?=base_url();?>assets/website/images/icons/icon-13.png"> <span>FITNESS CENTER</span> </li>
        <li> <img alt="" src="<?=base_url();?>assets/website/images/icons/icon-14.png"> <span>SPA &amp; MASSAGE</span> </li> -->
        <!-- <li class="price"> <del>$350</del> <div> <ins> $275 </ins> <span> PER NIGHT </span> </div> </li> -->
      </ul>
    </div>
    <div class="clearfix"></div>
  </section>

  <div class="container">
    <div class="row">

      <hr class="divider-1" />
      <div class="col-md-8 card-white">

        <div class="overview mb-30">
          <div class="info">
            <h2 class="title-4 fw-600">Addition Info.</h2>
            <ul class="list-unstyled">
              <li>
                <i class="fa fa-map-marker theme-color-bg"></i>
                <span>
                  <?=$venue_details['address'];?>
                </span>
              </li>
              <li>
                <i class="fa fa-bolt theme-color-bg"></i>
                <span>
                  <?=ucwords($venue_details['booking_type']);?> Booking
                </span>
              </li>
              <li>
                <i class="fa fa-star theme-color-bg"></i>
                <span>
                  <?=round($venue_details['ratings']);?> stars
                </span>
              </li>
              <li>
                <i class="fa fa-inr theme-color-bg"></i>
                <span>
                  <?php echo $final_amount = $venue_details['price'] * ((100 - $venue_details['discount_percentage']) / 100); ?>
                </span>
                <del style="font-size: 12px; color: #bbb">
                  (&#8377; <?=$venue_details['price'];?>/-)
                </del>
              </li>
              <li>
                <i class="fa fa-users theme-color-bg"></i>
                <span>
                  Capacity : <?=$venue_details['people_capacity'];?>
                </span>
              </li>
              <li>
                <i class="fa fa-chevron-right theme-color-bg"></i>
                <strong>Ac/Non Ac: </strong>
                <span>
                  <?=ucfirst($venue_details['ac']);?>
                </span>
              </li>
              <li>
                <i class="fa fa-chevron-right theme-color-bg"></i>
                <strong>Venue type: </strong>
                <span>
                  <?=ucfirst($venue_details['venue_type']);?>
                </span>
              </li>
              <li>
                <i class="fa fa-chevron-right theme-color-bg"></i>
                <strong>Veg/ Non Veg: </strong>
                <span>
                  <?=ucfirst($venue_details['veg']);?>
                </span>
              </li>
            </ul>
          </div>
        </div>
        <div class="batches">
          <?php
          $book_your_slot = "";
            //echo $venue_details['category_id'];
            if($venue_details['category_id'] == 7 || $venue_details['category_id'] == 8)
            {
                ?>
          <div class="select-capacity col-lg-12">
            <h2 class="title-4 fw-600 pull-left">
              <i class="fa fa-check" aria-hidden="true"></i>Book Your Slot
            </h2>

            <div class="clearfix"></div>
            <div class="clearfix"></div>
            <hr>

              <form class="col-lg-12 pull-right" action="javascript:void(0)" method="post" id="capacity_date">

                <div class="form-group">
                  <?php
                if(!empty($pricings))
                {
                    foreach($pricings as $key => $row)
                    {
                        ?>
                  <div class="col-lg-3">
                    <h4>
                      <?=$row->title;?> :
                    </h4>
                    <input type="hidden" name="title[]" value="<?=$row->title;?>">
                    <input type="hidden" name="e_id[]" value="<?=$row->id;?>">
                  </div>

                  <div class="col-lg-3">
                    <div class="row">
                      <input class="form-control border quantityy" required="" placeholder="Enter Quantity" type="number" id="quantity" name="quantity[]" onkeyup="calculate_total(this.value, '<?=$key;?>', '<?=$row->id;?>')">
                    </div>
                  </div>

                  <div class="col-lg-2" style="margin-left: 30px;">
                    <div class="row">
                      <h5>
                        Price : <span id="price<?=$key;?>"><?=$row->price;?>
                        </span>
                      </h5>
                      <input type="hidden" name="price[]" value="<?=$row->price;?>">
                    </div>
                  </div>

                  <div class="col-lg-2">
                    <div class="row">
                      <h5>
                        Total : <span id="total<?=$key;?>" class="total">0
                        </span>
                      </h5>
                      <input type="hidden" name="total[]" id="in_total<?=$key;?>" value="0">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <?php
                    }                    
                    ?>
                    <hr>
                    <div class="col-lg-3">
                      <h4>&nbsp;</h4>
                    </div>

                    <div class="col-lg-3">
                      <div class="row">
                        &nbsp;
                      </div>
                    </div>

                    <div class="col-lg-2" style="margin-left: 30px;">
                      <div class="row">
                        &nbsp;
                      </div>
                    </div>

                    <div class="col-lg-2">
                      <div class="row">
                        <h5>
                          = <span id="grand_total" class="grand_total">0</span>
                        </h5>
                      </div>
                    </div>

                    <div class="clearfix"></div>
                    <hr>
                      <!-- <div class="col-lg-2">
                        <button type="Submit" class="btn theme-color-bg white-color slot" type="button" id="btnSubmit">Go</button>
                    </div> -->
                    <?php
                } 
                else
                {
                  $book_your_slot = "hide";
                }               
                ?>
                  
                    </div>


                <style>
                  .slot{
                  line-height: 27px;
                  }
                </style>

              </form>
              <div class="clearfix"></div>
              <div class="clearfix"></div>
              <br>
            
             </div>
          <?php
         }
            else
            {
                ?>
          <div class="select-capacity col-lg-12">
            <h2 class="title-4 fw-600 pull-left">
              <i class="fa fa-check" aria-hidden="true"></i>Book Your Slot
            </h2>

            <form class="col-lg-8 col-xs-12 pull-right slot-container" action="javascript:void(0)" method="post" id="capacity_date">
              
                <div class="form-group">
                  <div class="row">
                  <?php                    
                    $capacity_range = explode('-', $venue_details['people_capacity']);
                    //var_dump($capacity_range);
                    if($venue_details['category_id'] == 4 || $venue_details['category_id'] == 9 || $venue_details['category_id'] == 10)
                    {
                        ?>
                  <div class="col-lg-5 col-xs-5">
                    <label>Enter Capacity</label>
                    <input class="form-control border" required="" type="number" placeholder="Enter Capacity" name="capacity" id="capacity" required="" min="<?=$capacity_range[0];?>" max="<?=$capacity_range[1];?>" value="<?=$capacity;?>">
                  </div>
                  <?php
                    }
                    else
                    {
                        ?>
                  <div class="col-lg-5 col-xs-5">
                  <label>Enter Capacity</label>
                    <input class="form-control border" required="" type="number" placeholder="Enter Capacity" name="capacity" id="capacity" required="" max="<?=$capacity_range[0];?>" value="<?=$capacity;?>">
                  </div>
                  <?php
                    }
                    ?>
                  <div class="col-lg-5 col-xs-5">
                    <div class="row">

                      <label>Select Date</label>
                      <?php
                      $display_date = $venue_details['date'];
                      if($venue_details['date'] == "1970-01-01")
                      {
                          $display_date = date('Y-m-d');
                      }
                      ?>
                    
                      <input class="form-control border" required="" data-date-format="yyyy-mm-dd" placeholder="Select Date" type="text" min="<?=date('Y-m-d', strtotime($tdate));?>" required="" readonly="" name="date" id="date" value="<?=date('d-m-Y', strtotime($display_date));?>">
                    </div>
                    <!-- <span class="fa fa-chevron-down theme-color"></span> -->
                  </div>
                  <input type="hidden" name="venue_id" value="<?=$this->uri->segment(3);?>">
                  <input type="hidden" name="category_id" value="<?=$venue_details['category_id'];?>">
                  <div class="col-lg-2 col-xs-2">
                    <label>&nbsp;</label>
                    <button type="Submit" class="btn theme-color-bg white-color slot" type="button" id="btnSubmit">Go</button>
                  </div>
                  <style>
                    .slot{
                    line-height: 27px;
                    }
                  </style>
                </div>
              </div>
            </form>
            <div class="clearfix"></div>
            <div class="clearfix"></div>
            <br>
              <ul id="slots">
                <?php            
            //var_dump($venue_details['check_slots_available']);
            //echo $venue_details['capacity_booked'];
            if(!empty($venue_details['check_slots_available']) && $capacity)
            {
                foreach($venue_details['check_slots_available'] as $key => $csa)
                {

                    if($csa['amount'] != "")
                    {
                      $selected = "";
                      if($venue_details['capacity_applicable'] == "Yes")
                      {
                        $left_capacity = $csa['slot_capacity'] - $csa['capacity_booked'];
                        //echo $capacity;echo "<br>";echo $left_capacity;
                        if($capacity > $left_capacity)
                        {
                          $selected = "booked";
                        }
                      }
                      ?>
                <li>
                  <a href="javascript:void(0)" class="wow pulse <?=$selected;?> <?=$csa['booking_status'];?>" data-wow-delay=".<?=$key+1.5;?>s" id="<?=$csa['slot_id'];?>"><span>
                      <i class="fa fa-clock-o" aria-hidden="true"></i> <?=date('h:i A', strtotime($csa['start_time']));?> - <?=date('h:i A', strtotime($csa['end_time']));?>
                    </span>
                    <?php
                        if($venue_details['capacity_applicable'] == "Yes")
                        {
                            $left_capacity = $csa['slot_capacity'] - $csa['capacity_booked'];
                            ?>
                    <span class="capacity">
                      <span class="total-capacity">
                        <i class="fa fa-users" aria-hidden="true"></i> Capacity <?=$csa['slot_capacity'];?>
                      </span>
                      <span class="remaining-capacity">
                        <i class="fa fa-users" aria-hidden="true"></i> Booked <?php if($csa['capacity_booked']) echo $csa['capacity_booked']; else echo 0;?> - Left <?=$left_capacity;?>
                      </span>
                    </span>
                    <?php
                        }
                        else
                        {
                            ?>
                    <span class="capacity">
                      <span class="total-capacity">
                        <i class="fa fa-users" aria-hidden="true"></i> Capacity <?=$venue_details['people_capacity'];?>
                      </span>
                      <span class="remaining-capacity">
                        <i class="fa fa-users" aria-hidden="true"></i> Capacity <?=$venue_details['people_capacity'];?>
                      </span>
                    </span>
                    <?php
                        }
                        ?>
                    <span class="price">
                      <i class="fa fa-inr" aria-hidden="true"></i>
                      <?php echo $csa['amount']; ?>
                    </span><span class="select">Select this Slot</span><span class="selected">
                      Selected <i class="fa fa-check" aria-hidden="true"></i>
                    </span>
                  </a>
                </li>
                <?php
                    }
                    else
                    {
                        ?>
                <div class="alert alert-info">
                  <p>No slots available!</p>
                </div>
                <?php
                    }
                }
            }
            else
            {
                ?>
                <div class="alert alert-info">
                  <p>Plese select capacity and date to get slots available!</p>
                </div>
                <?php
            }
            ?>
              </ul>
            </div>
          <?php
         }
         ?>

          <hr>
            <div class="services">
              <h2 class="title-4 fw-600 pull-left">
                <i class="fa fa-cogs" aria-hidden="true"></i> Services
              </h2>
              <div class="clearfix"></div>
              <hr />
              <ul>
                <?php
            if($venue_details['services_titles'])
            {
                $services_titles = explode(', ', $venue_details['services_titles']);
                $services_images = explode(', ', $venue_details['services_images']);
                foreach($services_titles as $key=>$st)
                {
                    ?>
                <li>
                  <span>
                    <b>
                      <img src="<?=base_url().$services_images[$key];?>" height="20" width="20">
                    </b>
                    <?=$st;?>
                  </span>
                </li>
                <?php
                }
            }
            ?>
                <div class="clearfix"></div>
              </ul>
            </div>
            <hr />

            <?php
            //echo $book_your_slot;
            if($book_your_slot != "hide")
            {
              ?>
            <div class="hidden-desktop">
            <div class="book-venue">
              <a onclick="open_popup()" class="label-one theme-color-bg">
                 <strong id="book_amount1">
                  Book(<i class="fa fa-inr"></i> <?php echo $venue_details['token_amount']; ?> /-)
                </strong> 
              </a>
              </p>
            </div>
            </div>
            <?php
          }
          //echo $venue_details['can_give_ratings'];
          $user_logged_in = $this->session->userdata('user_logged_in');
          if((isset($user_logged_in) || $user_logged_in == true ) && $venue_details['can_give_ratings'] == "yes")
          {
          ?>


            <h2 class="title-4 fw-600 pull-left">
              <i class="fa fa-pencil" aria-hidden="true"></i> Reviews
            </h2>
            <div class="clearfix"></div>
            <form method="post" action="<?=base_url();?>home/submit_ratings" id="">
              <div class="form-group">
                <div class="stars">
                  <input class="star star-5" id="star-5" type="radio" name="star" value="5"/>
                  <label class="star star-5" for="star-5"></label>
                  <input class="star star-4" id="star-4" type="radio" name="star" value="4"/>
                  <label class="star star-4" for="star-4"></label>
                  <input class="star star-3" id="star-3" type="radio" name="star" value="3"/>
                  <label class="star star-3" for="star-3"></label>
                  <input class="star star-2" id="star-2" type="radio" name="star" value="2"/>
                  <label class="star star-2" for="star-2"></label>
                  <input class="star star-1" id="star-1" type="radio" name="star" value="1" checked="" />
                  <label class="star star-1" for="star-1"></label>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="form-group">
                <textarea placeholder="Write your Reviews" class="form-control review-text" required="" name="reviews"></textarea>
              </div>
              <input type="hidden" name="venue_id" value="<?=$this->uri->segment(3);?>">
              <?php $url = explode('?', $_SERVER['REQUEST_URI']); ?>
              <input type="hidden" name="filter" value="<?php if(isset($url[1])) $url[1];?>">
              <div class="form-group">
                <div class="clearfix"></div>
                <br>
                  <button class="btn theme-color-bg white-color pull-right">Submit</button>
                  <div class="clearfix"></div>
                </div>

            </form>
            <?php
          }
          ?>
            <div class="contents grid-contents available-rooms ">
              <hr class="divider">
                <?php
            //var_dump($venue_details['venue_ratings']);
            if(!empty($venue_details['venue_ratings']))
            {
                foreach($venue_details['venue_ratings'] as $vr)
                {
                    ?>
                <div class="row">
                  <div class="content wide">
                    <div class="inner">
                      <div class="col-sm-7 col-md-8">
                        <div class="entry">
                          <article class="entry-content">
                            <h2 class="title-4 no-margin">
                              <a href="javascript:void(0)" title="">
                                <?=$vr->name;?>
                              </a>
                            </h2>
                            <p>
                              <span class="rating fsz-11">
                                <?php
                                $i = 1;
                                while($i <= $vr->ratings)
                                {
                                    ?>
                                    <span class="star active"></span>
                                    <?php
                                    $i++;
                                }
                                ?>
                              </span>
                            </p>
                            <p>
                              <?=$vr->reviews;?>
                            </p>
                          </article>
                        </div>
                        <!-- /.entry -->
                      </div>

                    </div>
                  </div>
                  <!-- /.content -->
                </div>
                <!-- /.row -->
                <hr class="divider-1">
                  <?php
                }
            }
            ?>
                </div>
          </div>

      </div>
      <div class="col-md-4 sx-mt-50">
        
          <div class="widget-map mb-30">
            <div class="contact-map">
              <iframe src="https://maps.google.com/maps?q=<?=$venue_details['lat'];?>,<?=$venue_details['lng'];?>&hl=es;z=15&amp;output=embed" height="252px" width="100%" frameBorder="0">
              </iframe>
            </div>
          </div>
        <div class="visible-desktop">
          <div class="mb-30">
            <!-- <?php
            if($venue_details['capacity_applicable'] == "Yes")
            {
                ?>
                <div class="book-venue"><a class="label-one theme-color-bg" onclick="book_now('<?=$venue_details['category_id'];?>','<?=$venue_details['vendor_id'];?>','<?=$venue_details['venue_id'];?>', '<?=$venue_details['token_amount'];?>', <?=$venue_details['people_capacity'];?>, '', '<?=$venue_details['booking_type'];?>')"> <strong>Book( <i class="fa fa-inr"></i> <?php echo $venue_details['token_amount']; ?> /-)</strong>  </a></p></div>
                <?php
            }
            else
            {
                ?>
                <div class="book-venue"><a class="label-one theme-color-bg" onclick="book_now('<?=$venue_details['category_id'];?>','<?=$venue_details['vendor_id'];?>','<?=$venue_details['venue_id'];?>', '<?=$venue_details['token_amount'];?>', '', '', '<?=$venue_details['booking_type'];?>')"> <strong> Book(<i class="fa fa-inr"></i> <?php echo $venue_details['token_amount']; ?> /-)</strong> </a></p></div>
                <?php
            }
            ?> -->
            <?php
            //echo $book_your_slot;
            if($book_your_slot != "hide")
            {
              ?>
            <div class="book-venue">
              <a onclick="open_popup()" class="label-one theme-color-bg">
                 <strong id="book_amount">
                  Book(<i class="fa fa-inr"></i> <?php echo $venue_details['token_amount']; ?> /-)
                </strong> 
              </a>
              </p>
            </div>
            <?php
          }
          ?>
          </div>
        </div>
        <div class="clearfix"></div>
        <!--<div class="widget-wrap">
                <h2 class="title-4 fw-600"> You May Like </h2>
                <ul class="recent-post list-items">
                    <li> 
                        <img src="<?=base_url();?>assets/website/images/gallery/80x80-7.jpg" alt="">
                        <div class="info">
                            <p class="no-margin"> <a href="#"> Spotlight destinations in this month </a> </p>
                             <p class="no-margin"><span class="theme-color fw-600 fsz-15">Designation</span> </p>
                            <a href="#" class="all-show">Book</a>
                        </div>
                    </li>
                    <li> 
                        <img src="<?=base_url();?>assets/website/images/gallery/80x80-8.jpg" alt="">
                        <div class="info">
                            <p class="no-margin"> <a href="#"> Cheap flight only in vetrov inside deal </a> </p>
                            <p class="no-margin"><span class="theme-color fw-600 fsz-15">$150</span><small>/Night </small> </p>
                            <a href="#" class="all-show">Book</a>
                        </div>
                    </li>
                    <li> 
                        <img src="<?=base_url();?>assets/website/images/gallery/80x80-9.jpg" alt="">
                        <div class="info">
                            <p class="no-margin"> <a href="#"> Get up to 50% off only in this month </a> </p>
                            <p class="no-margin"><span class="theme-color fw-600 fsz-15">$150</span><small>/Night </small> </p>
                            <a href="#" class="all-show">Book</a>                                               
                        </div>
                    </li>
                </ul>
            </div>-->
      </div>
    </div>
</div>
</section>
<!-- / Listing Slider Ends -->      

</article>
<!-- / CONTENT AREA -->

<!-- Modal City -->
<div class="modal modal-padding fade" id="modal-payment" role="dialog">
    <div class="modal-dialog">
      <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px; z-index:99999999"><img src='<?=base_url();?>assets/img/demo_wait.gif' width="64" height="64" /></div>
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body no-padding">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
          <!-- <h4>Please Select Payment mode</h4> -->
          <form class="reply-form">
          <style>
             .cash-radio label{
              border:1px solid #ddd;
              padding:10px 10px 10px 40px;

             }
             .cash-radio label input[type="checkbox"], .cash-radio label input[type="radio"]
             {
                display: block;
                position: absolute;
                left: 10px;
                top: 10px;
             }
             .cash-radio label input[type="radio"]:checked{
              
             }
             .checkmark
             {
                display: none;
             }
            </style>
            <div class="overview mb-30">
                <div class="info">
                    <h2 class="title-4 fw-600">Booking Summary</h2>
                    <ul class="list-unstyled">
                        <li> <i class="fa fa-building theme-color-bg"></i> <span><?=$venue_details['venue_name'];?></span> </li>
                        <li> <i class="fa fa-map-marker theme-color-bg"></i> <span><?=$venue_details['address'];?></span> </li>
                        <li> <i class="fa fa-bolt theme-color-bg"></i> <span><?=ucwords($venue_details['booking_type']);?> Booking</span> </li>
                        <li> <i class="fa fa-star theme-color-bg"></i> <span><?=round($venue_details['ratings']);?> stars </span> </li>
                        <li> <i class="fa fa-inr theme-color-bg"></i> <span id="price_summary"><strong id="book_amount1">
                  <?php echo $venue_details['token_amount']; ?> /-
                </strong></span>
                </del> </li>
                        <li> <i class="fa fa-users theme-color-bg"></i> <span>Capacity : <span id="capacity_summary"><?=$capacity;?></span> </span> </li>
                        <li>
                <i class="fa fa-chevron-right theme-color-bg"></i>
                <strong>Ac/Non Ac: </strong>
                <span>
                  <?=ucfirst($venue_details['ac']);?>
                </span>
              </li>
              <li>
                <i class="fa fa-chevron-right theme-color-bg"></i>
                <strong>Venue type: </strong>
                <span>
                  <?=ucfirst($venue_details['venue_type']);?>
                </span>
              </li>
              <li>
                <i class="fa fa-chevron-right theme-color-bg"></i>
                <strong>Veg/ Non Veg: </strong>
                <span>
                  <?=ucfirst($venue_details['veg']);?>
                </span>
              </li>
                        <li id="slot_display"></li>
                    </ul>
                </div>
            </div>

            <?php
            //echo $venue_details['category_id'];
            if($venue_details['category_id'] != 4 && $venue_details['category_id'] != 9 && $venue_details['category_id'] != 10 && $venue_details['category_id'] != 5 && $venue_details['category_id'] != 6)
            {
                ?>
                <div class="col-lg-5">
                    <div class="row">
                    <label>Select date</label>
                        <input style="border: 1px #000" class="form-control border datepicker" required="" data-date-format="yyyy-mm-dd" placeholder="Select Date" type="text" required="" name="date" id="date" value="<?=date('Y-m-d');?>" >
                    </div>
                    <!-- <span class="fa fa-chevron-down theme-color"></span> -->
                </div>
                <?php
            }
            ?>

            <div class="clearfix"></div>
            <!-- <?php
            if(!empty($pricing))
            {
                ?>
                <table class="table" style="width: 100%;" border="1">
                <tr><th>Title</th><th>Price</th><th>Quantity</th><th>Total</th></tr>
                <?php
                    foreach($pricing as $p_price)
                    {
                        ?>
                        <tr>
                        <td><?=$p_price->title;?></td>
                        <td><?=$p_price->price;?></td>
                        <td><?=$p_price->quantity;?></td>
                        <td><?=$p_price->price * $p_price->quantity?></td>
                        </tr>
                        <?php
                    }
                ?>
                </table>
                <?php
            }
            ?> -->
            <br>
            <?php
            //echo $venue_details['booking_type'];
            if($venue_details['payment_option'] == "enable" && ($venue_details['category_id'] != 5 && $venue_details['category_id'] != 6) && $venue_details['booking_type'] != "delayed")
            {
                ?>

            <div class="col-lg-12">
                <div class="text-center cash-radio row">
              <label class="">Pay at Venue
                <input type="radio" name="payment_type" value="cash" class="payment_type" onclick="book_now('cash')">
                <span class="checkmark"></span>
              </label>
              <label class="">Pay Online
                <input type="radio" name="payment_type" value="card" class="payment_type" onclick="book_now('card')"/>
                <span class="checkmark"/></span>
              </label>
            </div>
            </div>
            <?php
        }
        else
        {
            ?>
            <style type="">
            .new-cash-radio label input[type="checkbox"], .cash-radio label input[type="radio"]{
                visibility: hidden;
            }
            .new-cash-radio label{
                padding: 10px 20px;
            }
            .new-cash-radio{

                padding-top: 10px 20px !important;
            }
            </style>
            <div class="col-lg-12">
                <div class="text-center cash-radio new-cash-radio">
              <label class="label-one theme-color-bg">Confirm
                <input type="radio" name="payment_type" value="na" class="payment_type" onclick="book_now('na')" />
                <span class="checkmark"></span>
              </label>              
            </div>
            </div>
            <?php
        }
        ?>
        </form>
        <div class="clearfix"></div>
        <hr />
        <div class="cities-list">
        </div>    
    </div>
</div>

<div class="blue-line"></div>
<div class="yellow-line"></div>

</div>
</div>

<?php
$MERCHANT_KEY = "RSfY9Azo";
$SALT = "1r9HXMWnFj";
$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
$posted = array(
    'key' => $MERCHANT_KEY,
    'hash' => '',
    'txnid' => $txnid,
    'amount' => $venue_details['token_amount'],
    'firstname' => $this->session->userdata('name'),
    'email' => $this->session->userdata('email_id'),
    'phone' => $this->session->userdata('mobile'),
    'productinfo' => substr($venue_details['description'], 0, 100),    
    'service_provider' => 'payu_paisa'
    );
//$PAYU_BASE_URL = "https://sandboxsecure.payu.in";       // For Sandbox Mode
$PAYU_BASE_URL = "https://secure.payu.in";
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
$hashVarsSeq = explode('|', $hashSequence);
$hash_string = '';  
foreach($hashVarsSeq as $hash_var) {
  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
  $hash_string .= '|';
}
$hash_string .= $SALT;
$hash = strtolower(hash('sha512', $hash_string));
$action = $PAYU_BASE_URL . '/_payment';
?>

<form action="<?php echo $action; ?>" method="post" name="payuForm" id="payuForm">
    <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
    <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
    <input type="hidden" name="amount" id="amount_t" value="<?=$venue_details['token_amount'];?>" />
    <input type="hidden" name="firstname" id="firstname" value="<?=$this->session->userdata('name');?>" />
    <input type="hidden" name="email" id="email" value="<?=$this->session->userdata('email_id');?>" />
    <input type="hidden" name="phone" value="<?=$this->session->userdata('mobile');?>" />
    <input type="hidden" name="productinfo" value="<?=substr($venue_details['description'], 0, 100);?>" />
    <input type="hidden" name="surl" value="" size="64" id="surl" />
    <input type="hidden" name="furl" value="" size="64" id="furl" />
    <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
</form>

<script type="text/javascript">
    $("#capacity_date").submit(function() { //alert();
        $("#btnSubmit").prop('disabled', true);
        var date = $("#date").val();//alert(date);
        var capacity = $("#capacity").val();//alert(date);
        var pageURL = $(location).attr("href");

        var segments = pageURL.split( '/' );
        var filter = '/?filter='+date+','+capacity;
        //alert(segments[7]);
        if ( !segments[7] )
        {
            
        }
        else
        {
            var pageURL = pageURL.substring(0, pageURL.indexOf('/?'));
        }
        location.href=pageURL+filter;
    });

    function open_popup()
    {
        <?php
        $user_logged_in = $this->session->userdata('user_logged_in');
        if(!isset($user_logged_in) || $user_logged_in != true)
        {
            ?>
            $('#login-modal').modal('show'); 
            $('#login-modal').show();
            $('#login-modal').addClass('in');
            $('#login-modal .close').hide();
            $('#login-modal').modal({backdrop:'static', keyboard:false});
            $("#wait").css("display", "none");
            return false;
            <?php
        }
        ?>

        var slot_id = $('ul#slots a.active').attr('id');
        var capacity = $('#capacity').val();
        var date = $('#date').val();

        <?php
        //echo $venue_details['category_id'];
        if($venue_details['category_id'] == 4 || $venue_details['category_id'] == 5 || $venue_details['category_id'] == 6 || $venue_details['category_id'] == 9 || $venue_details['category_id'] == 10)
        {
            ?>
            if(!capacity)
            {
                alert('Please Enter Capacity!');exit;
            }
            else if(!date)
            {
                alert('Please Enter Date!');exit;
            }
            else if(!slot_id)
            {
                alert('Please select a slot!');exit;
            }
            else
            {
                var slot = $('ul#slots a.active span').html();
                $('#slot_display').html(slot);
                $("#slot_display i").addClass("theme-color-bg");
                $('#modal-payment').modal('show');exit;
            }
            <?php
        }
        else
        {
            ?>
            var quantity = $("input[name='quantity[]']").map(function(){return $(this).val();}).get();//alert(quantity);
            //var res = quantity.split(",,");alert(res);
            var grand_total = $(".grand_total").html();
            if (parseFloat(grand_total) <= 0)
            {
                alert('please enter quantity!');exit;
            }
            $("#slot_display i").addClass("theme-color-bg");
            $('#modal-payment').modal('show');exit;
            <?php
        }
        ?>
    }
    // category_id, vendor_id, venue_id, amount_paid, total_capacity, capacity, booking_type
    $('.payment_type').click(function()
    {
        $("#wait").css("display", "block");
        $(".payment_type").prop('disabled', true);
        
        var payment_mode = $(this).attr("value");//alert(payment_mode);exit;
    
        var category_id = "<?=$venue_details['category_id'];?>";
        var vendor_id = "<?=$venue_details['vendor_id'];?>";
        var venue_id = "<?=$venue_details['venue_id'];?>";

        var amount_paid = $('#amount_t').val();
        
        var booking_type = "<?=$venue_details['booking_type'];?>";

        var capacity_applicable = "<?=$venue_details['capacity_applicable'];?>";
        if(capacity_applicable == "Yes")
        {
            var total_capacity = "<?=$venue_details['people_capacity'];?>";
        }
        else
        {
          var total_capacity = "";
        }               

        var slot_id = 0;
        var capacity = 0;
        var date = "<?=date('Y-m-d');?>";
        var title = [];
        var quantity = [];
        var price = [];
        var total = [];
        var e_id = [];
        <?php
        //echo $venue_details['category_id'];
        if($venue_details['category_id'] == 4 || $venue_details['category_id'] == 9 || $venue_details['category_id'] == 10 || $venue_details['category_id'] == 5 || $venue_details['category_id'] == 6)
        {
            ?>
            var slot_id = $('ul#slots a.active').attr('id');
            var capacity = $('#capacity').val();
            var date = $('#date').val(); //alert(date);exit;
            if(!slot_id)
            {
                alert('Please select a slot!');exit;
            }
            <?php
        }
        else
        {
            ?>
            var title = $("input[name='title[]']").map(function(){return $(this).val();}).get();//alert(values);exit;
            var quantity = $("input[name='quantity[]']").map(function(){return $(this).val();}).get();
            // if (quantity.length === 0) {
            //     alert('Please enter quantity!');return false;
            // }
            var price = $("input[name='price[]']").map(function(){return $(this).val();}).get();
            var total = $("input[name='total[]']").map(function(){return $(this).val();}).get();
            var e_id = $("input[name='e_id[]']").map(function(){return $(this).val();}).get();
            var date = $('#date').val(); //alert(date);exit;
            //var title = title.join(",");alert(title);
            
            <?php
        }
        ?>
        var date = $('#date').val(); //alert(date);exit;
        $.ajax( {
            type: 'POST',
            url: "<?=base_url();?>home/place_order",
            data: {category_id:category_id, vendor_id:vendor_id, venue_id:venue_id, total_capacity:total_capacity, capacity:capacity, amount_paid:amount_paid, booking_type:booking_type, slot_id:slot_id, capacity:capacity, booked_for:date, payment_mode:payment_mode, title:title, quantity:quantity, price:price, total:total, e_id:e_id},
            beforeSend: function( xhr ) { //alert(title);
                xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                $("#wait").css("display", "block");
            },
            success: function(data) { //alert(data);exit;
                var str = data.split("-", 2);
                if(str[0] == "success")
                {
                    $('#order_success').html('Your order has been placed successfully. Thank You.').show();
                    alert('Your order has been placed successfully. Thank You.');
                    location.reload();
                }
                else if(str[0] == "payment_gateway")
                {   //alert();
                    var surl = '<?=base_url();?>home/payment_status/success/'.concat(str[1]);
                    var furl = '<?=base_url();?>home/payment_status/failure/'.concat(str[1]);
                    $("#surl").val(surl);
                    $("#furl").val(furl);
                    $("#payuForm").submit();
                }
                $("#wait").css("display", "none");
                return false;
            }
        });
        //$("#wait").css("display", "none"); 
    });

    function calculate_total(quantity, key, id)
    {
        //alert(quantity);
        var price = $('#price'+key).html();
        var total = parseFloat(price) * parseFloat(quantity);//alert(total);
        var t_total = 0;
        if($.isNumeric( total ))
        {
            var t_total = total;
        }
        $('#total'+key).html(t_total);
        $('#in_total'+key).val(t_total);

        var sum = 0;
        $('.total').each(function(){
            sum += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
        });
        
        var quan = 0;
        $('.quantityy').each(function(){
            quan += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
        });
        $('#grand_total').html(sum);
        $('#book_amount').html(sum);
        $('#book_amount1').html(sum);
        $('#amount_t').val(sum);
        $('#price_summary').html(sum);
        $('#capacity_summary').html(quan);
        
    }
</script>