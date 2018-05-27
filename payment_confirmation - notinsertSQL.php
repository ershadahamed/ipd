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
	$province = $_GET['state'];
	$postal = $_GET['postalcode'];
	$country = $_GET['country'];
	
	$paymethod=$_POST['radio'];	

	$name=$firstname.' '.$middlename.' '.$lastname;
	
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
	$traineeID=$candidatesI;	
	
?>
<?
 if (isloggedin()) {
	header("location:index.php");
 }else{
		if(is_array($_SESSION['cart'])){

		$username=strtolower($traineeID);
		$pword_text='Password01$';
		$password=md5($pword_text);
		$timecreated = strtotime('now');
		$lastcreated = strtotime("now" . " + 1 year");
		$addressUser=$address.' '.$address1;
	   
		$srole=mysql_query("SELECT name FROM mdl_cifarole WHERE id='5'");
		$rwrole=mysql_fetch_array($srole);
		$usertype=$rwrole['name'];	   
		
		//adding user to mdl_cifauser
		/*$sqlReg="INSERT INTO mdl_cifauser
				  SET username='".$username."', password='".$password."', firstname='".$firstname."', lastname='".$lastname."', 
					  email='".$email."', traineeid='".$traineeID."', dob='".$dob."', mnethostid='1', confirmed='0', descriptionformat='1',  
					  timecreated='".$timecreated."', lasttimecreated='".$lastcreated."', usertype='".$usertype."', phone1='". $phone."', address='".$addressUser."', country='".$country."', city='".$province."'";
		$sqlRegQ=mysql_query($sqlReg) or die("sql gagal<br/>" .mysql_error());		
		$usercandidateid=mysql_insert_id();
		
		//force change password
		if($sqlRegQ){
			$forcechangepwd=mysql_query("INSERT INTO mdl_cifauser_preferences SET userid='".$usercandidateid."', name='auth_forcepasswordchange', value='1'");
		}*/
		
		//adding user to purchase info
		$result=mysql_query("insert into mdl_cifacandidates values('','','$traineeID','0','$title','$name','$dob','$email','$addressUser','$postal','$province','$country','$phone')");
		$customerid=mysql_insert_id();
		$date=strtotime('now');
		
		//adding orders
		$result=mysql_query("insert into mdl_cifaorders values('','$paymethod','new','$date','$customerid')");
		$orderid=mysql_insert_id();
		
	
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['productid'];
			$q=$_SESSION['cart'][$i]['qty'];
			$price=get_price($pid);
			//adding order details
			mysql_query("insert into mdl_cifaorder_detail values ($orderid,$pid,$q,$price)");
		}
		
		/*//to get program id;
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
		*/
		
		
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
<table width="80%" border="0" style="margin: 0px auto;">
    <tr>
		<td>
		<?php echo "Thank You! your order has been placed!<br/> Email confirmation will automatically send in 24 hours."; ?>
		<?php //session_unset(); session_destroy();?>
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
</table>
<!--div id="divButtons" style="text-align:center;">&nbsp;<input type="button" value = " Print this page " onclick="printPage()"></div-->
<div style="text-align:center;">
			<?php $printtxt = $CFG->wwwroot. '/printenrolstatement.php?orderid='.$orderid.'&total='.get_order_total(); ?>
			<input type="hidden" name="printtxt" id="printtxt" value="<?=$printtxt;?>"/>			
			<!--input type="button" name="Cetak" onClick="myPopup2()" value="" /-->
			<input type="button" value=" Print this page " onClick="myPopup2()" name="printthispage" />
</div>
<?php 
	}

		//session_unset(); session_destroy();
		unset($_SESSION['cart']);
	echo $OUTPUT->footer(); 
?>