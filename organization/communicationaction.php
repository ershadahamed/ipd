<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../config.php');
require_once('../lib.php');
require_once('../examcenter/lib.php');
require_once('lib.php');
require_once('lib_organization.php');
require_once('communication_lib.php');
require_once($CFG->libdir . '/logactivity_lib.php');

$formtype = optional_param('formtype', '', PARAM_MULTILANG);
$recipienttype = optional_param('utype', '', PARAM_MULTILANG);
$imagebutton = optional_param('imagebutton', '', PARAM_MULTILANG);
$communicationid = optional_param('communicationid', '', PARAM_INT);
$scheduleid = optional_param('scheduleid', '', PARAM_INT);

$site = get_site();
$strcommunication = get_string("communication");
$userroleprocess = get_string("userroleedit");
$title = "$site->shortname: $strcommunication - ".get_string('scheduling');
if(!empty($scheduleid)){
    $title .= " - ". get_string('editscheduling');
}else{
    $title .= " - ". get_string('addnewschedule');
}
$fullname = $site->fullname;

$PAGE->set_url('/');
$PAGE->set_title($title);
$PAGE->set_course($site);
$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('buy_a_cifa');
$PAGE->set_heading($fullname);

// Navigation
$PAGE->navbar->add(ucwords(strtolower(get_string('communication'))), '');
$PAGE->navbar->add(ucwords(strtolower(get_string('scheduling'))), '');
if(!empty($scheduleid)){
    $PAGE->navbar->add(ucwords(strtolower('Edit Scheduling')), '');
}else{
    $PAGE->navbar->add(ucwords(strtolower(get_string('addnewschedule'))), '');
}

// load JS
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/jquery-1.9.1.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/jquery-ui.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/script.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/communication.js'));

// load CSS
$PAGE->requires->css(new moodle_url($CFG->wwwroot . '/js/jquery-ui.css'));
$PAGE->requires->css(new moodle_url($CFG->wwwroot . '/css/communication.css'));

echo $OUTPUT->header();
require_login();

$selectedusers = $_POST['checktoken'];

if ($selectedusers == "") {
    $new = $CFG->wwwroot . '/organization/communicationhome_process.php?formtype=' . $formtype;
    $new .= '&imagebutton=' . $imagebutton . '&whichbutton=' . get_string('new') . '&communicationid=' . $communicationid . '&utype=' . $recipienttype;
    ?>
    <script language="javascript">
        window.alert("Please select users for this report.");
        window.location.href = '<?= $new; ?>';
    </script>
    <?php
}
// list of selected user here
if ($selectedusers != "") {
    $select = "scheduleid = '" . $scheduleid . "' AND communicationid = '" . $communicationid . "'";
    $DB->delete_records_select('communication_schedulinguser', $select);

    $checkBox = $selectedusers;
    for ($i = 0; $i < sizeof($checkBox); $i++) {
        // echo $checkBox[$i];
        $getusers = $DB->count_records('communication_schedulinguser', array('scheduleid' => $scheduleid, 'communicationid' => $communicationid, 'userid' => $checkBox[$i]));
        if (empty($getusers)) {
            // save to database
            communicationschedulinguser($checkBox[$i], $communicationid, $scheduleid); // comunication_lib.php
        }
        //echo '<br/>';
    }
}
// End list of selected user here

$schedulingrecords = get_communicationschedulingusers($scheduleid);
if($schedulingrecords->scheduling == 'daily'){
    $selectedscheduletime = 'checked = "checked"';
}
else if($schedulingrecords->scheduling == 'scheduleweekly'){
    $selectedscheduletime = 'checked = "checked"';
    $schedulingtimew = $schedulingrecords->scheduling_time;
}
else if($schedulingrecords->scheduling == 'schedulemonthly'){
    $selectedscheduletime = 'checked = "checked"';
    $schedulingtimem = $schedulingrecords->scheduling_time;
}
else if($schedulingrecords->scheduling == 'specificdate'){
    $selectedscheduletime = 'checked = "checked"';
    $schedulingtimes = $schedulingrecords->scheduling_time;
}

if(!empty($scheduleid)){
    $startdatepicker = $schedulingrecords->startdate;
    $enddatepicker = $schedulingrecords->enddate;
    $starttimepickervalue = $schedulingrecords->starttime;
    $endtimepickervalue = $schedulingrecords->endtime;
}

$a = new stdClass();
switch ($imagebutton) {
    case get_string('schedule'):
        $a->buttonname = get_string('scheduling');
        break;
    case get_string('email1'):
        $a->buttonname = get_string('email1') . '/' . get_string('scheduling');
        break;
}
echo html_writer::start_tag('form', array('id' => 'typeofsupportform', 'name' => 'typeofsupportform', 'method' => 'post', 'action' => 'communication_previewmessage.php?communicationid='.$communicationid.'&scheduleid='.$scheduleid));
echo html_writer::start_tag('h3', array('style' => 'margin-top:1em;margin-bottom:1em;')) . get_string('communicationhome_process', '', $a) . '</h3>';
echo createinputtext('hidden', 'communicationid', 'communicationid', $communicationid, '', 'margin-left:4.2em;', '');
echo createinputtext('hidden', 'utype', 'utype', $recipienttype, '', 'margin-left:4.2em;', '');
//echo createinputtext('hidden', 'scheduleid', 'scheduleid', $scheduleid, '', 'margin-left:4.2em;', '');

// Start 1st fieldset // SCHEDULING
$fieldset1 = html_writer::start_tag('fieldset', array('id' => 'group', 'class' => 'clearfix_group'));
$fieldset1 .= html_writer::start_tag('legend', array('class' => 'ftoggler'));
$fieldset1 .= get_string('scheduling');
$fieldset1 .= html_writer::end_tag('legend');
echo $fieldset1;
// createinputtext(type, id, name, value, placeholder, style, $additional)
echo '<div id="groupline">';
echo '<input type="radio" name="scheduletime" id="scheduletime" value="daily" style="margin:0.5em 0.5em;"';
if($schedulingrecords->scheduling == 'daily'){
    echo 'checked = "checked"';
}
echo ' />'. get_string('daily') . '<br/>';

echo '<input type="radio" name="scheduletime" id="scheduletime" value="scheduleweekly" style="margin:0.5em 0.5em;"';
if($schedulingrecords->scheduling == 'scheduleweekly'){
    echo 'checked = "checked"';
}
echo ' />'. get_string('weekly');
$communication_weekly = communication_weeklyselection($schedulingtimew);
echo $communication_weekly. '<br/>';

// Monthly radio button
echo '<input type="radio" name="scheduletime" id="scheduletime" value="schedulemonthly" style="margin:0.5em 0.5em;"';
if($schedulingrecords->scheduling == 'schedulemonthly'){
    echo 'checked = "checked"';
}
echo ' />'. get_string('monthly');
echo '<select name="schedulemonthly" id="schedulemonthly">';
echo '<option value=""> ' . get_string('chooseone') . ' </option>';
//$dayoftheday = date('d', time());

for ($i = 1; $i <= daysina_month(); $i++) {
    echo '<option value="' . $i . '"';
    if ($schedulingtimem== $i) {
        echo 'selected="selected"';
    }
    echo ' >' . $i . '</option>';
}
echo '</select>' . '<br/>';

// specificdate radio button
echo '<input type="radio" name="scheduletime" id="scheduletime" value="specificdate" style="margin:0.5em 0.5em;"';
if($schedulingrecords->scheduling == 'specificdate'){
    echo 'checked = "checked"';
}
echo ' />'. get_string('specificdate');
if(!empty($schedulingtimes)){
    $specificdatedata = $schedulingtimes;
}
echo createinputtext('text', 'specificdate', 'specificdate', $specificdatedata, '', 'margin-left:4.2em;', '');
echo '<br/></div>';
echo html_writer::end_tag('fieldset');

// PREVIEW BUTTON
//$new = $CFG->wwwroot . '/organization/communication_previewmessage.php?formtype=' . $formtype;
//$new .= '&imagebutton=' . get_string('schedule') . '&whichbutton=' . get_string('new') . '&communicationid=' . $communicationid . '&utype=' . get_string('individual');
//$newlink = "window.open('" . $new . "','_blank')";

$previewbtn = html_writer::start_tag('div', array('id' => 'previewmessagebutton'));
$previewbtn .= html_writer::start_tag('div', array('class' => 'previewbtn'));
// $previewbtn .= createinputtext('button', 'id_actionbutton', 'previewmessage', get_string('previewmessage'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick="' . $newlink . '"');
$previewbtn .= createinputtext('submit', 'id_actionbutton', 'previewmessage', get_string('previewmessage'), '', 'margin-right:0.5em;line-height: 0.8em;');
$previewbtn .= html_writer::end_tag('div');
$previewbtn .= html_writer::end_tag('div');
print_r($previewbtn);

// Start 2st fieldset // Recurrence Time
$fieldset2 = html_writer::start_tag('fieldset', array('id' => 'group', 'class' => 'clearfix_group'));
$fieldset2 .= html_writer::start_tag('legend', array('class' => 'ftoggler'));
$fieldset2 .= get_string('recurrencetimeline');
$fieldset2 .= html_writer::end_tag('legend');
echo $fieldset2;
echo '<div id="groupline">' . get_string('recurrencetimelinenotice') . '</div>';
echo '<div id="searchgroupline">';
echo '<div class="searchgrouptitle">' . get_string('empstartdate') . '</div>';
echo '<div class="searchgroupbox">';
echo createinputtext('text', 'startdatepicker', 'startdatepicker', $startdatepicker, '', '', '');
echo createtimepicker('starttimepicker', $starttimepickervalue); // select time
echo '</div>';
echo '</div><br/>';

echo '<div id="searchgroupline">';
echo '<div class="searchgrouptitle">' . get_string('empenddate') . '</div>';
echo '<div class="searchgroupbox">';
echo createinputtext('text', 'enddatepicker', 'enddatepicker', $enddatepicker, '', '', '');
echo createtimepicker('endtimepicker', $endtimepickervalue); // select time
echo '</div>';
echo '</div>';
echo html_writer::end_tag('fieldset');

// Back Button
//echo '<div style="margin:0px auto;">';
//echo createinputtext('button', $d, 'backbutton', get_string('back'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick=""');
//echo '</div>';

echo html_writer::end_tag('form');

echo $OUTPUT->footer();
