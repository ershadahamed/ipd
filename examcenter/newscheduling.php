<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $newschedulling = get_string('newschedulling');
    $PAGE->navbar->add(ucwords(strtolower($progressreport)));	

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
	$reportid=$_GET['rid'];
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
?>
<div style="margin-left:0em;font-size:2em; font-weight:bolder;"><?=$viewreport['reportname'];?></div>
<div style="margin-left:0em;margin-bottom:1em;">By <?=$creator['name'];?>, <?=date('d/m/Y h:i:s', $viewreport['timecreated']);?></div>

<form name="formback" id="formback" action="" method="post">
	<table style="margin-bottom: 0px;width:100%;padding:0px; border: 0px solid #666666; border-collapse:collapse;text-align:right;" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="right"><input type="button" id="id_defaultbutton" name="backbutton" onclick="window.close()" value="Back" /></td>
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
		<td><input type="text" name="enddatepicker" id="enddatepicker" value="<?=$viewreport['tlenddate'];?>" /></td>
	</tr> 
	</table>
</fieldset>
 
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('scheduling');?></legend>


	<table style="float:left;width:320px;padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="1%"><input type="radio" name="radio" id="radio" value="daily"></td>
			<td align="left"><?=get_string('daily');?><input type="hidden" name="daily" value="1"></td>
			<td align="left">&nbsp;</td>                        
	  </tr>  
        
	  <tr>
			<td><input type="radio" name="radio" id="radio" value="weekly"></td>
			<td align="left"><?=get_string('weekly');?></td>
			<td align="left"><select name="recipientweekly" id="recipientweekly" style="width:120px;">
			  <option value="1" selected="selected">Monday</option>
			  <option value="2">Tuesday</option>
			  <option value="3">Wednesday</option>
			  <option value="4">Thursday</option>
			  <option value="5">Friday</option>
			  <option value="6">Saturday</option>
			  <option value="7">Sunday</option>
            </select></td>                        
		</tr>
        		<tr>
			<td align="right"><input type="radio" name="radio" id="radio" value="monthly"></td>
			<td align="left"><?=get_string('monthly');?></td>
			<td align="left">
			<?php
				list($day, $month, $year) = explode('/', $viewreport['tlstartdate']);
				list($day2, $month2, $year2) = explode('/', $viewreport['tlenddate']);
			?>			
              <select name="recipientmonthly" id="recipientmonthly" style="width:120px;">
              <?php	
				foreach(range($day, $day2) as $number) {
					echo '<option value="'.$number.'">'.$number.'</option>';
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
	<input type="submit" name="button" id="button" value="Search" />
	</td></tr> 
</table>
<?php 
	$candidatedetails=$_POST['recipientdetails']; 
	$candidatedetails_s=$_POST['candidatedetails_s'];	
?>
	<table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
        	<td><?=get_string('schedulenotice');?></td>
			<td align="right">
				<input type="submit" name="confirm" id="confirm" value="Confirm" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/newscheduling_sql.php?id='.$sqlrow['userid'].'&rid='.$_GET['rid'].'&sid='.$_GET['sid'];?>'" />            
            	<input type="button" name="unselectall" id="unselectall" value="Unselect All" onclick="clearSelected();" />
				<input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll()"/>
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
	
	$statement.=" WHERE c.userid!='".$USER->id."' And d.orgtype='".$USER->orgtype."'";
	if($candidatedetails_s!=''){
		if($candidatedetails=='dob'){
			$statement.=" AND ((date_format(from_unixtime(d.dob), '%d/%m/%Y') LIKE '%{$candidatedetails_s}%'))";
		}else{
			$statement.=" AND {$candidatedetails} LIKE '%{$candidatedetails_s}%'";
		}
	}
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} GROUP BY d.traineeid ORDER BY d.traineeid ASC";
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
			}else{ echo ' - '; }?>
		  </td>
          <td style="text-align:center;"><input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['userid'];?>" /></td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="10" scope="row">Records not found</td></tr>
<?php } ?>
		</table></form><br/>	  
  </fieldset>  
<script src="./jquery.datetimepicker.js"></script>
	<script>
    $('#datetimepicker1').datetimepicker({
        datepicker:false,
        format:'H:i',
        step:5
    }); 
    $('#enddatetimepicker').datetimepicker({
        datepicker:false,
        format:'H:i',
        step:5
    }); 	
    </script> 
<?php 
		/* if($_POST['checktoken'] != ""){
			if($_POST['radio']=='weekly'){
				$a=$_POST['recipientweekly'];
			}else if($_POST['radio']=='monthly'){
				$a=$_POST['recipientmonthly'];
			}else{
				$a=$_POST['daily'];
			}
			$schedule=mysql_query("INSERT INTO mdl_cifareport_scheduling(rid, scheduling, scheduling_value) VALUE('".$_GET['rid']."', '".$_POST['radio']."', '".$a."')");
			$scheduleid=mysql_insert_id();
				
			$checkBox = $_POST['checktoken'];
			for($i=0; $i<sizeof($checkBox); $i++){
				$recipient=$checkBox[$i];
				$rcp=mysql_query("INSERT INTO mdl_cifareport_recipient(scheduling_id, recipient_id) VALUE('".$scheduleid."', '".$recipient."')");
			}
		}
		
		$url=$CFG->wwwroot. '/examcenter/schedulling.php?id=119&rid=27&sid=1'; */

	echo $OUTPUT->footer();
?>