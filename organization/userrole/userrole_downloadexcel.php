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
$url[] = $CFG->wwwroot . '/examcenter/reportview.php?id=' . $reportid . '&sid=' . $sid;
$url[] = $CFG->wwwroot . '/examcenter/reportview.php?id=' . $reportid . '&sid=' . $sid . '&download=1';

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
    $headers[] = get_string('candidateid');
    $headers[] = get_string('firstname');
    $headers[] = get_string('lastname');
    $headers[] = get_string('dob');
    $headers[] = get_string('designation');
    $headers[] = get_string('organization');

    // $colsprofile = count($profileheaders);    // count profile column

    $filename = "userrole_excel";
    $excel_filename = clean_filename($filename . '-' . date('Ymd') . '-' . time('now') . '.xls');
    // Creating a workbook
    $workbook = new MoodleExcelWorkbook("-");
    // Sending HTTP headers
    $workbook->send($excel_filename);
    // Creating the first worksheet
    $sheettitle = $excel_filename;
    $myxls = & $workbook->add_worksheet($sheettitle);
    // format types
    $format = & $workbook->add_format();
    $format->set_bold(0);
    $format->set_border(1);
    $format->set_align('left');

    $formattitle = & $workbook->add_format();
    $formattitle->set_bold(1);

    $formatbc = & $workbook->add_format();
    $formatbc->set_bold(1);
    $formatbc->set_align('merge');
    $formatbc->set_border(1);
    $formatbc->set_right(1);

    $formatheader = & $workbook->add_format();
    $formatheader->set_bold(1);
    $formatheader->set_align('left');
    $formatheader->set_border(1);

    // Merge cell
    //$myxls->merge_cells(0, 0, 0, 1);
    //$myxls->merge_cells(1, 0, 1, 1);
    //$myxls->merge_cells(3, 0, 3, $colsprofile - 1);
    //$myxls->merge_cells(3, $colsprofile, 3, count($headers) - 1);

    $border = & $workbook->add_format();
    $border->set_right(1);
    $border->set_bottom(1);
    $border->set_top(1);
    $border->set_left(1);
    $border->set_border(1);
    $border->set_bold(1);
    // $border->set_h_align('merge');

    $t = count($headers) - 1;
    $myxls->set_column(0, $t, 30);

    $myxls->write(0, 0, "Role title: " . selectrolename($roleid), $formattitle);
    $myxls->write(1, 0, "Date time: " . date('d/m/Y h:i:s', time()) . "", $formattitle);

    //$myxls->write(3, 0, "Candidate Profile", $border);
    //$myxls->write(3, $colsprofile, "Candidate Performance", $border);
    // set header here!
    $colnum = 0;
    foreach ($headers as $item) {
        $myxls->write(5, $colnum, $item, $formatheader);
        $colnum++;
    }
    $rownum = 6;

    // Content start here!!!
    for ($i = 0; $i < sizeof($selectedusers); $i++) {
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
            $row[] = strtoupper($users->traineeid);
        }
        if ($users->firstname) {
            $row[] = $users->firstname;
        }
        if ($users->lastname) {
            $row[] = $users->lastname;
        }
        if ($users->dob) {
            $row[] = $udob;
        }
        $row[] = $designation;
        $row[] = $subgroupname;

        // display content
        foreach ($row as $item) {
            $myxls->write($rownum, $colnum1, $item, $format);
            $colnum1++;
        }
        $rownum++;
    }
    $workbook->close();
}   