<?php
    require_once('../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php'); 

	$site = get_site();

	$viewresult=get_string('mocktest');
	$title="$SITE->shortname: ".$viewresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	$urlmocktest = new moodle_url('/course/mock_exam.php', array('id'=>$USER->id)); //added by arizan	
	$urlmytraining = new moodle_url('/coursesindex.php', array('id'=>$USER->id)); //added by arizan http://202.157.188.250/shapeipd/coursesindex.php?id=134	
	$PAGE->navbar->add(get_string('mytraining'), $urlmytraining)->add(get_string('mocktest'), $urlmocktest);
		
	echo $OUTPUT->header();		
	if (isloggedin()) {
		add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
				
		//echo $OUTPUT->heading($viewresult, 2, 'headingblock header');
		
		$id=$_GET['id'];
		
	?>	
	<style>
	<?php 
		include('../css/style2.css'); 
		include('../css/button.css');
		include('../css/pagination.css');
		include('../css/grey.css');
	?>
	</style>    
	<style>
	a:hover {text-decoration:underline;}
	</style>	
		<div style="min-height: 305px;">	
        <h2><?=get_string('mocktest');?></h2>
		<form id="form1" name="form1" method="post" action="">			
		<?php
			// search enrollment test
			/* $selectnew=mysql_query("
				Select
				  *
				From
				  mdl_cifacourse a Inner Join
				  mdl_cifaenrol b On a.id = b.courseid Inner Join
				  mdl_cifauser_enrolments c On b.id = c.enrolid
				Where
				  c.userid = '".$USER->id."' And
				  a.visible = '1' And
				  a.category = '9'	
			"); */

		$selectnew=mysql_query("			
		Select
		  a.category,
		  a.fullname,
		  b.course,
		  b.instance,
		  c.id,
		  c.name,
		  c.course As course1,
		  e.userid,
		  b.id As id1
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifacourse_modules b On a.id = b.course Inner Join
		  mdl_cifaquiz c On b.course = c.course And b.instance = c.id Inner Join
		  mdl_cifaenrol d On c.course = d.courseid Inner Join
		  mdl_cifauser_enrolments e On d.id = e.enrolid
		Where
		  a.category = '9' And a.visible = '1' And e.userid='".$USER->id."'");		
			
			$bil='1';
		
?>			
			
        <table id="availablecourse" style="margin-bottom:1em;">
			<tr class="yellow">
				<th class="adjacent" width="1%">No</th>
                <th class="adjacent"><?=get_string('examinationtitle');?></th>
                <th class="adjacent" width="20%" style="text-align:center"><?=get_string('demo');?></th>
            </tr>
			<?php
			while($serow=mysql_fetch_array($selectnew))
			{				
				// echo $serow['courseid'];
				/* $m_sc=mysql_query("						
					Select
					  *,
					  x.id As id1,
					  z.courseid,
					  y.name As name1
					From
					  mdl_cifacourse_modules x Inner Join
					  mdl_cifaquiz y On x.course = y.course And x.instance = y.id Inner Join
					  mdl_cifaenrol z On y.course = z.courseid Inner Join
					  mdl_cifauser_enrolments a On z.id = a.enrolid Inner Join
					  mdl_cifacourse_modules b On x.course = b.course
					Where
					  a.userid = '".$USER->id."' And
					  y.course = '".$serow['courseid']."' And b.module = '13'					
				"); */	

				/* $m_sc=mysql_query("						
					Select
					  *,
					  x.id As id1,
					  z.courseid,
					  y.name As name1
					From
					  mdl_cifacourse_modules x Inner Join
					  mdl_cifaquiz y On x.course = y.course And x.instance = y.id Inner Join
					  mdl_cifaenrol z On y.course = z.courseid Inner Join
					  mdl_cifauser_enrolments a On z.id = a.enrolid
					Where
					  a.userid = '".$serow['userid']."' And
					  y.course = '".$serow['courseid']."' And x.module = '13'					
				");	
				
				$c=mysql_num_rows($m_sc);
				//if($c=='1'){
				$m_rws=mysql_fetch_array($m_sc); */
				
				$link_to_mock=$CFG->wwwroot.'/mod/quiz/view.php?id='.$serow['id1'];
				$m_link_open="<a href='".$link_to_mock."' title='Click to start ".$serow['name']."'>";
				$link_close="</a>"; 
				
				$sview=mysql_query("
					Select
					  a.category,
					  a.fullname,
					  c.userid, a.idnumber
					From
					  mdl_cifacourse a Inner Join
					  mdl_cifaenrol b On a.id = b.courseid Inner Join
					  mdl_cifauser_enrolments c On b.id = c.enrolid
					Where
					  a.category = '1' AND c.userid='".$USER->id."'	And a.fullname='".$serow['name']."'	
				");
				$slistnums=mysql_num_rows($sview);
				if($slistnums!='0'){
				?>
                <tr>
                    <td class="adjacent" align="center"><?=$bil++;?></td>
                    <td class="adjacent" style="text-align:left;"><?=$serow['name'];?></td>
                    <td class="adjacent" style="text-align:center;">
					<?php
						/* $sqlattempts=mysql_query("
							Select
							  a.attempts,
							  b.userid,
							  a.name,
							  b.quiz,
							  b.attempt
							From
							  mdl_cifaquiz a Inner Join
							  mdl_cifaquiz_attempts b On a.id = b.quiz
							Where
							  a.course = '".$serow['courseid']."' AND b.userid = '".$serow['userid']."'					
						");
						$cattempts=mysql_num_rows($sqlattempts);
						if($m_rws['attempts']==$cattempts){
							echo 'Limited to attempt';
						}else{ */
					?>
                    <input id="id_actionbutton" type="submit" name="back" onClick="this.form.action='<?=$link_to_mock;?>'" value="<?=get_string('startdemo');?>" />
					<?php //} ?>
					</td>
               </tr> 				
				<?php
			}}
			
			if($bil=='1'){
			?>            
            <tr>
			<td colspan="3" class="adjacent" ><?=get_string('norecords');?></td>
			</tr> 
			<?php } ?>
        </table>
		<div style="padding:2px;text-align:center;"><center>			
		<input id="id_defaultbutton" type="submit" name="back" onClick="this.form.action='<?=$CFG->wwwroot. '/index.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" />
		</center></div>		
		</form>
		</div>
	<?php }	?>
<?php echo $OUTPUT->footer(); ?>