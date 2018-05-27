<?php

require('../config.php');

//arizanabdullah
/// Define variables used in page
$site = get_site();

$moduletestsubscibe = get_string("moduletestsubscibe");
$moduletestsubscibeform = get_string("moduletestsubscibeform");
$moduletestsubscibeconfrim = get_string("moduletestsubscibeconfrim");

$PAGE->navbar->add($moduletestsubscibe, new moodle_url('/portal/moduletest.php?module-test'));
$PAGE->navbar->add($moduletestsubscibeform);
$PAGE->navbar->add($moduletestsubscibeconfrim);

$PAGE->set_title("$site->fullname: $moduletestsubscibeconfrim");
$PAGE->set_heading("$site->fullname");

echo $OUTPUT->header();

if (!isloggedin()){
	echo "<div style='width:90%; margin-left:auto; margin-right:auto;'>";
	include('subscribe/moduleConfirmDetails.php');
	echo '</div><br/>';
}

echo $OUTPUT->footer();
