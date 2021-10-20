<div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <h1 class="page-title">
                Dashboard
              </h1>
            </div>
            <div class="row row-cards main-cat">
          
              <div class="col-6 col-sm-4 col-lg-2">
                  <a href="javascript:void(0)" class="link">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-warning">
                      <?=$dashboard['online_bookings_count'];?>
                    </div>
                    <div class="h1 m-0 color-yellow"><i class="fe fe-eye" data-toggle="tooltip" title="Online"></i><br />Online</div>
                    <div class="text-muted"> Bookings</div>
                    <a href="<?=base_url();?>vendor/bookings?status=pending" class="badge badge-warning">View</a>
                  </div>
                </div>
                  </a>
              </div>

              <div class="col-6 col-sm-4 col-lg-2">
                <a href="javascript:void(0)" class="link">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-green">
                      <?=$dashboard['offline_bookings_count'];?>
                    </div>
                    <div class="h1 m-0 color-red"><i class="fe fe-eye-off" data-toggle="tooltip" title="Offline"></i><br />Offline</div>
                    <div class="text-muted">Bookings</div>
                     <a href="<?=base_url();?>vendor/bookings?status=offline" class="badge badge-success">View</a>
                  </div>
                </div>
                </a>
              </div>              

              <div class="col-6 col-sm-4 col-lg-2">
                <a href="javascript:void(0)" class="link">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-red">
                      <?=$dashboard['cancelled_by_user_count'];?>
                    </div>
                    <div class="h1 m-0"><i class="fe fe-x-circle" data-toggle="Tooltip" title="Cancelled"></i><br />Cancelled</div>
                    <div class="text-muted">Bookings</div>
                    <a href="<?=base_url();?>vendor/bookings?status=user" class="badge badge-danger">View</a>
                  </div>
                </div>
                </a>
              </div>
              
              <div class="col-6 col-sm-4 col-lg-2">
                <a href="javascript:void(0)" class="link">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-green">
                      <?=$dashboard['shortlists_count'];?>
                    </div>
                    <div class="h1 m-0"><i class="fe fe-heart" data-toggle="Wishlisted" title="fe fe-heart"></i> <br />Wishlists</div>
                    <div class="text-muted">Users Wishlisted</div>
                    <a href="<?=base_url();?>vendor/wishlist" class="badge badge-success">View</a>
                  </div>
                </div>
                </a>
              </div>

              <div class="col-6 col-sm-4 col-lg-2">
                <a href="<?=base_url();?>vendor/add_venue" class="link">
                  <div class="card bg-primary b-r-30">
                    <div class="card-body p-3  text-center">
                      <!--<div class="text-right text-green">
                        60
                      </div>-->
                      <div class="h1 m-0 text-white"><i class="fe fe-plus-circle" data-toggle="tooltip" title="fe fe-plus-circle"></i> <br />Add Venue</div>
                      <div class="text-muted">New Venue</div>
                      <!--<a href="#" class="badge badge-primary">View</a>-->
                    </div>
                  </div>
                </a>
              </div>

            </div>

            <div class="alert alert-danger">
              <div class="page-header">
                <h1 class="page-title">
                  My History
                </h1>
              </div>
            <div class="row row-cards main-cat">
          
              <div class="col-6 col-sm-4 col-lg-2">
                  <a href="javascript:void(0)" class="link">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-warning">
                      <?=$dashboard['accepted_count'];?>                     
                    </div>
                    <div class="h1 m-0 color-yellow"><i class="fe fe-check" data-toggle="tooltip" title="Accepted"></i><br />Accepted</div>
                    <div class="text-muted">By Vendor</div>
                    <a href="<?=base_url();?>vendor/bookings?status=accepted" class="badge badge-warning">View</a>
                  </div>
                </div>
                  </a>
              </div>

              <div class="col-6 col-sm-4 col-lg-2">
                <a href="javascript:void(0)" class="link">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-green">
                      <?=$dashboard['rejected_count'];?>
                    </div>
                    <div class="h1 m-0 color-red"><i class="fe fe-alert-octagon" data-toggle="tooltip" title="Rejected"></i><br />Rejected</div>
                    <div class="text-muted">By Vendor</div>
                     <a href="<?=base_url();?>vendor/bookings?status=rejected" class="badge badge-success">View</a>
                  </div>
                </div>
                </a>
              </div>              

              <div class="col-6 col-sm-4 col-lg-2">
                <a href="javascript:void(0)" class="link">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-red">
                      <?=$dashboard['cancelled_by_vendor_count'];?>
                    </div>
                    <div class="h1 m-0"><i class="fe fe-x-circle" data-toggle="Tooltip" title="Cancelled"></i><br />Cancelled</div>
                    <div class="text-muted">By Vendor</div>
                    <a href="<?=base_url();?>vendor/bookings?status=vendor" class="badge badge-danger">View</a>
                  </div>
                </div>
                </a>
              </div>
              
              <div class="col-6 col-sm-4 col-lg-2">
                <a href="<?=base_url();?>vendor/cancellation_policy" class="link">
                  <div class="card bg-primary b-r-30">
                    <div class="card-body p-3  text-center">
                      <!--<div class="text-right text-green">
                        60
                      </div>-->
                      <div class="h1 m-0 text-white"><i class="fe fe-plus-circle" data-toggle="tooltip" title="fe fe-plus-circle"></i> <br />Add Cancellation</div>
                      <div class="text-muted">Policy</div>
                      <!--<a href="#" class="badge badge-primary">View</a>-->
                    </div>
                  </div>
                </a>
              </div>

            </div>
            </div>
            <!--<div class="row row-cards row-deck">
              <div class="col-lg-6">
                <div class="card card-aside">
                  <a href="#" class="card-aside-column" style="background-image: url(./demo/photos/david-klaasen-54203-500.jpg)"></a>
                  <div class="card-body d-flex flex-column">
                    <h4><a href="#">And this isn't my nose. This is a false one.</a></h4>
                    <div class="text-muted">Look, my liege! The Knights Who Say Ni demand a sacrifice! …Are you suggesting that coconuts migr...</div>
                    <div class="d-flex align-items-center pt-5 mt-auto">
                      <div class="avatar avatar-md mr-3" style="background-image: url(./demo/faces/female/18.jpg)"></div>
                      <div>
                        <a href="./profile.html" class="text-default">Rose Bradley</a>
                        <small class="d-block text-muted">3 days ago</small>
                      </div>
                      <div class="ml-auto text-muted">
                        <a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-heart mr-1"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card card-aside">
                  <a href="#" class="card-aside-column" style="background-image: url(./demo/photos/david-marcu-114194-500.jpg)"></a>
                  <div class="card-body d-flex flex-column">
                    <h4><a href="#">Well, I didn't vote for you.</a></h4>
                    <div class="text-muted">Well, we did do the nose. Why? Shut up! Will you shut up?! You don't frighten us, English pig-dog...</div>
                    <div class="d-flex align-items-center pt-5 mt-auto">
                      <div class="avatar avatar-md mr-3" style="background-image: url(./demo/faces/male/16.jpg)"></div>
                      <div>
                        <a href="./profile.html" class="text-default">Peter Richards</a>
                        <small class="d-block text-muted">3 days ago</small>
                      </div>
                      <div class="ml-auto text-muted">
                        <a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-heart mr-1"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>-->
            <div class="row row-cards row-deck my-venues">
           
              <div class="col-12">
               <div class="page-header">
              <h1 class="page-title">
                My Venues
              </h1>
              </div>
                <div class="card">
                  <div class="table-responsive">
                    <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                      <thead>
                        <tr>
                          <th class="text-center w-1"><i class="icon-people"></i></th>
                          <th>Venue</th>
                          <th>Added On</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php
                      if(isset($dashboard['venues']))
                      {
                        foreach($dashboard['venues'] as $key => $venues)
                        {
                          if($key <= 1)
                          {
                            ?>
                            <tr>
                              <td class="text-center">
                                <div class="avatar d-block" style="background-image: url(<?=base_url().$venues->image;?>)">
                                  <span class="avatar-status bg-yellow"></span>
                                </div>
                              </td>
                              <td>
                                <div><?=$venues->venue_name;?></div>
                                <div class="small text-muted">
                                 <?=substr($venues->description, 0, 70);?>...
                                </div>
                              </td>
                              <td>
                                <div class="small text-muted">Date</div>
                                <div><?=date('d F Y', strtotime($venues->created_on));?></div>
                              </td>
                              
                            </tr>
                            <?php
                          }
                        }
                      }
                      ?>
                      </tbody>
                    </table>

                  </div>
                </div>
                
                    <div class="form-footer">
                         <a class="btn btn-primary btn-block col-lg-3 pull-right" href="<?=base_url();?>vendor/venues">View All</a>
                       </div>
              </div>
              <div class="clearfix"></div>
             
            </div>
          </div>
        </div>
      </div>