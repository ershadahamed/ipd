<?php

mysql_connect('localhost','root','E9z0YmGGfXO1');
$qry = "SELECT access_token, id from shapedblms.mdl_cifauser where email LIKE '%@adib.com'";
$sql = mysql_query($qry);
while($rs = mysql_fetch_array($sql)){ 
$str=0;
	echo "<br>".$str = strlen($rs['access_token']);
	if($str==4){
echo "=".$str2 = str_pad($rs['access_token'], 6, "0", STR_PAD_LEFT);
		echo "<br>".$qry2 = "UPDATE shapedblms.mdl_cifauser SET access_token='".$str2."' where id='".$rs['id']."'";
		$rs2 = mysql_query($qry2);
	}
}
?>
