<?php
	require_once("../config.php");
	include("../manualdbconfig.php");
	
	$site = get_site();
	$getnav=$_GET['nav'];
	$userfullname=ucwords(strtolower($q['firstname'].' '.$q['lastname']));
	$fullusername=$userfullname.' ('.strtoupper($q['traineeid']).')';
	
	$viewresult=get_string('viewresult');
	$title="$SITE->shortname: ".$viewresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	if($USER->id !='2'){
		$PAGE->navbar->add($getnav)->add($viewresult)->add($fullusername);
	}	
?>
<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAll () {
	if (checked == false){checked = true}else{checked = false}
		for (var i = 0; i < document.getElementById('form').elements.length; i++) {
		document.getElementById('form').elements[i].checked = checked;
		document.getElementById('downloadresult').disabled=false;
	}
}
//  End -->
</script>
<?php echo $OUTPUT->header();	?>
<form name="form" id="form" action="<?//=$CFG->wwwroot. '/download_exam_anwer.php'; ?>" method="post">
<h2><?=get_string('potusers', 'role');?></h2>
<div style="height:500px; margin-bottom:5px; border-collapse:collapse; border:3px Solid #6d6e71; overflow-y:scroll;">
<table width="100%" style="border-collapse:collapse; border:0px;">
  <!--tr>
    <th colspan="2"><?//=get_string('potusers');?></th>
  </tr-->
<?php
	$roles=mysql_query("SELECT id, name FROM mdl_cifarole WHERE id='5'");
	$rolesusers=mysql_fetch_array($roles);

	$statement="SELECT * FROM mdl_cifauser a WHERE a.confirmed='1' AND a.deleted='0' AND a.suspended='0' AND a.usertype='".$rolesusers['name']."' Order By a.firstname ASC";
	$sqlquery=mysql_query($statement);
	$sqlcount=mysql_num_rows($sqlquery);
	if($sqlcount!='0'){
  	while($sqllist=mysql_fetch_array($sqlquery)){
		$userfullname=$sqllist['firstname'].' '.$sqllist['lastname'];
		$usertraineeid=$sqllist['traineeid'];
  ?>
  <tr>
  	<td width="1%"><input type='checkbox' name='downloadall[]' value='<?=$sqllist['userid']; ?>'></td>
    <td width="10%"><?=ucwords(strtoupper($usertraineeid));?></td>
    <td><?=ucwords(strtolower($userfullname));?></td>
  </tr>
  <?php }}else{ ?>
  <tr>
    <td colspan="3"><?=get_string('norecords');?></td>
  </tr>
  <?php } ?>
</table></div>
<input type="checkbox" name="allcheckbox" id="allcheckbox" onClick="checkedAll()" />&nbsp;Select All
<input type="submit" id="downloadresult" name="downloadresult" value="Download result" />
<div style="min-height:20px;"></div>
</form>
<?php echo $OUTPUT->footer(); ?>