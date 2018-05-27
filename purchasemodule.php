<?php
	require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('manualdbconfig.php'); 
	include("includes/functions.php");
	
	$site = get_site();
	
	$purchaseprogramview=get_string('buyacifa');
	$title="$SITE->shortname: Courses - ".$purchaseprogramview;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->navbar->add($purchaseprogramview);		
	$PAGE->set_pagelayout('buy_a_cifa');
	echo $OUTPUT->header();	
	
	// redirect if poassword not change
	$rselect=mysql_query("SELECT * FROM {$CFG->prefix}user_preferences WHERE userid='".$USER->id."' AND name='auth_forcepasswordchange' AND value='1'");
	$srows=mysql_num_rows($rselect);
	if($srows!='0'){
		?>
			<script language="javascript">
				window.location.href = '<?=$CFG->wwwroot .'/login/change_password.php';?>'; 
			</script>
		<?php	
	}	

	// redirect if profile not updated
	$rsc=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='".$USER->id."' AND (email='' OR college_edu='' OR highesteducation='' OR yearcomplete_edu='0')");
	$srows2=mysql_num_rows($rsc);
	if($srows2!='0'){
		?>
			<script language="javascript">
				window.location.href = '<?=$CFG->wwwroot .'/user/edit.php?id='.$USER->id.'&course=1';?>'; 
			</script>
		<?php	
	}	
	 
	if($_REQUEST['command']=='add' && $_REQUEST['productid']>0){
		$pid=$_REQUEST['productid'];
		addtocart($pid,1);
	}
?>
<script language="javascript">
	function addtocart(pid){
		document.formcart.productid.value=pid;
		document.formcart.command.value='add';
		document.formcart.submit();
	}
</script>
	<script type="text/javascript">
	setTimeout(onUserInactivity, 1000 * 900)
	function onUserInactivity() {
	   window.location.href = "login/logout.php?sesskey=<?=sesskey();?>"
	   <?php //session_destroy(); ?>
	   alert('<?=get_string('idletime');?>');
	}
	</script>
<?php	
	echo '<style>';
	include('css/style2.css'); 
	echo '</style>';
	echo '
	<form name="formcart">
		<input type="hidden" name="productid" />
		<input type="hidden" name="command" />
	</form>	';
	
	if (isloggedin()) {
		echo '<div style="min-height: 300px;">';
		include('userfrontpage/availablecourse.php');
		echo '</div>';
	}	
	echo $OUTPUT->footer();	
?>