<?php
/*****
create_erules
******/
function create_erules($data, $editoroptions = NULL) {
    global $CFG, $DB;

    $data->timecreated  = time();
    $data->timemodified = $data->timecreated;

    if ($editoroptions) {
        // summary text is updated later, we need context to store the files first
        $data->summary = '';
        $data->summary_format = FORMAT_HTML;
    }

    $examrulesid = $DB->insert_record('examrules', $data);
	//$context = get_context_instance(CONTEXT_COURSE, $examrulesid, MUST_EXIST);

    if ($editoroptions) {
        // Save the files used in the summary editor and store
        $data = file_postupdate_standard_editor($data, 'summary', $editoroptions, 'examrules', 'summary', 0);
        $DB->set_field('examrules', 'summary', $data->summary, array('id'=>$examrulesid));
        $DB->set_field('examrules', 'summaryformat', $data->summary_format, array('id'=>$examrulesid));
    }

    $erules = $DB->get_record('examrules', array('id'=>$examrulesid));
	
    return $erules;
}

/**
 * Update a update_erules.
 *
 * Please note this functions does not verify any access control,
 * the calling code is responsible for all validation (usually it is the form definition).
 *
 * @param object $data  - all the data needed for an entry in the 'course' table
 * @param array $editoroptions course description editor options
 * @return void
 */
function update_erules($data, $editoroptions = NULL) {
    global $CFG, $DB;

    $data->timemodified = time();

    if ($editoroptions) {
        $data = file_postupdate_standard_editor($data, 'summary', $editoroptions, 'examrules', 'summary', 0);
    }	
	
    // Update with the new data
    $DB->update_record('examrules', $data);

    $erules = $DB->get_record('examrules', array('id'=>$data->id));
}

// create_erules
?>