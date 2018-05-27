<body onLoad="window.print()">
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../config.php');
require_once($CFG->libdir . '/tablelib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/datalib.php');
require_once('lib.php');
$site = get_site();

$viewusertitle = get_string('user');
$title = "$SITE->shortname: " . $viewusertitle;
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);

$groupid = strtoupper($USER->username);
$author = $groupid . ' (' . $USER->firstname . ' ' . $USER->lastname . ')';
?>
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
<style type="text/css">
    html, body {
        /* color: #333333; */
        font-family: Verdana,Geneva,sans-serif !important;
        -webkit-print-color-adjust:exact;
    }

    .printtable{
        border-collapse: collapse;
        border-spacing: 0;
        color: #FFF; 
    }

    table .printtable th{
        background-color: #21409A;
        border: 1px solid #ccc;
        font-weight: bold;
        padding: 4px;
        vertical-align: middle;            
    }

    table .printtable td {  
        border: 1px solid #ccc;
        color: #000;
        padding: 4px;
        vertical-align: top;
        text-align: left;          
    }
    #policy th, tr, td { border:0px solid #000; }

    @media print {
        input#btnPrint {
            display: none;
        }
    }
    table{
        font-family: Verdana,Geneva,sans-serif;
        font-size:0.95em;
    }

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
<form method="post" name="form"  action="<?//=$link; ?>">
    <table class="with-bg-image" style="width:90%; margin-left:auto; margin-right:auto;"><tr><td><br/>
                <table id="policy" width="100%" border="0"  style="padding:0px;">
                    <tr valign="top">
                        <td align="left" valign="middle" style="font-size:0.9em;"><?= get_string('ipdaddress'); ?></td>
                        <td align="right" style="width:50%"><img style="width:134px;" src="<?= $CFG->wwwroot; ?>/image/CIFALogo.png"></td>
                    </tr>
                </table>

                <?php
                // Content here!! 
                echo '<h3>' . strtoupper(get_string('users')) . '</h3>';
                $url = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $getorg->id . '&display=form1';

                $where = "Where confirmed='1' And deleted='0' And traineeid LIKE 'A%' And id<>'2'";
                $dbtable = "Select * From {user} {$where} Order By id DESC";
                $result = $DB->get_records_sql($dbtable);

                $table = new html_table();
                $table->width = "100%";
                $table->attributes = array("class" => "printtable");
                $table->head = array("Candidate ID", "Firstname", "Lastname", "Email", "Gender", "Status", "Country", "Created By");
                $table->align = array("center", "left", "left", "left", "center", "center", "left", "left");
                foreach ($result as $value) {
                    if ($value->status == '0') {
                        $createby = $author;
                    } else {
                        $createby = $author;
                    }
                    // Registration date
                    $datetime = date('d-m-Y', $value->timecreated);

                    // Organization Name
                    if ($value->middlename) {
                        $organizationname = $value->firstname . ' ' . $value->middlename . ' ' . $value->lastname;
                    } else {
                        $organizationname = $value->firstname . ' ' . $value->lastname;
                    }

                    if ($value->gender == '0') {
                        $gender = 'Male';
                    } elseif ($value->gender == '1') {
                        $gender = 'Female';
                    }

                    $link = $CFG->wwwroot . '/organization/orgview.php?formtype=' . $formtype . '&id=' . $value->id . '&display=userdetails';
                    $table->data[] = array(strtoupper($value->traineeid),
                        $value->firstname,
                        $value->lastname,
                        $value->email,
                        $gender,
                        checkuserstatus($value->id), // status
                        getCountryName($value->country), // country
                        $createby
                    );
                }

                if (!empty($table)) {
                    echo html_writer::table($table);
                }
                ?>

            </td></tr></table></form>





