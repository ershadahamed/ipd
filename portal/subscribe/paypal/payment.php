<?php
/*
	This page will submit the order information to paypal website.
	After the customer completed the payment she will return to this site
*/

require_once 'paypal.inc.php';

$paypal['item_name'] = $coursename;
$paypal['invoice']   = $subscribeid;
$paypal['amount']    = $cost;
$paypal['item_number']   = $shortname;
$paypal['os0']           = $userfullname;
$paypal['os1']           = $traineeID;
$paypal['phone_1'] = $phone;
$paypal['currency_code'] = $currency;
//$paypal['business']      = $PaypalBusinessEmail;
?>
<center>
    <p>&nbsp;</p>
    <p><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="333333">
	<img src="<?php echo $CFG->wwwroot.'/image/loader2.gif'; ?>"><br/>
	Processing Transaction . . . </font></p>
	<p>&nbsp;</p>
</center>

<?php
    $paypalurl = empty($CFG->usepaypalsandbox) ? 'https://www.paypal.com/cgi-bin/webscr' : 'https://www.sandbox.paypal.com/cgi-bin/webscr';
?>

<form action="<?php echo /*$paypal['url'];*/ $paypalurl; ?>" method="post" name="frmPaypal" id="frmPaypal">

<input type="hidden" name="amount" value="<?php echo $paypal['amount']; ?>">
<input type="hidden" name="invoice" value="<?php echo $paypal['invoice']; ?>">
<input type="hidden" name="item_name" value="<?php echo $paypal['item_name']; ?>">
<input type="hidden" name="business" value="<?php echo $paypal['business']; ?>"> 
<input type="hidden" name="cmd" value="<?php echo $paypal['cmd']; ?>"> 

<input type="hidden" name="charset" value="utf-8" />
<input type="hidden" name="item_number" value="<?php echo $paypal['item_number']; ?>" />
<input type="hidden" name="on0" value="<?php echo 'User';//print_string("user") ?>" />
<input type="hidden" name="os0" value="<?php echo $paypal['os0']; ?>" />
<input type="hidden" name="on1" value="<?php print_string("candidateid") ?>" />
<input type="hidden" name="os1" value="<?php echo $paypal['os1']; ?>" />

<!-- <input type="hidden" name="notify_url" value="<?php //echo '$CFG->wwwroot/enrol/paypal/ipn.php'?>" />
<input type="hidden" name="return" value="<?php //echo '$CFG->wwwroot/enrol/paypal/return.php?id=$course->id' ?>" />
<input type="hidden" name="cancel_return" value="<?php //echo $CFG->wwwroot ?>" /> -->


<!--input type="hidden" name="notify_url" value="<?php //echo  $paypal['site_url'] . $paypal['notify_url']; ?>">
<input type="hidden" name="return" value="<?php //echo  $paypal['site_url'] . $paypal['success_url']; ?>">
<input type="hidden" name="cancel_return" value="<?php //echo $paypal['site_url'] . $paypal['cancel_url']; ?>"-->

<input type="hidden" name="notify_url" value="<?php echo $CFG->wwwroot. $paypal['notify_url']; ?>">
<input type="hidden" name="return" value="<?php echo $CFG->wwwroot. $paypal['success_url']; ?>">
<input type="hidden" name="cancel_return" value="<?php echo $CFG->wwwroot. $paypal['cancel_url'];?>" />

<input type="hidden" name="rm" value="<?php echo $paypal['return_method']; ?>">
<input type="hidden" name="currency_code" value="<?php echo $paypal['currency_code']; ?>">
<input type="hidden" name="lc" value="<?php echo $paypal['lc']; ?>">
<input type="hidden" name="bn" value="<?php echo $paypal['bn']; ?>">
<input type="hidden" name="no_shipping" value="<?php echo $paypal['display_shipping_address']; ?>">
<input type="hidden" name="cbt" value="<?php echo 'continuetocourse';//print_string("continuetocourse") ?>" />
<input type="hidden" name="for_auction" value="false" />
<input type="hidden" name="no_note" value="1" />


<input type="hidden" name="first_name" value="<?php echo $paypal['firstname']; ?>" />
<input type="hidden" name="last_name" value="<?php echo $paypal['lastname']; ?>" />
<input type="hidden" name="address1" value="<?php echo $paypal['address1']; ?>" />
<input type="hidden" name="address2" value="<?php echo $paypal['address2']; ?>" />
<input type="hidden" name="city" value="<?php echo $paypal['city']; ?>" />
<input type="hidden" name="email" value="<?php echo $paypal['email']; ?>" />
<input type="hidden" name="state" value="<?php echo $paypal['state']; ?>" />
<input type="hidden" name="zip" value="<?php echo $paypal['zip']; ?>" />
<input type="hidden" name="phone_1" value="<?php echo $paypal['phone_1']; ?>" />


</form>
<script language="JavaScript" type="text/javascript">
window.onload=function() {
	window.document.frmPaypal.submit();
}
</script>
