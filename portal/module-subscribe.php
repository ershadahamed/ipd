<?php

require('../config.php');

//arizanabdullah
/// Define variables used in page
$site = get_site();

$moduletestsubscibe = get_string("moduletestsubscibe");
$moduletestsubscibeform = get_string("moduletestsubscibeform");

$PAGE->navbar->add($moduletestsubscibe);
$PAGE->navbar->add($moduletestsubscibeform);

$PAGE->set_title("$site->fullname: $moduletestsubscibeform");
$PAGE->set_heading("$site->fullname");

echo $OUTPUT->header();

if (!isloggedin()){
	echo "<div style='width:90%; margin-left:auto; margin-right:auto;'>";
	include('subscribe/module-subscribe-details.php');
	echo '</div><br/>';
}

echo $OUTPUT->footer();
