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
require_once($CFG->libdir . '/datalib.php');
require_once('lib.php');

$id = optional_param('id', '', PARAM_INT);

$organizationid = get_string('organizationid');
$organizationrole = get_string('role') . ' (Tick where relevant)';
$organizationstatus = get_string('status');
$orgregistrationdate = get_string('registrationdate');
$organizationsize = get_string('organizationsize');
$organizationtype = get_string('organizationtype');
$display = required_param('display', PARAM_MULTILANG);
$industry = get_string('orgindustry');
$required = '<div style="color:red;"> *';

$qr = "Select * From {organization_type} Where id = '" . $id . "' Order By id DESC";
$rs = $DB->get_record_sql($qr);

$sql2 = "Select id, name From {role} Where (id='10' Or id='12' Or id='13') Order By name Asc";
$sqlrole = $DB->get_recordset_sql($sql2);

$sql = "SELECT id, groupofinstitution, name, organizationid FROM {organization_type} WHERE id = '" . getOrganizationId($rs->id)->groupofinstitution . "'";
$data = $DB->get_record_sql($sql);
$Hqorgid = $data->organizationid;

print_r('<h3 style="width:95%; margin: 0px auto;">'.$rs->name.'</h3>');
$marginright = 'style="margin-right:0.5em;"';
$textinput = 'style="float:left;margin-top:0.5em;"';
$textinput1 = 'style="float:left;margin-top:0.5em; width:80%;"';

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

//value textbox here
$organizationidvalue = 'value="' . $rs->organizationid . '"';
$addressline1value = 'value="' . $rs->address . '"';
$addressline2value = 'value="' . $rs->address_line2 . '"';
$addressline3value = 'value="' . $rs->address_line3 . '"';
$websitevalue = 'value="' . $rs->url . '"';
$orgnamevalue = 'value="' . $rs->name . '"';
$orgemailvalue = 'value="' . $rs->email . '"';
$orgcityvalue = 'value="' . $rs->city . '"';
$orgregistrationdatevalue = 'value="' . date('d-m-Y', $rs->timecreated) . '"';
$orgzipvalue = 'value="' . $rs->zip . '"';
$ipaddressvalue = 'value="' . $rs->ipaddress . '"';
$orgstatevalue = 'value="' . $rs->state . '"';
$orgcountryvalue = 'value="' . getCountryName($rs->country) . '"';
$hqorganizationidvalue = 'value="' . $Hqorgid . '"';
$worktelvalue = 'value="' . $rs->telephone . '"';
$workfaxvalue = 'value="' . $rs->faxs . '"';
$totaluserssub = totalUsersSubscribeByOrg($id);
$totalcoursesub = totalCourseSubscribeByOrg(32, $id);

if (!empty($rs->path_logo)) {
    $imglink = $CFG->wwwroot . '/organization/' . $rs->path_logo;
    $orglogo = '<img src="' . $imglink . '" alt="' . $imglink . '" title="' . $imglink . '" width="200" style="margin-top:0.8em;">';
    $logoname = 'Change Logo';
} else {
    $logoname = 'Upload Logo';
}

if ($rs->groupofinstitution == '0') {
    $oroles = $rs->organizationrole;
} else {
    $oroles = $rs->organizationrole;
}
//$poplinklogo = $CFG->wwwroot . '/organization/uploadlogo.php?orgid=' . $id;
//$onclicklogo = "window.open('" . $poplinklogo . "', 'Window2', 'width=880,height=630, scrollbars=1')";
//$orglogoupload = '<input type="button" name="uploadnewlogo" id="uploadnewlogo" value="' . $logoname . '" onclick="' . $onclicklogo . '" style="margin-top:0.8em;margin-right:0.5em;line-height:1em;height:28px;" />';
// END 

// Input text box here!!
$orgid = '<input ' . $textinput . ' type="text" id="organizationid" name="organizationid" ' . $organizationidvalue . ' disabled="disabled"  />';
$addressline1 = '<input ' . $textinput1 . ' type="text" name="addressline1" ' . $addressline1value . ' disabled="disabled" />';
$website = '<input ' . $textinput1 . ' type="text" name="website" ' . $websitevalue . ' disabled="disabled" />';
$organizationname = '<input ' . $textinput . ' type="text" name="organizationname" ' . $orgnamevalue . ' disabled="disabled" />';
$addressline2 = '<input ' . $textinput1 . ' type="text" name="addressline2" ' . $addressline2value . ' disabled="disabled" />';
$email = '<input ' . $textinput1 . ' type="text" name="orgemail" ' . $orgemailvalue . ' disabled="disabled" />';
$addressline3 = '<input ' . $textinput1 . ' type="text" name="addressline3" ' . $addressline3value . ' disabled="disabled" />';
$city = '<input ' . $textinput . ' type="text" name="orgcity" ' . $orgcityvalue . ' disabled="disabled" />';
$registerdate = '<input ' . $textinput . ' type="text" name="orgregistrationdate" id="datepicker" ' . $orgregistrationdatevalue . ' disabled="disabled" />';
$orgzip = '<input ' . $textinput . ' type="text" name="orgzip" ' . $orgzipvalue . ' disabled="disabled" />';
$ipaddress = '<input ' . $textinput . ' type="text" name="ipaddress" ' . $ipaddressvalue . ' disabled="disabled" />';
$orgstate = '<input ' . $textinput . ' type="text" name="orgstate" ' . $orgstatevalue . ' disabled="disabled" />';
$orgcountry = '<input ' . $textinput . ' type="text" name="orgcountry" ' . $orgcountryvalue . ' disabled="disabled" />';
$hqorganizationid = '<input ' . $textinput . ' type="text" name="hqorganizationid" ' . $hqorganizationidvalue . ' disabled="disabled" />';
$worktel = '<input ' . $textinput . ' type="text" name="worktel" ' . $worktelvalue . ' disabled="disabled" />';
$workfax = '<input ' . $textinput . ' type="text" name="workfax" ' . $workfaxvalue . ' disabled="disabled" />';
//END
$poplink1 = $CFG->wwwroot . '/organization/detailusersubscribed.php?orgid=' . $id;
$poplink2 = $CFG->wwwroot . '/organization/detailcoursesubscribed.php?orgid=' . $id;
$poplink3 = $CFG->wwwroot . '/organization/detailpassrate.php?orgid=' . $id;
$totalUserSub = "window.open('" . $poplink1 . "', 'Window2', 'width=880,height=630, scrollbars=1')";
$totalCourseSub = "window.open('" . $poplink2 . "', 'Window2', 'width=880,height=630, scrollbars=1')";
$totalPassrate = "window.open('" . $poplink3 . "', 'Window2', 'width=880,height=630, scrollbars=1')";

$textinput2 = 'style="float:left;margin-top:0.5em;margin-left:0.3em;cursor: pointer;"';
$iconpopup1 = '<a ' . $textinput2 . ' onclick="' . $totalUserSub . '"><image src="' . $CFG->wwwroot . '/ui/images/Info_icon.png" name="" width="18px"></a>';
$iconpopup2 = '<a ' . $textinput2 . ' onclick="' . $totalCourseSub . '"><image src="' . $CFG->wwwroot . '/ui/images/Info_icon.png" name="" width="18px"></a>';
$iconpopup3 = '<a ' . $textinput2 . ' onclick="' . $totalPassrate . '"><image src="' . $CFG->wwwroot . '/ui/images/Info_icon.png" name="" width="18px"></a>';

// print table
echo '<table class="n" id="n" style="width:95%;margin-left:auto;margin-right:auto;border: 3px solid #ffffff;margin-top:1em;">';
print_r($tr . $td);                 // <tr><td>
print_r($required . $organizationid . '</div>' . $orgid);                // Organization ID
print_r($tdclose . $td);
print_r($required . get_string('address1') . '</div>' . $addressline1);  // address line 1
print_r($tdclose . $td);
print_r(get_string('website') . '<br/>' . $website);        // website
print_r($tdclose . $trclose);       // </td></tr>

print_r($tr . $td);                 // <tr><td>
print_r($required . get_string('name') . '</div>' . $organizationname);  // Organization Name
print_r($tdclose . $td);
print_r(get_string('address2') . '<br/>' . $addressline2);  // Address Line 2
print_r($tdclose . $td);
print_r(get_string('email') . '<br/>' . $email);            // Email
print_r($tdclose . $trclose);       // </td></tr>    

print_r($tr . $td);   // <tr><td>
print_r($required . $organizationrole . '</div>');                                 // Organization Role
echo $div . $divclose;

foreach ($sqlrole as $role) {
    $roles = '<input type="checkbox" name="role" value="' . $role->id . '"';
    if ($role->id == $rs->org_type) {
        $roles.= ' checked = "checked"';
    }
    $roles.= ' disabled="disabled">';
    $roles.=$role->name . '<br/>';
    print_r($roles);
}

print_r($tdclose . $td);
print_r(get_string('address3') . '<br/>' . $addressline3);                // Address Line 3 $totaluserssub
print_r($tdclose . $td);
print_r(get_string('totalusersubscribed'));     // total user subscribed
echo '<br/><input ' . $textinput . ' type="text" name="totalusersubscribed" value="' . $totaluserssub . '" disabled="disabled" /> &nbsp;' . $iconpopup1;
print_r($tdclose . $trclose);                   // </td></tr>     

print_r($tr . $td);                             // <tr><td>
print_r($required . $organizationstatus . '</div>');                   // Organization Status
print_r($div . $divclose);
print_r(orgstatus_print($rs->status));
print_r($tdclose . $td);
print_r($required . get_string('city') . '</div>');                    // city town
echo $city;
print_r($tdclose . $td);
print_r(get_string('totalcoursesubscribed'));
echo '<br/><div class="groupbutton"><input ' . $textinput . ' type="text" name="totalcoursesubscribed" value="' . $totalcoursesub . '" disabled="disabled" /> &nbsp;' . $iconpopup2 . '</div>';
print_r($tdclose . $trclose);                   // </td></tr>  

print_r($tr . $td);                             // <tr><td>
print_r($required . $orgregistrationdate . '</div>');                  // Registration date
echo $registerdate;
print_r($tdclose . $td);
print_r(get_string('zip'));                     // Zip
echo '<br/>' . $orgzip;
print_r($tdclose . $td);
print_r(get_string('passrate'));                    // passrate here
echo '<br/><input ' . $textinput . ' type="text" name="passrate" value="' . passrateorganization($id) . '" disabled="disabled" /> &nbsp;' . $iconpopup3;
print_r($tdclose . $trclose);                   // </td></tr>   

print_r($tr . $td);                             // <tr><td>
print_r(get_string('ip_address'));              // IP Address
echo '<br/>' . $ipaddress;
print_r($tdclose . $td);
print_r(get_string('state'));                   // State
echo '<br/>' . $orgstate;
print_r($tdclose . $td);
print_r($required . get_string('organizationrole') . '</div>');        // HQ Org Role // HQ or Branches
print_r($div . $divclose);
echo getOrganizationRoles_print('organizationrole', $oroles);
print_r($tdclose . $trclose);                   // </td></tr>   

print_r($tr . $td);                             // <tr><td>
print_r($organizationsize);                     // Organization Size
print_r($div . $divclose);
print_r(organizationdatabase_print(1, $rs->organizationsize, 'orgsize'));
print_r($tdclose . $td);
print_r($required . get_string('country') . '</div>');                 // country
echo selectcountry_print('country', $rs->country);
print_r($tdclose . $td);
print_r($required . get_string('hqorganizationid') . '</div>');
print_r($hqorganizationid);
print_r($tdclose . $trclose);                   // </td></tr>    

print_r($tr . $td);                             // <tr><td>
print_r($organizationtype);                     // Organization Type
print_r($div . $divclose);
print_r(organizationdatabase_print(2, $rs->organizationtype, 'orgtype'));
print_r($tdclose . $td);
print_r(get_string('worktel'));                 // Work tel
echo '<br/>';
print_r('<div style="float:left;margin:0.5em 0.3em 0 0;"> +' . getUserCountrycode($rs->country) . '</div> ' . $worktel);
print_r($tdclose . '<td rowspan="3">');
print_r($required . get_string('logo') . '</div>');                    // Logo
print_r($orglogo . '<br/>');
print_r($orglogoupload);
print_r($tdclose . $trclose);                   // </td></tr> 

print_r($tr . '<td valign="top">');                             // <tr><td>
print_r($industry);                             // Organization Industry
print_r($div . $divclose);
print_r(organizationdatabase_print(3, $rs->organizationindustry, 'orgindustry'));
print_r($tdclose . $td);
print_r(get_string('workfax'));                 // Work Fax
echo '<br/>';
print_r('<div style="float:left;margin:0.5em 0.3em 0 0;"> +' . getUserCountrycode($rs->country) . '</div> ' . $workfax);
print_r($tdclose . $td);
print_r($tdclose . $trclose);                   // </td></tr>     
echo '</table>';
