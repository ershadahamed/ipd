<?php
include 'config.php';
include 'manualdbconfig.php';

$search_result = "";

$search_result = $_POST['search'];

$result = mysql_query("SELECT * FROM mdl_cifauser WHERE firstname LIKE '%$search_result%' ORDER BY id DESC", $conn)
  or die ('Error: '.mysql_error());
?>