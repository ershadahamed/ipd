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
#groupline{width:98%; margin:0.8em auto}
#recipientdetails, #searchbox, #startdatepicker, #specificdate, #enddatepicker { width:200px; height: 1.8em; margin-right: 5px;}
#starttimepicker, #endtimepicker { width:150px; height: 1.8em; margin-right: 5px; }
#scheduleweekly, #schedulemonthly{ width:200px; height: 1.8em; margin-left:1em;} 
</style>
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// organization/communicationhome_process.php?formtype=Communication&imagebutton=Schedule&whichbutton=New&communicationid=3

require_once('../config.php');
require_once('../lib.php');
require_once('../examcenter/lib.php');
require_once('lib.php');
require_once('lib_organization.php');
require_once('communication_lib.php');
require_once($CFG->libdir . '/logactivity_lib.php');

$formtype = optional_param('formtype', '', PARAM_MULTILANG);
$whichbutton = optional_param('whichbutton', '', PARAM_MULTILANG);
$recipienttype = optional_param('utype', '', PARAM_MULTILANG);
$imagebutton = optional_param('imagebutton', '', PARAM_MULTILANG);
$communicationid = optional_param('communicationid', '', PARAM_INT);
$scheduleid = optional_param('scheduleid', '', PARAM_INT); // edit
$shedule_actionbutton = optional_param('shedule_actionbutton', '', PARAM_MULTILANG);
$recipientdetails = optional_param('recipientdetails', '', PARAM_MULTILANG); 
$search = optional_param('searchbox', '', PARAM_MULTILANG); 

$gotoconfirmationpage = 'communicationhome_process.php?formtype='.$formtype.'&imagebutton='.$imagebutton.'&whichbutton='.$whichbutton;

$PAGE->set_url('/');
$PAGE->set_course($SITE);
$PAGE->set_context(get_system_context());

// load JS
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/jquery-1.9.1.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/jquery-ui.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/script.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/communication.js'));

// load CSS
$PAGE->requires->css(new moodle_url($CFG->wwwroot . '/js/jquery-ui.css'));

$productionheader = get_string('production');
$schedulingheader = get_string('scheduling');
$url = new moodle_url('/organization/communicationhome_process.php?formtype=' . $formtype . '&imagebutton=' . $imagebutton . '&whichbutton=' . $whichbutton . '&communicationid=' . $communicationid.'&utype='.$recipienttype);
$PAGE->navbar->add(ucwords(strtolower($productionheader)), $url)->add(ucwords(strtolower($schedulingheader)), $url);
if(!empty($scheduleid)){
    $PAGE->navbar->add(ucwords(strtolower('Edit Scheduling')), '');
}else{
    $PAGE->navbar->add(ucwords(strtolower(get_string('addnewschedule'))), $url);
}

$PAGE->set_pagetype('site-index');
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('buy_a_cifa');

$actionbuttoncolor = 'id_actionbutton';
$defaultbuttoncolor = 'id_defaultbutton';

echo $OUTPUT->header();
require_login();

$a = new stdClass();
switch ($imagebutton) {
    case get_string('schedule'):
        $a->buttonname = get_string('scheduling');
        break;
    case get_string('email1'):
        $a->buttonname = get_string('email1') . '/' . get_string('scheduling');
        break;
}

switch ($recipienttype) {
    case get_string('individual'):
        $a->utype = get_string('individual');
        break;
    case get_string('organization'):
        $a->utype = get_string('organization');
        break;
}

// active color for TAP
if($recipienttype==get_string('individual')){ $ab=$actionbuttoncolor; $d=$actionbuttoncolor; $u = get_string('individual'); }else{$ab=$defaultbuttoncolor;}
if($recipienttype==get_string('organization')){ $ac=$actionbuttoncolor; $u = get_string('organization'); }else{$ac=$defaultbuttoncolor;}

switch ($shedule_actionbutton) {
    case get_string('back'):
        $abc=$actionbuttoncolor;
        break;
    case get_string('confirm'):
        $d=$actionbuttoncolor;
        break;
    default:
        $abc=$defaultbuttoncolor;
        // $d=$defaultbuttoncolor;
}

// echo $u;
$formlink = 'communicationaction.php?formtype=' . $formtype .'&communicationid='.$communicationid.'&imagebutton=' . $imagebutton.'&utype='.$recipienttype;
if(!empty($scheduleid)){
    $formlink .= '&scheduleid='.$scheduleid;
}

echo html_writer::start_tag('form', array('id' => 'typeofsupportform', 'name' => 'typeofsupportform', 'method' => 'post'));
echo html_writer::start_tag('h3', array('style' => 'margin-top:1em;margin-bottom:1em;')) . get_string('communicationhome_process', '', $a) . '</h3>';

// Start 3st fieldset // TAB ->> induvidual, organization
$fieldset = html_writer::start_tag('fieldset', array('id' => 'group', 'class' => 'clearfix_group'));     
$fieldset .= html_writer::start_tag('legend', array('class' => 'ftoggler'));
$fieldset .= html_writer::end_tag('legend');
echo createinputtext('hidden', 'utype', 'utype', $recipienttype,'','','');
echo createinputtext('submit', $ab, 'utype', get_string('individual'), '', 'line-height:2em;margin-right:0.5em;');
echo createinputtext('submit', $ac, 'utype', get_string('organization'), '', 'line-height:2em;margin-right:0.5em;');
echo $fieldset;

if($recipienttype == get_string('individual')){
    $titletype = get_string('candidatedetail');
}
else if($recipienttype == get_string('organization')){
    $titletype = get_string('orgname');
}
    
echo '<div id="searchgroupline">';
echo '<div class="searchgrouptitle">';
echo $titletype;
echo '</div>';

if($recipienttype == get_string('individual')){
    echo '<div class="searchgroupdp"><select name="recipientdetails" id="recipientdetails">
        <option value=""></option>
        <option value="traineeid">'.get_string('candidateid').'</option>
        <option value="firstname">'.get_string('firstname').'</option>
        <option value="lastname">'.get_string('lastname').'</option>
        <option value="dob">'.get_string('dateofbirth').'</option>
        <option value="institution">'.get_string('orgname').'</option>
    </select></div>';
}

echo '<div class="searchgroupbox">';
echo createinputtext('text', 'searchbox', 'searchbox', '','','','');
echo '</div>';
echo '<div class="searchgroupbtn">';
echo createinputtext('submit', $d, 'searchbutton', get_string('search'), '', 'margin-right:0.5em;line-height: 0.8em;', '');
echo '</div>';
echo '</div>';
//echo html_writer::end_tag('div');

echo html_writer::start_tag('div', array('id' => 'searchgroupline'));
echo html_writer::start_tag('div', array('class' => 'searchtextline'));
echo get_string('emailschedulenotice', '', $a);
echo html_writer::end_tag('div');
echo html_writer::start_tag('div', array('class' => 'buttonline'));
// Button -> Confirm // Select All // Unselect All // Back
$aaction = "this.form.action='".$formlink."'";
echo createinputtext('button', $abc, 'shedule_actionbutton', get_string('back'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick="window.close();"');
echo createinputtext('submit', $d, 'shedule_actionbutton', get_string('confirm'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onClick="'.$aaction.'"');
echo createinputtext('button', $abc, 'shedule_actionbutton', get_string('unselectall'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick="clearSelected();"');
echo createinputtext('button', $abc, 'shedule_actionbutton', get_string('selectall'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick="checkedAll();"');
echo html_writer::end_tag('div');
echo html_writer::end_tag('div');

echo '<div style="margin-bottom:2em;"></div>';


$statement = "
  mdl_cifacourse a Inner Join
  mdl_cifaenrol b On a.id = b.courseid Inner Join
  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
  mdl_cifauser d On c.userid = d.id
";

if ($USER->id != '2') {
    $statement.=" WHERE d.id!='1' AND d.deleted!='1' AND d.confirmed='1' AND c.userid!='" . $USER->id . "' AND d.orgtype='" . $USER->orgtype . "'";           
} else {
    $statement.=" WHERE d.id!='1' AND d.deleted!='1' AND d.confirmed='1' AND c.userid!='" . $USER->id . "'";
}
$statement.=" AND c.userid!='391' AND c.userid!='269'";
switch ($recipienttype) {
    case get_string('individual'):        
        if ($search != '') {
            if ($recipientdetails == 'dob') {
                $statement.=" AND ((date_format(from_unixtime(d.dob), '%d/%m/%Y') LIKE '%{$search}%'))";
            } else {
                $statement.=" AND {$recipientdetails} LIKE '%{$search}%'";
            }
        }
        // Display the table of users
        if (!empty($scheduleid)) {
            // EDIT Communication of SCHEDULING
            // organization/communication_lib.php
            communicationtableofusers_editscheduling($statement, $communicationid, $scheduleid);
        } else {
            // ADD NEW Communication of SCHEDULING
            // examcenter/lib.php
            display_tableofusers_report($statement);
        }
        break;
    case get_string('organization'):
        // echo get_string('organization');
        // recipient_organization();
        
        if ($search != '') {
            $statement.=" AND d.institution LIKE '%{$search}%'";
        }
        // Display the table of users
        if (!empty($scheduleid)) {
            // EDIT Communication of SCHEDULING
            // organization/communication_lib.php
            communicationtableofusers_editscheduling($statement, $communicationid, $scheduleid);
        } else {
            // ADD NEW Communication of SCHEDULING
            // examcenter/lib.php
            display_tableofusers_report($statement);
        }        
        break;
    default:
        break;
}
echo html_writer::end_tag('fieldset');
echo html_writer::end_tag('form');

echo $OUTPUT->footer();