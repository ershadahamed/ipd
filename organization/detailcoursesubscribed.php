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

echo '<h3 style="margin-bottom:1em;">Total Course Subscribed</h3>';
$table5 = new html_table();
$table5->head = array("Course title", "Total Course Subscribed");
$table5->align = array("left", "center");
$table5->width = "100%";
$no3 = 1;

foreach (coursepassrate($organizationid) as $cpassrate) {
    $a=counttotalsubscribeduser_org($organizationid, $cpassrate->courseid);
    $total+=$a;

    $table5->data[] = array($cpassrate->fullname, $a);
}
$table5->data[] = array('', $total);
if (!empty($table5)) {
    echo html_writer::table($table5);
}
echo $OUTPUT->footer();
