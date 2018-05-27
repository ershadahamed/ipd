<?php
/*****
create_erules
******/
function create_financial($data, $editoroptions = NULL) {
    global $CFG, $DB;

    $data->timecreated  = time();
    $data->timemodified = $data->timecreated;

    if ($editoroptions) {
        // summary text is updated later, we need context to store the files first
        $data->summary = '';
        $data->summary_format = FORMAT_HTML;
		
		$data->financialsummary = '';
        $data->financial_format = FORMAT_HTML;		
    }

    $financialid = $DB->insert_record('financial_statement', $data);

    if ($editoroptions) {
        // Save the files used in the summary editor and store
        $data = file_postupdate_standard_editor($data, 'summary', $editoroptions, 'financial_statement', 'summary', 0);
        $data = file_postupdate_standard_editor($data, 'financialsummary', $editoroptions, 'financial_statement', 'financialsummary', 0);
		
        $DB->set_field('financial_statement', 'summary', $data->summary, array('id'=>$financialid));
        $DB->set_field('financial_statement', 'summaryformat', $data->summary_format, array('id'=>$financialid));
		
        $DB->set_field('financial_statement', 'financialsummary', $data->financialsummary, array('id'=>$financialid));
        $DB->set_field('financial_statement', 'financialformat', $data->financial_format, array('id'=>$financialid));		
    }

    $erules = $DB->get_record('financial_statement', array('id'=>$financialid));
	
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
function update_financial($data, $editoroptions = NULL) {
    global $CFG, $DB;

    $data->timemodified = time();

    if ($editoroptions) {
        $data = file_postupdate_standard_editor($data, 'summary', $editoroptions, 'examrules', 'summary', 0);
        $data = file_postupdate_standard_editor($data, 'financialsummary', $editoroptions, 'financial_statement', 'financialsummary', 0);
    }	
	
    // Update with the new data
    $DB->update_record('financial_statement', $data);

    $erules = $DB->get_record('financial_statement', array('id'=>$data->id));
}

// create_estatement
?>