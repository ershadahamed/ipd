<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = get_string('myreport');
	$myadmin = get_string('myadmin');
	$creatednewreport = get_string('creatednewreport');
	$url1=new moodle_url('/examcenter/myreport.php', array('id'=>$USER->id));  	
    $PAGE->navbar->add(ucwords(strtolower($myadmin)), $url1)->add(ucwords(strtolower($listusertoken)), $url1)->add(ucwords(strtolower($creatednewreport)), $url1);	

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
<script src="../script/jquery-1.9.1.js" type="text/javascript"></script>
<link href="http://fiddle.jshell.net/css/result-light.css" type="text/css" rel="stylesheet">
<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAll () {
	if (checked == false){checked = true;}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
	}
}
//  End -->
 function clearSelected(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
	}
  }
</script>

<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAllOrg () {
	if (checked == false){checked = true;}
		for (var i = 0; i < document.getElementById('form2').elements.length; i++) {
		document.getElementById('form2').elements[i].checked = checked;
		//document.getElementById('selectall').disabled=true;
	}
}
//  End -->
 function clearSelectedOrg(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('form2').elements.length; i++) {
		document.getElementById('form2').elements[i].checked = checked;
		//document.getElementById('unselectall').disabled=true;
	}
  }
</script>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
	 $(document).ready(function () {
		$('#id_radio1').click(function () {
		   $('#div2').hide('fast');
		   $('#div1').show('fast');
	});
	$('#id_radio2').click(function () {
		  $('#div1').hide('fast');
		  $('#div2').show('fast');
	 });
   });
</script>

<?php include('tree1.js'); ?>
<?php include('tree1.css'); ?>

<form name="formback" id="formback" action="" method="post">
	<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">
				<input type="submit" name="backbutton" id="id_defaultbutton" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/myreport.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" /></td>
		</tr>    
	</table>
</form>

<form name="form1" id="form1" action="" method="post">
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('reportmenu');?></legend>
<div style="color:#F00; margin-bottom:1em;"><?//=get_string('reportdeletedsuccessfully');?></div>

<?php
	$role=mysql_query("SELECT name FROM {$CFG->prefix}role WHERE id='5'");
	$nrole=mysql_fetch_array($role);	
?>

<table width="100%" style="border:none;" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-weight:bolder;" width="20%">Select Report</td>
    <td>
	<select name="selectreport" id="selectreport">
	  <option value="3" <?php if($_POST['searchindividu']=='3'){ echo 'selected'; } ?>>Candidate Profile</option>
      <option value="0" <?php if($_POST['searchindividu']=='0'){ echo 'selected'; } ?>>Candidate Performance</option>
      <option value="1" <?php if($_POST['searchindividu']=='1'){ echo 'selected'; } ?>>Examination Performance</option>
      <option value="2" <?php if($_POST['searchindividu']=='2'){ echo 'selected'; } ?>>Examination Statistic</option>
    </select></td>
  </tr>
  <tr>
    <td style="font-weight:bolder;">Report Name</td>
    <td><input name="reportnametext" type="text" id="reportnametext" size="40" <?php if($_POST['searchindividu']){ echo 'value="'.$_POST['reportnametext'].'"'; } ?>></td>
  </tr> 
  <tr style="vertical-align:top;">
    <td style="font-weight:bolder;">User Type</td>
    <td>
		<input id="id_radio1" type="radio" name="name_radio1" value="1" <?php if($_POST['name_radio1']=='1'){ echo 'checked'; } ?>  checked="checked" />Individual<br>
		<input id="id_radio2" type="radio" name="name_radio1" value="2" <?php if($_POST['name_radio1']=='2'){ echo 'checked'; } ?> />Organization
	</td>
  </tr> 
</table>
</fieldset><br/>

<!----For Individual---->
<div id="div1" <?php if($_POST['name_radio1']=='2'){ echo 'style="display:none"'; } ?>>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Individual</legend>
<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17%" scope="row">
      <?=get_string('candidatedetails');?></td>
    <td width="0%">:</td>
    <td width="83%">
	<select name="individualitem" id="individualitem" style="width:200px;">
	  <option value="traineeid"><?=get_string('candidateid');?></option>
	  <option value="firstname"><?=get_string('firstname');?></option>
	  <option value="lastname"><?=get_string('lastname');?></option>
	  <option value="dob"><?=get_string('dateofbirth');?></option>
    </select>
	<input name="individusearch" type="text" id="individusearch" size="40" />
	<input type="submit" name="searchindividu" id="searchindividu" value="Search" />
	</td></tr> 
</table>
<!--/form-->
<?php
	if($_POST['searchindividu']){	
		$selectreport=$_POST['selectreport'];
		$reportname=$_POST['reportnametext'];
		$grouptype=$_POST['name_radio1'];
	}else{
		$selectreport=$_POST['selectreport'];
		$reportname=$_POST['reportnametext'];
		$grouptype=$_POST['name_radio1'];
	}
?>
	<table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
        	<td><?=get_string('newreportindividualnotice');?></td>
			<td align="right">
				<input type="submit" name="confirmindividual" id="confirmindividual" value="Confirm" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/reportmenu_action.php?id='.$USER->id.'&sreport='.$selectreport.'&nreport='.$reportname;?>'" />            
            	<input type="button" name="unselectall" id="unselectall" value="Unselect All" onclick="clearSelected();" />
				<input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll()"/>
          </td>
		</tr>    
	</table>	
    
<?php
	//individu part
	$individualitem=$_POST['individualitem'];
	$individusearch=$_POST['individusearch'];	
		
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken On b.courseid = mdl_cifauser_accesstoken.courseid And mdl_cifauser_accesstoken.userid = d.id	
	";
	
	$statement.=" WHERE a.category = '3' AND d.usertype='".$nrole['name']."'";
	if($individusearch!=''){
		if($individualitem=='dob'){
			$statement.=" AND ((date_format(from_unixtime(d.dob), '%d/%m/%Y') LIKE '%{$individusearch}%'))";
		}else{
			$statement.=" AND {$individualitem} LIKE '%{$individusearch}%'";
		}
	}
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} GROUP BY d.firstname, d.lastname, c.userid ORDER BY d.traineeid ASC";
	$sqlquery=mysql_query($csql);	
?>	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th width="15%" scope="row"><?=get_string('candidateid');?></th>
		  <th width="20%"><?=get_string('firstname');?></th>
		  <th width="20%"><?=get_string('lastname');?></th>          
		  <th width="10%"><?=get_string('dob');?></th>
		  <th width="12%"><?=get_string('organization');?></th>
          <th width="1%">&nbsp;</th>
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$linkto=$CFG->wwwroot. "/offlineexam/candidate_examsummary.php?id=".$sqlrow['userid']."&examid=".$sqlrow['examid'];
	$bil=$no++;
?>
		<tr>
		  <td style="text-align:center"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname']));?></td>
          <td><?=ucwords(strtolower($sqlrow['lastname']));?></td>
		  <td style="text-align:center"><?=date('d/m/Y' ,$sqlrow['dob']);?></td>
		  <td style="text-align:center">
		  <?php
			if($sqlrow['empname']!=''){ echo $sqlrow['empname']; }else{ echo ' - '; }?>
		  </td>
          <td style="text-align:center;">
		  <?php if($_POST['searchindividu']){ ?>
			<input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['id'];?>" />
		  <?php }else{ ?>
		  <input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['id'];?>" />
		  <?php } ?>
		  </td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="10" scope="row">Records not found</td></tr>
<?php } ?>
		</table><br/>	  
  </fieldset>
  </div>
  <!--/form-->

  
<!----For Organization---->
<div id="div2" <?php if($_POST['name_radio1']=='1'){ echo 'style="display:none"'; }else if(($_POST['name_radio1']!='1') && ($_POST['name_radio1']!='2')){ echo 'style="display:none"'; } ?>>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Organization</legend>

<div role="application">

<ul id="tree1" class="tree" role="tree" aria-labelledby="label_1">
  
  <?php 
	  /******/ 
	  $sqlorg=mysql_query("SELECT * FROM {$CFG->prefix}organization_type");
	  $no='0';
	  while($sorg=mysql_fetch_array($sqlorg)){
		  $bil=$no++;
		  $orgname=$sorg['name'];
  ?>
  <li id="fruits" role="treeitem" tabindex="0" aria-expanded="true">
  <input type="checkbox" name="organizationname[]" id="organizationname" value="a" /><?=$orgname;?>
    <ul role="group">
      <li id="oranges" role="treeitem" tabindex="-1"><input type="checkbox" name="organizationname[]" id="organizationname" value="a" />Oranges</li>
      <li id="pinapples" role="treeitem" tabindex="-1">Pineapples</li>
      <li id="apples" role="treeitem" tabindex="-1" aria-expanded="false">Apples
        <ul role="group">
          <li id="macintosh" role="treeitem" tabindex="-1">Macintosh</li>
          <li id="granny_smith" role="treeitem" tabindex="-1" aria-expanded="false">Granny Smith
            <ul role="group">
              <li id="Washington" role="treeitem" tabindex="-1">Washington State</li>
              <li id="Michigan" role="treeitem" tabindex="-1">Michigan</li>
              <li id="New_York" role="treeitem" tabindex="-1">New York</li>
            </ul>
          </li>
          <li id="fuji" role="treeitem" tabindex="-1">Fuji</li>
        </ul>
      </li>
      <li id="bananas" role="treeitem" tabindex="-1">Bananas</li>    
      <li id="pears" role="treeitem" tabindex="-1">Pears</li>    
    </ul>
  </li>
  <?php } /******/ ?>
  
  <?php /* ?>
  <li id="vegetables" role="treeitem" tabindex="-1" aria-expanded="true">Vegetables
    <ul role="group">
      <li id="broccoli" role="treeitem" tabindex="-1">Broccoli</li>
      <li id="carrots" role="treeitem" tabindex="-1">Carrots</li>
      <li id="lettuce" role="treeitem" tabindex="-1" aria-expanded="false">Lettuce
      <ul role="group">
          <li id="romaine" role="treeitem" tabindex="-1">Romaine</li>
          <li id="iceberg" role="treeitem" tabindex="-1">Iceberg</li>
          <li id="butterhead" role="treeitem" tabindex="-1">Butterhead</li>
      </ul>
      </li>
      <li id="spinach" role="treeitem" tabindex="-1">Spinach</li>    
      <li id="squash" role="treeitem" tabindex="-1" aria-expanded="true">Squash
        <ul role="group" >
          <li id="acorn" role="treeitem" tabindex="-1">Acorn</li>
          <li id="ambercup" role="treeitem" tabindex="-1">Ambercup</li>
          <li id="autumn_cup" role="treeitem" tabindex="-1">Autumn Cup</li>
          <li id="hubbard" role="treeitem" tabindex="-1">Hubbard</li>
          <li id="kobacha" role="treeitem" tabindex="-1">Kabocha</li>
          <li id="butternut" role="treeitem" tabindex="-1">Butternut</li>
          <li id="spaghetti" role="treeitem" tabindex="-1">Spaghetti</li>
          <li id="sweet_dumpling" role="treeitem" tabindex="-1">Sweet Dumpling</li>
          <li id="turban" role="treeitem" tabindex="-1">Turban</li>
        </ul>
      </li>
    </ul>
  </li><?php */ ?>
</ul>

</div> 

<!--table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17%" scope="row">
      <?=get_string('candidatedetails');?></td>
    <td width="0%">:</td>
    <td width="83%">
	<select name="individualitem2" id="individualitem2" style="width:200px;">
	  <option value="traineeid"><?=get_string('candidateid');?></option>
	  <option value="firstname"><?=get_string('firstname');?></option>
	  <option value="lastname"><?=get_string('lastname');?></option>
	  <option value="dob"><?=get_string('dateofbirth');?></option>
    </select>
	<input name="individusearch2" type="text" id="individusearch2" size="40" />
	<input type="submit" name="searchindividu" id="searchindividu" value="Search" />
	</td></tr> 
</table-->

<?php
	/*if($_POST['searchindividu']){	
		$selectreport=$_POST['selectreport'];
		$reportname=$_POST['reportnametext'];
		$grouptype=$_POST['name_radio1'];
	}else{
		$selectreport=$_POST['selectreport'];
		$reportname=$_POST['reportnametext'];
		$grouptype=$_POST['name_radio1'];
	}
?>

	<table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
        	<td><?=get_string('newreportorgnotice');?></td>
			<td align="right">
				<input type="submit" name="confirmindividual" id="confirmindividual" value="Confirm" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/reportmenu_action.php?id='.$USER->id.'&sreport='.$selectreport.'&nreport='.$reportname;?>'" /> 
				<!--input type="submit" name="confirmorg" id="confirmorg" value="Confirm" onClick="this.form.action='<?//=$CFG->wwwroot. '/offlineexam/downloadtoken.php?id='.$sqlrow['userid'];?>'" /-->            
            	<input type="button" name="unselectallorg" id="unselectallorg" value="Unselect All" onclick="clearSelected();" />
				<input type="button" name="selectallorg" id="selectallorg" value="Select All" onClick="checkedAll()"/>
          </td>
		</tr>    
	</table>	
    
<?php
	// organization 
	$individualitem2=$_POST['individualitem2']; 
	$individusearch2=$_POST['individusearch2'];
	
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken On b.courseid = mdl_cifauser_accesstoken.courseid And
		mdl_cifauser_accesstoken.userid = d.id	
	";
	
	$statement.=" WHERE a.category = '3' AND d.usertype='".$nrole['name']."'";
	if($individusearch2!=''){
		if($individualitem2=='dob'){
			$statement.=" AND ((date_format(from_unixtime(d.dob), '%d/%m/%Y') LIKE '%{$individusearch2}%'))";
		}else{
			$statement.=" AND {$individualitem2} LIKE '%{$individusearch2}%'";
		}
	}	
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} GROUP BY d.firstname, d.lastname, c.userid ORDER BY d.traineeid ASC";
	$sqlquery=mysql_query($csql);	
?>	
	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th width="15%" scope="row"><?=get_string('candidateid');?></th>
		  <th width="20%"><?=get_string('firstname');?></th>
		  <th width="20%"><?=get_string('lastname');?></th>          
		  <th width="10%"><?=get_string('dob');?></th>
		  <th width="12%"><?=get_string('organization');?></th>
          <th width="1%">&nbsp;</th>
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$linkto=$CFG->wwwroot. "/offlineexam/candidate_examsummary.php?id=".$sqlrow['userid']."&examid=".$sqlrow['examid'];
	$bil=$no++;
?>
		<tr>
		  <td style="text-align:center"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname']));?></td>
          <td><?=ucwords(strtolower($sqlrow['lastname']));?></td>
		  <td style="text-align:center"><?=date('d/m/Y' ,$sqlrow['dob']);?></td>
		  <td style="text-align:center">
		  <?php
			if($sqlrow['empname']!=''){ echo $sqlrow['empname']; }else{ echo ' - '; }?>
		  </td>
          <td style="text-align:center;">
		  <?php if($_POST['searchindividu']){ ?>
			<input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['id'];?>" />
		  <?php }else{ ?>
		  <input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['id'];?>" />
		  <?php } ?>
		  </td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="10" scope="row">Records not found</td></tr>
<?php } ?>
		</table>	*/ ?> 
  
  </fieldset> </div> </form><br/>


<?php 
	echo $OUTPUT->footer();
?>