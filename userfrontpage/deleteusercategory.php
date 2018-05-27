<?php
	require_once('../config.php');
	echo '<style type="text/css">';
		include('../css/style.css'); 
		include('../css/style3.css');
	echo '</style>';
	
	include('../header2.php');
	include('../nav.php');
?>

<?php
	include('../manualdbconfig.php');
	
	$id=$_GET['id'];
	
	$SqlDelete=mysql_query("DELETE FROM mdl_cifauser_category WHERE id='".$id."'");
	if($SqlDelete){
		echo 'Record successful delete from system.';
		header('Location:../cifa/userfrontpage/useraddcategory.php');
	}else{
		echo 'Cannot delete the records. Try agains.';
	}
//add aa
	include('../footer3.php');
?>