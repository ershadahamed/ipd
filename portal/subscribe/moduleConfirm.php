<?php include('pageconfig/moduleHeader.php'); ?>
<?php
	include('../manualdbconfig.php');

	$modulename=$_POST['modulename'];
	$attempts=$_POST['attempts'];
	$coursename=$_POST['coursename'];
	$shortname=$_POST['shortname'];
	$moduleCost=$_POST['cost'];
	$currency=$_POST['currency'];
	$courseID=$_POST['id'];
?>

<!--******************************************* form start here ***********************************************-->
<form action="moduleConfirm-details.php?paypal-home-page" method="post">
<h2>Module Test: &nbsp;<?php echo $coursename; ?></h2>

	<table>
		<tr bgcolor="#7F92A4"><td colspan="3"><font color="#FFFFFF" size="2em" style="font-weight:bolder;" >Details About Module Test</font></td></tr>	
		<tr>
			<td>Module Test Name</td>
			<td>:</td>
			<td>
			<?php echo $coursename; ?><input type="hidden" name="coursename" value="<?php echo $coursename; ?>" />
			</td>
		</tr>		
		<tr>
			<td width="30%">Test Name</td>
			<td width="1%">:</td>
			<td><?php echo $modulename; ?>
				<input type="hidden" name="modulename" value="<?php echo $modulename; ?>" />
				<input type="hidden" name="shortname" value="<?php echo $shortname; ?>" />
				<input type="hidden" name="courseid" value="<?php echo $courseID; ?>" />
			</td>
		</tr>	
		<tr>
			<td>Attempts Allow</td><td>:</td><td><?php echo $attempts; ?><input type="hidden" name="attempts" value="<?php echo $attempts; ?>" /></td>
		</tr>
		<tr>
			<td>Module Cost</td><td>:</td>
			<td>
				<img alt="<?php print_string('paypalaccepted', 'enrol_paypal') ?>" src="https://www.paypal.com/en_US/i/logo/PayPal_mark_60x38.gif" title="PayPal payments accepted" align="center" />
				<?php 
					echo $moduleCost.' '.$currency; 
					$PaypalBusinessEmail=$_POST['PaypalBusinessEmail'];
				?>
				<input type="hidden" name="cost" value="<?php echo $moduleCost; ?>" />
				<input type="hidden" name="currency" value="<?php echo $currency; ?>">
				<input type="hidden" name="PaypalBusinessEmail" value="<?php echo $PaypalBusinessEmail; ?>"/>
			</td>
		</tr>
	</table>

<!-- Payment Information for user to fill out -->	
<?php
	$traineeID = $_POST['traineeid'];
	$trainee_name = $_POST['name'];
	$address = $_POST['trainee_address'];
	$email = $_POST['email'];
	$phone = $_POST['phone_no'];
	
	$lastname = $_POST['lastname'];
	$address2 = $_POST['address2'];
	$province = $_POST['province'];
	$city = $_POST['city'];
	$postal = $_POST['postal'];	
	
	$fullUsername=$trainee_name.' '.$lastname;
	$fulladdress=$address.', '.$address2;
	
	//for new user, exp: prosprect trainee
	$sqlNew=mysql_query("Select traineeid From mdl_cifauser");
	$resultNew=mysql_fetch_array($sqlNew);
	if($resultNew['traineeid'] != $traineeID){
		
		$sqlInsert=mysql_query("INSERT INTO mdl_cifauser
								SET username='$traineeID', 
									password=md5('password'), 
									confirmed='1',
									mnethostid='1',
									firstname='$trainee_name',
									lastname='$lastname',
									address='$fulladdress',
									email='$email',
									phone1='$phone',
									city='$city',
									country='MY',
									timezone='8.0',
									description='Please fill up your desciption',
									descriptionformat='1',
									imagealt='$fullUsername',
									timecreated=UNIX_TIMESTAMP(),
									timemodified=UNIX_TIMESTAMP(),
									traineeid='$traineeID',
									offline_id='1',
									usertype='prospect trainee'");	
	}
?>

<p>
	<table>
	<tr bgcolor="#7F92A4"><td colspan="3"><font color="#FFFFFF" size="2em" style="font-weight:bolder;" >Payment Information</font></td></tr>
	<tr><td width="30%">Trainee ID	</td><td width="1%">:</td><td><?php echo $traineeID; ?><input type="hidden" name="traineeid" value="<?php echo $traineeID; ?>" /></td></tr>
	<tr><td>First Name			</td><td width="1%">:</td><td><?php echo $trainee_name; ?><input type="hidden" name="firstname" value="<?php echo $trainee_name; ?>" size="40" /></td></tr>
	<tr><td>Last Name			</td><td width="1%">:</td><td><?php echo $lastname; ?><input type="hidden" name="lastname" size="40" value="<?php echo $lastname; ?>" /></td></tr>	
	<tr><td>Address	1			</td><td width="1%">:</td><td><?php echo $address; ?><input type="hidden" name="address1" size="40" value="<?php echo $address; ?>" /></td></tr>
	<tr><td>Address 2			</td><td width="1%">:</td><td><?php echo $address2; ?><input type="hidden" name="address2" size="40" value="<?php echo $address2; ?>" /></td></tr>	
	<tr><td>Email				</td><td width="1%">:</td><td><?php echo $email; ?><input type="hidden" name="email" value="<?php echo $email; ?>" /></td></tr>
	<tr><td>Phone Num.			</td><td width="1%">:</td><td><?php echo $phone; ?><input type="hidden" name="phone_1" value="<?php echo $phone; ?>" /></td></tr>
	<tr><td>Province / State	</td><td width="1%">:</td><td><?php echo $province; ?><input type="hidden" name="state" value="<?php echo $province; ?>" /></td></tr>
	<tr><td>City				</td><td width="1%">:</td><td><?php echo $city; ?><input type="hidden" name="city" value="<?php echo $city; ?>" /></td></tr>
	<tr><td>Postal / Zip Code	</td><td width="1%">:</td><td><?php echo $postal; ?><input type="hidden" name="zip" value="<?php echo $postal; ?>" /></td></tr>	
	</table>
</p>
<p>
	<table>
		<tr><td width="30%" bgcolor="#7F92A4">Payment Method	</td><td width="1%">:</td><td><label>Paypal</label></td></tr>
	</table>
</p>

<p align="center"><input type="submit" name="submit" value="Proceed & Confirm" title="Click 'Proceed & COnfirm' to continue subscribe module" /></p>
</form>
  <br/>
<?php include('pageconfig/moduleFooter.php'); ?>