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
	//require_once('../css/style.css'); 
	//require_once('../css/style2.css'); 
	//include('../css/pagination.css');
	//include('../css/grey.css');
	include('../institutionalclient/style.css');
?>
	a:hover {text-decoration:underline;}
	#searchtable td, th{	 
		border: 1px solid #666666;
		border-collapse:collapse; 
	}	
</style>
<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAll () {
	if (checked == false){checked = true}else{checked = false}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
		document.getElementById('download_button2').disabled=false;
	}
}
//  End -->
</script>
<form name="form" id="form" action="" method="post">
<!--form name="form" id="form" action="<?//=$CFG->wwwroot. '/offlineexam/download_token.php'; ?>" method="post"-->
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
	<select name="candidatedetails" id="candidatedetails" style="width:200px;">
      <option value="traineeid">Candidate ID</option>
      <option value="firstname">First Name</option>
      <option value="lastname">Last Name</option>
      <option value="dob">Date Of Birth</option>
    </select>
	<input type="text" style="width:300px;" name="candidatedetails_s" id="candidatedetails_s" />
	<input type="submit" name="button" id="button" value="Search" />
	</td></tr> 
</table>
<?php 
	$candidatedetails=$_POST['candidatedetails']; 
	if($_POST['candidatedetails'] == 'dob'){
		echo $candidatedetails_s=strtotime($_POST['candidatedetails_s']); 
	}else{
		$candidatedetails_s=$_POST['candidatedetails_s'];	
	}
?>
</form><form name="form1" id="form1" action="" method="post">
	<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="right">
				<input type="submit" name="online_exam" id="online_exam" onClick="this.form.action='<?=$CFG->wwwroot. '/offlineexam/online_examschedule.php?id='.$USER->id;?>', target='_blank'" value="<?=get_string('onlineexam');?>" />
				<input type="submit" name="unselectall" id="unselectall" value="Unselect All" />
				<input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll()"/>
				<input type="submit" name="download_button" id="download_button" value="Download" onClick="this.form.action='<?=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" />
			</td>
		</tr>    
	</table>
	
<?php	
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id 
	";
	$statement.=" WHERE a.category = '3' AND usertype='Active Candidate'";
	if($candidatedetails_s!=''){
		$statement.=" AND {$candidatedetails} LIKE '%{$candidatedetails_s}%'";
	}
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";
	$sqlquery=mysql_query($csql);	
?>	
	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th width="15%" scope="row">Candidate ID</th>
		  <th width="20%">First Name</th>
		  <th width="20%">Last Name</th>
		  <th width="15%">DOB</th>
		  <th width="25%">CIFA&#8482; Examination Title</th>
		  <th width="15%">Token Expiry</th>
		  <th width="1%">&nbsp;</th>
		  <th width="3%">&nbsp;</th>
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$linkto=$CFG->wwwroot. "/offlineexam/candidate_examsummary.php?id=".$sqlrow['userid']."&examid=".$sqlrow['examid'];
	$bil=$no++;
?>
		<tr>
		  <td scope="row"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname']));?></td>
		  <td><?=ucwords(strtolower($sqlrow['lastname']));?></td>
		  <td style="text-align:center"><a href="<?=$linkto;?>" target="_blank"><?=date('d-m-Y', $sqlrow['dob']);?></a></td>
		  <td><?=$sqlrow['fullname'].'-'.$sqlrow['courseid'];?><input type="hidden" name="examid" id="examid" value="<?=$sqlrow['courseid'];?>"></td>
		  <td><?=date('d-m-Y', $sqlrow['timeend']);?></td>
		  <td align="center"><input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['userid'];?>" /></td>
		  <td align="center"><input type="submit" name="download_button2" id="download_button2" value="Download" onClick="this.form.action='<?=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" /></td>
		</tr>

<?php
		//Insert data to user_accesstoken db table
/* 		$examid = $sqlrow['courseid'];
		
		$sqlInsert=mysql_query("UPDATE {$CFG->prefix}user_accesstoken 
		SET courseid='".$examid."' WHERE userid='".$sqlrow['userid']."' AND courseid='".$examid."'"); */
		
			//Insert data to user_accesstoken db table
			$access_token=uniqid(rand()); //create random number
			$timecreated = strtotime('now');
			$examid = $sqlrow['courseid'];
			
			$sqlInsert=mysql_query("UPDATE {$CFG->prefix}user_accesstoken 
			SET centerid='".$USER->id."', courseid='".$examid."', userid='".$checkBox[$i]."', user_accesstoken='".$access_token."', 
			timecreated_token='".$timecreated."' WHERE courseid='".$examid."' AND userid='".$sqlrow['userid']."'");		
		
	}
	}else{
?>
		<tr><td colspan="8" scope="row">Records not found</td></tr>
<?php } ?>
		</table></form>		
		<form name="form" id="form" action="" method="post">
		<table width="95%" border="0" style="margin:0px auto; padding:0px; border: 0px solid #666666; border-collapse:collapse;">
			<tr>
			  <td align="right"><input type="submit" name="buttonprint" id="buttonprint" value="Print" />
			  <input type="submit" name="buttonback" id="buttonback" onClick="this.form.action='<?=$CFG->wwwroot. '/index.php';?>'" value="<?=get_string('back');?>" />
			  </td>
			</tr>    
		</table></form>	
		<br/>	  
  
  </fieldset>

<?php 
	echo $OUTPUT->footer();
?>