<?php
	include('../config.php');
	include('../manualdbconfig.php');

	function authgMail($from, $namefrom, $to, $nameto, $subject, $message) {
		
	$smtpServer = "pop.mmsc.com.my";   //ip address of the mail server.  This can also be the local domain name
	$port = "25";					 // should be 25 by default, but needs to be whichever port the mail server will be using for smtp 
	$timeout = "45";				 // typical timeout. try 45 for slow servers
	$username = "mohd.arizan/mmsc.com.my"; // the login for your smtp
	$password = "mohdarizan123";			// the password for your smtp
	$localhost = "127.0.0.1";	   // Defined for the web server.  Since this is where we are gathering the details for the email
	$newLine = "\r\n";			 // aka, carrage return line feed. var just for newlines in MS
	$secure = 0;				  // change to 1 if your server is running under SSL
	
	//connect to the host and port
	$smtpConnect = fsockopen($smtpServer, $port, $errno, $errstr, $timeout);
	$smtpResponse = fgets($smtpConnect, 4096);
	if(empty($smtpConnect)) {
	   $output = "Failed to connect: $smtpResponse";
	   echo "Not send";
	   return $output;
	}
	else {
	   $logArray['connection'] = "<p>Connected to: $smtpResponse";
	}

	//you have to say HELO again after TLS is started
	fputs($smtpConnect, "HELO $localhost". $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['heloresponse2'] = "$smtpResponse";
	   
	//request for auth login
	fputs($smtpConnect,"AUTH LOGIN" . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['authrequest'] = "$smtpResponse";

	//send the username
	fputs($smtpConnect, base64_encode($username) . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['authusername'] = "$smtpResponse";

	//send the password
	fputs($smtpConnect, base64_encode($password) . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['authpassword'] = "$smtpResponse";

	//email from
	fputs($smtpConnect, "MAIL FROM: <$from>" . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['mailfromresponse'] = "$smtpResponse";

	//email to
	fputs($smtpConnect, "RCPT TO: <$to>" . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['mailtoresponse'] = "$smtpResponse";

	//the email
	fputs($smtpConnect, "DATA" . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['data1response'] = "$smtpResponse";

	//construct headers
	$headers = "MIME-Version: 1.0" . $newLine;
	$headers .= "Content-type: text/html; charset=iso-8859-1" . $newLine;
	$headers .= "To: $nameto <$to>" . $newLine;
	$headers .= "From: $namefrom <$from>" . $newLine;

	//observe the . after the newline, it signals the end of message
	fputs($smtpConnect, "To: $to\r\nFrom: $from\r\nSubject: $subject\r\n$headers\r\n\r\n$message\r\n.\r\n");
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['data2response'] = "$smtpResponse";

	// say goodbye
	fputs($smtpConnect,"QUIT" . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['quitresponse'] = "$smtpResponse";
	$logArray['quitcode'] = substr($smtpResponse,0,3);
	fclose($smtpConnect);
	//a return value of 221 in $retVal["quitcode"] is a success
	return($logArray);
}
	//details about email content
	//***************************///
		$sqlSelect="SELECT traineeid, email, firstname,lastname, fullname FROM mdl_cifa_modulesubscribe a, mdl_cifacourse b WHERE a.courseid = b.id And (a.invoiceno='".$invoice."')";
		$querySelect=mysql_query($sqlSelect);
		$sqlRow=mysql_fetch_array($querySelect);
		
		$email=$sqlRow['email'];
		$firstname=$sqlRow['firstname'];
		$lastname=$sqlRow['lastname'];
		$coursename=$sqlRow['fullname'];
	
	//trainee fullname
	$name=$firstname.' '.$lastname;

	/*$transaction_content="
		<p>Dear $firstname $lastname </p><br/>

		<p>Candidate ID: $option_selection2</p><br/>

		<p>
		<br/>Merchant reference: $invoice
		<br/>Transaction ID: $txn_id
		</p><br/>

		<p>We are pleased to confirm your payment of $mc_currency $amount has now been received and your account has been settled. If you would like confirmation of payment you can print out a financial statement by logging onto CIFA Workspace and selecting the option Financial Statement under “My Financials”. SHAPE<sup>TM</sup> does not issue receipts.</p>
		<br/><p>Please use the link below to access CIFA Workspace<br/>
		<a href='www.CIFAOnline.com/workspace' target='_blank'>www.CIFAOnline.com/workspace</a> </p>														
	";*/

$transaction_content="<table width='100%' style='text-align:justify;' border='0'>
  <tr>
    <td>Dear  ($firstname $lastname)</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>IPD  Candidate ID: $option_selection2<br />
Temporary  password: $pword_text</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>I am pleased to welcome you as a new candidate to  SHAPETM Islamic Professional Development (IPD) Training Program.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>You have taken the first step to enhance your  knowledge in Islamic Finance. Your Candidate ID is <strong>$option_selection2</strong>. Please quote this in all future correspondence with us.  You may proceed to the first time login to your CIFA Workspace by using the Candidate  ID and the temporary password given in this email. </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Please refer to (<u>CIFA workspace</u>) section of the <a href='http://www.CIFAOnline.com/faq'>www.CIFAOnline.com/faq</a> for  more information on workspace functionalities and accessing the online training  program. </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>CIFA  Workspace enables you access to the online training portal, update personal details i.e.  address/email, participate in the CIFA Community activities, access to  candidate support area and attempting your test online, viewing your result and  certification.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Since you have opted for SHAPE (IPD), you will be  entitled to Certificate of Completion for each course you pass. You will not be  required to take other examination as it is not part of the program  requirement.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>However, along the way if you wish to enroll for  the CIFA Certification program, you may proceed to purchase the CIFA Curriculum  Trainings. For more information on CIFA Curriculum, please visit <a href='http://www.CIFAOnline.com/cifaconcept'>www.CIFAOnline.com/cifaconcept</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td>As an active IPD Candidate, you may start your IPD  courses via <u>My Training Program</u> link under <strong>&ldquo;My Training&rdquo;</strong> in your CIFA Workspace. You will be able to see the  SHAPE (IPD) courses that you have chosen. To start, simply click on the <strong>START</strong> button.</td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td>You may now proceed to login to your workspace  using the link below<br />
    <a href='http://www.CIFAOnline.com/workspace'>www.CIFAOnline.com/workspace</a></td>
  </tr>                  
</table>";	
														
	$from="mohd.arizan@mmsc.com.my"; //administrator mail
	$namefrom="CIFA Administrator";
	$to = $email;
	$nameto = $name;
	$subject = "[ Purchase a module transaction ]";
	$message = "
		$transaction_content";
	// this is it, lets send that email!
	authgMail($from, $namefrom, $to, $nameto, $subject, $message);
?>