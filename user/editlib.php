<?php

function cancel_email_update($userid) {
    unset_user_preference('newemail', $userid);
    unset_user_preference('newemailkey', $userid);
    unset_user_preference('newemailattemptsleft', $userid);
}

function useredit_load_preferences(&$user, $reload = true) {
    global $USER;

    if (!empty($user->id)) {
        if ($reload and $USER->id == $user->id) {
            // reload preferences in case it was changed in other session
            unset($USER->preference);
        }

        if ($preferences = get_user_preferences(null, null, $user->id)) {
            foreach ($preferences as $name => $value) {
                $user->{'preference_' . $name} = $value;
            }
        }
    }
}

function useredit_update_user_preference($usernew) {
    $ua = (array) $usernew;
    foreach ($ua as $key => $value) {
        if (strpos($key, 'preference_') === 0) {
            $name = substr($key, strlen('preference_'));
            set_user_preference($name, $value, $usernew->id);
        }
    }
}

function useredit_update_picture(&$usernew, $userform) {
    global $CFG, $DB;
    require_once("$CFG->libdir/gdlib.php");

    $fs = get_file_storage();
    $context = get_context_instance(CONTEXT_USER, $usernew->id, MUST_EXIST);

    if (isset($usernew->deletepicture) and $usernew->deletepicture) {
        $fs->delete_area_files($context->id, 'user', 'icon'); // drop all areas
        $DB->set_field('user', 'picture', 0, array('id' => $usernew->id));
    } else if ($iconfile = $userform->save_temp_file('imagefile')) {
        if (process_new_icon($context, 'user', 'icon', 0, $iconfile)) {
            $DB->set_field('user', 'picture', 1, array('id' => $usernew->id));
        }
        @unlink($iconfile);
    }
}

function useredit_update_bounces($user, $usernew) {
    if (!isset($usernew->email)) {
        //locked field
        return;
    }
    if (!isset($user->email) || $user->email !== $usernew->email) {
        set_bounce_count($usernew, true);
        set_send_count($usernew, true);
    }
}

function useredit_update_trackforums($user, $usernew) {
    global $CFG;
    if (!isset($usernew->trackforums)) {
        //locked field
        return;
    }
    if ((!isset($user->trackforums) || ($usernew->trackforums != $user->trackforums)) and ! $usernew->trackforums) {
        require_once($CFG->dirroot . '/mod/forum/lib.php');
        forum_tp_delete_read_records($usernew->id);
    }
}

function useredit_update_interests($user, $interests) {
    tag_set('user', $user->id, $interests);
}

//****added by yasmin 3/1/2013
function useredit_shared_definition(&$mform, $editoroptions = null) {
    global $CFG, $USER, $DB;

    $user = $DB->get_record('user', array('id' => $USER->id));
    //$currentuser = ($user->id == $USER->id); //add by aa
    useredit_load_preferences($user, false);

    $strrequired = get_string('required');

    $rolesql = mysql_query("SELECT * FROM {$CFG->prefix}role_assignments WHERE contextid='1' AND userid='" . $USER->id . "'");
    $rs = mysql_fetch_array($rolesql);

    $mform->addElement('hidden', 'currentpicture', get_string('currentpicture'));

    if ($user->id == '2') {
        $mform->addElement('header', 'user', get_string('user_picture'));
        $mform->addElement('checkbox', 'deletepicture', get_string('delete'));
        $mform->setDefault('deletepicture', 0);

        $mform->addElement('filepicker', 'imagefile', get_string('newpicture'), '', array('maxbytes' => get_max_upload_file_size($CFG->maxbytes)));
        $mform->addHelpButton('imagefile', 'newpicture');

        $mform->addElement('text', 'imagealt', get_string('imagealt'), 'maxlength="100" size="30"');
        $mform->setType('imagealt', PARAM_MULTILANG);
    } else {
        if (($rs['roleid'] != '10') && ($rs['roleid'] != '12') && ($rs['roleid'] != '13')) { //jika bukan exam center
            $mform->addElement('hidden', 'deletepicture', get_string('delete'));
            $mform->setDefault('deletepicture', 0);

            $mform->addElement('hidden', 'imagefile', get_string('newpicture'), '', array('maxbytes' => get_max_upload_file_size($CFG->maxbytes)));
            $mform->addHelpButton('imagefile', 'newpicture');

            $mform->addElement('hidden', 'imagealt', get_string('imagealt'), 'maxlength="100" size="30"');
            $mform->setType('imagealt', PARAM_MULTILANG);
        }
    }

    $mform->addElement('header', 'user', get_string('general'));

    $nameordercheck = new stdClass();
    $nameordercheck->firstname = 'a';
    $nameordercheck->lastname = 'b';

    $choices = array();
    $choices[''] = 'Select one..';
    $choices['1'] = 'Mr';
    $choices['2'] = 'Mrs';
    $choices['3'] = 'Miss';
    if ($USER->id != '2') {
        $mform->addElement('select', 'title', 'Title', $choices);
        $mform->setDefault('title', $USER->title);
    } else {
        $mform->addElement('select', 'title', 'Title', $choices);
        $mform->setDefault('title', '1');
    }

    /* if($USER->id!='2'){
      $mform->hardFreeze('title');
      } */

    if (fullname($nameordercheck) == 'b a') {  // See MDL-4325
        $mform->addElement('static', 'lastname', get_string('lastname'), 'maxlength="26" size="40"');
        $mform->addElement('static', 'firstname', get_string('firstname'), 'maxlength="26" size="40"');
    } else {
        if ($USER->id != '2') {
            $mform->addElement('static', 'firstname', get_string('firstname'), 'maxlength="26" size="40"');
            if (($CFG->middlename) != '') {
                $mform->addElement('static', 'middlename', get_string('middlename'), 'maxlength="26" size="40"');
            } else {
                $mform->addElement('text', 'middlename', get_string('middlename'), 'maxlength="26" size="40"');
            }
            // $mform->addElement('text','middlename',  get_string('middlename'),  'maxlength="26" size="40"');
            $mform->addElement('static', 'lastname', get_string('lastname'), 'maxlength="26" size="40"');
        } else {
            $mform->addElement('text', 'firstname', get_string('firstname'), 'maxlength="50" size="40"');
            $mform->addRule('firstname', $strrequired, 'required', null, 'client');
            $mform->addElement('text', 'middlename', get_string('middlename'), 'maxlength="50" size="40"');
            $mform->addElement('text', 'lastname', get_string('lastname'), 'maxlength="50" size="40"');
            $mform->addRule('lastname', $strrequired, 'required', null, 'client');
        }
    }

    //add by arizan abdullah
    $setdob=date('Y',strtotime('now'.'+ 23 year'));
    // $setdob = date("Y", time() . strtotime("+23 year"));
    $setdob_modify = array(
        'startyear' => 1933,
        'stopyear' => $setdob,
        'timezone' => 99,
        'optional' => false
    );
    $mform->addElement('date_selector', 'dob', get_string('dob'), $setdob_modify);
    $mform->addRule('dob', $strrequired, 'required', null, 'client');

    $choices = array();
    $choices[''] = 'Select one..';
    $choices['0'] = get_string('male');
    $choices['1'] = get_string('female');
    //if($USER->id!='2'){
    //$mform->addElement('select', 'gender', get_string('gender'), $choices, 'disabled="disabled"');
    //}else{
    $mform->addElement('select', 'gender', get_string('gender'), $choices);
    //}
    $mform->addRule('gender', $strrequired, 'required', null, 'client');
    $mform->setDefault('gender', $USER->gender);
    if ($USER->id != '2') {
        $mform->hardFreeze('gender');
    }

    //If user is not capable, make it read only.
    if ($USER->id != '2') {
        //if (!has_capability('moodle/course:update', $coursecontext)) {
            //$mform->hardFreeze('dob');
        //} else {
            //$addactionbuttons = true;
        //}
    }

    // Do not show email field if change confirmation is pending
    if (!empty($CFG->emailchangeconfirmation) and ! empty($user->preference_newemail)) {
        $notice = get_string('emailchangepending', 'auth', $user);
        $notice .= '<br /><a href="edit.php?cancelemailchange=1&amp;id=' . $user->id . '">'
                . get_string('emailchangecancel', 'auth') . '</a>';
        $mform->addElement('static', 'emailpending', get_string('email'), $notice);
    } else {
        //if(($rs['roleid']!='10') && ($rs['roleid']!='12') && ($rs['roleid']!='13')){	//jika bkn exam center
        $mform->addElement('text', 'email', get_string('email'), 'maxlength="100" size="30"');
        $mform->addRule('email', $strrequired, 'required', null, 'client');
        if ($USER->id != '2') {
            $mform->hardFreeze('email');
        }
        //}
    }

    $choices = array();
    $choices['0'] = get_string('emaildisplayno');
    $choices['1'] = get_string('emaildisplayyes');
    $choices['2'] = get_string('emaildisplaycourse');
    $mform->addElement('hidden', 'maildisplay', $choices);
    $mform->setDefault('maildisplay', 2);

    $choices = array();
    $choices['0'] = get_string('textformat');
    $choices['1'] = get_string('htmlformat');
    $mform->addElement('hidden', 'mailformat', $choices);
    $mform->setDefault('mailformat', 1);

    if (!empty($CFG->allowusermailcharset)) {
        $choices = array();
        $charsets = get_list_of_charsets();
        if (!empty($CFG->sitemailcharset)) {
            $choices['0'] = get_string('site') . ' (' . $CFG->sitemailcharset . ')';
        } else {
            $choices['0'] = get_string('site') . ' (UTF-8)';
        }
        $choices = array_merge($choices, $charsets);
        $mform->addElement('select', 'preference_mailcharset', get_string('emailcharset'), $choices);
    }

    $choices = array();
    $choices['0'] = get_string('emaildigestoff');
    $choices['1'] = get_string('emaildigestcomplete');
    $choices['2'] = get_string('emaildigestsubjects');
    $mform->addElement('hidden', 'maildigest', $choices);
    $mform->setDefault('maildigest', 0);

    $choices = array();
    $choices['1'] = get_string('autosubscribeyes');
    $choices['0'] = get_string('autosubscribeno');
    $mform->addElement('hidden', 'autosubscribe', $choices);
    $mform->setDefault('autosubscribe', 1);

    if (!empty($CFG->forum_trackreadposts)) {
        $choices = array();
        $choices['0'] = get_string('trackforumsno');
        $choices['1'] = get_string('trackforumsyes');
        $mform->addElement('hidden', 'trackforums', $choices);
        $mform->setDefault('trackforums', 0);
    }

    $editors = editors_get_enabled();
    if (count($editors) > 1) {
        $choices = array();
        $choices['0'] = get_string('texteditor');
        $choices['1'] = get_string('htmleditor');
        $mform->addElement('hidden', 'htmleditor', $choices);
        $mform->setDefault('htmleditor', 1);
    } else {
        $mform->addElement('hidden', 'htmleditor');
        $mform->setDefault('htmleditor', 1);
        $mform->setType('htmleditor', PARAM_INT);
    }

    if (empty($CFG->enableajax)) {
        $mform->addElement('static', 'ajaxdisabled', get_string('ajaxuse'), get_string('ajaxno'));
    } else {
        $choices = array();
        $choices['0'] = get_string('ajaxno');
        $choices['1'] = get_string('ajaxyes');
        $mform->addElement('hidden', 'ajax', $choices);
        $mform->setDefault('ajax', 0);
    }

    $choices = array();
    $choices['0'] = get_string('screenreaderno');
    $choices['1'] = get_string('screenreaderyes');
    $mform->addElement('hidden', 'screenreader', $choices);
    $mform->setDefault('screenreader', 0);
    $mform->addHelpButton('screenreader', 'screenreaderuse');

    if (($rs['roleid'] != '10') && ($rs['roleid'] != '12') && ($rs['roleid'] != '13')) { //jika bkn exam center
        $mform->addElement('text', 'address', get_string('address1'), 'maxlength="120" size="40"');
        $mform->addRule('address', $strrequired, 'required', null, 'client');
        $mform->setType('address', PARAM_MULTILANG);

        $mform->addElement('text', 'address2', get_string('address2'), 'maxlength="120" size="40"');
        $mform->setType('address2', PARAM_MULTILANG);

        $mform->addElement('text', 'address3', get_string('address3'), 'maxlength="120" size="40"');
        $mform->setType('address3', PARAM_MULTILANG);
    }

    if (($rs['roleid'] != '10') && ($rs['roleid'] != '12') && ($rs['roleid'] != '13')) { //jika bkn exam center
        $mform->addElement('text', 'city', get_string('city'), 'maxlength="120" size="21"'); //city
        $mform->setType('city', PARAM_MULTILANG);
        $mform->addRule('city', $strrequired, 'required', null, 'client');
        if (!empty($CFG->defaultcity)) {
            $mform->setDefault('city', $CFG->defaultcity);
        }

        $mform->addElement('text', 'postcode', get_string('zip'), 'maxlength="120" size="21"'); //poskod
        $mform->setType('postcode', PARAM_MULTILANG);
        // $mform->addRule('postcode', $strrequired, 'required', null, 'client');
        if (!empty($CFG->defaultpostcode)) {
            $mform->setDefault('postcode', $CFG->defaultpostcode);
        }

        $mform->addElement('text', 'state', get_string('state'), 'maxlength="120" size="21"'); //state
        $mform->setType('state', PARAM_MULTILANG);
        if (!empty($CFG->defaultstate)) {
            $mform->setDefault('state', $CFG->defaultstate);
        }
    }

    if ($USER->id != '2') { //country
        if (($rs['roleid'] != '10') && ($rs['roleid'] != '12') && ($rs['roleid'] != '13')) { //jika bkn exam center
            $choices = get_string_manager()->get_list_of_countries();
            $choices = array('' => get_string('selectacountry') . '...') + $choices;
            $mform->addElement('select', 'country', 'Country', $choices);
            $mform->addRule('country', $strrequired, 'required', null, 'client');
            if (!empty($CFG->country)) {
                $mform->setDefault('country', $CFG->country);
                $mform->hardFreeze('country');
            }
        }
    } else {
        $choices = get_string_manager()->get_list_of_countries();
        $choices = array('' => get_string('selectacountry') . '...') + $choices;
        $mform->addElement('select', 'country', get_string('selectacountry'), $choices);
        $mform->addRule('country', $strrequired, 'required', null, 'client');
        if (!empty($CFG->country)) {
            $mform->setDefault('country', $CFG->country);
        }
    }

    $countrycode = getUserCountrycode($user->country);
    //if ($USER->id != '2') {
    if (($rs['roleid'] != '10') && ($rs['roleid'] != '12') && ($rs['roleid'] != '13')) { //jika bkn exam center
        // $selectcode = mysql_query("SELECT * FROM mdl_cifacountry_list WHERE countrycode='" . $USER->country . "'");
        //$ccode = mysql_fetch_array($selectcode);
        $mobiletelcode = array();
        $mobiletelcode[] = & $mform->createElement('static', 'mobiletelcode', '', '+' . $countrycode);
        $mobiletelcode[] = & $mform->createElement('text', 'phone1', '');
        $mform->addGroup($mobiletelcode, 'mobiletelcode', get_string('officetel'), ' ', false);  //mobile phone	
        $mform->addRule('mobiletelcode', $strrequired, 'required', null, 'client');
    }
    /* } else {
      $mform->addElement('text', 'phone1', get_string('officetel'), 'maxlength="20" size="25"');
      $mform->addRule('phone1', $strrequired, 'required', null, 'client');
      $mform->setType('phone1', PARAM_NOTAGS); //mobile phone

      $mobiletelcode = array();
      $mobiletelcode[] = & $mform->createElement('static', 'mobiletelcode', '', '+' . $countrycode);
      $mobiletelcode[] = & $mform->createElement('text', 'phone1', '');
      $mform->addGroup($mobiletelcode, 'mobiletelcode', get_string('officetel'), ' ', false);  //mobile phone
      $mform->addRule('mobiletelcode', $strrequired, 'required', null, 'client');
      } */

    $choices = get_list_of_timezones();
    $choices['99'] = get_string('serverlocaltime');
    if ($CFG->forcetimezone != 99) {
        //$mform->addElement('static', 'forcedtimezone', get_string('timezone'), $choices[$CFG->forcetimezone]);
        $mform->addElement('hidden', 'forcedtimezone', $choices[$CFG->forcetimezone]);
    } else {
        //$mform->addElement('select', 'timezone', get_string('timezone'), $choices);
        $mform->addElement('hidden', 'timezone', $choices);
        $mform->setDefault('timezone', $CFG->timezone);
    }

    //$mform->addElement('select', 'lang', get_string('preferredlanguage'), get_string_manager()->get_list_of_translations());
    $mform->addElement('hidden', 'lang', get_string_manager()->get_list_of_translations());
    $mform->setDefault('lang', $CFG->lang);

    if (!empty($CFG->allowuserthemes)) {
        $choices = array();
        $choices[''] = get_string('default');
        $themes = get_list_of_themes();
        foreach ($themes as $key => $theme) {
            if (empty($theme->hidefromselector)) {
                $choices[$key] = $theme->name;
            }
        }
        $mform->addElement('select', 'theme', get_string('preferredtheme'), $choices);
    }
    //edited by arizan abdullah
    //$mform->addElement('editor', 'description_editor', get_string('userdescription'), null, $editoroptions);
    $mform->addElement('hidden', 'description_editor', null, $editoroptions);
    $mform->setType('description_editor', PARAM_CLEANHTML);
    $mform->addHelpButton('description_editor', 'userdescription');

    //last time created
    $lasttimecreated = strtotime('120 days');
    $mform->addElement('hidden', 'lasttimecreated', $lasttimecreated);
    $mform->setType('lasttimecreated', PARAM_NOTAGS);
    if (!empty($CFG->lasttimecreated)) {
        $mform->setDefault('lasttimecreated', $CFG->lasttimecreated);
    }

    //**********************************************************************************/

    if (!empty($CFG->usetags) and empty($USER->newadminuser)) {
        //$mform->addElement('header', 'moodle_interests', get_string('interests'));
        $mform->addElement('hidden', 'moodle_interests', get_string('interests'));
        $mform->addElement('hidden', 'interests', get_string('interestslist'), array('display' => 'noofficial')); //tags
        $mform->addHelpButton('interests', 'interestslist');
    }

    //added by arizan abdullah 20121003
    /// Moodle optional fields	
    if ($user->id != '2') {
        if (($rs['roleid'] != '10') && ($rs['roleid'] != '12') && ($rs['roleid'] != '13')) {
            $mform->addElement('header', '', 'Employment Background', '');

            $empstatustitle = get_string('empstatus');
            $empstatuslist = array();
            $empstatuslist['1'] = get_string('working');
            $empstatuslist['2'] = get_string('notworking');
            $mform->addElement('select', 'empstatus', $empstatustitle, $empstatuslist);
            $mform->addRule('empstatus', $strrequired, 'required', null, 'client');
            $mform->setDefault('empstatus', 1);
            if (!empty($USER->empstatus)) {
                $mform->setDefault('empstatus', $USER->empstatus);
            }

            // $mform->addElement('text', 'employeeid', get_string('employeeid'), 'pattern=".{15,20}" required title="15 to 20 characters" size="40"');
            $mform->addElement('text', 'access_token', get_string('employeeid'), 'maxlength="20" title="15 to 20 characters" size="40"');
            $mform->setType('access_token', PARAM_NOTAGS);
            // $mform->addHelpButton('employeeid', 'interestslist');
            $mform->disabledIf('access_token', 'empstatus', 'noteq', 1);

            $mform->addElement('text', 'empname', get_string('empname'), 'required title="' . get_string('empname') . '" placeholder="if working, fillup this box"');
            $mform->setType('empname', PARAM_NOTAGS);
            $mform->disabledIf('empname', 'empstatus', 'noteq', 1);

            $mform->addElement('text', 'designation', get_string('designation'), 'required title="' . get_string('designation') . '" placeholder="if working, fillup this box"');
            $mform->setType('designation', PARAM_NOTAGS);
            $mform->disabledIf('designation', 'empstatus', 'noteq', 1);

            $mform->addElement('text', 'department', get_string('department'), 'required title="' . get_string('department') . '" placeholder="if working, fillup this box"');
            $mform->setType('department', PARAM_NOTAGS);
            $mform->disabledIf('department', 'empstatus', 'noteq', 1);

            $currentyeardate =date('Y',strtotime('now'.'+ 23 years'));
            // $currentyeardate = date("Y", time() . strtotime("+23 year"));
            $date_selector_modify = array(
                'startyear' => 1933,
                'stopyear' => $currentyeardate,
                'timezone' => 99,
                'optional' => false
            );
            $mform->addElement('date_selector', 'empstartdate', get_string('empstartdate'), $date_selector_modify, 'required title=" if working, fillup this box"'); //start date
            // $mform->addRule('empstartdate', $strrequired, 'required', null, 'client');
            $mform->disabledIf('empstartdate', 'empstatus', 'noteq', 1);
        } else { //if exam center
            //$mform->addElement('header', '', get_string('general'), '');  
            //Institution Details
            $mform->addElement('text', 'designation', get_string('designation'), 'maxlength="100"');
            $mform->addRule('designation', $strrequired, 'required', null, 'client');
            $mform->setType('designation', PARAM_NOTAGS);

            $mform->addElement('text', 'department', get_string('department'), 'maxlength="100"');
            $mform->addRule('department', $strrequired, 'required', null, 'client');
            $mform->setType('department', PARAM_NOTAGS);

            //$selectcode = mysql_query("SELECT * FROM mdl_cifacountry_list WHERE countrycode='" . $USER->country . "'");
            //$ccode = mysql_fetch_array($selectcode);

            $mobiletelcode = array();
            $mobiletelcode[] = & $mform->createElement('static', 'mobiletelcode', '', '+' . $countrycode);
            $mobiletelcode[] = & $mform->createElement('text', 'mobile', '');
            $mform->addGroup($mobiletelcode, 'mobiletelcode', get_string('mobiletel'), ' ', false);  //mobile phone	
            $mform->addRule('mobiletelcode', $strrequired, 'required', null, 'client');


            $mform->addElement('header', '', get_string('institutiondetails'), '');  //Institution Details
            //logo
            $mform->addElement('hidden', 'deletepicture', get_string('delete'));
            $mform->setDefault('deletepicture', 0);

            $mform->addElement('filepicker', 'imagefile', get_string('logo'), '', array('maxbytes' => get_max_upload_file_size($CFG->maxbytes)));
            //$mform->addHelpButton('imagefile', 'newpicture');

            $mform->addElement('hidden', 'imagealt', get_string('imagealt'), 'maxlength="100" size="30"');
            $mform->setType('imagealt', PARAM_MULTILANG);
            //logo

            $mform->addElement('text', 'institution', get_string('institutionname'), 'maxlength="50" size="40"');
            $mform->setType('institution', PARAM_NOTAGS);

            $mform->addElement('text', 'address', get_string('address1'), 'maxlength="255" size="40"');
            $mform->addRule('address', $strrequired, 'required', null, 'client');
            $mform->setType('address', PARAM_MULTILANG);

            $mform->addElement('text', 'address2', get_string('address2'), 'maxlength="255" size="40"');
            $mform->setType('address2', PARAM_MULTILANG);

            $mform->addElement('text', 'address3', get_string('address3'), 'maxlength="255" size="40"');
            $mform->setType('address3', PARAM_MULTILANG);

            $mform->addElement('text', 'city', get_string('city'), 'maxlength="120" size="21"'); //city
            $mform->setType('city', PARAM_MULTILANG);
            $mform->addRule('city', $strrequired, 'required', null, 'client');
            if (!empty($CFG->city)) {
                $mform->setDefault('city', $CFG->city);
            }

            $mform->addElement('text', 'postcode', get_string('zip'), 'maxlength="120" size="21"'); //poskod
            $mform->setType('postcode', PARAM_MULTILANG);
            if (!empty($CFG->postcode)) {
                $mform->setDefault('postcode', $CFG->postcode);
            }

            $mform->addElement('text', 'state', get_string('state'), 'maxlength="120" size="21"'); //state
            $mform->setType('state', PARAM_MULTILANG);
            if (!empty($CFG->state)) {
                $mform->setDefault('state', $CFG->state);
            }

            $choices = get_string_manager()->get_list_of_countries();
            $choices = array('' => get_string('selectacountry') . '...') + $choices;
            $mform->addElement('select', 'country', get_string('selectacountry'), $choices);
            $mform->addRule('country', $strrequired, 'required', null, 'client');
            if (!empty($CFG->country)) {
                $mform->setDefault('country', $CFG->country);
            }

            // $mform->addElement('text', 'orgtel', get_string('worktel'), 'maxlength="20" size="25"');
            // $mform->setType('orgtel', PARAM_NOTAGS); //orgtel

            $worktelcode = array();
            $worktelcode[] = & $mform->createElement('static', 'worktelcode', '', '+' . $countrycode);
            $worktelcode[] = & $mform->createElement('text', 'orgtel', '');
            $mform->addGroup($worktelcode, 'worktelcode', get_string('worktel'), ' ', false);  //orgtel	

            $orgfaxcode = array();
            $orgfaxcode[] = & $mform->createElement('static', 'orgfaxcode', '', '+' . $countrycode);
            $orgfaxcode[] = & $mform->createElement('text', 'orgfax', '');
            $mform->addGroup($orgfaxcode, 'orgfaxcode', get_string('workfax'), ' ', false);  //orgfax		
            // $mform->addElement('text', 'orgfax', get_string('workfax'), 'maxlength="20" size="25"');
            // $mform->setType('orgfax', PARAM_NOTAGS); //orgfax

            $mform->addElement('text', 'url', get_string('website'), 'size="25"');
            $mform->setType('url', PARAM_NOTAGS); //website		

            $mform->addElement('text', 'ipaddress', get_string('ip_address'), 'size="25"');
            $mform->setType('ipaddress', PARAM_NOTAGS); //ip address	
            $mform->addHelpButton('ipaddress', 'ip_address');
        }

        if (($rs['roleid'] != '10') && ($rs['roleid'] != '12') && ($rs['roleid'] != '13')) {
            $mform->addElement('header', '', 'Education Background', '');

            //Educational Background & Employment details //list of highesteducation//****** 
            $highesteducationtitle = get_string('highesteducation');
            $highesteducationlist = array();
            $highesteducationlist[''] = 'Select one..';
            $highesteducationlist['1'] = get_string('highesteducation1');
            $highesteducationlist['2'] = get_string('highesteducation2');
            $highesteducationlist['3'] = get_string('highesteducation3');
            $highesteducationlist['4'] = get_string('highesteducation4');
            $highesteducationlist['5'] = get_string('highesteducation5');
            $mform->addElement('select', 'highesteducation', $highesteducationtitle, $highesteducationlist);

            $mform->addRule('highesteducation', $strrequired, 'required', null, 'client');
            if (!empty($USER->highesteducation)) {
                $mform->setDefault('highesteducation', $CFG->highesteducation);
            }
            //list of highesteducation// End
            //Year completed education
            $currentyeardateedu = date('Y',strtotime('now'.'+ 23 years'));
            // $currentyeardateedu = date("Y", time() . strtotime("+23 year"));

            $listyearsedu = array();
            $listyearsedu[''] = 'Select one..';
            for ($i = 1933; $i <= $currentyeardateedu; $i++) {
                $listyearsedu["$i"] = $i;
            }
            $mform->addElement('select', 'yearcomplete_edu', get_string('yearcomplete'), $listyearsedu);
            $mform->addRule('yearcomplete_edu', $strrequired, 'required', null, 'client');
            if (!empty($USER->yearcomplete_edu)) {
                $mform->setDefault('yearcomplete_edu', $CFG->yearcomplete_edu);
            }
            $mform->disabledIf('yearcomplete_edu', 'highesteducation', 'eq', '');

            //professionalcert //list of professionalcert// 
            $profcerttitle = get_string('professionalcert');
            $profcertlist = array();
            $profcertlist[''] = 'Select one..';
            $profcertlist['1'] = get_string('certificate0');
            $profcertlist['2'] = get_string('certificate1');
            $profcertlist['3'] = get_string('certificate2');
            $profcertlist['4'] = get_string('certificate3');
            $profcertlist['5'] = get_string('certificate4');
            $profcertlist['6'] = get_string('certificate5');
            $profcertlist['7'] = get_string('certificate6');
            $profcertlist['8'] = get_string('certificate7');
            $profcertlist['9'] = get_string('certificate8');
            $profcertlist['10'] = get_string('certificate9');
            $profcertlist['11'] = get_string('certificate10');
            $profcertlist['12'] = get_string('certificate11');
            $mform->addElement('select', 'professionalcert', $profcerttitle, $profcertlist);
            if (!empty($USER->professionalcert)) {
                $mform->setDefault('professionalcert', $USER->professionalcert);
            }
            //list of professionalcert// End	
            $mform->addElement('text', 'nameofqualification', get_string('nameofqualification'), 'maxlength="50" size="40"');
            $mform->setType('nameofqualification', PARAM_NOTAGS);
            $mform->disabledIf('nameofqualification', 'professionalcert', 'noteq', 12);

            $currentyeardate = date('Y',strtotime('now'.'+ 23 years'));
            // $currentyeardate = date("Y", time() . strtotime("+23 year"));

            $listyears = array();
            $listyears[''] = 'Select one..';
            for ($i = 1933; $i <= $currentyeardate; $i++) {
                $listyears["$i"] = $i;
            }
            $mform->addElement('select', 'yearcomplete', get_string('yearcomplete'), $listyears);
            if (!empty($USER->yearcomplete)) {
                $mform->setDefault('yearcomplete', $CFG->yearcomplete);
            }
            $mform->disabledIf('yearcomplete', 'professionalcert', 'eq', '');

            $mform->addElement('text', 'college_edu', get_string('college'), 'maxlength="50" size="40"');
            $mform->addRule('college_edu', $strrequired, 'required', null, 'client');
            $mform->setType('college_edu', PARAM_NOTAGS);

            $mform->disabledIf('college_edu', 'highesteducation', 'eq', '');

            $mform->addElement('text', 'major_edu', get_string('major'), 'maxlength="50" size="40"');
            $mform->addRule('major_edu', $strrequired, 'required', null, 'client');
            $mform->setType('major_edu', PARAM_NOTAGS);
            $mform->disabledIf('major_edu', 'highesteducation', 'eq', '');

            $date_selector_modify = array(
                'startyear' => 1933,
                'stopyear' => $currentyeardate,
                'timezone' => 99,
                'optional' => false
            );
            $mform->addElement('date_selector', 'startdate_edu', get_string('empstartdate'), $date_selector_modify); //empstartdate date
            $mform->addRule('startdate_edu', $strrequired, 'required', null, 'client');
            if (!empty($USER->startdate_edu)) {
                $mform->setDefault('startdate_edu', $CFG->startdate_edu);
            }
            $mform->disabledIf('startdate_edu', 'highesteducation', 'eq', '');

            $mform->addElement('date_selector', 'completion_edu', get_string('completiondate'), $date_selector_modify); //completion_edu date	
            $mform->addRule('completion_edu', $strrequired, 'required', null, 'client');
            if (!empty($USER->completion_edu)) {
                $mform->setDefault('completion_edu', $CFG->completion_edu);
            }
            $mform->disabledIf('completion_edu', 'highesteducation', 'eq', '');
        }

        if (($rs['roleid'] != '10') && ($rs['roleid'] != '12') && ($rs['roleid'] != '13')) {
            //popup
            $a = new stdClass();

            $policy = $CFG->wwwroot . '/userpolicy.php';
            $a = "<a href=\"javascript:void(0);\" onclick=\"popupwindow('" . $policy . "', 'myPop1',820,600);\"><u><b>" . get_string('cifaonlinepolicy') . "</b></u></a>";
            //End popup	
            //Communication Preferences//	
            $mform->addElement('header', '', get_string('communicationpreferences'), '');

            //$mform->addElement('static', 'description', 'Please read the options in this column carefully.');
            $mform->addElement('html', '<div style="padding-left:13em;"><h6>Please read the options in this column carefully.</h6></div>');

            /* $mform->addElement('advcheckbox', 'cpreference1', null,  '<span style="margin-right:4em;">'.get_string('compreference1').'</span>', array('group' => 1, 'disabled'=>'disabled'));
              $mform->setDefault('cpreference1', 1);
              $mform->addElement('hidden', 'compreference1', '1');
              $mform->setDefault('compreference1', 1); */

            $mform->addElement('advcheckbox', 'compreference2', '', get_string('compreference2'), array('group' => 1), array(0, 1));

            $mform->addElement('advcheckbox', 'cpreference3', null, get_string('compreference3_1') . get_string('compreference3', '', $a) . get_string('compreference3_2'), array('group' => 1, 'disabled' => 'disabled'));
            $mform->setDefault('cpreference3', 1);
            $mform->addElement('hidden', 'compreference3', '1');
            $mform->setDefault('compreference3', 1);
        }
    }
}
