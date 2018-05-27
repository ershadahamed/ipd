<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = get_string('candidateexamsummary');
    $PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
   // echo $OUTPUT->header();
	$userid=$_GET['id']; //get user id
?>
<style type="text/css">
<?php 
	include('../institutionalclient/style.css');
?>
	a:hover {text-decoration:underline;}
	#searchtable td, th{	 
		border: 1px solid #666666;
		border-collapse:collapse;
		padding:0.5em;		
	}	
body {
font: 13px/1.231 arial,helvetica,clean,sans-serif;
}	
</style>
<form id="form1" name="form1" method="post" action="">
<br/>
<fieldset style="padding: 1em;" id="user" class="clearfix"><br/>
<div style="margin-left:2em;"><h2><?=get_string('cifacandidatedatabase');?></h2></div>
<?php
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken e On b.courseid = e.courseid And e.userid = d.id		
	";
	$statement.=" WHERE a.category = '3' AND d.usertype='Active Candidate' AND c.userid='".$userid."'";
	
	$csql="SELECT *, c.timestart as enroltime, a.id as examid  FROM {$statement}";	
	$sqlquery=mysql_query($csql);
	
	$sql=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='".$userid."'");
	$srow=mysql_fetch_array($sql);
	
	$firstname = $srow['firstname'];
	$middlename = $srow['middlename'];
	$lastname = $srow['lastname'];
	if($middlename!=''){
		$fullname = $firstname.' '.$middlename.' '.$lastname;
	}else{
		$fullname = $firstname.' '.$lastname;
	}
?>
	
	<table width="95%" border="0" style="border-collapse:collapse;margin:0px auto;">
	  <tr>
		<td width="22%" scope="row">Candidate ID</td>
		<td width="1%"><strong>:</strong></td>
		<td width="76%"><?=strtoupper($srow['traineeid']);?></td>
	  </tr>
	  <tr>
		<td scope="row">Fullname</td>
		<td><strong>:</strong></td>
		<td><?=ucwords(strtolower($fullname));?></td>
	  </tr>
	  <tr>
		<td scope="row">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>

  <table width="95%" border="1" id="searchtable" style="border-collapse:collapse; margin:0px auto;">
    <tr align="center"  style="background-color:#ccc;">
      <td scope="row" style="text-align:left;">CIFA&#8482; Examination Title</td>
      <td width="25%" style="text-align:left;">Exam Token ID</td>
      <td width="10%">Token Expiry</td>
      <td width="10%">Exam Start</td>
      <td width="10%">Exam End</td>
      <td width="8%">Marks (%)</td>
    </tr>
<?php	
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	
	$sqllist=mysql_query("Select
				  a.fullname,
				  b.course,
				  c.quiz,
				  c.userid,
				  c.timestart,
				  c.timefinish,
				  d.grade,
				  e.user_accesstoken,
				  e.tokenexpiry
				From
				  mdl_cifacourse a Inner Join
				  mdl_cifaquiz b On a.id = b.course Inner Join
				  mdl_cifaquiz_attempts c On b.id = c.quiz Inner Join
				  mdl_cifaquiz_grades d On c.quiz = d.quiz And c.userid = d.userid Inner Join
				  mdl_cifauser_accesstoken e On b.course = e.courseid And e.userid = d.userid
				Where
					c.userid='".$userid."'
				");
	$st=mysql_fetch_array($sqllist);
	$sepx=mysql_num_rows($sqllist);
	
	//token availibility
	$tokenstart=strtotime('now');
	$tokenexpiry=$sqlrow['tokenexpiry'];
	
	//$linkto=$CFG->wwwroot. "/offlineexam/candidate_examsummary.php?id=".$sqlrow['userid'];
	$bil=$no++;
?>
    <tr>
      <td scope="row"><?=$sqlrow['fullname'];?></td>
      <td><?=$sqlrow['user_accesstoken'];?></td>
      <td><?=date('d/m/Y H:i:s',$sqlrow['tokenexpiry']);?></td>
	  <?php if($sepx!='0'){ if($tokenexpiry<$tokenstart){ ?>
	  <td colspan="3" style="text-align:center;"><?=get_string('examtokenexpiry');?></td>
	  <?php }else{ ?>
      <td><?=date('d/m/Y H:i:s',$st['timestart']);?></td>
      <td><?=date('d/m/Y H:i:s',$st['timefinish']);?></td>
      <td style="text-align:center;"><?=round($st['grade']);?></td>	  
	  <?php }}else{ ?>
	  <td colspan="3" style="text-align:center;"><?=get_string('notusedtoken');?></td>
	  <?php } ?>
    </tr>
<?php
	}
	}else{
?>	
	
    <tr>
      <td colspan="6" scope="row"><?=get_string('notusedtoken');?></td>
    </tr>
<?php } ?>	
	</table><br/><br/>
  </fieldset>
    <br/>
  <center>
  <input type="button" name="closepage" value="Close" onclick="window.close();return false;">
  </center><br/><br/>
</form>
<?php 
	//echo $OUTPUT->footer();
?>