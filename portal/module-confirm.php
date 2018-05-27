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
	
	//***************************************check if user already enroll**********************************
	include('../manualdbconfig.php');
	$id=$_POST['id'];
	$traineeID=$_POST['traineeid'];
	
	/*$sqlCheck2=mysql_query("
						Select
						  *					  
						From
						  mdl_cifauser_enrolments a,
						  mdl_cifaenrol b,
						  mdl_cifauser c
						Where					  
						  b.id = a.enrolid And 
						  c.id=a.userid And
						  b.courseid = '$id'
	");*/
	
	$sqlCheck2=mysql_query("
						Select
						  *
						From
						  mdl_cifauser_enrolments a,
						  mdl_cifaenrol b,
						  mdl_cifauser c,
						  mdl_cifa_modulesubscribe d
						Where
						  b.id = a.enrolid And
						  c.id = a.userid And
						  b.courseid = d.courseid And
						  c.traineeid = d.traineeid And
						  (b.courseid = '$id')
	");	
	$rowCheck2=mysql_fetch_array($sqlCheck2);
		
	if($rowCheck2['traineeid'] == $traineeID){
		echo"<center>You already enroll on this course. Thank you</center><br/>";
	}
	else
	{	
		include('subscribe/moduleConfirm.php');
	}
	//********************************************end check************************************************
	
	echo '</div><br/>';
}

echo $OUTPUT->footer();
