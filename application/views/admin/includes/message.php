<?php if($this->session->flashdata('success') != ''){?>
                                    <div class="alert alert-block alert-success">
                                        <button type="button" class="close" data-dismiss="alert">
                                        <i class="fa fa-close"></i>
                                        </button>
                                        <p>
                                            <i class="icon-ok"></i>
                                            <?php echo $this->session->flashdata('success')?$this->session->flashdata('success'):'';?>
                                        </p>
                                    </div>
                             <?php } ?>
                               <?php if($this->session->flashdata('error') != ''){?>
                                    <div class="alert alert-block alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">
                                        <i class="fa fa-close"></i>
                                        </button>
                                        <p>
                                            <i class="icon-ok"></i>
                                            <?php echo $this->session->flashdata('error')?$this->session->flashdata('error'):'';?>
                                        </p>
                                    </div>
                             <?php } ?>