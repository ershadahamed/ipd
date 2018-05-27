<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = get_string('myreport');
    $PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
?>
<style type="text/css">
<?php 
	include('../institutionalclient/style.css');
?>
	a:hover {text-decoration:underline;}
	#searchtable td, th{	 
		border: 1px solid #666666;
		border-collapse:collapse; 
	}	
</style>

<br/>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('myreport');?></legend>
<div style="color:#F00; margin-bottom:1em;">
<?//=get_string('reportdeletedsuccessfully');?></div>

<form name="form1" id="form1" action="" method="post">
	<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">
				<input type="submit" name="creatednewreport" id="creatednewreport" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/reportmenu.php?id='.$USER->id;?>'" value="<?=get_string('creatednewreport');?>" /></td>
		</tr>    
	</table>
  <?php		
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken On b.courseid = mdl_cifauser_accesstoken.courseid And
		mdl_cifauser_accesstoken.userid = d.id	
	";
	
	$statement.=" WHERE a.category = '3' AND d.usertype='Active Candidate'";
	if($candidatedetails_s!=''){
		$statement.=" AND {$candidatedetails} LIKE '%{$candidatedetails_s}%'";
	}
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";
	$sqlquery=mysql_query($csql);	
?>	
	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th><?=get_string('reportname');?></th>
		  <th width="20%"><?=get_string('createdby');?></th>
		  <th width="20%"><?=get_string('creationdate');?></th>
		  <th width="5%"><?=get_string('view');?></th>
		  <th width="5%"><?=get_string('schedule');?></th>
		  <th width="5%"><?=get_string('edit');?></th>
		  <th width="5%"><?=get_string('delete');?></th>
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$linkto=$CFG->wwwroot. "/examcenter/progressreport.php?id=".$USER->id;
	$linkschedule=$CFG->wwwroot. "/examcenter/schedulling.php?id=".$USER->id;
	$bil=$no++;
?>
		<tr>
		  <td scope="row">Candidate Performance</td>
		  <td><?=ucwords(strtolower($sqlrow['firstname'].' '.$sqlrow['lastname']));?></td>
		  <td style="text-align:center;"><?=date('d/m/Y H:i:s', strtotime("now"));?></td>
		  <td style="text-align:center;"><a title="<?=get_string('viewprogress');?>" href="<?=$linkto;?>"><?=get_string('view');?></a></td>
		  <td style="text-align:center;">
		  <a title="<?=get_string('viewprogress');?>" href="<?=$linkschedule;?>">
		  <?=get_string('schedule');?></a></td>
		  <td style="text-align:center;"><?=get_string('edit');?></td>
		  <td align="center">Delete</td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="8" scope="row">Records not found</td></tr>
<?php } ?>
		</table></form></fieldset>

<?php 
	echo $OUTPUT->footer();
?>