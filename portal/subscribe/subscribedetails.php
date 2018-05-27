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
	
	//$traineeID = $_GET['traineeID'];
	
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
		
	$today = strtotime('now');	
	$dob=strtotime($_GET['dob']);
	
	
	/*$firstname = $_POST['firstname'];
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
	$PaypalBusinessEmail=$_POST['PaypalBusinessEmail']; 
	
	$today = strtotime('now');*/
	
	$sqlInsert="INSERT INTO mdl_cifa_modulesubscribe (firstname, lastname, dob, address1, email, phone_no, province, city, country, zip,
				payment_status, cost, paymethod, memo, courseid, timecreated, timemodified)
				VALUES ('".$firstname."', '".$lastname."', '".$dob."', '".$useraddress."', '".$email."', '".$phone."', '".$province."', '".$city."', '".$country."', '".$postal."',
				'New', '".$cost."', '".$pay_method."', 'none', '".$courseid."', '".$today."', '".$today."')";				
	
	//**************add payment information to database********************************************************************//	
	$sqlQuery=mysql_query($sqlInsert) or die("sql gagal<br/>" .mysql_error());	
	if($sqlQuery){
	
		$sqlSelect="SELECT * FROM mdl_cifa_modulesubscribe WHERE payment_status!='Paid' AND courseid='".$courseid."' AND email='".$email."'";
		$querySelect=mysql_query($sqlSelect)or die("sql check gagal<br/>" .mysql_error());
		$sqlRow=mysql_fetch_array($querySelect);
		$userrow=$sqlRow['id'];
		$year=date('m Y');
		
		if($sqlRow['id'] <= '9'){ 
			$a='000';
		}
		elseif($sqlRow['id'] >= '10' && $sqlRow['id'] <= '99'){ 
			$a='00';
		}else{
			$a='0';
		}
		
		$subscribeid='CIFA /'.$year.' /'.$a.''.$sqlRow['id'];
               				
		//candidates ID for new users
		$selectusers=mysql_query("SELECT * FROM mdl_cifauser WHERE deleted='0' AND confirmed='1' AND suspended='0' ORDER BY id DESC");
		$usercount=mysql_num_rows($selectusers);
		$userrec=mysql_fetch_array($selectusers);
		$tid=$userrec['id']+'1';
		$month=date('m');
		$year=date('y');
		if($month < '10'){ $m='00';}else{ $m='0';}
		
		if($userrec['id'] <= '9'){ 
			$c='00';
		}
		elseif($userrec['id'] >= '10' && $userrec['id'] <= '99'){ 
			$c='0';
		}else{
			$c='';
		}
		//final candidates ID generate
		$candidatesI='sb'.$m.''.$month.''.$c.''.$tid;	
		$traineeID=$candidatesI;
		
		//update course to fillup invoice
		$sqlUpdate=mysql_query("UPDATE mdl_cifa_modulesubscribe SET traineeid='".$traineeID."', invoiceno='".$subscribeid."' WHERE id='".$userrow."'");
	
		include('paypal/payment.php');
	}
	else
	{
		echo"No information about payment";
		echo"<br/>Please go back to the list.";
	}
	//***************************************************************************************************************************//
	//$subscribeid=$courseid;
	//include('paypal/payment.php');
	?>
<?php 	echo $OUTPUT->footer();	?>