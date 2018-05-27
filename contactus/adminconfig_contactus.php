<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $emailactivitys = get_string('emailactivity');
    $PAGE->navbar->add(ucwords(strtolower($emailactivitys)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
	if (isloggedin()) { //if login
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
<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('emailactivity');?></legend>
<br/>
<table id="availablecourse">
  <tr class="yellow">
    <th class="adjacent" width="1%">No</th>
	<th class="adjacent" width="30%" style="text-align:center;"><strong>Fullname</strong></th>
    <th class="adjacent" width="20%" style="text-align:center;"><strong>Email From</strong></th>
    <th class="adjacent" width="22%" style="text-align:center;"><strong>Subject</strong></th>
	<th class="adjacent" width="22%" style="text-align:center;"><strong>Message</strong></th>
	<th class="adjacent" width="5%" style="text-align:center;"><strong>Misc.</strong></th>
  </tr>
<?php
	$acemailsql=mysql_query("SELECT * FROM {$CFG->prefix}uploaded_files ORDER BY id ASC");
	while($ac=mysql_fetch_array($acemailsql)){
?>
  <tr>
    <td width="1%" class="adjacent" align="center">1</td>
	<td class="adjacent"  align="center"> - </td>    
    <td class="adjacent" >-</td>
    <td class="adjacent" >-</td>
    <td class="adjacent" >-</td>
    <td class="adjacent" >-</td>	
  </tr> 
<?php } ?>  
</table>
<br/>
</fieldset>
<br/>
<br/>
</center>
<?php 
	}else{
		echo '<div style="color:red">You cannot access this page. Please login.</div>';
	}
	echo $OUTPUT->footer();
?>