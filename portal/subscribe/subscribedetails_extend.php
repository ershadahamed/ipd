<?php
require_once('../../config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/filelib.php');
include('../../manualdbconfig.php');
require_once("../../includes/functions.php");

$site = get_site();

$purchase = 'Purchase modules';
$title = "$SITE->shortname: Courses - " . $purchase;
$PAGE->set_title($title);
$PAGE->set_heading($site->fullname);
$PAGE->set_pagelayout('buy_a_cifa');

$buy_cifa = get_string('buyacifa');
$selectprogram = 'Select Program';
$your_details = 'Your Details';
$pay_details = 'Payment Method';
$pay_confirm = 'Confirmation';
$PAGE->navbar->add($buy_cifa)->add($selectprogram)->add($your_details)->add($pay_details)->add($pay_confirm);

echo $OUTPUT->header();

//candidate info
// $traineeID = strtoupper($_GET['traineeID']);
// $firstname = $_GET['name'];
// $lastname = $_GET['lastname'];
// $address = $_GET['address'];	
// $email = $_GET['email'];
// $phone = $_GET['phone'];
// $city = $_GET['state'];
// $country = $_GET['country'];
// $dob=$_GET['dob'];
// $gender=$_GET['gender'];

$extendcost = '50'; //cost for extend
$resitcost = '50'; //cost for extend
//candidate info //optional
$traineeID = strtoupper($_GET['traineeID']);
$titlename = $_GET['title'];
$middlename = $_GET['middlename'];
$address = $_GET['address'];
$address2 = $_GET['address2'];
$address3 = $_GET['address3'];
$state = $_GET['state'];

//candidate info //wajib isi
$firstname = $_GET['name'];
$lastname = $_GET['lastname'];
$dob = $_GET['dob'];
$gender = $_GET['gender'];
$email = $_GET['email'];
$city = $_GET['city'];
$postcode = $_GET['postcode'];
$country = $_GET['country'];
$phone = $_GET['phone'];

$co1 = $_GET['co1'];
$co2 = $_GET['co2'];
$co3 = $_GET['co3'];

$paymethod = $_POST['radio'];
$userfullname = $firstname . ' ' . $lastname;
$useraddress = $address . ', ' . $address2;

$today = strtotime('today');

$semakpengguna_statement = "SELECT * FROM mdl_cifacandidates WHERE candidateid='" . $USER->id . "' AND traineeid='" . $traineeID . "'";
$semakpengguna = mysql_query($semakpengguna_statement);
$count_semak = mysql_num_rows($semakpengguna);
//echo '-'.$count_semak;
if ($count_semak == '0') {
    //adding user to purchase info
    //$result=mysql_query("insert into mdl_cifacandidates values('','".$USER->id."','".$traineeID."','1','','".$userfullname."','".$dob."','".$gender."','".$email."','".$address."','','".$city."','".$country."','".$phone."')");

    $result = mysql_query("INSERT INTO mdl_cifacandidates(candidateid, traineeid, visible, title, name, firstname, middlename, lastname, dob, gender, email, address, address2, address3, postal, province, state_code, country, phone) 
VALUES('" . $USER->id . "','" . $traineeID . "','1', '" . $titlename . "', '" . $userfullname . "', '" . $firstname . "', '" . $middlename . "', '" . $lastname . "', '" . $dob . "', '" . $gender . "', '" . $email . "', '" . $address . "', '" . $address2 . "', '" . $address3 . "', '" . $postcode . "', '" . $city . "', '" . $state . "','" . $country . "','" . $phone . "')");

    $customerid = mysql_insert_id();
    $date = strtotime('now');
} else {
    $uresult = mysql_query("SELECT candidateid, serial FROM mdl_cifacandidates WHERE candidateid='" . $USER->id . "'");
    $uget = mysql_fetch_array($uresult);
    $customerid.=$uget['serial'];
}
if (is_array($_SESSION['cart'])) {
    if ($_GET['extendid'] != '3') {
        //communication references accepted
        $communication = mysql_query("INSERT INTO mdl_cifacommunication_reference
										SET serial='" . $customerid . "', traineeid='" . $traineeID . "', candidateid='" . $USER->id . "', rules1='" . $co1 . "', rules2='" . $co2 . "', rules3='" . $co3 . "', timeaccepted='" . $date . "'");
    }

    //adding orders
    $result = mysql_query("insert into mdl_cifaorders values('','','','new','" . $date . "','" . $customerid . "')");
    $orderid = mysql_insert_id();
}

$max = count($_SESSION['cart']);
for ($i = 0; $i < $max; $i++) {
    $pid = $_SESSION['cart'][$i]['productid'];
    $q = $_SESSION['cart'][$i]['qty'];
    $price = get_price($pid);
    //adding order details
    if ($_GET['extendid'] == '3') { //extendid
        mysql_query("insert into mdl_cifaorder_detail(orderid, productid, quantity, price,resitid) values ($orderid,$pid,$q,$extendcost," . $_GET['extendid'] . ")");
    } else if ($_GET['extendid'] == '4') {
        mysql_query("insert into mdl_cifaorder_detail(orderid, productid, quantity, price,resitid) values ($orderid,$pid,$q,$resitcost," . $_GET['resitid'] . ")");
    } else {
        mysql_query("insert into mdl_cifaorder_detail(orderid, productid, quantity, price) values ($orderid,$pid,$q,$price)");
    }

    if ($_GET['extendid'] == '3') {
        //extend///purchase detais to statement DB
        $descsubcribe = 'Extension';
        $istatementsql = mysql_query("
				INSERT INTO mdl_cifastatement
				SET 
					candidateid='" . $traineeID . "',
					subscribedate='" . $today . "', 
					courseid='" . $pid . "', 
					remark='" . $descsubcribe . "', 
					debit1='" . $extendcost . "'
				");
    } else if ($_GET['extendid'] == '4') {
        //re-sit an exam///purchase detais to statement DB
        $descsubcribe = 'Re-sit';
        $istatementsql = mysql_query("
				INSERT INTO mdl_cifastatement
				SET 
					candidateid='" . $traineeID . "',
					subscribedate='" . $today . "', 
					courseid='" . $pid . "', 
					remark='" . $descsubcribe . "', 
					debit1='" . $resitcost . "'
				");
    }
}

/////////////////////////////////////////////- ADDING USER -/////////////////////////////////////////////////////////////////////////////
if (is_array($_SESSION['cart'])) {
    //to get program id;
    $pro1 = mysql_query("SELECT productid FROM mdl_cifaorder_detail ORDER BY orderid DESC");
    $ord1 = mysql_fetch_array($pro1);
    $prodid = $ord1['productid'];

    //select program
    $usecategory = mysql_query("SELECT b.id, b.name FROM mdl_cifacourse a, mdl_cifacourse_categories b  WHERE b.id=a.category AND a.category='1' AND a.id='" . $prodid . "'");
    $progrow = mysql_fetch_array($usecategory);
    $programname = ucwords(strtolower($progrow['name']));
    //insert user program IPD@CIFA
    $userprogram = mysql_query("INSERT INTO mdl_cifauser_program SET userid='" . $USER->id . "', programid='" . $progrow['id'] . "', programname='" . $programname . "'");
}
//}
///////////////////////////////////////////////- END ADDING USER-//////////////////////////////////////////////////////////////////		
//***************************************************************************************************************************//
//untuk running number
$statementorder = mysql_query("SELECT * FROM mdl_cifaorders WHERE serial='" . $orderid . "' ORDER BY serial DESC");
$kiraorderid = mysql_fetch_array($statementorder);

$random = $kiraorderid['serial'];
$year = date('mY');
if ($random > 0 && $random < 9) {
    $a = '0000';
} else if ($random > 9 && $random < 99) {
    $a = '000';
} else if ($random > 99 && $random < 999) {
    $a = '00';
} else {
    $a = '0';
}
$confirmationno = 'SHAPE/' . $year . '/' . $a . '' . $random . '';

$statement21 = " mdl_cifacandidates a Inner Join mdl_cifaorders b On a.serial = b.customerid Inner Join mdl_cifaorder_detail c On b.serial = c.orderid";
$sqlcourse21 = "SELECT * FROM {$statement21} WHERE b.serial='" . $orderid . "'";
$sqlcourse21.=" Group By b.date Order By b.date DESC, a.traineeid DESC";
$sqlquery21 = mysql_query($sqlcourse21);
$sqlrow21 = mysql_fetch_array($sqlquery21);

$date = strtotime('now');
$newstatus = 'new';
$pendingstatus = 'pending';
$corruptedstatus = 'corrupted';

if (is_array($_SESSION['cart'])) {
    $updateprospect = mysql_query("UPDATE mdl_cifacandidates SET visible='1' WHERE traineeid='" . $sqlrow21['traineeid'] . "'");
    $update_cr = mysql_query("UPDATE mdl_cifaorders SET confirmationno='" . $confirmationno . "', paymethod='" . $paymethod . "', paystatus='" . $pendingstatus . "', date='" . $date . "' WHERE serial='" . $orderid . "' AND paystatus='" . $newstatus . "' AND customerid='" . $customerid . "'");

    $upuserinfo = mysql_query("UPDATE mdl_cifauser SET gender='" . $gender . "', middlename='" . $middlename . "', address='" . $_GET['address'] . "', address2='" . $address2 . "', address3='" . $address3 . "', state='" . $state . "', city='" . $city . "', phone1='" . $_GET['phone'] . "' WHERE id='" . $USER->id . "'");
}
// $upuserinfo=mysql_query("UPDATE mdl_cifauser SET gender='".$gender."', middlename='".$middlename."', address='".$_GET['address']."', address2='".$address2."', address3='".$address3."', state='".$state."', city='".$city."', phone1='".$_GET['phone']."' WHERE id='".$USER->id."'");
?>

<script type="text/javascript">
    function printPage() {
        if (document.all) {
            document.all.divButtons.style.visibility = 'hidden';
            window.print();
            document.all.divButtons.style.visibility = 'visible';
        } else {
            document.getElementById('divButtons').style.visibility = 'hidden';
            window.print();
            document.getElementById('divButtons').style.visibility = 'visible';
        }
    }

    function myPopup2() {
        var printtxt = document.getElementById('printtxt').value;
        window.open(printtxt);
    }
</script>
<?php include('../../js/js_idletime.php'); ?>
<!--- step by step----->
<style>
    h3 { color:#ffffff;}
    #shopcart img{max-width:80%;}
</style>
<table id="shopcart" width="80%" border="0" style="text-align:left;">
    <tr>
        <td width="20%" align="center"><img src="../../image/step4_confirmation.png" width="80%"></td>   
    </tr>
</table>

<table width="80%" style="bgcolor:#FFFFFF;" border="0" style="margin: 0px auto;">
    <tr>
        <td>
<?= get_string('emailenrolmentmsj'); ?>
        </td>           
    </tr> 
</table>
<?php
$acinfo = mysql_query("SELECT * FROM {$CFG->prefix}account_info");
$aci = mysql_fetch_array($acinfo);
?>
<table id="availablecourse3"  width="99%" border="1" style="bgcolor:#FFFFFF; border-collapse: collapse; border-spacing: 0; border-color:#cccccc;margin: 0px auto;">
    <tr style="background-color:#21409A;"><td colspan="3"><h3><?= $aci['headtitle']; ?></h3></td></tr>	
    <tr><td width="20%">Branch</td><td width="1%"><strong>:</strong></td><td><?= $aci['branch']; ?></td></tr>
    <tr><td>Account Title/Beneficiary</td><td><strong>:</strong></td><td><?= $aci['account_title']; ?></td></tr>
    <tr><td>SWIFT Code</td><td><strong>:</strong></td><td><?= $aci['swiftcode']; ?></td></tr>
    <tr><td>IBAN  #	</td><td><strong>:</strong></td><td><?= $aci['iban']; ?></td></tr>
    <tr><td>Account Number</td><td><strong>:</strong></td><td><?= $aci['accountnumber']; ?></td></tr>	
    <tr><td>Reference</td><td><strong>:</strong></td><td><?= $traineeID; ?></td></tr>
    <tr><td colspan="3"><?= $aci['textline1']; ?></td></tr>
    <tr><td colspan="3"><?= $aci['textline2']; ?><?php //$a = new stdClass(); $a='contact@learncifa.com';  ?><?//=get_string('textpayment', '', $a);?></td></tr>
    <tr style="background-color:#d6dee7;"><td colspan="3">&nbsp;</td></tr>	
</table><br/>
<table width="100%" border="0" style="bgcolor:#FFFFFF; border-collapse: collapse; border-spacing: 0; border-color:#cccccc;margin: 0px auto;">  
    <tr>
        <td>
            <?php
            //to get program id;
            //$pro1=mysql_query("SELECT productid, quantity, price FROM mdl_cifaorder_detail WHERE orderid='".$orderid."' ORDER BY orderid DESC");
            $pro1 = mysql_query("
				Select
				  b.customerid,
				  c.productid,
				  a.name,
				  c.quantity,
				  c.price,
				  a.traineeid,
				  a.email,
				  b.confirmationno
				From
				  mdl_cifacandidates a Inner Join
				  mdl_cifaorders b On a.serial = b.customerid Inner Join
				  mdl_cifaorder_detail c On b.serial = c.orderid
				Where c.orderid='" . $orderid . "'
			");

            $ord1 = mysql_fetch_array($pro1);
            $prodid = $ord1['productid'];

            $pro2 = mysql_query("SELECT productid, quantity, price FROM mdl_cifaorder_detail WHERE orderid='" . $orderid . "' ORDER BY orderid DESC");
            ?>
            <table id="availablecourse3" style="bgcolor:#FFFFFF; border-collapse: collapse; border-spacing: 0; border-color:#cccccc;margin: 0px auto;" width="100%" border="1">
                <tr style="background-color:#21409A;">
                    <td colspan="4"><h3><?= get_string('orderconfirmationtitle'); ?></h3></td>
                </tr>	
                <tr bgcolor="#d6dee7">
                    <td colspan="4"><strong>Candidate Information</strong></td>
                </tr>	

                <tr style="background-color:#fff; border-color:#cccccc;" valign="top">
                    <td width="50%">
                        <?php
                        $sqlst = mysql_query("SELECT * FROM mdl_cifauser WHERE traineeid='" . $traineeID . "'");
                        $qst = mysql_fetch_array($sqlst);

                        $sqlco = mysql_query("SELECT * FROM mdl_cifacountry_list WHERE countrycode='" . $country . "'");
                        $qco = mysql_fetch_array($sqlco);
                        ?>
                        <table id="candidatedetails" style="width:100%;padding:0px;">
                            <tr valign="top">
                                <td width="30%"><strong><?= get_string('candidateid'); ?></strong></td><td width="1%"><strong>:</strong></td><td><?= strtoupper($traineeID); ?></td>
                            </tr>
                            <tr valign="top"><td><strong><?= get_string('name'); ?></strong></td><td width="1%"><strong>:</strong></td><td><?= $qst['firstname'] . ' ' . $qst['middlename'] . ' ' . $qst['lastname']; ?></td></tr>
                            <tr valign="top"><td><strong><?= get_string('email1'); ?></strong></td><td width="1%"><strong>:</strong></td><td><?= $qst['email']; ?></td></tr>
                            <tr valign="top">
                                <td><strong><?= get_string('contactno'); ?></strong></td>
                                <td width="1%"><strong>:</strong></td>
                                <?php if ($qst['phone1'] != '') { ?>
                                    <td>+<?= $qco['iso_countrycode'] . $qst['phone1']; ?><br/></td>
<?php } else { ?>
                                    <td>+<?= $qco['iso_countrycode'] . $_GET['phone']; ?><br/></td>
                                <?php } ?>
                            </tr>
                            <tr style="vertical-align:top;">
                                <td><strong><?= get_string('address'); ?></strong></td>
                                <td width="1%"><strong>:</strong></td>
                <?php if (($qst['postal'] != '') || ($qst['province'] != '')) { ?>
                                    <td><?= $qst['address'] . ', ' . $qst['postal'] . ' ' . $qst['province'] . ', ' . $qco['countryname']; ?></td>
                                </tr>
<?php } else { ?>
                                <td><?= $_GET['address'] . ' ' . $_GET['address2'] . ' ' . $_GET['address3'] . ', ' . $_GET['poscode'] . ' ' . $_GET['state'] . ', ' . $qco['countryname']; ?></td></tr>
<?php } ?>
            </table>			
        </td>
        <td colspan="3">
            <table id="candidatedetails" style="width:100%" >
                <tr valign="top">
                    <td width="25%"><strong>Confirmation no.</strong></td><td width="1%"><strong>:</strong></td><td><?= $ord1['confirmationno']; ?></td>
                </tr>
            </table>			
        </td>			
    </tr>

    <tr bgcolor="#d6dee7">
        <td colspan="4"><strong>Transaction details</strong></td>
    </tr>
    <tr bgcolor="#efeff7">
        <td><strong>Description</strong></td>
        <td><strong>Unit price</strong></td>
        <td align="center" width="1%"><strong>Qty</strong></td>
        <td width="20%"><strong>Amount</strong></td>
    </tr>
<?php
while ($ord2 = mysql_fetch_array($pro2)) {
    $bil = '0';
    ?>
        <tr bgcolor="#FFFFFF">
            <td>
                <?php
                $prodid2 = $ord2['productid'];
                $seprod = mysql_query("
						Select fullname From mdl_cifacourse Where id='" . $prodid2 . "'
					");
                $quprod = mysql_fetch_array($seprod);

                // resit ID
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
						  e.userid='" . $USER->id . "'	And b.course='" . $prodid2 . "' And	c.id='" . $_GET['resitid'] . "'
					");
                $finalarray = mysql_fetch_array($cfinaltestsql);
                $finalexamid = $finalarray['cifaquizid'];
                $examname = $finalarray['name'] . ' - (' . get_string('resitexam') . ')';
                if ($_GET['extendid'] == '4') {
                    echo $examname;
                } else {
                    echo $quprod['fullname'] . '&nbsp;';
                }

                if ($_GET['extendid'] == '3') {
                    echo get_string('extension');
                }
                ?>
            </td>
            <td>$ <?= $ord2['price']; ?> USD</td>
            <td align="center"><?= $ord2['quantity']; ?></td>
            <td>$ <?= $ord2['price']; ?> USD</td>
        </tr>
        <?php } ?>
    <tr bgcolor="#efeff7">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center"><strong>Total</strong></td>
        <?php if ($_GET['extendid'] == '3') { ?>
            <td>$ <?= $extendcost; ?> USD</td>
        <?php } else if ($_GET['extendid'] == '4') { ?>
            <td>$ <?= $resitcost; ?> USD</td>
<?php } else { ?>
            <td>$ <?php echo get_order_total() ?> USD</td>
<?php } ?>
    </tr>  
</table>		
<!-- Billing info order -->			
</td>
</tr>
</table>
<div style="text-align:center;" id="confirmationenrollbuttons">
    <?php
    $printtxt = $CFG->wwwroot . '/printenrolstatement.php?confirmationno=' . $ord1['confirmationno'] . '&traineeid=' . $traineeID . '&country=' . $country . '&orderid=' . $orderid . '&total=' . get_order_total() . '&phone2=' . $qst['phone2'] . '&gender=' . $gender . '&extendid=' . $_GET['extendid'] . '&resitid=' . $_GET['resitid'];
    $cifaworkspace = $CFG->wwwroot . '/index.php';
    $learncifacom = $CFG->wwwroot . '/index.php';
    ?>
    <input type="hidden" name="printtxt" id="printtxt" value="<?= $printtxt; ?>"/>			
    <input type="button" value=" Print this page " onClick="myPopup2()" name="printthispage" />
    <input type="submit" title="<?= get_string('cifaworkspace'); ?>" onClick="this.form.action = '<?= $cifaworkspace; ?>'" value="<?= get_string('cifaworkspace'); ?>.com" name="cifaworkspace" />
</div><br/>
<?php unset($_SESSION['cart']);
echo $OUTPUT->footer(); ?>