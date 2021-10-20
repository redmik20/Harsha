<?php
$MERCHANT_KEY = "RSfY9Azo";
$SALT = "1r9HXMWnFj";
$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
$posted = array(
    'key' => $MERCHANT_KEY,
    'hash' => '',
    'txnid' => $txnid,
    'amount' => $amount_paid,
    'firstname' => $this->session->userdata('name'),
    'email' => $this->session->userdata('email_id'),
    'phone' => $this->session->userdata('mobile'),
    'productinfo' => substr($venue_details['description'], 0, 100),    
    'service_provider' => 'payu_paisa'
    );
//$PAYU_BASE_URL = "https://sandboxsecure.payu.in";       // For Sandbox Mode
$PAYU_BASE_URL = "https://secure.payu.in";

$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
$hashVarsSeq = explode('|', $hashSequence);
$hash_string = '';  
foreach($hashVarsSeq as $hash_var) {
  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
  $hash_string .= '|';
}
$hash_string .= $SALT;
$hash = strtolower(hash('sha512', $hash_string));
$action = $PAYU_BASE_URL . '/_payment';
?>

<form action="<?php echo $action; ?>" method="post" name="payuForm" id="payuForm">
    <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
    <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
    <input type="hidden" name="amount" value="<?=$amount_paid;?>" />
    <input type="hidden" name="firstname" id="firstname" value="<?=$this->session->userdata('name');?>" />
    <input type="hidden" name="email" id="email" value="<?=$this->session->userdata('email_id');?>" />
    <input type="hidden" name="phone" value="<?=$this->session->userdata('mobile');?>" />
    <input type="hidden" name="productinfo" value="<?=substr($venue_details['description'], 0, 100);?>" />
    <input type="hidden" name="surl" value="<?=base_url();?>home/payment_status/success/<?=$order_id;?>" size="64" id="surl" />
    <input type="hidden" name="furl" value="<?=base_url();?>home/payment_status/failure/<?=$order_id;?>" size="64" id="furl" />
    <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
</form>

<script type="text/javascript">
    $( document ).ready(function() {
        $("#payuForm").submit();        
    });
</script>