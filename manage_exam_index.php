<?php
    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');

    if ($CFG->forcelogin) {
        require_login();
    } else {
        user_accesstime_log();
    }

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
	$PAGE->set_heading($SITE->fullname);
	
	//header
    echo $OUTPUT->header();

	//content area
	echo $OUTPUT->heading(get_string('manageexamcentre'), 2, 'headingblock header');
	include('manageExam/manage_exam.php');

    echo '<br />';
	//end content area
	
	//footer
    echo $OUTPUT->footer();
