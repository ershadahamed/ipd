<?php
//added by arizanabdullah 11/11/11****************************************************************************/////////////////////////////////
//mmn
$qry = "SELECT * FROM mdl_cifauser_enrolments a, mdl_cifaenrol b, mdl_cifauser c, mdl_cifacourse d
		WHERE b.id=a.enrolid AND a.emailsent='0' AND a.userid=c.id AND b.courseid='".$courseid."' AND d.id=b.courseid";
$sql = mysql_query($qry); 

while($rs = mysql_fetch_array($sql)){ 
	$coursename=$rs['fullname'];
	$shortcoursename=$rs['shortname'];
	$email=$rs['email'];
	$userenrolid=$rs['userid'];
	$enrolid=$rs['enrolid'];
	$namesent=$rs['firstname'].' '.$rs['lastname'];
	//echo "send email to $email".$rs['firstname']."=".$rs['userid'];
	
	$sqlAdmin="
			Select
			  a.lastname,
			  a.id,
			  a.username,
			  a.email,
			  a.firstname
			From
			  mdl_cifauser a
			Where
			  a.id = '2'";
	$queryAdmin=mysql_query($sqlAdmin);
	$rowAdmin=mysql_fetch_array($queryAdmin);
	
	//include('email_notification.php');
	$from=$rowAdmin['email'];//"mohd.arizan@mmsc.com.my"; //administrator mail
	$namefrom="CIFA Administrator";
	$to = $email;
	$nameto = $namesent;
	$subject = "Online purchasing module";

	$message = "You have been enroll for this courses:- <br/><b>$coursename($shortcoursename)</b>. <br/><br/>
				Now, you <b>$namesent</b> can login CIFA ONLINE for more details. <a href='http://localhost/cifa' target='_blank'>Login to cifa</a><br/>
			<p>Thank you.</p>";
			
	// this is it, lets send that email!
	authgMail($from, $namefrom, $to, $nameto, $subject, $message);
	
	//update mysql
	$updatesql="UPDATE mdl_cifauser_enrolments SET emailsent='1' WHERE userid='$userenrolid' AND enrolid='$enrolid'";
	$updatequery=mysql_query($updatesql);
	
}
//end by arizanabdullah 11/11/11
?>