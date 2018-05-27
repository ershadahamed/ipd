<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
?>
<h2>Recipient List</h2>

<?php	
	$statement="
	  mdl_cifareport_scheduling a Inner Join
	  mdl_cifareport_recipient b On a.id = b.scheduling_id Inner Join
	  mdl_cifauser c On b.recipient_id = c.id Inner Join
	  mdl_cifareport_menu d On a.rid = d.id
	";
	
	$csql="SELECT * FROM {$statement} WHERE a.rid='".$_GET['id']."' AND a.scheduling='".$_GET['scheduling']."' AND b.scheduling_id='".$_GET['sid']."' ORDER BY a.rid ASC";
	$sqlquery=mysql_query($csql);	
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	
	while($sqlrow=mysql_fetch_array($sqlquery)){
		$linkto=$CFG->wwwroot. "/examcenter/progressreport.php?id=".$USER->id;
		$bil=$no++;
		$fullname=$sqlrow['firstname'].' '.$sqlrow['lastname'];
		echo $bil.') '.$fullname.', '.$sqlrow['email'].'<br/>';
	}	
?>