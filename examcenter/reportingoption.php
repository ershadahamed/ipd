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
<script src="../js/gen_validatorv4.js" type="text/javascript"></script>
<style type="text/css">
<?php
include('../institutionalclient/style.css');
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
        var designation = document.getElementById("designation");
        var department = document.getElementById("department");
        var employeeid = document.getElementById("employeeid");

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
        
        var savebackhome = document.getElementById("id_defaultbuttonsavebackhome");

        if ((organizationname.checked == "") && (employeeid.checked == "") && (candidateid.checked == "") && (candidateFullname.checked == "") && (candidateEmail.checked == "") && (candidateAddress.checked == "") && (candidateTel.checked == "") && (designation.checked == "") && (department.checked == "") && (enrolstatus.checked == "")) {
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

        document.form1.submit();
        return true;
    }
</script>

<form name="form1" id="form1" action="<?= $CFG->wwwroot . '/examcenter/reportoptionaction.php?id=' . $USER->id; ?>" method="post">
    <table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= get_string('reportoptionnotice'); ?></td>
        </tr><tr>
            <td align="right">
                <input type="submit" name="backbutton" id="id_defaultbutton" onClick="this.form.action = '<?= $CFG->wwwroot . '/examcenter/reportmenu.php?id=' . $USER->id; ?>'" value="<?= get_string('back'); ?>" />
                <input type="button" name="savebackhome" id="id_defaultbuttonsavebackhome" onclick="checkfield()" value="Save &amp; Back to Home" />
                <input type="button" name="unsaveshow" id="id_defaultbutton" onclick="checkfield()" value="Show &amp; Don`t Save" />
                <input type="button" name="saveshow" id="id_defaultbutton" onclick="checkfield()" value="Save &amp; Show" />
            </td>
        </tr>    
    </table>


    <?php
    $reportid = $_GET['id'];

    // selected role
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
            <input name="organizationname" type="checkbox" value="1" id="organizationname" /> <?= get_string('organization'); ?>  <br/>
            <input name="employeeid" type="checkbox" value="1" id="employeeid" /> <?= get_string('employeeid'); ?>  <br/>
            <input name="candidateID" type="checkbox" value="1" id="candidateID" /> Candidate ID <br/>
            <input name="candidateFullname" type="checkbox" value="1" id="candidateFullname"/> Candidate Full Name<br/>
            <input name="candidateEmail" type="checkbox" value="1" id="candidateEmail"/> Candidate Email <br/>
            <input name="candidateAddress" type="checkbox" value="1" id="candidateAddress"/> Candidate Address<br/>
            <input name="candidateTel" type="checkbox" value="1" id="candidateTel"/> Candidate Telephone <br/>
            <input name="designation" type="checkbox" value="1" id="designation"/> <?= get_string('designation'); ?> <br/>
            <input name="department" type="checkbox" value="1" id="department"/> <?= get_string('department'); ?> <br/>
            <input name="enrolstatus" type="checkbox" value="1" id="department"/> <?= get_string('enrolstatus'); ?> <br/>
        </fieldset>
    <?php } ?>

    <?php if ($sreport == '0') { ?>
        <fieldset style="padding: 1em;" id="user" class="clearfix">
            <legend style="font-weight:bolder;" class="ftoggler">Candidate Performance</legend><br/>


            <input name="curriculumname_candidate" id="curriculumname_candidate" type="checkbox" value="1"/> Course Title<br/>
            <input name="curriculumcode" type="checkbox" value="1" id="curriculumcode"/> Course Code<br/>
            <input name="statuscandidate" type="checkbox" value="1" id="statuscandidate"/> Status (Subscribed / In Progress / Ended) <br/>
            <input name="modulecompleted" type="checkbox" value="1" id="modulecompleted"/> Module Completed (%)<br/>
            <input name="totaltime" type="checkbox" value="1" id="totaltime"/> Total Time (total time used to access online course)(HH:MM:SS) <br/>
            <input name="examinationstatus" type="checkbox" value="1" id="examinationstatus"/> 
            Test Status (Pass, Fail, Absent, Expired)<br/>
            <input name="markcandidate" type="checkbox" value="1" id="markcandidate"/> Mark (%) <br/>
            <input name="subscriptiondate" type="checkbox" value="1" id="subscriptiondate"/> Course subscription date <br/>
            <input name="expirydate" type="checkbox" value="1" id="expirydate"/> Course access expiry date <br/>
            <input name="lastaccess" type="checkbox" value="1" id="lastaccess"/> Last access date <br/>
        </fieldset>
    <?php } else if ($sreport == '1') { ?>
        <!-------Examination Performance-------->
        <fieldset style="padding: 1em;" id="user" class="clearfix">
            <legend style="font-weight:bolder;" class="ftoggler"><?= get_string('ipdcourseperformance'); ?></legend><br/>	   
            <input name="curriculumname_examination" type="checkbox" value="1" id="curriculumname_examination"/> 
            Course Title<br/>
            <input name="curriculumcode_examination" type="checkbox" value="1" id="curriculumcode_examination"/> 
            Course Code <br/>
            <input name="curriculumattemps" type="checkbox" value="1" id="curriculumattemps"/> 
            Test Attempts <br/>
            <input name="learningoutcome" type="checkbox" value="1" id="learningoutcome"/> Learning Outcome <br/>
            <input name="scoreonlearning" type="checkbox" value="1" id="scoreonlearning"/><?= get_string('scorelo'); ?><br/>
            <input name="passes" type="checkbox" value="1" id="passes"/><?= get_string('passes'); ?><br/>
            <input name="passrate" type="checkbox" value="1" id="passrate"/><?= get_string('passrate'); ?>
        </fieldset><br/>
    <?php } else { ?>
        <!------Statistics (%)--------->
        <fieldset style="padding: 1em;" id="user" class="clearfix">
            <legend style="font-weight:bolder;" class="ftoggler">Course Statistics (%)</legend><br/>	     
            <input name="curriculumname_statistics" type="checkbox" value="1" id="curriculumnamestatistics"/> 
            Course Title<br/>
            <input name="curriculumcode_statistics" type="checkbox" value="1" id="curriculumcode_statistics"/> 
            Course Code <br/>
            <input name="statusstistics" type="checkbox" value="1" id="statusstistics"/> Status (Subscribed / In Progress / Ended)<br/>
            <input name="mcomplete_statistics" type="checkbox" value="1" id="modulecompletedstistics"/> Module Completed <br/>
            <input name="examstatus_statistics" type="checkbox" value="1" id="examstatus_statistics"/> 
            Test Status (Pass, Fail, Absent, Expired)<br/>
            <input name="totaltime_statistics" type="checkbox" value="1" id="totaltime_statistics"/> 
            Total Time (total time used to access online course)(HH:MM:SS)
        </fieldset><br/>
    <?php } ?>

    <!-------Report timeline-------->
    <fieldset style="padding: 1em;" id="user" class="clearfix">
        <legend style="font-weight:bolder;" class="ftoggler">Report Timeline</legend>

        <table width="100%" style="border:none;" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td style="font-weight:bolder;" width="12%">Start Date</td>
                <td><input type="text" name="startdatepicker" id="startdatepicker" /></td>
            </tr>
            <tr>
                <td style="font-weight:bolder;">End Date</td>
                <td><input type="text" name="enddatepicker" id="enddatepicker" /></td>
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
<script  type="text/javascript">
    /*  var frmvalidator = new Validator("form1");
     frmvalidator.addValidation("startdatepicker","req","Start Date is required to fillup");
     frmvalidator.addValidation("enddatepicker","req","End Date is required to fillup"); */
</script>	
<?php
echo $OUTPUT->footer();
?>