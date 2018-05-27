<?php
include('config.php');
include('manualdbconfig.php');

//define a maxim size for the uploaded images in Kb
 define ("MAX_SIZE","30000"); 

//This function reads the extension of the file. It is used to determine if the file  is an image by checking the extension.
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

//This variable is used as a flag. The value is initialized with 0 (meaning no error  found)  
//and it will be changed to 1 if an errro occures.  
//If the error occures the file will not be uploaded.
 $errors=0;
//checks if the form has been submitted
 if(isset($_POST['Submit'])) 
 {
 	//reads the name of the file the user submitted for uploading
 	$myfile=$_FILES['myfile']['name'];
 	//if it is not empty
 	if (!$myfile) 
 	{?>
				<script language="javascript">
					window.alert("Need a file to upload!");
				</script>
	<?php
		$errors=1;
	}
	else
	{
 	//get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['myfile']['name']);
 	//get the extension of the file in a lower case format
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
 	//if it is not a known extension, we will suppose it is an error and will not  upload the file,  
	//otherwise we will do more tests
	if (($extension != "txt") && ($extension != "doc") && ($extension != "docx") && ($extension != "pdf") && ($extension != "zip") && ($extension != "rar")) 
 		{
		//print error message
 			//echo '<h1>Unknown extension!</h1>';
			?>
				<script language="javascript">
					window.alert("Unknown extension!");
				</script>
			<?php
 			$errors=1;
 		}
 		else
 		{
			//get the size of the image in bytes
			//$_FILES['image']['tmp_name'] is the temporary filename of the file
			//in which the uploaded file was stored on the server
			$size=filesize($_FILES['myfile']['tmp_name']);

			//compare the size with the maxim size we defined and print error if bigger
			if ($size > MAX_SIZE*1024)
			{
				//echo '<h1>You have exceeded the size limit!</h1>';
			?>
				<script language="javascript">
					window.alert("You have exceeded the size limit!");
				</script>
			
			<?php
				$errors=1;
		}

		//we will give an unique name, for example the time in unix time format
		$file_name=time().'.'.$extension;
		//the new name will be containing the full path where will be stored (images folder)
		//$newname="images/".$file_name;
		//$newname=$CFG->wwwroot. '/uploadfiles/'.$myfile;
		$newname=$myfile;
		//we verify if the image has been uploaded, and print error instead
		$copied = move_uploaded_file($_FILES['myfile']['tmp_name'], $newname);
			if (!$copied) 
			{
			?>
			<script language="javascript">
				window.alert("Copy unsuccessfull!!");
			</script>
			<?php
			$errors=1;
			}
		}
	}
}

//If no errors registred, print the success message
 if(isset($_POST['Submit']) && !$errors) 
 {
	include('upload_examanwer_software.php');	
 }

 ?>

 <!--next comes the form, you must set the enctype to "multipart/frm-data" and use an input type "file" -->
    <?php
	$PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = get_string('uploadresult');
    $PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	
    echo $OUTPUT->header();?>
	
	<table style="border: 2px solid #ccc;" width="100%" height="350px"><tr><td>
	 <form name="newad" method="post" enctype="multipart/form-data"  action="">
	 <br/><center><h3><?=get_string('uploadresult');?></h3> </center>
	 <table border="0" align="center" cellspacing="0" cellpadding="0" bordercolor="#cccccc" style="border-collapse: collapse">
		<tr>
			<td><strong><?=get_string('chooseafile');?></td><td>:</strong></td><td> <input type="file" name="myfile" size="30"></td><td align="center"><input name="Submit" type="submit" value="<?=get_string('upload');?>"></td>
		</tr>
	 </table><br/>
	 </form>
	 </td></tr></table><br/>
<?php echo $OUTPUT->footer();?>