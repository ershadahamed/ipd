<?php
    require_once('../config.php');
    // require_once($CFG->dirroot .'/course/lib.php');
    // require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php'); 
	
	$currentid=$_GET['id'];
	$programmename=$_GET['courseid'];
	$testid=$_GET['quizid'];
	
	$stat=mysql_query("SELECT * FROM mdl_cifauser WHERE id='".$currentid."'");
	$susers=mysql_fetch_array($stat);
	
	$statcourse=mysql_query("SELECT * FROM mdl_cifacourse WHERE id='".$programmename."'");
	$scourses=mysql_fetch_array($statcourse);
	
	$sgrade=mysql_query("SELECT *, a.grade as usergrade FROM mdl_cifaquiz_grades a, mdl_cifaquiz b WHERE a.quiz=b.id AND b.course='".$_GET['courseid']."' AND userid='".$currentid."'");
	$qgrade=mysql_fetch_array($sgrade);	
	
	
	/* $stat=mysql_query("SELECT * FROM mdl_cifauser WHERE id='".$currentid."'");
	$susers=mysql_fetch_array($stat); */
	
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
<table class="with-bg-image" width="98%" height="867px"  border="1" cellpadding="0" cellspacing="0" style="text-align:center;font-family:Arial, Helvetica, sans-serif;">
  <tr style="vertical-align:top;">
    <td>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="text-align:center;">
  <tr>
    <td width="77%">&nbsp;</td>
    </tr> 
  <tr>
    <td><img src="../image/Landscape_logo_(trademark).jpg" width="330" /></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>This is to certify that</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><div style="font-size:2em;"><?php echo ucwords(strtolower($susers['firstname'].' '.$susers['lastname']));?></div></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>	
  <tr>
    <td>has passed the</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36">&nbsp;</td>
    </tr>
  <tr>
    <td><div style="font-size:1.3em;"><i><?=$scourses['name'];?></i></div></td>
    </tr>
  <tr>
    <td height="36">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td style="padding:0px 10px 0px 30px;text-align:center;">
    <table width="50%" border="0" cellpadding="0" cellspacing="0" style="margin:0px auto;">
      <tr>
        <td width="50%">Date:</td>
        <td width="50%">Sponsor by</td>
      </tr>
      <tr>
        <td>
		<?php
			$sque=mysql_query("SELECT timestart, timefinish FROM mdl_cifaquiz_attempts WHERE userid='".$currentid."' AND quiz='".$scourses['quiz']."'");
			$query=mysql_fetch_array($sque);
			
			echo date('F jS, Y',$query['timestart']).'<br/>';
		?>		
		<?php //echo date('F jS, Y', strtotime('now')); ?></td>
        <td rowspan="7" style="vertical-align:top;">
        	<table>
            <tr>
                <td>
					<?php
$qrysup = "SELECT * FROM {$CFG->prefix}organization_type WHERE status='0' And (id='".$susers['orgtype']."' OR groupofinstitution='".$susers['orgtype']."')";					
$sup=mysql_query($qrysup);
						$snu=mysql_num_rows($sup);
						$s=mysql_fetch_array($sup);
					?>
					<?php //if($USER->picture!='0'){ ?>
					<img src="<?=$CFG->wwwroot.'/financialinstituition/'.$s['path_logo'];?>" width="200" />
					<?php //} ?>
				</td>
           </tr></table>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td><?=get_string('candidateid');?></td>
        </tr>
      <tr>
        <td><?=strtoupper($susers['traineeid']);?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Certificate ID:</td>
        </tr>
      <tr>
        <td valign="top"><?='IPD'.date('Y', strtotime('now')).'/'.strtoupper($susers['id']);?></td>
        </tr>
    </table></td>
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
  <tr>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td>&nbsp;</td>
    </tr> 
    <td><div style="font-size:10px"><?=get_string('certtext');?></div></td>
    </tr> 
  <tr>
    <td>&nbsp;</td>
    </tr>  
</table>

</td></tr></table></center>