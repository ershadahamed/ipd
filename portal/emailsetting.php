<?php
	$sqlSelect="SELECT traineeid, email, firstname,lastname, fullname FROM mdl_cifa_modulesubscribe a, mdl_cifacourse b WHERE a.courseid = b.id And (a.invoiceno='".$invoice."')";
	$querySelect=mysql_query($sqlSelect);
	$sqlRow=mysql_fetch_array($querySelect);

	$email=$sqlRow['email'];
	$firstname=$sqlRow['firstname'];
	$lastname=$sqlRow['lastname'];
	$coursename=$sqlRow['fullname'];

	//trainee fullname
	$name=$firstname.' '.$lastname;
	
	//content 1 // Candidate Enrolment Confirmation – SHAPE (IPD)
	$IPD_content='
		<table width="80%" border="0" cellpadding="1" cellspacing="1">
		  <tr><td>Dear  ('.$name.')</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr>
			<td>
				IPD  Candidate ID: '.$option_selection2.'<br />
				Temporary  password: $Password01$
			</td>
		  </tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>I am pleased to welcome you as a new candidate to  SHAPETM Islamic Professional Development (IPD) Training Program.</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>You have taken the first step to enhance your  knowledge in Islamic Finance. Your Candidate ID is <strong>'.$option_selection2.'</strong>. Please quote this in all future correspondence with us.  You may proceed to the first time login to your CIFA Workspace by using the Candidate  ID and the temporary password given in this email. </td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>Please refer to (<u>CIFA workspace</u>) section of the <a href="http://www.CIFAOnline.com/faq">www.CIFAOnline.com/faq</a> for  more information on workspace functionalities and accessing the online training  program. </td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>CIFA  Workspace enables you access to the online training portal, update personal details i.e.  address/email, participate in the CIFA Community activities, access to  candidate support area and attempting your test online, viewing your result and  certification.</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>Since you have opted for SHAPE (IPD), you will be  entitled to Certificate of Completion for each course you pass. You will not be  required to take other examination as it is not part of the program  requirement.</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>However, along the way if you wish to enroll for  the CIFA Certification program, you may proceed to purchase the CIFA Curriculum  Trainings. For more information on CIFA Curriculum, please visit <a href="http://www.CIFAOnline.com/cifaconcept">www.CIFAOnline.com/cifaconcept</a></td></tr>
		  <tr><td>&nbsp;</td></tr> 
		  <tr><td>As an active IPD Candidate, you may start your IPD  courses via <u>My Training Program</u> link under <strong>&ldquo;My Training&rdquo;</strong> in your CIFA Workspace. You will be able to see the  SHAPE (IPD) courses that you have chosen. To start, simply click on the <strong>START</strong> button.</td></tr> 
		  <tr><td>&nbsp;</td></tr> 
		  <tr><td>You may now proceed to login to your workspace  using the link below<br /><a href="http://www.CIFAOnline.com/workspace">www.CIFAOnline.com/workspace</a></td></tr>                  
		</table>	
	';
	
	//content 2 // Payment Confirmation
	$transaction_content="
		<p>Dear $name </p><br/>

		<p>Candidate ID: $option_selection2</p><br/>

		<p>
		Thank you, your payment was successful.<br/>
		<br/>Merchant reference: $invoice
		<br/>Transaction ID: $txn_id
		</p><br/>

		<p>We are pleased to confirm your payment of $mc_currency $amount has now been received and your account has been settled. If you would like confirmation of payment you can print out a financial statement by logging onto CIFA Workspace and selecting the option Financial Statement under “My Financials”. SHAPE<sup>TM</sup> does not issue receipts.</p>
		<br/><p>Please use the link below to access CIFA Workspace<br/>
		<a href='www.CIFAOnline.com/workspace' target='_blank'>www.CIFAOnline.com/workspace</a> </p>														
	";	
	
	//email configuration.
	if (!isloggedin()) {
		$from="arizanabdullah@gmail.com"; //administrator mail
		$namefrom="CIFA Administrator";
		$to = $email;
		$nameto = $name;
		$subject = "[ Purchase a module transaction ]";
		$message = "$IPD_content";
				
		// this is it, lets send that email!
		authgMail($from, $namefrom, $to, $nameto, $subject, $message);	
	}else{													
		$from="mohd.arizan@mmsc.com.my"; //administrator mail
		$namefrom="CIFA Administrator";
		$to = $email;
		$nameto = $name;
		$subject = "[ Purchase a module transaction ]";
		$message = "$transaction_content";
		
		// this is it, lets send that email!
		authgMail($from, $namefrom, $to, $nameto, $subject, $message);
	}
?>