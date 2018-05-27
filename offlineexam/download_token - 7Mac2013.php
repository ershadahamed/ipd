<?php
include_once('../manualdbconfig.php');   
   header('Content-type: text/plain');

	//$qrty=""; mdl_cifauser_accesstoken a, mdl_cifauser b Where a.userid = b.id
	$sql=mysql_query("SELECT * FROM mdl_cifauser_accesstoken a, mdl_cifauser b WHERE a.userid = b.id AND a.userid='".$_GET['tokenid']."'");
	$rs=mysql_fetch_array($sql);
	$tokenid=$rs['user_accesstoken'];
	$username=$rs['username'];

	echo "username=";
	echo $rs['traineeid'];	
	//echo $username;
	//echo $tokenid;
	echo "\r\n\n\n\n\n";
	echo "firstname=";
	echo $rs['firstname'];
	echo "\r\n\n\n\n\n";
	echo "lastname=";
	echo $rs['lastname'];
	echo "\r\n\n\n\n\n";
	echo "email=";
	echo $rs['email'];
	echo "\r\n\n\n\n\n";	
	echo "traineeid=";
	echo $rs['traineeid'];
	echo "\r\n\n\n\n\n";
	echo "country=";
	echo $rs['country'];
	echo "\r\n\n\n\n\n";
	echo "city=";
	echo $rs['city'];
	echo "\r\n\n\n\n\n";	
	echo "courseid=";
	echo $rs['courseid'];
	echo "\r\n\n\n\n\n";
	echo "accesstoken=";
	echo $tokenid;
	echo "\r\n\n\n\n\n";	

	
	header('Content-Disposition: attachment; filename="default-filename.txt"');
?>