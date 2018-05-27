<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $instregistration = get_string('instregistration');
    $PAGE->navbar->add(ucwords(strtolower($instregistration)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
	if (isloggedin()) { if($USER->id == '2') { //if login and if admin
?>
<style>
<?php 
	include('../css/style2.css'); 
	include('../css/button.css');
	//include('../css/pagination.css');
	include('../css/grey.css');
?>
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<style>
form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px }
#progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
#percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style>

<center>
<form method="post">
<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('listoforg');?></legend>
<br/>
<?php
	$sinstitude=mysql_query("SELECT * FROM {$CFG->prefix}organization_type WHERE status='0'");
?>
<table id="availablecourse">
  <tr class="yellow">
    <th class="adjacent" width="1%">No</th>
	<th class="adjacent" width="32%" style="text-align:center;"><strong>Institution</strong></th>
    <th class="adjacent" width="32%" style="text-align:center;"><strong>Org. Type</strong></th>
    <th class="adjacent" width="15%" style="text-align:center;">Phone</th>
    <th class="adjacent" width="15%" style="text-align:center;"><strong>Date Registration</strong></th>
	<th class="adjacent" width="5%" style="text-align:center;"></th>
	<th class="adjacent" width="5%" style="text-align:center;"></th>
  </tr>
  <?php 
  	$bil='1';
  	while($qins=mysql_fetch_array($sinstitude)){ 
	$name=$qins['name'];
	$orgtype_name=$qins['org_typename'];
	$timecreated=date('d-m-Y', $qins['timecreated']);
	$phoneno=$qins['telephone'];
	$linkedit=$CFG->wwwroot. '/financialinstituition/edit_registration.php?id='.$qins['id'];
	$linkdelete=$CFG->wwwroot. '/financialinstituition/deletelist.php?id='.$qins['id'];
   ?>
  <tr>
    <td width="1%" class="adjacent" align="center"><?=$bil++;?></td>
	<td class="adjacent"  style="text-align:left"><?=$name;?></td>    
    <td class="adjacent" style="text-align:left"><?=$orgtype_name;?></td>
    <td class="adjacent" ><?=$phoneno;?></td>
    <td class="adjacent" ><?=$timecreated;?></td>
	<td class="adjacent" ><a href="<?=$linkedit;?>"><?=get_string('edit');?></a></td>
	<td class="adjacent" ><a href="<?=$linkdelete;?>"><?=get_string('delete');?></a></td>
  </tr> 
  <?php } ?> 
</table>
<br/>
</fieldset>
<input type="submit" onClick="this.form.action='<?=$CFG->wwwroot. '/financialinstituition/add_registration.php?id='.$USER->id;?>'" name="addneworg" value="<?=get_string('addneworg');?>" title="<?=get_string('addneworg');?>">
</form>
<br/>
<br/>
</center>
<?php 
	}else{ //if not admin
		echo '<div style="color:red">You cannot access this page. Thank you.</div>'; 
	}
	}else{
		echo '<div style="color:red">You cannot access this page. Please login.</div>';
	}
	echo $OUTPUT->footer();
?>