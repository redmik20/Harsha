<?php if(!empty($total_test_series))
                  {
                    foreach($total_test_series as $ts)
                    {
                      ?>
                      <input type="checkbox"  class="checkbox4" name="test_series_ids[]" value="<?php echo $ts['id'];?>" id="test_series_ids" 
                      <?php if(!empty($ex_test_series_ids)){
                      $ex_test_series_ids=explode(',', $package['test_series_ids']);

                      foreach($ex_test_series_ids as $ex_vs_val){
                        if($ex_vs_val == $ts['id']){ 
                          echo 'checked'; 
                        }
                      }
                    } ?> >
                       <label for="vehicle1"> <?php echo $ts['title'];?></label><br>
                      

                      <?php }
                      }?>