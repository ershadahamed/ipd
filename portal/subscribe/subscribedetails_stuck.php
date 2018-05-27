<?php
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../../manualdbconfig.php'); 

	$site = get_site();
	
	$purchase='Purchase modules';
	$title="$SITE->shortname: Courses - ".$purchase;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);

	echo $OUTPUT->header();	
	//to retrive back data from form
	$traineeID = $_GET['traineeID'];
	
	$firstname = $_GET['trainee_name'];
	$lastname = $_GET['lastname'];
	$address = $_GET['address'];
	$address2 = $_GET['address2'];
	$email = $_GET['email'];
	$phone = $_GET['phone'];
	$province = $_GET['province'];
	$city = $_GET['city'];
	$postal = $_GET['postal'];
	$country = $_GET['country'];
	
	$coursename = $_GET['coursename'];
	$shortname = $_GET['shortname'];
	$courseid = $_GET['courseid'];
	
	$cost = $_GET['cost'];
	$currency=$_GET['currency'];
	$PaypalBusinessEmail=$_GET['PaypalBusinessEmail']; 	
	
	$userfullname=$firstname.' '.$lastname; 
	$useraddress=$address.', '.$address2;
	$subscribeid=$_GET['invoice'];
	$pay_method=$_GET['paymethod'];
	
	$today = strtotime('now'); 
    //echo $coursename;
	
	if($pay_method == 'paypal'){
		$sqlUpdate=mysql_query("UPDATE mdl_cifa_modulesubscribe SET timemodified='".$today."' WHERE invoiceno='".$subscribeid."'");
		include('paypal/payment.php');	
	}else if($pay_method == 'creditcard'){
		$sqlUpdate=mysql_query("UPDATE mdl_cifa_modulesubscribe SET timemodified='".$today."', payment_status='Pending' WHERE invoiceno='".$subscribeid."'");
		include('creditcard_pay.php');	
	}else{
	//telegraphic
	$sqlUpdate=mysql_query("UPDATE mdl_cifa_modulesubscribe SET timemodified='".$today."', payment_status='Pending' WHERE invoiceno='".$subscribeid."'");
?>
	<fieldset id="fieldset"><legend id="legend">Please pay to Alinmaa Education Co W.L.L at Boubyan Bank</legend>
	<table>
		<tr><td width="20%">Branch</td><td width="1%"><strong>:</strong></td><td>Sharq Branch</td></tr>
		<tr><td>Account Title/Beneficiary</td><td><strong>:</strong></td><td>Alinmaa Education Co W.L.L </td></tr>
		<tr><td>SWIFT Code</td><td><strong>:</strong></td><td>KWKWBBYN</td></tr>
		<tr><td>IBAN  #	</td><td><strong>:</strong></td><td>KW12 BBYN 0000 0000 0000 0149 0840 01 </td></tr>
		<tr><td>Account Number</td><td><strong>:</strong></td><td>0149084001</td></tr>	
		<tr><td>Reference</td><td><strong>:</strong></td><td>SHAPE Financial Corporation</td></tr>
		<tr><td colspan="3">You will be liable for the additional charges incurred in the wire transfer.</td></tr>
	</table><br/>
	
	<!--p><a href="" title="Back to purchase a curriculum">Back to purchase a curriculum</a></p-->
	</fieldset>	
<?php		
	}

	echo $OUTPUT->footer();	
?>