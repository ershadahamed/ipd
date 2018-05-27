<?php
//email to candidate yet to start
mysql_connect("localhost", "root", "E9z0YmGGfXO1") or die(mysql_error());
mysql_select_db("shapedblms") or die(mysql_error());


include('function/emailfunction.php');

$qry1 = "SELECT id FROM mdl_cifaenrol WHERE courseid = '32'";
$sql1 = mysql_query($qry1);
while($rs1 = mysql_fetch_array($sql1)){
	
	$qry2 = "SELECT b.firstname, b.lastname, b.traineeid, 
			FROM_UNIXTIME(b.firstaccess,'%d/%m/%Y') as startdate, 
			DATE_ADD(FROM_UNIXTIME(b.firstaccess,'%Y-%m-%d'), INTERVAL 60 DAY) as enddate, b.email 
			FROM mdl_cifauser_enrolments a, mdl_cifauser b 
			WHERE a.enrolid='".$rs1['id']."'
			AND a.userid=b.id";
			//AND b.timestart=0
	$sql2 = mysql_query($qry2);
	while($rs2 = mysql_fetch_array($sql2)){
	$splitdate = explode('-',$rs2['enddate']);
	$newenddate = $splitdate['2']."/".$splitdate['1']."/".$splitdate['0'];
	echo "<br>".$rs2['firstname']." ".$rs2['lastname']."=".$rs2['email']."=".$rs2['traineeid']."=".$rs2['startdate'].">".$newenddate;
	
			$name = $rs2['firstname']." ".$rs2['lastname'];
			$to = $rs2['email'];
			//$to = 'jeslynn@learncifa.com';
			$subject = "Reminder: ".strtoupper($rs2['traineeid'])." - Expiry of SHAPE Foundation of Islamic Banking and Finance Course Subscription";
						
						$message = "
							<html>
							<head>
								<title>HTML email</title>
							</head>
							<body>
							<p>Dear ".strtoupper($name).", Greetings from SHAPE<sup>&reg;</sup></p>
							<p>IPD Candidate ID: ".strtoupper($rs2['traineeid'])."</p>
							
							<p style='text-align:justify;'>This is a brief reminder that you have not started the SHAPE<sup>&reg;</sup> Foundation of Islamic Banking & Finance
							e-learning course and the access is due to expire by ".$newenddate.". Once expired, you will not be able to access the course online or take the test.</p>
							
							<p style='text-align:justify;'>To start the course and attempt the test, login to the SHAPE<sup>&reg;</sup> (IPD) portal with your provided username and password via the following link:
							<strong><u><a href='http://134.213.66.124/shapeipd/login/index.php' target='_blank'>http://134.213.66.124/shapeipd/login/index.php</a></u></strong></p>
							
							<p style='text-align:justify;'>If you have forgotten your username and/or password, click on the forgotten password link at the login page for immediate assistance.</p> 
							
							<p style='text-align:justify;'>We wish you all the best and hope to continuously support you throughout your training with us. </p> 
							
							<br/><p>Yours Sincerely, <br>
							<strong>Consult SHAPE<sup>&reg;</sup></strong></p>
							
							<br/><p style='font-size:11px'><strong>Disclaimer:</strong> <br>
							This is a system  generated email. Please do not reply. For assistance, please email us at info@consultSHAPE.com with your Candidate ID, fullname and email. We will revert back to you within 72 hours. </p>
							</body>
							</html>
						";
						
						// Always set content-type when sending HTML email
						
						$sqlsupportemail=mysql_query("SELECT * FROM mdl_cifaconfig WHERE name='supportemail'");
						$q_supportemail=mysql_fetch_array($sqlsupportemail);
						$supportemail=$q_supportemail['value'];
					
						$link=$CFG->wwwroot;
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						
						// More headers
						$headers .= 'From: <'.$supportemail.'>' . "\r\n";
						//$headers .= 'Cc: mohd.arizan@mmsc.com.my'. "\r\n";
						
						mail($to,$subject,$message,$headers);
						
						/////// AUTHMAIL ///////////////////////////////////////////////////////////////////////
						$from1=$supportemail;  
						$namefrom1="IPD Online";
						$nameto1 = "IPD Online"; 
								
						// this is it, lets send that email!
						authgMail($from1, $namefrom1, $to, $nameto1, $subject, $message);	
	
	echo "sent<br>";
	}//end of loop user list 
}//end of loop enrolment method for foundation.
?>