<?php
/*****
create_erules
******/
function create_estatement($data, $editoroptions = NULL) {
    global $CFG, $DB;

    $data->timecreated  = time();
    $data->timemodified = $data->timecreated;

    if ($editoroptions) {
        // summary text is updated later, we need context to store the files first
        $data->summary = '';
        $data->summary_format = FORMAT_HTML;
		
		$data->estatementsummary = '';
        $data->estatement_format = FORMAT_HTML;		
    }

    $estatementid = $DB->insert_record('estatement', $data);

    if ($editoroptions) {
        // Save the files used in the summary editor and store
        $data = file_postupdate_standard_editor($data, 'summary', $editoroptions, 'estatement', 'summary', 0);
        $data = file_postupdate_standard_editor($data, 'estatementsummary', $editoroptions, 'estatement', 'estatementsummary', 0);
		
        $DB->set_field('estatement', 'summary', $data->summary, array('id'=>$estatementid));
        $DB->set_field('estatement', 'summaryformat', $data->summary_format, array('id'=>$estatementid));
		
        $DB->set_field('estatement', 'estatementsummary', $data->estatementsummary, array('id'=>$estatementid));
        $DB->set_field('estatement', 'estatementformat', $data->estatement_format, array('id'=>$estatementid));		
    }

    $erules = $DB->get_record('estatement', array('id'=>$estatementid));
	
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
function update_estatement($data, $editoroptions = NULL) {
    global $CFG, $DB;

    $data->timemodified = time();

    if ($editoroptions) {
        $data = file_postupdate_standard_editor($data, 'summary', $editoroptions, 'examrules', 'summary', 0);
        $data = file_postupdate_standard_editor($data, 'estatementsummary', $editoroptions, 'estatement', 'estatementsummary', 0);
    }	
	
    // Update with the new data
    $DB->update_record('estatement', $data);

    $erules = $DB->get_record('estatement', array('id'=>$data->id));
}

// create_estatement
?>