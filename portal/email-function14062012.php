<?php
	include('../config.php');
	include('../manualdbconfig.php');

	function authgMail($from, $namefrom, $to, $nameto, $subject, $message) {
	
	$sqlEmail="
			Select
			  a.name,
			  a.value,
			  a.id
			From
			  mdl_cifaconfig a
			Where
			  (a.name = 'smtphosts') Or
			  (a.name = 'smtpuser') Or
			  (a.name = 'smtppass')";
			  
	$queryEmail=mysql_query($sqlEmail);
	$rowEmail=mysql_fetch_array($queryEmail);
	
	if($rowEmail['name']=='smtphosts'){ $smtpEmail=$rowEmail['value']; }
	if($rowEmail['name']=='smtpuser'){ $smtpUser=$rowEmail['value']; }
	if($rowEmail['name']=='smtppass'){ $smtppass=$rowEmail['value']; }
	
	$smtpServer = $smtpEmail; //"pop.mmsc.com.my";   //ip address of the mail server.  This can also be the local domain name
	$port = "25";					 // should be 25 by default, but needs to be whichever port the mail server will be using for smtp 
	$timeout = "45";				 // typical timeout. try 45 for slow servers
	$username = $smtpUser;//"mohd.arizan/mmsc.com.my"; // the login for your smtp
	$password = $smtppass;//"mohdarizan123";			// the password for your smtp
	$localhost = "127.0.0.1";	   // Defined for the web server.  Since this is where we are gathering the details for the email
	$newLine = "\r\n";			 // aka, carrage return line feed. var just for newlines in MS
	$secure = 0;				  // change to 1 if your server is running under SSL
	
	//connect to the host and port
	$smtpConnect = fsockopen($smtpServer, $port, $errno, $errstr, $timeout);
	$smtpResponse = fgets($smtpConnect, 4096);
	if(empty($smtpConnect)) {
	   $output = "Failed to connect: $smtpResponse";
	   //echo $output;
	   echo "Not send";
	   return $output;
	}
	else {
	   $logArray['connection'] = "<p>Connected to: $smtpResponse";
	   //echo "<p />connection accepted<br>".$smtpResponse."<p />Continuing<p />";
	   
	   //echo "<br/><p>Thank your for subscribed our module</p>";
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
	$nameto = $name;
	$subject = "[courses enroll]";
	$message = "Hi <b>$name</b>, you have been enroll for this courses $coursename. Please login CIFA ONLINE.";
	// this is it, lets send that email!
	authgMail($from, $namefrom, $to, $nameto, $subject, $message);
?>