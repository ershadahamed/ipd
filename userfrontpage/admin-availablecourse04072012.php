<!-- available course module-->
<div align="left" style="width:100%;margin: 10px 0px 10px 0px; float: right; background-color: #EFF7FB;">
<div class="buttons">
    <a href="<?='course/edit.php?category=1&returnto=category'; ?>" class="positive" title="Click to add new curriculum/module">
        <img src="image/switch_course_alternative.png" alt=""/>
        Add new module
    </a>

    <a href="<?='course/category.php?id=1&categoryedit=on'; ?>" class="regular" title="Click to manage category / curriculum / module">
        <img src="image/configure.png" alt=""/>
        Manage curriculum/module
    </a>
</div></div>

<?php	
	$sql="SELECT * FROM mdl_cifacourse";
	$query=mysql_query($sql);
?>
<table id="avalaiblecourse" border="1" style="border-collapse: collapse; background-color: #fff;">
  <tr>
    <th width="1%">No</th>
    <td width="20%" align="left"><strong>Curriculum Name</strong></td>
    <td width="15%" align="left"><strong>Module Code</strong></td>
    <td width="30%" align="left"><strong>Module Name</strong></td>
    <td width="15%" align="left"><strong>Trainer</strong></td>
    <th width="10%">No. of Trainee</th>
    <th width="17%">Status</th>
    <!--th width="15%">Start Date</th-->
  </tr>
<?php
	$row=mysql_fetch_array($query);
	if($row['id'] >= 1){ 
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $limit = 4;
    $startpoint = ($page * $limit) - $limit;	
	
	$statement="mdl_cifacourse WHERE 	(category='1' or category='2')";
	$sqlcourse="SELECT * FROM {$statement}";
	$sqlcourse.="LIMIT {$startpoint} , {$limit}";
	$sqlquery=mysql_query($sqlcourse);
	$bil=1;
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
		//if($sqlrow['id'] != '28'){
?>
  <tr valign="top">
    <td width="1%" align="center"><?php echo $bil++; ?></td>
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
		/*while($row3=mysql_fetch_array($query3)){

		$enrolid=$row3['enrolid'];
		echo $enrolid.'<br/>';}
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
					  (a.enrolid = '$enrolid')
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
	<td align="center">
	<?php
			if ($sqlrow['visible'] == '1'){ echo 'Available'; }else{ echo'Not available';}
	?>
	</td>
  </tr>
  <?php }//} ?> 
<?php }else{ ?> 
  <tr>
    <td colspan="6">No available course module</td>
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