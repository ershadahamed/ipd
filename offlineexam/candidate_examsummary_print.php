<body onload="window.print()">
<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	$userid=$_GET['id']; //get user id
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
html, body {
    font-family: Verdana,Geneva,sans-serif !important;
    color: #333;
}	
table tr, td, th {
	font-family: Verdana,Geneva,sans-serif;
	font-size:0.95em;
}
</style>
<style type="text/css">
    img.table-bg-image {
        position: absolute;
        z-index: -1;
		width:100%;
		/* min-height:837px; */
		height:98%;
		margin-bottom:0px;
		padding-bottom:0px;
    }
    table.with-bg-image, table.with-bg-image tr, table.with-bg-image td {
        background: transparent;
    }
</style>
<img class="table-bg-image" src="<?=$CFG->wwwroot;?>/image/bg_statement.png"/>
<form id="form1" name="form1" method="post" action="">

<div style="margin:0px auto">
<table class="with-bg-image" width="100%" style="margin:0px auto;"><tr><td>
<table id="policy" width="98%" border="0"  style="padding:0px;margin:0px auto;">
  <tr valign="top">
    <td align="left" valign="middle" style="font-size:0.9em;"><?=get_string('ipdaddress');?></td>
    <td align="right" style="width:50%"><img style="width:134px;" src="<?=$CFG->wwwroot;?>/image/CIFALogo.png"></td>
  </tr>
</table>
<div style="width:98%;margin:0px auto;"><h3><?=get_string('candidateexamsummary');?></h3></div>

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
	
	<table width="98%" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:0px auto;">
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

  <table width="98%" border="1" id="searchtable" style="border-collapse:collapse;margin:0px auto;">
    <tr align="center"  style="background-color:#6d6e71;color: #000;border: 1px solid #231f20;">
      <td scope="row" style="text-align:left;">
            <div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:2em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><b><?=get_string('shapeipdcoursestitle');?></b></span>
            </div> 		  
	  </td>
      <td width="22%" style="text-align:left;">
            <div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:2em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><b><?=get_string('testtokenid');?></b></span>
            </div> 		  
	  </td>
      <td width="22%" style="text-align:left;">
            <div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:2em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><b><?=get_string('testdatetime');?></b></span>
            </div> 	  
	  </td>
      <td width="13%" style="text-align:left;">
            <div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:2em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><b><?=get_string('marks');?></b></span>
            </div> 	 	  
	  </td>
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
      <td scope="row">
				<?php 
					echo $qgrade['quizname'];
				?>	  
	  </td>
      <td>
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
      <td><?=date('d-m-Y H:i:s',$qgrade['timestart']);?></td>
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
				
				if($qgrade['attempts']!=$cattempts){  //kali pertama amik test
				?>
					<td class="adjacent" align="center">
					<?php
						//marks here
						echo $totalmarks_test;
					?>
					</td>
				
				<?php
				}else{ //kali ke-2 amik test
				?>
					<td class="adjacent" align="center">
					<?php			
							// marks here
							echo $totalmarks_test;					
					?>
					</td>				
				<?php } // count attempts ?>
			</tr>
			<?php }}else{
?>	
	
    <tr>
      <td colspan="6" scope="row"><?=get_string('notusedtoken');?></td>
    </tr>
<?php } ?>	
	</table></td></tr></table></div>
</form>