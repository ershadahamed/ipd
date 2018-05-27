<body onLoad="window.print()">
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../config.php');
require_once($CFG->libdir . '/tablelib.php');
require_once($CFG->libdir . '/filelib.php');
require_once('lib.php');
require_once('lib_organization.php');
require_once('communication_lib.php');
require_once('../lib.php');
require_once($CFG->libdir . '/logactivity_lib.php');

$candidateid = get_string('candidateid');
$organizationrole = get_string('role');
$organizationstatus = get_string('status');
$orgregistrationdate = get_string('registrationdate');
$organizationsize = get_string('organizationsize');
$organizationtype = get_string('organizationtype');
$industry = get_string('orgindustry');

$id = optional_param('id', '', PARAM_INT);

$marginright = 'style="margin-right:0.5em;"';
$textinput = 'style="float:left;margin-top:0.5em;"';
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

$required = '<div style="color:red;"> *';
$placeholder = 'Automated'; // for input textbox
$tdstyle = 'border: none;';
$tdstyle_rowspan = 'border: none';
$selectionwidth = 'width:150px;';

$qr = "Select * From {user} Where id = '" . $id . "' Order By id DESC";
$rs = $DB->get_record_sql($qr);

$userfullnameis .= $rs->firstname;
if(!empty($rs->middlename)){ $userfullnameis .= ' '.$rs->middlename; }
$userfullnameis .= ' '.$rs->lastname;
print_r('<h3 style="width:95%; margin: 0px auto;"> User Details - '.ucfirst($userfullnameis).'</h3>');

$communicationPreference = communicationPreference();
$bil = '1';
foreach ($communicationPreference as $cp) {
    //createinputcheck(type,id,name,value,userid,dbfield)
    $a2.=createinputcheck('checkbox', 'commpreference1', 'commpreference[]', $cp->id, $rs->id, $cp->id) . $cp->rules_text . '<br/>';
}

// Oranization ID value here
if($rs->suborgtype!=0){
    $suborgtypesql = "SELECT * FROM {organization_type} Where deletestatus='0' And id='" . $rs->suborgtype . "'";
    $data = $DB->get_record_sql($suborgtypesql);
    $suborgtypedata = $data->organizationid;
}else{ $suborgtypedata = 0; }

// SUB BUTTON HERE!!!!!!
// SEARCH, NEW, SAVE, RESET
/*switch ($whichbutton) {
    case get_string('search'):
        $getcid = required_param('candidateid', PARAM_ALPHANUMEXT);
        $getfirstname = required_param('firstname', PARAM_MULTILANG);
        $getlastname = required_param('lastname', PARAM_MULTILANG);
        $searchfield = "traineeid='" . $getcid . "' OR firstname LIKE '%" . $getfirstname . "'";
        $sqltext = "Select * From {user} Where $searchfield";
        $searchdb = $DB->get_record_sql($sqltext);

        $cidvalue = $searchdb->traineeid;
        $firstnamevalue = $searchdb->firstname;
        $mnamevalue = $searchdb->middlename;
        $lastnamevalue = $searchdb->lastname;
        $gendervalue = $searchdb->gender;
        $addressline1value = $searchdb->address;
        $addressline2value = $searchdb->address2;
        $addressline3value = $searchdb->address3;
        $zipvalue = $searchdb->zip;
        $cityvalue = $searchdb->city;
        $statevalue = $searchdb->state;
        $countryvalue = $searchdb->country;
        $highesteduvalue = $searchdb->highesteducation;
        $professvalue = $searchdb->professionalcert;
        $completiondatevalue = $searchdb->yearcomplete_edu;
        $noqvalue = $searchdb->nameofqualification;
        $collegevalue = $searchdb->college_edu;
        $majorvalue = $searchdb->major_edu;
        $dobvalue = date('d-m-Y', $searchdb->dob);
        $ycvalue = $searchdb->yearcomplete;
        $studstartdatevalue = date('d-m-Y', $searchdb->startdate_edu);
        $studcomdatevalue = date('d-m-Y', $searchdb->completion_edu);
        $phone1value = $searchdb->phone1;
        $emailvalue = $searchdb->email;
        $regdatevalue = date('d-m-Y', $searchdb->timecreated);
        $empstatusvalue = $searchdb->empstatus;
        $organizationidvalue = $suborgtypedata;
        $oldusernamevalue = '';
        $outstandingbalanceval = $outstandingbalance_finance;
        $enrolmentsourceval = '';
        $djorganizationvalue = '';
        $designationvalue = $searchdb->designation;
        $departmentvalue = $searchdb->department;
        break;
    case get_string('new'):
        include('script.php');
        $regdatevalue = $today; // time();
        if (empty($countryvalue)) {
            $countryvalue = 'AE';   // default
        }
        $cidvalue2=$cidvalue;
            
        break;
    case get_string('savebutton') || get_string('resetpword') || get_string('delete'):
        $newuserid = optional_param('newuserid', PARAM_ALPHANUMEXT);
        $cidvalue = optional_param('candidateid', PARAM_ALPHANUMEXT);
        $rolesvalue = optional_param('selectrolename', PARAM_INT);
        $titlevalue = optional_param('title', PARAM_INT);
        $firstnamevalue = optional_param('firstname', PARAM_MULTILANG);
        $mnamevalue = optional_param('middlename', PARAM_MULTILANG);
        $lastnamevalue = optional_param('lastname', PARAM_MULTILANG);
        $gendervalue = optional_param('gender', PARAM_INT);
        $dobvalue = optional_param('dobdatepicker', PARAM_ALPHANUMEXT);

        // Full address
        $addressline1value = optional_param('addressline1', PARAM_MULTILANG);
        $addressline2value = optional_param('addressline2', PARAM_MULTILANG);
        $addressline3value = optional_param('addressline3', PARAM_MULTILANG);
        $zipvalue = optional_param('zip', PARAM_INT);
        $cityvalue = optional_param('city', PARAM_MULTILANG);
        $statevalue = optional_param('statename', PARAM_MULTILANG);
        $countryvalue = optional_param('country', PARAM_ALPHA);

        // organization history
        $highesteduvalue = optional_param('highesteducation', PARAM_INT);
        $completiondatevalue = optional_param('completiondate', PARAM_ALPHANUMEXT);
        $professvalue = optional_param('professionalcert', PARAM_INT);
        $noqvalue = optional_param('nameofqualification', PARAM_ALPHANUMEXT);
        $collegevalue = optional_param('collegename', PARAM_MULTILANG);
        $majorvalue = optional_param('collegemajorname', PARAM_MULTILANG);
        $ycvalue = optional_param('yearcompleted', PARAM_INT);
        $studstartdatevalue = optional_param('studiesstartdate', PARAM_ALPHANUMEXT);
        $studcomdatevalue = optional_param('studiescompletiondate', PARAM_ALPHANUMEXT);

        $phone1value = optional_param('phone1', PARAM_ALPHANUMEXT);
        $emailvalue = optional_param('email', PARAM_MULTILANG);
        $regdatevalue = optional_param('registrationdate', PARAM_ALPHANUMEXT);
        $empstatusvalue = optional_param('empstatus', PARAM_INT);
        $organizationidvalue = optional_param('organizationid', PARAM_ALPHANUMEXT);
        $oldusernamevalue = optional_param('oldusername', PARAM_ALPHANUMEXT);
        $outstandingbalanceval = optional_param('outstandingbalance', PARAM_ALPHANUMEXT);
        $enrolmentsourceval = optional_param('enrolmentsource', PARAM_ALPHANUMEXT);
        $djorganizationvalue = optional_param('datejoinorganization', PARAM_ALPHANUMEXT);
        $designationvalue = optional_param('designation', PARAM_MULTILANG);
        $departmentvalue = optional_param('department', PARAM_MULTILANG);
        // $commpreference = required_param('commpreference', PARAM_ALPHANUMEXT);

        if($whichbutton ==get_string('resetpword')){
            //reset password
            $resetuser = new stdClass();
            $resetuser->id = $rs->id;
            $resetuser->password = md5(get_string('temporarypassword'));
            $resetpassword = $DB->update_record('user', $resetuser);  
        }else if($whichbutton ==get_string('delete')){ 
            // delete users only. 
            $deleteuser = new stdClass();
            $deleteuser->id = $rs->id;
            $deleteuser->username = $rs->email.'.'.time();
            $deleteuser->deleted = '1';
            $delete = $DB->update_record('user', $deleteuser); 
            
            // $sql=$DB->delete_records('user', array('id'=>$rs->id));
            //$link=$CFG->wwwroot."/organization/orgview.php?formtype=User&id=".$rs->id."&display=userdetails";
            //redirect($link);
            
            $link = $CFG->wwwroot . "/organization/orgview.php?formtype=" . $formtype;
            // redirect($link);
            die("<script>location.href = '" . $link . "'</script>");            
        }else{
            $commpreference = optional_param('commpreference', PARAM_ALPHANUMEXT);
            $lasttimecreated = strtotime('today midnight'.'+ 120 days - 1 minutes');
            $sql="Select * From {user} Where traineeid='".$cidvalue."' Order By id Desc";
           // $sql1="Select * From {user} Where id='".$rs->id."' Order By id Desc";
            // echo $DB->count_records_sql($sql);      
            
            if(empty($DB->count_records_sql($sql))){
                /*echo $data = $DB->get_record_sql($sql1); echo $newuserid = $data->id + 1;
                $forcepword = $DB->count_records_sql("Select id From {user_preferences} Where userid='".$newuserid."'");
                if(empty($forcepword)){
                    insertpreference_user($newuserid);
                } */          
                
                /*// Added new registration here
                $saverecords = insertnewusers_db($lasttimecreated, $cidvalue, $titlevalue, $firstnamevalue, $mnamevalue, $lastnamevalue, $gendervalue, $dobvalue, $addressline1value, $addressline2value, $addressline3value, $zipvalue, $cityvalue, $statevalue, $countryvalue, $highesteduvalue, $completiondatevalue, $professvalue, $noqvalue, $collegevalue, $majorvalue, $ycvalue, $studstartdatevalue, $studcomdatevalue, $phone1value, $emailvalue, $empstatusvalue, $designationvalue, $departmentvalue);
            }else{
                // Update records    
                $saverecords = updateuserrecords($rs->id, $titlevalue, $firstnamevalue, $mnamevalue, $lastnamevalue, $gendervalue, $dobvalue, $addressline1value, $addressline2value, $addressline3value, $zipvalue, $cityvalue, $statevalue, $countryvalue, $highesteduvalue, $completiondatevalue, $professvalue, $noqvalue, $collegevalue, $majorvalue, $ycvalue, $studstartdatevalue, $studcomdatevalue, $phone1value, $emailvalue, $empstatusvalue, $designationvalue, $departmentvalue);
            }
                
            
            for ($i = 0; $i < sizeof($commpreference); $i++) {
                if(empty(countcommunicationpreference($commpreference[$i], $id))){
                    // insert to communication_users
                    savecommunicationusers($commpreference[$i], $id);
                }else{
                    if(empty($DB->count_records_sql($sql))){
                        echo  'update only';
                        $commpreferenceid = getcommpreference_users($commpreference[$i], $id)->id;
                        $commpreference_cpid = getcommpreference_users($commpreference[$i], $id)->cpid;

                        $detailscommpreference_users = getdetailscommpreference_users($id, $commpreference_cpid->status);
                        foreach($detailscommpreference_users as $details){
                            echo $commpreference_cpid.$details->cpid; echo '<br/>';
                            if(getcommpreference_users($commpreference[$i], $id)->status==$details->status){
                                updateuserscommunication($commpreferenceid, $details->status);
                            }else{ 
                                updateuserscommunication($commpreferenceid, 0);
                            }
                        }
                    }
                }                
            }            
            */
            //roles
            $getroles = buildroleslist();
            foreach ($getroles as $roles) {
                if ($roles->id == $rolesvalue) {
                    $rolesid.=$roles->id;
                    $rolename.=$roles->name;
                }
            }
            /*
            $redirecturl = $CFG->wwwroot . '/organization/orgview.php?formtype='.$formtype;
            die("<script>location.href = '" . $redirecturl . "'</script>");            
        }
        break;
    default:*/
        $cidvalue = $rs->traineeid;
        $titlevalue = $rs->title;
        $firstnamevalue = $rs->firstname;
        $mnamevalue = $rs->middlename;
        $lastnamevalue = $rs->lastname;
        $gendervalue = $rs->gender;
        $addressline1value = $rs->address;
        $addressline2value = $rs->address2;
        $addressline3value = $rs->address3;
        $zipvalue = $rs->zip;
        $cityvalue = $rs->city;
        $statevalue = $rs->state;
        $countryvalue = $rs->country;
        $highesteduvalue = $rs->highesteducation;
        $professvalue = $rs->professionalcert;
        $completiondatevalue = $rs->yearcomplete_edu;
        $noqvalue = $rs->nameofqualification;
        $collegevalue = $rs->college_edu;
        $majorvalue = $rs->major_edu;
        $dobvalue = date('d-m-Y', $rs->dob);
        $ycvalue = $rs->yearcomplete;
        $studstartdatevalue = date('d-m-Y', $rs->startdate_edu);
        $studcomdatevalue = date('d-m-Y', $rs->completion_edu);
        $phone1value = $rs->phone1;
        $emailvalue = $rs->email;
        $regdatevalue = date('d-m-Y', $rs->timecreated);
        $empstatusvalue = $rs->empstatus;
        $organizationidvalue = $suborgtypedata;
        $oldusernamevalue = '';
        $outstandingbalanceval = $outstandingbalance_finance;
        $enrolmentsourceval = '';
        $djorganizationvalue = '';
        $designationvalue = $rs->designation;
        $departmentvalue = $rs->department;
       //// break;
//}

// display table here!!disabled="disabled"
$cid = createinputtext('text', 'candidateid', 'candidateid', $cidvalue, '', '', 'required disabled="disabled"');
$cid_new = createinputtext('text', 'candidateid_new', 'candidateid_new', $cidvalue2);
$firstname = createinputtext('text', 'firstnameid', 'firstname', $firstnamevalue, '', '', 'required disabled="disabled"');
$middlename = createinputtext('text', 'middlenameid', 'middlename', $mnamevalue, '', '', 'disabled="disabled"');
$lastname = createinputtext('text', 'lastnameid', 'lastname', $lastnamevalue, '', '', 'disabled="disabled"');
$addressline1 = createinputtext('text', 'addressline1', 'addressline1', $addressline1value, '', '', 'disabled="disabled"');
$addressline2 = createinputtext('text', 'addressline2', 'addressline2', $addressline2value, '', '', 'disabled="disabled"');
$addressline3 = createinputtext('text', 'addressline3', 'addressline3', $addressline3value, '', '', 'disabled="disabled"');
$city = createinputtext('text', 'city', 'city', $cityvalue, '', '', 'disabled="disabled"');
$zip = createinputtext('text', 'zip', 'zip', $zipvalue, '', '', 'disabled="disabled"');
$title = createdselectedoption(buildSelectionTitle(), 'title', $selectionwidth, $titlevalue, '', '', 'disabled="disabled"');
$gender = createdselectedoption(buildSelectionGender(), 'gender', $selectionwidth, $gendervalue, '', '', 'disabled="disabled"');
$state = createinputtext('text', 'stateid', 'statename', $statevalue, '', '', 'disabled="disabled"');
$college = createinputtext('text', 'collegeid', 'collegename', $collegevalue, '', '', 'disabled="disabled"');
$collegemajor = createinputtext('text', 'collegemajorid', 'collegemajorname', $majorvalue, '', '', 'disabled="disabled"');
$country = selectcountry('country', $countryvalue);
$dob = createinputtext('text', 'dobdatepicker', 'dobdatepicker', $dobvalue, '', '', 'disabled="disabled"');
$nameofqualification = createinputtext('text', 'nameofqualification', 'nameofqualification', $noqvalue, '', '', 'disabled="disabled"');
$yearcompleted = createinputtext('text', 'yearcompleted', 'yearcompleted', $ycvalue, '', '', 'disabled="disabled"');
$studstartdate = createinputtext('text', 'studiesstartdate', 'studiesstartdate', $studstartdatevalue, '', '', 'disabled="disabled"');
$studcompletiondate = createinputtext('text', 'studiescompletiondate', 'studiescompletiondate', $studcomdatevalue, '', '', 'disabled="disabled"');
$daytimetel = createinputtext('text', 'phone1', 'phone1', $phone1value, '', '', 'disabled="disabled"');
$email = createinputtext('text', 'email', 'email', $emailvalue, '', '', 'disabled="disabled"');
$registerdate = createinputtext('text', 'registrationdate', 'registrationdate', $regdatevalue, '', '', 'disabled="disabled"');
$highesteducation = createdselectedoption(buildhighestedu(), 'highesteducation', $selectionwidth, $highesteduvalue);
$completiondate = createinputtext('text', 'completiondate', 'completiondate', $completiondatevalue, '', '', 'disabled="disabled"');
$empstatus = createdselectedoption(buildSelectionEmpStatus(), 'empstatus', $selectionwidth, $empstatusvalue);
$organizationid = createinputtext('text', 'organizationid', 'organizationid', $organizationidvalue, $placeholder, '', 'disabled="disabled"');
$oldusername = createinputtext('text', 'oldusername', 'oldusername', $oldusernamevalue, '', '', 'disabled="disabled"');
$osbalance = createinputtext('text', 'outstandingbalance', 'outstandingbalance', $outstandingbalanceval, '', '', 'disabled="disabled"');
$enrolmentsource = createinputtext('text', 'enrolmentsource', 'enrolmentsource', $enrolmentsourceval, '', '', 'disabled="disabled"');
$datejoinorganization = createinputtext('text', 'datejoinorganization', 'datejoinorganization', $djorganizationvalue, '', '', 'disabled="disabled"');
$designation = createinputtext('text', 'designation', 'designation', $designationvalue, '', '', 'disabled="disabled"');
$department = createinputtext('text', 'department', 'department', $departmentvalue, '', '', 'disabled="disabled"');
$professionalcert = createdselectedoption(buildprofessionalcert(), 'professionalcert', $selectionwidth, $professvalue);

echo '<table class="n" id="n" style="width:95%;margin-left:auto;margin-right:auto;border: 3px solid #ffffff;margin-top:1em;">';
print_r($tr);
print_r(buildTdTable($tdstyle, $required . $organizationrole . '</div>' . selectuserrole('selectrolename', 'selectrolename', $rolesid)));
print_r(buildTdTable($tdstyle, $required . get_string('address1') . '</div>' . $addressline1));
print_r(buildTdTable($tdstyle, get_string('highesteducation') . '<br/>' . $highesteducation));
print_r($trclose);       // </td></tr> 

print_r($tr);
print_r(buildTdTable($tdstyle, $required . $candidateid . '</div>' . $cid));
print_r(buildTdTable($tdstyle, get_string('address2') . '<br/>' . $addressline2));
print_r(buildTdTable($tdstyle, get_string('completiondate') . '<br/>' . $completiondate));
print_r($trclose);       // </td></tr> 

print_r($tr);
print_r(buildTdTable($tdstyle, $required . get_string('title') . '</div>' . $title));
print_r(buildTdTable($tdstyle, get_string('address3') . '<br/>' . $addressline3));
print_r(buildTdTable($tdstyle, get_string('professionalcert') . '<br/>' . $professionalcert));
print_r($trclose);       // </td></tr> 

print_r($tr);
print_r(buildTdTable($tdstyle, $required . get_string('firstname') . '</div>' . $firstname));
print_r(buildTdTable($tdstyle, $required . get_string('city') . '</div>' . $city));
print_r(buildTdTable($tdstyle, get_string('nameofqualification') . '<br/>' . $nameofqualification));
print_r($trclose);       // </td></tr> 

print_r($tr);                             // <tr><td>
print_r(buildTdTable($tdstyle, get_string('middlename') . '<br/>' . $middlename));
print_r(buildTdTable($tdstyle, get_string('zip') . '<br/>' . $zip));
print_r(buildTdTable($tdstyle, get_string('yearcomplete') . '<br/>' . $yearcompleted));
print_r($trclose);

print_r($tr);                             // <tr><td>
print_r(buildTdTable($tdstyle, $required . get_string('lastname') . '</div>' . $lastname));
print_r(buildTdTable($tdstyle, get_string('state') . '<br/>' . $state));
print_r(buildTdTable($tdstyle, get_string('college') . '<br/>' . $college));
print_r($trclose);

print_r($tr);                             // <tr><td>
print_r(buildTdTable($tdstyle, $required . get_string('gender') . '</div>' . $gender));
print_r(buildTdTable($tdstyle, $required . get_string('country') . '</div>' . $country));
print_r(buildTdTable($tdstyle, get_string('collegemajor') . '<br/>' . $collegemajor));
print_r($trclose);

print_r($tr);                             // <tr><td>
print_r(buildTdTable($tdstyle, $required . get_string('dateofbirth') . '</div>' . $dob));
print_r(buildTdTable($tdstyle, $required . get_string('daytimetel') . '</div>' . '+' . getUserCountrycode($countryvalue) . ' ' . $daytimetel));
print_r(buildTdTable($tdstyle, get_string('studiesstartdate') . '<br/>' . $studstartdate));
print_r($trclose);

print_r($tr);                             // <tr><td>
print_r(buildTdTable($tdstyle, $required . $organizationstatus . '</div>' . orgstatus(0)));
print_r(buildTdTable($tdstyle, $required . get_string('email') . '</div>' . $email));
print_r(buildTdTable($tdstyle, get_string('studiescompdate') . '<br/>' . $studcompletiondate));
print_r($trclose);

print_r($tr);                             // <tr><td>
print_r(buildTdTable($tdstyle, $orgregistrationdate . '<br/>' . $registerdate));
print_r(buildTdTable($tdstyle, get_string('empstatus') . '<br/>' . $empstatus));
print_r(buildTdTable($tdstyle, get_string('datejoinorganization') . '<br/>' . $datejoinorganization));
print_r($trclose);

print_r($tr);                             // <tr><td>
print_r(buildTdTable($tdstyle, get_string('oldusername') . '<br/>' . $oldusername));
print_r(buildTdTable($tdstyle, get_string('organizationid') . '<br/>' . $organizationid));
print_r(buildTdTableRowspan($tdstyle, get_string('communicationpreferences') . '<div style="padding-top:0.5em;"></div>' . $a2));
print_r($trclose);

print_r($tr);                             // <tr><td>
print_r(buildTdTable($tdstyle, get_string('outstandingbalance') . '<br/>' . $osbalance));
print_r(buildTdTable($tdstyle, get_string('designation') . '<br/>' . $designation));
print_r('');
print_r($trclose);

print_r($tr);                             // <tr><td>
print_r(buildTdTable($tdstyle, get_string('enrolmentsource') . '<br/>' . $enrolmentsource));
print_r(buildTdTable($tdstyle, get_string('department') . '<br/>' . $department));
print_r('');
print_r($trclose);

echo '</table>';