<?php
    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('manualdbconfig.php'); 

	$site = get_site();
	
	$purchase='Purchase a curriculum';
	$title="$SITE->shortname: Courses - ".$purchase;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('courses');

	echo $OUTPUT->header();		
	if (isloggedin()) {
		add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
		
		echo $OUTPUT->heading($purchase, 2, 'headingblock header');
		?>
		<form name="programselection" method="post">
		<fieldset id="fieldset"><legend id="legend" style="width: 30%">Selections of online training programs available are :-</legend>
		<br/>
		<table border="0">
			<tr><td><input type="radio" name="program" value="cifa" onClick='this.form.submit()'/></td><td>CIFA Curriculum</td></tr>
			<tr><td><input type="radio" name="program" value="ipd" onClick='this.form.submit()'/></td><td>SHAPE Islamic Professional Development (IPD) Courses</td></tr>
		</table>
		</fieldset></form>
		<?php
		if (isset($_POST['program'])) {
			if($_POST['program']=='ipd'){ //ipd program
				$programtype=$_POST['program'];
				include('userfrontpage/availablecourse.php');
			}else{
				echo '<fieldset id="fieldset"><legend id="legend" style="width: 30%">CIFA Curriculum</legend>';
				echo 'No available CIFA Program';
				echo '</fieldset>';
			}
		}
	}	
	echo $OUTPUT->footer();	
?>