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
	$examreg=get_string('manageexamregister');
    $PAGE->navbar->add(ucwords(strtolower($examreg)))->add(ucwords(strtolower($listusertoken)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
    //echo $OUTPUT->heading('Manage Candidate for Exam Registration', 2, 'headingblock header');
?>
    <!-- Load jQuery from Google's CDN -->
    <!-- Load jQuery UI CSS  -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="../examcenter/jquery.datetimepicker.css"/>
    
    <!-- Load jQuery JS -->
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <!-- Load jQuery UI Main JS  -->
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    
    <!-- Load SCRIPT.JS which will create datepicker for input field  -->
    <script src="../examcenter/script.js"></script>
   
    <link rel="stylesheet" href="runnable.css" />
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
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('olineexamschedulling');?></legend>

<form id="form1" name="form1" method="post" action="">
<?php if (isset($_POST['bookexam'])){ ?>
<div style="color:#2cac19; font-weight:bolder;padding:0.5em 2em;">
"<?=get_string('olinebookexam');?>"</div>
<?php } ?>

<table width="95%" border="0" cellpadding="2" cellspacing="0" style="margin:0px auto;">
    <tr>
		<td align="right">
			<input type="submit" name="back" onClick="this.form.action='<?=$CFG->wwwroot. '/offlineexam/multi_token_download.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" />
			<?php if (isset($_POST['bookexam'])){ ?>
			<input type="button" name="printbookexam" id="printbookexam" value="Print" onclick="window.open('<?=$CFG->wwwroot. "/offlineexam/print_bookexam.php?id=".$USER->id;?>', 'Window2', 'width=850, height=950,resizable = 1, scrollbars=yes');"/>			
			<?php }else{ ?>
			<input type="submit" name="bookexam" id="bookexam" value="Book Exam" onClick="this.form.action='<?=$CFG->wwwroot. '/offlineexam/online_examschedule.php?id='.$USER->id;?>'" />
			<?php } ?>
		</td>
    </tr>    
  </table>
 <?php if (!isset($_POST['bookexam'])){  ?> 
  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
    <tr align="center" style="background-color:#ccc;">
      <th width="10%" scope="row">Candidate ID</th>
      <th width="20%">First Name</th>
      <th width="20%">Last Name</th>
      <th width="20%">CIFA&#8482; Examination Title</th>
      <th width="10%">Token Expiry</th>
      <th width="10%">Exam Date</th>
      <th width="10%">Exam Time</th>
    </tr>
	
<?php
if($_POST['checktoken'] != ""){
	$checkBox = $_POST['checktoken'];
	for($i=0; $i<sizeof($checkBox); $i++){
	// echo $i;
	//update token, center ID, token start date, token expiry	
	$sqlUP=mysql_query("UPDATE {$CFG->prefix}user_accesstoken SET bookexam='1', bookstatus='0' WHERE id='".$checkBox[$i]."'") 
	or die("Not update - ".mysql_error());	
	//End update	

	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken e On b.courseid = e.courseid And e.userid = d.id	
	";
	
	$statement.=" WHERE a.category = '3' AND d.usertype='Active Candidate' And e.id='".$checkBox[$i]."'";
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";

	$sqlquery=mysql_query($csql);
	$sqlrow=mysql_fetch_array($sqlquery);
	
	//token availibility
	$tokenstart=strtotime('now');
	$tokenexpiry=$sqlrow['tokenexpiry'];
	
	//exam date and time
	$examtimedatesql=mysql_query("
		Select
		  a.category,
		  b.name,
		  b.course,
		  b.timeopen
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifaquiz b On a.id = b.course
		Where
		  a.category = '3' And
		  b.course = '".$sqlrow['courseid']."' AND b.timeopen!='0'	
	");
	$examtimedate=mysql_fetch_array($examtimedatesql);
	
?>	
	
    <tr>
      <td style="text-align:center;" scope="row"><?=$sqlrow['traineeid'];?><input type="hidden" name="selecteduser" value="<?=$checkBox[$i];?>"/></td>
      <td><?=$sqlrow['firstname'];?></td>
      <td><?=$sqlrow['lastname'];?></td>
      <td><?=$sqlrow['fullname'];?></td>
	  <td style="text-align:center;"><?=date('d/m/Y H:i:s', $sqlrow['tokenexpiry']);?></td>
	  <td style="text-align:center;">
		startdatepicker<?=$i;?><?//=$sqlrow['enrolid'];?>
		<input type="text" name="startdatepicker<?=$i;?>" id="startdatepicker<?=$i;?>" /><?//=date('d/m/Y', $examtimedate['timeopen']);?>
	  </td>
	  <td style="text-align:center;">
		datetimepicker<?=$i;?><?//=$sqlrow['userid'];?>
		<input type="text" id="datetimepicker<?=$i;?>" name="datetimepicker<?=$i;?>"/><?//=date('H:i:s', $examtimedate['timeopen']);?>
	  </td>
   </tr>
	  <script src="../examcenter/jquery.datetimepicker.js"></script>
	<script>
    $('#datetimepicker<?=$i;?>').datetimepicker({
        datepicker:false,
        format:'H:i',
        step:5
    }); 
	
	/*  jQuery ready function. Specify a function to execute when the DOM is fully loaded.  */
	$(document).ready(
	  
	  /* This is the function that will get executed after the DOM is fully loaded ({ dateFormat: "yy-mm-dd" }) */
	  function () {
		$( "#startdatepicker<?=$i;?>" ).datepicker({
		  dateFormat: "dd/mm/yy",
		  changeMonth: true,//this option for allowing user to select month
		  changeYear: true //this option for allowing user to select from year range
		});
	  }

	);	
    </script> 
<?php
	}
}else{
?>
    <tr>
      <td colspan="7" scope="row">Records not found</td>
    </tr>
<?php } ?>
	</table><br/><br/>
</form>	


<?php
	} if (isset($_POST['bookexam'])){
		
	// $timestartexam="";
	// $sqldatetime=mysql_query("UPDATE {$CFG->prefix}user_enrolments SET timestart='".$timestartexam."', timeend='0' WHERE enrolid='".$sqlrow['enrolid']."' AND userid='".$sqlrow['userid']."'");
	
	//update bookstatus, bookexam
	$sql=mysql_query("UPDATE {$CFG->prefix}user_accesstoken SET bookstatus='1', bookexam='0' WHERE bookexam='1' AND bookstatus='0'") 
	or die("Not update - ".mysql_error());	
	//End update	
	
	//token availibility

?>
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
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken e On b.courseid = e.courseid And e.userid = d.id	
	";
	
	$statement.=" WHERE a.category = '3' AND d.usertype='Active Candidate' And e.bookexam='0' And e.bookstatus='1'";
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";

	$sqlquery=mysql_query($csql);
	while($sqlrow=mysql_fetch_array($sqlquery)){
?>
    <tr>
      <td style="text-align:center;" scope="row"><?=$sqlrow['traineeid'];?></td>
      <td><?=$sqlrow['firstname'];?></td>
      <td><?=$sqlrow['lastname'];?></td>
      <td><?=$sqlrow['fullname'];?></td>
      <td style="text-align:center;"><?=date('d/m/Y H:i:s', $sqlrow['tokenexpiry']);?></td>
      <td></td>
      <td></td>
    </tr>
<?php } ?>
</table><br/><br/>
<?php	
	} 
?>
  </fieldset>

<?php 
	echo $OUTPUT->footer();
?>