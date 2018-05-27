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
	$pay_method=$_GET['paymethod'];
	
	$userfullname=$firstname.' '.$lastname; 
	$useraddress=$address.', '.$address2;	
	
	$today = strtotime('today');			
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
	</table>
	</fieldset>	
<?php			
	include("../../includes/functions.php");
	
	$currentusername=$USER->firstname.' '.$USER->lastname;	
	$result=mysql_query("
		INSERT INTO 
			mdl_cifacandidates 
		SET 
			candidateid='".$USER->id."', traineeid='".$USER->traineeid."', name='".$currentusername."', dob='".$USER->dob."', email='".$USER->email."', address='".$USER->address."', province='".$USER->city."', country='".$USER->country."', phone='".$USER->phone1."'
	");
	$customerid=mysql_insert_id();
	$date=strtotime('now');
	$result=mysql_query("insert into mdl_cifaorders values('','$date','".$customerid."')");
	$orderid=mysql_insert_id();
	
	$max=count($_SESSION['cart']);
	for($i=0;$i<$max;$i++){
		$pid=$_SESSION['cart'][$i]['productid'];
		$q=$_SESSION['cart'][$i]['qty'];
		$price=get_price($pid);
		mysql_query("insert into mdl_cifaorder_detail values ($orderid,$pid,$q,$price)");
	}	

	//enrol old user to mdl_cifauser_enrolments
	$selectgetuser=mysql_query("
		Select
		  b.customerid,
		  a.candidateid,
		  a.traineeid,
		  a.name,
		  a.email,
		  b.date,
		  c.productid,
		  c.price
		From
		  mdl_cifacandidates a Inner Join
		  mdl_cifaorders b On a.serial = b.customerid Inner Join
		  mdl_cifaorder_detail c On b.serial = c.orderid
		Where
		  a.candidateid = '46'
	");
	while($sgetuser=mysql_fetch_array($selectgetuser)){
		$getcourseid=$sgetuser['productid'];
		
		//echo 'manual enrol users. <br/>'.$getcourseid.'<br/>';
		
		$senroluser=mysql_query("Select * From mdl_cifaenrol Where enrol = 'manual' And courseid='".$getcourseid."' And status='0'");
		$qenroluser=mysql_fetch_array($senroluser);
		$getenrolid=$qenroluser['id'];
		$gotuser=$sgetuser['candidateid'];
		
		//echo $getenrolid.'****** '.$gotuser.'<br/>';
		
		//to check if user never enrol for this course
		$scuser=mysql_query("SELECT * FROM mdl_cifauser_enrolments WHERE enrolid='".$getenrolid."' AND userid='".$gotuser."'");
		$ucount=mysql_num_rows($scuser);
		
		//echo $ucount.'<br/>';
		if($ucount=='0'){
			$today = strtotime('now');
			$sqlInsert=mysql_query("INSERT INTO mdl_cifauser_enrolments 
									SET enrolid='".$getenrolid."', userid='".$gotuser."',
									timecreated='".$today."', timemodified='".$today."',
									modifierid='2', emailsent='1', timestart='".$timestart."', timeend='".$timeend."'");

			//to define contextid
			$sL=mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='".$getcourseid."'");
			$L=mysql_fetch_array($sL);
			$contextid=$L['id'];
			
			$sqlassign=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='5', contextid='".$contextid."', userid='".$gotuser."', modifierid='2', timemodified='".$today."'");								
		}
	}
	//end enrol users
	//***************************************************************************************************************************//
	session_unset(); 
?>
<?php 	echo $OUTPUT->footer();	?>