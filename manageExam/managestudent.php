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
	
    $listusertoken = 'Manage Candidate for Exam Registration';
    $PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	
    echo $OUTPUT->header();
    echo $OUTPUT->heading('Manage Candidate for Exam Registration', 2, 'headingblock header');
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
	<tr>
		<td width="10%">Candidate ID</td><td width="1%">:</td>
		<td colspan="2"><input type="text" name="traineeid" /></td>
	</tr>	
	<tr>
		<td width="10%">Payment Status</td><td width="1%">:</td>
		<td width="10%"><input type="text" name="paymentstatus" /></td>
		<td><input type="submit" name="search" value="Search"/></td>
	</tr>
</table>
</form>
<?php 
	$candidateid=$_POST['traineeid']; 
	$paymentstatus=$_POST['paymentstatus'];
?>
<table id="listcandidate" border="1">
<tr>
	<th width="1%">Num.</th>
	<th width="8%">Trainee ID</th>
	<th>Name</th>
	<th width="35%">Course Name</th>
	<th width="5%">Cost($)</th>
	<th width="13%">Payment Status</th>
	<th width="1%">#</th>
	<th width="1%">#</th>	
</tr>
<?php
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $limit = 10;
    $startpoint = ($page * $limit) - $limit;	
	
	/*$sqlAB=mysql_query("SELECT * FROM mdl_cifacourse WHERE category='3'");
	while($rsAB=mysql_fetch_array($sqlAB)){
	
	echo $rsAB['id'].' '.$rsAB['fullname'].'<br/>';
	}*/
	
	$statement="mdl_cifacourse a, mdl_cifa_modulesubscribe b, mdl_cifauser c WHERE   a.id = b.courseid And b.traineeid = c.traineeid And (a.category = '1')";
	if($candidateid!=''){$statement.= " And b.traineeid LIKE '%".$candidateid."%'";}
	if($paymentstatus!=''){$statement.= " And b.payment_status LIKE '%".$paymentstatus."%'";}
	$sqlquery=mysql_query("Select * From {$statement}  LIMIT {$startpoint}, {$limit}");
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
	<td><?php echo $sqlRowStudent['coursename']; ?></td>
	<td align="center"><?php echo $sqlRowStudent['cost']; ?></td>
	<td align="center">
		<?php 
			echo $sqlRowStudent['payment_status']; 
		?>
	</td>
	<td>
	<a href="managestudent_edit.php?id=<?php echo $sqlRowStudent['courseid']; ?>"><img src="<?php echo $CFG->wwwroot. '/image/edit.png';?>" width="20" title="Edit payment status"></a></td>
	<td><a href="managestudent_delete.php?id=<?php echo $sqlRowStudent['courseid']; ?>" onClick="javascript:return confirm('Are you really want to remove this?\nTrainee - <?=ucwords(strtoupper($sqlRowStudent['firstname'].' '.$sqlRowStudent['lastname']))?>')">
		<img src="<?php echo $CFG->wwwroot. '/image/delete.png';?>" width="20" title="Delete user from registration">
	</td>	
</tr>
<?php  } }else{ ?>
<tr>
	<td colspan="8"> No records found.</td>
</tr>
<?php  }?>
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