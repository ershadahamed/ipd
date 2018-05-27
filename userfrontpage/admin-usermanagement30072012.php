<!-- available course module-->
<div align="left" style="width:100%;margin: 10px 0px 10px 0px; float: right; background-color: #EFF7FB;">
<div class="buttons">
    <a href="<?='user/editadvanced.php?id=-1'; ?>" class="positive" title="Click to add new user">
        <img src="image/switch_course_alternative.png" alt=""/>
        Add User
    </a>
    <!--a href="<?php //echo $CFG->wwwroot.'/userfrontpage/useraddcategory.php';?>" class="regular" title="Click to manage category/user"-->
	<a href="<?php echo $CFG->wwwroot.'/admin/user.php';?>" class="regular" title="Click to manage category/user">
        <img src="image/configure.png" alt=""/>
        Manage category/user
    </a>
</div></div>

<?php	
	$sql="SELECT * FROM mdl_cifauser";
	$query=mysql_query($sql);
?>
<table id="availablecourse">
  <tr class="yellow">
    <th class="adjacent" width="1%">No</th>
	<!--th class="adjacent" width="20%" align="left"><strong>Category</strong></th-->
    <th class="adjacent" width="30%" align="left"><strong>Name</strong></th>
    <th class="adjacent" width="29%" align="left"><strong>Email</strong></th>
    <th class="adjacent" width="10%" style="text-align:center;">Status</th>
  </tr>
<?php
	$row=mysql_fetch_array($query);
	if($row['id'] >= 1){ 
	
    //paging
    //$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    //$limit = 10;
    //$startpoint = ($page * $limit) - $limit;	
	
	$statement="mdl_cifauser WHERE 	deleted='0' AND (id!='1' AND id!='2')";
	$sqlcourse="SELECT * FROM {$statement}";
	//$sqlcourse.="LIMIT {$startpoint} , {$limit}";	
	
	/*$sqlcourse="SELECT *
		FROM 	mdl_cifauser
		WHERE 	deleted='0' AND (id!='1' AND id!='2')";*/
		
	$sqlquery=mysql_query($sqlcourse);
	$no='1';
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil= $no++;
?>
  <tr>
    <td class="adjacent" width="1%" align="center"><?php echo $bil; ?></td>
    <!--td class="adjacent"-->
	<?php
		/*$categoryuserid=$sqlrow['usercategoryid'];
		$qryU="SELECT * FROM mdl_cifauser_category WHERE id='".$categoryuserid."' ORDER BY id ASC";
		$sqlU=mysql_query($qryU);
		$rs=mysql_fetch_array($sqlU);
			echo ucwords(strtolower($rs['categoryname']));*/
	?>
	<!--/td-->
	<td class="adjacent" style="text-align:left;">
		<?php 
			//view user fullname
			$userfullname=$sqlrow['firstname'].' '.$sqlrow['lastname'];
			echo ucwords(strtolower($userfullname)); 
		?>
	</td>
    <td class="adjacent" style="text-align:left;">
		<!--a href="course/view.php?id=<?//=$sqlrow['id'];?>" title="click to enter this user"-->
		<?php echo $sqlrow['email']; ?><!--/a-->
	</td>
    <td align="center" class="adjacent">
	<?php 
	//start date
		require_once('functiontime.php');
		
		$createdate = unix_timestamp_to_human($sqlrow['timecreated']);		
		//$currentdate=date('d/m/Y');
		
		$tarikhdaftar=$sqlrow['timecreated'];
		$tarikhakhir=$sqlrow['lasttimecreated'];
		$today = strtotime('now');
		
		//echo $enddate .'<br/>';
		//echo unix_timestamp_to_human($tarikhdaftar).'<br/>';
		//echo unix_timestamp_to_human($tarikhakhir).'<br/>';
		//echo unix_timestamp_to_human($today).'<br/>';
                //echo date('Y-m-d',strtotime($createdate));
		
		if($tarikhdaftar <= $today && $today <= $tarikhakhir) {
			echo'Active'; 
		}else{
			echo'Inactive';
		}
		//echo $tarikhdaftar.'<br/>';

	?>
	</td>
  </tr>
<?php }}else{ ?> 
  <tr>
    <td class="adjacent" colspan="5">No record founds</td>
  </tr>
<?php } ?>
</table>

<div style="margin-top:10px;">
<table align="center"><tr><td>
<?php 
	//paging numbers
	//echo pagination($statement,$limit,$page); 
?>
</td></tr></table>
</div>