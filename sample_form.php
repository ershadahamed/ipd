<?php
    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	require_once($CFG->dirroot .'/sample_formedit.php');
	
	$mform_simple = new simplehtml_form( null, array('email'=>$email, 'username'=>$username ) );
	$mform_simple->display();
?>