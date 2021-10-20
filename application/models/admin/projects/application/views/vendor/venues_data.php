<?php
if(!empty($venues))
{
  foreach($venues as $row)
  {
    ?>
    <tr class="tr">
      <td class="text-center">
        <div class="avatar d-block" style="background-image: url(<?=base_url().$row->image;?>)">
          <span class="avatar-status bg-yellow"></span>
        </div>
      </td>
      <td>
        <div><?=$row->venue_name;?></div>
        <div class="small text-muted">
         <?=$row->address;?>
        </div>
        <div class="white-color review"> 
          <span class="rating">
              <?php
              $ratings = round($row->ratings);
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
      </div>
      </td>
      <td>
        <div class="small text-muted">Created Date</div>
        <div><?=date('d F Y h:i A', strtotime($row->created_on));?></div>
      </td>
      <td class="text-center">
        <div class="item-action dropdown">
          <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
          <div class="dropdown-menu dropdown-menu-right">
            
            <?php
            if($row->category_id == 4 || $row->category_id == 9 || $row->category_id == 10 || $row->category_id == 5 || $row->category_id == 6)
            {
              ?>
              <a href="<?=base_url();?>vendor/temporary_slots/<?=$row->id;?>" class="dropdown-item"><i class="dropdown-icon fe fe-dollar-sign"></i> Temporary Slots</a>
              <div class="dropdown-divider"></div>
              <a href="<?=base_url();?>vendor/book_offline/<?=$row->id;?>" class="dropdown-item"><i class="dropdown-icon fe fe-eye-off"></i> Book Offline</a>
              <a href="<?=base_url();?>vendor/calendar/<?=$row->id;?>" class="dropdown-item"><i class="dropdown-icon fe fe-calendar"></i> Calendar</a>
              <?php
            }
            ?>
            <a href="<?=base_url();?>vendor/edit_venue/<?=$row->id;?>" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Edit </a>
            <a href="<?=base_url();?>vendor/home/delete_venue/<?=$row->id;?>" class="dropdown-item"><i class="dropdown-icon fe fe-delete"></i> Delete </a>
          </div>
        </div>
      </td>
    </tr>
    <?php
  }
}
?>