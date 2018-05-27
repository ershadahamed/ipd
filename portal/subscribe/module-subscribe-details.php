<?php include('pageconfig/moduleHeader.php'); ?>
<?php
	include('../manualdbconfig.php');
	
	$modulename=$_POST['modulename'];
	$attempts=$_POST['attempts'];
	$coursename=$_POST['fullname'];
	$shortname=$_POST['shortname'];
	$moduleCost=$_POST['cost'];
	$currency=$_POST['currency'];
	$courseID=$_POST['id'];
?>

<!--************************** form start here ***********************************************************-->
<form action="module-confirm.php?confrim-to-subscibe-module" method="post" onSubmit="return valCari(this);">
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
				<input type="hidden" name="id" value="<?php echo $courseID; ?>" />
			</td>
		</tr>	
		<tr>
			<td>Attempts Allow</td><td>:</td><td><?php echo $attempts; ?><input type="hidden" name="attempts" value="<?php echo $attempts; ?>" /></td>
		</tr>
		<tr>
			<td>Module Cost</td><td>:</td>
			<td>
				<img alt="<?php print_string('paypalaccepted', 'enrol_paypal') ?>" src="https://www.paypal.com/en_US/i/logo/PayPal_mark_60x38.gif" title="PayPal payments accepted" align="center" />
				<?php echo $moduleCost.' '.$currency; ?>
				<?php
			//************************to get bussiness email*******************************************
				$sqlPaypalBusiness=mysql_query("Select
												  a.plugin,
												  a.name,
												  a.value
												From
												  mdl_cifaconfig_plugins a
												Where
												  a.plugin = 'enrol_paypal' And
												  a.name = 'paypalbusiness'");
				$rowPaypalBusiness=mysql_fetch_array($sqlPaypalBusiness);
				
				$PaypalBusinessEmail=$rowPaypalBusiness['value'];
			//******************************************************************************************
				?>
				<input type="hidden" name="cost" value="<?php echo $moduleCost; ?>" />
				<input type="hidden" name="currency" value="<?php echo $currency; ?>">
				<input type="hidden" name="PaypalBusinessEmail" value="<?php echo $PaypalBusinessEmail; ?>"/>
			</td>
		</tr>
	</table>

<!-- Payment Information for user to fill out -->	
<p>
	<table>
	<tr bgcolor="#7F92A4"><td colspan="3"><font color="#FFFFFF" size="2em" style="font-weight:bolder;" >Payment Information</font></td></tr>
	<tr><td width="30%">Trainee ID	</td><td width="1%">:</td><td><input type="text" name="traineeid" id="traineeid" /></td></tr>
	<tr><td>First Name			</td><td width="1%">:</td><td><input type="text" name="name" id="firstname" size="40" /></td></tr>
	<tr><td>Last Name			</td><td width="1%">:</td><td><input type="text" name="lastname" id="lastname" size="40" /></td></tr>	
	<tr><td>Address 1					</td><td width="1%">:</td><td><input type="text" name="trainee_address" id="address1" size="40"/></td></tr>
	<tr><td>Address 2					</td><td width="1%">:</td><td><input type="text" name="address2" size="40" id="address2" /></td></tr>
	<tr><td>Email					</td><td width="1%">:</td><td><input type="text" name="email" id="email" /></td></tr>
	<tr><td>Phone Number				</td><td width="1%">:</td><td><input type="text" name="phone_no" id="phoneno" /></td></tr>
	<tr><td>Province / State				</td><td width="1%">:</td><td><input type="text" name="province" id="state" /></td></tr>
	<tr><td>City				</td><td width="1%">:</td><td><input type="text" name="city" id="city" /></td></tr>
	<tr><td>Postal / Zip Code				</td><td width="1%">:</td><td><input type="text" name="postal" id="zip" /></td></tr>
	</table>
</p>

<p>
	<table>
		<tr><td width="30%">Payment Method	</td><td width="1%">:</td><td><label><!--<input type="radio" name="paymentmethod" id="radio" value="radio"/>-->Paypal</label></td></tr>
	</table>
</p>

<p align="center"><input type="submit" name="submit" value="Proceed" title="Click 'Proceed' to continue subscribe module" /></p>
</form>
  <br/>
	<script language="JavaScript" type="text/javascript">
	//You should create the validator only after the definition of the HTML form
	function valCari(form)
	{
		var VAL = true;		
		var traineeid = form.traineeid.value;
		var name = form.name.value;
		var lastname = form.lastname.value;
		var address1 = form.address1.value;
		var email = form.email.value;
		var phone_no = form.phone_no.value;
	 
		if(!traineeid)
		{
			VAL = false;
			alert("Please enter Trainee ID");
			form.traineeid.focus();
			return false;
		}
		
		else if(!name)
		{
			VAL = false;
			alert("Please enter first name");
			form.name.focus();
			return false;
		}
		
		else if(!lastname)
		{
			VAL = false;
			alert("Please enter last name");
			form.lastname.focus();
			return false;
		}
		
		else if(!address1)
		{
			VAL = false;
			alert("Please enter address");
			form.address1.focus();
			return false;
		}
		
		else if(!email)
		{
			VAL = false;
			alert("Please enter email");
			form.email.focus();
			return false;
		}
		
		else if(!phone_no)
		{
			VAL = false;
			alert("Please enter phone_no");
			form.phone_no.focus();
			return false;
		}
	}
	</script>  
<?php include('pageconfig/moduleFooter.php'); ?>