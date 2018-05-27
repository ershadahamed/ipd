<?php
	require_once('../config.php');
	//require_once($CFG->libdir.'/blocklib.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');

	//require_login();

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);

	$navlink = 'Manage Trainee for Exam Registration';
	$PAGE->navbar->add($navlink);	
	
    $PAGE->set_pagetype('site-index');
    $PAGE->set_other_editing_capability('moodle/course:manageactivities');
    $PAGE->set_docs_path('');
    //$PAGE->set_pagelayout('frontpage');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname.':'. $navlink);
    $PAGE->set_heading($SITE->fullname);
	
	echo $OUTPUT->header();
	echo $OUTPUT->heading('Update payment status', 2, 'headingblock header');
?>
<br/>
<?php		
	include('../manualdbconfig.php');
	
	//courseid
	$ID=$_GET['id'];
	
	//echo $ID;
	$sqlCheck2="Select
  						*
					From
  						mdl_cifacourse a, mdl_cifa_modulesubscribe b, mdl_cifauser c 
					WHERE   a.id = b.courseid And b.traineeid = c.traineeid And (a.category = '1') And courseid='$ID'";
	$queryCheck2=mysql_query($sqlCheck2);
	$rowCheck2=mysql_fetch_array($queryCheck2)
?>
<style type="text/css">
<?php 
require_once('style.css'); 
require_once('button.css');
?>
</style>
<form name="form" id="form" method="post" action="managestudent_exe.php">
<table id="studentregistration" border="0">
	<tr>
		<td width="15%">Trainee ID</td><td width="1%">:</td>
		<td><?php echo $rowCheck2['traineeid']; ?>
			<input type="hidden" name="id" value="<?php echo $rowCheck2['courseid']; ?>" />
			<input type="hidden" name="traineeid" value="<?php echo $rowCheck2['traineeid']; ?>" />
		</td>
	</tr>
	<tr><td>Trainee Name</td><td>:</td><td><?php echo ucwords(strtolower($rowCheck2['firstname'].' '.$rowCheck2['lastname'])); ?></td></tr>
	<tr><td>Course Name</td><td>:</td><td><?php echo $rowCheck2['coursename']; ?></td></tr>
	<tr><td>Cost($)</td><td>:</td><td><?php echo $rowCheck2['cost']; ?></td></tr>
	<tr><td>Payment Status</td><td>:</td><td>
		<?php $list=array("New"=>"New","Paid"=>"Paid"); ?>
			
		<select name="payment" id="payment">
		<?php if($rowCheck2['payment_status'] == ''){ ?>
		<option value=""> -- Please choose --</option>
		<?php }else{ ?>
		<!--option value="<?php //echo $rowCheck2['payment_status'];?>" selected><?php //echo $rowCheck2['payment_status'];?></option-->
		<?php } ?>		
		<?php
		
		asort($list);
		reset($list);	
			foreach($list as $key => $value):
			echo '<option value="'.$key.'"';
			if($rowCheck2['payment_status']==$key){
			echo 'selected';}			
			echo '>'.$value.'</option>'; 
			endforeach;
		?>				
		</select>
	</td></tr>
</table><br/>

<div class="buttons" style="float: left; padding-left: 18px; margin-bottom:10px;">
    <button type="reset" class="negative" name="back" onclick="javascript:history.go(-1);" title="Back to..">
        <img src="Images/foward.png" alt="" />
        Back
    </button>

    <button type="submit" class="positive" name="submit" title="Save update data">
        <img src="Images/save.png" title="Save update" />
        Save update
    </button>
</div>
</form>
<?php
	echo '<br />';
	echo $OUTPUT->footer();
?>