<?php
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
	   echo $output;
	   return $output;
	}
	else {
	   $logArray['connection'] = "<p>Connected to: $smtpResponse";
	   echo "<p />connection accepted<br>".$smtpResponse."<p />Continuing<p />";
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
	
/*	$err=0;  // so far, so good
	$err_msg="";

	if($_POST['name_']!="") { echo $_POST['name_']."<br>"; }
	else {
	  $err=1;
	  $err_msg="You must include your name";
	}

	if($_POST['day_phone_']!="") {echo $_POST['day_phone_']."<br>"; }
	else {
	  $err=1;
	  $err_msg="You must include a daytime phone number.";
	}
	if($_POST['add_']!="") { echo $_POST['add_']."<br>"; }
	else {
	  $err=1;
	  $err_msg="You must include your address.";
	}
	if($_POST['city_']!="") { echo $_POST['city_']."<br>"; }
	else {
	  $err=1;
	  $err_msg="You must include the city.";
	}
	// Check for the existence of an AT symbol inside the email.
	if (strpos($_POST['email'],"@")) { echo $_POST['email']."<br>"; } 
	else {
	  $err=1;
	  $err_msg="You must include a current email address.";
	}
	if($_POST['email']!="") { echo $_POST['email']."<br>"; }
	else {
	  $err=1;
	  $err_msg="You must include your e-mail address.";
	}

	echo $err_msg;

	if($err<=0) {*/
		
	  $from="mohd.arizan@mmsc.com.my";
	  $namefrom="CIFA Administrator";
	  $to = "arizan_86@yahoo.com";
	  $nameto = "internal_user";
	  $subject = "Online purchasing module";
	  $message = "Thank u for the purchasing our fullpackage module....";
	  // this is it, lets send that email!
	  //authgMail($from, $namefrom, $to, $nameto, $subject, $message);
	  if(authgMail($from, $namefrom, $to, $nameto, $subject, $message)){
		echo "Thank your for subscribed our module.";
	  }else{
		echo "Not send";
	  }
	/*}
	else {
	 echo "<p /> This form was not filled out correctly, please correct any mistakes.";
	}*/

	?>



