<?php

define('CLI_SCRIPT', true);
require_once('config.php');
require_once($CFG->libdir . '/logactivity_lib.php');
require_once($CFG->libdir . '/moodlelib.php');
//email to candidate yet to start /// not completed

$newusers = $DB->get_recordset_sql("	
		Select
		  c.userid, c.timestart, c.timeend, 
		  d.firstname, d.lastname, d.traineeid,
		  FROM_UNIXTIME(d.firstaccess,'%d/%m/%Y') as startdate,
		  DATE_ADD(FROM_UNIXTIME(d.firstaccess,'%Y-%m-%d'), INTERVAL 60 DAY) as enddate, d.email
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifaenrol b On a.id = b.courseid Inner Join
		  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
		  mdl_cifauser d On c.userid = d.id
		Where
		  d.usertype='Active candidate' AND a.id = '32' AND d.confirmed='1' AND d.deleted='0' AND d.firstaccess!='0'
	");

foreach ($newusers as $newuser) {
    $tt = explode('-', $newuser->enddate);
    $expirydate = $tt['2'] . "/" . $tt['1'] . "/" . $tt['0'];
    $today = strtotime('now');
    $epd = strtotime($newuser->enddate);
    if ($today <= $epd) {
        $userid=$newuser->userid;
        if($DB->count_records('quiz_grades', array('userid' =>$userid, 'quiz' => '26'))){
            echo $newuser->userid . " || ";
            echo "Email already send out to candidate. <br/>";
        }else{
            if (!lms_reminder_coursenotcomplete($newuser)) {
                echo $newuser->userid . " || ";
                echo $newuser->firstname . " || ";
                echo $newuser->lastname . " || ";
                echo $newuser->startdate . " || ";
                echo $expirydate . " || ";
                echo $newuser->email;
                echo "<br/>";
            }   
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
$newusers->close();
?>