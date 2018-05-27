<form id="form1" name="form1" method="post" action="editCentre-exe.php">

<!-----***********************New***************************************************------------>
<br/>
<fieldset style="border:1px solid #000000; width: 95%; margin-right: auto; margin-left: auto;">
	<legend style="font-weight: bold; margin: 0 10px 0 10px; padding:0 10px 0 10px;">Edit exam center</legend>
	<div style="padding:20px; float: left; width:100%;">

<?php		
	include('../manualdbconfig.php');
	
	$ID=$_GET['id'];
	$sqlCheck="Select
  						*
					From
  						mdl_cifa_exam Where id='$ID'";
	$queryCheck=mysql_query($sqlCheck);
	$rowCheck=mysql_fetch_array($queryCheck)
?>
	
	<table width="100%" style="border: 2px solid #FFF;">
	<tr style="border: 2px solid #FFF;">
		<td width="20%" style="border: 2px solid #FFF;">Centre code</td>
		<td width="1%" style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;">
		<?php echo $rowCheck['centre_code']; ?>
		</td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Centre name</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="centreName" id="centreName" size="40" value="<?php echo $rowCheck['centre_name']; ?>" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Address 1</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="address1" id="address1" size="40" value="<?php echo $rowCheck['address']; ?>" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Address 2</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="address2" id="address2" size="40" value="<?php echo $rowCheck['address2']; ?>" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">State</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="state" id="state" size="40" value="<?php echo $rowCheck['state']; ?>" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">City</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="city" id="city"  size="40" value="<?php echo $rowCheck['city']; ?>" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Zip code</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="zip" id="zip" maxlength="5" size="40" value="<?php echo $rowCheck['zip']; ?>" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Telephone no.</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="office" id="office" size="40" value="<?php echo $rowCheck['phone']; ?>" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Fax no.</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="fax" id="fax" size="40" value="<?php echo $rowCheck['fax']; ?>" /></td>
	</tr>
	<tr style="border: 2px solid #FFF;">
		<td style="border: 2px solid #FFF;">Email</td>
		<td style="border: 2px solid #FFF;">:</td>
		<td style="border: 2px solid #FFF;"><input type="text" name="email" id="email" size="40" value="<?php echo $rowCheck['email']; ?>" /></td>
	</tr>
	</table>
	</div>
</fieldset>
<div style="padding:10px; width:100%; text-align:center;">
<button><a href="../manage_exam_index.php?categoryedit=off">Back</a></button>
<input type="submit" name="submit" value="Save" />
</div>
	<?php
	//if(isset($_POST['submit'])=='Save'){
	?>
	<!-- <div style="padding-left:20px; float: left; width:100%;"> -->
	<?php
		//include('editCentre-exe.php');
	?>
	<!-- </div> -->
	<?php
	//}
	?>
</form>
