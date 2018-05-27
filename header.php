<html>
<head>
<title>CIFA LMS</title>
<link type="text/css" rel="stylesheet" href="css/style.css">
</head>

<body>
<div id="wrapper">

<div id="header">
<div class="title">CIFA Learning Management System</div>

<div class="userinfo">
<?php 
	if (isloggedin()) { 
	/*echo html_writer::start_tag('div', array('id'=>'userdetails'));
            echo html_writer::tag('h1', get_string('usergreeting', 'theme_splash', $USER->firstname));
            echo html_writer::start_tag('p', array('class'=>'prolog'));
            echo html_writer::link(new moodle_url('/user/profile.php', array('id'=>$USER->id)), get_string('myprofile')).' | ';
            echo html_writer::link(new moodle_url('/login/logout.php', array('sesskey'=>sesskey())), get_string('logout'));
            echo html_writer::end_tag('p');
            echo html_writer::end_tag('div');
            echo html_writer::tag('div', $OUTPUT->user_picture($USER, array('size'=>55)), array('class'=>'userimg'));*/
	?>
	<div id="userdetails"><b><?php echo "You are logged in as ".$USER->firstname.' '.$USER->lastname;?></b>
	( <a class="prolog" href="<?php echo $CFG->wwwroot.'/login/logout.php?sesskey='.sesskey();?>">Logout</a> )</div>
	
			
<?php    } else { ?>
            <div id="userdetails"><b><?php echo "Welcome, ";?></b>
			<a class="prolog" href="<?php echo $CFG->wwwroot.'/login/';?>">click here to login.</a></div>
<?php   } 
?>
</div>
<div style="clear:both;height:0;"></div>