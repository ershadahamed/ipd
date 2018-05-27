<?php
require_once('../config.php');
require_once('../manualdbconfig.php');
require_once($CFG->dirroot . '/lib/blocklib.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/filelib.php');


include_once ('../pagingfunction.php');

$PAGE->set_url('/');
$PAGE->set_course($SITE);

$listusertoken = get_string('myadmin');
$reportoption = "Reporting Options";
$PAGE->navbar->add(ucwords(strtolower($listusertoken)))->add(ucwords(strtolower($reportoption)));

$PAGE->set_pagetype('site-index');
$editing = $PAGE->user_is_editing();
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('buy_a_cifa');

echo $OUTPUT->header();
?><head>
    <!-- Load jQuery from Google's CDN -->
    <!-- Load jQuery UI CSS  -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="./jquery.datetimepicker.css"/>

    <!-- Load jQuery JS -->
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <!-- Load jQuery UI Main JS  -->
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

    <!-- Load SCRIPT.JS which will create datepicker for input field  -->
    <script src="script.js"></script>

    <link rel="stylesheet" href="runnable.css" />
</head>

<style type="text/css">
<?php
include('../institutionalclient/style.css');
$reportid = $_GET['rid'];
$sreport = $_GET['sreport'];
?>
    a:hover {text-decoration:underline;}
    #searchtable td, th{	 
        border: 1px solid #666666;
        border-collapse:collapse; 
    }	
</style>
<script type="text/javascript" language="javascript">
<!-- Begin
    checked = false;
    function checkedAll() {
        if (checked == false) {
            checked = true;
        }
        for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
            document.getElementById('form1').elements[i].checked = checked;
        }
    }
//  End -->
    function clearSelected() {
        if (checked == true) {
            checked = false
        }
        for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
            document.getElementById('form1').elements[i].checked = checked;
        }
    }
</script>

<script type="text/javascript" language="javascript">
    function checkfield() {
        var checked = false;
        // var elements = document.getElementsByName("checktoken[]");

        //Candidate Profile
        var organizationname = document.getElementById("organizationname");
        var candidateid = document.getElementById("candidateID");
        var candidateFullname = document.getElementById("candidateFullname");
        var candidateEmail = document.getElementById("candidateEmail");
        var candidateAddress = document.getElementById("candidateAddress");
        var candidateTel = document.getElementById("candidateTel");

        //Candidate Performance
        var curriculumname_candidate = document.getElementById("curriculumname_candidate");
        var curriculumcode = document.getElementById("curriculumcode");
        var statuscandidate = document.getElementById("statuscandidate");
        var modulecompleted = document.getElementById("modulecompleted");
        var totaltime = document.getElementById("totaltime");
        var examinationstatus = document.getElementById("examinationstatus");
        var markcandidate = document.getElementById("markcandidate");
        var subscriptiondate = document.getElementById("subscriptiondate");
        var expirydate = document.getElementById("expirydate");
        var lastaccess = document.getElementById("lastaccess");

        // IPD Course Performance
        var curriculumname_examination = document.getElementById("curriculumname_examination");
        var curriculumcode_examination = document.getElementById("curriculumcode_examination");
        var curriculumattemps = document.getElementById("curriculumattemps");
        var learningoutcome = document.getElementById("learningoutcome");
        var scoreonlearning = document.getElementById("scoreonlearning");
        var passes = document.getElementById("passes");
        var passrate = document.getElementById("passrate");

        // IPD Course Statistic
        var curriculumnamestatistics = document.getElementById("curriculumnamestatistics");
        var curriculumcode_statistics = document.getElementById("curriculumcode_statistics");
        var statusstistics = document.getElementById("statusstistics");
        var modulecompletedstistics = document.getElementById("modulecompletedstistics");
        var examstatus_statistics = document.getElementById("examstatus_statistics");
        var totaltime_statistics = document.getElementById("totaltime_statistics");

        //timeline fields
        var startdatepicker = document.getElementById("startdatepicker");
        var enddatepicker = document.getElementById("enddatepicker");

        if ((organizationname.checked == "") && (candidateid.checked == "") && (candidateFullname.checked == "") && (candidateEmail.checked == "") && (candidateAddress.checked == "") && (candidateTel.checked == "")) {
            alert('Please select at least one reporting option on Candidate Profile to proceed.');
            return checked;
        }

        //Candidate Performance
<?php if ($sreport == '0') { ?>
            if ((curriculumname_candidate.checked == "") && (curriculumcode.checked == "") && (statuscandidate.checked == "") && (modulecompleted.checked == "") && (totaltime.checked == "") && (examinationstatus.checked == "") && (markcandidate.checked == "") && (subscriptiondate.checked == "") && (expirydate.checked == "") && (lastaccess.checked == "")) {
                alert('Please select at least one reporting option on Candidate Performance to proceed.');
                return checked;
            }

            // IPD Course Performance
<?php } else if ($sreport == '1') { ?>
            if ((curriculumname_examination.checked == "") && (curriculumcode_examination.checked == "") && (curriculumattemps.checked == "") && (learningoutcome.checked == "") && (scoreonlearning.checked == "") && (passes.checked == "") && (passrate.checked == "")) {
                alert('Please select at least one reporting option on IPD Course Performance to proceed.');
                return checked;
            }

            // IPD Course Statistic
<?php } else { ?>
            if ((curriculumnamestatistics.checked == "") && (curriculumcode_statistics.checked == "") && (statusstistics.checked == "") && (modulecompletedstistics.checked == "") && (examstatus_statistics.checked == "") && (totaltime_statistics.checked == "")) {
                alert('Please select at least one reporting option on Course Statistic to proceed.');
                return checked;
            }
<?php } ?>

        if (startdatepicker.value == "") {
            alert("Start Date is required to fillup.");
            startdatepicker.focus();
            return false;
        }

        if (enddatepicker.value == "") {
            alert("End Date is required to fillup.");
            enddatepicker.focus();
            return false;
        }

        document.form.submit();
        return true;
    }
</script>

<?php
$sqlview = mysql_query("
		Select
		  c.candidateid,
		  a.reportname,
		  b.*
		From
		  mdl_cifareport_menu a Inner Join
		  mdl_cifareport_option b On a.id = b.reportid Inner Join
		  mdl_cifareport_users c On b.reportid = c.reportid
		Where
		  c.reportid = '" . $_GET['rid'] . "'	
	");
$sview = mysql_fetch_array($sqlview);
$cid0 = $sview['organizationname'];
$cid01 = $sview['employeeid'];
$cid = $sview['candidateID'];
$cid1 = $sview['candidateFullname'];
$cid2 = $sview['candidateEmail'];
$cid3 = $sview['candidateAddress'];
$cid4 = $sview['candidateTel'];
$cid5 = $sview['designation'];
$cid6 = $sview['department'];
$cid7 = $sview['enrolstatus'];

$cp = $sview['curriculumname'];
$cp1 = $sview['curriculumcode'];
$cp2 = $sview['performancestatus'];
$cp3 = $sview['modulecompleted'];
$cp4 = $sview['totaltimeperformance'];
$cp5 = $sview['examinationstatus'];
$cp6 = $sview['markperformance'];
$cp7 = $sview['learningoutcomes'];
$cp8 = $sview['scoreonlo'];
$cp9 = $sview['subscriptiondate'];
$cp10 = $sview['expirydate'];
$cp11 = $sview['lastaccess'];

$ep = $sview['cnameexam'];
$ep1 = $sview['ccodeexam'];
$ep2 = $sview['cattempts'];
$ep3 = $sview['learningoutcomes'];
$ep4 = $sview['scoreonlo'];
$ep5 = $sview['passes'];
$ep6 = $sview['passrate'];

$es = $sview['cname_statistics'];
$es1 = $sview['ccode_statistics'];
$es2 = $sview['statusstistics'];
$es3 = $sview['mcomplete_statistics'];
$es4 = $sview['examstatus_statistics'];
$es5 = $sview['totaltime_statistics'];

$es4 = $sview['examstatus_statistics'];
$es5 = $sview['totaltime_statistics'];

$tlinestartdate = $sview['tlstartdate'];
$tlineenddate = $sview['tlenddate'];
?>

<form name="form" id="form" action="<?= $CFG->wwwroot . '/examcenter/reportoptionaction_edit.php?id=' . $USER->id; ?>" method="post">
    <table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= get_string('reportoptionnotice'); ?></td>
        </tr><tr>
            <td align="right">
                <input type="submit" name="backbutton" id="id_defaultbutton" onClick="this.form.action = '<?= $CFG->wwwroot . '/examcenter/editreport.php?id=' . $_GET['rid'] . '&sid=' . $_GET['sreport']; ?>'" value="<?= get_string('back'); ?>" />
                <input type="button" name="savebackhome" id="id_defaultbutton" onclick="checkfield()" value="Save &amp; Back to Home" />
                <input type="button" name="unsaveshow" id="id_defaultbutton" onclick="checkfield()" value="Show &amp; Don`t Save" />
                <input type="button" name="saveshow" id="id_defaultbutton" onclick="checkfield()" value="Save &amp; Show" />
            </td>
        </tr>    
    </table>


    <?php
    // $reportid=$_GET['rid'];
    // $sreport = $_GET['sreport'];
    //role selected
    $role = mysql_query("SELECT name FROM {$CFG->prefix}role WHERE id='5'");
    $nrole = mysql_fetch_array($role);

    $roleid = mysql_query("SELECT * FROM {$CFG->prefix}role WHERE id='12' OR id= '13'");
    $nroleid = mysql_fetch_array($roleid);

    $statement = "
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken On b.courseid = mdl_cifauser_accesstoken.courseid And
		mdl_cifauser_accesstoken.userid = d.id	
	";

    $statement.=" WHERE a.category = '3' AND d.usertype='" . $nrole['name'] . "'";
    $csql = "SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";
    $sqlquery = mysql_query($csql);
    ?>	
    <!------- Candidate Performance -------->
    <input type="hidden" name="reportid" id="reportid" value="<?= $reportid; ?>" />
    <input type="hidden" name="sreport" id="sreport" value="<?= $sreport; ?>" />

    <?php if (($nroleid['id'] == '12') || ($nroleid['id'] == '13')) { ?>
        <fieldset style="padding: 1em;" id="user" class="clearfix">
            <legend style="font-weight:bolder;" class="ftoggler">Candidate Profile</legend><br/>
            <input name="organizationname" type="checkbox" value="1" id="organizationname" <?php if ($cid0 != '0') {
            echo 'checked';
        } ?> /><?= get_string('organization'); ?><br/>
            <input name="employeeid" type="checkbox" value="1" id="employeeid" <?php if ($cid01 != '0') {
            echo 'checked';
        } ?> /><?= get_string('employeeid'); ?><br/>
            <input name="candidateID" type="checkbox" value="1" id="candidateID" <?php if ($cid != '0') {
            echo 'checked';
        } ?> />Candidate ID <br/>
            <input name="candidateFullname" type="checkbox" value="1" id="candidateFullname" <?php if ($cid1 != '0') {
            echo 'checked';
        } ?> />Candidate Full Name<br/>
            <input name="candidateEmail" type="checkbox" value="1" id="candidateEmail" <?php if ($cid2 != '0') {
        echo 'checked';
    } ?> />Candidate Email <br/>
            <input name="candidateAddress" type="checkbox" value="1" id="candidateAddress" <?php if ($cid3 != '0') {
        echo 'checked';
    } ?> />Candidate Address<br/>
            <input name="candidateTel" type="checkbox" value="1" id="candidateTel" <?php if ($cid4 != '0') {
        echo 'checked';
    } ?> />Candidate Telephone <br/>
            <input name="designation" type="checkbox" value="1" id="designation" <?php if ($cid5 != '0') {
        echo 'checked';
    } ?> /><?= get_string('designation'); ?> <br/>
            <input name="department" type="checkbox" value="1" id="department" <?php if ($cid6 != '0') {
        echo 'checked';
    } ?> /><?= get_string('department'); ?> <br/>
            <input name="enrolstatus" type="checkbox" value="1" id="department" <?php if ($cid7 != '0') {
        echo 'checked';
    } ?> /><?= get_string('enrolstatus'); ?> <br/>
        </fieldset>
<?php } ?>

    <?php if ($sreport == '0') { ?>
        <fieldset style="padding: 1em;" id="user" class="clearfix">
            <legend style="font-weight:bolder;" class="ftoggler">Candidate Performance</legend><br/>


            <input name="curriculumname_candidate" id="curriculumname_candidate" type="checkbox" value="1" <?php if ($cp != '0') {
            echo 'checked';
        } ?>/><?= get_string('coursetitle'); ?><br/>
            <input name="curriculumcode" type="checkbox" value="1" id="curriculumcode" <?php if ($cp1 != '0') {
            echo 'checked';
        } ?>/><?= get_string('curriculumcode'); ?><br/>
            <input name="statuscandidate" type="checkbox" value="1" id="statuscandidate" <?php if ($cp2 != '0') {
            echo 'checked';
        } ?>/>Status (Subscribed / In Progress / Ended) <br/>
            <input name="modulecompleted" type="checkbox" value="1" id="modulecompleted" <?php if ($cp3 != '0') {
        echo 'checked';
    } ?>/>Module Completed (%)<br/>
            <input name="totaltime" type="checkbox" value="1" id="totaltime" <?php if ($cp4 != '0') {
        echo 'checked';
    } ?>/>Total Time (total time used to access online course)(HH:MM:SS) <br/>
            <input name="examinationstatus" type="checkbox" value="1" id="examinationstatus" <?php if ($cp5 != '0') {
        echo 'checked';
    } ?>/>Test Status (Pass, Fail, Absent, Expired)<br/>
            <input name="markcandidate" type="checkbox" value="1" id="markcandidate" <?php if ($cp6 != '0') {
        echo 'checked';
    } ?>/>Mark (%) <br/>
            <input name="subscriptiondate" type="checkbox" value="1" id="subscriptiondate" <?php if ($cp9 != '0') {
        echo 'checked';
    } ?>/> Course subscription date <br/>
            <input name="expirydate" type="checkbox" value="1" id="expirydate" <?php if ($cp10 != '0') {
        echo 'checked';
    } ?>/> Course access expiry date <br/>
            <input name="lastaccess" type="checkbox" value="1" id="lastaccess" <?php if ($cp11 != '0') {
        echo 'checked';
    } ?>/> Last access date <br/>
            <!--input name="learningoutcome" type="checkbox" value="1" id="learningoutcome" <?php //if($cp7!='0'){echo 'checked';}  ?>/>Learning Outcome <br/>
            <input name="scoreonlearning" type="checkbox" value="1" id="scoreonlearning" <?php //if($cp8!='0'){echo 'checked';}  ?>/>Score on Learning Outcome <br/-->
        </fieldset>
<?php } else if ($sreport == '1') { ?>
        <!-------Examination Performance-------->
        <fieldset style="padding: 1em;" id="user" class="clearfix">
            <legend style="font-weight:bolder;" class="ftoggler">IPD Course Performance</legend><br/>	   
            <input name="curriculumname_examination" type="checkbox" value="1" id="curriculumname_examination" <?php if ($ep != '0') {
        echo 'checked';
    } ?>/><?= get_string('coursetitle'); ?><br/>
            <input name="curriculumcode_examination" type="checkbox" value="1" id="curriculumcode_examination" <?php if ($ep1 != '0') {
        echo 'checked';
    } ?>/><?= get_string('curriculumcode'); ?><br/>
            <input name="curriculumattemps" type="checkbox" value="1" id="curriculumattemps" <?php if ($ep2 != '0') {
        echo 'checked';
    } ?> />Test Attempts <br/>
            <input name="learningoutcome" type="checkbox" value="1" id="learningoutcome" <?php if ($ep3 != '0') {
        echo 'checked';
    } ?> />Learning Outcome <br/>
            <input name="scoreonlearning" type="checkbox" value="1" id="scoreonlearning" <?php if ($ep4 != '0') {
        echo 'checked';
    } ?> />Score on Learning Outcome <br/>
            <input name="passes" type="checkbox" value="1" id="passes" <?php if ($ep5 != '0') {
        echo 'checked';
    } ?>/>Passes <br/>
            <input name="passrate" type="checkbox" value="1" id="passrate" <?php if ($ep6 != '0') {
        echo 'checked';
    } ?>/>Pass rate
        </fieldset><br/>
<?php } else { ?>
        <!------Statistics (%)--------->
        <fieldset style="padding: 1em;" id="user" class="clearfix">
            <legend style="font-weight:bolder;" class="ftoggler">Course Statistics (%)</legend><br/>	     
            <input name="curriculumname_statistics" type="checkbox" value="1" id="curriculumnamestatistics" <?php if ($es != '0') {
        echo 'checked';
    } ?> /><?= get_string('coursetitle'); ?><br/>
            <input name="curriculumcode_statistics" type="checkbox" value="1" id="curriculumcode_statistics" <?php if ($es1 != '0') {
        echo 'checked';
    } ?> /><?= get_string('curriculumcode'); ?><br/>
            <input name="statusstistics" type="checkbox" value="1" id="statusstistics" <?php if ($es2 != '0') {
        echo 'checked';
    } ?> />Status (Subscribed / In Progress / Ended)<br/>
            <input name="mcomplete_statistics" type="checkbox" value="1" id="modulecompleted" <?php if ($es3 != '0') {
        echo 'checked';
    } ?> />Module Completed <br/>
            <input name="examstatus_statistics" type="checkbox" value="1" id="examinationstatus" <?php if ($es4 != '0') {
        echo 'checked';
    } ?> />Test Status (Pass, Fail, Absent, Expired)<br/>
            <input name="totaltime_statistics" type="checkbox" value="1" id="totaltime" <?php if ($es5 != '0') {
        echo 'checked';
    } ?> />Total Time (total time used to access online course)(HH:MM:SS)
        </fieldset><br/>
<?php } ?>

    <!-------Report timeline-------->
    <fieldset style="padding: 1em;" id="user" class="clearfix">
        <legend style="font-weight:bolder;" class="ftoggler">Report Timeline</legend>

        <table width="100%" style="border:none;" border="0" cellpadding="0" cellspacing="0">
            <td style="font-weight:bolder;" width="12%">Start Date</td>
            <td><input type="text" name="startdatepicker" id="startdatepicker" value="<?= $tlinestartdate; ?>" /></td>
            </tr>
            <tr>
                <td style="font-weight:bolder;">End Date</td>
                <td><input type="text" name="enddatepicker" id="enddatepicker" value="<?= $tlineenddate; ?>" /></td>
            </tr> 
        </table>
    </fieldset> </form>

<script src="./jquery.datetimepicker.js"></script>
<script>
                            $('#datetimepicker1').datetimepicker({
                                datepicker: false,
                                format: 'H:i',
                                step: 5
                            });
                            $('#enddatetimepicker').datetimepicker({
                                datepicker: false,
                                format: 'H:i',
                                step: 5
                            });
</script> 
<?php
echo $OUTPUT->footer();
?>