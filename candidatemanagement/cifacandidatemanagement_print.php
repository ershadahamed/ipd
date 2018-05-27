<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	// require_once($CFG->dirroot .'/lib/blocklib.php'); 
	// require_once($CFG->dirroot .'/course/lib.php');
	// require_once($CFG->libdir .'/filelib.php');
	
	//include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = get_string('cifacandidatemanagement');
    $PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
?>
<style type="text/css">
<?php 
	include('../institutionalclient/style.css');
?>

	html, body, table tr, td, th{
		font-family: Verdana,Geneva,sans-serif;
		font-size:0.9em; 
	}
a:hover {text-decoration:underline;}
#searchtable td, th{	 
	border: 1px solid #666666;
	border-collapse:collapse; 
}

td { padding:3px;}
</style>
<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAll () {
	if (checked == false){checked = true}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
		//document.getElementById('download_button').disabled=false;
	}
}
//  End -->
 function clearSelected(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
		//document.getElementById('download_button').disabled=true;
	}
  }
</script>

<!--form name="form" id="form" action="<?//=$CFG->wwwroot. '/offlineexam/download_token.php'; ?>" method="post"-->
<br/>
<body onload="window.print();">


<style type="text/css">
    img.table-bg-image {
        position: absolute;
        z-index: -1;
		width:100%;
		/* min-height:837px; */
		height:98%;
		margin-bottom:0px;
		padding-bottom:0px;
    }
    table.with-bg-image, table.with-bg-image tr, table.with-bg-image td {
        background: transparent;
    }
</style>
<img class="table-bg-image" src="<?=$CFG->wwwroot;?>/image/bg_statement.png"/>
<table class="with-bg-image" width="100%"><tr><td><br/>
<table id="policy" width="100%" border="0"  style="padding:0px;">
  <tr valign="top">
    <td align="left" valign="middle" style="font-size:0.9em;"><?=get_string('ipdaddress');?></td>
    <td align="right" style="width:50%"><img style="width:134px;" src="<?=$CFG->wwwroot;?>/image/CIFALogo.png"></td>
  </tr>
</table>
<div style="width:95%;margin:0px auto;"><h3><?=get_string('cifacandidatedatabase');?></h3></div>
<form name="form" id="form" action="" method="post">
<?php 
	$chooseprogramid=$_GET['programid'];
	$candidatedetails=$_GET['candidatedetails']; 
	$candidatedetails_s=$_GET['candidatedetails_s'];
?>
</form>
<form name="form1" id="form1" action="" method="post">	
<?php
	$statement="
		  mdl_cifacourse a Inner Join
		  mdl_cifaenrol b On a.id = b.courseid Inner Join
		  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
		  mdl_cifauser d On c.userid = d.id
	";
	
	$statement.=" WHERE  b.status='0' AND b.enrol='manual' AND (d.usertype='Active candidate' OR d.usertype='Inactive candidate' OR d.usertype='Prospect') 
				AND d.id != '2' And d.deleted != '1' And d.confirmed = '1' And d.id != '1' And a.category='1'";
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
	$csql="SELECT b.courseid, d.traineeid, d.firstname, d.lastname, d.dob, a.fullname, d.usertype, d.id as userid FROM {$statement}";
	$csql.=" GROUP BY d.traineeid ORDER BY d.traineeid";
	$sqlquery=mysql_query($csql);	
?>	
	
	  <table width="95%" border="1" id="searchtable" style="border-collapse:collapse;margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th width="15%" scope="row" style="text-align:left;">
			<div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.2em;">Candidate ID</span>
            </div> 			  
		  </th>
		  <th width="15%" style="text-align:left;">
		  	<div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">First Name</span>
            </div> 
		  </th>
		  <th width="15%" style="text-align:left;">
		  	<div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">Last Name</span>
            </div> 		  
		  </th>
		  <th width="8%" style="text-align:left;">
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
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">CIFA&#8482; Program Title</span>
            </div> 		  
		  </th>
		  <th width="10%" style="text-align:left;">
		  	<div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">Status</span>
            </div> 		  
		  </th>
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$linkto=$CFG->wwwroot. "/candidatemanagement/candidateexamsummary.php?id=".$sqlrow['userid']."&examid=".$sqlrow['courseid'];
	$linktitle="Clickable and takes to ".get_string('candidateexamsummary');
	$bil=$no++;
?>
		<tr>
		  <td scope="row" align="center"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname']));?></td>
		  <td><?=ucwords(strtolower($sqlrow['lastname']));?></td>
		  <td style="text-align:center"><?=date('d/m/Y', $sqlrow['dob']);?></td>
		  <td>
			<?php
				//list out cifa program title
				$enrolsql=mysql_query("
					Select
					  *
					From
					  mdl_cifacourse a Inner Join
					  mdl_cifaenrol b On a.id = b.courseid Inner Join
					  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
					  mdl_cifauser d On c.userid = d.id
					Where
					  c.userid = '".$sqlrow['userid']."' And
					  b.enrol = 'manual' And
					  a.category = '1' And
					  a.visible = '1' And
					  b.status = '0'				
				");
				while($euser=mysql_fetch_array($enrolsql)){
				echo '- '.$euser['fullname'].'<br/>';
				}
			?>
			<?//=$sqlrow['fullname'];?>
		  </td>
		  <td style="text-align:center"><?=$sqlrow['usertype'];?></td>		
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="6" scope="row">Records not found</td></tr>
<?php } ?>
		</table></form>	  </td></tr></table> 