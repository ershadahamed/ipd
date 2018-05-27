<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $news_update = get_string('news_update');
    $PAGE->navbar->add(ucwords(strtolower($news_update)));	

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
	include('../css/grey.css');
?>
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<style>
form { display: block; margin: 20px auto; background: #eee;  border-radius: 10px; padding: 15px }
#progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
#percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style>

<center>
<form method="post">
<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('listofnews_update');?></legend>
<br/>
<?php
	$snews=mysql_query("SELECT * FROM {$CFG->prefix}news_update");
?>
<table id="availablecourse">
  <tr class="yellow">
    <th class="adjacent" width="1%">No</th>
	<th class="adjacent" width="32%" style="text-align:center;"><strong>Title</strong></th>
    <th class="adjacent" style="text-align:center;"><strong>Content</strong></th>
    <th class="adjacent" width="12%" style="text-align:center;"> Date Created</th>
    <th class="adjacent" width="8%" style="text-align:center;"><?=get_string('status');?></th>
    <!--th class="adjacent" width="15%" style="text-align:center;"><strong>Expiry Date</strong></th-->
	<th class="adjacent" width="5%" style="text-align:center;"></th>
  </tr>
  <?php 
  	$bil='1';
	$newscount=mysql_num_rows($snews);
	if($newscount!='0'){
  	while($qnews=mysql_fetch_array($snews)){ 
	$title=$qnews['title'];
	$content=$qnews['content'];
	$timecreated=date('d-m-Y', $qnews['timecreated']);
	$status=$qnews['status'];
	if($status !='0'){
		 $sstatus='Inactive';
	}else{ $sstatus='Active';}
	$linkedit=$CFG->wwwroot. '/news_update/edit_newsupdate.php?id='.$qnews['id'];
   ?>
  <tr>
    <td width="1%" class="adjacent" align="center"><?=$bil++;?></td>
	<td class="adjacent"  style="text-align:left"><?=$title;?></td>    
    <td class="adjacent" style="text-align:left"><?=$content;?></td>
    <td class="adjacent" ><?=$timecreated;?></td>
    <td class="adjacent" style="text-align:left"><?=$sstatus;?></td>
    <!--td class="adjacent" ><?//=$timecreated;?></td-->
	<td class="adjacent" ><a href="<?=$linkedit;?>"><?=get_string('edit');?></a></td>
  </tr> 
  <?php }}else{ ?> 
  <tr>
  	<td class="adjacent" style="text-align:left" colspan="6"> No records found</td>
  </tr>
  <?php } ?>
</table>
<br/>
</fieldset>
<input type="submit" onClick="this.form.action='<?=$CFG->wwwroot. '/news_update/news_update_form.php?id='.$USER->id;?>'" name="addnews" value="<?=get_string('addnews_update');?>" title="<?=get_string('addnews_update');?>">
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