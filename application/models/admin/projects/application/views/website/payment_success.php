<?php
if($p_status == "success")
{
  ?>
  <div class="jumbotron text-center">
    <h2 class="text-center"><i class="fa fa-check success-icon"></i></h2>
    <h1 class="display-3">
    
    <span>Thank You!
       <!-- <div class="blue-line"></div>
        <div class="yellow-line"></div>-->
    </span>
    </h1>
    <p class="lead"><strong> Your Payment is Successful</strong> Please check your email for further Details</p>
    
    <hr />
    <p>
      any Query? <a href="">Contact us : +91-9999 999 999</a>
    </p>
    <p class="lead">
      <a class="btn btn-primary btn-sm" href="<?=base_url();?>home/user_profile" role="button">Go to My Account</a>
      <a class="btn btn-primary btn-sm" href="<?=base_url('home/user_profile');?>" role="button">Go to Account Page</a>
    </p>
  </div>
  <?php
}
else
{
  ?>
  <div class="jumbotron text-center">
    <h2 class="text-center"><i class="fa fa-times fail-icon"></i></h2>
    <h1 class="display-3">
    
    <span>Ooooooops!...
       <!-- <div class="blue-line"></div>
        <div class="yellow-line"></div>-->
    </span>
    </h1>
    <p class="lead"><strong> Something went wrong</strong> your payment is failed.</p>
    
    <hr />
    <p>
      any Query? <a href="">Contact us : +91-9999 999 999</a>
    </p>
    <p class="lead">
      <a class="btn btn-primary btn-sm" href="<?=base_url();?>" role="button">Go to Home Page</a>
      <a class="btn btn-primary btn-sm" href="<?=base_url('home/user_profile');?>" role="button">Go to Account Page</a>
    </p>
  </div>
  <?php
}
?>

<style>
.jumbotron
{
    background:#fff;
    box-shadow:0 5px 10px rgba(0,0,0,.2);
    }
 .jumbotron h1 span
 {
     position:relative;
     }
  .success-icon
  {
      border:2px solid #28a745;
      padding:20px;
      border-radius:50%;
      color:#28a745!important;
      }
      .fail-icon
  {
      border:2px solid red;
      padding:20px;
      border-radius:50%;
      color:red!important;
      }
</style>