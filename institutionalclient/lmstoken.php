<?php 
	//require_once('../manualdbconfig.php');

	/*$sql2="
			Select
			  a.id,
			  a.dob,
			  b.userid,
			  a.firstname,
			  a.lastname,
			  c.courseid,
			  a.lms_token,
			  a.traineeid,
			  a.offline_id,
			  a.email,
			  d.fullname,
			  d.id As courseid2
			From
			  mdl_cifauser a,
			  mdl_cifauser_enrolments b,
			  mdl_cifaenrol c,
			  mdl_cifacourse d,
			  mdl_cifa_exam e
			Where
			  a.id = b.userid And
			  c.id = b.enrolid And   
			  c.courseid = d.id And
			  d.examcentrecode = e.centre_code
	";*/
	
	$sql2="
			Select
			  a.dob,
			  b.userid,
			  a.firstname,
			  a.lastname,
			  c.courseid,
			  a.traineeid,
			  d.fullname,
			  d.id As courseid2
			From
			  mdl_cifauser a,
			  mdl_cifauser_enrolments b,
			  mdl_cifaenrol c,
			  mdl_cifacourse d
			Where
			  a.id = b.userid And
			  c.id = b.enrolid And
			  c.courseid = d.id	
	";
	$query2=mysql_query($sql2);
	$bil=1;
	$b=1;
	while($row2=mysql_fetch_array($query2)){

		//generate number token
		$sa = $row2['courseid2'];
		$f = $sa + 1;
		$a = 'CIFA';
		$c = date('Y');
		$e = date('m');
		$traineeid=$row2['traineeid'];
		$examid=$row2['courseid'];
		$b++;
	
		if($b<10 && $f<10 && $examid<10)
			$d = '0000';
		else if($b<100 && $f<100 && $examid<100)
			$d = '000';
		else if($b<1000 && $f<1000 && $examid<1000)
			$d = '00';
		else if($b<10000)
			$d = '0';
		else if($b<100000)
			$d = '';
		else{
			}
										
		$generate_token = $a.'_'.$d.$examid.'_'.$traineeid.' / '.$c.' '.$e;	
	?>
	
	<input type="hidden" name="token" value="<?php echo $generate_token; ?>" />
	<?php
	
		//$lmstoken=mysql_query("UPDATE mdl_cifauser SET lms_token='".$generate_token."' WHERE id='".$row2['id']."' AND traineeid='".$row2['traineeid']."'");
		//$clientSQL=mysql_query("SELECT * FROM mdl_cifainstitutionaltoken");
		//$clientRow=mysql_fetch_array($clientSQL);
		
		$roleSQL=mysql_query("Select * From mdl_cifarole_assignments WHERE userid='".$row2['userid']."'");
		$roleCheck=mysql_fetch_array($roleSQL);
		if($roleCheck['roleid'] == '5'){
		
			$sqlSemak="Select * From mdl_cifainstitutionaltoken";
			$querySemak=mysql_query($sqlSemak);
			$rowSemak=mysql_fetch_array($querySemak);
			$rs=mysql_num_rows($querySemak);
			//echo $rs;
			//if(($rs > '0')){
					//if(($rowSemak['moduleid'] != $row2['courseid']) || ($rowSemak['candidateid'] != $row2['traineeid'])){
						$currenttime=strtotime('now');
						$lmstoken="
							INSERT INTO mdl_cifainstitutionaltoken 
							SET userid='".$row2['userid']."', candidateid='".$row2['traineeid']."', 
								firstname='".$row2['firstname']."', lastname='".$row2['lastname']."', dob='".$row2['dob']."', dateregister='".$currenttime."',
								moduleid='".$row2['courseid']."', modulename='".$row2['fullname']."', lmstoken='".$generate_token."'";	
						$lmstoken .= "WHERE lmstoken!='".$generate_token."'";
						$lmsquery=mysql_query($lmstoken);
					//}
			/*}else{
				
					$lmstoken="
						INSERT INTO mdl_cifainstitutionaltoken 
						SET userid='".$row2['userid']."', candidateid='".$row2['traineeid']."', 
							firstname='".$row2['firstname']."', lastname='".$row2['lastname']."', dob='".$row2['dob']."', dateregister=now(),
							moduleid='".$row2['courseid']."', modulename='".$row2['fullname']."', lmstoken='".$generate_token."'";	
					$lmsquery=mysql_query($lmstoken);
			}*/
		}
	}
?>  