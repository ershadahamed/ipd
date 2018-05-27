<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/formslib.php');
require_once($CFG->libdir . '/completionlib.php');

class simplehtml_form extends moodleform {

    function definition() {
        // global $USER, $CFG, $DB;

        $mform = & $this->_form; // Don't forget the underscore! 

        $recipientemail = $this->_customdata['recipientemail']; // this contains the data of this form
        $editoroptions = $this->_customdata['editoroptions'];
        $returnto = $this->_customdata['returnto'];
        $scheduleid = $this->_customdata['scheduleid'];
        $comid= $this->_customdata['communicationid'];

        // $mform->addElement('header', 'general', get_string('previewmessage'));

        $mform->addElement('hidden', 'returnto', null);
        $mform->setType('returnto', PARAM_ALPHANUM);
        $mform->setConstant('returnto', $returnto);

        $mform->addElement('filemanager', 'attachments', get_string('attachments'));	
        
        $mform->addElement('text', 'subject', get_string('subject'),'style="width:330px; height: 1.8em;"');
        $mform->setType('subject', PARAM_TEXT);
        $mform->addRule('subject', null, 'required');

        $mform->addElement('editor', 'message_editor', get_string('message'), null, $editoroptions);  
        $mform->setType('message_editor', PARAM_RAW);
        
        $options = $this->_customdata['sigs'] + array(-1 => 'No '. get_string('signature'));
        $mform->addElement('select', 'sigid', get_string('signature'), $options);        
        $radio = array(
            $mform->createElement('radio', 'receipt', '', get_string('yes'), 1),
            $mform->createElement('radio', 'receipt', '', get_string('no'), 0)
        );

        $mform->addGroup($radio, 'receipt_action', get_string('receiveacopy'), array(' '), false);

        $buttons = array();
        $buttons[] =& $mform->createElement('submit', 'send', 'Send');
        // $buttons[] =& $mform->createElement('submit', 'edit', 'Edit');
        $buttons[] =& $mform->createElement('submit', 'save', 'Save', 'id="id_defaultbutton"');
        $buttons[] =& $mform->createElement('submit', 'cancel', 'Cancel');
        $mform->addGroup($buttons, 'buttons', '', array(' '), false);        

//--------------------------------------------------------------------------------
        // $this->add_action_buttons();
//--------------------------------------------------------------------------------
        $mform->addElement('hidden', 'communicationid', $comid);
        $mform->setType('communicationid', PARAM_INT);        
        $mform->addElement('hidden', 'scheduleid', $scheduleid);
        $mform->setType('scheduleid', PARAM_INT);
        $mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);

/// finally set the current form data
//--------------------------------------------------------------------------------
        $this->set_data($recipientemail); // retrieve back data from DB
        // Add elements to your form
    }

// Close the function
}
