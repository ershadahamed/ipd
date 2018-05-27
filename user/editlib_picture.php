<?php

function cancel_email_update($userid) {
    unset_user_preference('newemail', $userid);
    unset_user_preference('newemailkey', $userid);
    unset_user_preference('newemailattemptsleft', $userid);
}

function useredit_load_preferences(&$user, $reload=true) {
    global $USER;

    if (!empty($user->id)) {
        if ($reload and $USER->id == $user->id) {
            // reload preferences in case it was changed in other session
            unset($USER->preference);
        }

        if ($preferences = get_user_preferences(null, null, $user->id)) {
            foreach($preferences as $name=>$value) {
                $user->{'preference_'.$name} = $value;
            }
        }
    }
}

function useredit_update_user_preference($usernew) {
    $ua = (array)$usernew;
    foreach($ua as $key=>$value) {
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
        $DB->set_field('user', 'picture', 0, array('id'=>$usernew->id));

    } else if ($iconfile = $userform->save_temp_file('imagefile')) {
        if (process_new_icon($context, 'user', 'icon', 0, $iconfile)) {
            $DB->set_field('user', 'picture', 1, array('id'=>$usernew->id));
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
        set_bounce_count($usernew,true);
        set_send_count($usernew,true);
    }
}

function useredit_update_trackforums($user, $usernew) {
    global $CFG;
    if (!isset($usernew->trackforums)) {
        //locked field
        return;
    }
    if ((!isset($user->trackforums) || ($usernew->trackforums != $user->trackforums)) and !$usernew->trackforums) {
        require_once($CFG->dirroot.'/mod/forum/lib.php');
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
    useredit_load_preferences($user, false);

    $strrequired = get_string('required');	
	$mform->addElement('header','user', 'Change Picture');
	
	$mform->addElement('hidden', 'currentpicture', get_string('currentpicture')); //static
	
	$mform->addElement('checkbox', 'deletepicture', get_string('delete'), 'Check this box to delete');
	$mform->setDefault('deletepicture', 0);

	$mform->addElement('filepicker', 'imagefile', get_string('newpicture'), '', array('maxbytes'=>get_max_upload_file_size($CFG->maxbytes)));
	$mform->addHelpButton('imagefile', 'newpicture');

	//$mform->addElement('text', 'imagealt', get_string('imagealt'), 'maxlength="100" size="30"');
	$mform->addElement('hidden', 'imagealt', get_string('imagealt'), 'maxlength="100" size="30"');
	$mform->setType('imagealt', PARAM_MULTILANG);
	
	//if($USER->id !='2'){	
	//header user picture
	/* $mform->addElement('header','user', get_string('general')); */
	//}
		
/*     $nameordercheck = new stdClass();
    $nameordercheck->firstname = 'a';
    $nameordercheck->lastname  = 'b';
    if (fullname($nameordercheck) == 'b a' ) {  // See MDL-4325
        $mform->addElement('static', 'lastname',  get_string('lastname'),  'maxlength="26" size="40"');
			if($USER->middlename ==''){
			$mform->addElement('static','middlename',  get_string('middlename'),  'maxlength="26" size="40"');
			}		
        $mform->addElement('static', 'firstname', get_string('firstname'), 'maxlength="26" size="40"');
    } else {
		if($USER->id != '2'){
			$mform->addElement('static','firstname', get_string('firstname'), 'maxlength="26" size="40"');
			$mform->addElement('static','lastname',  get_string('lastname'),  'maxlength="26" size="40"');
		}else{
			$mform->addElement('text','firstname', get_string('firstname'), 'maxlength="26" size="40"');
			$mform->addElement('text','middlename',  get_string('middlename'),  'maxlength="26" size="40"');
			$mform->addElement('text','lastname',  get_string('lastname'),  'maxlength="26" size="40"');		
		}
    } */

    //$mform->addRule('firstname', $strrequired, 'required', null, 'client');
    //$mform->setType('firstname', PARAM_NOTAGS);

    //$mform->addRule('lastname', $strrequired, 'required', null, 'client');
    //$mform->setType('lastname', PARAM_NOTAGS);
	
	//add by arizan abdullah
/* 	$mform->addElement('date_selector', 'dob', get_string('dob'));

    $choices = array();
	$choices['']='Select one..';
    $choices['0'] = get_string('male');
    $choices['1'] = get_string('female');
    $mform->addElement('select', 'gender', get_string('gender'), $choices);
    $mform->setDefault('gender', $USER->gender); */
	
	// If user is not capable, make it read only.
/* 	if($USER->id != '2'){
        if (!has_capability('moodle/course:update', $coursecontext)) {
            $mform->hardFreeze('dob');
        } else {
            $addactionbuttons = true;
        }
	} */
	
    // Do not show email field if change confirmation is pending
/*     if (!empty($CFG->emailchangeconfirmation) and !empty($user->preference_newemail)) {
        $notice = get_string('emailchangepending', 'auth', $user);
        $notice .= '<br /><a href="edit.php?cancelemailchange=1&amp;id='.$user->id.'">'
                . get_string('emailchangecancel', 'auth') . '</a>';
        $mform->addElement('static', 'emailpending', get_string('email'), $notice);
    } else {
        $mform->addElement('text', 'email', get_string('email'), 'maxlength="100" size="30"');
        $mform->addRule('email', $strrequired, 'required', null, 'client');
    } */

/*     $choices = array();
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
            $choices['0'] = get_string('site').' ('.$CFG->sitemailcharset.')';
        } else {
            $choices['0'] = get_string('site').' (UTF-8)';
        }
        $choices = array_merge($choices, $charsets);
        $mform->addElement('select', 'preference_mailcharset', get_string('emailcharset'), $choices);
    } */

/*     $choices = array();
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
	
	//add by arizan abdullah 24/10/2011
    $mform->addElement('textarea', 'address', get_string('address'), 'maxlength="200" cols="28" rows="4"');
    $mform->setType('address', PARAM_MULTILANG);	
		
    $mform->addElement('text', 'state', get_string('state'), 'maxlength="120" size="21"');
    $mform->setType('state', PARAM_MULTILANG);
    if (!empty($CFG->defaultstate)) {
        $mform->setDefault('state', $CFG->defaultstate);
    }
	
    $mform->addElement('text', 'postcode', get_string('zip'), 'maxlength="120" size="21"');
    $mform->setType('postcode', PARAM_MULTILANG);
	$mform->addRule('postcode', $strrequired, 'required', null, 'client');
    if (!empty($CFG->defaultpostcode)) {
        $mform->setDefault('postcode', $CFG->defaultpostcode);
    }	 */
/* 	
    $mform->addElement('text', 'city', get_string('city'), 'maxlength="120" size="21"');
    $mform->setType('city', PARAM_MULTILANG);
    $mform->addRule('city', $strrequired, 'required', null, 'client');
    if (!empty($CFG->defaultcity)) {
        $mform->setDefault('city', $CFG->defaultcity);
    }

    if($USER->id !='2'){
		$choices = get_string_manager()->get_list_of_countries();
		$choices= array(''=>get_string('selectacountry').'...') + $choices;
		$mform->addElement('select', 'country', get_string('selectacountry'), $choices);
		$mform->addRule('country', $strrequired, 'required', null, 'client');
		if (!empty($CFG->country)) {
			$mform->setDefault('country', $CFG->country);
		}	
	}else{
		$choices = get_string_manager()->get_list_of_countries();
		$choices= array(''=>get_string('selectacountry').'...') + $choices;
		$mform->addElement('select', 'country', get_string('selectacountry'), $choices);
		$mform->addRule('country', $strrequired, 'required', null, 'client');
		if (!empty($CFG->country)) {
			$mform->setDefault('country', $CFG->country);
		}
	} */
	
/* 	if($USER->id !='2'){
		$selectcode=mysql_query("SELECT * FROM mdl_cifacountry_list WHERE countrycode='".$USER->country."'");
		$ccode=mysql_fetch_array($selectcode);			
		$mobiletelcode=array();
		$mobiletelcode[] =& $mform->createElement('text', 'phone1', '');
		$mobiletelcode[] =& $mform->createElement('static', 'mobiletelcode', '', '+'.$ccode['iso_countrycode']);
		$mform->addGroup($mobiletelcode, 'mobiletelcode', get_string('mobiletel'), ' ', false);	 //mobile phone	
		$mform->addRule('mobiletelcode', $strrequired, 'required', null, 'client');
	}else{		
		$mform->addElement('text', 'phone1', get_string('mobiletel'), 'maxlength="20" size="25"');
		$mform->addRule('phone1', $strrequired, 'required', null, 'client');
		$mform->setType('phone1', PARAM_NOTAGS); //mobile phone	
	}
	
    $choices = get_list_of_timezones();
    $choices['99'] = get_string('serverlocaltime');
    if ($CFG->forcetimezone != 99) {
        $mform->addElement('static', 'forcedtimezone', get_string('timezone'), $choices[$CFG->forcetimezone]);
    } else {
        //$mform->addElement('select', 'timezone', get_string('timezone'), $choices);
		$mform->addElement('hidden', 'timezone', $choices);
        $mform->setDefault('timezone', $CFG->timezone);
    } */

    //$mform->addElement('select', 'lang', get_string('preferredlanguage'), get_string_manager()->get_list_of_translations());
	$mform->addElement('hidden', 'lang', get_string_manager()->get_list_of_translations());
    $mform->setDefault('lang', $CFG->lang);

    if (!empty($CFG->allowuserthemes)) {
        $choices = array();
        $choices[''] = get_string('default');
        $themes = get_list_of_themes();
        foreach ($themes as $key=>$theme) {
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
	$lasttimecreated=strtotime('1 years');
	$mform->addElement('hidden', 'lasttimecreated',$lasttimecreated);
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
}


