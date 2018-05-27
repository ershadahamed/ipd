<table style="width:100%"><tr><td>
<!-- available course module-->
<div style="width:100%;margin: 10px 0px 10px 0px; float: right; background-color: #EFF7FB;">
<div class="buttons">
    <a href="<?='course/category.php?id=1&categoryedit=on'; ?>" class="positive" title="Click to add new curriculum/module">
        <img src="image/switch_course_alternative.png" alt=""/>
        Add curriculum/module
    </a>

    <!--a href="<?//='course/category.php?id=1&categoryedit=on'; ?>" class="regular" title="Click to manage category / course">
        <img src="image/configure.png" alt=""/>
        Manage category/course
    </a-->
</div></div>

<?php	
	$sql="SELECT * FROM mdl_cifacourse Where Category='1' And id!='28'";
	$query=mysql_query($sql);
?>
<table id="avalaiblecourse" border="1" style="border-collapse: collapse; background-color: #fff; width:100%;">
  <tr>   
    <th width="1%">No</th>
    <td width="20%" align="left"><strong>Course Name</strong></td>
    <td width="15%" align="left"><strong>Module Code</strong></td>
    <td width="30%" align="left"><strong>Module Name</strong></td>
    <td width="15%" align="left"><strong>Trainer</strong></td>
    <th width="10%">No. of Trainee</th>
    <td width="17%" align="left"><strong>Status</strong></td>   
  </tr>
<?php
	$row=mysql_num_rows($query);
	if($row>= 1){ 
	
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $limit = 10;
    $startpoint = ($page * $limit) - $limit;	
	
	$statement="mdl_cifacourse WHERE 	(category='1' or category='2')";
	$sqlcourse="SELECT * FROM {$statement}";
	$sqlcourse.="LIMIT {$startpoint} , {$limit}";
		
	$sqlquery=mysql_query($sqlcourse);
	$no='1';
	while($sqlrow=mysql_fetch_array($sqlquery)){
		//$bil= $no++;
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
		if($sqlrow['fullname'] != 'Online Chat'){
?>
  <tr valign="top">
    <td width="1%" align="center"><?php echo $no++; ?></td>
    <td>
		<?php 
			$coursecategoryid=$sqlrow['category'];
			$rscoursecategory="SELECT id, name FROM mdl_cifacourse_categories WHERE id='".$coursecategoryid."'";
			$rscoursequery=mysql_query($rscoursecategory);
			$rs2=mysql_fetch_array($rscoursequery);
				echo ucwords(strtolower($rs2['name'])); 
		?>
	</td>
	<td><?php echo ucwords(strtolower($sqlrow['shortname'])); ?></td>
    <td>
		<a href="course/view.php?id=<?=$sqlrow['id'];?>" title="click to enter this course">
		<?php echo ucwords(strtolower($sqlrow['fullname'])); ?></a></td>
    <td>
	<?php 
		//to view trainer for courses
		while($row2=mysql_fetch_array($query2)){ 
			echo '<ul><li>';
			if(($row2['usertype'] != 'trainer') || ($row2['usertype'] == '')){
				echo 'Not set';
			}else{
				echo ucwords(strtolower($row2['firstname'].' '.$row2['lastname']));
			}
			echo '</li></ul>';			
			echo '<br/>';
		} 
	?>
	</td>
    <td align="center">
	<?php 
	//calculate no of active trainee
	$coursename2=$sqlrow['id'];
	$sql3=" Select * From
		  mdl_cifauser_enrolments a,
		  mdl_cifaenrol b
		Where
		  a.enrolid = b.id And
		  (b.courseid = '".$coursename2."' And b.enrol='paypal' And b.status='0')";
	$query3=mysql_query($sql3);
	//$row3=mysql_fetch_array($query3);
	$row4=mysql_num_rows($query3);
	if($row4>0){ 
            //echo '<a href="#" title="View list of trainee">'; ?>
            <a href="#" title="View list of trainee" onclick="window.open('listoftrainee.php?courseid=<?php echo $coursename2; ?>', 'Window2', 'width=820,height=600,resizable = 1');">
           <?php }
            echo $row4;
        if($row4>0){echo '</a>';}       
	/*$row3=mysql_fetch_array($query3);	

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
			echo '0';*/
                               
	?>
	</td>
    <!--td>
	<?php 
	//start date
		//$unix_time = $sqlrow['startdate'];
		//echo unix_timestamp_to_human($unix_time);
	?>
	</td-->
	<td>
	<?php
			if ($sqlrow['visible'] == '1'){ echo 'Available'; }else{ echo'In progress';}
	?>
	</td>
  </tr>
  <?php }} ?> 
<?php }else{ ?> 
  <tr>
    <td colspan="6">No available course module</td>
  </tr>
<?php } ?>
</table><br/>
</td></tr></table>

<div style="margin-top:10px;">
<table align="center"><tr><td>
<?php 
	//paging numbers
	echo pagination($statement,$limit,$page); 
?>
</td></tr></table>
</div>