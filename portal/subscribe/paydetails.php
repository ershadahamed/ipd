
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
	//$PAGE->set_pagelayout('courses');

	echo $OUTPUT->header();	
	
		$id=$_GET['id'];
		$sql_ = mysql_query("SELECT * FROM mdl_cifacourse WHERE id='$id' ORDER BY id DESC");
		$row = mysql_fetch_array($sql_); 
	?>

<!--**********************FORM AREA****************************************************************-->
<form id="fullpackinfo" name="fullpackinfo" action="fullpack-confimation-info.php" method="post" onSubmit="return valCari(this);">
<br/>	
	<fieldset id="fieldset"><legend id="legend">Module Information</legend>
	<table id="formpayment">
	  <tr>
		<td width="20%">Course Name</td>
		<td width="1%">:</td>
		<td>
			<?php echo '<b>'.ucwords(strtolower($row['fullname'])).'</b>'; ?>
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
			<td><div style="text-align:justify; background-color:#EFF7FB;">
			<?php if($row['summary']!=''){echo $row['summary'];}else{echo 'none';} ?>
			<input type="hidden" name="summary" value="<?php echo $row['summary']; ?>"></div>
			</td>			
		</tr>
	  <tr valign="top">
		<td width="20%">Course Cost</td>
		<td width="1%">:</td>
		<td>
		<img alt="<?php print_string('paypalaccepted', 'enrol_paypal'); ?>" src="https://www.paypal.com/en_US/i/logo/PayPal_mark_60x38.gif" title="PayPal payments accepted" align="center" />
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
			
				//to get a cost amount from admin setting
				$id=$_GET['id'];
				
				$sql_paypalamount="SELECT cost, currency FROM mdl_cifaenrol WHERE courseid='$id' AND enrol='paypal'";
				$query_paypalamount=mysql_query($sql_paypalamount);
				$paypal_row=mysql_fetch_array($query_paypalamount);
				
					echo '&nbsp;<b>'.$paypal_row['cost'].' '.$paypal_row['currency'].'</b>';
			?>
			<input type="hidden" name="cost" value="<?php echo $paypal_row['cost'];?>">
			<input type="hidden" name="currency" value="<?php echo $paypal_row['currency'];?>">
			<input type="hidden" name="PaypalBusinessEmail" value="<?php echo $PaypalBusinessEmail; ?>"/>
		</td>
	  </tr>
	</table></fieldset>

<!-- Payment Information for user to fill out -->	
<fieldset id="fieldset"><legend id="legend">Candidate Information</legend><?php $strrequired='<font style="color: red;"> &nbsp; * </font>'; ?>
	<table id="formpayment">
	<!--tr><td width="20%">Candidate ID	</td><td width="1%">:</td><td><input type="text" name="traineeid" id="traineeid" /></td></tr-->
	<tr><td width="20%">First Name			</td><td width="1%">:</td><td><input type="text" name="name" size="40" id="firstname" /><?=$strrequired;?>	</td></tr>
	<tr><td>Last Name			</td><td width="1%">:</td><td><input type="text" name="lastname" size="40" id="lastname" /><?=$strrequired;?>	</td></tr>	
	<tr><td>D.O.B			</td><td width="1%">:</td><td>	

	<?php
		//$day=array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
		$day=array_combine(range(31, 1), range(31, 1));
		$month=array(
		"1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July",
		"8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
		$years = array_combine(range(date("Y"), 1900), range(date("Y"), 1900));
		
	?>
		<select id="day" name="day">
		<option value="">Day</option>
		<?php
		asort($day);
		reset($day);	
			foreach($day as $key => $value):
			echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
			endforeach;
		?>
		</select>
		
		<select id="month" name="month">
		<option value="">Month</option>
		<?php
	
			foreach($month as $key => $value):
			echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
			endforeach;
		?>
		</select>

		<select id="years" name="years">
		<option value="">Year</option>
		<?php
	
			foreach($years as $key => $value):
			echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
			endforeach;
		?>
		</select>	<?=$strrequired;?>		
	</td></tr>

	<tr><td>Street address					</td><td width="1%">:</td><td><input type="text" name="trainee_address" size="40" id="address1" /><?=$strrequired;?>	</td></tr>
	<tr><td>Street address(cont.)					</td><td width="1%">:</td><td><input type="text" name="address2" id="address2" size="40"/></td></tr>
	<tr><td>Email					</td><td width="1%">:</td><td><input type="text" name="email" id="email" /><?=$strrequired;?>	</td></tr>
	<tr><td>Phone Number				</td><td width="1%">:</td><td><input type="text" name="phone_no" id="phoneno" /></td></tr>
	<tr><td>City				</td><td width="1%">:</td><td><input type="text" name="city" id="city" /></td></tr>	
	<tr><td>Province / State				</td><td width="1%">:</td><td><input type="text" name="province" id="state" /></td></tr>
	<tr><td>Postal / Zip Code				</td><td width="1%">:</td><td><input type="text" name="postal" id="postal" /></td></tr>
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
			echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
			endforeach;
		?>
		</select><?=$strrequired;?>	
	</td></tr>
	</table>
	
	

<script type="text/javascript">
String.prototype.toTitleCase = function() {
    return this.replace(/([\w&`'‘’"“.@:\/\{\(\[<>_]+-? *)/g, function(match, p1, index, title) {
        if (index > 0 && title.charAt(index - 2) !== ":" &&
        	match.search(/^(a(nd?|s|t)?|b(ut|y)|en|for|i[fn]|o[fnr]|t(he|o)|vs?\.?|via)[ \-]/i) > -1)
            return match.toLowerCase();
        if (title.substring(index - 1, index + 1).search(/['"_{(\[]/) > -1)
            return match.charAt(0) + match.charAt(1).toUpperCase() + match.substr(2);
        if (match.substr(1).search(/[A-Z]+|&|[\w]+[._][\w]+/) > -1 || 
        	title.substring(index - 1, index + 1).search(/[\])}]/) > -1)
            return match;
        return match.charAt(0).toUpperCase() + match.substr(1);
    });
};
</script>

<!--table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td width="20%">Title</td>
    <td>
        <input type="radio" name="radio" id="radio" value="mr" />
        Mr.
        <input type="radio" name="radio" id="radio2" value="mrs" />
        Mrs.
        <input type="radio" name="radio" id="radio3" value="ms" />
        Ms.
	</td>
  </tr>
  <tr>
    <td>Fullname</td>
    <td><label for="textfield"></label>
    <input type="text" name="fullname" id="fullname" style="width:250px;" onKeyUp="javascript:this.value=this.value.toTitleCase()" /><?=$strrequired;?></td>
  </tr>
  <tr>
    <td>D.O.B</td>
    <td>
	<?php/*
		$day=array_combine(range(31, 1), range(31, 1));
		$month=array(
		"1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July",
		"8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
		$years = array_combine(range(date("Y"), 1900), range(date("Y"), 1900));
		
	?>
		<select id="day" name="day">
		<option value="">Day</option>
		<?php
		asort($day);
		reset($day);	
			foreach($day as $key => $value):
			echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
			endforeach;
		?>
		</select>
		
		<select id="month" name="month">
		<option value="">Month</option>
		<?php
	
			foreach($month as $key => $value):
			echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
			endforeach;
		?>
		</select>

		<select id="years" name="years">
		<option value="">Year</option>
		<?php
	
			foreach($years as $key => $value):
			echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
			endforeach;
		?>
		</select>	
	<?=$strrequired;?></td>
  </tr>  
  <tr>
    <td>Company name</td>
    <td><input type="text" name="companyname" id="companyname" style="width:250px;" onKeyUp="javascript:this.value=this.value.toTitleCase()" /><?=$strrequired;?></td>
  </tr>
  <tr>
    <td>Job title</td>
    <td><input type="text" name="jobtitle" id="jobtitle" style="width:250px;" onKeyUp="javascript:this.value=this.value.toTitleCase()" /><?=$strrequired;?></td>
  </tr>
  <tr>
    <td>Work / Personal email</td>
    <td><input type="text" name="email" id="email" style="width:250px;" /><?=$strrequired;?></td>
  </tr>
  <tr>
    <td>Work telephone no.</td>
    <td><input type="text" name="wtelephone" id="wtelephone" style="width:250px;" /><?=$strrequired;?></td>
  </tr>
  <tr>
    <td>Fax no.</td>
    <td><input type="text" name="faxno" id="faxno" style="width:250px;" /></td>
  </tr>
  <tr>
    <td>Address</td>
    <td><input type="text" name="address1" id="address1" style="width:250px;" onKeyUp="javascript:this.value=this.value.toTitleCase()" /><?=$strrequired;?></td>
  </tr>
  <tr>
    <td>Address (cont.)</td>
    <td><input type="text" name="address2" id="address2" style="width:250px;" onKeyUp="javascript:this.value=this.value.toTitleCase()" /></td>
  </tr>
  <tr>
    <td>Address (cont.)</td>
    <td><input type="text" name="address3" id="address3" style="width:250px;" onKeyUp="javascript:this.value=this.value.toTitleCase()" /></td>
  </tr>
  <tr>
    <td>Postcode</td>
    <td><input type="text" name="postcode" id="postcode" /></td>
  </tr>
  <tr>
    <td>City</td>
    <td><input type="text" name="city" id="city" /><?=$strrequired;?></td>
  </tr>
  <tr>
    <td>Country</td>
    <td>
	<?php 
	//list out of country
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
		<select id="country" name="country" style="width:250px;">
		<option value=""> - country - </option>
		<?php
		asort($country_list);
		reset($country_list);	
			foreach($country_list as $key => $value):
			echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
			endforeach;
		?>
		</select><?=$strrequired;*/?>  
    </td>
  </tr>  
</table-->
	</fieldset>
<p align="center"><input type="submit" name="submit" value="Proceed" title="Click 'Proceed' to confirm subscribe module" /></p>
</form>
	<script language="JavaScript" type="text/javascript">
	//You should create the validator only after the definition of the HTML form
	function valCari(form)
	{
		var VAL = true;		
		//var traineeid = form.traineeid.value;
		var name = form.name.value;
		//var lastname = form.lastname.value;
		var address1 = form.address1.value;
		var email = form.email.value;
		var phone_no = form.phone_no.value;
	 		
		if(!name)
		{
			VAL = false;
			alert("Please enter first name");
			form.name.focus();
			return false;
		}
		
		/*else if(!lastname)
		{
			VAL = false;
			alert("Please enter last name");
			form.lastname.focus();
			return false;
		}*/
		
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
<?php 	echo $OUTPUT->footer();	?>
