<?php
include('../config.php');
include('../manualdbconfig.php');
include ('../pagingfunction.php');

$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);

$courseid = $_GET['id'];
?>

<style type="text/css">
    @media print {
        input#btnPrint {
            display: none;
        }
    }
    table{
        font-family: arial,helvetica,clean,sans-serif;
    }
</style><center>
    <style type="text/css">
        img.table-bg-image {
            position: absolute;
            z-index: -1;
            width:98%;
            height:100%;
        }
        table.with-bg-image, table.with-bg-image tr, table.with-bg-image td {
            background: transparent;
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
            </td></tr></table>
                        </td></tr></table>
</form>