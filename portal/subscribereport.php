<form id="form1" name="form1" method="post" action="">
<h2>Online Course Subscription Report</h2>
<b><u>Course Info</u></b><br/><br/>
  <table width="85%" border="1">
    <tr align="center" bgcolor="#fff3bf">
      <td width="1%"><strong>No</strong></td>
      <td width="20%"><strong>Course Code</strong></td>
      <td width="50%"><strong>Course Name</strong></td>
      <td width="20%"><strong>Duration</strong></td>
    </tr>
    <?php
		include('../manualdbconfig.php');
		
		$sql="Select * From mdl_cifa_modulesubscribe";
		$query=mysql_query($sql) or die("SQL Fail".mysql_error());
		$row=mysql_fetch_array($query);
		if($row['id']>='1'){
		
		
		$sqlSubscribe=" Select
						  b.id,
						  a.courseid,  
						  b.fullname,
						  b.shortname,
						  b.duration,
						  a.payment_status
						From
						  mdl_cifa_modulesubscribe a,
						  mdl_cifacourse b
						Where
						  a.courseid = b.id";
		$querySubscribe=mysql_query($sqlSubscribe);
		$no=0;
		while($rowSubscribe=mysql_fetch_array($querySubscribe)){
		$no++;
	?>
    <tr align="center">
      <td><?php echo $no; ?></td>
      <td><?php echo $rowSubscribe['shortname']; ?></td>
      <td><?php echo $rowSubscribe['fullname']; ?></td>
      <td><?php echo $rowSubscribe['duration']; ?> Month</td>
    </tr>
    <?php 
		} 
	}else{
	?>
    <tr>
      <td colspan="4" align="center">No data found</td>
    </tr>
    <?php } ?>
  </table>
  <br/>
  
  <!-------------------------------------------------------------------------------------->
  <!-- ****************************** user information ******************************** -->
  <!-------------------------------------------------------------------------------------->
  <b><u>Trainee Info</u></b><br/><br/>
  <table width="85%" border="1">
  <tr align="center" bgcolor="#fff3bf">
    <td width="1%"><strong>No</strong></td>
    <td><strong>Name</strong></td>
    <td width="15%"><strong>Email</strong></td>
	<td width="15%"><strong>Course Code</strong></td>
    <td width="15%"><strong>Start Date</strong></td>
    <td width="15%"><strong>End Date</strong></td>
  </tr>
    <?php
		$sql2="Select * From mdl_cifa_modulesubscribe";
		$query2=mysql_query($sql2) or die("SQL Fail".mysql_error());
		$row2=mysql_fetch_array($query2);
		
		if($row2['id']>='1'){	
		$sqlSubscribe2="  Select
						  b.id,
						  b.fullname,
						  b.shortname,
						  b.duration,
						  a.courseid,
						  a.enrol,
						  c.courseid As courseid1,
						  c.firstname,
						  c.lastname,
						  c.email,
						  a.enrolstartdate,
						  a.enrolenddate
						From
						  mdl_cifacourse b,
						  mdl_cifaenrol a,
						  mdl_cifa_modulesubscribe c
						Where
						  b.id = a.courseid And
						  (a.enrol = 'paypal' And
						  c.courseid = b.id)";
		$querySubscribe2=mysql_query($sqlSubscribe2);
		$no=0;
		while($rowSubscribe2=mysql_fetch_array($querySubscribe2)){
		$no++;
	?>  
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $rowSubscribe2['firstname'].' '.$rowSubscribe2['lastname']; ?></td>
    <td><?php echo $rowSubscribe2['email']; ?></td>
	<td><?php echo $rowSubscribe2['shortname']; ?></td>
    <td>
		<?php 
				echo $rowSubscribe2['enrolstartdate']; 
		?>
    </td>
    <td><?php echo $rowSubscribe2['enrolenddate']; ?></td>
  </tr>
    <?php 
		} 
	}else{
	?>
  <tr>
    <td colspan="6" align="center">No data found</td>
  </tr>
    <?php } ?>
</table>
