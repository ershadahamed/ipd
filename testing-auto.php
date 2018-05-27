<?php
	include("manualdbconfig.php");
	include("includes/functions.php");

    require_once('config.php');
    require_once('manualdbconfig.php');
    require_once($CFG->dirroot .'/course/lib.php');
?>
<?php
	$pilihnegara=mysql_query("SELECT * FROM mdl_cifacountry_list");
?>
<script language="javascript">
function displ()
{
  if(document.formcart.country.options[0].value == true) {
	return false
  }
  else {
	//document.formcart.centrecode.value=document.formcart.country.options[document.formcart.country.selectedIndex].value;
	<?php 
	while($negara=mysql_fetch_array($pilihnegara)){ 
	?>
	if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='<?=$negara['countrycode']?>'){
		document.formcart.countrycode.value='('+'+<?=$negara['iso_countrycode'];?>'+')';
		document.formcart.centreline.value='+<?=$negara['iso_countrycode'];?>'+document.formcart.office.value;
	}
	<?php } ?>
  }
}
</script>
<form name="formcart" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onSubmit="return validate(formcart)" onClick="return displ();">
	<select id="country" name="country">
	<option value="">----- Please select country ------</option>
	<?php 
	$statement="SELECT * FROM mdl_cifacountry_list";
	$scountry=mysql_query($statement);
	while($rowcountry=mysql_fetch_array($scountry)){ 
	?>
	<option value="<?=$rowcountry['countrycode'];?>"><?=$rowcountry['countryname'];?></option>
	<?php } ?>
	</select>

	<!--input type="hidden" name="centrecode" id="centrecode" size="15" /-->
	<input type="text" name="office" id="office" size="15" />		
	<input type="text" name="countrycode" id="countrycode" size="10" readonly="readonly" style="border:0; background-color: #EFF7FB; font-weight:bold;"/>
	<input type="hidden" name="centreline" id="centreline" value="" />
<?php
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=file.csv");
	header("Pragma: no-cache");
	header("Expires: 0");

	echo "record1,record2,record3\n";

	function writeToCSV($array) {
		$i = 1;
		$j = 1;
		$fp = fopen('programmes' . $j . '.csv', 'a');
		foreach($array as $fields) {
			if ($i % 1000 == 0) {
				fclose($fp);
				$fp = fopen('programmes' . $j . '.csv', 'a');
				$j = $j + 1;
			}
			fputcsv($fp, $fields);
			$i = $i + 1;
		}
		fclose($fp);
	}

	
?>
</form>
