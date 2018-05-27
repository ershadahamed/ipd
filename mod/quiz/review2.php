<?php 
mysql_connect("localhost", "root", "mmsc_v3ntur3s") or die(mysql_error());
mysql_select_db("cifadblms") or die(mysql_error());

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->dirroot . '/mod/quiz/report/reportlib.php');


$PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
   // $listusertoken = 'Manage Candidate for Exam Registration';
   // $PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

    //$PAGE->set_pagetype('site-index');
    //$editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	
    echo $OUTPUT->header();

?>
<?php 
$qryq = "SELECT a.id FROM mdl_cifaquiz a, mdl_cifacourse_modules b
		WHERE a.course=b.course
		AND b.id='".$_GET['id']."'";
$sqlq = mysql_query($qryq);
$rsq = mysql_fetch_array($sqlq);
		
$qrys = "SELECT FROM_UNIXTIME(timestart, '%d/%m/%Y') as startedon,
		FROM_UNIXTIME(timefinish, '%d/%m/%Y') as completedon,
		sumgrades FROM mdl_cifaquiz_attempts 
		WHERE userid='".$USER->id."' AND quiz='".$rsq['id']."'
		";
$sqls = mysql_query($qrys);
$rss = mysql_fetch_array($sqls);		
?>
<table width="90%" border="1" cellpadding="0" cellspacing="2">
	<tr>
		<td width="20%">Started on</td>
		<td width="80%">: <?php echo $rss['startedon'];?></td>
	</tr>
	<tr>
		<td>Completed on</td>
		<td>: <?php echo $rss['completedon'];?></td>
	</tr>
	<tr>	
		<td>Marks</td>
		<td>: <?php echo round($rss['sumgrades'],2);?></td>
	</tr>
</table>
		
		
		
<table width="90%" border="1" cellpadding="0" cellspacing="2">
	<tr>
		<td width="60%"><b>Module</b></td>
		<td width="20%" align="center"><b>No of Questions</b></td>
		<td width="20%" align="center"><b>Marks (%)</b></td>
	</tr>
	<?php
	/*get module name*/
	
	$qry = "SELECT e.id, e.name, count(c.questionid) as noofquestion
			FROM mdl_cifacourse_modules a, mdl_cifaquiz_attempts b, mdl_cifaquestion_attempts c, 
			mdl_cifaquestion d, mdl_cifaquestion_categories e
			WHERE a.id='".$_GET['id']."' 
			AND b.quiz=a.instance
			AND b.userid='".$USER->id."'
			AND c.questionusageid=b.uniqueid
			AND e.id = d.category
			AND d.id = c.questionid
			GROUP BY d.category";
	$categoryid=$rs['id'];
	$sql = mysql_query($qry);
	$totalnoofquestion = 0;
	while($rs=mysql_fetch_array($sql)){
		$totalnoofquestion = $totalnoofquestion + $rs['noofquestion'];
	?>
	<tr>
		<td><?php echo $rs['name'];?></td>
		<td align="center"><?php echo $rs['noofquestion'];?></td>
		<td align="center"><?php echo getmodulesmark($rs['id'],$USER->id,$totalnoofquestion,$_GET['id']);?></td>
	</tr>
	<?php } ?>
	</table>
	
<?php
echo $OUTPUT->footer();

function getmodulesmark($categoryid,$userid,$totalnoofquestion,$attemptid){

	$qry = "SELECT e.id, e.name, count(c.questionid) as noofquestion
			FROM mdl_cifacourse_modules a, mdl_cifaquiz_attempts b, mdl_cifaquestion_attempts c, 
			mdl_cifaquestion d, mdl_cifaquestion_categories e
			WHERE a.id='".$attemptid."' 
			AND b.quiz=a.instance
			AND b.userid='".$userid."'
			AND c.questionusageid=b.uniqueid
			AND e.id = d.category
			AND d.id = c.questionid
			GROUP BY d.category";
	//$categoryid=$rs['id'];
	$sql = mysql_query($qry);
	$grandtotalno = 0;
	while($rs=mysql_fetch_array($sql)){
	$grandtotalno = $grandtotalno + $rs['noofquestion'];
	}
	
	$qryd = "SELECT a.maxmark 
			FROM mdl_cifaquestion_attempts a, mdl_cifaquestion b, mdl_cifaquestion_categories c,mdl_cifaquiz_attempts d
			WHERE c.id='".$categoryid."'
			AND c.id=b.category
			AND a.questionid=b.id
			AND a.questionusageid=d.uniqueid
			AND d.userid='".$userid."'";
	$sqld = mysql_query($qryd);
	$totalmarks = 0;
		while($rsd=mysql_fetch_array($sqld)){
		//echo "marks=".$rsd['maxmark']."+";
		$totalmarks = $totalmarks + $rsd['maxmark'];
		}
		//echo "t=".$grandtotalno."<br>";
		//echo "n=".$totalmarks."<br>";
		$percentage = $totalmarks / $grandtotalno;
		$percentage = round($percentage,2);
	return $percentage;
}
?>	