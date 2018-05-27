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
	
	$viewresult=get_string('communicationpreferences');
	$title="$SITE->shortname: ".$viewresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	//$PAGE->set_pagelayout('course');
	$PAGE->navbar->add($viewresult);

	echo $OUTPUT->header();	
	if (isloggedin()) {
	echo $OUTPUT->heading($viewresult, 2, 'headingblock header');
	//$linkto=$CFG->wwwroot. "/userfrontpage/admin-editcompreference.php?id=".$USER->id;

	if($USER->id == '2'){
    	
	
	$sqlstatement=mysql_query("SELECT * FROM mdl_cifacommunication_rules");
?>
<script>
function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
</script>
<br/>
<form id="form1" name="form1" method="post" action="">
  <table id="availablecourse" width="100%" border="1">
    <tr class="yellow">
      <th class="adjacent" rowspan="2" align="center">No</th>
      <th class="adjacent" rowspan="2">Communication preference rules</th>
      <th class="adjacent" colspan="2" width="16%" style="text-align:center">Show compulsory(*)</th>
      <th class="adjacent" colspan="2" width="16%" style="text-align:center">Show rules</th>
      <th class="adjacent" rowspan="2" width="11%" style="text-align:center">#</th>
    </tr>
    <tr class="yellow">
      <th class="adjacent" style="text-align:center" width="8%">New</th>
      <th class="adjacent" style="text-align:center" width="8%">Existing</th>
      <th class="adjacent" style="text-align:center" width="8%">New</th>
      <th class="adjacent" style="text-align:center" width="8%">Existing</th>
    </tr>
    <?php 
		$no='1';
		while($sqlquery=mysql_fetch_array($sqlstatement)){ 
		$bil=$no++;
	?>
    <tr valign="top">
      <td class="adjacent"  align="center"><?=$bil;?></td>
      <td class="adjacent"  style="text-align:justify; padding-bottom: 3px; padding-top: 3px;">
	  <?php
		
	  ?>
	  <?=$sqlquery['rules_text'];?>
	  <?php 
		$a = new stdClass();
		
		$policy=$CFG->wwwroot .'/userpolicy.php';
		$a = "<a href=\"javascript:void(0);\" onclick=\"popupwindow('".$policy."', 'myPop1',820,600);\"><u><b>".get_string('cifaonlinepolicy')."</b></u></a>";
		if($bil=='3'){
			echo get_string('compreference3', '', $a);
		}
	  ?>
	  </td>
      <td class="adjacent"  align="center" valign="middle"><?php if($sqlquery['firstreg']=='1'){ echo 'Show';} else { echo 'Hide';};?></td>
      <td class="adjacent"  align="center" valign="middle"><?php if($sqlquery['existingreg']=='1'){ echo 'Show';} else { echo 'Hide';};?></td>
      <td class="adjacent"  align="center" valign="middle"><?php if($sqlquery['visible_1']=='1'){ echo 'Show';} else { echo 'Hide';};?></td>
      <td class="adjacent"  align="center" valign="middle"><?php if($sqlquery['visible_2']=='1'){ echo 'Show';} else { echo 'Hide';};?></td>
      <td class="adjacent"  align="center" valign="middle"><input type="submit" name="editcomm" id="editcomm" value="Edit" onClick="this.form.action='<?=$CFG->wwwroot. "/userfrontpage/admin-editcompreference.php?rulesid=".$sqlquery['id'];?>'"  onMouseOver="style.cursor='hand'" />
      <input type="submit" name="remove" id="remove" value="Delete" onclick="this.form.action='<?=$CFG->wwwroot. "/userfrontpage/admin-commpreference.php?rulesid=".$sqlquery['id'];?>'"  onmouseover="style.cursor='hand'" /></td>
    </tr>
    <?php } ?>
  </table>
  <table align="center" ><tr><td width="100%"><input type="submit" name="addnewcomm" value="Add new rules" onClick="this.form.action='<?=$CFG->wwwroot. "/userfrontpage/admin-addnewcomm.php";?>'"  onMouseOver="style.cursor='hand'" /></td></tr></table>
  <br/>
</form>
	<?php
	$var=$_POST['remove'];
	if (isset($var)) {
		$rulesid=$_GET['rulesid'];
		/*$rulestext=$_POST['textarea'];
		$compulsory=$_POST['compulsory'];
		$compulsory2=$_POST['compulsory2'];
		$visible=$_POST['visible'];
		$visible2=$_POST['visible2'];*/
		
		$DELETE=mysql_query("DELETE FROM mdl_cifacommunication_rules WHERE id='".$rulesid."' ");
	?>
		<script language="javascript">
			window.alert("File have been remove");
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
	echo $OUTPUT->footer(); 
?>