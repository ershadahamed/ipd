<?php
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../../manualdbconfig.php'); 
	include('../../includes/functions.php');

	$site = get_site();
	$today = strtotime('today');
	$orderid=$_GET['orderid'];
		
	$statement=" mdl_cifacandidates a Inner Join mdl_cifaorders b On a.serial = b.customerid Inner Join mdl_cifaorder_detail c On b.serial = c.orderid";		
	$sqlcourse="SELECT * FROM {$statement} WHERE b.serial='".$orderid."'";
	$sqlcourse.=" Group By b.date Order By b.date DESC, a.traineeid DESC";	
	$sqlquery=mysql_query($sqlcourse);
	$sqlrow=mysql_fetch_array($sqlquery);
	$purchase=$sqlrow['name'];
	
	$continuemypurchases=ucwords(strtolower(get_string('continuemypurchases')));
	$title="$SITE->shortname: SHAPE IPD - ".$purchase;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->navbar->add($continuemypurchases)->add($orderid);

	echo $OUTPUT->header();	
	$traineeID = $sqlrow['traineeid'];
	
	$firstname = $sqlrow['name'];
	$lastname = $sqlrow['lastname'];
	$address = $sqlrow['address'];
	$address2 = $sqlrow['address2'];
	$email = $sqlrow['email'];
	$phone = $sqlrow['phone'];
	$phone2 = $sqlrow['phone2'];	
	$province = $sqlrow['province'];
	$city = $sqlrow['city'];
	$postal = $sqlrow['postal'];
	$country = $sqlrow['country'];
	$customerid= $sqlrow['customerid'];
	
	$userfullname=$firstname.' '.$lastname; 
	$useraddress=$address.', '.$address2;	
	
	$today = strtotime('today');
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