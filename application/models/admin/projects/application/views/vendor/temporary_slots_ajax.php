<div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px; z-index:99999999"><img src='<?=base_url();?>assets/img/demo_wait.gif' width="64" height="64" /></div>
<?php
          if(!empty($slots))
          {
            ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Time</th>
                  <!-- <th scope="col">Capacity</th> -->
                  <th scope="col">Price</th>
                  <th scope="col">Edit</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach($slots as $key=>$slot)
                {
                  ?>
                  <tr>
                    <th scope="row"><?=$key+1;?></th>
                    <input type="hidden" name="slot_id[]" id="slot_id" value="<?=$slot['slot_id'];?>">
                    <td><?=date('h:i A', strtotime($slot['start_time']));?> - <?=date('h:i A', strtotime($slot['end_time']));?></td>
                    <input type="hidden" name="start_time[]" id="start_time" value="<?=$slot['start_time'];?>">
                    <input type="hidden" name="end_time[]" id="end_time" value="<?=$slot['end_time'];?>">
                    <!-- <td><?=$slot['slot_capacity'];?></td> -->
                    <input type="hidden" name="slot_capacity[]" id="slot_capacity" value="<?=$slot['slot_capacity'];?>">
                    <td><?=$slot['amount'];?>/-</td>
                    <td class="input"><input type="text" class="form-control" placeholder="Update Temporary Price" id="amount" name="amount[]" value="<?=$slot['amount'];?>" /></td>
                  </tr>
                  <?php
                }
              ?>
              </tbody>
            </table>
            
            <?php
          }
          else
          {
            echo "No slots available!";
          }
          ?>