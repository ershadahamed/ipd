<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	
	$output_dir = "logo/";
	$uid=optional_param('id', '', PARAM_INT);
        $attachmentid = optional_param('aid', '', PARAM_INT);
        $formtype = optional_param('type', '', PARAM_MULTILANG);
        
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
                        
                        if(!empty($attachmentid)){
                            $esql = " And id='".$attachmentid."'";
                        }else{
                            $esql = " And attachmentid=''";
                            
                        }			
			$sql="Select * From {support_attachment} Where userid='".$uid."'";
                        $sql .= $esql;
			$data=$DB->get_record_sql($sql);	
			
			$sql = "Select COUNT(DISTINCT id) From {support_attachment} Where userid='".$uid."'";
                        $sql .= $esql;
			$usercount = $DB->count_records_sql($sql);
                        
                        if($formtype == get_string('user')){
                            $usertype = '5';
                            $display ='userdetails';
                        }elseif($formtype == get_string('organization')){
                            $usertype = '6';
                            $display = 'organizationdetails';
                        }                     
                        
			if(empty($usercount)){
				$qsimpan=mysql_query("
					INSERT INTO mdl_cifasupport_attachment 
					SET usertype='".$usertype."' ,userid='".$uid."', attachment='".$fileupload."', attachment_path='".$path."', timecreated='".$now."'");	
			}else{			
			// update record
				$logoorg = new stdClass();
				$logoorg->id = $data->id;
				$logoorg->attachment = $fileupload;
				$logoorg->attachment_path = $path; 
				$logoorg->timemodified = time(); 
				$qsimpan = $DB->update_record('support_attachment', $logoorg);					
			}
			
			if($qsimpan){ 
				echo 'Upload successful. Thank you.<br />';		
				echo "Uploaded File :".$_FILES["myfile"]["name"];
?>
                                
				<script type="text/javascript">
				window.alert('Uploaded success. Thank you');
                                <?php if(!empty($attachmentid)){ ?>
                                    window.opener.location='<?=$CFG->wwwroot. "/organization/orgview.php?formtype=".$formtype."&id=".$uid."&display=".$display."&supportform=Attachment";?>';
                                <?php } ?>				
    window.close();
				
				// window.location.href = '<?//=$CFG->wwwroot. "/financialinstituition/list_ofregistration_admin.php";?>';   
				</script>	
<?php				
				
				
			}else{
				echo 'Upload Fail. Thank you.<br />';
?>
				<script type="text/javascript">
				window.alert('Uploaded Fail. Thank you')  
				</script>	
<?php				
			}
		}

	}
?>