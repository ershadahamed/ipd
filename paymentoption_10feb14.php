<?php
    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
    include('manualdbconfig.php'); 
    include("includes/functions.php");	

	$site = get_site();
	
	$purchase='Purchase IPD modules';
	$titlehead="$SITE->shortname: SHAPE IPD - ".$purchase;
	$PAGE->set_title($titlehead);
	$PAGE->set_heading($site->fullname);

	echo $OUTPUT->header();	
	/**POST*/
	$title = $_POST['title'];
	
	$firstname = $_POST['name'];
	$middlename=$_POST['middlename'];
	$lastname = $_POST['lastname'];
	$address = $_POST['address'];
	$address2 = $_POST['address2'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$phone2 = $_POST['phone2'];
	$province = $_POST['state'];
	$postal = $_POST['postalcode'];
	$country = $_POST['country'];
	$dob = $_POST['dob'];
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
	$selectusers=mysql_query("SELECT * FROM mdl_cifauser WHERE deleted='0' AND suspended='0' ORDER BY id DESC");
	//$selectusers=mysql_query("SELECT * FROM mdl_cifacandidates ORDER BY id DESC");
	$usercount=mysql_num_rows($selectusers);
	$userrec=mysql_fetch_array($selectusers);
	$tid=$userrec['id']+'1';
	//$tid=$usercount+'1';
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
	//echo $traineeID;
	$semakpengguna_statement="SELECT * FROM mdl_cifacandidates WHERE candidateid='0' AND traineeid='".$traineeID."'";
	$semakpengguna=mysql_query($semakpengguna_statement);
	$count_semak=mysql_num_rows($semakpengguna);
	//echo $count_semak;
	if($count_semak == '0'){
	//adding user to purchase info
	$result=mysql_query("insert into mdl_cifacandidates values('','','".$traineeID."','1','".$title."','".$name."','".$dob."','".$gender."','".$email."','".$addressUser."','".$postal."','".$province."','".$country."','".$phone."')");
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
		mysql_query("insert into mdl_cifaorder_detail values ($orderid,$pid,$q,$price)");
	}
	

	/////////////////////////////////////////////- ADDING USER -/////////////////////////////////////////////////////////////////////////////
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
		   
			$srole=mysql_query("SELECT name FROM mdl_cifarole WHERE id='16'");
			$rwrole=mysql_fetch_array($srole);
			$usertype=$rwrole['name'];
			
			//adding user as prospect to mdl_cifauser
			$sqlReg="INSERT INTO mdl_cifauser
					  SET username='".$username."', password='".$password."', firstname='".$firstname."', lastname='".$lastname."', 
						  email='".$email."', traineeid='".$traineeID."', dob='".strtotime($dob)."', mnethostid='1', confirmed='0', descriptionformat='1',  
						  timecreated='".$timecreated."', lasttimecreated='".$lastcreated."', usertype='".$usertype."', phone1='". $phone."', phone2='". $phone2."', address='".$addressUser."', country='".$country."', city='".$province."', gender='".$gender."'";
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
				
	}}	
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
		
		elem1 = document.getElementById('creditcard');
		elem2 = document.getElementById('paypal');
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
	<script type="text/javascript">
	setTimeout(onUserInactivity, 1000 * 900)
	function onUserInactivity() {
	   window.location.href = "index.php"
	   <?php //session_destroy(); ?>
	   alert('You has been idle for 15 minutes.');
	}
	</script>
<?php
	$link=$CFG->wwwroot .'/payment_confirmation.php?traineeID='.$traineeID.'&&method='.$_POST['radio'].'&name='.$firstname.'&middlename='.$middlename.'&lastname='.$lastname.'&gender='.$gender.'&dob='.$dob.'&address='.$address.'&address2='.$address2.'&title='.$title.'&email='.$email.'&phone='.$phone.'&phone2='.$phone2.'&state='.$province.'&postalcode='.$postal.'&country='.$country.'&&co1='.$co1.'&&co2='.$co2.'&&co3='.$co3.'&&customerid='.$customerid.'&orderid='.$orderid;
?>	
<div style="min-height: 260px;">
<form id="form1" name="form1" method="post" action="">	
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
<fieldset style="padding: 0.6em;" id="user" class="clearfix"><legend style="font-weight:bolder;" class="ftoggler">Please choose your preferred payment method:</legend>
<table width="50%" border="0">
    <tr>
      <td width="5%"><input type="radio" name="radio" id="creditcard" value="creditcard" disabled="disabled" onClick="this.form.action='';" /></td>
      <td width="1%">&nbsp;</td>      
      <td width="94%">Credit card</td>      
    </tr>
    <tr>
      <td><input type="radio" name="radio" id="paypal" value="paypal" disabled="disabled" onClick="this.form.action='';" /></td>    
      <td>&nbsp;</td>
      <td>Paypal</td>
    </tr>
    <tr>
      <td><input type="radio" name="radio" id="telegraphic" value="telegraphic" onClick="this.form.action='<?=$link;?>';" /></td>    
      <td>&nbsp;</td>    
      <td>Bank Transfer</td>
    </tr>   
  </table>
</fieldset>
    
<!------Paypal Show Hide------------>
<div class="check paypal" style="display:none">
<p> Some information i want hidden (5) </p>
</div>
<!------Paypal Show Hide------------>

<!----Credit card -- Show Hide--Billing address------------>
<div class="check creditcard" style="display:none">
<fieldset id="fieldset"><legend id="legend" style="width:120px;">&nbsp;Billing Address&nbsp;</legend>
	<div style="padding:20px;">
        <table border="0" cellpadding="2px" width="95%">
            <tr><td width="30%">Title</td><td width="1%"><strong>:</strong></td>
                <td>
                    <select name="billingtitle">
                        <option <?php if($_GET['title']=='Mr.'){ echo "selected='selected'";}?> >Mr.</option>
                        <option <?php if($_GET['title']=='Mrs.'){ echo "selected='selected'";}?>>Mrs.</option>
                        <option <?php if($_GET['title']=='Miss.'){ echo "selected='selected'";}?>>Miss.</option>
                        <option <?php if($_GET['title']=='Ms.'){ echo "selected='selected'";}?>>Ms.</option>
                   </select>
                </td>
            </tr>
            <tr><td>First name</td><td width="1%"><strong>:</strong></td><td>
                    <input type="text" name="billingname" size="40" value="<?=$_GET['name'];?>" onKeyUp="javascript:this.value=this.value.toTitleCase();" /><?=$strrequired;?>
            </td></tr>
            <tr><td>Middle name</td><td width="1%"><strong>:</strong></td><td>
                    <input type="text" value="<?=$_GET['middlename']; ?>" name="billingmiddlename" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase();" />
            </td></tr>				 
            <tr><td>Last name</td><td width="1%"><strong>:</strong></td><td>
                    <input type="text" value="<?=$_GET['lastname'];?>" name="billinglastname" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase();" /><?=$strrequired;?>
            </td></tr>
            <tr><td>Date of birth</td><td><strong>:</strong></td><td>
                    <input type="text" value="<?=$_GET['dob'];?>" id="inputField" name="billingdob" size="40" /><?=$strrequired;?>
            </td></tr>	
            <tr><td>Gender</td><td><strong>:</strong></td><td>
                    <input type="text" value="<?=$_GET['gender'];?>" id="billgender" name="billgender" size="40" /><?=$strrequired;?>
            </td></tr>
            <tr><td>Email address</td><td width="1%"><strong>:</strong></td><td>
                    <input type="text" value="<?=$_GET['email'];?>" name="billingemail" size="40" /><?=$strrequired;?>
            </td></tr>			
            <tr><td>Address details</td><td width="1%"><strong>:</strong></td><td>
                    <input type="text" value="<?=$_GET['address'];?>" name="billingaddress" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase()" /><?=$strrequired;?>
            </td></tr>		
            <tr><td>&nbsp;</td><td width="1%"><strong>:</strong></td><td>
                    <input type="text" value="<?=$_GET['address2'];?>" name="billingaddress2" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase()" />
            </td></tr>							
            <tr><td>State</td><td width="1%"><strong>:</strong></td><td>
                    <input type="text" value="<?=$_GET['state'];?>" name="billingstate" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase()" />
            </td></tr>					
            <tr><td>Postal code</td><td width="1%"><strong>:</strong></td><td>
                    <input value="<?=$_GET['postalcode']; ?>" type="text" name="billingpostalcode" size="40" />
            </td></tr>											
            <tr><td>Country</td><td width="1%"><strong>:</strong></td><td>

            <?php
                $statement="SELECT * FROM mdl_cifacountry_list";
                $scountry=mysql_query($statement);				
            ?>			
                <select id="country" name="billingcountry">
                        <option value=""> - </option>
                        <?php while($rowcountry=mysql_fetch_array($scountry)){ ?>
                        <option <?php if($_GET['country']==$rowcountry['countrycode']){ echo "selected='selected'";}?> value="<?=$rowcountry['countrycode'];?>"><?=$rowcountry['countryname'];?></option>
                        <?php } ?>
                </select><?=$strrequired;?>
            </td></tr>			
            <tr valign="top"><td>Contact number</td><td width="1%"><strong>:</strong></td><td>
                Phone no. (M) :- &nbsp;&nbsp;&nbsp;&nbsp;				
                <input type="text" id="phoneM" value="<?=$_GET['phone'];?>" name="billingphoneM" size="20" />
                <input type="text" name="countrycode" id="countrycode" size="10" readonly="readonly" style="border:0; width: 50px; text-align:center;font-weight:bold;"/><?=$strrequired;?>
                <input type="hidden" name="phone" id="phone" value="" />					
            </td></tr>					
        </table>
	</div>
</fieldset> </div> 

<table style="width:10%; margin:0 auto;">
<tr valign="top"><td><input type="submit" name="submit" value=" Next >> " onclick="return validate();" /></td></tr>
</table>
</form>
</div>
<?php 	echo $OUTPUT->footer();	?>