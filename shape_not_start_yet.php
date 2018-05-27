<?php
define('CLI_SCRIPT', true);
require_once('config.php');
require_once($CFG->libdir . '/logactivity_lib.php');
require_once($CFG->libdir . '/moodlelib.php');
//email to candidate yet to start LMS

$courseid = '32';
$newusers = $DB->get_recordset_sql("	
		Select
		  c.userid, c.timestart, c.timeend, 
		  d.firstname, d.lastname, d.traineeid,
		  FROM_UNIXTIME(d.timecreated,'%d/%m/%Y') as startdate,
                  DATE_ADD(FROM_UNIXTIME(d.timecreated,'%Y-%m-%d'), INTERVAL 60 DAY) as subscribeexpiry,
		  DATE_ADD(FROM_UNIXTIME(d.timecreated,'%Y-%m-%d'), INTERVAL 120 DAY) as enddate, d.email
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifaenrol b On a.id = b.courseid Inner Join
		  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
		  mdl_cifauser d On c.userid = d.id
		Where
		  d.usertype='Active candidate' AND a.id = '".$courseid."' AND d.confirmed='1' AND d.deleted='0' AND d.firstaccess='0' AND d.email!=''
	");
foreach ($newusers as $newuser) {
    $tt = explode('-', $newuser->subscribeexpiry);
    $expirydate = $tt['2'] . "/" . $tt['1'] . "/" . $tt['0'];
    $today = strtotime('now');
    $epd = strtotime($newuser->subscribeexpiry);
    if ($today <= $epd) {
        if (!lms_reminder_notyetstart($newuser)) {
            echo $newuser->userid . " || ";
            echo $newuser->firstname . " || ";
            echo $newuser->lastname . " || ";
            echo $newuser->startdate . " || ";
            echo $expirydate . " || ";
            echo $newuser->email;
            echo "<br/>";
        } else {
            echo "Email send out to candidate. <br/>";
        }
    } else {
        echo $newuser->userid . " || ";
        echo $newuser->firstname . " || ";
        echo $newuser->lastname . " || ";
        echo $newuser->startdate . " || ";
        echo $expirydate . " | ";
        echo "Course already expiry.";
        echo "<br/>";
    }
}
$newusers->close(); // Don't forget to close the recordset!