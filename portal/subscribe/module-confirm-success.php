<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title>cifa</title>
    <style type="text/css" media="all">
    
    body {
        font: 0.8em arial, helvetica, sans-serif;
    }
	   
    #header ul {
        /*list-style: none;*/
        padding: 0;
        margin: 0;
		list-style-type: none;
    }
    
    #header li {
		list-style-type: none;
        float: left;
        border: 1px solid #bbb;
        border-bottom-width: 0;
        margin: 0;
    }
    
    #header a {
        text-decoration: none;
        display: block;
        background: #eee;
        padding: 0.24em 1em;
        color: #00c;
        width: 8em;
        text-align: center;
    }
    
    #header a:hover {
        background: #ddf;
    }
    
    #header #selected {
        border-color: #cccccc;
    }
    
    #header #selected a {
        position: relative;
        top: 1px;
        background: white;
        color: black;
        font-weight: bold;
    }
    
    #content {
        border: 1px solid #cccccc;
        clear: both;
        padding: 0 1em;
		background-color:#FFFFCC;
    }
    
    h1 {
        margin: 0;
        padding: 0 0 1em 0;
    }
	
	#content.col1{ width:100%; float:left; font-weight:bold; }
	#content.col2{ float:left; font-weight:bold; text-align:center; }
	#content.col3{ float:left; }
	
	
    </style>
</head>
<body>
<br/>
<div id="header">
<ul>
    <li><a href="fullpackage.php?fullpackage-module">Full Package</a></li>
    <li><a href="coursecountent.php?course-content">Course Content</a></li>
    <li id="selected"><a href="moduletest.php?module-test">Module Test</a></li>
</ul>
</div>

<div id="content">
  <p>
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
	   //echo $output;
	   echo "Not send";
	   return $output;
	}
	else {
	   $logArray['connection'] = "<p>Connected to: $smtpResponse";
	   //echo "<p />connection accepted<br>".$smtpResponse."<p />Continuing<p />";
	   
	   echo "<p>Thank your for subscribed our module $name.</p>";
	   include('subscribe/paypal/payment.php');
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
	
	$module = $_POST['modulename'];			//trainee name
	$attempts = $_POST['attempts']; 				//trainee email
	$coursename = $_POST['coursename']; 	//kursus yg dipilih oleh trainee
	$price = $_POST['price']; 	//level kursus yg dipilih
	$traineeID = $_POST['traineeid']; 			//harga kursus yg dipilih
	$trainee_name = $_POST['name'];
	$address = $_POST['trainee_address'];
	$email = $_POST['email'];
	$phone = $_POST['phone_no'];
	
	$from="mohd.arizan@mmsc.com.my"; 
	$namefrom="CIFA Administrator";
	$to = $email;
	$nameto = "Module test subscribers";
	$subject = "Online purchasing module";

	$message = "<p>Thank you for purchasing our module, below show details about your purchasing:- </p><br/>
		<p><b><u>Module Details</u></b></p>
	    <p><b>Module Test Name: </b>	$module<br/>
	    <b>Attempts Allow: </b>		$attempts<br/>
	    <b>Course name:</b> 		$coursename<br/>
	    <b>Price: </b>				$price</p><br/>

	    <p><b><u>Trainee Details</u></b></p>
	    <p><b>Trainee ID:</b> 		$traineeID<br/>
	    <b>Trainee Name: </b>	$trainee_name<br/>
	    <b>Address: </b>		$address<br/>
	    <b>Email:</b> 			$email<br/>
	    <b>Phone Num.:</b> 		$phone</p><br/>
		<p>Now, you are enroll for the module. <a href='http://localhost/cifa' target='_blank'>Login to cifa</a></p>";
	// this is it, lets send that email!
	authgMail($from, $namefrom, $to, $nameto, $subject, $message);

?>
  </p>
  <br/>
</div>
<?php //} ?>
</body>
</html>

