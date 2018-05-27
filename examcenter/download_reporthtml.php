<?php
require_once('../config.php');
require_once('../organization/lib.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/filelib.php');
include('../manualdbconfig.php');
// include('convertToPDF.php'); 

if ($_POST['checktoken'] == "") {
    $url2 = $CFG->wwwroot . '/examcenter/reportview.php?id=' . $_GET['rid'] . '&sid=' . $_GET['sid'];
    ?>
    <script language="javascript">
        window.alert("Please tick at lease one user to download.");
        window.location.href = '<?= $url2; ?>';
    </script>
    <style type="text/css">
        a:hover {text-decoration:underline;}
        #searchtable td{	 
            border-collapse:collapse; 
            border: 1px solid #666666;
            padding-left:5px;
        }
        #searchtable th{
            border: 1px solid #231f20;
            color:#ffffff;	
            background-color:#6D6E71;
        }	
        html, body {
            font-family: Verdana,Geneva,sans-serif !important;
            color: #333;
            font-size:0.9em;
        }	
        table tr, td, th {
            font-family: Verdana,Geneva,sans-serif;
            font-size:0.9em;
        }
    </style>			
    <?php
}

if ($_POST['checktoken'] != "") {
    $checkBox = $_POST['checktoken'];

    //print_r($download_excel_3);	die('testing');	

    $reportid = $_GET['rid'];
    $sid = $_GET['sid'];

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

    echo "<table width='95%' border='1' id='searchtable' style='border-collapse:collapse;margin:0px auto;'><tr style='color:#ffffff;background-color:#6D6E71;'>";
    $tdopen = "<td>";
    $tdclose = "</td>";
    $thopen = "<th>";
    $thclose = "</th>";

    // Candidate Profile
    if ($sid != '2') {
        if ($viewreport['organizationname'] != '0') {
            $CPtitle.="<th>" . get_string('organization') . "</th>";
        }
        if ($viewreport['employeeid'] != '0') {
            $CPtitle.="<th>" . get_string('employeeid') . "</th>";
        }
        if ($viewreport['candidateID'] != '0') {
            $CPtitle.="<th>" . get_string('candidateid') . "</th>";
        }
        if ($viewreport['candidateFullname'] != '0') {
            $CPtitle.="<th>" . get_string('fullname') . "</th>";
        }
        if ($viewreport['candidateEmail'] != '0') {
            $CPtitle.="<th>" . get_string('email') . "</th>";
        }
        if ($viewreport['candidateAddress'] != '0') {
            $CPtitle.="<th>" . get_string('address') . "</th>";
        }
        if ($viewreport['candidateTel'] != '0') {
            $CPtitle.="<th>" . get_string('officetel') . "</th>";
        }
        if ($viewreport['designation'] != '0') {
            $CPtitle.="<th>" . get_string('designation') . "</th>";
        }
        if ($viewreport['department'] != '0') {
            $CPtitle.="<th>" . get_string('department') . "</th>";
        }
        if ($viewreport['enrolstatus'] != '0') {
            $CPtitle.="<th>" . get_string('enrolstatus') . "</th>";
        }
    }

    if ($sid == '0') {
        // Candidate Performance
        if ($viewreport['curriculumname'] != '0') {
            $CPtitle.="<th>" . get_string('coursetitle') . "</th>";
        }
        if ($viewreport['curriculumcode'] != '0') {
            $CPtitle.="<th>" . get_string('coursecode') . "</th>";
        }
        if ($viewreport['performancestatus'] != '0') {
            $CPtitle.="<th>" . get_string('status') . "</th>";
        }
        if ($viewreport['modulecompleted'] != '0') {
            $CPtitle.="<th>" . get_string('modulecompleted') . "</th>";
        }
        if ($viewreport['totaltimeperformance'] != '0') {
            $CPtitle.="<th>" . get_string('totaltime') . "</th>";
        }
        if ($viewreport['examinationstatus'] != '0') {
            $CPtitle.="<th>" . get_string('teststatus') . "1</th>";
			$CPtitle.="<th>Marks 1 (%)</th>";
			$CPtitle.="<th>Date Attempt 1</th>";
			$CPtitle.="<th>" . get_string('teststatus') . "2</th>";
			$CPtitle.="<th>Marks 2 (%)</th>";
			$CPtitle.="<th>Date Attempt 2</th>";
        }
        /*mmn off if ($viewreport['markperformance'] != '0') {
            $CPtitle.="<th>" . get_string('marks') . "</th>";
        }*/
        if ($viewreport['subscriptiondate'] != '0') {
            $CPtitle.="<th>" . get_string('subscriptiondate') . "</th>";
        }
        if ($viewreport['expirydate'] != '0') {
            $CPtitle.="<th>" . get_string('expirydate') . "</th>";
        }
        if ($viewreport['lastaccess'] != '0') {
            $CPtitle.="<th>" . get_string('lastaccess') . "</th>";
        }

        echo $CPtitle;
    } else if ($sid == '1') {
        // IPD Course Performance
        if ($viewreport['cnameexam'] != '0') {
            $CPtitle.="<th>" . get_string('coursetitle') . $thclose;
        }
        if ($viewreport['ccodeexam'] != '0') {
            $CPtitle.="<th>" . get_string('coursecode') . $thclose;
        }
        if ($viewreport['cattempts'] != '0') {
            $CPtitle.="<th>" . get_string('testattempts') . $thclose;
        }
        if ($viewreport['learningoutcomes'] != '0') {
            $CPtitle.="<th>" . get_string('lo') . $thclose;
        }
        if ($viewreport['scoreonlo'] != '0') {
            $CPtitle.="<th>" . get_string('scorelo') . $thclose;
        }
        if ($viewreport['passes'] != '0') {
            $CPtitle.="<th>" . get_string('passes') . $thclose;
        }
        if ($viewreport['passrate'] != '0') {
            $CPtitle.="<th>" . get_string('passrate') . $thclose;
        }

        echo $CPtitle;
    } else {
        // Course Statistics %
        if ($viewreport['cname_statistics'] != '0') {
            $CPtitle.=$thopen . get_string('coursetitle') . $thclose;
        }
        if ($viewreport['ccode_statistics'] != '0') {
            $CPtitle.=$thopen . get_string('coursecode') . $thclose;
        }
        if ($viewreport['statusstistics'] != '0') {
            $CPtitle.=$thopen . get_string('status') . $thclose;
        }
        if ($viewreport['mcomplete_statistics'] != '0') {
            $CPtitle.=$thopen . get_string('modulecompleted') . $thclose;
        }
        if ($viewreport['totaltime_statistics'] != '0') {
            $CPtitle.=$thopen . get_string('teststatus') . $thclose;
        }
        if ($viewreport['examstatus_statistics'] != '0') {
            $CPtitle.=$thopen . get_string('totaltime') . $thclose;
        }

        echo $CPtitle;
    }
    echo "</tr>";

    for ($i = 0; $i < sizeof($checkBox); $i++) {
        echo '<tr>';
        //update token, center ID, token start date, token expiry
        $access_token = uniqid(rand());
        $tokencreated = strtotime('now');
        $tokenexpiry = strtotime(date('d-m-Y H:i:s', $tokencreated) . " + 1 year");

        // $filename="report_html";
        // $csv_filename = clean_filename($filename.'-'.date('Ymd').'-'.time('now').'.xls');

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
            $sql = "SELECT *, a.idnumber as code, c.lastaccess as courselastaccess  FROM {$statement}";
        } else if ($sid == '1') {
            // list out candidate performance	
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
        } else if ($sid == '2') {
            $statement = "
				  mdl_cifacourse a Inner Join
				  mdl_cifaenrol b On a.id = b.courseid Inner Join
				  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
				  mdl_cifareport_users d On c.userid = d.candidateid Inner Join
				  mdl_cifauser e On d.candidateid = e.id
				";
            $statement.=" WHERE a.category = '1' And a.idnumber='" . $checkBox[$i] . "' And d.reportid = '" . $reportid . "' And a.visible != '0'";
            $statement.=" Group By a.idnumber";
            $sql = "SELECT *, c.id as enrollmentid, a.idnumber as coursecode FROM {$statement}";
        } // SID == 2				

        $result = mysql_query($sql);
        $kira2 = mysql_num_rows($result);
        // print_r($kira2); die('testing');

        if ($kira2 != '0') {
            $data = mysql_fetch_array($result);
            //while($data=mysql_fetch_array($result)){


            /* $tdopen="<td>";
              $tdclose="</td>"; */

            $fullcname = $data['firstname'] . " " . $data['lastname'];

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
            $rsOrgName = "<td>" . $rsOrg['name'] . ' ' . $countrylist['countryname'] . "</td>";

            // phone no
            $cphoneno = '+' . $countrylist['iso_countrycode'] . $data['phone1'];

            if ($data['department'] != '') {
                $rsdepartment = $data['department'];
            } else {
                $rsdepartment = " - ";
            }  // department

            // enrol status
            $rsenrolstatus = checkuserstatus($data->userid);

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
                // $sstatement.=" Where a.id = '".$testcodearray['quizattemptsid']."' And b.userid='".$data['userid']."'";
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
                $sqlcoursequery = mysql_query("SELECT * FROM {$CFG->prefix}course WHERE idnumber='" . $ccode . "' AND category='1'");
                
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
                /*$sqlcourse = mysql_fetch_array($sqlcoursequery);

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
                //mmn off to display subscriptiondate if ($data['firstaccess'] != '0') {
                    $subscriptiondate = date('d/m/Y', $data['timestart']);
                /*mmn off to display subscriptiondate } else {
                    $subscriptiondate = ' - ';
                }*/

                // course expiry date
               //mmn off to display subscriptiondate  if ($data['firstaccess'] != '0') {
                    $courseexpirydate = date('d/m/Y', $data['timeend']);
               /*mmn off to display subscriptiondate  } else {
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
						Order By
						  b.name ASC
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
                        $lolist.=$lo['name'] . '<br/>';
                    }
                } else {
                    echo ' - ';
                }
            } // SID == 1
            else if ($sid == '2') {
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

                $statusenrollment = "Subscribed - " . round($subscribed) . "% <br/>";
                $statusenrollment.="In Progress - " . round($inprogress) . "% <br/>";
                $statusenrollment.="Completed - " . round($completed) . "%<br/>";

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

                        $modulelist = 'M' . $a . $no . ' - ' . round($mpercent) . '% <br/>';
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

                $gradestatus = "Pass - " . round($gradepasspercent) . "% <br/>";
                $gradestatus.="Fail - " . round($gradefailpercent) . "% <br/>";
                $gradestatus.="Absent - " . round($absentpercent) . "% <br/>";
                $gradestatus.="Expired - " . round($expiredpercent) . "% <br/>";

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
                    $CPemployeeid = $tdopen . $rsaccess_token . $tdclose;
                }
                if ($viewreport['candidateID'] != '0') {
                    $CPdata1 = $tdopen . strtoupper($data['traineeid']) . $tdclose;
                }
                if ($viewreport['candidateFullname'] != '0') {
                    $CPdata2 = $tdopen . $fullcname . $tdclose;
                }
                if ($viewreport['candidateEmail'] != '0') {
                    $CPdata3 = $tdopen . $data['email'] . $tdclose;
                }
                if ($viewreport['candidateAddress'] != '0') {
                    $CPdata4 = $tdopen . $fulladdress . $tdclose;
                }
                if ($viewreport['candidateTel'] != '0') {
                    $CPdata5 = $tdopen . $cphoneno . $tdclose;
                }
                if ($viewreport['designation'] != '0') {
                    $CPdesignation = $tdopen . $rsdesignation . $tdclose;
                }
                if ($viewreport['department'] != '0') {
                    $CPdepartment = $tdopen . $rsdepartment . $tdclose;
                }
                if ($viewreport['enrolstatus'] != '0') {
                    $CPenrolstatus = $tdopen . $rsenrolstatus . $tdclose;
                }

                // echo $CPdata1;
            }

            if ($sid == '0') {
                // Candidate Performance
                if ($viewreport['curriculumname'] != '0') {
                    $CPdata6 = $tdopen . $cname . $tdclose;
                }
                if ($viewreport['curriculumcode'] != '0') {
                    $CPdata7 = $tdopen . $ccode . $tdclose;
                }
                if ($viewreport['performancestatus'] != '0') {
                    $CPdata8 = $tdopen . $cstatus . $tdclose;
                }
                if ($viewreport['modulecompleted'] != '0') {
                    $CPdata9 = $tdopen . $mcompleted . $tdclose;
                }
                if ($viewreport['totaltimeperformance'] != '0') {
                    $CPdata10 = $tdopen . $totaltimeaccess . $tdclose;
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
				$test_status1='';
				$fgrade1='';
				$datefinish1='';	
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
				if($testgrade1['timefinish']=='0'){$datefinish1 = 'incomplete';}else{ date('d/m/Y H:i:s', $testgrade1['timefinish']);}
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
                $test_status2='';
				$fgrade2='';
				$datefinish2='';
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
				if($testgrade2['timefinish']=='0'){$datefinish2 = 'incomplete';}else{$datefinish2 = date('d/m/Y H:i:s', $testgrade2['timefinish']);}
				$testresult2 = $test_status2." - ".$fgrade2."% (".$datefinish2.")";//$testresult2 = $test_status2." - ".$fgrade2."%";
				}//end while 2nd attempt
			
				$alltestresult = $testresult1."<br>".$testresult2;	
				//$qrytest = "Select {$sselect2} From {$sstatement2}";
				//mmn end
                if ($viewreport['examinationstatus'] != '0') {
                    $CPdata11a = $tdopen .$test_status1 . $tdclose;
					$CPdata11b = $tdopen .$fgrade1 . $tdclose;
					$CPdata11c = $tdopen .$datefinish1 . $tdclose;
					$CPdata11d = $tdopen .$test_status2 . $tdclose;
					$CPdata11e = $tdopen .$fgrade2 . $tdclose;
					$CPdata11f = $tdopen .$datefinish2 . $tdclose;
                }
                /*mmn off if ($viewreport['markperformance'] != '0') {
                    $CPdata12 = $tdopen . '' . $tdclose;
                }*/
                if ($viewreport['subscriptiondate'] != '0') {
                    $CPdata13 = $tdopen . $subscriptiondate . $tdclose;
                }
                if ($viewreport['expirydate'] != '0') {
                    $CPdata14 = $tdopen . $courseexpirydate . $tdclose;
                }
                if ($viewreport['lastaccess'] != '0') {
                    $CPdata15 = $tdopen . $lastuseraccess . $tdclose;
                }
            } else if ($sid == '1') {
                // IPD Course Performance
                if ($viewreport['cnameexam'] != '0') {
                    $CPdata6 = $tdopen . $cname . $tdclose;
                }
                if ($viewreport['ccodeexam'] != '0') {
                    $CPdata7 = $tdopen . $ccode . $tdclose;
                }
                if ($viewreport['cattempts'] != '0') {
                    $CPdata8 = $tdopen . $sqla . $tdclose;
                }
                if ($viewreport['learningoutcomes'] != '0') {
                    $CPdata9 = $tdopen . $lolist . $tdclose;
                }
                if ($viewreport['scoreonlo'] != '0') {
                    $CPdata10 = $tdopen . " - " . $tdclose;
                }
                if ($viewreport['passes'] != '0') {
                    $CPdata11 = $tdopen . $passes . $tdclose;
                }
                if ($viewreport['passrate'] != '0') {
                    $CPdata12 = $tdopen . $passrate . $tdclose;
                }
            } else if ($sid == '2') {
                // Course Statistics %					
                if ($viewreport['cname_statistics'] != '0') {
                    $CPdata6 = $tdopen . $cname . $tdclose;
                }
                if ($viewreport['ccode_statistics'] != '0') {
                    $CPdata7 = $tdopen . $ccode . $tdclose;
                }
                if ($viewreport['statusstistics'] != '0') {
                    $CPdata8 = $tdopen . $statusenrollment . $tdclose;
                }
                if ($viewreport['mcomplete_statistics'] != '0') {
                    $CPdata9 = $tdopen . $modulelist . $tdclose;
                }
                if ($viewreport['totaltime_statistics'] != '0') {
                    $CPdata10 = $tdopen . $gradestatus . $tdclose;
                }
                if ($viewreport['examstatus_statistics'] != '0') {
                    $CPdata11 = $tdopen . $totaltimeaccess . $tdclose;
                }
            }

            // data here!
            if ($sid == '0') {  // selected report == 0
                if ($i < '0') {
                    $fileContent = "" . $CPorgname . $CPemployeeid . $CPdata1 . $CPdata2 . $CPdata3 . $CPdata4 . $CPdata5 . $CPdesignation . $CPdepartment . $CPenrolstatus. $CPdata6 . $CPdata7 . $CPdata8 . $CPdata9 . $CPdata10 . $CPdata11a . $CPdata11b .$CPdata11c .$CPdata11d.$CPdata11e.$CPdata11f . $CPdata12 . $CPdata13 . $CPdata14 . $CPdata15 . "";
                } else {
                    $fileContent = "<tr>" . $CPorgname . $CPemployeeid . $CPdata1 . $CPdata2 . $CPdata3 . $CPdata4 . $CPdata5 . $CPdesignation . $CPdepartment . $CPenrolstatus. $CPdata6 . $CPdata7 . $CPdata8 . $CPdata9 . $CPdata10 . $CPdata11a . $CPdata11b .$CPdata11c .$CPdata11d.$CPdata11e.$CPdata11f . $CPdata12 . $CPdata13 . $CPdata14 . $CPdata15 . "</tr>";
                }
            } else if ($sid == '1') {  // selected report == 1
                if ($i < '0') {
                    $fileContent = "" . $CPdata1 . $CPdata2 . $CPdata3 . $CPdata4 . $CPdata5 . $CPdata6 . $CPdata7 . $CPdata8 . $CPdata9 . $CPdata10 . $CPdata11 . $CPdata12 . "";
                } else {
                    $fileContent = "<tr>" . $CPdata1 . $CPdata2 . $CPdata3 . $CPdata4 . $CPdata5 . $CPdata6 . $CPdata7 . $CPdata8 . $CPdata9 . $CPdata10 . $CPdata11 . $CPdata12 . "</tr>";
                }
            } else if ($sid == '2') {      // selected report == 2
                if ($i < '0') {
                    $fileContent = "" . $CPdata6 . $CPdata7 . $CPdata8 . $CPdata9 . $CPdata10 . $CPdata11 . "";
                } else {
                    $fileContent = "<tr>" . $CPdata6 . $CPdata7 . $CPdata8 . $CPdata9 . $CPdata10 . $CPdata11 . "</tr/>";
                }
            }
            $fileContent = str_replace("<br/><br/>", "<br/>", $fileContent);
            echo $fileContent;
        } else {
            echo "<td>" . get_string('norecords') . "</td>";
        }
        echo '</tr>';
    }
    echo "</table>";
}
?> 