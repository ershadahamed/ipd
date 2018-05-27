<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	$output_dir = "uploads/";

	$fullname=$_POST['contactus_firstname'];
	$email=$_POST['contactus_email'];
	$email22="arizanabdullah.pbms@gmail.com";
	$subjectcontent=$_POST['contactus_subject'];
	$messageto=$_POST['contactus_message'];
	
	if($subjectcontent != '' & $messageto !=''){
	if(isset($_FILES["myfile"]))
	{
		//Filter the file types , if you want.
		if ($_FILES["myfile"]["error"] > 0)
		{
		  echo "Error: " . $_FILES["file"]["error"] . "<br>";
		}
		else if($_FILES['myfile']['size'] > (1024000)) //can’t be larger than 1 MB
		{
			echo "Oops! Your file\’s size is to large.";
		?>
				<script type="text/javascript">
				window.alert('Oops! Your file`s size is to large.')
				//window.location.href = '<?=$CFG->wwwroot. "/contactus/upload_index.php";?>';   
				</script>	
		<?php				
		}		
		else
		{
			//move the uploaded file to uploads folder;
			move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $_FILES["myfile"]["name"]);
			$path=$output_dir.$_FILES["myfile"]["name"];
			$fileupload=$_FILES["myfile"]["name"];
			
			/* $qsemak=mysql_query("SELECT filename FROM mdl_cifauploaded_files WHERE filename='".$fileupload."'");
			$skira=mysql_num_rows($qsemak);
			echo $qsemak; */
			
			$qsimpan=mysql_query("
				INSERT INTO mdl_cifauploaded_files 
				SET fullname='".$fullname."', email='".$email."', subject='".$subjectcontent."', message='".$messageto."', filename='".$fileupload."', path='".$path."', uploadby='".$USER->id."'");	
			
			if($qsimpan){ 
				// echo 'Thank you for your email, we will revert back to you within 72 hours..<br />';		
				// echo "Uploaded File :".$_FILES["myfile"]["name"];
		
		// Get a support email from DB
		$sqlsupportemail=mysql_query("SELECT * FROM {$CFG->prefix}config WHERE name='supportemail'");
		$q_supportemail=mysql_fetch_array($sqlsupportemail);
		$supportemail=$q_supportemail['value'];
		
		// email to Administrator
		$to = $supportemail;
		$subject = $subjectcontent;
		$message = $messageto;
		
		// Always set content-type when sending HTML email
		$link=$CFG->wwwroot;
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		// More headers
		$headers .= 'From: <'.$email.'>' . "\r\n";
		//$headers .= 'Cc: mohd.arizan@mmsc.com.my'. "\r\n";
		
		mail($to,$subject,$message,$headers);
		// End email to Administrator
	
		// email to commenter
		$to = $email;
		$subject = "Auto-response: This is system generated email. Please do not reply";
		
		$message = "
				<html>
				<head>
					<title>HTML email</title>
				</head>
				<body>
					<p>Dear (".strtoupper($fullname)."),</p>
				<p>Thank you for your email.</p>
				<p style='text-align:justify;'>
					Please be informed that our service manager is going through your request and we will get back to you within 3 working days.
					</p>
					
				<p style='text-align:justify;'>
					Please note that this is a system generated email. Please  do not reply to this email. For  assistance, please use the <strong><u>contact us</u></strong> facility  at IPD Online Portal. 
					</p>

				<p>
					Our operation hours are as follows:<br>
					Sunday – Thursday : 9.00am – 5.00pm GMT+3<br>
					Closed on Friday, Saturday &amp; Public Holidays.
				</p><p></p>
				<p>Yours Sincerely, <br>
				<strong>SHAPE&reg; Knowledge Services</strong></p>
				<p style='font-size:11px'><strong>Disclaimer:</strong> <br>
				  This is a system  generated email. Please do not reply. For assistance, please <strong><u>contact us</u></strong> and we will revert back to you within 72 hours. </p>
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

?>
				<script type="text/javascript">
				window.alert('Thank you for your email, we will revert back to you within 72 hours.')
				window.location.href = '<?=$CFG->wwwroot;?>';   
				</script>	
<?php				
				
				
			}else{
				// echo 'Your file fail to send. Please send again. Thank you.<br />';
?>
				<script type="text/javascript">
				window.alert('Your file fail to send. Please send again. Thank you')
				//window.location.href = '<?=$CFG->wwwroot. "/contactus/upload_index.php";?>';   
				</script>	
<?php				
			}
		}

	}
	
	if($_FILES["myfile"]==''){ //only contact us details without upload files
		$qsimpan=mysql_query("
			INSERT INTO mdl_cifauploaded_files 
			SET fullname='".$fullname."', email='".$email."', subject='".$subjectcontent."', message='".$messageto."', 
			uploadby='".$USER->id."'");		
				
		if($qsimpan){ 
			//echo 'File has been send to us.<br />';
			
		// Get a support email from DB
		$sqlsupportemail=mysql_query("SELECT * FROM {$CFG->prefix}config WHERE name='supportemail'");
		$q_supportemail=mysql_fetch_array($sqlsupportemail);
		$supportemail=$q_supportemail['value'];
		
		// email to Administrator
		$to = $supportemail;
		$subject = $subjectcontent;
		$message = $messageto;
		
		// Always set content-type when sending HTML email
		$link=$CFG->wwwroot;
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		// More headers
		$headers .= 'From: <'.$email.'>' . "\r\n";
		//$headers .= 'Cc: mohd.arizan@mmsc.com.my'. "\r\n";
		
		mail($to,$subject,$message,$headers);
		// End email to Administrator
	
		// email to commenter
		$to = $email;
		$subject = "Auto-response: This is system generated email. Please do not reply";
		
		$message = "
				<html>
				<head>
					<title>HTML email</title>
				</head>
				<body>
					<p>Dear (".strtoupper($fullname)."),</p>
				<p>Thank you for your email.</p>
				<p style='text-align:justify;'>
					Please be informed that our service manager is going through your request and we will get back to you within 3 working days.
					</p>
					
				<p style='text-align:justify;'>
					Please note that this is a system generated email. Please  do not reply to this email. For  assistance, please use the <strong><u>contact us</u></strong> facility  at IPD Online Portal. 
					</p>

				<p>
					Our operation hours are as follows:<br>
					Sunday - Thursday : 9.00am - 5.00pm GMT+3<br>
					Closed on Friday, Saturday &amp; Public Holidays.
				</p><p></p>
				<p>Yours Sincerely, <br>
				<strong>SHAPE&reg; Knowledge Services</strong></p>
				<p style='font-size:11px'><strong>Disclaimer:</strong> <br>
				  This is a system  generated email. Please do not reply. For assistance, please <strong><u>contact us</u></strong> and we will revert back to you within 72 hours. </p>
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
			
?>
			<script type="text/javascript">
			window.alert('Thank you for your email, we will revert back to you within 72 hours.')
			window.location.href = '<?=$CFG->wwwroot;?>';   
			</script>	
<?php		
			//echo "Uploaded File :".$_FILES["myfile"]["name"];
		}else{
			//echo 'Your file fail to send.<br />';
?>
			<script type="text/javascript">
			window.alert('Your file fail to send. Please send again. Thank you')
			//window.location.href = '<?=$CFG->wwwroot;?>';   
			</script>	
<?php			
		}					
	}
	}else{
?>
			<script type="text/javascript">
			window.alert('You need to fillup required fields.')
			window.location.href = '<?=$CFG->wwwroot;?>';   
			</script>	
<?php } ?>