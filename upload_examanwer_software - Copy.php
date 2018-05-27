<?php
function get_value_of($name)
{
	 $num='10';
	 for ($i = 1; $i <= $num; ++$i) { $array[] = $i; }
	 
	 $lines = file('exam_software.txt');
	 $lines2 = file('exam_software('.$i.').txt');
     if($lines){
		 foreach (array_values($lines) AS $line)
		 {
			list($key, $val) = explode('=', trim($line) );
			if (trim($key) == $name)
			  {
				return $val;
			  }
		 }
	 }else{
		 foreach (array_values($lines) AS $line)
		 {
			list($key, $val) = explode('=', trim($line) );
			if (trim($key) == $name)
			  {
				return $val;
			  }
		 }	 
	 }
     return false;
} 
	$quiz=get_value_of('quiz');
	$username=get_value_of('username');
	$grade=get_value_of('grade');
	$timemodified=get_value_of('timemodified');
	$tokenid=get_value_of('tokenid');
	
	$attempt=get_value_of('attempt');
	$sumgrades=get_value_of('sumgrades');
	$timestart=get_value_of('timestart');
	$timefinish=get_value_of('timefinish');
	$layout=get_value_of('layout');
	$preview=get_value_of('preview');
	$needsupgradetonewqe=get_value_of('needsupgradetonewqe');	
	
	$itemid=get_value_of('itemid');
	$userid=get_value_of('userid');
	$usermodified=get_value_of('usermodified');
	$finalgrade=get_value_of('finalgrade');
	$rawgrade=get_value_of('rawgrade');
	$timecreated=get_value_of('timecreated');
	
	//echo $quiz.'<br/>'.$username.'<br/>'.$grade.'<br/>'.$timemodified;
	//echo $uniqueid.'<br/>'.$attempt.'<br/>'.$sumgrades.'<br/>'.$timestart.'<br/>'.$timefinish.'<br/>'.$layout.'<br/>'.$preview.'<br/>'.$needsupgradetonewqe;
?>
<?php
	//to check if user already added	
	$s=mysql_query("SELECT id, access_token FROM mdl_cifauser WHERE access_token='".$tokenid."'");
	$srow=mysql_num_rows($s);
	echo '<br/> Bil.. '.$srow;
	echo '<br/>'.$tokenid;
	//kalu ada pengguna dengan access_token
	if($srow != '0'){
		$sget=mysql_fetch_array($s);
		echo '<br/>User ID : '.$sget['id'];
		
		$sqlquery=mysql_query("SELECT id, uniqueid, userid FROM mdl_cifaquiz_attempts ORDER BY uniqueid DESC");
		$sq=mysql_fetch_array($sqlquery);
		$uniqueid=$sq['uniqueid'];
		
		$sql=mysql_query("SELECT uniqueid, userid FROM mdl_cifaquiz_attempts WHERE userid='".$sget['id']."' AND uniqueid!='".$uniqueid."'");
		$q=mysql_num_rows($sql);
		if($q!='0'){ 
			$uniqueid2=$uniqueid+1; 
		}
		
		//to check if user already added
		$scount=mysql_query("SELECT * FROM mdl_cifagrade_grades WHERE (itemid='17' OR itemid='9') AND userid='".$sget['id']."'");
		$count=mysql_num_rows($scount);
		echo '<br/>'.$count;
		if($count!='0'){
			$sqlGI=mysql_query("UPDATE mdl_cifagrade_grades 
			SET rawgrade='".$rawgrade."', finalgrade='".$finalgrade."', timecreated='".$timecreated."', timemodified='".$timemodified."'
			WHERE itemid='17' AND userid='".$sget['id']."'");
			if($sqlGI){
			$sqlG2=mysql_query("UPDATE mdl_cifagrade_grades 
			SET rawgrade=NULL, finalgrade='".$finalgrade."', timecreated='".$timecreated."', timemodified='".$timemodified."'
			WHERE itemid='9' AND userid='".$sget['id']."'");	
			}
		}else{
			$sqlGI=mysql_query("INSERT INTO mdl_cifagrade_grades 
			SET itemid='17', userid='".$sget['id']."', rawgrade='".$rawgrade."', finalgrade='".$finalgrade."', timecreated='".$timecreated."', timemodified='".$timemodified."'");
			if($sqlGI){
			$sqlG2=mysql_query("INSERT INTO  mdl_cifagrade_grades 
			SET rawgrade=NULL, itemid='9', userid='".$sget['id']."', finalgrade='".$finalgrade."', timecreated='".$timecreated."', timemodified='".$timemodified."'");
			}			
		}
		
		//to check if user already added
		$skira=mysql_query("SELECT * FROM mdl_cifaquiz_attempts WHERE quiz='".$quiz."' AND userid='".$sget['id']."'");
		$kira=mysql_num_rows($skira);	
		echo '<br/>'.$kira;
		if($kira!='0'){
			$sqlI=mysql_query("UPDATE mdl_cifaquiz_attempts SET sumgrades='".$sumgrades."', timemodified='".$timemodified."' WHERE quiz='".$quiz."' AND userid='".$sget['id']."'");			
		}else{
			$sqlI=mysql_query("INSERT INTO mdl_cifaquiz_attempts(uniqueid, quiz, userid, attempt, sumgrades, timestart, timefinish, timemodified, layout, preview, needsupgradetonewqe) 
			VALUES ('".$uniqueid2."', '".$quiz."', '".$sget['id']."', '".$attempt."', '".$sumgrades."', '".$timestart."', '".$timefinish."', '".$timemodified."', '".$layout."', '".$preview."','".$needsupgradetonewqe."')");
		}
		
		if($sqlI){		
			//to check if user already added		
			$suc=mysql_query("SELECT * FROM mdl_cifaquiz_grades WHERE quiz='".$quiz."' AND userid='".$sget['id']."'");
			$sc=mysql_num_rows($suc);
			//if tak sama 0
			echo '<br/>'.$sc;
			if($sc!='0'){		
				$sup=mysql_query("UPDATE mdl_cifaquiz_grades SET grade='".$grade."', timemodified='".$timemodified."' WHERE quiz='".$quiz."' AND userid='".$sget['id']."'");
				if($sup){
				?>
					<script language="javascript">
						window.alert("Uploaded Successfully!");
						window.location = "upload_software.php";
					</script>
				<?php
				}else{
				?>
					<script language="javascript">
						window.alert("Upload not success. Please try again.");
						window.location = "upload_software.php";
					</script>
				<?php			
				}
			}else{
				$sqlInsert=mysql_query("INSERT INTO mdl_cifaquiz_grades SET quiz='".$quiz."', userid='".$sget['id']."', grade='".$grade."', timemodified='".$timemodified."'");
				if($sqlInsert){
					//enrol user to online base systems
					$swhere="mdl_cifaenrol b, mdl_cifauser c, mdl_cifacourse d Where d.id = b.courseid And (c.id = '".$sget['id']."' And b.courseid = '12' And b.enrol = 'manual')";
					$sql=mysql_query("Select *, b.id As enrolid, c.id As userid From {$swhere}");		
					$queryuser=mysql_fetch_array($sql);
					$userid=$queryuser['userid'];
		
					$today = strtotime('now');
					$sqlInsert=mysql_query("INSERT INTO mdl_cifauser_enrolments 
											SET enrolid='".$queryuser['enrolid']."', userid='".$userid."',
											timecreated='".$today."', timemodified='".$today."',
											modifierid='2', emailsent='1'");	
											
					$sqlassign=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='5', contextid='19', userid='".$sget['id']."', modifierid='2', timemodified='".$today."'");				
				?>
				<script language="javascript">
					window.alert("Uploaded Successfully!");
					window.location = "upload_software.php";
				</script>
			<?php
				}else{
				?>
				<script language="javascript">
					window.alert("Upload not success. Please try again.");
					window.location = "upload_software.php";
				</script>
			<?php			
				}
			}
		}
	}
?>