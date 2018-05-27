<?php
	include('../manualdbconfig.php');
	
	$id=$_POST['id'];
	$categorycode=$_POST['categorycode'];
	$categoryname=$_POST['categoryname'];
	
	$sqlEdit=mysql_query("UPDATE mdl_cifauser_category SET categorycode='".$categorycode."', categoryname='".$categoryname."' WHERE id='".$id."'");
	if($sqlEdit != 1){
		echo 'record not update';
	}else{
		echo 'record update';
		header('Location:useraddcategory.php');
	}

?>