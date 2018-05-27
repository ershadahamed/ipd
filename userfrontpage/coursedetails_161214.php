<?php
    include('config.php');
	include('manualdbconfig.php');
	
	$courseid=$rowCourses['courseid'];
	$coursecode=$rowCourses['idnumber'];
		
	$choose=mysql_query("
		Select
		  a.fullname,
		  b.courseid,
		  c.enrolid,
		  d.firstname,
		  d.lastname,
		  c.userid,
		  c.timecreated,
		  c.timestart,
		  c.timeend,
		  d.firstaccess
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifaenrol b On a.id = b.courseid Inner Join
		  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
		  mdl_cifauser d On c.userid = d.id
		Where
		  b.courseid ='".$courseid."' And
		  c.userid = '".$USER->id."'	
	");	
	$sqldisplay=mysql_fetch_array($choose);
	
	$querycourse=mysql_query("SELECT * FROM mdl_cifacourse WHERE id='".$courseid."'");
	$sqldata=mysql_fetch_array($querycourse);
?>
<script type="text/javascript" src="../scripts/jquery-1.3.2.min.js"></script>
<style>
fieldset { 
	border:2px solid #5DCBEB;	
	width: 96%; 
	margin-left: auto;
	margin-right: auto;
	margin-bottom: 10px;
	padding: 1em 1em 0em;
	border-top-left-radius: 5px 5px;
	border-top-right-radius: 5px 5px;
}
</style>	
<form id="form1" name="form1" method="post" action="">
	<?php 
    $var=$_POST['extendtraining'];

	/* if($courseid==$_GET['courseid']){
		echo '<b><font color="green">Extend for 30 days</font></b><br/><br/>';
	} */
    ?> 
<table id="cifa-table" width="100%" border="0" align="center">
<tr><th><?=$sqldata['idnumber'].': '.$sqldata['fullname'];?></th></tr>
<tr><td>

  <table width="98%" border="0" cellpadding="0" cellspacing="0">
    <!--tr valign="top">
      <td width="23%" align="right"><strong>Title</strong></td>
      <td width="1%"><b>:</b></td>
      <td><?//=$sqldata['fullname'];?></td>
    </tr-->
    <tr valign="top">
      <td width="23%" align="right"><strong>Program Description</strong></td>
      <td width="1%"><b>:</b></td>
      <td><?=trim($sqldata['summary']);?></td>
    </tr>
    <tr valign="top">
      <td align="right"><strong><?=ucwords(strtolower(get_string('subscriptionstart')));?></strong></td>
      <td><b>:</b></td>
      <td><?php echo $enrolstartdate=date('M d, Y', $sqldisplay['timestart']);?></td>
    </tr>
    <tr valign="top">
      <td align="right"><strong><?=ucwords(strtolower(get_string('subscriptionend')));?></strong></td>
      <td><b>:</b></td>
        <td>
            <?php 
                $signupdate=date('d-m-Y H:i:s', $sqldisplay['timestart']);
				$enddate=strtotime($signupdate . " + 2 month");
				
				$start=$sqldisplay['timestart']; //subscribe start
				$expired=strtotime($signupdate . " + 2 month"); //subscribe end
				//$expired=$sqldisplay['timeend']; //subscribe end
				
				$todaydate=strtotime('now');
				echo $expireddate=date('M d, Y',strtotime($signupdate . " + 2 month"));
            ?>	  
        </td>
    </tr>
  </table></td></tr></table>
  <?php 
	$linklaunch=$CFG->wwwroot.'/course/view.php?id='.$courseid;
	// $linkextend=$CFG->wwwroot.'/coursesindex.php?id='.$USER->id.'&extendid='.$courseid.'&courseid='.$courseid.'&sesskey='.sesskey(); 
	$linkextend=$CFG->wwwroot. '/purchasemodule.php?resitexamid=3&resitcode='.$sqldata['idnumber'].'&productid='.$courseid.'&command=add';
	
	//to get enrol id
	$s_enrol=mysql_query("SELECT id FROM mdl_cifaenrol WHERE enrol='manual' AND status='0' AND id ='".$sqldisplay['enrolid']."'");
	$get_enrol=mysql_fetch_array($s_enrol);
	$course_enrol_id=$get_enrol['id'];
	
	// set enroltime with firsttime loggin for the first time
	if($sqldisplay['timeend']=='0'){
		$enrolq="UPDATE mdl_cifauser_enrolments 
		SET timestart='".$sqldisplay['firstaccess']."', timeend='".$expired."'
		WHERE enrolid='".$course_enrol_id."' AND userid='".$USER->id."'
		";
		$runsql=mysql_query($enrolq);
	}

  ?>
  <table border="0">
    <tr>
    	<?php 
			$twodaybefore=strtotime(date('M d, Y',$expired) . " - 2 days");  // 48 hour before
				$e30daybefore=strtotime(date('M d, Y',$expired) . " - 30 days"); // 1 month before
				$e30dayafter=strtotime(date('M d, Y',$expired) . " + 30 days");	 // 1 month after	
				
				/* echo date('M d, Y',$e30daybefore);
				echo date('M d, Y',$e30dayafter); */
			//if course still valid

			if(($todaydate >=$start) && ($todaydate <= $expired)){ 
				$twodaybefore=strtotime(date('M d, Y',$expired) . " - 2 days");  // 48 hour before
				$e30daybefore=strtotime(date('M d, Y',$expired) . " - 30 days"); // 1 month before
				$e30dayafter=strtotime(date('M d, Y',$expired) . " + 30 days");	 // 1 month after	
		?>
      	<td style="padding-left:0px;">
			<input type="submit" name="lauchtraining" onClick="this.form.action='<?=$linklaunch;?>'" value="Launch Training" />
		</td>
      <?php  
			}/* else{ */ 
			if(($todaydate >=$e30daybefore) && ($todaydate <= $e30dayafter)){ 
				// if extend courses
				if (isset($var)) { 
					/*  mdl_cifauser_enrolments */
					//extend for 2 months once
					$update_time_start=strtotime(date('M d, Y', $expired));
					$u_timeend=strtotime(date('M d, Y',$expired) . " + 2 month");

					$enrolupdate=mysql_query("
						UPDATE {$CFG->prefix}user_enrolments SET timeend='".$u_timeend."', timestart='".$update_time_start."'
						WHERE status='0' AND userid='".$USER->id."' AND enrolid='".$course_enrol_id."'
					");
					
					//instanceid
					$sexam=mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='".$courseid."'");
					$Le=mysql_fetch_array($sexam);
					$examcontextid=$Le['id'];				
					
					//assigned roled.				
					$sqlassignexam=mysql_query("UPDATE {$CFG->prefix}role_assignments SET timemodified='".$todaydate."' WHERE contextid='".$examcontextid."' AND userid='".$USER->id."'");
									
					//extend detais to statement DB
					$extendcost='50'; //cost for extend
					$descextension='Extension';
					$istatementsql=mysql_query("
					INSERT INTO {$CFG->prefix}statement
					SET 
						candidateid='".$USER->traineeid."',
						subscribedate='".$todaydate."', 
						courseid='".$courseid."', 
						remark='".$descextension."', 
						debit1='".$extendcost."'
					");			
					
					$linkredirect=$CFG->wwwroot. '/courseindex.php?id='.$USER->id;
					// header('Location: http://google.com.my');
					// header('Location: '.$linkredirect);		
					redirect($linkextend);
				}	
				
				
				// Set email notification (IPD candidate enrollment confirmation).
				$sqlsupportemail=mysql_query("SELECT * FROM {$CFG->prefix}config WHERE name='supportemail'");
				$q_supportemail=mysql_fetch_array($sqlsupportemail);
				$supportemail=$q_supportemail['value'];
			
				// send email 1 month before expiry
				//Reminder:  CANDIDATE ID - Enrolment Not Complete
				if($USER->middlename!=''){
				$candidate_fullname=$USER->firstname.' '.$USER->middle.' '.$USER->lastname; }else{ $candidate_fullname=$USER->firstname.$USER->lastname; }
				
				// email to commenter
					// $to = "mohd.arizan@mmsc.com.my";
					$to = $USER->email;
					
					// Send email 1 month before expiry
					if($todaydate == $e30daybefore){					
						$subject = "Reminder: CANDIDATE ID - Expiry of SHAPE&reg; IPD Training Program Subscription";
						$message = "
							<html>
							<head>
								<title>HTML email</title>
							</head>
							<body>
							<p>Dear (".strtoupper($candidate_fullname)."),</p>
							<p>Candidate ID: ".strtoupper($USER->traineeid)."</p>
							
							<p style='text-align:justify;'>This is a brief reminder that your access to the online training program is due to expire within a month.</p>										
							<p style='text-align:justify;'>Once expired, you will have limited functions in your IPD Online.</p>
							<p style='text-align:justify;'>
							If you wish to extend your access to the training program, please proceed by clicking on the <strong>EXTEND</strong> button in the Active Training session under <strong>&quot;My Training&quot;</strong>.
							</p> 
							
							
							<p style='text-align:justify;'>&nbsp;</p> 

							<p>Yours Sincerely, <br>
							<strong>SHAPE&reg; Knowledge Services</strong></p>
							<p style='font-size:11px'><strong>Disclaimer:</strong><br>
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
						// end email config	
						/////// AUTHMAIL ///////////////////////////////////////////////////////////////////////
						$from1=$supportemail;  
						$namefrom1="IPD Online";
						$nameto1 = "IPD Online"; 
								
						// this is it, lets send that email!
						authgMail($from1, $namefrom1, $to, $nameto1, $subject, $message);						
						
					} // End send email 1 month before expiry
					
					// send email 48hour before expiry
					if($todaydate == $twodaybefore){
						$subject = "Reminder: CANDIDATE ID - Expiry of SHAPE&reg; IPD Training Program Subscription within 48 hours";
						$message = "
							<html>
							<head>
								<title>HTML email</title>
							</head>
							<body>
							<p>Dear (".strtoupper($candidate_fullname)."),</p>
							<p>Candidate ID: ".strtoupper($USER->traineeid)."</p>
							
							<p style='text-align:justify;'>
							This is a final reminder that your access to you online training program is due to expire within 48 hours. Without it, you will not be able to continue with your training, attempt and pass the IPD Test or access the IPDTM course online. With the expiry, you will also have limited access to the SHAPE&reg; IPD Portal. 							
							</p>										
							<p style='text-align:justify;'>
							If you wish to extend your access to the training program, please proceed by clicking on the <strong>EXTEND</strong> button in the Active Training session under <strong>&quot;My Training&quot;</strong>. Please note the extend offer is only valid for a period of 30 days from the expiry of your online training program subscription. 							
							</p> 
							
							
							<p style='text-align:justify;'>&nbsp;</p> 

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
						// end email config	
						/////// AUTHMAIL ///////////////////////////////////////////////////////////////////////
						$from1=$supportemail;  
						$namefrom1="IPD Online";
						$nameto1 = "IPD Online"; 
								
						// this is it, lets send that email!
						authgMail($from1, $namefrom1, $to, $nameto1, $subject, $message);						
						
					} // End send email 48hour before expiry

					// send email while expiry
					if($todaydate == $expired){
						$subject = "CANDIDATE ID - CIFAOnline Training Program Expired";
						$message = "
							<html>
							<head>
								<title>HTML email</title>
							</head>
							<body>
							<p>Dear (".strtoupper($candidate_fullname)."),</p>
							<p>Candidate ID: ".strtoupper($USER->traineeid)."</p>
							
							<p style='text-align:justify;'>
							We regret to inform you that your access to the online training program has expired and you will not have access to the online training program unless you opt to extend the subscription for the online training programs. This offer is valid for 30 days from the expiry of your online training program. To extend, simply click the <strong>EXTEND</strong> button in the Active Training session under <strong>&quot;My Training&quot;</strong>. 							
							</p>										
							<p style='text-align:justify;'>
							You will have limited access to SHAPE&reg; IPD Portal. If you are interested to pursue your training with us, please proceed to <strong>&quot;Buy IPD&quot;</strong>.
							</p> 
							<p style='text-align:justify;'>
							For more information, kindly contact us and we will be happy to assist you with your queries.  </p>
							
							<p style='text-align:justify;'>&nbsp;</p> 

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
						// end email config	
						/////// AUTHMAIL ///////////////////////////////////////////////////////////////////////
						$from1=$supportemail;  
						$namefrom1="IPD Online";
						$nameto1 = "IPD Online"; 
								
						// this is it, lets send that email!
						authgMail($from1, $namefrom1, $to, $nameto1, $subject, $message);						
					} // End send email while expiry
								
				// display button 30 before & 30 after
				// if(($todaydate >=$e30daybefore) && ($todaydate <= $e30dayafter)){ 
	  ?>
      <td><input name="extendtraining" id="extendtraining" type="submit" onClick="this.form.action='<?=$linkextend;?>'" value="Extend Training" <?php if (isset($var)) { echo 'disabled="disabled"'; } ?> /></td>
	  <?php
			} //}
		?>
	  <td>
	  <?php 

		// echo $sqldata['fullname'];
		// test ID for courses
		if($coursecode=='IPD01'){ $attemptquizid='26';}
		if($coursecode=='IPD02'){ $attemptquizid='31';}
		if($coursecode=='IPD03'){ $attemptquizid='32';}
		if($coursecode=='IPD04'){ $attemptquizid='33';}
		if($coursecode=='IPD05'){ $attemptquizid='34';}
		
	  	// final test ID
		// $cfinaltestsql=mysql_query("SELECT idnumber,id FROM {$CFG->prefix}course WHERE category='3' AND idnumber='".$coursecode."'");
		$cfinaltestsql=mysql_query("
			Select
			  a.category,
			  a.fullname,
			  b.course,
			  b.instance,
			  c.id As cifaquizid,
			  c.name,
			  c.course As course1,
			  e.userid,
			  b.id As id1,
			  c.attempts,
			  a.idnumber
			From
			  mdl_cifacourse a Inner Join
			  mdl_cifacourse_modules b On a.id = b.course Inner Join
			  mdl_cifaquiz c On b.course = c.course And b.instance = c.id Inner Join
			  mdl_cifaenrol d On c.course = d.courseid Inner Join
			  mdl_cifauser_enrolments e On d.id = e.enrolid
			Where
			  a.category = '3' And a.visible = '1' And e.userid='".$USER->id."'	And c.name='".$sqldata['fullname']."'	
		");
		$final=mysql_fetch_array($cfinaltestsql); 
	  	$finaltestid=$final['course1']; //'64';		
	  	$finalexamid=$final['instance']; //'64';		
	  	// echo $sqldata['idnumber']; //'64';		
		
	  	// if final test mark is below than 60.
		/* $sgrade=mysql_query("	
			Select
			  a.course,
			  c.fullname,
			  b.userid,
			  a.attempts,
			  b.grade,
			  a.id As cifaquizid
			From
			  mdl_cifaquiz a Inner Join
			  mdl_cifaquiz_grades b On a.id = b.quiz Inner Join
			  mdl_cifacourse c On c.id = a.course
			Where
				a.id='".$final['cifaquizid']."' And b.userid='".$USER->id."' And b.grade < '60' And c.id='".$finaltestid."' And c.category='3'
		");
		$scourse=mysql_fetch_array($sgrade);
		$qgrade=mysql_num_rows($sgrade);
		if($qgrade!=0){ */ 
			// re-sit link button 
			$linkresit=$CFG->wwwroot. '/purchasemodule.php?resitexamid=4&resitid='.$final['cifaquizid'].'&resitcode='.$sqldata['idnumber'].'&productid='.$finaltestid.'&command=add';
			// $linkresit=$CFG->wwwroot. '/portal/subscribe/paydetails_loggeduser_extend.php?pid='.$finaltestid.'&resitexamid=4';
			 
			$sqlattempts=mysql_query("
				Select
				  a.attempts,
				  b.userid,
				  a.name,
				  b.quiz,
				  b.attempt,
				  a.course As course1
				From
				  mdl_cifaquiz a Inner Join
				  mdl_cifaquiz_attempts b On a.id = b.quiz
				Where
				  a.id='".$final['cifaquizid']."' AND a.course = '".$finaltestid."' AND b.userid = '".$USER->id."'							  
			");
			$cattempts=mysql_num_rows($sqlattempts);
			 // re-sit button // after 2 attempts complete
			 if($final['attempts']==$cattempts){ 
		?>
			<form method="post">
			<input name="resitexam" id="resitexam" type="submit" value="<?=get_string('resitexam');?>" onclick="this.form.action='<?=$linkresit;?>'" />
			</form>
		<?php }// } ?>
	  </td>
    </tr>
  </table>
  <br/>
</form>