<?php 
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../../manualdbconfig.php'); 
	require_once("../../includes/functions.php"); 

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
<style>
<?php 
	include('../../css/style2.css'); 
?>
</style>
<!--*************************************************FORM AREA*********************************************************************************-->
<form action="subscribedetails_loggeduser.php" method="post">
	
	<!--fieldset id="fieldset"><legend id="legend">Module Information</legend>
	<table id="formpayment">
  <tr>
    <td width="20%">Course Name</td>
    <td width="1%">:</td>
    <td>
		<?php /*echo ucwords(strtolower($row['fullname'])); ?>
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
		<input type="hidden" name="PaypalBusinessEmail" value="<?php echo $PaypalBusinessEmail; */?>"/>
	</strong></td>
  </tr>
</table></fieldset-->



	<fieldset id="fieldset"><legend id="legend"><strong>Subscribe info</strong></legend>
	<div style="margin:0px auto; width:95%; padding-top:20px;">
    <div style="padding-bottom:10px">
    	<!--h1 align="center">Purchase info</h1-->
    <!--input type="button" value="Continue Shopping" onclick="window.location='coursesindex.php'" /-->
    </div>
    	<div style="color:#F00"><?php echo $msg?></div>
    	<table id="availablecourse3" width="100%">
    	<?php
			if(is_array($_SESSION['cart'])){
            	echo '<tr class="yellow" bgcolor="#FFFFFF" style="font-weight:bold">
						<th width="1%" align="center">No.</th>
						<th width="45%">IPD Name</th>
						<th width="15%">IPD Code</th>
						<th width="10%" align="center">Price</th>
						<th width="10%" align="center">Qty</th>
						<th width="10%" align="center">Amount</th>
					</tr>';
				$max=count($_SESSION['cart']);
				for($i=0;$i<$max;$i++){
					$pid=$_SESSION['cart'][$i]['productid'];
					$q=$_SESSION['cart'][$i]['qty'];
					$pname=get_product_name($pid);
					if($q==0) continue;
			?>
            		<tr bgcolor="#FFFFFF">
						<td class="adjacent" style="text-align:center;"><?php echo $i+1?></td>
						<td class="adjacent"><?php echo $pname?></td>
						<td class="adjacent" style="text-align:center;"><?php echo get_product_code($pid);?></td>
						<td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)?></td>
						<td class="adjacent" style="text-align:center;"><input type="hidden" name="product<?php echo $pid?>" value="<?php echo $q?>" maxlength="3" size="2" /><?php echo $q?></td>                    
						<td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)*$q?></td>
					</tr>
            <?php					
				}
			?>
				<tr style="height:30px;">
					<td class="adjacent" colspan="4" width="70%">&nbsp;</td>
					<td class="adjacent" style="text-align:right;"><b>Order Total</b></td>
					<td class="adjacent" style="text-align:center;"><b>$ <?php echo get_order_total()?></b></td>
				</tr>
			<?php
            }
			else{
				echo "<tr bgColor='#FFFFFF'><td>There are no items in your shopping cart!</td>";
			}
		?>
        </table>
    </div></fieldset>



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
	$pay_method = $_POST['radio'];
?>

<fieldset id="fieldset"><legend id="legend"><strong>Candidate Information</strong></legend>
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
	<?php if($province!=''){ ?>
	<tr><td>Province / State	</td><td width="1%">:</td><td><?php echo $province; ?><input type="hidden" name="state" value="<?php echo $province; ?>" /></td></tr>
	<?php }if($postal!=''){  ?>
	<tr><td>Postal / Zip Code	</td><td width="1%">:</td><td><?php echo $postal; ?><input type="hidden" name="zip" value="<?php echo $postal; ?>" /></td></tr>		
    <?php } ?>
	<tr><td>Country	</td><td width="1%">:</td><td>
            <?php 	
                $querycountry = $DB->get_records('country_list',array('countrycode'=>$country));
                foreach($querycountry as $qcountry);
                echo $qcountry->countryname;
            ?>
            <input type="hidden" name="country" value="<?php echo $country; ?>" /></td></tr>
	</table>
</fieldset>

<fieldset id="fieldset"><legend id="legend"><strong>Selected payment method:</strong></legend>
<table width="50%" border="0">
    <tr>
      <td width="5%">
		<?php 
			if($pay_method == 'creditcard'){?> <img src="<?php echo $CFG->wwwroot. '/image/yes.png';?>" width="28"> <?} 
			else{ ?><img src="<?php echo $CFG->wwwroot. '/image/not.png';?>" width="28"><?php }
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
			if($pay_method == 'paypal'){?> <img src="<?php echo $CFG->wwwroot. '/image/yes.png';?>" width="28"> <?} 
			else{ ?><img src="<?php echo $CFG->wwwroot. '/image/not.png';?>" width="28"><?php }
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
			if($pay_method == 'telegraphic'){?> <img src="<?php echo $CFG->wwwroot. '/image/yes.png';?>" width="28"> <?} 
			else{ ?><img src="<?php echo $CFG->wwwroot. '/image/not.png';?>" width="28"><?php }
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
<input type="button" name="submit" value="Confirm & Proceed" title="Click 'Confirm & Proceed' to make a payment through paypal" target="_blank" onclick="window.open('<?php echo $CFG->wwwroot. "/userpolicy.php?"; ?>pay_method=<?=$pay_method;?>&&traineeID=<?=$traineeID;?>&&trainee_name=<?=$trainee_name;?>&&lastname=<?=$lastname;?>&&address=<?=$address;?>&&address2=<?=$address2;?>&&email=<?=$email;?>&&phone=<?=$phone;?>&&city=<?=$city;?>&&province=<?=$province;?>&&postal=<?=$postal;?>&&country=<?=$country;?>', 'Window2', 'width=820,height=400,resizable = 1, scrollbars=yes');" />
</p>
</form>

<?php 	echo $OUTPUT->footer();	?>
