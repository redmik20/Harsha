<?php if(!empty($total_subjects)){
                    foreach($total_subjects as $tsubject)
                    {
                      ?>
                      <input type="checkbox"  class="checkbox3" name="qbank_subject_ids[]" value="<?php echo $tsubject['id'];?>" id="qbank_subject_ids" 
                      <?php if(!empty($ex_qbank_subject_ids)){
                      $ex_qbank_subject_ids=explode(',', $package['qbank_subject_ids']);
                      foreach($ex_qbank_subject_ids as $ex_qs_val){
                        if($ex_qs_val == $tsubject['id']){ 
                          echo 'checked'; 
                        }
                      }
                    } ?> >
                       <label for="vehicle1"> <?php echo $tsubject['subject_name'];?></label><br>
                      

                      <?php }
                      }?>