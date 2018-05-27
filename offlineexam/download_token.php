<?php
	require_once('../config.php');
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php');

	$filename="ePay";
	$csv_filename = clean_filename($filename.'-'.date('Ymd').'-'.time('now').'.csv');

	header("Content-Type: application/vnd.ms-excel");

	$sql = "SELECT * FROM mdl_cifauser_accesstoken a, mdl_cifauser b WHERE a.userid = b.id AND a.userid='".$_GET['tokenid']."'";	
	$result=mysql_query($sql);
	if(mysql_num_rows($result)>0){
		$fileContent="Username;Firstname;Lastname;Email;Traineeid;Country;City;Courseid;Accesstoken\n";
		while($data=mysql_fetch_array($result))
		{
			$fileContent.= "".$data['traineeid'].";".$data['firstname'].";".$data['lastname'].";".$data['email']."; ".$data['traineeid'].";".$data['country'].";".$data['city'].";".$data['courseid'].";".trim($data['user_accesstoken'])."";
		}

		$fileContent=str_replace("\n\n","\n",$fileContent);
		echo $fileContent;
	}
	header("content-disposition: attachment;filename=$csv_filename"); 
?> 