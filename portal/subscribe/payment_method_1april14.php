<?php
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../../manualdbconfig.php'); 
	include("../../includes/functions.php");

	$site = get_site();
	
	$purchase='Purchase IPD modules';
	$title="$SITE->shortname: SHAPE IPD - ".$purchase;
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
	
	$userfullname=$firstname.' '.$lastname; 
	$useraddress=$address.', '.$address2;	
	
	$today = strtotime('today');
	
	$co1=$_GET['co1'];
	$co2=$_GET['co2'];
	$co3=$_GET['co3'];
	
	//check if record exist
	$currentusername=$USER->firstname.' '.$USER->lastname;
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
	
	//insert to candidates, orders, orders details
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
		$result=mysql_query("insert into mdl_cifaorders(serial, confirmationno, paymethod, paystatus, date, customerid) values('','','','new','".$date."','".$customerid."')");
		$orderid=mysql_insert_id();		
	}

	$max=count($_SESSION['cart']);
	for($i=0;$i<$max;$i++){
		$pid=$_SESSION['cart'][$i]['productid'];
		$q=$_SESSION['cart'][$i]['qty'];
		$price=get_price($pid);
		mysql_query("insert into mdl_cifaorder_detail values ($orderid,$pid,$q,$price)");
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
	$link=$CFG->wwwroot. '/portal/subscribe/telegraphic_pay.php?traineeID='.$traineeID.'&&trainee_name='.$firstname.'&&lastname='.$lastname.'&&address='.$address.'&&address2='.$address2.'&&email='.$email.'&&phone='.$phone.'&&phone2='.$phone2.'&&city='.$city.'&&province='.$province.'&&postal='.$postal.'&&country='.$country.'&&co1='.$co1.'&&co2='.$co2.'&&co3='.$co3.'&&customerid='.$customerid.'&orderid='.$orderid; 	
	//$link=$CFG->wwwroot .'/portal/subscribe/telegraphic_pay.php?method='.$_POST['radio'].'&name='.$firstname.'&middlename='.$middlename.'&lastname='.$lastname.'&dob='.$dob.'&address='.$address.'&address2='.$address2.'&title='.$title.'&email='.$email.'&phone='.$phone.'&phone2='.$phone2.'&state='.$province.'&postalcode='.$postal.'&country='.$country.'&&co1='.$nilai1.'&&co2='.$nilai2.'&&co3='.$nilai3;
?>	

<form id="form1" name="form1" method="post" action="">	
<div style="min-height:260px;">
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
      <td><input type="radio" name="radio" id="telegraphic" onMouseOver="style.cursor='pointer'" value="telegraphic" onClick="this.form.action='<?=$link;?>'" /></td>    
      <td>&nbsp;</td>    
      <td>Telegraphic Transfer</td>
    </tr>   
  </table>
</fieldset>

<table style="width:10%; margin:0 auto;">
<tr valign="top"><td><input type="submit" style="cursor:pointer;" name="submit" value=" Next >> " onclick="return validate();" /></td></tr>
</table>
</div>
</form>

<?php 	echo $OUTPUT->footer();	?>