<body onLoad="window.print()">
    <?php
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    require_once('../config.php');
    include '../manualdbconfig.php';
    require_once($CFG->libdir . '/tablelib.php');
    require_once($CFG->libdir . '/filelib.php');
    require_once($CFG->libdir . '/datalib.php');
    require_once('lib.php');

    $userid = optional_param('id', 0, PARAM_INT);
    // include_once ('../pagingfunction.php');

    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);

    //to get list of financial
    $userdetails = get_user_details($userid);
    $candidateid = strtoupper($userdetails->traineeid);
    $statement = mysql_query("
				Select
				  *
				From
				  mdl_cifastatement
				Where
					candidateid='" . $candidateid . "' Order By candidateid, courseid ASC
	");
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
    <style>
<?php //require_once($CFG->wwwroot. '/theme/aardvark/style/core.css');   ?>

        #userpolicy
        {
            width:98%;
            margin:0 auto;
            /* border-collapse: collapse;
            border: 2px solid rgb(152, 191, 33); */
            background-color:#fff;	
        }
        html, body {
            /* color: #333333; */
            font-family: Verdana,Geneva,sans-serif !important;
            -webkit-print-color-adjust:exact;
        }
        table td{ background-color:#fff; }
    </style>
    <style type="text/css">
        @media print {
            input#btnPrint {
                display: none;
            }
        }
        table{
            font-family: Verdana,Geneva,sans-serif;
            font-size:0.95em;
        }
        /* input[type="button"]{
                border:		2px solid #21409A;
                padding:		8px 10px !important;
                margin-bottom: 2px;
                font-size:		12px !important;
                background-color:	#FFFFFF;
                font-weight:		bold;
                color:			#000000;	
                cursor:pointer;
                border-radius: 5px;
                min-width: 80px;
        } */
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

    <form method="post" name="form"  action="<?//=$link; ?>">

        <table class="with-bg-image" width="100%"><tr><td><br/>
                    <table id="policy" width="100%" border="0"  style="padding:0px;">
                        <tr valign="top">
                            <td align="left" valign="middle" style="font-size:0.9em;"><?= get_string('ipdaddress'); ?></td>
                            <td align="right" style="width:50%"><img style="width:134px;" src="<?= $CFG->wwwroot; ?>/image/CIFALogo.png"></td>
                        </tr>
                    </table>

                    <table id="policy" style="text-align:justify;width:100%;height:100%;margin:0px auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;"><tr><td>
                                <div class="demo" style="margin-bottom:1em;">
                                    Date: <?= date('d-F-Y', strtotime('now')); ?>
                                </div>
                                <?php
                                echo ucfirst($userdetails->address) . "<br>";
                                if ($userdetails->address2 != '') {
                                    echo ucfirst($userdetails->address2) . "<br>";
                                }
                                if ($userdetails->address3 != '') {
                                    echo ucfirst($userdetails->address3) . "<br>";
                                }
                                echo ucfirst($userdetails->city);
                                echo "<br>";
                                echo "<br>";
                                ?>
                                <input name="id" type="text" value="<?php echo $id; ?>" hidden> 
                                <br>
                                <?php
                                if ($userdetails->middlename != '') {
                                    $mname = $userdetails->middlename;
                                }
                                echo "Dear ";
                                echo ucfirst($userdetails->firstname . ' ' . $mname . ' ' . $userdetails->lastname) . ", ";
                                ?>
                                <br><br>
                                <div style="margin-bottom:1em;">
                                    Candidate ID: <strong><?= $userdetails->traineeid; ?></strong>
                                </div>
                                <?php
                                $s = mysql_query("SELECT * FROM mdl_cifafinancial_statement WHERE id='1'");
                                $ss = mysql_fetch_array($s);

                                echo $ss['summary'];
                                ?>
                                <table border="1" cellpadding="0" cellspacing="0" class="viewdata" style="border-collapse:collapse;width:100%; margin:1.2em 0px;">
                                    <tr style="background-color:#21409A; color:#ffffff;">
                                        <th style="width:15%; color:#ffffff;">Date
                                            <?php /* <div style="position: relative;">
                                              <img src="../image/btp_b.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                              <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                              <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">Date</span>
                                              </div> */ ?> 
                                        </th>
                                        <th>Description
                                            <?php /* <div style="position: relative;">
                                              <img src="../image/btp_b.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                              <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                              <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">Description</span>
                                              </div> */ ?>   
                                        </th>
                                        <th style="width:16%">Debit (USD)
                                            <?php /* <div style="position: relative;">
                                              <img src="../image/btp_b.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                              <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                              <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">Debit (USD)</span>
                                              </div> */ ?>     
                                        </th>
                                        <th style="width:16%">Credit (USD)
                                            <?php /* <div style="position: relative;">
                                              <img src="../image/btp_b.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                                              <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                                              <span style="position: absolute; top: 50%; margin-top: -0.6em;">Credit (USD)</span>
                                              </div> */ ?>
                                        </th>
                                    </tr>
                                    <?php
                                    $bil = '1';
                                    $frowcol = mysql_num_rows($statement);
                                    if ($frowcol != '0') {
                                        while ($financial = mysql_fetch_array($statement)) {
                                            if ($financial['remark'] == 'Subscribe') {
                                                $sb = $financial['debit1'];
                                                $sdate = $financial['subscribedate'];
                                            }
                                            if ($financial['remark'] == 'Payment') {
                                                $sb = $financial['credit1'];
                                                $sdate = $financial['paymentdate'];
                                            }
                                            if ($financial['remark'] == 'Re-sit') {
                                                $sb = $financial['debit1'];
                                                $sdate = $financial['subscribedate'];
                                            }
                                            if ($financial['remark'] == 'Extension') {
                                                $sb = $financial['debit1'];
                                                $sdate = $financial['subscribedate'];
                                            }
                                            ?>    
                                            <tr>
                                                <td style="text-align:center;">
                                                    <?php
                                                    //date subcribe//payment
                                                    echo date('d M Y', $sdate);
                                                    ?>      
                                                </td>
                                                <td style="padding-left:5px;">
                                                    <?php
                                                    //description
                                                    $sc = mysql_query("SELECT fullname FROM {$CFG->prefix}course WHERE id='" . $financial['courseid'] . "'");
                                                    $gsc = mysql_fetch_array($sc);
                                                    echo $financial['remark'] . ' - ' . $gsc['fullname'];
                                                    ?></td>
                                                <td style="text-align:center;">
                                                    <?php
                                                    //debit
                                                    if ($financial['remark'] != 'Payment') {
                                                        echo $sb;

                                                        //total debit
                                                        $sum+=$sb;
                                                    }
                                                    ?>
                                                </td>
                                                <td style="text-align:center;">
                                                    <?php
                                                    //credit
                                                    if ($financial['remark'] == 'Payment') {
                                                        echo $sb;
                                                        //total credit
                                                        $sum2+=$sb;
                                                    }
                                                    ?>
                                                </td>
                                            </tr>   
                                        <?php } ?>
                                        <tr>
                                            <td colspan="3" style="text-align:center;"><strong>Balance</strong></td>
                                            <td style="text-align:center;"><strong><?= $sum - $sum2; ?></strong></td>
                                        </tr> 
                                    <?php } else { ?>     
                                        <tr>
                                            <td colspan="4" style="text-align:center;"><strong>No records found</strong></td>
                                        </tr>
                                    <?php } ?>    
                                </table>
                                <?php
                                echo $ss['financialsummary'];
                                ?>
                                <br><br><br/>
                                Yours Sincerely,<br/>
                                <img src="../image/signiture.jpg" alt="" width="161" height="62"><br/>
                                <strong>Abdulkader Thomas</strong><br/>
                                CEO

                                <br><br><br/>
                                <span style="font-size:0.6em;"><?= get_string('disclaimer'); ?></span>
                            </td></tr></table>
                </td></tr></table></form>


