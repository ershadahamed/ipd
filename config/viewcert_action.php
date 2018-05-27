<?php
    require_once('../config.php');
	include('../manualdbconfig.php'); 
	
	$permission = $_POST['permission'];
		
	for($i=0; $i<sizeof($permission); $i++){	
		$show = explode(";", $permission[$i]);
		$selectionid=$show['0'];  	// selection value
		$orgid=$show['1'];			// organization type id
		
		$orgsql=mysql_query("Select name FROM {$CFG->prefix}organization_type WHERE id='".$orgid."'");
		$orgvalue=mysql_fetch_array($orgsql);
		// echo $orgvalue['name'];
		
		$updateorgsql=mysql_query("UPDATE {$CFG->prefix}organization_type SET viewcert='".$selectionid."' WHERE id='".$orgid."'");
		
		$url=$CFG->wwwroot. "/config/viewcertconfig.php?updated=1";
?>
		<script language="javascript">
			window.alert("<?=get_string('configurationupdate');?>");
			window.location.href = '<?=$url;?>'; 
		</script>			
<?php } ?>