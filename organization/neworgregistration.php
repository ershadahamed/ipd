<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../config.php');

$newbutton = optional_param('id', '', PARAM_ALPHANUMEXT);
$link = $CFG->wwwroot . '/organization/orgview.php?id=' . $newbutton.'&form=new';
$PAGE->set_url($link);
/*
  $savebutton = optional_param('hiddensavebutton', '', PARAM_ALPHANUMEXT);
  $printbutton = optional_param('hiddenprintbutton', '', PARAM_ALPHANUMEXT); */

echo $newbutton;

