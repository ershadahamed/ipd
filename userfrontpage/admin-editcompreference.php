<style type="text/css">
<?php 
	include('../css/style2.css'); 
	include('../css/button.css');
	include('../css/pagination.css');
	include('../css/grey.css');
?>
</style>
<?php 
    require_once('../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php'); 

	$site = get_site();
	
	$viewresult='Edit '.get_string('communicationpreferences');
	$title="$SITE->shortname: ".$viewresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	//$PAGE->set_pagelayout('course');
	$PAGE->navbar->add($viewresult);

	echo $OUTPUT->header();	
	if (isloggedin()) {
	echo $OUTPUT->heading($viewresult, 2, 'headingblock header');
	if($USER->id == '2'){
	$sqlstatement=mysql_query("SELECT * FROM mdl_cifacommunication_rules WHERE id='".$_GET['rulesid']."'");
	$querystatement=mysql_fetch_array($sqlstatement);
?>
<br/>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0">
    <tr>
      <td width="30%" valign="top">Communication preference text</td>
      <td width="1%" valign="top"><strong>:</strong></td>
      <td colspan="2" valign="top"><label for="textarea"></label>
	  <input type="hidden" name="rulesid" value="<?=$_GET['rulesid'];?>" />
      <textarea name="textarea" id="textarea" cols="45" rows="5"><?=$querystatement['rules_text'];?></textarea></td>
    </tr>
    <tr>
      <td width="30%">Show compulsory (*)</td>
      <td width="1%"><strong>:</strong></td>
      <td width="18%"><label for="compulsory">First Registration:&nbsp;</label>
        <select name="compulsory" id="compulsory">
          <option value="1" selected="selected">Show</option>
          <option value="0">Hide</option>
      </select></td>
      <td>
		<label for="radio2">Existing :&nbsp;
				<select name="compulsory2" id="compulsory2">
				  <option value="1" selected="selected">Show</option>
				  <option value="0">Hide</option>
                </select>
			  </label>
	</td>
    </tr>
    <tr>
      <td width="30%">Show rules text</td>
      <td width="1%"><strong>:</strong></td>
      <td><label for="visible">First Registration:&nbsp;</label><select name="visible" id="visible">
        <option value="1" selected="selected">Show</option>
        <option value="0">Hide</option>
      </select></td>
      <td>
<label for="radio2">Existing :&nbsp;
        <select name="visible2" id="visible2">
          <option value="1" selected="selected">Show</option>
          <option value="0">Hide</option>
        </select>
      </label></td>
    </tr>
  </table>
  <table style="float:left;"><tr>
    <td><input name="savenewcomm" type="submit" id="savenewcomm" onClick="this.form.action='<?=$CFG->wwwroot. "/userfrontpage/admin-editcompreference.php?rulesid=".$sqlquery['id'];?>'"  onMouseOver="style.cursor='hand'" value="Save rules" /></td></tr></table>
  
</form>
<?php
$var=$_POST['savenewcomm'];
if (isset($var)) {
	$rulesid=$_POST['rulesid'];
	$rulestext=$_POST['textarea'];
	$compulsory=$_POST['compulsory'];
	$compulsory2=$_POST['compulsory2'];
	$visible=$_POST['visible'];
	$visible2=$_POST['visible2'];
	
	$UPDATE=mysql_query("UPDATE mdl_cifacommunication_rules SET rules_text='".$rulestext."', firstreg='".$compulsory."', existingreg='".$compulsory2."', visible_1='".$visible."', visible_2='".$visible2."' WHERE id='".$rulesid."' ");
?>
	<script language="javascript">
		window.alert("File have been save");
	</script>	
<?php
	$home=$CFG->wwwroot. '/userfrontpage/admin-commpreference.php';
	redirect($home);
}
}}else{
		echo '<div style="height:268px;">'; 
		echo 'Not allow to access this page';
		echo '</div>';
}	
?>
<?php echo $OUTPUT->footer(); ?>