<?php
    include('config.php');
	include('manualdbconfig.php');
	
	$courseid=$rowCourses['courseid'];
	// echo $courseenrolid=$_GET['courseid'];
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
		  c.timeend
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
      <td><?=date('M d, Y', $sqldisplay['timestart']);?></td>
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
				echo date('M d, Y',strtotime($signupdate . " + 2 month"));
            ?>	  
        </td>
    </tr>
  </table></td></tr></table>
  <?php 
	$linklaunch=$CFG->wwwroot.'/course/view.php?id='.$courseid;
	// $linkextend=$CFG->wwwroot.'/coursesindex.php?id='.$USER->id.'&extendid='.$courseid.'&courseid='.$courseid.'&sesskey='.sesskey(); 
	$linkextend=$CFG->wwwroot. '/purchasemodule.php?resitexamid=3&productid='.$courseid.'&command=add';
	
	//to get enrol id
	$s_enrol=mysql_query("SELECT id FROM mdl_cifaenrol WHERE enrol='manual' AND status='0' AND id ='".$sqldisplay['enrolid']."'");
	$get_enrol=mysql_fetch_array($s_enrol);
	$course_enrol_id=$get_enrol['id'];

  ?>
  <table border="0">
    <tr>
    	<?php 
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
			}else{ 
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
							<p style='font-size:11px'><strong>Disclaimer:</strong> <br>
							This is a system  generated email. Please do not reply. For assistance, please <strong><u>contact us</u></strong> and we will revert back to you within 72 hours. </p>
							</body>
							</html>
						";
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
					} // End send email while expiry
					
					// Always set content-type when sending HTML email
					$link=$CFG->wwwroot;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					
					// More headers
					$headers .= 'From: <'.$supportemail.'>' . "\r\n";
					//$headers .= 'Cc: mohd.arizan@mmsc.com.my'. "\r\n";
					
					mail($to,$subject,$message,$headers);
					// end email config					
								
				// display button 30 before & 30 after
				if(($todaydate >=$e30daybefore) && ($todaydate <= $e30dayafter)){ 
	  ?>
      <td><input name="extendtraining" id="extendtraining" type="submit" onClick="this.form.action='<?=$linkextend;?>'" value="Extend Training" <?php if (isset($var)) { echo 'disabled="disabled"'; } ?> /></td>
	  <?php
			} }
		?>
	  <td>
	  <?php 
	  	// final test ID
		$cfinaltestsql=mysql_query("SELECT idnumber,id FROM {$CFG->prefix}course WHERE category='3' AND idnumber='".$coursecode."'");
		$final=mysql_fetch_array($cfinaltestsql); 
	  	$finaltestid=$final['id']; //'64';
		
	  	// if final test mark is below than 70.
		$sgrade=mysql_query("	
			Select
			  a.course,
			  c.fullname,
			  b.userid,
			  a.attempts
			From
			  mdl_cifaquiz a Inner Join
			  mdl_cifaquiz_grades b On a.id = b.quiz Inner Join
			  mdl_cifacourse c On c.id = a.course
			Where
				b.userid='".$USER->id."' And b.grade < '70' And c.id='".$finaltestid."' And c.category='3'
		");
		$scourse=mysql_fetch_array($sgrade);
		$qgrade=mysql_num_rows($sgrade);
		if($qgrade!=0){ 
			// re-sit link button
			 $linkresit=$CFG->wwwroot. '/purchasemodule.php?resitexamid=4&productid='.$finaltestid.'&command=add';

						$sqlattempts=mysql_query("
							Select
							  a.attempts,
							  b.userid,
							  a.name,
							  b.quiz,
							  b.attempt
							From
							  mdl_cifaquiz a Inner Join
							  mdl_cifaquiz_attempts b On a.id = b.quiz
							Where
							  a.course = '".$scourse['course']."' AND b.userid = '".$USER->id."'					
						");
						$cattempts=mysql_num_rows($sqlattempts);
			 
			 // re-sit button // after 2 attempts complete
			 if($scourse['attempts']==$cattempts){ 
		?>
			<form method="post">
			<input name="resitexam" id="resitexam" type="submit" value="<?=get_string('resitexam');?>" onclick="this.form.action='<?=$linkresit;?>'" />
			</form>
		<?php }} ?>
	  </td>
    </tr>
  </table>
  <br/>
</form>