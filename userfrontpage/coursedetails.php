<?php
include('config.php');
include('manualdbconfig.php');
?>
<script type="text/javascript" src="../scripts/jquery-1.3.2.min.js"></script>
<style>
    fieldset { 
        border:2px solid #5DCBEB;	
        width: 96%; 
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 10px;
        padding: 1em 1em 0em;
        border-top-left-radius: 5px 5px;
        border-top-right-radius: 5px 5px;
    }
</style>	
<?php $timestarttxt = $timestart." Central Standard Time (US)";
$timeendtxt = $timeend." Central Standard Time (US)";?>
<form id="form1" name="form1" method="post" action="">
    <table id="cifa-table" width="100%" border="0" align="center">
        <tr><th><?php print_r($fulltitle); ?></th></tr>
        <tr><td>
                <table width="98%" border="0" cellpadding="0" cellspacing="0">
                    <tr valign="top">
                        <td width="23%" align="right"><strong><?php print_r(get_string('programdescription')); ?></strong></td>
                        <td width="1%"><b>:</b></td>
                        <td><?php print_r($summary); ?></td>
                    </tr>
                    <tr valign="top">
                        <td align="right"><strong><?= ucwords(strtolower(get_string('subscriptionstart'))); ?></strong></td>
                        <td><b>:</b></td>
                        <td><?php print_r($timestarttxt); ?></td>
                    </tr>
                    <tr valign="top">
                        <td align="right"><strong><?= ucwords(strtolower(get_string('subscriptionend'))); ?></strong></td>
                        <td><b>:</b></td>
                        <td>
                            <?php print_r($timeendtxt); ?>	  
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php
    $linklaunch = $CFG->wwwroot . '/course/view.php?id=' . $courseid;
    $linkextend = $CFG->wwwroot . '/purchasemodule.php?resitexamid=3&resitcode=' . $coursecode . '&productid=' . $courseid . '&command=add';
    ?>
    <table border="0">
        <tr>
            <?php
            //if course still valid
            if (($todaydate >= strtotime($timestart)) && ($todaydate <= strtotime($timeend))) {
                ?>
                <td style="padding-left:0px;">
                    <input type="submit" name="lauchtraining" onClick="this.form.action = '<?= $linklaunch; ?>'" value="Launch Training" />
                </td>
                <?php
            }
            if (($todaydate >= $e30daybefore) && ($todaydate < $e30dayafter)) {
                // if extend courses
                if (isset($var)) {
                    /*  mdl_cifauser_enrolments */
                    //extend for 2 months once
                    $u_timeend = strtotime($timeend . " + 60 days");

                    $enrolupdate = mysql_query("
						UPDATE {$CFG->prefix}user_enrolments SET timeend='" . $u_timeend . "', timestart='" . strtotime($timeend) . "'
						WHERE status='0' AND userid='" . $USER->id . "' AND enrolid='" . $courselist->enrolid . "'
					");

                    //instanceid
                    $sexam = mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='" . $courseid . "'");
                    $Le = mysql_fetch_array($sexam);
                    $examcontextid = $Le['id'];

                    //assigned roled.				
                    $sqlassignexam = mysql_query("UPDATE {$CFG->prefix}role_assignments SET timemodified='" . $todaydate . "' WHERE contextid='" . $examcontextid . "' AND userid='" . $USER->id . "'");

                    //extend detais to statement DB
                    $extendcost = '50'; //cost for extend
                    $descextension = 'Extension';
                    $istatementsql = mysql_query("
					INSERT INTO {$CFG->prefix}statement
					SET 
						candidateid='" . $USER->traineeid . "',
						subscribedate='" . $todaydate . "', 
						courseid='" . $courseid . "', 
						remark='" . $descextension . "', 
						debit1='" . $extendcost . "'
					");

                    $linkredirect = $CFG->wwwroot . '/courseindex.php?id=' . $USER->id;
                    redirect($linkextend);
                }

                // display button 30 before & 30 after
                ?>
                <td><input name="extendtraining" id="extendtraining" type="submit" onClick="this.form.action = '<?= $linkextend; ?>'" value="Extend Training" <?php
                    if (isset($var)) {
                        echo 'disabled="disabled"';
                    }
                    ?> /></td>
                    <?php
                }
                ?>
            <td>
                <?php
                // test ID for courses
                if ($coursecode == 'IPD01') {
                    $attemptquizid = '26';
                }
                if ($coursecode == 'IPD02') {
                    $attemptquizid = '31';
                }
                if ($coursecode == 'IPD03') {
                    $attemptquizid = '32';
                }
                if ($coursecode == 'IPD04') {
                    $attemptquizid = '33';
                }
                if ($coursecode == 'IPD05') {
                    $attemptquizid = '34';
                }

                // final test ID
                $splitcoursename=explode("(",$coursename);  // testname
                $cfinaltestsql = mysql_query("
			Select
			  a.category,
			  a.fullname,
			  b.course,
			  b.instance,
			  c.id As cifaquizid,
			  c.name,
			  c.course As course1,
			  e.userid,
			  b.id As id1,
			  c.attempts,
			  a.idnumber
			From
			  mdl_cifacourse a Inner Join
			  mdl_cifacourse_modules b On a.id = b.course Inner Join
			  mdl_cifaquiz c On b.course = c.course And b.instance = c.id Inner Join
			  mdl_cifaenrol d On c.course = d.courseid Inner Join
			  mdl_cifauser_enrolments e On d.id = e.enrolid
			Where
			  a.category = '3' And a.visible = '1' And e.userid='" . $USER->id . "'	And c.name LIKE '" . $splitcoursename[0] . "%'	
		");
                $final = mysql_fetch_array($cfinaltestsql);
                $finaltestid = $final['course1']; //'64';		
                $finalexamid = $final['instance']; //'64';		
                // re-sit link button 
                $linkresit = $CFG->wwwroot . '/purchasemodule.php?resitexamid=4&resitid=' . $final['cifaquizid'] . '&resitcode=' . $coursecode . '&productid=' . $finaltestid . '&command=add';
                $sqlattempts = mysql_query("
				Select
				  a.attempts,
				  b.userid,
				  a.name,
				  b.quiz,
				  b.attempt,
				  a.course As course1
				From
				  mdl_cifaquiz a Inner Join
				  mdl_cifaquiz_attempts b On a.id = b.quiz
				Where
				  a.id='" . $final['cifaquizid'] . "' AND a.course = '" . $finaltestid . "' AND b.userid = '" . $USER->id . "'							  
			");
                $cattempts = mysql_num_rows($sqlattempts);
                // re-sit button // after 2 attempts complete
                if ($final['attempts'] == $cattempts) {
                    ?>
                    <form method="post">
                        <input name="resitexam" id="resitexam" type="submit" value="<?= get_string('resitexam'); ?>" onclick="this.form.action = '<?= $linkresit; ?>'" />
                    </form>
                <?php } ?>
            </td>
        </tr>
    </table>
    <br/>
</form>