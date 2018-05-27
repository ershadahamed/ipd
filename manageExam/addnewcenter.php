 <?php   require_once('../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');

    if ($CFG->forcelogin) {
        require_login();
    } else {
        user_accesstime_log();
    }

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);

    $PAGE->set_pagetype('site-index');
    $PAGE->set_other_editing_capability('moodle/course:manageactivities');
    $PAGE->set_docs_path('');
    $PAGE->set_pagelayout('frontpage');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	//header
    echo $OUTPUT->header();
	echo $OUTPUT->heading(get_string('manageexamcentre'), 2, 'headingblock header');
	echo '<br/>';
?>
<style>
<?php 
	include('style.css'); 
	include('button.css');
?>
</style>
<?php include('../manualdbconfig.php'); ?>
<fieldset style="border:1px solid #3D91CB; margin-right: auto; margin-left: auto; background-color:#EFF7FB;">
	<legend style="font-weight: bold; margin: 0 10px 0 10px; padding:0 10px 0 10px;">New centre registration</legend> 
	<?php 
	$displaymessage="New centre successfully added.";
	if (count($_POST)>0) echo '<div style="padding:5px; color: red; font-weight:bold;">'.$displaymessage.'</div>'; 
	
	include('scriptcode.php');?>
		<!--form name="mform1" method="post" action="manageexam-exe.php" onSubmit="return validate(mform1)" onClick="return displ();" -->
		<form name="mform1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onSubmit="return validate(mform1)" onClick="return displ();">
		<?php include('form_centre.php'); ?>
		</form>
		<?php include('form-jscript-mform.php'); ?>	
		<?php 
			if(isset($_POST['submit'])){ include('manageexam-exe.php');}
		?>
</fieldset>
 <?php   echo '<br />';
	//end content area
	
	//footer
    echo $OUTPUT->footer();?>