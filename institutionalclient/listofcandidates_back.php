<?php
	require_once('../config.php');
	//require_once($CFG->libdir.'/blocklib.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');

	//require_login();

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
	$listusertoken = 'List of Trainee With LMS Token';
	$PAGE->navbar->add($listusertoken);

    $PAGE->set_pagetype('site-index');
    $PAGE->set_other_editing_capability('moodle/course:manageactivities');
    $PAGE->set_docs_path('');

    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname.':'. $listusertoken);
    $PAGE->set_heading($SITE->fullname);
	
	echo $OUTPUT->header();
	echo $OUTPUT->heading(get_string('listtoken'), 2, 'headingblock header');
?>
	
<?php 
	require_once('../manualdbconfig.php');
	require_once('lmstoken.php');
?>
<style type="text/css">
<?php include('style.css'); ?>
</style>
<form action="listofcandidates.php" method="post">
<table id="listcandidate">
	<tr>
		<td width="10%">Candidate ID</td><td width="1%">:</td>
		<td><input type="text" name="candidateid" /><input type="submit" name="search" value="Search"/></td>
	</tr>
	<!--tr>
		<td width="10%">Year</td><td width="1%">:</td>
		<td>
		<select name="caritarikh">
		<option value=""> - by year - </option>
		<option value=""> 2012 </option>
		<option value=""> 2011 </option>
		</select>
		<input type="submit" name="search" value="Search"/>
		</td>
	</tr-->	
</table>
</form>

<?php 
	$candidateid=$_POST['candidateid'];
	//$dateReg=$_POST['caritarikh'];
?>

<table id="listcandidate">
  <tr>
    <th width="1%">Num.</th>
    <th>Candidate ID</th>
    <th>Candidate Name</th>
    <th>D.O.B</th>
    <th>Date Register</th>
    <th>LMS Token</th>
    <th>Receipt</th>
  </tr>
<?php
	$sql="Select * From mdl_cifainstitutionaltoken";
	$query=mysql_query($sql);
	$row=mysql_fetch_array($query);
	if($row['id'] >='1'){

	$sql2="Select *, date_format(from_unixtime(dob), '%Y-%m-%d') as dob, date_format(from_unixtime(dateregister), '%Y-%m-%d') as dateregister From mdl_cifainstitutionaltoken";
	if($candidateid!='') { $sql2 .= " Where candidateid LIKE '%".$candidateid."%'"; }
	//if($dateReg!='') { $sql2 .= " Where date_format(from_unixtime(dateregister), '%Y') as dateregister LIKE '%".$dateReg."%'"; }
	$query2=mysql_query($sql2);
	$bil=1;
	while($row2=mysql_fetch_array($query2)){
?>  
  <tr>
    <td align="center"><?php echo $bil++; ?></td>
    <td><?php echo ucwords(strtolower($row2['candidateid'])); ?></td>
    <td><?php echo ucwords(strtolower($row2['firstname'].' '.$row2['lastname'])); ?></td>
    <td align="center">
	<?php 
		echo $row2['dob'];
	?></td>
    <td align="center"><?php echo $row2['dateregister']; ?></td>
    <td><?php echo $row2['lmstoken']; ?></td>
    <td align="center"><a href="#"onclick="window.open('candidate_receipt.php?id=<?=$row2['id']?>', 'Window2', 'width=820,height=600,resizable = 1');">View & Print</a></td>
  </tr>
  <?php } }else{ ?>
  <tr>
    <td colspan="7">No Enroll Candidates Data.</td>
  </tr>
  <?php } ?>
    <tr>
    <td align="center" colspan="7">&nbsp;</td>
    <!--td align="center"><input type="submit" name="submit" value="Confirm & Generate Token" onClick="randomString();" /></td--> 
    <td align="center">
		<input type="button" name="print" value="Print All Receipt" onclick="window.open('institutional_receipt.php', 'Window2', 'width=820,height=600,resizable = 1');" />
	</td>
  </tr>
</table>
<?php
	echo '<br />';
	echo $OUTPUT->footer();
?>