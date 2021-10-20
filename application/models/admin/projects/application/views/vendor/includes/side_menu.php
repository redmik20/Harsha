<?php
$url = explode('=', $_SERVER['REQUEST_URI']);
$status = "";
if(isset($url[1]))
{
  $status = $url[1];
}
?>
<div class="list-group list-group-transparent mb-0">
  <a href="<?=base_url();?>vendor/bookings?status=pending" class="list-group-item list-group-item-action <?php echo ($status == "pending")?"active":"";?>"><span class="icon mr-3"><i class="fe fe-eye"></i></span>Online Booking</a>
  <a href="<?=base_url();?>vendor/bookings?status=offline" class="list-group-item list-group-item-action <?php echo ($status == "offline")?"active":"";?>"><span class="icon mr-3"><i class="fe fe-eye-off"></i></span>Offline Bookings</a>
  <a href="<?=base_url();?>vendor/bookings?status=user" class="list-group-item list-group-item-action <?php echo ($status == "user")?"active":"";?>"><span class="icon mr-3"><i class="fe fe-x-circle"></i></span>Cancelled</a>
</div>
</div>
<div class="col-9">
  <div class="page-header">
    <h1 class="page-title">
      Booked Online
    </h1>
  </div>