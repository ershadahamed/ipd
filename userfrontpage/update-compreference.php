<?php 
    require_once('../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php'); 

	$site = get_site();
	
	$viewresult='Edit '.get_string('communicationpreferences');
	$title="$SITE->shortname: ".$viewresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	//$PAGE->set_pagelayout('course');
	$PAGE->navbar->add($viewresult);

	echo $OUTPUT->header();	
	echo $OUTPUT->heading($viewresult, 2, 'headingblock header');
	$link2=$CFG->wwwroot. "/userfrontpage/update-compreference-2.php?id=".$USER->id;
?>
<?php 	
	$policyname='CIFA';
	//$policyname='SHAPE<sup>TM</sup>';
	
	$selectstatement=mysql_query("SELECT * FROM mdl_cifacommunication_reference WHERE candidateid='".$USER->id."'");
	$ssql=mysql_fetch_array($selectstatement);
	
	$rules1=$ssql['rules1'];
	$rules2=$ssql['rules2'];
	$rules3=$ssql['rules3'];
	
	$rulesstatement=mysql_query("SELECT * FROM mdl_cifacommunication_rules");	
	$count++;
	$count2++;
	$count3++;
	$strrequired='<font color="red">*</font>';
?>
<form method="post" name="form"  action="<?=$link2;?>">
<div style="min-height:300px;padding: 0px 0px 20px 0px;">
<table id="userpolicy"><tr><td style="align:justify;">
<table style="width:95%;margin:0 auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;"><tr><td>
<p>Please read the options in this column carefully. </p>
<table style="width:95%;margin:0 auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;">
	<?php 
		while($rulesql=mysql_fetch_array($rulesstatement)){ 
		if($rulesql['visible_2']!='0'){
	?> 
	<tr valign="top"><td>
	<input type="checkbox" name="column<?=$count2++;?>" id="column<?=$count3++;?>" <?php echo 'value="1" checked="checked"'; if($rulesql['existingreg']=='1'){ echo 'disabled="disabled"';} ?> /></td><td>
	<?php
		echo $rulesql['rules_text'];
		if($rulesql['existingreg']=='1'){ echo $strrequired; }
	?>
	</td>
	</tr>
	<?php 
		} }
	?>
  <!--tr valign="top"><td>
  <input type="checkbox" name="column1" id="column1" <?php echo 'value="1" checked'; ?> disabled="disabled" /></td><td>
  Declaration of status to  third party. This is compulsory. For example, if we are approached by employers  and recruitment consultants to verify the CIFA status of job candidates. <?=$strrequired;?></td>
  </tr>
  <tr valign="top"><td>
  <input type="checkbox" name="column2" id="column2" <?php echo 'value="1" checked'; ?> /></td><td>
  We also need to know if  you are happy to receive promotional literature. These might include  information about training programs, recruitment opportunities and other business  services. Your details are never passed directly to the advertising  organizations concerned. The mailings are carried out by our appointed mailing  house. </td></tr-->
  <!--tr valign="top"><td>
  <input type="checkbox" name="column3" id="column3" <?php //echo 'value="1" checked';?> /></td><td>
  <?//=$policyname;?> Online  Training Program Access and Usage Policy. You need to read and agree to the  terms and policy to proceed to the payment page. The policy is also available  in your CIFA Workspace under &ldquo;<strong>My Training&rdquo;. </strong></td></tr--></table>
  
</td></tr></table>

</td></tr></table>

<table style="width:10%; margin:0 auto;">
<tr valign="top"><td><input type="submit" name="proceddnext" value=" Update " /></td></tr>
</table>
</div>
</form>
<?php echo $OUTPUT->footer(); ?>