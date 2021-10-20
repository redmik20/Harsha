<!-- <div class="col-lg-9 style-one"> -->
    <?php    
    //var_dump($venues);
    //echo $this->session->userdata('v_count');
    $venues_count = $this->homemodel->total_venues_count();
    $round = $venues_count/5;
    $str_arr = explode('.',$round);

    $count = $str_arr[0] - $this->session->userdata('v_count');
    if(!empty($venues))
    {
        foreach($venues as $key => $row)
        {
          $block = "no";
                      if($row['capacity_applicable'] == "Yes" && $row['capacity_booked'] >= $row['total_capacity'])
                      {
                        $block = "yes";
                      }
                      //echo $row['total_capacity'];
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
                                    <p><?=$row['description'];?></p>
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
                                    <h2 class="fsz-20 fw-600"><span>&#8377;</span> <?php echo $final_amount = $row['price'] * ((100 - $row['discount_percentage']) / 100); ?>/-</h2>
                                    
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
        <div class="clearfix"></div>
        <?php
        //echo $row['id'];
            if(($key +1) / 5 == 1)
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
?>        
<!-- </div> -->
<div style="float: right;"><?php echo $this->ajax_pagination->create_links(); ?></div>

<script type="text/javascript">
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
            var filter = '/?filter='+values[7]+","+values[6];
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
                alert(data);      
                $("#wait").css("display", "none");
                location.reload();
                return false;
            }
        }); 
    }
</script>

<style type="text/css">
    li a.shortlisted
    {
        color:#7a329d;
    }
</style>