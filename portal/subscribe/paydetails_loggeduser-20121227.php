<?php 
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../../manualdbconfig.php'); 
	require_once('../../functiontime.php');
	require_once("../../includes/functions.php"); 
	
	$site = get_site();
	
	$purchase='Purchase modules';
	$title="$SITE->shortname: Courses - ".$purchase;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);

	echo $OUTPUT->header();	
	
	$id=$_GET['id'];
	$sql_ = mysql_query("SELECT * FROM mdl_cifacourse WHERE id='$id' ORDER BY id DESC");
	$row = mysql_fetch_array($sql_); 
	?>
<style>
<?php 
	include('../../css/style2.css'); 
?>
</style>
<!--**********************FORM AREA****************************************************************-->
<form id="fullpackinfo" name="fullpackinfo" action="confirmation_loggeduser.php" method="post" onSubmit="return valCari(this);">
	<!--h2>Fullpackage: &nbsp;<?php //echo $row['fullname']; ?></h2-->

	<!--fieldset id="fieldset"><legend id="legend">Module Information</legend>
	<table id="formpayment">
	  <tr>
		<td width="20%">Program Name</td>
		<td width="1%">:</td>
		<td>
			<?php echo ucwords(strtolower($row['fullname'])); ?>
			<input type="hidden" name="coursename" value="<?php echo $row['fullname']; ?>">
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
			<td><div align="justify"><?php if($row['summary']!=''){echo $row['summary'];}else{echo 'none';} ?><input type="hidden" name="summary" value="<?php echo $row['summary']; ?>"></div>
			</td>
		</tr>
	  <tr valign="top">
		<td width="20%">Course Cost</td>
		<td width="1%">:</td>
		<td>
		<img alt="" src="https://www.paypal.com/en_US/i/logo/PayPal_mark_60x38.gif" title="PayPal payments accepted" align="center" />
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
				
					echo '&nbsp;<b>'.$paypal_row['cost'].' '.$paypal_row['currency'].'</b>';
			?>
			<input type="hidden" name="cost" value="<?php echo $paypal_row['cost'];?>">
			<input type="hidden" name="currency" value="<?php echo $paypal_row['currency'];?>">
			<input type="hidden" name="PaypalBusinessEmail" value="<?php echo $PaypalBusinessEmail; ?>"/>
		</td>
	  </tr>
	</table></fieldset-->

	<?php 
        	$DOBUSER  = $DB->get_records('user',array('id'=>$USER->id));
			foreach($DOBUSER as $DOB){ } 
	?>	



	<fieldset id="fieldset"><legend id="legend"><strong>Subscribe info</strong></legend>
	<div style="margin:0px auto; width:95%; padding-top:20px;">
    <div style="padding-bottom:10px">
    	<!--h1 align="center">Purchase info</h1-->
    <!--input type="button" value="Continue Shopping" onclick="window.location='coursesindex.php'" /-->
	<input type="button" style="cursor:pointer;" value="Add new subscribe module" onclick="window.location='../../purchasemodule.php'">
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
                    <!--td style="text-align:center;"--><!--a href="javascript:del(<?php// echo $pid?>)">Remove</a--><!--
					<img onclick="javascript:del(<?php //echo $pid?>)" src="image/delete2.png" width="25" title="Remove a purchase - <?//=$pname;?>"/>
					</td--></tr>
            <?php					
				}
			?>
				<tr style="height:30px;">
					<td class="adjacent" colspan="4" width="70%">&nbsp;</td>
					<td class="adjacent" style="text-align:right;"><b>Order Total</b></td>
					<td class="adjacent" style="text-align:center;"><b>$ <?php echo get_order_total()?></b></td>
					<!--td colspan="3" align="right"-->
						<!--<input type="button" value="Clear Cart" onclick="clear_cart()"-->
						<!--input type="button" value="Update Cart" onclick="update_cart()"-->
						<!--input type="button" value="Place Order" onclick="window.location='billing.php'">
					</td-->
				</tr>
			<?php
            }
			else{
				echo "<tr bgColor='#FFFFFF'><td>There are no items in your shopping cart!</td>";
			}
		?>
        </table>
    </div></fieldset>


<!-- Payment Information for user to fill out -->	
<fieldset id="fieldset"><legend id="legend"><strong>Candidate Information</strong></legend><?php $strrequired='<font style="color: red;"> &nbsp; * </font>'; ?>
	<table id="formpayment">
	<tr><td width="20%">Candidate ID	</td><td width="1%">:</td><td><?php echo $DOB->traineeid; ?><input type="hidden" name="traineeid" id="traineeid" value="<?php echo $DOB->traineeid; ?>" /></td></tr>
	<tr><td>First Name			</td><td width="1%">:</td><td><?php echo $DOB->firstname; ?><input type="hidden" name="name" id="firstname" value="<?php echo $DOB->firstname; ?>"/></td></tr>
	<tr><td>Last Name			</td><td width="1%">:</td><td><?php echo $DOB->lastname; ?><input type="hidden" name="lastname" id="lastname" value="<?php echo $DOB->lastname; ?>" /></td></tr>	
	<tr><td>Street address</td><td width="1%">:</td><td>
		<?php if($DOB->address != '') { 
				echo $DOB->address; 
				echo '<input type="hidden" name="trainee_address" size="40" id="address1" value="'.$DOB->address.'" />';
			}else{?>
			<input type="text" name="trainee_address" size="40" id="address1" /><?=$strrequired;?>
											</td></tr>
	<tr><td>Street address(cont.)					</td><td width="1%">:</td><td><input type="text" name="address2" id="address2" size="40"/></td></tr><?php } ?>
	<tr><td>Email					</td><td width="1%">:</td><td><?php echo $DOB->email; ?><input type="hidden" name="email" id="email" value="<?php echo $DOB->email; ?>"/></td></tr>
	<tr><td>Phone Number				</td>
		<td width="1%">:</td><td>
		<?php if($DOB->phone1 != ''){
				echo $DOB->phone1; 
				echo '<input type="hidden" name="phone_no" id="phoneno" value="'.$DOB->phone1.'"/>';
		}else{?>
		<input type="text" name="phone_no" id="phoneno"/> <?=$strrequired;?><?php } ?>
	</td></tr>
	<tr><td>City				</td><td width="1%">:</td><td><?php echo $DOB->city; ?><input type="hidden" name="city" id="city" value="<?php echo $DOB->city; ?>" /></td></tr>	
	<tr><td>Province / State				</td><td width="1%">:</td><td>
		<?php 
			$sql_show=mysql_query("SELECT * FROM mdl_cifa_modulesubscribe WHERE traineeid='".$DOB->traineeid."' GROUP BY traineeid"); 
			$scount=mysql_num_rows($sql_show);
			if($scount!='0'){
			$srow=mysql_fetch_array($sql_show);
			echo $srow['province']; 
		?>
		<input type="hidden" name="province" id="state" value="<?php echo $srow['province']; ?>" />
		<?php }else{ ?>
		<input type="text" name="province" id="state" value="" />
		<?php } ?>
	</td></tr>
	<tr><td>Postal / Zip Code				</td><td width="1%">:</td><td>
		<?php 
		$sql_show=mysql_query("SELECT * FROM mdl_cifa_modulesubscribe WHERE traineeid='".$USER->traineeid."' GROUP BY traineeid"); 
		$scount=mysql_num_rows($sql_show);		
		if($scount!='0'){
		$srow=mysql_fetch_array($sql_show);
		echo $srow['zip'];
		?>
		<input type="hidden" name="postal" id="postal" value="<?php echo $srow['zip']; ?>"/>
		<?php }else{ ?>		
		<input type="text" name="postal" id="postal" />
		<?php } ?>
	</td></tr>
	<tr><td>Country				</td><td width="1%">:</td>
	<td>
	<?php	
	//list of country in the world
	$country_list = array(
			 "GB" => "United Kingdom",
			  "US" => "United States",
			  "AF" => "Afghanistan",
			  "AL" => "Albania",
			  "DZ" => "Algeria",
			  "AS" => "American Samoa",
			  "AD" => "Andorra",
			  "AO" => "Angola",
			  "AI" => "Anguilla",
			  "AQ" => "Antarctica",
			  "AG" => "Antigua And Barbuda",
			  "AR" => "Argentina",
			  "AM" => "Armenia",
			  "AW" => "Aruba",
			  "AU" => "Australia",
			  "AT" => "Austria",
			  "AZ" => "Azerbaijan",
			  "BS" => "Bahamas",
			  "BH" => "Bahrain",
			  "BD" => "Bangladesh",
			  "BB" => "Barbados",
			  "BY" => "Belarus",
			  "BE" => "Belgium",
			  "BZ" => "Belize",
			  "BJ" => "Benin",
			  "BM" => "Bermuda",
			  "BT" => "Bhutan",
			  "BO" => "Bolivia",
			  "BA" => "Bosnia And Herzegowina",
			  "BW" => "Botswana",
			  "BV" => "Bouvet Island",
			  "BR" => "Brazil",
			  "IO" => "British Indian Ocean Territory",
			  "BN" => "Brunei Darussalam",
			  "BG" => "Bulgaria",
			  "BF" => "Burkina Faso",
			  "BI" => "Burundi",
			  "KH" => "Cambodia",
			  "CM" => "Cameroon",
			  "CA" => "Canada",
			  "CV" => "Cape Verde",
			  "KY" => "Cayman Islands",
			  "CF" => "Central African Republic",
			  "TD" => "Chad",
			  "CL" => "Chile",
			  "CN" => "China",
			  "CX" => "Christmas Island",
			  "CC" => "Cocos (Keeling) Islands",
			  "CO" => "Colombia",
			  "KM" => "Comoros",
			  "CG" => "Congo",
			  "CD" => "Congo, The Democratic Republic Of The",
			  "CK" => "Cook Islands",
			  "CR" => "Costa Rica",
			  "CI" => "Cote D'Ivoire",
			  "HR" => "Croatia (Local Name: Hrvatska)",
			  "CU" => "Cuba",
			  "CY" => "Cyprus",
			  "CZ" => "Czech Republic",
			  "DK" => "Denmark",
			  "DJ" => "Djibouti",
			  "DM" => "Dominica",
			  "DO" => "Dominican Republic",
			  "TP" => "East Timor",
			  "EC" => "Ecuador",
			  "EG" => "Egypt",
			  "SV" => "El Salvador",
			  "GQ" => "Equatorial Guinea",
			  "ER" => "Eritrea",
			  "EE" => "Estonia",
			  "ET" => "Ethiopia",
			  "FK" => "Falkland Islands (Malvinas)",
			  "FO" => "Faroe Islands",
			  "FJ" => "Fiji",
			  "FI" => "Finland",
			  "FR" => "France",
			  "FX" => "France, Metropolitan",
			  "GF" => "French Guiana",
			  "PF" => "French Polynesia",
			  "TF" => "French Southern Territories",
			  "GA" => "Gabon",
			  "GM" => "Gambia",
			  "GE" => "Georgia",
			  "DE" => "Germany",
			  "GH" => "Ghana",
			  "GI" => "Gibraltar",
			  "GR" => "Greece",
			  "GL" => "Greenland",
			  "GD" => "Grenada",
			  "GP" => "Guadeloupe",
			  "GU" => "Guam",
			  "GT" => "Guatemala",
			  "GN" => "Guinea",
			  "GW" => "Guinea-Bissau",
			  "GY" => "Guyana",
			  "HT" => "Haiti",
			  "HM" => "Heard And Mc Donald Islands",
			  "VA" => "Holy See (Vatican City State)",
			  "HN" => "Honduras",
			  "HK" => "Hong Kong",
			  "HU" => "Hungary",
			  "IS" => "Iceland",
			  "IN" => "India",
			  "ID" => "Indonesia",
			  "IR" => "Iran (Islamic Republic Of)",
			  "IQ" => "Iraq",
			  "IE" => "Ireland",
			  "IL" => "Israel",
			  "IT" => "Italy",
			  "JM" => "Jamaica",
			  "JP" => "Japan",
			  "JO" => "Jordan",
			  "KZ" => "Kazakhstan",
			  "KE" => "Kenya",
			  "KI" => "Kiribati",
			  "KP" => "Korea, Democratic People's Republic Of",
			  "KR" => "Korea, Republic Of",
			  "KW" => "Kuwait",
			  "KG" => "Kyrgyzstan",
			  "LA" => "Lao People's Democratic Republic",
			  "LV" => "Latvia",
			  "LB" => "Lebanon",
			  "LS" => "Lesotho",
			  "LR" => "Liberia",
			  "LY" => "Libyan Arab Jamahiriya",
			  "LI" => "Liechtenstein",
			  "LT" => "Lithuania",
			  "LU" => "Luxembourg",
			  "MO" => "Macau",
			  "MK" => "Macedonia, Former Yugoslav Republic Of",
			  "MG" => "Madagascar",
			  "MW" => "Malawi",
			  "MY" => "Malaysia",
			  "MV" => "Maldives",
			  "ML" => "Mali",
			  "MT" => "Malta",
			  "MH" => "Marshall Islands",
			  "MQ" => "Martinique",
			  "MR" => "Mauritania",
			  "MU" => "Mauritius",
			  "YT" => "Mayotte",
			  "MX" => "Mexico",
			  "FM" => "Micronesia, Federated States Of",
			  "MD" => "Moldova, Republic Of",
			  "MC" => "Monaco",
			  "MN" => "Mongolia",
			  "MS" => "Montserrat",
			  "MA" => "Morocco",
			  "MZ" => "Mozambique",
			  "MM" => "Myanmar",
			  "NA" => "Namibia",
			  "NR" => "Nauru",
			  "NP" => "Nepal",
			  "NL" => "Netherlands",
			  "AN" => "Netherlands Antilles",
			  "NC" => "New Caledonia",
			  "NZ" => "New Zealand",
			  "NI" => "Nicaragua",
			  "NE" => "Niger",
			  "NG" => "Nigeria",
			  "NU" => "Niue",
			  "NF" => "Norfolk Island",
			  "MP" => "Northern Mariana Islands",
			  "NO" => "Norway",
			  "OM" => "Oman",
			  "PK" => "Pakistan",
			  "PW" => "Palau",
			  "PA" => "Panama",
			  "PG" => "Papua New Guinea",
			  "PY" => "Paraguay",
			  "PE" => "Peru",
			  "PH" => "Philippines",
			  "PN" => "Pitcairn",
			  "PL" => "Poland",
			  "PT" => "Portugal",
			  "PR" => "Puerto Rico",
			  "QA" => "Qatar",
			  "RE" => "Reunion",
			  "RO" => "Romania",
			  "RU" => "Russian Federation",
			  "RW" => "Rwanda",
			  "KN" => "Saint Kitts And Nevis",
			  "LC" => "Saint Lucia",
			  "VC" => "Saint Vincent And The Grenadines",
			  "WS" => "Samoa",
			  "SM" => "San Marino",
			  "ST" => "Sao Tome And Principe",
			  "SA" => "Saudi Arabia",
			  "SN" => "Senegal",
			  "SC" => "Seychelles",
			  "SL" => "Sierra Leone",
			  "SG" => "Singapore",
			  "SK" => "Slovakia (Slovak Republic)",
			  "SI" => "Slovenia",
			  "SB" => "Solomon Islands",
			  "SO" => "Somalia",
			  "ZA" => "South Africa",
			  "GS" => "South Georgia, South Sandwich Islands",
			  "ES" => "Spain",
			  "LK" => "Sri Lanka",
			  "SH" => "St. Helena",
			  "PM" => "St. Pierre And Miquelon",
			  "SD" => "Sudan",
			  "SR" => "Suriname",
			  "SJ" => "Svalbard And Jan Mayen Islands",
			  "SZ" => "Swaziland",
			  "SE" => "Sweden",
			  "CH" => "Switzerland",
			  "SY" => "Syrian Arab Republic",
			  "TW" => "Taiwan",
			  "TJ" => "Tajikistan",
			  "TZ" => "Tanzania, United Republic Of",
			  "TH" => "Thailand",
			  "TG" => "Togo",
			  "TK" => "Tokelau",
			  "TO" => "Tonga",
			  "TT" => "Trinidad And Tobago",
			  "TN" => "Tunisia",
			  "TR" => "Turkey",
			  "TM" => "Turkmenistan",
			  "TC" => "Turks And Caicos Islands",
			  "TV" => "Tuvalu",
			  "UG" => "Uganda",
			  "UA" => "Ukraine",
			  "AE" => "United Arab Emirates",
			  "UM" => "United States Minor Outlying Islands",
			  "UY" => "Uruguay",
			  "UZ" => "Uzbekistan",
			  "VU" => "Vanuatu",
			  "VE" => "Venezuela",
			  "VN" => "Viet Nam",
			  "VG" => "Virgin Islands (British)",
			  "VI" => "Virgin Islands (U.S.)",
			  "WF" => "Wallis And Futuna Islands",
			  "EH" => "Western Sahara",
			  "YE" => "Yemen",
			  "YU" => "Yugoslavia",
			  "ZM" => "Zambia",
			  "ZW" => "Zimbabwe"
		);?>	
	
		<select id="country" name="country">
		<option value=""> - country - </option>
		<?php
		asort($country_list);
		reset($country_list);	
		foreach($country_list as $key => $value):
		echo '<option value="'.$key.'"';
		if(($DOB->country)==$key){
		echo 'selected';
		} echo '>'.$value.'</option>'; 
		endforeach;
		?>
		</select>	<?=$strrequired;?>
	</td></tr>
	</table>
</fieldset>


<fieldset id="fieldset"><legend id="legend"><strong>Please choose your preferred payment method:</strong></legend>
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
<input type="button" name="update_profile" value="Update candidate info" title="Click 'Update candidate info' to update your information" target="_blank" onclick="window.open('<?php echo $CFG->wwwroot. "/portal/subscribe/paydetails_loggeduser_update.php?"; ?>id=<?php echo $row['id']; ?>', 'Window2', 'width=820,height=480,resizable = 1, scrollbars=yes');" />
<!--input type="button" name="update_profile" value="Update candidate info" title="Click 'Update candidate info' to update your information" target="_blank" /-->
<input type="submit" name="submit" value="Proceed" title="Click 'Proceed' to confirm subscribe module" />
</p>
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
		//var radio = form.radio.value;
	 
		if(!traineeid)
		{
			VAL = false;
			alert("Please enter candidate ID");
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
		/*else if(!radio) { 
			VAL = false;
			alert("Please enter payment method!");
			return false; 
		} */		
	}
	</script>
<?php 	echo $OUTPUT->footer();	?>
