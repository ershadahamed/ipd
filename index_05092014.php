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
 * Moodle frontpage.
 *
 * @package    core
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

    if (!file_exists('./config.php')) {
        header('Location: install.php');
        die;
    }

    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');

    redirect_if_major_upgrade_required();

    if ($CFG->forcelogin) {
        require_login();
    } else {
        user_accesstime_log();
    }

    $hassiteconfig = has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));

    $urlparams = array();
    if ($CFG->defaulthomepage == HOMEPAGE_MY && optional_param('redirect', 1, PARAM_BOOL) === 0) {
        $urlparams['redirect'] = 0;
    }
    $PAGE->set_url('/', $urlparams);
    $PAGE->set_course($SITE);

/// If the site is currently under maintenance, then print a message
    if (!empty($CFG->maintenance_enabled) and !$hassiteconfig) {
        print_maintenance_message();
    }

    if ($hassiteconfig && moodle_needs_upgrading()) {
        redirect($CFG->wwwroot .'/'. $CFG->admin .'/index.php');
    }

    if (get_home_page() != HOMEPAGE_SITE) {
        // Redirect logged-in users to My Moodle overview if required
        if (optional_param('setdefaulthome', false, PARAM_BOOL)) {
            set_user_preference('user_home_page_preference', HOMEPAGE_SITE);
        } else if ($CFG->defaulthomepage == HOMEPAGE_MY && optional_param('redirect', 1, PARAM_BOOL) === 1) {
            redirect($CFG->wwwroot .'/my/');
        } else if (!empty($CFG->defaulthomepage) && $CFG->defaulthomepage == HOMEPAGE_USER) {
            $PAGE->settingsnav->get('usercurrentsettings')->add(get_string('makethismyhome'), new moodle_url('/', array('setdefaulthome'=>true)), navigation_node::TYPE_SETTING);
        }
    }

    if (isloggedin()) {
        add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
    }

/// If the hub plugin is installed then we let it take over the homepage here
    if (get_config('local_hub', 'hubenabled') && file_exists($CFG->dirroot.'/local/hub/lib.php')) {
        require_once($CFG->dirroot.'/local/hub/lib.php');
        $hub = new local_hub();
        $continue = $hub->display_homepage();
        //display_homepage() return true if the hub home page is not displayed
        //mostly when search form is not displayed for not logged users
        if (empty($continue)) {
            exit;
        }
    }

	/// Print Section or custom info
    if (!empty($CFG->customfrontpageinclude)) {
        include($CFG->customfrontpageinclude);

    } else if ($SITE->numsections > 0) {

        if (!$section = $DB->get_record('course_sections', array('course'=>$SITE->id, 'section'=>1))) {
            $DB->delete_records('course_sections', array('course'=>$SITE->id, 'section'=>1)); // Just in case
            $section->course = $SITE->id;
            $section->section = 1;
            $section->summary = '';
            $section->summaryformat = FORMAT_HTML;
            $section->sequence = '';
            $section->visible = 1;
            $section->id = $DB->insert_record('course_sections', $section);
        }

        if (!empty($section->sequence) or !empty($section->summary) or $editing) {
            echo $OUTPUT->box_start('generalbox sitetopic');

            /// If currently moving a file then show the current clipboard
            if (ismoving($SITE->id)) {
                $stractivityclipboard = strip_tags(get_string('activityclipboard', '', $USER->activitycopyname));
                echo '<p><font size="2">';
                echo "$stractivityclipboard&nbsp;&nbsp;(<a href=\"course/mod.php?cancelcopy=true&amp;sesskey=".sesskey()."\">". get_string('cancel') .'</a>)';
                echo '</font></p>';
            }

            $context = get_context_instance(CONTEXT_COURSE, SITEID);
            $summarytext = file_rewrite_pluginfile_urls($section->summary, 'pluginfile.php', $context->id, 'course', 'section', $section->id);
            $summaryformatoptions = new stdClass();
            $summaryformatoptions->noclean = true;
            $summaryformatoptions->overflowdiv = true;

            echo format_text($summarytext, $section->summaryformat, $summaryformatoptions);

            if ($editing) {
                $streditsummary = get_string('editsummary');
                echo "<a title=\"$streditsummary\" ".
                     " href=\"course/editsection.php?id=$section->id\"><img src=\"" . $OUTPUT->pix_url('t/edit') . "\" ".
                     " class=\"iconsmall\" alt=\"$streditsummary\" /></a><br /><br />";
            }

            get_all_mods($SITE->id, $mods, $modnames, $modnamesplural, $modnamesused);
            print_section($SITE, $section, $mods, $modnamesused, true);

            if ($editing) {
                print_section_add_menus($SITE, $section->section, $modnames);
            }
            echo $OUTPUT->box_end();
        }
    }
    if (isloggedin() and !isguestuser() and isset($CFG->frontpageloggedin)) {
        $frontpagelayout = $CFG->frontpageloggedin;
    } else {
        $frontpagelayout = $CFG->frontpage;
    }

$site = get_site();	
$title="$SITE->shortname: Home";
$PAGE->set_title($title);
$PAGE->set_heading($site->fullname);

if (isloggedin()) {
	if($USER->id == '2'){
	//$PAGE->set_pagelayout('frontpage-custom');
	}
}
$PAGE->set_pagelayout('frontpage');
echo $OUTPUT->header();
if (isloggedin()) { $idletime=get_string('idletime'); 
?>
<script type="text/javascript">
setTimeout(onUserInactivity, 1000 * 900) //900->15minutes//test for 2 minutes
function onUserInactivity() {
   window.location.href = "<?=$CFG->wwwroot;?>/login/logout.php?sesskey=<?=sesskey();?>"
   alert('<?=$idletime;?>');
}
</script>
<?php
}
if	($frontpagelayout){
	if(($USER->id)!='2'){
		//selain administrator
		$queryrole  = $DB->get_records('role_assignments',array('userid'=>$USER->id));
		foreach($queryrole as $qrole){ }
		if(($qrole->roleid !='5')){ 
			include_once('home.php'); 
		}else{
			include("manualdbconfig.php");
			include("includes/functions.php");
			if(is_array($_SESSION['cart'])){
			$max=count($_SESSION['cart']);
                        for($i=0;$i<$max;$i++){
							$pid=$_SESSION['cart'][$i]['productid'];								
							$pid_cek=mysql_query("Select
							  *
							From
							  mdl_cifaenrol a Inner Join
							  mdl_cifauser_enrolments b On a.id = b.enrolid
							Where
							  a.courseid='".$pid."' And b.userid='".$USER->id."'
							");	
							$rpid=mysql_num_rows($pid_cek); //echo $rpid;
							$del_pid=mysql_fetch_array($pid_cek);
							if($rpid!='0'){
								//$del_pid=mysql_fetch_array($pid_cek);
								//echo $del_pid['courseid'];
								for($p=0;$p<$max;$p++){
									if($del_pid['courseid']==$pid){
										unset($_SESSION['cart'][$p]);
										break;
									}
								}								 
								//$_SESSION['cart']=array_values($_SESSION['cart']);
							}
							$_SESSION['cart']=array_values($_SESSION['cart']);
							$redirect = $CFG->wwwroot.'/portal/subscribe/paydetails_loggeduser.php?pid='.$del_pid['courseid']; redirect($redirect);

							
						}
			}
			
			$sql=mysql_query("SELECT * FROM mdl_cifauser WHERE firstaccess='0' AND id='".$USER->id."'");
			$count=mysql_num_rows($sql);
			if($count == '0'){
				if($pid!=''){ $redirect = $CFG->wwwroot.'/portal/subscribe/paydetails_loggeduser.php?pid='.$pid; redirect($redirect); }else{
				include_once('home.php'); 
				}
			}else{
				if($pid!=''){ $redirect = $CFG->wwwroot.'/portal/subscribe/paydetails_loggeduser.php?pid='.$pid; redirect($redirect); }else{
				include_once('home.php'); 
				}
			}
			$secretkey=sesskey();
			$sqlp=mysql_query("UPDATE mdl_cifauser SET secret='".$secretkey."', firstaccess='".time()."' WHERE firstaccess='0' AND id='".$USER->id."'");
		}
	}else{
		//administrator
		include_once('home.php');
	}
	}
	
	//untuk delete user yang masih di simpan di userprogram DB.
	include('manualdbconfig.php');
	
	$sqlstatement="
		Select
		  a.firstname,
		  a.lastname,
		  a.id
		From
		  mdl_cifauser a Inner Join
		  mdl_cifauser_program b On b.userid = a.id
		Where
		  a.confirmed='1' And 	
		  a.deleted = '1' 
		Order by
			a.id ASC
	";
	$sqlremove=mysql_query($sqlstatement);
	$sqlremovecount=mysql_num_rows($sqlremove);
	while($sqlshow=mysql_fetch_array($sqlremove)){
		$sqldeleteprog=mysql_query("		
			DELETE FROM mdl_cifauser_program WHERE userid='".$sqlshow['id']."'
		");	
	}
	//End//untuk delete user yang masih di simpan di userprogram DB.
	
	echo $OUTPUT->footer();
?>
