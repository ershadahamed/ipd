<?php
include('../config.php');
include('../manualdbconfig.php');
include ('../pagingfunction.php');

$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);

$courseid = $_GET['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
    </head>

    <body>
        <style>
            html, body {
                color: #333333;
                font-family: Verdana,Geneva,sans-serif !important;
            }
            table td {
                padding:0.4em 0;	
            }
        </style>
        <script language="javascript">
            var isNS = (navigator.appName == "Netscape") ? 1 : 0;
            if (navigator.appName == "Netscape")
                document.captureEvents(Event.MOUSEDOWN || Event.MOUSEUP);
            function mischandler() {
                return false;
            }
            function mousehandler(e) {
                var myevent = (isNS) ? e : event;
                var eventbutton = (isNS) ? myevent.which : myevent.button;
                if ((eventbutton == 2) || (eventbutton == 3))
                    return false;
            }
            document.oncontextmenu = mischandler;
            document.onmousedown = mousehandler;
            document.onmouseup = mousehandler;
            function killCopy(e) {
                return false
            }
            function reEnable() {
                return true
            }
            document.onselectstart = new Function("return false")
            if (window.sidebar) {
                document.onmousedown = killCopy
                document.onclick = reEnable
            }
        </script>

        <form method="post" name="form"  action="<?//=$link; ?>">
            <table width="90%" border="0" align="center">
                <tr>
                    <td>
                        <table class="with-bg-image"><tr><td><br/>
                                    <table id="policy" width="100%" border="0"  style="padding:0px;">
                                        <tr valign="top">
                                            <td align="left" valign="middle" style="font-size:0.9em;"><?= get_string('ipdaddress'); ?></td>
                                            <td align="right" style="width:50%"><img style="width:134px;" src="<?= $CFG->wwwroot; ?>/image/CIFALogo.png"></td>
                                        </tr>
                                    </table>
                                    <table id="policy" style="text-align:justify;width:100%;margin:2em auto;"><tr><td>		
                                                <?php
                                                $summarydetailssql = mysql_query("SELECT * FROM mdl_cifacourse WHERE id='" . $_GET['id'] . "'");
                                                $summarydetails = mysql_fetch_array($summarydetailssql);
                                                $summarydetailsfullname = $summarydetails['fullname'] . '(' . $summarydetails['idnumber'] . ')';
                                                echo '<div style="width:100%; margin:3.7em auto;">';
                                                echo $OUTPUT->heading($summarydetailsfullname, 2, 'headingblock header');
                                                ?>


                                                <?php
                                                echo $summarydetails['summarydetails'];
                                                ?>
                                                </div>
                                            </td></tr></table>
                                </td></tr></table></td></tr></table>
        </form>     
    </body>
</html>