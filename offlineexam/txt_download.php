<?php
    header('Content-type: text/plain');
	//$qrty="";
	$sql=mysql_query("SELECT * FROM mdl_cifauser_accesstoken WHERE userid='".$qtoken->id."'");
	$rs=mysql_fetch_array($sql);
	$tokenid=$rs['user_accesstoken'];
	echo "username='".$tokenid."'";
	//echo "password=abc";

	header('Content-Disposition: attachment; filename="default-filename.txt"');
?>