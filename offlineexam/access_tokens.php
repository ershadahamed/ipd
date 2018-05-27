<script style="text/javascript">
        function redirectToFB(){

            window.opener.location.href="http://192.168.1.94/CIFALMS/offlineexam/examregistration_home.php?id=7";

            self.close();

        }
</script>
<?php
	include('../config.php');
	include('../manualdbconfig.php');
	
	echo '<style type="text/css">';
	include('../institutionalclient/style.css');
	echo '</style>';
	
	$candidateid=$_GET['candidateid'];
	$courseid=$_GET['examid'];
 
	//$statement="mdl_cifacourse a, mdl_cifa_modulesubscribe b, mdl_cifauser c WHERE   a.id = b.courseid And b.traineeid = c.traineeid And (a.id='".$courseid."' And a.category = '1')";
	$statement="mdl_cifauser WHERE traineeid='".$candidateid."'";
	$sqlquery=mysql_query("Select * From {$statement}");
	$sqlRowStudent=mysql_fetch_array($sqlquery);
	$startdate=date('d-m-Y H:i:s',$sqlRowStudent['timecreated']);
	
	echo'<table style="margin: 0 auto; width:95%; font:13px/1.231 arial,helvetica,clean,sans-serif bolder;"><tr><td>';
	echo'<b>Access Token For '.ucwords(strtolower($sqlRowStudent['firstname'].' '.$sqlRowStudent['lastname'])).'</b>';
	echo '</td></tr></table>';
?>
<table id="listcandidate">
	<tr><td colspan="3" style="text-align:left; font-weight: bolder;">Access Token Settings</td></tr>
	<tr><th style="text-align:right" width="30%">Maximum Number of Accesses</th><th width="1%">:</th><td>1</td></tr>
	<tr><th style="text-align:right">Start Date / Time</th><th>:</th><td><?php echo $startdate; ?></td></tr>
	<tr><th style="text-align:right">End Date / Time</th><th>:</th><td><?php echo date('d-m-Y H:i:s',strtotime($startdate . " + 1 year")); ?></td></tr>
</table>

<table id="listcandidate">	
	<tr>
		<th style="font-weight: bolder;" width="1%">Index</th>
		<th style="text-align:left; font-weight: bolder;" width="40%">Candidate Name</th>
		<th style="font-weight: bolder;" width="20%">Candidate ID</th>
		<th style="font-weight: bolder;" width="39%">Access Token</th>
	</tr>
	<tr>
		<td align="center">1</td>
		<td><?php echo $sqlRowStudent['firstname'].' '.$sqlRowStudent['lastname']; ?></td>
		<td align="center"><?php echo $sqlRowStudent['traineeid']; ?></td>
		<td>
			<?php 
				//$random_string = chr(rand(65,90)). rand(0,9) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)). rand(0,9) . chr(rand(65,90))  .rand(1,9). chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)). rand(0,9) . chr(rand(65,90)); 
				//echo $random_string;
				//echo uniqid(rand());
				$access_token=uniqid(rand());
				//$sqlUP=mysql_query("UPDATE {$CFG->prefix}user a, {$CFG->prefix}user_accesstoken b SET a.access_token='".$access_token."', b.user_accesstoken='".$access_token."' WHERE a.id = b.userid AND a.traineeid='".$candidateid."'") or die("Not update".mysql_error());
				$sqlUP=mysql_query("UPDATE {$CFG->prefix}user a SET a.access_token='".$access_token."' WHERE a.traineeid='".$candidateid."'") or die("Not update".mysql_error());
				if($sqlUP){
					//select user from DB
					$querytoken  = $DB->get_records('user',array('traineeid'=>$candidateid));
					foreach($querytoken as $qtoken){}
					echo $qtoken->access_token;
					
					$sqlUP=mysql_query("UPDATE {$CFG->prefix}user_accesstoken b SET b.user_accesstoken='".$qtoken->access_token."' WHERE b.userid='".$qtoken->id."'") or die("Not update".mysql_error());
					
					//select user_accesstoken from DB
					$query=$DB->get_records('user_accesstoken');
					foreach ($query as $rs){}
					if($rs->userid != $qtoken->id){
						//Insert data to user_accesstoken
						$sqlInsert=mysql_query("INSERT INTO {$CFG->prefix}user_accesstoken SET userid='".$qtoken->id."', user_accesstoken='".$qtoken->access_token."'");
					}
				}
			?>
		</td>
	</tr>
</table>
<table border="0" align="center" style="padding-top:10px;"><tr><td>
<!--INPUT type="button" value=" Close this window " onClick="redirectToFB()" /-->
<INPUT type="button" value=" Close this window " onClick="javascript:self.close();"/>
</td>
<td>
<!--INPUT type="button" value=" Generate New Token " onClick="javascript:location.reload(true);"/-->
</td>
</tr></table>