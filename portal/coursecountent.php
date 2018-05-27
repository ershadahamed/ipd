<?php

require('../config.php');

//arizanabdullah
/// Define variables used in page
$site = get_site();

$coursesubscibe = get_string("coursecontentsubscibe");
$PAGE->navbar->add($coursesubscibe);

$PAGE->set_title("$site->fullname: $coursesubscibe");
$PAGE->set_heading("$site->fullname");

echo $OUTPUT->header();

if (!isloggedin()){
	echo "<div style='width:90%; margin-left:auto; margin-right:auto;'>";
	include('subscribe/course_content.php');
	echo '</div><br/>';
}

echo $OUTPUT->footer();
