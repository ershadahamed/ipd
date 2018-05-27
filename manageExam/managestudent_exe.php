<?php
	include('../manualdbconfig.php');
	//courseid
	$id=$_POST['id'];
	$traineeid=$_POST['traineeid'];
	$payment=$_POST['payment'];	
	$todaytime=strtotime('now');
	
	$sql="UPDATE mdl_cifa_modulesubscribe SET payment_status='$payment', timemodified='".$todaytime."'
			WHERE courseid='$id' AND traineeid='".$traineeid."'";
	$query=mysql_query($sql);
	if($query){
		echo"data berjaya";
		header('Location:managestudent.php?categoryedit=off');
	}else{
		echo"tidak berjaya";
		header('Location:managestudent.php?categoryedit=off');
	}
?>