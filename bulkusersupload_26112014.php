<?php
	include('config.php');
	include('manualdbconfig.php');

	$PAGE->set_url('/');
	$PAGE->set_course($SITE);


	$siteadmin='Site Administrator';
	$siteusers='Users';
	$siteaccounts='Accounts';
	$bulkupload = get_string('uploadusers', 'admin');
	$url=$CFG->wwwroot. '/bulkusersupload.php?id='.$USER->id;
	if($USER->id !='2'){
	$PAGE->navbar->add(ucwords(strtolower($bulkupload)), $url);	
	}else{
	$PAGE->navbar->add(ucwords(strtolower($bulkupload)), $url);
	}

	$PAGE->set_pagetype('site-index');
	$editing = $PAGE->user_is_editing();
	$PAGE->set_title($SITE->fullname);
	$PAGE->set_heading($SITE->fullname);
	//if($USER->id !='2'){
		$PAGE->set_pagelayout('buy_a_cifa');
	//}

	echo $OUTPUT->header();
?>
 <style type="text/css">
<?php 
	include('style.css');
?>
</style>
<table style="border: 2px solid #ccc;" width="100%" height="300px"><tr><td>
 <br/><center><h3><?=ucwords(strtolower(get_string('uploadusers', 'admin')));?></h3> </center>
 <table border="0" align="center" cellspacing="0" cellpadding="0" bordercolor="#cccccc" style="border-collapse: collapse">
 <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
 	<tr>
		<td><strong>File To Upload</td><td>:</strong></td>
		<td><input type="file" name="file" id="file" size="30" /></td>
		<td align="center"><input type="submit" name="submit" value="<?=get_string('uploadusers', 'admin');?>" /></td>
	</tr>
 </table><br/>
 </form>
<?php
	$errors=0;
	if ( isset($_POST["submit"]) ) {

	   if ( isset($_FILES["file"])) {

				//if there was an error uploading the file
			if ($_FILES["file"]["error"] > 0) {
				echo "<center><font color='#FF0000'>Need a file to upload, error!: " . $_FILES["file"]["error"] . "<br /></font></center>";

			}
			else {
				 //Print file details
				 //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
				 //echo "Type: " . $_FILES["file"]["type"] . "<br />";
				 //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
				 //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

				 //if file already exists
				 if (file_exists("uploadfiles/" . $_FILES["file"]["name"])) {
					echo $_FILES["file"]["name"] . " already exists. ";
				 }
				 else {
				 //Store file in directory "upload" with the name of "result_software.txt"
				 $storagename = "bulkusersupoad.txt";
				 $storangefiles="uploadfiles/".$storagename;
				 $copied=move_uploaded_file($_FILES["file"]["tmp_name"], $storangefiles);
				 if (!$copied) 
					{
					?>
						<script language="javascript">
							window.alert("Copy unsuccessfull!!");
						</script>
					<?php
						$errors=1;
					}
				 //echo "Stored in: " . "uploadfiles/" . $_FILES["file"]["name"] . "<br />";
				}
			}
		 } else {
				 echo "No file selected <br />";
		 }
	}
?>
 </td></tr></table><br/>
<?php
//If no errors registred, print the success message
if(isset($_POST['submit']) && !$errors) 
{
	if($file = fopen("uploadfiles/" . $storagename , "r")) {

		//echo "File opened.<br />";

		$firstline = fgets ($file, 4096); //4096//2048
		//Gets the number of fields, in CSV-files the names of the fields are mostly given in the first line
		$num = strlen($firstline) - strlen(str_replace(";", "", $firstline));

		//save the different fields of the firstline in an array called fields
		$fields = array();
		$fields = explode(";", $firstline, ($num+1));

		$line = array();
		$i = 0;

		//CSV: one line is one record and the cells/fields are seperated by ";"
		//so $dsatz is an two dimensional array saving the records like this: $dsatz[number of record][number of cell]
		while ($line[$i] = fgets($file, 4096)) {

			$dsatz[$i] = array();
			$dsatz[$i] = explode( ";", $line[$i], ($num+1));

			$i++;
		}
		if($i!=0){
		echo "<h3>".ucwords(strtolower(get_string('uploaduserspreview', 'admin')))."(Successful)</h3>";
		echo "<table border='1' id='listcandidate'>";
		echo "<tr style='background-color:#ccc; font-weight:bolder;'>";
		for ($k = 0;$k != ($num+1);$k++) {
			echo "<td>" .$fields[$k]. "</td>";
			//$fields=$fields[$k];
		}
		echo "</tr>";
		foreach ($dsatz as $key => $number) {
		//new table row for every record
			echo "<tr>";
			foreach ($number as $k => $content) {
				//new table cell for every field of the record
				echo "<td>".$content."</td>";	
				
				$staffid=$number[0];
				$firstname=$number[1];
				$lastname=$number[2];
				$gender=$number[3];
				$dob=strtotime($number[4]);
				$email=$number[5];
				$department=$number[6];
				$designation=$number[7];
				$institution=$number[8];
				
				$address1=$number[9];
				$address2=$number[10];
				$address3=$number[11];
				$city=$number[12];
				$postcode=$number[13];
				
				$country=trim($number[14]);
				$phone=$number[15];
				$organization=$number[16];				
				$roleid=$number[17];				
				
			}
			include('uploadbulkusers.php');
			echo "</tr>";
		}
		echo "</table><br/><br/>";}
	}
}
?>
<?php echo $OUTPUT->footer(); ?>