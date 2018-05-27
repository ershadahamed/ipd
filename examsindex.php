<?php
    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');

	session_start();
	$_SESSION['page_ul'] = 'exams';	
	
	$site = get_site();	
	
	$title="$SITE->shortname: Exams";
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);

	echo $OUTPUT->header();
	include_once('exams.php'); 
	echo $OUTPUT->footer();
?>