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
<script src="../script/jquery-1.9.1.js" type="text/javascript"></script>
<link href="http://fiddle.jshell.net/css/result-light.css" type="text/css" rel="stylesheet">
<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAll () {
	if (checked == false){checked = true;}
		for (var i = 0; i < document.getElementById('formx').elements.length; i++) {
		document.getElementById('formx').elements[i].checked = checked;
	}
}
//  End -->
 function clearSelected(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('formx').elements.length; i++) {
		document.getElementById('formx').elements[i].checked = checked;
	}
  }
</script>

<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAllOrg () {
	if (checked == false){checked = true;}
		for (var i = 0; i < document.getElementById('form2').elements.length; i++) {
		document.getElementById('form2').elements[i].checked = checked;
		//document.getElementById('selectall').disabled=true;
	}
}
//  End -->
 function clearSelectedOrg(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('form2').elements.length; i++) {
		document.getElementById('form2').elements[i].checked = checked;
		//document.getElementById('unselectall').disabled=true;
	}
  }
</script>
<script>
//<![CDATA[
$(window).load(function(){
$(document).ready(function() {
$("input[type=checkbox]").change(function()
{
var divId = $(this).attr("id");
if ($(this).is(":checked")) {
$("." + divId).show();
}
else {
$("." + divId).hide();
}
});
$("input[type=radio]").change();
});
$(document).ready(function() {
$("input[type=radio]").change(function()
{
var divId = $(this).attr("id");
$("div.check").hide();
$("." + divId).show();
$("input[type=checkbox]").change();
});
});
});//]]> 
</script>
<form name="formback" id="formback" action="" method="post">
	<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">
				<input type="submit" name="backbutton" id="backbutton" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/myreport.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" /></td>
		</tr>    
	</table>
</form>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('reportmenu');?></legend>
<div style="color:#F00; margin-bottom:1em;">
<?//=get_string('reportdeletedsuccessfully');?></div>


<form name="form1" id="form1" action="" method="post">
  <?php
	$role=mysql_query("SELECT name FROM {$CFG->prefix}role WHERE id='5'");
	$nrole=mysql_fetch_array($role);
	  
  		
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken On b.courseid = mdl_cifauser_accesstoken.courseid And
		mdl_cifauser_accesstoken.userid = d.id	
	";
	
	$statement.=" WHERE a.category = '3' AND d.usertype='".$nrole['name']."'";
	if($candidatedetails_s!=''){
		$statement.=" AND {$candidatedetails} LIKE '%{$candidatedetails_s}%'";
	}
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";
	$sqlquery=mysql_query($csql);	
?>


<table width="100%" style="border:none;" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-weight:bolder;" width="20%">Select Report</td>
    <td>
	<select name="selectreport" id="selectreport">
      <option <?php if($_POST['searchindividu']){ echo 'value="'.$_POST['selectreport'].'"'; }else{ echo 'value="0"';} ?>>Candidate Performance</option>
      <option <?php if($_POST['searchindividu']){ echo 'value="'.$_POST['selectreport'].'"'; }else{ echo 'value="1"';} ?> value="1">Examination Performance</option>
      <option <?php if($_POST['searchindividu']){ echo 'value="'.$_POST['selectreport'].'"'; }else{ echo 'value="2"';} ?> value="2">Examination Token Usage</option>
    </select></td>
  </tr>
  <tr>
    <td style="font-weight:bolder;">Report Name</td>
    <td><input name="reportnametext" type="text" id="reportnametext" size="40" <?php if($_POST['searchindividu']){ echo 'value="'.$_POST['reportnametext'].'"'; } ?>></td>
  </tr> 
</table>
</fieldset><br/>

<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">User | Individual</legend>
<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17%" scope="row">
      <?=get_string('candidatedetails');?></td>
    <td width="0%">:</td>
    <td width="83%">
	<select name="individualitem" id="individualitem" style="width:200px;">
	  <option value="traineeid"><?=get_string('candidateid');?></option>
	  <option value="firstname"><?=get_string('firstname');?></option>
	  <option value="lastname"><?=get_string('lastname');?></option>
	  <option value="dob"><?=get_string('dateofbirth');?></option>
    </select>
	<input name="individusearch" type="text" id="individusearch" size="40" />
	<input type="submit" name="searchindividu" id="searchindividu" value="Search" />
	</td></tr> 
</table>
</form>
<?php
	$selectreport=$_POST['selectreport'];
	$reportname=$_POST['reportnametext'];
?>
<form name="formx" id="formx" action="" method="post">
	<!---hidden info--->
	<input type="hidden" name="pilihanlaporan" id="pilihanlaporan" value="<?=$selectreport;?>" />
	<input type="hidden" name="namalaporan" id="namalaporan" value="<?=$reportname;?>" />
	<input type="hidden" name="reportgroup" id="reportgroup" <?php if($_POST['searchindividu']){ echo 'value="1"'; }else{ echo 'value="2"'; } ?> />

	<table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
        	<td><?=get_string('newreportindividualnotice');?></td>
			<td align="right"><input type="submit" name="confirmindividual" id="confirmindividual" value="Confirm" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/reportmenu_action.php?id='.$USER->id;?>'" />            
            	<input type="button" name="unselectall" id="unselectall" value="Unselect All" onclick="clearSelected();" />
				<input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll()"/>
          </td>
		</tr>    
	</table>	
    
<?php
	$individualitem=$_POST['individualitem']; 
	if($_POST['individualitem'] == 'dob'){
		$individusearch=strtotime($_POST['individusearch']); 
	}else{
		$individusearch=$_POST['individusearch'];	
	}
		
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken On b.courseid = mdl_cifauser_accesstoken.courseid And
		mdl_cifauser_accesstoken.userid = d.id	
	";
	
	$statement.=" WHERE a.category = '3' AND d.usertype='Active Candidate'";
	if($individusearch!=''){
		$statement.=" AND {$individualitem} LIKE '%{$individusearch}%'";
	}
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";
	$sqlquery=mysql_query($csql);	
?>	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th width="15%" scope="row"><?=get_string('candidateid');?></th>
		  <th width="20%"><?=get_string('firstname');?></th>
		  <th width="20%"><?=get_string('lastname');?></th>          
		  <th width="10%"><?=get_string('dob');?></th>
		  <th width="12%"><?=get_string('organization');?></th>
          <th width="1%">&nbsp;</th>
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
		  <td style="text-align:center"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname']));?></td>
          <td><?=ucwords(strtolower($sqlrow['lastname']));?></td>
		  <td style="text-align:center"><?=date('d/m/Y' ,$sqlrow['dob']);?></td>
		  <td style="text-align:center">&nbsp;</td>
          <td style="text-align:center;"><input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['id'];?>" /></td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="10" scope="row">Records not found</td></tr>
<?php } ?>
		</table></form><br/>	  
  </fieldset><br/>

<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">User | Organization</legend>

<form name="form2" id="form2" action="" method="post">
<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17%" scope="row">
      <?=get_string('orgname');?></td>
    <td width="0%">:</td>
    <td width="83%"><input name="reportnameorg" type="text" id="orgname" size="40" />      <input type="submit" name="searchorg" id="searchorg" value="Search" />
	</td></tr> 
</table>

	<table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
        	<td><?=get_string('newreportorgnotice');?></td>
			<td align="right"><input type="submit" name="confirmorg" id="confirmorg" value="Confirm" onClick="this.form.action='<?=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" />            
            	<input type="button" name="unselectallorg" id="unselectallorg" value="Unselect All" onclick="clearSelectedOrg();" />
				<input type="button" name="selectallorg" id="selectallorg" value="Select All" onClick="checkedAllOrg()"/>
          </td>
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
		  <th width="15%" scope="row"><?=get_string('candidateid');?></th>
		  <th width="20%"><?=get_string('firstname');?></th>
		  <th width="20%"><?=get_string('lastname');?></th>          
		  <th width="10%"><?=get_string('dob');?></th>
		  <th width="12%"><?=get_string('organization');?></th>
          <th width="1%">&nbsp;</th>
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
		  <td style="text-align:center"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname']));?></td>
          <td><?=ucwords(strtolower($sqlrow['lastname']));?></td>
		  <td style="text-align:center"><?=date('d/m/Y' ,$sqlrow['dob']);?></td>
		  <td style="text-align:center">&nbsp;</td>
          <td style="text-align:center;"><input type="checkbox" name="checktokenorg[]" id="checktokenorg[]" value="<?=$sqlrow['userid'];?>" /></td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="10" scope="row">Records not found</td></tr>
<?php } ?>
		</table></form><br/>	  
  
  </fieldset>  


<?php 
	echo $OUTPUT->footer();
?>