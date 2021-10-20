<?php
                  /*if(!empty($total_subjects))
                  {
                    foreach($total_subjects as $tsubject)
                    {
                      ?>
                      <option value="<?php echo $tsubject['id'];?>" 
                     <?php 
                     $ex_video_subject_ids=explode(',', $package['video_subject_ids']);
                     foreach($ex_video_subject_ids as $ex_vs_val){
                        if($ex_vs_val == $tsubject['id']){ 
                          echo 'selected'; 
                        }
                      }?>
                      ><?php echo $tsubject['subject_name'];?></option>
                      <?php
                    }
                  }*/
                  ?>

<?php if(!empty($total_subjects))
                  {
                    foreach($total_subjects as $tsubject)
                    {
                      ?>
                      <input type="checkbox"  class="checkbox2" name="video_subject_ids[]" value="<?php echo $tsubject['id'];?>" id="video_subject_ids" 
                      <?php if(!empty($ex_video_subject_ids)){
                        $ex_video_subject_ids=explode(',', $package['video_subject_ids']);
                        foreach($ex_video_subject_ids as $ex_vs_val){
                          if($ex_vs_val == $tsubject['id']){ 
                            echo 'checked'; 
                          }
                        } 
                    }
                      ?> >
                       <label for="vehicle1"> <?php echo $tsubject['subject_name'];?></label><br>
                      

                      <?php }
                      }?>