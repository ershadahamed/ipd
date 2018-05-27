<?php

$sqlSelect2=mysql_query(
"Select
  a.category,
  a.fullname
From
  mdl_cifacourse a,
  mdl_cifaenrol b,
  mdl_cifauser_enrolments c
Where
  a.id = b.courseid And
  b.id = c.enrolid And
					  (c.userid = '".$USER->id."') 
					Order by 
					  a.id desc");
$rowOrder2=mysql_fetch_array($sqlSelect2);
	if(($rowOrder2['category'] >= '1')){
	//echo 'no enroll courses module';
	
	
		//*****************available courses for trainee******************************//				
		$sqlCourses="Select
				  a.category,
				  a.fullname,
				  a.shortname,
				  a.id,
				  a.summary
				From
				  mdl_cifacourse a
				where
				  a.category = '1' 
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
					<a href="course/view.php?id=<?=$rowCourses['id'];?>" title="click to enter this course">
						<?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['shortname'];?></a>
				</h3>		
			</div>
			<div class="summary">
				<div class="no-overflow">
						<p>
							<!-- <b>Course Summary:</b> -->
							<?php echo $rowCourses['summary'];?>
						</p>
						<!-- <p>
							<b>Course start date:</b>
							<?php 
								//echo $row['startdate'];
								//start date
									//$unix_time = $rowCourses['startdate'];
									//echo unix_timestamp_to_human($unix_time);

							?>
						</p> -->
						 <p>
							<b>Announcement:</b>
							<?php 
								$announcement = $rowCourses['id'];
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
								}
							?>
						</p>				
				</div>
			</div>		
		</div>
	</li>
</ul>	
<?php //} ?>		
<?php }}else{ echo '<br/>Dont have any enrollment to show';} ?>	