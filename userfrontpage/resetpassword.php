<?php
require_once('../config.php');
include('../manualdbconfig.php');
include_once ('../pagingfunction.php');
require_once($CFG->libdir . '/logactivity_lib.php');


$site = get_site();

$heading = get_string('resetpassword');
$title = "$SITE->shortname: " . $heading;
$PAGE->set_title($title);
$PAGE->set_heading($site->fullname);
$PAGE->set_pagelayout('buy_a_cifa');
$PAGE->navbar->add($heading);

echo $OUTPUT->header();

if (isloggedin()) {
    echo $OUTPUT->heading($heading, 2, 'headingblock header');
    $pword_text = get_string('temporarypassword');

    $sql = "SELECT * FROM mdl_cifauser";
    $query = mysql_query($sql);
    ?>
    <style>
    <?php
    include('../css/style2.css');
    include('../css/button.css');
    include('../css/pagination.css');
    include('../css/grey.css');
    ?>
    </style>
    <div style="min-height: 390px;">
        <form method="post">
            <!--fieldset id="fieldset"><legend id="legend">Search candidate</legend-->
            <table border="0" cellpadding="1" cellspacing="1" style="margin-top:30px; width:95%; font:13px/1.231 arial,helvetica,clean,sans-serif bolder;">
                <tr>
                    <td style="width:180px;text-align:right;">
                        <select name="pilihancarian" style="width:180px;">
                            <option value=""> - select - </option>
                            <option value="traineeid"><?= get_string('candidateid'); ?></option>
                            <option value="firstname"><?= get_string('firstname'); ?></option>
                            <option value="lastname"><?= get_string('lastname'); ?></option>
                        </select>
                    </td>
                    <td width="10%"><input type="text" name="traineeid" style="width:250px;" /></td>
                    <td><input type="submit" name="search" value="<?= get_string('search'); ?>"/></td>
                </tr>	
                <tr>
                    <td style="width:180px;text-align:right;">
                        <select name="pilihancarian2" style="width:180px;">
                            <option value=""> - select - </option>
                            <option value="traineeid"><?= get_string('candidateid'); ?></option>
                            <option value="firstname"><?= get_string('firstname'); ?></option>
                            <option value="lastname"><?= get_string('lastname'); ?></option>
                        </select>
                    </td>
                    <td width="10%"><input type="text" name="traineeid2" style="width:250px;" /></td>
                    <!--td><input type="submit" name="search" value="<?//=get_string('search');?>"/></td-->
                </tr>    
            </table><!--/fieldset-->
        </form>

        <?php
        $selectsearch = $_POST['pilihancarian'];
        $candidateid = $_POST['traineeid'];
        $selectsearch2 = $_POST['pilihancarian2'];
        $candidateid2 = $_POST['traineeid2'];
        ?>
        <table id="availablecourse3">
            <tr class="yellow">
                <th class="adjacent" width="1%">No</th>
                <th class="adjacent" width="12%" align="left"><strong><?= get_string('candidateid'); ?></strong></th>
                <th class="adjacent" width="33%" align="left"><strong><?= get_string('name'); ?></strong></th>
                <th class="adjacent" width="25%" align="left"><strong><?= get_string('email'); ?></strong></th>
                <th class="adjacent" width="14%" style="text-align:left;"><?= get_string('roles'); ?></th>	
                <th class="adjacent" width="10%" style="text-align:center;"><?= get_string('status'); ?></th>
                <th class="adjacent" width="5%" style="text-align:center;"><?= get_string('misc.'); ?></th>
            </tr>
            <?php
            $row = mysql_fetch_array($query);
            if ($row['id'] >= 1) {

                //paging
                $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                $limit = 12;
                $startpoint = ($page * $limit) - $limit;

                //collect user to list out on table
                if ($USER->id != '2') {
                    $statement = "
		  mdl_cifauser a Inner Join
		  mdl_cifauser_accesstoken b On b.userid = a.id 
		Where 
		  a.deleted='0' And a.confirmed='1'	And (a.usertype='Active candidate' Or a.usertype='inactive candidate')	  
		";
                } else {
                    $statement = "mdl_cifauser a WHERE 	a.deleted='0' AND (a.usertype='Active candidate' OR a.usertype='inactive candidate')";
                }
                if ($candidateid != '' && $selectsearch != '') {
                    $statement.= " AND (($selectsearch LIKE '%" . $candidateid . "%'))";
                }
                if ($candidateid2 != '' && $selectsearch2 != '') {
                    $statement.= " AND (($selectsearch2 LIKE '%" . $candidateid2 . "%'))";
                }
                if ($candidateid != '' && $selectsearch != '' && $candidateid2 != '' && $selectsearch2 != '') {
                    $statement.= " AND (($selectsearch LIKE '%" . $candidateid . "%') AND ($selectsearch2 LIKE '%" . $candidateid2 . "%'))";
                }
                $sqlcourse = "SELECT *, DATE_ADD(FROM_UNIXTIME(a.timecreated,'%Y-%m-%d'), INTERVAL 120 DAY) as lasttimecreatedreg FROM {$statement} ORDER BY a.id DESC";
                $sqlcourse.=" LIMIT {$startpoint} , {$limit}";

                $sqlquery = mysql_query($sqlcourse);
                $no = '1';
                while ($sqlrow = mysql_fetch_array($sqlquery)) {
                    $bil = $no++;
                    if ($USER->id != '2') {
                        $getuserid = $sqlrow['userid'];
                    } else {
                        $getuserid = $sqlrow['id'];
                    }
                    ?>
                    <tr>
                        <td class="adjacent" width="1%" align="center"><?php echo $bil + ($startpoint); ?></td>
                        <td class="adjacent" style="text-align:left;"><?= strtoupper($sqlrow['traineeid']); ?></td>
                        <td class="adjacent" style="text-align:left;">
                            <?php
                            //view user fullname
                            $userfullname = $sqlrow['firstname'] . ' ' . $sqlrow['lastname'];
                            echo ucwords(strtolower($userfullname));
                            ?>
                        </td>
                        <td class="adjacent" style="text-align:left;">
                            <?php echo $sqlrow['email']; ?>
                        </td>
                        <td class="adjacent" style="text-align:center;">
                            <?php
                            //echo $sqlrow['userid']; //user role
                            $sqluser = mysql_query("SELECT * FROM mdl_cifarole_assignments a, mdl_cifarole b WHERE a.roleid=b.id AND a.userid='" . $getuserid . "'");
                            $suser = mysql_fetch_array($sqluser);
                            if ($suser['name'] != '') {
                                if ($suser['name'] != $sqlrow['usertype']) {
                                    $querole = $DB->get_records('role_assignments', array('userid' => $getuserid));
                                    foreach ($querole as $qrol) {
                                        $sq = mysql_query("SELECT id, name FROM mdl_cifarole WHERE id='" . $qrol->roleid . "'");
                                        $qs = mysql_fetch_array($sq);
                                        //update usertype
                                        $updatetype = mysql_query("UPDATE mdl_cifauser SET usertype='" . $qs['name'] . "' WHERE id='" . $getuserid . "'");
                                    }
                                }
                                //user role-name
                                //echo $suser['name'];
                                if (($suser['roleid'] == '5') || ($suser['roleid'] == '9')) {
                                    echo 'Candidate';
                                }
                            } else {
                                //if($USER->id!='2'){
                                //	$s=mysql_query("SELECT * FROM mdl_cifauser WHERE usertype!='Active candidate' AND id='".$sqlrow['userid']."'");
                                //}else{
                                $s = mysql_query("SELECT * FROM mdl_cifauser WHERE usertype!='Active candidate' AND id='" . $getuserid . "'");
                                //}
                                $sbil = mysql_num_rows($s);
                                if ($sbil != '0') {
                                    $myrole = mysql_fetch_array($s);
                                    //echo $myrole['usertype'];
                                    if ($myrole['usertype'] == 'Inactive candidate') {
                                        echo 'Candidate';
                                    }
                                } else {
                                    echo 'Candidate';
                                }
                            }
                            ?>
                        </td>	
                        <td align="center" class="adjacent">
                            <?php
                            //start date
                            require_once('functiontime.php');
                            $createdate = unix_timestamp_to_human($sqlrow['timecreated']);

                            $tarikhdaftar = $sqlrow['timecreated'];
                            $tarikhakhir = $sqlrow['lasttimecreatedreg'];
                            // echo $sqlrow['lasttimecreatedreg'];
                            $today = strtotime('now');

                            global $DB;

                            $sql = "							
									Select
									  c.timestart, c.timeend, DATE_ADD(FROM_UNIXTIME(d.timecreated,'%Y-%m-%d'), INTERVAL 120 DAY) as lasttimecreated
									From
									  mdl_cifacourse a Inner Join
									  mdl_cifaenrol b On a.id = b.courseid Inner Join
									  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
									  mdl_cifauser d On c.userid = d.id
									Where
									  c.userid = '" . $getuserid . "' And
									  b.enrol = 'manual' And
									  a.category = '1' And
									  a.visible = '1' And
									  b.status = '0' Group By c.userid";

                            $rs = $DB->get_record_sql($sql);

                            //if(strtotime('now') > strtotime($rs->lasttimecreated)){ echo 'Inactive'; }else{ echo 'Active'; }	

                            if ($rs->timeend >= strtotime($rs->lasttimecreated)) {
                                if (strtotime('now') > $rs->timeend) {
                                    echo 'Inactive';
                                } else {
                                    echo 'Active';
                                }
                            } else {
                                if (strtotime('now') > strtotime($rs->lasttimecreated)) {
                                    echo 'Inactive';
                                } else {
                                    echo 'Active';
                                }
                            }

                            if ($tarikhdaftar <= $today && $today <= $tarikhakhir) {
                                // echo'Active';
                            } else {

                                $displayrole = mysql_query("SELECT * FROM mdl_cifarole WHERE (id='5' OR id='13')");
                                $countroles = mysql_num_rows($displayrole);
                                if ($countroles != '0') {
                                    //inactive bila sudah expired dr. last date
                                    //to make sure all enrolment status ='1'
                                    $semak = mysql_query("SELECT status FROM mdl_cifauser_enrolments WHERE status!='1' AND userid='" . $getuserid . "'");
                                    $countsemak = mysql_num_rows($semak);
                                    if ($countsemak != '0') {
                                        //$supdate = mysql_query("UPDATE mdl_cifauser_enrolments SET status='1' WHERE status!='1' AND userid='" . $getuserid . "'");
                                        //change role from active to inactive
                                        //$roleupdate = mysql_query("UPDATE mdl_cifarole_assignments SET roleid='9', contextid='1' WHERE roleid='5' AND contextid!='1' AND userid='" . $getuserid . "'");
                                        if ($roleupdate) {
                                            $queryrole = $DB->get_records('role_assignments', array('userid' => $getuserid));
                                            foreach ($queryrole as $qrole) {
                                                $sq = mysql_query("SELECT id, name FROM mdl_cifarole WHERE id='" . $qrole->roleid . "'");
                                                $qs = mysql_fetch_array($sq);
                                                //update usertype
                                                //$updatetype = mysql_query("UPDATE mdl_cifauser SET usertype='" . $qs['name'] . "' WHERE id='" . $getuserid . "'");
                                            }
                                        }
                                    }

                                    //change role- active to inactive institution client
                                    //$Oroleupdate = mysql_query("UPDATE mdl_cifarole_assignments SET roleid='14' WHERE roleid='13' AND contextid='1' AND userid='" . $getuserid . "'");
                                    if ($Oroleupdate) {
                                        $queryrole = $DB->get_records('role_assignments', array('userid' => $getuserid, 'contextid' => '1'));
                                        foreach ($queryrole as $qrole) {
                                            $sq = mysql_query("SELECT id, name FROM mdl_cifarole WHERE id='" . $qrole->roleid . "'");
                                            $qs = mysql_fetch_array($sq);
                                            // update usertype
                                            // $updatetype = mysql_query("UPDATE mdl_cifauser SET usertype='" . $qs['name'] . "' WHERE id='" . $getuserid . "'");
                                        }
                                    }
                                }
                                //user status
                                // echo'Inactive';
                            }
                            //echo $tarikhdaftar.'<br/>';
                            ?>
                        </td>
                        <td class="adjacent" style="text-align:center;">
                            <form id="form1" name="form1" method="post" action="">
                                <div style="padding:3px;">
                                    <input type="submit" value="<?= get_string('reset'); ?>" name="resetpassword" onClick="this.form.action = '<?= $CFG->wwwroot . "/userfrontpage/resetpassword.php?id=" . $getuserid; ?>'"  onMouseOver="style.cursor = 'pointer'"/>
                                </div>
                            </form>

                        </td>	
                    </tr>
                <?php } ?>
                <?php
                // Reset password and sending email to user
                if ($_POST['resetpassword']) {

                    $cuserid = $_GET['id'];
                    $password = md5($pword_text);
                    $ucuser = mysql_query("UPDATE mdl_cifauser SET password='" . $password . "' WHERE id='" . $cuserid . "'") or die("Not update" . mysql_error());
                    $rop = $DB->get_recordset_sql("SELECT * FROM {user} WHERE id='" . $cuserid . "'");
                    foreach ($rop as $newuserpassword) {
                        resetcandidatepassword($newuserpassword);
                    }
                    $rop->close();
                }
                ?>                    
                <?php if ($ucuser) { ?>
                    <script language="javascript">
                        window.alert("Password have been reset to <?= $pword_text; ?>");
                    </script>
                    <?php
                }
            } else {
                ?> 
                <tr>
                    <td class="adjacent" colspan="7"><?= get_string('norecords'); ?></td>
                </tr>
            <?php } ?>
        </table>

        <div style="margin-top:10px;">
            <table align="center"><tr><td>
                        <?php
                        //paging numbers
                        echo pagination($statement, $limit, $page);
                        ?>
                    </td></tr></table>
        </div></div>
    <?php
}
echo $OUTPUT->footer();
?>