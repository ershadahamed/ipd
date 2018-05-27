<?php if(isset($_GET['printpage'])){ ?>
		<body onLoad="javascript:window.print()">
<?php } ?>
<?php
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../../manualdbconfig.php'); 

	$id=$_GET['id'];
	$courseid=$_GET['courseid'].'sadaas';
	
	$getcategorysql=mysql_query("SELECT category FROM {$CFG->prefix}course WHERE id='".$courseid."'");
	$getcategory=mysql_fetch_array($getcategorysql);
	$ccategory=$getcategory['category'];
	
	$site = get_site();
	
	$resultsummary=ucwords(strtolower(get_string('quiz_result_summary_mock','quiz')));
	$title="$SITE->shortname: ".$resultsummary;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
	$url1 = new moodle_url('/coursesindex.php', array('id'=>$USER->id)); //added by arizan	
	$urlmocktest = new moodle_url('/course/mock_test.php', array('id'=>$USER->id)); //added by arizan	
	$urlfinaltest = new moodle_url('/course/finaltest.php', array('id'=>$USER->id)); //added by arizan	
	$urlsummary=$CFG->wwwroot. '/mod/quiz/result-summay.php?examid='.$_GET['examid'].'&courseid='.$_GET['courseid'].'&seskey='.sesskey();
	//$urlexamresult = new moodle_url('mod/quiz/result-summay.php?examid=13&courseid=54&seskey=', array('id'=>$USER->id)); //added by arizan	
	
	$PAGE->navbar->add(get_string('moduletest_name','quiz'), $url1);
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
<div id="welcometable"><h2><?=get_string('quiz_result_summary_mock','quiz'); ?></h2></div>	
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
				  g.name As examname
				From
				  mdl_cifaquiz_attempts a Inner Join
				  mdl_cifaquestion_attempts b On a.uniqueid = b.questionusageid Inner Join
				  mdl_cifagrade_grades c On b.timemodified = c.timemodified Inner Join
				  mdl_cifaquestion d On b.questionid = d.id Inner Join
				  mdl_cifaquestion_categories e On d.category = e.id Inner Join
				  mdl_cifaquiz_grades f On f.userid = a.userid Inner Join
				  mdl_cifaquiz g On f.quiz = g.id  
				Where
				  a.userid = '".$q['id']."' And g.course = '".$_GET['courseid']."' And a.quiz = '".$_GET['examid']."' Group By e.id ORDER BY b.slot ASC
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
					$squery=mysql_query("
				Select
				  b.responsesummary,
				  b.rightanswer,
				  b.maxmark,
				  a.uniqueid,
				  a.quiz,
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
				  a.userid = '".$q['id']."' And g.course = '".$_GET['courseid']."' And a.quiz = '".$_GET['examid']."' AND b.behaviour!='informationitem'
					");
					$sc=mysql_num_rows($squery);

					//count total per question
					$qquery=mysql_query("
				Select
				  b.responsesummary,
				  b.rightanswer,
				  b.maxmark,
				  a.uniqueid,
				  a.quiz,
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
					  a.userid = '".$q['id']."' And g.course = '".$_GET['courseid']."' And a.quiz = '".$_GET['examid']."' AND e.id='".$qgrade['categorygroup']."' AND b.behaviour!='informationitem'
				");
					$qqcount=mysql_num_rows($qquery);					
					
					echo $qqcount;	//Total Questions per section
				?>
				</td>
				<td class="adjacent" align="center">
				<?php
					//count total question attempt
					$squerytotal=mysql_query("Select
				  b.responsesummary,
				  b.rightanswer,
				  b.maxmark,
				  a.uniqueid,
				  a.quiz,
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
					  a.userid = '".$q['id']."' And g.course = '".$_GET['courseid']."' And a.quiz = '".$_GET['examid']."' AND b.responsesummary = b.rightanswer AND b.responsesummary != '' AND e.id='".$qgrade['categorygroup']."'
					");
					$totalquestionattempt=mysql_num_rows($squerytotal);
					$totalanswered+=$totalquestionattempt;
					echo $totalquestionattempt; //correct answer					
				?>				
				</td>
				<td class="adjacent" align="center" style="display:none;">
				<?php 
					//total final per marks
					$q1sum+=(float) ($totalquestionattempt / $qqcount)*100;
					$count++;
					
					//score per question						
					$marksperlearning=($totalquestionattempt / $qqcount)*100;					
					echo round($marksperlearning).' %';
				?>
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
                <td align="center" class="adjacent" style="text-align:center;font-weight:bolder"><?=$sc;?></td>
				<td class="adjacent" style="text-align:center;font-weight:bolder"><?php
					//count total question answered	
					echo $totalanswered;
				?></td>
				<td class="adjacent" style="background: #58FA58;display:none;">
				<?php
					//count total score
					$scorequery=mysql_query("Select
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
					$markgrade=(($qgrade['maxmark'] * 100) / $sc);
					$totalscore=($markgrade * $scoreattempt);
					
					//Final marks
					$q1final_result=$q1sum / $count;
					echo '<strong>'.round($q1final_result).' % </strong>';

				?>
				<?php
					//insert record to db mdl_cifaexam_grade
					$checkusers=mysql_query("SELECT userid, traineeid FROM mdl_cifaexam_grade WHERE userid='".$USER->id."' AND examid='".$_GET['examid']."'");
					$kirausersno=mysql_num_rows($checkusers);
					echo $kirausersno;
					if($kirausersno!='0'){
						$updategrade=mysql_query("
							UPDATE mdl_cifaexam_grade 
							SET examid='".$_GET['examid']."', totalanswer='".$sc."', totalcorrectanswer='".$totalanswered."', 
							finalgrade='".round($q1final_result)."', examtokenid='".$examtokenid."' 
							WHERE userid='".$USER->id."' AND examid='".$_GET['examid']."'
						");
					}else{
						$sqllearningfinal=mysql_query("
							INSERT INTO mdl_cifaexam_grade SET 
							userid='".$USER->id."', traineeid='".$USER->username."', examid='".$_GET['examid']."', examtokenid='".$examtokenid."',
							totalanswer='".$sc."', totalcorrectanswer='".$totalanswered."', finalgrade='".round($q1final_result)."'					
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
                <td class="adjacent" style="background: #5DCBEC;"><?php echo '<strong>'.round($q1final_result).' % </strong>';?></td>
                <td class="adjacent" style="display:none;"></td>
            </tr>
		</table>
		<br/>
        
		<div style="padding:2px;text-align:center;"><center>
		<?php $printtxt = $CFG->wwwroot. "/mod/quiz/print-summay.php?courseid=".$_GET['courseid']."&examid=".$_GET['examid']."&seskey=".$_GET['seskey']."&printpage=1"; ?>
		<input type="hidden" name="printtxt" id="printtxt" value="<?=$printtxt;?>"/>			
		<input type="button" onClick="myPopup2()" onMouseOver="style.cursor='pointer'" name="viewconfirmation" value="&nbsp;<?=get_string('printresults','quiz');?>&nbsp;" />			
		</center></div>
		</form>
		</div>
	<?php }else{ 
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