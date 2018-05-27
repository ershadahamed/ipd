<?php
    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('manualdbconfig.php'); 

	$site = get_site();
	
	$purchase='Purchase a curriculum';
	$title="$SITE->shortname: Courses - ".$purchase;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('courses');

	echo $OUTPUT->header();		
	if (isloggedin()) {
		add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
		
		echo $OUTPUT->heading($purchase, 2, 'headingblock header');
		include('userfrontpage/availablecourse.php');
	}	
	echo $OUTPUT->footer();	
?>