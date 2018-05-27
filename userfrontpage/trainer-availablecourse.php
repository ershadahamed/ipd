<!-- available course module-->
<?php	
	$sql="SELECT * FROM mdl_cifacourse";
	$query=mysql_query($sql);
?>
 <table id="availablecourse">
  <tr class="yellow">
    <th class="adjacent" width="1%">No</th>
    <th class="adjacent" width="18%" style="text-align:center;"><strong><?=get_string('programname');?></strong></th>
    <th class="adjacent" width="13%" align="left"><strong><?=get_string('programcodename');?></strong></th>
    <th class="adjacent" width="30%" align="left"><strong><?=get_string('programcoursename');?></strong></th>
    <th class="adjacent" width="14%" style="text-align:center;"><?=get_string('noofcandidate');?></th>
    <th class="adjacent" width="17%" style="text-align:center;"><?=get_string('coursestatus');?></th>
  </tr> 
<?php
	$row=mysql_fetch_array($query);
	if($row['id'] >= 1){ 
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $limit = 4;
    $startpoint = ($page * $limit) - $limit;	
	
	$statement="
                mdl_cifacourse a,
                mdl_cifaenrol b,
                mdl_cifauser_enrolments c,
                mdl_cifauser d
            Where
                a.id = b.courseid And
                b.id = c.enrolid And
                c.userid = d.id And
                (c.userid = '".$USER->id."' And 
                a.category='1' And a.visible='1')            

";
	$sqlcourse="SELECT * FROM {$statement}";
	$sqlcourse.="LIMIT {$startpoint} , {$limit}";
	$sqlquery=mysql_query($sqlcourse);
	$no=1;
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil=$no++;
		//to view trainer for courses
		$coursename=$sqlrow['id'];
		$sql2="Select *
			From
			  mdl_cifacourse a,
			  mdl_cifauser_enrolments b,
			  mdl_cifauser c,
			  mdl_cifaenrol d
			Where
			  a.id = d.courseid And
			  d.id = b.enrolid And
			  b.userid = c.id And
			  (c.usertype = 'trainer' And
			  a.id='$coursename')";
		$query2=mysql_query($sql2);
?>
  <tr valign="top">
    <td class="adjacent" width="1%" align="center"><?php echo $bil+($startpoint); ?></td>
    <td class="adjacent">
		<?php 
			$coursecategoryid=$sqlrow['category'];
			$rscoursecategory="SELECT id, name FROM mdl_cifacourse_categories WHERE id='".$coursecategoryid."'";
			$rscoursequery=mysql_query($rscoursecategory);
			$rs2=mysql_fetch_array($rscoursequery);
				echo ucwords(strtolower($rs2['name'])); 
		?>
	</td>
	<td class="adjacent" style="text-align:left;"><?php echo ucwords(strtoupper($sqlrow['shortname'])); ?></td>
    <td class="adjacent" style="text-align:left;">
		<a href="course/view.php?id=<?=$sqlrow['courseid'];?>" title="click to enter this course">
		<?php echo ucwords(strtolower($sqlrow['fullname'])); ?></a></td>
    <td class="adjacent">
	<?php 
	//calculate no of active trainee
        $scourse=mysql_query("SELECT * FROM mdl_cifacourse WHERE (category='1' or category='2')");
        $sc=mysql_fetch_array($scourse);
	$coursename2=$sc['id'];
	$sql3=" Select * From
		  mdl_cifauser_enrolments a,
		  mdl_cifaenrol b
		Where
		  a.enrolid = b.id And
		  (b.courseid = '".$coursename2."' And b.enrol='paypal' And b.status='0')";
	$query3=mysql_query($sql3);
	$row4=mysql_num_rows($query3);
	if($row4>0){ 
    ?>
            <a href="#" title="View list of trainee" onclick="window.open('listoftrainee.php?courseid=<?php echo $coursename2; ?>', 'Window2', 'width=820,height=600,resizable = 1');">
           <?php }
            echo $row4;
        if($row4>0){echo '</a>';}			
	?>
	</td>
	<td align="center" class="adjacent">
	<?php
	if ($sqlrow['visible'] == '1'){ echo 'Available'; }else{ echo'Not available';}
	?>
	</td>
  </tr>
  <?php }//} ?> 
<?php }else{ ?> 
  <tr>
    <td colspan="5" class="adjacent">No available course module</td>
  </tr>
<?php } ?>
</table>

<div style="margin-top:10px;">
<table align="center"><tr><td>
<?php 
	//paging numbers
	echo pagination($statement,$limit,$page); 
?>
</td></tr></table>
</div>