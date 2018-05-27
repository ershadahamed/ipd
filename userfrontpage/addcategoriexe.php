<?php
	include_once('../manualdbconfig.php');
	$sqlCategory="INSERT INTO mdl_cifauser_category
	SET categorycode='".$_POST['categorycode']."', categoryname='".$_POST['categoryname']."'";
	$catQuery=mysql_query($sqlCategory);
	if($catQuery){
		//echo 'Yay';
		header('Location:useraddcategory.php');
	}else{
		echo 'noooo';
	}
?>