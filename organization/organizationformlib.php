<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$organizationid = get_string('organizationid');
$organizationrole = get_string('role') . ' (Tick where relevant)';
$organizationstatus = get_string('status');
$orgregistrationdate = get_string('registrationdate');
$organizationsize = get_string('organizationsize');
$organizationtype = get_string('organizationtype');
$display = required_param('display', PARAM_MULTILANG);
$industry = get_string('orgindustry');
$required = '<div style="color:red;"> *';
$passgrade = '60';

echo '<form id="orgform" name="orgform">';
echo '<input type="hidden" name="id" id="id" value="' . $id . '">';
echo '<input type="hidden" name="formtype" id="formtype" value="' . $formtype . '">';
echo '<input type="hidden" name="display" id="display" value="' . $formdisplay . '">';

// display button here!! line-height:1em;height:28px;
print_r($divopen);
//if($whichbutton){}

if ($whichbutton == get_string('search')) {
    $a = $actionbuttoncolor;
} else {
    $a = $defaultbuttoncolor;
}
if ($whichbutton == get_string('new')) {
    $b = $actionbuttoncolor;
} else {
    $b = $defaultbuttoncolor;
}
if ($whichbutton == get_string('savebutton')) {
    $c = $actionbuttoncolor;
} else {
    $c = $defaultbuttoncolor;
}
if ($whichbutton == get_string('print')) {
    $d = $actionbuttoncolor;
} else {
    $d = $defaultbuttoncolor;
}
if ($whichbutton == get_string('delete')) {
    $e = $actionbuttoncolor;
} else {
    $e = $defaultbuttoncolor;
}

$printdetails = $CFG->wwwroot . '/organization/organizationdetails_print.php?id='.$id.'&display='.$display;
//$actiontoprint = "Onclick=this.form.action='" . $printdetails . "';target='_blank'";
$bulkupload_link = $CFG->wwwroot.'/admin/uploaduser.php';
$actiontoprint = "window.open('" . $printdetails . "','_blank')";
$actionprint = "window.open('" . $bulkupload_link . "','_blank')";
echo createinputtext('submit', $a, 'whichbutton', get_string('search'), '', 'margin-right:0.5em;line-height:1em;height:28px;');
echo createinputtext('submit', $b, 'whichbutton', get_string('new'), '', 'margin-right:0.5em;line-height:1em;height:28px;');
echo createinputtext('submit', $c, 'whichbutton', get_string('savebutton'), '', 'margin-right:0.5em;line-height:1em;height:28px;'); 
//echo createinputtext_print('submit', $d, 'whichbutton', get_string('print'), 'Click to print', $actiontoprint. ' style="margin-right:0.5em;line-height:1em;height:28px;"');

echo createinputtext('button', $e, 'whichbutton', get_string('print'), '', 'margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $actiontoprint . '"');
echo createinputtext('submit', $e, 'whichbutton', get_string('delete'), '', 'margin-right:0.5em;line-height:1em;height:28px;');
echo createinputtext('button', $e, 'whichbutton', get_string('bulkenrolment'), '', 'margin-right:0.5em;line-height:1em;height:28px;', 'Onclick="' . $actionprint . '"');
print_r($divclose);

if ($rs->groupofinstitution == '0') {
    $oroles = $rs->organizationrole;
} else {
    $oroles = $rs->organizationrole;
}        // Org roles
//
$sql = "SELECT id, groupofinstitution, name, organizationid FROM {organization_type} WHERE id = '" . getOrganizationId($rs->id)->groupofinstitution . "'";
$data = $DB->get_record_sql($sql);
$Hqorgid = $data->organizationid;
$newlogoid= listOrganization()->id+1;

switch ($whichbutton) {
    case get_string('search'):
        $getcid = required_param('organizationid', PARAM_ALPHANUMEXT);
        $organizationname = required_param('organizationname', PARAM_MULTILANG);
        $orgrole = required_param('role', PARAM_ALPHANUMEXT);
        $orgstatus = required_param('orgstatus', PARAM_INT);
        $orgregdate = required_param('orgregistrationdate', PARAM_MULTILANG);
        $ipaddress = required_param('ipaddress', PARAM_MULTILANG);
        $orgsize = required_param('orgsize', PARAM_INT);
        $orgtype = required_param('orgtype', PARAM_INT);
        $orgindustry = required_param('orgindustry', PARAM_INT);
        $addressline1 = required_param('addressline1', PARAM_MULTILANG);
        $addressline2 = required_param('addressline2', PARAM_MULTILANG);
        $addressline3 = required_param('addressline3', PARAM_MULTILANG);
        $orgcity = required_param('orgcity', PARAM_MULTILANG);
        $orgzip = required_param('orgzip', PARAM_INT);
        $orgstate = required_param('orgstate', PARAM_MULTILANG);
        $orgcountry = required_param('country', PARAM_ALPHANUMEXT);
        $website = required_param('website', PARAM_MULTILANG);
        $wphone = required_param('worktel', PARAM_INT);
        $fphone = required_param('workfax', PARAM_INT);
        $email = required_param('orgemail', PARAM_MULTILANG);

        $organizationidvalue = 'value="' . $getcid . '"';
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
        break;
    case get_string('new'):
        $organizationidvalue = 'value="' . generateOrganizationId('AE') . '"';

        // Logo here!
        $poplinklogo = $CFG->wwwroot . '/organization/uploadlogo.php?orgid=' . $newlogoid.'&code=1';      
        $onclicklogo = "window.open('" . $poplinklogo . "', 'Window2', 'width=880,height=630, scrollbars=1')";
        $orglogo = '<input type="button" name="uploadnewlogo" id="uploadnewlogo" value="Upload Logo" onclick="' . $onclicklogo . '" style="margin-top:0.8em;margin-right:0.5em;line-height:1em;height:28px;" />';
        break;
    case get_string('delete'):
        // delete org only. 
        $sql = $DB->delete_records('organization_type', array('id' => $rs->id));
        $link = $CFG->wwwroot . "/organization/orgview.php?formtype=" . $formtype;
        // redirect($link);
        die("<script>location.href = '" . $link . "'</script>");
        break;
    case get_string('savebutton'):
        $getcid = required_param('organizationid', PARAM_ALPHANUMEXT);
        $organizationname = required_param('organizationname', PARAM_MULTILANG);
        $orgrole = required_param('role', PARAM_ALPHANUMEXT);
        $orgstatus = required_param('orgstatus', PARAM_INT);
        $orgregdate = required_param('orgregistrationdate', PARAM_MULTILANG);
        $ipaddress = required_param('ipaddress', PARAM_MULTILANG);
        $orgsize = required_param('orgsize', PARAM_INT);
        $orgtype = required_param('orgtype', PARAM_INT);
        $orgindustry = required_param('orgindustry', PARAM_INT);
        $addressline1 = required_param('addressline1', PARAM_MULTILANG);
        $addressline2 = required_param('addressline2', PARAM_MULTILANG);
        $addressline3 = required_param('addressline3', PARAM_MULTILANG);
        $orgcity = required_param('orgcity', PARAM_MULTILANG);
        $orgzip = required_param('orgzip', PARAM_INT);
        $orgstate = required_param('orgstate', PARAM_MULTILANG);
        $orgcountry = required_param('country', PARAM_ALPHANUMEXT);
        $website = required_param('website', PARAM_MULTILANG);
        $wphone = required_param('worktel', PARAM_INT);
        $fphone = required_param('workfax', PARAM_INT);
        $email = required_param('orgemail', PARAM_MULTILANG);
        $hqorganizationid = required_param('hqorganizationid', PARAM_MULTILANG);
        $selectorganizationrole = required_param('organizationrole', PARAM_MULTILANG);

        //roles
        $getroles = buildroleslist();
        foreach ($getroles as $roles) {
            if ($roles->id == $orgrole) {
                $rolesid.=$roles->id;
                $rolename.=$roles->name;
            }
        }
        //regdate
        $regdate = strtotime($orgregdate);
        // organization ID in this table is ID.
        $searchsql = "Select COUNT(DISTINCT id) From {organization_type} Where organizationid='" . $getcid . "'";
        $scount = $DB->count_records_sql($searchsql);

        $searchsql = "Select id, groupofinstitution From {organization_type} Where organizationid='" . $hqorganizationid . "'";
        $q = $DB->get_record_sql($searchsql);
        if($selectorganizationrole==1){
            $gethqorganizationid = $q->id;
        }
        
        if (empty($scount)) { $getid = $newlogoid; }else{ $getid = $id; }
        
        $sql = "Select * From {organization_logo} Where organizationid='" . $getid . "'";
        $data = $DB->get_record_sql($sql);        
        if (empty($scount)) {
            $saverecords = insertorgrecords($selectorganizationrole, $gethqorganizationid, $getcid, $organizationname, $orgrole, $rolename, $orgstatus, $regdate, $ipaddress, $orgsize, $orgtype, $orgindustry, $addressline1, $addressline2, $addressline3, $orgcity, $orgzip, $orgstate, $orgcountry, $website, $wphone, $fphone, $email);

            if(!empty($data->logo)){
            $upduser = new stdClass();
            $upduser->id = $getid;
            $upduser->groupofinstitution = $q->id;
            $upduser->logo = $data->logo;
            $upduser->path_logo = $data->path_logo;
            $saverecord2 = $DB->update_record('organization_type', $upduser);
            }
            $getid = $newlogoid;
        } else {
           $saverecords = updateorgrecords($getid, $selectorganizationrole, $gethqorganizationid, $getcid, $organizationname, $orgrole, $rolename, $orgstatus, $regdate, $ipaddress, $orgsize, $orgtype, $orgindustry, $addressline1, $addressline2, $addressline3, $orgcity, $orgzip, $orgstate, $orgcountry, $website, $wphone, $fphone, $email);

            if(!empty($data->logo)){
            $upduser = new stdClass();
            $upduser->id = $getid;
            $upduser->groupofinstitution = $q->id;
            $upduser->logo = $data->logo;
            $upduser->path_logo = $data->path_logo;
            $saverecord2 = $DB->update_record('organization_type', $upduser);
            }
            $getid = $id;
        }
        // $neworgid
        echo $link = $CFG->wwwroot . "/organization/orgview.php?formtype=" . $formtype . "&id=" . $getid . "&display=" . $display;
        die("<script>location.href = '" . $link . "'</script>");
        break;
    default:
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
        }else{ $logoname = 'Upload Logo';} 
       
        if($whichbutton == get_string('new')){  $logoid = $newlogoid; }else{ $logoid = $id;}
        $poplinklogo = $CFG->wwwroot . '/organization/uploadlogo.php?orgid=' . $logoid.'&code=2';
        $onclicklogo = "window.open('" . $poplinklogo . "', 'Window2', 'width=880,height=630, scrollbars=1')";
        $orglogoupload = '<input type="button" name="uploadnewlogo" id="uploadnewlogo" value="'.$logoname.'" onclick="' . $onclicklogo . '" style="margin-top:0.8em;margin-right:0.5em;line-height:1em;height:28px;" />';

        break;
}

// display table here!!  
$orgid = '<input ' . $textinput . ' type="text" id="organizationid" name="organizationid" ' . $organizationidvalue .'  />';
$addressline1 = '<input ' . $textinput . ' type="text" name="addressline1" ' . $addressline1value . $requiredfield.' />';
$website = '<input ' . $textinput . ' type="text" name="website" ' . $websitevalue . ' />';
$organizationname = '<input ' . $textinput . ' type="text" name="organizationname" ' . $orgnamevalue . $requiredfield.' />';
$addressline2 = '<input ' . $textinput . ' type="text" name="addressline2" ' . $addressline2value . ' />';
$email = '<input ' . $textinput . ' type="text" name="orgemail" ' . $orgemailvalue . $requiredfield.' />';
$addressline3 = '<input ' . $textinput . ' type="text" name="addressline3" ' . $addressline3value . ' />';
$city = '<input ' . $textinput . ' type="text" name="orgcity" ' . $orgcityvalue . $requiredfield.' />';
$registerdate = '<input ' . $textinput . ' type="text" name="orgregistrationdate" id="orgregistrationdate" ' . $orgregistrationdatevalue . $requiredfield.' />';
$orgzip = '<input ' . $textinput . ' type="text" name="orgzip" ' . $orgzipvalue . ' />';
$ipaddress = '<input ' . $textinput . ' type="text" name="ipaddress" ' . $ipaddressvalue . ' />';
$orgstate = '<input ' . $textinput . ' type="text" name="orgstate" ' . $orgstatevalue . ' />';
$orgcountry = '<input ' . $textinput . ' type="text" name="orgcountry" ' . $orgcountryvalue . $requiredfield. ' />';
$hqorganizationid = '<input ' . $textinput . ' type="text" name="hqorganizationid" ' . $hqorganizationidvalue . $requiredfield. ' />';
$worktel = '<input ' . $textinput2 . ' type="text" name="worktel" ' . $worktelvalue . ' />';
$workfax = '<input ' . $textinput2 . ' type="text" name="workfax" ' . $workfaxvalue . ' />';

$poplink1 = $CFG->wwwroot . '/organization/detailusersubscribed.php?orgid=' . $id;
$poplink2 = $CFG->wwwroot . '/organization/detailcoursesubscribed.php?orgid=' . $id;
$poplink3 = $CFG->wwwroot . '/organization/detailpassrate.php?orgid=' . $id;
$totalUserSub = "window.open('" . $poplink1 . "', 'Window2', 'width=880,height=630, scrollbars=1')";
$totalCourseSub = "window.open('" . $poplink2 . "', 'Window2', 'width=880,height=630, scrollbars=1')";
$totalPassrate = "window.open('" . $poplink3 . "', 'Window2', 'width=880,height=630, scrollbars=1')";

$textinput1 = 'style="float:left;margin-top:0.5em;margin-left:0.3em;cursor: pointer;"';
$iconpopup1 = '<a ' . $textinput1 . ' onclick="' . $totalUserSub . '"><image src="' . $CFG->wwwroot . '/ui/images/Info_icon.png" name="" width="18px"></a>';
$iconpopup2 = '<a ' . $textinput1 . ' onclick="' . $totalCourseSub . '"><image src="' . $CFG->wwwroot . '/ui/images/Info_icon.png" name="" width="18px"></a>';
$iconpopup3 = '<a ' . $textinput1 . ' onclick="' . $totalPassrate . '"><image src="' . $CFG->wwwroot . '/ui/images/Info_icon.png" name="" width="18px"></a>';

echo '<table class="n" id="n" style="width:100%;margin:0px auto;border: 3px solid #ffffff;margin-top:1em;">';
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
    $roles.= '>';
    $roles.=$role->name . '<br/>';
    print_r($roles);
}

print_r($tdclose . $td);
print_r(get_string('address3') . '<br/>' . $addressline3);                // Address Line 3 $totaluserssub
print_r($tdclose . $td);
print_r(get_string('totalusersubscribed'));     // total user subscribed
echo '<br/><input ' . $textinput . ' type="text" name="totalusersubscribed" value="' . $totaluserssub . '" /> &nbsp;' . $iconpopup1;
print_r($tdclose . $trclose);                   // </td></tr>     

print_r($tr . $td);                             // <tr><td>
print_r($required . $organizationstatus . '</div>');                   // Organization Status
print_r($div . $divclose);
print_r(orgstatus($rs->status));
print_r($tdclose . $td);
print_r($required . get_string('city') . '</div>');                    // city town
echo $city;
print_r($tdclose . $td);
print_r(get_string('totalcoursesubscribed'));
echo '<br/><div class="groupbutton"><input ' . $textinput . ' type="text" name="totalcoursesubscribed" value="' . $totalcoursesub . '" /> &nbsp;' . $iconpopup2 . '</div>';
print_r($tdclose . $trclose);                   // </td></tr>  

print_r($tr . $td);                             // <tr><td>
print_r($required . $orgregistrationdate . '</div>');                  // Registration date
echo $registerdate;
print_r($tdclose . $td);
print_r(get_string('zip'));                     // Zip
echo '<br/>' . $orgzip;
print_r($tdclose . $td);
print_r(get_string('passrate'));                    // passrate here
echo '<br/><input ' . $textinput . ' type="text" name="passrate" value="'.passrateorganization($id, $passgrade).'" /> &nbsp;' . $iconpopup3;
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
echo getOrganizationRoles('organizationrole', $oroles);
print_r($tdclose . $trclose);                   // </td></tr>   

print_r($tr . $td);                             // <tr><td>
print_r($organizationsize);                     // Organization Size
print_r($div . $divclose);
print_r(organizationdatabase(1, $rs->organizationsize, 'orgsize'));
print_r($tdclose . $td);
print_r($required . get_string('country') . '</div>');                 // country
echo selectcountry('country', $rs->country);
print_r($tdclose . $td);
print_r($required . get_string('hqorganizationid') . '</div>');
print_r($hqorganizationid);
print_r($tdclose . $trclose);                   // </td></tr>    

print_r($tr . $td);                             // <tr><td>
print_r($organizationtype);                     // Organization Type
print_r($div . $divclose);
print_r(organizationdatabase(2, $rs->organizationtype, 'orgtype'));
print_r($tdclose . $td);
print_r(get_string('worktel'));                 // Work tel
echo '<br/>';
print_r('<div style="float:left;margin:0.5em 0.3em 0 0;"> +' . getUserCountrycode($rs->country) . '</div> ' . $worktel);
print_r($tdclose . '<td rowspan="3">');
print_r($required . get_string('logo') . '</div>');                    // Logo
print_r($orglogo.'<br/>');
print_r($orglogoupload);
print_r($tdclose . $trclose);                   // </td></tr> 

print_r($tr . '<td valign="top">');                             // <tr><td>
print_r($industry);                             // Organization Industry
print_r($div . $divclose);
print_r(organizationdatabase(3, $rs->organizationindustry, 'orgindustry'));
print_r($tdclose . $td);
print_r(get_string('workfax'));                 // Work Fax
echo '<br/>';
print_r('<div style="float:left;margin:0.5em 0.3em 0 0;"> +' . getUserCountrycode($rs->country) . '</div> ' . $workfax);
print_r($tdclose . $td);
print_r($tdclose . $trclose);                   // </td></tr>     
echo '</table>';
echo '</form>';
