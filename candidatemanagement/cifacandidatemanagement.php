<?php
require_once('../config.php');
require_once('../manualdbconfig.php');
require_once($CFG->dirroot . '/lib/blocklib.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/logactivity_lib.php');

include_once ('../pagingfunction.php');

$PAGE->set_url('/');
$PAGE->set_course($SITE);

$navtitle = get_string('mycandidate');
$titleccmanagement = get_string('cifacandidatemanagement');
$ccmanagement = get_string('ccmanagement');
$url1 = $CFG->wwwroot . '/candidatemanagement/cifacandidatemanagement.php?id=' . $USER->id;
$PAGE->navbar->add(ucwords(strtolower($navtitle)), $url1)->add(ucwords(strtolower($ccmanagement)), $url1);

$PAGE->set_pagetype('site-index');
$editing = $PAGE->user_is_editing();
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('buy_a_cifa');

echo $OUTPUT->header();
//echo '<div style="font-weight:bolder;"><h2>'.$listusertoken.'</h2></div>';
echo $OUTPUT->heading($titleccmanagement, 2, 'headingblock header');

// redirect if poassword not change
if ($USER->id != '2') {
    $rselect = mysql_query("SELECT * FROM {$CFG->prefix}user_preferences WHERE userid='" . $USER->id . "' AND name='auth_forcepasswordchange' AND value='1'");
    $srows = mysql_num_rows($rselect);
    if ($srows != '0') {
        ?>
        <script language="javascript">
            window.location.href = '<?= $CFG->wwwroot . '/login/change_password.php'; ?>';
        </script>
        <?php
    }


// redirect if profile not updated
    $srole = mysql_query("SELECT name FROM mdl_cifarole WHERE id='5'");
    $rwrole = mysql_fetch_array($srole);
    $usertype = $rwrole['name'];

    $srolew = mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='" . $USER->id . "' AND usertype='" . $rwrole['name'] . "'");
    $srolenum = mysql_num_rows($srolew);
    if ($srolenum != '0') {
        $rsc = mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='" . $USER->id . "' AND (email='' OR postcode='' OR college_edu='' OR highesteducation='0' OR yearcomplete_edu='0')");
    } else {
        $rsc = mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='" . $USER->id . "' AND (email='' OR designation='' OR department='')");
    }
    $srows2 = mysql_num_rows($rsc);
    if ($srows2 != '0') {
        ?>
        <script language="javascript">
            window.location.href = '<?= $CFG->wwwroot . '/user/edit.php?id=' . $USER->id . '&course=1'; ?>';
        </script>
        <?php
    }
}
?>
<style type="text/css">
<?php
include('../institutionalclient/style.css');
?>
    a:hover {text-decoration:underline;}
    #searchtable td{	 
        border-collapse:collapse; 
        border: 1px solid #666666;
    }
	
    #searchtable th{
        border: 1px solid #231f20;
        color:#ffffff;	
    }

    td { padding:3px;}
</style>
<script type="text/javascript" language="javascript">
<!-- Begin
    checked = false;
    function checkedAll() {
        if (checked == false) {
            checked = true
        }
        for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
            document.getElementById('form1').elements[i].checked = checked;
            //document.getElementById('download_button').disabled=false;
        }
    }
//  End -->
    function clearSelected() {
        if (checked == true) {
            checked = false
        }
        for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
            document.getElementById('form1').elements[i].checked = checked;
            //document.getElementById('download_button').disabled=true;
        }
    }
</script>
<?php
$programlist = mysql_query("SELECT * FROM {$CFG->prefix}course WHERE category='1'");
?>
<form name="form" id="form" action="" method="post">
    <br/><fieldset style="padding: 1em;" id="user" class="clearfix">
        <!--legend style="font-weight:bolder;" class="ftoggler">&nbsp;</legend-->
        <table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="18%" scope="row"><?= get_string('chooseipdshape'); ?></td>
                <td width="1%"><strong>:</strong></td>
                <td width="5%" colspan="2">
                    <select name="chooseprogram" id="chooseprogram" style="width:200px;">
                        <option value="">None</option>
                        <option value="" selected="selected"><?= get_string('allipdcourses'); ?></option>
                        <?php while ($plist = mysql_fetch_array($programlist)) { ?>
                            <option value="<?= $plist['id']; ?>"><?= $plist['fullname']; ?></option>
<?php } ?>
                    </select>
                    OR</td></tr> 
            <tr>
                <td width="18%" scope="row">Candidate Detail</td>
                <td width="1%"><strong>:</strong></td>
                <td width="5%">
                    <select name="candidatedetails" id="candidatedetails" style="width:200px;">
                        <option value="traineeid">Candidate ID</option>
                        <option value="firstname">First Name</option>
                        <option value="lastname">Last Name</option>
                        <option value="dob">Date Of Birth</option>
                    </select>
                </td>
                <td>
                    <input type="text" style="width:300px;" name="candidatedetails_s" id="candidatedetails_s" placeholder="DOB format:DD/MM/YYYY" />
                    <input type="submit" name="button" id="button" value="Search" />
                </td>
            </tr> 
        </table>
    </fieldset></form>
<br/>

<fieldset style="padding: 1em;" id="user" class="clearfix">
    <legend style="font-weight:bolder;" class="ftoggler"><?= get_string('cifacandidatedatabase'); ?></legend>
<?= get_string('multiplepwordresetnotice'); ?><br/>
    <div style="color:red; padding-top:0.5em;">
        <?//=get_string('resetsuccessful');?>
        <?php
        if (isset($_POST['multiplereset'])) {
            if ($_POST['checktoken'] != "") {
                $checkBox = $_POST['checktoken'];
                for ($i = 0; $i < sizeof($checkBox); $i++) {

                    $pword_text = get_string('temporarypassword');
                    $password = md5($pword_text);
                    $ucuser = mysql_query("UPDATE mdl_cifauser SET password='" . $password . "' WHERE id='" . $checkBox[$i] . "'") or die("Not update" . mysql_error());
                    $rop = $DB->get_recordset_sql("SELECT * FROM {user} WHERE id='" . $checkBox[$i] . "'");
                    foreach ($rop as $newuserpassword) {
                        resetcandidatepassword($newuserpassword);
                    }
                    $rop->close();
                }
                echo $notice = get_string('resetsuccessful');
            }
        }
        ?>
    </div>
    <?php
    $chooseprogramid = $_POST['chooseprogram'];
    $candidatedetails = $_POST['candidatedetails'];
    $candidatedetails_s = $_POST['candidatedetails_s'];
    ?>
    <form name="form1" id="form1" action="" method="post">
        <table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="right"><input type="button" name="unselectall" id="unselectall" value="Unselect All" onclick="clearSelected();" />
                    <input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll()"/>
                    <input type="submit" name="multiplereset" id="multiplereset" value="Reset Password" onClick="this.form.action = '<?//=$CFG->wwwroot. ' / candidatemanagement / masterresetuser.php';?>'" />
                </td>
            </tr>    
        </table>

        <?php
        $statement = "
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id
	";

        $statement.=" WHERE b.status='0' AND b.enrol='manual' And (d.usertype='" . $usertype . "' Or d.usertype='Inactive candidate')
          AND d.id != '2' And d.deleted != '1' And d.confirmed = '1' And d.id != '1'";
        $statement .=" And d.orgtype='" . $USER->orgtype . "'";

        if ($candidatedetails_s != '') {
            if ($candidatedetails == 'dob') {
                $statement.=" AND ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL d.dob SECOND), '%d/%m/%Y') LIKE '%{$candidatedetails_s}%'))";
            } else {
                $statement.=" AND {$candidatedetails} LIKE '%{$candidatedetails_s}%'";
            }
        }
        if ($chooseprogramid != '') {
            $statement.=" AND b.courseid='" . $chooseprogramid . "'";
        }
        $csql = "SELECT b.courseid, d.traineeid, d.email, d.firstname, d.lastname, DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL d.dob SECOND), '%d/%m/%Y') As dateofbirth, a.fullname, d.usertype, d.id as userid FROM {$statement}";
        $csql.=" GROUP BY d.traineeid ORDER BY d.traineeid";
        $sqlquery = mysql_query($csql);
        ?>	

        <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
            <tr style="background-color:#6D6E71;">
                <th width="11%" scope="row">Candidate ID</th>
                <th width="15%">First Name</th>
                <th width="15%">Last Name</th>
                <th width="8%">DOB</th>
                <th><?= get_string('shapeipdcoursestitle'); ?></th>
                <th width="8%"> Status</th>
                <th width="1%">&nbsp;</th>
                <th width="1%">&nbsp;</th>
            </tr>
            <?php
            $mycount = mysql_num_rows($sqlquery);
            $no = '1';
            if ($mycount != '0') {
                while ($sqlrow = mysql_fetch_array($sqlquery)) {
                    $linkto = $CFG->wwwroot . "/offlineexam/candidate_examsummary.php?id=" . $sqlrow['userid'] . "&examid=" . $sqlrow['courseid'];
                    $linktitle = "Clickable and takes to " . get_string('candidateexamsummary');
                    $bil = $no++;
                    ?>
                    <tr>
                        <td scope="row" align="center"><a href="<?= $linkto; ?>" title="<?= $linktitle; ?>" target="_blank"><?= strtoupper($sqlrow['traineeid']); ?></a></td>
                        <td><?= ucwords(strtolower($sqlrow['firstname'])); ?></td>
                        <td><?= ucwords(strtolower($sqlrow['lastname'])); ?></td>
                        <td style="text-align:center"><?= $sqlrow['dateofbirth']; ?></td>
                        <td>
                            <?php
                            //list out cifa program title
                            $enrolsql = mysql_query("
					Select
					  *
					From
					  mdl_cifacourse a Inner Join
					  mdl_cifaenrol b On a.id = b.courseid Inner Join
					  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
					  mdl_cifauser d On c.userid = d.id
					Where
					  c.userid = '" . $sqlrow['userid'] . "' And
					  b.enrol = 'manual' And
					  a.category = '1' And
					  a.visible = '1' And
					  b.status = '0'				
				");
                            while ($euser = mysql_fetch_array($enrolsql)) {
                                echo '- ' . $euser['fullname'] . '<br/>';
                            }
                            ?>
                        </td>
                        <td style="text-align:center;">
                            <?php
                            global $DB;
                            /*$sql = "							
                                    Select
                                      c.timestart,c.timeend,DATE_ADD(FROM_UNIXTIME(d.timecreated,'%Y-%m-%d'), INTERVAL 120 DAY) as lasttimecreated
                                    From
                                      mdl_cifacourse a Inner Join
                                      mdl_cifaenrol b On a.id = b.courseid Inner Join
                                      mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
                                      mdl_cifauser d On c.userid = d.id
                                    Where
                                      c.userid = '" . $sqlrow['userid'] . "' And
                                      b.enrol = 'manual' And
                                      a.category = '1' And
                                      a.visible = '1' And
                                      b.status = '0' And
                                      a.id = '" . $sqlrow['courseid'] . "'";*/
                            
                            $sql = "							
                                Select
                                  c.timestart, c.timeend, DATE_ADD(FROM_UNIXTIME(d.timecreated,'%Y-%m-%d'), INTERVAL 120 DAY) as lasttimecreated
                                From
                                  mdl_cifacourse a Inner Join
                                  mdl_cifaenrol b On a.id = b.courseid Inner Join
                                  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
                                  mdl_cifauser d On c.userid = d.id
                                Where
                                  c.userid = '" . $sqlrow['userid'] . "' And
                                  b.enrol = 'manual' And
                                  a.category = '1' And
                                  a.visible = '1' And
                                  b.status = '0' Group By c.userid";                            
                            
                            
                            $rs = $DB->get_record_sql($sql);

                            if ($rs->timeend >= strtotime($rs->lasttimecreated)) {
                                if (strtotime('now') > $rs->timeend) {
                                    echo 'Inactive';
                                } else {
                                    echo 'Active';
                                }
                            } else {
                                if (strtotime('now') > strtotime($rs->lasttimecreated)) {
                                    echo 'Inactive';
                                } else {
                                    echo 'Active';
                                }
                            }

                            /* if ($sqlrow['usertype'] == 'Inactive candidate') {
                              echo 'Inactive';
                              } else {
                              echo 'Active';
                              } */
                            ?></td>
                        <td align="center"><input type="submit" name="updatedetail" id="updatedetail" value="Update Detail" onMouseOver="style.cursor = 'hand'" onClick="this.form.action = '<?= $CFG->wwwroot . '/user/edit.php?id=' . $sqlrow['userid'] . '&course=1'; ?>'" /></td>
                        <td style="text-align:center;"><input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?= $sqlrow['userid']; ?>" /></td>		
                    </tr>

                    <?php
                }
            } else {
                ?>
                <tr><td colspan="8" scope="row"><?= get_string('searchresultnotfound'); ?></td></tr>
<?php } ?>
        </table></form>	
    <form name="form" id="form" action="" method="post">
        <table width="95%" border="0" style="margin:0px auto; padding:0px; border: 0px solid #666666; border-collapse:collapse;">
            <tr>
                <td align="right">
                    <?php
                    $candidatedetails = $_POST['candidatedetails'];
                    if ($candidatedetails != 'dob') {

                        $candidatedetails_s = $_POST['candidatedetails_s'];
                    } else {
                        $candidatedetails_s = strtotime($_POST['candidatedetails_s']);
                    }
                    $printto = $CFG->wwwroot . '/candidatemanagement/cifacandidatemanagement_print.php?programid=' . $chooseprogramid . '&candidatedetails=' . $candidatedetails . '&candidatedetails_s=' . $candidatedetails_s;
                    ?>
                    <input type="submit" name="buttonprint" id="id_defaultbutton" value="Print" onClick="this.form.action = '<?= $printto; ?>', target = '_blank'" />
                    <input type="submit" name="buttonback" id="id_defaultbutton" onClick="this.form.action = '<?= $CFG->wwwroot . '/index.php'; ?>', target = '_parent'" value="<?= get_string('back'); ?>" />
                </td>
            </tr>    
        </table></form>	
    <br/>	  

</fieldset>

<?php
echo $OUTPUT->footer();
?>