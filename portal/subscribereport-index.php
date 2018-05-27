<?php

require('../config.php');

//arizanabdullah
/// Define variables used in page
$site = get_site();

$subscibeReport = 'Online course subscription report';
//$fullpackagesubscibeform = get_string("fullpackagesubscibeform");
//$fullpackagesubscibeconfrim = get_string("fullpackagesubscibeconfrim");

$PAGE->navbar->add($subscibeReport);
//$PAGE->navbar->add($fullpackagesubscibeform);
//$PAGE->navbar->add($fullpackagesubscibeconfrim);

$PAGE->set_title("$site->fullname: $subscibeReport");
$PAGE->set_heading("$site->fullname");

echo $OUTPUT->header();

if (!isloggedin()){
	echo "<div style='width:90%; margin-left:auto; margin-right:auto;'>";
	include('subscribereport.php');
	echo '</div><br/>';
}

echo $OUTPUT->footer();
