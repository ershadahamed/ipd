<?php
    include('config.php');
	include('manualdbconfig.php');
	
	$courseid=$rowCourses['courseid'];
	$courseenrolid=$_GET['courseid'];
		
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
		  c.timeend,
		  a.category
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
	
	$sgrade=mysql_query("	
		Select
		  a.course,
		  c.fullname,
		  b.userid
		From
		  mdl_cifaquiz a Inner Join
		  mdl_cifaquiz_grades b On a.id = b.quiz Inner Join
		  mdl_cifacourse c On c.id = a.course
		Where
			b.userid='".$USER->id."' And b.grade <='100' And c.id='".$courseid."'
	");
	$qgrade=mysql_num_rows($sgrade);	
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
	<?php 
    $var=$_POST['extendtraining'];

	if($courseid==$_GET['courseid']){
		echo '<b><font color="green">Extend for 30 days</font></b><br/><br/>';
	}
    ?> 
	
<table id="cifa-table" width="100%" border="0" align="center">
<tr><th><?=$sqldata['fullname'];?></th></tr>
<tr><td>

  <table width="98%" border="0" cellpadding="0" cellspacing="0">
    <!--tr valign="top">
      <td width="23%" align="right"><strong>Title</strong></td>
      <td width="1%"><b>:</b></td>
      <td><?//=$sqldata['fullname'];?></td>
    </tr-->
    <tr valign="top">
      <td width="23%" align="right"><strong>Program Description</strong></td>
      <td width="1%"><b>:</b></td>
      <td><?=trim($sqldata['summary']);?></td>
    </tr>
    <tr valign="top">
      <td align="right"><strong><?=ucwords(strtolower(get_string('subscriptionstart')));?></strong></td>
      <td><b>:</b></td>
      <td><?=date('M d, Y', $sqldisplay['timestart']);?></td>
    </tr>
    <tr valign="top">
      <td align="right"><strong><?=ucwords(strtolower(get_string('subscriptionend')));?></strong></td>
      <td><b>:</b></td>
        <td>
            <?php 
                $signupdate=date('d-m-Y H:i:s', $sqldisplay['timestart']);
				$enddate=strtotime($signupdate . " + 3 month");
				
				$start=$sqldisplay['timestart']; //subscribe start
				$expired=strtotime($signupdate . " + 3 month"); //subscribe end
				//$expired=$sqldisplay['timeend']; //subscribe end
				
				$todaydate=strtotime('now');
				echo date('M d, Y',strtotime($signupdate . " + 3 month"));
            ?>	  
        </td>
    </tr>
  </table></td></tr></table>
  <?php 
	$linklaunch=$CFG->wwwroot.'/course/view.php?id='.$courseid;
	// $linkextend=$CFG->wwwroot.'/coursesindex.php?id='.$USER->id.'&extendid='.$courseid.'&courseid='.$courseid.'&sesskey='.sesskey(); 
	$linkextend=$CFG->wwwroot. '/purchasemodule.php?resitexamid=3&productid='.$courseid.'&command=add';
	
	//to get enrol id
	$s_enrol=mysql_query("SELECT id FROM mdl_cifaenrol WHERE enrol='manual' AND status='0' AND courseid ='".$courseenrolid."'");
	$get_enrol=mysql_fetch_array($s_enrol);
	$course_enrol_id=$get_enrol['id'];
  ?>
  <table border="0">
    <tr>
    	<?php 
			//if course still valid
			if(($todaydate >=$start) && ($todaydate <= $expired)){ 
		?>
      	<td style="padding-left:0px;">
			<input type="submit" name="lauchtraining" onClick="this.form.action='<?=$linklaunch;?>'" value="Launch Training" />
		</td>
      <?php  
			}else{ 
				// if extend courses
				if (isset($var)) { 
					/*  mdl_cifauser_enrolments */
					//extend for 3 months once
					$update_time_start=strtotime(date('M d, Y', $expired));
					$u_timeend=strtotime(date('M d, Y',$expired) . " + 3 month");

					$enrolupdate=mysql_query("
						UPDATE {$CFG->prefix}user_enrolments SET timeend='".$u_timeend."', timestart='".$update_time_start."'
						WHERE status='0' AND userid='".$USER->id."' AND enrolid='".$course_enrol_id."'
					");
					
					//instanceid
					$sexam=mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='".$courseid."'");
					$Le=mysql_fetch_array($sexam);
					$examcontextid=$Le['id'];				
					
					//assigned roled.				
					$sqlassignexam=mysql_query("UPDATE {$CFG->prefix}role_assignments SET timemodified='".$todaydate."' WHERE contextid='".$examcontextid."' AND userid='".$USER->id."'");
									
					//extend detais to statement DB
					$extendcost='50'; //cost for extend
					$descextension='Extension';
					$istatementsql=mysql_query("
					INSERT INTO {$CFG->prefix}statement
					SET 
						candidateid='".$USER->traineeid."',
						subscribedate='".$todaydate."', 
						courseid='".$courseid."', 
						remark='".$descextension."', 
						debit1='".$extendcost."'
					");			
					
					$linkredirect=$CFG->wwwroot. '/courseindex.php?id='.$USER->id;
					// header('Location: http://google.com.my');
					// header('Location: '.$linkredirect);		
					redirect($linkextend);
				}

	  ?>
     
      <td><input name="extendtraining" id="extendtraining" type="submit" onClick="this.form.action='<?=$linkextend;?>'" value="Extend Training" <?php if (isset($var)) { echo 'disabled="disabled"'; } ?> /></td>
	  <?php
			}
			// if($sqldisplay['category']=='3'){ echo $courseid;
		?>
	  <td>
	  <?php
		if($qgrade!=0){ 
			// $linkresit=$CFG->wwwroot. '/purchasemodule.php?id='.$USER->id.'&resitexamid='.$courseid;
			 $linkresit=$CFG->wwwroot. '/purchasemodule.php?resitexamid=4&productid='.$courseid.'&command=add';
			// $linkresit=$CFG->wwwroot. '/portal/subscribe/paydetails_loggeduser_extend.php?resitexamid=3&productid='.$courseid.'&command=add';
			if($sqldisplay['category']=='3'){
		?>
			<input name="resitexam" id="resitexam" type="submit" value="<?=get_string('resitexam');?>" onclick="this.form.action='<?=$linkresit;?>'" />
		<?php }} ?>
	  </td>
	  <?php //} ?>
    </tr>
  </table>
  <br/>
</form>