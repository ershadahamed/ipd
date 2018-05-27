<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../config.php');

$searchbutton = optional_param('hiddensearchbutton', '', PARAM_ALPHANUMEXT);
/*
  $savebutton = optional_param('hiddensavebutton', '', PARAM_ALPHANUMEXT);
  $printbutton = optional_param('hiddenprintbutton', '', PARAM_ALPHANUMEXT); */

echo $searchbutton;
