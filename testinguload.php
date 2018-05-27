<table width="600">
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

<tr>
<td width="20%">Select file</td>
<td width="80%"><input type="file" name="file" id="file" /></td>
</tr>

<tr>
<td>Submit</td>
<td><input type="submit" name="submit" value="Submit" /></td>
</tr>

</form>
</table>
<?php
	$errors=0;
	if ( isset($_POST["submit"]) ) {

	   if ( isset($_FILES["file"])) {

				//if there was an error uploading the file
			if ($_FILES["file"]["error"] > 0) {
				echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

			}
			else {
					 //Print file details
				 echo "Upload: " . $_FILES["file"]["name"] . "<br />";
				 echo "Type: " . $_FILES["file"]["type"] . "<br />";
				 echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
				 echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

					 //if file already exists
				 if (file_exists("upload/" . $_FILES["file"]["name"])) {
					echo $_FILES["file"]["name"] . " already exists. ";
				 }
				 else {
						//Store file in directory "upload" with the name of "uploaded_file.txt"
				$storagename = "uploaded_file.txt";
				$storangefiles="upload/".$storagename;
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
				echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br />";
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
	if($file = fopen("upload/" . $storagename , "r")) {

		echo "File opened.<br />";

		$firstline = fgets ($file, 2048); //4096
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
		
		echo "<table border='1'>";
		echo "<tr>";
		for ($k = 0;$k != ($num+1);$k++) {
			echo "<td>" .$fields[$k]. "</td>";
		}
		echo "</tr>";
		
		$bil2='0';
		foreach ($dsatz as $key => $number) {
		$bil2++;
		//new table row for every record
			echo "<tr>";
			$bil='0';
			foreach ($number as $k => $content) {
				//new table cell for every field of the record
				$bil++;
				echo "<td>" . $content . "</td>";
				if($bil=='5'){ echo $content.'<br/>'; }
			}
			echo "</tr>";
		}
		echo "</table>";
		echo $bil.'-->'.$bil2;
	}
}
?>