<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function buildsupportcontentdb_org($userid, $searchcategory, $searchdesc, $searchdate, $searchid, $searchcreatedby, $searchstatus) {
    global $DB;
 
    $sql="Select *, From_UnixTime(timecreated, '%d/%m/%Y') As getdate From {support} Where userid='".$userid."' And usertype!='5'  And deleted='0'"; 
    if(!empty($searchcategory)){
        $sql.=" And category = '".$searchcategory."'";
    }
    if(!empty($searchdesc)){
        $sql.=" And description Like '%".$searchdesc."%'";
    }
    if(!empty($searchdate)){
       $sql.=" And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL timecreated SECOND), '%d-%m-%Y') LIKE '%{$searchdate}%'))";
    }
    if(!empty($searchid)){
        $sql.=" And supportid LIKE '%".$searchid."%'";
    }
    if(!empty($searchcreatedby)){
        $sql.=" And createdby='".$searchcreatedby."'";
    }  
    if(!empty($searchstatus)){
        $sql.=" And status='".$searchstatus."'";
    }
    $sql.=" Order By id Desc";
    $data = $DB->get_recordset_sql($sql);    
    
    return $data;
}

function buildsupport_attachment_org($userid, $searchcategory, $searchdesc, $searchdate, $searchattachmentid, $searchcreatedby){
    global $DB;
    
    $sql="Select *, From_UnixTime(timecreated, '%d/%m/%Y') As getdate From {support_attachment} Where userid='".$userid."' And usertype!='5' And status='0'"; 
    if(!empty($searchcategory)){
        $sql.=" And category = '".$searchcategory."'";
    }
    if(!empty($searchdesc)){
        $sql.=" And attachment_desc Like '%".$searchdesc."%'";
    }
    if(!empty($searchdate)){
        $sql.=" And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL timecreated SECOND), '%d-%m-%Y') LIKE '%{$searchdate}%'))";
    }
    if(!empty($searchattachmentid)){
        $sql.=" And attachmentid LIKE '%".$searchattachmentid."%'";
    }
    if(!empty($searchcreatedby)){
        $sql.=" And createdby='".$searchcreatedby."'";
    }  
    $sql.=" Order By id Desc";
    $data = $DB->get_recordset_sql($sql);
    return $data;    
}

function buildsupport_activities_org($userid, $searchcategory, $searchdesc, $searchdate, $searchactivityid, $searchcreatedby){
    global $DB;
    
    $sql="Select *, From_UnixTime(timecreated, '%d/%m/%Y') As getdate From {log_activity} Where recipientid='".$userid."' And usertype!='5' And deleted='0'"; 
    if(!empty($searchcategory)){
        $sql.=" And category = '".$searchcategory."'";
    }
    if(!empty($searchdesc)){
        $sql.=" And information Like '%".$searchdesc."%'";
    }
    if(!empty($searchdate)){
        $sql.=" And ((DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL timecreated SECOND), '%d-%m-%Y') LIKE '%{$searchdate}%'))";
    }
    if(!empty($searchactivityid)){
        $sql.=" And activityid LIKE '%".$searchactivityid."%'";
    }
    if(!empty($searchcreatedby)){
        $sql.=" And createdby='2'";
    }    
    $sql.=" Order By id Desc";
    $data = $DB->get_records_sql($sql);
    return $data;    
}

// User searchs
function users_search($table, $countrycode) {
    $selectname = 'searchcreatedby';
    $gendername = 'gendercolumn';

    $communicationtitle = createinputtext('text', 'candidateid', 'candidateid', '', '', 'width:100%;text-align:left;');
    $firstnamebox = createinputtext('text', 'firstname', 'firstname', '', '', 'width:100%;text-align:left;');
    $lastnamebox = createinputtext('text', 'lastname', 'lastname', '', '', 'width:100%;text-align:left;');
    $emailbox = createinputtext('text', 'email', 'email', '', '', 'width:100%;text-align:left;');
    $citybox = createinputtext('text', 'city', 'city', '', '', 'width:100%;text-align:left;');
    $county = selectcountry('getcountry', $countrycode);
    $gender = selectgender($gendername);

    $dobbox = createinputtext('text', 'creationdatetime', 'creationdatetime', '', 'dd-mm-yy', 'width:100%;text-align:center;');
    $createdby = selectcreatedby_financial($selectname);      // created by                        // created by     

    $table->data[] = array($communicationtitle, $firstnamebox, $lastnamebox, $emailbox, $gender, $dobbox, '-', $citybox, '-', $createdby, '-');
    return $table;
}


//organization_search($table);
function organization_search($table) {
    $selectname = 'searchcreatedby';
    $orgid = createinputtext('text', 'organizationid', 'organizationid', '', '', 'width:100%;text-align:left;');
    $namebox = createinputtext('text', 'organizationname', 'organizationname', '', '', 'width:100%;text-align:left;');
    $rolebox = createinputtext('text', 'srole', 'srole', '', '', 'width:100%;text-align:left;');
    $statusbox = createinputtext('text', 'orgstatus', 'orgstatus', '', '', 'width:100%;text-align:left;');
    $country = selectcountry('country', '0');
    $registrationdate = createinputtext('text', 'orgregistrationdate', 'orgregistrationdate', '', 'dd-mm-yy', 'width:100%;text-align:center;');
    $createdby = selectcreatedby_financial($selectname);      // created by                        // created by     

    $table->data[] = array($orgid, $namebox, $rolebox, $statusbox, $registrationdate, $country, $createdby,'');
    return $table;
}

/* function supportorgcontent_default($userid, $table, $searchcategory, $searchdesc, $searchdate, $searchid, $searchcreatedby, $searchstatus){
    foreach (buildsupportcontentdb_org($userid, $searchcategory, $searchdesc, $searchdate, $searchid, $searchcreatedby, $searchstatus) as $item) {
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

// SWITCHCASE START HERE TO DISPLAY PAGE
function createdswitchcase_org($n, $supporttab, $activitiestab, $attachmenttab, $logginuserid, $whichsupportbutton = '', $p1 = '', $p2 = '', $p3 = '', $uid = '', $f6 = '', $f7 = '', $f8 = '', $delcoursehistory='',$generateActivitiyId='', $formtype='') {
    switch ($n) {
        case $supporttab:
            echo 'support for organization';
            supportcontent($uid, $logginuserid, $whichsupportbutton, $p1, $p2, $p3, $f6, $f7, $f8, $generateActivitiyId, $formtype, $delcoursehistory);
            break;
        case $activitiestab:
            // activities
            echo supportactivities($uid, $whichsupportbutton, $logginuserid, $p2, $p3, $f6, $f7, $f8, $generateActivitiyId, $formtype, $delcoursehistory);
            break;
        case $attachmenttab:
            // attachment
            echo 'Upload attachment belom buat!!!!';
            supportattachment($uid, $whichsupportbutton, $logginuserid, $p2, $p3, $f6, $f7, $f8, $generateActivitiyId, $formtype, $delcoursehistory);
            break;
        default:
            supportcontent($uid, $logginuserid, $whichsupportbutton, $p1, $p2, $p3, $f6, $f7, $f8, $generateActivitiyId, $formtype, $delcoursehistory);
    }
}*/

