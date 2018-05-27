<?php

// require_once($CFG->libdir.'/moodlelib.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function lms_activity_log($recipient = '', $information = '', $activity = '', $purpose = '', $sender = '') {
    global $DB;

    //$tt = getdate(time());
    //$today = mktime(0, 0, 0, $tt["mon"], $tt["mday"], $tt["year"]);
    //inser record 
    $record = new stdClass();
    $record->activity = $activity;
    $record->purpose = $purpose;
    $record->recipient = $recipient;
    $record->sender = $sender;
    $record->timecreated = time();
    $record->information = $information;
    $lastinsertid = $DB->insert_record('log_activity', $record, false);

    return $lastinsertid;
}

function test_insert() {
    global $DB;

    $record = new stdClass();
    $record->activity = 'Candidate Status';
    $record->purpose = 'Verify candidate studying IPD with SHAPE';
    $record->recipient = 'IPD Candidate';
    $lastinsertid = $DB->insert_record('standard_responses', $record, false);

    return $lastinsertid;
}

function lms_welcome_email($user) {
    global $CFG, $DB;

    $site = get_site();
    $supportuser = generate_email_supportuser();
    $user->mailformat = 1;  // Always send HTML version as well

    $a = new stdClass();
    $a->cifa = 'CIFA&#8482;';
    $a->firstname = ucwords(strtolower($user->firstname));
    $a->lastname = ucwords(strtolower($user->lastname));
    $a->traineeid = $user->traineeid;
    $a->sitename = format_string($site->fullname);
    $a->username = strtoupper($user->username); //modified by arizan
    $a->newpassword = 'Password01$';
    $a->link = '<a href="' . $CFG->httpswwwroot . '">' . 'ipdonline.consultshape.com' . '</a>';
    $a->websiteurl = '<a href="http://www.Learncifa.com/structure">www.Learncifa.com</a>';
    $a->contactuslink = '<a href="' . $CFG->httpswwwroot . '/contactus/upload_index.php">' . 'contact us' . '</a>';
    $a->signoff = '<strong>SHAPE<sup>&reg;</sup> Knowledge Services</strong>';

    $message = get_string('welcome_email_text', '', $a);
    $messagehtml = text_to_html(get_string('welcome_email_text', '', $a), false, false, true);

    $subject = "Next Step: " . strtoupper($user->traineeid) . " - Candidate Enrolment Confirmation >> Foundation of Islamic Banking and Finance";

    // log record to db
    $dbtable2 = 'standard_responses'; ///name of table
    $conditions = array('id' => '1'); ///the name of the field (key) and the desired value
    $sort = 'id'; //field or fields you want to sort the result by

    $result2 = $DB->get_records($dbtable2, $conditions, $sort);
    foreach ($result2 as $rc) {
        $activity = $rc->activity;
        $purpose = $rc->purpose;
    }
    lms_activity_log($user->email, $subject, $activity, $purpose, $CFG->supportemail);

    //directly email rather than using the messaging system to ensure its not routed to a popup or jabber
    return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
}

/*
 * Setting for reminder - not complete course
 */

function lms_reminder_coursenotcomplete($user) {
    global $CFG;

    $supportuser = generate_email_supportuser();
    $user->mailformat = 1;  // Always send HTML version as well

    $tt = explode('-', $user->enddate);
    $expirydate = $tt['2'] . "/" . $tt['1'] . "/" . $tt['0'];

    $a = new stdClass();
    $a->firstname = ucwords(strtolower($user->firstname));
    $a->lastname = ucwords(strtolower($user->lastname));
    $a->traineeid = $user->traineeid;
    $a->expirydate = $expirydate;
    $a->link = '<a href="' . $CFG->httpswwwroot . '">' . 'ipdonline.consultshape.com' . '</a>';
    $a->contactuslink = '<a href="' . $CFG->httpswwwroot . '/contactus/upload_index.php">' . 'contact us' . '</a>';
    $a->signoff = '<strong>SHAPE<sup>&reg;</sup> Knowledge Services</strong>';

    $message = get_string('reminder_notcomplet_course', '', $a);
    $messagehtml = text_to_html(get_string('reminder_notcomplet_course', '', $a), false, false, true);
    $subject = "Reminder: " . strtoupper($user->traineeid) . " - Expiry of SHAPE Foundation of Islamic Banking and Finance Course Subscription";

    // create log
    $activity = 'Reminder to candidate which not complete the course';
    $purpose = 'Reminder to candidate';
    lms_activity_log($user->email, $subject, $activity, $purpose, $CFG->supportemail);

    //directly email rather than using the messaging system to ensure its not routed to a popup or jabber
    return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
}

/*
 * lms_reminder_notyetstart
 */

function lms_reminder_notyetstart($user) {
    global $CFG;

    $supportuser = generate_email_supportuser();
    $user->mailformat = 1;  // Always send HTML version as well

    $tt = explode('-', $user->enddate);
    $expirydate = $tt['2'] . "/" . $tt['1'] . "/" . $tt['0'];

    $a = new stdClass();
    $a->firstname = ucwords(strtolower($user->firstname));
    $a->lastname = ucwords(strtolower($user->lastname));
    $a->traineeid = $user->traineeid;
    $a->expirydate = $expirydate;
    $a->link = '<a href="' . $CFG->httpswwwroot . '">' . 'ipdonline.consultshape.com' . '</a>';
    $a->contactuslink = '<a href="' . $CFG->httpswwwroot . '/contactus/upload_index.php">' . 'contact us' . '</a>';
    $a->signoff = '<strong>SHAPE<sup>&reg;</sup> Knowledge Services</strong>';

    $message = get_string('reminder_notstart_LMS', '', $a);
    $messagehtml = text_to_html(get_string('reminder_notstart_LMS', '', $a), false, false, true);
    $subject = "Reminder: " . strtoupper($user->traineeid) . " - Expiry of SHAPE Foundation of Islamic Banking and Finance Course Subscription";

    // create log
    $activity = 'Reminder to candidate about not start LMS';
    $purpose = 'Reminder to candidate';
    lms_activity_log($user->email, $subject, $activity, $purpose, $CFG->supportemail);

    //directly email rather than using the messaging system to ensure its not routed to a popup or jabber
    return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
}

/*
 * lms_reminder_expiry_course_subscription
 */

function reminder_expirycourse($user, $subject, $time, $messagetext) {
    global $CFG;

    $supportuser = generate_email_supportuser();
    $user->mailformat = 1;  // Always send HTML version as well
       
    // create log
    $activity = 'Reminder to candidate';
    $purpose = 'Reminder to ' . strtoupper($user->traineeid) . $time;     
    lms_activity_log($user->email, $subject, $activity, $purpose, $CFG->supportemail);
    $message = $messagetext;
    $messagehtml = text_to_html($messagetext, false, false, true);  

    //directly email rather than using the messaging system to ensure its not routed to a popup or jabber
    return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
}

/*
 * Schedule to download report
 */

function schedulling_task($user) {
    global $CFG, $DB;

    $supportuser = generate_email_supportuser();
    $user->mailformat = 1;  // Always send HTML version as well
    $reportname = ucwords(strtolower($user->reportname));

    $conditions = array('reportid' => $user->rid); ///the name of the field (key) and the desired value
    $rop = $DB->get_record('report_option', $conditions);
    $url = $CFG->wwwroot . '/examcenter/download_excel.php?rid=' . $user->rid . '&rcid=' . $user->reportcreator . '&sid=' . $user->selectedreport;

    $a = new stdClass();
    $a->firstname = ucwords(strtolower($user->firstname));
    $a->lastname = ucwords(strtolower($user->lastname));
    $a->timeline_start = $rop->tlstartdate;
    $a->timeline_end = $rop->tlenddate;
    $a->linkdownload = '<a href="' . $url . '">' . 'Click_to_download' . '</a>';
    $a->contactuslink = '<a href="' . $CFG->httpswwwroot . '/contactus/upload_index.php">' . 'contact us' . '</a>';
    $a->signoff = '<strong>SHAPE<sup>&reg;</sup> Knowledge Services</strong>';

    $message = get_string('schedule_emailtext', '', $a);
    $messagehtml = text_to_html(get_string('schedule_emailtext', '', $a), false, false, true);
    $subject = "Reminder: New generated report - " . $reportname;

    // create log
    $activity = 'Schedule report';
    $purpose = 'Schedule report';
    lms_activity_log($user->email, $subject, $activity, $purpose, $CFG->supportemail);

    //directly email rather than using the messaging system to ensure its not routed to a popup or jabber
    return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
}

/*
 * Testing sending email using cron
 */

function testing($user) {
    global $CFG, $DB;

    $supportuser = generate_email_supportuser();
    $user->mailformat = 1;  // Always send HTML version as well
    $reportname = ucwords(strtolower($user->reportname));

    $conditions = array('reportid' => $user->rid); ///the name of the field (key) and the desired value
    $rop = $DB->get_record('report_option', $conditions);

    $a = new stdClass();
    $a->firstname = ucwords(strtolower($user->firstname));
    $a->lastname = ucwords(strtolower($user->lastname));
    $a->timeline_start = $rop->tlstartdate;
    $a->timeline_end = $rop->tlenddate;
    $a->linkdownload = '<a href="' . $CFG->httpswwwroot . '">' . 'ipdonline.consultshape.com' . '</a>';
    $a->contactuslink = '<a href="' . $CFG->httpswwwroot . '/contactus/upload_index.php">' . 'contact us' . '</a>';
    $a->signoff = '<strong>SHAPE<sup>&reg;</sup> Knowledge Services</strong>';

    $message = get_string('schedule_emailtext', '', $a);
    $messagehtml = text_to_html(get_string('schedule_emailtext', '', $a), false, false, true);
    $subject = "Reminder: New generated report - " . $reportname;

    //directly email rather than using the messaging system to ensure its not routed to a popup or jabber
    return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
}

/*
 * Get user role name for report
 */

function get_reportcreator($rcid) {
    global $DB, $CFG;

    $sql = "    Select
		  b.userid,
		  a.name,
		  a.id,
		  b.contextid
		From
		  {role} a Inner Join
		  {role_assignments} b On a.id = b.roleid
		Where
		  b.userid = '" . $rcid . "' And
		  b.contextid = 1";
    $getrcid = $DB->get_record_sql($sql);
    return $getrcid->name;
}

/*
 * Reset password - sending email through HR admin/BP
 */

function resetcandidatepassword($user) {
    global $CFG;

    $supportuser = generate_email_supportuser();
    $user->mailformat = 1;  // Always send HTML version as well
    $newpasswordtext = 'Password01$';

    $a = new stdClass();
    $a->sitename = 'IPD Online';
    $a->firstname = ucwords(strtolower($user->firstname));
    $a->lastname = ucwords(strtolower($user->lastname));
    $a->traineeid = strtoupper($user->traineeid);
    $a->newpassword = $newpasswordtext;
    $a->link = '<a href="' . $CFG->httpswwwroot . '/login/change_password.php?id=1">' . $CFG->httpswwwroot . '/login/change_password.php?id=1' . '</a>';
    $a->contactuslink = '<a href="' . $CFG->httpswwwroot . '/contactus/upload_index.php">' . 'contact us' . '</a>';
    $a->signoff = '<strong>SHAPE<sup>&reg;</sup> Knowledge Services</strong>';

    $message = get_string('newpasswordtext', '', $a);
    $messagehtml = text_to_html(get_string('newpasswordtext', '', $a), false, false, true);
    $subject = "Reminder: Password reset";

    //directly email rather than using the messaging system to ensure its not routed to a popup or jabber
    $email_to_user = email_to_user($user, $supportuser, $subject, $message, $messagehtml);

    if ($email_to_user) {
        // create log
        $activity = 'Reset password';
        $purpose = 'Reset password - ' . $user->firstname . ' ' . $user->lastname . '(' . strtoupper($user->traineeid) . ')';
        lms_activity_log($user->email, $subject, $activity, $purpose, $CFG->supportemail);
    }

    return $email_to_user;
}

/*
 * Auto responses to sender when using contact us
 */

function autoresponsesmail($sender) {
    global $CFG;
    $supportuser = generate_email_supportuser();

    $sender->mailformat = 1;  // Always send HTML version as well

    $a = new stdClass();
    $a->sitename = 'IPD Online';
    $a->fullname = ucwords(strtolower($sender->firstname . ' ' . $sender->lastname));
    $a->link = '<a href="' . $CFG->httpswwwroot . '/login/change_password.php?id=1">' . $CFG->httpswwwroot . '/login/change_password.php?id=1' . '</a>';
    $a->contactuslink = '<a href="' . $CFG->httpswwwroot . '/contactus/upload_index.php">' . 'contact us' . '</a>';
    $a->signoff = '<strong>SHAPE<sup>&reg;</sup> Knowledge Services</strong>';

    $message = get_string('autoresponsesemail', '', $a);
    $messagehtml = text_to_html(get_string('autoresponsesemail', '', $a), false, false, true);
    $subject = 'Auto-response: This is system generated email. Please do not reply';
    // create log
    $activity = 'Auto responses email';
    $purpose = 'Auto responses email - ' . $sender->firstname . ' ' . $sender->lastname;
    lms_activity_log($sender->email, $subject, $activity, $purpose, $CFG->supportemail);

    //directly email rather than using the messaging system to ensure its not routed to a popup or jabber
    return email_to_user($sender, $supportuser, $subject, $message, $messagehtml);
}

/*
 * lms_reminder_notyetstart
 */

function manual_sendingmail($user) {
    global $CFG;

    $supportuser = generate_email_supportuser();
    $user->mailformat = 1;  // Always send HTML version as well

    $a = new stdClass();
    $a->getsite = 'IPD Online';
    $a->firstname = ucwords(strtolower($user->firstname));
    $a->lastname = ucwords(strtolower($user->lastname));
    $a->traineeid = ucwords(strtoupper($user->traineeid));
    $a->linkdownload = '<a href="' . $CFG->httpswwwroot . '">' . 'ipdonline.consultshape.com' . '</a>';
    $a->contactuslink = '<a href="' . $CFG->httpswwwroot . '/contactus/upload_index.php">' . 'contact us' . '</a>';
    $a->signoff = '<strong>SHAPE<sup>&reg;</sup> Knowledge Services</strong>';

    $message = get_string('manual_sendingmail', '', $a);
    $messagehtml = text_to_html(get_string('manual_sendingmail', '', $a), false, false, true);
    $subject = "Notice: You now able to access IPD Online";

    //directly email rather than using the messaging system to ensure its not routed to a popup or jabber
    return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
}
