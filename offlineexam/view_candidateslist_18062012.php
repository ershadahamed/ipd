<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	include_once ('../pagingfunction.php');
	
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	
	echo'<table style="margin: 0 auto; width:95%; font:13px/1.231 arial,helvetica,clean,sans-serif bolder;"><tr><td>';
	echo '<strong>'.ucwords(strtolower('list of candidate for exam registration')).'</strong>';
	echo '</td></tr></table>';	
?>
<br/>
<script language="javascript" type="text/javascript">
<!--
function popitup(url) {
	newwindow=window.open(url,'name','height=600,width=850,status=1,scrollbars=1');
	if (window.focus) {newwindow.focus()}
	return false;
}

// -->
</script>
<style type="text/css">
<?php 
	include('../css/pagination.css');
	include('../css/grey.css');
	include('../institutionalclient/style.css');
?>
</style>

<table style="padding-bottom: 10px; margin: 0 auto; width:95%; font:13px/1.231 arial,helvetica,clean,sans-serif bolder;">
	<tr valign="top">
		<td width="10%">Exam Name</td><th width="1%">:</th><td>
		<?php 
			$sqlselect=mysql_query("SELECT * FROM mdl_cifacourse a, mdl_cifaquiz b WHERE a.id=b.course AND (a.category='3' AND a.id='12')"); 
			$qsql=mysql_fetch_array($sqlselect);
			echo $qsql['name'];
		?>
		</td>
	</tr>	
</table>

<fieldset>
<form method="post">
<table style="margin: 10px auto; width:95%; font:13px/1.231 arial,helvetica,clean,sans-serif bolder;">
	<tr valign="top">
		<td width="15%">Candidate ID</td><th width="1%">:</th>
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
	<th width="1%">No.</th>
	<th width="10%">Candidate ID</th>
	<th>Name</th>
	<th width="20%">Token ID</th>
	<th width="18%">Start Date</th>
	<th width="18%">End Date</th>
	<th width="1%">#</th>
	<th width="1%">#</th>	
	<th width="1%">#</th>	
</tr>
<?php
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $limit = 10;
    $startpoint = ($page * $limit) - $limit;	
	
	//$statement="mdl_cifacourse a, mdl_cifa_modulesubscribe b, mdl_cifauser c, mdl_cifauser_enrolments d, mdl_cifaenrol e WHERE   a.id = b.courseid And b.traineeid = c.traineeid And d.enrolid = e.id And c.id = d.userid And b.courseid=e.courseid And (e.enrol = 'paypal' And a.category='1')";
	$statement="{$CFG->prefix}user a, {$CFG->prefix}user_accesstoken b WHERE a.id=b.userid";
	if($candidateid==''){$statement.= " GROUP BY a.traineeid";}
	if($candidateid!=''){$statement.= " And a.traineeid LIKE '%".$candidateid."%' GROUP BY a.traineeid";}
	$sqlquery=mysql_query("Select * From {$statement}  LIMIT {$startpoint}, {$limit}");
	$rsCount=mysql_num_rows($sqlquery);
	if($rsCount >=1){
	$bill=0;
	while($sqlRowStudent=mysql_fetch_array($sqlquery)){
	$startdate=date('d-m-Y H:i:s',$sqlRowStudent['timecreated']);
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
	<td><?php echo $sqlRowStudent['access_token']; ?></td>
	<td align="center"><?php echo $startdate; ?></td>
	<td align="center">
		<?php 
			echo date('d-m-Y H:i:s',strtotime($startdate . " + 1 year")); 
		?>
	</td>
	<td>
	<a href="registeration_edit.php?id=<?php echo $sqlRowStudent['courseid']; ?>" onClick="javascript:return confirm('Are you really want to edit this?\nStudent : <?=ucwords(strtoupper($sqlRowStudent['firstname'].' '.$sqlRowStudent['lastname']))?>')"><img src="<?php echo $CFG->wwwroot. '/image/edit.png';?>" width="20" border="0" title="Edit registration info"></a></td>
	<td><a href="registeration_delete.php?id=<?php echo $sqlRowStudent['courseid']; ?>" onClick="javascript:return confirm('Are you really want to remove this?\nStudent : <?=ucwords(strtoupper($sqlRowStudent['firstname'].' '.$sqlRowStudent['lastname']))?>')">
		<img src="<?php echo $CFG->wwwroot. '/image/delete.png';?>" width="20" border="0" title="Delete user from registration">
		
	</td>	
	<td><a href="certificate.php?id=<?php echo $sqlRowStudent['traineeid']; ?>" onclick="return popitup('certificate.php?id=<?php echo $sqlRowStudent['traineeid']; ?>')"><?php echo $sqlRowStudent['courseid']; ?>c </a></td>
</tr>
<?php  } }else{ ?>
<tr>
	<td colspan="8"> No records found.</td>
</tr>
<?php  }?>
</table>

<div style="margin-top:10px;">
<table align="center"><tr><td>
<?php 
	//paging numbers
	echo pagination($statement,$limit,$page); 
?>
</td></tr></table>
</div>
</fieldset>