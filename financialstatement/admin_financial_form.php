<?php
	require_once('../config.php');
	require_once('admin_financiallib.php');
	require_once('lib.php');
	
	$id         = optional_param('id', 0, PARAM_INT);       // course id
	// $categoryid = optional_param('category', 0, PARAM_INT); // course category - can be changed in edit form
	$returnto = optional_param('returnto', 0, PARAM_ALPHANUM); // generic navigation return page switch

	$PAGE->set_pagelayout('buy_a_cifa');	

// basic access control checks
if ($id) { // editing course
/*     if ($id == SITEID){
        // don't allow editing of  'site course' using this from
        print_error('cannoteditsiteform');
    } */

    $erules = $DB->get_record('financial_statement', array('id'=>$id), '*', MUST_EXIST);
    require_login($erules);
    require_capability('moodle/course:update', $erules); 
    $PAGE->url->param('id',$id);

} else {
    require_login();
    //print_error('needcoursecategroyid');
}
	
	$editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'maxbytes'=>$CFG->maxbytes, 'trusttext'=>false, 'noclean'=>true);
	if (!empty($erules)) {
		$erules = file_prepare_standard_editor($erules, 'summary', $editoroptions, 'financial_statement', 'summary', 0);
		$erules = file_prepare_standard_editor($erules, 'financialsummary', $editoroptions, 'financial_statement', 'financialsummary', 0);
	}else{
		$erules = file_prepare_standard_editor($erules, 'summary', $editoroptions, null, 'financial_statement', 'summary', null);
		$erules = file_prepare_standard_editor($erules, 'financialsummary', $editoroptions, null, 'financial_statement', 'financialsummary', null);
	}
	
	$mform_simple = new simplehtml_form(null, array('erules'=>$erules, 'editoroptions'=>$editoroptions, 'returnto'=>$returnto));
	
	// action here
	if ($mform_simple->is_cancelled()) {
		$url = new moodle_url($CFG->wwwroot);
		redirect($url);

	} else if ($data = $mform_simple->get_data()) {
	
		if (empty($erules->id)) {
			// In creating the course
			$erules = create_financial($data, $editoroptions);
		}else{	
			// Save any changes to the files used in the editor
			update_financial($data, $editoroptions);
			
		}
		$url = new moodle_url($CFG->wwwroot. '/financialstatement/view_financial.php?id='.$id);
		// $url = new moodle_url($CFG->wwwroot);
		redirect($url);			
	}	
	// Print the form

	$site = get_site();

	$streditfinancialstatement = get_string("editfinancialstatement");
	$PAGE->navbar->add($streditfinancialstatement , new moodle_url('/financialstatement/admin_financial_form.php?id=1'));
	$title = "$site->shortname: $streditfinancialstatement";
	$fullname = $site->fullname;
	
	$PAGE->set_title($title);
	$PAGE->set_heading($fullname);

	echo $OUTPUT->header();
	echo $OUTPUT->heading($streditfinancialstatement);	
	
	$mform_simple->display();
	
	echo $OUTPUT->footer();
?>