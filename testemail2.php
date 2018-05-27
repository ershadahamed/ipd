<?php	
    include('config.php');
	include('manualdbconfig.php'); 
	
	$sqlusers=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='142'");
	$sqluserlist=mysql_fetch_array($sqlusers);
	
	$ucfullname=$sqluserlist['firstname'].' '.$sqluserlist['middlename'].' '.$sqluserlist['lastname'];
	$yes=strtoupper($sqluserlist['traineeid']);
	
	$name=$sqluserlist['firstname'].' '.$sqluserlist['middlename'].' '.$sqluserlist['lastname'];
	$traineeID=strtoupper($sqluserlist['traineeid']);	
								
	// Set email notification (IPD candidate enrollment confirmation).
	$sqlsupportemail=mysql_query("SELECT * FROM {$CFG->prefix}config WHERE name='supportemail'");
	$q_supportemail=mysql_fetch_array($sqlsupportemail);
	$supportemail=$q_supportemail['value'];

	// email to commenter
/* 	$to = "arizan_86@yahoo.com";
	$subject = "Next Step:  ".strtoupper($yes)." - Candidate Enrolment Confirmation >> IPD COURSE TITLE";
	
	$message = "
		<html>
		<head>
			<title>HTML email</title>
		</head>
		<body>
		<p>Dear (".strtoupper($ucfullname)."),</p>
		<br/><p>IPD Candidate ID: ".strtoupper($yes)."<br/>
		Temporary password: ".get_string('temporarypassword')."
		</p>
		<br/><p style='text-align:justify;'>
		I am pleased to welcome you as a new candidate to Islamic Professional Development (IPD) Training Program.
		</p>
			
		<br/><p style='text-align:justify;'>
		You have taken the first step to enhance your knowledge in Islamic Finance. Your Candidate ID is <strong>".strtoupper($yes)."</strong>. Please quote this in all future correspondence with us. You may proceed to the first time login to your IPD Online by using the Candidate ID and the temporary password given in this email. </p>

		<br/><p style='text-align:justify;'>
		IPD Online enables you access to the online training portal, update personal details i.e. address/email, participate in the community activities, access to candidate support area, attempting your test online, viewing your result and certification.</p> 

		<br/><p style='text-align:justify;'>
		Since you have opted for IPD, you will be entitled to Certificate of Completion for each course you pass. You will not be required to take other examination as it is not part of the program requirement.</p>

		<br/><p style='text-align:justify;'>However, along the way if you wish to enroll for  the CIFA&#8482; Certification program, you may proceed to  purchase the CIFA Curriculum Trainings. For more information on CIFA&#8482;  Curriculum, please visit <a href='http://www.Learncifa.com/structure'>www.Learncifa.com/structure</a></p>

		<br/><p style='text-align:justify;'>As an active IPD Candidate, you may start your IPD  courses via <u>Active Training</u> link under <strong>&quot;My Training&quot;</strong>. You will be able to see the SHAPE<sup>&reg;</sup> IPD courses that  you have chosen. Click on the <strong>LAUNCH</strong> button to begin your training.</p>

		<br/><p style='text-align:justify;'>You may now proceed to login to your IPD Online  using the link below<br>
		  <a href='http://ipdonline.consultshape.com' target='_blank'>ipdonline.consultshape.com</a></p>
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
	// $headers .= 'Cc: arizanabdullah.pbms@gmail.com'. "\r\n";
	
	mail($to,$subject,$message,$headers);
	// end email config
	
			// CANDIDATE PART-ENROLMENT CONFIRMATION
			// email to commenter
			$to = "arizan_86@yahoo.com";
			$subject = "Next Step: ".$traineeID." - Candidate Part-Enrolment Confirmation";
			
			$message = "
				<html>
				<head>
					<title>HTML email</title>
				</head>
				<body>
				<p>Dear (".ucwords(strtolower($name))."),</p>
				<br/><p>Candidate ID: ".$traineeID."</p>
				
				<br/><p style='text-align:justify;'>
				I am pleased to congratulate you to have taken the first step in enrolling as SHAPE<sup>&reg;</sup> IPD Candidate. Your Candidate ID is <strong>".$traineeID."</strong> . Please quote this in all future correspondence with us.</p>
					
				<br/><p style='text-align:justify;'>
				The next step is to wire transfer the relevant payment to us within the stipulated 4 weeks to ensure your successful enrolment as a SHAPE<sup>&reg;</sup> IPD Candidate. Failing to meet the deadline, your enrolment will be cancelled.</p>

				<br/><p>Please pay to:<br>
				SHAPE for Economic  Consulting W.L.L at Boubyan Bank</p>
				
				<br/><table width='100%' border='1'>
				  <tr>
					<td width='34%'>Branch</td>
					<td width='2%'>:</td>
					<td width='64%'>Sharq Branch</td>
				  </tr>
				  <tr>
					<td>Account Title/Beneficiary</td>
					<td>:</td>
					<td>SHAPE for Economic Consulting W.L.L</td>
				  </tr>
				  <tr>
					<td>SWIFT Code</td>
					<td>:</td>
					<td>BBYNKWKW</td>
				  </tr>
				  <tr>
					<td>IBAN # </td>
					<td>:</td>
					<td>KW62 BBYN 0000 0000 0000 0203 3190 02</td>
				  </tr>
				  <tr>
					<td>Account Number</td>
					<td>:</td>
					<td>0203319002</td>
				  </tr>
				  <tr>
					<td>Reference</td>
					<td>:</td>
					<td>".$traineeID."</td>
				  </tr>
				</table>

				<br/><p style='text-align:justify;'>You will be liable  for the additional charges incurred in the bank transfer. Please be sure to  send the successful bank transfer slip with your Candidate ID to <strong><u><a href='http://134.213.66.124/shapeipd/contactus/upload_index.php' target='_blank'>contact us</a></u></strong>. The process to verify  payment and updating your status may take up to 7 days. </p>										
				
				<br/><p style='text-align:justify;'>
				Once your status has been updated, you will receive another email guiding you to login to your IPD Online and start your training with us. </p>

				<br/><p style='text-align:justify;'>&nbsp;</p> 

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
			//$headers .= 'Cc: mohd.arizan@mmsc.com.my'. "\r\n";
			
			mail($to,$subject,$message,$headers);
			// end email config	

		
						
		// email to commenter
					// ENROLLMENT NOT COMPLETE
					// email to commenter
						$to = "arizan_86@yahoo.com";
						$subject = "Reminder: ".$traineeID." - Enrollment Not Complete";
						
						$message = "
							<html>
							<head>
								<title>HTML email</title>
							</head>
							<body>
							<p>Dear (".$name)."),</p>
							<p>IPD Candidate ID: ".$traineeID."</p>
							
							<br/><p style='text-align:justify;'>This is a brief reminder that your enrolment process is not complete.</p>										
							<br/><p style='text-align:justify;'>We have yet to receive the payment via bank transfer and your user status is currently prospect.</p>
							<br/><p style='text-align:justify;'>In order for you to enjoy the benefit of the training program and gain access to the online training portal, a complete enrolment inclusive of payment must be completed within duration of 4 weeks from the point you do the part-enrolment process online.  If we do not receive the payment within the stipulated timeline, your enrolment will be cancelled.</p> 
							<br/><p style='text-align:justify;'>However, if you have remitted the payment and received a confirmation from us on the payment receipt, kindly ignore this email. Once we have cleared the payment, your status will be updated to active candidate and you may continue with your training via IPD Online.</p> 
							<br/><p style='text-align:justify;'>If your employer sponsors your training, it might be a good idea to check that the payment is on its way to us.</p> 
							<br/><p style='text-align:justify;'>We are looking forward to welcoming you as our active candidate.</p> 
							
							<br/><p style='text-align:justify;'>&nbsp;</p> 

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
						//$headers .= 'Cc: mohd.arizan@mmsc.com.my'. "\r\n";
						
						mail($to,$subject,$message,$headers); */	


						// Next Step:  CANDIDATE ID - Candidate Enrolment Cancellation
						// email to commenter
						$to = "arizan_86@yahoo.com";
						$subject = "Next Step:  ".$traineeID." - Candidate Enrollment Cancellation";
						
						$message = "
							<html>
							<head>
								<title>HTML email</title>
							</head>
							<body>
							<p>Dear (".$name."),</p>
							<p>IPD Candidate ID: ".$traineeID."</p>
							<br/><p style='text-align:justify;'>
							We regret to inform you that your enrolment has been cancelled thus you will not be able to pursue your training with us. However, if you have remitted the payment, kindly contact us to resolve the misunderstanding. 
							</p>
																		
							<br/><p style='text-align:justify;'>
							If you still wish to enroll as a SHAPE<sup>&reg;</sup> IPD candidate, please repeat the enrolment process and remit the payment within the stipulated timeline. However, we wish to remind you that you may not be entitled to any promotions which you signed up for earlier.</p>

							<br/><p style='text-align:justify;'>&nbsp;</p> 

							<br/><p>Yours Sincerely, <br>
							<strong>SHAPE<sup>&reg;</sup> Knowledge Services</strong></p>
							
							<br/><p style='font-size:11px'><strong>Disclaimer:</strong><br>
							This is a system  generated email. Please do not reply. For assistance, please <strong><u><a href='http://134.213.66.124/shapeipd/contactus/upload_index.php' target='_blank'>contact us</a></u></strong> and we will revert back to you within 72 hours.</p>
							</body>
							</html>
						";
						
						// Always set content-type when sending HTML email
						$link=$CFG->wwwroot;
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						
						// More headers
						$headers .= 'From: <'.$supportemail.'>' . "\r\n";
						//$headers .= 'Cc: mohd.arizan@mmsc.com.my'. "\r\n";
						
						mail($to,$subject,$message,$headers);
						// end email config	
											
?>