<body onLoad="javascript:window.print()">
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

	//echo $OUTPUT->header();	
	
	/*$title = $_GET['title'];
	$firstname = $_GET['name'];
	$middlename = $_GET['middlename'];
	$lastname = $_GET['lastname'];
	$dob = $_GET['dob'];
	$address = $_GET['address'];
	$address2 = $_GET['address2'];
	$email = $_GET['email'];
	$phone = $_GET['phone'];
	$province = $_GET['state'];
	$postal = $_GET['postalcode'];*/
	$country = $_GET['country'];
	$traineeID=$_GET['traineeid'];
	$phone2=$_GET['phone2'];
	
	$orderid = $_GET['orderid'];
	$confirmationno=$_GET['confirmationno'];
	$gettotal=$_GET['total'];

	//candidates ID for new users
	/*$selectusers=mysql_query("SELECT * FROM mdl_cifauser WHERE deleted='0' AND confirmed='1' AND suspended='0' ORDER BY id DESC");
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
	$invoiceno='SHAPE/'.$year.'/'.$c.''.$tid.'';*/	
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
<style media="screen">
<?php 
	include('css/style2.css'); 	
?>
h3{ color:#ffffff;}
#availablecourse4{
font-family: Arial,Verdana,Helvetica,sans-serif;font-size: 13px; 
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
}
h3{
margin: 1em 0;
}
</style>
<table width="95%" id="availablecourse4" style="margin: 0px auto;  border-collapse: collapse; border-spacing: 0;">
    <tr>
		<td colspan="2">&nbsp;</td>           
    </tr>  
	<tr>
		<td colspan="2">

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
<?php
	$acinfo=mysql_query("SELECT * FROM {$CFG->prefix}account_info");
	$aci=mysql_fetch_array($acinfo);
?>		
	<table id="availablecourse"  border="1" width="100%" style="bgcolor:#FFFFFF; border-collapse: collapse; border-spacing: 0; border-color:#cccccc;margin: 0px auto;">
		<tr style="background-color:#21409A;"><td colspan="3">
        <div style="position: relative;">
            <img src="image/btp_g.png" style="width:100%; height:3.5em; border: 0; padding: 0" />
            <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
            <span style="position: absolute; top: 10%; margin-top: -0.6em; margin-left: 0.5em;"><h3><?=$aci['headtitle'];?></h3></span>
        </div> 		
		</td></tr>	
		<tr><td width="20%">Branch</td><td width="1%"><strong>:</strong></td><td><?=$aci['branch'];?></td></tr>
		<tr><td>Account Title/Beneficiary</td><td><strong>:</strong></td><td><?=$aci['account_title'];?></td></tr>
		<tr><td>SWIFT Code</td><td><strong>:</strong></td><td><?=$aci['swiftcode'];?></td></tr>
		<tr><td>IBAN  #	</td><td><strong>:</strong></td><td><?=$aci['iban'];?></td></tr>
		<tr><td>Account Number</td><td><strong>:</strong></td><td><?=$aci['accountnumber'];?></td></tr>	
		<tr><td>Reference</td><td><strong>:</strong></td><td><?=$traineeID;?></td></tr>
		<tr><td colspan="3"><?=$aci['textline1'];?></td></tr>
		<tr><td colspan="3"><?=$aci['textline2'];?></td></tr>
		<tr style="background-color:#d6dee7;"><td colspan="3">
            <div style="position: relative;">
                <img src="image/btp_c1.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 20%; margin-top: -0.6em; margin-left: 0.5em;">&nbsp;</span>
            </div> 		
		</td></tr>	
	</table><br/>		
		
		<table id="availablecourse4" style="bgcolor:#FFFFFF; border-collapse: collapse; border-spacing: 0; border-color:#cccccc;" width="100%" border="1">
		  <tr style="background-color:#21409A; border-color:#cccccc;">
			<td colspan="4" class="classtr" style="padding-left:0px;">
				<div style="position: relative;">
					<img src="image/btp_g.png" style="width:100%; height:3.5em; border: 0; padding: 0" />
					<!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
					<span style="position: absolute; top: 10%; margin-top: -0.6em; margin-left: 0.5em;"><h3>Confirmation Statement</h3></span>
				</div> 			
			</td>
		  </tr>	
		  <tr>
			<td colspan="4" class="classtitle">
            <div style="position: relative;">
                <img src="image/btp_c1.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><strong>Candidate Information</strong></span>
            </div>  			
			</td>
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
					<tr valign="top"><td><strong><?=get_string('name');?></strong></td><td width="1%"><strong>:</strong></td><td><?=$qst['firstname'].' '.$qst['middlename'].' '.$qst['lastname'];?></td></tr>
					<tr valign="top"><td><strong><?=get_string('email1');?></strong></td><td width="1%"><strong>:</strong></td><td><?=$qst['email'];?></td></tr>
					<tr valign="top">
						<td><strong><?=get_string('contactno');?></strong></td>
						<td width="1%"><strong>:</strong></td>
						<?php if($qst['phone1']!=''){ ?>
						<td>+<?=$qco['iso_countrycode'].$qst['phone1'];?><br/></td>
						<?php }else{ ?>
						<td>+<?=$qco['iso_countrycode'].$_GET['phone'];?><br/></td>
						<?php } ?>
					</tr>
					<tr style="vertical-align:top;">
						<td><strong><?=get_string('address');?></strong></td>
						<td width="1%"><strong>:</strong></td>
						<?php if(($qst['postal']!='') || ($qst['province']!='')){ ?>
						<td><?=$qst['address'].', '.$qst['postal'].' '.$qst['province'].', '.$qco['countryname'];?></td>
					</tr>
						<?php }else{ ?>
						<td><?=$qst['address'].' '.$qst['address2'].' '.$qst['address3'].', <br/>'.$qst['poscode'].' '.$qst['state'].', '.$qco['countryname'];?></td></tr>
						<?php } ?>					
				</table>			
			</td>
			<td colspan="3" class="classtr">
				<table id="candidatedetails" style="width:100%;">
					<tr valign="top">
						<td width="30%"><strong>Confirmation no.</strong></td><td width="1%"><strong>:</strong></td><td><?=$confirmationno;?></td>
					</tr>
				</table>			
			</td>			
		  </tr>
		  <tr>
			<td class="classtitle" colspan="4" style="padding-left:0px;">
            <div style="position: relative;">
                <img src="image/btp_c1.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><strong>Transaction details</strong></span>
            </div> 
            </td>
		  </tr>
		  <tr bgcolor="#efeff7">
			<td class="classtr" style="padding-left:0px;">
            <div style="position: relative;">
                <img src="image/btp_c2.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><strong>Description</strong></span>
            </div>                        
            </td>
			<td class="classtr" style="padding-left:0px;">
            <div style="position: relative;">
                <img src="image/btp_c2.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><strong>Unit price</strong></span>
            </div>            
            </td>
			<td class="classtr" style="padding-left:0px;" width="13%">
            <div style="position: relative;">
                <img src="image/btp_c2.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><strong>Qty</strong></span>
            </div></td>
			<td class="classtr" style="padding-left:0px;" width="15%">
			<div style="position: relative;">
                <img src="image/btp_c2.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><strong>Amount</strong></span>
            </div></td>
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
									
					// resit ID
					$cfinaltestsql=mysql_query("
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
						  e.userid='".$USER->id."'	And b.course='".$prodid2."' And	c.id='".$_GET['resitid']."'
					");
					$finalarray=mysql_fetch_array($cfinaltestsql); 
					$finalexamid=$finalarray['cifaquizid'];	
					$examname=$finalarray['name'].' - ('.get_string('resitexam').')';						
					if($_GET['extendid']=='4'){
						echo $examname;
					}else{
						echo $quprod['fullname'].'&nbsp;';
					}
					
					if($_GET['extendid']=='3'){
						echo get_string('extension');
					}					
				//}
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
			<td class="classtr" style="padding-left:0px;">
            <div style="position: relative;">
                <img src="image/btp_c2.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">&nbsp;</span>
            </div>             
            </td>
			<td class="classtr"  style="padding-left:0px;">
            <div style="position: relative;">
                <img src="image/btp_c2.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">&nbsp;</span>
            </div>            
            </td>
			<td class="classtr" style="padding-left:0px;">
            <div style="position: relative;">
                <img src="image/btp_c2.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><strong>Total</strong></span>
            </div>            
            </td>
			<td class="classtr" style="padding-left:0px;">
            <div style="position: relative;">
                <img src="image/btp_c2.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;">$ <?php echo $q1final_result;?> USD</span>
            </div>             
            </td>
		  </tr>   
		</table>		
		<!-- Billing info order -->			
		</td>
	</tr>	
  <tr>
    <td align="left"><?=get_string('printnote');?></td>
	<td align="right" width="30%"><?='Print on: '.date('d/m/Y');?></td>
  </tr>	
</table>
<br/>
<!--div id="divButtons" style="text-align:center;">&nbsp;<input type="button" value = " Print now " onclick="printPage()"></div-->