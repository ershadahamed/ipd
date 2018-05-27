<!-- available exam -->
<!-- available exam -->
<!-- available exam -->
<div align="right" style="width:100%;margin: 10px 0px 10px 0px; float: right; background-color: #EFF7FB;">
<table id="avalaiblecourse" border="1" style="border-collapse: collapse; background-color: #fff;">
  <tr>
    <th width="1%">No</th>
    <th width="33%" style="text-align:left">Code</th>
    <th style="text-align:left">Exam Name</th>
    <th width="13%" style="text-align:left">Status</th>
  </tr>
<?php
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
                a.category='3' And a.visible='1')            

	";
	$sqlcourse="SELECT * FROM {$statement}";	
	$sqlquery=mysql_query($sqlcourse);
	$c=mysql_num_rows($sqlquery);
	if($c!='0'){
	$no=1;
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil= $no++;
?>
  <tr valign="middle">
    <td width="1%"><?php echo $bil; ?></td>
    <td><?php echo ucwords(strtoupper($sqlrow['shortname'])); ?></td>
	<td>
		<a href="course/view.php?id=<?=$sqlrow['courseid'];?>" title="click to enter this exam module">
		<?php echo ucwords(strtolower($sqlrow['fullname'])); ?></a></td>
	<td>
	<?php
			if ($sqlrow['visible'] == '1'){ echo 'Available'; }else{ echo'Not available';}
	?>	
	</td>
  </tr>
  <?php } ?> 
<?php }else{ ?> 
  <tr>
    <td colspan="4">No Available Module Exam</td>
  </tr>
<?php } ?>
</table>