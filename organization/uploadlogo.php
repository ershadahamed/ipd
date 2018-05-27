<?php
require_once('../config.php');
require_once($CFG->libdir . '/tablelib.php');
require_once($CFG->libdir . '/filelib.php');
global $DB;
$orgid = optional_param('orgid', '', PARAM_INT);
$code = optional_param('code', '', PARAM_INT);

$sql="Select * From {organization_logo} Where organizationid='".$orgid."'";
$data=$DB->get_record_sql($sql);

$sql = "Select COUNT(DISTINCT id) From {organization_logo} Where organizationid='".$orgid."'";
$usercount = $DB->count_records_sql($sql);
$imglink=$CFG->wwwroot.'/organization/'.$data->path_logo;
?>

<form style="background-color:#fff;" id="myForm" onsubmit="return validateFormOnSubmit(this)" onChange="return displ();" action="upload.php?id=<?=$orgid;?>&code=<?=$code;?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="organizationid" value="<?=$orgid;?>" />
	<fieldset style="padding: 0.6em;" id="user" class="clearfix">
		<legend style="font-weight:bolder;" class="ftoggler">Upload Logo</legend>
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
