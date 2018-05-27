<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	$id=$_GET['scdid'];
	$sid=$_GET['sid'];
	
	/* echo $sschedule=mysql_query("SELECT * FROM {$CFG->prefix}report_scheduling WHERE id='".$id."'");
	$schedul=mysql_fetch_array($sschedule); */
	
	$deleteschedule=mysql_query("DELETE FROM {$CFG->prefix}report_scheduling WHERE id='".$id."'");
	if($deleteschedule==1){
	$deleterecord=mysql_query("DELETE FROM {$CFG->prefix}report_recipient WHERE scheduling_id='".$id."'");
	if($deleterecord){
?>
			<script language="javascript">
				window.alert("Delete successful.");
				window.location.href = '<?=$CFG->wwwroot. "/examcenter/myreport.php";?>'; 
			</script>
<?php		
	}
	}
?>
