<?php include('pageconfig/moduleHeader.php'); ?>
<br/>
<?php
	include('../manualdbconfig.php');
	//to retrive back data from form
	$traineeID = $_POST['traineeid'];
	
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$email = $_POST['email'];
	$phone = $_POST['phone_1'];
	$province = $_POST['state'];
	$city = $_POST['city'];
	$postal = $_POST['zip'];
	
	$userfullname=$firstname.' '.$lastname; 
	$useraddress=$address1.', '.$address2;
	
	$coursename = $_POST['coursename'];
	$shortname = $_POST['shortname'];
	$courseid = $_POST['courseid'];
	
	$cost = $_POST['cost'];
	$currency=$_POST['currency'];
	$PaypalBusinessEmail=$_POST['PaypalBusinessEmail'];
	
	//**************add payment information to database********************************************************************//
	$sqlInsert="INSERT INTO mdl_cifa_modulesubscribe 
				SET traineeid='$traineeID', firstname='$firstname', lastname='$lastname', address1='$address1',
				address2='$address2', email='$email', phone_no='$phone', province='$province', city='$city', zip='$postal',
				payment_status='New', cost='$cost', memo='none', courseid='$courseid', coursename='$coursename', date=now(), last_updated=now()";
	$sqlQuery=mysql_query($sqlInsert) or die("sql gagal" .mysql_error());	
	if($sqlQuery){
	
		$sqlSelect="SELECT * FROM mdl_cifa_modulesubscribe WHERE courseid='$courseid'";
		$querySelect=mysql_query($sqlSelect);
		$sqlRow=mysql_fetch_array($querySelect);
		
		$subscribeid=$sqlRow['id'];
	
		include('paypal/payment.php');
	}
	else
	{
		echo"No information about payment";
		echo"<br/>Please go back to the list.";
	}
	//***************************************************************************************************************************//
?>
<?php include('pageconfig/moduleFooter.php'); ?>