<div id="navbar">

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
	<li <?php echo checkCurrentPage('online users'); ?> ><a>Online Users</a></li>
	<li <?php echo checkCurrentPage('survey'); ?> ><a>Survey</a></li>
	<li <?php echo checkCurrentPage('reports'); ?> ><a>Reports</a></li>
</ul>

<ul class="account">
	<li><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">Account</a></li>
</ul>
<div style="clear:both;"></div>
</div> <?php //end navbar ?> 

<div id="content">
<table class="content2" cellspacing="5px" style="padding:5px;">
<tr>
	<td class="con3">
		<div style="background-color:#fff; min-height: 630px; height: 100%; box-shadow: 0px 0px 10px #000; ">	