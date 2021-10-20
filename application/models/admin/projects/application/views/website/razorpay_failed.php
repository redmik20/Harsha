

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


<div class="container">
    <div class="row text-center">
        <div class="col-sm-6 col-sm-offset-3">
        
        
        <br><br> <h2 style="color:red">Payment Failed</h2>
        
        <h3>Dear, <?php echo $user_data['name'];?></h3>
        <p style="font-size:20px;color:#5C5C5C;">Sorry,Your Payment was failed.
        </p>
        <br><br>
        <p>Razor Pay Reference ID:<b><?php echo $payment_info['receipt_id'];?></b></p>
        <br><br>
        <a href="http://platoonline.in/admin/" class="btn btn-success"> Please try Once.  </a>
           
        <br><br>
        </div>
        
    </div>
</div>