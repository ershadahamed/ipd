<?php if (isloggedin()) { 
		if(($USER->id)=='2'){?>
<fieldset><legend>List of available exams</legend>
<?php }}else{ ?><fieldset><!--legend>List of available exams</legend--><?php } ?>
<table id="avalaiblecourse" border="0" cellpadding="0" cellspacing="0">
<?php
	
		//*****************available courses for trainee******************************//				
		$sqlCourses="Select
					  a.id as courseid,
					  a.shortname,
					  a.fullname,
					  a.duration,
					  a.startdate,
					  a.category,
					  a.summary
					From
					  mdl_cifacourse a
					Where
					  a.category = '3' And a.visible='1'
					Order By
					  a.id Desc";
					    
		$queryCourses=mysql_query($sqlCourses);

	while($rowCourses=mysql_fetch_array($queryCourses)){
?>	


<tr><td>
<h3 class="name">
<?php if (isloggedin()) { 
		if(($USER->id)!='2'){
?>
			<a href="portal/subscribe/paydetails_loggeduser.php?id=<?=$rowCourses['courseid'];?>" title="click to subscribe modules">
			<?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['shortname'];?></a> 
	
<?php }else{ ?>
	<a href="course/view.php?id=<?=$rowCourses['courseid'];?>" title="click to enter this exam">
	<?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['shortname'];?></a>		
		
<?php		}
	}else{ 
?>
<a href="portal/subscribe/paydetails.php?id=<?=$rowCourses['courseid'];?>" title="click to subscribe modules">
<?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['shortname'];?></a>
<?php } ?>
</h3></td></tr>
<?php if($rowCourses['summary'] != ''){ ?>
<tr>
<td>
<?php 
	if (isloggedin()) { 
		if(($USER->id)!='2'){
			echo '<div style="text-align:justify;">'.$rowCourses['summary'].'</div>';
		}else{
			echo '<div style="text-align:justify;">'.$rowCourses['summary'].'</div>';
		}
	}else{
	echo '<div style="text-align:justify;">'.$rowCourses['summary'].'</div>';
	}
?>
</td>
</tr><?php }else{ ?>
<tr>
<td>
<?php 
	echo "No summary for this exams";}
?>
</td>
</tr>

<?php } ?>	</table></fieldset>	