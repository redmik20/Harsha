<div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Select In Stock</label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <select class="form-control" id="in_stock_id" name="in_stock_id" required="" >
                              <option value="">Please select</option>  

                               <?php
                                if(!empty($in_stock))
                                {
                                  foreach($in_stock as $in)
                                  {
                                    ?>
                                    <option value="<?=$in['id'];?>"><?=$in['stock_name'];?> -- (<?php echo $in['count']?>)</option>
                                    <?php
                                  }
                                }
                                ?>  
                                                                               
                              </select>
                            </div>
                          </div>            
                        </div>                  
                      </div>

                      <!-- <div class="row">
                        <div class="col-lg-9 col-xs-12 col-sm-9 col-md-9 col-lg-offset-1">                  
                          <div class="row form-group frm-btm">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
                              <label class="input-text">Stock Count<span class="red bigger-120">*</span></label>
                            </div>
                            <div class="col-lg-1 col-xs-1 col-sm-1 col-md-1 input-text"> : </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 word-brk">
                              <input class="form-control" name="stock_count" id="stock_count" value="" >
                            </div>
                          </div>            
                        </div>                  
                      </div> -->