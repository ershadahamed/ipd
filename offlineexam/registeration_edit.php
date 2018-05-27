<style type="text/css">
<?php 
	require_once('../css/style.css'); 
	require_once('../css/style2.css'); 
	include('../css/pagination.css');
	include('../css/grey.css');
	include('../institutionalclient/style.css');
?>
#listcandidate td{background-color:#fff;}
</style>

<?php
	include('../config.php');
	include('../manualdbconfig.php');
	
	$accesstoken=$_GET['access_token'];
	
	$sql=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE access_token='".$accesstoken."'");
	$rs=mysql_fetch_array($sql);
	$startdate=date('d-m-Y H:i:s',$rs['timecreated']);
	
	echo'<table style="margin: 0 auto; width:95%; font:15px/1.231 arial,helvetica,clean,sans-serif bolder;"><tr><td>';
	echo '<strong>'.ucwords(strtolower('Update registed candidate info')).'</strong>';
	echo '</td></tr></table>';		
	
?>
<form name="form_update" method="post">
<table id="listcandidate" border="1"><tr>
<th style="align:left" width="30%">Candidate ID</th><th width="1%">:</th><td><?php echo $rs['traineeid']; ?></td></tr><tr>
<th style="align:left">Firstname</th><th>:</th><td><input type="text" size="50" name="firstname" value="<?php echo $rs['firstname']; ?>" /></td></tr><tr>
<th style="align:left">Lastname</th><th>:</th><td><input type="text" size="50" name="lastname" value="<?php echo $rs['lastname']; ?>" /></td></tr><tr>
<th style="align:left">Access token</th><th>:</th><td><?php echo $rs['access_token']; ?></td></tr><tr>
<th style="align:left">Start date</th><th>:</th><td><?php echo $startdate; ?></td></tr><tr>
<th style="align:left">End date</th><th>:</th><td><?php echo date('d-m-Y H:i:s',strtotime($startdate . " + 1 year"));  ?></td>
</tr><table><br/>
<table border="0" align="center"><tr><td>
<input type="submit" name="updatename" value="Update info" />
</td></tr></table>
</form>

<?php
$accesstoken=$_GET['access_token'];
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];

if(isset($_POST['updatename'])){ 
	$sqlupdate=mysql_query("UPDATE {$CFG->prefix}user SET firstname='".$firstname."', lastname='".$lastname."' WHERE access_token='".$accesstoken."'");
	if($sqlupdate){
		redirect($CFG->wwwroot. '/offlineexam/view_candidateslist.php?success_update=1&&token='.$rs['access_token']);
	}
}
?>