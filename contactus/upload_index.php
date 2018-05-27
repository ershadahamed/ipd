<?php
require_once('../config.php');
require_once('../manualdbconfig.php');

$PAGE->set_url('/');
$PAGE->set_course($SITE);

$contactus = get_string('contactus');
$uploadindextitle = 'Upload Files';
$contactuslink = $CFG->wwwroot . '/contactus/upload_index.php';
$PAGE->navbar->add(ucwords(strtolower($contactus)), $contactuslink); // breadcrum

$PAGE->set_pagetype('site-index');
$editing = $PAGE->user_is_editing();
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('buy_a_cifa');

echo $OUTPUT->header();
if (isloggedin()) {
    $csign = '<span style="color:red;text-weight:bold;">*</span>';
    $compusory = '<span style="color:red;text-weight:bold;">*Compulsory</span>';


    // redirect if poassword not change
    $rselect = mysql_query("SELECT * FROM {$CFG->prefix}user_preferences WHERE userid='" . $USER->id . "' AND name='auth_forcepasswordchange' AND value='1'");
    $srows = mysql_num_rows($rselect);
    if ($srows != '0') {
        ?>
        <script language="javascript">
            window.location.href = '<?= $CFG->wwwroot . '/login/change_password.php'; ?>';
        </script>
        <?php
    }

    // redirect if profile not updated
    $srole = mysql_query("SELECT name FROM mdl_cifarole WHERE id='5'");
    $rwrole = mysql_fetch_array($srole);
    $usertype = $rwrole['name'];

    $srolew = mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='" . $USER->id . "' AND usertype='" . $rwrole['name'] . "'");
    $srolenum = mysql_num_rows($srolew);
    if ($srolenum != '0') {
        $rsc = mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='" . $USER->id . "' AND (email='' OR college_edu='' OR highesteducation='' OR yearcomplete_edu='0')");
    } else {
        $rsc = mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='" . $USER->id . "' AND (email='' OR designation='' OR department='')");
    }
    $srows2 = mysql_num_rows($rsc);
    if ($srows2 != '0') {
        ?>
        <script language="javascript">
            window.location.href = '<?= $CFG->wwwroot . '/user/edit.php?id=' . $USER->id . '&course=1'; ?>';
        </script>
        <?php
    }
    ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
    <script type="text/javascript" src="jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <style>
        form { display: block; margin: 20px auto; border-radius: 10px; padding: 15px }
        #progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
        #bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
        #percent { position:absolute; display:inline-block; top:3px; left:48%; }
    </style>

    <center>
        <!--h2>Upload Facility</h2-->
        <script type="text/javascript">
                                    String.prototype.toTitleCase = function () {
                                        return this.replace(/([\w&`'??"?.@:\/\{\(\[<>_]+-? *)/g, function (match, p1, index, title) {
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
                var f = document.form;

                reason += validateFirstname(theForm.contactus_firstname);
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

            function validateFirstname(fld) {
                var error = "";
                var illegalChars = /\W/; // allow letters, numbers, and underscores

                if (fld.value == "") {
                    fld.style.background = 'Yellow';
                    error = "You didn't enter a fullname.\n";
                } /* else if ((fld.value.length < 5) || (fld.value.length > 15)) {
                 fld.style.background = 'Yellow'; 
                 error = "The fullanme is the wrong length.\n";
                 } else if (illegalChars.test(fld.value)) {
                 fld.style.background = 'Yellow'; 
                 error = "The fullname contains illegal characters.\n";
                 }  */ else {
                    fld.style.background = 'White';
                }
                return error;
            }

            function validateSubject(fld) {
                var error = "";
                var illegalChars = /\W/; // allow letters, numbers, and underscores

                if (fld.value == "") {
                    fld.style.background = 'Yellow';
                    error = "You didn't select a subject.\n";
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
                var error = "";
                var tfld = trim(fld.value);                        // value of field with whitespace trimmed off
                var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/;
                var illegalChars = /[\(\)\<\>\,\;\:\\\"\[\]]/;

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

        <style>
            .fileUpload {
                position: relative;
                overflow: hidden;
                margin: 10px;
                border:		2px solid #21409A;
                padding:		3px 8px !important;
                margin: 2px 0px 2px 2px;
                font-size:		12px !important;
                background-color:	#FFFFFF;
                font-weight:		bold;
                color:			#000000;	
                cursor:pointer;
                border-radius: 5px;
                min-width: 80px;	
            }
            .fileUpload input.upload {
                position: absolute;
                top: 0;
                right: 0;
                margin: 0;
                padding: 0;
                font-size: 20px;
                cursor: pointer;
                opacity: 0;
                filter: alpha(opacity=0);
            }

            .inputfiletype input{
                padding: 4px 12px;
                color: #000;
                border: 1px solid #D8D8D8;
                width: 250px;
            }
        </style>

        <form id="myForm" onsubmit="return validateFormOnSubmit(this)" action="upload.php" method="post" enctype="multipart/form-data">
            <fieldset style="text-align: left;padding: 0.6em;" id="user" class="clearfix">
                <legend style="font-weight:bolder;" class="ftoggler"><?= get_string('contactus'); ?></legend>
                <br/><br/>
                <table width="100%" border="0">
                    <tr>
                        <td width="20%">Subject&nbsp;<?= $csign; ?></td>
                        <td width="1%"><strong>:</strong></td>
                        <td>
                            <!--input name="contactus_subject" type="text" id="contactus_subject" style="width:100%" onKeyUp="javascript:this.value=this.value.toTitleCase()" /-->
                            <select name="contactus_subject" id="contactus_subject">
                                <option value=""> - Select One - </option>
                                <option value="<?= get_string('profile'); ?>"><?= get_string('profile'); ?></option>
                                <option value="<?= get_string('password'); ?>"><?= get_string('password'); ?></option>
                                <option value="<?= get_string('financialstatement'); ?>"><?= get_string('financialstatement'); ?></option>
                                <option value="<?= get_string('enrolmentconfirmation'); ?>">SHAPE Enrollment Confirmation</option>
                                <option value="<?= get_string('activetrainings'); ?>"><?= get_string('activetrainings'); ?></option>
                                <option value="<?= get_string('finaltest'); ?>"><?= get_string('finaltest'); ?></option>
                                <option value="<?= get_string('testresult'); ?>"><?= get_string('testresult'); ?></option>
                                <option value="<?= get_string('cifaonlinepolicy'); ?>"><?= get_string('cifaonlinepolicy'); ?></option>
                                <option value="<?= get_string('ipddemo'); ?>"><?= get_string('ipddemo'); ?></option>
                                <option value="<?= get_string('cifachat'); ?>"><?= get_string('cifachat'); ?></option>
                                <option value="<?= get_string('cifablog'); ?>"><?= get_string('cifablog'); ?></option>
                                <option value="<?= get_string('youtube'); ?>"><?= get_string('youtube'); ?></option>
                                <option value="<?= get_string('socialnetwork'); ?>"><?= get_string('socialnetwork'); ?></option>
                                <option value="<?= get_string('feedbackreview'); ?>"><?= get_string('feedbackreview'); ?></option>
                            </select>
                            <input type="hidden" name="contactus_firstname" id="contactus_firstname" size="40" value="<?= $USER->firstname . ' ' . $USER->lastname; ?>" />
                            <input name="contactus_email" type="hidden" id="contactus_email" size="40" value="<?= $USER->email; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Message&nbsp;<?= $csign; ?></td>
                        <td valign="top"><strong>:</strong></td>
                        <td><textarea name="contactus_message" id="contactus_message" rows="10" style="width:100%;" onKeyUp="javascript:this.value = this.value.toTitleCase()"></textarea></td>
                    </tr>  
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>   
                </table>
            </fieldset>

            <fieldset style="text-align: left;padding: 0.6em;" id="user" class="clearfix">
                <legend style="font-weight:bolder; text-align:left;" class="ftoggler"><?= get_string('uploadfacility'); ?></legend>
                <br/><br/>
                <div style="text-align:center;">
                    <p style="display: inline;" class="inputfiletype"><input id="uploadFile" style="line-height: 16px;" type="text" disabled="disabled" placeholder="No file chosen"></p>
                    <div class="fileUpload btn btn-primary">
                        <span>Choose a file</span>
                        <input id="uploadBtn" type="file" name="myfile" class="upload" />
                    </div><span style="color:red;padding-left:1em;">(File size: below than 1MB)</span></div>
                <br/>
                <!--//Javascipt line here -->
                <p><script type="text/javascript">// <![CDATA[
                    document.getElementById("uploadBtn").onchange = function () {
                        document.getElementById("uploadFile").value = this.value;
                    };
                // ]]&gt;</script></p>
            </fieldset>

            <div id="progress">
                <div id="bar"></div>
                <div id="percent">0%</div >
            </div>
            <br/>
            <input type="submit" name="Submit" value="<?= get_string('submitmessage'); ?>">
        </form>
        <br/>

        <div id="message"></div>
        <script>
            $(document).ready(function ()
            {

                var options = {
                    beforeSend: function ()
                    {
                        $("#progress").show();
                        //clear everything
                        $("#bar").width('0%');
                        $("#message").html("");
                        $("#percent").html("0%");
                    },
                    uploadProgress: function (event, position, total, percentComplete)
                    {
                        $("#bar").width(percentComplete + '%');
                        $("#percent").html(percentComplete + '%');


                    },
                    success: function ()
                    {
                        $("#bar").width('100%');
                        $("#percent").html('100%');

                    },
                    complete: function (response)
                    {
                        $("#message").html("<font color='green'>" + response.responseText + "</font>");
                    },
                    error: function ()
                    {
                        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");

                    }

                };

                $("#myForm").ajaxForm(options);

            });

        </script></center><?= $compusory; ?>
    <?php
} else {
    echo '<div style="color:red">You cannot access this page. Please login.</div>';
}
echo $OUTPUT->footer();
?>