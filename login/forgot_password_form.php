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

class login_forgot_password_form extends moodleform {

    function definition() {
        $mform    = $this->_form;

        $mform->addElement('header', '', get_string('searchby'), '');

        /* $mform->addElement('text', 'username', get_string('candidateid'), 'onKeyUp="javascript:this.value=this.value.toTitleCase()"');
        $mform->setType('username', PARAM_RAW);
		$mform->addElement('static', 'description', "OR"); */
		
		$candidateidgroup=array();
		$candidateidgroup[] =& $mform->createElement('text', 'username', get_string('candidateid'), 'size="40", onkeydown="f(this)", onkeyup="f(this)", onblur="f(this)", onclick="f(this)"');
		$candidateidgroup[] =& $mform->createElement('static', 'availablefromenabled', '', 'OR');
		$mform->addGroup($candidateidgroup, 'candidateidgroup', get_string('candidateid'), ' ', false);		
		
		$emailgroup=array();
		$emailgroup[] =& $mform->createElement('text', 'email', '', 'size="40"');
		$emailgroup[] =& $mform->createElement('static', 'availablefromenabled', '', 'AND');
		$mform->addGroup($emailgroup, 'emailgroup', get_string('email'), ' ', false);			
		
        //$submitlabel = get_string('search');
        //$mform->addElement('submit', 'submitbuttonusername', $submitlabel);

        //$mform->addElement('header', '', get_string('searchbyemail'), '');

        /* $mform->addElement('text', 'email', get_string('email'));
        $mform->setType('email', PARAM_RAW);
		$mform->addElement('static', 'description', "OR"); */		
		
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
			$squestionlist['10'] = get_string('squestion10');	
			$squestionlist['11'] = get_string('squestion11');
			/* $mform->addElement('select', 'securityquestionid', $squestiontitle, $squestionlist);
			if (!empty($USER->securityquestionid)) {
				$mform->setDefault('securityquestionid', $USER->securityquestionid);
			} */
			
			$info='<table width="48%" style="padding:0px; margin:0px;float:right;"><tr><td><em>When you created your CIFAOnline Account, you created a security question. Answer the question correctly to access your account</em></td></tr></table>';
			$securityquestiongroup=array();
			$securityquestiongroup[] =& $mform->createElement('select', 'securityquestionid', '', $squestionlist);
			$securityquestiongroup[] =& $mform->createElement('static', 'description', '', '&nbsp;'.$info);
			$mform->addGroup($securityquestiongroup, 'securityquestiongroup', $squestiontitle, ' ', false);
			$mform->addRule('securityquestiongroup', $strrequired, 'required', null, 'client');
			
			//list of security question// End
			$mform->addElement('text', 'sqanswer',  get_string('sqyouranswer'),  'maxlength="100" size="40"'); //sq answer..
			$mform->setType('sqanswer', PARAM_NOTAGS);	
			$mform->disabledIf('sqanswer', 'securityquestionid', 'eq', '');	
			$mform->addRule('sqanswer', $strrequired, 'required', null, 'client');
			if (!empty($USER->sqanswer)) {
				$mform->setDefault('sqanswer', $USER->sqanswer);
			}		
		//ended by arizan 28082012	

		//text below reset password
		//$mform->addElement('html', '<br/><h6>If you still have trouble logging in, please complete the Contact Us form below</h6>');
		
		
		
		//$mform->addElement('static','static',  'Please');
		
        //$submitlabel = get_string('search');
		$submitlabel = get_string('submit');
        $mform->addElement('submit', 'submitbuttonemail', $submitlabel);
    }

    function validation($data, $files) {
        global $CFG, $DB;

        $errors = parent::validation($data, $files);

        if ((!empty($data['username']) and !empty($data['email']) and !empty($data['securityquestionid'])) or (empty($data['username']) and empty($data['email']) and empty($data['securityquestionid']))) {
			/* $errors['username'] = get_string('usernameoremail');
            $errors['email']    = get_string('usernameoremail'); */
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
