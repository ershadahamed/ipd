<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	
	$output_dir = "logo/";
	$organizationid=$_POST['organizationid'];
        $code = optional_param('code', '', PARAM_INT);
	global $DB;
	if(isset($_FILES["myfile"]))
	{
		//Filter the file types , if you want.
		if ($_FILES["myfile"]["error"] > 0)
		{
		  echo "Error: " . $_FILES["file"]["error"] . "<br>";
		}
		else if($_FILES['myfile']['size'] > (1024000)) //can�t be larger than 1 MB
		{
			echo "Oops! Your file\�s size is to large.";
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
			$now=strtotime('now');
			
			$sql="Select * From {organization_logo} Where organizationid='".$organizationid."'";
			$data=$DB->get_record_sql($sql);	
			
			$sql = "Select COUNT(DISTINCT id) From {organization_logo} Where organizationid='".$organizationid."'";
			$usercount = $DB->count_records_sql($sql);
			if(empty($usercount)){
				$qsimpan=mysql_query("
					INSERT INTO mdl_cifaorganization_logo 
					SET organizationid='".$organizationid."', logo='".$fileupload."', path_logo='".$path."', timecreated='".$now."'");	
			
                                if($code==2){
                                    // update record di organization_type table
                                    $upduser = new stdClass();
                                    $upduser->id = $organizationid;
                                    $upduser->logo = $fileupload;
                                    $upduser->path_logo = $path;
                                    $saverecord2 = $DB->update_record('organization_type', $upduser);
                                }  
                        }else{			
			// update record di organization_logo table
				$logoorg = new stdClass();
				$logoorg->id = $data->id;
				$logoorg->logo = $fileupload;
				$logoorg->path_logo = $path; 
				$logoorg->timemodified = time(); 
				$qsimpan = $DB->update_record('organization_logo', $logoorg);	

				// update record di organization_type table
				$upduser = new stdClass();
				$upduser->id = $organizationid;
				$upduser->logo = $fileupload;
				$upduser->path_logo = $path;
				$saverecord2 = $DB->update_record('organization_type', $upduser);				
			}
			
			if($qsimpan){ 
				echo 'Registration success. Thank you.<br />';		
				echo "Uploaded File :".$_FILES["myfile"]["name"];

?>
				<script type="text/javascript">
				window.alert('Uploaded success. Thank you');
                                <?php if($code==2){ ?>
                                window.opener.location='<?=$CFG->wwwroot. "/organization/orgview.php?formtype=Organization&id=".$organizationid."&display=organizationdetails&code=".$code;?>';
                                <?php } ?>
                                window.close();
				
				// window.location.href = '<?=$CFG->wwwroot. "/financialinstituition/list_ofregistration_admin.php";?>';   
				</script>	
<?php				
				
				
			}else{
				echo 'Registration Fail. Thank you.<br />';
?>
				<script type="text/javascript">
				window.alert('Uploaded Fail. Thank you')
				//window.location.href = '<?=$CFG->wwwroot. "/contactus/upload_index.php";?>';   
				</script>	
<?php				
			}
		}

	}
?>