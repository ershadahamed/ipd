<?php
	include('manualdbconfig.php');
?>
<form action="" method="post">
	<div style="padding:20px 20px 0px 20px; float: left; width:100%;">
	
	<table id="availablecourse2" width="96%">
		<tr class="yellow">
			<th class="adjacent" width="1%">No.</th>
			<th class="adjacent" width="8%" style="text-align:center;">Centre code</th>
			<th class="adjacent" width="20%">Centre name</th>
			<th class="adjacent" style="text-align:left;">Street address</th>
			<th class="adjacent" width="12%" style="text-align:left;">Centre coordinator</th>
			<th class="adjacent" width="13%" style="text-align:center;">Telephone</th>
			<th class="adjacent" width="10%" style="text-align:left;">Email</th>
			<th class="adjacent" width="1%">#</th>
			<th class="adjacent" width="1%">#</th>
		</tr>
	<?php
		$sqlCheck1="Select
  						*
					From
  						mdl_cifa_exam
					Order by
						id DESC";
		$queryCheck1=mysql_query($sqlCheck1);	
		$rowCheck1=mysql_fetch_array($queryCheck1);
		if($rowCheck1['id'] >= '1'){
		
		$sqlCheck="Select
  						*
					From
  						mdl_cifa_exam
					Order by
						id DESC";
		$queryCheck=mysql_query($sqlCheck);
		$no="0";
		while($rowCheck=mysql_fetch_array($queryCheck)){
		$no++;
		
		$sqlcountry=mysql_query("SELECT * FROM mdl_cifacountry_list WHERE countrycode='".$rowCheck['country']."'");
		$rsCountry=mysql_fetch_array($sqlcountry);
	?>	
		<tr>
			<td class="adjacent" ><?php echo $no; ?></td>
			<td class="adjacent" ><?php echo $rowCheck['centre_code']; ?></td>
			<td class="adjacent" style="text-align:left;"><?php echo $rowCheck['centre_name']; ?></td>
			<td class="adjacent" style="text-align:left;"><?php echo $rowCheck['address'].' '.$rowCheck['address2'].', '.$rowCheck['city'].', '; 
				if($rowCheck['country']==$rsCountry['countrycode']){echo $rsCountry['countryname'];} ?>
			</td>
			<td class="adjacent" ><?php echo $rowCheck['license']; ?></td>
			<td class="adjacent" ><?php echo $rowCheck['phone']; ?></td>
			<td class="adjacent" ><?php echo $rowCheck['email']; ?></td>
			<td align="center" class="adjacent" >
				<a href="editCentre_index.php?id=<?php echo $rowCheck['id']; ?>"><img src="<?php echo $CFG->wwwroot. '/image/edit.png'; ?>" width="15" border="0" title="Edit center"></a>
			</td><td align="center" class="adjacent">
			<a href="manageExam/removeCentre.php?id=<?php echo $rowCheck['id']; ?>" onClick="javascript:return confirm('Are you really want to remove this?\nExam Centre - <?=ucwords(strtoupper($rowCheck['centre_name']))?>')">
			<img src="<?php echo $CFG->wwwroot. '/image/delete2.png'; ?>" width="15" border="0" title="Remove center"></a>
			</td>
		</tr>
		<?php }
		}else{
		?>
			<tr><td colspan="9" class="adjacent" >No data found</td></tr>
		<?php
		}
		?>
		</table>	</div>

<div class="buttons" style="float:right; padding-bottom:10px; padding-right:10px;">
    <!--button type="submit" class="positive" name="submit">
        <img src="manageExam/Images/apply2.png" alt=""/>
        Add New Centre
    </button-->
    <a href="<?php echo $CFG->wwwroot. '/manageExam/addnewcenter.php'; ?>" class="positive" title="Add New Centre">
        <img src="<?php echo $CFG->wwwroot. '/manageExam/Images/apply2.png';?>" alt=""/>
        Add New Centre
    </a>    
	
</div>	


</form>