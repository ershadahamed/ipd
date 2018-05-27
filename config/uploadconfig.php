<?php
    require_once('../config.php');
	include('../manualdbconfig.php'); 
	//include_once ('../pagingfunction.php');
	
	
	$site = get_site();
	
	$uploadconfig="Setup Permission to Upload Users";
	$title="$SITE->shortname: ".$uploadconfig;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	//$PAGE->set_pagelayout('courses');
	$PAGE->navbar->add($uploadconfig);	
	
	echo $OUTPUT->header();
	if (isloggedin()) {
		
	$sql=mysql_query("Select * from mdl_cifarole WHERE id='13'");
	$sqlquery=mysql_fetch_array($sql);
	
	$SQ=mysql_query("
		Select
		  a.name,
		  b.userid,
		  c.firstname,
		  c.lastname
		From
		  mdl_cifarole a Inner Join
		  mdl_cifarole_assignments b On a.id = b.roleid Inner Join
		  mdl_cifauser c On b.userid = c.id
		Where
		  a.id = '13' And
		  b.contextid = '1'
	");	
	
	$sql1=mysql_query("Select * from mdl_cifaassign_site WHERE id='1'");
	$s1=mysql_fetch_array($sql1);	
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
<?php
if (isset($_POST["radio"])){
	
	$permissionchanges=mysql_query("UPDATE mdl_cifaassign_site SET active='".$_POST["radio"]."' WHERE id='1'");
	echo '<center><h5><font color="#00CC00">Setting have been changes.</font></h5></center>';
?>
	<script type="text/javascript">
	window.alert('Setting have been changes.');
	window.location.href = '<?=$CFG->wwwroot. "/config/uploadconfig.php";?>';   
	</script>	
<?php
	
	}
?>
	<center><h3><?=$uploadconfig;?></h3></center>
  <br/><table id="availablecourse" style="width:70%;" border="1">
    <tr class="yellow">
      <th class="adjacent" style="width:35%;text-align:center;">Role</th>
      <th class="adjacent" style="width:35%;text-align:center;">Users With Role</th>
      <th class="adjacent" style="width:35%;text-align:center;">Action</th>
    </tr>
    <tr>
      <td valign="top" class="adjacent" style="text-align:left;"><div style="padding:3px 0px 3px 0px;"><?=$sqlquery['name'];?></div></td>
      <td class="adjacent" style="text-align:left;">
      	<div style="padding:3px 0px 3px 0px;">
        <?php
			$no='1';
			while($SQ2=mysql_fetch_array($SQ)){
				echo $no++.')&nbsp;'.ucwords(strtolower($SQ2['firstname'].' '.$SQ2['lastname'])).'<br/>';
			}
		?>
        </div>
      </td>
      <td valign="top" class="adjacent" style="padding:3px 0px 3px 0px;">
      &nbsp;Permission:      
      <input name="radio" type="radio" id="yes" value="1" <?php if($s1['active']=='1'){ echo 'checked'; } ?>> Yes &nbsp;&nbsp;&nbsp;
      <input type="radio" name="radio" id="no" value="0" <?php if($s1['active']!='1'){ echo 'checked'; } ?>> No </td>
    </tr>
  </table>
  <div style="text-align:center;padding-top:10px;"><input type="submit" name="permissionbutton" id="permissionbutton" value="Saves Config"></div>
  <br/>
</form>
<?php	
	}
	echo $OUTPUT->footer();	
?>