<?php if(isset($_GET['printpage'])){ ?>
		<body onLoad="javascript:window.print()">
<?php } ?>
<?php
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../../manualdbconfig.php'); 

	$id=$_GET['id'];
	$courseid=$_GET['courseid'];
	$quiz_attemptid=$_GET['attemptid'];
	
	$getcategorysql=mysql_query("SELECT category FROM {$CFG->prefix}course WHERE id='".$courseid."'");
	$getcategory=mysql_fetch_array($getcategorysql);
	$ccategory=$getcategory['category'];
	
	$site = get_site();
	
	$resultsummary=ucwords(strtolower(get_string('quiz_result_summary_mock','quiz')));
	$mocktitle=get_string('quiz_result_summary_mock','quiz');
	// $finaltesttitle=get_string('quiz_result_summary','quiz');
	$finaltesttitle="SHAPE<sup>&reg;</sup> IPD Final Test";
	$title="$SITE->shortname: ".$resultsummary;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
	$url1 = new moodle_url('/coursesindex.php', array('id'=>$USER->id)); //added by arizan	
	$urlmocktest = new moodle_url('/course/mock_test.php', array('id'=>$USER->id)); //added by arizan	
	$urlfinaltest = new moodle_url('/course/finaltest.php', array('id'=>$USER->id)); //added by arizan	
	$urlsummary=$CFG->wwwroot. '/mod/quiz/result-summay.php?examid='.$_GET['examid'].'&courseid='.$_GET['courseid'].'&seskey='.sesskey();	
	
	$getquizname=mysql_query("
		Select
		  a.id,
		  a.quiz,
		  b.name
		From
		  mdl_cifaquiz_attempts a Inner Join
		  mdl_cifaquiz b On a.quiz = b.id
		Where
		  a.id = '".$quiz_attemptid."'
	");
	$mocktest_name=mysql_fetch_array($getquizname);
	
	$PAGE->navbar->add($mocktest_name['name'], $url1);
	if($ccategory=='9'){
		$PAGE->navbar->add(get_string('quiz_result_summary_mock','quiz'), $urlmocktest);
		$PAGE->navbar->add(get_string('quizname_summary_mock','quiz'), $urlsummary);	
	}else{
		$PAGE->navbar->add(get_string('quiz_result_summary','quiz'), $urlfinaltest);
		$PAGE->navbar->add(get_string('quizname_summary','quiz'), $urlsummary);
	}	
	

	echo $OUTPUT->header();	
		
	
	if (isloggedin()) {
		//add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
		//echo $OUTPUT->heading($resultsummary, 2, 'headingblock header');
	?>	
	<style>
	<?php 
		include('../../css/style2.css'); 
		include('../../css/button.css');
		include('../../css/pagination.css');
		include('../../css/grey.css');
	?>
	</style>
<style type="text/css">
#welcometable{
	/*font:18px/1.231 arial,helvetica,clean,sans-serif;
	margin-left: 30px;*/
}
</style>
<script type="text/javascript">
<!--
function myPopup2() {
var printtxt = document.getElementById('printtxt').value;
window.open(printtxt, "Window2", "status = 1, width=880, height=1000 resizable = yes, scrollbars=1");
//window.open(printtxt);
}
//-->
</script>
<div id="welcometable"><h2>
<?php
	if($ccategory=='9'){
		echo $mocktitle;	// mock test title
	}else{
		echo $finaltesttitle; // Final test title
	}	
?>
</h2></div>	
		<div style="min-height: 400px;">
		
		<?php
			$sel=mysql_query("SELECT * FROM mdl_cifauser WHERE id='".$USER->id."'");
			$q=mysql_fetch_array($sel);
			
			
			$qattempt="
				Select
				  b.responsesummary,
				  b.rightanswer,
				  b.maxmark,
				  a.uniqueid,
				  a.quiz as quizattempt,
				  a.userid,
				  a.attempt,       
				  a.sumgrades,
				  a.timestart,
				  a.timefinish,
				  a.timemodified,
				  a.preview,
				  a.needsupgradetonewqe,				  
				  b.questionid,
				  b.slot,
				  b.questionusageid,
				  d.name,
				  d.category,
				  e.id As categorygroup,
				  e.name As questiongroup,
				  f.grade as usergrade,
				  g.name As examname,
				  e.parent
				From
				  mdl_cifaquiz_attempts a Inner Join
				  mdl_cifaquestion_attempts b On a.uniqueid = b.questionusageid Inner Join
				  mdl_cifagrade_grades c On b.timemodified = c.timemodified Inner Join
				  mdl_cifaquestion d On b.questionid = d.id Inner Join
				  mdl_cifaquestion_categories e On d.category = e.id Inner Join
				  mdl_cifaquiz_grades f On f.userid = a.userid Inner Join
				  mdl_cifaquiz g On f.quiz = g.id  
				Where
				  a.userid = '".$q['id']."' And g.course = '".$_GET['courseid']."' And a.quiz = '".$_GET['examid']."' 
				Group By e.id ORDER BY b.slot ASC
			";
			$sgrade=mysql_query($qattempt);
			//Group By e.name	
		
			$sgrade2=mysql_query("SELECT *, a.grade as usergrade FROM mdl_cifaquiz_grades a, mdl_cifaquiz b WHERE a.quiz=b.id AND userid='".$q['id']."'");
			$grade=mysql_fetch_array($sgrade2);
		?>
		<form id="form1" name="form1" method="post" action="">
		<table id="availablecourse2" style="margin-bottom:2em;">
			<tr>
				<td><?=get_string('candidatename');?></td>
				<td><strong>:</strong></td>
				<td><?=ucwords(strtolower($q['firstname'].' '.$q['lastname']));?></td>
			</tr>
			<tr>
				<td><?=get_string('candidateid');?></td>
				<td><strong>:</strong></td>
				<td><?=strtoupper($q['traineeid']);?></td>
			</tr>	
			<tr>
				<td>Date</td>
				<td><strong>:</strong></td>
				<td>
					<?php
						$sque=mysql_query("SELECT timestart, timefinish FROM mdl_cifaquiz_attempts WHERE userid='".$q['id']."' AND quiz='".$grade['id']."'");
						$query=mysql_fetch_array($sque);
						
						echo date('d-m-Y',$query['timestart']).'<br/>';
					?>				
				</td>
			</tr>			
		</table>
		
		<table id="availablecourse">
			<tr class="yellow">
            <!--th class="adjacent" width="1%">No</th-->
            <th class="adjacent" width="39%" style="text-align:left;"><strong><?=get_string('resultsection','quiz');?></strong></th>
            <th class="adjacent" width="18%" style="text-align:center;"><strong><?=get_string('questions','quiz');?></strong></th>
            <th class="adjacent" width="18%" style="text-align:center;"><strong><?=get_string('correctanswer','quiz');?></strong></th>
            <th class="adjacent" width="18%" style="text-align:center; display:none;"><?=get_string('marks');?></th>	
			</tr>
			<?php
				$bil=1;
				$q1sum=0;
				$count=0;
				while($qgrade=mysql_fetch_array($sgrade)){
				$no=$bil++;
			?>
			<tr>
				<td class="adjacent" style="text-align:left;">
				<?php 					
 					echo $qgrade['questiongroup'];
				?>
				</td>
				<td class="adjacent" align="center">
				<?php		
					//count total question
					$attemptidquery=mysql_query("
						Select
						  a.id
						From
						  mdl_cifaquiz_attempts a Inner Join
						  mdl_cifaquestion_attempts b On a.uniqueid = b.questionusageid  
						Where
						  a.id='".$quiz_attemptid."'
					");
					$numattemptid=mysql_num_rows($attemptidquery);
					echo $numattemptid;
				?>
				</td>
				<td class="adjacent" align="center">
				<?php
					//count total question attempt/Answer		
					$squerytotal=mysql_query("
						Select
						  a.id
						From
						  mdl_cifaquiz_attempts a Inner Join
						  mdl_cifaquestion_attempts b On a.uniqueid = b.questionusageid  
						Where
						  a.id='".$quiz_attemptid."' And
						  b.responsesummary = b.rightanswer AND b.responsesummary != ''	
					"); 					
										
					$totalquestionattempt=mysql_num_rows($squerytotal);
					$totalanswered+=$totalquestionattempt;
					echo $totalquestionattempt; //correct answer

					//score per question						
					$marksperlearning=($totalquestionattempt / $numattemptid)*100;
					
					//total final per marks
					$q1sum+=(float) ($totalquestionattempt / $numattemptid)*100;
					$count++;	
					
					//Final marks
					$q1final_result=$q1sum / $count;
					
				?>				
				</td>
				<td class="adjacent" align="center" style="display:none;">
				<?php
					//insert record to db
					$learningoutcome=$qgrade['categorygroup'];
					$timecreated=strtotime('now');
					$correctanswered=round($marksperlearning);
					$tquestion=$totalquestionattempt;
					$examtokenid=$q['access_token'];
					
					$checktoken=mysql_query("SELECT * FROM mdl_cifalearning_outcome WHERE examid='".$examtokenid."'");
					$kirachecktoken=mysql_num_rows($checktoken);
						/* $sqllearning=mysql_query("
							INSERT INTO mdl_cifalearning_outcome SET examid='".$examtokenid."',
							learning='".$learningoutcome."', totalquestion='".$tquestion."',
							correctanswered='".$correctanswered."', timecreated='".$timecreated."'					
						");	 */					
				?>
				</td>
			</tr>
			<?php } ?>
			<!---total question / attempts / score---->
			<tr>
				<td class="adjacent" style="text-align:left; font-weight:bolder"><?=get_string('totalquestion','quiz');?></td>
                <td align="center" class="adjacent" style="text-align:center;font-weight:bolder"><?=$numattemptid;?></td>
				<td class="adjacent" style="text-align:center;font-weight:bolder"><?php
					//count total question answered	
					echo $totalanswered;				
				?></td>
				<td class="adjacent" style="background: #58FA58;display:none;">
				<?php
					//count total score
					/* $scorequery=mysql_query("Select
					  b.responsesummary,
					  b.rightanswer,
					  b.maxmark,					  
					  a.uniqueid,
					  a.quiz as quizattempt,
					  a.userid,
					  a.attempt,       
					  a.sumgrades,
					  a.timestart,
					  a.timefinish,
					  a.timemodified,
					  a.preview,
					  a.needsupgradetonewqe,					  					  
					  b.questionid,
					  b.slot,
					  b.questionusageid,
					  d.name,
					  d.category,
					  e.name As questiongroup,
					  f.grade as usergrade				  
					From
					  mdl_cifaquiz_attempts a Inner Join
					  mdl_cifaquestion_attempts b On a.uniqueid = b.questionusageid Inner Join
					  mdl_cifagrade_grades c On b.timemodified = c.timemodified Inner Join
					  mdl_cifaquestion d On b.questionid = d.id Inner Join
					  mdl_cifaquestion_categories e On d.category = e.id Inner Join
					  mdl_cifaquiz_grades f On f.userid = a.userid Inner Join
					  mdl_cifaquiz g On f.quiz = g.id
					Where
					  a.userid = '".$q['id']."' AND b.behaviour!='informationitem' And g.course = '".$_GET['courseid']."' And a.quiz = '".$_GET['examid']."'
					");	
					$markscrore=mysql_fetch_array($scorequery);
					$scoreattempt=mysql_num_rows($scorequery);
					$markgrade=(($qgrade['maxmark'] * 100) / $numattemptid);
					$totalscore=($markgrade * $scoreattempt); */
					
					//Final marks
					/* $q1final_result=$q1sum / $count;
					echo '<strong>'.round($q1final_result).' % </strong>'; */

				?>
				<?php
					//insert record to db mdl_cifaexam_grade
					$checkusers=mysql_query("SELECT userid, traineeid FROM mdl_cifaexam_grade WHERE userid='".$USER->id."' AND examid='".$_GET['examid']."'");
					$kirausersno=mysql_num_rows($checkusers);
					echo $kirausersno;
					if($kirausersno!='0'){
						$updategrade=mysql_query("
							UPDATE mdl_cifaexam_grade 
							SET examid='".$_GET['examid']."', totalanswer='".$numattemptid."', totalcorrectanswer='".$totalanswered."', 
							finalgrade='".round($q1final_result)."', examtokenid='".$examtokenid."' 
							WHERE userid='".$USER->id."' AND examid='".$_GET['examid']."'
						");
					}else{
						$sqllearningfinal=mysql_query("
							INSERT INTO mdl_cifaexam_grade SET 
							userid='".$USER->id."', traineeid='".$USER->username."', examid='".$_GET['examid']."', examtokenid='".$examtokenid."',
							totalanswer='".$numattemptid."', totalcorrectanswer='".$totalanswered."', finalgrade='".round($q1final_result)."'					
						");							
					}

					//insert record to db mdl_cifaexam_grade
					$check_quiz=mysql_query("SELECT userid FROM mdl_cifaquiz_attempts_v WHERE userid='".$USER->id."'");
					$kira_quiz=mysql_num_rows($check_quiz);
					
					$c1=$markscrore['uniqueid'];
					$c2=$markscrore['quizattempt'];
					$z3=$markscrore['attempt'];
					$z4=$markscrore['sumgrades'];
					$z5=$markscrore['timestart'];
					$z6=$markscrore['timemodified'];
					$z7=$markscrore['preview'];
					$z8=$markscrore['needsupgradetonewqe'];
					
					if($kira_quiz!='0'){ echo $kira_quiz;
						$quiz_attempts_update=mysql_query("
							UPDATE mdl_cifaquiz_attempts_v SET
							uniqueid='".$c1."', quiz='".$c2."', userid='".$USER->id."', attempt='".$z3."', 
							sumgrades='".$z4."', timestart='".$z5."', timemodified='".$z6."', preview='".$z7."', needsupgradetonewqe='".$z8."' 
							WHERE userid='".$USER->id."'
						");
					}else{
						$quiz_attempts_copy=mysql_query("
							INSERT INTO mdl_cifaquiz_attempts_v SET 
							uniqueid='".$c1."', quiz='".$c2."', userid='".$USER->id."', attempt='".$z3."',
							sumgrades='".$z4."', timestart='".$z5."', timemodified='".$z6."', preview='".$z7."',
							needsupgradetonewqe='".$z8."'					
						");							
					}					
				?>				
				</td>
			</tr>
            <tr>
            	<td class="adjacent" style="text-align:left; font-weight:bolder"><?=get_string('resultpercent','quiz');?></td>
                <td class="adjacent" >&nbsp;</td>
                <td class="adjacent" style="color:#ffffff;background: #6D6E71;"><?php echo '<strong>'.round($q1final_result).' % </strong>';?></td>
                <td class="adjacent" style="display:none;"></td>
            </tr>
		</table>
		<br/>
        
		<div style="padding:2px;text-align:center;"><center>
		<?php $printtxt = $CFG->wwwroot. "/mod/quiz/print-summay.php?attemptid=".$quiz_attemptid."&courseid=".$_GET['courseid']."&examid=".$_GET['examid']."&seskey=".$_GET['seskey']."&printpage=1"; ?>
		<input type="hidden" name="printtxt" id="printtxt" value="<?=$printtxt;?>"/>			
		<input type="button" onClick="myPopup2()" onMouseOver="style.cursor='pointer'" name="viewconfirmation" value="&nbsp;<?=get_string('printresults','quiz');?>&nbsp;" />			
		</center></div>
		</form>
		</div>
	<?php 

		// Set email notification - Announcement: CANDIDATE ID - Get Your SHAPE&reg; IPD Certificate
		$sqlsupportemail=mysql_query("SELECT * FROM {$CFG->prefix}config WHERE name='supportemail'");
		$q_supportemail=mysql_fetch_array($sqlsupportemail);
		$supportemail=$q_supportemail['value'];
		
		// $sqlcoursequery=mysql_query("SELECT fullname FROM {$CFG->prefix}course WHERE id='".$_GET['courseid']."'");
		$sqlcoursequery=mysql_query("
			Select
			  b.uniqueid,
			  a.name,
			  b.id,
			  c.grade
			From
			  mdl_cifaquiz a Inner Join
			  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
			  mdl_cifaquiz_grades c On b.quiz = c.quiz And b.userid = c.userid
			Where
			  b.id = '".$quiz_attemptid."'		
		");
		$sqlquery=mysql_fetch_array($sqlcoursequery);
		$coursefullname=$sqlquery['name'];
	
		// send email 2 week before expiry
		// Announcement: CANDIDATE ID - Get Your SHAPE&reg; IPD Certificate
		if($USER->middlename!=''){
		$ucfullname=$USER->firstname.' '.$USER->middlename.' '.$USER->lastname;}else{
		$ucfullname=$USER->firstname.' '.$USER->lastname;}
		
		if($today == $beforeexpiry){
		// email to commenter
			$to = $USER->email;
			$subject = "Announcement: CANDIDATE ID - Get Your SHAPE&reg; IPD Certificate";
			$message = "
				<html>
				<head>
					<title>HTML email</title>
				</head>
				<body>
					<p>Dear (".ucwords(strtolower($USER->firstname))."),</p>
					<p>Candidate ID: ".strtoupper($USER->traineeid)."<br/>
					Name: ".ucwords(strtolower($ucfullname))."</p>

					<p style='text-align:justify;'>Congratulations!!</p>

					<p style='text-align:justify;'>
					You have successfully completed the test for the following course</p>
					<table width='80%' border='0' align='center' cellpadding='0' cellspacing='0'>
					  <tr>
						<th width='50%' scope='row'>".$coursefullname."</th>
						<th>".round($q1final_result)."% </th>
					  </tr>
					</table>
																
					<p style='text-align:justify;'>
					The result has been uploaded to your account immediately. However the certificate is only available within 7 days after the result has been released.</p>

					<p style='text-align:justify;'>The course certificate will be available via <u>Test  Result</u> under <strong>&quot;My Training&quot; </strong>in your IPD Online. Once the results have  been uploaded, you will be able to see a <u>View Cert </u>link beside the  result. Please be informed that the certificate is only printable once. It is  important that you keep the certificate in safe keeping. If you have lost the  certificate, you will need to <strong><u>contact us</u></strong> for a replacement copy.</p>

					<p style='text-align:justify;'>
					We would like to take this opportunity to thank you for studying with us and hope we can continue to support you throughout your training you may undertake. </p>

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
		} // End send email 2 week before expiry	
	
	}else{ 
			echo 'You not allow to view this summary;';
			$linkto=$CFG->wwwroot.'/index.php';
			redirect($linkto);
		}	
	
	?>
<?php
		//session_unset();
		//session_destroy();	
	
	echo $OUTPUT->footer(); 
?>