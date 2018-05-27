<?php 
    require_once('../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php'); 
	
	$site = get_site();
	
	$viewresult=get_string('communicationpreferences');
	$title="$SITE->shortname: ".$viewresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	//$PAGE->set_pagelayout('course');

	echo $OUTPUT->header();		
	
	$link=$CFG->wwwroot. '/index.php';
?>
<form method="post" name="form"  action="">
<div style="min-height:250px;padding: 10px 0px 0px 0px;">
<?php
	$co1=$_POST['column1'];
	$co2=$_POST['column2'];
	$co3=$_POST['column3'];

	//communication references accepted
	$date=strtotime('now');
	//$check_cr=mysql_query("SELECT * FROM mdl_cifacommunication_reference WHERE candidateid='".$USER->id."'");
	//$count_cr=mysql_num_rows($check_cr);
	//if($count_cr != '0'){
		//if ade, update communication references 
		$update_cr=mysql_query("UPDATE mdl_cifacommunication_reference SET rules1='1', rules2='".$co2."', timeaccepted='".$date."' WHERE candidateid='".$USER->id."'");
	//}	
?>
<center>
	<p><?=get_string('communicationpreferenceupdated');?></p>
	<input type="submit" name="comupdated" value="Continue" onMouseOver="style.cursor='pointer'" onClick="this.form.action='<?=$link;?>'" />
</center>
</div>
</form>
<?php echo $OUTPUT->footer(); ?>