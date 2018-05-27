<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	
	$title=$_POST['title'];
	$content=$_POST['content'];
	$timecreated=strtotime('now');
	$timeend=strtotime("+1 month");
			
	$qsimpan=mysql_query("INSERT INTO mdl_cifanews_update 
		SET title='".$title."', content='".$content."', timecreated='".$timecreated."', timeend='".$timeend."'
	");				
			if($qsimpan){ 
?>
				<script type="text/javascript">
				window.alert('Success. Thank you')
				window.location.href = '<?=$CFG->wwwroot. "/news_update/list_ofnews_update.php";?>';   
				</script>	
<?php					
			}else{
				echo 'Failed. Thank you.<br />';
?>
				<script type="text/javascript">
				window.alert('Registration Fail. Thank you')  
				</script>	
<?php				
			}
?>