<?php
require_once('../../config.php');
require_once($CFG->libdir . '/tablelib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/datalib.php');
require_once($CFG->dirroot . '/lib.php');
require_once("$CFG->libdir/excellib.class.php");
require_once('../lib.php');
require_once('../lib_organization.php');
require_once('../userrole_lib.php');
require_once('../../examcenter/lib.php');

$site = get_site();
$streditexamrules = get_string("userrole");
$userroleprocess = get_string("userroleedit");
$title = "$site->shortname: $streditexamrules - " . get_string('finalstep');
$fullname = $site->fullname;

$PAGE->set_url('/');
$PAGE->set_title($title);
$PAGE->set_course($site);
$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('buy_a_cifa');
$PAGE->set_heading($fullname);

//// OPTION PARAM
$roleid = optional_param('id', '', PARAM_MULTILANG);
$formtype = optional_param('formtype', '', PARAM_MULTILANG);
$urole = optional_param('urole', '', PARAM_MULTILANG);
$radio = optional_param('name_radio1', '', PARAM_MULTILANG);

$tab = optional_param('tab', '', PARAM_MULTILANG);
$imagebutton = optional_param('imagebutton', '', PARAM_MULTILANG);
$communicationid = optional_param('communicationid', '', PARAM_INT);
$scheduleid = optional_param('scheduleid', '', PARAM_INT); // edit
$shedule_actionbutton = optional_param('shedule_actionbutton', '', PARAM_MULTILANG);
$recipientdetails = optional_param('recipientdetails', '', PARAM_MULTILANG);
$searchboxindividual = optional_param('searchboxindividual', '', PARAM_MULTILANG);
$searchboxorg = optional_param('searchboxorg', '', PARAM_MULTILANG);
$selectedusers = optional_param('checktoken', '', PARAM_INT);

// Navigation $shedule_actionbutton
$PAGE->navbar->add(ucwords(strtolower(get_string('userrole'))), '');
$PAGE->navbar->add(ucwords(strtolower(get_string('assigneduser'))), '')->add(ucwords(strtolower($shedule_actionbutton)), '');

// load JS
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/jquery-1.9.1.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/jquery-ui.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/script.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/communication.js'));

$url = array();
$url[] = $CFG->wwwroot . '/organization/userrole/userrole_finalstep.php?id=' . $roleid . '&name_radio1=' . $radio . '&tab=' . $tab;
// $url[] = $CFG->wwwroot . '/examcenter/reportview.php?id=' . $reportid . '&sid=' . $sid . '&download=1';

if (empty($selectedusers)) {
    ?>
    <script language="javascript">
        window.alert("Please tick at lease one to proceed.");
        window.location.href = '<?= $url[0]; ?>';
    </script>
    <?php
}

if (!empty($selectedusers)) {
    $headers = array();
    $headers[] = get_string('candidateid') . ';';
    $headers[] = get_string('firstname') . ';';
    $headers[] = get_string('lastname') . ';';
    $headers[] = get_string('dob') . ';';
    $headers[] = get_string('designation') . ';';
    $headers[] = get_string('organization') . ';';

    $filename = "userrole_csv";
    $csv_filename = clean_filename($filename . '-' . date('Ymd') . '-' . time('now') . '.csv');
    header("Content-Type: application/vnd.ms-excel");

    // Content start here!!!
    for ($i = 0; $i < sizeof($selectedusers); $i++) {
        if ($i < '1') {
            $fileContent = "Report Title: " . selectrolename($roleid) . "\n";
            $fileContent.= "Date Time: " . date('d/m/Y h:i:s', time()) . "\n\n\n\n";

            $fileContent .= $headers[0] . $headers[1] . $headers[2] . $headers[3] . $headers[4] . $headers[5] . "\n";
        } else {
            $fileContent = "";
        }
        $users = get_user_details($selectedusers[$i]);
        // dob 
        if ($users->dob != '') {
            $udob = date('d/m/Y', $users->dob);
        } else {
            $udob = ' - ';
        }
        // Sub organization name
        $organization = listoutall_groupusers($users->userid);
        if ($organization->subgroupname != '') {
            $subgroupname = $organization->subgroupname;
        } else {
            $subgroupname = ' - ';
        }
        // designation
        if ($users->designation != '') {
            $designation = ucwords(strtolower($users->designation));
        } else {
            $designation = ' - ';
        }

// Content list here!!!!
        $colnum1 = 0;
        $row = array();

        if ($users->traineeid) {
            $row[] = strtoupper($users->traineeid) . ';';
        }
        if ($users->firstname) {
            $row[] = $users->firstname . ';';
        }
        if ($users->lastname) {
            $row[] = $users->lastname . ';';
        }
        if ($users->dob) {
            $row[] = $udob . ';';
        }
        $row[] = $designation . ';';
        $row[] = $subgroupname . ';';

        // display content
        // data here!						
        if ($i < '0') {
            $fileContent.= "" . $row[0] . $row[1] . $row[2] . $row[3] . $row[4] . $row[5] . "";
        } else {
            $fileContent.= "\n" . $row[0] . $row[1] . $row[2] . $row[3] . $row[4] . $row[5] . "";
        }

        $fileContent = str_replace("\n\n", "\n", $fileContent);
        echo $fileContent;
    }
    header("content-disposition: attachment;filename=$csv_filename");
}   