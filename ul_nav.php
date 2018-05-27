<?php
function checkCurrentPage($thisPage){
	session_start();
	if($_SESSION['page_ul'] == $thisPage){
		return "class='check'";
	}
}

?>

<ul>
	<li <?php echo checkCurrentPage('home'); ?> ><a href="<?php echo $CFG->wwwroot.'/index.php';?>">Home</a></li>
	<li <?php echo checkCurrentPage('courses'); ?> ><a href="<?php echo $CFG->wwwroot.'/coursesindex.php';?>">Courses</a></li>
	<li <?php echo checkCurrentPage('exams'); ?> ><a href="<?php echo $CFG->wwwroot.'/examsindex.php';?>">Exams</a></li>
	<li <?php echo checkCurrentPage('online users'); ?>>
		<?php if (isloggedin()) { 
		add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);?>
		<a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=1';?>" target="_blank">Online Users</a>
		<?php }else{ ?>
		<a>Online Users</a>
		<?php } ?>
	</li>
	<li <?php echo checkCurrentPage('survey'); ?> ><a>Survey</a></li>
	<li <?php echo checkCurrentPage('reports'); ?> ><a>Reports</a></li>
</ul>
