<?php
    require_once('config.php');
	include('manualdbconfig.php'); 
	include_once ('pagingfunction.php');
	include('function/emailfunction.php');
	
	
	// $s=mysql_query("SELECT firstaccess,orgtype,id, firstname, lastname, username, traineeid, country, email FROM mdl_cifauser WHERE deleted!='1' AND (country='AE' OR country='IQ') AND firstaccess='0' AND usertype='Active candidate'");
	// $s=mysql_query("SELECT firstaccess,orgtype,id, firstname, lastname, username, traineeid, country, email FROM mdl_cifauser WHERE id='196'");
	$s=mysql_query("SELECT firstaccess,orgtype,id, firstname, lastname, username, traineeid, country, email FROM mdl_cifauser WHERE id='209' ORDER BY id DESC");
	while($se=mysql_fetch_array($s)){
		echo $se['id'].' / '.$se['firstname'].' / '.$se['lastname'].' / '.$se['username'].' / '.$se['traineeid'].' / '.$se['country'];
		echo ' / '.$se['orgtype'];
		echo ' / '.date('dmY',$se['firstaccess']);
		
		if ($se['firstaccess']) {
               echo ' / '.$strlastaccess = format_time(time() - $se['firstaccess']);
            } else {
               echo ' / '.$strlastaccess = get_string('never');
            }
		echo "<br/>";
	// }	
	
	/* $scandidate=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='134'");
	// while($ssqlu=mysql_fetch_array($scandidate)){
	$ssqlu=mysql_fetch_array($scandidate); */
	
	// Set email notification (IPD candidate enrollment confirmation).
	$sqlsupportemail=mysql_query("SELECT * FROM {$CFG->prefix}config WHERE name='supportemail'");
	$q_supportemail=mysql_fetch_array($sqlsupportemail);
	$supportemail=$q_supportemail['value'];	
	
/* 	$ctfname=$ssqlu['firstname']." ".$ssqlu['lastname'];
	$cemail=$ssqlu['email'];
	$ctraineeid=$ssqlu['traineeid']; */
	
	$ctfname=$se['firstname']." ".$se['lastname'];
	$cemail=$se['email'];
	// $cemail="mohd.arizan@mmsc.com.my";
	$ctraineeid=$se['traineeid'];	


	// email to commenter
	$to = $cemail;
	$subject = "Next Step: ".strtoupper($ctraineeid)." - Candidate Enrolment Confirmation >> IPD COURSE TITLE";
	
	$message = "
		<html>
		<head>
			<title>HTML email</title>
		</head>
		<body>
		<p>Dear (".strtoupper($ctfname)."),</p>
		<br/><p>IPD Candidate ID: ".strtoupper($ctraineeid)."<br/>
		Temporary password: ".get_string('temporarypassword')."
		</p>
		<br/><p style='text-align:justify;'>
		I am pleased to welcome you as a new candidate to Islamic Professional Development (IPD) Training Program.
		</p>
			
		<br/><p style='text-align:justify;'>
		You have taken the first step to enhance your knowledge in Islamic Finance. Your Candidate ID is <strong>".strtoupper($ctraineeid)."</strong>. Please quote this in all future correspondence with us. You may proceed to the first time login to your IPD Online by using the Candidate ID and the temporary password given in this email. </p>

		<br/><p style='text-align:justify;'>
		IPD Online enables you access to the online training portal, update personal details i.e. address/email, participate in the community activities, access to candidate support area, attempting your test online, viewing your result and certification.</p> 

		<br/><p style='text-align:justify;'>
		Since you have opted for IPD, you will be entitled to Certificate of Completion for each course you pass. You will not be required to take other examination as it is not part of the program requirement.</p>

		<br/><p style='text-align:justify;'>However, along the way if you wish to enroll for  the CIFA&#8482; Certification program, you may proceed to  purchase the CIFA Curriculum Trainings. For more information on CIFA&#8482;  Curriculum, please visit <a href='http://www.Learncifa.com/structure'>www.Learncifa.com/structure</a></p>

		<br/><p style='text-align:justify;'>As an active IPD Candidate, you may start your IPD  courses via <u>Active Training</u> link under <strong>&quot;My Training&quot;</strong>. You will be able to see the SHAPE<sup>&reg;</sup> IPD courses that  you have chosen. Click on the <strong>LAUNCH</strong> button to begin your training.</p>

		<br/><p style='text-align:justify;'>You may now proceed to login to your IPD Online  using the link below<br>
		  <a href='http://ipdonline.consultshape.com/' target='_blank'>ipdonline.consultshape.com</a></p>
		<p style='text-align:justify;'>&nbsp;</p> 

		<br/><p>Yours Sincerely, <br>
		<strong>SHAPE<sup>&reg;</sup> Knowledge Services</strong></p>
		<br/><p style='font-size:11px'><strong>Disclaimer:</strong> <br>
		  This is a system  generated email. Please do not reply. For assistance, please <strong><u><a href='http://134.213.66.124/shapeipd/contactus/upload_index.php' target='_blank'>contact us</a></u></strong> and we will revert back to you within 72 hours. </p>
		</body>
		</html>
	";
	
	// Always set content-type when sending HTML email
	$link=$CFG->wwwroot;
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	
	// More headers
	$headers .= 'From: <'.$supportemail.'>' . "\r\n";
	// $headers .= 'Cc: mohd.arizan@mmsc.com.my'. "\r\n";
	
	mail($to,$subject,$message,$headers);
	
	/////// AUTHMAIL ///////////////////////////////////////////////////////////////////////
	$from1=$supportemail;  
	$namefrom1="IPD Online";
	$nameto1 = "IPD Online"; 
			
	// this is it, lets send that email!
	authgMail($from1, $namefrom1, $to, $nameto1, $subject, $message);									
	// end email config
	}
	
	// echo $setup20=mysql_query("UPDATE mdl_cifauser SET postcode='SW1X 7LJ' WHERE id='194'");
?>