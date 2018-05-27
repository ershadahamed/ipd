<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	
	$inst_id=$_GET['id'];

	$qsimpan=mysql_query("
		UPDATE {$CFG->prefix}organization_type SET status='1' WHERE id='".$inst_id."'
	");	
	
	if($qsimpan){ 
		echo 'Delete success. Thank you.<br />';		
?>
		<script type="text/javascript">
		window.alert('Delete success. Thank you')
		window.location.href = '<?=$CFG->wwwroot. "/financialinstituition/list_ofregistration_admin.php";?>';   
		</script>	
<?php				
		
		
	}else{
		echo 'Registration Fail. Thank you.<br />';
?>
		<script type="text/javascript">
		window.alert('Delete Fail. Thank you')
		//window.location.href = '<?=$CFG->wwwroot. "/contactus/upload_index.php";?>';   
		</script>	
<?php				
	}
?>