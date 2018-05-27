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
	$pay_method=$_GET['paymethod'];
	
	$cost = $_GET['cost'];
	$currency=$_GET['currency'];
	$PaypalBusinessEmail=$_GET['PaypalBusinessEmail']; 	
	
	$userfullname=$firstname.' '.$lastname; 
	$useraddress=$address.', '.$address2;	
	
	$today = strtotime('today');
        
        //echo $coursename;
				
	$sqlInsert="INSERT INTO mdl_cifa_modulesubscribe (traineeid, firstname, lastname, address1, email, phone_no, province, city, country, zip,
				payment_status, cost, paymethod, memo, courseid, timecreated, timemodified)
				VALUES ('".$traineeID."', '".$firstname."', '".$lastname."', '".$useraddress."', '".$email."', '".$phone."', '".$province."', '".$city."', '".$country."', '".$postal."',
				'New', '".$cost."', '".$pay_method."', 'none', '".$courseid."', '".$today."', '".$today."')";				
				
	$sqlQuery=mysql_query($sqlInsert) or die("sql gagal<br/>" .mysql_error());	
	if($sqlQuery){
	
		$sqlSelect="SELECT * FROM mdl_cifa_modulesubscribe WHERE invoiceno='' AND payment_status!='Paid' AND courseid='".$courseid."' AND email='".$email."'";
		$querySelect=mysql_query($sqlSelect);
		$sqlRow=mysql_fetch_array($querySelect);
		
		$year=date('m Y');
		
		if($sqlRow['id'] <= '10'){ 
			$a='000';
		}
		elseif($sqlRow['id'] >= '11' && $sqlRow['id'] <= '100'){ 
			$a='00';
		}else{
			$a='0';
		}
		
		$subscribeid='CIFA /'.$year.' /'.$a.''.$sqlRow['id'];
		
		//update course to fillup invoice
		$sqlUpdate=mysql_query("UPDATE mdl_cifa_modulesubscribe SET invoiceno='".$subscribeid."', payment_status='Pending' WHERE id='".$sqlRow['id']."'");
		//include('email-function.php');
		//include('creditcard.php');
		echo "
		Credit Card Payment:<br/><br/>
		There are 3 columns within the online payment process for credit card payment): <br/>
		1.	First you are asked to enter your credit/debit card details (including billing address). <br/>
		2.	Next, First you are asked to verify the details of the fees to be paid <br/>
		3.	Finally, we ask you to confirm that the card details you entered are correct (you can change them if not), before clicking on Submit to process your payment. <br/>
		";		
		
	}
	else
	{
		echo"No information about payment";
		echo"<br/>Please go back to the list.";
	}
	//***************************************************************************************************************************//
?>
<?php 	echo $OUTPUT->footer();	?>