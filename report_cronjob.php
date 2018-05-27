<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define('CLI_SCRIPT', true);
require_once('config.php');
require_once($CFG->libdir . '/logactivity_lib.php');
require_once($CFG->libdir . '/moodlelib.php');

/*
 * reporting scheduling(daily, weekly, monthly)
 */
$timenow = time();
$today = strtotime('now');
mtrace("Server Time: " . date('r', $timenow) . "\n\n");
echo '<br/>';
$monthlyvalue=date('j', $timenow);  // 1 - 30
$dateweekvalue=date('N', $timenow); // 1 - 7
// echo date('l', $timenow);
$recipientusers = $DB->get_recordset_sql("SELECT *
                                                FROM 
                                            {report_scheduling} a Inner Join
                                            {report_recipient} b On a.id = b.scheduling_id Inner Join
                                            {user} c On b.recipient_id = c.id Inner Join
                                            {report_menu} d On a.rid = d.id
                                               ");

// note: we can not send emails to suspended accounts
foreach ($recipientusers as $rusers) {
    $conditions = array('reportid' => $rusers->rid); ///the name of the field (key) and the desired value
    $rop = $DB->get_record('report_option', $conditions);

    $tt = explode('/', $rop->tlstartdate);
    $tl = explode('/', $rop->tlenddate);
    $timestart = $tt['0'] . "-" . $tt['1'] . "-" . $tt['2'];
    $timeend = $tl['0'] . "-" . $tl['1'] . "-" . $tl['2'];

    // timeline start & end
    $timeline_start = strtotime($timestart);
    $timeline_end = strtotime($timeend);

    if (($today >= $timeline_start) && ($today <= $timeline_end)) {
        if ($rusers->scheduling == 'weekly') {            
            if($dateweekvalue==$rusers->scheduling_value){
                schedulling_task($rusers);
            }
        } elseif ($rusers->scheduling == 'monthly') {
            if($monthlyvalue==$rusers->scheduling_value){
                schedulling_task($rusers);
            }
        } else {
            schedulling_task($rusers);
        }
    } // timeline end
}
$recipientusers->close();

