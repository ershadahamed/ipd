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
	$title = $_GET['title'];
	
	$firstname = $_GET['name'];
	$middlename=$_GET['middlename'];
	$lastname = $_GET['lastname'];
	$address = $_GET['address'];
	$address2 = $_GET['address2'];
	$email = $_GET['email'];
	$phone = $_GET['phone'];
	$phone2 = $_GET['phone2'];
	$province = $_GET['state'];
	$postal = $_GET['postalcode'];
	$country = $_GET['country'];
	$dob = $_GET['dob'];
	
	$userfullname=$firstname.' '.$lastname; 
	$useraddress=$address.', '.$address2;	
	$addressUser=$address.' '.$address2;
	
	$today = strtotime('today');
	
	$co1=$_GET['co1'];
	$co2=$_GET['co2'];
	$co3=$_GET['co3'];	

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
	//echo $traineeID;
	$semakpengguna_statement="SELECT * FROM mdl_cifacandidates WHERE candidateid='0' AND traineeid='".$traineeID."'";
	$semakpengguna=mysql_query($semakpengguna_statement);
	$count_semak=mysql_num_rows($semakpengguna);
	if($count_semak == '0'){
	
	//adding user to purchase info
	$result=mysql_query("insert into mdl_cifacandidates values('','','".$traineeID."','1','".$title."','".$name."','".$dob."','".$email."','".$addressUser."','".$postal."','".$province."','".$country."','".$phone."')");
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
<?php
	$link=$CFG->wwwroot .'/payment_confirmation.php?traineeID='.$traineeID.'&&method='.$_POST['radio'].'&name='.$firstname.'&middlename='.$middlename.'&lastname='.$lastname.'&dob='.$dob.'&address='.$address.'&address2='.$address2.'&title='.$title.'&email='.$email.'&phone='.$phone.'&phone2='.$phone2.'&state='.$province.'&postalcode='.$postal.'&country='.$country.'&&co1='.$co1.'&&co2='.$co2.'&&co3='.$co3.'&&customerid='.$customerid.'&orderid='.$orderid;
?>	
<div style="min-height: 260px;">
<form id="form1" name="form1" method="post" action="">	
<fieldset id="fieldset"><legend id="legend">Please choose your preferred payment method:</legend>
<table width="50%" border="0">
    <tr>
      <td width="5%"><input type="radio" name="radio" id="creditcard" value="creditcard" onClick="this.form.action='<?=$link;?>'" disabled /></td>
      <td width="1%">&nbsp;</td>      
      <td width="94%">Credit card</td>      
    </tr>
    <tr>
      <td><input type="radio" name="radio" id="paypal" value="paypal" onClick="this.form.action='<?=$link;?>'" disabled /></td>    
      <td>&nbsp;</td>
      <td>Paypal</td>
    </tr>
    <tr>
      <td><input type="radio" name="radio" id="telegraphic" value="telegraphic" onClick="this.form.action='<?=$link;?>'" /></td>    
      <td>&nbsp;</td>    
      <td>Telegraphic Transfer</td>
    </tr>   
  </table>
</fieldset>

<table style="width:10%; margin:0 auto;">
<tr valign="top"><td><input type="submit" name="submit" value=" Next >> " onclick="return validate();" /></td></tr>
</table>
</form>
</div>
<?php 	echo $OUTPUT->footer();	?>