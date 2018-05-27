<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Moodle frontpage.
 *
 * @package    core
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');

    if ($CFG->forcelogin) {
        require_login();
    } else {
        user_accesstime_log();
    }

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);

    $PAGE->set_pagetype('site-index');
    $PAGE->set_other_editing_capability('moodle/course:manageactivities');
    $PAGE->set_docs_path('');
    $PAGE->set_pagelayout('frontpage');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
    echo $OUTPUT->header();


    //foreach (explode(',',$frontpagelayout) as $v) {
        //if ($v) {     /// Display the main part of the front page.
			//if ((!has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM)) and !isguestuser()) or ($DB->count_records('course') <= FRONTPAGECOURSELIMIT)) {
					echo $OUTPUT->heading(get_string('manageexamcentre'), 2, 'headingblock header');
?>
<style type="text/css">
	<?php 
		require_once('manageExam/button.css'); 
		//require_once('css/style2.css'); 
	?>
	
</style>
<form id="form1" name="form1" method="post" action="manageExam/editCentre-exe.php" onSubmit="return valCari(this);" >

<!-----***********************New***************************************************------------>
<br/>
<fieldset style="border:1px solid #3D91CB; width: 95%; margin-right: auto; margin-left: auto; background-color:#EFF7FB;">
	<legend style="font-weight: bold; margin: 0 10px 0 10px; padding:0 10px 0 10px;">Edit exam center</legend>
	<div style="padding:20px; float: left; width:100%;">

<?php		
	include('manualdbconfig.php');
	
	$ID=$_GET['id'];
	$sqlCheck="Select
  						*
					From
  						mdl_cifa_exam Where id='$ID'";
	$queryCheck=mysql_query($sqlCheck);
	$rowCheck=mysql_fetch_array($queryCheck);
?>
	
	<table width="90%">
	<tr style="border: 2px solid #EFF7FB;">
		<td width="20%" style="border: 2px solid #EFF7FB;">Centre code</td>
		<td width="1%" style="border: 2px solid #EFF7FB;">:</td>
		<td style="border: 2px solid #EFF7FB;">
		<!-- input type="hidden" name="id" id="id" size="40" value="<?php //echo $rowCheck['id']; ?>" /-->
		<input type="hidden" name="id" id="id" size="40" value="<?php echo $rowCheck['id']; ?>" />
		<input type="hidden" name="centrecode_edit" id="centrecode_edit" size="40" value="<?php echo $rowCheck['centre_code']; ?>" />
		<?php echo $rowCheck['centre_code']; ?>
		<?php //echo $rowCheck['country'].''.$rowCheck['code']; ?>
		</td>
	</tr>
	<tr style="border: 2px solid #EFF7FB;">
		<td style="border: 2px solid #EFF7FB;">Centre name</td>
		<td style="border: 2px solid #EFF7FB;">:</td>
		<td style="border: 2px solid #EFF7FB;"><input type="text" name="centreName" id="centreName" size="40" value="<?php echo $rowCheck['centre_name']; ?>" /></td>
	</tr>
	<tr style="border: 2px solid #EFF7FB;">
		<td style="border: 2px solid #EFF7FB;">Street Address 1</td>
		<td style="border: 2px solid #EFF7FB;">:</td>
		<td style="border: 2px solid #EFF7FB;"><input type="text" name="address1" id="address1" size="40" value="<?php echo $rowCheck['address']; ?>" /></td>
	</tr>
	<tr style="border: 2px solid #EFF7FB;">
		<td style="border: 2px solid #EFF7FB;">Street Address 2</td>
		<td style="border: 2px solid #EFF7FB;">:</td>
		<td style="border: 2px solid #EFF7FB;"><input type="text" name="address2" id="address2" size="40" value="<?php echo $rowCheck['address2']; ?>" /></td>
	</tr>
	<!--tr style="border: 2px solid #EFF7FB;">
		<td style="border: 2px solid #EFF7FB;">State</td>
		<td style="border: 2px solid #EFF7FB;">:</td>
		<td style="border: 2px solid #EFF7FB;"><input type="text" name="state" id="state" size="40" value="<?php echo $rowCheck['state1']; ?>" /></td>
	</tr-->
	<tr style="border: 2px solid #EFF7FB;">
		<td style="border: 2px solid #EFF7FB;">City</td>
		<td style="border: 2px solid #EFF7FB;">:</td>
		<td style="border: 2px solid #EFF7FB;"><input type="text" name="city" id="city"  size="40" value="<?php echo $rowCheck['city']; ?>" /></td>
	</tr>
	<tr style="border: 2px solid #EFF7FB;">
		<td style="border: 2px solid #EFF7FB;">Country</td>
		<td style="border: 2px solid #EFF7FB;">:</td>
		<td style="border: 2px solid #EFF7FB;">
		
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
	<?php if($rowCheck['country'] == ''){ ?>
	<option value=""> -- Please choose country --</option>
	<?php }/*else{ */?>
	<!--option value="<?php //echo $rowCheck['country'];?>" selected><?php //echo $rowCheck['country'];?></option-->
	<?php //} ?>
	<?php
    asort($country_list);
    reset($country_list);	
		foreach($country_list as $key => $value):
		echo '<option value="'.$key.'"';
		if($rowCheck['country']==$key){
		echo 'selected';
		} echo '>'.$value.'</option>'; 
		endforeach;
	?>
	</select>
		
		
		</td>
	</tr>	
	<!--tr style="border: 2px solid #EFF7FB;">
		<td style="border: 2px solid #EFF7FB;">Zip code</td>
		<td style="border: 2px solid #EFF7FB;">:</td>
		<td style="border: 2px solid #EFF7FB;"><input type="text" name="zip" id="zip" maxlength="5" size="40" value="<?php echo $rowCheck['zip']; ?>" /></td>
	</tr-->
	<tr style="border: 2px solid #EFF7FB;">
		<td width="23%" style="border: 2px solid #EFF7FB;">Centre coordinator</td>
		<td width="1%" style="border: 2px solid #EFF7FB;">:</td>
		<td style="border: 2px solid #EFF7FB;">
		<input type="text" name="license" id="license" value="<?php echo $rowCheck['license']; ?>" size="40" />
		</td>
	</tr>		
	<tr style="border: 2px solid #EFF7FB;">
		<td style="border: 2px solid #EFF7FB;">Centre line.</td>
		<td style="border: 2px solid #EFF7FB;">:</td>
		<td style="border: 2px solid #EFF7FB;"><input type="text" name="office" id="office" size="40" value="<?php echo $rowCheck['phone']; ?>" /></td>
	</tr>
	<tr style="border: 2px solid #EFF7FB;">
		<td style="border: 2px solid #EFF7FB;">Fax num.</td>
		<td style="border: 2px solid #EFF7FB;">:</td>
		<td style="border: 2px solid #EFF7FB;"><input type="text" name="fax" id="fax" size="40" value="<?php echo $rowCheck['fax']; ?>" /></td>
	</tr>
	<tr style="border: 2px solid #EFF7FB;">
		<td style="border: 2px solid #EFF7FB;">Mobile num.</td>
		<td style="border: 2px solid #EFF7FB;">:</td>
		<td style="border: 2px solid #EFF7FB;"><input type="text" name="mobile" id="mobile" size="40" value="<?php echo $rowCheck['mobile']; ?>" /></td>
	</tr>	
	<tr style="border: 2px solid #EFF7FB;">
		<td style="border: 2px solid #EFF7FB;">Email</td>
		<td style="border: 2px solid #EFF7FB;">:</td>
		<td style="border: 2px solid #EFF7FB;"><input type="text" name="email" id="email" size="40" value="<?php echo $rowCheck['email']; ?>" /></td>
	</tr>
	</table>
	</div>
</fieldset>

<!-- button section -->
<!--<div style="padding:10px; width:100%; text-align:center;">
<input type="button" value="Back" onclick="javascript:history.go(-1);">
<input type="submit" name="submit" value="Save" />
</div>-->


<div class="buttons" style="float: left; padding-left: 18px;">
    <button type="reset" class="negative" name="back" onclick="javascript:history.go(-1);" title="Back to form add new">
        <img src="<?php echo $CFG->wwwroot. '/manageExam/Images/foward.png'; ?>" />
        Back
    </button>

    <button type="submit" class="positive" name="submit" title="Save update data">
        <img src="<?php echo $CFG->wwwroot. '/manageExam/Images/save.png'; ?>" title="Save update" />
        Save update
    </button>
</div>
<!-- button section -->

</form>
	<script language="JavaScript" type="text/javascript">
	//You should create the validator only after the definition of the HTML form
	function valCari(form)
	{
		var VAL = true;		
		var centreName = form.centreName.value;
		var address1 = form.address1.value;
		var state = form.state.value;
		
		var city = form.city.value;
		var zip = form.zip.value;
		var office = form.office.value;
		var fax = form.fax.value;
		var email = form.email.value;
	 
		if(!centreName)
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
			//}	
       // }
        echo '<br />';
   // }

    echo $OUTPUT->footer();
