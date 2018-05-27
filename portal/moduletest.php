<?php

require('../config.php');

//arizanabdullah
/// Define variables used in page
$site = get_site();

$moduletestsubscibe = get_string("moduletestsubscibe");
$PAGE->navbar->add($moduletestsubscibe);

$PAGE->set_title("$site->fullname: $moduletestsubscibe");
$PAGE->set_heading("$site->fullname");

echo $OUTPUT->header();

if (!isloggedin()){
	echo "<div style='width:90%; margin-left:auto; margin-right:auto;'>";
	include('subscribe/module_test.php');
	echo '</div><br/>';
}

echo $OUTPUT->footer();
