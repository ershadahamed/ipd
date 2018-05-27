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
 * Forgot password routine.
 *
 * Finds the user and calls the appropriate routine for their authentication type.
 *
 * @package    core
 * @subpackage auth
 * @copyright  1999 onwards Martin Dougiamas  http://dougiamas.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../config.php');
require_once('forgot_password_form.php');
require_once('forgot_password_form_contactus.php');

$p_secret   = optional_param('p', false, PARAM_RAW);
$p_username = optional_param('s', false, PARAM_RAW);

//HTTPS is required in this page when $CFG->loginhttps enabled
$PAGE->https_required();

$PAGE->set_url('/login/forgot_password.php');
$systemcontext = get_context_instance(CONTEXT_SYSTEM);
$PAGE->set_context($systemcontext);

// setup text strings
$strforgotten = get_string('passwordforgotten');
$strlogin     = get_string('login');

$PAGE->navbar->add($strlogin, get_login_url());
$PAGE->navbar->add($strforgotten);
$PAGE->set_title($strforgotten);
$PAGE->set_heading($COURSE->fullname);

// if alternatepasswordurl is defined, then we'll just head there
if (!empty($CFG->forgottenpasswordurl)) {
    redirect($CFG->forgottenpasswordurl);
}

// if you are logged in then you shouldn't be here!
if (isloggedin() and !isguestuser()) {
    redirect($CFG->wwwroot.'/index.php', get_string('loginalready'), 5);
}

if ($p_secret !== false) {
///=====================
/// user clicked on link in email message
///=====================

    update_login_count();

    $user = $DB->get_record('user', array('username'=>$p_username, 'mnethostid'=>$CFG->mnet_localhost_id, 'deleted'=>0, 'suspended'=>0));

    if ($user and ($user->auth === 'nologin' or !is_enabled_auth($user->auth))) {
        // bad luck - user is not able to login, do not let them reset password
        $user = false;
    }

    if (!empty($user) and $user->secret === '') {
        echo $OUTPUT->header();
        print_error('secretalreadyused');
    } else if (!empty($user) and $user->secret == $p_secret) {
        // make sure that url relates to a valid user

        // check this isn't guest user
        if (isguestuser($user)) {
            print_error('cannotresetguestpwd');
        }

        // make sure user is allowed to change password
        require_capability('moodle/user:changeownpassword', $systemcontext, $user->id);

        if (!reset_password_and_mail($user)) {
            print_error('cannotresetmail');
        }

        // Clear secret so that it can not be used again
        $user->secret = '';
        $DB->set_field('user', 'secret', $user->secret, array('id'=>$user->id));

        reset_login_count();

        $changepasswordurl = "{$CFG->httpswwwroot}/login/change_password.php";
		$site  = get_site();
        $a = new stdClass();
        $a->email = $user->email;
        $a->link = $changepasswordurl;
		$a->sitename = format_string($site->fullname);

        echo $OUTPUT->header();
        notice(get_string('emailpasswordsent', '', $a), $changepasswordurl);

    } else {
        if (!empty($user) and strlen($p_secret) === 15) {
            // somebody probably tries to hack in by guessing secret - stop them!
            $DB->set_field('user', 'secret', '', array('id'=>$user->id));
        }
        echo $OUTPUT->header();
        print_error('forgotteninvalidurl');
    }

    die; //never reached
}

$mform = new login_forgot_password_form();
$mform2 = new login_forgot_password_form_contactus();

if ($mform->is_cancelled()) {
    redirect(get_login_url());

} else if ($data = $mform->get_data()) {
/// find the user in the database and mail info

    // first try the username
    if (!empty($data->username)) {
        $username = textlib_get_instance()->strtolower($data->username); // mimic the login page process, if they forget username they need to use email for reset
        $user = $DB->get_record('user', array('username'=>$username, 'mnethostid'=>$CFG->mnet_localhost_id, 'deleted'=>0, 'suspended'=>0));

	} else {
        // this is tricky because
        // 1/ the email is not guaranteed to be unique - TODO: send email with all usernames to select the correct account for pw reset
        // 2/ mailbox may be case sensitive, the email domain is case insensitive - let's pretend it is all case-insensitive

        $select = $DB->sql_like('email', ':email', false, true, false, '|'). " AND mnethostid = :mnethostid AND deleted=0 AND suspended=0";
        $params = array('email'=>$DB->sql_like_escape($data->email, '|'), 'mnethostid'=>$CFG->mnet_localhost_id);
        $user = $DB->get_record_select('user', $select, $params, '*', IGNORE_MULTIPLE);
    }
	
    if(!empty($data->securityquestionid)){ //sequrity question
		$securityquestionid = textlib_get_instance()->strtolower($data->securityquestionid);
		$user = $DB->get_record('user', array('securityquestionid'=>$securityquestionid, 'mnethostid'=>$CFG->mnet_localhost_id, 'deleted'=>0, 'suspended'=>0));
	}
	
	if(!empty($data->sqanswer)){ //sequrity answer
		$sqanswer = textlib_get_instance()->strtolower($data->sqanswer);
		$user = $DB->get_record('user', array('sqanswer'=>$sqanswer, 'mnethostid'=>$CFG->mnet_localhost_id, 'deleted'=>0, 'suspended'=>0));	
	}
	
    if ($user and !empty($user->confirmed)) {

        $userauth = get_auth_plugin($user->auth);
        if (has_capability('moodle/user:changeownpassword', $systemcontext, $user->id)) {
            // send email
        }

        if ($userauth->can_reset_password() and is_enabled_auth($user->auth)
          and has_capability('moodle/user:changeownpassword', $systemcontext, $user->id)) {
            // send reset password confirmation

            // set 'secret' string
            $user->secret = random_string(15);
            $DB->set_field('user', 'secret', $user->secret, array('id'=>$user->id));

            if (!send_password_change_confirmation_email($user)) {
                print_error('cannotmailconfirm');
            }

        } else {
            if (!send_password_change_info($user)) {
                print_error('cannotmailconfirm');
            }
        }
    }

    echo $OUTPUT->header();

    if (empty($user->email) or !empty($CFG->protectusernames)) {
		if(!$user->email){
			notice(get_string('emailpasswordwrong'), $CFG->wwwroot.'/index.php'); //added by arizan abdullah
		}else{
			$sql=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE deleted='0' AND (username='".$data->username."' OR email='".$data->email."') AND securityquestionid='".$data->securityquestionid."' AND sqanswer='".$data->sqanswer."'");
			$sqlcount=mysql_num_rows($sql);
			if($sqlcount!=0){
				// Print general confirmation message
				notice(get_string('emailpasswordconfirmmaybesent'), $CFG->wwwroot.'/index.php');			
			}else{
				notice(get_string('emailpasswordwrong'), $CFG->wwwroot.'/index.php'); 
			}
		}
	}else {	
		$sql=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE deleted='0' AND (username='".$data->username."' OR email='".$data->email."') AND securityquestionid='".$data->securityquestionid."' AND sqanswer='".$data->sqanswer."'");
		$sqlcount=mysql_num_rows($sql);
		if($sqlcount!=0){
			// Confirm email sent
			$protectedemail = preg_replace('/([^@]*)@(.*)/', '******@$2', $user->email); // obfuscate the email address to protect privacy
			$stremailpasswordconfirmsent = get_string('emailpasswordconfirmsent', '', $protectedemail);
			notice($stremailpasswordconfirmsent, $CFG->wwwroot.'/index.php');			
		}
    }

    die; // never reached
}

// make sure we really are on the https page when https login required
$PAGE->verify_https_required();


/// DISPLAY FORM

echo $OUTPUT->header();
$a = new stdClass();
//$a = '<a href="" target="_blank" title="Contact Us"><u>contact@learncifa.com</u></a>';
$a = '<b>Contact Us</b>';
echo $OUTPUT->box(get_string('passwordforgotteninstructions2', '', $a), 'generalbox boxwidthnormal boxaligncenter');
$mform->display();
echo $OUTPUT->box(get_string('ifstillcannotlogging', '', $a), 'generalbox boxwidthnormal boxaligncenter');
$mform2->display();
//echo '<fieldset style="padding: 0.6em;" id="user" class="clearfix"><legend style="font-weight:bolder;" class="ftoggler">'.get_string('contactus').'</legend>';
?>
<!--table width="100%" border="0">
  <tr>
    <td width="15%" style="text-align:right" scope="row">Fullname</td>
    <td><input type="text" name="fullname" id="fullname" size="40" maxlength="100" /></td>
  </tr>
  <tr>
    <td style="text-align:right" scope="row">D.O.B (DD:MM:YY)</td>
    <td><input type="text" name="dob" id="dob" /></td>
  </tr>
  <tr>
    <td style="text-align:right" scope="row">
		Subject
			<img class="req" src="<?=$CFG->wwwroot;?>/theme/image.php?theme=aardvark&image=req&rev=1006" alt="Required field" title="Required field">
				
	</td>
    <td><input type="text" name="subject" id="subject" size="40" maxlength="100" /></td>
  </tr>
  <tr>
    <td style="text-align:right" scope="row">
		<div class="fitemtitle">Message
			<img class="req" src="http://localhost/shape/theme/image.php?theme=aardvark&image=req&rev=1006" alt="Required field" title="Required field">
		</div>	
	</td>
    <td><input type="text" name="contactmessage" id="contactmessage" /></td>
  </tr>
</table>
<div class="felement fsubmit" align="center">
<input id="id_submitbuttonemail" type="submit" value="Submit" name="submitbuttonemail">
</div-->

<?php //echo '</fieldset>'; ?>
 
<script type="text/javascript">
function f(o){o.value=o.value.toUpperCase().replace(/([\w&`'??"?.@:\/\{\(\[<>_]+-? *^0-9A-Z])/g,"");}
</script>
<script type="text/javascript">
String.prototype.toTitleCase = function() {
    return this.replace(/([\w&`'??"?.@:\/\{\(\[<>_]+-? *)/g, function(match, p1, index, title) {
        if (index > 0 && title.charAt(index - 2) !== ":" &&
        	match.search(/^(a(nd?|s|t)?|b(ut|y)|en|for|i[fn]|o[fnr]|t(he|o)|vs?\.?|via)[ \-]/i) > -1)
            return match.toLowerCase();
        if (title.substring(index - 1, index + 1).search(/['"_{(\[]/) > -1)
            return match.charAt(0) + match.charAt(1).toUpperCase() + match.substr(2);
        if (match.substr(1).search(/[A-Z]+|&|[\w]+[._][\w]+/) > -1 || 
        	title.substring(index - 1, index + 1).search(/[\])}]/) > -1)
            return match;
        return match.charAt(0).toUpperCase() + match.substr(1);
    });
};
</script>
<?php
echo $OUTPUT->footer();
