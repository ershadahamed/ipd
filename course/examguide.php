<?php	
    require_once('../config.php');
	require_once('../manualdbconfig.php');
    require_once('lib.php');
    require_once($CFG->dirroot.'/mod/forum/lib.php');
    require_once($CFG->libdir.'/completionlib.php');
	
	
	$site = get_site();
	
	$examguidetitle=ucwords(strtolower(get_string('eguide')));
	$title="$SITE->shortname: ".$examguidetitle;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('examguide');
		
	$queryeg=mysql_query("SELECT fullname FROM mdl_cifacourse WHERE id='".$_GET['id']."'");
	$roweg=mysql_fetch_array($queryeg);
	$coursename=$roweg['fullname'];	
	
	$urlat = new moodle_url('/coursesindex.php?id='.$USER->id);
	$urlcourse = new moodle_url('/course/view.php?id='.$_GET['id']);
	$PAGE->navbar->add(get_string('activetrainings'), $urlat)->add($coursename, $urlcourse)->add($examguidetitle);		
	
	echo $OUTPUT->header();
	
	if (isloggedin()) {
	$examguide=get_string('eguide');
	echo $OUTPUT->heading($examguide, 2, 'headingblock header');
?>
<style>
.header a:hover
{
background-color: rgb(86, 179, 201);
}
</style>
<table>
<tr>
	<td><?php 
			$sql=mysql_query("
				Select
					  a.section,
					  a.course,
					  a.summary
					From
					  mdl_cifacourse_sections a
					Where
					  a.section = '0' And
					  a.course = '".$_GET['id']."'
			");
			$sqlexamguide=mysql_fetch_array($sql);
			$sqlcount=mysql_num_rows($sqlexamguide);
			if($sqlcount!='0'){
				if($sqlexamguide['name']!=null){ echo '<strong>'.$sqlexamguide['name'].'</strong><br/>';}
				echo $sqlexamguide['summary'];
			}
			
			if($sqlcount==''){
				echo 'There is no guide for this exam.';
			 }
	?></td>
</tr></table>
<?php	
	}else{
		redirect($CFG->wwwroot.'/index.php') ;
	}
	echo $OUTPUT->footer();	
?>