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
	
	$viewresult='Add New '.get_string('communicationpreferences');
	$title="$SITE->shortname: ".$viewresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	//$PAGE->set_pagelayout('course');
	$PAGE->navbar->add($viewresult);

	echo $OUTPUT->header();	
	if (isloggedin()) {
	echo $OUTPUT->heading($viewresult, 2, 'headingblock header');
	//$linkto=$CFG->wwwroot. "/userfrontpage/admin-editcompreference.php?id=".$USER->id;

	//$sqlstatement=mysql_query("SELECT * FROM mdl_cifacommunication_rules");
	if($USER->id == '2'){
?>
<script language="JavaScript">
function checkfield(msg){
		pengakuan1 = 'Please tick, if you agree with the policy.';
		elem1 = document.getElementById('pengakuan1');
		elem2 = document.getElementById('textarea');
			if(elem2==''){
				alert(pengakuan1);
				return false; 			
			}
			
		document.form.submit();	
		return true;	
				
	}
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
</script>
<br/>
<form action="" method="post" name="form" id="form" onSubmit="MM_validateForm('textarea','','R');return document.MM_returnValue" onfocus="textarea">
  <table width="100%" border="0">
    <tr>
      <td width="30%" valign="top">Communication preference text</td>
      <td width="1%" valign="top"><strong>:</strong></td>
      <td colspan="2" valign="top"><label for="textarea"></label>
      <textarea name="textarea" id="textarea" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td width="30%">Compulsory</td>
      <td width="1%"><strong>:</strong></td>
      <td width="18%"><label for="compulsory">First Registration:&nbsp;</label>
        <select name="compulsory" id="compulsory">
          <option value="1">Yes</option>
          <option value="0">No</option>
      </select></td>
      <td>
		<label for="radio2">Existing :&nbsp;
				<select name="compulsory2" id="compulsory2">
				  <option value="1">Yes</option>
				  <option value="0">No</option>
				</select>
			  </label>
	</td>
    </tr>
    <tr>
      <td width="30%">Show to candidate</td>
      <td width="1%"><strong>:</strong></td>
      <td><label for="visible">First Registration:&nbsp;</label><select name="visible" id="visible">
        <option value="1">Yes</option>
        <option value="0">No</option>		
      </select></td>
      <td>
<label for="radio2">Existing :&nbsp;
        <select name="visible2" id="visible2">
          <option value="1">Yes</option>
          <option value="0">No</option>
        </select>
      </label></td>
    </tr>
  </table>
  <table style="float:left;"><tr>
    <td><input name="savenewcomm" type="submit" id="savenewcomm" onclick="checkfield()" onClick="this.form.action='<?=$CFG->wwwroot. "/userfrontpage/admin-addnewcomm.php";?>'"  onMouseOver="style.cursor='hand'" value="Save rules" /></td></tr></table>
</form>
<?php
$var=$_POST['savenewcomm'];
if (isset($var)) {
	//$rulesid=$_POST['rulesid'];
	$rulestext=$_POST['textarea'];
	$compulsory=$_POST['compulsory'];
	$compulsory2=$_POST['compulsory2'];
	$visible=$_POST['visible'];
	$visible2=$_POST['visible2'];
	if($rulestext!=''){
	//$UPDATE=mysql_query("UPDATE mdl_cifacommunication_rules SET rules_text='".$rulestext."', firstreg='".$compulsory."', existingreg='".$compulsory2."', visible_1='".$visible."', visible_2='".$visible2."' WHERE id='".$rulesid."' ");
	$saveadd=mysql_query("INSERT INTO mdl_cifacommunication_rules SET rules_text='".$rulestext."', firstreg='".$compulsory."', existingreg='".$compulsory2."', visible_1='".$visible."', visible_2='".$visible2."'");
	?>
	<script language="javascript">
		window.alert("File have been save");
	</script>
<?php	
	$home=$CFG->wwwroot. '/userfrontpage/admin-commpreference.php';
	redirect($home);
}}	
?>
<?php
}}else{
		echo '<div style="height:268px;">'; 
		echo 'Not allow to access this page';
		echo '</div>';
}
	echo $OUTPUT->footer(); 
?>