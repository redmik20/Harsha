<?php 
        $user_name=$user_data['name'];
        $user_email=$user_data['email_id'];
        $user_mobile=$user_data['mobile'];
        $amt=$total_price*100;
        $order_id=$razorpay_order_id;
        $payment_id=$payment_id;

$payment_keys=$this->db->query("select * from payment_gateway where id='1'")->row_array();
$api_key=$payment_keys['key'];
$api_secret=$payment_keys['secret'];  
?>
<button style="display:none" type="hidden" id="rzp-button1">Pay</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
var options = {
    "key": "<?php echo $api_key?>", // Enter the Key ID generated from the Dashboard
    "amount": "<?php echo $amt?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "INR",
    "name": "Plato",

    "description": "Live Transaction",
    "image": "<?php echo base_url()?>/assets/images/plato100.png",

    "order_id": "<?php echo $order_id?>", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
    "callback_url": "<?php echo base_url()?>payment/success/<?php echo $payment_id?>",
    "prefill": {
        "name": "<?php echo $user_name?>",
        "email": "<?php echo $user_email?>",
        "contact": "<?php echo $user_mobile?>"
    },
    "notes": {
        "address": "Razorpay Corporate Office"
    },
    "theme": {
        "color": "#F37254"
    }
};
var rzp1 = new Razorpay(options);
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}

/*jQuery(function(){
   jQuery('#rzp-button1').click();
});*/
window.onload=function(){
  document.getElementById("rzp-button1").click(function(e){
    rzp1.open();
    e.preventDefault();
});
};

</script>