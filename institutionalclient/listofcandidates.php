<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	//require_once($CFG->libdir.'/blocklib.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
	$listusertoken = 'List of Trainee With LMS Token';
	$PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	
	echo $OUTPUT->header();
	echo $OUTPUT->heading('List of Trainee With LMS Token', 2, 'headingblock header');
?>
<br/>
<style type="text/css">
<?php 
	require_once('../css/style.css'); 
	require_once('../css/style2.css'); 
	include('../css/pagination.css');
	include('../css/grey.css');
	include('../institutionalclient/style.css');
?>
</style>
<form method="post">
<table id="listcandidate">
	<tr valign="middle">
		<td width="10%">Candidate ID</td><td width="1%">:</td>
		<td width="10%"><input type="text" name="traineeid" /></td>
		<td><input type="submit" name="search" value="Search"/></td>
	</tr>	
</table>
</form>
<?php 
	$candidateid=$_POST['traineeid']; 
?>
<table id="listcandidate" border="1">
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
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $limit = 10;
    $startpoint = ($page * $limit) - $limit;	
	
	$statement="mdl_cifacourse a, mdl_cifa_modulesubscribe b, mdl_cifauser c WHERE b.payment_status='Paid' And a.id = b.courseid And b.traineeid = c.traineeid And (a.category = '1')";
	if($candidateid!=''){$statement.= " And b.traineeid LIKE '%".$candidateid."%'";}
	//if($yearReg!=''){$statement .= " AND date_format(from_unixtime(a.timecreated), '%Y')='".date('Y')."'"};
	$sqlquery=mysql_query("Select *, date_format(from_unixtime(c.dob), '%Y-%m-%d') as dob, date_format(from_unixtime(b.timecreated), '%Y-%m-%d') as timecreated From {$statement}  LIMIT {$startpoint}, {$limit}");
	$rsCount=mysql_num_rows($sqlquery);
	if($rsCount >=1){
	$bill=0;
	while($sqlRowStudent=mysql_fetch_array($sqlquery)){
	$bill++;
?>
<tr>
	<td align="center"><?php echo $bill; ?></td>
	<td align="center"><input type="hidden" name="id" value="<?php $sqlRowStudent['courseid']; ?>" /><?php echo $sqlRowStudent['traineeid']; ?></td>
	<td>
		<?php 
			$firstname = $sqlRowStudent['firstname'];
			$lastname=$sqlRowStudent['lastname'];
			$fullusername=$firstname.' '.$lastname;
			echo ucwords(strtolower($fullusername)); 
		?>
	</td>
	<td align="center"><?php echo $sqlRowStudent['dob']; ?></td>
	<td align="center"><?php echo $sqlRowStudent['timecreated']; ?></td>
	<td>
		<?php 
		$sa = $sqlRowStudent['traineeid'];
		$f = $sa + 1;
		$a = 'CIFA';
		$c = date('Y');
		$e = date('m');
		$traineeid=$sqlRowStudent['traineeid'];
		$examid=$sqlRowStudent['courseid'];
	
		if($f<10 && $examid<10)
			$d = '0000';
		else if($f<100 && $examid<100)
			$d = '000';
		else if($f<1000 && $examid<1000)
			$d = '00';
		else if($f<10000)
			$d = '0';
		else if($f<100000)
			$d = '';
		else{
			}
										
		$generate_token = $a.'_'.$d.$examid.'_'.$traineeid.' / '.$c.' '.$e;	
		echo $generate_token;  
		?>
	</td>
    <td align="center"><a href="#"onclick="window.open('candidate_receipt.php?id=<?=$sqlRowStudent['id']?>&&token=<?=$sqlRowStudent['courseid']?>', 'Window2', 'width=820,height=600,resizable = 1');">View & Print</a></td>	
</tr>
<?php  } }else{ ?>
<tr>
	<td colspan="8"> No records found.</td>
</tr>
<?php  }?>
    <tr>
    <td align="center" colspan="6">&nbsp;</td>
    <!--td align="center"><input type="submit" name="submit" value="Confirm & Generate Token" onClick="randomString();" /></td--> 
    <td align="center">
		<input type="button" name="print" value="Print All Receipt" onclick="window.open('institutional_receipt.php', 'Window2', 'width=820,height=600,resizable = 1');" />
	</td>
  </tr>
</table>

<!--table border="0" align="center"><tr><td>
<form action="<?php //echo $CFG->wwwroot.'/admin/uploaduser.php'; ?>" method="post">
    <button type="submit" class="positive" name="submit">
        <img src="<?php// $CFG->wwwroot. '/manageExam/Images/apply2.png'; ?>" alt=""/>
        Upload user
    </button>
</form>
</td></tr></table-->

<div style="margin-top:10px;">
<table align="center"><tr><td>
<?php 
	//paging numbers
	echo pagination($statement,$limit,$page); 
?>
</td></tr></table>
</div>

<?php
	echo $OUTPUT->footer();
?>