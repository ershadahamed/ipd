<?php
require('../config.php');

//arizanabdullah
/// Define variables used in page
$site = get_site();

$fullpackagesubscibe = get_string("fullpackagesubscibe");
$fullpackagesubscibeform = get_string("fullpackagesubscibeform");
$fullpackagesubscibeconfrim = get_string("fullpackagesubscibeconfrim");

$PAGE->navbar->add($fullpackagesubscibe, new moodle_url('/portal/index.php'));
$PAGE->navbar->add($fullpackagesubscibeform);
$PAGE->navbar->add($fullpackagesubscibeconfrim);

$PAGE->set_title("$site->fullname: $fullpackagesubscibe");
$PAGE->set_heading("$site->fullname");

echo $OUTPUT->header();

if (!isloggedin()){
	echo "<div style='width:90%; margin-left:auto; margin-right:auto;'>";
	include('subscribe/subscribedetails.php');
	//include('subscribe/paypal-test.php');
	echo '</div><br/>';
}

echo $OUTPUT->footer();
