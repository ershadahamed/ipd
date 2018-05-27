<style>
    #searchgroupline {
        width: 98%;
        margin: 1em auto 1em auto;
    } 
    #searchgroupline .searchtextline { float:left; line-height: 40px; display:block;}
    #searchgroupline .buttonline { float:right; margin-bottom: 1em; display:block;}
    .clearfix_group{
        margin-bottom:2em;
    }
    fieldset.clearfix_group{ width:98%;}

    #previewmessagebutton {
        width:100%;
        margin: 1em auto 1em auto;
    } 
    .previewbtn{
        float:right; 
        display: block;
    }

    .searchgrouptitle{
        margin-right: 5px;
        width: 132px;
        display: block;
        float:left; 
        line-height: 2em;
    }
    .searchgroupbox, .searchgroupdp{
        display: block;
        float:left;     
    }
    #group{ margin-top: 1em;}
    #groupline{width:98%; margin:0.8em auto}
    #recipientdetails, #searchboxindividual, #searchboxorg, #startdatepicker, #specificdate, #enddatepicker { width:200px; height: 1.8em; margin-right: 5px;}
    #starttimepicker, #endtimepicker { width:150px; height: 1.8em; margin-right: 5px; }
    #scheduleweekly, #schedulemonthly{ width:200px; height: 1.8em; margin-left:1em;} 

    .myButton {
        background-color:#21409a;
        -moz-border-radius:5px;
        -webkit-border-radius:5px;
        border-radius:5px;
        border:1px solid #21409a;
        padding:5px 10px;
        color:#ffffff;
        text-decoration:none;
        margin-right:0.5em;line-height: 0.8em;
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

echo $OUTPUT->header();
require_login();

$actionbuttoncolor = 'id_actionbutton';
$defaultbuttoncolor = 'id_defaultbutton';

// active color for TAP
if ($tab == get_string('assigned')) {
    $ab = $actionbuttoncolor;
    $d = $actionbuttoncolor;
    $u = get_string('assigned');
} else {
    $ab = $defaultbuttoncolor;
}
if ($tab == get_string('new')) {
    $ac = $actionbuttoncolor;
    $u = get_string('new');
} else {
    $ac = $defaultbuttoncolor;
}

// LINK to next page (print page)
$formlink = 'userrole_assigneduser_print.php?id=' . $roleid . '&name_radio1=' . $radio . '&tab=' . $tab;
$linkprint = $CFG->wwwroot . '/organization/userrole/userrole_assigneduser_print.php?id=' . $roleid . '&name_radio1=' . $radio . '&tab=' . $tab;
$linkexcel = $CFG->wwwroot . '/organization/userrole/userrole_downloadexcel.php?id=' . $roleid . '&name_radio1=' . $radio . '&tab=' . $tab;
$linkcsv = $CFG->wwwroot . '/organization/userrole/userrole_downloadcsv.php?id=' . $roleid . '&name_radio1=' . $radio . '&tab=' . $tab;
$actionprint = "Onclick=this.form.action='" . $linkprint . "';target='_blank'";  // 1. link to print page
$downloadexcel = "Onclick=this.form.action='" . $linkexcel . "';target='_blank'";
$downloadcsv = "Onclick=this.form.action='" . $linkcsv . "';target='_blank'";

echo html_writer::start_tag('form', array('id' => 'typeofsupportform', 'name' => 'typeofsupportform', 'method' => 'post'));
echo createinputtext('hidden', 'tab', 'tab', $tab, '', '', '');
echo createinputtext('hidden', 'urole', 'urole', $radio, '', '', '');
echo createinputtext('hidden', 'checktoken', 'checktoken', $selectedusers, '', '', '');
echo createinputtext('hidden', 'shedule_actionbutton', 'shedule_actionbutton', $shedule_actionbutton, '', '', '');
// $a = new stdClass();
// $a->utype = get_string('individual');
// Role title & Role Assigned/Remove datetime;
print_r('<br/>');
print_r('<h3>' . selectrolename($roleid) . '</h3>');
print_r(date('d/m/Y H:i:s', time()));

$html1 .= html_writer::start_tag('fieldset', array('id' => 'group', 'class' => 'clearfix_group'));
$html1 .= html_writer::start_tag('legend', array('class' => 'ftoggler'));
$html1 .= html_writer::end_tag('legend');
echo $html1;

// $htmlpages = file_put_contents('yourpage.html', ob_get_contents());
echo html_writer::start_tag('div', array('id' => 'searchgroupline'));
echo html_writer::start_tag('div', array('class' => 'searchtextline'));

echo '<a title="Click on HTML, EXCEL, CSV button to download" class="myButton">' . get_string('download') . '</a>';
echo "<input type='submit' " . $actionprint . " name='shedule_actionbutton' id='" . $defaultbuttoncolor . "' value='" . get_string('downloadhtml') . "' style='margin-right:0.5em;line-height: 0.8em;' />";
echo "<input type='submit' " . $downloadexcel . " name='shedule_actionbutton' id='" . $defaultbuttoncolor . "' value='" . get_string('downloadexcel') . "' style='margin-right:0.5em;line-height: 0.8em;' />";
echo "<input type='submit' " . $downloadcsv . " name='shedule_actionbutton' id='" . $defaultbuttoncolor . "' value='" . get_string('downloadcsv') . "' style='margin-right:0.5em;line-height: 0.8em;' />";

// Notification
if ($tab == get_string('new')) {
    echo "User Assigned Successfully";
} else {
    echo "User Removed Successfully";
}

echo html_writer::end_tag('div');

// Button -> Back // Save // Print // Unselect All // Select All 
// $aaction = "this.form.action='".$formlink."'";
echo html_writer::start_tag('div', array('class' => 'buttonline'));
echo createinputtext('button', $abc, 'shedule_actionbutton', get_string('back'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick="history.go(-1);"');
echo createinputtext('submit', $d, 'shedule_actionbutton', get_string('save'), '', 'margin-right:0.5em;line-height: 0.8em;', $actionprint);
// echo createinputtext('submit', $abc, 'shedule_actionbutton', get_string('print'), '', 'margin-right:0.5em;line-height: 0.8em;', $actionprint);
echo "<input type='submit' " . $actionprint . " name='printbutton' id='" . $defaultbuttoncolor . "' value='" . get_string('print') . "' style='margin-right:0.5em;line-height: 0.8em;' />";
echo createinputtext('button', $abc, 'shedule_actionbutton', get_string('unselectall'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick="clearSelected();"');
echo createinputtext('button', $abc, 'shedule_actionbutton', get_string('selectall'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick="checkedAll();"');
echo html_writer::end_tag('div');
echo html_writer::end_tag('div');
echo '<div style="margin-bottom:2em;"></div>';

// Display table
// echo display_tableofusers_roleassignment($statement);   // userrole_lib.php
$table = new html_table();
$table->head = array(get_string('candidateid'), get_string('firstname'), get_string('lastname'), get_string('dob'), get_string('designation'), get_string('organization'), "");
$table->align = array("center", "left", "left", "center", "left", "left", "center");
$table->width = "98%";
$table->attributes = array('style' => 'margin-left:auto;margin-right:auto');

if (!empty($selectedusers)) {
    for ($i = 0; $i < sizeof($selectedusers); $i++) {
        $users = get_user_details($selectedusers[$i]);

        $statement = "
          {role} a Inner Join
          {role_assignments} b On a.id = b.roleid Inner Join
          {user} c On b.userid = c.id
        ";
        $statement.=" WHERE b.userid = '" . $users->id . "'";

        if ($tab == get_string('new')) {
            // $statement.=" And (b.roleid = '16') And b.contextid='1'";
            $statement.=" And b.roleid != '0' And b.contextid = '1' And (b.roleid = '16' Or b.roleid = '14' Or b.roleid = '9')";
        } else {
            $statement.=" And b.roleid = '" . $roleid . "' And b.contextid='1'";
        }

        // check available or not
        $sql = "Select COUNT(DISTINCT b.userid)
          From
            {$statement} 
          ";
        $gb = $DB->count_records_sql($sql);

        // Select user roleid
        $sql2 = "Select
            *
          From
            {$statement} 
          ";
        $gb2 = $DB->get_record_sql($sql2);
        $getroleid = $gb2->roleid;

        if (!empty($gb)) {
            // Assigned & removed the user
            remove_assignedusers($users->id, $roleid, $tab, $getroleid);
        }

        // dob 
        if ($users->dob != '') {
            $udob = date('d/m/Y', $users->dob);
        } else {
            $udob = ' - ';
        }
        // Sub organization name
        $organization = listoutall_groupusers($users->id);
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
        $cbox = createinputcheckdelete('checkbox', 'checktoken', "checktoken[]", $users->id);
        $table->data[] = array(strtoupper($users->traineeid), $users->firstname, $users->lastname, $udob, $designation, $subgroupname, $cbox);
        // print_r($selectedusers[$i].'<br/>');
    }
}

if (!empty($table)) {
    echo html_writer::table($table);
}


echo html_writer::end_tag('fieldset');
echo '</div>';

echo html_writer::end_tag('form');
echo $OUTPUT->footer();
