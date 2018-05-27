<?php include('config.php'); include("manualdbconfig.php"); include("includes/functions.php");?>
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
	$title = $_GET['title'];
	
	$firstname = $_GET['name'];
	$lastname = $_GET['lastname'];
	$address = $_GET['address'];
	$address2 = $_GET['address2'];
	$email = $_GET['email'];
	$phone = $_GET['phone'];
	$phone2 = $_GET['phone2'];
	$province = $_GET['state'];
	$postal = $_GET['postalcode'];
	$country = $_GET['country'];
	$dob = strtotime($_GET['dob']);
	$middlename=$_GET['middlename'];
	
	$link=$CFG->wwwroot. '/userpolicy_purchase.php?name='.$firstname.'&middlename='.$middlename.'&lastname='.$lastname.'&dob='.$dob.'&address='.$address.'&address2='.$address2.'&title='.$title.'&email='.$email.'&phone='.$phone.'&phone2='.$phone2.'&state='.$province.'&postalcode='.$postal.'&country='.$country;
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

<?php 
	$policyname='CIFA';
	
	$sqlstatement=mysql_query("SELECT * FROM mdl_cifacommunication_rules");	
	//$policyname='SHAPE<sup>TM</sup>';
	$count++;
	$count2++;
	$count3++;
	$strrequired='<font color="red">*</font>';	
?>

<form method="post" name="form"  action="<?=$link;?>">
<table id="userpolicy"><tr><td style="align:justify;">
<table style="width:95%;margin:0 auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;"><tr><td>
<p><strong>Enter communication preferences </strong> <br /><br/>
  Please read the options in this column carefully. </p>
<table style="width:95%;margin:0 auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;">
    <?php 
		$no='1';
		while($sqlquery=mysql_fetch_array($sqlstatement)){ 
		$bil=$no++;
		if($sqlquery['visible_1']!='0'){
	?>
	<tr valign="top">
		<td>
			<input type="checkbox" name="column<?=$count++;?>" id="column<?=$count2++;?>" value="1" checked <?php if(($bil == '1') || ($bil == '3')){ echo 'disabled="disabled"';} ?> />
		</td>
		<td>
			<?=$sqlquery['rules_text'];?>
			<?php 
				//if($bil == '1'){ 
					if($sqlquery['firstreg']!='0'){
					echo $strrequired;
					}
				//} 
				/*if($bil == '3'){ 
					if($sqlquery['firstreg']!='0'){
					echo $strrequired;
					}
				} */				
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