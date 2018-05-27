<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if($_POST)
{
	$candidate_id=$_POST['candidate_id'];
	mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='".$candidate_id."'");
}
?>