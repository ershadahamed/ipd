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
    #recipientdetails, #searchboxindividual, #searchboxorg, #startdatepicker, #specificdate, #enddatepicker { width:200px; height: 1.8em; margin-right: 5px;}
    #starttimepicker, #endtimepicker { width:150px; height: 1.8em; margin-right: 5px; }
    #scheduleweekly, #schedulemonthly{ width:200px; height: 1.8em; margin-left:1em;} 
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
$title = "$site->shortname: $streditexamrules - " . get_string('assigneduser');
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

// Navigation
$PAGE->navbar->add(ucwords(strtolower(get_string('userrole'))), '');
$PAGE->navbar->add(ucwords(strtolower(get_string('assigneduser'))), '');
/* if(!empty($scheduleid)){
  $PAGE->navbar->add(ucwords(strtolower('Edit Scheduling')), '');
  }else{
  $PAGE->navbar->add(ucwords(strtolower(get_string('addnewschedule'))), '');
  }
  $PAGE->navbar->add(ucwords(strtolower(get_string('previewmessage'))), ''); */

// load JS
// $PAGE->requires->js(new moodle_url($CFG->wwwroot . '/js/jquery-latest.js'));
?>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#id_radio1').click(function () {
            $('#div2').hide('fast');
            $('#div1').show('fast');
        });
        $('#id_radio2').click(function () {
            $('#div1').hide('fast');
            $('#div2').show('fast');
        });
    });
</script>
<?php
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

/// User TYPE
$fieldset1 = html_writer::start_tag('fieldset', array('id' => 'group', 'class' => 'clearfix_group'));
$fieldset1 .= html_writer::start_tag('legend', array('class' => 'ftoggler'));
$fieldset1 .= get_string('usertype');
$fieldset1 .= html_writer::end_tag('legend');
print_r($fieldset1);
print_r('<br/>');

// LINK to next page (Final Step)
$formlink = 'userrole_finalstep.php?id=' . $roleid . '&name_radio1=' . $radio . '&tab=' . $tab;
if (!empty($scheduleid)) {
    $formlink .= '&scheduleid=' . $scheduleid;
}

echo html_writer::start_tag('form', array('id' => 'typeofsupportform', 'name' => 'typeofsupportform', 'method' => 'post'));


echo '<input id="id_radio1" type="radio" name="name_radio1" value="5" ';
if (($radio == '5')) {
    echo 'checked="checked"';
}
echo ' />' . get_string('individual') . '<br>';
echo '<input id="id_radio2" type="radio" name="name_radio1" value="6" ';
if (($radio == '6')) {
    echo 'checked="checked"';
}
echo ' />' . get_string('organization') . '<br>';
print_r(html_writer::end_tag('fieldset'));
// END User Type

/* * ************************ SQL ************************** */
$statement = "
  mdl_cifarole a Inner Join
  mdl_cifarole_assignments b On a.id = b.roleid Inner Join
  mdl_cifauser c On b.userid = c.id
";

if ($tab == get_string('new')) {
    $statement.=" WHERE c.id>2 And b.roleid != '" . $roleid . "' And b.roleid != '0' And b.contextid = '1' And (b.roleid = '16' Or b.roleid = '14' Or b.roleid = '9')";
}else{
    $statement.=" WHERE c.id>2 And b.roleid = '" . $roleid . "'";
}
//$statement.=" AND c.userid!='391' AND c.userid!='269'";
/* * ************************************************************************* */


echo createinputtext('hidden', 'tab', 'tab', $tab, '', '', '');
echo createinputtext('hidden', 'susers', 'susers', $selectedusers, '', '', '');
// echo createinputtext('hidden', 'name_radio1', 'name_radio1', $radio,'','','');
$buttonhere .= createinputtext('submit', $ab, 'tab', get_string('assigned'), '', 'line-height:2em;margin-right:0.5em;');
$buttonhere .= createinputtext('submit', $ac, 'tab', get_string('new'), '', 'line-height:2em;margin-right:0.5em;');
$a = new stdClass();
// individual here
echo '<div id="div1"';
if ($radio != '5') {
    echo 'style="display:none;"';
}
echo '>';
echo createinputtext('hidden', 'urole', 'urole', $radio, '', '', '');
$a->utype = get_string('individual');
echo '<h3>' . get_string('individual') . '</h3>';
$html1 .= html_writer::start_tag('fieldset', array('id' => 'group', 'class' => 'clearfix_group'));
$html1 .= html_writer::start_tag('legend', array('class' => 'ftoggler'));
// $html1 .= get_string('individual');
$html1 .= html_writer::end_tag('legend');
echo $buttonhere;
echo $html1;

echo '<div id="searchgroupline">';
echo '<div class="searchgrouptitle">';
echo get_string('candidatedetail');
echo '</div>';

echo '<div class="searchgroupdp"><select name="recipientdetails" id="recipientdetails">
    <option value=""></option>
    <option value="traineeid">' . get_string('candidateid') . '</option>
    <option value="firstname">' . get_string('firstname') . '</option>
    <option value="lastname">' . get_string('lastname') . '</option>
    <option value="dob">' . get_string('dateofbirth') . '</option>
    <option value="institution">' . get_string('orgname') . '</option>
</select></div>';

echo '<div class="searchgroupbox">';
echo createinputtext('text', 'searchboxindividual', 'searchboxindividual', '', '', '', '');
echo '</div>';
echo '<div class="searchgroupbtn">';
echo createinputtext('submit', $d, 'searchbutton', get_string('search'), '', 'margin-right:0.5em;line-height: 0.8em;', '');
echo '</div>';
echo '</div>';

echo html_writer::start_tag('div', array('id' => 'searchgroupline'));
echo html_writer::start_tag('div', array('class' => 'searchtextline'));
echo get_string('emailschedulenotice', '', $a);
echo html_writer::end_tag('div');
echo html_writer::start_tag('div', array('class' => 'buttonline'));
// Button -> Confirm // Select All // Unselect All // Back
$aaction = "this.form.action='" . $formlink . "'";
echo createinputtext('button', $abc, 'shedule_actionbutton', get_string('back'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick="window.close();"');
if ($tab == get_string('new')) {
    echo createinputtext('submit', $d, 'shedule_actionbutton', get_string('assign'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onClick="' . $aaction . '"');
} else {
    echo createinputtext('submit', $d, 'shedule_actionbutton', get_string('remove'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onClick="' . $aaction . '"');
}
echo createinputtext('button', $abc, 'shedule_actionbutton', get_string('unselectall'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick="clearSelected();"');
echo createinputtext('button', $abc, 'shedule_actionbutton', get_string('selectall'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick="checkedAll();"');
echo html_writer::end_tag('div');
echo html_writer::end_tag('div');
echo '<div style="margin-bottom:2em;"></div>';

// SEARCH CODE
if ($searchboxindividual != '') {
    if ($recipientdetails == 'dob') {
        $statement.=" AND ((date_format(from_unixtime(c.dob), '%d/%m/%Y') LIKE '%{$searchboxindividual}%'))";
    } else {
        $statement.=" AND {$recipientdetails} LIKE '%{$searchboxindividual}%'";
    }
}

// echo display_tableofusers_roleassignment($statement);   // userrole_lib.php
$table = new html_table();
$table->head = array(get_string('candidateid'), get_string('firstname'), get_string('lastname'), get_string('dob'), get_string('designation'), get_string('organization'), "");
$table->align = array("center", "left", "left", "center", "left", "left", "center");
$table->width = "98%";
$table->attributes = array('style' => 'margin-left:auto;margin-right:auto');

$records = getrole_assignmentsql($statement);
foreach ($records as $users) {
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
    $cbox = createinputcheckdelete('checkbox', 'checktoken', "checktoken[]", $users->id); // '<input type="checkbox" name="checktoken[]" id="checktoken[]" value="' . $users->userid . '" />';
    $table->data[] = array(strtoupper($users->traineeid), $users->firstname, $users->lastname, $udob, $designation, $subgroupname, $cbox);
}
if (!empty($table)) {
    echo html_writer::table($table);
}

echo html_writer::end_tag('fieldset');
echo '</div>';

// ################################################################################################
// ORGANIZATION HERE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// organization here
echo '<div id="div2"';
if ($radio != '6') {
    echo 'style="display:none;"';
}
echo '>';
echo createinputtext('hidden', 'urole', 'urole', $radio, '', '', '');
$a->utype = get_string('organization');
echo '<h3>' . get_string('organization') . '</h3>';
$html .= html_writer::start_tag('fieldset', array('id' => 'group', 'class' => 'clearfix_group'));
$html .= html_writer::start_tag('legend', array('class' => 'ftoggler'));
// $html .= get_string('organization');
$html .= html_writer::end_tag('legend');
echo $buttonhere;
echo $html;

echo '<div id="searchgroupline">';
echo '<div class="searchgrouptitle">';
echo get_string('orgname');
echo '</div>';

echo '<div class="searchgroupbox">';
echo createinputtext('text', 'searchboxorg', 'searchboxorg', '', '', '', '');
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
$aaction = "this.form.action='" . $formlink . "'";
echo createinputtext('button', $abc, 'shedule_actionbutton', get_string('back'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick="window.close();"');
if ($tab == get_string('new')) {
    echo createinputtext('submit', $d, 'shedule_actionbutton', get_string('assign'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onClick="' . $aaction . '"');
} else {
    echo createinputtext('submit', $d, 'shedule_actionbutton', get_string('remove'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onClick="' . $aaction . '"');
}
//echo createinputtext('submit', $d, 'shedule_actionbutton', get_string('remove'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onClick="'.$aaction.'"');
echo createinputtext('button', $abc, 'shedule_actionbutton', get_string('unselectall'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick="clearSelected();"');
echo createinputtext('button', $abc, 'shedule_actionbutton', get_string('selectall'), '', 'margin-right:0.5em;line-height: 0.8em;', 'onclick="checkedAll();"');
echo html_writer::end_tag('div');
echo html_writer::end_tag('div');
echo '<div style="margin-bottom:2em;"></div>';


if ($searchboxorg != '') {
    $statement.=" AND c.institution LIKE '%{$searchboxorg}%'";
}
echo display_tableofusers_roleassignment($statement);
echo html_writer::end_tag('fieldset');
echo '</div>';

echo html_writer::end_tag('form');
echo $OUTPUT->footer();
