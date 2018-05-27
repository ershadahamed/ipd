<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = 'Manage Candidate for Exam Registration';
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
	if (checked == false){checked = true}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
		document.getElementById('download_button').disabled=false;
	}
}
//  End -->
 function clearSelected(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
		//document.getElementById('download_button').disabled=true;
	}
  }
</script>

<!--form name="form" id="form" action="<?//=$CFG->wwwroot. '/offlineexam/download_token.php'; ?>" method="post"-->
<br/>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('tokentitle');?></legend>
<?=get_string('tokennotice');?><br/>
<div style="color:red; padding-top:0.5em;">
<?//=get_string('tokendownloadsuccesful');?>
<?php
	if(isset($_POST['download_button'])){ 
		echo'<table border="1" style="text-align:center;margin: 10px auto; width:95%; color:#4f0093; height:60px;"><tr><td>';
		echo 'Thank you. Token id for <b>'.get_string('tokendownloadsuccesful').'</b> have been download.';
		echo '</td></tr></table>';	
	}
?>
</div>
<form name="form" id="form" action="" method="post">
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
				<input type="button" name="unselectall" id="unselectall" value="Unselect All" onclick="clearSelected();" />
				<input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll()"/>
				<input type="submit" name="download_button" id="download_button" value="Download" onClick="this.form.action='<?=$CFG->wwwroot. '/offlineexam/downloadtoken.php';?>'" />
			</td>
		</tr>    
	</table>
	
<?php		
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken e On b.courseid = e.courseid And
		e.userid = d.id	
	";
	
	$statement.=" WHERE a.category = '3' AND d.usertype='Active Candidate'";
	if($candidatedetails_s!=''){
		$statement.=" AND {$candidatedetails} LIKE '%{$candidatedetails_s}%'";
	}
	$csql="SELECT *, c.timestart as enroltime, a.id as examid, e.id as token_id FROM {$statement} ORDER BY d.traineeid ASC";
	$sqlquery=mysql_query($csql);	
?>	
	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th width="11%" scope="row">Candidate ID</th>
		  <th width="20%">First Name</th>
		  <th width="20%">Last Name</th>
		  <th width="10%">DOB</th>
		  <th>CIFA&#8482; Examination Title</th>
		  <th width="10%">Token Expiry</th>
		  <th width="1%">&nbsp;</th>
		  <th width="2%">&nbsp;</th>
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
		  <td scope="row" align="center"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname']));?></td>
		  <td><?=ucwords(strtolower($sqlrow['lastname']));?></td>
		  <td style="text-align:center"><a href="<?=$linkto;?>" target="_blank"><?=date('d/m/Y', $sqlrow['dob']);?></a></td>
		  <td><?=$sqlrow['fullname'];?></td>
		  <td><?=date('d/m/Y H:i:s', $sqlrow['tokenexpiry']);?></td>
		  <td align="center"><input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['token_id'];?>" /></td>
		  <td align="center"><input type="submit" name="download_button2" id="download_button2" value="Download" onClick="this.form.action='<?=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['token_id'].'&examid='.$sqlrow['examid'];?>'" /></td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="8" scope="row">Records not found</td></tr>
<?php } ?>
		</table></form>	
		<form name="form" id="form" action="" method="post">
		<table width="95%" border="0" style="margin:0px auto; padding:0px; border: 0px solid #666666; border-collapse:collapse;">
			<tr>
			  <td align="right"><input type="button" name="buttonprint" id="buttonprint" value="Print" onclick="window.print();" />
			  <input type="submit" name="buttonback" id="buttonback" onClick="this.form.action='<?=$CFG->wwwroot. '/index.php';?>'" value="<?=get_string('back');?>" />
			  </td>
			</tr>    
		</table></form>	
		<br/>	  
  
  </fieldset>

<?php 
	echo $OUTPUT->footer();
?>