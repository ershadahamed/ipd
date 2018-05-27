<?php
	require_once("../config.php");
	require_once($CFG->dirroot .'/course/lib.php');
	include("../manualdbconfig.php");

	//$id=$_GET['id'];
	//$sel=mysql_query("SELECT * FROM mdl_cifauser WHERE id='".$id."'");
	//$q=mysql_fetch_array($sel);	
	
	$site = get_site();
	//$userfullname=ucwords(strtolower($q['firstname'].' '.$q['lastname']));
	//$fullusername=$userfullname.' ('.strtoupper($q['traineeid']).')';
	
	$viewresult=get_string('potusers', 'role');
	$title="$SITE->shortname: ".$viewresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	if($USER->id !='2'){
		$PAGE->navbar->add($viewresult);
	}
$redirectpage=$CFG->wwwroot. '/hradmin/traineeregistration.php';	
?>
<style type="text/css">
	/*************************************************************************************************************/
	#potentialusers{/*width:40%;*/margin-bottom:5px; border-collapse:collapse; border:3px Solid #6d6e71; height:300px; overflow-y:auto;}
	#registedusers{/*width:40%;*/margin-bottom:5px; border-collapse:collapse; border:3px Solid #6d6e71; height:300px; overflow-y:auto;}
	#availablecourse3 {font-size:0.95em;width:100%;}
	#availablecourse3 table {border-collapse: collapse; }
	#availablecourse3 th {padding: 0 0.5em;}
	#availablecourse3 tr.yellow th {border: 1px solid #FB7A31;background: #FFC;}
	#availablecourse3 td {border-bottom: 1px solid #CCC;padding: 0 0.5em;}
	#availablecourse3 td.adjacent {border-left: 1px solid #CCC;border-right: 1px solid #CCC;}
	#availablecourse3 tr:hover, tr.selected {background-color: #5DCBEC;}
	#availablecourse {font-size:0.95em;width:100%;}
	#availablecourse table {border-collapse: collapse; }
	#availablecourse td {border-bottom: 1px solid #fff;padding: 0 0.5em;}
</style>
<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAll () {
	if (checked == false){checked = true}else{checked = false}
		for (var i = 0; i < document.getElementById('form').elements.length; i++) {
		document.getElementById('form').elements[i].checked = checked;
		document.getElementById('registerusers').disabled=false;
	}
}

function checkedallregisted () {
	if (checked == false){checked = true}else{checked = false}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
		document.getElementById('gtoken').disabled=false;
	}
}

function checkedalldown () {
	if (checked == false){checked = true}else{checked = false}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
		document.getElementById('dtoken').disabled=false;
	}
}
//  End  -->
</script>
<?php echo $OUTPUT->header();	if (isloggedin()) { ?>
<form name="form" id="form" action="<?=$CFG->wwwroot. '/hradmin/traineeregistration.php'; ?>" method="post">
<?php /*if(isset($_POST['dtoken'])){ ?>
	<script type="text/javascript">location.href = '/shape/hradmin/traineeregistration.php';</script>
<?php }*/ if(isset($_POST['registerusers'])){ ?>
	<script type="text/javascript">location.href = '/shape/hradmin/traineeregistration.php';</script>
<?php } ?>
<table id="availablecourse">
<tr><td width="44%" valign="top">
<h2><?=get_string('potusers', 'role');?></h2>
<div id="potentialusers">
<?php
	$roles=mysql_query("SELECT id, name FROM mdl_cifarole WHERE id='5'");
	$rolesusers=mysql_fetch_array($roles);

	/*$currentregusers=mysql_query("
		Select
		  a.id,
		  a.username,
		  a.firstname,
		  a.lastname
		From
		  mdl_cifauser a Inner Join
		  mdl_cifauser_accesstoken b On a.id = b.userid	
	");
	$regusersid=mysql_fetch_array($currentregusers);
	echo $regusersid['firstname'];*/
	
	$statement="SELECT * FROM mdl_cifauser a WHERE a.confirmed='1' AND a.deleted='0' AND a.suspended='0' AND a.usertype='".$rolesusers['name']."' AND a.access_token='' Order By a.firstname ASC";

	$sqlquery=mysql_query($statement);
	$sqlcount=mysql_num_rows($sqlquery);
?>
<table id="availablecourse3">
  <tr>
    <td colspan="3" style="font-weight:bolder;padding-bottom:10px;text-align:left;"><?php echo get_string('potusers', 'role').' - ('.$sqlcount.')';?></td>
  </tr>
<?php
	if($sqlcount!='0'){
  	while($sqllist=mysql_fetch_array($sqlquery)){
		$userfullname=$sqllist['firstname'].' '.$sqllist['lastname'];
		$usertraineeid=$sqllist['traineeid'];
  ?>
  <tr>
  	<td width="1%"><input type='checkbox' name='downloadall[]' value='<?=$sqllist['id']; ?>'></td>
    <td width="10%"><?=ucwords(strtoupper($usertraineeid));?></td>
    <td><?=ucwords(strtolower($userfullname));?><?=$sqllist['access_token'];?></td>
  </tr>
  <?php }}else{ ?>
  <tr>
    <td colspan="3"><?=get_string('norecords');?></td>
  </tr>
  <?php } ?>
</table></div>

<!--label for="searchreg">Search trainee&nbsp;&nbsp;</label><input name="searchreg" type="text" id="searchreg" />&nbsp;
<input type="submit" name="searchreg" id="searchreg" value="Search" /><br/-->
<div style="margin-top:5px;">
<input type="checkbox" name="allcheckbox" id="allcheckbox" onClick="checkedAll()" />&nbsp;Select all
<input type="submit" id="registerusers" name="registerusers" value="Register users" /></div>
</form>
<?php
	$checkBox=$_POST['downloadall'];
	for($i=0; $i<sizeof($checkBox); $i++){
		$testing=$checkBox[$i];
		if(isset($_POST['registerusers'])){
		echo $testing;
		}
		$sql_statement=" mdl_cifacourse a Inner Join mdl_cifaenrol b On a.id = b.courseid Inner Join mdl_cifauser_enrolments c On b.id = c.enrolid";				
		$sql_query=mysql_query("SELECT * FROM {$sql_statement} WHERE c.userid = '".$testing."' And b.enrol = 'manual' And a.category = '1' And a.visible = '1' And b.status = '0'");
		$sql_row=mysql_fetch_array($sql_query);
		$examid=$sql_row['courseid'];
		$tokenExpire = strtotime('now');
		if(isset($_POST['registerusers'])){
		$access_token=uniqid(rand());
		$sqlUP=mysql_query("UPDATE {$CFG->prefix}user a SET a.access_token='".$access_token."' WHERE a.id='".$testing."'") or die("Not update".mysql_error());
		
		if($sqlUP){
			$tokenExpire = strtotime('now');
			//select user from DB
			$querytoken  = $DB->get_records('user',array('id'=>$testing));
			foreach($querytoken as $qtoken){}	
			
			$sqlUP=mysql_query("UPDATE {$CFG->prefix}user_accesstoken b SET b.centerid='".$USER->id."', b.user_accesstoken='".$qtoken->access_token."' WHERE b.userid='".$qtoken->id."'") or die("Not update".mysql_error());
			
			//select user_accesstoken from DB
			$query=$DB->get_records('user_accesstoken');
			foreach ($query as $rs){}
			if($rs->userid != $qtoken->id){
				//Insert data to user_accesstoken
				$sqlInsert=mysql_query("
					INSERT INTO {$CFG->prefix}user_accesstoken SET visible='1', centerid='".$USER->id."',
					courseid='".$examid."', userid='".$testing."', user_accesstoken='".$qtoken->access_token."', timecreated_token='".$tokenExpire."'
				");	
			}
		}}
	}
?>

</td><!--td width="12%">

<table id="availablecourse">
<tr><td>
<div style="margin-top:5px;">
<input type="checkbox" name="allcheckbox" id="allcheckbox" onClick="checkedAll()" />
&nbsp;Select all
<input type="checkbox" name="allcheckbox" id="allcheckbox" onClick="checkedallregisted()" />
&nbsp;Select all
<br/><br/><input type="submit" id="downloadresult" name="downloadresult" value="Register users" /></div>
</td></tr></table>

</td--><td width="44%" valign="top">
<!----------------------------------Registed users--------------------------------------------------->
<!--------------------------------------------------------------------------------------------------->
<form name="form1" id="form1" action="<?=$CFG->wwwroot. '/hradmin/bachdownload.php'; ?>" method="post">
<h2><?=get_string('regusers', 'role');?></h2>
<div id="registedusers">
<?php
	$roles=mysql_query("SELECT id, name FROM mdl_cifarole WHERE id='5'");
	$rolesusers=mysql_fetch_array($roles);
	$statementreg="SELECT * FROM mdl_cifauser a, mdl_cifauser_accesstoken b WHERE b.userid = a.id AND b.user_accesstoken!='' AND b.status='0' Group by a.firstname";
	$sqlqueryreg=mysql_query($statementreg);
	$sqlcountreg=mysql_num_rows($sqlqueryreg);
?>
<table id="availablecourse3">
  <tr>
    <td colspan="3" style="font-weight:bolder;padding-bottom:10px;text-align:left;"><?php echo get_string('regusers', 'role').' - ('.$sqlcountreg.')';?></td>
  </tr>
<?php
	if($sqlcountreg!='0'){
  	while($sqllistreg=mysql_fetch_array($sqlqueryreg)){
		$userfullnamereg=$sqllistreg['firstname'].' '.$sqllistreg['lastname'];
		$usertraineeidreg=$sqllistreg['traineeid'];
		$visible=$sqllistreg['visible'];
		echo '<input type="hidden" name="visible" value="1" />';
  ?>
  <tr>
  	<td width="1%"><input type='checkbox' name='downloadall[]' value='<?=$sqllistreg['userid']; ?>'></td>
    <td width="10%"><?=ucwords(strtoupper($usertraineeidreg));?></td>
    <td>
		<?php if($visible=='1'){ ?>
		<a href="#" title="<?=ucwords(strtolower($userfullnamereg));?>"><?=ucwords(strtolower($userfullnamereg));?></a>
		<?php }else{ echo ucwords(strtolower($userfullnamereg)); } ?>
	</td>
  </tr>
  <?php }}else{ ?>
  <tr>
    <td colspan="3"><?=get_string('norecords');?></td>
  </tr>
  <?php } ?>
</table></div>

<?php if($sqlcountreg!='0'){ ?>

<!--label for="searchdown">Search trainee&nbsp;&nbsp;</label><input name="searchdown" type="text" id="searchdown" />&nbsp;
<input type="submit" name="searchdwonuser" id="searchdwonuser" value="Search" />
<br/-->
<div style="margin-top:5px;">
<input type="checkbox" name="allcheckbox" id="allcheckbox" onClick="checkedalldown()" <?php if($sqlcountreg=='0'){ echo 'disabled';} ?> />
&nbsp;Select all
<input type="submit" id="dtoken" name="dtoken" value="Download token" <?php if($sqlcountreg=='0'){ echo 'disabled';} ?> />
</div>
<?php } ?>
</td>
</tr></table>
<div style="min-height:20px;"></div>
</form>
<?php }else{ echo 'Unable to view the page. Please login the system. <br/><br/>';} echo $OUTPUT->footer(); ?>