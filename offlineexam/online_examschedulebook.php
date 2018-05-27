<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = get_string('olineexamschedulling');
	// $examreg=get_string('manageexamregister');
	
	$navtitle = get_string('myexamcenter');
	$titleccmanagement=get_string('cifacandidatemanagement');
	$url1=$CFG->wwwroot. '/offlineexam/multi_token_download.php?id='.$USER->id;
	$ccmanagement=get_string('ccmanagement');
    $PAGE->navbar->add(ucwords(strtolower($navtitle)), $url1)->add(ucwords(strtolower($ccmanagement)), $url1);	
    $PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
    //echo $OUTPUT->heading('Manage Candidate for Exam Registration', 2, 'headingblock header');

	$startdatepicker = $_POST['startdatepicker'];
	$datetimepicker = $_POST['datetimepicker'];
	$selecteduser = $_POST['selecteduser']; // id
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
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('olineexamschedulling');?></legend>

<div style="color:#2cac19; font-weight:bolder;padding:0.5em 2em;">
"<?=get_string('olinebookexam');?>"</div>

<table width="95%" border="0" cellpadding="2" cellspacing="0" style="margin:0px auto;">
    <tr>
		<td align="right">
			<input type="button" name="back" onClick="window.close()" value="<?=get_string('back');?>" />
			<!--input type="button" name="printbookexam" id="printbookexam" value="Print" onclick="window.open('<?//=$CFG->wwwroot. "/offlineexam/print_bookexam.php?id=".$USER->id."&examid=".$USER->id."&userid=".$USER->id."&centerid=";?>', 'Window2', 'width=850, height=950,resizable = 1, scrollbars=yes');"/-->			
			<input type="submit" name="printbookexam" id="printbookexam" value="Print" onClick="this.form.action='<?=$CFG->wwwroot. '/offlineexam/online_examschedulebook_print.php?id='.$USER->id;?>', target='_blank'" />			
		</td>
    </tr>    
  </table>
<table width="95%" border="1" id="searchtable" style="margin:0px auto;">
    <tr align="center" style="background-color:#ccc;">
      <th width="10%" scope="row">Candidate ID</th>
      <th width="15%">First Name</th>
      <th width="15%">Last Name</th>
      <th width="20%">CIFA&#8482; Examination Title</th>
      <th width="10%">Token Expiry</th>
      <th width="10%">Exam Date</th>
      <th width="10%">Exam Time</th>
    </tr>
<?php
	for($i=0; $i<sizeof($selecteduser); $i++){	
		$bookingid=$selecteduser[$i];
		$examdate=$startdatepicker[$i];
		$examtime=$datetimepicker[$i];
		
		//if($examdate==''){ echo 'lol';}
		
	//update bookstatus, bookexam
	$sql=mysql_query("UPDATE {$CFG->prefix}user_accesstoken SET examdate='".$examdate."', examtime='".$examtime."', centerid='".$USER->id."', bookstatus='1', bookexam='0' 
	WHERE bookexam='1' AND id='".$selecteduser[$i]."' AND bookstatus='0'") 
	or die("Not update - ".mysql_error());	
	//End update	
	
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken e On b.courseid = e.courseid And e.userid = d.id	
	";
	
	$statement.=" WHERE a.category = '3' AND d.usertype='Active Candidate' And e.bookexam='0' And e.bookstatus='1' And e.id='".$selecteduser[$i]."' And e.centerid='".$USER->id."'";
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";

	$sqlquery=mysql_query($csql);
	while($sqlrow=mysql_fetch_array($sqlquery)){
?>
    <tr>
      <td style="text-align:center;" scope="row"><?=$sqlrow['traineeid'];?>
      	<input type="hidden" name="bookingid[]" value="<?=$bookingid;?>"/>
        <input type="hidden" name="suser[]" value="<?=$selecteduser[$i];?>"/></td>
      <td><?=$sqlrow['firstname'];?></td>
      <td><?=$sqlrow['lastname'];?></td>
      <td><?=$sqlrow['fullname'];?></td>
      <td style="text-align:center;"><?=date('d/m/Y H:i:s', $sqlrow['tokenexpiry']);?></td>
      <td style="text-align:center;"><?=$sqlrow['examdate'];?></td>
      <td style="text-align:center;"><?=$sqlrow['examtime'];?></td>
    </tr>
<?php }} ?>
</table></fieldset></form>
<?php 
	echo $OUTPUT->footer();
?>