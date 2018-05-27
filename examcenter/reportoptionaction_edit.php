<?php
	require_once('../config.php');
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php');

	//Candidate Profile
	$organizationname=$_POST['organizationname'];
	$employeeid=$_POST['employeeid'];
	$candidateID=$_POST['candidateID'];
	$candidateFullname=$_POST['candidateFullname'];
	$candidateEmail=$_POST['candidateEmail'];
	$candidateAddress=$_POST['candidateAddress'];
	$candidateTel=$_POST['candidateTel'];
	$designation=$_POST['designation'];
	$department=$_POST['department'];
        $enrolstatus=$_POST['enrolstatus'];

	//candidate performance
  	echo $reportid=$_POST['reportid'];
	echo $sreport = $_POST['sreport'];	
	echo $curriculumname_candidate=$_POST['curriculumname_candidate'];
	echo $curriculumcode=$_POST['curriculumcode'];
	echo $statuscandidate=$_POST['statuscandidate'];
	echo $modulecompleted=$_POST['modulecompleted'];
	echo $totaltime=$_POST['totaltime'];
	echo $examinationstatus=$_POST['examinationstatus'];
	echo $markcandidate=$_POST['markcandidate'];
        $subscriptiondate=$_POST['subscriptiondate'];
        $expirydate=$_POST['expirydate'];
        $lastaccess=$_POST['lastaccess'];        

	//Examination Performance
	$cname_examination=$_POST['curriculumname_examination'];
	$ccode_examination=$_POST['curriculumcode_examination'];
	$cattemps=$_POST['curriculumattemps'];
	$learningoutcome=$_POST['learningoutcome'];
	$scoreonlearning=$_POST['scoreonlearning'];
	$passes=$_POST['passes'];
	$passrate=$_POST['passrate'];
	
	// Statistics
	$cname_statistics=$_POST['curriculumname_statistics'];
	$ccode_statistics=$_POST['curriculumcode_statistics'];
	$statusstistics=$_POST['statusstistics'];
	$mcomplete_statistics=$_POST['mcomplete_statistics'];
	$examstatus_statistics=$_POST['examstatus_statistics'];
	$totaltime_statistics=$_POST['totaltime_statistics'];
	
	//startdate&enddate
	$startdatepicker=$_POST['startdatepicker'];
	$enddatepicker=$_POST['enddatepicker'];
	
/* 	if($_POST['savebackhome']){
		//update record to DB
		$qcandidate=mysql_query("
			UPDATE {$CFG->prefix}report_option SET candidateID='".$candidateID."', candidateFullname='".$candidateFullname."', candidateEmail='".$candidateEmail."', candidateAddress='".$candidateAddress."', candidateTel='".$candidateTel."', curriculumname='".$curriculumname_candidate."', curriculumcode='".$curriculumcode."', performancestatus='".$statuscandidate."', modulecompleted='".$modulecompleted."', totaltimeperformance='".$totaltime."', examinationstatus='".$examinationstatus."', markperformance='".$markcandidate."', cnameexam='".$cname_examination."', ccodeexam='".$ccode_examination."', cattempts='".$cattemps."', learningoutcomes='".$learningoutcome."', scoreonlo='".$scoreonlearning."', passes='".$passes."', passrate='".$passrate."', cname_statistics='".$cname_statistics."', ccode_statistics='".$ccode_statistics."', statusstistics='".$statusstistics."', mcomplete_statistics='".$mcomplete_statistics."', examstatus_statistics='".$examstatus_statistics."', totaltime_statistics='".$totaltime_statistics."', reportid='".$reportid."', tlstartdate='".$startdatepicker."', tlenddate='".$enddatepicker."' WHERE reportid='".$reportid."'
		");
		if($qcandidate){	
			//redirect to myreport home	
			$linkto=$CFG->wwwroot. '/examcenter/myreport.php';
			header('Location: '.$linkto);
		}
	} */
	
	//if($_POST['unsaveshow']){
		//save record to DB 
		$qcandidate=mysql_query("
			UPDATE {$CFG->prefix}report_option SET organizationname='".$organizationname."', employeeid='".$employeeid."', department='".$department."', enrolstatus='".$enrolstatus."', designation='".$designation."', candidateID='".$candidateID."', candidateFullname='".$candidateFullname."', candidateEmail='".$candidateEmail."', candidateAddress='".$candidateAddress."', candidateTel='".$candidateTel."', curriculumname='".$curriculumname_candidate."', curriculumcode='".$curriculumcode."', performancestatus='".$statuscandidate."', modulecompleted='".$modulecompleted."', totaltimeperformance='".$totaltime."', examinationstatus='".$examinationstatus."', markperformance='".$markcandidate."', subscriptiondate='".$subscriptiondate."', expirydate='".$expirydate."', lastaccess='".$lastaccess."', cnameexam='".$cname_examination."', ccodeexam='".$ccode_examination."', cattempts='".$cattemps."', learningoutcomes='".$learningoutcome."', scoreonlo='".$scoreonlearning."', passes='".$passes."', passrate='".$passrate."', cname_statistics='".$cname_statistics."', ccode_statistics='".$ccode_statistics."', statusstistics='".$statusstistics."', mcomplete_statistics='".$mcomplete_statistics."', examstatus_statistics='".$examstatus_statistics."', totaltime_statistics='".$totaltime_statistics."', reportid='".$reportid."', tlstartdate='".$startdatepicker."', tlenddate='".$enddatepicker."' WHERE reportid='".$reportid."'
		");		
		if($qcandidate){	
			//redirect to viewreport	
			$linkto=$CFG->wwwroot. '/examcenter/reportview.php?id='.$reportid.'&sid='.$sreport;
			header('Location: '.$linkto);
		}
	//}
	
/* 	if($_POST['saveshow']){ 
		//save record to DB 
		$qcandidate=mysql_query("
			UPDATE {$CFG->prefix}report_option SET candidateID='".$candidateID."', candidateFullname='".$candidateFullname."', candidateEmail='".$candidateEmail."', candidateAddress='".$candidateAddress."', candidateTel='".$candidateTel."', curriculumname='".$curriculumname_candidate."', curriculumcode='".$curriculumcode."', performancestatus='".$statuscandidate."', modulecompleted='".$modulecompleted."', totaltimeperformance='".$totaltime."', examinationstatus='".$examinationstatus."', markperformance='".$markcandidate."', cnameexam='".$cname_examination."', ccodeexam='".$ccode_examination."', cattempts='".$cattemps."', learningoutcomes='".$learningoutcome."', scoreonlo='".$scoreonlearning."', passes='".$passes."', passrate='".$passrate."', cname_statistics='".$cname_statistics."', ccode_statistics='".$ccode_statistics."', statusstistics='".$statusstistics."', mcomplete_statistics='".$mcomplete_statistics."', examstatus_statistics='".$examstatus_statistics."', totaltime_statistics='".$totaltime_statistics."', reportid='".$reportid."', tlstartdate='".$startdatepicker."', tlenddate='".$enddatepicker."' WHERE reportid='".$reportid."'
		");
		if($qcandidate){	
			//redirect to view-report
			$linkto=$CFG->wwwroot. '/examcenter/reportview.php?id='.$reportid.'&sid='.$sreport;
			header('Location: '.$linkto);
		}		
	} */				 
?> 