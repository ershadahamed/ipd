<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = get_string('tokentitle');
    $PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
    //echo $OUTPUT->heading('Manage Candidate for Exam Registration', 2, 'headingblock header');
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

<form id="form1" name="form1" method="post" action="">
<br/>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('tokentitle');?></legend>
<?=get_string('tokennotice');?><br/>
<div style="color:red; padding-top:0.5em;">
<?=get_string('tokendownloadsuccesful');?></div>
<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td scope="row">Candidate Detail</td>
    <td width="2%">:</td>
    <td>
	<select name="select" id="select" style="width:200px;">
      <option>Candidate ID</option>
      <option>First Name</option>
      <option>Last Name</option>
      <option>Date Of Birth</option>
    </select>
	<input type="text" style="width:300px;" name="textfield" id="textfield" />
	<input type="submit" name="button" id="button" value="Search" />
	</td></tr> 
</table>


	<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="right">
				<input type="submit" name="online_exam" id="online_exam" onClick="this.form.action='<?=$CFG->wwwroot. '/offlineexam/online_examschedule.php?id='.$USER->id;?>', target='_blank'" value="<?=get_string('onlineexam');?>" />
				<input type="submit" name="unselectall" id="unselectall" value="Unselect All" />
				<input type="submit" name="selectall" id="selectall" value="Select All" />
				<input type="submit" name="download_button" id="download_button" value="Download" />
			</td>
		</tr>    
	</table>
	
<?php
	$linkto=$CFG->wwwroot. "/offlineexam/candidate_examsummary.php?id=".$userid;
?>	
	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th width="15%" scope="row">Report Name</th>
		  <th width="20%">Created By</th>
		  <th width="20%">Creation Date</th>
		  <th width="15%">View</th>
		  <th width="25%">Schedule</th>
		  <th width="15%">Edit</th>
		  <th width="1%">&nbsp;</th>
		  <th width="3%">&nbsp;</th>
		</tr>
		<tr>
		  <td scope="row">&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td style="text-align:center"><a href="<?=$linkto;?>" target="_blank">18-1-1991</a></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td align="center"><input type="checkbox" name="checkbox" id="checkbox" /></td>
		  <td align="center"><input type="submit" name="download_button2" id="download_button2" value="Download" /></td>
		</tr>
		<!--tr><td colspan="8" scope="row">Records not found</td></tr-->
		</table>
		
		<table width="95%" border="0" style="margin:0px auto; padding:0px; border: 0px solid #666666; border-collapse:collapse;">
			<tr>
			  <td align="right"><input type="submit" name="buttonprint" id="buttonprint" value="Print" />
			  <input type="submit" name="buttonback" id="buttonback" onClick="this.form.action='<?=$CFG->wwwroot. '/index.php';?>'" value="<?=get_string('back');?>" />
			  </td>
			</tr>    
		</table>		
		<br/>	  
  
  </fieldset>
</form>
<?php 
	echo $OUTPUT->footer();
?>