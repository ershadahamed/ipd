<?php if(isset($_GET['printpage'])){ ?>
		<body onload="javascript:window.print()">
<?php } ?>
<?php
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../../manualdbconfig.php'); 

	$site = get_site();
	
	$resultsummary=get_string('resultsummary');
	$title="$SITE->shortname: ".$resultsummary;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('course');

	echo $OUTPUT->header();		
	if (isloggedin()) {
		//add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
		//echo $OUTPUT->heading($resultsummary, 2, 'headingblock header');
		
		
		$id=$_GET['id'];
		
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
<!--script type="text/javascript"> 
function printPage() {
if(document.all) {
	document.all.divButtons.style.visibility = 'hidden';
	window.print();
	document.all.divButtons.style.visibility = 'visible';
} else {
	document.getElementById('divButtons').style.visibility = 'hidden';
	window.print();
	document.getElementById('divButtons').style.visibility = 'visible';
}
}
</script-->
<div id="welcometable"><h1><?php echo $resultsummary; ?></h1></div>	
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
				  a.quiz,
				  b.questionid,
				  b.slot,
				  b.questionusageid,
				  d.name,
				  d.category,
				  e.id As categorygroup,
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
				  a.userid = '".$q['id']."' Group By e.id
			";
			$sgrade=mysql_query($qattempt);
			//Group By e.name	
			
			
			//$sgrade=mysql_query("SELECT *, a.grade as usergrade FROM mdl_cifaquiz_grades a, mdl_cifaquiz b WHERE a.quiz=b.id AND userid='".$q['id']."'");			
			$sgrade2=mysql_query("SELECT *, a.grade as usergrade FROM mdl_cifaquiz_grades a, mdl_cifaquiz b WHERE a.quiz=b.id AND userid='".$q['id']."'");
			$grade=mysql_fetch_array($sgrade2);
		?>
		<form id="form1" name="form1" method="post" action="">
		<table id="availablecourse2">
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
			<!--tr>
				<td><?//=get_string('examid');?></td>
				<td><strong>:</strong></td>
				<td><?//=$q['access_token'];?></td>
			</tr-->	
			<!--tr>
				<td><?//=get_string('examname');?></td>
				<td><strong>:</strong></td>
				<td>
					<?php 
						//if($grade['course']=='12'){
							//echo 'CIFA Foundation Exam';
						//}else{
							//echo $grade['name'];
						//}
					?>				
				</td>
			</tr-->
			<tr>
				<td><?=get_string('examdate');?></td>
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
				<th class="adjacent" width="1%">No</th>
				<th class="adjacent" width="39%" style="text-align:left;"><strong><?=get_string('learningoutcome');?></strong></th>
				<th class="adjacent" width="18%" style="text-align:center;"><strong>Total <?=get_string('questions');?></strong></th>
				<th class="adjacent" width="18%" style="text-align:center;"><strong>Correct Answered<?//=get_string('questionsattempted');?></strong></th>
				<th class="adjacent" width="18%" style="text-align:center;"><?=get_string('marks');?></th>	
			</tr>
			<?php
				$bil=1;
				$q1sum=0;
				$count=0;
				while($qgrade=mysql_fetch_array($sgrade)){
				$no=$bil++;
			?>
			<tr>
				<td class="adjacent" align="center"><?=$no;?></td>
				<td class="adjacent" style="text-align:left;">
				<?php 					
					/*$learningoutcome=$qgrade['categorygroup'];
					$timecreated=strtotime('now');
					$sqllearning=mysql_query("INSERT INTO mdl_cifalearning_outcome SET learning='".$learningoutcome."', timecreated='".$timecreated."'");*/
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
				  a.userid = '".$q['id']."'
					");
					$sc=mysql_num_rows($squery);
					
				$jomkirasql=mysql_query("SELECT * FROM mdl_cifaquestion_attempts a WHERE a.questionusageid='".$qgrade['questionusageid']."'");
				$countquestion=mysql_num_rows($jomkirasql);
				//echo $countquestion;
					
					//echo $sc;
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
					  a.userid = '".$q['id']."' AND e.id='".$qgrade['categorygroup']."' AND b.questionusageid='".$qgrade['questionusageid']."'
				");
					$qqcount=mysql_num_rows($qquery);					
					
					echo $qqcount / 2;
					
				?>
				</td>
				<td class="adjacent" align="center">
				<?php
					//count total question attempt
					/*$squerytotal=mysql_query("Select
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
					  a.userid = '".$q['id']."' AND b.responsesummary = '".$qgrade['rightanswer']."' AND b.responsesummary != '' AND e.id='".$qgrade['categorygroup']."'
					");*/
					
				$squerytotal=mysql_query("Select
					*
				From
				  mdl_cifaquestion_attempts b 
					Where
					  b.responsesummary = '".$qgrade['rightanswer']."' AND b.responsesummary != '' AND b.questionusageid='".$qgrade['questionusageid']."'
					");					
					$totalquestionattempt=mysql_num_rows($squerytotal);
					$totalanswered+=$totalquestionattempt;
					//$count++;
					echo $totalquestionattempt;	
				?>				
				</td>
				<td class="adjacent" align="center">
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
					//echo $kirachecktoken;
					//if($kirachecktoken == '0'){
						$sqllearning=mysql_query("
							INSERT INTO mdl_cifalearning_outcome SET examid='".$examtokenid."',
							learning='".$learningoutcome."', totalquestion='".$tquestion."',
							correctanswered='".$correctanswered."', timecreated='".$timecreated."'					
						");		
					//}					
				?>
				</td>
			</tr>
			<?php } ?>
			<!---total question / attempts / score---->
			<tr>
				<td class="adjacent" colspan="2" style="font-weight:bolder">Final Result</td>
                <td align="center" class="adjacent" style="text-align:center;font-weight:bolder"><?=$countquestion;?></td>
				<td class="adjacent" style="text-align:center;font-weight:bolder"><?php
					//count total question answered	
					echo $totalanswered;
				?></td>
				<td class="adjacent" style="background: #58FA58;">
				<?php
					//count total score
					$scorequery=mysql_query("Select
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
					  a.userid = '".$q['id']."'
					");	
					$markscrore=mysql_fetch_array($scorequery);
					$scoreattempt=mysql_num_rows($scorequery);
					$markgrade=(($qgrade['maxmark'] * 100) / $countquestion);
					$totalscore=($markgrade * $scoreattempt);
					
					//Final marks
					$q1final_result=$q1sum / $count;
					echo '<strong>'.round($q1final_result).' % </strong>';

				?>
				<?php
					//insert record to db mdl_cifaexam_grade
					$checkusers=mysql_query("SELECT userid, traineeid FROM mdl_cifaexam_grade WHERE userid='".$USER->id."'");
					$kirausersno=mysql_num_rows($checkusers);
					if($kirausersno!='0'){
						$updategrade=mysql_query("
							UPDATE mdl_cifaexam_grade SET totalanswer='".$countquestion."', totalcorrectanswer='".$totalanswered."', 
							finalgrade='".round($q1final_result)."', examtokenid='".$examtokenid."' WHERE userid='".$USER->id."' AND traineeid='".$USER->username."'
						");
					}else{
						$sqllearningfinal=mysql_query("
							INSERT INTO mdl_cifaexam_grade SET 
							userid='".$USER->id."', traineeid='".$USER->username."', examid='".$grade['course']."', examtokenid='".$examtokenid."',
							totalanswer='".$countquestion."', totalcorrectanswer='".$totalanswered."', finalgrade='".round($q1final_result)."'					
						");	
					}					
				?>				
				</td>
			</tr>
		</table>

		<div style="padding:2px;text-align:center;"><center>
		<?php $printtxt = $CFG->wwwroot. "/mod/quiz/print-summay.php?seskey=".$_GET['seskey']."&printpage=1"; ?>
		<input type="hidden" name="printtxt" id="printtxt" value="<?=$printtxt;?>"/>			
		<input type="button" onClick="myPopup2()" onMouseOver="style.cursor='pointer'" name="viewconfirmation" value="&nbsp;<?=get_string('printresults');?>&nbsp;" />			
		</center></div><br/>

		<?php			
			//list out exam question n save to db
			$squeryquestion=mysql_query("
				Select
				  b.responsesummary,
				  b.rightanswer,
				  b.timemodified,
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
				  a.userid = '".$q['id']."'
			");
			//$kiralistque=mysql_num_rows($squeryquestion);
			while($questiontotal=mysql_fetch_array($squeryquestion)){ 
				//echo $questiontotal['questionid'].'-'; 
				$rightanswerque=$questiontotal['rightanswer'];
				$responsesummaryque=$questiontotal['responsesummary'];
				$timemodifiedque=$questiontotal['timemodified'];
				$sqllistquestion=mysql_query("
					INSERT INTO mdl_cifaexam_question SET 
					examid='".$grade['course']."', examtokenid='".$q['access_token']."', candidateid='".$USER->username."', slot='".$questiontotal['slot']."',
					questionid='".$questiontotal['questionid']."', rightanswer='".$rightanswerque."', responsesummary='".$responsesummaryque."', timemodified='".$timemodifiedque."'					
				");					
			}		
		?>

		
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