<?php
	$querycourse=mysql_query("SELECT * FROM mdl_cifacourse WHERE id='".$rowCourses['courseid']."'");
	$sqldata=mysql_fetch_array($querycourse);
?>
<form id="form1" name="form1" method="post" action="">
<table width="80%" border="0" align="center"><tr><td>
<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"><tr>
  <td>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td width="34%" align="right"><strong>Title</strong></td>
      <td width="1%"><b>:</b></td>
      <td width="65%"><?=$sqldata['fullname'];?></td>
    </tr>
    <tr valign="top">
      <td align="right"><strong>Program Description</strong></td>
      <td><b>:</b></td>
      <td><?=$sqldata['summary'];?></td>
    </tr>
    <tr valign="top">
      <td align="right"><strong>Sign Up Date</strong></td>
      <td><b>:</b></td>
      <td><?=date('M d, Y',$sqldata['timecreated']);?></td>
    </tr>
    <tr valign="top">
      <td align="right"><strong>Valid Until</strong></td>
      <td><b>:</b></td>
      <td>
			<?php 
				$signupdate=date('d-m-Y H:i:s', $sqldata['timecreated']);
				echo date('M d, Y',strtotime($signupdate . " + 3 month")); 
			?>
	</td>
    </tr>
  </table></td></tr></table></fieldset>
  <?php $linklaunch=$CFG->wwwroot.'/course/view.php?id='.$rowCourses['courseid']; ?>
  <table border="0">
    <tr>
      <td><input type="submit" name="lauchtraining" onClick="this.form.action='<?=$linklaunch;?>'" value="Lauch Training" /></td>
      <td>&nbsp;</td><td><input name="extendtraining" type="submit" value="Extend Training" id="extendtraining" /></td>
    </tr>
  </table></td></tr></table>
  <br/>
</form>