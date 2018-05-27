<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../config.php');
require_once('lib.php');
require_once('lib_organization.php');
require_once('communication_lib.php');
require_once('userrole_lib.php');
require_once('report_lib.php');
require_once('../lib.php');
require_once($CFG->libdir . '/logactivity_lib.php');

//define('AJAX_SCRIPT', true);
global $DB, $PAGE, $OUTPUT;

$id = optional_param('id', 0, PARAM_INT);
$page = optional_param('page', 0, PARAM_INT);
$perpage = optional_param('perpage', 10, PARAM_INT);        // how many per page
$sort = optional_param('sort', 'name', PARAM_ALPHA);
$search = optional_param('month', '', PARAM_INT);
$dir = optional_param('dir', 'ASC', PARAM_ALPHA);
$formtype = optional_param('formtype', '', PARAM_MULTILANG);
$supportform1 = optional_param('supportform1', '', PARAM_ALPHANUMEXT);
$formdisplay = optional_param('display', '', PARAM_ALPHANUMEXT);
$supportform = optional_param('supportform', '', PARAM_MULTILANG);
$typeofsupportform = optional_param('typeofsupportform', '', PARAM_MULTILANG);
$whichbutton = optional_param('whichbutton', '', PARAM_MULTILANG);
$whichsupportbutton = optional_param('whichsupportbutton', '', PARAM_MULTILANG);
$imagebutton = optional_param('imagebutton', '', PARAM_MULTILANG);
$supportactivities = optional_param('support', '', PARAM_ALPHANUMEXT);

$searchorgid = optional_param('organizationid', '', PARAM_ALPHANUMEXT);
$searchorgname = optional_param('organizationname', '', PARAM_MULTILANG);
$searchorgrole = optional_param('role', '', PARAM_INT);
$sorgrole = optional_param('srole', '', PARAM_MULTILANG);
$searchorgstatus = optional_param('orgstatus', '', PARAM_ALPHANUMEXT);
$searchorgregdate = optional_param('orgregistrationdate', '', PARAM_ALPHANUMEXT);
$searchaddress1 = optional_param('addressline1', '', PARAM_MULTILANG);
$searchorgcity = optional_param('orgcity', '', PARAM_MULTILANG);
$searchorgcountry = optional_param('country', '', PARAM_MULTILANG);
$searchhqorganizationid = optional_param('hqorganizationid', '', PARAM_ALPHANUMEXT);
$searchorghqrole = optional_param('organizationrole', '', PARAM_INT);

$deletebutton = optional_param('deletebutton', '', PARAM_MULTILANG);
$deleteorg = optional_param('deleteorg', '', PARAM_MULTILANG);
$deleteuser = optional_param('deleteuser', '', PARAM_MULTILANG);

$statusparam = optional_param('supportstatusname', '', PARAM_INT);
$categoryparam = optional_param('supportcategoryname', '', PARAM_INT);
$descparam = optional_param('supportdesc', '', PARAM_MULTILANG);
$delid = optional_param('delfinancial', '', PARAM_INT); // delete record financial 
$delcoursehistory = optional_param('delcoursehistory', '', PARAM_INT);

// support for user case  // refer lib.php
$f2 = optional_param('debit', '', PARAM_INT); // financial debit
$f3 = optional_param('credit', '', PARAM_INT); // financial credit
$f4 = optional_param('financialstatusname', '', PARAM_INT); // financial status
$f5 = optional_param('financialdesc', '', PARAM_MULTILANG); // financial description
// Financial search
$f6 = optional_param('searchdatetimefinance', '', PARAM_MULTILANG); // Search financial credit
$f7 = optional_param('searchtransactionid', '', PARAM_ALPHANUMEXT); // Search transaction id
$f9 = optional_param('searchstatus', '', PARAM_ALPHANUMEXT); // Search transaction id
$f8 = optional_param('searchcreatedby', '', PARAM_INT); // Search created by user  
// Course History
$sc1 = optional_param('teststatusname', '', PARAM_INT);
$sc2 = optional_param('coursetitle', '', PARAM_INT);
$sc3 = optional_param('testmark', '', PARAM_INT);
$sc4 = optional_param('datetimesearchfinance', '', PARAM_MULTILANG); // start date
$sc5 = optional_param('subscriptionenddate', '', PARAM_MULTILANG);     // end date

$enrolnewcourse = optional_param('enrolnewcourse', '', PARAM_INT);
$generateActivitiyId = optional_param('generateActivitiyId', '', PARAM_ALPHANUMEXT);

// SEARCH users ifo
$searchcid = optional_param('candidateid','', PARAM_ALPHANUMEXT);
$searchfirstname = optional_param('firstname','', PARAM_MULTILANG);
$searchlastname = optional_param('lastname','', PARAM_MULTILANG);
$searchemail = optional_param('email','', PARAM_MULTILANG);
$searchcity = optional_param('city','', PARAM_MULTILANG);
$sgender = optional_param('gendercolumn','', PARAM_MULTILANG);
$scountry = optional_param('getcountry','', PARAM_MULTILANG);

// communication
$creationdatetime = optional_param('creationdatetime', '', PARAM_MULTILANG);
$communicationtitle = optional_param('communicationtitle', '', PARAM_MULTILANG);
$scheduleimagebutton = optional_param('scheduleimagebutton', '', PARAM_MULTILANG);
$newtext = optional_param('new', '', PARAM_MULTILANG); 
$deletetext = optional_param('delete', '', PARAM_MULTILANG);
$communicationid = optional_param('communicationid', '', PARAM_INT);
$scheduledeleteid = optional_param('scheduledelid', '', PARAM_INT);
$viewlink_communication = optional_param('viewlink', '', PARAM_MULTILANG);
$editlink_communication = optional_param('editlink', '', PARAM_MULTILANG);

$PAGE->set_url('/');
$PAGE->set_course($SITE);
$PAGE->set_context(get_system_context());

$organizationheader = get_string('salesservices');   // Sales & Services 
$url = new moodle_url('/organization/orgview.php');
$PAGE->navbar->add(ucwords(strtolower($organizationheader)), $url);

$PAGE->set_pagetype('site-index');
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('buy_a_cifa');
?>
<head>
    <!-- Load jQuery from Google's CDN -->
    <!-- Load jQuery UI CSS  -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="./jquery.datetimepicker.css"/>

    <!-- Load jQuery JS -->
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <!-- Load jQuery UI Main JS  -->
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

    <!-- Load SCRIPT.JS which will create datepicker for input field  -->
    <script src="../examcenter/script.js"></script>

    <link rel="stylesheet" href="../examcenter/runnable.css" />
</head>
<script type="text/javascript">
    function popupwindow(url, title, w, h) {//Center PopUp Window added by Arizan
        var left = (screen.width / 2) - (w / 2);
        var top = (screen.height / 2) - (h / 2);
        return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    }
</script>

<?php
echo $OUTPUT->header();
require_login();
$extenddays = '60 days';

//echo date('dmY H:i:s',strtotime('today midnight'.'- 1 minutes'));
//$todaymidnight = strtotime('today midnight'.'+ '.$extenddays.' - 1 minutes');
//echo date('dmY H:i:s',$todaymidnight);

//echo strtotime('today midnight'.'+ 120 days - 1 minutes');

$groupid = strtoupper($USER->username);
$author = $groupid . ' (' . $USER->firstname . ' ' . $USER->lastname . ')';
$userdatetime = date('d-m-Y H:i:s', time());
$today = date('d-m-Y', time());

//$tt = getdate(time());
//$today = mktime(0, 0, 0, $tt["mon"], $tt["mday"], $tt["year"]);

$marginright = 'style="margin-right:0.5em;"';
$userstyle = "float:left;margin-top:0.5em; width:75%;height:1.8em;";
$userstyle2 = "float:left;margin-top:0.5em; width:65%;height:1.8em;";
$textinput = 'style="float:left;margin-top:0.5em; width:75%;height:1.8em;"';
$textinput2 = 'style="float:left;margin-top:0.5em; width:65%;height:1.8em;"';
$actionbuttoncolor = 'id_actionbutton';
$defaultbuttoncolor = 'id_defaultbutton';

$formstart = html_writer::start_tag('form', array('id' => 'typeofsupportform', 'name' => 'typeofsupportform', 'method' => 'post', 'action' => ''));
$div = html_writer::start_tag('div', array('style' => 'margin-bottom:0.5em'));
$divopen = html_writer::start_tag('div');
$divclose = html_writer::end_tag('div');
$td = html_writer::start_tag('td');
$tdclose = html_writer::end_tag('td');
$tr = html_writer::start_tag('tr', array('style' => 'vertical-align:top;'));
$trclose = html_writer::end_tag('tr');
$formclose = html_writer::end_tag('form');
$h3start = html_writer::start_tag('h3', array('style' => 'margin-bottom:1em;'));
$h3 = html_writer::end_tag('h3');

// DB for USERS
$result = buildusersdb_listall($page, $perpage, $formtype, $searchcid, $searchfirstname, $searchlastname, $searchemail, $searchcity, $creationdatetime, $sgender, $scountry);
// END DB for USERS

$bottommargin = '<div style="margin-bottom:1em;"></div>';
echo $bottommargin;

// Organization
echo $h3start . strtoupper($formtype) . $h3;

// display TOP button here!!
echo '<form id="typeofform" name="typeofform">';
print_r($divopen);
echo '<input ' . $marginright . ' type="submit"';
if ($formtype == get_string('organization')) {
    echo 'id="' . $actionbuttoncolor . '"';
} else {
    echo 'id="' . $defaultbuttoncolor . '"';
}
echo 'name="formtype" value="' . get_string('organization') . '" />';

echo '<input ' . $marginright . ' type="submit"';
if ($formtype == get_string('user')) {
    echo 'id="' . $actionbuttoncolor . '"';
} else {
    echo 'id="' . $defaultbuttoncolor . '"';
}
echo 'name="formtype" value="' . get_string('user') . '" />';

echo '<input ' . $marginright . ' type="submit"';
if ($formtype == get_string('communication')) {
    echo 'id="' . $actionbuttoncolor . '"';
} else {
    echo 'id="' . $defaultbuttoncolor . '"';
}
echo 'name="formtype" value="' . get_string('communication') . '" />';

echo '<input ' . $marginright . ' type="submit"';
if ($formtype == get_string('reporting')) {
    echo 'id="' . $actionbuttoncolor . '"';
} else {
    echo 'id="' . $defaultbuttoncolor . '"';
}
echo 'name="formtype" value="' . get_string('reporting') . '" title="' . get_string('reporting') . '" />';

echo '<input type="submit"';
if ($formtype == get_string('userrole')) {
    echo 'id="' . $actionbuttoncolor . '"';
} else {
    echo 'id="' . $defaultbuttoncolor . '"';
}
echo 'name="formtype" value="' . get_string('userrole') . '" title="' . get_string('userrole') . '" />';
print_r($divclose); // End top button
echo '</form>';

// array for search content
if ($whichbutton == get_string('search') || $whichsupportbutton == get_string('search')) {
    $searchorg1 = array($searchorgid, $searchorgname, $searchorgrole, $searchorgstatus, $searchorgregdate);
    $searchorg2 = array($searchaddress1, $searchorgcity, $searchorgcountry, $sorgrole);
    $searchorg = array_merge($searchorg1, $searchorg2);
}
// END array for search content

$fieldset = html_writer::start_tag('fieldset', array('id' => 'group', 'class' => 'clearfix_group'));     // Start 1st fieldset
$fieldset .= html_writer::start_tag('legend', array('class' => 'ftoggler'));
$fieldset .= html_writer::end_tag('legend');

// Count total of record && Link print // lib.php
$usercount = countusers_org_tabs($formtype, $searchcid, $searchfirstname, $searchlastname, $searchemail, $searchcity, $searchdob, $sgender, $scountry, $searchorg[0], $searchorg[1], $searchorg[2], $searchorg[3], $searchorg[4], $searchorg[5], $searchorg[6], $searchorg[7], $searchorg[8]);

if ($formtype == get_string('organization')) {
    $linkprint = $CFG->wwwroot . '/organization/organizationlist_print.php?';
} elseif ($formtype == get_string('user')) {
    $linkprint = $CFG->wwwroot . '/organization/userslist_print.php?id=';
}

$baseurl = new moodle_url('/organization/orgview.php', array('formtype' => $formtype, 'sort' => $sort, 'dir' => $dir, 'perpage' => $perpage));
$totalrecord = 'Total Record: ' . $usercount;

print_r($fieldset);
if ($usercount > 0) {
    if ($usercount >= $perpage) {
        $r = ($perpage * ($page + 1));
    } else {
        $r = $usercount;
    }

    $record.=(($perpage * $page) + 1) . ' - ' . $r . ' of ' . ($usercount - ($perpage * $page)) . ' record';
}

echo '<form id="typeofformdelete" name="typeofformdelete">';
$action = "Onclick=this.form.action='" . $linkprint . "';target='_blank'";  // 1. link to print page
// button delete & print
echo html_writer::start_tag('div', array('class' => 'groupbutton'));
if($formtype == get_string('user') || $formtype == get_string('organization')){
    // search button for organization, users
    if($whichsupportbutton ==get_string('search')){ $b=$actionbuttoncolor; }else{ $b=$defaultbuttoncolor; }
    echo createinputtext('submit', $b, 'whichsupportbutton', get_string('search'), '', 'margin-right:0.5em;line-height:1em;height:28px;');
    echo createinputtext('submit', $defaultbuttoncolor, 'deletebutton', get_string('delete'), '', 'margin-right:0.5em;line-height:1em;height:28px;');
    echo "<input type='submit' " . $action . " name='printbutton' id='" . $defaultbuttoncolor . "' value='" . get_string('print') . "' style='margin-right:0.5em;line-height:1em;height:28px;' />";   
}
if($formtype == get_string('communication') || $formtype == get_string('reporting') || $formtype == get_string('userrole')){
    // button search & print 
    $buttoncolor = $defaultbuttoncolor;
    if($whichsupportbutton ==get_string('search')){ $b=$actionbuttoncolor; }else{ $b=$buttoncolor; }
    switch($formtype){
        case get_string('communication'):
            $printname = 'communication_print';
            if(!empty($newtext)){ $newaddedtextmsg = get_string('newaddedtextmsg'); }
            if(!empty($deletetext)){ $deletetextmsg = get_string('deletetextmsg'); } 
            break;
        case get_string('reporting'):
            $printname = 'reporting_print';
            break;
        case get_string('userrole'):
            $printname = 'userrole_print';
            break;
        default:
    }
    // communication_lib.php  
    printall_data($b, $buttoncolor, $printname, $formtype, $id);  
    echo $newaddedtextmsg.''.$deletetextmsg;
}
echo createinputtext('hidden', 'formtype', 'formtype', $formtype, '', '');

print_r($record);
echo html_writer::start_tag('div', array('style' => 'float:right; line-height:2.5em;padding-left:0.5em;'));
echo $OUTPUT->paging_bar($usercount, $page, $perpage, $baseurl);    // upper paging bar

// New button for Communication & reporting
communicationnewsave_button($whichsupportbutton, $actionbuttoncolor,$defaultbuttoncolor, $formtype);

echo html_writer::end_tag('div');
echo html_writer::end_tag('div');   // End 

echo '<div style="margin-bottom:1em;"></div>';
$table = new html_table();
$table->width = "100%";

// display default page for organization & user
$outstandingbalance_finance = outstandingbalance_finance($id);
$logginuserid = $USER->id;
// $orgpassrate = userpassrateis(testdetails($cpassrate->coursecode, 1)->fullname, $organizationid, $passgrade, testdetails($cpassrate->coursecode, 3)->id);
switch ($formtype) {
    case get_string('user'):
        $table->head = array("Candidate ID", "Firstname", "Lastname", "Email", "Gender", "D.O.B", "Status", "City", "Country", "Created By", "");
        $table->align = array("center", "left", "left", "left", "center", "center","center", "center","left", "left", "center");
        if($whichsupportbutton==get_string('search')){
            users_search($table);
        }
        foreach ($result as $value) {
            if ($value->status == '0') {
                $createby = $author;
            } else {
                $createby = $author;
            }
            // Registration date
            $datetime = date('d-m-Y', $value->timecreated);
            $dob = date('d-m-Y', $value->dob);
            // Organization Name
            if ($value->middlename) {
                $organizationname = $value->firstname . ' ' . $value->middlename . ' ' . $value->lastname;
            } else {
                $organizationname = $value->firstname . ' ' . $value->lastname;
            }

            if ($value->gender == '0') {
                $gender = 'Male';
            } elseif ($value->gender == '1') {
                $gender = 'Female';
            }

            $link = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $value->id . '&display=userdetails';
            $checkbox = createinputcheckdelete('checkbox', 'deleteuser', "deleteuser[]", $value->id);
            if ($formtype == get_string('user')) {
                $table->data[] = array('<a href="' . $link . '">' . strtoupper($value->traineeid) . '</a>',
                    $value->firstname,
                    $value->lastname,
                    $value->email,
                    $gender,
                    $dob,
                    checkuserstatus($value->id),        // status
                    $value->city,
                    getCountryName($value->country),    // country
                    $createby, $checkbox
                );
            }
        }
        break;
    case get_string('organization'):    // Organization table
        $table->head = array("Organization ID", "Name", "Role", "Status", "Registration Date", "Country", "Created By", "");
        $table->align = array("center", "left", "left", "center", "center", "left", "center", "center");
        if($whichsupportbutton==get_string('search')){
            organization_search($table);
        }
        foreach (getListOfOrganization($page, $perpage, $searchorg[0], $searchorg[1], $searchorg[2], $searchorg[3], $searchorg[4], $searchorg[5], $searchorg[6], $searchorg[7], $searchorg[8]) as $getorg) {
            //Status
            if ($getorg->status == '0') {
                $status = get_string('active');
            } else {
                $status = get_string('inactive');
            }
            // Registration Date
            $orgregisterdate = date('d-m-Y', $getorg->timecreated);

            // Created By
            $user = get_user_details($getorg->createdby);
            if ($getorg->createdby == '2') {
                $createdby = 'Superadmin';
            } else {
                $createdby = $user->firstname . ' ' . $user->lastname;
                $createdby .= $user->traineeid;
            }

            $checkbox = createinputcheckdelete('checkbox', 'deleteorg', "deleteorg[]", $getorg->id);
            $link = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $getorg->id . '&display=organizationdetails';
            $table->data[] = array('<a href="' . $link . '">' . strtoupper($getorg->organizationid) . '</a>',
                $getorg->name,
                $getorg->org_typename,
                $status,
                $orgregisterdate,
                getCountryName($getorg->country),
                $createdby, $checkbox
            );
        }
        break;
    case get_string('communication'):   // COMMUNICATION TAB
        // communication_lib.php
        communication_main($id, $whichsupportbutton, $logginuserid, $formtype, $creationdatetime, $communicationtitle, $f8, $viewlink_communication, $editlink_communication);
        break;
    case get_string('reporting'):
        // report_lib.php;
        reporting_main($whichsupportbutton, $communicationtitle, $creationdatetime, $f8);
        break;
    case get_string('userrole'):
        // userrole_lib.php
        // userrole_main($userid, $whichsupportbutton);
        userrole_main($userid, $whichsupportbutton, $communicationtitle, $descparam);
        break;
    default:
        $table->head = array("Organization ID", "Name", "Role", "Status", "Registration Date", "Country", "Created By");
        $table->align = array("center", "left", "left", "center", "center", "left", "center");
}
if (!empty($table)) {
    echo html_writer::table($table);
}

// redirect to organization list
if ($deletebutton == get_string('delete')) {
    if ($formtype == get_string('organization')) {
        for ($i = 0; $i < sizeof($deleteorg); $i++) {
            // delete only
            checkboxdeleteorg($deleteorg[$i]); // id 
        }
        $deleteurl = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype;
        die("<script>location.href = '" . $deleteurl . "'</script>");
    } elseif ($formtype == get_string('user')) {
        //delete untuk users
        for ($i = 0; $i < sizeof($deleteuser); $i++) {
            // delete only
            checkboxdeleteusers($deleteuser[$i]); // id 
        }
        $deleteurl = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype;
        die("<script>location.href = '" . $deleteurl . "'</script>");       
    }
}
echo '</form>';

echo $OUTPUT->paging_bar($usercount, $page, $perpage, $baseurl);    // bottom paging bar
echo '<div style="margin-bottom:1em;"></div>';
echo html_writer::end_tag('fieldset');  // End 1st fieldset

// COMMUNICATION // BAHAGIAN TENGAH
if(!empty($imagebutton)){
    $a = new stdClass();
    switch($imagebutton){
        case get_string('schedule'):
            $a->buttonname = get_string('scheduling'); 
            break;
        case get_string('email1'):
            $a->buttonname = get_string('email1').'/'.get_string('scheduling');
            break;
    }
    
    echo $h3start. get_string('communicationhome_process','',$a) . '</h3>';
    echo $fieldset;
    echo html_writer::start_tag('div', array('class' => 'groupbutton','style'=>'margin-bottom:1em;float:right; line-height:2.5em;padding-left:0.5em;'));
        // NEW Button
        schedulenewsave_button($imagebutton, $whichbutton, $actionbuttoncolor, $buttoncolor, $formtype, $communicationid);
    echo html_writer::end_tag('div');
        // schedule box here
        communication_subaction($logginuserid, $formtype, $imagebutton, $whichbutton, $communicationid);
        // delete schedule list
        if(!empty($scheduledeleteid)){
            deletecommunication_schedule($communicationid, $scheduledeleteid,$formtype, $imagebutton);    // communication_lib.php
        }
    echo html_writer::end_tag('fieldset');  // End 2st fieldset
}
// END Communication part

// Bahagian tengah // bawah
// display group details form
$part1 = 'organizationdetails';
$part2 = 'userdetails';
$part3 = get_string('new');

$sql2 = "Select id, name From {role} Where (id='10' Or id='12' Or id='13') Order By name Asc";
$sqlrole = $DB->get_recordset_sql($sql2);

$supporttable = new html_table();
$supporttable->width = "100%";
switch ($formdisplay) {
    case $part1:    // organization group-details
        $qr = "Select * From {organization_type} Where id = '" . $id . "' Order By id DESC";
        $rs = $DB->get_record_sql($qr);

        echo $fieldset;
        // organization details
        include('organizationformlib.php');
        echo html_writer::end_tag('fieldset');  // End 2st fieldset
        // Support Management Activities - organization
        echo "<br/>" . $h3start . get_string('supportactivities') . $h3;

        // display all support button here
        print_r($formstart . $divopen);
        if (empty($supportform)) {
            $supportform = get_string('support');
        } // default

        $supportformlink = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $id . '&display=' . $formdisplay . '&supportform=' . $supportform;
        $linksupport = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $id . '&display=' . $formdisplay . '&supportform=' . $supportform;
        $linksupport .= '&whichsupportbutton=' . $whichsupportbutton;
        $supportformaction = "this.form.action='" . $supportformlink . "'";
        $action = "this.form.action='" . $linksupport . "'";
        // financial history link
        $linkfinancialprint = $CFG->wwwroot . '/organization/financialpage_print.php?id=' . $id . '&historyid=' . $delid;
        $linkstatement = $CFG->wwwroot . '/financialstatement/cview_statement.php?id=' . $id;
        $coursehistoryprint = $CFG->wwwroot.'/organization/coursehistory_print.php?id='.$id; 
        $supportactivities_print = $CFG->wwwroot.'/organization/supportactivities_print.php?id='.$id.'&type='.$formtype; 
        $supportattachment_print = $CFG->wwwroot.'/organization/supportattachment_print.php?id='.$id.'&type='.$formtype;
        $supportcontent_print = $CFG->wwwroot.'/organization/supportcontent_print.php?id='.$id.'&type='.$formtype;

        if ($supportform == get_string('support')) { 
            $spagingfh=simplepagingfor($id, $page, $perpage, $supportform, $formtype);
            $a = $actionbuttoncolor; 
            $actionprint = "window.open('" . $supportcontent_print . "','_blank')";} else { $a = $defaultbuttoncolor; }
        if ($supportform == get_string('activities')) { 
            $spagingfh=simplepagingfor($id, $page, $perpage, $supportform, $formtype);
            $b = $actionbuttoncolor; 
            $actionprint = "window.open('" . $supportactivities_print . "','_blank')";
        } else { 
            $b = $defaultbuttoncolor; 
        }
        if ($supportform == get_string('attachment')) { 
            $spagingfh=simplepagingfor($id, $page, $perpage, $supportform, $formtype);
            $c = $actionbuttoncolor;
            $actionprint = "window.open('" . $supportattachment_print . "','_blank')";
        } else { $c = $defaultbuttoncolor; }
        
        echo createinputtext('submit', $a, 'supportform', get_string('support'), '', 'margin-right:0.5em;', 'Onclick="' . $supportformaction . '"');
        echo createinputtext('submit', $b, 'supportform', get_string('activities'), '', 'margin-right:0.5em;', 'Onclick="' . $supportformaction . '"');
        echo createinputtext('submit', $c, 'supportform', get_string('attachment'), '', 'margin-right:0.5em;', 'Onclick="' . $supportformaction . '"');
        /* echo createinputtext('submit', $d, 'supportform', get_string('financialhistory'), '', 'margin-right:0.5em;', 'Onclick="' . $supportformaction . '"');
        echo createinputtext('submit', $e, 'supportform', get_string('coursehistory'), '', 'margin-right:0.5em;', 'Onclick="' . $supportformaction . '"');*/

        print_r($divclose . $formclose);
        echo $fieldset;
        echo '<form action="" id="supportform1" name="supportform1" method="post">';
        
        echo html_writer::start_tag('div', array('class' => 'groupbutton'));
        if ($whichsupportbutton == get_string('search')) { $a = $actionbuttoncolor; } else { $a = $defaultbuttoncolor; }
        if ($whichsupportbutton == get_string('new')) { $b = $actionbuttoncolor; } else { $b = $defaultbuttoncolor; }
        if ($whichsupportbutton == get_string('savebutton')) { $c = $actionbuttoncolor; } else { $c = $defaultbuttoncolor; }
        if ($whichsupportbutton == get_string('print')) { $d = $actionbuttoncolor; } else { $d = $defaultbuttoncolor; }
        if ($whichsupportbutton == get_string('delete')) { $e = $actionbuttoncolor; } else { $e = $defaultbuttoncolor; }      

        // Button New/Search/Save/Delete 
        echo createinputtext('submit', $a, 'whichsupportbutton', get_string('search'), '', 'margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $action . '"');
        echo createinputtext('submit', $b, 'whichsupportbutton', get_string('new'), '', 'margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $action . '"');
        if ($whichsupportbutton == get_string('new') || $whichsupportbutton == get_string('savebutton')) {
            echo createinputtext('submit', $c, 'whichsupportbutton', get_string('savebutton'), '', 'margin-right:0.5em;line-height:1em;height:28px;');
        }
        
        if ($USER->id == 2) { // only admin able to use delete button
            echo createinputtext('submit', $e, 'whichsupportbutton', get_string('delete'), '', 'margin-right:0.5em;line-height:1em;height:28px;');
        }
        echo createinputtext('button', $d, 'whichsupportbutton', get_string('print'), '', 'margin-bottom:1em;margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $actionprint . '"');
        echo createinputtext('hidden', 'supportform', 'supportform', $supportform);

        echo $simplepagingfinancialhistory=$spagingfh;    // 1 - 10 of X record
        
        echo html_writer::start_tag('div', array('style' => 'float:right; line-height:2.5em;padding-left:0.5em;'));
        if($supportform == get_string('support') || $supportform == get_string('activities') || $supportform == get_string('attachment')){
            // Support//Activities//Attachment
            //$newtext = optional_param('new', '', PARAM_MULTILANG); 
            //$deletetext = optional_param('delete', '', PARAM_MULTILANG);  
            if(!empty($newtext)){ echo get_string('newaddedtextmsg'); }
            if(!empty($deletetext)){ echo get_string('deletetextmsg'); } 
            if ($whichsupportbutton == get_string('delete')) {
                if(empty($delcoursehistory)){ echo get_string('checkatleastone'); }
            }            
        }        
        echo html_writer::end_tag('div');
        echo html_writer::end_tag('div');
        
        $switchcasesupportusers = createdswitchcase($supportform, get_string('support'), get_string('activities'), get_string('attachment'), get_string('financialhistory'), get_string('coursehistory'), $USER->id, $whichsupportbutton, $statusparam, $categoryparam, $descparam, $id, $f2, $f3, $f4, $f5, $delid, $f6, $f7, $f8, $f9, $delcoursehistory, $extenddays, $sc1, $sc2, $sc3, $sc4, $sc5, $enrolnewcourse, $generateActivitiyId, $formtype);        
// End support for user case
        echo html_writer::end_tag('fieldset');  // End 2st fieldset
        echo '</form>';               
        break;
    case $part2:    // USER DETAILS HERE
        $qr = "Select * From {user} Where id = '" . $id . "' Order By id DESC";
        $rs = $DB->get_record_sql($qr);

        //  User details here
        echo $fieldset;
        include('userformlib.php');
        echo html_writer::end_tag('fieldset');  // End 2st fieldset
        echo $bottommargin;

        // Support Management Activities - organization
        echo "<br/><h3>" . get_string('supportactivities') . "</h3>";

        // display all support button here
        print_r($formstart . $divopen);
        if (empty($supportform)) {
            $supportform = get_string('support');
        } // default

        $supportformlink = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $id . '&display=' . $formdisplay . '&supportform=' . $supportform;
        $linksupport = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $id . '&display=' . $formdisplay . '&supportform=' . $supportform;
        $linksupport .= '&whichsupportbutton=' . $whichsupportbutton;
        $supportformaction = "this.form.action='" . $supportformlink . "'";
        $action = "this.form.action='" . $linksupport . "'";
        // financial history link
        $linkfinancialprint = $CFG->wwwroot . '/organization/financialpage_print.php?id=' . $id . '&historyid=' . $delid;
        $linkstatement = $CFG->wwwroot . '/financialstatement/cview_statement.php?id=' . $id;
        $coursehistoryprint = $CFG->wwwroot.'/organization/coursehistory_print.php?id='.$id; 
        $supportactivities_print = $CFG->wwwroot.'/organization/supportactivities_print.php?id='.$id.'&type='.$formtype; 
        $supportattachment_print = $CFG->wwwroot.'/organization/supportattachment_print.php?id='.$id.'&type='.$formtype;
        $supportcontent_print = $CFG->wwwroot.'/organization/supportcontent_print.php?id='.$id.'&type='.$formtype;

        if ($supportform == get_string('support')) { 
            $a = $actionbuttoncolor; 
            $spagingfh=simplepagingfor($id, $page, $perpage, $supportform, $formtype);
            $actionprint = "window.open('" . $supportcontent_print . "','_blank')";} else { $a = $defaultbuttoncolor; }
        if ($supportform == get_string('activities')) { 
            $b = $actionbuttoncolor; 
            $spagingfh=simplepagingfor($id, $page, $perpage, $supportform, $formtype);
            $actionprint = "window.open('" . $supportactivities_print . "','_blank')";
        } else { 
            $b = $defaultbuttoncolor; 
        }
        if ($supportform == get_string('attachment')) { 
            $c = $actionbuttoncolor;
            $spagingfh=simplepagingfor($id, $page, $perpage, $supportform, $formtype);
            $actionprint = "window.open('" . $supportattachment_print . "','_blank')";
        } else { $c = $defaultbuttoncolor; }
        if ($supportform == get_string('financialhistory')) {
            $d = $actionbuttoncolor;
            $spagingfh=simplepagingfinancialhistory($id, $page, $perpage);
            $actionprint = "window.open('" . $linkfinancialprint . "','_blank')";
            $actionstatement = "popupwindow('" . $CFG->wwwroot . '/organization/viewstatement.php?id=' . $id . "', 'googlePopup', 880, 630);";            
        } else {
            $d = $defaultbuttoncolor;
        }
        if ($supportform == get_string('coursehistory')) {
            $e = $actionbuttoncolor;
            $spagingfh=simplepagingfor($id, $page, $perpage, $supportform);
            $actionprint = "window.open('" . $coursehistoryprint . "','_blank')";
        } else {
            $e = $defaultbuttoncolor;
        }

        echo createinputtext('submit', $a, 'supportform', get_string('support'), '', 'margin-right:0.5em;', 'Onclick="' . $supportformaction . '"');
        echo createinputtext('submit', $b, 'supportform', get_string('activities'), '', 'margin-right:0.5em;', 'Onclick="' . $supportformaction . '"');
        echo createinputtext('submit', $c, 'supportform', get_string('attachment'), '', 'margin-right:0.5em;', 'Onclick="' . $supportformaction . '"');
        echo createinputtext('submit', $d, 'supportform', get_string('financialhistory'), '', 'margin-right:0.5em;', 'Onclick="' . $supportformaction . '"');
        //echo createinputtext('submit', $e, 'supportform', get_string('coursehistory'), '', 'margin-right:0.5em;', 'Onclick="' . $supportformaction . '"');
		echo createinputtext('submit', $e, 'supportform', get_string('coursehistory'), '', 'margin-right:0.5em;', 'Onclick=""');
        print_r($divclose . $formclose);
        
        echo $fieldset;
        echo '<form action="" id="supportform1" name="supportform1" method="post">';

        echo html_writer::start_tag('div', array('class' => 'groupbutton'));
        if ($whichsupportbutton == get_string('search')) { $a = $actionbuttoncolor; } else { $a = $defaultbuttoncolor; }
        if ($whichsupportbutton == get_string('new')) { $b = $actionbuttoncolor; } else { $b = $defaultbuttoncolor; }
        if ($whichsupportbutton == get_string('savebutton')) { $c = $actionbuttoncolor; } else { $c = $defaultbuttoncolor; }
        if ($whichsupportbutton == get_string('print')) { $d = $actionbuttoncolor; } else { $d = $defaultbuttoncolor; }
        if ($whichsupportbutton == get_string('delete')) { $e = $actionbuttoncolor; } else { $e = $defaultbuttoncolor; }
        if ($whichsupportbutton == get_string('statement')) { $f = $actionbuttoncolor; } else { $f = $defaultbuttoncolor; }      
        if ($whichsupportbutton == get_string('extendedcourse')) { $g = $actionbuttoncolor; }else{ $g = $defaultbuttoncolor; }
        if ($whichsupportbutton == get_string('testresit')) { $h = $actionbuttoncolor; }else{ $h = $defaultbuttoncolor; }
        if ($whichsupportbutton == get_string('ipdcert')) { $i = $actionbuttoncolor; }else{ $i = $defaultbuttoncolor; }
        
        // Button New/Search/Save/Delete 
        echo createinputtext('submit', $a, 'whichsupportbutton', get_string('search'), '', 'margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $action . '"');
        echo createinputtext('submit', $b, 'whichsupportbutton', get_string('new'), '', 'margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $action . '"');
        if ($whichsupportbutton == get_string('new') || $whichsupportbutton == get_string('savebutton')) {
            echo createinputtext('submit', $c, 'whichsupportbutton', get_string('savebutton'), '', 'margin-right:0.5em;line-height:1em;height:28px;');
        }
        
        if ($USER->id == 2) { // only admin able to use delete button
            echo createinputtext('submit', $e, 'whichsupportbutton', get_string('delete'), '', 'margin-right:0.5em;line-height:1em;height:28px;');
        }
        echo createinputtext('button', $d, 'whichsupportbutton', get_string('print'), '', 'margin-bottom:1em;margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $actionprint . '"');
        echo createinputtext('hidden', 'supportform', 'supportform', $supportform);

        echo $simplepagingfinancialhistory=$spagingfh;    // 1 - 10 of X record
        
        echo html_writer::start_tag('div', array('style' => 'float:right; line-height:2.5em;padding-left:0.5em;'));
        if ($supportform == get_string('financialhistory')) {
            echo createinputtext('button', $f, 'whichsupportbutton', get_string('statement'), '', 'margin-bottom:1em;margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $actionstatement . '"');
            echo get_string('outstandingbalance');
            echo ': <b>USD '.outstandingbalance_finance($id).'</b>'; // refer lib
        
        }else if($supportform == get_string('coursehistory')){
            $linksupport .= '&checkoption='.$delcoursehistory;
            $extendtext = optional_param('extend', '', PARAM_MULTILANG); 
            $testresittext = optional_param('resit', '', PARAM_MULTILANG); 
            $erroripdcert = optional_param('erroripdcert', '', PARAM_MULTILANG);
            if(!empty($extendtext)){ echo get_string('courseextensiontext'); }
            if(!empty($testresittext)){ echo get_string('testsittext'); }
            if(!empty($erroripdcert)){ echo get_string('recordsnotfound').' '; } //erroripdcert
            
            if ($whichsupportbutton == get_string('extendedcourse') || $whichsupportbutton == get_string('testresit') || $whichsupportbutton == get_string('ipdcert')) {
                if(empty($delcoursehistory)){ echo get_string('checkatleastone'); }
            }
            echo createinputtext('submit', $g, 'whichsupportbutton', get_string('extendedcourse'), '', 'margin-bottom:1em;margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $action . '"');
            echo createinputtext('submit', $h, 'whichsupportbutton', get_string('testresit'), '', 'margin-bottom:1em;margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $action . '"');
            echo createinputtext('submit', $i, 'whichsupportbutton', get_string('ipdcert'), '', 'margin-bottom:1em;margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $action . '"');    
        
		}else if($supportform == get_string('support') || $supportform == get_string('activities') || $supportform == get_string('attachment')){
            // Support//Activities//Attachment
            //$newtext = optional_param('new', '', PARAM_MULTILANG); 
            //$deletetext = optional_param('delete', '', PARAM_MULTILANG);  
            if(!empty($newtext)){ echo get_string('newaddedtextmsg'); }
            if(!empty($deletetext)){ echo get_string('deletetextmsg'); } 
            if ($whichsupportbutton == get_string('delete')) {
                if(empty($delcoursehistory)){ echo get_string('checkatleastone'); }
            }            
        }
        echo '</div></div>';
        
        // support for user case  // refer lib.php
        /*$f2 = optional_param('debit', '', PARAM_INT); // financial debit
        $f3 = optional_param('credit', '', PARAM_INT); // financial credit
        $f4 = optional_param('financialstatusname', '', PARAM_INT); // financial status
        $f5 = optional_param('financialdesc', '', PARAM_MULTILANG); // financial description
        // Financial search
        $f6 = optional_param('searchdatetimefinance', '', PARAM_MULTILANG); // Search financial credit
        $f7 = optional_param('searchtransactionid', '', PARAM_ALPHANUMEXT); // Search transaction id
        $f9 = optional_param('searchstatus', '', PARAM_ALPHANUMEXT); // Search transaction id
        $f8 = optional_param('searchcreatedby', '', PARAM_INT); // Search created by user  
        // Course History
        $sc1 = optional_param('teststatusname', '', PARAM_INT);
        $sc2 = optional_param('coursetitle', '', PARAM_INT);
        $sc3 = optional_param('testmark', '', PARAM_INT);
        $sc4 = optional_param('datetimesearchfinance', '', PARAM_MULTILANG); // start date
        $sc5 = optional_param('subscriptionenddate', '', PARAM_MULTILANG);     // end date
        
        $enrolnewcourse = optional_param('enrolnewcourse', '', PARAM_INT);
        $generateActivitiyId = optional_param('generateActivitiyId', '', PARAM_ALPHANUMEXT);*/

        $switchcasesupportusers = createdswitchcase($supportform, get_string('support'), get_string('activities'), get_string('attachment'), get_string('financialhistory'), get_string('coursehistory'), $USER->id, $whichsupportbutton, $statusparam, $categoryparam, $descparam, $id, $f2, $f3, $f4, $f5, $delid, $f6, $f7, $f8, $f9, $delcoursehistory, $extenddays, $sc1, $sc2, $sc3, $sc4, $sc5, $enrolnewcourse, $generateActivitiyId, $formtype);
        // End support for user case
        echo html_writer::end_tag('fieldset');  // End 2st fieldset
        echo '</form>';
        break;
    default:
        break;
}

if (!empty($supporttable)) {
   // echo html_writer::table($supporttable);
}
echo html_writer::end_tag('fieldset');  // End 2st fieldset
echo $OUTPUT->footer();
