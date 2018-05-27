<body onLoad="window.print()">
<style>
    table {
        margin-bottom: 1em;
        border-collapse: collapse;
        border-spacing: 0;
        font-size: 1em;
        width: 90%;
        margin: 1em auto;
    }
    .formtable tbody th, .generaltable th.header {
        vertical-align: top;
        font-size: 12px;
        font-weight: bolder;
    }

    .cell {
        vertical-align: top;
    }
    th, td {
        border: 1px solid #000;
        padding: .5em;
    }
    tr {
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }
    td.maincalendar table.calendartable th, table.rolecap .header, .generaltable .header, .forumheaderlist .header, .files .header, .editcourse .header, .logtable .header, #attempts .header, table#categoryquestions th {
        background: #f9f9f9 !important;
        font-size: 11px;
        font-weight: 200;
        text-decoration: none;
        color: #333 !important;
        border-top: 1px solid #ccc !important;
    }
    #page-admin-course-category .generalbox th, .editcourse .header, .results .header, #attempts .header, .generaltable .header, .environmenttable th, .forumheaderlist th {
        background: #f3f3f3;
        border-bottom-width: 2px;
    }
    .editcourse th, .editcourse td, .generaltable th, .generaltable td, #page-admin-course-category .generalbox th, #page-admin-course-category .generalbox td, #attempts th, #attempts td, .environmenttable th, .environmenttable td, .forumheaderlist td, .forumheaderlist th {
        border: 1px solid #ddd;
        border-collapse: collapse;
    }
    html, body {
        font-family: Verdana,Geneva,sans-serif!important;
    }
    body {
        font: 13px/1.231 arial,helvetica,clean,sans-serif;
    }
    h3{
        width: 90%;
        margin: 0em auto;        
    }
    .datetime {
        width: 90%;
        margin: 0.3em auto;        
    }
</style>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../../config.php');
require_once($CFG->libdir . '/tablelib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/datalib.php');
require_once($CFG->dirroot . '/lib.php');
require_once('../lib.php');
require_once('../lib_organization.php');
require_once('../userrole_lib.php');
require_once('../../examcenter/lib.php');

$site = get_site();
$streditexamrules = get_string("userrole");
$userroleprocess = get_string("userroleedit");
$title = "$site->shortname: $streditexamrules - ".get_string('finalstep');
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
$searchboxorg= optional_param('searchboxorg', '', PARAM_MULTILANG); 
$selectedusers = optional_param('checktoken', '', PARAM_INT);

// Navigation $shedule_actionbutton
$PAGE->navbar->add(ucwords(strtolower(get_string('userrole'))), '');
$PAGE->navbar->add(ucwords(strtolower(get_string('assigneduser'))), '')->add(ucwords(strtolower($shedule_actionbutton)), '');

// load JS
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/jquery-1.9.1.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/jquery-ui.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/script.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/communication.js'));

// Role title & Role Assigned/Remove datetime;
print_r('<br/>');
print_r('<h3>'.selectrolename($roleid).'</h3>');
print_r('<div class="datetime">'.date('d/m/Y H:i:s', time()).'</div>');

// Display table
// echo display_tableofusers_roleassignment($statement);   // userrole_lib.php
$table = new html_table();
$table->head = array(get_string('candidateid'), get_string('firstname'), get_string('lastname'), get_string('dob'), get_string('designation'), get_string('organization'));
$table->align = array("center", "left", "left", "center", "left", "left");
$table->width = "98%";
$table->attributes = array('style' => 'margin-top:2em;margin-left:auto;margin-right:auto');

if(!empty($selectedusers)){
    for ($i = 0; $i < sizeof($selectedusers); $i++) {
        // delete only // HIDE
        // checkboxdel_activities($selectedusers[$i]); // id 
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
        $table->data[] = array(strtoupper($users->traineeid), $users->firstname, $users->lastname, $udob, $designation, $subgroupname);
        // print_r($selectedusers[$i].'<br/>');
    }
}

if (!empty($table)) {
    echo html_writer::table($table);
} 

