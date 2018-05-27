<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/filelib.php');

$PAGE->set_url('/');
$PAGE->set_course($SITE);

$emailactivitys = get_string('emailactivity');
$url = new moodle_url('/manualemail/emailactivity.php');
$PAGE->navbar->add(ucwords(strtolower($emailactivitys)), $url);

$PAGE->set_pagetype('site-index');
$editing = $PAGE->user_is_editing();
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('buy_a_cifa');

echo $OUTPUT->header();
?>
<form id="name" method="post">
<select name="along">
    <option value="01">January</option>
    <option value="02">February</option>
    <option value="03">March</option>
    <option value="04">April</option>
    <option value="05">January</option>
    <option value="06">February</option>
    <option value="07">March</option>
    <option value="08">April</option>
    <option value="09">January</option>
    <option value="10">February</option>
    <option value="11">March</option>
    <option value="12">April</option>
</select>
<input type="submit" name="submit" value="Submit" />
</form>
<?php
$month = $_POST['along'];
$getlist = getListOfloggedinUsers($month);
// Total user login by date
$table = new html_table();
$table->head = array("Date", "Loggedin", "Subscribed");
$table->align = array("center", "left", "left");
$table->width = "100%";
$userc='1';
foreach ($getlist as $list) {
    $table->data[] = array($list->logdate,
        totalLoggedinByDate($list->logdate), totalSubscribeBydate($list->logdate, 32)
    );
}
if (!empty($table)) {
    echo html_writer::table($table);
}

// Active Users Report  - get active user by report duration
$ActiveUsers= getListOfActiveUsers($month);

$table2 = new html_table();
$table2->head = array("No", "Candidate ID", "Full Name");
$table2->align = array("center", "center", "left");
$table2->width = "100%";
$no=1;
foreach ($ActiveUsers as $list2) {
    $fullname = $list2->firstname.' '.$list2->lastname;
    
    $table2->data[] = array($no++, ucwords(strtoupper($list2->traineeid)),
        $fullname
    );
}
if (!empty($table2)) {
    echo html_writer::table($table2);
}

//total subcribe course by date
$listSubscribeBydate = listSubscribeBydate($month, 32);
$table3 = new html_table();
$table3->head = array("No", "Date", "Subscribed");
$table3->align = array("center", "center", "left");
$table3->width = "100%";
$no=1;
foreach ($listSubscribeBydate as $list3) {    
    $table3->data[] = array($no++, $list3->subscribedate, totalSubscribeBydate($list3->subscribedate, 32)
    );
}
if (!empty($table3)) {
    echo html_writer::table($table3);
}

global $DB;
$sqltext="Select
  a.firstname,
  a.lastname,
  c.userid,
  c.enrolid,
  a.orgtype,
  d.name,
  a.institution,
  a.empname, a.city, a.suborgtype,
  d.groupofinstitution,
  d.id As id1  
From
  mdl_cifauser a Inner Join
  mdl_cifauser_enrolments c On a.id = c.userid Inner Join
  mdl_cifaenrol b On b.id = c.enrolid Inner Join
  mdl_cifaorganization_type d On a.orgtype = d.id
Where
  b.courseid = '32'";
$get1=$DB->get_recordset_sql($sqltext);

$table4 = new html_table();
$table4->head = array("No","User ID", "Full Name", "Organization Name","Institution", "Employer Name", "Organization ID");
$table4->align = array("center", "center", "center", "center", "center", "center", "center");
$table4->width = "100%";
$no1=1;

foreach($get1 as $get){
    $fullname = $get->firstname.' '.$get->lastname;
    $table4->data[] = array($no1++,$get->userid, $fullname, $get->name.' -> '.$get->city, $get->institution, $get->empname, $get->id1.''.$get->suborgtype
    );    
}
if (!empty($table4)) {
    echo html_writer::table($table4);
}

// $sqlinstitution=$DB->get_recordset_sql("Select * From {user} Where orgtype='7' And (institution LIKE '%Abu Dhabi%' OR institution LIKE '%ADIB UAE%' OR institution LIKE '%ADIB HQ%')");
//$sqlinstitution=$DB->get_recordset_sql("Select * From {user} Where orgtype='7' And (institution LIKE '%ADIB Iraq%')");
// $sqlinstitution=$DB->get_recordset_sql("Select * From {user} Where orgtype='7' And (institution LIKE '%ADIB UK%')");
// $sqlinstitution=$DB->get_recordset_sql("Select * From {user} Where orgtype='7' And (institution LIKE '%Dubai%')");
/*$sqlinstitution=$DB->get_recordset_sql("Select * From {user} Where orgtype='7' And (city LIKE '%AbuDhabi%')");
foreach($sqlinstitution as $institude){
    $org=$DB->get_record_sql("Select * From {organization_type} Where name LIKE '%ADIB Abu Dhabi%'");
    echo $institude->id.'->'.$institude->institution.''.$org->name.''.$org->id.'<br/>';
    
    $upduser = new stdClass();
    $upduser->id = $institude->id;
    $upduser->suborgtype = $org->id;
    $DB->update_record('user', $upduser, false);
}*/

echo totalSubscribeByYear('2015', 32);

echo $OUTPUT->footer();