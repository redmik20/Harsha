<?php $uri = $this->uri->segment(2);?>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="list-group">
        <a class="list-group-item <?php if($uri == "user_profile" || $uri == "edit_profile"){ ?> active <?php } ?>" href="<?=base_url();?>home/user_profile"><i class="fa fa-user" aria-hidden="true"></i>  My Profile <?php if($uri == "user_profile"){ ?><span class="pull-right"> <i class="fa fa-arrow-right" aria-hidden="true"></i></span><?php } ?></a>

        <a class="list-group-item <?php if($uri == "user_bookings"){ ?> active <?php } ?>" href="<?=base_url();?>home/user_bookings"><i class="fa fa-shopping-cart"></i> My Booking <?php if($uri == "user_bookings"){ ?><span class="pull-right"> <i class="fa fa-arrow-right" aria-hidden="true"></i></span><?php } ?></a>
        
        <a class="list-group-item <?php if($uri == "my_favourites"){ ?> active <?php } ?>" href="<?=base_url();?>home/my_favourites"><i class="fa fa-heart"></i> My Favourite <?php if($uri == "my_favourites"){ ?><span class="pull-right"> <i class="fa fa-arrow-right" aria-hidden="true"></i></span><?php } ?></a>

        <a class="list-group-item <?php if($uri == "change_password"){ ?> active <?php } ?>" href="<?=base_url();?>home/change_password"><i class="fa fa-key"></i>  Change Password <?php if($uri == "change_password"){ ?><span class="pull-right"> <i class="fa fa-arrow-right" aria-hidden="true"></i></span><?php } ?></a>

        <a class="list-group-item <?php if($uri == "submit_form"){ ?> active <?php } ?>" href="<?=base_url();?>home/submit_form"><i class="fa fa-envelope"></i>  Submit Form <?php if($uri == "submit_form"){ ?><span class="pull-right"> <i class="fa fa-arrow-right" aria-hidden="true"></i></span><?php } ?></a>

        <a class="list-group-item" href="<?=base_url();?>home/user_logged_out"><i class="fa fa-power-off" aria-hidden="true"></i>  Logout</a>
    </div>    
</div>