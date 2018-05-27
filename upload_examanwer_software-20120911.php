<?php
function get_value_of($name)
{
	$file='exam_software';
     //$lines = file($file);
	 $lines = file($file.'.txt');
     foreach (array_values($lines) AS $line)
     {
        list($key, $val) = explode('=', trim($line) );
        if (trim($key) == $name)
          {
            return $val;
          }
     }
     return false;
} 
	$quiz=get_value_of('quiz');
	$username=get_value_of('username');
	$grade=get_value_of('grade');
	$timemodified=get_value_of('timemodified');
	
	$uniqueid=get_value_of('uniqueid');
	$attempt=get_value_of('attempt');
	$sumgrades=get_value_of('sumgrades');
	$timestart=get_value_of('timestart');
	$timefinish=get_value_of('timefinish');
	$layout=get_value_of('layout');
	$preview=get_value_of('preview');
	$needsupgradetonewqe=get_value_of('needsupgradetonewqe');	
	
	
	echo $quiz.'<br/>'.$username.'<br/>'.$grade.'<br/>'.$timemodified;
	echo $uniqueid.'<br/>'.$attempt.'<br/>'.$sumgrades.'<br/>'.$timestart.'<br/>'.$timefinish.'<br/>'.$layout.'<br/>'.$preview.'<br/>'.$needsupgradetonewqe;
?>
<?php
	$s=mysql_query("SELECT id, access_token FROM mdl_cifauser WHERE access_token='".$username."'");
	$srow=mysql_num_rows($s);
	echo '<br/> Bil.. '.$srow;
	if($srow != '0'){
		$sget=mysql_fetch_array($s);
		echo '<br/>User ID : '.$sget['id'];
		//$sqlI=mysql_query("INSERT INTO mdl_cifaquiz_attempts SET uniqueid='".$uniqueid."', quiz='".$quiz."', userid='".$sget['id']."', attempt='".$attempt."', sumgrades='".$sumgrades."', timestart='".$timestart."', timefinish='".$timefinish."', timemodified='".$timemodified."', layout='".$layout."', preview='".$preview."', needsupgradetonewqe='".$needsupgradetonewqe."'");
		$sqlI=mysql_query("INSERT INTO mdl_cifaquiz_attempts(uniqueid, quiz, userid, attempt, sumgrades, timestart, timefinish, timemodified, layout, preview, needsupgradetonewqe) 
		VALUES ('".$uniqueid."', '".$quiz."', '".$sget['id']."', '".$attempt."', '".$sumgrades."', '".$timestart."', '".$timefinish."', '".$timemodified."', '".$layout."', '".$preview."','".$needsupgradetonewqe."')");
		
		if($sqlI){
			$sqlInsert=mysql_query("INSERT INTO mdl_cifaquiz_grades SET quiz='".$quiz."', userid='".$sget['id']."', grade='".$grade."', timemodified='".$timemodified."'");
			if($sqlInsert){
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
?>