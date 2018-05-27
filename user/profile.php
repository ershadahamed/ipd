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
 * Public Profile -- a user's public profile page
 *
 * - each user can currently have their own page (cloned from system and then customised)
 * - users can add any blocks they want
 * - the administrators can define a default site public profile for users who have
 *   not created their own public profile
 *
 * This script implements the user's view of the public profile, and allows editing
 * of the public profile.
 *
 * @package    moodlecore
 * @subpackage my
 * @copyright  2010 Remote-Learner.net
 * @author     Hubert Chathi <hubert@remote-learner.net>
 * @author     Olav Jordan <olav.jordan@remote-learner.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../manualdbconfig.php');
require_once($CFG->dirroot . '/my/lib.php');
require_once($CFG->dirroot . '/tag/lib.php');
require_once($CFG->dirroot . '/user/profile/lib.php');
require_once($CFG->libdir . '/filelib.php');

$userid = optional_param('id', 0, PARAM_INT);
$edit = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off

$PAGE->set_url('/user/profile.php', array('id' => $userid));

if (!empty($CFG->forceloginforprofiles)) {
    require_login();
    if (isguestuser()) {
        $SESSION->wantsurl = $PAGE->url->out(false);
        redirect(get_login_url());
    }
} else if (!empty($CFG->forcelogin)) {
    require_login();
}

$userid = $userid ? $userid : $USER->id;       // Owner of the page
$user = $DB->get_record('user', array('id' => $userid));
$currentuser = ($user->id == $USER->id);
$context = $usercontext = get_context_instance(CONTEXT_USER, $userid, MUST_EXIST);

if (!$currentuser &&
        !empty($CFG->forceloginforprofiles) &&
        !has_capability('moodle/user:viewdetails', $context) &&
        !has_coursecontact_role($userid)) {

    // Course managers can be browsed at site level. If not forceloginforprofiles, allow access (bug #4366)
    $struser = get_string('user');
    $PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
    $PAGE->set_title("$SITE->shortname: $struser");  // Do not leak the name
    $PAGE->set_heading("$SITE->shortname: $struser");
    $PAGE->set_url('/user/profile.php', array('id' => $userid));
    $PAGE->navbar->add($struser);
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('usernotavailable', 'error'));
    echo $OUTPUT->footer();
    exit;
}

// Get the profile page.  Should always return something unless the database is broken.
if (!$currentpage = my_get_page($userid, MY_PAGE_PUBLIC)) {
    print_error('mymoodlesetup');
}

if (!$currentpage->userid) {
    $context = get_context_instance(CONTEXT_SYSTEM);  // A trick so that we even see non-sticky blocks
}

$PAGE->set_context($context);
if (!$currentuser) {
    $PAGE->set_pagelayout('update_details');
} else {
    $PAGE->set_pagelayout('mydashboard');
}
$PAGE->set_pagetype('user-profile');

// Set up block editing capabilities
if (isguestuser()) {     // Guests can never edit their profile
    $USER->editing = $edit = 0;  // Just in case
    $PAGE->set_blocks_editing_capability('moodle/my:configsyspages');  // unlikely :)
} else {
    if ($currentuser) {
        $PAGE->set_blocks_editing_capability('moodle/user:manageownblocks');
    } else {
        $PAGE->set_blocks_editing_capability('moodle/user:manageblocks');
    }
}

if (has_capability('moodle/user:viewhiddendetails', $context)) {
    $hiddenfields = array();
} else {
    $hiddenfields = array_flip(explode(',', $CFG->hiddenuserfields));
}

// Start setting up the page
$strpublicprofile = get_string('publicprofile');

$site = get_site();
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title(fullname($user) . ": $strpublicprofile");
/* $PAGE->set_heading(fullname($user).": $strpublicprofile"); */
$PAGE->set_heading($site->fullname);

if (!$currentuser) {
    $PAGE->navigation->extend_for_user($user);
    if ($node = $PAGE->settingsnav->get('userviewingsettings' . $user->id)) {
        $node->forceopen = true;
    }
} else if ($node = $PAGE->settingsnav->get('usercurrentsettings', navigation_node::TYPE_CONTAINER)) {
    $node->forceopen = true;
}
if ($node = $PAGE->settingsnav->get('root')) {
    $node->forceopen = false;
}


// Toggle the editing state and switches
if ($PAGE->user_allowed_editing()) {
    if ($edit !== null) {             // Editing state was specified
        $USER->editing = $edit;       // Change editing state
        if (!$currentpage->userid && $edit) {
            // If we are viewing a system page as ordinary user, and the user turns
            // editing on, copy the system pages as new user pages, and get the
            // new page record
            if (!$currentpage = my_copy_page($USER->id, MY_PAGE_PUBLIC, 'user-profile')) {
                print_error('mymoodlesetup');
            }
            $PAGE->set_context($usercontext);
            $PAGE->set_subpage($currentpage->id);
        }
    } else {                          // Editing state is in session
        if ($currentpage->userid) {   // It's a page we can edit, so load from session
            if (!empty($USER->editing)) {
                $edit = 1;
            } else {
                $edit = 0;
            }
        } else {                      // It's a system page and they are not allowed to edit system pages
            $USER->editing = $edit = 0;          // Disable editing completely, just to be safe
        }
    }

    // Add button for editing page
    $params = array('edit' => !$edit);

    if (!$currentpage->userid) {
        // viewing a system page -- let the user customise it
        $editstring = get_string('updatemymoodleon');
        $params['edit'] = 1;
    } else if (empty($edit)) {
        $editstring = get_string('updatemymoodleon');
    } else {
        $editstring = get_string('updatemymoodleoff');
    }

    $url = new moodle_url("$CFG->wwwroot/user/profile.php", $params);
    $button = $OUTPUT->single_button($url, $editstring);
    // $PAGE->set_button($button);
} else {
    $USER->editing = $edit = 0;
}

// HACK WARNING!  This loads up all this page's blocks in the system context
if ($currentpage->userid == 0) {
    $CFG->blockmanagerclass = 'my_syspage_block_manager';
}

// TODO WORK OUT WHERE THE NAV BAR IS!
echo $OUTPUT->header();
echo '<div class="userprofile">';


// Print the standard content of this page, the basic profile info

if (!$currentuser) { //not own user//
    echo '<div style="padding-left: 1em;">' . $OUTPUT->heading(ucwords(strtolower(fullname($user)))) . '</div>';
}

if (is_mnet_remote_user($user)) {
    $sql = "SELECT h.id, h.name, h.wwwroot,
                   a.name as application, a.display_name
              FROM {mnet_host} h, {mnet_application} a
             WHERE h.id = ? AND h.applicationid = a.id";

    $remotehost = $DB->get_record_sql($sql, array($user->mnethostid));
    $a = new stdclass();
    $a->remotetype = $remotehost->display_name;
    $a->remotename = $remotehost->name;
    $a->remoteurl = $remotehost->wwwroot;

    echo $OUTPUT->box(get_string('remoteuserinfo', 'mnet', $a), 'remoteuserinfo');
}

//echo '<div class="userprofilebox clearfix"><div class="profilepicture" style="text-align:center;">';
echo '<div class="userprofilebox clearfix"><div style="display:none;text-align:center;">';
echo $OUTPUT->user_picture($user, array('size' => 100));
echo '</div>';

echo '<div class="descriptionbox"><div style="display:none" class="description">';
// Print the description


if ($user->description && !isset($hiddenfields['description'])) {
    if (!empty($CFG->profilesforenrolledusersonly) && !$currentuser && !$DB->record_exists('role_assignments', array('userid' => $user->id))) {
        echo get_string('profilenotshown', 'moodle');
    } else {
        $user->description = file_rewrite_pluginfile_urls($user->description, 'pluginfile.php', $usercontext->id, 'user', 'profile', null);
        $options = array('overflowdiv' => true);
        echo format_text($user->description, $user->descriptionformat, $options);
    }
}

echo '</div>';
// Print all the little details in a list
$cfirstname = ucwords(strtolower($user->firstname));
$cmiddlename = ucwords(strtolower($user->middlename));
$clastname = ucwords(strtolower($user->lastname));

$udob = strtotime(date('d-m-Y', $user->dob) . '+ 1 days');
$ustartdate = strtotime(date('d-m-Y', $user->empstartdate) . '+ 1 days');
$ustartdate_edu = strtotime(date('d-m-Y', $user->startdate_edu) . '+ 1 days');
$ucompletion_edu = strtotime(date('d-m-Y', $user->completion_edu) . '+ 1 days');

$rolesql = mysql_query("SELECT * FROM {$CFG->prefix}role_assignments WHERE contextid='1' AND userid='" . $USER->id . "'");
$rs = mysql_fetch_array($rolesql);

echo '<fieldset style="padding: 0.6em;" id="user" class="clearfix"><legend style="font-weight:bolder;" class="ftoggler">';
if (!$currentuser) {
    echo get_string("updateprofile");
} else {
    echo get_string("general");
}
echo '</legend>';
echo '<table class="list" summary="">';
//echo $currentuser;
//if(($rs['roleid']!='10') && ($rs['roleid']!='12') && ($rs['roleid']!='13')){ 
if (!$currentuser) {
    if ($user->title == '0') {
        print_row(get_string('titlename') . ':', 'Mr');
    } else if ($user->title == '1') {
        print_row(get_string('titlename') . ':', 'Mrs');
    } else {
        print_row(get_string('titlename') . ':', 'Miss');
    }

    print_row(get_string('firstname') . ':', $cfirstname);
    if ($cmiddlename != '') {
        print_row(get_string('middlename') . ':', $cmiddlename);
    }
    print_row(get_string('lastname') . ':', $clastname);
    print_row(get_string('dob') . ':', date('d-m-Y', $udob));
    //print_row(get_string('dob') . ':', $user->dob);


    if ($user->gender == '0') {
        print_row(get_string('gender') . ':', 'Male');
    } else {
        print_row(get_string('gender') . ':', 'Female');
    }

    if ($currentuser
            or $user->maildisplay == 1
            or has_capability('moodle/course:useremail', $context)
            or ( $user->maildisplay == 2 and enrol_sharing_course($user, $USER))) {

        print_row(get_string("email") . ":", obfuscate_mailto($user->email, ''));
    }

    //if (has_capability('moodle/user:viewhiddendetails', $context)) {}
    if ($user->address != '') {
        print_row(get_string("address1") . ":", "$user->address");
    }
    if ($user->address2 != '') {
        print_row(get_string("address2") . ":", "$user->address2");
    }
    if ($user->address3 != '') {
        print_row(get_string("address3") . ":", "$user->address3");
    }

    if (!isset($hiddenfields['city']) && $user->city) {
        print_row(get_string('city') . ':', $user->city);
    } else {
        print_row(get_string('city') . ':', "-");
    }

    if (!isset($hiddenfields['postcode']) && $user->postcode) {
        print_row(get_string('zip') . ':', $user->postcode);
    } else {
        print_row(get_string('zip') . ':', "-");
    }

    if (!isset($hiddenfields['state']) && $user->state) {
        print_row(get_string('state') . ':', $user->state);
    } else {
        print_row(get_string('state') . ':', "-");
    }

    if (!isset($hiddenfields['country']) && $user->country) {
        print_row(get_string('country') . ':', get_string($user->country, 'countries'));
    } else {
        print_row(get_string('country') . ':', "-");
    }

    $selectcode = mysql_query("SELECT * FROM {$CFG->prefix}country_list WHERE countrycode='" . $user->country . "'");
    $ccode = mysql_fetch_array($selectcode);

    if ($user->phone1 != '') {
        print_row(get_string("phone") . ":", "+" . $ccode['iso_countrycode'] . "$user->phone1");
    } else {
        print_row(get_string('phone') . ':', "-");
    }
} else {

    $selectcode = mysql_query("SELECT * FROM {$CFG->prefix}country_list WHERE countrycode='" . $user->country . "'");
    $ccode = mysql_fetch_array($selectcode);
    //untuk candidate
    if (($rs['roleid'] != '10') && ($rs['roleid'] != '12') && ($rs['roleid'] != '13')) { //jika bkn exam center//business partner//hr admin
        if ($user->title == '1') {
            print_row(get_string('titlename') . ':', 'Mr');
        } else if ($user->title == '2') {
            print_row(get_string('titlename') . ':', 'Mrs');
        } else {
            print_row(get_string('titlename') . ':', 'Miss');
        }

        print_row(get_string('firstname') . ':', $cfirstname);
        if ($cmiddlename != '') {
            print_row(get_string('middlename') . ':', $cmiddlename);
        }
        print_row(get_string('lastname') . ':', $clastname);
        print_row(get_string('dob') . ':', date('d-m-Y', $udob));
        //print_row(get_string('dob') . ':', $user->dob);


        if ($user->gender == '0') {
            print_row(get_string('gender') . ':', 'Male');
        } else {
            print_row(get_string('gender') . ':', 'Female');
        }

        if ($currentuser
                or $user->maildisplay == 1
                or has_capability('moodle/course:useremail', $context)
                or ( $user->maildisplay == 2 and enrol_sharing_course($user, $USER))) {

            print_row(get_string("email") . ":", obfuscate_mailto($user->email, ''));
        }

        if ($user->address != '') {
            print_row(get_string("address1") . ":", "$user->address");
        }
        if ($user->address2 != '') {
            print_row(get_string("address2") . ":", "$user->address2");
        }
        if ($user->address3 != '') {
            print_row(get_string("address3") . ":", "$user->address3");
        }

        if (!isset($hiddenfields['city']) && $user->city) {
            print_row(get_string('city') . ':', $user->city);
        } else {
            print_row(get_string('city') . ':', "-");
        }

        if (!isset($hiddenfields['postcode']) && $user->postcode) {
            print_row(get_string('zip') . ':', $user->postcode);
        } else {
            print_row(get_string('zip') . ':', "-");
        }

        if (!isset($hiddenfields['state']) && $user->state) {
            print_row(get_string('state') . ':', $user->state);
        } else {
            print_row(get_string('state') . ':', "-");
        }

        if (!isset($hiddenfields['country']) && $user->country) {
            print_row(get_string('country') . ':', get_string($user->country, 'countries'));
        } else {
            print_row(get_string('country') . ':', "-");
        }

        $selectcode = mysql_query("SELECT * FROM {$CFG->prefix}country_list WHERE countrycode='" . $user->country . "'");
        $ccode = mysql_fetch_array($selectcode);

        if ($user->phone1 != '') {
            print_row(get_string("phone") . ":", "+" . $ccode['iso_countrycode'] . "$user->phone1");
        } else {
            print_row(get_string('phone') . ':', "-");
        }
    } else {
        //exam center//hr admin//business partner
        if ($user->title == '0') {
            print_row(get_string('titlename') . ':', 'Mr');
        } else if ($user->title == '1') {
            print_row(get_string('titlename') . ':', 'Mrs');
        } else {
            print_row(get_string('titlename') . ':', 'Miss');
        }

        print_row(get_string('firstname') . ':', $cfirstname);
        if ($cmiddlename != '') {
            print_row(get_string('middlename') . ':', $cmiddlename);
        } else {
            print_row(get_string('middlename') . ':', '-');
        }
        print_row(get_string('lastname') . ':', $clastname);
        print_row(get_string('dob') . ':', date('d-m-Y', $udob));
        //print_row(get_string('dob') . ':', $user->dob);


        if ($user->gender == '0') {
            print_row(get_string('gender') . ':', 'Male');
        } else {
            print_row(get_string('gender') . ':', 'Female');
        }

        if ($currentuser
                or $user->maildisplay == 1
                or has_capability('moodle/course:useremail', $context)
                or ( $user->maildisplay == 2 and enrol_sharing_course($user, $USER))) {

            print_row(get_string("email") . ":", obfuscate_mailto($user->email, ''));
        }

        /* if (! isset($hiddenfields['city']) && $user->city) {
          print_row(get_string('city') . ':', $user->city);
          }else{ print_row(get_string('city') . ':', "-"); }

          if (! isset($hiddenfields['country']) && $user->country) {
          print_row(get_string('country') . ':', get_string($user->country, 'countries'));
          }else{ print_row(get_string('country') . ':', "-"); } */

        if (($user->designation) != '') {
            print_row(get_string('designation') . ':', $user->designation);
        } else {
            print_row(get_string('designation') . ':', "-");
        }

        if (($user->department) != '') {
            print_row(get_string('department') . ':', $user->department);
        } else {
            print_row(get_string('department') . ':', ' - ');
        } //arizan

        /* if ($user->phone1!='') {
          print_row(get_string("worktel").":", "$user->phone1");
          }else{ print_row(get_string("worktel").":", "-"); }

          if ($user->phone1!='') {
          print_row(get_string("workfax").":", "$user->phone2");
          }else{ print_row(get_string("workfax").":", "-"); } */

        if ($user->mobile != '') {
            print_row(get_string("mobiletel") . ":", "+" . $ccode['iso_countrycode'] . "$user->mobile");
        } else {
            print_row(get_string("mobiletel") . ":", "-");
        }
    }
}
echo '</table></fieldset>';

if($user->id!='2') {
if (($rs['roleid'] != '10') && ($rs['roleid'] != '12') && ($rs['roleid'] != '13')) { //jika bkn exam center//business partner//hr admin
    echo '<fieldset style="padding: 0.6em;" id="user" class="clearfix"><legend style="font-weight:bolder;" class="ftoggler">' . get_string('employmentbg') . '</legend>';
    echo '<table class="list" summary="">';

    if (($user->empstatus) != '') {
        if (($user->empstatus) == '1') {
            print_row(get_string('empstatus') . ':', get_string('working'));
        }
        if (($user->empstatus) == '2') {
            print_row(get_string('empstatus') . ':', get_string('notworking'));
        }
        if (($user->empstatus) == '3') {
            print_row(get_string('empstatus') . ':', get_string('student'));
        }
    } else {
        print_row(get_string('empstatus') . ':', '-');
    }

    if (($user->access_token) != '') {
        print_row(get_string('employeeid') . ':', $user->access_token);
    } else {
        print_row(get_string('employeeid') . ':', '-');
    }

    if (($user->empname) != '') {
        print_row(get_string('empname') . ':', $user->empname);
    } else {
        print_row(get_string('empname') . ':', '-');
    }

    if (($user->designation) != '') {
        print_row(get_string('designation') . ':', $user->designation);
    } else {
        print_row(get_string('designation') . ':', '-');
    }

    if (($user->department) != '') {
        if (($user->empstatus) != '1') {
            print_row(get_string('department') . ':', ' - ');
        } else {
            print_row(get_string('department') . ':', $user->department);
        } //arizan
    } else {
        print_row(get_string('department') . ':', '-');
    }

    if (($user->empstartdate) != '') {
        if (($user->empstatus) != '1') {
            print_row(get_string('empstartdate') . ':', ' - ');
        } else {
            print_row(get_string('empstartdate') . ':', date('d-m-Y', $ustartdate));
        }
    } else {
        print_row(get_string('empstartdate') . ':', '-');
    }
    echo '</table></fieldset>';
}

// if(!$currentuser) {
// if(($rs['roleid']!='10') && ($rs['roleid']!='12') && ($rs['roleid']!='13')){	//jika bkn exam center
// echo get_string('educationbg'); 	// active user
// }
// }else{
// echo get_string('institutiondetails'); //exam center
// }
// echo '</legend>';
// echo '<table class="list" summary="">';
//if(!$currentuser) {
if (($rs['roleid'] != '10') && ($rs['roleid'] != '12') && ($rs['roleid'] != '13')) { //jika bkn exam center
    echo '<fieldset style="padding: 0.6em;" id="user" class="clearfix">';
    echo '<legend style="font-weight:bolder;" class="ftoggler">' . get_string('educationbg') . '</legend>';
    echo '<table class="list" summary="">';
    if (($user->highesteducation) != '0') {
        if (($user->highesteducation) == '1') {
            print_row(get_string('highesteducation') . ':', get_string('highesteducation1'));
        }
        if (($user->highesteducation) == '2') {
            print_row(get_string('highesteducation') . ':', get_string('highesteducation2'));
        }
        if (($user->highesteducation) == '3') {
            print_row(get_string('highesteducation') . ':', get_string('highesteducation3'));
        }
        if (($user->highesteducation) == '4') {
            print_row(get_string('highesteducation') . ':', get_string('highesteducation4'));
        }
        if (($user->highesteducation) == '5') {
            print_row(get_string('highesteducation') . ':', get_string('highesteducation5'));
        }
    } else {
        print_row(get_string('highesteducation') . ':', '-');
    }

    if (($user->yearcomplete_edu) != '') {
        if (($user->highesteducation) == '') {
            print_row(get_string('yearcomplete') . ':', ' - ');
        } else {
            print_row(get_string('yearcomplete') . ':', $user->yearcomplete_edu);
        }
    } else {
        print_row(get_string('yearcomplete') . ':', '-');
    }

    if (($user->professionalcert) != '') {
        if (($user->professionalcert) == '1') {
            print_row(get_string('professionalcert') . ':', get_string('certificate0'));
        }
        if (($user->professionalcert) == '2') {
            print_row(get_string('professionalcert') . ':', get_string('certificate1'));
        }
        if (($user->professionalcert) == '3') {
            print_row(get_string('professionalcert') . ':', get_string('certificate2'));
        }
        if (($user->professionalcert) == '4') {
            print_row(get_string('professionalcert') . ':', get_string('certificate3'));
        }
        if (($user->professionalcert) == '5') {
            print_row(get_string('professionalcert') . ':', get_string('certificate4'));
        }
        if (($user->professionalcert) == '6') {
            print_row(get_string('professionalcert') . ':', get_string('certificate5'));
        }
        if (($user->professionalcert) == '7') {
            print_row(get_string('professionalcert') . ':', get_string('certificate6'));
        }
        if (($user->professionalcert) == '8') {
            print_row(get_string('professionalcert') . ':', get_string('certificate7'));
        }
        if (($user->professionalcert) == '9') {
            print_row(get_string('professionalcert') . ':', get_string('certificate8'));
        }
        if (($user->professionalcert) == '10') {
            print_row(get_string('professionalcert') . ':', get_string('certificate9'));
        }
        if (($user->professionalcert) == '11') {
            print_row(get_string('professionalcert') . ':', get_string('certificate10'));
        }
        if (($user->professionalcert) == '12') {
            print_row(get_string('professionalcert') . ':', get_string('certificate11'));
        }
    } else {
        print_row(get_string('professionalcert') . ':', '-');
    }

    if (($user->nameofqualification) != '') {
        if (($user->professionalcert) == '') {
            print_row(get_string('nameofqualification') . ':', ' - ');
        } else {
            print_row(get_string('nameofqualification') . ':', $user->nameofqualification);
        }
    } else {
        print_row(get_string('nameofqualification') . ':', '-');
    }


    if (($user->yearcomplete) != '') {
        if (($user->professionalcert) == '') {
            print_row(get_string('yearcomplete') . ':', ' - ');
        } else {
            print_row(get_string('yearcomplete') . ':', $user->yearcomplete);
        }
    } else {
        print_row(get_string('yearcomplete') . ':', '-');
    }

    if (($user->college_edu) != '') {
        print_row(get_string('college') . ':', $user->college_edu);
    } else {
        print_row(get_string('college') . ':', '-');
    }

    if (($user->major_edu) != '') {
        print_row(get_string('major') . ':', $user->major_edu);
    } else {
        print_row(get_string('major') . ':', '-');
    }

    if (($user->startdate_edu) != ($user->completion_edu)) {
        print_row(get_string('empstartdate') . ':', date('d-m-Y', $ustartdate_edu));
    } else {
        print_row(get_string('empstartdate') . ':', '-');
    }

    if (($user->completion_edu) != ($user->startdate_edu)) {
        print_row(get_string('completiondate') . ':', date('d-m-Y', $ucompletion_edu));
    } else {
        print_row(get_string('completiondate') . ':', '-');
    }
    echo '</table></fieldset>';
    //}	
} else { //if exam center	
    if ($currentuser) {
        $sinstitude = mysql_query("SELECT * FROM {$CFG->prefix}organization_type WHERE id='" . $user->orgtype . "' AND status='0'");
        $qins = mysql_fetch_array($sinstitude);
        $imglink = $CFG->wwwroot . '/financialinstituition/' . $qins['path_logo'];

        echo '<fieldset style="padding: 0.6em;" id="user" class="clearfix">';
        echo '<legend style="font-weight:bolder;" class="ftoggler">' . get_string('institutiondetails') . '</legend>';

        echo '<div style="margin:1em 0"><img src="' . $imglink . '" alt="' . $imglink . '" title="' . $imglink . '" width="200"></div>';

        echo '<table class="list" summary="">';
        if ($user->institution != '') {
            print_row(get_string("institutionname") . ":", "$user->institution");
        } else {
            print_row(get_string("institutionname") . ":", "-");
        }

        if ($user->address != '') {
            print_row(get_string("address1") . ":", "$user->address");
        } else {
            print_row(get_string("address1") . ":", "-");
        }

        if ($user->address2 != '') {
            print_row(get_string("address2") . ":", "$user->address2");
        } else {
            print_row(get_string("address2") . ":", "-");
        }

        if ($user->address3 != '') {
            print_row(get_string("address3") . ":", "$user->address3");
        } else {
            print_row(get_string("address3") . ":", "-");
        }

        if (!isset($hiddenfields['city']) && $user->city) {
            print_row(get_string('city') . ':', $user->city);
        } else {
            print_row(get_string('city') . ':', "-");
        }

        // if (! isset($hiddenfields['postcode']) && $user->postcode) {
        if ($user->postcode != '0') {
            print_row(get_string('zip') . ':', $user->postcode);
        }// else{ print_row(get_string('zip') . ':', "-"); }		

        if (!isset($hiddenfields['state']) && $user->state) {
            print_row(get_string('state') . ':', $user->state);
        } else {
            print_row(get_string('state') . ':', "-");
        }

        if (!isset($hiddenfields['country']) && $user->country) {
            print_row(get_string('country') . ':', get_string($user->country, 'countries'));
        } else {
            print_row(get_string('country') . ':', "-");
        }

        if ($user->orgtel != '') {
            print_row(get_string("worktel") . ":", "+" . $ccode['iso_countrycode'] . "$user->orgtel");
        } else {
            print_row(get_string("worktel") . ":", "-");
        }

        if ($user->orgfax != '') {
            print_row(get_string("workfax") . ":", "+" . $ccode['iso_countrycode'] . "$user->orgfax");
        } else {
            print_row(get_string("workfax") . ":", "-");
        }

        if ($user->url) {
            $url = $user->url;
            if (strpos($user->url, '://') === false) {
                $url = 'http://' . $url;
            }
            print_row(get_string("website") . ":", '<a href="' . s($url) . '">' . s($user->url) . '</a>');
        } else {
            print_row(get_string("website") . ":", "-");
        }

        if ($user->ipaddress != '') {
            print_row(get_string("ip_address") . ":", "$user->ipaddress");
        } else {
            print_row(get_string("ip_address") . ":", "-");
        }

        echo '</table></fieldset>';
    }
}

if ($currentuser) {
    if (($rs['roleid'] != '10') && ($rs['roleid'] != '12') && ($rs['roleid'] != '13')) { //jika bkn exam center
        echo '<fieldset style="padding: 0.6em;" id="user" class="clearfix"><legend style="font-weight:bolder;" class="ftoggler">' . get_string('communicationpreferences') . '</legend>';
        echo '<table class="list" summary="">';
        print_row('', '<h6>Please read the options in this column carefully:-</h6>');
        /* if (($user->compreference1)!='') {
          print_row('<input type="checkbox" name="cm1" value="1" checked disabled /> ', '<div style="text-align:justify;">'.get_string('compreference1').'</div>');
          } */
        if (($user->compreference2) != '') {
            if ($user->compreference2 == '1') {
                print_row('<input type="checkbox" name="cm1" value="1" checked disabled /> ', '<div style="text-align:justify;">' . get_string('compreference2') . '</div>');
            } else {
                print_row('<input type="checkbox" name="cm1" value="0" disabled /> ', '<div style="text-align:justify;">' . get_string('compreference2') . '</div>');
            }
        }
        if (($user->compreference3) != '') {
            //popup
            $a = new stdClass();

            $policy = $CFG->wwwroot . '/userpolicy.php';
            $a = "<a href=\"javascript:void(0);\" onclick=\"popupwindow('" . $policy . "', 'myPop1',820,600);\"><u><b>" . get_string('cifaonlinepolicy') . "</b></u></a>";
            //End popup		

            print_row('<input type="checkbox" name="cm1" value="1" checked disabled /> ', '<div style="text-align:justify;">' . get_string('compreference3_1') . get_string('compreference3', '', $a) . '<font color="red"> *</font></div>');
        }
        echo '</table></fieldset>';
    }
}
} // if not administrator
/* if (has_capability('moodle/user:viewhiddendetails', $context)) { get_string('compreference1')
  if ($user->address) {
  print_row(get_string("address").":", "$user->address");
  }
  if ($user->phone1) {
  print_row(get_string("phone").":", "$user->phone1");
  }
  if ($user->phone2) {
  print_row(get_string("phone2").":", "$user->phone2");
  }
  } */

/* if ($currentuser
  or $user->maildisplay == 1
  or has_capability('moodle/course:useremail', $context)
  or ($user->maildisplay == 2 and enrol_sharing_course($user, $USER))) {

  print_row(get_string("email").":", obfuscate_mailto($user->email, ''));
  } */

if ($user->url && !isset($hiddenfields['webpage'])) {
    $url = $user->url;
    if (strpos($user->url, '://') === false) {
        $url = 'http://' . $url;
    }
    //print_row(get_string("webpage") .":", '<a href="'.s($url).'">'.s($user->url).'</a>');
}

if ($user->icq && !isset($hiddenfields['icqnumber'])) {
    print_row(get_string('icqnumber') . ':', "<a href=\"http://web.icq.com/wwp?uin=" . urlencode($user->icq) . "\">" . s($user->icq) . " <img src=\"http://web.icq.com/whitepages/online?icq=" . urlencode($user->icq) . "&amp;img=5\" alt=\"\" /></a>");
}

if ($user->skype && !isset($hiddenfields['skypeid'])) {
    print_row(get_string('skypeid') . ':', '<a href="callto:' . urlencode($user->skype) . '">' . s($user->skype) .
            ' <img src="http://mystatus.skype.com/smallicon/' . urlencode($user->skype) . '" alt="' . get_string('status') . '" ' .
            ' /></a>');
}
if ($user->yahoo && !isset($hiddenfields['yahooid'])) {
    print_row(get_string('yahooid') . ':', '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . urlencode($user->yahoo) . '&amp;.src=pg">' . s($user->yahoo) . " <img src=\"http://opi.yahoo.com/online?u=" . urlencode($user->yahoo) . "&m=g&t=0\" alt=\"\"></a>");
}
if ($user->aim && !isset($hiddenfields['aimid'])) {
    print_row(get_string('aimid') . ':', '<a href="aim:goim?screenname=' . urlencode($user->aim) . '">' . s($user->aim) . '</a>');
}
if ($user->msn && !isset($hiddenfields['msnid'])) {
    //print_row(get_string('msnid').':', s($user->msn));
}

/// Print the Custom User Fields
profile_display_fields($user->id);

if (!isset($hiddenfields['mycourses'])) {
    if ($mycourses = enrol_get_users_courses($user->id, true, NULL, 'visible DESC,sortorder ASC')) {
        $shown = 0;
        $courselisting = '';
        foreach ($mycourses as $mycourse) {
            if (($mycourse->category == '1') || ($mycourse->category == '3')) { //add by arizan abdullah 23052012
                if ($mycourse->category) {
                    $class = '';
                    if ($mycourse->visible == 0) {
                        $ccontext = get_context_instance(CONTEXT_COURSE, $mycourse->id);
                        if (!has_capability('moodle/course:viewhiddencourses', $ccontext)) {
                            continue;
                        }
                        $class = 'class="dimmed"';
                    }
                    $courselisting .= "<a href=\"{$CFG->wwwroot}/user/view.php?id={$user->id}&amp;course={$mycourse->id}\" $class >" . format_string($mycourse->fullname) . "</a>, ";
                }
                $shown++;
                if ($shown == 20) {
                    $courselisting.= "...";
                    break;
                }
            }
        }
        //remove by arizan abdullah 20121003
        //print_row(get_string('courseprofiles').':', rtrim($courselisting,', '));
    }
}
/*
  if (!isset($hiddenfields['firstaccess'])) {
  if ($user->firstaccess) {
  $datestring = userdate($user->firstaccess)."&nbsp; (".format_time(time() - $user->firstaccess).")";
  } else {
  $datestring = get_string("never");
  }
  print_row(get_string("firstaccess").":", $datestring);
  }
  if (!isset($hiddenfields['lastaccess'])) {
  if ($user->lastaccess) {
  $datestring = userdate($user->lastaccess)."&nbsp; (".format_time(time() - $user->lastaccess).")";
  } else {
  $datestring = get_string("never");
  }
  print_row(get_string("lastaccess").":", $datestring);
  }
 */

/// Printing tagged interests
if (!empty($CFG->usetags)) {
    if ($interests = tag_get_tags_csv('user', $user->id)) {
        print_row(get_string('interests') . ": ", $interests);
    }
}
echo "</div></div>";
echo "<div style='text-align:center;padding-top:10px;'>";
?>
<form id="form1" name="form1" method="post" action="">
    <div class="editprofilebutton"><input type="submit" name="editprofile" onClick="this.form.action = '<?= $CFG->wwwroot . '/user/edit.php?id=' . $user->id . '&course=1'; ?>'" value="<?= ucwords(strtolower(get_string('editmyprofile'))); ?> Profile" />
<?php if (($rs['roleid'] != '10') && ($rs['roleid'] != '12') && ($rs['roleid'] != '13')) { ?>
            <input type="submit" name="backhome" onClick="this.form.action = '<?= $CFG->wwwroot . '/index.php'; ?>'" value="<?= ucwords(strtolower(get_string('cancel'))); ?>" />
<?php } else { ?>
            <input type="submit" name="backhome" onClick="this.form.action = '<?= $CFG->wwwroot . '/candidatemanagement/cifacandidatemanagement.php?id=' . $user->id; ?>'" value="<?= ucwords(strtolower(get_string('cancel'))); ?>" />
<?php } ?>
    </div>

</form>
<?php
echo "</div>";
echo $OUTPUT->blocks_for_region('content');

// Print messaging link if allowed
if (isloggedin() && has_capability('moodle/site:sendmessage', $context) && !empty($CFG->messaging) && !isguestuser() && !isguestuser($user) && ($USER->id != $user->id)) {
    echo '<div class="messagebox">';
    //echo '<a href="'.$CFG->wwwroot.'/message/index.php?id='.$user->id.'">'.get_string('messageselectadd').'</a>';
    echo '</div>';
}

if ($CFG->debugdisplay && debugging('', DEBUG_DEVELOPER) && $currentuser) {  // Show user object
    echo '<br /><br /><hr />';
    echo $OUTPUT->heading('DEBUG MODE:  User session variables');
    print_object($USER);
}

echo '</div>';  // userprofile class
echo '<br/><br/>';
echo $OUTPUT->footer();

function print_row($left, $right) {
    echo "\n<tr><td class=\"label c0\">$left</td><td class=\"info c1\">$right</td></tr>\n";
}
?>
<script language="javascript">
    function popupwindow(url, title, w, h) {
        var left = (screen.width / 2) - (w / 2);
        var top = (screen.height / 2) - (h / 2);
        return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    }
</script>
