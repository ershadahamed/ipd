<!-- available exam -->
<!-- available exam -->
<!-- available exam -->
<?php include('../manualdbconfig.php'); ?>
<div align="right" style="width:100%;margin: 10px 0px 10px 0px; float: right; ">
<div class="buttons">
    <a href="<?php echo $CFG->wwwroot . '/course/category_3.php?id=3&categoryedit=on'; ?>" class="positive" title="Click to add test">
        <img src="image/switch_course_alternative.png" alt=""/>
        Add category/test/module
    </a>

    <!--a href="<?php //echo $CFG->wwwroot . '/course/category_3.php?id=3&categoryedit=on'; ?>" class="regular" title="Click to manage category">
        <img src="image/configure.png" alt=""/>
        Manage category
    </a-->
</div></div>
	
<!--table id="avalaiblecourse" border="1" style="border-collapse: collapse; background-color: #fff;"-->
<table id="availablecourse">
  <tr class="yellow">
    <th class="adjacent" width="1%">No</th>
    <th class="adjacent" width="20%">Course Code</th>
    <!--th class="adjacent">Exam Name</th-->
    <th class="adjacent" width="20%">Test Title</th>
    <th class="adjacent" width="13%">No. of Candidate</th>
	<th width="13%" style="text-align:center;"><?=get_string('manualenrolments');?></th>
    <!--th width="13%">Exam Date</th-->
  </tr>
<?php

	
	$sqlcourse="SELECT * FROM mdl_cifacourse WHERE (category='3' Or category='9') AND visible='1'";
	$sqlquery=mysql_query($sqlcourse);
	$no=1;
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil= $no++;
?>
  <tr valign="middle">
    <td class="adjacent" width="1%"><?php echo $bil; ?></td>
    <td class="adjacent" style="text-align:left;"><?php echo ucwords(strtoupper($sqlrow['idnumber'])); ?></td>
	<td class="adjacent" style="text-align:left;">
		<a href="course/view.php?id=<?=$sqlrow['id'];?>" title="click to enter this test">
		<?php echo ucwords(strtolower($sqlrow['fullname'])); ?></a></td>
    <!--td class="adjacent" style="text-align:left;">
	<?php
	//select centre_name for exam
	/*$courseid3=$sqlrow['id'];
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
	echo ucwords(strtolower($row3['centre_name']));*/
	?>
	</td-->
    <td class="adjacent" align="center">
	<?php 
	//calculate trainee
	//select trainee			
	$coursename2=$sqlrow['id'];
	$sql3=" Select * From
		  mdl_cifauser_enrolments a,
		  mdl_cifaenrol b
		Where
		  a.enrolid = b.id And
		  (b.courseid = '".$coursename2."' And b.status='0')";
	$query3=mysql_query($sql3);
	$row4=mysql_num_rows($query3);
            echo $row4;		
	?>	
	</td>
    <td align="center" class="adjacent" >
	<form id="form1" name="form1" method="post" action="">
	<div style="padding: 5px;"><input type="submit" onClick="this.form.action='<?=$CFG->wwwroot ."/enrol/users.php?id=".$sqlrow['id'];?>'" name="<?=get_string('enrolcandidates');?>" value="<?=get_string('enrolcandidates');?>" />	</div>
	</form>	
	</td>
  </tr>
  <?php } ?> 
</table>