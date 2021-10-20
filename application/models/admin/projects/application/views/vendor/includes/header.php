<!-- <?php
$url = explode('=', $_SERVER['REQUEST_URI']);
$status = "";
if(isset($url[1]))
{
  $status = $url[1];
}
?> -->
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/website/images/icons/logo-icon.png">   
    <input type="hidden" id="base" value="<?php echo base_url(); ?>">
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title>Smart Venue | Vendor Panel</title>
    <!-- Dashboard Core -->
    <link href="<?=base_url();?>assets/vendor/assets/css/dashboard.css" rel="stylesheet" />
    <!-- <script src="<?=base_url();?>assets/vendor/assets/js/dashboard.js"></script> -->
    <!-- c3.js Charts Plugin -->
    <link href="<?=base_url();?>assets/vendor/assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
    <!-- <script src="<?=base_url();?>assets/vendor/assets/plugins/charts-c3/plugin.js"></script> -->
    <!-- Google Maps Plugin -->
    <link href="<?=base_url();?>assets/vendor/assets/plugins/maps-google/plugin.css" rel="stylesheet" />
    <!-- Date Picker-->
    <!--<link rel='stylesheet' href='<?=base_url();?>assets/website/css/plugin/datepicker.css'>-->    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    
    <!-- <script src="<?=base_url();?>assets/vendor/assets/js/vendors/jquery-3.2.1.min.js"></script>
       
       <script type="text/javascript">
if (typeof jQuery == 'undefined')
    document.write(unescape("%3Cscript src="<?=base_url();?>assets/vendor/assets/js/vendors/jquery-3.2.1.min.js" type='text/javascript'%3E%3C/script%3E"));
</script> -->

    <link href="<?=base_url();?>assets/vendor/plugins/select2/css/select2.css" rel="stylesheet" type="text/css" />
    <script src="<?=base_url();?>assets/vendor/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="<?=base_url();?>assets/vendor/plugins/select2/js/select2-script.js" type="text/javascript"></script> 
   
      <script type="text/javascript">
window.onload = function()
{
    if (window.jQuery)
    {
        // alert('jQuery is loaded');
        // location.reload();
    }
    else
    {
        alert('jQuery is not loaded');
        location.reload();
    }
}
</script>
  </head>
  <body class="">  
    <div class="page">
      <div class="page-main">
        <div class="header py-4">
                  <div class="container">
                    <div class="d-flex">
                      <a class="header-brand" href="<?=base_url();?>vendor/dashboard">
                       <img src="<?=base_url();?>assets/vendor/assets/images/logo/vendor-logo.png" />
                      </a>
                      <div class="d-flex order-lg-2 ml-auto">
                        <div class="dropdown">
                          <a href="javascript:void(0)" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                            <!-- <span class="avatar" style="background-image: url(./demo/faces/female/25.jpg)"></span> -->
                            <span class="ml-2 d-none d-lg-block">
                              <span class="text-default"> <?=$profile->name;?> </span>
                              <small class="text-muted d-block mt-1">Vendor</small>
                            </span>
                            
                            <span class="ml-2 d-none d-xs-block mobile-vendor">
                              <i class="fa fa-user"></i>
                            </span>
                            
                            
                          </a>
                           <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="<?=base_url();?>vendor/edit_profile">
                      <i class="dropdown-icon fe fe-user"></i> Profile
                    </a>
                    <a class="dropdown-item" href="<?=base_url();?>vendor/change_password">
                      <i class="dropdown-icon fe fe-lock"></i> Change Password
                    </a>                   
                    <a class="dropdown-item" href="<?=base_url();?>vendor/home/vendor_logged_out">
                      <i class="dropdown-icon fe fe-log-out"></i> Sign out
                    </a>
                  </div>
                        </div>
                      </div>
                      <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                        <span class="header-toggler-icon"></span>
                      </a>
                    </div>
                  </div>
                </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="navbar">
            <div class="row align-items-center">
              <!-- <div class="col-lg-3 ml-auto">
                <form class="input-icon my-3 my-lg-0">
                  <input type="search" class="form-control header-search" placeholder="Search Venues&hellip;" tabindex="1" id="search-box">
                  <div id="suggesstion-box"><ul id="subject-list"></div>
                  <div class="input-icon-addon">
                    <i class="fe fe-search"></i>
                  </div>
                </form>
              </div> -->
              <?php $uri = $this->uri->segment(2);?>
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="<?=base_url();?>vendor/dashboard" class="nav-link <?php echo ($uri == "dashboard")?"active":"";?>"><i class="fe fe-home"></i> Dashboard</a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link <?php echo ($status == "pending" || $status == "offline" || $status == "user")?"active":"";?>" data-toggle="dropdown"><i class="fe fe-user"></i> User Bookings &nbsp;<i class="fe fe-chevron-down"></i></a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="<?=base_url();?>vendor/bookings?status=pending" class="dropdown-item "><i class="fe fe-eye" data-toggle="tooltip" title="Online"></i> Online</a>
                      <a href="<?=base_url();?>vendor/bookings?status=offline" class="dropdown-item "><i class="fe fe-eye-off" data-toggle="tooltip" title="Ofline"></i> Offline</a>
                      <a href="<?=base_url();?>vendor/bookings?status=user" class="dropdown-item "><i class="fe fe-x-circle" data-toggle="tooltip" title="Cancelled"></i> Cancelled</a>
                    </div>
                  </li>

                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link <?php echo ($status == "accepted" || $status == "rejected" || $status == "vendor")?"active":"";?>" data-toggle="dropdown"><i class="fe fe-user-plus"></i> Vendor History &nbsp;<i class="fe fe-chevron-down"></i></a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="<?=base_url();?>vendor/bookings?status=accepted" class="dropdown-item "><i class="fe fe-check" data-toggle="tooltip" title="Accepted"></i> Accepted</a>
                      <a href="<?=base_url();?>vendor/bookings?status=rejected" class="dropdown-item "><i class="fe fe-alert-octagon" data-toggle="tooltip" title="Rejected"></i> Rejected</a>
                      <a href="<?=base_url();?>vendor/bookings?status=vendor" class="dropdown-item "><i class="fe fe-x-circle" data-toggle="tooltip" title="Cancelled"></i> Cancelled</a>
                    </div>
                  </li>
                  <!-- <li class="nav-item">
                    <a href="<?=base_url();?>vendor/venues" class="nav-link <?php echo ($uri == "venues")?"active":"";?>"><i class="fa fa-map-marker"></i> Venues List &nbsp;<i class="fe fe-chevron-down"></i></a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="<?=base_url();?>vendor/venues" class="dropdown-item "><i class="fa fa-map-marker" data-toggle="tooltip" title="Online"></i> Venues List</a>
                      <a href="<?=base_url();?>vendor/bookings?status=offline" class="dropdown-item "><i class="fe fe-eye-off" data-toggle="tooltip" title="Ofline"></i> Book Offline</a>
                      <a href="<?=base_url();?>vendor/temporary_slots" class="dropdown-item "><i class="fe fe-dollar-sign" data-toggle="tooltip" title="Cancelled"></i> Add Temporary Slots</a>
                    </div>
                  </li> -->
                  <li class="nav-item">
                    <a href="<?=base_url();?>vendor/venues" class="nav-link <?php echo ($uri == "venues")?"active":"";?>"><i class="fa fa-map-marker"></i> Venues List </a>                    
                  </li>
                  <!-- <li class="nav-item">
                    <a href="<?=base_url();?>vendor/calendar" class="nav-link <?php echo ($uri == "calendar")?"active":"";?>"><i class="fe fe-calendar"></i> Calendar</a>
                  </li> -->
                    <li class="nav-item">
                    <a href="<?=base_url();?>vendor/add_venue" class="nav-link <?php echo ($uri == "add_venue")?"active":"";?>"><i class="fe fe-plus-circle"></i> Add Venue</a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=base_url();?>vendor/pricing" class="nav-link <?php echo ($uri == "pricing")?"active":"";?>"><i class="fa fa-inr"></i> Add Pricing</a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=base_url();?>vendor/submit_form" class="nav-link <?php echo ($uri == "submit_form")?"active":"";?>"><i class="fa fa-envelope"></i> Send Message</a>
                  </li>
                </ul>
              </div>
            </div>
            </div>
          </div>
        </div>

        

<style type="text/css">
#subject-list 
{
  float: left;
  list-style: none;
  margin: 0;
  padding: 0;
  width: 90%;
  z-index: 99;
  position: absolute;
  margin-top: 5px;
  box-shadow: 0 5px 10px rgba(0,0,0,.13);
  /*margin-left: -5px;*/
}
#subject-list li 
{
  padding: 10px;
  background: #fff;
  color: #666;
  text-align: left;
  width: 100%;
  border-bottom: 1px solid #eee;
}
#subject-list li:hover{background:#F0F0F0;}
/*#search-box{border:#F0F0F0 1px solid;}*/
.owl-controls{ display:none; }
.error
{
  color:red;
}
</style>
<script type="text/javascript">
    $(document).ready(function() { //alert();
        $("#search-box").keyup(function(){
            $.ajax({
                type: "POST",
                url:  "<?=base_url();?>vendor/home/search_orders",
                data:'keyword='+$(this).val(),
                beforeSend: function(){
                $("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#suggesstion-box").show();
                $("#suggesstion-box").html(data);
                $("#search-box").css("background","#FFF");
            }
            });
        });
    });
</script>