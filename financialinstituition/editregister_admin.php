<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	$output_dir = "logo/";
	
	$groupofinstitution=$_POST['groupofinstitution'];
	$inst_name=$_POST['inst_name'];
	$inst_address=$_POST['inst_address'];
	$inst_address2=$_POST['inst_address2'];
	$inst_address3=$_POST['inst_address3'];
	$icity=$_POST['inst_city'];
	$izip=$_POST['inst_zip'];
	$istate=$_POST['inst_state'];
	$icountry=$_POST['inst_country'];
	$inst_telephone=$_POST['inst_telephone'];
	$inst_faxs=$_POST['inst_faxs'];
	$inst_website=$_POST['inst_website'];
	$organization_type=$_POST['organization_type'];
	$inst_id=$_POST['inst_id'];
	$now=strtotime('now');
	
	$sqlroles=mysql_query("SELECT name FROM {$CFG->prefix}role WHERE id='".$organization_type."'");
	$qroles=mysql_fetch_array($sqlroles);
	$org_typename= $qroles['name'];
	
	if(isset($_FILES["myfile"]))
	{
		//Filter the file types , if you want.
		if ($_FILES["myfile"]["error"] > 0)
		{
		  echo "Error: " . $_FILES["file"]["error"] . "<br>";
		}
		else if($_FILES['myfile']['size'] > (1024000)) //can’t be larger than 1 MB
		{
			echo "Oops! Your file\’s size is to large.";
		?>
				<script type="text/javascript">
				window.alert('Oops! Your file`s size is to large.')  
				</script>	
		<?php				
		}		
		else
		{
			//move the uploaded file to uploads folder;
			move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $_FILES["myfile"]["name"]);
			$path=$output_dir.$_FILES["myfile"]["name"];
			$fileupload=$_FILES["myfile"]["name"];
			
						
			$qsimpan=mysql_query("
				UPDATE mdl_cifaorganization_type 
				SET groupofinstitution='".$groupofinstitution."', name='".$inst_name."', address='".$inst_address."' ,address_line2='".$inst_address2."', address_line3='".$inst_address3."',
				city='".$icity."', state='".$istate."', zip='".$izip."', country='".$icountry."',
				telephone='".$inst_telephone."', faxs='".$inst_faxs."', website='".$inst_website."', 
				org_type='".$organization_type."', org_typename='".$org_typename."', logo='".$fileupload."', path_logo='".$path."', timecreated='".$now."'
				WHERE id='".$inst_id."'
			");	
			
			if($qsimpan){ 
				echo 'Registration success. Thank you.<br />';		
				echo "Uploaded File :".$_FILES["myfile"]["name"];

?>
				<script type="text/javascript">
				window.alert('Update success. Thank you')
				window.location.href = '<?=$CFG->wwwroot. "/financialinstituition/list_ofregistration_admin.php";?>';   
				</script>	
<?php				
				
				
			}else{
				echo 'Registration Fail. Thank you.<br />';
?>
				<script type="text/javascript">
				window.alert('Update Fail. Thank you')
				//window.location.href = '<?=$CFG->wwwroot. "/contactus/upload_index.php";?>';   
				</script>	
<?php				
			}
		}

	}
	
	if($_FILES["myfile"]==''){ //only contact us details without upload files
		$qsimpan=mysql_query("
				UPDATE mdl_cifaorganization_type 
				SET groupofinstitution='".$groupofinstitution."', name='".$inst_name."', address='".$inst_address."',address_line2='".$inst_address2."', address_line3='".$inst_address3."',
				city='".$icity."', state='".$istate."', zip='".$izip."', country='".$icountry."', telephone='".$inst_telephone."', faxs='".$inst_faxs."', 
				website='".$inst_website."', org_type='".$organization_type."', org_typename='".$org_typename."', timecreated='".$now."' WHERE id='".$inst_id."'");		
				
		if($qsimpan){ 
			//echo 'File has been send to us.<br />';
?>
			<script type="text/javascript">
			window.alert('Registration success. Thank you.')
			window.location.href = '<?=$CFG->wwwroot. "/financialinstituition/list_ofregistration_admin.php";?>';   
			</script>	
<?php		
			//echo "Uploaded File :".$_FILES["myfile"]["name"];
		}else{
			//echo 'Your file fail to send.<br />';
?>
			<script type="text/javascript">
			window.alert('Registration fail. Thank you')
			//window.location.href = '<?=$CFG->wwwroot. "/contactus/upload_index.php";?>';   
			</script>	
<?php			
		}					
	}
?>