<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $contactus = 'Institution Registration';
    $PAGE->navbar->add(ucwords(strtolower($contactus)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
	if (isloggedin()) {
		$csign='<span style="color:red;text-weight:bold;">*</span>';
		$compusory='<span style="color:red;text-weight:bold;">*Compulsory</span>';
?>
<div style="float:right;padding-right:1.5em;"><?=$compusory;?></div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<style>
form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px }
#progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
#percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style>

<center>
<!--h2>Upload Facility</h2-->
<script type="text/javascript">
String.prototype.toTitleCase = function() {
    return this.replace(/([\w&`'??"?.@:\/\{\(\[<>_]+-? *)/g, function(match, p1, index, title) {
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
<script type="text/javascript">
function validateFormOnSubmit(theForm) {
var reason = "";
var f=document.form;

  reason += validateInst_name(theForm.inst_name);
  reason += validateInst_address(theForm.inst_address);  
  reason += validateInst_telephone(theForm.inst_telephone);
  reason += validateOrganization_type(theForm.organization_type);  
      
  if (reason != "") {
    alert("Some fields need correction:\n" + reason);
    return false;
  }

  //alert("All fields are filled correctly");
  //return true;
  //f.submit();
}

function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "The required field has not been filled in.\n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}

function validateInst_name(fld) {
    var error = "";
    var illegalChars = /\W/; // allow letters, numbers, and underscores
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a name.\n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}

function validateInst_address(fld) {
    var error = "";
    var illegalChars = /\W/; // allow letters, numbers, and underscores
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a fullname address.\n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}

function validateInst_telephone(fld) {
    var error = "";
    var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, '');    

   if (fld.value == "") {
        error = "You didn't enter a phone number.\n";
        fld.style.background = 'Yellow';
    } else if (isNaN(parseInt(stripped))) {
        error = "The phone number contains illegal characters.\n";
        fld.style.background = 'Yellow';
    } /* else if (!(stripped.length <= 15)) {
        error = "The phone number is the wrong length. Make sure you included an area code.\n";
        fld.style.background = 'Yellow';
    } */
    return error;
}

function validateOrganization_type(fld) {
    var error = "";
    var illegalChars = /\W/; // allow letters, numbers, and underscores
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't select an Organization Type.\n";
    } /* else if ((fld.value.length < 5) || (fld.value.length > 15)) {
        fld.style.background = 'Yellow'; 
        error = "The message is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The message contains illegal characters.\n";
    } */ else {
        fld.style.background = 'White';
    }
    return error;
}

function trim(s)
{
  return s.replace(/^\s+|\s+$/, '');
}

function validateEmail(fld) {
    var error="";
    var tfld = trim(fld.value);                        // value of field with whitespace trimmed off
    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
   
    if (fld.value == "") {
        fld.style.background = 'Yellow';
        error = "You didn't enter an email address.\n";
    } else if (!emailFilter.test(tfld)) {              //test email for illegal characters
        fld.style.background = 'Yellow';
        error = "Please enter a valid email address.\n";
    } else if (fld.value.match(illegalChars)) {
        fld.style.background = 'Yellow';
        error = "The email address contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}
</script>

<form id="myForm" onsubmit="return validateFormOnSubmit(this)" onChange="return displ();" action="upload.php" method="post" enctype="multipart/form-data">
<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Upload Logo</legend>
     <input type="file" size="60" name="myfile"> <span style="color:red">(File size: below than 1MB)</span>
</fieldset>

<?php
	$sinstitude=mysql_query("SELECT * FROM {$CFG->prefix}organization_type WHERE status='0' And groupofinstitution='0'");
	$scountry=mysql_query("SELECT * FROM {$CFG->prefix}country_list");
?>

<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Institution Details</legend>
<table width="100%" border="0">
  <tr>
    <td width="30%" valign="top">Group of Institution</td>
    <td width="1%">&nbsp;</td>
    <td>
	<select name="groupofinstitution">
		<option value=""> Select Group </option>
		<?php
		$bil='1';
		while($qins=mysql_fetch_array($sinstitude)){
		?>
		<option value="<?=$qins['id'];?>"><?=$qins['name'];?></option>
		<?php
		}
		?>
	</select>
	</td>
  </tr>
  <tr>
    <td width="30%" valign="top">Name
      <?=$csign;?></td>
    <td width="1%">&nbsp;</td>
    <td><input name="inst_name" type="text" id="inst_name" size="80%" onKeyUp="javascript:this.value=this.value.toTitleCase()"></td>
  </tr>
  <tr>
    <td valign="top"><?=get_string('address1');?>
      <?=$csign;?></td>
    <td>&nbsp;</td>
    <td><input name="inst_address" type="text" id="inst_address" size="80%" onKeyUp="javascript:this.value=this.value.toTitleCase()" /></td>
  </tr>
  <tr>
    <td valign="top"><?=get_string('address2');?>
      </td>
    <td>&nbsp;</td>
    <td><input name="inst_address2" type="text" id="inst_address2" size="80%" onKeyUp="javascript:this.value=this.value.toTitleCase()" /></td>
  </tr>
  <tr>
    <td valign="top"><?=get_string('address3');?>
      </td>
    <td>&nbsp;</td>
    <td><input name="inst_address3" type="text" id="inst_address3" size="80%" onKeyUp="javascript:this.value=this.value.toTitleCase()" /></td>
  </tr>  
  <tr>
    <td valign="top"><?=get_string('city');?>
      <?=$csign;?></td>
    <td>&nbsp;</td>
    <td><input type="text" name="inst_city" id="inst_city"></td>
  </tr>
   <tr>
    <td valign="top"><?=get_string('zip');?>
      </td>
    <td>&nbsp;</td>
    <td><input type="text" name="inst_zip" id="inst_zip"></td>
  </tr>
  <tr>
    <td valign="top"><?=get_string('state');?>
      </td>
    <td>&nbsp;</td>
    <td><input type="text" name="inst_state" id="inst_state"></td>
  </tr> 
  <tr>
    <td width="30%" valign="top"><?=get_string('country');?></td>
    <td width="1%">&nbsp;</td>
    <td>	
	<select name="inst_country" id="inst_country">
		<option value=""> Choose One </option>
		<?php
		$bil='1';
		while($qcountry=mysql_fetch_array($scountry)){
		?>
		<option value="<?=$qcountry['countrycode'];?>"><?=$qcountry['countryname'];?></option>
		<?php
		}
		?>
	</select><?=$csign;?>
	</td>
  </tr>  
  <tr>
    <td valign="top">Telephone No.
      <?=$csign;?></td>
    <td>&nbsp;</td>
    <td><input type="text" name="inst_telephone" id="inst_telephone"></td>
  </tr>
  <tr>
    <td valign="top">Faxs No</td>
    <td>&nbsp;</td>
    <td><input type="text" name="inst_faxs" id="inst_faxs"></td>
  </tr>
  <tr>
    <td valign="top">Website</td>
    <td>&nbsp;</td>
    <td><input type="text" name="inst_website" id="inst_website"></td>
  </tr>
  <tr>
    <td valign="top">Organization Type
      <?=$csign;?></td>
    <td>&nbsp;</td>
    <td><select name="organization_type" id="organization_type">
      <option value=""> - Select One - </option>
      <option value="13">Financial Institution</option>
      <option value="12">Business Partner</option>
    </select></td>
  </tr>  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>   
</table>
</fieldset>

<div id="progress">
        <div id="bar"></div>
        <div id="percent">0%</div >
</div>
<br/>
<input type="button" onClick="window.history.back();" name="back" value="<?=get_string('back');?>" title="<?=get_string('back');?>">
<input type="submit" name="Submit" value="<?=get_string('submitmessage');?>">
</form>
<br/>
   
<div id="message"></div>
<script>
$(document).ready(function()
{

	var options = { 
    beforeSend: function() 
    {
    	$("#progress").show();
    	//clear everything
    	$("#bar").width('0%');
    	$("#message").html("");
		$("#percent").html("0%");
    },
    uploadProgress: function(event, position, total, percentComplete) 
    {
    	$("#bar").width(percentComplete+'%');
    	$("#percent").html(percentComplete+'%');

    
    },
    success: function() 
    {
        $("#bar").width('100%');
    	$("#percent").html('100%');

    },
	complete: function(response) 
	{
		$("#message").html("<font color='green'>"+response.responseText+"</font>");
	},
	error: function()
	{
		$("#message").html("<font color='red'> ERROR: unable to upload files</font>");

	}
     
}; 

     $("#myForm").ajaxForm(options);

});

</script>
</center>
<?php 
	}else{
		echo '<div style="color:red">You cannot access this page. Please login.</div>';
	}
	echo $OUTPUT->footer();
?>