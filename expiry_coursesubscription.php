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
echo date('d/m/Y', time()) . '<br/>';
// echo get_rolename() . '<br/>';

$time = array();
$time[] = ' due to expire within a month';
$time[] = ' due to expire within 48 hours';
$time[] = ' Program Expired';

$expirysubscription = $DB->get_recordset_sql("	
		Select
		  c.userid, c.timestart, c.timeend, 
		  d.firstname, d.lastname, d.traineeid, d.email,
		  FROM_UNIXTIME(c.timestart,'%d/%m/%Y') as startdate,
                  FROM_UNIXTIME(c.timeend,'%d/%m/%Y') as expirydate,
		  DATE_ADD(FROM_UNIXTIME(c.timestart,'%Y-%m-%d'), INTERVAL 60 DAY) as enddate
		From
		  {course} a Inner Join
		  {enrol} b On a.id = b.courseid Inner Join
		  {user_enrolments} c On b.id = c.enrolid Inner Join
		  {user} d On c.userid = d.id
		Where
		  d.usertype='" . get_rolename() . "' AND a.id = '32' AND d.confirmed='1' AND d.deleted='0' AND d.firstaccess!='0'
	");

foreach ($expirysubscription as $expiryusers) {
    $tt = explode('-', $expiryusers->enddate);
    $expirydate = $tt['2'] . "/" . $tt['1'] . "/" . $tt['0'];
    $today = time();
    $todaydate = date('d/m/Y', time());
    $epd = strtotime($expiryusers->enddate);

    $e30daybefore = strtotime($expiryusers->enddate . " - 30 days");
    $e2daybefore = strtotime($expiryusers->enddate . " - 2 days");
    $exp = date('d/m/Y', $e30daybefore);
    $exp2days = date('d/m/Y', $e2daybefore);

    $traineeid = strtoupper($expiryusers->traineeid);
    
    // class for email content
    $a = new stdClass();
    $a->sitename = get_string('ipdonline');
    $a->firstname = ucwords(strtolower($expiryusers->firstname));
    $a->lastname = ucwords(strtolower($expiryusers->lastname));
    $a->traineeid = $expiryusers->traineeid;
    $a->extend = '<strong>' . strtoupper(get_string('extendedcourse')) . '</strong>';
    $a->activetraining = '<u>' . get_string('activetrainings') . '</u>';
    $a->mytraining = '"' . get_string('mytraining') . '"';
    $a->shapeipdportal = 'SHAPE<sup>&reg;</sup> IPD Portal';
    $a->buyipd = '"' . get_string('buyacifa') . '"';
    $a->contactuslink = '<a href="' . $CFG->httpswwwroot . '/contactus/upload_index.php">' . 'contact us' . '</a>';
    $a->signoff = '<strong>SHAPE<sup>&reg;</sup> Knowledge Services</strong>';
    
    if ($today <= $epd) {
        if ($todaydate == $exp) {
            $messagetext = get_string('expirycoursemonth', '', $a);
            $subject = "Reminder: " . $traineeid . " - Expiry of SHAPE IPD Training Program Subscription";
            reminder_expirycourse($expiryusers, $subject, $time[0], $messagetext);    // 30 days before expiry
        } elseif ($todaydate == $exp2days) {
            $messagetext = get_string('expirycoursetwoday', '', $a);
            $subject = "Reminder: " . $traineeid . " - Expiry of SHAPE IPD Training Program Subscription within 48 hours";
            reminder_expirycourse($expiryusers, $subject, $time[1], $messagetext);    // 2 days before expiry
        } elseif ($todaydate == $expirydate) {
            $messagetext = get_string('expirycourse', '', $a);
            $subject = "Notice: " . $traineeid . " - SHAPE IPD Training" . $time[2];
            reminder_expirycourse($expiryusers, $subject, $time[2], $messagetext);    // day of expiry
        }
        echo $expiryusers->userid . " || ";
        echo $expiryusers->firstname . " || ";
        echo $expiryusers->lastname . " || ";
        echo $expiryusers->startdate . " || ";
        echo $exp . " || ";
        echo $exp2days."||";
        print_r($expirydate);
        echo "<br/>";
    }
}
$newusers->close();
