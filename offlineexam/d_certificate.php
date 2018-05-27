<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	include_once ('../pagingfunction.php');
	
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	
	
	$date = $_POST["date"];
	$id = $_POST["id"];
	$line1 = $_POST["line1"];
	$line2 = $_POST["line2"];
	$line3 = $_POST["line3"];
	
	$trainer = "SELECT * FROM mdl_cifauser WHERE traineeid = '".$id."'";
	$cidosexam1 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'A'";
	$cidosexam2 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'B'";
	$cidosexam3 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'C'";

	$query = mysql_query($trainer);
	$data = mysql_fetch_array($query);

	$exam1 = mysql_query($cidosexam1);
	$exam2 = mysql_query($cidosexam2);
	$exam3 = mysql_query($cidosexam3);

	$a = mysql_fetch_array($exam1);
	$b = mysql_fetch_array($exam2);
	$c = mysql_fetch_array($exam3);
?>
<script type="text/javascript" >
function varitext(text){
text=document
print(text);
} 
</script>
<style type="text/css">
@media print {
input#btnPrint {
display: none;
}
}
</style>

<form method="post">
<table border="0" width="100%">
<tr>
<td colspan="2"><img src="img/SHAPE2.jpg" width="30%"></td>
</tr>
<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><br>
<?php
echo ucfirst($data['firstname']).' '.ucfirst($data['lastname']);
if($data['address'] !=''){
	echo "<br/>".ucfirst($data['address']);
}
echo "<br/>".ucfirst($data['city'])."<br>";
echo ucfirst($data['country'])."<br><br>";
?>

<?php
echo "Dear "; 
echo ucfirst($data['firstname']);
?>

<br>

<p>This Letter represent confirmation of your examination result by SHAPE&#x2122; Financial Corporation.</p>
<p><b><?php echo $line1 ?></b></p>

&nbsp;&nbsp;&nbsp;
A		<?php echo $a['marks'];?>% and above<br>
&nbsp;&nbsp;&nbsp;
B		<?php echo $b['marks'];?>-<?php echo $d = $a['marks']-1; ?>%<br>
&nbsp;&nbsp;&nbsp;
C		<?php echo $c['marks'];?>-<?php echo $d = $b['marks']-1; ?>%<br>
&nbsp;&nbsp;&nbsp;
Did Not Pass	<?php echo $c = $c['marks']-1; ?>% and below

<br>

<p><?php echo $line2 ?></p>
<p><?php echo $line3 ?></p>
<br><br>
Sincerely,
<br><br><br>
<p><b>Abdulkader Thomas</b></p>
CEO
<br><br>
</td>
<tr>
<td>

</td>
</tr>
</table>

<div style="text-align:center;">
			<input type="button" id="btnPrint" onclick="window.print();" value="Print Page" />
</div><br/>
</form>