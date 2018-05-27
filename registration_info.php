<?php
	include('config.php');
	include('manualdbconfig.php');
	
	echo'<style type="text/css">';
	include('institutionalclient/style.css');
	echo '</style>';	

	$userid=$_GET['id'];
	$candidateid=$_GET['candidateid'];
	$courseid=$_GET['courseid'];
	
	$queryuser  = $DB->get_records('user',array('id'=>$userid));
	foreach($queryuser as $quser){ }
			
	/*$sql="
		Select
		  *
		From
		  mdl_cifauser_enrolments a,
		  mdl_cifaenrol b
		Where
		  a.enrolid = b.id And
		  (a.userid = '".$quser->id."' And b.status='0')	
	";*/
	
	$sql="
		Select *
		From
		  mdl_cifaenrol b Inner Join
		  mdl_cifauser_enrolments a On b.id = a.enrolid Inner Join
		  mdl_cifacourse c On b.courseid = c.id
		Where
		  a.userid = '".$quser->id."' And
		  b.status = '0' And
		  c.category = '1'
		";	
	
	$sqlQuery=mysql_query($sql);
	$rsCount=mysql_num_rows($sqlQuery);	
	
	$querysubscribe  = mysql_query("Select * From {$CFG->prefix}_modulesubscribe Where courseid='".$courseid."' And traineeid='".$quser->traineeid."'");
	$qsubscribe=mysql_fetch_array($querysubscribe);
?>	
<table style="font:13px/1.231 arial,helvetica,clean,sans-serif;	margin-left: auto; 
	margin-right: auto; 
	margin-top: 20px;
	border-collapse: collapse;
	width: 95%;"><tr><td>
<strong>Registration information for <?php echo ucwords(strtolower($quser->firstname.' '.$quser->lastname)); ?>.</strong></td></tr></table>

<table id="listcandidate" border="1" width="98%">
<tr>
	<th align="left">Registration date</th><th width="1%">:</th>
	<td><?php echo date('d-m-Y H:i:s',$quser->timecreated); ?></td>
</tr>
<tr>
	<th align="left">Candidate ID</th><th width="1%">:</th>
	<td><?php echo strtoupper($quser->traineeid); ?></td>
</tr><tr>
	<th align="left" width="20%">Name</th><th width="1%">:</th>
	<td><?php echo ucwords(strtolower($quser->firstname.' '.$quser->lastname)); ?></td>
</tr><tr>
	<th align="left">D.O.B</th><th width="1%">:</th>
	<td><?php echo date('d-m-Y',$quser->dob); ?></td>
</tr><tr>
	<th align="left">Email</th><th width="1%">:</th>
	<td><?php echo $quser->email; ?></td>
</tr><tr>
	<th align="left">Country</th><th width="1%">:</th>
	<td>
		<?php 
			$querycountry = $DB->get_records('country_list',array('countrycode'=>$quser->country));
			foreach($querycountry as $qcountry);
			
			if($quser->country != ''){
				echo $qcountry->countryname;
			}else{ 
				echo 'Not set'; 
			} 
		?>
	</td>
</tr>
<tr valign='top'>
	<th align="left" width="1%">Module subscibe</th><th width="1%">:</th>
	<td>
	<?php 
		$nom='1';
		while($listModules=mysql_fetch_array($sqlQuery)){
			$queryCourse  = $DB->get_records('course',array('id'=>$listModules['courseid']));
			foreach($queryCourse as $qCourse){ }
			echo $nom++.'. '.$qCourse->fullname.'<br/>';
		}
	?>
	</td>
</tr>
<tr>
	<th align="left" width="1%">Total subscibe(module)</th><th width="1%">:</th>
	<td><?php echo $rsCount.' module'; ?></td>
</tr>
</table>

<table border="0" align="center" style="padding-top:10px;"><tr><td>
<FORM><INPUT type="button" value=" Back " onClick="parent.history.back(); return false;"/></FORM> 
</td></tr></table>
