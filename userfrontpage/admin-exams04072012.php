<!-- available exam -->
<!-- available exam -->
<!-- available exam -->
<?php include('../manualdbconfig.php'); ?>
<div align="right" style="width:100%;margin: 10px 0px 10px 0px; float: right; background-color: #EFF7FB;">
<div class="buttons">
    <a href="<?php echo $CFG->wwwroot . '/course/category_3.php?id=3&categoryedit=on'; ?>" class="positive" title="Click to add new exam">
        <img src="image/switch_course_alternative.png" alt=""/>
        Add category/exam/module
    </a>

    <!--a href="<?php //echo $CFG->wwwroot . '/course/category_3.php?id=3&categoryedit=on'; ?>" class="regular" title="Click to manage category">
        <img src="image/configure.png" alt=""/>
        Manage category
    </a-->
</div></div>
	
<table id="avalaiblecourse" border="1" style="border-collapse: collapse; background-color: #fff;">
  <tr>
    <th width="1%">No</th>
    <th width="15%">Code</th>
    <th>Exam Name</th>
    <th width="15%">Exam Centre</th>
    <th width="13%">No. of Candidate</th>
    <!--th width="13%">Exam Date</th-->
  </tr>
<?php

	
	$sqlcourse="SELECT * FROM mdl_cifacourse WHERE category='3' AND visible='1'";
	$sqlquery=mysql_query($sqlcourse);
	$no=1;
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil= $no++;
?>
  <tr valign="middle">
    <td width="1%"><?php echo $bil; ?></td>
    <td><?php echo ucwords(strtoupper($sqlrow['shortname'])); ?></td>
	<td>
		<a href="course/view.php?id=<?=$sqlrow['id'];?>" title="click to enter this exam module">
		<?php echo ucwords(strtolower($sqlrow['fullname'])); ?></a></td>
    <td align="center">
	<?php
	//select centre_name for exam
	$courseid3=$sqlrow['id'];
	$sql3=mysql_query("
						Select
						  b.id,
						  a.centre_code,
						  a.centre_name
						From
						  mdl_cifa_exam a,
						  mdl_cifacourse b
						Where
						  a.centre_code = b.examcentrecode And
						  (b.id = '$courseid3')	
	");
	$row3=mysql_fetch_array($sql3);
	echo ucwords(strtolower($row3['centre_name']));
	?>
	</td>
    <td align="center">
	<?php 
	//calculate trainee
	//select trainee
	$coursename2=$sqlrow['id'];
	$sql3="Select
		  c.usertype,
		  a.category,
		  a.fullname,
		  c.firstname,
		  c.lastname,
		  b.enrolid
		From
		  mdl_cifacourse a,
		  mdl_cifauser_enrolments b,
		  mdl_cifauser c,
		  mdl_cifaenrol d
		Where
		  a.id = d.courseid And
		  d.id = b.enrolid And
		  b.userid = c.id And
		  (c.usertype = 'active trainee' And
		  a.id='$coursename2')";
	$query3=mysql_query($sql3);
	$row3=mysql_fetch_array($query3);	
		//sql unt kira candidate
		$enrolid=$row3['enrolid'];
		$sqlEnrol="	Select
					  a.enrolid,
					  Count(a.id) As myCount,
					  a.userid,
					  b.id
					From
					  mdl_cifauser_enrolments a,
					  mdl_cifauser b
					Where
					  a.userid = b.id And
					  (b.usertype = 'active trainee' And
					  a.enrolid = '$enrolid')
					Group By
					  a.enrolid
					Order By
					  a.id"; 
			
		$queryEnrol=mysql_query($sqlEnrol);
		$rowEnrol=mysql_fetch_array($queryEnrol);
		$count=$rowEnrol['myCount'];
		
		if($count>=1)
			echo $count;
		else
			echo '0';
	
	?>	
	</td>
    <!--td>	
	<?php 
	//start date
		//$unix_time = $sqlrow['startdate'];
		//echo unix_timestamp_to_human($unix_time);
	?></td-->
  </tr>
  <?php } ?> 
</table>