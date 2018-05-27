<?php
    require_once('../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php'); 

	$site = get_site();

	$fullusername=ucwords(strtolower($USER->firstname.' '.$USER->lastname)).' ('.strtoupper($USER->traineeid).')';
	//$viewresult=get_string('testresults');
	$viewresult=get_string('cifaexamination');
	$title="$SITE->shortname: ".$viewresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('exam_result');
	$urlexamresult = new moodle_url('/userfrontpage/viewuserresult.php', array('id'=>$USER->id)); //added by arizan	
	$mytraininglink = new moodle_url('/coursesindex.php', array('id'=>$USER->id)); //added by arizan
	$PAGE->navbar->add(get_string('mytraining'), $mytraininglink)->add('Exam Result', $urlexamresult);
		
	echo $OUTPUT->header();		
	if (isloggedin()) {
		add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
		
		//IPD candidate 
		$IPDstatement=" mdl_cifauser a, mdl_cifauser_program b WHERE a.id=b.userid AND a.deleted!='1' AND b.programid='1' AND b.userid='".$USER->id."'";
		$selIPD=mysql_query("SELECT * FROM {$IPDstatement}");
		$cIPD=mysql_num_rows($selIPD); 	
		
		if($cIPD!='0'){
			//echo $OUTPUT->heading(get_string('testresults'), 2, 'headingblock header');
			echo $OUTPUT->heading(get_string('cifaexamination'), 2, 'headingblock header');
		}else{
			echo $OUTPUT->heading($viewresult, 2, 'headingblock header');
		}
		
		$id=$_GET['id'];
		
	?>
	<script type="text/javascript">
	<!--
	function myPopup2() {
	var printtxt = document.getElementById('printtxt').value;
	window.open(printtxt, "Window2", "status = 1, width=880, height=500, resizable = yes, scrollbars=1");
	//window.open(printtxt);
	}
	//-->
	</script>	
	<style>
	<?php 
		include('../css/style2.css'); 
		include('../css/button.css');
		include('../css/pagination.css');
		include('../css/grey.css');
	?>
	</style>	
		<div style="min-height: 250px;">	
		<?php
			$sel=mysql_query("SELECT * FROM mdl_cifauser WHERE id='".$id."'");
			$q=mysql_fetch_array($sel);
		?>
		<form id="form1" name="form1" method="post" action="">
		<br/>
		<table id="availablecourse2">
			<tr>
				<td><?=get_string('candidatename');?></td>
				<td><strong>:</strong></td>
				<td><?=ucwords(strtolower($q['firstname'].' '.$q['lastname']));?></td>
			</tr>
			<tr>
				<td><?=get_string('candidateid');?></td>
				<td><strong>:</strong></td>
				<td><?=strtoupper($q['traineeid']);?></td>
			</tr>			
		</table>
		<br/>
		<table id="availablecourse">
			<tr class="yellow">
				<th class="adjacent" width="1%">No</th>
				<?php /*SHAPE IPD*/ if($cIPD!='0'){ ?>
				<th class="adjacent" width="39%" style="text-align:left;padding: 5px;"><strong><?=get_string('examinationtitle');?></strong></th>
				<?php }else{ ?>
				<th class="adjacent" width="39%" style="text-align:left;padding: 5px;"><strong><?=get_string('examname');?></strong></th>
				<?php } ?>
				<th class="adjacent" width="18%" style="text-align:center;padding: 5px;"><strong><?=get_string('timestart');?></strong></th>
				<th class="adjacent" width="18%" style="text-align:center;padding: 5px;"><strong><?=get_string('timefinish');?></strong></th>
				<th class="adjacent" width="18%" style="text-align:center;padding: 5px;"><?=get_string('marks');?></th>	
				<th class="adjacent" width="6%" style="text-align:center;padding: 5px;"><?=get_string('view');?></th>
			</tr>	
			<?php
				// $sgrade=mysql_query("SELECT *, a.grade as usergrade FROM mdl_cifaquiz_grades a, mdl_cifaquiz b WHERE a.quiz=b.id AND userid='".$q['id']."'");
				$sgrade=mysql_query("
					Select
					  *,
					  a.grade As usergrade
					From
					  mdl_cifaquiz_grades a,
					  mdl_cifaquiz b Inner Join
					  mdl_cifacourse c On b.course = c.id
					Where
					  a.quiz = b.id And
					  (c.category = '3' And
					  a.userid = '".$q['id']."')				
				");
				$bil=1;
				$cq=mysql_num_rows($sgrade); //count records
				while($qgrade=mysql_fetch_array($sgrade)){
				$no=$bil++;
			?>
			<tr>
				<td class="adjacent" align="center"><?=$no;?></td>
				<td class="adjacent" style="text-align:left;">
				<?php 
					//if($qgrade['course']=='12'){
						//echo 'CIFA Foundation Exam';
					//}else{
						echo ucwords(strtolower($qgrade['name']));
					//}
				?>
				</td>
				<td class="adjacent" align="center">
				<?php
					$sque=mysql_query("SELECT timestart, timefinish FROM mdl_cifaquiz_attempts WHERE userid='".$q['id']."' AND quiz='".$qgrade['quiz']."'");
					$query=mysql_fetch_array($sque);
					
					echo date('d-m-Y H:i:s',$query['timestart']).'<br/>';
				?>
				</td>
				<td class="adjacent" align="center"><?=date('d-m-Y H:i:s',$query['timefinish']);?></td>
				<td class="adjacent" align="center"><?=round($qgrade['usergrade']);?></td>
				<?php 
					//certificate button // membership expiry
					$statement="mdl_cifauser a WHERE a.id='".$USER->id."'";
					$sqlquery=mysql_query("Select * From {$statement} ");
					$sqlRowStudent=mysql_fetch_array($sqlquery);

					$today=strtotime('now');
					$startdate=date('d-m-Y H:i:s',$sqlRowStudent['timecreated']); //start date
					$membershipexpiry=date('d-m-Y H:i:s',strtotime($startdate . " + 1 year")); //expiry
				?>
				<td class="adjacent" align="center">
					<div style="padding:5px; text-align:center;">
					<?php 
						if($sqlRowStudent['timecreated']<=$today && $today <= strtotime($membershipexpiry)){ 
					?>
						<input type="button" id="id_actionbutton" name="statement" value="<?=get_string('statement');?>" onclick="window.open('<?=$CFG->wwwroot. "/offlineexam/usercertificate.php?id=".$USER->id."&examid=".$qgrade['id'];?>', 'Window2', 'width=850, height=500,resizable = 1, scrollbars=yes');"/>
						<!--input type="button" name="certificate" value="<?//=get_string('certificate');?>" onclick="window.open('<?//=$CFG->wwwroot. "/offlineexam/usercertificate.php?id=".$USER->id."&examid=".$qgrade['id'];?>', 'Window2', 'width=850, height=950,resizable = 1');"/-->
					<?php 
						}else{ 
							$alertlink='alert("'.get_string('alertmessage').'")';
							//echo "<a href='#' onClick='".$alertlink."'>".get_string('statement').'</a>'; 
							//echo '<input type="button" name="statement_expiry" value="'.get_string('statement').'" onclick="'.$alertlink.'">';					
					?>
							<input type="button" id="id_actionbutton" name="statement" value="<?=get_string('statement');?>" onclick='alert("<?=get_string('alertmessage');?>")'>
					<?php
						} 
					?>
					</div>
				</td>
			</tr>
			<?php } ?>
			<?php
			//if no records
				if($cq == '0'){
					echo '<tr><td class="adjacent" style="text-align:left;" colspan="6">'.get_string('norecords').'</td></tr>';
				}
			?>
		</table>

        <br/>
		<div style="padding:2px;text-align:center;"><center>
		<?php $printtxt = $CFG->wwwroot. "/userfrontpage/print_user_result.php?seskey=".$_GET['seskey']."&printpage=1"; ?>
		<input type="hidden" name="printtxt" id="printtxt" value="<?=$printtxt;?>"/>			
		<?php if($cq != '0'){ ?>
		<input type="button" onClick="myPopup2()" onMouseOver="style.cursor='pointer'" name="viewuserresult" value="&nbsp;<?=get_string('print');?>&nbsp;" />			
		<?php } ?>
		<input id="id_defaultbutton" type="submit" name="back" onClick="this.form.action='<?=$CFG->wwwroot. '/index.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" />
		</center></div>		
		
			<!--div style="padding:5px; text-align:center;"><input type="submit" name="back" onClick="window.print();" value="<?///=get_string('print');?>" />
			<input type="submit" name="back" onClick="this.form.action='<?//=$CFG->wwwroot. '/index.php?id='.$USER->id;?>'" value="<?//=get_string('back');?>" /></div-->
		</form>
		</div>
	<?php }	?>
<?php echo $OUTPUT->footer(); ?>