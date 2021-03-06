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
	$pay_method=$_GET['paymethod'];
	
	$userfullname=$firstname.' '.$lastname; 
	$useraddress=$address.', '.$address2;	
	
	$today = strtotime('today');			
?>	
	<!--fieldset id="fieldset"><legend id="legend">Please pay to Alinmaa Education Co W.L.L at Boubyan Bank</legend-->
	<!--table id="availablecourse3" style="bgcolor:#FFFFFF;" border="0" style="margin: 0px auto;">
		<tr style="background-color:#5a84b5;"><td colspan="3"><h3>Please pay to Alinmaa Education Co W.L.L at Boubyan Bank</h3></td></tr>	
		<tr><td width="20%">Branch</td><td width="1%"><strong>:</strong></td><td>Sharq Branch</td></tr>
		<tr><td>Account Title/Beneficiary</td><td><strong>:</strong></td><td>Alinmaa Education Co W.L.L </td></tr>
		<tr><td>SWIFT Code</td><td><strong>:</strong></td><td>KWKWBBYN</td></tr>
		<tr><td>IBAN  #	</td><td><strong>:</strong></td><td>KW12 BBYN 0000 0000 0000 0149 0840 01 </td></tr>
		<tr><td>Account Number</td><td><strong>:</strong></td><td>0149084001</td></tr>	
		<tr><td>Reference</td><td><strong>:</strong></td><td>SHAPE Financial Corporation</td></tr>
		<tr><td colspan="3">You will be liable for the additional charges incurred in the wire transfer.</td></tr>
		<tr style="background-color:#d6dee7;"><td colspan="3">&nbsp;</td></tr>	
	</table-->
	<!--/fieldset-->	
<?php			
	include("../../includes/functions.php");
	
	$currentusername=$USER->firstname.' '.$USER->lastname;	
	$result=mysql_query("
		INSERT INTO 
			mdl_cifacandidates 
		SET 
			candidateid='".$USER->id."', traineeid='".$USER->traineeid."', name='".$currentusername."', dob='".$USER->dob."', email='".$USER->email."', address='".$USER->address."', province='".$USER->city."', country='".$USER->country."', phone='".$USER->phone1."'
	");
	$customerid=mysql_insert_id();
	$date=strtotime('now');
	$result=mysql_query("insert into mdl_cifaorders values('','$date','".$customerid."')");
	$orderid=mysql_insert_id();
	
	$max=count($_SESSION['cart']);
	for($i=0;$i<$max;$i++){
		$pid=$_SESSION['cart'][$i]['productid'];
		$q=$_SESSION['cart'][$i]['qty'];
		$price=get_price($pid);
		mysql_query("insert into mdl_cifaorder_detail values ($orderid,$pid,$q,$price)");
	}	

	//enrol old user to mdl_cifauser_enrolments
	$selectgetuser=mysql_query("
		Select
		  b.customerid,
		  a.candidateid,
		  a.traineeid,
		  a.name,
		  a.email,
		  b.date,
		  c.productid,
		  c.price
		From
		  mdl_cifacandidates a Inner Join
		  mdl_cifaorders b On a.serial = b.customerid Inner Join
		  mdl_cifaorder_detail c On b.serial = c.orderid
		Where
		  a.candidateid = '".$USER->id."'
	");
	while($sgetuser=mysql_fetch_array($selectgetuser)){
		$getcourseid=$sgetuser['productid'];
		
		//echo 'manual enrol users. <br/>'.$getcourseid.'<br/>';
		
		$senroluser=mysql_query("Select * From mdl_cifaenrol Where enrol = 'manual' And courseid='".$getcourseid."' And status='0'");
		$qenroluser=mysql_fetch_array($senroluser);
		$getenrolid=$qenroluser['id'];
		$gotuser=$sgetuser['candidateid'];
		
		//echo $getenrolid.'****** '.$gotuser.'<br/>';
		
		//to check if user never enrol for this course
		$scuser=mysql_query("SELECT * FROM mdl_cifauser_enrolments WHERE enrolid='".$getenrolid."' AND userid='".$gotuser."'");
		$ucount=mysql_num_rows($scuser);
		
		//echo $ucount.'<br/>';
		/*if($ucount=='0'){
			$today = strtotime('now');
			$sqlInsert=mysql_query("INSERT INTO mdl_cifauser_enrolments 
									SET enrolid='".$getenrolid."', userid='".$gotuser."',
									timecreated='".$today."', timemodified='".$today."',
									modifierid='2', emailsent='1', timestart='".$timestart."', timeend='".$timeend."'");

			//to define contextid
			$sL=mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='".$getcourseid."'");
			$L=mysql_fetch_array($sL);
			$contextid=$L['id'];
			
			$sqlassign=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='5', contextid='".$contextid."', userid='".$gotuser."', modifierid='2', timemodified='".$today."'");								
		}*/
	}
	//end enrol users
	//***************************************************************************************************************************//
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
<!--table width="100%" border="0" style="margin: 0px auto;"-->
<center>
<table id="availablecourse3" width="80%" style="bgcolor:#FFFFFF;" border="0" style="margin: 0px auto;">
    <tr>
		<td>
		<?php echo "Thank You! your order has been placed!<br/> Email confirmation will automatically send in 24 hours."; ?>
		</td>           
    </tr>  
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
			<td colspan="4"><h3>Confirmation Statement</h3></td>
		  </tr>	
		  <tr bgcolor="#d6dee7">
			<td colspan="4"><strong>Candidate Information</strong></td>
		  </tr>	

		  <tr style="background-color:#fff; border-color:#cccccc;" valign="top">
			<td>
				<table id="candidatedetails" style="width:100%">
					<tr>
						<td width="25%"><strong>Candidate ID</strong></td><td width="1%"><strong>:</strong></td><td><?=$ord1['traineeid'];?></td>
					</tr>
					<tr><td colspan="3"><?=$ord1['name'];?></td></tr>
					<tr><td colspan="3"><?=$ord1['email'];?></td></tr>
				</table>			
			</td>
			<td colspan="3">
				<table id="candidatedetails" >
					<tr valign="top">
						<td width="25%"><strong>Confirmation no.</strong></td><td width="1%"><strong>:</strong></td><td><?=$invoiceno;?></td>
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
<!--div id="divButtons" style="text-align:center;">&nbsp;<input type="button" value = " Print this page " onclick="printPage()"></div-->
<div style="text-align:center;">
			<?php $printtxt = $CFG->wwwroot. '/printenrolstatement.php?orderid='.$orderid.'&total='.get_order_total(); ?>
			<input type="hidden" name="printtxt" id="printtxt" value="<?=$printtxt;?>"/>			
			<!--input type="button" name="Cetak" onClick="myPopup2()" value="" /-->
			<input type="button" value=" Print this page " onClick="myPopup2()" name="printthispage" />
</div>	
	
<?php	
	unset($_SESSION['cart']);
?>
<?php 	echo $OUTPUT->footer();	?>