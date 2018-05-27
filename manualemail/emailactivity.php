<?php

require_once('../config.php');
require_once('../manualdbconfig.php');
require_once('../lib/logactivity_lib.php');
require_once('../lib/moodlelib.php');
require_once('../lib/datalib.php');
require_once('../course/lib.php');
require_once('../lib/enrollib.php');

$page = optional_param('page', 0, PARAM_INT);
$perpage = optional_param('perpage', 100, PARAM_INT);        // how many per page
$sort = optional_param('sort', 'name', PARAM_ALPHA);
$search = optional_param('month', '', PARAM_INT);
$dir = optional_param('dir', 'ASC', PARAM_ALPHA);
$penerimaemel = optional_param('penerimaemel', '', PARAM_MULTILANG);


$PAGE->set_url('/');
$PAGE->set_course($SITE);

$emailactivitys = get_string('emailactivity');
$url = new moodle_url('/manualemail/emailactivity.php');
$PAGE->navbar->add(ucwords(strtolower($emailactivitys)), $url);

$PAGE->set_pagetype('site-index');
$editing = $PAGE->user_is_editing();
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('buy_a_cifa');

echo $OUTPUT->header();

// What day is it now for the user, and when is midnight that day (in GMT).
//$timemidnight = $today = usergetmidnight($timenow);

$courseid = '32';                           // course id
$enrolid = get_coursesenrolid($courseid);   // enrol id
$rolename = get_rolename();                 // user role name
$month = date('m', time());                 // current month
$Y = date('Y', time());                     // current year

/*$recipientusers = $DB->get_recordset_sql("SELECT * FROM {user} WHERE (id='280' Or id='283')");
foreach ($recipientusers as $rusers) {
	echo $rusers->email.'_'.$rusers->firstname.'_'.$rusers->username;
	// email user
	//lms_welcome_email($rusers);
        //manual_sendingmail($rusers);
}*/

    
/*$sql="Select * From {scorm} Where course='32'";
$srecords=$DB->get_recordset_sql($sql);
foreach($srecords as $rc){
	echo $rc->reference;
	echo $grademethod=$rc->grademethod; //0
	echo $skipview=$rc->skipview; //2
	echo $hidebrowse=$rc->hidebrowse; //1
	echo $hidetoc=$rc->hidetoc;	//0
	echo $hidenav=$rc->hidenav;	//1
	echo $auto=$rc->auto; //1 
	echo '<br/>';
	
	//$sqlupdate="Update mdl_cifascorm Set grademethod='0', skipview='2', hidebrowse='1', hidetoc='0', hidenav='1', auto='1' Where id='".$rc->id."'";
	//mysql_query($sqlupdate);
	//echo $run=$DB->execute($sqlupdate);
}
$srecords->close();echo '<br/>';*/
	
    /*$rsc = printScormWithCourseId($courseid);
    $a='0';
    foreach ($rsc as $r) {
       // name of lesson
       echo $r->name;

       // 
       $sql = "Select COUNT(a.id)
                     From
                       {scorm_scoes_track} a
                     Where
                       a.userid='315' AND
                       a.scormid='" . $r->scorm . "' AND
                       a.value = 'completed'
                     ";
       $rs = $DB->count_records_sql($sql);
       echo '(';
       echo 'Chapter completed = ' . $rs;
       echo ' from ';
       print_r(chapteronscorm($r->scorm));
       echo ')<br/>';

       if ($rs == chapteronscorm($r->scorm)) {
           $a++;
       }
    } echo 'Total lesson completed: ' . $a . ' of ' . getTotalScormOnCourse($courseid) . ' Modules';*/


if (isloggedin()) {
    add_to_log(SITEID, 'course', 'view', 'view.php?id=' . SITEID, SITEID);
    if ($USER->id == '2') { //if login and if admin
        echo $OUTPUT->heading(get_string('emailactivity'));

        // we use only manual enrol plugin here, if it is disabled no enrol is done
        /* if (enrol_is_enabled('manual')) {
          $manual = enrol_get_plugin('manual');
          } else {
          $manual = NULL;
          }
          $sql = "Select
          a.fullname, a.id
          From
          mdl_cifacourse a
          Where
          a.visible!='0' And
          (a.category = '3' Or a.category='4' Or a.category='6' Or a.category = '9')
          ";
          foreach($DB->get_recordset_sql($sql) as $cid){
          $courseid = $cid->id;
          $today = time();
          if ($instances = enrol_get_instances($courseid, false)) {
          foreach ($instances as $instance) {
          if ($instance->enrol === 'manual') {
          $autoenrol[$courseid] = $instance;
          break;
          }
          }
          }

          $rid = $autoenrol[$courseid]->roleid;
          $cduration = '150 day'; // 5 month
          if ($rid) {
          // find duration
          $timeend   = 0;
          $duration = (int)$courseduration * 60*60*24; // convert days to seconds
          if ($duration > 0) { // sanity check
          $timeend = $today + $duration;
          }
          $manual->enrol_user($autoenrol[$courseid], '313', $rid, $today, $timeend);
          }
          } */
        /*
          $dbtable = 'user'; ///name of table
          $conditions = array('confirmed' => '1', "deleted"=>'0'); ///the name of the field (key) and the desired value
          $sort = 'id'; //field or fields you want to sort the result by
          $fields = 'id, confirmed, firstname, lastname, dob'; ///list of fields to return

          // $result = $DB->count_records($dbtable, $conditions, $sort, $fields);
          $result = $DB->get_records($dbtable, $conditions, $sort, $fields);

          print_r($result);
         * 
         */

        /* $db=$DB->get_recordset_sql("SELECT * FROM {user} WHERE confirmed='1' AND id='303'");
          foreach($db as $ds){
          print_r($ds->username);
          manual_sendingmail($ds);
          echo '<br/>';
          } */

        $tt = getdate(time());
        $today = mktime(0, 0, 0, $tt["mon"], $tt["mday"], $tt["year"]);

        // Display list of log activity
        //$dbtable = 'log_activity'; ///name of table
        // $conditions = array('confirmed' => '1', "deleted" => '0'); ///the name of the field (key) and the desired value
        //$sort = 'id DESC'; //field or fields you want to sort the result by 
        
        echo "<form method='post' name='submitform'>";
        echo '<input type="text" name="penerimaemel" id="penerimaemel" style="width:300px;" />';
        echo '<input type="submit" name="submitpenerimaemel" id="penerimaemel" value="Submit" />';
        echo '</form>';
        echo $penerimaemel;
        
        $fromrecords=$page * $perpage;
        $dbtable = "Select * From {log_activity}"; 
        if(!empty($penerimaemel)){
            $usercount= $DB->count_records('log_activity', array('recipient'=>$penerimaemel));
            $dbtable .= " Where recipient='".$penerimaemel."'";
        }else{
            $usercount= $DB->count_records('log_activity');
        }
        $dbtable.=" Order By id DESC LIMIT $perpage OFFSET $fromrecords";
        $result = $DB->get_records_sql($dbtable);

        echo '<div style="margin-bottom:1em;"></div>';
        
        $baseurl = new moodle_url('/manualemail/emailactivity.php', array('sort' => $sort, 'dir' => $dir, 'perpage' => $perpage));
        echo $totalrecord='Total Record: '.$usercount;
        echo $OUTPUT->paging_bar($usercount, $page, $perpage, $baseurl);    // bottom paging bar
        echo '<div style="margin-bottom:1em;"></div>';
        
        $table = new html_table();
        $table->head = array("No", "Date", "Activity", "Purpose", "recipient", "Information", "Status");
        $table->align = array("center", "left", "left", "left", "center", "left", "center");
        $table->width = "100%";

        $userc = $page * $perpage + 1;
        foreach ($result as $value) {
            if ($value->status == '0') {
                $status = 'Send';
            } else {
                $status = 'Not Send';
            }
            $datetime = date('d-m-Y', $value->timecreated);
            //$datetime=userdate($value->timecreated);

            $table->data[] = array($userc++,
                $datetime,
                $value->activity,
                $value->purpose,
                $value->recipient,
                $value->information,
                $status
            );
        }
        //

        if (!empty($table)) {
            echo html_writer::table($table);
        }
    } else { //if not admin
        echo '<div style="color:red">You cannot access this page. Thank you.</div>';
    }
} else {
    echo '<div style="color:red">You cannot access this page. Please login.</div>';
}
echo $OUTPUT->paging_bar($usercount, $page, $perpage, $baseurl);    // bottom paging bar
echo '<div style="margin-bottom:1em;"></div>';
echo $OUTPUT->footer();
