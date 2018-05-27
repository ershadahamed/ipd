<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
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
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
    echo $OUTPUT->heading('Manage Candidate for Exam Registration', 2, 'headingblock header');
?>
<br/>
<style type="text/css">
<?php 
	//require_once('../css/style.css'); 
	//require_once('../css/style2.css'); 
	//include('../css/pagination.css');
	//include('../css/grey.css');
	include('../institutionalclient/style.css');
?>
</style>
<div style="height:400px;">
<?php
	$setSQL=mysql_query("SELECT * FROM mdl_cifacourse d WHERE d.category='3' AND (d.id != '53' AND d.id != '54')");
?>

<form method="post"><!--fieldset style="padding-top:20px;height:50px;"-->
<table style="margin: 0 auto; width:95%; padding-bottom:10px;">
	<tr valign="top">
		<td width="10%">Choose an Exam</td><td width="1%">:</td>
		<td width="10%">
		<select name="choose_exam">
			<option value=""></option>
			<?php
				while($setExam=mysql_fetch_array($setSQL)){
					echo '<option value="'.$setExam['id'].'">'.$setExam['fullname'].'</option>';
				}
			?>
		</select>
		</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr valign="top">
		<td width="10%"><?=get_string('candidateid');?></td><td width="1%">:</td>
		<td width="10%"><input type="text" name="traineeid" size="50" style="height:20px"/></td>
		<td><input type="submit" name="search" value="View" style="width:60px;" /></td>
		<td style="text-align:right;">
		<input type="button" title="View Candidate List" value="<?=get_string('registedcandidates');?>" name="candidatelist" onclick="window.open('view_candidateslist.php', 'Window2', 'width=950,height=550,resizable = 1');">
		</td>
	</tr>		
</table><!--/fieldset-->
</form>
<?php 
	if(isset($_POST['search'])){
	$candidateid=$_POST['traineeid']; 
	$gotanExamID=$_POST['choose_exam']; 
	
	/* $statement=" mdl_cifauser c";
	if($candidateid!=''){$statement.= " WHERE c.traineeid LIKE '%".$candidateid."%'";}
	$sqlquery=mysql_query("Select *, c.id as userID From {$statement}"); */
		
	$statement=" 
	  mdl_cifauser a Inner Join
	  mdl_cifauser_enrolments b On b.userid = a.id Inner Join
	  mdl_cifaenrol c On b.enrolid = c.id Inner Join
	  mdl_cifacourse d On c.courseid = d.id	
	";
	if($candidateid!=''){$statement.= " WHERE c.courseid='".$gotanExamID."' And a.id != '2' And a.traineeid LIKE '%".$candidateid."%' And a.id != '1' And d.category = '3' And (d.id != '53' And d.id != '54')";}	
	$sqlquery=mysql_query("Select *, a.id as userID From {$statement}");
	$rsCount=mysql_num_rows($sqlquery);
	$sqlRowStudent=mysql_fetch_array($sqlquery);
	//echo $rsCount.'<br/>';
	//echo $sqlRowStudent['courseid'];
	if($rsCount>='0'){	
		if($candidateid!=''){
		
		//$sqldownload=mysql_query("SELECT * FROM mdl_cifauser_accesstoken a, mdl_cifauser b Where a.userid = b.id And b.traineeid LIKE '%".$candidateid."%' And a.user_accesstoken!='' Group by a.userid");
		$sqldownload=mysql_query("
			Select
			  *
			From
			  mdl_cifauser_accesstoken a Inner Join
			  mdl_cifauser b On a.userid = b.id Inner Join
			  mdl_cifauser_enrolments c On b.id = c.userid Inner Join
			  mdl_cifacourse d On a.courseid = d.id
			Where
			  b.traineeid Like '%".$candidateid."%' And
			  a.user_accesstoken != '' And
			  d.category ='3'
			Group By
			  a.userid		
		");
		$qdownload=mysql_num_rows($sqldownload);
		//echo $qdownload;
		if($qdownload=='0'){ //check if already register
		//count module
			$sql="SELECT * FROM {$CFG->prefix}user_enrolments a, {$CFG->prefix}enrol b";
			$sql.=" WHERE  a.enrolid=b.id AND (a.userid='".$sqlRowStudent['userID']."' AND b.enrol='manual')";
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
					<tr><td colspan="6" style="text-align:left; font-weight: bolder;">Candidate Details</td></tr>
					<tr>
						<th width="25%" style="text-align:right">Candidate ID</th><th width="1%">:</th><td colspan="4"><?php echo $sqlRowStudent['traineeid']; ?></td>
					</tr><tr>
						<th style="text-align:right">Date Of Birth</th><th>:</th><td colspan="4"><?php echo date('d F Y',$sqlRowStudent['dob']); ?></td>
					</tr>
					<tr>
						<th style="text-align:right">Firstname</th><th>:</th><td colspan="4"><?php echo $sqlRowStudent['firstname']; ?></td>
					</tr>
					<tr><th style="text-align:right">Lastname</th><th>:</th><td colspan="4"><?php echo $sqlRowStudent['lastname']; ?></td></tr>
					<tr><td colspan="6" style="text-align:left; font-weight: bolder;">Active Period</td></tr>
					<tr>
						<th style="text-align:right" width="25%">Start Date</th><th>:</th><td><?php echo $startdate; ?></td>
						<th style="text-align:left" width="25%">End Date</th><th>:</th><td><?php echo date('d-m-Y H:i:s',strtotime($startdate . " + 1 year")); ?></td>
					</tr>
				</table>
				<form method="post">
				
				<?php
					/* $sql_statement=" mdl_cifacourse a Inner Join mdl_cifaenrol b On a.id = b.courseid Inner Join mdl_cifauser_enrolments c On b.id = c.enrolid";				
					$sql_query=mysql_query("SELECT * FROM {$sql_statement} WHERE c.userid = '".$sqlRowStudent['userID']."' And b.enrol = 'manual' And a.category = '3' And a.visible = '1' And b.status = '0'");
					$sql_row=mysql_fetch_array($sql_query); */
					//echo $sql_row['courseid'].' '.$sqlRowStudent['traineeid'];;
				?>
				<table style="margin: 0 auto; width:95%;">
					<tr>
						<td>
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
			echo get_string('fillbox');
			echo '</td></tr></table>';
		}		
	} //end count row
	}//End if set search
	if(isset($_POST['gtoken'])){ 
	
	$candidateid2=$_POST['traineeid_hidden']; 
	$examid=$_POST['examid']; 
	$quizlist=$_POST['quizlist']; 
	
	$statement=" mdl_cifauser c WHERE c.traineeid = '".$candidateid2."'";
	$sqlquery=mysql_query("Select *, c.id as userID From {$statement}");
	$rsCount=mysql_num_rows($sqlquery);
	$sqlRowStudent=mysql_fetch_array($sqlquery);
	$startdate=date('d-m-Y H:i:s',$sqlRowStudent['timecreated']);
?>
				<table id="listcandidate">
					<tr><td colspan="6" style="text-align:left; font-weight: bolder;">Candidate Details</td></tr>
					<tr><th style="text-align:right" width="25%">Candidate ID</th><th width="1%">:</th><td colspan="4"><?php echo $sqlRowStudent['traineeid']; ?></td></tr>
					<tr><th style="text-align:right">Date Of Birth</th><th>:</th><td colspan="4"><?php echo date('d F Y',$sqlRowStudent['dob']); ?></td></tr>
					<tr><th style="text-align:right">Firstname</th><th>:</th><td colspan="4"><?php echo $sqlRowStudent['firstname']; ?></td>
					</tr><tr><th style="text-align:right">Lastname</th><th>:</th><td colspan="4"><?php echo $sqlRowStudent['lastname']; ?></td></tr>
					<tr><td colspan="6" style="text-align:left; font-weight: bolder;">Active Period</td></tr>
					<tr>
						<th style="text-align:right" width="25%">Start Date</th><th>:</th><td><?php echo $startdate; ?></td>	
						<th style="text-align:left" width="25%">End Date</th><th>:</th><td><?php echo date('d-m-Y H:i:s',strtotime($startdate . " + 1 year"));?></td>
					</tr>
					<!--tr><th style="text-align:right">End Date</th><th>:</th><td><?php //echo date('d-m-Y H:i:s',strtotime($startdate . " + 1 year")); ?></td></tr-->
				</table>
				
<form name="download" method="post">
			<?php 
				$examid=$_POST['examid'];
				$access_token=uniqid(rand());
				$sqlUP=mysql_query("UPDATE {$CFG->prefix}user a SET a.access_token='".$access_token."' WHERE a.traineeid='".$candidateid2."'") or die("Not update".mysql_error());
				if($sqlUP){
					$tokenExpire = strtotime('now');
					//select user from DB
					$querytoken  = $DB->get_records('user',array('traineeid'=>$candidateid2));
					foreach($querytoken as $qtoken){}
					
					$sqlUP=mysql_query("UPDATE {$CFG->prefix}user_accesstoken b SET b.centerid='".$USER->id."', b.user_accesstoken='".$qtoken->access_token."' WHERE b.userid='".$qtoken->id."'") or die("Not update".mysql_error());
					
					//select user_accesstoken from DB
					$query=$DB->get_records('user_accesstoken');
					foreach ($query as $rs){}
					if($rs->userid != $qtoken->id){
						//Insert data to user_accesstoken
						$sqlInsert=mysql_query("INSERT INTO {$CFG->prefix}user_accesstoken SET centerid='".$USER->id."', courseid='".$examid."', userid='".$qtoken->id."', user_accesstoken='".$qtoken->access_token."', timecreated_token='".$tokenExpire."'");
					}
				}
			?>
<table id="listcandidate">
	<tr><td colspan="6" style="text-align:left; font-weight: bolder;">Access Token Settings</td></tr>
	<tr><th style="text-align:right" width="25%">Token ID</th><th width="1%">:</th>
		<td colspan="4"><?php 
					//select user from DB
					$querytoken  = $DB->get_records('user',array('traineeid'=>$candidateid2));
					foreach($querytoken as $qtoken){}
					echo $qtoken->access_token;
		?></td>
	</tr>
	<!--tr><th style="text-align:right" width="25%">Maximum Number of Accesses</th><th width="1%">:</th><td>1</td></tr-->
	<tr>
		<th style="text-align:right" width="25%">Start Date / Time</th><th>:</th><td><?php echo $startdate; ?></td>
		<th style="text-align:left" width="25%">End Date / Time</th><th>:</th><td><?php echo date('d-m-Y H:i:s',strtotime($startdate . " + 1 year")); ?></td>
	</tr>
	<!--tr><th style="text-align:right">End Date / Time</th><th>:</th><td><?php// echo date('d-m-Y H:i:s',strtotime($startdate . " + 1 year")); ?></td></tr-->
</table>

<table style="margin: 0 auto; width:95%;"><tr><td>	
<input type="submit" value="Download token" name="token" onclick="window.open('download_token.php?tokenid=<?php echo $qtoken->id; ?>&examid=<?=$examid;?>', 'Window2', 'width=820,height=400,resizable = 1');">
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
</div>
<?php 
	echo $OUTPUT->footer();
?>