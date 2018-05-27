
<?php
	include('../manualdbconfig.php');
	
	$ID=$_GET['id'];
	
	if(trim($ID) == "")
	{
		echo"<center>Cannot remove, try agains.</center>";
		echo"<center><a href='../manage_exam_index.php?categoryedit=off' target='_self'>Back</a></center>";
	}
	else {
		$sql="DELETE FROM mdl_cifa_exam WHERE id='$ID'";
		mysql_query($sql);
	
		#jika berjaya dihapuskan
		header('Location:../manage_exam_index.php?categoryedit=off');
		//echo"<center>Remove 1 records.</center>";
		//echo"<center><a href='../manage_exam_index.php?categoryedit=off' target='_self'>Back</a></center>";
		
	}
?>