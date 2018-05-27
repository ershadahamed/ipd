<?php
	include('../manualdbconfig.php');
	$license=$_POST['license'];
	$centrename=$_POST['centreName'];
	$address=$_POST['address1'];
	$address2=$_POST['address2'];
	//$state=$_POST['state'];
	$city=$_POST['city'];
	//$zip=$_POST['zip'];
	$phone=$_POST['office'];
	$fax=$_POST['fax'];
	$mobile=$_POST['mobile'];
	$email=$_POST['email'];
	$id=$_POST['id'];
	$country=$_POST['country'];	
	
	$sql="UPDATE mdl_cifa_exam 
		  SET 
			centre_name='$centrename', 
			address='$address',
			address2='$address2',
			city='$city', 
			phone='$phone',
			license='$license', 
			fax='$fax', 
			mobile='$mobile', 
			email='$email',
			country='$country'
		  WHERE id='$id'";
	$query=mysql_query($sql);
	if($query){
		echo"data berjaya";
		header('Location:../manage_exam_index.php?categoryedit=off');
	}else{
		echo"tidak berjaya";
		header('Location:../manage_exam_index.php?categoryedit=off');
	}
?>