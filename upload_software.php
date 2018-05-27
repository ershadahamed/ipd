<?php
	include('config.php');
	include('manualdbconfig.php');

	$PAGE->set_url('/');
	$PAGE->set_course($SITE);
	
	$resultupload = get_string('uploadexamresult');
	$navtitle = get_string('myexamcenter');
	$url=$CFG->wwwroot. '/offlineexam/multi_token_download.php?id='.$USER->id;
	$urlupload=$CFG->wwwroot. '/upload_software.php?id='.$USER->id;
	$PAGE->navbar->add(ucwords(strtolower($navtitle)), $url)->add(ucwords(strtolower($resultupload)), $urlupload);	

	$PAGE->set_pagetype('site-index');
	$editing = $PAGE->user_is_editing();
	$PAGE->set_title($SITE->fullname);
	$PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');

	echo $OUTPUT->header();
?>
 <style type="text/css">
<?php 
	//include('style.css'); //disabled
?>
</style>
<style>
.fileUpload {
	position: relative;
	overflow: hidden;
	margin: 10px;
	border:		2px solid #21409A;
	padding:		3px 8px !important;
	margin: 2px 0px 2px 2px;
	font-size:		12px !important;
	background-color:	#FFFFFF;
	font-weight:		bold;
	color:			#000000;	
	cursor:pointer;
	border-radius: 5px;
	min-width: 80px;	
}
.fileUpload input.upload {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;
	font-size: 20px;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}

.inputfiletype input{
	padding: 4px 12px;
	color: #000;
	border: 1px solid #D8D8D8;
	width: 250px;
}
</style>
<table style="border: 2px solid #ccc;" width="100%" height="300px"><tr><td>
 <br/><center><h3><?=get_string('examresultupload');?></h3> </center>
 <table border="0" align="center" cellspacing="0" cellpadding="0" bordercolor="#cccccc" style="border-collapse: collapse">
 <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
 	<tr>
		<td><strong><?=get_string('chooseupload');?></td><td>:</strong></td>
		<!--td><input type="file" name="file" id="file" size="30" /></td>
		<td align="center"><input type="submit" name="submit" value="<?=get_string('upload');?>" /></td-->
<td>		
<div style="text-align:center;">
<p style="display: inline;" class="inputfiletype"><input id="uploadFile" style="line-height: 16px;" type="text" disabled="disabled" placeholder="No file chosen"></p>
<div class="fileUpload btn btn-primary">
    <span>Choose file</span>
    <input id="uploadBtn" type="file" name="file" id="file" class="upload" />
</div>
</td>		
<td align="center"><input type="submit" name="submit" value="<?=get_string('upload');?>" /></td>	
		
	</tr>
 </table><br/>
 <!--//Javascipt line here -->
<p><script type="text/javascript">// <![CDATA[
document.getElementById("uploadBtn").onchange = function () {
    document.getElementById("uploadFile").value = this.value;
};
// ]]&gt;</script></p>
 </form>
 </td></tr></table><br/>
<?php
	$errors=0;
	if ( isset($_POST["submit"]) ) {

	   if ( isset($_FILES["file"])) {

				//if there was an error uploading the file
			if ($_FILES["file"]["error"] > 0) {
				//echo "<center><font color='red'>Need a file to upload, error!: " . $_FILES["file"]["error"] . "<br /></font></center><br/><br/>";
?>
<script language="javascript">
				window.alert("Need a file to upload, error!");
				window.location = "upload_software.php";
			</script>
<?php
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
				echo "<td>".$content."</td>";	
				
				$userid=$number[0];
				$examid=$number[1];
				$totalanswer=$number[2];
				$totalcorrectanswer=$number[3];
				$examtokenid=$number[4];
				$finalgrade=$number[5];							
				
				/*$username=$number[7];
				$tokenid=$number[8];				
				$grade=$number[9];
				$timemodified=$number[10];*/
				$sumgrades=$number[6];
				$timestart=$number[7];
				$timefinish=$number[8];
				$timemodified=$number[9];
				$preview=$number[10];
				$needsupgradetonewqe=$number[11];
				$cosid=$number[12];
			}
			if($examtokenid!=''){	
				//echo $examtokenid;
				$trimmed = trim($examtokenid);
				//echo $trimmed;
				//echo '<input type="text" name="ex1" value="'.$trimmed.'"/>';
				include('upload_examanwer_software.php');	
			}			
			echo "</tr>";
		}
		echo "</table>";
	}
}
?>
<?php echo $OUTPUT->footer(); ?>