<?php
require_once('../config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/filelib.php');
require_once("$CFG->libdir/excellib.class.php");
require_once($CFG->libdir . '/logactivity_lib.php');
include('../manualdbconfig.php');

$reportid = optional_param('rid', 0, PARAM_INT);        // get report ID
$rcid = optional_param('rcid', 0, PARAM_INT);
$sid = optional_param('sid', 0, PARAM_INT);             // get selected report ID
$checkBox = optional_param('checktoken', '', PARAM_INT);

$url = array();
$url[] = $CFG->wwwroot . '/examcenter/reportview.php?id=' . $reportid . '&sid=' . $sid;
$url[] = $CFG->wwwroot . '/examcenter/reportview.php?id=' . $reportid . '&sid=' . $sid . '&download=1';

$srid = array();   // Selected report ID
$srid[] = '0';
$srid[] = '1';
$srid[] = '2';

$headers = array();
$profileheaders = array();

if ($checkBox == '') {
    ?>
    <script language="javascript">
        window.alert("Please tick at lease one user to download.");
        window.location.href = '<?= $url[0]; ?>';
    </script>
    <?php
}

if ($checkBox != '') {
    $gns = get_reportdetails($reportid);
    if ($sid != $srid[2]) {
        if ($gns->organizationname) {
            $headers[] = get_string('organization');
            $profileheaders[] = $c;
        }
        if ($gns->employeeid) {
            $headers[] = get_string('employeeid');
            $profileheaders[] = $c;
        }
        if ($gns->usersid) {
            $headers[] = get_string('candidateid');
            $profileheaders[] = $c;
        }
        if ($gns->cnameusers) {
            $headers[] = get_string('fullname');
            $profileheaders[] = $c;
        }
        if ($gns->usersemail) {
            $headers[] = get_string('email');
            $profileheaders[] = $c;
        }
        if ($gns->usersaddress) {
            $headers[] = get_string('address');
            $profileheaders[] = $c;
        }
        if ($gns->usersphone) {
            $headers[] = get_string('officetel');
            $profileheaders[] = $c;
        }
        if ($gns->designation) {
            $headers[] = get_string('designation');
            $profileheaders[] = $c;
        }
        if ($gns->department) {
            $headers[] = get_string('department');
            $profileheaders[] = $c;
        }
    }
    if ($sid == $srid[0]) {
        if ($gns->curriculumname) {
            $headers[] = get_string('coursetitle');
        }
        if ($gns->curriculumcode) {
            $headers[] = get_string('coursecode');
        }
        if ($gns->performancestatus) {
            $headers[] = get_string('status');
        }
        if ($gns->modulecompleted) {
            $headers[] = get_string('modulecompleted');
        }
        if ($gns->totaltimeperformance) {
            $headers[] = get_string('totaltime');
        }
        if ($gns->examinationstatus) {
            $headers[] = get_string('teststatus');
        }
        if ($gns->markperformance) {
            $headers[] = get_string('marks');
        }
        if ($gns->subscriptiondate) {
            $headers[] = get_string('subscriptiondate');
        }
        if ($gns->expirydate) {
            $headers[] = get_string('expirydate');
        }
        if ($gns->lastaccess) {
            $headers[] = get_string('lastaccess');
        }
    } else if ($sid == $srid[1]) {
        if ($row['Field'] == 'cnameexam') {
            $headers[] = get_string('coursetitle');
        }
        if ($gns->ccodeexam) {
            $headers[] = get_string('coursecode');
        }
        if ($gns->cattempts) {
            $headers[] = get_string('testattempts');
        }
        if ($gns->learningoutcomes) {
            $headers[] = get_string('lo');
        }
        if ($gns->scoreonlo) {
            $headers[] = get_string('scorelo');
        }
        if ($gns->passes) {
            $headers[] = get_string('passes');
        }
        if ($gns->passrate) {
            $headers[] = get_string('passrate');
        }
    } else if ($sid == $srid[2]) {
        if ($gns->cname_statistics) {
            $headers[] = get_string('coursetitle');
        }
        if ($gns->ccode_statistics) {
            $headers[] = get_string('coursecode');
        }
        if ($gns->statusstistics) {
            $headers[] = get_string('status');
        }
        if ($gns->mcomplete_statistics) {
            $headers[] = get_string('modulecompleted');
        }
        if ($gns->totaltime_statistics) {
            $headers[] = get_string('teststatus');
        }
        if ($gns->examstatus_statistics) {
            $headers[] = get_string('totaltime');
        }
    }
    $colsprofile = count($profileheaders);    // count profile column

    $filename = "report_excel";
    $excel_filename = clean_filename($filename . '-' . date('Ymd') . '-' . time('now') . '.xls');
    // Creating a workbook
    $workbook = new MoodleExcelWorkbook("-");
    // Sending HTTP headers
    $workbook->send($excel_filename);
    // Creating the first worksheet
    $sheettitle = $excel_filename;
    $myxls = & $workbook->add_worksheet($sheettitle);
    // format types
    $format = & $workbook->add_format();
    $format->set_bold(0);
    $format->set_border(1);
    $format->set_align('left');

    $formattitle = & $workbook->add_format();
    $formattitle->set_bold(1);

    $formatbc = & $workbook->add_format();
    $formatbc->set_bold(1);
    $formatbc->set_align('merge');
    $formatbc->set_border(1);
    $formatbc->set_right(1);

    $formatheader = & $workbook->add_format();
    $formatheader->set_bold(1);
    $formatheader->set_align('left');
    $formatheader->set_border(1);

    // Merge cell
    $myxls->merge_cells(0, 0, 0, 1);
    $myxls->merge_cells(1, 0, 1, 1);
    $myxls->merge_cells(3, 0, 3, $colsprofile - 1);
    $myxls->merge_cells(3, $colsprofile, 3, count($headers) - 1);

    $border = & $workbook->add_format();
    $border->set_right(1);
    $border->set_bottom(1);
    $border->set_top(1);
    $border->set_left(1);
    $border->set_border(1);
    $border->set_bold(1);
    $border->set_h_align('merge');

    $t = count($headers) - 1;
    $myxls->set_column(0, $t, 30);

    $myxls->write(0, 0, "Report title: " . strtoupper($gns->reportname), $formattitle);
    $myxls->write(1, 0, "Created By: " . ucwords(strtolower(get_reportcreator($rcid))) . ", " . date('d/m/Y h:i:s', $gns->timecreated) . "", $formattitle);

    $myxls->write(3, 0, "Candidate Profile", $border);
    $myxls->write(3, $colsprofile, "Candidate Performance", $border);

    // set header here!
    $colnum = 0;
    foreach ($headers as $item) {
        $myxls->write(4, $colnum, $item, $formatheader);
        $colnum++;
    }
    $rownum = 5;

// Content start here!!!
    for ($i = 0; $i < sizeof($checkBox); $i++) {
        $statement = "
            mdl_cifacourse a Inner Join
            mdl_cifaenrol b On a.id = b.courseid Inner Join
            mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
            mdl_cifareport_users d On c.userid = d.candidateid Inner Join
            mdl_cifauser e On d.candidateid = e.id And c.userid = e.id
";

        if ($sid == $srid[0]) {
            $statement.=" WHERE a.category = '1' And d.reportid = '" . $reportid . "' And a.visible != '0' And c.id='" . $checkBox[$i] . "'";
            $statement.=" Group by b.courseid, d.candidateid";
            $sql = "SELECT *, a.idnumber as code,c.lastaccess as courselastaccess  FROM {$statement}";
        } else if ($sid == $srid[1]) {
            $statement = "
				  mdl_cifaquiz a Inner Join
				  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
				  mdl_cifacourse c On a.course = c.id Inner Join
				  mdl_cifauser d On b.userid = d.id Inner Join
				  mdl_cifareport_users e On e.candidateid = d.id
				";
            $statement.=" WHERE  c.visible = '1' And c.category = '3' And b.quiz='" . $checkBox[$i] . "' And e.reportid = '" . $reportid . "'";
            $statement.=" Group by b.quiz, b.userid";
            $sql = "SELECT *, c.idnumber as code, a.name As testname, a.id As quizattemptid FROM {$statement}";
        } else if ($sid == $srid[2]) {
            $statement.=" WHERE a.category = '1' And a.idnumber='" . $checkBox[$i] . "' And d.reportid = '" . $reportid . "' And a.visible != '0'";
            $statement.=" Group By b.courseid";
            $sql = "SELECT *, c.id as enrollmentid, a.idnumber as coursecode FROM {$statement}";
        }

        $results = $DB->get_recordset_sql($sql);
        foreach ($results as $data) {
            $candidatefullname = $data->firstname . ' ' . $data->lastname;

            $FA1 = explode(",", $data->address);
            $address1 = $FA1[0] . $FA1[2] . $FA1[3];
            $FA2 = explode(",", $data->address2);
            $address2 = $FA2[0] . $FA2[2] . $FA2[3];
            $FA3 = explode(",", $data->address3);
            $address3 = $FA3[0] . $FA3[2] . $FA3[3];
            $fulladdress = $address1 . $address2 . $address3 . " " . $data->postcode . " " . $data->city . " " . $data->state . " " . $data->country;

            $countrylist = $DB->get_record('country_list', array('countrycode' => $data->country));
            $qryOrg = $DB->get_record('organization_type', array('id' => $data->orgtype));
            $rsOrgName = $qryOrg->name . ' ' . $countrylist->countryname;
            $cphoneno = '+' . $countrylist->iso_countrycode . $data->phone1;    // phone no

            if ($data->department) {
                $rsdepartment = $data->department;
            } else {
                $rsdepartment = " - ";
            }  // department

            if ($data->designation) {
                $rsdesignation = $data->designation;
            } else {
                $rsdesignation = " - ";
            }  // designation

            if ($data->access_token) {
                $rsaccess_token = $data->access_token;
            } else {
                $rsaccess_token = " - ";
            }  // Employee ID    

            if ($sid == $srid[0]) {
                $sqltestcode = mysql_query("
                    Select
                      a.name,
                      a.course,
                      b.idnumber,
                      a.id as quizattemptsid,
                      a.attempts
                    From
                      mdl_cifaquiz a Inner Join
                      mdl_cifacourse b On a.name = b.fullname 
                    Where
                      b.visible!='0' And a.name='" . $data->fullname . "'
                ");
                $testcodearray = mysql_fetch_array($sqltestcode);
                $cname = $testcodearray['name'];
                $cattempts = $testcodearray['attempts'];
                $ccode = ucwords(strtoupper($testcodearray['idnumber']));

                $sgrade = mysql_query("
                            Select
                              *,
                              a.grade As usergrade, b.id As quizid
                            From
                              mdl_cifaquiz_grades a,
                              mdl_cifaquiz b Inner Join
                              mdl_cifacourse c On b.course = c.id
                            Where
                              a.quiz = b.id And c.visible!='0' And
                              (c.category = '3' And
                              a.userid = '" . $data->userid . "')				
                        ");
                $cq = mysql_num_rows($sgrade); //count records	
                $qgrade = mysql_fetch_array($sgrade);

                //how to get grade
                $sselect = "
                    a.name,
                    a.id as quizattemptsid,
                    b.attempt,
                    c.grade as testgrade,
                    b.userid,
                    b.id As id1,
                    a.attempts,
                    a.course	
                ";
                $sstatement = "
                    mdl_cifaquiz a Inner Join
                    mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
                    mdl_cifaquiz_grades c On b.quiz = c.quiz And b.userid = c.userid
		";
                $sstatement.=" Where a.id = '" . $qgrade['quizid'] . "' And b.userid='" . $data->userid . "'";
                if ($cattempts == '1') {
                    $sstatement.=" And b.attempt = '1'";
                }
                if ($cattempts == '2') {
                    $sstatement.=" And b.attempt = '2'";
                }
                $sqltestgrade = mysql_query("Select {$sselect} From {$sstatement}");
                $testgraderow = mysql_num_rows($sqltestgrade);
                $testgrade = mysql_fetch_array($sqltestgrade);
                $finalgrade = $testgrade['testgrade'];

                // course status // subscribe or in progress or end
                if ($testgraderow != '0') {
                    $cstatus = 'Ended';
                } else {
                    if (!$data->timeclose || strtotime('now') < $data->timeclose) {
                        // The attempt is still in progress.
                        $cstatus = get_string('inprogress', 'quiz');
                    } else {
                        // $timetaken = format_time($sqlrow['timefinish'] - $sqlrow['timestart']);
                        $cstatus = userdate($data->timeclose);
                    }
                }

                // Marks %
                if ($testgraderow) {
                    $fgrade = round($finalgrade);
                } else {
                    $fgrade = '-';
                }

                // Module Completed
                $sqlcourse = $DB->get_record('course', array('idnumber' => $ccode, 'category' => '1'));

                // Completed Module here!!!!
                $rscc = printScormWithCourseId($data->courseid);
                $a = '0';
                foreach ($rscc as $r) {
                    // 
                    $sql = "Select COUNT(a.id)
                         From
                           {scorm_scoes_track} a
                         Where
                           a.userid='" . $data->userid . "' AND
                           a.scormid='" . $r->scorm . "' AND
                           a.value = 'completed'
                         ";
                    $rsql = $DB->count_records_sql($sql);
                    if ($rsql === chapteronscorm($r->scorm)) {
                        $a++;
                    }
                } $rscc->close();
                $mcompleted = $a . ' of ' . getTotalScormOnCourse($data->courseid) . ' Modules';

                // End Module Completed
                // total time accessing course
                // $totaltimeaccess=format_time($data['lastaccess'] - $data['timestart']);	
                if ($data->firstaccess) {
                    $totaltimeaccess = format_time(time() - $data->firstaccess);
                } else {
                    $totaltimeaccess = "0";
                }

                // Test (Status)
                if ($testgraderow != '0') {
                    if ($finalgrade < '60') {
                        $test_status = 'Fail';
                    } else {
                        $test_status = 'Pass';
                    }
                } else {
                    $test_status = '-';
                }

                //subscribe course date
                if ($data->firstaccess != '0') {
                    $subscriptiondate = date('d/m/Y', $data->timestart);
                } else {
                    $subscriptiondate = ' - ';
                }

                // course expiry date
                if ($data->firstaccess != '0') {
                    $courseexpirydate = date('d/m/Y', $data->timeend);
                } else {
                    $courseexpirydate = ' - ';
                }

                // last user access
                if ($data->firstaccess) {
                    $lastuseraccess = date('d/m/Y', $data->courselastaccess);
                } else {
                    $lastuseraccess = ' - ';
                }
            } else if ($sid == $srid[1]) {
                $cname = $data->testname;
                // $ccode=$data['code'];
                // display course code where coursefullname=testname
                $sqltestcode = mysql_query("
                    Select
                    a.name,
                    b.idnumber
                    From
                    mdl_cifaquiz a Inner Join
                    mdl_cifacourse b On a.name = b.fullname
                    Where
                    b.visible!='0' And a.name='" . $cname . "'
                ");
                $testcodearray = mysql_fetch_array($sqltestcode);
                $ccode = ucwords(strtoupper($testcodearray['idnumber']));

                //kira calon lulus
                $sgrade = mysql_query("
                    Select
                   * ,
                    a.grade As usergrade, b.id As quizid
                    From
                    mdl_cifaquiz_grades a,
                    mdl_cifaquiz b Inner Join
                    mdl_cifacourse c On b.course = c.id
                    Where
                    a.quiz = b.id And a.grade >= 60 And a.quiz = '" . $data->quizattemptid . "' And
                    (c.category = '3' And
                    a.userid = '" . $data->userid . "')
                ");
                $cq = mysql_num_rows($sgrade);

                // display candidate fullname n traineeid
                $st9 = "
                    a.userid,
                    a.quiz,
                    a.attempt,
                    b.firstname,
                    b.lastname,
                    c.reportid,
                    b.traineeid
                    ";
                $st10 = "
                    mdl_cifaquiz_attempts a Inner Join
                    mdl_cifauser b On a.userid = b.id Inner Join
                    mdl_cifareport_users c On c.candidateid = b.id
                ";
                $st10.=" Where a.quiz = '" . $data->quizattemptid . "' And c.reportid = '" . $reportid . "'";
                $st10.=" Group By a.userid";
                $sql10 = mysql_query("Select {$st9} From {$st10}");
                $sql11 = mysql_query("Select {$st9} From {$st10}");
                $sqla = mysql_num_rows($sql10);  // attempts
                // display learning outcome
                $losql = mysql_query("
                    Select
                    b.name,
                    b.course,
                    a.idnumber
                    From
                    mdl_cifacourse a Inner Join
                    mdl_cifascorm b On a.id = b.course
                    Where
                    a.idnumber = '" . $ccode . "' AND b.reference!='navigation_tips.zip'
                    Order By b.name
                ");
                $no = '1';
                $losqlcount = mysql_num_rows($losql);

                // candidate performance//total time
                // $totaltime = format_time($data['timefinish'] - $data['timestart']);
                if ($data->firstaccess) {
                    $totaltime = format_time(time() - $data->firstaccess);
                } else {
                    $totaltime = "0";
                }

                // candidate performance status
                if ($data->timefinish > 0) {
                    // attempt has finished
                    $datecompleted = 'Ended';
                } else if (!$data->timeclose || strtotime('now') < $data->timeclose) {
                    // The attempt is still in progress.
                    $datecompleted = get_string('inprogress', 'quiz');
                } else {
                    $timetaken = format_time($data->timefinish - $data->timestart);
                    $datecompleted = userdate($data->timeclose);
                }

                $estatus = "Pass";    // Examination Status// pass, fail, absent, expired
                $LO = "LO1";      // Learning Outcome
                $scoreLO = "80%";     // Score on LO
                $cattempts = $data['attempt'];  // Curriculum Attempts
                $passes = $cq;      // Passes
                // display passrate
                $countpassrate = ($cq / $sqla) * 100;
                $passrate = round($countpassrate) . '%';    // Passrate

                $sstatus = "Subscribed 10%<br/> In Progress 30%<br/> Completed 60%";    // Statistic Status
                $modulecompleted = "M01 - 50%<br/> M02 - 50%";         // Module Completed
                $examstatus = "Pass - 93%<br/> Fail - 5%<br/> Absent - 1%<br/> Expired - 1%";  // Exam Status
                // display learning outcome
                if ($losqlcount != '0') {
                    while ($lo = mysql_fetch_array($losql)) {
                        $lolist.=$lo['name'];
                    }
                    $lolist.='<br/>';
                } else {
                    echo ' - ';
                }
            }   // SID == 1 
            else if ($sid == $srid[2]) {
                //total user enroll courses
                $sqlstatus = mysql_query("
						Select
						  c.id As enrollmentid,
						  a.fullname,
						  a.idnumber,
						  b.id,
						  c.userid as statususerid
						From
						  mdl_cifacourse a Inner Join
						  mdl_cifaenrol b On a.id = b.courseid Inner Join
						  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
						  mdl_cifareport_users d On c.userid = d.candidateid Inner Join
						  mdl_cifauser e On d.candidateid = e.id
						Where
						  a.category = '1' And
						  d.reportid = '" . $data->reportid . "' And
						  a.visible != '0' And c.enrolid='" . $data->enrolid . "'	
					");
                $sqlstatusrow = mysql_num_rows($sqlstatus); // echo $data['enrolid'].'<br/>';

                $cname = $data->fullname;
                $ccode = $data->coursecode;

                // display learning outcome
                $losql = mysql_query("
						Select
						  b.name,
						  b.course,
						  a.idnumber,
						  b.reference
						From
						  mdl_cifacourse a Inner Join
						  mdl_cifascorm b On a.id = b.course
						Where
						  a.idnumber = '" . $data->coursecode . "' AND b.reference!='navigation_tips.zip'	
						Order By b.name
					");
                $no = '1';
                $losqlcount = mysql_num_rows($losql);
                // END display learning outcome	
                // total active users
                $sqlusers = mysql_query("SELECT * FROM {$CFG->prefix}user WHERE confirmed='1' AND deleted!='1' AND usertype='Active Candidate'");
                $sqlusersrow = mysql_num_rows($sqlusers);

                // total users enrol test
                $sqltestcheck = mysql_query("
						Select
						  a.name,
						  b.userid,
						  c.grade
						From
						  mdl_cifaquiz a Inner Join
						  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
						  mdl_cifaquiz_grades c On b.userid = c.userid And b.quiz = c.quiz
						Where
						  a.name = '" . $data->fullname . "' 
						Group By a.id, b.userid
					");
                $sqltestrow = mysql_num_rows($sqltestcheck);
                $inprogress = (($sqlstatusrow - $sqltestrow) / $sqlstatusrow) * 100;
                $completed = ($sqltestrow / $sqlstatusrow) * 100;
                $subscribed = ($sqlstatusrow / $sqlusersrow) * 100; // jum. enroll courses bahagi jum. user

                $statusenrollment = "Subscribed - " . $subscribed . "% <br/>";
                $statusenrollment.="In Progress - " . $inprogress . "% <br/>";
                $statusenrollment.="Completed - " . $completed . "%<br/>";

                // display module completed %
                if ($losqlcount != '0') {
                    $bil = '1';
                    while ($lo = mysql_fetch_array($losql)) {
                        //echo $lolist=$lo['name'];
                        //echo $lolist='- %';
                        $no = $bil++;
                        if ($no < '10') {
                            $a = '0';
                        }

                        ////////	
                        $moduleselect = " a.course, b.value, a.name, b.scormid, b.userid, b.element, a.reference";
                        $modulestatement = "
					  mdl_cifascorm a Inner Join
					  mdl_cifascorm_scoes_track b On a.id = b.scormid
					Where
					  a.course = '" . $data->courseid . "' And
					  b.element = 'cmi.core.lesson_status' And
					  (a.reference != 'navigation_tips.zip' And a.reference='" . $lo['reference'] . "')				
				";
                        // total module in courses
                        $totalmodulestatussql = mysql_query("Select {$moduleselect} From {$modulestatement}");
                        $totalmodulestatus = mysql_num_rows($totalmodulestatussql);

                        // complete module	
                        $totalmodulecomplete = mysql_query("Select {$moduleselect} From {$modulestatement} And b.value='completed'");
                        $totalmodulecompleterow = mysql_num_rows($totalmodulecomplete);
                        $mpercent = ($totalmodulecompleterow / $totalmodulestatus) * 100;

                        $modulelist = 'M' . $a . $no . ' - ' . $mpercent . '% <br/>';
                    }
                } else {
                    echo ' - ';
                }

                // SQL total candidate PASS
                $gradepass = mysql_query("						  
					Select
					  d.grade,
					  d.userid,
					  d.quiz,
					  b.name,
					  c.attempt,
					  a.category,
					  a.visible,
					  e.reportid
					From
					  mdl_cifacourse a Inner Join
					  mdl_cifaquiz b On a.id = b.course Inner Join
					  mdl_cifaquiz_attempts c On b.id = c.quiz Inner Join
					  mdl_cifaquiz_grades d On c.quiz = d.quiz And c.userid = d.userid Inner Join
					  mdl_cifareport_users e On e.candidateid = d.userid
					Where
					  d.grade >= '60' And
					  a.visible != '0' And
					  e.reportid = '" . $data->reportid . "' And
					  b.name  = '" . $data->fullname . "'
					group by d.quiz
					 
				");
                $gradepasssql = mysql_num_rows($gradepass);

                // SQL grade fail
                $gradefailsql = mysql_query("						  
					Select
					  d.grade,
					  d.userid,
					  d.quiz,
					  b.name,
					  c.attempt,
					  a.category,
					  a.visible,
					  e.reportid
					From
					  mdl_cifacourse a Inner Join
					  mdl_cifaquiz b On a.id = b.course Inner Join
					  mdl_cifaquiz_attempts c On b.id = c.quiz Inner Join
					  mdl_cifaquiz_grades d On c.quiz = d.quiz And c.userid = d.userid Inner Join
					  mdl_cifareport_users e On e.candidateid = d.userid
					Where
					  d.grade < '60' And
					  a.visible != '0' And
					  e.reportid = '" . $data->reportid . "' And
					  b.name  = '" . $data->fullname . "'
					group by d.quiz
					 
				");
                $gradefail = mysql_num_rows($gradefailsql);

                $absent = $sqlstatusrow - ($gradepasssql + $gradefail);

                $gradepasspercent = ($gradepasssql / $sqlstatusrow) * 100;
                $gradefailpercent = ($gradefail / $sqlstatusrow) * 100;
                $absentpercent = ($absent / $sqlstatusrow) * 100;
                $expiredpercent = 100 - ($gradepasspercent + $gradefailpercent + $absentpercent);

                $gradestatus = "Pass - " . $gradepasspercent . "% <br/>";
                $gradestatus.="Fail - " . $gradefailpercent . "% <br/>";
                $gradestatus.="Absent - " . $absentpercent . "% <br/>";
                $gradestatus.="Expired - " . $expiredpercent . "% <br/>";

                // total time accessing course
                if ($data->firstaccess) {
                    $totaltimeaccess = format_time(time() - $data->firstaccess);
                } else {
                    $totaltimeaccess = "0";
                }
            } // SID == 2   
            // Content list here!!!!
            $colnum1 = 0;
            $row = array();

            if ($gns->organizationname) {
                $row[] = $rsOrgName;
            }
            if ($gns->employeeid) {
                $row[] = $rsaccess_token;
            }
            if ($gns->usersid) {
                $row[] = strtoupper($data->traineeid);
            }
            if ($gns->cnameusers) {
                $row[] = $candidatefullname;
            }
            if ($gns->usersemail) {
                $row[] = $data->email;
            }
            if ($gns->usersaddress) {
                $row[] = $fulladdress;
            }
            if ($gns->usersphone) {
                $row[] = $cphoneno;
            }
            if ($gns->designation) {
                $row[] = ucwords(strtolower($rsdesignation));
            }
            if ($gns->department) {
                $row[] = ucwords(strtolower($rsdepartment));
            }

            // Candidate Performance
            if ($sid == $srid[0]) {
                if ($gns->curriculumname) {
                    $row[] = $cname;
                }
                if ($gns->curriculumcode) {
                    $row[] = $ccode;
                }
                if ($gns->performancestatus) {
                    $row[] = $cstatus;
                }
                if ($gns->modulecompleted) {
                    $row[] = $mcompleted;
                }
                if ($gns->totaltimeperformance) {
                    $row[] = $totaltimeaccess;
                }
                if ($gns->examinationstatus) {
                    $row[] = $test_status;
                }
                if ($gns->markperformance) {
                    $row[] = $fgrade;
                }
                if ($gns->subscriptiondate) {
                    $row[] = $subscriptiondate;
                }
                if ($gns->expirydate) {
                    $row[] = $courseexpirydate;
                }
                if ($gns->lastaccess) {
                    $row[] = $lastuseraccess;
                }
            } elseif ($sid == $srid[1]) {
                if ($gns->cnameexam) {
                    $row[] = $cname;
                }
                if ($gns->ccodeexam) {
                    $row[] = $ccode;
                }
                if ($gns->cattempts) {
                    $row[] = $sqla;
                }
                if ($gns->learningoutcomes) {
                    $row[] = "";
                }
                if ($gns->scoreonlo) {
                    $row[] = "";
                }
                if ($gns->passes) {
                    $row[] = $passes;
                }
                if ($gns->passrate) {
                    $row[] = $passrate;
                }
            } elseif ($sid == $srid[2]) {
                // Course Statistics %
                if ($gns->cname_statistics) {
                    $row[] = $cname;
                }
                if ($gns->ccode_statistics) {
                    $row[] = $ccode;
                }
                if ($gns->statusstistics) {
                    $row[] = $statusenrollment;
                }
                if ($gns->mcomplete_statistics) {
                    $row[] = $modulelist;
                }
                if ($gns->totaltime_statistics) {
                    $row[] = $gradestatus;
                }
                if ($gns->examstatus_statistics) {
                    $row[] = $totaltimeaccess;
                }
            }

            // display content
            foreach ($row as $item) {
                $myxls->write($rownum, $colnum1, $item, $format);
                $colnum1++;
            }
            $rownum++;
        }
        $results->close();
    }
    $workbook->close();
}   