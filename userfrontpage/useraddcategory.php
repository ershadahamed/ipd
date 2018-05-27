
<?php
	require_once('../config.php');
	require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	$sitecontext = get_context_instance(CONTEXT_SYSTEM);
	$site = get_site();
	
	$usercategory = get_string('usercategory');
	$title="$SITE->shortname: $usercategory";
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('admin');

	echo $OUTPUT->header();
?>
<script type="text/javascript">
function submitform()
{

/*elem1 = document.getElementById('categorycode');
elem2 = document.getElementById('categoryname');

categorycode = 'Sila nyatakan kehadiran';
categoryname = 'Sila cadangkan calon ganti';
		
		if(elem1.value.length==0){
			elem1.focus();
			alert(categorycode);
			return false;
		}
		
		if(elem2.value.length==0){
			elem2.focus();
			alert(categoryname);
			return false;
		}*/
		
		/*document.form.submit();
		return true;*/


    document.forms["myform"].submit();
}
</script>
<div class="course-content">
<form id="myform" method="post" action="<?php echo $CFG->wwwroot.'/userfrontpage/addcategoriexe.php';?>" onSubmit="return valCari(this);">
<?php 
	$strmymoodle='Manage category/user';
	echo $OUTPUT->heading($strmymoodle, 2, 'headingblock header');
?>
<fieldset id="fieldset"><legend id="legend" style="width:130px;">Add category</legend>
<table id="avalaiblecourse" border="0">
<tr><td>Category code</td><td>:</td><td><input type="text" name="categorycode" id="categorycode" size="40"></td></tr>
<tr><td>Category name</td><td>:</td><td><input type="text" name="categoryname" id="categoryname" size="40"></td></tr>
</table>
<table>
<tr>
<td><input type="submit" name="add" value="Add category"></td>
<td><input type="reset" name="cancel" value="Cancel"></td>
</tr>
</table>
</fieldset>
</form>

	<script language="JavaScript" type="text/javascript">
	//You should create the validator only after the definition of the HTML form
	function valCari(form)
	{
		var VAL = true;		
		var categorycode = form.categorycode.value;
		var categoryname = form.categoryname.value;
	 
		if(!categorycode)
		{
			VAL = false;
			alert("Please enter categorycode");
			form.categorycode.focus();
			return false;
		}
		
		else if(!categoryname)
		{
			VAL = false;
			alert("Please enter categoryname");
			form.categoryname.focus();
			return false;
		}
	}
	</script>
<style type="text/css">
	#avalaiblecourse th{background-color: #aaa; }
</style>	
<fieldset id="fieldset"><legend id="legend" style="width:130px;">List of user category</legend>
<table id="avalaiblecourse" border="1" style="border-collapse: collapse; background-color: #fff;">
<tr>
	<th width="1%">Num.</th>
	<th>Category code</th>
	<th>Category name</th>
	<th width="2%">#</th>
	<th width="2%">#</th>
</tr>
<?php
	include('../manualdbconfig.php');
	$sql=mysql_query("Select * From mdl_cifauser_category");
	$bil='0';
	while($queryS=mysql_fetch_array($sql)){
	$bil++;
?>
<tr>
	<td align="center"><?php echo $bil;?></td>
	<td><?php echo $queryS['categorycode']; ?></td>
	<td><?php echo $queryS['categoryname']; ?></td>
    <td><a href="<?php echo $CFG->wwwroot.'/userfrontpage/editusercategory.php?id=';?><?php echo $queryS['id']; ?>">
		<img src="<?php echo $CFG->wwwroot.'/theme/afterburner/pix_core/t/edit.png'; ?>"></a></td>
    <td><a href="<?php echo $CFG->wwwroot.'/userfrontpage/deleteusercategory.php?id=';?><?php echo $queryS['id']; ?>">
		<img src="<?php echo $CFG->wwwroot.'/theme/afterburner/pix_core/t/delete.png'; ?>"></a></td>	
</tr>
<?php } ?>
</table>
</fieldset>

<br/>
<div align="center">
<INPUT TYPE="BUTTON" VALUE="Go Back" ONCLICK="history.go(-1)">
</div>
<br/></div>
<?php
echo $OUTPUT->footer();