	<style type="text/css">
	<?php require_once('button.css');?>
	</style>
<?php
	require_once('../manualdbconfig.php');
	
	$license=$_POST['license'];
	$centrecode=$_POST['centrecode'];
	$code=$_POST['centrecode1'];
	$centrename=$_POST['centreName'];
	$address=$_POST['address1'];
	$address2=$_POST['address2'];
	//$state=$_POST['state'];
	$city=$_POST['city'];
	$country=$_POST['country'];	
	//$zip=$_POST['zip'];
	$phone=$_POST['centreline'];
	$fax=$_POST['faxnum'];
	$mobile=$_POST['mobile'];
	$email=$_POST['email2'];
	
		$sql="INSERT INTO mdl_cifa_exam 
			  SET 
				license='$license',
				code='$code',
				centre_code='$centrecode',
				centre_name='$centrename', 
				address='$address',
				address2='$address2',
				city='$city', 
				phone='$phone', 
				fax='$fax', 
				mobile='$mobile', 
				email='$email',
				country='$country'";
		$query=mysql_query($sql);
	if($query){
		include('email-function.php');
		header('Location:addnewcenter.php?categoryedit=off');
		//include('form_centre_success.php');
	}else{
		echo"tidak berjaya";
		header('Location:../manage_exam_index.php?categoryedit=off');
	}
	//}
?>