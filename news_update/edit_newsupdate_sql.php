<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	$output_dir = "logo/";
	
	$title=$_POST['title'];
	$content=$_POST['content'];
	$timemodified=strtotime("now");
	$timeend=strtotime("+1 month");
	$status=$_POST['status'];
	$news_id=$_POST['news_id'];
	
						
	$qsimpan=mysql_query("
		UPDATE {$CFG->prefix}news_update  
		SET title='".$title."', content='".$content."', timecreated='".$timemodified."', timeend='".$timeend."', status='".$status."'
		WHERE id='".$news_id."'
	");	
			
	if($qsimpan){ 
?>
		<script type="text/javascript">
		window.alert('Updating success. Thank you')
		window.location.href = '<?=$CFG->wwwroot. "/news_update/list_ofnews_update.php";?>';   
		</script>	
<?php				
	}else{
?>
		<script type="text/javascript">
		window.alert('Updating Fail. Thank you') 
		</script>	
<?php				
	}
?>