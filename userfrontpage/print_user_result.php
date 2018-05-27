<?php if(isset($_GET['printpage'])){ ?>
		<body onLoad="javascript:window.print()">
<?php } ?>
<?php
    require_once('../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php'); 
	$PAGE->requires->css('/theme/aardvark/style/core.css');
	$PAGE->requires->css('/css/style2.css');

	$site = get_site();

	$fullusername=ucwords(strtolower($USER->firstname.' '.$USER->lastname)).' ('.strtoupper($USER->traineeid).')';
	$viewresult=get_string('cifaexamination');
	$title="$SITE->shortname: ".$viewresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('exam_result');
	$urlexamresult = new moodle_url('/userfrontpage/viewuserresult.php', array('id'=>$USER->id)); //added by arizan	
	$PAGE->navbar->add(get_string('mytraining'))->add('Exam Result', $urlexamresult);
		
		
	$id=$USER->id;
	$sel=mysql_query("SELECT * FROM mdl_cifauser WHERE id='".$USER->id."'");
	$q=mysql_fetch_array($sel);		

	//IPD candidate 
	$IPDstatement=" mdl_cifauser a, mdl_cifauser_program b WHERE a.id=b.userid AND a.deleted!='1' AND b.programid='1' AND b.userid='".$USER->id."'";
	$selIPD=mysql_query("SELECT * FROM {$IPDstatement}");
	$cIPD=mysql_num_rows($selIPD); 	
		
	?>
	<style media="screen">
	<?php 
		/* include('../css/style2.css'); 
		include('../css/button.css');
		include('../css/pagination.css');
		include('../css/grey.css'); */
	?>	
	</style>
		
	<style type="text/css">	
		body{
			font-family:Verdana,Geneva,sans-serif;
			font-size:0.9em;
		}	
		table th, td {font-size:0.9em; border-color:#000; border-collapse:collapse;}
		tr .yellow th{ background-color:#6D6E71;}
	</style>
	<style type="text/css">
		img.table-bg-image {
			position: absolute;
			z-index: -1;
			width:100%;
			/* min-height:837px; */
			height:98%;
			margin-bottom:0px;
			padding-bottom:0px;
		}
		table.with-bg-image, table.with-bg-image tr, table.with-bg-image td {
			background: transparent;
		}
	</style>
<img class="table-bg-image" src="<?=$CFG->wwwroot;?>/image/bg_statement.png"/>	

	<div style="margin:0px auto">
<table class="with-bg-image" width="100%"><tr><td><br/>
<table id="policy" width="95%" border="0"  style="padding:0px;margin:0px auto;">
  <tr valign="top">
    <td align="left" valign="middle" style="font-size:0.9em;"><?=get_string('ipdaddress');?></td>
    <td align="right" style="width:50%"><img style="width:134px;" src="<?=$CFG->wwwroot;?>/image/CIFALogo.png"></td>
  </tr>
</table>

	<table style="margin:0px auto;width:95%;"><tr><td>
	<h2><?=$viewresult;?></h2>
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
		</table><br/>
		
		<table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
			<tr class="yellow" style="color:#fff;">
				<th class="adjacent" width="5%">No
                 <?php /*<div style="position: relative;">
                    <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                    <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                    <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em; left: -6px;">No</span>
                </div>  */?>              
                </th>
				<?php /*SHAPE IPD*/ if($cIPD!='0'){ ?>
				<th class="adjacent" width="39%" style="padding-left:5px;text-align:left;"><?=get_string('examinationtitle');?>
                 <?php /*<div style="position: relative;">
                    <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                    <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                    <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em; left: -6px;"><strong><?=get_string('examinationtitle');?></strong></span>
                </div> */?>                
                </th>
				<?php }else{ ?>
				<th class="adjacent" width="39%" style="text-align:left;"><?=get_string('examname');?>
                 <?php /*<div style="position: relative;">
                    <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                    <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                    <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em; left: -6px;"><strong><?=get_string('examname');?></strong></span>
                </div>   */?>              
                </th>
				<?php } ?>
				<th class="adjacent" width="18%" style="text-align:center;"><?=get_string('timestart');?>
                 <?php /*<div style="position: relative;">
                    <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                    <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                    <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em; left: -6px;"><strong><?=get_string('timestart');?></strong></span>
                </div>   */?>              
                </th>
				<th class="adjacent" width="18%" style="text-align:center;"><?=get_string('timefinish');?>
                 <?php /*<div style="position: relative;">
                    <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                    <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                    <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em; left: -6px;"><strong><?=get_string('timefinish');?></strong></span>
                </div>     */ ?>                            
                </th>
				<th class="adjacent" width="18%" style="text-align:center;"><?=get_string('marks');?>
				<?php /* ?>	
                 <div style="position: relative;">
                    <img src="../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                    <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                    <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em; left: -6px;"><?=get_string('marks');?></span>
                </div>	<?php */ ?>			
				</th>	
			</tr>	
			<?php
				$sgrade=mysql_query("
					Select
					  *,
					  a.grade As usergrade
					From
					  mdl_cifaquiz_grades a,
					  mdl_cifaquiz b Inner Join
					  mdl_cifacourse c On b.course = c.id
					Where
					  a.quiz = b.id And c.visible!='0' And
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
				<td class="adjacent" style="padding-left:5px;text-align:left;">
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
			</tr>
			<?php } ?>
			<?php
			//if no records
				if($cq == '0'){
					echo '<tr><td class="adjacent" style="text-align:left;" colspan="6">'.get_string('norecords').'</td></tr>';
				}
			?>
		</table></td></tr></table>	
		</td></tr></table></div>