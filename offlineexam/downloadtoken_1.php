<?php
	require_once('../config.php');
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php');

	if($_POST['checktoken'] != ""){
	
		$checkBox = $_POST['checktoken'];
		for($i=0; $i<sizeof($checkBox); $i++){

		/* $statement="
			mdl_cifacourse a Inner Join
			mdl_cifaenrol b On a.id = b.courseid Inner Join
			mdl_cifauser_enrolments c On b.id = c.enrolid
		";
				
		$statement.=" WHERE a.category = '3' AND c.userid='".$checkBox[$i]."'";
		$csql="SELECT *, a.id as examid FROM {$statement}";
		$sqlquery=mysql_query($csql);	
		$sqlrow=mysql_fetch_array($sqlquery); */
		
/* 			//Insert data to user_accesstoken db table
			$access_token=uniqid(rand()); //create random number
			$timecreated = strtotime('now');
			$examid = $sqlrow['courseid'];
			
			$sqlInsert=mysql_query("UPDATE {$CFG->prefix}user_accesstoken 
			SET centerid='".$USER->id."', userid='".$checkBox[$i]."', user_accesstoken='".$access_token."', 
			timecreated_token='".$timecreated."' WHERE userid='".$checkBox[$i]."'"); */

			$filename="tokendownload";
			$csv_filename = clean_filename($filename.'-'.date('Ymd').'-'.time('now').'.csv');

			header("Content-Type: application/vnd.ms-excel");

			//$sql = "SELECT * FROM mdl_cifauser_accesstoken a, mdl_cifauser b WHERE a.userid = b.id AND a.userid='".$checkBox[$i]."'";	
			$sql = "Select * From mdl_cifauser a Inner Join mdl_cifauser_accesstoken b On a.id = b.userid Where a.id='".$checkBox[$i]."'";
			$result=mysql_query($sql);
			if(mysql_num_rows($result)>0){
				
				
			if($i < '1'){
				$fileContent="Username;Firstname;Lastname;Email;Traineeid;Country;City;Courseid;Accesstoken\n";
			}
			else{ $fileContent=""; }				
				$data=mysql_fetch_array($result);
				if($i < '0'){
				//while($data=mysql_fetch_array($result))
				//{
					$fileContent.= "".$data['traineeid'].";".$data['firstname'].";".$data['lastname'].";".$data['email']."; ".$data['traineeid'].";".$data['country'].";".$data['city'].";".$data['courseid'].";".trim($data['user_accesstoken'])."";
				//}
				}else{
					$fileContent.= "\n".$data['traineeid'].";".$data['firstname'].";".$data['lastname'].";".$data['email']."; ".$data['traineeid'].";".$data['country'].";".$data['city'].";".$data['courseid'].";".trim($data['user_accesstoken'])."";
				}
				$fileContent=str_replace("\n\n","\n",$fileContent);
				echo $fileContent;
			}
			header("content-disposition: attachment;filename=$csv_filename");
		}
	}else{
		echo "get a popup message and redirect to CIFA™ Examination Candidate Database page.";
	}	
?> 