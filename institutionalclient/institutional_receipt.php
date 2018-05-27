<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<style type="text/css">
<?php include('style.css'); ?>
</style>
<?php 
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');

		function unix_timestamp_to_human ($timestamp = "", $format = 'D, d M Y')
	{
		if (empty($timestamp) || ! is_numeric($timestamp)) $timestamp = time();
		return ($timestamp) ? date($format, $timestamp) : date($format, $timestamp);
	}
?>
<table id="tableluar2"><tr><td>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr><td colspan="6" valign="middle">
  
  <table border="0" cellpadding="0" cellspacing="0" align="center">
 	 <tr>
     	<td><img src="Images/shape.png" width="200" /></td>
     </tr>
  </table>
  
  </td>
  </tr>
    <tr><td colspan="6">
	
	&nbsp;
<table class="institutionallist"  width="100%" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <th>No.</th>
    <th>Candidate ID</th>
    <th>Candidate Name</th>
    <th>D.O.B</th>
    <th>Date Register</th>
    <th>LMS Token</th>
  </tr>
<?php
	$sql2="Select *, date_format(from_unixtime(c.dob), '%Y-%m-%d') as dob, date_format(from_unixtime(b.timecreated), '%Y-%m-%d') as timecreated From mdl_cifacourse a, mdl_cifa_modulesubscribe b, mdl_cifauser c WHERE b.payment_status='Paid' And   a.id = b.courseid And b.traineeid = c.traineeid And (a.category = '1')";
	$query2=mysql_query($sql2);
	$rs=mysql_num_rows($query2);
	if($rs >='1'){
	$bil=1;
	while($row2=mysql_fetch_array($query2)){
?>  
  <tr>
    <td align="center"><?php echo $bil++; ?></td>
    <td align="center"><?php echo ucwords(strtoupper($row2['traineeid'])); ?></td>
    <td><?php echo ucwords(strtolower($row2['firstname'].' '.$row2['lastname'])); ?></td>
    <td align="center">
	<?php 
		
		echo $row2['dob'];
	?></td>
    <td align="center"><?php echo $row2['timecreated']; ?></td>
    <td>
	<?php 
		$sa = $row2['traineeid'];
		$f = $sa + 1;
		$a = 'CIFA';
		$c = date('Y');
		$e = date('m');
		$traineeid=$row2['traineeid'];
		$examid=$row2['courseid'];
	
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
  </tr>
  <?php } }else{ ?>
  <tr>
    <td colspan="7">No Enroll Candidates Data.</td>
  </tr>
  <?php } ?>
</table>

<!--signatures--->
<table class="institutionallist" style="border: 0px;">
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td>Printed by</td><td>:</td><td><?php echo $USER->firstname.' '.$USER->lastname; ?></td></tr>
<tr><td>Date</td><td>:</td><td><?php echo unix_timestamp_to_human(strtotime('now')); ?></td></tr>
</table>	

<table border="0" align="center">
    <tr>
    <td>&nbsp;</td>
  </tr>
    <tr><td><div align="center">
    <input type="button" name="PRINT" value="PRINT" onClick="window.print()" />
  </div></td></tr>
  </table>
	</td>
</tr>
</table>
</td></tr></table>
</body>
</html>
