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
	
	$id=$_GET['id'];

	$sqlse=mysql_query("SELECT * FROM mdl_cifa_modulesubscribe WHERE traineeid='".$USER->traineeid."' AND (payment_status='Pending' OR payment_status='New') AND courseid='".$id."'");
	$sqlshow=mysql_fetch_array($sqlse);
	
	$selectcourse=mysql_query("SELECT * FROM mdl_cifacourse WHERE id='".$sqlshow['courseid']."'");
	$scount=mysql_num_rows($selectcourse);
?>	
<!--*************************************************FORM AREA*********************************************************************************-->
<form action="subscribedetails_stuck.php" method="post">
<?php
	//if($scount != '0'){
	$row=mysql_fetch_array($selectcourse);
?>	
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
			//*************** ***************************************************************************			
			
				//to get a cost amount from admin setting
				//$id=$_GET['id'];
				$id2=$row['id'];
				
				$sql_paypalamount="SELECT cost, currency FROM mdl_cifaenrol WHERE courseid='$id2' AND enrol='paypal'";
				$query_paypalamount=mysql_query($sql_paypalamount);
				$paypal_row=mysql_fetch_array($query_paypalamount);
					$cost=$paypal_row['cost'];
					$currency=$paypal_row['currency'];
					echo '&nbsp;'.$paypal_row['cost'].' '.$paypal_row['currency'].'';
			?>
		<input type="hidden" name="cost" value="<?php echo $cost; ?>">
		<input type="hidden" name="currency" value="<?php echo $currency;?>">
		<input type="hidden" name="PaypalBusinessEmail" value="<?php echo $PaypalBusinessEmail; ?>"/>
	</strong></td>
  </tr>
</table></fieldset>
<?php //} ?>
<?php
	$traineeID = $sqlshow['traineeid'];
	$trainee_name = $sqlshow['firstname'];
	$address = $sqlshow['address1'];
	$email = $sqlshow['email'];
	$phone = $sqlshow['phone_no'];
	
	$lastname = $sqlshow['lastname'];
	$address2 = $sqlshow['address2'];
	$province = $sqlshow['province'];
	$city = $sqlshow['city'];
	$postal = $sqlshow['zip'];
    $country = $sqlshow['country'];
	$invoiceno = $sqlshow['invoiceno'];
	$pay_method = $sqlshow['paymethod'];
?>

<fieldset id="fieldset"><legend id="legend">Candidate Information</legend>
	<table id="formpayment">
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
    <tr><td>Country				</td><td width="1%">:</td><td>
            <?php 	
                $querycountry = $DB->get_records('country_list',array('countrycode'=>$country));
                foreach($querycountry as $qcountry);
                echo $qcountry->countryname;
            ?>
            <input type="hidden" name="country" value="<?php echo $country; ?>" /><input type="hidden" name="invoiceno" value="<?php echo $invoiceno; ?>" />
	</td></tr>
	</table>
</fieldset>

<fieldset id="fieldset"><legend id="legend">Selected payment method:</legend>
<table width="50%" border="0">
    <tr>
      <td width="5%">
		<?php 
			if($pay_method == 'creditcard'){?> <img src="<?php echo $CFG->wwwroot. '/image/yes.png';?>" width="25"> <?} 
			else{ ?><img src="<?php echo $CFG->wwwroot. '/image/not.png';?>" width="25"><?php }
		?>
	  </td>
      <td width="1%">&nbsp;</td>      
      <td width="94%">
		<?php echo 'Credit card'; ?>
	  </td>      
    </tr>
    <tr>
      <td width="5%">
		<?php 
			if($pay_method == 'paypal'){?> <img src="<?php echo $CFG->wwwroot. '/image/yes.png';?>" width="25"> <?} 
			else{ ?><img src="<?php echo $CFG->wwwroot. '/image/not.png';?>" width="25"><?php }
		?>
	  </td>
      <td width="1%">&nbsp;</td>      
      <td width="94%">
		<?php echo 'Paypal'; ?>
	  </td>      
    </tr>
    <tr>
      <td width="5%">
		<?php 
			if($pay_method == 'telegraphic'){?> <img src="<?php echo $CFG->wwwroot. '/image/yes.png';?>" width="25"> <?} 
			else{ ?><img src="<?php echo $CFG->wwwroot. '/image/not.png';?>" width="25"><?php }
		?>
	  </td>
      <td width="1%">&nbsp;</td>      
      <td width="94%">
		<?php echo 'Telegraphic Transfer'; ?>
	  </td>      
    </tr>	
  </table>
</fieldset>

<p align="center">
<input type="button" name="submit" value="Confirm & Proceed" title="Click 'Confirm & Proceed' to make a payment through <?=$pay_method;?>" target="_blank" onclick="window.open('<?php echo $CFG->wwwroot. "/userpolicy_stuck.php?"; ?>invoice=<?=$invoiceno;?>&&pay_method=<?=$pay_method;?>&&traineeID=<?=$traineeID;?>&&trainee_name=<?=$trainee_name;?>&&lastname=<?=$lastname;?>&&address=<?=$address;?>&&address2=<?=$address2;?>&&email=<?=$email;?>&&phone=<?=$phone;?>&&city=<?=$city;?>&&province=<?=$province;?>&&postal=<?=$postal;?>&&country=<?=$country;?>&&cost=<?=$cost;?>&&currency=<?=$currency;?>&&PaypalBusinessEmail=<?=$PaypalBusinessEmail;?>&&coursename=<?php echo $row['fullname'];?>&&shortname=<?php echo $row['shortname']; ?>&&courseid=<?php echo $row['id']; ?>', 'Window2', 'width=820,height=400,resizable = 1, scrollbars=yes');" />
</p>
</form>	

<?php 	echo $OUTPUT->footer();	?>	