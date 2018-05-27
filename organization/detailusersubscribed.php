<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * totalSubscribeByYear($year, courseid, organization ID)
 */

require_once('../config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/filelib.php');

$organizationid = required_param('orgid', PARAM_ALPHANUMEXT);
$PAGE->set_pagelayout('buy_a_cifa');

echo $OUTPUT->header();

$courseid = '32';
echo '<h3 style="margin-bottom:1em;">Total User Subscribed</h3>';
$table5 = new html_table();
$table5->head = array("Year", "Total Subscribed");
$table5->align = array("center", "left");
$table5->width = "100%";
$no3 = 1;

$setyears = date("Y", time());
for ($i = 2014; $i <= $setyears; $i++) {
    $totalSubscribeByYear = totalSubscribeByYear($i, $courseid, $organizationid);
    $table5->data[] = array($i, $totalSubscribeByYear
    );
}
$table5->data[] = array('', totalUsersSubscribeByOrg($organizationid));
if (!empty($table5)) {
    echo html_writer::table($table5);
}
echo $OUTPUT->footer();
