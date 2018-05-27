<?php
	include('config.php');
	include('manualdbconfig.php');

	$PAGE->set_url('/');
	$PAGE->set_course($SITE);

	$listusertoken = get_string('uploadresult');
	$PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

	$PAGE->set_pagetype('site-index');
	$editing = $PAGE->user_is_editing();
	$PAGE->set_title($SITE->fullname);
	$PAGE->set_heading($SITE->fullname);

	echo $OUTPUT->header();
?>
 <style type="text/css">
<?php 
	include('style.css');
?>
</style>
<table style="border: 2px solid #ccc;" width="100%" height="300px"><tr><td>
 <br/><center><h3>Upload Candidate Info</h3> </center>
 <table border="0" align="center" cellspacing="0" cellpadding="0" bordercolor="#cccccc" style="border-collapse: collapse">
 <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
 	<tr>
		<td><strong>Choose a file to upload</td><td>:</strong></td>
		<td><input type="file" name="file" id="file" size="30" /></td>
		<td align="center"><input type="submit" name="submit" value="Upload candidate" /></td>
	</tr>
 </table><br/>
 </form>
 </td></tr></table><br/>
<?php
	$errors=0;
	if ( isset($_POST["submit"]) ) {

	   if ( isset($_FILES["file"])) {

				//if there was an error uploading the file
			if ($_FILES["file"]["error"] > 0) {
				echo "<center>Need a file to upload, error!: " . $_FILES["file"]["error"] . "<br /></center>";

			}
			else {
				 //Print file details
				 echo "Upload: " . $_FILES["file"]["name"] . "<br />";
				 echo "Type: " . $_FILES["file"]["type"] . "<br />";
				 echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
				 echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

				 //if file already exists
				 if (file_exists("uploadfiles/" . $_FILES["file"]["name"])) {
					echo $_FILES["file"]["name"] . " already exists. ";
				 }
				 else {
				 //Store file in directory "upload" with the name of "result_software.txt"
				 $storagename = "result_software.txt";
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
				 echo "Stored in: " . "uploadfiles/" . $_FILES["file"]["name"] . "<br />";
				}
			}
		 } else {
				 echo "No file selected <br />";
		 }
	}
?>
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
		
		echo "<table border='1' id='listcandidate'>";
		echo "<tr>";
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
				echo "<td>" . $content . "</td>";	
				
				$itemid=$number[0];
				$userid=$number[1];
				$usermodified=$number[2];
				$finalgrade=$number[3];
				$rawgrade=$number[4];
				$timecreated=$number[5];				
				
				$quizid=$number[6];
				$username=$number[7];
				$tokenid=$number[8];				
				$grade=$number[9];
				$timemodified=$number[10];

				$uniqueid=$number[11];
				$attempt=$number[12];
				$sumgrades=$number[13];
				$timestart=$number[14];
				$timefinish=$number[15];
				$layout="";
				$preview=$number[16];
				$needsupgradetonewqe=$number[17];		
			}
			if($tokenid!=''){
			include('upload_examanwer_software.php');	
			}			
			echo "</tr>";
		}
		echo "</table>";
	}
}
?>
<?php echo $OUTPUT->footer(); ?>