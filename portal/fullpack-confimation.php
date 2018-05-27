<?php

/*require('../../config.php');

//arizanabdullah
/// Define variables used in page
$site = get_site();

$fullpackagesubscibe = get_string("fullpackagesubscibe");
$fullpackagesubscibeform = get_string("fullpackagesubscibeform");
$fullpackagesubscibeinfo = 'Confirmation';

$PAGE->navbar->add($fullpackagesubscibe, new moodle_url('/portal/index.php'));
$PAGE->navbar->add($fullpackagesubscibeform);
$PAGE->navbar->add($fullpackagesubscibeinfo);

$PAGE->set_title("$site->fullname: $fullpackagesubscibe");
$PAGE->set_heading("$site->fullname");

echo $OUTPUT->header();*/

/*if (!isloggedin()){
	echo "<div style='width:90%; margin-left:auto; margin-right:auto;'>";
	
	//***************************************check if user already enroll**********************************
	include('../../manualdbconfig.php');
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
	
	/*$sqlCheck2=mysql_query("
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
		include('subscribe/fullpack-confimation-info.php');
	}*/
	//********************************************end check************************************************
	
	//echo '</div><br/>';
//}
///include('subscribe/fullpack-confimation-info.php');
///include('subscribe/pageconfig/paymentFooter.php'); 
//echo $OUTPUT->footer();
