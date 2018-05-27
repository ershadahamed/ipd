<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	$reportid=$_GET['rid'];
	$sid=$_GET['sid'];
	
	//echo $reportid.'-->'.$sid.'-->'.$_REQUEST['rid'].'-->'.$_REQUEST['sid'];
	
	
	$deleterecord=mysql_query("DELETE FROM {$CFG->prefix}report_menu WHERE id='".$reportid."'");
	if($deleterecord==1){
		$deleterecord2=mysql_query("DELETE FROM {$CFG->prefix}report_users WHERE reportid='".$reportid."'");
		if($deleterecord2){
?>
			<script language="javascript">
				window.alert("Delete successful.");
				window.location.href = '<?=$CFG->wwwroot. "/examcenter/myreport.php";?>'; 
			</script>
<?php		
		}
	}
?>
