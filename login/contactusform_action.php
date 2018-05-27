<?php
	require('../config.php');
	require('../manualdbconfig.php');
	include('../function/emailfunction.php');
	
	$alertmessage=get_string('contactusmessage');
	$alertmessagefalse=get_string('contactusmessagefalse');
	
	$fullname=$_POST['fullname'];
	$id_dob=$_POST['id_dob'];
	$email=$_POST['email'];
	$contactsubject=$_POST['contactsubject'];
	$contactmessage=$_POST['contactmessage'];
	$timecreated=strtotime('now');
	
	$sqlsupportemail=mysql_query("SELECT * FROM {$CFG->prefix}config WHERE name='supportemail'");
	$q_supportemail=mysql_fetch_array($sqlsupportemail);
	$supportemail=$q_supportemail['value'];
	
	
	$sql=mysql_query("
		INSERT INTO {$CFG->prefix}contactus_form (reporterfullname, reporterdob, reporteremail, contactsubject, contactmessage, timecreated)
		VALUES('".$fullname."', '".$id_dob."', '".$email."', '".$contactsubject."', '".$contactmessage."', '".$timecreated."')
	");
	$newemailid=mysql_insert_id();

	if($sql){		
		// email to commenter----------------------------------------------------------//
		$linkcontact=$CFG->wwwroot. '/login/forgot_password.php';
		$to = $email;
		$subject = "Auto-response: This is system generated email. Please do not reply";
		
		$message = "
				<html>
				<head>
					<title>HTML email</title>
				</head>
				<body>
				<p>Dear (".strtoupper($fullname)."),</p><br/>
				<p>Thank you for your email.</p>
				<p style='text-align:justify;'>
					Please be informed that our service manager is going through your request and we will get back to you within 3 working days.
					</p>
					
				<p style='text-align:justify;'>
					Please note that this is a system generated email. Please  do not reply to this email. For assistance, please use the <strong><u><a href='".$linkcontact."' target='_blank'>contact us</a></u></strong> facility  at IPD Online Portal. 
					</p>

				<p>
					Our operation hours are as follows:<br>
					Sunday - Thursday : 9.00am - 5.00pm GMT+3<br>
					Closed on Friday, Saturday &amp; Public Holidays.
				</p><p></p><br/>
				<p>Yours Sincerely, <br>
				<strong>SHAPE&reg; Knowledge Services</strong></p><br/><br/>
				<p style='font-size:11px'><strong>Disclaimer:</strong> <br>
				  This is a system  generated email. Please do not reply. For assistance, please <strong><u><a href='".$linkcontact."' target='_blank'>contact us</a></u></strong> and we will revert back to you within 72 hours. </p>
				</body>
				</html>
		";
		
		// Always set content-type when sending HTML email
		$link=$CFG->wwwroot;
		$headers = "Content-type:text/html" . "\r\n";
		
		// More headers
		$headers .= "From: IPD Online<".$supportemail.">" . "\r\n";			
		mail($to,$subject,$message,$headers);	
		//------------------- email to user----------------------------//
			
		//------------------- email to administrator----------------------------//
		$to1 = $supportemail;
		$subject1 = $contactsubject;
		$message1 = $contactmessage;
		
		// Always set content-type when sending HTML email
		$link=$CFG->wwwroot;
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		// More headers
		$headers .= 'From: <'.$email.'>' . "\r\n";
			
		mail($to1,$subject1,$message1,$headers);	
		
		/////// AUTHMAIL
		$fromadmin=$email;  
		$namefromadmin="IPD Online";
		$nametoadmin = "IPD Online"; 
				
		// this is it, lets send that email!
		authgMail($fromadmin, $namefromadmin, $to1, $nametoadmin, $subject1, $message1);	
		//------------------- End email to administrator----------------------------//
		
		/////// AUTHMAIL
		$from1=$supportemail;  
		$namefrom1="IPD Online";
		$nameto1 = "IPD Online"; 
				
		// this is it, lets send that email!
		authgMail($from1, $namefrom1, $to, $nameto1, $subject, $message);		

		/* $emailuser->email: Email address
		$emailuser->firstname: You can put both first and last name in this field.
		$emailuser->lastname
		$emailuser->maildisplay = true;
		$emailuser->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML/Text emails.
		$emailuser->id: Moodle User ID. If it is for someone who is not a Moodle user, use an invalid ID like -99.
		$emailuser->firstnamephonetic
		$emailuser->lastnamephonetic
		$emailuser->middlename
		$emailuser->alternatename	 */
		
		// email_to_user($toUser, $fromUser, $subject, $messageText, $messageHtml, ", ", true);
?>
	<script language="javascript">
		window.alert("<?=$alertmessage;?>");
		window.location.href = '<?=$CFG->wwwroot. "/login/forgot_password.php";?>'; 
	</script>
<?php
	}else{
?>
	<script language="javascript">
		window.alert("<?=$alertmessagefalse;?>");
		window.location.href = '<?=$CFG->wwwroot. "/login/forgot_password.php";?>'; 
	</script>
<?php } ?>
</body>
</html>