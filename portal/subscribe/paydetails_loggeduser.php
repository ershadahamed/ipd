<?php 
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
    include('../../manualdbconfig.php'); 
    require_once('../../functiontime.php');
    require_once("../../includes/functions.php"); 
	
    $site = get_site();

    $buy_cifa='Buy IPD Courses';
	$buyipd=get_string('buyacifa');
	$selectprogram='Select Program';
	$your_details='Your Details';
    $lmstitle="$SITE->shortname: Courses - ".$buy_cifa;
    $PAGE->set_title($lmstitle);
    $PAGE->set_heading($site->fullname);
	$PAGE->navbar->add($buyipd)->add($selectprogram)->add($your_details);
	$PAGE->set_pagelayout('buy_a_cifa');

    echo $OUTPUT->header();	

    $id=$_GET['id'];
    $sql_ = mysql_query("SELECT * FROM mdl_cifacourse WHERE id='$id' ORDER BY id DESC");
    $row = mysql_fetch_array($sql_); 
	//action button//delete, clear, update
	if(isset($_REQUEST['command'])){
	if($_REQUEST['command']=='delete' && $_REQUEST['pid']>0){
		remove_product($_REQUEST['pid']);
	}}	
?>
<style>
<?php 
    include('../../css/style2.css'); 
    //include('../../css/style.css'); 
?>

ol #myList
{
	list-style-type:lower-roman;
	text-align: justify;
}

#userpolicy
{
	width:95%;
	margin:0 auto;
	border-collapse: collapse;
	border: 2px solid rgb(152, 191, 33);
	background-color:#fff;	
}
</style>
<script language="javascript">
function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
</script>
<script language="javascript">
	function del(pid){
		if(confirm('Do you really mean to delete this item')){
			document.fullpackinfo.pid.value=pid;
			document.fullpackinfo.command.value='delete';
			document.fullpackinfo.submit();
		}
	}
</script>
<?php include('../../js/js_idletime.php'); ?>
<!--**********************FORM AREA****************************************************************-->
<form id="fullpackinfo" name="fullpackinfo" action="confirmation_loggeduser.php" method="post" onSubmit="return valCari(this);">
	<input type="hidden" name="pid" />
    <input type="hidden" name="command" />
<?php 
        $DOBUSER  = $DB->get_records('user',array('id'=>$USER->id));
                foreach($DOBUSER as $DOB){ } 
?>	


<!--- step by step----->
<style>
#shopcart img{max-width:80%;}
</style>
<table id="shopcart" width="80%" border="0" style="text-align:left;">
        <tr>
        <td><img src="../../image/step2_your_details.png" width="80%"></td>  
        </tr>
</table> 


<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Shopping Cart</legend>
<div style="margin:0px auto; width:95%; padding-top:20px;">
	<div style="color:#F00"><?php echo $msg?></div>
	<table id="availablecourse2" width="100%">
	<?php
		if(is_array($_SESSION['cart'])){
			echo '<tr class="yellow" bgcolor="#FFFFFF" style="font-weight:bold">
					<th width="1%" align="center">No.</th>
					<th width="45%">Course Name</th>
					<th width="10%" style="text-align:center;">Price</th>
					<th width="10%" style="text-align:center;">Amount</th>
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
				<td class="adjacent" style="text-align:left;"><?php echo $pname?></td>
				<td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)?></td>
				<td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)*$q?></td>
				</tr>
		<?php					
			}
			if($max>0){
		?>
			<tr style="height:30px;">
				<td class="adjacent" colspan="2" width="70%">&nbsp;</td>
				<td class="adjacent" style="text-align:center;"><b>Order Total</b></td>
				<td class="adjacent" style="text-align:center;"><b>$ <?php echo get_order_total()?></b></td>
			</tr>
		<?php
			}else{
				echo "<tr bgColor='#FFFFFF'><td class='adjacent' colspan='7'>There are no items in your shopping cart!</td>";
			}
		}
		else{
			echo "<tr bgColor='#FFFFFF'><td class='adjacent'>There are no items in your shopping cart!</td>";
		}
	?>
	</table>
</div>
</fieldset>	
<!-- End purchasing order -->	

<!-- Payment Information for user to fill out -->	
<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Candidate Information</legend>
<?php $strrequired='<font style="color: red;">*</font>'; ?>
    <table id="formpayment" style="border-collapse:collapse; margin:3em auto; width:95%;">
    <tr><td width="20%"><?=get_string('candidateid');?></td><td width="1%">:</td>
		<td><?php echo strtoupper($DOB->traineeid); ?><input type="hidden" name="traineeid" id="traineeid" value="<?php echo $DOB->traineeid; ?>" />
		</td></tr>
    <tr><td><?=get_string('title');?></td><td width="1%">:</td>
		<td><?php if($DOB->title=='0'){ echo 'Mr'; } ?>
		<?php if($DOB->title=='1'){ echo 'Mrs'; } ?>
		<?php if($DOB->title=='2'){ echo 'Miss'; } ?>
		<input type="hidden" size="40" name="title" id="title" value="<?php echo $DOB->title; ?>"/>
		</td></tr>			
    <tr><td><?=get_string('firstname');?><?=$strrequired;?></td><td width="1%">:</td>
		<td>
			<?php echo $DOB->firstname; ?><input type="hidden" size="40" name="name" id="firstname" value="<?php echo $DOB->firstname; ?>"/>
		</td></tr>
    <tr><td><?=get_string('middlename');?></td><td width="1%">:</td>
		<td>
			<?php if($DOB->middlename==''){ ?>
				<input type="text" size="40" name="middlename" id="middlename"/>
			<?php }else{ echo $DOB->middlename; ?>
				<input type="hidden" size="40" name="middlename" id="middlename" value="<?php echo $DOB->middlename; ?>"/>
			<?php } ?>
		</td></tr>		
    <tr><td><?=get_string('lastname');?><?=$strrequired;?></td><td width="1%">:</td>
		<td><?php echo $DOB->lastname; ?><input type="hidden" size="40" name="lastname" id="lastname" value="<?php echo $DOB->lastname; ?>" />
		</td></tr>	
	<tr><td><?=get_string('dob');?><?=$strrequired;?></td><td width="1%">:</td>
		<td><?php echo date('d-m-Y', $DOB->dob); ?><input type="hidden" size="40" name="dob" id="dob" value="<?php echo $DOB->dob; ?>" /></td>
	</tr>
	<tr>
		<td><?=get_string('gender');?><?=$strrequired;?></td><td width="1%">:</td><td>
		<?php if($DOB->gender == '0'){ echo 'Male'; }else{ echo 'Female'; }  ?></td>
	</tr>
    <tr>
		<td><?=get_string('email');?><?=$strrequired;?></td>
		<td width="1%">:</td>
		<td><input type="text" name="email" size="40" id="email" value="<?php echo $DOB->email; ?>"/></td>
	</tr>	
	<tr>
		<td><?=get_string('address1');?></td><td width="1%">:</td>
		<td><input type="text" name="trainee_address" size="40" id="address1" value="<?=$DOB->address;?>" /></td>
	</tr>
	<tr>
		<td><?=get_string('address2');?></td><td width="1%">:</td>
		<td><input type="text" name="address2" size="40" id="address2" value="<?=$DOB->address2;?>" /></td>
	</tr>
	<tr>
		<td><?=get_string('address3');?></td><td width="1%">:</td>
		<td><input type="text" name="address3" size="40" id="address3" value="<?=$DOB->address3;?>" /></td>
	</tr>		
    <tr>
		<td><?=get_string('city');?><?=$strrequired;?></td><td width="1%">:</td>
		<td><input type="text" name="city" id="city" value="<?php echo $DOB->city; ?>" /></td>
	</tr>    
	<tr>
		<td><?=get_string('zip');?><?=$strrequired;?></td><td width="1%">:</td>
		<td><?php if($DOB->country=='MY'){ ?>
			<input type="text" maxlength="5" name="postcode" id="postcode" value="<?php echo $DOB->postcode; ?>" />
			<?php }else{ ?>
			<input type="text" name="postcode" id="postcode" value="<?php echo $DOB->postcode; ?>" />
			<?php } ?>
		</td>
	</tr>    
	<tr>
		<td><?=get_string('state');?></td><td width="1%">:</td>
		<td>
			<?php if($DOB->country=='MY'){ ?>
				<select name="state" id="state">
				<option value=""> - </option>
				<?php
					$kodnegeri=mysql_query("SELECT Negeri FROM {$CFG->prefix}kodnegeri ORDER BY ptkarrangement ASC");
					while($kn=mysql_fetch_array($kodnegeri)){
						echo "<option value='".$kn['Negeri']."'>".$kn['Negeri']."</option>";
					}
				?>
				</select>
			<?php }else{ ?>
			<input type="text" name="state" id="state" value="<?php echo $DOB->state; ?>" />
			<?php } ?>
		</td>
	</tr>	
    <tr><td><?=get_string('selectacountry');?><?=$strrequired;?></td><td width="1%">:</td>
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

            <?php
                $pilihnegara=mysql_query("SELECT * FROM mdl_cifacountry_list WHERE countrycode='".$DOB->country."'");
                $negarapilihan=mysql_fetch_array($pilihnegara);
                echo $negarapilihan['countryname'];
                echo '<input type="hidden" id="country" name="country" value="'.$negarapilihan['countrycode'].'" />';
            ?>
    </td></tr>
    <tr><td><?=get_string('officetel');?><?=$strrequired;?></td>
            <td width="1%">:</td><td>
            <?php
                    $pilihnegara=mysql_query("SELECT * FROM mdl_cifacountry_list WHERE countrycode='".$DOB->country."'");
                    $negarapilihan=mysql_fetch_array($pilihnegara);	
                    //echo '<b> +'.$negarapilihan['iso_countrycode'].'</b>';
					echo $cod='+'.$negarapilihan['iso_countrycode'];
            ?>	
            <input type="text" name="phone_no" id="phoneno" value="<?php echo $DOB->phone1; ?>" /> 		
    </td></tr>	
    </table>
</fieldset>

<!-- Communication References -->
<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Communication References</legend>
<?php 
	$policyname="CIFA <sup>TM</sup>";
	//$policyname='SHAPE<sup>TM</sup>';
	$sqlstatement=mysql_query("SELECT * FROM mdl_cifacommunication_rules");	
	$count++;
	$count2++;
	$count3++;        
	$strrequired='<font color="red">*</font>';		
?>
<table style="width:100%;margin:0 auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;"><tr><td>
<p>
  Please read the options in this column carefully. </p>
<table style="width:95%;margin:0 auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;">
    <?php 
		$no='1';
		while($sqlquery=mysql_fetch_array($sqlstatement)){ 
		$bil=$no++;
		if($sqlquery['visible_2']!='0'){
	?>
	<tr valign="top">
		<td>
			<input type="checkbox" name="column<?=$count++;?>" id="column<?=$count2++;?>" value="1" checked <?php if(($bil == '1') || ($bil == '3')){ echo 'disabled="disabled"';} ?> />
		</td>
		<td>
                    <?=$sqlquery['rules_text'];?>
                    <?php
						//popup
						$a = new stdClass();
						
						$policy=$CFG->wwwroot .'/userpolicy.php';
						$a = "<a href=\"javascript:void(0);\" onclick=\"popupwindow('".$policy."', 'myPop1',820,600);\"><u><b>".get_string('cifaonlinepolicy')."</b></u></a>";
						if($bil=='3'){
							echo get_string('compreference3', '', $a);
						}				
						//End popup
						
                        if($sqlquery['existingreg']!='0'){
                        echo $strrequired;
                        }	
                    ?>
		</td>
	</tr>	
	<?php }} ?>
	<input type="hidden" name="column1" id="column1" value="1" />
	<input type="hidden" name="column3" id="column3" value="1" />
</table></td></tr></table><br/></fieldset>

<p align="center">
<input id="id_defaultbutton" type="submit" name="backbutton" onclick="this.form.action='<?=$CFG->wwwroot.'/purchasemodule.php?id='.$USER->id;?>'" title="back to select program/course" value=" Back " />
<input type="submit" name="submit" style="cursor:pointer;" value="Proceed" title="Click 'Proceed' to confirm subscribe module" />
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
		var gender = form.gender.value;
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
		else if(!gender) { 
			VAL = false;
			alert("Please select one");
			return false; 
		} 		
	}
	</script>
<?php 	echo $OUTPUT->footer();	?>
