<body onLoad="window.print()">
<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	$titleccmanagement=get_string('cifacandidatemanagement');
    echo '<div style="padding-left:2.2em;">'.$OUTPUT->heading($titleccmanagement, 2, 'headingblock header').'</div>';
  
	$chooseprogramid=$_GET['programid'];
	$candidatedetails=$_GET['candidatedetails']; 
	$candidatedetails_s=$_GET['candidatedetails_s'];	

	//to get a role name
	$squery=mysql_query("SELECT name FROM {$CFG->prefix}role WHERE id='5'");
	$sqlrole=mysql_fetch_array($squery);
	$usertypename=$sqlrole['name'];
	
	//to get list of users with token
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken e On b.courseid = e.courseid And e.userid = d.id	
	";
	
	$statement.=" WHERE a.category = '3' AND d.usertype='".$usertypename."'";
	if($candidatedetails_s!=''){
		// $statement.=" AND {$candidatedetails} LIKE '%{$candidatedetails_s}%'";
		if($candidatedetails=='dob'){
			$statement.=" AND ((date_format(from_unixtime(d.dob), '%d/%m/%Y') LIKE '%{$candidatedetails_s}%'))";
		}else{
			$statement.=" AND {$candidatedetails} LIKE '%{$candidatedetails_s}%'";
		}
	}
	
	if($chooseprogramid!=''){
		$statement.=" AND b.courseid='".$chooseprogramid."'";
	}
	
	$csql="SELECT *, c.timestart as enroltime, a.id as examid, e.id as token_id, d.timecreated as utimecreated FROM {$statement} ORDER BY d.traineeid ASC";
	$sqlquery=mysql_query($csql);	
?>
<table width="95%" border="1" cellpadding="0" cellspacing="0" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;" class="header">
		  <th width="11%" scope="row" style="text-align:left;">
            <div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">Candidate ID</span>
            </div>           
          </th>
		  <th width="20%" style="text-align:left;">
            <div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">First Name</span>
            </div>           
          </th>
		  <th width="20%" style="text-align:left;">
            <div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">Last Name</span>
            </div>           
          </th>
		  <th width="10%" style="text-align:left;">
            <div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">DOB</span>
            </div>           
          </th>
		  <th style="text-align:left;">
            <div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">CIFA&#8482; Examination Title</span>
            </div>          
          </th>
		  <th width="15%" style="text-align:left;">
            <div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">Token Expiry</span>
            </div>           
          </th>
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil=$no++;
?>
		<tr>
		  <td scope="row" align="center"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td style="padding-left:0.3em;"><?=ucwords(strtolower($sqlrow['firstname']));?></td>
		  <td style="padding-left:0.3em;"><?=ucwords(strtolower($sqlrow['lastname']));?></td>
		  <td style="text-align:center"><?=date('d/m/Y', $sqlrow['dob']);?></td>
		  <td style="padding-left:0.3em;"><?=$sqlrow['fullname'];?></td>
		  <td style="text-align:center">
		  <?//=date('d/m/Y H:i:s', $sqlrow['tokenexpiry']);?>
			<?php
                $utimecreated=date('d/m/Y H:i:s', $sqlrow['utimecreated']);
				echo $utokenexpiry=date('d/m/Y H:i:s', strtotime($utimecreated . " + 1 year"));
            ?>          
          </td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="8" scope="row"><?=get_string('searchresultnotfound');?></td></tr>
<?php } ?>
		</table><br/>