<?php
require_once('../config.php');
include('../manualdbconfig.php');
include_once ('../pagingfunction.php');

$site = get_site();

$heading = ucwords(strtolower(get_string('enrollmentprogram')));
$title = "$SITE->shortname: " . $heading;
$PAGE->set_title($title);
$PAGE->set_heading($site->fullname);

$PAGE->set_pagelayout('enrollment');
$urlenroll = new moodle_url('/userfrontpage/listofnameenrolment.php');
$link1 = new moodle_url('/user/profile.php', array('id' => $USER->id));
$PAGE->navbar->add(get_string('myprofile'), $link1)->add("SHAPE Enrollment Confirmation", $urlenroll);

echo $OUTPUT->header();

if (isloggedin()) {
    if ($USER->id != '2') {
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
        $rsc = mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='" . $USER->id . "' AND (email='' OR college_edu='' OR highesteducation='0' OR yearcomplete_edu='0')");
        $srows2 = mysql_num_rows($rsc);
        if ($srows2 != '0') {
            ?>
            <script language="javascript">
                window.location.href = '<?= $CFG->wwwroot . '/user/edit.php?id=' . $USER->id . '&course=1'; ?>';
            </script>
            <?php
        }
    }

    echo $OUTPUT->heading($heading, 2, 'headingblock header');

    //$sql="SELECT * FROM mdl_cifauser";
    //$query=mysql_query($sql);
    ?>
    <style>
    <?php
    include('../css/style2.css');
    include('../css/button.css');
    include('../css/pagination.css');
    include('../css/grey.css');
    ?>
    </style>
    <!---Search------>

    <link rel="stylesheet" type="text/css" media="all" href="offlineexam/jsDatePick_ltr.min.css" />
    <script type="text/javascript" src="offlineexam/jquery.1.4.2.js"></script>
    <script type="text/javascript" src="offlineexam/jsDatePick.jquery.min.1.3.js"></script>
    <script type="text/javascript">
        window.onload = function () {
            new JsDatePick({
                useMode: 2,
                target: "inputField",
                dateFormat: "%d-%m-%Y"
            });
        };
    </script>
    <script type="text/javascript">
        /***untuyk select value listbox to textbox***/
        function displ()
        {
            if (document.formname.cariandate.value == true) {
                return false
            }
            else {
                document.formname.dob2.value = document.formname.cariandate.value;
            }
            return true;
        }
    </script>
    <div style="min-height: 250px;">
        <!--form id="formname" name="formname" method="post" onClick="return displ();">
        <table border="0" cellpadding="1" cellspacing="1" style="margin-top:30px; width:95%; font:13px/1.231 arial,helvetica,clean,sans-serif bolder;">
                <tr>
                        <td style="width:180px;text-align:right;">
                        <select name="pilihancarian" style="width:180px;">
                                <option value=""> - select - </option>
                                <option value="traineeid"><?= get_string('candidateid'); ?></option>
                                <option value="name"><?= get_string('name'); ?></option>
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
                                <option value="name"><?= get_string('name'); ?></option>
                        </select>
                        </td>
                        <td width="10%"><input type="text" name="traineeid2" style="width:250px;" /></td>
                </tr> 	
        </table>
        </form-->
        <!---End search---->

        <?php
        $selectsearch = $_POST['pilihancarian'];
        $candidateid = $_POST['traineeid'];
        $selectsearch2 = $_POST['pilihancarian2'];
        $candidateid2 = $_POST['traineeid2'];
        ?>
        <table id="availablecourse" style="margin-top:30px;">
            <tr class="yellow" style="padding: 5px;">
                <th class="adjacent" width="1%">No</th>
                <th class="adjacent" width="25%" style="text-align:center;padding: 5px;"><strong><?= get_string('confirmationno'); ?></strong></th>
                <th class="adjacent" width="28%" style="text-align:left;padding: 5px;"><?= get_string('coursemodule'); ?></th>	
                <th class="adjacent" width="20%" style="text-align:left;padding: 5px;"><?= get_string('paymentmethod'); ?></th>
                <th class="adjacent" width="20%" style="text-align:center;padding: 5px;"><?= get_string('datepurchase'); ?></th>
                <th class="adjacent" width="7%" style="text-align:center;padding: 5px;"><?//=get_string('status');?></th>
            </tr>
            <?php
            //$row=mysql_fetch_array($query);
            //paging
            $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
            $limit = 12;
            $startpoint = ($page * $limit) - $limit;

            //collect user to list out on table
            $statement = " mdl_cifacandidates a Inner Join mdl_cifaorders b On a.serial = b.customerid Inner Join mdl_cifaorder_detail c On b.serial = c.orderid";
            $sqlcourse = "SELECT * FROM {$statement} WHERE ((b.paystatus!='new') AND (b.paystatus!='cancel') AND (b.paystatus!='corrupted')) AND a.traineeid = '" . $USER->traineeid . "'";
            if ($candidateid != '' && $selectsearch != '') {
                $sqlcourse.= " AND (($selectsearch LIKE '%" . $candidateid . "%'))";
            }
            if ($candidateid2 != '' && $selectsearch2 != '') {
                $sqlcourse.= " AND (($selectsearch2 LIKE '%" . $candidateid2 . "%'))";
            }
            if ($candidateid != '' && $selectsearch != '' && $candidateid2 != '' && $selectsearch2 != '') {
                $sqlcourse.= " AND (($selectsearch LIKE '%" . $candidateid . "%') AND ($selectsearch2 LIKE '%" . $candidateid2 . "%'))";
            }
            $sqlcourse.=" Group By b.date Order By b.date DESC, a.traineeid DESC";

            $sqlquery = mysql_query($sqlcourse);
            $sqlsemakrow = mysql_num_rows($sqlquery);

            if ($sqlsemakrow != '0') {

                $no = '1';
                while ($sqlrow = mysql_fetch_array($sqlquery)) {
                    ?>
                    <?php
                    /* $pstatus1=$sqlrow['paystatus'] == 'new';
                      $pstatus2=$sqlrow['paystatus'] == 'paid';
                      $color1='background-color:#fff;';
                      $color2='background-color:#81F781;';
                      $color3='background-color:#FA5858;'; */

                    $semakenrol = mysql_query("
		Select
		  b.userid,
		  a.courseid
		From
		  mdl_cifaenrol a Inner Join
		  mdl_cifauser_enrolments b On a.id = b.enrolid
		Where
		  b.userid = '" . $USER->id . "' And a.courseid='" . $sqlrow['productid'] . "'
	");
                    $cenrol = mysql_num_rows($semakenrol);
                    if ($cenrol != '0') {
                        $bil = $no++;
                        ?>
                        <tr style="<?php if ($pstatus1) {
                            echo $color1;
                        } else if ($pstatus2) {
                            echo $color2;
                        } else {
                            echo $color3;
                        } ?>">
                            <td class="adjacent" width="1%" align="center"><?php echo $bil + ($startpoint); ?></td>
                            <td class="adjacent" style="text-align:center;">
                                <?php echo $sqlrow['confirmationno']; ?>
                            </td>	
                            <td class="adjacent" style="text-align:left;">
                                <?php
                                //senarai kursus yang dibeli		
                                if ($sqlrow['paymethod'] == 'telegraphic') {
                                    $sqluser = mysql_query("
				Select
				  *
				From
					mdl_cifacandidates a Inner Join
					mdl_cifaorders b On a.serial = b.customerid Inner Join
					mdl_cifaorder_detail c On b.serial = c.orderid
				Where a.traineeid = '" . $sqlrow['traineeid'] . "' And b.paymethod='telegraphic' And b.date='" . $sqlrow['date'] . "'
			");
                                }
                                if ($sqlrow['paymethod'] == 'paypal') {
                                    $sqluser = mysql_query("
				Select
				  *
				From
					mdl_cifacandidates a Inner Join
					mdl_cifaorders b On a.serial = b.customerid Inner Join
					mdl_cifaorder_detail c On b.serial = c.orderid
				Where a.traineeid = '" . $sqlrow['traineeid'] . "' And b.paymethod='paypal' And b.date='" . $sqlrow['date'] . "'
			");
                                }
                                if ($sqlrow['paymethod'] == 'creditcard') {
                                    $sqluser = mysql_query("
				Select
				  *
				From
					mdl_cifacandidates a Inner Join
					mdl_cifaorders b On a.serial = b.customerid Inner Join
					mdl_cifaorder_detail c On b.serial = c.orderid
				Where a.traineeid = '" . $sqlrow['traineeid'] . "' And b.paymethod='creditcard' And b.date='" . $sqlrow['date'] . "'
			");
                                }

                                $b = '1';
                                while ($suser = mysql_fetch_array($sqluser)) {

                                    $slecourse = mysql_query("Select * From mdl_cifacourse Where id='" . $suser['productid'] . "'");
                                    $qselcourse = mysql_fetch_array($slecourse);

                                    //echo $b++.') - '.$qselcourse['fullname'].'<br/>';
                                    echo $qselcourse['fullname'] . '<br/>';
                                }
                                ?>
                            </td>	
                            <td class="adjacent" style="text-align:left;">
                                <?php
                                if ($sqlrow['paymethod'] == 'telegraphic') {
                                    $telegraphic = 'Bank Transfer';
                                    echo ucwords(strtolower($telegraphic));
                                }
                                if ($sqlrow['paymethod'] == 'paypal') {
                                    $paypal = 'Paypal';
                                    echo ucwords(strtolower($paypal));
                                }
                                if ($sqlrow['paymethod'] == 'creditcard') {
                                    $creditcard = 'Credit card';
                                    echo ucwords(strtolower($creditcard));
                                }
                                ?>
                            </td>
                            <td class="adjacent" style="text-align:center;">
                <?php $datepurchase = $sqlrow['date'];
                echo date('d-m-Y', $datepurchase); ?>
                            </td>
                            <td class="adjacent" style="text-align:center; vertical-align:middle;">
                                <div style="padding:5px;">
                                    <input id="id_actionbutton" onclick="window.open('<?php echo $CFG->wwwroot . "/viewenrolmentconfirmation.php?orderid=" . $sqlrow['orderid']; ?>', 'Window2', 'width=880,height=630,resizable = 1, scrollbars=yes');" onMouseOver="style.cursor = 'pointer'" type="button" name="viewconfirmation" value="&nbsp;<?= get_string('view'); ?>&nbsp;"/>
                                </div>	
                            </td>		
                        </tr>
            <?php }
        } // end while	 	
    } else {
        ?> 
                <tr>
                    <td class="adjacent" colspan="7"><?= get_string('norecords'); ?></td>
                </tr>
    <?php } ?>
        </table>
        <div style="margin-top:10px;">
            <table align="center"><tr><td>
                    </td></tr></table>
        </div></div>
    <?php
}
echo $OUTPUT->footer();
?>