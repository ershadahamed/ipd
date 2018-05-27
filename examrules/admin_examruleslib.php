<?php
	defined('MOODLE_INTERNAL') || die;

	require_once($CFG->libdir.'/formslib.php');
	require_once($CFG->libdir.'/completionlib.php');
	
	class simplehtml_form extends moodleform {
	 
	function definition() {
		global $USER, $CFG, $DB;
	 
		$mform =& $this->_form; // Don't forget the underscore! 
		
		$erules        = $this->_customdata['erules']; // this contains the data of this form
        // $category      = $this->_customdata['category'];
        $editoroptions = $this->_customdata['editoroptions'];
        $returnto = $this->_customdata['returnto'];
	 
		$mform->addElement('header','general', get_string('general', 'form'));
		
        $mform->addElement('hidden', 'returnto', null);
        $mform->setType('returnto', PARAM_ALPHANUM);
        $mform->setConstant('returnto', $returnto);		
				
		$mform->addElement('editor','summary_editor', get_string('content'), null, $editoroptions);
        $mform->addHelpButton('summary_editor', 'content');
		$mform->addRule('summary_editor', get_string('content').' Required', 'required', null, 'client');
        $mform->setType('summary_editor', PARAM_RAW);
		
//--------------------------------------------------------------------------------
        $this->add_action_buttons();
//--------------------------------------------------------------------------------
        $mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);

/// finally set the current form data
//--------------------------------------------------------------------------------
        $this->set_data($erules); // retrieve back data from DB

		// Add elements to your form
	}   // Close the function
	} 
?>