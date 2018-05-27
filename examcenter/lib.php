<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Create SQL schedule/
 */
function build_sqllist($statement) {
    global $DB;
    $csql = "SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} GROUP BY d.traineeid ORDER BY d.traineeid ASC";
    $gb = $DB->get_recordset_sql($csql);

    return $gb;
}

/*
 * Display table, list of users. 
 */
function display_tableofusers_report($statement) {
    $table = new html_table();
    $table->head = array(get_string('candidateid'), get_string('firstname'), get_string('lastname'), get_string('dob'), get_string('designation'), get_string('organization'), "");
    $table->align = array("center", "left", "left", "center", "left", "left", "center");
    $table->width = "98%";
    $table->attributes = array('style' => 'margin-left:auto;margin-right:auto');

    foreach (build_sqllist($statement) as $users) {
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
        $cbox = '<input type="checkbox" name="checktoken[]" id="checktoken[]" value="' . $users->userid . '" />';
        $table->data[] = array(strtoupper($users->traineeid), $users->firstname, $users->lastname, $udob, $designation, $subgroupname, $cbox);
    }
    if (!empty($table)) {
        echo html_writer::table($table);
    }
}
