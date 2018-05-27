<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $navtitle = get_string('myexamcenter');
	$titleccmanagement=get_string('cifacandidatemanagement');
	$url1=$CFG->wwwroot. '/offlineexam/multi_token_download.php?id='.$USER->id;
	$ccmanagement=get_string('ccmanagement');
    $PAGE->navbar->add(ucwords(strtolower($navtitle)), $url1)->add(ucwords(strtolower($ccmanagement)), $url1);	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
    echo $OUTPUT->heading($titleccmanagement, 2, 'headingblock header');
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
<script type="text/javascript">
function popupwindow(url, title, w, h) { //Center PopUp Window added by Izzat
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
</script>
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
<script type="text/javascript" language="javascript">
function checkfield(){
	var checked=false;
	var elements = document.getElementsByName("checktoken[]");
	for(var i=0; i < elements.length; i++){
		if(elements[i].checked) {
			checked = true;
		}
	}
	if (!checked) {
		alert('Please check the box to download.');
		return checked;
	}

document.form1.submit();
return true;	
} 
</script>

<br/>
<div style="color:red; padding-top:0.5em;">
<?//=get_string('tokendownloadsuccesful');?>
</div>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<form name="form" id="form" action="" method="post">
<?php
	$scourse=mysql_query("SELECT id, category, fullname FROM {$CFG->prefix}course WHERE category='3'");
?>
<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="18%" scope="row"><?=get_string('chooseshapeprogram');?></td>
    <td width="1%"><strong>:</strong></td>
    <td width="5%" colspan="2">
	<select name="chooseprogram" id="chooseprogram" style="width:200px;">
	  <option value="">None</option>
	  <option value="" selected="selected"><?=get_string('allshapeprogram');?></option>
	  <?php
		while($ccprogram=mysql_fetch_array($scourse)){
			echo '<option value="'.$ccprogram['id'].'">';
			echo $ccprogram['fullname']; // list of exam
			echo '</option>';
		}
	  ?>
	  <!--option>CIFA&#8482; Program Available</option-->
    </select>
  OR</td></tr> 
  <tr>
    <td width="18%" scope="row">Candidate Detail</td>
    <td width="1%"><strong>:</strong></td>
    <td width="5%">
	<select name="candidatedetails" id="candidatedetails" style="width:200px;">
      <option value="traineeid">Candidate ID</option>
      <option value="firstname">First Name</option>
      <option value="lastname">Last Name</option>
      <option value="dob">Date Of Birth</option>
    </select>
	</td>
	<td>
	<input type="text" style="width:300px;" name="candidatedetails_s" id="candidatedetails_s" placeholder="DOB format:DD/MM/YYYY" />
	<input type="submit" name="button" id="button" value="Search" />
	</td>
	</tr>
</table>
<?php 
	$chooseprogramid=$_POST['chooseprogram'];
	$candidatedetails=$_POST['candidatedetails']; 
	$candidatedetails_s=$_POST['candidatedetails_s'];	
?>
</form></fieldset>

<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('tokentitle');?></legend>
<?=get_string('tokennotice');?><br/>
<?php
	if(isset($_POST['download_button'])){ 
		echo'<table border="1" style="text-align:center;margin: 10px auto; width:95%; color:#4f0093; height:60px;"><tr><td>';
		echo 'Thank you. Token id for <b>'.get_string('tokendownloadsuccesful').'</b> have been download.';
		echo '</td></tr></table>';	
	}
	
	if(isset($_POST['download_button2'])){ 
		echo'<table border="1" style="text-align:center;margin: 10px auto; width:95%; color:#4f0093; height:60px;"><tr><td>';
		echo 'Thank you. Token id for <b>'.get_string('tokendownloadsuccesful').'</b> have been download.';
		echo '</td></tr></table>';	
	}	
?>

<form name="form1" id="form1" action="<?=$CFG->wwwroot. '/offlineexam/downloadtoken.php?cid=0';?>" method="post" >
	<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="right">
				<input type="submit" name="online_exam" id="online_exam" onClick="this.form.action='<?=$CFG->wwwroot. '/offlineexam/online_examschedule.php?id='.$USER->id;?>', target='_blank'" value="<?=get_string('onlineexam');?>" />
				<input type="button" name="unselectall" id="unselectall" value="Unselect All" onclick="clearSelected();" />
				<input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll()"/>
				<input type="button" name="download_button" id="download_button" value="Download" onclick="checkfield()" />                
			</td>
		</tr>    
	</table>
	
<?php
	//to get a role name
	$squery=mysql_query("SELECT name FROM {$CFG->prefix}role WHERE id='5'");
	$sqlrole=mysql_fetch_array($squery);
	$usertypename=$sqlrole['name'];
	
	//to get list of users with token
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken e On b.courseid = e.courseid And e.userid = d.id	
	";
	
	$statement.=" WHERE a.category = '3' AND d.usertype='".$usertypename."'";
	if($candidatedetails_s!=''){
		// $statement.=" AND {$candidatedetails} LIKE '%{$candidatedetails_s}%'";
		if($candidatedetails=='dob'){
			$statement.=" AND ((date_format(from_unixtime(d.dob), '%d/%m/%Y') LIKE '%{$candidatedetails_s}%'))";
		}else{
			$statement.=" AND {$candidatedetails} LIKE '%{$candidatedetails_s}%'";
		}
	}
	
	if($chooseprogramid!=''){
		$statement.=" AND b.courseid='".$chooseprogramid."'";
	}
	
	$csql="SELECT *, c.timestart as enroltime, a.id as examid, e.id as token_id, d.timecreated as utimecreated FROM {$statement} ORDER BY d.traineeid ASC";
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
		  <th width="1%">Select</th>
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
		  <td scope="row" align="center"><a href="<?=$linkto;?>" target="_blank"><?=strtoupper($sqlrow['traineeid']);?></a></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname']));?></td>
		  <td><?=ucwords(strtolower($sqlrow['lastname']));?></td>
		  <td style="text-align:center"><?=date('d/m/Y', $sqlrow['dob']);?></td>
		  <td><?=$sqlrow['fullname'];?></td>
		  <td>
			  <?php
                $utimecreated=date('d/m/Y H:i:s', $sqlrow['utimecreated']);
				echo $utokenexpiry=date('d/m/Y H:i:s', strtotime($utimecreated . " + 1 year"));
              ?>
          </td>
		  <?php
			$today=strtotime('now');
			$tokenexpiry=strtotime($utimecreated . " + 1 year");
			// $utokenexpiry=date('d/m/Y H:i:s', strtotime($utimecreated . " + 1 year"));
			if($today >= $tokenexpiry){
		  ?>
		  <td colspan="2">&nbsp;</td>
		  <?php }else{ ?>
		  <td align="center">
          	<input type="checkbox" name="checktoken[]" id="checktoken_<?=$bil;?>" value="<?=$sqlrow['token_id'];?>" />
          </td>
		  <td align="center"><input type="submit" name="download_button2" id="download_button2" value="Download" onClick="this.form.action='<?=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'].'&examid='.$sqlrow['examid'];?>'" /></td>
		  <?php } ?>
		</tr>
<?php
	}}else{
?>
		<tr><td colspan="10" scope="row"><?=get_string('searchresultnotfound');?></td></tr>
<?php } ?>
		</table></form>	
		<form name="form" id="form" action="" method="post">
		<table width="95%" border="0" style="margin:0px auto; padding:0px; border: 0px solid #666666; border-collapse:collapse;">
			<tr>
			  <td align="right">
				<input type="button" name="buttonprint" id="buttonprint" value="Print" onclick="popupwindow('multi_token_download_printpage.php?programid=<?=$chooseprogramid.'&candidatedetails='.$candidatedetails.'&candidatedetails_s='.$candidatedetails_s;?>','googlePopup',1300,768);" />
				<!--input type="button" name="buttonprint" id="buttonprint" value="Print" onclick="window.print();" /-->
				<input type="submit" name="buttonback" id="id_defaultbutton" onClick="this.form.action='<?=$CFG->wwwroot. '/index.php';?>'" value="<?=get_string('back');?>" />
			  </td>
			</tr>    
		</table></form>	
		<br/>	  
  
  </fieldset>

<?php 
	echo $OUTPUT->footer();
?>