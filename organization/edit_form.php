<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Mohd Arizan Bin Abdullah - 19 March 2015
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/formslib.php');
require_once($CFG->libdir . '/completionlib.php');

class simplehtml_form extends moodleform {

    function definition() {
        global $USER, $CFG, $DB;
        $id = optional_param('id', 0, PARAM_INT);
        $cid = optional_param('cid', 0, PARAM_INT);
        $mform = & $this->_form; // Don't forget the underscore! 

        $sorganization = $this->_customdata['organization_config']; // this contains the data of this form
        $editoroptions = $this->_customdata['editoroptions'];
        $returnto = $this->_customdata['returnto'];

        $mform->addElement('header', 'general', get_string('organizationdb'));

        $mform->addElement('hidden', 'returnto', null);
        $mform->setType('returnto', PARAM_ALPHANUM);
        $mform->setConstant('returnto', $returnto);

        $organization = array();
        $organization['1'] = 'Organization Size';
        $organization['2'] = 'Organization Type';
        $organization['3'] = 'Organization Industry';
        $mform->addElement('select', 'organizationtitle', get_string('insertinto'), $organization);
        $mform->addHelpButton('organizationtitle', 'organizationtitle');
        $mform->setDefault('organizationtitle', $CFG->organizationtitle);

        // content
        /* $mform->addElement('text', 'organizationcontent', get_string('organizationcontent'), 'maxlength="100"');
          $mform->addHelpButton('organizationcontent', 'organizationcontent');
          $mform->setType('organizationcontent', PARAM_MULTILANG); */

        $mform->addElement('editor', 'summary_editor', get_string('content'), null, $editoroptions);
        $mform->addHelpButton('summary_editor', 'content');
        $mform->addRule('summary_editor', get_string('content') . ' Required', 'required', null, 'client');
        $mform->setType('summary_editor', PARAM_RAW);

        if ($id) {
            $mform->addElement('header', 'general', get_string('view'));
            $c = count_orgtitle($cid);
            
            $themeobjects = listorgtitle_withtitleid($cid);
            $name = array();
            $themes = array();
            // $themes[''] = 'All list';
            foreach ($themeobjects as $key => $theme) {
                $themes[$key] = $theme->summary;
                if($theme->organizationtitle == '1'){ $name = 'Organization Size'; }
                if($theme->organizationtitle == '2'){ $name = 'Organization Type'; }
                if($theme->organizationtitle == '3'){ $name = 'Organization Industry'; }
            }
            $mform->addElement('select', '', $name, $themes);
        }

//--------------------------------------------------------------------------------
        $this->add_action_buttons();
//--------------------------------------------------------------------------------
        $mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);

/// finally set the current form data
//--------------------------------------------------------------------------------
        $this->set_data($sorganization); // retrieve back data from DB
        // Add elements to your form
    }

// Close the function
}
?>