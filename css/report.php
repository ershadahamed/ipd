<?php
	include('config.php');
	include('manualdbconfig.php');
	echo '<style type="text/css">';
	include('css/style2.css');
	include('css/style.css');
	echo '</style>';
    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = 'List of puchasing module';
    $PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	
    echo $OUTPUT->header();
    echo $OUTPUT->heading('List of puchasing module', 2, 'headingblock header');
	$select=mysql_query("SELECT id, fullname, timecreated FROM mdl_cifacourse WHERE category='1'");
?>

<table width="98%"><tr><td>
<form name="form1" method="post">
<table>
	<tr><td>Module</td><td>:</td><td>
		<select name="module">
			<option value=""></option>
			<?php while($ss=mysql_fetch_array($select)){ ?>
			<option value="<?=$ss['id'];?>"><?=$ss['id'].'-'.$ss['fullname'];?></option>
			<?php } ?>
		</select></td>
	</tr>
	<tr><td>View status</td><td>:</td>
		<td>
		<select name="status" onChange="document.form1.submit()">
			<option value=""></option>
			<option value="Paid">Completed</option>
			<option value="New">Cancelled</option>
		</select>
		</td>
	</tr>
</table>
</form>
<?php
$courseid=$_POST['module'];
$payment_status=$_POST['status'];

if($courseid == ''){ echo 'Please select module..';}

$statement="SELECT * FROM mdl_cifa_modulesubscribe";
if($payment_status !=''){$statement.=" WHERE courseid='".$courseid."' AND payment_status='".$payment_status."'";}
//$sel=mysql_query("SELECT * FROM mdl_cifa_modulesubscribe WHERE courseid='".$_POST['module']."' AND payment_status='".$_POST['status']."'");
$sel=mysql_query($statement);
?>
<table id="avalaiblecourse" style="margin:0 auto;" border="1" width="98%">
<tr>
	<th width="1%">No.</th>
	<th style="text-align:left;" width="20%">Invoice no.</th>
	<th style="text-align:left;" width="25%">Buyer name</th>
	<th style="text-align:left;" width="25%">Module name</th>	
	<th width="14%">Cost</th>
	<th width="15%">Status</th>	
</tr>
<?php
$s=mysql_num_rows($sel);
echo $s;
if($s != '0'){
$bil='0';
while($sq=mysql_fetch_array($sel)){
$bil++;
?>
<tr>
	<td><?=$bil;?></td>
	<td><?=$sq['invoiceno'];?></td>
	<td><?=$sq['firstname'].' '.$sq['lastname'];?></td>
	<td>
	<?php
		$course=mysql_query("SELECT fullname FROM mdl_cifacourse WHERE id='".$sq['courseid']."'");
		$cs=mysql_fetch_array($course);
		
		echo $cs['fullname'];
	?>
	</td>
	<td style="text-align:center;"><?=$sq['cost'];?></td>
	<td style="text-align:center;"><?=$sq['payment_status'];?></td>	
</tr>
<?php	
}}else{ echo '<tr><td colspan="6">No records found.</td></tr>';}
?>
</table>
</td></tr></table>
<?php echo $OUTPUT->footer(); ?>