<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $progressreport = 'View Report';
	$rmanagement = 'Report Management';
	$url_view=$CFG->wwwroot. '/examcenter/myreport.php?id='.$USER->id;
    $PAGE->navbar->add(ucwords(strtolower($rmanagement)), $url_view)->add(ucwords(strtolower($progressreport)), $url_view);		

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
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
</style>
<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAll () {
	if (checked == false){checked = true;}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
		//document.getElementById('selectall').disabled=true;
	}
}
//  End -->
 function clearSelected(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
		//document.getElementById('unselectall').disabled=true;
	}
  }
</script>
<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAll2 () {
	if (checked == false){checked = true;}
		for (var i = 0; i < document.getElementById('form2').elements.length; i++) {
		document.getElementById('form2').elements[i].checked = checked;
	}
}
//  End -->
 function clearSelected2(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('form2').elements.length; i++) {
		document.getElementById('form2').elements[i].checked = checked;
	}
  }
</script>
<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAll3 () {
	if (checked == false){checked = true;}
		for (var i = 0; i < document.getElementById('form3').elements.length; i++) {
		document.getElementById('form3').elements[i].checked = checked;
	}
}
//  End -->
 function clearSelected3(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('form3').elements.length; i++) {
		document.getElementById('form3').elements[i].checked = checked;
	}
  }
</script>

<script type="text/javascript" language="javascript">
function checkfield(){
	var checked=false;
	var elements = document.getElementsByName("checktoken[]");
	for(var i=0; i < elements.length; i++){
		if(elements[i].checked) {
			checked = true;
		}
	}
	if (!checked) {
		alert('Please check the box to download.');
		return checked;
	}
<?php if($_GET['sid']=='0'){ ?>
document.form1.submit();
<?php }else if($_GET['sid']=='1'){ ?>
document.form2.submit();
<?php }else if($_GET['sid']=='2'){ ?>
document.form3.submit();
<?php } ?>
return true;	
} 
</script>

<br/>
<?php
	$reportid=$_GET['id'];
	$reportSQL=mysql_query("
		Select
		  *
		From
		  mdl_cifareport_menu a Inner Join
		  mdl_cifareport_option b On b.reportid = a.id Inner Join
		  mdl_cifareport_users c On b.reportid = c.reportid
		Where
			b.reportid='".$reportid."'	
	");
	$viewreport=mysql_fetch_array($reportSQL);

	$rpcreator=mysql_query("
		Select
		  b.userid,
		  a.name,
		  a.id,
		  b.contextid
		From
		  {$CFG->prefix}role a Inner Join
		  {$CFG->prefix}role_assignments b On a.id = b.roleid
		Where
		  b.userid = '".$viewreport['reportcreator']."' And
		  b.contextid = '1'		
	");
	$creator=mysql_fetch_array($rpcreator);
	
	if($viewreport['selectedreport']=='0'){
?>

<!--////- Candidate Performance -////-->
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('candidateperformance');?></legend><br/>

<!--form name="form1" id="form1" action="" method="post"-->
<form name="form1" id="form1" action="<?=$CFG->wwwroot. '/examcenter/download_reportcsv.php?rid='.$reportid.'&csv=csv&excel=excel&html=html&sid='.$_GET['sid'];?>" method="post">
	<div style="margin-left:1em;font-size:2em; font-weight:bolder;"><?=$viewreport['reportname'];?></div>
    <div style="margin-left:2em;margin-bottom:1em;"><?=$creator['name'];?>, <?=date('d/m/Y h:i:s', $viewreport['timecreated']);?></div>
    
	<table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="left">
				<!--b>DOWNLOAD</b-->
			  <input type="submit" name="download_html" id="id_defaultbutton" value="HTML" title="<?=get_string('titledownload');?>" onClick="this.form.action='<?//=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" />
				<input type="submit" name="download_excel" id="id_defaultbutton" value="EXCEL" title="<?=get_string('titledownload');?>" onClick="this.form.action='<?//=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" />
				<!--input type="submit" name="download_csv" id="id_defaultbutton" value="CSV" title="<?//=get_string('titledownload');?>" onClick="this.form.action='<?//=$CFG->wwwroot. '/examcenter/download_reportcsv.php?rid='.$reportid.'&sid='.$_GET['sid'];?>'" /-->
				<input type="button" name="download_csv" id="id_defaultbutton" value="CSV" title="<?=get_string('titledownload');?>" onclick="checkfield()" />                
			</td>
			<td align="right"><input type="submit" name="buttonback2" id="id_defaultbutton" onclick="this.form.action='<?=$CFG->wwwroot. '/examcenter/myreport.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" />
			  <input type="submit" name="buttonprint2" id="id_defaultbutton" value="Print" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/reportview_print.php?id='.$_GET['id'];?>', target = '_blank';" />
			  <input type="button" name="unselectall" id="unselectall" value="Unselect All" onclick="clearSelected();" />
				<input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll()"/></td>
		</tr>    
	</table>
	
<?php		
	$statement="
		  mdl_cifaquiz a Inner Join
		  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
		  mdl_cifaquiz_grades c On b.quiz = c.quiz And b.userid = c.userid Inner Join
		  mdl_cifacourse d On a.course = d.id Inner Join
		  mdl_cifauser e On b.userid = e.id
	";
	
	$statement.=" WHERE d.category = '3' AND d.visible='1'";
	$csql="SELECT *, d.idnumber As code FROM {$statement} GROUP BY b.userid ORDER BY b.userid ASC";
	$sqlquery=mysql_query($csql);	
?>	
	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		<?php if(($creator['id']=='12') || ($creator['id']=='13')){ ?>
        	  <?php if($viewreport['candidateID']!='0'){ ?>
			  <th width="15%" scope="row"><?=get_string('candidateid');?></th>
              <?php }if($viewreport['candidateFullname']!='0'){ ?>
			  <th width="20%"><?=get_string('fullname');?></th>
              <?php }if($viewreport['candidateEmail']!='0'){ ?>
			  <th width="20%"><?=get_string('email');?></th>
              <?php }if($viewreport['candidateAddress']!='0'){ ?>
			  <th width="20%"><?=get_string('address');?></th>
              <?php }if($viewreport['candidateTel']!='0'){ ?>
			  <th width="20%"><?=get_string('officetel');?></th>
		<?php }}else if(($creator['id']=='10')){ ?>
			  <th width="15%" scope="row"><?=get_string('candidateid');?></th>
			  <th width="20%"><?=get_string('fullname');?></th>		
		<?php } ?>
          <?php if($viewreport['curriculumname']!='0'){ ?>
		  	<th width="20%"><?=get_string('coursetitle');?></th> 
           <?php } if($viewreport['curriculumcode']!='0'){ ?>
           <th width="20%"><?=get_string('coursecode');?></th> 
          <?php } if($viewreport['performancestatus']!='0'){ ?>   
		  	<th width="10%"><?=get_string('status');?></th>
		  <?php } if($viewreport['markperformance']!='0'){ ?>
		  	<th width="10%"><?=get_string('marks');?></th>
		  <?php } if($viewreport['modulecompleted']!='0'){ ?>
		  	<th width="12%"><?=get_string('modulecompleted');?></th>
		  <?php } if($viewreport['totaltimeperformance']!='0'){ ?>
		  	<th width="10%"><?=get_string('totaltime');?></th>
		  <?php }if($viewreport['examinationstatus']!='0'){  ?>
		  <th width="10%"><?=get_string('teststatus');?></th>
		  <?php }  ?>
          <th width="1%">&nbsp;</th>
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil=$no++;
	
	//country list
	$countrylistsql=mysql_query("SELECT * FROM {$CFG->prefix}country_list WHERE countrycode='".$sqlrow['country']."'");
	$countrylist=mysql_fetch_array($countrylistsql);
	
	$fulladdress=ucwords(strtolower($sqlrow['address'].' '.$sqlrow['address2'].' '.$sqlrow['address3'].', '.$sqlrow['postcode'].' '.$sqlrow['city'].' '.$sqlrow['state'].', '.$countrylist['countryname']));
?>
		<tr>		  
		<?php if(($creator['id']=='12') || ($creator['id']=='13')){ ?>
          <?php if($viewreport['candidateID']!='0'){ ?>
		  <td style="text-align:center" scope="row"><?=strtoupper($sqlrow['traineeid']);?></td>
          <?php }if($viewreport['candidateFullname']!='0'){ ?>
		  <td><?=ucwords(strtolower($sqlrow['firstname'].' '.$sqlrow['lastname']));?></td>	
          <?php }if($viewreport['candidateEmail']!='0'){ ?>
		  <td style="text-align:center" scope="row"><?=$sqlrow['email'];?></td>
          <?php }if($viewreport['candidateAddress']!='0'){ ?>
		  <td><?=$fulladdress;?></td>	
          <?php }if($viewreport['candidateTel']!='0'){ ?>
		  <td><?='+'.$countrylist['iso_countrycode'].$sqlrow['phone1'];?></td>	
		<?php }}else if(($creator['id']=='10')){ ?>
		  <td style="text-align:center" scope="row"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname'].' '.$sqlrow['lastname']));?></td>	
		<?php } ?>		  
          <?php if($viewreport['curriculumname']!='0'){ ?>
          <td style="text-align:left">
		  <?php
			/* $selectcoursefullname=mysql_query("SELECT fullname FROM {$CFG->wwwroot}course WHERE category='3' AND idnumber='".$sqlrow['idnumber']."'");
			$scfullname=mysql_fetch_array($selectcoursefullname);
			echo $scfullname['fullname']; */
		  ?>
		  <?=$sqlrow['fullname'];?>
		  </td>
          <?php } if($viewreport['curriculumcode']!='0'){ ?>
          <td style="text-align:left">
		  <?php
			if($sqlrow['code']!=''){ echo $sqlrow['code']; }else{ echo '-'; }
		  ?>
		  </td>
          <?php } if($viewreport['performancestatus']!='0'){ ?>
		  <td style="text-align:center">
		  <?php
            if ($sqlrow['timefinish'] > 0) {
                // attempt has finished
                // $timetaken = format_time($sqlrow['timefinish'] - $sqlrow['timestart']);
				// $datecompleted = userdate($sqlrow['timefinish']);
				echo  'Ended';
            } else if (!$sqlrow['timeclose'] || strtotime('now') < $sqlrow['timeclose']) {
                // The attempt is still in progress.
                //$timetaken = format_time($viewobj->timenow - $attempt->timestart);
                echo $datecompleted = get_string('inprogress', 'quiz');
            } else {
                $timetaken = format_time($sqlrow['timefinish'] - $sqlrow['timestart']);
                echo $datecompleted = userdate($sqlrow['timeclose']);
            }		  
		  ?>
		  </td><?php }  if($viewreport['markperformance']!='0'){ ?>
		  <td style="text-align:center"><?=round($sqlrow['grade']);?></td>
		  <?php } if($viewreport['modulecompleted']!='0'){ ?>
		  <td>
          <?php
			$sqlA=mysql_query("
				Select
				  b.status As status1,
				  b.userid,
				  a.courseid,
				  a.enrol
				From
				  mdl_cifaenrol a Inner Join
				  mdl_cifauser_enrolments b On a.id = b.enrolid Inner Join
				  mdl_cifacourse c On a.courseid = c.id
				Where
				  b.status != '1' And
				  c.category = '1' And
				  b.userid = '".$sqlrow['userid']."'				
			");
			$sqlcount=mysql_num_rows($sqlA);
			echo $sqlcount." of ".$sqlcount." Modules";
		  ?>
          </td>
		  <?php } if($viewreport['totaltimeperformance']!='0'){ ?>
		  <td style="text-align:center;">
		  <?php
			echo format_time($sqlrow['timefinish'] - $sqlrow['timestart']);
		  ?>
		  </td><?php } if($viewreport['examinationstatus']!='0'){ ?>
		  <td style="text-align:center;">
		  <?php
			// echo format_time($sqlrow['timefinish'] - $sqlrow['timestart']);
				$grade=round($sqlrow['grade']);
				if($grade < '70'){
					echo 'Fail';
				}else{ echo 'Pass'; }			
		  ?>
		  </td><?php } ?>
          <td style="text-align:center;"><input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['id'];?>" /></td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="15" scope="row">Records not found</td></tr>
<?php } ?>
		</table><br/><br/></form>	  
  </fieldset>
 <?php }else if($viewreport['selectedreport']=='1'){ ?>
  
  
<!--////- Examination Performance -////-->
 <fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">IPD Course Performance</legend><br/>

<form name="form2" id="form2" action="" method="post">
	<div style="margin-left:1em;font-size:2em; font-weight:bolder;"><?=$viewreport['reportname'];?></div>
    <div style="margin-left:2em;margin-bottom:1em;"><?=$creator['name'];?>, <?=date('d/m/Y h:i:s', $viewreport['timecreated']);?></div>
    
	<table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="left">
				<!--b>DOWNLOAD</b-->
			  <input type="submit" name="download_html_2" id="id_defaultbutton" value="HTML" title="<?=get_string('titledownload');?>" onClick="this.form.action='<?//=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" />
				<input type="submit" name="download_excel_2" id="id_defaultbutton" value="EXCEL" title="<?=get_string('titledownload');?>" onClick="this.form.action='<?//=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" />
				<input type="submit" name="download_csv_" id="id_defaultbutton" value="CSV" title="<?=get_string('titledownload');?>" onClick="this.form.action='<?//=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" />
			</td>
			<td align="right"><input type="submit" name="buttonback2" id="id_defaultbutton" onclick="this.form.action='<?=$CFG->wwwroot. '/examcenter/myreport.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" />
			  <input type="submit" name="buttonprint2" id="id_defaultbutton" value="Print" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/reportview_print.php?id='.$_GET['id'];?>', target='_blank'" />
			  <input type="button" name="unselectall" id="unselectall" value="Unselect All" onclick="clearSelected2();" />
				<input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll2()"/></td>
		</tr>    
	</table>
	
<?php		
	$statement="
		  mdl_cifaquiz a Inner Join
		  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
		  mdl_cifaquiz_grades c On b.quiz = c.quiz And b.userid = c.userid Inner Join
		  mdl_cifacourse d On a.course = d.id Inner Join
		  mdl_cifauser e On b.userid = e.id
	";
	
	$statement.=" WHERE d.category = '3' AND visible!='0'";
	$csql="SELECT *, d.idnumber as code FROM {$statement}";
	$sqlquery=mysql_query($csql);	
?>	
	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		<?php if(($creator['id']=='12') || ($creator['id']=='13')){ ?>
        	  <?php if($viewreport['candidateID']!='0'){ ?>
			  <th width="15%" scope="row"><?=get_string('candidateid');?></th>
              <?php }if($viewreport['candidateFullname']!='0'){ ?>
			  <th width="20%"><?=get_string('fullname');?></th>
              <?php }if($viewreport['candidateEmail']!='0'){ ?>
			  <th width="20%"><?=get_string('email');?></th>
              <?php }if($viewreport['candidateAddress']!='0'){ ?>
			  <th width="20%"><?=get_string('address');?></th>
              <?php }if($viewreport['candidateTel']!='0'){ ?>
			  <th width="20%"><?=get_string('officetel');?></th>
		<?php }}else if(($creator['id']=='10')){ ?>
			  <th width="15%" scope="row"><?=get_string('candidateid');?></th>
			  <th width="20%"><?=get_string('fullname');?></th>		
		<?php } ?>		
		  <?php if($viewreport['cnameexam']!='0'){ ?>
		  <th width="25%" scope="row"><?=get_string('coursetitle');?></th>
		  <?php } if($viewreport['ccodeexam']!='0'){ ?>
		  <th width="14%"><?=get_string('curriculumcode');?></th>
          <?php } if($viewreport['cattempts']!='0'){ ?>
		  	<th width="8%"> Attempts</th> 
          <?php } if($viewreport['learningoutcomes']!='0'){ ?>   
		  	<th width="24%">Learning Outcome</th>
		  <?php } if($viewreport['scoreonlo']!='0'){ ?>
		  	<th width="9%">Score</th>
		  <?php } if($viewreport['passes']!='0'){ ?>
		  	<th width="9%">Passes</th>
		  <?php } if($viewreport['passrate']!='0'){ ?>
		  	<th width="9%">Pass rate</th>
		  <?php }  ?>
          <th width="2%">&nbsp;</th>
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil=$no++;
	
	//country list
	$countrylistsql=mysql_query("SELECT * FROM {$CFG->prefix}country_list WHERE countrycode='".$sqlrow['country']."'");
	$countrylist=mysql_fetch_array($countrylistsql);
	
	$fulladdress=ucwords(strtolower($sqlrow['address'].' '.$sqlrow['address2'].' '.$sqlrow['address3'].', '.$sqlrow['postcode'].' '.$sqlrow['city'].' '.$sqlrow['state'].', '.$countrylist['countryname']));	
?>
<tr>
		<?php if(($creator['id']=='12') || ($creator['id']=='13')){ ?>
          <?php if($viewreport['candidateID']!='0'){ ?>
		  <td style="text-align:center" scope="row"><?=strtoupper($sqlrow['traineeid']);?></td>
          <?php }if($viewreport['candidateFullname']!='0'){ ?>
		  <td><?=ucwords(strtolower($sqlrow['firstname'].' '.$sqlrow['lastname']));?></td>	
          <?php }if($viewreport['candidateEmail']!='0'){ ?>
		  <td style="text-align:center" scope="row"><?=$sqlrow['email'];?></td>
          <?php }if($viewreport['candidateAddress']!='0'){ ?>
		  <td><?=$fulladdress;?></td>	
          <?php }if($viewreport['candidateTel']!='0'){ ?>
		  <td><?='+'.$countrylist['iso_countrycode'].$sqlrow['phone1'];?></td>
		<?php }}else if(($creator['id']=='10')){ ?>
		  <td style="text-align:center" scope="row"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname'].' '.$sqlrow['lastname']));?></td>	
		<?php } ?>	
		  <?php if($viewreport['cnameexam']!='0'){ ?>
			<td style="text-align:left" scope="row"><?=$sqlrow['fullname'];?></td>
		  <?php } if($viewreport['ccodeexam']!='0'){ ?>
			<td><?=ucwords(strtolower($sqlrow['code']));?></td>
          <?php } if($viewreport['cattempts']!='0'){ ?>
			<td style="text-align:center"><?=$sqlrow['attempt'];?></td>
          <?php } if($viewreport['learningoutcomes']!='0'){ ?>
			<td style="text-align:center">&nbsp;</td>
		  <?php }  if($viewreport['scoreonlo']!='0'){ ?>
			<td style="text-align:center"><?=round($sqlrow['grade']);?>%</td>
		  <?php } if($viewreport['passes']!='0'){ ?>
			<td>
            <?php 
				$grade=round($sqlrow['grade']);
				if($grade < '70'){
					echo 'Fail';
				}else{ echo 'Pass'; }
			?>
            </td>
		  <?php } if($viewreport['passrate']!='0'){ ?>
			<td style="text-align:center;">
<?php
				$sgrade=mysql_query("
					Select
					  *,
					  a.grade As usergrade, b.id As quizid
					From
					  mdl_cifaquiz_grades a,
					  mdl_cifaquiz b Inner Join
					  mdl_cifacourse c On b.course = c.id
					Where
					  a.quiz = b.id And a.grade >= 70 And
					  (c.category = '3' And
					  a.userid = '".$sqlrow['userid']."')				
				");
				$cq=mysql_num_rows($sgrade); //count records
				
				$passsql=mysql_query("
					Select
					  c.userid,
					  a.fullname,
					  c.attempt
					From
					  mdl_cifacourse a Inner Join
					  mdl_cifaquiz b On a.id = b.course Inner Join
					  mdl_cifaquiz_attempts c On b.id = c.quiz
					Where
					  a.category = '3' And
					  a.visible != '0'				
				");
				$passrate=mysql_num_rows($passsql); 
				
				$countpassrate=($cq / $passrate)*100;
				echo round($countpassrate).'%';
		  ?>
		  </td><?php } ?>
          <td style="text-align:center;"><input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['id'];?>" /></td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="15" scope="row">Records not found</td></tr>
<?php } ?>
		</table><br/><br/></form>	  
  </fieldset>

<?php }else{ ?>
  
<!--////-Statistic-////-->
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Course Statistics(%)</legend><br/>

<form name="form3" id="form3" action="" method="post">
	<div style="margin-left:1em;font-size:2em; font-weight:bolder;"><?=$viewreport['reportname'];?></div>
    <div style="margin-left:2em;margin-bottom:1em;"><?=$creator['name'];?>, <?=date('d/m/Y h:i:s', $viewreport['timecreated']);?></div>
    
	<table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="left">
				<!--b>DOWNLOAD</b-->
			  <input type="submit" name="download_html_3" id="id_defaultbutton" value="HTML" title="<?=get_string('titledownload');?>" onClick="this.form.action='<?//=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" />
				<input type="submit" name="download_excel_3" id="id_defaultbutton" value="EXCEL" title="<?=get_string('titledownload');?>" onClick="this.form.action='<?//=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" />
				<input type="submit" name="download_csv_3" id="id_defaultbutton" value="CSV" title="<?=get_string('titledownload');?>" onClick="this.form.action='<?//=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" />
			</td>
			<td align="right"><input type="submit" name="buttonback2" id="id_defaultbutton" onclick="this.form.action='<?=$CFG->wwwroot. '/examcenter/myreport.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" />
			  <input type="submit" name="buttonprint2" id="id_defaultbutton" value="Print" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/reportview_print.php?id='.$_GET['id'];?>', target='_blank'" />
			  <input type="button" name="unselectall" id="unselectall" value="Unselect All" onclick="clearSelected3();" />
				<input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll3()"/></td>
		</tr>    
	</table>
	
<?php		
	$statement="
		  mdl_cifaquiz a Inner Join
		  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
		  mdl_cifaquiz_grades c On b.quiz = c.quiz And b.userid = c.userid Inner Join
		  mdl_cifacourse d On a.course = d.id Inner Join
		  mdl_cifauser e On b.userid = e.id
	";
	
	$statement.=" WHERE d.category = '3'";
	$csql="SELECT *, d.idnumber as code FROM {$statement} GROUP BY d.id";
	$sqlquery=mysql_query($csql);	
?>	
	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		<?php if(($creator['id']=='12') || ($creator['id']=='13')){ ?>
        	  <?php if($viewreport['candidateID']!='0'){ ?>
			  <th width="15%" scope="row"><?=get_string('candidateid');?></th>
              <?php }if($viewreport['candidateFullname']!='0'){ ?>
			  <th width="20%"><?=get_string('fullname');?></th>
              <?php }if($viewreport['candidateEmail']!='0'){ ?>
			  <th width="20%"><?=get_string('email');?></th>
              <?php }if($viewreport['candidateAddress']!='0'){ ?>
			  <th width="20%"><?=get_string('address');?></th>
              <?php }if($viewreport['candidateTel']!='0'){ ?>
			  <th width="20%"><?=get_string('officetel');?></th>
		<?php }}else if(($creator['id']=='10')){ ?>
			  <th width="15%" scope="row"><?=get_string('candidateid');?></th>
			  <th width="20%"><?=get_string('fullname');?></th>		
		<?php } ?>		
		  <?php if($viewreport['cname_statistics']!='0'){ ?>
		  <th width="24%" scope="row">Course Title</th>
		  <?php } if($viewreport['ccode_statistics']!='0'){ ?>
		  <th width="15%">Code</th>
          <?php } if($viewreport['statusstistics']!='0'){ ?>
		  	<th width="14%">Status</th> 
          <?php  } if($viewreport['mcomplete_statistics']!='0'){ ?>   
		  	<th width="18%">Modules Completed</th>
		  <?php  }  if($viewreport['examstatus_statistics']!='0'){ ?>
		  	<th width="14%">Test Status</th>
		  <?php  } if($viewreport['totaltime_statistics']!='0'){ ?>
		  	<th width="13%">Total Time</th>
		  <?php }  ?>
          <th width="2%">&nbsp;</th>		  
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil=$no++;

	//country list
	$countrylistsql=mysql_query("SELECT * FROM {$CFG->prefix}country_list WHERE countrycode='".$sqlrow['country']."'");
	$countrylist=mysql_fetch_array($countrylistsql);
	
	$fulladdress=ucwords(strtolower($sqlrow['address'].' '.$sqlrow['address2'].' '.$sqlrow['address3'].', '.$sqlrow['postcode'].' '.$sqlrow['city'].' '.$sqlrow['state'].', '.$countrylist['countryname']));	
	
	$coursequery=mysql_query("
		Select
		  b.status As status1,
		  b.userid,
		  a.courseid,
		  a.enrol
		From
		  mdl_cifaenrol a Inner Join
		  mdl_cifauser_enrolments b On a.id = b.enrolid
		Where
		  b.status != '1' And
		  a.courseid = '".$sqlrow['course']."'	
	");
	$course=mysql_fetch_array($coursequery);
	$cc=mysql_num_rows($coursequery);
?>
		<tr>
		<?php if(($creator['id']=='12') || ($creator['id']=='13')){ ?>
          <?php if($viewreport['candidateID']!='0'){ ?>
		  <td style="text-align:center" scope="row"><?=strtoupper($sqlrow['traineeid']);?></td>
          <?php }if($viewreport['candidateFullname']!='0'){ ?>
		  <td><?=ucwords(strtolower($sqlrow['firstname'].' '.$sqlrow['lastname']));?></td>	
          <?php }if($viewreport['candidateEmail']!='0'){ ?>
		  <td style="text-align:center" scope="row"><?=$sqlrow['email'];?></td>
          <?php }if($viewreport['candidateAddress']!='0'){ ?>
		  <td><?=$fulladdress;?></td>	
          <?php }if($viewreport['candidateTel']!='0'){ ?>
		  <td><?='+'.$countrylist['iso_countrycode'].$sqlrow['phone1'];?></td>
		<?php }}else if(($creator['id']=='10')){ ?>
		  <td style="text-align:center" scope="row"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname'].' '.$sqlrow['lastname']));?></td>	
		<?php } ?>			
		  <?php if($viewreport['cname_statistics']!='0'){ ?>
		  <td style="text-align:left" scope="row"><?=$sqlrow['fullname'];?></td>
		  <?php } if($viewreport['ccode_statistics']!='0'){ ?>
		  <td><?=$sqlrow['code'];?></td>
          <?php } if($viewreport['statusstistics']!='0'){ ?>
          <td style="text-align:left; padding-left:0.5em;">
          Subscribed  - 50%<br />
          In Progress - 30%<br />
          Completed  -  20%<br />          
          </td>
          <?php  } if($viewreport['mcomplete_statistics']!='0'){ ?>
		  <td style="text-align:center">M01 - X% <br/> M02 - X%</td>
		  <?php  }  if($viewreport['examstatus_statistics']!='0'){ ?>
		  <td style="text-align:left; padding-left:0.5em;">
		  	<?//=round($sqlrow['grade']);?>
              Pass  - 84%<br />
              Fail - 3%<br />
              Absent  - 3%<br />   
              Expired  - 10%<br />          
          </td>
		  <?php  } if($viewreport['totaltime_statistics']!='0'){ ?>
		  <td><?php echo format_time($sqlrow['timefinish'] - $sqlrow['timestart']);?></td>
		  <?php  } ?>
          <td style="text-align:center;"><input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['id'];?>" /></td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="15" scope="row">Records not found</td></tr>
<?php } ?>
		</table><br/><br/></form> 
  </fieldset>   
  
<?php
	}
	echo $OUTPUT->footer();
?>