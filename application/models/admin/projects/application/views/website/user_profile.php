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
                    <h4><a href="#" style="text-decoration:none;"><strong>My Profile</strong></a></h4>                    
                    <hr>
                    <div class="post-content">
                        <div class="col-sm-12">
						<div class="all-courses">
							<h3><?=$row->name;?></h3>
							<div class="profile__courses__inner">
                            <table class="profile-table">
                                    <tr><td><i class="fa fa-graduation-cap"></i>Name:</td><td><?=$row->name;?></td></tr>
                                    <tr><td><i class="fa fa-star"></i>Phone:</td><td><?=$row->mobile;?></td></tr>
                                    <tr><td><i class="fa fa-envelope"></i>Email:</td><td><?=$row->email_id;?></td></tr>
                                    <!-- <tr><td><i class="fa fa-map-marker"></i>Address:</td><td>Loreum Dolar sit ameet</td></tr> -->
                                    <!--<tr><td><i class="fa fa-bookmark"></i>Projects:</td>  <td>Map Creation</td></tr>-->
                              </table><br>
                              <a href="<?=base_url('home/edit_profile');?>" class="btn theme-btn">Edit Profile</a>
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
<!-- / FAQ Ends -->
</article>
<!-- / CONTENT AREA -->
