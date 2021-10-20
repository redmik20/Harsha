<!DOCTYPE html>
<html lang="zxx">  
<head>
        <!-- meta tag -->
        <meta charset="utf-8">
        <title>Plato Online</title>
        <meta name="description" content="">
        <!-- responsive tag -->
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- favicon -->
        <link rel="apple-touch-icon" href="apple-touch-icon.html">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/website/assets/images/favicon.png">

        <!-- Bootstrap v4.4.1 css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/website/assets/css/bootstrap.min.css">
        <!-- font-awesome css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/website/assets/css/font-awesome.min.css">
        <!-- animate css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/website/assets/css/animate.css">
        <!-- owl.carousel css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/website/assets/css/owl.carousel.css">
        <!-- slick css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/website/assets/css/slick.css">
        <!-- off canvas css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/website/assets/css/off-canvas.css">
        <!-- linea-font css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/website/assets/fonts/linea-fonts.css">
        <!-- flaticon css  -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/website/assets/fonts/flaticon.css">
        <!-- magnific popup css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/website/assets/css/magnific-popup.css">
        <!-- Main Menu css -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/website/assets/css/rsmenu-main.css">
        <!-- spacing css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/website/assets/css/rs-spacing.css">
        <!-- style css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/website/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/website/assets/css/responsive.css">
        <script src="https://use.fontawesome.com/993c706b3f.js"></script>
        
    </head>
    <body class="defult-home">
        
        <!--Preloader area start here-->
        <div id="loader" class="loader">
            <div class="loader-container">
                <div class='loader-icon'>
                    <img src="<?php echo base_url();?>assets/website/assets/images/plato-logo.png" alt="">
                </div>
            </div>
        </div>
        <!--Preloader area End here--> 


        <!--Full width header Start-->
        <div class="full-width-header header-style1 home1-modifiy">
            <!--Header Start-->
            <header id="rs-header" class="rs-header">
                <!-- Topbar Area Start -->
                <!-- <div class="topbar-area dark-parimary-bg">
                    <div class="container">
                        <div class="row y-middle">
                            <div class="col-md-7">
                                <ul class="topbar-contact">
                                    <li>
                                        <i class="flaticon-email"></i>
                                        <a href="mailto:support@rstheme.com">support@rstheme.com</a>
                                    </li>
                                    <li>
                                        <i class="flaticon-location"></i>
                                        374 William S Canning Blvd, MA 2721, USA
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-5 text-right">
                                <ul class="topbar-right">
                                    <li class="login-register">
                                        <i class="fa fa-sign-in"></i>
                                        <a href="login.html">Login</a>/<a href="register.html">Register</a>
                                    </li>
                                    <li class="btn-part">
                                        <a class="apply-btn" href="#">Apply Now</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- Topbar Area End -->

                <!-- Menu Start -->
                <div class="menu-area menu-sticky">
                    <div class="container">
                        <div class="row y-middle">
                            <div class="col-lg-2">
                              <div class="logo-cat-wrap">
                                  <div class="logo-part">
                                      <a href="<?php echo base_url();?>">
                                          <img src="<?php echo base_url();?>assets/website/assets/images/plato-logo.png" alt="">
                                      </a>
                                  </div>
                              </div>
                            </div>
                            <div class="col-lg-8 text-right">
                                <div class="rs-menu-area">
                                    <div class="main-menu">
                                      <div class="mobile-menu">
                                          <a class="rs-menu-toggle">
                                              <i class="fas fa-bars"></i>
                                          </a>
                                      </div>
                                      <nav class="rs-menu">
                                         <ul class="nav-menu">
                                            <li class="menu-item-has-children"><a href="<?php echo base_url();?>">Home</a></li>
                                            <li class="menu-item-has-children">
                                                <a href="<?php echo base_url();?>welcome/about_us">About</a></li>

                                            <li class="menu-item-has-children">
                                                 <a href="#">Courses &nbsp;<i class='fas fa-angle-down'></i></a>
                                                 <ul class="sub-menu">
                                                    <?php foreach($exams as $exam){?>
                                                     <li><a href="<?php echo base_url()?>welcome/course_details/<?php echo $exam['id'];?>"><?php echo $exam['name'];?></a> 
                                                     <?php }?> </li>
                                                 </ul>
                                            </li>

                                            <li class="menu-item-has-children">
                                                 <a href="#">Packages</a>
                                            </li>

                                             <li class="menu-item-has-children">
                                                 <a href="#">Polices &nbsp;<i class='fas fa-angle-down'></i></a>
                                                 <ul class="sub-menu">
                                                     <li><a href="<?php echo base_url();?>welcome/privacy_policy">Privacy Policy</a></li>
                                                     <li><a href="<?php echo base_url();?>welcome/payment_policy">Payments Policy</a></li>
                                                     <li><a href="<?php echo base_url();?>welcome/terms_conditions">Terms & Conditions</a></li>
                                                 </ul>
                                             </li>

                                             <li class="menu-item-has-children">
                                                 <a href="<?php echo base_url();?>welcome/contact_us">Contact</a></li>
                                         </ul> <!-- //.nav-menu -->
                                      </nav>                                        
                                    </div> <!-- //.main-menu -->                                
                                </div>
                            </div>
                            <!-- <div class="col-lg-2 text-right">
                                <div class="expand-btn-inner">
                                    <ul>
                                        <li>
                                            <a class="hidden-xs rs-search" data-target=".search-modal" data-toggle="modal" href="#">
                                                <i class="flaticon-search"></i>
                                            </a>
                                        </li>
                                        <li class="icon-bar cart-inner no-border mini-cart-active">
                                            <a class="cart-icon">
                                                <i class="fa fa-shopping-bag"></i>
                                            </a>
                                            <div class="woocommerce-mini-cart text-left">
                                                <div class="cart-bottom-part">
                                                    <ul class="cart-icon-product-list">
                                                        <li class="display-flex">
                                                            <div class="icon-cart">
                                                                <a href="#"><i class="fa fa-times"></i></a>
                                                            </div>
                                                            <div class="product-info">
                                                                <a href="cart.html">Law Book</a><br>
                                                                <span class="quantity">1 × $30.00</span>
                                                            </div>
                                                            <div class="product-image">
                                                                <a href="cart.html"><img src="<?php echo base_url();?>assets/website/assets/images/shop/1.jpg" alt="Product Image"></a>
                                                            </div>
                                                        </li>
                                                        <li class="display-flex">
                                                            <div class="icon-cart">
                                                                <a href="#"><i class="fa fa-times"></i></a>
                                                            </div>
                                                            <div class="product-info">
                                                                <a href="cart.html">Spirit Level</a><br>
                                                                <span class="quantity">1 × $30.00</span>
                                                            </div>
                                                            <div class="product-image">
                                                                <a href="cart.html"><img src="<?php echo base_url();?>assets/website/assets/images/shop/2.jpg" alt="Product Image"></a>
                                                            </div>
                                                        </li>
                                                    </ul>

                                                    <div class="total-price text-center">
                                                        <span class="subtotal">Subtotal:</span>
                                                        <span class="current-price">$85.00</span>
                                                    </div>

                                                    <div class="cart-btn text-center">
                                                        <a class="crt-btn btn1" href="cart.html">View Cart</a>
                                                        <a class="crt-btn btn2" href="checkout.html">Check Out</a>
                                                    </div>
                                                </div>
                                            </div> 
                                        </li>
                                    </ul>
                                    <span><a id="nav-expander" class="nav-expander style3">
                                        <div class="bar">
                                            <span class="dot1"></span>
                                            <span class="dot2"></span>
                                            <span class="dot3"></span>
                                        </div>
                                    </a></span>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <!-- Menu End --> 

                <!-- Canvas Menu start -->
                <!-- <nav class="right_menu_togle hidden-md">
                    <div class="close-btn">
                        <span id="nav-close">
                            <div class="line">
                                <span class="line1"></span><span class="line2"></span>
                            </div>
                        </span>
                    </div>
                    <div class="canvas-logo">
                        <a href="index.html"><img src="<?php echo base_url();?>assets/website/assets/images/logo-dark.png" alt="logo"></a>
                    </div>
                    <div class="offcanvas-text">
                        <p>We denounce with righteous indige nationality and dislike men who are so beguiled and demo  by the charms of pleasure of the moment data com so blinded by desire.</p>
                    </div>
                    <div class="offcanvas-gallery">
                        <div class="gallery-img">
                            <a class="image-popup" href="<?php echo base_url();?>assets/website/assets/images/gallery/1.jpg"><img src="assets/images/gallery/1.jpg" alt=""></a>
                        </div>
                        <div class="gallery-img">
                            <a class="image-popup" href="<?php echo base_url();?>assets/website/assets/images/gallery/2.jpg"><img src="assets/images/gallery/2.jpg" alt=""></a>
                        </div>
                        <div class="gallery-img">
                            <a class="image-popup" href="<?php echo base_url();?>assets/website/assets/images/gallery/3.jpg"><img src="assets/images/gallery/3.jpg" alt=""></a>
                        </div>
                        <div class="gallery-img">
                            <a class="image-popup" href="<?php echo base_url();?>assets/website/assets/images/gallery/4.jpg"><img src="assets/images/gallery/4.jpg" alt=""></a>
                        </div>
                        <div class="gallery-img">
                            <a class="image-popup" href="<?php echo base_url();?>assets/website/assets/images/gallery/5.jpg"><img src="assets/images/gallery/5.jpg" alt=""></a>
                        </div>
                        <div class="gallery-img">
                            <a class="image-popup" href="<?php echo base_url();?>assets/website/assets/images/gallery/6.jpg"><img src="assets/images/gallery/6.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="map-img">
                        <img src="<?php echo base_url();?>assets/website/assets/images/map.jpg" alt="">
                    </div>
                    <div class="canvas-contact">
                        <ul class="social">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </nav> -->
                <!-- Canvas Menu end -->
            </header>
            <!--Header End-->
        </div>
        <!--Full width header End-->