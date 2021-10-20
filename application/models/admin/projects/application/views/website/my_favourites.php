<!-- FAQ Starts-->
<section class="sec-space text-center faq light-gray-bg user-panel">
    <div class="container"> 
        <div class="row">
            <?php
            $this->load->view('website/includes/side_menu');
            ?>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <!-- Simple post content example. -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4><a href="#" style="text-decoration:none;"><strong>My Favourites</strong></a></h4> 
                        <hr>
                        <?php if($this->session->flashdata('success') != "") : ?>
                    <div class="alert alert-success" role="alert">
                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                      <?=$this->session->flashdata('success');?>
                    </div>
                  <?php endif; ?>
                  <?php if($this->session->flashdata('failure') != "") : ?>
                    <div class="alert alert-danger" role="alert">
                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                      <?=$this->session->flashdata('failure');?>
                    </div>
                  <?php endif; ?>
                        <div class="post-content">
                            <div class="col-sm-12">
                                <div class="all-courses">
                                    <div class="profile__courses__inner">
                                        <table class="profile-table" style="width:100%">
                                            
                                                
            <?php
            if(!empty($favourites))
            {
                foreach($favourites as $row)
                {
                    ?>
                    <tr>
                    <td class="bookings-list-img" style="width:150px;>"<a href="<?=base_url();?>home/venue_details/<?=$row['id'];?>">
                            <img class="media-object" src="<?=base_url().$row['image'];?>"  style="margin-right:8px; margin-top:-5px;">
                        </a>
                        <a href="javascript:void(0)" onclick="add_to_favourites(<?=$row['id'];?>,<?=$row['vendor_id'];?>)" title="Remove from favourites">
                            <i class="fa fa-heart"></i>
                        </a>
                    </td>
                        <td>
                            <h4 class="pull-left"><a href="<?=base_url();?>home/venue_details/<?=$row['id'];?>" style="text-decoration:none;"><?=$row['venue_name'];?></a></h4> <h4 class="pull-right"><a href="#" style="text-decoration:none;"><i class="fa fa-inr"></i> <?php echo $final_amount = $row['price'] * ((100 - $row['discount_percentage']) / 100); ?>/-</a></h4>
                            <div class="clearfix"></div>
                                <p>
                                    <strong>Address:</strong> <?=$row['address'];?><br>
                                </p>
                                
                            </td>
                        </tr>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <tr>
                    <td>No data available!</td>
                    </tr>    
                    <?php
                }
                ?>

                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</article>
<script type="text/javascript">
    function add_to_favourites(venue_id, vendor_id)
    {        
        $.ajax( {
            type: 'POST',
            url: "<?=base_url();?>home/add_to_favourites",
            data: {vendor_id:vendor_id, venue_id:venue_id},
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                $("#wait").css("display", "block");
            },
            success: function(data) { //alert(data);exit;
                alert(data);      
                $("#wait").css("display", "none");
                location.reload();
                return false;
            }
        }); 
    }
</script>

