 <!-- Footer Start -->
        <footer id="rs-footer" class="rs-footer">
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-12 col-sm-12 footer-widget md-mb-50">
                            <h4 class="widget-title">Explore</h4>
                            <ul class="site-map">
                                <li><a href="<?php echo base_url();?>welcome/privacy_policy">Privacy Policy</a></li>
                                <li><a href="<?php echo base_url();?>welcome/payment_policy">Payments Policy</a></li>
                                <li><a href="<?php echo base_url();?>welcome/terms_conditions">Terms & Conditions</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12 footer-widget md-mb-50">
                            <h4 class="widget-title">Courses</h4>
                            <ul class="site-map">
                                <?php foreach($exams as $exam){?>
                                <li><a href="<?php echo base_url()?>welcome/course_details/<?php echo $exam['id'];?>"><?php echo $exam['name'];?></a> 
                                                     <?php }?> </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12 footer-widget md-mb-50">
                            <h4 class="widget-title">Packages</h4>
                            <ul class="site-map">
                                <li><a href="#">Become A Teacher</a></li>
                                <li><a href="#">Instructor/Student Profile</a></li>
                                <li><a href="#">Courses</a></li>
                                <li><a href="#">Checkout</a></li>
                                
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12 footer-widget">
                            <h4 class="widget-title">Address</h4>
                            <ul class="address-widget">
                                <li>
                                    <i class="fas fa-map"></i>
                                    <div class="desc">6-1-102/3, Street Number 3, Aruna Colony,
                                    Walker Town, Padmarao Nagar,
                                    Secunderabad, Telangana 500025</div>
                                </li>
                                <li>
                                    <i class="fas fa-phone"></i>
                                    <div class="desc">
                                        <a href="tel:+91 7815925940">+91 7815925940</a><br>
                                        <a href="tel:+91 7815925941">+91 7815925941</a>
                                        
                                    </div>
                                </li>
                                <li>
                                    <i class="fas fa-envelope-square"></i>
                                    <div class="desc">
                                        <a href="mailto:studentsupport@platoonline.com">studentsupport@platoonline.com</a>
                                        <a href="mailto:info@platoonline.com">info@platoonline.com</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">                    
                    <div class="row y-middle">
                        <div class="col-lg-4 col-xs-12 md-mb-20">
                            <div class="footer-logo text-center">
                                <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/website/assets/images/plato-logo.png" alt=""></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12 md-mb-20">
                            <div class="copyright text-center">
                                <p>&copy; 2020 All Rights Reserved. PLATO DIGIEDUCATION PVT LTD</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12 text-center">
                            <ul class="footer-social">
                                <li><a href="https://www.facebook.com/Plato-Online-570377633629934" target="_blank"><i class="fab fa-facebook"></i></a></li>
                                <li><a href="https://twitter.com/Plato_Online" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="https://www.instagram.com/platodigieducation/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="https://www.linkedin.com/company/platoonline" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                                <li><a href="https://www.youtube.com/PlatoOnline" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer End -->

        <!-- start scrollUp  -->
        <div id="scrollUp">
            <i class="fa fa-angle-up"></i>
        </div>
        <!-- End scrollUp  -->

        <!-- Search Modal Start -->
        <div aria-hidden="true" class="modal fade search-modal" role="dialog" tabindex="-1">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="flaticon-cross"></span>
            </button>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="search-block clearfix">
                        <form>
                            <div class="form-group">
                                <input class="form-control" placeholder="Search Here..." type="text">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Search Modal End -->

        <!-- modernizr js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/modernizr-2.8.3.min.js"></script>
        <!-- jquery latest version -->
        <script src="<?php echo base_url();?>assets/website/assets/js/jquery.min.js"></script>
        <!-- Bootstrap v4.4.1 js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/bootstrap.min.js"></script>
        <!-- Menu js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/rsmenu-main.js"></script> 
        <!-- op nav js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/jquery.nav.js"></script>
        <!-- owl.carousel js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/owl.carousel.min.js"></script>
        <!-- Slick js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/slick.min.js"></script>
        <!-- isotope.pkgd.min js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/isotope.pkgd.min.js"></script>
        <!-- imagesloaded.pkgd.min js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/imagesloaded.pkgd.min.js"></script>
        <!-- wow js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/wow.min.js"></script>
        <!-- Skill bar js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/skill.bars.jquery.js"></script>
        <script src="<?php echo base_url();?>assets/website/assets/js/jquery.counterup.min.js"></script>        
         <!-- counter top js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/waypoints.min.js"></script>
        <!-- video js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/jquery.mb.YTPlayer.min.js"></script>
        <!-- magnific popup js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/jquery.magnific-popup.min.js"></script>      
        <!-- plugins js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/plugins.js"></script>
        <!-- contact form js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/contact.form.js"></script>
        <!-- main js -->
        <script src="<?php echo base_url();?>assets/website/assets/js/main.js"></script>

        <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    </body>
</html>