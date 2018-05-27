<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $contactus = get_string('manualemailconfig');
	$uploadindextitle = 'Manual Email Config';
    $PAGE->navbar->add(ucwords(strtolower($contactus)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
	if (isloggedin()) { if($USER->id == '2') { //if login and if admin
?>
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

  //reason += validateFirstname(theForm.contactus_firstname);
  reason += validateEmail(theForm.contactus_email);
  reason += validateSubject(theForm.contactus_subject);
  reason += validateMessage(theForm.contactus_message);
      
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

/* function validateFirstname(fld) {
    var error = "";
    var illegalChars = /\W/; // allow letters, numbers, and underscores
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a fullname.\n";
    } 	else if ((fld.value.length < 5) || (fld.value.length > 15)) {
        fld.style.background = 'Yellow'; 
        error = "The fullanme is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The fullname contains illegal characters.\n";
    }  else {
        fld.style.background = 'White';
    }
    return error;
} */

function validateSubject(fld) {
    var error = "";
    var illegalChars = /\W/; // allow letters, numbers, and underscores
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a subject.\n";
    } /* else if ((fld.value.length < 5) || (fld.value.length > 15)) {
        fld.style.background = 'Yellow'; 
        error = "The subject is the wrong length.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The subject contains illegal characters.\n";
    } */ else {
        fld.style.background = 'White';
    }
    return error;
}

function validateMessage(fld) {
    var error = "";
    var illegalChars = /\W/; // allow letters, numbers, and underscores
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a message.\n";
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

<form id="myForm" onsubmit="return validateFormOnSubmit(this)" onChange="return displ();" action="" method="post">
<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('manualemailconfig');?></legend>
<table width="100%" border="0">
  <!--tr>
    <td width="20%">Fullname</td>
    <td width="1%"><strong>:</strong></td>
    <td><input type="text" name="contactus_firstname" id="contactus_firstname" size="40" value="<?=$USER->firstname.' '.$USER->lastname;?>" /></td>
  </tr-->
  <tr>
    <td width="20%">Send To</td>
    <td width="1%"><strong>:</strong></td>
    <td><input name="contactus_email" type="text" id="contactus_email" size="40" /></td>
  </tr>
  <tr>
    <td>Subject</td>
    <td><strong>:</strong></td>
    <td><input name="contactus_subject" type="text" id="contactus_subject" style="width:100%" onKeyUp="javascript:this.value=this.value.toTitleCase()" /></td>
  </tr>
  <tr>
    <td valign="top">Message</td>
    <td valign="top"><strong>:</strong></td>
    <td><textarea name="contactus_message" id="contactus_message" rows="10" style="width:100%;" onKeyUp="javascript:this.value=this.value.toTitleCase()"></textarea></td>
  </tr>  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>   
</table>
</fieldset>

<!--fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?//=get_string('uploadfacility');?></legend>
	File name: <input type="text" size="60" name="captiontext" onKeyUp="javascript:this.value=this.value.toTitleCase()"><br/><br/>
     <input type="file" size="60" name="myfile"> <span style="color:red">(File size: below than 1MB)</span>
</fieldset-->

<div id="progress">
        <div id="bar"></div>
        <div id="percent">0%</div >
</div>
<br/>
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

</script></center>
<?php 
	}else{ //if not admin
		echo '<div style="color:red">You cannot access this page. Thank you.</div>'; 
	}
	}else{
		echo '<div style="color:red">You cannot access this page. Please login.</div>';
	}
	echo $OUTPUT->footer();
?>