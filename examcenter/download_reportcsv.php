<?php

require_once('../config.php');
require_once('../organization/lib.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/filelib.php');
include('../manualdbconfig.php');

if ($_POST['checktoken'] != "") {
    $checkBox = $_POST['checktoken'];

    //print_r($download_excel_3);	die('testing');	

    $reportid = $_GET['rid'];
    $sid = $_GET['sid'];
    
    $rpcreator = mysql_query("
                    Select
                      b.userid,
                      a.name,
                      a.id,
                      b.contextid
                    From
                      {$CFG->prefix}role a Inner Join
                      {$CFG->prefix}role_assignments b On a.id = b.roleid
                    Where
                      b.userid = '" . $_GET['rcid'] . "' And
                      b.contextid = '1'		
            ");
    $creator = mysql_fetch_array($rpcreator);    

    $reportSQL = mysql_query("
				Select
				  *
				From
				  mdl_cifareport_menu a Inner Join
				  mdl_cifareport_option b On b.reportid = a.id Inner Join
				  mdl_cifareport_users c On b.reportid = c.reportid
				Where
					b.reportid='" . $reportid . "'	
			");
    $viewreport = mysql_fetch_array($reportSQL);


    for ($i = 0; $i < sizeof($checkBox); $i++) {
        //print_r($checkBox[$i]);	die('testing');		
        //update token, center ID, token start date, token expiry
        $access_token = uniqid(rand());
        $tokencreated = strtotime('now');
        $tokenexpiry = strtotime(date('d-m-Y H:i:s', $tokencreated) . " + 1 year");

        $filename = "report_csv";
        $csv_filename = clean_filename($filename . '-' . date('Ymd') . '-' . time('now') . '.csv');

        header("Content-Type: application/vnd.ms-excel");

        if ($sid == '0') {
            // list out candidate performance	
            $statement = "
				  mdl_cifacourse a Inner Join
				  mdl_cifaenrol b On a.id = b.courseid Inner Join
				  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
				  mdl_cifareport_users d On c.userid = d.candidateid Inner Join
				  mdl_cifauser e On d.candidateid = e.id And c.userid = e.id
				";

            $statement.=" WHERE a.category = '1' And d.reportid = '" . $reportid . "' And a.visible != '0' And c.id='" . $checkBox[$i] . "'";
            $statement.=" Group by b.courseid, d.candidateid";
            $sql = "SELECT *, a.idnumber as code, c.lastaccess as courselastaccess FROM {$statement}";
        } else if ($sid == '1') {
            // list out ipd course performance	
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
        } // SID == 1
        else if ($sid == '2') {
            $statement = "
				  mdl_cifacourse a Inner Join
				  mdl_cifaenrol b On a.id = b.courseid Inner Join
				  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
				  mdl_cifareport_users d On c.userid = d.candidateid Inner Join
				  mdl_cifauser e On d.candidateid = e.id
				";
            $statement.=" WHERE a.category = '1' And a.idnumber='" . $checkBox[$i] . "' And d.reportid = '" . $reportid . "' And a.visible != '0'";
            $statement.=" Group By b.courseid";
            $sql = "SELECT *, c.id as enrollmentid, a.idnumber as coursecode FROM {$statement}";
        } // SID == 2
        // Candidate Profile
        if ($sid != '2') {
            if ($viewreport['organizationname'] != '0') {
                $CPtitle.=get_string('organization') . ";";
            }
            if ($viewreport['employeeid'] != '0') {
                $CPtitle.=get_string('employeeid') . ";";
            }
            if ($viewreport['candidateID'] != '0') {
                $CPtitle.=get_string('candidateid') . ";";
            }
            if ($viewreport['candidateFullname'] != '0') {
                $CPtitle.=get_string('fullname') . ";";
            }
            if ($viewreport['candidateEmail'] != '0') {
                $CPtitle.=get_string('email') . ";";
            }
            if ($viewreport['candidateAddress'] != '0') {
                $CPtitle.=get_string('address') . ";";
            }
            if ($viewreport['candidateTel'] != '0') {
                $CPtitle.=get_string('officetel') . ";";
            }
            if ($viewreport['designation'] != '0') {
                $CPtitle.=get_string('designation') . ";";
            }
            if ($viewreport['department'] != '0') {
                $CPtitle.=get_string('department') . ";";
            }
            if ($viewreport['enrolstatus'] != '0') {
                $CPtitle.=get_string('enrolstatus') . ";";
            }            
        }

        if ($sid == '0') {
            // Candidate Performance
            if ($viewreport['curriculumname'] != '0') {
                $CPtitle.=get_string('coursetitle') . ";";
            }
            if ($viewreport['curriculumcode'] != '0') {
                $CPtitle.=get_string('coursecode') . ";";
            }
            if ($viewreport['performancestatus'] != '0') {
                $CPtitle.=get_string('status') . ";";
            }
            if ($viewreport['modulecompleted'] != '0') {
                $CPtitle.=get_string('modulecompleted') . ";";
            }
            if ($viewreport['totaltimeperformance'] != '0') {
                $CPtitle.=get_string('totaltime') . ";";
            }
            if ($viewreport['examinationstatus'] != '0') {
                $CPtitle.=get_string('teststatus') . "1;";
				$CPtitle.= "Marks 1 (%);";
				$CPtitle.= "Date Attempt 1;";
				$CPtitle.= get_string('teststatus').' 2;';
				$CPtitle.= "Marks 2 (%);";
				$CPtitle.= "Date Attempt 2;";
            }
            /*if ($viewreport['markperformance'] != '0') {
                $CPtitle.=get_string('marks') . ";";
            }*/
            if ($viewreport['subscriptiondate'] != '0') {
                $CPtitle.=get_string('subscriptiondate') . ";";
            }
            if ($viewreport['expirydate'] != '0') {
                $CPtitle.=get_string('expirydate') . ";";
            }
            if ($viewreport['lastaccess'] != '0') {
                $CPtitle.=get_string('lastaccess') . ";";
            }            
        } else if ($sid == '1') {
            // IPD Course Performance
            if ($viewreport['cnameexam'] != '0') {
                $CPtitle.=get_string('coursetitle') . ";";
            }
            if ($viewreport['ccodeexam'] != '0') {
                $CPtitle.=get_string('coursecode') . ";";
            }
            if ($viewreport['cattempts'] != '0') {
                $CPtitle.=get_string('testattempts') . ";";
            }
            if ($viewreport['learningoutcomes'] != '0') {
                $CPtitle.=get_string('lo') . ";";
            }
            if ($viewreport['scoreonlo'] != '0') {
                $CPtitle.=get_string('scorelo') . ";";
            }
            if ($viewreport['passes'] != '0') {
                $CPtitle.=get_string('passes') . ";";
            }
            if ($viewreport['passrate'] != '0') {
                $CPtitle.=get_string('passrate') . ";";
            }
        } else {
            // Course Statistics %
            if ($viewreport['cname_statistics'] != '0') {
                $CPtitle.=get_string('coursetitle') . ";";
            }
            if ($viewreport['ccode_statistics'] != '0') {
                $CPtitle.=get_string('coursecode') . ";";
            }
            if ($viewreport['statusstistics'] != '0') {
                $CPtitle.=get_string('status') . ";";
            }
            if ($viewreport['mcomplete_statistics'] != '0') {
                $CPtitle.=get_string('modulecompleted') . ";";
            }
            if ($viewreport['totaltime_statistics'] != '0') {
                $CPtitle.=get_string('teststatus') . ";";
            }
            if ($viewreport['examstatus_statistics'] != '0') {
                $CPtitle.=get_string('totaltime') . ";";
            }
        }

        $result = mysql_query($sql);
        if (mysql_num_rows($result) != '0') {
            if ($i < '1') {	
                $fileContent = "Report Title: " . $viewreport['reportname'] . "\n";
                $fileContent.="Created By: " . $creator['name'] . ", " . date('d/m/Y h:i:s', $viewreport['timecreated']) . "\n\n\n\n";

                $fileContent .= $CPtitle . "\n";
            } else {
                $fileContent = "";
            }
            while ($data = mysql_fetch_array($result)) {

                $fullcname = $data['firstname'] . " " . $data['lastname'];

                // $address=trim($data['address']); //." ".trim($data['address2'])." ".trim($data['address3']);
                $FA1 = explode(",", $data['address']);
                $address1 = $FA1[0] . $FA1[2] . $FA1[3];
                $FA2 = explode(",", $data['address2']);
                $address2 = $FA2[0] . $FA2[2] . $FA2[3];
                $FA3 = explode(",", $data['address3']);
                $address3 = $FA3[0] . $FA3[2] . $FA3[3];
                $fulladdress = $address1 . $address2 . $address3 . " " . $data['postcode'] . " " . $data['city'] . " " . $data['state'] . " " . $data['country'];

                //country list
                $countrylistsql = mysql_query("SELECT * FROM {$CFG->prefix}country_list WHERE countrycode='" . $data['country'] . "'");
                $countrylist = mysql_fetch_array($countrylistsql);

                // OrgType
                $qryOrg = "SELECT * FROM {$CFG->prefix}organization_type WHERE id='" . $data['orgtype'] . "' ORDER BY id ASC";
                $sqlOrg = mysql_query($qryOrg);
                $rsOrg = mysql_fetch_array($sqlOrg);
                $rsOrgName = $rsOrg['name'] . ' ' . $countrylist['countryname'] . ";";

                // phone no
                $cphoneno = '+' . $countrylist['iso_countrycode'] . $data['phone1'];

                if ($data['department'] != '') {
                    $rsdepartment = $data['department'];
                } else {
                    $rsdepartment = " - ";
                }  // department
                
                $rsenrolstatus = checkuserstatus($data['userid']);
                if ($data['department'] != '') {
                    $rsdesignation = $data['designation'];
                } else {
                    $rsdesignation = " - ";
                }  // designation
                if ($data['access_token'] != '') {
                    $rsaccess_token = $data['access_token'];
                } else {
                    $rsaccess_token = " - ";
                }  // Employee ID					

                if ($sid == '0') {
                    // display course code where coursefullname=testname
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
						  b.visible!='0' And a.name='" . $data['fullname'] . "'
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
						  a.userid = '" . $data['userid'] . "')				
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
                    //$sstatement.=" Where a.id = '".$testcodearray['quizattemptsid']."' And b.userid='".$data['userid']."'";
                    $sstatement.=" Where a.id = '" . $qgrade['quizid'] . "' And b.userid='" . $data['userid'] . "'";
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
                        if (!$data['timeclose'] || strtotime('now') < $data['timeclose']) {
                            // The attempt is still in progress.
                            $cstatus = get_string('inprogress', 'quiz');
                        } else {
                            // $timetaken = format_time($data['timefinish'] - $data['timestart']);
                            $cstatus = userdate($data['timeclose']);
                        }
                    }

                    // Marks %
                    if ($testgraderow != '0') {
                        $fgrade = round($finalgrade);
                    } else {
                        $fgrade = '-';
                    }

                    // Module Completed
        // Completed Module here!!!!
        $rscc = printScormWithCourseId($data['courseid']);
        $a='0';
        foreach ($rscc as $r) {
           // 
           $sql = "Select COUNT(a.id)
                         From
                           {scorm_scoes_track} a
                         Where
                           a.userid='".$data['userid']."' AND
                           a.scormid='" . $r->scorm . "' AND
                           a.value = 'completed'
                         ";
           $rsql = $DB->count_records_sql($sql);
           if ($rsql === chapteronscorm($r->scorm)) {
               $a++;
           }
            
        } $rscc->close();   $mcompleted = $a.' of ' . getTotalScormOnCourse($data['courseid']) . ' Modules';                     
                    
                    /*$sqlcoursequery = mysql_query("SELECT * FROM {$CFG->prefix}course WHERE idnumber='" . $ccode . "' AND category='1'");
                    $sqlcourse = mysql_fetch_array($sqlcoursequery);

                    $cmodulecompletesql = mysql_query("
						Select
						  *
						From
						  mdl_cifascorm a Inner Join
						  mdl_cifascorm_scoes_track b On a.id = b.scormid
						Where
							b.userid='" . $data['userid'] . "' And a.course='" . $sqlcourse['id'] . "'
						Group By a.id		
					");
                    $kiramodule = mysql_num_rows($cmodulecompletesql);

                    $cmcompletesql = mysql_query("
						Select
						  *
						From
						  mdl_cifascorm a
						Where
							a.course='" . $sqlcourse['id'] . "'
						Group By a.id		
					");
                    $moduleofcourse = mysql_num_rows($cmcompletesql);
                    $mcompleted = $kiramodule . " of " . $moduleofcourse . " Modules";*/
                    // End Module Completed
                    // total time accessing course
                    if ($data['firstaccess']) {
                        $totaltimeaccess = format_time(time() - $data['firstaccess']);
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
                    ////mmn off to display subscriptiondate if ($data['firstaccess'] != '0') {
                        $subscriptiondate = date('d/m/Y', $data['timestart']);
                   /*//mmn off to display subscriptiondate } else {
                        $subscriptiondate = ' - ';
                    }*/

                    // course expiry date
                   ////mmn off to display subscriptiondate if ($data['firstaccess'] != '0') {
                        $courseexpirydate = date('d/m/Y', $data['timeend']);
                   /*//mmn off to display subscriptiondate } else {
                        $courseexpirydate = ' - ';
                    }*/

                    // last user access
                    if ($data['firstaccess'] != '0') {
                        $lastuseraccess = date('d/m/Y', $data['courselastaccess']);
                    } else {
                        $lastuseraccess = ' - ';
                    }                    
                } else if ($sid == '1') {
                    $cname = $data['testname'];

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
						  *,
						  a.grade As usergrade, b.id As quizid
						From
						  mdl_cifaquiz_grades a,
						  mdl_cifaquiz b Inner Join
						  mdl_cifacourse c On b.course = c.id
						Where
						  a.quiz = b.id And a.grade >= 60 And a.quiz = '" . $data['quizattemptid'] . "' And
						  (c.category = '3' And
						  a.userid = '" . $data['userid'] . "')				
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
                    $st10.=" Where a.quiz = '" . $data['quizattemptid'] . "' And c.reportid = '" . $reportid . "'";
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
					");
                    $no = '1';
                    $losqlcount = mysql_num_rows($losql);

                    // candidate performance // module completed		
                    $sqlA = mysql_query("
						Select
						  b.status As status1,
						  b.userid,
						  a.courseid,
						  a.enrol
						From
						  mdl_cifaenrol a Inner Join
						  mdl_cifauser_enrolments b On a.id = b.enrolid
						Where
						  b.status != '1' And
						  b.userid = '" . $data['userid'] . "'				
					");
                    $sqlcount = mysql_num_rows($sqlA);
                    $mcomplete = $sqlcount . " of " . $sqlcount . " Modules";

                    // candidate performance//total time 
                    $totaltime = format_time($data['timefinish'] - $data['timestart']);

                    // candidate performance status
                    if ($data['timefinish'] > 0) {
                        // attempt has finished
                        $datecompleted = 'Ended';
                    } else if (!$data['timeclose'] || strtotime('now') < $data['timeclose']) {
                        // The attempt is still in progress.
                        $datecompleted = get_string('inprogress', 'quiz');
                    } else {
                        $timetaken = format_time($data['timefinish'] - $data['timestart']);
                        $datecompleted = userdate($data['timeclose']);
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
                    //display learning outcome
                    if ($losqlcount != '0') {
                        while ($lo = mysql_fetch_array($losql)) {
                            $lolist.=$lo['name'] . '\n';
                        }
                    } else {
                        echo ' - ';
                    }
                } // SID == 1
                else {
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
						  d.reportid = '" . $data['reportid'] . "' And
						  a.visible != '0' And c.enrolid='" . $data['enrolid'] . "'	
					");
                    $sqlstatusrow = mysql_num_rows($sqlstatus); // echo $data['enrolid'].'<br/>';

                    $cname = $data['fullname'];
                    $ccode = $data['coursecode'];

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
						  a.idnumber = '" . $data['coursecode'] . "' AND b.reference!='navigation_tips.zip'	
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
						  a.name = '" . $sqlrow['fullname'] . "' 
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
					  a.course = '" . $sqlrow['courseid'] . "' And
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
					  e.reportid = '" . $sqlrow['reportid'] . "' And
					  b.name  = '" . $sqlrow['fullname'] . "'
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
					  e.reportid = '" . $sqlrow['reportid'] . "' And
					  b.name  = '" . $sqlrow['fullname'] . "'
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
                    if ($data['firstaccess']) {
                        $totaltimeaccess = format_time(time() - $data['firstaccess']);
                    } else {
                        $totaltimeaccess = "0";
                    }
                } // SID == 2
                // Candidate Profile
                if ($sid != '2') {
                    if ($viewreport['organizationname'] != '0') {
                        $CPorgname = $rsOrgName;
                    }
                    if ($viewreport['employeeid'] != '0') {
                        $CPemployeeid = $rsaccess_token . ";";
                    }
                    if ($viewreport['candidateID'] != '0') {
                        $CPdata1 = strtoupper($data['traineeid']) . ";";
                    }
                    if ($viewreport['candidateFullname'] != '0') {
                        $CPdata2 = $fullcname . ";";
                    }
                    if ($viewreport['candidateEmail'] != '0') {
                        $CPdata3 = $data['email'] . ";";
                    }
                    if ($viewreport['candidateAddress'] != '0') {
                        $CPdata4 = $fulladdress . ";";
                    }
                    if ($viewreport['candidateTel'] != '0') {
                        $CPdata5 = $cphoneno . ";";
                    }
                    if ($viewreport['designation'] != '0') {
                        $CPdesignation = $rsdesignation . ";";
                    }
                    if ($viewreport['department'] != '0') {
                        $CPdepartment = $rsdepartment . ";";
                    }
                    if ($viewreport['enrolstatus'] != '0') {
                        $CPenrolstatus = $rsenrolstatus . ";";
                    }
                    
                }

                if ($sid == '0') {
                    // Candidate Performance
                    if ($viewreport['curriculumname'] != '0') {
                        $CPdata6 = $cname . ";";
                    }
                    if ($viewreport['curriculumcode'] != '0') {
                        $CPdata7 = $ccode . ";";
                    }
                    if ($viewreport['performancestatus'] != '0') {
                        $CPdata8 = $cstatus . ";";
                    }
                    if ($viewreport['modulecompleted'] != '0') {
                        $CPdata9 = $mcompleted . ";";
                    }
                    if ($viewreport['totaltimeperformance'] != '0') {
                        $CPdata10 = $totaltimeaccess . ";";
                    }
					//mmn add to display all attempts
				//1st attempt
				$sselect1 = "
						  a.name,
						  a.id as quizattemptsid,
						  b.attempt, b.sumgrades,b.timefinish,
						  b.userid,
						  b.id As id1,
						  a.attempts,
						  a.course	
					";
                $sstatement1 = "
						  mdl_cifaquiz a Inner Join
						  mdl_cifaquiz_attempts b On a.id = b.quiz 
					";
                // $sstatement.=" Where a.id = '".$testcodearray['quizattemptsid']."' And b.userid='".$data['userid']."'";
                $sstatement1.=" Where b.attempt=1 AND a.id = '" . $qgrade['quizid'] . "' And b.userid='" . $data['userid'] . "' Order by b.attempt ASC";
                $sqltestgrade1 = mysql_query("Select {$sselect1} From {$sstatement1}");
                $testgraderow1 = mysql_num_rows($sqltestgrade1);				                
                while($testgrade1 = mysql_fetch_array($sqltestgrade1)){
				$finalgrade1a = $testgrade1['sumgrades'];
				$finalgrade1 = $finalgrade1a*10/2;
				//status : pass / fail
				if ($testgraderow1 != '0') {
                    if ($finalgrade1 < '60') {
                        $test_status1 = 'Fail';
                    } else {
                        $test_status1 = 'Pass';
                    }
                } else {
                    $test_status1 = '-';
                }
				
				// Marks %
                if ($testgraderow1 != '0') {
                    $fgrade1 = round($finalgrade1);
                } else {
                    $fgrade1 = '-';
                }
				$datefinish1 = date('d/m/Y H:i:s', $testgrade1['timefinish']);
				$testresult1 = $test_status1." - ".$fgrade1."% (".$datefinish1.")";//$testresult1 = $test_status1." - ".$fgrade1."%";
				}//end while 1st attempt
				
				//2nd attempt
				$sselect2 = "
						  a.name,
						  a.id as quizattemptsid,
						  b.attempt, b.sumgrades, b.timefinish,
						  b.userid,
						  b.id As id1,
						  a.attempts,
						  a.course	
					";
                $sstatement2 = "
						  mdl_cifaquiz a Inner Join
						  mdl_cifaquiz_attempts b On a.id = b.quiz 
					";
                // $sstatement.=" Where a.id = '".$testcodearray['quizattemptsid']."' And b.userid='".$data['userid']."'";
                $sstatement2.=" Where b.attempt=2 AND a.id = '" . $qgrade['quizid'] . "' And b.userid='" . $data['userid'] . "' Order by b.attempt ASC";
                $sqltestgrade2 = mysql_query("Select {$sselect2} From {$sstatement2}");
                $testgraderow2 = mysql_num_rows($sqltestgrade2);				                
                while($testgrade2 = mysql_fetch_array($sqltestgrade2)){
				$finalgrade2a = $testgrade2['sumgrades'];
				$finalgrade2 = $finalgrade2a*10/2;
				//status : pass / fail
				if ($testgraderow2 != '0') {
                    if ($finalgrade2 < '60') {
                        $test_status2 = 'Fail';
                    } else {
                        $test_status2 = 'Pass';
                    }
                } else {
                    $test_status2 = '-';
                }
				
				// Marks %
                if ($testgraderow2 != '0') {
                    $fgrade2 = round($finalgrade2);
                } else {
                    $fgrade2 = '-';
                }
				$datefinish2 = date('d/m/Y H:i:s', $testgrade2['timefinish']);
				$testresult2 = $test_status2." - ".$fgrade2."% (".$datefinish2.")";//$testresult2 = $test_status2." - ".$fgrade2."%";
				}//end while 2nd attempt
			
				$alltestresult = $testresult1."<br>".$testresult2;	
				//$qrytest = "Select {$sselect2} From {$sstatement2}";
				//mmn end
                    if ($viewreport['examinationstatus'] != '0') {
                        $CPdata11a = $test_status1 . ";";
						$CPdata11b = $fgade1 . ";";
						$CPdata11c = $datefinish1 . ";";
						$CPdata11d = $test_status2 . ";";
						$CPdata11e = $fgade2 . ";";
						$CPdata11f = $datefinish2 . ";";
                    }
                    /*if ($viewreport['markperformance'] != '0') {
                        $CPdata12 = $fgrade . ";";
                    }*/
                    if ($viewreport['subscriptiondate'] != '0') {
                        $CPdata13 = $subscriptiondate . ";";
                    }
                    if ($viewreport['expirydate'] != '0') {
                        $CPdata14 = $courseexpirydate . ";";
                    }
                    if ($viewreport['lastaccess'] != '0') {
                        $CPdata15 = $lastuseraccess . ";";
                    }                    
                } else if ($sid == '1') {
                    // IPD Course Performance
                    if ($viewreport['cnameexam'] != '0') {
                        $CPdata6 = $cname . ";";
                    }
                    if ($viewreport['ccodeexam'] != '0') {
                        $CPdata7 = $ccode . ";";
                    }
                    if ($viewreport['cattempts'] != '0') {
                        $CPdata8 = $sqla . ";";
                    }
                    if ($viewreport['learningoutcomes'] != '0') {
                        $CPdata9 = ";";
                    }
                    if ($viewreport['scoreonlo'] != '0') {
                        $CPdata10 = $data['traineeid'] . ";";
                    }
                    if ($viewreport['passes'] != '0') {
                        $CPdata11 = $passes . ";";
                    }
                    if ($viewreport['passrate'] != '0') {
                        $CPdata12 = $passrate . ";";
                    }
                } else {
                    // Course Statistics %
                    if ($viewreport['cname_statistics'] != '0') {
                        $CPdata6 = $cname . ";";
                    }
                    if ($viewreport['ccode_statistics'] != '0') {
                        $CPdata7 = $ccode . ";";
                    }
                    if ($viewreport['statusstistics'] != '0') {
                        $CPdata8 = $statusenrollment . ";";
                    }
                    if ($viewreport['mcomplete_statistics'] != '0') {
                        $CPdata9 = $modulelist . ";";
                    }
                    if ($viewreport['totaltime_statistics'] != '0') {
                        $CPdata10 = $gradestatus . ";";
                    }
                    if ($viewreport['examstatus_statistics'] != '0') {
                        $CPdata11 = $totaltimeaccess . ";";
                    }
                }


                // data here!
                if ($sid == '0') {  // selected report == 0						
                    if ($i < '0') {
                        $fileContent.= "" . $CPorgname . $CPemployeeid . $CPdata1 . $CPdata2 . $CPdata3 . $CPdata4 . $CPdata5 . $CPdesignation . $CPdepartment . $CPenrolstatus.$CPdata6 . $CPdata7 . $CPdata8 . $CPdata9 . $CPdata10 . $CPdata11a . $CPdata11b .$CPdata11c .$CPdata11d .$CPdata11e .$CPdata11f .$CPdata12 . $CPdata13 . $CPdata14 . $CPdata15 . "";
                    } else {
                        $fileContent.= "\n" . $CPorgname . $CPemployeeid . $CPdata1 . $CPdata2 . $CPdata3 . $CPdata4 . $CPdata5 . $CPdesignation . $CPdepartment . $CPenrolstatus.$CPdata6 . $CPdata7 . $CPdata8 . $CPdata9 . $CPdata10 . $CPdata11a .$CPdata11b .$CPdata11c .$CPdata11d .$CPdata11e .$CPdata11f . $CPdata12 . $CPdata13 . $CPdata14 . $CPdata15 . "";
                    }
                } else if ($sid == '1') {  // selected report == 1
                    if ($i < '0') {
                        $fileContent.= "" . $CPdata1 . $CPdata2 . $CPdata3 . $CPdata4 . $CPdata5 . $CPdata6 . $CPdata7 . $CPdata8 . $CPdata9 . $CPdata10 . $CPdata11 . $CPdata12 . "";
                    } else {
                        $fileContent.= "\n" . $CPdata1 . $CPdata2 . $CPdata3 . $CPdata4 . $CPdata5 . $CPdata6 . $CPdata7 . $CPdata8 . $CPdata9 . $CPdata10 . $CPdata11 . $CPdata12 . "";
                    }
                } else if ($sid == '2') {      // selected report == 2
                    if ($i < '0') {
                        $fileContent.= "" . $CPdata6 . $CPdata7 . $CPdata8 . $CPdata9 . $CPdata10 . $CPdata11 . $CPdata12 . "";
                    } else {
                        $fileContent.= "\n" . $CPdata6 . $CPdata7 . $CPdata8 . $CPdata9 . $CPdata10 . $CPdata11 . $CPdata12 . "";
                    }
                }
            }
            $fileContent = str_replace("\n\n", "\n", $fileContent);
            echo $fileContent;
        }
        header("content-disposition: attachment;filename=$csv_filename");
    }
}
?> 