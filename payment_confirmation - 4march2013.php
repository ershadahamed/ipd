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

	echo $OUTPUT->header();	
	
	$title = $_GET['title'];
	$firstname = $_GET['name'];
	$middlename = $_GET['middlename'];
	$lastname = $_GET['lastname'];
	$dob = $_GET['dob'];
	$address = $_GET['address'];
	$address2 = $_GET['address2'];
	$email = $_GET['email'];
	$phone = $_GET['phone'];
	$phone2 = $_GET['phone2'];
	$province = $_GET['state'];
	$postal = $_GET['postalcode'];
	$country = $_GET['country'];
	
	$co1=$_GET['co1'];
	$co2=$_GET['co2'];
	$co3=$_GET['co3'];		
	
	$paymethod=$_POST['radio'];	

	$name=$firstname.' '.$middlename.' '.$lastname;
	
	//untuk running number
	$statementorder=mysql_query("SELECT * FROM mdl_cifaorders ORDER BY serial DESC");
	$kiraorderid=mysql_fetch_array($statementorder);
	$countorder=mysql_num_rows($statementorder);
	
	$random=$kiraorderid['serial'] + 1;
	$year=date('mY');
	if($random > 0 && $random < 9){ $a='0000';}
	else if($random > 9 && $random < 99){ $a='000';}
	else if($random > 99 && $random < 999){ $a='00';}
	else{$a='0';}
	$confirmationno='SHAPE/'.$year.'/'.$a.''.$random.'';
	
	//candidates ID for new users
	$selectusers=mysql_query("SELECT * FROM mdl_cifauser WHERE deleted='0' AND confirmed='1' AND suspended='0' ORDER BY id DESC");
	$usercount=mysql_num_rows($selectusers);
	$userrec=mysql_fetch_array($selectusers);
	$tid=$userrec['id']+'1';
	$month=date('m');
	$year=date('y');
	
	if($userrec['id'] <= '9'){ 
		$c='00';
	}
	elseif($userrec['id'] >= '10' && $userrec['id'] <= '99'){ 
		$c='0';
	}else{
		$c='';
	}
	//final candidates ID generate// candidate start with A
	$candidatesI='A'.$year.''.$c.''.$tid.''.$country;	
	//$candidatesI='A'.$year.''.$month.''.$c.''.$tid.''.$country;
	$traineeID=$candidatesI;	
	
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
		
		//adding user to mdl_cifauser
		$sqlReg="INSERT INTO mdl_cifauser
				  SET username='".$username."', password='".$password."', firstname='".$firstname."', lastname='".$lastname."', 
					  email='".$email."', traineeid='".$traineeID."', dob='".$dob."', mnethostid='1', confirmed='0', descriptionformat='1',  
					  timecreated='".$timecreated."', lasttimecreated='".$lastcreated."', usertype='".$usertype."', phone1='". $phone."', phone2='". $phone2."', address='".$addressUser."', country='".$country."', city='".$province."'";
		$sqlRegQ=mysql_query($sqlReg) or die("sql gagal<br/>" .mysql_error());		
		$usercandidateid=mysql_insert_id();
		
		//force change password
		if($sqlRegQ){
			$forcechangepwd=mysql_query("INSERT INTO mdl_cifauser_preferences SET userid='".$usercandidateid."', name='auth_forcepasswordchange', value='1'");
		}
		
		//adding user to purchase info
		$result=mysql_query("insert into mdl_cifacandidates values('','','$traineeID','0','$title','$name','$dob','$email','$addressUser','$postal','$province','$country','$phone')");
		$customerid=mysql_insert_id();
		$date=strtotime('now');
		
		if(is_array($_SESSION['cart'])){		
			//communication references accepted
			$check_cr=mysql_query("SELECT * FROM mdl_cifacommunication_reference WHERE candidateid='".$USER->id."'");
			$count_cr=mysql_num_rows($check_cr);
			if($count_cr != '0'){
				//if ade, update communication references 
				$update_cr=mysql_query("UPDATE mdl_cifacommunication_reference SET serial='".$customerid."', rules1='".$co1."', rules2='".$co2."', rules3='".$co3."', timeaccepted='".$date."' WHERE traineeid='".$traineeID."'");
			}else{
				//if xde, insert communication references 
				$communication=mysql_query("INSERT INTO mdl_cifacommunication_reference
										SET serial='".$customerid."', traineeid='".$traineeID."', candidateid='0', rules1='".$co1."', rules2='".$co2."', rules3='".$co3."', timeaccepted='".$date."'");		
			}		
			//adding orders
			$result=mysql_query("insert into mdl_cifaorders values('','$confirmationno','$paymethod','pending','$date','$customerid')");
			$orderid=mysql_insert_id();
		}
	
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['productid'];
			$q=$_SESSION['cart'][$i]['qty'];
			$price=get_price($pid);
			//adding order details
			mysql_query("insert into mdl_cifaorder_detail values ($orderid,$pid,$q,$price)");
		}
		
		//to get program id;
		$pro1=mysql_query("SELECT productid FROM mdl_cifaorder_detail ORDER BY orderid DESC");
		$ord1=mysql_fetch_array($pro1);
		$prodid=$ord1['productid'];
		
		//select user 4 program IPD@CIFA
		$userquery=mysql_query("SELECT id, firstname, lastname FROM mdl_cifauser WHERE traineeid='".$traineeID."'");
		$userow=mysql_fetch_array($userquery);
		
		//select program
		$usecategory=mysql_query("SELECT b.id, b.name FROM mdl_cifacourse a, mdl_cifacourse_categories b  WHERE b.id=a.category AND a.category='1' AND a.id='".$prodid."'");
		$progrow=mysql_fetch_array($usecategory);
		$programname=ucwords(strtolower($progrow['name']));
		//insert user program IPD@CIFA
		$userprogram=mysql_query("INSERT INTO mdl_cifauser_program SET userid='".$userow['id']."', programid='".$progrow['id']."', programname='".$programname."'");	
		
		
		
}

	//candidates ID for new users
	$selectusers=mysql_query("SELECT * FROM mdl_cifauser WHERE deleted='0' AND confirmed='1' AND suspended='0' ORDER BY id DESC");
	$usercount=mysql_num_rows($selectusers);
	$userrec=mysql_fetch_array($selectusers);
	$tid=$userrec['id']+'1';
	$month=date('m');
	$year=date('mY');
	
	if($userrec['id'] <= '9'){ 
		$c='00';
	}
	elseif($userrec['id'] >= '10' && $userrec['id'] <= '99'){ 
		$c='0';
	}else{
		$c='';
	}
	//final candidates ID generate// candidate start with A
	$invoiceno='SHAPE/'.$year.'/'.$c.''.$tid.'';
		
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
<center>
<table width="80%" style="bgcolor:#FFFFFF;" border="0" style="margin: 0px auto;">
    <tr>
		<td>
		<?=get_string('emailenrolmentmsj');?>
		</td>           
    </tr> 
</table>
<table id="availablecourse3"  width="80%" style="bgcolor:#FFFFFF;" border="0" style="margin: 0px auto;">
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
<table width="80%" border="0" style="margin: 0px auto;">  
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
		<table id="availablecourse3" style="bgcolor:#FFFFFF;" width="100%" border="0">
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
					<tr valign="top">
						<td><strong><?=get_string('contactno');?></strong></td>
						<td width="1%"><strong>:</strong></td>
						<td><?=get_string('mobiletel');?>: &nbsp;<?='+'.$qst['phone1'];?><br/>
						<?php if($phone2!=''){ ?>
						<?=get_string('officetel');?>: &nbsp;<?='+'.$qst['phone2'];?><?php } ?></td>
					</tr>
					<tr style="vertical-align:top;">
						<td><strong><?=get_string('address');?></strong></td>
						<td width="1%"><strong>:</strong></td>
						<?php if(($qst['postal']!='') || ($qst['province']!='')){ ?>
						<td><?=$qst['address'].', '.$qst['postal'].' '.$qst['province'].', '.$qco['countryname'];?></td></tr>
						<?php }else{ ?>
						<td><?=$qst['address'].', '.$qco['countryname'];?></td></tr>
						<?php } ?>
				</table>			
			</td>
			<td colspan="3">
				<table id="candidatedetails" >
					<tr valign="top">
						<td width="30%"><strong>Confirmation no.</strong></td><td width="1%"><strong>:</strong></td><td><?=$invoiceno;?></td>
					</tr>
				</table>			
			</td>			
		  </tr>
		  
		  <!--tr bgcolor="#FFFFFF">
			<td colspan="4">
			<?php
				//echo '<br/><strong>Candidate ID: </strong>'.$ord1['traineeid'].'<br/>';	
				//echo $ord1['name'].'<br/>'.$ord1['email'].'<br/><br/>';			
			?>
			</td>
		  </tr-->
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
<div style="text-align:center;">
			<?php $printtxt = $CFG->wwwroot. '/printenrolstatement.php?confirmationno='.$confirmationno.'&traineeid='.$traineeID.'&country='.$country.'&orderid='.$orderid.'&total='.get_order_total().'&phone2='.$qst['phone2']; ?>
			<input type="hidden" name="printtxt" id="printtxt" value="<?=$printtxt;?>"/>			
			<input type="button" value=" Print this page " onClick="myPopup2()" name="printthispage" />
</div><br/>
<?php 
	}

		//session_unset(); session_destroy();
		unset($_SESSION['cart']);
	echo $OUTPUT->footer(); 
?>