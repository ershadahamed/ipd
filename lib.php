<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function test_statussql($examid, $userid){
    global $DB;

    $sql = "Select
                COUNT(DISTINCT b.attempt)
              From
                mdl_cifaquiz a Inner Join
                mdl_cifaquiz_attempts b On a.id = b.quiz
              Where
                a.id='" . $examid . "' AND b.userid = '" . $userid . "'";
    $c = $DB->count_records_sql($sql);
    return $c;
}

// TEST STATUS
function teststatus_resit($examid, $userid) {
    global $DB;

    $sql = "Select
                COUNT(DISTINCT b.attempt)
              From
                mdl_cifaquiz a Inner Join
                mdl_cifaquiz_attempts b On a.id = b.quiz
              Where
                a.id='" . $examid . "' AND b.userid = '" . $userid . "'";

    $c = $DB->count_records_sql($sql);
    if ($c >= 1) {
        if ($c == 2) {
            $teststatus = 'Close';
        }
        if ($c == 1) {
            $teststatus = $c . ' attempt';
        }
    } else {
        $teststatus = $c = get_string('openstatus');
    }
    return $teststatus;
}

function coursestatus_resit($enrolstatus) {
    switch ($enrolstatus) {
        case -1:
            $coursestatus = 'No Change';
            break;
        case 0:
            $coursestatus = 'Active';
            break;
        case 1:
            $coursestatus = 'Inactive';
            break;
    }
    return $coursestatus;
}

function finaltest_sql($userid, $testid) {
    global $DB;

    $sql = "Select
            a.id,
            a.fullname,
            c.userid,c.status,
            b.id As id1,
            c.id As enrolmentid
          From
            mdl_cifacourse a Inner Join
            mdl_cifaenrol b On a.id = b.courseid Inner Join
            mdl_cifauser_enrolments c On b.id = c.enrolid
          Where
            a.id = '" . $testid . "' And c.userid='" . $userid . "'";
    $data = $DB->get_record_sql($sql);

    return $data;
}

function testexpirydate($userid, $examid) {
    global $DB;

    $sql = "Select
            a.id,
            a.fullname,
            c.userid,
            c.enrolid,c.timeend,
            FROM_UNIXTIME(c.timestart,'%d/%m/%Y') as timestartdate,
            FROM_UNIXTIME(c.timeend,'%d/%m/%Y') as timeenddate
          From
            mdl_cifacourse a Inner Join
            mdl_cifaenrol b On a.id = b.courseid Inner Join
            mdl_cifauser_enrolments c On b.id = c.enrolid
          Where
            a.id = '" . $examid . "' And c.userid='" . $userid . "'";
    $data = $DB->get_record_sql($sql);

    if ($data->timeend != 0) {
        $datetime = $data->timeenddate;
    } else {
        $datetime = get_string('never');
    }
    return $datetime;
}

function testresult_resit($examid, $userid, $grade, $expirydate) {
    global $DB;
    $todaytime = time();
    $sql = "Select
        b.userid,
        c.grade,b.quiz as attemptquizid,
        a.name
      From
        mdl_cifaquiz a Inner Join
        mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
        mdl_cifaquiz_grades c On b.userid = c.userid And b.quiz = c.quiz
      Where
        a.id = '" . $examid . "' And b.userid = '" . $userid . "'";
    $data = $DB->get_record_sql($sql);

    if ($data->grade == 0) {
        if ($todaytime <= $expirydate) {
            // valid
            $result = get_string('none');
        } else {
            // NOT valid
            $result = get_string('expired');
        }
    } elseif ($data->grade < $grade && $data->grade >= 1) {

        if ($todaytime <= $expirydate) {
            // valid
            $result = get_string('failed');
        } else {
            // NOT valid
            $result = get_string('expired');
        }
        // $result = get_string('failed');
    } else {
        $result = get_string('passed');
    }
    return $result;
}

// days in a month
function daysina_month() {
    $month = date('m', time());
    $year = date('Y', time());
    $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $dates_month = array();
    for ($i = 1; $i <= $num; $i++) {
        $mktime = mktime(0, 0, 0, $month, $i, $year);
        $date = date("d-M-Y", $mktime);
        $dates_month[$i] = $date;
    }
    return sizeof($dates_month);
}

function buildupdatedexpirydate($enrollmentid, $newexpirydate){
    global $DB;
    echo "=".$enrollmentid;
    //$sql = "SELECT id FROM {user_enrolments} WHERE userid='" . $userid . "' AND enrolid='" . $enrolid . "'";
    // = $DB->get_record_sql($sql);
    
    $record1 = new stdClass();
    $record1->id = $enrollmentid;
    $record1->timeend = $newexpirydate;
    $record1->timemodified = time();
    $record1->status = 0;
    return $DB->update_record('user_enrolments', $record1, $bulk = false);   
}

//
function update_expirydate($courseenrolid, $newexpirydate, $userid, $testid, $testexpirydate) {
    global $DB;

    $enrolmentid = finaltest_sql($userid, $testid)->enrolmentid; // TEST enrolment id
    $mocktestenrollmentid = finaltest_sql($userid, 62)->enrolmentid;
    $ipdchatenrollmentid = finaltest_sql($userid, 44)->enrolmentid;
    $ipdfbenrollmentid = finaltest_sql($userid, 57)->enrolmentid;
            
    $sql = "SELECT id FROM {user_enrolments} WHERE userid='" . $userid . "' AND enrolid='" . $courseenrolid . "'";
    $getenrolmentid = $DB->get_record_sql($sql);

    // COURSE
    $updatecourseexpirydate = buildupdatedexpirydate($getenrolmentid->id, $newexpirydate);  // IPD COURSE
    $updateipdchatexpirydate = buildupdatedexpirydate($ipdchatenrollmentid, $newexpirydate);       // IPD Chat
    $updatefbexpirydate = buildupdatedexpirydate($ipdfbenrollmentid, $newexpirydate);       // IPD Feedback    

    // TEST
    if (time() >= strtotime($testexpirydate)) {      
        $updatetestexpirydate = buildupdatedexpirydate($enrolmentid, $newexpirydate);               // Final test
        $updatemockexpirydate = buildupdatedexpirydate($mocktestenrollmentid, $newexpirydate);      // Mock
        
        $records = array($updatecourseexpirydate, $updatetestexpirydate, $updatemockexpirydate, $updateipdchatexpirydate, $updatefbexpirydate);
        return $records;
    } else {
        $records = array($updatecourseexpirydate, $updateipdchatexpirydate, $updatefbexpirydate);
        return $records;
    }
}

/*// LMS Maintenance shootout email
function lms_schedule_maintenance($user) {
    global $CFG;

    $supportuser = generate_email_supportuser();
    $user->mailformat = 1;  // Always send HTML version as well

    $a = new stdClass();
    $a->firstname = ucwords(strtolower($user->firstname));
    $a->lastname = ucwords(strtolower($user->lastname));
    $a->traineeid = $user->traineeid;
    $a->notice = '<b>Notice: '.$user->traineeid.'</b>';
    $a->startdatetimemaintenance = 'Friday 31 July, 2015 at 12:00 GMT';
    $a->datetimemaintenance = 'Friday (31 July, 2015) 12:00 GMT to Friday (31 July, 2015)  23:59 GMT';
    $a->link = '<a href="http://www.ipdonline.consultshape.com">' . 'www.ipdonline.consultshape.com' . '</a>';
    $a->consultshapelink = '<a href="mailto:info@consultshape.com">info@consultshape.com</a>';
    $a->contactuslink = '<a href="' . $CFG->httpswwwroot . '/contactus/upload_index.php">' . 'contact us' . '</a>';
    $a->signoff = '<strong>SHAPE<sup>&reg;</sup> Knowledge Services</strong>';

    $message = get_string('lms_schedule_maintenance', '', $a);
    $messagehtml = text_to_html(get_string('lms_schedule_maintenance', '', $a), false, false, true);
    //$subject = "Notice: " . strtoupper($user->traineeid);
    $subject = "IPDOnline LMS Update and Scheduled Maintenance";

    // create log
    $activity = 'To setup new url for LMS and application';
    $purpose = 'LMS Maintenance Notice';
    //lms_activity_log($user->email, $subject, $activity, $purpose, $CFG->supportemail);

    //directly email rather than using the messaging system to ensure its not routed to a popup or jabber
    return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
}*/

function testattemptlimit($examid, $userid){
    global $DB;
    
    $sql = "Select
                COUNT(DISTINCT b.attempt)
              From
                mdl_cifaquiz a Inner Join
                mdl_cifaquiz_attempts b On a.id = b.quiz
              Where
                a.id='" . $examid . "' AND b.userid = '" . $userid . "'";

    $c = $DB->count_records_sql($sql);
    return $c;
}

function getattemptid($userid, $eid, $attempt){
    global $DB;
    
    $sql = "Select * From {quiz_attempts} Where attempt='".$attempt."' And quiz='".$eid."' And userid='".$userid."'";
    return $DB->get_record_sql($sql)->id;
}

function gettestfullnamebyuserid($userid, $searchgrade){
    global $DB;
    
    $sql="Select
        a.name,
        a.id As quizid,
        a.course,
        b.category,
        c.userid,
        c.enrolid,
        e.grade, b.fullname
      From
        mdl_cifaquiz a Inner Join
        mdl_cifacourse b On b.id = a.course Inner Join
        mdl_cifaenrol d On d.courseid = b.id Inner Join
        mdl_cifauser_enrolments c On d.id = c.enrolid Inner Join
        mdl_cifaquiz_grades e On a.id = e.quiz And e.userid = c.userid
      Where
        b.category = '3' And
        c.userid = '".$userid."' And
        e.grade = '".$searchgrade."'";
    return $DB->get_record_sql($sql);    
}    