<table style="width:100%"><tr><td>
<!-- available course module-->
<div style="width:100%;margin: 10px 0px 10px 0px; float: right; background-color: #EFF7FB;">
<div class="buttons">
    <a href="<?='course/category.php?id=1&categoryedit=on'; ?>" class="positive" title="Click to add new curriculum/module">
        <img src="image/switch_course_alternative.png" alt=""/>
        Add curriculum/module
    </a>
</div></div>

<?php	
	$sql="SELECT * FROM mdl_cifacourse Where Category='1' And id!='28'";
	$query=mysql_query($sql);
?>
<table id="availablecourse">
  <tr class="yellow">   
    <th class="adjacent" width="1%">No</th>
    <th class="adjacent" align="left"><strong>Curriculum Name</strong></th>
    <th class="adjacent" width="15%" align="left"><strong>Module Code</strong></th>
    <th class="adjacent" width="29%" align="left"><strong>Module Name</strong></th>
    <th class="adjacent" width="20%" align="left"><strong>Trainer</strong></th>
    <th class="adjacent" width="10%">No. of Trainee</th>
    <th class="adjacent" width="8%">Status</th>   
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
		//to view trainer for courses
		$coursename=$sqlrow['id'];
		$sql2="Select
					b.firstname,
					b.lastname
				From
					mdl_cifauser_enrolments a,
					mdl_cifauser b,
					mdl_cifaenrol c,
					mdl_cifarole_assignments d
				Where
					c.id = a.enrolid And
					a.userid = b.id And
					d.userid = a.userid And
					(c.courseid = '".$coursename."' And
					d.contextid = '1' And d.roleid='3')";
		$query2=mysql_query($sql2);
?>
  <tr>
    <td class="adjacent" width="1%" align="center"><?php echo $no++; ?></td>
    <td class="adjacent" style="text-align:left;">
		<?php 
			$coursecategoryid=$sqlrow['category'];
			$rscoursecategory="SELECT id, name FROM mdl_cifacourse_categories WHERE id='".$coursecategoryid."'";
			$rscoursequery=mysql_query($rscoursecategory);
			$rs2=mysql_fetch_array($rscoursequery);
				echo ucwords(strtolower($rs2['name'])); 
		?>
	</td>
	<td class="adjacent"><?php echo ucwords(strtolower($sqlrow['shortname'])); ?></td>
    <td class="adjacent" style="text-align:left;">
		<a href="course/view.php?id=<?=$sqlrow['id'];?>" title="click to enter this course">
		<?php echo ucwords(strtolower($sqlrow['fullname'])); ?></a></td>
    <td class="adjacent" style="text-align:left;">
	<?php 
		//to view trainer for courses
        $count=mysql_num_rows($query2);
        if($count>0){
			while($row2=mysql_fetch_array($query2)){ 
				echo '<ul><li>';
				echo ucwords(strtolower($row2['firstname'].' '.$row2['lastname']));
				echo '</li></ul>';			
			} 
		}else{            
 			echo '<ul><li>';
                        echo 'Not set';
			echo '</li></ul>';                   
                }
	?>
	</td>
    <td class="adjacent" align="center">
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
	$row4=mysql_num_rows($query3);
	if($row4>0){ 
    ?>
            <a href="#" title="View list of trainee" onclick="window.open('listoftrainee.php?courseid=<?php echo $coursename2; ?>', 'Window2', 'width=820,height=600,resizable = 1');">
           <?php }
            echo $row4;
        if($row4>0){echo '</a>';}                                
	?>
	</td>
	<td class="adjacent">
	<?php
			if ($sqlrow['visible'] == '1'){ echo 'Available'; }else{ echo'In progress';}
	?>
	</td>
  </tr>
  <?php } ?> 
<?php }else{ ?> 
  <tr>
    <td class="adjacent" colspan="6">No available course module</td>
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