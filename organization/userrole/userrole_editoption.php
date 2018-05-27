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
require_once('userrole_editoptionform.php');

$id = optional_param('roleid', '', PARAM_INT);       // course id
$returnto = optional_param('returnto', 0, PARAM_ALPHANUM); // generic navigation return page switch

/* if ($id) { // editing course
  if ($id == SITEID) {
  // don't allow editing of  'site course' using this from
  print_error('cannoteditsiteform');
  }

  $erules = $DB->get_record('estatement', array('id' => $id), '*', MUST_EXIST);
  require_login($erules);
  require_capability('moodle/course:update', $erules);
  $PAGE->url->param('id', $id);
  } else {
  require_login();
  //print_error('needcoursecategroyid');
  } */

require_login();

$userroledata = $DB->get_record('role', array('id' => $id), '*', MUST_EXIST);
require_login($userrole_data);

$editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'maxbytes' => $CFG->maxbytes, 'trusttext' => false, 'noclean' => true);
if (!empty($userroledata)) {
    $userroledata = file_prepare_standard_editor($userroledata, 'description', $editoroptions, 'role', 'description', 0);
} else {
    $userroledata = file_prepare_standard_editor($userroledata, 'description', $editoroptions, null, 'role', 'description', null);
}
$mform = new userrole_editform(null, array('editoroptions' => $editoroptions, 'returnto' => $returnto, 'roleid' => $id, 'role' => $userroledata));

$warnings = array();
if ($email = data_submitted()) {
    if (isset($email->cancel)) {
        close_window();
    }
}

$submitted = (isset($email->save) or isset($email->assign));
if ($submitted) {
    // Save roles here // if save button
    if (isset($email->save)) {
        
        // Submitted data
        // role title
        // role description
        $data = new stdClass;
        $data->id = $email->roleid;        
        if ($editoroptions) {
            $data = file_postupdate_standard_editor($email, 'description', $editoroptions, 'role', 'description', 0);
        }
        // Update with the new data
        $DB->update_record('role', $data);
        ?>
        <script>
        window.opener.location.reload(true);
        </script>
        <?php
        close_window();
        // redirect(new moodle_url('/organization/orgview.php?formtype=' . get_string('userrole')));
    }

    // Assigning user to role process
    if (isset($email->assign)) {
        redirect(new moodle_url('/organization/userrole/userrole_assign.php?id=' . $email->roleid . '&name_radio1=5&tab=' . get_string('assigned')));
    }
}

$mform->set_data($email);

// Print the form
$site = get_site();
$streditexamrules = get_string("userrole");
$userroleprocess = get_string("userroleedit");
$title = "$site->shortname: $streditexamrules";
$fullname = $site->fullname;

$PAGE->set_url('/');
$PAGE->set_title($title);
$PAGE->set_heading($fullname);
$PAGE->set_pagelayout('buy_a_cifa');
$PAGE->navbar->add($streditexamrules, '');
$PAGE->navbar->add($userroleprocess, '');

echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();

