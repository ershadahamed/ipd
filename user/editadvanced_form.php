<?php

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot . '/lib/formslib.php');

class user_editadvanced_form extends moodleform {

    // Define the form
    function definition() {
        global $USER, $CFG, $COURSE;

        $mform = & $this->_form;

        if (is_array($this->_customdata) && array_key_exists('editoroptions', $this->_customdata)) {
            $editoroptions = $this->_customdata['editoroptions'];
        } else {
            $editoroptions = null;
        }

        //Accessibility: "Required" is bad legend text.
        $strgeneral = get_string('general');
        $strrequired = get_string('required');
        $strlogin = get_string('strlogin');

        /// Add some extra hidden fields
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'course', $COURSE->id);
        $mform->setType('course', PARAM_INT);

        /// Print the required moodle fields first
        $mform->addElement('header', 'moodle', $strlogin);

        //added by arizan abdullah 20121004//candidate ID
        $selectusers = mysql_query("SELECT * FROM {$CFG->prefix}user WHERE suspended='0' ORDER BY id DESC");
        $usercount = mysql_num_rows($selectusers);
        $userrec = mysql_fetch_array($selectusers);
        $tid = $userrec['id'] + '1';
        $month = date('m');
        $year = date('y');
        //if($month < '10'){ $m='00';}else{ $m='0';}

        if ($userrec['id'] <= '9') {
            $a = '00';
        } elseif ($userrec['id'] >= '10' && $userrec['id'] <= '99') {
            $a = '0';
        } else {
            $a = '';
        } 
        $candidatesI = $year . '' . $a . '' . $tid;
        //Ended by arizan abdullah 20121004////

        $mform->addElement('text', 'username', get_string('username'), 'value="' . strtolower($candidatesI) . '" size="20" readonly');
        //$mform->addElement('static', '', get_string('username'), $candidatesI);
        $mform->addElement('hidden', 'username', $candidatesI);
        $mform->addRule('username', $strrequired, 'required', null, 'client');
        $mform->setType('username', PARAM_RAW);

        $auths = get_plugin_list('auth');
        $auth_options = array();
        foreach ($auths as $auth => $unused) {
            $auth_options[$auth] = get_string('pluginname', "auth_{$auth}");
        }
        // $mform->addElement('select', 'auth', get_string('chooseauthmethod','auth'), $auth_options);
        $mform->addElement('hidden', 'auth', $auth_options);
        $mform->addHelpButton('auth', 'chooseauthmethod', 'auth');

        if (!empty($CFG->passwordpolicy)) {
            $mform->addElement('static', 'passwordpolicyinfo', '', print_password_policy());
        }
        $mform->addElement('passwordunmask', 'newpassword', get_string('newpassword'));
        $mform->addHelpButton('newpassword', 'newpassword');
        $mform->setType('newpassword', PARAM_RAW);

        $mform->addElement('advcheckbox', 'preference_auth_forcepasswordchange', get_string('forcepasswordchange'));
        $mform->addHelpButton('preference_auth_forcepasswordchange', 'forcepasswordchange');
        $mform->setDefault('preference_auth_forcepasswordchange', 1);

        //list of user types//add by arizan
        $usertypetitle = get_string('usertype');
        $usertypelist = array();
        $usertypelist[''] = 'Select a user type..';
        $qryU = "SELECT * FROM mdl_cifarole ORDER BY id ASC";
        $sqlU = mysql_query($qryU);

        while ($rs = mysql_fetch_array($sqlU)) {
            if ($rs['id'] != '1' && $rs['id'] != '2' && $rs['id'] != '7' && $rs['id'] != '8' && $rs['id'] != '9' && $rs['id'] != '14' && $rs['id'] != '15') {
                $id = $rs['id'];
                $typesuser = $rs['name'];

                $categoryusers = ucwords(strtolower($rs['name']));
                $usertypelist[$typesuser] = $categoryusers;
            }
        }
        $mform->addElement('select', 'usertype', $usertypetitle, $usertypelist);
        $mform->addRule('usertype', $strrequired, 'required', null, 'client');
        $mform->setDefault('usertype', 'Active candidate');
        if (!empty($CFG->usertype)) {
            $mform->setDefault('usertype', $CFG->usertype);
        }
        //end list user types//add by arizan

        $orgtypetitle = get_string('orgtype');
        $orgtypelist = array();
        $orgtypelist[''] = 'Select one..';
        $qryOrg = "SELECT * FROM {$CFG->prefix}organization_type ORDER BY id ASC";
        $sqlOrg = mysql_query($qryOrg);

        while ($rs = mysql_fetch_array($sqlOrg)) {
            $id = $rs['id'];
            $typesorg = $rs['name'];
            $categoryorg = ucwords(strtolower($rs['name']));
            $orgtypelist[$id] = $categoryorg;
        }
        $mform->addElement('select', 'orgtype', $orgtypetitle, $orgtypelist);
        if (!empty($CFG->orgtype)) {
            $mform->setDefault('orgtype', $CFG->orgtype);
        }

        //trainee id for candidate
        //$selectusers=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE deleted='0' AND confirmed='1' AND suspended='0' ORDER BY id DESC");
        $selectusers = mysql_query("SELECT * FROM {$CFG->prefix}user WHERE deleted='0' AND suspended='0' ORDER BY id DESC");
        $usercount = mysql_num_rows($selectusers);
        $userrec = mysql_fetch_array($selectusers);
        $tid = $userrec['id'] + '1';
        $month = date('m');
        $year = date('y');
        if ($userrec['id'] <= '9') {
            $a = '00';
        } elseif ($userrec['id'] >= '10' && $userrec['id'] <= '99') {
            $a = '0';
        } else {
            $a = '';
        }
        $candidatesI = $year . '' . $a . '' . $tid;
        $mform->addElement('hidden', 'traineeid', '' . $candidatesI . '');
        $mform->setType('traineeid', PARAM_NOTAGS);

        //if ($USER->id == '2') {
        //$mform->addElement('header', 'user', get_string('user_picture'));
        //}
        /// shared fields
        useredit_shared_definition($mform, $editoroptions);

        /// Next the customisable profile fields
        profile_definition($mform);

        $this->add_action_buttons(false, get_string('updatemyprofile'));
        //$this->add_action_buttons(false, get_string('addnewuser'));
    }

    function definition_after_data() {
        global $USER, $CFG, $DB, $OUTPUT;

        $mform = & $this->_form;
        if ($userid = $mform->getElementValue('id')) {
            $user = $DB->get_record('user', array('id' => $userid));
        } else {
            $user = false;
        }

        // if language does not exist, use site default lang
        if ($langsel = $mform->getElementValue('lang')) {
            $lang = reset($langsel);
            // check lang exists
            if (!get_string_manager()->translation_exists($lang, false)) {
                $lang_el = & $mform->getElement('lang');
                $lang_el->setValue($CFG->lang);
            }
        }

        // user can not change own auth method
        if ($userid == $USER->id) {
            $mform->hardFreeze('auth');
            $mform->hardFreeze('preference_auth_forcepasswordchange');
        }

        // admin must choose some password and supply correct email
        if (!empty($USER->newadminuser)) {
            $mform->addRule('newpassword', get_string('required'), 'required', null, 'client');
        }

        // require password for new users
        if ($userid == -1) {
            $mform->addRule('newpassword', get_string('required'), 'required', null, 'client');
        }

        // print picture
        if (!empty($CFG->gdversion) and empty($USER->newadminuser)) {
            $image_el = & $mform->getElement('currentpicture');
            if ($user and $user->picture) {
                $image_el->setValue($OUTPUT->user_picture($user, array('courseid' => SITEID)));
            } else {
                $image_el->setValue(get_string('none'));
            }
        }

        /// Next the customisable profile fields
        profile_definition_after_data($mform, $userid);
    }

    function validation($usernew, $files) {
        global $CFG, $DB;

        $usernew = (object) $usernew;
        $usernew->username = trim($usernew->username);

        $user = $DB->get_record('user', array('id' => $usernew->id));
        $err = array();

        if (!empty($usernew->newpassword)) {
            $errmsg = ''; //prevent eclipse warning
            if (!check_password_policy($usernew->newpassword, $errmsg)) {
                $err['newpassword'] = $errmsg;
            }
        }

        if (empty($usernew->username)) {
            //might be only whitespace
            $err['username'] = get_string('required');
        } else if (!$user or $user->username !== $usernew->username) {
            //check new username does not exist
            if ($DB->record_exists('user', array('username' => $usernew->username, 'mnethostid' => $CFG->mnet_localhost_id))) {
                $err['username'] = get_string('usernameexists');
            }
            //check allowed characters
            if ($usernew->username !== moodle_strtolower($usernew->username)) {
                $err['username'] = get_string('usernamelowercase');
            } else {
                if ($usernew->username !== clean_param($usernew->username, PARAM_USERNAME)) {
                    $err['username'] = get_string('invalidusername');
                }
            }
        }

        if (!$user or $user->email !== $usernew->email) {
            if (!validate_email($usernew->email)) {
                $err['email'] = get_string('invalidemail');
            } else if ($DB->record_exists('user', array('email' => $usernew->email, 'mnethostid' => $CFG->mnet_localhost_id))) {
                $err['email'] = get_string('emailexists');
            }
        }

        /// Next the customisable profile fields
        $err += profile_validation($usernew, $files);

        if (count($err) == 0) {
            return true;
        } else {
            return $err;
        }
    }

}
