<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once('config.php');
require_once($CFG->libdir . '/datalib.php');
require_once('lib.php');
include('organization/lib.php');
include('manualdbconfig.php');

echo date('d/m/Y H:i:s', time());
// echo date("d/m/Y", strtotime("now"."+120days"));
$userrole = get_rolename();
$image = '<image src="'.$CFG->wwwroot.'/image/success.png" width="20px" alt="Included in course package" title="included in course package" />';
$wrongicon = '<image src="'.$CFG->wwwroot.'/image/wrong.png" width="20px" alt="Not included in course package" title="Not included in course package" />';


/*function reactiveusers(){
    global $DB;
    $reactiveuser = new stdClass();
    $reactiveuser ->id = 496;
    $reactiveuser ->timecreated = time();
    $reactiveuser ->lasttimecreated = strtotime("now"."+120days");

    $saverecord = $DB->update_record('user', $reactiveuser );
    return $saverecord;    
}

reactiveusers();*/
?>
<table border="1" style="border-collapse: collapse;">
    <tr style="text-align:center; font-weight: bolder;">
        <td></td>
        <td colspan="3">Users</td>
        <td colspan="3">LMS Status</td>
        <td colspan="3">Course Status</td>
        <td colspan="3">Test Status</td>
    </tr>    
    <tr style="text-align:center; font-weight: bolder;">
        <td>No</td>
        <td>Candidate ID</td>
        <td style="text-align:left;">Candidate Name</td>
        <td style="text-align:left;">Email</td>
        <td>Start Date registration</td>
        <td>End Date registration</td>
        <td>Status</td>
        <td>Enrol Start</td>
        <td>Enrol End</td>
        <!--td>Last Login</td-->
        <td>Last access</td>
        <!--td>Extended Course</td-->
        <td>Final Test</td>
        <td>Mock Test</td>
        <!--td>Test Attempt</td--> 
        <td>Availibility</td>        
    </tr>
    <?php
//echo date('dmY',strtotime('120 days'));
    $courseid = '32';
    $examid ='26';
    $qry1 = "SELECT id FROM mdl_cifaenrol WHERE courseid = '" . $courseid . "'";
    $sql1 = mysql_query($qry1);
    while ($rs1 = mysql_fetch_array($sql1)) {        
        $qry2 = "SELECT a.status, a.enrolid, b.firstaccess,b.lastaccess,b.firstname, b.middlename, b.lastname, b.traineeid,a.userid,a.timestart,a.timeend,b.lastlogin, a.lastaccess as courselastaccess,
			FROM_UNIXTIME(b.firstaccess,'%d/%m/%Y') as startdate, 
			FROM_UNIXTIME(b.timecreated,'%d/%m/%Y') as timecreated, 
			DATE_ADD(FROM_UNIXTIME(b.firstaccess,'%Y-%m-%d'), INTERVAL 60 DAY) as enddate, 
			DATE_ADD(FROM_UNIXTIME(b.timecreated,'%Y-%m-%d'), INTERVAL 120 DAY) as lasttimecreated, b.email 
			FROM mdl_cifauser_enrolments a, mdl_cifauser b 
			WHERE a.enrolid='" . $rs1['id'] . "' AND (b.usertype='" . $userrole . "' OR b.usertype='Inactive candidate') AND b.deleted!='1'
			AND a.userid!='391' AND a.userid!='269' AND a.userid=b.id ORDER BY b.firstaccess DESC";
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
            if(empty($rs2['middlename'])){
            $candidatefullname = $rs2['firstname'] . ' ' . $rs2['lastname'];
            }else{
            $candidatefullname = $rs2['firstname'] . ' ' . $rs2['middlename'].' '. $rs2['lastname'];
            }
            ?>
            <?php if (($rs2['firstaccess'] <= $sebulan)) { ?>
                <tr style="background-color: #F7CF07;">
                <?php } else if (($rs2['firstaccess'] <= $hours)) { ?>
                <tr style="background-color: #00FF00;"><?php } ?>
                <td><?= $bil++; ?></td>
                <td><?= strtoupper($rs2['traineeid']); ?></td>
                <td style=" text-align:left;"><?= $candidatefullname; ?></td>
                <td style=" text-align:left;"><?= $rs2['email']; ?></td>
                <!--td><?php
                    /*if ($rs2['firstaccess']) {
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
                    }*/
                    ?></td-->
                <td style="text-align:center;"><?= $rs2['timecreated']; ?></td>
                <td style="text-align:center;"><?= date('d/m/Y', strtotime($rs2['lasttimecreated'])); ?></td>
                <td style="text-align:center;">
                    <?php
                    echo checkuserstatus($rs2['userid']);
                    ?>
                </td>
                <td style="text-align:center;"><?= date('d/m/Y', $rs2['timestart']); ?></td>
                <td style="text-align:center;">
                <?php 
                    if($rs2['timeend']){
                    echo date('d/m/Y', $rs2['timeend']); 
                    }else{
                        echo get_string('never');
                    }
                ?>             
                </td>
                <!--td><?php
                    /*if ($rs2['lastlogin'] == '0') {
                        echo '0';
                    } else {
                        echo date('d/m/Y H:i:s', $rs2['lastlogin']);
                    }*/
                    ?></td-->
                <td style="text-align:center;"><?php
                    if ($rs2['courselastaccess']) {
                        echo date('d/m/Y H:i:s', $rs2['courselastaccess']);
                    } else {
                        echo $strlastaccess = get_string('never');
                    }
                    ?></td>
                <?php /*
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
                            echo 'Expired';
                        } else {
                            echo ' - ';
                        }
                        ?>
                    </form>
                </td>
                */ ?>
                <td style="text-align:center;">
                    <?php
                        $sql = "							
                                Select
                                  COUNT(DISTINCT a.fullname), a.fullname, c.timestart, c.timeend, DATE_ADD(FROM_UNIXTIME(d.timecreated,'%Y-%m-%d'), INTERVAL 120 DAY) as lasttimecreated
                                From
                                  {course} a Inner Join
                                  {enrol} b On a.id = b.courseid Inner Join
                                  {user_enrolments} c On b.id = c.enrolid Inner Join
                                  {user} d On c.userid = d.id
                                Where
                                  c.userid = '" . $rs2['userid'] . "' And
                                  b.enrol = 'manual' And
                                  a.category = '3' And
                                  a.visible = '1' And
                                  b.status = '0' Group By c.userid";

                        $rs = $DB->count_records_sql($sql);
                        if($rs==1){
                            echo $image;
                        }else{ echo $wrongicon; }                        
                    ?>
                </td>
                <td style="text-align:center;">
                    <?php
                        $sql3 = "							
                                Select
                                  COUNT(DISTINCT a.fullname), a.fullname, c.timestart, c.timeend, DATE_ADD(FROM_UNIXTIME(d.timecreated,'%Y-%m-%d'), INTERVAL 120 DAY) as lasttimecreated
                                From
                                  {course} a Inner Join
                                  {enrol} b On a.id = b.courseid Inner Join
                                  {user_enrolments} c On b.id = c.enrolid Inner Join
                                  {user} d On c.userid = d.id
                                Where
                                  c.userid = '" . $rs2['userid'] . "' And
                                  b.enrol = 'manual' And
                                  a.category = '9' And
                                  a.visible = '1' And
                                  b.status = '0' Group By c.userid";

                        $rs3 = $DB->count_records_sql($sql3);
                        if($rs3==1){
                            echo $image;
                        }else{ echo $wrongicon; }
                    ?>                    
                </td>                
                <!--td style="text-align:center;">
                    <?php
                        //echo test_statussql($examid, $rs2['userid']);
                    ?>
                </td-->   
                <td style="text-align:center;">
                    <?php
					
                    $sql = "Select  COUNT(DISTINCT b.attempt),
                                            b.userid,
                                            a.name, a.id
                                          From
                                            mdl_cifaquiz a Inner Join
                                            mdl_cifaquiz_attempts b On a.id = b.quiz
                                          Where
                                            a.id = '" . $examid . "' And b.userid = '" . $rs2['userid']  . "'";
                    // $data2 = $DB->get_record_sql($sql);
                    $crecords = $DB->count_records_sql($sql);                    				
                    if($crecords>=1){ 
                        if($crecords==2){
                            echo 'Limited';
                        }
                        if($crecords==1){
                            echo $crecords . ' attempt';
                        }
                    }else{
                        echo $crecords='0pen';
                    }
                    ?>
                </td>                
            </tr>
            <?php
            if ($rs2['courselastaccess'] == '0') {
                //echo $sqlu=mysql_query("UPDATE mdl_cifauser_enrolments SET lastaccess='".$rs2['lastaccess']."' WHERE userid='".$rs2['userid']."' AND enrolid='".$rs2['enrolid']."'");
            }
        } //end of loop user list 
    } //end of loop enrolment method for foundation.
    ?>
</table>