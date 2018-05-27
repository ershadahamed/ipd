<?php
	include('../config.php');
	include('../manualdbconfig.php');
		
		$scheduling=$_POST['radio'];
		$rid=$_POST['hiddenreportid'];
		$startdatepicker=$_POST['startdatepicker'];
		$enddatepicker=$_POST['enddatepicker'];
		
		if($scheduling=='weekly'){
			$a=$_POST['recipientweekly'];
		}else if($scheduling=='monthly'){
			$a=$_POST['recipientmonthly'];
		}else{
			$a=$_POST['daily'];
		}
					
		if($_POST['checktoken'] != ""){
			$checkBox = $_POST['checktoken'];

			// Delete uncheck users
			$s2=mysql_query("SELECT * FROM {$CFG->prefix}report_recipient WHERE scheduling_id='".$_GET['scheduling_id']."'");
			for($i=0; $i<sizeof($checkBox); $i++){
				while($sm2=mysql_fetch_array($s2)){
					$ab=$sm2['recipient_id'];	
					if($ab!=$checkBox[$i]){ 
						// echo $ab;
						$de=mysql_query("DELETE FROM {$CFG->prefix}report_recipient WHERE scheduling_id='".$_GET['scheduling_id']."' AND recipient_id='".$ab."'");
					}
				}
			} // End delete
			
			$supdate=mysql_query("UPDATE mdl_cifareport_scheduling SET scheduling='".$scheduling."', scheduling_value='".$a."' WHERE id='".$_GET['scheduling_id']."' AND rid='".$_GET['rid']."'");
			$sureportoption=mysql_query("UPDATE {$CFG->prefix}report_option SET tlstartdate='".$startdatepicker."', tlenddate='".$enddatepicker."' WHERE reportid='".$_GET['rid']."'");
			
		
			for($i=0; $i<sizeof($checkBox); $i++){				
				// to get a role name
				$squery=mysql_query("SELECT name FROM {$CFG->prefix}role WHERE id='5'");
				$sqlrole=mysql_fetch_array($squery);
				$usertypename=$sqlrole['name'];			
				//$checkBox[$i].'<br/>';
								
				$statement="
				  mdl_cifacourse a Inner Join
				  mdl_cifaenrol b On a.id = b.courseid Inner Join
				  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
				  mdl_cifauser d On c.userid = d.id Inner Join
				  mdl_cifauser_accesstoken e On b.courseid = e.courseid And e.userid = d.id	
				";
				
				$statement.=" WHERE a.category = '3' AND d.usertype='".$usertypename."' And d.id='".$checkBox[$i]."'";
				$sql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";			
				
				$result=mysql_query($sql);
				if(mysql_num_rows($result)!='0'){
					$data=mysql_fetch_array($result);	
					$candidateid=$data['userid'];
					$firstname=$data['firstname'];
					$lastname=$data['lastname'];
					$dob=$data['dob'];
					$organization=$data['orgtype'];
										
					$s=mysql_query("SELECT * FROM {$CFG->prefix}report_recipient WHERE scheduling_id='".$_GET['scheduling_id']."' AND recipient_id='".$candidateid."'");				
					$sc=mysql_num_rows($s);
					$sm=mysql_fetch_array($s);
					// echo $ab=$sm['recipient_id'];					

					if($sc!='0'){  // if we have record
						$qreportgroup=mysql_query("UPDATE {$CFG->prefix}report_recipient SET scheduling_id='".$_GET['scheduling_id']."', recipient_id='".$candidateid."'
						WHERE scheduling_id='".$_GET['scheduling_id']."' AND recipient_id='".$candidateid."'");									
					}
					
					if($sc!='1'){
						// insert into mdl_cifareport_users
						$qreportgroup2=mysql_query("INSERT INTO {$CFG->prefix}report_recipient(scheduling_id, recipient_id) 
						VALUES('".$_GET['scheduling_id']."', '".$candidateid."')");									
					}					
				}
			}	
		}
	$url=$CFG->wwwroot. '/examcenter/schedulling.php?id='.$USER->id.'&rid='.$_GET['rid'];
?>
	<script language="javascript">
		window.alert("Schedule has been updated.");
		window.location.href = '<?=$url;?>'; 
	</script>