<?php if(isset($_GET['printpage'])){ ?>
		<body onLoad="javascript:window.print()">
<script language="javascript">
var isNS = (navigator.appName == "Netscape") ? 1 : 0;
  if(navigator.appName == "Netscape")
     document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);
  function mischandler(){
   return false;
 }
  function mousehandler(e){
     var myevent = (isNS) ? e : event;
     var eventbutton = (isNS) ? myevent.which : myevent.button;
    if((eventbutton==2)||(eventbutton==3)) return false;
 }
 document.oncontextmenu = mischandler;
 document.onmousedown = mousehandler;
 document.onmouseup = mousehandler;
function killCopy(e){
    return false
}
function reEnable(){
    return true
}
document.onselectstart = new Function ("return false")
if (window.sidebar){
    document.onmousedown=killCopy
    document.onclick=reEnable
}
</script>        
<?php } ?>
<?php
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../../manualdbconfig.php'); 

	$site = get_site();
	
	$courseid=$_GET['courseid'];
	
	$getcategorysql=mysql_query("SELECT category FROM {$CFG->prefix}course WHERE id='".$courseid."'");
	$getcategory=mysql_fetch_array($getcategorysql);
	$ccategory=$getcategory['category'];	
	
	$resultsummary=ucwords(strtolower(get_string('quiz_result_summary_mock','quiz')));
	$mocktitle=get_string('quiz_result_summary_mock','quiz');
	$finaltesttitle=get_string('quiz_result_summary','quiz');	
	$title="$SITE->shortname: ".$resultsummary;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('course');	
	if (isloggedin()) {
	$id=$_GET['id'];	
	$quiz_attemptid=$_GET['attemptid'];
	?>	
	<style>
	<?php 
		include('../../css/style2.css'); 
		include('../../css/button.css');
		include('../../css/pagination.css');
		include('../../css/grey.css');
	?>
	</style>
<style type="text/css">
<?php //require_once($CFG->wwwroot. '/theme/aardvark/style/core.css'); ?>
#welcometable{
	/*font:18px/1.231 arial,helvetica,clean,sans-serif;
	margin-left: 30px;*/
}
html{
font-family:Verdana,Geneva,sans-serif;
}
table th, td {font-size:0.9em; border-color:#000; border-collapse:collapse;}
td {padding:0.3em; }
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

<table class="with-bg-image" width="100%"><tr><td><br/>
<table id="policy" width="100%" border="0"  style="padding:0px;">
  <tr valign="top">
    <td align="left" valign="middle" style="font-size:0.9em;"><?=get_string('ipdaddress');?></td>
    <td align="right" style="width:50%"><img style="width:134px;" src="<?=$CFG->wwwroot;?>/image/CIFALogo.png"></td>
  </tr>
</table>
<div id="welcometable"><h3>
<?php
	if($ccategory=='9'){
		echo $mocktitle;	// mock test title
	}else{
		echo $finaltesttitle; // Final test title
	}	
?>
</h3></div>	
		<div style="min-height: 400px;">
		
		<?php
			$sel=mysql_query("SELECT * FROM mdl_cifauser WHERE id='".$USER->id."'");
			$q=mysql_fetch_array($sel);
			
			
			$qattempt="
				Select
				  b.responsesummary,
				  b.rightanswer,
				  b.maxmark,
				  a.uniqueid,
				  a.quiz as quizattempt,
				  a.userid,
				  a.attempt,       
				  a.sumgrades,
				  a.timestart,
				  a.timefinish,
				  a.timemodified,
				  a.preview,
				  a.needsupgradetonewqe,				  
				  b.questionid,
				  b.slot,
				  b.questionusageid,
				  d.name,
				  d.category,
				  e.id As categorygroup,
				  e.name As questiongroup,
				  f.grade as usergrade,
				  g.name As examname
				From
				  mdl_cifaquiz_attempts a Inner Join
				  mdl_cifaquestion_attempts b On a.uniqueid = b.questionusageid Inner Join
				  mdl_cifagrade_grades c On b.timemodified = c.timemodified Inner Join
				  mdl_cifaquestion d On b.questionid = d.id Inner Join
				  mdl_cifaquestion_categories e On d.category = e.id Inner Join
				  mdl_cifaquiz_grades f On f.userid = a.userid Inner Join
				  mdl_cifaquiz g On f.quiz = g.id  
				Where
				  a.userid = '".$q['id']."' And g.course = '".$_GET['courseid']."' And a.quiz = '".$_GET['examid']."' Group By e.id ORDER BY b.slot ASC
			";
			$sgrade=mysql_query($qattempt);
			//Group By e.name	
			
			
			//$sgrade=mysql_query("SELECT *, a.grade as usergrade FROM mdl_cifaquiz_grades a, mdl_cifaquiz b WHERE a.quiz=b.id AND userid='".$q['id']."'");			
			$sgrade2=mysql_query("SELECT *, a.grade as usergrade FROM mdl_cifaquiz_grades a, mdl_cifaquiz b WHERE a.quiz=b.id AND userid='".$q['id']."'");
			$grade=mysql_fetch_array($sgrade2);
		?>
		<form id="form1" name="form1" method="post" action="">
		<table cellpadding="0" cellspacing="0" id="availablecourse2" style="border-collapse:collapse;width:70%;">
			<tr>
				<td width="30%"><?=get_string('candidatename');?></td>
				<td width="1%"><strong>:</strong></td>
				<td align="left"><?=ucwords(strtolower($q['firstname'].' '.$q['lastname']));?></td>
			</tr>
			<tr>
				<td><?=get_string('candidateid');?></td>
				<td><strong>:</strong></td>
				<td><?=strtoupper($q['traineeid']);?></td>
			</tr>		
			<tr>
				<td>Date</td>
				<td><strong>:</strong></td>
				<td>
					<?php
						$sque=mysql_query("SELECT timestart, timefinish FROM mdl_cifaquiz_attempts WHERE userid='".$q['id']."' AND quiz='".$grade['id']."'");
						$query=mysql_fetch_array($sque);
						
						echo date('d-m-Y',$query['timestart']).'<br/>';
					?>				
				</td>
			</tr>			
		</table><br/><br/>
		
		<table border="1" cellpadding="0" cellspacing="0" class="viewdata" style="border-collapse:collapse;width:100%; margin:1.2em 0px;">
			<tr style="background-color:#6D6E71; color:#ffffff;">
				<th width="39%" style="padding-left:5px;text-align:left;"><?=get_string('resultsection', 'quiz');?>
				 <?php /*<div style="position: relative;">
					<img src="../../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
					<!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
					<span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('resultsection', 'quiz');?></span>
				</div> */?>
				</th>
				<th width="18%" style="text-align:center;"><?=get_string('questions', 'quiz');?>
                <?php /* <div style="position: relative;">
                    <img src="../../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
                    <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                    <span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('questions', 'quiz');?></span>
                </div> */?>
				</th>
				<th width="18%" style="text-align:center;"><?=get_string('correctanswer', 'quiz');?>
				 <?php /*<div style="position: relative;">
					<img src="../../image/btp_c.png" style="width:100%; height:1.5em; border: 0; padding: 0" />
					<!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
					<span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('correctanswer', 'quiz');?></span>
				 </div> */?>
				 </th>
				<th width="18%" style="text-align:center; display:none;"><?=get_string('marks');?></th>
			</tr>
			<?php
				$bil=1;
				$q1sum=0;
				$count=0;
				while($qgrade=mysql_fetch_array($sgrade)){
				$no=$bil++;
			?>
			<tr>
				<!--td class="adjacent" align="center" style="display:none;"><?//=$no;?></td-->
				<td class="adjacent" style="padding-left:5px;text-align:left;">
				<?php 
					echo $qgrade['questiongroup'];
				?>
				</td>
				<td class="adjacent" align="center">
				<?php		
					//count total question
					$attemptidquery=mysql_query("
						Select
						  a.id
						From
						  mdl_cifaquiz_attempts a Inner Join
						  mdl_cifaquestion_attempts b On a.uniqueid = b.questionusageid  
						Where
						  a.id='".$quiz_attemptid."'
					");
					$numattemptid=mysql_num_rows($attemptidquery);
					echo $numattemptid;
				?>
				</td>
				<td class="adjacent" align="center">
				<?php
					//count total question attempt/Answer		
					$squerytotal=mysql_query("
						Select
						  a.id
						From
						  mdl_cifaquiz_attempts a Inner Join
						  mdl_cifaquestion_attempts b On a.uniqueid = b.questionusageid  
						Where
						  a.id='".$quiz_attemptid."' And
						  b.responsesummary = b.rightanswer AND b.responsesummary != ''	
					"); 					
										
					$totalquestionattempt=mysql_num_rows($squerytotal);
					$totalanswered+=$totalquestionattempt;
					echo $totalquestionattempt; //correct answer

					//score per question						
					$marksperlearning=($totalquestionattempt / $numattemptid)*100;
					
					//total final per marks
					$q1sum+=(float) ($totalquestionattempt / $numattemptid)*100;
					$count++;	
					
					//Final marks
					$q1final_result=$q1sum / $count;
					
				?>				
				</td>
				<td class="adjacent" align="center" style="display:none;">
				<?php 
					//total final per marks
					/* $q1sum+=(float) ($totalquestionattempt / $qqcount)*100;
					$count++;
					
					//score per question						
					$marksperlearning=($totalquestionattempt / $qqcount)*100;					
					echo round($marksperlearning).' %'; */
				?>
				
				</td>
			</tr>
			<?php } ?>
			<!---total question / attempts / score---->
			<tr>
				<td class="adjacent" style="text-align:left; font-weight:bolder"><?=get_string('totalquestion', 'quiz');?></td>
                <td align="center" class="adjacent" style="text-align:center;font-weight:bolder"><?=$numattemptid;;?></td>
				<td class="adjacent" style="text-align:center;font-weight:bolder"><?php
					//count total question answered	
					echo $totalanswered;
				?></td>
				<td class="adjacent" style="background: #58FA58; display:none;">
				<?php
					//count total score
					/* $scorequery=mysql_query("Select
					  b.responsesummary,
					  b.rightanswer,
					  b.maxmark,
					  a.uniqueid,
					  a.quiz,
					  b.questionid,
					  b.slot,
					  b.questionusageid,
					  d.name,
					  d.category,
					  e.name As questiongroup,
					  f.grade as usergrade
					From
					  mdl_cifaquiz_attempts a Inner Join
					  mdl_cifaquestion_attempts b On a.uniqueid = b.questionusageid Inner Join
					  mdl_cifagrade_grades c On b.timemodified = c.timemodified Inner Join
					  mdl_cifaquestion d On b.questionid = d.id Inner Join
					  mdl_cifaquestion_categories e On d.category = e.id Inner Join
					  mdl_cifaquiz_grades f On f.userid = a.userid Inner Join
					  mdl_cifaquiz g On f.quiz = g.id
					Where
					  a.userid = '".$q['id']."' And g.course = '".$_GET['courseid']."' And a.quiz = '".$_GET['examid']."' AND b.behaviour!='informationitem'
					");	
					$markscrore=mysql_fetch_array($scorequery);
					$scoreattempt=mysql_num_rows($scorequery);
					$markgrade=(($qgrade['maxmark'] * 100) / $sc);
					$totalscore=($markgrade * $scoreattempt);
					//echo round($markscrore['usergrade']).' %';
					
					//Final marks
					$q1final_result=$q1sum / $count;
					echo '<strong>'.round($q1final_result).' % </strong>'; */

				?>
				</td>
			</tr>
            <tr>
            	<td style="text-align:left; font-weight:bolder"><?=get_string('resultpercent', 'quiz');?></td>
                <td >&nbsp;</td>
                <th style="color:#ffffff;padding:0px:text-align:center; background: #6D6E71;"><?='<strong>'.round($q1final_result).' % </strong>';?>
					<?php /*<div style="position: relative;">
						<img src="../../image/btp_c.png" style="width:100%; height:1.8em; border: 0; padding: 0" />
						<!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
						<span style="position: absolute; top: 50%; margin-top: -0.6em; margin-left: 0.5em;padding-left:6em;"><?='<strong>'.round($q1final_result).' % </strong>';?></span>
					</div> */?>
				</th>
                <td style="display:none;"></td>
            </tr>            
		</table><br/>  			
</form>
</div>
<?php }else{ 
	echo 'You not allow to view this summary;';
	$linkto=$CFG->wwwroot.'/index.php';
	redirect($linkto);
	}	
?>
</td></tr></table>
