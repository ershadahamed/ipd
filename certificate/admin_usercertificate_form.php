<?php
	require_once('../config.php');
	require_once('admin_usercertificatelib.php');
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

    $erules = $DB->get_record('estatement', array('id'=>$id), '*', MUST_EXIST);
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
		$erules = file_prepare_standard_editor($erules, 'estatementsummary', $editoroptions, 'estatement', 'estatementsummary', 0);
	}else{
		$erules = file_prepare_standard_editor($erules, 'summary', $editoroptions, null, 'examrules', 'summary', null);
		$erules = file_prepare_standard_editor($erules, 'estatementsummary', $editoroptions, null, 'estatement', 'estatementsummary', null);
	}
	
	$mform_simple = new simplehtml_form(null, array('erules'=>$erules, 'editoroptions'=>$editoroptions, 'returnto'=>$returnto));
	
	// action here
	if ($mform_simple->is_cancelled()) {
		$url = new moodle_url($CFG->wwwroot);
		redirect($url);

	} else if ($data = $mform_simple->get_data()) {
	
		if (empty($erules->id)) {
			// In creating the course
			$erules = create_estatement($data, $editoroptions);
		}else{	
			// Save any changes to the files used in the editor
			update_estatement($data, $editoroptions);
			
		}
		$url = new moodle_url($CFG->wwwroot. '/certificate/view_usercertificate.php?id='.$id);
		// $url = new moodle_url($CFG->wwwroot);
		redirect($url);			
	}	
	// Print the form

	$site = get_site();

	$streditusercertificate = get_string("editusercertificate");
	$PAGE->navbar->add($streditusercertificate , new moodle_url('/certificate/admin_usercertificate_form.php?id=3'));
	$title = "$site->shortname: $streditusercertificate";
	$fullname = $site->fullname;
	
	$PAGE->set_title($title);
	$PAGE->set_heading($fullname);

	echo $OUTPUT->header();
	echo $OUTPUT->heading($streditusercertificate);	
	
	$mform_simple->display();
	
	echo $OUTPUT->footer();
?>