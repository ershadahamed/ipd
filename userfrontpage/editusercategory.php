<?php
	require_once('../config.php');
	echo '<style type="text/css">';
		include('../css/style.css'); 
		include('../css/style3.css');
	echo '</style>';
	
	include('../header2.php');
	include('../nav.php');
?>
<?php
	include('../manualdbconfig.php');
	
	$id=$_GET['id'];
	
	//$sqlEdit="UPDATE mdl_cifauser_category SET categorycode='', categoryname='' WHERE id='".$id."'";
	$sqlShow=mysql_query("SELECT * FROM mdl_cifauser_category WHERE id='".$id."'");
	$sqlRow=mysql_fetch_array($sqlShow);
?>
<form id="myform" method="post" action="<?php echo $CFG->wwwroot.'/userfrontpage/editusercategoryexe.php';?>" onSubmit="return valCari(this);">
<br/>
<div style="padding-left: 20px;"><h3>Manage category/user</h3></div>

<?php
	//if(isset($_POST['submit'])){ echo 'Record have been updated.';}
?>

<fieldset><legend>Edit category user</legend>
<table id="avalaiblecourse" border="0" cellpadding="1" background="#aaaaaa">
<tr>
	<td>Category code</td><td>:</td>
	<td>
		<input type="text" name="categorycode" id="categorycode" value="<?php echo $sqlRow['categorycode']; ?>" size="40">
		<input type="hidden" name="id" id="id" value="<?php echo $sqlRow['id']; ?>" size="40">
	</td>
</tr>
<tr>
	<td>Category name</td><td>:</td>
	<td><input type="text" name="categoryname" id="categoryname" value="<?php echo $sqlRow['categoryname']; ?>" size="40"></td>
</tr>
</table>
<table>
<tr>
<td><input type="submit" name="save" value="Save"></td>
<td><input type="button" name="cancel" value="Cancel" ONCLICK="history.go(-1)"></td>
</tr>
</table>
</fieldset>
</form>
<?php
	include('../footer3.php');