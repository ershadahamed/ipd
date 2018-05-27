<?php
      // Displays different views of the logs.

    require_once('../../../config.php');
    require_once('../../lib.php');
    require_once('lib.php');
    require_once($CFG->libdir.'/adminlib.php');

    $id          = optional_param('id', 0, PARAM_INT);// Course ID

    $host_course = optional_param('host_course', '', PARAM_PATH);// Course ID

    if (empty($host_course)) {
        $hostid = $CFG->mnet_localhost_id;
        if (empty($id)) {
            $site = get_site();
            $id = $site->id;
        }
    } else {
        list($hostid, $id) = explode('/', $host_course);
    }

    $group       = optional_param('group', 0, PARAM_INT); // Group to display
    $user        = optional_param('user', 0, PARAM_INT); // User to display
    $date        = optional_param('date', 0, PARAM_FILE); // Date to display - number or some string
    $modname     = optional_param('modname', '', PARAM_SAFEDIR); // course_module->id
    $modid       = optional_param('modid', 0, PARAM_FILE); // number or 'site_errors'
    $modaction   = optional_param('modaction', '', PARAM_PATH); // an action as recorded in the logs
    $page        = optional_param('page', '0', PARAM_INT);     // which page to show
    $perpage     = optional_param('perpage', '100', PARAM_INT); // how many per page
    $showcourses = optional_param('showcourses', 0, PARAM_INT); // whether to show courses if we're over our limit.
    $showusers   = optional_param('showusers', 0, PARAM_INT); // whether to show users if we're over our limit.
    $chooselog   = optional_param('chooselog', 0, PARAM_INT);
    $logformat   = optional_param('logformat', 'showashtml', PARAM_ALPHA);

    $params = array();
    if ($id !== 0) $params['id'] = $id;
    if ($host_course !== '') $params['host_course'] = $host_course;
    if ($group !== 0) $params['group'] = $group;
    if ($user !== 0) $params['user'] = $user;
    if ($date !== 0) $params['date'] = $date;
    if ($modname !== '') $params['modname'] = $modname;
    if ($modid !== 0) $params['modid'] = $modid;
    if ($modaction !== '') $params['modaction'] = $modaction;
    if ($page !== '0') $params['page'] = $page;
    if ($perpage !== '100') $params['perpage'] = $perpage;
    if ($showcourses !== 0) $params['showcourses'] = $showcourses;
    if ($showusers !== 0) $params['showusers'] = $showusers;
    if ($chooselog !== 0) $params['chooselog'] = $chooselog;
    if ($logformat !== 'showashtml') $params['logformat'] = $logformat;
    $PAGE->set_url('/course/report/log/index.php', $params);
    $PAGE->set_pagelayout('report');

    if ($hostid == $CFG->mnet_localhost_id) {
        if (!$course = $DB->get_record('course', array('id'=>$id))) {
            print_error('That\'s an invalid course id'.$id);
        }
    } else {
        $course_stub       = $DB->get_record('mnet_log', array('hostid'=>$hostid, 'course'=>$id), '*', true);
        $course->id        = $id;
        $course->shortname = $course_stub->coursename;
        $course->fullname  = $course_stub->coursename;
    }

    require_login($course);

    $context = get_context_instance(CONTEXT_COURSE, $course->id);

    require_capability('coursereport/log:view', $context);

    add_to_log($course->id, "course", "report log", "report/log/index.php?id=$course->id", $course->id);

    $strlogs = get_string('logs');
    $stradministration = get_string('administration');
    $strreports = get_string('reports');

    session_get_instance()->write_close();

    $navlinks = array();

    if (!empty($chooselog)) {
        $userinfo = get_string('allparticipants');
        $dateinfo = get_string('alldays');

        if ($user) {
            if (!$u = $DB->get_record('user', array('id'=>$user))) {
                print_error('That\'s an invalid user!');
            }
            $userinfo = fullname($u, has_capability('moodle/site:viewfullnames', $context));
        }
        if ($date) {
            $dateinfo = userdate($date, get_string('strftimedaydate'));
        }

        switch ($logformat) {
            case 'showashtml':
                if ($hostid != $CFG->mnet_localhost_id || $course->id == SITEID) {
                    admin_externalpage_setup('reportlog');
                    echo $OUTPUT->header();

                } else {
                    $PAGE->set_title($course->shortname .': '. $strlogs);
                    $PAGE->set_heading($course->fullname);
                    $PAGE->navbar->add($strreports, new moodle_url('/course/report.php', array('id'=>$course->id)));
                    $PAGE->navbar->add($strlogs, new moodle_url('/course/report/log/index.php', array('id'=>$course->id)));
                    $PAGE->navbar->add("$userinfo, $dateinfo");
                    echo $OUTPUT->header();
                }

                echo $OUTPUT->heading(format_string($course->fullname) . ": $userinfo, $dateinfo (".usertimezone().")");
                print_mnet_log_selector_form($hostid, $course, $user, $date, $modname, $modid, $modaction, $group, $showcourses, $showusers, $logformat);

                if($hostid == $CFG->mnet_localhost_id) {
                    print_log($course, $user, $date, 'l.time DESC', $page, $perpage,
                            "index.php?id=$course->id&amp;chooselog=1&amp;user=$user&amp;date=$date&amp;modid=$modid&amp;modaction=$modaction&amp;group=$group",
                            $modname, $modid, $modaction, $group);
                } else {
                    print_mnet_log($hostid, $id, $user, $date, 'l.time DESC', $page, $perpage, "", $modname, $modid, $modaction, $group);
                }
                break;
            case 'downloadascsv':
                if (!print_log_csv($course, $user, $date, 'l.time DESC', $modname,
                        $modid, $modaction, $group)) {
                    echo $OUTPUT->notification("No logs found!");
                    echo $OUTPUT->footer();
                }
                exit;
            case 'downloadasods':
                if (!print_log_ods($course, $user, $date, 'l.time DESC', $modname,
                        $modid, $modaction, $group)) {
                    echo $OUTPUT->notification("No logs found!");
                    echo $OUTPUT->footer();
                }
                exit;
            case 'downloadasexcel':
                if (!print_log_xls($course, $user, $date, 'l.time DESC', $modname,
                        $modid, $modaction, $group)) {
                    echo $OUTPUT->notification("No logs found!");
                    echo $OUTPUT->footer();
                }
                exit;
        }


    } else {
        if ($hostid != $CFG->mnet_localhost_id || $course->id == SITEID) {
            admin_externalpage_setup('reportlog');
            echo $OUTPUT->header();
        } else {
            $PAGE->set_title($course->shortname .': '. $strlogs);
            $PAGE->set_heading($course->fullname);
            echo $OUTPUT->header();
        }

//report start here
include('../../../manualdbconfig.php');
$qry = "SELECT a.firstname, a.usertype, FROM_UNIXTIME(b.date,'%d/%m/%Y') as registrationdate FROM mdl_cifauser a, mdl_cifaorders b, mdl_cifacandidates c
		WHERE c.serial=b.customerid AND a.id=c.candidateid ORDER BY a.usertype, registrationdate ASC";
$sql = mysql_query($qry);	
$row = mysql_num_rows($sql);
$no=1;	
?>

<table width="100%" border="0">
<tr><td align="center">List of Users Account<br><br></td><tr>
<tr><td>
	<form action="report_admin.php" method="post">
	<table width="98%" border="0">
	<tr><td width="20%">User Type</td><td><select name="usertype"><option></option></select></td></tr>
	<tr><td>Registration Date</td><td>Month <select name="month"><option</option></select>&nbsp; Year <select name="year"><option></option></select></td></tr>
	<tr><td>&nbsp;</td><td><input type="submit" name="submit" value="View Report"><input type="reset" name="reset" value="Cancel">
	</table></form>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>	
<?php if($_POST['submit']!=''){?>
<table width="98%" border="1" cellpadding="0">
<tr>
	<td width="5%">No.</td>
	<td width="55%">Name</td>
	<td width="20%">User Type</td>
	<td width="20%">Registration Date</td>
</tr>
<?php if($row>0){ 
while($rs = mysql_fetch_array($sql)){?>
<tr>
	<td><?php echo $no;?></td>
	<td><?php echo $rs['firstname'];?></td>
	<td><?php echo $rs['usertype'];?></td>
	<td><?php echo $rs['registrationdate'];?></td>
</tr>
<?php $no++;}}else{ ?>
<tr><td colspan="4">No records found.</td></tr>
<?php } } mysql_close();?>
</table>
</td></tr></table>
<?php 
//report ends here       

    }

    echo $OUTPUT->footer();

    exit;

