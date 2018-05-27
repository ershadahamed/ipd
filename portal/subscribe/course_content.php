<?php include('pageconfig/contentHeader.php'); ?>
<br/>
<?php 
	include('../manualdbconfig.php');
	$sql_1 = mysql_query("SELECT * FROM mdl_cifacourse ORDER BY id DESC");
	$row1 = mysql_fetch_array($sql_1);	
	if($row1['course_type'] == 'coursecontent' ){
	
	$sql_ = mysql_query("SELECT * FROM mdl_cifacourse WHERE course_type='coursecontent' ORDER BY id DESC");
	while ($row = mysql_fetch_array($sql_)){ 
?>
<table width="100%" border="0">
  <tr>
    <td width="24%"><h6>Course Name</h6></td>
    <td width="1%">:</td>
    <td><?php echo $row['fullname']; ?></td>
  </tr>
  <tr>
    <td width="19%">Course Level</td>
    <td width="1%">:</td>
    <td><?php echo $row['course_level']; ?></td>
  </tr>
  <tr valign="top">
    <td width="19%">Course Content</td>
    <td width="1%">:</td>
    <td>
	<?php 
		$id = $row['id'];
		$sql_1 = mysql_query("SELECT * FROM mdl_cifapage WHERE course='$id'");
	?>
    <?php $row_1 = mysql_fetch_array($sql_1); ?>
	<?php echo $row_1['intro']; ?>
    </td>
  </tr>
<?php }}else{ ?>
	<tr>
		<td colspan='3'>No available course content<br/></td>
	</tr>
<?php } ?>
</table>
<br/>
<?php include('pageconfig/contentFooter.php'); ?>

