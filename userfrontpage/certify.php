<?php
    include('../config.php');
    // include($CFG->dirroot .'/course/lib.php');
    // include($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php'); 
	
	$currentid=$_GET['id'];
	$testid=$_GET['testid'];
?>
		<style>
		<?php include('../theme/aardvark/style/core.css'); ?></style>
		
<style type="text/css">
    img.table-bg-image {
	position: absolute;
	z-index: -1;
	width: 98%;
	height: 857px;
    }
    table.with-bg-image, table.with-bg-image tr, table.with-bg-image td {
        background: transparent;
    }
</style>
<img class="table-bg-image" src="<?=$CFG->wwwroot;?>/image/bg_cert.png"/>		
<?php	
	$stat=mysql_query("SELECT * FROM mdl_cifauser WHERE id='".$currentid."'");
	$susers=mysql_fetch_array($stat);
	
	$statcourse=mysql_query("
					Select
					  *,
					  a.grade As usergrade, b.id As quizid
					From
					  mdl_cifaquiz_grades a,
					  mdl_cifaquiz b Inner Join
					  mdl_cifacourse c On b.course = c.id
					Where
					  a.quiz = b.id And
					  c.visible!='0' And b.id='".$testid."' And
					  (c.category = '3' And 
					  a.userid = '".$currentid."')	
	");
	$scourses=mysql_fetch_array($statcourse);	
?>
<body onLoad="javascript:window.print()">
<table width="95%" height="857" border="1" cellpadding="0" cellspacing="0" class="with-bg-image" style="text-align:center;font-family:Arial, Helvetica, sans-serif;margin:0px auto;">
  <tr style="vertical-align:top;">
    <td>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="text-align:center;">
  <tr>
    <td width="77%">&nbsp;</td>
    </tr> 
  <tr>
    <td height="170"><img src="../image/Landscape_logo_(trademark).jpg" width="330" /></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="31">&nbsp;</td>
    </tr>
  <tr>
    <td>This is to certify that</td>
    </tr>
  <tr>
    <td><div style="font-size:2em;"><?php echo $susers['firstname'].' '.$susers['lastname'];?></div></td>
    </tr>
  <tr>
    <td>has completed the</td>
    </tr>
  <tr>
    <td height="48">&nbsp;</td>
    </tr>
  <tr>
    <td><div style="font-size:1.2em;"><em><i><?=$scourses['name'];?></i></em></div></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="36">&nbsp;</td>
    </tr>
  <tr>
    <td>Date:</td>
    </tr>
  <tr>
    <td>
		<?php
			$sque=mysql_query("SELECT timestart, timefinish FROM mdl_cifaquiz_attempts WHERE userid='".$currentid."' AND quiz='".$scourses['quiz']."'");
			$query=mysql_fetch_array($sque);
			
			echo date('F jS, Y',$query['timestart']).'<br/>';
		?>	
		<?php // echo date('F jS, Y', $scourses['timestart']); ?></td>
    </tr>
  <tr>
    <td height="50">&nbsp;</td>
    </tr>
  <tr>
    <td><?=get_string('candidateid');?>:</td>
    </tr>
  <tr>
    <td><?=strtoupper($susers['traineeid']);?></td>
    </tr>
  <tr>
    <td height="54">&nbsp;</td>    
    </tr>
  <tr>
    <td>Certificate ID:</td>
    </tr>
  <tr>
    <td><?='IPD'.date('Y', strtotime('now')).'/'.strtoupper($susers['id']);?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="87">&nbsp;</td>
    </tr>     
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div style="font-size:10px"><?=get_string('certtext');?></div></td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
    </tr>  
</table>
</td></tr></table>