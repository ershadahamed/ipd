<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $testsummary = get_string('candidateexamsummary');
    $navtitle = get_string('mycandidate');
	$titleccmanagement=get_string('cifacandidatemanagement');
	$ccmanagement=get_string('ccmanagement');
	$url1=$CFG->wwwroot. '/candidatemanagement/cifacandidatemanagement.php?id='.$USER->id;
	$linktestsummary=$CFG->wwwroot. '/offlineexam/candidate_examsummary.php?id='.$_GET['id'].'&examid='.$_GET['examid'];
    $PAGE->navbar->add(ucwords(strtolower($navtitle)), $url1)->add(ucwords(strtolower($ccmanagement)), $url1);	
	$PAGE->navbar->add(ucwords(strtolower($testsummary)), $linktestsummary);	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
	$userid=$_GET['id']; //get user id
	// $headercolor="#6D6E71";
?>
<style type="text/css">
<?php 
	include('../institutionalclient/style.css');
?>
	a:hover {text-decoration:underline;}
	#searchtable td, th{	 
		border: 1px solid #666666;
		border-collapse:collapse; 
	}	
	
tr.yellow th {
    background: none repeat scroll 0 0 #6d6e71;
    border: 1px solid #231f20;
    color: #fff;
}	
</style>
<form id="form1" name="form1" method="post" action="">
<br/>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('candidateexamsummary');?></legend><br/>

<?php
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken e On b.courseid = e.courseid And e.userid = d.id		
	";
	$statement.=" WHERE a.category = '3' AND a.visible!='0' AND d.usertype='Active Candidate' AND c.userid='".$userid."' AND b.courseid='".$_GET['examid']."'";	
	$csql="SELECT *, c.timestart as enroltime, a.id as examid  FROM {$statement}";	
	$sqlquery=mysql_query($csql);
	
	$sql=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='".$userid."'");
	$srow=mysql_fetch_array($sql);
	
	$firstname = $srow['firstname'];
	$middlename = $srow['middlename'];
	$lastname = $srow['lastname'];
	if($middlename!=''){
		$fullname = $firstname.' '.$middlename.' '.$lastname;
	}else{
		$fullname = $firstname.' '.$lastname;
	}
?>
	
	<table width="95%" border="0" style="border-collapse:collapse;margin:0px auto;">
	  <tr>
		<td width="22%" scope="row">Candidate ID</td>
		<td width="1%"><strong>:</strong></td>
		<td width="76%"><?=strtoupper($srow['traineeid']);?></td>
	  </tr>
	  <tr>
		<td scope="row">Fullname</td>
		<td><strong>:</strong></td>
		<td><?=ucwords(strtolower($fullname));?></td>
	  </tr>
	  <tr>
		<td scope="row">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
    
 <?php
		// control organization to view cert
		$selectorgsql=mysql_query("
Select
  b.name,
  a.firstname,
  a.lastname,
  a.usertype,
  b.org_typename,
  b.org_type,
  a.traineeid,
  b.viewcert
From
  mdl_cifauser a Inner Join
  mdl_cifaorganization_type b On a.usertype = b.org_typename And
    a.orgtype = b.id
			Where
			  a.traineeid = '".$USER->traineeid."' And b.viewcert!='0'		
		");
		$orgviewstatus=mysql_num_rows($selectorgsql); 
?> 
  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
			<tr class="yellow" style="background-color:#6D6E71;border: 1px solid #231f20;">
				<th class="adjacent" style="text-align:left;"><strong><?=get_string('shapeipdcoursestitle');?></strong></th>
				<th class="adjacent" width="25%" style="text-align:left;"><strong><?=get_string('testtokenid');?></strong></th>
				<th class="adjacent" width="18%" style="text-align:center;"><strong><?=get_string('testdatetime');?></strong></th>
				<th class="adjacent" width="10%" style="text-align:center;"><?=get_string('marks');?></th>	
				<?php if($orgviewstatus!='0'){  // control by admin to view cert. ?>
					<th class="adjacent" width="10%" style="text-align:center;"><?=get_string('view');?></th>
				<?php } ?>
                
			</tr>	
			<?php
				$sgrade=mysql_query("					
					SELECT *, a.name As quizname, c.grade as usergrade, c.id as quizid, a.id as cifaquizid FROM
					  mdl_cifaquiz a Inner Join
					  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
					  mdl_cifaquiz_grades c On b.quiz = c.quiz AND b.userid = c.userid Inner Join
					  mdl_cifacourse d On a.course = d.id
					WHERE d.visible != '0' And b.userid='".$userid."' And d.category='3'
				");				
				$bil=1;
				$c=mysql_num_rows($sgrade);
				if($c !='0'){
				while($qgrade=mysql_fetch_array($sgrade)){
				$no=$bil++;
			?>
			<tr>
				<td class="adjacent" style="text-align:left;">
				<?php 
					echo $qgrade['quizname'];
				?>
				</td>
				<td class="adjacent" style="text-align:left;">
				<?php
				
				// count attempts
				$sqlattempts=mysql_query("
							Select
							  a.attempts,
							  b.userid,
							  a.name,
							  b.quiz,
							  b.attempt
							From
							  mdl_cifaquiz a Inner Join
							  mdl_cifaquiz_attempts b On a.id = b.quiz
							Where
							  a.id='".$qgrade['cifaquizid']."'  AND a.course = '".$qgrade['course']."' AND b.userid = '".$userid."'					
						");
				$cattempts=mysql_num_rows($sqlattempts);
				
				// test token ID					
				$stoken=mysql_query("SELECT testtokenid, testtoken FROM {$CFG->prefix}quiz_token WHERE attempt='1' AND testtokenid='".$qgrade['cifaquizid']."'");
				$ctesttoken=mysql_fetch_array($stoken);
				if($qgrade['attempt']=='2'){
				echo $access_token=uniqid(rand());
				}else{
				echo $ctesttoken['testtoken'];
				}
					
				?>
				</td>
				<td class="adjacent" align="center"><?=date('d-m-Y H:i:s',$qgrade['timestart']);?></td>
				
				<?php 
				$sel=mysql_query("SELECT * FROM mdl_cifagrade_items WHERE itemtype='mod' AND itemmodule='quiz' AND courseid='".$qgrade['course']."'");
				$selq=mysql_fetch_array($sel);
				
				$sel2=mysql_query("SELECT * FROM mdl_cifagrade_items WHERE itemtype='course' AND courseid='".$qgrade['course']."'");
				$selq2=mysql_fetch_array($sel2);
				
				//total question
				$sqlquestion=mysql_query("
					Select
					  *
					From
					  mdl_cifaquiz_attempts a Inner Join
					  mdl_cifaquestion_usages b On a.uniqueid = b.id Inner Join
					  mdl_cifaquestion_attempts c On b.id = c.questionusageid		
					Where
						a.uniqueid='".$qgrade['uniqueid']."' Order By a.attempt ASC
				");
				$questionattempts=mysql_num_rows($sqlquestion);	
				
				//marks here
				$totalmarks_test=round($qmarks=($qgrade['sumgrades'] / $questionattempts)*100);
				// echo $qgrade['attempts'].'!='.$cattempts;
				if($qgrade['attempts']!=$cattempts){  //kali pertama amik test
				?>
					<td class="adjacent" align="center">
					<?php
						//marks here
						echo $totalmarks_test;
					?>
					</td>
				<?php
				if($orgviewstatus!='0'){  // control by admin to view cert.
				// jika kurang daripada 60 mean FAIL
				if($totalmarks_test < '60'){
				?>
					<td class="adjacent" align="center" colspan="2"><?=get_string('failtest');?></td>	
				<?php 
					}else{ // jika PASS 
				?>					
					<td class="adjacent" align="center">
						<div style="padding:3px;">				
							<input type="button" id="id_actionbutton" name="viewcertify" value="<?=get_string('cert.');?>" onclick="window.open('<?=$CFG->wwwroot.'/userfrontpage/';?>certify_two.php?id=<?=$userid; ?>&quizid=<?=$qgrade['cifaquizid'];?>&courseid=<?=$qgrade['course'];?>&certid=<?=$qgrade['quizid'];?>', 'Window2', 'width=850,height=600,resizable = 1,scrollbars=1');"  onMouseOver="style.cursor='hand'" />					
						</div>
					</td>				
				<?php }} // count attempts ?>
				
				<?php
					}else{ //kali ke-2 amik test
				?>
					<td class="adjacent" align="center">
					<?php			
							// marks here
							echo $totalmarks_test;					
					?>
					</td>
				<?php

				if($orgviewstatus!='0'){  // control by admin to view cert.
				// jika kurang daripada 60 mean FAIL
				if($totalmarks_test < '60'){
				?>
					<td class="adjacent" align="center" colspan="2"><?=get_string('failtest');?></td>	
				<?php }else{ // jika PASS ?>					
					<td class="adjacent" align="center">
						<div style="padding:3px;">
						<?php if($qgrade['attempt']=='2'){ ?>
							<input type="button" id="id_actionbutton" name="viewcertify" value="<?=get_string('cert.');?>" onclick="window.open('<?=$CFG->wwwroot.'/userfrontpage/';?>certify_two.php?id=<?=$userid; ?>&quizid=<?=$qgrade['cifaquizid'];?>&courseid=<?=$qgrade['course'];?>&certid=<?=$qgrade['quizid'];?>', 'Window2', 'width=850,height=600,resizable = 1,scrollbars=1');"  onMouseOver="style.cursor='hand'" />					
						<?php }else{ echo ' - '; } ?>
						</div>
					</td>				
				<?php }
				}
				} // count attempts ?>
			</tr>
			<?php }}else{
?>	
	
    <tr>
      <td colspan="6" scope="row"><?=get_string('notusedtoken');?></td>
    </tr>
<?php } ?>	
		</table>
	<table width="98%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td align="right">
	  <?php if($c !='0'){ ?>
      <input type="submit" name="buttonprint" id="id_defaultbutton" value="Print" onClick="this.form.action='<?=$CFG->wwwroot. '/offlineexam/candidate_examsummary_print.php?id='.$_GET['id'].'&examid='.$_GET['examid'];?>', target='_blank'" />
      <?php } ?>
	  <input type="button" name="buttonback" id="id_defaultbutton" onClick="window.close()" value="<?=get_string('back');?>" /></td>
    </tr>    
</table>
  </fieldset>
</form>
<?php 
	echo $OUTPUT->footer();
?>