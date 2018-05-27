<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Reset forgotten password form definition.
 *
 * @package    core
 * @subpackage auth
 * @copyright  2006 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once $CFG->libdir.'/formslib.php';

class login_forgot_password_form_contactus extends moodleform {

    function definition() {
        $mform    = $this->_form;

		//contact us
		$mform->addElement('header', '', get_string('contactus'), '');
		
		$mform->addElement('text', 'contactname',  get_string('contactname'),  'maxlength="100" size="40"'); //contact Full name..
		$mform->setType('contactname', PARAM_NOTAGS);		
		$mform->addRule('contactname', $strrequired, 'required', null, 'client');
		if (!empty($USER->contactname)) {
			$mform->setDefault('contactname', $USER->contactname);
		}		
		
		$mform->addElement('date_selector', 'contactdob', get_string('contactdob'));
		$mform->addRule('contactdob', $strrequired, 'required', null, 'client');

		$mform->addElement('text', 'email',  get_string('email'),  'maxlength="100" size="40"'); //contact email
		$mform->setType('email', PARAM_NOTAGS);		
		$mform->addRule('email', $strrequired, 'required', null, 'client');
		
		//added by arizan 28082012
		$mform->addElement('text', 'contactsubject',  get_string('contactsubject'),  'maxlength="200" size="102"'); //contact subject
		$mform->setType('contactsubject', PARAM_NOTAGS);		
		$mform->addRule('contactsubject', $strrequired, 'required', null, 'client');
		if (!empty($USER->contactsubject)) {
			$mform->setDefault('contactsubject', $USER->contactsubject);
		}
		
		//contact us message// End
		$mform->addElement('textarea', 'contactmessage', get_string("messagecontent"), 'wrap="virtual" rows="10" cols="100" width="100%"'); //contact message
		$mform->setType('contactmessage', PARAM_NOTAGS);		
		$mform->addRule('contactmessage', $strrequired, 'required', null, 'client');
		if (!empty($USER->contactmessage)) {
			$mform->setDefault('contactmessage', $USER->contactmessage);
		}		
		//ended by arizan 28082012	
		
		$submitlabel = get_string('submit');
        $mform->addElement('submit', 'submitbuttonemail', $submitlabel);
    }

    function validation($data, $files) {
        global $CFG, $DB;

        $errors = parent::validation($data, $files);

        if ((!empty($data['username']) and !empty($data['email']) and !empty($data['securityquestionid'])) or (empty($data['username']) and empty($data['email']) and empty($data['securityquestionid']))) {
			$errors['candidateidgroup'] = get_string('enterusername');
			$errors['emailgroup'] = get_string('enteremail');
			$errors['securityquestiongroup'] = get_string('entersq');
			$errors['sqanswer'] = get_string('entersqanswer');

        } else if (!empty($data['email'])) {
            if (!validate_email($data['email'])) {
                $errors['email'] = get_string('invalidemail');

            } else if ($DB->count_records('user', array('email'=>$data['email'])) > 1) {
                $errors['email'] = get_string('forgottenduplicate');

            } else {
                if ($user = get_complete_user_data('email', $data['email'])) {
                    if (empty($user->confirmed)) {
                        $errors['email'] = get_string('confirmednot');
                    }
                }
                if (!$user and empty($CFG->protectusernames)) {
                    $errors['email'] = get_string('emailnotfound');
                }
            }

        } else {
            if ($user = get_complete_user_data('username', $data['username'])) {
                if (empty($user->confirmed)) {
                    $errors['email'] = get_string('confirmednot');
                }
            }
            if (!$user and empty($CFG->protectusernames)) {
                $errors['username'] = get_string('usernamenotfound');
            }
        }

        return $errors;
    }

}
