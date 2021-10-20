<?php 
        $url='https://api.razorpay.com/v1/orders';
        $razorPayRequest=array(
						    'amount'=> 500,
						    'currency'=> 'INR',
						    'receipt'=> 'rcptid_17'
						   );

        $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($razorPayRequest));
	    curl_setopt($ch, CURLOPT_POST, 1);
	   // curl_setopt($ch, CURLOPT_USERPWD, "rzp_test_BGLPFtM9zlOVDY:P6EVJZ59BYmsx1N0E6sLFGsr"); //test keys
	    curl_setopt($ch, CURLOPT_USERPWD, "rzp_live_HRwYF4LWTTirfx:DFWV9E5luw6nlLhQeR9qpym2"); //live keys
	    
	    $headers = array();
	    $headers[] = 'Accept: application/json';
	    $headers[] = 'Content-Type: application/json';
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    $data = curl_exec($ch);
		curl_close($ch);
		$step1_response=json_decode($data);
		$order_id=$step1_response->id;
?>

<form action="http://issmedu.in/payment/success/" method="POST"> 
<script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="rzp_live_HRwYF4LWTTirfx" 
    data-amount="50000"
    data-currency="INR"
    data-order_id="<?php echo $order_id?>"
    data-buttontext="Pay with Razorpay"
    data-name="Acme Corp"
    data-description="Test transaction"
    data-image="https://example.com/your_logo.jpg"
    data-prefill.name="Srinivas A"
    data-prefill.email="asrinivas433@example.com"
    data-prefill.contact="7093668623"
    data-theme.color="#F37254"
></script>
<input type="hidden" custom="Hidden Element" name="hidden">
</form>