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
<div class="loading" id="wait" style="display:none;width:120px;height:120px;position:fixed;top:25%;left:50%;padding:2px; z-index:99999999"><img src='<?=base_url();?>assets/img/demo_wait.gif' width="150" height="150" /></div>
<!-- Page Starts-->
<!--Breadcrumb Section Start-->
<?php
$url = explode('=', $_SERVER['REQUEST_URI']);
if(isset($url[1]))
{
    $filters = explode(',', $url[1]);
}
else
{
    $filters = array();
}
$tdate = date('Y-m-d');
?>
<section class="">   
    <!-- <div class="site-breadcumb"> -->
    <div class="container" style="margin-top: 10px">
        <ol class="breadcrumb breadcrumb-menubar">
            <li> <a href="<?=base_url();?>"> Home </a> <span><?=$category_name;?> </span>  </li>                             
        </ol>
    </div>
    <!-- </div> -->
</section>
<!--Breadcrumb Section End-->
<section class="sec-space" style="padding-top: 10px">
    <div class="container"> 
        <div class="widget-search filter-section hidden-lg hidden-md">
            <div class="row">
                <div class="search-selectpicker selectpicker-wrapper col-lg-6 col-md-6 col-xs-6">
                 
                    <a href="Javascript:void(0);" class="sort-button">Hide Sort & Filter
                    <!--<i class="fa fa-long-arrow-up" aria-hidden="true"></i><i class="fa fa-long-arrow-down" aria-hidden="true"></i>-->
                    </a>
                </div>
                <!-- <div class="search-selectpicker selectpicker-wrapper col-lg-6 col-md-6 col-xs-6">
                    <a href="Javascript:void(0);" class="filter-button">Filter<i class="fa fa-filter" aria-hidden="true"></i></a>
                </div> -->
            </div>
            <div class="clearfix"></div>              
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-lg-3 col-sm-4 list-filter">
             <div class="widget-wrap sort-wrap filter-wrap">
                 
                 <h4 class="fsz-15 "> Sort By <i class="fa fa-long-arrow-down pull-right" aria-hidden="true"></i> <i class="fa fa-long-arrow-up pull-right" aria-hidden="true"></i>
                    <form class="search-form" method="post"></h4>
                        <select class="selectpicker form-control border" data-width="100%" data-toggle="tooltip" onchange="update_filter(this.value, 'sort')">
                            <option value="">Sort By</option>
                            <option value="high" <?php echo (isset($filters[0]) && $filters[0] == "high")?"selected":"" ;?>>High to Low</option>
                            <option value="low" <?php echo (isset($filters[0]) && $filters[0] == "low")?"selected":"" ;?>>Low to High</option>
                            <option value="ratings" <?php echo (isset($filters[0]) && $filters[0] == "ratings")?"selected":"" ;?>>Ratings</option>
                        </select>

                        <?php
                          if(isset($filters[4]) && ($filters[4] == 4 || $filters[4] == 5))
                          {
                            ?>
                            <div class="search-selectpicker selectpicker-wrapper">
                              <div class="radio">
                              <label><input type="radio" name="veg" value="veg" <?php echo (isset($filters[1]) && $filters[1] == "veg")?"checked":"" ;?> onclick="update_filter(this.value, 'veg')"> Veg</label>
                              <label><input type="radio" name="veg" value="non_veg" <?php echo (isset($filters[1]) && $filters[1] == "non_veg")?"checked":"" ;?> onclick="update_filter(this.value, 'veg')"> Non Veg</label>
                              <label><input type="radio" name="veg" value="both" <?php echo (isset($filters[1]) && $filters[1] == "both")?"checked":"" ;?> onclick="update_filter(this.value, 'veg')"> Both</label>
                              </div>
                          </div>
                          <?php
                      }
                      ?>

                      <?php
                      if(isset($filters[4]) && ($filters[4] == 4 || $filters[4] == 5 || $filters[4] == 9 || $filters[4] == 10))
                      {
                        ?>
                          <div class="search-selectpicker selectpicker-wrapper">
                              <div class="radio">
                              <label><input type="radio" name="ac" value="ac" <?php echo (isset($filters[2]) && $filters[2] == "ac")?"checked":"" ;?> onclick="update_filter(this.value, 'ac')"> AC</label>
                              <label><input type="radio" name="ac" value="non_ac" <?php echo (isset($filters[2]) && $filters[2] == "non_ac")?"checked":"" ;?> onclick="update_filter(this.value, 'ac')"> Non AC</label>
                              <label><input type="radio" name="ac" value="both" <?php echo (isset($filters[2]) && $filters[2] == "both")?"checked":"" ;?> onclick="update_filter(this.value, 'ac')"> Both</label>
                              </div>
                          </div>
                          <?php
                      }
                      ?>
                      
                      <div class="search-selectpicker selectpicker-wrapper">
                          <div class="radio">
                          <label><input type="radio" name="booking_type" value="delayed" <?php echo (isset($filters[8]) && $filters[8] == "delayed")?"checked":"" ;?> onclick="update_filter(this.value, 'booking_type')"> Delayed</label>
                          <label><input type="radio" name="booking_type" value="instant" <?php echo (isset($filters[8]) && $filters[8] == "instant")?"checked":"" ;?> onclick="update_filter(this.value, 'booking_type')"> Instant</label>
                          </div>
                      </div>

                      <?php
                      if(isset($filters[4]) && $filters[4] != 10)
                      {
                        ?>
                          <div class="search-selectpicker selectpicker-wrapper">
                              <div class="radio">
                              <label><input type="radio" name="venue_type" value="Indoor" <?php echo (isset($filters[9]) && $filters[9] == "Indoor")?"checked":"" ;?> onclick="update_filter(this.value, 'venue_type')"> Indoor</label>
                              <label><input type="radio" name="venue_type" value="Outdoor" <?php echo (isset($filters[9]) && $filters[9] == "Outdoor")?"checked":"" ;?> onclick="update_filter(this.value, 'venue_type')"> Outdoor</label>
                              </div>
                          </div>
                          <?php
                      }
                      ?>
                  </div>

                    <div class="widget-wrap filter-wrap">

                        <!--<a href='Javascript:void(0);' class='filter-mobile-close'><i class="fa fa-times" aria-hidden="true"></i></a>-->
                        <form class="search-form" method="post">
                            <h4 class="fsz-15 "> Filter <i class="fa fa-filter pull-right" aria-hidden="true"></i></h4>                           

                            <div class="search-selectpicker selectpicker-wrapper">
                                <select class="selectpicker form-control border" data-width="100%" data-toggle="tooltip" onchange="update_filter(this.value, 'categories')">
                                    <option value="">Select Category</option>
                                    <?php
                                    if(!empty($categories))
                                    {
                                        foreach($categories as $cat)
                                        {
                                            ?>
                                            <option value="<?=$cat['id'];?>" <?php echo (isset($filters[4]) && $filters[4] == $cat['id'])?"selected":"" ;?>><?=$cat['title'];?></option>
                                            <?php
                                        }
                                    }
                                    ?>                                    
                                </select>
                            </div>

                            <div class="search-selectpicker selectpicker-wrapper">
                                <select class="selectpicker form-control border" data-width="100%" data-toggle="tooltip" onchange="update_filter(this.value, 'event_types')">
                                    <option value="">Select Event Type</option>
                                    <?php
                                    if(!empty($event_types))
                                    {
                                        foreach($event_types as $et)
                                        {
                                            ?>
                                            <option value="<?=$et->id;?>"  <?php echo (isset($filters[5]) && $filters[5] == $et->id)?"selected":"" ;?>><?=$et->title;?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <?php
                            //echo $filters[4];
                            if(isset($filters[4]) && $filters[4] != 8 && $filters[4] != 7)
                            {                                
                                ?>
                                <div class="search-selectpicker selectpicker-wrapper">
                                    <select class="selectpicker form-control border" data-width="100%" data-toggle="tooltip" onchange="update_filter(this.value, 'areas')">
                                        <option value="">Select Area</option>
                                        <?php
                                        if(!empty($areas))
                                        {
                                            foreach($areas as $area)
                                            {
                                                ?>
                                                <option value="<?=$area->id;?>" <?php echo (isset($filters[3]) && $filters[3] == $area->id)?"selected":"" ;?>><?=$area->title;?></option>
                                                <?php
                                            }
                                        }
                                        ?>                                    
                                    </select>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            //echo $filters[4];
                            if(isset($filters[4]) && $filters[4] != "")
                            {                                
                                ?>
                                <div class="form-group" style="margin-bottom: 0px;" id="quantity">
                                    <div class="row">
                                        <p>No. of People</p>
                                        <div class="col-lg-12">

                                            <input id="quantity_value" placeholder="Quantity" required="" class="form-control" type="text" style="padding-left: 5px;" value="<?php echo (isset($filters[6]) && $filters[6])? $filters[6]:"" ;?>">
                                             <button onclick="update_filter('', 'quantity')" class="btn btn-outline-primary btn-search pull-right" type="button">&nbsp;<i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                        <div class="form-group">
                        <div class="row">
                        <p>Select Date</p>
                        <div class="col-lg-12">
                            <input placeholder="Select Date" required=""  class="form-control datepicker" readonly rel="" style="padding-left: 5px;" value="<?php echo (isset($filters[7]) && $filters[7])? date('d-m-Y', strtotime($filters[7])):"" ;?>" onchange="update_filter(this.value, 'date')" min="<?=date('Y-m-d', strtotime($tdate));?>">
                            </div>
                            </div>
                        </div>                   
                    </form>
                </div>
            </div>
          <div class="col-lg-9 style-one" id="tbody">
            <div class="">
            <div id="postList">
                <?php
                //var_dump($advertisements);
                //var_dump($advertisements[0]->image);
                //echo count($venues);
                //echo $venues_count;

                $venues_count = $this->homemodel->total_venues_count();
                $round = $venues_count/5;
                $str_arr = explode('.',$round);

                $count = $str_arr[0] - $this->session->userdata('v_count');
                if(!empty($venues))
                {
                    foreach($venues as $key => $row)
                    {
                      $block = "no";
                      if(($row['category_id'] != 7 && $row['category_id'] != 8) && $row['capacity_applicable'] == "Yes" && $row['capacity_booked'] >= $row['total_capacity'])
                      {
                        $block = "yes";
                      }
                      //echo $row['total_capacity'];
                      if(($row['capacity_applicable'] == "No" && $row['slots_count'] != 0) || ($row['capacity_applicable'] == "Yes"))
                      {
                    ?>                       
                            
                        <div class="listing-box col-lg-12 col-xs-12 count-div" <?php if($block == "yes"){ ?> style="display: none;" <?php } ?>>
                            <div class="listing-feature">
                                <div class="img" style="background-image: url(&quot;<?=base_url().$row['image'];?>&quot;); background-size: cover;">     
                                </div>
                            </div>
                            <div class="listing-info">
                                <div class="detail">
                                    <h2 class="fsz-20 fw-600"> <?=$row['venue_name'];?> </h2>
                                    <p class="fsz-11 hidden-sm hidden-xs"> <i class="fa fa-map-marker theme-color"></i> <?=$row['address'];?>  </p>
                                    <div class="white-color review"> 
                                        <span class="rating">
                                            <?php
                                            $ratings = round($row['ratings']);
                                            $star_o = 5 - $ratings;
                                            for($i = 1; $i <= $ratings; $i++)
                                            {
                                              ?>
                                              <span class="star active"></span>
                                              <?php
                                            }
                                            for($i = 1; $i <= $star_o; $i++)
                                            {
                                              ?>
                                              <span class="star"></span>
                                              <?php
                                            }
                                            ?>
                                        </span>
                                        <span class="fsz-12 fw-600"> 3250 REVEW </span>
                                    </div>
                                    <hr style="margin: 0; padding: 5px;">
                                    <p><?=substr($row['description'], 0, 150);?> .....</p>
                                    <ul class="list-inline amenities-ul">
                                    <?php
                                    $amenities_images = explode(', ', $row['amenities_images']);
                                    if(!empty($amenities_images))
                                    {
                                        foreach($amenities_images as $ai)
                                        {
                                            ?>
                                            <li><img src="<?=base_url().$ai;?>" height="25" width="25"></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </ul>
                                </div>
                                <div class="booking">
                                    <h2 class="fsz-20 fw-600"><span>&#8377;</span> <?php echo $final_amount = $row['price'] * ((100 - $row['discount_percentage']) / 100); ?>/- <del><span>&#8377;</span><?=$row['price'];?>/-</del></h2>
                                    
                                    <?php
                                    if($row['capacity_applicable'] == "No")
                                    {
                                        ?>
                                        <a href="#" class="fsz-11 fw-600"> <i class="fa fa-users theme-color"></i> <?=$row['slots_count'];?> Slots Left</a><br>
                                        <a href="Javascript:void(0)" class="fsz-11 fw-600"> <i class="fa fa-sitemap theme-color"></i> <?=$row['people_capacity'];?> Capacity</a>
                                        <?php
                                    }
                                    else
                                    {
                                        //echo $row['capacity_booked'];
                                        if(!$row['capacity_booked'])
                                        {
                                            ?>
                                            <a href="Javascript:void(0)" class="fsz-11 fw-600"> <i class="fa fa-users theme-color"></i> <?=$row['people_capacity'];?> Total Capacity</a>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <a href="Javascript:void(0)" class="fsz-11 fw-600"> <i class="fa fa-users theme-color"></i> <?=$row['capacity_booked'];?> Capacity Left</a>
                                        <?php
                                        }
                                    }
                                    $shortlisted = "";
                                    if($row['favourites'] == "yes")
                                    {
                                        $shortlisted = "shortlisted";
                                    }
                                    ?>
                                    <ul class="shortlist">
                                       <li><a class="<?=$shortlisted;?>" href="javascript:void(0)" onclick="add_to_favourites(<?=$row['id'];?>,<?=$row['vendor_id'];?>)"><i class="fa fa-heart" style="margin-right: 0"></i> Shortlist</a></li>
                                       <li><p>
                                       <?php
                                       if($row['booking_type'] == "delayed")
                                       {
                                        echo "Delayed Booking";
                                       }
                                       else
                                       {
                                        echo "Instant Booking";
                                       }
                                       ?>
                                       </p></li>
                                   </ul>
                                   <h2 class="fsz-20 fw-600"><?=$row['venue_type'];?></h2>
                                    
                                   <form class="search-form row" method="post">

                                    <div class="form-group col-md-12 col-sm-6">                                               
                                        <a class="theme-btn" href="javascript:void(0)" onclick="venue_details(<?=$row['id'];?>);"> View Details </a>                                            
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                    //echo $row['id'];                        
                        if(($key + 1) / 5 == 1)
                        {

                        $keyo = ($key +1) / 5;
                        if(isset($advertisements[$count]))
                        {
                            ?>
                            <div class="listing-box col-lg-12 col-xs-12">
                                <img src="<?=base_url().$advertisements[$count]->image;?>">
                            </div>
                            <?php
                        }

                            }
                      }
                }
            }
            else
            {
                ?>
                <div class="listing-box col-lg-12 col-xs-6">
                No Venues found!
                </div>
                <?php
            }
            ?>        
            </div>
            </div>
            <!-- <div style="float: right;"><?php echo $this->ajax_pagination->create_links(); ?></div> -->
        </div>
    </div>
</div>
</section>
<!-- / Page Ends -->      
</article>
<!-- / CONTENT AREA -->
</div>



<!-- / CONTENT AREA -->
<script type="text/javascript">
    function update_filter(val, filter_type)
    {
        //alert(filter_type);exit;
        if(!val && filter_type == "quantity")
        {
            var quantity_value = $("#quantity_value").val();
            //alert(quantity_value);
        }
        $("#wait").show();
        var pageURL = $(location).attr("href");
        var segments = pageURL.split( '/' );
        //alert(segments[7]);exit;
        if ( !segments[7] )
        {
            if(filter_type == "sort"){ var val = val; }else if(filter_type == "veg"){ var val = ','+val; }else if(filter_type == "ac"){ var val = ',,'+val; }else if(filter_type == "areas"){ var val = ',,,'+val; }else if(filter_type == "categories"){ var val = ',,,,'+val;}else if(filter_type == "areas"){ var val = ',,,,,'+val; }else if(filter_type == "event_types"){ var val = ',,,,,'+val; }else if(filter_type == "quantity"){ var val = ',,,,,,'+val; }else if(filter_type == "date"){ var val = ',,,,,,,'+val; }else if(filter_type == "date"){ var val = ',,,,,,,'+val; }else if(filter_type == "booking_type"){ var val = ',,,,,,,,'+val; }else if(filter_type == "venue_type"){ var val = ',,,,,,,,,'+val; }

            var filter = '/?filter='+val;
        }
        else
        {
            var index = segments[7].split("=");
            var filter_values = index[1];
            var values = filter_values.split(",");
            if(filter_type == "sort"){ values[0] = val; }else if(filter_type == "veg"){ values[1] = val; }else if(filter_type == "ac"){ values[2] = val; }else if(filter_type == "areas"){ values[3] = val; }else if(filter_type == "categories"){ values[4] = val; if(val == ""){ values[5] = ""; values[6] = ""; $('#quantity').hide();  } }else if(filter_type == "event_types"){ values[5] = val; }else if(filter_type == "quantity"){ values[6] = quantity_value; }else if(filter_type == "booking_type"){ values[8] = val; }else if(filter_type == "venue_type"){ values[9] = val; }
            else if(filter_type == "date"){ values[7] = val; }
            
            var filter = '/?filter='+values.join(",")
            //var filter = '';
            var pageURL = pageURL.substring(0, pageURL.indexOf('/?'));
        }
        location.href=pageURL+filter;
    }

    function venue_details(venue_id)
    {
        var url = '<?=base_url();?>home/venue_details';
        var pageURL = $(location).attr("href");
        var segments = pageURL.split( '/' );
        if ( !segments[7] )
        {
            location.href=url+'/'+venue_id;
        }
        else
        {
            var index = segments[7].split("=");
            var filter_values = index[1];
            var values = filter_values.split(",");
            if(values[8] || values[7])
            {
                var filter = '/?filter='+values[7]+","+values[7];
            }
            else
            {
                var filter = "";
            }            
            location.href=url+'/'+venue_id+filter;
        }
    }

    function add_to_favourites(venue_id, vendor_id)
    {
        $.ajax( {
            type: 'POST',
            url: "<?=base_url();?>home/add_to_favourites",
            data: {vendor_id:vendor_id, venue_id:venue_id},
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                $("#wait").css("display", "block");
            },
            success: function(data) { //alert(data);exit;
                if(data == 'login')
                {
                  $('#login-modal').modal('show'); 
                   $('#login-modal').show();
                   $('#login-modal').addClass('in');
                   //$('#login-modal .close').hide();
                   $('#login-modal').modal({backdrop:'static', keyboard:false});
                   $("#wait").css("display", "none");
                   return false;
                }
                alert(data);      
                $("#wait").css("display", "none");
                location.reload();
                return false;
            }
        }); 
    }
</script>
<script type="text/javascript">
  $( document ).ready(function() {
  //$('.list-filter').hide();
  $('.sort-button').click(function(){
  $(this).toggleClass("closed")
  $('.list-filter').slideToggle('slow', function() {
  if ($(this).is(':visible')) {
  $('.sort-button').text('Hide Sort & Filter');
  } else {
  $('.sort-button').text('Sort & Filter');
  }
  });

  });
  $('.filter-mobile-close').click(function(){
  $('.list-filter').slideUp();
  $('.sort-button').text('Sort & Filter');
  });
  });
  
  
  $(window).scroll(function() {
  //alert($(window).scrollTop() + $(window).height());
  //alert($(document).height() - 30);
  //  if ($(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
  //    alert();
  // }exit;
  var pageURL = $(location).attr("href");
  var segments = pageURL.split( '/' );
  //alert(segments[6]);
  // if ( !segments[6] )
  // {
  // }exit;
  if($(window).scrollTop() >= $(document).height() - $(window).height()) {
  scrollLoad = false;
  var numItems = $('.count-div').length; //alert(numItems);
  $.ajax({
  type:'post',
  url : '<?php echo base_url(); ?>home/venues_scroll_data/0/'+segments[6],
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
<style type="text/css">
    li a.shortlisted
    {
        color:#7a329d;
    }
    del
    {
      font-size: 13px;
      font-weight: normal;
    }
</style>