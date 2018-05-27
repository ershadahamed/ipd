
<table border="1">
<tr>
	<td>Firstname</td>
	<td>Org ID</td>
</tr>
<?php 
mysql_connect('localhost','root','E9z0YmGGfXO1');
echo $qry1 = "SELECT candidate_id, orgtype FROM shapedblms.tempadib";
$sql1 = mysql_query($qry1);
while($rs1 = mysql_fetch_array($sql1)){
$qry2 = "SELECT firstname, orgtype FROM shapedblms.mdl_cifauser WHERE username = '".$rs1['candidate_id']."'";
$sql2 = mysql_query($qry2);
$rs2 = mysql_fetch_array($sql2);

?>
<tr>
	<td><?php echo $rs2['firstname'];?></td>
	<td><?php echo $rs2['orgtype'];?></td>
</tr>

<?php } ?>
</table>
