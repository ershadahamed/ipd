<!-- <form id="form1" name="form1" method="post" action="manageExam/manageexam-exe.php" onSubmit="return isValid()">-->

	<table id="newcentre">
	<tr>
		<td width="20%">Centre code</td>
		<td width="1%">:</td>
		<td>
		<?php 
			//$autoid=mt_rand(); //autoid number
			//echo $autoid;
			
			$countno=mysql_query("Select * From mdl_cifa_exam ORDER BY id DESC");
			//$num_rows=mysql_num_rows($countno);
			$num_rows=mysql_fetch_array($countno);
			$nums=$num_rows['id'] + 1;
			if($nums < 10){ $a='0000'; }
			elseif($nums < 100){ $a='000'; }
			elseif($nums < 1000){ $a='00'; }
			else{ $a='0'; }
		?>
		<input type="text" name="centrecode" id="centrecode" readonly="readonly" style="border:0; background-color: #EFF7FB; font-weight:bold;" />
		<input type="hidden" name="centrecode1" id="centrecode1" value="<?php echo $a.''.$nums;?>" />
		<input type="hidden" name="centrecode2" id="centrecode2"/>
		</td>
	</tr>
	<tr>
		<td>Centre name</td>
		<td>:</td>
		<td><input type="text" name="centreName" id="centreName" size="40" /></td>
	</tr>
	<tr>
		<td>Street Addres 1</td>
		<td>:</td>
		<td><input type="text" name="address1" id="address1" size="40" /></td>
	</tr>
	<tr>
		<td>Street Addres 2</td>
		<td>:</td>
		<td><input type="text" name="address2" id="address2" size="40" /></td>
	</tr>
	<!--tr>
		<td>State</td>
		<td>:</td>
		<td><input type="text" name="state" id="state" size="40" /></td>
	</tr-->
	<tr>
		<td>City</td>
		<td>:</td>
		<td><input type="text" name="city" id="city"  size="40" /></td>
	</tr>
	<tr>
		<td>Country</td>
		<td>:</td>
		<td>
		
<?php		
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
	<option value="">----- Please select country ------</option>
	<?php
    asort($country_list);
    reset($country_list);	
		foreach($country_list as $key => $value):
		echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
		endforeach;
	?>
	</select>
		
		</td>
	</tr>
	<!--tr>
		<td>Zip code</td>
		<td>:</td>
		<td><input type="text" name="zip" id="zip" maxlength="5" size="40" /></td>
	</tr-->
	<tr>
		<td>Centre coordinator</td>
		<td>:</td>
		<td><input type="text" name="license" value="" size="40"/></td>
	</tr>		
	<tr>
		<td>Center line num.</td>
		<td>:</td>
		<td>
			<input type="text" name="office" id="office" size="15" />		
			<input type="text" name="countrycode" id="countrycode" size="10" readonly="readonly" style="border:0; background-color: #EFF7FB; font-weight:bold;"/>
			<input type="hidden" name="centreline" id="centreline" value="" />
		</td>
	</tr>	
	<tr>
		<td>Fax num.</td>
		<td>:</td>
		<td>
			<input type="text" name="fax" id="fax" size="15" />
			<input type="text" name="countrycode2" id="countrycode2" size="10" readonly="readonly" style="border:0; background-color: #EFF7FB; font-weight:bold;"/>
			<input type="hidden" name="faxnum" id="faxnum" value="" />
		</td>
	</tr>
	<tr>
		<td>Mobile num.</td>
		<td>:</td>
		<td><input type="text" name="mobile" id="mobile" size="40" /></td>
	</tr>	
	<tr>
		<td>Email</td>
		<td>:</td>
		<td><input type="text" name="email2" id="email2" size="40" /></td>
	</tr>
	<tr><td colspan="3">
	
<table style="margin-bottom: 0em; margin-top: 1em;"><tr><td>
<div class="buttons" style="float: right;">
    <a href="<?='../manage_exam_index.php?categoryedit=off'; ?>" class="positive" title="Back to list of exam centre">
        <img src="Images/switch_course_alternative.png" alt=""/>
        List of exam centre
    </a>    
	
	<button type="submit" class="positive" name="submit">
        <img src="Images/apply2.png" alt=""/>
        Save New Centre
    </button>

    <button type="reset" class="negative" name="reset">
        <img src="Images/cross.png" alt=""/>
        Reset
    </button>
</div>
</td></tr></table></td></tr></table>
