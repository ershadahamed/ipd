<?php
    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('manualdbconfig.php'); 
	include("includes/functions.php");

	$site = get_site();
	
	$purchase='Purchase IPD modules';
	$title="$SITE->shortname: SHAPE IPD - ".$purchase;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    $buy_cifa=get_string('buyacifa');
	$selectprogram='Select Program';
	$your_details='Your Details';
	$pay_details='Payment Method';
	$pay_confirm='Confirmation';
	$PAGE->navbar->add($buy_cifa)->add($selectprogram)->add($your_details)->add($pay_details)->add($pay_confirm);
	
	echo $OUTPUT->header();	
	$traineeID = $_GET['traineeID'];
	$title = $_GET['title'];
	$firstname = $_GET['name'];
	$middlename = $_GET['middlename'];
	$lastname = $_GET['lastname'];
	$dob = $_GET['dob'];
        $gender = $_GET['gender'];
	$address = $_GET['address'];
	$address2 = $_GET['address2'];
	$address3 = $_GET['address3'];
	$email = $_GET['email'];
	$phone = $_GET['phone'];
	$phone2 = $_GET['phone2'];
	$province = $_GET['state'];
	$city = $_GET['city'];
	$postal = $_GET['postalcode'];
	$country = $_GET['country'];
	
	$co1=$_GET['co1'];
	$co2=$_GET['co2'];
	$co3=$_GET['co3'];
	$customerid=$_GET['customerid'];
	$orderid=$_GET['orderid'];	
	$paymethod=$_POST['radio'];
        
        //billing info//credit card
        $billtraineeid=$_GET['traineeID'];
        $billtitle=$_POST['billingtitle'];
        $billname=$_POST['billingname'].' '.$_POST['billingmiddlename'].' '.$_POST['billinglastname'];
        $billdob=$_POST['billingdob'];
        $billgender=$_POST['billgender'];
        $billemail=$_POST['billingemail'];
        $billaddressuser=$_POST['billingaddress'].' '.$_POST['billingaddress2'];
        $billpostal=$_POST['billingpostalcode'];
        $billprovince=$_POST['billprovince'];
        $billcountry=$_POST['billingcountry'];
        $billphone=$_POST['billingphoneM']; 
	
	//untuk running number
	$statementorder=mysql_query("SELECT * FROM mdl_cifaorders WHERE serial='".$orderid."' ORDER BY serial DESC");
	$kiraorderid=mysql_fetch_array($statementorder);
	$countorder=mysql_num_rows($statementorder);
	
	$random=$kiraorderid['serial'];
	$year=date('mY');
	if($random > 0 && $random < 9){ $a='0000';}
	else if($random > 9 && $random < 99){ $a='000';}
	else if($random > 99 && $random < 999){ $a='00';}
	else{$a='0';}
	
	// $sqlid=mysql_query("SELECT * FROM {$CFG->prefix}user_program WHERE programid='1' AND traineeid='".$traineeID."'");
	// $userprogram_id=mysql_num_rows($sqlid);
	// if($userprogram_id != '1'){ //// shape
		// $userprogid='SHAPE';
	// }else{ //ipd
		// $userprogid='IPD';
	// }
	$confirmationno='SHAPE/'.$year.'/'.$a.''.$random.'';

	$statement21=" mdl_cifacandidates a Inner Join mdl_cifaorders b On a.serial = b.customerid Inner Join mdl_cifaorder_detail c On b.serial = c.orderid";		
	$sqlcourse21="SELECT * FROM {$statement21} WHERE b.serial='".$orderid."'";
	$sqlcourse21.=" Group By b.date Order By b.date DESC, a.traineeid DESC";	
	$sqlquery21=mysql_query($sqlcourse21);
	$sqlrow21=mysql_fetch_array($sqlquery21);	

	$date=strtotime('now');
	$newstatus='new';
	$pendingstatus='pending';
	$corruptedstatus='corrupted';
	
	if(is_array($_SESSION['cart'])){
		$updateprospect=mysql_query("UPDATE mdl_cifacandidates SET visible='1' WHERE traineeid='".$sqlrow21['traineeid']."'");	
		$update_cr=mysql_query("UPDATE mdl_cifaorders SET confirmationno='".$confirmationno."', paymethod='".$paymethod."', paystatus='".$pendingstatus."', date='".$date."' WHERE serial='".$orderid."' AND paystatus='".$newstatus."' AND customerid='".$customerid."'");
	
                if($paymethod=='creditcard'){
                    //insert data billing info//
                    $billingquery=mysql_query("INSERT INTO mdl_cifabilling_info(traineeid, visible, billtitle, billname, billdob, billgender, billemail, billaddress, billpostal, billprovince, billcountry, billphone) 
                        VALUES(".$billtraineeid."','1','".$billtitle."','".$billname."','".$billdob."','".$billgender."','".$billemail."','".$billaddressuser."','".$billpostal."','".$billprovince."','".$billcountry."','".$billphone."')");
                }
        }

?>
<?
 if (isloggedin()) {
	header("location:index.php");
 }else{
		if(is_array($_SESSION['cart'])){

		$username=strtolower($traineeID);
		$pword_text='Pword01$';
		$password=md5($pword_text);
		$timecreated = strtotime('now');
		$lastcreated = strtotime("now" . " + 1 year");
		$addressUser=$address.' '.$address2;
	   
		$srole=mysql_query("SELECT name FROM mdl_cifarole WHERE id='5'");
		$rwrole=mysql_fetch_array($srole);
		$usertype=$rwrole['name'];	   
		
		//update usertype to active
		$updateuser=mysql_query("UPDATE mdl_cifauser SET usertype='".$usertype."' WHERE traineeid='".$traineeID."'");			
		}
}		
?>
<script type="text/javascript"> 
function printPage() {
	if(document.all) {
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
<style>
<?php 
	include('css/style2.css'); 	
?>
</style>
<?php
	//idle time
	include('js/js_idletime.php');
?>
<center>
<style>
#shopcart img{max-width:80%;}
h3{color:#ffffff;}
</style>
<table id="shopcart" width="80%" border="0" style="text-align:left;">
	<tr>
	<td width="20%" align="center"><img src="image/step4_confirmation.png" width="80%"></td>   
	</tr>
</table>

<table width="100%" style="bgcolor:#FFFFFF;" border="0" style="float:right;margin: 0px auto;">
    <tr>
		<td>
		<?=get_string('emailenrolmentmsj');?>
		</td>           
    </tr> 
</table>

<!--Remove bank account information-->
<!-- <table id="availablecourse3"  width="99%" border="1" style="bgcolor:#FFFFFF; border-collapse: collapse; border-spacing: 0; border-color:#cccccc;margin: 0px auto;">
	<tr style="background-color:#21409A;"><td colspan="3"><h3 style="padding-bottom: 0.5em; padding-top: 1em;">SHAPE for Economic Consulting W.L.L  at Boubyan Bank</h3></td></tr>	
	<tr><td width="20%">Branch</td><td width="1%"><strong>:</strong></td><td>Sharq Branch</td></tr>
	<tr><td>Account Title/Beneficiary</td><td><strong>:</strong></td><td>SHAPE for Economic Consulting W.L.L</td></tr>
	<tr><td>SWIFT Code</td><td><strong>:</strong></td><td>BBYNKWKW</td></tr>
	<tr><td>IBAN  #	</td><td><strong>:</strong></td><td>KW12 BBYN 0000 0000 0000 0149 0840 01 </td></tr>
	<tr><td>Account Number</td><td><strong>:</strong></td><td>0203319002</td></tr>	
	<tr><td>Reference</td><td><strong>:</strong></td><td><?=$traineeID;?></td></tr>
	<tr><td colspan="3">You will be liable for the additional charges incurred in the bank transfer.</td></tr>
	<tr><td colspan="3"><?php 
		$a = new stdClass(); 
		$a=get_string('ipdemail'); 
		echo get_string('textpayment', '', $a);
		?>
		<?//=get_string('textpayment', '', $a);?>
	</td></tr>
	<tr style="background-color:#d6dee7;"><td colspan="3">&nbsp;</td></tr>	
</table><br/> -->
<table width="100%" border="0" style="bgcolor:#FFFFFF; border-collapse: collapse; border-spacing: 0; border-color:#cccccc;margin: 0px auto;">  
	<tr>
		<td>

		<?php
			//to get program id;
			//$pro1=mysql_query("SELECT productid, quantity, price FROM mdl_cifaorder_detail WHERE orderid='".$orderid."' ORDER BY orderid DESC");
			$pro1=mysql_query("
				Select
				  b.customerid,
				  c.productid,
				  a.name,
				  c.quantity,
				  c.price,
				  a.traineeid,
				  a.email
				From
				  mdl_cifacandidates a Inner Join
				  mdl_cifaorders b On a.serial = b.customerid Inner Join
				  mdl_cifaorder_detail c On b.serial = c.orderid
				Where c.orderid='".$orderid."'
			");
			
			$ord1=mysql_fetch_array($pro1);
			$prodid=$ord1['productid'];
			
			$pro2=mysql_query("SELECT productid, quantity, price FROM mdl_cifaorder_detail WHERE orderid='".$orderid."' ORDER BY orderid DESC");
		?>
		<table id="availablecourse3" style="bgcolor:#FFFFFF; border-collapse: collapse; border-spacing: 0; border-color:#cccccc;margin: 0px auto;" width="100%" border="1">
		  <tr style="background-color:#21409A;">
			<td colspan="4"><h3 style="padding-bottom: 0.5em; padding-top: 1em;"><?=get_string('orderconfirmationtitle');?></h3></td>
		  </tr>	
		  <tr bgcolor="#d6dee7">
			<td colspan="4"><strong>Candidate Information</strong></td>
		  </tr>	

		  <tr style="background-color:#fff; border-color:#cccccc;" valign="top">
			<td width="50%">
				<?php
					$sqlst=mysql_query("SELECT * FROM mdl_cifauser WHERE traineeid='".$traineeID."' AND deleted='0'");
					$qst=mysql_fetch_array($sqlst);
					
					$sqlco=mysql_query("SELECT * FROM mdl_cifacountry_list WHERE countrycode='".$country."'");
					$qco=mysql_fetch_array($sqlco);
				?>
				<table id="candidatedetails" style="width:100%;padding:0px;">
					<tr valign="top">
						<td width="30%"><strong><?=get_string('candidateid');?></strong></td><td width="1%"><strong>:</strong></td><td><?=strtoupper($traineeID);?></td>
					</tr>
					<tr valign="top"><td><strong><?=get_string('name');?></strong></td><td width="1%"><strong>:</strong></td><td><?=$qst['firstname'].' '.$qst['middlename'].' '.$qst['lastname'];?></td></tr>
					<tr valign="top"><td><strong><?=get_string('email1');?></strong></td><td width="1%"><strong>:</strong></td><td><?=$qst['email'];?></td></tr>
					<tr valign="top">
						<td><strong><?=get_string('officetel');?></strong></td>
						<td width="1%"><strong>:</strong></td>
						<td><?=$qst['phone1'];?><br/>
						</td>
					</tr>
					<tr style="vertical-align:top;">
						<td><strong><?=get_string('address');?></strong></td>
						<td width="1%"><strong>:</strong></td>
						<?php if(($qst['postal']!='') || ($qst['province']!='')){ ?>
						<td><?=$qst['address'].', '.$qst['postal'].' '.$qst['province'].', '.$qco['countryname'];?></td></tr>
						<?php }else{ ?>
						<td><?=$qst['address'].', '.$qco['countryname'];?></td></tr>
						<?php } ?>
					<?php if($qst['address2']!=''){	?>
					<tr style="vertical-align:top;">
						<td>&nbsp;</td>
						<td width="1%"><strong>:</strong></td>
						<td><?=$qst['address2'];?></td></tr>
					<?php }if($qst['address3']!=''){ ?>
					<tr style="vertical-align:top;">
						<td>&nbsp;</td>
						<td width="1%"><strong>:</strong></td>
						<td><?=$qst['address3'];?></td></tr>	<?php } ?>						
				</table>			
			</td>
			<td colspan="3">
				<table id="candidatedetails" >
					<tr valign="top">
						<td width="30%"><strong>Confirmation no.</strong></td>
						<td width="1%"><strong>:</strong></td><td>
						<?=$confirmationno;?>
						</td>
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
		  while($ord2=mysql_fetch_array($pro2)){
		  $bil='0';
		  ?>
		  <tr bgcolor="#FFFFFF">
			<td>
			<?php
					$prodid2=$ord2['productid'];
					$seprod=mysql_query("
						Select fullname From mdl_cifacourse Where id='".$prodid2."'
					");
					$quprod=mysql_fetch_array($seprod);
					echo $quprod['fullname'].'<br/>';
			?>
			</td>
			<td>$ <?=$ord2['price'];?> USD</td>
			<td align="center"><?=$ord2['quantity'];?></td>
			<td>$ <?=$ord2['price'];?> USD</td>
		  </tr>
		  <?php } ?>
		  <tr bgcolor="#efeff7">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center"><strong>Total</strong></td>
			<td>$ <?php echo get_order_total()?> USD</td>
		  </tr>  
		</table>		
		<!-- Billing info order -->			
		</td>
	</tr>
</table></center>
<form method="post" id="form" name="form" >
<div style="text-align:center;">
			<?php 
				$printtxt = $CFG->wwwroot. '/printenrolstatement.php?confirmationno='.$confirmationno.'&traineeid='.$traineeID.'&country='.$country.'&orderid='.$orderid.'&total='.get_order_total().'&phone2='.$qst['phone2'].'&gender='.$gender; 
				$cifaworkspace=$CFG->wwwroot. '/index.php';
				$learncifacom=$CFG->wwwroot. '/index.php';
			?>
			<input type="hidden" name="printtxt" id="printtxt" value="<?=$printtxt;?>"/>			
			<input type="button" value=" Print this page " onClick="myPopup2()" name="printthispage" />
			<!--input type="submit" title="<?//=get_string('cifaworkspace');?>" onClick="this.form.action='<?//=$cifaworkspace;?>'" value="<?//=get_string('cifaworkspace');?>" name="cifaworkspace" /-->
			<input type="submit" title="<?=get_string('ipdonline');?>" onClick="this.form.action='<?=$learncifacom;?>'" value="<?=get_string('ipdonline');?>" name="<?=get_string('ipdonline');?>" />
</div></form><br/>
<?php 
	//}

	//session_unset(); session_destroy();
	unset($_SESSION['cart']);
	echo $OUTPUT->footer(); 
?>