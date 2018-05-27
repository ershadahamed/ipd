<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function buildcommunicationdb($searchcommunicationtitle, $searchcreatedby, $searchdate) {
    global $DB;

    $sql = "Select *, From_UnixTime(timecreated, '%d/%m/%Y') As getdate From {communication} Where deletestatus='0'";
    if (!empty($searchcommunicationtitle)) {
        $sql.=" And title Like '%" . $searchcommunicationtitle . "%'";
    }
    if (!empty($searchdate)) {
        $sql.=" And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL timecreated SECOND), '%d-%m-%Y') LIKE '%{$searchdate}%'))";
    }
    if (!empty($searchcreatedby)) {
        $sql.=" And createdby='2'";
    }
    $sql.=" Order By communicationcode Asc";
    $data = $DB->get_records_sql($sql);
    return $data;
}

function communication_default($table, $formtype, $searchcommunicationtitle, $searchcreatedby, $searchdate) {
    global $CFG, $DB, $USER;
    $communicationdb = buildcommunicationdb($searchcommunicationtitle, $searchcreatedby, $searchdate);
    foreach ($communicationdb as $data) {
        $sql = 'Select COUNT(DISTINCT id) From {communication} Where communicationcode LIKE "COM%" And id="' . $data->id . '"';
        $c = $DB->count_records_sql($sql);

        $createdby = createdbyuser($data->createdby);
        $creationdate = date('d/m/Y H:i:s', $data->timecreated);
        $style = 'width:30px;';

        $viewimage = $CFG->wwwroot . '/image/view_ico.png';
        $editimage = $CFG->wwwroot . '/image/edit_ico.png';
        $emailimage = $CFG->wwwroot . '/image/email_ico.png';
        $sheduleimage = $CFG->wwwroot . '/image/schedule_ico.png';
        $deleteimage = $CFG->wwwroot . '/image/delete_ico.png';
        $link = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype;

        if (!empty($data->url_path_view)) {
            $vpath = $CFG->wwwroot . '' . $data->url_path_view;
            $viewlink = "window.open('" . $vpath . "','_blank')";
        }
        if (!empty($data->url_path_edit)) {
            $editpath = $CFG->wwwroot . '' . $data->url_path_edit;
            $editlink = "window.open('" . $editpath . "','_blank')";
        }

        $emailpath = $link . '&imagebutton=' . get_string('email1') . '&communicationid=' . $data->id;
        $schedulepath = $link . '&imagebutton=' . get_string('schedule') . '&communicationid=' . $data->id;
        $deletepath = $link . '&imagebutton=' . get_string('delete') . '&communicationid=' . $data->id;

        $view = '<input name="whichbutton" type="image" style="width:38px" src="' . $viewimage . '" Onclick="' . $viewlink . '" />';
        $edit = '<input name="whichbutton" type="image" style="' . $style . '" src="' . $editimage . '" Onclick="' . $editlink . '" />';

        if ($c == '1') {
            $email = ' - ';
            $schedule = ' - ';
        } else {
            $email = "<a href='" . $emailpath . "'><img src='" . $emailimage . "' style='width:25px;' /></a>";
            $schedule = "<a href='" . $schedulepath . "'><img src='" . $sheduleimage . "' style='width:25px;' /></a>";
        }

        // Only available for SA
        if ($USER->id == '2') {
            $delete = "<a href='" . $deletepath . "'><img src='" . $deleteimage . "' style='width:25px;' /></a>";
        } else {
            $delete = '-';
        }
        $table->data[] = array($data->title, $createdby, $creationdate, $view, $edit, $email, $schedule, $delete);
    }
    return $table;
}

function communication_new($table, $logginuserid) {
    global $CFG;

    $creationdatedefault = time();
    $display_creationdatedefault = date('d-m-Y', $creationdatedefault);

    $communicationtitle = createinputtext('text', 'communicationtitle', 'communicationtitle', '', '', 'width:100%;text-align:left;');
    $sstartdate = createinputtext('text', 'creationdatedisplay', 'creationdatedisplay', $display_creationdatedefault, 0, 'width:100%;text-align:center;');
    $creationdatetime = createinputtext('hidden', 'creationdatetime', 'creationdatetime', $creationdatedefault);
    $viewlink = createinputtext('text', 'viewlink', 'viewlink', '', $CFG->wwwroot, 'width:100%;');
    $editlink = createinputtext('text', 'editlink', 'editlink', '', $CFG->wwwroot, 'width:100%;');
    $createdby = createinputtext('hidden', 'searchcreatedby', 'searchcreatedby', $logginuserid);                        // created by     

    $table->data[] = array($communicationtitle, $createdby . createdbyuser($logginuserid), $creationdatetime . $sstartdate, $viewlink, $editlink, '-', '-', '-');
    return $table;
}

function communication_save($formtype, $creationdatetime, $communicationtitle, $createdby, $viewlink, $editlink) {
    global $DB, $CFG;
    $insertdata = new stdClass();
    $insertdata->title = $communicationtitle;
    $insertdata->url_path_view = $viewlink;
    $insertdata->url_path_edit = $editlink;
    $insertdata->timecreated = $creationdatetime;
    $insertdata->timemodified = time();
    $insertdata->createdby = $createdby;
    $DB->insert_record('communication', $insertdata, false);

    $redirecturl = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype;
    die("<script>location.href = '" . $redirecturl . "'</script>");
}

function communication_search($table) {
    $selectname = 'searchcreatedby';

    $communicationtitle = createinputtext('text', 'communicationtitle', 'communicationtitle', '', '', 'width:100%;text-align:left;');
    $creationdatetime = createinputtext('text', 'creationdatetime', 'creationdatetime', '', 'dd-mm-yy', 'width:100%;text-align:center;');
    $createdby = selectcreatedby_financial($selectname);      // created by                        // created by     

    $table->data[] = array($communicationtitle, $createdby, $creationdatetime, '-', '-', '-', '-', '-');
    return $table;
}

function communication_switchcase($table, $whichsupportbutton, $logginuserid, $formtype, $creationdatetime, $communicationtitle, $createdby, $viewlink, $editlink) {
    // echo $communicationtitle.'<br/>'.$creationdatetime.'<br/>'.$createdby;
    switch ($whichsupportbutton) {
        case get_string('search'):
            communication_search($table);
            communication_default($table, $formtype, $communicationtitle, $createdby, $creationdatetime);
            break;
        case get_string('new'):
            communication_new($table, $logginuserid);
            communication_default($table, $formtype);
            break;
        case get_string('savebutton'):
            communication_save($formtype, $creationdatetime, $communicationtitle, $createdby, $viewlink, $editlink);
            break;
        default:
            communication_default($table, $formtype, $communicationtitle, $createdby, $creationdatetime);
    }
}

// Communication MAIN here
function communication_main($userid, $whichsupportbutton, $logginuserid, $formtype, $creationdatetime, $communicationtitle, $createdby, $viewlink, $editlink) {
    $table = new html_table();
    $table->width = "100%";
    $table->head = array(get_string('communicationtitle'), get_string('createdby'), get_string('creationdate'), get_string('view'), get_string('edit'), get_string('email1'), get_string('schedule'), get_string('delete'));
    $table->align = array("center", "center", "center", "center", "center", "center", "center", "center");
    $table->size = array('30%', null, null, '7%', '7%', null, null, null);
    $table->align[0] = 'text-align:left';

    // switch case loop here
    communication_switchcase($table, $whichsupportbutton, $logginuserid, $formtype, $creationdatetime, $communicationtitle, $createdby, $viewlink, $editlink);

    if (!empty($table)) {
        echo html_writer::table($table);
    }
}

function communicationdb_list($communicationid) {
    global $DB;
    $sql = "Select *, From_UnixTime(timecreated, '%d/%m/%Y') As getdate From {communication} Where id='" . $communicationid . "' And deletestatus='0'";
    return $DB->get_record_sql($sql);
}

function buildcommunicationdb_list($communicationid) {
    global $DB;
    $sql = "Select *, From_UnixTime(timecreated, '%d/%m/%Y') As getdate From {communication_schedule} Where communicationid='" . $communicationid . "' And status='0'";
    return $DB->get_records_sql($sql);
}

function weeklyscheduling($scheduling_time) {
    if ($scheduling_time == 1) {
        return 'Monday';
    } else if ($scheduling_time == 2) {
        return 'Tuesday';
    } else if ($scheduling_time == 3) {
        return 'Wednesday';
    } else if ($scheduling_time == 4) {
        return 'Thursday';
    } else if ($scheduling_time == 5) {
        return 'Friday';
    } else if ($scheduling_time == 6) {
        return 'Saturday';
    } else if ($scheduling_time == 7) {
        return 'Sunday';
    }
}

// list all recipient
function recipientlist_popup($communicationid, $scheduleid) {
    global $DB;
    $sql = "Select *, From_UnixTime(timecreated, '%d/%m/%Y') As getdate From {communication_schedulinguser} Where scheduleid='" . $scheduleid . "' And communicationid='" . $communicationid . "' And status='0'";
    return $DB->get_records_sql($sql);
}

function schedulelist_default($userid, $table, $communicationid, $formtype, $imagebutton) {
    global $CFG, $DB, $USER;
    $communicationmain = buildcommunicationdb_list($communicationid);
    foreach ($communicationmain as $communication) {
        $countrecords = $DB->count_records('communication_schedulinguser', array('communicationid' => $communicationid, 'scheduleid' => $communication->id));
        $editimage = $CFG->wwwroot . '/image/edit_ico.png';
        $deleteimage = $CFG->wwwroot . '/image/delete_ico.png';
        $deletepath = $CFG->wwwroot . '/organization/orgview.php?formtype=Communication&imagebutton=' . $imagebutton . '&communicationid=' . $communicationid . '&scheduledelid=' . $communication->id;

        $editpath = $CFG->wwwroot . '/organization/communicationhome_process.php?formtype=' . $formtype;
        $editpath .= '&imagebutton=' . $imagebutton . '&whichbutton=' . get_string('new') . '&communicationid=' . $communicationid . '&utype=' . get_string('individual') . '&scheduleid=' . $communication->id;

        $edit = "<a href='" . $editpath . "' target='_blank'><img src='" . $editimage . "' style='width:30px;' /></a>";
        if($USER->id=='2'){
        $delete = "<a href='" . $deletepath . "' class='delbutton'><img src='" . $deleteimage . "' style='width:25px;' /></a>";
        }else{ $delete='-';}

        $popup = 'popupwindow("' . $CFG->wwwroot . '/organization/communicationrecipientlist.php?id=' . $communicationid . '&sid=' . $communication->id . '", "googlePopup", 880, 630);';
        $recipientlist = "<u><a style='cursor: pointer' Onclick='" . $popup . "'> (" . $countrecords . ") </a></u>";

        // $sendschedule = 'Daily/Weekly/Monthly';
        // $communicationtitle = communicationdb_list($communicationid)->title;
        $communicationtitle = communicationdb_logmessage($communication->id)->subject;
        if ($communication->scheduling == 'daily') {
            $sendschedule = get_string('daily');
        } else if ($communication->scheduling == get_string('scheduleweekly')) {
            $sendschedule = 'Weekly, ' . weeklyscheduling($communication->scheduling_time);
        } else if ($communication->scheduling == 'schedulemonthly') {
            $sendschedule = 'Monthly, ' . $communication->scheduling_time;
        } else if ($communication->scheduling == 'specificdate') {
            $sendschedule = $communication->scheduling_time;
        }
        // Status Here
        $communicationlogmessage = communicationdb_logmessage($communication->id)->action;
        if ($communicationlogmessage == '1') {/* save */
            $status = get_string('saved');
        } elseif ($communicationlogmessage == '2') { /* send */
            $status = get_string('send');
        }else{
            $status = ' - ';
        }

        // table content
        $table->data[] = array($communicationtitle, createdbyuser($userid), $recipientlist, $sendschedule, $status, $edit, $delete);
    }

    return $table;
}

function communicationdb_logmessage($communicationscheduleid) {
    global $DB;
    $sql = "Select * From {communicationmessage_log} Where scheduleid='" . $communicationscheduleid . "'";
    $data = $DB->get_record_sql($sql);
    return $data;
}

function schedulepart_main($userid, $communicationid, $formtype, $imagebutton) {
    $table = new html_table();
    $table->width = "100%";
    $table->head = array(get_string('communicationtitle'), get_string('createdby'), get_string('recipient'), get_string('sendschedule'), get_string('status'), get_string('edit'), get_string('delete'));
    $table->align = array("center", "center", "center", "center", "center", "center");
    $table->size = array('30%', '24%', '15%', '15%', '8%', '8%');
    $table->align[0] = 'text-align:left';

    schedulelist_default($userid, $table, $communicationid, $formtype, $imagebutton);
    if (!empty($table)) {
        echo html_writer::table($table);
    }
}

// communication action image DELETE
function communication_subaction($userid, $formtype, $imagebutton, $whichbutton, $communicationid) {
    global $DB, $CFG;

    switch ($imagebutton) {
        case get_string('email1'):
            // echo 'Sini Email Part';
            schedulepart_main($userid, $communicationid, $formtype, $imagebutton);
            break;
        case get_string('delete'):
            $deletedata = new stdClass();
            $deletedata->id = $communicationid;
            $deletedata->deletestatus = 1;
            $DB->update_record('communication', $deletedata, false);

            $redirecturl = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&delete=1';
            die("<script>location.href = '" . $redirecturl . "'</script>");
            break;
        case get_string('schedule'):
            schedulepart_main($userid, $communicationid, $formtype, $imagebutton);
            break;
    }
}

function displaybutton($imagebutton, $newbutton, $savebutton) {
    switch ($imagebutton) {
        case get_string('schedule'):
            echo $newbutton;
            echo $savebutton;
            break;
        case get_string('email1'):
            echo $newbutton;
            echo $savebutton;
            break;
        default:
    }
}

// Schedule new button
function schedulenewsave_button($imagebutton, $whichbutton, $actionbuttoncolor, $buttoncolor, $formtype, $communicationid) {
    global $CFG;
    if ($whichbutton == get_string('new')) {
        $b = $actionbuttoncolor;
    } else {
        $b = $buttoncolor;
    }
    if ($whichbutton == get_string('savebutton')) {
        $c = $actionbuttoncolor;
    } else {
        $c = $buttoncolor;
    }

    $new = $CFG->wwwroot . '/organization/communicationhome_process.php?formtype=' . $formtype;
    $new .= '&imagebutton=' . get_string('schedule') . '&whichbutton=' . get_string('new') . '&communicationid=' . $communicationid . '&utype=' . get_string('individual');
    $newlink = "window.open('" . $new . "','_blank')";

    $newbutton = createinputtext('button', $b, 'whichbutton', get_string('new'), '', 'margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $newlink . '"');
    if ($whichbutton == get_string('new') || $whichbutton == get_string('savebutton')) {
        $savebutton = createinputtext('submit', $c, 'whichbutton', get_string('savebutton'), '', 'margin-right:0.5em;line-height:1em;height:28px;');
    }

    displaybutton($imagebutton, $newbutton, $savebutton);
}

// Organization recipient
function recipient_organization() {
    $table = new html_table();
    $table->width = "100%";
    $table->head = array(get_string('candidateid'), get_string('firstname'), get_string('lastname'), get_string('dob'), get_string('organization'), '');
    $table->align = array("center", "center", "center", "center", "center", "center");
    $table->size = array('17%', '25%', '25%', '16%', '16%', '1%');
    $table->align[0] = 'text-align:left';

    if (!empty($table)) {
        echo html_writer::table($table);
    }
}

function schedulelist_recipient($table) {

    $checkbox = createinputcheckdelete('checkbox', 'delcoursehistory', "delcoursehistory[]", '');
    $table->data[] = array($communicationtitle, createdbyuser($userid), $recipientlist, $sendschedule, $edit, $checkbox);

    return $table;
}

// INDIVIDUAL Recipient
function recipient_individual() {
    $table = new html_table();
    $table->width = "100%";
    $table->head = array(get_string('candidateid'), get_string('firstname'), get_string('lastname'), get_string('dob'), get_string('organization'), '');
    $table->align = array("center", "center", "center", "center", "center", "center");
    $table->size = array('17%', '25%', '25%', '16%', '16%', '1%');
    $table->align[0] = 'text-align:left';

    schedulelist_recipient($table);

    if (!empty($table)) {
        echo html_writer::table($table);
    }
}

function printall_data($b, $a, $printname, $formtype, $cid) {
    global $CFG;
    $printlink = $CFG->wwwroot . '/organization/' . $printname . '.php?id=' . $cid . '&type=' . $formtype;
    $actionprint = "window.open('" . $printlink . "','_blank')";

    echo createinputtext('submit', $b, 'whichsupportbutton', get_string('search'), '', 'margin-right:0.5em;line-height:1em;height:28px;');
    echo createinputtext('button', $a, 'whichsupportbutton', get_string('print'), '', 'margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $actionprint . '"');
}

function communicationnewsave_button($whichsupportbutton, $actionbuttoncolor, $buttoncolor, $formtype) {
    global $CFG, $USER;

    if ($whichsupportbutton == get_string('new')) {
        $b = $actionbuttoncolor;
    } else {
        $b = $buttoncolor;
    }
    if ($whichsupportbutton == get_string('savebutton')) {
        $c = $actionbuttoncolor;
    } else {
        $c = $buttoncolor;
    }
    $newbutton = createinputtext('submit', $b, 'whichsupportbutton', get_string('new'), '', 'margin-right:0.5em;line-height:1em;height:28px;');
    if ($whichsupportbutton == get_string('new') || $whichsupportbutton == get_string('savebutton')) {
        $savebutton = createinputtext('submit', $c, 'whichsupportbutton', get_string('savebutton'), '', 'margin-right:0.5em;line-height:1em;height:28px;');
    }
    switch ($formtype) {
        case get_string('communication'):
            echo $newbutton;
            echo $savebutton;
            break;
        case get_string('reporting'):
            $vpath = $CFG->wwwroot . '/examcenter/reportmenu.php?id=' . $USER->id;
            $viewlink = "window.open('" . $vpath . "','_blank')";
            echo '<input name="whichbutton" type="button" value="' . get_string('new') . '" style="margin-right:0.5em;line-height:1em;height:28px;" Onclick="' . $viewlink . '" />';
            break;
        default:
    }
}

// create time list
function createtimepicker($starttimepickerid, $valuetimepicker) {
    echo "<select id='" . $starttimepickerid . "' name='" . $starttimepickerid . "'>";
    echo '<option value=""> </option>';
    for ($i = 1; $i <= 24; $i++):
        echo '<option value="' . $i . '"';
        if ($valuetimepicker == $i) {
            echo 'selected="selected"';
        }
        echo ' >' . date("h.iA", strtotime("$i:00")) . '</option>';
    endfor;
    echo "</select>";
}

function getscheduleid($communicationid){
    global $DB;
    
    $sql="SELECT * FROM {communication_schedule} Where communicationid='".$communicationid."' ORDER BY id DESC";
    return $DB->get_record_sql($sql);
}

function communicationschedulinguser($userid, $communicationid, $scheduleid) {
    global $DB;
    $insertdata = new stdClass();
    $insertdata->userid = $userid;
    $insertdata->communicationid = $communicationid;
    $insertdata->timecreated = time();
    if (!empty($scheduleid)) {
        $insertdata->scheduleid = $scheduleid;
    }

    return $DB->insert_record('communication_schedulinguser', $insertdata, false);
}

function schedulingdata($communicationid, $utype, $scheduling, $scheduling_time, $startdate, $enddate, $starttime, $endtime, $createdby, $coscheduleid) {
    global $DB, $CFG;

    $countscheduling = $DB->count_records('communication_schedule', array('id' => $coscheduleid));
    if ($countscheduling == '0') {
        // Insert record to communication_schedule table
        $insert = mysql_query("Insert Into {$CFG->prefix}communication_schedule (communicationid, utype, scheduling, scheduling_time, startdate, enddate, starttime, endtime, timecreated, timemodified, createdby) "
                . "Values ('$communicationid', '$utype', '$scheduling','$scheduling_time', '$startdate', '$enddate','$starttime','$endtime','" . time() . "','" . time() . "','" . $createdby . "')");
        $scheduleid = mysql_insert_id();

        $sql2 = "Select * From {communication_schedulinguser} Where communicationid='" . $communicationid . "' And scheduleid='0' And status='0' Order By id Desc";
        $cmain = $DB->get_records_sql($sql2);
        foreach ($cmain as $csm) {
            // update scheduleid
            mysql_query("Update {$CFG->prefix}communication_schedulinguser SET scheduleid='" . $scheduleid . "' Where id='" . $csm->id . "'");
        }
    } else {
        // UPDATE scheduling records
        $insert = communication_updatescheduling($coscheduleid, $utype, $scheduling, $scheduling_time, $startdate, $enddate, $starttime, $endtime, $createdby);
    }
    return $insert;
}

function communication_updatescheduling($coscheduleid, $utype, $scheduling, $scheduling_time, $startdate, $enddate, $starttime, $endtime, $createdby) {
    global $DB;

    $updatedata = new stdClass();
    $updatedata->id = $coscheduleid;
    $updatedata->utype = $utype;
    $updatedata->scheduling = $scheduling;
    $updatedata->scheduling_time = $scheduling_time;
    $updatedata->startdate = $startdate;
    $updatedata->enddate = $enddate;
    $updatedata->starttime = $starttime;
    $updatedata->endtime = $endtime;
    $updatedata->timemodified = time();
    $updatedata->createdby = $createdby;

    $insert = $DB->update_record('communication_schedule', $updatedata, false);
    return $insert;
}

/*
 * Display table, list of users. 
 */

function communicationtableofusers_editscheduling($statement, $communicationid, $scheduleid) {
    $table = new html_table();
    $table->head = array(get_string('candidateid'), get_string('firstname'), get_string('lastname'), get_string('dob'), get_string('designation'), get_string('organization'), "");
    $table->align = array("center", "left", "left", "center", "left", "left", "center");
    $table->width = "98%";
    $table->attributes = array('style' => 'margin-left:auto;margin-right:auto');

    foreach (build_sqllist($statement) as $users) {
        $selecteduserid = communication_selecteduser($communicationid, $scheduleid, $users->id);
        // dob 
        if ($users->dob != '') {
            $udob = date('d/m/Y', $users->dob);
        } else {
            $udob = ' - ';
        }
        // Sub organization name
        $organization = listoutall_groupusers($users->userid);
        if ($organization->subgroupname != '') {
            $subgroupname = $organization->subgroupname;
        } else {
            $subgroupname = ' - ';
        }
        // designation
        if ($users->designation != '') {
            $designation = ucwords(strtolower($users->designation));
        } else {
            $designation = ' - ';
        }

        $cbox = '<input type="checkbox" name="checktoken[]" id="checktoken[]" value="' . $users->userid . '"';
        if (!empty($selecteduserid)) {
            $cbox .= ' checked';
        }
        $cbox .= ' />';
        $table->data[] = array(strtoupper($users->traineeid), $users->firstname, $users->lastname, $udob, $designation, $subgroupname, $cbox);
    }
    if (!empty($table)) {
        echo html_writer::table($table);
    }
}

function communication_selecteduser($communicationid, $scheduleid, $userid) {
    global $DB;

    $sql = "Select
        COUNT(DISTINCT b.userid)
      From
        mdl_cifacommunication_schedule a Inner Join
        mdl_cifacommunication_schedulinguser b On a.id = b.scheduleid
      Where
        a.id = '" . $scheduleid . "' And b.userid = '" . $userid . "' And
        b.communicationid = '" . $communicationid . "'";
    $record = $DB->count_records_sql($sql);

    return $record;
}

function get_communicationschedulingusers($scheduleid) {
    global $DB;

    $sql = "Select * From {communication_schedule} Where id='" . $scheduleid . "'";
    $rs = $DB->get_record_sql($sql);
    return $rs;
}

function selected_recipientformail($scheduleid) {
    global $DB;

    $sql = "Select * From {communication_schedulinguser} Where scheduleid='" . $scheduleid . "'";
    $rs = $DB->get_recordset_sql($sql);
    return $rs;
}

function communication_weeklyselection($selected) {
    $select = html_writer::start_tag('select', array('id' => 'scheduleweekly', 'name' => 'scheduleweekly'));
    $selectclose = html_writer::end_tag('select');
    $status = array();
    $status[1] = 'Monday';
    $status[2] = 'Tuesday';
    $status[3] = 'Wednesday';
    $status[4] = 'Thursday';
    $status[5] = 'Friday';
    $status[6] = 'Saturday';
    $status[7] = 'Sunday';
    // $a .= $select;
    $select .= '<option value="">' . get_string('chooseone') . '</option>';
    foreach ($status as $key => $orgstatus) {
        $select .= '<option value="' . $key . '"';
        if ($key == $selected) {
            $select .= 'selected="selected"';
        }
        $select .= '>' . $orgstatus . '</option>';
    }
    $select .= $selectclose;
    return $select;
}

// delete communuucation scheduling
function deletecommunication_schedule($communicationid, $scheduledeleteid, $formtype, $imagebutton) {
    global $DB, $CFG;

    $updatedata = new stdClass();
    $updatedata->id = $scheduledeleteid;
    $updatedata->status = 1;
    $DB->update_record('communication_schedule', $updatedata, false);

    $sql = "UPDATE {$CFG->prefix}communication_schedulinguser SET status='1' WHERE communicationid='" . $communicationid . "' AND scheduleid='" . $scheduledeleteid . "'";
    $DB->execute($sql);
    // $update = array($update1, $update2);
    // return $update;

    $redirecturl = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&imagebutton=' . $imagebutton . '&communicationid=' . $communicationid;
    echo '<script type="text/javascript">';
    echo "window.alert('Schedule Deleted Successfully');";
    echo '</script>';
    die("<script>location.href = '" . $redirecturl . "'</script>");
}

function attachment_names($draft) {
    global $USER;

    $usercontext = get_context_instance(CONTEXT_USER, $USER->id);

    $fs = get_file_storage();
    $files = $fs->get_area_files($usercontext->id, 'user', 'draft', $draft, 'id');

    $only_files = array_filter($files, function($file) {
        return !$file->is_directory() and $file->get_filename() != '.';
    });

    $only_names = function ($file) {
        return $file->get_filename();
    };

    $only_named_files = array_map($only_names, $only_files);

    return implode(',', $only_named_files);
}

function process_attachments($context, $email, $id) {
    global $CFG, $USER;

    $base_path = "temp/block_quickmail/{$USER->id}";
    $moodle_base = "$CFG->dataroot/$base_path";

    if (!file_exists($moodle_base)) {
        mkdir($moodle_base, 0777, true);
    }

    $zipname = $zip = $actual_zip = '';

    if (!empty($email->attachment)) {
        $zipname = "attachment.zip";
        $zip = "$base_path/$zipname";
        $actual_zip = "$moodle_base/$zipname";

        $packer = get_file_packer();
        $fs = get_file_storage();

        $files = $fs->get_area_files(
                $context->id, 'communicationmessage_log', 'attachment', $id, 'id'
        );

        $stored_files = array();

        foreach ($files as $file) {
            if ($file->is_directory() and $file->get_filename() == '.')
                continue;

            $stored_files[$file->get_filepath() . $file->get_filename()] = $file;
        }

        $packer->archive_to_pathname($stored_files, $actual_zip);
    }

    return array($zipname, $zip, $actual_zip);
}
