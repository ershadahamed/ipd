<?php require_once('../../config.php');?>
<html>
<head>
<title>CIFA LMS</title>
<link type="text/css" rel="stylesheet" href="../../css/style.css">
</head>

<body>
<div id="wrapper">

<div id="header">
<div class="title">CIFA Learning Management System</div>
<div class="userinfo">
<?php 
	if (isloggedin()) { 
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



<div id="navbar">

<?php
include_once('../../ul_nav.php');
?>

<ul class="account">
	<li><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">Account</a></li>
</ul>
<div style="clear:both;"></div>
</div> <?php //end navbar ?> 

<div id="content">

<table class="content" cellspacing="5px" style="padding:5px;">
<tr>
	<td class="con">
		<div style="background-color:#fff; min-height: 630px; height: 100%; box-shadow: 0px 0px 10px #000;">