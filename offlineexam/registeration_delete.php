<?php
include('../config.php');
include('../manualdbconfig.php');

$accesstoken=$_GET['access_token'];

$sqlupdate=mysql_query("UPDATE {$CFG->prefix}user SET access_token='' WHERE access_token='".$accesstoken."'");
if($sqlupdate){
	$sqldel=mysql_query("DELETE FROM {$CFG->prefix}user_accesstoken WHERE user_accesstoken='".$accesstoken."'");
	if(!$sqldel){
	?>
		<script language="javascript">
			window.alert("Remove unsuccessfull!!");
		</script>
	<?php
		$errors=1;
		redirect($CFG->wwwroot. '/offlineexam/view_candidateslist.php?unsuccessful=0');
	}else{
	?>
		<script language="javascript">
			window.alert("File have been successfull remove!!");
		</script>
	<?php
		$errors=1;
		redirect($CFG->wwwroot. '/offlineexam/view_candidateslist.php?success=1');
	}
}
?>