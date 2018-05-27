<?php
require_once('../config.php');
require_once($CFG->libdir . '/tablelib.php');
require_once($CFG->libdir . '/filelib.php');
global $DB;

$id = optional_param('id', '', PARAM_INT);
$attachmentid = optional_param('aid', '', PARAM_INT);
$formtype = optional_param('type', '', PARAM_MULTILANG);

$sql="Select * From {support_attachment} Where userid='".$id."'";
$data=$DB->get_record_sql($sql);

$sql = "Select COUNT(DISTINCT id) From {support_attachment} Where userid='".$id."' And attachmentid =''";
$usercount = $DB->count_records_sql($sql);
$imglink=$CFG->wwwroot.'/organization/'.$data->attachment_path;
?>

<form style="background-color:#fff;" id="myForm" onsubmit="return validateFormOnSubmit(this)" onChange="return displ();" action="attachmentloader.php?aid=<?=$attachmentid;?>&id=<?=$id;?>&type=<?=$formtype;?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="userid" value="<?=$id;?>" />
	<fieldset style="padding: 0.6em;" id="user" class="clearfix">
		<legend style="font-weight:bolder;" class="ftoggler">Upload File</legend>
		<?php 
		if(!empty($usercount)){
		?>
		<img src="<?=$imglink;?>" alt="<?=$imglink;?>" title="<?=$imglink;?>" width="200"><br/><br/>		
		<?php } ?>
		<input type="file" size="60" name="myfile"> <span style="color:red">(File size: below than 1MB)</span>
	</fieldset>
	<div style="text-align:left; margin-top:0.8em;">
		<input type="button" onClick="window.close();" name="Close" value="Close" title="Close">
		<input type="submit" name="Submit" value="<?= get_string('save'); ?>" title="Save logo" />
	</div>
</form>
