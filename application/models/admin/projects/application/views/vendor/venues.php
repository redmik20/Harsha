<div class="loading" id="wait" style="display:none;width:120px;position:absolute; padding:2px;top:40%; z-index:99999999;left:50%;"><img src='<?=base_url();?>assets/images/load.gif' width="80" height="80" /></div>
<div class="my-3 my-md-5">
  <div class="container">
  <div class="row row-cards row-deck my-venues">
     
        <div class="col-12">
         <div class="page-header">
        <h1 class="page-title">
          My Venues
        </h1>
        </div>
        <?php if($this->session->flashdata('success') != "") : ?>
              <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span class="sr-only">Close</span></button>
                <?=$this->session->flashdata('success');?>
              </div>
            <?php endif; ?>
          <div class="card">
            <div class="table-responsive">
              <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                <thead>
                  <tr>
                    <th class="text-center w-1"><i class="icon-people"></i></th>
                    <th>Venue</th>
                    <th>Adden On</th>
                    <th class="text-center"><i class="icon-settings"></i></th>
                  </tr>
                </thead>
                <tbody id="tbody">
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
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
       
      </div>
  </div>
  </div>
</div>
<style type="text/css">
  .white-color, .white-color a, .white-color a.theme-color:hover {
      color: #fff;
  }
  .listing-box .rating span.star::before {
    font-size: 11px;
}
.rating span.star.active::before {
    color: #7a329d;
    content: "\f005";
}
.rating span.star::before {
    color: #feb200;
    font-size: 15px;
    content: "\f006";
    font-family: FontAwesome;
    -ms-transition: all 0.3s ease-in-out;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}
</style>
<script type="text/javascript">
  $(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() == $(document).height()) {
      var numItems = $('.tr').length;
      $.ajax({
        type:'post',
        url : '<?php echo base_url(); ?>vendor/home/venues_scroll_data',
        data : {numItems:numItems},
        beforeSend: function( xhr ) {
          xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
          $("#wait").css("display", "block");
        },
        success : function(data) { //alert(data);
          $("#tbody").append(data);
          $("#wait").css("display", "none");
          return false;
        }
      });
    }
  });
</script>