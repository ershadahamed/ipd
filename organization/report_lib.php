<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Reporting MAIN here
function reporting_main($whichsupportbutton, $searchtitle, $searchdate, $searchcreatedby) {
    $table = new html_table();
    $table->width = "100%";
    $table->head = array(get_string('reporttitle'), get_string('createdby'), get_string('creationdate'), get_string('view'), get_string('edit'), get_string('email1'), get_string('schedule'), get_string('delete'));
    $table->align = array("center", "center", "center", "center", "center", "center", "center", "center");
    $table->size = array('30%', null, null, '7%', '7%', null, null, null);
    $table->align[0] = 'text-align:left';

    // switch case loop here
    reporting_switchcase($table, $whichsupportbutton, $searchtitle, $searchdate, $searchcreatedby);

    if (!empty($table)) {
        echo html_writer::table($table);
    }
}

// selectcreatedby_financial
function selectcreatedby_report($name) {
    global $DB;

    $sql = "Select reportcreator From {report_menu} Group By reportcreator";
    $getcreatedby = $DB->get_recordset_sql($sql);


    $a = html_writer::start_tag('select', array('name' => $name, 'style' => 'width:100px;'));
    $a.='<option value="">' . get_string('chooseone') . '</option>';
    foreach ($getcreatedby as $gcreatedby) {
        $createdbyname = reportcreatedby($gcreatedby->reportcreator)->name;
        $a.='<option value="' . $gcreatedby->reportcreator . '">' . $createdbyname . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

function reporting_search($table){
    $selectname = 'searchcreatedby';

    $reporttitle = createinputtext('text', 'communicationtitle', 'communicationtitle', '', '', 'width:100%;text-align:left;');
    $creationdatetime = createinputtext('text', 'creationdatetime', 'creationdatetime', '', 'dd-mm-yy', 'width:100%;text-align:center;');
    $createdby = selectcreatedby_report($selectname);      // created by                        // created by     

    $table->data[] = array($reporttitle, $createdby, $creationdatetime, '-', '-', '-', '-', '-');
    return $table;    
}

function reporting_switchcase($table, $whichsupportbutton, $searchtitle, $searchdate, $searchcreatedby) {
    switch ($whichsupportbutton) {
        case get_string('search'):
            reporting_search($table);
            reporting_tabledata($table, $searchtitle, $searchdate, $searchcreatedby);
            break;
        default:
            reporting_tabledata($table, $searchtitle, $searchdate, $searchcreatedby);
    }
}

function reporting_sqldata($searchtitle, $searchdate, $searchcreatedby) {
    global $DB;

    $statement = "
		  mdl_cifareport_menu a Inner Join
		  mdl_cifareport_option b On b.reportid = a.id Inner Join
		  mdl_cifareport_users c On b.reportid = c.reportid
	";
    $sql = "SELECT *, From_UnixTime(timecreated, '%d/%m/%Y') As getdate FROM {$statement}";
    if (!empty($searchtitle)) {
        $sql.=" And a.reportname Like '%" . $searchtitle . "%'";
    }
    if (!empty($searchdate)) {
        $sql.=" And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL a.timecreated SECOND), '%d-%m-%Y') LIKE '%{$searchdate}%'))";
    }
    if (!empty($searchcreatedby)) {
        $sql.=" And a.reportcreator='".$searchcreatedby."'";
    }
    if (!empty($searchtitle) && !empty($searchdate)) {
        $sql.=" WHERE a.reportname Like '%" . $searchtitle . "%' And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL a.timecreated SECOND), '%d-%m-%Y') LIKE '%{$searchdate}%'))";
    }
    $sql.=" GROUP BY b.reportid ORDER BY b.reportid ASC";
    $rs = $DB->get_recordset_sql($sql);

    return $rs;    
}

function reporting_tabledata($table, $searchtitle, $searchdate, $searchcreatedby) {
    global $CFG, $USER;
    $records = reporting_sqldata($searchtitle, $searchdate, $searchcreatedby);
    foreach ($records as $record) {
        $creationdate = date('d/m/Y H:i:s', $record->timecreated);
        $reporttitle = strtoupper($record->reportname);
        $createby = reportcreatedby($record->reportcreator)->name;

        $style = 'width:30px;';

        $viewimage = $CFG->wwwroot . '/image/view_ico.png';
        $editimage = $CFG->wwwroot . '/image/edit_ico.png';
        $emailimage = $CFG->wwwroot . '/image/email_ico.png';
        $sheduleimage = $CFG->wwwroot . '/image/schedule_ico.png';
        $deleteimage = $CFG->wwwroot . '/image/delete_ico.png';

        $vpath = $CFG->wwwroot . '/examcenter/progressreport.php?id=' . $record->reportid . '&sid=' . $record->selectedreport;
        $schedulepath = $CFG->wwwroot . '/examcenter/schedulling.php?id=' . $USER->id . '&rid=' . $record->reportid . '&sid=' . $record->selectedreport;
        $editpath = $CFG->wwwroot . '/examcenter/editreport.php?id=' . $record->reportid . '&sid=' . $record->selectedreport;
        $deletepath = $CFG->wwwroot . '/examcenter/deletemyreport.php?rid=' . $record->reportid . '&sid=' . $record->selectedreport;
        $viewlink = "window.open('" . $vpath . "','_blank')";
        $editlink = "window.open('" . $editpath . "','_blank')";

        $view = '<input name="whichbutton" type="image" style="width:38px" src="' . $viewimage . '" Onclick="' . $viewlink . '" />';
        $edit = '<input name="whichbutton" type="image" style="' . $style . '" src="' . $editimage . '" Onclick="' . $editlink . '" />';
        $email = "<a href='" . $emailpath . "'><img src='" . $emailimage . "' style='width:25px;' /></a>";
        $schedule = "<a href='" . $schedulepath . "'><img src='" . $sheduleimage . "' style='width:25px;' /></a>";
        $delete = "<a href='" . $deletepath . "'><img src='" . $deleteimage . "' style='width:25px;' /></a>";

        $table->data[] = array($reporttitle, $createby, $creationdate, $view, $edit, $email, $schedule, $delete);
    }
}

function reportcreatedby($reportcreatorid) {
    global $DB;

    $sql = " Select
        *
      From
        mdl_cifarole a Inner Join
        mdl_cifarole_assignments b On a.id = b.roleid
      Where
        b.userid = '" . $reportcreatorid . "' And
        b.contextid = '1'";
    $rs = $DB->get_record_sql($sql);
    return $rs;
}
