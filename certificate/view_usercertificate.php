<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	include_once ('../pagingfunction.php');
	
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);

	$examid=$_GET['examid'];

	$cidosexam1 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'A'";
	$cidosexam2 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'B'";
	$cidosexam3 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'C'";

	$sgrade=mysql_query("SELECT *, a.grade as usergrade FROM mdl_cifaquiz_grades a, mdl_cifaquiz b WHERE a.quiz=b.id AND b.course='12' AND a.userid='116'");

	$exam1 = mysql_query($cidosexam1);
	$exam2 = mysql_query($cidosexam2);
	$exam3 = mysql_query($cidosexam3);

	$a = mysql_fetch_array($exam1);
	$b = mysql_fetch_array($exam2);
	$c = mysql_fetch_array($exam3);
	$qgrade=mysql_fetch_array($sgrade);
?>
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
<style type="text/css">
@media print {
input#btnPrint {
display: none;
}
}
table{
	font-family: Verdana,Geneva,sans-serif;
	font-size:0.95em;
}
input[type="submit"]{
	border:		2px solid #00C5FB;
	padding:		8px 10px !important;
	margin-bottom: 2px;
	font-size:		12px !important;
	background-color:	#FFFFFF;
	font-weight:		bold;
	color:			#000000;	
	cursor:pointer;
	border-radius: 5px;
	min-width: 80px;
}
</style><center>
<style type="text/css">
    img.table-bg-image {
        position: absolute;
        z-index: -1;
		width:650px;
		height:1042px;
    }
    table.with-bg-image, table.with-bg-image tr, table.with-bg-image td {
        background: transparent;
    }
</style>
<img class="table-bg-image" src="<?=$CFG->wwwroot;?>/image/statementbg1.jpg"/>
<table class="with-bg-image" height="1042px" border="0" cellspacing="0" cellpadding="10" width="1266px" style="padding:0px; margin:0px;" align="center"><tr><td style="vertical-align:top;">

<table width="100%" border="0"  style="padding:0px;">
  <tr valign="top">
    <td align="left">
	<table style="padding:0px; margin:0px; color:#666;">
	<tr><td>Tel: [+965] 22915580</td></tr>
	<tr><td>Fax: [+965] 22915580</td></tr>
	<tr><td>Website: learnCIFA.com</td></tr>
	<tr><td>P.O.Box 29916, Safat 13159,</td></tr>
	<tr><td>Kuwait City, Kuwait</td></tr></table>
	</td>
    <td align="right" style="width:50%"><img style="width:45%" src="<?=$CFG->wwwroot;?>/image/CIFALogo.png"></td>
  </tr>
</table>
<table><tr><td style="text-align:justify"><br/><br/>
<div class="demo" style="margin-bottom:1em;">
Date: <?=date('d-F-Y', strtotime('now')); ?>
</div>
<?php
	echo ucfirst($USER->address)."<br>";
	if($USER->address2!=''){
	echo ucfirst($USER->address2)."<br>";
	}
	if($USER->address3!=''){
	echo ucfirst($USER->address3)."<br>";
	}
	echo ucfirst($USER->city);
	echo "<br>";
	echo "<br>";
?>
<form action="#" method="post">
<input name="id" type="text" value="<?php echo $id;  ?>" hidden> 
<br>
<?php
	echo "Dear "; 
	echo ucfirst($USER->firstname.' '.$USER->lastname);
?>
<br><br>
<div style="margin-bottom:1em;">
Candidate ID: <strong><?=$USER->traineeid;?>A14116MY</strong>
</div>

<?php
	$s=mysql_query("SELECT * FROM mdl_cifaestatement WHERE id='3'");
	$ss=mysql_fetch_array($s);
	
	echo $ss['summary'];
?>

<table width="100%" border="0" style="border-collapse:collapse;margin:1em 0;">
  <tr>
    <td align="left" style="font-weight:bolder;width:50%;"> CIFATM Foundation Exam</td>
    <td align="center" style="font-weight:bolder;">97%</td>
  </tr>  
</table>

<?php	
	echo $ss['estatementsummary'];
?>

<br><br><br/>
Yours Sincerely,<br/>
<img src="../image/signiture.jpg" alt="" width="161" height="62"><br/>
<strong>Abdulkader Thomas</strong><br/>
CEO

</form></table>
</td></tr></table></center><br/>
<div style="text-align:center;">
	<form>
		<input type="submit" id="btnPrint" name="backbutton" onclick="this.form.action='<?=$CFG->wwwroot. '/index.php';?>'" value="Back" />
	</form>
</div><br/>


