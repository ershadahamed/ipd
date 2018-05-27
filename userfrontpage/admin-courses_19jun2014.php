<!--table style="width:100%"><tr><td-->
<!-- available course module-->
<div style="width:100%;margin: 0px 0px 10px 0px; float: right; ">
<div class="buttons">
    <a href="<?='course/category.php?id=1&categoryedit=on'; ?>" class="positive" title="Click to add new curriculum/module">
        <img src="image/switch_course_alternative.png" alt="Click to add new curriculum/module"/>
        <?=ucwords(strtolower(get_string('addcurriculummodule')));?>
    </a>
</div></div>

<?php	
	$sql="SELECT * FROM mdl_cifacourse Where Category='1' And id!='28'";
	$query=mysql_query($sql);
?>
<table id="availablecourse2">
  <tr class="yellow">   
    <th class="adjacent" width="1%">No</th>
    <th class="adjacent" width="17%" style="text-align:left;"><strong><?=ucwords(strtolower(get_string('programname')));?></strong></th>
    <th class="adjacent" width="12%" style="text-align:center;"><strong><?=ucwords(strtolower(get_string('programcodename')));?></strong></th>
    <th class="adjacent" width="30%" align="left"><strong><?=ucwords(strtolower(get_string('programcoursename')));?></strong></th>
    <th class="adjacent" width="13%" style="text-align:center;"><?=ucwords(strtolower(get_string('noofcandidate')));?></th>
    <th class="adjacent" width="15%" style="text-align:center;"><strong><?=ucwords(strtolower(get_string('moduleprice')));?></strong></th>	
    <th class="adjacent" width="10%" style="text-align:center;"><?=ucwords(strtolower(get_string('coursestatus')));?></th> 		
	<th class="adjacent" width="17%" style="text-align:center;"><?=ucwords(strtolower(get_string('manualenrolments')));?></th> 
  </tr>
<?php
	$row=mysql_num_rows($query);
	if($row>= 1){ 
	
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $limit = 10;
    $startpoint = ($page * $limit) - $limit;	
	
	//$statement="mdl_cifacourse WHERE 	(category='1' or category='2' or category='7')";
	$statement="mdl_cifacourse WHERE visible!='0' AND (category!='0' AND category!='4' AND category!='6')";		
	$sqlcourse="SELECT * FROM {$statement}";
	$sqlcourse.="LIMIT {$startpoint} , {$limit}";
		
	$sqlquery=mysql_query($sqlcourse);
	$no='1';
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
?>
  <tr>
    <td class="adjacent" width="1%" align="center"><?php echo $bil + ($startpoint); ?></td>
    <td class="adjacent" style="text-align:left;">
		<?php 
			$coursecategoryid=$sqlrow['category'];
			$rscoursecategory="SELECT id, name FROM mdl_cifacourse_categories WHERE id='".$coursecategoryid."'";
			$rscoursequery=mysql_query($rscoursecategory);
			$rs2=mysql_fetch_array($rscoursequery);
				//echo ucwords(strtolower($rs2['name'])); 
				echo $rs2['name']; 
		?>
	</td>
	<td class="adjacent"><?php echo ucwords(strtoupper($sqlrow['idnumber'])); ?></td>
    <td class="adjacent" style="text-align:left;">
		<a href="course/view.php?id=<?=$sqlrow['id'];?>" title="click to enter this course">
		<?php echo ucwords(strtolower($sqlrow['fullname'])); ?></a></td>
    <td class="adjacent" align="center">
	<?php 
	//calculate no of active trainee
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
		  a.status = '0' And
		  c.usertype='".$candidaterole."'
	";
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
    <td align="center" class="adjacent" >
	<form id="form1" name="form1" method="post" action="">
	<?php
	
    $sqlcourse4=mysql_query("
		Select
		  *,
		  b.id As enrolid
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifaenrol b On a.id = b.courseid
		Where
		  a.category = '1' And 
		  a.id = '".$coursename."' And
		  b.enrol = 'manual' And
		  a.visible = '1' And
		  b.status = '0'
	");	
	$sqlq4=mysql_fetch_array($sqlcourse4);
	echo '<input type="hidden" value="'.$sqlq4['id'].'" name="changepricehidden" />';
	echo '<input type="hidden" value="'.$sqlq4['cost'].'" name="savepricehidden" />';
		
	if(($_POST['priceupdate'])){
		$priceid=$_GET['priceid'];
		if($priceid == $sqlq4['id']){
			echo '$ <input type="text" value="'.$sqlq4['cost'].'" name="changeprice" style="background-color:lightyellow;text-align:center;width:40px" />';
		}else{
			echo '$ '. $sqlq4['cost'];
			
		}	
	}else if($_POST['saveprice']){
		$priceid=$_GET['priceid'];
		$changeprice=$_POST['changeprice'];
		$itemid=$_GET['pricechangestatus'];
		if(($priceid == $sqlq4['id']) && ($itemid == '1')){	
			//echo '$ '. $changeprice;
			$tukarharga=mysql_query("UPDATE mdl_cifaenrol SET cost='".$changeprice."' WHERE enrol = 'manual' AND status = '0' AND id='".$priceid."'");
			echo '<div style="background-color:#00ff00;"> Updated </div>';
			echo '$ '. $changeprice;
		}else{
			echo '$ '. $sqlq4['cost'];
		}
	}else{
		echo '$ '. $sqlq4['cost'];
		
	}
	
	?>
		<?php 	if($_POST['priceupdate']){ 
					$priceid=$_GET['priceid'];
					if($priceid == $sqlq4['id']){ ?>		
						<input onClick="this.form.action='<?=$CFG->wwwroot ."/coursesindex.php?priceid=".$sqlq4['id']."&pricechangestatus=1";?>'" style="margin-left: 5px;" type="submit" value="Save" id="saveprice" name="saveprice" title="<?=get_string('saveprice');?>" onMouseOver="style.cursor='pointer'"  />							
		<?php 		}else{ ?>
						<input onClick="this.form.action='<?=$CFG->wwwroot ."/coursesindex.php?priceid=".$sqlq4['id'];?>'" style="margin-left: 5px;" type="submit" value="Change" id="priceupdate" name="priceupdate" title="<?=get_string('changeprice');?>" onMouseOver="style.cursor='pointer'"  />		
		<?php
					}
				}else{ ?>
					<input onClick="this.form.action='<?=$CFG->wwwroot ."/coursesindex.php?priceid=".$sqlq4['id'];?>'" style="margin-left: 5px;" type="submit" value="Change" id="priceupdate" name="priceupdate" title="<?=get_string('changeprice');?>" onMouseOver="style.cursor='pointer'"  />
		<?php } ?>
		
	</form>
	</td>		
	<td class="adjacent">
	<?php
			if ($sqlrow['visible'] == '1'){ echo 'Available'; }else{ echo'In progress';}
	?>
	</td>
    <td align="center" class="adjacent" >
		<form id="form1" name="form1" method="post" action="">
		<div style="padding: 5px;"><input type="submit" onClick="this.form.action='<?=$CFG->wwwroot ."/enrol/users.php?id=".$coursename;?>'" name="<?=get_string('enrolledusers');?>" value="<?=get_string('enrolledusers');?>" />	</div>
		</form>
	</td>
  </tr>
  <?php } ?> 
<?php }else{ ?> 
  <tr>
    <td class="adjacent" colspan="6">No available course module</td>
  </tr>
<?php } ?>
</table><br/>
<!--/td></tr></table-->

<div style="margin-top:10px;">
<table align="center"><tr><td>
<?php 
	//paging numbers
	echo pagination($statement,$limit,$page); 
?>
</td></tr></table>
</div>