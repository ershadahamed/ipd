<?php
$my['host'] = "localhost";
			$my['user'] = "mylms_cifa";
			$my['pass'] = "Aay27?k2";
			$my['database'] = "ipdonline";

			$conn = mysql_connect($my['host'], $my['user'], $my['pass']);

			if(!$conn)
			{
				echo"Tidak dapat sambung ke MYSQL.<br/>"; 
				mysql_error();
			}
			mysql_select_db($my['database']) or die("Tiada database".mysql_error());
			
$bil='1';
$qry = "SELECT candidateid, orgtype FROM temp_adib_org_update";
$sql = mysql_query($qry);
while($rs = mysql_fetch_array($sql)){
	echo "<br>".$qry2 = "UPDATE mdl_cifauser SET orgtype='".$rs['orgtype']."' WHERE username='".$rs['candidateid']."'";
	echo ";";
	$sql2 = mysql_query($qry2);
$bil++;}
?>