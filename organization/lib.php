<?php

/* * ***
  create_$corganizationid
 * **** */

function create_erules($data, $editoroptions = NULL) {
    global $CFG, $DB;

    $data->timecreated = time();
    $data->timemodified = $data->timecreated;

    if ($editoroptions) {
        // summary text is updated later, we need context to store the files first
        $data->summary = '';
        $data->summary_format = FORMAT_HTML;
    }

    $corganizationid = $DB->insert_record('organization_config', $data);
    //$context = get_context_instance(CONTEXT_COURSE, $corganizationid, MUST_EXIST);

    if ($editoroptions) {
        // Save the files used in the summary editor and store
        $data = file_postupdate_standard_editor($data, 'summary', $editoroptions, 'organization_config', 'summary', 0);
        $DB->set_field('organization_config', 'summary', $data->summary, array('id' => $corganizationid));
        $DB->set_field('organization_config', 'summaryformat', $data->summary_format, array('id' => $corganizationid));
    }

    $corganization = $DB->get_record('organization_config', array('id' => $corganizationid));

    return $corganization;
}

/**
 * Update a update_erules.
 *
 * Please note this functions does not verify any access control,
 * the calling code is responsible for all validation (usually it is the form definition).
 *
 * @param object $data  - all the data needed for an entry in the 'course' table
 * @param array $editoroptions course description editor options
 * @return void
 */
function update_erules($data, $editoroptions = NULL) {
    global $DB;

    $data->timemodified = time();

    if ($editoroptions) {
        $data = file_postupdate_standard_editor($data, 'summary', $editoroptions, 'organization_config', 'summary', 0);
    }

    // Update with the new data
    $DB->update_record('organization_config', $data);
    $corganization = $DB->get_record('organization_config', array('id' => $data->id));

    return $corganization;
}

function orgstatus($selected) {
    $select = html_writer::start_tag('select', array('name' => 'orgstatus', 'style' => 'width:250px;'));
    $selectclose = html_writer::end_tag('select');
    $status = array();
    $status[0] = get_string('active');
    $status[1] = 'Inactive';
    $a .= $select;
    $a .= '<option value="">' . get_string('chooseone') . '</option>';
    foreach ($status as $key => $orgstatus) {
        $a .= '<option value="' . $key . '"';
        if ($key == $selected) {
            $a .= 'selected="selected"';
        }
        $a .= '>' . $orgstatus . '</option>';
    }
    $a .= $selectclose;
    return $a;
}

function orgstatus_print($selected) {
    $select = html_writer::start_tag('select', array('name' => 'orgstatus', 'style' => 'width:150px;', 'disabled' => 'disabled'));
    $selectclose = html_writer::end_tag('select');
    $status = array();
    $status[0] = get_string('active');
    $status[1] = 'Inactive';
    $a .= $select;
    $a .= '<option value="">' . get_string('chooseone') . '</option>';
    foreach ($status as $key => $orgstatus) {
        $a .= '<option value="' . $key . '"';
        if ($key == $selected) {
            $a .= 'selected="selected"';
        }
        $a .= '>' . $orgstatus . '</option>';
    }
    $a .= $selectclose;
    return $a;
}

function getOrganizationRoles($name, $orgselected) {
    $themeobjects = array();
    $themeobjects[] = get_string('headquarter');
    $themeobjects[] = get_string('branches');

    $select = html_writer::start_tag('select', array('name' => $name, 'style' => 'width:150px;'));
    $selectclose = html_writer::end_tag('select');
    print_r($select);
    echo '<option value="">' . get_string('chooseone') . '</option>';
    foreach ($themeobjects as $key => $theme) {
        echo '<option value="' . $key . '"';
        if ($key == $orgselected) {
            echo 'selected="selected"';
        }
        echo '>' . $theme . '</option>';
    }
    print_r($selectclose);
}

function getOrganizationRoles_print($name, $orgselected) {
    $themeobjects = array();
    $themeobjects[] = get_string('headquarter');
    $themeobjects[] = get_string('branches');

    $select = html_writer::start_tag('select', array('name' => $name, 'style' => 'width:150px;', 'disabled' => 'disabled'));
    $selectclose = html_writer::end_tag('select');
    print_r($select);
    echo '<option value="">' . get_string('chooseone') . '</option>';
    foreach ($themeobjects as $key => $theme) {
        echo '<option value="' . $key . '"';
        if ($key == $orgselected) {
            echo 'selected="selected"';
        }
        echo '>' . $theme . '</option>';
    }
    print_r($selectclose);
}

function organizationdatabase($cid, $orgselected, $name) {
    $themeobjects = listorgtitle_withtitleid($cid);
    $select = html_writer::start_tag('select', array('name' => $name, 'style' => 'width:250px;'));
    $selectclose = html_writer::end_tag('select');
    print_r($select);
    echo '<option value="">' . get_string('chooseone') . '</option>';
    foreach ($themeobjects as $theme) {
        echo '<option value="' . $theme->id . '"';
        if ($theme->id == $orgselected) {
            echo 'selected="selected"';
        }
        echo '>' . $theme->summary . '</option>';
    }
    print_r($selectclose);
}

function organizationdatabase_print($cid, $orgselected, $name) {
    $themeobjects = listorgtitle_withtitleid($cid);
    $select = html_writer::start_tag('select', array('name' => $name, 'style' => 'width:150px;', 'disabled' => 'disabled'));
    $selectclose = html_writer::end_tag('select');
    print_r($select);
    echo '<option value="">' . get_string('chooseone') . '</option>';
    foreach ($themeobjects as $theme) {
        echo '<option value="' . $theme->id . '"';
        if ($theme->id == $orgselected) {
            echo 'selected="selected"';
        }
        echo '>' . $theme->summary . '</option>';
    }
    print_r($selectclose);
}

function getstatusname($statuscname) {
    $getstatus = array();
    $getstatus[1] = get_string('statusopen');
    $getstatus[2] = get_string('statusclose');
    $getstatus[3] = get_string('statuspending');

    foreach ($getstatus as $key => $gstatus) {
        if ($key == $statuscname) {
            return $gstatus;
        }
    }
}

function getfinancialstatus($status) {
    $getstatus = array();
    $getstatus[] = get_string('billed');
    $getstatus[] = get_string('paid');
    $getstatus[] = get_string('cancelled');

    foreach ($getstatus as $key => $gstatus) {
        if ($key == $status) {
            return $gstatus;
        }
    }
}

function selectstatus_financial($statusname) {
    $getstatus = array();
    $getstatus[0] = get_string('billed');
    $getstatus[1] = get_string('paid');
    $getstatus[2] = get_string('cancelled');
    $a = html_writer::start_tag('select', array('name' => $statusname, 'style' => 'width:100px;'));
    $a.='<option value="">' . get_string('chooseone') . '</option>';
    foreach ($getstatus as $key => $gstatus) {
        $a.='<option value="' . $key . '">' . $gstatus . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

// selectcreatedby_financial
function selectcreatedby_financial($name) {
    global $DB;

    $sql = "Select createdby From {statement} Where deleted='0' Group By createdby";
    $getcreatedby = $DB->get_recordset_sql($sql);

    $a = html_writer::start_tag('select', array('name' => $name, 'style' => 'width:100px;'));
    $a.='<option value="">' . get_string('chooseone') . '</option>';
    foreach ($getcreatedby as $gcreatedby) {
        $createdbyname = strtoupper(get_user_details($gcreatedby->createdby)->username);
        $a.='<option value="' . $gcreatedby->createdby . '">' . $createdbyname . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

// Select input
function selectstatus($statusname) {
    $getstatus = array();
    $getstatus[1] = get_string('statusopen');
    $getstatus[2] = get_string('statusclose');
    $getstatus[3] = get_string('statuspending');
    $a = html_writer::start_tag('select', array('name' => $statusname, 'style' => 'width:100px;'));
    $a.='<option value="">' . get_string('chooseone') . '</option>';
    foreach ($getstatus as $key => $gstatus) {
        $a.='<option value="' . $key . '">' . $gstatus . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

// create array for support/activities category
function buildcategory() {
    //$roleid='';
    $getcategory = array();
    $getcategory[1] = get_string('profile');
    $getcategory[2] = get_string('password');
    $getcategory[3] = get_string('financialstatement');
    $getcategory[4] = get_string('seconfirmation');
    $getcategory[5] = get_string('activetrainings');
    $getcategory[6] = get_string('finaltest');
    $getcategory[7] = get_string('testresult');
    $getcategory[8] = get_string('ipdonlinepolicy');
    $getcategory[9] = get_string('onlineportal');
    $getcategory[10] = get_string('cifachat');
    $getcategory[11] = get_string('cifablog');
    $getcategory[12] = get_string('youtube');
    $getcategory[13] = get_string('socialnetwork');
    $getcategory[14] = get_string('feedbackreview');

    return $getcategory;
}

function getcategoryname($categoryvalue) {
    $getcategory = buildcategory();
    foreach ($getcategory as $key => $category) {
        if ($key == $categoryvalue) {
            return $category;
        }
    }
}

// category dropdown list
function selectcategory($categoryname, $categoryvalue) {
    $getcategory = buildcategory();
    $a = html_writer::start_tag('select', array('name' => $categoryname, 'style' => 'width:100%;'));
    $a.='<option value="">' . get_string('chooseone') . '</option>';
    foreach ($getcategory as $key => $category) {
        $a.= '<option value="' . $key . '"';
        if ($key == $categoryvalue) {
            $a.="Selected";
        }
        $a.= '>' . $category . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

// create array buildroleslist
function buildroleslist() {
    global $DB;

    $where = " Where (id='5' Or id='6' Or id='10' Or id='12' Or id='13' Or id='16')";
    $rolesdb = $DB->get_records_sql("Select * From {role} {$where}");

    return $rolesdb;
}

// roles dropdown list
function selectuserrole($selectrolename, $id, $rolesid) {
    $getroles = buildroleslist();
    $a = html_writer::start_tag('select', array('name' => $selectrolename, 'id' => $id, 'style' => 'width:80%;'));
    foreach ($getroles as $roles) {
        $a.='<option value="' . $roles->id . '"';
        if ($roles->id == $rolesid) {
            $a.='selected="selected"';
        }
        $a.='>' . $roles->name . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

// country dropdown list
function selectcountry($countryname, $countrycode) {
    global $DB;

    $sql = "SELECT * FROM {country_list}";
    $country = $DB->get_records_sql($sql);
    $a = html_writer::start_tag('select', array('name' => $countryname));
    $a.='<option value=""';
    if (empty($countrycode)) {
        $a.='selected="selected"';
    }
    $a.='> Choose One </option>';
    foreach ($country as $co) {
        $a.='<option value="' . $co->countrycode . '"';
        if ($co->countrycode == $countrycode) {
            $a.='selected="selected"';
        }
        $a.='>' . $co->countryname . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

function selectcountry_print($countryname, $countrycode) {
    global $DB;

    $sql = "SELECT * FROM {country_list}";
    $country = $DB->get_records_sql($sql);
    $a = html_writer::start_tag('select', array('name' => $countryname, 'disabled' => 'disabled'));
    foreach ($country as $co) {
        $a.='<option value="' . $co->countrycode . '"';
        if ($co->countrycode == $countrycode) {
            $a.='selected="selected"';
        }
        $a.='>' . $co->countryname . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

// creating input type textbox
function createinputtext($inputtype, $inputid, $inputname, $inputvalue, $placeholder = '', $style = '', $additional = '') {
    if (empty($inputvalue)) {
        $value = '';
    } else {
        $value = $inputvalue;
    }
    $build = '<input type="' . $inputtype . '" id="' . $inputid . '" name="' . $inputname . '" value="' . $value . '" placeholder="' . $placeholder . '" style="' . $style . '"  ' . $additional . ' />';
    return $build;
}

// creating input type textbox for print button
function createinputtext_print($inputtype, $inputid, $inputname, $inputvalue, $title = '', $additional = '') {
    if (empty($inputvalue)) {
        $value = '';
    } else {
        $value = $inputvalue;
    }
    $build = '<input type="' . $inputtype . '" id="' . $inputid . '" name="' . $inputname . '" value="' . $value . '" title="' . $title . '" ' . $additional . ' />';
    return $build;
}

// creating input type checkbox// communication preference
function createinputcheck($inputtype, $inputid, $inputname, $inputvalue, $userid) {
    global $DB;
    $sql = "Select * From {communication_users} Where cpid='" . $inputvalue . "' And userid='" . $userid . "' Order By id Asc";
    $udetails = $DB->get_record_sql($sql);

    if (empty($inputvalue)) {
        $value = '';
    } else {
        $value = $inputvalue;
    }
    $build = '<input type="' . $inputtype . '" id="' . $inputid . '" name="' . $inputname . '" value="' . $value . '"';
    if (($inputvalue == '4') && ($inputvalue == '5')) {
        $build .= 'checked="checked"';
    }
    if ($udetails->status == 1) {
        $build .= 'checked="checked"';
    }
    $build .= '/>';
    return $build;
}

// creating input type checkbox // delete // ORGANIZATION
function createinputcheckdelete($inputtype, $inputid, $inputname, $inputvalue) {
    if (empty($inputvalue)) {
        $value = '';
    } else {
        $value = $inputvalue;
    }
    $build = '<input type="' . $inputtype . '" id="' . $inputid . '" name="' . $inputname . '" value="' . $value . '"';
    $build .= '/>';
    return $build;
}

// creating input type textarea
function createtextarea($textname, $textareaid, $maxcols, $maxrows, $textareavalue, $additional) {
    if (empty($textareavalue)) {
        $value = '';
    } else {
        $value = $textareavalue;
    }
    $build = '<textarea name="' . $textname . '" id="' . $textareaid . '" rows="' . $maxrows . '" cols="' . $maxcols . '" ' . $additional . ' />';
    $build.=$value;
    $build.=html_writer::end_tag('textarea');
    return $build;
}

function buildselectionstatus() {
    $getstatus = array();
    $getstatus[] = get_string('statusactive');
    $getstatus[] = get_string('statusinactive');
    $getstatus[] = get_string('statusprospect');
    $getstatus[] = get_string('statusoffline');

    return $getstatus;
}

function buildSelectionTitle() {
    $title = array();
    $title[] = get_string('mr');
    $title[] = get_string('mrs');
    $title[] = get_string('miss');

    return $title;
}

// Gender
function buildSelectionGender() {
    $gender = array();
    $gender[] = get_string('male');
    $gender[] = get_string('female');
    return $gender;
}

function selectgender($gendername) {
    $a = html_writer::start_tag('select', array('name' => $gendername, 'style' => 'width:80px;'));
    $a.='<option value="">' . get_string('chooseone') . '</option>';
    foreach (buildSelectionGender() as $key => $gender) {
        $a.='<option value="' . $key . '">' . $gender . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

//
function buildSelectionEmpStatus() {
    $empstatus = array();
    $empstatus[1] = get_string('working');
    $empstatus[2] = get_string('notworking');

    return $empstatus;
}

//Highest education
function buildhighestedu() {
    $highesteducation = array();
    $highesteducation[1] = get_string('highesteducation1');
    $highesteducation[2] = get_string('highesteducation2');
    $highesteducation[3] = get_string('highesteducation3');
    $highesteducation[4] = get_string('highesteducation4');
    $highesteducation[5] = get_string('highesteducation5');

    return $highesteducation;
}

//Highest education
function buildprofessionalcert() {
    $professionalcert = array();
    $professionalcert[1] = get_string('certificate0');
    $professionalcert[2] = get_string('certificate1');
    $professionalcert[3] = get_string('certificate2');
    $professionalcert[4] = get_string('certificate3');
    $professionalcert[5] = get_string('certificate4');
    $professionalcert[6] = get_string('certificate5');
    $professionalcert[7] = get_string('certificate6');
    $professionalcert[8] = get_string('certificate7');
    $professionalcert[9] = get_string('certificate8');
    $professionalcert[10] = get_string('certificate9');
    $professionalcert[11] = get_string('certificate10');
    $professionalcert[12] = get_string('certificate11');

    return $professionalcert;
}

// Creating Selection input
function createdselectedoption($buildselection, $selectionname, $selectionwidth, $selected) {
    // $buildselectionstatus = buildselectionstatus();
    $a = html_writer::start_tag('select', array('name' => $selectionname, 'style' => $selectionwidth));
    $a .= '<option value="">' . get_string('chooseone') . '</option>';
    foreach ($buildselection as $key => $bselection) {
        $a.='<option value="' . $key . '"';
        if ($key == $selected) {
            $a.='selected="selected"';
        }
        $a.='>' . $bselection . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

function buildTdTable($tdstyle, $value) {
    // $tdstyle = 'border: 1px solid black;';
    $td = html_writer::start_tag('td', array('style' => $tdstyle));
    $td .= $value;
    $td .= html_writer::end_tag('td');

    return $td;
}

function buildTdTableRowspan($tdstyle, $value) {
    // $tdstyle = 'border: 1px solid black;';
    $td = html_writer::start_tag('td', array('style' => $tdstyle, 'rowspan' => '3'));
    $td .= $value;
    $td .= html_writer::end_tag('td');

    return $td;
}

// save button // User
function updateuserrecords($userid, $title, $firstname, $mnamevalue, $lastname, $gender, $dob, $addressline1, $addressline2, $addressline3, $zip, $city, $state, $country, $highesteduvalue, $completiondatevalue, $professvalue, $noqvalue, $collegevalue, $majorvalue, $ycvalue, $studstartdatevalue, $studcomdatevalue, $phone1value, $emailvalue, $empstatusvalue, $designationvalue, $departmentvalue) {
    global $DB;

    $upduser = new stdClass();
    $upduser->id = $userid;
    $upduser->title = $title;
    $upduser->firstname = $firstname;
    $upduser->middle = $mnamevalue;
    $upduser->lastname = $lastname;
    $upduser->gender = $gender;
    $upduser->dob = strtotime($dob);
    $upduser->address = $addressline1;
    $upduser->address2 = $addressline2;
    $upduser->address3 = $addressline3;
    $upduser->postcode = $zip;
    $upduser->city = $city;
    $upduser->state = $state;
    $upduser->country = $country;
    $upduser->highesteducation = $highesteduvalue;
    $upduser->yearcomplete_edu = $completiondatevalue;
    $upduser->professionalcert = $professvalue;
    $upduser->nameofqualification = $noqvalue;
    $upduser->college_edu = $collegevalue;
    $upduser->major_edu = $majorvalue;
    $upduser->yearcomplete = $ycvalue;
    $upduser->startdate_edu = strtotime($studstartdatevalue);
    $upduser->completion_edu = strtotime($studcomdatevalue);
    $upduser->phone1 = $phone1value;
    $upduser->email = $emailvalue;
    $upduser->empstatus = $empstatusvalue;
    $upduser->designation = $designationvalue;
    $upduser->department = $departmentvalue;

    $saverecord = $DB->update_record('user', $upduser);
    return $saverecord;
}

function insertpreference_user($newuserid) {
    global $DB;
    $insertdata = new stdClass();
    $insertdata->userid = $newuserid;
    $insertdata->name = 'auth_forcepasswordchange';
    $insertdata->value = 1;

    $saverecord = $DB->insert_record('user_preferences', $insertdata);
    return $saverecord;
}

function insertnewusers_db($lasttimecreated, $traineeid, $title, $firstname, $mnamevalue, $lastname, $gender, $dob, $addressline1, $addressline2, $addressline3, $zip, $city, $state, $country, $highesteduvalue, $completiondatevalue, $professvalue, $noqvalue, $collegevalue, $majorvalue, $ycvalue, $studstartdatevalue, $studcomdatevalue, $phone1value, $emailvalue, $empstatusvalue, $designationvalue, $departmentvalue) {
    global $DB;

    $upduser = new stdClass();
    $upduser->confirmed = 1;
    $upduser->mnethostid = 1;
    $upduser->usertype = 'Active candidate';
    $upduser->username = strtoupper($traineeid);
    $upduser->password = md5(get_string('temporarypassword'));
    $upduser->traineeid = strtoupper($traineeid);
    $upduser->title = $title;
    $upduser->firstname = $firstname;
    $upduser->middle = $mnamevalue;
    $upduser->lastname = $lastname;
    $upduser->gender = $gender;
    $upduser->dob = strtotime($dob);
    $upduser->address = $addressline1;
    $upduser->address2 = $addressline2;
    $upduser->address3 = $addressline3;
    $upduser->postcode = $zip;
    $upduser->city = $city;
    $upduser->state = $state;
    $upduser->country = $country;
    $upduser->highesteducation = $highesteduvalue;
    $upduser->yearcomplete_edu = $completiondatevalue;
    $upduser->professionalcert = $professvalue;
    $upduser->nameofqualification = $noqvalue;
    $upduser->college_edu = $collegevalue;
    $upduser->major_edu = $majorvalue;
    $upduser->yearcomplete = $ycvalue;
    $upduser->startdate_edu = strtotime($studstartdatevalue);
    $upduser->completion_edu = strtotime($studcomdatevalue);
    $upduser->phone1 = $phone1value;
    $upduser->email = $emailvalue;
    $upduser->empstatus = $empstatusvalue;
    $upduser->designation = $designationvalue;
    $upduser->department = $departmentvalue;
    $upduser->timecreated = time();
    $upduser->lasttimecreated = $lasttimecreated;

    $saverecord = $DB->insert_record('user', $upduser);
    return $saverecord;
}

function searchorg($searchdata1, $searchdata2, $searchdata3, $searchdata4, $searchdata5, $searchdata6, $searchdata7, $searchdata8, $srole) {
    if (!empty($searchdata1)) {
        $sql.=" And organizationid='" . $searchdata1 . "'";
    }
    if (!empty($searchdata2)) {
        $sql.=" And name Like '%" . $searchdata2 . "%'";
    }
    if (!empty($srole)) {
        $sql.=" And org_typename Like '%" . $srole . "%'";
    }
    if (!empty($searchdata3)) {
        $sql.=" And org_type='" . $searchdata3 . "'";
    }
    if (!empty($searchdata4)) {
        $sql.=" And status='" . $searchdata4 . "'";
    }
    if (!empty($searchdata5)) {
        // $sql.=" And timecreated='" . $searchdata5 . "'";
        $sql.=" And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL timecreated SECOND), '%d-%m-%Y') LIKE '%{$searchdata5}%'))";
    }
    if (!empty($searchdata6)) {
        $sql.=" And address='" . $searchdata6 . "'";
    }
    if (!empty($searchdata7)) {
        $sql.=" And city='" . $searchdata7 . "'";
    }
    if (!empty($searchdata8)) {
        $sql.=" And country='" . $searchdata8 . "'";
    }

    return $sql;
}

function getListOfOrganizationdetails() {
    global $DB;
    $sql = "SELECT * FROM {organization_type} Where deletestatus='0'";
    // $sql .= "Order By id ASC LIMIT $perpage OFFSET $fromrecords";
    $data = $DB->get_records_sql($sql);
    return $data;
}

function getListOfOrganization($page = '', $perpage = '', $searchdata1 = '', $searchdata2 = '', $searchdata3 = '', $searchdata4 = '', $searchdata5 = '', $searchdata6 = '', $searchdata7 = '', $searchdata8 = '', $srole = '') {
    global $DB;
    $fromrecords = $page * $perpage;
    $sql = "SELECT * FROM {organization_type} Where deletestatus='0'";
    if (!empty($searchdata1) || !empty($searchdata2) || !empty($searchdata3) || !empty($searchdata4) || !empty($searchdata5) || !empty($searchdata6) || !empty($searchdata7) || !empty($searchdata8) || !empty($srole)) {
        $sql.= searchorg($searchdata1, $searchdata2, $searchdata3, $searchdata4, $searchdata5, $searchdata6, $searchdata7, $searchdata8, $srole);
    } elseif (!empty($searchdata1)) {
        $sql.= searchorg($searchdata1, $searchdata2, $searchdata3, $searchdata4, $searchdata5, $searchdata6, $searchdata7, $searchdata8, $srole);
    }
    $sql .= "Order By id ASC LIMIT $perpage OFFSET $fromrecords";
    $data = $DB->get_records_sql($sql);
    return $data;
}

function checkboxdeleteorg($id) {
    global $DB;

    $sql = "SELECT * FROM {organization_type} Where deletestatus='0' And id='" . $id . "'";
    $data = $DB->get_record_sql($sql);

    $deleteorg = new stdClass();
    $deleteorg->id = $id;
    $deleteorg->organizationid = $data->organizationid . '.' . $data->timecreated;
    $deleteorg->deletestatus = 1;

    $saverecord = $DB->update_record('organization_type', $deleteorg);
    return $saverecord;
}

function checkboxdeleteusers($id) {
    global $DB;

    $userdetails = get_user_details($id);

    $deleteuser = new stdClass();
    $deleteuser->id = $userdetails->id;
    $deleteuser->username = $userdetails->email . '.' . time();
    $deleteuser->deleted = '1';
    $saverecord = $DB->update_record('user', $deleteuser);
    return $saverecord;
}

function updateorgrecords($id, $organizationrole, $gethqorganizationid, $organizationid, $organizationname, $orgrole, $orgrolename, $status, $regdate, $ipaddress, $organizationsize, $organizationtype, $organizationindustry, $addressline1, $addressline2, $addressline3, $orgcity, $orgzip, $orgstate, $country, $website, $workphone, $workfaxs, $email) {
    global $DB;

    $upduser = new stdClass();
    $upduser->id = $id;
    $upduser->organizationrole = $organizationrole;
    $upduser->organizationid = $organizationid;
    $upduser->groupofinstitution = $gethqorganizationid;
    $upduser->name = $organizationname;
    $upduser->org_type = $orgrole;
    $upduser->org_typename = $orgrolename;
    $upduser->status = $status;
    $upduser->timecreated = $regdate;
    $upduser->ipaddress = $ipaddress;
    $upduser->organizationsize = $organizationsize;
    $upduser->organizationtype = $organizationtype;
    $upduser->organizationindustry = $organizationindustry;
    $upduser->address = $addressline1;
    $upduser->address_line2 = $addressline2;
    $upduser->address_line3 = $addressline3;
    $upduser->city = $orgcity;
    $upduser->zip = $orgzip;
    $upduser->state = $orgstate;
    $upduser->country = $country;
    $upduser->url = $website;
    $upduser->telephone = $workphone;
    $upduser->faxs = $workfaxs;
    $upduser->email = $email;

    $saverecord = $DB->update_record('organization_type', $upduser);
    return $saverecord;
}

function insertorgrecords($organizationrole, $gethqorganizationid, $organizationid, $organizationname, $orgrole, $orgrolename, $status, $regdate, $ipaddress, $organizationsize, $organizationtype, $organizationindustry, $addressline1, $addressline2, $addressline3, $orgcity, $orgzip, $orgstate, $country, $website, $workphone, $workfaxs, $email) {
    global $DB;

    $upduser = new stdClass();
    $upduser->organizationid = $organizationid;
    $upduser->organizationrole = $organizationrole;
    $upduser->groupofinstitution = $gethqorganizationid;
    $upduser->name = $organizationname;
    $upduser->org_type = $orgrole;
    $upduser->org_typename = $orgrolename;
    $upduser->status = $status;
    $upduser->timecreated = $regdate;
    $upduser->ipaddress = $ipaddress;
    $upduser->organizationsize = $organizationsize;
    $upduser->organizationtype = $organizationtype;
    $upduser->organizationindustry = $organizationindustry;
    $upduser->address = $addressline1;
    $upduser->address_line2 = $addressline2;
    $upduser->address_line3 = $addressline3;
    $upduser->city = $orgcity;
    $upduser->zip = $orgzip;
    $upduser->state = $orgstate;
    $upduser->country = $country;
    $upduser->url = $website;
    $upduser->telephone = $workphone;
    $upduser->faxs = $workfaxs;
    $upduser->email = $email;
    return $DB->insert_record('organization_type', $upduser, false);
}

function buildsupportcontentdb($userid, $searchcategory, $searchdesc, $searchdate, $searchid, $searchcreatedby, $searchstatus) {
    global $DB;

    $sql = "Select *, From_UnixTime(timecreated, '%d/%m/%Y') As getdate From {support} Where userid='" . $userid . "' And deleted='0'";
    if (!empty($searchcategory)) {
        $sql.=" And category = '" . $searchcategory . "'";
    }
    if (!empty($searchdesc)) {
        $sql.=" And description Like '%" . $searchdesc . "%'";
    }
    if (!empty($searchdate)) {
        $sql.=" And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL timecreated SECOND), '%d-%m-%Y') LIKE '%{$searchdate}%'))";
    }
    if (!empty($searchid)) {
        $sql.=" And supportid LIKE '%" . $searchid . "%'";
    }
    if (!empty($searchcreatedby)) {
        $sql.=" And createdby='" . $searchcreatedby . "'";
    }
    if (!empty($searchstatus)) {
        $sql.=" And status='" . $searchstatus . "'";
    }
    $sql.=" Order By id Desc";
    $data = $DB->get_recordset_sql($sql);

    return $data;
}

function getTotalSupportContent() {
    global $DB;

    $sql = "SELECT COUNT(DISTINCT id) FROM {support}";
    $rs = $DB->count_records_sql($sql);
    return $rs;
}

function inserttodb($supportid, $supportcategory, $supportdesc, $supportstatus, $logginuserid, $userid, $usertype) {
    global $DB;

    $upduser = new stdClass();
    $upduser->supportid = $supportid;
    $upduser->userid = $userid;
    $upduser->usertype = $usertype; //'5'; // need to change it
    $upduser->category = $supportcategory;
    $upduser->description = $supportdesc;
    $upduser->timecreated = time();
    $upduser->status = $supportstatus;
    $upduser->createdby = $logginuserid;
    return $DB->insert_record('support', $upduser, false);
}

function generateSupportId() {
    global $DB;

    /* $total = $DB->count_records('support');
      if ($total < 10) {
      $a = '00';
      } elseif ($total < 100) {
      $a = '0';
      } */

    $record = $DB->get_record_sql("Select * From {support} Order By id Desc");
    $total = $record->id;
    if ($total < 10) {
        $a = '0000';
    } elseif ($total < 100) {
        $a = '000';
    } elseif ($total < 1000) {
        $a = '00';
    } else {
        $a = '0';
    }

    $runningno = $total + 1;
    return $supportid = 'S' . $a . $runningno;
}

function generateTransactionId() {
    global $DB;
    $record = $DB->get_record_sql("Select * From {statement} Order By id Desc");
    $total = $record->id;
    if ($total < 10) {
        $a = '000';
    } elseif ($total < 100) {
        $a = '00';
    } else {
        $a = '0';
    }
    $runningno = $total + 1;
    return $supportid = 'T' . $a . $runningno;
}

function generateActivitiyId() {
    global $DB;
    $record = $DB->get_record_sql("Select * From {log_activity} Order By id Desc");
    $total = $record->id;
    if ($total < 10) {
        $a = '0000';
    } elseif ($total < 100) {
        $a = '000';
    } elseif ($total < 1000) {
        $a = '00';
    } else {
        $a = '0';
    }
    $runningno = $total + 1;
    return $supportid = 'A' . $a . $runningno;
}

function generateAttachmentId() {
    global $DB;
    $record = $DB->get_record_sql("Select * From {support_attachment} Order By id Desc");
    $total = $record->id;
    if ($total < 10) {
        $a = '0000';
    } elseif ($total < 100) {
        $a = '000';
    } elseif ($total < 1000) {
        $a = '00';
    } else {
        $a = '0';
    }
    $runningno = $total + 1;
    return $supportid = 'AT' . $a . $runningno;
}

function generateOrganizationId($countrycode) {
    $total = listOrganization()->id;
    if ($total < 10) {
        $a = '00';
    } elseif ($total < 100) {
        $a = '0';
    }

    $year = date('y', time());
    $number = $year . $a;
    $runningno = $total + 1;
    return $orgid = 'F' . $number . $runningno . $countrycode;
}

function supportcontent_default($userid, $table, $searchcategory, $searchdesc, $searchdate, $searchid, $searchcreatedby, $searchstatus, $formtype) {
    if ($formtype == get_string('user')) {
        $items = buildsupportcontentdb($userid, $searchcategory, $searchdesc, $searchdate, $searchid, $searchcreatedby, $searchstatus);
    } elseif ($formtype == get_string('organization')) {
        $items = buildsupportcontentdb_org($userid, $searchcategory, $searchdesc, $searchdate, $searchid, $searchcreatedby, $searchstatus);
    }
    foreach ($items as $item) {
        $datetime = date('d-m-Y H:i:s', $item->timecreated);
        $supportcategory = getcategoryname($item->category);
        $sstatus = getstatusname($item->status);
        $groupid = strtoupper(get_user_details($item->createdby)->username);
        $author = $groupid . ' (' . get_user_details($item->createdby)->firstname . ' ' . get_user_details($item->createdby)->lastname . ')';

        $checkbox = createinputcheckdelete('checkbox', 'delcoursehistory', "delcoursehistory[]", $item->id);
        $table->data[] = array(
            $datetime, $item->supportid, $supportcategory, $item->description, $sstatus, $author, $checkbox
        );
    }
}

function supportcontent_new($table, $logginuserid) {
    $userdatetime = date('d/m/Y H:i:s', time());
    $statusname = 'supportstatusname';
    $categoryname = 'supportcategoryname';
    $supportstatus = selectstatus($statusname);
    $supportcategory = selectcategory($categoryname, '');
    $supportdesc = createtextarea('supportdesc', 'supportdesc', '100%', '10', '');
    $supportdatetitme = createinputtext('hidden', 'supportdatetitme', 'supportdatetitme', time());    // support date
    $createdby = createinputtext('hidden', 'createdby', 'createdby', $logginuserid);                  // created by 
    $generateSupportId = createinputtext('hidden', 'generateActivitiyId', 'generateActivitiyId', generateSupportId());

    // if click new button
    $table->data[] = array(
        $userdatetime . $supportdatetitme, $generateSupportId . generateSupportId(), $supportcategory, $supportdesc, $supportstatus, createdbyuser($logginuserid) . $createdby, ''
    );
}

function supportcontent_save($userid, $logginuserid, $category, $description, $generateSupportId, $formtype, $sp) {
    global $CFG;
    // save data to database
    if ($formtype == get_string('user')) {
        $display = 'userdetails';
        $usertype = '5';
    } else if ($formtype == get_string('organization')) {
        $display = 'organizationdetails';
        $usertype = '6';
    }
    inserttodb($generateSupportId, $category, $description, $sp, $logginuserid, $userid, $usertype);
    $redirecturl = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $userid . '&display=' . $display . '&supportform=' . get_string('support') . '&new=1';
    die("<script>location.href = '" . $redirecturl . "'</script>");
}

function checkboxdel_supportcontent($supportcontent_id) {
    global $DB;

    $deleteattachment = new stdClass();
    $deleteattachment->id = $supportcontent_id;
    $deleteattachment->deleted = 1;

    $saverecord = $DB->update_record('support', $deleteattachment);
    return $saverecord;
}

function supportcontent_delete($del_supportcontent, $userid, $formtype) {
    global $CFG;
    if (!empty($del_supportcontent)) {
        for ($i = 0; $i < sizeof($del_supportcontent); $i++) {
            // delete only // HIDE
            checkboxdel_supportcontent($del_supportcontent[$i]); // id 
        }
    }

    if ($formtype == get_string('user')) {
        $display = 'userdetails';
        $usertype = '5';
    } else if ($formtype == get_string('organization')) {
        $display = 'organizationdetails';
        $usertype = '6';
    }

    echo $deleteurl = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $userid . '&display=' . $display . '&supportform=' . get_string('support') . '&delete=1';
    die("<script>location.href = '" . $deleteurl . "'</script>");
}

function supportcontent_search($table) {
    $statusname = 'supportstatusname';
    $categoryname = 'supportcategoryname';
    $supportstatus = selectstatus($statusname);
    $supportcategory = selectcategory($categoryname, '');
    $supportdesc = createtextarea('supportdesc', 'supportdesc', '100%', '10', '', 'placeholder=" max 500 character" style="width:450px;"');
    $supportid = createinputtext('text', 'searchtransactionid', 'searchtransactionid', '', '', 'width:100px;text-align:center;');
    $supportdatetitme = createinputtext('text', 'searchdatetimefinance', 'searchdatetimefinance', '', 'dd-mm-yy', 'width:80px;text-align:center;');
    $createdby = selectcreatedby_activities('searchcreatedby');                  // created by     

    $table->data[] = array(
        $supportdatetitme, $supportid, $supportcategory, $supportdesc, $supportstatus, $createdby, ''
    );
}

function supportcontent_switchcase($table, $userid, $whichsupportbutton, $logginuserid, $sp, $cp, $descparam, $searchdate, $searchtsid, $searchcreatedby, $generateSupportId, $formtype, $del_support) {
    switch ($whichsupportbutton) {
        case get_string('search'):
            supportcontent_search($table);
            supportcontent_default($userid, $table, $cp, $descparam, $searchdate, $searchtsid, $searchcreatedby, $sp, $formtype);
            break;
        case get_string('new'):
            supportcontent_new($table, $logginuserid);
            break;
        case get_string('savebutton'):
            supportcontent_save($userid, $logginuserid, $cp, $descparam, $generateSupportId, $formtype, $sp);
            break;
        case get_string('delete'):
            if (!empty($del_support)) {
                supportcontent_delete($del_support, $userid, $formtype);
            } else {
                supportcontent_default($userid, $table, $logginuserid);
            }
            break;
        default:
            //if($formtype == get_string('user')){
            supportcontent_default($userid, $table, $cp, $descparam, $searchdate, $searchtsid, $searchcreatedby, $sp, $formtype);
        //}elseif($formtype == get_string('organization')){
        //echo 'zzz';
        //supportorgcontent_default($userid, $table);
        //}
    }
}

// Support content MAIN here
function supportcontent($uid, $logginuserid, $whichsupportbutton, $sp, $cp, $descparam, $searchdate, $searchtsid, $searchcreatedby, $generateSupportId, $formtype, $del_support) {
    $table = new html_table();
    $table->width = "100%";
    $table->head = array(get_string('date'), get_string('supportid'), get_string('supportcategory'), get_string('description'), get_string('status'), get_string('createdby'), '');
    $table->align = array("center", "center", "left", "left", "center", "left", "center");

    supportcontent_switchcase($table, $uid, $whichsupportbutton, $logginuserid, $sp, $cp, $descparam, $searchdate, $searchtsid, $searchcreatedby, $generateSupportId, $formtype, $del_support);

    if (!empty($table)) {
        echo html_writer::table($table);
    }
}

// Financial part
function buildfinancialhistory_contentdb($userid, $debit, $credit, $status, $description, $searchdatetimefinance, $searchtransactionid, $searchcreatedby) {
    global $DB;
    $userdetails = get_user_details($userid);
    $candidateid = strtoupper($userdetails->traineeid);
    $sql = "Select * From {statement} Where candidateid='" . $candidateid . "' And deleted='0'";
    if (!empty($searchdatetimefinance)) {
        $sql.=" AND ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL subscribedate SECOND), '%d-%m-%Y') LIKE '%{$searchdatetimefinance}%'))";
    }
    if (!empty($searchtransactionid)) {
        $sql.=" AND transactionid = '" . $searchtransactionid . "'";
    }
    if (!empty($description)) {
        $sql.=" AND description LIKE '%{$description}%'";
    }
    if (!empty($debit)) {
        $sql.=" AND debit1 = '" . $debit . "'";
    }
    if (!empty($credit)) {
        $sql.=" AND credit1 = '" . $credit . "'";
    }
    if (!empty($status)) {
        $sql.=" AND status='" . $status . "'";
    }

    if (!empty($searchcreatedby)) {
        $sql.=" AND createdby = '" . $searchcreatedby . "'";
    }
    $sql.=" Order By id Desc";
    $data = $DB->get_recordset_sql($sql);
    return $data;
}

// New Financial part
function financialhistory_new($table, $logginuserid) {
    $userdetails = get_user_details($logginuserid);
    $groupid = strtoupper($userdetails->username);
    $author = $groupid . ' (' . $userdetails->firstname . ' ' . $userdetails->lastname . ')';

    $userdatetime = date('d-m-Y H:i:s', time());
    $statusname = 'financialstatusname';
    $financialstatus = selectstatus_financial($statusname);
    $financialdesc = createtextarea('financialdesc', 'financialdesc', '100%', '10', '', 'style="width:300px;"');
    $debit = createinputtext('text', 'debit', 'debit', '', 0, 'width:80px;');
    $credit = createinputtext('text', 'credit', 'credit', '', 0, 'width:80px;');
    $financialdatetitme = createinputtext('hidden', 'financialdatetitme', 'financialdatetitme', time());      // support date
    $createdby = createinputtext('hidden', 'createdby', 'createdby', $logginuserid);                        // created by 

    $table->data[] = array(
        $userdatetime . $financialdatetitme, generateTransactionId(), $financialdesc, $debit, $credit, $financialstatus, $author . $createdby, ''
    );
}

//default page // Financial part
function financialhistory_default($userid, $table, $f2, $f3, $f5, $f6, $f7, $f8, $f9) {
    // echo financialhistory_new($table, $logginuserid);
    foreach (buildfinancialhistory_contentdb($userid, $f2, $f3, $f9, $f5, $f6, $f7, $f8) as $item) {
        if ($item->debit1 == 0) {
            $datetime = date('d-m-Y H:i:s', $item->paymentdate);
        } else {
            $datetime = date('d-m-Y H:i:s', $item->subscribedate);
        }
        $sstatus = getfinancialstatus($item->status);
        $groupid = strtoupper(get_user_details($item->createdby)->username);
        $author = $groupid . ' (' . get_user_details($item->createdby)->firstname . ' ' . get_user_details($item->createdby)->lastname . ')';

        $checkbox = createinputcheckdelete('checkbox', 'delfinancial', "delfinancial[]", $item->id);
        $table->data[] = array(
            $datetime, $item->transactionid, $item->description, $item->debit1, $item->credit1, $sstatus, $author, $checkbox
        );
    }
}

// Insert to table mdl_cifastatement
function inserttostatementdb($transactionid, $candidateid, $debit, $credit, $financialstatus, $desc, $logginuserid) {
    global $DB;
    if ($debit == 0) {
        $subscribedate = 0;
        $financialremark = 'Payment';
    } else {
        $subscribedate = time();
        $financialremark = 'Subscribe';
    }
    if ($credit == 0) {
        $paymentdate = 0;
    } else {
        $paymentdate = time();
    }

    $insertdata = new stdClass();
    $insertdata->transactionid = $transactionid;
    $insertdata->candidateid = $candidateid;
    $insertdata->subscribedate = $subscribedate;
    $insertdata->courseid = '32'; // need to change it
    $insertdata->remark = $financialremark;
    $insertdata->debit1 = $debit;
    $insertdata->credit1 = $credit;
    $insertdata->paymentdate = $paymentdate;
    $insertdata->status = $financialstatus;
    $insertdata->description = $desc;
    $insertdata->createdby = $logginuserid;
    return $DB->insert_record('statement', $insertdata, false);
}

function financialhistory_save($userid, $supportform, $debit, $credit, $financialstatus, $desc, $logginuserid) {
    global $DB, $CFG;
    $userdetails = get_user_details($userid);
    $candidateid = strtoupper($userdetails->traineeid);

    // set for sent out email
    if ($financialstatus == get_string('billed') || $financialstatus == get_string('paid')) {
        $recipientusers = $DB->get_recordset_sql("SELECT * FROM {user} WHERE id='" . $userdetails->id . "'");
        foreach ($recipientusers as $rusers) {
            // email user
            lms_welcome_email($rusers);
        }
        $recipientusers->close();
    }
    // insert to db
    inserttostatementdb(generateTransactionId(), $candidateid, $debit, $credit, $financialstatus, $desc, $logginuserid);
    $url = $CFG->wwwroot . '/organization/orgview.php?formtype=User&id=' . $userid . '&display=userdetails&supportform=' . $supportform;
    die("<script>location.href = '" . $url . "'</script>");
}

function checkboxdelfinancial($id) {
    global $DB;

    $sql = "SELECT * FROM {statement} Where deleted='0' And id='" . $id . "'";
    $data = $DB->get_record_sql($sql);

    $deleterec = new stdClass();
    $deleterec->id = $id;
    $deleterec->transactionid = $data->transactionid . '.' . $data->candidateid;
    $deleterec->deleted = 1;

    $saverecord = $DB->update_record('statement', $deleterec);
    return $saverecord;
}

function financialhistory_delete($delfinancial, $userid, $supportform) {
    global $CFG;
    for ($i = 0; $i < sizeof($delfinancial); $i++) {
        // delete only
        checkboxdelfinancial($delfinancial[$i]); // id 
    }
    $deleteurl = $CFG->wwwroot . '/organization/orgview.php?formtype=User&id=' . $userid . '&display=userdetails&supportform=' . $supportform;
    die("<script>location.href = '" . $deleteurl . "'</script>");
}

// search column
function financialhistory_search($table) {
    $statusname = 'searchstatus';
    $selectname = 'searchcreatedby';
    $userdatetime = createinputtext('text', 'searchdatetimefinance', 'searchdatetimefinance', '', 'dd-mm-yy', 'width:100px;');          // date
    $transactionid_select = createinputtext('text', 'searchtransactionid', 'searchtransactionid', '', '', 'width:80px;');    // Need to change, selection

    $financialstatus = selectstatus_financial($statusname);
    $financialdesc = createtextarea('financialdesc', 'financialdesc', '100%', '5', '', 'style="width:300px;"');
    $debit = createinputtext('text', 'debit', 'debit', '', 0, 'width:80px;');
    $credit = createinputtext('text', 'credit', 'credit', '', 0, 'width:80px;');
    $createdby = selectcreatedby_financial($selectname);      // created by

    $table->data[] = array(
        $userdatetime, $transactionid_select, $financialdesc, $debit, $credit, $financialstatus, $createdby, ''
    );
}

function financialhistory_print($userid) {
    global $DB;
    $userdetails = get_user_details($userid);
    $candidateid = strtoupper($userdetails->traineeid);
    $sql = "Select * From {statement} Where candidateid='" . $candidateid . "' And deleted='0'";
    $sql.=" Order By id Desc";
    $data = $DB->get_recordset_sql($sql);
    return $data;
}

function outstandingbalance_finance($id) {
    // kira balance
    $listoutstatement = financialhistory_print($id);
    foreach ($listoutstatement as $outbalance) {
        $outbalancedebit += $outbalance->debit1;
        $outbalancecredit += $outbalance->credit1;
    }
    $totalbalance = $outbalancedebit - $outbalancecredit;
    return $totalbalance;
}

// total record financial history by user
function totalrecordsfinancialhistory($userid) {
    global $DB;
    $userdetails = get_user_details($userid);
    $candidateid = strtoupper($userdetails->traineeid);
    return $DB->count_records("statement", array('deleted' => '0', 'candidateid' => $candidateid));
}

// // 1 - 10 of X record
function simplepagingfinancialhistory($userid, $page, $perpage) {
    $total = totalrecordsfinancialhistory($userid);
    if ($total > 0) {
        if ($total >= $perpage) {
            $r = ($perpage * ($page + 1));
        } else {
            $r = $total;
        }

        $record.=(($perpage * $page) + 1) . ' - ' . $r . ' of ' . ($total - ($perpage * $page)) . ' record';
    }
    return $record;
}

function simplepagingfor($userid, $page, $perpage, $supportform, $formtype) {
    global $DB;
    if ($formtype == get_string('user')) {
        if ($supportform == get_string('support')) {
            $total = $DB->count_records("support", array('deleted' => '0', 'userid' => $userid));
        } else if ($supportform == get_string('activities')) {
            $total = $DB->count_records("log_activity", array('deleted' => '0', 'recipientid' => $userid));
        } else if ($supportform == get_string('attachment')) {
            $total = $DB->count_records("support_attachment", array('status' => '0', 'userid' => $userid));
        }
    } else if ($formtype == get_string('organization')) { //And usertype!='5'  
        if ($supportform == get_string('support')) {
            $sql="Select COUNT(DISTINCT id) FROM {support} WHERE userid='".$userid."' And deleted='0' And usertype!='5'";
            $total = $DB->count_records_sql($sql);
            // $total = $DB->count_records("support", array('deleted' => '0', 'userid' => $userid, 'usertype'=>'5'));
        } else if ($supportform == get_string('activities')) {
            $sql="Select COUNT(DISTINCT id) FROM {log_activity} WHERE recipientid='".$userid."' And deleted='0' And usertype!='5'";
            $total = $DB->count_records_sql($sql);            
        } else if ($supportform == get_string('attachment')) {
            $sql="Select COUNT(DISTINCT id) FROM {support_attachment} WHERE userid='".$userid."' And status='0' And usertype!='5'";
            $total = $DB->count_records_sql($sql);           
        }
    }

    if ($total > 0) {
        if ($total >= $perpage) {
            $r = ($perpage * ($page + 1));
        } else {
            $r = $total;
        }

        $record.=(($perpage * $page) + 1) . ' - ' . $r . ' of ' . ($total - ($perpage * $page)) . ' record';
    }
    return $record;
}

// display table financial history
function supportfinancial_history($userid, $whichsupportbutton, $logginuserid, $supportform, $f2, $f3, $f4, $f5, $delfinancialid, $f6, $f7, $f8, $f9) {
    $table = new html_table();
    $table->width = "100%";
    $table->head = array(get_string('date'), get_string('transactionid'), get_string('description'), get_string('debit'), get_string('credit'), get_string('status'), get_string('createdby'), '');
    $table->align = array("center", "center", "left", "center", "center", "center", "left", "center");

    switch ($whichsupportbutton) {
        case get_string('search'):
            financialhistory_search($table);
            financialhistory_default($userid, $table, $f2, $f3, $f5, $f6, $f7, $f8, $f9);
            break;
        case get_string('new'):
            financialhistory_new($table, $logginuserid);
            break;
        case get_string('savebutton'):
            echo $userid;
            financialhistory_save($userid, $supportform, $f2, $f3, $f4, $f5, $logginuserid);
            break;
        case get_string('delete'):
            financialhistory_delete($delfinancialid, $userid, $supportform);
            break;
        default:
            financialhistory_default($userid, $table, $f2, $f3, $f5, $f6, $f7, $f8, $f9);
    }
    if (!empty($table)) {
        echo html_writer::table($table);
    }
}

// COURSE HISTORY // COURSE TITLE

function coursetitle_list($userid, $searchcoursetitle, $sstartdate, $searchenddate, $enrolmentdate, $createduser, $searchbymark) {
    global $DB;
    $sql = "Select
            a.fullname,
            b.courseid,c.enrolid,
            c.userid, c.timestart, c.timeend, c.status as enrollmentstatus,
            FROM_UNIXTIME(c.timestart,'%d/%m/%Y') as subscription_startdate,
            FROM_UNIXTIME(c.timeend,'%d/%m/%Y') as subscription_enddate,
            FROM_UNIXTIME(c.timecreated,'%d/%m/%Y') as enrolmentdate
          From
            mdl_cifacourse a Inner Join
            mdl_cifaenrol b On a.id = b.courseid Inner Join
            mdl_cifauser_enrolments c On b.id = c.enrolid
          Where
            c.userid = '" . $userid . "' And
            a.category = '1'";
    if (!empty($searchcoursetitle)) {
        $sql .= " And b.courseid='" . $searchcoursetitle . "'";
    }
    if (!empty($sstartdate)) {
        $sql.=" And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL c.timestart SECOND), '%d/%m/%Y') LIKE '%{$sstartdate}%'))";
    }
    if (!empty($searchenddate)) {
        $sql.=" And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL c.timeend SECOND), '%d/%m/%Y') LIKE '%{$searchenddate}%'))";
    }
    if (!empty($enrolmentdate)) {
        $sql.=" And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL c.timecreated SECOND), '%d-%m-%Y') LIKE '%{$enrolmentdate}%'))";
    }
    if (!empty($searchbymark)) {
        $sql.=" And a.fullname LIKE '%$searchbymark%'";
    }
    if (!empty($createduser)) {
        $sql.=" And c.modifierid = '" . $createduser . "'";
    }
    return $DB->get_records_sql($sql);
}

function getlist_coursehistory($userid, $coursename, $examid) {
    global $DB;

    $sql = "Select 
                b.userid,
                c.grade,
                b.quiz As attemptquizid,
                a.name, a.id, a.course,
                c.timemodified, 
                FROM_UNIXTIME(c.timemodified,'%d/%m/%Y') as enrolmentdate
              From
                mdl_cifaquiz a Inner Join
                mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
                mdl_cifaquiz_grades c On b.userid = c.userid And b.quiz = c.quiz
              Where
                a.course='" . $examid . "' And a.name LIKE '%" . $coursename . "' And b.userid = '" . $userid . "'";
    $data2 = $DB->get_record_sql($sql);
    return $data2;
}

function selectstatus_test($statusname) {
    $getstatus = array();
    $getstatus[1] = get_string('passed');
    $getstatus[2] = get_string('failed');
    $getstatus[3] = get_string('expired');
    $getstatus[4] = get_string('none');

    $a = html_writer::start_tag('select', array('name' => $statusname, 'style' => 'width:100px;'));
    $a.='<option value="">' . get_string('chooseone') . '</option>';
    foreach ($getstatus as $key => $gstatus) {
        $a.='<option value="' . $key . '">' . $gstatus . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

function selectcourse_title($statusname, $userid) {
    $getstatus = coursetitle_list($userid);
    $a = html_writer::start_tag('select', array('name' => $statusname, 'style' => 'width:300px;'));
    $a.='<option value="">' . get_string('chooseone') . '</option>';
    foreach ($getstatus as $gstatus) {
        $a.='<option value="' . $gstatus->courseid . '">' . $gstatus->fullname . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

function coursetitle_listallcourse() {
    global $DB;
    $sql = "Select
        a.fullname,
        b.id As enrolid
      From
        {course} a Inner Join
        {enrol} b On a.id = b.courseid
      Where
        a.category = 1 And
        b.enrol = 'manual'";
    return $DB->get_records_sql($sql);
}

function selectcoursetitle_new($enrolnewcourse) {
    $getstatus = coursetitle_listallcourse();
    $a = html_writer::start_tag('select', array('name' => $enrolnewcourse, 'style' => 'width:300px;'));
    $a.='<option value="">' . get_string('chooseone') . '</option>';
    foreach ($getstatus as $gstatus) {
        $a.='<option value="' . $gstatus->enrolid . '">' . $gstatus->fullname . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

function supportcourse_new($userid, $table, $logginuserid, $extenddays) {
    $userdetails = get_user_details($logginuserid);
    $groupid = strtoupper($userdetails->username);
    $author = $groupid . ' (' . $userdetails->firstname . ' ' . $userdetails->lastname . ')';
    $timestart = date('d-m-Y', strtotime('today midnight'));
    $timeend = date('d-m-Y', strtotime('today midnight' . '+ ' . $extenddays . ' - 1 minutes'));
    $userdatetime = date('d/m/Y H:i:s', time());

    $statusname = 'teststatusname';
    $teststatus = selectstatus_test($statusname);
    $coursetitle = selectcoursetitle_new('enrolnewcourse');
    $sstartdate = createinputtext('text', 'datetimesearchfinance', 'datetimesearchfinance', $timestart, 0, 'width:100px;text-align:center;'); // subscriptionstartdate
    $senddate = createinputtext('text', 'subscriptionenddate', 'subscriptionenddate', $timeend, 0, 'width:100px;text-align:center;');
    $enrollmentdatetitme = createinputtext('hidden', 'enrollmentdatetitme', 'enrollmentdatetitme', time());      // support date
    $createdby = createinputtext('hidden', 'createdby', 'createdby', $logginuserid);                        // created by 

    $table->data[] = array(
        $userdatetime . $enrollmentdatetitme, $coursetitle, $sstartdate, $senddate, $teststatus, '-', $author . $createdby, ''
    );
}

function examdetails($usergrade, $gradelulus, $todaytime, $expirydate) {
    if ($usergrade == 0) {
        if ($todaytime <= $expirydate) {
            // valid
            $status = get_string('none');
        } else {
            // NOT valid
            $status = get_string('expired');
        }
    } elseif ($usergrade < $gradelulus && $usergrade >= 1) {
        if ($todaytime <= $expirydate) {
            // valid
            $status = get_string('failed');
        } elseif ($usergrade < $gradelulus) {
            $status = get_string('failed');
        } else {
            // NOT valid
            $status = get_string('expired');
        }
    } else {
        $status = get_string('passed');
    }
    return $status;
}

// display createdby
function createdbyuser($logginuserid) {
    $userdetails = get_user_details($logginuserid);
    $groupid = strtoupper($userdetails->username);
    $author = $groupid . ' (' . $userdetails->firstname . ' ' . $userdetails->lastname . ')';

    return $author;
}

// search course history column
function coursehistory_search($userid, $table) {
    $selectname = 'searchcreatedby';
    $statusname = 'teststatusname';
    $teststatus = selectstatus_test($statusname);
    $coursetitle = selectcourse_title('coursetitle', $userid);
    $sstartdate = createinputtext('text', 'datetimesearchfinance', 'datetimesearchfinance', '', 'dd-mm-yy', 'width:100px;text-align:center;'); // subscriptionstartdate
    $senddate = createinputtext('text', 'subscriptionenddate', 'subscriptionenddate', '', 'dd-mm-yy', 'width:100px;text-align:center;');
    $enrollmentdatetitme = createinputtext('text', 'searchdatetimefinance', 'searchdatetimefinance', '', 'dd-mm-yy', 'width:100px;text-align:center;');          // date      // support date
    $testmark = createinputtext('text', 'testmark', 'testmark', '', 0, 'width:100px;text-align:center;');
    $createdby = selectcreatedby_financial($selectname);      // created by 

    $table->data[] = array(
        $enrollmentdatetitme, $coursetitle, $sstartdate, $senddate, $teststatus, $testmark, $createdby, ''
    );
}

// default view when we click on course history
function supportcourse_default($userid, $table, $logginuserid, $gradelulus, $searchtstatus, $searchcoursetitle, $searchbymark, $sstartdate, $searchenddate, $enrolmentdate, $createduser) {
    global $CFG;
    $todaytime = time();
    $getstatus = coursetitle_list($userid, $searchcoursetitle, $sstartdate, $searchenddate, $enrolmentdate, $createduser, $searchbymark, $searchtstatus);
    $createdby = createdbyuser($logginuserid);
    foreach ($getstatus as $gdata) {
        $data = getlist_coursehistory($userid, $gdata->fullname, 64); // 64 is courseid for test
        if (!empty($data->grade)) {
            $resultsummaryview = $CFG->wwwroot . '/mod/quiz/resultsummary_adminview.php?uid=' . $userid . '&cenrolid=' . $gdata->enrolid;
            $grade = '<a href="' . $resultsummaryview . '" target="_blank" title="Click to open Result Summary"><u>' . round($data->grade) . '</u></a>';
        } else {
            $grade = ' - ';
        }
        $expirydate = $gdata->timeend;
		//mmn add 10022016
				$qryge = "SELECT a.orgtype FROM mdl_cifauser a, mdl_cifaorganization_type b
					 where a.id='".$userid."' AND a.orgtype=b.id AND b.name LIKE '%ADIB%'";
				$sqlge = mysql_query($qryge);
				$rsge = mysql_fetch_array($sqlge);
				$rowge = mysql_num_rows($sqlge);
				
				$qryed = "SELECT * FROM mdl_cifaquiz_grades WHERE quiz='26' AND userid='".$userid."' AND timemodified>'1455494400'";
				$sqled = mysql_query($qryed);
				$rsed = mysql_fetch_array($sqled);
				$rowed = mysql_num_rows($sqled);
				//if(strpos($rsge['email'],'adib')!== false){
				if($rowed>0){
					if($rowge>0){
						$gradelulus = 75;
					}else{
						$gradelulus = 60;
					}
				}else{
					$gradelulus = 60;
				}

		//mmn end		
        $resultstatus = examdetails($data->grade, $gradelulus, $todaytime, $expirydate); // Test Status

        $titlename_link = $CFG->wwwroot . '/enrol/users.php?id=' . $gdata->courseid . '&page=0&perpage=400&sort=lastname&dir=ASC&ifilter=' . $gdata->enrolid;
        $coursetitle = '<a href="' . $titlename_link . '" target="_blank" title="Click to edit enrollment status"><u>' . $gdata->fullname . '</u></a>';

        $checkbox = createinputcheckdelete('checkbox', 'delcoursehistory', "delcoursehistory[]", $gdata->enrolid); // change status to 1
        $table->data[] = array(
            $gdata->enrolmentdate, $coursetitle, $gdata->subscription_startdate, $gdata->subscription_enddate, $resultstatus, $grade, $createdby, $checkbox
        );
    }
}

function checkboxdelcourse($courseenrolid, $userid) {
    global $DB;

    $sql = "SELECT * FROM {user_enrolments} Where status='0' And userid='" . $userid . "' And enrolid='" . $courseenrolid . "'";
    $data = $DB->get_record_sql($sql);

    $deletecourse = new stdClass();
    $deletecourse->id = $data->id;
    $deletecourse->status = 1;

    $saverecord = $DB->update_record('user_enrolments', $deletecourse);
    return $saverecord;
}

function supportcourse_delete($delcoursehistory, $userid) {
    global $CFG;
    if (!empty($delcoursehistory)) {
        for ($i = 0; $i < sizeof($delcoursehistory); $i++) {
            // delete only // HIDE
            checkboxdelcourse($delcoursehistory[$i], $userid); // id 
        }
    }
    $deleteurl = $CFG->wwwroot . '/organization/orgview.php?formtype=User&id=' . $userid . '&display=userdetails&supportform=' . get_string('coursehistory');
    die("<script>location.href = '" . $deleteurl . "'</script>");
}

// Update user lasttimecred field
function updateuser_lasttimecreated($userid, $timeend) {
    global $DB;
    $up_lasttimecreated = new stdClass();
    $up_lasttimecreated->id = $userid;
    $up_lasttimecreated->lasttimecreated = $timeend;
    $user_lasttimecreated = $DB->update_record('user', $up_lasttimecreated);
    return $user_lasttimecreated;
}

function checkboxextendcourse($courseenrolid, $userid, $extenddays) {
    global $DB;
    $sql = "SELECT * FROM {user_enrolments} Where userid='" . $userid . "' And enrolid='" . $courseenrolid . "'";
    $data = $DB->get_record_sql($sql);
    $timestart = strtotime('today midnight');
    $timeend = strtotime('today midnight' . '+ ' . $extenddays . ' - 1 minutes');
    $ipdchatenrollmentid = finaltest_sql($userid, 44)->enrolmentid;
    //57 is cifa feedback $ipdfbenrollmentid = finaltest_sql($userid, 57)->enrolmentid;
$ipdfbenrollmentid = finaltest_sql($userid, 32)->enrolmentid;
    $finaltestenrolid = finaltest_sql($userid, 64)->enrolmentid;
    $mocktestenrolid = finaltest_sql($userid, 62)->enrolmentid;
    //$updateipdchatexpirydate = buildupdatedexpirydate($ipdchatenrollmentid, $timeend); mmn off this on 12/04/2016 due to candidate did not enrol to ipdchat and admin unable to extend candidate       // IPD Chat
    $updatefbexpirydate = buildupdatedexpirydate($ipdfbenrollmentid, $timeend);     // IPD Feedback  
    $updatefinaltest = buildupdatedexpirydate($finaltestenrolid, $timeend); 
    $updatemocktest = buildupdatedexpirydate($mocktestenrolid, $timeend); 

    $extendcourse = new stdClass();
    $extendcourse->id = $data->id;
    $extendcourse->timestart = $timestart;
    $extendcourse->timeend = $timeend;
    $extendcourse->status = 0;
    $updatecourseexpirydate = $DB->update_record('user_enrolments', $extendcourse);echo "9";

    $user_lasttimecreated = updateuser_lasttimecreated($userid, $timeend);echo "10";

    $records = array($updatecourseexpirydate, $updateipdchatexpirydate, $updatefbexpirydate, $updatefinaltest, $updatemocktest, $user_lasttimecreated);
    return $records;
}

// Extended the course
function supportcourse_extend($extendcoursehistory, $userid, $extenddays) {
    global $CFG;
    if (!empty($extendcoursehistory)) {
        for ($i = 0; $i < sizeof($extendcoursehistory); $i++) { 
            // Extended the course
            checkboxextendcourse($extendcoursehistory[$i], $userid, $extenddays); // id 
        }
    }
    $redirecturl = $CFG->wwwroot . '/organization/orgview.php?formtype=User&id=' . $userid . '&display=userdetails&supportform=' . get_string('coursehistory') . '&extend=1';
    die("<script>location.href = '" . $redirecturl . "'</script>");
}

// Reset Test attempts to open
function limited_access_test($userid, $grade, $quizid) {
    global $DB;
    $sql = "Select 
            b.userid,
            c.grade,b.quiz as attemptquizid,
            a.name, a.id
          From
            {quiz} a Inner Join
            {quiz_attempts} b On a.id = b.quiz Inner Join
            {quiz_grades} c On b.userid = c.userid And b.quiz = c.quiz
          Where
            a.id = '" . $quizid . "' And b.userid = '" . $userid . "' And c.grade < '" . $grade . "'";
    $data = $DB->get_record_sql($sql);

    // delete record jika attempts has been limit(2)
    if (!empty($data->attemptquizid)) {
        $del1 = $DB->delete_records('quiz_attempts', array('userid' => $data->userid, 'quiz' => $data->attemptquizid));
        $del2 = $DB->delete_records('quiz_grades', array('userid' => $data->userid, 'quiz' => $data->attemptquizid));
        $resetall = $del1 . $del2;
    }
    return $resetall;
}

function countattempttest($userid, $grade, $quizid) {
    global $DB;
    $sql = "Select  COUNT(DISTINCT a.id),
            b.userid,
            c.grade,b.quiz as attemptquizid,
            a.name, a.id
      From
        {quiz} a Inner Join
        {quiz_attempts} b On a.id = b.quiz Inner Join
        {quiz_grades} c On b.userid = c.userid And b.quiz = c.quiz
      Where
        a.id = '" . $quizid . "' And b.userid = '" . $userid . "' And c.grade < '" . $grade . "'";
    $crecords = $DB->count_records_sql($sql);

    return $crecords;
}

function updatetestenrolstatus($userid, $testid) {
    global $DB;
    $enrolmentid = finaltest_sql($userid, $testid)->enrolmentid; // TEST enrolment id
    $record2 = new stdClass();
    $record2->id = $enrolmentid;
    $record2->status = 0;
    $record2->timemodified = time();
    $updatestatus = $DB->update_record('user_enrolments', $record2, $bulk = false);
    return $updatestatus;
}

function buildsqlresittest($userid, $testfullname, $tescategory) {
    global $DB;

    $sql = "Select
        a.name,
        a.id As quizid
      From
        mdl_cifaquiz a Inner Join
        mdl_cifacourse b On b.id = a.course Inner Join
        mdl_cifaenrol d On d.courseid = b.id Inner Join
        mdl_cifauser_enrolments c On d.id = c.enrolid
      Where
        a.name LIKE '" . $testfullname . "' And
        b.category = '" . $tescategory . "' And
        c.userid = '" . $userid . "'";
    $data = $DB->get_record_sql($sql);
    return $data->quizid;
}

function checkboxresittest($courseenrolid, $userid, $testid, $passgrade) {
    global $DB;
    $days = daysina_month();
    $testfullname = buildsqlipdcert($courseenrolid)->fullname;
    $quizid = buildsqlresittest($userid, $testfullname, 3); // quizid Final test

    $qry = "SELECT a.status, b.orgtype, a.enrolid, b.firstaccess,b.lastaccess,b.firstname, b.lastname, b.traineeid,a.userid,a.timestart,a.timeend,b.lastlogin, a.lastaccess as courselastaccess,
                FROM_UNIXTIME(b.firstaccess,'%d/%m/%Y') as startdate, 
                FROM_UNIXTIME(b.timecreated,'%d/%m/%Y') as timecreated, 
                DATE_ADD(FROM_UNIXTIME(a.timeend,'%Y-%m-%d'), INTERVAL $days DAY) as courseexpirydate_update,
                DATE_ADD(FROM_UNIXTIME(b.firstaccess,'%Y-%m-%d'), INTERVAL 60 DAY) as enddate, 
                DATE_ADD(FROM_UNIXTIME(b.timecreated,'%Y-%m-%d'), INTERVAL 120 DAY) as lasttimecreated, b.email 
                FROM mdl_cifauser_enrolments a, mdl_cifauser b 
                WHERE a.enrolid='" . $courseenrolid . "' AND a.userid='" . $userid . "' AND b.deleted!='1'
                AND a.userid=b.id ORDER BY b.firstaccess DESC";
    $getdata = $DB->get_record_sql($qry);
    // $newexpirydate = strtotime("+$days day");
    $newexpirydate = strtotime('today midnight' . '+ ' . $days . ' day - 1 minutes');
    $testexpirydate = testexpirydate($userid, $testid);
    $attempts = countattempttest($userid, $passgrade, $quizid); // count attempts for FAIL candidates
    $attemptstatus = teststatus_resit($quizid, $userid); // Open or Close
    //update expiry date course && Final Test
    if ((time() >= $getdata->timeend)) {
        if ($attemptstatus == get_string('openstatus')) {
            // Update expiry date for 1 months
            $testresit = update_expirydate($courseenrolid, $newexpirydate, $userid, $testid, $testexpirydate);
        }
        if (!empty($attempts)) {
            //FAIL // re-open the test
            $testresit = update_expirydate($courseenrolid, $newexpirydate, $userid, $testid, $testexpirydate);
            $testresit .= limited_access_test($userid, $passgrade, $quizid); // 26 is quiz id for course id 64 
        }
    }else{//mmn add for resit before end of subscription date
			
			//$testresit = limited_access_test($userid, $passgrade, $quizid); // 26 is quiz id for course id 64 
		$sqldel = "Select 
            b.userid,
            c.grade,b.quiz as attemptquizid,
            a.name, a.id
          From
            {quiz} a Inner Join
            {quiz_attempts} b On a.id = b.quiz Inner Join
            {quiz_grades} c On b.userid = c.userid And b.quiz = c.quiz
          Where
            a.id = '" . $quizid . "' And b.userid = '" . $userid . "' And c.grade < '" . $grade . "'";
    $data2 = $DB->get_record_sql($sqldel);

    // delete record jika attempts has been limit(2)
    if (!empty($data->attemptquizid)) {
        $delete1 = $DB->delete_records('quiz_attempts', array('userid' => $data2->userid, 'quiz' => $data2->attemptquizid));
        $delete2 = $DB->delete_records('quiz_grades', array('userid' => $data2->userid, 'quiz' => $data2->attemptquizid));
        $resetall = $delete1 . $delete2;
    }
	}

    if (finaltest_sql($userid, $testid)->status != 0) {
        updatetestenrolstatus($userid, $testid); // re-active test enrolment status
        updatetestenrolstatus($userid, 62);
    } else {
        updatetestenrolstatus($userid, 62);
    }

    return $testresit;
}

// Re-sit the test
function supportcourse_resittest($resitcoursehistory, $userid, $passgrade) {
    global $CFG;
    $testid = '64';
    if (!empty($resitcoursehistory)) {
        for ($i = 0; $i < sizeof($resitcoursehistory); $i++) {
            checkboxresittest($resitcoursehistory[$i], $userid, $testid, $passgrade); // id 
        }
    }
    $redirecturl = $CFG->wwwroot . '/organization/orgview.php?formtype=User&id=' . $userid . '&display=userdetails&supportform=' . get_string('coursehistory') . '&resit=1';
    die("<script>location.href = '" . $redirecturl . "'</script>");
}

function builsqlstatementipdcert($testfullname, $userid) {
    $statement = "From
            {quiz} a Inner Join
            {course} b On b.id = a.course Inner Join
            {enrol} d On d.courseid = b.id Inner Join
            {user_enrolments} c On d.id = c.enrolid Inner Join
            {quiz_grades} e On a.id = e.quiz And e.userid = c.userid
          Where
            a.name LIKE '" . $testfullname . "' And
            b.category = '3' And
            c.userid = '" . $userid . "'";
    return $statement;
}

function ipdcerttestid($userid, $testfullname) {
    global $DB;
    $ipdcertstatement = builsqlstatementipdcert($testfullname, $userid);
    $sql = "Select
            a.name,
            a.id As quizid
          $ipdcertstatement";
    $data = $DB->get_record_sql($sql);
    return $data->quizid;
}

function ifshowipdcert($userid, $testfullname) {
    global $DB;
    $ipdcertstatement = builsqlstatementipdcert($testfullname, $userid);
    $sql = "Select
            COUNT(DISTINCT a.id)
          $ipdcertstatement";

    return $DB->count_records_sql($sql);
}

function buildsqlipdcert($ipdcertid) {
    global $DB;

    $sql = "Select
            b.id,
            a.fullname
          From
            {course} a Inner Join
            {enrol} b On b.courseid = a.id
          Where
            b.id = '" . $ipdcertid . "'";
    $data = $DB->get_record_sql($sql);
    return $data;
}

function checkboxshowipdcert($ipdcertid, $userid) {
    global $CFG;

    $testfullname = buildsqlipdcert($ipdcertid)->fullname;
    $gettestid = ipdcerttestid($userid, $testfullname);

    $linkipdcert = $CFG->wwwroot . '/userfrontpage/certify.php?id=' . $userid . '&testid=' . $gettestid;
    $actionshowipdcert = "window.open('" . $linkipdcert . "','_blank')";
    echo $showipdcert = "<script>" . $actionshowipdcert . "</script>";
}

// Show ipd cert by course title
function showipdcert($ipdcertid, $userid) {
    global $CFG;
    $ifshowipdcert = ifshowipdcert($userid, $testfullname);
    if (!empty($ipdcertid)) {
        for ($i = 0; $i < sizeof($ipdcertid); $i++) {
            $testfullname = buildsqlipdcert($ipdcertid[$i])->fullname;
            if (!empty($ifshowipdcert)) {
                checkboxshowipdcert($ipdcertid[$i], $userid); // id 
            }
        }
    }
    $redirecturl = $CFG->wwwroot . '/organization/orgview.php?formtype=User&id=' . $userid . '&display=userdetails&supportform=' . get_string('coursehistory');
    if (empty($ifshowipdcert)) {
        $redirecturl .= '&erroripdcert=1';
    }
    die("<script>location.href = '" . $redirecturl . "'</script>");
}

function supportcourse_save($userid, $sc4, $sc5, $enrolnewcourse) {
    global $DB, $CFG;
    $days = daysina_month();
    $testid = '64';
    $enrolmentid = finaltest_sql($userid, $testid)->enrolmentid; // TEST enrolment id
    $mocktestenrollmentid = finaltest_sql($userid, 62)->enrolmentid;
    $newexpirydate = strtotime('today midnight' . '+ ' . $days . ' day - 1 minutes');
    $timestart = strtotime($sc4 . ' midnight');
    $timeend = strtotime($sc5 . ' midnight' . '+ 23 hours 59 minutes');
    $testexpirydate = testexpirydate($userid, $testid);

    if (finaltest_sql($userid, $testid)->status != 0) {
        updatetestenrolstatus($userid, $testid); // re-active test enrolment status
        updatetestenrolstatus($userid, 62);
    } else {
        updatetestenrolstatus($userid, 62);
    }

    if (time() >= strtotime($testexpirydate)) {
        buildupdatedexpirydate($enrolmentid, $newexpirydate);               // Final test
        buildupdatedexpirydate($mocktestenrollmentid, $newexpirydate);      // Mock
    }

    $insertdata = new stdClass();
    $insertdata->enrolid = $enrolnewcourse;
    $insertdata->userid = $userid;
    $insertdata->timestart = $timestart;
    $insertdata->timeend = $timeend;
    $insertdata->timecreated = time();
    $insertdata->timemodified = time();
    $insertdata->modifierid = 2;
    $DB->insert_record('user_enrolments', $insertdata, false);

    $redirecturl = $CFG->wwwroot . '/organization/orgview.php?formtype=User&id=' . $userid . '&display=userdetails&supportform=' . get_string('coursehistory');
    die("<script>location.href = '" . $redirecturl . "'</script>");
}

// MAIN course history
function supportcourse_history($logginuserid, $whichsupportbutton, $userid, $delcoursehistory, $extenddays, $sc1, $sc2, $sc3, $sc4, $sc5, $sc6, $sc7, $enrolnewcourse) {
    $passgrade = 60;
    $searchbymark = gettestfullnamebyuserid($userid, $sc3)->name;
    // echo 'Search test status & add new belum settel lo';    
    $table = new html_table();
    $table->width = "100%";
    $table->head = array(get_string('enrolmentdate'), get_string('coursetitle'), get_string('subscriptionstartdate'), get_string('subscriptionendate'), get_string('teststatus'), get_string('marks'), get_string('serviceby'), '');
    $table->align = array("center", "center", "center", "center", "center", "center", "center", "center");
    switch ($whichsupportbutton) {
        case get_string('search'):
            coursehistory_search($userid, $table);
            supportcourse_default($userid, $table, $logginuserid, $passgrade, $searchstatus, $sc2, $searchbymark, $sc4, $sc5, $sc6, $sc7);
            break;
        case get_string('new'):
            supportcourse_new($userid, $table, $logginuserid, $extenddays);
            break;
        case get_string('savebutton'):
            echo supportcourse_save($userid, $sc4, $sc5, $enrolnewcourse);
            break;
        case get_string('delete'):
            supportcourse_delete($delcoursehistory, $userid);
            break;
        case get_string('extendedcourse'):
            if (!empty($delcoursehistory)) {
                supportcourse_extend($delcoursehistory, $userid, $extenddays); // 60 is extend days // 2 months 
            } else {
                supportcourse_default($userid, $table, $logginuserid, $passgrade);
            }
            break;
        case get_string('testresit'):
            if (!empty($delcoursehistory)) {
                supportcourse_resittest($delcoursehistory, $userid, $passgrade);
            } else {
                supportcourse_default($userid, $table, $logginuserid, $passgrade);
            }
            break;
        case get_string('ipdcert'):
            if (!empty($delcoursehistory)) {
                showipdcert($delcoursehistory, $userid);
            } else {
                supportcourse_default($userid, $table, $logginuserid, $passgrade);
            }
            break;
        default:
            supportcourse_default($userid, $table, $logginuserid, $passgrade); // 60 is pass grade
    }
    if (!empty($table)) {
        echo html_writer::table($table);
    }
}

function buildactivities_category($menu) {
    global $DB;

    $sql = "Select * From {activity_categories} Where menu='" . $menu . "' Order By id Asc";
    $data = $DB->get_records_sql($sql);

    return $data;
}

function selectactivities_category($categoryname, $categoryvalue, $menu) {
    $getcategory = buildactivities_category($menu);
    $a = html_writer::start_tag('select', array('name' => $categoryname, 'style' => 'width:150px;'));
    $a.= '<option value=""> select one </option>';
    foreach ($getcategory as $category) {
        $a.= '<option value="' . $category->id . '"';
        if ($category->id == $categoryvalue) {
            $a.="Selected";
        }
        $a.= '>' . $category->content . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

function supportactivities_new($table, $logginuserid) {
    $userdatetime = date('d/m/Y H:i:s', time());
    $categoryname = 'supportcategoryname';
    $activitiescategory = selectactivities_category($categoryname, '', 1);
    $activitiesdesc = createtextarea('supportdesc', 'supportdesc', '100%', '10', '', 'placeholder="max 500 character"');
    $activitiesdatetitme = createinputtext('hidden', 'searchdatetimefinance', 'searchdatetimefinance', time());       // support date
    $createdby = createinputtext('hidden', 'createdby', 'createdby', $logginuserid);                        // created by     
    $generateActivitiyId = createinputtext('hidden', 'generateActivitiyId', 'generateActivitiyId', generateActivitiyId());

    $table->data[] = array(
        $userdatetime . $activitiesdatetitme, $generateActivitiyId . generateActivitiyId(), $activitiescategory, $activitiesdesc, createdbyuser($logginuserid) . $createdby, ''
    );
}

function buildsupport_activities($userid, $searchcategory, $searchdesc, $searchdate, $searchactivityid, $searchcreatedby) {
    global $DB;

    $sql = "Select *, From_UnixTime(timecreated, '%d/%m/%Y') As getdate From {log_activity} Where recipientid='" . $userid . "' And deleted='0'";
    if (!empty($searchcategory)) {
        $sql.=" And category = '" . $searchcategory . "'";
    }
    if (!empty($searchdesc)) {
        $sql.=" And information Like '%" . $searchdesc . "%'";
    }
    if (!empty($searchdate)) {
        $sql.=" And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL timecreated SECOND), '%d-%m-%Y') LIKE '%{$searchdate}%'))";
    }
    if (!empty($searchactivityid)) {
        $sql.=" And activityid LIKE '%" . $searchactivityid . "%'";
    }
    if (!empty($searchcreatedby)) {
        $sql.=" And createdby='2'";
    }
    $sql.=" Order By id Desc";
    $data = $DB->get_records_sql($sql);
    return $data;
}

function getActivitiyId($activitylogid) {
    if ($activitylogid < 10) {
        $a = '0000';
    } elseif ($activitylogid < 100) {
        $a = '000';
    } elseif ($activitylogid < 1000) {
        $a = '00';
    } else {
        $a = '0';
    }
    return $supportid = 'A' . $a . $activitylogid;
}

function getActivityCategoryName($category, $menu) {
    global $DB;
    $sql = "Select * From {activity_categories} Where id='" . $category . "' And menu='" . $menu . "'  Order By id Asc";
    return $DB->get_record_sql($sql);
}

function supportactivities_default($userid, $table, $logginuserid, $searchcategory, $searchdesc, $searchdatee, $searchactivityid, $searchcreatedby, $formtype) {
    global $DB;
    if ($formtype == get_string('user')) {
        $records = buildsupport_activities($userid, $searchcategory, $searchdesc, $searchdatee, $searchactivityid, $searchcreatedby);
    } else if ($formtype == get_string('organization')) {
        $records = buildsupport_activities_org($userid, $searchcategory, $searchdesc, $searchdatee, $searchactivityid, $searchcreatedby);
    }

    foreach ($records as $record) {
        $author = createdbyuser($record->createdby);
        $sql = "Select * From {activity_categories} Where id='" . $record->category . "' And menu='1' Order By id Asc";  // Menu=1 means activities

        $timecreated = $record->getdate;
        $activitiescategory = $DB->get_record_sql($sql)->content;
        $activitiesdesc = $record->information;

        $checkbox = createinputcheckdelete('checkbox', 'delcoursehistory', "delcoursehistory[]", $record->id);
        $table->data[] = array(
            $timecreated, getActivitiyId($record->id), $activitiescategory, $activitiesdesc, $author, $checkbox
        );
    }
}

function checkboxdel_activities($supportactivityid) {
    global $DB;

    $deleteactivity = new stdClass();
    $deleteactivity->id = $supportactivityid;
    $deleteactivity->deleted = 1;

    $saverecord = $DB->update_record('log_activity', $deleteactivity);
    return $saverecord;
}

function supportactivities_delete($del_activities, $userid, $formtype) {
    global $CFG;

    if ($formtype == get_string('user')) {
        $display = 'userdetails';
    }
    if ($formtype == get_string('organization')) {
        $display = 'organizationdetails';
    }
    if (!empty($del_activities)) {
        for ($i = 0; $i < sizeof($del_activities); $i++) {
            // delete only // HIDE
            checkboxdel_activities($del_activities[$i]); // id 
        }
    }
    $deleteurl = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $userid . '&display=' . $display . '&supportform=' . get_string('activities') . '&delete=1';
    die("<script>location.href = '" . $deleteurl . "'</script>");
}

function selectcreatedby_activities($name) {
    global $DB;

    $sql = "Select createdby From {log_activity} Group By createdby Order By id ASC";
    $getcreatedby = $DB->get_recordset_sql($sql);

    $a = html_writer::start_tag('select', array('name' => $name, 'style' => 'width:100px;'));
    $a.='<option value="">' . get_string('chooseone') . '</option>';
    foreach ($getcreatedby as $gcreatedby) {
        $createdbyname = strtoupper(get_user_details($gcreatedby->createdby)->username);
        $a.='<option value="' . $gcreatedby->createdby . '">' . $createdbyname . '</option>';
    }
    $a.=html_writer::end_tag('select');
    return $a;
}

function supportactivities_search($table) {
    $categoryname = 'supportcategoryname';
    $activitiescategory = selectactivities_category($categoryname, '', 1);
    $activitiesdesc = createtextarea('supportdesc', 'supportdesc', '100%', '10', '', 'placeholder=" max 500 character"');
    $activitiesid = createinputtext('text', 'searchtransactionid', 'searchtransactionid', '', '', 'width:100px;text-align:center;');
    $activitiesdatetitme = createinputtext('text', 'searchdatetimefinance', 'searchdatetimefinance', '', 'dd-mm-yy', 'width:80px;text-align:center;');
    $createdby = selectcreatedby_activities('searchcreatedby');                  // created by     

    $table->data[] = array(
        $activitiesdatetitme, $activitiesid, $activitiescategory, $activitiesdesc, $createdby, ''
    );
}

function supportactivities_save($userid, $logginuserid, $category, $description, $generateActivitiyId, $formtype) {
    global $DB, $CFG;
    if ($formtype == get_string('user')) {
        $display = 'userdetails';
        $usertype = '5';
        if (!empty(get_user_details($userid)->email)) {
            $recipient = get_user_details($userid)->email;
        } else {
            $recipient = ' - ';
        }
    }
    if ($formtype == get_string('organization')) {
        $display = 'organizationdetails';
        $recipient = getOrganizationId($userid)->email;
        $usertype = '6';
    }

    $categoryname = getActivityCategoryName($category, 1)->content;
    $insertdata = new stdClass();
    $insertdata->timecreated = time();
    $insertdata->activityid = $generateActivitiyId;
    $insertdata->recipientid = $userid;
    $insertdata->usertype = $usertype;
    $insertdata->activity = $categoryname . ': ' . $description;
    $insertdata->purpose = $categoryname . ': ' . $description;
    $insertdata->recipient = $recipient;
    $insertdata->sender = get_user_details($logginuserid)->email;
    $insertdata->status = 0;

    $insertdata->category = $category;
    $insertdata->information = $description;
    $insertdata->createdby = $logginuserid;
    $DB->insert_record('log_activity', $insertdata, false);

    $redirecturl = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $userid . '&display=' . $display . '&supportform=' . get_string('activities') . '&new=1';
    die("<script>location.href = '" . $redirecturl . "'</script>");
}

// support activities MAIN here
function supportactivities($userid, $whichsupportbutton, $logginuserid, $p2, $p3, $f6, $f7, $f8, $generateActivitiyId, $formtype, $del_activities) {
    $table = new html_table();
    $table->width = "100%";
    $table->head = array(get_string('date'), get_string('activityid'), get_string('supportcategory'), get_string('description'), get_string('createdby'), '');
    $table->align = array("center", "center", "center", "center", "center");
    switch ($whichsupportbutton) {
        case get_string('search'):
            supportactivities_search($table, $logginuserid);
            supportactivities_default($userid, $table, $logginuserid, $p2, $p3, $f6, $f7, $f8, $formtype);
            break;
        case get_string('new'):
            supportactivities_new($table, $logginuserid);
            break;
        case get_string('savebutton'):
            echo 'savebutton';
            supportactivities_save($userid, $logginuserid, $p2, $p3, $generateActivitiyId, $formtype);
            break;
        case get_string('delete'):
            if (!empty($del_activities)) {
                supportactivities_delete($del_activities, $userid, $formtype);
            } else {
                supportactivities_default($userid, $table, $logginuserid);
            }
            break;
        default:
            supportactivities_default($userid, $table, $logginuserid, $p2, $p3, $f6, $f7, $f8, $formtype);
    }
    if (!empty($table)) {
        echo html_writer::table($table);
    }
}

function buildsupport_attachment($userid, $searchcategory, $searchdesc, $searchdate, $searchattachmentid, $searchcreatedby) {
    global $DB;

    $sql = "Select *, From_UnixTime(timecreated, '%d/%m/%Y') As getdate From {support_attachment} Where userid='" . $userid . "' And status='0'";
    if (!empty($searchcategory)) {
        $sql.=" And category = '" . $searchcategory . "'";
    }
    if (!empty($searchdesc)) {
        $sql.=" And attachment_desc Like '%" . $searchdesc . "%'";
    }
    if (!empty($searchdate)) {
        $sql.=" And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL timecreated SECOND), '%d-%m-%Y') LIKE '%{$searchdate}%'))";
    }
    if (!empty($searchattachmentid)) {
        $sql.=" And attachmentid LIKE '%" . $searchattachmentid . "%'";
    }
    if (!empty($searchcreatedby)) {
        $sql.=" And createdby='" . $searchcreatedby . "'";
    }
    $sql.=" Order By id Desc";
    $data = $DB->get_recordset_sql($sql);
    return $data;
}

function supportattachment_default($userid, $table, $searchcategory, $searchdesc, $searchdate, $searchattachmentid, $searchcreatedby, $formtype) {
    global $DB, $CFG;
    if ($formtype == get_string('user')) {
        $records = buildsupport_attachment($userid, $searchcategory, $searchdesc, $searchdate, $searchattachmentid, $searchcreatedby);
    } else if ($formtype == get_string('organization')) {
        $records = buildsupport_attachment_org($userid, $searchcategory, $searchdesc, $searchdate, $searchattachmentid, $searchcreatedby);
    }

    foreach ($records as $record) {
        $author = createdbyuser($record->createdby);
        $sql = "Select * From {activity_categories} Where id='" . $record->category . "' Order By id Asc";

        $timecreated = $record->getdate;
        $attachmentcategory = $DB->get_record_sql($sql)->content;
        $attachmentdesc = $record->attachment_desc;
        $link = $CFG->wwwroot . '/organization/' . $record->attachment_path;
        if (empty($record->attachment)) {
            $attachmentfilename = attachmentloader($userid, $formtype, $record->id);
        } else {
            $attachmentfilename = '<a href="' . $link . '" target="_blank"><u>' . $record->attachment . '</u></a>';
        }

        $checkbox = createinputcheckdelete('checkbox', 'delcoursehistory', "delcoursehistory[]", $record->id);
        $table->data[] = array(
            $timecreated, $record->attachmentid, $attachmentcategory, $attachmentdesc, $attachmentfilename, $author, $checkbox
        );
    }
}

function attachmentloader($userid, $formtype, $attachmentid) {
    global $CFG;
    $name = 'Upload';
    $poplink = $CFG->wwwroot . '/organization/attachmentfiles.php?id=' . $userid . '&type=' . $formtype . '&aid=' . $attachmentid;
    $onclick = "window.open('" . $poplink . "', 'Window2', 'width=880,height=630, scrollbars=1')";
    $attachmentloader = '<input type="button" name="attachmentloader" id="attachmentloader" value="' . $name . '" onclick="' . $onclick . '" style="margin-top:0.8em;margin-right:0.5em;line-height:1em;height:28px;" />';
    return $attachmentloader;
}

function supportattachment_new($table, $logginuserid, $userid, $formtype) {
    $userdatetime = date('d/m/Y H:i:s', time());
    $categoryname = 'supportcategoryname';
    $activitiescategory = selectactivities_category($categoryname, '', 2);
    $activitiesdesc = createtextarea('supportdesc', 'supportdesc', '100%', '10', '', 'placeholder=" max 500 character" style="width:100%;"');
    $activitiesdatetitme = createinputtext('hidden', 'searchdatetimefinance', 'searchdatetimefinance', time());       // support date
    $createdby = createinputtext('hidden', 'createdby', 'createdby', $logginuserid);                        // created by     
    $generateAttachmentId = createinputtext('hidden', 'generateActivitiyId', 'generateActivitiyId', generateAttachmentId());

    $attachmentloader = attachmentloader($userid, $formtype, '');

    $table->data[] = array(
        $userdatetime . $activitiesdatetitme, $generateAttachmentId . generateAttachmentId(), $activitiescategory, $activitiesdesc, $attachmentloader, createdbyuser($logginuserid) . $createdby, ''
    );
}

function supportattachment_save($userid, $logginuserid, $category, $description, $generateAttachmentId, $formtype) {
    global $DB, $CFG;

    if ($formtype == get_string('user')) {
        $display = 'userdetails';
        $usertype = '5';
    } else if ($formtype == get_string('organization')) {
        $display = 'organizationdetails';
        $usertype = '6';
    }
    $sql = "Select * From {support_attachment} Where userid='" . $userid . "' And attachmentid='' And category='0'";
    $data = $DB->get_record_sql($sql);

    $sql2 = "Select COUNT(DISTINCT id) From {support_attachment} Where userid='" . $userid . "' And attachmentid='' And category='0'";
    $usercount = $DB->count_records_sql($sql2);
    if (!empty($usercount)) {
        // update record
        $insertdata = new stdClass();
        $insertdata->id = $data->id;
        $insertdata->timemodified = time();
        $insertdata->attachmentid = $generateAttachmentId;
        $insertdata->category = $category;
        $insertdata->attachment_desc = $description;
        $insertdata->createdby = $logginuserid;

        $DB->update_record('support_attachment', $insertdata);
    } else {
        $insertdata = new stdClass();
        $insertdata->usertype = $usertype;
        $insertdata->userid = $userid;
        $insertdata->timecreated = time();
        $insertdata->attachmentid = $generateAttachmentId;
        $insertdata->category = $category;
        $insertdata->attachment_desc = $description;
        $insertdata->attachment = '';
        $insertdata->attachment_path = '';
        $insertdata->createdby = $logginuserid;
        $DB->insert_record('support_attachment', $insertdata, false);
    }
    $redirecturl = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $userid . '&display=' . $display . '&supportform=' . get_string('attachment') . '&new=1';
    die("<script>location.href = '" . $redirecturl . "'</script>");
}

function checkboxdel_attachment($supportattachment_id) {
    global $DB;

    $deleteattachment = new stdClass();
    $deleteattachment->id = $supportattachment_id;
    $deleteattachment->status = 1;

    $saverecord = $DB->update_record('support_attachment', $deleteattachment);
    return $saverecord;
}

function supportattachment_delete($del_attachment, $userid, $formtype) {
    global $CFG;
    if (!empty($del_attachment)) {
        for ($i = 0; $i < sizeof($del_attachment); $i++) {
            // delete only // HIDE
            checkboxdel_attachment($del_attachment[$i]); // id 
        }
    }
    $deleteurl = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $userid . '&display=userdetails&supportform=' . get_string('attachment') . '&delete=1';
    die("<script>location.href = '" . $deleteurl . "'</script>");
}

function supportattachment_search($table) {
    $categoryname = 'supportcategoryname';
    $activitiescategory = selectactivities_category($categoryname, '', 2);
    $activitiesdesc = createtextarea('supportdesc', 'supportdesc', '100%', '10', '', 'placeholder=" max 500 character" style="width:450px;"');
    $activitiesid = createinputtext('text', 'searchtransactionid', 'searchtransactionid', '', '', 'width:100px;text-align:center;');
    $activitiesdatetitme = createinputtext('text', 'searchdatetimefinance', 'searchdatetimefinance', '', 'dd-mm-yy', 'width:80px;text-align:center;');
    $createdby = selectcreatedby_activities('searchcreatedby');                  // created by     

    $table->data[] = array(
        $activitiesdatetitme, $activitiesid, $activitiescategory, $activitiesdesc, '', $createdby, ''
    );
}

function supportattachment_switchcase($table, $userid, $whichsupportbutton, $logginuserid, $p2, $p3, $f6, $f7, $f8, $generateActivitiyId, $formtype, $del_attachment) {
    switch ($whichsupportbutton) {
        case get_string('search'):
            supportattachment_search($table, $logginuserid);
            supportattachment_default($userid, $table, $p2, $p3, $f6, $f7, $f8, $formtype);
            break;
        case get_string('new'):
            supportattachment_new($table, $logginuserid, $userid, $formtype);
            break;
        case get_string('savebutton'):
            supportattachment_save($userid, $logginuserid, $p2, $p3, $generateActivitiyId, $formtype);
            break;
        case get_string('delete'):
            if (!empty($del_attachment)) {
                supportattachment_delete($del_attachment, $userid, $formtype);
            } else {
                supportattachment_default($userid, $table, $logginuserid);
            }
            break;
        default:
            supportattachment_default($userid, $table, $p2, $p3, $f6, $f7, $f8, $formtype);
    }
}

// Attachment MAIN here
function supportattachment($userid, $whichsupportbutton, $logginuserid, $p2, $p3, $f6, $f7, $f8, $generateActivitiyId, $formtype, $del_attachment) {
    $table = new html_table();
    $table->width = "100%";
    $table->head = array(get_string('date'), get_string('activityid'), get_string('supportcategory'), get_string('description'), get_string('attachment'), get_string('createdby'), '');
    $table->align = array("center", "center", "center", "center", "center", "center", "center");

    // switch case loop here
    supportattachment_switchcase($table, $userid, $whichsupportbutton, $logginuserid, $p2, $p3, $f6, $f7, $f8, $generateActivitiyId, $formtype, $del_attachment);
    if (!empty($table)) {
        echo html_writer::table($table);
    }
}

// SWITCHCASE START HERE TO DISPLAY PAGE
function createdswitchcase($n, $label1, $label2, $label3, $label4, $label5, $logginuserid, $whichsupportbutton = '', $p1 = '', $p2 = '', $p3 = '', $uid = '', $f2 = '', $f3 = '', $f4 = '', $f5 = '', $delid = '', $f6 = '', $f7 = '', $f8 = '', $f9 = '', $delcoursehistory = '', $extenddays = '', $sc1 = '', $sc2 = '', $sc3 = '', $sc4 = '', $sc5 = '', $enrolnewcourse = '', $generateActivitiyId = '', $formtype = '') {
    $userdetails = get_user_details($logginuserid);
    $groupid = strtoupper($userdetails->username);
    $author = $groupid . ' (' . $userdetails->firstname . ' ' . $userdetails->lastname . ')';
    $userdatetime = date('d-m-Y H:i:s', time());
   switch ($n) {
        case $label1:
            supportcontent($uid, $logginuserid, $whichsupportbutton, $p1, $p2, $p3, $f6, $f7, $f8, $generateActivitiyId, $formtype, $delcoursehistory);
            break;
        case $label2:
            // activities// $delcoursehistory==$del_activities
            echo supportactivities($uid, $whichsupportbutton, $logginuserid, $p2, $p3, $f6, $f7, $f8, $generateActivitiyId, $formtype, $delcoursehistory);
            break;
        case $label3:
            // attachment
            supportattachment($uid, $whichsupportbutton, $logginuserid, $p2, $p3, $f6, $f7, $f8, $generateActivitiyId, $formtype, $delcoursehistory);
            break;
        case $label4:
            // Financial history
            echo supportfinancial_history($uid, $whichsupportbutton, $logginuserid, $label4, $f2, $f3, $f4, $f5, $delid, $f6, $f7, $f8, $f9);
            break;
        case $label5:
            // course history
            echo supportcourse_history($logginuserid, $whichsupportbutton, $uid, $delcoursehistory, $extenddays, $sc1, $sc2, $sc3, $sc4, $sc5, $f6, $f8, $enrolnewcourse);
            break;
        default:
            supportcontent($uid, $logginuserid, $whichsupportbutton, $p1, $p2, $p3, $f6, $f7, $f8, $generateActivitiyId, $formtype, $delcoursehistory);
        // echo supportcontent($uid, $logginuserid, $whichsupportbutton, $p1, $p2, $p3);
    }
}

function subscribeduser_org($organizationid, $courseid) {
    global $DB;
    $sql = "    
    Select
      *
    From
      mdl_cifauser a Inner Join
      mdl_cifauser_enrolments c On a.id = c.userid Inner Join
      mdl_cifaenrol b On b.id = c.enrolid Inner Join
      mdl_cifaorganization_type d On a.orgtype = d.id Inner Join
      mdl_cifacontext e On e.instanceid = b.courseid
    Where
      a.suborgtype = '" . $organizationid . "' And
      b.courseid = '" . $courseid . "' And
      a.id <> '2' And
      (a.usertype = 'Active candidate' Or
        a.usertype = 'Inactive candidate')";

    $data = $DB->get_records_sql($sql);
    return $data;
}

//Count total user subscribe. For Organization page
function counttotalsubscribeduser_org($organizationid, $courseid) {
    global $DB;
    $sql = "    
    Select
      Count(Distinct a.id)
    From
      mdl_cifauser a Inner Join
      mdl_cifauser_enrolments c On a.id = c.userid Inner Join
      mdl_cifaenrol b On b.id = c.enrolid Inner Join
      mdl_cifaorganization_type d On a.orgtype = d.id Inner Join
      mdl_cifacontext e On e.instanceid = b.courseid
    Where
      a.suborgtype = '" . $organizationid . "' And
      b.courseid = '" . $courseid . "' And
      a.id <> '2' And
      (a.usertype = 'Active candidate' Or
        a.usertype = 'Inactive candidate')";

    $a = $DB->count_records_sql($sql);
    return $a;
}

function userpassrateis($examname, $organizationid, $passgrade, $examid) {
    global $DB;

    $sql = "Select
        Count(Distinct c.userid)
      From
        {course} a Inner Join
        {quiz} b On a.id = b.course Inner Join
        {quiz_grades} c On b.id = c.quiz Inner Join
        {user} d On c.userid = d.id Inner Join
        {organization_type} e On d.suborgtype = e.id
      Where
        b.name Like '" . $examname . "' And 
        d.suborgtype= '" . $organizationid . "' And
        c.grade >= '" . $passgrade . "' And
        a.id = '" . $examid . "'";

    $grade = $DB->count_records_sql($sql);
    return $grade;
}

function testdetails($coursecode, $category) {
    global $DB;

    $sql = "SELECT * FROM {course} WHERE idnumber='" . $coursecode . "' AND category='" . $category . "' Order By idnumber ASC";
    $data = $DB->get_record_sql($sql);
    return $data;
}

function listOrganization() {
    global $DB;

    $sql = "Select * From {organization_type} Order By id Desc";
    return $DB->get_record_sql($sql);
}

// Pass rate dalam page organization
function passrateorganization($organizationid, $passgrade) {
    foreach (coursepassrate($organizationid) as $cpassrate) {
        /* $grade = userpassrateis(testdetails($cpassrate->coursecode, 1)->fullname, $organizationid, $passgrade, testdetails($cpassrate->coursecode, 3)->id);
          $peratus = ($grade / 100) * 100;   // peratus
          $ppperatus+=$peratus;
          $b+=100;
          $totalperatus = round(($ppperatus / $b) * 100); */


        $usersattemptcourse = counttotalsubscribeduser_org($organizationid, $cpassrate->courseid);   // user yg attempt course
        $total+=$usersattemptcourse;

        // echo $data->id1;
        $userpassrate = userpassrateis(testdetails($cpassrate->coursecode, 1)->fullname, $organizationid, $passgrade, testdetails($cpassrate->coursecode, 3)->id);
        $totaluserpassrate+=$userpassrate;
        $getperatus = ($totaluserpassrate / $total) * 100;

        $totalgetperatus+=$getperatus;
    }
    return round($totalgetperatus) . '%';
}

function coursepassrate($orgid) {
    global $DB;
    $sql = "Select
            a.fullname,
            d.suborgtype,
            b.courseid,
            a.idnumber As coursecode,
            c.userid,
            d.firstname,
            d.lastname,
            e.groupofinstitution
          From
            {course} a Inner Join
            {enrol} b On a.id = b.courseid Inner Join
            {user_enrolments} c On b.id = c.enrolid Inner Join
            {user} d On c.userid = d.id Inner Join
            {organization_type} e On d.suborgtype = e.id
          Where
          d.suborgtype = '" . $orgid . "' And a.category = '1' Group By b.courseid";
    $data = $DB->get_recordset_sql($sql);
    return $data;
}

// display status for users
function checkuserstatus($getuserid) {
    global $DB;

    $sql = "							
            Select
              c.timestart, c.timeend, DATE_ADD(FROM_UNIXTIME(d.timecreated,'%Y-%m-%d'), INTERVAL 120 DAY) as lasttimecreated
            From
              {course} a Inner Join
              {enrol} b On a.id = b.courseid Inner Join
              {user_enrolments} c On b.id = c.enrolid Inner Join
              {user} d On c.userid = d.id
            Where
              c.userid = '" . $getuserid . "' And
              b.enrol = 'manual' And
              a.category = '1' And
              a.visible = '1' And
              b.status = '0' Group By c.userid";

    $rs = $DB->get_record_sql($sql);
    if ($rs->timeend >= strtotime($rs->lasttimecreated)) {
        if (strtotime('now') > $rs->timeend) {
            $status = 'Inactive';
        } else {
            $status = 'Active';
        }
    } else {
        if (strtotime('now') > strtotime($rs->lasttimecreated)) {
            $status = 'Inactive';
        } else {
            $status = 'Active';
        }
    }
    return $status;
}

// users -> communication preference  partgetdetailscommpreference_users
function getcommpreference_users($cpid, $userid) {
    global $DB;
    $sql = "Select * From {communication_users} Where cpid='" . $cpid . "' And userid='" . $userid . "' Order By id Asc";
    return $DB->get_record_sql($sql);
}

function getdetailscommpreference_users($userid, $status) {
    global $DB;
    $sql = "Select * From {communication_users} Where userid='" . $userid . "' And status='" . $status . "' Order By id Asc";
    return $DB->get_recordset_sql($sql);
}

function savecommunicationusers($cpid, $userid) {
    global $DB;

    $insertdata = new stdClass();
    $insertdata->cpid = $cpid;
    $insertdata->userid = $userid;
    $insertdata->status = 1;
    return $DB->insert_record('communication_users', $insertdata, false);
}

function updateuserscommunication($commpreferenceid, $status) {
    global $DB;

    $record = new stdClass();
    $record->id = $commpreferenceid;
    $record->status = $status;
    return $DB->update_record('communication_users', $record, false);
}

// users -> communication preference  part
function countcommunicationpreference($cpid, $userid) {
    global $DB;

    return $DB->count_records('communication_users', array('userid' => $userid, 'cpid' => $cpid));
}

// Display list of users for tab users
function searchitemsfield($searchcid, $searchfirstname, $searchlastname, $searchemail, $searchcity, $searchdob, $sgender, $scountry) {
    if (!empty($searchcid)) {
        $where .= " And traineeid LIKE '%" . $searchcid . "%'";
    } elseif (!empty($searchcid) && !empty($searchemail)) {
        $where .= " And traineeid LIKE '%" . $searchcid . "%' And email = '" . $searchemail . "'";
    }
    if (!empty($searchfirstname)) {
        $where .= " And firstname LIKE '%" . $searchfirstname . "%'";
    }
    if (!empty($searchlastname)) {
        $where .= " And lastname LIKE '%" . $searchlastname . "%'";
    }
    if (!empty($searchemail)) {
        $where .= " And email = '" . $searchemail . "'";
    }
    if (!empty($sgender)) {
        if ($sgender != '1') {
            $where .= " And gender = '0'";
        } else {
            $where .= " And gender = '" . $sgender . "'";
        }
    }
    if (!empty($searchcity)) {
        $where .= " And city LIKE '%" . $searchcity . "%'";
    }
    if (!empty($scountry)) {
        $where .= " And country = '" . $scountry . "'";
    }
    if (!empty($searchdob)) {
        $where.=" And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL dob SECOND), '%d-%m-%Y') LIKE '%{$searchdob}%'))";
    }
    return $where;
}

function buildusersdb_listall($page, $perpage, $formtype, $searchcid, $searchfirstname, $searchlastname, $searchemail, $searchcity, $searchdob, $sgender, $scountry) {
    global $DB;

    $fromrecords = $page * $perpage;
    $where = "Where confirmed='1' And deleted='0'";
    if ($formtype == get_string('user')) {
        $where .= " And traineeid LIKE 'A%' AND id<>'2'";
    }

    $where .= searchitemsfield($searchcid, $searchfirstname, $searchlastname, $searchemail, $searchcity, $searchdob, $sgender, $scountry);

    $dbtable = "Select * From {user} {$where}";
    $dbtable .= "Order By id DESC LIMIT $perpage OFFSET $fromrecords";
    $result = $DB->get_records_sql($dbtable);
    return $result;
}

function countusers_org_tabs($formtype, $searchcid, $searchfirstname, $searchlastname, $searchemail, $searchcity, $searchdob, $sgender, $scountry, $searchorg0, $searchorg1, $searchorg2, $searchorg3, $searchorg4, $searchorg5, $searchorg6, $searchorg7) {
    global $DB;

    $where = "Where confirmed='1' And deleted='0'";
    if ($formtype == get_string('user')) {
        $where .= " And traineeid LIKE 'A%' AND id<>'2'";
    }
    $where .= searchitemsfield($searchcid, $searchfirstname, $searchlastname, $searchemail, $searchcity, $searchdob, $sgender, $scountry);

    $whereorg = "Where deletestatus='0'";
    $whereorg .= searchorg($searchorg0, $searchorg1, $searchorg2, $searchorg3, $searchorg4, $searchorg5, $searchorg6, $searchorg7);

    if ($formtype == get_string('organization')) {
        $sql = "Select COUNT(DISTINCT id) From {organization_type} {$whereorg}";
    } elseif ($formtype == get_string('user')) {
        $sql = "Select COUNT(DISTINCT id) From {user} {$where}";
    } else {
        $sql = "Select COUNT(DISTINCT id) From {organization_type} Where id='0'";
    }
    $usercount = $DB->count_records_sql($sql);
    return $usercount;
}

function usersexam_attempts($examid) {   // Examid is quiz id.
    global $DB;

    $sql = "Select COUNT(DISTINCT c.userid)
        From
          mdl_cifacourse a Inner Join
          mdl_cifaquiz b On a.id = b.course Inner Join
          mdl_cifaquiz_attempts c On b.id = c.quiz
        Where
          b.id = '" . $examid . "'
        Group By c.userid";
    $data = $DB->count_records_sql($sql);
    return $data;
}

function totalpassusers_exam($passgrade, $examid, $userid) {
    $sql = mysql_query("Select c.userid
        From
          mdl_cifacourse a Inner Join
          mdl_cifaquiz b On a.id = b.course Inner Join
          mdl_cifaquiz_attempts c On b.id = c.quiz Inner Join
          mdl_cifaquiz_grades d On c.quiz = d.quiz And c.userid = d.userid
        Where
          b.id = '" . $examid . "' And
          d.grade >= '" . $passgrade . "' And c.userid='" . $userid . "'
        Group By
          c.userid");

    $data = mysql_num_rows($sql);
    return $data;
}
