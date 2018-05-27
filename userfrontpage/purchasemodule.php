<?php
    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('manualdbconfig.php'); 
	
	if (isloggedin()) {
		add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
	
		$title="$SITE->shortname: Courses";
		$PAGE->set_title($title);
		$PAGE->set_heading($site->fullname);
		$PAGE->set_pagelayout('frontpage');

		echo $OUTPUT->header();	
		
		include('userfrontpage/availablecourse.php');
		echo $OUTPUT->footer();	
	}	
?>