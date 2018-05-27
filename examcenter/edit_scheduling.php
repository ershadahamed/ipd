<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $editschedulling = get_string('newschedulling');
    $PAGE->navbar->add(ucwords(strtolower($progressreport)));	
	
    $scheduling = get_string('schedulingreport');
    $listusertoken = get_string('myreport');
	$myadmin = get_string('myadmin');
	$url1=new moodle_url('/examcenter/myreport.php', array('id'=>$USER->id));  
	$url2=$CFG->wwwroot. '/examcenter/edit_scheduling.php?id='.$_GET['id'].'&scheduling='.$_GET['scheduling'].'&scdid='.$_GET['scdid'];
    $PAGE->navbar->add(ucwords(strtolower($myadmin)), $url1)->add(ucwords(strtolower($listusertoken)), $url1);	
	//$PAGE->navbar->add(ucwords(strtolower($scheduling)));
	$PAGE->navbar->add(ucwords(strtolower($editschedulling)), $url2);	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
?>

<head>
    <!-- Load jQuery from Google's CDN -->
    <!-- Load jQuery UI CSS  -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="./jquery.datetimepicker.css"/>
    
    <!-- Load jQuery JS -->
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <!-- Load jQuery UI Main JS  -->
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    
    <!-- Load SCRIPT.JS which will create datepicker for input field  -->
    <script src="script.js"></script>
   
    <link rel="stylesheet" href="runnable.css" />
  </head>

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
<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAll () {
	if (checked == false){checked = true;}
		for (var i = 0; i < document.getElementById('form').elements.length; i++) {
		document.getElementById('form').elements[i].checked = checked;
		//document.getElementById('selectall').disabled=true;
	}
}
//  End -->
 function clearSelected(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('form').elements.length; i++) {
		document.getElementById('form').elements[i].checked = checked;
		//document.getElementById('unselectall').disabled=true;
	}
  }
</script>
<br/>
<?php
	$reportid=$_GET['id'];
	$scheduling=$_GET['scheduling'];
	$scdid=$_GET['scdid'];
	
	$reportSQL=mysql_query("
		Select
		  *
		From
		  mdl_cifareport_menu a Inner Join
		  mdl_cifareport_option b On b.reportid = a.id Inner Join
		  mdl_cifareport_users c On b.reportid = c.reportid
		Where
			b.reportid='".$reportid."'	
	");
	$viewreport=mysql_fetch_array($reportSQL);

	$rpcreator=mysql_query("
		Select
		  b.userid,
		  a.name,
		  b.contextid
		From
		  {$CFG->prefix}role a Inner Join
		  {$CFG->prefix}role_assignments b On a.id = b.roleid
		Where
		  b.userid = '".$viewreport['reportcreator']."' And
		  b.contextid = '1'		
	");
	$creator=mysql_fetch_array($rpcreator);
	
	$schedule_statement="
	  mdl_cifareport_scheduling a Inner Join
	  mdl_cifareport_recipient b On a.id = b.scheduling_id Inner Join
	  mdl_cifauser c On b.recipient_id = c.id Inner Join
	  mdl_cifareport_menu d On a.rid = d.id
	";
	
	$scsql="SELECT * FROM {$schedule_statement} WHERE b.scheduling_id='".$scdid."' AND a.rid='".$reportid."' AND a.scheduling='".$scheduling."' ORDER BY a.rid ASC";
	$ssqlquery=mysql_query($scsql);
	$ssch=mysql_fetch_array($ssqlquery);
	
	
?>
<div style="margin-left:0em;font-size:2em; font-weight:bolder;"><?=$viewreport['reportname'];?></div>
<div style="margin-left:0em;margin-bottom:1em;">By <?=$creator['name'];?>, <?=date('d/m/Y h:i:s', $viewreport['timecreated']);?></div>

<form name="formback" id="formback" action="" method="post">
	<table style="margin-bottom: 0px;width:100%;padding:0px; border: 0px solid #666666; border-collapse:collapse;text-align:right;" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="right">
			<!--input type="button" id="id_defaultbutton" name="backbutton" onclick="window.close()" value="Back" /-->
			<input type="submit" name="buttonback2" id="id_defaultbutton" onclick="this.form.action='<?=$CFG->wwwroot. '/examcenter/myreport.php?id='.$USER->id;?>', target = '_parent'" value="<?=get_string('back');?>" />
			</td>
		</tr>    
	</table>
</form>    
   
<form name="form" id="form" action="" method="post">
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('reporttimeline');?></legend>
	<table style="float:left;width:320px;padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td style="font-weight:bolder;" width="30%">Start Date</td>
		<td><input type="text" name="startdatepicker" id="startdatepicker" value="<?=$viewreport['tlstartdate'];?>" /></td>
	</tr>
    <tr>
		<td style="font-weight:bolder;">End Date</td>
		<td>
			<input type="text" name="enddatepicker" id="enddatepicker" value="<?=$viewreport['tlenddate'];?>" />
			<input type="hidden" name="hiddenreportid" id="hiddenreportid" value="<?=$reportid;?>" />
		</td>
	</tr> 
	</table>
</fieldset>
   
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('scheduling');?></legend>


	<table style="float:left;width:320px;padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="1%"><input type="radio" name="radio" id="radio" value="daily" <?php if($ssch['scheduling']=='daily'){echo 'checked';} ?>></td>
			<td align="left"><?=get_string('daily');?><input type="hidden" name="daily" value="1"></td>
			<td align="left">&nbsp;</td>                        
	  </tr>  
        
	  <tr>
			<td><input type="radio" name="radio" id="radio" value="weekly" <?php if($ssch['scheduling']=='weekly'){echo 'checked';} ?>></td>
			<td align="left"><?=get_string('weekly');?></td>
			<td align="left"><select name="recipientweekly" id="recipientweekly" style="width:120px;">
			  <option value="1" <?php if($ssch['scheduling_value']=='1'){echo 'selected';} ?>>Monday</option>
			  <option value="2" <?php if($ssch['scheduling_value']=='2'){echo 'selected';} ?>>Tuesday</option>
			  <option value="3" <?php if($ssch['scheduling_value']=='3'){echo 'selected';} ?>>Wednesday</option>
			  <option value="4" <?php if($ssch['scheduling_value']=='4'){echo 'selected';} ?>>Thursday</option>
			  <option value="5" <?php if($ssch['scheduling_value']=='5'){echo 'selected';} ?>>Friday</option>
			  <option value="6" <?php if($ssch['scheduling_value']=='6'){echo 'selected';} ?>>Saturday</option>
			  <option value="7" <?php if($ssch['scheduling_value']=='7'){echo 'selected';} ?>>Sunday</option>
            </select></td>                        
		</tr>
        		<tr>
			<td align="right"><input type="radio" name="radio" id="radio" value="monthly" <?php if($ssch['scheduling']=='monthly'){echo 'checked';} ?>></td>
			<td align="left"><?=get_string('monthly');?></td>
			<td align="left">
			<?php
				list($day, $month, $year) = explode('/', $viewreport['tlstartdate']);
				list($day2, $month2, $year2) = explode('/', $viewreport['tlenddate']);
			?>			 
              <select name="recipientmonthly" id="recipientmonthly" style="width:120px;">
              <?php
				echo $scv=$ssch['scheduling_value'];
				foreach(range($day, $day2) as $number) {
					echo '<option value="'.$number.'"';
					if($scv==$number){ echo 'selected';}
					echo '>'.$number.'</option>';
				}			  
			  ?>
              </select>
             </td>                        
		</tr>          
	</table>
<!--/form--><br/>	  
  
  </fieldset>
<br/>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('recipient');?></legend>

<!--form name="form1" id="form1" action="" method="post"-->
<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%" scope="row">
      <?=get_string('recipientdetails');?></td>
    <td width="2%">:</td>
    <td>
	<select name="recipientdetails" id="recipientdetails" style="width:200px;">
	  <option value="traineeid" selected="selected"><?=get_string('candidateid');?></option>
      <option value="firstname"><?=get_string('firstname');?></option>
      <option value="lastname"><?=get_string('lastname');?></option>
      <option value="dob"><?=get_string('dateofbirth');?></option>
      <option value="empname"><?=get_string('orgname');?></option>
    </select>
	<input type="text" style="width:300px;" name="candidatedetails_s" id="candidatedetails_s" />
	<input type="submit" name="searchindividu" id="searchindividu" value="Search" />
	</td></tr> 
</table>
<?php 
if($_POST['searchindividu']){	
	$scheduling=$ssch['scheduling'];
	$scheduling_value=$ssch['scheduling_value'];
}else{
	$scheduling=$ssch['scheduling'];
	$scheduling_value=$ssch['scheduling_value'];
}	

	// $updatereport=$CFG->wwwroot. '/examcenter/reportmenu_update.php?id='.$_GET['id'].'&sreport='.$selectreport.'&nreport='.$reportname.'&nr='.$nr;
?>
	<table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
        	<td><?=get_string('schedulenotice');?></td>
			<td align="right">
				<input type="submit" name="confirm" id="confirm" value="Confirm" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/edit_scheduling_sql.php?scheduling='.$scheduling.'&sid='.$scheduling_value.'&rid='.$reportid.'&scheduling_id='.$scdid;?>'" />            
            	<input type="button" name="unselectall" id="unselectall" value="Unselect All" onclick="clearSelected();" />
				<input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll()"/>
          </td>
		</tr>    
	</table>	
    
<?php	
	$candidatedetails=$_POST['recipientdetails']; 
	$candidatedetails_s=$_POST['candidatedetails_s'];
	
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id	
	";
	
	$statement.=" WHERE c.userid!='".$USER->id."' AND d.orgtype='".$USER->orgtype."'";
	if($candidatedetails_s!=''){
		if($candidatedetails=='dob'){
			$statement.=" AND ((date_format(from_unixtime(d.dob), '%d/%m/%Y') LIKE '%{$candidatedetails_s}%'))";
		}else{
			$statement.=" AND {$candidatedetails} LIKE '%{$candidatedetails_s}%'";
		}
	}
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} GROUP BY c.userid ORDER BY d.traineeid ASC";
	$sqlquery=mysql_query($csql);	
?>	
	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th width="15%" scope="row"><?=get_string('candidateid');?></th>
		  <th width="20%" style="text-align:left;"><?=get_string('firstname');?></th>
		  <th width="20%" style="text-align:left;"><?=get_string('lastname');?></th>          
		  <th width="10%"><?=get_string('dob');?></th>
		  <th width="10%"><?=get_string('designation');?></th>
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



  
	//$sqlcheck=mysql_query("SELECT * FROM {$CFG->prefix}report_recipient WHERE scheduling_id='".$scdid."' AND recipient_id='".$sqlrow['userid']."'");
	$sqlcheck=mysql_query("
		Select
		  b.scheduling_id,
		  b.recipient_id,
		  a.rid
		From
		  mdl_cifareport_scheduling a Inner Join
		  mdl_cifareport_recipient b On a.id = b.scheduling_id
		Where
		  b.scheduling_id = '".$scdid."' And b.recipient_id='".$sqlrow['userid']."' And a.rid='".$reportid."'
	");
	$checktokenid=mysql_fetch_array($sqlcheck);
	$cid=$checktokenid['recipient_id'];
	$uid=$sqlrow['userid'];
?>
		<tr>
		  <td style="text-align:center"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname']));?></td>
          <td><?=ucwords(strtolower($sqlrow['lastname']));?></td>
		  <td style="text-align:center"><?=date('d/m/Y', $sqlrow['dob']);?></td>
		  <td style="text-align:center">
		  <?php if($sqlrow['designation']!=''){ echo $sqlrow['designation']; }else{ echo ' - ';} ?>
			</td>
		  <td style="text-align:center;">
		  <?php
			if($sqlrow['orgtype']!=''){ 
				$sqlor=mysql_query("
					SELECT * 
					FROM  mdl_cifaorganization_type WHERE id='".$sqlrow['orgtype']."' 				
				");
				$sql=mysql_fetch_array($sqlor);
				echo $sql['name']; 
			}else{ echo ' - '; } ?>		  
			<?php //if($sqlrow['empname']!=''){ echo $sqlrow['institution']; }else{ echo ' - '; }?>
		  </td>
          <td style="text-align:center;"><input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['userid'];?>" <?php if($uid==$cid){ echo 'checked'; } ?> /></td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="10" scope="row">Records not found</td></tr>
<?php } ?>
		</table><br/>	  
  </fieldset>  </form>

<?php 
	echo $OUTPUT->footer();
?>