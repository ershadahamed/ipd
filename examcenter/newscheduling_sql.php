<?php
	include('../config.php');
	include('../manualdbconfig.php');
	
		if($_POST['radio'] ==""){
			$url2=$CFG->wwwroot. '/examcenter/newscheduling.php?id='.$USER->id.'&rid='.$_GET['rid'];
?>
			<script language="javascript">
				window.alert("Please select scheduling to proceed.");
				window.location.href = '<?=$url2;?>'; 
			</script>
<?php			
		}
		
		if($_POST['checktoken'] != ""){
			if($_POST['radio']=='weekly'){
				$a=$_POST['recipientweekly'];
			}else if($_POST['radio']=='monthly'){
				$a=$_POST['recipientmonthly'];
			}else{
				$a=$_POST['daily'];
			}
			
			$startdatepicker=$_POST['startdatepicker'];
			$enddatepicker=$_POST['enddatepicker'];			
			
			$sureportoption=mysql_query("UPDATE {$CFG->prefix}report_option SET tlstartdate='".$startdatepicker."', tlenddate='".$enddatepicker."' WHERE reportid='".$_GET['rid']."'");
			
			$schedule=mysql_query("INSERT INTO mdl_cifareport_scheduling(rid, scheduling, scheduling_value) VALUE('".$_GET['rid']."', '".$_POST['radio']."', '".$a."')");
			$scheduleid=mysql_insert_id();
				
			$checkBox = $_POST['checktoken'];
			for($i=0; $i<sizeof($checkBox); $i++){
				$recipient=$checkBox[$i];
				$rcp=mysql_query("INSERT INTO mdl_cifareport_recipient(scheduling_id, recipient_id) VALUE('".$scheduleid."', '".$recipient."')");
			}
		}
		
		$url=$CFG->wwwroot. '/examcenter/schedulling.php?id=119&rid='.$_GET['rid'];
		
?>
	<script language="javascript">
		window.alert("Schedule has been updated.");
		window.location.href = '<?=$url;?>'; 
	</script>