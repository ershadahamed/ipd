<?php
	//insert student data
	//enrol feedback & chat room
	
	$cekstude=mysql_query("SELECT * FROM mdl_cifauser WHERE deleted='0' AND suspended='0' AND email='".$email."' AND country='".$country."' AND dob='".$dob."'");
	$studentnow=mysql_num_rows($cekstude);
	echo 'te-'.$studentnow.'<br/>';
	
	if($studentnow<='0'){
		//candidates ID for new users
		$selectusers=mysql_query("SELECT * FROM mdl_cifauser WHERE suspended='0' ORDER BY id DESC");
		$usercount=mysql_num_rows($selectusers);
		$userrec=mysql_fetch_array($selectusers);
		$tid=$userrec['id']+'1';
		$month=date('m');
		$year=date('y');
		
		if($userrec['id'] <= '9'){ 
			$c='00';
		}
		elseif($userrec['id'] >= '10' && $userrec['id'] <= '99'){ 
			$c='0';
		}else{
			$c='';
		}
		
		//final candidates ID generate// candidate start with A
		$candidateID='A'.$year.''.$c.''.$tid.''.$country;
		
		// getting a password
		$textpword=get_string('temporarypassword');
		$password=md5($textpword);
		$timecreated = strtotime('now');
		$lastcreated = strtotime("now" . " + 1 year");	
		
		// getting a gender
		if($gender=='male'){$g='0';}else{$g='1';}
		
		// getting a role name
		$srole=mysql_query("SELECT name FROM mdl_cifarole WHERE id='".$roleid."'");
		$rwrole=mysql_fetch_array($srole);
		$usertype=$rwrole['name'];	
			
		//adding user to mdl_cifauser
		$sqlReg="INSERT INTO mdl_cifauser
			SET username='".$candidateID."', password='".$password."', firstname='".$firstname."', lastname='".$lastname."',empname='".$institution."',
			  email='".$email."', traineeid='".$candidateID."', dob='".$dob."', mnethostid='1', confirmed='1', descriptionformat='1', gender='".$g."', department='".$department."', designation='".$designation."', institution='".$institution."',
			  timecreated='".$timecreated."', lasttimecreated='".$lastcreated."', usertype='".$usertype."', phone1='". $phone."', address='".$address1."', address2='".$address2."', address3='".$address3."', country='".$country."', city='".$city."', 
			  orgtype='".$organization."', access_token='".$staffid."', postcode='".$postcode."'
		";
		$sqlRegQ=mysql_query($sqlReg) or die("sql gagal<br/>" .mysql_error());	
		$usercandidateid=mysql_insert_id();
		
		//force change password
		if($sqlRegQ){
			$forcechangepwd=mysql_query("INSERT INTO mdl_cifauser_preferences SET userid='".$usercandidateid."', name='auth_forcepasswordchange', value='1'");
		}	
		
		//insert user program IPD@CIFA
		$userprogram=mysql_query("INSERT INTO mdl_cifauser_program SET userid='".$usercandidateid."', programid='1', programname='Shape Ipd'");
		
			// AUTO ENROLL CHAT(6) // FEEDBACK(4) // MOCK TEST(9) // FINAL TEST(3)
			$sqlchat=mysql_query("
				Select
				  b.enrol,
				  a.fullname,
				  b.courseid,
				  b.id as enrolid
				From
				  mdl_cifacourse a Inner Join
				  mdl_cifaenrol b On a.id = b.courseid
				Where
				  b.enrol = 'manual' And a.visible!='0' And
				  (a.category = '3' Or a.category='4' Or a.category='6' Or a.category = '9')	
			");		
					
			while($chatting=mysql_fetch_array($sqlchat)){
				$chatenrolid=$chatting['enrolid'];
				$today=strtotime('now');
				$expiring_date=strtotime('now + 2 months'); //expiring date
							
				$chatenrol=mysql_query("INSERT INTO mdl_cifauser_enrolments 
				SET enrolid='".$chatenrolid."', userid='".$usercandidateid."', timestart='".$today."', timeend='".$expiring_date."', timecreated='".$today."', timemodified='".$today."', modifierid='2', emailsent='1'");			
			
				//to define exam contextid
				$sexam=mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='".$chatting['courseid']."'");
				$Le=mysql_fetch_array($sexam);
				$examcontextid=$Le['id'];
									
				$userassignments=mysql_query("SELECT * FROM {$CFG->prefix}role_assignments WHERE roleid='5' AND userid='".$usercandidateid."' AND contextid='".$examcontextid."'");
				$cuseruserassignments=mysql_num_rows($userassignments);
				if($cuseruserassignments=='0'){
					$sqlassignexam=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='5', contextid='".$examcontextid."', userid='".$usercandidateid."', modifierid='2', timemodified='".$today."'");
				}
									
				//update token, center ID, token start date, token expiry
				$selectusertoken=mysql_query("SELECT * FROM {$CFG->prefix}user_accesstoken WHERE userid='".$usercandidateid."' AND courseid='64'");
				$cusertoken=mysql_num_rows($selectusertoken);
				if($cusertoken=='0'){
					$access_token=uniqid(rand());
					$tokencreated=strtotime('now'); //token start
					$tokenexpiry=strtotime(date('d-m-Y H:i:s',$tokencreated) . " + 2 month"); //token expiry
					
					$sqlUP=mysql_query("INSERT INTO {$CFG->prefix}user_accesstoken SET user_accesstoken='".$access_token."',
						timecreated_token='".$tokencreated."', tokenexpiry='".$tokenexpiry."', userid='".$usercandidateid."', courseid='".$chatting['courseid']."'") 
					or die("Not update".mysql_error());	
				}			
			}		
		}
	
	
	
?>