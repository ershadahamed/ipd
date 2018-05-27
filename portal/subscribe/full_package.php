<?php include('pageconfig/fullpackageHeader.php'); ?>
<br/>
<p><strong>List of Available Fullpackage Module</strong></p>
  <p>
    <?php 
	include('../manualdbconfig.php');
	
	//*********************************************************************************************	
	$sql_ = mysql_query("Select *
						From
						  mdl_cifacourse a,
						  mdl_cifaenrol b
						Where
						  a.id = b.courseid And
						  (a.category = '1' And
						  b.enrol = 'paypal' And
						  a.visible = '1' And
						  b.status = '0')
						Order By
						  a.id Desc");	
	
	while ($row = mysql_fetch_array($sql_)){ 
	?>

	<!--form submit and view on paydetails.php -->
	<form action="payment-index.php?step1-enter-payment-information" method="post">
	<table>
		<tr>
			<td width="20%" align="right" bgcolor="#ffffff">Course Name</td><td width="1%">:</td>
			<td width="100%"><?php echo $row['fullname']; ?>
				<input type="hidden" name="id" value="<?php echo $row['courseid']; ?>"/></td>
		</tr>
		<tr><td align="right" bgcolor="#ffffff">Duration</td><td>:</td><td><?php echo $row['duration']; ?> Month</td></tr>
		<tr valign="top"><td align="right" bgcolor="#ffffff">Summary</td><td>:</td><td><div align="justify"><?php echo $row['summary']; ?></div></td></tr>
		<!--<tr><td align="right" bgcolor="#ffffff">Level</td><td>:</td><td><?php //echo $row['course_level']; ?></td></tr>
		<tr><td align="right" bgcolor="#ffffff">Prerequisite</td><td>:</td><td>Not Available</td></tr>-->
        <tr><td colspan="3" align="right"><input type="submit" name="fullpackage" value="Subscribe" title="Click subscribe to subscribe module" /></td>
        </tr>
	</table> 
	</form>
	<?php } ?>
  </p>
  <br/>
<?php include('pageconfig/fullpackageFooter.php'); ?>

