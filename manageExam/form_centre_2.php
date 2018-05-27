<!-- <form id="form1" name="form1" method="post" action="manageExam/manageexam-exe.php" onSubmit="return isValid()">-->

	<table id="newcentre">
	<tr>
		<td>License No</td>
		<td>:</td>
		<td><input type="text" name="license" value="" /></td>
	</tr>	
	<tr>
		<td width="20%">Centre code</td>
		<td width="1%">:</td>
		<td>
		<?php 
			$autoid=mt_rand(); //autoid number
			echo $autoid;
		?>
		<input type="hidden" name="centrecode" id="centrecode" value="<?php echo $autoid; ?>" />
		</td>
	</tr>
	<tr>
		<td>Centre name</td>
		<td>:</td>
		<td><input type="text" name="centreName" id="centreName" size="40" /></td>
	</tr>
	<tr>
		<td>Address 1</td>
		<td>:</td>
		<td><input type="text" name="address1" id="address1" size="40" /></td>
	</tr>
	<tr>
		<td>Address 2</td>
		<td>:</td>
		<td><input type="text" name="address2" id="address2" size="40" /></td>
	</tr>
	<tr>
		<td>State</td>
		<td>:</td>
		<td><input type="text" name="state" id="state" size="40" /></td>
	</tr>
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
		"Afghanistan",
		"Albania",
		"Algeria",
		"Andorra",
		"Angola",
		"Antigua and Barbuda",
		"Argentina",
		"Armenia",
		"Australia",
		"Austria",
		"Azerbaijan",
		"Bahamas",
		"Bahrain",
		"Bangladesh",
		"Barbados",
		"Belarus",
		"Belgium",
		"Belize",
		"Benin",
		"Bhutan",
		"Bolivia",
		"Bosnia and Herzegovina",
		"Botswana",
		"Brazil",
		"Brunei",
		"Bulgaria",
		"Burkina Faso",
		"Burundi",
		"Cambodia",
		"Cameroon",
		"Canada",
		"Cape Verde",
		"Central African Republic",
		"Chad",
		"Chile",
		"China",
		"Colombi",
		"Comoros",
		"Congo (Brazzaville)",
		"Congo",
		"Costa Rica",
		"Cote d'Ivoire",
		"Croatia",
		"Cuba",
		"Cyprus",
		"Czech Republic",
		"Denmark",
		"Djibouti",
		"Dominica",
		"Dominican Republic",
		"East Timor (Timor Timur)",
		"Ecuador",
		"Egypt",
		"El Salvador",
		"Equatorial Guinea",
		"Eritrea",
		"Estonia",
		"Ethiopia",
		"Fiji",
		"Finland",
		"France",
		"Gabon",
		"Gambia, The",
		"Georgia",
		"Germany",
		"Ghana",
		"Greece",
		"Grenada",
		"Guatemala",
		"Guinea",
		"Guinea-Bissau",
		"Guyana",
		"Haiti",
		"Honduras",
		"Hungary",
		"Iceland",
		"India",
		"Indonesia",
		"Iran",
		"Iraq",
		"Ireland",
		"Israel",
		"Italy",
		"Jamaica",
		"Japan",
		"Jordan",
		"Kazakhstan",
		"Kenya",
		"Kiribati",
		"Korea, North",
		"Korea, South",
		"Kuwait",
		"Kyrgyzstan",
		"Laos",
		"Latvia",
		"Lebanon",
		"Lesotho",
		"Liberia",
		"Libya",
		"Liechtenstein",
		"Lithuania",
		"Luxembourg",
		"Macedonia",
		"Madagascar",
		"Malawi",
		"Malaysia",
		"Maldives",
		"Mali",
		"Malta",
		"Marshall Islands",
		"Mauritania",
		"Mauritius",
		"Mexico",
		"Micronesia",
		"Moldova",
		"Monaco",
		"Mongolia",
		"Morocco",
		"Mozambique",
		"Myanmar",
		"Namibia",
		"Nauru",
		"Nepa",
		"Netherlands",
		"New Zealand",
		"Nicaragua",
		"Niger",
		"Nigeria",
		"Norway",
		"Oman",
		"Pakistan",
		"Palau",
		"Panama",
		"Papua New Guinea",
		"Paraguay",
		"Peru",
		"Philippines",
		"Poland",
		"Portugal",
		"Qatar",
		"Romania",
		"Russia",
		"Rwanda",
		"Saint Kitts and Nevis",
		"Saint Lucia",
		"Saint Vincent",
		"Samoa",
		"San Marino",
		"Sao Tome and Principe",
		"Saudi Arabia",
		"Senegal",
		"Serbia and Montenegro",
		"Seychelles",
		"Sierra Leone",
		"Singapore",
		"Slovakia",
		"Slovenia",
		"Solomon Islands",
		"Somalia",
		"South Africa",
		"Spain",
		"Sri Lanka",
		"Sudan",
		"Suriname",
		"Swaziland",
		"Sweden",
		"Switzerland",
		"Syria",
		"Taiwan",
		"Tajikistan",
		"Tanzania",
		"Thailand",
		"Togo",
		"Tonga",
		"Trinidad and Tobago",
		"Tunisia",
		"Turkey",
		"Turkmenistan",
		"Tuvalu",
		"Uganda",
		"Ukraine",
		"United Arab Emirates",
		"United Kingdom",
		"United States",
		"Uruguay",
		"Uzbekistan",
		"Vanuatu",
		"Vatican City",
		"Venezuela",
		"Vietnam",
		"Yemen",
		"Zambia",
		"Zimbabwe",
		"Palestin"
	);?>		

	<select id="country" name="country">
	<option value="">----- Please select country ------</option>
	<?php
    asort($country_list);
    reset($country_list);	
		foreach($country_list as $key => $value):
		echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
		endforeach;
	?>
	</select>
		
		
		</td>
	</tr>
	<tr>
		<td>Zip code</td>
		<td>:</td>
		<td><input type="text" name="zip" id="zip" maxlength="5" size="40" /></td>
	</tr>
	<tr>
		<td>Telephone no.</td>
		<td>:</td>
		<td><input type="text" name="office" id="office" size="40" /></td>
	</tr>
	<tr>
		<td>Fax no.</td>
		<td>:</td>
		<td><input type="text" name="fax" id="fax" size="40" /></td>
	</tr>
	<tr>
		<td>Email</td>
		<td>:</td>
		<td><input type="text" name="email2" id="email2" size="40" /></td>
	</tr>
	</table>
<div id="button_exam">
	<input type="submit" name="submit" value="Add New Centre" title="Add New Centre" />
	<input type="reset" name="reset" value="Reset" title="Reset form" />
</div><br/>
