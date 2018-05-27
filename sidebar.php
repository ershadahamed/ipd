<?php
if (isloggedin()) {
        add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
?>	
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td align="right">
	<a><img src="image/Save.png"></a>&nbsp;
	<a><img src="image/Profile.png"></a>&nbsp;
	<a><img src="image/Info.png"></a>&nbsp;
</td></tr>
</table>
<?php }//else{ ?>
<!--fieldset><legend>
<?php //echo 'Latest news'; } ?>	</legend></fieldset-->