<?php
    require_once('../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php'); 

	$site = get_site();
	
	$mytrainingprogram=get_string('mytrainingprogram');
	$title="$SITE->shortname: ".$mytrainingprogram;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	//$PAGE->set_pagelayout('course');

	echo $OUTPUT->header();	
?>
<style type="text/css">
<?php 
	include('../css/style2.css'); 
	include('../css/style.css'); 
?>
</style>
<?php	
	if (isloggedin()) {
		add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
		echo $OUTPUT->heading($mytrainingprogram, 2, 'headingblock header');
	?>
		<div style="margin-top: 20px; min-height: 400px;">
		<!--//list of cifa curriculum-->
		<!--fieldset id="fieldset"><legend id="legend" style="width:140px; font-weight: bolder;"><?//=ucwords(strtoupper(get_string('cifacurriculum')));?></legend>
		
		</fieldset-->
		<!--//list of SHAPE IPD	-->
		<fieldset id="fieldset" style="width:96%;"><legend id="legend" style="font-weight: bolder;">
			<?=ucwords(strtoupper(get_string('shapeipd'))).' '.get_string('courses');?>
		</legend></fieldset>
	<?php
	}	
	?>
	</div>
<?php echo $OUTPUT->footer(); ?>