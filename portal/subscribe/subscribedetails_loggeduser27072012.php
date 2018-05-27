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
	
	$cost = $_GET['cost'];
	$currency=$_GET['currency'];
	$PaypalBusinessEmail=$_GET['PaypalBusinessEmail']; 	
	
	$userfullname=$firstname.' '.$lastname; 
	$useraddress=$address.', '.$address2;	
	
	//to retrive back data from form
	/*$traineeID = $_POST['traineeid'];
	
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$email = $_POST['email'];
	$phone = $_POST['phone_1'];
	$province = $_POST['state'];
	$city = $_POST['city'];
	$postal = $_POST['zip'];
	$country = $_POST['country'];
        $dob=strtotime($_POST['dob']);
	
	$userfullname=$firstname.' '.$lastname; 
	$useraddress=$address1.', '.$address2;
	
	$coursename = $_POST['coursename'];
	$shortname = $_POST['shortname'];
	$courseid = $_POST['courseid'];
	
	$cost = $_POST['cost'];
	$currency=$_POST['currency'];
	$PaypalBusinessEmail=$_POST['PaypalBusinessEmail']; */
	
	$today = strtotime('today');
        
        echo $coursename;
				
	$sqlInsert="INSERT INTO mdl_cifa_modulesubscribe (traineeid, firstname, lastname, address1, email, phone_no, province, city, country, zip,
				payment_status, cost, memo, courseid, timecreated, timemodified)
				VALUES ('".$traineeID."', '".$firstname."', '".$lastname."', '".$useraddress."', '".$email."', '".$phone."', '".$province."', '".$city."', '".$country."', '".$postal."',
				'New', '".$cost."', 'none', '".$courseid."', '".$today."', '".$today."')";				
				
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
		$sqlUpdate=mysql_query("UPDATE mdl_cifa_modulesubscribe SET invoiceno='".$subscribeid."' WHERE id='".$sqlRow['id']."'");
		//include('email-function.php');
		include('paypal/payment.php');
	}
	else
	{
		echo"No information about payment";
		echo"<br/>Please go back to the list.";
	}
	//***************************************************************************************************************************//
	//include('paypal/payment.php');
?>
<?php 	echo $OUTPUT->footer();	?>