<?php
/*$sqlSelect=mysql_query(
"Select
					  a.id,
					  a.shortname,
					  a.fullname,
					  a.duration,
					  a.startdate,
					  b.courseid,
					  a.category
					From
					  mdl_cifacourse a,
					  mdl_cifaenrol b,
					  mdl_cifauser_enrolments c,
					  mdl_cifauser d
					Where
					  a.id = b.courseid And
					  b.id = c.enrolid And
					  c.userid = d.id And
					  (c.userid = '".$USER->id."') 
					Order by 
					  a.id desc");
$rowOrder1=mysql_fetch_array($sqlSelect);
	if(($rowOrder1['category'] == '3')){*/
	
		$sqlCourses="Select
					  a.id As courseid,
					  a.shortname,
					  a.fullname,
					  a.duration,
					  a.startdate,
					  a.category
					From
					  mdl_cifacourse a
					Where
					  (a.category='3' And a.visible='1') 
					Order by 
					  a.id desc";
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
			<div class="summary">
				<?php if($rowCourses['summary'] != ''){ ?>
				<div class="no-overflow">
						<!--p-->
							<!-- <b>Course Summary:</b> -->
							<?php echo $rowCourses['summary'];?>
						<!--/p-->
						<!-- <p>
							<b>Course start date:</b>
							<?php 
								//echo $row['startdate'];
								//start date
									//$unix_time = $rowCourses['startdate'];
									//echo unix_timestamp_to_human($unix_time);

							?>
						</p> -->
						<!--p>
							<b>Announcement:</b>
							<?php 
								/*$announcement = $rowCourses['courseid'];
								$sql="
									Select
									 *
									From
									  mdl_cifaforum_discussions a,
									  mdl_cifaforum_posts b
									Where
									  a.name = b.subject And
									  a.course = '$announcement'
								";
								
								$querySql=mysql_query($sql);
								$annResult=mysql_fetch_array($querySql);
								
								if($annResult){
									echo $annResult['message'];
								}else{
								//echo $row['startdate'];
									echo "<br/> Not available";
								}*/
							?>
						</p-->			
				</div><?php } ?>
			</div>		
		</div>
	</li>
</ul>			
<?php } /*}else{ echo 'No enroll';}*/ ?>	