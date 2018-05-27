<?php
	//to check if user already added		
	$s=mysql_query("SELECT id, access_token, traineeid FROM mdl_cifauser WHERE access_token='".$trimmed."'");
	$srow=mysql_num_rows($s);
	echo $examid;
	echo '<br/> Bil.. '.$srow;
	echo '<br/>'.$examtokenid;
	echo '<br/>'.$cosid;

	//kalu ada pengguna dengan access_token
	if($srow != '0'){
		$sget=mysql_fetch_array($s);
		$today = strtotime('now');
		echo '<br/>User ID : '.$sget['id'];

		/* $sqlexam=mysql_query("SELECT * FROM mdl_cifaquiz WHERE course='".$examid."'");
		$examcourseid=mysql_fetch_array($sqlexam);
		echo $courseid=$examcourseid['id']; */		
		if($cosid=='12'){
			$sqlqueryquiz=mysql_query("SELECT * FROM mdl_cifaquiz WHERE course='12'");  //COURSEID SINI//60@12
			$squiz12=mysql_fetch_array($sqlqueryquiz);
			$quiz=$squiz12['id'];	
		}else{
			$sqlqueryquiz=mysql_query("SELECT * FROM mdl_cifaquiz WHERE course='60'");  //COURSEID SINI//60@12
			$squiz12=mysql_fetch_array($sqlqueryquiz);
			$quiz=$squiz12['id'];		
		}	
		
		$sqlquery=mysql_query("SELECT id, uniqueid, userid FROM mdl_cifaquiz_attempts ORDER BY uniqueid DESC");
		$sq=mysql_fetch_array($sqlquery);
		$uniqueid1=$sq['uniqueid'];
		
		//echo '<br/>'.$uniqueid1;
		
		$sql=mysql_query("SELECT uniqueid, userid FROM mdl_cifaquiz_attempts WHERE userid='".$sget['id']."' AND uniqueid!='".$uniqueid1."'");
		$q=mysql_num_rows($sql);
		if($q!='0'){ 
			$uniqueid2=$uniqueid1+1; 
		}else{
			$sqlquery3=mysql_query("SELECT id, uniqueid, userid FROM mdl_cifaquiz_attempts ORDER BY uniqueid DESC");
			$sq3=mysql_fetch_array($sqlquery3);
			$uniqueid3=$sq3['uniqueid'];
			$uniqueid2=$uniqueid3+1; 
		}
		
		//to check if user already added
		$scount=mysql_query("SELECT * FROM mdl_cifagrade_grades WHERE (itemid='17' OR itemid='9') AND userid='".$sget['id']."'");
		$count=mysql_num_rows($scount);
		//echo '<br/>'.$count;
		if($count!='0'){
			$sqlGI=mysql_query("UPDATE mdl_cifagrade_grades 
			SET rawgrade='".$finalgrade."', finalgrade='".$finalgrade."', timecreated='".$timecreated."', timemodified='".$timemodified."'
			WHERE itemid='17' AND userid='".$sget['id']."'");
			if($sqlGI){
			$sqlG2=mysql_query("UPDATE mdl_cifagrade_grades 
			SET rawgrade=NULL, finalgrade='".$finalgrade."', timecreated='".$timecreated."', timemodified='".$timemodified."'
			WHERE itemid='9' AND userid='".$sget['id']."'");	
			}
		}else{
			$sqlGI=mysql_query("INSERT INTO mdl_cifagrade_grades 
			SET itemid='17', userid='".$sget['id']."', rawgrade='".$finalgrade."', finalgrade='".$finalgrade."', timecreated='".$timecreated."', timemodified='".$timemodified."'");
			if($sqlGI){
			$sqlG2=mysql_query("INSERT INTO  mdl_cifagrade_grades 
			SET rawgrade=NULL, itemid='9', userid='".$sget['id']."', finalgrade='".$finalgrade."', timecreated='".$timecreated."', timemodified='".$timemodified."'");
			}			
		}
		
		//to check if user already added
		$skira=mysql_query("SELECT * FROM mdl_cifaquiz_attempts WHERE quiz='".$quiz."' AND userid='".$sget['id']."'");
		$kira=mysql_num_rows($skira);	
		if($kira!='0'){
			$sqlI=mysql_query("UPDATE mdl_cifaquiz_attempts SET sumgrades='".$sumgrades."', timemodified='".$timemodified."' WHERE quiz='".$quiz."' AND userid='".$sget['id']."'");			
		}else{
			$sqlI=mysql_query("INSERT INTO mdl_cifaquiz_attempts(uniqueid, quiz, userid, attempt, sumgrades, timestart, timefinish, timemodified, layout, preview, needsupgradetonewqe) 
			VALUES ('".$uniqueid2."', '".$quiz."', '".$sget['id']."', '1', '".$sumgrades."', '".$timestart."', '".$timefinish."', '".$timemodified."', '', '".$preview."','".$needsupgradetonewqe."')");
		}
		if($sqlI){			

			//to check if user already added
			$suc=mysql_query("SELECT * FROM mdl_cifaquiz_grades WHERE quiz='".$quiz."' AND userid='".$sget['id']."'");
			$sc=mysql_num_rows($suc);
			//if tak sama 0
			//echo '<br/>'.$sc;
			if($sc!='0'){		
				$sup=mysql_query("UPDATE mdl_cifaquiz_grades SET grade='".$finalgrade."', timemodified='".$today."' WHERE quiz='".$quiz."' AND userid='".$sget['id']."'");
			}else{
				$sqlInsert=mysql_query("INSERT INTO mdl_cifaquiz_grades SET quiz='".$quiz."', userid='".$sget['id']."', grade='".$finalgrade."', timemodified='".$today."'");
				if($sqlInsert){
					//enrol user to online base systems
					if($cosid=='12'){
						$swhere="mdl_cifaenrol b, mdl_cifauser c, mdl_cifacourse d Where d.id = b.courseid And (c.id = '".$sget['id']."' And b.courseid = '12' And b.enrol = 'manual')";
					}else{
						$swhere="mdl_cifaenrol b, mdl_cifauser c, mdl_cifacourse d Where d.id = b.courseid And (c.id = '".$sget['id']."' And b.courseid = '60' And b.enrol = 'manual')";
					}				
					$sql=mysql_query("Select *, b.id As enrolid, c.id As userid From {$swhere}");		
					$queryuser=mysql_fetch_array($sql);
					$userid=$queryuser['userid'];
					
					// UPDATE Token expiry
					$updatetoken=mysql_query("UPDATE mdl_cifauser_enrolments SET timeend='".$today."' WHERE enrolid='".$queryuser['enrolid']."' AND userid='".$userid."'");
					$updatetokenexpiry=mysql_query("UPDATE mdl_cifauser_accesstoken SET tokenexpiry='".$today."' WHERE courseid='".$cosid."' AND userid='".$userid."'");
					
					$sqlInsert=mysql_query("INSERT INTO mdl_cifauser_enrolments 
											SET enrolid='".$queryuser['enrolid']."', userid='".$userid."',
											timecreated='".$today."', timemodified='".$today."', timeend='".$today."',
											modifierid='2', emailsent='1'");	
											
					$sqlassign=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='5', contextid='19', userid='".$sget['id']."', modifierid='2', timemodified='".$today."'");			
				
					
				}
			}	

		
		//to check if user already added
		$skira=mysql_query("SELECT * FROM mdl_cifaexam_grade WHERE userid='".$sget['id']."'");
		$kira=mysql_num_rows($skira);	
		echo '<br/>'.$kira;
		if($kira!='0'){
			$sqlII=mysql_query("UPDATE mdl_cifaexam_grade SET totalanswer='".$totalanswer."', finalgrade='".$finalgrade."' WHERE userid='".$sget['id']."'");			
		}else{
			$sqlII=mysql_query("INSERT INTO mdl_cifaexam_grade(userid, traineeid, examid, totalanswer, totalcorrectanswer, finalgrade, examtokenid) 
			VALUES ('".$sget['id']."', '".$sget['traineeid']."', '".$quiz."', '".$totalanswer."', '".$totalcorrectanswer."', '".$finalgrade."', '".$examtokenid."')");
		}
		if($sqlII){
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
		}
		}
	}
?>