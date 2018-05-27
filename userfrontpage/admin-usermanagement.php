<!-- available course module-->
<div align="left" style="width:100%;margin: 10px 0px 10px 0px; float: right;">
    <div class="buttons">
        <a href="<?= 'user/editadvanced.php?id=-1'; ?>" class="positive" title="Click to add new user">
            <img src="image/switch_course_alternative.png" alt=""/><?= ucwords(strtolower(get_string('addusers'))); ?>
        </a>
        <!--a href="<?php //echo $CFG->wwwroot.'/userfrontpage/useraddcategory.php'; ?>" class="regular" title="Click to manage category/user"-->
        <a href="<?php echo $CFG->wwwroot . '/admin/user.php'; ?>" class="regular" title="Click to manage category/user">
            <img src="image/configure.png" alt=""/><?= ucwords(strtolower(get_string('managecategoryusers'))); ?>
        </a>
    </div></div>

<?php
$sql = "SELECT * FROM mdl_cifauser WHERE (id!='2' AND id!='1')";
$query = mysql_query($sql);
?>
<table id="availablecourse">
    <tr class="yellow">
        <th class="adjacent" width="1%"><?= get_string('no'); ?></th>
        <th class="adjacent" width="40%" align="left"><strong><?= get_string('name'); ?></strong></th>
        <th class="adjacent" width="29%" align="left"><strong><?= get_string('email'); ?></strong></th>
        <th class="adjacent" width="20%" style="text-align:center;"><?= get_string('usersrole'); ?></th>	
        <th class="adjacent" width="10%" style="text-align:center;"><?= get_string('status'); ?></th>
    </tr>
    <?php
    $row = mysql_fetch_array($query);
    $crow = mysql_num_rows($query);
    if ($crow != '0') {

        //paging
        $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
        $limit = 15;
        $startpoint = ($page * $limit) - $limit;

        $nrole = mysql_query("Select * FROM mdl_cifarole WHERE id='10'");
        $srole = mysql_fetch_array($nrole);

        //collect user to list out on table
        $statement = "mdl_cifauser WHERE 	deleted='0' AND confirmed='1' AND usertype!='" . $srole['name'] . "' AND firstaccess!='0' AND (id!='1' AND id!='2')";
        $sqlcourse = "SELECT * FROM {$statement}";
        $sqlcourse.=" LIMIT {$startpoint} , {$limit}";

        $sqlquery = mysql_query($sqlcourse);
        $no = '1';
        while ($sqlrow = mysql_fetch_array($sqlquery)) {
            $bil = $no++;
            ?>
            <tr>
                <td class="adjacent" width="1%" align="center"><?php echo $bil + ($startpoint); ?></td>
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
                <td class="adjacent" style="text-align:left;">
                    <?php
                    //echo $sqlrow['id']; //user role
                    $sqluser = mysql_query("SELECT * FROM mdl_cifarole_assignments a, mdl_cifarole b WHERE a.roleid=b.id AND a.userid='" . $sqlrow['id'] . "'");
                    $suser = mysql_fetch_array($sqluser);
                    if ($suser['name'] != '') {
                        if ($suser['name'] != $sqlrow['usertype']) {
                            $querole = $DB->get_records('role_assignments', array('userid' => $sqlrow['id']));
                            foreach ($querole as $qrol) {
                                $sq = mysql_query("SELECT id, name FROM mdl_cifarole WHERE id='" . $qrol->roleid . "'");
                                $qs = mysql_fetch_array($sq);
                                //update usertype
                                // $updatetype = mysql_query("UPDATE mdl_cifauser SET usertype='" . $qs['name'] . "' WHERE id='" . $sqlrow['id'] . "'");
                            }
                        }
                        //user role-name
                        echo $suser['name'];
                    } else {
                        $s = mysql_query("SELECT * FROM mdl_cifauser WHERE usertype!='Active candidate' AND id='" . $sqlrow['id'] . "'");
                        $sbil = mysql_num_rows($s);
                        if ($sbil != '0') {
                            $myrole = mysql_fetch_array($s);
                            echo $myrole['usertype'];
                        } else {
                            echo 'Active candidate';
                        }
                    }
                    ?>
                </td>	
                <td align="center" class="adjacent">
                    <?php
                    //status//active//inactive
                    //start date
                    require_once('functiontime.php');
                    $createdate = unix_timestamp_to_human($sqlrow['firstaccess']);

                    $tarikhdaftar = $sqlrow['firstaccess'];
                    //$tarikhakhir=$sqlrow['lasttimecreated'];

                    $tarikhakhir = strtotime("$createdate" . " + 1 year");
                    $today = strtotime('now');
                    //echo date('d-m-Y',$tarikhakhir).'---->'.date('d-m-Y',$lastcreated);
                    if ($tarikhdaftar <= $today && $today <= $tarikhakhir) {
                        echo'Active';
                    } else {
                        //$displayrole=mysql_query("SELECT * FROM mdl_cifarole WHERE (id='5' OR id='13')");
                        $displayrole = mysql_query("SELECT * FROM mdl_cifarole_assignments WHERE (roleid='5' OR roleid='13') AND userid='" . $sqlrow['id'] . "'");
                        $countroles = mysql_num_rows($displayrole);
                        //echo $countroles.'='.$sqlrow['id'];
                        if ($countroles != '0') {
                            //inactive bila sudah expired dr. last date
                            //to make sure all enrolment status ='1'
                            $semak = mysql_query("SELECT status FROM mdl_cifauser_enrolments WHERE status!='1' AND userid='" . $sqlrow['id'] . "'");
                            $countsemak = mysql_num_rows($semak);
                            //echo $countsemak;
                            if ($countsemak != '0') {
                                // $supdate = mysql_query("UPDATE mdl_cifauser_enrolments SET status='1' WHERE status!='1' AND userid='" . $sqlrow['id'] . "'");

                                //change role from active to inactive
                               // $roleupdate = mysql_query("UPDATE mdl_cifarole_assignments SET roleid='9', contextid='1' WHERE roleid='5' AND contextid!='1' AND userid='" . $sqlrow['id'] . "'");
                                if ($roleupdate) {
                                    $queryrole = $DB->get_records('role_assignments', array('userid' => $sqlrow['id']));
                                    foreach ($queryrole as $qrole) {
                                        $sq = mysql_query("SELECT id, name FROM mdl_cifarole WHERE id='" . $qrole->roleid . "'");
                                        $qs = mysql_fetch_array($sq);
                                        //update usertype
                                        // $updatetype = mysql_query("UPDATE mdl_cifauser SET usertype='" . $qs['name'] . "' WHERE id='" . $sqlrow['id'] . "'");
                                    }
                                }
                            }

                            //change role- active to inactive institution client
                            //$Oroleupdate = mysql_query("UPDATE mdl_cifarole_assignments SET roleid='14' WHERE roleid='13' AND contextid='1' AND userid='" . $sqlrow['id'] . "'");
                            if ($Oroleupdate) {
                                $queryrole = $DB->get_records('role_assignments', array('userid' => $sqlrow['id'], 'contextid' => '1'));
                                foreach ($queryrole as $qrole) {
                                    $sq = mysql_query("SELECT id, name FROM mdl_cifarole WHERE id='" . $qrole->roleid . "'");
                                    $qs = mysql_fetch_array($sq);
                                    //update usertype
                                    // $updatetype = mysql_query("UPDATE mdl_cifauser SET usertype='" . $qs['name'] . "' WHERE id='" . $sqlrow['id'] . "'");
                                }
                            }
                        }
                        //user status
                        if ($tarikhdaftar <= $today && $today <= $lastcreated) {
                            echo'Active';
                        } else {
                            echo'Inactive';
                        }
                    }
                    //echo $tarikhdaftar.'<br/>';
                    ?>
                </td>
            </tr>
        <?php }
    } else { ?> 
        <tr>
            <td class="adjacent" colspan="5">No record founds</td>
        </tr>
    <?php } ?>
</table>
<?php //echo date('Y',strtotime($startdate . " + 37 year")); ?>
<div style="margin-top:10px;">
    <table align="center"><tr><td>
                <?php
                //paging numbers
                echo pagination($statement, $limit, $page);
                ?>
            </td></tr></table>
</div>