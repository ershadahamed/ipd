<?php
    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
    include('manualdbconfig.php'); 
    include("includes/functions.php");	
	include('function/emailfunction.php');       
        

	$site = get_site();
	
	$purchase='Purchase IPD modules';
	$titlehead="$SITE->shortname: SHAPE IPD - ".$purchase;
	$PAGE->set_title($titlehead);
	$PAGE->set_heading($site->fullname);

	$buyipd=get_string('buyacifa');
	$selectprogram='Select Program';
	$your_details='Your Details';
	$pay_details='Payment Method';
	$PAGE->navbar->add($buyipd)->add($selectprogram)->add($your_details)->add($pay_details);	

	echo $OUTPUT->header();	
	/**POST*/
	$title = $_POST['title'];
	
	$firstname = $_POST['name'];
	$middlename=$_POST['middlename'];
	$lastname = $_POST['lastname'];
	$address = $_POST['address'];
	$address2 = $_POST['address2'];
	$address3 = $_POST['address3'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$phone2 = $_POST['phone2'];
	$province = $_POST['state_code'];
	$postal = $_POST['postalcode'];
	$country = $_POST['country'];
	$city = $_POST['city'];
	$dob = $_POST['dob'];
	$dob2 = strtotime($_POST['dob']);
	$dob_1=date('d/m/Y', $dob2);
        $gender = $_POST['gender'];	
		
	$userfullname=$firstname.' '.$lastname; 
	$addressUser=$address.' '.$address2;
	
	$today = strtotime('today');

	$co1=$_POST['column1'];
	$co2=$_POST['column2'];	
	$co3=$_POST['column3'];	

	if($middlename!=''){ $name=$firstname.' '.$lastname; }else{
		$name=$firstname.' '.$middlename.' '.$lastname;
	}
	
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
	$selectusers=mysql_query("SELECT * FROM mdl_cifauser WHERE suspended='0' ORDER BY id DESC");
	$usercount=mysql_num_rows($selectusers);
	$userrec=mysql_fetch_array($selectusers);
	$tid=$userrec['id']+'1';
	$month=date('m');
	$year=date('y');
	
	if($tid <= '9'){ 
		$c='00';
	}
	elseif($tid >= '10' && $tid <= '99'){ 
		$c='0';
	}else{
		$c='';
	}
        
        
        
	
	//final candidates ID generate// candidate start with A
	$candidatesI='A'.$year.''.$c.''.$tid.''.$country;
	$traineeID=$candidatesI;	
	
	//delete user yang telah dipadam sekiranya sama id dalam sistem
	$deleteuser=mysql_query("DELETE FROM {$CFG->prefix}candidates WHERE traineeid='".$traineeID."' AND candidateid!='0'");
	
	$semakpengguna_statement="SELECT * FROM mdl_cifacandidates WHERE candidateid='0' AND traineeid='".$traineeID."'";
	$semakpengguna=mysql_query($semakpengguna_statement);
	$count_semak=mysql_num_rows($semakpengguna);
	// echo $count_semak;
	if($count_semak == '0'){
	//adding user to purchase info
	//$result=mysql_query("insert into mdl_cifacandidates values('','','".$traineeID."','1','".$title."','".$name."','".$dob."','".$gender."','".$email."','".$addressUser."','".$postal."','".$province."','".$country."','".$phone."')");
	
	$result=mysql_query("INSERT INTO mdl_cifacandidates(traineeid, visible, title, name, firstname, middlename, lastname, dob, gender, email, address, address2, address3, postal, province, state_code, country, phone) 
	VALUES('".$traineeID."','1', '".$title."', '".$name."', '".$firstname."', '".$middlename."', '".$lastname."', '".$dob_1."', '".$gender."', '".$email."', '".$address."', '".$address2."', '".$address3."', '".$postal."', '".$city."', '".$province."','".$country."','".$phone."')");	
	$customerid=mysql_insert_id();
	$date=strtotime('now');
	
	if(is_array($_SESSION['cart'])){		
		//communication references accepted
			$communication=mysql_query("INSERT INTO mdl_cifacommunication_reference
									SET serial='".$customerid."', traineeid='".$traineeID."', candidateid='0', rules1='".$co1."', rules2='".$co2."', rules3='".$co3."', timeaccepted='".$date."'");			
		//adding orders
		$result=mysql_query("insert into mdl_cifaorders values('','','','new','".$date."','".$customerid."')");
		$orderid=mysql_insert_id();
	}

	$max=count($_SESSION['cart']);
	for($i=0;$i<$max;$i++){
		$pid=$_SESSION['cart'][$i]['productid'];
		$q=$_SESSION['cart'][$i]['qty'];
		$price=get_price($pid);
		//adding order details
		// mysql_query("insert into mdl_cifaorder_detail values ($orderid,$pid,$q,$price)");
		mysql_query("insert into mdl_cifaorder_detail(orderid, productid, quantity, price) values ($orderid,$pid,$q,$price)");
		
		
			//extend///purchase detais to statement DB
			$descsubcribe='Subscribe';
			$istatementsql=mysql_query("
			INSERT INTO mdl_cifastatement
			SET 
				candidateid='".$traineeID."',
				subscribedate='".$today."', 
				courseid='".$pid."', 
				remark='".$descsubcribe."', 
				debit1='".$price."'
			");			
	}
	

	/////////////////////////////////////////////- ADDING USER -/////////////////////////////////////////////////////////////////////////////
	if (isloggedin()) {
		header("location:index.php");
	 }else{
			if(is_array($_SESSION['cart'])){

			$username=strtolower($traineeID);
			$pword_text=get_string('temporarypassword');
			$password=md5($pword_text);
			$timecreated = strtotime('now');
			$lastcreated = strtotime("now" . " + 1 year");
			$addressUser=$address.' '.$address2;
		   
			$srole=mysql_query("SELECT name FROM mdl_cifarole WHERE id='16'");
			$rwrole=mysql_fetch_array($srole);
			$usertype=$rwrole['name'];
			$userdob2=strtotime($dob);
			
			/* $checkquery=mysql_query("SELECT email, dob FROM mdl_cifauser WHERE email='".$email."' AND dob='".$userdob2."'");
			echo $email.$sqlcrow=mysql_num_rows($checkquery); */
			
			//adding user as prospect to mdl_cifauser
			$sqlReg="INSERT INTO mdl_cifauser
					  SET username='".$username."', password='".$password."', firstname='".$firstname."', middlename='".$middlename."', lastname='".$lastname."', 
						  email='".$email."', traineeid='".$traineeID."', dob='".strtotime($dob)."', mnethostid='1', confirmed='0', descriptionformat='1',  
						  timecreated='".$timecreated."', lasttimecreated='".$lastcreated."', usertype='".$usertype."', phone1='". $phone."', phone2='". $phone2."', address='".$address."', address2='".$address2."', address3='".$address3."', country='".$country."', state='".$province."', city='".$city."', gender='".$gender."'";
			$sqlRegQ=mysql_query($sqlReg) or die("sql gagal<br/>" .mysql_error());		
			$usercandidateid=mysql_insert_id();
			
			//force change password
			if($sqlRegQ){
				$forcechangepwd=mysql_query("INSERT INTO mdl_cifauser_preferences SET userid='".$usercandidateid."', name='auth_forcepasswordchange', value='1'");
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
	
			// Set email notification (IPD candidate enrollment confirmation).
			$sqlsupportemail=mysql_query("SELECT * FROM {$CFG->prefix}config WHERE name='supportemail'");
			$q_supportemail=mysql_fetch_array($sqlsupportemail);
			$supportemail=$q_supportemail['value'];
			
                        
                        // Loop get course, for each course if 
                        // more than 1 course or single course
                        //  - By Ershad
                        // --------- START --------- //
                        
                        //Payment links
                        $foundation = 'http://www.gocollect.io/shape%20for%20economic%20consulting/8cc41';
                        $accounting = 'http://www.gocollect.io/shape%20for%20economic%20consulting/o9zwd';
                        $trade_finance = 'http://www.gocollect.io/shape%20for%20economic%20consulting/171c2';
                        $treasury = 'http://www.gocollect.io/shape%20for%20economic%20consulting/85759';
                        $capital_market = 'http://www.gocollect.io/shape%20for%20economic%20consulting/53c39';
                        
                        $coursedetails_e = "";
                        $payment_link = '';
                        
                        if(is_array($_SESSION['cart'])){
                            $max = count($_SESSION['cart']);
                            
                            for($i=0; $i<$max; $i++){
                                $pid = $_SESSION['cart'][$i]['productid'];
                
                                $q =$_SESSION['cart'][$i]['qty']; // Quantitiy kot

                                $pname = get_product_name($pid);
                                
                                $price = get_price($pid);
                                
                                //Setting up payment links
                                
                                if($pname === 'Foundations of Islamic Banking & Finance' || $pname === 'Foundations of Islamic Banking & Finance(In Arabic)'){
                                    $payment_link = $foundation;
                                }else if ($pname === 'AAOIFI Accounting'){
                                    $payment_link = $accounting;
                                }else if ($pname === 'Islamic Trade Finance'){
                                    $payment_link = $trade_finance;
                                }else if ($pname === 'Islamic Treasury Application'){
                                    $payment_link = $treasury;
                                }else if ($pname === 'Sukuk & Islamic Securitization'){
                                    $payment_link = $capital_market;
                                }else {
                                    $payment_link = '';
                                }
                                
                                $coursedetails_e .= "
                                    <br/>
                                    <table id='availablecourse3' style='bgcolor:#FFFFFF; border-collapse: collapse; border-spacing: 0; border-color:#cccccc;margin: 0px auto;' width='100%' border='1'>
                                        <tr bgcolor='#efeff7'>
                                            <td style='width:60%;'><strong>Description</strong></td>
                                            <td><strong>Unit price</strong></td>
                                            <td align='center' width='1%'><strong>Qty</strong></td>
                                            <td width='20%'><strong>Amount</strong></td>
                                        </tr>
                                        <tr bgcolor='#FFFFFF'>
                                            <td>".$pname."</td>
                                            <td>$ ".$price." USD</td>
                                            <td align='center'>".$q."</td>
                                            <td>$ ".$price * $q." USD</td>
                                        </tr>
                                        <tr bgcolor='#efeff7'>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td align='center'><strong>Total</strong></td>
                                            <td>$ ".$price * $q." USD</td>
                                        </tr>  
                                    </table>
                                    <div style='width: 100%; padding:10px 0px; text-align:center;'>
                                    <a style='display:inline-block; width: 140px; padding:10px 0px; text-decoration: none; text-transform: uppercase; letter-spacing: 2.5px;  font-weight: 500; color: #FFF;  background-color: #1ab7ea; border: none;  box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);  transition: all 0.3s ease 0s;  cursor: pointer;  outline: none;' target='_blank' href='".$payment_link."'>Pay Now</a></div>
                                    <br/>";
                            }
                        }
                        // --------- END --------- //
                        
			// email to commenter
			$to = $email;
                        $subject = "Next Step: ".strtoupper($traineeID)." - Candidate Part-Enrolment Confirmation & Payment Instruction";
                                
                        $message = "
                            <html>
                                <head>
                                    <title>HTML email</title>
                                </head>
                                <body>
                                <p>Dear (".ucwords(strtolower($name))."),</p>
                                <br/><p>Candidate ID: ".$traineeID."</p>

                                <br/><p style='text-align:justify;'>
                                I am pleased to congratulate you to have taken the first step in enrolling as SHAPE<sup>&reg;</sup> IPD Candidate. Your Candidate ID is <strong>".$traineeID."</strong> . Please quote this in all future correspondence with us.</p>

                                <br/><p style='text-align:justify;'>Please find below your transaction details:</p>

                                <br/>

                                ".$coursedetails_e."

                                <br/><p style='text-align:justify;'>
                                    Please be sure to send the successful payment transfer proof which contains the following information to info@consultshape.com :
                                </p>										

                                <br/><p style='text-align:justify;'>
                                    <ol>
                                        <li>Receipt Ref No</li>
                                        <li>Invoice No</li>
                                        <li>Full Name </li>
                                        <li>Email</li>
                                        <li>Candidate ID</li>
                                    </ol>
                                </p>

                                <br/><p style='text-align:justify;'>
                                    The process to verify payment and updating your status may take up to 48 hours. 
                                </p> 

                                <br/><p style='text-align:justify;'>
                                    Once your status has been updated, you will receive another email guiding you to login to IPD Online and start your training with us.
                                </p> 

                                <br/><p style='text-align:justify;'>
                                    Please do not hesitate to <strong><u><a href='http://134.213.66.124/shapeipd/contactus/upload_index.php' target='_blank'>contact us</a></u></strong> for further assistance. 
                                </p> 

                                <br/><p>Yours Sincerely, <br>
                                <strong>SHAPE<sup>&reg;</sup> Knowledge Services</strong></p>
                                <br/><p style='font-size:11px'><strong>Disclaimer:</strong> <br>
                                    This is a system  generated email. Please do not reply. For assistance, please <strong><u><a href='http://134.213.66.124/shapeipd/contactus/upload_index.php' target='_blank'>contact us</a></u></strong> and we will revert back to you within 72 hours. </p>
                                </body>
                            </html>";
                        
			// Always set content-type when sending HTML email
			$link=$CFG->wwwroot;
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			
			// More headers
			$headers .= 'From: <'.$supportemail.'>' . "\r\n";
			//$headers .= 'Cc: mohd.arizan@mmsc.com.my'. "\r\n";
			
			mail($to,$subject,$message,$headers);
			// end email config	
			/////// AUTHMAIL ///////////////////////////////////////////////////////////////////////
			$from1=$supportemail;  
			$namefrom1="IPD Online";
			$nameto1 = "IPD Online"; 
					
			// this is it, lets send that email!
			authgMail($from1, $namefrom1, $to, $nameto1, $subject, $message);
                       
	}	
	///////////////////////////////////////////////- END ADDING USER-//////////////////////////////////////////////////////////////////
}	
?>
<style>
<?php 
    include('css/style2.css'); 
    //include('css/style.css'); 
?>
</style>
<link rel="stylesheet" type="text/css" media="all" href="offlineexam/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="offlineexam/jquery.1.4.2.js"></script>
<script type="text/javascript" src="offlineexam/jsDatePick.jquery.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%d-%m-%Y"
		});
	};
</script>

<script src="script/jquery-1.9.1.js" type="text/javascript"></script>
<link href="http://fiddle.jshell.net/css/result-light.css" type="text/css" rel="stylesheet">
<script>
//<![CDATA[
$(window).load(function(){
$(document).ready(function() {
$("input[type=checkbox]").change(function()
{
var divId = $(this).attr("id");
if ($(this).is(":checked")) {
$("." + divId).show();
}
else {
$("." + divId).hide();
}
});
$("input[type=radio]").change();
});
$(document).ready(function() {
$("input[type=radio]").change(function()
{
var divId = $(this).attr("id");
$("div.check").hide();
$("." + divId).show();
$("input[type=checkbox]").change();
});
});
});//]]> 
</script>


<script language="JavaScript">
	function validate(){
		pengakuan1 = 'Please choose your payment method.';
		
//		elem1 = document.getElementById('creditcard');
//		elem2 = document.getElementById('paypal');
		elem3 = document.getElementById('telegraphic');

		if ( (elem1.checked == false ) && (elem2.checked == false ) && (elem3.checked == false ) )
		{
                    alert (pengakuan1);
                    document.form1.radio.focus();
                    return false;
		}
			
		document.form1.submit();	
		return true;	
				
	}
</script>

    
    
<?php
	//idle time
	include('js/js_idletime.php');
	
	$link=$CFG->wwwroot .'/payment_confirmation.php?traineeID='.$traineeID.'&&method='.$_POST['radio'].'&name='.$firstname.'&middlename='.$middlename.'&lastname='.$lastname.'&gender='.$gender.'&dob='.$dob.'&address='.$address.'&address2='.$address2.'&address3='.$address3.'&title='.$title.'&email='.$email.'&phone='.$phone.'&phone2='.$phone2.'&state='.$province.'&city='.$city.'&postalcode='.$postal.'&country='.$country.'&&co1='.$co1.'&&co2='.$co2.'&&co3='.$co3.'&&customerid='.$customerid.'&orderid='.$orderid;
?>	




<div style="min-height: 260px;">
<form id="form1" name="form1" method="post" action="<?=$link;?>">	
<style>
#shopcart img{max-width:80%;}
</style>
<table id="shopcart" width="80%" border="0" style="text-align:left;">
	<tr>
	<td width="20%" align="center"><img src="image/step3_payment.png" width="80%"></td>  
	</tr>
</table>
	<fieldset style="padding: 0.6em;" id="user" class="clearfix"><legend style="font-weight:bolder;" class="ftoggler">Shopping Cart</legend>
	<div style="margin:0px auto; width:95%; padding-top:20px;">
    <!--div style="padding-bottom:10px;cursor:pointer;">
    	<!--h1 align="center">Purchase info</h1-->
    <!--input type="button" value="Add new subscribe module" onclick="window.location='coursesindex.php'">
    </div-->
    	<div style="color:#F00"><?php echo $msg?></div>
    	<table id="availablecourse2" width="100%">
    	<?php
			if(is_array($_SESSION['cart'])){
            	echo '<tr class="yellow" bgcolor="#FFFFFF" style="font-weight:bold">
						<th width="1%" align="center">No.</th>
						<th width="45%">Course Name</th>
						<th width="10%" style="text-align:center;">Price</th>
						<th width="10%" style="text-align:center;">Amount</th>
					</tr>';
				$max=count($_SESSION['cart']);
				for($i=0;$i<$max;$i++){
					$pid=$_SESSION['cart'][$i]['productid'];
					$q=$_SESSION['cart'][$i]['qty'];
					$pname=get_product_name($pid);
					if($q==0) continue;
			?>
            		<tr bgcolor="#FFFFFF">
                    <!--td class="adjacent" style="padding:5px;text-align:center;"><div style="cursor:pointer;">
						<img onclick="javascript:del(<?php //echo $pid?>)" src="image/delete2.png" width="15" title="Remove a purchase - <?//=$pname;?>"/></div>
					</td-->					
					<td class="adjacent" style="text-align:center;"><?php echo $i+1?></td>
					<td class="adjacent" style="text-align:left;"><?php echo $pname?></td>
					<!--td class="adjacent" style="text-align:left;"><?php //echo get_product_code($pid);?></td-->
                    <td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)?></td>
                    <!--td class="adjacent" style="text-align:center;"><input type="hidden" name="product<?php //echo $pid?>" value="<?php //echo $q?>" maxlength="3" size="2" /><?php //echo $q?></td-->                    
                    <td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)*$q?></td>
					</tr>
            <?php					
				}
				if($max>0){
			?>
				<tr style="height:30px;">
					<td class="adjacent" colspan="2" width="70%">&nbsp;</td>
					<td class="adjacent" style="text-align:center;"><b>Order Total</b></td>
					<td class="adjacent" style="text-align:center;"><b>$ <?php echo get_order_total()?></b></td>
				</tr>
			<?php
				}else{
					echo "<tr bgColor='#FFFFFF'><td class='adjacent' colspan='7'>There are no items in your shopping cart!</td>";
				}
			}
			else{
				echo "<tr bgColor='#FFFFFF'><td class='adjacent'>There are no items in your shopping cart!</td>";
			}
		?>
        </table>
    </div>
	</fieldset>	
	<!-- End purchasing order -->
        
        
        
        
        
<!--Payment method below--> 

<!--the payment method passed to payment confirmation [age-->
        
<fieldset style="padding: 0.6em; display:none;" id="user" class="clearfix"><legend style="font-weight:bolder;" class="ftoggler">Please choose your preferred payment method:</legend>
<table width="50%" border="0">
    <tr>
      <td><input type="radio" name="radio" id="telegraphic" checked value="telegraphic" onClick="this.form.action='<?=$link;?>';" /></td>    
      <td>&nbsp;</td>    
      <td>Bank Transfer</td>
    </tr>   
  </table>
</fieldset>
    


<table style="width:10%; margin:0 auto;">
<tr valign="top"><td><input type="submit" name="submit" value=" Confirm " onClick="return validate();" /></td></tr>
</table>
</form>
</div>
<?php 	echo $OUTPUT->footer();	?>