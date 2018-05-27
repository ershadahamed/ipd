<style type="text/css">
	.setwidth { width: 50%;}
</style>

<form id="form1" name="form1" method="post" action="">
<h3><?=get_string('emailsettings');?></h3>
  <table width="100%" border="1">
    <tr valign="top">
      <td width="30%"><?=get_string('messagesubject'); ?></td>
      <td width="1%"><strong>:</strong></td>
      <td><input type="text" name="textfield" id="textfield" class="setwidth" /></td>
    </tr>
    <tr valign="top">
      <td><?=get_string('messagecontent'); ?></td>
      <td width="1%"><strong>:</strong></td>
      <td><textarea name="textarea" width="100%" id="textarea" class="setwidth" cols="45" rows="5"></textarea></td>
    </tr>
  </table>
</form>