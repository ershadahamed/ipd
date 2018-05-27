<style>
<?php 
	include('css/style2.css'); 
	include('css/button.css');
?>
</style>
<?php
include('manualdbconfig.php'); 
if (isloggedin()) {
        add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
?>	
	
<table width="98%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td width="70%" valign="center" >
				<!--table width="100%" border="0" width="100%"><tr><td class="tdclass">Available Courses</td></tr></table--> 
		</td>
		<td width="30%" align="right" valign="center">
			<table width="100%" border="0" width="100%"><tr><td align="right" width="95%">
			<input type="text" name="username" size="50" style="height:18px;">
			</td><td align="right" width="5%">
			<a><img src="image/search.png" width="20px"></a></td></tr></table>
		</td>
	</tr>
	<tr><td colspan="2">
	<?php 	
		if(($USER->id)!='2'){
		include('userfrontpage/page1.php'); 
		include('userfrontpage/frontpage-content.php');
		}else{
			//if administrator
			//index//home
			include('userfrontpage/admin-availablemodules.php');
			include('userfrontpage/usermanagementHome.php');
			//include_once('userfrontpage/useraddcategory.php');
		}
	?>
	</td></tr>
</table>
<?php }else{ 
	//if not loggin
	include('userfrontpage/availablecourse.php'); 
} ?>