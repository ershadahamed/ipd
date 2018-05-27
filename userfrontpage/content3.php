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
					  a.category = '1' And a.visible='1'
					Order By
					  a.id Desc";
					  
		$queryCourses=mysql_query($sqlCourses);

	while($rowCourses=mysql_fetch_array($queryCourses)){
?>	
<br/>		
<ul class="unlist">
	<li>
		<div class="coursebox clearfix">
			<div class="info">
				<h3 class="name">
					<a href="course/view.php?id=<?=$rowCourses['courseid'];?>" title="click to enter this course">
						<?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['shortname'];?></a>
				</h3>		
			</div>
			<div class="summary"><?php if($rowCourses['summary'] != ''){ ?>
				<div class="no-overflow">
							<?php echo $rowCourses['summary'];?>			
				</div><?php } ?>
			</div>		
		</div>
	</li>
</ul>	
<?php //} ?>		
<?php }/*}else{ echo 'No enroll';}*/ ?>	