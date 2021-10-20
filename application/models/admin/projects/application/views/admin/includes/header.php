<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">        
  <!-- META SECTION -->
  <title>PLATO</title>            
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="icon" type="image/png" href="<?=base_url();?>assets/images/platologo.png">
  <!-- END META SECTION -->

  <!-- CSS INCLUDE -->        
  <link rel="stylesheet" type="text/css" id="theme" href="<?=base_url();?>assets/css/theme-default.css"/>
  
  <script src="<?=base_url();?>assets/js/jquery-3.0.0.min.js"></script>
  <script src="<?=base_url();?>assets/js/jquery.validate.min.js"></script>
  <script src="<?=base_url(); ?>assets/js/tableToExcel.js"></script>

  <script src="https://maps.google.com/maps/api/js?key=AIzaSyC_u0v1SDu6-BkV6RaDcXaSgRnTuMJlgQY&libraries=places&region=ind&language=en&sensor=false"></script> 
  <script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/ckeditor/samples/js/sample.js"></script>


  <!-- EOF CSS INCLUDE --> 
   <style type="text/css">
    .alert-error, .error {
      color: #ff0000;
    }
    .alert-success {
      color: #3c763d;
      background-color: #dff0d8;
      border-color: #d6e9c6;
    }
 .x-navigation.x-navigation-horizontal li.user{
      padding: 10px;
      line-height: 30px;
      color: #fff;
      font-weight: bold;
    }

  </style>    
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">   
</head>
<body>
  <!-- START PAGE CONTAINER -->
  <div class="page-container">

    <div class="page-sidebar">
      <ul class="x-navigation">
        <li class="xn-profile">
          <a href="#" class="profile-mini">
            <img src="<?=base_url();?>assets/images/platologo.png" height="130" width="320" alt="Logo"/></a> 
            <div class="profile">
              <div class="profile-image"><img src="<?=base_url();?>assets/images/platologo.png" height="130" width="320" alt="Logo"/>
              </div>
            </div>
          </li>
          <?php $uri = $this->uri->segment(3);?>
          <li class="xn-title">Navigation</li>

          <li <?php if($uri == "index"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/home/index', '<span class="fa fa-cog"></span> <span class="xn-text"> Dashboard</span>'); ?>      
          </li>

           
          <li class="xn-openable <?php if($uri == "payments" || $uri == "offline_payments"): echo "active"; endif; ?>">
            <a href="#"><span class="fa fa-credit-card"></span> Payments </a>
            <ul>
                
          <li <?php if($uri == "payments"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/payments', '<span class="fa fa-credit-card"></span> <span class="xn-text"> ONLINE </span>'); ?>      
          </li>
          <li <?php if($uri == "offline_payments"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/offline_payments', '<span class="fa fa-credit-card"></span> <span class="xn-text"> OFFLINE</span>'); ?>      
          </li>

          
          </ul>
        </li>

        <li class="xn-openable <?php if($uri == "exams" || $uri == "add_exams" || $uri == "subjects" || $uri == "add_subjects" || $uri == "edit_subjects" || $uri == "chapters" || $uri == "add_chapters" || $uri == "edit_chapters" || $uri == "videochapters" || $uri == "add_videochapters" || $uri == "edit_videochapters"): echo "active"; endif; ?>">
            <a href="#"><span class="fa fa-bars"></span> Select Course </a>
            <ul>
               <li <?php if($uri == "exams"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/exams', '<span class="fa fa-edit"></span> <span class="xn-text"> Courses</span>'); ?>      
          </li>
              <li <?php if($uri == "subjects"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/subjects', '<span class="fa fa-book"></span> <span class="xn-text"> Subjects</span>'); ?>      
          </li>
          </li>
              <li <?php if($uri == "videochapters"|| $uri == "add_videochapters" || $uri == "edit_videochapters"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/videochapters', '<span class="fa fa-book"></span> <span class="xn-text"> Video Chapters</span>'); ?>      
          </li>
               <li <?php if($uri == "chapters"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/chapters', '<span class="fas fa-book-open"></span> <span class="xn-text"> Videos</span>'); ?>      
          </li>
          
       </ul>
          </li>

          
            <li class="xn-openable <?php if($uri == "examss" || $uri == "add_examss" || $uri == "subjectss" || $uri == "add_subjectss" || $uri == "edit_subjectss" || $uri == "topics" || $uri == "add_topics" || $uri == "edit_topics" || $uri == "quiz_questions"|| $uri == "add_quiz_questions" || $uri == "edit_quiz_questions"  || $uri == "quiz_reports" || $uri == "add_quiz_reports" || $uri == "edit_quiz_reports"  || $uri == "feedback"|| $uri == "add_feedback" || $uri == "edit_feedback" || $uri == "quiz_question_bookmarks"||$uri == "add_quiz_question_bookmarks" || $uri == "edit_quiz_question_bookmarks" || $uri == "qbanktopics" || $uri == "add_qbanktopics" || $uri == "edit_qbanktopics" || $uri == "pearls" || $uri == "add_pearl_to_question" || $uri == "edit_pearls"): echo "active"; endif; ?>">
            <a href="#"><span class="fa fa-bars"></span> Select Qbanks </a>
            <ul>
                
               <li <?php if($uri == "examss"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/exams', '<span class="fa fa-edit"></span> <span class="xn-text"> Courses</span>'); ?>      
          </li>
              <li <?php if($uri == "subjectss"): echo "class='active'"; endif; ?>>
      <?php echo anchor('admin/register/subjects', '<span class="fa fa-book"></span> <span class="xn-text"> Subjects</span>'); ?>      
          </li>
               <li <?php if($uri == "topics"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/topics', '<span class="fas fa-sticky-note"></span> <span class="xn-text"> Qbank Chapters</span>'); ?>      
          </li>

          </li>
               <li <?php if($uri == "qbanktopics" || $uri == "add_qbanktopics" || $uri == "edit_qbanktopics" ): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/qbanktopics', '<span class="fas fa-sticky-note"></span> <span class="xn-text"> Qbank Topics</span>'); ?>      
          </li>

          </li>
          <li <?php if($uri == "qbanksubtopics" || $uri == "add_qbanksubtopics" || $uri == "edit_qbanksubtopics" ): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/qbanksubtopics', '<span class="fas fa-sticky-note"></span> <span class="xn-text"> Qbank Sub Topics</span>'); ?>      
          </li>
          
            <li <?php if($uri == "quiz_questions"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/quiz_questions', '<span class="fa fa-question"></span> <span class="xn-text"> Questions</span>'); ?>      
          </li>

          <li <?php if($uri == "qbanksubtopics" || $uri == "add_qbanksubtopics" || $uri == "quiz_questions" || $uri == ''): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/search_quiz_questions', '<span class="fa fa-search"></span> <span class="xn-text">Search Questions</span>'); ?>      
          </li>

          <li <?php if($uri == "pearls" || $uri == "add_pearl_to_question" || $uri == "edit_pearls"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/pearls', '<span class="fa fa-question"></span> <span class="xn-text"> Flash Cards</span>'); ?>      
          </li>
          <li <?php if($uri == "quiz_reports"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/quiz_reports', '<span class="fa fa-line-chart"></span><span class="xn-text"> Reports</span>'); ?>      
          </li>
            <li <?php if($uri == "feedback"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/feedback', '<span class="fa fa-star"></span> <span class="xn-text"> Feedback</span>'); ?>      
          </li>
          <li <?php if($uri == "quiz_question_bookmarks"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/quiz_question_bookmarks', '<span class="fa fa-bookmark"></span> <span class="xn-text"> Bookmarks</span>'); ?>      
          </li>
          <li <?php if($uri == "bulk_upload_quiz_questions"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/bulk_upload_quiz_questions', '<span class="fa fa-question"></span> <span class="xn-text">Bulk Upload Questions</span>'); ?>      
          </li>
       </ul>
          </li>


         
         


          <li class="xn-openable <?php if($uri == "examsss" || $uri == "add_examsss" ||  $uri == "test_series_quiz" || $uri == "add_test_series_quiz" || $uri == "edit_test_series_quiz"  || $uri == "testseries" || $uri == "add_testseries" || $uri == "edit_testseries"|| $uri == "test_series_categories" || $uri == "add_test_series_categories" || $uri == "edit_test_series_categories" || $uri == "test_series_questions" ||$uri == "add_test_series_questions" || $uri == "edit_test_series_questions"): echo "active"; endif; ?>">
            <a href="#"><span class="fa fa-bars"></span> Select Test Series </a>
            <ul>

            <li <?php if($uri == "testseries"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/testseries', '<span class="material-icons">content_paste</span> <span class="xn-text"> TestSeries</span>'); ?>      
          </li>
               <li <?php if($uri == "test_series_categories"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/test_series_categories', '<span class="fa fa-bars"></span> <span class="xn-text"> TestSeries Categories </span>'); ?>      
          </li>
          <li <?php if($uri == "examsss"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/exams', '<span class="fa fa-edit"></span> <span class="xn-text"> Courses</span>'); ?>      
          </li>
          <li <?php if($uri == "test_series_quiz"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/test_series_quiz', '<span class="fa fa-bars"></span> <span class="xn-text"> TestSeries Topics</span>'); ?>      
          </li>      
            <li <?php if($uri == "test_series_questions"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/test_series_questions', '<span class="fa fa-question"></span> <span class="xn-text"> Test Series Questions</span>'); ?>      
          </li>
          <li <?php if($uri == "testseries_bookmarks"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/testseries_bookmarks', '<span class="fa fa-bookmark"></span> <span class="xn-text"> Test Series Bookmarks</span>'); ?>      
          </li>
          <li <?php if($uri == "bulk_upload_testseries"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/bulk_upload_testseries', '<span class="fa fa-question"></span> <span class="xn-text">Bulk Upload Test Series Questions</span>'); ?>      
          </li>
          
            <li <?php if($uri == "reset_test_series_view"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/reset_test_series_view', '<span class="fa fa-question"></span> <span class="xn-text">Reset Testseries for User</span>'); ?>      
          </li>
       </ul>
          </li>

        <li class="xn-openable <?php if($uri == "agents" || $uri == "add_agents" || $uri == "edit_agents" || $uri == "view_agents"): echo "active"; endif; ?>">
            <a href="#"><span class="fa fa-bars"></span> Agents </a>
            <ul>
                
          <li <?php if($uri == "agents" || $uri == "add_agents" || $uri == "edit_agents" || $uri == "view_agents"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/agents', '<span class="fa fa-users"></span> <span class="xn-text"> Agents</span>'); ?>      
          </li>
          <li <?php if($uri == "exams"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/agent_commissions', '<span class="fa fa-money"></span> <span class="xn-text"> Agent Commissions</span>'); ?>      
          </li>
          </ul>
        </li>

        <!-- <li class="xn-openable <?php if($uri == "users" || $uri == "unregister_users" || $uri == "online_users"): echo "active"; endif; ?>">
            <a href="#"><span class="fa fa-users"></span> Users </a>
            <ul>
                
          <li <?php if($uri == "users"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/users', '<span class="fa fa-user"></span> <span class="xn-text"> Users</span>'); ?>      
          </li>
          <li <?php if($uri == "unregister_users"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/unregister_users', '<span class="fa fa-user"></span> <span class="xn-text"> UnRegister Users</span>'); ?>      
          </li>

          <li <?php if($uri == "online_users"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/online_users', '<span class="fa fa-user"></span> <span class="xn-text">Online Users</span>'); ?>      
          </li>
          </ul>
        </li> -->
         
         
          

          <li <?php if($uri == "images_gallery"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/images_gallery', '<span class="fa fa-image"></span> <span class="xn-text"> Images Gallery</span>'); ?>      
          </li>

           <li <?php if($uri == "notifications"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/notifications', '<span class="fa fa-bell"></span> <span class="xn-text"> Notifications</span>'); ?>      
          </li>
          <li <?php if($uri == "faculty"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/faculty', '<span class="fas fa-chalkboard-teacher"></span> <span class="xn-text"> Faculty</span>'); ?>      
          </li>

           <li <?php if($uri == "banners"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/banners', '<span class="fa fa-image"></span> <span class="xn-text"> Banners</span>'); ?>      
          </li>
          <li <?php if($uri == "coupons"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/coupons', '<span class="fa fa-bars"></span> <span class="xn-text"> Coupons</span>'); ?>      
          </li>
          <li <?php if($uri == "packages" || $uri == "add_packages" ||  $uri == "edit_packages" || $uri == "view_packages"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/packages', '<span class="fa fa-money"></span> <span class="xn-text"> Packages</span>'); ?>      
          </li>
           <li <?php if($uri == "plandetails"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/plandetails', '<span class="fa fa-bars"></span> <span class="xn-text"> Plandetails</span>'); ?>      
          </li>

          <li <?php if($uri == "access_user" || $uri == "add_access_user"): echo "class='active'"; endif; ?>>
            <?php echo anchor('admin/register/add_access_user', '<span class="fa fa-bars"></span> <span class="xn-text">User access</span>'); ?>      
          </li>

            

            <!-- <li <?php if($uri == "questions"): echo "class='active'"; endif; ?>>
    <?php echo anchor('admin/register/questions', '<span class="fa fa-question"></span> <span class="xn-text"> Questions</span>'); ?>      
          </li>-->
         
        </ul>
      </li>
    </ul>
    <!-- END X-NAVIGATION -->
  </div>
  <!-- END PAGE SIDEBAR -->

  <!-- PAGE CONTENT -->
  <div class="page-content">
    <!-- START X-NAVIGATION VERTICAL -->
    <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
      <!-- TOGGLE NAVIGATION -->
      <li class="xn-icon-button">
        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
      </li>
      <!-- END TOGGLE NAVIGATION -->

      <!-- POWER OFF -->
      <li class="xn-icon-button pull-right last">        
        <a href="#"><span class="fa fa-power-off"></span></a>
        <ul class="xn-drop-left animated zoomIn">
          <li><a href="<?=base_url();?>admin/register/ChangePassword"><span class="fa fa-key"></span> Change Password</a></li>
          <li><a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span> Sign Out</a></li>
        </ul>
      </li>
    </ul>                        

    <!-- END X-NAVIGATION VERTICAL --> 

    <!-- <script type="text/javascript">
      $(document).ready(function() 
      {
        window.setInterval(function(){
          $.ajax( {
            type: 'POST',
            url: "<?=base_url();?>admin/register/get_venue_delete_requests_count",
            //data: {category_id:category_id},
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                //$("#wait").css("display", "block");
            },
            success: function(data) { //alert(data);exit;
              var present_count = $("#delete_request_counts").html();
              //alert(present_count);
              if(data > present_count)
              {
                document.getElementById('audio-alert').play();
              }
              if(data > 0)
              {                
                $("#delete_request_counts").show().html(data);
              }      
              //$("#wait").css("display", "none");
              //location.reload();
              return false;
            }
          });
  
        }, 50);
      });
    </script> -->
      <script src='https://kit.fontawesome.com/a076d05399.js'></script>

    