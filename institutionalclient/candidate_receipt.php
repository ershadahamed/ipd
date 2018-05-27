<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<style type="text/css">
<?php include('style.css'); ?>
</style>
<body>
<?php 
	require_once('../config.php');
	require_once('../manualdbconfig.php');
?>
<?php
		function unix_timestamp_to_human ($timestamp = "", $format = 'D, d M Y')
	{
		if (empty($timestamp) || ! is_numeric($timestamp)) $timestamp = time();
		return ($timestamp) ? date($format, $timestamp) : date($format, $timestamp);
	}
?>
<?php
	$ID=$_GET['id'];
	$courseID=$_GET['token'];
	
	$sql="Select *, date_format(from_unixtime(c.dob), '%Y-%m-%d') as dob From mdl_cifacourse a, mdl_cifa_modulesubscribe b, mdl_cifauser c 
			WHERE c.id='".$ID."' And b.courseid='".$courseID."' And b.payment_status='Paid' And   a.id = b.courseid And b.traineeid = c.traineeid And (a.category = '1')";
	$query=mysql_query($sql);
	$checkrow=mysql_fetch_array($query);
?>
<br/>
<table id="tableluar" border="1" align="center" cellpadding="0" cellspacing="0" ><tr><td>
<table width="700" id="tabledalam">
  <tr><td colspan="3" valign="middle">
  
  <table border="0" cellpadding="0" cellspacing="0" align="center">
 	 <tr>
     	<td><img src="Images/shape.png" width="200" /></td>
     </tr>
  </table>
  
  </td>
  </tr>
  <tr><td colspan="3">&nbsp;</td></tr>
  <tr>
    <th width="23%">Date</th>
    <th width="1%">:</th>
    <td><?php $today = strtotime('now'); echo unix_timestamp_to_human($today); ?></td>
  </tr>
  <tr>
    <th>Candidate ID</th>
    <th>:</th>
    <td><?php echo $checkrow['traineeid']; ?></td>
  </tr>
  <tr>
    <th>Candidate Name</th>
    <th>:</th>
    <td><?php echo $checkrow['firstname'].' '.$checkrow['lastname']; ?></td>
  </tr>
  <tr>
    <th>D.O.B</th>
    <th>:</th>
    <td><?php echo $checkrow['dob']; ?>	<?php 
		//$unix_time=$checkrow['dob'];
		//echo unix_timestamp_to_human($unix_time);
	?></td>
  </tr>
  <tr>
    <th>LMS Token</th>
    <th>:</th>
    <td>
		<?php 

		//generate number token date_format(from_unixtime(dateregister), '%Y-%m-%d')
		$sa = $checkrow['traineeid'];
		$f = $sa + 1;
		$a = 'CIFA';
		$c = date('Y');
		$e = date('m');
		$traineeid=$checkrow['traineeid'];
		$examid=$checkrow['courseid'];
	
		if($f<10 && $examid<10)
			$d = '0000';
		else if($f<100 && $examid<100)
			$d = '000';
		else if($f<1000 && $examid<1000)
			$d = '00';
		else if($f<10000)
			$d = '0';
		else{
			}
										
		$generate_token = $a.'_'.$d.$examid.'_'.$traineeid.' / '.$c.' '.$e;	
		echo $generate_token;
	?>
	</td>
  </tr>
  <tr><td colspan="3">&nbsp;</td></tr>
</table>
</td></tr></table>

<!--signatures--->
<table class="institutionallist" style="border: 0px;">
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td>Printed by</td><td>:</td><td><?php echo $USER->firstname.' '.$USER->lastname; ?></td></tr>
</table>

<table class="buttoncetak">
  <tr><td colspan="3"><div align="center">
    <input type="button" name="PRINT" value="PRINT" onClick="window.print()" />
  </div></td></tr>
</table>
</table>
</body>
</html>
