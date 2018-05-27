<?php 
mysql_connect('localhost','root','E9z0YmGGfXO1');
$qry = "SELECT timecreated, id from shapedblms.temp_enrol";
$sql = mysql_query($qry);
while($rs = mysql_fetch_array($sql)){
	$qry2 = "select timestart from shapedblms.mdl_cifauser_enrolments where id='".$rs['id']."'";
	$sql2 = mysql_query($qry2);
	$rs2 = mysql_fetch_array($sql2);
	if($rs2['timestart']=='0'){
	echo "<br>".$qry3 = "UPDATE shapedblms.mdl_cifauser_enrolments set timestart='".$rs['timecreated']."' WHERE id='".$rs['id']."'";
	$sql3 = mysql_query($qry3);
	}
}
?>