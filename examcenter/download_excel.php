<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../config.php');
require_once('../manualdbconfig.php');
require_once($CFG->libdir . '/logactivity_lib.php');
require_once($CFG->libdir . '/datalib.php');
require_once($CFG->libdir . '/moodlelib.php');
require_once($CFG->dirroot . '/lib/blocklib.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/filelib.php');
require_once("$CFG->libdir/excellib.class.php");

$rcid = optional_param('rcid', 0, PARAM_INT);
$reportid = optional_param('rid', 0, PARAM_INT); // Report ID

$rpcreator = $DB->get_record_sql("
		Select
		  b.userid,
		  a.name,
		  a.id,
		  b.contextid
		From
		  {$CFG->prefix}role a Inner Join
		  {$CFG->prefix}role_assignments b On a.id = b.roleid
		Where
		  b.userid = '" . $rcid . "' And
		  b.contextid = '1'		
	");

$headers = array();
$profileheaders = array();
$sqltext = "Select
				  *, b.candidateID as usersid, b.candidateFullname as cnameusers,
                                  b.candidateEmail as usersemail, b.candidateAddress as usersaddress,
                                  b.candidateTel as usersphone
				From
				  mdl_cifareport_menu a Inner Join
				  mdl_cifareport_option b On b.reportid = a.id Inner Join
				  mdl_cifareport_users c On b.reportid = c.reportid
				Where
					b.reportid='" . $reportid . "'";
$ns = $DB->get_recordset_sql($sqltext);
$getns1 = $DB->get_record_sql($sqltext);

if ($getns1->organizationname) {
    $headers[] = get_string('organization');
    $profileheaders[] = $c;
}
if ($getns1->employeeid) {
    $headers[] = get_string('employeeid');
    $profileheaders[] = $c;
}
if ($getns1->usersid) {
    $headers[] = get_string('candidateid');
    $profileheaders[] = $c;
}
if ($getns1->cnameusers) {
    $headers[] = get_string('fullname');
    $profileheaders[] = $c;
}
if ($getns1->usersemail) {
    $headers[] = get_string('email');
    $profileheaders[] = $c;
}
if ($getns1->usersaddress) {
    $headers[] = get_string('address');
    $profileheaders[] = $c;
}
if ($getns1->usersphone) {
    $headers[] = get_string('officetel');
    $profileheaders[] = $c;
}
if ($getns1->designation) {
    $headers[] = get_string('designation');
    $profileheaders[] = $c;
}
if ($getns1->department) {
    $headers[] = get_string('department');
    $profileheaders[] = $c;
}

// Candidate Performance
if ($getns1->curriculumname) {
    $headers[] = get_string('coursetitle');
}
if ($getns1->curriculumcode) {
    $headers[] = get_string('coursecode');
}
if ($getns1->performancestatus) {
    $headers[] = get_string('status');
}
if ($getns1->modulecompleted) {
    $headers[] = get_string('modulecompleted');
}
if ($getns1->totaltimeperformance) {
    $headers[] = get_string('totaltime');
}
if ($getns1->examinationstatus) {
    $headers[] = get_string('teststatus');
}
if ($getns1->markperformance) {
    $headers[] = get_string('marks');
}
if ($getns1->subscriptiondate) {
    $headers[] = get_string('subscriptiondate');
}
if ($getns1->expirydate) {
    $headers[] = get_string('expirydate');
}
if ($getns1->lastaccess) {
    $headers[] = get_string('lastaccess');
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
$border->set_align('merge'); # Required for cell merge

$t = count($headers) - 1;
$myxls->set_column(0, $t, 30);
//$myxls->set_row(3,NULL,$border);

$myxls->write(0, 0, "Report title: " . strtoupper($getns1->reportname), $formattitle);
$myxls->write(1, 0, "Created By: " . ucwords(strtolower($rpcreator->name)) . ", " . date('d/m/Y h:i:s', $getns1->timecreated) . "", $formattitle);

$myxls->write(3, 0, "Candidate Profile", $border);
$myxls->write(3, $colsprofile, "Candidate Performance", $border);

// set header here!
$colnum = 0;
foreach ($headers as $item) {
    $myxls->write(4, $colnum, $item, $formatheader);
    $colnum++;
}
$rownum = 5;

// set content here!!
$statement = "
            mdl_cifacourse a Inner Join
            mdl_cifaenrol b On a.id = b.courseid Inner Join
            mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
            mdl_cifareport_users d On c.userid = d.candidateid Inner Join
            mdl_cifauser e On d.candidateid = e.id
        ";

$statement.=" WHERE a.category='1' AND d.reportid = '" . $reportid . "' And a.visible != '0' AND e.orgtype='7'";
$sql = "SELECT *, c.id as enrollmentid, a.idnumber as code FROM {$statement}";
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
    
        // Completed Module here!!!!
        $rscc = printScormWithCourseId($data->courseid);
        $a='0';
        foreach ($rscc as $r) {
           // 
           $sql = "Select COUNT(a.id)
                         From
                           {scorm_scoes_track} a
                         Where
                           a.userid='".$data->userid."' AND
                           a.scormid='" . $r->scorm . "' AND
                           a.value = 'completed'
                         ";
           $rsql = $DB->count_records_sql($sql);
           if ($rsql === chapteronscorm($r->scorm)) {
               $a++;
           }
            
        } $rscc->close();   $mcompleted = $a.' of ' . getTotalScormOnCourse($data->courseid) . ' Modules';    
    
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
    if ($data->firstaccess != '0') {
        $lastuseraccess = date('d/m/Y', $data->lastaccess);
    } else {
        $lastuseraccess = ' - ';
    }

    $getns = $DB->get_record_sql('Select
				  *, b.candidateID as usersid, b.candidateFullname as cnameusers,
                                  b.candidateEmail as usersemail, b.candidateAddress as usersaddress,
                                  b.candidateTel as usersphone
				From
				  {report_menu} a Inner Join
				  {report_option} b On b.reportid = a.id Inner Join
				  {report_users} c On b.reportid = c.reportid
				Where b.reportid = ?', array($reportid));

    // Content list here!!!!
    $colnum1 = 0;
    $row = array();

    if ($getns->organizationname) {
        $row[] = $rsOrgName;
    }
    if ($getns->employeeid) {
        $row[] = $rsaccess_token;
    }
    if ($getns->usersid) {
        $row[] = strtoupper($data->traineeid);
    }
    if ($getns->cnameusers) {
        $row[] = $candidatefullname;
    }
    if ($getns->usersemail) {
        $row[] = $data->email;
    }
    if ($getns->usersaddress) {
        $row[] = $fulladdress;
    }
    if ($getns->usersphone) {
        $row[] = $cphoneno;
    }
    if ($getns->designation) {
        $row[] = ucwords(strtolower($rsdesignation));
    }
    if ($getns->department) {
        $row[] = ucwords(strtolower($rsdepartment));
    }

    // Candidate Performance
    if ($getns->curriculumname) {
        $row[] = $cname;
    }
    if ($getns->curriculumcode) {
        $row[] = $ccode;
    }
    if ($getns->performancestatus) {
        $row[] = $cstatus;
    }
    if ($getns->modulecompleted) {
        $row[] = $mcompleted;
    }
    if ($getns->totaltimeperformance) {
        $row[] = $totaltimeaccess;
    }
    if ($getns->examinationstatus) {
        $row[] = $test_status;
    }
    if ($getns->markperformance) {
        $row[] = $fgrade;
    }
    if ($getns->subscriptiondate) {
        $row[] = $subscriptiondate;
    }
    if ($getns->expirydate) {
        $row[] = $courseexpirydate;
    }
    if ($getns->lastaccess) {
        $row[] = $lastuseraccess;
    }

    // display content
    foreach ($row as $item) {
        $myxls->write($rownum, $colnum1, $item, $format);
        $colnum1++;
    }
    $rownum++;
}
$workbook->close();
