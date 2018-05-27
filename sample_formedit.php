<?php
    require_once('config.php');
	require_once('manualdbconfig.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
 
 	//$currentdate = strtotime('now');
	$selectgetuser=mysql_query("
		Select
		  b.customerid,
		  a.candidateid,
		  a.traineeid,
		  a.name,
		  a.email,
		  b.date,
		  c.productid,
		  c.price
		From
		  mdl_cifacandidates a Inner Join
		  mdl_cifaorders b On a.serial = b.customerid Inner Join
		  mdl_cifaorder_detail c On b.serial = c.orderid
		Where
		  a.candidateid = '46'
	");
	while($sgetuser=mysql_fetch_array($selectgetuser)){
		$getcourseid=$sgetuser['productid'];
		
		echo 'manual enrol users. <br/>'.$getcourseid.'<br/>';
		
		$senroluser=mysql_query("Select * From mdl_cifaenrol Where enrol = 'manual' And courseid='".$getcourseid."' And status='0'");
		$qenroluser=mysql_fetch_array($senroluser);
		$getenrolid=$qenroluser['id'];
		$gotuser=$sgetuser['candidateid'];
		
		echo $getenrolid.'****** '.$gotuser.'<br/>';
		
		//to check if user never enrol for this course
		$scuser=mysql_query("SELECT * FROM mdl_cifauser_enrolments WHERE enrolid='".$getenrolid."' AND userid='".$gotuser."'");
		$ucount=mysql_num_rows($scuser);
		
		echo $ucount.'<br/>';
		if($ucount=='0'){
			$today = strtotime('now');
			$sqlInsert=mysql_query("INSERT INTO mdl_cifauser_enrolments 
									SET enrolid='".$getenrolid."', userid='".$gotuser."',
									timecreated='".$today."', timemodified='".$today."',
									modifierid='2', emailsent='1', timestart='".$timestart."', timeend='".$timeend."'");

			//to define contextid
			$sL=mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='".$getcourseid."'");
			$L=mysql_fetch_array($sL);
			$contextid=$L['id'];
			
			$sqlassign=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='5', contextid='".$contextid."', userid='".$gotuser."', modifierid='2', timemodified='".$today."'");								
		}
	}
?>	