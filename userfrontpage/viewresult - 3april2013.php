<?php
    require_once('../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php'); 

	$site = get_site();
	$getnav=$_GET['nav'];
	$viewresult=get_string('viewresult');
	$title="$SITE->shortname: ".$viewresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	//$PAGE->navbar->add($getnav)->add($viewresult);
	//$PAGE->set_pagelayout('course');

	echo $OUTPUT->header();		
	if (isloggedin()) {
		add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
		echo $OUTPUT->heading($viewresult, 2, 'headingblock header');
		
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
		<div style="min-height: 400px;">
		
		<?php
			$sel=mysql_query("SELECT * FROM mdl_cifauser WHERE id='".$id."'");
			$q=mysql_fetch_array($sel);
		?>
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
				<th class="adjacent" width="39%" style="text-align:left;"><strong><?=get_string('examname');?></strong></th>
				<th class="adjacent" width="18%" style="text-align:center;"><strong><?=get_string('timestart');?></strong></th>
				<th class="adjacent" width="18%" style="text-align:center;"><strong><?=get_string('timefinish');?></strong></th>
				<!--th class="adjacent" width="13%" style="text-align:center;"><strong><?//=get_string('durations');?></strong></th-->
				<th class="adjacent" width="18%" style="text-align:center;"><?=get_string('marks');?></th>	
                <?php if($USER->id == '2'){ ?>
				<th class="adjacent" width="6%" style="text-align:center;"><?=get_string('misc.');?></th>
				<th class="adjacent" width="6%" style="text-align:center;"><?=get_string('cert.');?></th>
                <?php } ?>
			</tr>	
			<?php
				$sgrade=mysql_query("SELECT *, a.grade as usergrade FROM mdl_cifaquiz_grades a, mdl_cifaquiz b WHERE a.quiz=b.id AND userid='".$q['id']."'");
				$bil=1;
				while($qgrade=mysql_fetch_array($sgrade)){
				$no=$bil++;
			?>
			<tr>
				<td class="adjacent" align="center"><?=$no;?></td>
				<td class="adjacent" style="text-align:left;">
				<?php 
					if($qgrade['course']=='12'){
						echo 'CIFA Foundation Exam';
					}else{
						echo ucwords(strtolower($qgrade['name']));
					}
					
				/*$myString=$qgrade['questions'];
				$myArray = explode(',', $myString);
				for ($i='0'; $i<=20; $i++){
					$test=$myArray[$i];
					if($test != '0'){
						echo '<br/>'.$test;
					}
				}
				//$test=$myArray;
				$r=count($test);
				echo '->'.$r;*/
				?>
				</td>
				<td class="adjacent" align="center">
				<?php
					$sque=mysql_query("SELECT timestart, timefinish FROM mdl_cifaquiz_attempts WHERE userid='".$q['id']."' AND quiz='".$qgrade['id']."'");
					$query=mysql_fetch_array($sque);
					
					echo date('d-m-Y H:i:s',$query['timestart']).'<br/>';
				?>
				</td>
				<td class="adjacent" align="center"><?=date('d-m-Y H:i:s',$query['timefinish']);?></td>
				<td class="adjacent" align="center">
				<?php 
				$sel=mysql_query("SELECT * FROM mdl_cifagrade_items WHERE itemtype='mod' AND itemmodule='quiz' AND courseid='".$qgrade['course']."'");
				$selq=mysql_fetch_array($sel);
				//echo $selq['itemname'].'->'.$selq['id'].'<br/>';
				
				$sel2=mysql_query("SELECT * FROM mdl_cifagrade_items WHERE itemtype='course' AND courseid='".$qgrade['course']."'");
				$selq2=mysql_fetch_array($sel2);
				//echo $selq2['id'].'<br/>';
				?>				
				
				<?php
					if($_POST['updateresult']){	
						$examid=$_GET['examid'];
						if($examid == $qgrade['id']){
							echo '<input type="text" style="text-align:center; background-color:lightyellow;" name="updategrade" value="'.round($qgrade['usergrade'], 2).'"/>';
						}else{
							//echo $qgrade['usergrade'];
							echo round($qgrade['usergrade'], 2);
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
							echo round($qgrade['usergrade'], 2);
						}
					}else{
						echo round($qgrade['usergrade'], 2);
						//printf('%d',$qgrade['usergrade']);
					}					
				?>
				
				</td>
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
					<input type="button" name="viewcertify" value="<?=get_string('view');?>" onclick="window.open('certify_two.php?id=<?=$q['id']; ?>&courseid=<?=$qgrade['course'];?>', 'Window2', 'width=850,height=600,resizable = 1,scrollbars=1');"  onMouseOver="style.cursor='hand'" />					
				</div>
				</td>				
				
			</tr>
			<?php }} ?>
		</table>
		<div style="padding:5px; text-align:center;"><input type="submit" name="back" onClick="this.form.action='<?=$CFG->wwwroot. '/userfrontpage/examresult_ECadmin.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" /></div>
		</form>
		</div>
	<?php }	?>
<?php echo $OUTPUT->footer(); ?>