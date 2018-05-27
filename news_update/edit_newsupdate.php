<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $newsupdate = get_string('news_update');
	$editnewsupdate = 'Edit '.get_string('news_update');
    $PAGE->navbar->add(ucwords(strtolower($newsupdate)))->add(ucwords(strtolower($editnewsupdate)));	

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
<div style="float:right;margin-right:1.5em;"><?=$compusory;?></div>
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
    } else if (!(stripped.length == 12)) {
        error = "The phone number is the wrong length. Make sure you included an area code.\n";
        fld.style.background = 'Yellow';
    }
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
<?php
	$sinstitude=mysql_query("SELECT * FROM {$CFG->prefix}news_update WHERE id='".$_GET['id']."'");
	$qins=mysql_fetch_array($sinstitude);
	$title=$qins['title'];
	$content=$qins['content'];
	$status=$qins['status'];
	$timemodified=strtotime("now");
?>
<form id="myForm" onsubmit="return validateFormOnSubmit(this)" onChange="return displ();" action="../news_update/edit_newsupdate_sql.php" method="post">
    
<fieldset style="width: 96%;padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Edit <?=get_string('news_update');?></legend>
<table width="100%" border="0">
  <tr>
    <td width="30%" valign="top">Title
      <?=$csign;?></td>
    <td width="1%" align="right" valign="top"><strong>:</strong></td>
    <td align="left">
		<input name="title" type="text" id="title" size="80%" value="<?=$title;?>">
		<input name="news_id" type="hidden" id="news_id" size="80%" value="<?=$_GET['id'];?>">
	</td>
  </tr>
  <tr>
    <td valign="top">Content
      <?=$csign;?></td>
    <td align="right" valign="top"><strong>:</strong></td>
    <td align="right"><textarea name="content" id="content" rows="10" style="width:100%;" onKeyUp="javascript:this.value=this.value.toTitleCase()"><?=$content;?></textarea></td>
  </tr>
  <tr>
    <td width="30%" valign="top">Status
      <?=$csign;?></td>
    <td width="1%" align="right" valign="top"><strong>:</strong></td>
    <td align="left"><select name="status" id="status">
      <option selected="selected">Select One..</option>
      <option value="0" <?php if($status=='0'){ echo "Selected";}?>>Active</option>
      <option value="1" <?php if($status=='1'){ echo "Selected";}?>>Not Active</option>
    </select></td>
  </tr>     
</table>
</fieldset>

<!--div id="progress">
        <div id="bar"></div>
        <div id="percent">0%</div >
</div-->
<br/>
<input type="button" onClick="window.history.back();" name="back" value="<?=get_string('back');?>" title="<?=get_string('back');?>">
<input type="submit" name="Submit" value="<?=get_string('save');?>">
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