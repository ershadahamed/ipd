<?php
/*     require_once('../config.php');
    require_once('../manualdbconfig.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');

	$site = get_site();	
	
	$title="$SITE->shortname: Courses";
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
    //$PAGE->set_pagelayout('courses');
	
	echo $OUTPUT->header(); */
	$courseid=$rowCourses['courseid'];
		
	$choose=mysql_query("
		Select
		  a.fullname,
		  b.courseid,
		  c.enrolid,
		  d.firstname,
		  d.lastname,
		  c.userid,
		  c.timecreated,
		  c.timestart,
		  c.timeend
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifaenrol b On a.id = b.courseid Inner Join
		  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
		  mdl_cifauser d On c.userid = d.id
		Where
		  b.courseid ='".$courseid."' And
		  c.userid = '".$USER->id."'	
	");	
	$sqldisplay=mysql_fetch_array($choose);
	
	$querycourse=mysql_query("SELECT * FROM mdl_cifacourse WHERE id='".$courseid."'");
	$sqldata=mysql_fetch_array($querycourse);
	?>
<script type="text/javascript" src="../scripts/jquery-1.3.2.min.js"></script>
<style>
fieldset { 
	border:2px solid #5DCBEB;	
	width: 96%; 
	margin-left: auto;
	margin-right: auto;
	margin-bottom: 10px;
	padding: 1em 1em 0em;
	border-top-left-radius: 5px 5px;
	border-top-right-radius: 5px 5px;
}
</style>	
<form id="form1" name="form1" method="post" action="">

<table width="80%" border="0" align="center"><tr><td>
	<?php 
    $var=$_POST['extendtraining'];
    if (isset($var)) { 
        echo '<b><font color="green">Extend for 30 days</font></b><br/><br/>';
	?>
	<script type="text/javascript">
	$('#extendtraining').click(function() {
		location.reload();
	});	
	</script>
	<?php
    }
    ?> 
<fieldset id="fieldset">
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
      <td><?=trim($sqldata['summary']);?></td>
    </tr>
    <tr valign="top">
      <td align="right"><strong><?=get_string('subscriptionstart');?></strong></td>
      <td><b>:</b></td>
      <td><?=date('M d, Y', $sqldisplay['timestart']);?></td>
    </tr>
    <tr valign="top">
      <td align="right"><strong><?=get_string('subscriptionend');?></strong></td>
      <td><b>:</b></td>
        <td>
            <?php 
                $signupdate=date('d-m-Y H:i:s', $sqldisplay['timestart']);
				$enddate=strtotime($signupdate . " + 3 month");
				
				$start=$sqldisplay['timestart'];
				//$expired=strtotime($signupdate . " + 3 month").'<br/>';
				$expired=strtotime($signupdate . " + 3 month");
				$todaydate=strtotime('now');
				echo date('M d, Y',strtotime($signupdate . " + 3 month")); 
				
				//echo date('M d, Y',$start).' <= '.date('M d, Y',$todaydate).' <= '.date('M d, Y',$expired);
            ?>	  
        </td>
    </tr>
  </table></td></tr></table></fieldset>
  <?php 
	$linklaunch=$CFG->wwwroot.'/course/view.php?id='.$_GET['id']; 
	$linkextend=$CFG->wwwroot.'/course/coursedetails.php?id='.$_GET['id']; 
	
	//to get enrol id
	$s_enrol=mysql_query("SELECT id FROM mdl_cifaenrol WHERE enrol='manual' AND status='0' AND courseid ='".$courseid."'");
	$get_enrol=mysql_fetch_array($s_enrol);
	$course_enrol_id=$get_enrol['id'];
  ?>
  <table border="0">
    <tr>
		<td><input type="submit" name="lauchtraining" onClick="this.form.action='<?=$linklaunch;?>'" value="Launch Training" /></td>
    	<?php if(($todaydate >=$start) && ($todaydate <= $expired)){ ?>
      	<td><input type="submit" name="lauchtraining" onClick="this.form.action='<?=$linklaunch;?>'" value="Launch Training" /></td>
      <?php
	  	}else{ 
			//$var=$_POST['extendtraining'];
			if (isset($var)) { 
				/*  mdl_cifauser_enrolments */
				//extend for 3 months once
				$update_time_start=strtotime(date('M d, Y',strtotime($signupdate . " + 3 month")) . " + 3 month");
				$u_timeend=strtotime(date('M d, Y',$update_time_start) . " + 3 month");
				//$update_enddate=date('M d, Y',strtotime($u_timestart . " + 3 month"));
				//echo $u_timeend.'---->'.$update_time_start;
				$enrolupdate=mysql_query("
					UPDATE mdl_cifauser_enrolments SET timeend='".$u_timeend."', timestart='".$update_time_start."'
					WHERE status='0' AND userid='".$USER->id."' AND enrolid='".$course_enrol_id."'
				");
			}
	  ?>
      <td><input name="extendtraining" id="extendtraining" type="submit" onClick="this.form.action='<?=$linkextend;?>'" value="Extend Training" id="extendtraining" <?php if (isset($var)) { echo 'disabled="disabled"';}?> /></td>
	  <?php } ?>
    </tr>
  </table></td></tr></table>
  <br/>
</form>
<?php		
	/* echo $OUTPUT->footer(); */
?>