<?php

require('../config.php');

//arizanabdullah
/// Define variables used in page
$site = get_site();

$fullpackagesubscibe = get_string("fullpackagesubscibe");
$PAGE->navbar->add($fullpackagesubscibe);

$PAGE->set_title("$site->fullname: $fullpackagesubscibe");
$PAGE->set_heading("$site->fullname");

echo $OUTPUT->header();

if (!isloggedin()){
	echo "<div style='width:90%; margin-left:auto; margin-right:auto;'>";
	include('subscribe/full_package.php');
	echo '</div><br/>';
}else{
	redirect(new moodle_url('../index.php'));
}

echo $OUTPUT->footer();
