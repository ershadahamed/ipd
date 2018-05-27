<?php
	include('config.php');
	include('manualdbconfig.php');
	echo'<style type="text/css">';
	include('institutionalclient/style.css');
		//require_once('css/style.css'); 
	//require_once('css/style2.css'); 
	echo '</style>';
	$courseid=$_GET['courseid'];
	
	$querycourse  = $DB->get_records('course',array('id'=>$courseid));
	foreach($querycourse as $qcourse){ }
?>	

<table style="	font:13px/1.231 arial,helvetica,clean,sans-serif; margin-left: auto; 
	margin-right: auto; 
	margin-top: 20px;
	border-collapse: collapse;
	width: 95%;"><tr><td>
<strong>List of enrolment candidate for <?php echo $qcourse->fullname; ?> module.</strong></td></tr></table>

<table id="listcandidate" border="1" width="98%">
<tr>
	<th width="1%">Num.</th>
	<th>Name</th>
	<th>Candidate ID</th>
	<th>D.O.B</th>
	<th>Email</th>
	<th>Country</th>
	<th>Purchase Date</th>
</tr>
<?php
	/*$sql="
		Select
		  *, a.timecreated as purchasedate
		From
		  mdl_cifauser_enrolments a,
		  mdl_cifaenrol b
		Where
		  a.enrolid = b.id And
		  (b.courseid = '".$courseid."' And b.enrol='paypal' And b.status='0' And a.status='0')	
	";*/
	
	$sql_role=mysql_query("Select id, name From mdl_cifarole Where id='5'");
	$sqlrows=mysql_fetch_array($sql_role);
	$candidaterole = $sqlrows['name'];
	
	$sql="
		Select
		  *, b.timecreated as purchasedate
		From
		  mdl_cifaenrol a Inner Join
		  mdl_cifauser_enrolments b On a.id = b.enrolid Inner Join
		  mdl_cifauser c On c.id = b.userid
		Where
		  a.courseid = '".$courseid."' And
		  a.status = '0' And
		  c.usertype='".$candidaterole."'
	";	
	$sqlQuery=mysql_query($sql);
	$num='1';
	while($rsList=mysql_fetch_array($sqlQuery)){
	
			$queryuser  = $DB->get_records('user',array('id'=>$rsList['userid']));
			foreach($queryuser as $quser){ }
?>
<tr>
	<td align="center"><?php echo $num++; ?></td>
	<td>
		<a href="#" title="View of registration information" onclick="window.open('registration_info.php?id=<?php echo $quser->id; ?>&&candidateid=<?php echo $quser->traineeid; ?>&&courseid=<?php echo $rsList['courseid']; ?>', 'Window2', 'width=820,height=600,resizable = 1');">
		<?php echo ucwords(strtolower($quser->firstname.' '.$quser->lastname)); ?>
		</a>
	</td>
	<td align="center"><?php echo strtoupper($quser->traineeid); ?></td>
	<td align="center"><?php echo date('d-m-Y',$quser->dob); ?></td>
	<td><?php echo $quser->email; ?></td>
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
	<td align="center"><?php echo date('d-m-Y',$rsList['purchasedate']); ?></td>
</tr>
<?php } ?>
</table>
<table border="0" align="center" style="padding-top:10px;"><tr><td>
<FORM><INPUT type="button" value=" Close this window " onClick="javascript:self.close();"/></FORM> 
</td></tr></table>