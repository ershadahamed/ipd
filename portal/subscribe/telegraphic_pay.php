<?php
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../../manualdbconfig.php'); 

	$site = get_site();
	
	$purchase='Purchase modules';
	$title="$SITE->shortname: Courses - ".$purchase;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);

	echo $OUTPUT->header();	
	$traineeID = $_GET['traineeID'];
	
	$firstname = $_GET['trainee_name'];
	$lastname = $_GET['lastname'];
	$address = $_GET['address'];
	$address2 = $_GET['address2'];
	$email = $_GET['email'];
	$phone = $_GET['phone'];
	$phone2 = $_GET['phone2'];
	$province = $_GET['province'];
	$city = $_GET['city'];
	$postal = $_GET['postal'];
	$country = $_GET['country'];
	
	$coursename = $_GET['coursename'];
	$shortname = $_GET['shortname'];
	$courseid = $_GET['courseid'];
	
	$cost = $_GET['cost'];
	$currency=$_GET['currency'];
	$PaypalBusinessEmail=$_GET['PaypalBusinessEmail']; 	
	$pay_method=$_POST['radio'];
	
	$userfullname=$firstname.' '.$lastname; 
	$useraddress=$address.', '.$address2;	
	
	$today = strtotime('today');	

	$co1=$_GET['co1'];
	$co2=$_GET['co2'];
	$co3=$_GET['co3'];
	$customerid=$_GET['customerid'];
	$orderid=$_GET['orderid'];

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
	$confirmationno='SHAPE/'.$year.'/'.$a.''.$random.'';


	$statement21=" mdl_cifacandidates a Inner Join mdl_cifaorders b On a.serial = b.customerid Inner Join mdl_cifaorder_detail c On b.serial = c.orderid";		
	$sqlcourse21="SELECT * FROM {$statement21} WHERE b.serial='".$orderid."'";
	$sqlcourse21.=" Group By b.date Order By b.date DESC, a.traineeid DESC";	
	$sqlquery21=mysql_query($sqlcourse21);
	$sqlrow21=mysql_fetch_array($sqlquery21);	
?>
<style>
<?php 
	include('../../css/style2.css'); 	
?>

#availablecourse4 tr, td .classtr{
	border-color:#cccccc; padding-left:5px;border-collapse: collapse; 
}
#availablecourse4 tr .classtitle{
	border-color:#cccccc;
	background-color:#d6dee7; padding-left:5px;
}
#candidatedetails{
	border-collapse: collapse; border-spacing: 0; margin: 10px 0px 10px 0px; padding-left:5px;
}
h3{
margin: 1em 0;
}
</style>	
<?php			
	include("../../includes/functions.php");
	$date=strtotime('now');
	$newstatus='new';
	$pendingstatus='pending';
	$corruptedstatus='corrupted';
	
	if(is_array($_SESSION['cart'])){
		$update_cr=mysql_query("UPDATE mdl_cifaorders SET confirmationno='".$confirmationno."', paymethod='".$pay_method."', paystatus='".$pendingstatus."', date='".$date."' WHERE serial='".$orderid."' AND paystatus='".$newstatus."' AND customerid='".$customerid."'");
	}
	
	else if(($USER->traineeid==$traineeID) && ($sqlrow21['orderid']==$orderid) && ($sqlrow21['paystatus']==$newstatus)){
		$update_cr=mysql_query("UPDATE mdl_cifaorders SET confirmationno='".$confirmationno."', paymethod='".$pay_method."', paystatus='".$pendingstatus."', date='".$date."' WHERE serial='".$orderid."' AND paystatus='".$newstatus."' AND customerid='".$customerid."'");
	}
	/*$currentusername=$USER->firstname.' '.$USER->lastname;	
	
	$semakpengguna_statement="SELECT * FROM mdl_cifacandidates WHERE candidateid='".$USER->id."' AND traineeid='".$USER->traineeid."'";
	$semakpengguna=mysql_query($semakpengguna_statement);
	$count_semak=mysql_num_rows($semakpengguna);
	if($count_semak != '0'){
		//kalu ade record
		$genQ=mysql_fetch_array($semakpengguna);
		$customerid= $genQ['serial'];	
	}else{
		//kalu xde record
		$result=mysql_query("
			INSERT INTO 
				mdl_cifacandidates 
			SET 
				candidateid='".$USER->id."', traineeid='".$USER->traineeid."', name='".$currentusername."', dob='".$USER->dob."', email='".$email."', address='".$useraddress."', province='".$USER->city."', country='".$country."', phone='".$phone."'
		");
		$customerid=mysql_insert_id();	
	}
	
	$date=strtotime('now');
	
	if(is_array($_SESSION['cart'])){
		//communication references accepted
		$check_cr=mysql_query("SELECT * FROM mdl_cifacommunication_reference WHERE candidateid='".$USER->id."'");
		$count_cr=mysql_num_rows($check_cr);
		if($count_cr != '0'){
			//if ade, update communication references 
			$update_cr=mysql_query("UPDATE mdl_cifacommunication_reference SET serial='".$customerid."', rules1='".$co1."', rules2='".$co2."', rules3='".$co3."', timeaccepted='".$date."' WHERE candidateid='".$USER->id."'");
		}else{
			//if xde, insert communication references 
			$communication=mysql_query("INSERT INTO mdl_cifacommunication_reference
									SET serial='".$customerid."', traineeid='".$USER->traineeid."', candidateid='".$USER->id."', rules1='".$co1."', rules2='".$co2."', rules3='".$co3."', timeaccepted='".$date."'");		
		}
	
		//insert orders item
		$result=mysql_query("insert into mdl_cifaorders values('','".$confirmationno."','".$pay_method."','new','".$date."','".$customerid."')");
		$orderid=mysql_insert_id();
	}
	
	$max=count($_SESSION['cart']);
	for($i=0;$i<$max;$i++){
		$pid=$_SESSION['cart'][$i]['productid'];
		$q=$_SESSION['cart'][$i]['qty'];
		$price=get_price($pid);
		mysql_query("insert into mdl_cifaorder_detail values ($orderid,$pid,$q,$price)");
	}*/	

	//***************************************************************************************************************************//
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
<!--table width="100%" border="0" style="margin: 0px auto;"-->

<table style="bgcolor:#FFFFFF; border: 0;">
    <tr>
		<td>
		<?=get_string('emailenrolmentmsj');?>
		</td>           
    </tr> 
</table>
<center>
<table id="availablecourse3"  style="bgcolor:#FFFFFF;" border="0" style="margin: 0px auto;">
	<tr style="background-color:#5a84b5;"><td colspan="3"><h3>Please pay to Alinmaa Education Co W.L.L at Boubyan Bank</h3></td></tr>	
	<tr><td width="20%">Branch</td><td width="1%"><strong>:</strong></td><td>Sharq Branch</td></tr>
	<tr><td>Account Title/Beneficiary</td><td><strong>:</strong></td><td>Alinmaa Education Co W.L.L </td></tr>
	<tr><td>SWIFT Code</td><td><strong>:</strong></td><td>KWKWBBYN</td></tr>
	<tr><td>IBAN  #	</td><td><strong>:</strong></td><td>KW12 BBYN 0000 0000 0000 0149 0840 01 </td></tr>
	<tr><td>Account Number</td><td><strong>:</strong></td><td>0149084001</td></tr>	
	<tr><td>Reference</td><td><strong>:</strong></td><td>SHAPE Financial Corporation</td></tr>
	<tr><td colspan="3">You will be liable for the additional charges incurred in the wire transfer.</td></tr>
	<tr><td colspan="3"><?=get_string('textpayment');?></td></tr>
	<tr style="background-color:#d6dee7;"><td colspan="3">&nbsp;</td></tr>	
</table><br/>
<table style="width:100%;bgcolor:#FFFFFF;margin: 0px auto;" border="0"> 
	<tr>
		<td>

		<?php
			//to get program id;
			$pro1=mysql_query("
				Select
				  *
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
		<table id="availablecourse4" style="bgcolor:#FFFFFF;" width="100%" border="0">
		  <tr style="background-color:#5a84b5;">
			<td colspan="4"><h3><?=get_string('orderconfirmationtitle');?></h3></td>
		  </tr>	
		  <tr bgcolor="#d6dee7">
			<td colspan="4"><strong>Candidate Information</strong></td>
		  </tr>	

		  <tr style="background-color:#fff; border-color:#cccccc;" valign="top">
			<td width="50%">
				<?php
					$sqlst=mysql_query("SELECT * FROM mdl_cifauser WHERE traineeid='".$traineeID."'");
					$qst=mysql_fetch_array($sqlst);
					
					$sqlco=mysql_query("SELECT * FROM mdl_cifacountry_list WHERE countrycode='".$country."'");
					$qco=mysql_fetch_array($sqlco);
				?>
				<table id="candidatedetails" style="width:100%;padding:0px;">
					<tr valign="top">
						<td width="30%"><strong><?=get_string('candidateid');?></strong></td><td width="1%"><strong>:</strong></td><td><?=strtoupper($traineeID);?></td>
					</tr>
					<tr valign="top"><td><strong><?=get_string('name');?></strong></td><td width="1%"><strong>:</strong></td><td><?=$qst['firstname'].''.$qst['lastname'];?></td></tr>
					<tr valign="top"><td><strong><?=get_string('email1');?></strong></td><td width="1%"><strong>:</strong></td><td><?=$qst['email'];?></td></tr>
					<tr valign="top"><td><strong><?=get_string('contactno');?></strong></td><td width="1%"><strong>:</strong></td><td><?=get_string('mobiletel');?>: &nbsp;<?='+'.$qco['iso_countrycode'].'-'.$qst['phone1'];?><br/><?=get_string('officetel');?>: &nbsp;<?='+'.$qco['iso_countrycode'].'-'.$qst['phone2'];?></td></tr>
					<tr style="vertical-align:top;"><td><strong><?=get_string('address');?></strong></td><td width="1%"><strong>:</strong></td><td><?=$qst['address'].', '.$qst['postal'].' '.$qst['province'].' '.$qco['countryname'];?></td></tr>
				</table>			
			</td>
			<td colspan="3">
				<table id="candidatedetails" >
					<tr valign="top">
						<td width="30%"><strong>Confirmation no.</strong></td><td width="1%"><strong>:</strong></td><td><?=$confirmationno;?></td>
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
			$q1sum=0;
			$count=0;		  
			while($ord2=mysql_fetch_array($pro2)){
			$bil='0';
			$q1sum+=(float) ($ord2['price']);
			$count++;		  		  
		  ?>
		  <tr bgcolor="#FFFFFF">
			<td>
			<?php
				//while($ord2=mysql_fetch_array($pro2)){
					$prodid2=$ord2['productid'];
					//echo $prodid2.'<br/>';
					$seprod=mysql_query("
						Select fullname From mdl_cifacourse Where id='".$prodid2."'
					");
					$quprod=mysql_fetch_array($seprod);
					echo $quprod['fullname'].'<br/>';
				//}
			?>
			</td>
			<td>$ <?=$ord2['price'];?> USD</td>
			<td align="center"><?=$ord2['quantity'];?></td>
			<td>$ <?=$ord2['price'];?> USD</td>
		  </tr>
		  <?php 
				} 
				$q1final_result=$q1sum;
		  ?>
		  <tr bgcolor="#efeff7">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center"><strong>Total</strong></td>
			<td>$ <?php //echo get_order_total()?><?php echo $q1final_result;?> USD</td>
		  </tr>  
		</table>		
		<!-- Billing info order -->			
		</td>
	</tr>
</table></center>
<div style="text-align:center; margin-bottom:20px;">
			<?php $printtxt = $CFG->wwwroot. '/printenrolstatement.php?country='.$country.'&traineeid='.$traineeID.'&confirmationno='.$confirmationno.'&orderid='.$orderid.'&total='.get_order_total(); ?>
			<input type="hidden" name="printtxt" id="printtxt" value="<?=$printtxt;?>"/>			
			<input type="button" value=" Print this page " onClick="myPopup2()" name="printthispage" />
</div>	
	
<?php	unset($_SESSION['cart']); ?>
<?php 	echo $OUTPUT->footer();	?>