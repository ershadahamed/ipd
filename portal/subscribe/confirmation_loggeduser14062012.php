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

<!--*************************************************FORM AREA*********************************************************************************-->
<form action="subscribedetails_loggeduser.php" method="post">
	
	<fieldset id="fieldset"><legend id="legend">Module Information</legend>
	<table id="formpayment">
	<!--tr bgcolor="#7F92A4"><td colspan="3"><font color="#FFFFFF" size="2em" style="font-weight:bolder;" >Details About Module</font></td></tr-->
  <tr>
    <td width="20%">Course Name</td>
    <td width="1%">:</td>
    <td>
		<?php echo ucwords(strtolower($row['fullname'])); ?>
		<input type="hidden" name="coursename" value="<?php echo $row['fullname']; ?>">
		<input type="hidden" name="shortname" value="<?php echo $row['shortname']; ?>">
		<input type="hidden" name="courseid" value="<?php echo $row['id']; ?>">
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
		<td><div align="justify"><?php if($row['summary']!=''){echo $row['summary'];}else{echo 'none';} ?><input type="hidden" name="summary" value="<?php echo $row['summary']; ?>"></div>
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
        $country = $_POST['country'];
	
	//dob
	if($_POST['dob'] == ''){
		if($_POST['day']!=''){$day=$_POST['day'];}else{$day='-';}
		if($_POST['month']!=''){$month=$_POST['month'];}else{$month='-';}
		if($_POST['years']!=''){$years=$_POST['years'];}else{$years='-';}
		//$month=$_POST['month'];
		//$years=$_POST['years'];
                $dob=$years.'/'.$month.'/'.$day;
	}else{
		$dob=$_POST['dob'];
	}
?>

<fieldset id="fieldset"><legend id="legend">Candidate Information</legend>
	<table id="formpayment">
	<!--tr bgcolor="#7F92A4"><td colspan="3"><font color="#FFFFFF" size="2em" style="font-weight:bolder;" >Payment Information</font></td></tr-->
	<tr><td width="20%">Candidate ID	</td><td width="1%">:</td><td><?php echo $traineeID; ?><input type="hidden" name="traineeid" value="<?php echo $traineeID; ?>" /></td></tr>
	<tr><td>First Name			</td><td width="1%">:</td><td><?php echo $trainee_name; ?><input type="hidden" name="firstname" value="<?php echo $trainee_name; ?>" size="40" /></td></tr>
	<tr><td>Last Name			</td><td width="1%">:</td><td><?php echo $lastname; ?><input type="hidden" name="lastname" size="40" value="<?php echo $lastname; ?>" /></td></tr>
	<!--tr><td>D.O.B				</td><td width="1%">:</td><td><?php //echo $dob; ?><input type="hidden" name="dob" size="40" value="<?php //echo $dob; ?>" /></td></tr-->	
	<tr><td>Street address		</td><td width="1%">:</td><td><?php echo $address; ?><input type="hidden" name="address1" size="40" value="<?php echo $address; ?>" /></td></tr>
	<?php if($address2!=''){ ?>
	<tr><td>Street address(cont.)</td><td width="1%">:</td><td><?php echo $address2; ?><input type="hidden" name="address2" size="40" value="<?php echo $address2; ?>" /></td></tr>	
	<?php } ?>
	<tr><td>Email				</td><td width="1%">:</td><td><?php echo $email; ?><input type="hidden" name="email" value="<?php echo $email; ?>" /></td></tr>
	<tr><td>Phone Num.			</td><td width="1%">:</td><td><?php echo $phone; ?><input type="hidden" name="phone_1" value="<?php echo $phone; ?>" /></td></tr>
	<tr><td>City				</td><td width="1%">:</td><td><?php echo $city; ?><input type="hidden" name="city" value="<?php echo $city; ?>" /></td></tr>	
	<tr><td>Province / State	</td><td width="1%">:</td><td><?php echo $province; ?><input type="hidden" name="state" value="<?php echo $province; ?>" /></td></tr>
	<tr><td>Postal / Zip Code	</td><td width="1%">:</td><td><?php echo $postal; ?><input type="hidden" name="zip" value="<?php echo $postal; ?>" /></td></tr>		
        <tr><td>Country	</td><td width="1%">:</td><td>
            <?php 	
                $querycountry = $DB->get_records('country_list',array('countrycode'=>$country));
                foreach($querycountry as $qcountry);
                echo $qcountry->countryname;
            ?>
            <input type="hidden" name="country" value="<?php echo $country; ?>" /></td></tr>
	</table>
</fieldset>

<p align="center">
<input type="submit" name="submit" value="Confirm & Proceed" title="Click 'Confirm & Proceed' to make a payment through paypal" target="_blank" />
</p>
</form>
<?php 	echo $OUTPUT->footer();	?>
