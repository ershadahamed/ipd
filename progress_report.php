<?php
require_once('config.php');
require_once('manualdbconfig.php');
require_once('organization/lib.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/logactivity_lib.php');

$site = get_site();

$purchase = get_string('candidateprogress');
$linkpurchase = '<a href="">' . $purchase . '</a>';
$title = "$SITE->shortname: " . $purchase;
$PAGE->set_title($title);
$PAGE->set_heading($site->fullname);
$PAGE->navbar->add($linkpurchase);
$PAGE->set_pagelayout('report');

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('candidateprogress'), 2, 'headingblock header');

$active = 'Active candidate';
$inactive = 'Inactive candidate';

if (isloggedin()) {
    ?>
    <link rel="stylesheet" type="text/css" media="all" href="offlineexam/jsDatePick_ltr.min.css" />
    <script type="text/javascript" src="offlineexam/jquery.1.4.2.js"></script>
    <script type="text/javascript" src="offlineexam/jsDatePick.jquery.min.1.3.js"></script>
    <script type="text/javascript">
        $("tr").click(function () {
            $(this).addClass("selected").siblings().removeClass("selected");
        });
    </script>
    <style type="text/css"><?php include('css/style2.css'); ?></style><br/>
    <form id="formname" name="formname" method="post">
        <table border="0" cellpadding="1" cellspacing="1" style="width:95%; font:13px/1.231 arial,helvetica,clean,sans-serif bolder;">
            <tr>
                <td style="width:180px;text-align:right;">
                    <select name="pilihancarian" style="width:180px;">
                        <option value=""> - select - </option>
                        <option value="traineeid"><?= get_string('candidateid'); ?></option>
                        <option value="fullname"><?= get_string('modulenameprogress'); ?></option>
                        <!--option value="traineeid">Date of Enrol</option>
                        <option value="status">Student <?//=get_string('status');?></option-->
                        <!--option value="quizgrade"><?//=get_string('coursescore');?></option-->
                    </select>
                </td>
                <td width="10%"><input type="text" name="traineeid" style="width:250px;" /></td>
                <td><input type="submit" name="search" value="<?= get_string('view'); ?>"/></td>
            </tr>		
        </table>
    </form>
    <!---End search---->

    <?php
    $selectsearch = $_POST['pilihancarian'];
    $candidateid = $_POST['traineeid'];

    if ($USER->id != '2') {
        $fromstatement = "
				mdl_cifauser a Inner Join
				mdl_cifauser_enrolments b On a.id = b.userid Inner Join
				mdl_cifaenrol c On c.id = b.enrolid Inner Join
				mdl_cifacourse d On d.id = c.courseid Inner Join
				mdl_cifauser_accesstoken e On a.id=e.userid
		";
    } else {
        $fromstatement = "
				mdl_cifauser a Inner Join
				mdl_cifauser_enrolments b On a.id = b.userid Inner Join
				mdl_cifaenrol c On c.id = b.enrolid Inner Join
				mdl_cifacourse d On d.id = c.courseid
		";
    }
    $wherestatement = " a.confirmed='1' AND d.category='1' AND a.username LIKE '%A%' AND ((a.usertype='" . $active . "') OR (a.usertype='" . $inactive . "'))";
    if ($candidateid != '' && $selectsearch != '') {
        $wherestatement.= " AND (($selectsearch LIKE '%" . $candidateid . "%'))";
    }
    $sql = mysql_query("
		SELECT *, b.lastaccess as courselastaccess, FROM_UNIXTIME(a.timecreated,'%d/%m/%Y') as timecreated
		FROM {$fromstatement}
		WHERE {$wherestatement}
		ORDER BY a.username DESC, a.firstname 
	");
    ?>
    <div style="width:100%; min-height:78px;/*overflow-x:auto;overflow-y:hidden;*/ margin-bottom:20px;">
        <table id="availablecourse3" width="100%"><tbody>
                <tr class="yellow">
                    <th colspan="2" align="center">Users</th>
                    <th colspan="2" align="center">Courses</th>
                    <th colspan="7" align="center">Status</th>
                </tr>
                <tr class="yellow">
                    <th width="6%"><?= get_string('candidateid'); ?></th>
                    <th width="15%" style="text-align:left;"><?= get_string('fullname'); ?></th>
                    <th width="18%" style="text-align:left;"><?= get_string('modulenameprogress'); ?></th>
                    <th width="5%"><?= get_string('status'); ?></th>
                    <th width="7%"><?= get_string('subscribeddate'); ?></th>
                    <th width="7%"><?= get_string('firstaccess'); ?></th>
                    <th width="7%"><?= get_string('completedate'); ?></th>
                    <th width="7%"><?= get_string('lastaccess'); ?></th>
                    <th width="5%"><?= get_string('status'); ?></th>
                    <th width="5%"><?= get_string('finalscore'); ?></th>
                    <!--th width="5%"><?//= get_string('coursescore'); ?></th-->
                    <th width="5%"><?= get_string('totaltime'); ?></th>
                </tr>
                <?php
                while ($sqluser = mysql_fetch_array($sql)) {
                    $fullname = ucwords(strtolower($sqluser['firstname'] . ' ' . $sqluser['lastname']));
                    
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
                                  a.userid = '" . $sqluser['userid'] . "')				
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
                        a.course,
                        b.timestart,
                        b.timefinish
                    ";
                    $sstatement = "
                        mdl_cifaquiz a Inner Join
                        mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
                        mdl_cifaquiz_grades c On b.quiz = c.quiz And b.userid = c.userid
                    ";
                    $sstatement.=" Where a.id = '" . $qgrade['quizid'] . "' And b.userid='" . $sqluser['userid'] . "'";
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
                        if (!$sqltestgrade['timeclose'] || strtotime('now') < $sqltestgrade['timeclose']) {
                            // The attempt is still in progress.
                            $cstatus = get_string('inprogress', 'quiz');
                        } else {
                            // $timetaken = format_time($sqlrow['timefinish'] - $sqlrow['timestart']);
                            $cstatus = userdate($sqltestgrade['timeclose']);
                        }
                    }

                    // Marks %
                    if ($testgraderow) {
                        $fgrade = round($finalgrade);
                    } else {
                        $fgrade = '-';
                    }                    

                    if ($sqluser['confirmed'] == '1') {
                        $coursestatus = 'confirmed';
                    }
                    
                    // Completed Module here!!!!
                    global $DB;
                    $rscc = printScormWithCourseId($sqluser['courseid']);
                    $a = '0';
                    foreach ($rscc as $r) {
                        // 
                        /*$sql = "Select COUNT(Distinct a.id)
                             From
                               {$CFG->prefix}scorm_scoes_track a
                             Where
                               a.userid='" . $sqluser['userid'] . "' AND
                               a.scormid='" . $r->scorm . "' AND
                               a.value = 'completed'
                             ";
                        $rsql = $DB->count_records_sql($sql);*/
                        
                        $rsql = $DB->count_records('scorm_scoes_track', array('userid' => $sqluser['userid'], 'scormid' => $r->scorm, 'value'=>'completed'));
                        
                        if ($rsql === chapteronscorm($r->scorm)) {
                            $a++;
                        }
                    }
                    if($a == getTotalScormOnCourse($sqluser['courseid'])) { $mcompleted = date('d/m/Y H:i', $sqluser['courselastaccess']); }
                    else { $mcompleted = ' - '; } 
                    // $mcompleted = $a . ' of ' . getTotalScormOnCourse($sqluser['courseid']) . ' Modules';                   
                    
                    $ts1 = strtotime(str_replace('/', '-', $sqltestgrade['timefinish']));
                    $ts2 = strtotime(str_replace('/', '-', $sqltestgrade['timestart']));
                    $diff = abs($ts1 - $ts2) / 3600;
                    ?>	
                    <tr>
                        <td class="adjacent" style="text-align:center;"><?= strtoupper($sqluser['username']); ?></td>
                        <td class="adjacent" style="text-align:left;"><?= $fullname; ?></td>
                        <td class="adjacent" style="text-align:left;">
                            <?= $sqluser['fullname']; ?>
                        </td>
                        <td class="adjacent" style="text-align:center;">
                            <?php
                            if ($sqluser['confirmed'] == '1') {
                                $coursestatus = 'confirmed';
                                echo $coursestatus;
                            }
                            ?>
                        </td>
                        <td class="adjacent" style="text-align:center;">
                            <?php
                            if ($sqluser['timecreated'] != '0') {
                                echo $sqluser['timecreated'];
                            } else {
                                echo ' - ';
                            }                           
                            ?>	  
                        </td>
                        <td class="adjacent" style="text-align:center;">
                            <?php
                            if ($sqluser['firstaccess'] != '0') {
                                echo date('d/m/Y H:i', $sqluser['firstaccess']);;
                            } else {
                                echo ' - ';
                            }                             
                            ?>
                        </td>
                        <td class="adjacent" style="text-align:center;"><?php echo $mcompleted;?></td>
                        <td class="adjacent" style="text-align:center;">
                            <?php
                            if ($sqluser['courselastaccess'] != 0) {
                                $lastaccess = date('d/m/Y H:i', $sqluser['courselastaccess']);
                                echo $lastaccess;
                            } else {
                                echo ' - ';
                            }
                            ?>		
                        </td>
                        <td class="adjacent" style="text-align:center;">
                            <?php
                            echo $cstatus;
                            ?>
                        </td>
                        <td class="adjacent" style="text-align:center;">
                            <?php
                            echo $fgrade;                          
                            ?>
                        </td>
                        <!--td class="adjacent" style="text-align:center;">
                            <?php
                            /*/Course score -> exam@Quiz@test score === Perlu tukar kalo salah
                            $showsql = mysql_query("
				Select
				  *, b.grade as quizgrade
				From
				  mdl_cifauser a Inner Join
				  mdl_cifaquiz_grades b On a.id = b.userid Inner Join
				  mdl_cifaquiz_attempts c On b.userid = c.userid And b.quiz = c.quiz Inner Join
				  mdl_cifaquiz d On c.quiz = d.id
				Where
				  a.id='" . $sqluser['userid'] . "' AND d.course='" . $sqluser['courseid'] . "'
			");
                            $q1sum = 0;
                            $count2 = 0;
                            while ($showfinalscore = mysql_fetch_array($showsql)) {
                                $count2++;
                                $q1sum+=(float) $showfinalscore['quizgrade'];
                            }
                            $q1finalscore = $q1sum / $count2;
                            if ($q1sum != '') {
                                echo round($q1finalscore) . ' / 100';
                            } else {
                                echo ' - ';
                            }*/
                            ?>	  
                        </td-->
                        <td class="adjacent">
                            <?php
                            //total time
                            echo date('H:i:s', $diff); ;
                            $showtime = mysql_query("
				Select
				  *, b.grade as quizgrade
				From
				  mdl_cifauser a Inner Join
				  mdl_cifaquiz_grades b On a.id = b.userid Inner Join
				  mdl_cifaquiz_attempts c On b.userid = c.userid And b.quiz = c.quiz Inner Join
				  mdl_cifaquiz d On c.quiz = d.id
				Where
				  a.id='" . $sqluser['userid'] . "' AND d.course='" . $sqluser['courseid'] . "'
			");
                            $stime = mysql_fetch_array($showtime);
                            $timeFirst = $stime['timestart'];
                            $timeSecond = $stime['timemodified'];

                            $differenceInSeconds = $timeSecond - $timeFirst;
                            if ($stime['quizgrade'] != '') {
                                echo date('H:i:s', $differenceInSeconds);
                            }
                            ?>
                        </td>
                    </tr>
    <?php } ?>
            </tbody></table></div>
<?php } ?>
<?php echo $OUTPUT->footer(); ?>