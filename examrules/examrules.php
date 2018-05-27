<?php
	include('../config.php');
	include('../manualdbconfig.php');
	include ('../pagingfunction.php');
	
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);

	$examid=$_GET['examid'];

	$cidosexam1 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'A'";
	$cidosexam2 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'B'";
	$cidosexam3 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'C'";

	//to get list of financial
	$statement = mysql_query("
				Select
				  *
				From
				  mdl_cifastatement
				Where
					candidateid='".$USER->traineeid."' Order By candidateid, courseid ASC
	");	
?>

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
input[type="button"]{
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
		width:98%;
		height:1840px;
    }
    table.with-bg-image, table.with-bg-image tr, table.with-bg-image td {
        background: transparent;
    }
</style>
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

	<?php if (isloggedin()) { ?> 
<img class="table-bg-image" src="<?=$CFG->wwwroot;?>/image/statementbg_scroll.png"/>
<table class="with-bg-image"  border="0" cellspacing="0" cellpadding="10" style="width:98%;padding:0px; margin:1em;" align="center"><tr><td style="vertical-align:top;">

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


<form action="#" method="post">
<table style="width:100%; margin-top: 1.7em;"><tr><td style="text-align:justify">
<?php
	$erules=get_string('erules');
	echo '<div style="width:100%; margin:3.7em auto;">';
	echo $OUTPUT->heading($erules, 2, 'headingblock header');
?>
 

<?php
	$erulessql=mysql_query("SELECT * FROM mdl_cifaexamrules WHERE id='16'");
	$erules=mysql_fetch_array($erulessql);
	echo $erules['summary'];
?>
<p>For more information, please <a href="<?=$CFG->wwwroot .'/contactus/upload_index.php'?>" target="_blank"><u><strong>contact us</strong></u></a>.</p>
</div><?php }else{ echo '<div style="margin:2em auto"><h3>'.get_string('examrulesloggin').'</h3></div>'; } ?>

<!--div style="text-align:center; margin:0px;">
			<input type="button" id="btnPrint" onclick="window.print();" value="Print Page" />
</div-->
</td></tr></table>
</form>
</td></tr></table>