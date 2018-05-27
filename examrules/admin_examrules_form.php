<?php
	require_once('../config.php');
	require_once('admin_examruleslib.php');
	require_once('lib.php');
	
	$id         = optional_param('id', 0, PARAM_INT);       // course id
	// $categoryid = optional_param('category', 0, PARAM_INT); // course category - can be changed in edit form
	$returnto = optional_param('returnto', 0, PARAM_ALPHANUM); // generic navigation return page switch

	$PAGE->set_pagelayout('buy_a_cifa');
	// $PAGE->set_url('/course/edit.php');	

// basic access control checks
if ($id) { // editing course
    if ($id == SITEID){
        // don't allow editing of  'site course' using this from
        print_error('cannoteditsiteform');
    }

    $erules = $DB->get_record('examrules', array('id'=>$id), '*', MUST_EXIST);
    require_login($erules);
    require_capability('moodle/course:update', $erules); 
    $PAGE->url->param('id',$id);

} else {
    require_login();
    //print_error('needcoursecategroyid');
}
	
	$editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'maxbytes'=>$CFG->maxbytes, 'trusttext'=>false, 'noclean'=>true);
	if (!empty($erules)) {
		$erules = file_prepare_standard_editor($erules, 'summary', $editoroptions, 'examrules', 'summary', 0);
	}else{
		$erules = file_prepare_standard_editor($erules, 'summary', $editoroptions, null, 'examrules', 'summary', null);
	}
	
	$mform_simple = new simplehtml_form(null, array('erules'=>$erules, 'editoroptions'=>$editoroptions, 'returnto'=>$returnto));
	
	// action here
	if ($mform_simple->is_cancelled()) {
		$url = new moodle_url($CFG->wwwroot);
		redirect($url);

	} else if ($data = $mform_simple->get_data()) {
	
		if (empty($erules->id)) {
			// In creating the course
			$erules = create_erules($data, $editoroptions);
		}else{	
			// Save any changes to the files used in the editor
			update_erules($data, $editoroptions);
			
		}
		$url = new moodle_url($CFG->wwwroot. '/examrules/view_examrules.php?id='.$id);
		// $url = new moodle_url($CFG->wwwroot);
		redirect($url);			
	}	
	// Print the form

	$site = get_site();

	$streditexamrules = get_string("editexamrules");
	$PAGE->navbar->add($streditexamrules , new moodle_url('/examrules/admin_examrules_form.php?id=16'));
	$title = "$site->shortname: $streditexamrules";
	$fullname = $site->fullname;
	
	$PAGE->set_title($title);
	$PAGE->set_heading($fullname);

	echo $OUTPUT->header();
	echo $OUTPUT->heading($streditexamrules);	
	
	$mform_simple->display();
	
	echo $OUTPUT->footer();
?>