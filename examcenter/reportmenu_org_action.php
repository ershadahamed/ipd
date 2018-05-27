<?php
	require_once('../config.php');
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php');
	
	
	$selectreport=$_POST['selectreport'];
	$reportname=$_POST['reportnametext'];
	$name_radio1=$_POST['name_radio1'];
	$today=strtotime('now');
	
	// insert into mdl_cifareport_menu
	$qmenureport=mysql_query("INSERT INTO {$CFG->prefix}report_menu(selectedreport, reportname, usergroup, timecreated, reportcreator) VALUES('".$selectreport."', '".$reportname."', '".$name_radio1."', '".$today."', '".$USER->id."')");
	$menureportid=mysql_insert_id();	
	
	// echo $_POST['myField'];
	$x=explode(',', $_POST['myField']);
	$i='0';
	foreach ($x as $key => $number) {
		$ss=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE orgtype='".$number[$i]."'");
		while($su=mysql_fetch_array($ss)){
			$candidateids=$su['id'];echo '<br/>';
			
			
			//to get a role name
			$squery=mysql_query("SELECT name FROM {$CFG->prefix}role WHERE id='5'");
			$sqlrole=mysql_fetch_array($squery);
			$usertypename=$sqlrole['name'];			
			
			/*$statement="
			  mdl_cifacourse a Inner Join
			  mdl_cifaenrol b On a.id = b.courseid Inner Join
			  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
			  mdl_cifauser d On c.userid = d.id Inner Join
			  mdl_cifauser_accesstoken e On b.courseid = e.courseid And e.userid = d.id	
			";*/
			
			$statement="
			  mdl_cifacourse a Inner Join
			  mdl_cifaenrol b On a.id = b.courseid Inner Join
			  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
			  mdl_cifauser d On c.userid = d.id
			";			
			
			$statement.=" WHERE a.category = '9' AND d.usertype='".$usertypename."' And d.id='".$candidateids."'";
			$sql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";			
			
			$result=mysql_query($sql);
			if(mysql_num_rows($result)!='0'){
				$data=mysql_fetch_array($result);	
				$candidateid=$data['userid'];
				$firstname=$data['firstname'];
				$lastname=$data['lastname'];
				$dob=$data['dob'];
				$organization=$data['orgtype'];
				
				// insert into mdl_cifareport_users
				$qryi = "INSERT INTO {$CFG->prefix}report_users(reportid, usergroup, candidateid, firstname, lastname, dob, organization) 
				VALUES('".$menureportid."','".$name_radio1."', '".$candidateid."', '".$firstname."', '".$lastname."', '".$dob."', '".$organization."')";
				$qreportgroup=mysql_query($qryi);				
			}			
			
		}
	}
	// echo $reportname.'-'.$selectreport.'-'.$_POST['result1'];
	$linkto=$CFG->wwwroot. '/examcenter/reportingoption.php?id='.$menureportid.'&sreport='.$selectreport.'&rname='.$reportname;
	//header('Location: '.$linkto);
redirect($linkto);
?>

<?php /*
	require_once('../config.php');
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php');

	if($_POST['checktoken'] != ""){
		$checkBox = $_POST['checktoken'];	
		$selectreport=$_POST['selectreport'];
		$reportname=$_POST['reportnametext'];
		$today=strtotime('now');
		
		// insert into mdl_cifareport_menu
		$qmenureport=mysql_query("INSERT INTO {$CFG->prefix}report_menu(selectedreport, reportname, timecreated, reportcreator) VALUES('".$selectreport."', '".$reportname."', '".$today."', '".$USER->id."')");
		$menureportid=mysql_insert_id();
		
		for($i=0; $i<sizeof($checkBox); $i++){
			//to get a role name
			$squery=mysql_query("SELECT name FROM {$CFG->prefix}role WHERE id='5'");
			$sqlrole=mysql_fetch_array($squery);
			$usertypename=$sqlrole['name'];			
			
			$statement="
			  mdl_cifacourse a Inner Join
			  mdl_cifaenrol b On a.id = b.courseid Inner Join
			  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
			  mdl_cifauser d On c.userid = d.id Inner Join
			  mdl_cifauser_accesstoken e On b.courseid = e.courseid And e.userid = d.id	
			";
			
			$statement.=" WHERE a.category = '3' AND d.usertype='".$usertypename."' And e.id='".$checkBox[$i]."'";
			$sql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";			
			
			$result=mysql_query($sql);
			if(mysql_num_rows($result)!='0'){
				$data=mysql_fetch_array($result);	
				$candidateid=$data['userid'];
				$firstname=$data['firstname'];
				$lastname=$data['lastname'];
				$dob=$data['dob'];
				$organization=$data['orgtype'];
				
				// insert into mdl_cifareport_users
				$qreportgroup=mysql_query("INSERT INTO {$CFG->prefix}report_users(reportid, usergroup, candidateid, firstname, lastname, dob, organization) 
				VALUES('".$menureportid."','', '".$candidateid."', '".$firstname."', '".$lastname."', '".$dob."', '".$organization."')");				
			}
		}	
		$linkto=$CFG->wwwroot. '/examcenter/reportingoption.php?id='.$menureportid.'&sreport='.$selectreport.'&rname='.$reportname;
		header('Location: '.$linkto);		
	}*/  
?> 