<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	include_once ('../pagingfunction.php');
	
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	
	$site = get_site();

	$streditcifapolicy = 'Edit CIFAOnline Policy';
	$strvieweditcifapolicy = 'View CIFAOnline Policy';
	$PAGE->navbar->add($streditcifapolicy , new moodle_url('/cifapolicy/admin_cifapolicy_form.php?id=20'));
	$PAGE->navbar->add($strvieweditcifapolicy, new moodle_url('/cifapolicy/view_cifapolicy.php?id=20'));
	$title = "$site->shortname: $streditcifapolicy";
	$fullname = $site->fullname;
	$PAGE->set_pagelayout('buy_a_cifa');
	$PAGE->set_title($title);
	$PAGE->set_heading($fullname);

	echo $OUTPUT->header();
	// echo $OUTPUT->heading($strvieweditcifapolicy);	

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

<table style="width:100%"><tr><td style="text-align:justify">
<form action="#" method="post">
<?php
	if (isloggedin()) {
	$erules=get_string('erules');
	echo '<div style="width:100%; margin:1em auto;">';
	// echo '<h2>'.$erules.'</h2>';
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

<?php
	$erulessql=mysql_query("SELECT * FROM mdl_cifaexamrules WHERE id='20'");
	$erules=mysql_fetch_array($erulessql);
	echo $erules['summary'];  // policy content
?>
</div><?php }else{ echo '<div style="margin:2em auto"><h3>'.get_string('examrulesloggin').'</h3></div>'; } ?>
</td></tr></table></center>

<div style="text-align:center;">
	<input type="submit" id="backbutton" name="backbutton" onclick="this.form.action='<?=$CFG->wwwroot. '/cifapolicy/admin_cifapolicy_form.php?id=20';?>'" value="Back" />
</div></form><br/>
<?php
	echo $OUTPUT->footer();
?>
