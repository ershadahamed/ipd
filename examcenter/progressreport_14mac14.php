<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $progressreport = 'View Report';
    $PAGE->navbar->add(ucwords(strtolower($progressreport)));	

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
<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAll () {
	if (checked == false){checked = true;}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
		//document.getElementById('selectall').disabled=true;
	}
}
//  End -->
 function clearSelected(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
		//document.getElementById('unselectall').disabled=true;
	}
  }
</script>
<br/>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('progressreport');?></legend>
<?//=get_string('progressreport');?><br/>

<form name="form1" id="form1" action="" method="post">
	<table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="left">
				<input type="submit" name="download_button2" id="download_button2" value="Download" onClick="this.form.action='<?//=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" />
				<input type="button" name="html" id="html" value="HTML" onclick="clearSelected();" />
				<input type="button" name="selectall" id="selectall" value="EXCEL" onClick="checkedAll()"/>
				<input type="submit" name="download_button" id="download_button" value="CSV" onClick="this.form.action='<?//=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" />
			</td>
			<td align="right"><input type="button" name="unselectall" id="unselectall" value="Unselect All" onclick="clearSelected();" />
				<input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll()"/></td>
		</tr>    
	</table>
	
<?php
	/* $qlist=mysql_query("
		Select
		  a.id,
		  a.course,
		  b.quiz,
		  b.userid,
		  b.timefinish,
		  c.grade,
		  b.timestart
		From
		  mdl_cifaquiz a Inner Join
		  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
		  mdl_cifaquiz_grades c On b.quiz = c.quiz And b.userid = c.userid
		Where
		  b.userid='".$sqlrow['userid']."'
	");
	$slist=mysql_fetch_array($qlist); */
		
	$statement="
		  mdl_cifaquiz a Inner Join
		  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
		  mdl_cifaquiz_grades c On b.quiz = c.quiz And b.userid = c.userid Inner Join
		  mdl_cifacourse d On a.course = d.id Inner Join
		  mdl_cifauser e On b.userid = e.id
	";
	
	$statement.=" WHERE d.category = '3'";
	$csql="SELECT * FROM {$statement}";
	$sqlquery=mysql_query($csql);	
?>	
	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th width="15%" scope="row"><?=get_string('candidateid');?></th>
		  <th width="20%"><?=get_string('fullname');?></th>
		  <th width="20%"><?=get_string('programname');?></th>          
		  <th width="10%"><?=get_string('status');?></th>
		  <th width="10%"><?=get_string('marks');?></th>
		  <th width="12%"><?=get_string('modulecompleted');?></th>
		  <th width="10%"><?=get_string('totaltime');?></th>
          <th width="1%">&nbsp;</th>
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	// $linkto=$CFG->wwwroot. "/offlineexam/candidate_examsummary.php?id=".$sqlrow['userid']."&examid=".$sqlrow['examid'];
	$bil=$no++;
?>
		<tr>
		  <td style="text-align:center" scope="row"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname'].' '.$sqlrow['lastname']));?></td>
          <td style="text-align:left"><?=$sqlrow['fullname'];?></td>
		  <td style="text-align:center">
		  <?php
            if ($sqlrow['timefinish'] > 0) {
                // attempt has finished
                // $timetaken = format_time($sqlrow['timefinish'] - $sqlrow['timestart']);
				// $datecompleted = userdate($sqlrow['timefinish']);
				echo  'Ended';
            } else if (!$sqlrow['timeclose'] || strtotime('now') < $sqlrow['timeclose']) {
                // The attempt is still in progress.
                //$timetaken = format_time($viewobj->timenow - $attempt->timestart);
                echo $datecompleted = get_string('inprogress', 'quiz');
            } else {
                $timetaken = format_time($sqlrow['timefinish'] - $sqlrow['timestart']);
                echo $datecompleted = userdate($sqlrow['timeclose']);
            }		  
		  ?>
		  </td>
		  <td style="text-align:center"><?=round($sqlrow['grade']);?></td>
		  <td>&nbsp;</td>
		  <td style="text-align:center;">
		  <?php
			echo format_time($sqlrow['timefinish'] - $sqlrow['timestart']);
		  ?>
		  </td>
          <td style="text-align:center;"><input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['id'];?>" /></td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="10" scope="row">Records not found</td></tr>
<?php } ?>
		</table></form>	
		<form name="form" id="form" action="" method="post">
		<table width="95%" border="0" style="margin:0px auto; padding:0px; border: 0px solid #666666; border-collapse:collapse;">
			<tr>
			  <td align="right"><input type="submit" name="buttonback" id="buttonback" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/myreport.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" />
			    <input type="submit" name="buttonprint" id="buttonprint" value="Print" />
			  </td>
			</tr>    
		</table></form>	
		<br/>	  
  
  </fieldset>

<?php 
	echo $OUTPUT->footer();
?>