<!-- content area --->		
<style>
<?php include('../../css/style.css'); ?>
</style>    
	<?php 
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../../manualdbconfig.php'); 
	require_once('../../functiontime.php');

	$site = get_site();
	
	$purchase='Purchase modules';
	$title="$SITE->shortname: Courses - ".$purchase;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);

	//echo $OUTPUT->header();	
	
		$courseid=$_GET['id'];
		/*$sql_ = mysql_query("SELECT * FROM mdl_cifacourse WHERE id='$id' ORDER BY id DESC");
		$row = mysql_fetch_array($sql_); */
	?>
	
<!--**********************FORM AREA****************************************************************-->
<form id="fullpackinfo" name="fullpackinfo"  method="post" onSubmit="return valCari(this);">

	<?php 
        	$DOBUSER  = $DB->get_records('user',array('id'=>$USER->id));
			foreach($DOBUSER as $DOB){ }
	?>

<!-- Payment Information for user to fill out -->	
<br/>
<fieldset id="fieldset"><legend id="legend" style="background-color:#666;">Update Candidate Information</legend>
	<table id="formpayment">
	<tr><td width="20%">Candidate ID</td><td width="1%">:</td><td>
	<?php echo $USER->traineeid; ?><input type="hidden" name="traineeid" id="traineeid" value="<?php echo $USER->traineeid; ?>" />
	<input type="hidden" name="courseid" id="courseid" value="<?php echo $courseid; ?>" />
	</td></tr>
	<tr><td>First Name			</td><td width="1%">:</td><td>
		<input type="text" name="name" id="firstname" value="<?php echo $DOB->firstname; ?>"/>
	<tr><td>Last Name			</td><td width="1%">:</td><td>
	<input type="text" name="lastname" id="lastname" value="<?php echo $DOB->lastname; ?>" /></td></tr>		

	<tr><td>Street address</td><td width="1%">:</td><td>
		<?php if($DOB->address != '') { 
				echo '<input type="text" name="trainee_address" size="60" id="address1" value="'.$DOB->address.'" />';
			}else{?>
			<input type="text" name="trainee_address" size="40" id="address1" />
											</td></tr>
	<tr><td>Street address(cont.)					</td><td width="1%">:</td><td><input type="text" name="address2" id="address2" size="60"/></td></tr><?php } ?>
	<tr><td>Email					</td><td width="1%">:</td><td>
	<input type="text" name="email" id="email" value="<?php echo $DOB->email; ?>"/></td></tr>
	<tr><td>Phone Number				</td>
		<td width="1%">:</td><td>
		<?php if($DOB->phone1 != ''){
				echo '<input type="text" name="phone_no" id="phoneno" value="'.$DOB->phone1.'"/>';
		}else{?>
		<input type="text" name="phone_no" id="phoneno"/> <?php } ?>
	</td></tr>
	<tr><td>City				</td><td width="1%">:</td><td><input type="text" name="city" id="city" value="<?php echo $DOB->city; ?>" /></td></tr>	
	<tr style="display:none;"><td>Province / State				</td><td width="1%">:</td><td>
		<?php 
			$sql_show=mysql_query("SELECT * FROM mdl_cifa_modulesubscribe WHERE traineeid='".$USER->traineeid."' GROUP BY traineeid"); 
			$scount=mysql_num_rows($sql_show);
			if($scount!='0'){
			$srow=mysql_fetch_array($sql_show);
			//echo $srow['province']; 
		?>
		<input type="text" name="province" id="state" value="<?php echo $srow['province']; ?>" />
		<?php }else{ ?>
		<input type="text" name="province" id="state" value="" />
		<?php } ?>
	</td></tr>
	<tr style="display:none;"><td>Postal / Zip Code				</td><td width="1%">:</td><td>
		<?php 
		$sql_show=mysql_query("SELECT * FROM mdl_cifa_modulesubscribe WHERE traineeid='".$USER->traineeid."' GROUP BY traineeid"); 
		$scount=mysql_num_rows($sql_show);		
		if($scount!='0'){
		$srow=mysql_fetch_array($sql_show);
		//echo $srow['zip'];
		?>
		<input type="text" name="postal" id="postal" value="<?php echo $srow['zip']; ?>"/>
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
		</select>	
	</td></tr>
	</table>
</fieldset>
<p align="center">
<input type="submit" name="update" value="Update" title="Click 'Update' to update" />
</p>
</form>

<?php 
if(isset($_POST['update'])){

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
	$courseid=$_POST['courseid'];
	
	$fulladdress=$address.' '.$address2;

	//$updatesql=mysql_query("UPDATE mdl_cifa_modulesubscribe SET firstname='".$trainee_name."', lastname='".$lastname ."', address1='".$fulladdress."', email='".$email."', phone_no='".$phone."', province='".$province ."', city='".$city."', zip='".$postal."', country='".$country."' WHERE traineeid='".$USER->traineeid."'");
	
	$updates=mysql_query("UPDATE mdl_cifauser SET firstname='".$trainee_name."', lastname='".$lastname ."', address='".$fulladdress."', email='".$email."', phone1='".$phone."', city='".$city."', country='".$country."' WHERE traineeid='".$USER->traineeid."'");
	$updatesql=mysql_query("UPDATE mdl_cifa_modulesubscribe SET firstname='".$trainee_name."', lastname='".$lastname ."', address1='".$fulladdress."', email='".$email."', phone_no='".$phone."', province='".$province ."', city='".$city."', zip='".$postal."', country='".$country."' WHERE traineeid='".$USER->traineeid."'");
	if($updatesql){ 
	$errors=0;
	?>
					<script language="javascript">
					window.alert("Your information have been updated.");
				</script>
	<?php			
				$errors=1;
	}
 ?>
 <script style="text/javascript">
		  window.opener.location.href="<?php echo $CFG->wwwroot. '/portal/subscribe/paydetails_loggeduser.php?id='.$courseid; ?>";
          self.close();
</script>
 <?php } ?>

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
	}
	</script>
<?php 	//echo $OUTPUT->footer();	?>
