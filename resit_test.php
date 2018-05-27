<?php

require_once('config.php');
require_once($CFG->libdir . '/datalib.php');
require_once('lib.php');

include('manualdbconfig.php');
$uid = optional_param('userid', '', PARAM_INT);


$PAGE->set_url('/');
$PAGE->set_course($SITE);

$emailactivitys = get_string('testresit');
$url = new moodle_url('/resit_test.php');
$PAGE->navbar->add(ucwords(strtolower($emailactivitys)), $url);

$PAGE->set_pagetype('site-index');
$editing = $PAGE->user_is_editing();
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('buy_a_cifa');

echo $OUTPUT->header();
// echo date('d/m/Y', time());
echo $OUTPUT->heading(get_string('testresit'));
$userrole = get_rolename();

$courseid = '32';
$testid = '64';
$examid = '26'; // quiz id
//$grade = '60'; //mmn off to set passing mark 60/75


// days in month // calculate days
$days = daysina_month();

$qry1 = "SELECT id FROM mdl_cifaenrol WHERE courseid = '" . $courseid . "'";
$sql1 = mysql_query($qry1);
$rs = $DB->get_record_sql($qry1);
$courseenrolid = $rs->id;

$qry2 = "SELECT a.status, b.orgtype, a.enrolid, b.firstaccess,b.lastaccess,b.firstname, b.lastname, b.traineeid,a.userid,a.timestart,a.timeend,b.lastlogin, a.lastaccess as courselastaccess,
                FROM_UNIXTIME(b.firstaccess,'%d/%m/%Y') as startdate, 
                FROM_UNIXTIME(b.timecreated,'%d/%m/%Y') as timecreated, 
                DATE_ADD(FROM_UNIXTIME(a.timeend,'%Y-%m-%d'), INTERVAL $days DAY) as courseexpirydate_update,
                DATE_ADD(FROM_UNIXTIME(b.firstaccess,'%Y-%m-%d'), INTERVAL 60 DAY) as enddate, 
                DATE_ADD(FROM_UNIXTIME(b.timecreated,'%Y-%m-%d'), INTERVAL 120 DAY) as lasttimecreated, b.email 
                FROM mdl_cifauser_enrolments a, mdl_cifauser b 
                WHERE a.enrolid='" . $rs->id . "' AND b.traineeid LIKE 'A%' AND (b.usertype='" . $userrole . "' OR b.usertype='Inactive candidate') AND b.deleted!='1'
                AND a.userid=b.id ORDER BY b.firstaccess DESC";
$getdata = $DB->get_recordset_sql($qry2);

$table = new html_table();
$table->width = "100%";
$table->head = array(get_string('candidateid'), get_string('candidatename'), get_string('email'), 'Course Start Date', 'Course End Date', get_string('teststatus'), get_string('testresit'));
$table->align = array("center", "left", "left", "center", "center", "center");
$bil = '1';
foreach ($getdata as $list) {
$qryge = "SELECT a.orgtype FROM mdl_cifauser a, mdl_cifaorganization_type b
					 where a.id='".$list->userid."' AND a.orgtype=b.id AND b.name LIKE '%ADIB%'";
				$sqlge = mysql_query($qryge);
				$rsge = mysql_fetch_array($sqlge);
				$rowge = mysql_num_rows($sqlge);
				
				$qryed = "SELECT * FROM mdl_cifaquiz_grades WHERE quiz='26' AND userid='".$list->userid."' AND timemodified>'1455494400'";
				$sqled = mysql_query($qryed);
				$rsed = mysql_fetch_array($sqled);
				$rowed = mysql_num_rows($sqled);
				if($rowed>0){
					if($rowge>0){
						$grade = 75;
					}else{
						$grade = 60;
					}
				}else{
					$grade = 60;
				}
				
    $splitdate = explode('-', $list->courseexpirydate_update);  // after resit, date will be extend 1 month
    $newenddate = $splitdate['2'] . "/" . $splitdate['1'] . "/" . $splitdate['0'];
    $enrolstatus = $list->status;

    $splitlasttimecreated = explode('-', $list->lasttimecreated);
    $lasttimecreated = $splitlasttimecreated['2'] . "/" . $splitlasttimecreated['1'] . "/" . $splitlasttimecreated['0'];

    $today = strtotime('now');
    $sebulan = strtotime(date('d-m-Y H:i:s', $list->firstaccess) . "- 30 day");
    $hours = strtotime(date('d-m-Y H:i:s', $list->firstaccess) . "- 48 hours");
    $fullname = $list->firstname . ' ' . $list->lastname;       // user fullname
    $startdate = date('d/m/Y', $list->timestart);               // course start date
    // course expiry date
    if ($list->timeend) {
        $enddate = date('d/m/Y', $list->timeend);
    } else {
        $enddate = get_string('never');
    }

    // course status
    //$coursestatus = coursestatus_resit($enrolstatus);
    // Test status
    $teststatus = teststatus_resit($examid, $list->userid);

    $testexpirydate = testexpirydate($list->userid, 64);
    $testresult_resit = testresult_resit($examid, $list->userid, $grade, $list->timeend);

    // START test resit 
    $resittest = '<form method="post">';

    $sql = "Select  COUNT(DISTINCT a.id),
                                b.userid,
                                c.grade,b.quiz as attemptquizid,
                                a.name, a.id
                              From
                                mdl_cifaquiz a Inner Join
                                mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
                                mdl_cifaquiz_grades c On b.userid = c.userid And b.quiz = c.quiz
                              Where
                                a.id = '" . $examid . "' And b.userid = '" . $list->userid . "' And c.grade < '" . $grade . "'";
    $data2 = $DB->get_record_sql($sql);
    $crecords = $DB->count_records_sql($sql);

    // Jika reset adalah user yg betul
    $alerttextmessage = get_string('resitmessagetext');
    if (!empty($uid)) {
        if ($uid == $list->userid) {
            $newexpirydate = strtotime("+$days day");

            //update expiry date course && Final Test
            if ((time() >= $list->timeend)) {
                update_expirydate($courseenrolid, $newexpirydate, $list->userid, $testid, $testexpirydate);
            }

            // delete record jika attempts has been limit(2)
            if (!empty($data2->attemptquizid)) {
                $resittest.=$uid . $data2->attemptquizid;
                $del1 = $DB->delete_records('quiz_attempts', array('userid' => $data2->userid, 'quiz' => $data2->attemptquizid));
                $del2 = $DB->delete_records('quiz_grades', array('userid' => $data2->userid, 'quiz' => $data2->attemptquizid));
            }

            $homeurl = $CFG->wwwroot . '/resit_test.php';
            echo "<script>window.alert('" . $alerttextmessage . "')</script>";
            die("<script>location.href = '" . $homeurl . "'</script>");
        }
    }

    // show button if grade below 60 // expired date // 
    $resittest .= '<input type="hidden" name="userid" id="userid" value="' . $list->userid . '" />';
    if ((time() >= $list->timeend)) {
        // Not Valid
        if (!empty($crecords)) {
            //FAIL
            $resittest .= '<input type="submit" name="resittest" id="resittest" value="Re-sit" />';
        } else {
            // PASS
            if ($testresult_resit == get_string('passed')) {
                $resittest .= '-';
            } else {
                $resittest .= '<input type="submit" name="resittest" id="resittest" value="Re-sit" />';
            }
        }
    } else {
        // Valid
        if (!empty($crecords)) {
            //FAIL
            $resittest .= '<input type="submit" name="resittest" id="resittest" value="Re-sit" />';
        } else {
            $resittest .= '-';
        }
    }

    $resittest .= '</form>';
    // END resit test
    // Collect data for table
    $table->data[] = array(
        $list->traineeid, $fullname, $list->email, $startdate, $enddate, $testresult_resit, $resittest
    );
}
// display table here
if (!empty($table)) {
    echo html_writer::table($table);
}
$getdata->close();

/*
  ?>





  <table border="1" style="border-collapse: collapse; width:98%;" >
  <tr>
  <td>No</td>
  <td>Candidate ID</td>
  <td>Candidate Name</td>
  <td>Email</td>
  <td style="text-align:center; vertical-align: middle;">Course Start Date</td>
  <td style="text-align:center; vertical-align: middle;">Course Expiry Date</td>
  <td style="text-align:center; vertical-align: middle;">Course Status</td>
  <td style="text-align:center; vertical-align: middle;">Test Status</td>
  <td style="text-align:center; vertical-align: middle;">Status</td>
  <td style="text-align:center; vertical-align: middle;">Test Re-sit </td>
  </tr>
  <?php
  /* $courseid = '32';
  $examid = '26';
  $grade = '60';

  $qry1 = "SELECT id FROM mdl_cifaenrol WHERE courseid = '" . $courseid . "'";
  $sql1 = mysql_query($qry1); *//*
  while ($rs1 = mysql_fetch_array($sql1)) {
  $qry2 = "SELECT a.status, b.orgtype, a.enrolid, b.firstaccess,b.lastaccess,b.firstname, b.lastname, b.traineeid,a.userid,a.timestart,a.timeend,b.lastlogin, a.lastaccess as courselastaccess,
  FROM_UNIXTIME(b.firstaccess,'%d/%m/%Y') as startdate,
  FROM_UNIXTIME(b.timecreated,'%d/%m/%Y') as timecreated,
  DATE_ADD(FROM_UNIXTIME(b.firstaccess,'%Y-%m-%d'), INTERVAL 60 DAY) as enddate,
  DATE_ADD(FROM_UNIXTIME(b.timecreated,'%Y-%m-%d'), INTERVAL 120 DAY) as lasttimecreated, b.email
  FROM mdl_cifauser_enrolments a, mdl_cifauser b
  WHERE a.enrolid='" . $rs1['id'] . "' AND (b.usertype='" . $userrole . "' OR b.usertype='Inactive candidate') AND b.deleted!='1'
  AND a.userid=b.id ORDER BY b.firstaccess DESC";
  //AND b.timestart=0
  $sql2 = mysql_query($qry2);
  $bil = '1';
  while ($rs2 = mysql_fetch_array($sql2)) {
  $splitdate = explode('-', $rs2['enddate']);
  $newenddate = $splitdate['2'] . "/" . $splitdate['1'] . "/" . $splitdate['0'];
  $enrolstatus = $rs2['status'];

  $splitlasttimecreated = explode('-', $rs2['lasttimecreated']);
  $lasttimecreated = $splitlasttimecreated['2'] . "/" . $splitlasttimecreated['1'] . "/" . $splitlasttimecreated['0'];

  $today = strtotime('now');
  $sebulan = strtotime(date('d-m-Y H:i:s', $rs2['firstaccess']) . "- 30 day");
  $hours = strtotime(date('d-m-Y H:i:s', $rs2['firstaccess']) . "- 48 hours");
  ?>
  <?php if (($rs2['firstaccess'] <= $sebulan)) { ?>
  <tr style="background-color: #F7CF07;">
  <?php } else if (($rs2['firstaccess'] <= $hours)) { ?>
  <tr style="background-color: #00FF00;"><?php } ?>
  <td><?= $bil++; ?></td>
  <td><?= strtoupper($rs2['traineeid']); ?></td>
  <td><?= $rs2['firstname'] . ' ' . $rs2['lastname']; ?></td>
  <td><?= $rs2['email']; ?></td>
  <td style="text-align:center; vertical-align: middle;"><?= date('d/m/Y', $rs2['timestart']); ?></td>
  <td style="text-align:center; vertical-align: middle;">
  <?php
  if ($rs2['timeend']) {
  echo date('d/m/Y', $rs2['timeend']);
  } else {
  echo get_string('never');
  }
  ?>
  </td>
  <td style="text-align:center; vertical-align: middle;">
  <?php
  switch ($enrolstatus) {
  case -1:
  echo 'No Change';
  break;
  case 0:
  echo 'Active';
  break;
  case 1:
  echo 'Inactive';
  break;
  }
  ?>
  </td>
  <td style="text-align:center;">
  <?php
  $sql = "Select
  COUNT(DISTINCT b.attempt)
  From
  mdl_cifaquiz a Inner Join
  mdl_cifaquiz_attempts b On a.id = b.quiz
  Where
  a.id='" . $examid . "' AND b.userid = '" . $rs2['userid'] . "'";

  $c = $DB->count_records_sql($sql);
  if ($c >= 1) {
  if ($c == 2) {
  echo 'Close';
  }
  if ($c == 1) {
  echo $c . ' attempt';
  }
  } else {
  echo $c = '0pen';
  }
  ?>
  </td>
  <td>

  </td>
  <td style="text-align:center; vertical-align: middle;">
  <form method="post">
  <?php
  $sql = "Select
  b.userid,
  c.grade,b.quiz as attemptquizid,
  a.name
  From
  mdl_cifaquiz a Inner Join
  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
  mdl_cifaquiz_grades c On b.userid = c.userid And b.quiz = c.quiz
  Where
  a.id = '" . $examid . "' And b.userid = '" . $rs2['userid'] . "' And c.grade < '" . $grade . "'";
  $data2 = $DB->get_record_sql($sql);
  $agrade = $data2->grade;

  // Jika reset adalah user yg betul
  if (!empty($uid)) {
  if ($uid == $data2->userid) {

  //$del1 = $DB->delete_records('quiz_attempts', array('userid' => $data2->userid, 'quiz' => $data2->attemptquizid));
  //$del2 = $DB->delete_records('quiz_grades', array('userid' => $data2->userid, 'quiz' => $data2->attemptquizid));

  $homeurl = $CFG->wwwroot . '/resit_test.php';
  //die("<script>location.href = '" . $homeurl . "'</script>");
  }
  }

  // show button if grade below 60
  if ($agrade) {
  echo '<input type="hidden" name="userid" id="userid" value="' . $rs2['userid'] . '" />';
  echo '<input type="submit" name="resittest" id="resittest" value="Re-sit" />';
  } else {
  echo '-';
  }
  ?>
  </form>
  </td>
  </tr>
  <?php
  } //end of loop user list
  } //end of loop enrolment method for foundation.
  ?>
  </table>
  <?php */
echo $OUTPUT->footer();
