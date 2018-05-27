<?php
    require_once('../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php'); 

	$id=$_GET['id'];
	$sel=mysql_query("SELECT * FROM mdl_cifauser WHERE id='".$id."'");
	$q=mysql_fetch_array($sel);	
	
	$get_userrole=mysql_query("SELECT roleid FROM {$CFG->prefix}role_assignments WHERE userid='".$USER->id."' AND contextid='1'");
	$guserrole=mysql_fetch_array($get_userrole);
	$userrole=mysql_num_rows($get_userrole);
	$uroleid=$guserrole['roleid'];

	$site = get_site();
	$getnav=$_GET['nav'];
	$userfullname=ucwords(strtolower($q['firstname'].' '.$q['lastname']));
	$fullusername=$userfullname.' ('.strtoupper($q['traineeid']).')';
	
	$viewresult=get_string('viewresult');
	$title="$SITE->shortname: ".$viewresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$vresult_link=$CFG->wwwroot. '/userfrontpage/examresult_ECadmin.php?id='.$USER->id;
	$clink=$CFG->wwwroot. '/offlineexam/multi_token_download.php?id='.$USER->id;
	
	if($USER->id !='2'){
		$PAGE->navbar->add($getnav, $vresult_link)->add($viewresult, $vresult_link)->add($fullusername, $clink);
	}
	
	if($uroleid!='5'){
		$PAGE->set_pagelayout('buy_a_cifa');
	}
	
	if($USER->id =='2'){
		$PAGE->navbar->add($getnav, $vresult_link)->add($viewresult, $vresult_link)->add($fullusername, $clink);
		$PAGE->set_pagelayout('buy_a_cifa');
	}
	
	echo $OUTPUT->header();		
	if (isloggedin()) {
		add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
		echo $OUTPUT->heading($viewresult, 2, 'headingblock header');
		
		
	?>
	<style>
	<?php 
		include('../css/style2.css'); 
		include('../css/button.css');
		include('../css/pagination.css');
		include('../css/grey.css');
	?>
	</style>	
		<div style="min-height: 400px;">
		<form id="form1" name="form1" method="post" action="">
		<table id="availablecourse2">
			<tr>
				<td><?=get_string('candidatename');?></td>
				<td><strong>:</strong></td>
				<td><?=ucwords(strtolower($q['firstname'].' '.$q['lastname']));?></td>
			</tr>
			<tr>
				<td><?=get_string('candidateid');?></td>
				<td><strong>:</strong></td>
				<td><?=ucwords(strtoupper($q['traineeid']));?></td>
			</tr>			
		</table>
		
		<table id="availablecourse">
			<tr class="yellow">
				<th class="adjacent" width="1%">No</th>
				<th class="adjacent" width="39%" style="text-align:left;"><strong><?=get_string('examinationtitle');?></strong></th>
				<th class="adjacent" width="18%" style="text-align:center;"><strong><?=get_string('timestart');?></strong></th>
				<th class="adjacent" width="18%" style="text-align:center;"><strong><?=get_string('timefinish');?></strong></th>
				<th class="adjacent" width="18%" style="text-align:center;"><?=get_string('marks');?></th>	
                <?php if($USER->id == '2'){ ?>
				<th class="adjacent" width="6%" style="text-align:center;"><?=get_string('misc.');?></th>
                <?php } ?>				
				<th class="adjacent" width="6%" style="text-align:center;"><?=get_string('cert.');?></th>
			</tr>	
			<?php
				/* $sgrade=mysql_query("
					SELECT *, a.grade as usergrade, a.id as quizid 
					FROM mdl_cifaquiz_grades a, mdl_cifaquiz b 
					WHERE a.quiz=b.id AND a.userid='".$q['id']."'
				"); */
				$sgrade=mysql_query("					
					SELECT *, a.name As quizname, c.grade as usergrade, c.id as quizid, a.id as cifaquizid FROM
					  mdl_cifaquiz a Inner Join
					  mdl_cifaquiz_attempts b On a.id = b.quiz Inner Join
					  mdl_cifaquiz_grades c On b.quiz = c.quiz AND b.userid = c.userid Inner Join
					  mdl_cifacourse d On a.course = d.id
					WHERE d.visible != '0' And b.userid='".$q['id']."' And d.category='3'
				");				
				$bil=1;
				$c=mysql_num_rows($sgrade);
				while($qgrade=mysql_fetch_array($sgrade)){
				//mmn add 10022016
				$qryge = "SELECT a.orgtype FROM mdl_cifauser a, mdl_cifaorganization_type b
					 where a.id='".$q['id']."' AND a.orgtype=b.id AND b.name LIKE '%ADIB%'";
				$sqlge = mysql_query($qryge);
				$rsge = mysql_fetch_array($sqlge);
				$rowge = mysql_num_rows($sqlge);
				
				$qryed = "SELECT * FROM mdl_cifaquiz_grades WHERE id='".$qgrade['quizid']."' AND quiz='26' AND userid='".$q['id']."' AND timemodified>'1455494400'";
				$sqled = mysql_query($qryed);
				$rsed = mysql_fetch_array($sqled);
				$rowed = mysql_num_rows($sqled);
				if($rowed>0){
					if($rowge>0){
						$passingmarkshape = 75;
					}else{
						$passingmarkshape = 60;
					}
				}else{
					$passingmarkshape = 60;
				}
				//mmn end
				$no=$bil++;
			?>
			<tr>
				<td class="adjacent" align="center"><?=$no;?></td>
				<td class="adjacent" style="text-align:left;">
				<?php 
					echo ucwords(strtolower($qgrade['name']));
				?>
				</td>
				<td class="adjacent" align="center">
				<?php
					// $sque=mysql_query("SELECT timestart, timefinish FROM mdl_cifaquiz_attempts WHERE userid='".$q['id']."' AND quiz='".$qgrade['id']."'");
					// $query=mysql_fetch_array($sque);
					
					echo date('d-m-Y H:i:s',$qgrade['timestart']).'<br/>';
				?>
				</td>
				<td class="adjacent" align="center"><?php echo date('d-m-Y H:i:s',$qgrade['timefinish']);?></td>
				
				<?php 
				$sel=mysql_query("SELECT * FROM mdl_cifagrade_items WHERE itemtype='mod' AND itemmodule='quiz' AND courseid='".$qgrade['course']."'");
				$selq=mysql_fetch_array($sel);
				//echo $selq['itemname'].'->'.$selq['id'].'<br/>';
				
				$sel2=mysql_query("SELECT * FROM mdl_cifagrade_items WHERE itemtype='course' AND courseid='".$qgrade['course']."'");
				$selq2=mysql_fetch_array($sel2);
				//echo $selq2['id'].'<br/>'; 
				
				// count attempts
				$sqlattempts=mysql_query("
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
							  a.id='".$qgrade['cifaquizid']."'  AND a.course = '".$qgrade['course']."' AND b.userid = '".$q['id']."'					
						");
				$cattempts=mysql_num_rows($sqlattempts);
				
				//total question
				$sqlquestion=mysql_query("
					Select
					  *
					From
					  mdl_cifaquiz_attempts a Inner Join
					  mdl_cifaquestion_usages b On a.uniqueid = b.id Inner Join
					  mdl_cifaquestion_attempts c On b.id = c.questionusageid		
					Where
						a.uniqueid='".$qgrade['uniqueid']."' AND c.behaviour!='informationitem'
				");
				$questionattempts=mysql_num_rows($sqlquestion);	
				
				//marks here
				// echo round((float)(($qgrade['sumgrades'] / $questionattempts)*100));
				$totalmarks_test=round((($qgrade['sumgrades'] / $questionattempts)*100));
				
				if($qgrade['attempt']!=$cattempts){  //attempt limit.
				?>
				<td class="adjacent" align="center">
				<?php
					//marks here
					echo $totalmarks_test;
				?>
				</td>
				<!-- coding asal td class="adjacent" align="center" colspan="2"><?php //echo get_string('noresults');?></td-->
				<?php if($totalmarks_test < $passingmarkshape){?>
				<td class="adjacent" align="center" colspan="2"><?php echo get_string('failtest');?></td>
				<?php
				}}else{
				?>
				<td class="adjacent" align="center">
				<?php
					if($_POST['updateresult']){	
						$examid=$_GET['examid'];
						if($examid == $qgrade['id']){
							echo '<input type="text" style="text-align:center; background-color:lightyellow;" name="updategrade" value="'.round($qgrade['usergrade']).'"/>';
						}else{
							//echo $qgrade['usergrade'];
							echo round($qgrade['usergrade']);
						}
					}
					else if($_POST['saveresult']){ 
						$userid2=$_GET['id'];
						$examid=$_GET['examid'];	
						$updategrade=$_POST['updategrade'];
						$itemid=$_GET['itemid'];
						
						if($itemid == $selq['id']){
						$up=mysql_query("UPDATE mdl_cifagrade_grades SET rawgrade='".$updategrade."', finalgrade='".$updategrade."' WHERE userid='".$userid2."' AND itemid='".$selq['id']."'");
						$up2=mysql_query("UPDATE mdl_cifagrade_grades SET finalgrade='".$updategrade."' WHERE userid='".$userid2."' AND itemid='".$selq2['id']."'");
						}
						$upresult=mysql_query("UPDATE mdl_cifaquiz_grades SET grade='".$updategrade."' WHERE userid='".$userid2."' AND quiz='".$examid."'");
					
						//select an update grade
						$sresult=mysql_query("SELECT * FROM mdl_cifaquiz_grades WHERE userid='".$userid2."' AND quiz='".$examid."'");
						$sre=mysql_fetch_array($sresult);
						if($examid == $qgrade['id']){
							echo '<div style="background:lightgreen;">Updated</div> '.round($sre['grade'], 2);
							//echo '<div style="background:lightgreen;">Updated</div> ';
							//printf('%d',$sre['grade']);
						}else{
							//echo $qgrade['usergrade'];
							echo round($qgrade['usergrade']);
						}
					}else{			
						// marks here
						echo $totalmarks_test;
						// echo round($qgrade['usergrade']);
						// echo '/'.round($qgrade['sumgrades']);
					}					
				?>
				</td>
				<?php
				// jika kurang daripada 70 mean FAIL
				
				if($totalmarks_test < $passingmarkshape){

				?>
				<td class="adjacent" align="center" colspan="2"><?php echo get_string('failtest');?></td>	
				<?php }else{ // jika PASS ?>					
				
                <?php if($USER->id == '2'){ ?>
				<td class="adjacent" align="center">
				<div style="padding:3px;">
					<?php 
					if(!$_POST['updateresult']){ 
					?>
					<input type="submit" name="updateresult" value="<?=get_string('update');?>" onClick="this.form.action='<?=$CFG->wwwroot ."/userfrontpage/viewresult.php?id=".$id."&examid=".$qgrade['id'];?>'"  onMouseOver="style.cursor='hand'" />
					<?php 
					}else{
						$examid=$_GET['examid'];
						if($examid == $qgrade['id']){					
					?>
					<input type="submit" name="saveresult" value="<?=get_string('savebutton');?>" onClick="this.form.action='<?=$CFG->wwwroot ."/userfrontpage/viewresult.php?id=".$id."&examid=".$qgrade['id']."&itemid=".$selq['id'];?>'"  onMouseOver="style.cursor='hand'" />					
					<?php 											
					}else{?>
					<input style="cursor:hand;" type="submit" name="updateresult" value="<?=get_string('update');?>" onClick="this.form.action='<?=$CFG->wwwroot ."/userfrontpage/viewresult.php?id=".$id."&examid=".$qgrade['id'];?>'"  onMouseOver="style.cursor='hand'" />
					<?php }
					}
					?>
					
				</div>
				</td>
				<td class="adjacent" align="center">
				<div style="padding:3px;">
					<input type="button" name="viewcertify" value="<?=get_string('view');?>" onclick="window.open('certify_two.php?id=<?=$q['id']; ?>&courseid=<?=$qgrade['course'];?>&certid=<?=$qgrade['quizid'];?>&quizid=<?=$qgrade['cifaquizid'];?>', 'Window2', 'width=850,height=600,resizable = 1,scrollbars=1');"  onMouseOver="style.cursor='hand'" />					
				</div>
				</td>				
				<?php }}} // count attempts ?>
			</tr>
			<?php } ?>
		</table>
		<div style="padding:5px; text-align:center;"><input type="submit" name="back" onClick="this.form.action='<?=$CFG->wwwroot. '/userfrontpage/examresult_ECadmin.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" /></div>
		</form>
		</div>
	<?php }	?>
<?php echo $OUTPUT->footer(); ?>