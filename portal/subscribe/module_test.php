<?php include('pageconfig/moduleHeader.php'); ?>	
	<br/>
	
	
	<!--********************** FORM AREA ************************************-->
	<form action="module-subscribe.php?subscribe-module-test" method="post">
	<p><strong>List of Available Module Test</strong></p>
	<table>	
	<?php
	include('../manualdbconfig.php');
	
	//check if fullpackage available
	$sql_1 = mysql_query("SELECT * FROM mdl_cifacourse ORDER BY id DESC");
	$row1 = mysql_fetch_array($sql_1);	
	if($row1['course_type'] == 'fullpackage' ){
		
		$sqlModuleTest= "Select
				  *
				From
				  mdl_cifacourse a,
				  mdl_cifaenrol b,
				  mdl_cifaquiz c
				Where
				  a.id = b.courseid And
				  b.courseid = c.course And
				  (a.category = '2' And
				  b.enrol = 'paypal' And
				  a.visible='1' And
				  b.status='0')
				Order By
				  a.id Desc";
		$queryModuleTest=mysql_query($sqlModuleTest);
		while($rowModuleTest=mysql_fetch_array($queryModuleTest)){
	?>
		<tr>
			<td>Module Test Name</td>
			<td>:</td>
			<td>
			<?php		
				echo $rowModuleTest['fullname'];
			?>
			<input type="hidden" name="fullname" value="<?php echo $rowModuleTest['fullname']; ?>">
			<input type="hidden" name="shortname" value="<?php echo $rowModuleTest['shortname']; ?>">
			<input type="hidden" name="id" value="<?php echo $rowModuleTest['courseid']; ?>">
			</td>
		</tr>
		<tr>
			<td width="30%">Test Name</td>
			<td width="1%">:</td>
			<td>
				<?php echo $rowModuleTest['name']; ?>
				<input type="hidden" name="modulename" value="<?php echo $rowModuleTest['name']; ?>">
			</td>
		</tr>
		<tr>
			<td>Attempts Allow</td><td>:</td><td><?php echo $rowModuleTest['attempts']; ?><input type="hidden" name="attempts" value="<?php echo $rowModuleTest['attempts']; ?>"></td>
		</tr>
		<tr>
			<td>Module Cost</td><td>:</td><td>
			<img alt="<?php print_string('paypalaccepted', 'enrol_paypal') ?>" src="https://www.paypal.com/en_US/i/logo/PayPal_mark_60x38.gif" title="PayPal payments accepted" align="center"/>
			&nbsp;
			<?php 
				echo $rowModuleTest['cost'].' '.$rowModuleTest['currency']; 
			?>
				<input type="hidden" name="cost" value="<?php echo $rowModuleTest['cost']; ?>">
				<input type="hidden" name="currency" value="<?php echo $rowModuleTest['currency']; ?>">
			</td>
		</tr>
		<tr><td colspan="3" align="right"><input type="submit" name="submit" value="Subscribe" title="Click 'Subscribe' to subscribe module" /></td></tr>		
	<?php  
		}
	}else{ ?>
	<tr>
		<td colspan='5'>No available module test<br/></td>
	</tr>	
	<?php  } ?>
	</table>
	</form>	
  <br/>
<?php include('pageconfig/moduleFooter.php'); ?>

