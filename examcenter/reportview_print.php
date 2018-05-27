<body onLoad="window.print()">
    <?php
    require_once('../config.php');
    require_once('../manualdbconfig.php');
	require_once('../lib/datalib.php');
    /* require_once($CFG->dirroot .'/lib/blocklib.php'); 
      require_once($CFG->dirroot .'/course/lib.php');
      require_once($CFG->libdir .'/filelib.php'); */

    include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);

    $progressreport = 'View Report';
    $rmanagement = 'Report Management';
    $url_view = $CFG->wwwroot . '/examcenter/myreport.php?id=' . $USER->id;
    $PAGE->navbar->add(ucwords(strtolower($rmanagement)), $url_view)->add(ucwords(strtolower($progressreport)), $url_view);

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
    $PAGE->set_pagelayout('buy_a_cifa');
    // $PAGE->requires->css('/theme/aardvark/style/core.css');
    // echo $OUTPUT->header();
    ?>
    <style type="text/css">
<?php
// include('../institutionalclient/style.css');
?>
        a:hover {text-decoration:underline;}
        #searchtable td{	 
            border-collapse:collapse; 
            border: 1px solid #666666;
            padding-left:5px;
        }
        #searchtable th{
            border: 1px solid #231f20;
            color:#ffffff;	
            background-color:#6D6E71;
        }	
        html, body {
            font-family: Verdana,Geneva,sans-serif !important;
            color: #333;
            font-size:0.9em;
        }	
        table tr, td, th {
            font-family: Verdana,Geneva,sans-serif;
            font-size:0.9em;
        }
    </style>
    <style type="text/css">
        img.table-bg-image {
            position: absolute;
            z-index: -1;
            width:98%;
            height:100%;
        }
        table.with-bg-image, table.with-bg-image tr, table.with-bg-image td {
            background: transparent;
        }
    </style>
    <script type="text/javascript" language="javascript">
    <!-- Begin
        checked = false;
        function checkedAll() {
            if (checked == false) {
                checked = true;
            }
            for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
                document.getElementById('form1').elements[i].checked = checked;
                //document.getElementById('selectall').disabled=true;
            }
        }
    //  End -->
        function clearSelected() {
            if (checked == true) {
                checked = false
            }
            for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
                document.getElementById('form1').elements[i].checked = checked;
                //document.getElementById('unselectall').disabled=true;
            }
        }
    </script>
    <script type="text/javascript" language="javascript">
    <!-- Begin
        checked = false;
        function checkedAll2() {
            if (checked == false) {
                checked = true;
            }
            for (var i = 0; i < document.getElementById('form2').elements.length; i++) {
                document.getElementById('form2').elements[i].checked = checked;
            }
        }
    //  End -->
        function clearSelected2() {
            if (checked == true) {
                checked = false
            }
            for (var i = 0; i < document.getElementById('form2').elements.length; i++) {
                document.getElementById('form2').elements[i].checked = checked;
            }
        }
    </script>
    <script type="text/javascript" language="javascript">
    <!-- Begin
        checked = false;
        function checkedAll3() {
            if (checked == false) {
                checked = true;
            }
            for (var i = 0; i < document.getElementById('form3').elements.length; i++) {
                document.getElementById('form3').elements[i].checked = checked;
            }
        }
    //  End -->
        function clearSelected3() {
            if (checked == true) {
                checked = false
            }
            for (var i = 0; i < document.getElementById('form3').elements.length; i++) {
                document.getElementById('form3').elements[i].checked = checked;
            }
        }
    </script>
    <br/>

    <table class="with-bg-image"  border="0" cellspacing="0" cellpadding="10" style="width:98%;padding:0px; margin:1em;" align="center"><tr><td style="vertical-align:top;">

                <table width="100%" border="0"  style="padding:0px;">
                    <tr valign="top">
                        <td align="left">
                            <table style="padding:0px; margin:0px; color:#666;">
                                <tr><td>Tel: [+965] 22915580</td></tr>
                                <tr><td>Fax: [+965] 22915580</td></tr>
                                <tr><td>Website: learnCIFA.com</td></tr>
                                <tr><td>P.O.Box 29916, Safat 13159,</td></tr>
                                <tr><td>Kuwait City, Kuwait</td></tr></table>
                        </td>
                        <td align="right" style="width:50%"><img style="width:150px;" src="<?= $CFG->wwwroot; ?>/image/CIFALogo.png"></td>
                    </tr>
                </table>
                <?php
                $reportid = $_GET['id'];
                $reportSQL = mysql_query("
		Select
		  *
		From
		  mdl_cifareport_menu a Inner Join
		  mdl_cifareport_option b On b.reportid = a.id Inner Join
		  mdl_cifareport_users c On b.reportid = c.reportid
		Where
			b.reportid='" . $reportid . "'	
	");
                $viewreport = mysql_fetch_array($reportSQL);

                $rpcreator = mysql_query("
		Select
		  b.userid,
		  a.name,
		  a.id,
		  b.contextid
		From
		  {$CFG->prefix}role a Inner Join
		  {$CFG->prefix}role_assignments b On a.id = b.roleid
		Where
		  b.userid = '" . $viewreport['reportcreator'] . "' And
		  b.contextid = '1'		
	");
                $creator = mysql_fetch_array($rpcreator);

                if ($viewreport['selectedreport'] == '0') {
                    ?>

                    <!--////- Candidate Performance -////-->
                    <div style="margin-left:1em;width:98%"><h2><?= get_string('candidateperformance'); ?></h2></div>
                    <form name="form1" id="form1" action="" method="post">
                        <div style="margin-left:0.5em;font-size:2em; font-weight:bolder;"><?= $viewreport['reportname']; ?></div>
                        <div style="margin-left:1em;margin-bottom:1em;"><?= $creator['name']; ?>, <?= date('d/m/Y h:i:s', $viewreport['timecreated']); ?></div>
                        <?php
                        // list out candidate performance	
                        $statement = "
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifareport_users d On c.userid = d.candidateid Inner Join
	  mdl_cifauser e On d.candidateid = e.id
	";

                        $statement.=" WHERE a.category = '1' And d.reportid = '" . $reportid . "' And a.visible != '0'";
                        $csql = "SELECT * FROM {$statement}";
                        $sqlquery = mysql_query($csql);
                        ?>	

                        <table width="98%" border="1" cellpadding="0" cellspacing="0" id="searchtable" style="margin:0px auto;">
                            <tr>
                                <?php if (($creator['id'] == '12') || ($creator['id'] == '13')) { ?>

                                    <?php if ($viewreport['organizationname'] != '0') { ?> 
                                        <th width="10%" scope="row"><?= get_string('organization'); ?></th>
                                    <?php }if ($viewreport['employeeid'] != '0') { ?>   
                                        <th width="10%" scope="row"><?= get_string('employeeid'); ?></th>			  
                                    <?php }if ($viewreport['candidateID'] != '0') { ?>          
                                        <th width="10%" scope="row"><?= get_string('candidateid'); ?></th>		  
                                    <?php }if ($viewreport['candidateFullname'] != '0') { ?>
                                        <th width="20%"><?= get_string('fullname'); ?></th>
                                    <?php }if ($viewreport['candidateEmail'] != '0') { ?>
                                        <th width="20%"><?= get_string('email'); ?></th>
                                    <?php }if ($viewreport['candidateAddress'] != '0') { ?>
                                        <th width="20%"><?= get_string('address'); ?></th>
                                    <?php }if ($viewreport['candidateTel'] != '0') { ?>
                                        <th width="20%"><?= get_string('officetel'); ?></th>
                                    <?php }if ($viewreport['designation'] != '0') { ?>
                                        <th width="20%"><?= get_string('designation'); ?></th>
                                    <?php }if ($viewreport['department'] != '0') { ?>
                                        <th width="20%"><?= get_string('department'); ?></th>			  
                                    <?php }
                                } else if (($creator['id'] == '10')) { ?>
                                    <th width="10%" scope="row"><?= get_string('candidateid'); ?></th>
                                    <th width="20%"><?= get_string('fullname'); ?></th>		
                                <?php } ?>
                                <?php if ($viewreport['curriculumname'] != '0') { ?>
                                    <th width="20%"><?= get_string('coursetitle'); ?></th> 
                                <?php } if ($viewreport['curriculumcode'] != '0') { ?>   
                                    <th width="10%"><?= get_string('curriculumcode'); ?></th>
                                <?php } if ($viewreport['performancestatus'] != '0') { ?>   
                                    <th width="10%"><?= get_string('status'); ?></th>            
                                <?php } if ($viewreport['markperformance'] != '0') { ?>
                                    <th width="10%"><?= get_string('marks'); ?></th>
                                <?php } if ($viewreport['modulecompleted'] != '0') { ?>
                                    <th width="12%"><?= get_string('modulecompleted'); ?></th>
                                <?php } if ($viewreport['totaltimeperformance'] != '0') { ?>
                                    <th width="10%"><?= get_string('totaltime'); ?></th>
                                <?php } if ($viewreport['examinationstatus'] != '0') { ?>
                                    <th width="10%"><?= get_string('teststatus'); ?></th>
                        <?php } if ($viewreport['subscriptiondate'] != '0') { ?>
                            <th width="10%"><?= get_string('subscriptiondate'); ?></th>
                        <?php } if ($viewreport['expirydate'] != '0') { ?>
                            <th width="10%"><?= get_string('expirydate'); ?></th>
                        <?php } if ($viewreport['lastaccess'] != '0') { ?>
                            <th width="10%"><?= get_string('lastaccess'); ?></th>                                   
                                <?php } ?>			
                            </tr>
                            <?php
                            $mycount = mysql_num_rows($sqlquery);
                            $no = '1';
                            if ($mycount != '0') {
                                while ($sqlrow = mysql_fetch_array($sqlquery)) {
                                    $bil = $no++;

                                    // display course code where coursefullname=testname
                                    $sqltestcode = mysql_query("
		Select
		  a.name,
		  a.course,
		  b.idnumber,
		  a.id as quizattemptsid,
		  a.attempts
		From
		  mdl_cifaquiz a Inner Join
		  mdl_cifacourse b On a.name = b.fullname 
		Where
		  b.visible!='0' And a.name='" . $sqlrow['fullname'] . "'
	");
                                    $testcodearray = mysql_fetch_array($sqltestcode);
                                    $cname = $testcodearray['name'];
                                    $cattempts = $testcodearray['attempts'];
                                    $ccode = ucwords(strtoupper($testcodearray['idnumber']));

                                    $sgrade = mysql_query("
						Select
						  *,
						  a.grade As usergrade, b.id As quizid
						From
						  mdl_cifaquiz_grades a,
						  mdl_cifaquiz b Inner Join
						  mdl_cifacourse c On b.course = c.id
						Where
						  a.quiz = b.id And c.visible!='0' And
						  (c.category = '3' And
						  a.userid = '" . $sqlrow['userid'] . "')				
					");
                                    $cq = mysql_num_rows($sgrade); //count records	
                                    $qgrade = mysql_fetch_array($sgrade);

                                    //how to get grade
                                    $sselect = "
		  a.name,
		  a.id as quizattemptsid,
		  b.attempt,
		  c.grade as testgrade,
		  b.userid,
		  b.id As id1,
		  a.attempts,
		  a.course	
	";
                                    $sstatement = "
		  mdl_cifaquiz a Inner Join
		  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
		  mdl_cifaquiz_grades c On b.quiz = c.quiz And b.userid = c.userid
	";
                                    //$sstatement.=" Where a.id = '".$testcodearray['quizattemptsid']."' And b.userid='".$sqlrow['userid']."'";
                                    $sstatement.=" Where a.id = '" . $qgrade['quizid'] . "' And b.userid='" . $sqlrow['userid'] . "'";
                                    if ($cattempts == '1') {
                                        $sstatement.=" And b.attempt = '1'";
                                    }
                                    if ($cattempts == '2') {
                                        $sstatement.=" And b.attempt = '2'";
                                    }
                                    $sqltestgrade = mysql_query("Select {$sselect} From {$sstatement}");
                                    $testgraderow = mysql_num_rows($sqltestgrade);
                                    $testgrade = mysql_fetch_array($sqltestgrade);
                                    $finalgrade = $testgrade['testgrade'];

                                    //country list
                                    $countrylistsql = mysql_query("SELECT * FROM {$CFG->prefix}country_list WHERE countrycode='" . $sqlrow['country'] . "'");
                                    $countrylist = mysql_fetch_array($countrylistsql);

                                    // OrgType
                                    $qryOrg = "SELECT * FROM {$CFG->prefix}organization_type WHERE id='" . $sqlrow['orgtype'] . "' ORDER BY id ASC";
                                    $sqlOrg = mysql_query($qryOrg);
                                    $rsOrg = mysql_fetch_array($sqlOrg);
                                    $rsOrgName = $rsOrg['name'] . ' ' . $countrylist['countryname'];

                                    $fulladdress = ucwords(strtolower($sqlrow['address'] . ' ' . $sqlrow['address2'] . ' ' . $sqlrow['address3'] . ', ' . $sqlrow['postcode'] . ' ' . $sqlrow['city'] . ' ' . $sqlrow['state'] . ', ' . $countrylist['countryname']));
                                    ?>
                                    <tr>		  
                                            <?php if (($creator['id'] == '12') || ($creator['id'] == '13')) { ?>
                                                <?php if ($viewreport['organizationname'] != '0') { ?>
                                                <td style="text-align:center" scope="row"><?= $rsOrgName; ?></td>
                                            <?php }if ($viewreport['employeeid'] != '0') { ?>
                                                <td style="text-align:center" scope="row">
                                                <?php if ($sqlrow['access_token'] != '') {
                                                    echo strtoupper($sqlrow['access_token']);
                                                } else {
                                                    echo " - ";
                                                } ?>
                                                </td>		
                                            <?php }if ($viewreport['candidateID'] != '0') { ?>
                                                <td style="text-align:center" scope="row"><?= strtoupper($sqlrow['traineeid']); ?></td>				  
                                            <?php }if ($viewreport['candidateFullname'] != '0') { ?>
                                                <td><?= ucwords(strtolower($sqlrow['firstname'] . ' ' . $sqlrow['lastname'])); ?></td>	
                                                <?php }if ($viewreport['candidateEmail'] != '0') { ?>
                                                <td style="text-align:center" scope="row"><?= $sqlrow['email']; ?></td>
                                            <?php }if ($viewreport['candidateAddress'] != '0') { ?>
                                                <td><?= $fulladdress; ?></td>	
                                                <?php }if ($viewreport['candidateTel'] != '0') { ?>
                                                <td><?= '+' . $countrylist['iso_countrycode'] . $sqlrow['phone1']; ?></td>
                                            <?php }if ($viewreport['designation'] != '0') { ?>
                                                <td>
                                                <?php if ($sqlrow['designation'] != '') {
                                                    echo $sqlrow['designation'];
                                                } else {
                                                    echo " - ";
                                                } ?>
                                                </td>
                                            <?php }if ($viewreport['department'] != '0') { ?>
                                                <td>
                                                    <?php if ($sqlrow['department'] != '') {
                                                        echo $sqlrow['department'];
                                                    } else {
                                                        echo " - ";
                                                    } ?>
                                                </td>		  
                                                <?php }
                                            } else if (($creator['id'] == '10')) { ?>
                                            <td style="text-align:center" scope="row"><?= strtoupper($sqlrow['traineeid']); ?></td>
                                            <td><?= ucwords(strtolower($sqlrow['firstname'] . ' ' . $sqlrow['lastname'])); ?></td>	
                                            <?php } ?>		

                                            <?php if ($viewreport['curriculumname'] != '0') { ?>
                                            <td style="text-align:left"><?= $cname; ?></td>
                                            <?php }if ($viewreport['curriculumcode'] != '0') { ?>
                                            <td style="text-align:center"><?= $ccode; ?></td>
                                            <?php } if ($viewreport['performancestatus'] != '0') { ?>
                                            <td style="text-align:center">
                                                <?php
                                                // course status // subscribe or in progress or end
                                                if ($testgraderow != '0') {
                                                    echo 'Ended';
                                                } else {
                                                    if (!$sqlrow['timeclose'] || strtotime('now') < $sqlrow['timeclose']) {
                                                        // The attempt is still in progress.
                                                        echo $datecompleted = get_string('inprogress', 'quiz');
                                                    } else {
                                                        $timetaken = format_time($sqlrow['timefinish'] - $sqlrow['timestart']);
                                                        echo $datecompleted = userdate($sqlrow['timeclose']);
                                                    }
                                                }
                                                ?>
                                            </td><?php } if ($viewreport['markperformance'] != '0') { ?>
                                            <td style="text-align:center">
                                                <?php
                                                // Marks %
                                                if ($testgraderow != '0') {
                                                    echo round($finalgrade);
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                            <?php } if ($viewreport['modulecompleted'] != '0') { ?>
                                            <td style="text-align:center">
                                                <?php
                                                $sqlcoursequery = mysql_query("SELECT * FROM {$CFG->prefix}course WHERE idnumber='" . $ccode . "' AND category='1'");
                                                $sqlcourse = mysql_fetch_array($sqlcoursequery);

                                                /*$cmodulecompletesql = mysql_query("
				Select
				  *
				From
				  mdl_cifascorm a Inner Join
				  mdl_cifascorm_scoes_track b On a.id = b.scormid
				Where
					b.userid='" . $sqlrow['userid'] . "' And a.course='" . $sqlcourse['id'] . "'
				Group By a.id		
			");
                                                $kiramodule = mysql_num_rows($cmodulecompletesql);

                                                $cmcompletesql = mysql_query("
				Select
				  *
				From
				  mdl_cifascorm a
				Where
					a.course='" . $sqlcourse['id'] . "'
				Group By a.id		
			");
                                                $moduleofcourse = mysql_num_rows($cmcompletesql);

                                                echo $kiramodule . " of " . $moduleofcourse . " Modules";*/
												
        // Completed Module here!!!!
        $rsc = printScormWithCourseId($sqlcourse['id']);
        $a='0';
        foreach ($rsc as $r) {
           // 
           $sql = "Select COUNT(a.id)
                         From
                           {scorm_scoes_track} a
                         Where
                           a.userid='".$sqlrow['userid']."' AND
                           a.scormid='" . $r->scorm . "' AND
                           a.value = 'completed'
                         ";
           $rs = $DB->count_records_sql($sql);
           if ($rs == chapteronscorm($r->scorm)) {
               $a++;
           }
            
        } $rsc->close();   echo $a.' of ' . getTotalScormOnCourse($sqlcourse['id']) . ' Modules'; 												
                                                ?>
                                            </td>
                                    <?php } if ($viewreport['totaltimeperformance'] != '0') { ?>
                                            <td style="text-align:center;">
                <?php
                // total time accessing course
                // echo format_time($sqlrow['lastaccess'] - $sqlrow['timestart']);
                if ($sqlrow['firstaccess']) {
                    echo $strlastaccess = format_time(time() - $sqlrow['firstaccess']);
                } else {
                    echo $strlastaccess = '0';
                }
                ?>
                                            </td><?php } if ($viewreport['examinationstatus'] != '0') { ?>
                                            <td style="text-align:center;">
                <?php
                // Test (Status)
                if ($testgraderow != '0') {
                    if ($finalgrade < '60') {
                        echo 'Fail';
                    } else {
                        echo 'Pass';
                    }
                } else {
                    echo '-';
                }
                ?>
                                    </td><?php } if ($viewreport['subscriptiondate'] != '0') { ?>
                                    <td style="text-align:center;">
                                        <?php
                                            if($sqlrow['firstaccess']!=0){
                                                echo date('d-m-Y', $sqlrow['timestart']);
                                            }else{ echo ' - '; }
                                        ?>
                                    </td>
                                    <?php } if ($viewreport['expirydate'] != '0') { ?>
                                    <td style="text-align:center;">
                                        <?php                                          
                                            if($sqlrow['firstaccess']!=0){
                                                echo date('d-m-Y', $sqlrow['timeend']);
                                            }else{ echo ' - '; }
                                        ?>
                                    </td>
                                    <?php } if ($viewreport['lastaccess'] != '0') { ?>
                                    <td style="text-align:center;">
                                        <?php
                                            if($sqlrow['firstaccess']!=0){
                                                echo date('d-m-Y H:i:s', $sqlrow['lastaccess']);
                                            }else{ echo ' - '; }
                                        ?>
                                    </td>
                                    <?php } ?>
                                    </tr>

                                <?php
                            }
                        } else {
                            ?>
                                <tr><td colspan="14" scope="row">Records not found</td></tr>
                        <?php } ?>
                        </table><br/><br/></form>	  
                    </fieldset>
<?php } else if ($viewreport['selectedreport'] == '1') { ?>


                    <!--////- Examination Performance -////-->
                    <!--fieldset style="padding: 1em;" id="user" class="clearfix">
                   <legend style="font-weight:bolder;" class="ftoggler">IPD Course Performance</legend><br/-->

                    <div style="width:98%;"><h2><u>IPD Course Performance</u></h2></div>
                    <form name="form2" id="form2" action="" method="post">
                        <div style="width:98%;font-size:2em; font-weight:bolder;"><?= $viewreport['reportname']; ?></div>
                        <div style="width:98%;margin-bottom:1em;"><?= $creator['name']; ?>, <?= date('d/m/Y h:i:s', $viewreport['timecreated']); ?></div>
                                <?php
                                $statement = "
		  mdl_cifaquiz a Inner Join
		  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
		  mdl_cifacourse c On a.course = c.id Inner Join
		  mdl_cifauser d On b.userid = d.id Inner Join
		  mdl_cifareport_users e On e.candidateid = d.id
	";
                                $statement.=" WHERE  c.visible = '1' And c.category = '3' And e.reportid = '" . $reportid . "'";
                                $statement.=" Group By b.quiz";
                                $csql = "SELECT *, c.idnumber as code, a.name As testname, a.id As quizattemptid FROM {$statement}";
                                $sqlquery = mysql_query($csql);
                                ?>	

                        <table width="100%" id="searchtable" style="margin:0px auto; border-collapse:collapse;">
                            <tr>
                                <?php if (($creator['id'] == '12') || ($creator['id'] == '13')) { ?>
                                        <?php if ($viewreport['candidateID'] != '0') { ?>          
                                        <th width="10%" scope="row"><?= get_string('candidateid'); ?>
                                            <?php /* <div style="position: relative;">
                                              <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                              <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                              <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('candidateid');?></span>
                                              </div> */ ?>            
                                        </th>
                                        <?php }if ($viewreport['candidateFullname'] != '0') { ?>
                                        <th width="20%"><?= get_string('fullname'); ?>
                                            <?php /* <div style="position: relative;">
                                              <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                              <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                              <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('fullname');?></span>
                                              </div> */ ?>		  
                                        </th>
                                        <?php }if ($viewreport['candidateEmail'] != '0') { ?>
                                        <th width="20%"><?= get_string('email'); ?>
                                            <?php /* <div style="position: relative;">
                                              <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                              <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                              <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('email');?></span>
                                              </div> */ ?>			  
                                        </th>
                                        <?php }if ($viewreport['candidateAddress'] != '0') { ?>
                                        <th width="20%"><?= get_string('address'); ?>
                                            <?php /* <div style="position: relative;">
                                              <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                              <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                              <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('address');?></span>
                                              </div> */ ?>	  
                                        </th>
                                        <?php }if ($viewreport['candidateTel'] != '0') { ?>
                                        <th width="20%"><?= get_string('officetel'); ?>
                                            <?php /* <div style="position: relative;">
                                              <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                              <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                              <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('officetel');?></span>
                                              </div> */ ?>		  
                                        </th>
                                        <?php }
                                    } else if (($creator['id'] == '10')) { ?>
                                    <th width="15%" scope="row"><?= get_string('candidateid'); ?>
                                        <?php /* <div style="position: relative;">
                                          <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                          <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                          <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('candidateid');?></span>
                                          </div> */ ?>			  
                                    </th>
                                    <th width="20%"><?= get_string('fullname'); ?>
                                        <?php /* <div style="position: relative;">
                                          <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                          <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                          <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('fullname');?></span>
                                          </div> */ ?>
                                    </th>		
                                    <?php } ?>
                                    <?php if ($viewreport['cnameexam'] != '0') { ?>
                                    <th width="25%" scope="row"><?= get_string('coursetitle'); ?>
                                        <?php /* <div style="position: relative;">
                                          <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                          <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                          <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('coursetitle');?></span>
                                          </div> */ ?>
                                    </th>
                                    <?php } if ($viewreport['ccodeexam'] != '0') { ?>
                                    <th width="10%"><?= get_string('curriculumcode'); ?>
                                        <?php /* <div style="position: relative;">
                                          <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                          <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                          <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('curriculumcode');?></span>
                                          </div> */ ?>                          
                                    </th>
                                    <?php } if ($viewreport['cattempts'] != '0') { ?>
                                    <th width="8%"><?= get_string('attempts'); ?>
                                        <?php /* <div style="position: relative;">
                                          <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                          <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                          <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('attempts');?></span>
                                          </div> */ ?>           
                                    </th> 
                                    <?php } if ($viewreport['learningoutcomes'] != '0') { ?>   
                                    <th width="29%"><?= get_string('learningoutcome'); ?>
                                        <?php /* <div style="position: relative;">
                                          <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                          <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                          <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('learningoutcome');?></span>
                                          </div> */ ?>             
                                    </th>
                            <?php } if ($viewreport['scoreonlo'] != '0') { ?>
                                    <th width="9%"><?= get_string('examscore'); ?>
                                <?php /* <div style="position: relative;">
                                  <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                  <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                  <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('examscore');?></span>
                                  </div> */ ?>          
                                    </th>
                            <?php } if ($viewreport['passes'] != '0') { ?>
                                    <th width="9%"><?= get_string('passes'); ?>
                                <?php /* <div style="position: relative;">
                                  <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                  <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                  <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('passes');?></span>
                                  </div> */ ?>         
                                    </th>
                            <?php } if ($viewreport['passrate'] != '0') { ?>
                                    <th width="9%"><?= get_string('passrate'); ?>
                                <?php /* <div style="position: relative;">
                                  <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                  <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                  <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('passrate');?></span>
                                  </div> */ ?>         
                                    </th>
                            <?php } ?>
                            </tr>
                            <?php
                            $mycount = mysql_num_rows($sqlquery);
                            $no = '1';
                            if ($mycount != '0') {
                                while ($sqlrow = mysql_fetch_array($sqlquery)) {
                                    $bil = $no++;

                                    // display course code where coursefullname=testname
                                    $sqltestcode = mysql_query("
		Select
		  a.name,
		  b.idnumber
		From
		  mdl_cifaquiz a Inner Join
		  mdl_cifacourse b On a.name = b.fullname 
		Where
		  b.visible!='0' And a.name='" . $sqlrow['testname'] . "'
	");
                                    $testcodearray = mysql_fetch_array($sqltestcode);
                                    $testcodename = $testcodearray['idnumber'];

                                    //kira calon lulus 
                                    $sgrade = mysql_query("
		Select
		  *,
		  a.grade As usergrade, b.id As quizid
		From
		  mdl_cifaquiz_grades a,
		  mdl_cifaquiz b Inner Join
		  mdl_cifacourse c On b.course = c.id
		Where
		  a.quiz = b.id And a.grade >= 60 And a.quiz = '" . $sqlrow['quizattemptid'] . "' And
		  (c.category = '3' And
		  a.userid = '" . $sqlrow['userid'] . "')				
	");
                                    $cq = mysql_num_rows($sgrade);

                                    // display candidate fullname n traineeid
                                    $st9 = "
		  a.userid,
		  a.quiz,
		  a.attempt,
		  b.firstname,
		  b.lastname,
		  c.reportid,
		  b.traineeid	
	";
                                    $st10 = "
		  mdl_cifaquiz_attempts a Inner Join
		  mdl_cifauser b On a.userid = b.id Inner Join
		  mdl_cifareport_users c On c.candidateid = b.id	
	";
                                    $st10.=" Where a.quiz = '" . $sqlrow['quizattemptid'] . "' And c.reportid = '" . $reportid . "'";
                                    $st10.=" Group By a.userid";
                                    $sql10 = mysql_query("Select {$st9} From {$st10}");
                                    $sql11 = mysql_query("Select {$st9} From {$st10}");
                                    $sqla = mysql_num_rows($sql10);

                                    // display learning outcome
                                    $losql = mysql_query("
		Select
		  b.name,
		  b.course,
		  a.idnumber
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifascorm b On a.id = b.course
		Where
		  a.idnumber = '" . $testcodename . "' AND b.reference!='navigation_tips.zip'				
	");
                                    $no = '1';
                                    $losqlcount = mysql_num_rows($losql);

                                    //country list
                                    $countrylistsql = mysql_query("SELECT * FROM {$CFG->prefix}country_list WHERE countrycode='" . $sqlrow['country'] . "'");
                                    $countrylist = mysql_fetch_array($countrylistsql);

                                    $fulladdress = ucwords(strtolower($sqlrow['address'] . ' ' . $sqlrow['address2'] . ' ' . $sqlrow['address3'] . ', ' . $sqlrow['postcode'] . ' ' . $sqlrow['city'] . ' ' . $sqlrow['state'] . ', ' . $countrylist['countryname']));
                                    ?>
                                    <tr>
                                        <?php if (($creator['id'] == '12') || ($creator['id'] == '13')) { ?>
                <?php if ($viewreport['candidateID'] != '0') { ?>
                                                <td style="text-align:center" scope="row">
                                                <?php
                                                $n10 = '1';
                                                while ($sqldisplay10 = mysql_fetch_array($sql10)) {
                                                    echo $n10++ . ')&nbsp;' . ucwords(strtolower($sqldisplay10['traineeid']));
                                                    echo '<br/>';
                                                }
                                                ?>		  
                                                </td>
                                            <?php }if ($viewreport['candidateFullname'] != '0') { ?>
                                                <td><?php
                                                $n11 = '1';
                                                while ($sqldisplay11 = mysql_fetch_array($sql11)) {
                                                    echo $n11++ . ')&nbsp;' . ucwords(strtolower($sqldisplay11['firstname'] . ' ' . $sqldisplay11['lastname']));
                                                    echo '<br/>';
                                                }
                                                ?>
                                                </td>	
                                            <?php }if ($viewreport['candidateEmail'] != '0') { ?>
                                                <td scope="row"><?= $sqlrow['email']; ?></td>
                                            <?php }if ($viewreport['candidateAddress'] != '0') { ?>
                                                <td><?= $fulladdress; ?></td>	
                                                <?php }if ($viewreport['candidateTel'] != '0') { ?>
                                                <td><?= '+' . $countrylist['iso_countrycode'] . $sqlrow['phone1']; ?></td>
                                                <?php }
                                            } else if (($creator['id'] == '10')) { ?>
                                            <td style="text-align:center" scope="row"><?= strtoupper($sqlrow['traineeid']); ?></td>
                                            <td><?= ucwords(strtolower($sqldisplay['firstname'] . ' ' . $sqldisplay['lastname'])); ?></td>	
                                            <?php } ?>	
                                            <?php if ($viewreport['cnameexam'] != '0') { ?>
                                            <td style="text-align:left" scope="row">
                                            <?php
                                            if ($sqlrow['testname'] != '') {
                                                echo $sqlrow['testname'];
                                            } else {
                                                echo ' - ';
                                            }
                                            ?>			
                                            </td>
                                        <?php } if ($viewreport['ccodeexam'] != '0') { ?>
                                            <td style="text-align:center;">
                                                <?php
                                                //if($sqlrow['code']!=''){
                                                echo ucwords(strtoupper($testcodename));
                                                //}else{ echo ' - '; }
                                                ?>
                                            </td>
            <?php } if ($viewreport['cattempts'] != '0') { ?>
                                            <td style="text-align:center"><?= $sqla; ?></td>
                                    <?php } if ($viewreport['learningoutcomes'] != '0') { ?>
                                            <td>
                                        <?php
                                        // Learning Outcome
                                        if ($losqlcount != '0') {
                                            while ($lo = mysql_fetch_array($losql)) {
                                                echo $lo['name'] . '<br/><br/>';
                                            }
                                        } else {
                                            echo ' - ';
                                        }
                                        ?>
                                            </td>
            <?php } if ($viewreport['scoreonlo'] != '0') { ?>
                                            <td style="text-align:center">
                <?php
                // 
                echo ' - ';
                ?>
                                            </td>
                                    <?php } if ($viewreport['passes'] != '0') { ?>
                                            <td style="text-align:center"><?= $cq; //display total pass ?></td>
                                    <?php } if ($viewreport['passrate'] != '0') { ?>
                                            <td style="text-align:center;">
                                        <?php
                                        // display passrate
                                        $countpassrate = ($cq / $sqla) * 100;
                                        echo round($countpassrate) . '%';
                                        ?>
                                            </td><?php } ?>
                                    </tr>

                                    <?php
                                }
                            } else {
                                ?>
                                <tr><td colspan="15" scope="row">Records not found</td></tr>
                                    <?php } ?>
                        </table><br/><br/></form>	  
                    <!--/fieldset-->

                                <?php } else { ?>

                    <!--////-Statistic-////-->
                    <fieldset style="padding: 1em;" id="user" class="clearfix">
                        <legend style="font-weight:bolder;" class="ftoggler">Course Statistics(%)</legend><br/>

                        <form name="form3" id="form3" action="" method="post">
                            <div style="margin-left:1em;font-size:2em; font-weight:bolder;"><?= $viewreport['reportname']; ?></div>
                            <div style="margin-left:2em;margin-bottom:1em;"><?= $creator['name']; ?>, <?= date('d/m/Y h:i:s', $viewreport['timecreated']); ?></div>
                                    <?php
                                    // course statistic %	
                                    // course statistic %	
                                    $statement = "
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifareport_users d On c.userid = d.candidateid Inner Join
	  mdl_cifauser e On d.candidateid = e.id
	";

                                    $statement.=" WHERE a.category = '1' And d.reportid = '" . $reportid . "' And a.visible != '0'";
                                    $statement.=" Group By b.courseid";
                                    $csql = "SELECT *, c.id as enrollmentid, a.idnumber as coursecode FROM {$statement}";
                                    $sqlquery = mysql_query($csql);
                                    ?>	

                            <table width="95%" border="1" cellpadding="0" cellspacing="0" id="searchtable" style="margin:0px auto;">
                                <tr style="background-color:#ccc;">
                                    <?php /* if(($creator['id']=='12') || ($creator['id']=='13')){ ?>
                                      <?php if($viewreport['candidateID']!='0'){ ?>
                                      <th width="15%" scope="row" style="text-align:left;">
                                      <div style="position: relative;">
                                      <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                      <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                      <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('candidateid');?></span>
                                      </div>
                                      </th>
                                      <?php }if($viewreport['candidateFullname']!='0'){ ?>
                                      <th width="20%" style="text-align:left;">
                                      <div style="position: relative;">
                                      <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                      <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                      <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('fullname');?></span>
                                      </div>
                                      </th>
                                      <?php }if($viewreport['candidateEmail']!='0'){ ?>
                                      <th width="20%" style="text-align:left;">
                                      <div style="position: relative;">
                                      <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                      <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                      <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('email');?></span>
                                      </div>
                                      </th>
                                      <?php }if($viewreport['candidateAddress']!='0'){ ?>
                                      <th width="20%" style="text-align:left;">
                                      <div style="position: relative;">
                                      <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                      <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                      <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('address');?></span>
                                      </div>
                                      </th>
                                      <?php }if($viewreport['candidateTel']!='0'){ ?>
                                      <th width="20%" style="text-align:left;">
                                      <div style="position: relative;">
                                      <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                      <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                      <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('officetel');?></span>
                                      </div>
                                      </th>
                                      <?php }}else if(($creator['id']=='10')){ ?>
                                      <th width="15%" scope="row" style="text-align:left;">
                                      <div style="position: relative;">
                                      <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                      <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                      <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('candidateid');?></span>
                                      </div>
                                      </th>
                                      <th width="20%" style="text-align:left;">
                                      <div style="position: relative;">
                                      <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                      <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                      <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('fullname');?></span>
                                      </div>
                                      </th>
                                      <?php } */ ?>	
                                <?php if ($viewreport['cname_statistics'] != '0') { ?>
                                        <th width="24%" scope="row" style="text-align:left;">
                                    <div style="position: relative;">
                                        <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                        <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                        <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?= get_string('categoryname'); ?></span>
                                    </div>                  
                                    </th>
                                <?php } if ($viewreport['ccode_statistics'] != '0') { ?>
                                    <th width="10%" style="text-align:left;">
                                    <div style="position: relative;">
                                        <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                        <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                        <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?= get_string('curriculumcode'); ?></span>
                                    </div>              
                                    </th>
                                <?php } if ($viewreport['statusstistics'] != '0') { ?>
                                    <th width="14%" style="text-align:left;">
                                    <div style="position: relative;">
                                        <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                        <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                        <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?= get_string('resetstatus'); ?></span>
                                    </div>            
                                    </th> 
                                <?php } if ($viewreport['mcomplete_statistics'] != '0') { ?>   
                                    <th width="15%" style="text-align:left;">
                                    <div style="position: relative;">
                                        <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                        <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                        <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?= get_string('modulescompleted'); ?></span>
                                    </div>          
                                    </th>
                                <?php } if ($viewreport['examstatus_statistics'] != '0') { ?>
                                    <th width="14%" style="text-align:left;">
                                    <div style="position: relative;">
                                        <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                        <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                        <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?= get_string('examstatus'); ?></span>
                                    </div>             
                                    </th>
                                <?php } if ($viewreport['totaltime_statistics'] != '0') { ?>
                                    <th width="25%" style="text-align:left;">
                                    <div style="position: relative;">
                                        <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                        <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                        <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?= get_string('totaltime'); ?></span>
                                    </div>             
                                    </th>
                                <?php } ?>		  
                                </tr>
                                <?php
                                $mycount = mysql_num_rows($sqlquery);
                                $no = '1';
                                if ($mycount != '0') {
                                    while ($sqlrow = mysql_fetch_array($sqlquery)) {
                                        $bil = $no++;

                                        //country list
                                        $countrylistsql = mysql_query("SELECT * FROM {$CFG->prefix}country_list WHERE countrycode='" . $sqlrow['country'] . "'");
                                        $countrylist = mysql_fetch_array($countrylistsql);

                                        // candidate fulladdress.
                                        $fulladdress = ucwords(strtolower($sqlrow['address'] . ' ' . $sqlrow['address2'] . ' ' . $sqlrow['address3'] . ', ' . $sqlrow['postcode'] . ' ' . $sqlrow['city'] . ' ' . $sqlrow['state'] . ', ' . $countrylist['countryname']));
                                        // echo $sqlrow['enrolid'];
                                        //total user enroll courses
                                        $sqlstatus = mysql_query("
		Select
		  c.id As enrollmentid,
		  a.fullname,
		  a.idnumber,
		  b.id,
		  c.userid as statususerid
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifaenrol b On a.id = b.courseid Inner Join
		  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
		  mdl_cifareport_users d On c.userid = d.candidateid Inner Join
		  mdl_cifauser e On d.candidateid = e.id
		Where
		  a.category = '1' And
		  d.reportid = '" . $sqlrow['reportid'] . "' And
		  a.visible != '0' And c.enrolid='" . $sqlrow['enrolid'] . "'	
	");
                                        $sqlstatusrow = mysql_num_rows($sqlstatus); // echo $sqlrow['enrolid'].'<br/>';
                                        // total time accessing course
                                        if ($data['firstaccess']) {
                                            $totaltimeaccess = format_time(time() - $data['firstaccess']);
                                        } else {
                                            $totaltimeaccess = "0";
                                        }

                                        // display learning outcome
                                        $losql = mysql_query("
		Select
		  b.name,
		  b.course,
		  a.idnumber,
		  b.reference
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifascorm b On a.id = b.course
		Where
		  a.idnumber = '" . $sqlrow['coursecode'] . "' AND b.reference!='navigation_tips.zip'	
		Order By b.name
	");
                                        $no = '1';
                                        $losqlcount = mysql_num_rows($losql);
                                        // END display learning outcome 
                                        ?>
                                        <tr>
                                                <?php /* if(($creator['id']=='12') || ($creator['id']=='13')){ ?>
                                                  <?php if($viewreport['candidateID']!='0'){ ?>
                                                  <td style="text-align:center" scope="row"><?=strtoupper($sqlrow['traineeid']);?></td>
                                                  <?php }if($viewreport['candidateFullname']!='0'){ ?>
                                                  <td><?//=ucwords(strtolower($sqlrow['firstname'].' '.$sqlrow['lastname']));?></td>
                                                  <?php }if($viewreport['candidateEmail']!='0'){ ?>
                                                  <td style="text-align:center" scope="row"><?//=$sqlrow['email'];?></td>
                                                  <?php }if($viewreport['candidateAddress']!='0'){ ?>
                                                  <td><?//=$fulladdress;?></td>
                                                  <?php }if($viewreport['candidateTel']!='0'){ ?>
                                                  <td><?//='+'.$countrylist['iso_countrycode'].$sqlrow['phone1'];?></td>
                                                  <?php }}else if(($creator['id']=='10')){ ?>
                                                  <td style="text-align:center" scope="row"><?//=strtoupper($sqlrow['traineeid']);?></td>
                                                  <td><?//=ucwords(strtolower($sqlrow['firstname'].' '.$sqlrow['lastname']));?></td>
                                                  <?php } */ ?>


                                                <?php if ($viewreport['cname_statistics'] != '0') { ?>
                                                <td style="text-align:left" scope="row">
                                                    <?= $sqlrow['fullname']; ?>
                                                </td>
                                                <?php } if ($viewreport['ccode_statistics'] != '0') { ?>
                                                <td><?= $sqlrow['coursecode']; ?></td>
                                            <?php } if ($viewreport['statusstistics'] != '0') { ?>
                                                <td style="text-align:left; padding-left:0.5em;">
                                                    <?php
                                                    // total active users
                                                    $sqlusers = mysql_query("SELECT * FROM {$CFG->prefix}user WHERE confirmed='1' AND deleted!='1' AND usertype='Active Candidate'");
                                                    $sqlusersrow = mysql_num_rows($sqlusers);

                                                    // total users enrol test
                                                    $sqltestcheck = mysql_query("
						Select
						  a.name,
						  b.userid,
						  c.grade
						From
						  mdl_cifaquiz a Inner Join
						  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
						  mdl_cifaquiz_grades c On b.userid = c.userid And b.quiz = c.quiz
						Where
						  a.name = '" . $sqlrow['fullname'] . "' 
						Group By a.id, b.userid
					");
                                                    $sqltestrow = mysql_num_rows($sqltestcheck);
                                                    $inprogress = (($sqlstatusrow - $sqltestrow) / $sqlstatusrow) * 100;
                                                    $completed = ($sqltestrow / $sqlstatusrow) * 100;
                                                    $subscribed = ($sqlstatusrow / $sqlusersrow) * 100; // jum. enroll courses bahagi jum. user

                                                    echo "Subscribed - " . round($subscribed) . "% <br/>";
                                                    echo "In Progress - " . round($inprogress) . "% <br/>";
                                                    echo "Completed - " . round($completed) . "%";
                                                    ?>         
                                                </td>
                                                <?php } if ($viewreport['mcomplete_statistics'] != '0') { ?>
                                                <td style="text-align:center">
                                                    <?php
                                                    // display module completed %
                                                    if ($losqlcount != '0') {
                                                        $bil = '1';
                                                        while ($lo = mysql_fetch_array($losql)) {
                                                            //echo $lolist=$lo['name'];
                                                            //echo $lolist='- %';
                                                            $no = $bil++;
                                                            if ($no < '10') {
                                                                $a = '0';
                                                            }

                                                            ////////	
                                                            $moduleselect = " a.course, b.value, a.name, b.scormid, b.userid, b.element, a.reference";
                                                            $modulestatement = "
					  mdl_cifascorm a Inner Join
					  mdl_cifascorm_scoes_track b On a.id = b.scormid
					Where
					  a.course = '" . $sqlrow['courseid'] . "' And
					  b.element = 'cmi.core.lesson_status' And
					  (a.reference != 'navigation_tips.zip' And a.reference='" . $lo['reference'] . "')				
				";
                                                            // total module in courses
                                                            $totalmodulestatussql = mysql_query("Select {$moduleselect} From {$modulestatement}");
                                                            $totalmodulestatus = mysql_num_rows($totalmodulestatussql);

                                                            // complete module	
                                                            $totalmodulecomplete = mysql_query("Select {$moduleselect} From {$modulestatement} And b.value='completed'");
                                                            $totalmodulecompleterow = mysql_num_rows($totalmodulecomplete);
                                                            $mpercent = ($totalmodulecompleterow / $totalmodulestatus) * 100;

                                                            $modulelist = 'M' . $a . $no . ' - ' . round($mpercent) . '% <br/>';
                                                            echo $modulelist;
                                                        }
                                                    } else {
                                                        echo ' - ';
                                                    }
                                                    ?>
                                                </td>
                                                <?php } if ($viewreport['examstatus_statistics'] != '0') { ?>
                                                <td style="text-align:left; padding-left:0.5em;">
                                                    <?php
                                                    // SQL total candidate PASS
                                                    $gradepass = mysql_query("						  
					Select
					  d.grade,
					  d.userid,
					  d.quiz,
					  b.name,
					  c.attempt,
					  a.category,
					  a.visible,
					  e.reportid
					From
					  mdl_cifacourse a Inner Join
					  mdl_cifaquiz b On a.id = b.course Inner Join
					  mdl_cifaquiz_attempts c On b.id = c.quiz Inner Join
					  mdl_cifaquiz_grades d On c.quiz = d.quiz And c.userid = d.userid Inner Join
					  mdl_cifareport_users e On e.candidateid = d.userid
					Where
					  d.grade >= '60' And
					  a.visible != '0' And
					  e.reportid = '" . $sqlrow['reportid'] . "' And
					  b.name  = '" . $sqlrow['fullname'] . "'
					group by d.quiz
					 
				");
                                                    $gradepasssql = mysql_num_rows($gradepass);

                                                    // SQL grade fail
                                                    $gradefailsql = mysql_query("						  
					Select
					  d.grade,
					  d.userid,
					  d.quiz,
					  b.name,
					  c.attempt,
					  a.category,
					  a.visible,
					  e.reportid
					From
					  mdl_cifacourse a Inner Join
					  mdl_cifaquiz b On a.id = b.course Inner Join
					  mdl_cifaquiz_attempts c On b.id = c.quiz Inner Join
					  mdl_cifaquiz_grades d On c.quiz = d.quiz And c.userid = d.userid Inner Join
					  mdl_cifareport_users e On e.candidateid = d.userid
					Where
					  d.grade < '60' And
					  a.visible != '0' And
					  e.reportid = '" . $sqlrow['reportid'] . "' And
					  b.name  = '" . $sqlrow['fullname'] . "'
					group by d.quiz
					 
				");
                                                    $gradefail = mysql_num_rows($gradefailsql);

                                                    $absent = $sqlstatusrow - ($gradepasssql + $gradefail);

                                                    $gradepasspercent = ($gradepasssql / $sqlstatusrow) * 100;
                                                    $gradefailpercent = ($gradefail / $sqlstatusrow) * 100;
                                                    $absentpercent = ($absent / $sqlstatusrow) * 100;
                                                    $expiredpercent = 100 - ($gradepasspercent + $gradefailpercent + $absentpercent);

                                                    echo "Pass - " . round($gradepasspercent) . "% <br/>";
                                                    echo "Fail - " . round($gradefailpercent) . "% <br/>";
                                                    echo "Absent - " . round($absentpercent) . "% <br/>";
                                                    echo "Expired - " . round($expiredpercent) . "%";
                                                    ?>       
                                                </td>
            <?php } if ($viewreport['totaltime_statistics'] != '0') { ?>
                                                <td><?= $totaltimeaccess; ?></td>
            <?php } ?>
                                        </tr>

            <?php
        }
    } else {
        ?>
                                    <tr><td colspan="15" scope="row">Records not found</td></tr>
    <?php } ?>
                            </table><br/><br/></form> 
                        <!--/fieldset-->   
<?php } ?>
            </td></tr></table>