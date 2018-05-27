<form id="form1" name="form1" method="post" action="manageExam/manageexam-exe.php" onSubmit="return valCari(this);">
<!-----***********************New***************************************************------------>
<br/>
<fieldset style="border:1px solid #000000; width: 95%; margin-right: auto; margin-left: auto;">
	<legend style="font-weight: bold; margin: 0 10px 0 10px; padding:0 10px 0 10px;">Add new exam center</legend>
	<div style="padding:20px; float: left; width:100%;">	
	<table width="100%" style="border: 2px solid #FFF;">
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Licence No</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="licence" id="licence" /></td>
	</tr>	
	<tr style="border: 2px solid #FFF;">
		<td width="20%" style="border: 2px solid #FFF;">Centre code</td>
		<td width="1%" style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;">
		<?php 
		$autoid=mt_rand(); //autoid number
		echo $autoid;
		?>
		</td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Centre name</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="centreName" id="centreName" size="40" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Address 1</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="address1" id="address1" size="40" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Address 2</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="address2" id="address2" size="40" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">State</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="state" id="state" size="40" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">City</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="city" id="city"  size="40" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Country</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;">
		
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
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Zip code</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="zip" id="zip" maxlength="5" size="40" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Telephone no.</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="office" id="office" size="40" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Fax no.</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="fax" id="fax" size="40" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Email</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="email" id="email" size="40" /></td>
	</tr>
	</table>
	</div>
</fieldset>
<div style="padding-bottom:10px; width:100%; text-align:center;"><input type="submit" name="submit" value="Add-New-Centre" /></div>

</form><br/>
	<script language="JavaScript" type="text/javascript">
	//You should create the validator only after the definition of the HTML form
	function valCari(form)
	{
		var VAL = true;		
		var licence = form.licence.value;
		var code = form.code.value;
		var centreName = form.centreName.value;
		var address1 = form.address1.value;
		var state = form.state.value;
		
		var city = form.city.value;
		var zip = form.zip.value;
		var office = form.office.value;
		var fax = form.fax.value;
		var email = form.email.value;
	 
		if(!code)
		{
			VAL = false;
			alert("Centre code required.");
			form.code.focus();
			return false;
		}

		else if(!licence)
		{
			VAL = false;
			alert("Licence numbe required.");
			form.licence.focus();
			return false;
		}		
		
		else if(!centreName)
		{
			VAL = false;
			alert("Centre name required.");
			form.centreName.focus();
			return false;
		}
		
		else if(!address1)
		{
			VAL = false;
			alert("Address required");
			form.address1.focus();
			return false;
		}
		
		else if(!state)
		{
			VAL = false;
			alert("State required");
			form.state.focus();
			return false;
		}
		
		else if(!city)
		{
			VAL = false;
			alert("City required");
			form.city.focus();
			return false;
		}
		
		else if(!zip)
		{
			VAL = false;
			alert("Zip code required.");
			form.zip.focus();
			return false;
		}
		else if(!office)
		{
			VAL = false;
			alert("Office telephone number required.");
			form.office.focus();
			return false;
		}
		else if(!fax)
		{
			VAL = false;
			alert("Fax number required.");
			form.fax.focus();
			return false;
		}
		else if(!email)
		{
			VAL = false;
			alert("Email required.");
			form.email.focus();
			return false;
		}
	}
	</script>  

<?php
	include('examCenterList.php');
?>
