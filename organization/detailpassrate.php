<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../config.php');
require_once('lib.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/filelib.php');

$organizationid = required_param('orgid', PARAM_ALPHANUMEXT);
$PAGE->set_pagelayout('buy_a_cifa');

echo $OUTPUT->header();
global $DB;

echo '<h3 style="margin-bottom:1em;">Pass Rate</h3>';
$table5 = new html_table();
$table5->head = array("Course title", "User passrate", "%");
$table5->align = array("left", "center", "center");
$table5->width = "100%";
$no3 = 1;

// print_r(coursepassrate($organizationid));
$passgrade = '60';
foreach (coursepassrate($organizationid) as $cpassrate) {
    //echo $cpassrate->courseid.''.$organizationid;
    $usersattemptcourse = counttotalsubscribeduser_org($organizationid, $cpassrate->courseid);   // user yg attempt course
    $total+=$usersattemptcourse;
    
    // echo $data->id1;
    $userpassrate = userpassrateis(testdetails($cpassrate->coursecode, 1)->fullname, $organizationid, $passgrade, testdetails($cpassrate->coursecode, 3)->id);
    $getperatus = ($userpassrate / $usersattemptcourse) * 100;
    
    $totaluserpassrate+=$userpassrate;
    $totalgetperatus+=$getperatus;
    
    //echo testdetails($cpassrate->coursecode, 1)->fullname;
    //echo '<br/>';
    //echo usersexam_attempts($examid);
    //echo testdetails($cpassrate->coursecode, 3)->id;
    // $grade = userpassrateis(testdetails($cpassrate->coursecode, 1)->fullname, $organizationid, $passgrade, testdetails($cpassrate->coursecode, 3)->id);

    // =(total pass user / total attempting the course) * 100

    //$per = $grade . '/'.$total;             // yg lulus
    //$peratus = ($grade / $usersattemptcourse) * 100;   // peratus

    //$ppperatus+=$getperatus;
    // $b+=100;
    //$totalperatus = ($ppperatus / $b) * 100;
    
    // $totalperatus = ()*100;

    $table5->data[] = array($cpassrate->fullname, $userpassrate, round($getperatus));
}
$table5->data[] = array('', $totaluserpassrate . '/' . $total, round($totalgetperatus));
if (!empty($table5)) {
    echo html_writer::table($table5);
}
echo $OUTPUT->footer();
