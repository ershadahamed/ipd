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
 * Change password form definition.
 *
 * @package    core
 * @subpackage auth
 * @copyright  2006 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once $CFG->libdir.'/formslib.php';

class login_change_password_form extends moodleform {

    function definition() {
        global $USER, $CFG;

        $mform = $this->_form;

        $mform->addElement('header', '', get_string('changepassword'), '');

        // visible elements
        $mform->addElement('static', 'username', get_string('username'), $USER->username);

        if (!empty($CFG->passwordpolicy)){
            $mform->addElement('static', 'passwordpolicyinfo', '', print_password_policy());
        }
        $mform->addElement('password', 'password', get_string('oldpassword'));
        $mform->addRule('password', get_string('required'), 'required', null, 'client');
        $mform->setType('password', PARAM_RAW);

        $mform->addElement('password', 'newpassword1', get_string('newpassword'));
        $mform->addRule('newpassword1', get_string('required'), 'required', null, 'client');
        $mform->setType('newpassword1', PARAM_RAW);

        $mform->addElement('password', 'newpassword2', get_string('newpassword').' ('.get_String('again').')');
        $mform->addRule('newpassword2', get_string('required'), 'required', null, 'client');
        $mform->setType('newpassword2', PARAM_RAW);

		$mform->addElement('header', '', get_string('squestion'), '');
		
		//added by arizan 28082012
			$squestiontitle = get_string('squestion');
			$squestionlist = array();
			$squestionlist['']='Select one security question..';
			$squestionlist['1'] = get_string('squestion1');
			$squestionlist['2'] = get_string('squestion2');
			$squestionlist['3'] = get_string('squestion3');
			$squestionlist['4'] = get_string('squestion4');
			$squestionlist['5'] = get_string('squestion5');
			$squestionlist['6'] = get_string('squestion6');
			$squestionlist['7'] = get_string('squestion7');
			$squestionlist['8'] = get_string('squestion8');	
			$squestionlist['9'] = get_string('squestion9');	
			$mform->addElement('select', 'securityquestionid', $squestiontitle, $squestionlist);
			$mform->addRule('securityquestionid', $strrequired, 'required', null, 'client');
			if (!empty($USER->securityquestionid)) {
				$mform->setDefault('securityquestionid', $USER->securityquestionid);
			}
			//list of security question// End
			$mform->addElement('text', 'sqanswer',  get_string('sqyouranswer'),  'maxlength="100" size="40"'); //sq answer..
			$mform->addRule('sqanswer', $strrequired, 'required', null, 'client');
			$mform->setType('sqanswer', PARAM_NOTAGS);	
			$mform->disabledIf('sqanswer', 'securityquestionid', 'eq', '');		
			if (!empty($USER->sqanswer)) {
				$mform->setDefault('sqanswer', $USER->sqanswer);
			}			
		//ended by arizan 28082012		
		
		$mform->addElement('header', '', get_string('educationemployment'), '');
		
		//list of highesteducation// 
		$highesteducationtitle = get_string('highesteducation');
		$highesteducationlist = array();
		$highesteducationlist['']='Select one..';
		$highesteducationlist['1'] = get_string('highesteducation1');
		$highesteducationlist['2'] = get_string('highesteducation2');
		$highesteducationlist['3'] = get_string('highesteducation3');
		$highesteducationlist['4'] = get_string('highesteducation4');
		$highesteducationlist['5'] = get_string('highesteducation5');
		$highesteducationlist['6'] = get_string('highesteducation6');
		$highesteducationlist['7'] = get_string('highesteducation7');
		$highesteducationlist['8'] = get_string('highesteducation8');	
		$highesteducationlist['9'] = get_string('highesteducation9');	
		$mform->addElement('select', 'highesteducation', $highesteducationtitle, $highesteducationlist);
		$mform->addRule('highesteducation', $strrequired, 'required', null, 'client');
		if (!empty($USER->highesteducation)) {
			$mform->setDefault('highesteducation', $USER->highesteducation);
		}
		//list of highesteducation// End

		
		$mform->addElement('text', 'currentprofession', get_string('currentprofession'), 'maxlength="100" size="40"');
		$mform->setType('currentprofession', PARAM_NOTAGS);	
		if (!empty($USER->currentprofession)) {
			$mform->setDefault('currentprofession', $USER->currentprofession);
		}		

		$mform->addElement('text', 'jobtitle', get_string('jobtitle'), 'maxlength="100" size="40"');
		$mform->setType('jobtitle', PARAM_NOTAGS);	
		if (!empty($USER->jobtitle)) {
			$mform->setDefault('jobtitle', $USER->jobtitle);
		}		
		
		
        // hidden optional params
        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id', PARAM_INT);

        // buttons
        if (get_user_preferences('auth_forcepasswordchange')) {
            $this->add_action_buttons(false);
        } else {
            $this->add_action_buttons(true);
        }
    }

/// perform extra password change validation
    function validation($data, $files) {
        global $USER;
        $errors = parent::validation($data, $files);

        update_login_count();

        // ignore submitted username
        if (!$user = authenticate_user_login($USER->username, $data['password'])) {
            $errors['password'] = get_string('invalidlogin');
            return $errors;
        }

        reset_login_count();

        if ($data['newpassword1'] <> $data['newpassword2']) {
            $errors['newpassword1'] = get_string('passwordsdiffer');
            $errors['newpassword2'] = get_string('passwordsdiffer');
            return $errors;
        }

        if ($data['password'] == $data['newpassword1']){
            $errors['newpassword1'] = get_string('mustchangepassword');
            $errors['newpassword2'] = get_string('mustchangepassword');
            return $errors;
        }

        $errmsg = '';//prevents eclipse warnings
        if (!check_password_policy($data['newpassword1'], $errmsg)) {
            $errors['newpassword1'] = $errmsg;
            $errors['newpassword2'] = $errmsg;
            return $errors;
        }

        return $errors;
    }
}
