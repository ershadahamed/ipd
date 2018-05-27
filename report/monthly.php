<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * Create by arizan abdullah - 09022015
 */

require('../config.php');
require('../manualdbconfig.php');
require('../organization/lib.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/user/filters/lib.php');

$page = optional_param('page', 0, PARAM_INT);
$perpage = optional_param('perpage', 30, PARAM_INT);        // how many per page
$sort = optional_param('sort', 'name', PARAM_ALPHA);
$search = optional_param('month', '', PARAM_INT);
$dir = optional_param('dir', 'ASC', PARAM_ALPHA);

$SITE = get_site();
$PAGE->set_course($SITE);
$PAGE->set_url($CFG->wwwroot . '/report/monthly.php?month=' . $search);
$PAGE->set_pagetype('site-index');
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('buy_a_cifa');

$report = get_string('report');
$monthlytitle = get_string('monthlyreport', 'admin');
$url = $CFG->wwwroot . '/report/monthly.php';
$PAGE->navbar->add(ucwords(strtolower($report)), $url)->add(ucwords(strtolower($monthlytitle)), $url);

echo $OUTPUT->header();
echo $OUTPUT->heading($monthlytitle);

$courseid = '32';                           // course id
$enrolid = get_coursesenrolid($courseid);   // enrol id
$rolename = get_rolename_candidate();       // user role name
$month = date('m', time());                 // current month
$Y = date('Y', time());                     // current year
// form
echo '<form name="searchform" id="searchform" method="post">';
$months = array();
for ($i = 0; $i < 12; $i++) {
    $timestamp = mktime(0, 0, 0, date('n') + $i, 1);
    $months[date('n', $timestamp)] = date('F', $timestamp);
}
echo '<div style="margin-bottom:1em;"></div>';
?>
Expiry Month to display:
<select name="month">
    <option value=" "> - Month - </option>
    <option value="01">January</option>
    <option value="02">February</option>
    <option value="03">March</option>
    <option value="04">April</option>
    <option value="05">May</option>
    <option value="06">June</option>
    <option value="07">July</option>
    <option value="08">August</option>
    <option value="09">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
<?php
/*foreach ($months as $num => $name) {
    printf('<option value="%u">%s</option>', $num, $name);
}*/
?>
</select>
<input type="submit" id="cari" name="cari" value="Search" />
</form>
<?php
echo '<div style="margin-bottom:1em;"></div>';
$usercount = count_listout_userswithstatus($enrolid, $rolename, $page * $perpage, $perpage, $search);
$baseurl = new moodle_url('/report/monthly.php', array('sort' => $sort, 'dir' => $dir, 'perpage' => $perpage));
if ($search == '') {
    echo $OUTPUT->paging_bar($usercount, $page, $perpage, $baseurl);    // Upper paging bar
}

$table = new html_table();
$table->head = array("No", get_string('candidateid'), get_string('fullname'), get_string('email'), get_string('empstartdate'), get_string('enddateregistration'), get_string('lastaccess'));
$table->align = array("center", "center", "left", "left", "center", "center", "center");
$table->width = "100%";
$table->attributes = array('style' => 'margin:1em auto;');
$no = $page * $perpage + 1;

// if($monthdata != ''){ $sqlcourse.= " AND (date_format(from_unixtime(c.timecreated), '%m') LIKE '%".$monthdata."%')"; }
foreach (listout_userswithstatus($enrolid, $rolename, $page * $perpage, $perpage, $search) as $users) {
    // Candidate fullname
    if ($users->middlename != '') {
        $userfullname = $users->firstname . ' ' . $users->middlename . ' ' . $users->lastname;
    } else {
        $userfullname = $users->firstname . ' ' . $users->lastname;
    }

    $startdate = $users->timecreated;                                   // registration start date
    $expirydate = $users->expirydate;    // registration expiry
    if ($users->lastaccess != '0') {
        $lastaccess = $users->lastuseraccess;
    } else {
        $lastaccess = get_string('never');
    }

    if(checkuserstatus($users->userid)=='Inactive'){
       $a = '<span style="background-color: red; color:#fff;font-weight:bolder;">' . $expirydate . '</span>';  
    }else{
        $a = $expirydate;
    }
    
    
    /*if ((date('m', strtotime($users->lasttimecreated)) == $month) && date('Y', strtotime($users->lasttimecreated)) == $Y) {
        $a = '<span style="background-color: #FFFF00">' . $expirydate . '</span>';  // make it highlight with yellow
    } elseif ((date('m', strtotime($users->lasttimecreated)) < $month) || date('Y', strtotime($users->lasttimecreated)) < $Y) {
        $a = '<span style="background-color: red; color:#fff;font-weight:bolder;">' . $expirydate . '</span>';  // make it highlight with RED
    } else {
        $a = $expirydate;
    }*/

    // create data
    $table->data[] = array($no++, strtoupper($users->traineeid), $userfullname, $users->email, $startdate, $a, $lastaccess);
}
if (!empty($table)) {
    echo html_writer::table($table);    // display the table
}
if ($search == '') {
    echo $OUTPUT->paging_bar($usercount, $page, $perpage, $baseurl);    // bottom paging bar
}
echo '<div style="margin-bottom:1em;"></div>';
echo $OUTPUT->footer();
