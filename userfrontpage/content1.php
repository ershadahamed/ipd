<?php

/*
 * Create By: Arizan Abdullah
 * Updated on 19 January 2015
 */

if (get_user_details($USER->id)->firstaccess == '0') {
    $secretkey = sesskey();
    $sqlp = mysql_query("UPDATE mdl_cifauser SET secret='" . $secretkey . "', firstaccess='" . strtotime('now') . "' WHERE firstaccess='0' AND id='" . $USER->id . "'");
}
updatecourse_subscription($USER->id);   // update course subscription date for firsttime loggin after purchase

$sqlCourses = "Select
                *, a.idnumber as coursecode,
                FROM_UNIXTIME(c.timestart,'%M %d, %Y') as startdate,
                FROM_UNIXTIME(c.timeend,'%M %d, %Y') as expirydate
            From
                {$CFG->prefix}course a Inner Join
                {$CFG->prefix}enrol b On a.id = b.courseid Inner Join
                {$CFG->prefix}user_enrolments c On b.id = c.enrolid Inner Join
                {$CFG->prefix}user d On c.userid = d.id
            Where
                a.category='1' And b.enrol='manual' And 
                a.visible='1' And
                c.userid = '" . $USER->id . "'";
$sqlCourses.=" Order by a.category ASC";
$sqllist = $DB->get_recordset_sql($sqlCourses);
$result = mysql_query($sqlCourses);
$c = mysql_num_rows($result);
foreach ($sqllist as $courselist) {
    $courseid = $courselist->courseid;              // Course ID
    $coursecode = $courselist->coursecode;          // Course code@idnumber
    $coursename = $courselist->fullname;            // Course fullname
    $fulltitle = $coursecode . ': ' . $coursename;  // Course fullname + course code
    $timestart = $courselist->startdate;            // course subscription startdate
    $timeend = $courselist->expirydate;             // course subscription end date
    $summary = trim($courselist->summary);          // Course Summary

    $todaydate = strtotime('now');
    $twodaybefore = strtotime($courselist->expirydate . " - 2 days");  // 48 hours before
    $e30daybefore = strtotime($courselist->expirydate . " - 30 days"); // 1 month before
    $e30dayafter = strtotime($courselist->expirydate . " + 31 days");  // 1 month after  
    //print_r($courselist->enrolid);
    include('coursedetails.php');
}
$sqllist->close();

if ($c < 1) {
    print_r('No records found');
}