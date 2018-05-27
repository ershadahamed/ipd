<?php 
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../../manualdbconfig.php'); 

	$site = get_site();
	
	$purchase='Purchase modules';
	$title="$SITE->shortname: Courses - ".$purchase;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);

	echo $OUTPUT->header();	
	
	$id=$_POST['id'];
	$sql_ = mysql_query("SELECT * FROM mdl_cifacourse WHERE id='$id' ORDER BY id DESC");
	$row = mysql_fetch_array($sql_); 
?>

<!--*************************************************FORM AREA**********confirmation_loggeduser.php***********************************************************************-->
<!--form action="subscribedetails.php?confirm-subscribe" method="post"-->
<form action="confirmation.php?confirm-subscribe" method="post">
<br/>	
	<fieldset id="fieldset"><legend id="legend">Module Information</legend>
	<table id="formpayment">
  <tr>
    <td width="20%">Course Name</td>
    <td width="1%">:</td>
    <td>
		<?php echo ucwords(strtolower($row['fullname'])); ?>
		<input type="hidden" name="coursename" value="<?php echo $row['fullname']; ?>">
		<input type="hidden" name="shortname" value="<?php echo $row['shortname']; ?>">
		<input type="hidden" name="courseid" value="<?php echo $row['id']; ?>">
		<input type="hidden" name="id" value="<?php echo $row['id']; ?>"/>
	</td>
  </tr>
  <tr>
	<td>Duration</td>
	<td>:</td>
	<td><?php echo $row['duration']; ?> Month<input type="hidden" name="duration" value="<?php echo $row['duration']; ?>"></td>
	</tr>
	<tr valign="top">
		<td>Summary</td>
		<td>:</td>
		<td><div align="justify"><?php echo $row['summary']; ?><input type="hidden" name="summary" value="<?php echo $row['summary']; ?>"></div>
		</td>
	</tr>
  <tr>
    <td width="20%">Course Cost</td>
    <td width="1%">:</td>
    <td><strong>
	<img alt="<?php print_string('paypalaccepted', 'enrol_paypal') ?>" src="https://www.paypal.com/en_US/i/logo/PayPal_mark_60x38.gif" title="PayPal payments accepted" align="center" />
	&nbsp;	
		<?php 
			$cost=$_POST['cost']; 
			$currency=$_POST['currency'];
			$PaypalBusinessEmail=$_POST['PaypalBusinessEmail'];
			
			echo $cost.' '.$currency; 
		?>
		<input type="hidden" name="cost" value="<?php echo $cost; ?>">
		<input type="hidden" name="currency" value="<?php echo $currency;?>">
		<input type="hidden" name="PaypalBusinessEmail" value="<?php echo $PaypalBusinessEmail; ?>"/>
	</strong></td>
  </tr>
</table></fieldset>

<?php
	//$traineeID = $_POST['traineeid'];
	$trainee_name = $_POST['name'];
	$address = $_POST['trainee_address'];
	$email = $_POST['email'];
	$phone = $_POST['phone_no'];
	
	$lastname = $_POST['lastname'];
	$address2 = $_POST['address2'];
	$province = $_POST['province'];
	$city = $_POST['city'];
	$postal = $_POST['postal'];
    $country = $_POST['country'];
	
	//dob
	if($_POST['day']!=''){$day=$_POST['day'];}else{$day='-';}
	if($_POST['month']!=''){$month=$_POST['month'];}else{$month='-';}
	if($_POST['years']!=''){$years=$_POST['years'];}else{$years='-';}
		$dob=$years.'/'.$month.'/'.$day;
?>

<fieldset id="fieldset"><legend id="legend">Candidate Information</legend>
	<table id="formpayment">
	<tr><td width="20%">First Name			</td><td width="1%">:</td><td><?php echo $trainee_name; ?><input type="hidden" name="name" value="<?php echo $trainee_name; ?>" size="40" /></td></tr>
	<tr><td>Last Name			</td><td width="1%">:</td><td><?php echo $lastname; ?><input type="hidden" name="lastname" size="40" value="<?php echo $lastname; ?>" /></td></tr>	
	<tr><td>D.O.B				</td><td width="1%">:</td><td><?php echo $dob; ?><input type="hidden" name="dob" size="40" value="<?php echo $dob; ?>" /></td></tr>	
	<tr><td>Street address		</td><td width="1%">:</td><td><?php echo $address; ?><input type="hidden" name="trainee_address" size="40" value="<?php echo $address; ?>" /></td></tr>
	<?php if($address2!=''){ ?>
	<tr><td>Street address(cont.)	</td><td width="1%">:</td><td><?php echo $address2; ?><input type="hidden" name="address2" size="40" value="<?php echo $address2; ?>" /></td></tr>	
	<?php } ?>	
	<tr><td>Email				</td><td width="1%">:</td><td><?php echo $email; ?><input type="hidden" name="email" value="<?php echo $email; ?>" /></td></tr>
	<tr><td>Phone no.			</td><td width="1%">:</td><td><?php echo $phone; ?><input type="hidden" name="phone_no" value="<?php echo $phone; ?>" /></td></tr>
	<tr><td>City				</td><td width="1%">:</td><td><?php echo $city; ?><input type="hidden" name="city" value="<?php echo $city; ?>" /></td></tr>	
	<tr><td>Province / State	</td><td width="1%">:</td><td><?php echo $province; ?><input type="hidden" name="province" value="<?php echo $province; ?>" /></td></tr>
	<tr><td>Postal / Zip Code	</td><td width="1%">:</td><td><?php echo $postal; ?><input type="hidden" name="postal" value="<?php echo $postal; ?>" /></td></tr>	
	<tr><td>Country	</td><td width="1%">:</td><td>
	<?php 	
		$querycountry = $DB->get_records('country_list',array('countrycode'=>$country));
		foreach($querycountry as $qcountry);
		echo $qcountry->countryname;
	?>
	<input type="hidden" name="country" value="<?php echo $country; ?>" /></td></tr>	
	</table>
</fieldset>

<fieldset id="fieldset"><legend id="legend">Please choose your preferred payment method:</legend>
<table width="50%" border="0">
    <tr>
      <td width="5%"><input type="radio" name="radio" id="creditcard" value="creditcard" /></td>
      <td width="1%">&nbsp;</td>      
      <td width="94%">Credit card</td>      
    </tr>
    <tr>
      <td><input type="radio" name="radio" id="paypal" value="paypal" /></td>    
      <td>&nbsp;</td>
      <td>Paypal</td>
    </tr>
    <tr>
      <td><input type="radio" name="radio" id="telegraphic" value="telegraphic" /></td>    
      <td>&nbsp;</td>    
      <td>Telegraphic Transfer</td>
    </tr>   
  </table>
</fieldset>	

<p align="center">
<!--input type="button" name="update_profile" value="Update candidate info" title="Click 'Update candidate info' to update your information" target="_blank" onclick="window.open('<?php echo $CFG->wwwroot. "/portal/subscribe/paydetails_loggeduser_update.php?"; ?>id=<?php echo $row['id']; ?>', 'Window2', 'width=820,height=480,resizable = 1, scrollbars=yes');" /-->
<input type="submit" name="submit" value="Proceed" title="Click 'Proceed' to confirm subscribe module" />
</p></form>
<?php 	echo $OUTPUT->footer();	?>

