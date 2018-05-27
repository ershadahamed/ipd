<style>
<?php 
	include('style.css'); 
	include('button.css');
?>
</style>
<?php include('manualdbconfig.php'); ?>



<fieldset style="border:1px solid #3D91CB; width: 98%; margin-right: auto; margin-left: auto; margin-top: 2em; background-color:#EFF7FB;">
	<legend style="font-weight: bold; margin: 0 10px 0 10px; padding:0 10px 0 10px;">List of exam centre</legend>
	<?php include('examCenterList.php'); ?>
</fieldset>