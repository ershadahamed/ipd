<body onLoad="window.print()">    
<style>
        html, body {
            font-family: Verdana,Geneva,sans-serif!important;
        }
        body {
            font: 14px/1.231 arial,helvetica,clean,sans-serif;
        }
        h2{
            width: 90%;
            margin: 1em auto;        
        }
        #availablecourse tr.yellow th {
    border: 1px solid #cccccc;
    background: #f3f3f3;
    color: #000;
}
    </style>
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * http://localhost/shapeipd/mod/quiz/result-summay.php?attemptid=383&examid=26&courseid=64&seskey=DoT3eAez6v
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/organization/lib.php');
require_once($CFG->dirroot . '/lib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->dirroot . '/manualdbconfig.php');


$courseid = '32'; // $_GET['courseid'];
$cid = '64';
$courseenrolid = optional_param('cenrolid', '', PARAM_INT); 
$userid = optional_param('uid', '', PARAM_INT);
$testfullname = buildsqlipdcert($courseenrolid)->fullname;
$eid = buildsqlresittest($userid, $testfullname, 3); // quizid Final test

if(testattemptlimit($eid, $userid)=='2'){
    $quiz_attemptid = getattemptid($userid, $eid, 2);
}else if(testattemptlimit($eid, $userid)=='1'){
    $quiz_attemptid = getattemptid($userid, $eid, 1);
}

$getcategorysql = mysql_query("SELECT category FROM {$CFG->prefix}course WHERE id='" . $courseid . "'");
$getcategory = mysql_fetch_array($getcategorysql);
$ccategory = $getcategory['category'];

$site = get_site();

$resultsummary = ucwords(strtolower(get_string('quiz_result_summary_mock', 'quiz')));
$mocktitle = get_string('quiz_result_summary_mock', 'quiz');
$finaltesttitle = "SHAPE<sup>&reg;</sup> IPD Final Test";
$title = "$SITE->shortname: " . $resultsummary;
$PAGE->set_title($title);
$PAGE->set_heading($site->fullname);
$PAGE->set_pagelayout('buy_a_cifa');

$url1 = new moodle_url('/coursesindex.php', array('id' => $userid)); 	
$urlmocktest = new moodle_url('/course/mock_test.php', array('id' => $userid)); 	
$urlfinaltest = new moodle_url('/course/finaltest.php', array('id' => $userid)); 	
$urlsummary = $CFG->wwwroot . '/mod/quiz/resultsummary_adminview.php?examid=' . $eid . '&courseid=' . $cid . '&seskey=' . sesskey();
$url = $CFG->wwwroot;
$PAGE->navbar->add('Support Management Activities', $url)->add(get_string('coursehistory'), $url);
// $PAGE->navbar->add(get_string('supportmanagementactivities'))->add(get_string('coursehistory'));
$PAGE->navbar->add('Result Summary', $urlsummary);
//echo $OUTPUT->header();


if (isloggedin()) {
    //add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
    //echo $OUTPUT->heading($resultsummary, 2, 'headingblock header');
    ?>	
    <style>       
    <?php
    include('../../css/style2.css');
    include('../../css/button.css');
    include('../../css/pagination.css');
    include('../../css/grey.css');
    ?>
    </style>
    <style type="text/css">
        #welcometable{
            /*font:18px/1.231 arial,helvetica,clean,sans-serif;
            margin-left: 30px;*/
        }
    </style>
    <script type="text/javascript">
        <!--
        function myPopup2() {
            var printtxt = document.getElementById('printtxt').value;
            window.open(printtxt, "Window2", "status = 1, width=880, height=1000 resizable = yes, scrollbars=1");
            //window.open(printtxt);
        }
        //-->
    </script>
    <div id="welcometable"><h2>Result Summary</h2></div>	
    <div style="min-height: 400px;">

        <?php
        $sel = mysql_query("SELECT * FROM mdl_cifauser WHERE id='" . $userid . "'");
        $q = mysql_fetch_array($sel);


        $qattempt = "
				Select
				  b.responsesummary,
				  b.rightanswer,
				  b.maxmark,
				  a.uniqueid,
				  a.quiz as quizattempt,
				  a.userid,
				  a.attempt,       
				  a.sumgrades,
				  a.timestart,
				  a.timefinish,
				  a.timemodified,
				  a.preview,
				  a.needsupgradetonewqe,				  
				  b.questionid,
				  b.slot,
				  b.questionusageid,
				  d.name,
				  d.category,
				  e.id As categorygroup,
				  e.name As questiongroup,
				  f.grade as usergrade,
				  g.name As examname,
				  e.parent
				From
				  mdl_cifaquiz_attempts a Inner Join
				  mdl_cifaquestion_attempts b On a.uniqueid = b.questionusageid Inner Join
				  mdl_cifaquestion d On b.questionid = d.id Inner Join
				  mdl_cifaquestion_categories e On d.category = e.id Inner Join
				  mdl_cifaquiz_grades f On f.userid = a.userid Inner Join
				  mdl_cifaquiz g On f.quiz = g.id  
				Where
				  a.userid = '" . $q['id'] . "' And g.course = '" . $cid . "' And a.quiz = '" . $eid . "' 
				Group By e.id ORDER BY b.slot ASC
			";
        $sgrade = mysql_query($qattempt);
        //Group By e.name	

        $sgrade2 = mysql_query("SELECT *, a.grade as usergrade FROM mdl_cifaquiz_grades a, mdl_cifaquiz b WHERE a.quiz=b.id AND userid='" . $q['id'] . "'");
        $grade = mysql_fetch_array($sgrade2);
        ?>
        <form id="form1" name="form1" method="post" action="">
            <table id="availablecourse" style="margin: 1em 0 2em;width:60%;margin-left:5%">
                <tr>
                    <td style="width:130px;"><?= get_string('candidatename'); ?></td>
                    <td style="width:1%;"><strong>:</strong></td>
                    <td><?= ucwords(strtolower($q['firstname'] . ' ' . $q['lastname'])); ?></td>
                </tr>
                <tr>
                    <td><?= get_string('candidateid'); ?></td>
                    <td><strong>:</strong></td>
                    <td><?= strtoupper($q['traineeid']); ?></td>
                </tr>	
                <tr>
                    <td>Date</td>
                    <td><strong>:</strong></td>
                    <td>
                        <?php
                        $sque = mysql_query("SELECT timestart, timefinish FROM mdl_cifaquiz_attempts WHERE userid='" . $q['id'] . "' AND quiz='" . $grade['id'] . "'");
                        $query = mysql_fetch_array($sque);

                        echo date('d-m-Y', $query['timestart']) . '<br/>';
                        ?>				
                    </td>
                </tr>			
            </table>

            <table id="availablecourse" style="width:90%">
                <tr class="yellow" style="background: #f9f9f9 !important;">
                    <!--th class="adjacent" width="1%">No</th-->
                    <th class="adjacent" width="39%" style="text-align:left;"><strong><?= get_string('resultsection', 'quiz'); ?></strong></th>
                    <th class="adjacent" width="18%" style="text-align:center;"><strong><?= get_string('questions', 'quiz'); ?></strong></th>
                    <th class="adjacent" width="18%" style="text-align:center;"><strong><?= get_string('correctanswer', 'quiz'); ?></strong></th>
                    <th class="adjacent" width="18%" style="text-align:center; display:none;"><?= get_string('marks'); ?></th>	
                </tr>
                <?php
                $bil = 1;
                $q1sum = 0;
                $count = 0;
                while ($qgrade = mysql_fetch_array($sgrade)) {
                    $no = $bil++;
                    ?>
                    <tr>
                        <td class="adjacent" style="text-align:left;">
                            <?php
                            echo $qgrade['questiongroup'];
                            ?>
                        </td>
                        <td class="adjacent" align="center">
                            <?php
                            //count total question
                            $attemptidquery = mysql_query("
						Select
						  a.id
						From
						  mdl_cifaquiz_attempts a Inner Join
						  mdl_cifaquestion_attempts b On a.uniqueid = b.questionusageid  
						Where
						  a.id='" . $quiz_attemptid . "'
					");
                            $numattemptid = mysql_num_rows($attemptidquery);
                            echo $numattemptid;
                            ?>
                        </td>
                        <td class="adjacent" align="center">
                            <?php
                            //count total question attempt/Answer		
                            $squerytotal = mysql_query("
						Select
						  a.id
						From
						  mdl_cifaquiz_attempts a Inner Join
						  mdl_cifaquestion_attempts b On a.uniqueid = b.questionusageid  
						Where
						  a.id='" . $quiz_attemptid . "' And
						  b.responsesummary = b.rightanswer AND b.responsesummary != ''	
					");

                            $totalquestionattempt = mysql_num_rows($squerytotal);
                            $totalanswered+=$totalquestionattempt;
                            echo $totalquestionattempt; //correct answer
                            //score per question						
                            $marksperlearning = ($totalquestionattempt / $numattemptid) * 100;

                            //total final per marks
                            $q1sum+=(float) ($totalquestionattempt / $numattemptid) * 100;
                            $count++;

                            //Final marks
                            $q1final_result = $q1sum / $count;
                            ?>				
                        </td>
                        <td class="adjacent" align="center" style="display:none;">
                            <?php
                            //insert record to db
                            $learningoutcome = $qgrade['categorygroup'];
                            $timecreated = strtotime('now');
                            $correctanswered = round($marksperlearning);
                            $tquestion = $totalquestionattempt;
                            $examtokenid = $q['access_token'];

                            $checktoken = mysql_query("SELECT * FROM mdl_cifalearning_outcome WHERE examid='" . $examtokenid . "'");
                            $kirachecktoken = mysql_num_rows($checktoken);
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <!---total question / attempts / score---->
                <tr>
                    <td class="adjacent" style="text-align:left; font-weight:bolder"><?= get_string('totalquestion', 'quiz'); ?></td>
                    <td align="center" class="adjacent" style="text-align:center;font-weight:bolder"><?= $numattemptid; ?></td>
                    <td class="adjacent" style="text-align:center;font-weight:bolder"><?php
                        //count total question answered	
                        echo $totalanswered;
                        ?></td>
                    <td class="adjacent" style="background: #58FA58;display:none;">
                        <?php
                        //insert record to db mdl_cifaexam_grade
                        $checkusers = mysql_query("SELECT userid, traineeid FROM mdl_cifaexam_grade WHERE userid='" . $userid . "' AND examid='" . $_GET['examid'] . "'");
                        $kirausersno = mysql_num_rows($checkusers);
                        echo $kirausersno;

                        //insert record to db mdl_cifaexam_grade
                        $check_quiz = mysql_query("SELECT userid FROM mdl_cifaquiz_attempts_v WHERE userid='" . $userid . "'");
                        $kira_quiz = mysql_num_rows($check_quiz);

                        $c1 = $markscrore['uniqueid'];
                        $c2 = $markscrore['quizattempt'];
                        $z3 = $markscrore['attempt'];
                        $z4 = $markscrore['sumgrades'];
                        $z5 = $markscrore['timestart'];
                        $z6 = $markscrore['timemodified'];
                        $z7 = $markscrore['preview'];
                        $z8 = $markscrore['needsupgradetonewqe'];

                        ?>				
                    </td>
                </tr>
                <tr>
                    <td class="adjacent" style="text-align:left; font-weight:bolder"><?= get_string('resultpercent', 'quiz'); ?></td>
                    <td class="adjacent" >&nbsp;</td>
                    <td class="adjacent" ><?php echo '<strong>' . round($q1final_result) . ' % </strong>'; ?></td>
                    <td class="adjacent" style="display:none;"></td>
                </tr>
            </table>
            <br/>
        </form>
    </div>
    <?php
} else {
    echo 'You not allow to view this summary;';
    $linkto = $CFG->wwwroot . '/index.php';
    redirect($linkto);
}
// footer
//echo $OUTPUT->footer();
?>