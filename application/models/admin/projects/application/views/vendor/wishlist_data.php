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
?>