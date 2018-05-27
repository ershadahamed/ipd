<?php

require_once('../config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/filelib.php');
include('../manualdbconfig.php');

//Candidate Profile
$organizationname = $_POST['organizationname'];
$employeeid = $_POST['employeeid'];
$candidateID = $_POST['candidateID'];
$candidateFullname = $_POST['candidateFullname'];
$candidateEmail = $_POST['candidateEmail'];
$candidateAddress = $_POST['candidateAddress'];
$candidateTel = $_POST['candidateTel'];
$department = $_POST['department'];
$designation = $_POST['designation'];
$enrolstatus = $_POST['enrolstatus'];

//candidate performance
$reportid = $_POST['reportid'];
$sreport = $_POST['sreport'];
$curriculumname_candidate = $_POST['curriculumname_candidate'];
$curriculumcode = $_POST['curriculumcode'];
$statuscandidate = $_POST['statuscandidate'];
$modulecompleted = $_POST['modulecompleted'];
$totaltime = $_POST['totaltime'];
$examinationstatus = $_POST['examinationstatus'];
$markcandidate = $_POST['markcandidate'];
$subscriptiondate = $_POST['subscriptiondate'];
$expirydate = $_POST['expirydate'];
$lastaccess = $_POST['lastaccess'];

//Examination Performance
$cname_examination = $_POST['curriculumname_examination'];
$ccode_examination = $_POST['curriculumcode_examination'];
$cattemps = $_POST['curriculumattemps'];
$learningoutcome = $_POST['learningoutcome'];
$scoreonlearning = $_POST['scoreonlearning'];
$passes = $_POST['passes'];
$passrate = $_POST['passrate'];

// Statistics
$cname_statistics = $_POST['curriculumname_statistics'];
$ccode_statistics = $_POST['curriculumcode_statistics'];
$statusstistics = $_POST['statusstistics'];
$mcomplete_statistics = $_POST['mcomplete_statistics'];
$examstatus_statistics = $_POST['examstatus_statistics'];
$totaltime_statistics = $_POST['totaltime_statistics'];

//startdate&enddate
$startdatepicker = $_POST['startdatepicker'];
$enddatepicker = $_POST['enddatepicker'];

//save record to DB 
$qcandidate = mysql_query("INSERT INTO {$CFG->prefix}report_option (organizationname, employeeid, candidateID, candidateFullname, candidateEmail, candidateAddress, candidateTel, designation, department, enrolstatus, curriculumname, curriculumcode, performancestatus, modulecompleted, totaltimeperformance, examinationstatus, markperformance, subscriptiondate, expirydate, lastaccess, cnameexam, ccodeexam, cattempts, learningoutcomes, scoreonlo, passes, passrate, cname_statistics, ccode_statistics, statusstistics, mcomplete_statistics, examstatus_statistics, totaltime_statistics, reportid, tlstartdate, tlenddate) VALUE ('" . $organizationname . "', '" . $employeeid . "', '" . $candidateID . "', '" . $candidateFullname . "', '" . $candidateEmail . "', '" . $candidateAddress . "', '" . $candidateTel . "', '" . $designation . "', '" . $department . "', '" . $enrolstatus . "', '" . $curriculumname_candidate . "', '" . $curriculumcode . "', '" . $statuscandidate . "', '" . $modulecompleted . "', '" . $totaltime . "', '" . $examinationstatus . "', '" . $markcandidate . "', '" . $subscriptiondate . "', '" . $expirydate . "', '" . $lastaccess . "', '" . $cname_examination . "', '" . $ccode_examination . "', '" . $cattemps . "', '" . $learningoutcome . "', '" . $scoreonlearning . "', '" . $passes . "', '" . $passrate . "', '" . $cname_statistics . "', '" . $ccode_statistics . "', '" . $statusstistics . "', '" . $mcomplete_statistics . "', '" . $examstatus_statistics . "', '" . $totaltime_statistics . "', '" . $reportid . "', '" . $startdatepicker . "', '" . $enddatepicker . "') ");
if ($qcandidate) {
    //redirect to viewreport	
    $linkto = $CFG->wwwroot . '/examcenter/reportview.php?id=' . $reportid . '&sid=' . $sreport;
    header('Location: ' . $linkto);
}