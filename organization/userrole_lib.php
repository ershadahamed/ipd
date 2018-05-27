<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// User Role MAIN here
function userrole_main($userid, $whichsupportbutton, $searchrole, $searchroledesc) {
    $table = new html_table();
    $table->width = "100%";
    if (($userid == '0')) {
        $table->head = array(get_string('roletitle'), get_string('description'), get_string('assigneduser'));
        $table->align = array("center", "center", "center");
        $table->size = array('20%', '40%', '10%');
    } else {
        $table->head = array(get_string('roletitle'), get_string('description'), get_string('assigneduser'), get_string('edit'), get_string('assign'), get_string('delete'));
        $table->align = array("center", "center", "center", "center", "center", "center");
        $table->size = array('20%', '40%', '10%', '10%', '10%', '10%');
    }
    $table->align[0] = 'text-align:left';
    $table->align[1] = 'text-align:left';

    // switch case loop here
    if ($whichsupportbutton == get_string('search')) {
        userrole_search($table);
    }
    userrolemain_default($table, $userid, $searchrole, $searchroledesc);

    if (!empty($table)) {
        echo html_writer::table($table);
    }
}

function buildroledb_list($searchrole, $searchroledesc) {
    global $DB;

    // Hidden from display //-> Manager, Course creator, Authenticated user
    // -> Authenticated user frontpage, Exam center
    $sql = "Select * From {role} Where id>3 And id<>7 And id<>8";
    if(!empty($searchrole)){
        $sql.=" And name Like '%" . $searchrole . "%'";
    }
    if(!empty($searchroledesc)){
        $sql .= " And description LIKE '%".$searchroledesc."%'";
    }
    $sql .= " Order By name Asc,id Asc";
    $data = $DB->get_records_sql($sql);
    return $data;
}

function buildrole_assignmentsdb_list() {
    global $DB;

    // Hidden from display //-> Manager, Course creator, Authenticated user
    // -> Authenticated user frontpage, Exam center
    $sql = "Select * From {role_assignments} Where id>3 And id<>7 And id<>8 And id<>10 Order By id Asc";
    $data = $DB->get_records_sql($sql);
    return $data;
}

function getrole_assignmentsql($statement) {
    global $DB;
    $sql = "Select
            *
          From
            {$statement} 
          Group by
            b.userid";
    $gb = $DB->get_recordset_sql($sql);

    return $gb;
}

function countrole_assignmentsdb($roleid) {
    global $DB;

    $sql = "Select
            COUNT(DISTINCT b.userid),
            b.roleid,
            b.userid,
            c.firstname,
            c.lastname,
            c.email
          From
            mdl_cifarole a Inner Join
            mdl_cifarole_assignments b On a.id = b.roleid Inner Join
            mdl_cifauser c On b.userid = c.id
          Where
            b.roleid = '" . $roleid . "' 
          ";
    $data = $DB->count_records_sql($sql);
    return $data;
}

// Search Roles
function userrole_search($table) {
    $roletitle = createinputtext('text', 'communicationtitle', 'communicationtitle', '', '', 'width:100%;text-align:left;');
    $roledesc = createinputtext('text', 'supportdesc', 'supportdesc', '', '', 'width:100%;text-align:left;');    

    $table->data[] = array($roletitle, $roledesc, '-','-','-','-');
    return $table;
}

function userrolemain_default($table, $userid, $searchrole, $searchroledesc) {
    global $CFG, $USER;
    $roletitle = buildroledb_list($searchrole, $searchroledesc);
    foreach ($roletitle as $role) {
        $popup = 'popupwindow("' . $CFG->wwwroot . '/organization/assigneduserlist.php?id=' . $role->id . '", "googlePopup", 880, 630);';

        $editimage = $CFG->wwwroot . '/image/edit_ico.png';
        $deleteimage = $CFG->wwwroot . '/image/delete_ico.png';
        $deletepath = $CFG->wwwroot . '/organization/userrole/userrole_delete.php?formtype=' . get_string('userrole') . '&roleid=' . $role->id;
        $editpath = $CFG->wwwroot . '/organization/userrole/userrole_editoption.php?roleid=' . $role->id;
        $assignpath = $CFG->wwwroot . '/organization/userrole/userrole_assign.php?id=' . $role->id . '&name_radio1=5&tab=' . get_string('assigned');

        $assignuser = "<a href='" . $assignpath . "' title='Assign User' target='_blank'>";
        $assignuser .= "<img src='" . $CFG->wwwroot . '/image/assign_users.png' . "' style='width:40px;' /></a>";
        $edit = "<a href='" . $editpath . "' target='_blank'><img src='" . $editimage . "' style='width:30px;' /></a>";
        if ($USER->id == '2') {
            $delete = "<a href='" . $deletepath . "' target='_blank'><img src='" . $deleteimage . "' style='width:25px;' /></a>";
        } else {
            $delete = ' - ';
        }

        $records = countrole_assignmentsdb($role->id);
        $recipientlist = "<u><a style='cursor: pointer' Onclick='" . $popup . "'>(" . $records . ")</a></u>";
        if (($userid == '0')) {
            $table->data[] = array($role->name, $role->description, '(' . $records . ')');
        } else {
            $table->data[] = array($role->name, $role->description, $recipientlist, $edit, $assignuser, $delete);
        }
    }
    return $table;
}

/*
 * Display table, list of users. 
 */

function display_tableofusers_roleassignment($statement) {
    $table = new html_table();
    $table->head = array(get_string('candidateid'), get_string('firstname'), get_string('lastname'), get_string('dob'), get_string('designation'), get_string('organization'), "");
    $table->align = array("center", "left", "left", "center", "left", "left", "center");
    $table->width = "98%";
    $table->attributes = array('style' => 'margin-left:auto;margin-right:auto');

    $records = getrole_assignmentsql($statement);
    foreach ($records as $users) {
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
        $cbox = createinputcheckdelete('checkbox', 'checktoken', "checktoken[]", $users->id); // '<input type="checkbox" name="checktoken[]" id="checktoken[]" value="' . $users->userid . '" />';
        $table->data[] = array(strtoupper($users->traineeid), $users->firstname, $users->lastname, $udob, $designation, $subgroupname, $cbox);
    }
    if (!empty($table)) {
        echo html_writer::table($table);
    }
}

function selectrolename($roleid) {
    global $DB;

    $sql = "    Select
		  a.name,
		  a.id
		From
		  {role} a
		Where
		  a.id='" . $roleid . "'";
    $getrcid = $DB->get_record_sql($sql);
    return $getrcid->name;
}

function remove_assignedusers($userid, $roleid, $tab, $getroleid) {
    global $DB;

    if ($tab == get_string('new')) {
        $userroleid = $roleid;
        $DB->delete_records('role_assignments', array('contextid' => 1, 'roleid' => $getroleid, 'userid' => $userid));
    } else {
        $userroleid = '16'; // Prospect users
        $DB->delete_records('role_assignments', array('contextid' => 1, 'roleid' => $roleid, 'userid' => $userid));
    }

    $insertdata = new stdClass();
    $insertdata->roleid = $userroleid;
    $insertdata->userid = $userid;
    $insertdata->contextid = 1;
    $insertdata->timemodified = time();
    $insertdata->modifierid = 2;
    $data = $DB->insert_record('role_assignments', $insertdata, false);
    return $data;
}
