<?php
//email to candidate yet to start

require_once('config.php');
require_once($CFG->libdir . '/datalib.php');
include('manualdbconfig.php');

/*$deleterec = new stdClass();
$deleterec->id = '529';
$deleterec->orgtype = '7';

$saverecord = $DB->update_record('user', $deleterec);

$deleterec1 = new stdClass();
$deleterec1->id = '531';
$deleterec1->orgtype = '7';

$saverecord1 = $DB->update_record('user', $deleterec1);

$deleterec2 = new stdClass();
$deleterec2->id = '532';
$deleterec2->orgtype = '7';

$saverecord2 = $DB->update_record('user', $deleterec2);

$deleterec3 = new stdClass();
$deleterec3->id = '536';
$deleterec3->orgtype = '7';

$saverecord3 = $DB->update_record('user', $deleterec3);*/


echo date('d/m/Y', time());
$userrole = get_rolename();
?>
<table border="1" style="border-collapse: collapse;">
    <tr>
        <td>No</td>
        <td>Candidate ID</td>
        <td>Candidate Name</td>
        <td>Email</td>
        <td>Start Date</td>
        <td>End Date</td>
        <td>Date registration</td>
        <td>Enddate registration</td>
        <td>Enrol Start</td>
        <td>Enrol End</td>
        <td>Last Login</td>
        <td>Last access</td>
        <td>Status</td>
        <td>Extended Course</td>
        <td>Final Test</td>
        <td>Group</td>
    </tr>
    <?php
//echo date('dmY',strtotime('120 days'));
    $courseid = '32';
    $examid = '26';
    $qry1 = "SELECT id FROM mdl_cifaenrol WHERE courseid = '" . $courseid . "'";
    $sql1 = mysql_query($qry1);
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
                <td><?php
                if ($rs2['firstaccess']) {
                    echo $rs2['startdate'];
                } else {
                    echo $strlastaccess = get_string('never');
                }
                ?></td>
                <td><?php
                if ($rs2['firstaccess']) {
                    echo $newenddate;
                } else {
                    echo $strlastaccess = get_string('never');
                }
                ?></td>
                <td><?= $rs2['timecreated']; ?></td>
                <td><?= date('d/m/Y', strtotime($rs2['lasttimecreated'])); ?></td>
                <td><?= date('d/m/Y', $rs2['timestart']); ?></td>
                <td>
                    <?php
                    if ($rs2['timeend']) {
                        echo date('d/m/Y', $rs2['timeend']);
                    } else {
                        echo get_string('never');
                    }
                    ?>             
                </td>
                <td><?php
                    if ($rs2['lastlogin'] == '0') {
                        echo '0';
                    } else {
                        echo date('d/m/Y H:i:s', $rs2['lastlogin']);
                    }
                    ?></td>
                <td><?php
                    if ($rs2['courselastaccess']) {
                        echo date('d/m/Y H:i:s', $rs2['courselastaccess']);
                    } else {
                        echo $strlastaccess = get_string('never');
                    }
                    ?></td>
                <td>
                    <?php
                    switch ($enrolstatus) {
                        case -1:
                            echo 'No Change';
                            break;
                        case 0:
                            echo 'Active';
                            break;
                        case 1:
                            echo 'Suspended';
                            break;
                    }
                    ?>
                </td>
                <td><form method="post">
                        <?php if ((time() <= strtotime($rs2['lasttimecreated'])) && (time() >= $rs2['timeend'])) { ?>
                            <?php
                            $contextid = getContextIdCourse($courseid)->id;     // context id
                            if ($_POST['userid'] == $rs2['userid']) {

                                $lastenrolldate = strtotime(date('d-m-Y H:i:s', $rs2['timeend']) . "+ 60 day");
                                $update = mysql_query("UPDATE mdl_cifauser_enrolments SET timeend='" . $lastenrolldate . "', timestart='" . $rs2['timeend'] . "' WHERE userid='" . $rs2['userid'] . "'");
                                $updateUT = mysql_query("UPDATE mdl_cifauser SET usertype='Active candidate' WHERE id='" . $rs2['userid'] . "'");
                                $del = mysql_query("DELETE FROM mdl_cifarole_assignments WHERE userid='" . $rs2['userid'] . "' AND contextid='1'");

                                // save records to database
                                $record = new stdClass();
                                $record->userid = $rs2['userid'];
                                $record->contextid = $contextid;
                                $record->roleid = 5;
                                $record->modifierid = 2;
                                $record->timemodified = time();
                                $DB->insert_record('role_assignments', $record, false);
                            }
                            ?>
                            <input type="hidden" name="userid" id="userid" value="<?= $rs2['userid']; ?>" />
                            <input type="submit" name="extendedcourse" id="extendedcourse" value="Extend" />

                            <?php
                        } else if (time() > strtotime($rs2['lasttimecreated']) && time() > $rs2['timeend']) {
                            echo 'dah expired';
                        } else {
                            echo ' - ';
                        }
                        ?>
                    </form>
                </td>
                <td style="text-align:center;">
                    <?php
                    $sql = "Select
                                b.userid
                              From
                                mdl_cifaquiz a Inner Join
                                mdl_cifaquiz_attempts b On a.id = b.quiz
                              Where
                                a.id='" . $examid . "' AND b.userid = '" . $rs2['userid'] . "'";
                    $data = $DB->get_recordset_sql($sql);
                    $e = '1';
                    foreach ($data as $d) {
                        $c = $e++;
                    }
                    if ($c >= 1) {
                        if ($c == 2) {
                            echo 'Close';
                        }
                        if ($c == 1) {
                            echo $c . 'attempt';
                        }
                    } else {
                        echo $c = '0pen';
                    }
                    ?>
                </td><td><?= $rs2['orgtype']; ?></td>
            </tr>
            <?php
            if ($rs2['courselastaccess'] == '0') {
                //echo $sqlu=mysql_query("UPDATE mdl_cifauser_enrolments SET lastaccess='".$rs2['lastaccess']."' WHERE userid='".$rs2['userid']."' AND enrolid='".$rs2['enrolid']."'");
            }
        } //end of loop user list 
    } //end of loop enrolment method for foundation.
    ?>
</table>