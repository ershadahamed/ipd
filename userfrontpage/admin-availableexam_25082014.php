<!-- available exam -->
<!-- available exam -->
<!-- available exam -->
<div align="right" style="width:100%;margin: 10px 0px 10px 0px; float: right;">
<div class="buttons">
    <a href="<?php echo $CFG->wwwroot . '/course/edit_exam.php?category=3&categoryedit=1'; ?>" class="positive" title="Click to add new exam">
        <img src="image/switch_course_alternative.png" alt=""/>
        Add New Exam
    </a>

    <a href="<?php echo $CFG->wwwroot . '/course/category.php?id=3&categoryedit=on'; ?>" class="regular" title="Click to manage category">
        <img src="image/configure.png" alt=""/>
        Manage category
    </a>
</div></div>
	
<table id="availablecourse">
  <tr class="yellow">
    <th width="1%">No</th>
    <th width="15%">Code</th>
    <th>Exam / Test Name</th>
    <!--th width="15%">Exam Centre</th-->
    <th width="13%">No. of Candidate</th>
    <th width="13%" style="text-align:center;"><?=get_string('manualenrolments');?></th>
  </tr>
<?php
	$row=mysql_fetch_array($query);
	if($row['id'] >= 1){ 
	
	$sqlcourse="SELECT * FROM mdl_cifacourse WHERE category='3' AND visible = '1'";
	$sqlquery=mysql_query($sqlcourse);
	$no=1;
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil= $no++;
?>
  <tr>
    <td width="1%" class="adjacent" ><?php echo $bil; ?></td>
    <td class="adjacent" style="text-align:left;"><?php echo ucwords(strtoupper($sqlrow['shortname'])); ?></td>
	<td class="adjacent" style="text-align:left;">
		<a href="course/view.php?id=<?=$sqlrow['id'];?>" title="click to enter this exam module">
		<?php echo ucwords(strtolower($sqlrow['fullname'])); ?></a></td>
    <td align="center" class="adjacent" >
	<?php 
	//calculate trainee
	//select trainee
	$coursename=$sqlrow['id'];
	$sql_role=mysql_query("Select id, name From mdl_cifarole Where id='5'");
	$sqlrows=mysql_fetch_array($sql_role);
	$candidaterole = $sqlrows['name'];
	
	$sql3="
		Select
			  b.userid,
			  a.courseid
		From
		  mdl_cifaenrol a Inner Join
		  mdl_cifauser_enrolments b On a.id = b.enrolid Inner Join
		  mdl_cifauser c On c.id = b.userid
		Where
		  a.courseid = '".$coursename."' And
		  a.status = '0' And
		  c.usertype='".$candidaterole."'
	";
	$query3=mysql_query($sql3);	
	$row4=mysql_num_rows($query3);
	echo $row4;
	
	/* $sql3=" Select * From
		  mdl_cifauser_enrolments a,
		  mdl_cifaenrol b
		Where
		  a.enrolid = b.id And
		  (b.courseid = '".$coursename."' And b.status='0')";
	$query3=mysql_query($sql3);
	$row4=mysql_num_rows($query3);
            echo $row4;	 */
	
	?>	
	</td>
    <td align="center" class="adjacent" >
	<form id="form1" name="form1" method="post" action="">
	<div style="padding: 5px;"><input type="submit" onClick="this.form.action='<?=$CFG->wwwroot ."/enrol/users.php?id=".$sqlrow['id'];?>'" name="<?=get_string('enrolcandidates');?>" value="<?=get_string('enrolcandidates');?>" />	</div>
	</form>
	<?php 
	//start date
		//$unix_time = $sqlrow['startdate'];
		//echo unix_timestamp_to_human($unix_time);
	?></td>
  </tr>
  <?php } ?> 
<?php }else{ ?> 
  <tr>
    <td class="adjacent" colspan="5">No available Exam</td>
  </tr>
<?php } ?>
</table>