<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../config.php');
require_once('edit_form.php');
require_once('lib.php');

global $DB, $OUTPUT, $PAGE;

$id = optional_param('id', 0, PARAM_INT);       // course idorganizationtitle
$returnto = optional_param('returnto', 0, PARAM_ALPHANUM); // generic navigation return page switch

$PAGE->set_pagelayout('buy_a_cifa');
$PAGE->set_url('/organization/edit.php');
// basic access control checks
if ($id) { // editing course
    if ($id == SITEID) {
        // don't allow editing of  'site course' using this from
        print_error('cannoteditsiteform');
    }

    $corganization = $DB->get_record('organization_config', array('id' => $id), '*', MUST_EXIST);
    require_login($corganization);
    //$PAGE->url->param('id', $id);
} else {
    require_login();
    //print_error('needcoursecategroyid');
}

$editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'maxbytes' => $CFG->maxbytes, 'trusttext' => false, 'noclean' => true);
if (!empty($corganization)) {
    $corganization = file_prepare_standard_editor($corganization, 'summary', $editoroptions, 'organization_config', 'summary', 0);
} else {
    $corganization = file_prepare_standard_editor($corganization, 'summary', $editoroptions, null, 'organization_config', 'summary', null);
}

$mform_simple = new simplehtml_form(null, array('organization_config' => $corganization, 'editoroptions' => $editoroptions, 'returnto' => $returnto));

// action here
if ($mform_simple->is_cancelled()) {
    $url = new moodle_url($CFG->wwwroot);
    redirect($url);
} else if ($data = $mform_simple->get_data()) {

    if (empty($corganization->id)) {
        // In creating the course
        $corganization = create_erules($data, $editoroptions);
    } else {
        // Save any changes to the files used in the editor
        update_erules($data, $editoroptions);
    }
    
    $sql="Select id, organizationtitle From {organization_config} Order By id DESC";
    $rs=$DB->get_record_sql($sql);
    
    $url = new moodle_url($CFG->wwwroot . '/organization/edit.php?id=' . $rs->id.'&cid='.$rs->organizationtitle);
    redirect($url);
}
// Print the form

$site = get_site();

$streditexamrules = get_string("organizationdb");
$PAGE->navbar->add($streditexamrules, new moodle_url('/organization/edit.php'));
$title = "$site->shortname: $streditexamrules";
$fullname = $site->fullname;

$PAGE->set_title($title);
$PAGE->set_heading($fullname);

echo $OUTPUT->header();

$mform_simple->display();

echo $OUTPUT->footer();
?>
