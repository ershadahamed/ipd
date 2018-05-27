<?php
	require_once('../config.php');
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php');
	
	
	echo $selectreport=$_POST['selectreport'];
	echo $reportname=$_POST['reportnametext'];
	echo $name_radio1=$_POST['name_radio1'];
	$today=strtotime('now');
	
	// insert into mdl_cifareport_menu
	/*$qmenureport=mysql_query("INSERT INTO {$CFG->prefix}report_menu(selectedreport, reportname, usergroup, timecreated, reportcreator) VALUES('".$selectreport."', '".$reportname."', '".$name_radio1."', '".$today."', '".$USER->id."')");
	$menureportid=mysql_insert_id();*/	
	
		// Update mdl_cifareport_menu
		$qmenureport=mysql_query("UPDATE {$CFG->prefix}report_menu SET selectedreport='".$selectreport."', reportname='".$reportname."', usergroup='".$name_radio1."', timecreated='".$today."', reportcreator='".$USER->id."'
		WHERE id='".$_GET['id']."'");	
	
	// echo $_POST['myField'];
	$x=explode(',', $_POST['myField']);
	$i='0';
	foreach ($x as $key => $number) {
		// Delete users
		$s2=mysql_query("SELECT * FROM {$CFG->prefix}report_users WHERE reportid='".$_GET['id']."'");
		$sm2=mysql_fetch_array($s2);
		$ab=$sm2['candidateid'];
		if($ab){		
		$de=mysql_query("DELETE FROM {$CFG->prefix}report_users WHERE reportid='".$_GET['id']."' AND candidateid='".$ab."'");
		}
		
		$ss=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE orgtype='".$number[$i]."'");
		while($su=mysql_fetch_array($ss)){
			$candidateids=$su['id'];echo '<br/>';
			
			
			//to get a role name
			$squery=mysql_query("SELECT name FROM {$CFG->prefix}role WHERE id='5'");
			$sqlrole=mysql_fetch_array($squery);
			$usertypename=$sqlrole['name'];			
						
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
				
$s=mysql_query("SELECT * FROM {$CFG->prefix}report_users WHERE reportid='".$_GET['id']."' AND candidateid='".$candidateid."'");
				$sc=mysql_num_rows($s);
				if($sc!='0'){
					$qreportgroup=mysql_query("UPDATE {$CFG->prefix}report_users SET usergroup='".$name_radio1."', reportid='".$_GET['id']."', candidateid='".$candidateid."', firstname='".$firstname."', lastname='".$lastname."', dob='".$dob."', organization='".$organization."'
					WHERE reportid='".$_GET['id']."' AND candidateid='".$candidateid."'");
				}
				else if($sc!='1'){
					// insert into mdl_cifareport_users
					$qreportgroup2=mysql_query("INSERT INTO {$CFG->prefix}report_users(reportid, usergroup, candidateid, firstname, lastname, dob, organization) 
					VALUES('".$_GET['id']."','".$name_radio1."', '".$candidateid."', '".$firstname."', '".$lastname."', '".$dob."', '".$organization."')");				
				}				
				
				// insert into mdl_cifareport_users
				/*$qreportgroup=mysql_query("INSERT INTO {$CFG->prefix}report_users(reportid, usergroup, candidateid, firstname, lastname, dob, organization) 
				VALUES('".$menureportid."','".$name_radio1."', '".$candidateid."', '".$firstname."', '".$lastname."', '".$dob."', '".$organization."')");*/				
			}			
			
		}
	}
		// $linkto=$CFG->wwwroot. '/examcenter/myreport.php';
		$linkto=$CFG->wwwroot. '/examcenter/reportingoption_edit.php?id='.$USER->id.'&sreport='.$selectreport.'&rid='.$_GET['id'];
		header('Location: '.$linkto);	
?>