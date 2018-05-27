<!-- available course module-->
<div align="left" style="width:100%;margin: 10px 0px 10px 0px; float: right;">
<div class="buttons">
    <a href="<?='course/edit.php?category=1&returnto=category'; ?>" class="positive" title="Click to add new curriculum/module">
        <img src="image/switch_course_alternative.png" alt=""/>
        <?=get_string('addnewmodule');?>
    </a>

    <a href="<?='course/category.php?id=1&categoryedit=on'; ?>" class="regular" title="Click to manage category / curriculum / module">
        <img src="image/configure.png" alt=""/>
        <?=get_string('manageprogram');?>
    </a>		
</div></div>

<?php	
	$sql="SELECT * FROM mdl_cifacourse";
	$query=mysql_query($sql);
?>
<table id="availablecourse">
  <tr class="yellow">
    <th class="adjacent" width="1%">No</th>
    <th class="adjacent" width="15%" style="text-align:center;"><strong><?=get_string('programname');?></strong></th>
    <th class="adjacent" width="13%" style="text-align:center;"><strong><?=get_string('programcodename');?></strong></th>
    <th class="adjacent" width="30%" align="left"><strong><?=get_string('programcoursename');?></strong></th>
    <th class="adjacent" width="20%" align="left"><strong><?=get_string('trainername');?></strong></th>
    <th class="adjacent" width="14%" style="text-align:center;"><?=get_string('noofcandidate');?></th>
    <th class="adjacent" width="7%" style="text-align:center;"><?=get_string('coursestatus');?></th>
  </tr>
<?php
	$row=mysql_fetch_array($query);
	if($row['id'] >= 1){ 
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $limit = 10;
    $startpoint = ($page * $limit) - $limit;	
	
	//$statement="mdl_cifacourse WHERE (category='1' or category='2' or category='7')";
	$statement="mdl_cifacourse WHERE visible!='0' AND (category='1') Order By idnumber ASC";	
	$sqlcourse="SELECT * FROM {$statement}";
	//$sqlcourse.="LIMIT {$startpoint} , {$limit}";
	$sqlquery=mysql_query($sqlcourse);
	$no=1;
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil=$no++;
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
  <tr>
    <td class="adjacent" width="1%" align="center"><?php echo $bil+($startpoint); ?></td>
    <td class="adjacent">
		<?php 
					//echo date('d/m/Y H:i:s','1357833600').' <br/>';
			$coursecategoryid=$sqlrow['category'];
			$rscoursecategory="SELECT id, name FROM mdl_cifacourse_categories WHERE id='".$coursecategoryid."'";
			$rscoursequery=mysql_query($rscoursecategory);
			$rs2=mysql_fetch_array($rscoursequery);
				//echo ucwords(strtolower($rs2['name'])); 
				echo $rs2['name'];
		?>
	</td>
	<td class="adjacent" style="text-align:center;"><?php echo ucwords(strtoupper($sqlrow['idnumber'])); ?></td>
    <td class="adjacent" style="text-align:left;">
		<a href="course/view.php?id=<?=$sqlrow['id'];?>" title="click to enter this course">
		<?php echo $sqlrow['fullname']; ?></a></td>
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
    <td align="center" class="adjacent" >
	<?php 
	//calculate no of active trainee//And b.enrol='paypal' And b.status='0'
	$coursename2=$sqlrow['id'];
	
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
		  a.status = '0' AND b.userid!='391' AND b.userid!='269' And
		  (c.usertype='".$candidaterole."' Or c.usertype='Inactive candidate')
	";
	$query3=mysql_query($sql3);
	//$row3=mysql_fetch_array($query3);
	$row4=mysql_num_rows($query3);
	if($row4>0){ 
            //echo '<a href="#" title="View list of trainee">'; ?>
            <a href="#" title="View list of trainee" onclick="window.open('listoftrainee.php?courseid=<?php echo $coursename2; ?>', 'Window2', 'width=850,height=600,resizable = 1');">
           <?php }
            echo $row4;
        if($row4>0){echo '</a>';}					
	?>
	</td>
	<td align="center" class="adjacent" >
	<?php
			if ($sqlrow['visible'] == '1'){ echo 'Available'; }else{ echo'Not available';}
	?>
	</td>
  </tr>
  <?php }//} ?> 
<?php }else{ ?> 
  <tr>
    <td colspan="6" class="adjacent" >No available course module</td>
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