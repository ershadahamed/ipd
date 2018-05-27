<?php include('config.php'); 	include("manualdbconfig.php"); include("includes/functions.php");?>
<style>
ol #myList
{
	list-style-type:lower-roman;
	text-align: justify;
}

#userpolicy
{
	width:95%;
	margin:0 auto;
	border-collapse: collapse;
	border: 2px solid rgb(152, 191, 33);
	background-color:#fff;	
}
</style>
<?php
	//to retrive back data from form
	//to retrive back data from form
	$traineeID = $_GET['traineeID'];
	
	$firstname = $_GET['trainee_name'];
	$lastname = $_GET['lastname'];
	$address = $_GET['address'];
	$address2 = $_GET['address2'];
	$email = $_GET['email'];
	$phone = $_GET['phone'];
	$phone2 = $_GET['phone_2'];	
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
	$paymethod=$_GET['pay_method'];

	/*if($paymethod == 'paypal'){
	//$link=$CFG->wwwroot. '/portal/subscribe/subscribedetails_loggeduser.php?paymethod=paypal&&traineeID='.$traineeID.'&&trainee_name='.$firstname.'&&lastname='.$lastname.'&&address='.$address.'&&address2='.$address2.'&&email='.$email.'&&phone='.$phone.'&&city='.$city.'&&province='.$province.'&&postal='.$postal.'&&country='.$country.'&&cost='.$cost.'&&currency='.$currency.'&&PaypalBusinessEmail='.$PaypalBusinessEmail.'&&coursename='.$coursename.'&&shortname='.$shortname.'&&courseid='.$courseid; 
	$link=$CFG->wwwroot. '/userpolicy.php?paymethod=paypal&&traineeID='.$traineeID.'&&trainee_name='.$firstname.'&&lastname='.$lastname.'&&address='.$address.'&&address2='.$address2.'&&email='.$email.'&&phone='.$phone.'&&phone2='.$phone2.'&&city='.$city.'&&province='.$province.'&&postal='.$postal.'&&country='.$country.'&&cost='.$cost.'&&currency='.$currency.'&&PaypalBusinessEmail='.$PaypalBusinessEmail.'&&coursename='.$coursename.'&&shortname='.$shortname.'&&courseid='.$courseid; 
	}else if($paymethod == 'creditcard'){
	//$link2=$CFG->wwwroot. '/portal/subscribe/creditcard_pay.php?paymethod=creditcard&&traineeID='.$traineeID.'&&trainee_name='.$firstname.'&&lastname='.$lastname.'&&address='.$address.'&&address2='.$address2.'&&email='.$email.'&&phone='.$phone.'&&city='.$city.'&&province='.$province.'&&postal='.$postal.'&&country='.$country.'&&cost='.$cost.'&&currency='.$currency.'&&PaypalBusinessEmail='.$PaypalBusinessEmail.'&&coursename='.$coursename.'&&shortname='.$shortname.'&&courseid='.$courseid; 
	$link2=$CFG->wwwroot. '/userpolicy.php?paymethod=creditcard&&traineeID='.$traineeID.'&&trainee_name='.$firstname.'&&lastname='.$lastname.'&&address='.$address.'&&address2='.$address2.'&&email='.$email.'&&phone2='.$phone2.'&&phone='.$phone.'&&city='.$city.'&&province='.$province.'&&postal='.$postal.'&&country='.$country.'&&cost='.$cost.'&&currency='.$currency.'&&PaypalBusinessEmail='.$PaypalBusinessEmail.'&&coursename='.$coursename.'&&shortname='.$shortname.'&&courseid='.$courseid; 
	}else{*/
	$link3=$CFG->wwwroot. '/userpolicy.php?traineeID='.$traineeID.'&&trainee_name='.$firstname.'&&lastname='.$lastname.'&&address='.$address.'&&address2='.$address2.'&&email='.$email.'&&phone='.$phone.'&&phone2='.$phone2.'&&city='.$city.'&&province='.$province.'&&postal='.$postal.'&&country='.$country.'&&cost='.$cost.'&&currency='.$currency.'&&PaypalBusinessEmail='.$PaypalBusinessEmail.'&&coursename='.$coursename.'&&shortname='.$shortname.'&&courseid='.$courseid; 	
	//}
	
	//$link=$CFG->wwwroot. '/userpolicy.php?name='.$firstname.'&middlename='.$middlename.'&lastname='.$lastname.'&dob='.$dob.'&address='.$address.'&address2='.$address2.'&title='.$title.'&email='.$email.'&phone='.$phone.'&state='.$province.'&postalcode='.$postal.'&country='.$country;
?>
<script language="JavaScript">
	function checkfield(msg){
		/*pengakuan1 = 'Please tick, if you agree with the policy.';
		elem1 = document.getElementById('pengakuan1');
			if(!elem1.checked) { 
				alert(pengakuan1);
				return false; 
			} */
			
		document.form.submit();	
		//window.opener.location.href="<?php if($paymethod == 'paypal'){echo $link;}else if($paymethod == 'creditcard'){echo $link2;}else{echo $link3;}?>";
		//window.opener.location.href="<?=$link;?>";
		//self.close();
		return true;	
				
	}
</script>
	<!--script language="JavaScript">
function checkfield(msg){
	pengakuan1 = 'Please tick, if you agree with the policy.';
	elem1 = document.getElementById('pengakuan1');
		if(!elem1.checked) { 
			alert(pengakuan1);
			return false; 
		} 
		
	document.form.submit();	
	window.opener.location.href="<?php //if($paymethod == 'paypal'){echo $link;}else if($paymethod == 'creditcard'){echo $link2;}else{echo $link3;}?>";
	self.close();
	return true;	
			
}
</script-->
<?php 
	$policyname='CIFA';
	//$policyname='SHAPE<sup>TM</sup>';
	$sqlstatement=mysql_query("SELECT * FROM mdl_cifacommunication_rules");	
	$count++;
	$count2++;
	$count3++;
	$strrequired='<font color="red">*</font>';		
?>
<form method="post" name="form"  action="<?=$link3;?>">
<table id="userpolicy"><tr><td style="align:justify;">
<table style="width:95%;margin:0 auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;"><tr><td>
<p><strong>Enter communication preferences </strong> <br /><br/>
  Please read the options in this column carefully. </p>
<table style="width:95%;margin:0 auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;">
    <?php 
		$no='1';
		while($sqlquery=mysql_fetch_array($sqlstatement)){ 
		$bil=$no++;
		if($sqlquery['visible_2']!='0'){
	?>
	<tr valign="top">
		<td>
			<input type="checkbox" name="column<?=$count++;?>" id="column<?=$count2++;?>" value="1" checked <?php if(($bil == '1') || ($bil == '3')){ echo 'disabled="disabled"';} ?> />
		</td>
		<td>
                    <?=$sqlquery['rules_text'];?>
                    <?php 
                        if($sqlquery['existingreg']!='0'){
                        echo $strrequired;
                        }	
                    ?>
		</td>
	</tr>	
	<?php }} ?>
</table></td></tr></table><br/>

</td></tr></table>
<table style="width:10%; margin:0 auto;">
<tr valign="top"><td><input type="button" style="cursor:pointer;" name="proceddnext" value=" << Next >> " onclick="checkfield()" /></td></tr>
</table>
</form>