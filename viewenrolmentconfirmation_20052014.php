<!--body onLoad="javascript:window.print()"-->
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

	$country = $USER->country;
	$traineeID=$USER->traineeid;
	
	$orderid = $_GET['orderid'];	
?>
<script language="javascript">
var isNS = (navigator.appName == "Netscape") ? 1 : 0;
  if(navigator.appName == "Netscape")
     document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);
  function mischandler(){
   return false;
 }
  function mousehandler(e){
     var myevent = (isNS) ? e : event;
     var eventbutton = (isNS) ? myevent.which : myevent.button;
    if((eventbutton==2)||(eventbutton==3)) return false;
 }
 document.oncontextmenu = mischandler;
 document.onmousedown = mousehandler;
 document.onmouseup = mousehandler;
function killCopy(e){
    return false
}
function reEnable(){
    return true
}
document.onselectstart = new Function ("return false")
if (window.sidebar){
    document.onmousedown=killCopy
    document.onclick=reEnable
}
</script>
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
//var printtxt = document.getElementById('printtxt').value;
//window.open(printtxt);
window.print();
}
</script>
<style type="text/css">
@media print {
input#btnPrint {
display: none;
}
}

input[type="button"]{
	border:		2px solid #00C5FB;
	padding:		5px 10px !important;
	margin-bottom: 2px;
	font-size:		12px !important;
	background-color:	#5DCBEB;
	font-weight:		bold;
	color:			#ffffff;
	border-radius:5px;
}
<?php 
	include('css/style2.css'); 	
?>



#availablecourse4{
font-family: Arial,Verdana,Helvetica,sans-serif;font-size: 13px; margin: 0px auto; 
}
#availablecourse4 tr, td .classtr{
	border-color:#cccccc; padding-left:5px;
}
#availablecourse4 tr .classtitle{
	border-color:#cccccc;
	background-color:#d6dee7; padding-left:5px;
}
#candidatedetails{
	font-family: Arial,Verdana,Helvetica,sans-serif;font-size: 13px;
	border-collapse: collapse; border-spacing: 0; border-color:#cccccc; margin: 10px 0px 10px 0px; padding-left:5px;
	width:100%;
}

#candidatedetails td, tr{ padding:5px 10px; }

h3{
margin: 1em 0;
}
</style>
<table id="availablecourse4"  width="98%" style="bgcolor:#FFFFFF;" border="0" style="margin: 0px auto;">
    <tr>
		<td>
		<?=get_string('emailenrolmentmsj');?>
		</td>           
    </tr> 
</table>
<table  width="98%" border="1" id="availablecourse4" style="bgcolor:#FFFFFF; border-collapse: collapse; border-spacing: 0; border-color:#cccccc;margin: 0px auto;">
	<tr style="background-color:#5DCBEB;"><td colspan="3" style="padding-left:10px;"><h3>Please pay to SHAPE for Economic Consulting W.L.L  at Boubyan Bank</h3></td></tr>	
	<tr><td width="20%">
	<table id="candidatedetails" style="width:100%;padding:0px;">
	<tr><td width="20%">Branch</td><td width="1%"><strong>:</strong></td><td>Sharq Branch</td></tr>
	<tr><td>Account Title/Beneficiary</td><td><strong>:</strong></td><td>SHAPE for Economic Consulting W.L.L</td></tr>
	<tr><td>SWIFT Code</td><td><strong>:</strong></td><td>BBYNKWKW</td></tr>
	<tr><td>IBAN  #	</td><td><strong>:</strong></td><td>KW62 BBYN 0000 0000 0000 0203 3190 02 </td></tr>
	<tr><td>Account Number</td><td><strong>:</strong></td><td>0203319002</td></tr>	
	<tr><td>Reference</td><td><strong>:</strong></td><td><?=$traineeID;?></td></tr>
	<tr><td colspan="3">You will be liable for the additional charges incurred in the bank transfer.</td></tr>
	<tr><td colspan="3"><?php 
		$a = new stdClass(); 
		$a='contact@learncifa.com'; 
		echo get_string('textpayment', '', $a);
		?>
		<?//=get_string('textpayment', '', $a);?>
	</td></tr>    
    </table>
	</td></tr>
	<tr style="background-color:#d6dee7;"><td colspan="3">&nbsp;</td></tr>	
</table><br/>
<table width="98%" id="availablecourse4" style="margin: 0px auto;  border-collapse: collapse; border-spacing: 0;">
    <tr>
		<td colspan="2">&nbsp;</td>           
    </tr>  
	<tr>
		<td colspan="2">
		<?php
			$pro1=mysql_query("
				Select
				  b.customerid,
				  b.confirmationno,
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
				Where a.traineeid='".$traineeID."'
			");
			
			$ord1=mysql_fetch_array($pro1);
			$prodid=$ord1['confirmationno'];
			$pro2=mysql_query("SELECT productid, quantity, price FROM mdl_cifaorder_detail WHERE orderid='".$orderid."' ORDER BY orderid DESC");
		?>
		<table id="availablecourse4" style="bgcolor:#FFFFFF; border-collapse: collapse; border-spacing: 0; border-color:#cccccc;" width="100%" border="1">
		  <tr style="background-color:#5DCBEB; border-color:#cccccc;">
			<td colspan="4" class="classtr"><h3><?=get_string('orderconfirmationtitle');?></h3></td>
		  </tr>	
		  <tr>
			<td colspan="4" class="classtitle"><strong>Candidate Information</strong></td>
		  </tr>			  
		  <tr style="background-color:#fff; border-color:#cccccc;" valign="top">
			<td class="classtr">
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
						<td><?=get_string('mobiletel');?>: &nbsp;<?='+'.$qco['iso_countrycode'].'-'.$qst['phone1'];?><br/>
						<?php if($phone2!=''){ ?>
						<?=get_string('officetel');?>: &nbsp;<?='+'.$qco['iso_countrycode'].'-'.$qst['phone2'];?><?php } ?></td>
					</tr>
					<tr style="vertical-align:top;">
						<td><strong><?=get_string('address');?></strong></td>
						<?php if (($qst['postal']!='') || ($qst['province'] !='')){ ?>
						<td width="1%"><strong>:</strong></td><td><?=$qst['address'].', '.$qst['postal'].' '.$qst['province'].', '.$qco['countryname'];?></td></tr>
						<?php }else{ ?>
						<td width="1%"><strong>:</strong></td><td><?=$qst['address'].','.$qco['countryname'];?></td></tr>
						<?php } ?>
				</table>			
			</td>
			<td colspan="3" class="classtr">
				<table id="candidatedetails">
					<tr valign="top">
						<td width="35%"><strong><?=get_string('confirmationno');?></strong></td><td width="1%"><strong>:</strong></td><td><?=$prodid;?></td>
					</tr>
				</table>			
			</td>			
		  </tr>
		  <tr>
			<td class="classtitle" colspan="4"><strong>Transaction details</strong></td>
		  </tr>
		  <tr bgcolor="#efeff7">
			<td class="classtr"><strong>Description</strong></td>
			<td class="classtr"><strong>Unit price</strong></td>
			<td class="classtr" align="center" width="5%"><strong>Qty</strong></td>
			<td class="classtr" width="20%"><strong>Amount</strong></td>
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
			<td class="classtr">
			<?php
					$prodid2=$ord2['productid'];
					$seprod=mysql_query("
						Select fullname From mdl_cifacourse Where id='".$prodid2."'
					");
					$quprod=mysql_fetch_array($seprod);
					echo $quprod['fullname'].'<br/>';
			?>
			</td>
			<td class="classtr">$ <?=$ord2['price'];?> USD</td>
			<td class="classtr" align="center"><?=$ord2['quantity'];?></td>
			<td class="classtr">$ <?=$ord2['price'];?> USD</td>
		  </tr>
			<?php 
				} 
				$q1final_result=$q1sum;
			?>
		  <tr bgcolor="#efeff7" >
			<td class="classtr">&nbsp;</td>
			<td class="classtr">&nbsp;</td>
			<td class="classtr" align="center"><strong>Total</strong></td>
			<td class="classtr">$ <?php echo $q1final_result;?> USD</td>
		  </tr>  
		</table>		
		<!-- Billing info order -->			
		</td>
	</tr>	
</table>
<br/>
<div style="text-align:center;">
			<?php $printtxt = $CFG->wwwroot. "/viewenrolmentconfirmation.php?orderid=".$orderid; ?>
			<input type="hidden" name="printtxt" id="printtxt" value="<?=$printtxt;?>"/>			
			<!--input type="button" value=" Print this page " onClick="myPopup2()" name="printthispage" /-->
			<input type="button" id="btnPrint" onclick="window.print();" value="Print Page" />
</div><br/>