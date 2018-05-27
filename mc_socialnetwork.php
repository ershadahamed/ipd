<?php
require_once('config.php');
include('manualdbconfig.php');

$site = get_site();
$mycommunity = get_string('mycommunity');
$title = "$SITE->shortname: " . $mycommunity;

// header ('Content-type: text/html; charset=utf-8');
header('Content-Type: text/html; charset=ISO-8859-1');
//if (isloggedin()) {		
$id = $_GET['id'];

$imgfacebook = $CFG->wwwroot . "/image/Facebook_media.png";
$imgtwitter = $CFG->wwwroot . "/image/Twitter_media.png";
$imglinkedin = $CFG->wwwroot . "/image/linkedin_btn.png";

$linkedin = $PAGE->theme->settings->linkedin;
$utube = $PAGE->theme->settings->youtube;
$twitter = $PAGE->theme->settings->twitter;
$facebook = $PAGE->theme->settings->facebook;

?>	
<style>
<?php //include('theme/aardvark/style/core.css');      ?>
    a:hover {text-decoration:underline;}
    /* ul{	list-style-type: none;} */
    .list li{padding: 0px 0px 0.5em 0px;}
		
    html, body {
        color: #333;
        font-family: Verdana,Geneva,sans-serif !important;
    }		
		
    input[type="submit"]{
        /* padding:3px 8px; */
			
        border:		2px solid #21409A;
        padding:		5px 10px !important;
        margin: 2px 0px 2px 2px;
        font-size:		12px !important;
        background-color:	#21409A;
        font-weight:		bold;
        color:			#ffffff;	
        cursor:pointer;
        border-radius: 5px;
        min-width: 80px;
    }

    #id_defaultbutton{
        background-color:	#ffffff;
        color:			#000000;
    }		
</style>	

<style type="text/css">
    img.table-bg-image {
        position: absolute;
        z-index: -1;
        width:100%;
        /* min-height:837px; */
        height:98%;
        margin-bottom:0px;
        padding-bottom:0px;
    }
    table.with-bg-image, table.with-bg-image tr, table.with-bg-image td {
        background: transparent;
    }
</style>
<img class="table-bg-image" src="<?= $CFG->wwwroot; ?>/image/bg_statement.png"/>
<div style="min-height: 400px;margin-top:2em;">	
    <form id="form1" name="form1" method="post" action="">
        <table class="with-bg-image" width="100%"><tr><td>
                    <table id="policy" width="100%" border="0"  style="padding:0px;">
                        <tr valign="top">
                            <td align="left" valign="middle" style="font-size:0.9em;"><?= get_string('ipdaddress'); ?></td>
                            <td align="right" style="width:50%"><img style="width:134px;" src="<?= $CFG->wwwroot; ?>/image/CIFALogo.png"></td>
                        </tr>
                    </table>	<br/>	
                    <fieldset style="margin:0px auto; padding: 0.6em;width:50%;" id="user" class="clearfix">
                        <p style="text-align:justify;"><?= get_string('mcsocialnetworking'); ?></p>	
                        <div class="link-list" style="text-align:center;padding: 0.5em 1em;">
                            <ul class="list" style="margin:0px auto;list-style-type:none;">
                                <li class="item">
                                    <a href="<?=$facebook;?>" target="_blank"><img name="facebook" id="facebook" src="<?= $imgfacebook; ?>" alt="Like Us On Facebook" title="Like Us On Facebook" /></a>
                                </li>
                                <li class="item">
                                    <a href="<?=$twitter;?>" target="_blank"><img name="twitter" id="twitter" src="<?= $imgtwitter; ?>" alt="Like Us On Twitter" title="Like Us On Twitter" /></a></li>
                                <li class="item">
                                    <a href="<?=$linkedin;?>" target="_blank"><img name="linkedin" id="linkedin" src="<?= $imglinkedin; ?>" alt="Connect On Linkedin" title="Connect On Linkedin" /></a></li>
                            </ul>
                        </div>		
                    </fieldset>
                    <div style="padding:2px;text-align:center;"><center>
                            <input type="submit" id="id_defaultbutton" name="back" onClick="window.close()" value="<?= get_string('back'); ?>" />			
                            <?php /* <input type="submit" name="back" onClick="this.form.action='<?=$CFG->wwwroot. '/index.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" /> */ ?>
                        </center></div>	
                </td></tr></table>
    </form>
</div>	
<?php //}	?>		