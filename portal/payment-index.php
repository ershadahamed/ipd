<?php

require('../config.php');

//arizanabdullah
/// Define variables used in page
$site = get_site();

$fullpackagesubscibe = get_string("fullpackagesubscibe");
$fullpackagesubscibeform = get_string("fullpackagesubscibeform");

$PAGE->navbar->add($fullpackagesubscibe, new moodle_url('/portal/index.php'));
$PAGE->navbar->add($fullpackagesubscibeform);

$PAGE->set_title("$site->fullname: $fullpackagesubscibe");
$PAGE->set_heading("$site->fullname");

echo $OUTPUT->header();
echo "<div style='width:90%; margin-left:auto; margin-right:auto;'>";
if (!isloggedin()){
	include('subscribe/paydetails.php');
}else{
	include('subscribe/paydetails_loggeduser.php');
}
echo '</div><br/>';
echo $OUTPUT->footer();
