<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	//require_once($CFG->libdir.'/blocklib.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = 'Manage Candidate for Exam Registration';
    $PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	
    echo $OUTPUT->header();
    echo $OUTPUT->heading('Manage Candidate for Exam Registration', 2, 'headingblock header');
?>
<br/>
<style type="text/css">
<?php 
	require_once('../css/style.css'); 
	require_once('../css/style2.css'); 
	include('../css/pagination.css');
	include('../css/grey.css');
	include('../institutionalclient/style.css');
?>
</style>
<form method="post">
<table style="margin: 0 auto; width:95%; padding-bottom:10px;">
	<tr valign="top">
		<td width="10%">Candidate ID</td><td width="1%">:</td>
		<td width="10%"><input type="text" name="traineeid" size="50" style="height:20px"/></td>
		<td><input type="submit" name="search" value="View" /></td>
		<td style="text-align:right;">
		<input type="button" title="View Candidate List" value="View Candidate List" name="candidatelist" onclick="window.open('view_candidateslist.php', 'Window2', 'width=950,height=550,resizable = 1');">
		<!--a href="#" title="View Candidate List" onclick="window.open('view_candidateslist.php', 'Window2', 'width=850,height=600,resizable = 1');">View Candidate List</a-->
		</td>
	</tr>	
</table>
</form>
<?php 
	if(isset($_POST['search'])){
	$candidateid=$_POST['traineeid']; 
	
	$statement="mdl_cifacourse a, mdl_cifa_modulesubscribe b, mdl_cifauser c WHERE   a.id = b.courseid And b.traineeid = c.traineeid And (a.category = '1')";
	if($candidateid!=''){$statement.= " And b.traineeid LIKE '%".$candidateid."%'";}
	$sqlquery=mysql_query("Select *, c.id as userID From {$statement}");
	$rsCount=mysql_num_rows($sqlquery);
	$sqlRowStudent=mysql_fetch_array($sqlquery);
	//echo $rsCount;
	if($rsCount>='0'){	
		if($candidateid!=''){
		
		$sqldownload=mysql_query("SELECT * FROM mdl_cifauser_accesstoken a, mdl_cifauser b Where a.userid = b.id And b.traineeid LIKE '%".$candidateid."%' And a.user_accesstoken!='' Group by a.userid");
		$qdownload=mysql_num_rows($sqldownload);

		if($qdownload=='0'){ //check if already register
		//count module
			$sql="SELECT * FROM {$CFG->prefix}user_enrolments a, {$CFG->prefix}enrol b";
			$sql.=" WHERE  a.enrolid=b.id AND (a.userid='".$sqlRowStudent['userID']."' AND b.enrol='paypal')";
			$sqlQ=mysql_query($sql);
			$rs=mysql_num_rows($sqlQ);

			//if not records found.	
			if($rs=='0'){
				echo'<table border="1" style="text-align:center;margin: 10px auto; width:95%; color:red; height:60px;"><tr><td>';
				echo 'Records not found.';
				echo '</td></tr></table>';
			}		
			//should be more than 10 module
			else if($rs>='1'){	
				$startdate=date('d-m-Y H:i:s',$sqlRowStudent['timecreated']);
?>
				<table id="listcandidate">
					<tr><td colspan="3" style="text-align:left; font-weight: bolder;">Candidate Details</td></tr>
					<tr>
						<th style="text-align:right" width="25%">Username</th><th width="1%">:</th><td><?php echo $sqlRowStudent['username']; ?></td>	
					</tr><tr>
						<th style="text-align:right">Candidate ID</th><th>:</th><td><?php echo $sqlRowStudent['traineeid']; ?></td>
					</tr><tr>
						<th style="text-align:right">Date Of Birth</th><th>:</th><td><?php echo date('d F Y',$sqlRowStudent['dob']); ?></td>
					</tr><tr>
						<th style="text-align:right">Registration Date</th><th>:</th><td><?php echo date('d-m-Y H:i:s',$sqlRowStudent['timecreated']); ?></td>
					</tr>
					<tr><td colspan="3" style="text-align:left; font-weight: bolder;">Contact Details</td></tr>
					<tr>
						<th style="text-align:right">Firstname</th><th>:</th><td><?php echo $sqlRowStudent['firstname']; ?></td>
					</tr><tr>
						<th style="text-align:right">Lastname</th><th>:</th><td><?php echo $sqlRowStudent['lastname']; ?></td>
					</tr><tr>
						<th style="text-align:right">Address</th><th>:</th><td>
						<?php 
							if($sqlRowStudent['address'] != ''){
								echo $sqlRowStudent['address']; 
							}else{ 
								echo 'Not found'; 
							} 
						?>
						</td>
					</tr><tr>
						<th style="text-align:right">Country</th><th>:</th><td>
						<?php 
							$querycountry = $DB->get_records('country_list',array('countrycode'=>$sqlRowStudent['country']));
							foreach($querycountry as $qcountry);
							
							if($sqlRowStudent['country'] != ''){
								echo $qcountry->countryname;
							}else{ 
								echo 'Not found'; 
							} 
						?>
						</td>
					</tr><tr>
						<th style="text-align:right">Email</th><th>:</th><td><?php echo $sqlRowStudent['email']; ?></td>
					</tr>
					<tr><td colspan="3" style="text-align:left; font-weight: bolder;">Active Period</td></tr>
					<tr>
						<th style="text-align:right">Start Date</th><th>:</th><td><?php echo $startdate; ?></td>	
					</tr><tr>
						<th style="text-align:right">End Date</th><th>:</th><td><?php echo date('d-m-Y H:i:s',strtotime($startdate . " + 1 year")); ?></td>
					</tr>
					<!--tr><th style="text-align:right">Quiz/test/exam</th><th>:</th><td>
						<form method="post">
						<?php
								//list of modules exam
								//echo '<select name="quizlist" onchange="this.form.submit();">';
								/*echo '<select name="quizlist">';
								echo '<option value=""> Please select..</option>';
								$queryquiz  = $DB->get_records('quiz');
								foreach($queryquiz as $qquiz){ 
								echo '<option value="'.$qquiz->name.'">'.$qquiz->name.'</option>';
								}
								echo '</select>';*/
						?></form>
					</td></tr-->
				</table>
				<form method="post">
				
				<table style="margin: 0 auto; width:95%;">
					<tr>
						<td>
						<!--input type="submit" value="Generate token" name="gtoken" onclick="window.open('access_tokens.php?candidateid=<?php //echo $sqlRowStudent['traineeid']; ?>&&examid=<?php //echo $sqlRowStudent['courseid']; ?>', 'Window2', 'width=820,height=400,resizable = 1');"-->
						<input type="submit" value="Generate token" name="gtoken">
						<input type="hidden" name="traineeid_hidden" value="<?php echo $sqlRowStudent['traineeid'];?>">
						<input type="hidden" name="examid" value="<?php echo $sqlRowStudent['courseid'];?>">
						</td>
					</tr>	
				</table>
				</form>
<?php
			}else{
				echo'<table border="1" style="text-align:center;margin: 10px auto; width:95%; color:red; height:60px;"><tr><td>';
				echo 'Enrolment for module, less than 10 module.';
				echo '</td></tr></table>';
			}
			}else{
			echo'<table border="1" style="text-align:center;margin: 10px auto; width:95%; color:red; height:60px;"><tr><td>';
			echo'Already register!';
			echo '</td></tr></table>';			
			}
		}else{
			echo'<table border="1" style="text-align:center;margin: 10px auto; width:95%; color:red; height:60px;"><tr><td>';
			echo'Please fill the search box with candidate ID!';
			echo '</td></tr></table>';
		}		
	} //end count row
	}//End if set search
	if(isset($_POST['gtoken'])){ 
	
	$candidateid2=$_POST['traineeid_hidden']; 
	$examid=$_POST['examid']; 
	$quizlist=$_POST['quizlist']; 
	
	$statement="mdl_cifacourse a, mdl_cifa_modulesubscribe b, mdl_cifauser c WHERE   a.id = b.courseid And b.traineeid = c.traineeid And (a.category = '1') And b.traineeid = '".$candidateid2."'";
	$sqlquery=mysql_query("Select *, c.id as userID From {$statement}");
	$rsCount=mysql_num_rows($sqlquery);
	$sqlRowStudent=mysql_fetch_array($sqlquery);
	$startdate=date('d-m-Y H:i:s',$sqlRowStudent['timecreated']);
?>
				<table id="listcandidate">
					<tr><td colspan="3" style="text-align:left; font-weight: bolder;">Candidate Details</td></tr>
					<tr>
						<th style="text-align:right" width="25%">Username</th><th width="1%">:</th><td><?php echo $sqlRowStudent['username']; ?></td>	
					</tr><tr>
						<th style="text-align:right">Candidate ID</th><th>:</th><td><?php echo $sqlRowStudent['traineeid']; ?></td>
					</tr><tr>
						<th style="text-align:right">Date Of Birth</th><th>:</th><td><?php echo date('d F Y',$sqlRowStudent['dob']); ?></td>
					</tr><tr>
						<th style="text-align:right">Registration Date</th><th>:</th><td><?php echo date('d-m-Y H:i:s',$sqlRowStudent['timecreated']); ?></td>
					</tr>
					<tr><td colspan="3" style="text-align:left; font-weight: bolder;">Contact Details</td></tr>
					<tr>
						<th style="text-align:right">Firstname</th><th>:</th><td><?php echo $sqlRowStudent['firstname']; ?></td>
					</tr><tr>
						<th style="text-align:right">Lastname</th><th>:</th><td><?php echo $sqlRowStudent['lastname']; ?></td>
					</tr><tr>
						<th style="text-align:right">Address</th><th>:</th><td>
						<?php 
							if($sqlRowStudent['address'] != ''){
								echo $sqlRowStudent['address']; 
							}else{ 
								echo 'Not found'; 
							} 
						?>
						</td>
					</tr><tr>
						<th style="text-align:right">Country</th><th>:</th><td>
						<?php 
							$querycountry = $DB->get_records('country_list',array('countrycode'=>$sqlRowStudent['country']));
							foreach($querycountry as $qcountry);
							
							if($sqlRowStudent['country'] != ''){
								echo $qcountry->countryname;
							}else{ 
								echo 'Not found'; 
							} 
						?>
						</td>
					</tr><tr>
						<th style="text-align:right">Email</th><th>:</th><td><?php echo $sqlRowStudent['email']; ?></td>
					</tr>
					<tr><td colspan="3" style="text-align:left; font-weight: bolder;">Active Period</td></tr>
					<tr>
						<th style="text-align:right">Start Date</th><th>:</th><td><?php echo $startdate; ?></td>	
					</tr><tr>
						<th style="text-align:right">End Date</th><th>:</th><td><?php echo date('d-m-Y H:i:s',strtotime($startdate . " + 1 year")); ?></td>
					</tr>
				</table>
				
<form name="download" method="post">
			<?php 
				$access_token=uniqid(rand());
				$sqlUP=mysql_query("UPDATE {$CFG->prefix}user a SET a.access_token='".$access_token."' WHERE a.traineeid='".$candidateid2."'") or die("Not update".mysql_error());
				if($sqlUP){
					$tokenExpire = strtotime('now');
					//select user from DB
					$querytoken  = $DB->get_records('user',array('traineeid'=>$candidateid2));
					foreach($querytoken as $qtoken){}
					
					$sqlUP=mysql_query("UPDATE {$CFG->prefix}user_accesstoken b SET b.user_accesstoken='".$qtoken->access_token."' WHERE b.userid='".$qtoken->id."'") or die("Not update".mysql_error());
					
					//select user_accesstoken from DB
					$query=$DB->get_records('user_accesstoken');
					foreach ($query as $rs){}
					if($rs->userid != $qtoken->id){
						//Insert data to user_accesstoken
						$sqlInsert=mysql_query("INSERT INTO {$CFG->prefix}user_accesstoken SET courseid='".$sqlRowStudent['courseid']."', userid='".$qtoken->id."', user_accesstoken='".$qtoken->access_token."', timecreated_token='".$tokenExpire."'");
					}
				}
			?>
<table id="listcandidate">
	<tr><td colspan="3" style="text-align:left; font-weight: bolder;">Access Token Settings</td></tr>
	<tr><th style="text-align:right">Token ID</th><th>:</th>
		<td><?php 
					//select user from DB
					$querytoken  = $DB->get_records('user',array('traineeid'=>$candidateid2));
					foreach($querytoken as $qtoken){}
					echo $qtoken->access_token;
		?></td>
	</tr>
	<tr><th style="text-align:right" width="25%">Maximum Number of Accesses</th><th width="1%">:</th><td>1</td></tr>
	<tr><th style="text-align:right">Start Date / Time</th><th>:</th><td><?php echo $startdate; ?></td></tr>
	<tr><th style="text-align:right">End Date / Time</th><th>:</th><td><?php echo date('d-m-Y H:i:s',strtotime($startdate . " + 1 year")); ?></td></tr>
</table>

<table style="margin: 0 auto; width:95%;"><tr><td>	
<input type="submit" value="Download token" name="token" onclick="window.open('download_token.php?tokenid=<?php echo $qtoken->id; ?>', 'Window2', 'width=820,height=400,resizable = 1');">
<input type="hidden" name="fullname" value="<?php echo $qtoken->firstname.' '.$qtoken->lastname; ?>" />
</td></tr></table>
</form>	
<?php } //end display page ?>	
<?php
	if(isset($_POST['token'])){ 
		$fullname=$_POST['fullname'];
		echo'<table border="1" style="text-align:center;margin: 10px auto; width:95%; color:#4f0093; height:60px;"><tr><td>';
		echo 'Thank you. Token id for <b>'.$fullname.'</b> have been download.';
		echo '</td></tr></table>';	
	}
?>
<?php 
	echo $OUTPUT->footer();
?>