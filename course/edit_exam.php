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
 * Edit course settings
 *
 * @package    moodlecore
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../config.php');
require_once('lib.php');
require_once('edit_form_exam.php');
//require_once('email.php');

$id         = optional_param('id', 0, PARAM_INT);       // course id
$categoryid = optional_param('category', 0, PARAM_INT); // course category - can be changed in edit form
$returnto = optional_param('returnto', 0, PARAM_ALPHANUM); // generic navigation return page switch

//aa
$PAGE->set_pagelayout('admin');
$PAGE->set_url('/course/edit.php');

// basic access control checks
if ($id) { // editing course
    if ($id == SITEID){
        // don't allow editing of  'site course' using this from
        print_error('cannoteditsiteform');
    }

    $course = $DB->get_record('course', array('id'=>$id), '*', MUST_EXIST);
    require_login($course);
    $category = $DB->get_record('course_categories', array('id'=>$course->category), '*', MUST_EXIST);
    $coursecontext = get_context_instance(CONTEXT_COURSE, $course->id);
    require_capability('moodle/course:update', $coursecontext);
    $PAGE->url->param('id',$id);

} else if ($categoryid) { // creating new course in this category
    $course = null;
    require_login();
    $category = $DB->get_record('course_categories', array('id'=>$categoryid), '*', MUST_EXIST);
    $catcontext = get_context_instance(CONTEXT_COURSECAT, $category->id);
    require_capability('moodle/course:create', $catcontext);
    $PAGE->url->param('category',$categoryid);
    $PAGE->set_context($catcontext);

} else {
    require_login();
    print_error('needcoursecategroyid');
}

// Prepare course and the editor
$editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'maxbytes'=>$CFG->maxbytes, 'trusttext'=>false, 'noclean'=>true);
if (!empty($course)) {
    $allowedmods = array();
    if ($am = $DB->get_records('course_allowed_modules', array('course'=>$course->id))) {
        foreach ($am as $m) {
            $allowedmods[] = $m->module;
        }
    } else {
        // this happens in case we edit course created before enabling module restrictions or somebody disabled everything :-(
        if (empty($course->restrictmodules) and !empty($CFG->defaultallowedmodules)) {
            $allowedmods = explode(',', $CFG->defaultallowedmodules);
        }
    }
    $course->allowedmods = $allowedmods;
    $course = file_prepare_standard_editor($course, 'summary', $editoroptions, $coursecontext, 'course', 'summary', 0);

} else {
    $course = file_prepare_standard_editor($course, 'summary', $editoroptions, null, 'course', 'summary', null);
}

// first create the form
$editform = new course_edit_form(NULL, array('course'=>$course, 'category'=>$category, 'editoroptions'=>$editoroptions, 'returnto'=>$returnto));
if ($editform->is_cancelled()) {
        switch ($returnto) {
            case 'category':
                $url = new moodle_url($CFG->wwwroot.'/course/category.php', array('id'=>$categoryid));
                break;
            case 'topcat':
                $url = new moodle_url($CFG->wwwroot.'/course/');
                break;
            default:
                if (!empty($course->id)) {
                    $url = new moodle_url($CFG->wwwroot.'/course/view.php', array('id'=>$course->id));
                } else {
                    $url = new moodle_url($CFG->wwwroot.'/course/');
                }
                break;
        }
        redirect($url);

} else if ($data = $editform->get_data()) {
    // process data if submitted

    if (empty($course->id)) {
        // In creating the course
        $course = create_course($data, $editoroptions);

        // Get the context of the newly created course
        $context = get_context_instance(CONTEXT_COURSE, $course->id, MUST_EXIST);

        if (!empty($CFG->creatornewroleid) and !is_viewing($context, NULL, 'moodle/role:assign') and !is_enrolled($context, NULL, 'moodle/role:assign')) {
            // deal with course creators - enrol them internally with default role
            enrol_try_internal_enrol($course->id, $USER->id, $CFG->creatornewroleid);

        }
        if (!is_enrolled($context)) {
            // Redirect to manual enrolment page if possible
            $instances = enrol_get_instances($course->id, true);
            foreach($instances as $instance) {
                if ($plugin = enrol_get_plugin($instance->enrol)) {
                    if ($plugin->get_manual_enrol_link($instance)) {
                        // we know that the ajax enrol UI will have an option to enrol
						
						///*************************emel notification for exam centre when added new exam details**********************************************/////////////
						include('../manualdbconfig.php');
						
						function authgMail($from, $namefrom, $to, $nameto, $subject, $message) {
						
						$sqlEmail="
								Select
								  a.name,
								  a.value,
								  a.id
								From
								  mdl_cifaconfig a
								Where
								  (a.name = 'smtphosts') Or
								  (a.name = 'smtpuser') Or
								  (a.name = 'smtppass')";
								  
						$queryEmail=mysql_query($sqlEmail);
						$rowEmail=mysql_fetch_array($queryEmail);
						
						if($rowEmail['name']=='smtphosts'){ $smtpEmail=$rowEmail['value']; }
						if($rowEmail['name']=='smtpuser'){ $smtpUser=$rowEmail['value']; }
						if($rowEmail['name']=='smtppass'){ $smtppass=$rowEmail['value']; }
						
						$smtpServer = $smtpEmail; //"pop.mmsc.com.my";   //ip address of the mail server.  This can also be the local domain name
						$port = "25";					 // should be 25 by default, but needs to be whichever port the mail server will be using for smtp 
						$timeout = "45";				 // typical timeout. try 45 for slow servers
						$username = $smtpUser;//"mohd.arizan/mmsc.com.my"; // the login for your smtp
						$password = $smtppass;//"mohdarizan123";			// the password for your smtp
						$localhost = "127.0.0.1";	   // Defined for the web server.  Since this is where we are gathering the details for the email
						$newLine = "\r\n";			 // aka, carrage return line feed. var just for newlines in MS
						$secure = 0;				  // change to 1 if your server is running under SSL
						
						//connect to the host and port
						$smtpConnect = fsockopen($smtpServer, $port, $errno, $errstr, $timeout);
						$smtpResponse = fgets($smtpConnect, 4096);
						if(empty($smtpConnect)) {
						   $output = "Failed to connect: $smtpResponse";
						   //echo $output;
						   echo "Not send";
						   return $output;
						}
						else {
						   $logArray['connection'] = "<p>Connected to: $smtpResponse";
						   //echo "<p />connection accepted<br>".$smtpResponse."<p />Continuing<p />";
						   
						   //echo "<p>Thank your for subscribed our module $name.</p>";
						}

						//you have to say HELO again after TLS is started
						fputs($smtpConnect, "HELO $localhost". $newLine);
						$smtpResponse = fgets($smtpConnect, 4096);
						$logArray['heloresponse2'] = "$smtpResponse";
						   
						//request for auth login
						fputs($smtpConnect,"AUTH LOGIN" . $newLine);
						$smtpResponse = fgets($smtpConnect, 4096);
						$logArray['authrequest'] = "$smtpResponse";

						//send the username
						fputs($smtpConnect, base64_encode($username) . $newLine);
						$smtpResponse = fgets($smtpConnect, 4096);
						$logArray['authusername'] = "$smtpResponse";

						//send the password
						fputs($smtpConnect, base64_encode($password) . $newLine);
						$smtpResponse = fgets($smtpConnect, 4096);
						$logArray['authpassword'] = "$smtpResponse";

						//email from
						fputs($smtpConnect, "MAIL FROM: <$from>" . $newLine);
						$smtpResponse = fgets($smtpConnect, 4096);
						$logArray['mailfromresponse'] = "$smtpResponse";

						//email to
						fputs($smtpConnect, "RCPT TO: <$to>" . $newLine);
						$smtpResponse = fgets($smtpConnect, 4096);
						$logArray['mailtoresponse'] = "$smtpResponse";

						//the email
						fputs($smtpConnect, "DATA" . $newLine);
						$smtpResponse = fgets($smtpConnect, 4096);
						$logArray['data1response'] = "$smtpResponse";

						//construct headers
						$headers = "MIME-Version: 1.0" . $newLine;
						$headers .= "Content-type: text/html; charset=iso-8859-1" . $newLine;
						$headers .= "To: $nameto <$to>" . $newLine;
						$headers .= "From: $namefrom <$from>" . $newLine;

						//observe the . after the newline, it signals the end of message
						fputs($smtpConnect, "To: $to\r\nFrom: $from\r\nSubject: $subject\r\n$headers\r\n\r\n$message\r\n.\r\n");
						$smtpResponse = fgets($smtpConnect, 4096);
						$logArray['data2response'] = "$smtpResponse";

						// say goodbye
						fputs($smtpConnect,"QUIT" . $newLine);
						$smtpResponse = fgets($smtpConnect, 4096);
						$logArray['quitresponse'] = "$smtpResponse";
						$logArray['quitcode'] = substr($smtpResponse,0,3);
						fclose($smtpConnect);
						//a return value of 221 in $retVal["quitcode"] is a success
						return($logArray);
					}						
						
						$sqlsemak=mysql_query("Select * From mdl_cifarole_assignments Where contextid='1'");
						$semakrow=mysql_fetch_array($sqlsemak);
						if($semakrow['roleid'] == '16'){
						
							$qry = "SELECT * FROM mdl_cifauser a WHERE a.id='".$semakrow['userid']."'";
							$sql = mysql_query($qry); 

							while($rs = mysql_fetch_array($sql)){ 
								//$coursename=$rs['fullname'];
								//$shortcoursename=$rs['shortname'];
								$email=$rs['email'];
								//$userenrolid=$rs['userid'];
								//$enrolid=$rs['enrolid'];
								$namesent=$rs['firstname'].' '.$rs['lastname'];
							
								$sqlAdmin="
										Select
										  a.lastname,
										  a.id,
										  a.username,
										  a.email,
										  a.firstname
										From
										  mdl_cifauser a
										Where
										  a.id = '2'";
								$queryAdmin=mysql_query($sqlAdmin);
								$rowAdmin=mysql_fetch_array($queryAdmin);
								
								//include('email_notification.php');
								$from=$rowAdmin['email'];//"mohd.arizan@mmsc.com.my"; //administrator mail
								$namefrom="CIFA Administrator";
								$to = $email;
								$nameto = $namesent;
								$subject = "New added set exam details";

								$message = "<p>Hi <b>$namesent</b>, </p><br/>
											<p>You have new added set of exam. Please check your cifaonline.</p><br/>
											<p>Thank you.</p>";
										
								// this is it, lets send that email!
								authgMail($from, $namefrom, $to, $nameto, $subject, $message);
							}
						}
						/////************************************************************End**************************************************////
						//redirect(new moodle_url('/enrol/users.php', array('id'=>$course->id)));
						//redirect(new moodle_url('../listofexam.php', array('id'=>$course->id)));
						redirect(new moodle_url('/index.php'));
                    }
                }
            }
        }
    } else {
        // Save any changes to the files used in the editor
        update_course($data, $editoroptions);
    }

    switch ($returnto) {
        case 'category':
        case 'topcat': //redirecting to where the new course was created by default.
            $url = new moodle_url($CFG->wwwroot.'/course/category.php', array('id'=>$categoryid));
            break;
        default:
            $url = new moodle_url($CFG->wwwroot.'/course/view.php', array('id'=>$course->id));
            break;
    }
    redirect($url);
}


// Print the form

$site = get_site();

$streditcoursesettings = get_string("editcoursesettings", "admin");
//$straddnewcourse = get_string("addnewexam", "admin");
//add by arizan abdullah
$straddnewcourse = get_string("addnewcourse").' '.strtolower($category->name); 
$stradministration = get_string("administration");
$strcategories = get_string("categories");

if (!empty($course->id)) {
    $PAGE->navbar->add($streditcoursesettings);
    $title = $streditcoursesettings;
    $fullname = $course->fullname;
} else {
    $PAGE->navbar->add($stradministration, new moodle_url('/admin/index.php')); 
	//add by arizan abdullah
    $PAGE->navbar->add($strcategories, new moodle_url('/course/index.php'));
	//$PAGE->navbar->add($strcategories, new moodle_url('/course/examcenter/category.php?id=3&categoryedit=on&sesskey=x3OeAgIuFp'));
    $PAGE->navbar->add($straddnewcourse);
    $title = "$site->shortname: $straddnewcourse";
    $fullname = $site->fullname;
}

//aa
$PAGE->set_title($title);
$PAGE->set_heading($fullname);

echo $OUTPUT->header();
//aa
echo $OUTPUT->heading($streditcoursesettings);

$editform->display();

//aa
echo $OUTPUT->footer();

