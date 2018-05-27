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
	newwindow=window.open(url,'name','height=600,width=1000,status=1,scrollbars=1');
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

<fieldset>
<form method="post">

<table style="margin: 10px auto; width:95%; font:13px/1.231 arial,helvetica,clean,sans-serif bolder;">
	<tr valign="top">
<?php
	$success_msg=$_GET['success'];
	$unsuccessful=$_GET['unsuccessful'];
	$success_update=$_GET['success_update'];
	$tokenupdate=$_GET['token'];
	
	if($success_msg == '1'){ 
		echo '<b><font color="red">Record have been successfull remove..</font></b>';
	}
	if($unsuccessful == '0'){
		echo 'Record fail to remove..';
	}
	if($success_update == '1'){
		echo '<b><font color="red">Record have been update..</font></b>';
	}	
?>
	</tr>	
</table>

<table border="0" cellpadding="1" cellspacing="1" style="margin: 10px auto; width:95%; font:13px/1.231 arial,helvetica,clean,sans-serif bolder;">
	<tr>
		<!--td width="15%"><?//=get_string('candidateid');?></td><th width="1%">:</th-->
		<td style="width:180px;text-align:right;">
		<select name="pilihancarian" style="width:180px;">
			<option value=""></option>
			<option value="traineeid"><?=get_string('candidateid');?></option>
			<option value="firstname"><?=get_string('firstname');?></option>
			<!--option value="dob"><?//=get_string('dob');?></option-->
		</select>
		</td>
		<td width="10%"><input type="text" name="traineeid" style="width:250px;" /></td>
		<td>&nbsp; AND<!--input type="submit" name="search" value="<?//=get_string('search');?>"/--></td>
	</tr>	
	<tr>
		<td style="width:180px;text-align:right;">
		<select name="pilihancarian2" style="width:180px;">
			<option value=""></option>
			<option value="traineeid"><?=get_string('candidateid');?></option>
			<option value="firstname"><?=get_string('firstname');?></option>
			<!--option value="dob"><?//=get_string('dob');?></option-->
		</select>
		</td>
		<td width="10%"><input type="text" name="carian2" style="width:250px;" /></td>
		<td><input type="submit" name="search" value="<?=get_string('search');?>"/></td>
	</tr>	
</table>
</form>

<?php 
	$selectsearch=$_POST['pilihancarian'];
	if($_POST['pilihancarian'] == 'dob'){ $candidateid=strtotime($_POST['traineeid']); echo $candidateid; }else{ $candidateid=$_POST['traineeid']; }
	$selectsearch2=$_POST['pilihancarian2']; 
	if($_POST['pilihancarian2'] == 'dob'){ $carian2=strtotime($_POST['carian2']); }else{ $carian2=$_POST['carian2']; }	
?>
<table id="listcandidate" border="1">
<tr>
	<th width="1%">No.</th>
	<th width="10%"><?=get_string('candidateid');?></th>
	<th><?=get_string('firstname');?> / <?=get_string('lastname');?></th>
	<th width="15%"><?=get_string('tokenid');?></th>
	<th width="15%"><?=get_string('programcodename');?></th>
	<th width="15%"><?=get_string('membershipexpiry');?></th>
	<th width="15%"><?=get_string('tokenexpiry');?></th>	
	<!--th width="1%"><?//=get_string('misc.');?></th-->	
</tr>
<?php
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $limit = 10;
    $startpoint = ($page * $limit) - $limit;	
	
	//$statement="mdl_cifacourse a, mdl_cifa_modulesubscribe b, mdl_cifauser c, mdl_cifauser_enrolments d, mdl_cifaenrol e WHERE   a.id = b.courseid And b.traineeid = c.traineeid And d.enrolid = e.id And c.id = d.userid And b.courseid=e.courseid And (e.enrol = 'paypal' And a.category='1')";
	$examcenterid=$USER->id;
	$statement="{$CFG->prefix}user a, {$CFG->prefix}user_accesstoken b WHERE a.id=b.userid AND b.centerid='".$examcenterid."'";
	if($candidateid==''){$statement.= " GROUP BY a.traineeid";}
	if($candidateid!='' && $selectsearch!='' && $carian2!='' && $selectsearch2!=''){$statement.= " And a.access_token!='' And (a.$selectsearch LIKE '%".$candidateid."%' AND a.$selectsearch2 LIKE '%".$carian2."%') GROUP BY a.traineeid";}
	$sqlquery=mysql_query("Select * From {$statement}  LIMIT {$startpoint}, {$limit}");
	$rsCount=mysql_num_rows($sqlquery);
	if($rsCount >=1){
	$bill=0;
	while($sqlRowStudent=mysql_fetch_array($sqlquery)){
	$startdate=date('d-m-Y H:i:s',$sqlRowStudent['timecreated']);
	$firstaccess=date('d-m-Y H:i:s',$sqlRowStudent['timecreated_token']);
	$bill++;	
?>
<tr <?php if($sqlRowStudent['access_token'] == $tokenupdate){ echo 'style="background-color:#66FF66;"';} ?>>
	<td align="center"><?php echo $bill+( $startpoint); ?></td>
	<td align="center"><input type="hidden" name="id" value="<?php $sqlRowStudent['courseid']; ?>" /><?php echo strtoupper($sqlRowStudent['traineeid']); ?></td>
	<td>
		<?php 
			$firstname = $sqlRowStudent['firstname'];
			$lastname=$sqlRowStudent['lastname'];
			$today=strtotime('now');
			$fullusername=$firstname.' '.$lastname;
			echo ucwords(strtolower($fullusername)); 
		?>
	</td>
	<td><?php echo $sqlRowStudent['access_token']; ?></td>
	<td>
		<?php
			//program code
			$sql=mysql_query("SELECT * FROM mdl_cifacourse WHERE id='".$sqlRowStudent['courseid']."'");
			$sqlquery2=mysql_fetch_array($sql);
			echo $sqlquery2['shortname'];
		?>
	</td>
	<td align="center">
		<?php 
			//membership expiry
			$membershipexpiry=date('d-m-Y H:i:s',strtotime($startdate . " + 1 year")); 
			echo $membershipexpiry;
			//echo date('d-m-Y H:i:s',strtotime($startdate . " + 1 year")); 
		?>
	</td>
	<td align="center">
		<?php 
			//token expiry
			if($sqlRowStudent['timecreated_token'] != ''){
				$tokenexpiry=date('d-m-Y H:i:s',strtotime($firstaccess . " + 18 month")); 
				echo $tokenexpiry;
			}
		?>
	</td>		
	<!--td>
		<?php
			//certificated//echo $sqlRowStudent['timecreated'].'<br/>'.strtotime($membershipexpiry);
			/* if($sqlRowStudent['timecreated']<=$today && $today <= strtotime($membershipexpiry)){
		?>
			<a href="certificate.php?id=<?php echo $sqlRowStudent['traineeid']; ?>" onclick="return popitup('certificate.php?id=<?php echo $sqlRowStudent['traineeid']; ?>')"><?=get_string('certificate');?> </a>
		<?php 
			}else{ 
				$alertlink='alert("'.get_string('alertmessage').'")';
				echo "<a href='#' onClick='".$alertlink."'>".get_string('certificate').'</a>'; 
			} */ 
		?>
	</td-->
</tr>
<?php  } }else{ ?>
<tr>
	<td colspan="7"><?=get_string('norecords');?></td>
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