<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/formslib.php');
require_once($CFG->libdir . '/completionlib.php');

class userrole_editform extends moodleform {

    function definition() {
        // global $USER, $CFG, $DB;

        $mform = & $this->_form; // Don't forget the underscore! 

        $userroledata = $this->_customdata['role']; // this contains the data of this form
        $editoroptions = $this->_customdata['editoroptions'];
        $returnto = $this->_customdata['returnto'];
        $roleid = $this->_customdata['roleid'];

        $mform->addElement('header', 'general', get_string('userrole'));

        $mform->addElement('hidden', 'roleid', $roleid);
        
        $mform->addElement('hidden', 'returnto', null);
        $mform->setType('returnto', PARAM_ALPHANUM);
        $mform->setConstant('returnto', $returnto);

        $mform->addElement('text', 'name', get_string('title'), 'style="width:400px; height: 1.7em;"');
        $mform->setType('name', PARAM_TEXT);

        $mform->addElement('editor', 'description_editor', get_string('description'), null, $editoroptions);
        $mform->setType('description_editor', PARAM_RAW);

//--------------------------------------------------------------------------------
        $buttons = array();
        $buttons[] = & $mform->createElement('submit', 'save', 'Save', 'id="id_defaultbutton" style="line-height: 0.8em;"');
        $buttons[] = & $mform->createElement('submit', 'edit', 'Edit', 'id="id_defaultbutton" style="line-height: 0.8em;"');
        $buttons[] = & $mform->createElement('submit', 'assign', 'Assign', 'style="line-height: 0.8em;"');
        $buttons[] = & $mform->createElement('submit', 'cancel', 'Cancel', 'style="line-height: 0.8em;"');

        $mform->addGroup($buttons, 'buttons', '', array(' '), false);
        // $this->add_action_buttons();
//--------------------------------------------------------------------------------
        $mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);

/// finally set the current form data
//--------------------------------------------------------------------------------
        $this->set_data($userroledata); // retrieve back data from DB
        // Add elements to your form
    }

// Close the function
}

?>