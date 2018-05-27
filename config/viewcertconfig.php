<?php
    require_once('../config.php');
	include('../manualdbconfig.php'); 
	//include_once ('../pagingfunction.php');
	
	
	$site = get_site();
	
	$uploadconfig=get_string('viewcertconfiguration');
	$title="$SITE->shortname: ".$uploadconfig;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	$url=$CFG->wwwroot. "/config/viewcertconfig.php";
	$PAGE->navbar->add($uploadconfig, $url);	
	
	echo $OUTPUT->header();
	if (isloggedin()) {
		
	$sql=mysql_query("Select * from {$CFG->prefix}organization_type");
?>
<style>
<?php 
	include('../css/style2.css'); 
	include('../css/button.css');
	include('../css/pagination.css');
	include('../css/grey.css');
?>
</style>
<form id="form1" name="form1" method="post" action="">
	<br/>
	<center><h3><?=$uploadconfig;?></h3></center>
	<br/><table id="availablecourse" style="width:80%;" border="1">
    <tr class="yellow">
      <th class="adjacent" style="width:35%;text-align:center;"><?=get_string('registedorganization');?></th>
      <th class="adjacent" style="width:35%;text-align:center;"><?=get_string('allowtoviewcert');?></th>
    </tr>
<?php
	while($sqlquery=mysql_fetch_array($sql)){
	
	$selectedview=mysql_query("SELECT viewcert FROM {$CFG->prefix}organization_type WHERE id='".$sqlquery['id']."'");
	$viewsql=mysql_fetch_array($selectedview);
	
?>
    <tr>
      <td valign="top" class="adjacent" style="text-align:left;"><div style="padding:3px 0px 3px 0px;"><?=$sqlquery['name'];?></div></td>
      <td valign="top" class="adjacent" style="padding:3px 0px 3px 0px;">   
		<input type="hidden" name="hiddenid[]" value="<?=$sqlquery['id'];?>" />
		<label>Permission: </label>
		<select name="permission[]">
			<option value=""> - Select One - </option>
			<option value="1;<?=$sqlquery['id'];?>" <?php if($viewsql['viewcert']=='1'){ echo 'Selected';} ?>>Yes</option>
			<option value="0;<?=$sqlquery['id'];?>" <?php if($viewsql['viewcert']=='0'){ echo 'Selected';} ?>>No</option>
		</select>
	  </td>
    </tr>
<?php } ?>
  </table>
  <div style="text-align:center;padding-top:10px;">
  <input type="submit" name="permissionbutton" id="permissionbutton" value="Saves Config" onClick="this.form.action='<?=$CFG->wwwroot. '/config/viewcert_action.php';?>'"></div>
  <br/>
</form>
<?php	
	}
	echo $OUTPUT->footer();	
?>