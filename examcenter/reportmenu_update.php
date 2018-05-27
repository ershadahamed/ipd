<?php
	require_once('../config.php');
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php');
		
	$reportcandidateid=$_POST['reportcandidateid'];
	
	if($_POST['checktoken'] != ""){
		$checkBox = $_POST['checktoken'];	
		
		$selectreport=$_POST['selectreport'];
		$reportname=$_POST['reportnametext'];
		$nr=$_POST['nr'];
		$today=strtotime('now');
		
		// Delete uncheck users
		$s2=mysql_query("SELECT * FROM {$CFG->prefix}report_users WHERE reportid='".$_GET['id']."'");
		for($i=0; $i<sizeof($checkBox); $i++){
		// echo $checkBox[$i].'<br/>';
			while($sm2=mysql_fetch_array($s2)){
				$ab=$sm2['candidateid'];			
				if($ab!=$checkBox[$i]){ 
					// echo $ab.'<br/>';
					$de=mysql_query("DELETE FROM {$CFG->prefix}report_users WHERE reportid='".$_GET['id']."' AND candidateid='".$ab."'");
				}
			}
		} // End delete		
		
		// Update mdl_cifareport_menu
		$qmenureport=mysql_query("UPDATE {$CFG->prefix}report_menu SET selectedreport='".$selectreport."', reportname='".$reportname."', timecreated='".$today."', reportcreator='".$USER->id."'
		WHERE id='".$_GET['id']."'");
		
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
			
			$statement.=" WHERE a.category = '3' AND d.usertype='".$usertypename."' And d.id='".$checkBox[$i]."'";
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
				if($sc>0){
					$qreportgroup=mysql_query("UPDATE {$CFG->prefix}report_users SET reportid='".$_GET['id']."', candidateid='".$candidateid."', firstname='".$firstname."', lastname='".$lastname."', dob='".$dob."', organization='".$organization."'
					WHERE reportid='".$_GET['id']."' AND candidateid='".$candidateid."'");
				}
				else if($sc<1){
					// insert into mdl_cifareport_users
					$qreportgroup2=mysql_query("INSERT INTO {$CFG->prefix}report_users(reportid, usergroup, candidateid, firstname, lastname, dob, organization) 
					VALUES('".$_GET['id']."','".$_GET['nr']."', '".$candidateid."', '".$firstname."', '".$lastname."', '".$dob."', '".$organization."')");				
				}
			}
		}	
		// $linkto=$CFG->wwwroot. '/examcenter/myreport.php';
		$linkto=$CFG->wwwroot. '/examcenter/reportingoption_edit.php?id='.$USER->id.'&sreport='.$selectreport.'&rid='.$_GET['id'];
		header('Location: '.$linkto);		
	}
?> 