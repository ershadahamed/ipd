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
 * testing code here!!!
 */
//$conditions = array('id' => '134'); ///the name of the field (key) and the desired value
//$su = $DB->get_records('user', $conditions);
//foreach ($su as $user) {
    // echo $user->firstname.' / '.$user->email;
    // testing($user);
//}

/*
 * reporting scheduling(daily, weekly, monthly)
 */
$timenow = time();
$today = strtotime('now');
mtrace("Server Time: " . date('r', $timenow) . "\n\n");
echo '<br/>';
$recipientusers = $DB->get_recordset_sql("SELECT *
                                                FROM 
                                            mdl_cifareport_scheduling a Inner Join
                                            mdl_cifareport_recipient b On a.id = b.scheduling_id Inner Join
                                            mdl_cifauser c On b.recipient_id = c.id Inner Join
                                            mdl_cifareport_menu d On a.rid = d.id
                                               ");

// note: we can not send emails to suspended accounts
foreach ($recipientusers as $rusers) {
    $conditions = array('reportid' => $rusers->rid); ///the name of the field (key) and the desired value
    $rop = $DB->get_record('report_option', $conditions);
    
    $tt=explode('/', $rop->tlstartdate);
    $tl=explode('/', $rop->tlenddate);
    $timestart = $tt['0']."-".$tt['1']."-".$tt['2'];
    $timeend = $tl['0']."-".$tl['1']."-".$tl['2'];
    
    // timeline start & end
    $timeline_start = strtotime($timestart);
    $timeline_end = strtotime($timeend);

    if (($today >= $timeline_start) && ($today <= $timeline_end)) {
        if ($rusers->scheduling == 'weekly') {
            for ($i = 0; $i < 7; $i++) {
                if ($i == $rusers->scheduling_value) {
                    schedulling_task($rusers);
                }
            }
        } elseif ($rusers->scheduling == 'monthly') {
            for ($i = 0; $i < 31; $i++) {
                if ($i == $rusers->scheduling_value) {
                    schedulling_task($rusers);
                }
            }
        } else {
                schedulling_task($rusers);
        }
    } // timeline end
}
$recipientusers->close();

