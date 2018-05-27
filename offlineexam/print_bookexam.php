<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = get_string('candidateexamsummary');
    $PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
?>
<body onLoad="javascript:window.print()">
<style type="text/css">
<?php 
	include('../institutionalclient/style.css');
?>
	a:hover {text-decoration:underline;}
	#searchtable td, th{	 
		border: 1px solid #666666;
		border-collapse:collapse; 
	}	
</style>
  <table width="95%" border="0" style="margin:0px auto;"><tr><td>
<h3>Online Examination Booked</h3>

  <table width="100%" border="1" id="searchtable" style="margin:0px auto;">
    <tr align="center" style="background-color:#ccc;">
      <th width="10%" scope="row">Candidate ID</th>
      <th width="15%">First Name</th>
      <th width="15%">Last Name</th>
      <th width="20%">CIFA&#8482; Examination Title</th>
      <th width="10%">Token Expiry</th>
      <th width="10%">Exam Date</th>
      <th width="10%">Exam Time</th>
    </tr>
<?php
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken e On b.courseid = e.courseid And e.userid = d.id	
	";
	
	$statement.=" WHERE a.category = '3' AND d.usertype='Active Candidate' And e.bookexam='0' And e.bookstatus='1'";
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";

	$sqlquery=mysql_query($csql);
	while($sqlrow=mysql_fetch_array($sqlquery)){
?>
    <tr>
      <td style="text-align:center;" scope="row"><?=$sqlrow['traineeid'];?></td>
      <td><?=$sqlrow['firstname'];?></td>
      <td><?=$sqlrow['lastname'];?></td>
      <td><?=$sqlrow['fullname'];?></td>
      <td style="text-align:center;"><?=date('d/m/Y H:i:s', $sqlrow['tokenexpiry']);?></td>
      <td style="text-align:center;"><?=$sqlrow['examdate'];?></td>
      <td style="text-align:center;"><?=$sqlrow['examtime'];?></td>
    </tr>
<?php } ?>
</table>
</td></tr></table>