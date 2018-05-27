<?php
	//to check if user already added	
	$s=mysql_query("SELECT id, access_token FROM mdl_cifauser WHERE access_token='".$examtokenid."'");
	$srow=mysql_num_rows($s);
	//echo '<br/> Bil.. '.$srow;
	//echo '<br/>'.$tokenid;
	//kalu ada pengguna dengan access_token
	if($srow != '0'){
		$sget=mysql_fetch_array($s);
		
		echo '<br/>User ID : '.$sget['id'];



			//to check if user already added
			$today = strtotime('now');
			$suc=mysql_query("SELECT * FROM mdl_cifaquiz_grades WHERE quiz='".$examid."' AND userid='".$sget['id']."'");
			$sc=mysql_num_rows($suc);
			//if tak sama 0
			//echo '<br/>'.$sc;
			if($sc!='0'){		
				$sup=mysql_query("UPDATE mdl_cifaquiz_grades SET grade='".$finalgrade."', timemodified='".$today."' WHERE quiz='".$examid."' AND userid='".$sget['id']."'");
			}else{
				$sqlInsert=mysql_query("INSERT INTO mdl_cifaquiz_grades SET quiz='".$examid."', userid='".$sget['id']."', grade='".$finalgrade."', timemodified='".$today."'");
				if($sqlInsert){
					//enrol user to online base systems
					$swhere="mdl_cifaenrol b, mdl_cifauser c, mdl_cifacourse d Where d.id = b.courseid And (c.id = '".$sget['id']."' And b.courseid = '12' And b.enrol = 'manual')";
					$sql=mysql_query("Select *, b.id As enrolid, c.id As userid From {$swhere}");		
					$queryuser=mysql_fetch_array($sql);
					$userid=$queryuser['userid'];
		
					//$today = strtotime('now');
					/*$sqlInsert=mysql_query("INSERT INTO mdl_cifauser_enrolments 
											SET enrolid='".$queryuser['enrolid']."', userid='".$userid."',
											timecreated='".$today."', timemodified='".$today."',
											modifierid='2', emailsent='1'");	
											
					$sqlassign=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='5', contextid='19', userid='".$sget['id']."', modifierid='2', timemodified='".$today."'");*/				
				}
			}	

		
		//to check if user already added
		$skira=mysql_query("SELECT * FROM mdl_cifaexam_grade WHERE userid='".$sget['id']."'");
		$kira=mysql_num_rows($skira);	
		echo '<br/>'.$kira;
		if($kira!='0'){
			$sqlI=mysql_query("UPDATE mdl_cifaexam_grade SET totalanswer='".$totalanswer."', finalgrade='".$finalgrade."' WHERE userid='".$sget['id']."'");			
		}else{
			$sqlI=mysql_query("INSERT INTO mdl_cifaexam_grade(userid, examid, totalanswer, totalcorrectanswer, finalgrade, examtokenid) 
			VALUES ('".$sget['id']."', '".$examid."', '".$totalanswer."', '".$totalcorrectanswer."', '".$finalgrade."', '".$examtokenid."')");
		}
		/*if($sqlI){
		?>
			<script language="javascript">
				window.alert("Uploaded Successfully!");
				window.location = "upload_software.php";
			</script>
		<?php } else { ?>
			<script language="javascript">
				window.alert("Upload not success. Please try again.");
				window.location = "upload_software.php";
			</script>		
		<?php
		}*/	
	}
?>