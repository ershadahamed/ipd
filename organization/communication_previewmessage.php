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
require_once('../certificate/lib.php');
require_once('previewmessage_form.php');

$formtype = optional_param('formtype', '', PARAM_MULTILANG);
$recipienttype = optional_param('utype', '', PARAM_MULTILANG);
$imagebutton = optional_param('imagebutton', '', PARAM_MULTILANG);
$communicationid = optional_param('communicationid', '', PARAM_INT);
$scheduleid = optional_param('scheduleid', '', PARAM_INT);

$scheduletime = optional_param('scheduletime', '', PARAM_MULTILANG);
$scheduleweekly = optional_param('scheduleweekly', '', PARAM_MULTILANG);
$schedulemonthly = optional_param('schedulemonthly', '', PARAM_MULTILANG);
$specificdate = optional_param('specificdate', '', PARAM_MULTILANG);

$startdatepicker = optional_param('startdatepicker', '', PARAM_MULTILANG);
$enddatepicker = optional_param('enddatepicker', '', PARAM_MULTILANG);
$starttimepicker = optional_param('starttimepicker', '', PARAM_MULTILANG);
$endtimepicker = optional_param('endtimepicker', '', PARAM_MULTILANG);

$site = get_site();
$strcommunication = get_string("communication");
$userroleprocess = get_string("userroleedit");
$title = "$site->shortname: $strcommunication - " . get_string('scheduling');
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
if (!empty($scheduleid)) {
    $PAGE->navbar->add(ucwords(strtolower('Edit Scheduling')), '');
} else {
    $PAGE->navbar->add(ucwords(strtolower(get_string('addnewschedule'))), '');
}
$PAGE->navbar->add(ucwords(strtolower(get_string('previewmessage'))), '');

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

$createdby = '2';
if ($recipienttype == get_string('individual')) {
    $utype = '1';
} else {
    $utype = '2';
}

if (!empty($startdatepicker)) {
    $std = $startdatepicker;
} else {
    $std = 0;
}
if (!empty($enddatepicker)) {
    $ed = $enddatepicker;
} else {
    $ed = 0;
}
if (!empty($starttimepicker)) {
    $stt = $starttimepicker;
} else {
    $stt = 0;
}
if (!empty($endtimepicker)) {
    $et = $endtimepicker;
} else {
    $et = 0;
}

switch ($scheduletime) {
    case 'daily':
        $schtime = 0;
        schedulingdata($communicationid, $utype, $scheduletime, $schtime, $std, $ed, $stt, $et, $createdby, $scheduleid);
        break;
    case 'scheduleweekly':
        $schtime = $scheduleweekly;
        schedulingdata($communicationid, $utype, $scheduletime, $schtime, $std, $ed, $stt, $et, $createdby, $scheduleid);
        break;
    case 'schedulemonthly':
        $schtime = $schedulemonthly;
        schedulingdata($communicationid, $utype, $scheduletime, $schtime, $std, $ed, $stt, $et, $createdby, $scheduleid);
        break;
    case 'specificdate':
        $schtime = $specificdate;
        schedulingdata($communicationid, $utype, $scheduletime, $schtime, $std, $ed, $stt, $et, $createdby, $scheduleid);
        break;
}

if (empty($scheduleid)) {
    $scheduleid = getscheduleid($communicationid)->id;
}

// Preview Page Form Here!!!
$sql = "Select id From {communicationmessage_log} Where scheduleid='" . $scheduleid . "'";
$messagelog_id = $DB->get_record_sql($sql)->id;

$id = optional_param('scheduleid', '', PARAM_INT);       // course id
$returnto = optional_param('returnto', 0, PARAM_ALPHANUM); // generic navigation return page switch

$sigs = $DB->get_records('block_quickmail_signatures', array('userid' => $USER->id), 'default_flag DESC');
// count message with scheduleid
$countmessagedata = $DB->count_records('communicationmessage_log', array('scheduleid' => $scheduleid));
// basic access control checks
if (!empty($id)) { // editing scheduleid
    if ($id == SITEID) {
        // don't allow editing of  'site course' using this from
        print_error('cannoteditsiteform');
    }
    if (!empty($countmessagedata)) {
        $message_logdata = $DB->get_record('communicationmessage_log', array('scheduleid' => $id), '*', MUST_EXIST);
        require_login($userrole_data);
    }
    $PAGE->url->param('id', $id);
} else {
    require_login();
    //print_error('needcoursecategroyid');
}

$editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'maxbytes' => $CFG->maxbytes, 'trusttext' => false, 'noclean' => true);
if (!empty($message_logdata)) {
    $message_logdata = file_prepare_standard_editor($message_logdata, 'message', $editoroptions, 'communicationmessage_log', 'message', 0);
} else {
    $message_logdata = file_prepare_standard_editor($message_logdata, 'message', $editoroptions, null, 'communicationmessage_log', 'message', null);
}

$mform = new simplehtml_form(null, array('editoroptions' => $editoroptions,
    'returnto' => $returnto,
    'selected' => $selected,
    'users' => $users,
    'comid' => $comid,
    'scheduleid' => $scheduleid,
    'recipientemail' => $message_logdata,
    'sigs' => array_map(function($sig) {
                return $sig->title;
            }, $sigs)
        ));

$warnings = array();
if ($email = data_submitted()) {
    if (isset($email->cancel)) {
        ?>
        <script> window.opener.location.reload(true);</script>
        <?php

        close_window();
        // redirect(new moodle_url('/organization/userrole/userrole_assign.php?id=' . $email->roleid . '&name_radio1=5&tab=' . get_string('assigned')));
    }
} elseif (!empty($scheduleid)) {
    $email = $DB->get_record('communicationmessage_log', array('scheduleid' => $scheduleid));
    $email->message = array(
        'text' => $email->message,
        'format' => $email->format
    );
}

$countrecords = $DB->count_records('communication_schedulinguser', array('communicationid' => $communicationid, 'scheduleid' => $scheduleid));
$users = array();
$selected = array();
if (!empty($email->mailto)) {
    foreach(explode(',', $email->mailto) as $id) {
        $selected[$id] = $users[$id];
        unset($users[$id]);
    }
}

$submitted = (isset($email->send) or isset($email->save));
if ($submitted) {
    $no = '1';
    foreach (selected_recipientformail($scheduleid) as $recipient) {
        $b = $no++;
        $a.= $recipient->userid;
        if ($b < $countrecords) {
            $a.= ',';
        }
    }

    // Submitted data
    $email->scheduleid = $scheduleid;
    $email->courseid = '32';
    // $email->mailto = '2' . $email->receipt;
    $email->userid = '2';               // default sender is SA
    $email->subject = $email->subject;
    $email->time = time();
    $email->attachment = attachment_names($email->attachments);

    // Save roles here // if save button
    if (isset($email->save)) {
        if (!empty($countmessagedata)) {
            if ($editoroptions) {
                $email->id = $messagelog_id;
                $email->format = 1;
                $email->action = 1; // save
                $email->mailto = $a;
                $email = file_postupdate_standard_editor($email, 'message', $editoroptions, 'communicationmessage_log', 'message', 0);
            }
            $id = $DB->update_record('communicationmessage_log', $email);
        } else {
            // Store email; id is needed for file storage
            $email->format = 1;
            $email->action = 1; // save
            $email->mailto = $a;
            $email = file_postupdate_standard_editor($email, 'message', $editoroptions, 'communicationmessage_log', 'message', 0);
            $id = $DB->insert_record('communicationmessage_log', $email);
        }
        // redirect(new moodle_url('/organization/orgview.php?formtype=' . get_string('communication').'&imagebutton=Schedule&communicationid=3'));
    }

    // Send email to user
    if (isset($email->send)) {
        if (!empty($countmessagedata)) {
            if ($editoroptions) {
                $email->id = $messagelog_id;
                $email->format = 1;
                $email->action = 2; // send
                $email->mailto = $a;
                $email = file_postupdate_standard_editor($email, 'message', $editoroptions, 'communicationmessage_log', 'message', 0);
            }
            $id = $DB->update_record('communicationmessage_log', $email);
        } else {
            // Store email; id is needed for file storage
            $email->format = 1;
            $email->action = 2; // send
            $email->mailto = $a;
            $email = file_prepare_standard_editor($email, 'message', $editoroptions, 'communicationmessage_log', 'message', 0);
            $id = $DB->insert_record('communicationmessage_log', $email);
        }

        list($zipname, $zip, $actual_zip) = process_attachments($context, $email, $id);

        if (!empty($sigs) and $email->sigid > -1) {
            $email->message .= $sigs[$email->sigid]->signature;
        }
        /*foreach (selected_recipientformail($id) as $recipient) {
            print_r($recipient->userid);
            // $success = email_to_user($recipient->userid, $USER, $email->subject, strip_tags($email->message), $email->message, $zip, $zipname);
            // manual_sendingmail($recipient);
        }*/
        
        foreach (explode(',', $email->mailto) as $userid) {
            print_r($userid);
            manual_sendingmail($userid);
            $success = email_to_user($userid, $USER, $email->subject,
                strip_tags($email->message), $email->message, $zip, $zipname);

            if(!$success) {
                $warnings[] = get_string("no_email", 'block_quickmail', $userid);
            }
        }
        
        if ($email->receipt) {
            email_to_user($USER, $USER, $email->subject, 
                strip_tags($email->message), $email->message, $zip, $zipname);
        }       
        
        if (!empty($zip)) {
            unlink($actual_zip);
        }
        // redirect(new moodle_url('/organization/userrole/userrole_assign.php?id=' . $email->roleid . '&name_radio1=5&tab=' . get_string('assigned')));
    }
    // print_r($email->mailto);
    // redirect to homepage
    echo "<script> window.opener.location.reload(true); </script>";
    close_window();
}

$mform->set_data($email);

// PREVIEW MESSAGE
$fieldset1 = html_writer::start_tag('fieldset', array('id' => 'group', 'class' => 'clearfix_group'));
$fieldset1 .= html_writer::start_tag('legend', array('class' => 'ftoggler'));
$fieldset1 .= get_string('previewmessage');
$fieldset1 .= html_writer::end_tag('legend');
print_r($fieldset1);
print_r('<br/>');
$mform->display();

print_r(html_writer::end_tag('fieldset'));

echo $OUTPUT->footer();
